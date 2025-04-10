<?php
$currAction = $this->request->getAttribute('params')['action'];
?>
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="<?php echo $home_url; ?>/frontend/img/logo.jpeg" alt="JSKS Infratech" aria-roledescription="logo">
            <span class="page-logo-text mr-1">JSKS Infratech</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="<?php echo $home_url;?>/dist/img/demo/avatars/avatar-admin.png" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate-sm d-inline-block">
                        Welcome
                    </span>
                </a>
                <strong class="text-truncate d-inline-block text-truncate-sm"><?php echo $user->Details['first_name']; ?></strong>
            </div>
            <img src="<?php echo $home_url;?>/dist/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li class="<?php if($currAction == 'index'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account" title="Dashboard">
                 <i class="fal fa-info-circle"></i>
                 <span class="item-text">Dashboard</span>
              </a>
            </li>
            <li class="<?php if($currAction == 'epins' || $currAction == 'transferredEpins'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-building"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">E-pins</span>
                </a>
                <ul>
                    <li class="<?php if($currAction == 'epins'){?>active<?php }?>">
                      <a href="<?php echo $home_url ?>/my-account/epins" title="Assigned Epins" data-toggle="" class="no-submenu">
                        <span class="item-text">Epin List</span>
                      </a>
                    </li>
                    <li class="<?php if($currAction == 'transferredEpins'){?>active<?php }?>">
                      <a href="<?php echo $home_url; ?>/my-account/transferred-epins" title="Transferred Epins" data-toggle="" class="no-submenu">
                        <span class="item-text">Transferred Epin</span>
                      </a>
                    </li>
                </ul>
            </li>

            <li class="<?php if($currAction == 'addUser' || $currAction == 'addKyc' || $currAction == 'upgradeUser' || $currAction == 'upgradeHistory' || $currAction == 'registeredUsers'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-users"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Users</span>
                </a>
                <ul>
                    <li class="<?php if($currAction == 'addUser'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/manage-users/add-user" title="Add User" data-toggle="" class="no-submenu">
                      <span class="item-text">New Registration</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'addKyc'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/manage-users/add-kyc" title="Add KYC" data-toggle="" class="no-submenu">
                      <span class="item-text">Add KYC</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'registeredUsers'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/manage-users/registered-users" title="Registered Users" data-toggle="" class="no-submenu">
                      <span class="item-text">Users List</span>
                    </a>
                  </li>
                </ul>
            </li>

            <li class="<?php if($currAction == 'myPlots' || $currAction == 'myEmi' || $currAction == 'myPayments' || $currAction == 'myTeamPlots' || $currAction == 'plotAvaibility'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-building"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Plot</span>
                </a>
                <ul>
                  <li class="<?php if($currAction == 'myPayments'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/plot/my-payments" title="My Payments" data-toggle="" class="no-submenu">
                      <span class="item-text">My Payments</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'myPlots'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/plot/my-plots" title="My Plots" data-toggle="" class="no-submenu">
                      <span class="item-text">My Plots</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'myEmi'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/plot/my-emi" title="My EMI" data-toggle="" class="no-submenu">
                      <span class="item-text">My EMI</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'myTeamPlots'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/plot/my-team-plots" title="My Team Plots" data-toggle="" class="no-submenu">
                      <span class="item-text">My Team Plots</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'plotAvaibility'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/plot/plot-avaibility" title="Plot Avaibility" data-toggle="" class="no-submenu">
                      <span class="item-text">Plot Avaibility</span>
                    </a>
                  </li>
                </ul>
            </li>

            <li class="<?php if($currAction == 'MyDirectNetwork' || $currAction == 'myNetwork' || $currAction == 'directReferral' || $currAction == 'downlineReport'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-tree"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Team</span>
                </a>
                <ul>
                  <li class="<?php if($currAction == 'directNetwork'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/direct-network" title="Upgraded" data-toggle="" class="Total Transaction">
                       <span class="item-text">Direct Network</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'myNetwork'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/my-network" title="My Network">
                      <span class="item-text">Network</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'directReferral'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/direct-referral" title="Direct Referral">
                      <span class="item-text">Direct Referral</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'downlineReport'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/downline-report" title="Downline Report">
                      <span class="item-text">Downline Report</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'downlineReportPosition'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/downline-report-position" title="Downline Report">
                      <span class="item-text">Post Report</span>
                    </a>
                  </li>
                  
                  <li class="<?php if($currAction == 'currentTotalBusiness'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/team/current-total-business" title="Current Total Business">
                      <span class="item-text">Current Business</span>
                    </a>
                  </li>
                </ul>
            </li>
            <li class="<?php if($currAction == 'closingDetails' || $currAction == 'payoutRequest' || $currAction == 'requestPayout' || $currAction == 'rewards'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-money"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Payouts</span>
                </a>
                <ul>
                  <li class="<?php if($currAction == 'closingDetails'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/payouts/closing-details" title="Registered" data-toggle="" class="Closing Details">
                       <span class="item-text">Closing Details</span>
                    </a>
                  </li>
                  
                 
                  
                  <li class="<?php if($currAction == 'rewards'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/payouts/rewards" title="Registered" data-toggle="" class="Rewards">
                       <span class="item-text">Rewards</span>
                    </a>
                  </li>
                </ul>
            </li>
            <li class="<?php if($currAction == 'directRewards' || $currAction == 'pairRewards'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-trophy"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Rewards</span>
                </a>
                <ul>
                  <li class="<?php if($currAction == 'directRewards'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/reward/direct-rewards" title="Direct Rewards" data-toggle="">
                       <span class="item-text">Direct Rewards</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'pairRewards' || $currAction == 'requestPayout'){?>active<?php }?>">
                    <a href="<?php echo $home_url ?>/my-account/reward/pair-rewards" title="Pair Rewards" data-toggle="">
                       <span class="item-text">Pair Rewards</span>
                    </a>
                  </li>
                </ul>
            </li>
            <!-- <li class="<?php if($currAction == 'editProfile'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/edit-profile" title="Edit Account">
                 <i class="fal fa-edit"></i>
                 <span class="item-text">Edit Profile</span>
              </a>
            </li> -->
            <li class="<?php if($currAction == 'tickets' || $currAction == 'addTicket' || $currAction == 'viewTicket'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-ticket"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Support</span>
                </a>
                <ul>
                  <li  class="<?php if($currAction == 'tickets' || $currAction == 'viewTicket'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/support/tickets" title="Tickets">
                       <span class="item-text">Tickets</span>
                    </a>
                  </li>
                  <li class="<?php if($currAction == 'addTicket'){?>active<?php }?>">
                    <a href="<?php echo $home_url;?>/my-account/support/add-ticket" title="Add Ticket">
                      <span class="item-text">Add Ticket</span>
                    </a>
                  </li>
                </ul>
            </li>
            <!-- <li class="<?php if($currAction == 'accountPassword' || $currAction == 'transactionPassword'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-key"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Change Password</span>
                </a>
                <ul>
                  <li  class="<?php if($currAction == 'accountPassword'){?>active<?php }?>">
                    <a href="<?php echo $home_url; ?>/my-account/change-password/account-password" title="Account Password">
                       <span class="item-text">Account Password</span>
                    </a>
                  </li>
                </ul>
            </li> -->
            <li class="<?php if($currAction == 'buinessPlan'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/buiness-plan" title="Business Plan">
                 <i class="fal fa-qrcode"></i>
                 <span class="item-text">Business Plan</span>
              </a>
            </li>
            
            <li>
              <a href="<?php echo $home_url ?>/logout_user" title="Logout">
                 <i class="fal fa-power-off"></i>
                 <span class="item-text">Logout</span>
              </a>
            </li>
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
</aside>