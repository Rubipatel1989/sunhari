<?php
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Achieved Rewards
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               
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
                                    <th>Sr. No.</th>
                                    <th>User Info.</th>
                                    <th>Reward Title</th>
                                    <th>Direct Users</th>
                                    <th>Matching Users</th>
                                    <th>Reward</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($achievedRewards)){
                                  $i=1;
                                  foreach($achievedRewards as $achievedRewar){
                                    $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $achievedRewar->id)))->count();
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td style="white-space: nowrap;">
                                        Username : <strong><?php echo $achievedRewar->Users['username']; ?></strong>
                                        <br>Name : <strong><?php echo $achievedRewar->Details['first_name'].' '.$achievedRewar->Details['last_name']; ?></strong>  
                                      </td>
                                      <td style="white-space: nowrap;"><?php echo $achievedRewar->Rewards['title']; ?></td>

                                      <td style="white-space: nowrap;"><?php echo number_format($achievedRewar->direct_users, 2); ?></td>

                                      <td style="white-space: nowrap;"><?php echo number_format($achievedRewar->matching_users, 2); ?></td>
                                      <td style="white-space: nowrap;">
                                        <?php echo $achievedRewar->reward; ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo number_format($achievedRewar->amount, 2); ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                       <?php echo date("j F Y", strtotime($achievedRewar->start_date)); ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php echo date("j F Y", strtotime($achievedRewar->end_date)); ?>
                                      </td>

                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Pending';
                                        if($achievedRewar->status == 2){
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
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/users/achieved-reward-status/<?php echo base64_encode($achievedRewar->id); ?>/<?php echo base64_encode(1); ?>">Pending</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/users/achieved-reward-status/<?php echo base64_encode($achievedRewar->id); ?>/<?php echo base64_encode(2); ?>">Paid</a> 
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