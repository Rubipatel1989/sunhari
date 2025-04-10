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

class StaffsController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
             return $this->redirect(['controller' => 'user', 'action' => 'dashboard', 'prefix' => $this->backend]);
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Staffs';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'LEFT',
                            'conditions' => array('Details.user_id = Users.id')
                        ),
                        array(
                            'table' => 'roles',
                            'alias' => 'Roles',
                            'type' => 'LEFT',
                            'conditions' => array('Roles.id = Users.role_id')
                        ),
                    );

        $conditions = array('Users.role_id !=' => 2); 

        $fields = array(
                        'Details.id', 
                        'Details.first_name', 
                        'Details.middle_name', 
                        'Details.last_name', 
                        'Details.father_name', 
                        'Details.dob', 
                        'Details.gender', 
                        'Details.contact_no', 
                        'Roles.id',
                        'Roles.title',
                    );
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->toArray();

        $this->set('users', $users);
    }

    public function add()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Staffs : Add";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $detailsTable = TableRegistry::get("Details");
        $rolesTable = TableRegistry::get("Roles");

        $conditions = [
            "Roles.id !=" => 2
        ];

        $order = [
            "Roles.id" => "ASC",
        ];

        $fields = ["Roles.id", "Roles.title"];

        $roles = $rolesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("roles", $roles);

        if ($this->request->is("post")) {
                /*echo '<pre>';
                print_r($this->request->getData());
                exit;*/
            $first_name = isset($this->request->getData()["Detail"]["first_name"]) ? trim($this->request->getData()["Detail"]["first_name"]) : null;
            $role_id = isset($this->request->getData()["User"]["role_id"]) ? trim($this->request->getData()["User"]["role_id"]) : null;
            $username = isset($this->request->getData()["User"]["username"]) ? trim($this->request->getData()["User"]["username"]) : null;
            $password = isset($this->request->getData()["User"]["password"]) ? trim($this->request->getData()["User"]["password"]) : null;
            $status = isset($this->request->getData()["User"]["status"]) ? trim($this->request->getData()["User"]["status"]) : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($role_id) &&
                !empty($first_name) 
            ) {
                

                $checkUsername = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.username" => $username],
                    ])
                    ->count();


                if ($checkUsername > 0) {
                    $this->Flash->error(
                        __(
                            "Entered username already used by our registered user. Please register with different username"
                        )
                    );
                } else {

                    $user = $usersTable->newEmptyEntity();
                    $user->role_id = $role_id;
                    $user->username = $username;
                    $user->password = md5($password);
                    $user->status = $status;
                    if ($usersTable->save($user)) {
                        $user_id = $user->id;

                        $detail = $detailsTable->newEmptyEntity();
                        $detail->user_id = $user_id;
                        $detail->first_name = $first_name;
                        $detailsTable->save($detail);


                        $this->Flash->success(
                            __(
                                "Congratulations! Staff has been added."
                            )
                        );

                        return $this->redirect($this->backend_url.'/staffs/index');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function edit($intUserId)
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Staffs : Edit";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $detailsTable = TableRegistry::get("Details");
        $rolesTable = TableRegistry::get("Roles");

        $conditions = [
            "Roles.id !=" => 2
        ];

        $order = [
            "Roles.id" => "ASC",
        ];

        $fields = ["Roles.id", "Roles.title"];

        $roles = $rolesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("roles", $roles);

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'LEFT',
                            'conditions' => array('Details.user_id = Users.id')
                        ),
                        array(
                            'table' => 'roles',
                            'alias' => 'Roles',
                            'type' => 'LEFT',
                            'conditions' => array('Roles.id = Users.role_id')
                        ),
                    );

        $conditions = array('Users.id' => $intUserId); 

        $fields = array(
                        'Details.id', 
                        'Details.first_name', 
                        'Details.middle_name', 
                        'Details.last_name', 
                        'Details.father_name', 
                        'Details.dob', 
                        'Details.gender', 
                        'Details.contact_no', 
                        'Roles.id',
                        'Roles.title',
                    );
        $userDetails = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();
        if(!$userDetails) {
            return $this->redirect($this->backend_url.'/user/login');
        }
        $this->set('userDetails', $userDetails);

        if ($this->request->is("post")) {
            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/
            $first_name = isset($this->request->getData()["Detail"]["first_name"]) ? trim($this->request->getData()["Detail"]["first_name"]) : null;
            $role_id = isset($this->request->getData()["User"]["role_id"]) ? trim($this->request->getData()["User"]["role_id"]) : null;
            $username = isset($this->request->getData()["User"]["username"]) ? trim($this->request->getData()["User"]["username"]) : null;
            $password = isset($this->request->getData()["User"]["password"]) ? trim($this->request->getData()["User"]["password"]) : null;
            $status = isset($this->request->getData()["User"]["status"]) ? trim($this->request->getData()["User"]["status"]) : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($role_id) &&
                !empty($first_name) 
            ) {
                

                $checkUsername = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.id !=" => $userDetails->id, "Users.username" => $username],
                    ])
                    ->count();


                if ($checkUsername > 0) {
                    $this->Flash->error(
                        __(
                            "Entered username already used by our registered user. Please register with different username"
                        )
                    );
                } else {

                    $user = $usersTable->get($intUserId);
                    $user->role_id = $role_id;
                    $user->username = $username;
                    $user->password = md5($password);
                    $user->status = $status;
                    if ($usersTable->save($user)) {
                        $user_id = $intUserId;
                        $detail = $detailsTable->get($userDetails->Details['id']);
                        $detail->first_name = $first_name;
                        $detailsTable->save($detail);


                        $this->Flash->success(
                            __(
                                "Congratulations! Staff has been updated."
                            )
                        );

                        return $this->redirect($this->backend_url.'/staffs/index');
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function block($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = 1;
        $usersTable->save($userData);

        $this->Flash->success(__('Staff has been blocked successfully.'));
        return $this->redirect(['controller' => 'staffs', 'action' => 'index', 'prefix' => $this->backend]);
    }

    public function unblock($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->render(false);

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = NULL;
        $usersTable->save($userData);

        $this->Flash->success(__('Staff has been blocked successfully.'));
        return $this->redirect(['controller' => 'staffs', 'action' => 'index', 'prefix' => $this->backend]);
    }
}
