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


class Deliveryreceipt_m extends FDTP_Model
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		$this->db = $db;
		parent::__construct($this->db);
	}

	// SELECT

	public function load_data()
	{
		// $query = "SELECT * FROM tbl_idr WHERE status = 'FOR RECEIVING' ORDER BY id DESC; ";
		$query = "SELECT a.id, a.attention, a.employee_no, a.control_no, a.status, a.request_date, b.employee_name FROM public.tbl_idr a
					LEFT JOIN employee_accounts b
					ON (SPLIT_PART(a.attention, '/', 1) = b.employee_email)
					WHERE a.status = 'FOR RECEIVING' ORDER BY a.id DESC; ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_data_details($id)
	{
		$query = "SELECT * FROM tbl_idr_request WHERE tbl_idr_id = ? AND status = 'WAITING' ORDER BY id; ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_data_attachment($id)
	{
		$query = "SELECT * FROM tbl_idr_attachment WHERE tbl_idr_id = ? ORDER BY id; ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_monitoring_remarks($id)
	{
		$query = "SELECT remarks FROM tbl_idr WHERE id = ?; ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_monitoring()
	{
		// $query = "SELECT * FROM tbl_idr ORDER BY id DESC; ";
		$query = "SELECT a.id, a.employee_no, b.employee_name, a.control_no, a.status, a.request_date, a.received_date, a.remarks FROM tbl_idr a
				LEFT JOIN employee_accounts b
				ON (SPLIT_PART(a.attention, '/', 1) = b.employee_email)
				ORDER BY id DESC; ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_monitoring_data($id)
	{
		// $query = "SELECT * FROM tbl_idr_request WHERE tbl_idr_id = ? ";
		$query = "SELECT a.id, a.tbl_idr_id, a.part_no, a.rev, a.qty, a.actual, a.supplier, a.dr_inv_no, a.remarks, a.status, a.received_by, a.received_date, c.employee_name FROM tbl_idr_request a
				INNER JOIN tbl_idr b
				ON (a.tbl_idr_id = b.id)
				LEFT JOIN employee_accounts c
				ON (SPLIT_PART(b.attention, '/', 1) = c.employee_email)
				WHERE a.tbl_idr_id = ? ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_return($id)
	{
		$query = "SELECT * FROM tbl_idr_return WHERE tbl_idr_id = ? ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_monitoringrequest()
	{
		$query = "SELECT aa.id, bb.control_no, aa.part_no, aa.rev, aa.supplier, aa.dr_inv_no, aa.remarks, aa.status FROM tbl_idr_request AS aa LEFT JOIN tbl_idr AS bb ON (aa.tbl_idr_id = bb.id) ORDER BY aa.id DESC; ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_receiving_data($id)
	{
		// $query = "SELECT * FROM tbl_idr_request WHERE id = ? ";
		$query = "SELECT a.id, a.tbl_idr_id, a.part_no, a.rev, a.qty, a.actual, a.supplier, a.dr_inv_no, a.remarks, a.status, a.received_by, a.received_date, c.employee_name FROM tbl_idr_request a
				INNER JOIN tbl_idr b
				ON (a.tbl_idr_id = b.id)
				LEFT JOIN employee_accounts c
				ON (SPLIT_PART(b.attention, '/', 1) = c.employee_email)
				WHERE a.id = ? ";
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_attention()
	{
		$query = "SELECT employee_name, employee_email, employee_group FROM employee_accounts WHERE employee_section = 'qc' AND employee_status = 'active'; ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$data = $stmt->fetchAll();
		return $data;
	}

	public function load_cancelapplication($id)
	{
		$query = "SELECT * FROM tbl_idr_cancel WHERE tbl_idr_id = ? ";

		$stmt = $this->conn->prepare($query);
		$stmt->execute([$id]);
		$data = $stmt->fetchAll();
		return $data;
	}

	// INSERT

	public function insert_return($data)
	{

		return $this->db->insert('tbl_idr_return', $data);
	}

	public function insert_cancel($data)
	{

		return $this->db->insert('tbl_idr_cancel', $data);
	}

	// UPDATE

	public function remove_receiving_item($data, $where)
	{

		return $this->db->update('tbl_idr_request', $data, $where);
	}

	public function remove_receiving($data, $where)
	{

		return $this->db->update('tbl_idr', $data, $where);
	}

	public function reapply_application($data, $where)
	{

		return $this->db->update('tbl_idr', $data, $where);
	}

	public function cancelapplication($data, $where)
	{

		return $this->db->update('tbl_idr', $data, $where);
	}

	public function cancelapplication_request($data, $where)
	{

		return $this->db->update('tbl_idr_request', $data, $where);
	}

	
}