<?php

	require 'email_header.php';
	
	$data = array();

	$sqlpur = "SELECT employee_position, employee_email FROM employee_accounts WHERE employee_section = 'qc' AND employee_status = 'active'; ";
	$resultpur = pg_query($connection, $sqlpur); 
	while($rowpur = pg_fetch_array($resultpur))
	{
		if($rowpur[0] == "staff")
			$mail->AddAddress($rowpur[1]);
		else 
			$mail->AddCC($rowpur[1]);
	}
	
	$mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

	//SUBJECT
	$mail->Subject = "IDR - PENDING REQUEST";

	//EMBEDDED IMAGE
	$mail->AddEmbeddedImage('images/purlogo.png', 'Kartka');
	$mail->AddEmbeddedImage('images/pending.jpg', 'Pending');

	//BODY
	$mail->isHTML(true);

	// REQUEST
		$htmlBodyText = '
				<center>
					<img src="cid:Pending" height="120" width="200" />
					<br/><br/>

					<table border="1" style="font-family: Helvetica, sans-serif; font-size: 11px;" width="700">
					<thead>
						<tr>
							<th style="background-color: #dd4b39; color: #fff; width: 10%"><p align="center">#</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 30%"><p align="center">ATTENTION TO</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">CONTROL NO.</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">REQUEST DATE</p></th>
							<th style="background-color: #dd4b39; color: #fff; width: 20%"><p align="center">STATUS</p></th>
						</tr>
					</thead>
			';

		$sql = "SELECT b.employee_name as attention, a.control_no, a.request_date, a.status FROM tbl_idr a 
				INNER JOIN employee_accounts b
				ON (b.employee_email = SPLIT_PART(a.attention, '/', 1))
				WHERE a.status = 'FOR RECEIVING' ORDER BY attention, a.request_date;
				 ";
		$result = pg_query($connection, $sql); 
		$counter = 1;
		while($row = pg_fetch_array($result))
		{
			$htmlBodyText .= 
			'
				<tbody>
					<tr>
			 			<td style="width: 10%"><p align="center">'. $counter++ .'</p></td>
			 			<td style="width: 30%"><p align="center">'. $row[0] .'</p></td>
			 			<td style="width: 20%"><p align="center">'. $row[1] .'</p></td>
			 			<td style="width: 20%"><p align="center">'. $row[2] .'</p></td>
			 			<td style="width: 20%"><p align="center">'. $row[3] .'</p></td>
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
	if($counter > 1)
		$mail->send();


echo json_encode($data);
