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
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;


class RolesController extends AppController

{
    public function index(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roles ';

        $this->set('title', $title);

        $rolesTable = TableRegistry::get('Roles');
        $join = array(
                        array(
                            'table' => 'permissions',
                            'alias' => 'Permissions',
                            'type' => 'INNER',
                            'conditions' => array('Permissions.role_id = Roles.id')
                        )
                    );
        $conditions = array('Roles.id !=' => 2);
        $fields = [
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
        $roles = $rolesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->toArray();
        $this->set('roles', $roles);

    }


    public function add(){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roles : Add';

        $this->set('title', $title);

        $rolesTable = TableRegistry::get('Roles');
        $permissionsTable = TableRegistry::get('Permissions');

        if($this->request->is('post')){

            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $title = isset($this->request->getData()['Role']['title']) ? trim($this->request->getData()['Role']['title']) : NULL;
            $is_permission = isset($this->request->getData()['Permission']['is_permission']) ? trim($this->request->getData()['Permission']['is_permission']) : NULL;
            $is_staff = isset($this->request->getData()['Permission']['is_staff']) ? trim($this->request->getData()['Permission']['is_staff']) : NULL;
            $is_package = isset($this->request->getData()['Permission']['is_package']) ? trim($this->request->getData()['Permission']['is_package']) : NULL;
            $is_properties = isset($this->request->getData()['Permission']['is_properties']) ? trim($this->request->getData()['Permission']['is_properties']) : NULL;
            $is_sites = isset($this->request->getData()['Permission']['is_sites']) ? trim($this->request->getData()['Permission']['is_sites']) : NULL;
            $is_blocks = isset($this->request->getData()['Permission']['is_blocks']) ? trim($this->request->getData()['Permission']['is_blocks']) : NULL;
            $is_current_rate = isset($this->request->getData()['Permission']['is_current_rate']) ? trim($this->request->getData()['Permission']['is_current_rate']) : NULL;
            $is_assign_plot = isset($this->request->getData()['Permission']['is_assign_plot']) ? trim($this->request->getData()['Permission']['is_assign_plot']) : NULL;
            $is_assigned_plots = isset($this->request->getData()['Permission']['is_assigned_plots']) ? trim($this->request->getData()['Permission']['is_assigned_plots']) : NULL;
            $is_plot_payment = isset($this->request->getData()['Permission']['is_plot_payment']) ? trim($this->request->getData()['Permission']['is_plot_payment']) : NULL;
            $is_plot_payment_list = isset($this->request->getData()['Permission']['is_plot_payment_list']) ? trim($this->request->getData()['Permission']['is_plot_payment_list']) : NULL;
            $is_assigned_unit_list = isset($this->request->getData()['Permission']['is_assigned_unit_list']) ? trim($this->request->getData()['Permission']['is_assigned_unit_list']) : NULL;
            $is_generate_pins = isset($this->request->getData()['Permission']['is_generate_pins']) ? trim($this->request->getData()['Permission']['is_generate_pins']) : NULL;
            $is_epin_list = isset($this->request->getData()['Permission']['is_epin_list']) ? trim($this->request->getData()['Permission']['is_epin_list']) : NULL;
            $is_unused_epins = isset($this->request->getData()['Permission']['is_unused_epins']) ? trim($this->request->getData()['Permission']['is_unused_epins']) : NULL;
            $is_used_pins = isset($this->request->getData()['Permission']['is_used_pins']) ? trim($this->request->getData()['Permission']['is_used_pins']) : NULL;
            $is_transferred_pins = isset($this->request->getData()['Permission']['is_transferred_pins']) ? trim($this->request->getData()['Permission']['is_transferred_pins']) : NULL;
            $is_new_registration = isset($this->request->getData()['Permission']['is_new_registration']) ? trim($this->request->getData()['Permission']['is_new_registration']) : NULL;
            $is_upgrade_user = isset($this->request->getData()['Permission']['is_upgrade_user']) ? trim($this->request->getData()['Permission']['is_upgrade_user']) : NULL;
            $is_upgrade_history = isset($this->request->getData()['Permission']['is_upgrade_history']) ? trim($this->request->getData()['Permission']['is_upgrade_history']) : NULL;
            $is_degrade_user = isset($this->request->getData()['Permission']['is_degrade_user']) ? trim($this->request->getData()['Permission']['is_degrade_user']) : NULL;
            $is_user_emi = isset($this->request->getData()['Permission']['is_user_emi']) ? trim($this->request->getData()['Permission']['is_user_emi']) : NULL;
            $is_user_list = isset($this->request->getData()['Permission']['is_user_list']) ? trim($this->request->getData()['Permission']['is_user_list']) : NULL;
            $is_direct_reward = isset($this->request->getData()['Permission']['is_direct_reward']) ? trim($this->request->getData()['Permission']['is_direct_reward']) : NULL;
            $is_pair_reward = isset($this->request->getData()['Permission']['is_pair_reward']) ? trim($this->request->getData()['Permission']['is_pair_reward']) : NULL;
            $is_direct_network = isset($this->request->getData()['Permission']['is_direct_network']) ? trim($this->request->getData()['Permission']['is_direct_network']) : NULL;
            $is_network = isset($this->request->getData()['Permission']['is_network']) ? trim($this->request->getData()['Permission']['is_network']) : NULL;
            $is_direct_referral = isset($this->request->getData()['Permission']['is_direct_referral']) ? trim($this->request->getData()['Permission']['is_direct_referral']) : NULL;
            $is_downline_report = isset($this->request->getData()['Permission']['is_downline_report']) ? trim($this->request->getData()['Permission']['is_downline_report']) : NULL;
            $is_post_report = isset($this->request->getData()['Permission']['is_post_report']) ? trim($this->request->getData()['Permission']['is_post_report']) : NULL;
            $is_current_business = isset($this->request->getData()['Permission']['is_current_business']) ? trim($this->request->getData()['Permission']['is_current_business']) : NULL;
            $is_run_cron = isset($this->request->getData()['Permission']['is_run_cron']) ? trim($this->request->getData()['Permission']['is_run_cron']) : NULL;
            $is_post_incomes = isset($this->request->getData()['Permission']['is_post_incomes']) ? trim($this->request->getData()['Permission']['is_post_incomes']) : NULL;
            $is_saved_post_incomes = isset($this->request->getData()['Permission']['is_saved_post_incomes']) ? trim($this->request->getData()['Permission']['is_saved_post_incomes']) : NULL;
            $is_payment_closing = isset($this->request->getData()['Permission']['is_payment_closing']) ? trim($this->request->getData()['Permission']['is_payment_closing']) : NULL;
            $is_id_wise_closing = isset($this->request->getData()['Permission']['is_id_wise_closing']) ? trim($this->request->getData()['Permission']['is_id_wise_closing']) : NULL;
            $is_closing_details = isset($this->request->getData()['Permission']['is_closing_details']) ? trim($this->request->getData()['Permission']['is_closing_details']) : NULL;
            $is_pending_plot_payment = isset($this->request->getData()['Permission']['is_pending_plot_payment']) ? trim($this->request->getData()['Permission']['is_pending_plot_payment']) : NULL;
            $is_incoming_income = isset($this->request->getData()['Permission']['is_incoming_income']) ? trim($this->request->getData()['Permission']['is_incoming_income']) : NULL;
            $is_outgoing_income = isset($this->request->getData()['Permission']['is_outgoing_income']) ? trim($this->request->getData()['Permission']['is_outgoing_income']) : NULL;
            $is_total_payout_report = isset($this->request->getData()['Permission']['is_total_payout_report']) ? trim($this->request->getData()['Permission']['is_total_payout_report']) : NULL;
            $is_tickets = isset($this->request->getData()['Permission']['is_tickets']) ? trim($this->request->getData()['Permission']['is_tickets']) : NULL;
            $is_tax_and_comission = isset($this->request->getData()['Permission']['is_tax_and_comission']) ? trim($this->request->getData()['Permission']['is_tax_and_comission']) : NULL;
            $is_account_password = isset($this->request->getData()['Permission']['is_account_password']) ? trim($this->request->getData()['Permission']['is_account_password']) : NULL;


            if( 
                !empty($title) 
            ){

                $roleData = $rolesTable->newEmptyEntity();
                $roleData->title = $title;
                if($rolesTable->save($roleData)){
                    $role_id = $roleData->id;
                    $permissionData = $permissionsTable->newEmptyEntity();
                    $permissionData->role_id = $role_id;
                    $permissionData->is_permission = $is_permission;
                    $permissionData->is_staff = $is_staff;
                    $permissionData->is_package = $is_package;
                    $permissionData->is_properties = $is_properties;
                    $permissionData->is_sites = $is_sites;
                    $permissionData->is_blocks = $is_blocks;
                    $permissionData->is_current_rate = $is_current_rate;
                    $permissionData->is_assign_plot = $is_assign_plot;
                    $permissionData->is_assigned_plots = $is_assigned_plots;
                    $permissionData->is_plot_payment = $is_plot_payment;
                    $permissionData->is_plot_payment_list = $is_plot_payment_list;
                    $permissionData->is_assigned_unit_list = $is_assigned_unit_list;
                    $permissionData->is_generate_pins = $is_generate_pins;
                    $permissionData->is_epin_list = $is_epin_list;
                    $permissionData->is_unused_epins = $is_unused_epins;
                    $permissionData->is_used_pins = $is_used_pins;
                    $permissionData->is_transferred_pins = $is_transferred_pins;
                    $permissionData->is_new_registration = $is_new_registration;
                    $permissionData->is_upgrade_user = $is_upgrade_user;
                    $permissionData->is_upgrade_history = $is_upgrade_history;
                    $permissionData->is_degrade_user = $is_degrade_user;
                    $permissionData->is_user_emi = $is_user_emi;
                    $permissionData->is_user_list = $is_user_list;
                    $permissionData->is_direct_reward = $is_direct_reward;
                    $permissionData->is_pair_reward = $is_pair_reward;
                    $permissionData->is_direct_network = $is_direct_network;
                    $permissionData->is_network = $is_network;
                    $permissionData->is_direct_referral = $is_direct_referral;
                    $permissionData->is_downline_report = $is_downline_report;
                    $permissionData->is_post_report = $is_post_report;
                    $permissionData->is_current_business = $is_current_business;
                    $permissionData->is_run_cron = $is_run_cron;
                    $permissionData->is_post_incomes = $is_post_incomes;
                    $permissionData->is_saved_post_incomes = $is_saved_post_incomes;
                    $permissionData->is_payment_closing = $is_payment_closing;
                    $permissionData->is_id_wise_closing = $is_id_wise_closing;
                    $permissionData->is_closing_details = $is_closing_details;
                    $permissionData->is_pending_plot_payment = $is_pending_plot_payment;
                    $permissionData->is_incoming_income = $is_incoming_income;
                    $permissionData->is_outgoing_income = $is_outgoing_income;
                    $permissionData->is_total_payout_report = $is_total_payout_report;
                    $permissionData->is_tickets = $is_tickets;
                    $permissionData->is_tax_and_comission = $is_tax_and_comission;
                    $permissionData->is_account_password = $is_account_password;

                    $permissionsTable->save($permissionData);

                    $this->Flash->success(__('Congratulations! Role has been added successfully.'));
                    return $this->redirect($this->backend_url.'/roles');
                }
            }


        }
    }

    public function edit($encRoleId){

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Roles : Edit';

        $this->set('title', $title);

        $rolesTable = TableRegistry::get('Roles');
        $permissionsTable = TableRegistry::get('Permissions');

        $roleId = base64_decode($encRoleId);

        $join = array(
                        array(
                            'table' => 'permissions',
                            'alias' => 'Permissions',
                            'type' => 'INNER',
                            'conditions' => array('Permissions.role_id = Roles.id')
                        )
                    );
        $conditions = array(
                            'Roles.id' => $roleId
                        );
        $fields = [
                'Permissions.id',
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

        $role = $rolesTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'join' => $join))->enableAutoFields(true)->first();

        if(empty($role)){
            return $this->redirect($this->backend_url.'/roles');
        }

        $this->set('role', $role);

        if($this->request->is('post')){

            /*echo '<pre>';
            print_r($this->request->getData());
            exit;*/

            $title = isset($this->request->getData()['Role']['title']) ? trim($this->request->getData()['Role']['title']) : NULL;
            $is_permission = isset($this->request->getData()['Permission']['is_permission']) ? trim($this->request->getData()['Permission']['is_permission']) : NULL;
            $is_staff = isset($this->request->getData()['Permission']['is_staff']) ? trim($this->request->getData()['Permission']['is_staff']) : NULL;
            $is_package = isset($this->request->getData()['Permission']['is_package']) ? trim($this->request->getData()['Permission']['is_package']) : NULL;
            $is_properties = isset($this->request->getData()['Permission']['is_properties']) ? trim($this->request->getData()['Permission']['is_properties']) : NULL;
            $is_sites = isset($this->request->getData()['Permission']['is_sites']) ? trim($this->request->getData()['Permission']['is_sites']) : NULL;
            $is_blocks = isset($this->request->getData()['Permission']['is_blocks']) ? trim($this->request->getData()['Permission']['is_blocks']) : NULL;
            $is_current_rate = isset($this->request->getData()['Permission']['is_current_rate']) ? trim($this->request->getData()['Permission']['is_current_rate']) : NULL;
            $is_assign_plot = isset($this->request->getData()['Permission']['is_assign_plot']) ? trim($this->request->getData()['Permission']['is_assign_plot']) : NULL;
            $is_assigned_plots = isset($this->request->getData()['Permission']['is_assigned_plots']) ? trim($this->request->getData()['Permission']['is_assigned_plots']) : NULL;
            $is_plot_payment = isset($this->request->getData()['Permission']['is_plot_payment']) ? trim($this->request->getData()['Permission']['is_plot_payment']) : NULL;
            $is_plot_payment_list = isset($this->request->getData()['Permission']['is_plot_payment_list']) ? trim($this->request->getData()['Permission']['is_plot_payment_list']) : NULL;
            $is_assigned_unit_list = isset($this->request->getData()['Permission']['is_assigned_unit_list']) ? trim($this->request->getData()['Permission']['is_assigned_unit_list']) : NULL;
            $is_generate_pins = isset($this->request->getData()['Permission']['is_generate_pins']) ? trim($this->request->getData()['Permission']['is_generate_pins']) : NULL;
            $is_epin_list = isset($this->request->getData()['Permission']['is_epin_list']) ? trim($this->request->getData()['Permission']['is_epin_list']) : NULL;
            $is_unused_epins = isset($this->request->getData()['Permission']['is_unused_epins']) ? trim($this->request->getData()['Permission']['is_unused_epins']) : NULL;
            $is_used_pins = isset($this->request->getData()['Permission']['is_used_pins']) ? trim($this->request->getData()['Permission']['is_used_pins']) : NULL;
            $is_transferred_pins = isset($this->request->getData()['Permission']['is_transferred_pins']) ? trim($this->request->getData()['Permission']['is_transferred_pins']) : NULL;
            $is_new_registration = isset($this->request->getData()['Permission']['is_new_registration']) ? trim($this->request->getData()['Permission']['is_new_registration']) : NULL;
            $is_upgrade_user = isset($this->request->getData()['Permission']['is_upgrade_user']) ? trim($this->request->getData()['Permission']['is_upgrade_user']) : NULL;
            $is_upgrade_history = isset($this->request->getData()['Permission']['is_upgrade_history']) ? trim($this->request->getData()['Permission']['is_upgrade_history']) : NULL;
            $is_degrade_user = isset($this->request->getData()['Permission']['is_degrade_user']) ? trim($this->request->getData()['Permission']['is_degrade_user']) : NULL;
            $is_user_emi = isset($this->request->getData()['Permission']['is_user_emi']) ? trim($this->request->getData()['Permission']['is_user_emi']) : NULL;
            $is_user_list = isset($this->request->getData()['Permission']['is_user_list']) ? trim($this->request->getData()['Permission']['is_user_list']) : NULL;
            $is_direct_reward = isset($this->request->getData()['Permission']['is_direct_reward']) ? trim($this->request->getData()['Permission']['is_direct_reward']) : NULL;
            $is_pair_reward = isset($this->request->getData()['Permission']['is_pair_reward']) ? trim($this->request->getData()['Permission']['is_pair_reward']) : NULL;
            $is_direct_network = isset($this->request->getData()['Permission']['is_direct_network']) ? trim($this->request->getData()['Permission']['is_direct_network']) : NULL;
            $is_network = isset($this->request->getData()['Permission']['is_network']) ? trim($this->request->getData()['Permission']['is_network']) : NULL;
            $is_direct_referral = isset($this->request->getData()['Permission']['is_direct_referral']) ? trim($this->request->getData()['Permission']['is_direct_referral']) : NULL;
            $is_downline_report = isset($this->request->getData()['Permission']['is_downline_report']) ? trim($this->request->getData()['Permission']['is_downline_report']) : NULL;
            $is_post_report = isset($this->request->getData()['Permission']['is_post_report']) ? trim($this->request->getData()['Permission']['is_post_report']) : NULL;
            $is_current_business = isset($this->request->getData()['Permission']['is_current_business']) ? trim($this->request->getData()['Permission']['is_current_business']) : NULL;
            $is_run_cron = isset($this->request->getData()['Permission']['is_run_cron']) ? trim($this->request->getData()['Permission']['is_run_cron']) : NULL;
            $is_post_incomes = isset($this->request->getData()['Permission']['is_post_incomes']) ? trim($this->request->getData()['Permission']['is_post_incomes']) : NULL;
            $is_saved_post_incomes = isset($this->request->getData()['Permission']['is_saved_post_incomes']) ? trim($this->request->getData()['Permission']['is_saved_post_incomes']) : NULL;
            $is_payment_closing = isset($this->request->getData()['Permission']['is_payment_closing']) ? trim($this->request->getData()['Permission']['is_payment_closing']) : NULL;
            $is_id_wise_closing = isset($this->request->getData()['Permission']['is_id_wise_closing']) ? trim($this->request->getData()['Permission']['is_id_wise_closing']) : NULL;
            $is_closing_details = isset($this->request->getData()['Permission']['is_closing_details']) ? trim($this->request->getData()['Permission']['is_closing_details']) : NULL;
            $is_pending_plot_payment = isset($this->request->getData()['Permission']['is_pending_plot_payment']) ? trim($this->request->getData()['Permission']['is_pending_plot_payment']) : NULL;
            $is_incoming_income = isset($this->request->getData()['Permission']['is_incoming_income']) ? trim($this->request->getData()['Permission']['is_incoming_income']) : NULL;
            $is_outgoing_income = isset($this->request->getData()['Permission']['is_outgoing_income']) ? trim($this->request->getData()['Permission']['is_outgoing_income']) : NULL;
            $is_total_payout_report = isset($this->request->getData()['Permission']['is_total_payout_report']) ? trim($this->request->getData()['Permission']['is_total_payout_report']) : NULL;
            $is_tickets = isset($this->request->getData()['Permission']['is_tickets']) ? trim($this->request->getData()['Permission']['is_tickets']) : NULL;
            $is_tax_and_comission = isset($this->request->getData()['Permission']['is_tax_and_comission']) ? trim($this->request->getData()['Permission']['is_tax_and_comission']) : NULL;
            $is_account_password = isset($this->request->getData()['Permission']['is_account_password']) ? trim($this->request->getData()['Permission']['is_account_password']) : NULL;

            if( 
                !empty($title) 
            ){

                $roleData = $rolesTable->get($roleId);
                $roleData->title = $title;
                if($rolesTable->save($roleData)){
                    $role_id = $roleData->id;
                    $permissionData = $permissionsTable->get($role->Permissions['id']);
                    $permissionData->role_id = $role_id;
                    $permissionData->is_permission = $is_permission;
                    $permissionData->is_staff = $is_staff;
                    $permissionData->is_package = $is_package;
                    $permissionData->is_properties = $is_properties;
                    $permissionData->is_sites = $is_sites;
                    $permissionData->is_blocks = $is_blocks;
                    $permissionData->is_current_rate = $is_current_rate;
                    $permissionData->is_assign_plot = $is_assign_plot;
                    $permissionData->is_assigned_plots = $is_assigned_plots;
                    $permissionData->is_plot_payment = $is_plot_payment;
                    $permissionData->is_plot_payment_list = $is_plot_payment_list;
                    $permissionData->is_assigned_unit_list = $is_assigned_unit_list;
                    $permissionData->is_generate_pins = $is_generate_pins;
                    $permissionData->is_epin_list = $is_epin_list;
                    $permissionData->is_unused_epins = $is_unused_epins;
                    $permissionData->is_used_pins = $is_used_pins;
                    $permissionData->is_transferred_pins = $is_transferred_pins;
                    $permissionData->is_new_registration = $is_new_registration;
                    $permissionData->is_upgrade_user = $is_upgrade_user;
                    $permissionData->is_upgrade_history = $is_upgrade_history;
                    $permissionData->is_degrade_user = $is_degrade_user;
                    $permissionData->is_user_emi = $is_user_emi;
                    $permissionData->is_user_list = $is_user_list;
                    $permissionData->is_direct_reward = $is_direct_reward;
                    $permissionData->is_pair_reward = $is_pair_reward;
                    $permissionData->is_direct_network = $is_direct_network;
                    $permissionData->is_network = $is_network;
                    $permissionData->is_direct_referral = $is_direct_referral;
                    $permissionData->is_downline_report = $is_downline_report;
                    $permissionData->is_post_report = $is_post_report;
                    $permissionData->is_current_business = $is_current_business;
                    $permissionData->is_run_cron = $is_run_cron;
                    $permissionData->is_post_incomes = $is_post_incomes;
                    $permissionData->is_saved_post_incomes = $is_saved_post_incomes;
                    $permissionData->is_payment_closing = $is_payment_closing;
                    $permissionData->is_id_wise_closing = $is_id_wise_closing;
                    $permissionData->is_closing_details = $is_closing_details;
                    $permissionData->is_pending_plot_payment = $is_pending_plot_payment;
                    $permissionData->is_incoming_income = $is_incoming_income;
                    $permissionData->is_outgoing_income = $is_outgoing_income;
                    $permissionData->is_total_payout_report = $is_total_payout_report;
                    $permissionData->is_tickets = $is_tickets;
                    $permissionData->is_tax_and_comission = $is_tax_and_comission;
                    $permissionData->is_account_password = $is_account_password;

                    $permissionsTable->save($permissionData);

                    $this->Flash->success(__('Congratulations! Role has been updated successfully.'));
                    return $this->redirect($this->backend_url.'/roles');
                }
            }


        }
    }


}

