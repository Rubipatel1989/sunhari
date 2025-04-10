<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Profile</h3>
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
          Profile
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
    <div class="col-sm-5">
      <div class="card card-body">
        <div class="row">
            <div class="col-sm-12 nopadding text-center profile-pic-container">
                <?php
                $profileImage = $home_url.'/dist/libs/images/profile.png';
                $altText = '';
                if($user->Attachments['file']) {
                    $profileImage = $home_url.'/attachments/'.$user->Attachments['file'];
                    $altText = $user->Attachments['caption'];
                }
                ?>
                <img src="<?php echo $profileImage; ?>" alt="<?php echo $altText; ?>">
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                User Id :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo $user['username'];?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                User Name :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo $user['name'];?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Mobile :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo $user['contact_number'];?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Email Id :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo $user['email'];?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Registration Date :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo date("d M Y", strtotime($user['created']));?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Activation Date :
            </div>
            <div class="w-60 text-right">
                <strong><?php echo date("d M Y", strtotime($userInfo->Packages['created'])); ?></strong>
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Sponsor ID :
            </div>
            <div class="w-60 text-right">
               <?php echo $userInfo->Sponsors['username']; ?> 
            </div>
        </div>
        <div class="row margin-top-15">
            <div class="w-40 text-left">
                Status :
            </div>
            <div class="w-60 text-right">
                <?php
                $status_cls = 'inactive-staus';
                $status_txt = 'Inactive';
                if($user['status'] == 1){
                  $status_cls = 'active-staus';
                  $status_txt = 'Active';
                }?>
                <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="card card-body">
        <h4 class="card-title">Profile</h4>
        <?php echo $this->Form->create(NULL, array('id' => 'add_profile_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10">
            <label>Profile Picture</label>
            <?php $rand_id = rand(123456789, 999999999);?>
            <div class="col-xs-12 padding-left-15 padding-right-15">
                <div class="row nopadding" <?php if(empty($is_kyc_approved)){?>onclick="return uploadPhoto('User.attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');"<?php }?>>
                  <div class="col btn_browse">
                    Choose file
                  </div>
                  <div class="col nopadding">
                    <button type="button" class="btn-browse">Browse</button>
                  </div>
                </div>
            </div>
            <div id="<?php echo $rand_id; ?>" class="ccol-xs-12 nopadding margin-top-2 w-100">
            
            </div>
          </div>
          <div class="w-100 height-64">
            <label>Name<span class="red">*</span></label>
            <?php echo $this->Form->input('User.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter name', 'value' => $user['name'])); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>Email<span class="red">*</span></label>
            <?php echo $this->Form->input('User.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter email', 'value' => $user['email'], 'readonly' => 'readonly')); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>Mobile<span class="red">*</span></label>
            <?php echo $this->Form->input('User.contact_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter mobile', 'value' => $user['contact_number'])); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>Aadhar Number<span class="red">*</span></label>
            <?php echo $this->Form->input('User.aadhar_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter aadhar number', 'value' => $user['aadhar_number'])); ?>
          </div>
          <div class="w-100 height-64  margin-top-15">
            <label>PAN Number<span class="red">*</span></label>
            <?php echo $this->Form->input('User.pan_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter PAN number', 'value' => $user['pan_number'])); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>Bank Name<span class="red">*</span></label>
            <?php echo $this->Form->input('User.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter bank name', 'value' => $user['bank_name'])); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>Account Number<span class="red">*</span></label>
            <?php echo $this->Form->input('User.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter account number', 'value' => $user['account_number'])); ?>
          </div>
          <div class="w-100 height-64 margin-top-15">
            <label>IFSC code<span class="red">*</span></label>
            <?php echo $this->Form->input('User.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter IFSC code', 'value' => $user['ifsc_code'])); ?>
          </div>
          <div class="w-100 margin-top-10 card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $home_url; ?>/my-account/profile" class="
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