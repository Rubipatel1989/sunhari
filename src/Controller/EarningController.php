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

class EarningController extends AppController
{
    public function incentiveIncome()
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
        $title = $prefix_title . " Earning | Incentive Income";
        $this->set("title", $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.user_id"],
            ]
        ];

        $conditions = ['Payouts.daily_incentive >' => 0, 'Payouts.user_id' => $this->user->id];
        $fields = ["Payouts.id", "Payouts.daily_incentive", "Payouts.created", "Users.username"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }

    public function repurchaseIncome()
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
        $title = $prefix_title . " Earning | Repurchase Income";
        $this->set("title", $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.user_id"],
            ],
            [
                "table" => "users",
                "alias" => "PaymentByUsers",
                "type" => "LEFT",
                "conditions" => ["PaymentByUsers.id = Payouts.payment_by_id"],
            ]
        ];

        

        $conditions = ['Payouts.repurchase_ab_income >' => 0, 'Payouts.user_id' => $this->user->id];
        $fields = ["Payouts.id", "Payouts.repurchase_ab_income", "Payouts.created", "Users.username", "PaymentByUsers.username", "PaymentByUsers.name"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }

    public function repurchaseMbIncome()
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
        $title = $prefix_title . " Earning | Repurchase MB Income";
        $this->set("title", $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.user_id"],
            ],
            [
                "table" => "users",
                "alias" => "PaymentByUsers",
                "type" => "LEFT",
                "conditions" => ["PaymentByUsers.id = Payouts.payment_by_id"],
            ]
        ];

        

        $conditions = ['Payouts.repurchase_mb_income >' => 0, 'Payouts.user_id' => $this->user->id];
        $fields = ["Payouts.id", "Payouts.repurchase_mb_income", "Payouts.created", "Users.username", "PaymentByUsers.username", "PaymentByUsers.name"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }

    public function royaltyIncome()
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
        $title = $prefix_title . " Earning | Royalty Income";
        $this->set("title", $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.user_id"],
            ],
            [
                "table" => "users",
                "alias" => "PaymentByUsers",
                "type" => "LEFT",
                "conditions" => ["PaymentByUsers.id = Payouts.payment_by_id"],
            ]
        ];

        

        $conditions = ['Payouts.royalty_income >' => 0, 'Payouts.user_id' => $this->user->id];
        $fields = ["Payouts.id", "Payouts.royalty_income", "Payouts.created", "Users.username", "PaymentByUsers.username", "PaymentByUsers.name"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }
}
