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
class PaymentsController extends AppController
{

   

    public function singleCalculation(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Single Calculation';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');

        $users = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.status' => 1)))->autoFields(true)->toArray();
        $this->set('users', $users);

        $username =  isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';

        $conditions = array(
                            'Users.username' => $username
                        );
        $userInfo = $usersTable->find('all', array('conditions' => $conditions))->autoFields(true)->first();
        $this->set('userInfo', $userInfo);

        $binary  =  $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->autoFields(true)->first();
        $this->set('binary', $binary);

        $cashingAmount = [];
        if(!empty($userInfo)){
            $query = $upgradesTable->find();
            $query->select(['count' => $query->func()->count('*')]);
            $cashingAmount = $query->select(['sum' => $query->func()->sum('package_amount')])->where(['Upgrades.upgraded_id' => $userInfo->id, 'Upgrades.expiry_date >=' => date('Y-m-d')])->first();
        }
        $this->set('cashingAmount', $cashingAmount);

    }

    public function bulkCalculation(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Single Calculation';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');
        $binariesTable = TableRegistry::get('Binaries');
        $payoutsTable = TableRegistry::get('Payouts');
        $commissionsTable = TableRegistry::get('Commissions');

        $conditions = array(
                            'Users.role_id' => 2, 
                            'Users.status !=' => 2
                        );
        $join = array(
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $fields = array('Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->toArray();
        $this->set('users', $users);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;
            if(isset($this->request->data['user_ids']) && !empty($this->request->data['user_ids'])){
                $commission = $commissionsTable->find('all', array('conditions' => array('Commissions.status' => 1)))->first();
                $binary = $binariesTable->find('all', array('conditions' => array('Binaries.status' => 1)))->first();
                if(isset($binary->percentage) && !empty($binary->percentage)){
                    $multiplier = ($binary->percentage)/100;
                }else{
                    $multiplier = $binary->amount;
                }
                foreach($this->request->data['user_ids'] as $user_id){

                    $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id)))->first();

                    $payout = $payoutsTable->newEntity();
                    $payout->upagraded_user_id  = $user_id;
                    $payout->matching_amount    = ($this->request->data['pending_pair'][$user_id] * $multiplier);
                    $payout->tax                = isset($commission->tax) ? $commission->tax : NULL;
                    $payout->admin_commission   = isset($commission->amount) ? $commission->amount : NULL;
                    if(isset($this->request->data['royalty'][$user_id])){
                        $conditions = array(
                                            'Upgrades.expiry_date >=' => date('Y-m-d')
                                        );
                        $join = array(
                                    array(
                                        'table' => 'users',
                                        'alias' => 'Users',
                                        'type'  => 'INNER',
                                        'conditions' => array('Users.id = Upgrades.upgraded_id and Users.sponsor_id = "'.$user_id.'"')
                                    )
                                );
                        $group = array('Upgrades.upgraded_id');
                        $fields = array('Upgrades.upgraded_id');
                        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'group' => $group))->toArray();
                        $royalty = 0;
                        if(!empty($upgrades)){
                            foreach ($upgrades as $upgrade) {
                                $query = $payoutsTable->find();
                                $payoutDetails = $query->select(['sum' => $query->func()->sum('Payouts.direct_amount + Payouts.matching_amount + Payouts.royalty_amount')])->where(['Payouts.upagraded_user_id' => $upgrade->upgraded_id, 'Payouts.status = 0'])->first();
                                
                                if(isset($payoutDetails->sum) && !empty($payoutDetails->sum)){
                                     $royalty = $royalty + $payoutDetails->sum;
                                }
                               
                            }
                        }
                        $payout->royalty_amount = ($royalty*10)/100;
                    }else{
                        $payout->royalty_amount = 0;
                    }
                    $payoutsTable->save($payout);

                    $userData = $usersTable->get($userInfo->id);
                    $userData->previous_pair =  $userInfo->previous_pair + $this->request->data['pending_pair'][$user_id];
                    $usersTable->save($userData);
                }
            }
            $this->Flash->success(__('Payment has been submitted successfully.'));
            return $this->redirect(['controller' => 'payments', 'action' => 'bulkCalculation', 'prefix' => $this->backend]);
            //exit;
        }
    }

    public function closing(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Payments Closing';

        $this->set('title', $title);

        $bitcoinsTable = TableRegistry::get('Bitcoins');
    
    }

}
