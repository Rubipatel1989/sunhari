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

class SupportController extends AppController
{

    public function tickets(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Tickets';

        $this->set('title', $title);

        $ticketsTable = TableRegistry::get('Tickets');

        $conditions = array('Tickets.status !=' => 2);
        $order = array('Tickets.id' => 'DESC');
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Tickets.ticket_by')
                    )
                );
        $fields = array('Users.id', 'Users.username');
        $tickets = $ticketsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();
        $this->set('tickets', $tickets);
        
    }

    public function viewTicket($ticketId){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' View Ticket';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $ticketsTable = TableRegistry::get('Tickets');
        $repliesTable = TableRegistry::get('Replies');

        if(!isset($ticketId)){
           return $this->redirect(['controller' => 'support', 'action' => 'tickets', 'prefix' => $this->backend]);
        }

        $conditions = array('Tickets.ticket_id' => $ticketId);
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Tickets.ticket_by')
                    )
                );
        $fields = array('Users.id', 'Users.username');
        $ticket = $ticketsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        $this->set('ticket', $ticket);

        $conditions = array(
                            'Replies.ticket_id' => $ticket->id,
                            'Replies.status !=' => 2
                        );
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Replies.replied_by')
                    )
                );
        $fields = array('Users.id', 'Users.username');
        $replies = $repliesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->toArray();
        $this->set('replies', $replies);

        if($this->request->is('post')){
            //echo '<pre>';
            //print_r($this->request->getData());exit;
            if(isset($this->request->getData()['btn_post_reply'])){
                $reply = $repliesTable->newEmptyEntity();
                $reply->parent_id   = $this->request->getData()['Reply']['parent_id'];
                 $reply->ticket_id  = $this->request->getData()['Reply']['ticket_id'];
                $reply->replied_by  = $this->adminUser->id;
                $reply->description = nl2br($this->request->getData()['Reply']['description']);
                $reply->status      = 1;

                if($repliesTable->save($reply)){
                    $this->Flash->success(__('Reply has been added successfully.'));
                    return $this->redirect(['controller' => 'support', 'action' => 'view_ticket', $ticket->ticket_id, 'prefix' => $this->backend]);
                }
            }
            elseif(isset($this->request->getData()['btn_edit_reply'])){
                $reply = $repliesTable->get($this->request->getData()['Reply']['id']);
                $reply->description = nl2br($this->request->getData()['Reply']['description']);
                $reply->status      = 1;

                if($repliesTable->save($reply)){
                    $this->Flash->success(__('Reply has been updated successfully.'));
                    return $this->redirect($this->backend_url.'/support/view_ticket/'.$ticket->ticket_id);
                }
            }
        }
    }

    public function updateTicketStatus($ticketId, $intStatus){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Update Ticket Status';

        $this->set('title', $title);

        if(!isset($ticketId)){
            return $this->redirect(['controller' => 'support', 'action' => 'tickets',  'prefix' => $this->backend]);
        }

        if(!isset($intStatus)){
            return $this->redirect(['controller' => 'support', 'action' => 'tickets',  'prefix' => $this->backend]);
        }
        $status = base64_decode($intStatus);

        $usersTable = TableRegistry::get('Users');
        $ticketsTable = TableRegistry::get('Tickets');
        $repliesTable = TableRegistry::get('Replies');

        $conditions = array('Tickets.ticket_id' => $ticketId);
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Tickets.ticket_by')
                    )
                );
        $fields = array('Users.id', 'Users.username');
        $ticketInfo = $ticketsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($ticketInfo)){
             return $this->redirect(['controller' => 'support', 'action' => 'tickets',  'prefix' => $this->backend]);
        }

        $ticket = $ticketsTable->get($ticketInfo->id);
        $ticket->status = $status;
        if($ticketsTable->save($ticket)){
            $this->Flash->success(__('Ticket status has been updated successfully.'));
            return $this->redirect($this->backend_url.'/support/tickets');
            return $this->redirect(['controller' => 'support', 'action' => 'tickets',  'prefix' => $this->backend]);
        }

        $this->autoRender = false;;
    }

     public function delete($ticketId, $intStatus=2){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Update Ticket Status';

        $this->set('title', $title);

        if(!isset($ticketId)){
            return $this->redirect($this->backend_url.'/support/tickets');
        }

        if(!isset($intStatus)){
            return $this->redirect($this->backend_url.'/support/tickets');
        }
        $status = $intStatus;

        $usersTable = TableRegistry::get('Users');
        $ticketsTable = TableRegistry::get('Tickets');
        $repliesTable = TableRegistry::get('Replies');

        $conditions = array('Tickets.ticket_id' => $ticketId);
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Tickets.ticket_by')
                    )
                );
        $fields = array('Users.id', 'Users.username');
        $ticketInfo = $ticketsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($ticketInfo)){
             return $this->redirect(['controller' => 'support', 'action' => 'tickets',  'prefix' => $this->backend]);
        }

        $ticket = $ticketsTable->get($ticketInfo->id);
        $ticket->status = $status;
        if($ticketsTable->save($ticket)){
            $this->Flash->success(__('Ticket status has been deleted successfully.'));
            return $this->redirect($this->backend_url.'/support/tickets');
        }

        $this->autoRender = false;;
    }

    public function deleteReply($intReplyId){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Delete Reply';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $ticketsTable = TableRegistry::get('Tickets');
        $repliesTable = TableRegistry::get('Replies');

        if(!isset($intReplyId)){
           return $this->redirect($this->backend_url.'/support/view_ticket');
        }

        $conditions = array(
                            'Replies.id' => $intReplyId
                        );
        $join = array(
                    array(
                        'table' => 'tickets',
                        'alias' => 'Tickets',
                        'type' => 'INNER',
                        'conditions' => array('Tickets.id = Replies.ticket_id')
                    )
                );
        $fields = array('Tickets.id', 'Tickets.ticket_id');
        $replyInfo = $repliesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($replyInfo)){
            return $this->redirect($this->backend_url.'/support/tickets');
        }

        $reply          = $repliesTable->get($intReplyId);
        $reply->status  = 2;
        if($repliesTable->save($reply)){
             $this->Flash->success(__('Reply has been deleted successfully.'));
             return $this->redirect($this->backend_url.'/support/view_ticket/'.$replyInfo->Tickets['ticket_id']);
        }
        $this->autoRender = false;;
    }
}
