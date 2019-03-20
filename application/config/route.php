<?php 

require_once "system_name.php";

if(isset($_SERVER['HTTPS']))
{
	$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else
{
	$protocol = 'http';
}

$base_url2 	= $protocol . "://" . $_SERVER['HTTP_HOST'] . '/'.$config['system_name'].'/';
$app_path 	= $_SERVER['DOCUMENT_ROOT'].'/'.$config['system_name'].'/application/';


define('base_url',$base_url2); // links
define('APPPATH',$app_path); // files
