<?php
if(file_exists("../../bsasd_images/2019-01-22/81747Sign.jpg")){
    echo "find";
}else{
    echo "no";
}

function clean($string) {
   $string = str_replace(' ', '##', $string); // Replaces all spaces with hyphens.
   $filter= preg_replace('/[^A-Za-z0-9#\-]/', '', $string); // Removes special chars.
   $newString = str_replace('##', ' ', $filter); // Replaces all spaces with hyphens.
   return $newString;
}
echo clean("ajhasdfkh@#!&jskl'dfjlj");
echo "<br/>";
echo substr("8700049068", -4);
echo "<br/>";
$address=" 62/1  VALLAR street  _x005F_x000D_ 2f  perumbur vine's theater_x005F_x000D_ sham medical_x005F_x000D_ 600012";
echo $address;
echo "<br/>";

echo clean($address);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

