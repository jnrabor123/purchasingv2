<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//required
require_once 'FDTP_Controller.php';
require_once $FDTP_Controller->route;
//end required

require_once APPPATH.'model/Login_m.php';

class Login 
{
	public $action;
	public $login;
	
	public function __construct() 
	{
		$this->action = $_GET['action'];

		$this->login = new Login_m();		
	}
	
	public function login($username, $password)
	{
		$result = $this->login->login($username, $password);
		return $result;
	}
	
	// NOTE: table column  => S_POST[""] 

	public function insert_user()
	{
		$data =
		[
			'employee_no'		=> $_POST['idnumber'],
			'employee_password'	=> $_POST['password'],
			'employee_name'		=> $_POST['name'],
			'employee_section'	=> $_POST['section'],
			'employee_position'	=> $_POST['position'],
			'employee_email'	=> $_POST['email'],
			'employee_status'	=> 'active',
			'employee_picture'	=> '../images/user.jpg'
		]; 
		return $this->login->insert_user($data);
	}
	
}


$login = new Login();

if($login->action == 'login')
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$result = $login->login($username,$password);

	$_SESSION["incharge"] = $result["id"];
	$_SESSION["purchasing_id"] = $result["employee_no"];
	$_SESSION["name"] = $result["employee_name"];
	$_SESSION["position"] = strtoupper($result["employee_position"]);
	$_SESSION["employee_picture"] = $result["employee_picture"];
	$_SESSION["section"] = $result["employee_section"];

	echo json_encode($result);

}
else if($login->action == 'insert_user')
{

	echo $data = $login->insert_user();
}


