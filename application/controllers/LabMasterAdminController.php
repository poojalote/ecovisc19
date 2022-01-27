<?php

require_once 'HexaController.php';

class LabMasterAdminController extends HexaController
{


	/**
	 * LabController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MasterModel');
	}

	public function index(){
		$this->load->view("LabMasterAdmin/labMasterAdmin",array("title"=>"Lab Admin Dashboard"));
	}
	public function labMasterData()
	{
		$this->load->view('LabMasterAdmin/lab_master_data', array('title' => 'Lab Master Data'));
	}
	public function labParentServices()
	{
		$this->load->view('LabMasterAdmin/labParentServices', array('title' => 'Lab Master Services'));
	}

	public function getLabMasterData()
	{
		$checkbox = '';

			$id = $this->input->post('id');
			$check="(case when (select lm.id from lab_master_test lm where lm.master_service_id=la.master_service_id and branch_id='".$id."' and status=1 limit 1) is not null then 1 else 0 end)";

		$masterObject=$this->MasterModel->_rawQuery('select la.id,la.name,'.$check.' as check_id from lab_admin_master_test la where la.status=1');

		if ($masterObject->totalCount>0) {
			foreach ($masterObject->data as $prow) {
				$selected="";
				if ($prow->check_id==1) {
					$selected = 'checked';
				}
				$checkbox .= '<div class="col-md-6">
								<input type="checkbox" name="labMasterData[]" '.$selected.' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxall">  <label for="per' . $prow->id . '">' . $prow->name . '</label>
							</div>';
			}
		}
		$response['lastQuery'] = $masterObject->last_query;
		$response['status'] = 200;
		$response['data'] = $checkbox;
		echo json_encode($response);
	}
	public function getLabMasterDataOption(){

		$validObject = $this->is_parameter(array("type", "searchTerm","data"));
		$response = array();
		if ($validObject->status) {

			$type = $validObject->param->type;
			$search = $validObject->param->searchTerm;
			$branch_id = $validObject->param->data;
			$where = array();
			if ((int)$type != 1)
				$where = array("branch_id" => $branch_id,"status"=>1);
			$userData = $this->db->select(array("master_service_id", "name"))->where($where)->like("name", $search)->limit(10, 0)->get("lab_master_test")->result();
			$response["last_query"] = $this->db->last_query();
			$data = array();
			if (count($userData) > 0) {
				foreach ($userData as $user) {
					array_push($data, array("id" => $user->master_service_id, "text" => $user->name));
				}
			}
			$response["body"] = $data;
		} else {
			$response["body"] = array();
		}
		echo json_encode($response);
	}
	public function getHtmlLabAdminChildTest(){
		$checkbox = '';
		if(!is_null($this->input->post('id')) && $this->input->post('id')!="" && !is_null($this->input->post('branch_id')) && $this->input->post('branch_id')!="")
		{
			$id = $this->input->post('id');
			$branch_id = $this->input->post('branch_id');
			$childObject=$this->MasterModel->_rawQuery('select la.id,la.name,(case when (select lm.id from lab_child_test lm where lm.service_code=la.service_code and lm.name=la.name and branch_id="'.$branch_id.'" and status=1 limit 1) is not null then 1 else 0 end) as check_id from lab_admin_child_test la where la.status=1 and la.service_code="'.$id.'"');

			if ($childObject->totalCount>0) {
				foreach ($childObject->data as $prow) {
					$selected = '';
					if ($prow->check_id==1) {
						$selected = 'checked';
					}
					$checkbox .= '<div class="col-md-6">
								<input type="checkbox" name="labChildData[]" '.$selected.' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxallc">  <label for="per' . $prow->id . '">' . $prow->name . '</label>
							</div>';
				}
			}
			$response['lastQuery'] = $childObject->last_query;
			$response['status'] = 200;
			$response['data'] = $checkbox;
		}
		else{
			$response['status'] = 201;
			$response['data'] = $checkbox;
		}
		echo json_encode($response);
	}

	public function saveLabMasterData()
	{
		if(!is_null($this->input->post('branches')) && $this->input->post('branches')!=""  && $this->input->post('branches')!="null") {
			$branch_id = $this->input->post('branches');
			$labMasterData = $this->input->post('labMasterData');
			$labMasterData = json_decode($labMasterData);
			$ldata = (array)$labMasterData;
			$labData = implode(',', $ldata['labMasterData']);
			$session_data = $this->session->user_session;
			$user_id = $session_data->id;
			$resultStatus = TRUE;
			try {
				$this->db->trans_start();
				$this->db->where('branch_id', $branch_id)->delete('lab_master_test');
				$masterObject = $this->MasterModel->_rawQuery('select * from lab_admin_master_test where status=1 and find_in_set(id,"' . $labData . '")');
				if($masterObject->totalCount > 0) {
					$insert_batch = array();
					foreach ($masterObject->data as $m_row) {
						$res = array(
							'name' => $m_row->name,
							'description' => $m_row->description,
							'branch_id' => $branch_id,
							'user_id' => $user_id,
							'transaction_date' => date('Y-m-d H:i:s'),
							'status' => 1,
							'dep_id' => $m_row->dep_id,
							'master_service_id' => $m_row->master_service_id,
							'master_rate' => $m_row->master_rate,
						);
						array_push($insert_batch, $res);
					}
					if (count($insert_batch) > 0) {
						$this->db->insert_batch('lab_master_test', $insert_batch);
					}
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$resultStatus = FALSE;
				} else {
					$this->db->trans_commit();
					$resultStatus = TRUE;
				}
				$this->db->trans_complete();
				$response["last_query"] = $masterObject->last_query;
			} catch (Exception $ex) {
				$resultStatus = FALSE;
				$this->db->trans_rollback();
			}
			if ($resultStatus == TRUE) {
				$response['status'] = 200;
				$response['branch_id'] = $branch_id;
				$response['body'] = 'Inserted Successfully';
			} else {
				$response['status'] = 201;
				$response['branch_id'] = $branch_id;
				$response['body'] = 'Changes Not Saved';
			}
		}
		else{
			$response['status'] = 201;
			$response['branch_id'] = "";
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}
	public function saveLabChildData()
	{
		if(!is_null($this->input->post('branch_id')) && $this->input->post('branch_id')!="" && $this->input->post('branch_id')!="null" && !is_null($this->input->post('lab_master_test')) && $this->input->post('lab_master_test')!="") {
		$branch_id = $this->input->post('branch_id');
		$lab_master_test = $this->input->post('lab_master_test');
		$labChildData = $this->input->post('labChildData');
		$labChildData = json_decode($labChildData);
		$ldata = (array)$labChildData;
		$labData = implode(',', $ldata['labChildData']);
		$session_data = $this->session->user_session;
		$user_id = $session_data->id;
			$resultStatus = TRUE;
			try {
				$this->db->trans_start();
				$this->db->where(array('branch_id'=> $branch_id,'service_code'=>$lab_master_test))->delete('lab_child_test');

				$childObject = $this->MasterModel->_rawQuery('select * from lab_admin_child_test where status=1 and find_in_set(id,"' . $labData . '") and service_code="'.$lab_master_test.'"');

				if($childObject->totalCount>0){
					$insertChild = array();
					foreach ($childObject->data as $c_row) {
						$res  = array(
							'branch_id'=>$branch_id,
							'name'=>$c_row->name,
							'method'=>$c_row->method,
							'user_id'=>$user_id,
							'transaction_date'=>date('Y-m-d H:i:s'),
							'status'=>1,
							'unit'=>$c_row->unit,
							'referance_range'=>$c_row->referance_range,
							'master_id'=>$c_row->master_id,
							'child_id'=>$c_row->child_id,
							'service_code'=>$c_row->service_code
						);
						array_push($insertChild,$res);
					}
					if (count($insertChild) > 0) {
						$this->db->insert_batch('lab_child_test', $insertChild);
					}
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$resultStatus = FALSE;
				} else {
					$this->db->trans_commit();
					$resultStatus = TRUE;
				}
				$this->db->trans_complete();
				$response["last_query"] = $childObject->last_query;
			} catch (Exception $ex) {
				$resultStatus = FALSE;
				$this->db->trans_rollback();
			}
			if($resultStatus == TRUE){
				$response['status'] = 200;
				$response['branch_id'] = $branch_id;
				$response['body'] = 'Inserted Successfully';
			}else{
				$response['status'] = 201;
				$response['branch_id'] = $branch_id;
				$response['body'] = 'Changes Not Saved';
			}
		}
		else
		{
			$response['status'] = 201;
			$response['branch_id'] = "";
			$response['body'] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

}
