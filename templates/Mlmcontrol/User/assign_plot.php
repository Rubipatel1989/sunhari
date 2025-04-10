<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Assign Plot
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
                          <form name="assign_plot_form"  id="assign_plot_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Assignment Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">User<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select User-'];
                                      foreach($users as $user){
                                        $options[$user->id] = $user->username.' ('.$user->Details['first_name'].' '.$user->Details['last_name'].')';
                                      }
                                      echo $this->Form->input('AssignPlot.user_id', array('type' => 'select', 'id' => 'select_username', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'data-live-search' => "true")); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Property<span class="red">*</span></label>
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
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Site<span class="red">*</span></label>
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
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Block<span class="red">*</span></label>
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
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plot No.<span class="red">*</span></label>
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
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Plan<span class="red">*</span></label>
                                     <div class="col-sm-4 height-37">
                                        <?php 
                                        $options = ['' => '-Select Plan-', '1' => 'Plan One' , '2' => 'Plan Two'];
                                        echo $this->Form->input('AssignPlot.plan', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'options' => $options, 'onchange' => 'getCurrentRateByPlan(this);'));
                                        ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Current Rate</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.current_rate', array('type' => 'text', 'id' => 'current_rate', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Total Amount</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.total_amount', array('type' => 'text', 'id' => 'total_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">PLC Amount</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.plc_amount', array('type' => 'text', 'id' => 'plc_amount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Grand Total</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.grand_total', array('type' => 'text', 'id' => 'grand_total', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'readonly' => 'readonly')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Discount (Fixed)</label>
                                     <div id="plot_container" class="col-sm-8 height-37">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.discount', array('type' => 'text', 'id' => 'discount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                                <fieldset>
                                  <div class="form-group">
                                     <label class="col-sm-2 control-label">Remark</label>
                                     <div id="plot_container" class="col-sm-8" style="height: 100px;">
                                        <?php 
                                        echo $this->Form->input('AssignPlot.remark', array('type' => 'textarea', 'id' => 'discount', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'style' => '100px')); 
                                         ?>
                                     </div>
                                  </div>
                                </fieldset>
                              </div>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/AssignPlots" class="btn btn-square btn-danger">Cancel</a>
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