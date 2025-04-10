<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaymentsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getMonths(){
    	$months = array(
    					'01' 	=> 	'January',
    					'02' 	=> 	'February',
    					'03' 	=> 	'March',
    					'04' 	=> 	'April',
    					'05' 	=> 	'May',
    					'06' 	=> 	'June',
    					'07' 	=> 	'July',
    					'08' 	=> 	'August',
    					'09' 	=> 	'September ',
    					'10' 	=> 	'October',
    					'11' 	=> 	'November',
    					'12' 	=> 	'December'
    				);
    	return $months;
    }
}