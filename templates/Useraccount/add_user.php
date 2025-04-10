<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">  New Registration</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      New Registration
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
                      <?php echo $this->Form->create(NULL, array('id' => 'add_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>Personal Details</legend>
                              
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Epin<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('User.epin', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Epin', 'value' => $epinText)); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Sponsor Id<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($users as $userInfo){
                                        $options[$userInfo->username] = $userInfo->username.'('.$userInfo->Details['first_name'].' '.$userInfo->Details['last_name'].')';
                                      }
                                      echo $this->Form->input('User.sponser_username', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'ddl-select form-control loginbox', 'data-live-search' => "true")); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Position<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-', 'left' => 'Left', 'right' => 'Right'];
                                      echo $this->Form->input('User.position', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'ddl-select form-control loginbox', 'placeholder' => 'Referral Name', 'data-live-search' => "true")); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Name<span class="red">*</span></label>
                                   <div class="col-sm-8">
                                      <div class="col-xs-12 nopadding">
                                          <div class="col-xs-12 padding-left-0 padding-right-0 height-37">
                                              <?php echo $this->Form->input('Detail.first_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Name'));?>
                                          </div>
                                          <!-- <div class="col-xs-6 padding-left-8 padding-right-0 height-37">
                                             <?php echo $this->Form->input('Detail.last_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Last Name'));?>
                                          </div> -->
                                      </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Email</label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('User.email', array('type' => 'text', 'id' => 'email', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Email'));?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">Contact Number<span class="red">*</span></label>
                                  <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Detail.contact_no', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter contact number with country code e.g. 919336914285'));?>
                                  </div>
                              </fieldset>
                              <legend>Attachments</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right">Photo</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                    
                                      <div class="col-xs-12 nopadding">
                                        <div class="row nopadding" onclick="return uploadPhoto('Detail.photo_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                     
                                      <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Adhar No.</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.adhar_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Adhar No.')); 
                                      ?>
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
                                        <div class="row nopadding" onclick="return uploadPhoto('Detail.address_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
                                        
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
                                      echo $this->Form->input('Detail.pan_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'PAN Number')); 
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
                                        <div class="row nopadding" onclick="return uploadPhoto('Detail.pan_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="ccol-xs-12 nopadding margin-top-10 qualification-proof">
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
                                      echo $this->Form->input('Detail.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank Name')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Account Number</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">IFSC Code</label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFSC Code')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Branch</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.branch_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Branch Name')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Google Pay Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.google_pay_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Google Pay Number')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Phone Pay Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.phone_pay_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Phone Pay Number')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Paytm Number</label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('Detail.paytm_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Paytm Number')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $home_url; ?>/my-account/manage-users/registered-user" class="btn btn-square btn-danger">Cancel</a>
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