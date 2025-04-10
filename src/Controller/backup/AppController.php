<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $backend_name = 'mlmcontrol';
        $baseUrl = 'http://localhost/fashioholic';
        $backendUrl = 'http://localhost/fashioholic/mlmcontrol';
        $this->backend = $backend_name;
        $this->set('home_url', $baseUrl);
        $this->set('BACKEND_NAME', $backend_name);
        $this->set('backend_url', $backendUrl);
        $this->set('backend', $backend_name);

        $this->home_url =  $baseUrl;
        $this->backend_url =  $backendUrl;
        $this->siteTitle = 'Fashioholic | ';
        $this->backendTitle = 'Fashioholic Administrator | ';

        $settingsTable = TableRegistry::get('Settings');

        $settings = $settingsTable->find('all', array('conditions' => array('Settings.id' => 1)))->first();
        $this->setting = $settings;
        $this->set('setting', $this->setting);
        //$this->request->getSession()->check('AdminUser')
        //print_r($this->request->params);

        $this->user = '';
        $this->adminUser = '';
        if($this->request->getSession()->check('userId')){
            $userId = $this->request->getSession()->read('userId');
            $usersTable = TableRegistry::get('Users');
            $conditions =  array('Users.id' => $userId);
            $joins = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                    );
            $this->user = $usersTable->find('all', array('fields' => array('Details.id', 'Details.first_name', 'Details.middle_name', 'Details.last_name', 'Details.contact_no', 'Details.pan_number'), 'conditions' => $conditions, 'join' => $joins))->enableAutoFields(true)->first();
        }
        if($this->request->getSession()->check('adminUserId')){
            $userId = $this->request->getSession()->read('adminUserId');
            $usersTable = TableRegistry::get('Users');
            $conditions =  array('Users.id' => $userId);
            $joins = array(
                        array(
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'LEFT',
                            'conditions' => array('Details.user_id = Users.id')
                        ),
                        array(
                            'table' => 'permissions',
                            'alias' => 'Permissions',
                            'type' => 'LEFT',
                            'conditions' => array('Permissions.id = Users.role_id')
                        )
                    );
            $fields = [
                'Details.id',
                'Details.first_name',
                'Details.middle_name',
                'Details.last_name',
                'Details.contact_no',
                'Details.pan_number',
                'Permissions.is_permission',
                'Permissions.is_staff',
                'Permissions.is_package',
                'Permissions.is_properties',
                'Permissions.is_sites',
                'Permissions.is_blocks',
                'Permissions.is_plots',
                'Permissions.is_current_rate',
                'Permissions.is_assign_plot',
                'Permissions.is_assigned_plots',
                'Permissions.is_plot_payment',
                'Permissions.is_plot_payment_list',
                'Permissions.is_assigned_unit_list',
                'Permissions.is_generate_pins',
                'Permissions.is_epin_list',
                'Permissions.is_unused_epins',
                'Permissions.is_used_pins',
                'Permissions.is_transferred_pins',
                'Permissions.is_new_registration',
                'Permissions.is_upgrade_user',
                'Permissions.is_upgrade_history',
                'Permissions.is_degrade_user',
                'Permissions.is_user_emi',
                'Permissions.is_user_list',
                'Permissions.is_direct_reward',
                'Permissions.is_pair_reward',
                'Permissions.is_direct_network',
                'Permissions.is_network',
                'Permissions.is_direct_referral',
                'Permissions.is_downline_report',
                'Permissions.is_post_report',
                'Permissions.is_current_business',
                'Permissions.is_run_cron',
                'Permissions.is_post_incomes',
                'Permissions.is_saved_post_incomes',
                'Permissions.is_payment_closing',
                'Permissions.is_id_wise_closing',
                'Permissions.is_closing_details',
                'Permissions.is_pending_plot_payment',
                'Permissions.is_incoming_income',
                'Permissions.is_outgoing_income',
                'Permissions.is_total_payout_report',
                'Permissions.is_tickets',
                'Permissions.is_tax_and_comission',
                'Permissions.is_account_password'
            ];
            $this->adminUser = $usersTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $joins))->enableAutoFields(true)->first();
        }

        $this->set('user', $this->user);
        $this->set('adminUser', $this->adminUser);
        $parms = $this->request->getAttribute('params');
        if(empty($parms['pass'][0]) && $parms['_matchedRoute'] == '/*'){
           // $this->viewBuilder()->setLayout('ineer-layout');
        }
        elseif(isset($parms['prefix']) && strtolower($parms['prefix']) == $backend_name && !$this->request->getSession()->check('adminUserId')){
            $this->viewBuilder()->setLayout('admin-login');
        }
        elseif(isset($parms['prefix']) && strtolower($parms['prefix']) == $backend_name && $this->request->getSession()->check('adminUserId')){
            $this->viewBuilder()->setLayout('admin');
        }
        else{
            $this->viewBuilder()->setLayout('ineer-layout');
        }
    }
}
