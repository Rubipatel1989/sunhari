<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CronController extends AppController
{


    public function roi(){
        
        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $roisTable = TableRegistry::get('Rois');
        $payoutsTable = TableRegistry::get('Payouts');
        $commissionsTable = TableRegistry::get('Commissions');

       $day = date('d');
       if(($day >= 1 && $day <= 7) || ($day >= 11 && $day <= 17) || ($day >= 21 && $day <= 27)){
            $conditions = array(
                                'Users.status' => 1
                            );
            $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

            if(!empty($users)){

            	$commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
                
                foreach($users as $user){
                    $query = $upgradesTable->find();
                    $upgrade = $query->select(['sum' => $query->func()->sum('roi_amount')])->where(['Upgrades.upgraded_id' => $user->id, 'Upgrades.expiry_date >=' => date('Y-m-d')])->first();
                    if(isset($upgrade->sum) && !empty($upgrade->sum)){
                        $roiInDollar = $upgrade->sum;

                        $roi_date = date('Y-m-d');
                       //$roi_date = '2018-06-03';
                        $checkRoi = $payoutsTable->find('all', array('conditions' => array('Payouts.upagraded_user_id' => $user->id, 'Payouts.direct_amount' => 0, 'Payouts.matching_amount' => 0, 'Payouts.royalty_amount' => 0, 'Payouts.roi >' => 0, 'Payouts.roi_date' => $roi_date)))->first();
                        if(empty($checkRoi)){
                            $payout = $payoutsTable->newEntity();
                            $payout->upagraded_user_id 	= $user->id;
                            $payout->roi 				= $roiInDollar;
                            $payout->tax 				= isset($commission->tax) ? $commission->tax : 0;
                            $payout->admin_commission 	= isset($commission->amount) ? $commission->amount : 0;
                            $payout->roi_date 			= $roi_date;
                            $payoutsTable->save($payout);
                        }
                    }
                }
            }
        }
    }

    public function matchingAmount(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $binariesTable = TableRegistry::get('Binaries');
        $commissionsTable = TableRegistry::get('Commissions');

        $conditions = array(
                            'Binaries.status' => 1
                        );
        $fields = array('Binaries.amount', 'Binaries.percentage');
        $binary = $binariesTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();

        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();

        $conditions =  array(
                                'Users.total_direct_acitve_left >' => 0,
                                'Users.total_direct_acitve_right >' => 0,
                            );
        $joins = array(
                    array(
                        'table' => 'upgrades',
                        'alias' => 'Upgrades',
                        'type' => 'INNER',
                        'conditions' => array('Upgrades.upgraded_id = Users.id')
                    )
                );

        $order = array();

        $group = array('Users.id');

        $fields = array('Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_id', 'Upgrades.package_amount');
        $users = $usersTable->find('all', array('fields' => $fields,  'join' => $joins, 'conditions' => $conditions, 'order' => $order, 'group' => $group))
                            //->select(['maxAmount' => '(SELECT u.package_amount FROM upgrades u WHERE (u.upgraded_id=Upgrades.package_id) ORDER BY id DESC LIMIT 0, 1)'])
                            ->select(['max_package_amount' => 'max(Upgrades.package_amount)'])
                            ->autoFields(true)
                            ->toArray();

        foreach($users as $user){

            $leftBusiness = $user->total_active_left - $user->total_direct_acitve_left;

            $rightBusiness = $user->total_active_right - $user->total_direct_acitve_right;

            $currentPair = $rightBusiness;
            if($leftBusiness < $rightBusiness){
                $currentPair = $leftBusiness;
            }

            $pendingPair = $currentPair - $user->previous_pair;

            $matchingAmount = ($pendingPair * $binary->percentage)/100;

            if($matchingAmount > $user->max_package_amount){
                $matchingAmount = $user->max_package_amount;
            }

            if($matchingAmount > 0){
                $date = date('Y-m-d');
                $checkUser = $payoutsTable->find('all', array('conditions' => array('Payouts.upagraded_user_id' => $user->id, 'Payouts.matching_amount >' => 0, 'DATE(Payouts.created)' => $date)))->count();

                if($checkUser == 0){
                    $payOutData = $payoutsTable->newEntity();
                    $payOutData->upagraded_user_id = $user->id;
                    $payOutData->matching_amount = $matchingAmount;
                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                    $payOutData->status = 0;

                    if($payoutsTable->save($payOutData)){
                        $userData = $usersTable->get($user->id);
                        $userData->previous_pair =  $user->previous_pair + $pendingPair;
                        $usersTable->save($userData);

                    }
                }
            }

        }

    }

    public function rewards(){

        //$this->viewBuilder()->setLayout('my_account');
        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');
        $achievedRewardsTable = TableRegistry::get('AchievedRewards');
        $this->makeGoldClub();
        $this->makePlatinumClub();
        $this->makeAmbrandClub();
        $this->makeDiamondClub();
        $this->makeKingClub();

       
        $conditions = array();

        $fields = array('Users.id');
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions))
                              ->select([
                                        'total_direct' => 'Users.direct_active_left_one + Users.direct_active_right_one',
                                        'total_days' => 'DATEDIFF(CURDATE(),Users.created)',
                                        'min_pair' => 'IF(Users.active_left_one < Users.active_right_one, Users.active_left_one, Users.active_right_one)'
                                    ])
                              ->toArray();

        foreach($users as $user){

            $conditions = array(
                                'AchievedRewards.user_id' =>  $user->id
                            );
            $achievedRewardInfo = $achievedRewardsTable->find('all', array('conditions' => $conditions))->first();

            if(!empty($achievedRewardInfo)){
                $achievedRewardData = $achievedRewardsTable->get($achievedRewardInfo->id);
            }else{
                $achievedRewardData = $achievedRewardsTable->newEntity();
            }

            $achievedRewardData->user_id = $user->id;
            if(($user->total_direct >= 8 && $user->total_days <= 130) || $user->total_direct >= 12){
                $achievedRewardData->is_direct_home_furniture = 1;
            }
            if(($user->total_direct >= 24 && $user->total_days <= 130) || $user->total_direct >= 36){
                $achievedRewardData->is_direct_bike = 1;
            }
            if(($user->total_direct >= 48 && $user->total_days <= 130) || $user->total_direct >= 72){
                $achievedRewardData->is_direct_kwid = 1;
            }
            if(($user->total_direct >= 93 && $user->total_days <= 270) || $user->total_direct >= 137){
                $achievedRewardData->is_direct_swift = 1;
            }
            if(($user->total_direct >= 164 && $user->total_days <= 390) || $user->total_direct >= 232){
                $achievedRewardData->is_direct_artica = 1;
            }
            if(($user->total_direct >= 259 && $user->total_days <= 490) || $user->total_direct >= 367){
                $achievedRewardData->is_direct_scorpio = 1;
            }
            if(($user->total_direct >= 401 && $user->total_days <= 590) || $user->total_direct >= 562){
                $achievedRewardData->is_direct_bmw = 1;
            }
            if(($user->total_direct >= 596 && $user->total_days <= 810) || $user->total_direct >= 837){
                $achievedRewardData->is_direct_audi = 1;
            }
            if(($user->min_pair >= 22 && $user->total_days <= 130) || $user->min_pair >= 72){
                $achievedRewardData->is_pair_home_furniture = 1;
            }
            if(($user->min_pair >= 94 && $user->total_days <= 130) || $user->min_pair >= 183){
                $achievedRewardData->is_pair_kwid = 1;
            }
            if(($user->min_pair >= 235 && $user->total_days <= 270) || $user->min_pair >= 408){
                $achievedRewardData->is_pair_swift = 1;
            }
            if(($user->min_pair >= 450 && $user->total_days <= 390) || $user->min_pair >= 753){
                $achievedRewardData->is_pair_artica = 1;
            }
            if(($user->min_pair >= 745 && $user->total_days <= 490) || $user->min_pair >= 1228){
                $achievedRewardData->is_pair_scorpio = 1;
            }
            if(($user->min_pair >= 1170 && $user->total_days <= 590) || $user->min_pair >= 2003){
                $achievedRewardData->is_pair_bmw = 1;
            }
            if(($user->min_pair >= 1745 && $user->total_days <= 810) || $user->min_pair >= 3054){
                $achievedRewardData->is_pair_audi = 1;
            }
            $achievedRewardData->modified = date("Y-m-d H:i:s");

            $achievedRewardsTable->save($achievedRewardData);

        }

       /* $this->makeGoldClub();
        $this->makePlatinumClub();
        $this->makeAmbrandClub();
        $this->makeDiamondClub();
        $this->makeKingClub();*/

    }

    public function makeGoldClub(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Users.is_mobile_club IS NULL'
                        );
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

        foreach($users as $user){

            $usersTable->makeGoldClub($user->id);

        }

    }

    public function makePlatinumClub(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Users.is_mobile_club' => 1
                        );
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

        foreach($users as $user){

            $usersTable->makePlatinumClub($user->id);

        }

    }

    public function makeAmbrandClub(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Users.is_laptop_club' => 1
                        );
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

        foreach($users as $user){

            $usersTable->makeAmbrandClub($user->id);

        }

    }

    public function makeDiamondClub(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Users.is_bike_club' => 1
                        );
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

        foreach($users as $user){

            $usersTable->makeDiamondClub($user->id);

        }

    }

    public function makeKingClub(){

        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Users.is_diamond_club' => 1
                        );
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();

        foreach($users as $user){

            $usersTable->makeKingClub($user->id);

        }

    }


}
