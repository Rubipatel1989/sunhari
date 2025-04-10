<?php
namespace App\Controller\Panelcontrol;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PaymentsController extends AppController
{

   

    public function singleCalculation(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Single Calculation';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');

        $users = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.status' => 1)))->autoFields(true)->toArray();
        $this->set('users', $users);

        $username =  isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';

        $conditions = array(
                            'Users.username' => $username
                        );
        $userInfo = $usersTable->find('all', array('conditions' => $conditions))->autoFields(true)->first();
        $this->set('userInfo', $userInfo);

        $binary  =  $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->autoFields(true)->first();
        $this->set('binary', $binary);

        $cashingAmount = [];
        if(!empty($userInfo)){
            $query = $upgradesTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $cashingAmount = $query->select(['sum' => $query->func()->sum('package_amount')])->where(['Upgrades.upgraded_id' => $userInfo->id, 'Upgrades.expiry_date >=' => date('Y-m-d')])->first();
        }
        $this->set('cashingAmount', $cashingAmount);

    }

    public function bulkCalculation(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Closing';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');
        $payoutsTable = TableRegistry::get('Payouts');
        $commissionsTable = TableRegistry::get('Commissions');
        $flushesTable = TableRegistry::get('Flushes');

        $conditions = array(
                            'Users.role_id' => 2, 
                            'Users.status !=' => 2
                        );
        $join = array(
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $fields = array('Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->toArray();
        $this->set('users', $users);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);
            //exit;
            if(isset($this->request->data['user_ids']) && !empty($this->request->data['user_ids'])){
                $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
                $binary = $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->first();
                if(isset($binary->type) && !empty($binary->type) && $binary->type == 1){
                    $multiplier = ($binary->percentage)/100;
                }else{
                    $multiplier = $binary->amount;
                }
                foreach($this->request->data['user_ids'] as $user_id){

                    $conditions = array(
                                    'Users.id' => $user_id,
                                    'Users.total_direct_acitve_left >' => 0,
                                    'Users.total_direct_acitve_right >' => 0,
                                    'Upgrades.expiry_date >=' => date('Y-m-d'),
                                  );
                    $join = array(
                                array(
                                    'table' => 'upgrades',
                                    'alias' => 'Upgrades',
                                    'type'  => 'INNER',
                                    'conditions' => array('Upgrades.upgraded_id = Users.id')
                                )
                            );
                    $group = array('Upgrades.upgraded_id');
                    $userInfo = $usersTable->find('all', array('conditions' => $conditions, 'join' => $join, 'group' => $group))->first();
                    
                    if(!empty($userInfo)){

                        $payout = $payoutsTable->newEntity();
                        $payout->upagraded_user_id  = $user_id;
                        $payout->matching_amount    = ($this->request->data['pending_pair'][$user_id] * $multiplier);
                        $payout->tax                = isset($commission->tax) ? $commission->tax : 0;
                        $payout->admin_commission   = isset($commission->amount) ? $commission->amount : 0;
                        $payout->royalty_amount     = 0;
                        $payoutsTable->save($payout);

                        $userData = $usersTable->get($userInfo->id);
                        $userData->previous_pair =  $userInfo->previous_pair + $this->request->data['pending_pair'][$user_id];
                        $usersTable->save($userData);
                    }else{
                        $conditions = array(
                                            'Users.id' => $user_id
                                        );
                        $userInfo = $usersTable->find('all', array('conditions' => $conditions))->first();
                        $flush = $flushesTable->newEntity();
                        $flush->user_id = $user_id;
                        $flush->matching_amount = ($this->request->data['pending_pair'][$user_id] * $multiplier);
                        $flush->status = 0;
                        $flushesTable->save($flush);

                        $userData = $usersTable->get($user_id);
                        $userData->previous_pair =  $userInfo->previous_pair + $this->request->data['pending_pair'][$user_id];
                        $usersTable->save($userData);
                    }

                    /*$conditions = array(
                                    'Users.id' => $user_id,
                                    'Upgrades.expiry_date >=' => date('Y-m-d'),
                                  );
                    $join = array(
                                array(
                                    'table' => 'upgrades',
                                    'alias' => 'Upgrades',
                                    'type'  => 'INNER',
                                    'conditions' => array('Upgrades.upgraded_id = Users.id')
                                )
                            );

                    $group = array('Upgrades.upgraded_id');
                    $userInfo = $usersTable->find('all', array('conditions' => $conditions, 'join' => $join, 'group' => $group))->first();
                    if(!empty($userInfo)){
                        $conditions = array(
                                            'Upgrades.expiry_date >=' => date('Y-m-d')
                                        );
                        $join = array(
                                    array(
                                        'table' => 'users',
                                        'alias' => 'Users',
                                        'type'  => 'INNER',
                                        'conditions' => array('Users.id = Upgrades.upgraded_id and Users.sponsor_id = "'.$user_id.'"')
                                    )
                                );
                        $group = array('Upgrades.upgraded_id');
                        $fields = array('Upgrades.upgraded_id');
                        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'group' => $group))->toArray();
                        if(!empty($upgrades)){
                            $distributedRoyaltyAmount = $this->request->data['royalty'][$user_id]/count($upgrades);
                            foreach ($upgrades as $upgrade) {
                                $payout = $payoutsTable->newEntity();
                                $payout->upagraded_user_id  = $upgrade->upgraded_id;
                                $payout->royalty_amount     = $distributedRoyaltyAmount;
                                $payoutsTable->save($payout);
                            }
                        }

                    }*/
                }
            }
            $this->Flash->success(__('Payment has been submitted successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'bulkCalculation', 'prefix' => $this->backend]);
        }
    }

    public function closing(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Payments Closing';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $binariesTable = TableRegistry::get('Binaries');
        $paymentsTable = TableRegistry::get('Payments');
        $payoutsTable = TableRegistry::get('Payouts');

        $binary  =  $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->autoFields(true)->first();
        $this->set('binary', $binary);

        $conn = ConnectionManager::get('default');

        $closings = $conn->execute("SELECT Users.id, Users.username, Users.closing_count, Details.first_name, Details.last_name, Details.pan_number,
            (SELECT SUM(dAmt.direct_amount) FROM payouts AS dAmt WHERE dAmt.upagraded_user_id=Users.id AND dAmt.status='0') AS direct_amount,
            (SELECT SUM(mAmt.matching_amount) FROM payouts AS mAmt WHERE mAmt.upagraded_user_id=Users.id AND mAmt.status='0') AS matching_amount,  
            (SELECT SUM(rAmt.royalty_amount) FROM payouts AS rAmt WHERE rAmt.upagraded_user_id=Users.id AND rAmt.status='0') AS royalty_amount,
            (SELECT SUM(roiAmt.roi) FROM payouts AS roiAmt WHERE roiAmt.upagraded_user_id=Users.id AND roiAmt.status='0') AS roi,
            
            (SELECT SUM((dcAmt.admin_commission * dcAmt.direct_amount)/100)FROM payouts AS dcAmt WHERE dcAmt.upagraded_user_id = Users.id AND dcAmt.direct_amount > '0' AND dcAmt.status='0') AS direct_admin_commission,
            
            (SELECT SUM((mcAmt.admin_commission * mcAmt.matching_amount)/100) FROM payouts AS mcAmt WHERE mcAmt.upagraded_user_id = Users.id AND mcAmt.matching_amount > '0' AND mcAmt.status='0') AS matching_admin_commission,
            
            (SELECT SUM((rcAmt.admin_commission * rcAmt.royalty_amount)/100) FROM payouts AS rcAmt WHERE rcAmt.upagraded_user_id = Users.id AND rcAmt.royalty_amount > '0' AND rcAmt.status='0') AS royalty_admin_commission,

            (SELECT SUM((roicAmt.admin_commission * roicAmt.roi)/100) FROM payouts AS roicAmt WHERE roicAmt.upagraded_user_id = Users.id AND roicAmt.roi > '0' AND roicAmt.status='0') AS roi_admin_commission,

            (SELECT SUM(Upgrades.package_amount)*10 FROM upgrades AS Upgrades WHERE Upgrades.upgraded_id = Users.id AND Upgrades.expiry_date >= '".date('Y-m-d')."') AS capping_amount

            FROM users AS Users 
            INNER JOIN payouts AS Payouts on Payouts.upagraded_user_id = Users.id
            INNER JOIN details AS Details on Details.user_id = Users.id
            WHERE Users.status = '1' AND Payouts.status = '0' GROUP BY Users.id");

        //echo '<pre>';
        //print_r($closings->fetchAll('assoc'));
        //exit;
        $this->set('closings', $closings->fetchAll('assoc'));

        if($this->request->is('post')){
            // '<pre>';
            //print_r($this->request->data);exit;
            if(isset($this->request->data['ids']) && !empty($this->request->data['ids'])){
                $paymentInfo = $paymentsTable->find('all', array('fields' => array('Payments.closing_count'), 'order' => array('Payments.id' => 'DESC'), 'limit' => 1))->first();
                $closing_count = 1;
                if(!empty($paymentInfo)){
                    $closing_count = $paymentInfo->closing_count + 1;
                }
                foreach($this->request->data['ids'] as $user_id){
                    $payment = $paymentsTable->newEntity();
                    $payment->user_id = $user_id;
                    $payment->btc_address = $this->request->data['btc_address'][$user_id];
                    $payment->direct_amount = $this->request->data['direct_amount'][$user_id];
                    $payment->matching_amount = $this->request->data['matching_amount'][$user_id];
                    //$payment->capping_amount = $this->request->data['capping_amount'][$user_id];
                    $payment->capping_amount = 0;
                    $payment->royalty_amount = $this->request->data['royalty_amount'][$user_id];
                    $payment->total = $this->request->data['total'][$user_id];
                    $payment->admin_commission = $this->request->data['admin_commission'][$user_id];
                    $payment->roi = $this->request->data['roi'][$user_id];
                    $payment->net_amount = $this->request->data['net_amount'][$user_id];
                    $payment->closing_count = $closing_count;
                    $paymentsTable->save($payment);

                    $userData = $usersTable->get($user_id);
                    $userData->closing_count = $this->request->data['closing_count'][$user_id];
                    $usersTable->save($userData);

                    $payoutsTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s")], ['Payouts.upagraded_user_id' => $user_id]);
                }
            }
            $this->Flash->success(__('Payment has been closed successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            //exit;
        }
    }

    public function closingDetails(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Closing Details';

        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');

        $conditions = array(
                            'Payments.requested_amount' => 0
                        );
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type'  => 'INNER',
                        'conditions' => array('Users.id = Payments.user_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type'  => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );

        $order = array(
                        'Payments.closing_count' => 'ASC'
                    );

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.last_name', 'Details.pan_number');
        $payments = $paymentsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'join' => $join))->autoFields(true)->toArray();

        $this->set('payments', $payments);

    }

    public function payoutRequest(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Payout Request';

        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');

        $join = array(
                        array(
                            'table' => 'users',
                            'alias' => 'Users',
                            'type' => 'INNER',
                            'conditions' => array('Users.id = Payments.user_id')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Payments.user_id')
                        )
                    );

        $conditions = array(
                            'Payments.requested_amount >' => 0
                        );

        $order = array('Payments.id' => 'DESC');

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.last_name', 'Details.pan_number');
        $payments = $paymentsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->autoFields(true)->toArray();

        $this->set('payments', $payments);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;
            if(isset($this->request->data['ids']) && !empty($this->request->data['ids']) && isset($this->request->data['Payment']['bulk_action']) && !empty($this->request->data['Payment']['bulk_action'])){
                foreach($this->request->data['ids'] as $id){
                    $payment = $paymentsTable->get($id);
                    $payment->transferred_to = 'bank';
                    $payment->status = $this->request->data['Payment']['bulk_action'];
                    $paymentsTable->save($payment);
                }
            }
            $this->Flash->success(__('Selected Payments request status has been changed successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'payoutRequest', 'prefix' => $this->backend]);
        }
    }

    public function roiAndRoyalty(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' ROI & Royalty';

        $this->set('title', $title);

        $upgradesTable = TableRegistry::get('Upgrades');
        $paymentsTable = TableRegistry::get('Payments');
        $commissionsTable = TableRegistry::get('Commissions');
        $payoutsTable = TableRegistry::get('Payouts');
        $usersTable = TableRegistry::get('Users');

        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();

        $months = $paymentsTable->getMonths();
        $this->set('months', $months);

        $join = array(
                        array(
                            'table' => 'packages',
                            'alias' => 'Packages',
                            'type' => 'INNER',
                            'conditions' => array('Packages.id = Upgrades.package_id')
                        )
                    );
        $conditions = array();
        $upgrades = $upgradesTable->find('all', array('join' => $join, 'conditions' => $conditions))
                                 ->select(['total_businnes_point' => 'SUM(Packages.business_point)'])->first();
        $this->set('upgrades', $upgrades);

        if($this->request->is('post')){
            echo '<pre>';
            print_r($this->request->data);
            exit;

            if(!empty($this->request->data['Payout']['month']) && !empty($this->request->data['Payout']['business_value']) && $this->request->data['Payout']['business_value'] > 0 && !empty($this->request->data['Payout']['percentage'])  && is_numeric($this->request->data['Payout']['percentage']) && !empty($this->request->data['Payout']['buiness_point'])){

                

                $bvPercentage = ($this->request->data['Payout']['business_value'] * $this->request->data['Payout']['percentage'])/100;
                $roi = $bvPercentage/$this->request->data['Payout']['buiness_point'];

                $joins = array(
                    array(
                        'table' => 'upgrades',
                        'alias' => 'Upgrades',
                        'type' => 'INNER',
                        'conditions' => array('Upgrades.upgraded_id = Users.id')
                    ),
                    array(
                        'table' => 'packages',
                        'alias' => 'Packages',
                        'type' => 'INNER',
                        'conditions' => array('Packages.id = Upgrades.package_id')
                    ),
                    array(
                        'table' => 'payouts',
                        'alias' => 'Payouts',
                        'type' => 'INNER',
                        'conditions' => array('Payouts.upagraded_user_id = Users.id')
                    )
                );

                $group = array('Users.id');

                $order = array();

                $fields = array('Users.id', 'Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_id', 'Upgrades.package_amount', 'Packages.id');

                $users = $usersTable->find('all', array('fields' => $fields,  'join' => $joins, 'conditions' => $conditions, 'order' => $order, 'group' => $group))
                                    ->select(['max_business_point' => 'max(Packages.business_point)', 'total_roi' => 'max(Payouts.roi)'])
                                    ->toArray();
                /*echo '<pre>';
                print_r($users);*/

                if(!empty($users)){
                    foreach($users as $user){

                        if(!empty($user)){
                            $conditions = array('Payouts.upagraded_user_id' => $user->id, 'Payouts.roi > ' => 0, 'MONTH(Payouts.created)' => $this->request->data['Payout']['month'], 'YEAR(Payouts.created)' => date('Y'));
                            $checkPayout = $payoutsTable->find('all', array('conditions' => $conditions))->count();
                            if($checkPayout == 0){
                               
                                if($user->total_roi < (2*$user->Upgrades['package_amount'])){
                                    $upagraded_user_id = $user->id;
                                    $payOutData = $payoutsTable->newEntity();
                                    $payOutData->upagraded_user_id = $upagraded_user_id;
                                    $payOutData->roi = $roi*$user->max_business_point;
                                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                    $payOutData->status = 0;
                                    $payoutsTable->save($payOutData);
                                }
                            }
                        }

                    }
                }
                $this->Flash->success(__('ROI & Roayalty has been added of selected months.'));
                return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            }else{
                $this->Flash->error(__('Please fill all required fields mark with asterisk (*).'));
            }
        }
    }

    public function matchingAmount(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Matching Amount';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $binariesTable = TableRegistry::get('Binaries');
        $commissionsTable = TableRegistry::get('Commissions');

        if($this->request->is('post')){
            //echo '<pre>';
           // print_r($this->request->data);
            //exit;

            $from_date = strtotime($this->request->data['Payout']['from_date']);
            $to_date = strtotime($this->request->data['Payout']['to_date']);
            $datediff = $to_date - $from_date;
            $totalDays = round($datediff / (60 * 60 * 24));
            
            if($totalDays > 0){

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
                            $payOutData->matching_amount = $matchingAmount*$totalDays;
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
                $this->Flash->success(__('Matching amount has been added from '.$this->request->data['Payout']['from_date'].' to '.$this->request->data['Payout']['to_date']));
                return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);

            }else{
                $this->Flash->error(__('To date should be more than from date'));
            }

        }
    }
}
