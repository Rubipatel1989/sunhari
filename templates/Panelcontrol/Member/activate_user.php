<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Activate User</h3>
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
          Activate User
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
        <h4 class="card-title">Activation Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'activate_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10 height-64">
            <label>User Id<span class="red">*</span></label>
            <?php 
            $username = '';
            if(isset($this->request->getData()["Upgrade"]["username"]) && $this->request->getData()["Upgrade"]["username"]) {
              $username = $this->request->getData()["Upgrade"]["username"];
            } elseif(isset($userData->username)) {
              $username = $userData->username;
            }
            echo $this->Form->input('Upgrade.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter referral id', 'onchange' => 'return getFullName(this);', 'value' => $username)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Name<span class="red">*</span></label>
            <?php
            $name = '';
            if(isset($this->request->getData()["Upgrade"]["sponsor_name"]) && $this->request->getData()["Upgrade"]["sponsor_name"]) {
              $name = $this->request->getData()["Upgrade"]["sponsor_name"];
            } elseif(isset($userData->name)) {
              $name = $userData->name;
            }
            echo $this->Form->input('Upgrade.sponsor_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly', 'value' => $name)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Package Amount<span class="red">*</span></label>
            <?php
            $amount = '';
            if(isset($this->request->getData()["Upgrade"]["package_amount"]) && $this->request->getData()["Upgrade"]["package_amount"]) {
              $amount = $this->request->getData()["Upgrade"]["package_amount"];
            } elseif(isset($_GET['amount'])) {
              $amount = $_GET['amount'];
            }
            echo $this->Form->input('Upgrade.package_amount', array('type' => 'text', 'id' => 'package_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter amount', 'value' => $amount)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>ROI Percentage<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-'];
            foreach($rois as $roi) {
              $options[$roi->percentage] = $roi->percentage;
            }
            echo $this->Form->input('Upgrade.roi_amount', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
            ?>
          </div>
          <div class="card-body text-center">
            <button type="button" class="btn btn-success rounded-pill px-4" onclick="displayMessageOnSubmit('activate_user_form');">
              <div class="d-flex align-items-center">
                Topup
              </div>
            </button>
            <a href="<?php echo $backend_url; ?>/member/activate-user" class="
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
