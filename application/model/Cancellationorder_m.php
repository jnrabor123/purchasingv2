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


class Cancellationorder_m extends FDTP_Model
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		$this->db = $db;
		parent::__construct($this->db);
	}

	// SELECT
		public function load_dashboard()
		{
			$query = "SELECT a.id, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.approved_by_pc, a.status
				FROM tbl_request_slip a
				INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
				ORDER BY a.id DESC; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_generate($code)
		{
			$query = "SELECT a.id as id, a.control_no, c.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.approved_by_pc, a.status, a.rejected_by, a.status,
			b.part_no, b.rev, b.quantity, b.po_no, b.po_code, b.receipt_no, b.prod_code_no, b.delivery_date, b.supplier_answer, b.reason, b.id as id2
			FROM tbl_request_slip a
			INNER JOIN tbl_request_details b ON (a.id = b.tbl_request_slip_id)
			INNER JOIN employee_accounts c ON (CAST(a.incharge AS integer) = c.id)
			WHERE a.generate_code = ?
			AND a.status != 'REJECTED - PURCHASING'
			AND a.status != 'REJECTED - PC'
			AND b.status != 'REMOVED'
			ORDER BY b.id; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute([$code]);
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_generate_by_id($id)
		{
			$query = "SELECT a.id, a.control_no, c.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.approved_by_pc, a.status as a_status,
			b.part_no, b.rev, b.quantity, b.po_no, b.po_code, b.receipt_no, b.prod_code_no, b.delivery_date, b.supplier_answer, b.reason, b.status
			FROM tbl_request_slip a
			INNER JOIN tbl_request_details b ON (a.id = b.tbl_request_slip_id)
			INNER JOIN employee_accounts c ON (CAST(a.incharge AS integer) = c.id)
			WHERE a.id = ?
			ORDER BY b.id; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute([$id]);
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_dashboard_by_receiving()
		{
			$query = "SELECT a.id, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.approved_by_pc, a.status
				FROM tbl_request_slip a
				INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
				WHERE a.status = 'FOR RECEIVING - PC'
				ORDER BY a.id DESC; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

	// UPDATE
		public function approved_by_purchasing($data, $where)
		{

			return $this->db->update('tbl_request_slip', $data, $where);
		}

		public function rejected_by_purchasing($data, $where, $generate_code)
		{
			try
			{
				$this->conn->beginTransaction();

				$update_slip = $this->db->update('tbl_request_slip', $data, $where);

				$query = "
					UPDATE tbl_request_details
					SET status = 'REMOVED'
					FROM tbl_request_slip
					WHERE 
					tbl_request_details.tbl_request_slip_id =  tbl_request_slip.id
					AND tbl_request_slip.generate_code = ?; ";
				$stmt = $this->conn->prepare($query);
				$update_details = $stmt->execute([$generate_code]);

				return $this->conn->commit();
			}
			catch (Exception $e) 
			{
				return $this->conn->rollback();
			}
		}

		public function remove_item($data, $where)
		{

			return $this->db->update('tbl_request_details', $data, $where);
		}

		public function received_pc_incharge($data, $where, $data2, $where2)
		{
			try
			{
				$this->conn->beginTransaction();

				$this->db->update('tbl_request_slip', $data, $where);
				$this->db->update('tbl_request_details', $data2, $where2);

				return $this->conn->commit();
			}
			catch(Exception $e)
			{
				return $this->conn->rollback();
			}
		}

}