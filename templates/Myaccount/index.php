<?php
echo $this->Html->css('frontend/css/my-account.css');
$binaryMultiplier = $binary->amount;
if($binary->type == 1){
    $binaryMultiplier = ($binary->percentage)/100;
}
?>
<h3>
   <div class="pull-right text-center">
      
   </div>Dashboard
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 margin-top-mobile-25 notice-box text-16">
                <marquee>Welcome in Fashioholic.</marquee>
            </div>
        </div>
        <div class="col-xs-12 nopadding margin-top-15">
            <ul class="dashboar-list">
               
               
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
                                <i class="fa fa-users wallet-balance-icon"></i>
                            </div>
                            <div class="col-xs-8 title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Self Unit</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php 
                                    if(isset($statistics[0]['totalPackages']) && !empty($statistics[0]['totalPackages'])){
                                        echo number_format($statistics[0]['totalPackages'], 2);
                                    }else{
                                        echo 'N/A';
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="col-xs-12 stat-container">
                        <div class="col-xs-12 nopadding">
                            <div class="col-xs-4 stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="col-xs-8 title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Left Unit</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php 
                                    echo number_format($user->active_left_one, 2); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="col-xs-12 stat-container">
                        <div class="col-xs-12 nopadding">
                            <div class="col-xs-4 stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="col-xs-8 title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Right Unit</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php 
                                    echo number_format($user->active_right_one, 2); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>


                <li>
                    <div class="col-xs-12 stat-container">
                        <div class="col-xs-12 nopadding">
                            <div class="col-xs-4 stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="col-xs-8 title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Direct Left Unit</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php 
                                    echo number_format($user->direct_active_left_one, 2); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="col-xs-12 stat-container">
                        <div class="col-xs-12 nopadding">
                            <div class="col-xs-4 stat-icon-container">
                                <i class="fa fa-user wallet-balance-icon"></i>
                            </div>
                            <div class="col-xs-8 title-container">
                                <div class="col-xs-12 nopadding">
                                    <h4>Direct Right Unit</h4>
                                </div>
                                <div class="col-xs-12 value-container">
                                    <?php 
                                    echo number_format($user->direct_active_right_one, 2); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
              <li>
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
                </li>
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
                <li>
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
                </li>
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
                <li>
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
                </li>
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
                <li>
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
                </li>
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
                


            </ul>
        </div>
    </div>
</div>