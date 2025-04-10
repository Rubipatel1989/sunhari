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
class RoiController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Rois';

        $this->set('title', $title);

        $roisTable = TableRegistry::get('Rois');

        $conditions = array(
                            'Rois.status !=' => 2
                        );

        $order = array('Rois.id' => 'DESC');

        $rois = $roisTable->find('all', array('conditions' => $conditions, 'order' => $order))->autoFields(true)->toArray();

        $this->set('rois', $rois);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roi | Add';

        $this->set('title', $title);

        $roisTable = TableRegistry::get('Rois');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            $roisTable->updateAll(['status' => 0], false);

            //$type = $this->request->data['Roi']['type'];
            $type = 0;

            $roi = $roisTable->newEntity();
            $roi->user_id    = $this->adminUser->id;
            $roi->title      = $this->request->data['Roi']['title'];
            $roi->type       = $type;
            if($type == 0){
                $roi->amount     = $this->request->data['Roi']['amount'];
            }else{
                $roi->percentage = $this->request->data['Roi']['percentage'];
            }
            $roi->remark     = nl2br($this->request->data['Roi']['remark']);
            $roi->status     = 1;
            if($roisTable->save($roi)){
                $this->Flash->success(__('Roi has been added successfully.'));
                return $this->redirect(['controller' => 'roi', 'action' => 'index', 'prefix' => $this->backend]);
            }
        }
    }
}
