<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($cashingAmount);
?>
<h3>
  <div class="pull-right text-center">
    
  </div>
  Payment Calculation
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <form name="add_bitcoin_form"  id="add_bitcoin_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Payment Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Username<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      $options = ['' => '-Select-'];
                                      foreach($users as $user){
                                        $options[$user->username] = $user->username;
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Payout.username', array('type' => 'select', 'id' => 'payment_by_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <?php
                              if(!empty($userInfo)){?>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Current Pair</label>
                                     <?php 
                                     //echo '<pre>';
                                     //print_r($binary);

                                     ?>
                                     <div class="col-sm-8 height-37 text-25">
                                        <?php 
                                        if($userInfo->total_active_left < $userInfo->total_active_right){
                                          $minActive = $userInfo->total_active_left;
                                        }else{
                                          $minActive = $userInfo->total_active_right;
                                        }
                                        if(isset($binary->type) && !empty($binary->type) && $binary->type == 1){
                                          $perMinActive = ($minActive*$binary->percentage)/100;
                                        }else{
                                          $perMinActive = $binary->amount;
                                        }
                                        if($perMinActive < $cashingAmount->sum){
                                          $currentPair = $perMinActive;
                                        }else{
                                          $currentPair = 30;
                                        }
                                        echo 'BTC '.number_format($currentPair, 8);
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Previous pair</label>
                                     <div class="col-sm-8 height-37 text-25">
                                        <?php
                                        echo 'BTC '.number_format($userInfo->previous_pair, 8);
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Pair</label>
                                     <div class="col-sm-8 height-37 text-25">
                                        <?php
                                        echo 'BTC '.number_format(($currentPair - $userInfo->previous_pair), 8);
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Cashing Amount</label>
                                     <div class="col-sm-8 height-37 text-25">
                                        <?php
                                        $cashingAmountShow = 0;
                                        if(isset($cashingAmount->sum) && $cashingAmount->sum < 30){
                                          $cashingAmountShow = $cashingAmount->sum;
                                        }
                                        elseif(isset($cashingAmount->sum) && $cashingAmount->sum >= 30){
                                          $cashingAmountShow = 30;
                                        }
                                        echo 'BTC '.number_format(($cashingAmountShow), 8);
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Actual Pair Amount</label>
                                     <div class="col-sm-8 height-37 text-25">
                                        <?php
                                        echo 'BTC '.number_format(($perMinActive), 8);
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                        &nbsp; <a href="<?php echo $backend_url ?>/payments/calculation" class="btn btn-square btn-danger">Cancel</a>
                                    </div>
                                  </div>
                                </fieldset>
                              <?php
                              }?>
                          </form>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>