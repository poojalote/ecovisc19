<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class ServiceOrderModel extends MasterModel
{

// fetch table data
	public function getSelectServicesData($tableName, $where)
	{
		$query = "select * from " . $tableName . " " . $where . " group by service_name ";
		return parent::_rawQuery($query);
	}

	public function getStandardLabServicesData($tableName, $where)
	{
		$query = "select * from " . $tableName . " " . $where . "";
		return parent::_rawQuery($query);
	}

	public function getSelectServicesDescriptionData($tableName, $where)
	{
		return $this->_select($tableName,$where,"*",false);
	}

	public function getSelectServicesRateData($tableName, $id)
	{
		// $query = "select * from " . $tableName . " where id='".$id."' " ;
		// return parent::_rawQuery($query);
		return $this->_select($tableName, array("service_id" => $id), "*", false);
	}

	public function service_order_history($tableName, $where)
	{
		//$query = "select bm.*,(select sm.service_name from service_master sm where sm.id=bm.service_id) as service_name,(select sm.service_description from service_master sm where sm.id=bm.service_id) as service_desc from " . $tableName . " bm where bm.patient_id=".$patient_id." AND bm.status=1  order by bm.id desc" ;
		$query = "select * from " . $tableName . " " . $where . " order by id desc";
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

	public function getPatientAdmissionDate($tableName, $where)
	{
		return $this->_select($tableName, $where, "*", true);
	}


	public function selectDataById($tableName, $where)
	{
		$query = "select * from " . $tableName . " " . $where;
		return parent::_rawQuery($query);
	}
	public function selectDataById1($tableName, $where,$billing_transaction)
	{
		$query = "select so.*,(select bt.confirm from ".$billing_transaction." bt where bt.reference_id=so.id and bt.type=3 and bt.patient_id=so.patient_id group by reference_id order by id desc) as confirm from " . $tableName . " so " . $where;
		return parent::_rawQuery($query);
	}

	public function deleteServicePlaceOrder($tableName, $where)
	{
		$query = "DELETE FROM " . $tableName . " " . $where;
		return $this->db->query($query);
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

	public function placeServiceOrder($tableName, $formData, $transactiontabel, $billingData)
	{
		try {
			$this->db->trans_start();

			// fore  index 1
			// var_dump($formData);
			// exit();
			foreach ($formData as $index1 => $value) {
				# code...

				$insert = $this->db->insert($tableName, $value);
				$insert_id = $this->db->insert_id();
				// $insert_id=1;

				if ($value['service_category'] != 'RADIOLOGY') {
					// var_dump($formData);
					// exit();
					foreach ($billingData as $index2 => $value2) {

						if ($index1 == $index2) {
							// echo 1;
							$value2["reference_id"] = $insert_id;
							$this->db->insert($transactiontabel, $value2);
						}
					}
				}
			}
			// exit();
			// $this->db->insert_batch($tableName, $formData);
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

	public function placeServiceOrder1($tableName, $formData)
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

	public function saveSampleCollection($sampleCollection)
	{
		try {
			$this->db->trans_start();
			foreach ($sampleCollection as $sample) {

				$result = $this->db->query("select s2.id from service_order s2 where s2.patient_id in (select s1.patient_id from service_order s1 where  s1.order_number ='" . $sample->id."') 
and s2.service_category='PATHOLOGY' and  `branch_id` = ". $this->session->user_session->branch_id." and s2.sample_pickup = 0;" )->result();
				if (is_array($result)) {
					foreach ($result as $item) {
						$this->db->set($sample->value)->where("id", $item->id)->update("service_order");
					}
				}

			}
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


	public function getRadiologyNotConfirmServices($category,$tableName,$hospital_bed_table,$patient_table,$patient_id,$zone,$confirm_status,$chk_count)
	{
		$where = array('branch_id' => $this->session->user_session->branch_id, 'company_id' => $this->session->user_session->company_id, 'service_category' => $category,'is_deleted'=>1);
		if($confirm_status==0)
		{
			$where['sample_collection']=0;
			$where['sample_pickup']=0;

		}
		else
		{
			$where['sample_pickup']=1;
		}
		if ($patient_id != null && $patient_id != '') {
				$where['patient_id']=$patient_id;
			}

		// if ($patient_id != null && $patient_id != '') {

		// 	$where = array('branch_id' => $this->session->user_session->branch_id, 'company_id' => $this->session->user_session->company_id, 'sample_collection' => 0, 'service_category' => $category, 'patient_id' => $patient_id, 'sample_pickup' => 0,'is_deleted'=>1);
		// }
			// if($chk_count==1)
			// {
			// 	$select = array("count(so.id)");
			// } 
			// else 
			// {
			$select = array("so.*",
			"(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info",
			"(select pt.roomid from ".$patient_table." pt where  pt.id=so.patient_id) as room_id",
			"(select um.name from users_master um where um.id=so.service_provider) as user_name");
			// }
		$this->db->select($select)->where($where);
		
		if (!is_null($zone)) {
			if ((int)$zone != -1) {
				$this->db->having('room_id', $zone);
			}
		}
		return $this->db->get($tableName)->result();
	}

	public function getPathologyNotConfirmServices($category,$tableName,$hospital_bed_table,$patient_table,$patient_id,$zone,$confirm_status,$chk_count)
	{
		$where = array('branch_id' => $this->session->user_session->branch_id, 'company_id' => $this->session->user_session->company_id, 'service_category' => $category,'is_deleted'=>1);
		if($confirm_status==0)
		{
			$where['sample_collection']=0;
			$where['sample_pickup']=0;

		}
		else
		{
			$where['sample_pickup']=1;
		}
		if ($patient_id != null && $patient_id != '') {
				$where['patient_id']=$patient_id;
			}

			// if($chk_count==1)
			// {
			// 	$select = array("count(so.id)");
			// } 
			// else 
			// {
			$select = array("so.*",
			"(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info",
			" group_concat(concat('AA',lpad(id,6,'0'))) as order_id",
			"group_concat(service_id) as service_code",
			"group_concat(service_detail) as service_name",
			"group_concat(service_detail,'||',so.id,'||',so.patient_id) as delete_string",
			"(select pt.roomid from ".$patient_table." pt where  pt.id=so.patient_id) as room_id",
			"(select um.name from users_master um where um.id=so.create_by) as user_name");
			// }
			if($chk_count==1)
			{
				$this->db->select($select)->where($where)->group_by("service_category,patient_id");
			} 
			else
			{
				$this->db->select($select)->where($where)->group_by("service_category,patient_id");
			}
		
		// if($chk_count!=1){
		if (!is_null($zone)) {

			if ((int)$zone != -1 && $zone !="undefined") {
				$this->db->having('room_id', $zone);
			}
		}
		// }
		return $this->db->get($tableName)->result();
	}
}

