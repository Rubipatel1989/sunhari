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

class UserPaymentsController extends AppController
{
    public function makePayment()
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
        $title = $prefix_title . " User Payments : Make Payment";
        $this->set("title", $title);

        $paymentsTable = TableRegistry::get('Payments');
        $pendingUpgradesTable = TableRegistry::get('PendingUpgrades');
        $packagesTable = TableRegistry::get('Packages');

        $join = [
            [
                'table' => 'attachments',
                'alias' => 'Attachments',
                'type' => 'LEFT',
                'conditions' => array('Attachments.id = Payments.attachment_id')
            ]
        ];
        $conditions = ['Payments.status' => 1];
        $fields = ['Payments.id', 'Payments.account_number', 'Payments.bank_name', 'Payments.ifsc_code', 'Payments.upi_id', 'Payments.remark', 'Payments.status', 'Attachments.id', 'Attachments.file', 'Attachments.caption'];
        $order = ['Payments.id' => 'DESC'];
        $limit = 1;
        $payment =  $paymentsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order, 'limit' => $limit])->first();
        $this->set('payment', $payment);

        $conditions = ['Packages.user_id' => $this->user->id, 'Packages.plan_id' => 1];
        $fields = ['Packages.id', 'Packages.plan_name'];
        $packages = $packagesTable->find('all', ['fields' =>$fields, 'conditions' => $conditions])->toArray();
        $this->set('packages', $packages);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $amount = $this->request->getData()['PendingUpgrade']['amount'] ?? '';
            $transaction_id = $this->request->getData()['PendingUpgrade']['transaction_id'] ?? '';
            $payment_for = $this->request->getData()['PendingUpgrade']['payment_for'] ?? '';
            $package_id = $this->request->getData()['PendingUpgrade']['package_id'] ?? '';
            $remark = $this->request->getData()['PendingUpgrade']['remark'] ?? '';

            if ($amount && $transaction_id && $payment_for) {
                $conditions = ["PendingUpgrades.user_id" => $this->user->id, "PendingUpgrades.status" => 0];
                $pendingUpgradeInfo = $pendingUpgradesTable->find("all", ["conditions" => $conditions])->count();
                if ($pendingUpgradeInfo) {
                    $this->Flash->error(__("You can not submit your payment because your old payment is in pending status."));
                } else {
                    $objPendingUpgrade = $pendingUpgradesTable->newEmptyEntity();
                    $objPendingUpgrade->user_id = $this->user->id;
                    $objPendingUpgrade->added_by = $this->user->id;
                    $objPendingUpgrade->amount = $amount;
                    $objPendingUpgrade->transaction_id = $transaction_id;
                    $objPendingUpgrade->payment_for = $payment_for;
                    $objPendingUpgrade->package_id = $package_id;
                    $objPendingUpgrade->remark = $remark;
                    $objPendingUpgrade->status = 0;
                    if ($pendingUpgradesTable->save($objPendingUpgrade)){
                        $this->Flash->success( __("Your payment has been submitted successfully. It will be processed within 24 hrs."));
                        return $this->redirect($this->home_url.'/my-account/user-payments/make-payment');

                    }
                }
            }
        }
    }

    public function payUserEmi() {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " User Payments : Pay User EMI";
        $this->set("title", $title);

        $emisTable = TableRegistry::get("Emis");
        $usersTable = TableRegistry::get("Users");
        $pendingUpgradesTable = TableRegistry::get("PendingUpgrades");
        $walletsTable = TableRegistry::get("Wallets");

        $conditions = ['Wallets.user_id' => $this->user->id];
        $wallet = $walletsTable->find('all', ['conditions' => $conditions])
        ->select([
            'total_wallet_amount' => 'SUM(Wallets.amount)'
        ])->first();
        $this->set('wallet', $wallet);

        if ($this->request->is('post')) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $defaultRemark = 'EMI Amount by customer : '.$this->user->username;
            $emiRemark = 'EMI pay by customer : '.$this->user->username;
            if($this->user->role_id == 2){
                $defaultRemark = 'EMI Amount by agent : '.$this->user->username;
                $emiRemark = 'EMI pay by agent : '.$this->user->username;
            }
            $username = $this->request->getData()['PendingUpgrade']['username'] ?? '';
            $name = $this->request->getData()['PendingUpgrade']['name'] ?? '';
            $package_id = $this->request->getData()['PendingUpgrade']['package_id'] ?? '';
            $amount = $this->request->getData()['PendingUpgrade']['amount'] ?? '';
            $remark = $this->request->getData()['PendingUpgrade']['remark'] ?? $defaultRemark;
            $otp = $this->request->getData()['PendingUpgrade']['otp'] ?? '';
            if ($this->request->getSession()->read('package_id')) {
                $package_id = $this->request->getSession()->read('package_id');
            }
            
            if ($username && $name && $package_id && $amount) {
                $conditions = ['Users.username' => $username];
                $userInfo = $usersTable->find('all', ['conditions' => $conditions])->first();
                if ($userInfo) {
                    if ($wallet->total_wallet_amount < $amount) {
                        $this->Flash->error(__("You don't have sufficient balance in your wallet."));
                    } else {
                        if (!$this->request->getSession()->check("emi_otp"))
                        {
                            $this->request->getSession()->write("package_id", $package_id);
                            $randOtp = rand(123456, 999999);
                            $this->request->getSession()->write("emi_otp", $randOtp);
                            $templateId = '1707173271185228935';
                            $template = "".$randOtp." is OTP for your EMI amount Rs.".$amount." OTP valid for 10 minutes. Do not share this OTP with anyone. DAULAT PRIDE";
                            $usersTable->sendSMS($this->user->contact_number, $templateId, $template);
                            $this->Flash->success(
                                    __(
                                        "Please enter OTP that has been sent to your regisered mobile number."
                                    )
                                );
                        } elseif(
                            $this->request->getSession()->check("emi_otp")
                            && $this->request->getSession()->read('emi_otp') == $otp
                        ) {
                            $objPendingUpgrade = $pendingUpgradesTable->newEmptyEntity();
                            $objPendingUpgrade->user_id = $userInfo->id;
                            $objPendingUpgrade->added_by = $this->user->id;
                            $objPendingUpgrade->amount = $amount;
                            $objPendingUpgrade->transaction_id = 'Sys'.$walletsTable->getTransactionId(11);
                            $objPendingUpgrade->payment_for = 2;
                            $objPendingUpgrade->package_id = $package_id;
                            $objPendingUpgrade->remark = $remark;
                            $objPendingUpgrade->status = 1;
                            if ($pendingUpgradesTable->save($objPendingUpgrade)) {
                                $id = $objPendingUpgrade->id;
                                if ($id) {
                                    $join = [
                                        [
                                            "table" => "users",
                                            "alias" => "Users",
                                            "type" => "INNER",
                                            "conditions" => ["Users.id = PendingUpgrades.user_id"]
                                        ]
                                    ];
                                    $conditions = ["PendingUpgrades.id" => $id];
                                    $fields = ['Users.sponsor_id'];
                                    $pendingUpgradeInfo = $pendingUpgradesTable->find("all", ['fields' => $fields, 'join' => $join, "conditions" => $conditions])->enableAutoFields(true)->first();
                                    if ($pendingUpgradeInfo) {
                                        $emi = $emisTable->newEmptyEntity();
                                        $emi->user_id = $pendingUpgradeInfo->user_id;
                                        $emi->sponsor_id = $pendingUpgradeInfo->Users['sponsor_id'];
                                        $emi->package_id = $pendingUpgradeInfo->package_id;
                                        $emi->added_by = $this->user->id;
                                        $emi->transaction_id = $walletsTable->getTransactionId(11);
                                        $emi->amount = $pendingUpgradeInfo->amount;
                                        $emi->remark = $emiRemark;
                                        $emisTable->save($emi);
                                        $emiId = $emi->id;
                                        $usersTable->updateSponsorOnEmiApprove($userInfo->sponsor_id, $pendingUpgradeInfo->amount);
                                        $usersTable->payPlanAbCommissionToParents($userInfo->id, $pendingUpgradeInfo->package_id, $emiId, $userInfo->sponsor_id, $pendingUpgradeInfo->amount);

                                        $objWallet = $walletsTable->newEmptyEntity();
                                        $objWallet->user_id = $this->user->id;
                                        $objWallet->transfer_by = $this->user->id;
                                        $objWallet->transaction_id = $walletsTable->getTransactionId(11);
                                        $objWallet->amount = '-'.$amount;
                                        $objWallet->remark = 'Used in EMI Pay';
                                        $objWallet->status = 0;
                                        $walletsTable->save($objWallet);
                                        $this->request->getSession()->delete('package_id');
                                        $this->request->getSession()->delete('emi_otp');

                                        $this->Flash->success( __("EMI has been added successfully."));
                                        return $this->redirect($this->home_url.'/my-account/user-payments/pay-user-emi');
                                    }
                                }
                            }
                        } else {
                            $this->request->getSession()->write("package_id", $package_id);
                            $this->Flash->error(
                                __(
                                    "Wrong OTP entered. Please enter correct OTP."
                                )
                            );
                        }
                    }
                }  else {
                    $this->Flash->error(__("Wrong username."));
                }
            } else {
                $this->Flash->error(__("All fields marked with * are required."));
            }
        }
    }

    public function paymentHistory()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(__("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " User Payments : Payment History";
        $this->set("title", $title);

        $pendingUpgradesTable = TableRegistry::get("PendingUpgrades");

        $conditions = ["PendingUpgrades.user_id" => $this->user->id];
        $order = ['PendingUpgrades.id' => 'DESC'];
        $pendingUpgrades = $pendingUpgradesTable->find("all", ["conditions" => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();

        $this->set("pendingUpgrades", $pendingUpgrades);
    }

    public function walletHistory()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(__("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " User Payments : Wallet History";
        $this->set("title", $title);

        $walletsTable = TableRegistry::get("Wallets");

        $conditions = ["Wallets.user_id" => $this->user->id];
        $order = ['Wallets.id' => 'DESC'];
        $wallets = $walletsTable->find("all", ["conditions" => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();

        $this->set("wallets", $wallets);

        $totalWalletInfo = $walletsTable->find("all", ["conditions" => $conditions])
        ->select([
            'total_wallets_amount' => 'SUM(Wallets.amount)'
        ])->first();

        $this->set("totalWalletInfo", $totalWalletInfo);
    }

    public function emiHistory()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(__("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " User Payments : EMI History";
        $this->set("title", $title);

        $emisTable = TableRegistry::get("Emis");

        $join = [
            [
                'table' => 'users',
                'alias' => 'Users',
                'type' => 'LEFT',
                'conditions' => array('Users.id = Emis.user_id')
            ]
        ];

        $conditions = ["Emis.user_id" => $this->user->id];
        if ($this->user->role_id == 2) {
            $conditions = ["Emis.added_by" => $this->user->id];
        }
        $order = ['Emis.id' => 'DESC'];
        $fields = ['Users.username', 'Users.name'];
        $emis = $emisTable->find("all", ["fields" => $fields, "join" => $join, "conditions" => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();
        $this->set("emis", $emis);

        $totalEmiInfo = $emisTable->find("all", ["conditions" => $conditions])
        ->select([
            'total_emi_amount' => 'SUM(Emis.amount)'
        ])->first();

        $this->set("totalEmiInfo", $totalEmiInfo);
    }
}
