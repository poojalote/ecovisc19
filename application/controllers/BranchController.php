<?php
require_once 'HexaController.php';

/**
 * @property  BranchModel BranchModel
 * @property  DepartmentModel DepartmentModel
 */
class BranchController extends HexaController
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *        http://example.com/index.php/welcome
	 *    - or -
	 *        http://example.com/index.php/welcome/index
	 *    - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{

		parent::__construct();

		// load model
		$this->load->model('DepartmentModel');
		$this->load->model('BranchModel');
		$this->load->model('TemplateModel');

		// load base_url
		$this->load->helper('url');

	}

	public function index()
	{
		$this->load->model('BranchModel');
		$table_name = "branch_master";
		$result['company_data'] = $this->BranchModel->all_company($table_name);
		// print_r($result);
		$this->load->view('header');
		$this->load->view('index2', $result);
		$this->load->view('footer');
	}

	public function uploadCompany()
	{

		if (!is_null($this->input->post('company_name')) && $this->input->post('company_name') != "") {

			$c_name = $this->input->post('company_name');
			$branch_id = $this->input->post('forward_company');
			$company_id = $this->input->post('dcompany_id');
			$session_data = $this->session->user_session;
			$user_id = $session_data->id;

			$table_name = 'branch_master';
			// company id found so request for update company name
			if (!empty($branch_id)) {
				$companyData = array('name' => $c_name,
					'company_id' => $company_id,
					'create_on' => date('Y-m-d'),
					'create_by' => $user_id);
				$where = array('id' => $branch_id);
				$patientTableResult = $this->createCompanyPatientAutoTable();
				$result = $this->BranchModel->updateForm($table_name, $companyData, $where, $patientTableResult->fields);
				if ($result == TRUE) {
					$response["status"] = 200;
					$response["data"] = "updated successfully";
				} else {
					$response["status"] = 201;
					$response["data"] = "Not updated";
				}
			} else {
				// insert new company
				$companyData = array('name' => $c_name,
					'status' => 1,
					'company_id' => $company_id,
					'create_on' => date('Y-m-d'),
					'create_by' => $user_id);
				$patientTableResult = $this->createCompanyPatientAutoTable();
				$result = $this->BranchModel->addForm($table_name, $companyData, $patientTableResult->fields);
				if ($result->status == TRUE) {
					$response["status"] = 200;
					$response["data"] = "uploaded successfully";
					$response["body"] = $result;
				} else {
					$response["status"] = 201;
					$response["data"] = "Not Found";
				}
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function createCompanyPatientAutoTable()
	{

		$fields = array(
			'branch_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'default' => '1'
			),
			'admission_date' => array(
				'type' => 'DATETIME',
				// 'unique' => TRUE,
			),
			'admission_mode' => array(
				'type' => 'int',
				'constraint' => 11,
				'default' => '2'
			),
			'tele_consulting_from' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'is_icu_patient' => array(
				'type' => 'INT',
				'constraint' => 11
				// 'unique' => TRUE,
			),
			'adhar_no' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
				// 'unique' => TRUE,
			),
			'patient_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'gender' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'birth_date' => array(
				'type' => 'DATE',
				'null' => TRUE,
			),
			'blood_group' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
			),
			'contact' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
			),
			'other_contact' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => TRUE,
			),
			'address' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'district' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'sub_district' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'patient_image' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'patient_adhhar_image' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'pin_code' => array(
				'type' => 'TEXT',
				'constraint' => '255',
				'null' => TRUE,
			),
			'create_on' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'create_by' => array(
				'type' => 'INT',
				'constraint' => '11',
				'null' => TRUE,
			),
			'modify_on' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'modify_by' => array(
				'type' => 'INT',
				'constraint' => '11',
				'null' => TRUE,
			),
			'status' => array(
				'type' => 'INT',
				'constraint' => '11',
				'default' => '1',
			),
			'bed_id' => array(
				'type' => 'INT',
				'constraint' => '11',

			),
			'roomid' => array(
				'type' => 'INT',
				'constraint' => '11',

			),
			'significant_event' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'discharge_condition' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'medication' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'physical_activity' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'urgent_care' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'is_transfered' => array(
				'type' => 'int',
				'constraint' => '11',
			),
			'transfer_to' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'transfer_reason' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'mark_as_discharge' => array(
				'type' => 'int',
				'default' => '0',
			)
		);
		$patientTable = new stdClass();
		$patientTable->fields = $fields;
		return $patientTable;
	}

	public function getCompanyTableData()
	{
		$validationObject = $this->is_parameter(array("type"));

		if ($validationObject->status) {
			$type = $validationObject->param->type;

			$where = array();
			if (!is_null($this->input->post('companyId')) && $this->input->post('companyId') != "") {
				$companyId = $this->input->post('companyId');
				$where["cm.id"] = $companyId;
			}
			$resultObject = $this->DepartmentModel->selectCompanyWithDepartment($where);

			if ($resultObject->totalCount > 0) {
				$tableRows = array();
				foreach ($resultObject->data as $row) {
					$tableRows[] = array(
						$row->name,
						$row->status,
						$row->create_on,
						$row->create_by,
						$row->id,
						$row->departments
					);
				}
				$results = array(
					"draw" => (int)$_POST['draw'],
					"recordsTotal" => $resultObject->totalCount,
					"recordsFiltered" => $resultObject->totalCount,
					"data" => $tableRows
				);
			} else {
				$results = array(
					"draw" => (int)$_POST['draw'],
					"recordsTotal" => $resultObject->totalCount,
					"recordsFiltered" => $resultObject->totalCount,
					"data" => $resultObject->data
				);
			}
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => array()
			);
		}
		echo json_encode($results);
	}

	public function getBranches()
	{
		$validationObject = $this->is_parameter(array("company_id"));
		if ($validationObject->status) {

			$resultObject = $this->DepartmentModel->_select("branch_master", array("company_id" => $validationObject->param->company_id, "status" => 1), "*", false);

			$options = "";
			if ($resultObject->totalCount > 0) {
				foreach ($resultObject->data as $branch) {
					$options .= "<option value='" . $branch->id . "'>" . $branch->name . "</option>";
				}
			}
			if ($options != "") {
				$response["status"] = 200;
			} else {
				$response["status"] = 201;
			}

			$response["option"] = $options;
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getCompanyDataById()
	{

		if (!is_null($this->input->post('companyId'))) {
			$companyId = $this->input->post('companyId');
			$tableName = 'branch_master';
			//$where = array('id' => $depId);
			$where = "where id='" . $companyId . "'";
			$resultObject = $this->DepartmentModel->selectDataById($tableName, $where);
			if ($resultObject->totalCount > 0) {
				$response["status"] = 200;
				$response["body"] = $resultObject->data;
			} else {
				$response["status"] = 201;
				$response["body"] = "Data Not Found";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function deleteCompany()
	{
		if (!is_null($this->input->post('companyId'))) {
			$companyId = $this->input->post('companyId');

			$table_name = 'branch_master';
			$departmentData = array('status' => 0);
			$where = array('id' => $companyId);
			$result = $this->DepartmentModel->updateForm($table_name, $departmentData, $where);
			if ($result == TRUE) {
				$response["status"] = 200;
				$response["body"] = "Deleted successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Not Deleted";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function ChangeCompanyStatus()
	{
		if (!is_null($this->input->post('companyId')) && !is_null($this->input->post('status'))) {
			$companyId = $this->input->post('companyId');
			$status = $this->input->post('status');
			$table_name = 'branch_master';
			$departmentData = array('status' => $status);
			$where = array('id' => $companyId);
			$result = $this->DepartmentModel->updateForm($table_name, $departmentData, $where);
			if ($result == TRUE) {
				$response["status"] = 200;
				$response["body"] = "Branch status change successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Status Not Changed";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}


	public function select_company($id)
	{
		// print_r($id);
		$condition = array("id" => $id);
		$table_name = "branch_master";
		$this->load->model('BranchModel');

		$user_data = $this->BranchModel->select($table_name, $condition);
		// print_r($user_data);
		echo json_encode($user_data);


	}

	public function delete_company($id)
	{
		$condition = array("id" => $id);
		$table_name = 'branch_master';
		$this->load->model('BranchModel');

		$user_data = $this->BranchModel->delete($table_name, $condition);
		print_r($user_data);


	}

	public function fetch_user()
	{
		$this->load->model('BranchModel');
		$fetch_data['data'] = $this->BranchModel->get_all_data();
		// print_r($fetch_data);exit();

		echo json_encode($fetch_data);


		// $data = array();
		// foreach ($fetch_data as $row) {
		// 	$sub_array = array();
		// 		// "id" => $row->id,
		// 		// "name" => $row->name);
		// 	$sub_array[] = $row->id;
		// 	$sub_array[] $row->name;
		// 	$data = $sub_array;
		// }
		// $output = array(
		// 					"draw" => intval($_POST["draw"]),
		// 					"recordsTotal" => $this->BranchModel->get_all_data(),
		// 					"recordsFiltered" => $this->BranchModel->get_filtered_data(),
		// 					"data"      => $data
		// 					);
		// // print_r($output);
		// echo json_encode($output);
	}

	public function labMasterData()
	{
		$this->load->view('admin/branch/lab_master_data', array('title' => 'Lab Master Data'));
	}
	public function labMasterData_child()
	{
		$this->load->view('admin/branch/lab_master_data_c', array('title' => 'Lab Master Data'));
	}


	public function getLabMasterData()
	{
		$id = $this->input->post('id');
		$param = '';

		$checkbox = '';
		$query = $this->db->get("lab_admin_master_test")->result();
		if (!empty($query)) {
			foreach ($query as $prow) {
				$query_lmd = $this->db->where(array('branch_id'=>$id,'name'=>$prow->name))->get("lab_master_test")->row();
				$selected = '';
				// if (!is_null($id) && !empty($id)) {
					if (!empty($query_lmd)) {
						$selected = 'checked';
					}
				// }
				$checkbox .= '<div class="col-md-6">
								<input type="checkbox" name="labMasterData[]" '.$selected.' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxall">  <label for="per' . $prow->id . '">' . $prow->name . '</label>
							</div>';
			}
		}
		$response['status'] = 200;
		$response['data'] = $checkbox;
		echo json_encode($response);
	}

	public function getLabMasterDataOption(){
		$id = $this->input->post('id');
		$query_lmd = $this->db->where(array('branch_id'=>$id))->get("lab_master_test")->result();
		$option = '<option>Select Lab Master Data</option>';
		$response = array();
		if (!empty($query_lmd)) {
			foreach ($query_lmd as $value) {
				$option .= '<option value="'.$value->master_service_id.'">'.$value->name.'</option>';
			}

			$response['status']=200;
			$response['data']=$option;
		}else{
			$response['status']=201;
			$response['data']="No option found";
		}

		echo json_encode($response);
	}

	public function saveLabMasterData()
	{
		$branch_id = $this->input->post('branches');
		$labMasterData = $this->input->post('labMasterData');
		$session_data = $this->session->user_session;
		$user_id = $session_data->id;
		$insert_batch = array();
		for ($i=0; $i < count($labMasterData); $i++) { 
			$query = $this->db->where(array('id'=>$labMasterData[$i]))->get("lab_admin_master_test")->row();
			// foreach ($query as $value) {
				if(!is_null($query->name) || $query->name!=''){
					$name = $query->name;
				}else{
					$name = '';
				}
				if(!is_null($query->description) && $query->description!=''){
					$description = $query->description;
				}else{
					$description = '';
				}

				$res  = array(
					'name'=> $name,
					'description'=> $description,
					'branch_id'=>$branch_id,
					'user_id'=>$user_id,
					'transaction_date'=>date('Y-m-d H:i:s'),
					'status'=>1,
					'dep_id'=>$query->dep_id, 
					'master_service_id'=>$query->master_service_id,
					'master_rate'=>$query->master_rate,
				);
				array_push($insert_batch,$res);
			// }
		}
		$this->db->where('branch_id', $branch_id)->delete('lab_master_test');
		if($this->db->insert_batch('lab_master_test',$insert_batch)){
			$response['status'] = 200;
			$response['branch_id'] = $branch_id;
			$response['body'] = 'Inserted Successfully';
		}else{
			$response['status'] = 201;
			$response['branch_id'] = $branch_id;
			$response['body'] = 'Inserted Not Successfully';
		}
		// $this->db->insert_batch('mytable', $data); 
		echo json_encode($response);
	}

	public function getHtmlLabAdminChildTest(){
		$id = $this->input->post('id');
		$branch_id = $this->input->post('branch_id');

		$param = '';

		$checkbox = '';
		// echo $id;die();
		$query = $this->db->where('service_code',$id)->get("lab_admin_child_test")->result();
		if (!empty($query)) {
			foreach ($query as $prow) {
				$query_lmd = $this->db->where(array('name'=>$prow->name,'branch_id'=>$branch_id,'service_code'=>$prow->service_code))->get("lab_child_test")->row();
				$selected = '';
				// if (!is_null($id) && !empty($id)) {
					if (!empty($query_lmd)) {
						$selected = 'checked';
					}
				// }
				$checkbox .= '<div class="col-md-6">
								<input type="checkbox" name="labChildData[]" '.$selected.' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxall">  <label for="per' . $prow->id . '">' . $prow->name . '</label>
							</div>';
			}
		}
		$response['status'] = 200;
		$response['data'] = $checkbox;
		echo json_encode($response);
	}


	public function saveLabChildData()
	{
		$branch_id = $this->input->post('branch_id');
		$lab_master_test = $this->input->post('lab_master_test');
		$labChildData = $this->input->post('labChildData');

		$session_data = $this->session->user_session;
		$user_id = $session_data->id;
		
		$insert_batch = array();
		for ($i=0; $i < count($labChildData); $i++) { 
			$query = $this->db->where(array('id'=>$labChildData[$i]))->get("lab_admin_child_test")->row();
			// foreach ($query as $value) {
				if(!is_null($query->name) || $query->name!=''){
					$name = $query->name;
				}else{
					$name = '';
				}
				if(!is_null($query->method) && $query->method!=''){
					$method = $query->method;
				}else{
					$method = '';
				}
				if(!is_null($query->unit) && $query->unit!=''){
					$unit = $query->unit;
				}else{
					$unit = '';
				}
				if(!is_null($query->referance_range) && $query->referance_range!=''){
					$referance_range = $query->referance_range;
				}else{
					$referance_range = '';
				}
				if(!is_null($query->child_id) && $query->child_id!=''){
					$child_id = $query->child_id;
				}else{
					$child_id = '';
				}

				$res  = array(
					'branch_id'=>$branch_id,
					'name'=>$name, 
					'method'=>$method, 
					'user_id'=>$user_id, 
					'transaction_date'=>date('Y-m-d H:i:s'), 
					'status'=>1, 
					'unit'=>$unit, 
					'referance_range'=>$referance_range, 
					'master_id'=>$query->master_id, 
					'child_id'=>$child_id,
					'service_code'=>$query->service_code
					
				);
				array_push($insert_batch,$res);
			// }
		}
		$this->db->where(array('branch_id'=>$branch_id,'service_code'=>$lab_master_test))->delete('lab_child_test');
		if($this->db->insert_batch('lab_child_test',$insert_batch)){
			$response['status'] = 200;
			$response['branch_id'] = $branch_id;
			$response['body'] = 'Inserted Successfully';
		}else{
			$response['status'] = 201;
			$response['branch_id'] = $branch_id;
			$response['body'] = 'Inserted Not Successfully';
		}
		// $this->db->insert_batch('mytable', $data); 
		echo json_encode($response);
	}

}
