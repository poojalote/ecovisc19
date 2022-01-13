<?php

include_once 'HexaController.php';

/**
 * @property  MedicineOrderModel MedicineOrderModel
 * @property  Global_model Global_model
 */
class MedicineOrderController1 extends HexaController
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

	public function index1()
	{
		$this->load->view("medicine_order/view_pharmeasy1", array("title" => "Dashboard"));
	}

	public function hospitalMedicine()
	{
		$this->load->view("medicine_order/view_receive_pharmeasy", array("title" => "Dashboard"));
	}

	public function getPatientOrderMedicine1()
	{

		$validObject = $this->is_parameter(array("patient_id"));
		$data = "";

		$cons_data = "";
		if ($validObject->status) {

			$patient_id = $validObject->param->patient_id;
			$date = $this->input->post('date');


			$orderDetails = $this->MedicineOrderModel->getOrdersByPatient($patient_id, $date);
			$response["query"] = $this->db->last_query();
			if ($orderDetails->totalCount > 0) {

				foreach ($orderDetails->data as $order) {
					$medicine_data = "";
					$hoverButton = "";
					$medicine_active = 0;
					if ($order->medicine_data != "" && $order->medicine_data != null) {
						$m_detials = explode("||", $order->medicine_data);

						$template = "";
						if (count($m_detials) > 0) {
							foreach ($m_detials as $m_index => $med) {
								if ($med != "" && $med != "-1") {
									if ($m_index == 0) {
										$template .= "<div class='col-md-12'>
												<b>Per day schedule : " . $med . " </b>
											   </div>";
									}
									if ($m_index == 1) {
										$template .= "<div class='col-md-12'>
												<b>Remark : " . $med . " </b>
											   </div>";
									}
									if ($m_index == 3) {
										$template .= "<div class='col-md-12'>
												<b>Flow Rate : " . $med . " </b>
											   </div>";
									}
									if ($m_index == 4) {
										$template .= "<div class='col-md-12'>
												<b>Route : " . $med . " </b>
											   </div>";
									}
									if ($m_index == 5) {
										$template .= "<div class='col-md-12'>
												<b>Quantity : " . $med . " </b>
											   </div>";
									}
									if ($m_index == 6) {
										if ($med == 0) {
											$medicine_active = 1;
										}
									}
								}
							}
						}
						$hoverButton = '<a tabindex="0" class="btn btn-link btn-sm mx-2" 
role="button" data-toggle="popover" data-trigger="focus" data-html="true" title=""
 data-content="' . $template . '" 
 data-original-title="' . $order->medicine_name . '"><i class="fa fa-info"></i></a>';
					}

					$medicine_data = '
							<tr>
								<td>' . $hoverButton . $order->medicine_name . "<b>(" . date('d-m-Y H:i A', strtotime($order->create_on)) . ")</b>" . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->required_bu . '</td>
								<td><input type="number" class="form-control" data-supply_order_id="' . $order->id . '" oninput="get_sum_rate(' . $order->id . ')" value="' . $order->required_bu . '" id="supply_quantity_' . $order->id . '" name="supply_quantity_' . $order->id . '"></td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="ck_order_medicine[]" data-order_id="' . $order->id . '" onchange="updateCalculation(this,' . $order->id . ')" id="ck_order_medicine_' . $order->id . '" checked value="' . $order->id . '_' . $order->medicine_id . '">
									
								</div>
								</td>
								<td><input type="text" name="alt_medicine_' . $order->id . '" class="form-control">
								
								</td>
								<td><input type="number" min="0" value="0"  id="rate_medicine_' . $order->id . '"  name="rate_medicine_' . $order->id . '" oninput="get_sum_rate(' . $order->id . ')" class="form-control">
								
								</td>
								<td><input type="number" min="0.1" value="0"  id="total_medicine_' . $order->id . '"  name="total_medicine_' . $order->id . '" oninput="get_total_rate(' . $order->id . ')" class="form-control">
								
								</td>
								<td>
								<input type="checkbox" name="rck_order_medicine[]" id="rck_order_medicine_' . $order->id . '"  value="' . $order->id . '">
								
								</td>
								
							</tr>							
							';
					if ($medicine_active == 0) {
						$data .= $medicine_data;
					}
				}
			}
			$consumableOrderDetails = $this->MedicineOrderModel->getConsumableOrdersByPatient($patient_id, $date);
			$response["query1"] = $this->db->last_query();
			if ($consumableOrderDetails->totalCount > 0) {

				foreach ($consumableOrderDetails->data as $order) {

					$cons_data .= '
					<tr>
								<td>' . $order->material_description . "<b>(" . date('d-m-Y', strtotime($order->order_create_date)) . ")</b>" . '</td>
								<td>' . $order->unit . '</td>
								<td>' . $order->quantity . '</td>
								<td><input type="number" class="form-control" value="' . $order->quantity . '" oninput="get_material_sum_rate(' . $order->id . ')" id="supply_con_quantity_' . $order->id . '" name="supply_con_quantity_' . $order->id . '" data-supply_material_order_id="' . $order->id . '"></td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="ck_order_consumable[]" data-material_id="' . $order->id . '" id="ck_order_consumable_' . $order->id . '" onchange="updateConsumeableCalculation(this,' . $order->id . ')" checked value="' . $order->id . '">
									
								</div>
								</td>
								<td><input type="text" name="alt_consumable_' . $order->id . '" class="form-control"></td>
								<td>
									<input type="number" min="0" value="0"  id="rate_material_' . $order->id . '"  name="rate_material_' . $order->id . '" oninput="get_material_sum_rate(' . $order->id . ')" class="form-control">								
								</td>
								<td>
									<input type="number" min="0.1" value="0"  id="total_material_' . $order->id . '"  name="total_material_' . $order->id . '" oninput="get_material_total_rate(' . $order->id . ')" class="form-control">								
								</td>
								<td>
								<input type="checkbox" name="rck_order_material[]" id="rck_order_material_' . $order->id . '"  value="' . $order->id . '">								
								</td>
							</tr>							
							';
				}
			}
			// print_r($consumableOrderDetails);exit();
			$response["status"] = 200;
			$response["body"] = $data;
			$response["cons_body"] = $cons_data;
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}

		echo json_encode($response);
	}

	public function getPatientOrderReturnMedicine()
	{

		$validObject = $this->is_parameter(array("patient_id"));
		$data = "";
		if ($validObject->status) {

			$patient_id = $validObject->param->patient_id;

			$orderDetails = $this->MedicineOrderModel->getOrdersReturnByPatient($patient_id);

			if ($orderDetails->totalCount > 0) {

				foreach ($orderDetails->data as $order) {
					$data .= '
							<tr>
								<td>' . $order->medicine_name . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->return_quantity . '</td>
								<td>' . $order->order_id . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="ck_order_return_medicine[]" id="ck_return_order_medicine_' . $order->medicine_id . '" checked value="' . $order->medicine_id . '">
									
								</div>
								</td>
								<td><input type="text" name="return_reason_' . $order->medicine_id . '" class="form-control">
								
								</td>
							</tr>							
							';
				}
			}
			$response["status"] = 200;
			$response["body"] = $data;
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}

		echo json_encode($response);
	}

	public function getApprovedPatientOrderMedicine()
	{

		$validObject = $this->is_parameter(array("patient_id"));
		$data = "";
		$cons_data = "";
		if ($validObject->status) {

			$patient_id = $validObject->param->patient_id;

			$orderDetails = $this->MedicineOrderModel->getApprovedOrdersByPatient($patient_id);

			if ($orderDetails->totalCount > 0) {

				foreach ($orderDetails->data as $order) {

					$data .= '
							<tr>
								<td>' . $order->medicine_name . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->required_bu . '</td>
								<td>' . $order->supply_quantity . '</td>
								<td>' . $order->alt_medicine . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
									<input type="checkbox" name="ck_order_medicine[]" id="ck_order_medicine_' . $order->medicine_id . '" checked value="' . $order->medicine_id . '">									
								</div>
								</td>
								
							</tr>							
							';
					// <button type="button" class="btn btn-primary btn-sm ml-2" onclick="deleteMedicine(' . $order->id . ','.$patient_id.')"><i class="fa fa-trash"></i></button>
					$response["invoice_number"] = $order->billing_ref_no;
					$response["invoice_amount"] = $order->total;
					$response["order_number"] = $order->order_id;
					$response["patient_id"] = $order->patient_id;
				}

			}
			$consumableOrderDetails = $this->MedicineOrderModel->getApprovedConsumableOrdersByPatient($patient_id);
			// print_r($consumableOrderDetails);exit();
			$response["query1"] = $this->db->last_query();
			if ($consumableOrderDetails->totalCount > 0) {

				foreach ($consumableOrderDetails->data as $order) {
					$cons_data .= '
							<tr>
								<td>' . $order->material_description . '</td>
								<td>' . $order->unit . '</td>
								<td>' . $order->quantity . '</td>
								<td>' . $order->supply_quantity . '</td>
								<td>' . $order->alt_consumable . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
									<input type="checkbox" name="ck_order_consumable[]" id="ck_order_consumable_' . $order->id . '" checked value="' . $order->id . '">									
								</div>
								</td>
								
							</tr>							
							';
					$response["cons_invoice_number"] = $order->billing_ref_no;
					$response["cons_invoice_amount"] = $order->total;
					$response["cons_order_number"] = $order->order_id;
					$response["cons_patient_id"] = $order->patient_id;
				}
			}

			$response["status"] = 200;
			$response["body"] = $data;
			$response["cons_body"] = $cons_data;
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}

		echo json_encode($response);
	}

	public function getApprovedReturnPatientOrderMedicine()
	{

		$validObject = $this->is_parameter(array("patient_id"));
		$data = "";
		if ($validObject->status) {

			$patient_id = $validObject->param->patient_id;

			$orderDetails = $this->MedicineOrderModel->getApprovedReturnOrdersByPatient($patient_id);

			if ($orderDetails->totalCount > 0) {

				foreach ($orderDetails->data as $order) {

					$data .= '
							<tr>
								<td>' . $order->medicine_name . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->return_quantity . '</td>
								<td>' . $order->order_id . '</td>
								<td>' . $order->return_reason . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
									<input type="checkbox" name="ck_order_return_medicine[]" id="ck_order_return_medicine' . $order->medicine_id . '" checked value="' . $order->medicine_id . '">									
								</div>
								</td>
								
							</tr>							
							';
					// <button type="button" class="btn btn-primary btn-sm ml-2" onclick="deleteMedicine(' . $order->id . ','.$patient_id.')"><i class="fa fa-trash"></i></button>
					$response["invoice_return_number"] = $order->return_invoice;
					$response["invoice_return_amount"] = $order->return_amount;
					$response["order_number"] = $order->order_id;
					$response["patient_id"] = $order->patient_id;
				}

			}
			$response["status"] = 200;
			$response["body"] = $data;
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}

		echo json_encode($response);
	}

	public function getOrderMedicinePatient()
	{
		$date = $this->input->post('date');

		$patientTable = $this->session->user_session->patient_table;

		$patientListObject = $this->MedicineOrderModel->getPatients($patientTable, $date);

		$data = array(array("id" => -1, "text" => "select Name", "disabled" => true, "selected" => true));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				if (!is_null($patient->patient_name)) {
					array_push($data, array("id" => (int)$patient->patient_id, "text" => $patient->patient_name));
				}

			}
		}
		$consumablepatientListObject = $this->MedicineOrderModel->getConsumablePatients($patientTable, $date);
		if ($consumablepatientListObject->totalCount > 0) {
			foreach ($consumablepatientListObject->data as $patient) {
				if (!is_null($patient->patient_name)) {
					array_push($data, array("id" => (int)$patient->patient_id, "text" => $patient->patient_name));
				}

			}
		}
		// $data1 = array_unique($data);
		$data = array_values(array_unique($data, SORT_REGULAR));
		// $dupes = array_diff_key( $data, $data1 );
		// print_r($data);exit();

		$response["query"] = $patientListObject->last_query;
		$response["body"] = $data;
		echo json_encode($response);
	}

	public function getOrderReturnMedicinePatient()
	{

		$patientTable = $this->session->user_session->patient_table;

		$patientListObject = $this->MedicineOrderModel->getReturnOrderPatients($patientTable);
		$data = array(array("id" => -1, "text" => "select Name", "disabled" => true, "selected" => true));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				// print_r($patient);exit();
				if (!is_null($patient->patient_name))
					array_push($data, array("id" => $patient->patient_id, "text" => $patient->patient_name));
			}
		}
		$response["body"] = $data;
		echo json_encode($response);
	}

	public function getApprovedOrderMedicinePatient()
	{

		$patientTable = $this->session->user_session->patient_table;
		$patientListObject = $this->MedicineOrderModel->getApprovedPatients($patientTable);
		$data = array(array("id" => -1, "text" => "select Name", "disabled" => true, "selected" => true));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				array_push($data, array("id" => $patient->order_id, "text" => $patient->patient_name . ' ' . $patient->order_id));
			}
		}

		$consumablepatientListObject = $this->MedicineOrderModel->getApprovedConsumablePatients($patientTable);
		if ($consumablepatientListObject->totalCount > 0) {
			foreach ($consumablepatientListObject->data as $patient) {
				if (!is_null($patient->patient_name)) {
					array_push($data, array("id" => $patient->order_id, "text" => $patient->patient_name . ' ' . $patient->order_id));
				}

			}
		}
		// $data1 = array_unique($data);
		$data = array_unique($data, SORT_REGULAR);
		// print_r($data);exit();

		$response["body"] = $data;
		echo json_encode($response);
	}

	public function getApprovedReturnOrderMedicinePatient()
	{

		$patientTable = $this->session->user_session->patient_table;
		$patientListObject = $this->MedicineOrderModel->getApprovedReturnPatients($patientTable);
		$data = array(array("id" => -1, "text" => "select Name", "disabled" => true, "selected" => true));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				// print_r()
				array_push($data, array("id" => $patient->order_id, "text" => $patient->patient_name . ' ' . $patient->order_id));
			}
		}
		$response["body"] = $data;
		echo json_encode($response);
	}

	public function history_patient()
	{
		$patientTable = $this->session->user_session->patient_table;
		$patientListObject = $this->MedicineOrderModel->getHistoryReturnPatients($patientTable);
		$data = array(array("id" => -1, "text" => "select Name", "disabled" => true, "selected" => true));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				// print_r()
				if (!is_null($patient->patient_name))
					array_push($data, array("id" => $patient->patient_id, "text" => $patient->patient_name));
			}
		}

		$data = array_values(array_unique($data, SORT_REGULAR));
		$response["body"] = $data;
		echo json_encode($response);
	}

	public function deleteOrder()
	{
		$validObject = $this->is_parameter(array("id"));
		if ($validObject->status) {

			$resultObject = $this->MedicineOrderModel->_update("com_1_medicine_order", array("status" => 0), array("id" => $validObject->param->id));
			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Save Changes";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed to Delete";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}


	public function saveOrder()
	{

		$validObject = $this->is_parameter(array("patient_id", "invoice_number", "invoice_amount", "ck_order_medicine", "type"));
		if ($validObject->status) {

			$param = $validObject->param;
			$billingTransactionTable = $this->session->user_session->billing_transaction;
			if (count($param->ck_order_medicine) > 0) {
				$updateData = array(
					"billing_ref_no" => $param->invoice_number,
					"total" => $param->invoice_amount,

				);
				$order_id = null;
				$receiver = false;
				if ((int)$param->type == 1) {
					$order_id = $this->Global_model->generate_order("select order_id from com_1_medicine_order where order_id = '#id'");
					$updateData["order_id"] = $order_id;
					$updateData["order_status"] = 2;
					$updateData["supplied_by_pharmeasy"] = 1;
					$mode = 0;
				} else {
					$updateData["order_id"] = $this->input->post('order_id');
					$updateData["order_status"] = 3;
					$updateData["received_by_hospital"] = 1;
					$receiver = true;
					$mode = 1;
				}
				$alter_medicine = array();
				$supply_quantity = array();
				foreach ($param->ck_order_medicine as $medicine) {
					if (!is_null($this->input->post("alt_medicine_" . $medicine))) {
						$alter_medicine[$medicine] = $this->input->post("alt_medicine_" . $medicine);

					}
					if (!$receiver) {
						if (!empty($this->input->post("supply_quantity_" . $medicine)) && $this->input->post("supply_quantity_" . $medicine) != 0) {
							$supply_quantity[$medicine] = $this->input->post("supply_quantity_" . $medicine);
						} else {
							$response["status"] = 201;
							$response["body"] = "Please add supply quantity or uncheck the medicine.";
							echo json_encode($response);
							exit;
						}
					}
				}

				$resultObject = $this->MedicineOrderModel->saveOrder($param->patient_id, $param->ck_order_medicine, $updateData, $alter_medicine, $receiver, $billingTransactionTable, $supply_quantity, $mode);
				if ($resultObject->status) {
					$response["mode"] = $receiver;
					$response["order_id"] = $order_id;
					$response["patient_id"] = $param->patient_id;
					$response["status"] = 200;
					$response["body"] = "Save Order";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed To Save";
					$response["patient_id"] = $param->patient_id;
				}

			} else {
				$response["status"] = 201;
				$response["body"] = "No Medicine Selected";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Check Order Details";
		}
		echo json_encode($response);
	}

	public function saveConsumableOrder()
	{
		$validObject = $this->is_parameter(array("patient_id", "invoice_number", "invoice_amount", "ck_order_consumable", "type"));
		if ($validObject->status) {

			$param = $validObject->param;

			$billingTransactionTable = $this->session->user_session->billing_transaction;
			if (count($param->ck_order_consumable) > 0) {
				$updateData = array(
					"billing_ref_no" => $param->invoice_number,
					"total" => $param->invoice_amount,

				);

				$order_id = null;
				$receiver = false;
				if ((int)$param->type == 1) {
					$order_id = $this->Global_model->generate_order("select order_id from com_1_medicine_order where order_id = '#id'");
					$updateData["order_id"] = $order_id;
					$updateData["order_status"] = 2;
					$updateData["supplied_by_pharmeasy"] = 1;
				} else {
					$updateData["order_id"] = $this->input->post('order_id');
					$updateData["order_status"] = 3;
					$updateData["received_by_hospital"] = 1;
					$receiver = true;
				}

				$alter_medicine = array();
				$supply_quantity = array();
				foreach ($param->ck_order_consumable as $medicine) {
					if (!is_null($this->input->post("alt_consumable_" . $medicine))) {
						$alter_medicine[$medicine] = $this->input->post("alt_consumable_" . $medicine);

					}
					if (!$receiver) {
						if (!empty($this->input->post("supply_con_quantity_" . $medicine)) && $this->input->post("supply_con_quantity_" . $medicine) != 0) {
							$supply_quantity[$medicine] = $this->input->post("supply_con_quantity_" . $medicine);
						} else {
							$response["status"] = 201;
							$response["body"] = "Please add supply quantity or uncheck the medicine.";
							echo json_encode($response);
							exit;
						}
					}
				}

				$resultObject = $this->MedicineOrderModel->saveConsumableOrder($param->patient_id, $param->ck_order_consumable, $updateData, $alter_medicine, $receiver, $billingTransactionTable, $supply_quantity);
				if ($resultObject->status) {
					$response["mode"] = $receiver;
					$response["patient_id"] = $param->patient_id;
					$response["order_id"] = $order_id;
					$response["status"] = 200;
					$response["body"] = "Save Order";
				} else {
					$response["status"] = 201;
					$response["patient_id"] = $param->patient_id;
					$response["body"] = "Failed To Save";
				}

			} else {
				$response["status"] = 201;
				$response["body"] = "No Medicine Selected";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Check Order Details";
		}
		echo json_encode($response);
	}

	public function saveOrderReturn()
	{

		$validObject = $this->is_parameter(array("patient_id", "invoice_return_number", "invoice_return_amount", "ck_order_return_medicine", "type"));
		if ($validObject->status) {

			$param = $validObject->param;
			// print_r($param->patient_id);exit();
			$billingTransactionTable = $this->session->user_session->billing_transaction;
			if (count($param->ck_order_return_medicine) > 0) {
				$updateData = array(
					"return_invoice" => $param->invoice_return_number,
					"return_amount" => $param->invoice_return_amount,

				);
				$order_id = null;
				$receiver = false;
				if ((int)$param->type == 1) {
					$order_id = $this->Global_model->generate_order("select order_id from com_1_medicine_order where order_id = '#id'");
					// $updateData["order_id"]=$order_id;
					//$updateData["return_status"] = 2;
					//$updateData["supplied_by_pharmeasy"] = 1;
//				} else {
					$updateData["return_status"] = 3;
					$updateData["received_by_hospital"] = 1;
					$receiver = true;
				}
				$alter_medicine = array();
				foreach ($param->ck_order_return_medicine as $medicine) {
					if (!is_null($this->input->post("return_reason_" . $medicine))) {
						$alter_medicine[$medicine] = $this->input->post("return_reason_" . $medicine);
					}
				}
				// print_r($updateData);exit();
				$resultObject = $this->MedicineOrderModel->saveReturnOrder($param->patient_id, $param->ck_order_return_medicine, $updateData, $alter_medicine, $receiver, $billingTransactionTable);

				if ($resultObject->status) {
					$response["mode"] = $receiver;
					$response["order_id"] = $order_id;
					$response["status"] = 200;
					$response["body"] = "Save Return Order";
				} else {
					$response["status"] = 201;
					$response["body"] = "Failed To Save";
				}

			} else {
				$response["status"] = 201;
				$response["body"] = "No Medicine Selected";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Check Return Order Details";
		}
		echo json_encode($response);
	}

	public function getHistoryorderTable()
	{
		$p_id = $this->input->post('p_id');
		$patientTable = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = "com_1_medicine_order m";
		$d = "*";
		$select = array($d, "(select patient_name from " . $patientTable . " c where c.id=m.patient_id) as name ",
			"(select id from " . $patientTable . " c where c.id=m.patient_id) as p_id "
		);
		if (!is_null($p_id)) {
			$where = "  order_id is not null AND branch_id=" . $branch_id . " and patient_id=" . $p_id;
		} else {
			$where = "  order_id is not null AND branch_id=" . $branch_id;
		}


		$order = array('supplied_on' => 'desc');
		$group_by = array('order_id');
		$column_order = array('name');
		$column_search = array('order_id', "billing_ref_no");

		$memData = $this->MedicineOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order, $group_by);

		$filterCount = $this->MedicineOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->MedicineOrderModel->countAll($tableName, $where);
		//	echo $this->db->last_query();
		if (count($memData) > 0) {
			$tableRows = array();
			// print_r($memData);exit();
			foreach ($memData as $row) {


				$tableRows[] = array(
					$row->order_id,
					$row->total,
					$row->name,
					date('d-m-Y', strtotime($row->supplied_on)),
					$row->billing_ref_no,
					$row->p_id,

				);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows,
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $memData,
			);
		}
		echo json_encode($results);
	}

	public function getItemMedicineHistory()
	{
		$order_id = $this->input->post('order_id');
		$query = $this->db->query("select * from com_1_medicine_order where order_id='" . $order_id . "'");
		$data = "";
		$data .= "<table class='table table-bordered' id='historyItemTable'>
		<thead>
		<tr>
		<th>Medicine Name</th>
		<th>Unit</th>
		<th>Required Quantity</th>
		<th>Supply Quantity</th>
		<th>Alternative Medicine</th>
		</tr>
		</thead>
		<tbody>
		";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$data .= "<tr>
				<td>" . $row->medicine_name . "</td>
				<td>" . $row->default_bu . "</td>
				<td>" . $row->required_bu . "</td>
				<td>" . $row->supply_quantity . "</td>
				<td>" . $row->alt_medicine . "</td>
				</tr>";
			}
			$data .= "</tbody>
			<table>";
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "";
		}
		echo json_encode($response);
	}

}
