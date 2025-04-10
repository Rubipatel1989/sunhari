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
    <?= $this->Html->meta('icon', $home_url.'/favicon.png') ?>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    <?= $this->Html->css($home_url.'/dist/css/vendors.bundle.css') ?>
    <?= $this->Html->css($home_url.'/dist/libs/css/jquery-jvectormap.css') ?>
    <?= $this->Html->css($home_url.'/dist/libs/css/style.min.css') ?>
    <?= $this->Html->css($home_url.'/assests/font-awesome/css/font-awesome.min.css') ?>
    <?= $this->Html->css('frontend/css/form-validation-style-common.css') ?>
    <?= $this->Html->css('backend/css/common-styles.css') ?>
    <?= $this->Html->css($home_url.'/dist/css/datagrid/datatables/datatables.bundle.css') ?>
    <?= $this->Html->css('frontend/css/jquery.fancybox.css') ?>
    <?= $this->Html->css('backend/css/custom.css') ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/jquery.min.js') ?>
</head>
<input type="hidden" name="home_url" id="home_url" value="<?php echo $home_url; ?>">
<input type="hidden" name="backend_url" id="backend_url" value="<?php echo $backend_url; ?>">
<body>
    <div class="whirl duo body-loader" style="display: none;">
        <div class="spinner-border rounded-0 text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <div class="preloader">
      <svg
        class="tea lds-ripple"
        width="37"
        height="48"
        viewbox="0 0 37 48"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z"
          stroke="#2962FF"
          stroke-width="2"
        ></path>
        <path
          d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34"
          stroke="#2962FF"
          stroke-width="2"
        ></path>
        <path
          id="teabag"
          fill="#2962FF"
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"
        ></path>
        <path
          id="steamL"
          d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke="#2962FF"
        ></path>
        <path
          id="steamR"
          d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13"
          stroke="#2962FF"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
      </svg>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- -------------------------------------------------------------- -->
    <div id="main-wrapper">
      <!-- -------------------------------------------------------------- -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- -------------------------------------------------------------- -->
      <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a
              class="nav-toggler waves-effect waves-light d-block d-md-none"
              href="javascript:void(0)"
            >
              <i class="ri-close-line fs-6 ri-menu-2-line"></i>
            </a>
            <!-- -------------------------------------------------------------- -->
            <!-- Logo -->
            <!-- -------------------------------------------------------------- -->
            <a class="navbar-brand" href="<?php echo $backend_url; ?>/user/dashboard">
              <!-- Logo icon -->
              <b class="logo-icon">
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="<?php echo $home_url; ?>/dist/libs/images/logo.jpg" alt="homepage" class="dark-logo" style="width: 55px;"/>
                <!-- Light Logo icon -->
                <img src="<?php echo $home_url; ?>/dist/libs/images/logo.jpg"  alt="homepage" class="light-logo" style="width: 55px;"/>
              </b>
              <!--End Logo icon -->
              <!-- Logo text -->
              <span class="logo-text">
                <span style="color: #fff;text-transform: uppercase;font-weight: 500;font-size: 20px;">Daulat Pride</span>
              </span>
            </a>
            <!-- -------------------------------------------------------------- -->
            <!-- End Logo -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
            <!-- Toggle which is visible on mobile only -->
            <!-- -------------------------------------------------------------- -->
            <a
              class="topbartoggler d-block d-md-none waves-effect waves-light"
              href="javascript:void(0)"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
              ><i data-feather="more-horizontal" class="feather-sm"></i
            ></a>
          </div>
          <!-- -------------------------------------------------------------- -->
          <!-- End Logo -->
          <!-- -------------------------------------------------------------- -->
          <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- -------------------------------------------------------------- -->
            <!-- toggle and nav items -->
            <!-- -------------------------------------------------------------- -->
            <ul class="navbar-nav me-auto">
              <!-- This is  -->
              <li class="nav-item">
                <a
                  class="
                    nav-link
                    sidebartoggler
                    d-none d-md-block
                    waves-effect waves-dark
                  "
                  href="javascript:void(0)"
                  ><i data-feather="menu" class="feather-sm"></i
                ></a>
              </li>
            </ul>
            <!-- -------------------------------------------------------------- -->
            <!-- Right side toggle and nav items -->
            <!-- -------------------------------------------------------------- -->
            <ul class="navbar-nav justify-content-end">
              <li class="nav-item dropdown">
                <a
                  class="
                    nav-link
                    dropdown-toggle
                    text-muted
                    waves-effect waves-dark
                  "
                  href="#"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="flag-icon flag-icon-us"></i
                ></a>
                <div
                  class="
                    dropdown-menu dropdown-menu-end dropdown-menu-animate-up
                  "
                >
                  <a class="dropdown-item" href="#"
                    ><i class="flag-icon flag-icon-in"></i> India</a
                  >
                  <a class="dropdown-item" href="#"
                    ><i class="flag-icon flag-icon-fr"></i> French</a
                  >
                  <a class="dropdown-item" href="#"
                    ><i class="flag-icon flag-icon-cn"></i> China</a
                  >
                  <a class="dropdown-item" href="#"
                    ><i class="flag-icon flag-icon-de"></i> Dutch</a
                  >
                </div>
              </li>
              <!-- -------------------------------------------------------------- -->
              <!-- Profile -->
              <!-- -------------------------------------------------------------- -->
              <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle waves-effect waves-dark"
                  href="#"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <img
                    src="<?php echo $home_url; ?>/dist/libs/images/1.jpg"
                    alt="user"
                    width="30"
                    class="profile-pic rounded-circle"
                  />
                </a>
                <div
                  class="
                    dropdown-menu dropdown-menu-end
                    user-dd
                    animated
                    flipInY
                  "
                >
                  <div
                    class="
                      d-flex
                      no-block
                      align-items-center
                      p-3
                      bg-primary
                      text-white
                      mb-2
                    "
                  >
                    <div class="">
                      <img
                        src="<?php echo $home_url; ?>/dist/libs/images/1.jpg"
                        alt="user"
                        class="rounded-circle"
                        width="60"
                      />
                    </div>
                    <div class="ms-2">
                      <h4 class="mb-0 text-white">Site Administrator</h4>
                    </div>
                  </div>
                  <a class="dropdown-item" href="<?php echo $backend_url; ?>/users/index"
                    ><i
                      data-feather="user"
                      class="feather-sm text-info me-1 ms-1"
                    ></i>
                    User Details</a
                  >
                  <a class="dropdown-item" href="<?php echo $backend_url; ?>/wallet/withdrawal-request"
                    ><i
                      data-feather="credit-card"
                      class="feather-sm text-primary me-1 ms-1"
                    ></i>
                    Withdrawal Request</a
                  >
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/account-password"
                    ><i
                      data-feather="settings"
                      class="feather-sm text-warning me-1 ms-1"
                    ></i>
                    Change Password</a
                  >
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo $backend_url; ?>/setting/index"
                    ><i
                      data-feather="settings"
                      class="feather-sm text-warning me-1 ms-1"
                    ></i>
                    Setting</a
                  >
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/logout"
                    ><i
                      data-feather="log-out"
                      class="feather-sm text-danger me-1 ms-1"
                    ></i>
                    Logout</a
                  >
                  <div class="dropdown-divider"></div>
                  <div class="pl-4 p-2">
                    <a
                      href="<?php echo $backend_url; ?>/user/dashboard"
                      class="btn d-block w-100 btn-primary rounded-pill"
                      >Dashboard</a
                    >
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- -------------------------------------------------------------- -->
      <!-- End Topbar header -->
      <!-- -------------------------------------------------------------- -->
      <!-- -------------------------------------------------------------- -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- -------------------------------------------------------------- -->
      <?php echo $this->element('admin_left_black');?>
      <!-- -------------------------------------------------------------- -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- -------------------------------------------------------------- -->
      <!-- -------------------------------------------------------------- -->
      <!-- Page wrapper  -->
      <!-- -------------------------------------------------------------- -->
      <div class="page-wrapper">
        <!-- -------------------------------------------------------------- -->
        <!-- Container fluid  -->
        <!-- -------------------------------------------------------------- -->
        <?= $this->fetch('content') ?>
        <!-- -------------------------------------------------------------- -->
        <!-- End Container fluid  -->
        <!-- -------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------- -->
        <!-- footer -->
        <!-- -------------------------------------------------------------- -->
        <footer class="footer text-center">
          All Rights Reserved by Daulat Pride Pvt.
        </footer>
        <!-- -------------------------------------------------------------- -->
        <!-- End footer -->
        <!-- -------------------------------------------------------------- -->
      </div>
      <!-- -------------------------------------------------------------- -->
      <!-- End Page wrapper  -->
      <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- End Wrapper -->
    <!-- -------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------- -->
    <!-- All Jquery -->
    <!-- -------------------------------------------------------------- -->
    
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/bootstrap.bundle.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/app.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/app.init.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/app-style-switcher.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/perfect-scrollbar.jquery.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/jquery.sparkline.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/waves.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/feather.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/sidebarmenu.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/custom.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/apexcharts.min.js') ?>
    <?= $this->Html->script($home_url.'/dist/libs/jquery/dist/dashboard2.js') ?>
    <?= $this->Html->script('frontend/jquery.validate.min.js') ?>
    <?= $this->Html->script('frontend/additional-methods.js') ?>
    <?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.bundle.js') ?>
    <?= $this->Html->script($home_url.'/dist/js/datagrid/datatables/datatables.export.js') ?>
    <?= $this->Html->script($home_url.'/js/frontend/jquery.fancybox.js') ?>
    <?= $this->Html->script('functions.js') ?>
    <?= $this->Html->script('backend/custom.js') ?>
    <?= $this->Html->script('backend/dataTables.js') ?>
    <?php echo $this->element('common-upload'); ?>
    <?php echo $this->element('ajax-upload'); ?>
    <?php echo $this->element('delete-attachment'); ?>
    <script type="text/javascript">
      function displayMessageOnSubmit(formId) {
        if($('#'+formId).valid()) {
          let packageAmount = $("#package_amount").val();
          if(confirm('Your package amount is '+packageAmount+'. Are you ok with this amount?')) {
            $("#"+formId).submit();
          }
        }
      }
    </script>
  </body>
</html>
