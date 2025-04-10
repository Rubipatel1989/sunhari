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

class WalletController extends AppController

{



    public function fundTransfer(){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

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



        $wallets = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();



        $this->set('wallets', $wallets);

    

    }



    public function transferFund(){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

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

            //print_r($this->request->getData());exit;

            if(isset($this->request->getData()['btn_transfer_fund'])){

                $wallet                     = [];

                $wallet['user_id']          = $this->request->getData()['Wallet']['username'];

                $wallet['amount']           = $this->request->getData()['Wallet']['amount'];

                $wallet['remark']           = $this->request->getData()['Wallet']['remark'];

                $wallet['status']           = $this->request->getData()['Wallet']['status'];

                $this->request->getSession()->write('wallet', $wallet);

                if($this->request->getSession()->check('wallet')){

                   $template = 'transaction_password';

                }

            }

            if(isset($this->request->getData()['btn_transaction_password'])){

                $template = 'transaction_password';



                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.transaction_password' => md5($this->request->getData()['User']['transaction_password']))))->first();

                

                if(!empty($userInfo)){

                    $tansactionId = $walletsTable->getTransactionId(11);

                    $walletInfo = $this->request->getSession()->read('wallet');

                    $wallet                 = $walletsTable->newEmptyEntity();

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



                        return $this->redirect($this->backend_url.'/wallet/fund_transfer');

                    }

                }else{

                    $this->Flash->error(__('Entered transaction password is wrong. Please enter correct transaction password'));

                }

            }

        }

        //echo $template;

        $this->render($template);

    

    }



    public function edit($intTransatonId){



        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Edit Fund';



        $this->set('title', $title);



        $walletsTable = TableRegistry::get('Wallets');

        $usersTable = TableRegistry::get('Users');



        if(!isset($intTransatonId)){

            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

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



        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();



        if(empty($getWallet)){

            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

        }

        $this->set('wallet', $getWallet);



        $userInfos = $usersTable->find('all', array('conditions' => array('Users.role_id' => 2, 'Users.id !=' => 1, 'Users.status' => 1)))->toArray();



        $this->set('userInfos', $userInfos);



        $template = 'edit';

        if($this->request->is('post')){

            $user_id = $this->adminUser->id;

            //echo '<pre>';

            //print_r($this->request->getData());exit;

            if(isset($this->request->getData()['btn_transfer_fund'])){

                $wallet                     =   [];

                $wallet['id']               =   $this->request->getData()['Wallet']['id'];

                $wallet['user_id']          =   $this->request->getData()['Wallet']['username'];

                $wallet['amount']           =   $this->request->getData()['Wallet']['amount'];

                $wallet['remark']           =   $this->request->getData()['Wallet']['remark'];

                $wallet['status']           =   $this->request->getData()['Wallet']['status'];

                $this->request->getSession()->write('wallet', $wallet);

                if($this->request->getSession()->check('wallet')){

                   $template = 'transaction_password';

                }

            }

            if(isset($this->request->getData()['btn_transaction_password'])){

                $template = 'transaction_password';



                $userInfo = $usersTable->find('all', array('conditions' => array('Users.id' => $user_id, 'Users.transaction_password' => md5($this->request->getData()['User']['transaction_password']))))->first();

                

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

                        return $this->redirect($this->backend_url.'/wallet/fund_transfer');

                    }

                }else{

                    $this->Flash->error(__('Entered transaction password is wrong. Please enter correct transaction password'));

                }

            }

        }

        //echo $template;

        $this->render($template);

    

    }



    public function updateStatus($intWalletId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Edit Fund';



        $this->set('title', $title);

        if(!isset($intWalletId) || !isset($intStatus)){

        return $this->redirect($this->backend_url.'/wallet/fund_transfer');

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



        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();



        if(empty($getWallet)){

            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

        }



        $wallet =  $walletsTable->get($intWalletId);

        $wallet->status =  $intStatus;

        if($walletsTable->save($wallet)){

            $this->Flash->success(__('Status has been updated successfully.'));



            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

        }



        $this->autoRender = false;

    }



    public function delete($intWalletId, $intStatus=2){

        if(!$this->request->getSession()->check('adminUserId')){

            return $this->redirect($this->backend_url.'/user/login');

        }



        $prefix_title = $this->backendTitle;

        

        $title = $prefix_title.' Edit Fund';



        $this->set('title', $title);

        if(!isset($intWalletId) || !isset($intStatus)){

           return $this->redirect($this->backend_url.'/wallet/fund_transfer');

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



        $getWallet = $walletsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();



        if(empty($getWallet)){

            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

        }



        $wallet =  $walletsTable->get($intWalletId);

        $wallet->status =  $intStatus;

        if($walletsTable->save($wallet)){

            $this->Flash->success(__('Wallet been deleted successfully.'));



            return $this->redirect($this->backend_url.'/wallet/fund_transfer');

        }



        $this->autoRender = false;

    }



    public function withdrawalHistory(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Withdrawal Request';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $fundrequestsTable  = TableRegistry::get('Fundrequests');

        $conditions = array('Fundrequests.status IN(1,2)');

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

        $fields = array('Users.id', 'Users.username', 'Users.name');
        $fundrequests = $fundrequestsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'join' => $join))->enableAutoFields(true)->toArray();

        $this->set('fundrequests', $fundrequests);
    }

    public function withdrawalRequest(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Withdrawal History';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $fundrequestsTable  = TableRegistry::get('Fundrequests');

        $conditions = array('Fundrequests.status' => 0);

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

        $fields = array('Users.id', 'Users.username', 'Users.name');
        $fundrequests = $fundrequestsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'join' => $join))->enableAutoFields(true)->toArray();

        $this->set('fundrequests', $fundrequests);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/
            $id = $this->request->getData()['Fundrequest']['id'] ?? '';
            $transaction_id = $this->request->getData()['Fundrequest']['transaction_id'] ?? '';
            $reject_reason = $this->request->getData()['Fundrequest']['reject_reason'] ?? '';
            if($id && $transaction_id){
                $fundrequest = $fundrequestsTable->get($id);
                $fundrequest->transaction_id = $transaction_id;
                $fundrequest->admin_action_date = date("Y-m-d H:i:s");
                $fundrequest->status = 1;
                $fundrequestsTable->save($fundrequest);
                $this->Flash->success(__('Withdrawal request has been approved.'));
            } elseif ($id && $reject_reason) {
                $fundrequest = $fundrequestsTable->get($id);
                $fundrequest->reject_reason = $reject_reason;
                $fundrequest->admin_action_date = date("Y-m-d H:i:s");
                $fundrequest->status = 2;
                $fundrequestsTable->save($fundrequest);
                $this->Flash->success(__('Withdrawal request has been rejected.'));
            }
            return $this->redirect($this->backend_url.'/wallet/withdrawal-request');

        }
    }

    public function raiseWithdrawalRequest() {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Raise Withdrawal Request';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $fundrequestsTable = TableRegistry::get("Fundrequests");

        
        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/

            $username =  trim($this->request->getData()["Fundrequest"]["username"]) ?? '';
            $btc_value =  trim($this->request->getData()["Fundrequest"]["btc_value"]) ?? '';
            $remark =  trim($this->request->getData()["Fundrequest"]["remark"]) ?? '';

            if ($btc_value && $username && $remark) {
                $conditions = ['Users.username' => $username];
                $userInfo = $usersTable->find('all', ['conditions' => $conditions])->first();
                if (!$userInfo) {
                    $this->Flash->error(__("Sorry! username does not exist in our database."));
                } elseif (!$userInfo->wallet_address) {
                    $this->Flash->error(__("Sorry! user did not save his wallet address"));
                }  elseif ($btc_value < 10) {
                    $this->Flash->error(__("Sorry! Minimum $10.00 can be Withdrawan."));

                } elseif (strpos( $btc_value, "." ) !== false) {
                    $this->Flash->error(__("Sorry! Amount should be in decimal."));
                } else {
                    $conditions = ['Fundrequests.user_id' => $userInfo->id, 'Fundrequests.status' => 0];
                    $checkfundRequest = $fundrequestsTable->find('all', ['conditions' => $conditions])->count();
                    if ($checkfundRequest > 0) {
                        $this->Flash->error(__("Sorry! You can not request withdrawal because old request is still pending."));
                    } else {
                        $fundRequest = $fundrequestsTable->newEmptyEntity();
                        $fundRequest->user_id = $userInfo->id;
                        $fundRequest->btc_value = $btc_value;
                        $fundRequest->self_btc_address = $userInfo->wallet_address;
                        $fundRequest->remark = $remark;
                        $fundRequest->status = 0;
                        if ($fundrequestsTable->save($fundRequest)) {
                            $this->Flash->success(__("Withdrawal request has been raised successfully."));
                            return $this->redirect($this->backend_url.'/wallet/raise-withdrawal-request');
                        }
                    }
                }
            } else {

                $this->Flash->error(__("All fields marked with * mandatory."));

            }

        }
    }
}

