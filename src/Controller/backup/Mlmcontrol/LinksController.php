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
class LinksController extends AppController
{

    public function index(){

         if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Links';

        $this->set('title', $title);

        $linksTable = TableRegistry::get('Links');

        $conditions = array(
                                'Links.status !=' => 2
                            );
        $order = array('Links.id' => 'DESC');

        $links = $linksTable->find('all', array('conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();

        $this->set('links', $links);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Link | Add';

        $this->set('title', $title);

        $linksTable = TableRegistry::get('Links');
        $attachmentsTable = TableRegistry::get('Attachments');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            $link = $linksTable->newEntity();
            $link->title    =  $this->request->data['Link']['title'];
            $link->link     =  $this->request->data['Link']['link'];
            $link->remark   =  nl2br($this->request->data['Link']['remark']);
            $link->status   =  $this->request->data['Link']['status'];

            if($linksTable->save($link)){
                $this->Flash->success(__('Congratulations! Link has been added successfully.'));
                return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function edit($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Link | Edit';

        $this->set('title', $title);

        $linksTable = TableRegistry::get('Links');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Links.status !=' => 2,
                            'Links.id' => $intId
                        );

        $linkInfo = $linksTable->find('all', array('conditions' => $conditions))->autoFields(true)->first();

        if(empty($linkInfo)){
             return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->set('linkInfo', $linkInfo);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            $link = $linksTable->get($this->request->data['Link']['id']);
            $link->title    =  $this->request->data['Link']['title'];
            $link->link     =  $this->request->data['Link']['link'];
            $link->remark   =  nl2br($this->request->data['Link']['remark']);
            $link->status   =  $this->request->data['Link']['status'];

            if($linksTable->save($link)){
                $link_id = $this->request->data['Link']['id'];
                $this->Flash->success(__('Congratulations! Link has been updated successfully.'));
                return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }

    public function updateStatus($intId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        if(!isset($intStatus)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Link | Update Status';

        $this->set('title', $title);

        $linksTable = TableRegistry::get('Links');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Links.status !=' => 2,
                            'Links.id' => $intId
                        );

        $linkInfo = $linksTable->find('all', array('conditions' => $conditions))->autoFields(true)->first();

        if(empty($linkInfo)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $link = $linksTable->get($intId);
        $link->status = $intStatus;
        if($linksTable->save($link)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }

     public function delete($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Link | Update Status';

        $this->set('title', $title);

        $linksTable = TableRegistry::get('Links');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Links.status !=' => 2,
                            'Links.id' => $intId
                        );

        $linkInfo = $linksTable->find('all', array('conditions' => $conditions))->autoFields(true)->first();

        if(empty($linkInfo)){
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $link = $linksTable->get($intId);
        $link->status = 2;
        if($linksTable->save($link)){
            $this->Flash->success(__('Congratulations! Link has been updated successfully.'));
            return $this->redirect(['controller' => 'links', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }
}
