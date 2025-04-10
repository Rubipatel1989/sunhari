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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,800" rel="stylesheet">
    <?= $this->Html->css('backend/css/bootstrap.css') ?>
    <?= $this->Html->css($home_url.'/assests/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css($home_url.'/assests/animo.js/animate-animo.css') ?>
    <?= $this->Html->css('backend/css/app.css') ?>
    <?= $this->Html->css('backend/css/common.css') ?>
    <?= $this->Html->css('backend/css/common-styles.css') ?>
    <?= $this->Html->css('frontend/css/form-validation-style-common.css') ?>
    <?= $this->Html->css('backend/css/login.css') ?>
    

    <?= $this->Html->script($home_url.'/assests/modernizr/modernizr.custom.js') ?>
    <?= $this->Html->script($home_url.'/assests/fastclick/lib/fastclick.js') ?>
    <?= $this->Html->script($home_url.'/assests/jquery/dist/jquery.min.js') ?>

    <?= $this->Html->script($home_url.'/assests/bootstrap/dist/js/bootstrap.min.js') ?>
    <?= $this->Html->script('backend/pages.js') ?>


    <?= $this->Html->script('frontend/jquery.validate.min.js') ?>
    <?= $this->Html->script('frontend/additional-methods.js') ?>
    <?= $this->Html->script('backend/login.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
   <!-- START wrapper-->
   <div class="row row-table page-wrapper">
      <div class="col-lg-3 col-md-6 col-sm-8 col-xs-12 align-middle">
         <!-- START panel-->
         <div data-toggle="play-animation" data-play="fadeIn" data-offset="0" class="panel panel-dark panel-flat">
            <div class="panel-heading text-center">
               <a href="#">
                  <img src="<?php echo $home_url; ?>/frontend/img/logo.png" alt="Image" class="block-center img-rounded">
               </a>
               <p class="text-center mt-lg">
                  <strong>SIGN IN TO CONTINUE.</strong>
               </p>
            </div>
            <div class="panel-body">
                <?= $this->fetch('content') ?>
            </div>
         </div>
         <!-- END panel-->
      </div>
   </div>
</body>
</html>
