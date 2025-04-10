<?php
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        
$site_url = 'https://soft.aojora.io';
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><h2 style="font-size:18px;font-family:Arial, Helvetica, sans-serif;font-weight:600;color:#848585;">Dear <?php echo $user['name']; ?>,</h2></td>
  </tr>
  <tr>
    <td height="73" style="font-size:16px;font-family:Arial, Helvetica, sans-serif;font-weight:400;color:#848585;">
     <p></p>
     <p>Your OTP for withdraw request aojora.io is : <strong><?php echo $user['otp']; ?></strong></p>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
