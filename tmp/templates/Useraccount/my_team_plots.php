<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $home_url; ?>/my-account">Dashboard</a></li>
        <li class="breadcrumb-item active">My Team Plots</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      My Team Plots
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
                                                      <a class="dropdown-item" href="<?php echo $home_url; ?>/plot/assigned-plot-details/<?php echo $downline->AssignPlots['id']; ?>">Details</a> 
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
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>