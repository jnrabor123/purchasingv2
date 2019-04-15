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
			$query = "SELECT a.id, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.status, a.file_upload
				FROM tbl_request_slip a
				INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
				ORDER BY a.id DESC; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_dashboard_partno()
		{
			$query = "SELECT a.id, c.part_no, c.rev, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.status, a.file_upload
				FROM tbl_request_slip a
				INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
				INNER JOIN tbl_request_details c ON (a.id = c.tbl_request_slip_id)
				ORDER BY a.id; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_generate($code)
		{
			$query = "SELECT a.id as id, a.control_no, c.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.status, a.status,
			b.part_no, b.rev, b.quantity, b.po_no, b.po_code, b.receipt_no, b.prod_code_no, b.delivery_date, b.supplier_answer, b.reason, b.id as id2,
			c.employee_section
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
			$query = "SELECT a.id, a.control_no, c.employee_email, c.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.status as a_status, a.date_approved_by_purchasing, a.date_received_by, a.rejected_by, a.date_rejected, a.email_by, a.email_date, a.rejected_reason,
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
			$query = "SELECT a.id, a.control_no, b.employee_name, a.request_date, a.request_type, a.supplier, a.approved_by_purchasing, a.received_by, a.status, a.file_upload
				FROM tbl_request_slip a
				INNER JOIN employee_accounts b ON (CAST(a.incharge AS integer) = b.id)
				WHERE a.status = 'FOR RECEIVING - PC'
				ORDER BY a.id DESC; ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_approver($section)
		{
			if($section == 'purchasing')
				$query = "SELECT * FROM employee_accounts WHERE employee_status = 'active' AND employee_position != 'staff' AND employee_section = '$section' AND employee_group = 'DELIVERY' ";
			else
				$query = "SELECT * FROM employee_accounts WHERE employee_status = 'active' AND employee_position != 'staff' AND employee_section = '$section' ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$data = $stmt->fetchAll();
			return $data;
		}

		public function load_incharge()
		{
			$query = "SELECT * FROM employee_accounts WHERE employee_status = 'active' AND employee_section = 'pc' AND employee_group = 'INCHARGE' ORDER BY id ";
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

		public function rejected_by_pc($data, $where, $id)
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
					AND tbl_request_slip.id = ?; ";
				$stmt = $this->conn->prepare($query);
				$update_details = $stmt->execute([$id]);

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

		public function save_email($data, $where)
		{

			return $this->db->update('tbl_request_slip', $data, $where);
		}

}