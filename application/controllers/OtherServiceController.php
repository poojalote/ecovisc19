<?php

require_once  'HexaController.php';
class OtherServiceController extends HexaController
{


	/**
	 * OtherServiceController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function load_view(){
		$this->load->view("othersService/view_other_services",array("title"=>"Other Service"));
	}

	public function getOtherServiceReport()
	{
		$data=$this->input->post_get('data');
		
		$object = json_decode($data);
		// print_r($object);exit();

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction." bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;

		if($object->patient_id!=null && $object->patient_id!="" && $object->patient_id!="null")
		{
			if($object->category!=null && $object->category!="" && $object->category!="null")
			{
				$where="((bm.type=3"." AND bm.confirm=0"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id."))
			and bm.service_id in (select service_id from service_master where service_category='".$object->category."')";
			}
			else
			{
				$where="((bm.type=3"." AND bm.confirm=0"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id."))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
			}
			
		}
		else if($object->category!=null && $object->category!="" && $object->category!="null")
		{
			$where="((bm.type=3"." AND bm.confirm=0"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id."))
			and bm.service_id in (select service_id from service_master where service_category='".$object->category."')";
		}
		else
		{
			$where="((bm.type=3"." AND bm.confirm=0"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=0 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." ))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
		}
		$order = array('bm.id' => 'desc');


		$select = array('bm.*',"(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from ".$hospital_bed_table." bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from ".$patient_table." pt WHERE pt.id=bm.patient_id) as patient_info",
			"(select pt.roomid from ".$patient_table." pt where  pt.id=bm.patient_id) as room_id",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		 $this->db->select($select)->where($where)->order_by('bm.id','desc');
		
		$memData = $this->db->get($billing_transaction)->result();

		// echo $this->db->last_query();exit();
		if (count($memData) > 0) {
			$this->createExcel($memData, 0);
		}
		else
		{
			// $url=str_replace($_SERVER['HTTP_REFERER']);
			redirect($_SERVER['HTTP_REFERER']);
			echo json_encode(array("body"=>"No data found","status"=>200));
		}
	}

	public function createExcel($data,$type)
	{
		// print_r($data);exit();
		// load excel library
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("Other Service Report");
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bed No');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Service Code');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Service Order No');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Service Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Service Provider');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Date and Time  (dd-Mmm-yy hh:mm AM/PM)');
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Service Confirm');
		$rowCount = 2;
		$k = 1;
		$service_confirm="No";
		if($type==1)
		{
			$service_confirm="Yes";
		}
		foreach ($data as $row) {
			
				
					$patient_info = explode('|||', $row->patient_info);
				if (count($patient_info) > 2) {
					$patient_name = $patient_info[0];
					$bed_name = $patient_info[1];
					$room_id = $patient_info[2];
					if($row->date_service!=null && $row->date_service!="0000-00-00 00:00:00"){
						// $date = $this->getDate($row->service_given_date);
						$date = date("Y-m-d h:i:sa", strtotime($row->date_service));
						// $date = new /DateTime($row->service_given_date);
					}
					else
					{
						$date="-";
					}
					if($row->user!=null && $row->user!="")
					{
						$user=$row->user;
					}
					else{
						$user="-";
					}

				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $bed_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $patient_name);
			//	$objPHPExcel->getActiveSheet()->getStyle('D' . $rowCount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX22);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->service_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->order_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->service_desc);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $user);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $date);
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $service_confirm);

				$rowCount++;
				$k++;

				}
				// print_r($row->patient_name);exit();
				
				
		}
		// print_r($objPHPExcel);exit();
		ob_end_clean();
		$filename = "Other_Services_" . date("Y-m-d") . "" . time() . ".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}

	public function getOtherServicesHistoryReport()
	{
		$data=$this->input->post_get('data');
		
		$object = json_decode($data);
		// print_r($object);exit();

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$billing_transaction = $this->session->user_session->billing_transaction." bm";//hospital_room_table
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$service_table="service_order";

	if($object->patient_id!=null && $object->patient_id!="" && $object->patient_id!="null")
		{
			if($object->category!=null && $object->category!="" && $object->category!="null")
			{
				$where="((bm.type=3"." AND bm.confirm=1"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id."))
			and bm.service_id in (select service_id from service_master where service_category='".$object->category."')";
			}
			else
			{
				$where="((bm.type=3"." AND bm.confirm=1"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." and bm.patient_id=".$object->patient_id."))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
			}
			
		}
		else if($object->category!=null && $object->category!="" && $object->category!="null")
		{
			$where="((bm.type=3"." AND bm.confirm=1"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id."))
			and bm.service_id in (select service_id from service_master where service_category='".$object->category."')";
		}
		else
		{
			$where="((bm.type=3"." AND bm.confirm=1"." AND bm.is_deleted=1 AND bm.branch_id=".$branch_id.")".
			"OR (bm.type=1 AND bm.entry_type=1 AND bm.confirm=1 AND bm.is_deleted=1 AND bm.branch_id=".$branch_id." ))
			and bm.service_id in (select service_id from service_master where service_category not in ('ACCOMM','RADIOLOGY','PATHOLOGY'))";
		}
		$order = array('bm.id' => 'desc');


		$select = array('bm.*',"(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm1.bed_name from ".$hospital_bed_table." bm1 where bm1.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from ".$patient_table." pt WHERE pt.id=bm.patient_id) as patient_info","(select GROUP_CONCAT(st.file_upload,'||',st.normal_status,'||',(case when st.Remark is not null then st.Remark else ' ' end)) from ".$service_table." st where st.id=bm.reference_id) as service_files",
			"(select pt.roomid from ".$patient_table." pt where  pt.id=bm.patient_id) as room_id",
			"(select um.name from users_master um where um.id=bm.create_by) as user");
		$column_order = array('patient_name', 'adhar_number');
		$column_search = array('patient_name', 'adhar_number');

		$this->db->select($select)->where($where)->order_by('bm.id','desc');
	
		$memData = $this->db->get($billing_transaction)->result();
		if (count($memData) > 0) {
			$this->createExcel($memData, 1);
		}
		else
		{
			redirect($_SERVER['HTTP_REFERER']);
			echo json_encode(array("body"=>"No data found","status"=>200));
		}
	}

}
