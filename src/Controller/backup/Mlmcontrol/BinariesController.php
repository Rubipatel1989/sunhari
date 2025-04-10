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
class BinariesController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Binaries';

        $this->set('title', $title);

        $binariesTable = TableRegistry::get('Binaries');

        $conditions = array(
                            'Binaries.status !=' => 2
                        );

        $order = array('Binaries.id' => 'DESC');

        $binaries = $binariesTable->find('all', array('conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();

        $this->set('binaries', $binaries);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Binary | Add';

        $this->set('title', $title);

        $binariesTable = TableRegistry::get('Binaries');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            $binariesTable->updateAll(['status' => 0], false);

            $type = $this->request->data['Binary']['type'];

            $banary = $binariesTable->newEntity();
            $banary->user_id    = $this->adminUser->id;
            $banary->title      = $this->request->data['Binary']['title'];
            $banary->type       = $type;
            if($type == 0){
                $banary->amount     = $this->request->data['Binary']['amount'];
            }else{
                $banary->percentage = $this->request->data['Binary']['percentage'];
            }
            $banary->remark     = nl2br($this->request->data['Binary']['remark']);
            $banary->status     = 1;
            if($binariesTable->save($banary)){
                $this->Flash->success(__('Binary has been added successfully.'));
                return $this->redirect(['controller' => 'binaries', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }
}
