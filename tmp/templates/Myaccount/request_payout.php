<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Request Payout
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
                          <?php echo $this->Form->create(NULL, array('id' => 'request_payout_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>Payout Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Payout Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 text-20 margin-top-5">
                                      $ 
                                      <?php 
                                      $payoutAmout = isset($payments[0]['net_amount']) ? $payments[0]['net_amount'] : 0;
                                      echo number_format($payoutAmout, 8);
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Paid Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 text-20 margin-top-5">
                                      $ 
                                      <?php 
                                      $paidAmount = isset($payments[0]['paid_amount']) ? $payments[0]['paid_amount'] : 0;
                                      echo number_format($paidAmount, 8);
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Requested Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 text-20 margin-top-5">
                                      $ 
                                      <?php 
                                      $requestedAmount = isset($payments[0]['requested_amount']) ? $payments[0]['requested_amount'] : 0;
                                      echo number_format($requestedAmount, 8);
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Available Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 text-20 margin-top-5">
                                      $ 
                                      <?php 
                                      $withdrawAmount = isset($payments[0]['withdraw_amount']) ? $payments[0]['withdraw_amount'] : 0;
                                      $availableAmount = $payoutAmout - $withdrawAmount;
                                      echo number_format($availableAmount, 8);
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Request Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Payment.requested_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Request Amount')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark<span class="red">*</span></label>
                                   <div class="col-sm-8" style="height:100px;">
                                      <?php echo $this->Form->input('Payment.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_transfer_fund" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $home_url ?>/my-account/wallet/amount-transfered" class="btn btn-square btn-danger">Cancel</a>
                                  </div>
                                </div>
                              </fieldset>
                          <?php echo $this->Form->end();?>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>