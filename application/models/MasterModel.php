<?php


class MasterModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $sql query which you want to execute
	 * @return stdClass witch properties of totalCount and data of query result
	 */
	function _rawQuery($sql)
	{
		$resultObject = new stdClass();
		try {
			$query = $this->db->query($sql, FALSE);
			$result = $query->result();
			if (count($result) > 0) {
				$resultObject->totalCount = count($result);
				$resultObject->data = $result;
			} else {
				$resultObject->totalCount = 0;
				$resultObject->data = array();
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->totalCount = 0;
			$resultObject->data = array();
		}
		return $resultObject;
	}

	/**
	 * @param $table String table name
	 * @param $data array values
	 * @return stdClass object of status and last insert id
	 */
	function _insert($table, $data)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($table, $data);
			$resultObject->inserted_id = $this->db->insert_id();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	/**
	 * @param $table String the table name
	 * @param $data  array you want to update
	 * @param $where array where update record
	 * @return stdClass object with property of status
	 */
	function _update($table, $data, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->set($data)->where($where)->update($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	/**
	 * @param $table String the table name
	 * @param $data  array you want to update including where column name
	 * @param $key String where column name
	 * @return stdClass object with property of status
	 */
	function _updateBatch($table, $data, $key)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->update_batch($table, $data, $key);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $table String the table name
	 * @param $where array where delete record
	 * @return stdClass object with property of status
	 */
	function _delete($table, $where)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->where($where)->delete($table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}


	/**
	 * @param $tableName String table name
	 * @param $where array of condition
	 * @param $select array|String of columns
	 * @param $type true for single row and false for multiple rows
	 * @param null $group_by group by value
	 * @return stdClass object with property of totalCount and data
	 */
	function _select($tableName, $where, $select = "*", $type = true, $group_by = null)
	{

		$resultObject = new stdClass();
		try {
			if ($type) {
				$this->db->select($select)->where($where);
				if ($group_by != null) {
					$this->db->group_by($group_by);
				}
				$result = $this->db->get($tableName)->row();

				if ($result != null) {
					$resultObject->totalCount = 1;
					$resultObject->data = $result;
				} else {
					$resultObject->totalCount = 0;
					$resultObject->data = $result;
				}
			} else {
				$this->db->select($select)->where($where);
				if ($group_by != null) {
					$this->db->group_by($group_by);
				}
				$result = $this->db->get($tableName)->result();

				$resultObject->totalCount = count($result);
				if (count($result) > 0) {
					$resultObject->data = $result;
				} else {
					$resultObject->data = array();
				}
			}
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $e) {
			$resultObject->totalCount = 0;
			$resultObject->data = null;
		}
		return $resultObject;
	}

	public function getRows($postData, $where, $select, $table, $column_search, $column_order, $order, $group_by = null, $where_or = null, $having = null, $customWhereCondition = null)
	{

		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by);
		if ($having != null) {
			if (!empty($having)) {
				$this->db->having($having['column'], $having['value']);
			}

		}
		if ($postData['length'] != -1) {
			$this->db->limit($postData['length'], $postData['start']);
		}
//		$this->where = $where;


		if($where_or != null){
			$this->db->where($where);
			$this->db->or_where($where_or);
		}else{
			$this->db->where($where);
			if ($customWhereCondition != null)
				$this->db->where($customWhereCondition);
		}

		$query = $this->db->select($select)->get();

		//echo $this->db->last_query();
		return $query->result();
	}

	/*
	 * Count all records
	 */

	public function countAll($table, $where,$customWhereCondition=null)
	{
        if($customWhereCondition !=null){
            $this->db->where($customWhereCondition);
        }
		$this->db->where($where)->from($table);
		return $this->db->count_all_results();
	}

	public function countFiltered($postData, $table, $where, $column_search, $column_order, $order,$customWhereCondition=null,$having=null,$select =null)
	{
		$this->_get_datatables_query($postData, $table, $column_search, $column_order, $order);
        if($where !=null){
            $this->db->where($where);
        }
		if($customWhereCondition !=null){
			$this->db->where($customWhereCondition);
		}
		if ($having != null) {
			if (!empty($having)) {
				$this->db->having($having['column'], $having['value']);
			}

		}
		if($select != null){
			$this->db->select($select);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	/*
	 * Perform the SQL queries needed for an server-side processing requested
	 * @param $_POST filter data based on the posted parameters
	 */

	public function _get_datatables_query($postData, $table, $column_search, $column_order, $order, $group_by = null)
	{

		$this->db->from($table);
		$i = 0;
		// loop searchable columns
		foreach ($column_search as $item) {
			// if datatable send POST for search
			if ($postData['search']['value']) {
				// first loop
				if ($i === 0) {
					// open bracket
					$this->db->group_start();
					$this->db->like($item, $postData['search']['value']);
				} else {
					$this->db->or_like($item, $postData['search']['value']);
				}
				// last loop
				if (count($column_search) - 1 == $i) {
					// close bracket
					$this->db->group_end();
				}
			}
			$i++;
		}
		if ($group_by != null) {
			$this->db->group_by($group_by);
		}
		if (isset($postData['order'])) {
			$column = (int)$postData['order']['0']['column'];
			if (count($column_order) > $column)
				$this->db->order_by($column_order[$column], $postData['order']['0']['dir']);
		} else if (count($order)>0) {

				$this->db->order_by(key($order), $order[key($order)]);

		}
	}
}
