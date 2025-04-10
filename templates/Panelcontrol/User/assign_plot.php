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
                     <?php echo $this->Form->create(NULL, array('id' => 'assign_plot_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">User<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select User-'];
                                      foreach($users as $user){
                                        $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                      }
                                      echo $this->Form->input('AssignPlot.user_id', array('type' => 'select', 'id' => 'single-default', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Property<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Property-'];
                                      foreach($properties as $property){
                                        $options[$property->id] = $property->title;
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('AssignPlot.property_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterSiteByProperty(this.value, "site_container", "AssignPlot.site_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Site<span class="red">*</span></label>
                                   <div id="site_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Site-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('AssignPlot.site_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterBlockBySite(this.value, "block_container", "AssignPlot.block_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Block<span class="red">*</span></label>
                                   <div id="block_container" data-plot-filter="yes" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Block-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('AssignPlot.block_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterPlotsByBlock(this, "plot_container", "AssignPlot.plot_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              
                              <fieldset>
                                <div class="row margin-top-25">
                                   <label class="col-sm-2 text-right">Plot No.<span class="red">*</span></label>
                                   <div id="plot_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Plot No-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('AssignPlot.plot_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'getPlotDetails(this);')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <div id="plot_fields_container">

                              </div>
                              <div id="plot_calculation_container" style="display: none;">
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Plan<span class="red">*</span></label>
                                     <div class="col-sm-4 height-37">
                                        <?php 
                                        $options = ['' => '-Select Plan-', '1' => 'Plan One' , '2' => 'Plan Two'];
                                        echo $this->Form->input('AssignPlot.plan', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options, 'onchange' => 'getCurrentRateByPlan(this);'));
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Current Rate</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.current_rate', array('type' => 'text', 'id' => 'current_rate', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Total Amount</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.total_amount', array('type' => 'text', 'id' => 'total_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">PLC Amount</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.plc_amount', array('type' => 'text', 'id' => 'plc_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Grand Total</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.grand_total', array('type' => 'text', 'id' => 'grand_total', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Discount (Fixed)</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.discount', array('type' => 'text', 'id' => 'discount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="row margin-top-25">
                                     <label class="col-sm-2 text-right">Remark</label>
                                     <div id="plot_container" class="col-sm-8" style="height: 100px;">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.remark', array('type' => 'textarea', 'id' => 'discount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'style' => '100px')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                              <fieldset>
                                <div class="row margin-top-25">
                                  <label class="col-sm-2 text-right"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/AssignPlots" class="btn btn-square btn-danger">Cancel</a>
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