<?php

	require 'email_header.php';

	$section = ['purchasing', 'press', 'pc'];

	for ($i=0; $i < count($section); $i++) 
	{ 

		switch ($section[$i]) 
		{
			case 'purchasing':
				$where = "employee_section = 'purchasing' AND employee_group = 'DELIVERY' ";
				break;
			case 'press':
				$where = "employee_section = 'press' ";
				break;
			case 'pc':
				$where = "employee_section = 'pc' ";
				break;

			default:
				$where = "employee_section = 'admin' ";
		}

		$mail->ClearAddresses();
		
		// EMAIL
			$sql = "SELECT employee_email, employee_position FROM employee_accounts WHERE " . $where . " AND employee_status = 'active' AND employee_position != 'staff' ";
			$result = pg_query($connection, $sql); 
			while($row = pg_fetch_array($result))
			{
				$mail->AddAddress($row['employee_email']);
			}
		
		$mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

		//SUBJECT
		$mail->Subject = "ICOS - NOTIFICATION";

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
								<th style="background-color: #dd4b39; color: #fff; width: 5%; "><p align="center">#</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 10%; "><p align="center">Control No.</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 15%; "><p align="center">Requestor</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 13%; "><p align="center">Date</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 12%; "><p align="center">Type</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 15%; "><p align="center">Supplier</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 20%; "><p align="center">Status</p></th>
								<th style="background-color: #dd4b39; color: #fff; width: 10%; "><p align="center">Generate</p></th>
							</tr>
						</thead>
				';

			$sql = "SELECT a.id, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.status, a.generate_code
					FROM tbl_request_slip a
					INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
					WHERE a.status = 'FOR APPROVAL - " . strtoupper($section[$i]) . "'
					ORDER BY a.id;
					 ";
			$result = pg_query($connection, $sql); 
			$counter = 1;
			while($row = pg_fetch_assoc($result))
			{
				$htmlBodyText .= 
				'
					<tbody>
						<tr>
				 			<td style="width: 5%; "><p align="center">'. $counter++ .'</p></td>
				 			<td style="width: 10%; "><p align="center">'. $row["control_no"] .'</p></td>
				 			<td style="width: 15%; "><p align="center">'. $row["employee_name"] .'</p></td>
				 			<td style="width: 13%; "><p align="center">'. $row["request_date"] .'</p></td>
				 			<td style="width: 12%; "><p align="center">'. $row["request_type"] .'</p></td>
				 			<td style="width: 15%; "><p align="center">'. $row["supplier"] .'</p></td>
				 			<td style="width: 20%; "><p align="center">'. $row["status"] .'</p></td>
				 			<td style="width: 10%; "><p align="center">'. '<a href="http://10.164.30.173/purchasingv2/assets/generate/generate.php?code=' . $row['generate_code'] . '" target="_blank" style="font-style: italic; color: #dd4b39; font-family: Courier New;"> Click Here</a>' .'</p></td>
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
	}

	$data = array();


// echo json_encode($data);

	echo "<script>window.close();</script>"; 
