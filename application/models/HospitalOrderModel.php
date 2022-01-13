<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class HospitalOrderModel extends MasterModel
{

// fetch table data
	public function getSelectMaterialGroupData($tableName)
	{
		$query = "select * from " . $tableName;
		return parent::_rawQuery($query);
	}
	public function getSelectServicesDescriptionData($tableName,$service_no)
	{
		$query = "select * from " . $tableName . " where service_no='".$service_no."' ";
		return parent::_rawQuery($query);
	}
	public function getViewOrderData($grouptableName,$materialItemtableName,$where)
	{
		return $this->_select("branch_master cm", $where, array("cm.*", "(select count(dm.id) from departments_master dm where dm.company_id=cm.id) as departments"), false);
	}
	public function getSelectMaterialDescription($tableName,$id)
	{
		return $this->_select($tableName, array("id" => $id), "*", true);
	}
	public function getSelectServicesRateData($tableName, $id)
	{
		// $query = "select * from " . $tableName . " where id='".$id."' " ;
		// return parent::_rawQuery($query);
		return $this->_select($tableName, array("id" => $id), "*", false);
	}
	public function billing_history($tableName, $patient_id)
	{
		 //$query = "select bm.*,(select sm.service_name from service_master sm where sm.id=bm.service_id) as service_name,(select sm.service_description from service_master sm where sm.id=bm.service_id) as service_desc from " . $tableName . " bm where bm.patient_id=".$patient_id." AND bm.status=1  order by bm.id desc" ;
//		$query = "select bm.*,(select sm.service_name from service_master sm where sm.id=bm.service_id) as service_name,
//				   (select sm.service_description from service_master sm where sm.id=bm.service_id) as service_desc,
//				   (select sm.service_category from service_master sm where sm.id=bm.service_id) as service_category
//				from " . $tableName . " bm where bm.patient_id=".$patient_id." AND bm.status=1 order by bm.id desc" ;
		$query="select bm.*, (case when type = 0 then
						(select sm.service_description from service_master sm where sm.id=bm.service_id)
                        else 
                        bm.service_desc end) as service_description                
				from ".$tableName." bm where bm.patient_id=".$patient_id." AND bm.status=1 order by bm.id desc";
		return parent::_rawQuery($query);
		// return $this->_select($tableName, array("patient_id" => $patient_id), "*", false);
	}
	
	public function getTableData($where)
	{
		return $this->_select("departments_master dm", $where, array("dm.*", "(SELECT cm.name from company_master cm where cm.id=dm.company_id) as company_name "), false);
	}

	


	public function selectDataById($tableName, $where)
	{
		$query = "select * from " . $tableName . " " . $where;
		return parent::_rawQuery($query);
	}

	public function selectCompanyWithDepartment($where)
	{
		return $this->_select("branch_master cm", $where, array("cm.*", "(select count(dm.id) from departments_master dm where dm.company_id=cm.id) as departments"), false);
	}

	public function addForm($tableName, $formData)
	{
		try {
			$this->db->trans_start();
			
				$this->db->insert($tableName, $formData);
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

	public function updateForm($tableName, $formData, $where)
	{
		try {
			$this->db->trans_start();
			$this->db->set($formData)->where($where)->update($tableName);
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
	
	public function reveseMedicineData($data,$id){
		try {
			$this->db->trans_start();
			$formData=array("status"=>0);
			$where=array("id"=>$id);
			$update=$this->db->set($formData)->where($where)->update("patient_medicine_order_consume");
			if($update == true){
				$this->db->insert("patient_medicine_order_consume",$data);
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
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			$result = FALSE;
		}
		return $result;
	}
	
	public function returnMedicineData($order_id,$data2){
		
		
		try {
			$this->db->trans_start();
			/* $insert=$this->db->insert('hospital_order_management',$data);
			$insert_id = $this->db->insert_id();
			$data2['retrun_order_id']=$insert_id;
			if($insert == true){
			$hospital_order_no = 'RET_' . $insert_id;
			$update_data = array('return_order_id' => $hospital_order_no);
			$this->db->where('id', $insert_id);
			$update = $this->db->update("hospital_order_management", $update_data);
			} */
			$insert=$this->db->insert('hospital_material_item_table',$data2);
			
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
public function getRoomOrderData($p_id){
	$query=$this->db->query("select * ,
	(select service_name from service_master sm where sm.service_id= ord.service_id
	)as service_name from oder_room_table ord
	where ord.patient_id='$p_id'
	");
	if($this->db->affected_rows() > 0){
		return $query->result();
	}else{
		return false;
	}
}

public function placeHospitamMaterialListOrder($tableName, $formData)
	{
		try {
			$this->db->trans_start();

			$this->db->insert_batch($tableName, $formData);
			// if  py / ra
			// fore to check   index 2
			/// if  index 1  = index 2

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





}

