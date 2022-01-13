<?php

include_once 'MasterModel.php';


class MedicineOrderModel extends MasterModel
{


	public function getPatients($patientTable,$date)
	{

			return $this->_select("com_1_medicine_order o", array("o.order_status" => 1,"confirm_status"=>1, "status" => 1, "branch_id" => $this->session->user_session->branch_id,"create_on >="=>date($date)),

			array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id and (p.discharge_date is null or p.discharge_date='0000-00-00 00:00:00')) as patient_name", "o.patient_id"), false, "o.patient_id");

			// array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id AND (p.discharge_date is null OR p.discharge_date='0000:00:00 00:00:00')) as patient_name", "o.patient_id"), false, "o.patient_id");

	}

	public function getConsumablePatients($patientTable,$date)
	{

			return $this->_select("com_1_consumable_material_item_table o", array("o.order_status" => 1, "status" => 1, "branch_id" => $this->session->user_session->branch_id,"order_create_date >="=>date($date)),

			array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id and (p.discharge_date is null or p.discharge_date='0000-00-00 00:00:00')) as patient_name", "o.patient_id"), false, "o.patient_id");

			// array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id AND (p.discharge_date is null OR p.discharge_date='0000:00:00 00:00:00')) as patient_name", "o.patient_id"), false, "o.patient_id");

	}

	public function getReturnOrderPatients($patientTable)
	{

		return $this->_select("com_1_medicine_order o", array("o.return_status" => 1, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select group_concat(p.patient_name,' ',p.adhar_no) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id"), false, "o.patient_id");
	}
	
	

	public function getApprovedPatients($patientTable)
	{

		return $this->_select("com_1_medicine_order o", array("o.order_status" => 2, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select (p.patient_name) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id", 'o.order_id'), false, "o.patient_id,o.order_id");
	}
	
	public function getApprovedConsumablePatients($patientTable)
	{

		return $this->_select("com_1_consumable_material_item_table o", array("o.order_status" => 2, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select (p.patient_name) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id", 'o.order_id'), false, "o.patient_id,o.order_id");
	}
	public function getApprovedReturnPatients($patientTable)
	{

		return $this->_select("com_1_medicine_order o", array("o.return_status" => 2, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select (p.patient_name) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id", 'o.order_id'), false, "o.patient_id,o.order_id");
	}
	public function getHistoryReturnPatients($patientTable)
	{

		return $this->_select("com_1_medicine_order o", array("o.order_id!="=>null, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select (p.patient_name) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id", 'o.order_id'), false, "o.patient_id,o.order_id");
	}

	public function getHistoryConsumablePatients($patientTable)
	{
		return $this->_select("com_1_consumable_material_item_table o", array("o.order_id!="=>null, "status" => 1, "branch_id" => $this->session->user_session->branch_id),
			array("(select (p.patient_name) from " . $patientTable . " p where p.id=o.patient_id) as patient_name", "o.patient_id", 'o.order_id'), false, "o.patient_id,o.order_id");
	}
	public function getOrdersByPatient($patient_id,$date)
	{

		return $this->_select("com_1_medicine_order o", array("o.order_status" => 1, "patient_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id,"create_on >="=>date($date)),
			array("o.*","(select 
group_concat(total_iteration,'||',remark,'||',flowRate_chk,'||',
(case when flowRate_text is null or flowRate_text ='' then -1 else flowRate_text end),'||',
(case when route is null or route ='' then -1 else route end),'||',
(case when quantity is null or quantity ='' then -1 else quantity end),'||',m.active
) 
from com_1_medicine m where m.name=o.medicine_id and m.p_id=o.patient_id ) as medicine_data"), false);
	}
	public function getHospOrdersByPatient($zone_id,$order_id)
	{

		return $this->_select("hospital_material_item_table o", array("material_order_id"=>$order_id,"is_supplied"=>0,"is_return"=>0),
			array("o.*","(select department from hospital_order_management m where m.id=o.material_order_id) as department",
			"(select group_name from hospital_material_group g where g.id=
			(select material_group_id from hospital_order_management m where m.id=o.material_order_id)) as group_name"), false);
	}
	public function getOrdersReturnByhospital($order_no){
		return $this->_select("hospital_material_item_table o", array("material_order_id"=>$order_no,"is_return"=>1,"return_accepted"=>0),
			array("o.*","(select department from hospital_order_management m where m.id=o.material_order_id) as department",
			"(select group_name from hospital_material_group g where g.id=
			(select material_group_id from hospital_order_management m where m.id=o.material_order_id)) as group_name"), false);
	}

	public function getConsumableOrdersByPatient($patient_id,$date)
	{
		return $this->_select("com_1_consumable_material_item_table o", array("o.order_status" => 1, "patient_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id,"order_create_date >="=>date($date)),
			"*", false);
	}

	public function getOrdersReturnByPatient($patient_id)
	{

		return $this->_select("com_1_medicine_order o", array("o.return_status" => 1, "patient_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id),
			"*", false);
	}

	public function getApprovedOrdersByPatient($patient_id)
	{

		return $this->_select("com_1_medicine_order o", array("o.order_status" => 2, "order_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id),
			"*", false);
	}

	public function getApprovedConsumableOrdersByPatient($patient_id)
	{
		return $this->_select("com_1_consumable_material_item_table o", array("o.order_status" => 2, "order_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id),
			"*", false);
	}
	public function getApprovedReturnOrdersByPatient($patient_id)
	{

		return $this->_select("com_1_medicine_order o", array("o.return_status" => 2, "order_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id),
			"*", false);
	}

	public function saveOrder($patient_id, $medicines, $updateData, $alt_medicine, $receiver, $billingTransactionTable, $supply_quantity,$mode,$supply_medicine_total,$mcgm)
	{$medicineUpdateData=array();
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();

			foreach ($medicines as $medicine1) {
				$medicineData = explode("_",$medicine1);
				if(count($medicineData)!=2){
					$medicine=$medicine1;
				}else{
					$medicine = $medicineData[0];
				}
				$newMedicineOrder = null;

				if (count($alt_medicine) > 0) {
					$updateData["alt_medicine"] = $alt_medicine[$medicine];
				}

				if (count($supply_quantity) > 0) {
					$supply_quan = $supply_quantity[$medicine];
					$medicineResult = $this->db
						->where(array("patient_id" => $patient_id, "id" => $medicine, "supplied_by_pharmeasy" => 0, "branch_id" => $this->session->user_session->branch_id))
						->get("com_1_medicine_order")->row();

					if (!is_null($medicineResult)) {
						if ((int)$supply_quan != (int)$medicineResult->required_bu) {
							$new_required_medicine = (int)$medicineResult->required_bu - (int)$supply_quan;
							if($new_required_medicine > 0){
								$newMedicineOrder = array(
									"medicine_name"=>$medicineResult->medicine_name,
									"medicine_id"=>$medicineResult->medicine_id,
									"default_bu"=>$medicineResult->default_bu,
									"default_pkt"=>$medicineResult->default_pkt,
									"required_bu"=>$new_required_medicine,
									"supplied_by_pharmeasy"=>0,
									"received_by_hospital"=>0,
									"status"=>1,
									"order_status"=>1,
									"patient_id"=>$patient_id,
									"branch_id"=>$medicineResult->branch_id,
									"confirm_status"=>$medicineResult->confirm_status,
									"create_on"=>date("Y-m-d h:i:s")
								);
							}
						}
					}

					$updateData["supply_quantity"] = $supply_quantity[$medicine];
				}

				if(array_key_exists($medicine,$supply_medicine_total)){
					$updateData["medicine_total"] = $supply_medicine_total[$medicine];
				}else{
					if(!$receiver){
						$updateData["medicine_total"] = 0;
					}
				}

				$isExist=false;
				foreach ($mcgm as $m){
					if($m== $medicine){
						$updateData["mcgm"] = $m;
						$isExist=true;
						break;
					}
				}
				if(!$isExist){
					$updateData["mcgm"] = 0;
				}

				if ($receiver) {
					$updateData["received_by"] = $this->session->user_session->id;
					$updateData["received_on"] = date("Y-m-d H:i:s");
				} else {
					$updateData["supplied_by"] = $this->session->user_session->id;
					$updateData["supplied_on"] = date("Y-m-d H:i:s");
				}
				if($mode==0){
					$this->db->set($updateData)->where(array("patient_id" => $patient_id,"supplied_by_pharmeasy"=>0, "id" => $medicine, "branch_id" => $this->session->user_session->branch_id))->update("com_1_medicine_order");
				}else{
					$order_id = $updateData["order_id"];
					$this->db->set($updateData)->where(array("patient_id" => $patient_id,"order_id"=>$order_id, "id" => $medicine, "branch_id" => $this->session->user_session->branch_id))->update("com_1_medicine_order");
				}

				$medicineUpdateData[]=$updateData;

				if(!is_null($newMedicineOrder)){
					$this->db->insert("com_1_medicine_order",$newMedicineOrder);
				}
			}
			if ($receiver) {
				$billingTransaction = $this->db->select("*")
					->where(array("patient_id" => $patient_id, "status" => 1, "branch_id" => $this->session->user_session->branch_id,
							"order_status" => 3, 'billing_ref_no' => $updateData["billing_ref_no"],
							"order_id" => $updateData["order_id"])
					)
					->group_by("billing_ref_no")
					->get("com_1_medicine_order")
					->result();

				if (count($billingTransaction) > 0) {
					$invoice_number = "";
					$invoice_amount = 0;
					$medicine_received = "";
					foreach ($billingTransaction as $medicine) {
						$invoice_number = $medicine->billing_ref_no;
						$invoice_amount = $invoice_amount + (double)$medicine->total;
						$medicine_received = $medicine->received_on;
					}

					$this->db->insert($billingTransactionTable,
						array("type" => 2, "rate" => $invoice_amount, "total" => $invoice_amount,"final_amount" => $invoice_amount, "order_id" => $invoice_number,
							"create_on" => date("Y-m-d H:i:s"), "create_by" => $this->session->user_session->id,
							"status" => 1, "patient_id" => $patient_id, "date_service" => $medicine_received,
							"service_desc" => "Medicine", "service_id" => "Medicine", "branch_id" => $this->session->user_session->branch_id,
							"confirm" => 1
						));
				}
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		$resultObject->medicine=$medicineUpdateData;
		return $resultObject;
	}

		public function saveConsumableOrder($patient_id, $medicines, $updateData, $alt_medicine, $receiver, $billingTransactionTable, $supply_quantity,$supply_material_total,$mgcm)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();

			foreach ($medicines as $medicine) {
				$newMedicineOrder = null;
				if (count($alt_medicine) > 0) {
					$updateData["alt_consumable"] = $alt_medicine[$medicine];
				}

				if (count($supply_quantity) > 0) {
					$supply_quan = $supply_quantity[$medicine];

					$medicineResult = $this->db
						->where(array("patient_id" => $patient_id, "id" => $medicine, "supplied_by_pharmeasy" => 0, "branch_id" => $this->session->user_session->branch_id))
						->get("com_1_consumable_material_item_table")->row();
						
					if (!is_null($medicineResult)) {
						
						if ((int)$supply_quan != (int)$medicineResult->quantity) {
							$new_required_medicine = (int)$medicineResult->quantity - (int)$supply_quan;
							
							if($new_required_medicine > 0){
								$newMedicineOrder = array(
									"material_description"=>$medicineResult->material_description,
									"material_description_id"=>$medicineResult->material_description_id,
									"unit"=>$medicineResult->unit,
									"quantity"=>$new_required_medicine,
									"supplied_by_pharmeasy"=>0,
									"received_by_hospital"=>0,
									"status"=>1,
									"order_status"=>1,
									"patient_id"=>$patient_id,
									"branch_id"=>$medicineResult->branch_id,
									"confirm_status"=>$medicineResult->confirm_status
								);
							}
						}
					}

					if(array_key_exists($medicine,$supply_material_total)){
						$updateData["material_total"] = $supply_material_total[$medicine];
					}else{
						if(!$receiver){
							$updateData["material_total"] = 0;
						}
					}

					$isExist=false;
					foreach ($mgcm as $m){
						if($m== $medicine){
							$updateData["mcgm"] = $m;
							$isExist=true;
							break;
						}
					}
					if(!$isExist){
						$updateData["mcgm"] = 0;
					}

					$updateData["supply_quantity"] = $supply_quantity[$medicine];
				}

				if ($receiver) {
					$updateData["received_by"] = $this->session->user_session->id;
					$updateData["received_on"] = date("Y-m-d H:i:s");
				} else {
					$updateData["supplied_by"] = $this->session->user_session->id;
					$updateData["supplied_on"] = date("Y-m-d H:i:s");
				}

				$this->db->set($updateData)->where(array("patient_id" => $patient_id, "id" => $medicine, "branch_id" => $this->session->user_session->branch_id))->update("com_1_consumable_material_item_table");
				if(!is_null($newMedicineOrder)){
					$this->db->insert("com_1_consumable_material_item_table",$newMedicineOrder);
				}
			}
			if ($receiver) {
				$billingTransaction = $this->db->select("*")
					->where(array("patient_id" => $patient_id, "status" => 1, "branch_id" => $this->session->user_session->branch_id,
							"order_status" => 3, 'billing_ref_no' => $updateData["billing_ref_no"],
							"order_id" => $updateData["order_id"])
					)
					->group_by("billing_ref_no")
					->get("com_1_consumable_material_item_table")
					->result();

				if (count($billingTransaction) > 0) {
					$invoice_number = "";
					$invoice_amount = 0;
					$medicine_received = "";
					foreach ($billingTransaction as $medicine) {
						$invoice_number = $medicine->billing_ref_no;
						$invoice_amount = $invoice_amount + (double)$medicine->total;
						$medicine_received = $medicine->received_on;
					}

					$this->db->insert($billingTransactionTable,
						array("type" => 2, "rate" => $invoice_amount, "total" => $invoice_amount, "final_amount" => $invoice_amount,"order_id" => $invoice_number,
							"create_on" => date("Y-m-d H:i:s"), "create_by" => $this->session->user_session->id,
							"status" => 1, "patient_id" => $patient_id, "date_service" => $medicine_received,
							"service_desc" => "Consumables", "service_id" => "Consumables", "branch_id" => $this->session->user_session->branch_id,
							"confirm" => 1
						));
				}
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	public function saveReturnOrder($patient_id, $medicines, $updateData, $alt_medicine, $receiver, $billingTransactionTable)
	{

		$resultObject = new stdClass();
		try {
			$this->db->trans_start();

			foreach ($medicines as $medicine) {
				if (count($alt_medicine) > 0) {
					$updateData["return_reason"] = $alt_medicine[$medicine];
				}
				if ($receiver) {
					$updateData["return_received_by"] = $this->session->user_session->id;
					$updateData["return_received_on"] = date("Y-m-d H:i:s");
				} else {
					$updateData["return_supplied_by"] = $this->session->user_session->id;
					$updateData["return_supplied_on"] = date("Y-m-d H:i:s");
				}
				// print_r(array("patient_id" => $patient_id, "medicine_id" => $medicine));exit();
				$this->db->set($updateData)->where(array("patient_id" => $patient_id, "medicine_id" => $medicine))->update("com_1_medicine_order");
			}

			if ($receiver) {
				$billingTransaction = $this->db->select("*")->where(array("patient_id" => $patient_id, "status" => 1, "branch_id" => $this->session->user_session->branch_id, "return_status" => 3, 'return_invoice' => $updateData["return_invoice"]))->group_by("return_invoice")->get("com_1_medicine_order")->result();
				// print_r($billingTransaction);exit();
				if (count($billingTransaction) > 0) {
					$invoice_number = "";
					$invoice_amount = 0;
					$medicine_received = date('Y-m-d h:i:s');
					foreach ($billingTransaction as $medicine) {
						$invoice_number = $medicine->return_invoice;
						$invoice_amount = $invoice_amount + (double)$medicine->return_amount;
						if ($medicine->return_received_on != null)
							$medicine_received = $medicine->return_received_on;
					}

					$this->db->insert($billingTransactionTable,
						array("type" => 2, "rate" => $invoice_amount, "total" => $invoice_amount, "final_amount" => $invoice_amount,"order_id" => $invoice_number,
							"create_on" => date("Y-m-d H:i:s"), "create_by" => $this->session->user_session->id,
							"status" => 1, "patient_id" => $patient_id, "date_service" => $medicine_received,
							"service_desc" => "Medicine", "service_id" => "Medicine", "branch_id" => $this->session->user_session->branch_id,
							"confirm" => 0
						));
				}
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}
	

}
