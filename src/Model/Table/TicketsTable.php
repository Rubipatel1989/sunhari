<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TicketsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getTicket($length){
    	$finalTicketId = '';
    	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $ticketId = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < $length; $i++) {
	        $n = rand(0, $alphaLength);
	        $ticketId[] = $alphabet[$n];
	    }
	    $impTicketId = implode($ticketId);
	    $finalTicketId .= $impTicketId;
	    $checkTicketId = $this->find('all', array('conditions' => array('Tickets.ticket_id' => $impTicketId)))->first();
	    if(!empty($checkTicketId)){
	    	$finalTicketId .= $this->getTicket($length);
	    }
	    return $finalTicketId;
    }
}