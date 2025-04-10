<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Add Payment Account</h3>
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
          Add Payment Account
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
        <h4 class="card-title">Payment Account Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'add_payment_account_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10 height-64">
            <label>Account Number<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Payment.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number')); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>Bank Name<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Payment.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank Name')); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>IFSC Code<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Payment.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFSC Code')); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>UPI Id<span class="red">*</span></label>
            <?php echo $this->Form->input('Payment.upi_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'UPI Id')); ?>
          </div>
          <div class="mb-3 margin-bottom-10">
            <label>Barcode<span class="red">*</span></label>
            <div class="col-xs-12 padding-left-15 margin-top-7">
              <div class="row nopadding ajax-upload">
                <div class="w-50 btn_browse">
                  Choose file
                </div>
                <div class="w-50 nopadding">
                  <button type="button" class="btn-browse">Browse</button>
                </div>
              </div>
            </div>
            <div class="row padding-left-15 ajax-upload-container margin-top-10">
            </div>
          </div>
          <div class="mb-3 margin-top-10">
            <label>Remark<span class="red">*</span></label>
            <?php echo $this->Form->input('Payment.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => '100px;', 'required' => 'required')); ?>
          </div>
          <div class="mb-3 margin-top-10">
            <label>Status<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
            echo $this->Form->input('Payment.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
            ?>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4" onclick="displayMessageOnSubmit('activate_user_form');">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $backend_url; ?>/packages/add" class="
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
