<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DownlinesTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getTreeByDownlines($downlines){
      $trees = [];
      foreach($downlines as $downline){

        $trees[$downline->level][$downline->Users['parent_id']][$downline->Users['position']] = array(
          'user_id' => $downline->Users['id'],
          'username' => $downline->Users['username'],
          'position' => $downline->Users['position'],
          'status' => $downline->Users['status'],
          'name'     => $downline->Details['first_name'].' '.$downline->Details['last_name'],
          'sponsor_name' => $downline->Users['sponsor_name'],
          'sponsor_usernmae' => $downline->Sponsers['username'],
          'total_left' => $downline->Users['total_left'],
          'total_right' => $downline->Users['total_right'],
          'total_active_left' => $downline->Users['total_active_left'],
          'total_active_right' => $downline->Users['total_active_right'],
          'plot_number' => isset($downline->AssignPlots['plot_number']) ? $downline->AssignPlots['plot_number'] : 'N/A',
          'grand_total' => isset($downline->AssignPlots['grand_total']) ? $downline->AssignPlots['grand_total'] : 'N/A',
          'total_paid_payment' => $downline->total_paid_payment,
          'total_upgrades' => $downline->total_upgrades
        );
      }
      return $trees;
  }

  public function getDirectUsers($downlines){
    $dirctUsers = [];
    if(!empty($downlines)){
        foreach($downlines as $downline){
          if($downline->position == 'left'){
            $dirctUsers['left'][] = array(
                                        'user_id' => $downline->Users['id'],
                                        'username' => $downline->Users['username'],
                                        'position' => $downline->Users['position'],
                                        'status' => $downline->Users['status'],
                                        'name'     => $downline->Details['first_name'].' '.$downline->Details['last_name'],
                                      );
          }else{
            $dirctUsers['right'][] = array(
                                        'user_id' => $downline->Users['id'],
                                        'username' => $downline->Users['username'],
                                        'position' => $downline->Users['position'],
                                        'status' => $downline->Users['status'],
                                        'name'     => $downline->Details['first_name'].' '.$downline->Details['last_name'],
                                      );
          }
        }
    }

    return $dirctUsers;
  }

  public function getDownlineUsersById($intUserId, $position, $countOnly=0, $clubType=NULL){

    $conditions = array(
                        'Downlines.user_id' => $intUserId,
                        'Downlines.position' => $position
                    );

    $arrClub = array(
                    'table' => 'users',
                    'alias' => 'Users',
                    'type' => 'INNER',
                    'conditions' => array('Users.id = Downlines.user_table_id')
                );
    if($clubType == 'mobile'){
      $arrClub = array(
                      'table' => 'users',
                      'alias' => 'Users',
                      'type' => 'INNER',
                      'conditions' => array('Users.id = Downlines.user_table_id AND Users.is_mobile_club = 1')
                  );
    }
    elseif($clubType == 'laptop'){
      $arrClub = array(
                      'table' => 'users',
                      'alias' => 'Users',
                      'type' => 'INNER',
                      'conditions' => array('Users.id = Downlines.user_table_id AND Users.is_laptop_club = 1')
                  );
    }
    elseif($clubType == 'bike'){
      $arrClub = array(
                      'table' => 'users',
                      'alias' => 'Users',
                      'type' => 'INNER',
                      'conditions' => array('Users.id = Downlines.user_table_id AND Users.is_bike_club = 1')
                  );
    }
    $joins = array(
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Downlines.user_table_id')
                    ),
                    $arrClub,
                    array(
                        'table' => 'users',
                        'alias' => 'Sponsers',
                        'type' => 'left',
                        'conditions' => array('Sponsers.id = Downlines.sponsor_id')
                    )
                );
    $group = array('Downlines.user_table_id');

    if($countOnly == 1){

      $downlines = $this->find('all', array('conditions' =>$conditions, 'join' => $joins, 'group' => $group))
                      ->count();
    }else{
      $fields = array('Users.id', 'Users.username', 'Users.status', 'Sponsers.username', 'Details.id', 'Details.user_id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

      $downlines = $this->find('all', array('fields' => $fields, 'conditions' =>$conditions, 'join' => $joins, 'group' => $group))
                      ->enableAutoFields(true)
                      ->toArray();
    }

    return $downlines;

  }
}