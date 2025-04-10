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
               <a href="<?php echo $backend_url ?>/roles/add"><i class="fa fa-plus"></i> Add Role</a>
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
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($roles)){
                                  $i=1;
                                  foreach($roles as $role){
                                  ?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td style="white-space: nowrap; vertical-align: top;"><?php echo date("d-m-Y g:i a", strtotime($role->created)); ?></td>
                                      <td style="white-space: nowrap; vertical-align: top;"><?php echo $role->title; ?></td>
                                      <td style="padding-left: 15px; vertical-align: top;">
                                        <div class="permission-list-container">
                                          <ul class="permission-list">
                                            <?php
                                            if($role->Permissions['is_permission']){
                                            ?>
                                              <li>
                                                <strong>Permissions</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_permission']){
                                                  ?>
                                                    <li>Role</li>
                                                  <?php
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_staff']){
                                            ?>
                                              <li>
                                                <strong>Team/People</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_staff']){
                                                  ?>
                                                    <li>Staff</li>
                                                  <?php
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_package']){
                                            ?>
                                              <li>
                                                <strong>Add Stuffs</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_package']){
                                                  ?>
                                                    <li>Add Package</li>
                                                  <?php
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_properties'] || $role->Permissions['is_sites'] || $role->Permissions['is_blocks'] || $role->Permissions['is_plots'] || $role->Permissions['is_current_rate'] || $role->Permissions['is_assign_plot'] || $role->Permissions['is_assigned_plots'] || $role->Permissions['is_plot_payment'] || $role->Permissions['is_plot_payment_list'] || $role->Permissions['is_assigned_unit_list']){
                                            ?>
                                              <li>
                                                <strong>Property</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_properties']){
                                                  ?>
                                                    <li>Properties</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_sites']){
                                                  ?>
                                                    <li>Sites</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_blocks']){
                                                  ?>
                                                   <li>Blocks</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_plots']){
                                                  ?>
                                                   <li>Plots</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_current_rate']){
                                                  ?>
                                                   <li>Current Rate</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_assign_plot']){
                                                  ?>
                                                   <li>Assign Plot</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_assigned_plots']){
                                                  ?>
                                                   <li>Assigned Plots</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_plot_payment']){
                                                  ?>
                                                   <li>Plot Payment</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_plot_payment_list']){
                                                  ?>
                                                   <li>Plot Payment List</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_assigned_unit_list']){
                                                  ?>
                                                   <li>Assigned Unit List</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_generate_pins'] || $role->Permissions['is_epin_list'] || $role->Permissions['is_unused_epins'] || $role->Permissions['is_used_pins'] || $role->Permissions['is_transferred_pins']){
                                            ?>
                                              <li>
                                                <strong>E-Pins</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_generate_pins']){
                                                  ?>
                                                    <li>Generate Pins</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_epin_list']){
                                                  ?>
                                                    <li>Epin List</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_unused_epins']){
                                                  ?>
                                                    <li>Unused Epins</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_used_pins']){
                                                  ?>
                                                    <li>Used Pins</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_transferred_pins']){
                                                  ?>
                                                    <li>Transferred Pins</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_new_registration'] || $role->Permissions['is_upgrade_user'] || $role->Permissions['is_degrade_user'] || $role->Permissions['is_user_emi'] || $role->Permissions['is_user_list']){
                                            ?>
                                              <li>
                                                <strong>Users</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_new_registration']){
                                                  ?>
                                                    <li>New Registration</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_upgrade_user']){
                                                  ?>
                                                    <li>Upgrade User</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_degrade_user']){
                                                  ?>
                                                    <li>Degrade User</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_user_emi']){
                                                  ?>
                                                    <li>User EMI</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_user_list']){
                                                  ?>
                                                    <li>User List</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_direct_reward'] || $role->Permissions['is_pair_reward']){
                                            ?>
                                              <li>
                                                <strong>Reward</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_direct_reward']){
                                                  ?>
                                                    <li>Direct Reward</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_pair_reward']){
                                                  ?>
                                                    <li>Pair Reward</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_direct_network'] || $role->Permissions['is_network'] || $role->Permissions['is_direct_referral'] || $role->Permissions['is_downline_report'] || $role->Permissions['is_post_report'] || $role->Permissions['is_current_business']){
                                            ?>
                                              <li>
                                                <strong>Team</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_direct_network']){
                                                  ?>
                                                    <li>Direct Network</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_network']){
                                                  ?>
                                                    <li>Network</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_direct_referral']){
                                                  ?>
                                                    <li>Direct Referral</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_downline_report']){
                                                  ?>
                                                    <li>Downline Report</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_post_report']){
                                                  ?>
                                                    <li>Post Report</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_current_business']){
                                                  ?>
                                                    <li>Current Business</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_run_cron'] || $role->Permissions['is_post_incomes'] || $role->Permissions['is_saved_post_incomes'] || $role->Permissions['is_payment_closing'] || $role->Permissions['is_id_wise_closing'] || $role->Permissions['is_closing_details']){
                                            ?>
                                              <li>
                                                <strong>Payments</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_run_cron']){
                                                  ?>
                                                    <li>Run Cron</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_post_incomes']){
                                                  ?>
                                                    <li>Post Incomes</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_saved_post_incomes']){
                                                  ?>
                                                    <li>Saved Post Incomes</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_payment_closing']){
                                                  ?>
                                                    <li>Payment Closing</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_id_wise_closing']){
                                                  ?>
                                                    <li>Id Wise Closing</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_closing_details']){
                                                  ?>
                                                    <li>Closing Details</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_pending_plot_payment'] || $role->Permissions['is_incoming_income'] || $role->Permissions['is_outgoing_income'] || $role->Permissions['is_total_payout_report']){
                                            ?>
                                              <li>
                                                <strong>Reports</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_pending_plot_payment']){
                                                  ?>
                                                    <li>Pending Plot Payment</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_incoming_income']){
                                                  ?>
                                                    <li>Incoming Income</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_outgoing_income']){
                                                  ?>
                                                    <li>Outgoing Income</li>
                                                  <?php 
                                                  }?>
                                                  <?php
                                                  if($role->Permissions['is_total_payout_report']){
                                                  ?>
                                                    <li>Total Payout Report</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_tickets']){
                                            ?>
                                              <li>
                                                <strong>Support</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_tickets']){
                                                  ?>
                                                    <li>Tickets</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_tax_and_comission']){
                                            ?>
                                              <li>
                                                <strong>Settings</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_tax_and_comission']){
                                                  ?>
                                                    <li>Tax & Comission</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                            <?php
                                            if($role->Permissions['is_account_password']){
                                            ?>
                                              <li>
                                                <strong>Change Password</strong>
                                                <ul>
                                                  <?php
                                                  if($role->Permissions['is_account_password']){
                                                  ?>
                                                    <li>Account Password</li>
                                                  <?php 
                                                  }?>
                                                </ul>
                                              </li>
                                            <?php
                                            }?>
                                          </ul>
                                        </li>
                                      </td>
                                      <td style="vertical-align: top;">
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/roles/edit/<?php echo base64_encode($role->id); ?>">Edit</a> 
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