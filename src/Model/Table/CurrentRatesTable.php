<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class CurrentRatesTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getCurrentPlanById($planId){

    	$plan = 'N/A';
    	if($planId == 1){

    		$plan = 'Plan One';

    	}
    	elseif($planId == 2){

    		$plan = 'Plan Two';
    		
    	}

    	return $plan;

    }
}