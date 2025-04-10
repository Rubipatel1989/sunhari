<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class AjaxController extends AppController

{

    public function getSponserDetails(){

        $this->viewBuilder()->setLayout('ajax');
        $usersTable = TableRegistry::get('Users');
        $sponserInfo = [];

        if($this->request->is('post')){

            $usersTable = TableRegistry::get('Users');

            $username = $this->request->getData()['username'] ? $this->request->getData()['username'] : '';



            $conditions = array(

                                 'Users.username' => $username,

                                 'Users.role_id' => 2

                                );

            $joins = array(

                            array(

                                'table' => 'details',

                                'alias' => 'Details',

                                'type' => 'INNER',

                                'conditions' => array('Details.user_id = Users.id')

                            )

                        );



            $sponserInfo = $usersTable->find('all', array('fields' => array('Users.id', 'Users.email', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name'), 'conditions' =>$conditions, 'join' => $joins))->first();

            $this->set('sponserInfo', $sponserInfo);

            $this->set('username', $username);

        }



    }



    public function checkEmail(){

        

        $this->viewBuilder()->setLayout('ajax');



        $usersTable = TableRegistry::get('Users');



        $userInfo = array();

        if($this->request->is('post')){

            $usersTable = TableRegistry::get('Users');

            $email = $this->request->getData()['email'] ? $this->request->getData()['email'] : '';



            $conditions = array(

                                 'Users.email' => $email

                                );



            $userInfo = $usersTable->find('all', array('fields' => array('Users.id'), 'conditions' =>$conditions))->first();

        

        }



        $this->set('userInfo', $userInfo);

    }



    public function ajaxUpload() {

        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');



        $attachment = array();

        $file_format = 1;

        $file_size = 2;

        if($this->request->is('post')){

            

            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

                $file_type = $_FILES['file']['type'];

                $get_file_size =  ($_FILES['file']['size'])/(1024*1024);

                if($get_file_size <= 0.5){

                    if($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif'){



                        $rand_number = rand(145365684, 999999999);

                    

                        $media_tmp_name = $_FILES['file']['tmp_name'];

                        

                        $ex_type = explode("/", $file_type);



                        if($ex_type[1] == 'msword'){

                            $attachment = md5($rand_number).'.doc';

                        }else{

                            $attachment = md5($rand_number).'.'.$ex_type[1];

                        }

            

                        $uploadedpath = WWW_ROOT . 'attachments' . DS . $attachment;



                        if(move_uploaded_file($media_tmp_name, $uploadedpath)){



                            $attachment_to_insert = $attachment;

                            $media_save_data = array(

                                                        'file' => $attachment_to_insert,

                                                        'status' => 1

                                                    );



                            $attachmentData        =  $attachmentsTable->newEmptyEntity();

                            $attachmentData->file  =  $attachment_to_insert;

                            if($attachmentsTable->save($attachmentData)){

                                $attachment_id = $attachmentData->id;

                                $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $attachment_id)))->first();

                            }

                        }

                    }else{

                        $file_format = 0;

                    }

                }else{

                    $file_size = 3;

                }

            }

        }

        $this->set('attachment', $attachment);

        $this->set('file_format', $file_format);

        $this->set('file_size', $file_size);

    }



    public function idProofUpload() {

        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');



        $attachment = array();

        $file_format = 1;

        $file_size = 2;

        if($this->request->is('post')){

            

            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

                $file_type = $_FILES['file']['type'];

                $get_file_size =  ($_FILES['file']['size'])/(1024*1024);

                if($get_file_size <= 0.5){

                    if($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif'){



                        $rand_number = rand(145365684, 999999999);

                    

                        $media_tmp_name = $_FILES['file']['tmp_name'];

                        

                        $ex_type = explode("/", $file_type);



                        if($ex_type[1] == 'msword'){

                            $attachment = md5($rand_number).'.doc';

                        }else{

                            $attachment = md5($rand_number).'.'.$ex_type[1];

                        }

            

                        $uploadedpath = WWW_ROOT . 'attachments' . DS . $attachment;



                        if(move_uploaded_file($media_tmp_name, $uploadedpath)){



                            $attachment_to_insert = $attachment;

                            $media_save_data = array(

                                                        'file' => $attachment_to_insert,

                                                        'status' => 1

                                                    );



                            $attachmentData        =  $attachmentsTable->newEmptyEntity();

                            $attachmentData->file  =  $attachment_to_insert;

                            if($attachmentsTable->save($attachmentData)){

                                $attachment_id = $attachmentData->id;

                                $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $attachment_id)))->first();

                            }

                        }

                    }else{

                        $file_format = 0;

                    }

                }else{

                    $file_size = 3;

                }

            }

        }

        $this->set('attachment', $attachment);

        $this->set('file_format', $file_format);

        $this->set('file_size', $file_size);

    }



    public function addressProofUpload() {

        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');



        $attachment = array();

        $file_format = 1;

        $file_size = 2;

        if($this->request->is('post')){

            

            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

                $file_type = $_FILES['file']['type'];

                $get_file_size =  ($_FILES['file']['size'])/(1024*1024);

                if($get_file_size <= 0.5){

                    if($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif'){



                        $rand_number = rand(145365684, 999999999);

                    

                        $media_tmp_name = $_FILES['file']['tmp_name'];

                        

                        $ex_type = explode("/", $file_type);



                        if($ex_type[1] == 'msword'){

                            $attachment = md5($rand_number).'.doc';

                        }else{

                            $attachment = md5($rand_number).'.'.$ex_type[1];

                        }

            

                        $uploadedpath = WWW_ROOT . 'attachments' . DS . $attachment;



                        if(move_uploaded_file($media_tmp_name, $uploadedpath)){



                            $attachment_to_insert = $attachment;

                            $media_save_data = array(

                                                        'file' => $attachment_to_insert,

                                                        'status' => 1

                                                    );



                            $attachmentData        =  $attachmentsTable->newEmptyEntity();

                            $attachmentData->file  =  $attachment_to_insert;

                            if($attachmentsTable->save($attachmentData)){

                                $attachment_id = $attachmentData->id;

                                $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $attachment_id)))->first();

                            }

                        }

                    }else{

                        $file_format = 0;

                    }

                }else{

                    $file_size = 3;

                }

            }

        }

        $this->set('attachment', $attachment);

        $this->set('file_format', $file_format);

        $this->set('file_size', $file_size);

    }



    public function commonUpload() {

        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');

        $fieldName = '';

        $attachment = array();

        $file_format = 1;

        $file_size = 2;

        if($this->request->is('post')){

            

            if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

                $file_type = $_FILES['file']['type'];

                $get_file_size =  ($_FILES['file']['size'])/(1024*1024);

                if($get_file_size <= 0.5){

                    if($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif'){



                        $rand_number = rand(145365684, 999999999);

                    

                        $media_tmp_name = $_FILES['file']['tmp_name'];

                        

                        $ex_type = explode("/", $file_type);



                        if($ex_type[1] == 'msword'){

                            $attachment = md5($rand_number).'.doc';

                        }else{

                            $attachment = md5($rand_number).'.'.$ex_type[1];

                        }

            

                        $uploadedpath = WWW_ROOT . 'attachments' . DS . $attachment;



                        if(move_uploaded_file($media_tmp_name, $uploadedpath)){



                            $attachment_to_insert = $attachment;

                            $media_save_data = array(

                                                        'file' => $attachment_to_insert,

                                                        'status' => 1

                                                    );



                            $attachmentData        =  $attachmentsTable->newEmptyEntity();

                            $attachmentData->file  =  $attachment_to_insert;

                            if($attachmentsTable->save($attachmentData)){

                                $attachment_id = $attachmentData->id;

                                $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $attachment_id)))->first();

                            }

                        }

                    }else{

                        $file_format = 0;

                    }

                }else{

                    $file_size = 3;

                }

            }

            $fieldName = $this->request->getData()['fieldName'];

        }

        $this->set('fieldName', $fieldName);

        $this->set('attachment', $attachment);

        $this->set('file_format', $file_format);

        $this->set('file_size', $file_size);

    }



    public function removeAttachment($intId) {



        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');



        $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $intId)))->first();

        if(!empty($attachment)){

            if(unlink(WWW_ROOT . 'attachments' . DS . $attachment->file)){

                //$attachmentsTable->delete($intId);

                $attachmentData = $attachmentsTable->get($attachment->id);

                $result = $attachmentsTable->delete($attachmentData);

            }

        }

        $this->autoRender = false;

        

    }



    // It was getName()

    public function getUserDetails($username) {
        $this->viewBuilder()->setLayout('ajax');
        $usersTable = TableRegistry::get('Users');

        $user = $usersTable->find('all', array('conditions' => array('Users.username' => $username)))->first();
        $this->set('user', $user);
    }





    public function showAttachments($intAttachmentId) {



        $this->viewBuilder()->setLayout('ajax');



        $attachmentsTable = TableRegistry::get('Attachments');



        $attachment = $attachmentsTable->find('all', array('conditions' => array('Attachments.id' => $intAttachmentId)))->enableAutoFields(true)->first();

        $this->set('attachment', $attachment);

    }



    public function viewPackageDetails($intId) {



        $this->viewBuilder()->setLayout('ajax');



        $packagesTable = TableRegistry::get('Packages');

        $bitcoinsTable = TableRegistry::get('Bitcoins');



        $package_id = base64_decode($intId);



        $package = $packagesTable->find('all', array('conditions' => array('Packages.id' => $package_id)))->enableAutoFields(true)->first();

        

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



        $conditions = array('Bitcoins.status' => 1);



        $bitcoin = $bitcoinsTable->find('all', array('fields' => $fields,  'join' => $join, 'conditions' => $conditions, 'order' => $order, 'limit' => 1))->enableAutoFields(true)->first();



        $this->set('package', $package);

        $this->set('bitcoin', $bitcoin);



    }



    public function viewProductDetails($intId) {



        if(!$this->request->getSession()->check('userId') || empty($this->user)){

            return $this->redirect($this->home_url.'/user/login');

        }



        if($this->user->status != 1 && $this->user->status != 3){

            $this->Flash->error(__('Your account is not verified. To verify your account please enter below sent OTP to your registered contact number.'));

            return $this->redirect($this->home_url.'/user/verify-account');

        }



        $this->viewBuilder()->setLayout('ajax');



        $productsTable = TableRegistry::get('Products');

        $ordersTable = TableRegistry::get('Orders');

        $orderedItemsTable = TableRegistry::get('Ordereditems');

        $walletsTable = TableRegistry::get('Wallets');

        $upgradesTable = TableRegistry::get('Upgrades');

        $cartsTable = TableRegistry::get('Carts');



        $productId = base64_decode($intId);



        $conditions = array(

                            'Products.id' => $productId

                        );



        $join = array(

                        array(

                            'table' => 'attachments',

                            'alias' => 'Attachments',

                            'type' => 'LEFT',

                            'conditions' => array('Attachments.id = Products.attachment_id')

                        )

                    );



        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');



        $product = $productsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        

        $this->set('product', $product);



         $join = array(

                        array(

                            'table' => 'orders',

                            'alias' => 'Orders',

                            'type' => 'INNER',

                            'conditions' => array('Orders.id = Ordereditems.order_id')

                        )

                    );



        $conditions = array(

                            'Ordereditems.product_id' => $productId,

                            'Orders.status IN(1,2)'

                        );



        $totalSoldQuantity = $orderedItemsTable->find('all', array('join' => $join, 'conditions' => $conditions))->count();

        $this->set('totalSoldQuantity', $totalSoldQuantity);





        if($this->request->is('post')){

            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/



            if(isset($this->request->getData()['btn_cart'])){



                if(isset($this->request->getData()['Cart']['quantity']) && $this->request->getData()['Cart']['quantity'] > 0){



                    $conditions = array(

                                        'Carts.user_id' => $this->user->id,

                                        'Carts.product_id' => $product->id

                                    );

                    $cart = $cartsTable->find('all', array('conditions' => $conditions))->first();



                    if(!empty($cart)){



                        $cartData = $cartsTable->get($cart->id);

                        $cartData->user_id = $this->user->id;

                        $cartData->product_id = $product->id;

                        $cartData->quantity = $cart->quantity + $this->request->getData()['Cart']['quantity'];



                    }else{

                        $cartData = $cartsTable->newEmptyEntity();

                        $cartData->user_id = $this->user->id;

                        $cartData->product_id = $product->id;

                        $cartData->quantity = $this->request->getData()['Cart']['quantity'];

                    }

                    if($cartsTable->save($cartData)){

                        $this->Flash->success(__('Product has been added to the cart. To place an order please <a href="'.$this->home_url.'/my-account/checkout" target="_parent" class="click-here-to-checkout">click here</a>.'));

                        

                        return $this->redirect($this->home_url.'/ajax/view_product_details/'.$intId);

                    }else{

                        $this->Flash->error(__('Something went wrong! Product has not been added to cart.'));

                    } 

                }else{

                    $this->Flash->error(__('Please fill the required fields.'));

                }

                    



            }



            /*$price = $product->price;

            if(!empty($product->discount_price)){

                 $price = $product->discount_price;

            }

            $query = $walletsTable->find(); 

            $totalWalletAmount = $query->select(['sum' => $query->func()->sum('Wallets.amount')])->where(['Wallets.user_id' => $this->user->id])->first();

            $walletAmount = isset($totalWalletAmount->sum) && !empty($totalWalletAmount->sum) ? $totalWalletAmount->sum : 0;



            $fields = array('Upgrades.package_amount');

            $conditions = array('Upgrades.upgraded_id' => $this->user->id);

            $order = array('Upgrades.id' => 'DESC');

            $upgrade = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order))->first();



            $upgradePackageAmount = isset($upgrade->package_amount) && !empty($upgrade->package_amount) ? $upgrade->package_amount : 0;



            $walletAmount = $walletAmount + $upgradePackageAmount;



            if($walletAmount < $price){

                $this->Flash->error(__('Sorry! Product can not be bought because insufficient fund.'));

            }else{



                $orderId = $ordersTable->getUniqueOrderId();

                $orderData = $ordersTable->newEmptyEntity();

                $orderData->user_id = $this->user->id;

                $orderData->product_id = $product->id;

                $orderData->order_id = $orderId;

                $orderData->quantity = 1;

                $orderData->price = $product->price;

                $orderData->discount = $product->discount;

                $orderData->discount_price = $product->discount_price;

                $orderData->business_volume = $product->business_volume;

                $orderData->business_point = $product->business_point;

                $orderData->status = 1;

                if($ordersTable->save($orderData)){



                    $transactionId = $walletsTable->getTransactionId(11);

                    $walletData = $walletsTable->newEmptyEntity();

                    $walletData->user_id = $this->user->id;

                    $walletData->transaction_id = $transactionId;

                    $walletData->amount = '-'.$price;

                    $walletData->remark = 'Shopping';

                    $walletData->status = 1;

                    $walletsTable->save($walletData);

                    $this->Flash->success(__('Thanks for your placing your order with us. Your ordered item will be delivered shortly.'));

                    return $this->redirect(['controller' => 'ajax', 'action' => 'view_product_details',$intId]);



                }

            }*/

        }



    }



    public function filterStates($country, $stateContainer, $fieldName, $cls) {



        $this->viewBuilder()->setLayout('ajax');



        $statesTable = TableRegistry::get('States');



        $this->set('stateContainer', $stateContainer);



        $this->set('fieldName', $fieldName);



        $this->set('cls', $cls);

        

        $states = $statesTable->find('all', array('conditions' => array('States.country_id' => $country), 'order' => 'States.name asc', 'group' => array('States.name')));

        

        $state_data = array();

        $state_data[''] = '-Select-';

        foreach($states as $state){

            $state_data[$state->id] = $state->name;

        };

        $this->set('states', $state_data);

    }



    public function filterSites($property, $siteContainer, $fieldName, $cls) {



        $this->viewBuilder()->setLayout('ajax');



        $sitesTable = TableRegistry::get('Sites');



        $this->set('siteContainer', $siteContainer);



        $this->set('fieldName', $fieldName);



        $this->set('cls', $cls);

        

        $conditions = array(

                            'Sites.property_id' => $property,

                            'Sites.status' => 1

                        );

        $order = array('Sites.title' => 'ASC');

        $sites = $sitesTable->find('all', array('conditions' => $conditions, 'order' => $order));

        

        $sites_data = array();

        $sites_data[''] = '-Select Site-';

        foreach($sites as $site){

            $sites_data[$site->id] = $site->title;

        };

        $this->set('sites', $sites_data);

    }



    public function filterBlocks($site, $blockContainer, $fieldName, $cls) {



        $this->viewBuilder()->setLayout('ajax');



        $blocksTable = TableRegistry::get('Blocks');



        $this->set('blockContainer', $blockContainer);



        $this->set('fieldName', $fieldName);



        $this->set('cls', $cls);

        

        $conditions = array(

                            'Blocks.site_id' => $site,

                            'Blocks.status' => 1,

                        );

        $order = array('Blocks.title' => 'ASC');

        $blocks = $blocksTable->find('all', array('conditions' => $conditions, 'order' => $order));

        

        $blocks_data = array();

        $blocks_data[''] = '-Select Block-';

        foreach($blocks as $block){

            $blocks_data[$block->id] = $block->title;

        };

        $this->set('blocks', $blocks_data);

    }



    public function filterPlots($block, $plotContainer, $fieldName, $cls) {



        $this->viewBuilder()->setLayout('ajax');



        $plotsTable = TableRegistry::get('Plots');



        $this->set('plotContainer', $plotContainer);



        $this->set('fieldName', $fieldName);



        $this->set('cls', $cls);

        

        $conditions = array(

                            'Plots.block_id' => $block,

                            'Plots.status' => 1,

                        );

        $order = array('Plots.name' => 'ASC');

        $plots = $plotsTable->find('all', array('conditions' => $conditions, 'order' => $order));

        

        $plots_data = array();

        $plots_data[''] = '-Select Plot No-';

        foreach($plots as $plot){

            if(!empty($plot->plot_number)){

                $plots_data[$plot->id] = $plot->plot_number;

            }

        };

        $this->set('plots', $plots_data);



    }



    public function getPlotDetails($intPlotId) {



        $this->viewBuilder()->setLayout('ajax');



        $plotsTable = TableRegistry::get('Plots');

        

        $conditions = array(

                            'Plots.id' => $intPlotId

                        );

        $plot = $plotsTable->find('all', array('conditions' => $conditions))->first();

        $this->set('plot', $plot);



        /*echo '<pre>';

        print_r($plot);*/



    }



    public function filterPlotsByUser($userId, $plotContainer, $fieldName, $cls) {



        $this->viewBuilder()->setLayout('ajax');



        $assignPlotsTable = TableRegistry::get('AssignPlots');



        $this->set('plotContainer', $plotContainer);



        $this->set('fieldName', $fieldName);



        $this->set('cls', $cls);



        $join = array(

                        array(

                            'table' => 'plots',

                            'alias' => 'Plots',

                            'type' => 'INNER',

                            'conditions' => array('Plots.id = AssignPlots.plot_id')

                        )

                    );

        

        $conditions = array(

                            'AssignPlots.user_id' => $userId,

                            'AssignPlots.status' => 1,

                        );

        $order = array('Plots.name' => 'ASC');

        $fields = array("AssignPlots.id", "AssignPlots.plot_number", 'Plots.id', 'Plots.name');

        $assignPlots = $assignPlotsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order))->toArray();

        

        $plots_data = array();

        $plots_data[''] = '-Select Plot Number-';

        foreach($assignPlots as $assignPlot){

            //$plots_data[$assignPlot->id] = $assignPlot->Plots['name'];

            $plots_data[$assignPlot->id] = $assignPlot->plot_number;

        };

        $this->set('plots', $plots_data);

        

    }



     public function getCurrentRateByPlan($planId) {



        $this->viewBuilder()->setLayout('ajax');



        $currentRatesTable = TableRegistry::get('CurrentRates');

        

        $conditions = array(

                            'CurrentRates.plan' => $planId,

                            'CurrentRates.status' => 1

                        );

        $assignPlot = $currentRatesTable->find('all', array('conditions' => $conditions))->first();

        

        $this->set('assignPlot', $assignPlot);

        

    }



    public function referralLink(){

        if(!$this->request->getSession()->check('userId') || empty($this->user)){

            return $this->redirect($this->home_url.'/user/login');

        }

        /*if($this->user->status != 1){

            $this->Flash->error(__('Your account is not verified. To verify your account please enter below sent OTP to your registered contact number.'));

            return $this->redirect($this->home_url.'/user/verify-account');

        }*/



        $this->viewBuilder()->setLayout('ajax');



        $prefix_title = Configure::read('SITETITLE');

        

        $title = $prefix_title.' Rerral Link';



        $this->set('title', $title);



        $usersTable = TableRegistry::get('Users');



    }



    public function getRoiAndRolaltyByMonth($month){



       $this->viewBuilder()->setLayout('ajax');



       $date = date('Y').'-'.$month.'-'.date('d');

       $previousMonth = date("Y-m-d", strtotime("-1 months", strtotime($date)));

       $previousMonthLastDate = date("Y-m-t", strtotime($previousMonth));

       

       $upgradesTable = TableRegistry::get('Upgrades');



        $join = array(

                        array(

                            'table' => 'packages',

                            'alias' => 'Packages',

                            'type' => 'INNER',

                            'conditions' => array('Packages.id = Upgrades.package_id')

                        )

                    );

        $conditions = array('MONTH(Upgrades.created)' => $month, 'YEAR(Upgrades.created)' => date('Y'));



        $upgrades = $upgradesTable->find('all', array('join' => $join, 'conditions' => $conditions))

                                 ->select([

                                            'total_businnes_value' => 'SUM(Packages.package_bv)',

                                            'total_business_point' => '(SELECT SUM(u.business_point) FROM upgrades u WHERE DATE(u.created)<="'.$previousMonthLastDate.'")'

                                        ])->first();

        

        $this->set('upgrades', $upgrades);

        //$this->autoRender = false;





    }



    public function getPlotPaymentInfo($intUserId){



        $this->viewBuilder()->setLayout('ajax');



        $plotPaymentsTable = TableRegistry::get('PlotPayments');



        $conditions = array(

                            'PlotPayments.user_id' => $intUserId

                        );

        $plotPaymentInfo = $plotPaymentsTable->find('all', array('conditions' => $conditions))->count();



        echo $plotPaymentInfo;



        $this->autoRender = false;



    }

    public function getFullName($username, $roleId){

        $this->viewBuilder()->setLayout('ajax');

        $usersTable = TableRegistry::get('Users');

        $conditions = ['Users.username' => $username, 'Users.role_id' => $roleId];

        $sponserInfo = $usersTable->find('all', array('conditions' =>$conditions))->first();

        $this->set('sponserInfo', $sponserInfo);
    }

    public function getMbPackages($username){

        $this->viewBuilder()->setLayout('ajax');
        $packagesTable = TableRegistry::get('Packages');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id AND Users.username = '".$username."'"],
            ]
        ];
        $conditions = ['Packages.plan_id' => 2, 'Packages.status IS NULL'];
        $packages = $packagesTable->find('all', ['join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
    }

    public function getAbPackages($username, $fieldName, $isAmountFilter = 0, $planId = 1){
        $this->viewBuilder()->setLayout('ajax');
        $packagesTable = TableRegistry::get('Packages');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Packages.user_id AND Users.username = '".$username."'"],
            ]
        ];
        $conditions = ['Packages.plan_id' => $planId, 'Packages.status IS NULL'];
        $packages = $packagesTable->find('all', ['join' => $join, 'conditions' => $conditions])->toArray();

        $this->set('packages', $packages);
        $this->set('fieldName', $fieldName);
        $this->set('isAmountFilter', $isAmountFilter);
    }

    public function checkPackageDetails($packageId){
        $this->viewBuilder()->setLayout('ajax');
        $billsTable = TableRegistry::get('Bills');
        $packagesTable = TableRegistry::get('Packages');

        $conditions = ['Packages.id' => $packageId];
        $package = $packagesTable->find('all', ['conditions' => $conditions])->first();
        $bill = $billsTable->getPackageBillDetails($packageId);

        $currentMonthLimit = $package->return_amount/$package->number_of_month;
        
        $currentRemainingAmount = $currentMonthLimit;
        if ($package->return_amount <= $bill->total_spent_amount) {
           $isAllow = 2;
        } if ($currentMonthLimit <= $bill->current_month_spent_amount) {
           $isAllow = 3;
        } else {
            $isAllow = 1;
            $currentRemainingAmount = $currentMonthLimit - $bill->current_month_spent_amount;
        }

        $this->set('isAllow', $isAllow);
        $this->set('currentRemainingAmount', $currentRemainingAmount);
    }

    public function getPackageAmount($packageId){
        $this->viewBuilder()->setLayout('ajax');
        $packagesTable = TableRegistry::get('Packages');

        $conditions = ['Packages.id' => $packageId];
        $package = $packagesTable->find('all', ['conditions' => $conditions])->first();
        $this->set('package', $package);
    }

    public function getRankDetails($amountType, $userId)
    {
        $this->viewBuilder()->setLayout('datatable');
        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ]
        ];
        $conditions = ['Payouts.'.$amountType.' > 0', 'Payouts.upagraded_user_id' => $userId];
        $fields = [
                "Payouts.id",
                "Payouts.explorer_rank_amount",
                "Payouts.contributor_rank_amount",
                "Payouts.expert_contributor_amount",
                "Payouts.rising_rank_amount",
                "Payouts.rising_star_rank_amount",
                "Payouts.master_star_rank_amount",
                "Payouts.mentor_rank_amount",
                "Payouts.super_mentor_rank_amount",
                "Payouts.master_rank_amount",
                "Payouts.master_mentor_rank_amount",
                "Payouts.created",
                "Users.username",
                "Users.name"
            ];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
            ->toArray();

        $this->set('amountType', $amountType);
        $this->set('payouts', $payouts);
    }

    public function getAmountDetails($amountType, $userId, $packageAmount = '')
    {
        $this->viewBuilder()->setLayout('datatable');
        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ]
        ];
        if ($packageAmount) {
            $conditions = ['Payouts.'.$amountType.' > 0', 'Payouts.upagraded_user_id' => $userId, 'Payouts.package_amount' => $packageAmount];
        } else {
            $conditions = ['Payouts.'.$amountType.' > 0', 'Payouts.upagraded_user_id' => $userId];
        }
        $fields = [
                "Users.username",
                "Users.name"
            ];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
            ->enableAutoFields(true)->toArray();

        $this->set('amountType', $amountType);
        $this->set('payouts', $payouts);

        $templates = 'get_amount_details';
        if($amountType == 'roi') {
            $templates = 'roi_amount_details';
        }

        $this->render($templates);
    }

    public function getWalletDetails($userId)
    {
        $this->viewBuilder()->setLayout('datatable');
        $fundrequestsTable  = TableRegistry::get('Fundrequests');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Fundrequests.user_id"],
            ]
        ];
        $conditions = ['Fundrequests.user_id' => $userId];
        $fields = [
                "Users.username",
                "Users.name"
            ];
        $fundrequests = $fundrequestsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
            ->enableAutoFields(true)->toArray();
            
        $this->set('fundrequests', $fundrequests);;
    }
}

