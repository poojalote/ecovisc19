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
		$check=0;
//		if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
//		{
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


}
