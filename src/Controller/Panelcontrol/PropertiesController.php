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
class PropertiesController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Properties';

        $this->set('title', $title);

        $propertiesTable = TableRegistry::get('Properties');

        $conditions = array();

        $order = array('Properties.id' => 'DESC');

        $properties = $propertiesTable->find('all', array('conditions' => $conditions, 'order' => $order))->contain(['Emis'])->autoFields(true)->toArray();

        $this->set('properties', $properties);

        /*echo '<pre>';
        print_r($propertties);
        exit;*/
    
    }

    public function addProperty(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roi | Add Property';

        $this->set('title', $title);

        $propertiesTable = TableRegistry::get('Properties');
        $emisTable = TableRegistry::get('Emis');

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);
            exit;*/

            if(
                isset($this->request->data['Emi']['amount']) && !empty($this->request->data['Emi']['amount'])
            ){

                $name = isset($this->request->data['Property']['name']) ? trim($this->request->data['Property']['name']) : NULL;
                $property_area = isset($this->request->data['Property']['property_area']) ? trim($this->request->data['Property']['property_area']) : NULL;
                $amount = isset($this->request->data['Property']['amount']) ? trim($this->request->data['Property']['amount']) : NULL;
                $status = isset($this->request->data['Property']['status']) ? trim($this->request->data['Property']['status']) : NULL;
                $number_of_emi = isset($this->request->data['Property']['number_of_emi']) ? trim($this->request->data['Property']['number_of_emi']) : NULL;

                if(!empty($name) && !empty($property_area) && !empty($amount) && !empty($status) && !empty($number_of_emi)){

                    $propertyData = $propertiesTable->newEntity();
                    $propertyData->name = $name;
                    $propertyData->property_area = $property_area;
                    $propertyData->amount = $amount;
                    $propertyData->number_of_emi = $number_of_emi;
                    $propertyData->status = $status;

                    if($propertiesTable->save($propertyData)){
                        $propetyId = $propertyData->id;
                        $emisTable->deleteAll(['property_id' => $propetyId]);
                        $i = 0;
                        foreach($this->request->data['Emi']['amount'] as $amount){

                            if(!empty($amount)){

                                $emiData = $emisTable->newEntity();
                                $emiData->property_id = $propetyId;
                                $emiData->amount = $amount;
                                $emiData->direct_amount = isset($this->request->data['Emi']['direct_amount'][$i]) ? trim($this->request->data['Emi']['direct_amount'][$i]) : NULL;
                                $emiData->matching_amount = isset($this->request->data['Emi']['matching_amount'][$i]) ? trim($this->request->data['Emi']['matching_amount'][$i]) : NULL;
                                $emisTable->save($emiData);
                            }
                            $i++;

                        }
                        $this->Flash->success(__('Congratulations! Property has been added successfully.'));
                        return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);
                    }

                }else{
                    $this->Flash->error(__('Please fill all required fields.'));
                }

            }else{

                $this->Flash->error(__('Please fill EMI details.'));
            }
            
        }
    }

    public function editProperty($encPropertyId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roi | Edit Property';

        $this->set('title', $title);

        $propertiesTable = TableRegistry::get('Properties');
        $emisTable = TableRegistry::get('Emis');

        if(!isset($encPropertyId)){
            return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $propertyId = base64_decode($encPropertyId);

        $conditions = array('Properties.id' => $propertyId);

        $order = array('Properties.id' => 'DESC');

        $property = $propertiesTable->find('all', array('conditions' => $conditions, 'order' => $order))->contain(['Emis'])->autoFields(true)->first();

        if(empty($property)){
            return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $this->set('property', $property);

        if($this->request->is('post')){
            /*echo '<pre>';
            print_r($this->request->data);
            exit;*/

            if(
                isset($this->request->data['Property']['amount']) && !empty($this->request->data['Property']['amount'])
            ){

                $name = isset($this->request->data['Property']['name']) ? trim($this->request->data['Property']['name']) : NULL;
                $property_area = isset($this->request->data['Property']['property_area']) ? trim($this->request->data['Property']['property_area']) : NULL;
                $amount = isset($this->request->data['Property']['amount']) ? trim($this->request->data['Property']['amount']) : NULL;
                $status = isset($this->request->data['Property']['status']) ? trim($this->request->data['Property']['status']) : NULL;
               // $number_of_emi = isset($this->request->data['Property']['number_of_emi']) ? trim($this->request->data['Property']['number_of_emi']) : NULL;

                if(!empty($name) && !empty($property_area) && !empty($amount) && !empty($status)){

                    $propertyData = $propertiesTable->get($propertyId);
                    $propertyData->name = $name;
                    $propertyData->property_area = $property_area;
                    $propertyData->amount = $amount;
                    $propertyData->status = $status;

                    $propertiesTable->save($propertyData);

                    /*if($propertiesTable->save($propertyData)){
                        $propetyId = $propertyId;
                        $emisTable->deleteAll(['property_id' => $propetyId]);
                        $i = 0;
                        foreach($this->request->data['Emi']['amount'] as $amount){

                            if(!empty($amount)){

                                $emiData = $emisTable->newEntity();
                                $emiData->property_id = $propetyId;
                                $emiData->amount = $amount;
                                $emiData->direct_amount = isset($this->request->data['Emi']['direct_amount'][$i]) ? trim($this->request->data['Emi']['direct_amount'][$i]) : NULL;
                                $emiData->matching_amount = isset($this->request->data['Emi']['matching_amount'][$i]) ? trim($this->request->data['Emi']['matching_amount'][$i]) : NULL;
                                $emisTable->save($emiData);
                            }
                            $i++;
                        }
                    }*/

                    $this->Flash->success(__('Congratulations! Property has been updated successfully.'));
                    return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);

                }else{
                    $this->Flash->error(__('Please fill all required fields.'));
                }

            }else{

                $this->Flash->error(__('Please fill EMI details.'));
            }
            
        }
    }

    public function changeStatus($encStatus, $encPropertyId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roi | Edit Property';

        $this->set('title', $title);

        $propertiesTable = TableRegistry::get('Properties');

        if(!isset($encStatus) || !isset($encPropertyId) ){
            return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $status = base64_decode($encStatus);
        
        $propertyId = base64_decode($encPropertyId);

        $conditions = array('Properties.id' => $propertyId);

        $order = array('Properties.id' => 'DESC');

        $property = $propertiesTable->find('all', array('conditions' => $conditions, 'order' => $order))->contain(['Emis'])->autoFields(true)->first();

        if(empty($property)){
            return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);
        }

        $propertyData = $propertiesTable->get($propertyId);
        $propertyData->status = $status;
        $propertiesTable->save($propertyData);
        $this->Flash->success(__('Congratulations! Status has been updated successfully.'));
        return $this->redirect(['controller' => 'properties', 'action' => 'index', 'prefix' => $this->backend]);

        $this->render(false);
    }
}
