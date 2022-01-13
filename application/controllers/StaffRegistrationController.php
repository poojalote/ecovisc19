<?php
require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
require_once 'HexaController.php';

/**
 * @property  Patient_Model Patient_Model
 */
class StaffRegistrationController extends HexaController
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
		$this->load->model('Patient_Model');
		$this->load->model('StaffModel');

		// load base_url
		$this->load->helper('url');

	}

	public function index()
	{
		$this->load->view('Staff/staff_registration', array("title" => "Staff Registration"));
	}

	public function get_profile_type()
	{
		$tableName = 'staff_profile';
		$resultObject = $this->StaffModel->getSelectOptionsData($tableName);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Profile</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->id . '">' . $value->name . '</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}

	public function get_staff_zone()
	{
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$branch_id = $this->session->user_session->branch_id;
		$where="where branch_id='".$branch_id."'";
		$resultObject = $this->StaffModel->getSelectWhereData($hospital_room_table,$where);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Zone</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->id . '">' . $value->room_no . ' - '.$value->ward_no.'</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}


	public function fill()
	{
		$code = $_POST['code'];
		// print_r($code);exit();

		$xml = simplexml_load_string($code);
		echo json_encode($xml);


	}

	public function add_staff()
	{

		if (!is_null($this->input->post("name")) && !is_null($this->input->post("contact"))) {

			if ($this->input->post("adhardetails") == 1 && is_null($this->input->post("adhhar_no"))) {
				$response["status"] = 201;
				$response["body"] = "enter Adhar No";
				echo json_encode($response);
				exit;
			}
			$adhardetails = $this->input->post("adhardetails");
			if ($adhardetails == 1) {
				$adhhar_no = $this->input->post("adhhar_no");
			} else {
				$adhhar_no = "";
			}
			$patient_name = $this->input->post("name");
			$patient_image = $this->input->post("patient_image");
			$patient_aadhar_image = $this->input->post("patient_adhhar_image");

			$contact = $this->input->post("contact");
			$patientId = $this->input->post("patientId");
			$gender = $this->input->post("gender");
			$birth_day = $this->input->post("birth_day");
			$blood_group = $this->input->post("blood_group");
			$vtc = $this->input->post("vtc");
			$alter_contact = $this->input->post("alter_contact");
			$location = $this->input->post("location");
			$dist = $this->input->post("dist");
			$sub_dist = $this->input->post("sub_dist");
			$postal_code = $this->input->post("postal_code");

			$staff_profile = $this->input->post("staff_profile");
			$staff_type = $this->input->post("staff_type");
			$staff_zone = $this->input->post("staff_zone");

			$session_data = $this->session->user_session;
			$user_id = $session_data->id;
			$branch_id = $session_data->branch_id;
			$company_id = $session_data->company_id;
			$table_name = $session_data->patient_table;


			if (is_null($this->input->post("gender")) && $this->input->post("gender") == "") {
				$gender = '';
			}
			if (is_null($this->input->post("birth_day")) && $this->input->post("birth_day") == "") {
				$birth_day = '';
			}
			if (is_null($this->input->post("blood_group")) && $this->input->post("blood_group") == "") {
				$blood_group = '';
			}
			if (is_null($this->input->post("vtc")) && $this->input->post("vtc") == "") {
				$vtc = '';
			}
			if (is_null($this->input->post("alter_contact")) && $this->input->post("alter_contact") == "") {
				$alter_contact = '';
			}
			if (is_null($this->input->post("location")) && $this->input->post("location") == "") {
				$location = '';
			}
			if (is_null($this->input->post("dist")) && $this->input->post("dist") == "") {
				$dist = '';
			}
			if (is_null($this->input->post("sub_dist")) && $this->input->post("sub_dist") == "") {
				$sub_dist = '';
			}
			if (is_null($this->input->post("postal_code")) && $this->input->post("postal_code") == "") {
				$postal_code = '';
			}
			if (is_null($this->input->post("staff_profile")) && $this->input->post("staff_profile") == "") {
				$staff_profile = '';
			}
			if (is_null($this->input->post("staff_type")) && $this->input->post("staff_type") == "") {
				$staff_type = '';
			}
			if (is_null($this->input->post("staff_zone")) && $this->input->post("staff_zone") == "") {
				$staff_zone = '';
			}
			if (is_null($patient_image) && $patient_image == "") {
				$patient_image = "";
			} else {
				$profileImagePath = $this->upload_file_aadhar($patient_image);
				if ($profileImagePath != null) {
					$patient_image = $profileImagePath;
				}
			}


			if (!empty($patientId)) {
				$update_data = array(
					'adhar_no' => $adhhar_no,
					'patient_name' => $patient_name,
					'patient_adhhar_image' => $patient_aadhar_image,
					'patient_image' => $patient_image,
					"gender" => $gender,
					'birth_date' => $birth_day,
					'blood_group' => $blood_group,
					'contact' => $contact,
					'other_contact' => $alter_contact,
					'address' => $location,
					'district' => $dist,
					'sub_district' => $sub_dist,
					'pin_code' => $postal_code,
//					'company_id' => $company_id,
					'is_icu_patient' => 2,
					'type'=>2

				);

				$staff_table="staff_master"; //universal table must add branch_id and company_id
				$staff_insert = array('profile_type' => $staff_profile,
					'type' => $staff_type,
					'zone' => $staff_zone,
					'branch_id' =>$branch_id,
					'company_id' =>$company_id,
					'modify_on' => date('Y-m-d H:i:s'),
					'modify_by' =>$user_id);

				if ($patient_image != "") {
					$update_data["patient_image"] = $patient_image;
				}
				$where = array('id' => $patientId);
				$staff_where = array('patient_id' => $patientId);
				$update = $this->StaffModel->updateForm($table_name, $update_data, $where,$staff_table,$staff_insert,$staff_where);

				if ($adhardetails == 2) {

					$adhar_no = "A000000" . $patientId;
					$this->db->where(array("id" => $patientId));
					$this->db->update($table_name, array("adhar_no" => $adhar_no));
				}
				if ($update == TRUE) {
					$response["status"] = 200;
					$response["data"] = "updated successfully";
				} else {
					$response["status"] = 201;
					$response["data"] = "Not Updated";
				}
			} else {


				$insert_data = array(
					'adhar_no' => $adhhar_no,
					'patient_name' => $patient_name,
					'patient_adhhar_image' => $patient_aadhar_image,
					'patient_image' => $patient_image,
					"gender" => $gender,
					'birth_date' => $birth_day,
					'blood_group' => $blood_group,
					'contact' => $contact,
					'other_contact' => $alter_contact,
					'address' => $location,
					'district' => $dist,
					'sub_district' => $sub_dist,
					'pin_code' => $postal_code,
//					'company_id' => $company_id,
					'is_icu_patient' => 2,
					'create_on' => date('Y-m-d H:i:s'),
					'create_by' => $user_id,
					'type'=>2
				);
				$staff_table="staff_master"; //universal table must add branch_id and company_id
				$staff_insert = array('profile_type' => $staff_profile,
					'type' => $staff_type,
					'zone' => $staff_zone,
					'branch_id' =>$branch_id,
					'company_id' =>$company_id,
					'create_on' => date('Y-m-d H:i:s'),
					'create_by' =>$user_id,
					'status' => 1 );
				$condition = 'where dm.adhar_no="' . $adhhar_no . '" and dm.discharge_date is null';

				$user_data = $this->StaffModel->getTableData($table_name, $condition);
				if($user_data->totalCount ==0) {

					$result = $this->StaffModel->addForm($table_name, $insert_data,$staff_table,$staff_insert);
					if ($result->status == TRUE) {
						$insert_id = $result->inserted_id;
						if ($adhardetails == 2) {
							$adhar_no = "A000000" . $insert_id;
							$this->db->where(array("id" => $insert_id));
							$this->db->update($table_name, array("adhar_no" => $adhar_no));
						}
						$response["status"] = 200;
						$response["data"] = "uploaded successfully";
					} else {
						$response["status"] = 201;
						$response["data"] = "Not Uploaded";
					}
				}else{
					$response["status"] = 201;
					$response["data"] = "Patient already admitted with same aadhar number";
				}

			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}


		echo json_encode($response);


	}

	public function getPatientDataById()
	{

		if (!is_null($this->input->post('patientId'))) {
			$patientId = $this->input->post('patientId');
			$session_data = $this->session->user_session;

			$company_id = $session_data->company_id;
			$branch_id = $session_data->branch_id;

			$tableName = $this->session->user_session->patient_table;// 'com_' . $company_id . '_patient';
			$tableUniversal="staff_master"; //get data by patient id ani branch_id and company_id
			//$where=array("id"=>$patientId);
			$where = "where dm.id='" . $patientId . "'";
			$resultObject = $this->StaffModel->_rawQuery("select *,(select group_concat(sm.profile_type,'|||',sm.type,'|||',sm.zone) from ".$tableUniversal." sm where sm.patient_id=dm.id and sm.branch_id='".$branch_id."' and sm.company_id='".$company_id."') as staff_profile from ".$tableName." dm ".$where);
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

	public function deletePatient()
	{
		if (!is_null($this->input->post('patientId'))) {
			$patientId = $this->input->post('patientId');
			$session_data = $this->session->user_session;

			$user_id = $session_data->id;
			$company_id = $session_data->company_id;
			$tableName = $this->session->user_session->patient_table;//'com_' . $company_id . '_patient';
			$departmentData = array('status' => 0, 'modify_on' => date('Y-m-d'), "modify_by" => $user_id);
			$where = array('id' => $patientId);

			$result = $this->Patient_Model->deletePatient($tableName, $departmentData, $where);
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

	public function search()
	{
		// print_r($id);
		if (!is_null($this->input->post('adhar_no')) && $this->input->post('adhar_no') !="" ) {
			$session_data = $this->session->user_session;

			$user_id = $session_data->id;
			$company_id = $session_data->company_id;
			$tableName = $this->session->user_session->patient_table;//'com_' . $company_id . '_patient';
			$id = $this->input->post('adhar_no');

			//$condition = array("adhhar_no"=>$id);
			$condition = 'where dm.adhar_no="' . $id . '" and dm.discharge_date is null';
			//$table_name= "patient_master";
			$this->load->model('Patient_Model');

			$user_data = $this->Patient_Model->getTableData($tableName, $condition);

			if ($user_data->totalCount > 0) {
				$response["status"] = 201;
				$response["messageBody"] = "Patient Already Admitted";
				$response["body"] = $user_data->data;
			} else {
				$response["status"] = 200;
				$response["body"] = $user_data->data;
				$response["messageBody"] = "";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Not Data Found";
		}
		//$response['xml_arr']=$user_data;
		echo json_encode($response);

	}

//	public function upload_file()
//	{
//		$filename = 'pic_'.date('YmdHis') . '.jpeg';
//		if( move_uploaded_file($_FILES['webcam']['tmp_name'],'uploads/patient_profiles/'.$filename) ){
//
//			echo $filename;
//		}
//	}

	public function upload_file_aadhar($data)
	{
		$filename = 'pic_' . date('YmdHis') . '.jpeg';
		if (move_uploaded_file($data, 'uploads/patient_aadhar/' . $filename)) {

			return $filename;
		}
		return null;
	}

	
	
	
}
