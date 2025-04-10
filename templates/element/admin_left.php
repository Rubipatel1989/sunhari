<?php

$currController = strtolower($this->request->getAttribute('params')['controller']);
$currAction = strtolower($this->request->getAttribute('params')['action']);
?>
<ul class="nav">
   <!-- START Menu-->
   <li class="nav-heading">Main navigation</li>
   <li class="<?php if($currController == 'user' && $currAction == 'dashboard'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/user/dashboard" title="Dashboard">
         <em class="fa fa-dot-circle-o"></em>
         <span class="item-text">Dashboard</span>
      </a>
   </li>
   <?php 
   if($adminUser['Permissions']['is_permission']) {
   ?>
     <li class="">
        <a href="#" title="Role" data-toggle="collapse-next" class="has-submenu">
          <em class="fa fa-plus-square"></em>
          <span class="item-text">Permissions</span>
        </a>
        <?php 
        $cls = '';
        if($currController == 'roles'){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls;?>">
          <?php 
          if($adminUser['Permissions']['is_permission']) {?>
             <li>
                <a href="<?php echo $backend_url; ?>/roles" title="Add Package" data-toggle="" class="no-submenu">
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
   if($adminUser['Permissions']['is_staff']) {
   ?>
     <li class="">
        <a href="#" title="Other Stuffs" data-toggle="collapse-next" class="has-submenu">
          <em class="fa fa-plus-square"></em>
          <span class="item-text">Team/People</span>
        </a>
        <?php 
        $cls = '';
        if($currController == 'staffs'){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls; ?>">
          <?php 
          if($adminUser['Permissions']['is_staff']) {?>
             <li>
                <a href="<?php echo $backend_url; ?>/staffs" title="Add Package" data-toggle="" class="no-submenu">
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
        <a href="#" title="Other Stuffs" data-toggle="collapse-next" class="has-submenu">
          <em class="fa fa-plus-square"></em>
          <span class="item-text">Add Stuffs</span>
        </a>
        <ul class="nav collapse ">
          <?php 
          if($adminUser['Permissions']['is_package']) {?>
           <li>
              <a href="<?php echo $backend_url; ?>/packages/add" title="Add Package" data-toggle="" class="no-submenu">
                <span class="item-text">Add Package</span>
              </a>
            </li>
          <?php 
          }?>
          <li>
            <a href="<?php echo $backend_url; ?>/binaries/add" title="Add Binary" data-toggle="" class="no-submenu">
              <span class="item-text">Add Binary</span>
            </a>
          </li>
        </ul>
     </li>
    <?php 
    }?>
    <?php 
    if($adminUser['Permissions']['is_package']) {?>
      <li class="<?php if($currController == 'packages'){?>active<?php }?>">
        <a href="<?php echo $backend_url ?>/packages" title="Packages">
           <em class="fa fa-cubes"></em>
           <span class="item-text">Packages</span>
        </a>
      </li>
    <?php 
    }?>
  <?php 
  if($adminUser['Permissions']['is_properties'] || $adminUser['Permissions']['is_sites'] || $adminUser['Permissions']['is_blocks'] || $adminUser['Permissions']['is_plots'] || $adminUser['Permissions']['is_current_rate'] || $adminUser['Permissions']['is_assign_plot'] || $adminUser['Permissions']['is_assigned_plots'] || $adminUser['Permissions']['is_plot_payment'] || $adminUser['Permissions']['is_plot_payment'] || $adminUser['Permissions']['is_plot_payment_list'] || $adminUser['Permissions']['is_assigned_unit_list']) {?>

   <li class="<?php if($currAction == 'properties' || $currAction == 'addproperty' || $currAction == 'editproperty' || $currAction == 'sites' || $currAction == 'addsite' || $currAction == 'editsite' || $currAction == 'blocks' || $currAction == 'addblock' || $currAction == 'editblock' || $currAction == 'plots' || $currAction == 'addplot' || $currAction == 'editplot' || $currAction == 'assignplot' || $currAction == 'assignedplots' || $currAction == 'plotpayment' || $currAction == 'plotpaymentlist' || $currAction == 'assignedunitlist'){?>active<?php }?>">
      <a href="#" title="Users" data-toggle="collapse-next" class="has-submenu">
         <em class="fa fa-building"></em>
         <span class="item-text">Property</span>
      </a>
      <!-- START SubMenu item-->
      <?php 
      $cls = '';
      if($currAction == 'properties' || $currAction == 'addproperty' || $currAction == 'editproperty' || $currAction == 'sites' || $currAction == 'addsite' || $currAction == 'editsite' || $currAction == 'blocks' || $currAction == 'addblock' || $currAction == 'editblock' || $currAction == 'plots' || $currAction == 'addplot' || $currAction == 'editplot' || $currAction == 'assignplot' || $currAction == 'assignedplots' || $currAction == 'plotpayment' || $currAction == 'plotpaymentlist' || $currAction == 'assignedunitlist'){
        $cls = 'in';
      }?>
      <ul class="nav collapse <?php echo $cls;?>">
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
      <!-- END SubMenu item-->
     </li>
  <?php
  }?>
  <?php 
  if($adminUser['Permissions']['is_generate_pins'] || $adminUser['Permissions']['is_epin_list'] || $adminUser['Permissions']['is_unused_epins'] || $adminUser['Permissions']['is_used_pins'] || $adminUser['Permissions']['is_transferred_pins']) {?>
     <li class="<?php if($currController == 'epins' || ($currController == 'generate' && $currAction == 'list' || $currAction == 'unused' || $currAction == 'used' || $currAction == 'transferredepins')){?>active<?php }?>">
        <a href="#" title="Users" data-toggle="collapse-next" class="has-submenu">
           <em class="fa fa-calculator"></em>
           <span class="item-text">E-Pins</span>
        </a>
        <!-- START SubMenu item-->
        <?php 
        $cls = '';
        if($currController == 'epins' || ($currController == 'generate' && $currAction == 'epinlist' || $currAction == 'unused' || $currAction == 'used' || $currAction == 'transferredepins')){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls;?>">
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
        <!-- END SubMenu item-->
     </li>
  <?php
  }?>
  <?php 
  if($adminUser['Permissions']['is_new_registration'] || $adminUser['Permissions']['is_upgrade_user'] || $adminUser['Permissions']['is_upgrade_history'] || $adminUser['Permissions']['is_degrade_user'] || $adminUser['Permissions']['is_user_emi'] || $adminUser['Permissions']['is_user_list']) {?>
     <li class="<?php if($currController == 'users' || ($currController == 'user' && ($currAction == 'adduser' || $currAction == 'upgrade'  || $currAction == 'degrade' || $currAction == 'editaccount' || $currAction == 'useremi'))){?>active<?php }?>">
        <a href="#" title="Users" data-toggle="collapse-next" class="has-submenu">
           <em class="fa fa-users"></em>
           <span class="item-text">Users</span>
        </a>
        <!-- START SubMenu item-->
        <?php 
        $cls = '';
        if($currController == 'users' || ($currController == 'user' && ($currAction == 'adduser' || $currAction == 'upgrade'  || $currAction == 'degrade' || $currAction == 'editaccount' || $currAction == 'useremi'))){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls;?>">
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
          <!--<li class="<?php if($currAction == 'editaccount'){?>active<?php }?>">
            <a href="<?php echo $backend_url; ?>/user/user-dashboard" title="User Dashboard" data-toggle="" class="no-submenu">
              <span class="item-text">User Dashboard</span>
            </a>
          </li>
          <li class="<?php if($currAction == 'achievedrewards'){?>active<?php }?>">
            <a href="<?php echo $backend_url; ?>/users/achieved-rewards" title="Achieved Rewards" data-toggle="" class="no-submenu">
              <span class="item-text">Achieved Rewards</span>
            </a>
          </li>-->
        </ul>
        <!-- END SubMenu item-->
     </li>
  <?php
  }?>
  <li class="<?php if($currController == 'products'){?>active<?php }?>">
    <a href="<?php echo $backend_url; ?>/products" title="Products">
       <em class="fa fa-product-hunt"></em>
       <span class="item-text">Products</span>
    </a>
  </li>
  <li class="<?php if($currController == 'links'){?>active<?php }?> hidden">
      <a href="<?php echo $backend_url; ?>/links" title="Links">
         <em class="fa fa-link"></em>
         <span class="item-text">Links</span>
      </a>
   </li>
   
   <li class="<?php if($currController == 'orders'){?>active<?php }?>">
      <a href="<?php echo $backend_url; ?>/orders" title="Orders">
         <em class="fa fa-shopping-basket"></em>
         <span class="item-text">Orders</span>
      </a>
    </li> 
   <!-- <li class="<?php if($currController == 'bonanza'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/bonanza" title="Bonanza">
         <em class="fa fa-cny"></em>
         <span class="item-text">Bonanza</span>
      </a>
   </li> -->
   <!-- <li class="<?php if($currController == 'reward'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/reward" title="Reward">
         <em class="fa fa-trophy"></em>
         <span class="item-text">Reward</span>
      </a>
   </li> -->
  <?php 
  if($adminUser['Permissions']['is_direct_reward'] || $adminUser['Permissions']['is_pair_reward']) {?>
     <li class="<?php if($currAction == 'directreward' || $currAction == 'pairreward'){?>active<?php }?>">
          <a href="#" title="Team" data-toggle="collapse-next">
             <em class="fa fa-users"></em>
             <span class="item-text">Reward</span>
          </a>
          <!-- START SubMenu item-->

          <?php 
          $cls = '';
          if($currAction == 'directreward' || $currAction == 'pairreward'){
            $cls = 'in';
          }?>
          <ul class="nav collapse <?php echo $cls; ?>">
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
   <!-- <li class="<?php if($currController == 'bitcoins'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/bitcoins" title="Bitcoins">
        <em class="fa fa-bitcoin"></em>
        <span class="item-text">BTC Address</span>
      </a>
   </li> -->
   <li class="<?php if($currController == 'binaries'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/binaries" title="Packages">
        <em class="fa fa-tree"></em>
        <span class="item-text">Binaries</span>
      </a>
   </li>
   <!--<li class="<?php if($currController == 'roi'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/roi" title="ROI(s)">
        <em class="fa fa-anchor"></em>
        <span class="item-text">ROI</span>
      </a>
   </li>-->
   <?php 
   if($adminUser['Permissions']['is_direct_network'] || $adminUser['Permissions']['is_network'] || $adminUser['Permissions']['is_direct_referral'] || $adminUser['Permissions']['is_downline_report'] || $adminUser['Permissions']['is_post_report'] || $adminUser['Permissions']['is_current_business']) {?>
     <li class="<?php if($currAction == 'directnetwork' || $currAction == 'network' || $currAction == 'directreferral' || $currAction == 'downlinereport'){?>active<?php }?>">
          <a href="#" title="Team" data-toggle="collapse-next">
             <em class="fa fa-users"></em>
             <span class="item-text">Team</span>
          </a>
          <!-- START SubMenu item-->

          <?php 
          $cls = '';
          if($currAction == 'directnetwork' || $currAction == 'network' || $currAction == 'directreferral' || $currAction == 'downlinereport'){
            $cls = 'in';
          }?>
          <ul class="nav collapse <?php echo $cls; ?>">
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
   <li class="<?php if($currAction == 'fundtransfer' || $currAction == 'transferfund' || $currAction == 'edit'  || $currAction == 'fundrequest'){?>active<?php }?>">
     <a href="#" title="Elements" data-toggle="collapse-next">
        <em class="fa fa-briefcase"></em>
        <span class="item-text">Wallet</span>
     </a>
     
     <?php 
     $active_cls = '';
     $collaps_in_cls = '';
     if($currAction == 'fundtransfer' || $currAction == 'transferfund'  || $currAction == 'edit' || $currAction == 'fundrequest'){
      $collaps_in_cls = 'in';
     }
     ?>
     <ul class="nav collapse <?php echo $collaps_in_cls; ?>">
         <li class="<?php if($currAction == 'fundtransfer' || $currAction == 'transferfund' || $currAction == 'edit'){?>active<?php }?>">
           <a href="<?php echo $backend_url ?>/wallet/fund_transfer" title="Fund Transfer">
              <span class="item-text">Fund Transfer</span>
           </a>
         </li>
         <li>
           <a href="<?php echo $backend_url ?>/wallet/fund-request" title="Fund Request">
              <span class="item-text">Fund Request</span>
           </a>
         </li>
     </ul>
   </li>
   <?php 
   if($adminUser['Permissions']['is_run_cron'] || $adminUser['Permissions']['is_post_incomes'] || $adminUser['Permissions']['is_saved_post_incomes'] || $adminUser['Permissions']['is_payment_closing'] || $adminUser['Permissions']['is_id_wise_closing'] || $adminUser['Permissions']['is_closing_details']) {?>
      <li class="<?php if($currAction == 'siglecalculation' || $currAction == 'bulkcalculation' || $currAction == 'closing' || $currAction == 'closingdetails' || $currAction == 'payoutrequest' || $currAction == 'calculatepairrate' || $currAction == 'pairratelist' || $currAction == 'calculatematchingincome' || $currAction == 'postincomes' || $currAction == 'savedpostincomes' || $currAction == 'calculateroi' || $currAction == 'calculatelegincome'){?>active<?php }?>">
        <a href="#" title="Payments" data-toggle="collapse-next">
           <em class="fa fa-money"></em>
           <span class="item-text">Payments</span>
        </a>
        <?php 
        $cls = '';
        if($currAction == 'singlecalculation' || $currAction == 'bulkcalculation' || $currAction == 'matchingamount'  || $currAction == 'roiandroyalty' || $currAction == 'closing' || $currAction == 'closingdetails' || $currAction == 'payoutrequest' || $currAction == 'clubincome' || $currAction == 'levelincome' || $currAction == 'calculatepairrate' || $currAction == 'pairratelist' || $currAction == 'calculatematchingincome' || $currAction == 'postincomes' || $currAction == 'savedpostincomes' || $currAction == 'calculateroi' || $currAction == 'calculatelegincome'){
          $cls = 'in';
        }?>

        <ul class="nav collapse <?php echo $cls; ?>">
            <!--<li  class="<?php if($currAction == 'singlecalculation'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/single-calculation" title="Single Calculation">
                <span class="item-text">Single Calculation</span>
              </a>
            </li>-->
            <!-- <li  class="<?php if($currAction == 'clubincome'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/club-income" title="Club Income">
                <span class="item-text">Club Income</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'matchingamount'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/matching-amount" title="Matching Amount">
                <span class="item-text">Matching Closing</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'levelincome'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/level-income" title="Level Income">
                <span class="item-text">Level Income</span>
              </a>
            </li> 
            <li  class="<?php if($currAction == 'calculatepairrate'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/calculate-pair-rate" title="Calculate Pair Rate">
                <span class="item-text">Calculate Pair Rate</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'pairratelist'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/pair-rate-list" title="Pair Rate List">
                <span class="item-text">Pair Rate List</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'calculatematchingincome'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/calculate-matching-income" title="Calculate Matching Income">
                <span class="item-text">Calculate Matching Income</span>
              </a>
            </li>-->
            <li  class="<?php if($currAction == 'calculateroi'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/calculate-roi" title="Calculate ROI">
                <span class="item-text">Calculate ROI</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'calculatelegincome'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/calculate-leg-income" title="Calculate Leg Income">
                <span class="item-text">Calculate Leg Income</span>
              </a>
            </li>
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
            <!-- <li  class="<?php if($currAction == 'roiandroyalty'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/roi-and-royalty" title="RoI & Royalty">
                <span class="item-text">PPI & Royalty</span>
              </a>
            </li>
            <li  class="<?php if($currAction == 'bulkcalculation'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/bulk-calculation" title="Closing">
                <span class="item-text">Closing</span>
              </a>
            </li> -->
            
          <!--  <li  class="<?php if($currAction == 'payoutrequest'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/payments/payout-request" title="Payout Request">
                <span class="item-text">Payout Request</span>
              </a>
            </li>-->
        </ul>
      </li>
    <?php 
    }?>
    <?php 
    if($adminUser['Permissions']['is_pending_plot_payment'] || $adminUser['Permissions']['is_incoming_income'] || $adminUser['Permissions']['is_outgoing_income'] || $adminUser['Permissions']['is_total_payout_report']) {?>
      <li class="<?php if($currController == 'reports'){?>active<?php }?>">
        <a href="#" title="Elements" data-toggle="collapse-next" class="Wallet">
           <em class="fa fa-ticket"></em>
           <span class="item-text">Reports</span>
        </a>
        <?php 
        $cls = '';
        if($currController == 'reports'){
          $cls = 'in';
        }?>

        <ul class="nav collapse <?php echo $cls; ?>">
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
    if($adminUser['Permissions']['is_tickets']) {?>
      <li class="<?php if($currAction == 'tickets' || $currAction == 'viewticket'){?>active<?php }?>">
        <a href="#" title="Elements" data-toggle="collapse-next" class="Wallet">
           <em class="fa fa-ticket"></em>
           <span class="item-text">Support</span>
        </a>
        <?php 
        $cls = '';
        if($currAction == 'tickets' || $currAction == 'viewticket'){
          $cls = 'in';
        }?>

        <ul class="nav collapse <?php echo $cls; ?>">
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
      <li class="<?php if($currController == 'setting'){?>active<?php }?>">
        <a href="#" title="Setting" data-toggle="collapse-next">
           <em class="fa fa-cogs"></em>
           <span class="item-text">Setting</span>
        </a>
        <?php 
        $cls = '';
        if($currController == 'setting'){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls; ?>">
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
    <li class="<?php if($currAction == 'accountpassword' || $currAction == 'transactionpassword'){?>active<?php }?>">
      <a href="#" title="Elements" data-toggle="collapse-next">
         <em class="fa fa-key"></em>
         <span class="item-text">Change Password</span>
      </a>
      <?php 
      $cls = '';
      if($currAction == 'accountpassword' || $currAction == 'transactionpassword'){
        $cls = 'in';
      }?>
      <ul class="nav collapse <?php echo $cls; ?>">
          <?php 
          if($adminUser['Permissions']['is_account_password']) {?>
            <li  class="<?php if($currAction == 'accountpassword'){?>active<?php }?>">
              <a href="<?php echo $backend_url; ?>/user/account-password" title="Account Password">
                 <span class="item-text">Account Password</span>
              </a>
            </li>
          <?php 
          }?>
          <li class="<?php if($currAction == 'transactionpassword'){?>active<?php }?>">
            <a href="<?php echo $backend_url;?>/user/transaction-password" title="Transaction Password">
              <span class="item-text">Transaction Password</span>
            </a>
          </li>
          <li class="<?php if($currAction == 'editaccount'){?>active<?php }?>">
            <a href="<?php echo $backend_url; ?>/user/edit-account" title="Edit Account" data-toggle="" class="no-submenu">
              <span class="item-text">User Password</span>
            </a>
          </li>
      </ul>
    </li>

    <!-- <li class="<?php if($currAction == 'plan'){?>active<?php }?>">
      <a href="<?php echo $backend_url ?>/business/plan" title="Business Plan">
         <em class="fa fa-qrcode"></em>
         <span class="item-text">Business Plan</span>
      </a>
    </li> -->

    <li class="">
      <a href="<?php echo $backend_url ?>/user/logout" title="Dashboard">
         <em class="fa fa-power-off"></em>
         <span class="item-text">Logout</span>
      </a>
    </li>
   <!-- END Menu-->
</ul>