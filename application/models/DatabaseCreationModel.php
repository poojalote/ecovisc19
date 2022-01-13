<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class DatabaseCreationModel extends MasterModel
{

// fetch table data
	public function tableExist($table_name)
	{
		return $this->db->table_exists($table_name);
	}

	public function columnExist($table_name, $column_name)
	{
		if($this->tableExist($table_name))
		return $this->db->field_exists($column_name, $table_name);

		return false;
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
<<<<<<< HEAD
				$this->dbforge->add_field('id');
				$this->dbforge->add_field($fields);
=======
				$this->dbforge->add_field($fields);
				$this->dbforge->add_field('id');
>>>>>>> 9e8a9109c651f108fcf463f654b4ef09203083ba
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






}

