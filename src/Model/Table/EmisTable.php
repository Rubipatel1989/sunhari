<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class EmisTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function addEmi($userId, $sponsorId, $packageId, $addedBy, $amount, $remark, $created = '')
    {
        $walletsTable = TableRegistry::get("Wallets");

        $emi = $this->newEmptyEntity();
        $emi->user_id = $userId;
        $emi->sponsor_id = $sponsorId;
        $emi->package_id = $packageId;
        $emi->added_by = $addedBy;
        $emi->transaction_id = $walletsTable->getTransactionId(11);
        $emi->amount = $amount;
        $emi->remark = $remark;
        if ($created) {
            $emi->created = $created;
            $emi->modified = $created;
        }
        $this->save($emi);

        return $emi->id;
    }

     public function removeEmiByPackageId($packageId)
     {
        $this->deleteAll(["package_id" => $packageId]);
     }
}