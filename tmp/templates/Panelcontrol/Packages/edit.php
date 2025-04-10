<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Package</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Package Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Form->create(NULL, array('id' => 'add_package_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                             <?php echo $this->Form->input('Package.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Name', 'value' => $packageInfo->id)); ?>
                            <legend>Package Details</legend>
                              <fieldset>
                                <div class="row margin-top-25 margin-top-15">
                                   <label class="col-sm-2 control-label">Name<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Name', 'value' => $packageInfo->name)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Description</label>
                                   <div class="col-sm-8">
                                      <?php echo $this->Form->input('Package.description', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Description', 'style' => '100px;', 'value' => $packageInfo->description)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Package B.V.<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.package_bv', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package B.V.', 'value' => $packageInfo->package_bv)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Package Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.package_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Package Amount', 'value' => $packageInfo->package_amount)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Direct Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.direct_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Direct Amount', 'value' => $packageInfo->direct_amount)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">ROI Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.roi_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'ROI Amount', 'value' => $packageInfo->roi_amount)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Business Point<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.business_point', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Business Point', 'value' => $packageInfo->business_point)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Booster Time<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.booster_time', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Booster Time', 'value' => $packageInfo->booster_time)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Booster Amount<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.booster_amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Booster Amount', 'value' => $packageInfo->booster_amount)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Allowed Links<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Package.allowed_links', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Allowed Links', 'value' => $packageInfo->allowed_links)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Image</label>
                                   <div class="col-sm-8">
                                    <div class="col-xs-12 nopadding margin-top-7">
                                      <div class="row nopadding ajax-upload">
                                        <div class="w-50 btn_browse">
                                          Choose file
                                        </div>
                                        <div class="w-50 nopadding">
                                          <button type="button" class="btn-browse">Browse</button>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12 ajax-upload-container margin-top-10">
                                      <?php
                                      if(isset($packageInfo->Attachments['id']) && !empty($packageInfo->Attachments['id'])){
                                        $attachment = $packageInfo->Attachments;
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
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Position<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                      <?php echo $this->Form->input('Package.position', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Position', 'value' => $packageInfo->position)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Package.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $packageInfo->status)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/packages" class="btn btn-square btn-danger">Cancel</a>
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
</main>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>