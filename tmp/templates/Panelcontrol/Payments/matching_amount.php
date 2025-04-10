<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($cashingAmount);
?>
<h3>
  <div class="pull-right text-center">
    
  </div>
  Matching Amount
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
                        <?php echo $this->Form->create(NULL, array('id' => 'add_matching_amount_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <legend>Matching Amount</legend>
                            <fieldset>
                              <div class="form-group margin-top-15">
                                <label class="col-sm-2 control-label">From Date<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <div class="dob input-group date">
                                    <?php echo $this->Form->input('Payout.from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date")); ?>
                                    <span class="input-group-addon">
                                      <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-2 control-label">To Date<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <div class="dob input-group date">
                                    <?php echo $this->Form->input('Payout.to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "To Date")); ?>
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
                                    &nbsp; <a href="<?php echo $backend_url ?>/payments/calculation" class="btn btn-square btn-danger">Cancel</a>
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