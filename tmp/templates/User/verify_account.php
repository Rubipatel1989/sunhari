<div class="page-header larger parallax custom" style="background-image:url(<?php echo $home_url; ?>/frontend/img/page-header-bg.jpg)">
    <div class="container">
        <h1>Register</h1>
        <!--<ol class="breadcrumb">
            <li><a href="<?php echo $home_url; ?>">Home</a></li>
            <li class="active">Verify Account</li>
        </ol>-->
    </div><!-- End .container -->
</div><!-- End .page-header -->

<div class="container">
    <div class="col-xs-12 nopadding">
        <?php echo $this->Flash->render(); ?>
    </div>
    <div class="col-xs-12 nopadding">
        <h2 class="mb30">Verify Account</h2>
        <?php echo $this->Form->create(NULL, array('id' => 'registrtion_otp_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group height-70">
                        <label>OTP</label>
                        <?php                         
                        echo $this->Form->input('User.otp', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter OTP'));
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 ">
                </div>
            </div>

            <div class="form-group height-70 mb5 margin-top-30">
                <input name="btn_verify" type="submit" class="btn btn-custom min-width" value="Verify">
                &nbsp;&nbsp; <input name="btn_resend" type="submit" class="btn btn-custom min-width" value="Re-send OTP">
            </div><!-- End .from-group -->
        <?php echo $this->Form->end();?>

    </div>
</div><!-- End .container -->

<div class="mb80"></div><!-- margin -->