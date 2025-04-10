<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Raise Withdrawal Request</h3>
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
          Raise Withdrawal Request
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
        <h4 class="card-title">Withdrawal Request Details</h4>
        <?php echo $this->Form->create(NULL, array('id' => 'request_fund_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10 height-64">
            <label>User Id<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Fundrequest.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter referral id', 'onchange' => 'return getFullName(this);')); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Name<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Fundrequest.sponsor_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Amount (Does not accept decimal value)<span class="red">*</span></label>
            <?php echo $this->Form->input('Fundrequest.btc_value', array('type' => 'number', 'min' => 10, 'step' => 1, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); ?>
          </div>
          <div class="mb-3" style="height: 110px;">
            <label>Remark<span class="red">*</span></label>
            <?php echo $this->Form->input('Fundrequest.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => 'height:100px;')); ?>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $home_url; ?>/my-account/wallet/request-fund" class="
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