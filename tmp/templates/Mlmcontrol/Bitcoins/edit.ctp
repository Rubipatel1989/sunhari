<?php
echo $this->Html->css('frontend/css/my-account.css');
//echo '<pre>';
//print_r($bitcoinInfo);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Edit Bitcoin
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <form name="add_bitcoin_form"  id="add_bitcoin_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <?php echo $this->Form->input('Bitcoin.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $bitcoinInfo->id)); ?>
                            <legend>Bitcoin Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Bitcoin.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'value' => $bitcoinInfo->title)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">BTC Address<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Bitcoin.address', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'BTC Address', 'value' => $bitcoinInfo->address)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark</label>
                                   <div class="col-sm-8" style="height:100px; ">
                                      <?php echo $this->Form->input('Bitcoin.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;', 'value' => $bitcoinInfo->remark)); ?>
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
                                      <?php
                                      if(isset($bitcoinInfo->Attachments['id']) && !empty($bitcoinInfo->Attachments['id'])){
                                        $attachment = $bitcoinInfo->Attachments;
                                        $ex_file = explode(".", $attachment['file']);
                                        if(strtolower($ex_file[1]) == 'pdf'){
                                          $attachment_file = 'frontend/img/pdf-default.png';
                                          $cls = "";
                                          $link = $home_url.'attachments/'.$attachment['file'];
                                        }
                                        elseif(strtolower($ex_file[1]) == 'doc'){
                                          $attachment_file = 'frontend/img/msdoc-default.gif';
                                          $cls = "";
                                          $link = $home_url.'/attachments/'.$attachment['file'];
                                        }
                                        elseif(strtolower($ex_file[1]) == 'mp4'){
                                          $attachment_file = 'frontend/img/video-default.png';
                                          $cls = "fancybox fancybox.ajax";
                                          $link = $home_url.'/ajax/show_attachments/'.$attachment['id'];
                                        }else{
                                          $attachment_file = 'attachments/'.$attachment['file'];
                                          $cls = "fancybox fancybox.ajax";
                                          $link = $home_url.'/ajax/show_attachments/'.$attachment['id'];
                                        }
                                      ?>
                                        <div class="attchment-container">
                                          <div class="col-xs-12 attchment-inner-container">
                                            <div class="col-xs-12 nopadding">
                                              <span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $attachment['id']; ?>');" title="Remove"><i class="fa fa-times"></i></span>
                                              <a href="<?php echo $link; ?>" class="<?php echo $cls; ?>" target="_blank"><img src="<?php echo $home_url; ?>/<?php echo $attachment_file; ?>" alt="<?php echo $attachment['caption']; ?>" /></a>
                                              <?php echo $this->Form->input('Attachment.id.', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $attachment['id'])); ?>
                                            </div>
                                          </div>
                                          <div class="col-xs-12 padding-left-10 padding-right-10 margin-top-12">
                                            <?php echo $this->Form->input('Attachment.caption.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Caption', 'value' => $attachment['caption'])); ?>
                                          </div>
                                        </div>
                                      <?php
                                      }?>
                                    </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Bitcoin.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $bitcoinInfo->status)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Update</button> 
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