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
  My EMI
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
                        <div class="col-xs-6 nopadding">
                          <?php echo $this->Form->create(NULL, array('id' => 'search_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <div class="col-sm-6 nopadding">
                              <?php
                              $options[''] = '-Select Plot Number-';
                              foreach($assignPlots as $assignPlot){
                                $options[$assignPlot->id] = $assignPlot->plot_number;
                              }
                              echo $this->Form->input('assignPlot.id', array('type' => 'select', 'id' => 'select_username', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title', 'options' => $options, 'data-live-search' => "true"));
                              ?>
                            </div>
                            <div class="col-sm-6 padding-left-10">
                              <button type="submit" class="btn btn-square btn-primary">Submit</button> &nbsp; <a href="<?php echo $backend_url ?>/plot/my-emi" class="btn btn-square btn-danger">Reset</a>
                            </div>
                          <?php echo $this->Form->end();?>
                        </div>
                        <div class="col-xs-6 nopadding text-right margin-top-5">
                          <?php
                          if(!empty($assignPlotDetails)){?>
                            Total Amount : <strong><?php echo number_format($assignPlotDetails->grand_total, 2);?></strong>,
                            Discount : <strong><?php echo number_format($assignPlotDetails->discount, 2);?></strong>,
                            &nbsp; Total Deposit : <strong><?php echo number_format($assignPlotDetails->total_paid_payment, 2);?></strong>,
                            &nbsp; Due Amount : <strong><?php echo number_format($assignPlotDetails->grand_total - ($assignPlotDetails->discount + $assignPlotDetails->total_paid_payment), 2);?></strong>
                          <?php
                          }?>
                        </div>
                        <?php
                        /*echo '<pre>';
                        print_r($assignPlotDetails);*/
                        if(!empty($assignPlotDetails)){?>
                          <div class="col-xs-12 nopadding margin-top-15" style="background-color: #cccccc87;padding: 7px 10px;">
                            <div class="col-sm-3 nopadding">
                              Plot No : <strong><?php echo $assignPlotDetails->plot_number; ?></strong>
                            </div>
                            <div class="col-sm-3 nopadding">
                              Property : <strong><?php echo $assignPlotDetails->Properties['title']; ?></strong>
                            </div>
                            <div class="col-sm-3 nopadding">
                              Site : <strong><?php echo $assignPlotDetails->Sites['title']; ?></strong>
                            </div>
                            <div class="col-sm-3 nopadding">
                              Block : <strong><?php echo $assignPlotDetails->Blocks['title']; ?></strong>
                            </div>
                          </div>
                        <?php
                        }?>
                        <div class="col-xs-12 nopadding table-cotainer margin-top-15">
                          <div class="col-xs-12 nopadding">
                            <table id="packages" class="table table-striped table-hover">
                               <thead>
                                  <tr>
                                    <th style="white-space: nowrap;">Sr. No.</th>
                                    <th style="white-space: nowrap;">Date</th>
                                    <th style="white-space: nowrap;">Amount</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  if(!empty($plotPayments)){
                                    $i=1;
                                    foreach($plotPayments as $plotPayment){?>
                                      <tr class="gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                          <?php echo date("j F, Y", strtotime($plotPayment->created)); ?>
                                        </td>
                                        <td style="white-space: nowrap;">
                                          <?php echo number_format($plotPayment->amount, 2); ?>
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