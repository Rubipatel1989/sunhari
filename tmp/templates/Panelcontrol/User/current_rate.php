<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Plots</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Plots
                    </h2>
                     <a href="<?php echo $backend_url ?>/user/add-current-rate" class="float-right margin-right-15"><i class="fa fa-plus"></i> Add Current Rate</a>
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
                                    <th>Created On</th>
                                    <th>Plan</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($currentRates)){
                                  $i=1;
                                  foreach($currentRates as $currentRate){
                                    $currentPlan = $currentRatesTable->getCurrentPlanById($currentRate->plan);
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($currentRate->created)); ?></td>
                                      <td><?php echo $currentPlan; ?></td>
                                      <td><?php echo number_format($currentRate->rate, 2); ?></td>
                                      <td>
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($currentRate->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td><?php echo html_entity_decode($currentRate->remark); ?></td>
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