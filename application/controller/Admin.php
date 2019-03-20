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

require_once APPPATH.'model/Admin_m.php';

class Admin 
{
	public $action;
	public $admin;
	
	public function __construct() {
		$this->action = $_GET['action'];

		$this->admin = new Admin_m();		
	}
	
	public function load_user()
	{
		$data = $this->admin->load_user();
		return $data;
	}
	
	public function load_user_details()
	{
		$id = $_POST['id'];
		$data = $this->admin->load_user_details($id);
		return $data;
	}
	
	// NOTE: table column  => S_POST[""] 

	public function insert_user()
	{
		$data =
		[
			'firstname'	=> $_POST['firstname'],
			'lastname'	=> $_POST['lastname'],
			'age'		=> $_POST['age'],
			'birthdate'	=> $_POST['birthdate'],
			'sex'		=> $_POST['sex'],
			'status'	=> $_POST['status']
		]; 
		return $this->admin->insert_user($data);
	}
	
	public function update_user()
	{
		$data = 
		[
			'firstname'	=> $_POST['firstname'],
			'lastname'	=> $_POST['lastname'],
			'age'		=> $_POST['age'],
			'birthdate'	=> $_POST['birthdate'],
			'sex'		=> $_POST['sex'],
			'status'	=> $_POST['status']
		];
		
		$where = 
		[
			'id =' => $_POST['id']
		];
		
		return $this->admin->update_user($data, $where);
	}
	
	public function delete_user()
	{	
		$where =
		[
			'id =' => $_POST['id']
		];
		
		return $this->admin->delete_user($where);
		// return $where;
	}
}


$admin = new Admin();

if($admin->action == 'load_user')
{
	$data = $admin->load_user();
	echo json_encode($data);
}
else if($admin->action == 'load_user_details')
{
	$data = $admin->load_user_details();
	echo json_encode($data);
}
else if($admin->action == 'insert_user')
{

	echo $data = $admin->insert_user();
}
else if($admin->action == 'update_user')
{

	echo $data = $admin->update_user();
}
else if($admin->action == 'delete_user')
{
	$data = $admin->delete_user();
	echo json_encode($data);
}

