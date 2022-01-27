<?php

require_once 'HexaController.php';

/**
 * Class LabMasterAdminController
 * @property MasterModel MasterModel
 */

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

	public function getLabMasterTest()
	{
		$company_id = $this->session->userdata('company_id');
		$group_data_array = $this->MasterModel->_rawQuery('select * from lab_admin_master_test');
		$departments = $this->db->select('*')->from('lab_admin_department_master')->get()->result();
		$depart  = array();
		if(count($departments) > 0 )
		{
			foreach($departments as $key=>$value)
			{
				array_push($depart,$value->id.'-'.$value->name);
			}
		}
		$data_array = array();
		if ($group_data_array->totalCount > 0) {
			$labData = $group_data_array->data;
			foreach($labData as $row)
			{
				$departmentData =  $this->db->select('*')->where('id',$row->dep_id)->from('lab_admin_department_master')->get()->row();
				if($departmentData != null)
				{
					$dep_id = $departmentData->id."-".$departmentData->name;
				}
				else
				{
					$dep_id = "";
				}
				$data = array(
					$row->master_service_id,
					$row->name,
					$row->description,
					$row->master_rate,
					$dep_id
				);
				array_push($data_array,$data);
			}
			$response['status'] = 200;
			$response['data'] = $data_array;
			$response['department'] = $depart;
			$response['body'] = "Data Found";
		} else {
			$response['status'] = 201;
			$response['data'] = array('');
			$response['department'] = $depart;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

	public function saveLabMasterData()
	{
		$value = $this->input->post('data');
		if($value != null && $value != "")
		{
			$array_data = array();
			$deleteData = $this->db->delete('lab_admin_master_test');
			foreach($value as $item)
			{
				$department = explode('-',$item[4]);
				$department_id = 0;
				if($department > 1)
				{
					$department_id = $department[0];
				}
				$data  = array(
					'master_service_id'=>$item[0],
					'name' => $item[1],
					'description' => $item[2],
					'master_rate' => $item[3],
					'dep_id'=>$department_id,
					'status' => 1
				);
				array_push($array_data,$data);
			}
			$insert_data = $this->MasterModel->_insert('lab_admin_master_test',$array_data);
			if($insert_data->status == true)
			{
				$response['status'] = 200;
				$response['data'] = $array_data;
				$response['body'] = "Data Inserted Successfully";
			}
			else
			{
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		}
		else
		{
			$response['status'] = 201;
			$response['body'] = "No Data To Upload";
		}
		echo json_encode($response);
	}

}
