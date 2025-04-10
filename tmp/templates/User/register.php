<div class="page-header larger parallax custom" style="background-image:url(<?php echo $home_url; ?>/frontend/img/page-header-bg.jpg)">
    <div class="container">
        <h1>Join Us</h1>
        <!--<ol class="breadcrumb">
            <li><a href="<?php echo $home_url; ?>">Home</a></li>
            <li class="active">Register</li>
        </ol>-->
    </div><!-- End .container -->
</div><!-- End .page-header -->

<div class="container">
    <div class="col-xs-12 nopadding">
        <?php echo $this->Flash->render(); ?>
    </div>
    <div class="col-xs-12 nopadding">
        <h2 class="mb30">Fill Form Details</h2>
        <?php echo $this->Form->create(NULL, array('id' => 'registration-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group height-70">
                        <label>Referral Id</label>
                        <?php 
                        $readonly = '';
                        $sponser_username = '';
                        if(isset($this->request->data['User']['sponser_username']) && !empty($this->request->data['User']['sponser_username'])){
                            $sponser_username = $this->request->data['User']['sponser_username'];
                        }
                        elseif(isset($referralInfo->username)){
                            $sponser_username = $referralInfo->username;
                            $readonly = 'readonly';
                        }
                        echo $this->Form->input('User.sponser_username', array('type' => 'text', 'id' => 'sponser_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Referral Id', 'value' => $sponser_username, $readonly));
                         ?>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group height-70">
                        <label>Referral Name</label>
                        <?php 
                        $sponsor_name = '';
                        if(isset($this->request->data['User']['sponsor_name']) && !empty($this->request->data['User']['sponsor_name'])){
                            $sponsor_name = $this->request->data['User']['sponsor_name'];
                        }
                        elseif(isset($referralInfo->Details['first_name'])){
                            $sponsor_name = $referralInfo->Details['first_name'].' '.$referralInfo->Details['last_name'] ;
                        }
                        
                        echo $this->Form->input('User.sponsor_name', array('type' => 'text', 'id' => 'sponsor_name', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Referral Name', 'value' => $sponsor_name, 'readonly' => 'readonly')); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 ">
                    <div class="form-group height-70">
                        <label>Position</label>
                        <?php 
                        $options = ['' => '-Select-', 'left' => 'Left', 'right' => 'Right'];
                        $readonly = '';
                        $style = "";
                        if($referredPosition == 'left' || $referredPosition == 'right' ){
                            $readonly = 'readonly';
                            $style = "pointer-events: none;";
                        }
                        echo $this->Form->input('User.position', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Referral Name', 'value' => $referredPosition, $readonly, 'style' => $style)); 
                        ?>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="col-xs-12 nopadding">
                        <div class="col-xs-6 padding-left-0 padding-right-8">
                            <div class="form-group height-70">
                                <div class="form-group height-70">
                                    <label>First Name</label>
                                    <?php echo $this->Form->input('Detail.first_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'First Name'));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 padding-left-8 padding-right-0">
                            <div class="form-group height-70">
                                <div class="form-group height-70">
                                    <label>Last Name</label>
                                    <?php echo $this->Form->input('Detail.last_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Last Name'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 ">
                    <div class="form-group height-70">
                        <label>Email</label>
                        <?php echo $this->Form->input('User.email', array('type' => 'text', 'id' => 'email', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Email'));?>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-group height-70">
                        <label>Contact Number</label>
                        <?php echo $this->Form->input('Detail.contact_no', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Please enter contact number with country code e.g. 919336914285'));?>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-sm-6 ">
                    <div class="form-group height-70">
                        <label>Username</label>
                        <?php //echo $this->Form->input('User.username', array('type' => 'text', 'id' => 'username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Username'));?>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="col-xs-12 nopadding">
                        <div class="col-xs-6 padding-left-0 padding-right-8">
                            <div class="form-group height-70">
                                <div class="form-group height-70">
                                    <label>Password</label>
                                    <?php //echo $this->Form->input('User.password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Password'));?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 padding-left-8 padding-right-0">
                            <div class="form-group height-70">
                                <div class="form-group height-70">
                                    <label>Confirm Password</label>
                                    <?php //echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Confirm Password'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="mb10"></div>

            <div class="form-group mb0">
                <div class="checkbox">
                  <label class="custom-checkbox-wrapper">
                    <span class="custom-checkbox-container">
                        <input type="checkbox" name="is_agree" value="true">
                        <span class="custom-checkbox-icon"></span>
                    </span>
                   <span>I have read and agree on the <a href="<?php echo $home_url ?>/privacy-policy" target="_blank">Term & Conditions</a>.</span>
                  </label>
                </div><!-- End .checkbox -->
            </div><!-- End .form-group height-70 -->

            <div class="form-group height-70 mb5 margin-top-30">
                <input type="submit" class="btn btn-custom min-width" value="Register Now">
            </div><!-- End .from-group -->
        <?php echo $this->Form->end();?>
    </div>
</div><!-- End .container -->

<div class="mb80"></div><!-- margin -->