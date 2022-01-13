<?php
require_once 'HexaController.php';

/**
 * @property  Doctor Doctor
 */

class RiskNodeController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('RiskNodeModel');
	}

	/*
	 * login api
	 */

	public function index()
	{
		$this->load->view("patient/riskNode", array("title" => 'RiskNode'));
	}
	public function loadTreeNodes()
	{
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$hospital_room_table = $this->session->user_session->hospital_room_table;


			$tree = array();
			$selectedNode=1;
			$status=true;
			$resultObject=$this->RiskNodeModel->getPatientData($patient_table,$hospital_bed_table,$hospital_room_table);
				if($resultObject->totalCount>0)
				{


				
				$ageArray=array(
					array("seq"=>1,
						  "type"=>2,
						  "name"=>'Age 0-10'),
					array("seq"=>2,
						 "type"=>2,
						  "name"=>'Age 11-20'),
					array("seq"=>3,
						 "type"=>2,
						  "name"=>'Age 21-40'),
					array("seq"=>4,
						 "type"=>2,
						  "name"=>'Age 41-60'),
					array("seq"=>5,
						 "type"=>2,
						  "name"=>'Age 60+')
				);

				$genderArray=array(
					array("seq"=>1,
						 "type"=>3,
						  "name"=>'Male'),
					array("seq"=>2,
						 "type"=>3,
						  "name"=>'Female')
				);
				$riskArray=array(
					array("seq"=>1,
						 "type"=>4,
						 "status"=>5,
						  "name"=>'Extreme Risk'),
					array("seq"=>2,
						 "type"=>4,
						  "status"=>4,
						  "name"=>'Extreme High Risk'),
					array("seq"=>3,
						 "type"=>4,
						  "status"=>3,
						  "name"=>'High Risk'),
					array("seq"=>4,
						 "type"=>4,
						  "status"=>2,
						  "name"=>'Medium Risk'),
					array("seq"=>5,
						 "type"=>4,
						  "status"=>1,
						  "name"=>'Low Risk')
				);

				$mainArray=array(
							array(
							"seq"=>1,
							"type"=>1,
							"status"=>0,
						  	"color"=>"",
							"name"=>'NSCI'
							),
							array(
							"seq"=>2,
							"type"=>1,
							"status"=>1,
						  	"color"=>"lightgreen",
							"name"=>'DOME'),
							array(
							"seq"=>3,
							"type"=>1,
							"status"=>3,
						  	"color"=>"lightred",
							"name"=>'ICU'));
		

				$details=array();
				
				
				$count=0;
				$k=1;
				foreach ($mainArray as $key => $value) {
					$newNode = new stdClass();
					$newNode->description = $value['name'];

					$data_count1=$this->getDataRecursiveArrayLayer($resultObject->data,$value['type'],$value['seq']);
					// print_r($data_count1['type']);exit();
					;
					$resultObject_data1="";
					if(!empty($data_count1))
					{
						if($value['type']==$data_count1['type'] && $value['seq']==$data_count1['seq'])
						{
							if(count($data_count1['ids'])==0){$newNode->name ="0";}else{$newNode->name = count($data_count1['ids']);}//count
								$newNode->patient_array=$data_count1['ids'];
								$resultObject_data1=$data_count1['data'];
						}
					}
				
					$newNode->id = $k;
					$newNode->type = $value['type'];
					$newNode->status = $value['status'];
					$newNode->color = $value['color'];
					
					if($value['seq']!==1)
					{
						
						$k3=31;
						$nodeChildRiskArray=array();

						foreach ($riskArray as $key => $riskvalue) {

							$newNoderisk= new stdClass();
							$newNoderisk->description = $riskvalue['name'];
							$resultObject_data2="";
							if($resultObject_data1!="")
								{
									$data_count2=$this->getDataRecursiveArrayLayer($resultObject_data1,$riskvalue['type'],$riskvalue['seq']);

									if(!empty($data_count2))
									{
										if($riskvalue['type']==$data_count2['type'] && $riskvalue['seq']==$data_count2['seq'])
										{
											if(count($data_count2['ids'])==0){$newNoderisk->name ="0";}else{$newNoderisk->name = count($data_count2['ids']);}//count
												$newNoderisk->patient_array=$data_count2['ids'];
												$resultObject_data2=$data_count2['data'];
										}
									}
								}
							$newNoderisk->id = $k3;
							$newNoderisk->type = $riskvalue['type'];
							$newNoderisk->status = $riskvalue['status'];
							//

							

						$k1=11;
						$nodeChildArray=array();
						foreach ($ageArray as $agevalue) {
							

							$newNodeAge = new stdClass();
							$newNodeAge->description = $agevalue['name'];
							$resultObject_data3="";
							if($resultObject_data2!="")
								{
									$data_count3=$this->getDataRecursiveArrayLayer($resultObject_data2,$agevalue['type'],$agevalue['seq']);

									if(!empty($data_count3))
									{
										if($agevalue['type']==$data_count3['type'] && $agevalue['seq']==$data_count3['seq'])
										{
											if(count($data_count3['ids'])==0){$newNodeAge->name ="0";}else{$newNodeAge->name = count($data_count3['ids']);}//count
												$newNodeAge->patient_array=$data_count3['ids'];
												$resultObject_data3=$data_count3['data'];
										}
									}
								}
								// print_r(count($newNodeAge->patient_array));exit();
							$newNodeAge->id = $k1;
							$newNodeAge->type = $agevalue['type'];
							$nodeChildGenderArray=array();
							$k2=21;
							foreach ($genderArray as $gendervalue) {
								$newNodegender = new stdClass();
								$newNodegender->description = $gendervalue['name'];
								$resultObject_data4="";
								if($resultObject_data3!="")
								{
									$data_count4=$this->getDataRecursiveArrayLayer($resultObject_data3,$gendervalue['type'],$gendervalue['seq']);

									if(!empty($data_count4))
									{
										if($gendervalue['type']==$data_count4['type'] && $gendervalue['seq']==$data_count4['seq'])
										{
											if(count($data_count4['ids'])==0){$newNodegender->name ="0";}else{$newNodegender->name = count($data_count4['ids']);}//count
												$newNodegender->patient_array=$data_count4['ids'];
												$resultObject_data4=$data_count4['data'];
										}
									}
								}
								$newNodegender->id = $k2;
								$newNodegender->type = $gendervalue['type'];

								
								
								$newNodegender->children =array();
								array_push($nodeChildGenderArray, $newNodegender);
								$k2++;
							}
							$newNodeAge->children =$nodeChildGenderArray;
							array_push($nodeChildArray, $newNodeAge);
							
							$k1++;

						}
						 $newNoderisk->children =$nodeChildArray;
						array_push($nodeChildRiskArray, $newNoderisk);

							$k3++;
						}
						$newNode->children = $nodeChildRiskArray;
						
					}
					else
					{
						$newNode->children = array();
					}
					
					array_push($tree, $newNode);
					$k++;
				}
			

				$response["status"] = 200;
				$response['data'] = $tree;
				$response["selected"] = $selectedNode;
				$response["type"] = 1;

			} else {
				$response["status"] = 201;
				$response["body"] = $tree;
			}

		
		echo json_encode($response);
	}

	public function getRiskExcelReport()
	{
		$data=$this->input->post_get('data');
		
		$object = json_decode($data);
		// print_r($object->ids);exit();
		if (count($object->ids)>1) {
			$ids=implode(',', $object->ids);
		}
		else if(count($object->ids)==1)
		{
			$ids=$object->ids[0];
		}
		else
		{
			$ids=$object->ids;
		}
		$patient_table = $this->session->user_session->patient_table;
		$data=$this->RiskNodeModel->getPatientData2($patient_table,$ids);
		// print_r($this->db->last_query());exit();
		if($data->totalCount>0)
		{
			$this->createRiskExcel($data->data,0);
		}
		else
		{
			echo json_encode(array("body"=>"No data found","status"=>200));
		}
	}
		public function createRiskExcel($data,$type)
	{
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("Risk Report");
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Patinet Adhar');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Gender');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Patient Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Patient Age');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Patient Risk');
		$rowCount = 2;
		$k = 1;
		foreach ($data as $row) {
			if($row->gender==1){$gender="Male";}else if($row->gender==2){$gender="Female";}else if($row->gender==null){$gender="";}else{$gender="Other";}
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->adhar_no);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->patient_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $gender);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->id);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->age);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, "");

				$rowCount++;
				$k++;
			}
		ob_end_clean();
		$filename = "PatientRiskReport" . date("Y-m-d") . "_" . time() . ".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function getDataRecursiveArrayLayer($resultData,$type,$seq)
	{

		$mainDataAarray=array();
		$dataArray=array();
		$idArray=array();
				foreach ($resultData as $value) {
					if($type==1)
					{
						if($seq==1)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						} else 
						if($seq==2)
						{
							if($value->category==1)
							{
								array_push($dataArray, $value);
								array_push($idArray, $value->id);
							}
						}
						else if($seq==3)
						{
							if($value->category==2)
							{
								array_push($dataArray, $value);
								array_push($idArray, $value->id);
							}
						}
					}
					else if($type==4)
					{
						if($seq==1)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						}
						else if($seq==2)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						}
						else if($seq==3)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						}
						else if($seq==4)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						}
						else if($seq==5)
						{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
						}
					}
					else if($type==2)
					{
						if($seq==1)
						{
							if($value->age>=0 && $value->age<=10)
							{	
								array_push($dataArray, $value);
								array_push($idArray, $value->id);
							}
						}
						else if($seq==2)
						{
							if($value->age>=11 && $value->age<=20)
							{	
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
							}
						}
						else if($seq==3)
						{
							if($value->age>=21 && $value->age<=40)
							{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
							}
						}
						else if($seq==4)
						{
							if($value->age>=41 && $value->age<=60)
							{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
							}
						}
						else if($seq==5)
						{
							if($value->age>60)
							{
							array_push($dataArray, $value);
							array_push($idArray, $value->id);
							}
						}
					}
					else if($type==3)
					{
						if($seq==1)
						{
							if($value->gender==1)
							{
								array_push($dataArray, $value);
								array_push($idArray, $value->id);
							}
						}
						else if($seq==2)
						{
							if($value->gender==2)
							{
								array_push($dataArray, $value);
								array_push($idArray, $value->id);
							}
						}
					}
					
				}
				$mainDataAarray=array('type'=>$type,'seq'=>$seq,'ids'=>$idArray,'data'=>$dataArray);
			return $mainDataAarray;
		
	}

}