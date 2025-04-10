<?php
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
    <title>
        <?php
        if(isset($title)){
            echo  $title;
        }else{
            echo  $this->fetch('title');
        }
        ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
     <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
     <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    
    <?= $this->Html->css($home_url.'/dist/css/vendors.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/app.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/skins/skin-master.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/datagrid/datatables/datatables.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/formplugins/select2/select2.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') ?>

    <?= $this->Html->css($home_url.'/assests/font-awesome/css/font-awesome.min.css') ?>

    <?= $this->Html->css('backend/css/common-styles.css') ?>
    <?= $this->Html->css('backend/css/custom.css') ?>
    <?= $this->Html->css('frontend/css/form-validation-style-common.css') ?>

    <?= $this->Html->css('frontend/css/jquery.fancybox.css') ?>

    <?= $this->Html->script($home_url.'/assests/jquery/dist/jquery.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
 <input type="hidden" name="home_url" id="home_url" value="<?php echo $home_url; ?>">
    <input type="hidden" name="backend_url" id="backend_url" value="<?php echo $backend_url; ?>">
  <body id="main_body_container" class="mod-bg-1 mod-nav-link">
    <div class="whirl duo body-loader" style="display: none;">
            <div class="spinner-border rounded-0 text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    <div class="panel-container show">
        <!-- DOC: script to save and load page settings -->
        <script>
            /**
             * This script should be placed right after the body tag for fast execution 
             * Note: the script is written in pure javascript and does not depend on thirdparty library
             **/
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],
                /** 
                 * Load from localstorage
                 **/
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /** 
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);

            }
            else if (themeSettings.themeURL && document.getElementById('mytheme'))
            {
                document.getElementById('mytheme').href = themeSettings.themeURL;
            }
            /** 
             * Save to localstorage 
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|footer|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /** 
             * Reset settings
             **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }

        </script>
        <!-- BEGIN Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-inner">
                <!-- BEGIN Left Aside -->
                <?php echo $this->element('admin_left_blue');?>
                <!-- END Left Aside -->
                <div class="page-content-wrapper">
                    <!-- BEGIN Page Header -->
                    <header class="page-header" role="banner">
                        <!-- we need this logo when user switches to nav-function-top -->
                        <div class="page-logo">
                            <a href="<?php echo $backend_url; ?>/user/dashboard" class="page-logo-link press-scale-down d-flex align-items-center position-relative">
                                <img src="<?php echo $home_url; ?>/frontend/img/logo.jpeg" alt="JSKS Infratech" aria-roledescription="logo">
                            </a>
                        </div>
                        <!-- DOC: nav menu layout change shortcut -->
                        <div class="hidden-md-down dropdown-icon-menu position-relative">
                            <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
                                <i class="ni ni-menu"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                                        <i class="ni ni-minify-nav"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                                        <i class="ni ni-lock-nav"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- DOC: mobile button appears during mobile width -->
                        <div class="hidden-lg-up">
                            <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                                <i class="ni ni-menu"></i>
                            </a>
                        </div>
                    </header>
                    <!-- END Page Header -->
                    <!-- BEGIN Page Content -->
                    <!-- the #js-page-content id is needed for some plugins to initialize -->
                    <?= $this->fetch('content') ?>
                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                    <!-- BEGIN Page Footer -->
                    <footer class="page-footer" role="contentinfo">
                        <div class="d-flex align-items-center flex-1 text-muted">
                            <span class="hidden-md-down fw-700"><?php echo date('Y'); ?> © JSKS Infratech&nbsp;</span>
                        </div>
                        <div>
                            
                        </div>
                    </footer>
                    <!-- END Page Footer -->
                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->
        <!-- BEGIN Quick Menu -->
        <!-- to add more items, please make sure to change the variable '$menu-items: number;' in your _page-components-shortcut.scss -->
        <nav class="shortcut-menu d-none d-sm-block">
            <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
            <label for="menu_open" class="menu-open-button ">
                <span class="app-shortcut-icon d-block"></span>
            </label>
            <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
                <i class="fal fa-arrow-up"></i>
            </a>
            <a href="<?php echo $backend_url ?>/user/logout" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Logout">
                <i class="fal fa-sign-out"></i>
            </a>
            <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
                <i class="fal fa-expand"></i>
            </a>
            <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Print page">
                <i class="fal fa-print"></i>
            </a>
        </nav>
        <!-- END Quick Menu -->
        <?= $this->Html->script($home_url.'/dist/js/vendors.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/app.bundle.js') ?>
        <script type="text/javascript">
            /* Activate smart panels */
            $('#js-page-content').smartPanel();

        </script>
        <!-- The order of scripts is irrelevant. Please check out the plugin pages for more details about these plugins below: -->
        <?= $this->Html->script($home_url.'/dist/js/statistics/peity/peity.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/statistics/flot/flot.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/statistics/easypiechart/easypiechart.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/formplugins/select2/select2.bundle.js') ?>
        <?= $this->Html->script($home_url.'/dist/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') ?>

        <?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.export.js') ?>
        <?= $this->Html->script('frontend/jquery.validate.min.js') ?>
        <?= $this->Html->script('frontend/additional-methods.js') ?>
        <?= $this->Html->script($home_url.'/js/frontend/jquery.fancybox.js') ?>

        <?= $this->Html->script('backend/custom.js') ?>
        <?= $this->Html->script('backend/dataTables.js') ?>
        <?= $this->Html->script('functions.js') ?>

        <script>
            var controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            }
            $(document).ready(function() {
                $('.select2').select2();

                $('.dob').datepicker({
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: controls,
                    format: 'dd-mm-yyyy'
                });
            });
        </script>
    </body>
</html>
