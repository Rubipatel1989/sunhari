<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class PromotionsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');

        $this->hasMany('Coupons')
        	 ->setForeignKey('promotion_id')
             ->setName('Coupons')
             ->setDependent(true);
    }
}