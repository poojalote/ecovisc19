<?php

require_once 'HexaController.php';

/**
 * @property  User User
 * @property  medicine_model medicine_model
 */
class medicineController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('medicine_model');


	}

	public function view_medicine_master()
	{
		$this->load->view('Medicine/medicine_master', array('title' => "Medicine"));
	}

	public function view_prescription_master()
	{
		$this->load->view('Medicine/prescription_master', array('title' => "Medicine"));
	}

	public function medicine()
	{
		$this->load->view('Medicine/medicineManagement', array('title' => "Medicine"));
	}

	public function medicine_data()
	{

		$tableName = "medicine_master";
		$select = array("name", "id", "bu", "pkt");
		$order = array('create_on' => 'asc');
		$column_order = array('name',);
		$column_search = array("name", "bu");
		$where = array("status" => 1);

		$memData = $this->medicine_model->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

		$filterCount = $this->medicine_model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->medicine_model->countAll($tableName, $where);

		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$tableRows[] = array(
					$row->name,
					$row->bu,
					$row->pkt,
					$row->id,
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

	public function getMedicineOptions()
	{

		$validObject = $this->is_parameter(array("type", "searchTerm"));
		$response = array();
		if ($validObject->status) {

			$type = $validObject->param->type;
			$search = $validObject->param->searchTerm;
			$where = array();
			if ((int)$type != 1)
				$where = array("group_id" => $type);
			$userData = $this->db->select(array("id", "name"))->where($where)->like("name", $search)->limit(10, 0)->get("medicine_master")->result();
			$response["last_query"] = $this->db->last_query();
			$data = array();
			if (count($userData) > 0) {
				foreach ($userData as $user) {
					array_push($data, array("id" => $user->id, "text" => $user->name));
				}
			}
			$response["body"] = $data;
		} else {
			$response["body"] = array();
		}
		echo json_encode($response);
	}

	public function getMedicine_option()
	{
		$facility = $this->session->user_session->company_id;
		$group_id = $this->input->post("group_id");
		if (!is_null($group_id)) {
			$query = $this->db->query("select id,name from medicine_master where status =1 and group_id=" . $group_id);
		} else {
			$query = $this->db->query("select id,name from medicine_master where status =1");
		}


		$options = "No Data Found";
		$list = "No Data Found";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			$options = "<option value=''>Select Medicine</option>";
			$list = "";
			foreach ($result as $medicine) {
				$options .= "<option value='" . $medicine->id . "'>" . $medicine->name . "</option>";
				$list .= "<li><a href='#'>" . $medicine->name . "</a></li>";
			}


			$response["status"] = 200;
			$response["body"] = $options;
			$response["list"] = $list;
		} else {
			$response["status"] = 201;
			$response["body"] = $options;
			$response["list"] = $list;
		}
		echo json_encode($response);
	}

	public function add_medicine_fun()
	{
		$facility = $this->session->user_session->company_id;
		$medicine_name = $this->input->post('medi_name');
		$group_id = $this->input->post('group_name');
		$bu = $this->input->post('unit_of_measure');
		$pkt = $this->input->post('pkt_value');
		//check medicine alredy added
		$query = $this->db->query("select name from medicine_master where name='$medicine_name'");
		if ($this->db->affected_rows() > 0) {
			$response['status'] = 201;
			$response['body'] = "This medicine is alredy added.";
		} else {
			$data = array(
				"name" => $medicine_name,
				"group_id" => $group_id,
				"bu" => $bu,
				"pkt" => $pkt,
				"facility" => $facility,
				"status" => 1,
				"create_on" => date("Y-m-d H:i:s")
			);
			$insert = $this->db->insert("medicine_master", $data);
			if ($insert == true) {
				$response['status'] = 200;
				$response['body'] = "Medicine Added Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Fail to add medicine.";
			}
		}
		echo json_encode($response);
	}

	function updatePatientMedicine()
	{
		$validObject = $this->is_parameter(array("id"));
		if ($validObject->status) {

			$resultObject = $this->medicine_model->_update($this->session->user_session->patient_mediine_table, array('active' => 1), array('id' => $validObject->param->id));
			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Activate Medicine";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed Activate Medicine";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	function getDoesHistory()
	{
		if (!is_null($this->input->post('p_id'))) {
			$company_id = $this->session->user_session->company_id;
			$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
			$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
			//print_r($patient_medicine_history_table);exit();
			$p_id = $this->input->post('p_id');
			$patient_reschedule_medicine_table = "com_1_reschedule_medicine";
			$branch_id = $this->session->user_session->branch_id;
			$resultArray = $this->medicine_model->getDoesHistoryOfPatient($p_id, $company_id, $patient_mediine_table, $patient_medicine_history_table, $patient_reschedule_medicine_table, $branch_id);
			$response["query"] = $resultArray;
			// print_r($this->db->last_query());exit();
			$currentDateTime = date('Y-m-d');
			$currentDateDoesArray = array();
			$isCurrentDateAvailabel = false;
			if (count($resultArray->data) > 0) {
				$doesArray = $resultArray->data;
				$sortArray = array();
				$doesDate = array();
				foreach ($doesArray as $item) {

					if ($item->ite_details != "" && $item->ite_details != null) {
						$doesObject = new stdClass();
						$doesObject->startDate = $item->start_date;
						$doesObject->end_date = $item->end_date;
						$doesObject->id = $item->id;
						$doesObject->total_iteration = $item->total_iteration;
						$doesObject->name = $item->name;
						$doesObject->medicineName = $item->m_name;
						$doesObject->pid = $item->p_id;
						$doesObject->active = $item->active;
						$dates = $this->getDatesFromRange($item->start_date, $item->end_date);
						$doesObject->rescheduleDoes = $this->getRescheduleDoes($item);
						if (!is_null($doesObject->rescheduleDoes)) {
							foreach ($doesObject->rescheduleDoes as $does) {
								array_push($dates, $does->reschedule_date);
							}
						}
						$doesObject->dateRange = array_unique($dates);
						$iteration_onArray = explode(',', $item->ite_details);
						$iterationDoes = array();
						foreach ($iteration_onArray as $iteration_on) {
							$item_detials = explode('|', $iteration_on);
							if (count($item_detials) >= 5) {
								$obj = new stdClass();
								$obj->item = $item->id;
								$obj->iterationNo = $item_detials[0];
								$obj->iterationDate = $item_detials[1];
								$obj->iterationDatetime = $item_detials[2];
								$obj->iterationOuttime = $item_detials[3];
								$obj->out_status = $item_detials[4];
								array_push($iterationDoes, $obj);
							}
						}
						$doesObject->confirm_status="";
						$doesObject->order_status="";
						$doesObject->alt_medicine="";
						if($item->order_status!=null && $item->order_status!="")
						{
							$order_status_onArray = explode('||', $item->order_status);
							if (count($order_status_onArray) > 2) {
								$doesObject->confirm_status = $order_status_onArray[0];
								$doesObject->order_status = $order_status_onArray[1];
								$doesObject->alt_medicine = $order_status_onArray[2];
							}
						}
						
						$doesObject->remark = $item->remark;
						$doesObject->flowRate_chk = $item->flowRate_chk;
						$doesObject->flowRate_text = $item->flowRate_text;
						$doesObject->route = $item->route;
						$doesObject->quantity = $item->quantity;
						$doesObject->itrationData = $iterationDoes;
						array_push($sortArray, $doesObject);
					} else {
						$doesObject = new stdClass();
						$doesObject->medicineName = $item->m_name;
						$doesObject->startDate = $item->start_date;
						$doesObject->end_date = $item->end_date;
						$doesObject->id = $item->id;
						$doesObject->active = $item->active;
						$doesObject->total_iteration = $item->total_iteration;
						$doesObject->name = $item->name;
						$doesObject->pid = $item->p_id;
						$iterationDoes = array();
						$doesObject->itrationData = $iterationDoes;
						$doesObject->remark = $item->remark;
						$doesObject->flowRate_chk = $item->flowRate_chk;
						$doesObject->flowRate_text = $item->flowRate_text;
						$doesObject->route = $item->route;
						$doesObject->quantity = $item->quantity;
						$dates = $this->getDatesFromRange($item->start_date, $item->end_date);

						$doesObject->confirm_status="";
						$doesObject->order_status="";
						$doesObject->alt_medicine="";
						if($item->order_status!=null && $item->order_status!="")
						{
							$order_status_onArray = explode('||', $item->order_status);
							if (count($order_status_onArray) > 2) {
								$doesObject->confirm_status = $order_status_onArray[0];
								$doesObject->order_status = $order_status_onArray[1];
								$doesObject->alt_medicine = $order_status_onArray[2];
							}
						}

						$doesObject->rescheduleDoes = $this->getRescheduleDoes($item);
						if (!is_null($doesObject->rescheduleDoes)) {
							foreach ($doesObject->rescheduleDoes as $does) {
								array_push($dates, $does->reschedule_date);
							}
						}

						$doesObject->dateRange = array_unique($dates);
						array_push($sortArray, $doesObject);
					}
				}


				$template = "";
				$response["sort"] = $sortArray;
				$currentDateTime = date('Y-m-d');
				$todayDoesTable = "<table style='width:100%;font-size: 12px'
												   class='table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display'
												   cellspacing='0'><thead><tr><th colspan='6'>Today Schedule Medicine</th></tr></thead>";
				$todayDoesRow = "";
				foreach ($sortArray as $doesObject) {
					$doesRecord = count($doesObject->dateRange);
					$deleteMedicine = '';
					if ((int)$doesObject->active == 1) {
						$template .= "<tr><td rowspan='" . $doesRecord . "'>" . $doesObject->medicineName . " </td>";
					} else {
						$template .= "<tr><td rowspan='" . $doesRecord . "'>" . $doesObject->medicineName . "<span class='text-danger'>Deleted</span> <button class='btn btn-link btn-sm' onclick='deleteActivate(" . $doesObject->id . ")'>To Activate click</button></td>";
					}

					// does date from start to end date
					foreach ($doesObject->dateRange as $doesDate) {

						$alreadyGivenIterationDoes = count($doesObject->itrationData);
						$template .= "<td>" . $doesDate . "</td>";
						$todaysDoesIteration = "";
						$total_iteration = (int)$doesObject->total_iteration;
						if ($doesObject->rescheduleDoes != null) {
							$new_total_iteration = $this->rescheduleDoes($doesObject->rescheduleDoes, $doesDate);
							if ($new_total_iteration != -1) {
								$total_iteration = $new_total_iteration;
							}
						}
						// check already does given or not if not goes in else case other wise go for set date time to that td

						if ($alreadyGivenIterationDoes > 0) {
							$givenDoes = $doesObject->itrationData;

							// iterated for each check box
							for ($i = 1; $i < 6; $i++) {

								$comment_m=" <i class='fa fa-comment comment_pointer ml-1' onclick='addMedicineComment(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)'></i> ";

								if ($i <= (int)$total_iteration) {
									$datetime = "";
									$iteration_in = 0;
									$outdatetime = "";
									foreach ($givenDoes as $g_does) {
										if ((int)$g_does->iterationNo == $i && $g_does->iterationDate == $doesDate) {
											$datetime = date('h:i a', strtotime($g_does->iterationDatetime));
											$iteration_in = $g_does->out_status;
											$outdatetime = date('h:i a', strtotime($g_does->iterationOuttime));
											break;
										}
									}
									if ($datetime != "") {

										if ($doesObject->flowRate_chk == 1) {
											if ($iteration_in == 1) {
												$template .= "<td><span class='color_in'>In: </span>" . $datetime . " - <span class='color_out'> out: </span>" . $outdatetime . " <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
												$todaysDoesIteration .= "<td><span class='color_in'>In: </span>" . $datetime . " - <span class='color_out'> out: </span>" . $outdatetime . "  <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
											} else {
												$template .= "<td><input type='checkbox' data-if='yes' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`," . $doesObject->flowRate_chk . ")' class='mr-1' /> ".$comment_m." <span class='color_in p-1'>   In: </span>" . $datetime . " <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
												$todaysDoesIteration .= "<td><input type='checkbox' data-if='no' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`," . $doesObject->flowRate_chk . ")' class='mr-1' /> ".$comment_m." <span class='color_in'>  In: </span>" . $datetime . "   <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
											}


										} else {
											$template .= "<td>" . $datetime . "  <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
											$todaysDoesIteration .= "<td>" . $datetime . "  <i class='fa fa-window-close p-1' onclick='clearDoesEntry(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ")'></i></td>";
										}
									} else {
										

										$template .= "<td><input type='checkbox' data-if='yes' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)' /> ".$comment_m."</td>";
										$todaysDoesIteration .= "<td><input type='checkbox' data-if='no' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)' /> ".$comment_m."</td>";

									}


								} else {
									$template .= "<td>-</td>";
									$todaysDoesIteration .= "<td>-</td>";
								}
							}
						} else {

							for ($i = 1; $i < 6; $i++) {
								// create check box upto total iteration
								$comment_m=" <i class='fa fa-comment comment_pointer ml-1' onclick='addMedicineComment(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)'></i> ";

								if ($i <= (int)$total_iteration) {
									
										

									$template .= "<td><input type='checkbox' data-else='yes' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)' /> ".$comment_m."</td>";
									$todaysDoesIteration .= "<td><input type='checkbox' data-else='no' onchange='doesGiven(" . $doesObject->pid . "," . $doesObject->id . "," . $i . ",`$doesDate`)' /> ".$comment_m."</td>";
								} else {
									$template .= "<td>-</td>";
									$todaysDoesIteration .= "<td>-</td>";
								}
							}
						}
						$template .= "</tr>";
						// today does iteration
						//get confirm status from order table
						$medicionOrderTable = "com_1_medicine_order";
						$confirm_status = "";
						$order_status = "";
						$checked = "";
						// $sql = "select confirm_status,order_status from " . $medicionOrderTable . " where medicine_id=" . $doesObject->name . " AND patient_id=" . $p_id;
						// $query = $this->db->query($sql);
						// if ($this->db->affected_rows() > 0) {
							// $confirm_status = $query->row()->confirm_status;
							// $order_status = $query->row()->order_status;
						// }
						$confirm_status = $doesObject->confirm_status;
						$order_status = $doesObject->order_status;
						$sts = 2;
						if ($confirm_status == 2) {
							$checked = "checked";
							$sts = 1;
						}

						$disabled = "";
						if ($order_status == 3) {
							$disabled = "disabled";
						}
						if ($doesObject->route !== "" && !is_null($doesObject->route)) {
							if($doesObject->route=="null")
							{
								$route = "Rt:NA";
							}
							else
							{
								$route = "Rt:" . $doesObject->route;
							}
							

						} else {
							$route = "";
						}
						if ($doesObject->quantity !== "" && !is_null($doesObject->quantity)) {
							if(!(int)$doesObject->quantity)
							{
								$quantity = "Qty:1";
							}
							else
							{
								$quantity = "Qty:" . $doesObject->quantity;
							}
							
						} else {
							$quantity = "";
						}

						if ($currentDateTime == $doesDate) {
							if ((int)$doesObject->active == 1) {

								if ((int)$total_iteration != 0) {
									$todayDoesRow .= "<tr><td colspan='6'>
								<div class='box'><span class='mx-2'>" . $doesDate . "</span>
								<span class='mx-2 '>" . $doesObject->medicineName . "</span>";
								
								if ($doesObject->alt_medicine != "" && $doesObject->alt_medicine != "0")
								{
									
									$todayDoesRow .="<span class='mx-2'><i class='text-danger  font-weight-bold'>Alternative Medicine - </i>" . $doesObject->alt_medicine . "</span>";
								}
								$todayDoesRow .="
								<span class='mx-2 text-danger font-weight-bold'>" . $doesObject->remark . "</span>
								<span class='mx-2 text-danger font-weight-bold'>" . $doesObject->flowRate_text . "</span>
								<span class='mx-2 text-primary font-weight-bold'>" . $route . "</span>
								<span class='mx-2 text-primary font-weight-bold'>" . $quantity . "</span>
								<i class='fa fa-pen px-2' style='cursor:pointer' data-id='" . $doesObject->id . "' data-pid='" . $p_id . "' data-flow_rate='" . base64_encode($doesObject->flowRate_chk) . "' data-flow_text='" . base64_encode($doesObject->flowRate_text) . "' data-remark='" . base64_encode($doesObject->remark) . "' data-route='" . base64_encode($doesObject->route) . "' data-quantity='" . base64_encode($doesObject->quantity) . "' data-toggle='modal' data-target='#update_modal'></i>
								<i class='fa fa-trash px-2' style='cursor:pointer' data-id='" . $doesObject->id . "' data-pid='" . $p_id . "'   data-toggle='modal' data-target='#edit_modal'></i>
								Home Medication <input type='checkbox' " . $checked . " " . $disabled . " class='' onclick='availabWPatient(" . $doesObject->pid . "," . $doesObject->name . "," . $sts . ")' >
								</div></td></tr>";
									$todayDoesRow .= "<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>";
									$todayDoesRow .= "<tr>" . $todaysDoesIteration . "</tr>";

								}
							}
						}
					}

				}
				if ($todayDoesRow == "") {
					$todayDoesTable .= "<tr><td>No Medicine are schedule View History Or Schedule  Medicine</td></tr>";
				} else {
					$todayDoesTable .= $todayDoesRow;
				}
				$todayDoesTable .= "</table>";
				$response["status"] = 200;
				$response["body"] = $template;
				$response["currentArray"] = $todayDoesTable;

			} else {
				$todayDoesTable = "<table style='width:100%;font-size: 12px'
												   class='table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display'
												   cellspacing='0'><thead><tr><th colspan='6'>Today's Schedule of Medicines</th></tr></thead>";
				$todayDoesTable .= "<tr><td>No Medicine are schedule  View History Or Schedule  Medicine</td></tr>";
				$todayDoesTable .= "</table>";
				$response["status"] = 201;
				$response["body"] = 'No Does Assign';
				$response["currentArray"] = $todayDoesTable;
			}
		} else {
			$response["status"] = 202;
			$response["body"] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}


	function getDateValue()
	{
		var_dump($this->getDatesFromRange('2021-05-27', '2021-05-27'));
	}

	function getDatesFromRange($start, $end, $format = 'Y-m-d')
	{

		// Declare an empty array
		$array = array();

		// Variable that store the date interval
		// of period 1 day
		$interval = new DateInterval('P1D');
		if ($end != "0000-00-00 00:00:00") {
			$realEnd = new DateTime($end);
		} else {
			$realEnd = new DateTime(date('Y-m-d'));
		}
		$realEnd->add($interval);

		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

		// Use loop to store date into array
		foreach ($period as $date) {
			$array[] = $date->format($format);
		}

		// Return the array elements
		return $array;
	}

	public function update_medicine()
	{
		$header = $this->is_parameter(array("u_medicine_id", "u_p_id"));

		if ($header->status) {

			$remark = $this->input->post("u_remark");
			$route = $this->input->post("u_route");
			$quantity = $this->input->post("u_quantity");
			$flow_rate = $this->input->post("u_flow_rate_update");
			$flow_rate_check = $this->input->post("u_flow_rate_check");

			$updateData = array();
			if (!is_null($remark)) {
				$updateData["remark"] = $remark;
			}
			if (!is_null($route)) {
				$updateData["route"] = $route;
			}
			if (!is_null($quantity)) {
				$updateData["quantity"] = $quantity;
			}
			if (!is_null($flow_rate_check)) {
				$updateData["flowRate_chk"] = 1;
				if (!is_null($flow_rate)) {
					$updateData["flowRate_text"] = $flow_rate;
				}
			}

			$table = $this->session->user_session->patient_mediine_table;
			$resultObject = $this->medicine_model->_update($table, $updateData, array("p_id" => $header->param->u_p_id, "id" => $header->param->u_medicine_id));
			$response["query"] = $resultObject->last_query;
			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Successfully Update Medicine Details";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Update";
			}


		} else {
			$response["status"] = 201;
			$response["body"] = "Missing Parameter";
		}
		echo json_encode($response);
	}

	public function add_patientmedicine_fun()
	{

		$medicine_name = $this->input->post('medicine_list');
		$patient_name = $this->input->post('patient_list');
		$Start_Date_new = $this->input->post('Start_Date_new');
		$End_Date_new = $this->input->post('End_Date_new');
		$Per_Day_Schedule_new = $this->input->post('Per_Day_Schedule_new');
		$prescription_objective = $this->input->post('prescription_objective');
		$Remark_new = $this->input->post('Remark_new');
		$chk = $this->input->post('chk');
		$flowRate_new = $this->input->post('flowRate_new');
		$flowratechk = $this->input->post('flowratechk');
		$ms_route = $this->input->post('ms_route');
		$ms_quantity = $this->input->post('ms_quantity');
		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table

		$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table

		if ($End_Date_new == "" || $chk == "on") {
			$End_Date_new = 0;
		}
		$flowRate_chk = 0;
		$flowRate_text = "";
		if ($flowratechk == "on") {
			$flowRate_chk = 1;
			$flowRate_text = $flowRate_new;
		}
		$medicionOrderTable = "com_1_medicine_order";
		//check medicine alredy added
		$query = $this->db->query("select id from " . $patient_mediine_table . " where name='$medicine_name' AND p_id='$patient_name' AND status='1' AND branch_id='" . $branch_id . "'");
		if ($this->db->affected_rows() > 0) {
			$response['status'] = 201;
			$response['body'] = "This medicine is already schedule extend that from medicine history.";
			echo json_encode($response);
			exit();
		} else {
			$query = $this->db->query("select * from " . $patient_mediine_table . " where name='$medicine_name' AND p_id='$patient_name' AND status='1' AND branch_id='" . $branch_id . "' order by create_on DESC");
			if ($this->db->affected_rows() > 0) {
				$result = $query->result();
				// print_r($result);
				foreach ($result as $key => $value) {
					$date1 = date('Y-m-d', strtotime($value->end_date));
					$date2 = date('Y-m-d', strtotime($Start_Date_new));
					if ($date2 <= $date1) {
						$response['status'] = 201;
						$response['body'] = "Medicine Already Schedule for Some days";
						echo json_encode($response);
						exit();
					}
				}


			}
			try {
				$this->db->trans_start();
				$data = array(
					"name" => $medicine_name,
					"p_id" => $patient_name,
					"status" => 1,
					"start_date" => $Start_Date_new,
					"end_date" => $End_Date_new,
					"objective" => $prescription_objective,
					"remark" => $Remark_new,
					"branch_id" => $branch_id,
					"create_on" => date("Y-m-d H:i:s"),
					"total_iteration" => $Per_Day_Schedule_new,
					"flowRate_chk" => $flowRate_chk,
					"flowRate_text" => $flowRate_text,
					"route" => $ms_route,
					"quantity" => $ms_quantity,
				);
				$dateRang = $this->getDatesFromRange($Start_Date_new, $End_Date_new);

				$totalDay = count($dateRang);
				$medicineObject = new stdClass();

				$requiredQty = (int)$Per_Day_Schedule_new * $totalDay;
				$medicineObject->required_bu = $requiredQty;
				$medicineObject->patient_id = $patient_name;
				$medicineObject->branch_id = $this->session->user_session->branch_id;
				$medicineObject->create_on = date('Y-m-d h:i:s');
				$medicineResultObject = $this->medicine_model->_select("medicine_master", array('id' => $medicine_name), array("id", "name", "bu", "pkt"));
				if ($medicineResultObject->totalCount > 0) {
					$medicineObject->medicine_name = $medicineResultObject->data->name;
					$medicineObject->medicine_id = $medicineResultObject->data->id;
					$medicineObject->default_bu = $medicineResultObject->data->bu;
					$medicineObject->default_pkt = $medicineResultObject->data->pkt;
				}
				$this->db->insert($patient_mediine_table, $data);
				$this->db->insert($medicionOrderTable, (array)$medicineObject);
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


			if ($result == true) {
				$response['status'] = 200;
				$response['body'] = "Medicine Scheduled with Patient Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Fail to Scheduled medicine.";
			}
		}
		echo json_encode($response);
	}

	public function updatetDoesHistory()
	{
		if (!is_null($this->input->post('p_id')) && !is_null($this->input->post('ite_count')) && !is_null($this->input->post('does_id')) && !is_null($this->input->post('ite_date'))) {

			$p_id = $this->input->post('p_id');
			$does_id = $this->input->post('does_id');
			$ite_count = $this->input->post('ite_count');
			$ite_date = $this->input->post('ite_date');
			$flowrate = $this->input->post('flowrate');
			$company_id = $this->session->user_session->company_id;
			$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
			$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
			if (!empty($flowrate) && $flowrate == 1) {
				$where = array('p_id' => $p_id,
					'iteration_count' => $ite_count,
					'iteration_on' => $ite_date,
					'status' => 1,
					'does_details_id' => $does_id);
				$dataArray = array('iteration_outime' => date('Y-m-d H:i:s'),
					'out_status' => 1);
				$resultObject = $this->medicine_model->update_icu_does_iteration($dataArray, $patient_medicine_history_table, $where);
			} else {
				$dataArray = array(
					'p_id' => $p_id,
					'iteration_count' => $ite_count,
					'does_details_id' => $does_id,
					'iteration_on' => $ite_date,
					'status' => 1,
					'iteration_time' => date('Y-m-d H:i:s')
				);

				$resultObject = $this->medicine_model->add_icu_does_iteration($dataArray, $patient_medicine_history_table);
			}


			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = 'Upadate Successfully';
			} else {
				$response["status"] = 201;
				$response["body"] = 'Failed To Update';
			}
		} else {
			$response["status"] = 202;
			$response["body"] = 'Required Parameter Missing';
		}
		echo json_encode($response);
	}

	function get_medicine_data_new()
	{
		$patient_id = $this->input->post('patient_id');
		$medi_id = $this->input->post('medi_id');
		$company_id = $this->session->user_session->company_id;
		$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
		$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table

		$query = $this->db->query("select * from " . $patient_mediine_table . " where name='$medi_id' AND p_id='$patient_id'");
		// echo $this->db->last_query();
		// exit;
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();

			$response['data'] = $result;
			$response['status'] = 200;
		} else {
			$response['data'] = "";
			$response['status'] = 200;
		}
		echo json_encode($response);
	}

	public function update_patientmedicine_fun()
	{
		$Start_Date_new = $this->input->post('e_Start_Date_new');
		$End_Date_new = $this->input->post('e_End_Date_new');
		$Per_Day_Schedule_new = $this->input->post('e_Per_Day_Schedule_new');
		$e_medicine_id = $this->input->post('e_medicine_id');
		$e_p_id = $this->input->post('e_p_id');
		$company_id = $this->session->user_session->company_id;
		$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
		$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
		$chk = $this->input->post('e_chk');
		if ($End_Date_new == "" || $chk == "on") {
			$End_Date_new = 0;
		}
		$set = array(
			"start_date" => $Start_Date_new,
			"end_date" => $End_Date_new,
			"total_iteration" => $Per_Day_Schedule_new
		);
		$where = array(
			"name" => $e_medicine_id,
			"p_id" => $e_p_id
		);
		$query = $this->db->update($patient_mediine_table, $set, $where);
		if ($query == true) {
			$response['status'] = 200;
			$response['body'] = "Updated Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Fail to Update.";
		}
		echo json_encode($response);
	}

	public function delete_schedule_medicine_data()
	{

		if (!is_null($this->input->post("id")) && !is_null($this->input->post("deleteReason"))) {

			$id = $this->input->post("id");
			$reason = $this->input->post("deleteReason");
			$date = date("Y-m-d");
			$table = $this->session->user_session->patient_mediine_table;
			$table_reschedule = "com_1_reschedule_medicine";
			try {
				$this->db->trans_start();
				$this->db
					->set(array('active' => 0, 'end_date' => $date, 'reason' => $reason))
					->where( array("id" => $id))
					->update($table);
				$resultObject=$this->db->where(array("id"=>$id))->get($table)->row();
				$response["query"] = $this->db->last_query();
				if(!is_null($resultObject)){
					$this->db->set("status",'0')->where(
						array("medicine_id"=>$resultObject->name,"patient_id"=>$resultObject->p_id,"medicine_date >="=>$date)
					)->update($table_reschedule);
				}

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "Patient Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "Patient Transaction Commited");
					$result = TRUE;
				}
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				log_message('info', "Patient Transaction Rollback");
				$result = FALSE;
			} finally {
				$this->db->trans_complete();
			}
			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Delete Medicine";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed Delete Medicine";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed Delete Medicine";
		}
		echo json_encode($response);
	}


	public function delete_medicine_data()
	{

		$medicine_id = $this->input->post('medicine_id');
		$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
		$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
		$query = $this->db->query("select id from " . $patient_mediine_table . " where name='$medicine_id'");
		if ($this->db->affected_rows() > 0) {
			$response['status'] = 201;
			$response['body'] = "This medicine is attached with Patient You can't delete it.";
		} else {
			$where = array(
				"id" => $medicine_id
			);
			$this->db->where($where);
			$qrr = $this->db->delete('medicine_master');
			if ($qrr == true) {
				$response['status'] = 200;
				$response['body'] = "Medicine Deleted Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Fail to Delete medicine.";
			}
		}
		echo json_encode($response);
	}

	public function delete_history_fun()
	{
		$patient_id = $this->input->post('patient_id');
		$does_details_id = $this->input->post('does_details_id');
		$iteration = $this->input->post('iteration');
		$company_id = $this->session->user_session->company_id;
		$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
		$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
		$where = array(
			"p_id" => $patient_id,
			"does_details_id" => $does_details_id,
			"iteration_count" => $iteration
		);
		$this->db->where($where);
		$qrr = $this->db->set("status", 0)->update($patient_medicine_history_table);
		if ($qrr == true) {
			$response['status'] = 200;
			$response['body'] = "History Deleted Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Fail to Delete History.";
		}

		echo json_encode($response);
	}

	function getMedicineGroup()
	{

		$resultObject = $this->db->where("status", 1)->get("medicine_group")->result();
		// $options = "<option selected disabled>Select Medicine Group</option>";
		$options = "";

		if (count($resultObject) > 0) {
			foreach ($resultObject as $group) {
				if($group->id==1)
				{
					$options .= "<option selected value='" . $group->id . "'>" . $group->name . "</option>";
				}
				else
				{
					$options .= "<option value='" . $group->id . "'>" . $group->name . "</option>";
				}
				
			}
			$response["status"] = 200;
		} else {
			$response["status"] = 201;
		}

		$response["body"] = $options;
		echo json_encode($response);
	}

	public function availabWPatient()
	{
		$p_id = $this->input->post('p_id');
		$m_id = $this->input->post('m_id');
		$sts = $this->input->post('sts');
		$where = array('medicine_id' => $m_id, 'patient_id' => $p_id);
		$set = array("confirm_status" => $sts);
		$this->db->where($where);
		$update = $this->db->update('com_1_medicine_order', $set);
		if ($update == true) {
			$response['status'] = 200;
			$response['body'] = "Updated Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Somethimg Went Wrong";
		}

		echo json_encode($response);
	}


	public function load_patient_history()
	{

		$validResult = $this->is_parameter(array("patient_id"));
		if ($validResult->status) {
			$patient_id = $validResult->param->patient_id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$patient_medicine_table = $this->session->user_session->patient_mediine_table;//dose details table
			
			$dose_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
			$patient_reschedule_medicine_table = "com_1_reschedule_medicine";
			$medicine_comment_table="com_1_medicine_comment";
			$select = array(
				'd.id',
				'd.p_id',
				'd.name',
				'(select medicine_master.name from medicine_master where id=d.name) as m_name',
				'd.start_date',
				'd.end_date',
				'd.total_iteration',
				'(select group_concat(cm.comment,"||",cm.medicine_iteration,"||",date(cm.medicine_date) SEPARATOR "@") from '.$medicine_comment_table.' cm where cm.patient_id=d.p_id and cm.status=1 and cm.medicine_id=d.id) as medicine_comment',
				'(select group_concat(h.iteration_count, "|",iteration_on,"|",iteration_time order by h.iteration_count ) from ' . $dose_history_table . ' h where h.p_id=p_id and h.status=1 and h.does_details_id=d.id) as ite_details',
				'(SELECT group_concat(rm.medicine_id,"|",rm.medicine_date,"|",rm.reschedule_iteration) FROM ' . $patient_reschedule_medicine_table . ' rm where rm.patient_id = d.p_id and rm.medicine_id = d.name and rm.status=1) as reschedule_medicine',
				'd.active'
			);
			$where = array(
				'p_id' => $patient_id,
				'branch_id' => $branch_id
			);

			$medicinesResult = $this->db->select($select)->where($where)->get($patient_medicine_table . " d")->result();

			$sortArray = array();
			$dateRanges = array();
			if (is_array($medicinesResult)) {
				foreach ($medicinesResult as $item) {
					$doesObject = new stdClass();
					if ($item->ite_details != "" && $item->ite_details != null) {
						$doesObject->startDate = $item->start_date;
						$doesObject->end_date = $item->end_date;
						$doesObject->id = $item->id;
						$doesObject->total_iteration = $item->total_iteration;
						$doesObject->name = $item->name;
						$doesObject->medicineName = $item->m_name;
						$doesObject->pid = $item->p_id;
						$doesObject->active = $item->active;
						$dates = $this->getDatesFromRange($item->start_date, $item->end_date);
						$doesObject->dateRange = $dates;
						foreach ($dates as $d) {
							array_push($dateRanges, $d);
						}
						$iteration_onArray = explode(',', $item->ite_details);
						$iterationDoes = array();
						foreach ($iteration_onArray as $iteration_on) {
							$item_detials = explode('|', $iteration_on);
							if (count($item_detials) >= 3) {
								$obj = new stdClass();
								$obj->item = $item->id;
								$obj->iterationNo = $item_detials[0];
								$obj->iterationDate = $item_detials[1];
								$obj->iterationDatetime = $item_detials[2];
								array_push($iterationDoes, $obj);
							}
						}
						$doesObject->rescheduleDoes = $this->getRescheduleDoes($item);
						if ($doesObject->rescheduleDoes != null) {

							foreach ($doesObject->rescheduleDoes as $d) {
								array_push($dateRanges, $d->reschedule_date);
							}
						}
						$iterationComment = array();
						if($item->medicine_comment!=null && $item->medicine_comment!="")
							{

								$ex_data=explode('@', $item->medicine_comment);
								if(count($ex_data)>0)
								{

									foreach ($ex_data as $key => $value) {
										$ex_comm=explode('||', $value);
										
										if(count($ex_comm)>2)
										{
											$obj1 = new stdClass();
											$obj1->item = $item->id;
											$obj1->comment = $ex_comm[0];
											$obj1->iteration = $ex_comm[1];
											$obj1->date = $ex_comm[2];
											array_push($iterationComment, $obj1);
										}
									}
								}
							}
						$doesObject->medicine_comment = $iterationComment;


						$doesObject->itrationData = $iterationDoes;
						array_push($sortArray, $doesObject);
					} else {
						$doesObject->medicineName = $item->m_name;
						$doesObject->startDate = $item->start_date;
						$doesObject->end_date = $item->end_date;
						$doesObject->id = $item->id;
						$doesObject->active = $item->active;
						$doesObject->total_iteration = $item->total_iteration;
						$doesObject->name = $item->name;
						$doesObject->pid = $item->p_id;
						$iterationDoes = array();
						$doesObject->itrationData = $iterationDoes;
						$dates = $this->getDatesFromRange($item->start_date, $item->end_date);
						$doesObject->dateRange = $dates;
						foreach ($dates as $d) {
							array_push($dateRanges, $d);
						}
						$doesObject->rescheduleDoes = $this->getRescheduleDoes($item);
						if ($doesObject->rescheduleDoes != null) {
							foreach ($doesObject->rescheduleDoes as $d) {
								array_push($dateRanges, $d->reschedule_date);
							}
						}
						array_push($sortArray, $doesObject);

						$iterationComment = array();
						if($item->medicine_comment!=null && $item->medicine_comment!="")
							{
								$ex_data=explode('@', $item->medicine_comment);
								if(count($ex_data)>0)
								{
									foreach ($ex_data as $key => $value) {
										$ex_comm=explode('||', $value);
										if(count($ex_comm)>2)
										{
											$obj1 = new stdClass();
											$obj1->item = $item->id;
											$obj1->comment = $ex_comm[0];
											$obj1->iteration = $ex_comm[1];
											$obj1->date = $ex_comm[2];
											array_push($iterationComment, $obj1);
										}
									}
								}
							}
						$doesObject->medicine_comment = $iterationComment;
					}

				}
			}
			$dataTable = "";

			if (count($sortArray) > 0) {
				$dateRanges = array_unique($dateRanges);
				$minDate = min($dateRanges);
				$maxDate = date('Y-m-d', strtotime(max($dateRanges) . ' + 5 days'));
				$response["min"] = $minDate;
				$response["max"] = $maxDate;
				$newDateRange = $this->getDatesFromRange($minDate, $maxDate);
				$dataTable = "
					<table class='table table-hover table-striped table-bordered dataTable table-responsive' style='width: 100%'>
						<thead style='background: #8916353b;'> 
							<tr>
								<th>Medicine Name</th>";
				foreach ($newDateRange as $date) {
					$classname="";
					if($date==date('Y-m-d'))
					{
						$classname="id='scrollMe'";
					}
					$dataTable .= "<th ".$classname.">" . date('d-M', strtotime($date)) . "</th>";
				}
				$response["range"] = $newDateRange;
				$dataTable .= "</tr></thead><tbody>";
				$dataTable1="";
				$dataTable2="";
				$dataTable3="";
				$currentDate = date('Y-m-d');
				foreach ($sortArray as $medicine) {
					$dataTable_pos1="";
					$dataTable_pos2="";
					// echo "<pre>";
					// print_r($medicine);
					$row_pos=0;
					$delete_pos=0;
					if(is_array($medicine->rescheduleDoes)){
						$result = array_values(array_column($medicine->rescheduleDoes, 'reschedule_date'));
						// print_r($result);
						if(in_array(date('Y-m-d'), $result) && (int)$medicine->active == 1)
						{
							$row_pos++;
						}
						else if(in_array(date('Y-m-d'), $result) && (int)$medicine->active == 0)
							{
								$delete_pos++;
							}
						// foreach ($medicine->rescheduleDoes as $checkReschedule_date) {
						// 	if($checkReschedule_date->reschedule_date==date('Y-m-d') && (int)$medicine->active == 1)
						// 	{
						// 		$row_pos++;
						// 	}
						// 	else if($checkReschedule_date->reschedule_date==date('Y-m-d') && (int)$medicine->active == 0)
						// 	{
						// 		$delete_pos++;
						// 	}
							
						// }
					}
					if(is_array($medicine->dateRange)){
						if(in_array(date('Y-m-d'), $medicine->dateRange) && (int)$medicine->active == 1)
						{
							$row_pos++;
						}
						else if(in_array(date('Y-m-d'), $medicine->dateRange) && (int)$medicine->active == 0)
						{
							$delete_pos++;
						}
					}
					
					if ((int)$medicine->active == 1) {
						$template = $medicine->medicineName;
					} else {
						$template = "<span class='text-danger'>" . $medicine->medicineName . "</span><span class='text-danger'>Deleted</span> <button class='btn btn-link btn-sm' onclick='deleteActivate(" . $medicine->id . ")'>To Activate click</button>";
					}
					if ($medicine->end_date == "0000-00-00 00:00:00") {
						$endOriginalDate = "-";
						$endDate = date("Y-m-d", strtotime("tomorrow"));
					} else {
						if (date($medicine->end_date) > date("Y-m-d")) {
							$endOriginalDate = date("Y-m-d", strtotime($medicine->end_date));
							$endDate = date("Y-m-d", strtotime("+1day" . $medicine->end_date));
						} else {
							$endDate = date("Y-m-d");
							$endOriginalDate = date("Y-m-d");
						}
					}


					$dataTable_pos1 .= "
							<tr>
								<td class='sticky-col first-col'><div class='medicine'>
								<button class='btn btn-sm btn-primary' data-target='#extendModel'
								 data-toggle='modal' 
								 data-name='" . $medicine->medicineName . "'
								 data-original_date='" . $endOriginalDate . "'
								 data-date='" . $endDate . "'
								 data-id='" . $medicine->name . "'><i class='fa fa-plus'></i></button>
								" . $template . "</div> </td>";
					foreach ($newDateRange as $date) {

							$commentM="";
							$commentT="";
							$medicine_comment="";
							if(!empty($medicine->medicine_comment))
							{
								
								$cmdata=$this->getMedicineCommentView($medicine->medicine_comment,$date);
								
								if(!empty($cmdata))
								{

									foreach ($cmdata as $key => $value) {
										if($value->status==1)
										{
											$commentM.='<div class="d-flex"><div><i class="fa fa-arrow-right mr-1"></i> </div> <div> '.$value->data.'</div></div>';
											$commentT.="".$value->date."";
										}
									}
									$medicine_comment.="class='popoverData' class='btn' data-html='true' data-content='".$commentM."' rel='popover' data-original-title='medicine comments' data-trigger='hover'";
								}
							}
						$isExist = $this->isExistDate($medicine->dateRange, $date);
						if ($isExist) {
							$alreadyGivenDoesCount = $this->alreadyGivenDoesCount($medicine->itrationData, $date);
							$total_iteration = (int)$medicine->total_iteration;
							if ($medicine->rescheduleDoes != null) {
								$new_total_iteration = $this->rescheduleDoes($medicine->rescheduleDoes, $date);
								if ($new_total_iteration != -1) {
									$total_iteration = $new_total_iteration;
								}
							}

							$alreadyDone = false;
							if ($alreadyGivenDoesCount == $total_iteration) {
								$alreadyDone = true;
							}

							if ($alreadyDone) {
								if ($currentDate <= date('Y-m-d', strtotime($date))) {
									if ($alreadyGivenDoesCount == 0 && $total_iteration == 0) {
										if ((int)$medicine->active == 1) {
											$dataTable_pos1 .= "<td><button class='btn btn-link btn-reddit btn-sm mx-2' 
									data-medicine_id='" . $medicine->name . "'
									data-reschedule_date='" . $date . "'
									data-alreadyGivenDoesCount='" . $alreadyGivenDoesCount . "'
									data-toggle='modal'
									data-target='#rescheduleMedicine'
									><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></button></td>";
										} else {
											$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></td>";
										}
									} else {
										// $dataTable .= "<td>@" . $alreadyGivenDoesCount . "/" . $total_iteration . "</td>";
										if ((int)$medicine->active == 1) {
											$dataTable_pos1 .= "<td><button class='btn btn-link btn-reddit btn-sm mx-2' 
									data-medicine_id='" . $medicine->name . "'
									data-reschedule_date='" . $date . "'
									data-alreadyGivenDoesCount='" . $alreadyGivenDoesCount . "'
									data-toggle='modal'
									data-target='#rescheduleMedicine'
									><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></button></td>";
										} else {
											$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></td>";
										}
									}
								} else {
									$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></td>";
								}


							} else {
								if ($currentDate <= date('Y-m-d', strtotime($date))) {
									if ((int)$medicine->active == 1) {

										$dataTable_pos1 .= "<td><button class='btn btn-link btn-reddit btn-sm mx-2' 
									data-medicine_id='" . $medicine->name . "'
									data-reschedule_date='" . $date . "'
									data-alreadyGivenDoesCount='" . $alreadyGivenDoesCount . "'
									data-toggle='modal'
									data-target='#rescheduleMedicine'
									><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></button></td>";

									} else {
										// print_r($medicine->medicine_comment);
									
										
										$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></td>";
									}

								} else {
									// print_r($medicine->medicine_comment);
								
									$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $total_iteration . "</span></td>";
								}
							}
						} else {
							$rescheduleDoes = null;

							if (!is_null($medicine->rescheduleDoes)) {
								foreach ($medicine->rescheduleDoes as $re_does) {
									if ($re_does->reschedule_date == $date) {
										$rescheduleDoes = $re_does;
										break;
									}
								}
							}

							if (!is_null($rescheduleDoes)) {
								$alreadyGivenDoesCount = $this->alreadyGivenDoesCount($medicine->itrationData, $date);


								if ($date < date('Y-m-d')) {

									$dataTable_pos1 .= "<td>" . $alreadyGivenDoesCount . "/" . $rescheduleDoes->reschedule_iteration . "</td>";
								} else {
									if ((int)$medicine->active == 1) {
										$dataTable_pos1 .= "<td><button class='btn btn-link btn-reddit btn-sm mx-2' 
										data-medicine_id='" . $medicine->name . "'
										data-reschedule_date='" . $date . "'
										data-alreadyGivenDoesCount='" . $alreadyGivenDoesCount . "'
										data-toggle='modal'
										data-target='#rescheduleMedicine'
										><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $rescheduleDoes->reschedule_iteration . "</span></button></td>";
									} else {
										$dataTable_pos1 .= "<td><span ".$medicine_comment.">" . $alreadyGivenDoesCount . "/" . $rescheduleDoes->reschedule_iteration . "</span></td>";
									}
								}
							} else {

								if ($date >= $currentDate) {
									if ((int)$medicine->active == 1) {
										$dataTable_pos1 .= "<td><button class='btn btn-link btn-reddit btn-sm mx-2' 
									data-medicine_id='" . $medicine->name . "'
									data-reschedule_date='" . $date . "'
									data-alreadyGivenDoesCount='0'
									data-toggle='modal'
									data-target='#rescheduleMedicine'
									>-</button></td>";
									} else {
										$dataTable_pos1 .= "<td>-</td>";
									}

								} else {
									$dataTable_pos1 .= "<td>-</td>";
								}

							}


						}
					}
					$dataTable_pos1 .= "</tr>";
					
					if($row_pos > 0)
					{
						
						$dataTable1.=$dataTable_pos1;
					} else if($delete_pos>0){
						$dataTable2.=$dataTable_pos1;
					}
					else
					{
					
						$dataTable3.=$dataTable_pos1;
					}
					
				}
				$dataTable.=$dataTable1.$dataTable2.$dataTable3;
				$dataTable .= "</tbody></table>";
			}
			$response["status"] = 200;
			$response["body"] = $dataTable;
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	public function saveRescheduleMedicine()
	{
		$validObject = $this->is_parameter(array("reschedule_medicine_id", "reschedule_date", "schedule_day", "patient_id"));

		if ($validObject->status) {

			$medicine_id = $validObject->param->reschedule_medicine_id;
			$reschedule_date = $validObject->param->reschedule_date;
			$schedule_day = $validObject->param->schedule_day;
			$patient_id = $validObject->param->patient_id;
			$branch_id = $this->session->user_session->branch_id;
			$user_id = $this->session->user_session->id;
			$patient_medicine_history_table = $this->session->user_session->patient_medicine_history_table;//dose details table
			$medicineData = array("medicine_id" => $medicine_id, "medicine_date" => $reschedule_date, "reschedule_iteration" => $schedule_day,
				"branch_id" => $branch_id, "patient_id" => $patient_id, "create_on" => date("Y-m-d H:i:a"), "create_by" => $user_id,"status"=>1);
			try {
				$this->db->trans_start();
				$this->db->where(array("medicine_id" => $medicine_id, "medicine_date" => $reschedule_date, "patient_id" => $patient_id, "branch_id" => $branch_id))->get("com_1_reschedule_medicine");
				if ($this->db->affected_rows() == 0) {
					$this->db->insert("com_1_reschedule_medicine", $medicineData);
				} else {
					$this->db->set($medicineData)
						->where(array("medicine_id" => $medicine_id, "patient_id" => $patient_id, "branch_id" => $branch_id, "medicine_date" => $reschedule_date))
						->update("com_1_reschedule_medicine");
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "Patient Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "Patient Transaction Commited");
					$result = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				$result = FALSE;
				$this->db->trans_complete();
			}
			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Save Changes";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Save Changes";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Failed To Save Changes";
		}
		echo json_encode($response);

	}

	public function getMedicineCommentView($c_data,$date)
	{
		$result="";
		
		$dataArray=array();
		foreach ($c_data as $key => $value) {
			if(date("Y-m-d", strtotime($value->date))==date("Y-m-d", strtotime($date)))
			{
				$data=$value->comment;
				$obj1 = new stdClass();
				$obj1->data=$data;
				$obj1->date=date("Y d M", strtotime($value->date));
				$obj1->status=1;
				array_push($dataArray, $obj1);
			}
		}
		return $dataArray;
	}
	public function isExistDate($dateRage, $date)
	{
		$result = false;
		foreach ($dateRage as $d) {
			if ($d == $date) {
				$result = true;
				break;
			}
		}
		return $result;
	}

	public function alreadyGivenDoesCount($medicineIterationData, $date)
	{
		$count = 0;
		foreach ($medicineIterationData as $medicine) {
			if ($medicine->iterationDate == $date) {
				$count++;
				continue;
			}
		}
		return $count;
	}

	public function rescheduleDoes($medicineIterationData, $date)
	{
		$count = -1;
		foreach ($medicineIterationData as $medicine) {
			if ($medicine->reschedule_date == $date) {
				$count = (int)$medicine->reschedule_iteration;
				break;
			}
		}
		return $count;
	}

	public function getRescheduleDoes($item)
	{
		if ($item->reschedule_medicine != "" && $item->reschedule_medicine != null) {
			$reschedule_iterationArray = explode(',', $item->reschedule_medicine);
			if (is_array($reschedule_iterationArray)) {
				$rescheduleObject = array();
				foreach ($reschedule_iterationArray as $reschedule_medicine) {
					$medicine = explode('|', $reschedule_medicine);
					if (count($medicine) > 2) {
						$obj = new stdClass();
						$obj->medicine_id = $medicine[0];
						$obj->reschedule_date = $medicine[1];
						$obj->reschedule_iteration = $medicine[2];
						array_push($rescheduleObject, $obj);
					}
				}
				return $rescheduleObject;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function saveExtendScheduleMedicine()
	{
		$header = $this->is_parameter(array(
			"extend_schedule_medicine_id", "extend_patient_id",
			"extend_schedule_day", "extend_date", "extend_start_date"));

		if ($header->status) {
			try {

				$this->db->trans_start();
				$tomorrowDate = $header->param->extend_start_date; //date('Y-m-d', strtotime("tomorrow"));

				// find all reschedule medicine from tomorrow day

				$rescheduleMedicine = $this->medicine_model->_select("com_1_reschedule_medicine",
					array(
						"medicine_id" => $header->param->extend_schedule_medicine_id,
						"medicine_date >=" => $tomorrowDate,
						"patient_id" => $header->param->extend_patient_id,
						"branch_id" => $this->session->user_session->branch_id
					),
					"id", false);

				if ($rescheduleMedicine->totalCount > 0) {
					// already have some schedule medicine
					$response["data"] = $rescheduleMedicine->data;
					foreach ($rescheduleMedicine->data as $medicine) {
						$this->db->where(array("id" => $medicine->id))->delete("com_1_reschedule_medicine");
					}

				}
				$rescheduleDate = $this->getDatesFromRange($tomorrowDate, $header->param->extend_date);
				$scheduleArray = array();
				foreach ($rescheduleDate as $date) {
					$reschedule = array(
						"medicine_id" => $header->param->extend_schedule_medicine_id,
						"medicine_date" => $date,
						"reschedule_iteration" => $header->param->extend_schedule_day,
						"patient_id" => $header->param->extend_patient_id,
						"branch_id" => $this->session->user_session->branch_id,
						"create_by" => $this->session->user_session->id,
						"create_on" => date("Y-m-d H:i:s"),
						"status" => 1
					);
					array_push($scheduleArray, $reschedule);
				}
				$totalDay = count($rescheduleDate);
				$medicineObject = new stdClass();

				$requiredQty = (int)$header->param->extend_schedule_day * $totalDay;
				$medicineObject->required_bu = $requiredQty;
				$medicineObject->patient_id = $header->param->extend_patient_id;
				$medicineObject->branch_id = $this->session->user_session->branch_id;
				$medicineObject->create_on = date('Y-m-d h:i:s');
				$medicineResultObject = $this->medicine_model->_select("medicine_master", array('id' => $header->param->extend_schedule_medicine_id), array("id", "name", "bu", "pkt"));
				if ($medicineResultObject->totalCount > 0) {
					$medicineObject->medicine_name = $medicineResultObject->data->name;
					$medicineObject->medicine_id = $medicineResultObject->data->id;
					$medicineObject->default_bu = $medicineResultObject->data->bu;
					$medicineObject->default_pkt = $medicineResultObject->data->pkt;
				}

				$this->db->insert_batch("com_1_reschedule_medicine", $scheduleArray);
				$medicineAlreadyOrder = $this->db
					->where(array(
						"patient_id" => $header->param->extend_patient_id,
						"supplied_by_pharmeasy" => 0,
						"medicine_id" => $medicineObject->medicine_id,
						"branch_id" => $medicineObject->branch_id
					))
					->get("com_1_medicine_order")->row();
				if (!is_null($medicineAlreadyOrder)) {
					$medicineObject->required_bu = $medicineObject->required_bu + $medicineAlreadyOrder->required_bu;
					$this->db->where(array("id" => $medicineAlreadyOrder->id))->update("com_1_medicine_order", (array)$medicineObject);
				} else {
					$this->db->insert("com_1_medicine_order", (array)$medicineObject);
				}

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					log_message('info', "Patient Transaction Rollback");
					$result = FALSE;
				} else {
					$this->db->trans_commit();
					log_message('info', "Patient Transaction Commited");
					$result = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				log_message('info', "Patient Transaction Rollback");
				$result = FALSE;
				$this->db->trans_complete();
			}

			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Successfully extend medicine";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To Extend Medicine";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function addmedicineCommentForm()
	{
		// print_r($this->input->post('m_patient_id'));exit();
		$header = $this->is_parameter(array(
			"m_patient_id", "c_medicine_id",
			"m_iteration_id", "m_dose_date", "medicine_comment"));

		if ($header->status) {
			$patient_id=$header->param->m_patient_id;
			$medicine_id=$header->param->c_medicine_id;
			$iteration_id=$header->param->m_iteration_id;
			$dose_date=$header->param->m_dose_date;
			$medicine_comment=$header->param->medicine_comment;

			$insert_data = array(
						"company_id" => $this->session->user_session->company_id,
						"branch_id" => $this->session->user_session->branch_id,
						"patient_id" => $patient_id,
						"medicine_date" => $dose_date,
						"comment" => $medicine_comment,
						"medicine_id" =>$medicine_id,
						"medicine_iteration" => $iteration_id ,
						"created_by" => $this->session->user_session->id,
						"created_on"=>date("Y-m-d H:i:s"),
						"status"=>1
					);
			$insert=$this->db->insert("com_1_medicine_comment",$insert_data);
			if($insert==true)
			{
				$response["status"] = 200;
				$response["body"] = "Comment Added";
			}
			else
			{
				$response["status"] = 201;
				$response["body"] = "Comment Not Added";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Something went wrong";
		}
		echo json_encode($response);
	}
}
