<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Plot Payment List</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Plot Payment List
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-xs-12 nopadding">
                          <?php echo $this->Form->create(NULL, array('id' => 'plot_payment_search_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <div class="row nopadding margin-bottom-25">
                              <div class="col-sm-3 padding-left-0">
                                <?php
                                $selected = isset($this->request->data['PlotPayment']['user_id']) ? trim($this->request->data['PlotPayment']['user_id']) : $intUserId; 
                                $options = ['' => '-Select User-'];
                                foreach($users as $user){
                                  $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                }
                                echo $this->Form->input('PlotPayment.user_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'default' => $selected, 'class' => 'select2 form-control loginbox', 'onchange' => 'filterPlotPaymentsByUser(this.value, "plot_container", "PlotPayment.assign_plot_id", "form-control loginbox");')); 
                                ?>
                              </div>
                              <div id="plot_container" class="col-sm-2 padding-left-0">
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


                                <div class="input-group">
                                  <?php 
                                  $from_date = isset($this->request->data['PlotPayment']['from_date']) ? trim($this->request->data['PlotPayment']['from_date']) : ''; 
                                  echo $this->Form->input('PlotPayment.from_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "From Date", 'value' => $from_date)); 
                                  ?>
                                 </div>

                              </div>
                              <div class="col-sm-2 padding-left-0">
                                <div class="input-group">
                                  <?php 
                                  $to_date = isset($this->request->data['PlotPayment']['to_date']) ? trim($this->request->data['PlotPayment']['to_date']) : ''; 
                                  echo $this->Form->input('PlotPayment.to_date', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox', 'placeholder' => "To Date", 'value' => $to_date)); 
                                  ?>
                                 </div>
                              </div>
                              <div class="col-sm-3 padding-left-0">
                                <button type="submit" class="btn btn-square btn-primary">Submit</button> &nbsp; <a href="<?php echo $backend_url ?>/projects/plot-payment-list" class="btn btn-square btn-danger">Reset</a>
                              </div>
                            </div>
                          <?php echo $this->Form->end();?>
                        </div>
                      <div class="row nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <div class="row nopadding table-cotainer">
                        <table id="payments_closing" class="table table-bordered table-hover table-striped w-100">
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
                                  $arrPlotmentData = [];
                                  $i=1;
                                  foreach($plotPayments as $plotPayment){
                                    if ($i <= 100) {
                                    ?>
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
                                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/projects/payment-receipt/<?php echo base64_encode($plotPayment->id); ?>" target="_blank">Receipt</a> 
                                              </li>
                                              <li>
                                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/projects/delete-payment/<?php echo base64_encode($plotPayment->id); ?>" onclick="return confirm('Delete operation will delete data permanently from database. Are you sure to delete?');">Delete</a> 
                                              </li>
                                            </ul>
                                         </div>
                                        </td>
                                      </tr>
                                  <?php
                                  }
                                  else {
                                    $ddlHtml = '<div class="btn-group">
                                      <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                      </button>
                                      <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                        <li>
                                          <a class="dropdown-item" href=" '.$backend_url.'/projects/payment-receipt/'.base64_encode($plotPayment->id).'" target="_blank">Receipt</a> 
                                        </li>
                                        <li>
                                          <a class="dropdown-item" href="'.$backend_url.'/projects/delete-payment/'.base64_encode($plotPayment->id).'" onclick="return confirm(\'Delete operation will delete data permanently from database. Are you sure to delete?\');">Delete</a> 
                                        </li>
                                      </ul>
                                   </div>';
                                    $arrPlotmentData[] = [
                                      $i,
                                      date("F j, Y, g:i a", strtotime($plotPayment->created)),
                                      $plotPayment->Users['username'].' ('.$plotPayment->Details['first_name'].' '.$plotPayment->Details['last_name'].')',
                                      number_format($plotPayment->amount, 2),
                                      $ddlHtml
                                    ];
                                  }
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                      </div> 
                      <div class="row margin-top-10">
                        <button id="loadMoreRow" type="button" class="btn btn-primary">Load full data</button>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    $(document).ready(function(){
      $("#loadMoreRow").click(function(){
        $(this).hide();
        var table = $('#payments_closing').DataTable();
        table.rows.add(<?php echo json_encode($arrPlotmentData); ?>);
        table .draw();
      });
    });
</script>