<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Referral Link
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
                          <?php echo $this->Form->create(NULL, array('id' => 'transfer_fund_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <legend>Referral Link</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Left : </label>
                                   <div class="col-sm-8 height-37 margin-top-8">
                                       <a href="<?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/left"><?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/left</a>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Right : </label>
                                   <div class="col-sm-8 height-37 margin-top-8">
                                      <a href="<?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/right"><?php echo $home_url; ?>/register-user/<?php echo md5($user['username']);?>/right</a>
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