<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;
use Cake\Mailer\Mailer;

class CustomerController extends AppController
{
    public function newJoining()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Manage Customers | New Joining";
        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $walletsTable = TableRegistry::get("Wallets");

        $conditions = ['Wallets.user_id' => $this->user->id];
        $wallet = $walletsTable->find('all', ['conditions' => $conditions])
        ->select([
            'total_wallet_amount' => 'SUM(Wallets.amount)'
        ])->first();
        $this->set('wallet', $wallet);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $username = $usersTable->getUniqueUsername("SGC");

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
                    $user->added_by = $this->user->id;
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
                        //$usersTable->sendSMS($contact_number, $templateId, $template);

                        $this->Flash->success(
                            __(
                                "Congratulations ".$name."! customer has been added successfully."
                            )
                        );

                        return $this->redirect($this->home_url.'/my-account/customer/user-added');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function userAdded()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Manage Agents | Agent Added";
        $this->set("title", $title);
    }

    public function index($searchKeyword=false)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Manage Agents | All Agent Details";
        $this->set("title", $title);

        $usersTable  = TableRegistry::get('Users');
        $upgradesTable  = TableRegistry::get('Upgrades');

        $join = [];
        $join[] = [
            "table" => "users",
            "alias" => "Sponsers",
            "type" => "LEFT",
            "conditions" => ["Sponsers.id = Users.sponsor_id"],
        ];
        $commonFilter = ['Users.role_id' => 3, 'Users.added_by' => $this->user->id];
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
}
