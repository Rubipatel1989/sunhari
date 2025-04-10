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
    <?= $this->Html->css('frontend/css/plugins.min.css') ?>
    <?= $this->Html->css('frontend/css/settings.css') ?>
    <?= $this->Html->css('frontend/css/layers.css') ?>
    <?= $this->Html->css('frontend/css/navigation.css') ?>
    <?= $this->Html->css('frontend/css/style.css') ?>
    <?= $this->Html->css('frontend/css/common.css') ?>
    <?= $this->Html->css('frontend/css/custom.css') ?>

    <?= $this->Html->script('frontend/plugins.min.js') ?>
    <?= $this->Html->script('frontend/main.js') ?>
    <?= $this->Html->script('frontend/jquery.themepunch.tools.min.js') ?>
    <?= $this->Html->script('frontend/jquery.themepunch.revolution.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.actions.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.carousel.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.kenburn.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.layeranimation.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.migration.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.navigation.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.parallax.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.slideanims.min.js') ?>
    <?= $this->Html->script('frontend/extensions/revolution.extension.video.min.js') ?>
    <?= $this->Html->script('frontend/home.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="transparent-sticky-header">
        <div id="wrapper">
            <header class="header header2 transparent light sticky-header">
                <div class="header-inner">
                    <div class="container">
                        <a href="<?php echo $home_url; ?>" class="site-logo" title="MLM">
                            <img src="<?php echo $home_url; ?>/frontend/img/fashioholic-logo.png" alt="MLM">
                            <span class="sr-only">MLM</span>
                        </a>

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav-container" aria-expanded="false">
                            <span class="toggle-text">Menu</span>
                            <span class="toggle-wrapper">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="main-nav-container">
                            <ul class="nav navbar-nav">
                                <!--<li class="<?php if($curr_page == ''){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>">Home</a></li>
                                <li class="<?php if($curr_page == 'about-us'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/about-us">About Us</a></li>
                                <li class="<?php if($curr_page == 'investments'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/investments">Investments</a></li>
                                <li class="<?php if($curr_page == 'representatives'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/representatives">Representatives</a></li>
                                <li class="<?php if($curr_page == 'contact-us'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/contact-us">Contact Us</a></li>-->
                                <?php
                                if($this->request->getSession()->check('userId')){?>
                                    <li class="<?php if($curr_page == 'my-account'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/my-account">My Account</a></li>
                                    <li class="<?php if($curr_page == 'logout'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/logout">Logout</a></li>
                                <?php
                                }else{?>
                                    <li class="<?php if($curr_page == 'register'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/register">Register</a></li>
                                    <li class="<?php if($curr_page == 'login'){ echo 'active'; }?>"><a href="<?php echo $home_url; ?>/login">Login</a></li>
                                <?php
                                }?>
                            </ul>
                        </div><!-- /.navbar-collapse -->

                    </div><!-- End .container -->
                </div><!-- End .header-inner -->
            </header><!-- End .header -->
            
            <div class="main">
                <?= $this->fetch('content') ?>
            </div><!-- End .main -->

            <footer class="footer">
              <?php echo $this->element('footer'); ?>
            </footer><!-- End .footer -->
        </div><!-- End #wrapper -->
        
        <a id="scroll-top" href="#top" title="Scroll top"><i class="fa fa-angle-up"></i></a>
        <!-- End -->
    </body>
</html>
