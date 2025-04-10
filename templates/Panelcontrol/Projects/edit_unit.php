<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Assign Plot</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                       Assign Plot Details
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
                            <legend>Unit Details</legend>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">User<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      echo $plotPaymentInfo->Users['username'].' ('.$plotPaymentInfo->Details['first_name'].' '.$plotPaymentInfo->Details['last_name'].')';; 
                                      ?>
                                   </div>
                                </div>
                              </fieldset>
                               <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Amount<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo number_format($plotPaymentInfo->amount, 2); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset id="number_of_unit_container" >
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Number of Unit<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      echo $this->Form->input('PlotPayment.number_of_unit', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Number of Unit', 'value' => $plotPaymentInfo->number_of_unit)); 
                                       ?>
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