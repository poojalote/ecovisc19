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
	public function labChildServices()
	{
		$this->load->view('LabMasterAdmin/labChildServices', array('title' => 'Lab Master Services'));
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
			$resultStatus = False;
			$servicemasterObject = $this->MasterModel->_rawQuery('select id from lab_admin_master_test where status=1 and master_service_id not in (select service_id from service_master where status=1 and branch_id="'.$branch_id.'") and find_in_set(id,"' . $labData . '")');
			if($servicemasterObject->totalCount>0)
			{
				$errorArray=array();
				foreach($servicemasterObject->data as $smRow)
				{
					array_push($errorArray,$smRow->id);
				}
				$response['status']=202;
				$response['body']='Add Services For Branch Or uncheck service';
				$response['error']=$errorArray;
				echo json_encode($response);
				exit();
			}
			else {
				try {
					$this->db->trans_start();

					$masterObject = $this->MasterModel->_rawQuery('select * from lab_admin_master_test where status=1 and find_in_set(id,"' . $labData . '")');
					$insert_batch = array();
					if ($masterObject->totalCount > 0) {
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
					}
					$this->db->where('branch_id', $branch_id)->delete('lab_master_test');
					if (count($insert_batch) > 0) {
						$this->db->insert_batch('lab_master_test', $insert_batch);
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
					$response['body'] = 'Changes Saved';
				} else {
					$response['status'] = 201;
					$response['branch_id'] = $branch_id;
					$response['body'] = 'Changes Not Saved';
				}
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
			$resultStatus = False;
			try {
				$this->db->trans_start();
				$childObject = $this->MasterModel->_rawQuery('select * from lab_admin_child_test where status=1 and find_in_set(id,"' . $labData . '") and service_code="'.$lab_master_test.'"');
				$insertChild = array();
				if($childObject->totalCount>0){
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

				}
				$this->db->where(array('branch_id'=> $branch_id,'service_code'=>$lab_master_test))->delete('lab_child_test');
				if (count($insertChild) > 0) {
					$this->db->insert_batch('lab_child_test', $insertChild);
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
	public function getLabMasterTest()
	{
		$company_id = $this->session->userdata('company_id');
		$group_data_array = $this->MasterModel->_rawQuery('select * from lab_admin_master_test where status=1');
		$departments = $this->MasterModel->_rawQuery('select * from lab_admin_department_master where status=1');
		$depart  = array();
		$departmentArray=array();
		if($departments->totalCount> 0 )
		{
			foreach($departments->data as $key=>$value)
			{
				array_push($depart,$value->name);
				$departmentArray[$value->id]=$value->name;
			}
		}
		$data_array = array();
		if ($group_data_array->totalCount > 0) {
			$labData = $group_data_array->data;
			foreach($labData as $row)
			{
				$dep_id = "";
				if(array_key_exists($row->dep_id,$departmentArray))
				{
					$dep_id = $departmentArray[$row->dep_id];
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

	public function saveLabMainMasterData()
	{

		$value = $this->input->post('data');
		$mData=json_decode($value);
		$mData=(array)$mData;
//		print_r($mData);exit();
		if($mData != null && $mData != "")
		{
			$array_data = array();
			$depData=array();
			$resultStatus = False;
			try {
				$this->db->trans_start();
			$depObject=$this->MasterModel->_rawQuery('select id,name from lab_admin_department_master where status=1');
			if($depObject->totalCount>0)
			{
				foreach ($depObject->data as $dData)
				{
					$dname=strtolower($dData->name);
					$depData[$dname]=$dData;
				}
			}

			foreach($mData as $item)
			{
				if($item[1]!="" && $item[1]!="" && $item[3]!="" && $item[4]!="")
				{
					$department_id='';
					if($item[4]!="")
					{
						if(array_key_exists(strtolower($item[4]),$depData))
						{
							$department_id=$depData[strtolower($item[4])]->id;
						}
					}
					$data  = array(
						'master_service_id'=>$item[0],
						'name' => $item[1],
						'description' => $item[2],
						'master_rate' => $item[3],
						'dep_id'=>$department_id,
						'status' => 1,
						'transaction_date'=>date('Y-m-d H:i:s')
					);
					array_push($array_data,$data);
				}
			}
			$deleteData = $this->db->where(array('status'=>1))->update('lab_admin_master_test',array('status'=>0));
			$insert_data = $this->db->insert_batch('lab_admin_master_test',$array_data);
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$resultStatus = FALSE;
				} else {
					$this->db->trans_commit();
					$resultStatus = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $ex) {
				$resultStatus = FALSE;
				$this->db->trans_rollback();
			}
			if($resultStatus== TRUE)
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
	public function getLabMainMasterDataOption(){
		$validObject = $this->is_parameter(array("type", "searchTerm"));
		$response = array();
		if ($validObject->status) {
			$type = $validObject->param->type;
			$search = $validObject->param->searchTerm;
			$where = array();
			if ((int)$type != 1)
				$where = array("status"=>1);
				$userData = $this->db->select(array("master_service_id", "name"))->where($where)->like("name", $search)->limit(10, 0)->get("lab_admin_master_test")->result();
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
	public function getMainLabAdminChildTest()
	{
		if (!is_null($this->input->post('lab_master_test')) && $this->input->post('lab_master_test') != "" && $this->input->post('lab_master_test') != "null") {
			$lab_master_test = $this->input->post('lab_master_test');
			$group_data_array = $this->MasterModel->_rawQuery('select * from lab_admin_child_test where service_code="'.$lab_master_test.'" and status=1');
			$response['query']=$group_data_array->last_query;
			$data_array=array();
			if ($group_data_array->totalCount > 0) {
				$labData = $group_data_array->data;
				foreach ($labData as $row) {
					$data = array(
						$row->name,
						$row->method,
						$row->unit,
						$row->referance_range,
						$row->child_id,
						$row->id,
					);
					array_push($data_array, $data);
				}
				$response['status'] = 200;
				$response['data'] = $data_array;
				$response['body'] = "Data Found";
			} else {
				$response['status'] = 201;
				$response['data'] = array('');
				$response['body'] = "No Data Found";
			}
		}
		else{
			$response['status'] = 201;
			$response['data'] = array('');
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}
	public function saveMainChildServices()
	{

		if(!is_null($this->input->post('lab_master_test')) && $this->input->post('lab_master_test')!="" && $this->input->post('lab_master_test')!="null")
		{
			$service_code=$this->input->post('lab_master_test');
			$data=$this->input->post('data');
			$childData=json_decode($data);
			$childData = (array)$childData;
			$session_data = $this->session->user_session;
			$user_id = $session_data->id;
			if(count($childData)>0)
			{
				$childRows=array();
				foreach ($childData as $crow)
				{
					if($crow!=null )
					{
						if($crow[0]!=""){

							$cData=array('name'=>$crow[0],
								'method'=>$crow[1],
								'user_id'=>$user_id,
								'transaction_date'=>date('Y-m-d H:i:s'),
								'status'=>1,
								'unit'=>$crow[2],
								'referance_range'=>$crow[3],
								'child_id'=>$crow[4],
								'service_code'=>$service_code);
							array_push($childRows,$cData);
						}

					}
				}
				$resultStatus = FALSE;
				try {
					$this->db->trans_start();
					$this->db->where(array('service_code'=>$service_code))->update('lab_admin_child_test',array('status'=>0));
					if(count($childRows)>0)
					{
						$this->db->insert_batch('lab_admin_child_test',$childRows);
					}
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$resultStatus = FALSE;
					} else {
						$this->db->trans_commit();
						$resultStatus = TRUE;
					}
					$this->db->trans_complete();
				} catch (Exception $ex) {
					$resultStatus = FALSE;
					$this->db->trans_rollback();
				}
				if($resultStatus==TRUE)
				{
					$response['status'] = 200;
					$response['body'] = "Data Added Successfully";
				}
				else{
					$response['status'] = 201;
					$response['body'] = "Data Not Added";
				}
			}
			else{
				$response['status'] = 201;
				$response['body'] = "No Data Found";
			}
		}
		else{
			$response['status'] = 201;
			$response['body'] = "No Data Found";
		}
		echo json_encode($response);
	}

}
