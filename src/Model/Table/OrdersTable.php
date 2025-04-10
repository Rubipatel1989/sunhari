<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrdersTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');

        $this->hasMany('Ordereditems')
            ->setForeignKey('order_id')
            ->setDependent(true);
    }

    public function getUniqueOrderId(){

        $orderId = rand(100000000,999999999);

        $checkOrderId = $this->find('all', array('conditions' => array('Orders.order_id' => $orderId)))->count();

        $uniqueOrderId = '';
        if($checkOrderId > 0){

            $uniqueOrderId .= $this->getUniqueUsername();

        }else{

            $uniqueOrderId .= $orderId;

        }

        return $uniqueOrderId;

    }
}