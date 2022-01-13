<?php
require_once 'HexaController.php';

/**
 * @property  LabReport LabReport
 */
class CriticalCareController extends HexaController
{


	/**
	 * Report constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('LabReport');
		$this->load->helper(array('url','html','form'));
	}

	public function index()
	{
		$this->load->view('criticalCare/criticalCare', array("title" => "Critical Care"));
	}
	public function get_Hr_chart() 
	{
 		$labelArray = array();
		$dataArray = array();
		$transArray = array();
      	$dayQuery =  $this->db->query("SELECT * FROM patientreport_table order by created_at"); 
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
 		}
     echo json_encode($response);
 
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
 		$labelArray = array();
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
     echo json_encode($response);
 
    }

    public function get_VitalSigns()
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
		$lactate="";
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			
			foreach($result as $row){
				$min_range=$row->min_range;
				$max_range=$row->max_range;
				$para_name=$row->para_name;
				$word="Lactate";
				if(strpos($para_name, $word) !== false){
					// echo 'true';
				$style="";
				// print_r($patient_id);exit;
				$q1=$this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row->para_id' order by id desc");
					if($this->db->affected_rows()>0){
						$r1=$q1->row();
						$result_a=$r1->result;
						if($result_a=="" && $result_a==null)
						{
							$result_a=0;
						}
						
					}
					else
					{
						$result_a=0;
					}
					if (($result_a >= $min_range && $result_a <= $max_range)){
							
							$style.="color:green";
							
						}else{
							$style.="color:red";
							
						}
						$lactate.='<span style="'.$style.'">'.$result_a.'</span>';
				}
			}
				
			
			$response["status"] = 200;
 			$response["body"] = "data fetch";
 			$response["lactate"] = $lactate;
		}else{
			$response["status"] = 201;
 			$response["body"] = "Something went wrong";
	}
	echo json_encode($response);
	}




}
