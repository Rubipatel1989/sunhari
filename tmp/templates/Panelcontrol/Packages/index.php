<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Closing Details</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Closing Details
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <form name="search_closing_detais_form" id="search_closing_detais_form" method="get">
                        <div class="row nopadding table-cotainer">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
                                            <button class="btn btn-outline-secondary dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                -Select-
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/edit/<?php echo $package->id; ?>">Edit</a>
                                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/1">Active</a>
                                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/packages/update_status/<?php echo $package->id; ?>/0">Inactive</a>
                                                <a class="dropdown-item" onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/packages/delete/<?php echo $package->id; ?>">Delete</a>
                                            </div>
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
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>