<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class BillingModel extends MasterModel
{

// fetch table data
	public function getSelectServicesData($tableName)
	{
		$query = "select * from " . $tableName . " group by service_name ";
		return parent::_rawQuery($query);
	}
	public function getSelectServicesDescriptionData($tableName,$service_no)
	{
		$query = "select * from " . $tableName . " where service_no='".$service_no."' ";
		return parent::_rawQuery($query);
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

	public function getSelectCompaniesData($tableName)
	{
		return $this->_select($tableName, array("status" => 1), "*", false);
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


public function getPatients($patientTable,$billing_transaction)
	{

			return $this->_select("".$billing_transaction." o", array("o.type" => 3,"o.confirm"=>0, "o.is_deleted" => 1, "o.branch_id" => $this->session->user_session->branch_id,"o.(service_category)!="=>"('ACCOMM','RADIOLOGY','PATHOLOGY')"),
			array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id"), false, "o.patient_id");
	}


}

