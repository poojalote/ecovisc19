<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class DashboardModel extends MasterModel
{

// fetch table data
	public function getTableData($patient_table,$billing_transaction,$where)
	{
		$query = "select cp.*,(select sum(bt.final_amount) from ".$billing_transaction." bt 
 where bt.patient_id=cp.id and bt.branch_id=". $this->session->user_session->branch_id." and bt.is_deleted=1 and ((bt.type=3 and bt.confirm=1) or bt.type=1 or bt.type=2 )) as bill_amount 
 from ".$patient_table." cp where cp.branch_id=". $this->session->user_session->branch_id." ".$where." ";
		return $this->db->query($query)->result();
	}

	






}

