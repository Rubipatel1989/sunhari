<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aojora</title>
</head>
<body>
<?php
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
				
$site_url = 'https://soft.aojora.io'; 
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="35">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background-color:#fff; border:7px solid #2F2F2F;">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FF6500; border:1px dashed #b0fdf9;">
              <tr>
                <td ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#fff;">
                    <tr>
                      <td align="center" valign="middle"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  style="border-bottom:1px solid #efefef;">
                                <tr>
                                  <td width="378" height="104px"><a href="<?php echo $site_url; ?>" target="_blank"><img src="<?php echo $site_url; ?>/dist/libs/images/logo2.png" /></a></td>
                                  <td width="344" align="right" valign="middle"><h1 style="font-size:18px;font-family:Arial, Helvetica, sans-serif;font-weight:600;color:#848585;"> Notification</h1>
                                    <h2 style="font-size:14px;font-family:Arial, Helvetica, sans-serif;font-weight:400;color:#848585;"><?php echo date('M, d.m.Y');?></h2></td>
                                  <td width="10">&nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                          </tr>
                          <tr>
                            <td><?php echo $this->fetch('content'); ?></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td height="35"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="47%" style=" font-size:11px;font-family:Arial, Helvetica, sans-serif;font-weight:400;color:#848585;">Copyright &copy; <?php echo date('Y'); ?> aojora.io. All Rights Reserved.</td>
          <td width="53%"><table width="29%"  border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td width="37%"><a href="" target="_blank"></td>
                <td width="32%"><a href="#" target="_blank"></td>
                <td width="31%"><a href="#" target="_blank"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
  </tr>
</table>
</body>
</html>
