<div class="auth-box p-4 bg-white rounded">
   <div id="loginform">
      <div class="logo">
         <h3 class="box-title mb-3">Member Sign In</h3>
      </div>
      <!-- Form -->
      <div class="row">
        <?php echo $this->Flash->render(); ?>
      </div>
      <div class="row">
         <div class="col-12">
            <?php echo $this->Form->create(NULL, array('id' => 'login-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
               <div class="form-group mb-3">
                  <div class="">
                    <?php echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control form-control-lg loginbox', 'placeholder' => 'Username')); ?>
                  </div>
               </div>
               <div class="form-group mb-4">
                  <div class="">
                    <?php echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control form-control-lg loginbox', 'placeholder' => 'Password')); ?>
                  </div>
               </div>
               <div class="form-group">
                  <div class="d-flex">
                     <div class="checkbox checkbox-info pt-0">
                        <input
                           id="checkbox-signup"
                           type="checkbox"
                           class="material-inputs chk-col-indigo"
                           />
                        <label for="checkbox-signup"> Remember me </label>
                     </div>
                  </div>
               </div>
               <div class="form-group text-center mt-4 mb-3">
                  <div class="col-xs-12">
                     <button
                        class="
                        btn btn-info
                        d-block
                        w-100
                        waves-effect waves-light
                        "
                        type="submit"
                        >
                     Log In
                     </button>
                  </div>
               </div>
            <?php echo $this->Form->end();?>
         </div>
      </div>
   </div>
</div>