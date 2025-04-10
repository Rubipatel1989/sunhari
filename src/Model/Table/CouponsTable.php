<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class CouponsTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function generateCoupons($userId, $promotionId, $allowedCouponsCount, $planPrefix, $counter = 0)
    {
        if ($allowedCouponsCount > $counter) {
            $couponCode = $planPrefix.$this->generateCouponCode(7);
            $conditions = ['Coupons.coupon_code' => $couponCode];
            $checkCoupon = $this->find('all', ['conditions' => $conditions])->count();
            if (!$checkCoupon) {
                $coupon = $this->newEmptyEntity();
                $coupon->user_id = $userId;
                $coupon->promotion_id = $promotionId;
                $coupon->coupon_code = $couponCode;
                $this->save($coupon);
                $counter = $counter + 1;
            }
            $this->generateCoupons($userId, $promotionId, $allowedCouponsCount, $planPrefix, $counter);
        }

    }

    public function generateCouponCode($length)
    {
        $finalTransactionId = '';
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890ADFVSS58479865321';
        $transactionId = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $transactionId[] = $alphabet[$n];
        }
        return implode($transactionId);
    }
}