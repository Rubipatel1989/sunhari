<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class SitesTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');

        $this->hasMany('Emis')
        	 ->setForeignKey('property_id')
             ->setName('Emis')
             ->setDependent(true);
    }
}