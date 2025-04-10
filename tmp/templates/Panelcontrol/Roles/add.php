<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Role</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                      Role Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       
                       <?php echo $this->Form->create(NULL, array('id' => 'add_role', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Title<span class="red">*</span></label>
                               <div class="col-sm-8 height-37">
                                  <?php
                                  echo $this->Form->input('Role.title', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Title')); 
                                  ?>
                               </div>
                            </div>
                          </fieldset>

                          <fieldset>
                            <div class="row margin-top-25">
                               <label class="col-sm-2 text-right">Permissions<span class="red">*</span></label>
                               <div class="col-sm-8">
                                  <div class="permission-list-container">
                                    <ul class="permission-list">
                                      <li>
                                        <strong>Permissions</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_permission', array('type' => 'checkbox', 'label' => 'Role', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Role</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Team/People</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_staff', array('type' => 'checkbox', 'label' => 'Staff', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Staff</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Add Stuffs</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_package', array('type' => 'checkbox', 'label' => 'Add Package', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Add Package</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Property</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_properties', array('type' => 'checkbox', 'label' => 'Properties', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Properties</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_sites', array('type' => 'checkbox', 'label' => 'Sites', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Sites</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_blocks', array('type' => 'checkbox', 'label' => 'Plots', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Plots</label> 
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_current_rate', array('type' => 'checkbox', 'label' => 'Current Rate', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Current Rate</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_assign_plot', array('type' => 'checkbox', 'label' => 'Assign Plot', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Assign Plot</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_assigned_plots', array('type' => 'checkbox', 'label' => 'Assigned Plots', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Assigned Plots</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_plot_payment', array('type' => 'checkbox', 'label' => 'Plot Payment', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Plot Payment</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_plot_payment_list', array('type' => 'checkbox', 'label' => 'Plot Payment List', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Plot Payment List</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_assigned_unit_list', array('type' => 'checkbox', 'label' => 'Assigned Unit List', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Assigned Unit List</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>E-Pins</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_generate_pins', array('type' => 'checkbox', 'label' => 'Generate Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Generate Pins</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_epin_list', array('type' => 'checkbox', 'label' => 'Epin List', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Epin List</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_unused_epins', array('type' => 'checkbox', 'label' => 'Unused Epins', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                             <label> Unused Epins</label> 
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_used_pins', array('type' => 'checkbox', 'label' => 'Used Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Used Pins</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_transferred_pins', array('type' => 'checkbox', 'label' => 'Transferred Pins', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Transferred Pins</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Users</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_new_registration', array('type' => 'checkbox', 'label' => 'New Registration', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> New Registration</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_upgrade_history', array('type' => 'checkbox', 'label' => 'Upgrade History', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Upgrade History</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_upgrade_user', array('type' => 'checkbox', 'label' => 'Upgrade User', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Upgrade User'</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_degrade_user', array('type' => 'checkbox', 'label' => 'Degrade User', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Degrade User</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_user_emi', array('type' => 'checkbox', 'label' => 'User EMI', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> User EMI</label> 
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_user_list', array('type' => 'checkbox', 'label' => 'User List', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> User List</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Reward</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_direct_reward', array('type' => 'checkbox', 'label' => 'Direct Reward', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Direct Reward</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_pair_reward', array('type' => 'checkbox', 'label' => 'Pair Reward', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Pair Reward</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Team</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_direct_network', array('type' => 'checkbox', 'label' => 'Direct Network', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                              <label> Direct Network</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_network', array('type' => 'checkbox', 'label' => 'Network', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Network</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_direct_referral', array('type' => 'checkbox', 'label' => 'Direct Referral', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Direct Referral</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_downline_report', array('type' => 'checkbox', 'label' => 'Downline Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Downline Report</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_post_report', array('type' => 'checkbox', 'label' => 'Post Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Post Report</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_current_business', array('type' => 'checkbox', 'label' => 'Current Business', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Current Business</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Payments</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_run_cron', array('type' => 'checkbox', 'label' => 'Run Cron', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Run Cron</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_post_incomes', array('type' => 'checkbox', 'label' => 'Post Incomes', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Post Incomes</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_saved_post_incomes', array('type' => 'checkbox', 'label' => 'Saved Post Incomes', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Saved Post Incomes</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_payment_closing', array('type' => 'checkbox', 'label' => 'Payment Closing', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Payment Closing</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_id_wise_closing', array('type' => 'checkbox', 'label' => 'Id Wise Closing', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Id Wise Closing</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_closing_details', array('type' => 'checkbox', 'label' => 'Closing Details', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Closing Details</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Reports</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_pending_plot_payment', array('type' => 'checkbox', 'label' => 'Pending Plot Payment', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Pending Plot Payment</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_incoming_income', array('type' => 'checkbox', 'label' => 'Incoming Income', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Incoming Income</label>
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_outgoing_income', array('type' => 'checkbox', 'label' => 'Outgoing Income', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Outgoing Income</label> 
                                          </li>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_total_payout_report', array('type' => 'checkbox', 'label' => 'Total Payout Report', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Total Payout Report</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Support</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_tickets', array('type' => 'checkbox', 'label' => 'Tickets', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Tickets</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Settings</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_tax_and_comission', array('type' => 'checkbox', 'label' => 'Tax & Comission', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Tax & Comission</label>
                                          </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <strong>Change Password</strong>
                                        <ul>
                                          <li>
                                            <?php echo $this->Form->input('Permission.is_account_password', array('type' => 'checkbox', 'label' => 'Account Password', 'div' => false, 'class' => 'permission-csk', 'value' => '1', 'checked' => 0));?>
                                            <label> Account Password</label>
                                          </li>
                                        </ul>
                                      </li>
                                    </ul>
                                  </div>
                               </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="row margin-top-25">
                              <label class="col-sm-2 text-right"></label>
                              <div class="col-sm-10">
                                  <button type="submit" name="btn_account_password" class="btn btn-square btn-primary">Submit</button> 
                                  &nbsp; <a href="<?php echo $backend_url ?>/roles" class="btn btn-square btn-danger">Cancel</a>
                              </div>
                            </div>
                          </fieldset>
                      <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>