<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   User Added
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
                          <form name="add_user_form"  id="add_user_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>User Added Successfully</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Username : </label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $this->request->getSession()->read('username'); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Password :</label>
                                   <div class="col-sm-8 margin-top-8">
                                      <?php echo $this->request->getSession()->read('password'); ?>
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