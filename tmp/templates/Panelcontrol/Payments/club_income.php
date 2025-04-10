<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($cashingAmount);
?>
<h3>
  <div class="pull-right text-center">
    
  </div>
  Club Income
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
                        <?php echo $this->Form->create(NULL, array('id' => 'add_club_income_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <legend>Club Income</legend>
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
                                <label class="col-sm-3 control-label">Mobile Club (In %)<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.mobile_club', array('type' => 'text', 'id' => 'mobile_club', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>

                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Laptop Club (In %)<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.laptop_club', array('type' => 'text', 'id' => 'laptop_club', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                  ?>
                                </div>
                              </div>
                            </fieldset>

                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Bike Club (In %)<span class="red">*</span></label>
                                <div class="col-sm-4 height-37">
                                  <?php
                                  echo $this->Form->input('Payout.bike_club', array('type' => 'text', 'id' => 'bike_club', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
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