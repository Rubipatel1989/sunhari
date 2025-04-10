<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class WalletsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getTransactionId($length){
    	$finalTransactionId = '';
    	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890ADFVSSsddsf5847';
	    $transactionId = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < $length; $i++) {
	        $n = rand(0, $alphaLength);
	        $transactionId[] = $alphabet[$n];
	    }
	    $impTransactionId = implode($transactionId);
	    $finalTransactionId .= $impTransactionId;
	    $checkTransactionId = $this->find('all', array('conditions' => array('Wallets.transaction_id' => $impTransactionId)))->first();
	    if(!empty($checkTransactionId)){
	    	$finalTransactionId .= $this->getTransactionId($length);
	    }
	    return $finalTransactionId;
    }
}