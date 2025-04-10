<div class="page-header larger parallax custom" style="background-image:url(<?php echo $home_url; ?>/frontend/img/page-header-bg.jpg)">
    <div class="container">
        <h1>Registration Completed</h1>
    </div><!-- End .container -->
</div><!-- End .page-header -->

<div class="container">
    <div class="col-xs-12 nopadding">
        <?php echo $this->Flash->render(); ?>
    </div>
    <div class="col-xs-12 nopadding">
        <h2 class="mb30">Registration Completed</h2>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group height-20">
                    <strong>Username : </strong> <?php echo $this->request->getSession()->read('username'); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group height-20">
                    <strong>Password : </strong> <?php echo $this->request->getSession()->read('password'); ?>
                </div>
            </div>
        </div>
         <div class="form-group height-70 mb5 margin-top-30">
            <a href="<?php echo $home_url;?>/login" class="btn btn-custom min-width">Login</a> &nbsp; <a href="<?php echo $home_url;?>/register" class="btn btn-custom min-width">Register</a>
        </div><!-- End .from-group -->
    </div>
</div><!-- End .container -->

<div class="mb80"></div><!-- margin -->