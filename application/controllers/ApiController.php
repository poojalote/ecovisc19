<?php

require_once 'HexaController.php';

/**
 * @property  MasterModel MasterModel
 */
class ApiController extends HexaController
{

	private $name = array(
		"Weight", "Blood Pressure - Systolic", "Blood Pressure - Diastolic", "Blood Sugar (Random)", "Serum Lipase",
		"Serum Amylase", "Hemoglobin (Hb)", "HbA1c", "Total Cholesterol", "High Density Lipoprotein (HDL)",
		"Low Density Lipoprotein (LDL)", "Very Low Density Lipoprotein (VLDL)", "Triglycerides", "Height",
		"Blood Sugar (Fasting)", "Vitamin D3,Vitamin B12", "Basophils", "Eosinophils",
		"Hematocrit (Hct)", "Lymphocytes", "Mean corpuscular hemoglobin (MCH)", "Mean corpuscular hemoglobin concentration (MCHC)",
		"Mean corpuscular volume (MCV)", "Monocytes", "Neutrophils", "Platelets (thrombocytes)", "Red blood cell count (RBC)",
		"Red cell distribution width (RDW)", "White blood cells (WBCs)", "Thyroglobulin antibody (TgAb, Anti-TG)",
		"Free T4", "Free T3", "Thyroglobulin (Tg)", "Thyroid Stimulating Hormone (TSH)", "Total T3", "Body Mass Index",
		"ESR", "Blood Urea Nitrogen", "Serum Creatinine", "Serum Uric Acid", "Total T4", "Bilirubin",
		"SGOT/AST", "SGPT/ALT", "Alkaline Phosphatase", "Gamma Glutamyl Transaminase", "Sodium (Na+)",
		"Potassium (K+)", "Calcium (Ca+)", "Chloride (Cl-)", "Phosphorous (P-)", "Serum Iron",
		"Serum Ferritin", "Total Iron binding capacity", "Unsaturated Iron binding capacity",
		"Leptin", "Heart Rate", "SPO2", "Temperature", "Cardiac Output", "Stroke volume", "Mean Arterial Pressure",
		"OCG - optical cardiogram", "Blood Viscosity", "PCO2", "PO2", "O2 Content", "CO2 Content",
		"PH", "Steps", "Calories", "Sleep", "Light sleep", "Deep Sleep", "Blood Sugar (Postprandial, PP)",
		"CRP - Inflammatory Markers", "D-Dimer", "Lactate DeHydrogenase (LDH)", "InterLeukin-6 (IL6)", "C-Reactive Protein",
		"NL ratio", "CT severity Index", "RT PCR", "Rapid Antigen", "Antibody Total",
		"Antibody IgG", "Spike Antibody", "Thyrocare - Antibody Total", "Thyrocare - IgG Elisa",
		"Thyrocare - IgG CMIA", "NMMedical - IgG CLIA", "NMMedical - IgG CLIA Interpretation",
		"RLS - RT-PCR", "RLS - Antibody Total", "RLS - Antibody IgG Elisa", "Metropolis - Antibody Total",
		"Metropolis - Antibody IgG", "IITD - RTLamp", "Albumin Serum", "Estimated Glomerular Filtration Rate",
		"BUN/Sr.Creatinine Ratio", "Basophils Absolute Count", "Eosinophils Absolute Count", "Lymphocytes Absolute Count",
		"Monocytes Absolute Count", "Neutrophils Absolute Count", "Immature Granulocytes", "Mean Platelet Volume",
		"Nucleated Red Blood Cells", "Nucleated Red Blood Cells %", "Plateletcrit", "Platelet Distribution Width",
		"Platelet To Large Cell Ratio", "Red Cell Distribution Width - SD", "Respiration Rate", "REM"
	);

	private $keyName = array(
		"weight", "bp_systolic", "bp_diastolic", "blood_sugar_random", "serum_lipase", "serum_amylase", "haemoglobin", "hba1c", "total_cholesterol", "hdl", "ldl", "vldl", "triglycerides",
		"height", "blood_sugar_fasting", "vitamin_d3", "vitamin_b12", "basophil", "eosinophils", "haematocrit", "lymphocytes", "mch",
		"mchc", "mcv", "monocytes", "neutrophils", "platelets", "rbc_count", "rdw", "wbc", "tgab", "free_t4", "free_t3", "thyroglobulin",
		"tsh", "total_t3", "body_mass_index", "esr", "bun", "serum_creatinine", "serum_uric_acid", "total_t4", "bilirubin", "sgot_ast",
		"sgpt_alt", "alkaline_phosphatase", "ggt", "na+", "k+", "ca+", "cl-", "p-", "SI", "SF", "tibc", "uibc", "leptin",
		"vitals_heartrate", "spo2", "temperature", "cardiac_output", "stroke_volume", "mean_arterial_pressure", "ocg_optical_cardiogram",
		"blood_viscosity", "pco2", "po2", "o2_content", "co2_content", "ph", "activities_panel_steps", "activities_panel_calories",
		"activities_panel_sleep", "activities_panel_light_sleep", "activities_panel_deep_sleep", "post_prandial", "crp,d_dimer",
		"ldh", "il6", "c_reactive_protein", "nlr", "ctv_sar", "rt_pcr", "covid_antigen", "covid_antibody_total", "covid_antibody_igg",
		"spike_antibody", "thyrocare_covid_antibody_total_clia", "thyrocare_covid_antibody_igg_elisa", "thyrocare_covid_antibody_igg_cmia",
		"nmmedical_covid_antibody_igg_clia", "nmmedical_covid_antibody_igg_clia_interpretation", "rls_covid_rt_pcr",
		"rls_covid_antibody_total", "rls_covid_antibody_igg_elisa", "metropolis_covid_antibody_total", "metropolis_covid_antibody_igg",
		"iitd_covid_rtlamp", "albumin_serum", "est_glomerular_filtration_rate", "bun_sr_creatinine_ratio", "basophils_absolute_count",
		"eosinophils_absolute_count", "lymphocytes_absolute_count", "monocytes_absolute_count", "neutrophils_absolute_count", "immature_granulocytes",
		"mean_platelet_volume", "nucleated_red_blood_cells", "nucleated_red_blood_cells_percentage", "plateletcrit", "platelet_distribution_width",
		"platelet_to_large_cell_ratio", "red_cell_distribution_width_sd", "respiration_rate", "rem"
	);

	private $unit = array(
		"kg", "mmHg", "mmHg", "mg/dl", "U/L", "U/L", "g/dl", "%", "mg/dl", "mg/dl", "mg/dl", "mg/dl", "mg/dl",
		"cm", "mg/dl", "ng/ml", "pg/ml", "%", "%", "%", "%", "g/dl", "%", "fL", "%", "%", "10^9/L", "x10^12/L", "%", "Count/cu mm",
		"Present/Absent", "ng/dl", "pg/ml", "ng/ml", "ulU/ml", "ug/dl", "kg/m2", "mm/hr", "mg/dl", "mg/dl", "mg/dl", "ug/dl",
		"mg/dl", "Units/L", "Units/L", "Units/L", "Units/L", "mEq/L", "mEq/L", "mEq/L", "mEq/L", "mEq/L", "ug/dl", "ng/ml", "ug/dl", "ug/dl",
		"U/L", "bpm", "%", "F", "Litres/Minute", "milli Litres", "mmHg", "milliseconds", "pascal-seconds", "mmHg", "mmHg", "ml/dL", "mEq/L",
		"-", "-", "calories", "hours", "hours", "hours", "mg/dl", "mg/l", "ng/ml", "U/l", "mcg/ml", "mg/l", "pg/ml", "NA", "NA", "NA", "COI",
		"S/CO", "U/ml", "COI", "OD Ratio", "Index", "AU/mL", "", "None", "None", "None", "cutoff index", "Index(S/C)", "", "gm/dl",
		"mL/min/1.73 m2", "ratio", "X 10³/µL", "X 10³/µL", "X 10³/µL", "X 10³/µL", "X 10³/µL", "X 10³/µL", "fL", "X 10³/µL", "%", "%", "fL",
		"%", "fL", "respirations/minute", "seconds");

	/**
	 * ApiController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MasterModel');

	}

	function getCount()
	{
		echo "<br>Parameter count" . count($this->name);
		echo "<br>Key count" . count($this->keyName);
		echo "<br>Unit count" . count($this->unit);
	}
	
	function uploadAllPatientData(){ // 1hour function
		$array=array(1075,1056,975,1041);
		
		//$array=array(1044);
		$response="";
		for($i=0;$i< count($array);$i++){
			$data = $this->uploadVitalStructureData($array[$i]);
			$response .=$i."-".$data;
		}
		log_message('info', "API_1Hour".$response);
		//echo json_encode($response);
	}
	function uploadAllPatientDataLive(){ //1 minute function
		$array=array(1075,1056,975,1041);
		$array2=array(456,460,466,467);
		//$array=array(1044);
		$response="";
		for($i=0;$i< count($array);$i++){
			$data = $this->uploadVitalStructureDataLive($array[$i],$array2[$i]);
			$response .=$i."-".$data;
		}
		log_message('info', "API_1Minute".$response);
		//echo json_encode($response);
	}
	
	function uploadVitalStructureDataLive($patientID,$bed_id){
		$authID = 'healthstart';
		$authToken = 'k07ojRrG6_Hhq6YtVLxKKQ';

		$demographicObject = $this->getPatientDemographicsData1($patientID);


		if ($demographicObject->status) {
			$patientDemographics = ($demographicObject->data);

			$vitalDetails = $this->getVitalDataLive($patientID,$bed_id);
			log_message('info', "API_1MinuteData".$vitalDetails);
			$response=$this->requestAPI($patientDemographics, $vitalDetails);
			} else {
			$response["status"] = 201;

			$response["body"] = $demographicObject->data;
			}
		return $response;
	}

	function uploadVitalStructureData($patientID)
	{


		//$patientID = 1062;
		//$patientID = $this->input->post('p_id');
		$authID = 'healthstart';
		$authToken = 'k07ojRrG6_Hhq6YtVLxKKQ';

		$demographicObject = $this->getPatientDemographicsData1($patientID);


		if ($demographicObject->status) {
			$patientDemographics = ($demographicObject->data);

			$vitalDetails = $this->getVitalData($patientID);
			log_message('info', "API_1HourData".$vitalDetails);
			$response=$this->requestAPI($patientDemographics, $vitalDetails);
			} else {
			$response["status"] = 201;

			$response["body"] = $demographicObject->data;
			}
		return $response;
		//echo json_encode($response);

	}

	function requestAPI($demographic, $vital)
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://qa3files.healthhub.net.in/HealthHubWebServices/uploadStructureData",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('patientDemographics' => json_encode($demographic),
 			'vitalDetails' => json_encode($vital)),
			CURLOPT_HTTPHEADER => array(
				'authToken: k07ojRrG6_Hhq6YtVLxKKQ',
				'authId: healthstart'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
	function getPatientDemographicsData1($patientID){
		$patientObject = $this->MasterModel->_select('patient_demographic_details', array("patient_id" => $patientID));
		$object = new stdClass();
		$object->status = false;
		if ($patientObject->totalCount == 1) {
				$name = explode(" ", $patientObject->data->Patient_name);
				if (count($name) > 1) {
				$firstName = $name[0];
				$lastName = $name[1];
				if (array_key_exists(2, $name)) {
					$lastName = $name[1];
				}
				$gender = $patientObject->data->gender;
				$patientDetails = array(
					"firstName" => $firstName,
					"lastName" => $lastName,
					"dob" => date('d-m-Y', strtotime($patientObject->data->dob)),
					"gender" => $gender,
					"phoneNumber" => $patientObject->data->phoneNumber,
					"healthHubId" => $patientObject->data->jio_id
				);
				$object->status = true;
				$object->data = $patientDetails;
				
				return $object;
				}else {
				$object->data = "Patient Name Not Found";
				return $object;
			}
		} else {
			$object->data = "Data Not Found";
			return $object;
		}
	}
	function getPatientDemographicsData($patientID)
	{
		$patientObject = $this->MasterModel->_select('com_1_patient', array("id" => $patientID));
		$object = new stdClass();
		$object->status = false;
		if ($patientObject->totalCount == 1) {
			$name = explode(" ", $patientObject->data->patient_name);

			if (count($name) > 1) {
				$firstName = $name[0];
				$lastName = $name[1];
				if (array_key_exists(2, $name)) {
					$lastName = $name[1];
				}
				$gender = $patientObject->data->gender == 2 ? "F" : "M";
				if ($patientObject->data->birth_date == '0000-00-00') {
					$object->data = "Patient Birth Not Found";
					return $object;
				}
				if ($patientObject->data->contact == null || $patientObject->data->contact == "") {
					$object->data = "Patient Contact Not Found";
					return $object;
				}
				$patientDetails = array(
					"firstName" => $firstName,
					"lastName" => $lastName,
					"dob" => date('d-m-Y', strtotime($patientObject->data->birth_date)),
					"gender" => $gender,
					"phoneNumber" => $patientObject->data->contact,
					"healthHubId" => $patientObject->data->jio_id
				);
				$object->status = true;
				$object->data = $patientDetails;
				return $object;
			} else {
				$object->data = "Patient Name Not Found";
				return $object;
			}
		} else {
			$object->data = "Data Not Found";
			return $object;
		}
	}


	function getVitalDataLive($patientID,$bed_id){
		$patientVisit = rand(1000, 100000);
		$patientVisitDateTime = date("d-m-Y H:i:s");
		$location = "Mumbai";

		$doctorName = "Dr. Vivek Kumar";
		$doctorSpecially = "Hemotologist";

		$doctorObject = new stdClass();
		$doctorObject->name = $doctorName;
		$doctorObject->specialty = $doctorSpecially;
		
		$vitalDetails = $this->getPatientVitalDataLive($patientID,$bed_id);
		
		$reportID = rand(1000, 100000);
		$paramArray = array("reportId"=>$reportID,"reportDate"=>date('d-m-Y H:i:s'));
		 if($vitalDetails->VitalSection2->Spo2  >= 5 && $vitalDetails->VitalSection2->Spo2  <= 220){
		$spoObject = $this->getParameterObject($vitalDetails->VitalSection2->Spo2, "%", "", "", "", "");
		$paramArray["spo2"] = $spoObject;		
		}
		if($vitalDetails->VitalSection2->Temperature  >= 50 && $vitalDetails->VitalSection2->Temperature  <= 100){
		$TemperatureObject = $this->getParameterObject($vitalDetails->VitalSection2->Temperature, "F", "", "", "", "");
		$paramArray["temperature"] = $TemperatureObject;		
		}
		if($vitalDetails->VitalSection2->heart_rate  >= 5 && $vitalDetails->VitalSection2->heart_rate  <= 220){
		$vitals_heartrateObject = $this->getParameterObject($vitalDetails->VitalSection2->heart_rate, "bpm", "", "", "", "");
		$paramArray["vitals_heartrate"] = $vitals_heartrateObject;		
		}
		
		
		$BP_SystolicObject = $this->getParameterObject($vitalDetails->VitalSection2->BP_Systolic, "mmHg", "", "", "", "");
		$BP_DiastolicObject = $this->getParameterObject($vitalDetails->VitalSection2->BP_Diastolic, "mmHg", "", "", "", "");
	//	$Blood_SugarObject = $this->getParameterObject($vitalDetails->VitalSection2->Blood_Sugar, "mg/dl", "", "", "", ""); 
		
		$paramArray["bp_systolic"] = $BP_SystolicObject;
		$paramArray["bp_diastolic"] = $BP_DiastolicObject;
		//$paramArray["blood_sugar_random"] = $Blood_SugarObject;
		return array(
			"visitId" => $patientVisit,
			"visitDate" => $patientVisitDateTime,
			"location" => $location,
			"doctor" => $doctorObject,
			"vitalarray" => array($paramArray)
		);
	}
	function getVitalData($patientID)
	{

		$patientVisit = rand(1000, 100000);
		$patientVisitDateTime = date("d-m-Y H:i:s");
		$location = "Mumbai";

		$doctorName = "Dr. Vivek Kumar";
		$doctorSpecially = "Hemotologist";

		$doctorObject = new stdClass();
		$doctorObject->name = $doctorName;
		$doctorObject->specialty = $doctorSpecially;
		$vitalDetails = $this->getPatientVital($patientID);
		$reportID = rand(1000, 100000);
		$paramArray = array("reportId"=>$reportID,"reportDate"=>date('d-m-Y H:i:s'));
		$weightObject = $this->getParameterObject($vitalDetails->VitalSection1->weight, "Kg", "", "", "", "");
		$heightObject = $this->getParameterObject($vitalDetails->VitalSection1->Height, "cm", "", "", "", "");
		$bmiObject = $this->getParameterObject($vitalDetails->VitalSection1->BMI, "kg/m2", "", "", "", "");
		
		//ExcelData
		
		if(property_exists($vitalDetails->ExcelData, 'HbA1c')){
			$HbA1cObject = $this->getParameterObject($vitalDetails->ExcelData->HbA1c, "%", "", "", "", "");
			$paramArray["hba1c"] = $HbA1cObject;
		}
		
		if(property_exists($vitalDetails->ExcelData, 'Basophils')){
			$BasophilsObject = $this->getParameterObject($vitalDetails->ExcelData->Basophils, "%", "", "", "", "");
			$paramArray["basophil"] = $BasophilsObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Neutrophils')){
			$NeutrophilsObject = $this->getParameterObject($vitalDetails->ExcelData->Neutrophils, "%", "", "", "", "");
			$paramArray["neutrophils"] = $NeutrophilsObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Monocytes')){
			$MonocytesObject = $this->getParameterObject($vitalDetails->ExcelData->Monocytes, "%", "", "", "", "");
			$paramArray["monocytes"] = $MonocytesObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Lymphocytes')){
			$LymphocytesObject = $this->getParameterObject($vitalDetails->ExcelData->Lymphocytes, "%", "", "", "", "");
			$paramArray["lymphocytes"] = $LymphocytesObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Eosinophils')){
			$EosinophilsObject = $this->getParameterObject($vitalDetails->ExcelData->Eosinophils, "%", "", "", "", "");
			$paramArray["eosinophils"] = $EosinophilsObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Triglycerides')){
			$TriglyceridesObject = $this->getParameterObject($vitalDetails->ExcelData->Triglycerides, "mg/dl", "", "", "", "");
			$paramArray["triglycerides"] = $TriglyceridesObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Vitamin_B12')){
			$VitaminB12Object = $this->getParameterObject($vitalDetails->ExcelData->Vitamin_B12, "pg/ml", "", "", "", "");
			$paramArray["vitamin_b12"] = $VitaminB12Object;
		}
		if(property_exists($vitalDetails->ExcelData, 'Free_t4')){
			$Free_t4Object = $this->getParameterObject($vitalDetails->ExcelData->Free_t4, "ng/dl", "", "", "", "");
			$paramArray["free_t4"] = $Free_t4Object;
		}
		if(property_exists($vitalDetails->ExcelData, 'Free_t3')){
			$Free_t3Object = $this->getParameterObject($vitalDetails->ExcelData->Free_t3, "pg/ml", "", "", "", "");
			$paramArray["free_t3"] = $Free_t3Object;
		}
		if(property_exists($vitalDetails->ExcelData, 'Total_T3')){
			$Total_T3Object = $this->getParameterObject($vitalDetails->ExcelData->Total_T3, "ug/dl", "", "", "", "");
			$paramArray["total_t3"] = $Total_T3Object;
		}
		if(property_exists($vitalDetails->ExcelData, 'Total_T4')){
			$Total_T4Object = $this->getParameterObject($vitalDetails->ExcelData->Total_T4, "ug/dl", "", "", "", "");
			$paramArray["total_t4"] = $Total_T4Object;
		}
		if(property_exists($vitalDetails->ExcelData, 'ESR')){
			$ESRObject = $this->getParameterObject($vitalDetails->ExcelData->ESR, "mm/hr", "", "", "", "");
			$paramArray["Esr"] = $ESRObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Bilirubin')){
			$BilirubinObject = $this->getParameterObject($vitalDetails->ExcelData->Bilirubin, "mg/dl", "", "", "", "");
			$paramArray["bilirubin"] = $BilirubinObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Potassium')){
			$PotassiumObject = $this->getParameterObject($vitalDetails->ExcelData->Potassium, "mEq/L", "", "", "", "");
			$paramArray["k+"] = $PotassiumObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Calcium')){
			$CalciumObject = $this->getParameterObject($vitalDetails->ExcelData->Calcium, "mEq/L", "", "", "", "");
			$paramArray["ca+"] = $CalciumObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'Chloride')){
			$ChlorideObject = $this->getParameterObject($vitalDetails->ExcelData->Chloride, "mEq/L", "", "", "", "");
			$paramArray["cl-"] = $ChlorideObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'pH')){
			$pHObject = $this->getParameterObject($vitalDetails->ExcelData->pH, "", "", "", "", "");
			$paramArray["Ph"] = $pHObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'd_dimer')){
			$d_dimerObject = $this->getParameterObject($vitalDetails->ExcelData->d_dimer, "ng/ml", "", "", "", "");
			$paramArray["d_dimer"] = $d_dimerObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'lactate')){
			$lactateObject = $this->getParameterObject($vitalDetails->ExcelData->lactate, "U/l", "", "", "", "");
			$paramArray["ldh"] = $lactateObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'creactive')){
			$creactiveObject = $this->getParameterObject($vitalDetails->ExcelData->creactive, "mg/l", "", "", "", "");
			$paramArray["c_reactive_protein"] = $creactiveObject;
		}
		if(property_exists($vitalDetails->ExcelData, 'sodium')){
			$sodiumObject = $this->getParameterObject($vitalDetails->ExcelData->sodium, "mEq/L", "", "", "", "");
			$paramArray["na+"] = $sodiumObject;
		}
		
		$paramArray["weight"] = $weightObject;
		$paramArray["height"] = $heightObject;
		$paramArray["body_mass_index"] = $bmiObject;
		
		return array(
			"visitId" => $patientVisit,
			"visitDate" => $patientVisitDateTime,
			"location" => $location,
			"doctor" => $doctorObject,
			"vitalarray" => array($paramArray)
		);
	}


	function getParameterObject($value, $unit, $testMethod, $normalRange, $interpretation, $specimen)
	{
		$object = new stdClass();
		$object->value = $value;
		$object->unit = $unit;
		$object->testmethod = $testMethod;
		$object->normalrange = $normalRange;
		$object->interpretation = $interpretation;
		$object->specimen = $specimen;
		return $object;
	}

	function getPatientVital($patientID)
	{

		$patientQuery1Result = $this->db->query("select sec_1_f_13 as 'weight', sec_1_f_14 as 'Height',sec_1_f_84 as 'BMI' from com_1_dep_1 where patient_id =" . $patientID . " and branch_id=1;")->row();

		/* $patientQuery2Result = $this->db->query("select sec_2_f_4 as 'Spo2',sec_2_f_5 as'Temperature',sec_2_f_6 as	'Blood_Sugar',sec_2_f_18 as	'BP_Systolic',sec_2_f_19 as	'BP_Diastolic',sec_2_f_20 as'Heart Rate' 
from  com_1_dep_2 where patient_id =" . $patientID . " and branch_id=1")->row(); */

		$patientQuery_excelData = $this->db->query("SELECT result,ParameterId,ParameterName FROM 
						excel_structure_data where (ParameterId=7053 OR ParameterId=9088 OR 
						ParameterId=9360 OR ParameterId=6926 OR ParameterId=7106 OR ParameterId=7136 OR
						ParameterId=7148 OR ParameterId=8145 OR ParameterId=8144 OR ParameterId=9058 OR
						ParameterId=6956 OR ParameterId=9059 OR ParameterId=6903 OR ParameterId=7371 OR
						ParameterId=7199 OR ParameterId=6804 OR ParameterId=6826 OR ParameterId=8655 OR
						ParameterId=6897 OR ParameterId=7495 OR ParameterId=6864 OR ParameterId=10263) 
						and patient_id = ".$patientID." group by ParameterId order by id desc")->result();
			$last_query_obj=new stdClass();			
		if(count($patientQuery_excelData) > 0){
			foreach($patientQuery_excelData as $row){
				$ParameterName=$row->ParameterName;
				if($ParameterName =="Free T4"){
					$paramaterName="Free_t4";
				}
				if($ParameterName =="Free T3"){
					$paramaterName="Free_t3";
				}
				if($ParameterName =="Total T3"){
					$paramaterName="Total_T3";
				}
				if($ParameterName =="Total T4"){
					$paramaterName="Total_T4";
				}
				if($ParameterName =="Vitamin B12"){
					$paramaterName="Vitamin_B12";
				}
				if($ParameterName =="Direct Bilirubin"){
					$paramaterName="Bilirubin";
				}
				if($ParameterName =="D-Dimer Assay"){
					$paramaterName="d_dimer";
				}
				if($ParameterName =="Lactate dehydrogenase [LDH]"){
					$paramaterName="lactate";
				}
				if($ParameterName =="C-Reactive Protein [CRP]"){
					$paramaterName="creactive";
				}
				if($ParameterName =="U. Sodium"){
					$paramaterName="sodium";
				}
				$result=$row->result;
				$last_query_obj->$ParameterName=$result;
			}
		}
		
		$object = new stdClass();
		$object->VitalSection1 = $patientQuery1Result;
		//$object->VitalSection2 = $patientQuery2Result;
		$object->ExcelData = $last_query_obj;
		//$object->HbA1c = $patientQuery_HBA1c;

		return $object;
	}
	
	function getPatientVitalDataLive($patientID,$bed_id){
		$this->db2 = $this->load->database('live', TRUE);
		$patientQuery2Result = $this->db2->query("select SPO2 as 'Spo2',TEMP as 'Temperature', 
		BP1 as 'BP_Systolic',BP2 as 'BP_Diastolic',HR_BPM as 'heart_rate'
		from  patient_monitor_live where patient_id =" . $bed_id)->row();
		$object = new stdClass();
		$object->VitalSection2 = $patientQuery2Result;
		return $object;
	}


}
