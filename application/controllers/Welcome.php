<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
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
	public function index()
	{
		$this->load->view('login', array("title" => "Login"));
	}

	public function view_cam()
	{
		$this->load->view("video-cam", array("title" => "Cam"));
	}

	public function view_companies()
	{
		$this->load->view("admin/company/view_company", array("title" => "Companies"));
	}

	public function delete_patients()
	{
		$this->load->view("admin/delete_patients", array("title" => "Patients"));
	}


	public function view_branches()
	{
		$this->load->view("admin/branch/view_branch", array("title" => "Branches"));
	}

	public function from_companies()
	{
		$this->load->view("admin/company/company_form", array("title" => "Department"));
	}

	public function view_lab_branches()
	{
		$this->load->view("admin/lab_branch/view_lab_branch", array("title" => "Lab Branches"));
	}

	public function view_department()
	{
		$this->load->view("admin/department/view_departments", array("title" => "Department"));
	}

	public function from_department()
	{
		$this->load->view("admin/department/department_form", array("title" => "Department"));
	}

	public function view_template()
	{
		$this->load->view("admin/templates/section_form", array("title" => "Template"));
	}

	public function from_template()
	{
		$this->load->view("admin/templates/template_form", array("title" => "Template"));
	}

	public function view_users()
	{
		$this->load->view("admin/users/view_users", array("title" => "Users"));
	}

	public function from_user()
	{
		$this->load->view("admin/users/template_form", array("title" => "Users"));
	}

	public function view_patient()
	{
		$this->load->view("admin/patients/view_patients", array("title" => "Patients"));
	}

	public function from_patient($id = 0)
	{
		$this->load->view("admin/patients/patient_form", array("title" => "Patients", "patient_id" => $id));
	}

	public function sendMessage()
	{

		$this->load->model("Global_model");
		$this->Global_model->sendSms('919920482779', "Your Bed is Register");
	}

	public function test()
	{
		$this->load->view("welcome_message", array("title" => "test"));
	}

	public function getPatients()
	{
		$this->load->model('Patient_Model');
		$branch_id = $this->input->post('branch_id');
		$type = $this->input->post('type');
		if ($branch_id != null && $branch_id != "" && $type != null && $type != "") {
			$getBranchData = $this->Patient_Model->_select('branch_master', array('id' => $branch_id), '*', true);
			if ($getBranchData->totalCount > 0) {
				$branchData = $getBranchData->data;
				$patient_table = $branchData->tb_patient;
				$where = array('branch_id' => $branch_id);
				if ($type == 2) {
					$where = 'branch_id = "' . $branch_id . '" and (admission_date is not null or admission_date != \'0000-00-00 00:00:00\') and (discharge_date is null or discharge_date = \'0000-00-00 00:00:00\')';
				}
				if ($type == 3) {
					$where = 'branch_id = "' . $branch_id . '" and (discharge_date is not null or discharge_date != \'0000-00-00 00:00:00\')';
				}

				$order = array('id' => 'desc');
				$column_order = array('patient_name', 'contact', 'adhar_no');
				$column_search = array("patient_name", 'adhar_no', 'contact');

				$memData = $this->Patient_Model->getRows($_POST, $where, '*', $patient_table, $column_search, $column_order, $order);


				$filterCount = $this->Patient_Model->countFiltered($_POST, $patient_table, $where, $column_search, $column_order, $order);
				$totalCount = $this->Patient_Model->countAll($patient_table, $where);

				if (count($memData) > 0) {
					$tableRows = array();
					foreach ($memData as $row) {
						$tableRows[] = array(
							$row->id,
							$row->adhar_no,
							$row->patient_name,
							$row->contact,
							$row->blood_group,
							$row->birth_date
						);
					}
					$response = array(
						"draw" => (int)$_POST['draw'],
						"recordsTotal" => $totalCount,
						"recordsFiltered" => $filterCount,
						"data" => $tableRows,
					);
				} else {
					$response = array(
						"draw" => (int)$_POST['draw'],
						"recordsTotal" => $totalCount,
						"recordsFiltered" => $filterCount,
						"data" => $memData,
					);
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "No Data Found";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Paramter Missing";
		}
		echo json_encode($response);
	}

	public function DeletePatient()
	{
		$this->load->model('Patient_Model');
		$patient_id = $this->input->post('patient_id');
		$branch_id = $this->input->post('branch_id');
		$type = $this->input->post('type');
		if ($patient_id != null && $patient_id != "" && $branch_id != null && $branch_id != "") {
			$getBranchData = $this->Patient_Model->_select('branch_master', array('id' => $branch_id), '*', true);
			if ($getBranchData->totalCount > 0) {
				$branchData = $getBranchData->data;
				$patient_table = $branchData->tb_patient;
				$getPatientData = $this->Patient_Model->_select($patient_table, array('id' => $patient_id), '*', true);
				if ($getPatientData->totalCount > 0) {
					$Pdata = $getPatientData->data;
					$data = array(
						'branch_id' => $Pdata->branch_id,
						'admission_date' => $Pdata->admission_date,
						'admission_mode' => $Pdata->admission_mode,
						'tele_consulting_from' => $Pdata->tele_consulting_from,
						'is_icu_patient' => $Pdata->is_icu_patient,
						'adhar_no' => $Pdata->adhar_no,
						'patient_name' => $Pdata->patient_name,
						'gender' => $Pdata->gender,
						'birth_date' => $Pdata->birth_date,
						'blood_group' => $Pdata->blood_group,
						'contact' => $Pdata->contact,
						'other_contact' => $Pdata->other_contact,
						'address' => $Pdata->address,
						'district' => $Pdata->district,
						'sub_district' => $Pdata->sub_district,
						'patient_image' => $Pdata->patient_image,
						'patient_adhhar_image' => $Pdata->patient_adhhar_image,
						'pin_code' => $Pdata->pin_code,
						'create_on' => $Pdata->create_on,
						'create_by' => $Pdata->create_by,
						'modify_on' => $Pdata->modify_on,
						'modify_by' => $Pdata->modify_by,
						'status' => $Pdata->status,
						'bed_id' => $Pdata->bed_id,
						'roomid' => $Pdata->roomid,
						'discharge_date' => $Pdata->discharge_date,
						'event' => $Pdata->event,
						'swab_report' => $Pdata->swab_report,
						'is_transfered' => $Pdata->is_transfered,
						'close_bill_date' => $Pdata->close_bill_date,
						'bill_close_user' => $Pdata->bill_close_user,
						'mark_as_discharge' => $Pdata->mark_as_discharge,
						'type' => $Pdata->type,
						'billing_open' => $Pdata->billing_open,
						'payer' => $Pdata->payer,
						'patient_company' => $Pdata->patient_company,
						'work_location' => $Pdata->work_location,
						'discount_percent' => $Pdata->discount_percent,
						'patient_id' => $patient_id,
						'deleted_on' => date('Y-m-d H:i:s'),
						'deleted_by' => $this->session->user_session->id
					);
					$bed_id = $Pdata->bed_id;
					$room_id = $Pdata->roomid;
					if ($data != null) {
						try {
							$this->db->trans_start();
							$delete_patient = $this->Patient_Model->_delete($patient_table, array('id' => $patient_id));
							$releaseBed=false;
							if($delete_patient){
								$releaseBed = $this->Patient_Model->_update('com_1_bed', array('status' => 1), array('id' => $bed_id));
							}
							if($releaseBed){
								$insertPatient = $this->Patient_Model->_insert('deleted_patients', $data);
							}
							if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
							}
							$this->db->trans_complete();
						} catch (Exception $ex) {
							$this->db->trans_rollback();
						}
						if ($insertPatient) {
							$response['status'] = 200;
							$response['data'] = $data;
							$response['insertPatient'] = $insertPatient;
							$response['body'] = "Patient Deleted Successfully";
						} else {
							$response['status'] = 200;
							$response['data'] = $data;
							$response['body'] = "Error!Something Went Wrong";
						}
					} else {
						$response['status'] = 201;
						$response['body'] = "Something Went Wrong";
					}
				} else {
					$response['status'] = 201;
					$response['body'] = "Patients Details Not Found";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Branch Data not Found";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function Readmit()
	{
		$this->load->model('Patient_Model');
		$patient_id = $this->input->post('patient_id');
		$branch_id = $this->input->post('branch_id');
		if ($patient_id != null && $patient_id != "" && $branch_id != null && $branch_id != "") {
			$getBranchData = $this->Patient_Model->_select('branch_master', array('id' => $branch_id), '*', true);
			if ($getBranchData->totalCount > 0) {
				$branchData = $getBranchData->data;
				$patient_table = $branchData->tb_patient;
				$getPatientData = $this->Patient_Model->_select($patient_table, array('id' => $patient_id), '*', true);
				if ($getPatientData->totalCount > 0) {
					$Pdata = $getPatientData->data;
					$bed_id = $Pdata->bed_id;
					$checkBed = $this->Patient_Model->_select('com_1_bed', array('id' => $bed_id, 'status' => 1), '*', true);
					if ($checkBed->totalCount > 0) {
						$releaseBed = $this->Patient_Model->_update('com_1_bed', array('status' => 0), array('id' => $bed_id));
					}
					$update_patient = $this->Patient_Model->_update($patient_table, array('discharge_date' => null), array('id' => $patient_id));
					if ($update_patient) {
						$response['status'] = 200;
						$response['body'] = "Patient Readmitted";
					} else {
						$response['status'] = 201;
						$response['body'] = "Something Went Wrong";
					}
				} else {
					$response['status'] = 201;
					$response['body'] = "Error! Something Went Wrong";
				}
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}
}
