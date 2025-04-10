<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add Staff
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
                          <form name="add_staff_form"  id="add_staff_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Staff Details</legend>
                              
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Name<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('Detail.first_name', array('type' => 'text', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Role<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($roles as $role){
                                        $options[$role->id] = $role->title;
                                      }
                                      echo $this->Form->input('User.role_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'ddl-select form-control loginbox', 'data-live-search' => "true")); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Username<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Username')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Password<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Password')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Confirm Password</label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('User.confirm_password', array('type' => 'password', 'id' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Password')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-', 1 => 'Active', 0 => 'Inactive'];
                                      echo $this->Form->input('User.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'ddl-select form-control loginbox', 'data-live-search' => "true")); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/staffs" class="btn btn-square btn-danger">Cancel</a>
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