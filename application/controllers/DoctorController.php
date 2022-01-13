<?php

require_once 'HexaController.php';

/**
 * @property  Doctor Doctor
 */
class DoctorController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Doctor');
	}

	function index()
	{
		$this->load->view("doctor/index", array("title" => 'Doctor Details'));
	}

	function doctor_form($doctorID=0){

		$this->load->view("doctor/doctor_form_view", array("title" => 'Doctor Details',"doctorID"=>$doctorID));
	}


	function get_doctor_categories()
	{
		$resultObject = $this->Doctor->getCategories();
		$response =$this->getOptionsResponse($resultObject);
		echo json_encode($response);
	}

	function get_doctor_education(){
		$resultObject = $this->Doctor->getEducations();
		$response =$this->getOptionsResponse($resultObject);
		echo json_encode($response);
	}

	function getOptionsResponse($resultObject){
		if ($resultObject->totalCount > 0) {
			$options = array();
			foreach ($resultObject->data as $option) {
				$object = new stdClass();
				$object->id = $option->id;
				$object->text = $option->name;
				array_push($options, $object);
			}
			$response['status'] = 200;
			$response['body'] = parent::base64_response($options);
		} else {
			$response['status'] = 201;
			$response['body'] = 'No Options';
		}
		return $response;
	}

	function save_category_changes()
	{

		if (!is_null($this->input->post_get("name"))) {
			$name = $this->input->post_get("id");
			$data = array("name" => $name);
			if (is_null($this->input->post_get("id"))) {
				$resultObject = $this->Doctor->saveCategory($data);
			} else {
				$resultObject = $this->Doctor->saveCategory($data, $this->input->post_get("id"));
			}
			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Save Changes";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Save";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Bad Request";
		}
		echo json_encode($response);
	}

	function get_all_doctors()
	{
		$where = array('status' => 1);
		$start_limit = $_POST['start'];
		$end_limit = $_POST['length'];
		$resultObject = $this->Doctor->getDoctors($where, $start_limit, $end_limit);
		$doctorsArray = array();
		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $item) {
				$gender = (int)$item->gender == 1 ? 'Male' : 'Female';
				$doctorsArray[] = array(base_url($item->profile_image),ucfirst($item->name), $gender, $item->email, $item->contact, $item->address, $item->doc_id);
			}
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $resultObject->totalCount,
			"recordsFiltered" => $resultObject->totalCount,
			"data" => $doctorsArray

		);

		echo json_encode($output);

	}


	function save_doctor_details()
	{

		$requiredParameter = parent::is_parameter(array("name","email", "contact", "gender", "education", 'category', 'address', 'alter_contact'));
		if ($requiredParameter->status) {
			$param = $requiredParameter->param;
			$user_id = 'USE_36';
			$userData = array(
				'name'=>$param->name,
				'email'=>$param->email,
				'contact'=>$param->contact,
				'gender'=>$param->gender,
				'role'=>2
			);
			$doctorData = array(
				'education'=>$param->education,
				'category'=>$param->category,
				'address'=>$param->address,
				'alt_contact_1'=>$param->alter_contact,
				'modify_by'=>$user_id,
				'modify_on'=> date('y-m-d h:i:s')
			);
			$imageResource=parent::upload_file('resource/profileImages','profileImage');
			if($imageResource->status){
				$imageData = array(
					'path'=>$imageResource->body[0],
					'modify_by'=>$user_id,
					'modify_on'=> date('y-m-d h:i:s')
				);

				$resultObject = $this->Doctor->saveDoctor($userData, $doctorData, $imageData);

				if ($resultObject->status) {
					$response["status"] = 200;
					$response["body"] = "Save Changes";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed To Save";
				}
			}else{
				$response["status"] = 201;
				$response["body"] = $imageResource->body;
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Bad Request";
		}
		echo json_encode($response);
	}


}
