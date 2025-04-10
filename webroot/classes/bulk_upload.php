<?php

function bulk_upload($tmp_name){

	include("classes/PHPExcel/IOFactory.php");
    $object = PHPExcel_IOFactory::load($tmp_name);
    return $object;
    
}
?>