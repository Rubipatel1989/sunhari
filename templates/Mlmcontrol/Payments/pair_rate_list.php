<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($payments);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
  Pair Rate List
</h3>
<div class="row">
  <div class="col-xs-12 padding-left-5 padding-right-5">
    <div class="col-xs-12 padding-left-10 padding-right-10">
      <div class="col-xs-12 nopadding ">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="col-xs-12 nopadding">
              <?php echo $this->Flash->render(); ?>
            </div>
            <div class="col-xs-12 nopadding table-cotainer">
              <div class="col-xs-12 nopadding margin-top-20">
                <table id="packages" class="table table-striped table-hover">
                   <thead>
                      <tr>
                        <th style="white-space: nowrap;">Sr. No.</th>
                        <th style="white-space: nowrap;">Date</th>
                        <th style="white-space: nowrap;">Total Upgraded Users</th>
                        <th style="white-space: nowrap;">Amount Per Id</th>
                        <th style="white-space: nowrap;">Total Amount</th>
                        <th style="white-space: nowrap;">Total Pair</th>
                        <th style="white-space: nowrap;">Pair Rate</th>
                        <th style="white-space: nowrap;">No. of EMI</th>
                        <th style="white-space: nowrap;">EMI Rate</th>
                        <th style="white-space: nowrap;">Status</th>
                      </tr>
                   </thead>
                   <tbody>
                      <?php
                      if(!empty($pairRates)){
                        $i=1;
                        foreach($pairRates as $pairRate){
                        ?>
                          <tr class="gradeX">
                            <td><?php echo $i; ?></td>
                            <td style="white-space: nowrap;">
                              <?php echo date("j F, Y", strtotime($pairRate->created)); ?>
                            </td>
                            <td><?php echo $pairRate->total_upgraded_users; ?></td>
                            <td><?php echo number_format($pairRate->amount_per_id, 2); ?></td>
                            <td><?php echo number_format($pairRate->total_amount, 2); ?></td>
                            <td><?php echo number_format($pairRate->total_pair, 2); ?></td>
                            <td><?php echo number_format($pairRate->pair_rate, 2); ?></td>
                            <td><?php echo $pairRate->no_of_emi; ?></td>
                            <td><?php echo number_format($pairRate->emi_rate, 2); ?></td>
                            <td>
                              <?php
                              $status_cls = 'inactive-staus';
                              $status_txt = 'Inactive';
                              if($pairRate->status == 1){
                                $status_cls = 'active-staus';
                                $status_txt = 'Active';
                              }?>
                              <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
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
</div>