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

require_once APPPATH.'model/Deliveryreceipt_m.php';

class Deliveryreceipt 
{
	public $action;
	public $deliveryreciept;
	
	public function __construct() 
	{
		$this->action = $_GET['action'];

		$this->deliveryreciept = new Deliveryreceipt_m();		
	}

	// SELECT

	public function load_data()
	{
		$data = $this->deliveryreciept->load_data();
		return $data;
	}

	public function load_data_details()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_data_details($id);
		return $data;
	}

	public function load_data_attachment()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_data_attachment($id);
		return $data;
	}

	public function load_monitoring()
	{
		$data = $this->deliveryreciept->load_monitoring();
		return $data;
	}

	public function load_monitoringrequest()
	{
		$data = $this->deliveryreciept->load_monitoringrequest();
		return $data;
	}

	public function load_monitoring_data()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_monitoring_data($id);
		return $data;
	}

	public function load_monitoring_remarks()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_monitoring_remarks($id);
		return $data;
	}

	public function load_receiving_data()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_receiving_data($id);
		return $data;
	}
	
	public function load_return()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_return($id);
		return $data;
	}

	public function load_attention()
	{
		$data = $this->deliveryreciept->load_attention();
		return $data;
	}

	public function load_cancelapplication()
	{
		$id = $_POST['id'];
		$data = $this->deliveryreciept->load_cancelapplication($id);
		return $data;
	}

	// INSERT

	public function insert_return()
	{
		$data =
		[
			'tbl_idr_id'	=> $_POST['id'],
			'reason'		=> $_POST['reason'],
			'return_by'		=> $_POST['return_by'],
			'return_date'	=> date('Y-m-d H:i:s')

		]; 
		return $this->deliveryreciept->insert_return($data);
	}

	public function insert_cancel()
	{
		$data =
		[
			'tbl_idr_id'	=> $_POST['id'],
			'reason'		=> $_POST['reason'],
			'cancel_by'		=> $_POST['cancel_by'],
			'cancel_date'	=> date('Y-m-d H:i:s')
		]; 
		return $this->deliveryreciept->insert_cancel($data);
	}

	// UPDATE

	public function remove_receiving_item()
	{
		$data = 
		[
			'status'		=> "NOT RECEIVED",
			'actual'		=> 0,
			'received_by'	=> $_SESSION["name"],
			'received_date'	=> date('Y-m-d H:i')

		];
		
		$where = 
		[
			'id =' => $_POST['id']
		];
		
		return $this->deliveryreciept->remove_receiving_item($data, $where);
		// return $_POST['id'];
	}

	public function remove_receiving()
	{
		$data = 
		[
			'status'	=> "RETURNED",
			'received_date'	=> date('Y-m-d H:i')
		];
		
		$where = 
		[
			'id =' => $_POST['id']
		];
		
		return $this->deliveryreciept->remove_receiving($data, $where);
	}

	public function reapply_application()
	{
		$data = 
		[
			'status'		=> "FOR RECEIVING",
			'received_date' => null
		];
		
		$where = 
		[
			'id =' => $_POST['id']
		];
		
		return $this->deliveryreciept->reapply_application($data, $where);
	}

	public function cancelapplication()
	{
		$data = 
		[
			'status' => "CANCELLED"
		];
		
		$where = 
		[
			'id =' => $_POST['id']
		];
		
		return $this->deliveryreciept->cancelapplication($data, $where);
	}

	public function cancelapplication_request()
	{
		$data = 
		[
			'status'	=> "CANCELLED"
		];
		
		$where = 
		[
			'tbl_idr_id =' => $_POST['id']
		];
		
		return $this->deliveryreciept->cancelapplication_request($data, $where);
	}
	
}


$deliveryreciept = new Deliveryreceipt();
$data = array();

if($deliveryreciept->action == 'load_data')
{
	$data = $deliveryreciept->load_data();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_data_details')
{
	$data = $deliveryreciept->load_data_details();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_data_attachment')
{
	$data = $deliveryreciept->load_data_attachment();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_monitoring')
{
	$data = $deliveryreciept->load_monitoring();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'remove_receiving_item')
{
	$data = $deliveryreciept->remove_receiving_item();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'remove_receiving')
{
	$data = $deliveryreciept->remove_receiving();
	$data = $deliveryreciept->insert_return();

	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_monitoring_data')
{
	$data = $deliveryreciept->load_monitoring_data();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_return')
{
	$data = $deliveryreciept->load_return();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_monitoringrequest')
{
	$data = $deliveryreciept->load_monitoringrequest();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_receiving_data')
{
	$data = $deliveryreciept->load_receiving_data();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_attention')
{
	$data = $deliveryreciept->load_attention();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_monitoring_remarks')
{
	$data = $deliveryreciept->load_monitoring_remarks();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'reapply_application')
{
	$data = $deliveryreciept->reapply_application();
	echo json_encode($data);
}
else if($deliveryreciept->action == 'cancelapplication')
{
	$data = $deliveryreciept->cancelapplication();
	$data = $deliveryreciept->insert_cancel();
	$data = $deliveryreciept->cancelapplication_request();

	echo json_encode($data);
}
else if($deliveryreciept->action == 'load_cancelapplication')
{
	$data = $deliveryreciept->load_cancelapplication();
	echo json_encode($data);
}






