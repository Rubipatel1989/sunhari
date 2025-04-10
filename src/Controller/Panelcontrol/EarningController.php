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

class EarningController extends AppController
{

    public function sponsorReward(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Sponsor Reward';

        $this->set('title', $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ],
            [
                "table" => "upgrades",
                "alias" => "Upgrades",
                "type" => "INNER",
                "conditions" => ["Upgrades.id = Payouts.upgraded_table_id"],
            ],
            [
                "table" => "users",
                "alias" => "FromUsers",
                "type" => "INNER",
                "conditions" => ["FromUsers.id = Upgrades.upgraded_id"],
            ]
        ];
        
        $conditions = ['Payouts.direct_amount >' => 0];
        $fields = ["Payouts.id", "Payouts.direct_amount", "Payouts.created", "Users.username", "Upgrades.package_amount", "FromUsers.username"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }

    public function aojoraReward(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Aojora Reward';

        $this->set('title', $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ],
            [
                "table" => "upgrades",
                "alias" => "Upgrades",
                "type" => "INNER",
                "conditions" => ["Upgrades.id = Payouts.upgraded_table_id"],
            ]
        ];
        
        $conditions = ['Payouts.roi >' => 0];
        $order = ['Payouts.id' => 'DESC'];
        $group = ['Payouts.upagraded_user_id'];
        $fields = ["Payouts.id", "Payouts.roi", "Payouts.package_amount", "Payouts.day_count", "Users.username", "Users.name", "Upgrades.created"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'group' => $group, 'order' => $order))
        ->select([
            'total_roi' => '(SELECT SUM(p.roi) FROM payouts p WHERE p.upagraded_user_id = Payouts.upagraded_user_id and p.roi > 0)',
            'total_roi_count' => '(SELECT COUNT(p.roi) FROM payouts p WHERE p.upagraded_user_id = Payouts.upagraded_user_id and p.roi > 0)'
        ])->toArray();

        $this->set('payouts', $payouts);
    }

    public function levelReward(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Level Reward';

        $this->set('title', $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ],
            [
                "table" => "users",
                "alias" => "FromUsers",
                "type" => "INNER",
                "conditions" => ["FromUsers.id = Payouts.level_income_by"],
            ]
        ];
        
        $conditions = ['Payouts.level_income >' => 0];
        $fields = ["Payouts.id", "Payouts.level_income", "Payouts.level_count", "Payouts.level_roi", "Payouts.day_count", "Payouts.created", "Users.username", "Users.name", "FromUsers.username"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
        ->select([
            'UpgradedDate' => '(SELECT u.created from upgrades u WHERE u.upgraded_id = Payouts.upagraded_user_id ORDER BY u.id ASC LIMIT 0, 1)'
        ])->toArray();

        $this->set('payouts', $payouts);
    }

    public function royaltyEligible(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Earning : Royalty Eligible';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        
        $conditions = ['Users.is_level_up' => 1];
        $fields = ["Users.id", "Users.username", "Users.name", "Users.level_up_date"];
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->toArray();

        $this->set('users', $users);
    }

    public function royaltyReward(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Royalty Reward';

        $this->set('title', $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ]
        ];
        
        $conditions = ['Payouts.royalty_amount >' => 0];
        $fields = ["Payouts.id", "Payouts.monthly_business", "Payouts.royalty_amount", "Payouts.created", "Users.username", "Users.name"];
        $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->toArray();

        $this->set('payouts', $payouts);
    }

    public function rankEligible(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        $title = $prefix_title.' Earning : Rank Eligible';
        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        
        $conditions = [
        'Users.is_explorer_rank = 1
        OR is_contributor_rank = 1 
        OR is_expert_contributor_rank = 1
        OR is_rising_rank = 1
        OR is_rising_star_rank = 1
        OR is_master_star_rank = 1
        OR is_mentor_rank = 1
        OR is_super_mentor_rank = 1
        OR is_master_rank = 1
        OR is_master_mentor_rank = 1'];

        $fields = [
            "Users.username",
            "Users.name",
            "Users.is_explorer_rank",
            "Users.explorer_rank_date",
            "Users.is_contributor_rank", 
            "Users.contributor_rank_date",
            "Users.is_expert_contributor_rank",
            "Users.expert_contributor_rank_date",
            "Users.is_rising_rank",
            "Users.rising_rank_date",
            "Users.is_rising_star_rank",
            "Users.rising_star_rank_date",
            "Users.is_master_star_rank",
            "Users.master_star_rank_date",
            "Users.is_mentor_rank",
            "Users.mentor_rank_date",
            "Users.is_super_mentor_rank",
            "Users.super_mentor_rank_date",
            "Users.is_master_rank",
            "Users.master_rank_date",
            "Users.is_master_mentor_rank",
            "Users.master_mentor_rank_date"
        ];
        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions))->toArray();

        $this->set('users', $users);
    }

    public function rankReward(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Rank Reward';

        $this->set('title', $title);

        $payoutsTable  = TableRegistry::get('Payouts');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Payouts.upagraded_user_id"],
            ]
        ];
        $conditions = [];
        if(isset($_GET['rank']) && $_GET['rank'] == 'explorer_rank'){
            $conditions = ['Payouts.explorer_rank_amount > 0'];
            $rankField = 'explorer_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'contributor_rank'){
            $conditions = ['Payouts.contributor_rank_amount > 0'];
            $rankField = 'contributor_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'expert_contributor'){
            $conditions = ['Payouts.expert_contributor_amount > 0'];
            $rankField = 'expert_contributor_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'rising_rank'){
            $conditions = ['Payouts.rising_rank_amount > 0'];
            $rankField = 'rising_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'rising_star_rank'){
            $conditions = ['Payouts.rising_star_rank_amount > 0'];
            $rankField = 'rising_star_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_star_rank'){
            $conditions = ['Payouts.master_star_rank_amount > 0'];
            $rankField = 'master_star_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'mentor_rank'){
            $conditions = ['Payouts.mentor_rank_amount > 0'];
            $rankField = 'mentor_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'super_mentor_rank'){
            $conditions = ['Payouts.super_mentor_rank_amount > 0'];
            $rankField = 'super_mentor_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_rank'){
            $conditions = ['Payouts.master_rank_amount > 0'];
            $rankField = 'master_rank_amount';
        } elseif(isset($_GET['rank']) && $_GET['rank'] == 'master_mentor_rank'){
            $conditions = ['Payouts.master_mentor_rank_amount > 0'];
            $rankField = 'master_mentor_rank_amount';
        }
        $payouts = [];
        if ($conditions) {
            $fields = [
                "Payouts.id",
                "Payouts.explorer_rank_amount",
                "Payouts.contributor_rank_amount",
                "Payouts.expert_contributor_amount",
                "Payouts.rising_rank_amount",
                "Payouts.rising_star_rank_amount",
                "Payouts.master_star_rank_amount",
                "Payouts.mentor_rank_amount",
                "Payouts.super_mentor_rank_amount",
                "Payouts.master_rank_amount",
                "Payouts.master_mentor_rank_amount",
                "Payouts.created",
                "Users.username",
                "Users.name"
            ];
            $payouts = $payoutsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
            ->select([
                'weeksCount' => '(SELECT COUNT(p.id) FROM payouts p WHERE p.'.$rankField.' > 0 AND p.upagraded_user_id = Payouts.upagraded_user_id)'
            ])
            ->toArray();
        }
        $this->set('payouts', $payouts);
    }

    public function totalEarning(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Total Earning';

        $this->set('title', $title);

        $upgradesTable  = TableRegistry::get('Upgrades');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Upgrades.upgraded_id"],
            ]
        ];
        
        $conditions = [];
        $fields = ["Users.username", "Users.name"];
        $group = ['Upgrades.upgraded_id'];
        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'group' => $group))
        ->select([
            'totalDirectAmount' => '(SELECT SUM(p.direct_amount) FROM payouts p WHERE p.direct_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalROI' => '(SELECT SUM(p.roi) FROM payouts p WHERE p.roi > 0 and p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalRoyaltyAmount' => '(SELECT SUM(p.royalty_amount) FROM payouts p WHERE p.royalty_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalLevelIncome' => '(SELECT SUM(p.level_income) FROM payouts p WHERE p.level_income > 0 and p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalRankIncome' => '(SELECT SUM(p.explorer_rank_amount) FROM payouts p WHERE p.explorer_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.contributor_rank_amount) FROM payouts p WHERE p.contributor_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.expert_contributor_amount) FROM payouts p WHERE p.expert_contributor_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.rising_rank_amount) FROM payouts p WHERE p.rising_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.rising_star_rank_amount) FROM payouts p WHERE p.rising_star_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.master_star_rank_amount) FROM payouts p WHERE p.master_star_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.mentor_rank_amount) FROM payouts p WHERE p.mentor_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.super_mentor_rank_amount) FROM payouts p WHERE p.super_mentor_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.master_rank_amount) FROM payouts p WHERE p.master_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)
            + (SELECT SUM(p.master_mentor_rank_amount) FROM payouts p WHERE p.master_mentor_rank_amount > 0 and p.upagraded_user_id = Upgrades.upgraded_id)',
        ])
        ->toArray();

        $this->set('upgrades', $upgrades);
    }

    public function pendingDays(){
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Earning : Pending Days';

        $this->set('title', $title);

        $upgradesTable  = TableRegistry::get('Upgrades');

        $join = [
            [
                "table" => "users",
                "alias" => "Users",
                "type" => "INNER",
                "conditions" => ["Users.id = Upgrades.upgraded_id"],
            ]
        ];
        
        $conditions = [];
        $fields = ["Users.username", "Users.name", "Users.total_self_business", "Users.total_direct_active"];
        $group = ['Upgrades.upgraded_id'];
        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'group' => $group))
        ->select([
            'totalDirectAmount' => '(SELECT SUM(p.direct_amount) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalROI' => '(SELECT SUM(p.roi) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalRoyaltyAmount' => '(SELECT SUM(p.royalty_amount) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id)',
            'totalLevelIncome' => '(SELECT SUM(p.level_income) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id)',
            'todayROI' => '(SELECT SUM(p.roi) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id and DATE(p.created) = "'.date('Y-m-d').'")',
            'todayLevelIncome' => '(SELECT SUM(p.level_income) FROM payouts p WHERE p.upagraded_user_id = Upgrades.upgraded_id and DATE(p.created) = "'.date('Y-m-d').'")'
        ])
        ->toArray();

        $this->set('upgrades', $upgrades);
    }
}
