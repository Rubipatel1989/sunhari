<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/my-account/reward/direct-rewards', ['controller' => 'useraccount', 'action' => 'direct_rewards']);

        $builder->connect('/my-account/reward/pair-rewards', ['controller' => 'useraccount', 'action' => 'pair_rewards']);

        $builder->connect('/my-account/plot/my-payments', ['controller' => 'useraccount', 'action' => 'my_payments']);
        
        $builder->connect('/my-account/plot/plot-avaibility', ['controller' => 'useraccount', 'action' => 'plot_avaibility']);

        $builder->connect('/my-account/plot/my-team-plots', ['controller' => 'useraccount', 'action' => 'my_team_plots']);

        $builder->connect('/my-account/plot/my-emi', ['controller' => 'useraccount', 'action' => 'my_emi']);

        $builder->connect('/my-account/plot/my-plots', ['controller' => 'useraccount', 'action' => 'my_plots']);

        $builder->connect('/my-account/payouts/roi-details', ['controller' => 'useraccount', 'action' => 'roi_details']);

        $builder->connect('/cron/make-platinum-club', ['controller' => 'cron', 'action' => 'make_platinum_club']);

        $builder->connect('/cron/index', ['controller' => 'cron', 'action' => 'index']);

        $builder->connect('/cron/make-gold-club', ['controller' => 'cron', 'action' => 'make_gold_club']);

        $builder->connect('/cron/rewards', ['controller' => 'cron', 'action' => 'rewards']);

        $builder->connect('/cron/matching-amount', ['controller' => 'cron', 'action' => 'matching_amount']);

        $builder->connect('/cron/old-roi', ['controller' => 'cron', 'action' => 'old_roi']);

        $builder->connect('/cron/roi', ['controller' => 'cron', 'action' => 'roi']);

        $builder->connect('/my-account/manage-users/add-kyc', ['controller' => 'useraccount', 'action' => 'add_kyc']);

        $builder->connect('/my-account/manage-users/user-added', ['controller' => 'useraccount', 'action' => 'user_added']);

        $builder->connect('/user/user-added', ['controller' => 'user', 'action' => 'user_added']);

        $builder->connect('/my-account/user-activation/upgrade-history', ['controller' => 'useraccount', 'action' => 'upgrade_history']);

        $builder->connect('/my-account/manage-users/add-user/*', ['controller' => 'useraccount', 'action' => 'add_user']);

        $builder->connect('/my-account/transferred-epins', ['controller' => 'useraccount', 'action' => 'transferred_epins']);

        $builder->connect('/my-account/epins', ['controller' => 'useraccount', 'action' => 'epins']);

        $builder->connect('my-account/remove-cart-product/*', ['controller' => 'useraccount', 'action' => 'remove_cart_product']);

        $builder->connect('/my-account/payouts/rewards', ['controller' => 'useraccount', 'action' => 'rewards']);

        $builder->connect('/my-account/checkout', ['controller' => 'useraccount', 'action' => 'checkout']);

        $builder->connect('/my-account/ad/view/*', ['controller' => 'useraccount', 'action' => 'view_ad']);

        $builder->connect('/my-account/buiness-plan', ['controller' => 'useraccount', 'action' => 'buiness_plan']);

        $builder->connect('/my-account/referral-link', ['controller' => 'useraccount', 'action' => 'referral_link']);

        $builder->connect('/my-account/ads', ['controller' => 'useraccount', 'action' => 'ads']);

        $builder->connect('/my-account/payouts/request-payout', ['controller' => 'useraccount', 'action' => 'request_payout']);

        $builder->connect('/my-account/payouts/payout-request', ['controller' => 'useraccount', 'action' => 'payout_request']);

        $builder->connect('/my-account/payouts/closing-details', ['controller' => 'useraccount', 'action' => 'closing_details']);
        
        $builder->connect('/my-account/manage-users/registered-users', ['controller' => 'useraccount', 'action' => 'registered_users']);

        $builder->connect('/my-account/manage-users/upgrade-history', ['controller' => 'useraccount', 'action' => 'upgrade_history']);

        

        $builder->connect('/my-account/wallet/request-fund', ['controller' => 'useraccount', 'action' => 'request_fund']);

        $builder->connect('/my-account/wallet/fund-request', ['controller' => 'useraccount', 'action' => 'fund_request']);
        
        $builder->connect('/my-account/buy-product', ['controller' => 'useraccount', 'action' => 'buyProduct']);

        $builder->connect('/my-account/buy-package', ['controller' => 'useraccount', 'action' => 'buyPackage']);

        $builder->connect('/my-account/my-orders', ['controller' => 'useraccount', 'action' => 'myOrders']);
        
        $builder->connect('/my-account/profile', ['controller' => 'useraccount', 'action' => 'profile']);
        
        $builder->connect('/my-account/change-password/transaction-password', ['controller' => 'useraccount', 'action' => 'transaction_password']);

        $builder->connect('/my-account/change-password/account-password', ['controller' => 'useraccount', 'action' => 'account_password']);

        $builder->connect('/my-account/edit-profile', ['controller' => 'useraccount', 'action' => 'edit_profile']);

        $builder->connect('/my-account/support/view-ticket/*', ['controller' => 'useraccount', 'action' => 'view_ticket']);

        $builder->connect('/my-account/support/add-ticket', ['controller' => 'useraccount', 'action' => 'add_ticket']);
        
        $builder->connect('/my-account/support/tickets', ['controller' => 'useraccount', 'action' => 'tickets']);

        $builder->connect('/my-account/wallet/transfer-amount', ['controller' => 'useraccount', 'action' => 'transfer_amount']);
        
        $builder->connect('/my-account/wallet/transfered-amount', ['controller' => 'useraccount', 'action' => 'transfered_amount']);

        $builder->connect('/my-account/team/direct-network/*', ['controller' => 'useraccount', 'action' => 'direct-network']);
        
        $builder->connect('/my-account/team/direct-network', ['controller' => 'useraccount', 'action' => 'direct_network']);
        
        $builder->connect('/my-account/team/my-network/*', ['controller' => 'useraccount', 'action' => 'my_network']);
        
        $builder->connect('/my-account/team/my-network', ['controller' => 'useraccount', 'action' => 'my_network']);

        $builder->connect('/my-account/team/direct-referral', ['controller' => 'useraccount', 'action' => 'direct_referral']);

        $builder->connect('/my-account/team/downline-report', ['controller' => 'useraccount', 'action' => 'downline_report']);

        $builder->connect('/my-account', ['controller' => 'useraccount', 'action' => 'index']);

        $builder->connect('/my-account/team/downline-report-position', ['controller' => 'useraccount', 'action' => 'downline_report_position']);

        $builder->connect('/my-account/team/current-total-business', ['controller' => 'useraccount', 'action' => 'current_total_business']);

        $builder->connect('/my-account/earning/sponsor-reward', ['controller' => 'useraccount', 'action' => 'sponsor_reward']);

        $builder->connect('/my-account/earning/aojora-reward', ['controller' => 'useraccount', 'action' => 'aojora_reward']);

        $builder->connect('/my-account/earning/level-reward', ['controller' => 'useraccount', 'action' => 'level_reward']);

        $builder->connect('/my-account/earning/royalty-reward', ['controller' => 'useraccount', 'action' => 'royalty_reward']);

        $builder->connect('/my-account/earning/rank-reward', ['controller' => 'useraccount', 'action' => 'rank_reward']);

        $builder->connect('/ajax/get_plot_payment_info/*', ['controller' => 'ajax', 'action' => 'get_plot_payment_info']);

        $builder->connect('/ajax/get_rank_details/*', ['controller' => 'ajax', 'action' => 'get_rank_details']);
        
        $builder->connect('/ajax/get_current_rate_by_plan/*', ['controller' => 'ajax', 'action' => 'get_current_rate_by_plan']);

        $builder->connect('/ajax/get_roi_and_rolalty_by_month/*', ['controller' => 'ajax', 'action' => 'get_roi_and_rolalty_by_month']);

        $builder->connect('/ajax/common_upload', ['controller' => 'ajax', 'action' => 'common_upload']);

        $builder->connect('/ajax/filter_plots_by_user/*', ['controller' => 'ajax', 'action' => 'filter_plots_by_user']);

        $builder->connect('/ajax/get_plot_details/*', ['controller' => 'ajax', 'action' => 'get_plot_details']);
        
        $builder->connect('/ajax/filter_plots/*', ['controller' => 'ajax', 'action' => 'filter_plots']);

        $builder->connect('/ajax/filter_blocks/*', ['controller' => 'ajax', 'action' => 'filter_blocks']);

        $builder->connect('/ajax/filter_site/*', ['controller' => 'ajax', 'action' => 'filter_sites']);

        $builder->connect('/ajax/filter_states/*', ['controller' => 'ajax', 'action' => 'filter_states']);

        $builder->connect('/ajax/referral-link', ['controller' => 'ajax', 'action' => 'referral_link']);

        $builder->connect('/ajax/view_product_details/*', ['controller' => 'ajax', 'action' => 'view_product_details']);

        $builder->connect('/ajax/view_package_details/*', ['controller' => 'ajax', 'action' => 'view_package_details']);

        $builder->connect('/ajax/show_attachments/*', ['controller' => 'ajax', 'action' => 'show_attachments']);

        $builder->connect('/ajax/get-user-details/*', ['controller' => 'ajax', 'action' => 'getUserDetails']);

        $builder->connect('/ajax/remove_attachment/*', ['controller' => 'ajax', 'action' => 'remove_attachment']);
        
        $builder->connect('/ajax/address_proof_upload', ['controller' => 'ajax', 'action' => 'address_proof_upload']);

        $builder->connect('/ajax/id_proof_upload', ['controller' => 'ajax', 'action' => 'id_proof_upload']);

        $builder->connect('/ajax/ajax_upload', ['controller' => 'ajax', 'action' => 'ajax_upload']);

        $builder->connect('/ajax/check_email', ['controller' => 'ajax', 'action' => 'check_email']);
        
        $builder->connect('/ajax/get_sponser_details', ['controller' => 'ajax', 'action' => 'get_sponser_details']);

        $builder->connect('/ajax/get_wallet_details/*', ['controller' => 'ajax', 'action' => 'get_wallet_details']);

        $builder->connect('/ajax/get_amount_details/*', ['controller' => 'ajax', 'action' => 'get_amount_details']);
        
        $builder->connect('/ajax/get-full-name/*', ['controller' => 'ajax', 'action' => 'get_full_name']);

        $builder->connect('/verify-account', ['controller' => 'user', 'action' => 'verify_account']);

        $builder->connect('/register-user/*', ['controller' => 'user', 'action' => 'register_user']);
        
        $builder->connect('/logout_user', ['controller' => 'user', 'action' => 'logout']);

         $builder->connect('/privacy-policy', ['controller' => 'user', 'action' => 'privacy_policy']);

        $builder->connect('/login', ['controller' => 'user', 'action' => 'login']);

        $builder->connect('/registeration-completed', ['controller' => 'user', 'action' => 'registeration_completed']);
        
        $builder->connect('/recover-password', ['controller' => 'user', 'action' => 'recover_password']);
        
        $builder->connect('/user/register/*', ['controller' => 'user', 'action' => 'register']);

        $builder->connect('/user/register', ['controller' => 'user', 'action' => 'register']);

        //Start here
        $builder->connect('my-account/earning/royalty-income', ['controller' => 'earning', 'action' => 'royalty_income']);

        $builder->connect('my-account/earning/repurchase-mb-income', ['controller' => 'earning', 'action' => 'repurchase_mb_income']);

        $builder->connect('my-account/earning/repurchase-income', ['controller' => 'earning', 'action' => 'repurchase_income']);

        $builder->connect('my-account/earning/incentive-income', ['controller' => 'earning', 'action' => 'incentive_income']);

        $builder->connect('my-account/packages/plan-mb-emi-history/*', ['controller' => 'packages', 'action' => 'plan_mb_emi_history']);

        $builder->connect('my-account/packages/plan-ab-emi-history/*', ['controller' => 'packages', 'action' => 'plan_ab_emi_history']);

        $builder->connect('/my-account/team/customers', ['controller' => 'team', 'action' => 'customers']);

        $builder->connect('/my-account/packages/plan-mb-list', ['controller' => 'packages', 'action' => 'plan_mb_list']);

        $builder->connect('/my-account/packages/plan-mb', ['controller' => 'packages', 'action' => 'plan_mb']);

        $builder->connect('/my-account/packages/plan-ab-list', ['controller' => 'packages', 'action' => 'plan_ab_list']);

        $builder->connect('/my-account/packages/plan-ab', ['controller' => 'packages', 'action' => 'plan_ab']);

        $builder->connect('/my-account/customer/user-added', ['controller' => 'customer', 'action' => 'user_added']);

        $builder->connect('/my-account/customer/index', ['controller' => 'customer', 'action' => 'index']);

        $builder->connect('/my-account/customer/new-joining', ['controller' => 'customer', 'action' => 'new_joining']);

        $builder->connect('/my-account/agent/daily-incentive-details', ['controller' => 'agent', 'action' => 'daily_incentive_details']);

        $builder->connect('/my-account/agent/royalty-report', ['controller' => 'agent', 'action' => 'royalty_report']);

        $builder->connect('/my-account/agent/user-added', ['controller' => 'agent', 'action' => 'user_added']);

        $builder->connect('/my-account/agent/index', ['controller' => 'agent', 'action' => 'index']);

        $builder->connect('/my-account/agent/new-joining', ['controller' => 'agent', 'action' => 'new_joining']);

        $builder->connect('/ajax/check_package_details/*', ['controller' => 'ajax', 'action' => 'check_package_details']);

        $builder->connect('/ajax/get_package_amount/*', ['controller' => 'ajax', 'action' => 'get_package_amount']);

        $builder->connect('/ajax/get_ab_packages/*', ['controller' => 'ajax', 'action' => 'get_ab_packages']);

        $builder->connect('/ajax/get_mb_packages/*', ['controller' => 'ajax', 'action' => 'get_mb_packages']);

        $builder->connect('/my-account/bills/add', ['controller' => 'bills', 'action' => 'add']);

        $builder->connect('/my-account/bills/bill-history', ['controller' => 'bills', 'action' => 'bill_history']);
        
        $builder->connect('/my-account/user-payments/pay-user-emi', ['controller' => 'userpayments', 'action' => 'pay_user_emi']);

        $builder->connect('/my-account/user-payments/emi-history', ['controller' => 'userpayments', 'action' => 'emi_history']);

        $builder->connect('/my-account/user-payments/wallet-history', ['controller' => 'userpayments', 'action' => 'wallet_history']);

        $builder->connect('/my-account/user-payments/payment-history', ['controller' => 'userpayments', 'action' => 'payment_history']);

        $builder->connect('/my-account/user-payments/make-payment/*', ['controller' => 'userpayments', 'action' => 'make_payment']);
        
        $builder->connect('/my-account/user-payments/make-payment', ['controller' => 'userpayments', 'action' => 'make_payment']);

        $builder->connect('/*', ['controller' => 'user', 'action' => 'login']);
        
        //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        //$builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall builder for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();

        $builder->prefix('panelcontrol', function (RouteBuilder $routes) {
            // All routes here will be prefixed with `/admin`
            // And have the prefix => admin route element added.
            $routes->fallbacks(DashedRoute::class);
        });
        
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
