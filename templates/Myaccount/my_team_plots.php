<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  My Team Plots
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="downlineReport" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                   <th>Sr. No.</th>
                                   <th>Booking Date</th>
                                   <th>Username</th>
                                   <th>Name</th>
                                   <th>Mobile No.</th>
                                   <th>Property</th>
                                   <th>Plot Type</th>
                                   <th>Plot No.</th>
                                   <th>Area</th>
                                   <th>Plan</th>
                                   <th>Current Rate</th>
                                   <th>Amount</th>
                                   <th>Discount</th>
                                   <th>Deposit Amount</th>
                                   <th>Rest Amount</th>
                                   <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                  <?php 
                                  if(count($downlines) > 0){
                                      $i=1;
                                      foreach($downlines as $downline){
                                          $currentPlan = $currentRatesTable->getCurrentPlanById($downline->AssignPlots['plan']);

                                          $rest_amount = $downline->AssignPlots['grand_total'] - ($downline->AssignPlots['discount'] + $downline->total_paid_payment);
                                      ?>
                                          <tr class="gradeX">
                                              <td><?php echo $i; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo date('F j, Y, g:i a', strtotime($downline->AssignPlots['created'])); ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->Users['username']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->Details['first_name'].' '.$downline->Details['last_name']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->Details['contact_no']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->Properties['title']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->Plots['name']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $downline->AssignPlots['plot_number']; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;">
                                                Area In Sqft : <strong><?php echo $downline->AssignPlots['area']; ?></strong>
                                                <br> Area In Sqyd : <strong><?php echo number_format($downline->AssignPlots['area']/9, 2); ?></strong>
                                              </td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo $currentPlan; ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo number_format($downline->AssignPlots['current_rate'], 2); ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo number_format($downline->AssignPlots['grand_total'], 2); ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo number_format($downline->AssignPlots['discount'], 2); ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo number_format($downline->total_paid_payment, 2); ?></td>
                                              <td style="vertical-align: top; white-space: nowrap;"><?php echo number_format($rest_amount, 2); ?></td>
                                              <td>
                                                <div class="btn-group">
                                                  <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                                  </button>
                                                  <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                    
                                                    <li>
                                                      <a href="<?php echo $home_url; ?>/plot/assigned-plot-details/<?php echo $downline->AssignPlots['id']; ?>">Details</a> 
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