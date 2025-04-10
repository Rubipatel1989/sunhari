<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">  Add User</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      New Registration
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       <form name="add_user_form"  id="add_user_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                        <legend>User Added Successfully</legend>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Username : </label>
                               <div class="col-sm-8">
                                  <?php echo $this->request->getSession()->read('username'); ?>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Password :</label>
                               <div class="col-sm-8">
                                  <?php echo $this->request->getSession()->read('password'); ?>
                               </div>
                            </div>
                          </fieldset>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>