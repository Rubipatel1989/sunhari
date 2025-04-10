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
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark" href="<?php echo $backend_url; ?>/user/dashboard">
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
                  <i data-feather="dollar-sign" class="feather-icon"></i>
                  <span class="hide-menu">Payment
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payments/add" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i><span class="hide-menu"> Add Payment Account</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url ?>/payments/index" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i><span class="hide-menu"> Payment Account List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url ?>/payments/pay-user-emi" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i><span class="hide-menu"> Pay User EMI</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url ?>/payments/pending-payment " class="sidebar-link">
                      <i class="mdi mdi-adjust"></i><span class="hide-menu"> Pending Payment</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url ?>/payments/payment-history " class="sidebar-link">
                      <i class="mdi mdi-adjust"></i><span class="hide-menu"> Payment History</span>
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
                  <i data-feather="users" class="feather-icon"></i>
                  <span class="hide-menu">Manage Agents
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/new-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> New Joining</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/add-multiple-agents" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Add Multiple Agents</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/index" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> All Agent Details</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/index/block-ids" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Blocked Ids</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/index/today-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Todays Joining</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/index/total-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Total Joining</span></a>
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
                    <a href="<?php echo $backend_url; ?>/lesars/add-lesar" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Add Lesar</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/lesars/lesar-list" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Lesar List</span></a>
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
                  <span class="hide-menu">Royalty
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/activate-royalty" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Activate Royalty</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/agent/royalty-list" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Royalty List</span></a>
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
                    <a href="<?php echo $backend_url; ?>/customer/new-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> New Joining</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/add-multiple-customers" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Add Multiple Customers</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> All Customer Details</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/block-ids" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Blocked Ids</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/today-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Todays Joining</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/total-joining" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Total Joining</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/today-activation" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Today Activation</span></a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/total-activation" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Total Activation</span></a>
                  </li> 
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/customer/index/inactive-ids" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> Inactive Ids</span></a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <i data-feather="user" class="feather-icon"></i>
                  <span class="hide-menu">My Account
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/user/account-password" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Change Password</span>
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
                  <i data-feather="battery-charging" class="feather-icon"></i>
                  <span class="hide-menu">Packages
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/plan-ab" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan AB-18</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/upload-plan-ab" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu">Upload Plan AB-18</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/remove-plan-ab" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu">Remove Plan AB-18</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/plan-ab-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan AB-18 List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/plan-mb" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan MB</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/upload-plan-mb" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Upload Plan MB</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/remove-plan-mb" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Remove Plan MB</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/plan-mb-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Plan MB List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/promotion" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/packages/promotion-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion List</span>
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
                    <a href="<?php echo $backend_url; ?>/bills/add" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Add Bill</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/bills/pending-bills" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Pending Bills</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/bills/bill-history" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Bill History</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark" href="<?php echo $backend_url; ?>/member/user-earning-details">
                  <i data-feather="sunrise" class="feather-icon"></i>
                  <span class="hide-menu">User Earning Details
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark" href="<?php echo $backend_url; ?>/agent/daily-incentive-details">
                  <i data-feather="sunrise" class="feather-icon"></i>
                  <span class="hide-menu">Daily Incentive Details
                </a>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                >
                  <i data-feather="users" class="feather-icon"></i>
                  <span class="hide-menu"
                    >Team
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/team/direct-referral" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Direct Referral</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/team/downline-report" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Downline Report</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/team/parent-report" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Parent Report</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/team/customer-report" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Customer Report</span>
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
                  <i data-feather="users" class="feather-icon"></i>
                  <span class="hide-menu"
                    >Payout
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $home_url; ?>/cron/index" class="sidebar-link" target="_blank">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Run Cron</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/closing" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Closing</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/closing-list" class="sidebar-link">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Closing List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/promotion-direct-closing" class="sidebar-link" title="Promotion Direct Closing">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion Direct Closing</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/promotion-direct-closing-list" class="sidebar-link" title="Promotion Direct Closing List">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion Direct Closing List</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/promotion-level-closing" class="sidebar-link" title="Promotion Level Closing">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion Level Closing</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/payout/promotion-level-closing-list" class="sidebar-link" title="Promotion Level Closing List">
                      <i class="mdi mdi-adjust"></i>
                      <span class="hide-menu"> Promotion Level Closing List</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"><i data-feather="cpu" class="feather-icon"></i><span class="hide-menu">Support</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="<?php echo $backend_url; ?>/support/tickets" class="sidebar-link"><i class="mdi mdi-box-shadow"></i><span class="hide-menu"> Ticket History</span></a>
                  </li>
                </ul>
              </li>
              
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="#"
                  aria-expanded="false"
                  ><i data-feather="message-square" class="feather-icon"></i
                  ><span class="hide-menu">Message</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="#"
                  aria-expanded="false"
                  ><i data-feather="film" class="feather-icon"></i
                  ><span class="hide-menu">User Image</span></a
                >
              </li>
              <li class="sidebar-item">
                <a
                  class="sidebar-link waves-effect waves-dark sidebar-link"
                  href="<?php echo $backend_url; ?>/user/logout"
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