<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Change Password</h3>
    </div>
    <div
      class="
        col-md-7 col-12
        align-self-center
        d-none d-md-flex
        justify-content-end
      "
    >
      <ol class="breadcrumb mb-0 p-0 bg-transparent">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Change Password
        </li>
      </ol>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <div class="row">
    <div class="col-sm-12">
      <?php echo $this->Flash->render(); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="card card-body">
        <h4 class="card-title">Password Details</h4>
        <?php echo $this->Form->create(NULL, array('id' => 'account_password_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 height-64 margin-top-10">
            <label>Old Password<span class="red">*</span></label>
            <?php echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Old Password')); ?>
          </div>
          <div class="mb-3 height-64">
            <label>New Password<span class="red">*</span></label>
            <?php echo $this->Form->input('User.new_password', array('type' => 'password', 'id' => 'user_new_password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'New Password')); ?>
          </div>
          <div class="mb-3 height-64">
            <label>Confirm Password<span class="red">*</span></label>
             <?php echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Password')); ?>
          </div>
          <div class="card-body text-center">
            <button type="submit" name="btn_account_password" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $home_url; ?>/my-account/change-password/account-password" class="
                btn btn-danger
                rounded-pill
                px-4
                ms-2
                text-white
              ">
              Cancel
            </a>
          </div>
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>