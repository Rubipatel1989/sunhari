<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Change Password</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Change Password
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
                       <?php echo $this->Form->create(NULL, array('id' => 'edit_account_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-2 text-right">User<span class="red">*</span></label>
                               <div class="col-sm-4 height-37">
                                  <?php 
                                  $options = ['' => '-Select-'];
                                  foreach($users as $user){
                                    $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';;
                                  }
                                  echo $this->Form->input('User.id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'options' => $options, 'default' => $intUserId));
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <!-- <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-2 text-right">Username</label>
                               <div class="col-sm-4 height-37">
                                  <?php 
                                  echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Username'));
                                  ?>
                               </div>
                            </div>
                          </fieldset> -->
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-2 text-right">Password</label>
                               <div class="col-sm-4 height-37">
                                  <?php 
                                  echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Password'));
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-20">
                               <label class="col-sm-2 text-right">Confirm Password</label>
                               <div class="col-sm-4 height-37">
                                  <?php 
                                  echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Password'));
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-20">
                              <label class="col-sm-2 text-right"></label>
                              <div class="col-sm-10">
                                  <button name="btn_edit_account" type="submit" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/users" class="btn btn-square btn-danger">Cancel</a>
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