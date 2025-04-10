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
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7COpen+Sans:300,300i,400,400i,600,600i,700,800" rel="stylesheet">
    <?= $this->Html->css('backend/css/bootstrap.css') ?>
    <?= $this->Html->css($home_url.'/assests/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css($home_url.'/assests/animo.js/animate-animo.css') ?>
    <?= $this->Html->css($home_url.'/assests/whirl/dist/whirl.css') ?>
    <?= $this->Html->css('backend/css/app.css') ?>
    <?= $this->Html->css('backend/css/common-styles.css') ?>
    <?= $this->Html->css('backend/css/custom.css') ?>
    <?= $this->Html->css('frontend/css/form-validation-style-common.css') ?>

    <?= $this->Html->css($home_url.'/css/jquery.dataTables.min.css') ?>
    <?= $this->Html->css($home_url.'/css/buttons.dataTables.min.css') ?>

    <?= $this->Html->css($home_url.'/assests/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ?>

    <?= $this->Html->css('bootstrap-select.min.css') ?>

    <?= $this->Html->css('frontend/css/jquery.fancybox.css') ?>

    <?= $this->Html->script($home_url.'/assests/modernizr/modernizr.custom.js') ?>

    <?= $this->Html->script($home_url.'/assests/fastclick/lib/fastclick.js') ?>

    <?= $this->Html->script($home_url.'/assests/jquery/dist/jquery.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
  <body>
    <input type="hidden" name="home_url" id="home_url" value="<?php echo $home_url; ?>">
    <input type="hidden" name="backend_url" id="backend_url" value="<?php echo $backend_url; ?>">
    <div class="whirl duo body-loader" style="display: none;">loader</div>
     <!-- START Main wrapper-->
     <div class="wrapper ">
        <!-- START Top Navbar-->
        <nav role="navigation" class="navbar navbar-default navbar-top navbar-fixed-top">
           <!-- START navbar header-->

           <div class="navbar-header">
              <a href="<?php echo $backend_url; ?>/user/dashboard" class="navbar-brand">
                 <div class="brand-logo" style="padding: 3px 5px;">
                    <img src="<?php echo $home_url; ?>/frontend/img/fashioholic-logo.png" alt="App Logo" class="img-responsive" style="width: 155px;">
                 </div>
                 <div class="brand-logo-collapsed">
                    <img src="<?php echo $home_url; ?>/backend/img/logo-single.png" alt="App Logo" class="img-responsive">
                 </div>
              </a>
           </div>
           <!-- END navbar header-->
           <!-- START Nav wrapper-->
           <div class="nav-wrapper">
              <!-- START Left navbar-->
              <ul class="nav navbar-nav">
                 <li>
                    <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                    <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                       <em class="fa fa-navicon"></em>
                    </a>
                    <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                    <a href="#" data-toggle-state="aside-toggled" class="visible-xs">
                       <em class="fa fa-navicon"></em>
                    </a>
                 </li>
                 <!-- START Messages menu (dropdown-list)-->
                 <li class="dropdown dropdown-list">
                    <a href="#" data-toggle="dropdown" data-play="flipInX" class="dropdown-toggle">
                       <em class="fa fa-envelope"></em>
                    </a>
                    <!-- START Dropdown menu-->
                    <ul class="dropdown-menu">
                       <li class="dropdown-menu-header">Unread messages</li>
                       <li class="p-sm">
                          <input type="text" placeholder="Find contacts.." onfocus="javascript:void(0);" class="form-control">
                       </li>
                       <li>
                          <div class="scroll-viewport">
                             <!-- START list group-->
                             <div class="list-group scroll-content">
                                <!-- START list group item-->
                                <a href="#" class="list-group-item">
                                   <div class="media">
                                      <div class="pull-left">
                                         <img src="<?php echo $home_url; ?>/backend/img/user/01.jpg" alt="Image" class="media-object img-circle thumb32">
                                      </div>
                                      <div class="media-body clearfix">
                                         <small class="pull-right">5m</small>
                                         <strong class="media-heading text-primary">
                                            <span class="circle circle-success circle-md"></span>Greg Lewis</strong>
                                         <p class="mb-sm">
                                            <small>Nunc vel dui et leo sagittis fringilla.</small>
                                         </p>
                                      </div>
                                   </div>
                                </a>
                                <!-- END list group item-->
                                <!-- START list group item-->
                                <a href="#" class="list-group-item">
                                   <div class="media">
                                      <div class="pull-left">
                                         <img src="<?php echo $home_url; ?>/backend/img/user/04.jpg" alt="Image" class="media-object img-circle thumb32">
                                      </div>
                                      <div class="media-body clearfix">
                                         <small class="pull-right">3h</small>
                                         <strong class="media-heading text-primary">
                                            <span class="circle circle-success circle-md"></span>Constance Cook</strong>
                                         <p class="mb-sm">
                                            <small>Nunc vel dui et leo sagittis fringilla.</small>
                                         </p>
                                      </div>
                                   </div>
                                </a>
                                <!-- END list group item-->
                                <!-- START list group item-->
                                <a href="#" class="list-group-item">
                                   <div class="media">
                                      <div class="pull-left">
                                         <img src="<?php echo $home_url; ?>/backend/img/user/03.jpg" alt="Image" class="media-object img-circle thumb32">
                                      </div>
                                      <div class="media-body clearfix">
                                         <small class="pull-right">3h</small>
                                         <strong class="media-heading text-primary">
                                            <span class="circle circle-danger circle-md"></span>Cody Barnes</strong>
                                         <p class="mb-sm">
                                            <small>Nunc vel dui et leo sagittis fringilla.</small>
                                         </p>
                                      </div>
                                   </div>
                                </a>
                                <!-- END list group item-->
                                <!-- START list group item-->
                                <a href="#" class="list-group-item">
                                   <div class="media">
                                      <div class="pull-left">
                                         <img src="<?php echo $home_url; ?>/backend/img/user/05.jpg" alt="Image" class="media-object img-circle thumb32">
                                      </div>
                                      <div class="media-body clearfix">
                                         <small class="pull-right">4h</small>
                                         <strong class="media-heading text-primary">
                                            <span class="circle circle-danger circle-md"></span>Gina Robinson</strong>
                                         <p class="mb-sm">
                                            <small>Nunc vel dui et leo sagittis fringilla.</small>
                                         </p>
                                      </div>
                                   </div>
                                </a>
                                <!-- END list group item-->
                                <!-- START list group item-->
                                <a href="#" class="list-group-item">
                                   <div class="media">
                                      <div class="pull-left">
                                         <img src="<?php echo $home_url; ?>/backend/img/user/06.jpg" alt="Image" class="media-object img-circle thumb32">
                                      </div>
                                      <div class="media-body clearfix">
                                         <small class="pull-right">yesterday</small>
                                         <strong class="media-heading text-primary">
                                            <span class="circle circle-danger circle-md"></span>Violet Olson</strong>
                                         <p class="mb-sm">
                                            <small>Nunc vel dui et leo sagittis fringilla.</small>
                                         </p>
                                      </div>
                                   </div>
                                </a>
                                <!-- END list group item-->
                             </div>
                             <!-- END list group-->
                          </div>
                       </li>
                       <!-- START dropdown footer-->
                       <li class="p">
                          <a href="#" class="text-center">
                             <small class="text-primary">More messages</small>
                          </a>
                       </li>
                       <!-- END dropdown footer-->
                    </ul>
                    <!-- END Dropdown menu-->
                 </li>
                 <!-- END Messages menu (dropdown-list)-->
                 
              </ul>
              <!-- END Left navbar-->
             
           </div>
           <!-- END Nav wrapper-->
           <!-- START Search form-->
           <form role="search" action="http://themicon.co/theme/beadmin/v1.1/search.html" class="navbar-form">
              <div class="form-group has-feedback">
                 <input type="text" placeholder="Type and hit Enter.." class="form-control">
                 <div data-toggle="navbar-search-dismiss" class="fa fa-times form-control-feedback"></div>
              </div>
              <button type="submit" class="hidden btn btn-default">Submit</button>
           </form>
           <!-- END Search form-->
        </nav>
        <!-- END Top Navbar-->
        <!-- START aside-->
        <aside class="aside">
           <!-- START Sidebar (left)-->
           <nav class="sidebar">
              <!-- START user info-->
              <div class="item user-block">
                 <!-- User picture-->
                 <div class="user-block-picture">
                    <div class="user-block-status">
                       <img src="<?php echo $home_url; ?>/backend/img/user/02.jpg" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle">
                       <div class="circle circle-success circle-lg"></div>
                    </div>
                    <!-- Status when collapsed-->
                 </div>
                 <!-- Name and Role-->
                 <div class="user-block-info">
                    <span class="user-block-name item-text">Welcome User</span>
                    <span class="user-block-role">UX-Dev</span>
                 </div>
              </div>
              <!-- END user info-->
              <?php echo $this->element('admin_left');?>
           </nav>
           <!-- END Sidebar (left)-->
        </aside>
        <!-- End aside-->
        <!-- START aside-->
        <aside class="offsidebar">
           <!-- START Off Sidebar (right)-->
           <nav>
              <div class="p-lg text-center">
                 <em class="fa fa-user"></em>
                 <strong>Connections</strong>
              </div>
              <ul class="nav">
                 <!-- END user info-->
                 <li class="p">
                    <div class="form-group has-feedback">
                       <input type="text" placeholder="Search contacts.." class="form-control input-sm">
                       <em class="fa fa-search form-control-feedback text-muted"></em>
                    </div>
                 </li>
                 <!-- START list title-->
                 <li class="p">
                    <small class="text-muted">ONLINE</small>
                 </li>
                 <!-- END list title-->
                 <li>
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-success circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/05.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Laura Sam</strong>
                             <br>
                             <small class="text-muted">Lead, Developer</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-success circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/06.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Beverley Pierce</strong>
                             <br>
                             <small class="text-muted">Writer</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-danger circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/07.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Mika Long</strong>
                             <br>
                             <small class="text-muted">System Analyst</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-warning circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/08.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Danielle Berry</strong>
                             <br>
                             <small class="text-muted">Developer</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                 </li>
                 <!-- START list title-->
                 <li class="p">
                    <small class="text-muted">OFFLINE</small>
                 </li>
                 <!-- END list title-->
                 <li>
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/09.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Martin Cooper</strong>
                             <br>
                             <small class="text-muted">Designeer</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                    <!-- START User status-->
                    <a href="#" class="media p mt0">
                       <span class="pull-right">
                          <span class="circle circle-lg"></span>
                       </span>
                       <span class="pull-left">
                          <!-- Contact avatar-->
                          <img src="<?php echo $home_url; ?>/backend/img/user/10.jpg" alt="Image" class="media-object img-circle thumb32">
                       </span>
                       <!-- Contact info-->
                       <span class="media-body">
                          <span class="media-heading">
                             <strong>Daniel Curtis</strong>
                             <br>
                             <small class="text-muted">Designer</small>
                          </span>
                       </span>
                    </a>
                    <!-- END User status-->
                 </li>
                 <li>
                    <div class="p-lg text-center">
                       <!-- Optional link to list more users-->
                       <a href="#" title="See more contacts" class="btn btn-purple btn-sm">
                          <strong>Load more..</strong>
                       </a>
                    </div>
                 </li>
              </ul>
              <!-- Extra items-->
              <div class="p">
                 <p>
                    <small class="text-muted">Tasks completion</small>
                 </p>
                 <div class="progress progress-xs m0">
                    <div role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-success progress-80">
                       <span class="sr-only">80% Complete</span>
                    </div>
                 </div>
              </div>
              <div class="p">
                 <p>
                    <small class="text-muted">Upload quota</small>
                 </p>
                 <div class="progress progress-xs m0">
                    <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-warning progress-40">
                       <span class="sr-only">40% Complete</span>
                    </div>
                 </div>
              </div>
           </nav>
           <!-- END Off Sidebar (right)-->
        </aside>
        <!-- END aside-->
        <!-- START Main section-->
        <section>
           <!-- START Page content-->
           <div class="content-wrapper">
            <?= $this->fetch('content') ?>
           </div>
           <!-- END Page content-->
        </section>
        <!-- END Main section-->
    </div>
    <?= $this->Html->script($home_url.'/assests/bootstrap/dist/js/bootstrap.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/chosen/chosen.jquery.js') ?>
    <?= $this->Html->script($home_url.'/assests/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/bootstrap-filestyle/src/bootstrap-filestyle.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/animo.js/animo.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/sparkline/index.js') ?>
    <?= $this->Html->script($home_url.'/assests/slimScroll/jquery.slimscroll.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/store-js/store%2bjson2.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/screenfull/dist/screenfull.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot/jquery.flot.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot.tooltip/js/jquery.flot.tooltip.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot/jquery.flot.resize.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot/jquery.flot.pie.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot/jquery.flot.time.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot/jquery.flot.categories.js') ?>
    <?= $this->Html->script($home_url.'/assests/flot-spline/js/jquery.flot.spline.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/ika.jvectormap/jquery-jvectormap-1.2.2.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/ika.jvectormap/jquery-jvectormap-us-mill-en.js') ?>

    <?= $this->Html->script($home_url.'/js/datatable/jquery.dataTables.min.js') ?>
    <?= $this->Html->script($home_url.'/js/datatable/dataTables.buttons.min.js') ?>
    <?= $this->Html->script($home_url.'/js/datatable/pdfmake.min.js') ?>
    <?= $this->Html->script($home_url.'/js/datatable/vfs_fonts.js') ?>
    <?= $this->Html->script($home_url.'/js/datatable/7.html5.min.js') ?>

    <?= $this->Html->script($home_url.'/js/dataTables.buttons.min.js') ?>
    <?= $this->Html->script($home_url.'/js/jszip.min.js') ?>>
    <?= $this->Html->script($home_url.'/js/buttons.html5.min.js') ?>


    <?= $this->Html->script('backend/app.js') ?>
    <?= $this->Html->script($home_url.'/js/backend/dataTables.js') ?>
    <?= $this->Html->script('frontend/jquery.validate.min.js') ?>
    <?= $this->Html->script('frontend/additional-methods.js') ?>
    <?= $this->Html->script($home_url.'/js/frontend/jquery.fancybox.js') ?>
    <?= $this->Html->script($home_url.'/assests/moment/min/moment-with-locales.min.js') ?>
    <?= $this->Html->script($home_url.'/assests/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ?>
    <?= $this->Html->script('bootstrap-select.min.js') ?>
    <?= $this->Html->script('backend/custom.js') ?>
    <?= $this->Html->script('functions.js') ?>
  </body>
</html>
