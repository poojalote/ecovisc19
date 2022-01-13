<?php


class BranchModel extends MasterModel
{

	var $table="companies_master";
	// var $select_column= array('id','name');
	// var $order_column = array(null,'name');
	// function make_query()
	// {
	// 	$this->db->select($this->select_column);
	// 	$this->db->from($this->table);
	// 	if (isset($_POST["search"]["value"]))
	// 	{
	// 		$this->db->like("name" ,$_POST["search"]["value"]);
	// 	}
	// 	if (isset($_POST["order"]))
	// 	{
	// 		$this->db->order_by($this->order_column[$_POST["order"][0]['column']], $_POST["order"][0]['dir']);
	// 	}
	// 	else
	// 	{
	// 		$this->db->order_by("id" , "DESC");
	// 	}
	// }
	// function make_datatables()
	// {
	// 	$this->make_query();
	// 	if ($_POST["length"]!= -1)
	// 	{
	// 		$this->db->limit($_POST["length"],$_POST["start"]);
	// 	}
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }
	// function get_filtered_data()
	// {
	// 	$this->make_query();
	// 	$query = $this->db->get();
	// 	return $query->num_rows();
	// }
	public function get_all_data()
	{
		$this->db->select();
		return $this->db->get($this->table)->result_array();
		// return $this->db->count_all_results();
	}


	public function addForm($tableName, $formData, $fields)
	{

		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->load->model("TemplateModel");
			$this->db->insert($tableName, $formData);
			$resultObject->inserted_id = $this->db->insert_id();
			$tablePatientName = "com_" . $resultObject->inserted_id . "_patient";
			$companyPatientTable = $this->TemplateModel->createTemplateTable($tablePatientName, $fields);
			if ($companyPatientTable->status) {
				if ($this->db->set(array("tb_patient" => $tablePatientName))->where(array("id" => $resultObject->inserted_id))->update($tableName)) {
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$resultObject->status = FALSE;
					} else {
						$this->db->trans_commit();
						$resultObject->status = TRUE;
					}
				} else {
					$this->db->trans_rollback();
					$resultObject->status = FALSE;
				}
			} else {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			}

			$this->db->trans_complete();
		} catch (Exception $exc) {
			$this->db->trans_rollback();
			$resultObject->status = FALSE;
		}
		return $resultObject;
	}

	public function all_company($tableName)
	{
		$this->db->select();
		return $this->db->get($tableName)->result_array();
	}

	public function select($tableName, $condition)
	{
		// print_r($user_id);exit();
		$this->db->select();
		$this->db->where($condition);
		return $this->db->get($tableName)->result_array();
	}

	public function updateForm($tableName, $formData, $where,$fields)
	{
		try {
			$this->db->trans_start();
			$this->db->set($formData)->where($where)->update($tableName);
			$this->load->model("TemplateModel");
			$tablePatientName = "com_" . $formData["company_id"] . "_patient";
			if(!$this->TemplateModel->tableExist($tablePatientName)){
				$this->TemplateModel->createTemplateTable($tablePatientName, $fields);

				$this->db->set(array('tb_patient'=>$tablePatientName))->where($where)->update($tableName);
			}
			$this->db->set(array('tb_patient'=>$tablePatientName))->where($where)->update($tableName);
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

	public function delete($tableName, $where)
	{
		$this->db->where($where);
		return $this->db->delete($tableName);
	}


}
