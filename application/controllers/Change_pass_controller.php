<?php
require_once 'HexaController.php';

/**
 * @property  Doctor Doctor
 */

class change_pass_controller extends HexaController
{
	public function index()
	{
		$this->load->view("admin/users/change_pass_form", array("title" => 'Change Password'));
	}
	public function change_pass()
	{
		$id = $this->input->post("id");
			$old_pass = $this->input->post("old_pass");
			$new_pass=$this->input->post("new_pass");
			// print_r($id);
			// print_r($old_pass);
			// print_r($new_pass);
			if (empty($new_pass)) {
				echo 2;
			}
			else{
			$formdata=array('password'=>$new_pass);
			$tablename="users_master";
			$where = array('id' => $id ,
							'password'=>$old_pass);
			$this->load->Model('UserModel');
			$user_check=$this->UserModel->check_user($tablename, $where);
			// print_r($user_check);
			if (!empty($user_check)) {


				$result=$this->UserModel->updateForm($tablename,$formdata, $where);
				// print_r($result);
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
			
	}
	
	public function change_access(){
		$id=$this->input->post('id');
		$userid=$this->session->user_session->id;
		$where = array('id' => $userid);
		$formdata=array('default_access'=>$id);
		$this->db->where($where);
		$this->db->set($formdata);
		$update=$this->db->update('users_master');
		if($update == true){
			$response['status']=200;
			$response['body']="Updated Successfully.";
		}else{
			$response['status']=201;
			$response['body']="Something Went Wrong.";
			
		}echo json_encode($response);
	}
	
	public function getDefaultAccess(){
		$userid=$this->session->user_session->id;
		$query=$this->db->query("select default_access from users_master where id='$userid' and default_access=2");
		if($this->db->affected_rows() > 0){
			$response['status']=200;
		}else{
			$response['status']=201;
		}echo json_encode($response);
	}
}