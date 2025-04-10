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

class UserController extends AppController
{
    public function register($referralUsername = null, $referredPosition = null)
    { 
        $this->viewBuilder()->setLayout('member-login-black');

        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Register";
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

        $referralInfo = [];
        if ($referralUsername) {
            $conditions = ['Users.username' => $referralUsername];
            $fields = ['Users.username', 'Users.name'];
            $referralInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
        }
        $this->set("referralInfo", $referralInfo);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $usersTable->getUniqueUsername("AJ");

            $password = isset($this->request->getData()["User"]["password"]) ? trim($this->request->getData()["User"]["password"]) : null;

            $email = isset($this->request->getData()["User"]["email"]) ? trim($this->request->getData()["User"]["email"]) : null;

            $sponser_username = isset($this->request->getData()["User"]["sponsor_username"]) ? trim($this->request->getData()["User"]["sponsor_username"]) : null;

            $sponsor_name = isset($this->request->getData()["User"]["sponsor_name"]) ? trim($this->request->getData()["User"]["sponsor_name"]) : null;

            $name = isset($this->request->getData()["User"]["name"]) ? trim($this->request->getData()["User"]["name"]) : null;

            $contact_number = isset($this->request->getData()["User"]["contact_number"]) ? trim($this->request->getData()["User"]["contact_number"]) : null;

            $country_id = isset($this->request->getData()["User"]["country_id"]) ? trim($this->request->getData()["User"]["country_id"]) : null;

            $country_code = isset($this->request->getData()["User"]["country_code"]) ? trim($this->request->getData()["User"]["country_code"]) : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($email) &&
                !empty($sponser_username) &&
                !empty($sponsor_name) &&
                !empty($name) &&
                !empty($contact_number) &&
                !empty($country_id) &&
                !empty($country_code)
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
                    $getLastUserInfo = json_decode($usersTable->getLastUserInfo($sponserInfo->id));

                    $exCountry = explode("__", $country_id);
                    $user = $usersTable->newEmptyEntity();

                    $user->role_id = 2;
                    $user->parent_id = $sponserInfo->id;
                    $user->parent_name = $sponserInfo->name;
                    $user->sponsor_id = $sponserInfo->id;
                    $user->sponsor_name = $sponserInfo->name;
                    $user->name = $name;
                    $user->email = $email;
                    $user->username = $username;
                    $user->password = md5($password);
                    $user->transaction_password = md5($password);
                    $user->plain_password = $password;
                    $user->contact_number = $contact_number;
                    $user->country_id = $exCountry[0];
                    $user->status = 3;

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

                        $emailData = [
                            'name' => $name,
                            'username' => $username,
                            'password' => $password
                        ];
                        $fromemail = 'info@aojora.io';
                        $to_email = $email;
                        $mailer = new Mailer();
                        $mailer
                        ->setEmailFormat('html')
                        ->setTo($to_email)
                        ->setSubject('Aojora || You are registered on aojora.io.')
                        ->setFrom($fromemail)
                        ->setViewVars(array("user" => $emailData))
                        ->viewBuilder()
                            ->setTemplate('registration')
                            ->setLayout('emaillayout');
                        $mailer->deliver();

                        $this->request->getSession()->write("username", $username);

                        $this->request->getSession()->write("password", $password);

                        $this->Flash->success(
                            __(
                                "Congratulations ".$name."! you have registered successfully."
                            )
                        );

                        return $this->redirect($this->home_url.'/user/user-added');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }

    }

    public function userAdded()
    { 
        $this->viewBuilder()->setLayout('member-login-black');
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " User Registered";
        $this->set("title", $title);
    }

    public function verifyAccount()
    {
        if ($this->request->getSession()->check("userId")) {
            return $this->redirect($this->home_url.'/my-account');
        }

        if (
            !$this->request->getSession()->check("userData") ||
            empty($this->request->getSession()->read("userData"))
        ) {
            return $this->redirect($this->home_url.'/user/register');
        }

        if (
            !$this->request->getSession()->check("registrationOtp") ||
            empty($this->request->getSession()->read("registrationOtp"))
        ) {
            return $this->redirect($this->home_url.'/user/register');
        }

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Verify";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $detailsTable = TableRegistry::get("Details");

        $downlinesTable = TableRegistry::get("Downlines");

        $upgradesTable = TableRegistry::get("Upgrades");

        if ($this->request->is("post")) {
            $userData = $this->request->getSession()->read("userData");

            $email = $userData["User"]["email"]
                ? trim($userData["User"]["email"])
                : "";

            $username = $userData["User"]["username"]
                ? trim($userData["User"]["username"])
                : "";

            $sponser_username = $userData["User"]["sponser_username"]
                ? $userData["User"]["sponser_username"]
                : "";

            $position = $userData["User"]["position"]
                ? $userData["User"]["position"]
                : "";

            $contact_no = $userData["Detail"]["contact_no"]
                ? $userData["Detail"]["contact_no"]
                : "";

            if (isset($this->request->getData()["btn_verify"])) {
                $registrationOtp = $this->request
                    ->getSession()
                    ->read("registrationOtp");

                if (
                    $registrationOtp ==
                    trim($this->request->getData()["User"]["otp"])
                ) {
                    if (
                        !empty($email) &&
                        !empty($username) &&
                        !empty($sponser_username) &&
                        !empty($position) &&
                        !empty($contact_no)
                    ) {
                        $checkEmail = $usersTable
                            ->find("all", [
                                "conditions" => ["Users.email" => $email],
                            ])
                            ->count();

                        $checkUsername = $usersTable
                            ->find("all", [
                                "conditions" => ["Users.username" => $username],
                            ])
                            ->count();

                        $checkContactNumber = $detailsTable
                            ->find("all", [
                                "conditions" => [
                                    "Details.contact_no" => $contact_no,
                                ],
                            ])
                            ->count();

                        $conditions = [
                            "Users.username" => $sponser_username,
                        ];

                        $joins = [
                            [
                                "table" => "details",

                                "alias" => "Details",

                                "type" => "INNER",

                                "conditions" => ["Details.user_id = Users.id"],
                            ],
                        ];

                        $sponserInfo = $usersTable
                            ->find("all", [
                                "fields" => [
                                    "Details.id",
                                    "Details.first_name",
                                    "Details.middle_name",
                                    "Details.last_name",
                                ],
                                "conditions" => $conditions,
                                "join" => $joins,
                            ])
                            ->enableAutoFields(true)
                            ->first();

                        if (!empty($sponserInfo)) {
                            $upgrades = $upgradesTable
                                ->find("all", [
                                    "conditions" => [
                                        "Upgrades.upgraded_id" =>
                                            $sponserInfo->id,
                                        "Upgrades.expiry_date >=" => date(
                                            "Y-m-d"
                                        ),
                                    ],
                                ])
                                ->enableAutoFields(true)
                                ->first();
                        }

                        /*if($checkEmail >= 3){

                             $this->Flash->error(__('Entered email id used 3 times. So Please resgister with different email id.'));

                        }*/

                        if ($checkUsername > 0) {
                            $this->Flash->error(
                                __(
                                    "Entered username already used by our registered user. Please register with different username"
                                )
                            );
                        }
                        /*elseif($checkContactNumber > 0){

                            $this->Flash->error(__('Entered contact number already used by our registered user. Please resgister with different contact number'));

                        }*/ elseif (
                            empty($sponserInfo)
                        ) {
                            $this->Flash->error(
                                __(
                                    "Entered referral id does not exist in our database. Please resgister with different referral id."
                                )
                            );
                        }
                        /*elseif(empty($upgrades)){

                            $this->Flash->error(__('Entered referral id is not upgraded. Please resgister with different referral id.'));

                        }*/ else {
                            $getLastUserInfo = json_decode(
                                $usersTable->getLastUserInfo(
                                    $sponserInfo->id,
                                    $position
                                )
                            );

                            $user = $usersTable->newEmptyEntity();

                            $user->role_id = 2;

                            $user->parent_id = $getLastUserInfo->id;

                            $user->parent_name =
                                $getLastUserInfo->Details->first_name .
                                " " .
                                $getLastUserInfo->Details->last_name;

                            $user->sponsor_id = $sponserInfo->id;

                            $user->sponsor_name =
                                $sponserInfo->Details["first_name"] .
                                " " .
                                $sponserInfo->Details["last_name"];

                            $user->position = $position;

                            $user->email = $email;

                            $user->username = $username;

                            $user->password = md5(
                                $userData["User"]["password"]
                            );

                            $user->total_left = 0;

                            $user->total_right = 0;

                            $user->total_active_left = 0;

                            $user->total_active_right = 0;

                            $user->total_inactive_left = 0;

                            $user->total_inactive_right = 0;

                            $user->total_direct_left = 0;

                            $user->total_direact_right = 0;

                            $user->total_direct_acitve_left = 0;

                            $user->total_direct_acitve_right = 0;

                            $user->total_direct_inacitve_left = 0;

                            $user->total_direct_inacitve_right = 0;

                            $user->status = 3;

                            if ($usersTable->save($user)) {
                                $user_id = $user->id;

                                $detail = $detailsTable->newEmptyEntity();

                                $detail->user_id = $user_id;

                                $detail->first_name =
                                    $userData["Detail"]["first_name"];

                                $detail->last_name =
                                    $userData["Detail"]["last_name"];

                                $detail->contact_no =
                                    $userData["Detail"]["contact_no"];

                                $detailsTable->save($detail);

                                $parent = $usersTable->get(
                                    $getLastUserInfo->id
                                );

                                if ($position == "left") {
                                    $parent->left_user = $user_id;
                                } else {
                                    $parent->right_user = $user_id;
                                }

                                $usersTable->save($parent);

                                $updateParents = $usersTable->updateParents(
                                    $user_id,
                                    $getLastUserInfo->id,
                                    $position,
                                    $user_id,
                                    0,
                                    $getLastUserInfo->id,
                                    $sponserInfo->id
                                );

                                $sponsor = $usersTable->get($sponserInfo->id);

                                if ($position == "left") {
                                    $sponsor->total_direct_left =
                                        $sponserInfo->total_direct_left + 1;

                                    $sponsor->total_direct_inacitve_left =
                                        $sponserInfo->total_direct_inacitve_left +
                                        1;
                                } else {
                                    $sponsor->total_direact_right =
                                        $sponserInfo->total_direact_right + 1;

                                    $sponsor->total_direct_inacitve_right =
                                        $sponserInfo->total_direct_inacitve_right +
                                        1;
                                }

                                $usersTable->save($sponsor);

                                $Email = new Email();

                                $fromemail = $this->setting->sender_email;

                                $to_email = $email;

                                $Email
                                    ->template("registration", "emaillayout")

                                    ->viewVars(["user" => $userData])

                                    ->emailFormat("html")

                                    ->to($to_email)

                                    ->from([$fromemail => "Octiq Marketing"])

                                    ->subject(
                                        "Dear " .
                                            $sponserInfo->Details[
                                                "first_name"
                                            ] .
                                            " " .
                                            $sponserInfo->Details["last_name"] .
                                            " ! You have successfully registered on octiqmarketing.com"
                                    )

                                    ->send();

                                $template =
                                    "Welcome to Octiq Marketing, Your login details are Username = " .
                                    $userData["User"]["username"] .
                                    " Password = " .
                                    $userData["User"]["password"] .
                                    " For more details, visit us www.octiqmarketing.com";

                                $sendSMS = $usersTable->sendSMS(
                                    $template,
                                    $userData["Detail"]["contact_no"]
                                );

                                $this->request
                                    ->getSession()
                                    ->delete("userData");

                                $this->request
                                    ->getSession()
                                    ->write("userId", $user_id);

                                $this->Flash->success(
                                    __(
                                        "Congratulations! You have successfully resistered on site."
                                    )
                                );

                                return $this->redirect($this->home_url.'/my-account');
                            }
                        }
                    } else {
                        $this->Flash->error(
                            __("Please fill all the required fields.")
                        );
                    }
                } else {
                    $this->Flash->error(
                        __("Entered OTP is wrog please enter correct OTP.")
                    );
                }
            }

            if (isset($this->request->getData()["btn_resend"])) {
                $userData = $this->request->getSession()->read("userData");

                $otp = rand(123456, 999999);

                /*$template = "Your OTP for www.admireglobal.io is ".$otp.". Valid for next 60 mins only.";

                $sendSMS = $usersTable->sendSMS($template, $userData['Detail']['contact_no']);*/

                $userData["User"]["otp"] = $otp;

                $this->request->getSession()->write("userData", $userData);

                $Email = new Email();

                $fromemail = $this->setting->sender_email;

                $to_email = $email;

                $Email
                    ->template("otp", "emaillayout")

                    ->viewVars(["user" => $userData])

                    ->emailFormat("html")

                    ->to($to_email)

                    ->from([$fromemail => "Admire Global"])

                    ->subject(
                        "Dear " .
                            $userData["Detail"]["first_name"] .
                            " " .
                            $userData["Detail"]["last_name"] .
                            " ! Your OTP for www.octiqmarketing.com"
                    );

                if ($Email->send()) {
                    $this->request
                        ->getSession()
                        ->write("registrationOtp", $otp);

                    if (
                        $this->request->getSession()->check("registrationOtp")
                    ) {
                        $this->Flash->success(
                            __(
                                "A new OTP has been sent to your contact number."
                            )
                        );

                        return $this->redirect($this->home_url.'/user/verify_account');
                    }
                } else {
                    $this->Flash->error(
                        __(
                            "Email is not working, please contact your site administrator."
                        )
                    );
                }
            }
        }
    }

    public function registerationCompleted()
    {
        if (
            !$this->request->getSession()->check("username") ||
            !$this->request->getSession()->check("password")
        ) {
            return $this->redirect($this->home_url.'/my-account');
        }

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Registeration Completed";

        $this->set("title", $title);
    }

    public function login()
    {
        if ($this->request->getSession()->check("userId")) {
            return $this->redirect($this->home_url.'/my-account');
        }

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Login";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        /*if ($this->request->is("post")) {
            $userInfo = $usersTable
                ->find("all", [
                    "conditions" => [
                        "Users.username" => trim(
                            $this->request->getData()["User"]["username"]
                        ),
                        "Users.password" => md5(
                            $this->request->getData()["User"]["password"]
                        ),
                    ],
                ])
                ->first();

            if (!empty($userInfo) > 0) {
                if ($userInfo->is_blocked != 1) {
                    $this->request
                        ->getSession()
                        ->write("userId", $userInfo->id);

                    $this->user = $userInfo;

                    if ($userInfo->status == 1 || $userInfo->status == 3) {
                        return $this->redirect($this->home_url.'/my-account');
                    } elseif ($userInfo->status == 0) {
                        $this->Flash->error(
                            __(
                                "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                            )
                        );

                        return $this->redirect($this->home_url.'/user/verify_account');
                    }
                } else {
                    $this->Flash->error(
                        __(
                            "Your account has been blocked. Please contact site administrator to unblock your account."
                        )
                    );
                }
            } else {
                $this->Flash->error(__("Wrong username or password."));
            }
        }*/
    }

    public function recoverPassword()
    {
        if ($this->request->getSession()->check("userId")) {return $this->redirect($this->home_url.'/my-account');
        }

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Register";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $detailsTable = TableRegistry::get("Details");

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());exit;*/

            if (
                !empty($this->request->getData()["Detail"]["contact_no"]) &&
                !empty($this->request->getData()["User"]["username"])
            ) {
                $join = [
                    [
                        "table" => "details",

                        "alias" => "Details",

                        "type" => "INNER",

                        "conditions" => ["Details.user_id = Users.id"],
                    ],
                ];

                $conditions = [
                    "Details.contact_no" => trim(
                        $this->request->getData()["Detail"]["contact_no"]
                    ),

                    "Users.username" => trim(
                        $this->request->getData()["User"]["username"]
                    ),
                ];

                $fields = [
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                    "Details.contact_no",
                ];

                $DetailsInfo = $usersTable
                    ->find("all", [
                        "fields" => $fields,
                        "conditions" => $conditions,
                        "join" => $join,
                    ])
                    ->enableAutoFields(true)
                    ->first();

                if (!empty($DetailsInfo)) {
                    $user_id = $DetailsInfo->id;

                    $email = $DetailsInfo->email;

                    $username = $DetailsInfo->username;

                    $contact_no = $DetailsInfo->Details["contact_no"];

                    $first_name = $DetailsInfo->Details["first_name"];

                    $last_name = $DetailsInfo->Details["last_name"];

                    $password =
                        rand(20, 80) .
                        rand(100, 999) .
                        chr(rand(97, 122)) .
                        chr(rand(65, 90)) .
                        "@";

                    $userSaveData = $usersTable->get($user_id);

                    $userSaveData->password = md5($password);

                    $usersTable->save($userSaveData);

                    $template =
                        "Dear  " .
                        $first_name .
                        " " .
                        $last_name .
                        "(" .
                        $username .
                        "), Your new login password for Jsksinfratech.com is " .
                        $password .
                        ". For help, please visit Jsksinfratech.com";

                    $sendSMS = $usersTable->sendSMS($template, $contact_no);

                    /*$emailData = array(

                                    'email' => $email,

                                    '$contact_no' => $contact_no,

                                    'first_name' => $first_name,

                                    'last_name' => $last_name,

                                    'password' => $password,

                                );

                    $fromemail = $this->setting->sender_email;

                    $to_email = $email;

                    $Email = new Email();

                    $Email->template('recover_password', 'emaillayout')

                          ->viewVars(array("emailData" => $emailData))

                          ->emailFormat('html')

                          ->to($to_email)

                          ->from(array($fromemail => 'Octiq Marketing'))

                          ->subject('Dear '.$first_name.' '.$last_name.' ! Your password has been changed successfully on www.octiqmarketing.com')

                          ->send();*/

                    $this->Flash->success(
                        __(
                            "Your new password has been sent on your registered contact number and email both."
                        )
                    );

                    return $this->redirect($this->home_url.'/user/recover-password');
                } else {
                    $this->Flash->error(
                        __("Wrong username or contact number.")
                    );
                }
            } else {
                $this->Flash->error(
                    __(
                        "Please fill either contact number or email and username."
                    )
                );
            }
        }
    }

    public function privacyPolicy()
    {
        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Privacy Policy";

        $this->set("title", $title);
    }

    public function logout()
    {
        $this->autoRender = false;

        $this->request->getSession()->delete("userId");

        $this->request->getSession()->delete("username");

        $this->request->getSession()->delete("password");

        if (isset($_GET["back_url"])) {
            return $this->redirect($_GET["back_url"]);
        } else {
            return $this->redirect($this->home_url.'/user/login');
        }
    }

    public function registerUser(
        $referralUsername = null,
        $referredPosition = null
    ) {
        $this->request->getSession()->delete("userId");

        return $this->redirect(
            $home_url . "/" . $referralUsername . "/" . $referredPosition
        );
    }
}
