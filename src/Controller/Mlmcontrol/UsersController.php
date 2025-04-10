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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{

    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/dashboard');
        }
        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Users';

        $this->set('title', $title);

        $usersTable  = TableRegistry::get('Users');
        $upgradesTable  = TableRegistry::get('Upgrades');

        $join = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        ),
                        array(
                            'table' => 'states',
                            'alias' => 'States',
                            'type' => 'LEFT',
                            'conditions' => array('States.id = Details.state_id')
                        ),
                        array(
                            'table' => 'countries',
                            'alias' => 'Countries',
                            'type' => 'LEFT',
                            'conditions' => array('Countries.id = Details.country_id')
                        ),
                        array(
                            'table' => 'epins',
                            'alias' => 'Epins',
                            'type' => 'LEFT',
                            'conditions' => array('Epins.id = Users.epin_id')
                        ),
                        array(
                            'table' => 'plot_payments',
                            'alias' => 'PlotPayments',
                            'type' => 'LEFT',
                            'conditions' => array('PlotPayments.user_id = Users.id AND PlotPayments.number_of_unit > 0')
                        )
                    );

        $conditions = array('Users.role_id' => 2); 

        $fields = array(
                        'Details.id', 
                        'Details.first_name', 
                        'Details.middle_name', 
                        'Details.last_name', 
                        'Details.father_name', 
                        'Details.dob', 
                        'Details.gender', 
                        'Details.contact_no', 
                        'Details.country_id', 
                        'Details.state_id', 
                        'Details.city_id',
                        'Details.city_name',
                        'Details.address',
                        'Details.pin_code',
                        'Details.occupation',
                        'Details.pan_number',
                        'Details.account_number',
                        'Details.branch_name',
                        'Details.type_of_account',
                        'Details.bank_name',
                        'Details.ifsc_code',
                        'Details.nominee_name',
                        'Details.relationship',
                        'States.id',
                        'States.name',
                        'Countries.id',
                        'Countries.name',
                        'Epins.id',
                        'Epins.epin',
                        'PlotPayments.id',
                        'PlotPayments.user_id',
                        'PlotPayments.number_of_unit',
                    );

        $limit = 100;

        $users = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->toArray();
        /*echo '<pre>';
        print_r($users);exit;*/
        $this->set('users', $users);

    }

    public function upgradeHistory(){

        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');
        $upgradesTable = TableRegistry::get('Upgrades');

        $conditions = array();
        $join = array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = Upgrades.upgraded_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'UserDetails',
                        'type' => 'INNER',
                        'conditions' => array('UserDetails.user_id = Upgrades.upgraded_id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Upgrader',
                        'type' => 'INNER',
                        'conditions' => array('Upgrader.id = Upgrades.upgraded_by')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'UpgraderDetails',
                        'type' => 'INNER',
                        'conditions' => array('UpgraderDetails.user_id = Upgrades.upgraded_by')
                    ),
                    array(
                        'table' => 'packages',
                        'alias' => 'Packages',
                        'type' => 'INNER',
                        'conditions' => array('Packages.id = Upgrades.package_id')
                    )
                );
        $order = array(
                        'Upgrades.id' => 'DESC'
                    );
        $fields = array('Users.id', 'Users.username', 'Upgrader.username', 'Upgrader.username', 'Packages.name', 'Packages.package_amount', 'UserDetails.id', 'UserDetails.first_name', 'UserDetails.middle_name', 'UserDetails.last_name', 'UpgraderDetails.first_name', 'UpgraderDetails.middle_name', 'UpgraderDetails.last_name');

        $upgrades = $upgradesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('upgrades', $upgrades);
    
    }

    public function block($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = 1;
        $usersTable->save($userData);

        $this->Flash->success(__('User has been blocked successfully.'));

        return $this->redirect($this->backend_url.'/users/index');
    }

    public function unblock($intUserId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Upgrade History';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $this->autoRender = false;

        $usersTable = TableRegistry::get('Users');

        $userData = $usersTable->get($intUserId);
        $userData->is_blocked = NULL;
        $usersTable->save($userData);

        $this->Flash->success(__('User has been blocked successfully.'));

        return $this->redirect($this->backend_url.'/users/index');
    }

    public function achievedRewards(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Achieved Rewards';

        $this->set('title', $title);

        $achievedRewardsTable = TableRegistry::get('AchievedRewards');

        $join = array(
                    array(
                        'table' => 'rewards',
                        'alias' => 'Rewards',
                        'type' => 'INNER',
                        'conditions' => array('Rewards.id = AchievedRewards.reward_id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'INNER',
                        'conditions' => array('Users.id = AchievedRewards.user_id')
                    ),
                    array(
                        'table' => 'details',
                        'alias' => 'Details',
                        'type' => 'INNER',
                        'conditions' => array('Details.user_id = Users.id')
                    )
                );
        $conditions = array();
        $order = array(
                        'AchievedRewards.id' => 'DESC'
                    );
        $fields = array('Rewards.id', 'Rewards.title', 'Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name');

        $achievedRewards = $achievedRewardsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join, 'order' => $order))->enableAutoFields(true)->toArray();

        $this->set('achievedRewards', $achievedRewards);

    }

    public function achievedRewardStatus($encId, $encStatus){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' User : Achieved Rewards';

        $this->set('title', $title);

        $achievedRewardsTable = TableRegistry::get('AchievedRewards');

        $intId = base64_decode($encId);
        $intStatus = base64_decode($encStatus);

        $achievedReward = $achievedRewardsTable->get($intId);
        $achievedReward->status = $intStatus;
        if($achievedRewardsTable->save($achievedReward)){
            $this->Flash->success(__('Reward status has been changed successfully.'));

            return $this->redirect($this->backend_url.'/users/achieved-rewards');
        }
    }
}
