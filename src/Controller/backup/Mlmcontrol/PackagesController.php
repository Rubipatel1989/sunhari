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
class PackagesController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Packages';

        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                                'Packages.status !=' => 2
                            );
        $join = array(
                        array(
                            'table' => 'attachments',
                            'alias' => 'Attachments',
                            'type' => 'LEFT',
                            'conditions' => array('Attachments.reference_id = Packages.id', 'Attachments.reference_type = "package"')
                        )
                    );
        $order = array('Packages.id' => 'DESC');

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $packages = $packagesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('packages', $packages);
    
    }

    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Package | Add';

        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $attachmentsTable = TableRegistry::get('Attachments');

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/
            $postData = $this->request->getData();
            $package = $packagesTable->newEmptyEntity();
            $package->name             =  $postData['Package']['name'];
            $package->description      =  $postData['Package']['description'];
            $package->package_bv       =  $postData['Package']['package_bv'];
            $package->package_amount   =  $postData['Package']['package_amount'];
            $package->direct_amount    =  $postData['Package']['direct_amount'];
            $package->roi_amount       =  $postData['Package']['roi_amount'];
            $package->business_point   =  $postData['Package']['business_point'];
            $package->booster_time     =  $postData['Package']['booster_time'];
            $package->booster_amount   =  $postData['Package']['booster_amount'];
            $package->position         =  $postData['Package']['position'];
            $package->allowed_links    =  $postData['Package']['allowed_links'];
            $package->status           =  $postData['Package']['status'];
            $packagesTable->save($package);
            if($packagesTable->save($package)){
                
                $package_id = $package->id; 
                if(isset($postData['Attachment']['id']) && !empty($postData['Attachment']['id'])){
                    $i = 0;
                    foreach($postData['Attachment']['id'] as $attachmentId){
                        $attachment = $attachmentsTable->get($attachmentId);
                        $attachment->reference_id = $package_id;
                        $attachment->reference_type = 'package';
                        $attachment->caption = $postData['Attachment']['caption'][$i];
                        $attachmentsTable->save($attachment);
                        $i++;
                    }
                }
                $this->Flash->success(__('Congratulations! Package has been added successfully.'));
                return $this->redirect($this->backend_url.'/packages/index');
            }
        }
    }

    public function edit($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Package | Edit';

        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Packages.status !=' => 2,
                            'Packages.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Packages.id', 'Attachments.reference_type = "package"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $packageInfo = $packagesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($packageInfo)){
            return $this->redirect($this->backend_url.'/packages/index');
        }

        $this->set('packageInfo', $packageInfo);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->getData());exit;*/
            $postData = $this->request->getData();
            $package = $packagesTable->get($postData['Package']['id']);
            $package->name             =  $postData['Package']['name'];
            $package->description      =  $postData['Package']['description'];
            $package->package_bv       =  $postData['Package']['package_bv'];
            $package->package_amount   =  $postData['Package']['package_amount'];
            $package->direct_amount    =  $postData['Package']['direct_amount'];
            $package->roi_amount       =  $postData['Package']['roi_amount'];
            $package->business_point   =  $postData['Package']['business_point'];
            $package->booster_time     =  $postData['Package']['booster_time'];
            $package->booster_amount   =  $postData['Package']['booster_amount'];
            $package->allowed_links    =  $postData['Package']['allowed_links'];
            $package->position         =  $postData['Package']['position'];
            $package->status           =  $postData['Package']['status'];

            if($packagesTable->save($package)){
                $package_id = $postData['Package']['id'];
                if(isset($postData['Attachment']['id']) && !empty($postData['Attachment']['id'])){
                    $i = 0;
                    foreach($postData['Attachment']['id'] as $attachmentId){
                        $attachment = $attachmentsTable->get($attachmentId);
                        $attachment->reference_id = $package_id;
                        $attachment->reference_type = 'package';
                        $attachment->caption = $postData['Attachment']['caption'][$i];
                        $attachmentsTable->save($attachment);
                        $i++;
                    }
                }
                $this->Flash->success(__('Congratulations! Package has been updated successfully.'));
                return $this->redirect($this->backend_url.'/packages/index');
            }
        }
    }

    public function updateStatus($intId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        if(!isset($intStatus)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Package | Update Status';

        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Packages.status !=' => 2,
                            'Packages.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Packages.id', 'Attachments.reference_type = "package"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $packageInfo = $packagesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($packageInfo)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $package = $packagesTable->get($intId);
        $package->status = $intStatus;
        if($packagesTable->save($package)){
            $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
            return $this->redirect($this->backend_url.'/packages/index');
        }

        $this->render(false);
    }

    public function delete($intId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        if(!isset($intId)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Package | Update Status';

        $this->set('title', $title);

        $packagesTable = TableRegistry::get('Packages');
        $attachmentsTable = TableRegistry::get('Attachments');

        $conditions = array(
                            'Packages.status !=' => 2,
                            'Packages.id' => $intId
                        );
        $join = array(
                    array(
                        'table' => 'attachments',
                        'alias' => 'Attachments',
                        'type' => 'LEFT',
                        'conditions' => array('Attachments.reference_id = Packages.id', 'Attachments.reference_type = "package"')
                    )
                );

        $fields =  array('Attachments.id', 'Attachments.reference_id', 'Attachments.reference_type', 'Attachments.file', 'Attachments.caption');

        $packageInfo = $packagesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($packageInfo)){
            return $this->redirect(['controller' => 'packages', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $package = $packagesTable->get($intId);
        $package->status = 2;
        if($packagesTable->save($package)){
            $this->Flash->success(__('Congratulations! Package has been updated successfully.'));
            return $this->redirect($this->backend_url.'/packages/index');
        }

        $this->render(false);
    }
}
