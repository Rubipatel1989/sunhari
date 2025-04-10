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

class BillsController extends AppController
{
    public function add()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Bills | Add';
        $this->set('title', $title);

        $billsTable = TableRegistry::get('Bills');
        $usersTable = TableRegistry::get('Users');
        $attachmentsTable = TableRegistry::get('Attachments');
        $packagesTable = TableRegistry::get('Packages');

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $username = $this->request->getData()["Bill"]["username"] ?? '';
            $customer_name = $this->request->getData()["Bill"]["customer_name"] ?? '';
            $package_id = $this->request->getData()["Bill"]["package_id"] ?? '';
            $amount = $this->request->getData()["Bill"]["amount"] ?? '';
            $bank_name = $this->request->getData()["Bill"]["bank_name"] ?? '';
            $account_number = $this->request->getData()["Bill"]["account_number"] ?? '';
            $ifsc_code = $this->request->getData()["Bill"]["ifsc_code"] ?? '';
            $shop_keeper_name = $this->request->getData()["Bill"]["shop_keeper_name"] ?? '';
            $mobile_number = $this->request->getData()["Bill"]["mobile_number"] ?? '';
            $invoice_attachment_id = $this->request->getData()["Bill"]["invoice_attachment_id"][0] ?? '';
            $invoice_attachment_caption = $this->request->getData()["Bill"]["invoice_attachment_id"]['caption'][0] ?? '';
            $products_attachment_id = $this->request->getData()["Bill"]["products_attachment_id"][0] ?? '';
            $products_attachment_caption = $this->request->getData()["Bill"]["products_attachment_id"]['caption'][0] ?? '';
            $cancelled_cheque_qr_attachement_id = $this->request->getData()["Bill"]["cancelled_cheque_qr_attachement_id"][0] ?? '';
            $products_cancelled_cheque_qr_attachement_caption = $this->request->getData()["Bill"]["cancelled_cheque_qr_attachement_id"]['caption'][0] ?? '';

            if (
                $username && $customer_name && $package_id && $amount && $shop_keeper_name && $shop_keeper_name && $invoice_attachment_id && $products_attachment_id && $cancelled_cheque_qr_attachement_id
            ) {
                $conditions = ['Users.username' => $username];
                $fields = ['Users.id', 'Users.sponsor_id'];
                $userInfo = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Customer does not exist in our database."));
                } else {
                    $bill = $billsTable->newEmptyEntity();
                    $bill->user_id = $userInfo->id;
                    $bill->added_by = $this->adminUser->id;
                    $bill->package_id = $package_id;
                    $bill->invoice_attachment_id = $invoice_attachment_id;
                    $bill->products_attachment_id = $products_attachment_id;
                    $bill->cancelled_cheque_qr_attachement_id = $cancelled_cheque_qr_attachement_id;
                    $bill->amount = $amount;
                    $bill->bank_name = $bank_name;
                    $bill->account_number = $account_number;
                    $bill->ifsc_code = $ifsc_code;
                    $bill->shop_keeper_name = $shop_keeper_name;
                    $bill->mobile_number = $mobile_number;
                    $bill->remark = 'Bill added by admin';
                    if ($billsTable->save($bill)) {
                        $billId = $bill->id;
                        $attachment = $attachmentsTable->get($invoice_attachment_id);
                        $attachment->caption = $invoice_attachment_caption;
                        $attachmentsTable->save($attachment);

                        $attachment = $attachmentsTable->get($products_attachment_id);
                        $attachment->caption = $products_attachment_caption;
                        $attachmentsTable->save($attachment);

                        $attachment = $attachmentsTable->get($cancelled_cheque_qr_attachement_id);
                        $attachment->caption = $products_cancelled_cheque_qr_attachement_caption;
                        $attachmentsTable->save($attachment);

                        $conditions = ['Packages.id' => $package_id];
                        $package = $packagesTable->find('all', ['conditions' => $conditions])->first();
                        $bill = $billsTable->getPackageBillDetails($package_id);
                        if ($package->return_amount <= $bill->total_spent_amount) {
                           $package = $packagesTable->get($package_id);
                           $package->status = 1;
                           $packagesTable->save($package);
                        }

                        $this->Flash->success(__("Bill has been added successfully."));
                        return $this->redirect($this->backend_url.'/bills/add');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function pendingBills()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Bills | Pending Bills';
        $this->set('title', $title);

        $billsTable = TableRegistry::get('Bills');
        $usersTable = TableRegistry::get('Users');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Bills.user_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "InvoiceAttachments",
                "type" => "LEFT",
                "conditions" => ["InvoiceAttachments.id = Bills.invoice_attachment_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "ProductAttachments",
                "type" => "LEFT",
                "conditions" => ["ProductAttachments.id = Bills.products_attachment_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "CancelledChequeQRAttachments",
                "type" => "LEFT",
                "conditions" => ["CancelledChequeQRAttachments.id = Bills.cancelled_cheque_qr_attachement_id"],
            ]
        ];
        $conditions = ['Bills.status IS NULL'];
        $fields = ['Users.username', 'Users.name', 'InvoiceAttachments.file', 'InvoiceAttachments.caption', 'ProductAttachments.file', 'ProductAttachments.caption', 'CancelledChequeQRAttachments.file', 'CancelledChequeQRAttachments.caption'];
        $bills = $billsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])
            ->enableAutoFields(true)->toArray();
        
        $this->set('bills', $bills);

        if ($this->request->is('post')) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            if (isset($this->request->getData()['btn_reject'])) {
                $id = $this->request->getData()['Bill']['id'] ?? '';
                $rejection_remark = $this->request->getData()['Bill']['rejection_remark'] ?? '';
                $bill = $billsTable->get($id);
                $bill->status = 2;
                $bill->rejection_remark = $rejection_remark;
                $billsTable->save($bill);
                $this->Flash->success( __("Bill has been rejected successfully."));
                return $this->redirect($this->backend_url.'/bills/pending-bills');
            } elseif (isset($this->request->getData()['btn_approve'])) {
                $id = $this->request->getData()['Bill']['id'] ?? '';
                if ($id) {
                    $bill = $billsTable->get($id);
                    $bill->status = 1;
                    $billsTable->save($bill);

                    $join = [
                            [
                                "table" => "users",
                                "alias" => "Users",
                                "type" => "LEFT",
                                "conditions" => ["Users.id = Bills.user_id"],
                            ]
                        ];
                    $conditions = ['Bills.id' => $id];
                    $fields = ['Users.sponsor_id'];
                    $bill = $billsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->first();
                    if($bill->Users['sponsor_id']) {
                        $usersTable->updateRepurchaseMBToParents($bill->Users['sponsor_id'], $bill->amount);
                        $usersTable->payPlanMbRepurchaseIncomeToParents($bill->user_id, $bill->package_id, $bill->Users['sponsor_id'], $bill->amount);
                    }
                    $this->Flash->success( __("Bill has been approved successfully."));
                    return $this->redirect($this->backend_url.'/bills/pending-bills');
                }
            }
        }
    }

    public function billHistory()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Bills | Bill History';
        $this->set('title', $title);

        $billsTable = TableRegistry::get('Bills');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Bills.user_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "InvoiceAttachments",
                "type" => "LEFT",
                "conditions" => ["InvoiceAttachments.id = Bills.invoice_attachment_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "ProductAttachments",
                "type" => "LEFT",
                "conditions" => ["ProductAttachments.id = Bills.products_attachment_id"],
            ],
            [
                "table" => "attachments",
                "alias" => "CancelledChequeQRAttachments",
                "type" => "LEFT",
                "conditions" => ["CancelledChequeQRAttachments.id = Bills.cancelled_cheque_qr_attachement_id"],
            ]
        ];
        $conditions = ['Bills.status IS NOT NULL'];
        $fields = ['Users.username', 'Users.name', 'InvoiceAttachments.file', 'InvoiceAttachments.caption', 'ProductAttachments.file', 'ProductAttachments.caption', 'CancelledChequeQRAttachments.file', 'CancelledChequeQRAttachments.caption'];
        $bills = $billsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])
            ->enableAutoFields(true)->toArray();
        
        $this->set('bills', $bills);
    }
}
