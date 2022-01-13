<?php

require_once 'HexaController.php';

/**
 * @property  ServiceOrderModel ServiceOrderModel
 * @property  Global_model Global_model
 */
class PickupController extends HexaController
{


	/**
	 * PickupController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ServiceOrderModel');
	}


	public function index()
	{
		$this->load->view("ServiceOrder/sample_pickup_view", array("title" => "Sample Pickup View"));
	}
	public function index1()
	{
		$this->load->view("ServiceOrder/sample_pickup_view1", array("title" => "Sample Pickup View"));
	}

	public function getSampleCollectedOrder()
	{

		if (!is_null($this->input->post("pickup_date"))) {
			if ($this->input->post("pickup_date") != "") {
				$pickup_date = $this->input->post("pickup_date");
			} else {
				$pickup_date = date('Y-m-d H:i:s');
			}

		} else {
			$pickup_date = date('Y-m-d H:i:s');
		}
		// session values
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		// dynamic tables
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;

		if (!is_null($this->input->post('category'))) {
			$category = $this->input->post('category');
		} else {
			$category = "PATHOLOGY";
		}
		$zone = $this->input->post('zone_id');

		$where = array(
			'branch_id' => $branch_id,
			'company_id' => $company_id,
			'confirm_service_given' => 1,
			'service_category' => $category,
			'service_given_date <=' => $pickup_date,
			'sample_pickup' => 0,
			'is_deleted'=>1

		);

		if (!is_null($this->input->post('patient_id'))) {
			$where['patient_id'] = $this->input->post('patient_id');
		}

		$tableName = "service_order so";

		$order = array('id' => 'desc');
		$column_order = array('service_id', 'service_description');
		$column_search = array();
		$select = array("so.*", "(select pt.patient_name from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_name",
			"(select pt.roomid from " . $patient_table . " pt WHERE pt.id=so.patient_id) as room_id",
			" group_concat(concat('AA',lpad(id,6,'0'))) as order_id",
			"group_concat(service_id) as service_code", "group_concat(service_detail) as service_name");


		$sql = "select so.*,(select pt.patient_name from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_name,group_concat(concat('AA',lpad(id,6,'0'))) as order_id
		,group_concat(service_id) as service_code,group_concat(service_detail) as service_name from " . $tableName . " ";

		$this->db->select($select)->where($where)->group_by('service_category,patient_id');
		if (!is_null($zone)) {
			if ((int)$zone != -1) {
				$this->db->having('room_id', $zone);
			}
		}
		$memData = $this->db->get($tableName)->result();
		$results_last_query = $this->db->last_query();

//		$this->db->query($sql);
//
//		$memData = $this->ServiceOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order, 'service_no,patient_id');
//		$results_last_query = $this->db->last_query();
//		$filterCount = $this->ServiceOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
//		$totalCount = $this->ServiceOrderModel->countAll($tableName, $where);


		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$tableRows[] = array(
					$row->order_number,
					$row->patient_name,
					$row->order_id,
					$row->service_code,
					$row->service_name,

					$row->id,
					$row->patient_id,
				);
			}
			$results = array(
				"draw" => 1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => 1,
				"recordsTotal" => count($memData),
				"recordsFiltered" => count($memData),
				"data" => $memData
			);
		}
		$results['last_query'] = $results_last_query;
		echo json_encode($results);
	}

	function getSampleZones()
	{

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$patient_table = $this->session->user_session->patient_table;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		if (!is_null($this->input->post('category'))) {
			$category = $this->input->post('category');
		} else {
			$category = "PATHOLOGY";
		}

		$sql = "select (select (select group_concat(bm.room_no,'-',bm.ward_no ) from " . $hospital_room_table . " bm where bm.id=pt.roomid) as zone,pt.room_id from " . $patient_table . " pt WHERE pt.id=so.patient_id ) from service_order so where so.confirm_service_given=1 and 
                                  so.branch_id=" . $branch_id . " and so.company_id=" . $company_id . " and so.service_category='" . $category . "'";
		$resultObject = $this->ServiceOrderModel->_rawQuery($sql);
		$optionsArray = array();

		if ($resultObject->totalCount > 0) {
			foreach ($resultObject->data as $zone) {
				$data = array("id" => $zone->room_id, "text" => $zone->zone);
				array_push($optionsArray, $data);
			}
			$response["status"] = 200;
		} else {
			$response["status"] = 201;
		}
		$response["body"] = $optionsArray;

		echo json_encode($response);
	}

	function saveCollection()
	{

		if (!is_null($this->input->post("sampleCollection"))) {
			$user_id = $this->session->user_session->id;
			$sampleCollection = json_decode($this->input->post("sampleCollection"));

			if (count($sampleCollection)) {
				$samplePickup = array();
				$this->load->model('Global_model');
				$samplePickupNumber = $this->Global_model->generate_order("select sample_pickup_no from service_order where sample_pickup_no='#id'");
				foreach ($sampleCollection as $sample) {

					$pickup = array(
						'sample_pickup' => 1,
						'sample_pickup_date' => date("Y-m-d H:i:s"),
						'sample_pickup_user_id' => $user_id,
						'sample_pickup_no' => $samplePickupNumber
					);
					$pickupObject = new stdClass();
					$pickupObject->id = $sample->id;
					$pickupObject->value = $pickup;
					array_push($samplePickup, $pickupObject);
				}
				if ($this->ServiceOrderModel->saveSampleCollection($samplePickup)) {
					$response["status"] = 200;
					$response["body"] = "Sample Pickup Save";
					$response["mode"] = true;
					$response["pickup_number"] = $samplePickupNumber;
				} else {
					$response["mode"] = false;
					$response["status"] = 201;
					$response["body"] = "Failed To Save";
				}

			} else {
				$response["status"] = 201;
				$response["body"] = "No Sample Selected";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}

	public function ExcelDownload()
	{
		$data = $this->input->post_get('data');
		$data = (json_decode($data));
		$this->createExcel($data, 0);
	}

	public function getExcel(){
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("ARegistrations");
		$registration_date='2021-06-02 01:54:25';// 20:24
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SlNo');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'OrgName');
		date_default_timezone_set('Asia/Kolkata');
		$sample_pickup_date = date('d-M-y h:i A', strtotime($registration_date));
		$objPHPExcel->getActiveSheet()->getStyle('A1' . 1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
//		$objPHPExcel->getActiveSheet()->SetCellValue('A1' . 1, PHPExcel_Shared_Date::PHPToExcel(PHPExcel_Shared_Date::PHPToExcel( $timeStart + date('Z', $timeStart) )));
		$objPHPExcel->getActiveSheet()->SetCellValue('A1' . 2, PHPExcel_Shared_Date::PHPToExcel(date('Y-m-d')));
		$filename = "Sample_collection" . date("Y-m-d") . ".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	public function createExcel($data, $type)
	{
		$fileName = 'data-' . time() . '.xlsx';
		// load excel library
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("ARegistrations");

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SlNo');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'OrgName');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Location');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Registration Date  (dd-Mmm-yy hh:mm AM/PM)');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'External Patient Number');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Salutation');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'DoB (dd-Mmm-yy)');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Age');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Age Type');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Sex');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Test Codes');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Client Code');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'MobileNo');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Remarks');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'PatientAddress');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Sample PickUp Date & Time (dd-Mmm-yy hh:mm AM/PM)');
		$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'OrderID');
		$rowCount = 2;
		$k = 1;

		foreach ($data as $d) {
			$id = $d->id;
			$query = $this->db->query("select *, concat('N',lpad(patient_id,9,'0')) as patient_number from service_order where order_number='$id' and `service_category` = 'PATHOLOGY' and is_deleted=1");
			if ($this->db->affected_rows() > 0) {
				$result = $query->row();
				$registration_date = $result->order_date;
				$sample_pickup_date = $result->sample_pickup_date;
				$external_patient_number = $result->patient_id;
				$sample_pickup_no = $result->sample_pickup_no;
				$adhar_number = $result->patient_number;
				$patientData = $this->get_patient_name($external_patient_number);

				$allData = $this->get_data($id, $type, $external_patient_number,$result->sample_pickup_no);


				$service_id = "";
				$order_id = "";
				if ($allData != false) {
					$service_id = $allData->service_code;
					$order_id = $allData->order_id;
					$adhar_number = $allData->patient_number;
				}


				if ($patientData != false) {

					$patient_name = $patientData->patient_name;
					if ((int)$patientData->roomid == 0) {
						$clientcode = " ";
					} else {
						$clientcode = $patientData->roomid;
					}


					$gender = $patientData->gender;
					$Salutation = ' ';
					if ($gender == 1) {
						$gender = "M";
						$Salutation = "Mr.";
					} elseif ($gender == 2) {
						$Salutation = "Mrs.";
						$gender = "F";
					} else {
						$Salutation = "Mx.";
						$gender = "Other";
					}
					$birth_date = $patientData->birth_date;
					$district = $patientData->district;
					$contact = $patientData->contact;
				} else {
					$adhar_number = "";
					$patient_name = "";
					$clientcode = "";
					$gender = "";
					$birth_date = "";
					$district = "";
					$contact = "";
				}
				if ($birth_date == "0000-00-00") {
					$birth_date = " ";
				} else {
					$birth_date = PHPExcel_Shared_Date::PHPToExcel(date('d-m-Y', strtotime($birth_date)));
				}
				if ($type == 0) {
					$registration_date = date('d-M-y h:i A', strtotime(date("d-m-Y h:ia")));
					$sample_pickup_date = date('d-M-y h:i A', strtotime(date("d-m-Y h:ia")));
				} else {
					$registration_date = date('d-M-y h:i A', strtotime('+5 hours +30 minutes'.$sample_pickup_date));
					//$sample_pickup_date = DateTime::createFromFormat('Y-m-d H:i', strtotime($sample_pickup_date));
					$sample_pickup_date = date('d-M-y h:i A', strtotime('+5 hours +30 minutes'. $sample_pickup_date));
				}


				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, "Reliance HNH");
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, "NSCI");
				$objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, PHPExcel_Shared_Date::PHPToExcel(strtotime($registration_date)));
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $adhar_number);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $Salutation);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $patient_name);
				$objPHPExcel->getActiveSheet()->getStyle('H' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $birth_date);
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, " ");
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, " ");
				$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $gender);
				$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $service_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $clientcode);
				$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $contact);
				$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, "");
				$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $district);
				$objPHPExcel->getActiveSheet()->getStyle('Q' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount,  PHPExcel_Shared_Date::PHPToExcel(strtotime($sample_pickup_date)));



				$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $order_id);
				$rowCount++;
				$k++;
			} else {

			}


		}

		$filename = "Sample_collection" . date("Y-m-d") . ".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

	public function get_patient_name($external_patient_number)
	{
		$tableName = $this->session->user_session->patient_table;
		$sql = "select * from " . $tableName . " where id=" . $external_patient_number;
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function get_data($id, $type, $external_patient_number,$order_number)
	{
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$patient_table = $this->session->user_session->patient_table;
		if ($type == 1) {
			$dateFrom = "sample_pickup = 1 and sample_pickup_no='".$order_number."'";
		} else {
			$dateFrom = 'sample_pickup = 0 ';
		}

//		$sql = "SELECT `so`.*,
//       concat('N',lpad(so.patient_id,9,'0')) as patient_number,
//(select pt.patient_name from com_1_patient pt WHERE pt.id=so.patient_id) as patient_name,
// group_concat(concat('AA',lpad(id,6,'0'))) as order_id,
// group_concat(service_id) as service_code,
// group_concat(service_detail) as service_name
//FROM `service_order` `so`where patient_id= '$external_patient_number' and  service_category='PATHOLOGY' and order_number='$order_number' group by service_category,patient_id";

		$sql = "SELECT `so`.*, 
        concat('N',lpad(so.patient_id,9,'0')) as patient_number,
       (select pt.patient_name from ".$patient_table." pt WHERE pt.id=so.patient_id) as patient_name,
       (select pt.roomid from ".$patient_table." pt WHERE pt.id=so.patient_id) as room_id,
 group_concat(concat('AA',lpad(id,6,'0'))) as order_id,
  group_concat(service_id) as service_code,
 group_concat(service_detail) as service_name
 FROM `service_order` `so`
 WHERE `branch_id` = '$branch_id' AND `company_id` = '$company_id' AND `confirm_service_given` = 1 and is_deleted=1 and ".$dateFrom."
 AND `service_category` = 'PATHOLOGY' and patient_id='$external_patient_number' 
 GROUP BY `service_category`, `patient_id`";
		$query = $this->db->query($sql);

		if ($this->db->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function downloadSampleOrderTable($order_number)
	{

		if (!is_null($order_number)) {
			$orderResult = $this->db
				->select('order_number as id')
					->where(array('sample_pickup_no'=> $order_number,"is_deleted"=>1))
				->group_by('patient_id')
				->get("service_order")->result();
			$orderItems = array();
			if (count($orderResult) > 0) {
				foreach ($orderResult as $order) {
					array_push($orderItems, $order);
				}
				$this->createExcel($orderItems, 1);
			} else {
				echo json_encode("Order Data Not Found");
			}
		} else {
			echo json_encode("Invalid Request");
		}
	}

	public function getAllOrderSampleCollected()
	{

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$mbData = $this->db
			->select(array("sample_pickup_no", "sample_pickup_date","order_number"))
			->where(array("company_id" => $company_id, "branch_id" => $branch_id, "sample_pickup" => 1, 'sample_pickup_user_id' => $user_id))
			
			->order_by('sample_pickup_date','desc')
			->get("service_order")->result();
		$tableRows = array();
		if (count($mbData) > 0) {
			foreach ($mbData as $order) {
				array_push($tableRows, array($order->sample_pickup_no, $order->sample_pickup_date,$order->order_number));
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows
		);

		echo json_encode($results);
	}
	
	public function HistorySampleTableData()
	{
		
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$statusFilter=$this->input->post('historyStatus_filter');
		$HistoryPatient=$this->input->post('HistoryPatient');

		if(is_null($this->input->post('historyStatus_filter')))
		{
			$statusFilter=0;
		}

		$where=array("company_id" => $company_id, "branch_id" => $branch_id, 'sample_pickup_user_id' => $user_id);
		if($statusFilter==1)
		{
			$where['sample_status']=0;
		}
		else if($statusFilter==2)
		{
			$where['sample_status']=1;
		}
		else
		{
			$where=array("company_id" => $company_id, "branch_id" => $branch_id, 'sample_pickup_user_id' => $user_id,"patient_id"=>$HistoryPatient);
		}
		// print_r($where);exit();
		$mbData = $this->db
			->select(array("patient_id","patient_name","adhar_number","order_number","service_detail","service_id", "create_on","sample_status","concat('AA',lpad(id,6,'0')) as orderGenerateId"))
			->where($where)
			->order_by('create_on','desc')
			->get("service_order")->result();
		$tableRows = array();
		//echo $this->db->last_query();
		// echo $this->db->last_query();
		if (count($mbData) > 0) {
			foreach ($mbData as $order) {
				
				if($order->sample_status == 0){
					$status="Pending";
				}else{
					$status="Completed";
				}
				array_push($tableRows, array($order->order_number,
				$order->create_on,$status,$order->patient_name,$order->orderGenerateId,$order->service_detail,$order->service_id,$order->patient_id));
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows
		);

		echo json_encode($results);
	}
	public function HistorySampleItemTableData(){
		$id=$this->input->post('id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$mbData = $this->db
			->select(array("*","concat('AA',lpad(id,6,'0')) as orderGenerateId"))
			->where(array("order_number"=>$id))
			->order_by('create_on','desc')
			->get("service_order")->result();
		// echo $this->db->last_query();
		$tableRows = array();
		if (count($mbData) > 0) {
			foreach ($mbData as $order) {
				if($order->sample_status == 1){
					$status="Complete";
				}else{
					$status="Pending";
				}
				array_push($tableRows, array($order->patient_name, $order->service_detail,$order->price,$order->sample_pickup_date,$status,$order->orderGenerateId));
			}
		}
		$results = array(
			"draw" => 1,
			"recordsTotal" => count($mbData),
			"recordsFiltered" => count($mbData),
			"data" => $tableRows
		);

		echo json_encode($results);
	}

	public function DownloadSampleHistory($statusFilter)
	{	

		if (!is_null($statusFilter)) {
			$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		// $statusFilter=$this->input->post('historyStatus_filter');

		$where=array("company_id" => $company_id, "branch_id" => $branch_id, 'sample_pickup_user_id' => $user_id);
		$statusName="All";
		if($statusFilter==1)
		{
			$where['sample_status']=0;
			$statusName="Pending";
		}
		else if($statusFilter==2)
		{
			$where['sample_status']=1;
			$statusName="Completed";
		}
		else
		{
			$where=array("company_id" => $company_id, "branch_id" => $branch_id, 'sample_pickup_user_id' => $user_id,'patient_id'=>$patient_id);
			$statusName="All";
		}

		$mbData = $this->db
			->select(array("patient_id","patient_name","adhar_number","order_number","service_detail","service_id", "create_on","sample_status","concat('AA',lpad(id,6,'0')) as orderGenerateId"))
			->where($where)
			->order_by('create_on','desc')
			->get("service_order")->result();
			// load excel library
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("sample colllection ".$statusName);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SlNo');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Patient ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Service Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Service Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Order Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Date  (dd-Mmm-yy hh:mm AM/PM)');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
		$rowCount = 2;
		$k = 1;

		
			if (count($mbData) > 0) {
			foreach ($mbData as $order) {
				
				if($order->sample_status ==0){
					$status="Pending";
				}else{
					$status="Completed";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $order->patient_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $order->patient_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $order->service_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $order->service_detail);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $order->orderGenerateId);
				$objPHPExcel->getActiveSheet()->getStyle('G' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, PHPExcel_Shared_Date::PHPToExcel(strtotime($order->create_on)));
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $status);
				$rowCount++;
				$k++;
			}
			// $filename = "Sample_collection" . date("Y-m-d") . ".xlsx";
			$filename = 'sample_collection_history-' . time() . '.xlsx';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		}
		else
		{
			echo json_encode("Order Data Not Found");
		}
		
			
		} else {
			echo json_encode("Invalid Request");
		}
	}
	
	function getServiceOrderPList(){
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$patient_table = $this->session->user_session->patient_table;
		$user_id = $this->session->user_session->id;
		//$validObject = $this->is_parameter(array("searchTerm"));
		$response = array();
		

			//$search = $validObject->param->searchTerm;
			$where = array("company_id"=>$company_id,"branch_id"=>$branch_id,"sample_pickup_user_id"=>$user_id);
			$userData = $this->db->select(array("patient_id", 
			"(select patient_name from ".$patient_table." c where c.id=s.patient_id) as patient_name"))
			->where($where)->group_by("patient_id")->get("service_order s")->result();


			//echo $this->db->last_query();
			$response["last_query"] = $this->db->last_query();
			$data = array();
			$option="<option selected disabled>Select Patient</option>";
			if (count($userData) > 0) {
				foreach ($userData as $user) {
					$option .="<option value='".$user->patient_id."'>".$user->patient_name."</option>";
					//array_push($data, array("id" => $user->patient_id, "text" => $user->patient_name));
				}
			}
			$response["status"] = 200;
			$response["body"] = $option;
		
		echo json_encode($response);
	}



}
