<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">New Joining</h3>
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
          New Joining
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
        <h4 class="card-title">User Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'add_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <?php
          $otpBoxStyle = 'display: none;';
          $fieldBoxStyle = 'display: block;';
          if ($this->request->getSession()->check("agent_joining_otp")) {
            $otpBoxStyle = 'display: block;';
            $fieldBoxStyle = 'display: none;';
          }?>
          <div style="<?php echo $otpBoxStyle; ?>">
            <div class="mb-3 height-64">
              <label>OTP<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.otp', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter otp')); 
              ?>
            </div>
          </div>
          <div style="<?php echo $fieldBoxStyle; ?>">
            <div class="mb-3 margin-top-10">
              Wallet Balance <strong>Rs <?php echo number_format($wallet->total_wallet_amount, 2); ?></strong>
            </div>
            <div class="mb-3 height-64">
              <label>Referral Id<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.sponsor_username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter referral id', 'onchange' => 'return getFullName(this);')); 
              ?>
            </div>
            <div class="mb-3 height-64">
              <label>Referral Name<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.sponsor_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
              ?>
            </div>
            <div class="mb-3 height-64">
              <label>Name<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter name')); 
              ?>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 height-64">
                 <label>Aadhar Number<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.aadhar_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter aadhar number')); 
                  ?>
                </div>
                <div class="col-md-6 height-64">
                  <label>PAN Number<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.pan_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter PAN number')); 
                  ?>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 height-64">
                  <label>Mobile<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.contact_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Mobile')); 
                  ?>
                </div>
                <div class="col-md-6 height-64">
                  <label>Rank<span class="red">*</span></label>
                  <?php 
                  $options = $this->UserData->getRankList();
                  echo $this->Form->input('User.current_rank', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                  ?>
                </div>
              </div>
            </div>
            <div class="mb-3 height-64">
              <label>Bank Name<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter bank name')); 
              ?>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 height-64">
                 <label>Account Number<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter account number')); 
                  ?>
                </div>
                <div class="col-md-6 height-64">
                  <label>IFSC<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter IFSC code')); 
                  ?>
                </div>
              </div>
            </div>
            <div class="mb-3 height-64">
              <label>Email Id<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('User.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter email id')); 
              ?>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 height-64">
                  <label>Password<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.password', array('type' => 'password', 'id' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => '**********')); 
                  ?>
                </div>
                <div class="col-md-6 height-64">
                  <label>Confirm Password<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => '**********')); 
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $backend_url; ?>/user/new-joining" class="
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