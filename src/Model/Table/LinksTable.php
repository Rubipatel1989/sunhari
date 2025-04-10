<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class LinksTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }
}