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

class OrdersController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
           return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Orders';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $ordersTable  = TableRegistry::get('Orders');

        $conditions = array();

        $order = array('Orders.id' => 'DESC');

        $join = array(
                        array(
                            'table' => 'users',
                            'alias' => 'Users',
                            'type' => 'INNER',
                            'conditions' => array('Users.id = Orders.user_id')
                        )
                    );
        $fields = array('Users.id', 'Users.username');
        $orders = $ordersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'order' => $order))
                            ->contain(['Ordereditems'])
                            ->enableAutoFields(true)->toArray();
        $this->set('orders', $orders);
        
        /*echo '<pre>';
        print_r($orders);
        exit;*/
    }

    public function changeStatus($encOrderId, $intStatus){

        if(!$this->request->getSession()->check('adminUserId')){
           return $this->redirect($this->backend_url.'/user/login');
        }

        $ordersTable  = TableRegistry::get('Orders');

        $orderId = base64_decode($encOrderId);

        $orderData = $ordersTable->get($orderId);
        $orderData->status = $intStatus;
        if($ordersTable->save($orderData)){
            $this->Flash->success(__('Order Status has been updated successfully.'));

            return $this->redirect($this->backend_url.'/orders/index');
        }
        $this->render(false);
    }

}
