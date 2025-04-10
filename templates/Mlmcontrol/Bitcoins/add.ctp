<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add BTC Address
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <form name="add_bitcoin_form"  id="add_bitcoin_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>BTC Address Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Bitcoin.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">BTC Address<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Bitcoin.address', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'BTC Address')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark</label>
                                   <div class="col-sm-8" style="height:100px; ">
                                      <?php echo $this->Form->input('Bitcoin.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">QR Image</label>
                                   <div class="col-sm-10">
                                    <div class="col-xs-12 nopadding margin-top-7">
                                      <div class="col-xs-12 nopadding ajax-upload">
                                        <div class="col-xs-6 btn_browse">
                                          Choose file
                                        </div>
                                        <div class="col-xs-6 nopadding">
                                          <button type="button" class="btn-browse">Browse</button>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12 ajax-upload-container margin-top-10">
                                    </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/bitcoins" class="btn btn-square btn-danger">Cancel</a>
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