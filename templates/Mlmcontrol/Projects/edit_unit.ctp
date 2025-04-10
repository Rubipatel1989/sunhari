<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Edit Unit
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
                            <legend>Unit Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">User<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $plotPaymentInfo->Users['username'].' ('.$plotPaymentInfo->Details['first_name'].' '.$plotPaymentInfo->Details['last_name'].')';; 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                               <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Amount<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo number_format($plotPaymentInfo->amount, 2); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset id="number_of_unit_container" >
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Number of Unit<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.number_of_unit', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of Unit', 'value' => $plotPaymentInfo->number_of_unit)); 
                                       ?>
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