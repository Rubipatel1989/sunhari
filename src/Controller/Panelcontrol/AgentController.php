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
use App\Controller\SimpleXLSX;

class AgentController extends AppController
{

    public function newJoining()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Manage Agents : New Joining";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $username = $usersTable->getUniqueUsername("DPA");
            $password = isset($this->request->getData()["User"]["password"]) ? trim($this->request->getData()["User"]["password"]) : null;
            $email = isset($this->request->getData()["User"]["email"]) ? trim($this->request->getData()["User"]["email"]) : null;
            $sponser_username = isset($this->request->getData()["User"]["sponsor_username"]) ? trim($this->request->getData()["User"]["sponsor_username"]) : null;
            $sponsor_name = isset($this->request->getData()["User"]["sponsor_name"]) ? trim($this->request->getData()["User"]["sponsor_name"]) : null;
            $name = isset($this->request->getData()["User"]["name"]) ? trim($this->request->getData()["User"]["name"]) : null;
            $aadhar_number = isset($this->request->getData()["User"]["aadhar_number"]) ? trim($this->request->getData()["User"]["aadhar_number"]) : null;
            $pan_number = isset($this->request->getData()["User"]["pan_number"]) ? trim($this->request->getData()["User"]["pan_number"]) : null;
            $contact_number = isset($this->request->getData()["User"]["contact_number"]) ? trim($this->request->getData()["User"]["contact_number"]) : null;
            $current_rank = isset($this->request->getData()["User"]["current_rank"]) ? trim($this->request->getData()["User"]["current_rank"]) : null;
            $bank_name = isset($this->request->getData()["User"]["bank_name"]) ? trim($this->request->getData()["User"]["bank_name"]) : null;
            $account_number = isset($this->request->getData()["User"]["account_number"]) ? trim($this->request->getData()["User"]["account_number"]) : null;
            $ifsc_code = isset($this->request->getData()["User"]["ifsc_code"]) ? trim($this->request->getData()["User"]["ifsc_code"]) : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($email) &&
                !empty($sponser_username) &&
                !empty($sponsor_name) &&
                !empty($name) &&
                !empty($aadhar_number) &&
                !empty($pan_number) &&
                !empty($contact_number) &&
                !empty($current_rank) &&
                !empty($bank_name) &&
                !empty($account_number) &&
                !empty($ifsc_code)
            ) {
                
                $checkEmail = $usersTable
                    ->find("all", ["conditions" => ["Users.email" => $email]])
                    ->count();

                $checkUsername = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.username" => $username],
                    ])
                    ->count();

                $conditions = [
                    "Users.username" => $sponser_username,
                    'Users.role_id' => 2
                ];

                $sponserInfo = $usersTable
                    ->find("all", [
                        "conditions" => $conditions
                    ])
                    ->enableAutoFields(true)
                    ->first();
                if ($checkUsername > 0) {
                    $this->Flash->error(
                        __(
                            "Entered username already used by our registered user. Please register with different username"
                        )
                    );
                } elseif (empty($sponserInfo)) {
                    $this->Flash->error(
                        __(
                            "Entered referral id does not exist in our database. Please resgister with different referral id."
                        )
                    );
                } elseif ($current_rank >= $sponserInfo->current_rank) {
                    $this->Flash->error(
                        __(
                            "Rank should be less than ".$this->userData->getRankLabelById($sponserInfo->current_rank)
                        )
                    );
                } else {
                    //print_r($usersTable->getLastUserInfo($sponserInfo->id, $position));exit;

                    $getLastUserInfo = json_decode($usersTable->getLastUserInfo($sponserInfo->id));

                    $user = $usersTable->newEmptyEntity();
                    $user->added_by = $this->adminUser->id;
                    $user->role_id = 2;
                    $user->sponsor_id = $sponserInfo->id;
                    $user->sponsor_name = $sponserInfo->name;
                    $user->name = $name;
                    $user->aadhar_number = $aadhar_number;
                    $user->pan_number = $pan_number;
                    $user->email = $email;
                    $user->username = $username;
                    $user->password = md5($password);
                    $user->transaction_password = md5($password);
                    $user->contact_number = $contact_number;
                    $user->current_rank = $current_rank;
                    $user->bank_name = $bank_name;
                    $user->account_number = $account_number;
                    $user->ifsc_code = $ifsc_code;
                    $user->status = 1;

                    if ($usersTable->save($user)) {
                        $user_id = $user->id;
                        $updateParents = $usersTable->updateParents(
                            $user_id,
                            $sponserInfo->id,
                            $user_id,
                            0,
                            $getLastUserInfo->id,
                            $sponserInfo->id
                        );

                        $sponsor = $usersTable->get($sponserInfo->id);
                        $sponsor->total_direct = $sponserInfo->total_direct + 1;
                        $usersTable->save($sponsor);

                        $this->request->getSession()->write("username", $username);
                        $this->request->getSession()->write("password", $password);

                        $templateId = '1707173253545533214';
                        $template = "Welcome To Daulat Pride Parivaar Your's BA User ID = ".$username." Password = ".$password." For Login Please Visit Our Website www.daulatprideindia.net";
                        $usersTable->sendSMS($contact_number, $templateId, $template);

                        $this->Flash->success(
                            __(
                                "Congratulations ".$name."! you have resistered successfully."
                            )
                        );

                        return $this->redirect($this->backend_url.'/user/user-added');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function addMultipleAgents()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Manage Agents : Add Multiple Agents";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        if ($this->request->is("post")) {
           /* echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $tmp_name = $_FILES["user_file"]["tmp_name"] ?? '';
            $file_name = isset($_FILES["user_file"]["name"]) ?? '';
                
            if ($tmp_name && $file_name) {
                $extFileName = explode(".", $file_name);
                $fileExt = trim($extFileName[count($extFileName) - 1]);
                if ($xlsx = SimpleXLSX::parse($_FILES['user_file']['tmp_name'])) {
                    foreach($xlsx->rows() as $key => $row) {
                        if($key > 0) {
                            $sponser_username = $row[0];
                            $name = $row[1];
                            $username = $row[2];
                            $password = 123456;
                            $email = $row[3];
                            $aadhar_number = $row[4];
                            $pan_number = $row[5];
                            $contact_number = $row[6];
                            $current_rank = $row[7];
                            $bank_name = $row[8];
                            $account_number = $row[9];
                            $ifsc_code = $row[10];
                            $created = $row[11];

                            if (
                                !empty($username) &&
                                !empty($password) &&
                                !empty($email) &&
                                !empty($sponser_username) &&
                                !empty($name) &&
                                !empty($aadhar_number) &&
                                !empty($pan_number) &&
                                !empty($contact_number) &&
                                !empty($current_rank) &&
                                !empty($bank_name) &&
                                !empty($account_number) &&
                                !empty($ifsc_code) &&
                                !empty($created)
                            ) {
                                
                                $checkEmail = $usersTable
                                    ->find("all", ["conditions" => ["Users.email" => $email]])
                                    ->count();

                                $checkUsername = $usersTable
                                    ->find("all", [
                                        "conditions" => ["Users.username" => $username],
                                    ])
                                    ->count();

                                $conditions = [
                                    "Users.username" => $sponser_username,
                                    'Users.role_id' => 2
                                ];

                                $sponserInfo = $usersTable
                                    ->find("all", [
                                        "conditions" => $conditions
                                    ])
                                    ->enableAutoFields(true)
                                    ->first();

                                if (!$checkUsername && $sponserInfo && ($current_rank < $sponserInfo->current_rank)) {

                                    $getLastUserInfo = json_decode($usersTable->getLastUserInfo($sponserInfo->id));

                                    $user = $usersTable->newEmptyEntity();
                                    $user->added_by = $this->adminUser->id;
                                    $user->role_id = 2;
                                    $user->sponsor_id = $sponserInfo->id;
                                    $user->sponsor_name = $sponserInfo->name;
                                    $user->name = $name;
                                    $user->aadhar_number = $aadhar_number;
                                    $user->pan_number = $pan_number;
                                    $user->email = $email;
                                    $user->username = $username;
                                    $user->password = md5($password);
                                    $user->transaction_password = md5($password);
                                    $user->contact_number = $contact_number;
                                    $user->current_rank = $current_rank;
                                    $user->bank_name = $bank_name;
                                    $user->account_number = $account_number;
                                    $user->ifsc_code = $ifsc_code;
                                    $user->status = 1;
                                    $user->created = $created;
                                    $user->modified = $created;

                                    if ($usersTable->save($user)) {
                                        $user_id = $user->id;
                                        $updateParents = $usersTable->updateParents(
                                            $user_id,
                                            $sponserInfo->id,
                                            $user_id,
                                            0,
                                            $getLastUserInfo->id,
                                            $sponserInfo->id
                                        );

                                        $sponsor = $usersTable->get($sponserInfo->id);
                                        $sponsor->total_direct = $sponserInfo->total_direct + 1;
                                        $usersTable->save($sponsor);
                                    }
                                }
                            }
                        }
                    }

                    $this->Flash->success( __("Valid agents has been added successfully."));
                    return $this->redirect($this->backend_url.'/agent/add-multiple-agents');
                }
            }
        }
    }

    public function index($searchKeyword=false){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Manage Agents : All Agent Details';

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
        $join[] = [
            "table" => "users",
            "alias" => "AddedBy",
            "type" => "LEFT",
            "conditions" => ["AddedBy.id = Users.added_by"],
        ];
        $commonFilter = ['Users.role_id' => 2];
        $template = 'index'; 
        $blockStatusFilter = [];
        $todayJoiningFilter = [];
        $statusFilter = [];
        $usernameFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
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
        $username = $_GET['username'] ?? '';
        if($username) {
            $usernameFilter = ['Users.username' => $username];
        }
        $fromDate = $_GET['from_date'] ?? '';
        if($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(Users.created) >=' => $fromDate];
        }
        $toDate = $_GET['to_date'] ?? '';
        if($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(Users.created) <=' => $toDate];
        }
        $users = [];
        $isRenderData = false;
        if ($template == 'index') {
            if ($usernameFilter || $fromDateFilter || $toDateFilter) {
                $isRenderData = true;
            }
        } else {
            $isRenderData = true;
        }

        if ($isRenderData) {
            $conditions = array_merge($commonFilter, $blockStatusFilter, $todayJoiningFilter, $usernameFilter, $fromDateFilter, $toDateFilter);
            $fields = ["Sponsers.username", "AddedBy.username", "AddedBy.name"];
            $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
            ->select([
                'total_package_amount' => '(SELECT SUM(u.package_amount) from upgrades u WHERE u.upgraded_id = Users.id)'
            ])
            ->enableAutoFields(true)->toArray();
        }

        $this->set('users', $users);
        $this->set('searchKeyword', $searchKeyword);

        $this->render($template);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $id = $this->request->getData()["User"]["id"] ?? ''; 
            $block_reason_remark = $this->request->getData()["User"]["block_reason_remark"] ?? ''; 
            if (
                !empty($id) &&
                !empty($block_reason_remark)
            ) {
                $userData = $usersTable->get($id);
                $userData->is_blocked = 1;
                $userData->block_reason_remark = $block_reason_remark;
                $usersTable->save($userData);
                $this->Flash->success(__('Agent has been blocked successfully.'));
                return $this->redirect($this->backend_url.'/agent/index/?username='.$username.'&from_date='.$fromDate.'&to_date='.$toDate);
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function activateRoyalty(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Manage Agents : Activate Royalty';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = isset($this->request->getData()["User"]["username"]) ? trim($this->request->getData()["User"]["username"]) : null;
            $name = isset($this->request->getData()["User"]["name"]) ? trim($this->request->getData()["User"]["name"]) : null;

            if ($username) {
                $conditions = [
                    "Users.username" => $username,
                    'Users.role_id' => 2
                ];

                $userInfo = $usersTable->find("all", ["conditions" => $conditions])->enableAutoFields(true)->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Enter user id does not exist in our database"));
                } else {
                    $objUser = $usersTable->get($userInfo->id);
                    $objUser->royalty_one = 1;
                    $usersTable->save($objUser);
                    $usersTable->activateRoyalty($userInfo->id);
                    if($userInfo->sponsor_id) {
                        $usersTable->activateRoyalty($userInfo->sponsor_id);
                    }
                    $this->Flash->success(__("Royalty has been activated successfully."));
                    return $this->redirect($this->backend_url.'/agent/activate-royalty');
                }
            }
        }
    }

    public function royaltyList(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Royalty : Royalty List';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');

        $royaltyNumber = $_GET['royalty_number'] ?? '';
        $users = [];
        if ($royaltyNumber) {
            if($royaltyNumber == 1) {
                $conditions = ['Users.royalty_one' => 1];
            } elseif($royaltyNumber == 2) {
                $conditions = ['Users.royalty_two' => 1];
            } elseif($royaltyNumber == 3) {
                $conditions = ['Users.royalty_three' => 1];
            } elseif($royaltyNumber == 4) {
                $conditions = ['Users.royalty_four' => 1];
            } elseif($royaltyNumber == 5) {
                $conditions = ['Users.royalty_five' => 1];
            } elseif($royaltyNumber == 6) {
                $conditions = ['Users.royalty_six' => 1];
            } elseif($royaltyNumber == 7) {
                $conditions = ['Users.royalty_seven' => 1];
            } elseif($royaltyNumber == 8) {
                $conditions = ['Users.royalty_eight' => 1];
            } elseif($royaltyNumber == 9) {
                $conditions = ['Users.royalty_nine' => 1];
            } elseif($royaltyNumber == 10) {
                $conditions = ['Users.royalty_ten' => 1];
            } elseif($royaltyNumber == 11) {
                $conditions = ['Users.royalty_eleven' => 1];
            } elseif($royaltyNumber == 12) {
                $conditions = ['Users.royalty_twelve' => 1];
            } elseif($royaltyNumber == 13) {
                $conditions = ['Users.royalty_thirteen' => 1];
            }
            $users = $usersTable->find('all', array('conditions' => $conditions))
            ->select([
                'total_package_amount' => '(SELECT SUM(u.package_amount) from upgrades u WHERE u.upgraded_id = Users.id)'
            ])
            ->enableAutoFields(true)->toArray();
        }
        $this->set('users', $users);
    }

    public function dailyIncentiveDetails(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Daily Incentive Details';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');

        $username = $_GET['username'] ?? '';

        $agents = [];
        $customers = [];
        if($username) {
            $conditions = ['Users.username' => $username, 'Users.role_id' => 2];
            $userInfo = $usersTable->find('all', ['conditions' => $conditions])->first();
            if ($userInfo) {
                $agents = $usersTable->getDownlineIncentiveEligibleAgents($userInfo->id);
                $customers = $usersTable->getDownlineIncentiveEligibleCustomers($userInfo->id);
            }
        }

        $this->set('agents', $agents);
        $this->set('customers', $customers);
    }

    public function unblock($intUserId, $encBackeUrl){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Unblock User';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = NULL;
        $userData->block_reason_remark = NULL;
        $usersTable->save($userData);
        $backUrl = base64_decode($encBackeUrl);

        $this->Flash->success(__('User has been unblocked successfully.'));

        return $this->redirect($this->backend_url.'/agent/index?'.$backUrl);
    }

}
