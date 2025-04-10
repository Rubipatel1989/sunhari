<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class PayoutsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function saveLegIncomce($autoPool, $usersType) {
        $autoPoolsTable = TableRegistry::get('AutoPools');

        $fields = ['AutoPools.id', 'AutoPools.user_id'];
        if($usersType == 'previousUsers') {
            $conditions = ['AutoPools.id <' => $autoPool->id];
        } else {
            $conditions = ['AutoPools.id >' => $autoPool->id];
        }
        $order = ['AutoPools.id'];
        $limit = 10;
        $autoPools = $autoPoolsTable->find('all', array('fields' => $fields, 'conditions' => $conditions, 'order' => $order, 'limit' => $limit))
        ->select(
            [
                'royal_amount_count' => '(SELECT COUNT(p.id) FROM payouts p WHERE p.upgraded_table_id = '.$autoPool->user_id.' AND p.upagraded_user_id = AutoPools.user_id AND p.royalty_amount > 0 AND p.status=0)'
            ])
        ->toArray();
        $legIncome = $autoPool->total_matching_amount/40;
        foreach($autoPools as $autoPoolData) {
            if($autoPoolData->royal_amount_count == 0) {
                $payOutData = $this->newEmptyEntity();
                $payOutData->upgraded_table_id = $autoPool->user_id;
                $payOutData->upagraded_user_id = $autoPoolData->user_id;
                $payOutData->royalty_amount = $legIncome;
                $payOutData->status = 0;
                $this->save($payOutData);
            }
        }
    }

    public function addLevelAmount($userId, $fixedFromId, $roiAmount, $level, $dayCount) {
        $usersTable = TableRegistry::get('Users');
        $conditions = ['Users.id' => $userId];
        $fields = ['Users.id', 'Users.sponsor_id'];
        $userData = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])
        ->select([
            'totalUpgradedDirect' => '(SELECT COUNT(u.id) FROM upgrades u INNER JOIN users u1 ON (u1.id = u.upgraded_id AND u1.sponsor_id = Users.sponsor_id))',
            'selfUpgraded' => '(SELECT COUNT(u.id) FROM upgrades u WHERE u.upgraded_id = Users.sponsor_id)'
        ])->first();
        if($level < 52 && $userData->sponsor_id) {
            if ($level == 1 && $userData->totalUpgradedDirect >= 1) {
                $levelPercentage = 20;
            } elseif ($level == 2 && $userData->totalUpgradedDirect >= 2) {
                $levelPercentage = 15;
            } elseif ($level == 3 && $userData->totalUpgradedDirect >= 3) {
                $levelPercentage = 10;
            } elseif ($level == 4 && $userData->totalUpgradedDirect >= 4) {
                $levelPercentage = 5;
            } elseif (($level >= 5 && $level <= 20) && $userData->totalUpgradedDirect >= 5) {
                $levelPercentage = 2;
            } elseif (($level >= 21 && $level <= 30) && $userData->totalUpgradedDirect >= 6) {
                $levelPercentage = 1;
            } elseif (($level >= 31 && $level <= 50) && $userData->totalUpgradedDirect >= 7) {
                $levelPercentage = 0.5;
            } elseif (($level == 51) && $userData->totalUpgradedDirect == 8) {
                $levelPercentage = 1;
            }
            if($userData->selfUpgraded > 0 && isset($levelPercentage)) {
                $levelAmount = ($roiAmount * $levelPercentage)/100;
                $remainingAmount = $this->getRemainingAmount($userData->sponsor_id);
                $isDeactivate = 0;
                $payableLevelAmount = $levelAmount;
                if($levelAmount > $remainingAmount) {
                    $payableLevelAmount = $remainingAmount;
                    $isDeactivate = 1;
                }
                if ($payableLevelAmount > 0) {
                    $payout = $this->newEmptyEntity();
                    $payout->upagraded_user_id  = $userData->sponsor_id;
                    $payout->level_income       = $payableLevelAmount;
                    $payout->tax                = 5;
                    $payout->admin_commission   = 5;
                    $payout->level_income_by    = $fixedFromId;
                    $payout->level_count        = (int) $level;
                    $payout->level_roi          = $roiAmount;
                    $payout->day_count          = $dayCount;
                    $this->save($payout);
                    if ($isDeactivate) {
                        $this->deactivePackages($userData->sponsor_id);
                    }
                }
            }

            $conditions = ['Users.id' => $userData->id];
            $fields = ['Users.id', 'Users.sponsor_id'];
            $sponserData = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])
            ->first();
            if ($sponserData) {
                $nextLevel = $level + 1;
                if (isset($sponserData->sponsor_id) && $sponserData->sponsor_id) {
                    $this->addLevelAmount($sponserData->sponsor_id, $fixedFromId, $roiAmount, $nextLevel, $dayCount);
                }
            }
        }

        return true;

    }

    public function addOldLevelAmount($userId, $fixedFromId, $roiAmount, $level, $dayCount, $created) {
        $usersTable = TableRegistry::get('Users');
        $conditions = ['Users.id' => $userId];
        $fields = ['Users.id', 'Users.sponsor_id'];
        $userData = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])
        ->select([
            'totalUpgradedDirect' => '(SELECT COUNT(u.id) FROM upgrades u INNER JOIN users u1 ON (u1.id = u.upgraded_id AND u1.sponsor_id = Users.sponsor_id))',
            'selfUpgraded' => '(SELECT COUNT(u.id) FROM upgrades u WHERE u.upgraded_id = Users.sponsor_id)'
        ])->first();
        if($level < 52 && $userData->sponsor_id) {
            if ($level == 1 && $userData->totalUpgradedDirect >= 1) {
                $levelPercentage = 20;
            } elseif ($level == 2 && $userData->totalUpgradedDirect >= 2) {
                $levelPercentage = 15;
            } elseif ($level == 3 && $userData->totalUpgradedDirect >= 3) {
                $levelPercentage = 10;
            } elseif ($level == 4 && $userData->totalUpgradedDirect >= 4) {
                $levelPercentage = 5;
            } elseif (($level >= 5 && $level <= 20) && $userData->totalUpgradedDirect >= 5) {
                $levelPercentage = 2;
            } elseif (($level >= 21 && $level <= 30) && $userData->totalUpgradedDirect >= 6) {
                $levelPercentage = 1;
            } elseif (($level >= 31 && $level <= 50) && $userData->totalUpgradedDirect >= 7) {
                $levelPercentage = 0.5;
            } elseif (($level == 51) && $userData->totalUpgradedDirect == 8) {
                $levelPercentage = 1;
            }
            if($userData->selfUpgraded > 0 && isset($levelPercentage)) {
                $levelAmount = ($roiAmount * $levelPercentage)/100;
                $remainingAmount = $this->getRemainingAmount($userData->sponsor_id);
                $isDeactivate = 0;
                $payableLevelAmount = $levelAmount;
                if($levelAmount > $remainingAmount) {
                    $payableLevelAmount = $remainingAmount;
                    $isDeactivate = 1;
                }
                $payout = $this->newEmptyEntity();
                $payout->upagraded_user_id  = $userData->sponsor_id;
                $payout->level_income       = $payableLevelAmount;
                $payout->tax                = 5;
                $payout->admin_commission   = 5;
                $payout->level_income_by    = $fixedFromId;
                $payout->level_count        = (int) $level;
                $payout->level_roi          = $roiAmount;
                $payout->day_count          = $dayCount;
                $payout->created            = $created;
                $payout->modified           = $created;
                $this->save($payout);
                if ($isDeactivate) {
                    $this->deactivePackages($userData->sponsor_id);
                }
            }

            $conditions = ['Users.id' => $userData->id];
            $fields = ['Users.id', 'Users.sponsor_id'];
            $sponserData = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])
            ->first();
            if ($sponserData) {
                $nextLevel = $level + 1;
                if (isset($sponserData->sponsor_id) && $sponserData->sponsor_id) {
                    $this->addOldLevelAmount($sponserData->sponsor_id, $fixedFromId, $roiAmount, $nextLevel, $dayCount, $created);
                }
            }
        }

        return true;
    }

    public function getTotalPayoutAmount($userId) {

        $conditions = ['Payouts.upagraded_user_id' => $userId];
        $payOutInfo = $this->find('all', ['conditions' => $conditions])
        ->select([
            'totalDirectAmount' => 'SUM(Payouts.direct_amount)',
            'totalRoyaltyAmount' => 'SUM(Payouts.royalty_amount)',
            'totalRoiAmount' => 'SUM(Payouts.roi)',
            'totalLevelAmount' => 'SUM(Payouts.level_income)'
        ])
        ->first();
        $totalPayout = 0;
        if ($payOutInfo) {
            $totalPayout = $payOutInfo->totalDirectAmount + $payOutInfo->totalRoyaltyAmount + $payOutInfo->totalRoiAmount + $payOutInfo->totalLevelAmount;
        }

        return $totalPayout;
    }

    public function getRemainingAmount($userId) {
        $usersTable = TableRegistry::get('Users');

        $totalPayout = $this->getTotalPayoutAmount($userId);

        $conditions = ['Users.id' => $userId];
        $fields = ['Users.total_direct_active', 'Users.total_self_business'];
        $userData = $usersTable->find('all', ['fields' => $fields, 'conditions' => $conditions])->first();
        $totalSelfBusiness = $userData->total_self_business;
        if($userData->total_direct_active > 0 || $totalSelfBusiness >= 10000) {
            $multiplier = 3;
        } elseif($totalSelfBusiness >= 1 && $totalSelfBusiness < 1000) {
            $multiplier = 2;
        } elseif($totalSelfBusiness >= 1000 && $totalSelfBusiness < 10000) {
            $multiplier = 2.5;
        } else {
            $multiplier = 2;
        }
        $totalPayableAmount = ($totalSelfBusiness*$multiplier);
        $remainingAmount = $totalPayableAmount - $totalPayout;

        return $remainingAmount;
    }

    public function deactivePackages($userId) {
        $upgradesTable = TableRegistry::get('Upgrades');
        $upgradesTable->updateAll(["status" => 1], ["upgraded_id" => $userId]);
    }
}