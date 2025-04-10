<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add Site
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
                          <form name="add_site_form"  id="add_site_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Site Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Property<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Property-'];
                                      foreach($properties as $property){
                                        $options[$property->id] = $property->title;
                                      }
                                      $selected = $siteInfo->property_id;
                                      echo $this->Form->input('Site.property_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Site.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'value' => $siteInfo->title)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label">Photo</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding" onclick="return uploadPhoto('Attachment.attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col-xs-6 btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col-xs-6 nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="col-xs-12 nopadding margin-top-10 qualification-proof">
                                        <?php
                                        if(isset($siteInfo->Attachments['file']) && !empty($siteInfo->Attachments['file'])){
                                          $fieldName = 'Attachment.attachment_id.';
                                          $ex_file = explode(".", $siteInfo->Attachments['file']);
                                          $file_id = $siteInfo->Attachments['id'];
                                          $file = $siteInfo->Attachments['file'];
                                          $caption = $siteInfo->Attachments['caption'];
                                          if(strtolower($ex_file[1]) == 'pdf'){
                                            $attachment_file = 'frontend/img/pdf-default.png';
                                            $cls = "";
                                            $link = $home_url.'attachments/'.$file;
                                          }
                                          elseif(strtolower($ex_file[1]) == 'doc'){
                                            $attachment_file = 'frontend/img/msdoc-default.gif';
                                            $cls = "";
                                            $link = $home_url.'/attachments/'.$file;
                                          }
                                          elseif(strtolower($ex_file[1]) == 'mp4'){
                                            $attachment_file = 'frontend/img/video-default.png';
                                            $cls = "fancybox fancybox.ajax";
                                            $link = $home_url.'/ajax/show_attachments/'.$file;
                                          }else{
                                            $attachment_file = 'attachments/'.$file;
                                            $cls = "fancybox fancybox.ajax";
                                            $link = $home_url.'/ajax/show_attachments/'.$file_id;
                                          }?>
                                          <div class="attchment-container">
                                              <div class="col-xs-12 attchment-inner-container">
                                                <div class="col-xs-12 nopadding">
                                                <span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $file_id; ?>');" title="Remove"><i class="fa fa-times"></i></span>
                                                <a href="<?php echo $link; ?>" class="<?php echo $cls; ?>" target="_blank"><img src="<?php echo $home_url; ?>/<?php echo $attachment_file; ?>" alt="<?php echo $caption; ?>" /></a>
                                                <?php echo $this->Form->input($fieldName, array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $file_id)); ?>
                                              </div>
                                              </div>
                                              <div class="col-xs-12 padding-left-10 padding-right-10 margin-top-12">
                                              <?php echo $this->Form->input($fieldName.'caption.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Caption', 'value' => $caption)); ?>
                                            </div>
                                          </div>
                                        <?php
                                        }?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Remark<span class="red">*</span></label>
                                   <div class="col-sm-8" style="height: 100px;">
                                      <?php echo $this->Form->input('Site.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;', 'value' => $siteInfo->remark)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Site.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $siteInfo->status)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/sites" class="btn btn-square btn-danger">Cancel</a>
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
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>