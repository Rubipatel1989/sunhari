<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Network\Session\DatabaseSession;
use Cake\Controller\Component\FlashComponent;
use Cake\Mailer\Mailer;

class TeamController extends AppController
{
    public function customers()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }
        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error( __("Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."));
            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_black");
        $prefix_title = $this->siteTitle;
        $title = $prefix_title . " Team : Customers";
        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $username = $_GET["username"] ?? $this->user->username;

        $users = [];
        if ($username) {
            $conditions = [
                "Users.username" => $username
            ];
            $fields = ['Users.id'];
            $userInfo =  $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();

            if ($userInfo) {
                $conditions = [
                    "Users.role_id" => 3,
                    "Users.sponsor_id" => $userInfo->id
                ];
                $users = $usersTable->find('all', ['conditions' => $conditions])->toArray();
            }
        }
        $this->set("users", $users);
    }
}
