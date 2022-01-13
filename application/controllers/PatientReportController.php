<?php
require_once 'HexaController.php';

/**
 * @property  LabReport LabReport
 */
class PatientReportController extends HexaController
{


	/**
	 * Report constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('LabReport');
		$this->load->helper(array('url','html','form'));
		 $this->db2 = $this->load->database('live', TRUE);
	}

	public function index()
	{
		$this->load->view('patientReport/patient_report', array("title" => "Patient Report"));
	}
	function create_time_range($start, $end, $interval = '30 mins', $format = '24') {
    $startTime = strtotime($start); 
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12')?'g:i:s A':'G:i:s';

    $current   = time(); 
    $addTime   = strtotime('+'.$interval, $current); 
    $diff      = $addTime - $current;

    $times = array(); 
    while ($startTime < $endTime) { 
        $times[] = date($returnTimeFormat, $startTime); 
        $startTime += $diff; 
    } 
    $times[] = date($returnTimeFormat, $startTime); 
    return $times; 
}
	public function get_Hr_chart() 
	{
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$patient_id=$this->input->post('patient_id');
		$get_bed_id=$this->db->query("select bed_id from ".$table_name." where id='$patient_id' ");
		$labelArray = array();
		$dataArray = array();
		$transArray = array();
		if($this->db->affected_rows() > 0){
			$result=$get_bed_id->row();
			$bed_id=$result->bed_id;
			date_default_timezone_set('Asia/Calcutta');
			 $date_time_current=date('Y-m-d H:i');
			$two_hours_back= date('Y-m-d H:i',strtotime('-60 minutes',strtotime($date_time_current)));
			$two_hours_forward= date('Y-m-d H:i',strtotime('+60 minutes',strtotime($date_time_current)));
		
		
			$query2=$this->db2->query("select * from patient_monitor_data where patient_id='$bed_id' AND p_datetime >= '$two_hours_back' AND p_datetime <= '$two_hours_forward' AND HR_BPM between 5 AND 250  ");
			
			if($this->db2->affected_rows() > 0){
				$res=$query2->result();
				//$HR_BPM=$res->HR_BPM;
				foreach($res as $r1){
					 date('H:i:s', strtotime($r1->p_datetime));
					
				array_push($labelArray, date('H:i:s', strtotime($r1->p_datetime)));
				array_push($dataArray, $r1->HR_BPM);
				array_push($transArray, date('H:i:s', strtotime($r1->p_datetime)));
				}
				
				/*  $times = $this->create_time_range($date_time_current,$two_hours_forward, '3 mins');
				for($i=0;$i<count($times);$i++)
				{
				
				array_push($labelArray, $times[$i]);
				
				}  */
				
				
				
			}
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
		} echo json_encode($response);
 		
      	/* $dayQuery =  $this->db->query("SELECT * FROM patientreport_table order by created_at"); 
		
 		if($this->db->affected_rows()>0)
 		{
 			$resultObject=$dayQuery->result();
 			foreach ($resultObject as $key => $column) {

 				array_push($labelArray, date('H:i:s', strtotime($column->created_at)));
 				// $labelArray[date('H', strtotime($column->created_at))][$key]=date('H:i:s', strtotime($column->created_at));
 				// print_r($labelArray);exit();
 				array_push($dataArray, $column->hr);
 				// $dataArray[date('H:i:s', strtotime($column->created_at))][$key] = $column->email;
 				array_push($transArray, date('H:i:s', strtotime($column->created_at)));
 			}
 			// print_r($labelArray);exit();
 			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
 		}
 		else
 		{
 			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
 		} */
    
 
    }
	public function get_Rr_chart() 
	{
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$patient_id=$this->input->post('patient_id');
		$get_bed_id=$this->db->query("select bed_id from ".$table_name." where id='$patient_id' ");
		$labelArray = array();
		$dataArray = array();
		$transArray = array();
		if($this->db->affected_rows() > 0){
			$result=$get_bed_id->row();
			$bed_id=$result->bed_id;
			date_default_timezone_set('Asia/Calcutta');
			 $date_time_current=date('Y-m-d H:i');
			$two_hours_back= date('Y-m-d H:i',strtotime('-60 minutes',strtotime($date_time_current)));
			$two_hours_forward= date('Y-m-d H:i',strtotime('+60 minutes',strtotime($date_time_current)));
		
		
			$query2=$this->db2->query("select * from patient_monitor_data where patient_id='$bed_id' AND p_datetime >= '$two_hours_back' AND p_datetime <= '$two_hours_forward'  AND RR_RPM between 5 AND 250 ");
			
			if($this->db2->affected_rows() > 0){
				$res=$query2->result();
				//$HR_BPM=$res->HR_BPM;
				foreach($res as $r1){
					 date('H:i:s', strtotime($r1->p_datetime));
					
				array_push($labelArray, date('H:i:s', strtotime($r1->p_datetime)));
				array_push($dataArray, $r1->RR_RPM);
				array_push($transArray, date('H:i:s', strtotime($r1->p_datetime)));
				}
				
				/*  $times = $this->create_time_range($date_time_current,$two_hours_forward, '3 mins');
				for($i=0;$i<count($times);$i++)
				{
				
				array_push($labelArray, $times[$i]);
				
				}  */
				
				
				
			}
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
	} echo json_encode($response);
	}
	public function get_nibp_chart() 
	{
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$patient_id=$this->input->post('patient_id');
		$get_bed_id=$this->db->query("select bed_id from ".$table_name." where id='$patient_id' ");
		$labelArray = array();
		$dataArray = array();
		$transArray = array();
		if($this->db->affected_rows() > 0){
			$result=$get_bed_id->row();
			$bed_id=$result->bed_id;
			date_default_timezone_set('Asia/Calcutta');
			 $date_time_current=date('Y-m-d H:i');
			$two_hours_back= date('Y-m-d H:i',strtotime('-60 minutes',strtotime($date_time_current)));
			$two_hours_forward= date('Y-m-d H:i',strtotime('+60 minutes',strtotime($date_time_current)));
		
		
			$query2=$this->db2->query("select * from patient_monitor_data where patient_id='$bed_id' AND p_datetime >= '$two_hours_back' AND p_datetime <= '$two_hours_forward'  AND NIBP between 5 AND 250 ");
			
			if($this->db2->affected_rows() > 0){
				$res=$query2->result();
				//$HR_BPM=$res->HR_BPM;
				foreach($res as $r1){
					 date('H:i:s', strtotime($r1->p_datetime));
					
				array_push($labelArray, date('H:i:s', strtotime($r1->p_datetime)));
				array_push($dataArray, $r1->NIBP);
				array_push($transArray, date('H:i:s', strtotime($r1->p_datetime)));
				}
				
				/*  $times = $this->create_time_range($date_time_current,$two_hours_forward, '3 mins');
				for($i=0;$i<count($times);$i++)
				{
				
				array_push($labelArray, $times[$i]);
				
				}  */
				
				
				
			}
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
	} echo json_encode($response);
	}

    public function get_SBP_MAP_chart()
    {
    	$labelArray = array();
		$dataArray1 = array();
		$dataArray2 = array();
		$transArray = array();
      	$dayQuery =  $this->db->query("SELECT * FROM patientreport_table"); 
 		if($this->db->affected_rows()>0)
 		{
 			$resultObject=$dayQuery->result();
 			foreach ($resultObject as $key => $column) {

 				array_push($labelArray, date('H:i:s', strtotime($column->created_at)));
 				// $labelArray[date('H:i', strtotime($column->created_at))][$key]=date('H:i:s', strtotime($column->created_at))
 				array_push($dataArray1, $column->sbp);
 				array_push($dataArray2, $column->map);
 				// $dataArray[date('H:i:s', strtotime($column->created_at))][$key] = $column->email;
 				array_push($transArray, date('H:i:s', strtotime($column->created_at)));
 			}
 			
 			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["SBP"] = $dataArray1;
			$response["MAP"] = $dataArray2;
 		}
 		else
 		{
 			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
 		}
     echo json_encode($response);
    }

    public function get_SPO2_chart() 
	{
		
		
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$patient_id=$this->input->post('patient_id');
		$get_bed_id=$this->db->query("select bed_id from ".$table_name." where id='$patient_id' ");
		$labelArray = array();
		$dataArray = array();
		$transArray = array();
		if($this->db->affected_rows() > 0){
			$result=$get_bed_id->row();
			$bed_id=$result->bed_id;
			date_default_timezone_set('Asia/Calcutta');
			 $date_time_current=date('Y-m-d H:i');
			$two_hours_back= date('Y-m-d H:i',strtotime('-2 hour',strtotime($date_time_current)));
		
		
			$query2=$this->db2->query("select * from patient_monitor_data where patient_id='$bed_id' AND p_datetime >= '$two_hours_back' AND p_datetime <= '$date_time_current' AND SPO2 between 5 AND 250 ");
			
			if($this->db2->affected_rows() > 0){
				$res=$query2->result();
				//$HR_BPM=$res->HR_BPM;
				foreach($res as $r1){
				array_push($labelArray, date('H:i:s', strtotime($r1->p_datetime)));
				array_push($dataArray, $r1->SPO2);
				array_push($transArray, date('H:i:s', strtotime($r1->p_datetime)));
				}
				
			}
			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
		} echo json_encode($response);
 	/* 	$labelArray = array();
		$dataArray = array();
		$transArray = array();
      	$dayQuery =  $this->db->query("SELECT * FROM patientreport_table"); 
 		if($this->db->affected_rows()>0)
 		{
 			$resultObject=$dayQuery->result();
 			foreach ($resultObject as $key => $column) {

 				array_push($labelArray, date('H:i:s', strtotime($column->created_at)));
 				// $labelArray[date('H:i', strtotime($column->created_at))][$key]=date('H:i:s', strtotime($column->created_at))
 				array_push($dataArray, $column->spo2);
 				// $dataArray[date('H:i:s', strtotime($column->created_at))][$key] = $column->email;
 				array_push($transArray, date('H:i:s', strtotime($column->created_at)));
 			}
 			
 			$response["status"] = 200;
 			$response["body"] = "data fetch";
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
 		}
 		else
 		{
 			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
 		}
     echo json_encode($response); */
 
    }
	
    public function get_VitalSigns1()
    {
    	$patient_id=$this->input->post('patient_id');
    	$branch_id=$this->session->user_session->branch_id;
		$company_id=$this->session->user_session->company_id;
		$query=$this->db->query("select * from icu_patient_para where branch_id='$branch_id' AND company_id='$company_id'");
		$data="";
		$HR="";
		$CVP="";
		$BP="";
		$RR="";
		$SPO2="";
		$TC="";
		$TM="";
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			foreach($result as $row){
				$min_range=$row->min_value;
				$max_range=$row->max_value;
				$para_id=$row->temp_id;

				//get para name
				$para_name="";
				$qq=$this->db->query("select name from template_master where id='$para_id'")->row();

				if($this->db->affected_rows()>0){
					$para_name=$qq->name;
				}
				$table_name=$row->table_name;
				$column_name=$row->column_name;
				$q1=$this->db->query("select ".$column_name." from ".$table_name." where
					patient_id='$patient_id'  AND branch_id='$branch_id' order by id desc");

				if($this->db->affected_rows()>0){
						$r1=$q1->row();
						
						$result_a=$r1->$column_name;
						if($result_a=="" && $result_a==null)
						{
							$result_a=0;
						}
					}
					else
					{
						$result_a=0;
					}
						if($row->filed_name=="HR")
							{
								$style="";
							if (($result_a >= $min_range && $result_a <= $max_range)){
								
								$style.="color:orange";
								
							}else{
								$style .='color:red';
								
							}
							$HR.='<span style="'.$style.'">'.$result_a.'</span>(<span style="color:orange">'.$min_range.'-'.$max_range.'</span>)';

						}
						if($row->filed_name=="BP")
						{
							$style="";
							if (($result_a >= $min_range && $result_a <= $max_range)){
								
								$style.="color:blue";
								
							}else{
								$style .='color:red';
								
							}
							$BP.='<span style="color:blue">'.$min_range.'/'.$max_range.'</span> (<span style="'.$style.'">'.$result_a.'</span>)';
						}
						if($row->filed_name=="RR")
						{
							$style="";
							if (($result_a >= $min_range && $result_a <= $max_range)){
								
								$style.="color:green";
								
							}else{
								$style .='color:red';
								
							}
							$RR.='<span style="'.$style.'">'.$result_a.'</span>';
						}
						if($row->filed_name=="SPO2")
						{
							$style="";
							if (($result_a >= $min_range && $result_a <= $max_range)){
								
								$style.="color:lightgreen";
								
							}else{
								$style .='color:red';
								
							}
							$SPO2.='<span style="'.$style.'">'.$result_a.'%</span>';
						}
						if($row->filed_name=="temperature")
						{
							$style="";
							if (($result_a >= $min_range && $result_a <= $max_range)){
								
								$style.="color:lightgreen";
								
							}else{
								$style .='color:red';
								
							}
							$TM.='<span style="'.$style.'">'.$result_a.' oF</span>';
						}



					

				
				
			}
			
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
 			$response["HR"] = $HR;
 			$response["BP"] = $BP;
 			$response["RR"] = $RR;
 			$response["SPO2"] = $SPO2;
 			$response["TM"] = $TM;

		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
    }

    public function get_excelSigns(){
    	$id=$this->input->post('patient_id');
		 $patient_id='N'.str_pad($id,'9','0',STR_PAD_LEFT);
		$query=$this->db->query("select * from labparameter_table");
		$branch_id=$this->session->user_session->branch_id;
		$lactate="";
		$lactate_date="";
		$glucose="";
		$glucose_date="";
		$BloodGas="";
		$BloodGas_date="";
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			
			foreach($result as $row){
				$min_range=$row->min_range;
				$max_range=$row->max_range;
				$para_name=$row->para_name;
				$q1=$this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row->para_id' AND branch_id='$branch_id' order by id desc");
				$r1=$q1->row();

				$lactate_word="Lactate";
				$glucose_word="Glucose";
				$bicarbonate_word="Bicarbonate";
				if(strpos($para_name, $lactate_word) !== false){
				$style="";
					if($r1!=""){
						
						$result_a=$r1->result;
						$lactate_date=$r1->VisitDate;
						if($result_a=="" && $result_a==null)
						{
							$result_a=0;

						}
						if (($result_a >= $min_range && $result_a <= $max_range)){
							
							$style.="color:green";
							
						}else{
							$style.="color:red";
							
						}
						$lactate.='<span style="'.$style.'">'.$result_a.'('.$min_range.'-'.$max_range.')</span>';
						
					}
					
				}
				if(strpos($para_name, $glucose_word) !== false){
				$style="";
					if($r1!=""){
						
						$result_a=$r1->result;
						$glucose_date=$r1->VisitDate;
						if($result_a=="" && $result_a==null)
						{
							$result_a=0;
						}
						if (($result_a >= $min_range && $result_a <= $max_range)){
							
							$style.="color:green";
							
						}else{
							$style.="color:red";
							
						}
						$glucose.='<span style="'.$style.'">'.$result_a.'('.$min_range.'-'.$max_range.')</span>';
						}
						
					}
					if(strpos($para_name, $bicarbonate_word) !== false){
				$style="";
					if($r1!=""){
						
						$result_a=$r1->result;
						$BloodGas_date=$r1->VisitDate;
						if($result_a=="" && $result_a==null)
						{
							$result_a=0;
						}
						if (($result_a >= $min_range && $result_a <= $max_range)){
							
							$style.="color:green";
							
						}else{
							$style.="color:red";
							
						}
						$BloodGas.='<span style="'.$style.'">bicarbonate:'.$result_a.'('.$min_range.'-'.$max_range.')</span>';
						}
						
					}
					
			}
				
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
 			$response["lactate"] = $lactate;
 			$response["lactate_date"] = $lactate_date;
 			$response["glucose"] = $glucose;
 			$response["glucose_date"] = $glucose_date;
 			$response["BloodGas"] = $BloodGas;
 			$response["BloodGas_date"] = $BloodGas_date;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
	}
	echo json_encode($response);
	}

public function get_VitalSigns(){
		$patient_id=$this->input->post('patient_id');
    	$branch_id=$this->session->user_session->branch_id;
		$company_id=$this->session->user_session->company_id;
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$get_bed_id=$this->db->query("select bed_id from ".$table_name." where id='$patient_id' ");
		
		$HR_BPM="";
		$RR_RPM="";
		$SPO2="";
		$NIBP="";
		$TEMP="";
		$TM="";
		$BP="";
		if($this->db->affected_rows() > 0){
			$result=$get_bed_id->row();
			$bed_id=$result->bed_id;
			$query2=$this->db2->query("select * from patient_monitor_live_data where patient_id='$bed_id'");
			if($this->db2->affected_rows() > 0){
				$res=$query2->row();
				$HR_BPM=$res->HR_BPM."(60-100)";
				$RR_RPM=$res->RR_RPM;
				$SPO2=$res->SPO2."(80-100)";
				$NIBP=$res->NIBP;
				$TEMP=$res->TEMP;
			}
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
 			$response["HR"] = $HR_BPM;
 			$response["BP"] = $NIBP;
 			$response["RR"] = $RR_RPM;
 			$response["SPO2"] = $SPO2;
 			$response["TM"] = $TM;
 			$response["NIBP"] = $NIBP;
 			$response["TEMP"] = $TEMP;

		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}
public function GetBundlesData(){
	$p_id=$this->input->post('patient_id');
	$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
	$branch_id=$this->session->user_session->branch_id;
	$query=$this->db->query("select Central_Line,Atrial_Lines,HD_Catheter,HD_Catheter ,
	Peripheral_Line,Drains,Urinary_Catheter,
	Endotracheal_Tube,IABP_catheter,Tracheostomy_tube,Ryles_tube,created_on ,
	Mode,Flo2,PEE,RATE,Tidal_Volume,Pressure_Support,RASS,
	(select admission_date from ".$table_name." where ".$table_name.".id=com_1_critical_care.patient_id) as admit_date
	from com_1_critical_care
	where patient_id='$p_id' and branch_id='$branch_id' order by id desc
	");
	$days=0;
	if($this->db->affected_rows() > 0)
	{
		$data=$query->row();
		$admit_date=$data->admit_date;
		$date=$data->created_on;
		$days=0;
	if($admit_date != "0000-00-00 00:00:00"){
		$datediff = strtotime($date) - strtotime($admit_date);
	$days=	round($datediff / (60 * 60 * 24));
	}
		$time=date('H:i', strtotime($data->created_on));
		// date('H:i:s', strtotime($r1->p_datetime))
	$response["status"] = 200;
	$response["data"] = $data;
	$response["days"] = $days;
	$response["time"] = $time;
	}else{
	$response["status"] = 201;
	$response["data"] = "";
	$response["time"] = "";
	$response["days"] = $days;
	}echo json_encode($response);
}

	public function get_sofaScore()
	{
		if(!is_null($this->input->post('patient_id')))
		{
			$p_id=$this->input->post('patient_id');
			$branch_id=$this->session->user_session->branch_id;
			$company_id=$this->session->user_session->company_id;
			$tableName="com_1_sofa_score";
			$sofa_score="";
			$date="";
			$resultObject=$this->db->query('select * from '.$tableName.' where patient_id='.$p_id.' and branch_id='.$branch_id.' and company_id='.$company_id.' order by id desc limit 1');
			if($this->db->affected_rows() > 0)
			{
				$result=$resultObject->row();

				$sofa_score=$result->sofa_score;
				$date=date('d/m H:i',strtotime($result->created_on));
			}
			else
			{
				$sofa_score="";
				$date="";
			}
			$response["status"] = 200;
			$response["sofa_score"] = $sofa_score;
			$response["sofa_date"] = $date;
		}
		else
		{
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}


	public function get_patientReportImage()
	{
		$p_id=$this->input->post('patient_id');
		$session_data = $this->session->user_session;
		$table_name = $session_data->patient_table;
		$branch_id=$this->session->user_session->branch_id;

		$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
		$patient_table = $this->session->user_session->patient_table;//hospital_patient_table
		$data="";
		$resultObject=$this->db->query("select pt.id,(select group_concat(cb1.bed_name,',',(case when cb1.camera_name is null then -1 else cb1.camera_name end))from ".$hospital_bed_table." cb1 where cb1.id=pt.bed_id) as bed_name from ".$patient_table." pt where pt.id=".$p_id." and pt.branch_id=".$branch_id."");

		if($this->db->affected_rows() > 0)
			{
				$result=$resultObject->row();

				$bed = explode(',', $result->bed_name);
				// print_r($bed);exit();
				if($bed!="" && count($bed)>1)
				{
					if((int)$bed[1] !== -1){
	                    $exxp1 = explode("|", $bed[1]);
	                    if(count($exxp1)>0){
	                        $c_name = trim($exxp1[0]) . trim($exxp1[1]);
	                    }
	                    $image="https://vs.docango.com/images/picture_".$c_name.".jpg";
	                }else{
	                    $c_name ="";
	                    $image="https://covidcare.docango.com/assets/img/not-available.jpg";

	                }
				}
				else{
					$c_name ="";
					$image="https://covidcare.docango.com/assets/img/not-available.jpg";
				}
				
				$data.='<div data-toggle="modal" data-target="#largeVideo" data-camera="'.$c_name.'"  >
									<img src="'.$image.'" id="L_' . $c_name . '" class="p-1"style="width: 100%;height:210px;border:2px  black" alt="No Video Available" />';
				$response["status"] = 200;
				$response["data"] = $data;
			}
			else
			{
				$response["status"] = 201;
				$response["data"] = $data;
			}
			echo json_encode($response);
	}

	public function get_HEME_data()
	{
		if(!is_null($this->input->post('patient_id')))
		{
			$id=$this->input->post('patient_id');
			$branch_id=$this->session->user_session->branch_id;
			$company_id=$this->session->user_session->company_id;
			$patient_table = $this->session->user_session->patient_table;//hospital_patient_table
			$patient_id='N'.str_pad($id,'9','0',STR_PAD_LEFT);
			// $resultObject=$this->db->query("select * from excel_structure_data where Patient_number='".$patient_id."' and branch_id=".$branch_id." and 
			// 	(ParameterName='Neutrophils' or ParameterName='Lymphocytes' or ParameterName='Monocytes' 
			// 	or ParameterName='Eosinophils' or ParameterName='Basophils' or ParameterName='Haemoglobin' 
			// 	or ParameterName='Platelet Count' or ParameterName='Chloride' or ParameterName='Potassium'
			// 	 or ParameterName='Sodium' or ParameterName='Bicarbonate' or ParameterName='Calcium')");
			$Neutrophils_data="";
			$Lymphocytes_data="";
			$Monocytes_data="";
			$Eosinophils_data="";
			$Basophils_data="";
			$Haemoglobin_data="";
			$Platelet_Count_data="";
			$Chloride_data="";
			$Potassium_data="";
			$Sodium_data="";
			$Bicarbonate_data="";
			$Calcium_data="";

			$last_visit="";

			$Neutrophils=7148;
			$Lymphocytes=7106;
			$Monocytes=7136;
			$Eosinophils=6926;
			$Basophils=9360;
			$Haemoglobin=9344;
			$Platelet_Count=9362;
			$Chloride=6826;
			$Potassium=7199;
			$Sodium=7353;
			$Bicarbonate=6790;
			$Calcium=6804;
			$resultObject=$this->db->query("select *,(select pt.gender from ".$patient_table." pt where pt.id=915) as gender from excel_structure_data where Patient_number='".$patient_id."' and branch_id=".$branch_id." and 
				ParameterId in (".$Neutrophils.",".$Lymphocytes.",".$Monocytes.",".$Eosinophils.",".$Basophils.",".$Haemoglobin.",".$Platelet_Count.",".$Chloride.",".$Potassium.",".$Sodium.",".$Bicarbonate.",".$Calcium.")");
			
			if($this->db->affected_rows() > 0)
			{
				$result=$resultObject->result();
				// print_r($result);exit();
				foreach ($result as $row) {
					$last_visit=$row->VisitDate;
					if($row->ParameterId==$Neutrophils)//Neutrophils
					{ 
						$Neutrophils_data=$this->getHEMEDesign($row->result,$row->gender,40,60,40,60);//getHEMEDesign(result,gender,male min range,male max range,female min range,female max range)
						
					}
					if($row->ParameterId==$Lymphocytes)//Lymphocytes
					{ 
						$Lymphocytes_data=$this->getHEMEDesign($row->result,$row->gender,20,40,20,40);
						
					}
					if($row->ParameterId==$Monocytes)//Monocytes
					{ 
						$Monocytes_data=$this->getHEMEDesign($row->result,$row->gender,2,10,2,10);
						
					}
					if($row->ParameterId==$Eosinophils)//Eosinophils
					{ 
						$Eosinophils_data=$this->getHEMEDesign($row->result,$row->gender,01,06,01,06);
						
					}
					if($row->ParameterId==$Basophils)//Basophils
					{ 
						$Basophils_data=$this->getHEMEDesign($row->result,$row->gender,0,02,0,02);
						
					}
					if($row->ParameterId==$Haemoglobin)//Haemoglobin
					{ 
						$Haemoglobin_data=$this->getHEMEDesign($row->result,$row->gender,14,18,12,16);
						
					}
					if($row->ParameterId==$Platelet_Count)//Platelet Count
					{ 
						$Platelet_Count_data=$this->getHEMEDesign($row->result,$row->gender,100,450,100,450);
						
					}
					if($row->ParameterId==$Chloride)//Chloride
					{ 
						$Chloride_data=$this->getHEMEDesign($row->result,$row->gender,98,107,98,107);
						
					}
					if($row->ParameterId==$Potassium)//Potassium
					{ 
						$Potassium_data=$this->getHEMEDesign($row->result,$row->gender,3.5,5.1,3.5,5.1);
						
					}
					if($row->ParameterId==$Sodium)//Sodium
					{ 
						$Sodium_data=$this->getHEMEDesign($row->result,$row->gender,136,145,136,145);
						
					}
					if($row->ParameterId==$Bicarbonate)//Bicarbonate
					{ 
						$Bicarbonate_data=$this->getHEMEDesign($row->result,$row->gender,22,29,22,29);
						
					}
					if($row->ParameterId==$Calcium)//Calcium
					{ 
						$Calcium_data=$this->getHEMEDesign($row->result,$row->gender,7.6,10.4,7.6,10.4);
						
					}

				}

				$response["status"] = 200;
				$response["Neutrophils"] = $Neutrophils_data;
				$response["Lymphocytes"] = $Lymphocytes_data;
				$response["Monocytes"] = $Monocytes_data;
				$response["Eosinophils"] = $Eosinophils_data;
				$response["Basophils"] = $Basophils_data;
				$response["Platelet_Count"] = $Platelet_Count_data;
				$response["Haemoglobin"] = $Haemoglobin_data;

				$response["Chloride"] = $Chloride_data;
				$response["Potassium"] = $Potassium_data;
				$response["Sodium"] = $Sodium_data;
				$response["Bicarbonate"] = $Bicarbonate_data;
				$response["Calcium"] = $Calcium_data;
				
				$response["last_visit"] = $last_visit;
			}
			else
			{
				$response["status"] = 201;
				$response["Neutrophils"] = $Neutrophils_data;
				$response["Lymphocytes"] = $Lymphocytes_data;
				$response["Monocytes"] = $Monocytes_data;
				$response["Eosinophils"] = $Eosinophils_data;
				$response["Basophils"] = $Basophils_data;
				$response["Platelet_Count"] = $Platelet_Count_data;
				$response["Haemoglobin"] = $Haemoglobin_data;

				$response["Chloride"] = $Chloride_data;
				$response["Potassium"] = $Potassium_data;
				$response["Sodium"] = $Sodium_data;
				$response["Bicarbonate"] = $Bicarbonate_data;
				$response["Calcium"] = $Calcium_data;
				$response["last_visit"] = $last_visit;
			}
			
		}
		else
			{
				$response["status"] = 201;
				$response["body"] = "Something went wrong";
			}
			echo json_encode($response);

	}

	public function getHEMEDesign($result_a,$gender,$m_min_range,$m_max_range,$f_min_range,$f_max_range)
	{
		$style="";
			if($gender==1) //male
			{
				$min_range=$m_min_range;
				$max_range=$m_max_range;
				if (($result_a >= $m_min_range && $result_a <= $m_max_range)){
					
					$style.="color:green";
					
				}else{
					$style .='color:red';
					
				}
			}
			else
			{
				$min_range=$f_min_range;
				$max_range=$f_max_range;
				if (($result_a >= $f_min_range && $result_a <= $f_max_range)){
					
					$style.="color:green";
					
				}else{
					$style .='color:red';
					
				}
			}
			$HR='<span style="'.$style.'">'.$result_a.'</span>(<span style="color:orange">'.$min_range.'-'.$max_range.'</span>)';
			return $HR;
	}

}
