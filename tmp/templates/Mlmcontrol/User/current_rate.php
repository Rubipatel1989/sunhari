<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$currentRatesTable  = TableRegistry::get('CurrentRates');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Current Rate
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/user/add-current-rate"><i class="fa fa-plus"></i> Add Current Rate</a>
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
</div>