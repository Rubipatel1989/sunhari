<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add Role
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
                         <div class="col-xs-12 nopadding">
                          <form name="add_role"  id="add_role" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Role Details</legend>
                              
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Title<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php
                                      echo $this->Form->input('Role.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>

                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Permissions<span class="red">*</span></label>
                                   <div class="col-sm-8">
                                      <div class="permission-list-container">
                                        <ul class="permission-list">
                                          <li>
                                            <strong>Permissions</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_permission', array('type' => 'checkbox', 'label' => 'Role', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Team/People</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_staff', array('type' => 'checkbox', 'label' => 'Staff', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Add Stuffs</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_package', array('type' => 'checkbox', 'label' => 'Add Package', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Property</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_properties', array('type' => 'checkbox', 'label' => 'Properties', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_sites', array('type' => 'checkbox', 'label' => 'Sites', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_blocks', array('type' => 'checkbox', 'label' => 'Plots', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_current_rate', array('type' => 'checkbox', 'label' => 'Current Rate', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_assign_plot', array('type' => 'checkbox', 'label' => 'Assign Plot', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_assigned_plots', array('type' => 'checkbox', 'label' => 'Assigned Plots', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_plot_payment', array('type' => 'checkbox', 'label' => 'Plot Payment', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_plot_payment_list', array('type' => 'checkbox', 'label' => 'Plot Payment List', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_assigned_unit_list', array('type' => 'checkbox', 'label' => 'Assigned Unit List', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>E-Pins</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_generate_pins', array('type' => 'checkbox', 'label' => 'Generate Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_epin_list', array('type' => 'checkbox', 'label' => 'Epin List', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_unused_epins', array('type' => 'checkbox', 'label' => 'Unused Epins', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_used_pins', array('type' => 'checkbox', 'label' => 'Used Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_transferred_pins', array('type' => 'checkbox', 'label' => 'Transferred Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Users</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_new_registration', array('type' => 'checkbox', 'label' => 'New Registration', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_upgrade_history', array('type' => 'checkbox', 'label' => 'Upgrade History', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_upgrade_user', array('type' => 'checkbox', 'label' => 'Upgrade User', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_degrade_user', array('type' => 'checkbox', 'label' => 'Degrade User', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_user_emi', array('type' => 'checkbox', 'label' => 'User EMI', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_user_list', array('type' => 'checkbox', 'label' => 'User List', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Reward</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_direct_reward', array('type' => 'checkbox', 'label' => 'Direct Reward', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_pair_reward', array('type' => 'checkbox', 'label' => 'Pair Reward', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Team</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_direct_network', array('type' => 'checkbox', 'label' => 'Direct Network', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_network', array('type' => 'checkbox', 'label' => 'Network', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_direct_referral', array('type' => 'checkbox', 'label' => 'Direct Referral', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_downline_report', array('type' => 'checkbox', 'label' => 'Downline Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_post_report', array('type' => 'checkbox', 'label' => 'Post Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_current_business', array('type' => 'checkbox', 'label' => 'Current Business', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Payments</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_run_cron', array('type' => 'checkbox', 'label' => 'Run Cron', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_post_incomes', array('type' => 'checkbox', 'label' => 'Post Incomes', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_saved_post_incomes', array('type' => 'checkbox', 'label' => 'Saved Post Incomes', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>

                                              <li><?php echo $this->Form->input('Permission.is_payment_closing', array('type' => 'checkbox', 'label' => 'Payment Closing', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_id_wise_closing', array('type' => 'checkbox', 'label' => 'Id Wise Closing', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_closing_details', array('type' => 'checkbox', 'label' => 'Closing Details', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Reports</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_pending_plot_payment', array('type' => 'checkbox', 'label' => 'Pending Plot Payment', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_incoming_income', array('type' => 'checkbox', 'label' => 'Incoming Income', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_outgoing_income', array('type' => 'checkbox', 'label' => 'Outgoing Income', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                              <li><?php echo $this->Form->input('Permission.is_total_payout_report', array('type' => 'checkbox', 'label' => 'Total Payout Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Support</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_tickets', array('type' => 'checkbox', 'label' => 'Tickets', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Settings</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_tax_and_comission', array('type' => 'checkbox', 'label' => 'Tax & Comission', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                          <li>
                                            <strong>Change Password</strong>
                                            <ul>
                                              <li><?php echo $this->Form->input('Permission.is_account_password', array('type' => 'checkbox', 'label' => 'Account Password', 'div' => false, 'class' => 'permission-csk', 'value' => '1'));?></li>
                                            </ul>
                                          </li>
                                        </ul>
                                      </div>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/roles" class="btn btn-square btn-danger">Cancel</a>
                                  </div>
                                </div>
                              </fieldset>
                          </form>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>