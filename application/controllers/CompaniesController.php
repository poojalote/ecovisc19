<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'HexaController.php';

/**
 * @property  Company_model Company_model
 * @property  DepartmentModel DepartmentModel
 */
class CompaniesController extends HexaController
{


	/**
	 * CompaniesController constructor.

	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Company_model");
	}

	function uploadCompany(){

		$validationObject = $this->is_parameter(array("company_name"));
		if($validationObject->status){
			$param=$validationObject->param;

			$company_name = $param->company_name;
			$company_id = $this->input->post("forward_company");
			$isBedManagement = $this->input->post("bed_management");
			$isMedicineManagement = $this->input->post("medicine_management");
			$isBed =0;
			$isMedicine=0;
			if(!is_null($isBedManagement)){
				$isBed = $isBedManagement == "on" ? 1:0;
			}
			if(!is_null($isMedicineManagement)){
				$isMedicine = $isMedicineManagement == "on" ? 1:0;
			}

			if(!is_null($company_id)){
				// update company
				$company = array("name"=>$company_name,"create_on" => date("Y-m-d"),"create_by"=>$this->session->user_session->id);
				if($this->Company_model->saveCompany($company,$isBed,$isMedicine,$company_id)){
					$response["status"]=200;
					$response["body"]="Save Changes";
				}else{
					$response["status"]=201;
					$response["body"]="Failed To Save Company";
				}
			}else{
				// new company
				$company = array("name"=>$company_name,"create_on" => date("Y-m-d"),"create_by"=>$this->session->user_session->id);

				if($this->Company_model->saveCompany($company,$isBed,$isMedicine)){
					$response["status"]=200;
					$response["body"]="Save Changes";
				}else{
					$response["status"]=201;
					$response["body"]="Failed To Save Company";
				}
			}
		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo json_encode($response);
	}


	function getCompanyTableData(){

		$tableName="company_master";
		$where = array();
		$order = array('create_on' => 'asc');
		$column_order = array('name');
		$column_search = array("name");
		$select = array("*");

		$memData = $this->Company_model->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);
		$results_last_query = $this->db->last_query();
		$filterCount = $this->Company_model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->Company_model->countAll($tableName, $where);

		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$tableRows[] = array(
					$row->name,
					$row->status,
					$row->id,
				);
			}
			$results = array(
				"draw" => (int)isset($_POST['draw']),
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)isset($_POST['draw']),
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $memData

			);
		}
		echo json_encode($results);
	}

	function getCompanyDataById(){

		$validationObject = $this->is_parameter(array('companyId'));
		if($validationObject->status){
			$company_id= $validationObject->param->companyId;

			$companyObject=$this->Company_model->_select("company_master",array('id'=>$company_id,"status"=>1));
			if($companyObject->totalCount > 0){
				$response["status"]=200;
				$response["body"]=$companyObject->data;
			}else{
				$response["status"]=201;
				$response["body"]="Not Found";
			}
		}else{
			$response["status"]=201;
			$response["body"]="Missing Parameter";
		}
		echo json_encode($response);
	}

	function ChangeCompanyStatus()
	{
		$validationObject = $this->is_parameter(array('companyId','status'));
		if ($validationObject->status) {
			$company_id = $validationObject->param->companyId;
			$status = $validationObject->param->status;
			$companyObject=$this->Company_model->_update("company_master",array("status"=>$status),array('id'=>$company_id,"status"=>1));
			if($companyObject->status){
				$response["status"]=200;
				$response["body"]="Save Change";
			}else{
				$response["status"]=201;
				$response["body"]="Failed To Save Changes";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}


}
