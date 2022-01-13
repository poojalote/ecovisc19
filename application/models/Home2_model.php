<?php 
class Home2_model extends CI_model
	{
		
		
		public function addForm($tableName,$formData) {
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
    public function all_company($tableName)
    {
    	$this->db->select();
    	return $this->db->get($tableName)->result_array();
    }
    public function select($tableName,$condition)
        {
            // print_r($user_id);exit();
            $this->db->select();
            $this->db->where($condition);
            return $this->db->get($tableName)->result_array();
        }
    public function updateForm($tableName, $formData,$where) {
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
    public function delete($tableName,$where)
    {
        $this->db->where($where);
        return $this->db->delete($tableName);
    }
		











	
    
    }
?>