<?php
$url = 'soft.aojora.io/cron/index';
//$url = 'http://localhost/aojora/cron/roi';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING, ""); 
curl_setopt($curl, CURLOPT_MAXREDIRS, 10); 
curl_setopt($curl, CURLOPT_TIMEOUT , 30); 
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$cronMsg = '';

if ($err) {
  $cronMsg .= 'Cron : Failure ';
} else {
  $cronMsg .= 'Cron : Success ';
}

echo $cronMsg;
?>