<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">New Joining</h3>
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
          New Joining
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
        <h4 class="card-title">User Details</h4>
        User Added Successfully
        <fieldset>
            <div class="row margin-top-25">
               <label class="col-sm-2 text-right">Username : </label>
               <div class="col-sm-8">
                  <strong><?php echo $this->request->getSession()->read('username'); ?></strong>
               </div>
            </div>
          </fieldset>
          <fieldset>
            <div class="row margin-top-25">
               <label class="col-sm-2 text-right">Password :</label>
               <div class="col-sm-8">
                  <strong><?php echo $this->request->getSession()->read('password'); ?></strong>
               </div>
            </div>
        </fieldset>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>