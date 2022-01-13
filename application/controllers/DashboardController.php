<?php

require_once 'HexaController.php';

/**
 * @property  User User
 */
class DashboardController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("DashboardModel");
	}

	/*
	 * login api
	 */

	public function cronJob()
	{
		echo "cron_job";
		log_message('ERROR', "cronJob Function call");


	}

	public function index()
	{

	}

	public function dashboard()
	{
		redirect('admin/view_companies');
//        $this->load->view('dashboard/dashboard',array("title"=>" Dashboard"));
	}

	public function icuPatientView()
	{
		$this->load->view('dashboard/icuPatientView', array("title" => " Dashboard"));
	}

	public function patient_dashboard()
	{
		$this->load->view('admin/patients/patient_form', array("title" => "Patient Dashboard"));
	}

	public function staff_dashboard()
	{
		$this->load->view('Staff/staff_registration', array("title" => "Staff Dashboard"));
	}

	public function dashboard_view()
	{
		$this->load->view('dashboard/dashboard', array("title" => " Dashboard"));
	}


	public function getDashboardBillingReport1()
	{
		// $data=$this->input->post();
		// print_r($data);exit();
		// $data1=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true );
		// $json = str_replace('&quot;', '"', $data);
		// print_r($_GET['data']);exit();
		// $json = utf8_encode($data);
		// $object = json_decode($data);
		// $data1 = json_decode($data);
		// print_r($object->monthly_chk);exit();
		if (!is_null($this->input->post('date_wise_chk')) || !is_null($this->input->post('monthly_chk'))) {
			$where = "";
			if (!is_null($this->input->post('date_wise_chk')) && $this->input->post('date_wise_chk') == 'on') {
				if (!is_null($this->input->post('start_date')) && $this->input->post('start_date') != "" && !is_null($this->input->post('end_date')) && $this->input->post('end_date') != "") {
					$start_date = $this->input->post('start_date');
					$end_date = $this->input->post('end_date');
					$where = " and date(pt.admission_date) between " . $start_date . ' and ' . $end_date;
				} else {
					$response['status'] = 201;
					$response['body'] = "Please Select Start date and End date";
					echo json_encode($response);
					exit;
				}


			} else {
				if (!is_null($this->input->post('year_select')) && $this->input->post('year_select') != "" && !is_null($this->input->post('month_select')) && $this->input->post('month_select') != "") {
					$year = $this->input->post('year_select');
					$month = $this->input->post('month_select');
					$where = " and Month(pt.admission_date)='" . $month . "' && YEAR(pt.admission_date)='" . $year . "'";
				} else {
					$response['status'] = 201;
					$response['body'] = "Please Select Year and Month";
					echo json_encode($response);
					exit;
				}
			}

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$patient_table = $this->session->user_session->patient_table;
			$billing_transaction = $this->session->user_session->billing_transaction;
			$service_master = "service_master";
			// $resultObject=$this->db->query("select pt.*,(select group_concat(ac.total) from ".$billing_transaction." ac where ac.patient_id and type=1 and confirm=1) as accomodationTotal from ".$patient_table." pt where pt.branch_id='".$branch_id."' ".$where)->result();
			$resultObject = $this->db->query("select pt.patient_name,pt.id,pt.admission_date,pt.adhar_no,(select sum(ac.total) from " . $billing_transaction . " ac 
where ac.patient_id=pt.id and ac.type=1 and ac.confirm=1) as accomodationTotal,
(select sum(mc.total) from " . $billing_transaction . " mc 
where mc.patient_id=pt.id and mc.type=2) as medicineTotal,
(select sum(so1.total) from " . $billing_transaction . " so1 
where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.service_id in (select sm1.service_id from " . $service_master . " sm1 where sm1.service_category='PATHOLOGY')) as labtest,
(select sum(so1.total) from " . $billing_transaction . " so1 
where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.service_id in (select sm1.service_id from " . $service_master . " sm1 where sm1.service_category='RADIOLOGY')) as radiologytest,
(select sum(so1.total) from " . $billing_transaction . " so1 
where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.service_id in (select sm1.service_id from " . $service_master . " sm1 where sm1.service_category='EQUIPMENT')) as equipmentest,
(select sum(so1.total) from " . $billing_transaction . " so1 
where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.service_id in (select sm1.service_id from " . $service_master . " sm1 where sm1.service_category='PROCEDURE')) as proceduretest,
(select sum(so1.total) from " . $billing_transaction . " so1 
where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.service_id in (select sm1.service_id from " . $service_master . " sm1 where sm1.service_category!='PROCEDURE' and sm1.service_category!='EQUIPMENT' and sm1.service_category!='RADIOLOGY' and sm1.service_category!='PATHOLOGY')) as othertest
from com_1_patient pt 
where pt.branch_id='" . $branch_id . "'" . $where);
			// echo $this->db->last_query();
			$result = "";
			if ($this->db->affected_rows() > 0) {
				$result = $resultObject->result();
				// $this->getDownloadDashboardBilling($result);

				$response['status'] = 200;
				$response['data'] = $result;

			} else {
				$response['status'] = 200;
				$response['data'] = $result;
			}


		} else {
			$response['status'] = 201;
			$response['body'] = "Please Select Date wise or Monthly download";
		}
		echo json_encode($response);
	}

	public function getDashboardBillingReport()
	{
		$data = $this->input->post_get('data');

		// $data1=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data), true );
		// $json = str_replace('&quot;', '"', $data);
		// print_r($_GET['data']);exit();
		// $json = utf8_encode($data);
		$object = json_decode($data);
		// $data1 = json_decode($data);
		// print_r($object->monthly_chk);exit();
		if (!isset($object->date_wise_chk) || !isset($object->monthly_chk)) {

			$where = "";
			if (isset($object->date_wise_chk) && isset($object->date_wise_chk) == 'on') {

				if (isset($object->start_date) && isset($object->start_date) != "" && isset($object->end_date) && isset($object->end_date) != "") {
					$start_date = $object->start_date;
					$end_date = $object->end_date;
					$where = " and (date(pt.admission_date) between '" . $start_date . "' and '" . $end_date . "') or (date(pt.discharge_date) between '" . $start_date . "' and '" . $end_date . "')";
				} else {
					$response['status'] = 201;
					$response['body'] = "Please Select Start date and End date";
					echo json_encode($response);
					exit;
				}


			} else {
				if (isset($object->year_select) && isset($object->year_select) != "" && isset($object->month_select) && isset($object->month_select) != "") {

					$year = $object->year_select;
					$month = $object->month_select;
					$where = " and (Month(pt.admission_date)='" . $month . "' && YEAR(pt.admission_date)='" . $year . "') or (Month(pt.discharge_date)='" . $month . "' && YEAR(pt.discharge_date)='" . $year . "')";
				} else {
					$response['status'] = 201;
					$response['body'] = "Please Select Year and Month";
					echo json_encode($response);
					exit;
				}
			}

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$patient_table = $this->session->user_session->patient_table;
			$billing_transaction = $this->session->user_session->billing_transaction;
			$service_master = "service_master";

			$resultObject = $this->db->query("select pt.patient_name,pt.id,pt.admission_date,pt.adhar_no,pt.discharge_date,pt.branch_id,
			(select group_concat(ac.service_id,'||',ac.total,'||',ac.type,'||',ac.confirm,'||',
			(select sm.service_category from " . $service_master . " sm where sm.service_id=ac.service_id) separator '@@') 
			from " . $billing_transaction . " ac 
			where ac.patient_id=pt.id and ac.branch_id=" . $branch_id . ") as service_order
			from " . $patient_table . " pt where pt.branch_id=" . $branch_id . " and pt.type=1 " . $where);
// 			$resultObject=$this->db->query("select pt.patient_name,pt.id,pt.admission_date,pt.adhar_no,pt.discharge_date,(select sum(ac.total) from ".$billing_transaction." ac 
// where ac.patient_id=pt.id and ac.type=1 and ac.confirm=1 and ac.branch_id='".$branch_id."') as accomodationTotal,
// (select sum(mc.total) from ".$billing_transaction." mc 
// where mc.patient_id=pt.id and mc.type=2 and mc.branch_id='".$branch_id."') as medicineTotal,
// (select sum(so1.total) from ".$billing_transaction." so1 
// where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.branch_id='".$branch_id."' and so1.service_id in (select sm1.service_id from ".$service_master." sm1 where sm1.service_category='PATHOLOGY')) as labtest,
// (select sum(so1.total) from ".$billing_transaction." so1 
// where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.branch_id='".$branch_id."' and so1.service_id in (select sm1.service_id from ".$service_master." sm1 where sm1.service_category='RADIOLOGY')) as radiologytest,
// (select sum(so1.total) from ".$billing_transaction." so1 
// where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.branch_id='".$branch_id."' and so1.service_id in (select sm1.service_id from ".$service_master." sm1 where sm1.service_category='EQUIPMENT')) as equipmentest,
// (select sum(so1.total) from ".$billing_transaction." so1 
// where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.branch_id='".$branch_id."' and so1.service_id in (select sm1.service_id from ".$service_master." sm1 where sm1.service_category='PROCEDURE')) as proceduretest,
// (select sum(so1.total) from ".$billing_transaction." so1 
// where so1.patient_id=pt.id and so1.type=3 and so1.confirm=1 and so1.branch_id='".$branch_id."' and so1.service_id in (select sm1.service_id from ".$service_master." sm1 where sm1.service_category!='PROCEDURE' and sm1.service_category!='EQUIPMENT' and sm1.service_category!='RADIOLOGY' and sm1.service_category!='PATHOLOGY')) as othertest
// from com_1_patient pt 
// where pt.branch_id='".$branch_id."' and type='1' ".$where);
			// echo $this->db->last_query();exit();
			$result = "";
			if ($this->db->affected_rows() > 0) {
				$result = $resultObject->result();


				$this->getDownloadDashboardBilling($result);

				// $response['status'] = 200;
				// $response['data'] = $result;
				$url = str_replace('?s=201', '', $_SERVER['HTTP_REFERER'] . "?s=201");
				redirect($url);
			} else {
				//echo $_SERVER['HTTP_REFERER']."?s=201";

				$url = str_replace('?s=201', '', $_SERVER['HTTP_REFERER'] . "?s=201");
				redirect($url . "?s=201");
				echo json_encode(array("body" => "No data found", "status" => 200));
			}


		} else {
			$url = str_replace('?s=201', '', $_SERVER['HTTP_REFERER'] . "?s=201");
			redirect($url . "?s=201");
			// echo json_encode(array("body"=>"No data found","status"=>200));
			echo json_encode("Please Select Date wise or Monthly download");
		}
		// echo json_encode($response);
	}


	public function getDownloadDashboardBilling($data)
	{

		// $data = $this->input->post_get('data');
		// var_dump($data);exit();
		// $data = json_decode($data);
		// print_r($data);exit();
		$this->createExcel($data, 0);
		// 

	}

	public function createExcel($data, $type)
	{

		// load excel library
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("Billing Report");
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'SlNo');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Addhar');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Admission Date  (dd-Mmm-yy hh:mm AM/PM)');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Accomodation Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Medicine & Consumables Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'LabTest Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Radiology Test Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Equipment Rentals Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Procedures Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Others');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Grand Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Discharge date');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Status');
		$rowCount = 2;
		$k = 1;

		foreach ($data as $row) {


			$accomodationTotal = 0;
			$medicineTotal = 0;
			$labtest = 0;
			$radiologytest = 0;
			$equipmentest = 0;
			$proceduretest = 0;
			$othertest = 0;
			if ($row->service_order != "" && $row->service_order != null) {
				$service_orders = explode('@@', $row->service_order);
				if (!empty($service_orders)) {
					foreach ($service_orders as $value) {
						$single_service = explode('||', $value);
						if (count($single_service) > 4) {
							if ($single_service[2] == 1 && $single_service[3] == 1) {
								$accomodationTotal = (int)$accomodationTotal + (int)$single_service[1];
							} else
								if ($single_service[2] == 2) {
									$medicineTotal = (int)$medicineTotal + (int)$single_service[1];
								} else if ($single_service[2] == 3 && $single_service[3] == 1) {
									if ($single_service[4] == 'PATHOLOGY') {
										$labtest = (int)$labtest + (int)$single_service[1];
									} else if ($single_service[4] == 'RADIOLOGY') {
										$radiologytest = (int)$radiologytest + (int)$single_service[1];
									} else if ($single_service[4] == 'EQUIPMENT') {
										$equipmentest = (int)$equipmentest + (int)$single_service[1];
									} else if ($single_service[4] == 'PROCEDURE') {
										$proceduretest = (int)$proceduretest + (int)$single_service[1];
									} else {
										$othertest = (int)$othertest + (int)$single_service[1];
									}
								}
						}

					}

				}

			}

			// print_r($row->patient_name);exit();
			$grand_total = 0;
			$grand_total = (int)$accomodationTotal + (int)$medicineTotal + (int)$labtest + (int)$radiologytest + (int)$equipmentest + (int)$proceduretest + (int)$othertest;
			$registration_date = date('d-M-Y h:i A', strtotime($row->admission_date));

			if ($row->discharge_date != "" && $row->discharge_date != null && $row->discharge_date != "0000-00-00 00:00:00") {
				$status = "Discharge";
				$discharge_date = date('d-M-Y h:i A', strtotime($row->discharge_date));
			} else {
				$status = "Admit";
				$discharge_date = "";
			}


			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->patient_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->adhar_no);
			//	$objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $registration_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $accomodationTotal);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $medicineTotal);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $labtest);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $radiologytest);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $equipmentest);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $proceduretest);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $othertest);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $grand_total);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $discharge_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $status);

			$rowCount++;
			$k++;
		}
		ob_end_clean();
		$filename = "Billing_Report_" . date("Y-m-d") . "" . time() . ".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}


	public function bed_management_report()
	{
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$patient_table = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;

		$labelArray = array();
		$dataArray1 = array();
		$dataArray2 = array();
		$transArray = array();

		$query = $this->db->query("SELECT room_no,ward_no,id,(select count(id) 
		from " . $hospital_bed_table . " b where b.Id_room=r.id and b.branch_id=" . $branch_id . " and b.category=r.category and b.active=0) as total_bed,
		(select count(id) from " . $hospital_bed_table . " b where b.Id_room=r.id AND b.status=0 and b.active=0 and b.category=r.category and b.branch_id=" . $branch_id . ") as occupied_bed,
		(select count(id) from " . $patient_table . " p where p.roomid=r.id AND p.mark_as_discharge=1 AND (p.discharge_date is null OR p.discharge_date = '0000:00:00 00:00:00') ) as discharge_mark
		 FROM " . $hospital_room_table . " r where branch_id='$branch_id'");
		$data = "";
		// $data .="<table class='table table-bordered'>
		// <thead style='background-color:#dc5a7d'>
		// <tr >
		// <th style='color: white !important;'>Zone</th>
		// <th style='color: white !important;'>Occupied</th>
		// <th style='color: white !important;'>Available</th>
		// <th style='color: white !important;'>Mark for Discharge</th>
		// </tr>
		// </thead>
		// <tbody>";
		// echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			// print_r($result);
			foreach ($result as $row) {
				$zone = $row->room_no . " " . $row->ward_no;
				array_push($labelArray, $zone);
				array_push($dataArray1, $row->occupied_bed);
				array_push($dataArray2, (($row->total_bed) - ($row->occupied_bed)));
				array_push($transArray, $row->discharge_mark);
				// $data .="<tr>
				// <td><b>".$row->room_no.$row->ward_no."</b></td>
				// <td>".$row->occupied_bed."</td>
				// <td>".(($row->total_bed)-($row->occupied_bed))."</td>
				// <td>".$row->discharge_mark."</td>
				// </tr>";
			}

			// $data .="</tbody></table>"; 
			$response["label"] = $labelArray;
			$response["occupied"] = $dataArray1;
			$response["available"] = $dataArray2;
			$response["discharge"] = $transArray;
			$response['status'] = 200;
		} else {
			// $data .="</tbody></table>";
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);

	}

	public function bed_management_report1()
	{
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$patient_table = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;
		$query = $this->db->query("SELECT room_no,ward_no,id,(select count(id) 
		from " . $hospital_bed_table . " b where b.Id_room=r.id) as total_bed,
		(select count(id) from " . $hospital_bed_table . " b where b.Id_room=r.id AND b.status=0 ) as occupied_bed,
		(select count(id) from " . $patient_table . " p where p.roomid=r.id AND p.mark_as_discharge=1 AND (p.discharge_date is null OR p.discharge_date = '0000:00:00 00:00:00') ) as discharge_mark
		 FROM " . $hospital_room_table . " r where branch_id='$branch_id'");
		$data = "";
		$data .= "<table class='table table-bordered'>
		 <thead style='background-color:#dc5a7d'>
		 <tr >
		 <th style='color: white !important;'>Zone</th>
		 <th style='color: white !important;'>Occupied</th>
		 <th style='color: white !important;'>Available</th>
		 <th style='color: white !important;'>Mark for Discharge</th>
		 </tr>
		 </thead>
		 <tbody>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$data .= "<tr>
				  <td><b>" . $row->room_no . $row->ward_no . "</b></td>
				  <td>" . $row->occupied_bed . "</td>
				  <td>" . (($row->total_bed) - ($row->occupied_bed)) . "</td>
				  <td>" . $row->discharge_mark . "</td>
				  </tr>";
			}

			$data .= "</tbody></table>";
			$response['data'] = $data;
			$response['status'] = 200;
		} else {
			$data .= "</tbody></table>";
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);

	}


	function getAllPatientDashboardData($branch_id)
	{
		$result='';
		$active_cases=0;
		$death_today=0;
		$admitted_today=0;
		$discharge_today=0;
		$transfer_today=0;
		$o2_patient=0;
		$no2_patient=0;
		$patient_table = $this->session->user_session->patient_table;
		$resulObject=$this->DashboardModel->_rawQuery('select sum(case when status=1 and admission_mode=2 and admission_date!=\'0000-00-00 00:00:00\' and discharge_date IS NULL then 1 else 0 end ) as active_cases,sum(case when date(discharge_date)=CURRENT_DATE() and event =\'mortality\' then 1 else 0 end) as death_today,
  														sum(case when date(admission_date)=CURRENT_DATE() then 1 else 0 end) as admitted_today,
  														sum(case when date(discharge_date)=CURRENT_DATE() and (is_transfered=0 or is_transfered is null) then 1 else 0 end) as discharge_today,sum(case when date(discharge_date)=CURRENT_DATE() and is_transfered =1 then 1 else 0 end) as transfer_today,
  														sum(case when (select cd.id from com_1_dep_2 cd where cd.branch_id=cp.branch_id and cd.patient_id=cp.id and cd.sec_2_f_347!=1565 and cd.sec_2_f_347 is not null order by cd.id desc limit 1 ) and admission_mode=2 and admission_date!=\'0000-00-00 00:00:00\' and discharge_date IS NULL then 1 else 0 end) as o2_patient,
														sum(case when (select cd.id from com_1_dep_2 cd where cd.branch_id=cp.branch_id and cd.patient_id=cp.id and (cd.sec_2_f_347=1565 or cd.sec_2_f_347 is null) order by cd.id desc limit 1) and admission_mode=2 and admission_date!=\'0000-00-00 00:00:00\' and discharge_date IS NULL then 1 else 0 end) as no2_patient from '.$patient_table.' cp where branch_id='.$branch_id);

		if($resulObject->totalCount>0)
		{
			$resuldata=$resulObject->data[0];
			if(!empty($resuldata->active_cases) || $resuldata->active_cases!=null) {
				$active_cases = $resuldata->active_cases;
			}
			if(!empty($resuldata->death_today) || $resuldata->death_today!=null) {
				$death_today=$resuldata->death_today;
			}
			if(!empty($resuldata->admitted_today) || $resuldata->admitted_today!=null) {
				$admitted_today=$resuldata->admitted_today;
			}
			if(!empty($resuldata->discharge_today) || $resuldata->discharge_today!=null) {
				$discharge_today=$resuldata->discharge_today;
			}
			if(!empty($resuldata->transfer_today) || $resuldata->transfer_today!=null) {
				$transfer_today = $resuldata->transfer_today;
			}
			if(!empty($resuldata->o2_patient) || $resuldata->o2_patient!=null)
			{
				$o2_patient = $resuldata->o2_patient;
			}
			if(!empty($resuldata->no2_patient) || $resuldata->no2_patient!=null)
			{
				$no2_patient = $resuldata->no2_patient;
			}
		}
		$result.='<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-hospital-alt"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Active IP Consus</h4>
								</div>
								<div class="card-body">
									'.$active_cases.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Admitted Today</h4>
								</div>
								<div class="card-body">
									'.$admitted_today.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-ambulance"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Total Discharge Today</h4>
								</div>
								<div class="card-body">
									'.$discharge_today.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-exchange-alt"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Transfer Today</h4>
								</div>
								<div class="card-body">
									'.$transfer_today.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-feather"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Death Today</h4>
								</div>
								<div class="card-body">
									'.$death_today.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>O2 Patient</h4>
								</div>
								<div class="card-body">
									'.$o2_patient.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>No2 Patient</h4>
								</div>
								<div class="card-body">
									'.$no2_patient.'
								</div>
							</div>
						</div>
					</div>';
		return $result;
	}
	function getAllbedsDashboarddata($branch_id)
	{
		//hospital_bed_table
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$result='';
		$occupied_beds=0;
		$vacant_beds=0;
		$icu_beds=0;
		$o2_beds=0;
		$no2_beds=0;
		$resulObject=$this->DashboardModel->_rawQuery(' select sum(case when status=0 and active=0 then 1 else 0 end) as occupied_beds,sum(case when status=1 and active=0 then 1 else 0 end) as vacant_beds,sum(case when status=1 and category=2 and active=0 then 1 else 0 end) as icu_beds,sum(case when (select cm.id from com_1_room cm where cm.id=cb.Id_room and cm.room_category=1) is null then 0 else 1 end) as o2_beds,sum(case when (select cm.id from com_1_room cm where cm.id=cb.Id_room and cm.room_category=2) is null then 0 else 1 end) as no2_beds from '.$hospital_bed_table.' cb where branch_id='.$branch_id);

		if($resulObject->totalCount>0)
		{
			$resuldata=$resulObject->data[0];
			if(!empty($resuldata->occupied_beds) || $resuldata->occupied_beds!=null){
				$occupied_beds=$resuldata->occupied_beds;
			}
			if(!empty($resuldata->vacant_beds) || $resuldata->vacant_beds!=null){
				$vacant_beds=$resuldata->vacant_beds;
			}
			if(!empty($resuldata->icu_beds) || $resuldata->icu_beds!=null) {
				$icu_beds = $resuldata->icu_beds;
			}
			if(!empty($resuldata->o2_beds) || $resuldata->o2_beds!=null) {
				$o2_beds = $resuldata->o2_beds;
			}
			if(!empty($resuldata->no2_beds) || $resuldata->no2_beds!=null) {
				$no2_beds = $resuldata->no2_beds;
			}
		}
		$result.='<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Occupied Beds</h4>
								</div>
								<div class="card-body">
									'.$occupied_beds.'
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>Vacant Beds</h4>
								</div>
								<div class="card-body">
									'.$vacant_beds.'
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-lg-3 col-md-3 col-sm-12">
						<div class="card card-statistic-2">
							<div class="card-icon shadow-primary bg-primary">
								<i class="fas fa-bed"></i>
							</div>
							<div class="card-wrap">
								<div class="card-header">
									<h4>ICU</h4>
								</div>
								<div class="card-body">
									'.$icu_beds.'
								</div>
							</div>
						</div>
					</div>';
		return $result;
	}
	public function get_dashboard_Data()
	{
		$data='';
		$branch_id = $this->session->user_session->branch_id;
		//patient active_cases,admitted_today,discharge_today(not total only discharge),transfer,death_today
		$data.=$this->getAllPatientDashboardData($branch_id);
		//beds occupied and vacant
		$data.=$this->getAllbedsDashboarddata($branch_id);
		$response['data'] = $data;
		$response['status'] = 200;
		echo json_encode($response);
	}
	public function get_monthly_Data()
	{
		$patient_table = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;

		$sql = 'SELECT sum(case when MONTH(admission_date) = MONTH(CURRENT_DATE()) then 1 else 0 end) as admitted, 
sum(case when MONTH(admission_date) <  MONTH(CURRENT_DATE()) and ((discharge_date ="0000:00:00 00:00:00" or discharge_date is null) or MONTH(discharge_date)= MONTH(CURRENT_DATE())) then 1 else 0 end) as patient_on_first, 
 sum(case when Month(discharge_date)=MONTH(CURRENT_DATE()) then 1 else 0 end) as discharge, 
 sum(case when discharge_date !="0000:00:00 00:00:00" and discharge_date is not null and MONTH(discharge_date)=MONTH(CURRENT_DATE()) 
 and event = "mortality" then 1 else 0 end) as mortality, sum(case when is_transfered =1 and MONTH(admission_date)=MONTH(CURRENT_DATE()) 
 then 1 else 0 end) as transfer FROM ' . $patient_table . ' where admission_date != "0000:00:00 00:00:00" and type=1';
		$query = $this->db->query($sql);
		$data = "";
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$count = $result->patient_on_first + $result->admitted - $result->discharge;
			$discharge = $result->discharge - $result->transfer - $result->mortality;
			$patient_on_first = $result->patient_on_first;
			$month = date('M');
			$data .= '
			<div class="card card-statistic-2 pl-3 pr-3">
                <div class="card-stats">
                  <div class="card-stats-title"><h6>Month Till Date (' . $month . ') </h6> </div>
                  <div class="row">
                    <div class="card-stats-item">
                     <div class="border_class">
                      <div class="card-stats-item-count">' . $patient_on_first . '</div>
                      <div class="card_label">Patient on 1st </div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                     <div class="border_class">
                      <div class="card-stats-item-count">' . $result->admitted . '</div>
                      <div class="card_label">Patient Admitted</div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                    	<div class="border_class">
                      <div class="card-stats-item-count">' . $discharge . '</div>
                      <div class="card_label">Patient Discharge</div>
                      </div>
                    </div>
					<div class="card-stats-item">
					<div class="border_class">
                      <div class="card-stats-item-count">' . $result->transfer . '</div>
                      <div class="card_label">Patient Transfer</div>
                      </div>	
                    </div>
					<div class="card-stats-item">
					<div class="border_class">
                      <div class="card-stats-item-count">' . $result->mortality . '</div>
                      <div class="card_label">Patient Death</div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                    	<div class="border_class">
                      <div class="card-stats-item-count">
                      ' . $count . '</div>
                      <div class="card_label">Patient in Facility</div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="card-wrap">
                   <div class="card-header">
                   
                  </div>
                  <div class="card-body">
                  
                  </div>
                </div>
              </div>
			 ';
			$response['data'] = $data;
			$response['status'] = 200;
		} else {
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}
	public function get_yearly_Data()
	{
		$patient_table = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;

		$sql = 'SELECT sum(case when YEAR(admission_date) = YEAR(CURRENT_DATE()) then 1 else 0 end) as admitted, 
sum(case when YEAR(admission_date) <  YEAR(CURRENT_DATE()) and ((discharge_date ="0000:00:00 00:00:00" or discharge_date is null) or
 YEAR(discharge_date)= YEAR(CURRENT_DATE())) then 1 else 0 end) as patient_on_first, 
 sum(case when YEAR(discharge_date)=YEAR(CURRENT_DATE()) then 1 else 0 end) as discharge, 
 sum(case when discharge_date !="0000:00:00 00:00:00" and discharge_date is not null and YEAR(discharge_date)=YEAR(CURRENT_DATE()) 
 and event = "mortality" then 1 else 0 end) as mortality, sum(case when is_transfered =1 and YEAR(admission_date)=YEAR(CURRENT_DATE()) 
 then 1 else 0 end) as transfer FROM ' . $patient_table . ' where admission_date != "0000:00:00 00:00:00" and type=1';
		$query = $this->db->query($sql);
		$data = "";
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$count = $result->patient_on_first + $result->admitted - $result->discharge;
			$discharge = $result->discharge - $result->transfer - $result->mortality;
			$patient_on_first = $result->patient_on_first;
			$year = date('Y');
			$data .= '
			<div class="card card-statistic-2 pl-3 pr-3">
                <div class="card-stats">
                   <div class="card-stats-title"><h6>Year Till Date (' . $year . ')</h6> </div>
                  <div class="row">
                    <div class="card-stats-item">
                    <div class="border_class">
                      <div class="card-stats-item-count">' . $result->patient_on_first . '</div>
                      <div class="card_label">Patient on 1st</div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                    <div class="border_class">
                      <div class="card-stats-item-count">' . $result->admitted . '</div>
                      <div class="card_label">Patient Admitted</div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                    <div class="border_class">
                      <div class="card-stats-item-count">' . $discharge . '</div>
                      <div class="card_label">Patient Discharge</div>
                      </div>
                    </div>
					<div class="card-stats-item">
					<div class="border_class">
                      <div class="card-stats-item-count">' . $result->transfer . '</div>
                      <div class="card_label">Patient Transfer</div>
                      </div>
                    </div>
					<div class="card-stats-item">
					<div class="border_class">
                      <div class="card-stats-item-count">' . $result->mortality . '</div>
                      <div class="card_label">Patient Death</div>
                      </div>
                    </div>
                    <div class="card-stats-item">
                    <div class="border_class">
                      <div class="card-stats-item-count"> ' . $count . '</div>
                      <div class="card_label">Patient in Facility</div>
                      </div>
                    </div>
					
                  </div>
                </div>
             
                <div class="card-wrap">
                  <div class="card-header">
                   
                  </div>
                  <div class="card-body">
                  
                  </div>
                </div>
              </div>
			 ';
			$response['data'] = $data;
			$response['status'] = 200;
		} else {
			$response['data'] = $data;
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	public function getDeathTranferBillingReport()
	{
		$status = $this->input->post('status');
		$event = $this->input->post('event');

		$patient_table = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$where = "";

		if ($event == 1) {
			$where .= " and (cp.event='mortality' or cp.is_transfered=1)";
		} else if ($event == 2) {
			$where .= " and (cp.event='mortality')";
		} else if ($event == 3) {
			$where .= " and (cp.is_transfered=1)";
		}

		if ($status == 1) // all
		{
			$where .= "";
		} else if ($status == 2) //open
		{
			$where .= " and billing_open=0";
		} else if ($status == 3) //close
		{
			$where .= " and billing_open=1";
		} else {
			$where .= "";
		}


		$memData = $this->DashboardModel->getTableData($patient_table, $billing_transaction, $where);

		$results_last_query = $this->db->last_query();
		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				if ((int)$row->is_transfered == 1) {
					$status = "Transfer";
				} else {
					$status = "Death";
				}

				if ($row->billing_open == 0) {
					$billing_status = "Open Bill";
				} else {
					$billing_status = "Closed Bill";
				}
				$tableRows[] = array(

					$row->patient_name,
					$status,
					$row->bill_amount,
					$billing_status,
					$row->id,

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
		$results['total_count'] = count($memData);
		echo json_encode($results);
	}

	public function getDeathTranferBillingExcelReport()
	{
		$data = $this->input->post_get('data');

		$object = json_decode($data);
		$patient_table = $this->session->user_session->patient_table;
		$billing_transaction = $this->session->user_session->billing_transaction;

		$where = "";


		if ($object->event == 1) {
			$where .= " and (cp.event='mortality' or cp.is_transfered=1)";
		} else if ($object->event == 2) {
			$where .= " and (cp.event='mortality')";
		} else if ($object->event == 3) {
			$where .= " and (cp.is_transfered=1)";
		}

		if ($object->status == 1) // all
		{
			$where .= "";
		} else if ($object->status == 2) //open
		{
			$where .= " and billing_open=0";
		} else if ($object->status == 3) //close
		{
			$where .= " and billing_open=1";
		} else {
			$where .= "";
		}


		$memData = $this->DashboardModel->getTableData($patient_table, $billing_transaction, $where);

		$results_last_query = $this->db->last_query();

		if (count($memData) > 0) {
			$this->deathTransferBillCreateExcel($memData, 0);
		} else {
			echo json_encode(array("body" => "No data found", "status" => 200));
		}
	}

	public function deathTransferBillCreateExcel($data, $type)
	{
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("Death & Transfer Bill Report");
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Patinet Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Adhar');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Gender');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Contact');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Admission Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Admission Time');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Discharge Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Discharge Time');
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Discharge Condition');
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Transfer To');
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Transfer Reason');
		$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Bill Status');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Bill Amount');
		$rowCount = 2;
		$k = 1;
		foreach ($data as $row) {
			if ($row->gender == 1) {
				$gender = "Male";
			} else if ($row->gender == 2) {
				$gender = "Female";
			} else if ($row->gender == null) {
				$gender = "";
			} else {
				$gender = "Other";
			}
			$admission_date = "";
			if ($row->admission_date != null && $row->admission_date != "0000-00-00 00:00:00") {
				$admission_date = date("Y-m-d", strtotime($row->admission_date));
			}
			$admission_time = "";
			if ($row->admission_date != null && $row->admission_date != "0000-00-00 00:00:00") {
				$admission_time = date("H:i:sa", strtotime($row->admission_date));
			}
			if ($row->is_transfered == 1) {
				$status = "Transfer";
			} else {
				$status = "Death";
			}
			$discharge_date = "";
			if ($row->discharge_date != null && $row->discharge_date != "0000-00-00 00:00:00") {
				$discharge_date = date("Y-m-d", strtotime($row->discharge_date));
			}
			$discharge_time = "";
			if ($row->discharge_date != null && $row->discharge_date != "0000-00-00 00:00:00") {
				$discharge_time = date("H:i:sa", strtotime($row->discharge_date));
			}
			if ($row->billing_open == 0) {
				$bill_status = "Open Bill";
			} else {
				$bill_status = "Closed Bill";
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->patient_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->adhar_no);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gender);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->contact);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $admission_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $admission_time);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $status);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $discharge_date);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $discharge_time);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->discharge_condition);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->transfer_to);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->transfer_reason);
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $bill_status);
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->bill_amount);

			$rowCount++;
			$k++;
		}
		ob_end_clean();
		$filename = "Death&TransferBillingReport" . date("Y-m-d") . "" . time() . ".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	// public function globalExcelCreate($title,$header,$data)
	// {
	// 	$this->load->library('excel');
	// 	//$listInfo = $this->export->exportList();
	// 	$objPHPExcel = new PHPExcel();
	// 	$objPHPExcel->setActiveSheetIndex(0);
	// 	// set Header
	// 	$objPHPExcel->getActiveSheet()->setTitle($title);

	// 	foreach ($header as $key => $value) {
	// 		$objPHPExcel->getActiveSheet()->SetCellValue(chr().'1', $value);
	// 	}

	// 	foreach ($data as $key => $value) {
	// 		foreach ($value as $row) {

	// 		}
	// 	}
	// 	$rowCount = 2;
	// 	$k = 1;
	// }
}
