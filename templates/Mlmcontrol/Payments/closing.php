<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($closings);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Payment Closing
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
                        <?php echo $this->Form->create(NULL, array('id' => 'bulk-payment-closing-form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <div class="col-xs-12 nopadding table-cotainer">
                          
                            <div class="col-xs-12 nopadding">
                              <table id="payments_closing" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th><input type="checkbox" class="chk-all chk-check-uncheck"></th>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Username</th>
                                      <th style="white-space: nowrap;">Name</th>
                                      <th style="white-space: nowrap;">Account No.</th>
                                      <th style="white-space: nowrap;">Direct Amount</th>
                                      <th style="white-space: nowrap;">Matching Amount</th>
                                      <th style="white-space: nowrap;">ROI Amount</th>
                                      <th style="white-space: nowrap;">Single Leg</th>
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

                                        $total = $closing['direct_amount'] + $closing['matching_amount'] + $closing['royalty_amount'] + $closing['roi']; 

                                        $tax = ($total*$commission->tax)/100;

                                        $adminCommission = ($total*$commission->amount)/100;

                                        $total_commission = $tax + $adminCommission ;

                                        $net_amount = $total - $total_commission;
                                        

                                      ?>
                                        <tr class="gradeX">
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
                                            echo number_format($closing['matching_amount'], 2); 
                                            ?>
                                            <input type="hidden"  name="matching_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['matching_amount']; ?>">  
                                          </td>
                                          <td>
                                            <?php 
                                            echo number_format($closing['roi'], 2); 
                                            ?>
                                            <input type="hidden"  name="roi[<?php echo $closing['id']; ?>]" value="<?php echo $closing['roi']; ?>">  
                                          </td>
                                          <td>
                                            <?php 
                                            echo number_format($closing['royalty_amount'], 2); 
                                            ?>
                                            <input type="hidden"  name="royalty_amount[<?php echo $closing['id']; ?>]" value="<?php echo $closing['royalty_amount']; ?>">  
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
                          </div>
                          <div class="col-xs-12 nopadding margin-top-15">
                            <button type="submit" class="btn btn-primary" name="btn_payment_calculation">Submit</button>
                          </div>
                        <?php echo $this->Form->end();?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>