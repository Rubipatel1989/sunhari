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
               <a href="<?php echo $backend_url ?>/user/upgrade"><i class="fa fa-plus"></i> Upgrade User</a>
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
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>DOB</th>
                                    <th>Gender</th>
                                    <th>PAN Number</th>
                                    <th>Contact Number</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Address</th>
                                    <th>Account No</th> 
                                    <th>IFSC Code</th>
                                    <th>Nominee Name</th>
                                    <th>Relationship</th>
                                    <th style="text-align: center;">Total Upgrade</th>
                                    <th>Is Block</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($users)){
                                  $i=1;
                                  foreach($users as $user){
                                    $totalUpgraded = $upgradesTable->find('all', array('conditions' => array('Upgrades.upgraded_id' => $user->id)))->count();
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td style="white-space: nowrap;"><?php echo $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')'; ?></td>
                                      <td><?php echo $user->Details['first_name'].' '.$user->Details['last_name']; ?></td>
                                      <td><?php echo $user->Details['father_name']; ?></td>
                                      <td style="white-space: nowrap;"><?php echo $user->Details['dob']; ?></td>
                                      <td>
                                        <?php
                                        if ($user->Details['gender'] == 'male') {
                                         echo 'Male'; 
                                        } elseif ($user->Details['gender'] == 'Female') {
                                          echo 'Female'; 
                                        } else {
                                          echo 'NA'; 
                                        }
                                        ?>
                                      </td>
                                      <td style="white-space: nowrap;">
                                        <?php 
                                        if(!empty($user->Details['pan_number'])){
                                           echo $user->Details['pan_number']; 
                                        }else{
                                           echo 'N/A';
                                        }
                                        ?>
                                      </td>
                                      <td>
                                        <?php echo $user->Details['contact_no']; ?>
                                      </td>

                                      <td>
                                        <?php echo $user->Details['city_name']; ?>
                                      </td>
                                      <td>
                                        <?php echo $user->States['name']; ?>
                                      </td>
                                      <td>
                                        <?php echo $user->Details['address']; ?>
                                      </td>


                                      <td>
                                        <?php 
                                       if(!empty($user->Details['account_number'])){
                                         echo $user->Details['account_number']; 
                                       }else{
                                         echo 'N/A';
                                       }
                                      ?>
                                      </td>
                                      <td><?php  echo $user->Details['ifsc_code']; ?></td>
                                      <td><?php  echo $user->Details['nominee_name']; ?></td>
                                      <td><?php  echo $user->Details['relationship']; ?></td>
                                      <td style="text-align: center;">
                                        <?php echo $totalUpgraded; ?>
                                      </td>
                                      <td>
                                        <?php 
                                        $block_txt = 'No';
                                        $block_cls = 'active-staus';
                                        if($user->is_blocked == 1){
                                          $block_txt = 'Yes';
                                          $block_cls = 'inactive-staus';
                                        }
                                        ?>
                                         <div class="whitetext-1 <?php echo $block_cls; ?>"><?php echo $block_txt; ?></div>
                                      </td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($user->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/view-user/<?php echo base64_encode($user->id); ?>" target="_blank">View</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/upgrade/<?php echo $user->id; ?>">Upgrade</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/edit-account/<?php echo $user->id; ?>">Change Password</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/edit-profile/<?php echo $user->id; ?>">Edit Profile</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/user/kyc/<?php echo $user->id; ?>">KYC</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/users/block/<?php echo $user->id; ?>">Block</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/users/unblock/<?php echo $user->id; ?>">Unblock</a> 
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