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
use Cake\Datasource\ConnectionManager;

class TeamController extends AppController
{
    public function directNetwork()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Direct Network";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $dwonlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $top_parent_id = $this->adminUser->id;

        $topUserInfo = $this->adminUser;

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

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

    public function network()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Network";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $dwonlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $top_parent_id = $this->adminUser->id;

        $topUserInfo = $this->adminUser;

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

            $conditions = ["Users.username" => $username];

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
                    "total_upgrades" =>
                        "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=Users.id)",
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
                "total_upgrades" =>
                    "(SELECT SUM(pp.amount) FROM plot_payments pp WHERE pp.user_id=Downlines.user_table_id)",
            ])

            ->enableAutoFields(true)
            ->toArray();

        $trees = $dwonlinesTable->getTreeByDownlines($downlines);

        $this->set("trees", $trees);

        /* echo '<pre>';

        print_r($trees);exit;*/
    }

    public function directReferral()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Direct Referral";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $user_id = "";

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

            $userInfo = $usersTable
                ->find("all", ["conditions" => ["Users.username" => $username]])
                ->enableAutoFields(true)
                ->first();

            if (!empty($userInfo)) {
                $user_id = $userInfo->id;
            }
        }

        $conditions = [
            "Downlines.user_id" => $user_id,

            "Downlines.sponsor_id" => $user_id,
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
    }

    public function downlineReport()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $user_id = "";

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

            $userInfo = $usersTable
                ->find("all", ["conditions" => ["Users.username" => $username]])
                ->enableAutoFields(true)
                ->first();

            if (!empty($userInfo)) {
                $user_id = $userInfo->id;
            }
        }

        $conditions = [
            "Downlines.user_id" => $user_id,
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
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $user_id = "";

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

            $userInfo = $usersTable
                ->find("all", ["conditions" => ["Users.username" => $username]])
                ->enableAutoFields(true)
                ->first();

            if (!empty($userInfo)) {
                $user_id = $userInfo->id;
            }
        }

        $conditions = [
            "Downlines.user_id" => $user_id,
        ];

        if (!empty($user_id)) {
            $connection = ConnectionManager::get("default");

            $downlines = $connection->query(
                'SELECT d.position,SUM(CASE WHEN u.is_mobile_club = 1 THEN 1 ELSE 0 END) AS mobile_club_count,SUM(CASE WHEN                                                         u.is_laptop_club = 1 THEN 1 ELSE 0 END) AS laptop_club_count,

                                            SUM(CASE WHEN u.is_bike_club = 1 THEN 1 ELSE 0 END) AS bike_club_count,

                                            SUM(CASE WHEN u.is_diamond_club = 1 THEN 1 ELSE 0 END) AS diamond_club_count,

                                            SUM(CASE WHEN u.is_king_club = 1 THEN 1 ELSE 0 END) AS king_club_count

                                            FROM downlines d

                                            JOIN users u ON d.user_table_id = u.id

                                            WHERE d.user_id = ' .
                    $user_id .
                    '

                                            GROUP BY d.position'
            );

            //->fetchAll('assoc')

            $this->set("downlines", $downlines);
        }
    }

    public function currentTotalBusiness()
    {
        if (!$this->request->getSession()->check("adminUserId")) {
            return $this->redirect($this->backend_url.'/user/login');
        }

        $prefix_title = $this->backendTitle;

        $title = $prefix_title . " Team : Downline Report";

        $this->set("title", $title);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $join = [
            [
                "table" => "details",

                "alias" => "Details",

                "type" => "INNER",

                "conditions" => ["Details.user_id = Users.id"],
            ],
        ];

        $fields = ["Details.id", "Details.first_name", "Details.last_name"];

        $users = $usersTable
            ->find("all", [
                "fields" => $fields,
                "join" => $join,
                "conditions" => ["Users.role_id" => 2],
            ])
            ->enableAutoFields(true)
            ->toArray();

        $this->set("users", $users);

        $usersTable = TableRegistry::get("Users");

        $downlinesTable = TableRegistry::get("Downlines");

        $user_id = "";

        if (isset($_GET["username"])) {
            $username = $_GET["username"];

            $userInfo = $usersTable
                ->find("all", ["conditions" => ["Users.username" => $username]])
                ->enableAutoFields(true)
                ->first();

            if (!empty($userInfo)) {
                $user_id = $userInfo->id;
            }
        }

        $conditions = [
            "Downlines.user_id" => $user_id,
        ];

        if (!empty($user_id)) {
            $fromdate = $_GET["from_date"];

            $to_date = $_GET["to_date"];

            if (!empty($fromdate) && !empty($to_date)) {
                $fromdate = date("Y-m-d", strtotime($fromdate));

                $to_date = date("Y-m-d", strtotime($to_date));

                $username = $_GET["username"];

                $connection = ConnectionManager::get("default");

                $totalbusiess = $connection
                    ->query(
                        'SELECT d.position, SUM(p.amount) as total_amount FROM downlines d INNER JOIN plot_payments p ON 

              d.user_table_id = p.user_id WHERE d.user_id = ' .
                            $user_id .
                            ' AND d.position IN ("left", "right") AND p.created 

              BETWEEN "' .
                            $fromdate .
                            '" AND "' .
                            $to_date .
                            '" GROUP BY d.position'
                    )
                    ->fetchAll("assoc");

                $this->set("totalbusiness", $totalbusiess);
            } else {
                $username = $_GET["username"];

                $connection = ConnectionManager::get("default");

                $totalbusiess = $connection
                    ->query(
                        'SELECT d.position, SUM(p.amount) as total_amount FROM downlines d INNER JOIN plot_payments p ON 

              d.user_table_id = p.user_id WHERE d.user_id = ' .
                            $user_id .
                            ' AND d.position IN ("left", "right") GROUP BY d.position'
                    )
                    ->fetchAll("assoc");

                $this->set("totalbusiness", $totalbusiess);
            }
        }
    }
}
