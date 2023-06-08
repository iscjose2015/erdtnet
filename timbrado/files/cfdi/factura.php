<?php
require('fpdf.php');

include("../../conecta_facturacion.php");

$fact = $_GET[cve];


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
//$pdf->Cell(40,60,$fact);  //  (X,Y)  x horizontal, y vertical 
$pdf->Image('logo-erdt.png',10,8,33);
$pdf->Cell(10,40,"_____________________________________________________________");  //  (X,Y)  x horizontal, y vertical 
$pdf->Output();
?>