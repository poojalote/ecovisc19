<?php

require_once 'MasterModel.php';
class Assignbed_model extends MasterModel

{
	function __construct()
	{
		parent::__construct();
	}

   
    public function newMasterPatient($p_data, $fcode) {
        $result = new stdClass();
        try {
            $this->db->trans_start();
            $this->db->insert('master_patient', $p_data);

            $pid = $this->db->insert_id();
            $result->patient_id = $pid;
            $result->patien_unique = $p_data["patien_unique"];
            $dashboard = array(
                "p_id" => $pid,
                "unic_id" => $p_data["patien_unique"],
                "name" => $p_data["patient_name"],
                "facility" => $fcode
            );
            $this->db->insert('dashboard_table', $dashboard);

            if (array_key_exists('bed_id', $p_data)) {
                $updateBed = array(
                    "status" => 0
                );
                $where = array(
                    "Id" => $p_data["bed_id"]
                );
                $this->db->where($where)->update('add_hospital_bed', $updateBed);
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "Patient Transaction Rollback");
                $result->status = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "Patient Transaction Commited");
                $result->status = TRUE;
            }
            $this->db->trans_complete();
        } catch (Exception $exc) {
            $this->db->trans_rollback();
            $this->db->trans_complete();
            log_message('error', $exc->getMessage());
            $result->status = FALSE;
        }
        return $result;
    }
	
	function insert_order($t1,$array,$billing_transaction,$array2){
		 try {
			$this->db->trans_start();
            $insert=$this->db->insert($t1, $array);
			if($insert == true){
				$this->db->insert($billing_transaction, $array2);
			}
			if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "Patient Transaction Rollback");
                $result = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "Patient Transaction Commited");
                $result = TRUE;
            }
            $this->db->trans_complete();
		 } catch (Exception $exc) {
            $this->db->trans_rollback();
            $this->db->trans_complete();
            log_message('error', $exc->getMessage());
            $result = FALSE;
        }
		return $result;
	}
	function insert_order_bill($billing_transaction,$array2){
		 try {
			$this->db->trans_start();
				$this->db->insert($billing_transaction, $array2);
			if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "Patient Transaction Rollback");
                $result = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "Patient Transaction Commited");
                $result = TRUE;
            }
            $this->db->trans_complete();
		 } catch (Exception $exc) {
            $this->db->trans_rollback();
            $this->db->trans_complete();
            log_message('error', $exc->getMessage());
            $result = FALSE;
        }
		return $result;
	}
	
    public function updateMasterPatient($master_patient,$pid,$branch_id,$patient_table,$patient_bed_history_table,$hospital_bed_table) {
        $result = new stdClass();
        $result->pid = $pid;
        try {
            $this->db->trans_start();
            $roomDetails = $this->db->select(array('roomid', 'bed_id'))->where('id', $pid)->get($patient_table)->row();
            $this->db->set($master_patient)->where('id', $pid)->update($patient_table);
			//$service_id=$master_patient['service_id'];
			
			
		   $bedHistory_data = array('patient_id' => $pid,
                'branch_id' => $branch_id,
                'bed_id' => $master_patient['bed_id'],
            'room_id' => $master_patient['roomid'],
				'inTime' =>  date("Y-m-d H:i:s"),
				"create_on"=>date("Y-m-d H:i:s"),
				"create_by"=>$this->session->user_session->id);
             $this->db->insert($patient_bed_history_table, $bedHistory_data);

            $result->roomDetails = $roomDetails;
            if ($roomDetails != NULL) {
                if (array_key_exists('bed_id', $master_patient)) {
                    $free_bed = array("status" => 1,'modify_on'=>date('Y-m-d H:i:s'),'modify_by'=>$this->session->user_session->id);
                    $freed_bed_where = array("Id" => $roomDetails->bed_id);
                    $this->db->set($free_bed)->where($freed_bed_where)->update($hospital_bed_table);

                    $occupied_bed = array("status" => 0,'modify_on'=>date('Y-m-d H:i:s'),'modify_by'=>$this->session->user_session->id);
                    $occupied_bed_where = array("Id" => $master_patient['bed_id']);
                    $this->db->set($occupied_bed)->where($occupied_bed_where)->update($hospital_bed_table);
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "Patient Transaction Rollback");
                $result->status = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "Patient Transaction Commited");
                $result->status = TRUE;
            }
            $this->db->trans_complete();
        } catch (Exception $exc) {
            log_message('error', $exc->getMessage());
            $result->status = FALSE;
        }
        return $result;
    }


    public function deleteMasterPatient($pid,$company_id,$patient_table,$hospital_bed_table,$patient_bed_history_table) {
        $result = new stdClass();
        try {
            $this->db->trans_start();
            $roomDetails = $this->db->select(array('roomid', 'bed_id'))->where('id', $pid)->get($patient_table)->row();
            if ($roomDetails != NULL) {
                $free_bed = array("status" => 1);
                $freed_bed_where = array("Id" => $roomDetails->bed_id);
                $this->db->set($free_bed)->where($freed_bed_where)->update($hospital_bed_table);
            }
            $this->db->where('id', $pid)->delete($patient_table);
            $this->db->where(array('patient_id' => $pid,'company_id'=>$company_id ))->delete($patient_bed_history_table);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_message('info', "Patient Transaction Rollback");
                $result->status = FALSE;
            } else {
                $this->db->trans_commit();
                log_message('info', "Patient Transaction Commited");
                $result->status = TRUE;
            }
            $this->db->trans_complete();
        } catch (Exception $exc) {
            $this->db->trans_rollback();
            $this->db->trans_complete();
            log_message('error', $exc->getMessage());
            $result->status = FALSE;
        }
        return $result;
    }
     public function get_patient_by_uniqueIDUpdate($id, $pid,$company_id,$patient_table) { //function to get all patient id wise
        try {
            $this->db->select(array('*'));
            $this->db->where(array('id' => $pid, 'adhar_no' => $id));
            $result = $this->db->get($patient_table);

            if ($result->num_rows() == 0) {
                $this->db->select(array('*'));
                $this->db->where(array('adhar_no' => $id,'id'=>$pid));
                $result1 = $this->db->get($patient_table);
                if ($result1->num_rows() == 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (Exception $exc) {
            return null;
        }
    }

	public function bed_history($patient_id,$branch_id,$hospital_bed_table,$hospital_room_table,$patient_bed_history_table)
	{
		$sql="SELECT cbh.*,(select cb.bed_name from ".$hospital_bed_table." cb where cb.id=cbh.bed_id) as bed,(SELECT GROUP_CONCAT(cr.room_no,'-',cr.ward_no) from ".$hospital_room_table." cr where cr.id=cbh.room_id) as room FROM ".$patient_bed_history_table." cbh WHERE cbh.patient_id='".$patient_id."' AND cbh.branch_id='".$branch_id."' order by inTime desc";
		return parent::_rawQuery($sql);

	}
	public function get_service_charges($service_id){
		$query=$this->db->query("select rate from service_master where service_id='$service_id'");
		if($this->db->affected_rows() > 0){
			$result=$query->row();
			return $result->rate;
		}else{
			return false;
		}
	}
	public function get_service_chargesbyname($service_name){
		$query=$this->db->query("select rate,service_id from service_master where service_description='$service_name'");
		if($this->db->affected_rows() > 0){
			$result=$query->row();
			return $result;
		}else{
			return false;
		}
	}
	

}
