<?php
	require '../vendor/phpmailer/class.phpmailer.php';
	
	$mail              = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug   = 0;
	$mail->Debugoutput = 'html';

	$mail->Mailer      = "smtp";
	$mail->SMTPAuth    = false;                 
	$mail->Port        = 25;                    
	$mail->Host        = "10.165.35.105"; 
	$mail->setFrom('purchasingv2@ph.fujitsu.com','PURCHASING');

	define('DB_HOST', '10.164.30.166'); 
	define('DB_NAME', 'purchasing'); 
	define('DB_USER', 'postgres'); 
	define('DB_PASSWORD', '@ssy3#');

	$connection = pg_connect("host=10.164.30.166 port=5432 dbname=purchasing user=postgres password=@ssy3#");

?>