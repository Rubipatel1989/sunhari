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

class PaymentsController extends AppController {

    public function add(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Payments | Add Payment Account Detail';
        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');
        $attachmentsTable = TableRegistry::get('Attachments');

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/
            $postData = $this->request->getData();
            $account_number = $postData['Payment']['account_number'] ?? '';
            $bank_name = $postData['Payment']['bank_name'] ?? '';
            $ifsc_code = $postData['Payment']['ifsc_code'] ?? '';
            $upi_id = $postData['Payment']['upi_id'] ?? '';
            $remark = $postData['Payment']['remark'] ?? '';
            $status = $postData['Payment']['status'] ?? '';
            $attachment_id = $postData['Attachment']['id'][0] ?? '';
            $caption = $postData['Attachment']['caption'][0] ?? '';

            if ($account_number && $bank_name && $ifsc_code && $upi_id && $remark && $status) {
                $payment = $paymentsTable->newEmptyEntity();
                $payment->attachment_id = $attachment_id;
                $payment->account_number = $account_number;
                $payment->bank_name = $bank_name;
                $payment->ifsc_code = $ifsc_code;
                $payment->upi_id = $upi_id;
                $payment->remark = $remark;
                $payment->status = $status;
                if ($paymentsTable->save($payment)) {
                    if ($attachment_id) {
                        $paymentId = $payment->id;
                        $attachment = $attachmentsTable->get($attachment_id);
                        $attachment->reference_id = $paymentId;
                        $attachment->reference_type = 'payment_barcode';
                        $attachment->caption = $caption;
                        $attachmentsTable->save($attachment);
                    }
                    $this->Flash->success(__('Congratulations! Wallet has been added successfully.'));
                    return $this->redirect($this->backend_url.'/payments/index');
                }
            } else {
                $this->Flash->error(__("All fields marked with * are required."));
            }
        }

    }

    public function index(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Payments | Payment Account List';
        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');
        $attachmentsTable = TableRegistry::get('Attachments');

        $join = [
            [
                'table' => 'attachments',
                'alias' => 'Attachments',
                'type' => 'LEFT',
                'conditions' => array('Attachments.id = Payments.attachment_id')
            ]
        ];
        $conditions = ['Payments.status !=' => 2];
        $fields = ['Payments.id', 'Payments.account_number', 'Payments.bank_name', 'Payments.ifsc_code', 'Payments.upi_id', 'Payments.remark', 'Payments.status', 'Attachments.file', 'Attachments.caption'];
        $payments =  $paymentsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->toArray();
        
        $this->set('payments', $payments);
    }

    public function edit($paymentId)
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Payments | Edit Payment Account Detail';
        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');
        $attachmentsTable = TableRegistry::get('Attachments');

        $join = [
            [
                'table' => 'attachments',
                'alias' => 'Attachments',
                'type' => 'LEFT',
                'conditions' => array('Attachments.id = Payments.attachment_id')
            ]
        ];
        $conditions = ['Payments.id' => $paymentId];
        $fields = ['Payments.id', 'Payments.account_number', 'Payments.bank_name', 'Payments.ifsc_code', 'Payments.upi_id', 'Payments.remark', 'Payments.status', 'Attachments.id', 'Attachments.file', 'Attachments.caption'];
        $payment =  $paymentsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->first();
        $this->set('payment', $payment);

        if ($this->request->is('post')) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $postData = $this->request->getData();
            $account_number = $postData['Payment']['account_number'] ?? '';
            $bank_name = $postData['Payment']['bank_name'] ?? '';
            $ifsc_code = $postData['Payment']['ifsc_code'] ?? '';
            $upi_id = $postData['Payment']['upi_id'] ?? '';
            $remark = $postData['Payment']['remark'] ?? '';
            $status = $postData['Payment']['status'] ?? '';
            $attachment_id = $postData['Attachment']['id'][0] ?? '';
            $caption = $postData['Attachment']['caption'][0] ?? '';
            if ($account_number && $bank_name && $ifsc_code && $upi_id && $remark && $status) {
                $payment = $paymentsTable->get($paymentId);
                $payment->attachment_id = $attachment_id;
                $payment->account_number = $account_number;
                $payment->bank_name = $bank_name;
                $payment->ifsc_code = $ifsc_code;
                $payment->upi_id = $upi_id;
                $payment->remark = $remark;
                $payment->status = $status;
                if ($paymentsTable->save($payment)) {
                    if ($attachment_id) {
                        $paymentId = $payment->id;
                        $attachment = $attachmentsTable->get($attachment_id);
                        $attachment->reference_id = $paymentId;
                        $attachment->reference_type = 'payment_barcode';
                        $attachment->caption = $caption;
                        $attachmentsTable->save($attachment);
                    }
                    $this->Flash->success(__('Congratulations! Wallet has been updated successfully.'));
                    return $this->redirect($this->backend_url.'/payments/index');
                }
            } else {
                $this->Flash->error(__("All fields marked with * are required."));
            }
        }
    }

    public function updateStatus($intId, $intStatus)
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect($this->backend_url.'/payments/index');
        }

        if(!isset($intStatus)){
            return $this->redirect($this->backend_url.'/payments/index');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Payment | Update Status';
        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');

        $payment = $paymentsTable->get($intId);
        $payment->status = $intStatus;
        if($paymentsTable->save($payment)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect($this->backend_url.'/payments/index');
        }
        $this->render(false);
    }

    public function delete($intId)
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Payment | Update Status';
        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');

        $payment = $paymentsTable->get($intId);
        $payment->status = 2;
        if($paymentsTable->save($payment)){
            $this->Flash->success(__('Congratulations! Payment details has been deleted successfully.'));
            return $this->redirect($this->backend_url.'/payments/index');
        }
        $this->render(false);
    }

    public function payUserEmi() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Pay User EMI';

        $emisTable = TableRegistry::get("Emis");
        $usersTable = TableRegistry::get("Users");
        $pendingUpgradesTable = TableRegistry::get("PendingUpgrades");
        $walletsTable = TableRegistry::get("Wallets");

        if ($this->request->is('post')) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()['PendingUpgrade']['username'] ?? '';
            $name = $this->request->getData()['PendingUpgrade']['name'] ?? '';
            $package_id = $this->request->getData()['PendingUpgrade']['package_id'] ?? '';
            $amount = $this->request->getData()['PendingUpgrade']['amount'] ?? '';
            $remark = $this->request->getData()['PendingUpgrade']['remark'] ?? 'EMI Amount added by admin.';

            if ($username && $name && $package_id && $amount) {
                $conditions = ['Users.username' => $username];
                $userInfo = $usersTable->find('all', ['conditions' => $conditions])->first();
                if ($userInfo) {
                    $objPendingUpgrade = $pendingUpgradesTable->newEmptyEntity();
                    $objPendingUpgrade->user_id = $userInfo->id;
                    $objPendingUpgrade->added_by = $this->adminUser->id;
                    $objPendingUpgrade->amount = $amount;
                    $objPendingUpgrade->transaction_id = 'Sys'.$walletsTable->getTransactionId(11);
                    $objPendingUpgrade->payment_for = 2;
                    $objPendingUpgrade->package_id = $package_id;
                    $objPendingUpgrade->remark = $remark;
                    $objPendingUpgrade->status = 1;
                    if ($pendingUpgradesTable->save($objPendingUpgrade)){
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
                                $emi->added_by = $this->adminUser->id;
                                $emi->transaction_id = $walletsTable->getTransactionId(11);
                                $emi->amount = $pendingUpgradeInfo->amount;
                                $emi->remark = 'EMI added by admin.';
                                $emisTable->save($emi);
                                $emiId = $emi->id;
                                $usersTable->updateSponsorOnEmiApprove($userInfo->sponsor_id, $pendingUpgradeInfo->amount);
                                $usersTable->payPlanAbCommissionToParents($userInfo->id, $pendingUpgradeInfo->package_id, $emiId, $userInfo->sponsor_id, $pendingUpgradeInfo->amount);

                                $this->Flash->success( __("EMI has been added successfully."));
                                return $this->redirect($this->backend_url.'/payments/pay-user-emi');
                            }
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

    public function pendingPayment() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Pending Payment';

        $pendingUpgradesTable = TableRegistry::get("PendingUpgrades");
        $walletsTable = TableRegistry::get("Wallets");
        $emisTable = TableRegistry::get("Emis");
        $usersTable = TableRegistry::get("Users");

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = PendingUpgrades.user_id"],
            ]
        ];

        $conditions = ["PendingUpgrades.status" => 0];
        $order = ['PendingUpgrades.id' => 'DESC'];
        $fields = ['Users.name', 'Users.username'];
        $pendingUpgrades = $pendingUpgradesTable->find("all", ["fields" => $fields, "join" => $join, "conditions" => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();

        $this->set('pendingUpgrades', $pendingUpgrades);

        if ($this->request->is('post')) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            if (isset($this->request->getData()['btn_reject'])) {
                $id = $this->request->getData()['PendingUpgrade']['id'] ?? '';
                $rejection_remark = $this->request->getData()['PendingUpgrade']['rejection_remark'] ?? '';
                if ($id && $rejection_remark) {
                    $objPendingUpgrades = $pendingUpgradesTable->get($id);
                    $objPendingUpgrades->rejection_remark = $rejection_remark;
                    $objPendingUpgrades->status = 2;
                    if ($pendingUpgradesTable->save($objPendingUpgrades)) {
                        $this->Flash->success(__('Payment has been rejected successfully.'));

                        return $this->redirect($this->backend_url.'/payments/pending-payment');
                    }
                }
            } elseif (isset($this->request->getData()['btn_approve'])) {
                $id = $this->request->getData()['PendingUpgrade']['id'] ?? '';
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
                        if ($pendingUpgradeInfo->payment_for == 1) {
                            $wallet = $walletsTable->newEmptyEntity();
                            $wallet->user_id = $pendingUpgradeInfo->user_id;
                            $wallet->transfer_by = $this->adminUser->id;
                            $wallet->transaction_id = $walletsTable->getTransactionId(11);
                            $wallet->amount = $pendingUpgradeInfo->amount;
                            $wallet->remark = 'Approved submitted amount.';
                            $wallet->status = 0;
                            $walletsTable->save($wallet);
                        } else {
                            $emi = $emisTable->newEmptyEntity();
                            $emi->user_id = $pendingUpgradeInfo->user_id;
                            $emi->sponsor_id = $pendingUpgradeInfo->Users['sponsor_id'];
                            $emi->package_id = $pendingUpgradeInfo->package_id;
                            $emi->added_by = $this->adminUser->id;
                            $emi->transaction_id = $walletsTable->getTransactionId(11);
                            $emi->amount = $pendingUpgradeInfo->amount;
                            $emi->remark = 'Approved submitted amount.';
                            $emisTable->save($emi);
                            $emiId = $emi->id;
                            $conditions = ['Users.id' => $pendingUpgradeInfo->user_id];
                            $userInfo = $usersTable->find('all', ['conditions' => $conditions])->first();
                            if ($userInfo) {
                                $usersTable->updateSponsorOnEmiApprove($userInfo->sponsor_id, $pendingUpgradeInfo->amount);
                                $usersTable->payPlanAbCommissionToParents($userInfo->id, $pendingUpgradeInfo->package_id, $emiId, $userInfo->sponsor_id, $pendingUpgradeInfo->amount);
                            }
                        }
                        $objPendingUpgrades = $pendingUpgradesTable->get($id);
                        $objPendingUpgrades->status = 1;
                        if ($pendingUpgradesTable->save($objPendingUpgrades)) {
                            $this->Flash->success( __("Payment has been approved successfully."));
                            return $this->redirect($this->backend_url.'/payments/pending-payment');
                        }
                    }
                }
            }
        }
    }

    public function paymentHistory() {
        if (!$this->request->getSession()->check('adminUserId')) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title . ' Payment History';

        $pendingUpgradesTable = TableRegistry::get("PendingUpgrades");
        $usersTable = TableRegistry::get("Users");

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = PendingUpgrades.user_id"],
            ]
        ];

        $commonFilter = ["PendingUpgrades.status !=" => 0];
        $paymentForFilter = [];
        $userIdFilter = [];
        $fromDateFilter = [];
        $toDateFilter = [];
        $paymentFor = $_GET['payment_for'] ?? '';
        if ($paymentFor) {
            $paymentForFilter = ['PendingUpgrades.payment_for' => $paymentFor];
        }
        $username = $_GET['username'] ?? '';
        if ($username) {
            $userId = $usersTable->getUserIdByUsername($username);
            $userIdFilter = ['PendingUpgrades.user_id' => $userId];
        }
        $fromDate = $_GET['from_date'] ?? '';
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromDateFilter = ['DATE(PendingUpgrades.created) >=' => $fromDate];
        }

        $toDate = $_GET['to_date'] ?? '';
         if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toDateFilter = ['DATE(PendingUpgrades.created) <=' => $toDate];
        }
        $conditions = array_merge($commonFilter, $paymentForFilter, $userIdFilter, $fromDateFilter, $toDateFilter);
        $order = ['PendingUpgrades.id' => 'DESC'];
        $fields = ['Users.name', 'Users.username'];
        $pendingUpgrades = $pendingUpgradesTable->find("all", ["fields" => $fields, "join" => $join, "conditions" => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();

        $this->set('pendingUpgrades', $pendingUpgrades);
    }
}
