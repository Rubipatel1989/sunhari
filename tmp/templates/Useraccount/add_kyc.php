<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">  Add KYC</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Add KYC
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       <div class="col-sm-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <?php
                        $is_kyc_approved = '';
                        $readonly = '';
                        if($detail->is_kyc_approved == 1){
                          $readonly = 'readonly';
                          $is_kyc_approved = $detail->is_kyc_approved;
                        }
                        ?>
                        <?php echo $this->Form->create(NULL, array('id' => 'edit_profile_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <?php echo $this->Form->input('Detail.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $detail->id)); ?>
                            
                              <legend>Attachments</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">Photo</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                    
                                      <div class="col-xs-12 nopadding">
                                        <div class="row nopadding" <?php if(empty($is_kyc_approved)){ ?>onclick="return uploadPhoto('Detail.photo_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');" <?php }?>>
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                     
                                      <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
                                        <?php
                                        if(isset($detail->Photo['file']) && !empty($detail->Photo['file'])){
                                          $fieldName = 'Detail.photo_attachment_id.';
                                          $ex_file = explode(".", $detail->Photo['file']);
                                          $file_id = $detail->Photo['id'];
                                          $file = $detail->Photo['file'];
                                          $caption = $detail->Photo['caption'];
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
                                                <?php if(empty($is_kyc_approved)){ ?><span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $file_id; ?>');" title="Remove"><i class="fa fa-times"></i></span><?php }?>
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
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">Addresss Proof</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="row nopadding" <?php if(empty($is_kyc_approved)){ ?>onclick="return uploadPhoto('Detail.address_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');"<?php }?>>
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
                                        <?php
                                        if(isset($detail->Address['file']) && !empty($detail->Address['file'])){
                                          $fieldName = 'Detail.address_attachment_id.';
                                          $ex_file = explode(".", $detail->Address['file']);
                                          $file_id = $detail->Address['id'];
                                          $file = $detail->Address['file'];
                                          $caption = $detail->Address['caption'];
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
                                                <?php if(empty($is_kyc_approved)){ ?>
                                                  <span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $file_id; ?>');" title="Remove"><i class="fa fa-times"></i></span>
                                                <?php }?>
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
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">PAN Number</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.pan_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'PAN Number', 'value' => $detail->pan_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">PAN Card</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="row nopadding" <?php if(empty($is_kyc_approved)){?>onclick="return uploadPhoto('Detail.pan_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');"<?php }?>>
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="ccol-xs-12 nopadding margin-top-10 qualification-proof">
                                        <?php

                                        if(isset($detail->Pan['file']) && !empty($detail->Pan['file'])){
                                          $fieldName = 'Detail.pan_attachment_id.';
                                          $ex_file = explode(".", $detail->Pan['file']);
                                          $file_id = $detail->Pan['id'];
                                          $file = $detail->Pan['file'];
                                          $caption = $detail->Pan['caption'];
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
                                                <?php if(empty($is_kyc_approved)){ ?>
                                                  <span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $file_id; ?>');" title="Remove"><i class="fa fa-times"></i></span>
                                                <?php }?>
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

                              <legend>Bank Details</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Bank Name</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank Name', 'value' => $detail->bank_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Account Number</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number', 'value' => $detail->account_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">IFSC Code</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFSC Code', 'value' => $detail->ifsc_code, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Branch</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.branch_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Branch Name', 'value' => $detail->branch_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Google Pay Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.google_pay_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Google Pay Number', 'value' => $detail->google_pay_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Phone Pay Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.phone_pay_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Phone Pay Number', 'value' => $detail->phone_pay_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Paytm Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.paytm_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Paytm Number', 'value' => $detail->paytm_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                            
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                    <?php if(empty($is_kyc_approved)){ ?>
                                       <button type="submit" name="btn_ticket" class="btn btn-square btn-primary">Submit</button> 
                                        &nbsp; <a href="<?php echo $home_url ?>/my-account/support/tickets" class="btn btn-square btn-danger">Cancel</a>
                                    <?php
                                    }?>
                                  </div>
                                </div>
                              </fieldset>
                          <?php echo $this->Form->end();?>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>