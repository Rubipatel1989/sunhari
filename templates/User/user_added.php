<div class="auth-box p-4 bg-white rounded">
   <div id="loginform">
      <div class="row">
        <?php echo $this->Flash->render(); ?>
      </div>
      <div class="logo">
         <h3 class="box-title">Login Details</h3>
      </div>
      <!-- Form -->
      <div class="row">
         <div class="col-12">
            <?php echo $this->Form->create(NULL, array('id' => 'login-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
               <div class="form-group margin-top-10">
                  <div class="row">
                     <div class="col text-right">
                        ID :
                     </div>
                     <div class="col text-right">
                        <strong><?php echo $this->request->getSession()->read('username'); ?></strong>
                     </div>
                  </div>
               </div>
               <div class="form-group margin-top-10">
                  <div class="row">
                     <div class="col text-right">
                        Password :
                     </div>
                     <div class="col text-right">
                        <strong><?php echo $this->request->getSession()->read('password'); ?></strong>
                     </div>
                  </div>
               </div>
               <div class="form-group margin-top-15">
                  <div class="row">
                     <div class="col text-center">
                        <a class="btn btn-info d-block w-100 waves-effect waves-light" href="<?php echo $home_url; ?>/user/login">Login</a>
                     </div>
                  </div>
               </div>
            <?php echo $this->Form->end();?>
         </div>
      </div>
   </div>
</div>