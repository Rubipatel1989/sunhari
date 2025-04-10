<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BillsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
    
    public function getPackageBillDetails($packageId)
    {   
        $conditions = ['Bills.package_id' => $packageId, 'MONTH(Bills.created)' => date('m'), 'YEAR(Bills.created)' => date('Y')];
        $bill = $this->find('all', ['conditions' => $conditions])
        ->select([
            'current_month_spent_amount' => 'SUM(Bills.amount)',
            'total_spent_amount' => '(SELECT SUM(b.amount) FROM bills b WHERE b.package_id = '.$packageId.')'
        ])->first();

        return $bill;
    }
}