<?= $this->Html->css('coupon.css') ?>

<div class="coupon-top-cotainer">
  <div style="background-image: url(<?php echo $home_url ?>/frontend/img/coupon_bg_bottom_blue.jpg);" class="coupon-bg">
    <div class="coupon-details">
      <div>
        <strong>Date : </strong> <?php echo date("d M Y", strtotime($couponInfo->created)); ?>
      </div>
      <div style="white-space: nowrap;">
        <strong>Coupon No. : </strong> <?php echo $couponInfo->coupon_code; ?>
      </div>
      <div>
        <strong>Coupon Amount : </strong> <?php echo number_format($this->UserData->getPlanAmountWithGSTById($couponInfo->Promotions['plan_id'])); ?>
      </div>
      <div>
        <strong>Name : </strong> <?php echo $couponInfo->Users['name']; ?>
      </div>
      <div>
        <strong>Customer Id : </strong> <?php echo $couponInfo->Users['username']; ?>
      </div>
      <div>
        <strong>Mobile No. : </strong> <?php echo $couponInfo->Users['contact_number']; ?>
      </div>
      <div>
        <strong>Sponsor Id : </strong> <?php echo $couponInfo->Sponsors['username']; ?>
      </div>
      <div>
        <strong>Sponsor Name : </strong> <?php echo $couponInfo->Sponsors['name']; ?>
      </div>
    </div>
  </div>
</div>