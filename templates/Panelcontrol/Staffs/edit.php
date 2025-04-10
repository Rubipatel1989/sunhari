<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Staff</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Staff Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       
                       <?php echo $this->Form->create(NULL, array('id' => 'add_staff_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Name<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php
                                  echo $this->Form->input('Detail.first_name', array('type' => 'text', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'value' => $userDetails->Details['first_name'])); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>

                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Role<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php 
                                  $options = ['' => '-Select-'];
                                  foreach($roles as $role){
                                    $options[$role->id] = $role->title;
                                  }
                                  echo $this->Form->input('User.role_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $userDetails->role_id)); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25 margin-top-15">
                               <label class="col-sm-2 text-right">Username<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php
                                  echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Username', 'value' => $userDetails->username)); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25 margin-top-15">
                               <label class="col-sm-2 text-right">Password<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php
                                  echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Password')); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25 margin-top-15">
                               <label class="col-sm-2 text-right">Confirm Password</label>
                               <div class="col-sm-8 height-37">
                                  <?php
                                  echo $this->Form->input('User.confirm_password', array('type' => 'password', 'id' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Password')); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Status<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php 
                                  $options = ['' => '-Select-', 1 => 'Active', 0 => 'Inactive'];
                                  echo $this->Form->input('User.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $userDetails->status)); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                              <label class="col-sm-2 text-right"></label>
                              <div class="col-sm-10">
                                  <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/staffs" class="btn btn-square btn-danger">Cancel</a>
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
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>