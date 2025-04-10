<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Plot Payment
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
                          <form name="plot_payment_form"  id="plot_payment_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Payments Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Username<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select User-'];
                                      foreach($users as $user){
                                        $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                      }
                                      //echo $this->Form->input('PlotPayment.user_id', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'data-live-search' => "true", 'onchange' => 'filterPlotPaymentsByUser(this.value, "plot_container", "PlotPayment.assign_plot_id", "form-control loginbox");')); 
                                      echo $this->Form->input('PlotPayment.user_id', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'data-live-search' => "true", 'onchange' => 'return checkUserPayment(this);')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                             <!--  <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plot<span class="red">*</span></label>
                                   <div id="plot_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Polt-'];
                                      echo $this->Form->input('PlotPayment.assign_plot_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <fieldset id="number_of_unit_container" style="display: none;">
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Number of Unit<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.number_of_unit', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of Unit')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Amount<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Payment Mode<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-', 'Cheque' => 'Cheque', 'UPI' => 'UPI', 'Cash' => 'Cash'];
                                      echo $this->Form->input('PlotPayment.payment_mode', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return showPaymentsFields(this);')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <div id="cheque_container" class="payment-fields-container" style="display: none;">
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Bank<span class="red">*</span></label>
                                     <div id="block_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.bank', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Cheque Number<span class="red">*</span></label>
                                     <div id="block_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.cheque_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Cheque Number')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                               <div id="upi_container" class="payment-fields-container" style="display: none;">
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Transaction ID<span class="red">*</span></label>
                                     <div class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.transaction_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Transaction ID')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                              <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Date<span class="red">*</span></label>
                                     <div class="col-sm-4 height-37">
                                        <div class="dob input-group date">
                                          <?php echo $this->Form->input('PlotPayment.amount_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "Date")); ?>
                                          <span class="input-group-addon">
                                             <span class="fa fa-calendar"></span>
                                          </span>
                                        </div>
                                     </div>
                                  </div>
                                </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/plot-payment-list" class="btn btn-square btn-danger">Cancel</a>
                                  </div>
                                </div>
                              </fieldset>
                          </form>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>