<div class="col col-md-6 col-lg-7 hidden-sm-down">
   <h2 class="fs-xxl fw-500 mt-4 text-white">
       JSKS Infratech Member Login
       <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
           JSKS Infratech is one of the fastest growing companies in the Network Marketing Industry today and is creating waves with it's superb and revolutionary line of products.
       </small>
   </h2>
   <a href="#" class="fs-lg fw-500 text-white opacity-70">Learn more &gt;&gt;</a>
   <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
       <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
           Find us on social media
       </div>
       <div class="d-flex flex-row opacity-70">
           <a href="#" class="mr-2 fs-xxl text-white">
               <i class="fab fa-facebook-square"></i>
           </a>
           <a href="#" class="mr-2 fs-xxl text-white">
               <i class="fab fa-twitter-square"></i>
           </a>
           <a href="#" class="mr-2 fs-xxl text-white">
               <i class="fab fa-google-plus-square"></i>
           </a>
           <a href="#" class="mr-2 fs-xxl text-white">
               <i class="fab fa-linkedin"></i>
           </a>
       </div>
   </div>
</div>
<div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
   <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
       Secure login
   </h1>
   <div class="card p-4 rounded-plus bg-faded">
       <div class="col-sm-12 nopadding">
          <?php echo $this->Flash->render(); ?>
       </div>
       <?php echo $this->Form->create(NULL, array('id' => 'login_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
           <div class="form-group">
               <label class="form-label" for="username">Username</label>
               <?php echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control form-control-lg loginbox', 'placeholder' => 'Username')); ?>
               <div class="invalid-feedback">No, you missed this one.</div>
               <div class="help-block">Your unique username to app</div>
           </div>
           <div class="form-group">
               <label class="form-label" for="password">Password</label>
                <?php echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control form-control-lg loginbox', 'placeholder' => 'Password')); ?>
               <div class="invalid-feedback">Sorry, you missed this one.</div>
               <div class="help-block">Your password</div>
           </div>
           <div class="form-group text-left">
               <div class="custom-control custom-checkbox">
                   <input type="checkbox" class="custom-control-input" id="rememberme">
                   <label class="custom-control-label" for="rememberme"> Remember me for the next 30 days</label>
               </div>
           </div>
           <div class="row no-gutters">
               <div class="col-lg-6 pr-lg-1 my-2">
                   <button type="submit" class="btn btn-info btn-block btn-lg">Login</button>
               </div>
               <div class="col-lg-6 pl-lg-1 my-2">
                  
               </div>
           </div>
       <?php echo $this->Form->end();?>
   </div>
</div>