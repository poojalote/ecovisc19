<?php

require_once 'MasterModel.php';

class Patient_Model extends MasterModel
{
	function __construct()
	{
		parent::__construct();
	}

	public function addForm($tableName, $formData)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($tableName, $formData);
			$resultObject->inserted_id = $this->db->insert_id();
			unset($formData['company_id']);
			unset($formData["is_icu_patient"]);
			unset($formData['branch_id']);
			$this->db->insert("patient_master", $formData);
			
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert form Transaction Rollback");
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert form Transaction Commited");
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$resultObject->status = FALSE;
		}
		return $resultObject;
	}
	
	
	public function getpatientdata($id,$table,$branch_id){
		$query=$this->db->query("select * from ".$table." where id='$id'");
		//echo $this->db->last_query();
		if($this->db->affected_rows()> 0){
			$res=$query->row();
			return $res;
		}else{
			return false;
		}
	}
	
	public function delete_insert_data($data_array,$tableName,$patientId){
		try {
			$this->db->trans_start();
			$insert=$this->db->insert("deleted_patients", $data_array);
			
			if($insert== true)
			{
				$where=array("id"=>$patientId);
			$delete=$this->db->delete($tableName,$where);
			}
			
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "insert form Transaction Rollback");
				$status = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "insert form Transaction Commited");
				$status = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$status = FALSE;
		}
		return $status;
	}

	public function getTableData($tableName, $where)
	{

		$query = " select dm.* from " . $tableName . " dm " . $where . "";
		return parent::_rawQuery($query);

	}

	public function deletePatient($table, $formData, $where)
	{
		return $this->_update($table, $formData, $where);
	}

	public function updateForm($tableName, $formData, $where)
	{
		try {
			$this->db->trans_start();
			$this->db->set($formData)->where($where)->update($tableName);
			unset($formData["is_icu_patient"]);
			unset($formData["modify_on"]);
			unset($formData["modify_by"]);
			$this->db->set($formData)->where(array("adhar_no" => $formData["adhar_no"]))->update("patient_master");
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "update form Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "update form Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;
	}

	function _insert($table, $data)
	{
		// print_r($data);exit();
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();

		return $insert_id;


	}

	public function search($table, $condition)
	{
		$this->db->SELECT();
		$this->db->WHERE($condition);
		$user_data = $this->db->get($table)->result_array();
		print_r($user_data);
		exit();
		return $user_data;
	}

	function dischargePatient($patient_table,$dischargeData, $where,$patientID,$bedTable)
	{
		try{
			$this->db->trans_start();
			$patientDetail=$this->_select($patient_table,array("id"=>$patientID),array("bed_id","roomid"));
			if($patientDetail->totalCount > 0){
				$this->db->set(array('status'=>1))->where(array("Id_room"=>$patientDetail->data->roomid,"id"=>$patientDetail->data->bed_id))->update($bedTable);
				$this->db->set($dischargeData)->where($where)->update($patient_table);

			}else{
				$this->db->trans_complete();
				return FALSE;
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				log_message('info', "update form Transaction Rollback");
				$result = FALSE;
			} else {
				$this->db->trans_commit();
				log_message('info', "update form Transaction Commited");
				$result = TRUE;
			}
			$this->db->trans_complete();
		}catch (Exception $exception){
			$result = FALSE;
		}
		return $result;
	}


}
