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


class Pricecontrol_m extends FDTP_Model
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		$this->db = $db;
		parent::__construct($this->db);
	}

	public function load_pricerequest()
	{
		$query = " ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}
	
}