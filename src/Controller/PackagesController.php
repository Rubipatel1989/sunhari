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

class PackagesController extends AppController
{
    public function planAb()
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
        $title = $prefix_title . " Packages | Plan AB-18";
        $this->set("title", $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $emisTable = TableRegistry::get('Emis');
        $walletsTable = TableRegistry::get('Wallets');

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
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            if ($this->user->role_id == 3) {
                $username = $this->user->username;
                $customer_name = $this->user->name;
            }
            $amount = $this->request->getData()["Package"]["amount"] ?? '';
            $total_amount = $this->request->getData()["Package"]["total_amount"] ?? '';

            if (
                $username && $customer_name && $amount && $total_amount
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if ($wallet->total_wallet_amount < $total_amount) {
                    $this->Flash->error(__("Your wallet balance is less than Rs ".number_format($total_amount, 2)));
                } elseif (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $package = $packagesTable->newEmptyEntity();
                    $package->user_id = $userInfo->id;
                    $package->added_by = $this->user->id;
                    $package->sponsor_id = $userInfo->sponsor_id;
                    $package->plan_id = 1;
                    $package->plan_name = 'Plan AB-18';
                    $package->amount = $amount;
                    $package->total_amount = $total_amount;
                    if ($packagesTable->save($package)) {
                        $packageId = $package->id;
                        $objUser = $usersTable->get($userInfo->id);
                        $objUser->status = 1;
                        $usersTable->save($objUser);

                        $usersTable->updateParentCustomerBusiness($userInfo->sponsor_id, $amount);
                        $emiId = $emisTable->addEmi($userInfo->id, $userInfo->sponsor_id, $packageId, $this->user->id, $amount, 'On plan selection');
                        $usersTable->payPlanAbCommissionToParents($userInfo->id, $packageId, $emiId, $userInfo->sponsor_id, $amount);
                        $usersTable->updateParentTodayBusiness($userInfo->sponsor_id, $amount);

                        $objWallet = $walletsTable->newEmptyEntity();
                        $objWallet->user_id = $this->user->id;
                        $objWallet->transfer_by = $this->user->id;
                        $objWallet->transaction_id = $walletsTable->getTransactionId(11);
                        $objWallet->amount = '-'.$total_amount;
                        $objWallet->remark = 'Used in buy Plan AB-18 package';
                        $objWallet->status = 0;
                        $walletsTable->save($objWallet);

                        $this->Flash->success(__("Plan has been selected successfully."));
                        return $this->redirect($this->home_url.'/my-account/packages/plan-ab');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function planAbList()
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
        $title = $prefix_title . " Packages | Plan AB-18 List";
        $this->set("title", $title);

        $packagesTable = TableRegistry::get('Packages');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id"]
            ]
        ];

        $conditions = ['Packages.plan_id' => 1, 'Packages.added_by' => $this->user->id];
        if ($this->user->role_id == 3) {
            $conditions = ['Packages.plan_id' => 1, 'Packages.user_id' => $this->user->id];
        }

        $fields = ['Packages.id', 'Packages.amount', 'Packages.total_amount', 'Packages.created', 'Users.username', 'Users.name'];
        $packages = $packagesTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
    }

    public function planMb()
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
        $title = $prefix_title . " Packages | Plan MB";
        $this->set("title", $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $walletsTable = TableRegistry::get('Wallets');

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
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            if ($this->user->role_id == 3) {
                $username = $this->user->username;
                $customer_name = $this->user->name;
            }
            $amount = $this->request->getData()["Package"]["amount"] ?? 0;
            $number_of_month = $this->request->getData()["Package"]["number_of_month"] ?? 16;
            $return_amount = $this->request->getData()["Package"]["return_amount"] ??  ((($amount*10)/100)*$number_of_month);

            if (
                $username && $customer_name && $amount && $return_amount && $number_of_month
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if ($wallet->total_wallet_amount < $amount) {
                    $this->Flash->error(__("Your wallet balance is less than Rs ".number_format($amount, 2)));
                } elseif (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $package = $packagesTable->newEmptyEntity();
                    $package->user_id = $userInfo->id;
                    $package->added_by = $this->user->id;
                    $package->sponsor_id = $userInfo->sponsor_id;
                    $package->plan_id = 2;
                    $package->plan_name = 'Plan MB';
                    $package->amount = $amount;
                    $package->return_amount = $return_amount;
                    $package->number_of_month = $number_of_month;
                    if ($packagesTable->save($package)) {
                        $packageId = $package->id;
                        $objUser = $usersTable->get($userInfo->id);
                        $objUser->status = 1;
                        $usersTable->save($objUser);
                        
                        $usersTable->updateParentCustomerBusiness($userInfo->sponsor_id, $amount);
                        $usersTable->payPlanMbCommissionToParents($userInfo->id, $packageId, $userInfo->sponsor_id, $amount);
                        $usersTable->updateParentTodayBusiness($userInfo->sponsor_id, $amount);

                        $objWallet = $walletsTable->newEmptyEntity();
                        $objWallet->user_id = $this->user->id;
                        $objWallet->transfer_by = $this->user->id;
                        $objWallet->transaction_id = $walletsTable->getTransactionId(11);
                        $objWallet->amount = '-'.$amount;
                        $objWallet->remark = 'Used in buy Plan MB package';
                        $objWallet->status = 0;
                        $walletsTable->save($objWallet);

                        $this->Flash->success(__("Plan has been selected successfully."));
                        return $this->redirect($this->home_url.'/my-account/packages/plan-mb');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function planMbList()
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
        $title = $prefix_title . " Packages | Plan MB List";
        $this->set("title", $title);

        $packagesTable = TableRegistry::get('Packages');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id"]
            ]
        ];

        $conditions = ['Packages.plan_id' => 2, 'Packages.added_by' => $this->user->id];
        if ($this->user->role_id == 3) {
            $conditions = ['Packages.plan_id' => 2, 'Packages.user_id' => $this->user->id];
        }

        $fields = ['Packages.id', 'Packages.amount', 'Packages.return_amount', 'Packages.number_of_month', 'Packages.created',  'Users.username', 'Users.name'];
        $packages = $packagesTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
    }

    public function planAbEmiHistory($packageId)
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
        $title = $prefix_title . " Packages | Plan AB-18 EMI History";
        $this->set("title", $title);

        $emisTable = TableRegistry::get('Emis');
        $packagesTable = TableRegistry::get('Packages');

        $conditions = ['Emis.package_id' => $packageId];
        $totalPaidEmi = $emisTable->find('all', ['conditions' => $conditions])->count();
        $this->set('totalPaidEmi', $totalPaidEmi);

        $conditions = ['Emis.package_id' => $packageId];
        $emis = $emisTable->find('all', ['conditions' => $conditions])->toArray();
        $this->set('emis', $emis);

        $conditions = ['Packages.id' => $packageId];
        $package = $packagesTable->find('all', ['conditions' => $conditions])->first();
        $this->set('package', $package);
    }

    public function planMbEmiHistory($packageId)
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
        $title = $prefix_title . " Packages | Plan MB Bill History";
        $this->set("title", $title);

        $billsTable = TableRegistry::get('Bills');
        $packagesTable = TableRegistry::get('Packages');


        $conditions = ['Bills.package_id' => $packageId];
        $bills = $billsTable->find('all', ['conditions' => $conditions])->toArray();
        $this->set('bills', $bills);

        $conditions = ['Packages.id' => $packageId];
        $package = $packagesTable->find('all', ['conditions' => $conditions])->first();
        $this->set('package', $package);
    }

    public function promotion()
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
        $title = $prefix_title . " Packages | Promotion";
        $this->set("title", $title);

        $promotionsTable = TableRegistry::get('Promotions');
        $couponsTable = TableRegistry::get('Coupons');
        $usersTable = TableRegistry::get('Users');
        $walletsTable = TableRegistry::get('Wallets');

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
            if ($this->user->role_id == 2) {
                $username = $this->request->getData()['Promotion']['username'] ?? '';
                $customer_name = $this->request->getData()['Promotion']['customer_name'] ?? '';
            } else {
                 $username = $this->request->getData()['Promotion']['username'] ?? $this->user->username;
            }
            $plan_id = $this->request->getData()['Promotion']['plan_id'] ?? '';

            if ($username && $plan_id) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                
                $amountWithGst = $this->userData->getPlanAmountWithGSTById($plan_id);
                if ($wallet->total_wallet_amount < $amountWithGst) {
                    $this->Flash->error(__("Your wallet balance is less than Rs ".number_format($amountWithGst, 2)));
                } elseif (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $amount = $this->userData->getPlanAmountById($plan_id);
                    $promotion = $promotionsTable->newEmptyEntity();
                    $promotion->user_id = $userInfo->id;
                    $promotion->added_by = $this->user->id;
                    $promotion->plan_id = $plan_id;
                    $promotion->plan_amount = $amount;
                    if ($promotionsTable->save($promotion)) {
                        $promotionId = $promotion->id;
                        $allowedCouponsCount = $this->userData->getAllowedCouponsCount($amount);
                        $remainCoupons = $allowedCouponsCount;
                        $planPrefix = $this->userData->getPlanPrefixById($plan_id);
                        $couponsTable->generateCoupons($userInfo->id, $promotionId, $remainCoupons, $planPrefix);
                        $usersTable->payPromotionCommissionToParents($userInfo->id, $promotionId, $userInfo->sponsor_id, $amount);
                        
                        $objWallet = $walletsTable->newEmptyEntity();
                        $objWallet->user_id = $this->user->id;
                        $objWallet->transfer_by = $this->user->id;
                        $objWallet->transaction_id = $walletsTable->getTransactionId(11);
                        $objWallet->amount = '-'.$amountWithGst;
                        $objWallet->remark = 'Used in buy Promotion';
                        $objWallet->status = 0;
                        $walletsTable->save($objWallet);
                        $this->Flash->success(__("Promotion has been added successfully."));
                        return $this->redirect($this->home_url.'/my-account/packages/promotion');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function promotionList()
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
        $title = $prefix_title . " Packages | Promotion List";
        $this->set("title", $title);

        $promotionsTable = TableRegistry::get('Promotions');
        $usersTable = TableRegistry::get('Users');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Promotions.user_id"]
            ]
        ];
        $commonFilter = ['Promotions.user_id' => $this->user->id];
        if ($this->user->role_id == 2) {
            $commonFilter = ['Promotions.added_by' => $this->user->id];
        }
        $userIdFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
        $username = $_GET['username'] ?? '';
        if ($username) {
            $userId = $usersTable->getUserIdByUsername($username);
            $userIdFilter = ['Promotions.user_id' => $userId];
        }

        $fromDate = $_GET['from_date'] ?? '';
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(Promotions.created) >=' => $fromDate];
        }

        $toDate = $_GET['to_date'] ?? '';
         if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(Promotions.created) <=' => $toDate];
        }

        $conditions = array_merge($commonFilter, $userIdFilter, $fromDateFilter, $toDateFilter);
        $fields = ['Users.username', 'Users.name'];
        $promotions = $promotionsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])
        ->contain(['Coupons'])->enableAutoFields(true)->toArray();

        $this->set('promotions', $promotions);

        $template = 'promotion_list';
        if ($this->user->role_id == 3) {
            $template = 'customer_promotion_list';
        }
        $this->render($template);
    }

    public function couponDetail($couponId)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout('ajax');
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Packages | Coupon Details";
        $this->set("title", $title);

        $couponsTable = TableRegistry::get('Coupons');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Coupons.user_id"]
            ],
            [
                "table" => "users",
                "alias" => "Sponsors",
                "type" => "LEFT",
                "conditions" => ["Sponsors.id = Users.sponsor_id"]
            ],
            [
                "table" => "promotions",
                "alias" => "Promotions",
                "type" => "INNER",
                "conditions" => ["Promotions.id = Coupons.promotion_id"]
            ]
        ];

        $conditions = ['Coupons.id' => $couponId];
        $fields = ['Users.username', 'Users.name', 'Users.contact_number', 'Sponsors.username', 'Sponsors.name', 'Promotions.plan_id', 'Promotions.plan_amount'];
        $couponInfo = $couponsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->first();
        $this->set('couponInfo', $couponInfo);
    }

    public function customerCouponList()
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
        $title = $prefix_title . " Packages | Customer Coupon List";
        $this->set("title", $title);

        $usersTable = TableRegistry::get('Users');
        $promotionsTable = TableRegistry::get('Promotions');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Promotions.user_id"]
            ]
        ];
        $commonFilter = ['Users.sponsor_id' => $this->user->id];
        $userIdFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
        $username = $_GET['username'] ?? '';
        if ($username) {
            $userId = $usersTable->getUserIdByUsername($username);
            $userIdFilter = ['Promotions.user_id' => $userId];
        }

        $fromDate = $_GET['from_date'] ?? '';
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(Promotions.created) >=' => $fromDate];
        }

        $toDate = $_GET['to_date'] ?? '';
         if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(Promotions.created) <=' => $toDate];
        }

        $conditions = array_merge($commonFilter, $userIdFilter, $fromDateFilter, $toDateFilter);
        $fields = ['Users.username', 'Users.name'];
        $promotions = $promotionsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])
        ->contain(['Coupons'])->enableAutoFields(true)->toArray();

        $this->set('promotions', $promotions);
    }
}
