<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($cashingAmount);
?>
<h3>
  <div class="pull-right text-center">
    
  </div>
  Calculate Pair Rate
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
                          <?php echo $this->Form->create(NULL, array('id' => 'pair_rate_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>Pair Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Total Upgraded Users</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.total_upgraded_users', array('type' => 'text', 'id' => 'total_upgraded_users', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $totalUpgradedUsers, 'readonly' => 'readonly')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Amount Per Id<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.amount_per_id', array('type' => 'text', 'id' => 'amount_per_id', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => '')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Total Amount</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.total_amount', array('type' => 'text', 'id' => 'total_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Total Pair</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      $totalPair = isset($queryResult[0]['total_Pair']) ? $queryResult[0]['total_Pair'] : 0;
                                      echo $this->Form->input('PairRate.total_pair', array('type' => 'text', 'id' => 'total_pair', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $totalPair, 'readonly' => 'readonly')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Pair Rate</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.pair_rate', array('type' => 'text', 'id' => 'pair_rate', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">No of EMI<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.no_of_emi', array('type' => 'text', 'id' => 'no_of_emi', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => '')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">EMI Rate</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      echo $this->Form->input('PairRate.emi_rate', array('type' => 'text', 'id' => 'emi_rate', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="button" name="btn_calulate_pair_rate" id="btn_calulate_pair_rate" class="btn btn-square btn-primary">Calculate</button> 
                                      &nbsp; <button type="submit" name="btn_pair_rate" id="btn_pair_rate" class="btn btn-square btn-primary" style="display: none;">Submit</button> 
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
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>