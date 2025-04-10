<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add Current Rate
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
                          <form name="add_current_rate_form"  id="add_current_rate_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Current Rate Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Plan<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $options = ['' => '-Select Plan-', '1' => 'Plan One' , '2' => 'Plan Two'];
                                      echo $this->Form->input('CurrentRate.plan', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Rate<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('CurrentRate.rate', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Rate'));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark<span class="red">*</span></label>
                                   <div class="col-sm-8" style="height:100px;">
                                      <?php echo $this->Form->input('CurrentRate.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button name="btn_edit_account" type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/user/current-rate" class="btn btn-square btn-danger">Cancel</a>
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