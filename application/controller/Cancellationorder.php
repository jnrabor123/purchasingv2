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

require_once APPPATH.'model/Cancellationorder_m.php';

class Cancellationorder 
{
	public $action;
	public $cancellationorder;
	
	public function __construct() 
	{
		$this->action = $_GET['action'];

		$this->cancellationorder = new Cancellationorder_m();		
	}

	// LOAD
		public function load_dashboard()
		{
			$data = $this->cancellationorder->load_dashboard();
			return $data;
		}

		public function load_generate()
		{
			$code = $_POST['code'];
			$data = $this->cancellationorder->load_generate($code);
			return $data;
		}

		public function load_generate_by_id()
		{
			$id = $_POST['id'];
			$data = $this->cancellationorder->load_generate_by_id($id);
			return $data;
		}

		public function load_dashboard_by_receiving()
		{
			$data = $this->cancellationorder->load_dashboard_by_receiving();
			return $data;
		}

	// UPDATE
		public function approved_by_purchasing()
		{
			$data = 
			[
				'approved_by_purchasing'	=>	$_POST['name'],
				'date_approved_by_purchasing'	=>	date('Y-m-d H:i'),
				'status'	=>	"FOR RECEIVING - PC"

			];
			
			$where = 
			[
				'generate_code =' => $_POST['code']
			];
			
			return $this->cancellationorder->approved_by_purchasing($data, $where);
		}

		public function rejected_by_purchasing()
		{
			$generate_code = $_POST['code'];

			$data = 
			[
				'date_rejected'	=>	date('Y-m-d H:i'),
				'rejected_by'	=>	$_POST['name'],
				'status'	=>	"REJECTED"

			];
			
			$where = 
			[
				'generate_code =' => $generate_code
			];
			
			return $this->cancellationorder->rejected_by_purchasing($data, $where, $generate_code);
		}

		public function remove_item()
		{
			$data = 
			[
				'status'	=>	"REMOVED"
			];
			
			$where = 
			[
				'id =' => $_POST['id']
			];
			
			return $this->cancellationorder->remove_item($data, $where);
		}

		public function received_pc_incharge()
		{
			$data = 
			[
				'received_by' => $_POST['incharge'],
				'date_received_by' => date('Y-m-d H:i'),
				'status' => 'RECEIVED AND ENCODED'
			];

			$where = 
			[
				'id =' => $_POST['id']

			];

			$data2 = 
			[
				'status' => 'RECEIVED'
			];
			

			$where2 = 
			[
				'tbl_request_slip_id =' => $_POST['id'],
				' status =' => 'WAITING'

			];
			
			return $this->cancellationorder->received_pc_incharge($data, $where, $data2,  $where2);
		}


	
}


$cancellationorder = new Cancellationorder();
$data = array();

if($cancellationorder->action == 'load_dashboard')
{
	$data = $cancellationorder->load_dashboard();
	echo json_encode($data);
}
else if($cancellationorder->action == 'load_generate')
{
	$data = $cancellationorder->load_generate();
	echo json_encode($data);
}
else if($cancellationorder->action == 'load_generate_by_id')
{
	$data = $cancellationorder->load_generate_by_id();
	echo json_encode($data);
}
else if($cancellationorder->action == 'approved_by_purchasing')
{
	$data = $cancellationorder->approved_by_purchasing();
	echo json_encode($data);
}
else if($cancellationorder->action == 'rejected_by_purchasing')
{
	$data = $cancellationorder->rejected_by_purchasing();
	echo json_encode($data);
}
else if($cancellationorder->action == 'remove_item')
{
	$data = $cancellationorder->remove_item();
	echo json_encode($data);
}
else if($cancellationorder->action == 'load_dashboard_by_receiving')
{
	$data = $cancellationorder->load_dashboard_by_receiving();
	echo json_encode($data);
}
else if($cancellationorder->action == 'received_pc_incharge')
{
	$data = $cancellationorder->received_pc_incharge();
	echo json_encode($data);
}