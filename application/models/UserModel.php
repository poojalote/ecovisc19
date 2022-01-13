<?php

require_once 'MasterModel.php';

class UserModel extends MasterModel
{


	public function getUsers($where)
	{
		return $this->_select("users_master u", $where, array("u.*", "(select c.name from branch_master c where c.id=u.branch_id and c.status=1) as branch_name", "(select c.name from company_master c where c.id=u.company_id and c.status=1) as company_name"), false);
	}

	public function updateUser($userData, $privileges,$permission, $tableName1, $tableName2, $where, $where1)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->where($where)->set($userData)->update($tableName1);
			$this->db->where($where1)->delete($tableName2);
			if (count($privileges) > 0) {
				//     $copy = array( );
				//     foreach ($privileges as $privilege) {
				//         $privilege["user_id"] = $resultObject->inserted_id;
				//         array_push($copy,$privilege);
				//     }

				//     $this->db->insert_batch($tableName2, $copy);
				$this->db->insert_batch($tableName2, $privileges);
			}
			if(count($permission)>0){
				$this->db->where($where1)->delete("user_permission_table");
				$this->db->insert_batch("user_permission_table",$permission);
			}
			//$this->db->insert_batch($tableName2, $privileges);

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

	public function addUser($userData, $privileges, $tableName1, $tableName2, $user = "")
	{

		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$this->db->insert($tableName1, $userData);
			$resultObject->inserted_id = $this->db->insert_id();
			$last_insert = $this->db->insert_id();
			// print_r($resultObject->inserted_id);exit();
			if (count($privileges) > 0) {
				$copy = array();
				foreach ($privileges as $privilege) {
					$privilege["user_id"] = $resultObject->inserted_id;
					array_push($copy, $privilege);
				}

				$this->db->insert_batch($tableName2, $copy);
			}

			$get_permission_data = $this->get_permission_data($user);
			if ($get_permission_data != false) {
				foreach ($get_permission_data as $r1) {
					$data_per = array(
						"permission_name" => $r1->permission_name,
						"user_id" => $last_insert,
						"status" => 1
					);
					$this->db->insert("user_permission_table", $data_per);
				}
			}
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

	public function getUser($user_id)
	{
		$query = "select u.*,(SELECT GROUP_CONCAT(r.department_id,'|||',(select dm.name from departments_master dm where dm.id=r.department_id)) from role_master r where r.user_id=u.id) as udepartment,(SELECT GROUP_CONCAT(dm1.id,'|||',dm1.name) from departments_master dm1 where dm1.company_id=u.company_id) as alldepartments from users_master u where u.id='" . $user_id . "'";
		return parent::_rawQuery($query);
	}

	public function selectDataById($tableName, $where)
	{
		$query = "select * from " . $tableName . " " . $where;
		return parent::_rawQuery($query);
	}

	public function updateForm($tableName, $formData, $where)
	{
		return $this->_update($tableName, $formData, $where);

	}

	public function check_user($tablename, $where)
	{
		$this->db->SELECT();
		$this->db->WHERE($where);
		$user_data = $this->db->get($tablename)->result_array();
		// print_r($user_data);
		// exit();
		return $user_data;
	}

	public function get_permission_data($user)
	{
		$sql = "select * from group_permission_table where " . $user . "=1";
		$queryy = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return $queryy->result();
		} else {
			return false;
		}
	}

	public function get_col_name()
	{
		$cont_id = 'col_' . rand(100, 1000);
		$this->db->select('*');
		$this->db->from('profile_management_table');
		$this->db->where('column_name', $cont_id);
		$this->db->get();
		if ($this->db->affected_rows() > 0) {
			return get_col_name();
		} else {
			return $cont_id;
		}
	}
	function update_permission($type,$profile_check)
	{
		$get_user_id=$this->db->query("select id from users_master where user_type='$type'");
	$cnt=1;	
	if($this->db->affected_rows() > 0){
			$res=$get_user_id->result();
			foreach($res as $row){
				$delete = $this->db->delete("user_permission_table", array("user_id" => $row->id));
				for ($i = 0; $i < count($profile_check); $i++) {
				$array = array(
				"user_id" => $row->id,
				"status" => 1,
				"permission_name" => $profile_check[$i],
			);
			$data_insert = $this->db->insert("user_permission_table", $array);
			if ($data_insert == true) {
				$cnt++;
			}
		}
			}
		}
		$cnt = 1;
		
		
		if ($cnt > 1) {
			return true;
		} else {
			return false;
		}
	}
	function update_roles($type,$roles){
		$cnt=1;
		$get_user_id=$this->db->query("select id from users_master where user_type='$type'");
		if($this->db->affected_rows() > 0){
			$res=$get_user_id->result();
			foreach($res as $row){
				$user_id=$row->id;
				$delete = $this->db->delete("role_master", array("user_id" => $row->id));
				for ($i = 0; $i < count($roles); $i++) {
					$array = array(
				"user_id" => $user_id,
				"activity_status" => 1,
				"department_id" => $roles[$i],
				"create_on" => date('y-m-d'),
				
			);
			
			$data_insert = $this->db->insert("role_master", $array);
			if ($data_insert == true) {
				$cnt++;
			}
				}
			}
		}
		if ($cnt > 1) {
			return true;
		} else {
			return false;
		}
		//exit;
	}
	public function add_profile($profile_name, $profile_check, $roles, $pf_id)
	{
		try {
			$this->db->trans_start();
			if ($pf_id == 0) {
				$generate_column_name = $this->get_col_name();
				$data = array(
					"profile_name" => $profile_name,
					"column_name" => $generate_column_name,
				);
				$this->db->insert("profile_management_table", $data);
				$sql = "ALTER TABLE group_permission_table ADD " . $generate_column_name . " INT DEFAULT 0";
				$this->db->query($sql);
			} else {
				$get_column_name = $this->db->query("select column_name from profile_management_table where id='$pf_id'");
				if ($this->db->affected_rows() > 0) {
					$res = $get_column_name->row();
					$column = $res->column_name;
				}
				$generate_column_name = $column;
				$w = array("id" => $pf_id);
				$s = array("profile_name" => $profile_name);
				$this->db->where($w);
				$this->db->update('profile_management_table', $s);
				
				
			}
				$set1 = array($generate_column_name => 0);
				$this->db->update("group_permission_table", $set1);

			for ($i = 0; $i < count($profile_check); $i++) {
				$permission_name = $profile_check[$i];
				$set = array($generate_column_name => 1);
				$where = array("permission_name" => $permission_name);
				$this->db->where($where);
				$this->db->update("group_permission_table", $set);
			}
			if ($pf_id != 0) {
			$update=$this->update_permission($pf_id,$profile_check);
			}
			
			$rolesInsertArray = array();
			$rolesUpdateArray = array();
			$this->db->set(array($generate_column_name => 0))->where(array("type" => 2))->update("group_permission_table");
			if (is_array($roles)) {

				foreach ($roles as $role) {
					$rolesObject = $this->db->select(array("permission_name", "id"))->where(array("permission_name" => $role, "type" => 2))->get("group_permission_table")->row();
					if (is_null($rolesObject)) {
						array_push($rolesInsertArray, array("permission_name" => $role, "type" => 2, $generate_column_name => 1));
					} else {
						$updateObject = new stdClass();
						$updateObject->data = array("type" => 2, $generate_column_name => 1);
						$updateObject->id = $rolesObject->id;
						array_push($rolesUpdateArray, $updateObject);
					}
				}

			}
			if (count($rolesInsertArray) > 0) {
				$this->db->insert_batch("group_permission_table", $rolesInsertArray);
			}
			if (count($rolesUpdateArray) > 0) {
				foreach ($rolesUpdateArray as $updateObject) {
					$this->db->set($updateObject->data)->where("id", $updateObject->id)->update("group_permission_table");
				}
			}
			 if ($pf_id != 0 && is_array($roles)) {
			$update=$this->update_roles($pf_id,$roles);
			} 

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject = TRUE;
			}
			$this->db->trans_complete();
			//	$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	function getPermissionDataProfile($column_name)
	{
		$sql = "select " . $column_name . ", permission_name,type from group_permission_table";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return $result = $query->result();
		} else {
			return false;
		}

	}
}
