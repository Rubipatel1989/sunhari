<?php
require_once('fpdf.php');


function numberTowords($number) {

    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                    " " . $digits[$counter] . $plural . " " . $hundred :
                    $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
        } else
            $str[] = null;
    }
    $str = array_reverse($str);
    $result = ucfirst(implode('', $str));
    $points = ($point) ?
            "." . $words[$point / 10] . " " .
            $words[$point = $point % 10] : '';
    return $result;
}

class PDF extends FPDF {

    // Page header
    function Header() {
        // Logo

        if($_SERVER['DOCUMENT_ROOT'] == 'C:/xampp/htdocs'){
            $logo = $_SERVER['DOCUMENT_ROOT']."/jksinfratech/webroot/frontend/img/logo.jpeg";
        }else{
            $logo = $_SERVER['DOCUMENT_ROOT']."/webroot/frontend/img/logo.jpeg";
        }

        //$this->Image('', 2, 8, 50);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 20);
        // Move to the right
        $this->Cell(60);
        // Title
        $this->Cell(120, 10, '', 0, 0, 'C');
        $this->ln();
        $this->Cell(60);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(120, 5, '', 0, 0, 'C');
        $this->ln();
        $this->Cell(60);
        $this->Cell(120, 5, '', 0, 0, 'C');
        $this->ln();
        $this->Cell(60);
        $this->Cell(120, 5, '', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

}


function printReceit ($printData) {

    //$dir_name = '../../../download/';
    if($_SERVER['DOCUMENT_ROOT'] == 'C:/xampp/htdocs'){
        $dir_name = $_SERVER['DOCUMENT_ROOT'].'/jksinfratech/webroot/download/';
    }else{
        $dir_name = $_SERVER['DOCUMENT_ROOT'].'/webroot/download/';
    }

    if (!is_dir($dir_name)) {
        // Return canonicalized absolute pathname Make Directory
        mkdir($dir_name, 0755);
    }

    //echo 'print here...';exit;

    $rowdata = $printData;

    $errors = array();
    $data = array();
    $dataArray = array();
    $output = array();

    $pdf = new PDF();

    $pdf->AddPage();


    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'Receipt No:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, $printData['receipt_no'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'Plot No:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, $printData['plot_number'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Date: ' . date("d-m-Y", strtotime($printData['payment_date'])) . ' ', 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();
    $pdf->Cell(50, 5, 'Received From Mr./Mrs:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(90, 5, $printData['received_from'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Mobile:- ' .$printData['contact_no'], 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();


    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'S/o,W/O,D/O:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, $printData['father_name'], 0, 0, 'L');


    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'Address:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(170, 5, $printData['address'], 0, 1, 'L');
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'Received :-', 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(160, 5, ucfirst(numberTowords($printData['amount'])).'Only', 0, 0, 'L');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'In Site Of:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(120, 5, $printData['site'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Sq.Ft:- ' . $printData['area'], 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(40, 5, 'Cheque/Draft/Cash:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 5, $printData['payment_mode'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(25, 5, 'Bank Name:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, $printData['bank_name'], 0, 0, 'L');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(15, 5, 'Rs.', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, 5, $printData['amount'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(130, 5, '', 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(21, 5, '', 0, 0, 'C');
    $pdf->Cell(306, 5, '', 0, 0, 'C');
    $pdf->ln();
    $pdf->ln();
  

    /*$pdf->Cell(190, '.1', '', 1, 1, 'L');
    $pdf->ln(4);
    $pdf->ln(4);
    $pdf->ln();*/

    /*## Second Page Start #########
    //$pdf->Image('../frontend/img/logo.jpeg', 2, 142, 50);
    if($_SERVER['DOCUMENT_ROOT'] == 'C:/xampp/htdocs'){
        $logo = $_SERVER['DOCUMENT_ROOT']."/gstinfratech/webroot/frontend/img/logo.jpeg";
    }else{
        $logo = $_SERVER['DOCUMENT_ROOT']."/webroot/frontend/img/logo.jpeg";
    }
    //$pdf->Image($logo, 2, 148, 50);
    // Arial bold 15
    $pdf->SetFont('Arial', 'B', 20);
    // Move to the right
    $pdf->Cell(60);
    // Title
    $pdf->Cell(120, 10, '', 0, 0, 'C');
    $pdf->ln();
    $pdf->Cell(60);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(120, 5, '', 0, 0, 'C');
    $pdf->ln();
    $pdf->Cell(60);
    $pdf->Cell(120, 5, '', 0, 0, 'C');
    $pdf->ln();
    $pdf->Cell(60);
    $pdf->Cell(120, 5, '', 0, 0, 'C');
    // Line break
    $pdf->Ln(20);


    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'Receipt No:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, $printData['receipt_no'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'Plot No:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, $printData['plot_number'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Date: ' . date("d-m-Y", strtotime($printData['payment_date'])) . ' ', 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();
    $pdf->Cell(50, 5, 'Received From Mr./Mrs:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(90, 5, $printData['received_from'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Mobile:- '.$printData['contact_no'], 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();


    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'S/o,W/O,D/O:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 5, $printData['father_name'], 0, 0, 'L');


    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'Address:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->MultiCell(170, 5, $printData['address'], 0, 1, 'L');
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(30, 5, 'Received :-', 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(160, 5, ucfirst(numberTowords($printData['amount'])).'Only', 0, 0, 'L');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 5, 'In Site Of:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(120, 5, $printData['site'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(50, 5, 'Sq.Ft:- '.$printData['area'], 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(40, 5, 'Cheque/Draft/Cash:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 5, $printData['payment_mode'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(25, 5, 'Bank Name:-', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(95, 5, $printData['bank_name'], 0, 0, 'L');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(15, 5, 'Rs.', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(45, 5, $printData['amount'], 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(130, 5, '', 0, 0, 'R');
    $pdf->ln();
    $pdf->ln();
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(21, 5, '', 0, 0, 'C');
    $pdf->Cell(306, 5, '', 0, 0, 'C');
    $pdf->ln();
*/

    ######## End Second Page





    $file_name = date('Y-m-d') . $printData['received_from'] . 'slip.pdf';
    $full_name = $dir_name . $file_name;

    if (file_exists($full_name)) {
        // Delete the Existing File
        unlink($full_name);
    }
    $pdf->Output('F', $full_name);
    // echo $file_name . "Pawan1";

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        
       $file_name = 'http://localhost/jksinfratech/webroot/download/' . $file_name;
        //  $file_name = 'http://localhost/download/' . $file_name;
        // echo $file_name . "Pawan2";
    } else {
        // echo $file_name . "Pawan3";
        $file_name = 'http://web.jsksinfratech.com/webroot/download/' . $file_name;
    }
    $data['success'] = true;
    $data['filename'] = $file_name;

    //echo json_encode($data);exit;

    header("Location:".$file_name);exit;
}