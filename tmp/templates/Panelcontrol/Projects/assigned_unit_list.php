<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Assigned Unit List</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Assigned Unit List
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-xs-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <div class="row nopadding table-cotainer">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Paid On</th>
                                  <th>User</th>
                                  <th>Amount</th>
                                  <th style="white-space: nowrap;">Number of Unit</th>
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
                                      <td style="vertical-align: top;"><?php echo $plotPayment->Users['username'].' ('.$plotPayment->Details['first_name'].' '.$plotPayment->Details['last_name'].')' ?></td>
                                      <td style="vertical-align: top;"><?php echo number_format($plotPayment->amount, 2); ?></td>
                                      <td style="vertical-align: top;"><?php echo number_format($plotPayment->number_of_unit); ?></td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/edit-unit/<?php echo base64_encode($plotPayment->id); ?>">Edit Unit</a> 
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