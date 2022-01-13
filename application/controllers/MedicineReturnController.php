<?php

include_once 'HexaController.php';

/**
 * @property  MedicineOrderModel MedicineOrderModel
 * @property  Global_model Global_model
 */
class MedicineReturnController extends HexaController
{


	/**
	 * MedicineOrderController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("MedicineOrderModel");
		$this->load->model("Global_model");
	}

	public function index()
	{
		$this->load->view("medicine_order/view_pharmeasy", array("title" => "Dashboard"));
	}

	function getReturnMedicineTable()
	{
		$medicineArray = array();
		if (!is_null($this->input->post("patient_id"))) {
			$patient_id = $this->input->post("patient_id");
			$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;
			$patient_medicine_table = $this->session->user_session->patient_mediine_table;
			$branch_id = $this->session->user_session->branch_id;
			$tableName='com_1_medicine_order';
			$resultObject = $this->MedicineOrderModel->_select($tableName, array("status" => 1, "patient_id" => $patient_id,"branch_id"=>$branch_id),
				array("*", "(select name from medicine_master m  where  m.id =medicine_id) as medicine_name"), false);
			// print_r($patient_medicine_history_table);exit();
			if ($resultObject->totalCount > 0) {
				 // print_r($resultObject->data);exit();
				$balance=0;
				foreach ($resultObject->data as $medicine) {
					$medicineScheduleExist = $this->MedicineOrderModel->_select($patient_medicine_table, array("name"=>$medicine->medicine_id,"status" => 1, "p_id" => $patient_id,"branch_id"=>$branch_id),
				array("*"), true);
				if ($medicineScheduleExist->totalCount > 0) {
					$user_quantity=0;
					$medicineResultObject =$this->MedicineOrderModel
						->_rawQuery("select id from ".$patient_medicine_history_table." where does_details_id in (select id from ".$patient_medicine_table." where name=".$medicine->medicine_id." and p_id=".$patient_id." and branch_id=".$branch_id." and status=1)");
//					 $this->MedicineOrderModel->_select($patient_medicine_history_table, array("does_details_id" => $medicine->medicine_id,"p_id" => $patient_id), array("*"),false);
					// echo $this->db->last_query();
					// $this->MedicineOrderModel->getMedicineHistoryData($patient_medicine_table,);
					// var_dump($medicineResultObject);exit();


					if ($medicineResultObject->totalCount > 0) {
								$user_quantity = $medicineResultObject->totalCount;
							}
					$return_quantity = $medicine->return_quantity ==null ? 0 : $medicine->return_quantity;
					$bu = $medicine->required_bu ==null ? 0 : $medicine->required_bu;

					$balance=$bu-$user_quantity- $return_quantity;

					$medicine_name=$medicine->medicine_name.' ( T='.$bu.' / U='.$user_quantity.' / R='.$return_quantity.' / B ='.$balance.' )';
					$medicineDetails = array(
						$medicine_name,
						$medicine->id,
						$medicine->medicine_id,
						$patient_id,
						$balance
					);
					array_push($medicineArray, $medicineDetails);
				}
				}
				$results = array(
					"draw" => (int)$_POST['draw'],
					"recordsTotal" => count($medicineArray),
					"recordsFiltered" => count($medicineArray),
					"data" => $medicineArray
				);
			} else {
				$results = array(
					"draw" => (int)$_POST['draw'],
					"recordsTotal" => count($medicineArray),
					"recordsFiltered" => count($medicineArray),
					"data" => $medicineArray
				);
			}
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => count($medicineArray),
				"recordsFiltered" => count($medicineArray),
				"data" => $medicineArray
			);
		}
		echo json_encode($results);
	}
	
	public function returnMedicineForm()
	{
			
			$med_id = $this->input->post('med_id');
			if (($med_id) == "") {
				$response["status"] = 201;
				$response["body"] = "Select Medicine";
				echo json_encode($response);
				exit;
			}
			
			$create_by = $this->session->user_session->id;

			// set table name
			$medicineTable = $this->session->user_session->patient_mediine_table;
			$medicionOrderTable = "com_1_medicine_order";
			
				try {
					$this->db->trans_start();

						foreach ($med_id as $medicine){
							$return_quantity=0;
							$medicineResultObject = $this->MedicineOrderModel->_select($medicionOrderTable, array('id' => $medicine), array("return_quantity"));
							if ($medicineResultObject->totalCount > 0) {
										$return_quantity = $medicineResultObject->data->return_quantity;
										
									}
							$schedule_return_quantity =$return_quantity+ $this->input->post("return_medicine_".$medicine);

							$scheduleMedicine = array('return_quantity' =>$schedule_return_quantity,
													  'return_status'=>1,
													  'return_by'=>$create_by,
													  'return_on'=>date('Y-m-d H:i:s'));
							$where = array('id' => $medicine );
							 // print_r($scheduleMedicine);
							$this->db->where($where);
							$this->db->update($medicionOrderTable,$scheduleMedicine);

						}
						
					// exit();
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$result = FALSE;
					} else {
						$this->db->trans_commit();
						$result = TRUE;
					}
					$this->db->trans_complete();
				} catch (Exception $exception) {
					$this->db->trans_rollback();
					$result = FALSE;
				}

				if ($result) {
					$response["status"] = 200;
					$response["body"] = "Medicine Return Request Successfully";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed To Return Request";
				}

			
		
		echo json_encode($response);
	}

}
