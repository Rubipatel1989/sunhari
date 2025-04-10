<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">User List</li>
    </ol>
    <div class="row">
        <div class="col">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      User List
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="col-sm-12 nopadding">
                        <?php echo $this->Flash->render(); ?>
                      </div>
                      <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                        <div class="row nopadding table-cotainer">
                          <table id="payments_closing" class="table table-bordered table-hover table-striped w-100">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Username</th>
                                    <th>Epin</th>
                                    <th>Rank</th>
                                    <th style="white-space: nowrap;">Plot Unit</th>
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
                                      <td><?php echo $user->Epins['epin']; ?></td>
                                      <td><?php echo $user->rank; ?></td>
                                      <td><?php if(!empty($user->PlotPayments['number_of_unit'])){echo number_format($user->PlotPayments['number_of_unit']);}else{echo 'N/A';} ?></td>
                                      <td style="white-space: nowrap;"><?php echo $user->Details['first_name'].' '.$user->Details['last_name']; ?></td>
                                      <td><?php echo $user->Details['father_name']; ?></td>
                                      <td style="white-space: nowrap;"><?php echo $user->Details['dob']; ?></td>
                                      <td>
                                        <?php
                                        if($user->Details['gender'] == 'male'){
                                         echo 'Male'; 
                                        }else{
                                          echo 'Female'; 
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
                                          <button class="btn btn-outline-secondary dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              -Select-
                                          </button>
                                          <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/view-user/<?php echo base64_encode($user->id); ?>" target="_blank">View</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/upgrade/<?php echo $user->id; ?>">Upgrade</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/edit-account/<?php echo $user->id; ?>">Change Password</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/edit-profile/<?php echo $user->id; ?>">Edit Profile</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/user/kyc/<?php echo $user->id; ?>">KYC</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/users/block/<?php echo $user->id; ?>">Block</a> 
                                            <a class="dropdown-item" href="<?php echo $backend_url; ?>/users/unblock/<?php echo $user->id; ?>">Unblock</a>
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
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>