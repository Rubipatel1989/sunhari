<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   All Plans
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/properties/add-property"><i class="fa fa-plus"></i> Add New Plan</a>
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
                                  <th>Created On</th>
                                  <th>Name</th>
                                  <th>Property Area</th>
                                  <th>Amount</th>
                                  <th>Number of EMI</th>
                                  <th>EMI Details</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($properties)){
                                  $i=1;
                                  foreach($properties as $property){?>
                                    <tr class="gradeX">
                                      <td style="vertical-align: top;"><?php echo $i; ?></td>
                                      <td style="vertical-align: top;"><?php echo date("F j, Y, g:i a", strtotime($property->created)); ?></td>
                                      <td style="vertical-align: top;"><?php echo $property->name; ?></td>
                                      <td style="vertical-align: top;"><?php echo $property->property_area; ?></td>
                                      <td style="vertical-align: top;"><?php echo $property->number_of_emi; ?></td>
                                      <td style="vertical-align: top;">Rs <?php echo number_format($property->amount, 2); ?></td>
                                      <td style="vertical-align: top;" class="nowrap">
                                        <?php
                                        if(!empty($property->emis)){
                                          $j=1;
                                          foreach($property->emis as $emi){?>
                                            <strong class="text-18"><?php echo $j; ?> EMI:</strong>
                                            <br> EMI Amount : Rs <strong><?php echo number_format($emi->amount, 2); ?></strong>
                                            <br> Direct Amount : Rs <strong><?php echo number_format($emi->direct_amount, 2); ?></strong>
                                            <br> Matching Amount : Rs <strong><?php echo number_format($emi->matching_amount, 2); ?></strong>
                                            <br>
                                          <?php
                                              $j++;
                                          }
                                        }
                                        ?>
                                      </td>
                                      <td style="vertical-align: top;">
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($property->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/properties/edit-property/<?php echo base64_encode($property->id); ?>">Edit</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/properties/change-status/<?php echo base64_encode(1); ?>/<?php echo base64_encode($property->id); ?>">Active</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/properties/change-status/<?php echo base64_encode(0); ?>/<?php echo base64_encode($property->id); ?>">Inactive</a> 
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