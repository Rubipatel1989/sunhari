<?php
$options = ['' => '-Select-'];
foreach ($packages as $package) {
  $options[$package->id] = $package->plan_name.'(Rs '.number_format($package->amount, 2).')';
}
if ($isAmountFilter) {
  echo $this->Form->input($fieldName, array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return getPackgeAmount(this);'));
} else {
  echo $this->Form->input($fieldName, array('type' => 'select', 'options' => $options, 'label' => false, 'div' => false, 'class' => 'form-control loginbox'));
}
?>