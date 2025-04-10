<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">Closing Details</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Closing Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="col-sm-12  margin-top-20">
                      <form name="search_closing_detais_form" id="search_closing_detais_form" method="get">
                        <div class="row">
                          <div class="col padding-right-0">
                            <?php 
                            $options = ['' => '-Select Closing Count-'];
                            foreach($closingCounts as $closingCount){
                              $options[$closingCount->closing_count] = $closingCount->closing_count;
                            }
                            echo $this->Form->input('closing_count', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'options' => $options, 'default' => $closing_count,));
                            ?>
                          </div>
                          <div class="col padding-left-10 padding-right-0">
                            <button type="submit" class="btn btn-square btn-primary">Search</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="panel-content">
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
                              if(!empty($payments)){
                                $i=1;
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
                                    <td><?php echo $payment->Details['first_name'].' '.$payment->Details['last_name']; ?></td>
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
                                      <?php echo number_format($payment->matching_amount, 2); ?> 
                                    </td>


                                    <td>
                                      <?php echo number_format($payment->mobile_club_amount, 2); ?> 
                                    </td>
                                    <td>
                                      <?php echo number_format($payment->laptop_club_amount, 2); ?> 
                                    </td>
                                    <td>
                                      <?php echo number_format($payment->bike_club_amount, 2); ?> 
                                    </td>
                                    <td>
                                      <?php echo number_format($payment->diamond_club_amount, 2); ?> 
                                    </td>
                                    <td>
                                      <?php echo number_format($payment->king_club_amount, 2); ?> 
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
</main>