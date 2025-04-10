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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{

    public function index($searchKeyword=false){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Users';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $upgradesTable  = TableRegistry::get('Upgrades');

        $join = [];
        $join[] = [
            "table" => "users",
            "alias" => "Sponsers",
            "type" => "LEFT",
            "conditions" => ["Sponsers.id = Users.sponsor_id"],
        ];
        $commonFilter = ['Users.role_id' => 2];
        $template = 'index'; 
        $blockStatusFilter = [];
        $todayJoiningFilter = [];
        $statusFilter = [];
        if ($searchKeyword == 'block-ids') {
            $template = 'blocked_ids';
            $blockStatusFilter = ['Users.is_blocked' => 1];
        } elseif ($searchKeyword == 'today-joining') {
            $template = 'today_joining';
            $todayJoiningFilter = ['DATE(Users.created)' => date('Y-m-d')];
        } elseif ($searchKeyword == 'total-joining') {
            $template = 'today_joining';
        } elseif ($searchKeyword == 'today-activation') {
            $template = 'blocked_users';
            $join[] = [
                "table" => "upgrades",
                "alias" => "Upgrades",
                "type" => "INNER",
                "conditions" => ["Upgrades.upgraded_id = Users.id AND Upgrades.is_activated = 1 AND DATE(Upgrades.created) = '".date('Y-m-d')."'"],
            ];
        } elseif ($searchKeyword == 'total-activation') {
            $template = 'blocked_users';
            $join[] = [
                "table" => "upgrades",
                "alias" => "Upgrades",
                "type" => "INNER",
                "conditions" => ["Upgrades.upgraded_id = Users.id AND Upgrades.is_activated = 1"],
            ];
        }  elseif ($searchKeyword == 'inactive-ids') {
            $template = 'inactive_ids';
            $statusFilter = ['Users.status' => 3];
        }
        $conditions = array_merge($commonFilter, $blockStatusFilter, $todayJoiningFilter);
        $limit = 100;

        $fields = ["Sponsers.username"];
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
        ->select([
            'total_package_amount' => '(SELECT SUM(u.package_amount) from upgrades u WHERE u.upgraded_id = Users.id)'
        ])
        ->enableAutoFields(true)->toArray();

        $this->set('users', $users);
        $this->set('searchKeyword', $searchKeyword);

        $this->render($template);

    }

    public function upgradeHistory(){

        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');

        $conditions = array();
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Upgrades.upgraded_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'UserDetails',
                        'type' => 'INNER',
                        'conditions' => array('UserDetails.user_id = Upgrades.upgraded_id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Upgrader',
                        'type' => 'INNER',
                        'conditions' => array('Upgrader.id = Upgrades.upgraded_by')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'UpgraderDetails',
                        'type' => 'INNER',
                        'conditions' => array('UpgraderDetails.user_id = Upgrades.upgraded_by')
                    ),
                    array(
                        'table' => 'plot_payments',
                        'alias' => 'PlotPayments',
                        'type' => 'LEFT',
                        'conditions' => array('PlotPayments.user_id = Upgrades.upgraded_id AND PlotPayments.number_of_unit > 0')
                    )
                );
        $order = array(
                        'Upgrades.id' => 'DESC'
                    );
        $fields = array('Users.id', 'Users.username', 'Users.rank', 'Upgrader.username', 'Upgrader.username', 'UserDetails.id', 'UserDetails.first_name', 'UserDetails.middle_name', 'UserDetails.last_name', 'UpgraderDetails.first_name', 'UpgraderDetails.middle_name', 'UpgraderDetails.last_name', 'PlotPayments.id', 'PlotPayments.number_of_unit');

        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('upgrades', $upgrades);
    
    }

    public function block($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = 1;
        $usersTable->save($userData);

        $this->Flash->success(__('User has been blocked successfully.'));

        return $this->redirect($this->backend_url.'/users/index');
    }

    public function unblock($intUserId, $encBackeUrl){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = NULL;
        $userData->block_reason_remark = NULL;
        $usersTable->save($userData);
        $backUrl = base64_decode($encBackeUrl);
        echo $backUrl;exit;

        $this->Flash->success(__('User has been unblocked successfully.'));

        return $this->redirect($backUrl);
    }

    public function holdWithdrawal($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_withdrawal_block = 1;
        $usersTable->save($userData);

        $this->Flash->success(__('Withdraw request has been hold successfully.'));

        return $this->redirect($this->backend_url.'/users/index');
    }

    public function removeHoldWithdrawal($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_withdrawal_block = 0;
        $usersTable->save($userData);

        $this->Flash->success(__('Withdraw request hold has been removed successfully.'));

        return $this->redirect($this->backend_url.'/users/index');
    }

    public function achievedRewards(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Achieved Rewards';

        $this->set('title', $title);

        $achievedRewardsTable = TableRegistry::get('AchievedRewards');

        $join = array(
                    array(
                        'table' => 'rewards',
                        'alias' => 'Rewards',
                        'type' => 'INNER',
                        'conditions' => array('Rewards.id = AchievedRewards.reward_id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = AchievedRewards.user_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $conditions = array();
        $order = array(
                        'AchievedRewards.id' => 'DESC'
                    );
        $fields = array('Rewards.id', 'Rewards.title', 'Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $achievedRewards = $achievedRewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('achievedRewards', $achievedRewards);

    }

    public function achievedRewardStatus($encId, $encStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Achieved Rewards';

        $this->set('title', $title);

        $achievedRewardsTable = TableRegistry::get('AchievedRewards');

        $intId = base64_decode($encId);
        $intStatus = base64_decode($encStatus);

        $achievedReward = $achievedRewardsTable->get($intId);
        $achievedReward->status = $intStatus;
        if($achievedRewardsTable->save($achievedReward)){
            $this->Flash->success(__('Reward status has been changed successfully.'));

            return $this->redirect($this->backend_url.'/users/achieved-rewards');
        }
    }

    public function editProfile($encUserId)
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' User : Edit Profile';
        $this->set('title', $title);
        $userId = base64_decode($encUserId);
        $usersTable  = TableRegistry::get('Users');
        $attachmentsTable  = TableRegistry::get('Attachments');
        $join = [
            [
                "table" => "users",
                "alias" => "Sponsors",
                "type" => "LEFT",
                "conditions" => ["Sponsors.id = Users.sponsor_id"],
            ],
            [
                "table" => "packages",
                "alias" => "Packages",
                "type" => "LEFT",
                "conditions" => ["Packages.user_id = Users.id"],
            ],
            [
                "table" => "attachments",
                "alias" => "Attachments",
                "type" => "LEFT",
                "conditions" => ["Attachments.id = Users.attachment_id"],
            ]
        ];
        $conditions = ['Users.id' => $userId];
        $fields = ['Sponsors.username', 'Packages.created', 'Attachments.file', 'Attachments.caption'];
        $userInfo = $usersTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->first();
        $this->set('userInfo', $userInfo);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/
            $name = $this->request->getData()['User']['name'] ?? '';
            $aadhar_number = $this->request->getData()['User']['aadhar_number'] ?? '';
            $pan_number = $this->request->getData()['User']['pan_number'] ?? '';
            $email = $this->request->getData()['User']['email'] ?? '';
            $contact_number = $this->request->getData()['User']['contact_number'] ?? '';
            $current_rank = $this->request->getData()['User']['current_rank'] ?? '';
            $password = $this->request->getData()['User']['password'];
            $attachment_id = $this->request->getData()['User']['attachment_id'][0] ?? '';
            $bank_name = $this->request->getData()['User']['bank_name'] ?? '';
            $account_number = $this->request->getData()['User']['account_number'] ?? '';
            $ifsc_code = $this->request->getData()['User']['ifsc_code'] ?? '';

            if ($name && $email && $contact_number && $aadhar_number  && $pan_number && $bank_name && $account_number && $ifsc_code) {
                $objUser = $usersTable->get($userId);
                $objUser->name = $name;
                $objUser->aadhar_number = $aadhar_number;
                $objUser->pan_number = $pan_number;
                $objUser->email = $email;
                $objUser->contact_number = $contact_number;
                $objUser->bank_name = $bank_name;
                $objUser->account_number = $account_number;
                $objUser->ifsc_code = $ifsc_code;
                if ($current_rank){
                    $objUser->current_rank = $current_rank;
                }
                if($password) {
                    $objUser->password = md5($password);
                }
                if ($attachment_id) {
                    $objUser->attachment_id = $attachment_id;
                }
                if($usersTable->save($objUser)) {
                    if($attachment_id) {
                        $objAttachment = $attachmentsTable->get($attachment_id);
                        $objAttachment->reference_id = $userId;
                        $objAttachment->reference_type = 'user_profile_pic';
                        $objAttachment->caption = $this->request->getData()['User']['attachment_id']['caption'][0] ?? '';
                        $attachmentsTable->save($objAttachment);
                    }
                    $this->Flash->success(__( "Profile info has been saved successfully."));
                    return $this->redirect($this->backend_url.'/users/edit-profile/'.$encUserId);
                }
            } else {
                $this->Flash->error(__("All fields marked with * are mandatory."));
            }
        }
    }
}
