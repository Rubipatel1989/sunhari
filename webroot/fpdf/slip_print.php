<?php

session_start();
require_once '../functions/model/dbback.php';
require_once('fpdf.php');
//date_default_timezone_set('Asia/Kolkata');
$conn = new db();
$connection = $conn->connect();





if ($_SERVER['REQUEST_METHOD'] == "POST") {

    class PDF extends FPDF {

// Page header
        function Header() {
            // Logo
            $this->Image('../images/logo.png', 20, 10, 50);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 25);
            // Move to the right
            $this->Cell(60);
            // Title
            $this->Cell(120, 10, 'BSA Logistics Pvt. Ltd.', 0, 0, 'C');
            $this->ln();
            $this->Cell(60);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(120, 5, '1301, 13th Floor, Vikrant Tower, Rajendra Place', 0, 0, 'C');
            $this->ln();
            $this->Cell(60);
            $this->Cell(120, 5, 'New Delhi- 110008', 0, 0, 'C');
            // Line break
            $this->Ln(20);
        }

    }

    $dir_name = '../../download/';
    if (!is_dir($dir_name)) {
        // Return canonicalized absolute pathname Make Directory
        mkdir($dir_name, 0755);
    }
    $errors = array();
    $data = array();
    $dataArray = array();
    $output = array();
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'get_pdfDetails') {
        if (isset($_SESSION['kr_user_id'])) {
            try {
                $emi_id = $_POST['emi_id'];
                $query = "SELECT e.amount, c.name as client_name, p.plot_no, t.name as tl_name, pr.name as property_name,
                s.name as site_name, e.receipt_no, e.payment_mode, e.payment_status, e.created_on,e.payment_status, 
                u.user_name as created_by
                from emi_details e
                inner join plot p on p.plot_id = e.plot_id
                inner join site s on s.site_id = p.site_id
                inner join proerty pr on pr.property_id = s.property_id
                inner join client c on c.client_id = e.client_id
                inner join tl t on t.tl_id = c.tl_id
                inner join user_master u on u.user_id = e.created_by       
                where e.id = '$emi_id'";
                // echo $query;                exit();
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $rowdata = $stmt->fetch();
                $stmt->closeCursor();
                $pdf = new PDF();
                $pdf->AliasNbPages();
                $pdf->AddPage();

                $pdf->SetFont('Arial', 'B', 15);
                $pdf->Cell(190, 5, 'Krishna Residancy & Developers', 0, 0, 'C');
                $pdf->ln();
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(190, 5, 'B-84 Okhla Phase - 2 New Delhi Near Vodafone Office', 0, 0, 'C');
                $pdf->ln();
                $pdf->Cell(190, 5, 'Krishna Residancy & Developers', 0, 0, 'C');
                $pdf->ln();
                $pdf->ln();

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(25, 5, 'No:-', 0, 0, 'L');
                $pdf->Cell(30, 5, '1256', 0, 0, 'L');
                $pdf->Cell(25, 5, 'Plot No', 0, 0, 'L');
                $pdf->Cell(60, 5, '5858-Demuu Entry', 0, 0, 'L');
                $pdf->Cell(50, 5, 'Date:21-02-1998', 0, 0, 'L');


                $pdf->ln();


                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(35, 5, 'Address', 0, 0, 'L');
                $pdf->Cell(10, 5, ':', 0, 0, 'L');
                $pdf->SetFont('Arial', '', 11);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->MultiCell(140, 5, 'Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo', 0, 1, 'L');
                $pdf->ln();
                $pdf->Cell(190, '.1', '', 1, 1, 'L');
                $pdf->ln(4);


                $file_name = $rowdata['receipt_no'] . '.pdf';
                $full_name = $dir_name . $file_name;

                if (file_exists($full_name)) {
                    // Delete the Existing File
                    unlink($full_name);
                }
                $pdf->Output('F', $full_name);
                // echo $file_name . "Pawan1";

                if ($_SERVER['HTTP_HOST'] == 'localhost') {
                    $file_name = 'http://localhost/download/' . $file_name;
                    // echo $file_name . "Pawan2";
                } else {
                    // echo $file_name . "Pawan3";
                    $file_name = 'http://kr.bhcl.in/download/' . $file_name;
                }
                $data['success'] = true;
                $data['filename'] = $file_name;
            } catch (Exception $ex) {
                $errors['error'] = $ex->getMessage();
                $data['success'] = false;
                $data['errors'] = $errors;
                $data['data'] = $dataerror;
            } catch (PDOException $ex) {
                $errors['error'] = $ex->getMessage();
                $data['success'] = false;
                $data['errors'] = $errors;
                $data['data'] = $dataerror;
            }
        } else {
            $errors['error'] = "Your Session Has Been Expired ! Please Re-Login.";
            $data['success'] = false;
            $data['errors'] = $errors;
            $data['session'] = 'Expire';
        }
    }
    echo json_encode($data);
}