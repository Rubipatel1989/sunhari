<?php
namespace App\Controller\Panelcontrol;

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
class BitcoinsController extends AppController
{

   

    public function index(){

         if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bitcoins';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                                'Bitcoins.status !=' => 2
                            );
        $join = array(
                        array(
                            'table' => 'attachments',
                            'alias' => 'Attachments',
                            'type' => 'LEFT',
                            'conditions' => array('Attachments.reference_id = Bitcoins.id', 'Attachments.reference_type = "bitcoin"')
                        )
                    );
        $order = array('Bitcoins.id' => 'DESC');

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $bitcoins = $bitcoinsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->autoFields(true)->toArray();

        $this->set('bitcoins', $bitcoins);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bitcoin | Add';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
        $attachmentsTable = TableRegistry::get('Attachments');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;
            $bitcoinsTable->updateAll(['status' => 0], false);

            $bitcoin            =  $bitcoinsTable->newEntity();
            $bitcoin->user_id   =  $this->adminUser->id;
            $bitcoin->title     =  $this->request->data['Bitcoin']['title'];
            $bitcoin->address   =  $this->request->data['Bitcoin']['address'];
            $bitcoin->remark    =  nl2br($this->request->data['Bitcoin']['remark']);
            $bitcoin->status    =  1;

            if($bitcoinsTable->save($bitcoin)){
                $bitcoin_id = $bitcoin->id;
                if(isset($this->request->data['Attachment']['id']) && !empty($this->request->data['Attachment']['id'])){
                    $i = 0;
                    foreach($this->request->data['Attachment']['id'] as $attachmentId){
                        $attachment = $attachmentsTable->get($attachmentId);
                        $attachment->reference_id = $bitcoin_id;
                        $attachment->reference_type = 'bitcoin';
                        $attachment->caption = $this->request->data['Attachment']['caption'][$i];
                        $attachmentsTable->save($attachment);
                        $i++;
                    }
                }
                $this->Flash->success(__('Congratulations! Bitcoin has been added successfully.'));
                return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function edit($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bitcoin | Edit';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Bitcoins.status !=' => 2,
                            'Bitcoins.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Bitcoins.id', 'Attachments.reference_type = "bitcoin"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $bitcoinInfo = $bitcoinsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($bitcoinInfo)){
             return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->set('bitcoinInfo', $bitcoinInfo);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            $bitcoin            =  $bitcoinsTable->get($this->request->data['Bitcoin']['id']);
            $bitcoin->title     =  $this->request->data['Bitcoin']['title'];
            $bitcoin->address   =  $this->request->data['Bitcoin']['address'];
            $bitcoin->remark    =  nl2br($this->request->data['Bitcoin']['remark']);
            $bitcoin->status    =  $this->request->data['Bitcoin']['status'];

            if($bitcoinsTable->save($bitcoin)){
                $bitcoin_id = $bitcoin->id;
                if(isset($this->request->data['Attachment']['id']) && !empty($this->request->data['Attachment']['id'])){
                    $i = 0;
                    foreach($this->request->data['Attachment']['id'] as $attachmentId){
                        $attachment                 = $attachmentsTable->get($attachmentId);
                        $attachment->reference_id   = $bitcoin_id;
                        $attachment->reference_type = 'bitcoin';
                        $attachment->caption        = $this->request->data['Attachment']['caption'][$i];
                        $attachmentsTable->save($attachment);
                        $i++;
                    }
                }
                $this->Flash->success(__('Congratulations! Bitcoin has been updated successfully.'));
                return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function updateStatus($intId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        if(!isset($intStatus)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bitcoin | Update Status';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Bitcoins.status !=' => 2,
                            'Bitcoins.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Bitcoins.id', 'Attachments.reference_type = "bitcoin"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $bitcoinInfo = $bitcoinsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($bitcoinInfo)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $bitcoin = $bitcoinsTable->get($intId);
        $bitcoin->status = $intStatus;
        if($bitcoinsTable->save($bitcoin)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }

     public function delete($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Bitcoin | Update Status';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Bitcoins.status !=' => 2,
                            'Bitcoins.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Bitcoins.id', 'Attachments.reference_type = "bitcoin"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $bitcoinInfo = $bitcoinsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($bitcoinInfo)){
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $bitcoin = $bitcoinsTable->get($intId);
        $bitcoin->status = 2;
        if($bitcoinsTable->save($bitcoin)){
            $this->Flash->success(__('Congratulations! Bitcoin has been updated successfully.'));
            return $this->redirect(['controller' => 'bitcoins', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }
}
