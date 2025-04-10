<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Closing Details
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
            <div class="col-xs-12 nopadding table-cotainer">
              <div class="col-xs-12 nopadding">
                <form name="search_closing_detais_form" id="search_closing_detais_form" method="get">
                  <div class="col-sm-3 padding-left-0 padding-right-0">
                    <?php 
                    $options = ['' => '-Select Closing Count-'];
                    foreach($closingCounts as $closingCount){
                      $options[$closingCount->closing_count] = $closingCount->closing_count;
                    }
                    echo $this->Form->input('closing_count', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options, 'default' => $closing_count, 'data-live-search' => "true"));
                    ?>
                  </div>
                  <div class="col-sm-2 padding-left-10 padding-right-0">
                    <button type="submit" class="btn btn-square btn-primary">Search</button>
                  </div>
                </form>
              </div>
              <div class="col-xs-12 nopadding margin-top-20">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">Date</th>
                        <th style="white-space: nowrap;">Username</th>
                        <th style="white-space: nowrap;">Name</th>
                        <th style="white-space: nowrap;">PAN Number</th>
                        <th style="white-space: nowrap;">Account Number</th>
                        <th style="white-space: nowrap;">Bank Name</th>
                        <th style="white-space: nowrap;">Branch Name</th>
                        <th style="white-space: nowrap;">IFSC Code</th>
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
                      if(!empty($payments)){
                        $i=1;
                        //echo"<pre>";print_r($payments);exit;
                        foreach($payments as $payment){
                          $panNumber = 'N/A'; 
                          if(!empty($payment->pan_number)){
                            $panNumber = $payment->pan_number; 
                          }
                          $accountNumber = 'N/A';
                          if(!empty($payment->account_number)){
                            $accountNumber = $payment->account_number; 
                          }
                          $bankName = 'N/A'; 
                          if(!empty($payment->bank_name)){
                            $bankName = $payment->bank_name; 
                          }
                          $branchName = 'N/A'; 
                          if(!empty($payment->branch_name)){
                            $branchName = $payment->branch_name; 
                          }
                          $ifscCode = 'N/A'; 
                          if(!empty($payment->ifsc_code)){
                            $ifscCode = $payment->ifsc_code; 
                          }
                        ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td style="white-space: nowrap;">
                              <?php echo $payment->modified; ?>
                            </td>
                            <td><?php echo $payment->Users['username']; ?></td>
                            <td><?php echo $payment->Details['first_name']; ?></td>
                            <td><?php echo $panNumber; ?></td>
                            <td style="white-space: nowrap;">
                              <?php echo "'".$accountNumber . "'";?>
                            </td>

                            <td>
                              <?php echo $bankName;?>
                            </td>
                            <td>
                              <?php echo $branchName;?>
                            </td>
                            <td>
                              <?php echo $ifscCode;?>
                            </td>
                            <td>
                              <?php echo number_format($payment->direct_amount, 2); ?>
                            </td>
                            <td>
                              <?php 
                              echo number_format($payment->matching_amount, 2); 
                              ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->roi, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->royalty_amount, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->total, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->admin_commission, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->tax, 2); ?> 
                            </td>
                            <td>
                              <?php echo number_format($payment->net_amount, 2); ?>
                            </td>
                            <td>
                              <?php echo $payment->closing_count; ?>
                            </td>
                          </tr>
                        <?php
                          $i++;
                        }
                      }?>
                   </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>