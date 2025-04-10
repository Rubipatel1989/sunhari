<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Plot Payment</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Payament Details
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       <?php echo $this->Form->create(NULL, array('id' => 'plot_payment_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Username<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select User-'];
                                      foreach($users as $user){
                                        $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                      }
                                      echo $this->Form->input('PlotPayment.user_id', array('type' => 'select', 'id' => 'single-default', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'onchange' => 'return checkUserPayment(this);')); 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                             <!--  <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Plot<span class="red">*</span></label>
                                   <div id="plot_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Polt-'];
                                      echo $this->Form->input('PlotPayment.assign_plot_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <fieldset id="number_of_unit_container" style="display: none;">
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Number of Unit<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.number_of_unit', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of Unit')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Amount<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.amount', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Amount')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Payment Mode<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select-', 'Cheque' => 'Cheque', 'UPI' => 'UPI', 'Cash' => 'Cash'];
                                      echo $this->Form->input('PlotPayment.payment_mode', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return showPaymentsFields(this);')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <div id="cheque_container" class="payment-fields-container" style="display: none;">
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Bank<span class="red">*</span></label>
                                     <div id="block_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.bank', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Bank')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Cheque Number<span class="red">*</span></label>
                                     <div id="block_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.cheque_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Cheque Number')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                               <div id="upi_container" class="payment-fields-container" style="display: none;">
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Transaction ID<span class="red">*</span></label>
                                     <div class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('PlotPayment.transaction_id', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Transaction ID')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                              <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Date<span class="red">*</span></label>
                                     <div class="col-sm-4 height-37">
                                       <div class="input-group">
                                         <?php echo $this->Form->input('PlotPayment.amount_date', array('type' => 'text', 'id' => 'date_field', 'label' => false, 'div' => false, 'class' => 'form-control dob loginbox dob', 'readonly' => 'readonly', 'placeholder' => "Date")); ?>
                                         <div class="input-group-append">
                                             <span class="input-group-text fs-xl">
                                                 <i class="fal fa-calendar"></i>
                                             </span>
                                         </div>
                                       </div>
                                     </div>
                                  </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/plot-payment-list" class="btn btn-square btn-danger">Cancel</a>
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