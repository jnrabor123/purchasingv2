<?php

	require 'email_header.php';
	
	$u = $_POST['u'];
	$p = $_POST['u'];
	$control_no = $_POST['control_no'];

	$data = array();
	
	$mail->AddBCC("jerwyn.rabor@ph.fujitsu.com");

	//SUBJECT
	$mail->Subject = "ICOS - NOTIFICATION";

	//EMBEDDED IMAGE
	$mail->AddEmbeddedImage('images/purlogo.png', 'Kartka');
	$mail->AddEmbeddedImage('images/message.jpg', 'Message');

	//BODY
	$mail->isHTML(true);

	// REQUEST
		$htmlBodyText = '
				<center>
					<img src="cid:Message" height="130" width="150" />
					<br/><br/>
		            <p style="font-family: Courier New;">You have new request
		            <br/>
		            <p style="font-family: Courier New; font-weight: bold;">CONTROL NO: ' . $control_no . '</p>
			';

	$htmlBodyText .= 
	'		
			<br/><br/>
			
			<a href="http://10.164.30.173/purchasingv2/assets/auto_login/magic.php?u:=' . $u . '&p:=' . $p . '" target="_blank" style="font-style: italic; color: #dd4b39; font-family: Courier New; pointer-events: none; cursor: default;">Come and visit us! Just click here</a>
			
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
