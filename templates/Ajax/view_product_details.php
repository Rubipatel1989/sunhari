<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,800" rel="stylesheet">
<?php echo $this->Html->css('backend/css/bootstrap.css'); ?>
<?php echo $this->Html->css('frontend/css/common.css'); ?>
<?php echo $this->Html->css('frontend/css/popup.css'); ?>
<?php echo $this->Html->css('frontend/css/form-validation-style-common.css'); ?>

<?php echo $this->Html->script($home_url.'/assests/jquery/dist/jquery.min.js'); ?>
<?php echo $this->Html->script('frontend/jquery.validate.min.js'); ?>
<?php echo $this->Html->script('frontend/additional-methods.js'); ?>
<?php echo $this->Html->script('frontend/popup.js'); ?>
<?php
/*echo '<pre>';
print_r($product);*/
?>
<div class="col-xs-12 package-popup" style="max-width: 500px;">
	<div class="col-xs-12 nopadding package-popup-head">
		<h2>Product Details</h2>
	</div>
	<div class="col-xs-12 nopadding">
      <?php echo html_entity_decode($this->Flash->render()); ?>
    </div>
	<div class="col-xs-12 nopadding margin-top-10">
		<div class="col-xs-4 padding-left-0 padding-right-20 ">
			<div class="col-xs-12 product-det-img-container"> 
				<?php
                $file = $home_url.'/frontend/img/btc.jpg';
                if($product->Attachments['file'] != ''){
                  $file = $home_url.'/attachments/'.$product->Attachments['file'];
                }
                ?>
                <img src="<?php echo $file;?>" class="img-responsive">
			</div>
		</div>
		<div class="col-xs-8 nopadding">
			<div class="col-xs-12 nopadding">
				<h2 class="product-name"><?php echo $product->name;?></h2>
			</div>
			<div class="col-xs-12 nopadding product-description margin-top-15 text-20">
				<?php
	            if(!empty($product->discount_price)){?>
	                <span class="primary-price"><span class="package-currency">Rs</span><?php echo number_format($product->price, 2); ?></span>
	                <span class="final-price"><span class="package-currency">Rs</span><?php echo number_format($product->discount_price, 2); ?></span>
	            <?php
	            }else{?>
	                <span class="package-currency">Rs</span><?php echo number_format($product->price, 2); ?>
                <?php
               }?>
			</div>
			<div class="col-xs-12 grey-top-strip-2 margin-top-10 height-1">&nbsp;</div>
			<div class="col-xs-12 nopadding margin-top-10 text-20">
				<?php
				$stock = $product->quantity - $totalSoldQuantity;
				if($stock <= 0){?>
					<span class="out-of-stock">Out Of Stock</span>
				<?php
				}else{?>
					<span class="in-stock">In Stock</span>
				<?php
				}?>
			</div>
			<div class="col-xs-12 grey-top-strip-2 margin-top-10 height-1">&nbsp;</div>
			<div .class="col-xs-12 nopadding margin-top-10">
				<?php echo html_entity_decode($product->description);?>
			</div>
			<div class="col-xs-12 grey-top-strip-2 margin-top-10 height-1">&nbsp;</div>
			<div class="col-xs-12 nopadding margin-top-10">
				Business Volume : <strong><?php echo $product->business_volume; ?></strong>
			</div>
			<div class="col-xs-12 nopadding margin-top-4">
				Business Point : <strong><?php echo $product->business_point; ?></strong>
			</div>
			<?php
			if($stock >= 0){?>
				<div class="col-xs-12 nopadding margin-top-15">
					<?php echo $this->Form->create(NULL, array('name' => 'add_to_cart_form', 'id' => 'add_to_cart_form'));?>
						<?php echo $this->Form->input('Cart.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'First Name', 'value' => $product->id, ));  ?>
						<div class="col-xs-12 nopadding">
							<div class="col-xs-3 nopadding margin-top-7 nowrap">
								<strong>Qunatity : </strong>
							</div>
							<div class="col-xs-4 nopadding height-40">
								<?php echo $this->Form->input('Cart.quantity', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Quantity', 'value' => 1));  ?>
							</div>
						</div>
						<div class="col-xs-12 nopadding margin-top-20">
							<button name="btn_cart" type="submit" class="btn_buy">Add to Cart</button>
						</div>
					<?php echo $this->Form->end();?>
				</div>
			<?php
			}?>
		</div>
	</div>
	
</div>