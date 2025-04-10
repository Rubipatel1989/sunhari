<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Payment Closing</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Payment Closing
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="payments_closing" class="table table-bordered table-hover table-striped w-100">
                             <thead>
                                <tr>
                                  <th><input type="checkbox" class="chk-all chk-check-uncheck"></th>
                                  <th style="white-space: nowrap;">Sr. No.</th>
                                  <th style="white-space: nowrap;">Username</th>
                                  <th style="white-space: nowrap;">Name</th>
                                  <th style="white-space: nowrap;">Account No.</th>
                                  <th style="white-space: nowrap;">Direct Amount</th>
                                  <th style="white-space: nowrap;">Matching Amount</th>
                                  <th style="white-space: nowrap;">Capping Amount</th>
                                  <th style="white-space: nowrap;">Gold Amount</th>
                                  <th style="white-space: nowrap;">Platinum Amount</th>
                                  <th style="white-space: nowrap;">Ambrand Amount</th>
                                  <th style="white-space: nowrap;">Diamond Amount</th>
                                  <th style="white-space: nowrap;">King Amount</th>
                                  <th style="white-space: nowrap;">Total</th>
                                  <th style="white-space: nowrap;">Tax</th>
                                  <th style="white-space: nowrap;">Admin Commission</th>
                                  <th style="white-space: nowrap;">Net Amount</th>
                                  <th style="white-space: nowrap;">Closing</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($closings)){
                                  $i=1;
                                  foreach($closings as $closing){

                                    $minAmount = 0;

                                    if($closing['total_direct_acitve_left'] > 0 && $closing['total_direct_acitve_right'] > 0){

                                      $minAmount = $closing['total_active_left'];
                                      if($closing['total_active_left'] > $closing['total_active_right']){

                                        $minAmount = $closing['total_active_right'];

                                      }
                                    }

                                    $subMinAmount = $minAmount - $closing['previous_pair'];

                                    $multiplier = $binary->amount;
                                    if($binary->type == 1){
                                      $multiplier = ($binary->percentage)/100;
                                    }
                                    
                                    $matchingAmount = $subMinAmount*$multiplier;

                                    $maximumAmount = 200000;
                                    $closingCappingAmount = $maximumAmount;
                                    $closingMatchingAmount = $matchingAmount;
                                    if($matchingAmount > $maximumAmount) {
                                      $closingMatchingAmount = $maximumAmount;
                                      $closingCappingAmount = $matchingAmount;
                                    }

                                    $total = $closing['direct_amount'] + $closingMatchingAmount + $closing['mobile_club_amount'] + $closing['laptop_club_amount'] + $closing['bike_club_amount'] + $closing['diamond_club_amount'] + $closing['king_club_amount']; 

                                    $tax = ($total*5)/100;

                                    $adminCommission = ($total*5)/100;

                                    $total_commission = $tax + $adminCommission ;

                                    $net_amount = $total - $total_commission;
                                    

                                  ?>
                                    <tr class="gradeX">
                                      <input type="hidden"  name="sub_min_amount[<?php echo $closing['id']; ?>]" value="<?php echo $subMinAmount; ?>">
                                      <td><input type="checkbox" name="ids[]" class="chk-all chk-ids" value="<?php echo $closing['id']; ?>"></td>
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $closing['username']; ?></td>
                                      <td><?php echo $closing['first_name'].' '.$closing['last_name']; ?></td>
                                      <td>
                                        <?php 
                                        $account_number = isset($closing['account_number']) ? $closing['account_number'] : ''; 
                                        if(!empty($account_number)){
                                          echo $account_number; 
                                        }else{
                                          echo 'N/A';
                                        }
                                        ?>
                                        <input type="hidden"  name="btc_address[<?php echo $closing['id']; ?>]" value="<?php echo $account_number; ?>">
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['direct_amount'], 2); ?>
                                        <input type="hidden"  name="direct_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['direct_amount']; ?>">
                                      </td>
                                      <td>
                                        <?php 
                                        echo number_format($matchingAmount, 2); 
                                        ?>
                                        <input type="hidden"  name="matching_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closingMatchingAmount; ?>">  
                                      </td>
                                      <td>
                                        <?php
                                        echo number_format($maximumAmount, 2);
                                        ?>
                                        <input type="hidden"  name="capping_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closingCappingAmount; ?>">  
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['mobile_club_amount'], 2); ?>
                                        <input type="hidden"  name="mobile_club_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['mobile_club_amount']; ?>">
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['laptop_club_amount'], 2); ?>
                                        <input type="hidden"  name="laptop_club_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['laptop_club_amount']; ?>">
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['bike_club_amount'], 2); ?>
                                        <input type="hidden"  name="bike_club_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['bike_club_amount']; ?>">
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['diamond_club_amount'], 2); ?>
                                        <input type="hidden"  name="diamond_club_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['diamond_club_amount']; ?>">
                                      </td>
                                      <td>
                                        <?php echo number_format($closing['king_club_amount'], 2); ?>
                                        <input type="hidden"  name="king_club_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['king_club_amount']; ?>">
                                      </td>




                                      <td>
                                        <?php echo number_format($total, 2); ?>
                                        <input type="hidden"  name="total[<?php echo $closing['id']; ?>]" value="<?php echo $total; ?>">
                                      </td>
                                     
                                      <td>
                                        <?php echo number_format($tax, 2); ?>
                                        <input type="hidden"  name="tax[<?php echo $closing['id']; ?>]" value="<?php echo $tax; ?>"> 
                                      </td>
                                      <td>
                                        <?php echo number_format($adminCommission, 2); ?>
                                        <input type="hidden"  name="admin_commission[<?php echo $closing['id']; ?>]" value="<?php echo $adminCommission; ?>"> 
                                      </td>
                                      <td>
                                        <?php echo number_format($net_amount, 2); ?>
                                        <input type="hidden"  name="net_amount[<?php echo $closing['id']; ?>]" value="<?php echo $net_amount; ?>">
                                      </td>
                                      <td><input type="text" name="closing_count[<?php echo $closing['id']; ?>]" class="form-control" value="<?php echo $closing['closing_count'] + 1; ?>" style="width: 50px;" readonly></td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                        </div>
                        <div class="row nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                          </div> 
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>