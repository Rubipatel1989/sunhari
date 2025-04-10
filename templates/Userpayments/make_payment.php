<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Make Payment</h3>
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
          Make Payment
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
    <?php if ($payment) {?>
      <div class="col-sm-12">
        <div class="card card-body">
          <h4 class="card-title">Payment Account Details</h4>
          <?php echo $this->Form->create(NULL, array('id' => 'request_fund_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
            <div class="mb-3 margin-top-10">
              <div class="row">
                <div class="col-sm-3 text-right">
                  Account Number :
                </div>
                <div class="col-sm-9 text-left">
                  <strong id="referral_link"><?php echo $payment->account_number;?></strong>
                  <!-- <span class="copy-icon" title="Copy" onclick="return copyTextById('referral_link');"><i class="fa fa-copy"></i></span> -->
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-sm-3 text-right">
                  Bank Name :
                </div>
                <div class="col-sm-9 text-left">
                  <strong id="referral_link"><?php echo $payment->bank_name;?></strong>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-sm-3 text-right">
                  IFSC :
                </div>
                <div class="col-sm-9 text-left">
                  <strong id="referral_link"><?php echo $payment->ifsc_code;?></strong>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-sm-3 text-right">
                  UPI Id :
                </div>
                <div class="col-sm-9 text-left">
                  <strong id="referral_link"><?php echo $payment->upi_id;?></strong>
                </div>
              </div>
            </div>
            <?php
            if (isset($payment->Attachments['file']) && $payment->Attachments['file']) {?>
              <div class="mb-3">
                <div class="row">
                  <div class="col-sm-3 text-right">
                    Barcode :
                  </div>
                  <div class="col-sm-3 text-left">
                    <img src="<?php echo $home_url;?>/attachments/<?php echo $payment->Attachments['file']; ?>" width="200">
                  </div>
                </div>
              </div>
            <?php }?>
            <div class="mb-3">
              <div class="row">
                <div class="col-sm-3 text-right">
                  Remark :
                </div>
                <div class="col-sm-3 text-left">
                  <strong><?php echo $payment->remark;?></strong>
                </div>
              </div>
            </div>
            
            <div class="card-body text-center">
              <div class="row">
                <div class="col-sm-3 text-right"></div>
                <div class="col-sm-3 text-left">
                  <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#paymemt_popup">
                    <div class="d-flex align-items-center">
                      Pay
                    </div>
                  </button>
                </div>
              </div>
            </div>
          <?php echo $this->Form->end();?>
        </div>
      </div>
    <?php }?>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>

<div class="modal fade" id="paymemt_popup" tabindex="-1" aria-labelledby="bs-example-modal-lg" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 id="amount_title" class="modal-title" id="myLargeModalLabel">Payment Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create(NULL, array('id' => 'payment_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row height-64">
            <div class="col-sm-3 text-right">
              Amount<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php
              echo $this->Form->input('PendingUpgrade.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox'));
              ?>
            </div>
          </div>
          <div class="row height-64">
            <div class="col-sm-3 text-right">
              Transaction Id<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php echo $this->Form->input('PendingUpgrade.transaction_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter transaction id')); ?>
            </div>
          </div>
          <div class="row height-64">
            <div class="col-sm-3 text-right">
              Payment For<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php
              $options = ['' => '-Select-', 1 => 'Credit to Wallet'];
              if ($packages) {
                $options[2] = 'EMI Payment';
              }
              echo $this->Form->input('PendingUpgrade.payment_for', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return showHidePackage(this)')); 
              ?>
            </div>
          </div>
          <div id="package_container" class="row height-64" style="display:none;">
            <div class="col-sm-3 text-right">
              Package<span class="red">*</span>
            </div>
            <div class="col-sm-9 text-left">
              <?php
              $options = ['' => '-Select-'];
              foreach($packages as $package) {
                $options[$package->id] = $package->plan_name;
              }
              echo $this->Form->input('PendingUpgrade.package_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox',)); 
              ?>
            </div>
          </div>
          <div class="row" style="height: 120px;">
              <div class="col-sm-3 text-right">
                Remark
              </div>
              <div class="col-sm-9 text-left">
                <?php echo $this->Form->input('PendingUpgrade.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter remark', 'style' => 'height: 100px;')); ?>
              </div>
            </div>
            <div class="row margin-top-20">
              <div class="col-sm-3 text-right">
                
              </div>
              <div class="col-sm-9 text-left">
               <button type="submit" class="btn btn-success px-4">
                  <div class="d-flex align-items-center">
                    Submit
                  </div>
                </button>
                <button type="button" class=" btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
        <?php echo $this->Form->end();?>
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="al-success-alert" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="
        modal-content modal-filled
        
        text-success
      ">
      <div class="modal-body p-4">
        <div class="text-center text-success">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle fill-white feather-lg"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          <h4 class="mt-2 text-success">Wallet Address Copied</h4>
          <p class="mt-3 text-success-50">
            <?php echo $payment->account_number;?>
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

<button type="button" id="btn-link-copied" class="
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