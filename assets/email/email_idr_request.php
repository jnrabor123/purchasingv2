<?php

	require 'email_header.php';
	
	$id = $_POST["id"];
	$rawdata = $_POST["rawdata"];

	//$id = '10';
	//$rawdata = 'romel.pea@ph.fujitsu.com/QC-RECEIVING';

	$datas = explode("/", $rawdata);

	$email = $datas[0];
	$group = $datas[1];

	$data = array();

	$sqlqc = "SELECT employee_email, employee_group, employee_position FROM employee_accounts WHERE employee_section = 'qc' AND employee_status = 'active'; ";
	$resultqc = pg_query($connection, $sqlqc); 
	while($rowqc = pg_fetch_array($resultqc))
	{
		if($rowqc[0] == $email)
			$mail->AddAddress($rowqc[0]);
		else
		{
			if($rowqc[1] == $group)
				$mail->AddCC($rowqc[0]);

			if($rowqc[2] != 'staff')
				$mail->AddCC($rowqc[0]);
		}
	}

	// Control No
		$controlno = '';
		$sql_controlno = "SELECT control_no FROM tbl_idr WHERE id = '$id'; ";
		$result_controlno = pg_query($connection, $sql_controlno); 
		while($row_controlno = pg_fetch_array($result_controlno))
		{
			$controlno = $row_controlno[0];
		}
	
	$mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

	//SUBJECT
	$mail->Subject = "IDR - SHIPPING INFORMATION";

	//EMBEDDED IMAGE
	$mail->AddEmbeddedImage('images/purlogo.png', 'Kartka');
	$mail->AddEmbeddedImage('images/delivery.png', 'Delivery');

	//BODY
	$mail->isHTML(true);

	// REQUEST
		$htmlBodyText = '
				<center>
					<img src="cid:Delivery" height="100" width="100" style="border-radius: 50%" />
					<br/><br/>

					<table border="1" style="font-family: Helvetica, sans-serif; font-size: 11px;" width="700">
					<thead>
						<tr>
							<th style="background-color: #dd4b39; color: #fff; width: 10%"><p align="center">#</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">CONTROL NO.</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 30%"><p align="center">PART NO.</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 10%"><p align="center">REV</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 10%"><p align="center">QTY</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">SUPPLIER</p></th>
						</tr>
					</thead>
			';

		$sql = "SELECT part_no,rev, qty, supplier FROM tbl_idr_request WHERE tbl_idr_id = '$id'; ";
		$result = pg_query($connection, $sql); 
		$counter = 1;
		while($row = pg_fetch_array($result))
		{
			$htmlBodyText .= 
			'
				<tbody>
					<tr>
			 			<td style="width: 10%"><p align="center">'. $counter++ .'</p></td>
			 			<td style="width: 25%"><p align="center">'. $controlno .'</p></td>
			 			<td style="width: 25%"><p align="center">'. $row[0] .'</p></td>
			 			<td style="width: 20%"><p align="center">'. $row[1] .'</p></td>
			 			<td style="width: 20%"><p align="center">'. $row[2] .'</p></td>
			 			<td style="width: 25%"><p align="center">'. $row[3] .'</p></td>
					</tr>
				</tbody>
			';
		}
		$htmlBodyText .= '</table>';

	// ATTACHMENTS
		$htmlBodyText .= '
				<br/><br/>

				<table border="1" style="font-family: Helvetica, sans-serif; font-size: 11px;" width="700">
				<thead>
					<tr>
						<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">#</p></th>
						<th style="background-color: #dd4b39; color: #fff; width: 50%"><p align="center">FILE NAME</p></th>
						<th style="background-color: #dd4b39; color: #fff; width: 30%"><p align="center">LOCATION</p></th>
					</tr>
				</thead>
		';

		$sqla = "SELECT filename, location FROM tbl_idr_attachment WHERE tbl_idr_id = '$id'; ";
		$resulta = pg_query($connection, $sqla); 
		$countera = 1;
		while($row = pg_fetch_array($resulta))
		{
			$htmlBodyText .= 
			'
				<tbody>
					<tr>
			 			<td style="width: 10%"><p align="center">'. $countera++ .'</p></td>
			 			<td style="width: 25%"><p align="center">'. $row[0] .'</p></td>
			 			<td style="width: 20%"><p align="center"><a href="http://10.164.30.173/Purchasingv2/application/view/'. $row[1] .'">Click Here</a></p></td>
					</tr>
				</tbody>
			';
		}
		$htmlBodyText .= '</table>';


	$htmlBodyText .= 
	'		
			<br/>
			
			<a href="http://10.164.30.173/Purchasingv2/" style="font-style: italic; color: #dd4b39; font-family: Courier New;">Come and visit us! Just click here</a>
			
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
