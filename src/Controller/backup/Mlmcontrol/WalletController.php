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
class WalletController extends AppController
{

    public function fundTransfer(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Fund Transfer';

        $this->set('title', $title);

        $walletsTable = TableRegistry::get('Wallets');

        $conditions = array(
                            'Wallets.status !=' => 2
                        );
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Wallets.user_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    ),
                     array(
                        'table' => 'users',
                        'alias' => 'Payer',
                        'type' => 'INNER',
                        'conditions' => array('Payer.id = Wallets.transfer_by')
                    )
                );
        $order = array('Wallets.id' => 'DESC');

        $fields =  array('Users.id', 'Users.username', 'Payer.id', 'Payer.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $wallets = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->autoFields(true)->toArray();

        $this->set('wallets', $wallets);
    
    }

    public function transferFund(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Transfer Fund';

        $this->set('title', $title);

        $walletsTable = TableRegistry::get('Wallets');
        $usersTable = TableRegistry::get('Users');

        $userInfos = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.id !=' => 1, 'Users.status' => 1)))->toArray();
        $this->set('userInfos', $userInfos);

        $template = 'transfer_fund';
        if($this->request->is('post')){
            $user_id = $this->adminUser->id;
            //echo '<pre>';
            //print_r($this->request->data);exit;
            if(isset($this->request->data['btn_transfer_fund'])){
                $wallet                     = [];
                $wallet['user_id']          = $this->request->data['Wallet']['username'];
                $wallet['amount']           = $this->request->data['Wallet']['amount'];
                $wallet['remark']           = $this->request->data['Wallet']['remark'];
                $wallet['status']           = $this->request->data['Wallet']['status'];
                $this->request->getSession()->write('wallet', $wallet);
                if($this->request->getSession()->check('wallet')){
                   $template = 'transaction_password';
                }
            }
            if(isset($this->request->data['btn_transaction_password'])){
                $template = 'transaction_password';

                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.transaction_password' => md5($this->request->data['User']['transaction_password']))))->first();
                
                if(!empty($userInfo)){

                    $otp = rand(123456, 999999);
                    $userSaveData = $usersTable->get($user_id);
                    $userSaveData->otp = md5($otp);
                    $usersTable->save($userSaveData);

                    $template = "Dear ".$this->adminUser->Details['first_name']." ".$this->adminUser->Details['last_name'].", Your One Time Password(OTP) for www.octiqmarketing.com is: ".$otp." For more help, please contact our support or visit www.octiqmarketing.com";
                    $sendSMS = $usersTable->sendSMS($template, $this->adminUser->Details['contact_no']);

                    $this->Flash->success(__('Please enter below sent OPT on your registered contact number.'));
                    $template = 'otp';
                }else{
                    $this->Flash->error(__('Entered transaction password is wrong. Please enter correct transaction password'));
                }
            }
            if(isset($this->request->data['btn_otp'])){
                $template = 'otp';
                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.otp' => md5($this->request->data['User']['otp']))))->first();
                if(!empty($userInfo)){
                    $tansactionId = $walletsTable->getTransactionId(11);
                    $walletInfo = $this->request->getSession()->read('wallet');
                    $wallet                 = $walletsTable->newEntity();
                    $wallet->user_id        = $walletInfo['user_id'];
                    $wallet->transfer_by    = $user_id;
                    $wallet->transaction_id = $tansactionId;
                    $wallet->amount         = $walletInfo['amount'];
                    $wallet->remark         = $walletInfo['remark'];
                    $wallet->status         = $walletInfo['status'];
                    if($walletsTable->save($wallet)){
                        
                        $userSaveData = $usersTable->get($user_id);
                        $userSaveData->otp = NULL;
                        $usersTable->save($userSaveData);

                        $this->request->getSession()->delete('wallet');
                        $this->Flash->success(__('Fund has been transfer successfully.'));
                        return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
                    }
                }else{
                    $this->Flash->error(__('Entered OTP is wrong. Please enter correct OTP'));
                }
            }
        }
        //echo $template;
        $this->render($template);
    
    }

    public function edit($intTransatonId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Edit Fund';

        $this->set('title', $title);

        $walletsTable = TableRegistry::get('Wallets');
        $usersTable = TableRegistry::get('Users');

        if(!isset($intTransatonId)){
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer']);
        }

        $conditions = array(
                            'Wallets.transaction_id' => $intTransatonId
                        );
        $join = array(
                         array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Wallets.user_id')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );
        $fields =  array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($getWallet)){
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer']);
        }
        $this->set('wallet', $getWallet);

        $userInfos = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.id !=' => 1, 'Users.status' => 1)))->toArray();

        $this->set('userInfos', $userInfos);

        $template = 'edit';
        if($this->request->is('post')){
            $user_id = $this->adminUser->id;
            //echo '<pre>';
            //print_r($this->request->data);exit;
            if(isset($this->request->data['btn_transfer_fund'])){
                $wallet                     =   [];
                $wallet['id']               =   $this->request->data['Wallet']['id'];
                $wallet['user_id']          =   $this->request->data['Wallet']['username'];
                $wallet['amount']           =   $this->request->data['Wallet']['amount'];
                $wallet['remark']           =   $this->request->data['Wallet']['remark'];
                $wallet['status']           =   $this->request->data['Wallet']['status'];
                $this->request->getSession()->write('wallet', $wallet);
                if($this->request->getSession()->check('wallet')){
                   $template = 'transaction_password';
                }
            }
            if(isset($this->request->data['btn_transaction_password'])){
                $template = 'transaction_password';

                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.transaction_password' => md5($this->request->data['User']['transaction_password']))))->first();
                
                if(!empty($userInfo)){
                    $this->Flash->success(__('Please enter below sent OPT on your registered contact number.'));
                    $template = 'otp';
                }else{
                    $this->Flash->error(__('Entered transaction password is wrong. Please enter correct transaction password'));
                }
            }
            if(isset($this->request->data['btn_otp'])){
                $template = 'otp';
                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.otp' => md5($this->request->data['User']['otp']))))->first();
                if(!empty($userInfo)){
                    $tansactionId = $walletsTable->getTransactionId(11);
                    $walletInfo = $this->request->getSession()->read('wallet');
                    $wallet                 = $walletsTable->get($walletInfo['id']);
                    $wallet->user_id        = $walletInfo['user_id'];
                    $wallet->transaction_id = $tansactionId;
                    $wallet->amount         = $walletInfo['amount'];
                    $wallet->remark         = $walletInfo['remark'];
                    $wallet->status         = $walletInfo['status'];
                    if($walletsTable->save($wallet)){
                        $this->request->getSession()->delete('wallet');
                        $this->Flash->success(__('Fund has been updated successfully.'));
                        return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
                    }
                }else{
                    $this->Flash->error(__('Entered OTP is wrong. Please enter correct OTP'));
                }
            }
        }
        //echo $template;
        $this->render($template);
    
    }

    public function updateStatus($intWalletId, $intStatus){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Edit Fund';

        $this->set('title', $title);
        if(!isset($intWalletId) || !isset($intStatus)){
           return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $walletsTable = TableRegistry::get('Wallets');
        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Wallets.id' => $intWalletId
                        );
        $join = array(
                         array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Wallets.user_id')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );
        $fields =  array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($getWallet)){
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $wallet =  $walletsTable->get($intWalletId);
        $wallet->status =  $intStatus;
        if($walletsTable->save($wallet)){
            $this->Flash->success(__('Status has been updated successfully.'));
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }

    public function delete($intWalletId, $intStatus=2){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Edit Fund';

        $this->set('title', $title);
        if(!isset($intWalletId) || !isset($intStatus)){
           return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $walletsTable = TableRegistry::get('Wallets');
        $usersTable = TableRegistry::get('Users');

        $conditions = array(
                            'Wallets.id' => $intWalletId
                        );
        $join = array(
                         array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Wallets.user_id')
                        ),
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );
        $fields =  array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->autoFields(true)->first();

        if(empty($getWallet)){
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $wallet =  $walletsTable->get($intWalletId);
        $wallet->status =  $intStatus;
        if($walletsTable->save($wallet)){
            $this->Flash->success(__('Wallet been deleted successfully.'));
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_transfer', 'prefix' => $this->backend]);
        }

        $this->render(false);
    }

    public function fundRequest(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Fund Request';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $fundrequestsTable  = TableRegistry::get('Fundrequests');

        $conditions = array(
                            'Fundrequests.status !=' => 2
                        );
        $order = array(
                        'Fundrequests.id' => 'DESC'
                    );

        $join = array(
                        array(
                            'table' => 'users',
                            'alias' => 'Users',
                            'type' => 'INNER',
                            'conditions' => array('Users.id = Fundrequests.user_id')
                        )
                    );

        $fields = array('Users.id', 'Users.username');
        $fundrequests = $fundrequestsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'join' => $join))->autoFields(true)->toArray();
        $this->set('fundrequests', $fundrequests);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->data);exit;

            if(isset($this->request->data['ids']) && !empty($this->request->data['ids']) && $this->request->data['Fundrequest']['bulk_action'] != ''){
                foreach($this->request->data['ids'] as $id){
                   $fundrequest = $fundrequestsTable->get($id);
                   $fundrequest->status = $this->request->data['Fundrequest']['bulk_action'];
                   $fundrequestsTable->save($fundrequest);
                }
            }
            $this->Flash->success(__('Status of selected fund reuest has been changed.'));
            return $this->redirect(['controller' => 'wallet', 'action' => 'fund_request', 'prefix' => $this->backend]);
        }
    
    }
}
