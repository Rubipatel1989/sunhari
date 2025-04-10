<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EpinsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getUniquePin($preFix){

    	$epin = $preFix.rand(100000,999999);

        $checkEpin = $this->find('all', array('conditions' => array('Epins.epin' => $epin)))->count();

        $checkEpin = '';
        if($checkEpin > 0){

            $checkEpin .= $this->getUniquePin();

        }else{

            $checkEpin .= $epin;

        }

        return $checkEpin;
    }

}