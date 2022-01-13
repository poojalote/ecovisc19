<?php

require_once 'HexaController.php';

class PersonalTemplateController extends HexaController
{


	/**
	 * PersonalTemplateController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('TemplateModel');
		$this->load->model('Formmodel');

		$this->load->model('Global_model');
		date_default_timezone_set('Asia/Kolkata');
	}

	public function index(){
		$this->load->view('admin/templates/personal_template',array("title"=>"Personal Template"));
	}


	function saveTemplate()
	{

		$validationObject = $this->is_parameter(array("department_id","section_name", "elementSequenceType","elementSequenceId"));
		if ($validationObject->status) {

			$params = $validationObject->param;
			$section_name = $params->section_name;
			$department_id = $params->department_id;
			$create_by =1;
			$resultObject = $this->TemplateModel->getCompany($department_id);
			$elementObjectArray = array();
			$tableName="";
			if (is_null($this->input->post("ck_template_transaction"))) {
				$sectionTransactionMode = 0;
			} else {
				$sectionTransactionMode = $this->input->post("ck_template_transaction") == "on" ? 1 : 0;
			}
			if (is_null($this->input->post("section_id"))) {
				$sectionId = null;
			} else {
				if($this->input->post("section_id")==""){
					$sectionId = null;
				}else{
					$sectionId = $this->input->post("section_id");
				}

			}
			if (is_null($this->input->post("ck_template_history"))) {
				$sectionHistoryMode = 0;
			} else {
				$sectionHistoryMode = $this->input->post("ck_template_history") == "on" ? 1 : 0;
			}

			if($resultObject->totalCount == 1){
				$company_id=$resultObject->data->company_id;
				$tableName = "com_".$company_id."_dep_".$department_id;

				$elementsType=explode(",",$params->elementSequenceType);
				$elementsId=explode(",",$params->elementSequenceId);

				if(count($elementsType) == count($elementsId)){
					foreach ($elementsType as $typeIndex => $type) {
						$index = $elementsId[$typeIndex];
						switch ((int)$type) {
							case 1:
								array_push($elementObjectArray, $this->getShortText($index,$typeIndex,$type));
								break;
							case 2:
								array_push($elementObjectArray, $this->getLongText($index,$typeIndex,$type));
								break;
							case 3:
								array_push($elementObjectArray, $this->getDropDown($index,$typeIndex,$type));
								break;
							case 4:
								array_push($elementObjectArray, $this->getMultipleDropDown($index,$typeIndex,$type));
								break;
							case 5:
								array_push($elementObjectArray, $this->getDateText($index,$typeIndex,$type));
								break;
							case 6:
								array_push($elementObjectArray, $this->getNumberText($index,$typeIndex,$type));
								break;
							case 7:
								array_push($elementObjectArray, $this->getAttachmentText($index,$typeIndex,$type));
								break;
							case 8:
								array_push($elementObjectArray, $this->getqueryDropDown($index,$typeIndex,$type));
								break;
							case 10:
								array_push($elementObjectArray, $this->getfixnumber($index,$typeIndex,$type));
								break;
							case 11:
								array_push($elementObjectArray, $this->getLabel($index,$typeIndex,$type));
								break;
							case 12:
								array_push($elementObjectArray, $this->getCheckBoxGroup($index,$typeIndex,$type));
								break;
							case 13:
								array_push($elementObjectArray, $this->getRadioGroup($index,$typeIndex,$type));
								break;
						}
					}
				}
			}
			$response["sectionId"] = $sectionId;
			$resultObject = $this->TemplateModel->saveTemplate($section_name, $department_id, $elementObjectArray, $tableName, $create_by,$sectionId,$sectionTransactionMode,$sectionHistoryMode);
			$dataObject = new stdClass();
			$dataObject->sectionName = $params->section_name;
			$dataObject->data = $elementObjectArray;
			if($resultObject->status){
				$response["status"] = 200;
				$response["body"]="Save Changes";
				$response["data"] = $resultObject;
			}else{
				$response["status"] = 201;
				$response["body"]="Failed To Save Changes";
				$response["body"] = $dataObject;
				$response["data"] = $resultObject;
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	private function getShortText($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;

		$shortText = $this->input->post("short_text_".$position);
		$shortTextId = $this->input->post("short_text_id_" . $position);
		$shortTextPlaceholder = $this->input->post("short_text_placeholder_".$position);
		$shortTextRequired = $this->input->post("ck_short_text_required_".$position);
		$shortTextHistory = $this->input->post("ck_short_text_history_".$position);

		$shortTextObject->name = $shortText;
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		if ($shortTextPlaceholder != null)
			$shortTextObject->placeholder = $shortTextPlaceholder;
		if ($shortTextRequired != null)
			$shortTextObject->is_required = $shortTextRequired == "on" ? 1 : 0;
		if ($shortTextHistory != null)
			$shortTextObject->is_history = $shortTextHistory == "on" ? 1 : 0;
		return $shortTextObject;
	}

	private function getLongText($position,$sequence,$type)
	{
		$longtextObject = new stdClass();
		$longtextObject->sequeance_num=$sequence;
		$longtextObject->ans_type=$type;

		$longText = $this->input->post("long_text_".$position);
		$longTextId = $this->input->post("long_text_id_" . $position);
		$longTextPlaceholder = $this->input->post("long_text_placeholder_".$position);
		$longTextRequired = $this->input->post("ck_long_text_required_".$position);
		$longTextHistory = $this->input->post("ck_long_text_history_".$position);

		$longtextObject->name = $longText;
		if ($longTextId != null)
			$longtextObject->id = $longTextId;
		if ($longTextPlaceholder != null)
			$longtextObject->placeholder = $longTextPlaceholder;
		if ($longTextRequired != null)
			$longtextObject->is_required = $longTextRequired == "on" ? 1 : 0;
		if ($longTextHistory != null)
			$longtextObject->is_history = $longTextHistory == "on" ? 1 : 0;
		return $longtextObject;
	}

	private function getDropDown($position,$sequence,$type)
	{
		$dropDownObject = new stdClass();
		$dropDownObject->sequeance_num=$sequence;
		$dropDownObject->ans_type=$type;
		$dropDown = $this->input->post("drop_down_".$position);
		$dropDownId = $this->input->post("drop_down_id_" . $position);
		$dropDownPlaceholder = $this->input->post("drop_down_placeholder_".$position);
		$dropDownRequired = $this->input->post("ck_drop_down_required_".$position);
		$dropDownHistory = $this->input->post("ck_drop_down_history_".$position);
		$dropDownOptions = $this->input->post("drop_down_option_value_".$position);
		$dropDownObject->name = $dropDown;
		if ($dropDownId != null)
			$dropDownObject->id = $dropDownId;
		if ($dropDownPlaceholder != null)
			$dropDownObject->placeholder = $dropDownPlaceholder;
		if ($dropDownRequired != null)
			$dropDownObject->is_required = $dropDownRequired == "on" ? 1 : 0;
		if ($dropDownHistory != null)
			$dropDownObject->is_history = $dropDownHistory == "on" ? 1 : 0;
		if ($dropDownOptions != null) {
			$options = explode(",", $dropDownOptions);
			$optionsValues = array();
			foreach ($options as $value) {
				if (!empty($value)) {
					array_push($optionsValues, $value);
				}
			}
			$dropDownObject->options = $optionsValues;
		}else{
			$dropDownObject->options = array();
		}

		return $dropDownObject;
	}

	private function getqueryDropDown($position,$sequence,$type){
		$dropDownObject = new stdClass();
		$dropDownObject->sequeance_num=$sequence;
		$dropDownObject->ans_type=$type;
		$dropDown = $this->input->post("query_drop_down_".$position);
		$dropDownId = $this->input->post("query_drop_down_id_" . $position);
		$dropDownPlaceholder = $this->input->post("query_drop_down_placeholder_".$position);
		$dropDownRequired = $this->input->post("ck_query_drop_down_required_".$position);
		$dropDownHistory = $this->input->post("ck_query_drop_down_history_".$position);
		$dropDownquery = $this->input->post("query_drop_down_option_".$position);
		$dropDowndependancy = $this->input->post("query_drop_down_dependant_".$position);
		$dropDownisextended = $this->input->post("ck_query_drop_down_exttemp_".$position);
		$dropDownexttempid = $this->input->post("slct_template_".$position);

		$dropDownObject->name = $dropDown;
		if ($dropDownId != null)
			$dropDownObject->id = $dropDownId;
		if ($dropDownPlaceholder != null)
			$dropDownObject->placeholder = $dropDownPlaceholder;
		if ($dropDownRequired != null)
			$dropDownObject->is_required = $dropDownRequired == "on" ? 1 : 0;
		if ($dropDownHistory != null)
			$dropDownObject->is_history = $dropDownHistory == "on" ? 1 : 0;
		if ($dropDownquery != null)
			$dropDownObject->custom_query = $dropDownquery;
		if ($dropDowndependancy != null)
			$dropDownObject->dependancy = $dropDowndependancy;
		if ($dropDownisextended != null)
			$dropDownObject->is_extended_template = $dropDownisextended== "on" ? 1 : 0;
		if ($dropDownexttempid != null)
			$dropDownObject->ext_template_id = $dropDownexttempid;

		return $dropDownObject;
	}

	private function getMultipleDropDown($position,$sequence,$type)
	{
		$dropDownObject = new stdClass();
		$dropDownObject->sequeance_num=$sequence;
		$dropDownObject->ans_type=$type;
		$dropDown = $this->input->post("multi_drop_down_".$position);
		$dropDownId = $this->input->post("multi_drop_down_id_" . $position);
		$dropDownPlaceholder = $this->input->post("multi_drop_down_placeholder_".$position);
		$dropDownRequired = $this->input->post("ck_multi_drop_down_required_".$position);
		$dropDownHistory = $this->input->post("ck_multi_drop_down_history_".$position);
		$dropDownOptions = $this->input->post("multi_drop_down_option_value_".$position);
		$dropDownObject->name = $dropDown;
		if ($dropDownId != null)
			$dropDownObject->id = $dropDownId;
		if ($dropDownPlaceholder != null)
			$dropDownObject->placeholder = $dropDownPlaceholder;
		if ($dropDownRequired != null)
			$dropDownObject->is_required = $dropDownRequired == "on" ? 1 : 0;
		if ($dropDownHistory != null)
			$dropDownObject->is_history = $dropDownHistory == "on" ? 1 : 0;
		if ($dropDownOptions != null) {
			$options = explode(",", $dropDownOptions);
			$optionsValues = array();
			foreach ($options as $value) {
				if (!empty($value)) {
					array_push($optionsValues, $value);
				}
			}
			$dropDownObject->options = $optionsValues;
		}else{
			$dropDownObject->options = array();
		}
		return $dropDownObject;
	}

	private function getNumberText($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;
		$shortText = $this->input->post("number_element_".$position);
		$shortTextId = $this->input->post("number_text_id_" . $position);
		$shortTextPlaceholder = $this->input->post("number_placeholder_".$position);
		$shortTextRequired = $this->input->post("ck_number_text_required_".$position);
		$shortTextHistory = $this->input->post("ck_number_text_history_".$position);

		$shortTextObject->name = $shortText;
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		if ($shortTextPlaceholder != null)
			$shortTextObject->placeholder = $shortTextPlaceholder;
		if ($shortTextRequired != null)
			$shortTextObject->is_required = $shortTextRequired== "on" ? 1 : 0;
		if ($shortTextHistory != null)
			$shortTextObject->is_history = $shortTextHistory == "on" ? 1 : 0;
		return $shortTextObject;
	}

	private function getfixnumber($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;
		$shortText = $this->input->post("fixnumber_element_".$position);
		$shortTextId = $this->input->post("fixnumber_text_id_" . $position);
		$shortTextPlaceholder = $this->input->post("fixnumber_placeholder_".$position);
		$shortTextRequired = $this->input->post("fixck_number_text_required_".$position);
		$shortTextHistory = $this->input->post("fixck_number_text_history_".$position);
		$shortTextquery = $this->input->post("fixnumber_drop_down_option_".$position);

		$shortTextObject->name = $shortText;
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		if ($shortTextPlaceholder != null)
			$shortTextObject->placeholder = $shortTextPlaceholder;
		if ($shortTextquery != null)
			$shortTextObject->custom_query = $shortTextquery;
		if ($shortTextRequired != null)
			$shortTextObject->is_required = $shortTextRequired== "on" ? 1 : 0;
		if ($shortTextHistory != null)
			$shortTextObject->is_history = $shortTextHistory == "on" ? 1 : 0;
		return $shortTextObject;
	}

	private function getDateText($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;
		$shortText = $this->input->post("date_element_".$position);
		$shortTextId = $this->input->post("date_text_id_" . $position);
		$shortTextPlaceholder = $this->input->post("date_placeholder_".$position);
		$shortTextRequired = $this->input->post("ck_date_text_required_".$position);
		$shortTextHistory = $this->input->post("ck_date_text_history_".$position);

		$shortTextObject->name = $shortText;
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		if ($shortTextPlaceholder != null)
			$shortTextObject->placeholder = $shortTextPlaceholder;
		if ($shortTextRequired != null)
			$shortTextObject->is_required = $shortTextRequired == "on" ? 1 : 0;
		if ($shortTextHistory != null)
			$shortTextObject->is_history = $shortTextHistory == "on" ? 1 : 0;
		return $shortTextObject;
	}

	private function getAttachmentText($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;
		$shortText = $this->input->post("attachment_element_".$position);
		$shortTextId = $this->input->post("attachment_id_" . $position);
		$shortTextPlaceholder = $this->input->post("attachment_placeholder_".$position);
		$shortTextRequired = $this->input->post("ck_attachment_text_required_".$position);
		$shortTextHistory = $this->input->post("ck_attachment_text_history_".$position);

		$shortTextObject->name = $shortText;
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		if ($shortTextPlaceholder != null)
			$shortTextObject->placeholder = $shortTextPlaceholder;
		if ($shortTextRequired != null)
			$shortTextObject->is_required = $shortTextRequired == "on" ? 1 : 0;
		if ($shortTextHistory != null)
			$shortTextObject->is_history = $shortTextHistory == "on" ? 1 : 0;
		return $shortTextObject;
	}

	private function getLabel($position,$sequence,$type)
	{
		$shortTextObject = new stdClass();
		$shortTextObject->sequeance_num=$sequence;
		$shortTextObject->ans_type=$type;
		$shortText = $this->input->post("label_".$position);
		$shortTextId = $this->input->post("label_text_id_" . $position);
		if ($shortTextId != null)
			$shortTextObject->id = $shortTextId;
		
		$shortTextObject->name = $shortText;
		return $shortTextObject;
		
		
		
	}

	private function getRadioGroup($position,$sequence,$type)
	{
		$dropDownObject = new stdClass();
		$dropDownObject->sequeance_num=$sequence;
		$dropDownObject->ans_type=$type;
		$dropDown = $this->input->post("radio_box_".$position);
		$dropDownId = $this->input->post("radio_box_id_" . $position);
		$dropDownRequired = $this->input->post("ck_radio_box_required_".$position);
		$dropDownOptions = $this->input->post("radio_box_option_value_".$position);
		$dropDownObject->name = $dropDown;
		if ($dropDownId != null)
			$dropDownObject->id = $dropDownId;
		if ($dropDownRequired != null)
			$dropDownObject->is_required = $dropDownRequired == "on" ? 1 : 0;
		if ($dropDownOptions != null) {
			$options = explode(",", $dropDownOptions);
			$optionsValues = array();
			foreach ($options as $value) {
				if (!empty($value)) {
					array_push($optionsValues, $value);
				}
			}
			$dropDownObject->options = $optionsValues;
		}else{
			$dropDownObject->options = array();
		}

		return $dropDownObject;
	}

	private function getCheckBoxGroup($position,$sequence,$type)
	{
		
		$dropDownObject = new stdClass();
		$dropDownObject->sequeance_num=$sequence;
		$dropDownObject->ans_type=$type;
		$dropDown = $this->input->post("check_box_".$position);
		$dropDownId = $this->input->post("check_box_id_" . $position);
		$dropDownRequired = $this->input->post("ck_check_box_required_".$position);
		$dropDownOptions = $this->input->post("check_box_option_value_".$position);
		$dropDownObject->name = $dropDown;
		if ($dropDownId != null)
			$dropDownObject->id = $dropDownId;
		if ($dropDownRequired != null)
			$dropDownObject->is_required = $dropDownRequired == "on" ? 1 : 0;
		if ($dropDownOptions != null) {
			$options = explode(",", $dropDownOptions);
			$optionsValues = array();
			foreach ($options as $value) {
				if (!empty($value)) {
					array_push($optionsValues, $value);
				}
			}
			$dropDownObject->options = $optionsValues;
		}else{
			$dropDownObject->options = array();
		}

		return $dropDownObject;
	}

	public function getDepartmentSections(){
		$validationObject = $this->is_parameter(array("department_id"));
		if($validationObject->status){
			$param = $validationObject->param;
			$resultObject=$this->TemplateModel->fetchTemplateSections($param->department_id);
			$response["status"]=200;
			$response["body"]=$resultObject->data;
		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo  json_encode($response);
	}

	public function getSectionElements(){
		$validationObject = $this->is_parameter(array("department_id","section_id"));
		if($validationObject->status){
			$param = $validationObject->param;
			$resultObject=$this->TemplateModel->fetchSectionElement($param->section_id,$param->department_id);
			// print_r($resultObject);exit();
			$response["status"]=200;
			$response["body"]=$resultObject->data;
		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo  json_encode($response);
	}

	public function deleteSection(){
		$validationObject = $this->is_parameter(array("section_id"));
		if($validationObject->status){
			$param = $validationObject->param;
			$resultObject=$this->TemplateModel->deleteSection($param->section_id);
			if($resultObject->status){
				$response["data"]=$resultObject;
				$response["status"]=200;
				$response["body"]="Delete Section";
			}else{
				$response["status"]=200;
				$response["body"]="Fail To Delete";
			}

		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo  json_encode($response);
	}

	public function deleteTemplateElement(){
		$validationObject = $this->is_parameter(array("templateID"));
		if($validationObject->status){
			$param = $validationObject->param;
			$resultObject=$this->TemplateModel->deleteElement($param->templateID);
			if($resultObject->status){
				$response["data"]=$resultObject;
				$response["status"]=200;
				$response["body"]="Delete Element";
			}else{
				$response["status"]=200;
				$response["body"]="Fail To Delete";
			}

		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo  json_encode($response);
	}

	function gettemplatelist(){
		$query=$this->TemplateModel->getTemplateList();
		$option="<option value='-1'>Select Template</option>";
		if($query != false){

			foreach($query as $data){
				$option.="<option value=".$data->id.">".$data->name."</option>";
			}
			$response["status"]=200;
			$response["data"]=$option;
		}else{
			$response["status"]=201;
			$response["data"]=$option;
		}echo  json_encode($response);
	}
	function getSectionTemplateFormPersonal()
	{
		$department_id = $this->input->post('department_id');
		$patient_id = $this->input->post('patient_id');
		$section_id = $this->input->post('section_id');
		$branch_id = $this->session->user_session->branch_id;

		$query = $this->Formmodel->get_personalTemplate_form($department_id,$section_id);
		$data = "";
		$button_data = "";
		$template_name = "-";
		if ($query != false) {
			$patientResultObject = null;
			$patientObject = null;
			$active = 0;
			$field="";

			usort($query, function ($a, $b) {
				return (int)$a->seq_num > $b->seq_num;
			});

			foreach ($query as $value) {

				$activePanel = "show";
				$exapanded = "aria-expanded='true'";
				if ($active == 0) {
					$activePanel = "show";
					$exapanded = "aria-expanded='true'";
					$active = 1;
				}
				$section_id = $value->section_id;
				//		$section_status = $value->section_status;
				$is_traction = $value->is_traction;
				$is_history = $value->is_history;
				$tb_history = $value->tb_history;
				$template_name = $value->template_name;
				if ($patientResultObject == null) {
					$patientResultObject = $this->Formmodel->getPatientDetails($value->tb_name, array('patient_id' => $patient_id,'branch_id'=>$branch_id));
					if ($patientResultObject->totalCount > 0) {
						$patientObject = (array)$patientResultObject->data;

					}

				}


				//is_traction
				
				$data .='
				
				<div id="accordion_' . $section_id . '">
	<div class="accordion">
                        ';
				$querysec = $this->Formmodel->get_sectionform($section_id);
				if ($is_history == 1) {
					$btn1 = '<button type="button" id="history_btn_' . $section_id . '" class="btn btn-sm btn-outline-dark mx-1" onclick="view_history(\'' . $tb_history . '\',' . $section_id . ')"> <i class="fas fa-notes-medical"></i> view history</button>';
					$btn2 = '<button type="button" id="graph_btn_' . $section_id . '" class="btn btn-sm btn-outline-dark mx-1" style="display:none" onclick="view_graph(\'' . $value->section_name . '\',' . $section_id . ')"> <i class="fas fa-chart-line"></i> view graph</button>';
					$btn3 = '<button type="button" id="main_btn_' . $section_id . '" style="display:none" class="btn btn-sm btn-outline-dark mx-1" onclick="view_main_data(' . $section_id . ')"><i class="fab fa-wpforms"></i>View form</button>';
				} else {
					$btn1 = '';
					$btn3 = '';
					$btn2 = "";
				}

				$data .= '<div class="accordion-body collapse ' . $activePanel . '" id="panel-body' . $section_id . '" data-parent="#accordion_' . $section_id . '">';
				$data .= '<div class="row justify-content-end row">' . $btn3 . $btn1 . $btn2 . '</div>';
				$data .= '<div id="main_div_' . $section_id . '"> 
							<form id="data_form_' . $section_id . '" method="post" data-form-valid="save_form_data">
							<div class="">
									<input type="hidden"  name="department_id"
										   value="' . $department_id . '">
									<input type="hidden"  name="section_id"
										   value="' . $section_id . '">	   
									<input type="hidden" id="patient_id" name="patient_id"
										   value="' . $patient_id . '">
							
							';
						$weightfield = "";
						$heightfield = "";
				foreach ($querysec as $value1) {
					$patientValue = "";
					if ($patientObject != null) {
						if ($is_history != 1) {
							if (array_key_exists($value1->field_name, $patientObject)) {
								$patientValue = $patientObject[$value1->field_name];
							}
						}

						
						
						if ($value1->name == 'Weight (Kg)') {
						
							$weightfield = $value1->field_name;
							
						}
						if ($value1->name == 'Height (cm)') {
							$heightfield = $value1->field_name;
						}
						
						$w_val="";
						if (array_key_exists($weightfield, $patientObject)) {
							$w_val = $patientObject[$weightfield];
						}
						$h_val="";
						if (array_key_exists($heightfield, $patientObject)) {
							$h_val = ($patientObject[$heightfield]) / 100;
						}
					
						//echo $patientValue = round(($w_val / ($h_val * $h_val)), 2);
					
						if ($value1->name == 'BMI' && $h_val != '' && $w_val != '' && is_numeric($h_val) && is_numeric($w_val)) {
							
							$patientValue = round(($w_val / ($h_val * $h_val)), 2);
						}

					}
					$validation = "";
					if ((int)$value1->is_required == 1) {
						$validation = 'data-valid="required" data-msg="Please Fill this Field"';
					}


					if ($value1->ans_type == 1) {
						if ($value1->name == 'user id') {
							$disabled ="readonly";
							$patientValue= $this->session->user_session->id;

							$type="hidden";
							$lable = "d-none";
						}else{
							$disabled="";
							$type="text";
							$lable = "";

						}
						if((int)$value1->id == 179){
							$patientValue='Dr. Vivek Kumar';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold '.$lable.'"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">

					<input type="'.$type.'" class="form-control" '.$disabled.' id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' /></div>';


					} else if ($value1->ans_type == 10) {
						$order_id = $this->Global_model->generate_order($value1->custom_query);

						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="form_field' . $value1->id . '" value="' . $order_id . '"   name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' /></div>';
					}else if ($value1->ans_type == 11) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					';
					}else if ($value1->ans_type == 12) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$selected ="";
						$option ="";
						$selectedOptions = explode(",", $patientValue);
						foreach ($get_option as $option_value) {
							
							 foreach ($selectedOptions as $o_value) {
								if ($o_value == $option_value->name) {
									$selected = "checked";
									break;
								}
								else
								{
									$selected = "";
								}
							} 

							$option .= ' <input type="checkbox" '.$selected.' value="'.$option_value->name.'" name="form_field' . $value1->id . '[]" id="form_field' . $value1->id . '"> '.$option_value->name;
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;"> ' . $value1->name . '</label>
					<div class="col-sm-9">'.$option.'</div>
					';
					
					
					}else if ($value1->ans_type == 13) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$selected ="";
						$option ="";
						// print_r($patientValue);
						// $selectedOptions = explode(",", $patientValue);

						foreach ($get_option as $option_value) {
									
							 // foreach ($selectedOptions as $o_value) {

								if ($patientValue == $option_value->name) {
									// echo $option_value->name;
									$selected = "checked";
									// break;
								}
								else
								{
									$selected = "";
								}
							// } 

							$option .= ' <input type="radio" '.$selected.' value="'.$option_value->name.'" name="form_field' . $value1->id . '" id="form_field' . $value1->id . '"> '.$option_value->name;
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;"> ' . $value1->name . '</label>
					<div class="col-sm-9">'.$option.'</div>
					';
					
					
					} else if ($value1->ans_type == 6) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="number" class="form-control"id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '" ' . $validation . ' /></div>';
					} else if ($value1->ans_type == 5) {
						$isDate = '<script>
							var dt = new Date();   
   							var month = dt.getMonth()+1;
							var day = dt.getDate();
							var output = dt.getFullYear() + "-" +
    (month<10 ? "0" : "") + month + "-" +
    (day<10 ? "0" : "") + day+" 00:00:00";
//   var date=output+\"T\"+time;
   document.getElementById("form_field' . $value1->id . '").min = app.getDate(output);
					</script>';
						if((int)$value1->id == 83 || (int)$value1->id == 17){
							$isDate = "";
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="datetime-local" class="form-control" id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' />
					'.$isDate.'
					
					</div>';
					} else if ($value1->ans_type == 2) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<textarea id="form_field' . $value1->id . '" class="form-control"  name="form_field' . $value1->id . '" ' . $validation . '>' . $patientValue . '</textarea></div>';
					} else if ($value1->ans_type == 3) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$option = "<option value=''  selected disabled></option>";
						$selectedOptions = explode(",", $patientValue);

						foreach ($get_option as $option_value) {
							$selected = "";
							foreach ($selectedOptions as $o_value) {
								if ($o_value == $option_value->id) {
									$selected = "selected";
									break;
								}
							}

							$option .= '<option value="' . $option_value->id . '" ' . $selected . '>' . $option_value->name . '</option>';
						}
						$check_dependancy = $this->Formmodel->check_dependancy($value1->name, $section_id);

						$onchange = "";
						if ($check_dependancy != false) {
							$id = $check_dependancy;
							$id2 = "form_field" . $value1->id;
							$id3 = "append_div" . $value1->id;
							$onchange = "get_other_dropdown('$id','$id2','$id3')";
							$multiple = "";
						} else {
							$multiple = '';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9" >
					<select class="custom-select" id="form_field' . $value1->id . '"  onchange="' . $onchange . '" name="form_field' . $value1->id . '" ' . $validation . '>
							' . $option . '
									</select><script>$("#form_field' . $value1->id . '").select2()</script></div>';
					} else if ($value1->ans_type == 4) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$option = "<option value='' selected disabled></option>";
						$selectedOptions = explode(",", $patientValue);
						if(is_array($get_option)){
							foreach ($get_option as $option_value) {
								$selected = "";
								foreach ($selectedOptions as $o_value) {
									if ($o_value == $option_value->id) {
										$selected = "selected";
										break;
									}
								}
								$option .= '<option value="' . $option_value->id . '" ' . $selected . '>' . $option_value->name . '</option>';
							}
						}

						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<select class="form-control" multiple id="form_field' . $value1->id . '" name="form_field' . $value1->id . '[]" ' . $validation . '>
							' . $option . '
									</select> <script>$("#form_field' . $value1->id . '").select2()</script></div>';
					} else if ($value1->ans_type == 7) {
						if ($patientValue != "") {
							$patientValue = '<a href="' . base_url($patientValue) . '" class="btn btn-link" download><i class="fa fa-download"></i> Download</a>';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="file" name="form_field' . $value1->id . '[]" id="form_field' . $value1->id . '" class="form-control"  ' . $validation . '>
					' . $patientValue . '
					</div>';
					} else if ($value1->ans_type == 8) {
						$dependancy = $value1->dependancy;
						$option = "<option value='-1'>select option</option>";
						if ($dependancy == "") {
							$query = $value1->custom_query;

							/*$qr=$this->db->query($query);

							if($this->db->affected_rows() > 0){ */
							/* $res=$qr->result();
							foreach($res as  $val){

								$arr=array();
								foreach($val as $k => $v){

								$arr[]=$v;
								}

								$option .= "<option value='".$arr[0]."'>".$arr[1]."</option>";
							} */
							$check_dependancy = $this->Formmodel->check_dependancy($value1->name, $section_id);

							$onchange = "";
							if ($check_dependancy != false) {
								$id = $check_dependancy;
								$id2 = "form_field" . $value1->id;
								$id3 = "append_div" . $value1->id;
								$onchange = "get_other_dropdown('$id','$id2','$id3')";
								$multiple = "";
							} else {
								$multiple = '';
							}
							if ($value1->is_extended_template == 1) {
								$ext_template_id = $value1->ext_template_id;
								$dep_encode = urlencode(base64_encode($ext_template_id));
								$qren = base64_encode($query);
								$url = base_url() . "FormController/get_data?query=$qren";
								$field = '
								<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
								<div class="col-sm-9">
								<div class="align-items-center row">
								<div class="col-sm-11 mx-0 px-0">
										<select class="custom-select"  id="form_field' . $value1->id . '" name="form_field' . $value1->id . '" ' . $validation . '  onchange="' . $onchange . '">
										  ' . $option . '
										</select>
										</div>
									<div class="col-sm-1 mx-0 px-0">
									  <a class="btn btn-primary" href="' . base_url() . 'company/form_view/' . $dep_encode . '"><i class="fa fa-plus"></i></a>
									</div>
									</div>
						
                      			</div><script>$("#form_field' . $value1->id . '").select2(
									{
								  ajax: { 
								   url: "' . $url . '",
								   type: "post",
								   dataType: "json",
								   delay: 250,
								   data: function (params) {
									return {
									  searchTerm: params.term // search term
									};
								   },
								   processResults: function (response) {
									 return {
										results: response
									 };
								   },
								   cache: true
								  },
								  minimumInputLength: 3
								 }
									)</script>
								';
							} else {
								$qren = base64_encode($query);
								$url = base_url() . "FormController/get_data?query=$qren";
								$field = '

					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9" >
					<select data-check="1" class="form-control"  ' . $multiple . ' onchange="' . $onchange . '"  id="form_field' . $value1->id . '" name="form_field' . $value1->id . '" ' . $validation . '>
							
									</select> <script>$("#form_field' . $value1->id . '").select2(
									{
								  ajax: { 
								   url: "' . $url . '",
								   type: "post",
								   dataType: "json",
								   delay: 250,
								   data: function (params) {
									return {
									  searchTerm: params.term // search term
									};
								   },
								   processResults: function (response) {
									 return {
										results: response
									 };
								   },
								   cache: true
								  },
								  minimumInputLength: 3
								 }
									)</script></div>';

							}

							//}


						} else {
							$field = '';
						}
					}


					$data .= ' 
                      <div class="form-group row mb-3" >
						' . $field . '			
					  </div>
					  <div id="append_div' . $value1->id . '"></div>
                    ';
				}
				if ($is_traction == 1) {

					if ($is_history == 1) {
						$now = date('Y-m-d H:i:s');
						//$now = date('d-M-Y H:i A');
						// print_r($now);exit;
						$data .= ' 
                      <div class="form-group row mb-3">
                      		<label  class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">Date</label>
                      		<div class="col-sm-9">
							<input type="datetime-local" id="transaction_date' . $section_id . '" name="transaction_date' . $section_id . '" value="' . $now . '"  class="form-control" data-valid="required" data-msg="Please Fill this Field"></div>	
					  </div>
					  <script>
//						var dt = new Date();
//   var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
//   var month = dt.getMonth()+1;
//var day = dt.getDate();
//
//var output = dt.getFullYear() + "-" +
//    (month<10 ? "0" : "") + month + "-" +
//    (day<10 ? "0" : "") + day;
//   var date=output+"T"+time;
//   document.getElementById("transaction_date' . $section_id . '").min = date;
					  	let date = app.getDate("' . $now . '")
					  	$("#transaction_date' . $section_id . '").val(date);
					  </script>
                    ';
					}
				} else {

					if ($is_history == 1) {
						$now = date('Y-m-d\TH:i:sP');
						$now = date('Y-m-d H:i:s');
						$data .= ' 
                      <div class="form-group row mb-3">
                      		<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">Date</label>
                      		<div class="col-sm-9">
								<input type="datetime-local" id="transaction_date' . $section_id . '" name="transaction_date' . $section_id . '" value="' . $now . '" class="form-control" data-valid="required" data-msg="Please Fill this Field">		
							</div>
							<script>
//						var dt = new Date();
//   var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
//   var month = dt.getMonth()+1;
//var day = dt.getDate();
//
//var output = dt.getFullYear() + "-" +
//    (month<10 ? "0" : "") + month + "-" +
//    (day<10 ? "0" : "") + day;
//   var date=output+"T"+time;
//   document.getElementById("transaction_date' . $section_id . '").min = date;
	date = app.getDate("' . $now . '")
					  	$("#transaction_date' . $section_id . '").val(date);
					</script>
					  </div>
                    ';
					}
				}
				$data .= "</div><div class='text-right'>
									<button class='btn btn-primary mr-1' type='submit'>Submit
									</button>
									<button class='btn btn-secondary' type='reset'>Reset</button>
								</div></form></div>";

				$data .= "</div>
				<div id='history_div_" . $section_id . "' class='d-none'></div>
				<div id='graph_div_" . $section_id . "' class='d-none'>
						<div class='row' id='graph_section_" . $section_id . "'>
						
						</div>
				</div></div></div>
				 
       ";
			}
			$response["template_name"] = $template_name;
			$response['code'] = 200;
			$response['data'] = $data;
			$response['button_data'] = $button_data;
			
		} else {
			$response['code'] = 201;
			$response['data'] = '';
			$response['button_data'] = '';
		}


		echo json_encode($response);
	}

	function add_form_data()
	{
		// print_r($this->input->post());exit();
		$department_id = $this->input->post('department_id');
		$patient_id = $this->input->post('patient_id');
		$form_section_id = $this->input->post('section_id');
//		$company_id = $this->session->user_session->company_id;
		$get_data = $this->Formmodel->get_all_data($department_id,$form_section_id);

		if ($get_data != false) {
			$data_to_insert = array();
			foreach ($get_data as $value) {
				$id = $value->id;
				$ans_type = $value->ans_type;
				$tb_name = $value->tb_name;
				$field_name = $value->field_name;
				$name_input = "form_field" . $id;
				if ($ans_type == 7) {
					$upload_path = "uploads";
					$combination = 2;
					$result = $this->upload_file($upload_path, $name_input, $combination);
					if ($result->status) {
						if ($result->body[0] == "uploads/") {
							$input_data = "";
						} else {
							$input_data = $result->body[0];
						}

					} else {
						$input_data = "";
					}
				} else if ($ans_type == 4) {
					if (is_array($this->input->post($name_input))) {
						$input_data = implode(',', $this->input->post($name_input));
					} else {
						$input_data = $this->input->post($name_input);
					}

				} else if($ans_type == 12)
				{
					
					if (is_array($this->input->post($name_input))) {
						$input_data = implode(',', $this->input->post($name_input));
					} else {
						$input_data = $this->input->post($name_input);
					}


				}
				else {
					$input_data = $this->input->post($name_input);
				}

				if ($input_data != "") {
					$data_to_insert[$field_name] = $input_data;
				}
			}
			$data_to_insert["patient_id"] = $patient_id;
			$data_to_insert["trans_date"] = date('Y-m-d H:i:s');
			$data_to_insert["branch_id"] = $this->session->user_session->branch_id;

			try {
				$this->db->trans_start();
				$check_patient_availabel = $this->Formmodel->check_patient_availabel($patient_id, $tb_name);
				if ($check_patient_availabel == true) {
					$this->db->where('patient_id', $patient_id);
					$insert = $this->db->update($tb_name, $data_to_insert);
				} else {
					$insert = $this->db->insert($tb_name, $data_to_insert);
					// $insert=true;
				}
				if ($insert == true) {
					//insert data into history table if history unable
					$query = $this->Formmodel->get_form($department_id);

					if ($query != false) {
						foreach ($query as $value) {
							$section_id = $value->section_id;
							if ($form_section_id == $section_id) {
								$tb_history = $value->tb_history;
								$is_history = $value->is_history;
								$is_trans = $value->is_traction;
								$transDate = 'transaction_date' . $section_id;
								if ($is_history == 1) {
									$get_data_section = $this->Formmodel->get_section_data($department_id, $section_id);
									if ($get_data_section != false) {
										$section_array = array();
										foreach ($get_data_section as $row) {
											$f_name = $row->field_name;
											$get_data_from_table = $this->Formmodel->get_data_from_table($f_name, $tb_name, $patient_id);
											if ($get_data_from_table != false) {
												$section_array[$f_name] = $get_data_from_table;
											}
										}
										$section_array["branch_id"] = $this->session->user_session->branch_id;
										$section_array["patient_id"] = $patient_id;
										//echo $this->input->post($transDate);
										if ((int)$is_trans == 1) {
											if (!is_null($this->input->post($transDate))) {
											//	echo 1;
												$section_array["trans_date"] = $this->input->post($transDate);
												$data_to_insert["trans_date"] = $this->input->post($transDate);
												$response['trans1'][]=$this->input->post($transDate);
											}else{
											//	echo 2;
												$section_array["trans_date"] = date('Y-m-d H:i:s');
												$data_to_insert["trans_date"] = date('Y-m-d H:i:s');
												$response['trans1'][]=date('Y-m-d H:i:s');;
											}

										} else {
											if (is_null($this->input->post($transDate))) {
											//	echo 3;
												$section_array["trans_date"] = date('Y-m-d H:i:s');
												$data_to_insert["trans_date"] = date('Y-m-d H:i:s');
												$response['trans0'][]=date('Y-m-d H:i:s');
											} else {
												//echo 4;
												$section_array["trans_date"] = $this->input->post($transDate);
												$data_to_insert["trans_date"] = $this->input->post($transDate);
												$response['trans0'][]=$this->input->post($transDate);;
											}

										}
										
										$this->db->insert($tb_history, $data_to_insert);
									}
								}
							}
						}
					}
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['code'] = 201;
				} else {
					$this->db->trans_commit();
					$response['code'] = 200;
				}
				$this->db->trans_complete();
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				$response['code'] = 201;
			}
		} else {
			$response['code'] = 201;
		}
		echo json_encode($response);
	}

	function get_form_fields()
	{
		$department_id = $this->input->post('department_id');
		$patient_id = $this->input->post('patient_id');

		$query = $this->Formmodel->get_form($department_id);
		$data = "";
		$button_data = "";
		$template_name = "-";
		if ($query != false) {
			$patientResultObject = null;
			$patientObject = null;
			$active = 0;
			$field="";

			usort($query, function ($a, $b) {
				return (int)$a->seq_num > $b->seq_num;
			});

			foreach ($query as $value) {

				$activePanel = "show";
				$exapanded = "aria-expanded='true'";
				if ($active == 0) {
					$activePanel = "show";
					$exapanded = "aria-expanded='true'";
					$active = 1;
				}
				$section_id = $value->section_id;
				//		$section_status = $value->section_status;
				$is_traction = $value->is_traction;
				$is_history = $value->is_history;
				$tb_history = $value->tb_history;
				$template_name = $value->template_name;
				if ($patientResultObject == null) {
					$patientResultObject = $this->Formmodel->getPatientDetails($value->tb_name, array('patient_id' => $patient_id));
					if ($patientResultObject->totalCount > 0) {
						$patientObject = (array)$patientResultObject->data;

					}

				}


				//is_traction
				$button_data .= '
				<button id="persTemModalBtn_' . $section_id . '" class="btn btn-primary myBtn mt-2" data-toggle="modal" data-target="#persTemModal_' . $section_id . '">' . $value->section_name . '</button>';
				$data .='
				  <div id="persTemModal_' . $section_id . '" class="modal" >
				  <div class="modal-dialog modal-xl">
				      <div class="modal-content">
				        <div class="modal-header modal_header">
				         
				          <h4 class="modal-title">' . $value->section_name . '</h4>
				           <button type="button" class="close modal_close" data-dismiss="modal">&times;</button>
				        </div>
				        <div class="modal-body">
				<div id="accordion_' . $section_id . '">
	<div class="accordion">
                        ';
				$querysec = $this->Formmodel->get_sectionform($section_id);
				if ($is_history == 1) {
					$btn1 = '<button type="button" id="history_btn_' . $section_id . '" class="btn btn-sm btn-outline-dark mx-1" onclick="view_history(\'' . $tb_history . '\',' . $section_id . ')"> <i class="fas fa-notes-medical"></i> view history</button>';
					$btn2 = '<button type="button" id="graph_btn_' . $section_id . '" class="btn btn-sm btn-outline-dark mx-1" style="display:none" onclick="view_graph(\'' . $value->section_name . '\',' . $section_id . ')"> <i class="fas fa-chart-line"></i> view graph</button>';
					$btn3 = '<button type="button" id="main_btn_' . $section_id . '" style="display:none" class="btn btn-sm btn-outline-dark mx-1" onclick="view_main_data(' . $section_id . ')"><i class="fab fa-wpforms"></i>View form</button>';
				} else {
					$btn1 = '';
					$btn3 = '';
					$btn2 = "";
				}

				$data .= '<div class="accordion-body collapse ' . $activePanel . '" id="panel-body' . $section_id . '" data-parent="#accordion_' . $section_id . '">';
				$data .= '<div class="row justify-content-end row">' . $btn3 . $btn1 . $btn2 . '</div>';
				$data .= '<div id="main_div_' . $section_id . '"> 
							<form id="data_form_' . $section_id . '" method="post" data-form-valid="save_form_data">
							<div class="">
									<input type="hidden"  name="department_id"
										   value="' . $department_id . '">
									<input type="hidden"  name="section_id"
										   value="' . $section_id . '">	   
									<input type="hidden" id="patient_id" name="patient_id"
										   value="' . $patient_id . '">
							
							';
						$weightfield = "";
						$heightfield = "";
				foreach ($querysec as $value1) {
					$patientValue = "";
					if ($patientObject != null) {
						if ($is_history != 1) {
							if (array_key_exists($value1->field_name, $patientObject)) {
								$patientValue = $patientObject[$value1->field_name];
							}
						}

						
						
						if ($value1->name == 'Weight (Kg)') {
						
							$weightfield = $value1->field_name;
							
						}
						if ($value1->name == 'Height (cm)') {
							$heightfield = $value1->field_name;
						}
						
						$w_val="";
						if (array_key_exists($weightfield, $patientObject)) {
							$w_val = $patientObject[$weightfield];
						}
						$h_val="";
						if (array_key_exists($heightfield, $patientObject)) {
							$h_val = ($patientObject[$heightfield]) / 100;
						}
					
						//echo $patientValue = round(($w_val / ($h_val * $h_val)), 2);
					
						if ($value1->name == 'BMI' && $h_val != '' && $w_val != '' && is_numeric($h_val) && is_numeric($w_val)) {
							
							$patientValue = round(($w_val / ($h_val * $h_val)), 2);
						}

					}
					$validation = "";
					if ((int)$value1->is_required == 1) {
						$validation = 'data-valid="required" data-msg="Please Fill this Field"';
					}


					if ($value1->ans_type == 1) {
						if ($value1->name == 'user id') {
							$disabled ="readonly";
							$patientValue= $this->session->user_session->id;

							$type="hidden";
							$lable = "d-none";
						}else{
							$disabled="";
							$type="text";
							$lable = "";

						}
						if((int)$value1->id == 179){
							$patientValue='Dr. Vivek Kumar';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold '.$lable.'"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">

					<input type="'.$type.'" class="form-control" '.$disabled.' id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' /></div>';


					} else if ($value1->ans_type == 10) {
						$order_id = $this->Global_model->generate_order($value1->custom_query);

						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="text" class="form-control" id="form_field' . $value1->id . '" value="' . $order_id . '"   name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' /></div>';
					}else if ($value1->ans_type == 11) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					';
					}else if ($value1->ans_type == 12) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$selected ="";
						$option ="";
						$selectedOptions = explode(",", $patientValue);
						foreach ($get_option as $option_value) {
							
							 foreach ($selectedOptions as $o_value) {
								if ($o_value == $option_value->name) {
									$selected = "checked";
									break;
								}
								else
								{
									$selected = "";
								}
							} 

							$option .= ' <input type="checkbox" '.$selected.' value="'.$option_value->name.'" name="form_field' . $value1->id . '[]" id="form_field' . $value1->id . '"> '.$option_value->name;
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;"> ' . $value1->name . '</label>
					<div class="col-sm-9">'.$option.'</div>
					';
					
					
					}else if ($value1->ans_type == 13) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$selected ="";
						$option ="";
						// print_r($patientValue);
						// $selectedOptions = explode(",", $patientValue);

						foreach ($get_option as $option_value) {
									
							 // foreach ($selectedOptions as $o_value) {

								if ($patientValue == $option_value->name) {
									// echo $option_value->name;
									$selected = "checked";
									// break;
								}
								else
								{
									$selected = "";
								}
							// } 

							$option .= ' <input type="radio" '.$selected.' value="'.$option_value->name.'" name="form_field' . $value1->id . '" id="form_field' . $value1->id . '"> '.$option_value->name;
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;"> ' . $value1->name . '</label>
					<div class="col-sm-9">'.$option.'</div>
					';
					
					
					} else if ($value1->ans_type == 6) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="number" class="form-control"id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '" ' . $validation . ' /></div>';
					} else if ($value1->ans_type == 5) {
						$isDate = '<script>
							var dt = new Date();   
   							var month = dt.getMonth()+1;
							var day = dt.getDate();
							var output = dt.getFullYear() + "-" +
    (month<10 ? "0" : "") + month + "-" +
    (day<10 ? "0" : "") + day+" 00:00:00";
//   var date=output+\"T\"+time;
   document.getElementById("form_field' . $value1->id . '").min = app.getDate(output);
					</script>';
						if((int)$value1->id == 83 || (int)$value1->id == 17){
							$isDate = "";
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="datetime-local" class="form-control" id="form_field' . $value1->id . '" value="' . $patientValue . '" name="form_field' . $value1->id . '" placeholder="' . $value1->placeholder . '"  ' . $validation . ' />
					'.$isDate.'
					
					</div>';
					} else if ($value1->ans_type == 2) {
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<textarea id="form_field' . $value1->id . '" class="form-control"  name="form_field' . $value1->id . '" ' . $validation . '>' . $patientValue . '</textarea></div>';
					} else if ($value1->ans_type == 3) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$option = "<option value=''  selected disabled></option>";
						$selectedOptions = explode(",", $patientValue);

						foreach ($get_option as $option_value) {
							$selected = "";
							foreach ($selectedOptions as $o_value) {
								if ($o_value == $option_value->id) {
									$selected = "selected";
									break;
								}
							}

							$option .= '<option value="' . $option_value->id . '" ' . $selected . '>' . $option_value->name . '</option>';
						}
						$check_dependancy = $this->Formmodel->check_dependancy($value1->name, $section_id);

						$onchange = "";
						if ($check_dependancy != false) {
							$id = $check_dependancy;
							$id2 = "form_field" . $value1->id;
							$id3 = "append_div" . $value1->id;
							$onchange = "get_other_dropdown('$id','$id2','$id3')";
							$multiple = "";
						} else {
							$multiple = '';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9" >
					<select class="custom-select" id="form_field' . $value1->id . '"  onchange="' . $onchange . '" name="form_field' . $value1->id . '" ' . $validation . '>
							' . $option . '
									</select><script>$("#form_field' . $value1->id . '").select2()</script></div>';
					} else if ($value1->ans_type == 4) {
						$get_option = $this->Formmodel->get_all_options($value1->id);
						$option = "<option value='' selected disabled></option>";
						$selectedOptions = explode(",", $patientValue);
						if(is_array($get_option)){
							foreach ($get_option as $option_value) {
								$selected = "";
								foreach ($selectedOptions as $o_value) {
									if ($o_value == $option_value->id) {
										$selected = "selected";
										break;
									}
								}
								$option .= '<option value="' . $option_value->id . '" ' . $selected . '>' . $option_value->name . '</option>';
							}
						}

						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<select class="form-control" multiple id="form_field' . $value1->id . '" name="form_field' . $value1->id . '[]" ' . $validation . '>
							' . $option . '
									</select> <script>$("#form_field' . $value1->id . '").select2()</script></div>';
					} else if ($value1->ans_type == 7) {
						if ($patientValue != "") {
							$patientValue = '<a href="' . base_url($patientValue) . '" class="btn btn-link" download><i class="fa fa-download"></i> Download</a>';
						}
						$field = '
					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9">
					<input type="file" name="form_field' . $value1->id . '[]" id="form_field' . $value1->id . '" class="form-control"  ' . $validation . '>
					' . $patientValue . '
					</div>';
					} else if ($value1->ans_type == 8) {
						$dependancy = $value1->dependancy;
						$option = "<option value='-1'>select option</option>";
						if ($dependancy == "") {
							$query = $value1->custom_query;

							/*$qr=$this->db->query($query);

							if($this->db->affected_rows() > 0){ */
							/* $res=$qr->result();
							foreach($res as  $val){

								$arr=array();
								foreach($val as $k => $v){

								$arr[]=$v;
								}

								$option .= "<option value='".$arr[0]."'>".$arr[1]."</option>";
							} */
							$check_dependancy = $this->Formmodel->check_dependancy($value1->name, $section_id);

							$onchange = "";
							if ($check_dependancy != false) {
								$id = $check_dependancy;
								$id2 = "form_field" . $value1->id;
								$id3 = "append_div" . $value1->id;
								$onchange = "get_other_dropdown('$id','$id2','$id3')";
								$multiple = "";
							} else {
								$multiple = '';
							}
							if ($value1->is_extended_template == 1) {
								$ext_template_id = $value1->ext_template_id;
								$dep_encode = urlencode(base64_encode($ext_template_id));
								$qren = base64_encode($query);
								$url = base_url() . "FormController/get_data?query=$qren";
								$field = '
								<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
								<div class="col-sm-9">
								<div class="align-items-center row">
								<div class="col-sm-11 mx-0 px-0">
										<select class="custom-select"  id="form_field' . $value1->id . '" name="form_field' . $value1->id . '" ' . $validation . '  onchange="' . $onchange . '">
										  ' . $option . '
										</select>
										</div>
									<div class="col-sm-1 mx-0 px-0">
									  <a class="btn btn-primary" href="' . base_url() . 'company/form_view/' . $dep_encode . '"><i class="fa fa-plus"></i></a>
									</div>
									</div>
						
                      			</div><script>$("#form_field' . $value1->id . '").select2(
									{
								  ajax: { 
								   url: "' . $url . '",
								   type: "post",
								   dataType: "json",
								   delay: 250,
								   data: function (params) {
									return {
									  searchTerm: params.term // search term
									};
								   },
								   processResults: function (response) {
									 return {
										results: response
									 };
								   },
								   cache: true
								  },
								  minimumInputLength: 3
								 }
									)</script>
								';
							} else {
								$qren = base64_encode($query);
								$url = base_url() . "FormController/get_data?query=$qren";
								$field = '

					<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">' . $value1->name . '</label>
					<div class="col-sm-9" >
					<select data-check="1" class="form-control"  ' . $multiple . ' onchange="' . $onchange . '"  id="form_field' . $value1->id . '" name="form_field' . $value1->id . '" ' . $validation . '>
							
									</select> <script>$("#form_field' . $value1->id . '").select2(
									{
								  ajax: { 
								   url: "' . $url . '",
								   type: "post",
								   dataType: "json",
								   delay: 250,
								   data: function (params) {
									return {
									  searchTerm: params.term // search term
									};
								   },
								   processResults: function (response) {
									 return {
										results: response
									 };
								   },
								   cache: true
								  },
								  minimumInputLength: 3
								 }
									)</script></div>';

							}

							//}


						} else {
							$field = '';
						}
					}


					$data .= ' 
                      <div class="form-group row mb-3" >
						' . $field . '			
					  </div>
					  <div id="append_div' . $value1->id . '"></div>
                    ';
				}
				if ($is_traction == 1) {

					if ($is_history == 1) {
						$now = date('Y-m-d H:i:s');
						//$now = date('d-M-Y H:i A');
						// print_r($now);exit;
						$data .= ' 
                      <div class="form-group row mb-3">
                      		<label  class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">Date</label>
                      		<div class="col-sm-9">
							<input type="datetime-local" id="transaction_date' . $section_id . '" name="transaction_date' . $section_id . '" value="' . $now . '"  class="form-control" data-valid="required" data-msg="Please Fill this Field"></div>	
					  </div>
					  <script>
//						var dt = new Date();
//   var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
//   var month = dt.getMonth()+1;
//var day = dt.getDate();
//
//var output = dt.getFullYear() + "-" +
//    (month<10 ? "0" : "") + month + "-" +
//    (day<10 ? "0" : "") + day;
//   var date=output+"T"+time;
//   document.getElementById("transaction_date' . $section_id . '").min = date;
					  	let date = app.getDate("' . $now . '")
					  	$("#transaction_date' . $section_id . '").val(date);
					  </script>
                    ';
					}
				} else {

					if ($is_history == 1) {
						$now = date('Y-m-d\TH:i:sP');
						$now = date('Y-m-d H:i:s');
						$data .= ' 
                      <div class="form-group row mb-3">
                      		<label class="col-sm-3 col-form-label font-weight-bold"  style="font-size: medium; color: brown;">Date</label>
                      		<div class="col-sm-9">
								<input type="datetime-local" id="transaction_date' . $section_id . '" name="transaction_date' . $section_id . '" value="' . $now . '" class="form-control" data-valid="required" data-msg="Please Fill this Field">		
							</div>
							<script>
//						var dt = new Date();
//   var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
//   var month = dt.getMonth()+1;
//var day = dt.getDate();
//
//var output = dt.getFullYear() + "-" +
//    (month<10 ? "0" : "") + month + "-" +
//    (day<10 ? "0" : "") + day;
//   var date=output+"T"+time;
//   document.getElementById("transaction_date' . $section_id . '").min = date;
	date = app.getDate("' . $now . '")
					  	$("#transaction_date' . $section_id . '").val(date);
					</script>
					  </div>
                    ';
					}
				}
				$data .= "</div><div class='text-right'>
									<button class='btn btn-primary mr-1' type='submit'>Submit
									</button>
									<button class='btn btn-secondary' type='reset'>Reset</button>
								</div></form></div>";

				$data .= "</div>
				<div id='history_div_" . $section_id . "' class='d-none'></div>
				<div id='graph_div_" . $section_id . "' class='d-none'>
						<div class='row' id='graph_section_" . $section_id . "'>
						
						</div>
				</div></div></div>
				 
          
        </div>
      </div>
      </div>
    </div>";
			}
			$response["template_name"] = $template_name;
			$response['code'] = 200;
			$response['data'] = $data;
			$response['button_data'] = $button_data;
			
		} else {
			$response['code'] = 201;
			$response['data'] = '';
			$response['button_data'] = '';
		}


		echo json_encode($response);
	}

}
