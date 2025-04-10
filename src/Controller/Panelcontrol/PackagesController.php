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

class PackagesController extends AppController
{
    public function planAb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan AB-18';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $emisTable = TableRegistry::get('Emis');

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            $amount = $this->request->getData()["Package"]["amount"] ?? '';
            $total_amount = $this->request->getData()["Package"]["total_amount"] ?? '';

            if (
                $username && $customer_name && $amount && $total_amount
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $package = $packagesTable->newEmptyEntity();
                    $package->user_id = $userInfo->id;
                    $package->added_by = $this->adminUser->id;
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
                        $emiId = $emisTable->addEmi($userInfo->id, $userInfo->sponsor_id, $packageId, $this->adminUser->id, $amount, 'On plan selection');
                        $usersTable->payPlanAbCommissionToParents($userInfo->id, $packageId, $emiId, $userInfo->sponsor_id, $amount);
                        $usersTable->updateParentTodayBusiness($userInfo->sponsor_id, $amount);
                        $this->Flash->success(__("Plan has been selected successfully."));
                        return $this->redirect($this->backend_url.'/packages/plan-ab');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function removePlanAb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan AB-18';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $emisTable = TableRegistry::get('Emis');

        if ($this->request->is("post")) {
           /* echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            $id = $this->request->getData()["Package"]["id"] ?? '';
            $amount = $this->request->getData()["Package"]["amount"] ?? '';

            if (
                $username && $customer_name && $amount && $id
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $usersTable->updateParentCustomerBusinessOnPackageRemove($userInfo->sponsor_id, $amount);
                    $emisTable->removeEmiByPackageId($id);
                    $usersTable->removePlanCommissionByPackageId($id);
                    $usersTable->updateParentTodayBusinessOnPackageRemove($userInfo->sponsor_id, $amount);
                    $objPackage = $packagesTable->get($id);
                    $packagesTable->delete($objPackage);

                    $this->Flash->success(__("Selected package has been removed successfully."));
                    return $this->redirect($this->backend_url.'/packages/remove-plan-ab');
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function uploadPlanAb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Upload Plan AB-18';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $emisTable = TableRegistry::get('Emis');

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
                            $username = $row[0];
                            $amount = $row[1];
                            $created = $row[2];
                            if (
                                $username && $amount && is_numeric($amount) && $created
                            ) {
                                $total_amount = $amount + (($amount/500)*110); 
                                $conditions = ['Users.username' => $username];
                                $fields = ['Users.id', 'Users.sponsor_id'];
                                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                                if ($userInfo) {
                                    $package = $packagesTable->newEmptyEntity();
                                    $package->user_id = $userInfo->id;
                                    $package->added_by = $this->adminUser->id;
                                    $package->sponsor_id = $userInfo->sponsor_id;
                                    $package->plan_id = 1;
                                    $package->plan_name = 'Plan AB-18';
                                    $package->amount = $amount;
                                    $package->total_amount = $total_amount;
                                    $package->created = $created;
                                    $package->modified = $created;
                                    if ($packagesTable->save($package)) {
                                        $packageId = $package->id;
                                        $objUser = $usersTable->get($userInfo->id);
                                        $objUser->status = 1;
                                        $usersTable->save($objUser);
                                        $usersTable->updateParentCustomerBusiness($userInfo->sponsor_id, $amount);
                                        $emiId = $emisTable->addEmi($userInfo->id, $userInfo->sponsor_id, $packageId, $this->adminUser->id, $amount, 'On plan selection', $created);
                                        $usersTable->payPlanAbCommissionToParents($userInfo->id, $packageId, $emiId, $userInfo->sponsor_id, $amount, $created);
                                        $usersTable->updateParentTodayBusiness($userInfo->sponsor_id, $amount);
                                    }
                                }
                            }
                        }
                    }
                    $this->Flash->success(__("Valid data has been uploaded successfully."));
                    return $this->redirect($this->backend_url.'/packages/upload-plan-ab');
                }
            }
        }
    }

    public function editPlanAb($packageId)
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Edit Plan AB-18';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');
        $emisTable = TableRegistry::get('Emis');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id"]
            ]
        ];
        $conditions = ['Packages.id' => $packageId];
        $fields = ['Packages.id', 'Packages.amount', 'Packages.total_amount', 'Users.name', 'Users.username'];
        $package = $packagesTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->first();
        $this->set('package', $package);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            $amount = $this->request->getData()["Package"]["amount"] ?? '';
            $total_amount = $this->request->getData()["Package"]["total_amount"] ?? '';

            if (
                $username && $customer_name && $amount && $total_amount
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $package = $packagesTable->get($packageId);
                    $package->user_id = $userInfo->id;
                    $package->sponsor_id = $userInfo->sponsor_id;
                    $package->amount = $amount;
                    $package->total_amount = $total_amount;
                    if ($packagesTable->save($package)) {
                        $usersTable->updateParentCustomerBusinessOnUpdateOrDelete($userInfo->sponsor_id, $amount);
                        $usersTable->updateParentCustomerBusiness($userInfo->sponsor_id, $amount);
                        
                        $emiId = $emisTable->addEmi($userInfo->id, $userInfo->sponsor_id, $packageId, $this->adminUser->id, $amount, 'On plan selection');
                        $usersTable->payPlanAbCommissionToParents($userInfo->id, $packageId, $emiId, $userInfo->sponsor_id, $amount);
                        $this->Flash->success(__("Plan has been updated successfully."));
                        return $this->redirect($this->backend_url.'/packages/plan-ab');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function planAbList()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan AB-18 List';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id"]
            ],
            [
                "table" => "users",
                "alias" => "AddedBy",
                "type" => "INNER",
                "conditions" => ["AddedBy.id = Packages.added_by"]
            ]
        ];

        $commonFilter = ['Packages.plan_id' => 1];
        $userIdFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
        $username = $_GET['username'] ?? '';
        if ($username) {
            $userId = $usersTable->getUserIdByUsername($username);
            $userIdFilter = ['Packages.user_id' => $userId];
        }

        $fromDate = $_GET['from_date'] ?? '';
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(Packages.created) >=' => $fromDate];
        }

        $toDate = $_GET['to_date'] ?? '';
         if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(Packages.created) <=' => $toDate];
        }

        $conditions = array_merge($commonFilter, $userIdFilter, $fromDateFilter, $toDateFilter);
        $fields = ['Packages.id', 'Packages.amount', 'Packages.total_amount', 'Packages.created', 'Users.username', 'Users.name', 'AddedBy.username', 'AddedBy.name'];
        $packages = $packagesTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
    }

    public function planMb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan MB';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            $amount = $this->request->getData()["Package"]["amount"] ?? 0;
            $number_of_month = $this->request->getData()["Package"]["number_of_month"] ?? 16;
            $return_amount = $this->request->getData()["Package"]["return_amount"] ??  ((($amount*10)/100)*$number_of_month);

            if (
                $username && $customer_name && $amount && $return_amount && $number_of_month
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $package = $packagesTable->newEmptyEntity();
                    $package->user_id = $userInfo->id;
                    $package->added_by = $this->adminUser->id;
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
                        $this->Flash->success(__("Plan has been associated with user successfully."));
                        return $this->redirect($this->backend_url.'/packages/plan-mb');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function removePlanMb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan MB';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Package"]["username"] ?? '';
            $customer_name = $this->request->getData()["Package"]["customer_name"] ?? '';
            $id = $this->request->getData()["Package"]["id"] ?? 0;
            $amount = $this->request->getData()["Package"]["amount"] ?? 0;

            if (
                $username && $customer_name && $id && $amount
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $usersTable->updateParentCustomerBusinessOnPackageRemove($userInfo->sponsor_id, $amount);
                    $usersTable->removePlanCommissionByPackageId($id);
                    $usersTable->updateParentTodayBusinessOnPackageRemove($userInfo->sponsor_id, $amount);
                    $objPackage = $packagesTable->get($id);
                    $packagesTable->delete($objPackage);
                    $this->Flash->success(__("Selected package has been removed successfully."));
                    return $this->redirect($this->backend_url.'/packages/remove-plan-mb');
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function uploadPlanMb()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Upload Plan MB';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');

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
                            $username = $row[0];
                            $amount = $row[1];
                            $created = $row[2];
                            $number_of_month = 16;
                            if (
                                $username && $amount && $created && $number_of_month
                            ) {
                                $return_amount = (($amount*10)/100)*$number_of_month;
                                $conditions = ['Users.username' => $username];
                                $fields = ['Users.id', 'Users.sponsor_id'];
                                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                                if ($userInfo) {
                                    $package = $packagesTable->newEmptyEntity();
                                    $package->user_id = $userInfo->id;
                                    $package->added_by = $this->adminUser->id;
                                    $package->sponsor_id = $userInfo->sponsor_id;
                                    $package->plan_id = 2;
                                    $package->plan_name = 'Plan MB';
                                    $package->amount = $amount;
                                    $package->return_amount = $return_amount;
                                    $package->number_of_month = $number_of_month;
                                    $package->created = $created;
                                    $package->modified = $created;
                                    if ($packagesTable->save($package)) {
                                        $packageId = $package->id;
                                        $objUser = $usersTable->get($userInfo->id);
                                        $objUser->status = 1;
                                        $usersTable->save($objUser);
                                        $usersTable->updateParentCustomerBusiness($userInfo->sponsor_id, $amount);
                                        $usersTable->payPlanMbCommissionToParents($userInfo->id, $packageId, $userInfo->sponsor_id, $amount, $created);
                                        $usersTable->updateParentTodayBusiness($userInfo->sponsor_id, $amount);
                                    }
                                }
                            }
                        }
                    }
                    $this->Flash->success(__("Valid data has been uploaded successfully."));
                    return $this->redirect($this->backend_url.'/packages/plan-mb');
                }
            }
        }
    }

    public function planMbList()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Plan MB List';
        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $usersTable = TableRegistry::get('Users');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id"]
            ],
            [
                "table" => "users",
                "alias" => "AddedBy",
                "type" => "INNER",
                "conditions" => ["AddedBy.id = Packages.added_by"]
            ]
        ];

        $commonFilter = ['Packages.plan_id' => 2];
        $userIdFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
        $username = $_GET['username'] ?? '';
        if ($username) {
            $userId = $usersTable->getUserIdByUsername($username);
            $userIdFilter = ['Packages.user_id' => $userId];
        }

        $fromDate = $_GET['from_date'] ?? '';
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(Packages.created) >=' => $fromDate];
        }

        $toDate = $_GET['to_date'] ?? '';
         if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(Packages.created) <=' => $toDate];
        }

        $conditions = array_merge($commonFilter, $userIdFilter, $fromDateFilter, $toDateFilter);
        $fields = ['Packages.id', 'Packages.amount', 'Packages.return_amount', 'Packages.number_of_month', 'Packages.created',  'Users.username', 'Users.name', 'AddedBy.username', 'AddedBy.name'];
        $packages = $packagesTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
    }

    public function promotion()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Promotion';
        $this->set('title', $title);

        $promotionsTable = TableRegistry::get('Promotions');
        $couponsTable = TableRegistry::get('Coupons');
        $usersTable = TableRegistry::get('Users');
        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()['Promotion']['username'] ?? '';
            $customer_name = $this->request->getData()['Promotion']['customer_name'] ?? '';
            $plan_id = $this->request->getData()['Promotion']['plan_id'] ?? '';

            if ($username && $customer_name && $plan_id) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $amount = $this->userData->getPlanAmountById($plan_id);
                    $promotion = $promotionsTable->newEmptyEntity();
                    $promotion->user_id = $userInfo->id;
                    $promotion->added_by = $this->adminUser->id;
                    $promotion->plan_id = $plan_id;
                    $promotion->plan_amount = $amount;
                    if ($promotionsTable->save($promotion)) {
                        $promotionId = $promotion->id;
                        $allowedCouponsCount = $this->userData->getAllowedCouponsCount($amount);
                        $remainCoupons = $allowedCouponsCount;
                        $planPrefix = $this->userData->getPlanPrefixById($plan_id);
                        $couponsTable->generateCoupons($userInfo->id, $promotionId, $remainCoupons, $planPrefix);
                        $usersTable->payPromotionCommissionToParents($userInfo->id, $promotionId, $userInfo->sponsor_id, $amount);
                        $this->Flash->success(__("Promotion has been added successfully."));
                        return $this->redirect($this->backend_url.'/packages/promotion');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function promotionList()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Promotion';
        $this->set('title', $title);

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
        $commonFilter = [];
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

    public function couponDetail($couponId)
    {
        $this->viewBuilder()->setLayout('ajax');
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Packages | Coupon Details';
        $this->set('title', $title);

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
}
