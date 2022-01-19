<?php

include_once 'HexaController.php';

/**
 * @property  MedicineOrderModel MedicineOrderModel
 * @property  Global_model Global_model
 */
class MedicineOrderController extends HexaController
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

	public function getPatientOrderMedicine()
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
					$hoverButton = "";
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
								}
							}
						}
						$hoverButton = '<a tabindex="0" class="btn btn-link btn-sm mx-2" 
role="button" data-toggle="popover" data-trigger="focus" data-html="true" title=""
 data-content="' . $template . '" 
 data-original-title="' . $order->medicine_name . '"><i class="fa fa-info"></i></a>';
					}

					$data .= '
							<tr>
								<td>' . $hoverButton . $order->medicine_name . "<b>(" . date('d-m-Y', strtotime($order->create_on)) . ")</b>" . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->required_bu . '</td>
								<td><input type="number" class="form-control" value="' . $order->required_bu . '" id="supply_quantity_' . $order->medicine_id . '" name="supply_quantity_' . $order->medicine_id . '"></td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="ck_order_medicine[]" id="ck_order_medicine_' . $order->medicine_id . '" checked value="' . $order->medicine_id . '">
									
								</div>
								</td>
								<td><input type="text" name="alt_medicine_' . $order->medicine_id . '" class="form-control">
								
								</td>
							</tr>							
							';
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
								<td><input type="number" class="form-control" value="' . $order->quantity . '" id="supply_con_quantity_' . $order->id . '" name="supply_con_quantity_' . $order->id . '"></td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="ck_order_consumable[]" id="ck_order_consumable_' . $order->id . '" checked value="' . $order->id . '">
									
								</div>
								</td>
								<td><input type="text" name="alt_consumable_' . $order->id . '" class="form-control">
								
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
					if ((int)$order->mcgm > 0) {
						$mcgm = "<i class='fa fa-check'></i>";
					} else {
						$mcgm = "-";
					}
					$data .= '
							<tr>
								<td>' . $order->medicine_name . '</td>
								<td>' . $order->default_bu . '</td>
								<td>' . $order->default_pkt . '</td>
								<td>' . $order->required_bu . '</td>
								<td>' . $order->supply_quantity . '</td>
								<td>' . $order->alt_medicine . '</td>
								<td>' . $order->medicine_total . '</td>
								<td>' . $mcgm . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
									<input type="checkbox" name="ck_order_medicine[]" id="ck_order_medicine_' . $order->id . '" checked value="' . $order->id . '">									
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
		$discharge = $this->input->post('discharge');
		$patientTable = $this->session->user_session->patient_table;

		$patientListObject = $this->MedicineOrderModel->getPatients($patientTable, $date,$discharge);

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
		$data = array_values(array_unique($data, SORT_REGULAR));

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
		array_push($data, array("id" => "", "text" => "All"));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				// print_r()
				if (!is_null($patient->patient_name))
					array_push($data, array("id" => $patient->patient_id, "text" => $patient->patient_name));
			}
		}
		$consumablepatientListObject = $this->MedicineOrderModel->getHistoryConsumablePatients($patientTable);
		if ($consumablepatientListObject->totalCount > 0) {
			foreach ($consumablepatientListObject->data as $patient) {
				if (!is_null($patient->patient_name)) {
					array_push($data, array("id" => $patient->patient_id, "text" => $patient->patient_name));
				}

			}
		}
		// $data1 = array_unique($data);
		// $data=array_unique($data, SORT_REGULAR);
		// print_r($data);exit();
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
				$supply_medicine_total = array();
				foreach ($param->ck_order_medicine as $medicine) {
					$medicineData = explode("_", $medicine);
					if (count($medicineData) != 2) {
						$medicineData[0] = $medicine;
					}

					if (!is_null($this->input->post("alt_medicine_" . $medicineData[0]))) {
						$alter_medicine[$medicineData[0]] = $this->input->post("alt_medicine_" . $medicineData[0]);

					}
					if (!$receiver) {
						if (!empty($this->input->post("supply_quantity_" . $medicineData[0])) && $this->input->post("supply_quantity_" . $medicineData[0]) != 0) {
							$supply_quantity[$medicineData[0]] = $this->input->post("supply_quantity_" . $medicineData[0]);
						} else {
							$response["status"] = 201;
							$response["body"] = "Please add supply quantity or uncheck the medicine.";
							echo json_encode($response);
							exit;
						}
						if (array_key_exists(1, $medicineData)) {
							if (!empty($this->input->post("total_medicine_" . $medicineData[0])) && $this->input->post("total_medicine_" . $medicineData[0]) != 0) {
								$supply_medicine_total[$medicineData[0]] = $this->input->post("total_medicine_" . $medicineData[0]);
							}
						}

					}
				}
				$mcgm = $this->input->post("rck_order_medicine");
				$mcgmArray = array();
				if (!is_null($mcgm)) {
					$mcgmArray = $mcgm;
				}

				$resultObject = $this->MedicineOrderModel->saveOrder($param->patient_id, $param->ck_order_medicine, $updateData, $alter_medicine, $receiver, $billingTransactionTable, $supply_quantity, $mode, $supply_medicine_total, $mcgmArray);

				$response["result"] = $resultObject->medicine;
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

	public function saveHospOrder()
	{

		$validObject = $this->is_parameter(array("h_invoice_number", "h_invoice_amount", "ord_id"));
		if ($validObject->status) {
			$param = $validObject->param;
			$cnt = 1;
			$h_ck_order_medicine = $this->input->post('h_ck_order_medicine');
			if (count($h_ck_order_medicine) > 0) {
				$order_id = $this->Global_model->generate_order("select receive_order_number from hospital_material_item_table where receive_order_number = '#id'");
				$invoice_number = $param->h_invoice_number;
				$invoice_amount = $param->h_invoice_amount;
				$ord_id = $param->ord_id;
				$h_rck_order_medicine = $this->input->post('h_rck_order_medicine');
				$query = $this->db->query("select count(*) as count from hospital_material_item_table
				where material_order_id=" . $ord_id);
				if ($this->db->affected_rows() > 0) {
					$count = $query->row()->count;
				} else {
					$count = 0;
				}
				$supply_count = 0;
				if ($count == count($h_ck_order_medicine)) {
					// $is_supplied=1;
					$supply_count = 0;
				} else {
					// $is_supplied=0;
					$supply_count = 1;
				}
				$is_supplied = 1;
				$where1 = array("id" => $ord_id);
				$set1 = array(
					"supplier_invoice_amount" => $invoice_amount,
					"supplier_invoice_number" => $invoice_number,
					"receive_order_number" => $order_id,
					"supplied_by" => $this->session->user_session->id,
					"supplied_on" => date('Y-m-d H:i:s'),
					"is_supplied" => $is_supplied
				);

				$this->db->where($where1);
				$update1 = $this->db->update("hospital_order_management", $set1);
				if ($update1 == true) {

					foreach ($h_ck_order_medicine as $medicine) {
						$rate = $this->input->post('h_total_medicine_' . $medicine);
						$altmedicine = $this->input->post('alt_medicine_' . $medicine);
						$supply_quantity = $this->input->post('h_supply_quantity_' . $medicine);
						$order_quantity = $this->input->post('act_q_' . $medicine);
						$branch_id = $this->session->user_session->branch_id;
						$company_id = $this->session->user_session->company_id;

						if (is_array($h_rck_order_medicine)) {
							if (in_array($medicine, $h_rck_order_medicine)) {
								$mcgm = 1;
							} else {
								$mcgm = 0;
							}
						} else {
							$mcgm = 0;
						}


						$set = array("supplier_unit_price" => $rate,
							"alternative_medicine" => $altmedicine,
							"supply_quantity" => $supply_quantity,
							"is_supplied" => 1,
							"receive_order_number" => $order_id,
							"mcgm" => $mcgm,
						);
						$where = array("id" => $medicine);
						$this->db->where($where);
						$update = $this->db->update("hospital_material_item_table", $set);
						if ($update == true) {
							$cnt++;
						}

					}

					$insert_array = array();
					foreach ($h_ck_order_medicine as $medicine) {
						$supply_quantity = $this->input->post('h_supply_quantity_' . $medicine);
						$order_quantity = $this->input->post('act_q_' . $medicine);
						if ($supply_quantity < $order_quantity) {
							$supply_count = $supply_count + 1;
							array_push($insert_array, $medicine);
						}
					}
					// print_r($insert_array);exit();
					//insert in hospital order mgmt if supply count=0;
					if ($supply_count != 0) {
						$main_query = $this->db->query("select * from hospital_order_management
					where id=" . $ord_id);
						if ($this->db->affected_rows() > 0) {
							$queryObject = $main_query->row();

							$insert_data = array(
								'hospital_name' => $queryObject->hospital_name,
								'order_for_hospital' => $queryObject->order_for_hospital,
								'department' => $queryObject->department,
								"order_create_date" => $queryObject->order_create_date,
								'material_group_id' => $queryObject->material_group_id,
								'order_by_user' => $queryObject->order_by_user,
								'status' => $queryObject->status,
								'create_on' => date('Y-m-d H:i:s'),
								'create_by' => $this->session->user_session->id,
								'branch_id' => $queryObject->branch_id,
								'zone_id' => $queryObject->zone_id,
								'company_id' => $queryObject->company_id
							);

							$insert_main = $this->db->insert("hospital_order_management", $insert_data);
							$insert_id_main = $this->db->insert_id();
							if ($insert_main == true) {
								$hospital_order_no = 'HOS_' . $insert_id_main;
								$update_data = array('order_no' => $hospital_order_no);
								$this->db->where('id', $insert_id_main);
								$update_main = $this->db->update("hospital_order_management", $update_data);
								if ($update_main == true) {
									if (!empty($insert_array)) {
										foreach ($insert_array as $medicine) {
											$rate = $this->input->post('h_total_medicine_' . $medicine);
											$altmedicine = $this->input->post('alt_medicine_' . $medicine);
											$supply_quantity = $this->input->post('h_supply_quantity_' . $medicine);
											$order_quantity = $this->input->post('act_q_' . $medicine);
											if ($supply_quantity < $order_quantity) {
												//insert new entry for remaining quantity
												$get_data_ByID = $this->getDataById($medicine);
												if ($get_data_ByID != false) {
													$quantity = $order_quantity - $supply_quantity;

													$data_array = array(
														"material_description_id" => $get_data_ByID->material_description_id,
														"material_description" => $get_data_ByID->material_description,
														"quantity" => $quantity,
														"unit" => $get_data_ByID->unit,
														"material_order_id" => $get_data_ByID->material_order_id,
														"branch_id" => $get_data_ByID->branch_id,
														"company_id" => $get_data_ByID->company_id,
													);
													$insert = $this->db->insert("hospital_material_item_table", $data_array);
												}

											}
										}
									}
									$getDataBYOrder = $this->getDataBYOrder($ord_id);
									if ($getDataBYOrder != false) {
										$set_item = array("material_order_id" => $insert_id_main);
										foreach ($getDataBYOrder as $key => $value) {

											$where_item = array("id" => $value->id);
											$this->db->where($where_item);
											$update_item = $this->db->update("hospital_material_item_table", $set_item);
										}
									}

								}
							}
						}

					}


				}
				if ($cnt > 1) {
					$response["status"] = 200;
					$response["order_id"] = $order_id;
					$response["body"] = "Save Order";
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
			$response["body"] = "Check Order Details";
		}
		echo json_encode($response);
	}

	public function getDataById($medicine)
	{
		$query = $this->db->query("select * from hospital_material_item_table where id=" . $medicine);
		if ($this->db->affected_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function getDataBYOrder($order_id)
	{
		$query = $this->db->query("select id from hospital_material_item_table where material_order_id=" . $order_id . " and ( supply_quantity=0 or supply_quantity is null)");
		if ($this->db->affected_rows() > 0) {
			return $query->result();

		} else {
			return false;
		}
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
				$supply_medicine_total = array();
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
					if (!empty($this->input->post("total_material_" . $medicine)) && $this->input->post("total_material_" . $medicine) != 0) {
						$supply_medicine_total[$medicine] = $this->input->post("total_material_" . $medicine);
					}
				}
				$mcgm = $this->input->post("rck_order_material");
				$mcgmArray = array();
				if (!is_null($mcgm)) {
					$mcgmArray = $mcgm;
				}
				$resultObject = $this->MedicineOrderModel->saveConsumableOrder($param->patient_id, $param->ck_order_consumable, $updateData, $alter_medicine, $receiver, $billingTransactionTable, $supply_quantity, $supply_medicine_total, $mcgmArray);
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
		if (!is_null($p_id) && $p_id != "") {
			$where = "  order_id is not null AND branch_id='" . $branch_id . "' and patient_id='" . $p_id . "' group by order_id";
		} else {
			$where = "  order_id is not null AND branch_id='" . $branch_id . "' group by order_id";
		}


		$order = array('supplied_on' => 'desc');
		$group_by = array();
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
		$patientTable = $this->session->user_session->patient_table;
		$query = $this->db->query("select *,(select cp.patient_name from " . $patientTable . " cp where cp.id=patient_id) as patient_name from com_1_medicine_order where order_id='" . $order_id . "'");
		$data = "";
		$data1 = "";
		$data2 = "";

		$data .= "<table class='table table-bordered table-striped' id='historyItemTable' style='border-collapse: separate!important'>
		<thead class='table_back thead-light'>
		<tr>
		<th>Patient Name</th>
		<th>Medicine Name</th>
		<th>Unit</th>
		<th>Required Quantity</th>
		<th>Supply Quantity</th>
		<th>Alternative Medicine</th>	
		<th>Total</th>
		<th>Mcgm</th>
		</tr>
		</thead>
		<tbody>
		";

		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			$tt = 0;
			foreach ($result as $row) {

				if ((int)$row->mcgm > 0) {
					$mcgm = "<i class='fa fa-check'></i>";
				} else {
					$mcgm = "";
				}
				$data1 = "<h5>Invoice Number : " . $row->billing_ref_no . "</h5>";
				$tt = $tt + $row->medicine_total;
				$data .= "<tr>
				<td>" . $row->patient_name . "</td>
				<td>" . $row->medicine_name . "</td>
				<td>" . $row->default_bu . "</td>
				<td>" . $row->required_bu . "</td>
				<td>" . $row->supply_quantity . "</td>
				<td>" . $row->alt_medicine . "</td>
				<td>" . $row->medicine_total . "</td>
				<td>" . $mcgm . "</td>
				</tr>";
			}
			$data .= "</tbody>
			<table>";
			$data2 = "<h5>Total Amount : " . $tt . "</h5>";
			$response['status'] = 200;
			$data21 = "<br><br>" . $data1 . $data2;
			$response['data'] = $data21 . $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "";
		}
		echo json_encode($response);
	}

	public function getBackOrderMedicinePatient()
	{
		$date = $this->input->post('date');

		$patientTable = $this->session->user_session->patient_table;

		$patientListObject = $this->MedicineOrderModel->getPatients($patientTable, $date);

		$data = array(array("id" => "", "text" => "All"));
		// array_push($data, array("id" =>"" , "text" => "All"));
		if ($patientListObject->totalCount > 0) {
			foreach ($patientListObject->data as $patient) {
				if (!is_null($patient->patient_name)) {
					array_push($data, array("id" => (int)$patient->patient_id, "text" => $patient->patient_name));
				}

			}
		}

		$data = array_values(array_unique($data, SORT_REGULAR));

		$response["query"] = $patientListObject->last_query;
		$response["body"] = $data;
		echo json_encode($response);
	}

	public function getBackOrderTable()
	{
		$patient_id = $this->input->post('patient_id');
		$date = $this->input->post('date');
		$patientTable = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;

		$tableName = "com_1_medicine_order o";
		$d = "*";


		if ($patient_id == null) {
			$select = array("*", "(select pt.patient_name from " . $patientTable . " pt where pt.id=o.patient_id) as patient_name");
			$where = array("o.order_status" => 1, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id, "create_on >=" => date($date));
		} else {
			$select = array("*", "(select patient_name from " . $patientTable . " where id=" . $patient_id . ") as patient_name");
			$where = array("o.order_status" => 1, "patient_id" => $patient_id, "status" => 1, "confirm_status" => 1, "branch_id" => $this->session->user_session->branch_id, "create_on >=" => date($date));
		}


		$order = array('supplied_on' => 'desc');
		$group_by = array();
		$column_order = array('medicine_name');
		$column_search = array('medicine_name', "patient_name");

		$memData = $this->MedicineOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order, $group_by);
		// echo $this->db->last_query();
		$filterCount = $this->MedicineOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->MedicineOrderModel->countAll($tableName, $where);
		//
		// print_r($memData);exit();
		if (count($memData) > 0) {
			$tableRows = array();
			//
			foreach ($memData as $row) {


				$tableRows[] = array(
					$row->patient_name,
					$row->medicine_name,
					date('d-m-Y', strtotime($row->create_on)),
					$row->required_bu,

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

	public function getConsumableHistoryorderTable()
	{
		$p_id = $this->input->post('p_id');
		$patientTable = $this->session->user_session->patient_table;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = "com_1_consumable_material_item_table m";
		$d = "*";
		$select = array($d, "(select patient_name from " . $patientTable . " c where c.id=m.patient_id) as name ",
			"(select id from " . $patientTable . " c where c.id=m.patient_id) as p_id "
		);
		if (!is_null($p_id) && $p_id != "") {
			$where = "  order_id is not null AND branch_id='" . $branch_id . "' and patient_id='" . $p_id . "'  group by order_id";
		} else {
			$where = "  order_id is not null AND branch_id='" . $branch_id . "' group by order_id";
		}


		$order = array('supplied_on' => 'desc');
		$group_by = array();
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

	public function getItemConsumableHistory()
	{
		$order_id = $this->input->post('order_id');
		$patientTable = $this->session->user_session->patient_table;
		$query = $this->db->query("select *,(select cp.patient_name from " . $patientTable . " cp where cp.id=patient_id) as patient_name from com_1_consumable_material_item_table where order_id='" . $order_id . "'");
		$data = "";
		$data .= "<table class='table table-bordered' id='ConsumablehistoryItemTable' style='border-collapse: separate!important'>
		<thead>
		<tr>
		<th>Patient Name</th>
		<th>Consumable Name</th>
		<th>Unit</th>
		<th>Required Quantity</th>
		<th>Supply Quantity</th>
		<th>Alternative Consumable</th>	
		<th>Total</th>
		</tr>
		</thead>
		<tbody>
		";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();

			foreach ($result as $row) {
				if (is_null($row->material_total)) {
					$mtotal = 0;
				} else {
					$mtotal = $row->material_total;
				}
				$data .= "<tr>
				<td>" . $row->patient_name . "</td>
				<td>" . $row->material_description . "</td>
				<td>" . $row->unit . "</td>
				<td>" . $row->quantity . "</td>
				<td>" . $row->supply_quantity . "</td>
				<td>" . $row->alt_consumable . "</td>
				<td>" . $mtotal . "</td>
				
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

	public function GetHospitalOrderMedicine()
	{
		$dept_id = $this->input->post('dept_id');
		$e = explode("|", $dept_id);
		$zone_id = $e[1];
		$order_id = $e[0];
		$data = "";
		if (!is_null($dept_id)) {
			$orderDetails = $this->MedicineOrderModel->getHospOrdersByPatient($zone_id, $order_id);

			$response["query"] = $this->db->last_query();
			if ($orderDetails->totalCount > 0) {
				$data .= '<input type="hidden" id="ord_id" name="ord_id" value="' . $order_id . '">';

				foreach ($orderDetails->data as $order) {
					$hoverButton = "";
					$material_name = $order->material_description;
					$quantity = $order->quantity;
					$unit = $order->unit;
					$id = $order->id;
					$group_name = $order->group_name;
					$department = $order->department;

					$data .= '
							<tr>
								<td>' . $material_name . '</td>
								<td>' . $unit . '</td>
								<td>' . $department . '</td>
								<td>' . $group_name . '</td>
								
								<td>' . $quantity . '<input type="hidden" value="' . $quantity . '"  name="act_q_' . $id . '" id="act_q_' . $id . '"></td>
								<td><input type="number" class="form-control" data-h_supply_order_id="' . $id . '" oninput="h_get_sum_rate(' . $id . ')" value="' . $quantity . '" id="h_supply_quantity_' . $id . '" name="h_supply_quantity_' . $id . '"></td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="h_ck_order_medicine[]" data-h_order_id="' . $id . '" onchange="h_updateCalculation(this,' . $id . ')" id="h_ck_order_medicine_' . $id . '" checked value="' . $id . '">
									
								</div>
								</td>
								<td><input type="text" name="alt_medicine_' . $id . '" class="form-control">
								
								</td>
								<td><input type="number" min="0" value="0"  id="h_rate_medicine_' . $id . '"  name="h_rate_medicine_' . $id . '" oninput="h_get_sum_rate(' . $id . ')" class="form-control">
								
								</td>
								<td><input type="number" min="0.1" value="0"  id="h_total_medicine_' . $id . '"  name="h_total_medicine_' . $id . '" oninput="h_get_total_rate(' . $id . ')" class="form-control">
								
								</td>
								<td>
								<input type="checkbox" name="h_rck_order_medicine[]" id="h_rck_order_medicine_' . $id . '"  value="' . $id . '">
								
								</td>
								
							</tr>							
							';


				}
				$response['status'] = 200;
				$response['data'] = $data;
			} else {
				$response['status'] = 201;
				$response['data'] = $data;
			}
		} else {
			$response['status'] = 201;
			$response['data'] = $data;
		}
		echo json_encode($response);
	}


	function getDeptOrder()
	{
		$branch_id = $this->session->user_session->branch_id;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$sql = "select h.id,h.zone_id,
		(select group_concat(r.room_no,'_',r.ward_no) from " . $hospital_room_table . " r where r.id=h.zone_id) 
		as zone from hospital_order_management h where department 
		is not null and h.is_supplied=0 and h.receive_status=0   and 
		h.id in(select material_order_id from hospital_material_item_table where is_return=0) and zone_id is not null and h.return_status is null and h.branch_id=" . $branch_id;

		$query = $this->db->query($sql);
		$option = "";
		if ($this->db->affected_rows() > 0) {
			$option .= "<option value='-1' selected disabled>Selct Zone</option>";
			$result = $query->result();
			foreach ($result as $row) {
				$option .= "<option value='" . $row->id . "|" . $row->zone_id . "'>" . $row->zone . " HOS_" . $row->id . "</option>";
			}
			$response['status'] = 200;
			$response['data'] = $option;
		} else {
			$response['status'] = 201;
			$response['data'] = $option;
		}
		echo json_encode($response);
	}

	function getDeptReturnOrder()
	{
		$branch_id = $this->session->user_session->branch_id;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$sql = "select h.id,h.zone_id,
		(select group_concat(r.room_no,'_',r.ward_no) from " . $hospital_room_table . " r where r.id=h.zone_id) 
		as zone from hospital_order_management h where department 
		is not null  and 
		h.id in(select material_order_id from hospital_material_item_table where is_return=1 AND return_accepted=0) and zone_id is not null and h.return_status is null and h.branch_id=" . $branch_id;


		$query = $this->db->query($sql);
		$option = "";
		if ($this->db->affected_rows() > 0) {
			$option .= "<option value='-1' selected disabled>Selct Zone</option>";
			$result = $query->result();
			foreach ($result as $row) {
				$option .= "<option value='" . $row->id . "|" . $row->zone_id . "'>" . $row->zone . " HOS_" . $row->id . "</option>";
			}
			$response['status'] = 200;
			$response['data'] = $option;
		} else {
			$response['status'] = 201;
			$response['data'] = $option;
		}
		echo json_encode($response);
	}

	public function GetHospitalReturnMedicine()
	{

		$validObject = $this->is_parameter(array("zone_id"));
		$data = "";
		if ($validObject->status) {

			$zone_id = $validObject->param->zone_id;
			$exp = explode("|", $zone_id);
			$order_no = $exp[0];
			$orderDetails = $this->MedicineOrderModel->getOrdersReturnByhospital($order_no);
			//var_dump($orderDetails);
			if ($orderDetails->totalCount > 0) {

				foreach ($orderDetails->data as $order) {
					$data .= '
							<tr>
								<td>' . $order->material_description . '</td>
								<td>' . $order->unit . '</td>
								<td>' . abs($order->quantity) . '<input type="hidden" value="' . abs($order->quantity) . '" name="h_r_qunatity_' . $order->id . '"></td>
								<td> HOS_' . $order->material_order_id . '</td>
								<td>
								<div class="align-items-center d-flex justify-content-around">
								<input type="checkbox" name="h_ck_order_return_medicine[]" id="h_ck_return_order_medicine_' . $order->id . '" checked value="' . $order->id . '">
									
								</div>
								</td>
								<td><input type="number" min="0.1" id="return_amount_' . $order->id . '" value="0" name="return_amount_' . $order->id . '" class="form-control"></td>
								<td><input type="text" name="h_return_reason_' . $order->id . '" class="form-control">
								
								
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

	public function SaveHospitalReturnOrder()
	{
		$validObject = $this->is_parameter(array("h_invoice_return_number", "h_ck_order_return_medicine"));
		if ($validObject->status) {

			$param = $validObject->param;
			// print_r($param->patient_id);exit();
			$billingTransactionTable = $this->session->user_session->billing_transaction;
			if (count($param->h_ck_order_return_medicine) > 0) {
				$order_id = $this->Global_model->generate_order("select receive_order_number from hospital_material_item_table where receive_order_number = '#id'");

				$reason = "";
				$cnt = 0;
				foreach ($param->h_ck_order_return_medicine as $medicine) {
					if (!is_null($this->input->post("h_return_reason_" . $medicine))) {
						$reason = $this->input->post("h_return_reason_" . $medicine);
					}
					$return_amount = $this->input->post("return_amount_" . $medicine);
					$supply_quantity = $this->input->post("h_r_qunatity_" . $medicine);
					$data = array(
						"return_invoice_reason" => $reason,
						"return_invoice_number" => $param->h_invoice_return_number,
						"supply_quantity" => (-$supply_quantity),
						"supplier_unit_price" => (-$return_amount),
						"return_accepted" => 1,
						"is_receive" => 1,
						"retrun_order_id" => ($order_id),
					);
					$this->db->where(array("id" => $medicine));
					$update = $this->db->update("hospital_material_item_table", $data);
					if ($update == true) {
						$cnt++;
					}
				}

				if ($cnt > 0) {
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

	function getHospHistoryorderTable()
	{
		$dept_id = $this->input->post('dept_id');
		$branch_id = $this->session->user_session->branch_id;
		$hospital_room_table = $this->session->user_session->hospital_room_table;
		$tableName = "hospital_order_management m";
		$d = "*";
		$select = array($d,
			"(select group_concat(r.room_no,'_',r.ward_no) from " . $hospital_room_table . " r where r.id=m.zone_id) 
		as zone ");
		if ($dept_id == null) {
			$where = array("is_supplied" => 1, "branch_id" => $branch_id);
		} else {
			$where = array("is_supplied" => 1, "branch_id" => $branch_id);
		}


		$order = array('supplied_on' => 'desc');
		$group_by = array();
		$column_order = array();
		$column_search = array('order_id', "invoice_number");

		$memData = $this->MedicineOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order, $group_by);

		$filterCount = $this->MedicineOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->MedicineOrderModel->countAll($tableName, $where);
		//	echo $this->db->last_query();
		if (count($memData) > 0) {
			$tableRows = array();
			// print_r($memData);exit();
			foreach ($memData as $row) {


				$tableRows[] = array(
					$row->order_no,
					$row->supplier_invoice_number,
					$row->department,
					date('d-m-Y', strtotime($row->supplied_on)),
					$row->id,
					$row->zone

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

	public function getItemHospitalHistory()
	{
		$order_id = $this->input->post('order_id');
		$patientTable = $this->session->user_session->patient_table;
		$query = $this->db->query("select *,
		(select supplier_invoice_number from hospital_order_management
		h where h.id=material_order_id) as invoice_number from hospital_material_item_table where material_order_id='" . $order_id . "'");
		$data = "";
		$data .= "<table class='table table-bordered' id='HospitalhistoryItemTable' style='border-collapse: separate!important'>
		<thead>
		<tr>
		<th>Material Name</th>
		<th>OrderID</th>
		<th>Unit</th>
		<th>Required Quantity</th>
		<th>Supply Quantity</th>
		<th>Alternative Material</th>	
		<th>Total</th>
		</tr>
		</thead>
		<tbody>
		";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();

			$tt = 0;
			foreach ($result as $row) {
				$data1 = "<h5>Invoice Number : " . $row->invoice_number . "</h5>";
				$tt = $tt + $row->supplier_unit_price;
				$data .= "<tr>
				<td>" . $row->material_description . "</td>
				<td>HOS_" . $row->material_description_id . "</td>
				<td>" . $row->unit . "</td>
				<td>" . $row->quantity . "</td>
				<td>" . $row->supply_quantity . "</td>
				<td>" . $row->alternative_medicine . "</td>
				<td>" . $row->supplier_unit_price . "</td>
				
				</tr>";
			}
			$data .= "</tbody>
			<table>";
			$data2 = "<h5>Invoice Amount : " . $tt . "</h5>";
			$response['status'] = 200;
			$response['data'] = $data1 . $data2 . $data;
		} else {
			$response['status'] = 201;
			$response['data'] = "";
		}
		echo json_encode($response);
	}

}
