<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Add Plot
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
                          <form name="add_plot_form"  id="add_plot_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                            <legend>Plot Details</legend>
                              <fieldset>
                                <div class="form-group margin-top-15">
                                   <label class="col-sm-2 control-label">Property<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Property-'];
                                      foreach($properties as $property){
                                        $options[$property->id] = $property->title;
                                      }
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Plot.property_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterSiteByProperty(this.value, "site_container", "Plot.site_id", "form-control loginbox");')); 
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
                                      echo $this->Form->input('Plot.site_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected, 'onchange' => 'FilterBlockBySite(this.value, "block_container", "Plot.block_id", "form-control loginbox");')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Block<span class="red">*</span></label>
                                   <div id="block_container" class="col-sm-8 height-37">
                                      <?php 
                                      $options = ['' => '-Select Block-'];
                                      $selected = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '';
                                      echo $this->Form->input('Plot.block_id', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'default' => $selected)); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Plot Number<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.plot_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Plot Number')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Property Type<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Property Type')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!-- <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Length<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.length', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Length')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Width<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.width', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Width')); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Area (In Sqyd)<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.area', array('type' => 'text', 'id' => 'area', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Area In Sqyd', 'onchange' => 'return convertAreaIn(this, "sqyd", "area_in_sqyd");')); ?>
                                   </div>
                                </div>
                              </fieldset>
                             <!--  <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Area (In Sqyd)</label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.area_in_sqyd', array('type' => 'text', 'id' => 'area_in_sqyd', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Area In Sqft', 'readonly' => 'readonly')); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <!-- <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Location<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.location', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Location')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">East<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.east', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'East')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">West<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.west', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'West')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">North<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.north', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'North')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">South<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.south', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'South')); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">PLC (%)<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.plc', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'PLC')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <!-- <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">EDC<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.edc', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'EDC')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">IFMC<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.ifmc', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFMC')); ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">BSP<span class="red">*</span></label>
                                   <div class="col-sm-8 height-37">
                                      <?php echo $this->Form->input('Plot.bsp', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'BSP')); ?>
                                   </div>
                                </div>
                              </fieldset> -->
                              <!-- <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label">Photo</label>
                                  <div class="col-sm-9">
                                    <?php $rand_id = rand(123456789, 999999999);?>
                                    <div class="col-sm-12 nopadding">
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding" onclick="return uploadPhoto('Attachment.attachment_id.', 'single', 1, '<?php echo $rand_id; ?>');">
                                          <div class="col-xs-6 btn_browse">
                                            Choose file
                                          </div>
                                          <div class="col-xs-6 nopadding">
                                            <button type="button" class="btn-browse">Browse</button>
                                          </div>
                                        </div>
                                      </div>
                                      <div id="<?php echo $rand_id; ?>" class="col-xs-12 nopadding margin-top-10 qualification-proof">
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </fieldset> -->
                              <fieldset>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">Status<span class="red">*</span></label>
                                   <div class="col-sm-2 height-37">
                                       <?php 
                                       $options = ['' => '-Select-', '1' => 'Active', '0' => 'Inactive'];
                                       echo $this->Form->input('Plot.status', array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox')); 
                                       ?>
                                   </div>
                                </div>
                              </fieldset>
                              <fieldset>
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"></label>
                                  <div class="col-sm-10">
                                      <button type="submit" class="btn btn-square btn-primary">Submit</button> 
                                      &nbsp; <a href="<?php echo $backend_url ?>/projects/plots" class="btn btn-square btn-danger">Cancel</a>
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