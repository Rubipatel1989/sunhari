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
class ProductsController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Products';

        $this->set('title', $title);

        $productsTable = TableRegistry::get('Products');

        $conditions = array(
                                'Products.status !=' => 2
                            );
        $join = array(
                        array(
                            'table' => 'attachments',
                            'alias' => 'Attachments',
                            'type' => 'LEFT',
                            'conditions' => array('Attachments.id = Products.attachment_id')
                        )
                    );
        $order = array('Products.id' => 'DESC');

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $products = $productsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('products', $products);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Product | Add';

        $this->set('title', $title);

        $productsTable = TableRegistry::get('Products');
        $attachmentsTable = TableRegistry::get('Attachments');

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $productData = $productsTable->newEmptyEntity();
            $productData->user_id           =  $this->adminUser->id;
            $productData->attachment_id     =  isset($this->request->getData()['Product']['attachment_id'][0]) ? $this->request->getData()['Product']['attachment_id'][0] : NULL;
            $productData->name              =  isset($this->request->getData()['Product']['name']) ? $this->request->getData()['Product']['name'] : NULL;
            $productData->description       =  isset($this->request->getData()['Product']['description']) ? nl2br($this->request->getData()['Product']['description']) : NULL;
            $productData->price             =  isset($this->request->getData()['Product']['price']) ? $this->request->getData()['Product']['price'] : NULL;
            $productData->discount          =  isset($this->request->getData()['Product']['discount']) ? $this->request->getData()['Product']['discount'] : NULL;
            $productData->discount_price    =  isset($this->request->getData()['Product']['discount_price']) ? $this->request->getData()['Product']['discount_price'] : NULL;
            $productData->business_volume   =  isset($this->request->getData()['Product']['business_volume']) ? $this->request->getData()['Product']['business_volume'] : NULL;
            $productData->business_point    =  isset($this->request->getData()['Product']['business_point']) ? $this->request->getData()['Product']['business_point'] : NULL;
            $productData->quantity          =  isset($this->request->getData()['Product']['quantity']) ? $this->request->getData()['Product']['quantity'] : NULL;
            $productData->position          =  isset($this->request->getData()['Product']['position']) ? $this->request->getData()['Product']['position'] : NULL;
            $productData->status            =  isset($this->request->getData()['Product']['status']) ? $this->request->getData()['Product']['status'] : NULL;

            if($productsTable->save($productData)){
                $product_id = $productData->id;
                if(isset($this->request->getData()['Product']['attachment_id'][0]) && !empty($this->request->getData()['Product']['attachment_id'][0])){
                    $attachment = $attachmentsTable->get($this->request->getData()['Product']['attachment_id'][0]);
                    $attachment->reference_id = $product_id;
                    $attachment->reference_type = 'product';
                    $attachment->caption = $this->request->getData()['Product']['attachment_id']['caption'][0];
                    $attachmentsTable->save($attachment);
                }
                $this->Flash->success(__('Congratulations! Proudct has been added successfully.'));
                
                return $this->redirect($this->backend_url.'/products/index');
            }
        }
    }

    public function edit($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Product | Edit';

        $this->set('title', $title);

        $productsTable = TableRegistry::get('Products');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Products.status !=' => 2,
                            'Products.id' => $intId
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

        $productInfo = $productsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($productInfo)){
             return $this->redirect($this->backend_url.'/products/index');
        }

        /*echo '<pre>';
        print_r($productInfo);exit;*/

        $this->set('productInfo', $productInfo);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $productData = $productsTable->get($this->request->getData()['Product']['id']);
            $productData->user_id           =  $this->adminUser->id;
            $productData->attachment_id     =  isset($this->request->getData()['Product']['attachment_id'][0]) ? $this->request->getData()['Product']['attachment_id'][0] : NULL;
            $productData->name              =  isset($this->request->getData()['Product']['name']) ? $this->request->getData()['Product']['name'] : NULL;
            $productData->description       =  isset($this->request->getData()['Product']['description']) ? nl2br($this->request->getData()['Product']['description']) : NULL;
            $productData->price             =  isset($this->request->getData()['Product']['price']) ? $this->request->getData()['Product']['price'] : NULL;
            $productData->discount          =  isset($this->request->getData()['Product']['discount']) ? $this->request->getData()['Product']['discount'] : NULL;
            $productData->discount_price    =  isset($this->request->getData()['Product']['discount_price']) ? $this->request->getData()['Product']['discount_price'] : NULL;
            $productData->business_volume   =  isset($this->request->getData()['Product']['business_volume']) ? $this->request->getData()['Product']['business_volume'] : NULL;
            $productData->business_point    =  isset($this->request->getData()['Product']['business_point']) ? $this->request->getData()['Product']['business_point'] : NULL;
            $productData->quantity          =  isset($this->request->getData()['Product']['quantity']) ? $this->request->getData()['Product']['quantity'] : NULL;
            $productData->position          =  isset($this->request->getData()['Product']['position']) ? $this->request->getData()['Product']['position'] : NULL;
            $productData->status            =  isset($this->request->getData()['Product']['status']) ? $this->request->getData()['Product']['status'] : NULL;

            if($productsTable->save($productData)){
                $product_id = $productData->id;
                if(isset($this->request->getData()['Product']['attachment_id'][0]) && !empty($this->request->getData()['Product']['attachment_id'][0])){
                    $attachment = $attachmentsTable->get($this->request->getData()['Product']['attachment_id'][0]);
                    $attachment->reference_id = $product_id;
                    $attachment->reference_type = 'product';
                    $attachment->caption = $this->request->getData()['Product']['attachment_id']['caption'][0];
                    $attachmentsTable->save($attachment);
                }
                $this->Flash->success(__('Congratulations! Proudct has been updated successfully.'));
                return $this->redirect($this->backend_url.'/products/index');
            }
        }
    }

    public function updateStatus($intId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        if(!isset($intStatus)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Product | Update Status';

        $this->set('title', $title);

        $productsTable = TableRegistry::get('Products');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Products.status !=' => 2,
                            'Products.id' => $intId
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

        $productInfo = $productsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($productInfo)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        $package = $productsTable->get($intId);
        $package->status = $intStatus;
        if($productsTable->save($package)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect($this->backend_url.'/products/index');
        }

        $this->render(false);
    }

    public function delete($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Product | Update Status';

        $this->set('title', $title);

        $productsTable = TableRegistry::get('Products');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Products.status !=' => 2,
                            'Products.id' => $intId
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

        $productInfo = $productsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($productInfo)){
            return $this->redirect($this->backend_url.'/products/index');
        }

        $package = $productsTable->get($intId);
        $package->status = 2;
        if($productsTable->save($package)){
            $this->Flash->success(__('Congratulations! Product has been updated successfully.'));
            return $this->redirect($this->backend_url.'/products/index');
        }

        $this->render(false);
    }
}
