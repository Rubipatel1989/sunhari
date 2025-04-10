<label>Package<span class="red">*</span></label>
<?php
$options = ['' => '-Select-'];
foreach ($packages as $package) {
  $options[$package->id] = $package->plan_name.'(Rs '.number_format($package->amount, 2).')';
}
echo $this->Form->input('Bill.package_id', array('type' => 'select', 'options' => $options, 'id' => 'dll_package', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'onchange' => 'return checkPackgeDetails(this);'));
?>