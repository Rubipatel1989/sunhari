
<?php echo $this->Form->input($fieldName, array('type' => 'select', 'class' => $cls, 'options' => $plots, 'label' => false, 'div' => false, 'onchange' => 'getPlotDetails(this);')); ?>