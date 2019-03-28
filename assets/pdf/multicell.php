<?php
require('..\vendor\topdf\fpdf.php');

// $id = $_GET['id'];

class PDF extends FPDF
{   
    // Page header
    function header()
    {
    }

    // Page footer
    function Footer()
    {
    }

    function Body()
    {
    }

}

$data2 = array(
    array(
        "1",
        "Foo, overflow text length",
        "This contains a long text. not too long but longer than cell's width",
        "Somethings",
        "Something"
    ),
    array(
        "1",
        "Bar, normal text length",
        "This should not exceed the cell's width",
        "Something else",
        "This contains a long text. not too long but longer than cell's width",
    ),
    array(
        "1",
        "Baz, overflowed text length",
        "This also contains a long text, not too long but longer than cell's width This also contains a long text, not too long but longer than cell's width",
        "Something else",
        "This contains a long text. not too long but longer than cell's width",
    )
);


// Instanciation of inherited class
$pdf = new PDF( 'L', 'mm', 'A4' );

$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);
$fontSize = 12;

$tempFontSize = $fontSize;

$pdf->Ln(10);

//multicell method
$pdf->Cell(150, 5, "Font size shrinking method", 0, 1);




$data = [];

for ($i=0; $i < 3; $i++) 
{ 
    $temp = [];

    $temp[] = '1';
    $temp[] = "Baz, overflowed text length";
    $temp[] = "Something else";
    $temp[] = "This contains a";
    $temp[] = "This also contains a long text, not too long but longer than cell's width This also contains a long text, not too long but longer than cell's width";

    $data[] = $temp;
}

foreach ($data as $item)
{
    $cellWidth = 80;
    $cellHeight = 5;

    if($pdf->GetStringWidth($item[4]) < $cellWidth)
        $line = 1;
    else
    {
        $textLength = strlen($item[4]);
        $errMargin = 10;
        $startChar = 0;
        $maxChar = 0;
        $textArray = array();
        $tmpString = "";

        while($startChar < $textLength)
        {
            while( $pdf->GetStringWidth($tmpString) < ($cellWidth-$errMargin) && ($startChar+$maxChar) < $textLength)
            {
                $maxChar++;
                $tmpString = substr($item[4], $startChar, $maxChar);
            }
            $startChar=$startChar+$maxChar;
            array_push($textArray, $tmpString);
            $maxChar = 0;
            $tmpString = '';
        }
        $line = count($textArray);
    }

    $pdf->Cell(10, ($line * $cellHeight), $item[0], 1, 0);
    $pdf->Cell(60, ($line * $cellHeight), $item[1], 1, 0);
    $pdf->Cell(30, ($line * $cellHeight), $item[2], 1, 0);
    $pdf->Cell(60, ($line * $cellHeight), $item[3], 1, 0);
    $pdf->MultiCell($cellWidth, $cellHeight, $item[4], 1);

    // $pdf->Cell(60, ($line * $cellHeight), $item[4], 1, 0);

    // $xPos = $pdf->GetX();
    // $yPos = $pdf->GetY();
    // $pdf->MultiCell($cellWidth, $cellHeight, $item[4], 1);
    // $pdf->SetXY($xPos + $cellWidth, $yPos);
    // $pdf->Cell(40, ($line * $cellHeight), $item[3], 1, 1);

    // $pdf->SetXY(($xPos + 40) + $cellWidth, $yPos);
    // $pdf->MultiCell($cellWidth, $cellHeight, $item[4], 1);
}





$pdf->Output('', "dr" . '.pdf');
?>