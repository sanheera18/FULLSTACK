<?php
require('fpdf/fpdf.php');
session_start();

$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_41293517",
    "GKMECzs3gnUs8I0",
    "if0_41293517_user"
);

if(!isset($_SESSION['user_id'])) {
    die("Unauthorized Access");
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$score = $_GET['score'];
$percentage = $_GET['percentage'];

// Generate Certificate ID
$certificate_id = "CERT-" . strtoupper(uniqid());

// Save to database
$conn->query("INSERT INTO certificates (user_id, certificate_id, score, percentage)
              VALUES ('$user_id', '$certificate_id', '$score', '$percentage')");

$pdf = new FPDF();
$pdf->AddPage();

// Thin Elegant Border
$pdf->SetDrawColor(180, 180, 180);
$pdf->SetLineWidth(0.5);
$pdf->Rect(15, 15, 180, 267);

// Title
$pdf->SetFont('Arial','B',22);
$pdf->SetTextColor(44, 62, 80);
$pdf->Ln(40);
$pdf->Cell(0,10,'Certificate of Completion',0,1,'C');

// Divider line
$pdf->Ln(5);
$pdf->SetDrawColor(200, 200, 200);
$pdf->Line(40, 65, 170, 65);

$pdf->Ln(20);

// Subtitle
$pdf->SetFont('Arial','',14);
$pdf->SetTextColor(90, 90, 90);
$pdf->Cell(0,10,'This is to certify that',0,1,'C');

$pdf->Ln(8);

// Name (Highlighted but subtle)
$pdf->SetFont('Arial','B',20);
$pdf->SetTextColor(58, 80, 107);
$pdf->Cell(0,10,$user_name,0,1,'C');

$pdf->Ln(8);

// Completion Text
$pdf->SetFont('Arial','',14);
$pdf->SetTextColor(60, 60, 60);
$pdf->MultiCell(0,8,'has successfully completed the Online Quiz and demonstrated satisfactory performance in the assessment.',0,'C');

$pdf->Ln(15);

// Score Section
$pdf->SetFont('Arial','',13);
$pdf->Cell(0,8,"Score: $score",0,1,'C');
$pdf->Cell(0,8,"Percentage: $percentage%",0,1,'C');

$pdf->Ln(15);

// Certificate Info
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(120,120,120);
$pdf->Cell(0,6,"Certificate ID: $certificate_id",0,1,'C');
$pdf->Cell(0,6,"Date: ".date("d M Y"),0,1,'C');

$pdf->Ln(25);

// Signature Line
$pdf->SetTextColor(80,80,80);
$pdf->Cell(80,8,'____________________',0,0,'C');
$pdf->Cell(30);
$pdf->Cell(80,8,'____________________',0,1,'C');

$pdf->Cell(80,6,'Authorized Signature',0,0,'C');
$pdf->Cell(30);
$pdf->Cell(80,6,'Coordinator',0,1,'C');

$pdf->Output();
?>