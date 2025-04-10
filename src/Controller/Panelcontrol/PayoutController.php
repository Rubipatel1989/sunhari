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

class PayoutController extends AppController
{

    public function closing()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payouts : Closing";

        $this->set("title", $title);

        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');
        $closingsTable = TableRegistry::get('Closings');

        $conn = ConnectionManager::get('default');

        $closings = $conn->execute("SELECT Users.id, Users.username, Users.name, Users.bank_name, Users.account_number, Users.pan_number, Users.branch, Users.ifsc_code,
            (SELECT SUM(p.level_income) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0' AND p.remark = 'Direct Income') AS direct_income,
            (SELECT SUM(p.level_income) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0' AND p.remark = 'Level Income') AS level_income,
            (SELECT SUM(p.daily_incentive) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0') AS daily_incentive,
            (SELECT SUM(p.repurchase_ab_income) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0') AS repurchase_ab_income,
            (SELECT SUM(p.repurchase_mb_income) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0') AS repurchase_mb_income,
            (SELECT SUM(p.royalty_income) FROM payouts AS p WHERE p.user_id=Users.id AND p.status='0') AS royalty_income,
            (SELECT c.closing_count FROM closings AS c ORDER BY c.id DESC LIMIT 0, 1) AS last_closing_count

            FROM users AS Users 
            INNER JOIN payouts AS Payouts on Payouts.user_id = Users.id
            WHERE Payouts.status = '0' GROUP BY Users.id"); 

        $this->set('closings', $closings->fetchAll('assoc'));

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit; */

            if(isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids'])){
                foreach($this->request->getData()['ids'] as $user_id){

                    if(isset($this->request->getData()['net_amount'][$user_id]) && $this->request->getData()['net_amount'][$user_id] > 0){

                        $closing = $closingsTable->newEmptyEntity();
                        $closing->user_id = $user_id;
                        $closing->daily_incentive = isset($this->request->getData()['daily_incentive'][$user_id]) ? $this->request->getData()['daily_incentive'][$user_id] : 0;
                        $closing->direct_income = isset($this->request->getData()['direct_income'][$user_id]) ? $this->request->getData()['direct_income'][$user_id] : 0;
                        $closing->level_income = isset($this->request->getData()['level_income'][$user_id]) ? $this->request->getData()['level_income'][$user_id] : 0;
                        $closing->repurchase_ab_income = isset($this->request->getData()['repurchase_ab_income'][$user_id]) ? $this->request->getData()['repurchase_ab_income'][$user_id] : 0;
                        $closing->repurchase_mb_income = isset($this->request->getData()['repurchase_mb_income'][$user_id]) ? $this->request->getData()['repurchase_mb_income'][$user_id] : 0;
                        $closing->royalty_income = isset($this->request->getData()['royalty_income'][$user_id]) ? $this->request->getData()['royalty_income'][$user_id] : 0;
                        $closing->total_income = isset($this->request->getData()['total'][$user_id]) ? $this->request->getData()['total'][$user_id] : 0;
                        $closing->tax = isset($this->request->getData()['tax'][$user_id]) ? $this->request->getData()['tax'][$user_id] : 0;
                        $closing->foundation_charge = isset($this->request->getData()['foundation_charge'][$user_id]) ? $this->request->getData()['foundation_charge'][$user_id] : 0;
                        $closing->admin_commission = isset($this->request->getData()['admin_commission'][$user_id]) ? $this->request->getData()['admin_commission'][$user_id] : 0;
                        $closing->net_amount = isset($this->request->getData()['net_amount'][$user_id]) ? $this->request->getData()['net_amount'][$user_id] : 0;
                         $closing->closing_count = isset($this->request->getData()['closing_count'][$user_id]) ? $this->request->getData()['closing_count'][$user_id] : 0;

                        $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id)))->first();
                        $closing->pan_number = $userInfo->pan_number;
                        $closing->account_number = $userInfo->account_number;
                        $closing->bank_name = $userInfo->bank_name;
                        $closing->branch_name = $userInfo->branch_name;
                        $closing->ifsc_code = $userInfo->ifsc_code;
                        $closingsTable->save($closing);

                        $payoutsTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s")], ['Payouts.user_id' => $user_id]);

                    }
                }
            }
            $this->Flash->success(__('Payment has been closed successfully.'));

            return $this->redirect($this->backend_url.'/payout/closing');
        }
    }

    public function closingList()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title . " Payouts : Closing List";
        $this->set("title", $title);

        $closingsTable = TableRegistry::get('Closings');

        $conditions = [];
        $order = ['Closings.id' => 'DESC'];
        $fields = ['Closings.closing_count'];
        $lastClosingInfo = $closingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = Closings.user_id"],

                ]
            ];
            $conditions = ['Closings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $closingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }

    public function promotionDirectClosing()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payouts : Promotion Direct Closing";

        $this->set("title", $title);

        $usersTable = TableRegistry::get('Users');
        $promotionPayoutsTable = TableRegistry::get('PromotionPayouts');
        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conn = ConnectionManager::get('default');

        $closings = $conn->execute("SELECT Users.id, Users.username, Users.name, Users.bank_name, Users.account_number, Users.pan_number, Users.branch, Users.ifsc_code,
            (SELECT SUM(p.direct_income) FROM promotion_payouts AS p WHERE p.user_id = Users.id AND p.status='0') AS direct_income,
            (SELECT c.closing_count FROM promotion_closings AS c WHERE c.closing_type = 1 ORDER BY c.id DESC LIMIT 0, 1) AS last_closing_count
            FROM users AS Users 
            INNER JOIN promotion_payouts AS PromotionPayouts on PromotionPayouts.user_id = Users.id
            WHERE PromotionPayouts.status = 0 AND PromotionPayouts.direct_income > 0 GROUP BY Users.id"); 

        $this->set('closings', $closings->fetchAll('assoc'));

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit; */

            if(isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids'])){
                foreach($this->request->getData()['ids'] as $user_id){

                    if(isset($this->request->getData()['net_amount'][$user_id]) && $this->request->getData()['net_amount'][$user_id] > 0){

                        $closing = $promotionClosingsTable->newEmptyEntity();
                        $closing->user_id = $user_id;
                        $closing->closing_type = 1;
                        $closing->direct_income = isset($this->request->getData()['direct_income'][$user_id]) ? $this->request->getData()['direct_income'][$user_id] : 0;
                        $closing->total_income = isset($this->request->getData()['total'][$user_id]) ? $this->request->getData()['total'][$user_id] : 0;
                        $closing->tax = isset($this->request->getData()['tax'][$user_id]) ? $this->request->getData()['tax'][$user_id] : 0;
                        $closing->foundation_charge = isset($this->request->getData()['foundation_charge'][$user_id]) ? $this->request->getData()['foundation_charge'][$user_id] : 0;
                        $closing->admin_commission = isset($this->request->getData()['admin_commission'][$user_id]) ? $this->request->getData()['admin_commission'][$user_id] : 0;
                        $closing->net_amount = isset($this->request->getData()['net_amount'][$user_id]) ? $this->request->getData()['net_amount'][$user_id] : 0;
                         $closing->closing_count = isset($this->request->getData()['closing_count'][$user_id]) ? $this->request->getData()['closing_count'][$user_id] : 0;

                        $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id)))->first();
                        $closing->pan_number = $userInfo->pan_number;
                        $closing->account_number = $userInfo->account_number;
                        $closing->bank_name = $userInfo->bank_name;
                        $closing->branch_name = $userInfo->branch_name;
                        $closing->ifsc_code = $userInfo->ifsc_code;
                        $promotionClosingsTable->save($closing);

                        $promotionPayoutsTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s")], ['Payouts.user_id' => $user_id, 'Payouts.direct_income >' => 0]);

                    }
                }
            }
            $this->Flash->success(__('Payment has been closed successfully.'));

            return $this->redirect($this->backend_url.'/payout/promotion-direct-closing');
        }
    }

    public function promotionDirectClosingList()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title . " Payouts : Promotion Direct Closing List";
        $this->set("title", $title);

        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conditions = ['PromotionClosings.closing_type' => 1];
        $order = ['PromotionClosings.id' => 'DESC'];
        $fields = ['PromotionClosings.closing_count'];
        $lastClosingInfo = $promotionClosingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = PromotionClosings.user_id"],

                ]
            ];
            $conditions = ['PromotionClosings.closing_type' => 1, 'PromotionClosings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $promotionClosingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }

    public function promotionLevelClosing()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Payouts : Promotion Level Closing";

        $this->set("title", $title);

        $usersTable = TableRegistry::get('Users');
        $promotionPayoutsTable = TableRegistry::get('PromotionPayouts');
        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conn = ConnectionManager::get('default');

        $closings = $conn->execute("SELECT Users.id, Users.username, Users.name, Users.bank_name, Users.account_number, Users.pan_number, Users.branch, Users.ifsc_code,
            (SELECT SUM(p.level_income) FROM promotion_payouts AS p WHERE p.user_id = Users.id AND p.status='0') AS level_income,
            (SELECT c.closing_count FROM promotion_closings AS c WHERE c.closing_type = 2 ORDER BY c.id DESC LIMIT 0, 1) AS last_closing_count
            FROM users AS Users 
            INNER JOIN promotion_payouts AS PromotionPayouts on PromotionPayouts.user_id = Users.id
            WHERE PromotionPayouts.status = 0 AND (SELECT SUM(p.level_income) FROM promotion_payouts AS p WHERE p.user_id = Users.id AND p.status='0') >= 200 GROUP BY Users.id"); 

        $this->set('closings', $closings->fetchAll('assoc'));

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit; */

            if(isset($this->request->getData()['ids']) && !empty($this->request->getData()['ids'])){
                foreach($this->request->getData()['ids'] as $user_id){

                    if(isset($this->request->getData()['net_amount'][$user_id]) && $this->request->getData()['net_amount'][$user_id] > 0){

                        $closing = $promotionClosingsTable->newEmptyEntity();
                        $closing->user_id = $user_id;
                        $closing->closing_type = 2;
                        $closing->level_income = isset($this->request->getData()['level_income'][$user_id]) ? $this->request->getData()['level_income'][$user_id] : 0;
                        $closing->total_income = isset($this->request->getData()['total'][$user_id]) ? $this->request->getData()['total'][$user_id] : 0;
                        $closing->tax = isset($this->request->getData()['tax'][$user_id]) ? $this->request->getData()['tax'][$user_id] : 0;
                        $closing->foundation_charge = isset($this->request->getData()['foundation_charge'][$user_id]) ? $this->request->getData()['foundation_charge'][$user_id] : 0;
                        $closing->admin_commission = isset($this->request->getData()['admin_commission'][$user_id]) ? $this->request->getData()['admin_commission'][$user_id] : 0;
                        $closing->net_amount = isset($this->request->getData()['net_amount'][$user_id]) ? $this->request->getData()['net_amount'][$user_id] : 0;
                         $closing->closing_count = isset($this->request->getData()['closing_count'][$user_id]) ? $this->request->getData()['closing_count'][$user_id] : 0;

                        $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id)))->first();
                        $closing->pan_number = $userInfo->pan_number;
                        $closing->account_number = $userInfo->account_number;
                        $closing->bank_name = $userInfo->bank_name;
                        $closing->branch_name = $userInfo->branch_name;
                        $closing->ifsc_code = $userInfo->ifsc_code;
                        $promotionClosingsTable->save($closing);

                        $promotionPayoutsTable->updateAll(['status' => 1, 'modified' => date("Y-m-d H:i:s")], ['Payouts.user_id' => $user_id, 'Payouts.level_income >' => 0]);

                    }
                }
            }
            $this->Flash->success(__('Payment has been closed successfully.'));

            return $this->redirect($this->backend_url.'/payout/promotion-level-closing');
        }
    }

    public function promotionLevelClosingList()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title . " Payouts : Promotion Level Closing List";
        $this->set("title", $title);

        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conditions = ['PromotionClosings.closing_type' => 2];
        $order = ['PromotionClosings.id' => 'DESC'];
        $fields = ['PromotionClosings.closing_count'];
        $lastClosingInfo = $promotionClosingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = PromotionClosings.user_id"],

                ]
            ];
            $conditions = ['PromotionClosings.closing_type' => 2, 'PromotionClosings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $promotionClosingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }
}
