<?php

include("connection.php");

$action = $_GET["action"];

if($action == "insertIDR")
{
	// tbl_idr
		$attention = $_POST['txtRequestAttention'];
		$employee_no = $_POST['txtRequestIncharge'];
		$request_date = date('Y-m-d H:i');
		$status = 'FOR RECEIVING';

	// tbl_idr_request
		(isset($_POST['txtPartNo'])) ? $loop = count($_POST['txtPartNo']) : $loop = 0;
		(isset($_FILES['txtFile']['name'])) ? $file = count($_FILES['txtFile']['name']) : $file = 0;

		// 
		// $_POST['txtFile']


	// QUERY
		try 
		{
			pg_query("BEGIN");

			$sqlselect = "SELECT control_no FROM tbl_idr ORDER BY tbl_idr DESC LIMIT 1 ";
			$queryselect = pg_query($connection, $sqlselect);

			$count = pg_num_rows($queryselect);

			if($count == 0)
			{
				$newvalue = "PURDR-" . date("y") . "-001";
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
				{
					$newvalue = "PURDR-" . date("y") . "-001";
				}
			}

			$controlnonew = $newvalue;

			$insert_tbl_idr = "INSERT INTO tbl_idr(attention, employee_no, request_date, status) VALUES('$attention', '$employee_no', '$request_date', '$status') RETURNING id; ";

			$result = pg_query($connection, $insert_tbl_idr); 

			$row = pg_fetch_row($result);
			$id = $row[0];

			$updatedr = "UPDATE tbl_idr SET control_no = '$controlnonew' WHERE id = '$id' ";
			pg_query($connection, $updatedr);

			for ($i = 0; $i < $loop; $i++) 
			{

				$partno = $_POST['txtPartNo'][$i];
				$rev = $_POST['txtRev'][$i];
				$qty = $_POST['txtQty'][$i];
				$supplier = $_POST['txtSupplier'][$i];
				$dr = $_POST['txtDR'][$i];
				$remarks = $_POST['txtRemarks'][$i];

				$insert_tbl_idr_request = "INSERT INTO tbl_idr_request(tbl_idr_id, part_no, rev, qty, supplier, dr_inv_no, remarks, status) VALUES('$id', '$partno', '$rev', '$qty', '$supplier', '$dr', '$remarks', 'WAITING'); ";
				pg_query($connection, $insert_tbl_idr_request); 
			}

			for ($a = 0; $a < $file; $a++) 
			{
				$description = $_POST['txtDescription'][$a];
				$location = '';

				if($_FILES['txtFile']['name'][$a] == "") { $location = ""; }
				else 
				{
					$location = "../../upload/PDF/" . basename($_FILES['txtFile']['name'][$a]); 

					if(file_exists($location))
					{
						$newName = $location;
						$counter = 1;
						while(file_exists($newName))
						{
							$temp = explode(".", $_FILES['txtFile']['name'][$a]);
							$newName = "../../upload/PDF/" . $temp[0] . $counter . "." . $temp[1];
							$counter++;
						}
						move_uploaded_file($_FILES['txtFile']['tmp_name'][$a] , $newName);
						$location = $newName;
					}
					else { move_uploaded_file($_FILES['txtFile']['tmp_name'][$a] , $location); }
				}

				$insert_tbl_idr_attachment = "INSERT INTO tbl_idr_attachment(tbl_idr_id, filename, location) VALUES('$id', '$description', '$location'); ";
				pg_query($connection, $insert_tbl_idr_attachment); 
			}

			pg_query("COMMIT");

			// echo json_encode("success");
			echo json_encode($id);
		} 
		catch (Exception $e) 
		{
			pg_query("ROLLBACK");
			echo json_encode("error");
		}
}
else if($action == "updateIDR")
{
	$name = $_POST['txtNameModal'];
	$id = $_POST['txtIdModal'];
	$date = date('Y-m-d H:i');
	$remarks = $_POST['txtRemarks'];

	(isset($_POST['txtId'])) ? $loop = count($_POST['txtId']) : $loop = 0;

	try
	{
		pg_query("BEGIN");

		$monitoring = "RECEIVED";

		for ($i = 0; $i < $loop; $i++)
		{

			$idloop = $_POST['txtId'][$i];
			$actual = $_POST['txtActual'][$i];
			$qty = $_POST['txtQty'][$i];

			if($actual != $qty)
			{
				$status = "RECEIVED WITH DISCREPANCY";
				$monitoring = "RECEIVED WITH DISCREPANCY";
			}
			else
			{
				$status = "RECEIVED";
			}

			$update_tbl_idr_request = "UPDATE tbl_idr_request SET status = '$status', actual = '$actual', received_by = '$name', received_date = '$date' WHERE id = '$idloop';  ";
			pg_query($connection, $update_tbl_idr_request); 
		}

		$update_tbl_idr = "UPDATE tbl_idr SET status = '$monitoring', received_date = '$date', remarks = '$remarks' WHERE id = '$id';  ";
		pg_query($connection, $update_tbl_idr); 

		pg_query("COMMIT");

		// echo json_encode("success");
		 echo json_encode($id);
	} 
	catch (Exception $e) 
	{
		pg_query("ROLLBACK");
		echo json_encode("error");
	}
}



?>