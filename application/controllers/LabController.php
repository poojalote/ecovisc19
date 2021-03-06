<?php

require_once 'HexaController.php';

class LabController extends HexaController
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
        $this->load->view("LabCenter/viewLabDashboard",array("title"=>"Lab Dashboard"));
    }

    public function labMaster($department_id = 0, $section_id = 0, $QueryParamter = null){
        $this->load->view("LabCenter/labMasterForm",array("title"=>"Lab Master", "department_id" => $department_id, "section_id" => $section_id, "queryParam" => $QueryParamter));
    }
    public function getMasterTestData()
	{
		$search = $this->input->post('searchTerm');
		$branch_id = $this->session->user_session->branch_id;
		$data = array();
		$query = $this->MasterModel->_rawQuery("select master_service_id,name from lab_master_test where status=1 and branch_id=".$branch_id." and name like '%".$search."%' limit 40");

		if ($query->totalCount > 0) {
			$res = $query->data;
			foreach ($res as $val) {
						$data[] = array("id" => $val->master_service_id, "text" => $val->name);
			}
		}
		echo json_encode($data);
	}
	public function getLabMasterChildEntryExcelData()
	{
		if(!is_null($this->input->post('masterId')) && $this->input->post('masterId')!="")
		{
			$service_code=$this->input->post('masterId');
			$branch_id = $this->session->user_session->branch_id;
//			$service_data = $this->MasterModel->_rawQuery('select sc.*,(select name from lab_unit_master where id=sc.unit) as unit_name from lab_child_test sc where sc.branch_id=' . $branch_id . ' and sc.status=1 and sc.service_code="' . $service_code . '"');
			$service_data = $this->MasterModel->_rawQuery('select sc.*,sc.unit as unit_name from lab_child_test sc where sc.branch_id=' . $branch_id . ' and sc.status=1 and sc.service_code="' . $service_code . '"');
//print_r($service_data);exit();

//			$unitData=$this->MasterModel->_rawQuery('select id,name from lab_unit_master where status=1');
			$unitSourceData=array();
//			if($unitData->totalCount>0)
//			{
//				$SourceData=$unitData->data;
//				array_push($unitSourceData,'NA');
//				foreach ($SourceData as $udata)
//				{
//					array_push($unitSourceData,$udata->id.'-'.$udata->name);
//				}
//			}
			$masterDataM=array();
			if($service_data->totalCount>0)
			{
				$masterData=$service_data->data;
				foreach ($masterData as $value)
				{
					$unit='';
					if($value->unit_name!=null && $value->unit_name!="")
					{
						$unit=$value->unit_name;
					}

					$childData=array($value->id,$value->name,$value->method,$unit,$value->referance_range);
					array_push($masterDataM,$childData);
				}
				$response['status']=200;
				$response['rows']=$masterDataM;
				$response['source']=$unitSourceData;
			}
			else{
				$mainAdminservice_data = $this->MasterModel->_rawQuery('select sc.*,sc.unit as unit_name from lab_admin_child_test sc where sc.status=1 and sc.service_code="' . $service_code . '"');
				if($mainAdminservice_data->totalCount>0)
				{
					$adminmasterData=$mainAdminservice_data->data;
					foreach ($adminmasterData as $value)
					{
						$unit='';
						if($value->unit_name!=null && $value->unit_name!="")
						{
							$unit=$value->unit_name;
						}

						$childData=array($value->id,$value->name,$value->method,$unit,$value->referance_range);
						array_push($masterDataM,$childData);
					}
					$response['status']=200;
					$response['rows']=$masterDataM;
					$response['source']=$unitSourceData;
				}
				else{
					$response['status']=201;
					$response['source']=$unitSourceData;
				}
			}
		}
		else{
			$response['status']=201;
		}
		echo json_encode($response);
	}
	public function saveSubGroupChildData()
	{
		if(!is_null($this->input->post('master_id')) && $this->input->post('master_id')!="")
		{
			$master_id=$this->input->post('master_id'); //service_code
			$arrayData=$this->input->post('arrayData');
			$branch_id = $this->session->user_session->branch_id;
			$user_id = $this->session->user_session->id;
			$arrData = json_decode($arrayData);
			if(!empty($arrData)) {
				$updateData = array();
				$insertData = array();
				$errorArray = array();
				$i = 1;
				$count=1;
				$cnt=count($arrData);
				foreach ($arrData as $arrValue) {

						if($count<$cnt)
						{

						if ($arrValue[1] != "" && $arrValue[3] != "" && $arrValue[4] != "") {
							$unit = '';
							if ($arrValue[3] != "") {
//								$unitC = explode('-', $arrValue[3]);
//								if (count($unitC) > 1) {
//									$unit = $unitC[0];
//								} else {
//									$unitObject = $this->MasterModel->_rawQuery('select id from lab_unit_master where name = "' . $arrValue[3] . '" limit 1');
//									if ($unitObject->totalCount > 0) {
//										$unit = $unitObject->data[0]->id;
//									} else {
//										$data = array('name' => $arrValue[3], 'transaction_date' => date('Y-m-d H:i:s'), 'status' => 1);
//										$insertObject = $this->MasterModel->_insert('lab_unit_master', $data);
//										if ($insertObject->status == TRUE) {
//											$unit = $insertObject->inserted_id;
//										}
//									}
//								}
								$unit = $arrValue[3];
							}
							if ($arrValue[0] != "") {

								$uData = array('id' => $arrValue[0], 'name' => $arrValue[1], 'method' => $arrValue[2], 'unit' => $unit, 'referance_range' => $arrValue[4], 'service_code' => $master_id, 'modify_by' => $user_id, 'modify_at' => date('Y-m-d H:i:s'), 'status' => 1);
								array_push($updateData, $uData);
							} else {
								if ($arrValue[1] != "") {

									$iData = array('name' => $arrValue[1], 'method' => $arrValue[2], 'branch_id' => $branch_id, 'user_id' => $user_id, 'transaction_date' => date('Y-m-d H:i:s'), 'status' => 1, 'unit' => $unit, 'referance_range' => $arrValue[4], 'service_code' => $master_id);
									array_push($insertData, $iData);
								}
							}
						} else {
							array_push($errorArray, "Row " . $i);
						}
						$i++;

						}
					$count++;
				}
				if (count($errorArray) > 0) {
					$response['status'] = 202;
					$response['body'] = "Failed To uplaod lab data";
					$response['error'] = implode(',',$errorArray);
					echo json_encode($response);
					exit();
				} else {


//				print_r($insertData);exit();
				$result = false;
				try {
					$this->db->trans_start();
					$this->db->update('lab_child_test', array('status' => 0), array('service_code' => $master_id));
					if (!empty($updateData)) {
						$this->db->update_batch('lab_child_test', $updateData, 'id');
					}
					if (!empty($insertData)) {
						$this->db->insert_batch('lab_child_test', $insertData);
					}
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$result = false;
						$body_message = 'something went wrong';
					} else {
						$this->db->trans_commit();
						$result = true;
						$body_message = 'Data Uploaded';
					}
					$this->db->trans_complete();
				} catch (Exception $exc) {
					$result = false;
					$body_message = 'something went wrong';
					$this->db->trans_rollback();
					$this->db->trans_complete();

				}
				if ($result == true) {
					$response['status'] = 200;
					$response['body'] = "Data uploaded Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Failed To uplaod lab data";
				}
			}
			}
			else
			{
				$response['status']=201;
				$response['body']='Add Data';
			}
		}
		else{
			$response['status']=201;
			$response['body']='Changes Not Saved';
		}
		echo json_encode($response);
	}
	public function RemoveChildTestData()
	{
		if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
		{
			$child_id=$this->input->post('id');
			$updateData=$this->MasterModel->_update('lab_child_test',array('status'=>0),array('id'=>$child_id));
			if($updateData->status==TRUE)
			{
				$response['status']=200;
				$response['body']='Data Deleted Successfully';
			}
			else{
				$response['status']=201;
				$response['body']='Changes Not Saved';
			}
		}
		else{
			$response['status']=201;
			$response['body']='Changes Not Saved';
		}
		echo json_encode($response);
	}
}
