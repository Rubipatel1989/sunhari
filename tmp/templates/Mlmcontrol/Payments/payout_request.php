<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Payout Request
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
                           <form name="fund_request_bulk_form" id="fund_request_bulk_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                            <div class="col-xs-12 nopadding">
                              <table id="packages" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th><input type="checkbox" class="chk-all chk-check-uncheck"></th>
                                      <th>Sr. No.</th>
                                      <th>Date</th>
                                      <th>Username</th>
                                      <th>Name</th>
                                      <th>Account No.</th>
                                      <th>Payout Amount</th>
                                      <th>Status</th>
                                      <th>Remark</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($payments)){
                                      $i=1;
                                      foreach($payments as $payment){?>
                                         <tr>
                                          <td><input type="checkbox" name="ids[]" class="chk-all chk-ids" value="<?php echo $payment->id ?>"></td>
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo date("F j, Y, g:i a", strtotime($payment->created)); ?></td>
                                          <td><?php echo $payment->Users['username']; ?></td>
                                          <td><?php echo $payment->Details['first_name'].' '.$payment->Details['last_name']; ?></td>
                                          <td>
                                            <?php 
                                            if(!empty($payment->btc_address)){
                                              echo $payment->btc_address; 
                                            }
                                            elseif(!empty($payment->Details['pan_number'])){
                                              echo $payment->Details['pan_number']; 
                                            }
                                            else{
                                              echo 'N/A'; 
                                            }
                                            ?>
                                          </td>
                                          <td><?php echo number_format($payment->requested_amount, 2); ?></td>
                                          <td>
                                            <?php
                                            
                                            $status_cls = 'inactive-staus';
                                            $status_txt = 'Pending';
                                            if($payment->status == 1){
                                              $status_cls = 'active-staus';
                                              $status_txt = 'Paid';
                                            }?>
                                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                          </td>
                                          <td><?php echo html_entity_decode($payment->remark); ?></td>
                                        </tr>
                                      <?php
                                        $i++;
                                      }
                                    }?>
                                 </tbody>
                              </table>
                            </div>
                            <div class="col-xs-12 nopadding margin-top-5 margin-bottom-15">
                              <div class="col-xs-2 nopadding" style="width: 150px; float: left;">
                                <?php 
                                 $options = ['' => '-Select-', '0' => 'Pending', '1' => 'Paid'];
                                
                                 echo $this->Form->input('Payment.bulk_action', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                 ?>
                              </div>
                              <div class="col-xs-8 padding-left-10 padding-right-0" style="width: 100px; float: left;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                            </div>
                          </form>
                        </div>

                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>