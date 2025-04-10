<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,800" rel="stylesheet">
<?php echo $this->Html->css('backend/css/bootstrap.css'); ?>
<?php echo $this->Html->css('frontend/css/common.css'); ?>
<?php echo $this->Html->css('frontend/css/popup.css'); ?>
<?php
//echo '<pre>';
//print_r($bitcoin);
?>
<div class="col-xs-12 package-popup">
  <div class="col-xs-12 nopadding package-popup-head">
    <h2>Referral Link</h2>
  </div>
  <div class="col-xs-12 nopadding margin-top-10">
    <div class="col-xs-12 nopadding">
      <strong>Left : </strong>
    </div>
    <div class="col-xs-12 nopadding">
      <a href="<?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/left"><?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/left</a>
    </div>
  </div>
  <div class="col-xs-12 nopadding grey-top-strip-1 margin-top-10"></div>
  <div class="col-xs-12 nopadding margin-top-10">
    <div class="col-xs-12 nopadding">
     <strong>Right : </strong>
    </div>
    <div class="col-xs-12 nopadding">
      <a href="<?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/right"><?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/right</a>
    </div>
  </div>
</div>