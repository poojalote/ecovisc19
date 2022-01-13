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
				'd.p_id',
				'd.name',
				'(select medicine_master.name from medicine_master where id=d.name) as m_name',
				'd.start_date',
				'd.end_date',
				'd.total_iteration',
				'd.remark',
				'd.flowRate_chk',
				'd.flowRate_text',
				'd.route',
				'd.quantity',
				'(select GROUP_CONCAT(co.confirm_status,"||",co.order_status,"||",(case WHEN co.alt_medicine is null then 0 else co.alt_medicine end)) from com_1_medicine_order co where d.name=co.medicine_id and co.patient_id=d.p_id) as order_status',
				'(select group_concat(h.iteration_count, "|",iteration_on,"|",iteration_time,"|",(case WHEN iteration_outime is null then 0 else iteration_outime end),"|",out_status order by h.iteration_count ) from ' . $dose_history_table . ' h where h.p_id=p_id and h.status=1 and h.does_details_id=d.id) as ite_details',
				'(SELECT group_concat(rm.medicine_id,"|",rm.medicine_date,"|",rm.reschedule_iteration) FROM ' . $patient_reschedule_medicine_table . ' rm where rm.patient_id = d.p_id and rm.medicine_id = d.name and rm.status=1) as reschedule_medicine',
				'd.active'
			))
				->where(array('p_id' => $pid,'branch_id'=>$branch_id))
				->get($dose_details_table . ' d')
				->result();
			//print_r($dose_history_table);exit();
			$object->query = $this->db->last_query();
			return $object;
		} catch (Exception $exc) {
			return array();
		}
	}

	public function add_icu_does_iteration($data, $patient_medicine_history_table)
	{
		$result = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($patient_medicine_history_table, $data);
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

	public function update_icu_does_iteration($data, $patient_medicine_history_table,$where)
	{
		$result = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->update($patient_medicine_history_table, $data,$where);
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
