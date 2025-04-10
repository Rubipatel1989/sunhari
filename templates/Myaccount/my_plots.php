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
  My Plots
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
                            <div class="col-xs-12 nopadding">
                              <table id="packages" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Plot No</th>
                                      <th style="white-space: nowrap;">Property</th>
                                      <th style="white-space: nowrap;">Site</th>
                                      <th style="white-space: nowrap;">Block</th>
                                      <th style="white-space: nowrap;">Amount</th>
                                      <th style="white-space: nowrap;">Discount</th>
                                      <th style="white-space: nowrap;">Total Deposit</th>
                                      <th style="white-space: nowrap;">Rest Amount</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($assignPlots)){
                                      $i=1;
                                      foreach($assignPlots as $assignPlot){?>
                                        <tr class="gradeX">
                                          <td><?php echo $i; ?></td>
                                          <td>
                                            <?php echo $assignPlot->plot_number; ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo $assignPlot->Properties['title']; ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo $assignPlot->Sites['title']; ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo $assignPlot->Blocks['title']; ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo number_format($assignPlot->grand_total, 2); ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo number_format($assignPlot->discount, 2); ?>
                                          </td>
                                          <td style="white-space: nowrap;">
                                            <?php echo number_format($assignPlot->total_paid_payment, 2); ?>
                                          </td>
                                           <td style="white-space: nowrap;">
                                            <?php echo number_format(($assignPlot->grand_total - ($assignPlot->total_paid_payment + $assignPlot->discount)), 2); ?>
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