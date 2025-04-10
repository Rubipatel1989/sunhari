<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
     
   </div>
   Upgrade User
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
                          <?php echo $this->Form->create(NULL, array('id' => 'user_upgrade_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>Upgrade Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">User<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($users as $user){
                                        $options[$user->id] = $user->username.'('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Upgrade.upgraded_id', array('type' => 'select', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'options' => $options, 'default' => $selected, 'data-live-search' => "true"));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Package<span class="red">*</span></label>
                                   <div class="col-sm-4 height-37">
                                      <?php 
                                      $options = ['' => '-Select-'];
                                      foreach($packages as $package){
                                        $options[$package->id] = $package->name;
                                      }
                                      echo $this->Form->input('Upgrade.package_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'options' => $options));
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/users/upgrade-history" class="btn btn-square btn-danger">Cancel</a>
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
</div>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>