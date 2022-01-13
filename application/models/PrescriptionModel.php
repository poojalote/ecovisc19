<?php

require_once 'MasterModel.php';
class PrescriptionModel extends MasterModel
{


	public function savePrescription($tableName, $formData)
	{
		try {
			$this->db->trans_start();

			$this->db->insert_batch($tableName, $formData);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert form Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert form Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;

	}
	public function prescription_history($tableName)
	{
		$query="select group_concat(id) as id,name from ".$tableName." group by name";
		return parent::_rawQuery($query);
	}

	public function delete_prescription($tableName,$where)
	{
		$this->db->where($where);
		return $this->db->delete($tableName);
	}
	public function getPrescription($tableName,$where)
	{
		$sql="select * from ".$tableName." ".$where;
		return parent::_rawQuery($sql);
	}
	public function get_med_name($medicine_id){
		$query="select name from medicine_master where id='$medicine_id'";
		$qr=$this->db->query($query);
		if($this->db->affected_rows() > 0){
			return $result=$qr->row();
			
		}else{
			return false;
		}
	}
	public function get_doctors($doctor_id){
		$query="select id,name from users_master where user_type=2 AND id='$doctor_id'";
		$qr=$this->db->query($query);
		if($this->db->affected_rows() > 0){
			return $result=$qr->row();
			
		}else{
			return false;
		}
	}
}
