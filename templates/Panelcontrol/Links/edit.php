<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Edit Link
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Form->create(NULL, array('id' => 'add_link_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <?php echo $this->Form->input('Link.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $linkInfo->id)); ?>
                            <legend>Link Detail</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Link.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'value' => $linkInfo->title)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Link<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Link.link', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Link', 'value' => $linkInfo->link)); ?>
                                   </div>
                                </div>
                              </fieldset>
                               <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark</label>
                                   <div class="col-sm-8">
                                      <?php echo $this->Form->input('Link.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => '100px;', 'value' => str_replace('<br />', '', $linkInfo->remark))); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Link.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $linkInfo->status)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/links" class="btn btn-square btn-danger">Cancel</a>
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