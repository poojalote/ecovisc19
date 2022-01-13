<?php

require_once 'HexaController.php';

/**
 * @property  User User
 */
class BillingManagementController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('BillingModel');
	}

	/*
	 * login api
	 */

	public function index()
	{
		$this->load->view('Billing/view_billing', array("title" => "Billing"));
	}

	public function billingMaster()
	{
		$this->load->view('Billing/billingMaster', array("title" => "Billing Master"));
	}

	public function getBillingServices()
	{
		$tableName = 'service_master';
		$resultObject = $this->BillingModel->getSelectServicesData($tableName);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Services</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->service_no . '">' . $value->service_name . '</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}

	public function getBillingServicesDescription()
	{
		if (!is_null($this->input->post('service_no'))) {
			$service_no = $this->input->post('service_no');
			$tableName = 'service_master';
			$resultObject = $this->BillingModel->getSelectServicesDescriptionData($tableName, $service_no);
			// print_r($resultObject);exit();
			$option = "No Data Found";
			if ($resultObject->totalCount > 0) {
				$option = '<option selected disabled>Select Services</option>';

				foreach ($resultObject->data as $key => $value) {
					$option .= '<option value="' . $value->id . '">' . $value->service_description . '</option>';
				}
				$results['status'] = 200;
				$results['option'] = $option;
			} else {
				$results['status'] = 201;
				$results['option'] = $option;
			}
		} else {
			$results['status'] = 201;
			$results['option'] = "";
			$results['body'] = "parameter missing";
		}
		echo json_encode($results);
	}

	public function getBillingServicesDRate()
	{
		if (!is_null($this->input->post('id'))) {
			$service_id = $this->input->post('id');
			$tableName = 'service_master';
			$resultObject = $this->BillingModel->getSelectServicesRateData($tableName, $service_id);
			// print_r($resultObject);exit();
			// $option="No Data Found";
			if ($resultObject->totalCount > 0) {
				$resultObject->data;
				$results['status'] = 200;
				$results['option'] = $resultObject->data;;
			} else {
				$results['status'] = 201;
				$results['option'] = "";
			}
		} else {
			$results['status'] = 201;
			$results['option'] = "";
			$results['body'] = "parameter missing";
		}
		echo json_encode($results);
	}

	public function get_status_true($tableServiceOrder, $patientId, $branch_id, $service_id, $company_id)
	{
		$alreadyServiceExist = $this->db->query('select * from ' . $tableServiceOrder . ' where patient_id=' . $patientId . ' AND branch_id=' . $branch_id . ' AND company_id=' . $company_id . ' AND service_id in (select service_id from service_master where id=' . $service_id . ') AND sample_pickup=0 AND (service_category="RADIOLOGY" OR service_category="PATHOLOGY" )')->num_rows();
		if ($alreadyServiceExist >= 1) {
			return false;
		} else {
			return true;
		}
	}

	public function add_billing_transaction()
	{
		if (!is_null($this->input->post("bservice_name")) && !is_null($this->input->post("bservice_desc")) && !is_null($this->input->post("billing_rate")) && !is_null($this->input->post("billing_date")) && !is_null($this->input->post("billing_patient_id"))) {

			$bservice_name = $this->input->post("bservice_name");
			$bservice_desc = $this->input->post("bservice_desc");
			$billing_rate = $this->input->post("billing_rate");
			$billing_date = $this->input->post("billing_date");

			$billing_unit = $this->input->post("billing_unit");
			$patientId = $this->input->post("billing_patient_id");
			$patientName = $this->input->post("billing_patient_name");
			$patientAdhar = $this->input->post("billing_patient_adhar");
			$billing_detail = $this->input->post("billing_detail");
			$billing_file = $this->input->post("billing_file");
			$service_id = $this->input->post("billing_service_id");
			if (is_null($this->input->post("billing_unit")) && $this->input->post("billing_unit") == "") {
				$billing_unit = 1;
			}
			if (is_null($this->input->post("billing_detail")) && $this->input->post("billing_detail") == "") {
				$billing_detail = '';
			}
			if (is_null($this->input->post("billing_file")) && $this->input->post("billing_file") == "") {
				$billing_file = '';
			}
			$this->load->model('formmodel');
			$upload_path = "uploads";

			$combination = 2;
			$result = $this->upload_file($upload_path, "billing_file", $combination);
			$response["f"] = $result;
			if ($result->status) {
				if ($result->body[0] == "uploads/") {
					$input_data = "";
				} else {
					$input_data = $result->body;
				}

			} else {
				$input_data = "";
			}

			$normal_status = '';
			if ($input_data != "") {
				$normal_status = 'yes';
			}

			$total = $billing_unit * $billing_rate;

			$billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
			$user_id = $this->session->user_session->id;//hospital_room_table
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableServiceOrder = "service_order";

			$randomNo = mt_rand(100000, 999999);
			$order_number = "o_" . $patientId . '_' . $randomNo;
			try {
				$this->db->trans_start();
				$serviceOrderExistData = $this->db->query("select * from " . $tableServiceOrder . " where patient_id='" . $patientId . "' AND service_id in (select service_id from service_master where id='" . $service_id . "') AND order_date='" . $billing_date . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "' AND sample_pickup=0 AND (service_category='RADIOLOGY' OR service_category='PATHOLOGY')")->num_rows();

				$statusResult = $this->get_status_true($tableServiceOrder, $patientId, $branch_id, $service_id, $company_id);
				if ($statusResult == false) {
					$response["status"] = 201;
					$response["data"] = "Already Ordered Sample collection Pending";
					echo json_encode($response);
					exit();
				}

				if ($serviceOrderExistData <= 0) {

					$resultServiceCategory = $this->db->query("select * from service_master where id='" . $service_id . "'")->row();
					// print_r($resultServiceCategory);exit();
					$s_category_coll = $resultServiceCategory->service_category;
					$service_no = $resultServiceCategory->service_no;
					$service_m_id = $resultServiceCategory->service_id;
					$service_description = $resultServiceCategory->service_description;

					$sample_collection = 1;
					$status = 1;
					$confirm_service_given = 0;
					$service_user_id = $user_id;
					$service_given_date = date('Y-m-d H:i:s');
					if ($s_category_coll == "RADIOLOGY") {
						$sample_collection = 0;
						$status = 0;
						$service_user_id = "";
						$service_given_date = "";
					}
					if ($s_category_coll == "PATHOLOGY") {
						$confirm_service_given = 1;
						$sample_collection = 0;
					}
					$dataArray = array('order_number' => $order_number,
						'service_id' => $service_m_id,
						'service_no' => $service_no,
						'service_detail' => $service_description,
						'service_category' => $s_category_coll,
						'order_receive' => 1,
						'order_date' => $billing_date,
						// 'order_time' => $time,
						'quantity' => $billing_unit,
						'patient_id' => $patientId,
						'patient_name' => $patientName,
						'adhar_number' => $patientAdhar,
						'price' => $billing_rate,
						'company_id' => $company_id,
						'branch_id' => $branch_id,
						'sample_collection' => $sample_collection,
						'create_by' => $user_id,
						'create_on' => date('Y-m-d H:i:s'),
						'service_provider' => $service_user_id,
						'service_given_date' => $service_given_date,
						'confirm_service_given' => $confirm_service_given,
						'file_upload' => $input_data,
						'normal_status' => $normal_status,
						'Remark' => $billing_detail
					);
					$update_service = $this->db->insert($tableServiceOrder, $dataArray);
					$insert_id = $this->db->insert_id();
					if ($update_service == true) {

						$billing_unit = $billing_unit;
						$billing_rate = $billing_rate;
						$total = $billing_unit * $billing_rate;
						$status = 1;
						if ($s_category_coll == 'ACCOMM') {
							$type = 1;
						} else if ($s_category_coll == 'PHARMCY') {
							$type = 2;
						} else {
							$type = 3;
						}
						$billing_array = array('order_id' => $order_number,
							'service_id' => $service_m_id,
							'service_desc' => $service_description,
							'unit' => $billing_unit,
							'date_service' => $billing_date,
							'service_file' => $input_data,
							'total' => $total,
							'final_amount' => $total,
							'create_on' => date('Y-m-d H:i:s'),
							'create_by' => $user_id,
							'rate' => $billing_rate,
							'status' => $status,
							'patient_id' => $patientId,
							'type' => $type,
							'branch_id' => $branch_id,
							'reference_id' => $insert_id,
							'entry_type' => 1

						);

						if ($s_category_coll != "RADIOLOGY") {
							$update = $this->BillingModel->addForm($billing_transaction, $billing_array);
						}
					}
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response['status'] = 201;
						$response['data'] = "Changes Not Save";
					} else {
						$this->db->trans_commit();
						$response['status'] = 200;
						$response['data'] = "Changes Saved";
					}


				} else {
					$response["status"] = 201;
					$response["data"] = "Already Ordered Sample collection Pending";
					echo json_encode($response);
					exit();
				}


				$this->db->trans_complete();
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$response['data'] = "Changes Not Save";
			}

		} else {
			$response["status"] = 201;
			$response["data"] = "Something went wrong";
		}


		echo json_encode($response);
	}

	public function getBillingTable()
	{
		$patient_id = $this->input->post('p_id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction . " bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		// $billing_transaction="service_order bm";
//		$resultObject = $this->BillingModel->billing_history($billing_transaction, $patient_id);


		/* $where = array("bm.patient_id"=>$patient_id,"bm.type"=>3,"bm.confirm"=>0,"bm.entry_type"=>0,
		"bm.is_deleted"=>1,"bm.branch_id"=>$branch_id); */

		$where = "(bm.type=3" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " AND bm.patient_id=" . $patient_id . ")" .
			" OR (bm.type=2" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " AND bm.patient_id=" . $patient_id . ")" .
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " AND bm.patient_id=" . $patient_id . ")";
		$order = array('bm.id' => 'desc');


		$select = array('bm.*', "concat('AA',lpad(bm.reference_id,6,'0')) as order_number", "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from " . $hospital_bed_table . " bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=bm.patient_id) as patient_info",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		$memData = $this->BillingModel->getRows($_POST, $where, $select, $billing_transaction, $column_search, $column_order, $order);

		$filterCount = $this->BillingModel->countFiltered($_POST, $billing_transaction, $where, $column_search, $column_order, $order);
		$totalCount = $this->BillingModel->countAll($billing_transaction, $where);
		$tableRows = array();

		if (count($memData) > 0) {

			foreach ($memData as $row) {
				$patient_info = explode('|||', $row->patient_info);
				if (count($patient_info) > 2) {
					$patient_name = $patient_info[0];
					$bed_name = $patient_info[1];
					$room_id = $patient_info[2];
					if ($row->date_service != null && $row->date_service != "0000-00-00 00:00:00") {
						// $date = $this->getDate($row->service_given_date);
						$date = date("Y-m-d h:i:sa", strtotime($row->date_service));
						// $date = new /DateTime($row->service_given_date);
					} else {
						$date = "-";
					}
					if ($row->user != null && $row->user != "") {
						$user = $row->user;
					} else {
						$user = "-";
					}

					$tableRows[] = array(
						$bed_name,
						$row->patient_id,
						$patient_name,
						$row->service_id,
						$row->order_number,
						$row->service_desc,
						$row->id,
						$row->id,
						$user,
						$date,
						$row->id,

					);
				} else {
					$patient_name = "";
					$bed_name = "";
				}
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows
			);
		}


//		$results['last_query'] = $resultObject->last_query;
		echo json_encode($results);
	}

	public function getOtherServicePatientData()
	{
		$branch_id = $this->session->user_session->branch_id;
		$patientTable = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;

		$patientListObject = $this->db->query("select pt.id,pt.patient_name from " . $patientTable . " pt where pt.id in 
(select bm.patient_id from " . $billing_transaction . " bm where ((bm.type=3 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")
			OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))) group by pt.id");
		$data = '<option selected disabled>Select patient</option>';

		if ($this->db->affected_rows() > 0) {
			$patientListObjectdata = $patientListObject->result();
			$data .= '<option value="">All</option>';
			foreach ($patientListObjectdata as $patient) {
				if (!is_null($patient->patient_name)) {
					// array_push($data, array("id" => (int) $patient->patient_id, "text" => $patient->patient_name));
					$data .= '<option value="' . (int)$patient->id . '">' . $patient->patient_name . '</option>';

				}

			}
			$response["status"] = 200;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		}
		// $data=array_values(array_unique($data, SORT_REGULAR));

		echo json_encode($response);
	}

	public function getOtherServiceHistoryPatientData()
	{
		$branch_id = $this->session->user_session->branch_id;
		$patientTable = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;

		$patientListObject = $this->db->query("select pt.id,pt.patient_name from " . $patientTable . " pt where pt.id in 
(select bm.patient_id from " . $billing_transaction . " bm where ((bm.type=3 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")
			OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))) group by pt.id");
		$data = '<option selected disabled>Select patient</option>';

		if ($this->db->affected_rows() > 0) {
			$patientListObjectdata = $patientListObject->result();
			$data .= '<option value="">All</option>';
			foreach ($patientListObjectdata as $patient) {
				if (!is_null($patient->patient_name)) {
					// array_push($data, array("id" => (int) $patient->patient_id, "text" => $patient->patient_name));
					$data .= '<option value="' . (int)$patient->id . '">' . $patient->patient_name . '</option>';

				}

			}
			$response["status"] = 200;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		}
		// $data=array_values(array_unique($data, SORT_REGULAR));

		echo json_encode($response);
	}

	public function getOtherServiceCategoryData()
	{
		$branch_id = $this->session->user_session->branch_id;
		$patientTable = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;

		$patientListObject = $this->db->query("select so.service_category from service_master so where so.service_id in
(select bm.service_id from " . $billing_transaction . " bm where ((bm.type=3 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")
			OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))) group by so.service_category");
		$data = '<option selected disabled>Select Category</option>';

		if ($this->db->affected_rows() > 0) {
			$patientListObjectdata = $patientListObject->result();
			$data .= '<option value="">All</option>';
			foreach ($patientListObjectdata as $patient) {
				if (!is_null($patient->service_category)) {
					// array_push($data, array("id" => (int) $patient->patient_id, "text" => $patient->patient_name));
					$data .= '<option value="' . $patient->service_category . '">' . $patient->service_category . '</option>';

				}

			}
			$response["status"] = 200;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		}
		// $data=array_values(array_unique($data, SORT_REGULAR));

		echo json_encode($response);
	}

	public function getOtherServiceHistoryCategoryData()
	{
		$branch_id = $this->session->user_session->branch_id;
		$patientTable = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;

		$patientListObject = $this->db->query("select so.service_category from service_master so where so.service_id in
(select bm.service_id from " . $billing_transaction . " bm where ((bm.type=3 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")
			OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))) group by so.service_category");
		$data = '<option selected disabled>Select Category</option>';

		if ($this->db->affected_rows() > 0) {
			$patientListObjectdata = $patientListObject->result();
			$data .= '<option value="">All</option>';
			foreach ($patientListObjectdata as $patient) {
				if (!is_null($patient->service_category)) {
					// array_push($data, array("id" => (int) $patient->patient_id, "text" => $patient->patient_name));
					$data .= '<option value="' . $patient->service_category . '">' . $patient->service_category . '</option>';

				}

			}
			$response["status"] = 200;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["query"] = $this->db->last_query();
			$response["data"] = $data;
		}
		// $data=array_values(array_unique($data, SORT_REGULAR));

		echo json_encode($response);
	}

	public function getBillingTable1()
	{
		$patient_id = $this->input->post('patient_id');
		$category = $this->input->post('category');

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction . " bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;

		$zone = $this->input->post('zone_id');
		// $billing_transaction="service_order bm";
//		$resultObject = $this->BillingModel->billing_history($billing_transaction, $patient_id);


		/* $where = array("bm.patient_id"=>$patient_id,"bm.type"=>3,"bm.confirm"=>0,"bm.entry_type"=>0,
		"bm.is_deleted"=>1,"bm.branch_id"=>$branch_id); */


		if ($patient_id != null && $patient_id != "" && $patient_id != "null") {
			if ($category != null && $category != "" && $category != "null") {
				$where = "((bm.type=3" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . ")" .
					"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . "))
			and bm.service_id in (select service_id from service_master where service_category='" . $category . "')";
			} else {
				$where = "((bm.type=3" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . ")" .
					"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . "))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
			}

		} else if ($category != null && $category != "" && $category != "null") {
			$where = "((bm.type=3" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")" .
				"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . "))
			and bm.service_id in (select service_id from service_master where service_category='" . $category . "')";
		} else {
			$where = "((bm.type=3" . " AND bm.confirm=0" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")" .
				"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			 and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
		}
		$order = array('bm.id' => 'desc');


		$select = array('bm.*', "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from " . $hospital_bed_table . " bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=bm.patient_id) as patient_info",
			"(select pt.roomid from " . $patient_table . " pt where  pt.id=bm.patient_id) as room_id",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		$this->db->select($select)->where($where)->order_by('bm.id', 'desc');
		// if (!is_null($zone)) {
		// 	if ((int)$zone != -1) {
		// 		$this->db->having('room_id', $zone);
		// 	}
		// }
		$memData = $this->db->get($billing_transaction)->result();

//		$memData = $this->BillingModel->getRows($_POST, $where, $select, $billing_transaction, $column_search, $column_order, $order);

//		$filterCount = $this->BillingModel->countFiltered($_POST, $billing_transaction, $where, $column_search, $column_order, $order);
//		$totalCount = $this->BillingModel->countAll($billing_transaction, $where);
		$tableRows = array();

		if (count($memData) > 0) {

			foreach ($memData as $row) {
				$patient_info = explode('|||', $row->patient_info);
				if (count($patient_info) > 2) {
					$patient_name = $patient_info[0];
					$bed_name = $patient_info[1];
					$room_id = $patient_info[2];
					if ($row->date_service != null && $row->date_service != "0000-00-00 00:00:00") {
						// $date = $this->getDate($row->service_given_date);
						$date = date("Y-m-d h:i:sa", strtotime($row->date_service));
						// $date = new /DateTime($row->service_given_date);
					} else {
						$date = "-";
					}
					if ($row->user != null && $row->user != "") {
						$user = $row->user;
					} else {
						$user = "-";
					}
					$tableRows[] = array(
						$bed_name,
						$patient_name,
						$row->service_id,
						$row->order_id,
						$row->service_desc,
						$row->id,
						$row->reference_id,
						$user,
						$date,
						$row->id,
						$row->patient_id,
					);
				} else {
					$patient_name = "";
					$bed_name = "";
				}
			}
			$results = array(
				"draw" => (int)1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $tableRows
			);
		}


		$results['last_query'] = $this->db->last_query();
		echo json_encode($results);
	}

	public function getBillingHistoryTable1()
	{
		$patient_id = $this->input->post('patient_id');
		$category = $this->input->post('category');

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction . " bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$zone = $this->input->post('zone_id');
		$service_table = "service_order";
		// $billing_transaction="service_order bm";
//		$resultObject = $this->BillingModel->billing_history($billing_transaction, $patient_id);


		/* $where = array("bm.patient_id"=>$patient_id,"bm.type"=>3,"bm.confirm"=>0,"bm.entry_type"=>0,
		"bm.is_deleted"=>1,"bm.branch_id"=>$branch_id); */
		if ($patient_id != null && $patient_id != "" && $patient_id != "null") {
			if ($category != null && $category != "" && $category != "null") {
				$where = "((bm.type=3" . " AND bm.confirm=1" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . ")" .
					"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . "))
			and bm.service_id in (select service_id from service_master where service_category='" . $category . "')";
			} else {
				$where = "((bm.type=3" . " AND bm.confirm=1" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . ")" .
					"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " and bm.patient_id=" . $patient_id . "))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
			}

		} else if ($category != null && $category != "" && $category != "null") {
			$where = "((bm.type=3" . " AND bm.confirm=1" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")" .
				"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . "))
			and bm.service_id in (select service_id from service_master where service_category='" . $category . "')";
		} else {
			$where = "((bm.type=3" . " AND bm.confirm=1" . " AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . ")" .
				"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=" . $branch_id . " ))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
		}
		$order = array('bm.id' => 'desc');


		$select = array('bm.*', "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from " . $hospital_bed_table . " bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=bm.patient_id) as patient_info", "(select GROUP_CONCAT(st.file_upload,'||',st.normal_status,'||',(case when st.Remark is not null then st.Remark else ' ' end)) from " . $service_table . " st where st.id=bm.reference_id) as service_files",
			"(select pt.roomid from " . $patient_table . " pt where  pt.id=bm.patient_id) as room_id",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		$this->db->select($select)->where($where)->order_by('bm.id', 'desc');
		// if (!is_null($zone)) {
		// 	if ((int)$zone != -1) {
		// 		$this->db->having('room_id', $zone);
		// 	}
		// }
		$memData = $this->db->get($billing_transaction)->result();
		// print_r($memData);exit();
//		$memData = $this->BillingModel->getRows($_POST, $where, $select, $billing_transaction, $column_search, $column_order, $order);

//		$filterCount = $this->BillingModel->countFiltered($_POST, $billing_transaction, $where, $column_search, $column_order, $order);
//		$totalCount = $this->BillingModel->countAll($billing_transaction, $where);
		$tableRows = array();

		if (count($memData) > 0) {

			foreach ($memData as $row) {
				$patient_info = explode('|||', $row->patient_info);
				if (count($patient_info) > 2) {
					$patient_name = $patient_info[0];
					$bed_name = $patient_info[1];
					$room_id = $patient_info[2];
					if ($row->date_service != null && $row->date_service != "0000-00-00 00:00:00") {
						// $date = $this->getDate($row->service_given_date);
						$date = date("Y-m-d h:i:sa", strtotime($row->date_service));
						// $date = new /DateTime($row->service_given_date);
					} else {
						$date = "-";
					}
					if ($row->user != null && $row->user != "") {
						$user = $row->user;
					} else {
						$user = "-";
					}

					$files = "";
					$normal = "";
					$remark = "";
					if ($row->service_files != "") {
						$services = explode('||', $row->service_files);
						if (count($services) > 1) {

							$files = $services[0];
							$normal = $services[1];;
							$remark = $services[2];;
						}

					}


					$tableRows[] = array(
						$bed_name,
						$patient_name,
						$row->service_id,
						$row->order_id,
						$row->service_desc,
						$row->id,
						$row->reference_id,
						$user,
						$date,
						$row->id,
						$row->patient_id,
						$files,
						$normal,
						$remark
					);
				} else {
					$patient_name = "";
					$bed_name = "";
				}
			}
			$results = array(
				"draw" => (int)1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $tableRows
			);
		}


		$results['last_query'] = $this->db->last_query();
		echo json_encode($results);
	}

	public function getDeleteBillingTable()
	{
		$patient_id = $this->input->post('p_id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction . " bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		// $billing_transaction="service_order bm";
//		$resultObject = $this->BillingModel->billing_history($billing_transaction, $patient_id);


		$where = array("bm.patient_id" => $patient_id, "bm.is_deleted" => 0, "bm.branch_id" => $branch_id);
		$order = array('bm.id' => 'desc');


		$select = array('bm.*', "concat('AA',lpad(bm.reference_id,6,'0')) as order_number", "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from " . $hospital_bed_table . " bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=bm.patient_id) as patient_info",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		$memData = $this->BillingModel->getRows($_POST, $where, $select, $billing_transaction, $column_search, $column_order, $order);

		$filterCount = $this->BillingModel->countFiltered($_POST, $billing_transaction, $where, $column_search, $column_order, $order);
		$totalCount = $this->BillingModel->countAll($billing_transaction, $where);
		$tableRows = array();

		if (count($memData) > 0) {

			foreach ($memData as $row) {
				$patient_info = explode('|||', $row->patient_info);
				if (count($patient_info) > 2) {
					$patient_name = $patient_info[0];
					$bed_name = $patient_info[1];
					$room_id = $patient_info[2];
					if ($row->date_service != null && $row->date_service != "0000-00-00 00:00:00") {
						// $date = $this->getDate($row->service_given_date);
						$date = date("Y-m-d h:i:sa", strtotime($row->date_service));
						// $date = new /DateTime($row->service_given_date);
					} else {
						$date = "-";
					}
					if ($row->user != null && $row->user != "") {
						$user = $row->user;
					} else {
						$user = "-";
					}

					$tableRows[] = array(
						$bed_name,
						$row->patient_id,
						$patient_name,
						$row->service_id,
						$row->order_number,
						$row->service_desc,
						$row->id,
						$row->id,
						$user,
						$date,
						$row->id,

					);
				} else {
					$patient_name = "";
					$bed_name = "";
				}
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows
			);
		}


//		$results['last_query'] = $resultObject->last_query;
		echo json_encode($results);
	}

	public function deleteBillingTrascation()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
			// $table_name='departments_master';
			$departmentData = array('status' => 0);
			$where = array('id' => $id);
			$result = $this->BillingModel->updateForm($billing_transaction, $departmentData, $where);
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

	public function RoomOrderBilling()
	{
		$p_id = $this->input->post('p_id');
		$room_odr_data = $this->BillingModel->getRoomOrderData($p_id);
		$data = "";
		if ($room_odr_data != false) {
			foreach ($room_odr_data as $row) {
				$data .= "<tr>
			<td>" . $row->service_name . "</td>
			<td>" . $row->date . "</td>
			<td>" . $row->order_id . "</td>
			<td>" . $row->price . "</td>
			</tr>";
			}
			$response["status"] = 200;
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["data"] = "No data Added";
		}
		echo json_encode($response);
	}

	public function addOrderRoom()
	{
		$p_id = $this->input->post('p_id');
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$room_odr_data = $this->BillingModel->getRoomOrderData($p_id);
		$data = "";
		if ($room_odr_data != false) {
			$a = 1;
			foreach ($room_odr_data as $row) {
				$data = array(
					"service_id" => $row->service_id,
					"unit" => 1,
					"rate" => $row->price,
					"total" => $row->price,
					"patient_id" => $p_id,
					"status" => 1,
					"branch_id" => $branch_id
				);
				$insert = $this->db->insert($billing_transaction, $data);
				if ($insert == true) {
					$a++;
				}
			}
			if ($a > 1) {
				$response["status"] = 200;
				$response["body"] = "Added SuccessFully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Not Added";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something Went Wrong";
		}
		echo json_encode($response);
	}

	public function getBillingserviceOrderBillingInfo()
	{
		if (!is_null($this->input->post('service_order_id'))) {
			// print_r($this->input->post('service_order_id'));exit;
			$service_order_id = $this->input->post('service_order_id');
			// print_r($service_order_id);exit();
			$confirm_service_given = $this->input->post('confirm_service_given');
			// print_r($confirm_service_given);exit();
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			try {
				$this->db->trans_start();
				$tableName = $billing_transaction;
				if ($confirm_service_given == 1) {
					$data = array('confirm' => 1);
				} else {
					$data = array('confirm' => 0);
				}

				foreach ($service_order_id as $service_id) {
					$where = array('id' => $service_id, 'branch_id' => $branch_id);
					$this->db->where($where);
					$update = $this->db->update($tableName, $data);

					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response['status'] = 201;
						$response['body'] = "service not confirm";
					} else {
						$this->db->trans_commit();
						$response['status'] = 200;
						$response['body'] = "service confirm";
					}
				}


				$this->db->trans_complete();
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$response['body'] = "service not confirm";
			}


		} else {
			$response['status'] = 201;
			$response['body'] = "service not confirm";
		}
		echo json_encode($response);
	}

	public function deleteBillingServiceOrder()
	{
		if (!is_null($this->input->post('service_order_id'))) {
			$billing_id = $this->input->post('service_order_id');
			$patient_id = $this->input->post('patient_id');
			$service_id = $this->input->post('service_id');
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableName = 'service_order';
			try {
				$this->db->trans_start();
				$where = array('id' => $billing_id, 'branch_id' => $branch_id);
				$resultObject = $this->db->where($where)->get($billing_transaction);

				if ($this->db->affected_rows() > 0) {
					$resultsArray = $resultObject->row();

					$service_delete = array('id' => $resultsArray->reference_id,
						'patient_id' => $patient_id,
						'service_id' => $service_id, 'branch_id' => $branch_id);
					$set = array("is_deleted" => 0);
					$this->db->where($where);
					$delete = $this->db->update($billing_transaction, $set);
					if ($delete == true) {
						$this->db->where($service_delete);
						$update = $this->db->update($tableName, $set);
						if ($this->db->trans_status() === FALSE) {
							$this->db->trans_rollback();
							$response['status'] = 201;
							$response['body'] = "Something went wrong";
						} else {
							$this->db->trans_commit();
							$response['status'] = 200;
							$response['body'] = "Deleted SuccessFully";
						}
					}
				}


				$this->db->trans_complete();
			} catch (Exception $exc) {
				$response['status'] = 201;
				$response['body'] = "Something went wrong";
			}

		} else {
			$response['status'] = 201;
			$response['body'] = "Something went wrong";
		}


		echo json_encode($response);
	}

	public function getAccomodationTableBIllingData()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=1 AND confirm=1 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$subTotal = 0;
				foreach ($resultObject->data as $key => $value) {
					$date_service = date('d M Y g:i A', strtotime($value->date_service));
					$subTotal = $subTotal + $value->final_amount;
					$p_checked = "";
					$a_checked = "";
					$discount_type = (int)$value->discount_type;
					if ($discount_type == 1) {
						$p_checked = "checked";
					} else {
						$a_checked = "checked";
					}
					$data .= '<tr>
					<td>' . $date_service . '</td>
					<td>' . $value->service_desc . '</td>
					<td>' . $value->unit . '</td>
					<td>' . $value->rate . '</td>
					<td>' . $value->total . '</td>
					<td>
					<div class="row">
					<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
					<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
					<input type="radio" class="hide_class" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
					<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,1)"><i class="fa fa-save"></i></button>
					</div>
					</td>
					<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',1)"><i class="fa fa-trash" style="color:red"></i></button></td>
					<td>' . $value->final_amount . '</td>
					</tr>';
				}
				$data .= '<tr>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><input type="hidden" value="' . $subTotal . '" id="accomodationSubtotal"><b>' . $subTotal . '</b></td>
				</tr>';
				$response['status'] = 200;
				$response['data'] = $data;
			} else {
				$response['status'] = 201;
				$response['data'] = '<tr><td colspan="5">No Data Found<input type="hidden" value="0" id="accomodationSubtotal"></td></tr>';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getmedicineAndConsumablesTableBilling()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=2 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$sr_no = 1;
				$subTotal = 0;
				$subTotal1 = 0;
				$subTotal2 = 0;
				foreach ($resultObject->data as $key => $value) {
					if ($value->confirm == 1) {
						$subTotal1 = $subTotal1 + $value->final_amount;
						$date_service = date('d M Y g:i A', strtotime($value->date_service));
						$p_checked = "";
						$a_checked = "";
						$discount_type = (int)$value->discount_type;
						if ($discount_type == 1) {
							$p_checked = "checked";
						} else {
							$a_checked = "checked";
						}
						$data .= '<tr>
						<td>' . $sr_no . '</td>
						<td>' . $value->order_id . '</td>
						<td>' . $date_service . '</td>
						<td>' . $value->total . '</td>
						<td>
						<div class="row">
						<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
						<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
						<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
						<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,1)"><i class="fa fa-save"></i></button>
						</div>
						</td>
						<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',3)"><i class="fa fa-trash" style="color:red"></i></button></td>
						<td>' . $value->final_amount . '</td>
						</tr>';
					} else if ($value->confirm == 0 && $value->entry_type == 0) {

						$date_service = date('d M Y g:i A', strtotime($value->date_service));
						$data .= '<tr>
						<td>' . $sr_no . '</td>
						<td>' . $value->order_id . '</td>
						<td>' . $date_service . '</td>
						<td>' . $value->total . '(R)</td>
						<td></td>
						<td></td>
						<td></td>
						</tr>';
						$subTotal2 = $subTotal2 + $value->total;
					} else {

					}
					$sr_no++;

				}
				$subTotal = $subTotal1;
				$subTotal = $subTotal - $subTotal2;
				$data .= '<tr>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><input type="hidden" value="' . $subTotal . '" id="medicineSubtotal"><b>' . $subTotal . '</b></td>
				</tr>';
				$response['status'] = 200;
				$response['data'] = $data;
			} else {
				$response['status'] = 201;
				$response['data'] = '<tr><td colspan="4">No Data Found<input type="hidden" value="0" id="medicineSubtotal"></td></tr>';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getserviceOrderCollectionTableBilling()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=3 AND confirm=1 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$subTotal = 0;
				$subTotal1 = 0;
				$subTotal2 = 0;
				$subTotal3 = 0;
				$subTotal4 = 0;
				$subTotal5 = 0;
				$subTotal6 = 0;
				$tableName = "service_master";
				$data1 = '<tr class="ordercollection1"><td colspan="9"><strong>Lab Tests</strong></td></tr>';
				$data2 = '<tr class="ordercollection2"><td colspan="9"><strong>Radiology Tests</strong></td></tr>';
				$data3 = '<tr class="ordercollection3"><td colspan="9"><strong>Equipment Rentals</strong></td></tr>';
				$data4 = '<tr class="ordercollection4"><td colspan="9"><strong>Procedure</strong></td></tr>';
				$data5 = '<tr class="ordercollection5"><td colspan="9"><strong>Others</strong></td></tr>';
				$data_consult = "";
				foreach ($resultObject->data as $key => $value) {
					$serviceMasterData = $this->db->where('service_id', $value->service_id)->get('service_master');
					// print_r($serviceMasterData);exit();
					$date_service = date('d M Y g:i A', strtotime($value->date_service));
					$p_checked = "";
					$a_checked = "";
					$discount_type = (int)$value->discount_type;
					if ($discount_type == 1) {
						$p_checked = "checked";
					} else {
						$a_checked = "checked";
					}
					if ($this->db->affected_rows() > 0) {
						$serviceMasterData = $serviceMasterData->row();

						if ($serviceMasterData->service_category == 'PATHOLOGY') {
							$subTotal1 = $subTotal1 + $value->final_amount;
							$data1 .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>

							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';
						} else if ($serviceMasterData->service_category == 'RADIOLOGY') {
							$subTotal2 = $subTotal2 + $value->final_amount;

							$data2 .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';
						} else if ($serviceMasterData->service_category == 'EQUIPMENT') {
							$subTotal3 = $subTotal3 + $value->final_amount;

							$data3 .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';


						} else if ($serviceMasterData->service_category == 'PROCEDURE') {
							$subTotal4 = $subTotal4 + $value->final_amount;

							$data4 .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';

						} else if ($serviceMasterData->service_category == 'CONSULT') {
							$subTotal6 = $subTotal6 + $value->final_amount;
							$data_consult .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>
							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link hide_class" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';
						} else {
							$subTotal5 = $subTotal5 + $value->final_amount;

							$data5 .= '<tr>
							<td>' . $date_service . '</td>
							<td>' . $value->service_desc . '</td>
							<td>' . $value->order_id . '</td>
							<td>' . $value->unit . '</td>
							<td>' . $value->rate . '</td>
							<td>' . $value->total . '</td>
							<td>
							<div class="row">
							<input type="number" style="width:100px" value="' . $value->discount_percent . '" class="form-control" name="dis_' . $value->id . '" id="dis_' . $value->id . '">
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="1" ' . $p_checked . '  id="per_btn' . $value->id . '"> <div class="hide_class">&nbsp; % &nbsp;</div>
							<input type="radio" class="hide_class" name="discount' . $value->id . '" value="2" ' . $a_checked . ' id="amt_btn' . $value->id . '"><div class="hide_class">&nbsp;₹</div>

							<button class="btn btn-link hide_class savebtn" onclick="save_discount(' . $value->id . ',' . $value->total . ',`discount' . $value->id . '`,2)"><i class="fa fa-save"></i></button>
							</div>
							</td>
							<td><button class="btn btn-link" onclick="delete_service_bill(' . $value->id . ',2)"><i class="fa fa-trash" style="color:red"></i></button></td>
							<td>' . $value->final_amount . '</td>
							</tr>';

						}

					}

				}


				$data1 .= '<tr class="ordercollection1">
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal1 . '</b></td>
				</tr>';

				$data2 .= '<tr class="ordercollection2">
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal2 . '</b></td>
				</tr>';

				$data3 .= '<tr class="ordercollection3">
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal3 . '</b></td>
				</tr>';

				$data4 .= '<tr class="ordercollection4">
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal4 . '</b></td>
				</tr>';

				$data5 .= '<tr class="ordercollection1">
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal5 . '</b></td>
				</tr>';

				$data_consult .= '<tr>
				<td></td>
				<td></td>
				<td></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub1"></td>
				<td class="sub"><b>Sub Total</b></td>
				<td><b>' . $subTotal6 . '</b>
				<input type="hidden" value="' . $subTotal6 . '" id="doctorconsultsubtotal">
				</td>
				</tr>';


				$subTotal = $subTotal1 + $subTotal2 + $subTotal3 + $subTotal4 + $subTotal5;
				$data .= $data1 . '' . $data2 . '' . $data3 . '' . $data4 . '' . $data5;
				$data .= '<tr>
				<td><input type="hidden" value="' . $subTotal . '" id="serviceOCSubtotal"></td>
				<td><input type="hidden" value="' . $subTotal1 . '" id="serviceOCSubtotal1"></td>
				<td><input type="hidden" value="' . $subTotal2 . '" id="serviceOCSubtotal2"></td>
				<td><input type="hidden" value="' . $subTotal3 . '" id="serviceOCSubtotal3"></td>
				<td><input type="hidden" value="' . $subTotal4 . '" id="serviceOCSubtotal4"></td>
				<td><input type="hidden" value="' . $subTotal5 . '" id="serviceOCSubtotal5"></td>
				</tr>';

				$response['status'] = 200;
				$response['data'] = $data;
				$response['data_consult'] = $data_consult;
			} else {
				$response['status'] = 201;
				$response['data'] = '<tr><td colspan="6">No Data Found<input type="hidden" value="0" id="serviceOCSubtotal"></td></tr>';
				$response['data_consult'] = '<tr><td colspan="6">No Data Found<input type="hidden" value="0" id="doctorconsultsubtotal"></td></tr>';
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getPatientBIllingData()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$patient_table = $this->session->user_session->patient_table;
			$where = "where id='" . $patient_id . "'";
			$resultObject = $this->BillingModel->selectDataById($patient_table, $where);
			// print_r($resultObject);exit();
			if ($resultObject->totalCount > 0) {
				$patient_name = '';
				$patient_age = '';
				$patient_id = '';
				$admission_date = '';
				$admission_time = '';
				$discharge_date = '';
				$discharge_time = '';
				$discount_amt = '';
				$discount_type = '';
				$result = $resultObject->data;
				foreach ($result as $key => $value) {
					$patient_name = $value->patient_name;
					$patient_age = $this->ageCalculator($value->birth_date);
					$patient_id = $value->id;
					$admission_date = date('d M Y', strtotime($value->admission_date));
					$admission_time = date('H:i a', strtotime($value->admission_date));
					if ($value->discharge_date != null && $value->discharge_date != '' && $value->discharge_date != '0000-00-00 00:00:00') {
						$discharge_date = date('d M Y', strtotime($value->discharge_date));
						$discharge_time = date('H:i a', strtotime($value->discharge_date));
					}
					$discount_amt = $value->billing_discount;
					$discount_type = $value->billing_dis_type;
				}
				$response['status'] = 200;
				$response['patient_name'] = $patient_name;
				$response['patient_age'] = $patient_age;
				$response['patient_id'] = $patient_id;
				$response['admission_date'] = $admission_date;
				$response['admission_time'] = $admission_time;
				$response['discharge_date'] = $discharge_date;
				$response['discharge_time'] = $discharge_time;
				$response['discount_amt'] = $discount_amt;
				$response['discount_type'] = $discount_type;
				$response['data'] = $result;
			} else {
				$response['status'] = 201;
				$response['data'] = "Something went wrong";
			}
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function ageCalculator($dob)
	{
		//echo $dob;

		if (!empty($dob) && $dob !== "0000-00-00") {
			$birthdate = new DateTime($dob);
			$today = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		} else {
			return 0;
		}
	}

	public function check_billing_status()
	{

		$p_id = $this->input->post('p_id');
		if(!is_null($p_id) && !empty($p_id)) {
            $patient_table = $this->session->user_session->patient_table;
            $query = $this->db->query("select billing_open from " . $patient_table . " where id=" . $p_id);
            if ($this->db->affected_rows() > 0) {
                $billing_open = $query->row()->billing_open;
                $response['status'] = 200;
                $response['value'] = $billing_open;
            } else {
                $response['status'] = 201;

            }
        }else{
            $response['status'] = 201;
        }
		echo json_encode($response);
	}

	public function ChangeBillingOpen()
	{
		$p_id = $this->input->post('p_id');
		$patient_table = $this->session->user_session->patient_table;
		$query = $this->db->query("select billing_open from " . $patient_table . " where id=" . $p_id);

		//1=close 0=open
		if ($this->db->affected_rows() > 0) {
			$billing_open = $query->row()->billing_open;
			if ($billing_open == 1) {
				$status = 0;
			} else {
				$status = 1;

				//check accomodation is run or not
				$check_accomodation = $this->check_accomodation($p_id);
				if (is_array($check_accomodation)) {
					$response['status'] = 201;
					$response['body'] = "Patient is not discharge yet.";
					echo json_encode($response);
					exit;
				}
				if ($check_accomodation == false) {
					$response['status'] = 201;
					$response['body'] = "Accomodation is not calculated for this patient.";
					echo json_encode($response);
					exit;
				}
				//check medicines order pending
				$check_medicine_order_pending = $this->check_medicine_order_pending($p_id);
				if ($check_medicine_order_pending == false) {
					$response['status'] = 201;
					$response['body'] = "Medicine Orders are pending for this patient.";
					echo json_encode($response);
					exit;
				}
				//check service order pending
				$check_service_order_pending = $this->check_service_order_pending($p_id);
				if ($check_service_order_pending == false) {
					$response['status'] = 201;
					$response['body'] = "Service Orders are pending for this patient.";
					echo json_encode($response);
					exit;
				}

			}
			$where = array("id" => $p_id);
			if ($status == 0) {
				$close_date = null;
				$close_user = null;
			} else {
				$close_date = date('Y-m-d H:i:s');
				$close_user = $this->session->user_session->id;
			}
			$set = array("billing_open" => $status, "close_bill_date" => $close_date, "bill_close_user" => $close_user);
			$this->db->where($where);
			$update = $this->db->update($patient_table, $set);
			if ($update == true) {
				$response['status'] = 200;
				if ($status == 0) {
					$response['body'] = "Successfully Open";
				} else {
					$response['body'] = "Successfully Close";
				}

			} else {
				$response['status'] = 201;
				$response['body'] = "Something went wrong";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function check_accomodation($p_id)
	{
		$patient_table = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$query = $this->db->query("select * from " . $patient_table . " where id=" . $p_id);
		if ($this->db->affected_rows() > 0) {

			$discharge_date = $query->row()->discharge_date;
		}
		if (is_null($discharge_date) || $discharge_date == "0000:00:00 00:00:00") {
			$data = array("1");
			return $data;
		}
		$query_get_accom = $this->db->query("select * from " . $billing_transaction . " where patient_id=" . $p_id . " order by id desc");
		if ($this->db->affected_rows() > 0) {
			$result = $query_get_accom->row();
			$date_service = $result->date_service;
		} else {
			$date_service = "";
		}

		if ($date_service == "") {
			return false;
		} else {
			if (strtotime(date('Y-m-d', strtotime($date_service))) == strtotime(date('Y-m-d', strtotime($discharge_date)))) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function check_medicine_order_pending($p_id)
	{
		$patient_table = $this->session->user_session->patient_table;
		$medicine_order_table = "com_1_medicine_order";
		$query = $this->db->query("SELECT count(*) as pending_count FROM " . $medicine_order_table . "
		where patient_id = " . $p_id . " AND (order_status = 1 OR order_status = 2)");
		//echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$count = $result->pending_count;
		} else {
			$count = 0;
		}
		if ($count == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function check_service_order_pending($p_id)
	{
		$patient_table = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$query = $this->db->query("SELECT count(*) as service_peding,
		(SELECT count(*) FROM service_order where patient_id =" . $p_id . " AND service_category='PATHOLOGY' AND sample_pickup != 1) as path_count
		FROM " . $billing_transaction . " where patient_id=" . $p_id . " AND confirm=0 AND type=3");
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$count = $result->service_peding;
			$path_count = $result->path_count;
		} else {
			$count = 0;
			$path_count = 0;
		}

		if ($count == 0 && $path_count == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function saveDiscount()
	{
		$id = $this->input->post('id');
		$total = $this->input->post('total');
		$discount = $this->input->post('discount');
		$type = $this->input->post('type');
		$billing_transaction = $this->session->user_session->billing_transaction;
		if (isset($id)) {
			if ($type == 1) {
				$discounted_value = ($total / 100) * ($discount);
				$final_amount = $total - $discounted_value;
			} else {
				$final_amount = $total - $discount;
			}

			$where = array("id" => $id);
			$set = array("final_amount" => $final_amount, "discount_percent" => $discount, "discount_type" => $type);
			$this->db->where($where);
			$update = $this->db->update($billing_transaction, $set);
			if ($update == true) {
				$response['status'] = 200;
				$response['body'] = "Updated SuccessFully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Something Went Wrong";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Something Went Wrong";
		}
		echo json_encode($response);
	}

	public function deleteBillingTrascationAcc()
	{

		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
			// $table_name='departments_master';
			$departmentData = array('is_deleted' => 0);
			$where = array('id' => $id);
			$result = $this->BillingModel->updateForm($billing_transaction, $departmentData, $where);
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

	public function restoreService()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
			// $table_name='departments_master';
			$departmentData = array('is_deleted' => 1);
			$where = array('id' => $id);
			$result = $this->BillingModel->updateForm($billing_transaction, $departmentData, $where);
			if ($result == TRUE) {
				$response["status"] = 200;
				$response["body"] = "Restored successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Not Restored";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getPatientBIllingPrintData()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$patient_table = $this->session->user_session->patient_table;
			$data = '';
			$patient_name = '';
			$patient_age = '';

			$admission_date = '';
			$admission_time = '';
			$discharge_date = '';
			$discharge_time = '';
			$discount_amt = 0;
			$discount_type = 1;
			$payment_details = $this->getPaymentDetails($patient_id);
			$medicine_charges = $this->getmedicineAndConsumablesTableBillingPrint($patient_id);
			$bed_charges = $this->getAccomodationTableBIllingDataPrint($patient_id);
			$services_and_consult = $this->getserviceOrderCollectionTableBillingPrint($patient_id);
			$paid_amount = $this->getPayableBIllingDataPrint($patient_id);
			$where = "where id='" . $patient_id . "'";
			$resultObject = $this->BillingModel->selectDataById($patient_table, $where);
			// print_r($resultObject);exit();
			if ($resultObject->totalCount > 0) {

				$result = $resultObject->data;
				foreach ($result as $key => $value) {
					$patient_name = $value->patient_name;
					$patient_age = $this->ageCalculator($value->birth_date);
					$patient_id = $value->id;
					$adhar_no = $value->adhar_no;
					$admission_date = date('d M Y', strtotime($value->admission_date));
					$admission_time = date('H:i a', strtotime($value->admission_date));
					if ($value->discharge_date != null && $value->discharge_date != '' && $value->discharge_date != '0000-00-00 00:00:00') {
						$discharge_date = date('d M Y', strtotime($value->discharge_date));
						$discharge_time = date('H:i a', strtotime($value->discharge_date));
					}
					$discount_amt = $value->billing_discount;
					$discount_type = $value->billing_dis_type;
				}


			}
			$summary_rows = "";
			if ($payment_details->totalCount > 0) {
				$paydetails = $payment_details->data;
				foreach ($paydetails as $paydetails) {
					$trans_date = $paydetails->transaction_date;
					$payer_name = $paydetails->payer_name;
					$pricing_type = $paydetails->pricing_type;
					$currency = $paydetails->currency;
					$amount = $paydetails->amount;
					$mode_of_payment = $paydetails->mode_of_payment;
					$summary_rows .= '<tr>
					<td>' . $trans_date . '</td>
					<td><p style="text-transform:capitalize">' . $payer_name . '</p></td>
					<td>' . $pricing_type . '</td>
					<td>' . $currency . '</td>
					<td>' . $amount . '</td>
					<td>' . $mode_of_payment . '</td>
					</tr>';
				}
			}
			$total_amt = $medicine_charges + $bed_charges + $services_and_consult->doctor_charges + $services_and_consult->services_charges;
			if ($discount_type == 1) {
				$total_bill = $total_amt - ($total_amt * ($discount_amt / 100));
				$dis_unit = '%';
			} else {
				$total_bill = $total_amt - $discount_amt;
				$dis_unit = '';
			}

			$payable_amt = $total_bill - $paid_amount;
			// print_r($total_bill);exit();
			$words = '';
			if ($payable_amt > 0) {
				$words = $this->getIndianCurrency($payable_amt);
			}

			$data .= '<div class="row" style="height:150px;">
			</div>
			<div class="row" style="font-size:22px;">
			<div class="col-md-12 text-center"><h4 style="text-decoration:underline;">FINAL BILL</h4></div>
			<div class="col-md-12 d-flex">
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Bill No.</div>
			<div class="col-md-8">: BL_' . $patient_id . '</div>
			</div>
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Bill Date</div>
			<div class="col-md-8">: ' . date("d M Y h:ia") . '</div>
			</div>
			</div>
			<div class="col-md-12 d-flex">
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Name</div>
			<div class="col-md-8">: ' . $patient_name . '</div>
			</div>
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Adm. Date</div>
			<div class="col-md-8">: ' . $admission_date . ' ' . $admission_time . '</div>
			</div>
			</div>
			<div class="col-md-12 d-flex">
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Age</div>
			<div class="col-md-8">: ' . $patient_age . '</div>
			</div>
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Dis. Date</div>
			<div class="col-md-8">: ' . $discharge_date . ' ' . $discharge_time . '</div>
			</div>
			</div>
			<div class="col-md-12 d-flex">
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Patient ID</div>
			<div class="col-md-8">: ' . $adhar_no . '</div>
			</div>
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Case Type</div>
			<div class="col-md-8">: Covid Treatment</div>
			</div>
			</div>
			<div class="col-md-12 d-flex">
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Case ID</div>
			<div class="col-md-8">: ' . $patient_id . '</div>
			</div>
			<div class="col-md-6 d-flex">
			<div class="col-md-4">Location</div>
			<div class="col-md-8">: NSCI, Worli, Mumbai</div>
			</div>
			</div>
			</div>
			<div class="col-md-12">
			<table style="width:100%;margin-top:20px;font-size:22px;">
			<thead style="border-top:1px solid #6c757d;border-bottom:1px solid #6c757d;">
			<tr>
			<th>Particulars</th>
			<th>Qrt</th>
			<th>Rate</th>
			<th>Discount</th>
			<th>Amount</th>
			</tr>
			</thead>
			<tbody style="text-transform:uppercase;">
			<tr>
			<td>medicines charges</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="text-right">' . $medicine_charges . '</td>
			</tr>
			<tr>
			<td>bed charges</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="text-right">' . $bed_charges . '</td>
			</tr>
			<tr>
			<td>Doctor Visit Charges</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="text-right">' . $services_and_consult->doctor_charges . '</td>
			</tr>
			' . $services_and_consult->services . '
			<tr>
			<td class="text-right pr-2" colspan="4">Total</td>
			<td class="text-right" style="border-top:1px dashed black;">' . $total_amt . '</td>
			</tr>
			<tr>
			<td class="text-right pr-2" colspan="4">Discount</td>
			<td class="text-right">' . $discount_amt . '' . $dis_unit . '</td>
			</tr>
			<tr>
			<td class="text-right pr-2" colspan="4">Total Bill Amount</td>
			<td class="text-right" style="border-top:1px dashed black; style="border-bottom:1px dashed black;"><b>' . $total_bill . '</b></td>
			</tr>
			<tr>
			<td class="text-right pr-2" colspan="4">Paid Amount</td>
			<td class="text-right" style="border-top:1px dashed black; style="border-bottom:1px dashed black;"><b>' . $paid_amount . '</b></td>
			</tr>
			<tr>
			<td class="text-right pr-2" colspan="4">Balance to be paid</td>
			<td class="text-right" style="border-top:1px dashed black;border-bottom:1px dashed black;"><b>' . $payable_amt . '</b></td>
			</tr>
			<tr>
			<td colspan="5" class="text-right"><b>(' . $words . ')</b></td>
			</tr>
			</tbody>
			</table>


			<div class="row" style="margin-top:10px;font-size:22px;">
			<div class="col-md-12"><b>Payment Summary :</b></div>
			</div>
			<table style="width:100%;margin-top:20px;font-size:22px;">
			<thead style="border-top:1px solid #6c757d;border-bottom:1px solid #6c757d;">
			<tr>
			<th>Transaction Date</th>
			<th>Payer Name</th>
			<th>Pricing Type</th>
			<th>Currency</th>
			<th>Amount</th>
			<th>Mode of Payment</th>
			</tr>
			</thead>
			<tbody>' . $summary_rows . '
			</tbody>
			</table>

			<div class="row" style="margin-top:150px;font-size:22px;">
			<div class="col-md-6"></div>
			<div class="col-md-6 text-right"><b>Authorized Signatory</b></div>
			</div>';

			// <div class="row" style="margin-top:150px;font-size:22px;">
			// <div class="col-md-6"><b>Sign. of Patient/Relative:</b></div>
			// <div class="col-md-6 text-right"><b>For City Nursing Home:</b></div>
			// </div>';

			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getPatientDetails($patient_id, $patient_table)
	{
		$query=$this->db->query("select * from ".$patient_table." where id=".$patient_id);
		$data='';
		if($this->db->affected_rows() > 0){
			$row=$query->row();
			$data .= '<h5>Patient Info :</h5>';
			$data .='<br>
			<div class="form-row">
		                      <div class="form-group col-md-6">
		                       Name : <span id="">'.$row->patient_name.'</span>
		                      </div>
		                      <div class="form-group col-md-6">
		                       Adhar No : <span id="">'.$row->adhar_no.'</span>
		                      </div>
                    		</div>
                    		<div class="form-row">
		                      <div class="form-group col-md-6">
		                        DOB : <span id="">'.$row->birth_date.'</span>
		                    	</div>
		                       <div class="form-group col-md-6">
		                       Patient ID : <span id="">'.$row->id.'</span>
		                   		
                    		</div>
                    		</div>
                    		<div class="form-row">
		                     <div class="form-group col-md-6">
		                       Consultation Date: <span id="">'.$row->admission_date.'</span>
		                   		</div>
		                      </div>
                    		</div>
                    		</div><hr>
			';
		}
		return $data;
	}

	public function getPatientBIllingPrintDataNew()
	{
		if (!is_null($this->input->post('p_id'))) {
			$patient_id = $this->input->post('p_id');
			$patient_table = $this->session->user_session->patient_table;
			$branch_id = $this->session->user_session->branch_id;
			$data = '';
			$restore=false;
			$consult=false;
			$finalAmount=0;
			$query = $this->db->query("select doctor_speciality as Doctor_speciality,doctor_name as Doctor_name,
patient_complaint as Patient_complaint,diagnosis as Diagnosis,treatment_plan as Treatment_plan,amount as Amount,
transaction_date as Consultation_date from doctor_consult where patient_id=" . $patient_id . " AND branch_id=" . $branch_id . " order by id desc");
			$data .= '<div class="col-md-12 offset-10 firstimgs" ><br><br><img alt="image"  style="width: 200px;height: 92px;" src="' . base_url() . '/assets/img/rel_logo.jpg"  class="" ></div>';
			$data .='<div align="center"><h4>Consultation Billing</h4></div>';
			$data .= $this->getPatientDetails($patient_id, $patient_table);
			if ($this->db->affected_rows() > 0) {
				$data .= '<h5>Consultation :</h5>';
				$data .= '
				<table class="table table-bordered">
				<thead>
				<tr>
				<th>Date/Time</th>
				<th>Doctor Name</th>
				<th>Patient Complaint</th>
				<th>Diagnosis</th>
				<th>Rate(Rs)</th>
				<th>Amount(Rs)</th>
</tr>	</thead><tbody>
				';
				$result = $query->result();
				foreach ($result as $row) {

					$data .= '
					<tr>
					<td>' . $row->Consultation_date . '</td>
					<td>' . $row->Doctor_name . '</td>
					<td>' . $row->Patient_complaint . '</td>
					<td>' . $row->Diagnosis . '</td>
					<td>1100</td>
					<td>1100</td>
					</tr>
					';
					$finalAmount +=1100;
				}
				$data .= '</tbody></table>';
				$consult=true;
			}

			$query2 = $this->db->query("select * from com_1_dep_16 where patient_id=" . $patient_id . " AND branch_id=" . $branch_id);
			if ($this->db->affected_rows() > 0) {
				$result2 = $query2->result();
				$data .= '<h5>Physiotherapist Charges :</h5>';
				$data .= '
				<table class="table table-bordered">
				<thead>
				<tr>
				<th>Date/Time</th>
				<th>Consultation</th>
				<th>Rate(Rs)</th>
				<th>Amount(Rs)</th>
</tr>	</thead><tbody>
				';
				foreach ($result2 as $row2) {
					$data .= '
					<tr>
					<td>' . $row2->trans_date . '</td>
					<td>physiotherapist</td>
					<td>900</td>
					<td>900</td>
					</tr>
					';

					$finalAmount +=900;
				}
				$data .= '</tbody></table>';
				$restore=true;
			}
			$data2='';
			if($restore == true || $consult == true){
				$data2 ='<hr><div class="col-md-12 offset-10">
<label><b>Total Amount : </b></label> '.$finalAmount.'<br>
<label><b>Discount : </b></label> 100%<br>
<label><b>Payable Amount : </b></label> 0
</div>';
			}

			$response['status'] = 200;
			$response['data'] = $data.$data2;
		} else {
			$response['status'] = 201;
			$response['data'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function getPaymentDetails($p_id)
	{
		if (!is_null($p_id)) {
			$patient_id = $p_id;
			$billing_transaction = 'payer_details_section';
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND status=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
		}
		return $resultObject;
	}

	public function getmedicineAndConsumablesTableBillingPrint($p_id)
	{
		if (!is_null($p_id)) {
			$patient_id = $p_id;
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=2 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$sr_no = 1;
				$subTotal = 0;
				$subTotal1 = 0;
				$subTotal2 = 0;
				foreach ($resultObject->data as $key => $value) {
					if ($value->confirm == 1) {
						$subTotal1 = $subTotal1 + $value->final_amount;
					} else if ($value->confirm == 0 && $value->entry_type == 0) {
						$subTotal2 = $subTotal2 + $value->total;
					} else {

					}
					$sr_no++;

				}
				$subTotal = $subTotal1;
				$subTotal = $subTotal - $subTotal2;
				$amount = $subTotal;
			} else {
				$amount = 0;
			}
		} else {
			$amount = 0;
		}
		return $amount;
	}

	public function getAccomodationTableBIllingDataPrint($p_id)
	{

		if (!is_null($p_id)) {
			$patient_id = $p_id;
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=1 AND confirm=1 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$subTotal = 0;
				foreach ($resultObject->data as $key => $value) {
					$date_service = date('d M Y g:i A', strtotime($value->date_service));
					$subTotal = $subTotal + $value->final_amount;
				}
				$amount = $subTotal;
			} else {
				$amount = 0;
			}
		} else {
			$amount = 0;
		}
		return $amount;
	}

	public function getserviceOrderCollectionTableBillingPrint($p_id)
	{
		$dataObject = new stdClass();
		$dataObject->services = '';
		$dataObject->services_charges = 0;
		$dataObject->doctor_consult = '';
		$dataObject->doctor_charges = 0;
		if (!is_null($p_id)) {
			$patient_id = $p_id;
			$billing_transaction = $this->session->user_session->billing_transaction;
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND type=3 AND confirm=1 AND is_deleted=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$subTotal = 0;
				$subTotal1 = 0;
				$subTotal2 = 0;
				$subTotal3 = 0;
				$subTotal4 = 0;
				$subTotal5 = 0;
				$subTotal6 = 0;
				$tableName = "service_master";
				$data1 = '';
				$data2 = '';
				$data3 = '';
				$data4 = '';
				$data5 = '';
				$data_consult = "";
				foreach ($resultObject->data as $key => $value) {
					$serviceMasterData = $this->db->where('service_id', $value->service_id)->get('service_master');
					// print_r($serviceMasterData);exit();
					$date_service = date('d M Y g:i A', strtotime($value->date_service));
					if ($this->db->affected_rows() > 0) {
						$serviceMasterData = $serviceMasterData->row();

						if ($serviceMasterData->service_category == 'PATHOLOGY') {
							$subTotal1 = $subTotal1 + $value->final_amount;
							$data1 .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';
						} else if ($serviceMasterData->service_category == 'RADIOLOGY') {
							$subTotal2 = $subTotal2 + $value->final_amount;
							$data2 .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';

						} else if ($serviceMasterData->service_category == 'EQUIPMENT') {
							$subTotal3 = $subTotal3 + $value->final_amount;
							$data3 .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';

						} else if ($serviceMasterData->service_category == 'PROCEDURE') {
							$subTotal4 = $subTotal4 + $value->final_amount;
							$data4 .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';

						} else if ($serviceMasterData->service_category == 'CONSULT') {
							$subTotal6 = $subTotal6 + $value->final_amount;
							$data_consult .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';
						} else {
							$subTotal5 = $subTotal5 + $value->final_amount;
							$data5 .= '<tr>
								<td>' . $value->service_desc . '</td>
								<td class="text-right">' . $value->unit . '</td>
								<td class="text-right">' . $value->rate . '</td>
								<td class="text-right">' . $value->discount_percent . '</td>
								<td class="text-right">' . $value->final_amount . '</td>
							</tr>';
						}
					}

				}

				$subTotal = $subTotal1 + $subTotal2 + $subTotal3 + $subTotal4 + $subTotal5;
				$data .= $data1 . '' . $data2 . '' . $data3 . '' . $data4 . '' . $data5;

				$dataObject->services = $data;
				$dataObject->services_charges = $subTotal;
				$dataObject->doctor_charges = $subTotal6;
			} else {

			}
		} else {

		}
		return $dataObject;
	}

	function getIndianCurrency(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}

	public function getPayableBIllingDataPrint($p_id)
	{
		if (!is_null($p_id)) {
			$patient_id = $p_id;
			$billing_transaction = 'payer_details_section';
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$where = "where patient_id='" . $patient_id . "' AND status=1 AND branch_id='" . $branch_id . "'";
			$resultObject = $this->BillingModel->selectDataById($billing_transaction, $where);
			// print_r($resultObject);exit();
			$data = '';
			if ($resultObject->totalCount > 0) {
				$subTotal = 0;
				foreach ($resultObject->data as $key => $value) {
					$subTotal = $subTotal + $value->amount;
				}
				$amount = $subTotal;
			} else {
				$amount = 0;
			}
		} else {
			$amount = 0;
		}
		return $amount;
	}

	public function savePatientBIllingDiscountData()
	{
		if (!is_null($this->input->post('p_id')) && !is_null($this->input->post('discount')) && !is_null($this->input->post('discount_amt'))) {
			$patient_table = $this->session->user_session->patient_table;
			$departmentData = array('billing_discount' => $this->input->post('discount_amt'),
				'billing_dis_type' => $this->input->post('discount'));
			$where = array('id' => $this->input->post('p_id'));
			$result = $this->BillingModel->updateForm($patient_table, $departmentData, $where);
			if ($result == TRUE) {
				$response["status"] = 200;
				$response["data"] = "updated successfully";
			} else {
				$response["status"] = 201;
				$response["data"] = "Not updated";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}
}
