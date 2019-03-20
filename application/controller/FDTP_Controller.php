<?php 



class FDTP_Controller{

	public $route;

	public function __construct()
	{
		$this->route = "../config/route.php";
		session_start();
	}

}

$FDTP_Controller = new FDTP_Controller();