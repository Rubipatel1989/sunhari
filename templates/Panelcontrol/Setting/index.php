<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Setting</h3>
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
          Setting
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
        <h4 class="card-title">Setting Details</h4>

        <?php echo $this->Form->create(NULL, array('id' => 'activate_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="mb-3 margin-top-10">
            <label>News</label>
            <div class="col-md-11 nopadding">
                <?php 
                echo $this->Form->input('Setting.news', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'value' => $setting->news, 'style' => 'height:110px;')); 
                ?>
            </div>
          </div>
          
          <div class="card-body text-left nopadding">
            <div class="col-md-5 nopadding">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                  <div class="d-flex align-items-center">
                    Submit
                  </div>
                </button>
                <a href="<?php echo $backend_url; ?>/setting/index" class="
                    btn btn-danger
                    rounded-pill
                    px-4
                    ms-2
                    text-white
                  ">
                  Cancel
                </a>
            </div>
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