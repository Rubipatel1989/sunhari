<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Edit Plan
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
                          <form name="add_emi_form"  id="add_emi_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Plan Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Name<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Property.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Name', 'onchange' => 'addEmiFields("number_of_emi", "add_emi_form");', 'value' => $property->name)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Area<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Property.property_area', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Area', 'onchange' => 'addEmiFields("number_of_emi", "add_emi_form");', 'value' => $property->property_area)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Property.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount', 'onchange' => 'addEmiFields("number_of_emi", "add_emi_form");', 'value' => $property->amount)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Property.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'addEmiFields("number_of_emi", "add_emi_form");', 'default' => $property->status)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!-- <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Number of EMI<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Property.number_of_emi', array('type' => 'text', 'id' => 'number_of_emi', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of EMI', 'onchange' => 'addEmiFields("number_of_emi", "add_emi_form");', 'value' => $property->number_of_emi)); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <?php
                              if(isset($this->request->data['Property']['number_of_emi']) && is_numeric($this->request->data['Property']['number_of_emi']) && !empty($this->request->data['Property']['number_of_emi'])){
                                for($i=1; $i <= $this->request->data['Property']['number_of_emi']; $i++){
                                ?>
                                  <!-- <fieldset>
                                    <div class="form-group">
                                       <label class="col-sm-2 control-label"><?php echo $i;?> EMI Details<span class="red">*</span></label>
                                       <div class="col-sm-8">
                                          <div class="col-xs-12 nopadding height-37">
                                            <div class="col-xs-4 padding-left-0 padding-right-4">
                                              <?php 
                                              $amount = isset($this->request->data['Emi']['amount'][$i-1]) ? $this->request->data['Emi']['amount'][$i-1] : '';
                                              echo $this->Form->input('Emi.amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of EMI', 'value' => $amount)); ?>
                                            </div>
                                            <div class="col-xs-4 padding-left-2 padding-right-2">
                                              <?php 
                                              $directAmount = isset($this->request->data['Emi']['direct_amount'][$i-1]) ? $this->request->data['Emi']['direct_amount'][$i-1] : '';
                                              echo $this->Form->input('Emi.direct_amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Direct Amount', 'value' => $directAmount)); 
                                              ?>
                                            </div>
                                            <div class="col-xs-4 padding-left-4 padding-right-0">
                                              <?php 
                                              $matchingAmount = isset($this->request->data['Emi']['matching_amount'][$i-1]) ? $this->request->data['Emi']['matching_amount'][$i-1] : '';
                                              echo $this->Form->input('Emi.matching_amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Matching Amount', 'value' => $matchingAmount)); 
                                              ?>
                                            </div>
                                       </div>
                                    </div>
                                  </fieldset> -->
                              <?php
                                }
                              }else{
                                  if(!empty($property->emis)){
                                    $i=1;
                                    foreach($property->emis as $emi){?>

                                      <!-- <fieldset>
                                        <div class="form-group">
                                           <label class="col-sm-2 control-label"><?php echo $i;?> EMI Details<span class="red">*</span></label>
                                           <div class="col-sm-8">
                                              <div class="col-xs-12 nopadding height-37">
                                                <div class="col-xs-4 padding-left-0 padding-right-4">
                                                  <?php 
                                                  $amount = isset($emi->amount) ? $emi->amount : '';
                                                  echo $this->Form->input('Emi.amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of EMI', 'value' => $amount)); ?>
                                                </div>
                                                <div class="col-xs-4 padding-left-2 padding-right-2">
                                                  <?php 
                                                  $directAmount = isset($emi->direct_amount) ? $emi->direct_amount : '';
                                                  echo $this->Form->input('Emi.direct_amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Direct Amount', 'value' => $directAmount)); 
                                                  ?>
                                                </div>
                                                <div class="col-xs-4 padding-left-4 padding-right-0">
                                                  <?php 
                                                  $matchingAmount = isset($emi->matching_amount) ? $emi->matching_amount : '';
                                                  echo $this->Form->input('Emi.matching_amount.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Matching Amount', 'value' => $matchingAmount)); 
                                                  ?>
                                                </div>
                                           </div>
                                        </div>
                                      </fieldset> -->
                                      <?php
                                      $i++;
                                    }
                                  }
                                ?>
                              <?php
                               }?>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/properties" class="btn btn-square btn-danger">Cancel</a>
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
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>