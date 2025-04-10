<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class RewardsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
}