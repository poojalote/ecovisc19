<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AccessManagementController extends CI_Controller
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
		$this->load->model("ReportMakerModel");
	}

	public function index()
	{
		$this->load->view('AccessManagement/access_management', array('title' => 'Access management'));
	}

	public function branch_access_management()
	{
		$this->load->view('AccessManagement/branch_access_management', array('title' => 'Branch Level Access management'));
	}


	public function getAccessMgmtFormData()
	{
		$id = $this->input->post('id');
		$param = '';


		$query = $this->ReportMakerModel->_rawQuery("select * from permissionMaster");
		if ($query->totalCount > 0) {
			$data = $query->data;
			foreach ($data as $prow) {
				$selected = '';
				if (!is_null($id) && !empty($id)) {
					if (!empty($prow->branch_id)) {
						if (in_array($id, explode(',', $prow->branch_id))) {
							$selected = 'checked';
						}
					}
				}

				$param .= '<div class="col-md-6">
								<input type="checkbox" name="permission[]" ' . $selected . ' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxall">  <label for="per' . $prow->id . '">' . $prow->permission_name . '</label>
							</div>';
			}
		}
		$response['status'] = 200;
		$response['data'] = $param;
		echo json_encode($response);
	}

	public function getBranchAccessMgmtFormData()
	{
		$id = $this->input->post('id');
		$param = '';


		$query = $this->ReportMakerModel->_rawQuery("select * from departments_master");
		if ($query->totalCount > 0) {
			$data = $query->data;
			foreach ($data as $prow) {
				$selected = '';
				if (!is_null($id) && !empty($id)) {
					if (!empty($prow->branch_level_access)) {
						if (in_array($id, explode(',', $prow->branch_level_access))) {
							$selected = 'checked';
						}
					}
				}

				$param .= '<div class="col-md-6">
								<input type="checkbox" name="permission[]" ' . $selected . ' value="' . $prow->id . '" id="per' . $prow->id . '" class="checkboxall">  <label for="per' . $prow->id . '">' . $prow->name . '</label>
							</div>';
			}
		}
		$response['status'] = 200;
		$response['data'] = $param;
		echo json_encode($response);
	}

	public function getAllBranchesList()
	{
		$where = 'status=1';
		if (!is_null($this->input->post('company_id'))) {
			if ($this->input->post('company_id') != "") {
				$where = 'status=1 and company_id=' . $this->input->post('company_id');
			}
		}
		$branchOptions = '<option disabled selected>Select Branch</option>';
		$branchObject = $this->ReportMakerModel->getAllBranches($where);
		if ($branchObject->totalCount > 0) {
			foreach ($branchObject->data as $brow) {
				$branchOptions .= '<option value="' . $brow->id . '">' . $brow->name . '</option>';
			}
			$response['status'] = 200;
			$response['body'] = $branchOptions;
		} else {
			$response['status'] = 201;
			$response['body'] = $branchOptions;
		}
		echo json_encode($response);
	}

	public function saveAccessMgmtFormData()
	{
		if (!is_null($this->input->post('branches')) && $this->input->post('branches') != "") {
			$permission = $this->input->post('permission');
			if ($permission == "") {
				$permission = array();
			}
			$branch = $this->input->post('branches');
			$update_data = array();
			$query = $this->ReportMakerModel->_rawQuery("select * from permissionMaster");
			if ($query->totalCount > 0) {
				$data = $query->data;
				foreach ($data as $prow) {
					$branch_Ids = array();
					array_push($branch_Ids, $branch);
					if (in_array($prow->id, $permission)) {
						$branch_Ids = array_merge($branch_Ids, explode(',', $prow->branch_id));
					} else {
						$branchID = explode(',', $prow->branch_id);
						if (($key = array_search($branch, $branchID)) !== false) {
							unset($branchID[$key]);
						}
						$branch_Ids = $branchID;
					}
					$branch_Ids = array_unique($branch_Ids, SORT_REGULAR);
					$branchesID = implode(',', $branch_Ids);
					$udata = array('id' => $prow->id, 'branch_id' => $branchesID);
					array_push($update_data, $udata);
				}
			}
			$updateObject = $this->ReportMakerModel->_updateBatch('permissionMaster', $update_data, 'id');
			if ($updateObject->status == TRUE) {
				$response['status'] = 200;
				$response['body'] = 'Changes Saved';
				$response['branch_id'] = $branch;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Changes Not Saved';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Select Branch & Permission';
		}
		echo json_encode($response);
	}

	public function saveBranchAccessMgmtFormData()
	{
		if (!is_null($this->input->post('branches')) && $this->input->post('branches') != "") {
			$permission = $this->input->post('permission');
			if ($permission == "") {
				$permission = array();
			}
			$branch = $this->input->post('branches');
			$update_data = array();
			$query = $this->ReportMakerModel->_rawQuery("select * from departments_master");
			if ($query->totalCount > 0) {
				$data = $query->data;
				foreach ($data as $prow) {
					$branch_Ids = array();
					array_push($branch_Ids, $branch);
					if (in_array($prow->id, $permission)) {
						$branch_Ids = array_merge($branch_Ids, explode(',', $prow->branch_level_access));
					} else {
						$branchID = explode(',', $prow->branch_level_access);
						if (($key = array_search($branch, $branchID)) !== false) {
							unset($branchID[$key]);
						}
						$branch_Ids = $branchID;
					}
					$branch_Ids = array_unique($branch_Ids, SORT_REGULAR);
					$branchesID = implode(',', $branch_Ids);
					$udata = array('id' => $prow->id, 'branch_level_access' => $branchesID);
					array_push($update_data, $udata);
				}
			}
			// print_r($update_data);
			$updateObject = $this->ReportMakerModel->_updateBatch('departments_master', $update_data, 'id');
			if ($updateObject->status == TRUE) {
				$response['status'] = 200;
				$response['body'] = 'Changes Saved';
				$response['branch_id'] = $branch;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Changes Not Saved';
			}
		} else {
			$response['status'] = 201;
			$response['body'] = 'Select Branch & Permission';
		}
		echo json_encode($response);
	}

	public function user_management()
	{
		$this->load->view('UserManagement/user_management', array('title' => 'User management'));
	}

	public function getAllCompanyList()
	{
		$branchOptions = '<option selected disabled>Select All</option>';
		$branchObject = $this->ReportMakerModel->getAllCompany();
		if ($branchObject->totalCount > 0) {
			foreach ($branchObject->data as $brow) {
				$branchOptions .= '<option value="' . $brow->id . '">' . $brow->name . '</option>';
			}
			$response['status'] = 200;
			$response['body'] = $branchOptions;
		} else {
			$response['status'] = 201;
			$response['body'] = $branchOptions;
		}
		echo json_encode($response);
	}

	public function get_user_types()
	{
		$usertypes = array();
		$userObject = $this->ReportMakerModel->getAllUserTypes();
		if ($userObject->totalCount > 0) {
			$result = $userObject->data;
			foreach ($result as $row) {
				array_push($usertypes, $row->profile_name);
			}
			$response["data"] = $usertypes;
			$response["status"] = 200;
		} else {
			$response['status'] = 201;
			$response['data'] = $usertypes;
		}
		echo json_encode($response);
	}

	public function saveUsersMgmtFormData()
	{
		if (!is_null($this->input->post('company')) && $this->input->post('company') != "" && !is_null($this->input->post('branches')) && $this->input->post('branches') != "") {
			$user_id = $this->session->user_session->id;
			$Data1 = $this->input->post('arrData');
			$company = $this->input->post('company');
			$branch = $this->input->post('branches');
			$arrData = json_decode($Data1);
			$userTyepData = array();
			$users = "";
			$user_type_array = "";
			if (!empty($arrData)) {
				$userObject = $this->ReportMakerModel->getAllUserTypes();
				if ($userObject->totalCount > 0) {
					$userTyepResult = $userObject->data;
					foreach ($userTyepResult as $row) {
						$userTyepData[$row->id] = $row->profile_name;
					}
				}
				$user_name_list = array();
				foreach ($arrData as $item) {
					if ($item[1] != "") {
						array_push($user_name_list, $item[1]);
					}
				}

				$user_type_list = array();
				foreach ($arrData as $item) {
					if ($item[4] != "") {
						array_push($user_type_list, $item[4]);
					}
				}
				$user_type_array = implode(",", $user_type_list);

//				print_r(implode(",",$user_name_list));exit();
				if (count($user_name_list) > 0) {
					$users = implode(",", $user_name_list);
					$resultObject = $this->ReportMakerModel->_rawQuery('select user_name from users_master where find_in_set(user_name,"' . $users . '") group by user_name');
					if ($resultObject->totalCount > 0) {
						$listExistUser = array();
						foreach ($resultObject->data as $list_user) {
							array_push($listExistUser, $list_user->user_name);
						}
						$response['error_data'] = implode(', ', $listExistUser);
						$response['status'] = 202;
						$response['data'] = "Duplicate Value Encounter";
						echo json_encode($response);
						exit();
					} else {
						$newArray = array();
						$user_type = "";
						foreach ($arrData as $item) {
							if ($item[0] != "" && $item[1] != "" && $item[2] != "" && $item[3] != "") {
								$user_type = 1;
								if ($item[4] != "") {
									if (array_search($item[4], $userTyepData)) {
										$user_type = array_search('' . $item[4] . '', $userTyepData);
									}
								}
								$roleU=0;
								if($item[3]!="")
								{
									if (strcasecmp($item[3], 'Doctor') == 0) {
										$roleU=2;
									}
									if (strcasecmp($item[3], 'Nurse') == 0) {
										$roleU=3;
									}
									if (strcasecmp($item[3], 'Other') == 0) {
										$roleU=4;
									}
								}
								$data = array(
									"name" => $item[0],
									"user_name" => $item[1],
									"password" => $item[2],
									"status" => 1,
									"create_on" => date('Y-m-d H:i:s'),
									"create_by" => $user_id,
									"roles" => $roleU,
									"company_id" => $company,
									"branch_id" => $branch,
									"user_type" => $user_type,
									"default_access" => 1
								);
								array_push($newArray, $data);
							}
						}
						$this->load->model('UserModel');
						if (!empty($newArray)) {
							$insert_batch = $this->db->insert_batch("users_master", $newArray);
							if ($insert_batch == true) {

								$user_id_array = $this->UserModel->_rawQuery('select id,user_name,user_type from users_master where find_in_set(user_name,"' . $users . '")');
								if ($user_id_array->totalCount > 0) {
									$userIDdata = $user_id_array->data;
									foreach ($userIDdata as $row) {
										$user = "";
										$get_column_name = $this->db->query("select column_name from profile_management_table where id='" . $row->user_type . "' ");
										if ($this->db->affected_rows() > 0) {
											$res = $get_column_name->row();
											$user = $res->column_name;

											$roles = $this->db->query("select " . $res->column_name . ",permission_name from group_permission_table where type =2 and " . $res->column_name . " = 1")->result();
											if (count($roles) > 0) {
												foreach ($roles as $role) {
													$chkdepartmentData = array(
														'department_id' => $role->permission_name,
														'activity_status' => 1,
														'user_id' => $row->id,
														'create_on' => date('Y-m-d'),
														'create_by' => $user_id
													);
													$this->db->insert('role_master',$chkdepartmentData);
												}
												
											}
										}

										$get_permission_data = $this->UserModel->get_permission_data($user);
										if ($get_permission_data != false) {
											foreach ($get_permission_data as $r1) {
												$data_per = array(
													"permission_name" => $r1->permission_name,
													"user_id" => $row->id,
													"status" => 1
												);
												$this->db->insert("user_permission_table", $data_per);
											}
										}
									}
								}
								$response['status'] = 200;
								$response['data'] = "Data uploaded Successfully";
							} else {
								$response['status'] = 201;
								$response['data'] = "Failed To uplaod";
							}
						} else {
							$response['status'] = 201;
							$response['data'] = "Add Data In well Format";
						}
					}
				} else {
					$response['status'] = 201;
					$response['data'] = "Data Not Found";
				}

			} else {
				$response['status'] = 201;
				$response['data'] = "Data Not Uploaded";
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "Select Company and Branch Both";
		}
		echo json_encode($response);
	}

}
