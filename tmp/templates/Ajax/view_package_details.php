<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,800" rel="stylesheet">
<?php echo $this->Html->css('backend/css/bootstrap.css'); ?>
<?php echo $this->Html->css('frontend/css/common.css'); ?>
<?php echo $this->Html->css('frontend/css/popup.css'); ?>
<?php
//echo '<pre>';
//print_r($bitcoin);
?>
<div class="col-xs-12 package-popup" style="max-width: 500px;">
	<div class="col-xs-12 nopadding package-popup-head">
		<h2>Package Details</h2>
	</div>
	<div class="col-xs-12 nopadding margin-top-10">
		<div class="col-xs-4 padding-left-0 padding-right-20 ">
			Amount 
		</div>
		<div class="col-xs-8 nopadding">
			$ <?php echo number_format($package->package_amount, 8); ?>
		</div>
	</div>
	<div class="col-xs-12 nopadding grey-top-strip-1 margin-top-10"></div>
	<div class="col-xs-12 nopadding margin-top-10">
		<div class="col-xs-4 padding-left-0 padding-right-10">
			BTC Address 
		</div>
		<div class="col-xs-8 nopadding">
			<?php echo $bitcoin->address; ?>
		</div>
	</div>
	<div class="col-xs-12 nopadding grey-top-strip-1 margin-top-13"></div>
	<div class="col-xs-12 nopadding margin-top-10">
		<div class="col-xs-4 padding-left-0 padding-right-10">
			QR Code
		</div>
		<div class="col-xs-8 nopadding">
			<img src="<?php echo $home_url; ?>/attachments/<?php echo $bitcoin->Attachments['file']; ?>" alt="<?php echo $bitcoin->Attachments['caption']; ?>" class="img-responsive">
		</div>
	</div>
</div>