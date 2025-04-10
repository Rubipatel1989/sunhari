<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($closings);
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Saved Post Incomes
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
                        <form name="bulk-payment-closing-form" id="bulk-payment-closing-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                          <div class="col-xs-12 nopadding table-cotainer">
                          
                            <div class="col-xs-12 nopadding">
                              <table id="payments_closing" class="table table-striped table-hover">
                                 <thead>
                                    <tr>
                                      <th style="white-space: nowrap;">Sr. No.</th>
                                      <th style="white-space: nowrap;">Total Upgrades</th>
                                      <th style="white-space: nowrap;">Gold</th>
                                      <th style="white-space: nowrap;">Platinum</th>
                                      <th style="white-space: nowrap;">Ambrand</th>
                                      <th style="white-space: nowrap;">Diamond</th>
                                      <th style="white-space: nowrap;">King</th>
                                      <th style="white-space: nowrap;">Status</th>
                                      <th style="white-space: nowrap;">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if(!empty($postIncomes)){
                                      $i=1;
                                      foreach($postIncomes as $postIncome){
                                      ?>
                                        <tr class="gradeX">
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $postIncome->number_of_upgraded_users; ?></td>
                                          <td><?php echo number_format($postIncome->gold, 2); ?></td>
                                          <td><?php echo number_format($postIncome->platinum, 2); ?></td>
                                          <td><?php echo number_format($postIncome->ambrand, 2); ?></td>
                                          <td><?php echo number_format($postIncome->diamond, 2); ?></td>
                                          <td><?php echo number_format($postIncome->king, 2); ?></td>
                                          <td>
                                            <?php
                                            $status_cls = 'inactive-staus';
                                            $status_txt = 'Pending';
                                            if($postIncome->status == 1){
                                              $status_cls = 'active-staus';
                                              $status_txt = 'Paid';
                                            }?>
                                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                              </button>
                                              <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                                <?php
                                                if(empty($postIncome->status)){?>
                                                  <li>
                                                    <a href="<?php echo $backend_url; ?>/payments/pay-post-income/<?php echo $postIncome->id; ?>">Pay</a>
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
                        </form>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>