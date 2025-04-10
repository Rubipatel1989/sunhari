<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;


class CronController extends AppController
{
    public function index(){
        $this->viewBuilder()->setLayout('blank');
        $this->autoRender = false;
        $this->dailyIncentive();
    }

    public function dailyIncentive() {
        $this->viewBuilder()->setLayout('blank');
        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');
        $payoutsTable = TableRegistry::get('Payouts');

        $conditions = ['Users.role_id' => 2];
        $users = $usersTable->find('all', ['conditions' => $conditions])->toArray();
        foreach($users as $user) {
            $agents = $usersTable->getDownlineIncentiveEligibleAgents($user->id, true);
            $customers = $usersTable->getDownlineIncentiveEligibleCustomers($user->id, true, 1);
            $totalIncentiveCount = $agents + $customers;
            if ($totalIncentiveCount > 1){
                $conditions = ['Payouts.user_id' => $user->id, 'DATE(Payouts.created)' => date('Y-m-d')];
                $isTodayIncentivePayout = $payoutsTable->find('all', ['conditions' => $conditions])->count();
                if (!$isTodayIncentivePayout) {
                    $dailyIncentive = ($totalIncentiveCount - 1)*1000;
                    $objPayout = $payoutsTable->newEmptyEntity();
                    $objPayout->user_id = $user->id;
                    $objPayout->daily_incentive = $dailyIncentive;
                    $objPayout->remark = 'Daily Incentive Income';
                    $objPayout->status = 0;
                    if ($payoutsTable->save($objPayout)){
                        $usersTable->updateAll(["total_today_business" => 0], ["total_today_business >" => 0]);
                    }
                }
            }
        }
    }
}

