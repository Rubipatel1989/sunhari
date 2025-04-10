<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$ex_curr_url = explode("/", $_SERVER['REQUEST_URI']);
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $curr_page = $ex_curr_url[2];
}else{
    $curr_page = $ex_curr_url[1];
}
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <title>
        <?php
        if(isset($title)){
            echo  $title;
        }else{
            echo  $this->fetch('title');
        }
        ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css($home_url.'/dist/css/vendors.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/app.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/skins/skin-master.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/fa-brands.css') ?>


    <?= $this->Html->css($home_url.'/assests/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('frontend/css/form-validation-style-common.css') ?>
    <?= $this->Html->css('backend/css/login.css') ?>
    

    <?= $this->Html->script($home_url.'/assests/jquery/dist/jquery.min.js') ?>

    <?= $this->Html->script('frontend/jquery.validate.min.js') ?>
    <?= $this->Html->script('frontend/additional-methods.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
 <body>
        <!-- DOC: script to save and load page settings -->
        
        <div class="page-wrapper auth">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class=" w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="<?php echo $home_url; ?>/frontend/img/logo.jpeg" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                    <span class="page-logo-text mr-1">JSKS Infratech</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <div class="row">
                                <?= $this->fetch('content') ?>
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                                <?php echo date('Y'); ?> © JSKS Infratech 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN Color profile -->
        <?= $this->Html->css($home_url.'/dist/js/vendors.bundle.js') ?>
        <?= $this->Html->css($home_url.'/dist/js/app.bundle.js') ?>
        <script>
            $("#js-login-btn").click(function(event)
            {
                // Fetch form to apply custom Bootstrap validation
                var form = $("#js-login")

                if (form[0].checkValidity() === false)
                {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });
        </script>
    </body>
</html>
