<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Closing Detail Id Wise</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Closing Detail Id Wise
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                        <div class="row nopadding margin-bottom-20">
                          <form name="users-form" id="users-form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="col-sm-12 nopadding">
                              <div class="col nopadding" style="width: 250px; float: left;">
                                <?php 
                                $options = ['' => '-Select Username-'];
                                foreach($users as $user){
                                  $options[$user->username] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                }
                                $selected = isset($_GET['username']) ? $_GET['username'] : '';
                                echo $this->Form->input('username', array('type' => 'select', 'id' => 'single-default', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox select2', 'default' => $selected, 'data-live-search' => "true")); 
                                 ?>
                              </div>
                              <div class="col padding-left-10 padding-right-0" style="width: 100px; float: left;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="row nopadding table-cotainer">
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
                                    if(!empty($payment->Details['pan_number'])){
                                      $panNumber = $payment->Details['pan_number']; 
                                    }
                                    $accountNumber = 'N/A';
                                    if(!empty($payment->Details['account_number'])){
                                      $accountNumber = $payment->Details['account_number']; 
                                    }
                                    $bankName = 'N/A'; 
                                    if(!empty($payment->Details['bank_name'])){
                                      $bankName = $payment->Details['bank_name']; 
                                    }
                                    $branchName = 'N/A'; 
                                    if(!empty($payment->Details['branch_name'])){
                                      $branchName = $payment->Details['branch_name']; 
                                    }
                                    $ifscCode = 'N/A'; 
                                    if(!empty($payment->Details['ifsc_code'])){
                                      $ifscCode = $payment->Details['ifsc_code']; 
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