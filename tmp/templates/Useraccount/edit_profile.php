<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active"> Edit Profile</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                     Edit Profile
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
                        <?php echo $this->Form->create(NULL, array('id' => 'edit_profile_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <?php echo $this->Form->input('Detail.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $detail->id)); ?>
                            <legend>Personal Details</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Name<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                    <div class="col-xs-12 nopadding">
                                      <div class="col-xs-12 padding-left-0 padding-right-5">
                                        <?php 
                                        $readonly = '';
                                        if($detail->first_name != ''){
                                          $readonly = 'readonly';
                                        }
                                        echo $this->Form->input('Detail.first_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Name', 'value' => $detail->first_name, 'readonly' => $readonly)); 
                                        ?>
                                      </div>
                                      <!-- <div class="col-xs-6 padding-left-5 padding-right-0">
                                        <?php 
                                        /*$readonly = '';
                                        if($detail->last_name != ''){
                                          $readonly = 'readonly';
                                        }*/
                                        //echo $this->Form->input('Detail.last_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Last Name', 'value' => $detail->last_name, 'readonly' => $readonly)); 
                                        ?>
                                      </div> -->
                                    </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Father's Name</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->father_name != ''){
                                        //$readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.father_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => "Father's Name", 'value' => $detail->father_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">DOB</label>
                                   <div class="col-sm-4 height-37">
                                      <?php
                                      $dateCls = 'date';
                                      $readonly = '';
                                      if($detail->dob != ''){
                                        //$dateCls = '';
                                        //$readonly = 'readonly';
                                      }
                                      ?>
                                      <div class="dob input-group <?php echo $dateCls;?>">
                                        <?php echo $this->Form->input('Detail.dob', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "Date of birth", 'value' => $detail->dob, 'readonly' => $readonly)); ?>
                                        <span class="input-group-addon" style="display: none;">
                                           <span class="fa fa-calendar"></span>
                                        </span>
                                      </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Gender</label>
                                   <div class="col-sm-3 height-37">
                                      <?php 
                                      $disabled = '';
                                      if($detail->gender != ''){
                                        $disabled = 'disabled';
                                      }
                                      $options = ['' => '-Select-', 'male' => 'Male', 'female' => 'Female', 'Other' => 'other'];
                                      echo $this->Form->input('Detail.gender', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $detail->gender, 'disabled' => $disabled)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <legend>Contact Details</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Email</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($user->email != ''){
                                        //$readonly = 'readonly';
                                      } 
                                      echo $this->Form->input('User.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => "Email", 'value' => $user->email, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Contact Number</label>
                                   <div class="col-sm-3 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.contact_no', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Contact Number', 'value' => $detail->contact_no)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Whapts App Number</label>
                                   <div class="col-sm-5 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->whats_app_number != ''){
                                        $readonly = 'readonly';
                                      } 
                                      echo $this->Form->input('Detail.whats_app_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => "Please enter Whapts App Number", 'value' => $detail->whats_app_number, 'readonly' => $readonly)); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Country</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $disabled = '';
                                      if($detail->country_id != ''){
                                        $disabled = 'disabled';
                                      }
                                      $options = ['' => '-Select-'];
                                      foreach($countries as $country){
                                        $options[$country->id] = $country->name;
                                      }
                                      echo $this->Form->input('Detail.country_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $detail->country_id, 'onchange' => 'FilterSateByCountry(this.value, "state_container", "Detail.state_id", "form-control loginbox");', 'disabled' => $disabled)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">State</label>
                                   <div id='state_container' class="col-sm-4 height-37">
                                      <?php 
                                      $disabled = '';
                                      if($detail->state_id != ''){
                                        $disabled = 'disabled';
                                      }
                                      $options = ['' => '-Select-'];
                                      if(!empty($state)){
                                        $options[$state->id] = $state->name;
                                      }
                                      echo $this->Form->input('Detail.state_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $detail->state_id, 'disabled' => $disabled)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">City</label>
                                   <div class="col-sm-5 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->city_name != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.city_name', array('type' => 'text',  'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'City Name', 'value' => $detail->city_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Address</label>
                                   <div class="col-sm-8" style="height: 60px;">
                                      <?php 
                                      $readonly = '';
                                      if($detail->address != ''){
                                        //$readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.address', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Address', 'style' => 'height: 60px;', 'value' => $detail->address, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Pin Code</label>
                                   <div class="col-sm-2 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->pin_code != ''){
                                        //$readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.pin_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Pin Code', 'value' => $detail->pin_code, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <legend>Account Details</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Adhar No.</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->adhar_number != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.adhar_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Adhar Number', 'value' => $detail->adhar_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">PAN No.</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->pan_number != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.pan_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'PAN Number', 'value' => $detail->pan_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Account No.</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->account_number != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number', 'value' => $detail->account_number, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!--<fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Account Number</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                     // echo $this->Form->input('Detail.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number', 'value' => $detail->account_number)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>-->
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Bank Name</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->bank_name != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank Name', 'value' => $detail->bank_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Branch Name</label>
                                   <div class="col-sm-5 height-37">
                                      <?php
                                      $readonly = '';
                                      if($detail->branch_name != ''){
                                        $readonly = 'readonly';
                                      } 
                                      echo $this->Form->input('Detail.branch_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Branch Name', 'value' => $detail->branch_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">IFSC Code</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->ifsc_code != ''){
                                        $readonly = 'readonly';
                                      } 
                                      echo $this->Form->input('Detail.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFSC Code', 'value' => $detail->ifsc_code, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Type of Account</label>
                                   <div class="col-sm-3 height-37">
                                      <?php 
                                      $disabled = '';
                                      if($detail->type_of_account != ''){
                                        $disabled = 'disabled';
                                      }
                                      $options = ['' => '-Select-', 'Saving' => 'Saving', 'Current' => 'Current'];
                                      echo $this->Form->input('Detail.type_of_account', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $detail->type_of_account, 'disabled' => $disabled)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Nominee Name</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->nominee_name != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.nominee_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Nominee Name', 'value' => $detail->nominee_name, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Relationship</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $readonly = '';
                                      if($detail->relationship != ''){
                                        $readonly = 'readonly';
                                      }
                                      echo $this->Form->input('Detail.relationship', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Relationship', 'value' => $detail->relationship, 'readonly' => $readonly)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                             <!-- <legend>Attachments</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">Photo</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding" onclick="return uploadPhoto('Attachment.user_photo.', 'single', 1, '<?php echo $rand_id; ?>');">
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
                                        if(isset($detail->Photo['file']) && !empty($detail->Photo['file'])){
                                          $fieldName = 'Attachment.user_photo.';
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
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">ID Proof</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding" onclick="return uploadPhoto('Attachment.id_proof.', 'single', 1, '<?php echo $rand_id; ?>');">
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
                                        if(isset($detail->IdProof['file']) && !empty($detail->IdProof['file'])){
                                          $fieldName = 'Attachment.id_proof.';
                                          $ex_file = explode(".", $detail->IdProof['file']);
                                          $file_id = $detail->IdProof['id'];
                                          $file = $detail->IdProof['file'];
                                          $caption = $detail->IdProof['caption'];
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
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">PAN Card</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding" onclick="return uploadPhoto('Attachment.address_proof.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col-xs-6 btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col-xs-6 nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="ccol-xs-12 nopadding margin-top-10 qualification-proof">
                                        <?php
                                        if(isset($detail->AddressProof['file']) && !empty($detail->AddressProof['file'])){
                                          $fieldName = 'Attachment.address_proof.';
                                          $ex_file = explode(".", $detail->AddressProof['file']);
                                          $file_id = $detail->AddressProof['id'];
                                          $file = $detail->AddressProof['file'];
                                          $caption = $detail->AddressProof['caption'];
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

                              </fieldset>-->
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_ticket" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $home_url ?>/my-account/support/tickets" class="btn btn-square btn-danger">Cancel</a>
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