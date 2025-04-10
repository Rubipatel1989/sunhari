<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Plots
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
              <a href="<?php echo $backend_url ?>/projects/add-plot"><i class="fa fa-plus"></i> Add New Plot</a>
              &nbsp; <a href="<?php echo $backend_url ?>/projects/add-multiple-plots"><i class="fa fa-plus"></i> Add Multiple Plots </a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Property</th>
                                  <th>Site</th>
                                  <th>Block</th>
                                  <th>Property Type</th>
                                  <th>Plot Number</th>
                                  <th>Area</th>
                                  <th>PLC</th>
                                  <th>Remark</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($plots)){
                                  $i=1;
                                  foreach($plots as $plot){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Properties['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Sites['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->Blocks['title']; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->name; ?></td>
                                      <td style="vertical-align: top;"><?php echo $plot->plot_number; ?></td>
                                      <td style="vertical-align: top; white-space: nowrap;">
                                        Area In Sqyd : <strong><?php echo $plot->area; ?></strong>
                                       <!--  <br> Area In Sqyd : <strong><?php echo number_format($plot->area/9, 2); ?></strong> -->
                                      </td>
                                      <td style="vertical-align: top;"><?php echo $plot->plc; ?></td>
                                      <td style="vertical-align: top;"><?php if(!empty($plot->remark)){echo $plot->remark;}else{echo 'N/A';}; ?></td>
                                      <td style="vertical-align: top;">
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($plot->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Available';
                                        }
                                        elseif($plot->status == 2){
                                          $status_cls = 'sold-staus';
                                          $status_txt = 'Sold';
                                        }
                                        elseif($plot->status == 3){
                                          $status_cls = 'onhold-staus';
                                          $status_txt = 'On Hold';
                                        }
                                        ?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/projects/edit-plot/<?php echo base64_encode($plot->id); ?>">Edit</a> 
                                            </li>
                                            <?php
                                            if($plot->status != 2){
                                            ?>
                                              <li>
                                                <a href="<?php echo $backend_url; ?>/projects/change-plot-status/<?php echo base64_encode(1); ?>/<?php echo base64_encode($plot->id); ?>">Available</a> 
                                              </li>
                                              <li>
                                                <a href="<?php echo $backend_url; ?>/projects/change-plot-status/<?php echo base64_encode(0); ?>/<?php echo base64_encode($plot->id); ?>">Inactive</a> 
                                              </li>
                                              <li>
                                                <a class="fancybox onhold-link" href="#reason-popup" data-action="<?php echo $backend_url; ?>/projects/change-plot-status/<?php echo base64_encode(3); ?>/<?php echo base64_encode($plot->id); ?>">On-hold</a> 
                                              </li>
                                            <?php
                                            }?>
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

<div id="reason-popup" style="min-width: 400px; display: none;">
  <div class="col-xs-12 nopadding">
    <form name="status-reason-form" id="status_reason_form" action="" method="post">
      <div class="col-xs-12 nopadding">
        <h3 class="heading-title-1">Remark</h3>
      </div>
      <div class="col-xs-12 nopadding margin-top-20" style="height: 120px;">
        <?php 
        echo $this->Form->input('Plot.remark', array('type' => 'textarea', 'id' => 'discount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Reason for On-Hold', 'style' => '100px')); 
         ?>
      </div>
      <div class="col-xs-12 nopadding margin-top-20 text-center">
        <button type="submit" class="btn btn-square btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>