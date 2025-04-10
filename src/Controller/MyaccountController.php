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
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;

class MyaccountController extends AppController
{
    public function index()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Account";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $binariesTable = TableRegistry::get("Binaries");

        $packagesTable = TableRegistry::get("Packages");

        $conditions = [
            "Binaries.status" => 1,
        ];

        $fields = ["Binaries.type", "Binaries.amount", "Binaries.percentage"];

        $binary = $binariesTable
            ->find("all", ["fields" => $fields, "conditions" => $conditions])
            ->first();

        $this->set("binary", $binary);

        $conn = ConnectionManager::get("default");

        $query = $conn->execute(
            "SELECT SUM(Payouts.direct_amount) as directIncome, SUM(Payouts.matching_amount) as matchingAmount, SUM(Payouts.royalty_amount) as royaltyAmount, SUM(Payouts.roi) as roiAmount, u.is_mobile_club, u.is_laptop_club, u.is_bike_club,

            (SELECT SUM(tWalletAmt.amount) FROM wallets as tWalletAmt WHERE tWalletAmt.user_id = '" .
                $this->user->id .
                "' AND tWalletAmt.status = '1') AS totalWalletAmount,


            (SELECT SUM(tTransferredAmt.amount) FROM wallets as tTransferredAmt WHERE tTransferredAmt.transfer_by = '" .
                $this->user->id .
                "' AND tTransferredAmt.status = '1') AS totalTransferredAmount,


            (SELECT SUM(tUpgradesAmt.package_amount) FROM upgrades as tUpgradesAmt WHERE tUpgradesAmt.upgraded_by = '" .
                $this->user->id .
                "') AS totalUpgradesAmount,


            (SELECT (SUM(pNetAmt.net_amount)) FROM payments as pNetAmt WHERE pNetAmt.user_id = '" .
                $this->user->id .
                "') AS totalPayouts,

            (SELECT SUM(sWithdrawals.requested_amount) FROM payments as sWithdrawals WHERE sWithdrawals.user_id = '" .
                $this->user->id .
                "' AND sWithdrawals.status = '1') AS successfullWithdrawls,

            (SELECT SUM(pWithdrawals.requested_amount) FROM payments as pWithdrawals WHERE pWithdrawals.user_id = '" .
                $this->user->id .
                "' AND pWithdrawals.status = '0') AS pendingWithdrawls,

            (SELECT SUM(tPackages.package_bv) FROM upgrades as tPackages WHERE tPackages.upgraded_id = '" .
                $this->user->id .
                "' AND tPackages.expiry_date >= '" .
                date("Y-m-d") .
                "') AS totalPackages,

            (SELECT tAativation.created FROM upgrades as tAativation WHERE tAativation.upgraded_id = '" .
                $this->user->id .
                "' ORDER BY tAativation.id ASC LIMIT 0,1) AS activationDate,

            (SELECT exPackage.expiry_date FROM upgrades as exPackage WHERE exPackage.upgraded_id = '" .
                $this->user->id .
                "' AND exPackage.expiry_date < '" .
                date("Y-m-d") .
                "' ORDER BY exPackage.id DESC LIMIT 0, 1) AS lastExpiry,

            (SELECT uDate.created FROM upgrades as uDate WHERE uDate.upgraded_id = '" .
                $this->user->id .
                "' ORDER BY uDate.id ASC LIMIT 0, 1) AS upgradedDate,

            (SELECT pId.package_id FROM upgrades as pId WHERE pId.upgraded_id = '" .
                $this->user->id .
                "' ORDER BY pId.id ASC LIMIT 0, 1) AS packageId,

            (SELECT IF(uPP.total_active_left < uPP.total_active_right, uPP.total_active_left, uPP.total_active_right) - uPP.previous_pair FROM users as uPP WHERE uPP.id = '" .
                $this->user->id .
                "') AS totaPendingPayable FROM payouts as Payouts INNER JOIN users u ON Payouts.upagraded_user_id = u.id WHERE Payouts.upagraded_user_id = '" . $this->user->id ."'"
        );

        $statistics = $query->fetchAll("assoc");

        $this->set("statistics", $statistics);

        /*echo '<pre>';

        print_r($statistics);

        exit;*/

        $package = [];

        if (
            isset($statistics[0]["packageId"]) &&
            !empty($statistics[0]["packageId"])
        ) {
            $conditions = ["Packages.id" => $statistics[0]["packageId"]];

            $fields = ["Packages.booster_time"];

            $package = $packagesTable
                ->find("all", [
                    "fields" => $fields,
                    "conditions" => $conditions,
                ])
                ->first();
        }

        $this->set("package", $package);
    }

    public function directNetwork($stringUsername='')
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Direct Network";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $dwonlinesTable = TableRegistry::get("Downlines");

        $top_parent_id = $this->user->id;

        $topUserInfo = $this->user;

        if ($stringUsername) {
            $username = $stringUsername;

            $conditions = ["Users.username" => $username];

            $joins = [
                [
                    "table" => "details",

                    "alias" => "Details",

                    "type" => "INNER",

                    "conditions" => ["Details.user_id = Users.id"],
                ],
            ];

            $userInfo = $usersTable
                ->find("all", [
                    "fields" => [
                        "Details.id",
                        "Details.first_name",
                        "Details.middle_name",
                        "Details.last_name",
                    ],
                    "conditions" => $conditions,
                    "join" => $joins,
                ])
                ->enableAutoFields(true)
                ->first();

            if (!empty($userInfo)) {
                $top_parent_id = $userInfo->id;

                $topUserInfo = $userInfo;
            }
        }

        $this->set("topUserInfo", $topUserInfo);

        $conditions = [
            "Downlines.user_id" => $top_parent_id,

            "Downlines.sponsor_id" => $top_parent_id,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $order = ["Downlines.level DESC"];

        $downlines = $dwonlinesTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.parent_id",
                    "Users.position",
                    "Users.username",
                    "Users.status",
                    "Sponsers.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $dirctUsers = $dwonlinesTable->getDirectUsers($downlines);

        $this->set("dirctUsers", $dirctUsers);
    }

    public function myNetwork($stringUsername='')
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Network";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $dwonlinesTable = TableRegistry::get("Downlines");

        $top_parent_id = $this->user->id;

        $conditions = ["Users.id" => $this->user->id];

        $slectedUsername = "";

        if ($stringUsername) {
            $username = base64_decode($stringUsername);

            $username = explode("___", $username);

            $username = $username[0];

            $slectedUsername = $username;

            $conditions = ["Users.username" => $username];
        }

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Users.sponsor_id"],
            ],
        ];

        $userInfo = $usersTable
            ->find("all", [
                "fields" => [
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                    "Sponsers.username",
                ],
                "conditions" => $conditions,
                "join" => $joins,
            ])

            ->select([
                "total_business_point" =>
                    "(SELECT SUM(u.business_point) FROM upgrades u WHERE u.upgraded_id=Users.id)",
            ])

            ->enableAutoFields(true)
            ->first();

        if (!empty($userInfo)) {
            $top_parent_id = $userInfo->id;

            $topUserInfo = $userInfo;
        }

        $this->set("topUserInfo", $topUserInfo);

        $this->set("slectedUsername", $slectedUsername);

        $conditions = [
            "Downlines.user_id" => $top_parent_id,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],

            [
                "table" => "assign_plots",

                "alias" => "AssignPlots",

                "type" => "left",

                "conditions" => [
                    "AssignPlots.user_id = Downlines.user_table_id AND AssignPlots.status=1",
                ],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $order = ["Downlines.level ASC"];

        $limit = 14;

        $fields = [
            "Users.id",
            "Users.parent_id",
            "Users.position",
            "Users.username",
            "Users.sponsor_name",
            "Users.total_left",
            "Users.total_right",
            "Users.total_active_left",
            "Users.total_active_right",
            "Users.status",
            "Sponsers.username",
            "Details.id",
            "Details.first_name",
            "Details.middle_name",
            "Details.last_name",
            "AssignPlots.id",
            "AssignPlots.plot_number",
            "AssignPlots.grand_total",
        ];

        $downlines = $dwonlinesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
                "order" => $order,
                "limit" => $limit,
            ])

            ->select([
                "total_paid_payment" =>
                    "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=AssignPlots.user_id AND pp.assign_plot_id=AssignPlots.id)",
            ])

            ->select([
                "total_upgrades" =>
                    "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=Downlines.user_table_id)",
            ])

            ->enableAutoFields(true)
            ->toArray();

        $trees = $dwonlinesTable->getTreeByDownlines($downlines);

        $this->set("trees", $trees);

        $top_parent_id = $this->user->id;

        $conditions = [
            "Downlines.user_id" => $top_parent_id,
        ];

        $order = ["Users.id ASC"];

        $downlines = $dwonlinesTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.parent_id",
                    "Users.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
                "order" => $order,
            ])
            ->toArray();

        /* echo '<pre>';

        print_r($downlines);exit;*/

        $this->set("downlines", $downlines);
    }

    public function directReferral()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Direct Referral";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $usersTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_id" => $this->user->id,

            "Downlines.sponsor_id" => $this->user->id,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $downlines = $usersTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.username",
                    "Users.status",
                    "Sponsers.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("downlines", $downlines);
    }

    public function downlineReport()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_id" => $this->user->id,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],

            [
                "table" => "plot_payments",

                "alias" => "PlotPayments",

                "type" => "left",

                "conditions" => [
                    "PlotPayments.user_id = Downlines.user_table_id AND PlotPayments.number_of_unit > 0",
                ],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $fields = [
            "Users.id",
            "Users.username",
            "Users.total_active_left",
            "Users.total_active_right",
            "Users.status",
            "Sponsers.username",
            "Details.id",
            "Details.first_name",
            "Details.middle_name",
            "Details.last_name",
            "Details.contact_no",
            "PlotPayments.id",
            "PlotPayments.number_of_unit",
        ];

        $downlines = $downlinesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("downlines", $downlines);
    }

    public function downlineReportPosition()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_id" => $this->user->id,
        ];

        $connection = ConnectionManager::get("default");

        $downlines = $connection
            ->query(
                'SELECT d.position,SUM(CASE WHEN u.is_mobile_club = 1 THEN 1 ELSE 0 END) AS mobile_club_count,SUM(CASE WHEN                                                         u.is_laptop_club = 1 THEN 1 ELSE 0 END) AS laptop_club_count,SUM(CASE WHEN u.is_bike_club = 1 THEN 1 ELSE 0 END) AS bike_club_count,SUM(CASE WHEN u.is_diamond_club = 1 THEN 1 ELSE 0 END) AS diamond_club_count,SUM(CASE WHEN u.is_king_club = 1 THEN 1 ELSE 0 END) AS king_club_count FROM downlines d JOIN users u ON d.user_table_id = u.id

                                            WHERE d.user_id = ' .
                    $this->user->id .
                    '

                                            GROUP BY d.position'
            )
            ->fetchAll("assoc");

        $this->set("downlines", $downlines);
    }

    public function currentTotalBusiness()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        if (!empty($_GET["from_date"]) && !empty($_GET["to_date"])) {
            $fromdate = $_GET["from_date"];

            $to_date = $_GET["to_date"];

            $fromdate = date("Y-m-d", strtotime($fromdate));

            $to_date = date("Y-m-d", strtotime($to_date));

            $connection = ConnectionManager::get("default");

            $totalbusiess = $connection
                ->query(
                    "SELECT d.position, SUM(p.amount) as total_amount FROM downlines d INNER JOIN plot_payments p ON d.user_table_id = p.user_id WHERE d.user_id = " .
                        $this->user->id .
                        ' AND d.position IN ("left", "right") AND p.created BETWEEN "' .
                        $fromdate .
                        '" AND "' .
                        $to_date .
                        '" GROUP BY d.position'
                )
                ->fetchAll("assoc");

            $this->set("totalbusiness", $totalbusiess);
        }
    }

    public function transferedAmount()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Wallet : Amount Transfered";

        $this->set("title", $title);

        $walletsTable = TableRegistry::get("Wallets");

        $conditions = [
            "Wallets.status !=" => 2,

            "Wallets.transfer_by" => $this->user->id,
        ];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Wallets.user_id"],
            ],

            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $order = ["Wallets.id" => "DESC"];

        $fields = [
            "Users.id",
            "Users.username",
            "Details.id",
            "Details.first_name",
            "Details.middle_name",
            "Details.last_name",
        ];

        $wallets = $walletsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("wallets", $wallets);
    }

    public function transferAmount()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Wallet : Transfer Amount";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $walletsTable = TableRegistry::get("Wallets");

        $conditions = [
            "Downlines.user_id" => $this->user->id,

            "Users.status" => 1,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $downlines = $downlinesTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.username",
                    "Users.status",
                    "Sponsers.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("userInfos", $downlines);

        $template = "transfer_amount";

        if ($this->request->is("post")) {
            $user_id = $this->user->id;

            //echo '<pre>';

            //print_r($this->request->getData());exit;

            if (isset($this->request->getData()["btn_transfer_fund"])) {
                $wallet = [];

                $wallet["user_id"] = $this->request->getData()["Wallet"]["username"];

                $wallet["amount"] = $this->request->getData()["Wallet"]["amount"];

                $wallet["remark"] = $this->request->getData()["Wallet"]["remark"];

                $wallet["status"] = 0;

                $this->request->getSession()->write("walletTemp", $wallet);

                if ($this->request->getSession()->check("walletTemp")) {
                    $template = "transaction_password";
                }
            }

            if (isset($this->request->getData()["btn_transaction_password"])) {
                $template = "transaction_password";

                $userInfo = $usersTable
                    ->find("all", [
                        "conditions" => [
                            "Users.id" => $user_id,
                            "Users.transaction_password" => md5(
                                $this->request->getData()["User"][
                                    "transaction_password"
                                ]
                            ),
                        ],
                    ])
                    ->first();

                if (!empty($userInfo)) {
                    $otp = rand(123456, 999999);

                    $userSaveData = $usersTable->get($user_id);

                    $userSaveData->otp = md5($otp);

                    $usersTable->save($userSaveData);

                    $template =
                        "Dear " .
                        $this->user->Details["first_name"] .
                        " " .
                        $this->user->Details["last_name"] .
                        ", Your One Time Password(OTP) for www.octiqmarketing.com is: " .
                        $otp .
                        " For more help, please contact our support or visit www.octiqmarketing.com";

                    $sendSMS = $usersTable->sendSMS(
                        $template,
                        $this->user->Details["contact_no"]
                    );

                    $this->Flash->success(
                        __(
                            "Please enter below sent OPT on your registered contact number."
                        )
                    );

                    $template = "otp";
                } else {
                    $this->Flash->error(
                        __(
                            "Entered transaction password is wrong. Please enter correct transaction password"
                        )
                    );
                }
            }

            if (isset($this->request->getData()["btn_otp"])) {
                $template = "otp";

                $userInfo = $usersTable
                    ->find("all", [
                        "conditions" => [
                            "Users.id" => $user_id,
                            "Users.otp" => md5(
                                $this->request->getData()["User"]["otp"]
                            ),
                        ],
                    ])
                    ->first();

                if (!empty($userInfo)) {
                    $tansactionId = $walletsTable->getTransactionId(11);

                    $walletInfo = $this->request->getSession()->read("walletTemp");

                    $wallet = $walletsTable->newEmptyEntity();

                    $wallet->user_id = $walletInfo["user_id"];

                    $wallet->transfer_by = $user_id;

                    $wallet->transaction_id = $tansactionId;

                    $wallet->amount = $walletInfo["amount"];

                    $wallet->remark = $walletInfo["remark"];

                    $wallet->status = $walletInfo["status"];

                    if ($walletsTable->save($wallet)) {
                        $userSaveData = $usersTable->get($user_id);

                        $userSaveData->otp = null;

                        $usersTable->save($userSaveData);

                        $this->request->getSession()->delete("walletTemp");

                        $this->Flash->success(
                            __("Fund has been transfer successfully.")
                        );

                        return $this->redirect($this->home_url.'/my-account/transfered_amount');
                    }
                } else {
                    $this->Flash->error(
                        __("Entered OTP is wrong. Please enter correct OTP")
                    );
                }
            }
        }

        //echo $template;

        $this->render($template);
    }

    public function tickets()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Tickets";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $ticketsTable = TableRegistry::get("Tickets");

        $conditions = [
            "Tickets.ticket_by" => $this->user->id,
            "Tickets.status !=" => 2,
        ];

        $order = ["Tickets.id" => "DESC"];

        $tickets = $ticketsTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("tickets", $tickets);
    }

    public function addTicket()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Add Ticket";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $ticketsTable = TableRegistry::get("Tickets");

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());

            //exit;

            $ticket_id = $ticketsTable->getTicket(11);

            $ticket = $ticketsTable->newEmptyEntity();

            $ticket->ticket_id = $ticket_id;

            $ticket->ticket_by = $this->user->id;

            $ticket->subject = $this->request->getData()["Ticket"]["subject"];

            $ticket->description = nl2br(
                $this->request->getData()["Ticket"]["description"]
            );

            $ticket->status = 0;

            if ($ticketsTable->save($ticket)) {
                $this->Flash->success(
                    __(
                        "Your ticket has been raised successfully. We will assist you shortly."
                    )
                );

                return $this->redirect($this->home_url.'/my-account/support/tickets');
            }
        }
    }

    public function viewTicket($ticketId)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        if (!isset($ticketId)) {
            return $this->redirect($this->home_url.'/my-account/tickets');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " View Ticket";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $ticketsTable = TableRegistry::get("Tickets");

        $repliesTable = TableRegistry::get("Replies");

        $conditions = ["Tickets.ticket_id" => $ticketId];

        $ticket = $ticketsTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->first();

        $conditions = ["Tickets.ticket_id" => $ticketId];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Tickets.ticket_by"],
            ],
        ];

        $fields = ["Users.id", "Users.username"];

        $ticket = $ticketsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->first();

        $this->set("ticket", $ticket);

        $conditions = [
            "Replies.ticket_id" => $ticket->id,

            "Replies.status !=" => 2,
        ];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Replies.replied_by"],
            ],
        ];

        $fields = ["Users.id", "Users.username"];

        $replies = $repliesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("replies", $replies);

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());exit;

            if (isset($this->request->getData()["btn_post_reply"])) {
                $reply = $repliesTable->newEmptyEntity();

                $reply->parent_id = $this->request->getData()["Reply"]["parent_id"];

                $reply->ticket_id = $this->request->getData()["Reply"]["ticket_id"];

                $reply->replied_by = $this->user->id;

                $reply->description = nl2br(
                    $this->request->getData()["Reply"]["description"]
                );

                $reply->status = 1;

                if ($repliesTable->save($reply)) {
                    $this->Flash->success(
                        __("Reply has been added successfully.")
                    );

                    return $this->redirect($this->home_url.'/my-account/view_ticket/'.$ticket->ticket_id);
                }
            } elseif (isset($this->request->getData()["btn_edit_reply"])) {
                $reply = $repliesTable->get(
                    $this->request->getData()["Reply"]["id"]
                );

                $reply->description = nl2br(
                    $this->request->getData()["Reply"]["description"]
                );

                $reply->status = 1;

                if ($repliesTable->save($reply)) {
                    $this->Flash->success(
                        __("Reply has been updated successfully.")
                    );
                    
                    return $this->redirect($this->home_url.'/my-account/view_ticket/'.$ticket->ticket_id);
                }
            }
        }
    }

    public function editProfile()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Edit Profile";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $detailsTable = TableRegistry::get("Details");

        $statesTable = TableRegistry::get("States");

        $attachmentsTable = TableRegistry::get("Attachments");

        $countriesTable = TableRegistry::get("Countries");

        $countries = $countriesTable
            ->find("all", [
                "conditions" => ["Countries.status" => 1],
                "order" => ["Countries.name" => "ASC"],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("countries", $countries);

        $conditions = [
            "Details.user_id" => $this->user->id,
        ];

        $join = [
            [
                "table" => "attachments",

                "alias" => "Photo",

                "type" => "LEFT",

                "conditions" => [
                    'Photo.reference_id = Details.user_id AND Photo.reference_type = "user_photo"',
                ],
            ],

            [
                "table" => "attachments",

                "alias" => "IdProof",

                "type" => "LEFT",

                "conditions" => [
                    'IdProof.reference_id = Details.user_id AND IdProof.reference_type = "id_proof"',
                ],
            ],

            [
                "table" => "attachments",

                "alias" => "AddressProof",

                "type" => "LEFT",

                "conditions" => [
                    'AddressProof.reference_id = Details.user_id AND AddressProof.reference_type = "address_proof"',
                ],
            ],
        ];

        $fields = [
            "Photo.id",
            "Photo.file",
            "Photo.caption",

            "IdProof.id",
            "IdProof.file",
            "IdProof.caption",

            "AddressProof.id",
            "AddressProof.file",
            "AddressProof.caption",
        ];

        $detail = $detailsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->first();

        $this->set("detail", $detail);

        /* echo '<pre>';

        print_r($detail);exit;*/

        $conditions = [
            "States.id" => $detail->state_id,
        ];

        $state = $statesTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->first();

        $this->set("state", $state);

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());exit;*/

            $conditions = [
                "Details.pan_number" =>
                    $this->request->getData()["Detail"]["pan_number"],
            ];

            $checkPanCount = $detailsTable
                ->find("all", ["conditions" => $conditions])
                ->count();

            if ($checkPanCount < 1000) {
                $user_id = $this->user->id;

                $userData = $usersTable->get($user_id);

                $userData->email = $this->request->getData()["User"]["email"];

                if ($usersTable->save($userData)) {
                    $detailData = $detailsTable->get(
                        $this->request->getData()["Detail"]["id"]
                    );

                    $detailData->first_name =
                        $this->request->getData()["Detail"]["first_name"];

                    $detailData->last_name = isset(
                        $this->request->getData()["Detail"]["last_name"]
                    )
                        ? $this->request->getData()["Detail"]["last_name"]
                        : null;

                    $detailData->father_name =
                        $this->request->getData()["Detail"]["father_name"];

                    $detailData->dob = $this->request->getData()["Detail"]["dob"];

                    if (
                        isset($this->request->getData()["Detail"]["gender"]) &&
                        !empty($this->request->getData()["Detail"]["gender"])
                    ) {
                        $detailData->gender =
                            $this->request->getData()["Detail"]["gender"];
                    }

                    //$detailData->contact_no       =   $this->request->getData()['Detail']['contact_no'];

                    if (
                        isset($this->request->getData()["Detail"]["country_id"]) &&
                        !empty($this->request->getData()["Detail"]["country_id"])
                    ) {
                        $detailData->country_id =
                            $this->request->getData()["Detail"]["country_id"];
                    }

                    if (
                        isset($this->request->getData()["Detail"]["state_id"]) &&
                        !empty($this->request->getData()["Detail"]["state_id"])
                    ) {
                        $detailData->state_id =
                            $this->request->getData()["Detail"]["state_id"];
                    }

                    $detailData->city_name =
                        $this->request->getData()["Detail"]["city_name"];

                    $detailData->address =
                        $this->request->getData()["Detail"]["address"];

                    $detailData->pin_code =
                        $this->request->getData()["Detail"]["pin_code"];

                    $detailData->adhar_number = isset(
                        $this->request->getData()["Detail"]["adhar_number"]
                    )
                        ? $this->request->getData()["Detail"]["adhar_number"]
                        : null;

                    $detailData->occupation = isset(
                        $this->request->getData()["Detail"]["occupation"]
                    )
                        ? $this->request->getData()["Detail"]["occupation"]
                        : null;

                    $detailData->pan_number = isset(
                        $this->request->getData()["Detail"]["pan_number"]
                    )
                        ? $this->request->getData()["Detail"]["pan_number"]
                        : null;

                    $detailData->account_number = isset(
                        $this->request->getData()["Detail"]["account_number"]
                    )
                        ? $this->request->getData()["Detail"]["account_number"]
                        : null;

                    $detailData->bank_name =
                        $this->request->getData()["Detail"]["bank_name"];

                    $detailData->branch_name =
                        $this->request->getData()["Detail"]["branch_name"];

                    $detailData->ifsc_code =
                        $this->request->getData()["Detail"]["ifsc_code"];

                    if (
                        isset(
                            $this->request->getData()["Detail"]["type_of_account"]
                        ) &&
                        !empty(
                            $this->request->getData()["Detail"]["type_of_account"]
                        )
                    ) {
                        $detailData->type_of_account =
                            $this->request->getData()["Detail"]["type_of_account"];
                    }

                    if (
                        isset($this->request->getData()["Detail"]["contact_no"]) &&
                        !empty($this->request->getData()["Detail"]["contact_no"])
                    ) {
                        $detailData->contact_no =
                            $this->request->getData()["Detail"]["contact_no"];
                    }

                    $detailData->whats_app_number = isset(
                        $this->request->getData()["Detail"]["whats_app_number"]
                    )
                        ? $this->request->getData()["Detail"]["whats_app_number"]
                        : null;

                    $detailData->nominee_name =
                        $this->request->getData()["Detail"]["nominee_name"];

                    $detailData->relationship =
                        $this->request->getData()["Detail"]["relationship"];

                    $detailsTable->save($detailData);

                    if (!empty($this->request->getData()["Attachment"])) {
                        foreach (
                            $this->request->getData()["Attachment"]
                            as $referenceType => $referenceValue
                        ) {
                            $attachmentData = $attachmentsTable->get(
                                $referenceValue[0]
                            );

                            $attachmentData->reference_id = $this->user->id;

                            $attachmentData->reference_type = $referenceType;

                            $attachmentData->caption =
                                $referenceValue["caption"][0];

                            $attachmentsTable->save($attachmentData);
                        }
                    }

                    $parentName = $this->request->getData()["Detail"]["first_name"];

                    $usersTable->updateAll(
                        ["parent_name" => $parentName],
                        ["parent_id" => $user_id]
                    );

                    $usersTable->updateAll(
                        ["sponsor_name" => $parentName],
                        ["sponsor_id" => $user_id]
                    );

                    $this->Flash->success(
                        __("Details has been updated successfully.")
                    );

                    return $this->redirect(
                        $this->home_url . "/my-account/edit-profile"
                    );
                }
            } else {
                $this->Flash->error(
                    __(
                        "Entered PAN is already used 7 times. So please different PAN number."
                    )
                );
            }
        }
    }

    public function accountPassword()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Change password : Account Password";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $template = "account_password";

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());exit;

            $user_id = $this->user->id;

            if (isset($this->request->getData()["btn_account_password"])) {
                $userInfo = $usersTable
                    ->find("all", [
                        "conditions" => [
                            "Users.id" => $user_id,
                            "Users.password" => md5(
                                $this->request->getData()["User"]["password"]
                            ),
                        ],
                    ])
                    ->enableAutoFields(true)
                    ->first();

                if (!empty($userInfo)) {
                    $userData = $usersTable->get($user_id);

                    $userData->password = md5(
                        $this->request->getData()["User"]["new_password"]
                    );

                    if ($usersTable->save($userData)) {
                        $this->Flash->success(
                            __("Your password has been changed successfully.")
                        );

                        return $this->redirect($this->home_url.'/my-account/change-password/account_password');
                    }
                } else {
                    $this->Flash->error(
                        __("Your old password did not match to our database.")
                    );
                }
            }
        }

        $this->render($template);
    }

    public function transactionPassword()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Change password : Transaction Password";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $template = "change_transaction_password";

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());exit;*/

            $user_id = $this->user->id;

            if (isset($this->request->getData()["btn_account_password"])) {
                $userInfo = $usersTable
                    ->find("all", [
                        "conditions" => [
                            "Users.id" => $user_id,
                            "Users.transaction_password" => md5(
                                $this->request->getData()["User"][
                                    "transaction_password"
                                ]
                            ),
                        ],
                    ])
                    ->enableAutoFields(true)
                    ->first();

                if (!empty($userInfo)) {
                    $userData = $usersTable->get($user_id);

                    $userData->transaction_password = md5(
                        $this->request->getData()["User"]["new_transaction_password"]
                    );

                    if ($usersTable->save($userData)) {
                        $this->Flash->success(
                            __(
                                "Your transaction password has been changed successfully."
                            )
                        );

                        return $this->redirect($this->home_url.'/my-account/transaction_password');
                    }
                } else {
                    $this->Flash->error(
                        __(
                            "Your old transaction password did not match to our database."
                        )
                    );
                }
            }
        }

        $this->render($template);
    }

    public function buyPackage()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Buy Package";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $packagesTable = TableRegistry::get("Packages");

        $conditions = [
            "Packages.status" => 1,
        ];

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => [
                    "Attachments.reference_id = Packages.id",
                    'Attachments.reference_type = "package"',
                ],
            ],
        ];

        $order = [
            "Packages.position" => "ASC",
        ];

        $fields = [
            "Attachments.id",
            "Attachments.reference_id",
            "Attachments.reference_type",
            "Attachments.file",
            "Attachments.caption",
        ];

        $packages = $packagesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("packages", $packages);
    }

    public function buyProduct()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Buy Product";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $productsTable = TableRegistry::get("Products");

        $conditions = [
            "Products.status" => 1,
        ];

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => ["Attachments.id = Products.attachment_id"],
            ],
        ];

        $order = [
            "Products.position" => "ASC",
        ];

        $fields = [
            "Attachments.id",
            "Attachments.reference_id",
            "Attachments.reference_type",
            "Attachments.file",
            "Attachments.caption",
        ];

        $products = $productsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("products", $products);
    }

    public function myOrders()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Orders";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $ordersTable = TableRegistry::get("Orders");

        $conditions = [
            "Orders.user_id" => $this->user->id,
        ];

        $order = ["Orders.id" => "DESC"];

        $orders = $ordersTable
            ->find("all", ["conditions" => $conditions, "order" => $order])

            ->contain(["Ordereditems"])

            ->enableAutoFields(true)
            ->toArray();

        $this->set("orders", $orders);
    }

    public function fundRequest()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Fund Request";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $fundrequestsTable = TableRegistry::get("Fundrequests");

        $conditions = [
            "Fundrequests.user_id" => $this->user->id,

            "Fundrequests.status !=" => 2,
        ];

        $order = [
            "Fundrequests.id" => "DESC",
        ];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Fundrequests.user_id"],
            ],
        ];

        $fields = ["Users.id", "Users.username"];

        $fundrequests = $fundrequestsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("fundrequests", $fundrequests);
    }

    public function requestFund()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Request Fund";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $fundrequestsTable = TableRegistry::get("Fundrequests");

        $bitcoinsTable = TableRegistry::get("Bitcoins");

        $join = [
            [
                "table" => "attachments",

                "alias" => "Attachments",

                "type" => "LEFT",

                "conditions" => [
                    "Attachments.reference_id = Bitcoins.id",
                    'Attachments.reference_type = "bitcoin"',
                ],
            ],
        ];

        $order = ["Bitcoins.id" => "DESC"];

        $fields = [
            "Attachments.id",
            "Attachments.reference_id",
            "Attachments.reference_type",
            "Attachments.file",
            "Attachments.caption",
        ];

        $conditions = ["Bitcoins.status" => 1];

        $bitcoin = $bitcoinsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
                "limit" => 1,
            ])
            ->enableAutoFields(true)
            ->first();

        $this->set("bitcoin", $bitcoin);

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());exit;

            $fundRequest = $fundrequestsTable->newEmptyEntity();

            $fundRequest->user_id = $this->user->id;

            $fundRequest->btc_address_id = $bitcoin->id;

            $fundRequest->company_btc_address = $bitcoin->address;

            $fundRequest->transaction_id =
                $this->request->getData()["Fundrequest"]["transaction_id"];

            $fundRequest->btc_value =
                $this->request->getData()["Fundrequest"]["btc_value"];

            $fundRequest->self_btc_address =
                $this->request->getData()["Fundrequest"]["self_btc_address"];

            $fundRequest->remark = nl2br(
                $this->request->getData()["Fundrequest"]["remark"]
            );

            $fundRequest->status = 0;

            if ($fundrequestsTable->save($fundRequest)) {
                $this->Flash->success(
                    __("Fund has been requested successfully.")
                );

                return $this->redirect($this->home_url.'/my-account/fund_request');
            }
        }
    }

    public function upgradeUser()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Manage Users : Upgrade User";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $packagesTable = TableRegistry::get("Packages");

        $upgradesTable = TableRegistry::get("Upgrades");

        $downlinesTable = TableRegistry::get("Downlines");

        $commissionsTable = TableRegistry::get("Commissions");

        $payoutsTable = TableRegistry::get("Payouts");

        $walletsTable = TableRegistry::get("Wallets");

        $conditions = [
            "Downlines.user_id" => $this->user->id,

            "Users.status NOT IN (2)",
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $downlines = $downlinesTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.username",
                    "Users.status",
                    "Sponsers.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("downlines", $downlines);

        $packages = $packagesTable
            ->find("all", ["conditions" => ["Packages.status" => 1]])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("packages", $packages);

        /*$getBTCDetails = $upgradesTable->getCryptoCurrencyDetails('btc', 'usd');







        if($getBTCDetails == 0){



            echo 'Crypto Currecy API is not working.';



        }*/

        $query = $walletsTable->find();

        $totalWalletAmount = $query
            ->select(["sum" => $query->func()->sum("Wallets.amount")])
            ->where(["Wallets.user_id" => $this->user->id])
            ->toArray();

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());exit;

            if (
                !empty($this->request->getData()["Upgrade"]["package_id"]) &&
                $this->request->getData()["Upgrade"]["upgraded_id"]
            ) {
                $package = $packagesTable
                    ->find("all", [
                        "conditions" => [
                            "Packages.id" =>
                                $this->request->getData()["Upgrade"]["package_id"],
                        ],
                    ])
                    ->enableAutoFields(true)
                    ->first();

                $user_id = $this->user->id;

                $upgraded_id = $this->request->getData()["Upgrade"]["upgraded_id"];

                $conditions = [
                    "Upgrades.upgraded_id" => $upgraded_id,
                ];

                $order = [
                    "Upgrades.id" => "DESC",
                ];

                $fields = [
                    "Upgrades.id",
                    "Upgrades.package_amount",
                    "Upgrades.package_bv",
                    "Upgrades.business_point",
                ];

                $upgradeInfo = $upgradesTable
                    ->find("all", [
                        "fields" => $fields,
                        "conditions" => $conditions,
                        "order" => $order,
                    ])

                    ->select([
                        "upgraded_count" =>
                            "(SELECT COUNT(u.id) FROM upgrades u WHERE u.upgraded_id = Upgrades.upgraded_id)",

                        "total_bv" =>
                            "(SELECT SUM(u.package_bv) FROM upgrades u WHERE u.upgraded_id = Upgrades.upgraded_id)",
                    ])

                    ->first();

                if (empty($package)) {
                    $this->Flash->error(
                        __(
                            "Sorry! selected user has not been upgraded because invalid package is seleted."
                        )
                    );
                } elseif (
                    !empty($upgradeInfo) &&
                    $upgradeInfo->upgraded_count > 2
                ) {
                    $this->Flash->error(
                        __(
                            "Sorry! selected user can not be upgraded because user has already upgraded 3 times."
                        )
                    );
                } elseif (
                    !empty($upgradeInfo) &&
                    $package->package_amount <= $upgradeInfo->package_amount
                ) {
                    $this->Flash->error(
                        __(
                            "Sorry! selected user has not been upgraded because package amount should be more than " .
                                $upgradeInfo->package_amount .
                                "."
                        )
                    );
                } else {
                    $query = $walletsTable->find();

                    $totalWalletAmount = $query
                        ->select([
                            "sum" => $query->func()->sum("Wallets.amount"),
                        ])
                        ->where(["Wallets.user_id" => $this->user->id])
                        ->toArray();

                    $totalWalletCash = !empty($totalWalletAmount[0]->sum)
                        ? $totalWalletAmount[0]->sum
                        : 0;

                    $query = $upgradesTable->find();

                    $totalUpgradesAmount = $query
                        ->select([
                            "sum" => $query
                                ->func()
                                ->sum("Upgrades.package_amount"),
                        ])
                        ->where(["Upgrades.upgraded_by" => $this->user->id])
                        ->toArray();

                    $totalUpgradesCash = !empty($totalUpgradesAmount[0]->sum)
                        ? $totalUpgradesAmount[0]->sum
                        : 0;

                    $remainingAmount = $totalWalletCash - $totalUpgradesCash;

                    if ($remainingAmount > $package->package_amount) {
                        $package_bv = $package->package_bv;

                        if (
                            !empty($upgradeInfo) &&
                            $upgradeInfo->upgraded_count > 0
                        ) {
                            $package_bv = $package_bv - $upgradeInfo->total_bv;
                        }

                        $upgrade = $upgradesTable->newEmptyEntity();

                        $upgrade->upgraded_by = $user_id;

                        $upgrade->upgraded_id = $upgraded_id;

                        $upgrade->package_id = $package->id;

                        $upgrade->package_amount = $package->package_amount;

                        $upgrade->package_bv = $package_bv;

                        if (
                            !empty($upgradeInfo) &&
                            $upgradeInfo->upgraded_count > 0
                        ) {
                            $upgrade->business_point = 0;
                        } else {
                            $upgrade->business_point = $package->business_point;
                        }

                        $upgrade->roi_amount = $package->roi_amount;

                        $upgrade->expiry_date = date(
                            "Y-m-d",
                            strtotime(" +8 months")
                        );

                        $upgrade->status = 0;

                        if ($upgradesTable->save($upgrade)) {
                            if (
                                !empty($upgradeInfo) &&
                                $upgradeInfo->upgraded_count > 0
                            ) {
                                $upgradesTable->updateAll(
                                    [
                                        "business_point" => 0,
                                        "modified" => date("Y-m-d H:i:s"),
                                    ],
                                    ["Upgrades.upgraded_id" => $upgraded_id]
                                );
                            }

                            $upgrade_table_id = $upgrade->id;

                            $userInfo = $usersTable->get($upgraded_id);

                            $userInfo->status = 1;

                            if ($usersTable->save($userInfo)) {
                                $conditions = ["Users.id" => $upgraded_id];

                                $join = [
                                    [
                                        "table" => "details",

                                        "alias" => "Details",

                                        "type" => "INNER",

                                        "conditions" => [
                                            "Details.user_id = Users.id",
                                        ],
                                    ],
                                ];

                                $fields = [
                                    "Details.id",
                                    "Details.first_name",
                                    "Details.middle_name",
                                    "Details.last_name",
                                    "Details.contact_no",
                                ];

                                $userData = $usersTable
                                    ->find("all", [
                                        "fields" => $fields,
                                        "conditions" => $conditions,
                                        "join" => $join,
                                    ])
                                    ->enableAutoFields(true)
                                    ->first();

                                $usersTable->updateParentsOnUpgrade(
                                    $upgraded_id,
                                    $userData->parent_id,
                                    $package_bv
                                );

                                //$usersTable->updateAchievedRewards($upgraded_id);

                                if (
                                    $userData->sponsor_id > 0 &&
                                    !empty($userData->sponsor_id) &&
                                    isset($userData->sponsor_id)
                                ) {
                                    $sponsorInfo = $usersTable
                                        ->find("all", [
                                            "conditions" => [
                                                "Users.id" =>
                                                    $userData->sponsor_id,
                                            ],
                                        ])
                                        ->enableAutoFields(true)
                                        ->first();

                                    if (empty($sponsorInfo)) {
                                        echo "Sponsor not found";

                                        exit();
                                    }

                                    $sponsor = $usersTable->get(
                                        $userData->sponsor_id
                                    );

                                    if ($userData->position == "left") {
                                        $sponsor->total_direct_acitve_left =
                                            $sponsorInfo->total_direct_acitve_left +
                                            $package_bv;
                                    } else {
                                        $sponsor->total_direct_acitve_right =
                                            $sponsorInfo->total_direct_acitve_right +
                                            $package_bv;
                                    }

                                    $usersTable->save($sponsor);

                                    /*$downlines = $downlinesTable->find('all', array('conditions' => array('Downlines.user_table_id' => $upgraded_id)))->enableAutoFields(true)->toArray();



                                    foreach($downlines as $downline){



                                        $downlineInfo = $downlinesTable->get($downline->id);



                                        $downlineInfo->total_join = $downline->total_join + $package->package_bv;



                                        //$downlineInfo->business_point = $downline->business_point + $package->business_point;



                                        $downlineInfo->modified = date("Y-m-d H:i:s");



                                        $downlinesTable->save($downlineInfo);



                                    }*/

                                    //Update mobile club flag(is_mobile_club) Start Here

                                    $sponsorId = $userData->sponsor_id;

                                    $conditions = [
                                        "Downlines.sponsor_id" => $sponsorId,

                                        "Downlines.position",
                                    ];

                                    $checkLeftRightDirect = $downlinesTable
                                        ->find("all", [
                                            "conditions" => $conditions,
                                        ])

                                        ->select([
                                            "total_direct_active_left" =>
                                                '(SELECT IF(COUNT(tDAL.id)>2, 2, COUNT(tDAL.id)) FROM downlines tDAL WHERE tDAL.sponsor_id = "' .
                                                $sponsorId .
                                                '" AND tDAL.position = "left")',

                                            "total_direct_active_right" =>
                                                '(SELECT IF(COUNT(tDAR.id)>2, 2, COUNT(tDAR.id)) FROM downlines tDAR WHERE tDAR.sponsor_id = "' .
                                                $sponsorId .
                                                '" AND tDAR.position = "right")',
                                        ])
                                        ->first();

                                    if (!empty($checkLeftRightDirect)) {
                                        $totalLeftRightActiveDirect =
                                            $checkLeftRightDirect->total_direct_active_left +
                                            $checkLeftRightDirect->total_direct_active_right;

                                        if ($totalLeftRightActiveDirect >= 3) {
                                            $userSaveData = $usersTable->get(
                                                $userData->sponsor_id
                                            );

                                            $userSaveData->is_mobile_club = 1;

                                            $usersTable->save($userSaveData);
                                        }
                                    }

                                    //Update mobile club flag(is_mobile_club) End Here

                                    //Update laptop club flag(is_laptop_club) Start Here

                                    $UserId = $userData->sponsor_id;

                                    $countOnly = 1;

                                    $clubType = "mobile";

                                    $downlinePosition = "left";

                                    $leftDownlineMobileClub = $downlinesTable->getDownlineUsersById(
                                        $UserId,
                                        $downlinePosition,
                                        $countOnly,
                                        $clubType
                                    );

                                    if ($leftDownlineMobileClub > 5) {
                                        $leftDownlineMobileClub = 5;
                                    }

                                    $downlinePosition = "right";

                                    $rightDownlineMobileClub = $downlinesTable->getDownlineUsersById(
                                        $UserId,
                                        $downlinePosition,
                                        $countOnly,
                                        $clubType
                                    );

                                    if ($rightDownlineMobileClub > 5) {
                                        $rightDownlineMobileClub = 5;
                                    }

                                    $totalLeftRightMobileClub =
                                        $leftDownlineMobileClub +
                                        $rightDownlineMobileClub;

                                    if ($totalLeftRightMobileClub >= 9) {
                                        $userSaveData = $usersTable->get(
                                            $userData->sponsor_id
                                        );

                                        $userSaveData->is_laptop_club = 1;

                                        $usersTable->save($userSaveData);
                                    }

                                    //Update laptop club flag(is_laptop_club) End Here

                                    //Update bike club flag(is_bike_club) Start Here

                                    $UserId = $userData->sponsor_id;

                                    $countOnly = 1;

                                    $clubType = "laptop";

                                    $downlinePosition = "left";

                                    $leftDownlineLaptopClub = $downlinesTable->getDownlineUsersById(
                                        $UserId,
                                        $downlinePosition,
                                        $countOnly,
                                        $clubType
                                    );

                                    if ($leftDownlineLaptopClub > 6) {
                                        $leftDownlineLaptopClub = 6;
                                    }

                                    $downlinePosition = "right";

                                    $rightDownlineLaptopClub = $downlinesTable->getDownlineUsersById(
                                        $UserId,
                                        $downlinePosition,
                                        $countOnly,
                                        $clubType
                                    );

                                    if ($rightDownlineLaptopClub > 6) {
                                        $rightDownlineLaptopClub = 6;
                                    }

                                    $totalLeftRightLaptopClub =
                                        $leftDownlineLaptopClub +
                                        $rightDownlineLaptopClub;

                                    if ($totalLeftRightMobileClub >= 11) {
                                        $userSaveData = $usersTable->get(
                                            $userData->sponsor_id
                                        );

                                        $userSaveData->is_bike_club = 1;

                                        $usersTable->save($userSaveData);
                                    }

                                    //Update bike club flag(is_bike_club) End Here

                                    $commission = $commissionsTable
                                        ->find("all", [
                                            "conditions" => [
                                                "Commissions.status" => 1,
                                            ],
                                        ])
                                        ->enableAutoFields(true)
                                        ->first();

                                    $checkUserLabelUp = $usersTable->checkUserLabelUp(
                                        $userData->sponsor_id,
                                        $package->booster_time
                                    );

                                    $checkUserLabel = explode(
                                        "_^_",
                                        $checkUserLabelUp
                                    );

                                    $direct_amount = $package->direct_amount;

                                    if ($checkUserLabel[0] > 0) {
                                        $direct_amount =
                                            $package->booster_amount;

                                        $totalRemainingDirectAmount = 0;

                                        if ($checkUserLabel[1] == 1) {
                                            $conditions = [
                                                "Users.sponsor_id" =>
                                                    $userData->sponsor_id,

                                                "Users.id !=" => $userData->id,
                                            ];

                                            $join = [
                                                [
                                                    "table" => "upgrades",

                                                    "alias" => "Upgrades",

                                                    "type" => "INNER",

                                                    "conditions" => [
                                                        "Upgrades.upgraded_id = Users.id",
                                                    ],
                                                ],
                                            ];

                                            $group = ["Users.id"];

                                            $fields = [
                                                "Users.id",
                                                "Upgrades.id",
                                                "Upgrades.upgraded_id",
                                                "Upgrades.package_id",
                                            ];

                                            $upgradedInfos = $usersTable

                                                ->find("all", [
                                                    "fields" => $fields,
                                                    "join" => $join,
                                                    "conditions" => $conditions,
                                                    "group" => $group,
                                                ])

                                                ->select([
                                                    "booster_amount" =>
                                                        "(SELECT p.booster_amount FROM packages p WHERE p.id = Upgrades.package_id)",
                                                ])

                                                ->toArray();

                                            $totalBoosterAmount = 0;

                                            foreach (
                                                $upgradedInfos
                                                as $upgradedInfo
                                            ) {
                                                $totalBoosterAmount =
                                                    $totalBoosterAmount +
                                                    $upgradedInfo->booster_amount;
                                            }

                                            $conditions = [
                                                "Payouts.upagraded_user_id" =>
                                                    $userData->sponsor_id,
                                            ];

                                            $fields = [
                                                "Payouts.upagraded_user_id",
                                            ];

                                            $totalDirectAmount = $payoutsTable

                                                ->find("all", [
                                                    "fields" => $fields,
                                                    "conditions" => $conditions,
                                                ])

                                                ->select([
                                                    "total_direct_amount" =>
                                                        "SUM(Payouts.direct_amount)",
                                                ])

                                                ->first();

                                            $totalRemainingDirectAmount =
                                                $totalBoosterAmount -
                                                $totalDirectAmount->total_direct_amount;
                                        }

                                        $direct_amount =
                                            $direct_amount +
                                            $totalRemainingDirectAmount;
                                    }

                                    if (empty($upgradeInfo)) {
                                        $payout = $payoutsTable->newEmptyEntity();

                                        $payout->upgraded_table_id = $upgrade_table_id;

                                        //$payout->upagraded_user_id  = $upgraded_id;

                                        $payout->upagraded_user_id =
                                            $userData->sponsor_id;

                                        $payout->direct_amount = $direct_amount;

                                        $payout->matching_amount = 0;

                                        $payout->royalty_amount = 0;

                                        $payout->roi = 0;

                                        $payout->tax = isset($commission->tax)
                                            ? $commission->tax
                                            : 0;

                                        $payout->admin_commission = isset(
                                            $commission->amount
                                        )
                                            ? $commission->amount
                                            : 0;

                                        $payoutsTable->save($payout);
                                    }

                                    $template =
                                        "Dear " .
                                        $userData->Details["first_name"] .
                                        " " .
                                        $userData->Details["last_name"] .
                                        "(" .
                                        $userData->username .
                                        "), Your account has TOPUP with " .
                                        $package->name .
                                        ". For help, please visit Jsksinfratech.com";

                                    $sendSMS = $usersTable->sendSMS(
                                        $template,
                                        $userData->Details["contact_no"]
                                    );
                                }

                                $this->Flash->success(
                                    __("User has been upgraded successfully.")
                                );

                                return $this->redirect($this->home_url.'/my-account/manage-users/upgrade-history');
                            }
                        }
                    } else {
                        $this->Flash->error(
                            __(
                                "Selected user can not be upgraded because insufficient fund in your wallet."
                            )
                        );
                    }
                }
            }
        }
    }

    public function upgradeHistory()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Manage Users : Upgrade History";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $upgradesTable = TableRegistry::get("Upgrades");

        $conditions = [
            'upgraded_by = "' .
            $this->user->id .
            '" OR upgraded_id = "' .
            $this->user->id .
            '"',
        ];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Upgrades.upgraded_id"],
            ],

            [
                "table" => "details",

                "alias" => "UserDetails",

                "type" => "INNER",

                "conditions" => ["UserDetails.user_id = Upgrades.upgraded_id"],
            ],

            [
                "table" => "users",

                "alias" => "Upgrader",

                "type" => "INNER",

                "conditions" => ["Upgrader.id = Upgrades.upgraded_by"],
            ],

            [
                "table" => "details",

                "alias" => "UpgraderDetails",

                "type" => "INNER",

                "conditions" => [
                    "UpgraderDetails.user_id = Upgrades.upgraded_by",
                ],
            ],

            [
                "table" => "packages",

                "alias" => "Packages",

                "type" => "INNER",

                "conditions" => ["Packages.id = Upgrades.package_id"],
            ],

            [
                "table" => "plot_payments",

                "alias" => "PlotPayments",

                "type" => "LEFT",

                "conditions" => [
                    "PlotPayments.user_id = Upgrades.upgraded_id AND PlotPayments.number_of_unit > 0",
                ],
            ],
        ];

        $order = [
            "Upgrades.id" => "DESC",
        ];

        $fields = [
            "Users.id",
            "Users.username",
            "Upgrader.username",
            "Upgrader.username",
            "Packages.name",
            "Packages.package_amount",
            "UserDetails.id",
            "UserDetails.first_name",
            "UserDetails.middle_name",
            "UserDetails.last_name",
            "UpgraderDetails.first_name",
            "UpgraderDetails.middle_name",
            "UpgraderDetails.last_name",
            "PlotPayments.id",
            "PlotPayments.number_of_unit",
        ];

        $upgrades = $upgradesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("upgrades", $upgrades);
    }

    public function registeredUsers()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Manage Users : Registered Users";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_id" => $this->user->id,

            "Users.status !=" => 2,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],

            [
                "table" => "epins",

                "alias" => "Epins",

                "type" => "LEFT",

                "conditions" => ["Epins.id = Users.epin_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $downlines = $downlinesTable
            ->find("all", [
                "fields" => [
                    "Users.id",
                    "Users.username",
                    "Users.rank",
                    "Users.total_active_left",
                    "Users.total_active_right",
                    "Users.status",
                    "Sponsers.username",
                    "Details.id",
                    "Details.first_name",
                    "Details.middle_name",
                    "Details.last_name",
                    "Epins.id",
                    "Epins.epin",
                ],
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("downlines", $downlines);
    }

    public function closingDetails()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Payouts : Closing Details";

        $this->set("title", $title);

        $paymentsTable = TableRegistry::get("Payments");

        $closingCount =
            isset($_GET["closing_count"]) &&
            !empty($_GET["closing_count"]) &&
            is_numeric($_GET["closing_count"])
                ? trim($_GET["closing_count"])
                : "";

        $this->set("closing_count", $closingCount);

        $conditions = [
            "Payments.requested_amount" => 0,

            "Payments.user_id" => $this->user->id,
        ];

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Payments.user_id"],
            ],

            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $order = [
            "Payments.closing_count" => "ASC",
        ];

        $fields = [
            "Users.id",
            "Users.username",
            "Details.first_name",
            "Details.last_name",
            "Details.pan_number",
        ];

        $payments = $paymentsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "order" => $order,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("payments", $payments);

        $fields = ["Payments.closing_count"];

        $group = ["Payments.closing_count"];

        $order = ["Payments.closing_count" => "ASC"];

        $closingCounts = $paymentsTable
            ->find("all", [
                "fields" => $fields,
                "group" => $group,
                "order" => $order,
            ])
            ->toArray();

        $this->set("closingCounts", $closingCounts);
    }

    public function payoutRequest()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Payouts : Payout Request";

        $this->set("title", $title);

        $paymentsTable = TableRegistry::get("Payments");

        $conditions = [
            "Payments.user_id" => $this->user->id,

            "Payments.requested_amount >" => 0,
        ];

        $order = ["Payments.id" => "DESC"];

        $payments = $paymentsTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("payments", $payments);
    }

    public function requestPayout()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Payouts : Request Payout";

        $this->set("title", $title);

        $paymentsTable = TableRegistry::get("Payments");

        $conn = ConnectionManager::get("default");

        $payments = $conn->execute(
            "SELECT 



            (SELECT SUM(nAmt.net_amount) FROM payments AS nAmt WHERE nAmt.user_id = Payments.user_id) AS net_amount,







            (SELECT SUM(pAmt.requested_amount) FROM payments AS pAmt WHERE pAmt.user_id = Payments.user_id AND status=1) AS paid_amount,







            (SELECT SUM(rAmt.requested_amount) FROM payments AS rAmt WHERE rAmt.user_id = Payments.user_id AND status=0) AS requested_amount,







            (SELECT SUM(wAmt.requested_amount) FROM payments AS wAmt WHERE wAmt.user_id = Payments.user_id) AS withdraw_amount







            FROM payments as Payments



            WHERE Payments.user_id = '" .
                $this->user->id .
                "'"
        );

        $payments = $payments->fetchAll("assoc");

        $this->set("payments", $payments);

        if ($this->request->is("post")) {
            /* echo '<pre>';



            print_r($this->request->getData());



            print_r($payments);



            exit;*/

            if (
                isset($this->request->getData()["Payment"]["requested_amount"]) &&
                !empty($this->request->getData()["Payment"]["requested_amount"])
            ) {
                if ($this->request->getData()["Payment"]["requested_amount"] >= 10) {
                    $availbaleBalance = 0;

                    if (isset($payments) && !empty($payments)) {
                        $availbaleBalance =
                            $payments[0]["net_amount"] -
                            $payments[0]["withdraw_amount"];
                    }

                    if (
                        $this->request->getData()["Payment"]["requested_amount"] <=
                        $availbaleBalance
                    ) {
                        $payment = $paymentsTable->newEmptyEntity();

                        $payment->user_id = $this->user->id;

                        $payment->btc_address =
                            $this->user->Details["pan_number"];

                        $payment->requested_amount =
                            $this->request->getData()["Payment"]["requested_amount"];

                        $payment->remark = nl2br(
                            $this->request->getData()["Payment"]["remark"]
                        );

                        $paymentsTable->save($payment);

                        $this->Flash->success(
                            __(
                                "Available payout amount has been requested successfully."
                            )
                        );

                        return $this->redirect($this->home_url.'/my-account/payouts/payout-request');
                    } else {
                        $this->Flash->error(
                            __(
                                "Requested amount should not be more than available amount."
                            )
                        );
                    }
                } else {
                    $this->Flash->error(
                        __('Requested amount should be atleast $ 10.00.')
                    );
                }
            } else {
                $this->Flash->error(__("Please enter requested amount."));
            }
        }
    }

    public function ads()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Ads";

        $this->set("title", $title);

        $linksTable = TableRegistry::get("Links");

        $upgradesTable = TableRegistry::get("Upgrades");

        $join = [
            [
                "table" => "packages",

                "alias" => "Packages",

                "type" => "INNER",

                "conditions" => ["Packages.id = Upgrades.package_id"],
            ],
        ];

        $conditions = [
            "Upgrades.upgraded_id" => $this->user->id,

            "Upgrades.expiry_date >=" => date("Y-m-d"),
        ];

        $fields = ["Packages.id", "Packages.allowed_links"];

        $query = $upgradesTable->find("all", [
            "fields" => $fields,
            "conditions" => $conditions,
            "join" => $join,
        ]);

        $getLimit = $query
            ->select(["sum" => $query->func()->sum("Packages.allowed_links")])
            ->first();

        $conditions = [
            "Links.status" => 1,

            'Links.id NOT IN(SELECT link_id FROM payouts WHERE upagraded_user_id = "' .
            $this->user->id .
            '" AND roi_date = "' .
            date("Y-m-d") .
            '")',
        ];

        $order = ["RAND()"];

        $group = "Links.id";

        $limit = !empty($getLimit->sum) ? $getLimit->sum : 0;

        $links = $linksTable
            ->find("all", [
                "conditions" => $conditions,
                "order" => $order,
                "group" => $group,
                "limit" => $limit,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("links", $links);
    }

    public function viewAd($linkId)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Ad Detail";

        $this->set("title", $title);

        $linksTable = TableRegistry::get("Links");

        $payoutsTable = TableRegistry::get("Payouts");

        $upgradesTable = TableRegistry::get("Upgrades");

        $conditions = [
            "Payouts.upagraded_user_id" => $this->user->id,

            "Payouts.roi_date" => date("Y-m-d"),

            "md5(Payouts.link_id)" => $linkId,
        ];

        $checkRoi = $payoutsTable
            ->find("all", ["conditions" => $conditions])
            ->count();

        if ($checkRoi > 0) {
            return $this->redirect($this->home_url.'/my-account/ads');
        }

        $conditions = [
            "md5(Links.id)" => $linkId,

            "Links.status" => 1,
        ];

        $link = $linksTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->first();

        if (empty($link)) {
            return $this->redirect($this->home_url.'/my-account/ads');
        }

        $this->set("link", $link);

        if ($this->request->is("post")) {
            //echo '<pre>';

            //print_r($this->request->getData());

            //exit;

            if (md5($this->request->getData()["Payouts"]["link_id"]) != $linkId) {
                return $this->redirect($this->home_url.'/my-account/ads');
            }

            $query = $upgradesTable->find();

            $upgrade = $query
                ->select(["sum" => $query->func()->sum("roi_amount")])
                ->where([
                    "Upgrades.upgraded_id" => $this->user->id,
                    "Upgrades.expiry_date >=" => date("Y-m-d"),
                ])
                ->first();

            if (isset($upgrade->sum) && !empty($upgrade->sum)) {
                $roiInDollar = $upgrade->sum;

                $payout = $payoutsTable->newEmptyEntity();

                $payout->upagraded_user_id = $this->user->id;

                $payout->roi = $roiInDollar;

                $payout->roi_date = date("Y-m-d");

                $payout->link_id = $this->request->getData()["Payouts"]["link_id"];

                $payoutsTable->save($payout);
            }

            $this->Flash->success(
                __("Your ROI has beed added successfully for submitted ad.")
            );

            return $this->redirect($this->home_url.'/my-account/ads');
        }
    }

    public function roiDetails()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " PPI Details";

        $this->set("title", $title);

        $payoutsTable = TableRegistry::get("Payouts");

        $rois = $payoutsTable
            ->find("all", [
                "conditions" => [
                    "Payouts.upagraded_user_id" => $this->user->id,
                    "Payouts.roi >" => 0,
                ],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("rois", $rois);
    }

    public function referralLink()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . "  Referral Link";

        $this->set("title", $title);
    }

    public function buinessPlan()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Bussiness Plan";

        $this->set("title", $title);
    }

    public function checkout()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Checkout";

        $this->set("title", $title);

        $cartsTable = TableRegistry::get("Carts");

        $ordereditemsTable = TableRegistry::get("Ordereditems");

        $ordersTable = TableRegistry::get("Orders");

        $walletsTable = TableRegistry::get("Wallets");

        $upgradesTable = TableRegistry::get("Upgrades");

        $productsTable = TableRegistry::get("Products");

        $join = [
            [
                "table" => "products",

                "alias" => "Products",

                "type" => "INNER",

                "conditions" => ["Products.id = Carts.product_id"],
            ],
        ];

        $conditions = [
            "Carts.user_id" => $this->user->id,
        ];

        $fields = [
            "Products.id",
            "Products.name",
            "Products.price",
            "Products.discount",
            "Products.discount_price",
            "Products.business_volume",
            "Products.business_point",
            "Products.quantity",
        ];

        $carts = $cartsTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("carts", $carts);

        /*echo '<pre>';

        print_r($carts);exit;*/

        if ($this->request->is("post")) {
            /* echo '<pre>';

            print_r($this->request->getData());*/

            //exit;

            if (
                isset($this->request->getData()["Order"]["first_name"]) &&
                !empty($this->request->getData()["Order"]["first_name"]) &&
                (isset($this->request->getData()["Order"]["last_name"]) &&
                    !empty($this->request->getData()["Order"]["last_name"])) &&
                (isset($this->request->getData()["Order"]["contact_no"]) &&
                    !empty($this->request->getData()["Order"]["contact_no"])) &&
                (isset($this->request->getData()["Order"]["email"]) &&
                    !empty($this->request->getData()["Order"]["email"])) &&
                (isset($this->request->getData()["Order"]["delivery_address"]) &&
                    !empty($this->request->getData()["Order"]["delivery_address"]))
            ) {
                $query = $walletsTable->find();

                $totalWalletAmount = $query
                    ->select(["sum" => $query->func()->sum("Wallets.amount")])
                    ->where(["Wallets.user_id" => $this->user->id])
                    ->first();

                $walletAmount =
                    isset($totalWalletAmount->sum) &&
                    !empty($totalWalletAmount->sum)
                        ? $totalWalletAmount->sum
                        : 0;

                $fields = ["Upgrades.package_amount"];

                $conditions = ["Upgrades.upgraded_id" => $this->user->id];

                $order = ["Upgrades.id" => "DESC"];

                $upgrade = $upgradesTable
                    ->find("all", [
                        "fields" => $fields,
                        "conditions" => $conditions,
                        "order" => $order,
                    ])
                    ->first();

                $upgradePackageAmount =
                    isset($upgrade->package_amount) &&
                    !empty($upgrade->package_amount)
                        ? $upgrade->package_amount
                        : 0;

                $walletAmount = $walletAmount + $upgradePackageAmount;

                $grandTotal = 0;

                foreach ($carts as $cart) {
                    $price = $cart->Products["price"];

                    if (
                        !empty($cart->Products["discount_price"]) &&
                        $cart->Products["discount_price"] > 0
                    ) {
                        $price = $cart->Products["discount_price"];
                    }

                    $total = $cart->quantity * $price;

                    $grandTotal = $grandTotal + $total;
                }

                if ($walletAmount < $grandTotal) {
                    $this->Flash->error(
                        __(
                            "Sorry! Product can not be bought because of insufficient fund."
                        )
                    );
                } else {
                    $orderId = $ordersTable->getUniqueOrderId();

                    $orderData = $ordersTable->newEmptyEntity();

                    $orderData->user_id = $this->user->id;

                    $orderData->order_id = $orderId;

                    $orderData->first_name = isset(
                        $this->request->getData()["Order"]["first_name"]
                    )
                        ? $this->request->getData()["Order"]["first_name"]
                        : null;

                    $orderData->last_name = isset(
                        $this->request->getData()["Order"]["last_name"]
                    )
                        ? $this->request->getData()["Order"]["last_name"]
                        : null;

                    $orderData->contact_no = isset(
                        $this->request->getData()["Order"]["contact_no"]
                    )
                        ? $this->request->getData()["Order"]["contact_no"]
                        : null;

                    $orderData->email = isset(
                        $this->request->getData()["Order"]["email"]
                    )
                        ? $this->request->getData()["Order"]["email"]
                        : null;

                    $orderData->delivery_address = isset(
                        $this->request->getData()["Order"]["delivery_address"]
                    )
                        ? $this->request->getData()["Order"]["delivery_address"]
                        : null;

                    $orderData->grand_total = $grandTotal;

                    $orderData->status = 1;

                    if ($ordersTable->save($orderData)) {
                        $orderIntId = $orderData->id;

                        foreach ($carts as $cart) {
                            $price = $cart->Products["price"];

                            if (
                                !empty($cart->Products["discount_price"]) &&
                                $cart->Products["discount_price"] > 0
                            ) {
                                $price = $cart->Products["discount_price"];
                            }

                            $orderedItem = $ordereditemsTable->newEmptyEntity();

                            $orderedItem->order_id = $orderIntId;

                            $orderedItem->product_id = $cart->product_id;

                            $orderedItem->quantity = $cart->quantity;

                            $orderedItem->price = $price;

                            $orderedItem->discount =
                                $cart->Products["discount"];

                            $orderedItem->discount_price =
                                $cart->Products["discount_price"];

                            $orderedItem->total = $cart->quantity * $price;

                            $orderedItem->business_volume =
                                $cart->Products["business_volume"];

                            $orderedItem->business_point =
                                $cart->Products["business_point"];

                            $ordereditemsTable->save($orderedItem);
                        }

                        $transactionId = $walletsTable->getTransactionId(11);

                        $walletData = $walletsTable->newEmptyEntity();

                        $walletData->user_id = $this->user->id;

                        $walletData->transaction_id = $transactionId;

                        $walletData->amount = "-" . $grandTotal;

                        $walletData->remark = "Shopping";

                        $walletData->status = 1;

                        $walletsTable->save($walletData);

                        $cartsTable->deleteAll(["user_id" => $this->user->id]);
                    }

                    $this->Flash->success(
                        __(
                            "Thanks for your placing your order with us. Your ordered item will be delivered shortly."
                        )
                    );

                    return $this->redirect($this->home_url.'/my-account/myOrders');
                }
            } else {
                $this->Flash->error(__("Please fill all required fields."));
            }

            //exit;
        }
    }

    public function removeCartProduct($encCartId)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Remove Product";

        $this->set("title", $title);

        $cartsTable = TableRegistry::get("Carts");

        $intId = base64_decode($encCartId);

        $entity = $cartsTable->get($intId);

        if ($cartsTable->delete($entity)) {
            $this->Flash->success(__("Product has been removed from cart."));

            return $this->redirect($this->home_url.'/my-account/checkout');
        } else {
            $this->Flash->error(
                __(
                    "Something went wrong! Product is not removed from your cart."
                )
            );
        }

        $this->autoRender = false;
    }

    public function rewards()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Rewards";

        $this->set("title", $title);

        $rewardsTable = TableRegistry::get("Rewards");

        $join = [
            [
                "table" => "achieved_rewards",

                "alias" => "AchievedRewards",

                "type" => "LEFT",

                "conditions" => [
                    'AchievedRewards.user_id = "' .
                    $this->user->id .
                    '" AND AchievedRewards.reward_id = Rewards.id',
                ],
            ],
        ];

        $conditions = [
            "Rewards.status" => 1,
        ];

        $fields = ["AchievedRewards.id", "AchievedRewards.status"];

        $rewards = $rewardsTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("rewards", $rewards);
    }

    public function epins()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Epins";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $epinsTable = TableRegistry::get("Epins");

        $epinHistoriesTable = TableRegistry::get("EpinHistories");

        $userId = $this->user->id;

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $conditions = [
            "Users.role_id" => 2,
        ];

        $fields = [
            "Users.id",
            "Users.username",
            "Details.first_name",
            "Details.middle_name",
            "Details.last_name",
        ];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->toArray();

        $this->set("users", $users);

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "LEFT",

                "conditions" => ["Users.id = Epins.assigned_to"],
            ],

            [
                "table" => "details",

                "alias" => "AssignedToDetails",

                "type" => "LEFT",

                "conditions" => ["AssignedToDetails.user_id = Users.id"],
            ],

            [
                "table" => "users",

                "alias" => "UsedFor",

                "type" => "LEFT",

                "conditions" => ["UsedFor.epin_id = Epins.id"],
            ],

            [
                "table" => "details",

                "alias" => "UsedForDetails",

                "type" => "LEFT",

                "conditions" => ["UsedForDetails.user_id = UsedFor.id"],
            ],
        ];

        $conditions = [
            "Epins.assigned_to" => $userId,
        ];

        $order = ["Epins.id" => "DESC"];

        $fields = [
            "Users.id",
            "Users.username",
            "AssignedToDetails.id",
            "AssignedToDetails.first_name",
            "AssignedToDetails.last_name",
            "UsedFor.id",
            "UsedFor.username",
            "UsedForDetails.id",
            "UsedForDetails.first_name",
            "UsedForDetails.last_name",
        ];

        $epins = $epinsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("epins", $epins);

        if ($this->request->is("post")) {
            /* echo '<pre>';

            print_r($this->request->getData());exit;*/

            if (
                isset($this->request->getData()["Epin"]["bulk_action"]) &&
                !empty($this->request->getData()["Epin"]["bulk_action"]) &&
                isset($this->request->getData()["epinIds"]) &&
                !empty($this->request->getData()["epinIds"]) &&
                is_array($this->request->getData()["epinIds"])
            ) {
                foreach ($this->request->getData()["epinIds"] as $epinId) {
                    $checkEpinStatus = $epinsTable
                        ->find("all", [
                            "conditions" => [
                                "Epins.id" => $epinId,
                                "Epins.status" => 1,
                            ],
                        ])
                        ->count();

                    if ($checkEpinStatus > 0) {
                        $assignedTo = null;

                        if ($this->request->getData()["Epin"]["bulk_action"] == 1) {
                            $assignedTo =
                                $this->request->getData()["Epin"]["assigned_to"];
                        }

                        $epinData = $epinsTable->get($epinId);

                        $epinData->assigned_to = $assignedTo;

                        $epinsTable->save($epinData);

                        if (!empty($assignedTo)) {
                            $epinHistoryData = $epinHistoriesTable->newEmptyEntity();

                            $epinHistoryData->transferred_by = $this->user->id;

                            $epinHistoryData->transferred_to = $assignedTo;

                            $epinHistoryData->epin_id = $epinId;

                            $epinHistoriesTable->save($epinHistoryData);
                        }
                    }
                }

                if ($this->request->getData()["Epin"]["bulk_action"] == 1) {
                    $this->Flash->success(
                        __(
                            "Selected unsed epins has been assigned successfully."
                        )
                    );
                } else {
                    $this->Flash->success(
                        __(
                            "Assignment of selected unsed epins has been removed successfully."
                        )
                    );
                }
            }

            return $this->redirect($this->home_url . "/my-account/epins");
        }
    }

    public function transferredEpins()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Tranferred Epins";

        $this->set("title", $title);

        $epinHistoriesTable = TableRegistry::get("EpinHistories");

        $join = [
            [
                "table" => "users",

                "alias" => "TransferredTo",

                "type" => "INNER",

                "conditions" => [
                    "TransferredTo.id = EpinHistories.transferred_to",
                ],
            ],

            [
                "table" => "details",

                "alias" => "DetialsTo",

                "type" => "INNER",

                "conditions" => [
                    "DetialsTo.user_id = EpinHistories.transferred_to",
                ],
            ],

            [
                "table" => "epins",

                "alias" => "Epins",

                "type" => "INNER",

                "conditions" => ["Epins.id = EpinHistories.epin_id"],
            ],
        ];

        $conditions = [
            "EpinHistories.transferred_by" => $this->user->id,
        ];

        $order = ["EpinHistories.id" => "DESC"];

        $fields = [
            "TransferredTo.id",
            "TransferredTo.username",
            "DetialsTo.first_name",
            "DetialsTo.last_name",
            "Epins.id",
            "Epins.epin",
        ];

        $epinHistories = $epinHistoriesTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("epinHistories", $epinHistories);
    }

    public function addUser($encEpinId = null)
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " New Registration";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");
        $detailsTable = TableRegistry::get("Details");

        $conditions = [
            "Users.role_id" => 2,

            "Users.status" => 1,
        ];

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $order = [
            "Users.username" => "ASC",
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $join,
                "order" => $order,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $username = $usersTable->getUniqueUsername("FOB");

            $password = 12345;

            $rank = isset($this->request->getData()["User"]["rank"])
                ? trim($this->request->getData()["User"]["rank"])
                : null;

            $plot_id = isset($this->request->getData()["User"]["plot_id"])
                ? trim($this->request->getData()["User"]["plot_id"])
                : null;

            $email = isset($this->request->getData()["User"]["email"])
                ? trim($this->request->getData()["User"]["email"])
                : null;

            $sponser_username = isset(
                $this->request->getData()["User"]["sponser_username"]
            )
                ? trim($this->request->getData()["User"]["sponser_username"])
                : null;

            $position = isset($this->request->getData()["User"]["position"])
                ? trim($this->request->getData()["User"]["position"])
                : null;

            $first_name = isset($this->request->getData()["Detail"]["first_name"])
                ? trim($this->request->getData()["Detail"]["first_name"])
                : "";

            $last_name = isset($this->request->getData()["Detail"]["last_name"])
                ? trim($this->request->getData()["Detail"]["last_name"])
                : "";

            $contact_no = isset($this->request->getData()["Detail"]["contact_no"])
                ? trim($this->request->getData()["Detail"]["contact_no"])
                : "";

            $photo_attachment_id = isset(
                $this->request->getData()["Detail"]["photo_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["photo_attachment_id"][0]
                : null;

            $address_attachment_id = isset(
                $this->request->getData()["Detail"]["address_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["address_attachment_id"][0]
                : null;

            $pan_attachment_id = isset(
                $this->request->getData()["Detail"]["pan_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["pan_attachment_id"][0]
                : null;

            if (
                !empty($username) &&
                !empty($password) &&
                !empty($sponser_username) &&
                !empty($position) &&
                !empty($first_name) &&
                !empty($contact_no)
            ) {
                /*echo '<pre>';

                print_r($currentRateInfo);exit;*/

                $checkEmail = $usersTable
                    ->find("all", ["conditions" => ["Users.email" => $email]])
                    ->count();

                $checkUsername = $usersTable
                    ->find("all", [
                        "conditions" => ["Users.username" => $username],
                    ])
                    ->count();

                $checkContactNumber = $detailsTable
                    ->find("all", [
                        "conditions" => ["Details.contact_no" => $contact_no],
                    ])
                    ->count();

                $conditions = [
                    "Users.username" => $sponser_username,
                ];

                $joins = [
                    [
                        "table" => "details",

                        "alias" => "Details",

                        "type" => "INNER",

                        "conditions" => ["Details.user_id = Users.id"],
                    ],
                ];

                $sponserInfo = $usersTable
                    ->find("all", [
                        "fields" => [
                            "Details.id",
                            "Details.first_name",
                            "Details.middle_name",
                            "Details.last_name",
                        ],
                        "conditions" => $conditions,
                        "join" => $joins,
                    ])
                    ->enableAutoFields(true)
                    ->first();

                if ($checkEmail >= 7) {
                    $this->Flash->error(
                        __(
                            "Entered email id already used 7 times by our registered user. So Please resgister with different email id."
                        )
                    );
                } elseif ($checkUsername > 0) {
                    $this->Flash->error(
                        __(
                            "Entered username already used by our registered user. Please register with different username"
                        )
                    );
                }
                /*elseif($checkContactNumber >= 7){

                   $this->Flash->error(__('Entered contact number already used 7 times by our registered user. Please resgister with different contact number'));

                }*/ elseif (
                    empty($sponserInfo)
                ) {
                    $this->Flash->error(
                        __(
                            "Entered referral id does not exist in our database. Please resgister with different referral id."
                        )
                    );
                }
                /*elseif(empty($upgrades)){

                    $this->Flash->error(__('Entered referral id is not upgraded. Please resgister with different referral id.'));

                }*/ elseif (isset($epinInfo->status) && $epinInfo->status == 2) {
                    $this->Flash->error(__("Entered Epin is already used."));
                } elseif ($rank > $this->user->rank) {
                    $this->Flash->error(
                        __(
                            "Rank should be less than or equal to " .
                                $this->user->rank
                        )
                    );
                } else {
                    $getLastUserInfo = json_decode(
                        $usersTable->getLastUserInfo(
                            $sponserInfo->id,
                            $position
                        )
                    );

                    $user = $usersTable->newEmptyEntity();

                    $user->role_id = 2;

                    $user->parent_id = $getLastUserInfo->id;

                    $user->parent_name =
                        $getLastUserInfo->Details->first_name .
                        " " .
                        $getLastUserInfo->Details->last_name;

                    $user->sponsor_id = $sponserInfo->id;

                    $user->sponsor_name =
                        $sponserInfo->Details["first_name"] .
                        " " .
                        $sponserInfo->Details["last_name"];

                    $user->position = $position;

                    $user->email = $email;

                    $user->username = $username;

                    $user->password = md5(12345);

                    $user->transaction_password = md5($password);

                    $user->total_left = 0;

                    $user->total_right = 0;

                    $user->total_active_left = 0;

                    $user->total_active_right = 0;

                    $user->total_inactive_left = 0;

                    $user->total_inactive_right = 0;

                    $user->total_direct_left = 0;

                    $user->total_direact_right = 0;

                    $user->total_direct_acitve_left = 0;

                    $user->total_direct_acitve_right = 0;

                    $user->total_direct_inacitve_left = 0;

                    $user->total_direct_inacitve_right = 0;

                    $user->status = 1;

                    if ($usersTable->save($user)) {
                        $user_id = $user->id;

                        $detail = $detailsTable->newEmptyEntity();

                        $detail->user_id = $user_id;

                        $detail->first_name = isset(
                            $this->request->getData()["Detail"]["first_name"]
                        )
                            ? $this->request->getData()["Detail"]["first_name"]
                            : null;

                        $detail->last_name = isset(
                            $this->request->getData()["Detail"]["last_name"]
                        )
                            ? $this->request->getData()["Detail"]["last_name"]
                            : null;

                        $detail->pan_number = isset(
                            $this->request->getData()["Detail"]["pan_number"]
                        )
                            ? $this->request->getData()["Detail"]["pan_number"]
                            : null;

                        $detail->adhar_number = isset(
                            $this->request->getData()["Detail"]["adhar_number"]
                        )
                            ? $this->request->getData()["Detail"]["adhar_number"]
                            : null;

                        $detail->country_id = isset(
                            $this->request->getData()["Detail"]["country_id"]
                        )
                            ? $this->request->getData()["Detail"]["country_id"]
                            : null;

                        $detail->contact_no = isset(
                            $this->request->getData()["Detail"]["contact_no"]
                        )
                            ? $this->request->getData()["Detail"]["contact_no"]
                            : null;

                        $detail->adhar_number = isset(
                            $this->request->getData()["Detail"]["adhar_number"]
                        )
                            ? $this->request->getData()["Detail"]["adhar_number"]
                            : null;

                        $detail->pan_number = isset(
                            $this->request->getData()["Detail"]["pan_number"]
                        )
                            ? $this->request->getData()["Detail"]["pan_number"]
                            : null;

                        $detail->bank_name = isset(
                            $this->request->getData()["Detail"]["bank_name"]
                        )
                            ? $this->request->getData()["Detail"]["bank_name"]
                            : null;

                        $detail->account_number = isset(
                            $this->request->getData()["Detail"]["account_number"]
                        )
                            ? $this->request->getData()["Detail"]["account_number"]
                            : null;

                        $detail->ifsc_code = isset(
                            $this->request->getData()["Detail"]["ifsc_code"]
                        )
                            ? $this->request->getData()["Detail"]["ifsc_code"]
                            : null;

                        $detail->branch_name = isset(
                            $this->request->getData()["Detail"]["branch_name"]
                        )
                            ? $this->request->getData()["Detail"]["branch_name"]
                            : null;

                        $detail->google_pay_number = isset(
                            $this->request->getData()["Detail"]["google_pay_number"]
                        )
                            ? $this->request->getData()["Detail"][
                                "google_pay_number"
                            ]
                            : null;

                        $detail->phone_pay_number = isset(
                            $this->request->getData()["Detail"]["phone_pay_number"]
                        )
                            ? $this->request->getData()["Detail"]["phone_pay_number"]
                            : null;

                        $detail->paytm_number = isset(
                            $this->request->getData()["Detail"]["paytm_number"]
                        )
                            ? $this->request->getData()["Detail"]["paytm_number"]
                            : null;

                        $detail->is_kyc_approved = isset(
                            $this->request->getData()["Detail"]["is_kyc_approved"]
                        )
                            ? $this->request->getData()["Detail"]["is_kyc_approved"]
                            : null;

                        $detail->photo_attachment_id = $photo_attachment_id;

                        $detail->address_attachment_id = $address_attachment_id;

                        $detail->pan_attachment_id = $pan_attachment_id;

                        $detailsTable->save($detail);

                        if (!empty($photo_attachment_id)) {
                            $attachmentData = $attachmentsTable->get(
                                $photo_attachment_id
                            );

                            $attachmentData->caption = isset(
                                $this->request->getData()["Detail"][
                                    "photo_attachment_id"
                                ]["caption"][0]
                            )
                                ? $this->request->getData()["Detail"][
                                    "photo_attachment_id"
                                ]["caption"][0]
                                : null;

                            $attachmentsTable->save($attachmentData);
                        }

                        if (!empty($address_attachment_id)) {
                            $attachmentData = $attachmentsTable->get(
                                $address_attachment_id
                            );

                            $attachmentData->caption = isset(
                                $this->request->getData()["Detail"][
                                    "address_attachment_id"
                                ]["caption"][0]
                            )
                                ? $this->request->getData()["Detail"][
                                    "address_attachment_id"
                                ]["caption"][0]
                                : null;

                            $attachmentsTable->save($attachmentData);
                        }

                        if (!empty($pan_attachment_id)) {
                            $attachmentData = $attachmentsTable->get(
                                $pan_attachment_id
                            );

                            $attachmentData->caption = isset(
                                $this->request->getData()["Detail"][
                                    "pan_attachment_id"
                                ]["caption"][0]
                            )
                                ? $this->request->getData()["Detail"][
                                    "pan_attachment_id"
                                ]["caption"][0]
                                : null;

                            $attachmentsTable->save($attachmentData);
                        }

                        $parent = $usersTable->get($getLastUserInfo->id);

                        if ($position == "left") {
                            $parent->left_user = $user_id;
                        } else {
                            $parent->right_user = $user_id;
                        }

                        $usersTable->save($parent);

                        $updateParents = $usersTable->updateParents(
                            $user_id,
                            $getLastUserInfo->id,
                            $position,
                            $user_id,
                            0,
                            $getLastUserInfo->id,
                            $sponserInfo->id
                        );

                        $sponsor = $usersTable->get($sponserInfo->id);

                        if ($position == "left") {
                            $sponsor->total_direct_left =
                                $sponserInfo->total_direct_left + 1;

                            $sponsor->total_direct_inacitve_left =
                                $sponserInfo->total_direct_inacitve_left + 1;
                        } else {
                            $sponsor->total_direact_right =
                                $sponserInfo->total_direact_right + 1;

                            $sponsor->total_direct_inacitve_right =
                                $sponserInfo->total_direct_inacitve_right + 1;
                        }

                        $usersTable->save($sponsor);

                        /* $Email = new Email();

                        $fromemail = $this->setting->sender_email;

                        $to_email = $email;

                        $Email->template('registration', 'emaillayout')

                              ->viewVars(array("user" => $this->request->getData()))

                              ->emailFormat('html')

                              ->to($to_email)

                              ->from(array($fromemail => 'Admire Global'))

                              ->subject('Dear '.$this->request->getData()['Detail']['first_name'].' '.$this->request->getData()['Detail']['last_name'].' ! You have successfully registered on admireglobal.io.')

                              ->send();*/

                        /*$template = "Welcome to Octiq Marketing, Thanks for joining us. Your login is: Username = ".$username." Password = ".$password." For more info, please visit www.octiqmarketing.com";

                        $sendSMS = $usersTable->sendSMS($template, $contact_no); */

                        $template =
                            "Dear " .
                            $this->request->getData()["Detail"]["first_name"] .
                            " " .
                            $sponserInfo->Details["last_name"] .
                            ", Welcome to JSKS Infratech, Your Username: " .
                            $username .
                            " Password: " .
                            $password .
                            " Please visit Jsksinfratech.com";

                        //$sendSMS = $usersTable->sendSMS($template, $contact_no);

                        $msg = 'Dear '.$this->request->getData()["Detail"]["first_name"].', Welcome to FashionHolic,  Your usernmae='.$username.' and Password='.$password.' Please visit fashion.fashioholic.biz';
                        $usersTable->sendWhatsUpSMS($contact_no, $msg);

                        //$this->request->getSession()->write('userId', $user_id);

                        $this->request->getSession()->write("username", $username);

                        $this->request->getSession()->write("password", $password);

                        $this->Flash->success(
                            __(
                                "Congratulations! User has been resistered successfully."
                            )
                        );

                        return $this->redirect(
                            $this->home_url .
                                "/my-account/manage-users/user-added"
                        );
                    }
                }
            } else {
                $this->Flash->error(__("Please fill all the required fields."));
            }
        }
    }

    public function userAdded()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " User Added";

        $this->set("title", $title);
    }

    public function addKyc()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Add KYC";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $detailsTable = TableRegistry::get("Details");

        $attachmentsTable = TableRegistry::get("Attachments");

        $userId = $this->user->id;

        $join = [
            [
                "table" => "attachments",

                "alias" => "Photo",

                "type" => "LEFT",

                "conditions" => ["Photo.id = Details.photo_attachment_id"],
            ],

            [
                "table" => "attachments",

                "alias" => "Address",

                "type" => "LEFT",

                "conditions" => ["Address.id = Details.address_attachment_id"],
            ],

            [
                "table" => "attachments",

                "alias" => "Pan",

                "type" => "LEFT",

                "conditions" => ["Pan.id = Details.pan_attachment_id"],
            ],
        ];

        $conditions = [
            "Details.user_id" => $userId,
        ];

        $fields = [
            "Photo.id",
            "Photo.file",
            "Photo.caption",
            "Address.id",
            "Address.file",
            "Address.caption",
            "Pan.id",
            "Pan.file",
            "Pan.caption",
        ];

        $detail = $detailsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])
            ->enableAutoFields(true)
            ->first();

        $this->set("detail", $detail);

        /*echo '<pre>';

        print_r($detail);exit;*/

        if ($this->request->is("post")) {
            /* echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $photo_attachment_id = isset(
                $this->request->getData()["Detail"]["photo_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["photo_attachment_id"][0]
                : null;

            $address_attachment_id = isset(
                $this->request->getData()["Detail"]["address_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["address_attachment_id"][0]
                : null;

            $pan_attachment_id = isset(
                $this->request->getData()["Detail"]["pan_attachment_id"][0]
            )
                ? $this->request->getData()["Detail"]["pan_attachment_id"][0]
                : null;

            $detailData = $detailsTable->get(
                $this->request->getData()["Detail"]["id"]
            );

            $detailData->pan_number = isset(
                $this->request->getData()["Detail"]["pan_number"]
            )
                ? $this->request->getData()["Detail"]["pan_number"]
                : null;

            $detailData->bank_name = isset(
                $this->request->getData()["Detail"]["bank_name"]
            )
                ? $this->request->getData()["Detail"]["bank_name"]
                : null;

            $detailData->account_number = isset(
                $this->request->getData()["Detail"]["account_number"]
            )
                ? $this->request->getData()["Detail"]["account_number"]
                : null;

            $detailData->ifsc_code = isset(
                $this->request->getData()["Detail"]["ifsc_code"]
            )
                ? $this->request->getData()["Detail"]["ifsc_code"]
                : null;

            $detailData->branch_name = isset(
                $this->request->getData()["Detail"]["branch_name"]
            )
                ? $this->request->getData()["Detail"]["branch_name"]
                : null;

            $detailData->google_pay_number = isset(
                $this->request->getData()["Detail"]["google_pay_number"]
            )
                ? $this->request->getData()["Detail"]["google_pay_number"]
                : null;

            $detailData->phone_pay_number = isset(
                $this->request->getData()["Detail"]["phone_pay_number"]
            )
                ? $this->request->getData()["Detail"]["phone_pay_number"]
                : null;

            $detailData->paytm_number = isset(
                $this->request->getData()["Detail"]["paytm_number"]
            )
                ? $this->request->getData()["Detail"]["paytm_number"]
                : null;

            $detailData->pan_number = isset(
                $this->request->getData()["Detail"]["pan_number"]
            )
                ? $this->request->getData()["Detail"]["pan_number"]
                : null;

            $detailData->photo_attachment_id = $photo_attachment_id;

            $detailData->address_attachment_id = $address_attachment_id;

            $detailData->pan_attachment_id = $pan_attachment_id;

            if ($detailsTable->save($detailData)) {
                if (!empty($photo_attachment_id)) {
                    $attachmentData = $attachmentsTable->get(
                        $photo_attachment_id
                    );

                    $attachmentData->caption = isset(
                        $this->request->getData()["Detail"]["photo_attachment_id"][
                            "caption"
                        ][0]
                    )
                        ? $this->request->getData()["Detail"]["photo_attachment_id"][
                            "caption"
                        ][0]
                        : null;

                    $attachmentsTable->save($attachmentData);
                }

                if (!empty($address_attachment_id)) {
                    $attachmentData = $attachmentsTable->get(
                        $address_attachment_id
                    );

                    $attachmentData->caption = isset(
                        $this->request->getData()["Detail"]["address_attachment_id"][
                            "caption"
                        ][0]
                    )
                        ? $this->request->getData()["Detail"][
                            "address_attachment_id"
                        ]["caption"][0]
                        : null;

                    $attachmentsTable->save($attachmentData);
                }

                if (!empty($pan_attachment_id)) {
                    $attachmentData = $attachmentsTable->get(
                        $pan_attachment_id
                    );

                    $attachmentData->caption = isset(
                        $this->request->getData()["Detail"]["pan_attachment_id"][
                            "caption"
                        ][0]
                    )
                        ? $this->request->getData()["Detail"]["pan_attachment_id"][
                            "caption"
                        ][0]
                        : null;

                    $attachmentsTable->save($attachmentData);
                }

                $this->Flash->success(
                    __(
                        "Congratulations! KYC details has submitted successfully."
                    )
                );

                return $this->redirect(
                    $this->home_url . "/my-account/manage-users/add-kyc"
                );
            }

            //exit;
        }
    }

    public function myPlots()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Plots";

        $this->set("title", $title);

        $assignPlotsTable = TableRegistry::get("AssignPlots");

        $userId = $this->user->id;

        $join = [
            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "LEFT",

                "conditions" => ["Properties.id = AssignPlots.property_id"],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "LEFT",

                "conditions" => ["Sites.id = AssignPlots.site_id"],
            ],

            [
                "table" => "blocks",

                "alias" => "Blocks",

                "type" => "LEFT",

                "conditions" => ["Blocks.id = AssignPlots.block_id"],
            ],
        ];

        $conditions = [
            "AssignPlots.user_id" => $userId,
        ];

        $fields = [
            "Properties.id",
            "Properties.title",
            "Sites.id",
            "Sites.title",
            "Blocks.id",
            "Blocks.title",
        ];

        $assignPlots = $assignPlotsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
            ])

            ->select([
                "total_paid_payment" =>
                    "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=AssignPlots.user_id AND pp.assign_plot_id=AssignPlots.id)",
            ])

            ->enableAutoFields(true)
            ->toArray();

        $this->set("assignPlots", $assignPlots);
    }

    public function myEmi()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My EMI";

        $this->set("title", $title);

        $assignPlotsTable = TableRegistry::get("AssignPlots");

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $userId = $this->user->id;

        $conditions = [
            "AssignPlots.user_id" => $userId,
        ];

        $assignPlots = $assignPlotsTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("assignPlots", $assignPlots);

        $plotPayments = [];

        $assignPlotDetails = [];

        if ($this->request->is("post")) {
            /*echo '<pre>';

            print_r($this->request->getData());

            exit;*/

            $assignPlotid = isset($this->request->getData()["assignPlot"]["id"])
                ? $this->request->getData()["assignPlot"]["id"]
                : "";

            //$assignPlotid = 7;

            if (!empty($assignPlotid)) {
                $join = [
                    [
                        "table" => "properties",

                        "alias" => "Properties",

                        "type" => "LEFT",

                        "conditions" => [
                            "Properties.id = AssignPlots.property_id",
                        ],
                    ],

                    [
                        "table" => "sites",

                        "alias" => "Sites",

                        "type" => "LEFT",

                        "conditions" => ["Sites.id = AssignPlots.site_id"],
                    ],

                    [
                        "table" => "blocks",

                        "alias" => "Blocks",

                        "type" => "LEFT",

                        "conditions" => ["Blocks.id = AssignPlots.block_id"],
                    ],
                ];

                $conditions = [
                    "assignPlots.id" => $assignPlotid,
                ];

                $fields = [
                    "Properties.id",
                    "Properties.title",
                    "Sites.id",
                    "Sites.title",
                    "Blocks.id",
                    "Blocks.title",
                ];

                $assignPlotDetails = $assignPlotsTable
                    ->find("all", [
                        "fields" => $fields,
                        "join" => $join,
                        "conditions" => $conditions,
                    ])

                    ->select([
                        "total_paid_payment" =>
                            "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=AssignPlots.user_id AND pp.assign_plot_id=AssignPlots.id)",
                    ])

                    ->enableAutoFields(true)
                    ->first();

                $conditions = [
                    "PlotPayments.assign_plot_id" => $assignPlotid,
                ];

                $plotPayments = $plotPaymentsTable
                    ->find("all", ["conditions" => $conditions])
                    ->enableAutoFields(true)
                    ->toArray();
            }
        }

        $this->set("assignPlotDetails", $assignPlotDetails);

        $this->set("plotPayments", $plotPayments);
    }

    public function myTeamPlots()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Team Plots";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $userId = $this->user->id;

        $conditions = [
            "Downlines.user_id" => $userId,
        ];

        $joins = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_table_id"],
            ],

            [
                "table" => "users",

                "alias" => "Sponsers",

                "type" => "left",

                "conditions" => ["Sponsers.id = Downlines.sponsor_id"],
            ],

            [
                "table" => "assign_plots",

                "alias" => "AssignPlots",

                "type" => "INNER",

                "conditions" => [
                    "AssignPlots.user_id = Downlines.user_table_id AND AssignPlots.status = 1",
                ],
            ],

            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "LEFT",

                "conditions" => ["Properties.id = AssignPlots.property_id"],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "LEFT",

                "conditions" => ["Sites.id = AssignPlots.site_id"],
            ],

            [
                "table" => "blocks",

                "alias" => "Blocks",

                "type" => "LEFT",

                "conditions" => ["Blocks.id = AssignPlots.block_id"],
            ],

            [
                "table" => "plots",

                "alias" => "Plots",

                "type" => "LEFT",

                "conditions" => ["Plots.id = AssignPlots.plot_id"],
            ],
        ];

        $group = ["Downlines.user_table_id"];

        $fields = [
            "Users.id",
            "Users.username",
            "Users.total_active_left",
            "Users.total_active_right",
            "Users.status",
            "Sponsers.username",
            "Details.id",
            "Details.first_name",
            "Details.middle_name",
            "Details.last_name",
            "Details.contact_no",
            "Properties.id",
            "Properties.title",
            "Sites.id",
            "Sites.title",
            "Blocks.id",
            "Blocks.title",
            "AssignPlots.id",
            "Plots.name",
            "AssignPlots.id",
            "AssignPlots.created",
            "AssignPlots.plot_number",
            "AssignPlots.area",
            "AssignPlots.plan",
            "AssignPlots.current_rate",
            "AssignPlots.total_amount",
            "AssignPlots.plc_amount",
            "AssignPlots.grand_total",
            "AssignPlots.discount",
        ];

        $downlines = $downlinesTable
            ->find("all", [
                "fields" => $fields,
                "conditions" => $conditions,
                "join" => $joins,
                "group" => $group,
            ])

            ->select([
                "total_paid_payment" =>
                    "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=AssignPlots.user_id AND pp.assign_plot_id=AssignPlots.id)",
            ])

            ->enableAutoFields(true)
            ->toArray();

        $this->set("downlines", $downlines);

        /* echo '<pre>';

        print_r($downlines);exit;*/
    }

    public function plotAvaibility()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Plot Availablity";

        $this->set("title", $title);

        $plotsTable = TableRegistry::get("Plots");

        $userId = $this->user->id;

        $join = [
            [
                "table" => "properties",

                "alias" => "Properties",

                "type" => "LEFT",

                "conditions" => ["Properties.id = Plots.property_id"],
            ],

            [
                "table" => "sites",

                "alias" => "Sites",

                "type" => "LEFT",

                "conditions" => ["Sites.id = Plots.site_id"],
            ],

            [
                "table" => "blocks",

                "alias" => "Blocks",

                "type" => "LEFT",

                "conditions" => ["Blocks.id = Plots.block_id"],
            ],
        ];

        $conditions = [
            "Plots.status" => 1,
        ];

        $order = ["Plots.id" => "DESC"];

        $fields = [
            "Properties.id",
            "Properties.title",
            "Sites.id",
            "Sites.title",
            "Blocks.id",
            "Blocks.title",
        ];

        $group = ["Plots.id"];

        $plots = $plotsTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => $conditions,
                "order" => $order,
                "group" => $group,
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("plots", $plots);
    }

    public function myPayments()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " My Payments";

        $this->set("title", $title);

        $plotPaymentsTable = TableRegistry::get("PlotPayments");

        $userId = $this->user->id;

        $conditions = [
            "PlotPayments.user_id" => $userId,
        ];

        $order = [
            "PlotPayments.id" => "DESC",
        ];

        $plotPayments = $plotPaymentsTable
            ->find("all", ["conditions" => $conditions, "order" => $order])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("plotPayments", $plotPayments);
    }

    public function directRewards()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Direct Rewards";

        $this->set("title", $title);

        $achievedRewardsTable = TableRegistry::get("AchievedRewards");

        $userId = $this->user->id;

        $conditions = [
            "AchievedRewards.user_id" => $userId,
        ];

        $achievedRewardInfo = $achievedRewardsTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->first();

        $this->set("achievedRewardInfo", $achievedRewardInfo);
    }

    public function pairRewards()
    {
        if (!$this->request->getSession()->check("userId") || empty($this->user)) {
            return $this->redirect($this->home_url.'/user/login');
        }

        if ($this->user->status != 1 && $this->user->status != 3) {
            $this->Flash->error(
                __(
                    "Your account is not verified. To verify your account please enter below sent OTP to your registered contact number."
                )
            );

            return $this->redirect($this->home_url.'/user/verify-account');
        }

        $this->viewBuilder()->setLayout("my_account_blue");

        $prefix_title = $this->siteTitle;

        $title = $prefix_title . " Pair Rewards";

        $this->set("title", $title);

        $achievedRewardsTable = TableRegistry::get("AchievedRewards");

        $userId = $this->user->id;

        $conditions = [
            "AchievedRewards.user_id" => $userId,
        ];

        $achievedRewardInfo = $achievedRewardsTable
            ->find("all", ["conditions" => $conditions])
            ->enableAutoFields(true)
            ->first();

        $this->set("achievedRewardInfo", $achievedRewardInfo);
    }
}
