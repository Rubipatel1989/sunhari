<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Add Bill</h3>
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
          Add Bill
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
        <h4 class="card-title">Bill Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'add_bill_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <?php
          if ($user->role_id == 2) {?>
            <div class="mb-3 margin-top-10 height-64">
              <label>Customer's Username<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('Bill.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => "Enter customer's username", 'onchange' => 'return getFullName(this, 3), getMBPackages(this);')); 
              ?>
            </div>
            <div class="mb-3 height-64">
              <label>Customer's Name<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('Bill.customer_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
              ?>
            </div>
          <?php 
          }?>
          <div id="package_cotainer" class="mb-3 height-64">
            <label>Package<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-'];
            foreach ($packages as $package) {
              $options[$package->id] = $package->plan_name.'(Rs '.number_format($package->amount, 2).')';
            }
            echo $this->Form->input('Bill.package_id', array('type' => 'select', 'id' => 'dll_package', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return checkPackgeDetails(this);'));
            ?>
          </div>
          <div id="amount_container" class="mb-3 margin-top-10 height-64">
            <label>Amount<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Bill.amount', array('type' => 'text', 'id' => 'bill_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return checkAmountLimit(this);'));
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>Shop Keeper Name<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Bill.shop_keeper_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox'));
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>Mobile Number<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Bill.mobile_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox'));
            ?>
          </div>
          <div class="mb-3">
            <label>Upload Invoice<span class="red">*</span></label>
            <div class="col-xs-12 padding-left-15 margin-top-7">
              <?php $rand_id = rand(123456789, 999999999);?>
              <div class="row nopadding" onclick="return uploadPhoto('Bill.invoice_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                <div class="w-50 btn_browse">
                  Choose file
                </div>
                <div class="w-50 nopadding">
                  <button type="button" class="btn-browse">Browse</button>
                </div>
              </div>
              <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
              </div>
            </div>
            <div class="row padding-left-15 ajax-upload-container margin-top-10">
            </div>
          </div>
          <div class="mb-3">
            <label>Upload Products Image<span class="red">*</span></label>
            <div class="col-xs-12 padding-left-15 margin-top-7">
              <?php $rand_id = rand(123456789, 999999999);?>
              <div class="row nopadding" onclick="return uploadPhoto('Bill.products_attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                <div class="w-50 btn_browse">
                  Choose file
                </div>
                <div class="w-50 nopadding">
                  <button type="button" class="btn-browse">Browse</button>
                </div>
              </div>
              <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
              </div>
            </div>
            <div class="row padding-left-15 ajax-upload-container margin-top-10">
            </div>
          </div>
          <div class="mb-3">
            <label>Cancel Cheque/QR Code Image<span class="red">*</span></label>
            <div class="col-xs-12 padding-left-15 margin-top-7">
              <?php $rand_id = rand(123456789, 999999999);?>
              <div class="row nopadding" onclick="return uploadPhoto('Bill.cancelled_cheque_qr_attachement_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                <div class="w-50 btn_browse">
                  Choose file
                </div>
                <div class="w-50 nopadding">
                  <button type="button" class="btn-browse">Browse</button>
                </div>
              </div>
              <div id="<?php echo $rand_id; ?>" class="row nopadding margin-top-10 qualification-proof">
              </div>
            </div>
            <div class="row padding-left-15 ajax-upload-container margin-top-10">
            </div>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $home_url; ?>/my-account/bills/add" class="
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