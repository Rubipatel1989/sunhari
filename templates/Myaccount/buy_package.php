<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Buy Package
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                         <div class="col-xs-12 nopadding">
                          <legend>Our Packges</legend>
                          <div class="col-xs-12 nopadding margin-top-15">
                            <?php
                            if(!empty($packages)){?>
                              <ul class="package-list">
                                <?php
                                $i = 1;
                                foreach($packages as $package){
                                  $background_color = '1C75BF';
                                  $color = 'fff';
                                  if(!empty($package->background_color)){
                                    $background_color = $package->background_color;
                                  }
                                  if(!empty($package->color)){
                                    $color = $package->color;
                                  }
                                ?>
                                  <li>
                                    <div class="col-xs-12 nopadding text-center">
                                      <div class="col-xs-12 nopadding package-name" style="background-color: #<?php echo $background_color; ?>; color: #<?php echo $color; ?>; border-top:1px solid #<?php echo $background_color; ?>; border-left:1px solid #<?php echo $background_color; ?>; border-right:1px solid #<?php echo $background_color; ?>;">
                                        <span class="srno"><?php echo $i; ?></span>
                                        <h2 style="color: #<?php echo $color; ?>"><?php echo $package->name; ?></h2>
                                        <div class="bottom-angle" style="border-top: solid 50px #<?php echo $background_color; ?>;">bottom Angle</div>
                                      </div>
                                      <div class="col-xs-12 text-center package-info-container">
                                        <div class="col-xs-12 btc-info">
                                          <!--<span class="package-currency">Rs</span><?php echo number_format($package->package_bv, 2); ?>-->
                                        </div>
                                        <div class="col-xs-12 grey-top-strip-1 margin-top-1"></div>
                                        <div class="col-xs-12 nopadding margin-top-10 text-center">
                                          <div class="package-img-container">
                                            <?php
                                            $file = $home_url.'/frontend/img/btc.jpg';
                                            if($package->Attachments['file'] != ''){
                                              $file = $home_url.'/attachments/'.$package->Attachments['file'];
                                            }
                                            ?>
                                            <img src="<?php echo $file;?>" class="img-responsive" style="border-radius: 50%;">
                                          </div>
                                        </div>
                                        <!--<div class="col-xs-12 nopadding margin-top-10">
                                          <span class="package-currency">Rs</span><?php echo number_format($package->package_amount, 8); ?>
                                          <br> <span class="amount-label">Package Amount</span>
                                        </div>
                                        <div class="col-xs-12 grey-top-strip-1 margin-top-10"></div>
                                         <div class="col-xs-12 nopadding margin-top-10">
                                            <span class="package-currency">Rs</span><?php echo number_format($package->direct_amount, 8); ?>
                                            <br> <span class="amount-label">Direct Amount</span>
                                        </div>-->
                                        <!-- <div class="col-xs-12 grey-top-strip-1 margin-top-10"></div>
                                        <div class="col-xs-12 nopadding margin-top-20">
                                          <a href="<?php echo $home_url; ?>/ajax/view_package_details/<?php echo base64_encode($package->id);?>" class="view_package_details_link fancybox.ajax btn_packages"  style="background-color: #<?php echo $background_color; ?>; color: #<?php echo $color; ?>;">View Details</a>
                                        </div> -->
                                      </div>
                                    </div>
                                  </li>
                                <?php
                                  $i++;
                                }?>
                              </ul>
                            <?php
                            }?>
                          </div>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>