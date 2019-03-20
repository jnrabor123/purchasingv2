<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//required
require_once APPPATH.'config/db_init.php';
require_once APPPATH.'library/FDTP_Model.php';
//end required


class Login_m extends FDTP_Model
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		$this->db = $db;
		parent::__construct($this->db);
	}

	public function login($username,$password)
	{
		$query = "SELECT * FROM employee_accounts WHERE employee_no = ? AND employee_password = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$username, $password]);
		
		$user = $stmt->fetch();
		return $user;
	}

	public function insert_user($data)
	{

		return $this->db->insert('employee_accounts', $data);
	}
	

	
	
}