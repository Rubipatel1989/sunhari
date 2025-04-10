<?php
namespace App\View\Helper;

use Cake\View\Helper;

class UserDataHelper extends Helper
{
    public function getRankList()
    {
        return [
           '' => '-Select-',
          '1' => 'Grade 1',
          '2' => 'Grade 2',
          '3' => 'Grade 3',
          '4' => 'Grade 4',
          '5' => 'Grade 5',
          '6' => 'Grade 6',
          '7' => 'Grade 7',
          '8' => 'Grade 8',
          '9' => 'Grade 9',
          '10' => 'Grade 10',
          '11' => 'Grade 11',
          '12' => 'Grade 12',
          '13' => 'Club',
        ];
    }

    public function getRankLabelById($rankId)
    {
        $rankLabel = '';
        if ($rankId == 1) {
            $rankLabel = 'Grade 1';
        } elseif ($rankId == 2) {
            $rankLabel = 'Grade 2';
        } elseif ($rankId == 3) {
            $rankLabel = 'Grade 3';
        } elseif ($rankId == 4) {
            $rankLabel = 'Grade 4';
        } elseif ($rankId == 5) {
            $rankLabel = 'Grade 5';
        } elseif ($rankId == 6) {
            $rankLabel = 'Grade 6';
        } elseif ($rankId == 7) {
            $rankLabel = 'Grade 7';
        } elseif ($rankId == 8) {
            $rankLabel = 'Grade 8';
        } elseif ($rankId == 9) {
            $rankLabel = 'Grade 9';
        } elseif ($rankId == 10) {
            $rankLabel = 'Grade 10';
        } elseif ($rankId == 11) {
            $rankLabel = 'Grade 11';
        } elseif ($rankId == 12) {
            $rankLabel = 'Grade 12';
        } elseif ($rankId == 13) {
            $rankLabel = 'Club';
        }

        return $rankLabel;
    }

    public function getPlanListDdl() {
        return [
            '' => '-Select-',
            1 => '2.5 k',
            2 => '5 k',
            3 => '7.5 k',
            4 => '10 k',
        ];
    }

    public function getPlanList() {
        return [
            1 => '2.5 k',
            2 => '5 k',
            3 => '7.5 k',
            4 => '10 k',
        ];
    }

    public function getPlanTitleById($planId) {
        if ($planId == 1) {
            $planTitle = '2.5 k';
        } elseif ($planId == 2) {
            $planTitle = '5 k';
        } elseif ($planId == 3) {
            $planTitle = '7.5 k';
        } elseif ($planId == 4) {
            $planTitle = '10 k';
        } else {
            $planTitle = '';
        }

        return $planTitle;
    }

    public function getPlanPrefixById($planId) {
        if ($planId == 1) {
            $planPrefix = 25;
        } elseif ($planId == 2) {
            $planPrefix = 50;
        } elseif ($planId == 3) {
            $planPrefix = 75;
        } elseif ($planId == 4) {
            $planPrefix = 100;
        } else {
            $planPrefix = '';
        }

        return $planPrefix;
    }

    public function getAllowedCouponsCount($amount) {
        if ($amount == 2500) {
            $allowedCoupons = 1;
        } elseif ($amount == 5000) {
            $allowedCoupons = 3;
        } elseif ($amount == 7500) {
            $allowedCoupons = 5;
        } elseif ($amount >= 10000) {
            $allowedCoupons = 7;
        } else {
            $allowedCoupons = 0;
        }

        return $allowedCoupons;
    }

    public function getPlanAmountById($planId) {
        if ($planId == 1) {
            $planAmount = 2500;
        } elseif ($planId == 2) {
            $planAmount = 5000;
        } elseif ($planId == 3) {
            $planAmount = 7500;
        } elseif ($planId == 4) {
            $planAmount = 10000;
        } else {
            $planAmount = 0;
        }

        return $planAmount;
    }

    public function getPlanAmountWithGSTById($planId) {
        if ($planId == 1) {
            $planAmount = 2950;
        } elseif ($planId == 2) {
            $planAmount = 5900;
        } elseif ($planId == 3) {
            $planAmount = 8850;
        } elseif ($planId == 4) {
            $planAmount = 11800;
        } else {
            $planAmount = 0;
        }

        return $planAmount;
    }
}
