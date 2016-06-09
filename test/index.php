<?php
/**
 * Created by PhpStorm.
 * User: thom
 * Date: 8-6-2016
 * Time: 13:18
 */

$test = 'Hallo Hallo HalloHallo Hallo Hallo Hallo';
require('../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);


$pdf->Cell(1,1, $test);
$pdf->Cell(1,20, $test);
$pdf->Output();
?>