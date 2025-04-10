<?php
$currController = strtolower($this->request->getAttribute('params')['controller']);
$currAction = strtolower($this->request->getAttribute('params')['action']);
?>
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="<?php echo $backend_url; ?>/user/dashboard" class="page-logo-link press-scale-down d-flex align-items-center position-relative">
            <img src="<?php echo $home_url; ?>/frontend/img/logo.jpeg" alt="JSKS Infratech" aria-roledescription="logo">
            <span class="page-logo-text mr-1">JSKS Infratech </span>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="info-card">
            <img src="<?php echo $home_url;?>/dist/img/demo/avatars/avatar-admin.png" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                      Welcome
                    </span>
                </a>
                <strong class="d-inline-block text-truncate text-truncate-sm"><?php echo $adminUser->Details['first_name']; ?></strong>
            </div>
            <img src="<?php echo $home_url;?>/dist/img/card-backgrounds/cover-2-lg.png" class="cover" alt="cover">
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li class="<?php if($currController == 'user' && $currAction == 'dashboard'){?>active<?php }?>">
              <a href="<?php echo $backend_url ?>/user/dashboard" title="Dashboard">
                 <i class="fal fa-info-circle"></i>
                 <span class="item-text">Dashboard</span>
              </a>
            </li>
            <?php 
            if($adminUser['Permissions']['is_permission']) {?>
              <li class="<?php if($currController == 'roles'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-info-circle"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Permissions</span>
                  </a>
                  <ul>
                      <?php 
                      if($adminUser['Permissions']['is_permission']) {?>
                         <li>
                            <a href="<?php echo $backend_url; ?>/roles" data-toggle="" class="no-submenu">
                              <span class="item-text">Role</span>
                            </a>
                          </li>
                      <?php 
                      }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_staff']) {?>
              <li class="<?php if($currController == 'staffs'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-info-circle"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Team/People</span>
                  </a>
                  <ul>
                      <?php 
                      if($adminUser['Permissions']['is_staff']) {?>
                         <li>
                            <a href="<?php echo $backend_url; ?>/staffs" data-toggle="" class="no-submenu">
                              <span class="item-text">Staff</span>
                            </a>
                          </li>
                      <?php 
                      }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_package']) {?>
              <li class="">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-info-circle"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Add Stuffs</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_package']) {?>
                     <li>
                        <a href="<?php echo $backend_url; ?>/packages/add" data-toggle="" class="no-submenu">
                          <span class="item-text">Add Package</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_properties'] || $adminUser['Permissions']['is_sites'] || $adminUser['Permissions']['is_blocks'] || $adminUser['Permissions']['is_plots'] || $adminUser['Permissions']['is_current_rate'] || $adminUser['Permissions']['is_assign_plot'] || $adminUser['Permissions']['is_assigned_plots'] || $adminUser['Permissions']['is_plot_payment'] || $adminUser['Permissions']['is_plot_payment'] || $adminUser['Permissions']['is_plot_payment_list'] || $adminUser['Permissions']['is_assigned_unit_list']) {?>
                <li class="<?php if($currAction == 'properties' || $currAction == 'addproperty' || $currAction == 'editproperty' || $currAction == 'sites' || $currAction == 'addsite' || $currAction == 'editsite' || $currAction == 'blocks' || $currAction == 'addblock' || $currAction == 'editblock' || $currAction == 'plots' || $currAction == 'addplot' || $currAction == 'editplot' || $currAction == 'assignplot' || $currAction == 'assignedplots' || $currAction == 'plotpayment' || $currAction == 'plotpaymentlist' || $currAction == 'assignedunitlist' || $currAction == 'addmultipleplots' || $currAction == 'currentrate' || $currAction == 'addcurrentrate'){?>active open<?php }?>">
                    <a href="#" title="Application Intel" data-filter-tags="application intel">
                        <i class="fal fa-building"></i>
                        <span class="nav-link-text" data-i18n="nav.application_intel">Property</span>
                    </a>
                    <ul>
                        <?php 
                        if($adminUser['Permissions']['is_properties']) {?>

                          <li class="<?php if($currAction == 'properties' || $currAction == 'addproperty' || $currAction == 'editproperty'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/properties" title="Properties" data-toggle="" class="no-submenu">
                              <span class="item-text">Properties</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_sites']) {?>
                          <li class="<?php if($currAction == 'sites' || $currAction == 'addsite' || $currAction == 'editsite'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/sites" title="Sites" data-toggle="" class="no-submenu">
                              <span class="item-text">Sites</span>
                            </a>
                          </li>
                         <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_blocks']) {?>
                          <li class="<?php if($currAction == 'blocks' || $currAction == 'addblock' || $currAction == 'editblock'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/blocks" title="Blocks" data-toggle="" class="no-submenu">
                              <span class="item-text">Blocks</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_plots']) {?>
                          <li class="<?php if($currAction == 'plots' || $currAction == 'addplot' || $currAction == 'editplot'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/plots" title="Plots" data-toggle="" class="no-submenu">
                              <span class="item-text">Plots</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_current_rate']) {?>
                          <li>
                            <a href="<?php echo $backend_url; ?>/user/current-rate" title="Add Package" data-toggle="" class="no-submenu">
                              <span class="item-text">Current Rate</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_assign_plot']) {?>
                          <li class="<?php if($currAction == 'assignplot'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/user/assign-plot" title="Assign Plot" data-toggle="" class="no-submenu">
                              <span class="item-text">Assign Plot</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_assigned_plots']) {?>
                          <li class="<?php if($currAction == 'assignedplots'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/user/assigned-plots" title="Assigned Plots" data-toggle="" class="no-submenu">
                              <span class="item-text">Assigned Plots</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_plot_payment']) {?>
                          <li class="<?php if($currAction == 'plotpayment'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/plot-payment" title="Plot Payment" data-toggle="" class="no-submenu">
                              <span class="item-text">Plot Payment</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_plot_payment_list']) {?>
                          <li class="<?php if($currAction == 'plotpaymentlist'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/plot-payment-list" title="Plot Payment List" data-toggle="" class="no-submenu">
                              <span class="item-text">Plot Payment List</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                        <?php 
                        if($adminUser['Permissions']['is_assigned_unit_list']) {?>
                          <li class="<?php if($currAction == 'assignedunitlist'){?>active<?php }?>">
                            <a href="<?php echo $backend_url; ?>/projects/assigned-unit-list" title="Assigned Unit List" data-toggle="" class="no-submenu">
                              <span class="item-text">Assigned Unit List</span>
                            </a>
                          </li>
                        <?php 
                        }?>
                    </ul>
                </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_generate_pins'] || $adminUser['Permissions']['is_epin_list'] || $adminUser['Permissions']['is_unused_epins'] || $adminUser['Permissions']['is_used_pins'] || $adminUser['Permissions']['is_transferred_pins']) {?>

              <li class="<?php if($currController == 'epins' || ($currController == 'generate' && $currAction == 'list' || $currAction == 'unused' || $currAction == 'used' || $currAction == 'transferredepins')){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-calculator"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">E-Pins</span>
                  </a>
                  <ul>
                      <?php 
                      if($adminUser['Permissions']['is_generate_pins']) {?>
                        <li class="<?php if($currAction == 'generate'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/epins/generate" title="Generate Epins" data-toggle="" class="no-submenu">
                            <span class="item-text">Generate Epins</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_epin_list']) {?>
                        <li class="<?php if($currAction == 'epinlist'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/epins/epin-list" title="Epin List" data-toggle="" class="no-submenu">
                            <span class="item-text">Epin List</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_unused_epins']) {?>
                        <li class="<?php if($currAction == 'unused'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/epins/unused" title="Unused Epins" data-toggle="" class="no-submenu">
                            <span class="item-text">Unused Epins</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_used_pins']) {?>
                        <li class="<?php if($currAction == 'used'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/epins/used" title="Used Pins" data-toggle="" class="no-submenu">
                            <span class="item-text">Used Epins</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_transferred_pins']) {?>
                        <li class="<?php if($currAction == 'transferredepins'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/epins/transferred-epins" title="Transferred Epins" data-toggle="" class="no-submenu">
                            <span class="item-text">Transferred Epins</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_new_registration'] || $adminUser['Permissions']['is_upgrade_user'] || $adminUser['Permissions']['is_upgrade_history'] || $adminUser['Permissions']['is_degrade_user'] || $adminUser['Permissions']['is_user_emi'] || $adminUser['Permissions']['is_user_list']) {?>

              <li class="<?php if($currController == 'users' || ($currController == 'user' && ($currAction == 'adduser' || $currAction == 'upgrade'  || $currAction == 'degrade' || $currAction == 'editaccount' || $currAction == 'useremi' || $currAction == 'kyc' || $currAction == 'useradded'))){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-users"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Users</span>
                  </a>
                  <ul>
                      <?php 
                      if($adminUser['Permissions']['is_new_registration']) {?>
                        <li class="<?php if($currAction == 'upgradeUser'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/user/add-user" title="Add User" data-toggle="" class="no-submenu">
                            <span class="item-text">New Registration</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_upgrade_user']) {?>
                        <li class="<?php if($currAction == 'upgrade'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/user/upgrade" title="Upgrade User" data-toggle="" class="no-submenu">
                            <span class="item-text">Upgrade User</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_upgrade_history']) {?>
                        <li class="<?php if($currAction == 'upgradehistory'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/users/upgrade-history" title="Upgrade History" data-toggle="" class="no-submenu">
                            <span class="item-text">Upgrade History</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_degrade_user']) {?>
                        <li class="<?php if($currAction == 'degrade'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/user/degrade" title="Degrade User" data-toggle="" class="no-submenu">
                            <span class="item-text">Degrade User</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_user_emi']) {?>
                        <li class="<?php if($currAction == 'useremi'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/user/user-emi" title="User EMI" data-toggle="" class="no-submenu">
                            <span class="item-text">User EMI</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_user_list']) {?>
                        <li class="<?php if($currAction == 'index'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/users" title="Registered Users" data-toggle="" class="no-submenu">
                            <span class="item-text">Users List</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_direct_reward'] || $adminUser['Permissions']['is_pair_reward']) {?>
              <li class="<?php if($currAction == 'directreward' || $currAction == 'pairreward'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-trophy"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Reward</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_direct_reward']) {?>
                      <li class="<?php if($currAction == 'directreward'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reward/direct-reward" title="Upgraded" data-toggle="" class="Direct Reward">
                           <span class="item-text">Direct Reward</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                   <?php 
                   if($adminUser['Permissions']['is_direct_network']) {?>
                      <li class="<?php if($currAction == 'pairreward'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reward/pair-reward" title="Pair Reward">
                          <span class="item-text">Pair Reward</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_run_cron'] || $adminUser['Permissions']['is_post_incomes'] || $adminUser['Permissions']['is_saved_post_incomes'] || $adminUser['Permissions']['is_payment_closing'] || $adminUser['Permissions']['is_id_wise_closing'] || $adminUser['Permissions']['is_closing_details']) {?>
              <li class="<?php if($currAction == 'siglecalculation' || $currAction == 'bulkcalculation' || $currAction == 'closing' || $currAction == 'closingdetails' || $currAction == 'payoutrequest' || $currAction == 'calculatepairrate' || $currAction == 'pairratelist' || $currAction == 'calculatematchingincome' || $currAction == 'postincomes' || $currAction == 'savedpostincomes'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-edit"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Payments</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_run_cron']) {?>
                      <li>
                        <a href="<?php echo $home_url; ?>/cron/rewards" title="Run Cron" target="_blank">
                          <span class="item-text">Run Cron</span>
                        </a>
                      </li>
                    <?php
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_post_incomes']) {?>
                      <li  class="<?php if($currAction == 'postincomes'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/payments/post-incomes" title="Post Incomes">
                          <span class="item-text">Post Incomes</span>
                        </a>
                      </li>
                    <?php
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_saved_post_incomes']) {?>
                      <li  class="<?php if($currAction == 'savedpostincomes'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/payments/saved-post-incomes" title="Saved Post Incomes">
                          <span class="item-text">Saved Post Incomes</span>
                        </a>
                      </li>
                    <?php
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_payment_closing']) {?>
                      <li  class="<?php if($currAction == 'closing'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/payments/closing" title="Payments Closing">
                          <span class="item-text">Payments Closing</span>
                        </a>
                      </li>
                    <?php
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_id_wise_closing']) {?>
                      <li class="<?php if($currAction == 'closingDetailsIdwise'){?>active<?php }?>">
                        <a href="<?php echo $backend_url ?>/payments/closing-details-idwise" title="Registered" data-toggle="" class="Closing Details">
                           <span class="item-text">Id Wise Closing</span>
                        </a>
                      </li>
                    <?php
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_closing_details']) {?>
                      <li  class="<?php if($currAction == 'closingdetails'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/payments/closing-details" title="Closing Details">
                          <span class="item-text">Closing Details</span>
                        </a>
                      </li>
                    <?php
                    }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_pending_plot_payment'] || $adminUser['Permissions']['is_incoming_income'] || $adminUser['Permissions']['is_outgoing_income'] || $adminUser['Permissions']['is_total_payout_report']) {?>
              <li class="<?php if($currController == 'reports'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-ticket"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Reports</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_pending_plot_payment']) {?>
                      <li  class="<?php if($currAction == 'pendingplotpayments'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reports/pending-plot-payments" title="Pending Plot Payments">
                           <span class="item-text">Pending Plot Payments</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_incoming_income']) {?>
                      <li  class="<?php if($currAction == 'incomingincome'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reports/incoming-income" title="Incoming Income">
                           <span class="item-text">Incoming Income</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_outgoing_income']) {?>
                      <li  class="<?php if($currAction == 'outgoingincome'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reports/outgoing-income" title="Outgoing Income">
                           <span class="item-text">Outgoing Income</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                    <?php 
                    if($adminUser['Permissions']['is_total_payout_report']) {?>
                      <li  class="<?php if($currAction == 'totalpayoutreport'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/reports/total-payout-report" title="Total Payout Report">
                           <span class="item-text">Total Payout Report</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                  </ul>
              </li>
            <?php 
            }?>

            <?php 
            if($adminUser['Permissions']['is_direct_network'] || $adminUser['Permissions']['is_network'] || $adminUser['Permissions']['is_direct_referral'] || $adminUser['Permissions']['is_downline_report'] || $adminUser['Permissions']['is_post_report'] || $adminUser['Permissions']['is_current_business']) {?>
                <li class="<?php if($currAction == 'directnetwork' || $currAction == 'network' || $currAction == 'directreferral' || $currAction == 'downlinereport' || $currAction == 'downlinereportposition' || $currAction == 'currenttotalbusiness'){?>active open<?php }?>">
                    <a href="#" title="Application Intel" data-filter-tags="application intel">
                        <i class="fal fa-tree"></i>
                        <span class="nav-link-text" data-i18n="nav.application_intel">Team</span>
                    </a>
                    <ul>
                      <?php 
                      if($adminUser['Permissions']['is_direct_network']) {?>
                        <li class="<?php if($currAction == 'directnetwork'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/direct-network" title="Upgraded" data-toggle="" class="Total Transaction">
                             <span class="item-text">Direct Network</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_network']) {?>
                        <li class="<?php if($currAction == 'network'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/network" title="Network">
                            <span class="item-text">Network</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_direct_referral']) {?>
                        <li class="<?php if($currAction == 'directreferral'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/direct-referral" title="Direct Referral">
                            <span class="item-text">Direct Referral</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_downline_report']) {?>
                        <li class="<?php if($currAction == 'downlinereport'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/downline-report" title="Downline Report">
                            <span class="item-text">Downline Report</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_post_report']) {?>
                        <li class="<?php if($currAction == 'downlinereport'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/downline-report-position" title="Downline Report">
                            <span class="item-text">Post Report</span>
                          </a>
                        </li> 
                      <?php 
                      }?>
                      <?php 
                      if($adminUser['Permissions']['is_current_business']) {?>
                        <li class="<?php if($currAction == 'currentTotalBusiness'){?>active<?php }?>">
                          <a href="<?php echo $backend_url; ?>/team/current-total-business" title="Current Total Business">
                            <span class="item-text">Current Business</span>
                          </a>
                        </li>
                      <?php 
                      }?>
                    </ul>
                </li>
            <?php 
            }?>
            <?php 
            if($adminUser['Permissions']['is_tickets']) {?>
              <li class="<?php if($currAction == 'tickets' || $currAction == 'viewticket'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-ticket"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Support</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_tickets']) {?>
                      <li  class="<?php if($currAction == 'tickets' || $currAction == 'viewticket'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/support/tickets" title="Tickets">
                           <span class="item-text">Tickets</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                  </ul>
              </li>
            <?php 
            }?>
            <?php 
            if($adminUser['Permissions']['is_tax_and_comission']) {?>
              <li class="<?php if($currController == 'setting'){?>active open<?php }?>">
                  <a href="#" title="Application Intel" data-filter-tags="application intel">
                      <i class="fal fa-cog"></i>
                      <span class="nav-link-text" data-i18n="nav.application_intel">Setting</span>
                  </a>
                  <ul>
                    <?php 
                    if($adminUser['Permissions']['is_tax_and_comission']) {?>
                      <li  class="<?php if($currAction == 'addtaxandcommission' || $currAction =='taxandcommission'){?>active<?php }?>">
                        <a href="<?php echo $backend_url; ?>/setting/tax-and-commission" title="Account Password">
                           <span class="item-text">Tax & Commission</span>
                        </a>
                      </li>
                    <?php 
                    }?>
                  </ul>
              </li>
            <?php 
            }?>
            <li class="<?php if($currAction == 'accountpassword' || $currAction == 'transactionpassword'){?>active open<?php }?>">
                <a href="#" title="Application Intel" data-filter-tags="application intel">
                    <i class="fal fa-key"></i>
                    <span class="nav-link-text" data-i18n="nav.application_intel">Change Password</span>
                </a>
                <ul>
                  <?php 
                  if($adminUser['Permissions']['is_account_password']) {?>
                    <li  class="<?php if($currAction == 'accountpassword'){?>active<?php }?>">
                      <a href="<?php echo $backend_url; ?>/user/account-password" title="Account Password">
                         <span class="item-text">Account Password</span>
                      </a>
                    </li>
                  <?php 
                  }?>
                  <li>
                    <a href="<?php echo $backend_url; ?>/user/edit-account" title="Edit Account" data-toggle="" class="no-submenu">
                      <span class="item-text">User Password</span>
                    </a>
                  </li>
                </ul>
            </li>

            <li>
              <a href="<?php echo $backend_url ?>/user/logout" title="Logout">
                 <i class="fal fa-power-off"></i>
                 <span class="item-text">Logout</span>
              </a>
            </li>
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
</aside>