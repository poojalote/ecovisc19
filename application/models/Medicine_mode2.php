<?php

require_once 'MasterModel.php';

class medicine_model extends MasterModel

{
	function __construct()
	{
		parent::__construct();
	}


	function getDoesHistoryOfPatient($pid, $company_id, $dose_details_table, $dose_history_table,$patient_reschedule_medicine_table,$branch_id)
	{

		try {
			$object = new stdClass();
			$object->data = $this->db->select(array(
				'd.id',
				'd.patient_id',
				'd.medicine_id',
				'(select medicine_master.name from medicine_master where id=d.medicine_id) as m_name',
				'd.does_date',
				'd.does_sequence',
				'd.remark',
				'd.does_transaction_date',
				'(SELECT group_concat(rm.medicine_id,"|",rm.medicine_date,"|",rm.reschedule_iteration) FROM ' . $patient_reschedule_medicine_table . ' rm where rm.patient_id = d.patient_id and rm.medicine_id = d.medicine_id) as reschedule_medicine',
				'd.active'
			))
				->where(array('patient_id' => $pid,'branch_id'=>$branch_id))
				->get($dose_details_table . ' d')
				->result();
			//print_r($dose_history_table);exit();
			$object->query = $this->db->last_query();
			return $object;
		} catch (Exception $exc) {
			return array();
		}
	}

	public function add_icu_does_iteration($data, $patient_medicine_table,$where)
	{
		$result = new stdClass();
		try {
			$this->db->trans_start();
				$this->db->where($where);
	       	 	$this->db->update($patient_medicine_table, $data);
			// $this->db->insert($patient_medicine_history_table, $data);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "ICU Paient Does Details Transaction Rollback");
				$result->status = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "ICU Paient Does Details  Transaction Commited");
				$result->status = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			$this->db->trans_rollback();
			$this->db->trans_complete();
			log_message('error', $exc->getMessage());
			$result->status = FALSE;
		}
		return $result;
	}


}
