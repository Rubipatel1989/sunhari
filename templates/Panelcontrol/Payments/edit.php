<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Edit Payment Account</h3>
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
          Edit Payment Account
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
            echo $this->Form->input('Payment.account_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Account Number', 'value' => $payment->account_number)); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>Bank Name<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Payment.bank_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank Name', 'value' => $payment->bank_name)); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>IFSC Code<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('Payment.ifsc_code', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFSC Code', 'value' => $payment->ifsc_code)); 
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>UPI Id<span class="red">*</span></label>
            <?php echo $this->Form->input('Payment.upi_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'UPI Id', 'value' => $payment->upi_id)); ?>
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
              <?php
              if($payment->Attachments['file']){
                $attachment = $payment->Attachments;
                $ex_file = explode(".", $attachment['file']);
                if(strtolower($ex_file[1]) == 'pdf'){
                  $attachment_file = 'frontend/img/pdf-default.png';
                  $cls = "";
                  $link = $home_url.'attachments/'.$attachment['file'];
                }
                elseif(strtolower($ex_file[1]) == 'doc'){
                  $attachment_file = 'frontend/img/msdoc-default.gif';
                  $cls = "";
                  $link = $home_url.'/attachments/'.$attachment['file'];
                }
                elseif(strtolower($ex_file[1]) == 'mp4'){
                  $attachment_file = 'frontend/img/video-default.png';
                  $cls = "fancybox fancybox.ajax";
                  $link = $home_url.'/ajax/show_attachments/'.$attachment['id'];
                }else{
                  $attachment_file = 'attachments/'.$attachment['file'];
                  $cls = "fancybox fancybox.ajax";
                  $link = $home_url.'/ajax/show_attachments/'.$attachment['id'];
                }
              ?>
                <div class="attchment-container">
                  <div class="col-xs-12 attchment-inner-container">
                    <div class="col-xs-12 nopadding">
                      <span class="remove-attachment-container" onclick="return removeAttachment(this, '<?php echo $attachment['id']; ?>');" title="Remove"><i class="fa fa-times"></i></span>
                      <a href="<?php echo $link; ?>" class="<?php echo $cls; ?>" target="_blank"><img src="<?php echo $home_url; ?>/<?php echo $attachment_file; ?>" alt="<?php echo $attachment['caption']; ?>" /></a>
                      <?php echo $this->Form->input('Attachment.id.', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $attachment['id'])); ?>
                    </div>
                  </div>
                  <div class="col-xs-12 padding-left-10 padding-right-10 margin-top-12">
                    <?php echo $this->Form->input('Attachment.caption.', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Caption', 'value' => $attachment['caption'])); ?>
                  </div>
                </div>
              <?php
              }?>
            </div>
          </div>
          <div class="mb-3 margin-top-10">
            <label>Remark<span class="red">*</span></label>
            <?php echo $this->Form->input('Payment.remark', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'style' => '100px;', 'required' => 'required', 'value' => $payment->remark)); ?>
          </div>
          <div class="mb-3 margin-top-10">
            <label>Status<span class="red">*</span></label>
            <?php 
            $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
            echo $this->Form->input('Payment.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $payment->status)); 
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
