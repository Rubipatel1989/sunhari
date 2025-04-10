<?php
namespace App\Controller\Mlmcontrol;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;
use Cake\Datasource\ConnectionManager;

class PaymentsController extends AppController {

    public function singleCalculation() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Single Calculation';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');
        $users = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.status' => 1)))->enableAutoFields(true)->toArray();
        $this->set('users', $users);
        $username = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
        $conditions = array('Users.username' => $username);
        $userInfo = $usersTable->find('all', array('conditions' => $conditions))->enableAutoFields(true)->first();
        $this->set('userInfo', $userInfo);
        $binary = $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->enableAutoFields(true)->first();
        $this->set('binary', $binary);
        $cashingAmount = [];
        if (!empty($userInfo)) {
            $query = $upgradesTable->find();
            $query->select(['count' => $query->func()->count('*') ]);
            $cashingAmount = $query->select(['sum' => $query->func()->sum('package_amount') ])->where(['Upgrades.upgraded_id' => $userInfo->id, 'Upgrades.expiry_date >=' => date('Y-m-d') ])->first();
        }
        $this->set('cashingAmount', $cashingAmount);
    }

    public function bulkCalculation() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Closing';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');
        $payoutsTable = TableRegistry::get('Payouts');
        $commissionsTable = TableRegistry::get('Commissions');
        $flushesTable = TableRegistry::get('Flushes');
        $conditions = array('Users.role_id' => 2, 'Users.status !=' => 2);
        $join = array(array('table' => 'details', 'alias' => 'Details', 'type' => 'INNER', 'conditions' => array('Details.user_id = Users.id')));
        $fields = array('Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->toArray();
        $this->set('users', $users);
        if ($this->request->is('post')) {
            //echo '<pre>';
            //print_r($this->request->getData());
            //exit;
            if (isset($this->request->getData()['user_ids']) && !empty($this->request->getData()['user_ids'])) {
                $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
                $binary = $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->first();
                if (isset($binary->type) && !empty($binary->type) && $binary->type == 1) {
                    $multiplier = ($binary->percentage) / 100;
                } else {
                    $multiplier = $binary->amount;
                }
                foreach ($this->request->getData()['user_ids'] as $user_id) {
                    $conditions = array('Users.id' => $user_id, 'Users.total_direct_acitve_left >' => 0, 'Users.total_direct_acitve_right >' => 0, 'Upgrades.expiry_date >=' => date('Y-m-d'),);
                    $join = array(array('table' => 'upgrades', 'alias' => 'Upgrades', 'type' => 'INNER', 'conditions' => array('Upgrades.upgraded_id = Users.id')));
                    $group = array('Upgrades.upgraded_id');
                    $userInfo = $usersTable->find('all', array('conditions' => $conditions, 'join' => $join, 'group' => $group))->first();
                    if (!empty($userInfo)) {
                        $payout = $payoutsTable->newEmptyEntity();
                        $payout->upagraded_user_id = $user_id;
                        $payout->matching_amount = ($this->request->getData()['pending_pair'][$user_id] * $multiplier);
                        $payout->tax = isset($commission->tax) ? $commission->tax : 0;
                        $payout->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                        $payout->royalty_amount = 0;
                        $payoutsTable->save($payout);
                        $userData = $usersTable->get($userInfo->id);
                        $userData->previous_pair = $userInfo->previous_pair + $this->request->getData()['pending_pair'][$user_id];
                        $usersTable->save($userData);
                    } else {
                        $conditions = array('Users.id' => $user_id);
                        $userInfo = $usersTable->find('all', array('conditions' => $conditions))->first();
                        $flush = $flushesTable->newEmptyEntity();
                        $flush->user_id = $user_id;
                        $flush->matching_amount = ($this->request->getData()['pending_pair'][$user_id] * $multiplier);
                        $flush->status = 0;
                        $flushesTable->save($flush);
                        $userData = $usersTable->get($user_id);
                        $userData->previous_pair = $userInfo->previous_pair + $this->request->getData()['pending_pair'][$user_id];
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
                    
                            $distributedRoyaltyAmount = $this->request->getData()['royalty'][$user_id]/count($upgrades);
                    
                            foreach ($upgrades as $upgrade) {
                    
                                $payout = $payoutsTable->newEmptyEntity();
                    
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

    public function postIncomes() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Post Incomes';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $postIncomesTable = TableRegistry::get('PostIncomes');
        $join = array(array('table' => 'plot_payments', 'alias' => 'plotPayments', 'type' => 'INNER', 'conditions' => array('plotPayments.user_id = Upgrades.upgraded_id AND plotPayments.number_of_unit > 0')));
        $conditions = array('Upgrades.status' => 0,
        //'Upgrades.package_amount >=' => 21000
        );
        $upgradeInfo = $upgradesTable->find('all', array('join' => $join, 'conditions' => $conditions))->select(['total_units' => 'SUM(plotPayments.number_of_unit)', 'total_upgraded' => 'COUNT(Upgrades.id)'])->first();
        /* echo '<pre>';
        
        print_r($upgradeInfo);exit;*/
        $totalUpgrades = 0;
        if (isset($upgradeInfo->total_upgraded) && !empty($upgradeInfo->total_upgraded)) {
            $totalUpgrades = $upgradeInfo->total_units;
        }
        $gold = 0;
        $platinum = 0;
        $ambrand = 0;
        $diamond = 0;
        $king = 0;
        if ($totalUpgrades > 0) {
            $gold = $totalUpgrades * 2500;
            $platinum = $totalUpgrades * 2000;
            $ambrand = $totalUpgrades * 1500;
            $diamond = $totalUpgrades * 1000;
            $king = $totalUpgrades * 500;
        }
        $this->set('totalUpgrades', $totalUpgrades);
        $this->set('gold', $gold);
        $this->set('platinum', $platinum);
        $this->set('ambrand', $ambrand);
        $this->set('diamond', $diamond);
        $this->set('king', $king);
        if ($this->request->is('post')) {
            /* echo '<pre>';
            
            print_r($this->request->getData());
            
            exit;*/
            if (isset($this->request->getData()['btn_save_post_income'])) {
                if ($totalUpgrades > 0) {
                    $postIncomeData = $postIncomesTable->newEmptyEntity();
                    $postIncomeData->number_of_upgraded_users = $totalUpgrades;
                    $postIncomeData->gold = $gold;
                    $postIncomeData->platinum = $platinum;
                    $postIncomeData->ambrand = $ambrand;
                    $postIncomeData->diamond = $diamond;
                    $postIncomeData->king = $king;
                    if ($postIncomesTable->save($postIncomeData)) {
                        $upgradesTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s") ], ['status' => 0, 'package_amount >=' => 21000]);
                        $this->Flash->success(__('Post Incomes has been saved successfully.'));
                        return $this->redirect($this->backend_url . '/payments/post-incomes');
                    }
                }
            }
        }
    }

    public function savedPostIncomes() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Saved Post Incomes';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $postIncomesTable = TableRegistry::get('PostIncomes');
        $conditions = array();
        $order = array('PostIncomes.id' => 'DESC');
        $postIncomes = $postIncomesTable->find('all', array('conditions' => $conditions, 'order' => $order))->toArray();
        $this->set('postIncomes', $postIncomes);
    }

    public function payPostIncome($intPostIncomeId) {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Pay Post Income';
        $this->set('title', $title);
        $this->render(false);
        $usersTable = TableRegistry::get('Users');
        $postIncomesTable = TableRegistry::get('PostIncomes');
        $commissionsTable = TableRegistry::get('Commissions');
        $payoutsTable = TableRegistry::get('Payouts');
        $conditions = array('PostIncomes.id' => $intPostIncomeId);
        $postIncomeInfo = $postIncomesTable->find('all', array('conditions' => $conditions))->first();
        if (!empty($postIncomeInfo)) {
            $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->enableAutoFields(true)->first();
            $conditions = array('Users.is_mobile_club' => 1);
            $totalGoldUsers = $usersTable->find('all', array('conditions' => $conditions))->count();
            $conditions = array('Users.is_laptop_club' => 1);
            $totalPlatinumUsers = $usersTable->find('all', array('conditions' => $conditions))->count();
            $conditions = array('Users.is_bike_club' => 1);
            $totalAmbrandUsers = $usersTable->find('all', array('conditions' => $conditions))->count();
            $conditions = array('Users.is_diamond_club' => 1);
            $totalDiamondUsers = $usersTable->find('all', array('conditions' => $conditions))->count();
            $conditions = array('Users.is_king_club' => 1);
            $totalKingUsers = $usersTable->find('all', array('conditions' => $conditions))->count();
            $remainingGoldUsers = $totalGoldUsers - $totalPlatinumUsers;
            $remainingPlatinumUsers = $totalPlatinumUsers - $totalAmbrandUsers;
            $remainingAmbrandUsers = $totalAmbrandUsers - $totalDiamondUsers;
            $remainingDiamondUsers = $totalDiamondUsers - $totalKingUsers;
            $remainingKingUsers = $totalKingUsers;
            $goldAmount = !empty($remainingGoldUsers) ? $postIncomeInfo->gold / $remainingGoldUsers : 0;
            $platinumAmount = !empty($remainingPlatinumUsers) ? $postIncomeInfo->platinum / $remainingPlatinumUsers : 0;
            $ambrandAmount = !empty($remainingAmbrandUsers) ? $postIncomeInfo->ambrand / $remainingAmbrandUsers : 0;
            $diamondAmount = !empty($remainingDiamondUsers) ? $postIncomeInfo->diamond / $remainingDiamondUsers : 0;
            $kingAmount = !empty($remainingKingUsers) ? $postIncomeInfo->king / $remainingKingUsers : 0;
            if ($goldAmount > 0) {
                $conditions = array('Users.is_mobile_club' => 1, 'Users.is_laptop_club IS NULL');
                $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
                foreach ($users as $userInfo) {
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->mobile_club_amount = $goldAmount;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 5;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 5;
                    $payoutsTable->save($payout);
                }
            }
            if ($platinumAmount > 0) {
                $conditions = array('Users.is_laptop_club' => 1, 'Users.is_bike_club IS NULL');
                $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
                foreach ($users as $userInfo) {
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->laptop_club_amount = $platinumAmount;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 5;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 5;
                    $payoutsTable->save($payout);
                }
            }
            if ($ambrandAmount > 0) {
                $conditions = array('Users.is_bike_club' => 1, 'Users.is_diamond_club IS NULL');
                $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
                foreach ($users as $userInfo) {
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->bike_club_amount = $ambrandAmount;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 5;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 5;
                    $payoutsTable->save($payout);
                }
            }
            if ($diamondAmount > 0) {
                $conditions = array('Users.is_diamond_club' => 1, 'Users.is_king_club IS NULL');
                $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
                foreach ($users as $userInfo) {
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->diamond_club_amount = $diamondAmount;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 5;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 5;
                    $payoutsTable->save($payout);
                }
            }
            if ($kingAmount > 0) {
                $conditions = array('Users.is_king_club' => 1);
                $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
                foreach ($users as $userInfo) {
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->king_club_amount = $kingAmount;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 5;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 5;
                    $payoutsTable->save($payout);
                }
            }
            $postIncomeData = $postIncomesTable->get($postIncomeInfo->id);
            $postIncomeData->status = 1;
            $postIncomesTable->save($postIncomeData);
        }
        $this->Flash->success(__('Payment has been done successfully.'));
        return $this->redirect($this->backend_url . '/payments/saved-post-incomes');
        //exit;
        
    }

    public function closing() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Payments Closing';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $detailsTable = TableRegistry::get('Details');
        $binariesTable = TableRegistry::get('Binaries');
        $paymentsTable = TableRegistry::get('Payments');
        $payoutsTable = TableRegistry::get('Payouts');
        $binary = $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->enableAutoFields(true)->first();
        $this->set('binary', $binary);
        /*echo '<pre>';
        
        print_r($binary);
        
        exit;*/
        $conn = ConnectionManager::get('default');
        /*$closings = $conn->execute("SELECT Users.id, Users.username, Users.closing_count, Details.first_name, Details.last_name, Details.pan_number,
        
            (SELECT SUM(dAmt.direct_amount) FROM payouts AS dAmt WHERE dAmt.upagraded_user_id=Users.id AND dAmt.status='0') AS direct_amount,
        
            (SELECT SUM(mAmt.matching_amount) FROM payouts AS mAmt WHERE mAmt.upagraded_user_id=Users.id AND mAmt.status='0') AS matching_amount
        
            FROM users AS Users 
        
            INNER JOIN payouts AS Payouts on Payouts.upagraded_user_id = Users.id
        
            INNER JOIN details AS Details on Details.user_id = Users.id
        
            WHERE Users.status = '1' AND Payouts.status = '0' GROUP BY Users.id");*/
        $closings = $conn->execute("SELECT Users.id, Users.username, Users.total_direct_acitve_left, Users.total_direct_acitve_right, Users.total_active_left, Users.total_active_right, Users.previous_pair, Users.closing_count, Details.first_name, Details.last_name, Details.pan_number,

            (SELECT SUM(dAmt.direct_amount) FROM payouts AS dAmt WHERE dAmt.upagraded_user_id=Users.id AND dAmt.status='0') AS direct_amount,

            (SELECT SUM(p.mobile_club_amount) FROM payouts AS p WHERE p.upagraded_user_id=Users.id AND p.status='0') AS mobile_club_amount,



            (SELECT SUM(p.laptop_club_amount) FROM payouts AS p WHERE p.upagraded_user_id=Users.id AND p.status='0') AS laptop_club_amount,



            (SELECT SUM(p.bike_club_amount) FROM payouts AS p WHERE p.upagraded_user_id=Users.id AND p.status='0') AS bike_club_amount,



            (SELECT SUM(p.diamond_club_amount) FROM payouts AS p WHERE p.upagraded_user_id=Users.id AND p.status='0') AS diamond_club_amount,



            (SELECT SUM(p.king_club_amount) FROM payouts AS p WHERE p.upagraded_user_id=Users.id AND p.status='0') AS king_club_amount



            FROM users AS Users 

            INNER JOIN payouts AS Payouts on Payouts.upagraded_user_id = Users.id

            INNER JOIN details AS Details on Details.user_id = Users.id

            WHERE Payouts.status = '0' OR ((Users.total_direct_acitve_left > 0  AND Users.total_direct_acitve_right > 0) AND (IF(Users.total_active_left < Users.total_active_right, Users.total_active_left, Users.total_active_right) - Users.previous_pair) > 0)  GROUP BY Users.id");
        /*echo '<pre>';
        
        print_r($closings->fetchAll('assoc'));
        
        exit;*/
        $this->set('closings', $closings->fetchAll('assoc'));
        if ($this->request->is('post')) {
            /*echo '<pre>';
            
            print_r($this->request->getData());exit; */
            if (isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids'])) {
                $paymentInfo = $paymentsTable->find('all', array('fields' => array('Payments.closing_count'), 'order' => array('Payments.closing_count' => 'DESC'), 'limit' => 1))->first();
                $closing_count = 1;
                if (!empty($paymentInfo)) {
                    $closing_count = $paymentInfo->closing_count + 1;
                }
                foreach ($this->request->getData()['ids'] as $user_id) {
                    if (isset($this->request->getData()['net_amount'][$user_id]) && $this->request->getData()['net_amount'][$user_id] > 0) {
                        $payment = $paymentsTable->newEmptyEntity();
                        $payment->user_id = $user_id;
                        $payment->btc_address = $this->request->getData()['btc_address'][$user_id];
                        $payment->direct_amount = isset($this->request->getData()['direct_amount'][$user_id]) ? $this->request->getData()['direct_amount'][$user_id] : 0;
                        $payment->matching_amount = isset($this->request->getData()['matching_amount'][$user_id]) ? $this->request->getData()['matching_amount'][$user_id] : 0;
                        $payment->capping_amount = $this->request->getData()['capping_amount'][$user_id];
                        $payment->royalty_amount = isset($this->request->getData()['royalty_amount'][$user_id]) ? $this->request->getData()['royalty_amount'][$user_id] : 0;
                        $payment->total = isset($this->request->getData()['total'][$user_id]) ? $this->request->getData()['total'][$user_id] : 0;
                        $payment->admin_commission = isset($this->request->getData()['admin_commission'][$user_id]) ? $this->request->getData()['admin_commission'][$user_id] : 0;
                        $payment->tax = isset($this->request->getData()['tax'][$user_id]) ? $this->request->getData()['tax'][$user_id] : 0;
                        $payment->roi = isset($this->request->getData()['roi'][$user_id]) ? $this->request->getData()['roi'][$user_id] : 0;
                        $payment->level_income = isset($this->request->getData()['level_income'][$user_id]) ? $this->request->getData()['level_income'][$user_id] : 0;
                        $payment->mobile_club_amount = isset($this->request->getData()['mobile_club_amount'][$user_id]) ? $this->request->getData()['mobile_club_amount'][$user_id] : 0;
                        $payment->laptop_club_amount = isset($this->request->getData()['laptop_club_amount'][$user_id]) ? $this->request->getData()['laptop_club_amount'][$user_id] : 0;
                        $payment->bike_club_amount = isset($this->request->getData()['bike_club_amount'][$user_id]) ? $this->request->getData()['bike_club_amount'][$user_id] : 0;
                        $payment->diamond_club_amount = isset($this->request->getData()['diamond_club_amount'][$user_id]) ? $this->request->getData()['diamond_club_amount'][$user_id] : 0;
                        $payment->king_club_amount = isset($this->request->getData()['king_club_amount'][$user_id]) ? $this->request->getData()['king_club_amount'][$user_id] : 0;
                        $payment->net_amount = isset($this->request->getData()['net_amount'][$user_id]) ? $this->request->getData()['net_amount'][$user_id] : 0;
                        $payment->closing_count = $closing_count;
                        $userdetailsInfo = $detailsTable->find('all', array('conditions' => array('Details.user_id' => $user_id)))->first();
                        $payment->pan_number = $userdetailsInfo->pan_number;
                        $payment->account_number = $userdetailsInfo->account_number;
                        $payment->bank_name = $userdetailsInfo->bank_name;
                        $payment->branch_name = $userdetailsInfo->branch_name;
                        $payment->ifsc_code = $userdetailsInfo->ifsc_code;
                        //echo"<pre>";print_r($payment);exit;
                        $paymentsTable->save($payment);
                        $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id)))->first();
                        $userData = $usersTable->get($user_id);
                        $userData->previous_pair = $userInfo->previous_pair + $this->request->getData()['sub_min_amount'][$user_id];
                        $userData->closing_count = $this->request->getData()['closing_count'][$user_id];
                        $usersTable->save($userData);
                        /* $template = "Congratulations Ram Lal(JKS09876), Your payment of Rs 10000 is in the process. For help, please visit Jsksinfratech.com";
                        
                        
                        
                        $sendSMS = $usersTable->sendSMS($template, $userData->Details['contact_no']);*/
                        $payoutsTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s") ], ['Payouts.upagraded_user_id' => $user_id]);
                    }
                }
            }
            $this->Flash->success(__('Payment has been closed successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            //exit;
            
        }
    }
    
    public function closingDetails() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Closing Details';
        $this->set('title', $title);
        $paymentsTable = TableRegistry::get('Payments');
        $closingCount = isset($_GET['closing_count']) && !empty($_GET['closing_count']) && is_numeric($_GET['closing_count']) ? trim($_GET['closing_count']) : '';
        $this->set('closing_count', $closingCount);
        $conditions = array('Payments.requested_amount' => 0);
        if (!empty($closingCount)) {
            $conditions = array('Payments.closing_count' => $closingCount, 'Payments.requested_amount' => 0);
        }
        $join = array(array('table' => 'users', 'alias' => 'Users', 'type' => 'INNER', 'conditions' => array('Users.id = Payments.user_id')), array('table' => 'details', 'alias' => 'Details', 'type' => 'INNER', 'conditions' => array('Details.user_id = Users.id')));
        $order = array('Payments.closing_count' => 'ASC');
        // $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.last_name', 'Details.occupation', 'Details.account_number', 'Details.bank_name', 'Details.branch_name', 'Details.pan_number','Details.ifsc_code');
        $fields = array('Users.id', 'Users.username', 'Users.username', 'Details.first_name');
        $payments = array();
        if (!empty($closingCount)) {
            $payments = $paymentsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();
        }
        //echo"<pre>";print_r($payments);exit;
        $this->set('payments', $payments);
        $fields = array('Payments.closing_count');
        $group = array('Payments.closing_count');
        $order = array('Payments.closing_count' => 'ASC');
        $closingCounts = $paymentsTable->find('all', array('fields' => $fields, 'group' => $group, 'order' => $order))->toArray();
        //$closingCounts = $paymentsTable->find('all', array('fields' => $fields, 'group' => $group, 'order' => $order))->Sql();
        $this->set('closingCounts', $closingCounts);
    }
    public function closingDetailsIdwise() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Id Wise Closing Detail';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $paymentsTable = TableRegistry::get('Payments');
        $join = array(array('table' => 'details', 'alias' => 'Details', 'type' => 'INNER', 'conditions' => array('Details.user_id = Users.id')));
        $fields = array('Details.id', 'Details.first_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => array('Users.role_id' => 2)))->enableAutoFields(true)->toArray();
        $this->set('users', $users);
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Closing Details';
        $this->set('title', $title);
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Closing Details ID Wise';
        $this->set('title', $title);
        $paymentsTable = TableRegistry::get('Payments');
        $user_id = '';
        if (isset($_GET['username'])) {
            $username = $_GET['username'];
            $userInfo = $usersTable->find('all', array('conditions' => array('Users.username' => $username)))->enableAutoFields(true)->first();
            if (!empty($userInfo)) {
                $user_id = $userInfo->id;
            }
        }
        $this->set('user_id', $user_id);
        $conditions = array('Payments.requested_amount' => 0);
        if (!empty($user_id)) {
            $conditions = array('Payments.user_id' => $user_id, 'Payments.requested_amount' => 0);
        }
        $join = array(array('table' => 'users', 'alias' => 'Users', 'type' => 'INNER', 'conditions' => array('Users.id = Payments.user_id')), array('table' => 'details', 'alias' => 'Details', 'type' => 'INNER', 'conditions' => array('Details.user_id = Users.id')));
        $order = array('Payments.user_id' => 'ASC');
        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.last_name', 'Details.occupation', 'Details.account_number', 'Details.bank_name', 'Details.branch_name', 'Details.pan_number', 'Details.ifsc_code');
        $payments = array();
        if (!empty($user_id)) {
            $payments = $paymentsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'join' => $join))->enableAutoFields(true)->toArray();
        }
        $this->set('payments', $payments);
        $fields = array('Payments.user_id');
        $group = array('Payments.user_id');
        $order = array('Payments.user_id' => 'ASC');
        $closingCounts = $paymentsTable->find('all', array('fields' => $fields, 'group' => $group, 'order' => $order))->toArray();
        //$closingCounts = $paymentsTable->find('all', array('fields' => $fields, 'group' => $group, 'order' => $order))->Sql();
        $this->set('closingCounts', $closingCounts);
    }
    public function payoutRequest() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Payout Request';
        $this->set('title', $title);
        $paymentsTable = TableRegistry::get('Payments');
        $join = array(array('table' => 'users', 'alias' => 'Users', 'type' => 'INNER', 'conditions' => array('Users.id = Payments.user_id')), array('table' => 'details', 'alias' => 'Details', 'type' => 'INNER', 'conditions' => array('Details.user_id = Payments.user_id')));
        $conditions = array('Payments.requested_amount >' => 0);
        $order = array('Payments.id' => 'DESC');
        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.last_name', 'Details.pan_number');
        $payments = $paymentsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();
        $this->set('payments', $payments);
        if ($this->request->is('post')) {
            //echo '<pre>';
            //print_r($this->request->getData());exit;
            if (isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids']) && isset($this->request->getData()['Payment']['bulk_action']) && !empty($this->request->getData()['Payment']['bulk_action'])) {
                foreach ($this->request->getData()['ids'] as $id) {
                    $payment = $paymentsTable->get($id);
                    $payment->transferred_to = 'bank';
                    $payment->status = $this->request->getData()['Payment']['bulk_action'];
                    $paymentsTable->save($payment);
                }
            }
            $this->Flash->success(__('Selected Payments request status has been changed successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'payoutRequest', 'prefix' => $this->backend]);
        }
    }
    public function roiAndRoyalty() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' ROI & Royalty';
        $this->set('title', $title);
        $upgradesTable = TableRegistry::get('Upgrades');
        $paymentsTable = TableRegistry::get('Payments');
        $commissionsTable = TableRegistry::get('Commissions');
        $payoutsTable = TableRegistry::get('Payouts');
        $usersTable = TableRegistry::get('Users');
        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
        $months = $paymentsTable->getMonths();
        $this->set('months', $months);
        $join = array(array('table' => 'packages', 'alias' => 'Packages', 'type' => 'INNER', 'conditions' => array('Packages.id = Upgrades.package_id')));
        $conditions = array();
        $upgrades = $upgradesTable->find('all', array('join' => $join, 'conditions' => $conditions))->select(['total_businnes_point' => 'SUM(Packages.business_point)'])->first();
        $this->set('upgrades', $upgrades);
        if ($this->request->is('post')) {
            //echo '<pre>';
            //print_r($this->request->getData());
            //exit;
            if (!empty($this->request->getData()['Payout']['month']) && !empty($this->request->getData()['Payout']['business_value']) && $this->request->getData()['Payout']['business_value'] > 0 && !empty($this->request->getData()['Payout']['percentage']) && is_numeric($this->request->getData()['Payout']['percentage']) && !empty($this->request->getData()['Payout']['buiness_point']) && !empty($this->request->getData()['Payout']['above_50_lakhs']) && !empty($this->request->getData()['Payout']['above_2_crore']) && !empty($this->request->getData()['Payout']['above_5_crore']) && !empty($this->request->getData()['Payout']['above_10_crore']) && !empty($this->request->getData()['Payout']['above_25_crore']) && !empty($this->request->getData()['Payout']['above_50_crore'])) {
                $bvPercentage = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['percentage']) / 100;
                $roi = $bvPercentage / $this->request->getData()['Payout']['buiness_point'];
                $joins = array(array('table' => 'upgrades', 'alias' => 'Upgrades', 'type' => 'INNER', 'conditions' => array('Upgrades.upgraded_id = Users.id AND MONTH(Upgrades.created) <= "' . $this->request->getData()['Payout']['month'] . '" AND YEAR(Upgrades.created) <= "' . date('Y') . '"')), array('table' => 'packages', 'alias' => 'Packages', 'type' => 'INNER', 'conditions' => array('Packages.id = Upgrades.package_id')), array('table' => 'payouts', 'alias' => 'Payouts', 'type' => 'LEFT', 'conditions' => array('Payouts.upagraded_user_id = Users.id')));
                $group = array('Users.id');
                $order = array('Upgrades.created' => 'ASC');
                $fields = array('Users.id', 'Users.total_active_left', 'Users.total_active_right', 'Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_id', 'Upgrades.package_amount', 'Upgrades.created', 'Packages.id');
                $users = $usersTable->find('all', array('fields' => $fields, 'join' => $joins, 'conditions' => $conditions, 'order' => $order, 'group' => $group))->select(['max_business_point' => 'max(Packages.business_point)', 'total_roi' => 'max(Payouts.roi)', 'total_above_50_lakhs_users' => '(SELECT COUNT(u50L.id) FROM users u50L WHERE IF(u50L.total_active_left<u50L.total_active_right, u50L.total_active_left, u50L.total_active_right) BETWEEN 5000000 AND 20000000)', 'total_above_2_corore_users' => '(SELECT COUNT(u2C.id) FROM users u2C WHERE IF(u2C.total_active_left<u2C.total_active_right, u2C.total_active_left, u2C.total_active_right) BETWEEN 20000000 AND 50000000)', 'total_above_5_corore_users' => '(SELECT COUNT(u5C.id) FROM users u5C WHERE IF(u5C.total_active_left<u5C.total_active_right, u5C.total_active_left, u5C.total_active_right) BETWEEN 50000000 AND 100000000)', 'total_above_10_corore_users' => '(SELECT COUNT(u10C.id) FROM users u10C WHERE IF(u10C.total_active_left<u10C.total_active_right, u10C.total_active_left, u10C.total_active_right) BETWEEN 100000000 AND 250000000)', 'total_above_25_corore_users' => '(SELECT COUNT(u25C.id) FROM users u25C WHERE IF(u25C.total_active_left<u25C.total_active_right, u25C.total_active_left, u25C.total_active_right) BETWEEN 250000000 AND 500000000)', 'total_above_50_corore_users' => '(SELECT COUNT(u50C.id) FROM users u50C WHERE IF(u50C.total_active_left<u50C.total_active_right, u50C.total_active_left, u50C.total_active_right) > 500000000)'])->toArray();
                if (!empty($users)) {
                    foreach ($users as $user) {
                        if (!empty($user)) {
                            $conditions = array('Payouts.upagraded_user_id' => $user->id, 'Payouts.roi > ' => 0, 'MONTH(Payouts.created)' => $this->request->getData()['Payout']['month'], 'YEAR(Payouts.created)' => date('Y'));
                            $checkPayout = $payoutsTable->find('all', array('conditions' => $conditions))->count();
                            if ($checkPayout == 0) {
                                if ($user->total_roi < (2 * $user->Upgrades['package_amount'])) {
                                    $upagraded_user_id = $user->id;
                                    $payOutData = $payoutsTable->newEmptyEntity();
                                    $payOutData->upagraded_user_id = $upagraded_user_id;
                                    $payOutData->roi = $roi * $user->max_business_point;
                                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                    $payOutData->status = 0;
                                    $payoutsTable->save($payOutData);
                                }
                            }
                            //Adding Royalty Amount Start Here
                            $mAPercentage50LakhsAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_50_lakhs']) / 100;
                            $mAPercentage2CroreAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_2_crore']) / 100;
                            $mAPercentage5CroreAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_5_crore']) / 100;
                            $mAPercentage10CroreAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_10_crore']) / 100;
                            $mAPercentage25CroreAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_25_crore']) / 100;
                            $mAPercentage50CroreAbove = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['above_50_crore']) / 100;
                            $minAactiveAmount = $user->total_active_right;
                            if ($user->total_active_left < $user->total_active_right) {
                                $minAactiveAmount = $user->total_active_left;
                            }
                            $royaltyAmount = 0;
                            if ($minAactiveAmount >= 5000000 && $minAactiveAmount < 20000000) {
                                if ($user->total_above_50_lakhs_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_50_lakhs_users;
                                }
                            } elseif ($minAactiveAmount >= 20000000 && $minAactiveAmount < 50000000) {
                                if ($user->total_above_2_corore_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_2_corore_users;
                                }
                            } elseif ($minAactiveAmount >= 50000000 && $minAactiveAmount < 100000000) {
                                if ($user->total_above_5_corore_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_5_corore_users;
                                }
                            } elseif ($minAactiveAmount >= 100000000 && $minAactiveAmount < 250000000) {
                                if ($user->total_above_10_corore_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_10_corore_users;
                                }
                            } elseif ($minAactiveAmount >= 250000000 && $minAactiveAmount < 500000000) {
                                if ($user->total_above_25_corore_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_25_corore_users;
                                }
                            } elseif ($minAactiveAmount >= 500000000) {
                                if ($user->total_above_50_corore_users > 0) {
                                    $royaltyAmount = $minAactiveAmount / $user->total_above_50_corore_users;
                                }
                            }
                            if ($royaltyAmount > 0) {
                                $conditions = array('Payouts.upagraded_user_id' => $user->id, 'Payouts.royalty_amount > ' => 0, 'MONTH(Payouts.created)' => $this->request->getData()['Payout']['month'], 'YEAR(Payouts.created)' => date('Y'));
                                $checkPayout = $payoutsTable->find('all', array('conditions' => $conditions))->count();
                                if ($checkPayout == 0) {
                                    if ($user->total_roi < (2 * $user->Upgrades['package_amount'])) {
                                        $upagraded_user_id = $user->id;
                                        $payOutData = $payoutsTable->newEmptyEntity();
                                        $payOutData->upagraded_user_id = $upagraded_user_id;
                                        $payOutData->royalty_amount = $royaltyAmount;
                                        $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                        $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                        $payOutData->status = 0;
                                        $payoutsTable->save($payOutData);
                                    }
                                }
                            }
                            //Adding Royalty Amount End Here
                            
                        }
                    }
                }
                $this->Flash->success(__('ROI & Roayalty has been added of selected months.'));
                return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            } else {
                $this->Flash->error(__('Please fill all required fields mark with asterisk (*).'));
            }
        }
    }
    public function clubIncome() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' ROI & Royalty';
        $this->set('title', $title);
        $upgradesTable = TableRegistry::get('Upgrades');
        $paymentsTable = TableRegistry::get('Payments');
        $commissionsTable = TableRegistry::get('Commissions');
        $payoutsTable = TableRegistry::get('Payouts');
        $usersTable = TableRegistry::get('Users');
        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
        $months = $paymentsTable->getMonths();
        $this->set('months', $months);
        $join = array(array('table' => 'packages', 'alias' => 'Packages', 'type' => 'INNER', 'conditions' => array('Packages.id = Upgrades.package_id')));
        $conditions = array();
        $upgrades = $upgradesTable->find('all', array('join' => $join, 'conditions' => $conditions))->select(['total_businnes_point' => 'SUM(Packages.business_point)'])->first();
        $this->set('upgrades', $upgrades);
        if ($this->request->is('post')) {
            /*echo '<pre>';
            
            print_r($this->request->getData());*/
            //exit;
            if (!empty($this->request->getData()['Payout']['month']) && !empty($this->request->getData()['Payout']['business_value']) && $this->request->getData()['Payout']['business_value'] > 0 && !empty($this->request->getData()['Payout']['mobile_club']) && is_numeric($this->request->getData()['Payout']['laptop_club']) && !empty($this->request->getData()['Payout']['bike_club'])) {
                $month = trim($this->request->getData()['Payout']['month']);
                $conditions = array('Users.is_mobile_club = 1 OR Users.is_laptop_club = 1 OR Users.is_bike_club = 1');
                $users = $usersTable->find('all', array('conditions' => $conditions))->select(['total_mobile_club_users' => '(SELECT COUNT(u.id) FROM users u WHERE u.is_mobile_club=1 AND u.is_laptop_club is NULL AND u.is_bike_club is NULL )', 'total_laptop_club_users' => '(SELECT COUNT(u.id) FROM users u WHERE u.is_mobile_club=1 AND u.is_laptop_club=1 AND u.is_bike_club is NULL)', 'total_bike_club_users' => '(SELECT COUNT(u.id) FROM users u WHERE u.is_mobile_club=1 AND u.is_laptop_club=1 AND u.is_bike_club=1)'])->enableAutoFields(true)->toArray();
                if (!empty($users)) {
                    $totalBikeClubUsers = isset($users[0]['total_bike_club_users']) && !empty($users[0]['total_bike_club_users']) ? $users[0]['total_bike_club_users'] : 1;
                    $bikeClubAmount = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['bike_club']) / 100;
                    $bikeClubAmountEachUser = $bikeClubAmount / $totalBikeClubUsers;
                    if ($bikeClubAmountEachUser > 100000) {
                        $bikeClubAmountEachUser = 100000;
                    }
                    $totalLaptopClubUsers = isset($users[0]['total_laptop_club_users']) && !empty($users[0]['total_laptop_club_users']) ? $users[0]['total_laptop_club_users'] : 1;
                    $LaptopClubAmount = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['laptop_club']) / 100;
                    $laptopClubAmountEachUser = $LaptopClubAmount / $totalLaptopClubUsers;
                    if ($laptopClubAmountEachUser > 25000) {
                        $laptopClubAmountEachUser = 25000;
                    }
                    $totalMobileClubUsers = isset($users[0]['total_mobile_club_users']) && !empty($users[0]['total_mobile_club_users']) ? $users[0]['total_mobile_club_users'] : 1;
                    $mobileClubAmount = ($this->request->getData()['Payout']['business_value'] * $this->request->getData()['Payout']['mobile_club']) / 100;
                    $mobileClubAmountEachUser = $mobileClubAmount / $totalMobileClubUsers;
                    if ($mobileClubAmountEachUser > 10000) {
                        $mobileClubAmountEachUser = 10000;
                    }
                    foreach ($users as $user) {
                        $conditions = array('Payouts.upagraded_user_id' => $user->id);
                        $addedClubAmount = $payoutsTable->find('all', array('conditions' => $conditions))->select(['total_added_mbile_club_amount' => 'SUM(Payouts.mobile_club_amount)', 'total_added_laptop_club_amount' => 'SUM(Payouts.laptop_club_amount)', 'total_added_bike_club_amount' => 'SUM(Payouts.bike_club_amount)', 'check_mobile_club_amount_for_month' => '(SELECT COUNT(p.id) FROM payouts p WHERE MONTH(p.club_date) = "' . $month . '" AND YEAR(p.club_date) = "' . date('Y') . '" AND p.upagraded_user_id="' . $user->id . '" AND p.mobile_club_amount  > "0")', 'check_laptop_club_amount_for_month' => '(SELECT COUNT(p.id) FROM payouts p WHERE MONTH(p.club_date) = "' . $month . '" AND YEAR(p.club_date) = "' . date('Y') . '" AND p.upagraded_user_id="' . $user->id . '" AND p.laptop_club_amount  > "0")', 'check_bike_club_amount_for_month' => '(SELECT COUNT(p.id) FROM payouts p WHERE MONTH(p.club_date) = "' . $month . '" AND YEAR(p.club_date) = "' . date('Y') . '" AND p.upagraded_user_id="' . $user->id . '" AND p.bike_club_amount > "0")'])->first();
                        $payOutData = $payoutsTable->newEmptyEntity();
                        if ($user->is_bike_club == 1) {
                            if ($addedClubAmount->total_added_bike_club_amount < 100000 && $addedClubAmount->check_bike_club_amount_for_month == 0) {
                                $permissiableAmount = 100000 - $addedClubAmount->total_added_bike_club_amount;
                                if ($bikeClubAmountEachUser > $permissiableAmount) {
                                    $bikeClubAmountEachUser = $permissiableAmount;
                                }
                                $payOutData->upagraded_user_id = $user->id;
                                $payOutData->bike_club_amount = $bikeClubAmountEachUser;
                                $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                $payOutData->status = 0;
                                $payOutData->club_date = date('Y') . '-' . $month . '-' . date('d');
                                $payoutsTable->save($payOutData);
                            }
                        } elseif ($user->is_laptop_club == 1) {
                            if ($addedClubAmount->total_added_laptop_club_amount < 25000 && $addedClubAmount->check_laptop_club_amount_for_month == 0) {
                                $permissiableAmount = 25000 - $addedClubAmount->total_added_laptop_club_amount;
                                if ($laptopClubAmountEachUser > $permissiableAmount) {
                                    $laptopClubAmountEachUser = $permissiableAmount;
                                }
                                $payOutData->upagraded_user_id = $user->id;
                                $payOutData->laptop_club_amount = $laptopClubAmountEachUser;
                                $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                $payOutData->status = 0;
                                $payOutData->club_date = date('Y') . '-' . $month . '-' . date('d');
                                $payoutsTable->save($payOutData);
                            }
                        } elseif ($user->is_mobile_club == 1) {
                            if ($addedClubAmount->total_added_mbile_club_amount < 10000 && $addedClubAmount->check_mobile_club_amount_for_month == 0) {
                                $permissiableAmount = 10000 - $addedClubAmount->total_added_mbile_club_amount;
                                if ($mobileClubAmountEachUser > $permissiableAmount) {
                                    $mobileClubAmountEachUser = $permissiableAmount;
                                }
                                $payOutData->upagraded_user_id = $user->id;
                                $payOutData->mobile_club_amount = $mobileClubAmountEachUser;
                                $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                $payOutData->status = 0;
                                $payOutData->club_date = date('Y') . '-' . $month . '-' . date('d');
                                $payoutsTable->save($payOutData);
                            }
                        }
                    }
                }
                $this->Flash->success(__('Club amount has been added of selected months.'));
                return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            } else {
                $this->Flash->error(__('Please fill all required fields mark with asterisk (*).'));
            }
        }
    }
    public function levelIncome() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Level Income';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $commissionsTable = TableRegistry::get('Commissions');
        $upgradesTable = TableRegistry::get('Upgrades');
        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
        $conditions = array('Payouts.level_income > 0 AND Payouts.status=0');
        $checkUnpaidLevelIncome = $payoutsTable->find('all', array('conditions' => $conditions))->count();
        $this->set('checkUnpaidLevelIncome', $checkUnpaidLevelIncome);
        $conn = ConnectionManager::get('default');
        $lavelIncomes = $conn->execute("SELECT Users.id, Users.username, Users.closing_count, Details.first_name, Details.last_name, Details.pan_number,

            (SELECT SUM(mAmt.matching_amount) FROM payouts AS mAmt WHERE mAmt.upagraded_user_id=Users.id AND mAmt.status='0') AS level_income

            FROM users AS Users 

            INNER JOIN payouts AS Payouts on Payouts.upagraded_user_id = Users.id 

            INNER JOIN details AS Details on Details.user_id = Users.id

            WHERE Users.status = '1' AND Payouts.status = '0' AND Payouts.matching_amount > '0' GROUP BY Users.id");
        /*echo '<pre>';
        
        print_r($lavelIncomes->fetchAll('assoc'));
        
        exit;*/
        $lavelIncomes = $lavelIncomes->fetchAll('assoc');
        $this->set('lavelIncomes', $lavelIncomes);
        if ($this->request->is('post')) {
            /* echo '<pre>';
            
            print_r($this->request->getData());
            
            print_r($lavelIncomes);
            
            exit;*/
            if (isset($this->request->getData()['check_all']) && !empty($this->request->getData()['check_all']) && $this->request->getData()['check_all'] == 1 && count($this->request->getData()['ids']) >= 10) {
                foreach ($lavelIncomes as $lavelIncome) {
                    $user_id = $lavelIncome['id'];
                    $levelIncome = $lavelIncome['level_income'];
                    $parentIds = $usersTable->getSponserIds($user_id, 4);
                    $exParentIds = explode("_^_", $parentIds);
                    if (!empty($parentIds)) {
                        $i = 1;
                        foreach ($exParentIds as $parentId) {
                            $conditions = array('Upgrades.upgraded_id' => $parentId);
                            $order = array('Upgrades.id' => 'DESC');
                            $fields = array('Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_amount');
                            $upgrade = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order))->first();
                            if (!empty($upgrade)) {
                                if ($i == 1) {
                                    $comparePackageAmount = 6000;
                                    $percetage = 4;
                                } elseif ($i == 2) {
                                    $comparePackageAmount = 18000;
                                    $percetage = 3;
                                } elseif ($i == 3) {
                                    $comparePackageAmount = 30000;
                                    $percetage = 2;
                                } elseif ($i == 4) {
                                    $comparePackageAmount = 60000;
                                    $percetage = 1;
                                }
                                if ($upgrade->package_amount >= $comparePackageAmount) {
                                    $PercentageLevelIncome = ($levelIncome * $percetage) / 100;
                                    $payOutData = $payoutsTable->newEmptyEntity();
                                    $payOutData->upagraded_user_id = $parentId;
                                    $payOutData->level_income = $PercentageLevelIncome;
                                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                    $payoutsTable->save($payOutData);
                                }
                            }
                            $i++;
                        }
                    }
                }
            } elseif (isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids'])) {
                foreach ($this->request->getData()['ids'] as $user_id) {
                    $user_id = $user_id;
                    $levelIncome = $this->request->getData()['level_income'][$user_id];
                    $parentIds = $usersTable->getSponserIds($user_id, 4);
                    $exParentIds = explode("_^_", $parentIds);
                    if (!empty($parentIds)) {
                        $i = 1;
                        foreach ($exParentIds as $parentId) {
                            $conditions = array('Upgrades.upgraded_id' => $parentId);
                            $order = array('Upgrades.id' => 'DESC');
                            $fields = array('Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_amount');
                            $upgrade = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order))->first();
                            if (!empty($upgrade)) {
                                if ($i == 1) {
                                    $comparePackageAmount = 6000;
                                    $percetage = 4;
                                } elseif ($i == 2) {
                                    $comparePackageAmount = 18000;
                                    $percetage = 3;
                                } elseif ($i == 3) {
                                    $comparePackageAmount = 30000;
                                    $percetage = 2;
                                } elseif ($i == 4) {
                                    $comparePackageAmount = 60000;
                                    $percetage = 1;
                                }
                                if ($upgrade->package_amount >= $comparePackageAmount) {
                                    $PercentageLevelIncome = ($levelIncome * $percetage) / 100;
                                    $payOutData = $payoutsTable->newEmptyEntity();
                                    $payOutData->upagraded_user_id = $parentId;
                                    $payOutData->level_income = $PercentageLevelIncome;
                                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                    $payoutsTable->save($payOutData);
                                }
                            }
                            $i++;
                        }
                    }
                }
            }
            $this->Flash->success(__('Level income has been submitted successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            exit;
        }
    }
    public function matchingAmount() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Matching Amount';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $binariesTable = TableRegistry::get('Binaries');
        $commissionsTable = TableRegistry::get('Commissions');
        $flushesTable = TableRegistry::get('Flushes');
        if ($this->request->is('post')) {
            //echo '<pre>';
            // print_r($this->request->getData());
            //exit;
            $from_date = strtotime($this->request->getData()['Payout']['from_date']);
            $to_date = strtotime($this->request->getData()['Payout']['to_date']);
            $datediff = $to_date - $from_date;
            $totalDays = round($datediff / (60 * 60 * 24));
            if ($totalDays > 0) {
                $conditions = array('Binaries.status' => 1);
                $fields = array('Binaries.amount', 'Binaries.percentage');
                $binary = $binariesTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();
                $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
                $conditions = array(
                //'Users.total_direct_acitve_left >' => 0,
                //'Users.total_direct_acitve_right >' => 0,
                );
                $joins = array(array('table' => 'upgrades', 'alias' => 'Upgrades', 'type' => 'LEFT', 'conditions' => array('Upgrades.upgraded_id = Users.id')));
                $order = array();
                $group = array('Users.id');
                $fields = array('Upgrades.id', 'Upgrades.upgraded_id', 'Upgrades.package_id', 'Upgrades.package_amount');
                $users = $usersTable->find('all', array('fields' => $fields, 'join' => $joins, 'conditions' => $conditions, 'order' => $order, 'group' => $group))
                //->select(['maxAmount' => '(SELECT u.package_amount FROM upgrades u WHERE (u.upgraded_id=Upgrades.package_id) ORDER BY id DESC LIMIT 0, 1)'])
                ->select(['max_package_amount' => 'max(Upgrades.package_amount)'])->enableAutoFields(true)->toArray();
                //echo '<pre>';
                //print_r($users);exit;
                foreach ($users as $user) {
                    //$leftBusiness = $user->total_active_left - $user->total_direct_acitve_left;
                    //$rightBusiness = $user->total_active_right - $user->total_direct_acitve_right;
                    $leftBusiness = $user->total_active_left;
                    $rightBusiness = $user->total_active_right;
                    $currentPair = $rightBusiness;
                    if ($leftBusiness < $rightBusiness) {
                        $currentPair = $leftBusiness;
                    }
                    $pendingPair = $currentPair - $user->previous_pair;
                    $matchingAmount = (($pendingPair * $binary->percentage) / 100);
                    if (!empty(trim($user->max_package_amount))) {
                        $maxPackageAmount = $user->max_package_amount * $totalDays;
                        if ($matchingAmount > $maxPackageAmount) {
                            $matchingAmount = $maxPackageAmount;
                        }
                        if ($matchingAmount > 0) {
                            if ($user->total_direct_acitve_left > 0 && $user->total_direct_acitve_right > 0) {
                                $date = date('Y-m-d');
                                $checkUser = $payoutsTable->find('all', array('conditions' => array('Payouts.upagraded_user_id' => $user->id, 'Payouts.matching_amount >' => 0, 'DATE(Payouts.created)' => $date)))->count();
                                if ($checkUser == 0) {
                                    $payOutData = $payoutsTable->newEmptyEntity();
                                    $payOutData->upagraded_user_id = $user->id;
                                    $payOutData->matching_amount = $matchingAmount;
                                    $payOutData->tax = isset($commission->tax) ? $commission->tax : 0;
                                    $payOutData->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                                    $payOutData->status = 0;
                                    $payoutsTable->save($payOutData);
                                }
                            } else {
                                $date = date('Y-m-d');
                                $checkUser = $flushesTable->find('all', array('conditions' => array('Flushes.user_id' => $user->id, 'Flushes.matching_amount >' => 0, 'DATE(Flushes.created)' => $date)))->count();
                                if ($checkUser == 0) {
                                    $flushData = $flushesTable->newEmptyEntity();
                                    $flushData->user_id = $user->id;
                                    $flushData->matching_amount = $matchingAmount;
                                    $flushData->status = 0;
                                    $flushesTable->save($flushData);
                                }
                            }
                        }
                    } else {
                        if ($matchingAmount > 0) {
                            $date = date('Y-m-d');
                            $checkUser = $flushesTable->find('all', array('conditions' => array('Flushes.user_id' => $user->id, 'Flushes.matching_amount >' => 0, 'DATE(Flushes.created)' => $date)))->count();
                            if ($checkUser == 0) {
                                $flushData = $flushesTable->newEmptyEntity();
                                $flushData->user_id = $user->id;
                                $flushData->matching_amount = $matchingAmount;
                                $flushData->status = 0;
                                $flushesTable->save($flushData);
                            }
                        }
                    }
                    if ($pendingPair > 0) {
                        $userData = $usersTable->get($user->id);
                        $userData->previous_pair = $user->previous_pair + $pendingPair;
                        $usersTable->save($userData);
                    }
                }
                $this->Flash->success(__('Matching amount has been added from ' . $this->request->getData()['Payout']['from_date'] . ' to ' . $this->request->getData()['Payout']['to_date']));
                return $this->redirect(['controller' => 'payments', 'action' => 'closing', 'prefix' => $this->backend]);
            } else {
                $this->Flash->error(__('To date should be more than from date'));
            }
        }
    }
    public function calculatePairRate() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Calculate Pair Rate';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $pairRatesTable = TableRegistry::get('PairRates');
        $conn = ConnectionManager::get('default');
        $group = array('Upgrades.upgraded_id');
        $totalUpgradedUsers = $upgradesTable->find('all', array('group' => $group))->count();
        $this->set('totalUpgradedUsers', $totalUpgradedUsers);
        $query = $conn->execute("SELECT SUM(IF(u.total_active_left < u.total_active_right, u.total_active_left, u.total_active_right)) AS total_Pair FROM users u");
        $queryResult = $query->fetchAll('assoc');
        $this->set('queryResult', $queryResult);
        if ($this->request->is('post')) {
            /*echo '<pre>';
            
            print_r($this->request->getData());
            
            exit;*/
            $total_upgraded_users = isset($this->request->getData()['PairRate']['total_upgraded_users']) ? $this->request->getData()['PairRate']['total_upgraded_users'] : '';
            $amount_per_id = isset($this->request->getData()['PairRate']['amount_per_id']) ? $this->request->getData()['PairRate']['amount_per_id'] : '';
            $total_amount = isset($this->request->getData()['PairRate']['total_amount']) ? $this->request->getData()['PairRate']['total_amount'] : '';
            $total_pair = isset($this->request->getData()['PairRate']['total_pair']) ? $this->request->getData()['PairRate']['total_pair'] : '';
            $pair_rate = isset($this->request->getData()['PairRate']['pair_rate']) ? $this->request->getData()['PairRate']['pair_rate'] : '';
            $no_of_emi = isset($this->request->getData()['PairRate']['no_of_emi']) ? $this->request->getData()['PairRate']['no_of_emi'] : '';
            $emi_rate = isset($this->request->getData()['PairRate']['emi_rate']) ? $this->request->getData()['PairRate']['emi_rate'] : '';
            if (!empty($total_upgraded_users) && !empty($amount_per_id) && !empty($total_amount) && !empty($total_pair) && !empty($pair_rate) && !empty($no_of_emi) && !empty($emi_rate)) {
                $pairRatesTable->updateAll(['status' => 0], ['status' => 1]);
                $pairRateData = $pairRatesTable->newEmptyEntity();
                $pairRateData->total_upgraded_users = $total_upgraded_users;
                $pairRateData->amount_per_id = $amount_per_id;
                $pairRateData->total_amount = $total_amount;
                $pairRateData->total_pair = $total_pair;
                $pairRateData->pair_rate = $pair_rate;
                $pairRateData->no_of_emi = $no_of_emi;
                $pairRateData->emi_rate = $emi_rate;
                $pairRateData->status = 1;
                if ($pairRatesTable->save($pairRateData)) {
                    $this->Flash->success(__('Pair Rate has been saved successfully.'));
                    return $this->redirect($this->backend_url . '/payments/pair-rate-list');
                }
            } else {
                $this->Flash->error(__('Please fill all required fields'));
            }
        }
    }
    public function pairRateList() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Pair Rate List';
        $this->set('title', $title);
        $pairRatesTable = TableRegistry::get('PairRates');
        $pairRates = $pairRatesTable->find('all')->toArray();
        $this->set('pairRates', $pairRates);
    }
    public function calculateMatchingIncome() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Calculate Matching Income';
        $this->set('title', $title);
        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $pairRatesTable = TableRegistry::get('PairRates');
        $commissionsTable = TableRegistry::get('Commissions');
        $conditions = array('Users.left_emi > 0 AND Users.right_emi');
        $users = $usersTable->find('all', array('conditions' => $conditions))->toArray();
        $this->set('users', $users);
        $pairRate = $pairRatesTable->find('all', array('conditions' => array('PairRates.status' => 1)))->first();
        $this->set('pairRate', $pairRate);
        $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->enableAutoFields(true)->first();
        if ($this->request->is('post')) {
            /*echo '<pre>';
            
            print_r($this->request->getData());
            
            exit;*/
            if (!empty($users)) {
                foreach ($users as $userInfo) {
                    $leftEmi = 0;
                    if (!empty($userInfo->left_emi)) {
                        $leftEmi = $userInfo->left_emi;
                    }
                    $rightEmi = 0;
                    if (!empty($userInfo->right_emi)) {
                        $rightEmi = $userInfo->right_emi;
                    }
                    $pair = $leftEmi;
                    if ($leftEmi > $rightEmi) {
                        $pair = $rightEmi;
                    }
                    $matchingIncome = $pair * $pairRate->emi_rate;
                    $payout = $payoutsTable->newEmptyEntity();
                    $payout->upagraded_user_id = $userInfo->id;
                    $payout->matching_amount = $matchingIncome;
                    $payout->tax = isset($commission->tax) ? $commission->tax : 0;
                    $payout->admin_commission = isset($commission->amount) ? $commission->amount : 0;
                    $payoutsTable->save($payout);
                    $userData = $usersTable->get($userInfo->id);
                    $userData->left_emi = NULL;
                    $userData->right_emi = NULL;
                    $usersTable->save($userData);
                }
                $this->Flash->success(__('Matching income has been submitted successfully.'));
                return $this->redirect($this->backend_url . '/payments/calculate-matching-income');
            }
        }
    }
}
