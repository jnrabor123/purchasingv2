<?php
require('..\vendor\topdf\fpdf.php');
require('..\..\application\model\connection.php');

// $id = $_POST['id'];

$id = $_GET['id'];
$report = $_GET['report'];

class PDF extends FPDF
{   
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
    
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {

        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

    // Page header
    function Header()
    {
        // 1
            // Arial bold 15
            $this->SetFont('Arial','B', 9);
            
            $this->Cell(287, 5, 'FUJITSU DIE-TECH CORPORATION OF THE PHILIPPINES', 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(287, 5, 'Business Administrative Department', 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(287, 5, 'Production Control Section', 0, 0, 'L');
            $this->Ln(15);

            $this->SetFont('Arial','IB', 8);
            $this->SetFillColor(192);
            $this->RoundedRect(12, 26, 30, 6, 1, '1234', 'DF');
            $this->text(17, 30, 'Suppliers Copy');

            // Logo
            $this->Image('logo.png', 260, 6, 30);
            $this->text(269, 24, 'PCF 04 REV 06');

            $this->SetFont('Times','B', 35);
            $this->Cell(280, 5, 'REQUEST SLIP', 0, 0, 'C');
            $this->Ln(15);

        // 2
            $this->SetFont('Arial','B', 9);
            $this->Rect(35, 50, 5, 5, '');
            $this->Rect(95, 50, 5, 5, '');
            $this->Rect(155, 50, 5, 5, '');
            $this->Line(290, 55, 250, 55);
            $this->Rect(35, 56, 5, 5, '');
            $this->Rect(95, 56, 5, 5, '');
            $this->Rect(155, 56, 5, 5, '');
            $this->Line(290, 61, 250, 61);

            $this->Cell(30, 5, '', 0, 0, '');
            $this->Cell(60, 5, 'P.O CANCELLATION', 0, 0, 'L');
            $this->Cell(60, 5, 'M.O CANCELLATION', 0, 0, 'L');
            $this->Cell(60, 5, 'MATERIAL CANCELLATION', 0, 0, 'L');
            $this->Cell(30, 5, 'CONTROL NO:', 0, 0, 'R');
            $this->Cell(40, 5, '', 0, 0, 'L'); // VALUE
            $this->Ln(6);
            $this->Cell(30, 5, '', 0, 0, '');
            $this->Cell(60, 5, 'P.O ISSUANCE', 0, 0, 'L');
            $this->Cell(60, 5, 'M.O ISSUANCE', 0, 0, 'L');
            $this->Cell(60, 5, 'MATERIAL ISSUANCE', 0, 0, 'L');
            $this->Cell(30, 5, 'DATE:', 0, 0, 'R');
            $this->Cell(40, 5, '', 0, 0, 'L'); // VALUE
            $this->Ln(10);

            $this->Cell(10, 5, '', 0, 0, '');
            $this->Cell(30, 5, 'Reference Code', 0, 0, 'L');
            $this->Line(50, 71, 290, 71);
    }

    // Page footer
    function Footer()
    {
        $this->SetFont('Arial','B',10);
        $this->Rect(10, 170, 280, 15, '');
        $this->Rect(10, 185, 280, 15, '');
        $this->SetY(-37);

        $this->SetFont('Arial','I',8);
        $this->Cell(40, 5, 'Requested By:', 0, 0, 'C');
        $this->Cell(70, 5, '', 0, 0, 'L');
        $this->Cell(25, 5, 'Approved By:', 0, 0, 'C');
        $this->Cell(70, 5, '', 0, 0, 'L');
        $this->Cell(25, 5, 'Received By:', 0, 0, 'C');
        $this->Cell(50, 5, '', 0, 0, 'L');
        $this->Ln(5);
        $this->Cell(40, 5, '', 0, 0, 'C');
        $this->Cell(70, 5, '', 0, 0, 'L');
        $this->Cell(25, 5, '', 0, 0, 'C');
        $this->Cell(70, 5, '', 0, 0, 'L');
        $this->Cell(25, 5, '', 0, 0, 'C');
        $this->Cell(50, 5, '', 0, 0, 'L');
        $this->Ln(12);

        $this->SetFont('Arial','BI',10);
        $this->Cell(50, 5, 'For Supplier Purposes only', 0, 0, 'C');
        $this->SetFont('Arial','',8);
        $this->Cell(50, 5, 'Received By:', 0, 0, 'C');
        $this->Cell(80, 5, '', 0, 0, 'L');
        $this->Cell(30, 5, 'Date:', 0, 0, 'C');
        $this->Cell(70, 5, '', 0, 0, 'L');
        $this->Line(110, 195, 170, 195);
        $this->Line(220, 195, 280, 195);
        $this->Ln(5);
        
        $this->SetFont('Arial','I',8);
        $this->Cell(148, 5, 'Signature over printed name', 0, 0, 'R');
        $this->Ln(5);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(280, 5, "*** SYSTEM GENERATED REPORT ***", 0, 0, 'R');
    }

    function Body($connection, $id)
    {

        $sql = "SELECT a.id, a.control_no, c.employee_email, c.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.date_approved_by_purchasing, a.date_received_by,
            b.part_no, b.rev, b.quantity, b.po_no, b.po_code, b.receipt_no, b.prod_code_no, b.delivery_date, b.supplier_answer, b.reason, b.status
            FROM tbl_request_slip a
            INNER JOIN tbl_request_details b ON (a.id = b.tbl_request_slip_id)
            INNER JOIN employee_accounts c ON (CAST(a.incharge AS integer) = c.id)
            WHERE a.id = '$id'
            ORDER BY b.id; ";
        $result = pg_query($connection, $sql);

        $data = array();
        $data_return = array();

        while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC))
        {
            $temp = array();

            if(count($data_return) == 0)
            {
                array_push($data_return, $row['control_no']);
                array_push($data_return, $row['supplier']);
                array_push($data_return, $row['request_type']);
                array_push($data_return, $row['employee_email']);
            }

            $temp['control_no'] = $row['control_no'];
            $temp['request_type'] = $row['request_type'];
            $temp['request_date'] = $row['request_date'];

            $temp['part_no'] = $row['part_no'];
            $temp['rev'] = $row['rev'];
            $temp['quantity'] = $row['quantity'];
            $temp['po_no'] = $row['po_no'];
            $temp['po_code'] = $row['po_code'];

            $temp['receipt_no'] = $row['receipt_no'];
            $temp['prod_code_no'] = $row['prod_code_no'];
            $temp['delivery_date'] = $row['delivery_date'];
            $temp['supplier_answer'] = $row['supplier_answer'];
            $temp['reason'] = $row['reason'];

            $temp['supplier'] = $row['supplier'];
            $temp['employee_name'] = $row['employee_name'];
            $temp['approved_by_purchasing'] = $row['approved_by_purchasing'];
            $temp['date_approved_by_purchasing'] = $row['date_approved_by_purchasing'];
            $temp['received_by'] = $row['received_by'];
            $temp['date_received_by'] = $row['date_received_by'];

            $data[] = $temp;
        }

        $this->AddPage('L', 'A4', 0);
        $this->SetFont('Courier','I', 10);
        // HEADER
            $this->text(252, 53.5, $data[0]['control_no']);
            $this->text(252, 59.5, substr($data[0]['request_date'], 0, 10));
            // TYPE
                switch ($data[0]['request_type']) 
                {
                    case 'P.O ISSUANCE':
                        $this->Rect(35, 56, 5, 5, 'DF');
                        break;

                    case 'P.O CANCELLATION':
                        $this->Rect(35, 50, 5, 5, 'DF');
                        break;

                    case 'M.O ISSUANCE':
                        $this->Rect(95, 56, 5, 5, 'DF');
                        break;

                    case 'M.O CANCELLATION':
                        $this->Rect(95, 50, 5, 5, 'DF');
                        break;
                    
                    default:
                        break;
                }

        // FOOTER
            $this->text(50, 176.5, $data[0]['employee_name']);
            $this->text(50, 181.5, substr($data[0]['request_date'], 0, 10));

            $this->text(145, 176.5, $data[0]['approved_by_purchasing']);
            $this->text(145, 181.5, substr($data[0]['date_approved_by_purchasing'], 0, 10));

            $this->text(240, 176.5, $data[0]['received_by']);
            $this->text(240, 181.5, substr($data[0]['date_received_by'], 0, 10));
        
        $this->SetFont('Arial','B', 9);
        $this->Ln(10);

        $this->Cell(10, 10, 'NO', 1, 0, 'C');
        $this->Cell(40, 10, 'PART NO.', 1, 0, 'C');
        $this->Cell(10, 10, 'REV', 1, 0, 'C');
        $this->Cell(15, 10, 'QTY', 1, 0, 'C');
        $this->Cell(20, 10, 'PO NO.', 1, 0, 'C');
        $this->Cell(25, 10, 'PO CODE', 1, 0, 'C');
        $this->Cell(30, 10, 'RECEIPT NO.', 1, 0, 'C');
        $this->Cell(30, 10, 'PROD. ORDER NO.', 1, 0, 'C');
        $this->Cell(30, 10, 'DELIVERY DATE', 1, 0, 'C');
        $this->Cell(30, 5, 'Suppliers Answer', 1, 0, 'C');
        $this->Cell(40, 10, 'REASON', 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(210, 10, '', 0, 0, 'C');
        $this->Cell(15, 5, 'OK', 1, 0, 'C');
        $this->Cell(15, 5, 'NG', 1, 0, 'C');
        $this->Ln(5);

        // LOOP
            $this->SetFont('Courier','', 10);
            $sa = 86;
            for ($a = 0; $a < 15; $a++)
            { 
                if( $a < count($data) )
                {
                    $this->Cell(10, 5, ($a + 1), 1, 0, 'C');
                    $this->Cell(40, 5, $data[$a]['part_no'], 1, 0, 'C');
                    $this->Cell(10, 5, $data[$a]['rev'], 1, 0, 'C');
                    $this->Cell(15, 5, $data[$a]['quantity'], 1, 0, 'C');
                    $this->Cell(20, 5, $data[$a]['po_no'], 1, 0, 'C');
                    $this->Cell(25, 5, $data[$a]['po_code'], 1, 0, 'C');
                    $this->Cell(30, 5, $data[$a]['receipt_no'], 1, 0, 'C');
                    $this->Cell(30, 5, $data[$a]['prod_code_no'], 1, 0, 'C');
                    $this->Cell(30, 5, $data[$a]['delivery_date'], 1, 0, 'C');

                    ($data[$a]['supplier_answer'] == "OK") ? $this->Image('check.png', 225, $sa, 5) : $this->Image('check.png', 240, $sa, 5);

                    $this->Cell(15, 5, '', 1, 0, 'C');
                    $this->Cell(15, 5, '', 1, 0, 'C');
                    $this->CellFitScale(40, 5, $data[$a]['reason'], 1, 1);
                }
                else
                {
                    $this->Cell(10, 5, ($a + 1), 1, 0, 'C');
                    $this->Cell(40, 5, '', 1, 0, 'C');
                    $this->Cell(10, 5, '', 1, 0, 'C');
                    $this->Cell(15, 5, '', 1, 0, 'C');
                    $this->Cell(20, 5, '', 1, 0, 'C');
                    $this->Cell(25, 5, '', 1, 0, 'C');
                    $this->Cell(30, 5, '', 1, 0, 'C');
                    $this->Cell(30, 5, '', 1, 0, 'C');
                    $this->Cell(30, 5, '', 1, 0, 'C');
                    $this->Cell(15, 5, '', 1, 0, 'C');
                    $this->Cell(15, 5, '', 1, 0, 'C');
                    $this->Cell(40, 5, '', 1, 0, 'C');
                    $this->Ln(5);
                }

                $sa += 5;
                
            }

        // AUTO FIT
            // foreach ($data as $item)
            // {
            //     $cellWidth = 40;
            //     $cellHeight = 5;

            //     if( $this->GetStringWidth($item['reason']) < $cellWidth)
            //         $line = 1;
            //     else
            //     {
            //         $textLength = strlen($item['reason']);
            //         $errMargin = 10;
            //         $startChar = 0;
            //         $maxChar = 0;
            //         $textArray = array();
            //         $tmpString = "";

            //         while($startChar < $textLength)
            //         {
            //             while( $this->GetStringWidth($tmpString) < ($cellWidth-$errMargin) && ($startChar+$maxChar) < $textLength)
            //             {
            //                 $maxChar++;
            //                 $tmpString = substr($item['reason'], $startChar, $maxChar);
            //             }
            //             $startChar=$startChar+$maxChar;
            //             array_push($textArray, $tmpString);
            //             $maxChar = 0;
            //             $tmpString = '';
            //         }
            //         $line = count($textArray);
            //     }

            //     $this->Cell(10, ($line * $cellHeight), '1', 1, 0);
            //     $this->Cell(40, ($line * $cellHeight), $item['part_no'], 1, 0);
            //     $this->Cell(10, ($line * $cellHeight), $item['rev'], 1, 0);
            //     $this->Cell(15, ($line * $cellHeight), $item['quantity'], 1, 0);
            //     $this->Cell(20, ($line * $cellHeight), $item['po_no'], 1, 0);
            //     $this->Cell(25, ($line * $cellHeight), $item['po_code'], 1, 0);
            //     $this->Cell(30, ($line * $cellHeight), $item['receipt_no'], 1, 0);
            //     $this->Cell(30, ($line * $cellHeight), $item['prod_code_no'], 1, 0);
            //     $this->Cell(30, ($line * $cellHeight), $item['delivery_date'], 1, 0);
            //     $this->Cell(15, ($line * $cellHeight), '', 1, 0, 'C');
            //     $this->Cell(15, ($line * $cellHeight), '', 1, 0, 'C');
            //     $this->MultiCell($cellWidth, $cellHeight, $item['reason'], 1);
            // }  

        $this->SetFont('Arial','B', 9);
        $this->Ln(2);
        $this->Cell(50, 5, 'SUPPLIER:', 1, 0, 'C');
        $this->SetFont('Courier','I', 10);
        $this->Cell(230, 5, $data[0]['supplier'], 1, 0, 'L'); // VALUE

        return $data_return;
    }

}

// Instanciation of inherited class
$pdf = new PDF( 'L', 'mm', 'A4' );

$pdf->AliasNbPages();

$data_array = array();

$data_array = $pdf->Body($connection, $id);

$control_no = $data_array[0];
$pdf_file = $control_no . '.pdf';
$supplier = $data_array[1];
$request_type = $data_array[2];
$employee_email = $data_array[3];

if($report == "email")
{
    require '../email/email_header.php';

    $data = array();

    $mail->AddAddress($employee_email);
    $mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

    //SUBJECT
        $mail->Subject = "ICOS - NOTIFICATION";

    // ATTACHMENT
        $mail->addStringAttachment( $pdf->Output('S', $pdf_file) ,  $pdf_file, $encoding = 'base64', $type = 'application/pdf'); 

    //EMBEDDED IMAGE
        $mail->AddEmbeddedImage('../email/images/purlogo.png', 'Kartka');
        $mail->AddEmbeddedImage('../email/images/done.jpg', 'Message');

    // BODY
        $mail->isHTML(true);

    // REQUEST
        $htmlBodyText = '
                <center>
                    <img src="cid:Message" height="130" width="150" />
                    <br/><br/>
                    <p style="font-family: Courier New;">Your request ' . $request_type . ' has been finished
                    <br/>

                    <table style="font-family: Courier New; border: 1px solid #dd4b39; ">

                        <tr>
                            <td style="border: 1px solid #dd4b39; width: 30%"><p>CONTROL NO </p></td>
                            <td style="border: 1px solid #dd4b39; width: 70%"><p align="center">'. $control_no .'</p></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dd4b39; width: 30%"><p>SUPPLIER </p></td>
                            <td style="border: 1px solid #dd4b39; width: 70%"><p align="center">'. $supplier .'</p></td>
                        </tr> 

                        
                    </table>
            ';

    $htmlBodyText .= 
    '
            <br/><br/>
            
            <a href="http://10.164.30.173/purchasingv2/" target="_blank" style="font-style: italic; color: #dd4b39; font-family: Courier New; pointer-events: none; cursor: default;">Come and visit us! Just click here</a>
            
            <br/><br/><br/><br/><br/>
            
            <img src="cid:Kartka" height="30" width="210" />
            <p style="font-style: italic; color: #dd4b39; font-family: Courier New">
                **This email is system generated**
            </p>
            </center>

            <br/><br/>

            <p style="font-family: Helvetica, sans-serif; font-size: 11px; text-align: justify; text-justify: inter-word; color: #a6a6a6;">
            DISCLAIMER
            <br/>
            This email including the information and attachments may contain confidential, copyright and/or privileged material that is solely for the use of the intended recipient/s or entity to whom it is addressed and other authorized to receive it. If you are not the intended recipient it is hereby brought to your notice that any disclosure, copying, distribution, or dissemination, or alternatively taking of any action in reliance to this, is strictly prohibited. If you received this email with inaccuracy/error, please notify the sender by reply, mail or telephone and delete the original message from your email system immediately.
            </p>
    ';

    $mail->Body = $htmlBodyText; 

    //SEND
    $mail->send();

    echo json_encode($data);
}
else if($report == "pdf")
{
    $pdf->Output('', $pdf_file);
}

?>