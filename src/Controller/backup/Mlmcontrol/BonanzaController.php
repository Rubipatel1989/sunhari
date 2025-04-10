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
class BonanzaController extends AppController
{

    public function index(){

         if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bonanza';

        $this->set('title', $title);

        $bonanzasTable = TableRegistry::get('Bonanzas');
        
        $conditions = array(
        					'Bonanzas.status !=' => 2
        				);
        $join = array();

        $order = array(
        				'Bonanzas.id' => 'DESC'
        			);

        $fields = array('Bonanzas.id', 'Bonanzas.user_id', 'Bonanzas.title', 'Bonanzas.direct_users', 'Bonanzas.matching_users', 'Bonanzas.reward', 'Bonanzas.amount', 'Bonanzas.start_date', 'Bonanzas.end_date', 'Bonanzas.remark', 'Bonanzas.status');

        $bonanzas = $bonanzasTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->toArray();
        $this->set('bonanzas', $bonanzas);

    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bonanza | Add';

        $this->set('title', $title);

        $bonanzasTable = TableRegistry::get('Bonanzas');

        if($this->request->is('post')){
           /* echo '<pre>';
            print_r($this->request->data);
            echo $startDate = date('Y-m-d', strtotime($this->request->data['Bonanza']['start_date']));
            exit;*/

            $bonanza 					=  $bonanzasTable->newEntity();
            $bonanza->user_id 			=  $this->adminUser->id;
            $bonanza->title             =  $this->request->data['Bonanza']['title'];
            $bonanza->direct_users      =  $this->request->data['Bonanza']['direct_users'];
            $bonanza->matching_users    =  $this->request->data['Bonanza']['matching_users'];
            $bonanza->reward   			=  $this->request->data['Bonanza']['reward'];
            $bonanza->amount    		=  $this->request->data['Bonanza']['amount'];
            $bonanza->start_date       	=  date('Y-m-d', strtotime($this->request->data['Bonanza']['start_date']));
            $bonanza->end_date   		=  date('Y-m-d', strtotime($this->request->data['Bonanza']['end_date']));
            $bonanza->remark     		=  nl2br($this->request->data['Bonanza']['remark']);
            $bonanza->status   			=  $this->request->data['Bonanza']['status'];
            $bonanza->created   		=  date("Y-m-d H:i:s");
            $bonanza->modified   		=  date("Y-m-d H:i:s");

            if($bonanzasTable->save($bonanza)){
                $this->Flash->success(__('Congratulations! Bonanza has been added successfully.'));
                return $this->redirect(['controller' => 'bonanza', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function edit($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'bonanza', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bonanza | Edit';

        $this->set('title', $title);

        $bonanzasTable = TableRegistry::get('Bonanzas');

        $conditions = array(
        					'Bonanzas.id' => $intId
        				);

        $fields = array('Bonanzas.id', 'Bonanzas.user_id', 'Bonanzas.title', 'Bonanzas.direct_users', 'Bonanzas.matching_users', 'Bonanzas.reward', 'Bonanzas.amount', 'Bonanzas.start_date', 'Bonanzas.end_date', 'Bonanzas.remark', 'Bonanzas.status');

        $bonanza = $bonanzasTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();
        $this->set('bonanza', $bonanza);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);
            exit;*/

            $bonanza 					=  $bonanzasTable->get($intId);
            $bonanza->title             =  $this->request->data['Bonanza']['title'];
            $bonanza->direct_users      =  $this->request->data['Bonanza']['direct_users'];
            $bonanza->matching_users    =  $this->request->data['Bonanza']['matching_users'];
            $bonanza->reward   			=  $this->request->data['Bonanza']['reward'];
            $bonanza->amount    		=  $this->request->data['Bonanza']['amount'];
            $bonanza->start_date       	=  date('Y-m-d', strtotime($this->request->data['Bonanza']['start_date']));
            $bonanza->end_date   		=  date('Y-m-d', strtotime($this->request->data['Bonanza']['end_date']));
            $bonanza->remark     		=  nl2br($this->request->data['Bonanza']['remark']);
            $bonanza->status   			=  $this->request->data['Bonanza']['status'];
            $bonanza->modified   		=  date("Y-m-d H:i:s");

            if($bonanzasTable->save($bonanza)){
                $this->Flash->success(__('Congratulations! Bonanza has been updated successfully.'));
                return $this->redirect(['controller' => 'bonanza', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function updateStatus($intId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        if(!isset($intStatus)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bonanza | Update Status';

        $this->set('title', $title);

        $bonanzasTable = TableRegistry::get('Bonanzas');

        $conditions = array(
                            'Bonanzas.status !=' => 2,
                            'Bonanzas.id' => $intId
                        );
       

        $fields =  array('Bonanzas.id');
        $bonanza = $bonanzasTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();

        if(empty($bonanza)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $bonanza = $bonanzasTable->get($intId);
        $bonanza->status = $intStatus;
        if($bonanzasTable->save($bonanza)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect(['controller' => 'bonanza', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }

    public function delete($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bonanza | Delete';

        $this->set('title', $title);

        $bonanzasTable = TableRegistry::get('Bonanzas');

        $conditions = array(
                            'Bonanzas.status !=' => 2,
                            'Bonanzas.id' => $intId
                        );
       

        $fields =  array('Bonanzas.id');
        $bonanza = $bonanzasTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->first();

        if(empty($bonanza)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $bonanza = $bonanzasTable->get($intId);
        $bonanza->status = 2;
        if($bonanzasTable->save($bonanza)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect(['controller' => 'bonanza', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }
}
