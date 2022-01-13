<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class StaffModel extends MasterModel
{

// fetch table data
	public function getSelectOptionsData($tableName)
	{
		$query = "select * from " . $tableName . "";
		return parent::_rawQuery($query);
	}
	public function getSelectWhereData($tableName,$where)
	{
		$query = "select * from " . $tableName . " ".$where;
		return parent::_rawQuery($query);
	}
	public function addForm($tableName, $formData,$staff_table,$staff_insert)
	{

		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($tableName, $formData);
			$resultObject->inserted_id = $this->db->insert_id();
			unset($formData['company_id']);
			unset($formData["is_icu_patient"]);
			unset($formData["type"]);
			unset($formData["branch_id"]);

			if($resultObject->inserted_id){
				// set($staff_insert["patient_id"],$resultObject->inserted_id);
				$staff_insert["patient_id"] = $resultObject->inserted_id;
				$this->db->insert($staff_table, $staff_insert);
			}
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

	public function getTableData($tableName, $where)
	{

		$query = " select dm.* from " . $tableName . " dm " . $where . "";
		return parent::_rawQuery($query);

	}

	public function deletePatient($table, $formData, $where)
	{
		return $this->_update($table, $formData, $where);
	}

	public function updateForm($tableName, $formData, $where,$staff_table,$staff_insert,$staff_where)
	{
		try {
			$this->db->trans_start();
			$this->db->set($formData)->where($where)->update($tableName);
			unset($formData["is_icu_patient"]);
			unset($formData["modify_on"]);
			unset($formData["modify_by"]);
			$this->db->set($formData)->where(array("adhar_no" => $formData["adhar_no"]))->update("patient_master");
			$this->db->set($staff_insert)->where($staff_where)->update($staff_table);
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

