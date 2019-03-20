<?php

include("connection.php");

// PHPEXCEL
	require "../../assets/vendor/phpexcel/Classes/PHPExcel.php";

$action = $_GET["action"];

if($action == "insert_manual")
{
	// QUERY
		try 
		{
			pg_query("BEGIN");

			// CONTROL NO
			$sqlselect = "SELECT control_no FROM tbl_request_slip ORDER BY id DESC LIMIT 1 ";
			$queryselect = pg_query($connection, $sqlselect);
			$count = pg_num_rows($queryselect);

			if($count == 0)
			{
				$newvalue = "CN-" . date("y") . "-001";
			}
			else
			{
				$rowselect = pg_fetch_row($queryselect);
				
				$explode = explode("-", $rowselect[0]);

				if($explode[1] == date("y"))
				{
					$counter = str_pad(($explode[2] + 1), 3, "0", STR_PAD_LEFT); 
					$newvalue = $explode[0] . "-" . $explode[1] . "-" . $counter;
				}
				else
					$newvalue = "CN-" . date("y") . "-001";
			}
			$controlnonew = $newvalue;


			// INSERT HEADER
			$supplier = $_POST['txtRequestSupplier'];
			$request_date = date('Y-m-d H:i');
			$request_type = $_POST['txtRequestType'];
			$incharge = $_POST['session_id'];
			$status = 'FOR APPROVAL - PURCHASING';

			$tbl_request_slip = "INSERT INTO tbl_request_slip(supplier, request_date, request_type, incharge, status) VALUES('$supplier', '$request_date', '$request_type', '$incharge', '$status') RETURNING id; ";
			$result = pg_query($connection, $tbl_request_slip); 

			$row = pg_fetch_row($result);

			$tbl_request_slip_id = $row[0];

			// UPDATE
			$generate_code = $_POST['generate_code'];

			$updatecn = "UPDATE tbl_request_slip SET control_no = '$controlnonew', generate_code = '$generate_code' WHERE id = '$tbl_request_slip_id' ";
			pg_query($connection, $updatecn);

			// INSERT BODY
			$checker = false;
			$loop = count($_POST['txt_partno']);
			for ($i = 0; $i < $loop; $i++) 
			{
				$part_no = $_POST['txt_partno'][$i];
				$rev = $_POST['txt_rev'][$i];
				$quantity = $_POST['txt_qty'][$i];
				$po_no = $_POST['txt_pono'][$i];
				$po_code = $_POST['txt_pocode'][$i];
				$receipt_no = $_POST['txt_receiptno'][$i];
				$prod_code_no = $_POST['txt_prodorder'][$i];
				$delivery_date = $_POST['txt_deliverydate'][$i];
				$reason = $_POST['txt_reason'][$i];
				$status = 'WAITING';

				if(isset($_POST['questionaire' . ($i + 1)]))
					$supplier_answer = $_POST['questionaire' . ($i + 1)];
				else
					$supplier_answer = "";

				$tbl_request_details = "INSERT INTO tbl_request_details(tbl_request_slip_id, part_no, rev, quantity, po_no, po_code, receipt_no, prod_code_no, delivery_date, supplier_answer, reason, status) VALUES('$tbl_request_slip_id', '$part_no', '$rev', '$quantity', '$po_no', '$po_code', '$receipt_no', '$prod_code_no', '$delivery_date', '$supplier_answer', '$reason', '$status'); ";
				$result = pg_query($connection, $tbl_request_details); 

				if(!$result)
	             	$checker = true;
			}

			if($checker)
                echo json_encode("With error. Maybe due to apostrophe symbol. ");
            else
            {
                $finally = array();
            	array_push($finally, $controlnonew);
            	array_push($finally, $request_type);
            	array_push($finally, $generate_code);
                echo json_encode($finally);
	            pg_query("COMMIT");
            }

		} 
		catch (Exception $e) 
		{
			pg_query("ROLLBACK");
			echo json_encode("error");
		}
}
else if($action == "upload")
{
	if(isset($_FILES['filesssss']['name'])) 
	{
		$tmpfname = $_FILES['filesssss']['tmp_name'];
	    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
	    $excelObj = $excelReader->load($tmpfname);
	    $worksheet = $excelObj->getActiveSheet();
	    $lastRow = $worksheet->getHighestRow();


	    if($lastRow !== 1)
        {

        	try 
			{
				pg_query("BEGIN");

				// CONTROL NO
				$sqlselect = "SELECT control_no FROM tbl_request_slip ORDER BY id DESC LIMIT 1 ";
				$queryselect = pg_query($connection, $sqlselect);
				$count = pg_num_rows($queryselect);

				if($count == 0)
				{
					$newvalue = "CN-" . date("y") . "-001";
				}
				else
				{
					$rowselect = pg_fetch_row($queryselect);
					
					$explode = explode("-", $rowselect[0]);

					if($explode[1] == date("y"))
					{
						$counter = str_pad(($explode[2] + 1), 3, "0", STR_PAD_LEFT); 
						$newvalue = $explode[0] . "-" . $explode[1] . "-" . $counter;
					}
					else
						$newvalue = "CN-" . date("y") . "-001";
				}
				$controlnonew = $newvalue;

	            $checker = false;

	            $supplier = strtoupper($worksheet->getCell('B5')->getValue());
			    $request_type = strtoupper($worksheet->getCell('C5')->getValue());
				$request_date = date('Y-m-d H:i');
				$incharge = $_POST["session_id"];
				$status = 'FOR APPROVAL - PURCHASING';

				$tbl_request_slip = "INSERT INTO tbl_request_slip(supplier, request_date, request_type, incharge, status) VALUES('$supplier', '$request_date', '$request_type', '$incharge', '$status') RETURNING id; ";
				$insert_check = pg_query($connection, $tbl_request_slip); 

				if(!$insert_check)
	             	$checker = true;

				$row = pg_fetch_row($insert_check);

				$tbl_request_slip_id = $row[0];

				// UPDATE
				$generate_code = $_POST['generate_code'];

				$updatecn = "UPDATE tbl_request_slip SET control_no = '$controlnonew', generate_code = '$generate_code' WHERE id = '$tbl_request_slip_id' ";
				$update_check = pg_query($connection, $updatecn);

				if(!$update_check)
	             	$checker = true;

			    for ($row = 5; $row <= $lastRow; $row++) 
			    { 
			    	$part_no = strtoupper($worksheet->getCell('E' . $row)->getValue());
			    	$rev = strtoupper($worksheet->getCell('F' . $row)->getValue());

			    	if(strlen($rev) == 1)
			    		$rev = "0" . $rev;

			    	$quantity = strtoupper($worksheet->getCell('G' . $row)->getValue());
			    	$po_no = strtoupper($worksheet->getCell('H' . $row)->getValue());
			    	$po_code = strtoupper($worksheet->getCell('I' . $row)->getValue());
			    	$receipt_no = strtoupper($worksheet->getCell('J' . $row)->getValue());
			    	$prod_code_no = strtoupper($worksheet->getCell('K' . $row)->getValue());
			    	$delivery_date = $worksheet->getCell('L' . $row)->getValue();
			    	$supplier_answer = strtoupper($worksheet->getCell('M' . $row)->getValue());
			    	$reason = strtoupper($worksheet->getCell('N' . $row)->getValue());
			    	$status = "WAITING";

			        if($part_no != '')
			        {
				        $sql = "INSERT INTO tbl_request_details(tbl_request_slip_id, part_no, rev, quantity, po_no, po_code, receipt_no, prod_code_no, delivery_date, supplier_answer, reason, status) VALUES('$tbl_request_slip_id', '$part_no', '$rev', '$quantity', '$po_no', '$po_code', '$receipt_no', '$prod_code_no', '$delivery_date', '$supplier_answer', '$reason', '$status'); ";
				        $result = pg_query($connection, $sql); 

				        if(!$result)
	             			$checker = true;
			    	}
			    }

			    if($checker)
	                echo json_encode("Success with error. Maybe due to apostrophe symbol. ");
	            else
	            {
	            	$finally = array();
	            	array_push($finally, $controlnonew);
	            	array_push($finally, $request_type);
	            	array_push($finally, $generate_code);
	                echo json_encode($finally);
		            pg_query("COMMIT");
	            }

        	}
        	catch (Exception $e) 
			{
				pg_query("ROLLBACK");
				echo json_encode("error");
			}
	    }
	    else
	    {
	    	echo json_encode("Empty Excel Uploaded!");
	    }
	}
	else
	{
		echo json_encode("Error, please verify the template!");
	}
}
else if($action == "download_details")
{
	$id = $_GET['id'];

	$output = array();

	$sql = "SELECT a.supplier, a.request_type, a.control_no,
			b.part_no, b.rev, b.quantity, b.po_no, b.po_code, b.receipt_no, b.prod_code_no, b.delivery_date, b.supplier_answer, b.reason
			FROM tbl_request_slip a
			INNER JOIN tbl_request_details b ON a.id = b.tbl_request_slip_id
			WHERE a.id = '$id'
			AND b.status != 'REMOVED'
			ORDER BY a.id; ";
	$result = pg_query($connection, $sql);

	$control_no = '';

	while ($row = pg_fetch_assoc($result))
	{
		$control_no = $row["control_no"];

		$temp = 
		[
			"supplier" => $row["supplier"],
			"request_type" => $row["request_type"],
			"part_no" => $row["part_no"],
			"rev" => $row["rev"],
			"quantity" => $row["quantity"],
			"po_no" => $row["po_no"],
			"po_code" => $row["po_code"],
			"receipt_no" => $row["receipt_no"],
			"prod_code_no" => $row["prod_code_no"],
			"delivery_date" => $row["delivery_date"],
			"supplier_answer" => $row["supplier_answer"],
			"reason" => $row["reason"]
		];

		$output[] = $temp;
	}

	$objPHPExcel = new PhpExcel();

	// STYLE
		// Center
			$objPHPExcel->getActiveSheet()->getStyle('A:Z')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		// Auto size
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

		// Border
			$styleArray = array
			(
		    	'font'  => array
		    	(
		        	'bold'  => true
		        ),
		        'borders' => array
		        (
				    'allborders' => array
				    (
				      'style' => PHPExcel_Style_Border::BORDER_THIN
				    )
				)
		    );

		    $objPHPExcel->getActiveSheet()->getStyle('B1:C2')->applyFromArray($styleArray);
		    $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($styleArray);
		    $objPHPExcel->getActiveSheet()->getStyle('E1:N1')->applyFromArray($styleArray);
		    $objPHPExcel->getActiveSheet()->getStyle('E2:N2')->applyFromArray($styleArray);

		// Color Fill
			$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f8cbad');
			$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f8cbad');
			$objPHPExcel->getActiveSheet()->getStyle('E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f8cbad');
			$objPHPExcel->getActiveSheet()->getStyle('E2:N2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f8cbad');

		// Merging Cells
			$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
			$objPHPExcel->getActiveSheet()->mergeCells('E1:N1');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'HEADER');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'BODY');

	// HEADER
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'SUPPLIER');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'TYPE');

		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'PART NO');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'REV');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 'QUANTITY');
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 'PO NO');
		$objPHPExcel->getActiveSheet()->setCellValue('I2', 'PO CODE');
		$objPHPExcel->getActiveSheet()->setCellValue('J2', 'RECEIPT NO');
		$objPHPExcel->getActiveSheet()->setCellValue('K2', 'PROD CODE NO');
		$objPHPExcel->getActiveSheet()->setCellValue('L2', 'DELIVERY DATE');
		$objPHPExcel->getActiveSheet()->setCellValue('M2', 'SUPPLIER ANSWER');
		$objPHPExcel->getActiveSheet()->setCellValue('N2', 'REASON');

	// BODY
	$counter = 3;
	foreach ($output as $row)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('B3', $row['supplier']);
		$objPHPExcel->getActiveSheet()->setCellValue('C3', $row['request_type']);

		$objPHPExcel->getActiveSheet()->setCellValue('E'. $counter, $row['part_no']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'. $counter, $row['rev']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'. $counter, $row['quantity']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'. $counter, $row['po_no']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'. $counter, $row['po_code']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'. $counter, $row['receipt_no']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'. $counter, $row['prod_code_no']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'. $counter, $row['delivery_date']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'. $counter, $row['supplier_answer']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'. $counter, $row['reason']);
		$counter++;
	}

	// TITLE 
	$objPHPExcel->getActiveSheet()->setTitle($control_no);

	// OUTPUT
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
	header('Content-Disposition: attachment; filename='. $control_no .'.xls');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}

?>