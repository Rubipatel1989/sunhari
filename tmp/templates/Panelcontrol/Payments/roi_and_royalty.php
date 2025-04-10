<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($cashingAmount);
?>
<h3>
  <div class="pull-right text-center">
    
  </div>
  ROI & Royalty
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
                        <?php echo $this->Form->create(NULL, array('id' => 'add_roi_and_royalty_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <legend>ROI & Royalty</legend>
                            <fieldset>
                              <div class="form-group margin-top-15">
                                <label class="col-sm-3 control-label">Month<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  $options = ['' => '-Select-'];
                                  foreach($months as $monthKey => $monthName){
                                    $options[$monthKey] = $monthName;
                                  }

                                  echo $this->Form->input('Payout.month', array('type' => 'select', 'id' => 'roi_and_rolaylty_by_month', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Total B.V.<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.business_value', array('type' => 'text', 'id' => 'total_bv', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.percentage', array('type' => 'text', 'id' => 'percentage', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Tatal Business Point<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.buiness_point', array('type' => 'text', 'id' => 'total_business_point', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => 0, 'readonly' => 'readonly')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 50 lakhs<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_50_lakhs', array('type' => 'text', 'id' => 'above_50_lakhs', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>

                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 2 crore<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_2_crore', array('type' => 'text', 'id' => 'above_2_crore', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 5 crore<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_5_crore', array('type' => 'text', 'id' => 'above_5_crore', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 10 crore<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_10_crore', array('type' => 'text', 'id' => 'above_10_crore', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 25 crore<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_25_crore', array('type' => 'text', 'id' => 'above_25_crore', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Percentage of above 50 crore<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.above_50_crore', array('type' => 'text', 'id' => 'above_50_crore', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-9">
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