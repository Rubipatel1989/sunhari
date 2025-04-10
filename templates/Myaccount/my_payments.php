<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   My Payments
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
              <!-- <a href="<?php echo $backend_url ?>/projects/add-plot"><i class="fa fa-plus"></i> Add New Plot</a>
              &nbsp; <a href="<?php echo $backend_url ?>/projects/add-multiple-plots"><i class="fa fa-plus"></i> Add Multiple Plots </a> -->
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        
                        <div class="col-xs-12 nopadding margin-top-15">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Paid On</th>
                                  <th>Amount</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($plotPayments)){
                                  $i=1;
                                  foreach($plotPayments as $plotPayment){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo date("F j, Y, g:i a", strtotime($plotPayment->created)); ?></td>
                                      <td style="vertical-align: top;"><?php echo number_format($plotPayment->amount, 2); ?></td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/payment-receipt/<?php echo base64_encode($plotPayment->id); ?>" target="_blank">Receipt</a> 
                                            </li>
                                          </ul>
                                       </div>
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