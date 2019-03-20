<?php


require_once APPPATH.'config/database.php';

//this loop will execute the connection
//DO NOT EDIT THIS SECTION
//PLEASE!
foreach($db as $key => $row)
{
	$dsn = $row['dbdriver'].':host='.$row['hostname'].';dbname='.$row['database'];
	$opt = [
		PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE 	=> PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES 		=> false,
	];

	try
	{
		${$key} = new PDO($dsn,$row['username'],$row['password'],$opt);
	}
	catch(PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
	}
}