<?php
require('fpdf181/fpdf.php');

$pdf = new FPDF('p','mm','A4');

$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);

$pdf->Cell(130, 5, '', 1, 0);
$pdf->Cell(130, 5, '', 1, 1);

$pdf->Output();