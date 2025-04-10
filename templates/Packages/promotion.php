<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Promotion</h3>
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
          Promotion
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
        <h4 class="card-title">Promotion Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'promotion_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10">
            Wallet Balance <strong>Rs <?php echo number_format($wallet->total_wallet_amount, 2); ?></strong>
          </div>
          <?php
          if ($user['role_id'] == 2) {?>
            <div class="mb-3 margin-top-10 height-64">
              <label>Customer's Username<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('Promotion.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => "Enter customer's username", 'onchange' => 'return getFullName(this, 3);')); 
              ?>
            </div>
            <div class="mb-3 height-64">
              <label>Customer's Name<span class="red">*</span></label>
              <?php 
              echo $this->Form->input('Promotion.customer_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
              ?>
            </div>
          <?php 
          }?>
          <div class="mb-3 margin-top-10 height-64">
            <label>Package Amount<span class="red">*</span></label>
            <?php
            $options = $this->UserData->getPlanListDdl();
            echo $this->Form->input('Promotion.plan_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox'));
            ?>
          </div>
          <div class="mb-3 margin-top-10 height-64">
            <label>Package Amount With GST<span class="red">*</span></label>
            <?php
            echo $this->Form->input('Promotion.package_with_gst_amount', array('type' => 'text', 'id' => 'package_with_gst_amount', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly'));
            ?>
          </div>
          <div class="card-body text-center">
            <button type="submit" class="btn btn-success rounded-pill px-4">
              <div class="d-flex align-items-center">
                Submit
              </div>
            </button>
            <a href="<?php echo $home_url; ?>/my-account/packages/promotion" class="
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