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

class LesarsController extends AppController
{

    public function addLesar()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Manage Lesar : Add Lesar";

        $this->set("title", $title);

        $lesarsTable = TableRegistry::get("Lesars");
        $usersTable = TableRegistry::get("Users");

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $username = $this->request->getData()["Lesar"]["username"] ?? NULL;
            $name = $this->request->getData()["Lesar"]["name"] ?? NULL;
            $payment_type = $this->request->getData()["Lesar"]["payment_type"] ?? NULL;
            $payment_mode = $this->request->getData()["Lesar"]["payment_mode"] ?? NULL;
            $bank_name = $this->request->getData()["Lesar"]["bank_name"] ?? NULL;
            $account_number = $this->request->getData()["Lesar"]["account_number"] ?? NULL;
            $ifsc_code = $this->request->getData()["Lesar"]["ifsc_code"] ?? NULL;
            $transaction_id = $this->request->getData()["Lesar"]["transaction_id"] ?? NULL;
            $voucher_code = $this->request->getData()["Lesar"]["voucher_code"] ?? NULL;
            $amount = $this->request->getData()["Lesar"]["amount"] ?? NULL;
            $remark = $this->request->getData()["Lesar"]["remark"] ?? NULL;

            if (
                !empty($username) &&
                !empty($payment_type) &&
                !empty($payment_mode) &&
                !empty($amount) &&
                !empty($remark)
            ) {

                $userInfo = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.username" => $username],
                    ])->first();

                
                if (!$userInfo) {
                    $this->Flash->error(
                        __(
                            "Entered username does not exist in our database"
                        )
                    );
                }  else {

                    if($payment_type == 'debit') {
                        $amount = '-'.$amount;
                    }
                    $lesar = $lesarsTable->newEmptyEntity();
                    $lesar->added_by = $this->adminUser->id;
                    $lesar->user_id = $userInfo->id;
                    $lesar->payment_type  = $payment_type;
                    $lesar->payment_mode = $payment_mode;
                    $lesar->bank_name = $bank_name;
                    $lesar->account_number = $account_number;
                    $lesar->ifsc_code = $ifsc_code;
                    $lesar->transaction_id = $transaction_id;
                    $lesar->voucher_code = $voucher_code;
                    $lesar->amount = $amount;
                    $lesar->remark = $remark;

                    if ($lesarsTable->save($lesar)) {
                        $this->Flash->success(
                            __(
                                "Congratulations Lesar has been added successfully."
                            )
                        );

                        return $this->redirect($this->backend_url.'/lesars/add-lesar');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function lesarList()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title . " Manage Lesar : Lesar List";
        $this->set("title", $title);

        $lesarsTable = TableRegistry::get("Lesars");
        
        $commonCondtion = [];
        $username = $_GET['username'] ?? '';
        $joinConditions = ["Users.id = Lesars.user_id"];
        if ($username) {
            $joinConditions = ["Users.id = Lesars.user_id AND Users.username = '".$username."'"];
        }
        $fromDate = $_GET['from_date'] ?? '';
        $fromConditions = [];
        if ($fromDate) {
            $fromDate = date('Y-m-d', strtotime($fromDate));
            $fromConditions = ['DATE(Lesars.created) >=' => $fromDate];
        }
        $toDate = $_GET['to_date'] ?? '';
        $toConditions = [];
        if ($toDate) {
            $toDate = date('Y-m-d', strtotime($toDate));
            $toConditions = ['DATE(Lesars.created) <=' => $toDate];
        }
        $conditions = array_merge($commonCondtion, $fromConditions, $toConditions);
        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => $joinConditions
            ]
        ];
        $order = ['Lesars.id' => 'DESC'];
        $fields = ['Users.username', 'Users.name'];
        $lesars = $lesarsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();
        $this->set('lesars', $lesars);
    }
}
