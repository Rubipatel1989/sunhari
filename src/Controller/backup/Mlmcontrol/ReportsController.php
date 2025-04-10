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
class ReportsController extends AppController {

    public function pendingPlotPayments() {

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Reports : Pending Plot Payments';

        $this->set('title', $title);

        $usersTable = TableRegistry::get('Users');

        $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
        $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';

        $users = [];
        if(!empty($from_date) && !empty($to_date)){

            $fromDate = date('Y-m-d', strtotime($from_date));
            $toDate = date('Y-m-d', strtotime($to_date));

            $join = array(
                            array(
                                'table' => 'plot_payments',
                                'alias' => 'PlotPayments',
                                'type' => 'LEFT',
                                'conditions' => array('PlotPayments.user_id = Users.id AND DATE(PlotPayments.created) BETWEEN "'.$fromDate.'" AND "'.$toDate.'"')
                            ),
                            array(
                                'table' => 'details',
                                'alias' => 'Details',
                                'type' => 'INNER',
                                'conditions' => array('Details.user_id = Users.id')
                            ),
                            array(
                                'table' => 'assign_plots',
                                'alias' => 'AssignPlots',
                                'type' => 'LEFT',
                                'conditions' => array('AssignPlots.user_id = Users.id')
                            ),
                            array(
                                'table' => 'plots',
                                'alias' => 'Plots',
                                'type' => 'LEFT',
                                'conditions' => array('Plots.id = AssignPlots.plot_id')
                            )
                        );

            $conditions = array(
                                'Users.role_id = 2 AND PlotPayments.user_id IS NULL'
                            ); 
            $fields = array('Details.id', 'Details.first_name', 'Details.last_name', 'Details.contact_no', 'AssignPlots.id', 'AssignPlots.grand_total', 'Plots.id', 'Plots.plot_number', 'Plots.name');
            $users = $usersTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->autoFields(true)
                                 ->select([
                                            'last_emi' => '(SELECT pp.amount FROM plot_payments pp WHERE pp.user_id=Users.id ORDER BY Users.id DESC LIMIT 0, 1)',
                                            'last_emi_date' => '(SELECT pp.created FROM plot_payments pp WHERE pp.user_id=Users.id ORDER BY Users.id DESC LIMIT 0, 1)'
                                        ])
                                 ->where('Users.id IN(SELECT p.user_id FROM plot_payments p)')
                                ->toArray();
        }

        $this->set('users', $users);

        /*echo '<pre>';
        print_r($users);
        exit;*/

    }

    public function incomingIncome() {

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Reports : Incoming Income';

        $this->set('title', $title);

        $plotPaymentsTable = TableRegistry::get('PlotPayments');

        $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
        $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
        $lower_amount = isset($_GET['lower_amount']) ? trim($_GET['lower_amount']) : '';
        $higher_amount = isset($_GET['higher_amount']) ? trim($_GET['higher_amount']) : '';

        $plotPayments = [];
        $totalIncomingPayment = 0;
        if(!empty($from_date) || !empty($to_date) || !empty($lower_amount) || !empty($higher_amount)){

            $fromDateFilter = [];
            $toDateFilter = [];
            $lowerAmountFilter = [];
            $higherAmountDateFilter = [];
            if(!empty($from_date)){
                $fromDate = date('Y-m-d', strtotime($from_date));
            
                $fromDateFilter = array(
                                        'DATE(PlotPayments.created) >=' => $fromDate
                                    );
            }

            if(!empty($to_date)){
                $toDate = date('Y-m-d', strtotime($to_date));

                $toDateFilter = array(
                                        'DATE(PlotPayments.created) <=' => $toDate
                                    );
            }

            if(!empty($lower_amount)){
                $lowerAmountFilter = array(
                                        'PlotPayments.amount >=' => $lower_amount
                                    );
            }

            if(!empty($higher_amount)){
                $higherAmountDateFilter = array(
                                        'PlotPayments.amount <=' => $higher_amount
                                    );
            }
            

            $join = array(
                            array(
                                'table' => 'users',
                                'alias' => 'Users',
                                'type' => 'INNER',
                                'conditions' => array('Users.id = PlotPayments.user_id')
                            ),
                            array(
                                'table' => 'details',
                                'alias' => 'Details',
                                'type' => 'INNER',
                                'conditions' => array('Details.user_id = Users.id')
                            )
                        );

            $conditions = array_merge($fromDateFilter, $toDateFilter, $lowerAmountFilter, $higherAmountDateFilter); 
            $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name', 'Details.contact_no');
            $plotPayments = $plotPaymentsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->autoFields(true)->toArray();
            $totalPlotPayments = $plotPaymentsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))
                                                   ->select([
                                                            'total_amount' => 'SUM(PlotPayments.amount)'
                                                        ])
                                                   ->first();
        }
        $this->set('plotPayments', $plotPayments);

        if(isset($totalPlotPayments->total_amount)){
            $totalIncomingPayment = $totalPlotPayments->total_amount;
        }
        $this->set('totalIncomingPayment', $totalIncomingPayment);
        /*echo '<pre>';
        print_r($plotPayments);
        exit;*/

    }

    public function outgoingIncome() {

        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Reports : Outgoing Income';

        $this->set('title', $title);

        $paymentsTable = TableRegistry::get('Payments');

        $from_date = isset($_GET['from_date']) ? trim($_GET['from_date']) : '';
        $to_date = isset($_GET['to_date']) ? trim($_GET['to_date']) : '';
        $lower_amount = isset($_GET['lower_amount']) ? trim($_GET['lower_amount']) : '';
        $higher_amount = isset($_GET['higher_amount']) ? trim($_GET['higher_amount']) : '';

        $payments = [];
        $totalOutgoingPayment = 0;
        if(!empty($from_date) || !empty($to_date) || !empty($lower_amount) || !empty($higher_amount)){

            $fromDateFilter = [];
            $toDateFilter = [];
            $lowerAmountFilter = [];
            $higherAmountDateFilter = [];
            if(!empty($from_date)){
                $fromDate = date('Y-m-d', strtotime($from_date));
            
                $fromDateFilter = array(
                                        'DATE(Payments.created) >=' => $fromDate
                                    );
            }

            if(!empty($to_date)){
                $toDate = date('Y-m-d', strtotime($to_date));

                $toDateFilter = array(
                                        'DATE(Payments.created) <=' => $toDate
                                    );
            }

            if(!empty($lower_amount)){
                $lowerAmountFilter = array(
                                        'Payments.total >=' => $lower_amount
                                    );
            }

            if(!empty($higher_amount)){
                $higherAmountDateFilter = array(
                                        'Payments.total <=' => $higher_amount
                                    );
            }
            

            $join = array(
                            array(
                                'table' => 'users',
                                'alias' => 'Users',
                                'type' => 'INNER',
                                'conditions' => array('Users.id = Payments.user_id')
                            ),
                            array(
                                'table' => 'details',
                                'alias' => 'Details',
                                'type' => 'INNER',
                                'conditions' => array('Details.user_id = Users.id')
                            )
                        );

            $conditions = array_merge($fromDateFilter, $toDateFilter, $lowerAmountFilter, $higherAmountDateFilter); 
            $fields = array('Users.id', 'Users.username', 'Details.id', 'Details.first_name', 'Details.last_name', 'Details.contact_no');
            $payments = $paymentsTable->find('all', array('fields' => $fields, 'join' => $join, 'conditions' => $conditions))->autoFields(true)->toArray();
            $totalPayments = $paymentsTable->find('all', array('join' => $join, 'conditions' => $conditions))
                                                   ->select([
                                                            'total_amount' => 'SUM(Payments.total)'
                                                        ])
                                                   ->first();
        }
        $this->set('payments', $payments);

        /*echo '<pre>';
        print_r($totalPayments);exit;*/

        if(isset($totalPayments->total_amount) && !empty($totalPayments->total_amount)){
           $totalOutgoingPayment = $totalPayments->total_amount;
        }
        $this->set('totalOutgoingPayment', $totalOutgoingPayment);
       // echo $totalPayments;
        //exit;
        /*echo '<pre>';
        print_r($plotPayments);
        exit;*/

    }

    public function totalPayoutReport()
    {
        if(!$this->request->getSession()->check('adminUserId')){
            return $this->redirect(['controller' => 'user', 'action' => 'login', 'prefix' => $this->backend]);
        }

        $prefix_title = $this->backendTitle;
        
        $title = $prefix_title.' Reports : Total Payout Report';

        $this->set('title', $title);

        $userTable = TableRegistry::get('Users');

        $join = array(
                        array(    
                            'table' => 'payments',
                            'alias' => 'Payments',
                            'type' => 'INNER',
                            'conditions' => array('Payments.user_id = Users.id')
                        ),
                        array(    
                            'table' => 'details',
                            'alias' => 'Details',
                            'type' => 'INNER',
                            'conditions' => array('Details.user_id = Users.id')
                        )
                );
        $group = array('Users.id');
        $fields = array('Users.username', 'Details.first_name');
        $users = $userTable->find('all', array('fields' => $fields,'join' => $join, 'group' => $group))
                            ->select([
                                        'direct_amount' => '(SELECT SUM(p.direct_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'matching_amount' => '(SELECT SUM(p.matching_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'gold_amount' => '(SELECT SUM(p.mobile_club_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'platinum_amount' => '(SELECT SUM(p.laptop_club_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'ambrand_amount' => '(SELECT SUM(p.bike_club_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'diamond_club_amount' => '(SELECT SUM(p.diamond_club_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'king_club_amount' => '(SELECT SUM(p.king_club_amount) FROM payments p WHERE p.user_id = Users.id)',
                                        'admin_commission' => '(SELECT SUM(p.admin_commission) FROM payments p WHERE p.user_id = Users.id)',
                                        'tax' => '(SELECT SUM(p.tax) FROM payments p WHERE p.user_id = Users.id)',
                                        'total' => '(SELECT SUM(p.total) FROM payments p WHERE p.user_id = Users.id)',
                                        'net_amount' => '(SELECT SUM(p.net_amount) FROM payments p WHERE p.user_id = Users.id)',
                                    ])
                            ->toArray();

        $this->set('users', $users);


    }

}
