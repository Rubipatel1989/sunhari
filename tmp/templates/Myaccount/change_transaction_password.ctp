<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Transaction Password
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
                          <form name="change_transaction_password_form"  id="change_transaction_password_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Transaction Password Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Old Password<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('User.transaction_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Old Transaction Password')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">New Password<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('User.new_transaction_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'New Transaction Password')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Confirm Password<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Transaction Password')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $home_url ?>/my-account/change-password/account-password" class="btn btn-square btn-danger">Cancel</a>
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