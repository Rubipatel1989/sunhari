<?php
$currController = strtolower($this->request->getAttribute('params')['controller']);
$currAction = strtolower($this->request->getAttribute('params')['action']);
?>
<aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav">
            <ul id="sidebarnav">
              <li class="sidebar-item user-profile">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark disabled-opacity"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <?php
                  $profileImage = $home_url.'/dist/libs/images/profile.png';
                  $altText = '';
                  if($user->Attachments['file']) {
                      $profileImage = $home_url.'/attachments/'.$user->Attachments['file'];
                      $altText = $user->Attachments['caption'];
                  }
                  ?>
                  <img src="<?php echo $profileImage; ?>" alt="<?php echo $altText; ?>" />
                  <span class="hide-menu"><?php echo $user['name']; ?> </span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url;?>/my-account/profile" class="sidebar-link p-0">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu">Profile</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url;?>/my-account/change-password/account-password" class="sidebar-link p-0">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu">Change Password</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark" href="<?php echo $home_url; ?>/my-account">
                  <i data-feather="home" class="feather-icon"></i>
                  <span class="hide-menu">Dashboard
                </a>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <i data-feather="battery-charging" class="feather-icon"></i>
                  <span class="hide-menu"
                    >User Payments
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/user-payments/make-payment" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Make Payment</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/user-payments/pay-user-emi" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Pay User EMI</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/user-payments/payment-history" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Payment History</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/user-payments/wallet-history" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Wallet History</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/user-payments/emi-history" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> EMI History</span>
                    </a>
                  </li>
                </ul>
              </li>
              <?php
              if ($user->role_id == 2) {?>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                  >
                    <i data-feather="users" class="feather-icon"></i>
                    <span class="hide-menu">Manage Agents
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url; ?>/my-account/agent/new-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> New Joining</span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url; ?>/my-account/agent/index" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> All Agent Details</span></a>
                    </li>
                  </ul>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                  >
                    <i data-feather="users" class="feather-icon"></i>
                    <span class="hide-menu">Manage Lesar
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url; ?>/my-account/lesars/lesar-list" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Lesar List</span></a>
                    </li>
                  </ul>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                  >
                    <i data-feather="users" class="feather-icon"></i>
                    <span class="hide-menu">Manage Customers
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url; ?>/my-account/customer/new-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> New Joining</span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url; ?>/my-account/customer/index" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> All Customer Details</span></a>
                    </li>
                  </ul>
                </li>
              <?php 
              }?>
              <?php
              if ($user->role_id == 2) {?>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link waves-effect waves-dark sidebar-link"
                    href="<?php echo $home_url ?>/my-account/agent/royalty-report"
                    aria-expanded="false"
                    ><i data-feather="log-out" class="feather-icon"></i
                    ><span class="hide-menu">Royalty Report</span></a
                  >
                </li>
              <?php
              }?>
              <?php
              if ($user->role_id == 2) {?>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                  >
                    <i data-feather="cloud-drizzle" class="feather-icon"></i>
                    <span class="hide-menu"
                      >My Team
                  </a>
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/team/direct-referral" class="sidebar-link">
                        <i class="mdi mdi-adjust"></i>
                        <span class="hide-menu"> Direct Team</span>
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/team/downline-report" class="sidebar-link">
                        <i class="mdi mdi-adjust"></i>
                        <span class="hide-menu"> Downline Team</span>
                      </a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/team/customers" class="sidebar-link">
                        <i class="mdi mdi-adjust"></i>
                        <span class="hide-menu">Customers</span>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php 
              }?>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <i data-feather="battery-charging" class="feather-icon"></i>
                  <span class="hide-menu">Packages
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/plan-ab" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan AB-18</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/plan-ab-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan AB-18 List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/plan-mb" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan MB</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/plan-mb-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan MB List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/promotion" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/promotion-list" class="sidebar-link">
                      <i class="mdi mdi-home_url"></i>
                      <span class="hide-menu"> Promotion List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/packages/customer-coupon-list" class="sidebar-link">
                      <i class="mdi mdi-home_url"></i>
                      <span class="hide-menu"> Customer Coupon List</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <i data-feather="file-text" class="feather-icon"></i>
                  <span class="hide-menu">Bills
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/bills/add" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Add Bill</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/bills/bill-history" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Bill History</span>
                    </a>
                  </li>
                </ul>
              </li>
              <?php
              if ($user->role_id == 2) {?>
                <li class="sidebar-item">
                  <a class="sidebar-link waves-effect waves-dark" href="<?php echo $home_url; ?>/my-account/agent/daily-incentive-details">
                    <i data-feather="sunrise" class="feather-icon"></i>
                    <span class="hide-menu">Daily Incentive Details
                  </a>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                    ><i data-feather="check-circle" class="feather-icon"></i
                    ><span class="hide-menu">Earning </span></a
                  >
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/incentive-income" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Incentive Income </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/sponsor-reward" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Direct Income </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/level-reward" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Level Income </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/repurchase-income" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Repurchase Incomde </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/repurchase-mb-income" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Repurchase MB Incomde </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/earning/royalty-income" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Royalty Income </span></a>
                    </li>
                  </ul>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                    ><i data-feather="check-circle" class="feather-icon"></i
                    ><span class="hide-menu">Payment Closing </span></a
                  >
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/payment-closing/closing-list" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Closing List </span></a>
                    </li>
                  </ul>
                </li>
                <li class="sidebar-item">
                  <a
                    class="sidebar-link has-arrow waves-effect waves-dark"
                    href="javascript:void(0)"
                    aria-expanded="false"
                    ><i data-feather="check-circle" class="feather-icon"></i
                    ><span class="hide-menu">Coupon Closing </span></a
                  >
                  <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/coupon-closing/direct-closing-list" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Direct Closing List </span></a>
                    </li>
                    <li class="sidebar-item">
                      <a href="<?php echo $home_url ?>/my-account/coupon-closing/level-closing-list" class="sidebar-link"><i class="mdi mdi-email"></i><span class="hide-menu"> Level Closing List </span></a>
                    </li>
                  </ul>
                </li>
              <?php 
              }?>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"><i data-feather="cpu" class="feather-icon"></i><span class="hide-menu">Support</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url;?>/my-account/support/add-ticket" class="sidebar-link"><i class="mdi mdi-box-shadow"></i><span class="hide-menu"> Create Ticket</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/my-account/support/tickets" class="sidebar-link"><i class="mdi mdi-box-shadow"></i><span class="hide-menu"> Ticket Record</span></a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="<?php echo $home_url ?>/logout_user"
                  aria-expanded="false"
                  ><i data-feather="log-out" class="feather-icon"></i
                  ><span class="hide-menu">Log Out</span></a
                >
              </li>
            </ul>
          </nav>
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>