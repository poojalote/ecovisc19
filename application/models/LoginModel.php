<?php

require_once 'MasterModel.php';

class loginModel extends MasterModel
{


    /**
     * @param $username String username
     * @param $password String password
     * @return stdClass Object of result with totalCount and data
     */
    public function login($username, $password)
    {
//        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
//            //NOT EMAIL
//            $exp = (explode("#", $password));
//            $company_id = $exp[0];
//            $branch_id = $exp[1];
//            $patient_id = $exp[2];
//            $table_name = $company_id . "_patient";
//            $this->db->select('*');
//            $this->db->from($table_name);
//            $this->db->where('adhar_no', $username);
//            $query = $this->db->get();
//
//            if ($query->num_rows() > 0) {
//                $row = $query->row_array();
//                return $row;
//            }
//        } else {
            return parent::_select('users_master', array("user_name" => $username, "password" => $password, "status" => 1),
                array("user_name", "id", "name", "password","mobile_number", "roles", "company_id", "branch_id", "user_type", "default_access"));
//        }

    }

    /**
     * @param $userData Array collection of user master data with column mapping
     * @param $privileges Array multi-dimension array of privileges
     * @return stdClass Object of result with status
     */
    public function addUser($userData, $privileges)
    {
        $resultObject = new stdClass();
        try {
            $this->db->trans_start();
            $this->db->insert("user_master", $userData);
            $resultObject->inserted_id = $this->db->insert_id();
            foreach ($privileges as $privilege) {
                $privilege["user_id"] = $resultObject->inserted_id;
            }
            $this->db->insert_batch("users_privileges", $privileges);
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
     * @param $user_id String id of user to update following data
     * @param $userData Array collection of user master data with column mapping
     * @param $privileges Array multi-dimension array of privileges
     * @return stdClass Object of result with status
     */
    public function updateUser($userData, $privileges, $user_id)
    {
        $resultObject = new stdClass();
        try {
            $this->db->trans_start();
            $this->db->where(array("id" => $user_id))->set($userData)->update("user_master");
            $this->db->where(array("id" => $user_id))->delete("users_privileges");
            foreach ($privileges as $privilege) {
                $privilege["user_id"] = $resultObject->inserted_id;
            }
            $this->db->insert_batch("users_privileges", $privileges);
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
     * @param $user_id String id of user to delete
     * @return stdClass Object of result with status
     */
    public function deleteUser($user_id)
    {
        return $this->_update("user_master", array("status" => 0), array("id" => $user_id));
    }

    /**
     * @param $where String where condition
     * @param $like String like condition
     * @param $order_by String order by
     * @param $limit String limit query result
     * @return stdClass Object of result with totalCount and data
     */
    public function fetchAllUsers($where, $like, $order_by, $limit)
    {
        $sql = "select u.id,u.name,(select c.name from companies_master c where c.id=u.company_id) from users_master u " . $where . " " . $like . " " . $order_by . " " . $limit;
        return $this->_rawQuery($sql);
    }

    public function fetchAllUserDepartments($user_id)
    {
        return $this->_select("role_master r", array("r.user_id" => $user_id, "r.activity_status" => 1),
            array("GROUP_CONCAT(r.id,'|||',r.department_id,'|||',(select group_concat(dm.name,'|||',dm.sequance,'|||',dm.is_admin,'|||',dm.branch_level_access) from departments_master dm where dm.id=r.department_id and dm.status=1 and dm.is_admin!=2) SEPARATOR '@') as departments"));
    }

    /**
     * @param $where Array where condition
     * @return stdClass Object of result with totalCount and data
     */
    public function fetchAllUsersCount($where)
    {
        return $this->_select("users_master", $where, array("count(*) as total_users"));
    }

    /**
     * @param $where Array where condition
     * @return stdClass Object of result with totalCount and data
     */
    public function fetchUser($where)
    {
        return $this->_select("user_master", $where);
    }

    public function getBranchCompanyData($branch_id)
    {
        $sql = "SELECT *,(SELECT bm.name FROM branch_master bm where bm.id=" . $branch_id . ") as branch_name
		,(SELECT bm.tb_patient FROM branch_master bm where bm.id=" . $branch_id . ") as patient_table,(SELECT bm.tb_lab_patient FROM branch_master bm where bm.id=" . $branch_id . ") as lab_patient_table  
		FROM company_master where id in (SELECT company_id FROM branch_master where id=" . $branch_id . ")";
        return $this->db->query($sql);

    }

    public function getPermissionData($user_id)
    {
        $q = $this->db->query("select * from user_permission_table where user_id='$user_id'");
        if ($this->db->affected_rows() > 0) {
            return $q->result();
        } else {
            return false;
        }
    }

    public function getBranchPermissionData($branch_id)
    {
        $q = $this->db->query("select * from permissionMaster where find_in_set(" . $branch_id . ",branch_id)");
        if ($this->db->affected_rows() > 0) {
            return $q->result();
        } else {
            return false;
        }
    }




}
