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

class PaymentController extends AppController
{
    public function closingList()
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
        $title = $prefix_title . " Payment Closing | Closing List";
        $this->set("title", $title);

        $closingsTable = TableRegistry::get('Closings');

        $conditions = [];
        $order = ['Closings.id' => 'DESC'];
        $fields = ['Closings.closing_count'];
        $lastClosingInfo = $closingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = Closings.user_id"],

                ]
            ];
            $conditions = ['Closings.user_id' => $this->user->id, 'Closings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $closingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }

    public function directClosingList()
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
        $title = $prefix_title . " Coupon Closing | Direct Closing List";
        $this->set("title", $title);

        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conditions = ['PromotionClosings.closing_type' => 1];
        $order = ['PromotionClosings.id' => 'DESC'];
        $fields = ['PromotionClosings.closing_count'];
        $lastClosingInfo = $promotionClosingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = PromotionClosings.user_id"],

                ]
            ];
            $conditions = ['PromotionClosings.user_id' => $this->user->id, 'PromotionClosings.closing_type' => 1, 'PromotionClosings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $promotionClosingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }

    public function levelClosingList()
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
        $title = $prefix_title . " Coupon Closing | Level Closing List";
        $this->set("title", $title);

        $promotionClosingsTable = TableRegistry::get('PromotionClosings');

        $conditions = ['PromotionClosings.closing_type' => 2];
        $order = ['PromotionClosings.id' => 'DESC'];
        $fields = ['PromotionClosings.closing_count'];
        $lastClosingInfo = $promotionClosingsTable->find('all', ['fields' => $fields, 'conditions' => $conditions, 'order' => $order])->first();
        $this->set('lastClosingInfo', $lastClosingInfo);

        $closingCount = $_GET['closing_count'] ?? '';
        $closings = [];
        if ($closingCount) {
            $join = [
                [

                    "table" => "users",
                    "alias" => "Users",
                    "type" => "INNER",
                    "conditions" => ["Users.id = PromotionClosings.user_id"],

                ]
            ];
            $conditions = ['PromotionClosings.user_id' => $this->user->id, 'PromotionClosings.closing_type' => 2, 'PromotionClosings.closing_count' => $closingCount];
            $fields = ['Users.username', 'Users.name'];
            $closings = $promotionClosingsTable->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions])->enableAutoFields(true)->toArray();
        }

        $this->set('closings', $closings);
    }
}
