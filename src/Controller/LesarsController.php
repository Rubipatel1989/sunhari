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

class LesarsController extends AppController
{
    public function lesarList()
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
        $title = $prefix_title . " Manage Lesar | Lesar List";
        $this->set("title", $title);

        $lesarsTable = TableRegistry::get("Lesars");
        $conditions = ['Lesars.user_id' => $this->user->id];
        $order = ['Lesars.id' => 'DESC'];
        $lesars = $lesarsTable->find('all', ['conditions' => $conditions, 'order' => $order])->enableAutoFields(true)->toArray();
        $this->set('lesars', $lesars);
    }
}
