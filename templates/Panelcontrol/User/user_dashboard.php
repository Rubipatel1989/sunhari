<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
     
   </div>
   User Dashboard
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding ">
              <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-xs-12 nopadding">
                      <?php echo $this->Flash->render(); ?>
                    </div>
                    <div class="col-xs-12 nopadding">
                      <?php echo $this->Form->create(NULL, array('id' => 'user_dashboard_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <legend>User Dashboard</legend>
                          <fieldset>
                            <div class="form-group margin-top-15">
                               <label class="col-sm-2 control-label">User<span class="red">*</span></label>
                               <div class="col-sm-4 height-37">
                                  <?php 
                                  $options = ['' => '-Select-'];
                                  foreach($users as $userInfo){
                                    $options[$userInfo->id] = $userInfo->username;
                                  }
                                  $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                  echo $this->Form->input('User.id', array('type' => 'select', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'options' => $options, 'default' => $selected, 'data-live-search' => "true"));
                                  ?>
                               </div>
                            </div>
                          </fieldset>
                          
                          <fieldset>
                            <div class="form-group">
                              <label class="col-sm-2 control-label"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/user/user-dashboard" class="btn btn-square btn-danger">Reset</a>
                              </div>
                            </div>
                          </fieldset>
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
              </div>
            </div>
            <?php
            if(!empty($statistics)){?>
              <div class="col-xs-12 nopadding margin-top-15">
                <ul class="dashboar-list">
                   
                   <!-- <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-briefcase wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Wallet Balance</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        $totalWalletAmount = 0;
                                        if(isset($statistics[0]['totalWalletAmount']) && !empty($statistics[0]['totalWalletAmount'])){
                                            $totalWalletAmount = $statistics[0]['totalWalletAmount'];
                                        }

                                        $totalTransferredAmount = 0;
                                        if(isset($statistics[0]['totalTransferredAmount']) && !empty($statistics[0]['totalTransferredAmount'])){
                                            $totalTransferredAmount = $statistics[0]['totalTransferredAmount'];
                                        }

                                        $totalUpgradesAmount = 0;
                                        if(isset($statistics[0]['totalUpgradesAmount']) && !empty($statistics[0]['totalUpgradesAmount'])){
                                            $totalUpgradesAmount = $statistics[0]['totalUpgradesAmount'];
                                        }
                                        $wallateBalance = $totalWalletAmount - ($totalTransferredAmount + $totalUpgradesAmount);
                                            echo number_format($wallateBalance, 2); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-calendar wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>User since</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <div class="col-xs-12 nopadding">
                                            <?php echo date("d/m/Y", strtotime($user->created)); ?>
                                        </div>
                                        <div class="col-xs-12 nopadding margin-top-3">
                                            <?php echo date("H:i:s", strtotime($user->created)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-calendar wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Activation Date</h4>
                                    </div>
                                    <?php
                                    if(isset($statistics[0]['activationDate']) && !empty($statistics[0]['activationDate'])){
                                    ?>
                                        <div class="col-xs-12 value-container">
                                            <div class="col-xs-12 nopadding">
                                                <?php echo date("d/m/Y", strtotime($statistics[0]['activationDate'])); ?>
                                            </div>
                                            <div class="col-xs-12 nopadding margin-top-3">
                                                <?php echo date("H:i:s", strtotime($statistics[0]['activationDate'])); ?>
                                            </div>
                                        </div>
                                    <?php
                                    }else{?>
                                        <div class="col-xs-12 value-container">
                                            N/A
                                        </div>
                                    <?php
                                    }?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-users wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Package Amount</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php 
                                        if(isset($statistics[0]['totalPackages']) && !empty($statistics[0]['totalPackages'])){
                                            echo 'Rs '.number_format($statistics[0]['totalPackages'], 2);
                                        }else{
                                            echo 'N/A';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-users wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Package Expire</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php 
                                        if(isset($statistics[0]['lastExpiry']) && !empty($statistics[0]['lastExpiry'])){
                                            echo date("d/m/Y", strtotime($statistics[0]['lastExpiry']));
                                        }else{
                                            echo 'N/A';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> -->
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-user wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Direct left</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                       <?php echo number_format($user->total_direct_left); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-user wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Direct Left BV</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_direct_acitve_left, 2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-users wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Direct Right</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_direact_right); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-users wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Direct Right BV</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_direct_acitve_right, 2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-users wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Downline Left</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                       <?php echo number_format($user->total_left); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Left BV</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_active_left, 2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Downline Right</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_right); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Right BV</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format($user->total_active_right, 2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Total BV</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php echo number_format(($user->total_active_left + $user->total_active_right), 2); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Direct Income</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['directIncome']) && !empty($statistics[0]['directIncome'])){
                                            echo number_format($statistics[0]['directIncome'], 2);
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                   <!-- <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Matching Income</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['matchingAmount']) && !empty($statistics[0]['matchingAmount'])){
                                           // echo number_format($statistics[0]['matchingAmount'], 2);
                                            echo 0;
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    
                    <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Super Bonus</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        $ 
                                        <?php 
                                        /*if(isset($statistics[0]['royaltyAmount']) && !empty($statistics[0]['royaltyAmount'])){
                                            echo number_format($statistics[0]['royaltyAmount'], 8);
                                        }else{
                                            echo '0.00';
                                        }*/?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->

                   <!-- <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>PPI</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['roiAmount']) && !empty($statistics[0]['roiAmount'])){
                                            //echo number_format($statistics[0]['roiAmount'], 2);
                                            echo 0;
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->

                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Total Payout</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['totalPayouts']) && !empty($statistics[0]['totalPayouts'])){
                                            echo number_format($statistics[0]['totalPayouts'], 2);
                                            //echo 0;
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                  <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Successfull Withdrawls</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['successfullWithdrawls']) && !empty($statistics[0]['successfullWithdrawls'])){
                                            echo number_format($statistics[0]['successfullWithdrawls'], 2);
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->

                   <!--<li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Pending withdrawls</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        if(isset($statistics[0]['pendingWithdrawls']) && !empty($statistics[0]['pendingWithdrawls'])){
                                            echo number_format($statistics[0]['pendingWithdrawls'], 2);
                                        }else{
                                            echo '0.00';
                                        }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-money wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Payable</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        Rs 
                                        <?php 
                                        $totaPendingPayable = 0;
                                        /*if(isset($statistics[0]['totaPendingPayable']) && !empty($statistics[0]['totaPendingPayable']) && $statistics[0]['totaPendingPayable'] > 0){
                                            $totaPendingPayable = ($statistics[0]['totaPendingPayable'] * $binary->percentage)/100;
                                        }*/
                                         $totaPendingPayable = isset($statistics[0]['totaPendingPayable']) && !empty($statistics[0]['totaPendingPayable']) ? ($statistics[0]['totaPendingPayable'] * $binaryMultiplier) : 0;

                                        echo number_format($totaPendingPayable, 2); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- <li>
                        <div class="col-xs-12 stat-container">
                            <div class="col-xs-12 nopadding">
                                <div class="col-xs-4 stat-icon-container">
                                    <i class="fa fa-trophy wallet-balance-icon"></i>
                                </div>
                                <div class="col-xs-8 title-container">
                                    <div class="col-xs-12 nopadding">
                                        <h4>Club Achieved</h4>
                                    </div>
                                    <div class="col-xs-12 value-container">
                                        <?php 
                                        /*if($statistics[0]['is_bike_club'] == 1){
                                            echo 'Bike';
                                        }
                                        elseif($statistics[0]['is_laptop_club'] == 1){
                                            echo 'Laptop';
                                        }
                                        elseif($statistics[0]['is_mobile_club'] == 1){
                                            echo 'Mobile';
                                        }else{
                                            echo 'N/A';
                                        }*/
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> -->
                </ul>
              </div>
            <?php
            }?>
        </div>
    </div>
</div>
<?php echo $this->element('ajax-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>