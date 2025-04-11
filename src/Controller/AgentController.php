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

class AgentController extends AppController
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
        $title = $prefix_title . " Manage Agents | New Joining";
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

            $username = $usersTable->getUniqueUsername("SGA");

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
            $otp = isset($this->request->getData()["User"]["otp"]) ? trim($this->request->getData()["User"]["otp"]) : null;

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

                if ($wallet->total_wallet_amount < 1110) {
                    $this->Flash->error(
                        __(
                            "Your wallet balance is less than Rs ".number_format(1110, 2)
                        )
                    );
                } elseif ($checkUsername > 0) {
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
                    if (!$this->request->getSession()->check("agent_joining_otp"))
                    {
                        $randOtp = rand(123456, 999999);
                        $this->request->getSession()->write("agent_joining_otp", $randOtp);
                        $templateId = '1707173271190790392';
                        $template = "".$randOtp." is OTP for your Agent registration for amount Rs.1110 OTP valid for 10 minutes. Do not share this OTP with anyone. DAULAT PRIDE";
                        $usersTable->sendSMS($this->user->contact_number, $templateId, $template);
                        $this->Flash->success(
                                __(
                                    "Please enter OTP that has been sent to your regisered mobile number."
                                )
                            );
                    } elseif(
                        $this->request->getSession()->check("agent_joining_otp")
                        && $this->request->getSession()->read('agent_joining_otp') == $otp
                    ) {
                        $getLastUserInfo = json_decode($usersTable->getLastUserInfo($sponserInfo->id));
                        $user = $usersTable->newEmptyEntity();
                        $user->added_by = $this->user->id;
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

                            $objWallet = $walletsTable->newEmptyEntity();
                            $objWallet->user_id = $this->user->id;
                            $objWallet->transfer_by = $this->user->id;
                            $objWallet->transaction_id = $walletsTable->getTransactionId(11);
                            $objWallet->amount = '-1110';
                            $objWallet->remark = 'Used in adding agent';
                            $objWallet->status = 0;
                            $walletsTable->save($objWallet);

                            $this->request->getSession()->write("username", $username);
                            $this->request->getSession()->write("password", $password);
                            $this->request->getSession()->delete("agent_joining_otp");

                            $templateId = '1707173253545533214';
                            $template = "Welcome To Daulat Pride Parivaar Your's BA User ID = ".$username." Password = ".$password." For Login Please Visit Our Website www.daulatprideindia.net";
                            //$usersTable->sendSMS($contact_number, $templateId, $template);

                            $this->Flash->success(
                                __(
                                    "Congratulations ".$name."! Agent has been resistered successfully."
                                )
                            );

                            return $this->redirect($this->home_url.'/my-account/agent/user-added');
                        }
                    } else {
                        $this->Flash->error(
                            __(
                                "Wrong OTP entered. Please enter correct OTP."
                            )
                        );
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
        $commonFilter = ['Users.role_id' => 2, 'Users.added_by' => $this->user->id];
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

    public function royaltyReport()
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
        $title = $prefix_title . " Royalty Report";
        $this->set("title", $title);
    }

    public function dailyIncentiveDetails()
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
        $title = $prefix_title . " Daily Incentive Details";
        $this->set("title", $title);

        $usersTable  = TableRegistry::get('Users');

        $agents = $usersTable->getDownlineIncentiveEligibleAgents($this->user->id);
        $customers = $usersTable->getDownlineIncentiveEligibleCustomers($this->user->id);

        $this->set('agents', $agents);
        $this->set('customers', $customers);
    }
}
