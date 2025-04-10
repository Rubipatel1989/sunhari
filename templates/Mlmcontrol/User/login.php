<?php echo $this->Form->create(NULL,array('url'=>'/mlmcontrol/user/login'));?>
  <div class="form-group has-feedback">
      <?php echo $this->Flash->render(); ?>
  </div>
    
  <div class="form-group has-feedback height-45">
     <?php echo $this->Form->input('User.username', array('type' => 'text', 'id' => 'username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Username')); ?>
     <span class="fa fa-user form-control-feedback text-muted"></span>
  </div>
  <div class="form-group has-feedback height-45">
    <?php echo $this->Form->input('User.password', array('type' => 'password', 'id' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Password')); ?>
    <span class="fa fa-lock form-control-feedback text-muted"></span>
  </div>
  <div class="clearfix">
     <div class="checkbox c-checkbox pull-left mt0">
        <label>
           <input type="checkbox" value="">
           <span class="fa fa-check"></span>Remember Me</label>
     </div>
     <div class="pull-right"><a href="#" class="text-muted">Forgot your password?</a>
     </div>
  </div>
  <button type="submit" class="btn btn-block btn-primary">Login</button>
<?php echo $this->Form->end();?>