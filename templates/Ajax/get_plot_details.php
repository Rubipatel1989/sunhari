<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Plot Number</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.plot_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Plot Number', 'readonly' => 'readonly', 'value' => $plot->plot_number)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Plot Type</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Plot Type', 'readonly' => 'readonly', 'value' => $plot->name)); ?>
     </div>
  </div>
</fieldset>
<!-- 
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Length</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.length', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Length', 'readonly' => 'readonly', 'value' => $plot->length)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Width</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.width', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Width', 'readonly' => 'readonly', 'value' => $plot->width)); ?>
     </div>
  </div>
</fieldset> -->
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Area (In Sqft)</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.area', array('type' => 'text', 'id' => 'plot_area', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Area in sqyd', 'readonly' => 'readonly', 'value' => $plot->area)); ?>
     </div>
  </div>
</fieldset>
<!-- <fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Area (In Sqft)</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.area_in_sqft', array('type' => 'text', 'id' => 'plot_area', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Area Area in sqft', 'readonly' => 'readonly', 'value' => $plot->area*9)); ?>
     </div>
  </div>
</fieldset> -->
<!-- <fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">Location</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.location', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Location', 'readonly' => 'readonly', 'value' => $plot->location)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">East</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.east', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'East', 'readonly' => 'readonly', 'value' => $plot->east)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">West</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.west', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'West', 'readonly' => 'readonly', 'value' => $plot->west)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">North</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.north', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'North', 'readonly' => 'readonly', 'value' => $plot->north)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">South</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.south', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'South', 'readonly' => 'readonly', 'value' => $plot->south)); ?>
     </div>
  </div>
</fieldset> -->
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">PLC (In %)</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.plc', array('type' => 'text', 'label' => false, 'id' => 'plot_plc', 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'PLC', 'readonly' => 'readonly', 'value' => $plot->plc)); ?>
     </div>
  </div>
</fieldset>
<!-- <fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">EDC</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.edc', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'EDC', 'readonly' => 'readonly', 'value' => $plot->edc)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">IFMC</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.ifmc', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'IFMC', 'readonly' => 'readonly', 'value' => $plot->ifmc)); ?>
     </div>
  </div>
</fieldset>
<fieldset>
  <div class="row margin-top-25">
     <label class="col-sm-2 text-right">BSP</label>
     <div class="col-sm-8 height-37">
        <?php echo $this->Form->input('AssignPlot.bsp', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'BSP', 'readonly' => 'readonly', 'value' => $plot->bsp)); ?>
     </div>
  </div>
</fieldset> -->