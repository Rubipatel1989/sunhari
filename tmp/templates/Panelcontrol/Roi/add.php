<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add ROI
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Form->create(NULL, array('id' => 'add_roi_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>ROI Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Roi.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!--<fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Type<span class="red">*</span></label>
                                   <div class="col-sm-8 height-20 rdo-container">
                                      <?php //echo $this->Form->radio('Roi.type', array('0' => 'Fixed',  '1' => 'Percentage')); ?>
                                   </div>
                                </div>
                              </fieldset>-->
                              <fieldset id="amount-container" style="display: block;">
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Roi.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset id="percentage-container" style="display: none;">
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Percentage<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Roi.percentage', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Percentage')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark<span class="red">*</span></label>
                                   <div class="col-sm-8" style="height:100px;">
                                      <?php echo $this->Form->input('Roi.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/binaries" class="btn btn-square btn-danger">Cancel</a>
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