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


class Admin_m extends FDTP_Model
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		$this->db = $db;
		parent::__construct($this->db);
	}
	
	public function load_user()
	{
		$query = "SELECT id, firstname, lastname, age, birthdate, CASE WHEN sex = '1' THEN 'MALE' ELSE 'FEMALE' END AS sex, CASE WHEN status = '1' THEN 'ACTIVE' ELSE 'DEACTIVATE' END AS status FROM tbl_jerwynmode ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}
	
	public function load_user_details($id)
	{

		$query = "SELECT id, firstname, lastname, age, birthdate, sex, status FROM tbl_jerwynmode WHERE id = ?";

		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}
	
	public function insert_user($data)
	{

		return $this->db->insert('tbl_jerwynmode', $data);
	}
	
	public function update_user($data, $where)
	{

		return $this->db->update('tbl_jerwynmode', $data, $where);
	}

	public function delete_user($where)
	{
		
		return $this->db->delete('tbl_jerwynmode', $where);
	}
	
	
}