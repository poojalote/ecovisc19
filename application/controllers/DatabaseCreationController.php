<?php

require_once 'HexaController.php';

/**
 * @property  User User
 * @property  DatabaseCreationModel DatabaseCreationModel
 */
class DatabaseCreationController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('DatabaseCreationModel');
	}

	/*
	 * login api
	 */
	public function table_creation()
	{
		$this->load->view('DatabaseCreation/database_creation', array("title" => "Database Creation"));
	}

	public function createNewtable()
	{
		$this->load->view('DatabaseCreation/createNewtable', array("title" => "Database Creation"));
	}

	public function getAllTablesFromDatabase()
	{
		$tables = array();
		$tables = $this->db->list_tables();
		if (count($tables) > 0) {
			$tableRows = array();
			foreach ($tables as $row) {
				$tableRows[] = array(
					$row
				);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => count($tables),
				"recordsFiltered" => count($tables),
				"data" => $tableRows,
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $memData,
			);
		}
		echo json_encode($results);

	}

	public function getDatabaseTableCategories()
	{
		$validationObject = $this->is_parameter(array("table_name"));
		if ($validationObject->status) {
			$param = $validationObject->param;
			$fields = $this->db->query('SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT,COLUMN_KEY, 
		COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE table_name = "' . $param->table_name . '" 
		AND table_schema = "html_database"')->result();
			$data = '<table class="table table-bordered"><thead> <tr>
			<th>Field</th>
			<th>Type</th>
			<th>Null</th>
			<th>Key</th>
			<th>Default</th>
			</tr></thead><tbody>';
			foreach ($fields as $field) {
				$data .= '<tr>
					<td>' . $field->COLUMN_NAME . '</td>
					<td>' . $field->DATA_TYPE . '</td>
					<td>' . $field->IS_NULLABLE . '</td>
					<td>' . $field->COLUMN_KEY . '</td>
					<td>' . $field->COLUMN_DEFAULT . '</td>
					</tr>';
			}
			$data .= "</tbody></table>";
			$response["status"] = 200;
			$response["data"] = $data;
			$response["body"] = '';
		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}

	public function saveDatabaseTableCreation()
	{
		// print_r($this->input->post());exit();
		//"c_notnull","c_autoincrement"
		$validationObject = $this->is_parameter(array("table_name", "rowCount", "c_name", "c_type", "c_length", "c_index", "c_default"));
		if ($validationObject->status) {
			$param = $validationObject->param;
			$table_name = $param->table_name;
			$rowCount = $param->rowCount;
			$fieldsArray = array();

			for ($i = 0; $i < $rowCount; $i++) {
				$fieldDetails = array();
				if (isset($param->c_type[$i]) && !empty($param->c_type[$i])) {
					$fieldDetails['type'] = $param->c_type[$i];
				}
				if (isset($param->c_length[$i]) && !empty($param->c_length[$i])) {
					$fieldDetails['constraint'] = $param->c_length[$i];
				}
				if (isset($param->c_notnull[$i]) && !empty($param->c_notnull[$i])) {
					if ($param->c_notnull[$i] == "on") {
						$fieldDetails['null'] = false;
					}else{
						$fieldDetails['null'] = true;
					}
				}else{
					$fieldDetails['null'] = true;
				}
				if (isset($param->c_index[$i]) && !empty($param->c_index[$i])) {
					$fieldDetails['key'] = $param->c_index[$i];
				}
				if (isset($param->c_default[$i]) && !empty($param->c_default[$i])) {
					$fieldDetails['default'] = $param->c_default[$i];
				}
				if (isset($param->c_autoincrement[$i]) && !empty($param->c_autoincrement[$i])) {
					if ($param->c_autoincrement[$i] == "on") {
						$fieldDetails['auto_increment'] = true;
					}
				}
				if (isset($param->c_index[$i]) && !empty($param->c_index[$i])) {
					$fieldDetails['index'] = $param->c_index[$i];
				}
				if (isset($param->c_name[$i]) && !empty($param->c_name[$i])) {
					$fieldsArray[$param->c_name[$i]] = $fieldDetails;
				}
			}
			$fieldsArray["user_id"] = array(
				"type" => "int",
				"null" => true,
			);
			$fieldsArray["transaction_date"] = array(
				"type" => "DATETIME",
				"null" => true,
			);
			$fieldsArray["status"] = array(
				"type" => "int",
				"null" => true,
				'default' => 1,
			);
			$result = $this->DatabaseCreationModel->createTemplateTable($table_name, $fieldsArray);
			// print_r($result);exit();
			if ($result->status == 1) {
				$response["status"] = 200;
				$response["body"] = "Table Created successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Check Column type and their length";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}


}
