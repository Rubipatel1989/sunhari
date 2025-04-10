<?php
$currAction = $this->request->getAttribute('params')['action'];
?>
<ul class="nav">
   <!-- START Menu-->
    <li class="nav-heading">Main navigation</li>
    <li class="<?php if($currAction == 'index'){?>active<?php }?>">
        <a href="<?php echo $home_url ?>/my-account" title="Dashboard">
           <em class="fa fa-dot-circle-o"></em>
           <span class="item-text">Dashboard</span>
        </a>
    </li>

   <li class="<?php if($currAction == 'buyPackage'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/buy-package" title="Buy Package">
         <em class="fa fa-cubes"></em>
         <span class="item-text">Buy Package</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'buyProduct'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/buy-product" title="Buy Product">
         <em class="fa fa-product-hunt"></em>
         <span class="item-text">Buy Product</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'checkout'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/checkout" title="Checkout">
         <em class="fa fa-shopping-cart"></em>
         <span class="item-text">Checkout</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'myOrders'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/my-orders" title="My Orders">
         <em class="fa fa-shopping-basket"></em>
         <span class="item-text">My Orders</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'ads'){?>active<?php }?> hidden">
      <a href="<?php echo $home_url ?>/my-account/ads" title="Links">
         <em class="fa fa-link"></em>
         <span class="item-text">My Ads</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'addUser' || $currAction == 'addKyc' || $currAction == 'upgradeUser' || $currAction == 'upgradeHistory' || $currAction == 'registeredUsers'){?>active<?php }?>">
      <a href="#" title="Users" data-toggle="collapse-next" class="has-submenu">
         <em class="fa fa-users"></em>
         <span class="item-text">Users</span>
      </a>
      <!-- START SubMenu item-->
      <?php 
      $cls = '';
      if($currAction == 'addUser' || $currAction == 'addKyc' || $currAction == 'upgradeUser' || $currAction == 'upgradeHistory' || $currAction == 'registeredUsers'){
        $cls = 'in';
      }?>
      <ul class="nav collapse <?php echo $cls;?>">
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
        <!--<li class="<?php if($currAction == 'upgradeUser'){?>active<?php }?>">
          <a href="<?php echo $home_url; ?>/my-account/manage-users/upgrade-user" title="Upgrade User" data-toggle="" class="no-submenu">
            <span class="item-text">Upgrade User</span>
          </a>
        </li>
        <li class="<?php if($currAction == 'upgradeHistory'){?>active<?php }?>">
          <a href="<?php echo $home_url; ?>/my-account/manage-users/upgrade-history" title="Upgrade History" data-toggle="" class="no-submenu">
            <span class="item-text">Upgrade History</span>
          </a>
        </li>-->
        <li class="<?php if($currAction == 'registeredUsers'){?>active<?php }?>">
          <a href="<?php echo $home_url; ?>/my-account/manage-users/registered-users" title="Registered Users" data-toggle="" class="no-submenu">
            <span class="item-text">Users List</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="<?php if($currAction == 'MyDirectNetwork' || $currAction == 'myNetwork' || $currAction == 'directReferral' || $currAction == 'downlineReport'){?>active<?php }?>">
        <a href="#" title="Team" data-toggle="collapse-next">
           <em class="fa fa-users"></em>
           <span class="item-text">Team</span>
        </a>
        <!-- START SubMenu item-->

        <?php 
        $cls = '';
        if($currAction == 'directNetwork' || $currAction == 'myNetwork' || $currAction == 'directReferral' || $currAction == 'downlineReport'){
          $cls = 'in';
        }?>
        <ul class="nav collapse <?php echo $cls; ?>">
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
    <!--<li class="<?php if($currAction == 'payoutReport' || $currAction == 'fundRequest' || $currAction == 'requestFund' || $currAction == 'amountTransfer' || $currAction == 'amountReceive' || $currAction == 'totalTransaction'){?>active<?php }?>">
        <a href="#" title="Elements" data-toggle="collapse-next" class="Wallet">
           <em class="fa fa-briefcase"></em>
           <span class="item-text">Wallet</span>
        </a>
        <?php 
        $cls = '';
        if($currAction == 'payoutReport' || $currAction == 'fundRequest' || $currAction == 'requestFund' || $currAction == 'transferedAmount' || $currAction == 'transferAmount' || $currAction == 'amountReceive' || $currAction == 'totalTransaction'){
          $cls = 'in';
        }?>
     
        <ul class="nav collapse <?php echo $cls; ?>">
            <li class="<?php if($currAction == 'fundRequest' || $currAction == 'requestFund'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/wallet/fund-request" title="Registered" data-toggle="" class="Fund Request">
                 <span class="item-text">Fund Request</span>
              </a>
            </li>
            <li class="<?php if($currAction == 'payoutReport'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/wallet/payout-report" title="Registered" data-toggle="" class="Payout Report">
                 <span class="item-text">Payout Report</span>
              </a>
            </li>
            <li class="<?php if($currAction == 'transferedAmount' || $currAction == 'transferAmount'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/wallet/transfered-amount" title="Upgraded" data-toggle="" class="Amount Transfered">
                <span class="item-text">Transfered Amount</span>
              </a>
            </li>
             <li>
              <a href="<?php echo $home_url ?>/my-account/wallet/amount-receive" title="Upgraded" data-toggle="" class="Amount Receive">
                 <span class="item-text">Amount Receive</span>
              </a>
            </li>
            <li>
              <a href="<?php echo $home_url ?>/my-account/wallet/total-transaction" title="Upgraded" data-toggle="" class="Total Transaction">
                 <span class="item-text">Total Transaction</span>
              </a>
            </li> 
        </ul>
        
    </li>-->

    <li class="<?php if($currAction == 'closingDetails' || $currAction == 'payoutRequest' || $currAction == 'requestPayout' || $currAction == 'rewards'){?>active<?php }?>">
        <a href="#" title="Elements" data-toggle="collapse-next" class="Payouts">
           <em class="fa fa-money"></em>
           <span class="item-text">Payouts</span>
        </a>
        <?php 
        $cls = '';
        if($currAction == 'closingDetails' || $currAction == 'payoutRequest' || $currAction == 'requestPayout' || $currAction == 'rewards'){
          $cls = 'in';
        }?>
        <!-- START SubMenu item-->
        <ul class="nav collapse <?php echo $cls; ?>">
            <!--<li class="<?php if($currAction == 'roiDetails'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/payouts/roi-details" title="Registered" data-toggle="" class="PPI Details">
                 <span class="item-text">PPI Details</span>
              </a>
            </li>-->
            <li class="<?php if($currAction == 'closingDetails'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/payouts/closing-details" title="Registered" data-toggle="" class="Closing Details">
                 <span class="item-text">Closing Details</span>
              </a>
            </li>
          
          	 
          
            <li class="<?php if($currAction == 'payoutRequest' || $currAction == 'requestPayout'){?>active<?php }?> hidden">
              <a href="<?php echo $home_url ?>/my-account/payouts/payout-request" title="Registered" data-toggle="" class="Closing Details">
                 <span class="item-text">Payout Request</span>
              </a>
            </li>
            <li class="<?php if($currAction == 'rewards'){?>active<?php }?>">
              <a href="<?php echo $home_url ?>/my-account/payouts/rewards" title="Registered" data-toggle="" class="Rewards">
                 <span class="item-text">Rewards</span>
              </a>
            </li>
          	
          
        </ul>
    </li>

    <li class="<?php if($currAction == 'directRewards' || $currAction == 'pairRewards'){?>active<?php }?>">
        <a href="#" title="Elements" data-toggle="collapse-next" class="Payouts">
           <em class="fa fa-trophy"></em>
           <span class="item-text">Rewards</span>
        </a>
        <?php 
        $cls = '';
        if($currAction == 'directRewards' || $currAction == 'pairRewards'){
          $cls = 'in';
        }?>
        <!-- START SubMenu item-->
        <ul class="nav collapse <?php echo $cls; ?>">
           
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

    <li class="<?php if($currAction == 'editProfile'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/edit-profile" title="Edit Account">
         <em class="fa fa-edit"></em>
         <span class="item-text">View Profile</span>
      </a>
    </li>

    <li class="<?php if($currAction == 'tickets' || $currAction == 'addTicket' || $currAction == 'viewTicket'){?>active<?php }?>">
      <a href="#" title="Elements" data-toggle="collapse-next" class="Wallet">
         <em class="fa fa-ticket"></em>
         <span class="item-text">Support</span>
      </a>
      <?php 
      $cls = '';
      if($currAction == 'tickets' || $currAction == 'addTicket' || $currAction == 'viewTicket'){
        $cls = 'in';
      }?>

      <ul class="nav collapse <?php echo $cls; ?>">
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

    <li class="<?php if($currAction == 'accountPassword' || $currAction == 'transactionPassword'){?>active<?php }?>">
      <a href="#" title="Elements" data-toggle="collapse-next">
         <em class="fa fa-key"></em>
         <span class="item-text">Change Password</span>
      </a>
      <?php 
      $cls = '';
      if($currAction == 'accountPassword' || $currAction == 'transactionPassword'){
        $cls = 'in';
      }?>
      <ul class="nav collapse <?php echo $cls; ?>">
          <li  class="<?php if($currAction == 'accountPassword'){?>active<?php }?>">
            <a href="<?php echo $home_url; ?>/my-account/change-password/account-password" title="Account Password">
               <span class="item-text">Account Password</span>
            </a>
          </li>
          <!--<li class="<?php if($currAction == 'transactionPassword'){?>active<?php }?>">
            <a href="<?php echo $home_url;?>/my-account/change-password/transaction-password" title="Transaction Password">
              <span class="item-text">Transaction Password</span>
            </a>
          </li>-->
      </ul>
    </li>

    <li class="<?php if($currAction == 'buinessPlan'){?>active<?php }?>">
      <a href="<?php echo $home_url ?>/my-account/buiness-plan" title="Business Plan">
         <em class="fa fa-qrcode"></em>
         <span class="item-text">Business Plan</span>
      </a>
    </li>

    <li>
      <a href="<?php echo $home_url ?>/logout_user" title="Logout">
         <em class="fa fa-power-off"></em>
         <span class="item-text">Logout</span>
      </a>
    </li>
   <!-- END Menu-->
</ul>