<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior("Timestamp");
    }

    public function getLastUserInfo($intUserId)
    {
        $user = $this->find("all", [
            "conditions" => [
                "Users.sponsor_id" => $intUserId
            ],
        ])->first();

        //echo"<pre>";print_r($user);exit;

        $userInfo = "";

        if ($user) {
            $userInfo .= $this->getLastUserInfo($user->id);

            // echo"<pre>";print_r($userInfo);exit;
        } else {
            $conditions = [
                "Users.id" => $intUserId,
            ];

            $userInfo .= $this->find("all", [
                "conditions" => $conditions
            ])
                ->enableAutoFields(true)
                ->first();
        }

        return $userInfo;
    }

    public function updateParents(
        $intUserId,
        $intSponsorId,
        $intUserTableId,
        $intLevel,
        $fixedParentId,
        $fixedSponserId,
        $created = ''
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId;

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intSponsorId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intSponsorId],
            ])->first();

            $sponsor = $this->get($user->id);
            $sponsor->total_downline = $user->total_downline + 1;
            $sponsor->total_downline_business = $user->total_downline_business + 1000;
            $this->save($sponsor);

            $nextLevel = $intLevel + 1;

            $downline = $downlinesTable->newEmptyEntity();
            $downline->user_table_id = $intUserTableId;
            $downline->user_id = $user->id;
            $downline->sponsor_id = $fixedSponserId;
            $downline->level = $nextLevel;
            $downline->total_join = 0;
            $downline->status = 0;
            if ($created) {
                $downline->created = $created;
                $downline->modified = $created;
            }
            $downlinesTable->save($downline);

            $this->updateParents(
                $user->id,
                $user->sponsor_id,
                $intUserTableId,
                $nextLevel,
                $fixedParentId,
                $fixedSponserId,
                $created
            );
        }

        return $intUserTableId;
    }

    public function updateParentCustomerBusiness($intUserId, $amount)
    {
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            $sponsor = $this->get($user->id);
            $sponsor->total_customers_business = $user->total_customers_business + $amount;
            $this->save($sponsor);
            if ($user->sponsor_id) {
                $this->updateParentCustomerBusiness($user->sponsor_id, $amount);
            }
        }
    }

    public function updateParentCustomerBusinessOnPackageRemove($intUserId, $amount)
    {
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            $sponsor = $this->get($user->id);
            $sponsor->total_customers_business = $user->total_customers_business - $amount;
            $this->save($sponsor);
            if ($user->sponsor_id) {
                $this->updateParentCustomerBusinessOnPackageRemove($user->sponsor_id, $amount);
            }
        }
    }

    public function updateParentTodayBusiness($intUserId, $amount)
    {
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            $sponsor = $this->get($user->id);
            $sponsor->total_today_business = $user->total_today_business + $amount;
            $this->save($sponsor);
            if ($user->sponsor_id) {
                $this->updateParentTodayBusiness($user->sponsor_id, $amount);
            }
        }
    }

    public function updateParentTodayBusinessOnPackageRemove($intUserId, $amount)
    {
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            $sponsor = $this->get($user->id);
            $sponsor->total_today_business = $user->total_today_business - $amount;
            $this->save($sponsor);
            if ($user->sponsor_id) {
                $this->updateParentTodayBusinessOnPackageRemove($user->sponsor_id, $amount);
            }
        }
    }

    public function updateParentCustomerBusinessOnUpdateOrDelete($intUserId, $amount)
    {
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            $sponsor = $this->get($user->id);
            $sponsor->total_customers_business = $user->total_customers_business - $amount;
            $this->save($sponsor);
            if ($user->sponsor_id) {
                $this->updateParentCustomerBusinessOnUpdateOrDelete($user->sponsor_id, $amount);
            }
        }
    }

    public function payPlanAbCommissionToParents($paymentById, $packegeId, $emiId, $intUserId, $amount, $created='', $currentPaidRank = 0, $totalPaidPercentage = 0, $count = 1, )
    {
        $payoutsTable = TableRegistry::get("Payouts");
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            if ($user->current_rank == 13) {
                $percentage = 9;
            } elseif ($user->current_rank == 12) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*8));
            } elseif ($user->current_rank == 11) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*7));
            } elseif ($user->current_rank == 10) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*6));
            } elseif ($user->current_rank == 9) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*5));
            } elseif ($user->current_rank == 8) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*4));
            } elseif ($user->current_rank == 7) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*3));
            } elseif ($user->current_rank == 6) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*2));
            } elseif ($user->current_rank == 5) {
                $percentage = (1.5 + 1.2 + 0.9 + (0.6*1));
            } elseif ($user->current_rank == 4) {
                $percentage = (1.5 + 1.2 + 0.9);
            } elseif ($user->current_rank == 3) {
                $percentage = (1.5 + 1.2);
            } elseif ($user->current_rank == 2) {
                $percentage = (1.5);
            } elseif ($user->current_rank == 1) {
                $percentage = 0;
            }
            if ($currentPaidRank < $user->current_rank) {
                $remark = 'Level Income';
                if ($count == 1) {
                    $remark = 'Direct Income';
                }
                $payblePercentage = $percentage - $totalPaidPercentage;
                $payout = $payoutsTable->newEmptyEntity();
                $payout->user_id = $user->id;
                $payout->package_id = $packegeId;
                $payout->emi_id = $emiId;
                $payout->payment_by_id = $paymentById;
                $payout->level_income = ($amount * $payblePercentage)/100;
                $payout->current_rank = $user->current_rank;
                $payout->remark = $remark;
                $payout->status = 0;
                if ($created) {
                    $payout->created = $created;
                    $payout->modified = $created;
                }
                $payoutsTable->save($payout);
                $currentPaidRank = $user->current_rank;
                $totalPaidPercentage = $totalPaidPercentage + $payblePercentage;
            }
            if ($user->sponsor_id && $user->current_rank < 13) {
                $count = $count + 1;
                $this->payPlanAbCommissionToParents($paymentById, $packegeId, $emiId, $user->sponsor_id, $amount, $created, $currentPaidRank, $totalPaidPercentage, $count);
            }
        }
    }

    public function removePlanCommissionByPackageId($packageId)
    {
        $payoutsTable = TableRegistry::get("Payouts");
        $payoutsTable->deleteAll(["package_id" => $packageId]);
    }

    public function payPlanMbCommissionToParents($paymentById, $packegeId, $intUserId, $amount, $created = '', $currentPaidRank = 0, $totalPaidPercentage = 0, $count = 1)
    {
        $payoutsTable = TableRegistry::get("Payouts");
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            if ($user->current_rank == 13) {
                $percentage = 6;
            } elseif ($user->current_rank == 12) {
                $percentage = 0.5*11;
            } elseif ($user->current_rank == 11) {
                $percentage = 0.5*10;
            } elseif ($user->current_rank == 10) {
                $percentage = 0.5*9;
            } elseif ($user->current_rank == 9) {
                $percentage = 0.5*8;
            } elseif ($user->current_rank == 8) {
                $percentage = 0.5*7;
            } elseif ($user->current_rank == 7) {
                $percentage = 0.5*6;
            } elseif ($user->current_rank == 6) {
                $percentage = 0.5*5;
            } elseif ($user->current_rank == 5) {
                $percentage = 0.5*4;
            } elseif ($user->current_rank == 4) {
                $percentage = 0.5*3;
            } elseif ($user->current_rank == 3) {
                $percentage = 0.5*2;
            } elseif ($user->current_rank == 2) {
                $percentage = 0.5*1;
            } elseif ($user->current_rank == 1) {
                $percentage = 0;
            }
            if ($currentPaidRank < $user->current_rank) {
                $remark = 'Level Income';
                if ($count == 1) {
                    $remark = 'Direct Income';
                }
                $payblePercentage = $percentage - $totalPaidPercentage;
                $payout = $payoutsTable->newEmptyEntity();
                $payout->user_id = $user->id;
                $payout->package_id = $packegeId;
                $payout->payment_by_id = $paymentById;
                $payout->level_income = ($amount * $payblePercentage)/100;
                $payout->current_rank = $user->current_rank;
                $payout->remark = $remark;
                $payout->status = 0;
                if ($created) {
                    $payout->created = $created;
                    $payout->modified = $created;
                }
                $payoutsTable->save($payout);
                $currentPaidRank = $user->current_rank;
                $totalPaidPercentage = $totalPaidPercentage + $payblePercentage;
            }
            if ($user->sponsor_id && $user->current_rank < 13) {
                $count = $count + 1;
                $this->payPlanMbCommissionToParents($paymentById, $packegeId, $user->sponsor_id, $amount, $created, $currentPaidRank, $totalPaidPercentage, $count);
            }
        }
    }

    public function payPlanMbRepurchaseIncomeToParents($paymentById, $packegeId, $intUserId, $amount, $currentPaidRank = 0, $totalPaidPercentage = 0, $count = 1)
    {
        $payoutsTable = TableRegistry::get("Payouts");
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            if ($user->current_rank == 13) {
                $percentage = 7.5;
            } elseif ($user->current_rank == 12) {
                $percentage = (2 + (0.5*11));
            } elseif ($user->current_rank == 11) {
                $percentage = (2 + (0.5*10));
            } elseif ($user->current_rank == 10) {
                $percentage = (2 + (0.5*9));
            } elseif ($user->current_rank == 9) {
                $percentage = (2 + (0.5*8));
            } elseif ($user->current_rank == 8) {
                $percentage = (2 + (0.5*7));
            } elseif ($user->current_rank == 7) {
                $percentage = (2 + (0.5*6));
            } elseif ($user->current_rank == 6) {
                $percentage = (2 + (0.5*5));
            } elseif ($user->current_rank == 5) {
                $percentage = (2 + (0.5*4));
            } elseif ($user->current_rank == 4) {
                $percentage = (2 + (0.5*3));
            } elseif ($user->current_rank == 3) {
                $percentage = (2 + (0.5*2));
            } elseif ($user->current_rank == 2) {
                $percentage = (2 + (0.5*1));
            } elseif ($user->current_rank == 1) {
                $percentage = 2;
            }
            if ($currentPaidRank < $user->current_rank) {
                $remark = 'Repurchase MB';
                $payblePercentage = $percentage - $totalPaidPercentage;
                $payout = $payoutsTable->newEmptyEntity();
                $payout->user_id = $user->id;
                $payout->package_id = $packegeId;
                $payout->payment_by_id = $paymentById;
                $payout->repurchase_mb_income = ($amount * $payblePercentage)/100;
                $payout->current_rank = $user->current_rank;
                $payout->remark = $remark;
                $payout->status = 0;
                $payoutsTable->save($payout);
                $currentPaidRank = $user->current_rank;
                $totalPaidPercentage = $totalPaidPercentage + $payblePercentage;
            }
            if ($user->sponsor_id && $user->current_rank < 13) {
                $count = $count + 1;
                $this->payPlanMbRepurchaseIncomeToParents($paymentById, $packegeId, $user->sponsor_id, $amount, $currentPaidRank, $totalPaidPercentage, $count);
            }
        }
    }

    public function updateParentsOnUpgrade(
        $intUserId,
        $intParentId,
        $packaeAmount,
        $parentNumbered = 0
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;

        //exit;

        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            if ($parentNumbered > 0) {
                $parent = $this->get($user->id);

                if (trim($user->left_user) == trim($intUserId)) {
                    $parent->total_active_left =
                        $user->total_active_left + $packaeAmount;
                } elseif (trim($user->right_user) == trim($intUserId)) {
                    //echo $user->right_user. '--------'.$intUserId.'<br>';

                    $parent->total_active_right =
                        $user->total_active_right + $packaeAmount;
                }

                $this->save($parent);
            }

            $parentNumbered = $parentNumbered + 1;

            $this->updateParentsOnUpgrade(
                $user->id,
                $user->parent_id,
                $packaeAmount,
                $parentNumbered
            );
        }

        //exit;
    }

    public function updateParentsOnUpgradeTemp(
        $intUserId,
        $intParentId,
        $packaeAmount,
        $parentNumbered = 0
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;

        //exit;

        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            if ($parentNumbered > 0) {
                $parent = $this->get($user->id);

                if (trim($user->left_user) == trim($intUserId)) {
                    $parent->total_active_left =
                        $user->total_active_left - $packaeAmount;
                } elseif (trim($user->right_user) == trim($intUserId)) {
                    $parent->total_active_right =
                        $user->total_active_right - $packaeAmount;
                }

                exit();

                $this->save($parent);
            }

            $parentNumbered = $parentNumbered + 1;

            $this->updateParentsOnUpgradeTemp(
                $user->id,
                $user->parent_id,
                $packaeAmount,
                $parentNumbered
            );
        }

        //exit;
    }

    public function updateParentsOnPackageUpgrade(
        $intUserId,
        $intParentId,
        $packaeAmount,
        $parentNumbered = 0
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;
        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            $parent = $this->get($user->id);
            $parent->total_downline_business = $parent->total_downline_business + $packaeAmount;
            if ($parentNumbered != 1) {
              $parent->total_active_downline = (int) $parent->total_active_downline + 1;
            }
            $this->save($parent);

            //$parentNumbered = $parentNumbered + 1;
            $this->updateParentsOnPackageUpgrade($user->id, $user->parent_id, $packaeAmount, $parentNumbered);
        }
    }

    public function updateSponsorOnEmiApprove($intUserId, $amount) {
        if ($intUserId) {
            $parent = $this->get($intUserId);
            $parent->total_customers_business = $parent->total_customers_business + $amount;
            $this->save($parent);
            $conditions = ['Users.id' => $intUserId];
            $userInfo = $this->find("all", ["conditions" => $conditions])->first();
            if ($userInfo) {
                $this->updateSponsorOnEmiApprove($userInfo->sponsor_id, $amount);
            }
        }
    }

    public function updateRepurchaseMBToParents($intUserId, $amount) {
        if ($intUserId) {
            $parent = $this->get($intUserId);
            $parent->repurchase_mb = $parent->repurchase_mb + $amount;
            $this->save($parent);
            $conditions = ['Users.id' => $intUserId];
            $userInfo = $this->find("all", ["conditions" => $conditions])->first();
            if ($userInfo) {
                $this->updateRepurchaseMBToParents($userInfo->sponsor_id, $amount);
            }
        }
    }

    public function levelUp($userId) {
        $conditions = [
            'Users.id' => $userId,
            'Users.total_self_business >=' => 1000,
            'Users.status' => 1
        ];
        $fields = ['Users.id'];
        $userInfo = $this->find("all", ['fields' => $fields, 'conditions' => $conditions])
        ->select([
            'dayCount' => '(SELECT DATEDIFF("'.date("Y-m-d H:i:s").'", u.created) from upgrades u WHERE u.upgraded_id=Users.id ORDER BY u.id ASC LIMIT 0, 1)',
            'totalDirects' => '(SELECT COUNT(u.id) FROM users u WHERE u.sponsor_id = Users.id AND u.status = 1 AND u.total_self_business >= 200)'
        ])->first();

        if( $userInfo && $userInfo->dayCount <= 30 && $userInfo->totalDirects >= 8) {
            $userData = $this->get($userId);
            $userData->is_level_up = 1;
            $userData->level_up_date = date('Y-m-d');
            $this->save($userData);
        }
    }

    public function updateParentsOnDegrade(
        $intUserId,
        $intParentId,
        $packaeAmount,
        $parentNumbered = 0
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;

        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            $parent = $this->get($user->id);

            if ($parentNumbered > 0) {
                if (trim($user->left_user) == trim($intUserId)) {
                    $parent->total_active_left =
                        $user->total_active_left - $packaeAmount;
                } elseif (trim($user->right_user) == trim($intUserId)) {
                    $parent->total_active_right =
                        $user->total_active_right - $packaeAmount;
                }
            }

            $this->save($parent);

            $parentNumbered = $parentNumbered + 1;

            $this->updateParentsOnDegrade(
                $user->id,
                $user->parent_id,
                $packaeAmount,
                $parentNumbered
            );
        }
    }

    public function updateParentsOnPackageDegrade(
        $intUserId,
        $intParentId,
        $packaeAmount
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;

        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            $parent = $this->get($user->id);

            if (trim($user->left_user) == trim($intUserId)) {
                $parent->active_left_one =
                    $user->active_left_one - $packaeAmount;
            } elseif (trim($user->right_user) == trim($intUserId)) {
                $parent->active_right_one =
                    $user->active_right_one - $packaeAmount;
            }

            $this->save($parent);

            $this->updateParentsOnPackageUpgrade(
                $user->id,
                $user->parent_id,
                $packaeAmount
            );
        }
    }

    public function updateParentsOnPayEmi(
        $intUserId,
        $intParentId,
        $matchingAmount,
        $parentNumbered = 1
    ) {
        //echo 'User Id '. $intUserId. '----------Parent : '.$intParentId.'-----------Package : '.$packaeAmount;

        //echo '<br>';

        $downlinesTable = TableRegistry::get("Downlines");

        if ($intParentId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intParentId],
            ])->first();

            if ($parentNumbered > 1) {
                $parent = $this->get($user->id);

                if (trim($user->left_user) == trim($intUserId)) {
                    $parent->left_emi = $user->left_emi + $matchingAmount;
                } elseif (trim($user->right_user) == trim($intUserId)) {
                    $parent->right_emi = $user->right_emi + $matchingAmount;
                }

                $this->save($parent);
            }

            $parentNumbered = $parentNumbered + 1;

            $this->updateParentsOnPayEmi(
                $user->id,
                $user->parent_id,
                $matchingAmount,
                $parentNumbered
            );
        }
    }

    public function updateAchievedRewards($intUserId, $upgradedId)
    {
        $rewardsTable = TableRegistry::get("Rewards");

        $achievedRewardsTable = TableRegistry::get("AchievedRewards");

        if ($intUserId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intUserId],
            ])->first();

            $matchingUsers = $user->total_active_left;

            if ($user->total_active_left > $user->total_active_right) {
                $matchingUsers = $user->total_active_right;
            }

            $conditions = [
                'Rewards.matching_users <= "' .
                $matchingUsers .
                '" AND Rewards.status = "1"',
            ];

            $rewards = $rewardsTable
                ->find("all", ["conditions" => $conditions])
                ->toArray();

            foreach ($rewards as $reward) {
                $conditions = [
                    "AchievedRewards.user_id" => $user->id,

                    "AchievedRewards.reward_id" => $reward->id,
                ];

                $checkAchievedReward = $achievedRewardsTable
                    ->find("all", ["conditions" => $conditions])
                    ->count();

                if ($checkAchievedReward == 0) {
                    $achievedReaward = $achievedRewardsTable->newEmptyEntity();

                    $achievedReaward->upgraded_id = $upgradedId;

                    $achievedReaward->user_id = $user->id;

                    $achievedReaward->reward_id = $reward->id;

                    $achievedReaward->direct_users = $reward->direct_users;

                    $achievedReaward->matching_users = $reward->matching_users;

                    $achievedReaward->reward = $reward->reward;

                    $achievedReaward->amount = $reward->amount;

                    $achievedReaward->start_date = date("Y-m-d");

                    $achievedReaward->end_date = date("Y-m-d");

                    $achievedReaward->status = 1;

                    $achievedRewardsTable->save($achievedReaward);
                }
            }

            $this->updateAchievedRewards($user->parent_id, $upgradedId);
        }
    }

    public function updateAchievedBonanzas($intUserId, $upgradedId)
    {
        $bonanzasTable = TableRegistry::get("Bonanzas");

        $achievedBonanzasTable = TableRegistry::get("AchievedBonanzas");

        if ($intUserId > 0) {
            $user = $this->find("all", [
                "conditions" => ["Users.id" => $intUserId],
            ])->first();

            $matchingUsers = $user->active_left_one;

            if ($user->active_left_one > $user->active_right_one) {
                $matchingUsers = $user->active_right_one;
            }

            $directUsers =
                $user->direct_active_left_one + $user->direct_active_right_one;

            $conditions = [
                'Bonanzas.matching_users <= "' .
                $matchingUsers .
                '" AND Bonanzas.direct_users <= "' .
                $directUsers .
                '" AND Bonanzas.status = "1"',
            ];

            $bonanzas = $bonanzasTable
                ->find("all", ["conditions" => $conditions])
                ->toArray();

            foreach ($bonanzas as $bonanza) {
                $conditions = [
                    "AchievedBonanzas.user_id" => $user->id,

                    "AchievedBonanzas.bonanza_id" => $bonanza->id,
                ];

                $checkAchievedBonanza = $achievedRewardsTable
                    ->find("all", ["conditions" => $conditions])
                    ->count();

                if ($checkAchievedBonanza == 0) {
                    $achievedBonanza = $achievedRewardsTable->newEmptyEntity();

                    $achievedBonanza->upgraded_id = $upgradedId;

                    $achievedBonanza->user_id = $user->id;

                    $achievedBonanza->bonanza_id = $bonanza->id;

                    $achievedBonanza->direct_users = $bonanza->direct_users;

                    $achievedBonanza->matching_users = $bonanza->matching_users;

                    $achievedBonanza->reward = $bonanza->reward;

                    $achievedBonanza->amount = $bonanza->amount;

                    $achievedBonanza->start_date = date("Y-m-d");

                    $achievedBonanza->end_date = date("Y-m-d");

                    $achievedBonanza->status = 1;

                    $achievedRewardsTable->save($achievedReaward);
                }
            }

            $this->updateAchievedBonanzas($user->parent_id, $upgradedId);
        }
    }

    public function sendSMS($reciverNumber, $templateId, $template)
    {
        $Phno = $reciverNumber;
        $Msg = $template;
        $Password = 'dvnn2174DV';
        $SenderID = 'DAULAA';
        $UserID = 'daulatpridebiz';
        $TemplateID = $templateId;
        $EntityID = '1001697963447169411';
             
        $ch='';
        $url='http://nimbusit.biz/api/SmsApi/SendSingleApi?UserID='.$UserID.'&Password='.$Password.'&SenderID='.$SenderID.'&Phno='.$Phno.'&Msg='.urlencode($Msg).'&EntityID='.$EntityID.'&TemplateID='.$TemplateID;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function sendWhatsUpSMS($contact_no, $msg)
    {
        $url = 'https://api.bulkcampaigns.com/api/wapi/?apikey=d26401c441d6e2d2267d536438473519&mobile='.$contact_no.'&msg='.urlencode($msg);
        //echo $url;exit;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, ""); 
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10); 
        curl_setopt($curl, CURLOPT_TIMEOUT , 30); 
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
    }

    public function getAdminStatistics()
    {
        $conn = ConnectionManager::get("default");

        $query = $conn->execute(
            "SELECT COUNT(Users.id) AS totalAgents, 
            (SELECT COUNT(u.id) FROM users u WHERE u.role_id = 3) AS totalCustomers,
            (SELECT COUNT(u.id) FROM users u WHERE u.role_id = 3 AND u.status = 1) AS totalActiveCustomer,
            (SELECT COUNT(u.id) FROM users u WHERE u.role_id = 3 AND u.status = 3) AS totalInactiveCustomers,
            (SELECT COUNT(p.id) FROM packages p) AS totalPackages,
            (SELECT COUNT(p.id) FROM packages p WHERE p.plan_id = 1) AS totalPlanAB,
            (SELECT COUNT(p.id) FROM packages p WHERE p.plan_id = 2) AS totalPlanMB,
            (SELECT u.total_customers_business FROM users u WHERE u.id = 1) AS totalCustomerBusiness,
            (SELECT (COUNT(u.id)*1110) FROM users u WHERE u.role_id = 2) AS totalAgentBusiness,
            (SELECT COUNT(u.id) FROM users u WHERE u.role_id = 2 AND u.sponsor_id = 1) AS totalDirectAgents,
            (SELECT COUNT(u.id) FROM users u WHERE u.role_id = 3 AND u.sponsor_id = 1) AS totalDirectCustomers,
            (SELECT COUNT(c.id) FROM coupons c INNER JOIN promotions p ON c.promotion_id = p.id WHERE p.plan_id = 1) AS total25kCoupons,
            (SELECT COUNT(c.id) FROM coupons c INNER JOIN promotions p ON c.promotion_id = p.id WHERE p.plan_id = 2) AS total50kCoupons,
            (SELECT COUNT(c.id) FROM coupons c INNER JOIN promotions p ON c.promotion_id = p.id WHERE p.plan_id = 3) AS total75kCoupons,
            (SELECT COUNT(c.id) FROM coupons c INNER JOIN promotions p ON c.promotion_id = p.id WHERE p.plan_id = 4) AS total100kCoupons
            FROM users as Users WHERE Users.role_id = 2 AND Users.status != 2"
        );
        $adminStatistics = $query->fetchAll("assoc");

        return $adminStatistics;
    }

    public function getAgentStatistics($intUserId){

        $conn = ConnectionManager::get("default");
        $query = $conn->execute(
            "SELECT  SUM(Payouts.level_income) as directIncome,
            (SELECT SUM(w.amount) FROM wallets as w WHERE w.user_id = '" .$intUserId."') AS walletBalance,
            (SELECT SUM(p.level_income) FROM payouts as p WHERE p.user_id = '" .$intUserId."' AND p.remark = 'Level Income') AS levelIncome,
            (SELECT COUNT(u.id) FROM users as u WHERE u.sponsor_id = '" .$intUserId."' AND u.role_id = 2) AS totalDirectAgents,
            (SELECT COUNT(u.id) FROM users as u WHERE u.sponsor_id = '" .$intUserId."' AND u.role_id = 3) AS totalDirectCustomers,
            (SELECT SUM(p.direct_income) FROM promotion_payouts as p WHERE p.user_id = '" .$intUserId."') AS totalPromotionDirectAmount,
            (SELECT SUM(p.level_income) FROM promotion_payouts as p WHERE p.user_id = '" .$intUserId."') AS totalPromotionLevelAmount
            FROM payouts as Payouts
            WHERE Payouts.user_id = '" . $intUserId ."' AND Payouts.remark = 'Direct Income'"
        );

        return $query->fetchAll("assoc");
    }

    public function getCustomerStatistics($intUserId){

        $conn = ConnectionManager::get("default");
        $query = $conn->execute(
            "SELECT  COUNT(Packages.id) as totalPlanAb,
            (SELECT SUM(w.amount) FROM wallets as w WHERE w.user_id = '" .$intUserId."') AS walletBalance,
            (SELECT COUNT(p.id) FROM packages as p WHERE p.user_id = '" .$intUserId."' AND p.plan_id = 2 AND p.status IS NULL) AS totalActivePlanMB,
            (SELECT COUNT(p.id) FROM packages as p WHERE p.user_id = '" .$intUserId."' AND p.plan_id = 2) AS totalPlanMB,
            (SELECT COUNT(p.id) FROM packages as p WHERE p.user_id = '" .$intUserId."' AND p.plan_id = 2 AND p.status IS NULL) AS totalActivePlanAB,
            (SELECT COUNT(e.id) FROM emis as e WHERE e.user_id = '" .$intUserId."') AS totalEmis,
            (SELECT COUNT(b.id) FROM bills as b WHERE b.user_id = '" .$intUserId."') AS totalBills
            FROM packages as Packages
            WHERE Packages.user_id = '" . $intUserId ."' AND Packages.plan_id = 1"
        );

        return $query->fetchAll("assoc");
    }

    public function checkUserLabelUp($intUserId, $boosterTime)
    {
        $conditions = [
            "Users.id" => $intUserId,
        ];

        $join = [
            [
                "table" => "upgrades",

                "alias" => "Upgrades",

                "type" => "INNER",

                "conditions" => ["Upgrades.upgraded_id = Users.id"],
            ],
        ];

        $fields = [
            "Users.id",
            "Users.is_level_up",
            "Upgrades.id",
            "Upgrades.package_amount",
            "Upgrades.created",
        ];

        $userInfo = $this->find("all", [
            "fields" => $fields,
            "conditions" => $conditions,
            "join" => $join,
        ])->first();

        /*echo '<pre>';

        print_r($userInfo);

        echo $userInfo->Upgrades['created'];

        exit;*/

        $isLavelUp = "0_^_0";

        if (!empty($userInfo)) {
            if ($userInfo->is_level_up == 1) {
                $isLavelUp = "1_^_2";
            } else {
                $deadLineDate = date(
                    "Y-m-d",
                    strtotime(
                        $userInfo->Upgrades["created"] .
                            " +" .
                            $boosterTime .
                            " days"
                    )
                );

                $join = [
                    [
                        "table" => "upgrades",

                        "alias" => "Upgrades",

                        "type" => "INNER",

                        "conditions" => ["Upgrades.upgraded_id = Users.id"],
                    ],
                ];

                $conditions = [
                    "Users.position" => "left",

                    "Users.sponsor_id" => $intUserId,

                    "Upgrades.created <=" => $deadLineDate,

                    "Upgrades.package_amount >=" =>
                        $userInfo->Upgrades["package_amount"],
                ];

                $checkLeftUpgraded = $this->find("all", [
                    "join" => $join,
                    "conditions" => $conditions,
                ])->count();

                if ($checkLeftUpgraded > 0) {
                    $conditions = [
                        "Users.position" => "right",

                        "Users.sponsor_id" => $intUserId,

                        "Upgrades.created <=" => $deadLineDate,

                        "Upgrades.package_amount >=" =>
                            $userInfo->Upgrades["package_amount"],
                    ];

                    $checkRightUpgraded = $this->find("all", [
                        "join" => $join,
                        "conditions" => $conditions,
                    ])->count();

                    if ($checkRightUpgraded > 0) {
                        $userData = $this->get($intUserId);

                        $userData->is_level_up = 1;

                        $this->save($userData);

                        $isLavelUp = "1_^_1";
                    }
                }
            }
        }

        return $isLavelUp;
    }

    public function getUniqueUsername($towLatterOfTitle)
    {
        $username = $towLatterOfTitle . rand(10000, 99999);

        $checkUsername = $this->find("all", [
            "conditions" => ["Users.username" => $username],
        ])->count();

        $uniqueUsername = "";

        if ($checkUsername > 0) {
            $uniqueUsername .= $this->getUniqueUsername($towLatterOfTitle);
        } else {
            $uniqueUsername .= $username;
        }

        return $uniqueUsername;
    }

    public function getParentsIds($intUserId, $level, $count = 0)
    {
        $user = $this->find("all", [
            "conditions" => ["Users.id" => $intUserId],
        ])->first();

        $parentIds = "";

        if (!empty($user) && $count < $level) {
            $seperator = "";

            if ($count > 0) {
                $seperator = "_^_";
            }

            $parentIds .= $seperator . $user->parent_id;

            $parentIds .= $this->getParentsIds(
                $user->parent_id,
                $level,
                $count + 1
            );
        }

        return $parentIds;
    }

    public function getSponserIds($intUserId, $level, $count = 0)
    {
        $user = $this->find("all", [
            "conditions" => ["Users.id" => $intUserId],
        ])->first();

        $sponserIds = "";

        if (!empty($user) && $count < $level) {
            $seperator = "";

            if ($count > 0) {
                $seperator = "_^_";
            }

            $sponserIds .= $seperator . $user->sponsor_id;

            $sponserIds .= $this->getParentsIds(
                $user->sponsor_id,
                $level,
                $count + 1
            );
        }

        return $sponserIds;
    }

    public function addLevelIncome(
        $intUserId,
        $amount,
        $startLevel,
        $endLevel,
        $currentRank = null
    ) {
        if ($startLevel <= $endLevel) {
            $payoutsTable = TableRegistry::get("Payouts");

            $commissionsTable = TableRegistry::get("Commissions");

            $conditions = [
                "Users.id" => $intUserId,
            ];

            $userInfo = $this->find("all", [
                "conditions" => $conditions,
            ])->first();

            if (isset($userInfo->sponsor_id) && !empty($userInfo->sponsor_id)) {
                /*echo '<pre>';

                print_r($userInfo);*/

                $conditions = [
                    "Users.id" => $userInfo->sponsor_id,
                ];

                $sponserInfo = $this->find("all", [
                    "conditions" => $conditions,
                ])->first();

                if ($startLevel == 1 || $currentRank < $sponserInfo->rank) {
                    $rankPercentage = $this->getRankPercentage(
                        $sponserInfo->rank
                    );

                    if (!empty($rankPercentage)) {
                        $commission = $commissionsTable
                            ->find("all", [
                                "conditions" => ["Commissions.status" => 1],
                            ])
                            ->enableAutoFields(true)
                            ->first();

                        $level_income = ($amount * $rankPercentage) / 100;

                        $payout = $payoutsTable->newEmptyEntity();

                        $payout->upagraded_user_id = $sponserInfo->id;

                        $payout->level_income = $level_income;

                        $payout->tax = isset($commission->tax)
                            ? $commission->tax
                            : 0;

                        $payout->admin_commission = isset($commission->amount)
                            ? $commission->amount
                            : 0;

                        $payoutsTable->save($payout);
                    }
                }

                $nextLevel = $startLevel + 1;

                $this->addLevelIncome(
                    $userInfo->sponsor_id,
                    $amount,
                    $nextLevel,
                    $endLevel,
                    $sponserInfo->rank
                );
            }
        }
    }

    public function getRankPercentage($intRank)
    {
        $percentage = 0;

        if ($intRank == 1) {
            $percentage = 2;
        } elseif ($intRank == 2) {
            $percentage = 4;
        } elseif ($intRank == 3) {
            $percentage = 6;
        } elseif ($intRank == 4) {
            $percentage = 8;
        } elseif ($intRank == 5) {
            $percentage = 10;
        } elseif ($intRank == 6) {
            $percentage = 12;
        } elseif ($intRank == 7) {
            $percentage = 14;
        } elseif ($intRank == 8) {
            $percentage = 16;
        } elseif ($intRank == 9) {
            $percentage = 18;
        } elseif ($intRank == 10) {
            $percentage = 20;
        } elseif ($intRank > 10) {
            $percentage = 20;
        }

        return $percentage;
    }

    public function removeFromDownlines($intUserId, $amount)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_table_id" => $intUserId,
        ];

        $downlines = $downlinesTable
            ->find("all", ["conditions" => $conditions])
            ->toArray();

        foreach ($downlines as $downline) {
            $downlineData = $downlinesTable->get($downline->id);

            $downlineData->total_join = $downline->total_join - $amount;

            $downlinesTable->save($downlineData);
        }
    }

    public function makeClubMember($intUserId, $amount)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $conditions = [
            "Downlines.user_table_id" => $intUserId,
        ];

        $downlines = $downlinesTable
            ->find("all", ["conditions" => $conditions])
            ->toArray();

        foreach ($downlines as $downline) {
            $downlineData = $downlinesTable->get($downline->id);

            $downlineData->total_join = $downline->total_join + $amount;

            $downlinesTable->save($downlineData);

            $this->makeGoldClub($downline->user_table_id);

            $this->makePlatinumClub($downline->user_table_id);

            $this->makeAmbrandClub($downline->user_table_id);

            $this->makeDiamondClub($downline->user_table_id);

            $this->makeKingClub($downline->user_table_id);
        }
    }

    public function makeGoldClub($intUserId)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $usersTable = TableRegistry::get("Users");

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.total_join > " => 0,

            "Downlines.position" => "left",
        ];

        $join = [
            [
                "table" => "plot_payments",

                "alias" => "PlotPayments",

                "type" => "INNER",

                "conditions" => [
                    "PlotPayments.user_id = Downlines.user_table_id AND PlotPayments.number_of_unit > 0",
                ],
            ],
        ];

        $leftDownLine = $downlinesTable
            ->find("all", ["conditions" => $conditions, "join" => $join])

            ->select(["total_left_units" => "SUM(PlotPayments.number_of_unit)"])

            ->first();

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.total_join > " => 0,

            "Downlines.position" => "right",
        ];

        $join = [
            [
                "table" => "plot_payments",

                "alias" => "PlotPayments",

                "type" => "INNER",

                "conditions" => [
                    "PlotPayments.user_id = Downlines.user_table_id AND PlotPayments.number_of_unit > 0",
                ],
            ],
        ];

        $rightDownLine = $downlinesTable
            ->find("all", ["conditions" => $conditions, "join" => $join])

            ->select([
                "total_right_units" => "SUM(PlotPayments.number_of_unit)",
            ])

            ->first();

        $totalLeft =
            isset($leftDownLine->total_left_units) &&
            !empty($leftDownLine->total_left_units)
                ? $leftDownLine->total_left_units
                : 0;

        $totalRight =
            isset($rightDownLine->total_right_units) &&
            !empty($rightDownLine->total_right_units)
                ? $rightDownLine->total_right_units
                : 0;

        if ($totalLeft >= 10 && $totalRight >= 10) {
            $userData = $usersTable->get($intUserId);

            $userData->is_mobile_club = 1;

            $usersTable->save($userData);
        }

    }

    public function makePlatinumClub($intUserId)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $usersTable = TableRegistry::get("Users");
        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_id"],
            ],

            [
                "table" => "users",

                "alias" => "DownlineUsers",

                "type" => "INNER",

                "conditions" => ["DownlineUsers.id = Downlines.user_table_id"],
            ],
        ];

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "left",

            "DownlineUsers.is_mobile_club" => 1,
        ];

        $totalLeft = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "right",

            "DownlineUsers.is_mobile_club" => 1,
        ];

        $totalRight = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        //echo $totalLeft.'----'.$totalRight.'<br>';

        if (
            ($totalLeft >= 5 && $totalRight >= 3) ||
            ($totalLeft >= 3 && $totalRight >= 5)
        ) {
            $userData = $usersTable->get($intUserId);

            $userData->is_laptop_club = 1;

            $usersTable->save($userData);
        }
    }

    public function makeAmbrandClub($intUserId)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $usersTable = TableRegistry::get("Users");

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_id"],
            ],

            [
                "table" => "users",

                "alias" => "DownlineUsers",

                "type" => "INNER",

                "conditions" => ["DownlineUsers.id = Downlines.user_table_id"],
            ],
        ];

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "left",

            "DownlineUsers.is_laptop_club" => 1,
        ];

        $totalLeft = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "right",

            "DownlineUsers.is_laptop_club" => 1,
        ];

        $totalRight = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        if (
            ($totalLeft >= 4 && $totalRight >= 3) ||
            ($totalLeft >= 3 && $totalRight >= 4)
        ) {
            $userData = $usersTable->get($intUserId);

            $userData->is_bike_club = 1;

            $usersTable->save($userData);
        }
    }

    public function makeDiamondClub($intUserId)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $usersTable = TableRegistry::get("Users");

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_id"],
            ],

            [
                "table" => "users",

                "alias" => "DownlineUsers",

                "type" => "INNER",

                "conditions" => ["DownlineUsers.id = Downlines.user_table_id"],
            ],
        ];

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "left",

            "DownlineUsers.is_bike_club" => 1,
        ];

        $totalLeft = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "right",

            "DownlineUsers.is_bike_club" => 1,
        ];

        $totalRight = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        if (
            ($totalLeft >= 3 && $totalRight >= 2) ||
            ($totalLeft >= 2 && $totalRight >= 3)
        ) {
            $userData = $usersTable->get($intUserId);

            $userData->is_diamond_club = 1;

            $usersTable->save($userData);
        }
    }

    public function makeKingClub($intUserId)
    {
        $downlinesTable = TableRegistry::get("Downlines");

        $usersTable = TableRegistry::get("Users");

        $join = [
            [
                "table" => "users",

                "alias" => "Users",

                "type" => "INNER",

                "conditions" => ["Users.id = Downlines.user_id"],
            ],

            [
                "table" => "users",

                "alias" => "DownlineUsers",

                "type" => "INNER",

                "conditions" => ["DownlineUsers.id = Downlines.user_table_id"],
            ],
        ];

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "left",

            "DownlineUsers.is_diamond_club" => 1,
        ];

        $totalLeft = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        $conditions = [
            "Downlines.user_id" => $intUserId,

            "Downlines.position" => "right",

            "DownlineUsers.is_diamond_club" => 1,
        ];

        $totalRight = $downlinesTable
            ->find("all", ["join" => $join, "conditions" => $conditions])
            ->count();

        if ($totalLeft >= 2 && $totalRight >= 2) {
            $userData = $usersTable->get($intUserId);

            $userData->is_king_club = 1;

            $usersTable->save($userData);
        }
    }

    public function activateRoyalty($userId)
    {
        $conditions = ["Users.id" => $userId];
        $sponsorInfo = $this->find("all", ["conditions" => $conditions])->enableAutoFields(true)->first();
        if ($sponsorInfo) {
            $conditions = ["Users.sponsor_id" => $sponsorInfo->id];
            $users = $this->find("all", ["conditions" => $conditions])->enableAutoFields(true)->toArray();
            $RoyalTwo = 0;
            $RoyalThree = 0;
            $RoyalFour = 0;
            $RoyalFive = 0;
            $RoyalSix = 0;
            $RoyalSeven = 0;
            $RoyalEight = 0;
            $RoyalNine = 0;
            $RoyalTen = 0;
            $RoyalEleven = 0;
            $RoyalTwelve = 0;
            $RoyalThirteen = 0;
            foreach ($users as $user) {
                if ($this->checkRoyalty($user, 1, $sponsorInfo)) {
                    $RoyalTwo = $RoyalTwo + 1;
                }
                if ($this->checkRoyalty($user, 2, $sponsorInfo)) {
                    $RoyalThree = $RoyalThree + 1;
                }
                if ($this->checkRoyalty($user, 3, $sponsorInfo)) {
                    $RoyalFour = $RoyalFour + 1;
                }
                if ($this->checkRoyalty($user, 4, $sponsorInfo)) {
                    $RoyalFive = $RoyalFive + 1;
                }
                if ($this->checkRoyalty($user, 5, $sponsorInfo)) {
                    $RoyalSix = $RoyalSix + 1;
                }
                if ($this->checkRoyalty($user, 6, $sponsorInfo)) {
                    $RoyalSeven = $RoyalSeven + 1;
                }
                if ($this->checkRoyalty($user, 7, $sponsorInfo)) {
                    $RoyalEight = $RoyalEight + 1;
                }
                if ($this->checkRoyalty($user, 8, $sponsorInfo)) {
                    $RoyalNine = $RoyalNine + 1;
                }
                if ($this->checkRoyalty($user, 9, $sponsorInfo)) {
                    $RoyalTen = $RoyalTen + 1;
                }
                if ($this->checkRoyalty($user, 10, $sponsorInfo)) {
                    $RoyalEleven = $RoyalEleven + 1;
                }
                if ($this->checkRoyalty($user, 11, $sponsorInfo)) {
                    $RoyalTwelve = $RoyalTwelve + 1;
                }
                if ($this->checkRoyalty($user, 12, $sponsorInfo)) {
                    $RoyalThirteen = $RoyalThirteen + 1;
                }
            }

            $objUser = $this->get($sponsorInfo->id);
            if ($RoyalTwo >= 3){
                $objUser->royalty_two = 1;
            }
            if ($RoyalThree >= 3){
                $objUser->royalty_three = 1;
            }
            if ($RoyalFour >= 3){
                $objUser->royalty_four = 1;
            }
            if ($RoyalFive >= 3){
                $objUser->royalty_five = 1;
            }
            if ($RoyalSix >= 3){
                $objUser->royalty_six = 1;
            }
            if ($RoyalSeven >= 3){
                $objUser->royalty_seven = 1;
            }
            if ($RoyalEight >= 3){
                $objUser->royalty_eight = 1;
            }
            if ($RoyalNine >= 3){
                $objUser->royalty_nine = 1;
            }
            if ($RoyalTen >= 3){
                $objUser->royalty_ten = 1;
            }
            if ($RoyalEleven >= 3){
                $objUser->royalty_eleven = 1;
            }
            if ($RoyalTwelve >= 3){
                $objUser->royalty_twelve = 1;
            }
            if ($RoyalThirteen >= 3){
                $objUser->royalty_thirteen = 1;
            }
            $this->save($objUser);
        }
    }

    public function checkRoyalty($objUser, $royaltyLevel, $sponserInfo)
    {
        if ($objUser) {
            if ($royaltyLevel == 1) {
                if ($objUser->royalty_one == 1 && $sponserInfo->royalty_one == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 2) {
                if ($objUser->royalty_two == 1 && $sponserInfo->royalty_two == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 3) {
                if ($objUser->royalty_three == 1 && $sponserInfo->royalty_three == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 4) {
                if ($objUser->royalty_four == 1 && $sponserInfo->royalty_four == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 5) {
                if ($objUser->royalty_five == 1 && $sponserInfo->royalty_five == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 6) {
                if ($objUser->royalty_six == 1 && $sponserInfo->royalty_six == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 7) {
                if ($objUser->royalty_seven == 1 && $sponserInfo->royalty_seven == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 8) {
                if ($objUser->royalty_eight == 1 && $sponserInfo->royalty_eight == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 9) {
                if ($objUser->royalty_nine == 1 && $sponserInfo->royalty_nine == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 10) {
                if ($objUser->royalty_ten == 1 && $sponserInfo->royalty_ten == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 11) {
                if ($objUser->royalty_eleven == 1 && $sponserInfo->royalty_eleven == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }

            if ($royaltyLevel == 12) {
                if ($objUser->royalty_twelve == 1 && $sponserInfo->royalty_twelve == 1) {
                    return true;
                } else {
                    $conditions = ['Users.sponsor_id' => $objUser->id];
                    $user = $this->find('all', ['conditions' => $conditions])->first();
                    $this->checkRoyalty($user, $royaltyLevel, $sponserInfo);
                }
            }
        }
    }

    public function getDownlineIncentiveEligibleAgents($userId, $isGetCount = false)
    {
        $conditions = ['Users.total_today_business >= 20000 AND Users.role_id = 2 AND Users.sponsor_id = "'.$userId.'"'];
        $fields = ['Users.id', 'Users.username', 'Users.name', 'Users.total_today_business'];
        $query = $this->find('all', ['fields' => $fields, 'conditions' => $conditions]);

        if ($isGetCount) {
           $agents = $query->count();
        } else {
            $agents = $query->toArray();
        }

        return $agents;
    }

    public function getDownlineIncentiveEligibleCustomers($userId, $isGetCount = false, $dayBefore = 0)
    {
        $join = [
                    [
                        'table' => 'packages',
                        'alias' => 'Packages',
                        'type' => 'LEFT',
                        'conditions' => ['Packages.user_id = Users.id']
                    ]
                ];
        if($dayBefore > 0) {
            $conditions = ['Users.role_id = 3 AND Users.sponsor_id = "'.$userId.'" AND DATE(Packages.created) = "'.date('Y-m-d', strtotime('now - '.$dayBefore.'day')).'"'];
        } else {
            $conditions = ['Users.role_id = 3 AND Users.sponsor_id = "'.$userId.'" AND DATE(Packages.created) = "'.date('Y-m-d').'"'];
        }
        $group = ['Packages.user_id'];
        $having = ['SUM(Packages.amount) >= 20000'];
        $fields = ['Users.id', 'Users.username', 'Users.name'];
        $query = $this->find('all', ['fields' => $fields, 'join' => $join, 'conditions' => $conditions, 'group' => $group, 'having' => $having])->select(['total_amount' => 'SUM(Packages.amount)']);

        if ($isGetCount) {
           $customers = $query->count();
        } else {
            $customers = $query->toArray();
        }
        
        return $customers;
    }

    public function getUserIdByUsername($username)
    {
        $conditions = ['Users.username' => $username];
        $fields = ['Users.id'];
        $user = $this->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
        $userId = '';
        if ($user) {
            $userId = $user->id;
        }

        return $userId;
    }

    public function payPromotionCommissionToParents($paymentById, $promotionId, $intUserId, $amount, $currentPaidRank = 0, $totalPaidPercentage = 0, $count = 1)
    {
        $promotionPayoutsTable = TableRegistry::get("PromotionPayouts");
        if ($intUserId > 0) {
            $conditions = ["Users.id" => $intUserId];
            $user = $this->find("all", ["conditions" => $conditions])->first();
            if ($user->current_rank == 13) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*4) + (0.25*4));
            } elseif ($user->current_rank == 12) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*4) + (0.25*3));
            } elseif ($user->current_rank == 11) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*4) + (0.25*2));
            } elseif ($user->current_rank == 10) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*4) + (0.25*1));
            } elseif ($user->current_rank == 9) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*4));
            } elseif ($user->current_rank == 8) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*3));
            } elseif ($user->current_rank == 7) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*2));
            } elseif ($user->current_rank == 6) {
                $percentage = (8 + 3 + 2 + (1*2) + (0.5*1));
            } elseif ($user->current_rank == 5) {
                $percentage = (8 + 3 + 2 + (1*2));
            } elseif ($user->current_rank == 4) {
                $percentage = (8 + 3 + 2 + (1*1));
            } elseif ($user->current_rank == 3) {
                $percentage = (8 + 3 + 2);
            } elseif ($user->current_rank == 2) {
                $percentage = (8 + 3);
            } elseif ($user->current_rank == 1) {
                $percentage = 8;
            }
            if ($currentPaidRank < $user->current_rank) {
                $remark = 'Level Income';
                if ($count == 1) {
                    $remark = 'Direct Income';
                }
                $payblePercentage = $percentage - $totalPaidPercentage;
                $promotionPayout = $promotionPayoutsTable->newEmptyEntity();
                $promotionPayout->user_id = $user->id;
                $promotionPayout->promotion_id = $promotionId;
                $promotionPayout->payment_by_id = $paymentById;
                if ($count == 1) {
                    $promotionPayout->direct_income = ($amount * $payblePercentage)/100;
                } else {
                    $promotionPayout->level_income = ($amount * $payblePercentage)/100;
                }
                $promotionPayout->current_rank = $user->current_rank;
                $promotionPayout->remark = $remark;
                $promotionPayout->status = 0;
                $promotionPayoutsTable->save($promotionPayout);
                $currentPaidRank = $user->current_rank;
                $totalPaidPercentage = $totalPaidPercentage + $payblePercentage;
            }
            if ($user->sponsor_id && $user->current_rank < 13) {
                $count = $count + 1;
                $this->payPromotionCommissionToParents($paymentById, $promotionId, $user->sponsor_id, $amount, $currentPaidRank, $totalPaidPercentage, $count);
            }
        }
    }
}
