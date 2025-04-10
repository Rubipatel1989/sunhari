<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
  
  
  
<div style="width: 1000px; min-height: 500px; background: #ffffff; margin: 0 auto;">
  
  <div style="float: left; width: 57px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-left.png"></div>
  <div style="float: left; width: 886px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-center.png" width="100%" height="57"></div>
  <div style="float: left; width: 57px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-right.png"></div>
  <div style="clear: both;"></div>
  <div style="float: left; width: 57px; min-height: 40px;"><img src="<?php echo $home_url;?>/img/new-left-center.png" ></div>
  <div style="float: left; width: 886px; min-height: 556px; position: relative;">
  
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
          
          
          <tr>
            <td valign="top" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px"><img src="<?php echo $home_url;?>/img/logo.png" alt="" title="" /></td>
            <td colspan="2" valign="top" style="font-family: 'Lato', sans-serif; font-size: 15px; font-weight: 700; line-height: 23px; text-align: center"><img src="<?php echo $home_url;?>/img/logo-name.png"><br /<br />Office: Mannat Arcade 12/2,Old Sher Shah Suri road. Near motherson company, <br>Sector 37,Faridabad, Haryana 121003, Email : jsksinfratechpvtltd@gmail.com</td>
            
          </tr>
          <tr>
            <td width="16%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; padding-top: 13px; padding-bottom: 13px">No. : <?php echo $printData['receipt_no']; ?></td>
            <td width="64%" style="font-size: 20px; font-weight: bold; color: #3e91f5; text-decoration: underline; font-family: 'Lato', sans-serif; text-align: center; padding-left: 140px;">RECEIPT</td>
            <td width="20%"  style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:right; position: relative;">Date..........................<span style="position: absolute; white-space: nowrap; left: 77px; top: 8px;"><?php echo date("d-m-Y", strtotime($printData['payment_date'])); ?></span></td>
          </tr>
          
          <tr>
            <td width="16%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 16px; padding-top: 13px; padding-bottom: 13px"></td>
            <td width="64%" style="font-size: 23px; font-weight: bold; color: #3e91f5; text-decoration: underline; font-family: 'Lato', sans-serif; text-align: center; padding-left: 140px;"></td>
            <td width="20%"  style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:right; position: relative;">Plot No.........................<span style="position: absolute; white-space: nowrap; left: 77px; top: -1px;"><?php echo $printData['plot_number']; ?></span></td>
          </tr>
        </table>
  
    <table style="padding-top: 10px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left; position: relative;">Received From Mr./Mrs......................................................................................<span style="position: absolute;white-space: nowrap;left: 171px;top: -4px;"><?php echo $printData['received_from']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left; position: relative;">S/O, W/o, D/o............................................................<span style="position: absolute;white-space: nowrap;left: 103px;top: -4px;"><?php echo $printData['father_name']; ?></span></td>
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Address.......................................................................................................................................................................................<span style="position: absolute;white-space: nowrap;left: 67px;top: -4px;"><?php echo $printData['address']; ?></span></td>
            
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="70%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left;">................................................................................................................................</td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Mobile/Ph...................................................<span style="position: absolute;white-space: nowrap;left: 82px;top: -4px;"><?php echo $printData['contact_no']; ?></span></td>
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="50%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Received Rs.................................................................................................................................................................................<span style="position: absolute;white-space: nowrap;left: 94px;top: -4px;"><?php echo $printData['amount_in_words']; ?></span></td>
            
          </tr>
          
    </table>
  
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="80%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">In site of...............................................................................................................................<span style="position: absolute;white-space: nowrap;left: 77px;top: -4px;"><?php echo $printData['site']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Size.................................................<span style="position: absolute;white-space: nowrap;left: 38px;top: -4px;"><?php echo $printData['area']; ?></span></td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Remarks (If any)...........................................................................................<span style="position: absolute;white-space: nowrap;left: 131px;top: -4px;"><?php echo $printData['remark']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">T.L. Name..............................................................<span style="position: absolute;white-space: nowrap;left: 87px;top: -4px;"><?php echo $printData['tlName']; ?></span></td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left;">by Cheque/Draft/Cash : <?php echo $printData['payment_mode']; ?></td>
            <td style="font-size: 17px; color: #3e91f5; font-family: 'Lato', sans-serif; text-align: right;">For JSKS Infratech Pvt. Ltd.</td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="29%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left;">
            
              <div style="width: 90%; height: 50px; border-radius: 20px; border:#3e91f5 solid 2px;"><img src="<?php echo $home_url;?>/img/rupee-icon.png" alt="" title="" style="border-top-left-radius: 18px; border-bottom-left-radius: 18px;"><span style="position: relative; top: -19px; font-size: 22px; left: 3px; font-weight: bold;"><?php echo number_format($printData['amount'], 2); ?></span></div>
            
            </td>
            <td valign="bottom" width="25%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left;">Thanks for Visit</td>
            <td valign="bottom" width="25%" style="font-size: 16px; font-family: 'Lato', sans-serif; text-align:left;">Client Signatory</td>
            <td valign="bottom" width="25%" style="font-size: 16px; font-family: 'Lato', sans-serif; text-align: right;">Auth. Signatory</td>
            
          </tr>
          
        </table>
    
    
    <div style="position: absolute; width:886px; bottom:2px;"><img src="<?php echo $home_url;?>/img/bottom-center.png" width="100%" height="57"></div>
    
    
  </div>
  <div style="float: left; width: 57px; min-height: 40px;"><img src="<?php echo $home_url;?>/img/new-right-center.png" ></div>
  <div style="clear: both;"></div>



  

  
<div style="clear: both;"></div>  
</div>
  
  
<div style="width: 1000px; min-height: 500px; background: #ffffff; margin: 10px auto;">
  
  <div style="float: left; width: 57px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-left.png"></div>
  <div style="float: left; width: 886px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-center.png" width="100%" height="57"></div>
  <div style="float: left; width: 57px; height: 57px;"><img src="<?php echo $home_url;?>/img/top-right.png"></div>
  <div style="clear: both;"></div>
  <div style="float: left; width: 57px; min-height: 40px;"><img src="<?php echo $home_url;?>/img/new-left-center.png" ></div>
  <div style="float: left; width: 886px; min-height: 556px; position: relative;">
  
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
          
          
          <tr>
            <td valign="top" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px"><img src="<?php echo $home_url;?>/img/logo.png" alt="" title="" /></td>
            <td colspan="2" valign="top" style="font-family: 'Lato', sans-serif; font-size: 15px; font-weight: 700; line-height: 23px; text-align: center"><img src="<?php echo $home_url;?>/img/logo-name.png"><br /><br />Office: Mannat Arcade 12/2,Old Sher Shah Suri road. Near motherson company, <br>Sector 37,Faridabad, Haryana 121003, Email : jsksinfratechpvtltd@gmail.com</td>
            
          </tr>
          <tr>
            <td width="16%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; padding-top: 13px; padding-bottom: 13px">No. : <?php echo $printData['receipt_no']; ?></td>
            <td width="64%" style="font-size: 20px; font-weight: bold; color: #3e91f5; text-decoration: underline; font-family: 'Lato', sans-serif; text-align: center; padding-left: 140px;">RECEIPT</td>
            <td width="20%"  style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:right; position: relative;">Date..........................<span style="position: absolute; white-space: nowrap; left: 77px; top: 8px;"><?php echo date("d-m-Y", strtotime($printData['payment_date'])); ?></span></td>
          </tr>
          
          <tr>
            <td width="16%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 16px; padding-top: 13px; padding-bottom: 13px"></td>
            <td width="64%" style="font-size: 23px; font-weight: bold; color: #3e91f5; text-decoration: underline; font-family: 'Lato', sans-serif; text-align: center; padding-left: 140px;"></td>
            <td width="20%"  style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:right; position: relative;">Plot No.........................<span style="position: absolute; white-space: nowrap; left: 77px; top: -1px;"><?php echo $printData['plot_number']; ?></span></td>
          </tr>
        </table>
  
    <table style="padding-top: 10px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left; position: relative;">Received From Mr./Mrs......................................................................................<span style="position: absolute;white-space: nowrap;left: 171px;top: -4px;"><?php echo $printData['received_from']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left; position: relative;">S/O, W/o, D/o............................................................<span style="position: absolute;white-space: nowrap;left: 103px;top: -4px;"><?php echo $printData['father_name']; ?></span></td>
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Address.......................................................................................................................................................................................<span style="position: absolute;white-space: nowrap;left: 67px;top: -4px;"><?php echo $printData['address']; ?></span></td>
            
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="70%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left;">................................................................................................................................</td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Mobile/Ph...................................................<span style="position: absolute;white-space: nowrap;left: 82px;top: -4px;"><?php echo $printData['contact_no']; ?></span></td>
          </tr>
          
    </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="50%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Received Rs.................................................................................................................................................................................<span style="position: absolute;white-space: nowrap;left: 94px;top: -4px;"><?php echo $printData['amount_in_words']; ?></span></td>
            
          </tr>
          
    </table>
  
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="80%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">In site of...............................................................................................................................<span style="position: absolute;white-space: nowrap;left: 77px;top: -4px;"><?php echo $printData['site']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Size.................................................<span style="position: absolute;white-space: nowrap;left: 38px;top: -4px;"><?php echo $printData['area']; ?></span></td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">Remarks (If any)...........................................................................................<span style="position: absolute;white-space: nowrap;left: 131px;top: -4px;"><?php echo $printData['remark']; ?></span></td>
            <td style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left; position: relative;">T.L. Name..............................................................<span style="position: absolute;white-space: nowrap;left: 87px;top: -4px;"><?php echo $printData['tlName']; ?></span></td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="60%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left;">by Cheque/Draft/Cash : <?php echo $printData['payment_mode']; ?></td>
            <td style="font-size: 17px; color: #3e91f5; font-family: 'Lato', sans-serif; text-align: right;">For JSKS Infratech Pvt. Ltd.</td>
          </tr>
          
        </table>
    
    <table style="padding-top: 13px;" width="100%" border="0" cellpadding="0" cellspacing="0">
          
          <tr>
            <td width="29%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 18px; text-align:left;">
            
              <div style="width: 90%; height: 50px; border-radius: 20px; border:#3e91f5 solid 2px;"><img src="<?php echo $home_url;?>/img/rupee-icon.png" alt="" title="" style="border-top-left-radius: 18px; border-bottom-left-radius: 18px;"><span style="position: relative; top: -19px; font-size: 22px; left: 3px; font-weight: bold;"><?php echo number_format($printData['amount'], 2); ?></span></div>
            
            </td>
            <td valign="bottom" width="50%" style="font-family: 'Kurale', serif; font-style: italic; font-size: 17px; text-align:left;">Thanks for Visit</td>
            <td valign="bottom" width="25%" style="font-size: 16px; font-family: 'Lato', sans-serif; text-align: right;">Auth. Signatory</td>
            
          </tr>
          
        </table>
    
    
    <div style="position: absolute; width:886px; bottom:2px;"><img src="<?php echo $home_url;?>/img/bottom-center.png" width="100%" height="57"></div>
    
    
  </div>
  <div style="float: left; width: 57px; min-height: 40px;"><img src="<?php echo $home_url;?>/img/new-right-center.png" ></div>
  <div style="clear: both;"></div>



  

  
<div style="clear: both;"></div>  
</div>
  
  
</body>
</html>
