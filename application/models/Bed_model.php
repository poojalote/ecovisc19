<?php

require_once 'MasterModel.php';
class bed_model extends MasterModel

{
	function __construct()
	{
		parent::__construct();
	}

    public function add_room($room_data,$hospital_room_table) {
        try {
            $this->db->trans_start();
            $this->db->insert($hospital_room_table, $room_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "insert user Transaction Rollback");
                $result = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "insert user Transaction Commited");
                $result = TRUE;
            }
            $this->db->trans_complete();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            $result = FALSE;
        }
        return $result;
    }

     public function add_bedroom($bedroom_data,$hospital_bed_table) {
        try {
            $this->db->trans_start();
            $this->db->insert($hospital_bed_table, $bedroom_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "insert user Transaction Rollback");
                $result = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "insert user Transaction Commited");
                $result = TRUE;
            }
            $this->db->trans_complete();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            $result = FALSE;
        }
        return $result;
    }
	
	public function get_bed_type(){
		$query=$this->db->query("select service_id,service_description from service_master where bed_custom=1 and service_category='ACCOMM'");
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			return $result;
		}else{
			return false;
		}
	}
	
	public function getIcuBedData($sql){
		$query=$this->db->query($sql);
		if($this->db->affected_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	


}
