<?php
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Users
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
              <!-- <a href="<?php echo $home_url ?>/my-account/manage-users/upgrade-user"><i class="fa fa-plus"></i> Upgrade User</a> -->
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
                                    <th>Registered On</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <!-- <th style="text-align: center;">Total Upgrade</th> -->
                                    <th>Left Business</th>
                                    <th>Right Business</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($downlines)){
                                  $i=1;
                                  foreach($downlines as $downline){
                                    $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $downline->Users['id'])))->count();
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($downline->created)); ?></td>
                                      <td><?php echo $downline->Users['username']; ?></td>
                                      <td><?php echo $downline->Details['first_name'].' '.$downline->Details['last_name']; ?></td>
                                      <td><?php echo $downline->Users['total_active_left']; ?></td>
                                      <td><?php echo $downline->Users['total_active_right']; ?></td>
                                      <!-- <td style="text-align: center;">
                                        <?php //echo $totalUpgraded; ?>
                                      </td> -->
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($downline->Users['status'] == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <!-- <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li>
                                              <a href="<?php echo $home_url; ?>/my-account/manage-users/upgrade-user/<?php echo $downline->Users['id']; ?>">Upgrade</a> 
                                             </li>
                                          </ul>
                                       </div>
                                      </td> -->
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