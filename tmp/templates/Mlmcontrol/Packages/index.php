<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Packages
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/packages/add"><i class="fa fa-plus"></i> Add Package</a>
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
                                    <th  class="nowrap">Sr. No.</th>
                                    <th>Name</th>
                                    <th>B.V.</th>
                                    <th>Amount</th>
                                    <th class="nowrap">Direct Value</th>
                                    <th class="nowrap">PPI Value</th>
                                    <th class="nowrap">Business Point</th>
                                    <th class="nowrap">Booster Time</th>
                                    <th class="nowrap">Booster Amount</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($packages)){
                                  $i=1;
                                  foreach($packages as $package){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $package->name; ?></td>
                                      <td><?php echo number_format($package->package_bv, 2); ?></td>
                                      <td><?php echo number_format($package->package_amount, 2); ?></td>
                                      <td><?php echo number_format($package->direct_amount, 2); ?></td>
                                      <td><?php echo number_format($package->roi_amount, 2); ?></td>
                                      
                                      <td><?php echo $package->business_point ? $package->business_point : 'N/A'; ?></td>
                                      <td><?php echo number_format($package->booster_time); ?></td>
                                      <td><?php echo number_format($package->booster_amount, 2); ?></td>

                                      <td><?php echo $package->position; ?></td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($package->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li><a href="<?php echo $backend_url; ?>/packages/edit/<?php echo $package->id; ?>">Edit</a> 
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/1">Active</a>
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/0">Inactive</a>
                                             </li>
                                             <li><a onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/packages/delete/<?php echo $package->id; ?>">Delete</a>
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