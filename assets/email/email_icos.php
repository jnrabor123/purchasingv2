<?php

	require 'email_header.php';
	
	$type = $_POST["type"];
	$generate_code = $_POST["generate_code"];
	$section = $_POST['section'];

	$where = '';

	switch ($section) 
	{
		case 'PURCHASING':
			$where = "employee_section = 'purchasing' AND employee_group = 'DELIVERY' ";
			break;
		case 'PRESS':
			$where = "employee_section = 'press' ";
			break;
		case 'PC':
			$where = "employee_section = 'pc' ";
			break;

		default:
			$where = "employee_section = 'admin' ";
	}

	$data = array();

	// EMAIL
		$sql = "SELECT employee_email, employee_position FROM employee_accounts WHERE " . $where . " AND employee_status = 'active' AND employee_position != 'staff' ";
		$result = pg_query($connection, $sql); 
		while($row = pg_fetch_array($result))
		{
			$mail->AddAddress($row[0]);
		}
	
	$mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

	//SUBJECT
	$mail->Subject = "ICOS - NOTIFICATION";

	//EMBEDDED IMAGE
	$mail->AddEmbeddedImage('images/purlogo.png', 'Kartka');
	$mail->AddEmbeddedImage('images/sms.png', 'Message');

	//BODY
	$mail->isHTML(true);

	// REQUEST
		$htmlBodyText = '
				<center>
					<img src="cid:Message" height="120" width="150" />
					<br/><br/>

		            <p style="text-indent: 50px; font-family: Courier New;">Good Day! You have ' . $type . ' request that needs your approval.
			';

	$htmlBodyText .= 
	'		
			<br/><br/><br/>
			
			<a href="http://10.164.30.173/purchasingv2/assets/generate/generate.php?code=' . $generate_code . '" target="_blank" style="font-style: italic; color: #dd4b39; font-family: Courier New;">Come and visit us! Just click here</a>
			
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
