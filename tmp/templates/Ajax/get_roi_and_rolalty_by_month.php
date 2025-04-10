<?php
$upgrades->total_businnes_value = !empty($upgrades->total_businnes_value) ? $upgrades->total_businnes_value : 0;
$upgrades->total_business_point = !empty($upgrades->total_business_point) ? $upgrades->total_business_point : 0;
echo $upgrades->total_businnes_value.'_^_'.$upgrades->total_business_point;
?>