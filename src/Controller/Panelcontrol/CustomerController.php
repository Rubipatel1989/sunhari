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

class CustomerController extends AppController
{

    public function newJoining()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Manage Customers : New Joining";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $countriesTable = TableRegistry::get("Countries");

        $countries = $countriesTable
            ->find("all", [
                "conditions" => ["Countries.status" => 1],
                "order" => ["Countries.name" => "ASC"],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("countries", $countries);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $username = $usersTable->getUniqueUsername("DPC");

            $password = isset($this->request->getData()["User"]["password"]) ? trim($this->request->getData()["User"]["password"]) : null;

            $email = isset($this->request->getData()["User"]["email"]) ? trim($this->request->getData()["User"]["email"]) : null;

            $sponser_username = isset($this->request->getData()["User"]["sponsor_username"]) ? trim($this->request->getData()["User"]["sponsor_username"]) : null;

            $sponsor_name = isset($this->request->getData()["User"]["sponsor_name"]) ? trim($this->request->getData()["User"]["sponsor_name"]) : null;

            $name = isset($this->request->getData()["User"]["name"]) ? trim($this->request->getData()["User"]["name"]) : null;

            $aadhar_number = isset($this->request->getData()["User"]["aadhar_number"]) ? trim($this->request->getData()["User"]["aadhar_number"]) : null;

            $contact_number = isset($this->request->getData()["User"]["contact_number"]) ? trim($this->request->getData()["User"]["contact_number"]) : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($email) &&
                !empty($sponser_username) &&
                !empty($sponsor_name) &&
                !empty($name) &&
                !empty($aadhar_number) &&
                !empty($contact_number)
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
                } /*elseif ($sponserInfo->status != 1) {
                    $this->Flash->error(
                        __(
                            "Referral Id not acitve. Please use active Referral Id for Registration."
                        )
                    );
                }*/ else {
                    
                    $user = $usersTable->newEmptyEntity();
                    $user->added_by = $this->adminUser->id;
                    $user->role_id = 3;
                    $user->sponsor_id = $sponserInfo->id;
                    $user->sponsor_name = $sponserInfo->name;
                    $user->name = $name;
                    $user->aadhar_number = $aadhar_number;
                    $user->email = $email;
                    $user->username = $username;
                    $user->password = md5($password);
                    $user->transaction_password = md5($password);
                    $user->contact_number = $contact_number;
                    $user->status = 3;

                    if ($usersTable->save($user)) {
                        $user_id = $user->id;
                        $sponsor = $usersTable->get($sponserInfo->id);
                        $sponsor->total_customers = $sponserInfo->total_customers + 1;
                        $usersTable->save($sponsor);

                        $this->request->getSession()->write("username", $username);
                        $this->request->getSession()->write("password", $password);

                        $templateId = '1707173253556518322';
                        $template = "Welcome To Daulat Pride Parivaar Your's Customer ID = ".$username." Password = ".$password." For Login Please Visit Our Website www.daulatprideindia.net";
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

    public function addMultipleCustomers()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Manage Customers : Add Multiple Customers";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $countriesTable = TableRegistry::get("Countries");

        $countries = $countriesTable
            ->find("all", [
                "conditions" => ["Countries.status" => 1],
                "order" => ["Countries.name" => "ASC"],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("countries", $countries);

        if ($this->request->is("post")) {
            /*echo '<pre>';
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
                            $contact_number = $row[5];
                            $created = $row[6];

                            if (
                                !empty($username) &&
                                !empty($password) &&
                                !empty($email) &&
                                !empty($sponser_username) &&
                                !empty($name) &&
                                !empty($aadhar_number) &&
                                !empty($contact_number) &&
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
                                if (!$checkUsername && $sponserInfo) {
                                    $user = $usersTable->newEmptyEntity();
                                    $user->added_by = $this->adminUser->id;
                                    $user->role_id = 3;
                                    $user->sponsor_id = $sponserInfo->id;
                                    $user->sponsor_name = $sponserInfo->name;
                                    $user->name = $name;
                                    $user->aadhar_number = $aadhar_number;
                                    $user->email = $email;
                                    $user->username = $username;
                                    $user->password = md5($password);
                                    $user->transaction_password = md5($password);
                                    $user->contact_number = $contact_number;
                                    $user->status = 3;
                                    $user->created = $created;
                                    $user->modified = $created;

                                    if ($usersTable->save($user)) {
                                        $user_id = $user->id;
                                        $sponsor = $usersTable->get($sponserInfo->id);
                                        $sponsor->total_customers = $sponserInfo->total_customers + 1;
                                        $usersTable->save($sponsor);
                                    }
                                }
                            }
                        }
                    }

                    $this->Flash->success(__("Valid customer has been added successfully."));

                    return $this->redirect($this->backend_url.'/customer/add-multiple-customers');
                }
            }
        }
    }

    public function index($searchKeyword=false){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Manage Customers : All Customer Details';

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
        $commonFilter = ['Users.role_id' => 3];
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
                'activation_date' => '(SELECT p.created FROM packages p WHERE p.user_id = Users.id ORDER BY p.id ASC LIMIT 0, 1)',
                'total_package_amount' => '(SELECT SUM(p.amount) FROM packages p WHERE p.user_id = Users.id)',
                'total_plan_ab' => '(SELECT COUNT(p.id) FROM packages p WHERE p.user_id = Users.id AND p.plan_id = 1)',
                'total_plan_ab_amount' => '(SELECT SUM(p.amount) FROM packages p WHERE p.user_id = Users.id AND p.plan_id = 1)',
                'total_plan_mb' => '(SELECT COUNT(p.id) FROM packages p WHERE p.user_id = Users.id AND p.plan_id = 2)',
                'total_plan_mb_amount' => '(SELECT SUM(p.amount) FROM packages p WHERE p.user_id = Users.id AND p.plan_id = 2)'
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
                $this->Flash->success(__('Customer has been blocked successfully.'));
                return $this->redirect($this->backend_url.'/customer/index/?username='.$username.'&from_date='.$fromDate.'&to_date='.$toDate);
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
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

        return $this->redirect($this->backend_url.'/customer/index?'.$backUrl);
    }
}
