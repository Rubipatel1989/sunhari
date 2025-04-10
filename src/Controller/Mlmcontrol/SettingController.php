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

class SettingController extends AppController {

    public function taxAndCommission() {

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Team : Tax & Commission';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $commissionsTable = TableRegistry::get('Commissions');

        $commissions = $commissionsTable->find('all', array('conditions' => array('Commissions.status !=' => 2), 'order' => array('Commissions.id' => 'DESC')))->enableAutoFields(true)->toArray();
        $this->set('commissions', $commissions);
        
    }

    public function addTaxAndCommission(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Team : Add Tax & Commission';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $commissionsTable = TableRegistry::get('Commissions');

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->getData());exit;
            $commissionsTable->updateAll(['status' => 0], false);
            $commissionData           = $commissionsTable->newEmptyEntity();
            $commissionData->tax      = $this->request->getData()['Commission']['tax'];
            $commissionData->amount   = $this->request->getData()['Commission']['amount'];
            $commissionData->remark   = nl2br($this->request->getData()['Commission']['remark']);
            $commissionData->status   = 1;
            if( $commissionsTable->save($commissionData)){
                $this->Flash->success(__('Tax & Commission has been set successfully.'));
                return $this->redirect($this->backend_url.'/setting/tax-and-commission');
            }
        }
    }

}