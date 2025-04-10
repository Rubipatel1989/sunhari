<?php
namespace App\Controller\Mlmcontrol;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class EpinsController extends AppController
{

    public function generate(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Generate Epins';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $epinsTable = TableRegistry::get('Epins');
        $epinHistoriesTable = TableRegistry::get('EpinHistories');

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );

        $conditions = array(
                            'Users.role_id' => 2
                        );

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();
        $this->set('users', $users);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);exit;*/

            if(
                isset($this->request->data['Epin']['number_of_pins']) && !empty($this->request->data['Epin']['number_of_pins']) && is_numeric($this->request->data['Epin']['number_of_pins'])
            ){
                $userId = $this->adminUser->id;
                $numberOfPins = $this->request->data['Epin']['number_of_pins'];
                for($i=0; $i < $numberOfPins; $i++){

                    $epin = $epinsTable->getUniquePin('ARAD');

                    $epinData = $epinsTable->newEntity();
                    $epinData->generated_by = $userId;
                    $epinData->assigned_to = !empty($this->request->data['Epin']['assigned_to']) ? $this->request->data['Epin']['assigned_to'] : $this->adminUser->id;
                    $epinData->epin = $epin;
                    $epinData->remark = !empty($this->request->data['Epin']['remark']) ? $this->request->data['Epin']['remark'] : NULL;;
                    $epinData->status = 1;
                    $epinsTable->save($epinData);
                    $epinId = $epinData->id;
                    if(!empty($this->request->data['Epin']['assigned_to'])){

                        $epinHistoryData = $epinHistoriesTable->newEntity();
                        $epinHistoryData->transferred_by = 1;
                        $epinHistoryData->transferred_to = $this->request->data['Epin']['assigned_to'];
                        $epinHistoryData->epin_id = $epinId;
                        $epinHistoriesTable->save($epinHistoryData);

                    }
                }
                $this->Flash->success(__('Pin has been generated successfully.'));
                return $this->redirect($this->backend_url.'/epins/epin-list');
            }else{
                $this->Flash->error(__('Please fill all required marked with *.'));
            }
        }
    
    }

    public function epinList(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Epin List';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $epinsTable = TableRegistry::get('Epins');
        $epinHistoriesTable = TableRegistry::get('EpinHistories');

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );

        $conditions = array(
                            'Users.role_id' => 2
                        );

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();
        $this->set('users', $users);

        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'LEFT',
                        'conditions' => array('Users.id = Epins.assigned_to')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'LEFT',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name');
        $order = array('Epins.id' => 'DESC');
        $epins = $epinsTable->find('all', array('fields' => $fields, 'join' => $join, 'order' => $order))->autoFields(true)->toArray();

        $this->set('epins', $epins);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);exit;*/

            if(
                isset($this->request->data['Epin']['bulk_action']) && !empty($this->request->data['Epin']['bulk_action'])
                && isset($this->request->data['epinIds']) && !empty($this->request->data['epinIds']) && is_array($this->request->data['epinIds'])
            ){

                foreach($this->request->data['epinIds'] as $epinId){

                    $checkEpinStatus = $epinsTable->find('all', array('conditions' => array('Epins.id' => $epinId, 'Epins.status' => 1)))->count();
                    if($checkEpinStatus > 0){

                        $assignedTo = NULL;
                        if($this->request->data['Epin']['bulk_action'] == 1){
                            $assignedTo = $this->request->data['Epin']['assigned_to'];
                        }
                        $epinData = $epinsTable->get($epinId);
                        $epinData->assigned_to = $assignedTo;
                        $epinsTable->save($epinData);

                        if(!empty($assignedTo)){
                            $epinHistoryData = $epinHistoriesTable->newEntity();
                            $epinHistoryData->transferred_by = 1;
                            $epinHistoryData->transferred_to = $assignedTo;
                            $epinHistoryData->epin_id = $epinId;
                            $epinHistoriesTable->save($epinHistoryData);
                        }

                    }

                }
                if($this->request->data['Epin']['bulk_action'] == 1){
                    $this->Flash->success(__('Selected unsed epins has been assigned successfully.'));
                }else{
                    $this->Flash->success(__('Assignment of selected unsed epins has been removed successfully.'));
                }
            }
            return $this->redirect($this->backend_url.'/epins/epin-list');
        }
    }

    public function unused(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Unused Epins';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $epinsTable = TableRegistry::get('Epins');
        $epinHistoriesTable = TableRegistry::get('EpinHistories');

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );

        $conditions = array(
                            'Users.role_id' => 2
                        );

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();
        $this->set('users', $users);

        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'LEFT',
                        'conditions' => array('Users.id = Epins.assigned_to')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'LEFT',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $conditions = array(
                            'Epins.status' => 1
                        );
        $order = array('Epins.id' => 'DESC');
        $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name');
        $epins = $epinsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();

        $this->set('epins', $epins);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);exit;*/

            if(
                isset($this->request->data['Epin']['bulk_action']) && !empty($this->request->data['Epin']['bulk_action'])
                && isset($this->request->data['epinIds']) && !empty($this->request->data['epinIds']) && is_array($this->request->data['epinIds'])
            ){

                foreach($this->request->data['epinIds'] as $epinId){

                    $checkEpinStatus = $epinsTable->find('all', array('conditions' => array('Epins.id' => $epinId, 'Epins.status' => 1)))->count();
                    if($checkEpinStatus > 0){

                        $assignedTo = NULL;
                        if($this->request->data['Epin']['bulk_action'] == 1){
                            $assignedTo = $this->request->data['Epin']['assigned_to'];
                        }
                        $epinData = $epinsTable->get($epinId);
                        $epinData->assigned_to = $assignedTo;
                        $epinsTable->save($epinData);

                        if(!empty($assignedTo)){
                            $epinHistoryData = $epinHistoriesTable->newEntity();
                            $epinHistoryData->transferred_by = 1;
                            $epinHistoryData->transferred_to = $assignedTo;
                            $epinHistoryData->epin_id = $epinId;
                            $epinHistoriesTable->save($epinHistoryData);
                        }

                    }

                }
                if($this->request->data['Epin']['bulk_action'] == 1){
                    $this->Flash->success(__('Selected unsed epins has been assigned successfully.'));
                }else{
                    $this->Flash->success(__('Assignment of selected unsed epins has been removed successfully.'));
                }
            }
             return $this->redirect($this->backend_url.'/epins/unused');
        }

    }

    public function used(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Used Epins';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $epinsTable = TableRegistry::get('Epins');


        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );

        $conditions = array(
                            'Users.role_id' => 2
                        );

        $fields = array('Users.id', 'Users.username', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();
        $this->set('users', $users);

        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'LEFT',
                        'conditions' => array('Users.id = Epins.assigned_to')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'LEFT',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $conditions = array(
                            'Epins.status' => 2
                        );
        $order = array('Epins.id' => 'DESC');
        $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name');
        $epins = $epinsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();

        $this->set('epins', $epins);
    }

    public function transferredEpins(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Transferred Epins';

        $this->set('title', $title);

        $epinHistoriesTable = TableRegistry::get('EpinHistories');

        $join = array(
                        array(
                            'table' => 'users',
                            'alias' => 'TransferredBy',
                            'type' => 'INNER',
                            'conditions' => array('TransferredBy.id = EpinHistories.transferred_by')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'DetialsBy',
                            'type' => 'INNER',
                            'conditions' => array('DetialsBy.user_id = EpinHistories.transferred_by')
                        ),
                        array(
                            'table' => 'users',
                            'alias' => 'TransferredTo',
                            'type' => 'INNER',
                            'conditions' => array('TransferredTo.id = EpinHistories.transferred_to')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'DetialsTo',
                            'type' => 'INNER',
                            'conditions' => array('DetialsTo.user_id = EpinHistories.transferred_to')
                        ),
                        array(
                            'table' => 'epins',
                            'alias' => 'Epins',
                            'type' => 'INNER',
                            'conditions' => array('Epins.id = EpinHistories.epin_id')
                        )
                    );

        $conditions = array(
                        );
        $order = array('EpinHistories.id' => 'DESC');
        $fields = array('TransferredBy.id', 'TransferredBy.username', 'TransferredTo.id', 'DetialsBy.first_name', 'DetialsBy.last_name', 'DetialsTo.first_name', 'DetialsTo.last_name', 'TransferredTo.username', 'Epins.id', 'Epins.epin');

        $epinHistories = $epinHistoriesTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();
        $this->set('epinHistories', $epinHistories);

        /*echo '<pre>';
        print_r($epinHistories);exit;*/

    }
}
