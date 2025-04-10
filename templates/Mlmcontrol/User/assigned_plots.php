<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Assigned Plots
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Assigned On</th>
                                    <th>Username</th>
                                    <th>Property</th>
                                    <th>Site</th>
                                    <th>Block</th>
                                    <th>Plot</th>
                                    <th>Plot Number</th>
                                    <th>Area</th>
                                    <th>PLC</th>
                                    <th>Plan</th>
                                    <th>Current Rate</th>
                                    <th>Total Amount</th>
                                    <th>PLC Amount</th>
                                    <th>Grand Total</th>
                                    <th>Discount</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($assignPlots)){
                                  $i=1;
                                  foreach($assignPlots as $assignPlot){
                                    $currentPlan = $currentRatesTable->getCurrentPlanById($assignPlot->plan);
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td style="white-space: nowrap;"><?php echo date("F j, Y, g:i a", strtotime($assignPlot->created)); ?></td>
                                      <td style="white-space: nowrap;"><?php echo $assignPlot->Users['username'].' ('.$assignPlot->Details['first_name'].' '.$assignPlot->Details['last_name'].')'; ?></td>
                                      <td><?php echo $assignPlot->Properties['title']; ?></td>
                                      <td><?php echo $assignPlot->Sites['title']; ?></td>
                                      <td><?php echo $assignPlot->Blocks['title']; ?></td>
                                      <td><?php echo $assignPlot->Plots['name']; ?></td>
                                      <td><?php echo $assignPlot->plot_number; ?></td>
                                      <td><?php echo $assignPlot->area; ?></td>
                                      <td><?php echo $assignPlot->plc; ?></td>
                                      <td><?php echo $currentPlan; ?></td>
                                      <td><?php echo number_format($assignPlot->current_rate, 2); ?></td>
                                      <td><?php echo number_format($assignPlot->total_amount, 2); ?></td>
                                      <td><?php echo number_format($assignPlot->plc_amount, 2); ?></td>
                                      <td><?php echo number_format($assignPlot->grand_total, 2); ?></td>
                                      <td><?php echo number_format($assignPlot->discount, 2); ?></td>
                                       <td><?php if(!empty($assignPlot->remark)){echo $assignPlot->remark;}else{echo 'N/A';} ?></td>
                                      <td>
                                        <?php
                                        $status_cls = 'active-staus';
                                        $status_txt = 'Sold';
                                        if($assignPlot->status == 2){
                                          $status_cls = 'inactive-staus';
                                          $status_txt = 'On Hold';
                                        }
                                        elseif($assignPlot->status == 3){
                                          $status_cls = 'released-staus';
                                          $status_txt = 'Released';
                                        }
                                        ?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <!-- <li>
                                              <a href="<?php echo $backend_url; ?>/user/change-assigned-plot-status/1/<?php echo $assignPlot->id; ?>">Sold</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/change-assigned-plot-status/2/<?php echo $assignPlot->id; ?>">On Hold</a> 
                                            </li> -->
                                            <?php
                                            if($assignPlot->status == 1){ ?>
                                              <li>
                                                <a href="<?php echo $backend_url; ?>/user/change-assigned-plot-status/3/<?php echo $assignPlot->id; ?>">Released</a> 
                                              </li>
                                            <?php
                                            }?>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/assigned-plot-details/<?php echo $assignPlot->id; ?>">Details</a> 
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