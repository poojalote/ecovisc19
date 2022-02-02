<?php

require_once 'MasterModel.php';

class TemplateModel extends MasterModel
{

	private $table;

	/**
	 * TemplateModel constructor.
	 * @param $table
	 */
	public function __construct()
	{
		$this->table = "template_master";
	}


	public function getCompany($company_id)
	{
		return $this->_select("departments_master", array("status" => 1, "id" => $company_id));
	}
	
	public function getTemplateList(){
		$query=$this->db->query("select id,name from departments_master");
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
	}

	public function saveTemplate($sectionName, $department_id, $templateFields, $table_name, $create_by, $section_id, $sectionTransactionMode, $sectionHistoryMode)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			if (!empty($table_name)) {
				$history_table = null;
				if ($section_id == null) {
					$history_table = "his_" . $table_name;
					$this->db->insert("section_master",
						array("name" => $sectionName, "department_id" => $department_id, "create_by" => $create_by, "is_history" => $sectionHistoryMode, "is_traction" => $sectionTransactionMode));
					$section_id = $this->db->insert_id();
					$this->db->set("tb_history", $history_table)->where(array("id" => $section_id))->update("section_master");
				} else {
					$this->db->set(array("name" => $sectionName, "is_history" => $sectionHistoryMode, "is_traction" => $sectionTransactionMode))->where("id", $section_id)->update("section_master");
					$history_table = "his_" . $table_name ;

				}

				$fieldsArray = array();
				$historyFieldsArray=array();
				if (!$this->tableExist($table_name)) {
					$patientFieldDetails = array("type" => "INT", 'constraint' => '11');
					$fieldsArray["patient_id"] = $patientFieldDetails;
//					$companyFieldDetails = array("type" => "INT", 'constraint' => '11');
//					$fieldsArray["company_id"] = $companyFieldDetails;
					$companyFieldDetails = array("type" => "INT", 'constraint' => '11');
					$fieldsArray["branch_id"] = $companyFieldDetails;
					$transactionFieldDetails = array("type" => "datetime" );
					$fieldsArray["trans_date"] = $transactionFieldDetails;
				}

				foreach ($templateFields as $field) {
					$field->tb_name = $table_name;
					$field->section_id = $section_id;
					$field->department_id = $department_id;
					$options = null;
					if ($field->ans_type == 3 || $field->ans_type == 4 || $field->ans_type == 12 || $field->ans_type == 13) {
						$options = $field->options;
						unset($field->options);
					}
					$fields = (array)$field;
//var_dump($fields);
//					print_r($fields);exit();
					if (!property_exists($field, "id")) {
						$this->db->insert("template_master", $fields);
						$field_id = $this->db->insert_id();
						$field_name = "sec_" . $section_id . "_f_" . $field_id;
						$this->db->set("field_name", $field_name)->where(array("id" => $field_id))->update("template_master");
						$fieldDetails = array("type" => "varchar", 'constraint' => '255', 'null' => TRUE, 'AFTER' => 'id');
						if (!$this->columnExist($table_name, $field_name)) {
							$fieldsArray[$field_name] = $fieldDetails;
							$historyFieldsArray[$field_name]=$fieldDetails;
						}
						if ($options != null) {
							foreach ($options as $value) {
								$this->db->insert("option_master", array("name" => $value, "temp_id" => $field_id));
							}
						}
					} else {
						$custom_query="";
						$dependancy="";
						$is_extended_template="";
						$ext_template_id="";
						$date_type="";
						$date_sequence="";
						if(array_key_exists("custom_query",$fields)){
							$custom_query=$fields['custom_query'];
						}
						if(array_key_exists("dependancy",$fields)){
							$dependancy=$fields['dependancy'];
						}
						if(array_key_exists("is_extended_template",$fields)){
							$is_extended_template=$fields['is_extended_template'];
						}
						if(array_key_exists("ext_template_id",$fields)){
							$ext_template_id=$fields['ext_template_id'];
						}
						if(array_key_exists("date_type",$fields)){
							$date_type=$fields['date_type'];
						}
						if(array_key_exists("date_position",$fields)){
							$date_sequence=$fields['date_position'];
						}
						$this->db->set(
						array("name" => $field->name, "ans_type" => $field->ans_type,
						"is_history"=>$sectionHistoryMode,
						'sequeance_num'=>$field->sequeance_num,"custom_query"=>$custom_query,
						"dependancy"=>$dependancy,"is_extended_template"=>$is_extended_template,"ext_template_id"=>$ext_template_id,"date_type"=>$date_type,"date_position"=>$date_sequence))
							->where(array("id" => $field->id))
							->update("template_master");

						$field_name = "sec_" . $section_id . "_f_" . $field->id;
						$fieldDetails = array("type" => "varchar", 'constraint' => '255', 'null' => TRUE, 'AFTER' => 'id');
						if (!$this->columnExist($table_name, $field_name)) {
							$historyFieldsArray[$field_name] = $fieldDetails;
						}

						if (!$this->columnExist($history_table, $field_name)) {
							$historyFieldsArray[$field_name]=$fieldDetails;
						}
						$resultObject->update = "On";
						if ($options != null) {
							// $this->db->where("temp_id", $field->id)->delete("option_master");
							$data=$this->getUniqueData($options,$field->id);
							// foreach ($options as $value) {							
							// 		$this->db->insert("option_master", array("name" => $value, "temp_id" => $field->id));	
							// }
						}else{
							//$this->db->where("temp_id", $field->id)->delete("option_master");
						}

					}
				}
				
				$resultObject->last_query = $this->db->last_query();
				$resultObject->fields = $templateFields;
				$result = $this->createTemplateTable($table_name, $fieldsArray);
				if ($sectionHistoryMode == 1) {
					$commonColumn=array("patient_id","trans_date","branch_id");
					foreach ($commonColumn as $column){
						$fieldDetails = array("type" => "INT", 'constraint' => '11');
						if($column == "trans_date"){
							$fieldDetails = array("type" => "datetime" );
						}
						if (!$this->columnExist($history_table, $column)) {
							$historyFieldsArray[$column] = $fieldDetails;
						}
					}
					$resultTable = $this->createTemplateTable($history_table, $historyFieldsArray);
					$resultObject->HistoryTableResult = $resultTable;
				}
				$resultObject->TransactionTableResult = $result;
				if ($result->status) {
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$resultObject->status = FALSE;
						$resultObject->section = 4;
					} else {
						$this->db->trans_commit();
						$resultObject->status = TRUE;
					}
				} else {
					$this->db->trans_rollback();
					$resultObject->status = FALSE;
					$resultObject->section = 3;
				}

			} else {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
				$resultObject->section = 2;
			}
			$this->db->trans_complete();


		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$resultObject->section = 1;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	public function columnExist($table_name, $column_name)
	{
		if($this->tableExist($table_name))
		return $this->db->field_exists($column_name, $table_name);

		return false;
	}

	public function tableExist($table_name)
	{
		return $this->db->table_exists($table_name);
	}

	public function createTemplateTable($table_name, $fields)
	{
		$this->load->dbforge();
		$resultObject = new stdClass();
		// create new table if not exists then create
		if (count($fields) > 0) {
			if ($this->db->table_exists($table_name)) {
				$this->dbforge->add_column($table_name, $fields);
				$resultObject->status = true;
				$resultObject->body = "table exists new column added";
			} else {
				$this->dbforge->add_field($fields);
				$this->dbforge->add_field('id');
				if ($this->dbforge->create_table($table_name, TRUE)) {
					$resultObject->body = "new table new column added";
					$resultObject->status = true;
				} else {
					$resultObject->status = false;
				}
			}
		} else {
			$resultObject->status = true;
		}


		$resultObject->fields = $fields;
		return $resultObject;
	}

	public function fetchTemplateSections($department_id)
	{
		return $this->_select("section_master",
			array("department_id" => $department_id, "status" => 1),
			"*", false);
	}

	public function fetchSectionElement($section_id, $department_id)
	{
		$sql='select t.id,t.name,t.ans_type,t.sequeance_num,t.is_required,t.is_history,t.placeholder,t.custom_query,t.dependancy,t.is_extended_template,t.ext_template_id,
		(select group_concat(o.id,"|||",o.name) from option_master o where o.temp_id=t.id) as options,
		(select group_concat(s.id,"|||",s.name,"|||",s.is_traction) from section_master s where s.id=t.section_id) as section,t.date_type,t.date_position
		from template_master t where department_id='.$department_id.' and t.status=1 and section_id='.$section_id.' and status=1 order by sequeance_num';
		return $this->_rawQuery($sql);
//		return $this->_select("template_master t",
//			array("department_id" => $department_id,"t.status"=>1, "section_id" => $section_id, "status" => 1),
//			array("t.id", "t.name", "t.ans_type", "t.sequeance_num", "t.is_required", "t.is_history", "t.placeholder",
//				"(select group_concat(o.id,'|||',o.name) from option_master o where o.temp_id=t.id) as options",
//				"(select group_concat(s.id,'|||',s.name) from section_master s where s.id=t.section_id) as section"
//			), false);
	}

	public function deleteSection($section_id)
	{
		return $this->_update("section_master", array("status" => 0), array("id" => $section_id));
	}

	public function deleteElement($element_id){
		return $this->_update("template_master",array("status"=>0),array("id"=>$element_id));
	}

	public function getUniqueData($options,$temp_id)
	{
		$resultMyOp=$this->db->select("name")->where('temp_id', $temp_id) -> get('option_master')->result();
		$same_array=array();
		$deleted_array=array();
		// print_r($options);
		foreach ($resultMyOp as $key => $value) {
			if(in_array($value->name, $options))
			{
				array_push($same_array,$value->name);
			}
			else
			{
				array_push($deleted_array,$value->name);
			}
		}

		$insert_array=array_diff($options,$same_array);
		// print_r($result);
		foreach ($insert_array as $key => $value) {
			$this->db->insert("option_master", array("name" => $value, "temp_id" => $temp_id));
		}

		foreach ($deleted_array as $key => $value) {
			$where=array("temp_id"=>$temp_id,"name"=>$value);
			$this->db->where($where)->delete("option_master");
		}
		return true;
		// print_r($deleted_array);
	}
}
