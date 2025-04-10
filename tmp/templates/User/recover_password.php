<div class="page-header larger parallax custom" style="background-image:url(<?php echo $home_url; ?>/frontend/img/page-header-bg.jpg)">
    <div class="container">
        <h1>Recover Password</h1>
        <!--<ol class="breadcrumb">
            <li><a href="<?php echo $home_url; ?>">Home</a></li>
            <li class="active">Login</li>
        </ol>-->
    </div><!-- End .container -->
</div><!-- End .page-header -->

<div class="container">
    <div class="row">
        <div class="col-xs-12 nopadding">
            <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xs-12 nopadding">
            <div class="col-sm-12 ">
                <h2 class="mb30">Recover Password</h2>

                    <?php echo $this->Form->create(NULL, array('id' => 'recover_password_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="form-group">
                            <div class="col-xs-12 nopadding">
                                <div class="col-md-5 padding-left-pc-0 padding-right-pc-10  height-70">
                                    <label>Registered Contact Number</label>
                                    <?php echo $this->Form->input('Detail.contact_no', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter number with country code e.g. 919336945285')); ?>
                                </div>
                            </div>
                        </div>
                       <!--  <div class="form-group">
                            <div class="col-xs-12 nopadding">
                                <div class="col-md-5 nopadding margin-top-20 text-center">
                                    <strong>OR</strong>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 nopadding">
                                <div class="col-md-5 padding-left-pc-0 padding-right-pc-0  height-70 margin-top-20">
                                    <label>Registered Email</label>
                                    <?php echo $this->Form->input('User.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter email')); ?>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-xs-12 nopadding">
                                <div class="col-md-5 padding-left-pc-0 padding-right-pc-0  height-70 margin-top-20">
                                    <label>Username</label>
                                    <?php echo $this->Form->input('User.username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter username')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-12 nopadding  margin-top-30"> 
                            <button type="submit" class="btn btn-custom min-width">Recover Now</button>
                          </div>
                        </div>
                    <?php echo $this->Form->end();?>
            </div><!-- End .col-sm-6 -->
        </div>
    </div><!-- End .row -->
</div><!-- End .container -->

<div class="mb80"></div><!-- margin -->