<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Plot Payment List
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
              <!-- <a href="<?php echo $backend_url ?>/projects/add-plot"><i class="fa fa-plus"></i> Add New Plot</a>
              &nbsp; <a href="<?php echo $backend_url ?>/projects/add-multiple-plots"><i class="fa fa-plus"></i> Add Multiple Plots </a> -->
              <strong>Total Payment :</strong> <?php echo number_format($totalPaymentInfo->total_amount, 2);?>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <form name="plot_payment_form"  id="" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <div class="col-xs-12 nopadding">
                              <div class="col-sm-2 padding-left-0">
                                <?php
                                $selected = isset($this->request->data['PlotPayment']['user_id']) ? trim($this->request->data['PlotPayment']['user_id']) : $intUserId; 
                                $options = ['' => '-Select User-'];
                                foreach($users as $user){
                                  $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                }
                                echo $this->Form->input('PlotPayment.user_id', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'default' => $selected, 'class' => 'form-control loginbox', 'data-live-search' => "true", 'onchange' => 'filterPlotPaymentsByUser(this.value, "plot_container", "PlotPayment.assign_plot_id", "form-control loginbox");')); 
                                ?>
                              </div>
                              <div id="plot_container" class="col-sm-3 padding-left-0">
                                <?php 
                                $selected = isset($this->request->data['PlotPayment']['assign_plot_id']) ? trim($this->request->data['PlotPayment']['assign_plot_id']) : $intAssignPlotId; 
                                $options = ['' => '-Select Polt Number-'];
                                foreach($assignPlots as $assignPlot){
                                  $options[$assignPlot->id] = $assignPlot->plot_number;
                                }
                                echo $this->Form->input('PlotPayment.assign_plot_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox',  'default' => $selected,)); 
                                 ?>
                              </div>
                              <div class="col-sm-2 padding-left-0">
                                <div class="dob input-group date">
                                  <?php 
                                  $from_date = isset($this->request->data['PlotPayment']['from_date']) ? trim($this->request->data['PlotPayment']['from_date']) : ''; 
                                  echo $this->Form->input('PlotPayment.from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date)); 
                                  ?>
                                  <span class="input-group-addon">
                                     <span class="fa fa-calendar"></span>
                                  </span>
                                </div>
                              </div>
                              <div class="col-sm-2 padding-left-0">
                                <div class="dob input-group date">
                                  <?php 
                                  $to_date = isset($this->request->data['PlotPayment']['to_date']) ? trim($this->request->data['PlotPayment']['to_date']) : ''; 
                                  echo $this->Form->input('PlotPayment.to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "To Date", 'value' => $to_date)); 
                                  ?>
                                  <span class="input-group-addon">
                                     <span class="fa fa-calendar"></span>
                                  </span>
                                </div>
                              </div>
                              <div class="col-sm-3 padding-left-0">
                                <button type="submit" class="btn btn-square btn-primary">Submit</button> &nbsp; <a href="<?php echo $backend_url ?>/projects/plot-payment-list" class="btn btn-square btn-danger">Reset</a>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-xs-12 nopadding margin-top-15">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Paid On</th>
                                  <th>User</th>
                                  <th>Amount</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                /*echo '<pre>';
                                print_r($totalPaymentInfo->total_amount);*/
                                if(!empty($plotPayments)){
                                  $i=1;
                                  foreach($plotPayments as $plotPayment){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo date("F j, Y, g:i a", strtotime($plotPayment->created)); ?></td>
                                      <td style="vertical-align: top;"><?php echo $plotPayment->Users['username'].' ('.$plotPayment->Details['first_name'].' '.$plotPayment->Details['last_name'].')' ?></td>
                                      <td style="vertical-align: top;"><?php echo number_format($plotPayment->amount, 2); ?></td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/payment-receipt/<?php echo base64_encode($plotPayment->id); ?>" target="_blank">Receipt</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/delete-payment/<?php echo base64_encode($plotPayment->id); ?>" onclick="return confirm('Delete operation will delete data permanently from database. Are you sure to delete?');">Delete</a> 
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