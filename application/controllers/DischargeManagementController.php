<?php

require_once 'HexaController.php';
require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

/**
 * @property  User User
 */
class DischargeManagementController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('BillingModel');
		$this->load->model('Patient_Model');
	}

	/*
	 * login api
	 */

	public function index()
	{
		$this->load->view('Discharge/view_discharge', array("title" => "Discharge"));
	}

	public function discharge_report()
	{
		$this->load->view('Discharge/discharge_report', array("title" => "Discharge Report"));
	}

	public function getPatientData()
	{
		$p_id = $this->input->post('p_id');
		$tableName = $this->session->user_session->patient_table;
		$branch_id=$this->session->user_session->branch_id;
		$sql = "select *,(select location from branch_master b where b.id=t.branch_id) as Location from " . $tableName . " t where id=" . $p_id;
		$query = $this->db->query($sql);


		if ($this->db->affected_rows() > 0) {
			$get_case_history = $this->get_case_history($p_id);
			$get_vital_sign = $this->get_vital_sign($p_id);
			$result = $query->row();
			$response['status'] = 200;
			$response['data'] = $result;
			$response['case_history'] = $get_case_history;
			$response['vital_sign'] = $get_vital_sign;

		} else {
			$response['status'] = 201;
			$response['data'] = "";
			$response['case_history'] = "";
		}
		echo json_encode($response);
	}

	function get_case_history($p_id)
	{

		$case_history = "";
		$table_name = "";
		$department_id = 1;
		$query = $this->db->query("select tb_name from template_master where department_id='$department_id'");
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$table_name = $result->tb_name;
		}
		$symptoms = "-";
		$symptoms_onset = "-";
		$other_sympt = "-";
		$comorbidi = "-";
		$pregnancy = "-";
		$oxigen_support = "-";
		$vaccination = "-";
		$vaccination_date = "-";
		$current_medication = "-";
		$height = "-";
		$weight = "-";
		$branch_id=$this->session->user_session->branch_id;
		if ($table_name != "") {
			$sql = "select * from " . $table_name . " where patient_id='$p_id' AND branch_id='$branch_id' order by id DESC limit 1";
			$qry = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) {
				$res = $qry->result();
				foreach ($res as $row) {
					$symptoms =$this->getOptions($row->sec_1_f_1);

					$comorbidi =$this->getOptions($row->sec_1_f_8);

					$symptoms_onset = $row->sec_1_f_83;
					$other_sympt = $row->sec_1_f_3;

					$pregnancy = $this->getOptions($row->sec_1_f_9);
					$oxigen_support = $this->getOptions($row->sec_1_f_15);
					$vaccination = $this->getOptions($row->sec_1_f_16);
					$vaccination_date = $row->sec_1_f_17;
					$current_medication = $row->sec_1_f_2;
					$weight = $row->sec_1_f_13;
					$height = $row->sec_1_f_14;
				}
			}
		}
		$case_history .= "<div class='col-md-6' ><table class='table table-striped table-bordered'>
		
		<tbody>
		<tr>
		<td>Symptoms</td>
		<td>" . $symptoms . "</td>
		</tr>
		<tr>
		<td>Symptom Onset Date</td>
		<td>" . $symptoms_onset . "</td>
		</tr>
		<tr>
		<td>Other Symptoms</td>
		<td>" . $other_sympt . "</td>
		</tr>
		<tr>
		<td>Comorbidities</td>
		<td>" . $comorbidi . "</td>
		</tr>
		<tr>
		<td>Pregnancy</td>
		<td>" . $pregnancy . "</td>
		</tr>
		<tr>
		<td>Oxygen Support</td>
		<td>" . $oxigen_support . "</td>
		</tr>
		<tr>
		<td>Vaccination</td>
		<td>" . $vaccination . "</td>
		</tr>
		<tr>
		<td>Vaccination Date</td>
		<td>" . $vaccination_date . "</td>
		</tr>
		<tr>
		<td>Current Medication</td>
		<td>" . $current_medication . "</td>
		</tr>
		<tr>
		<td>Allergy</td>
		<td>-</td>
		</tr>
		</tbody>
		</table></div>";

		$bmi = '';
		if ($weight != "" and $height != "" && is_numeric($height) && is_numeric($weight)) {

			$heightInMs = $height / 100;
			$bmi = $weight / ($heightInMs * $heightInMs);
			$bmi = round($bmi, 2);
		}
		$case_history .= "<div class='col-md-6' ><table class='table table-striped table-bordered'>
		
		<tbody>
		<tr>
		<td>Height (cm)</td>
		<td>" . $height . "</td>
		</tr>
		<tr>
		<td>Weight (Kg)</td>
		<td>" . $weight . "</td>
		</tr>
		<tr>
		<td>BMI</td>
		<td>" . $bmi . "</td>
		</tr>
		</tbody>
		</table></div>
		";
		return $case_history;
	}

	function getOptions($columnValue){
		$valueObject= $this->db->query("select group_concat(name) as name from option_master where find_in_set(id,'".$columnValue."')")->result();
		$symptoms="";
		if(count($valueObject) >0){
			$symptoms .= $valueObject[0]->name;
		}else{
			$symptoms ="-";
		}
		return $symptoms;
	}
	function get_vital_sign($p_id)
	{
		$get_vital_sign = "";
		$table_name = "";
		$department_id = 2;
		$query = $this->db->query("select tb_name from template_master where department_id='$department_id'");
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$table_name = $result->tb_name;
		}
		$spo2 = "-";
		$temp = "-";
		$blood_sugar = "-";
		$ECG = "-";
		$BP_systolic = "-";
		$BP_dystolic = "-";
		$heart_rate = "-";
		$respitory_rate = "-";
		$Comment = "-";
		$branch_id=$this->session->user_session->branch_id;
		if ($table_name != "") {
			$sql = "select * from " . $table_name . " where patient_id='$p_id' AND branch_id='$branch_id' order by id DESC limit 1";
			$qry = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) {
				$res = $qry->result();
				foreach ($res as $row) {
					$spo2 = $row->sec_2_f_4;
					$temp = $row->sec_2_f_5;
					$blood_sugar = $row->sec_2_f_6;
					$ECG = $row->sec_2_f_7;
					$BP_systolic = $row->sec_2_f_18;
					$BP_dystolic = $row->sec_2_f_19;
					$heart_rate = $row->sec_2_f_20;
					$respitory_rate = $row->sec_2_f_21;
					$Comment = $row->sec_2_f_22;
				}
			}
		}

		$get_vital_sign .= "<table class='table table-striped table-bordered'>
		
		<tbody>
		<tr>
		<td>SpO2</td>
		<td>" . $spo2 . "</td>
		</tr>
		<tr>
		<td>Blood Sugar</td>
		<td>" . $blood_sugar . "</td>
		</tr>
		<tr>
		<td>BP Systolic</td>
		<td>" . $BP_systolic . "</td>
		</tr>
		<tr>
		<td>BP Dyastolic</td>
		<td>" . $BP_dystolic . "</td>
		</tr>
		<tr>
		<td>Heart Rate</td>
		<td>" . $heart_rate . "</td>
		</tr>
		<tr>
		<td>Respiratory Rate</td>
		<td>" . $respitory_rate . "</td>
		</tr>
		<tr>
		<td>Clinical Observations</td>
		<td>" . $Comment . "</td>
		</tr>
		<tr>
		<td>Observations on X Ray Report</td>
		<td>-</td>
		</tr>
		<tr>
		<td>Observations on CT Scan Report</td>
		<td>-</td>
		</tr>
		<tr>
		<td>Observations on Other Reports</td>
		<td>-</td>
		</tr>
		</tbody>
		</table>";
		return $get_vital_sign;
	}

	public function getpatientdatadis1(){
		$p_id=$this->input->post('p_id');
		$q2=$this->db->query("select tb_name,field_name from template_master where name='Current Medication' AND department_id='1'");
		$medication="";
		if($this->db->affected_rows()>0){
			$res=$q2->row();
			$table_name=$res->tb_name;
			$column_name=$res->field_name;
			$b_id=$this->session->user_session->branch_id;
			$sql="select ".$column_name." from ".$table_name." where patient_id='$p_id' AND branch_id='$b_id'";
			$qq=$this->db->query($sql);
			if($this->db->affected_rows() > 0){
				$ress=$qq->row();
				$medication=$ress->$column_name;
			}
		}
		$response['medication'] = $medication;
		$response["branch_id"]=$this->session->user_session->branch_id;
		$response["patient"]=$this->session->user_session->patient_table;
		$query = $this->Patient_Model->getpatientdata($p_id,$this->session->user_session->patient_table,$this->session->user_session->branch_id);
		$response["query"]=$this->db->last_query();
		if($this->db->affected_rows() >0){
			$admission_date=$query->admission_date;
			$response['status'] = 200;
			$response['data'] = $admission_date;
		}else{
			$admission_date="";
			$response['status'] = 201;
			$response['data'] = $admission_date;
		}echo json_encode($response);
	}
	public function getpatientdatadis(){
		$p_id=$this->input->post('p_id');
		$patient_table=$this->session->user_session->patient_table;
		$q2=$this->db->query('SELECT (select name from medicine_master m where m.id=c.name ) as med_name,total_iteration,
(case when (DATEDIFF(end_date,start_date)+1) is null then "Everyday"  else (DATEDIFF(end_date,start_date)+1) end) as itr FROM com_1_medicine c where active=1 and p_id='.$p_id.' and branch_id= '.$this->session->user_session->branch_id);
		$medication="";
		if($this->db->affected_rows()>0){
			$res=$q2->result();
			foreach ($res as $row){
				$str=$row->med_name."-".$row->total_iteration."/".$row->itr;
				$medication .=  $str.",";

			}
		}
		$q3=$this->db->query('select hospital_medication from '.$patient_table.' p where p.id='.$p_id)->row();
		if($this->db->affected_rows()>0){
			$patient_details=$q3->hospital_medication;
		}
		$response['medication'] = rtrim($medication,",");
		$response["branch_id"]=$this->session->user_session->branch_id;
		$response["patient_details"]=$patient_details;
		$response["patient"]=$this->session->user_session->patient_table;
		$query = $this->Patient_Model->getpatientdata($p_id,$this->session->user_session->patient_table,$this->session->user_session->branch_id);
		$response["query"]=$this->db->last_query();
		if($this->db->affected_rows() >0){
			$admission_date=$query->admission_date;
			$response['status'] = 200;
			$response['data'] = $admission_date;
		}else{
			$admission_date="";
			$response['status'] = 201;
			$response['data'] = $admission_date;
		}echo json_encode($response);
	}

	public function markasdischarge(){
		$p_id=$this->input->post('p_id');
		$id=$this->input->post('id');
		$table_name=$this->session->user_session->patient_table;
		$sql="update ".$table_name." SET mark_as_discharge = '$id' where id=".$p_id;
		$query=$this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$response['status'] = 200;
			if($id==1){
				$response['body'] = "Mark for discharge";
			}else{
				$response['body'] = "Removed from Mark for discharge";
			}
		}else{
			$response['status'] = 201;
			$response['body'] = "Something Went wrong";
		}echo json_encode($response);
	}

	public function checkmarkasdischarge(){
		$p_id=$this->input->post('p_id');
		$table_name=$this->session->user_session->patient_table;
		$sql="select * from ".$table_name." where id=".$p_id." AND mark_as_discharge=1";
		$query=$this->db->query($sql);
		if($this->db->affected_rows() > 0){
			$response['status'] = 200;
			//$response['body'] = "Mark for discharge";
		}else{
			$response['status'] = 201;
			//$response['body'] = "Something Went wrong";
		}echo json_encode($response);
	}

	public function downlod_report(){
		$p_id=$this->input->post_get('p_id');
		$tableName = $this->session->user_session->patient_table;
		$branch_id=$this->session->user_session->branch_id;
		$sql = "select * from " . $tableName . " where id=" . $p_id;
		$query = $this->db->query($sql);


		if ($this->db->affected_rows() > 0) {
			$get_case_history = $this->get_case_history($p_id);
			$get_vital_sign = $this->get_vital_sign($p_id);
			$result = $query->row();
			$html = '<!DOCTYPE html>';
			$html .= '<html lang="en" >';
			$html .= '<head>';

			$html .= '<style>    
	
        
    </style>';
			$html .= '<style>@page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }<style>';
			$html .= '</head>';
			$html .= '<body style="font-size: 11px;font-family: Arial, sans-serif;padding:0px 8px; ">';
			$html .='
			<div  align="center"><h2>Discharge Report(1/3)</h2></div>
			
			<div style="margin-left:5px">Name</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-6">
										<label class="font-weight-bold">Name : </label>
											'.$result->patient_name.'
								</div>
								<div class="col-xs-6">
										<label class="font-weight-bold">Patient ID :</label>
										'.$result->adhar_no.'
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 d-flex">
								<div class="col-md-6 text-left">
									<div class="">
										<label class="font-weight-bold">DOB </label>
										<span id="p_dob" class="m-1"></span>
									</div>
								</div>

								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Age</label>
										<span id="p_age" class="m-1"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 d-flex">
								<div class="col-md-6 text-left">
									<div class="">
										<label class="font-weight-bold">Case Type </label>
										<span id="p_case_type" class="m-1">: Covid Treatment</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Sex</label>
										<span id="p_sex" class="m-1"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 d-flex">
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Location </label>
										<span id="p_location" class="m-1">: NSCI, Worli, Mumbai</span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Case ID</label>
										<span id="p_caseid" class="m-1"></span>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="m-2"><h5>Stay</h5></div>
						<div class="row">
							<div class="col-md-12 d-flex">
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Admission date</label>
										<span id="p_admitdate" class="m-1"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Admission Time</label>
										<span id="p_admittime" class="m-1"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 d-flex">
								<div class="col-md-6">
									<div class="">
										<label class="font-weight-bold">Discharge Date </label>
										<span id="p_discharedate" class="m-1"> </span>
									</div>
								</div>
									<div class="col-md-6">
										<div class="">
											<label class="font-weight-bold">Discharge Time</label>
											<span id="p_dischargetime" class="m-1"></span>
										</div>
									</div>
								</div>

						</div>
							<hr>
							<div class="m-2"><h5>Case History - Initial Assessment</h5></div>
							<div class="row">
								<div class="col-md-12 d-flex" id="case_history">
								'.$get_case_history.'
								</div>
							</div>
							<hr>
							<div class="m-2" align="center"><h5>Discharge Report(2/3)</h5></div>
							<div class="m-2"><h5>Vital Signs</h5></div>
							<div class="row">
								<div class="col-md-12 d-flex">
									<div class="col-md-6" id="vital_sign_table">
									'.$get_vital_sign.'
									</div>
								</div>
							</div>
							<hr>
							<div class="m-2"><h5>Labratory Findings</h5></div>
							<span class="ml-2">Attached</span>
							<div class="m-2"><h5>Procedures</h5></div>
							<span class="ml-2">List of Clinical Procedures recommended by Doctor from Services Section</span>
							<hr>
							<div class="m-2" align="center"><h5>Discharge Report(3/3)</h5></div>
							<div class="m-2"><h5> Course during hospital stay</h5></div>
							<span id="significant_event" class="ml-2"></span>
							<div class="m-2"><h5>Condition at the Time of Discharge</h5></div>
							<span id="discharge_condition" class="ml-2"></span>
							<hr>
							<div class="m-2" align="center"><h5>Discharge Advice</h5></div>
							<div class="m-2"><h5>Medication</h5></div>
							<span id="medication" class="ml-2"></span>
							<div class="m-2"><h5>Physical Activity</h5></div>
							<span id="physical_activity" class="ml-2"></span>
							<div class="m-2"><h5>Followup</h5></div>
							<span id="followup" class="ml-2"></span>
							<div class="m-2"><h5>Urgent Care</h5></div>
							<span id="urgentcare" class="ml-2"></span>
							<hr>
							<div id="transfer_div"style="display:none">
							<div class="m-2"><h5>Transfer To</h5></div>
							<span id="transfer_to" class="ml-2"></span>
							<div class="m-2"><h5>Transfer Reason</h5></div>
							<span id="transfer_reason" class="ml-2"></span>
							</div>
			';
			$html .= '</body>';
			$html .= '</html>';
		}
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->set_option('isHtml5ParserEnabled', true);
			$dompdf->setPaper('A4');

			$dompdf->render();
			$dompdf->stream("Discharge Report", array('Attachment' => 0));
}
public  function  getDeathPatientData()
{
	$p_id = $this->input->post('p_id');
	$tableName = $this->session->user_session->patient_table;
	$branch_id=$this->session->user_session->branch_id;
	$sql = "select * from " . $tableName . " where id=" . $p_id;
	$query = $this->db->query($sql);
	$data='';
	if ($this->db->affected_rows() > 0) {

			$result = $query->row();
//		print_r($result);exit();
			if($result->gender==1)
			{
				$gender="male";
			}else if($result->gender==2)
			{
				$gender="female";
			}
			else
			{
				$gender="other";
			}
			if($result->birth_date!=null && $result->birth_date!='0000-00-00 00:00:00')
			{
				$age = (date('Y') - date('Y',strtotime($result->birth_date)));
			}
			else{
				$age='';
			}
			$date_death='';
			$death_time='';
			$death_reason='';
			$person_name='';
			$person_relation='';
			$person_address='';
			$person_contact='';
			$death_sql = "select * from patient_death_details where patient_id=" . $p_id." and branch_id=".$branch_id." order by id desc";
			$de_query = $this->db->query($death_sql);
			if ($this->db->affected_rows() > 0) {
				$death_result = $de_query->row();
				$date_death=$death_result->date_of_death;
				$death_time=$death_result->time_of_death;
				$death_reason=$death_result->reason_of_death;
				$person_name=$death_result->name_of_person_hondover;
				$person_relation=$death_result->patient_relation;
				$person_address=$death_result->person_address;
				$person_contact=$death_result->contact_no;
			}
			$deathCaseHis=$this->get_DeathCaseHistory($p_id);
			$data.='<div class="row" style="height:160px;"></div>
			<div class="row" style="text-transform: uppercase;font-size:22px;margin: 10px; ">
					<div class="col-sm-12 text-center"><h5>DEATH DECLARATION AND BODY HAND OVER</h5></div>
					<div class="col-sm-12">factual report of patient - <b>'.$result->patient_name.'</b></div>
					<div class="col-sm-12">patient name - <b>'.$result->patient_name.'</b></div>
					<div class="col-sm-12">gender - '.$gender.'</div>
					<div class="col-sm-12">age - '.$age.' YEAR</div>
					<div class="col-sm-12">contact no - '.$result->contact.'</div>
					<div class="col-sm-12">address - '.$result->address.'</div>
					<div class="col-sm-12">date of admission/time - '.$result->admission_date.'</div>
					<div class="col-sm-12">date of death - '.$date_death.'</div>
					<div class="col-sm-12">time of death - '.$death_time.'</div>
					<div class="col-sm-12">reason of death - '.$death_reason.'</div>
					'.$deathCaseHis.'
				</div>
				<div class="row" style="font-size:22px;margin-top: 35px;margin: 10px;">
					<div class="col-sm-12 text-center" style="text-transform: uppercase;">
					<h5>(body handing over + belongings hand over to the relative/attendants)</h5></div>
					<div class="col-sm-12"> Name of Person to whom body handed over : '.$person_name.'</div>
					<div class="col-sm-12"> Relation : '.$person_relation.'</div>
					<div class="col-sm-12"> Address : '.$person_address.'</div>
					<div class="col-sm-12"> Contact No.: '.$person_contact.'</div>
					<div class="col-sm-12"> Date :</div>
					<div class="col-sm-12"> Time :</div>
					<div class="col-md-12" style="display: flex;margin-top: 150px;"> <div class="col-md-6"> <b>Signature of Relative/Attendants :</b></div>
					 <div class="col-md-6 text-right"> <b>Signature of Hospital Authority :</b></div></div>
				</div>				
				</div>';
			$response['status'] = 200;
			$response['data'] = $data;

		} else {
			$response['status'] = 201;
			$response['data'] = "";
		}
		echo json_encode($response);
	}

	function get_DeathCaseHistory($p_id)
	{
		$case_history = "";
		$table_name = "";
		$department_id = 1;
		$query = $this->db->query("select tb_name from template_master where department_id='$department_id'");
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$table_name = $result->tb_name;
		}

		$comorbidi = " ";
		$vaccination = " ";
		$vaccination_date = " ";
		$branch_id=$this->session->user_session->branch_id;
		if ($table_name != "") {
			$sql = "select * from " . $table_name . " where patient_id='$p_id' AND branch_id='$branch_id' order by id DESC limit 1";
			$qry = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) {
				$res = $qry->result();
				foreach ($res as $row) {
					$comorbidi =$this->getOptions($row->sec_1_f_8);
					$vaccination = $this->getOptions($row->sec_1_f_16);
					$vaccination_date = $row->sec_1_f_17;
				}
			}
		}
		$case_history .= '<div class="col-sm-12">comorbidies - '.$comorbidi.'</div>
					<div class="col-sm-12">vaccination - '.$vaccination.' '.$vaccination_date.'</div>';


		return $case_history;
	}
}
