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

class BinariesController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Binaries';

        $this->set('title', $title);

        $binariesTable = TableRegistry::get('Binaries');

        $conditions = array(
                            'Binaries.status !=' => 2
                        );

        $order = array('Binaries.id' => 'DESC');

        $binaries = $binariesTable->find('all', array('conditions' => $conditions, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('binaries', $binaries);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Binary | Add';

        $this->set('title', $title);

        $binariesTable = TableRegistry::get('Binaries');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->getData());exit;

            $binariesTable->updateAll(['status' => 0], false);

            $type = $this->request->getData()['Binary']['type'];

            $banary = $binariesTable->newEmptyEntity();
            $banary->user_id    = $this->adminUser->id;
            $banary->title      = $this->request->getData()['Binary']['title'];
            $banary->type       = $type;
            if($type == 0){
                $banary->amount     = $this->request->getData()['Binary']['amount'];
            }else{
                $banary->percentage = $this->request->getData()['Binary']['percentage'];
            }
            $banary->remark     = nl2br($this->request->getData()['Binary']['remark']);
            $banary->status     = 1;
            if($binariesTable->save($banary)){
                $this->Flash->success(__('Binary has been added successfully.'));

                return $this->redirect($this->backend_url.'/binaries/index');
            }
        }
    }
}
