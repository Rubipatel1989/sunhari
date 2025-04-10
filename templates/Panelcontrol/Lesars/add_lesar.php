<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Add Lesar</h3>
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
          Add Lesar
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
        <h4 class="card-title">Lesar Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'add_lesar_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10 height-64">
            <label>User Id<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Lesar.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter User Id', 'onchange' => 'return getUserDetails(this);')); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Name<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Lesar.name', array('type' => 'text', 'id' => 'name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Payment Type<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-', 'credit' => 'Credit', 'debit' => 'Debit'];
            echo $this->Form->input('Lesar.payment_type', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Payment Mode<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-', 'net_banking' => 'Net Banking', 'cash' => 'Cash'];
            echo $this->Form->input('Lesar.payment_mode', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options, 'onchange' => 'return showHidePaymentDetails(this);')); 
            ?>
          </div>
          <div id="bank_details_container" style="display:none;">
            <div class="mb-3 height-64">
              <label>Bank Name<span class="red">*</span></label>
              <?php
              echo $this->Form->input('Lesar.bank_name', array('type' => 'text', 'id' => 'bank_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
              ?>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 height-64">
                 <label>Account Number<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('Lesar.account_number', array('type' => 'text', 'id' => 'account_number', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter account number')); 
                  ?>
                </div>
                <div class="col-md-6 height-64">
                  <label>IFSC<span class="red">*</span></label>
                  <?php 
                  echo $this->Form->input('Lesar.ifsc_code', array('type' => 'text', 'id' => 'ifsc_code', 'label' => false, 'div' => false, 'class' => ' form-control loginbox', 'placeholder' => 'Enter IFSC code')); 
                  ?>
                </div>
              </div>
            </div>
            <div class="mb-3 height-64">
              <label>Transaction Id<span class="red">*</span></label>
              <?php
              echo $this->Form->input('Lesar.transaction_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter Transaction Id')); 
              ?>
            </div>
          </div>
          <div id="voucher_code_container" style="display:none;">
            <div class="mb-3 height-64">
              <label>Voucher Code<span class="red">*</span></label>
              <?php
              echo $this->Form->input('Lesar.voucher_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter Voucher Code')); 
              ?>
            </div>
          </div>
          <div class="mb-3 height-64">
            <label>Amount<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Lesar.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter Amount')); 
            ?>
          </div>
          <div class="mb-3" style="height: 110px;">
            <label>Remark<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Lesar.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'style' => 'height: 100px;')); 
            ?>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $backend_url; ?>/lesars/add-lesar" class="
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

<div class="modal fade" id="al-success-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="
        modal-content modal-filled
        
        text-success
      ">
      <div class="modal-body p-4">
        <div class="text-center text-danger">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle fill-white feather-lg"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          <h4 class="mt-2 text-danger">Warning</h4>
          <p id="warning-msg" class="mt-3 text-danger-50">
            
          </p>
          <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
            ok
          </button>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</div>

<button type="button" id="btn-amount-warning" class="
    btn btn-light-success
    text-success
    font-weight-medium
    btn-lg
    px-4
    fs-4
    font-weight-medium
  " data-bs-toggle="modal" data-bs-target="#al-success-alert" style="display: none;">
  Success Alert
</button> 