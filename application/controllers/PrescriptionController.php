<?php

require_once 'HexaController.php';

/**
 * @property  PrescriptionModel PrescriptionModel
 */
class PrescriptionController extends HexaController
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("PrescriptionModel");
		$this->load->model("Global_model");
	}


	function savePrescription()
	{

		$ValidationObject = $this->is_parameter(array("prescriptionName"));
		if ($ValidationObject->status) {
			$param = $ValidationObject->param;
			// print_r($param->prescriptionName);exit();
			$tableName = $this->session->user_session->prescription_master_table;
			$prescriptionName = $param->prescriptionName;
			$where = "where name='" . $prescriptionName . "'";
			$resultObject = $this->PrescriptionModel->getPrescription($tableName, $where);
			if ($resultObject->totalCount <= 0) {
				$user_id = $this->session->user_session->id;
				$branch_id = $this->session->user_session->branch_id;
				$prescriptionArray = array();
				$prescriptionArray[] = $this->input->post_get('itemArray');
				$dataArray1 = array();
				foreach ($prescriptionArray as $prescriptionArraydata) {
					$dataArray = array();
					foreach ($prescriptionArraydata as $key => $value) {
						$dataArray = array('name' => $prescriptionName,
							'medicine_id' => $value['medicine_id'],
							'per_date_schedule' => $value['per_date_schedule'],
							'nos_of_days' => $value['nos_of_days'],
							'doctor_id' => $value['doctorName'],
							'remark' => $value['remark'],
							'route' => $value['route'],
							'quantity' => $value['quantity'],
							'objective' => $value['objective'],
							'create_by' => $user_id,
							'branch_id' => $branch_id,
							'create_on' => date('Y-m-d'));
						$dataArray1[] = $dataArray;

					}
				}
				if ($this->PrescriptionModel->savePrescription($tableName, $dataArray1)) {
					$response["status"] = 200;
					$response["body"] = "Prescription added successfully";
				} else {
					$response["status"] = 201;
					$response["body"] = "Not Added";
				}
				// print_r($result);exit();
			} else {
				$response["status"] = 201;
				$response["body"] = "Same name prescription already added";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	public function getPrescriptionTableData()
	{
		$tableName = $this->session->user_session->prescription_master_table;
		$branch_id = $this->session->user_session->branch_id;
//		$resultObject = $this->PrescriptionModel->prescription_history($tableName);
		$select = array(" id", "name", "objective", "(select name from users_master where id=doctor_id) as doctor_name",
			"(select GROUP_CONCAT(LEFT(name,10)) from medicine_master m  where  m.id in (select t.medicine_id from " . $tableName . " t where t.name = t1.name )) as medicine_name");
		$order = array('create_on' => 'asc');
		$column_order = array('name',);
		$column_search = array("name", "bu");
		$where = array("status" => 1,"branch_id"=>$branch_id);

		$memData = $this->PrescriptionModel->getRows($_POST, $where, $select, $tableName . " t1", $column_search, $column_order, $order, "name");

		$filterCount = $this->PrescriptionModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->PrescriptionModel->countAll($tableName, $where);
		// print_r($resultObject);exit();
		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$tableRows[] = array(
					$row->name,
					$row->doctor_name,
					$row->id,
					$row->medicine_name,
					$row->objective,
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

	/* public function deletePrescription()
	{

		if (!is_null($this->input->post('name'))) {
			$name = $this->input->post('name');
			$tableName = $this->session->user_session->prescription_master_table;
			$where = array('name' => $name);
			$resultObject = $this->PrescriptionModel->delete_prescription($tableName, $where);
			if ($resultObject == true) {
				$response["status"] = 200;
				$response["body"] = "Prescription Deleted Successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Prescription not deleted";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	} */

	public function schedulePrescription()
	{

		$validObject = $this->is_parameter(array("pName", "patient_id", "start_date"));
		if ($validObject->status) {
			$param = $validObject->param;
			$med_id = $this->input->post('med_id');
			if (($med_id) == "") {
				$response["status"] = 201;
				$response["body"] = "Select Medicine";
				echo json_encode($response);
				exit;
			}
			$patient_id = $param->patient_id;
			$startDate = $param->start_date;
			$create_by = $this->session->user_session->id;

			// set table name
			$branch_id = $this->session->user_session->branch_id;
			$medicineTable = $this->session->user_session->patient_mediine_table;
			$prescriptionTable = $this->session->user_session->prescription_master_table;
			$schedulePrescriptionObjects =array();
			foreach ($med_id as $medicine){

				$scheduleMedicine = new stdClass();
				$scheduleMedicine->medicine_id=$medicine;
				$scheduleMedicine->per_date_schedule = $this->input->post("med_schedule_per_day_".$medicine);
				$scheduleMedicine->nos_of_days = $this->input->post("med_no_days_".$medicine);
				$scheduleMedicine->remark = $this->input->post("med_desc_".$medicine);
				$scheduleMedicine->route = $this->input->post("med_route_".$medicine);
				$scheduleMedicine->quantity = $this->input->post("med_quantity_".$medicine);

				array_push($schedulePrescriptionObjects,$scheduleMedicine);

			}
			$medicionOrderTable = "com_1_medicine_order";
//			$prescriptionResultObject = $this->PrescriptionModel->_select($prescriptionTable, array("name" => $param->pName, "status" => 1), "*", false);

			if (count($schedulePrescriptionObjects) > 0) {
				$medicineArray = array();
				$medicineOrderArray = array();
//				$order_id = $this->Global_model->generate_order("select order_id from com_1_medicine_order where order_id = '#id'");


				foreach ($schedulePrescriptionObjects as $medicine) {
//					$key = array_search($medicine->medicine_id, $med_id);
					$exist = true;
//					if ($key != false || $key == 0) {
//						if ((int)$medicine->medicine_id === (int)$med_id[$key]) {
//							$exist = true;
//						}
//					}

//					if ($exist) {
						$dateRang = $this->getDatesFromRange($startDate, (int)$medicine->nos_of_days);

						$endDate = end($dateRang);
						$totalDay = count($dateRang);
						$medicineObject = new stdClass();

						$requiredQty = (int)$medicine->per_date_schedule * $totalDay;
						$medicineObject->branch_id = $this->session->user_session->branch_id;
						$medicineObject->required_bu = $requiredQty;
						$medicineObject->patient_id = $patient_id;
						$medicineObject->create_on = date('Y-m-d h:i:s');
						$medicineResultObject = $this->PrescriptionModel->_select("medicine_master", array('id' => $medicine->medicine_id), array("id", "name", "bu", "pkt"));
						if ($medicineResultObject->totalCount > 0) {
							$medicineObject->medicine_name = $medicineResultObject->data->name;
							$medicineObject->medicine_id = $medicineResultObject->data->id;
							$medicineObject->default_bu = $medicineResultObject->data->bu;
							$medicineObject->default_pkt = $medicineResultObject->data->pkt;
						}

						$medicineScheduleObject = array("name" => $medicine->medicine_id, "start_date" => $startDate, "end_date" => $endDate, "total_iteration" => $medicine->per_date_schedule,
							"remark" => $medicine->remark,"quantity" => $medicine->quantity,"route" => $medicine->route, "create_on" => date('Y-m-d H:m:i'), "create_by" => $create_by, "p_id" => $patient_id,"branch_id"=>$branch_id);

						$query = $this->db->query("select * from " . $medicineTable . " where name='$medicine->medicine_id' AND p_id='$patient_id' AND status='1' AND branch_id='".$branch_id."' order by create_on DESC");
						$cnt=0;
							if ($this->db->affected_rows() > 0) {
								$result=$query->result();

								foreach ($result as $key => $value) {
									$currentStart=date('Y-m-d',strtotime($startDate));
									$currentEnd=date('Y-m-d',strtotime($endDate));
									$existingEnd=date('Y-m-d',strtotime($value->end_date));
									
									$existingStart=date('Y-m-d',strtotime($value->start_date));
									

									if(($currentStart >= $existingStart) && ($currentStart <=
										$existingEnd))
									{
										// echo 1;
											$cnt++;
											break;
										
									}
									else
									{
										if(($currentStart<$existingStart && $currentEnd<$existingStart) && ($currentStart>$existingEnd && $currentEnd>$existingEnd))
										{
											// echo 2;
											$cnt++;
											break;
										}

										
									}
								}
							}

							if($cnt == 0){
								array_push($medicineOrderArray, (array)$medicineObject);
								array_push($medicineArray, $medicineScheduleObject);
							}
								
						

//					}
				}

				// print_r($cnt);exit();	

				$result = false;

				if(!empty($medicineArray)){
					try {
						$this->db->trans_start();
						
							foreach ($medicineArray as $medicine) {
								$this->db->insert($medicineTable, $medicine);
							}
							$this->db->insert_batch($medicionOrderTable, $medicineOrderArray);

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
					}
					if ($result) {
						$response["status"] = 200;
						$response["body"] = "Schedule Successfully";
					} else {
						$response["status"] = 201;
						$response["body"] = "Failed to Schedule";
					}
				}
				else{
						$response["status"] = 201;
						$response["body"] = "Medicines Already Schedule";
				}

				

			} else {
				$response["status"] = 201;
				$response["body"] = "Prescription Data Not Available";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	function getDatesFromRange($start, $iteration, $format = 'Y-m-d')
	{


		// Declare an empty array
		$array = array($start);
		if ($iteration > 1) {
			$iteration = $iteration - 1;
			for ($i = 1; $i <= $iteration; $i++) {
				array_push($array, date('Y-m-d', strtotime('+' . $i . ' day', strtotime($start))));
			}
		}


		// Return the array elements
		return $array;
	}


	function getPrescriptionMedicine()
	{
		$medicineArray = array();
		if (!is_null($this->input->post("name")) && !is_null($this->input->post("patient_id"))) {
			$name = $this->input->post("name");
			$patient_id = $this->input->post("patient_id");
			$branch_id = $this->session->user_session->branch_id;
			$prescriptionTable = $this->session->user_session->prescription_master_table;
			$patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
			$resultObject = $this->PrescriptionModel->_select($prescriptionTable, array("status" => 1, "name" => $name),
				array("*", "(select name from medicine_master m  where  m.id =medicine_id) as medicine_name"), false);
			$getMedicineScheduleData = $this->PrescriptionModel->_select($patient_mediine_table, array("status" => 1,"p_id" => $patient_id,"branch_id"=>$branch_id),
				array("*"),false);

			

			if ($resultObject->totalCount > 0) {

				foreach ($resultObject->data as $medicine) {
					$count_m=0;
					if ($getMedicineScheduleData->totalCount > 0) {
						// print_r($getMedicineScheduleData->data);
						foreach ($getMedicineScheduleData->data as $s_medicine) {
							if($s_medicine->name == $medicine->medicine_id)
							{
								$count_m++;
								break;
							}
						}
					}
					$medicineDetails = array(
						$medicine->medicine_name,
						$medicine->per_date_schedule,
						$medicine->nos_of_days,
						$medicine->remark,
						$medicine->medicine_id,
						$count_m,
						$medicine->route,
						$medicine->quantity);
					array_push($medicineArray, $medicineDetails);
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

	function get_prescribe_data()
	{
		$id = $this->input->post('id');
		$prescriptionTable = $this->session->user_session->prescription_master_table;
		$query = "select * from " . $prescriptionTable . " where name='$id'";
		$qr = $this->db->query($query);
		$data = "";
		$data1 = "";
		if ($this->db->affected_rows() > 0) {
			$result = $qr->result();
			$data1 .= '<table class="table">
				<thead>
				<tr>
				<td>Medicine Name</td>
				<td>No. of days</td>
				<td>Per day Schedule</td>
				
				<td>Action</td>
				</tr>
				<tbody>
				';
			foreach ($result as $row) {
				$medicine_id = $row->medicine_id;
				$get_med_name = $this->PrescriptionModel->get_med_name($medicine_id);

				$med_name = "";
				if ($get_med_name != false) {
					$med_name = $get_med_name->name;


				}
				$nos_of_days = $row->nos_of_days;
				$doctor_id = $row->doctor_id;

				$remark = $row->remark;
				$eprescription_per_day_schedule = $row->per_date_schedule;
				$objective = $row->objective;
				$name = $row->name;
				$data1 .= "<tr>
			<td>" . $med_name . "</td>
			<td>" . $nos_of_days . "</td>
			<td>" . $eprescription_per_day_schedule . "</td>
			<td><button class='btn btn-link' type='button' onclick='delete_med(\"" . $medicine_id . "\",\"" . $name . "\")'><i class='fa fa-trash'></i></button></td>
			</tr>";
				//	$data1 .="".$med_name."<br>";


			}
			$branch_id = $this->session->user_session->branch_id;
			$get_doctors = $this->PrescriptionModel->get_doctors($doctor_id);

			$option = '';
			$doctor_name = "";
			if ($get_doctors != false) {
				$doctor_name = $get_doctors->name;
			}
			$data1 .= "</tbody>
				</thead>
				</table>";
			$data = "";
			$response['doctor_id'] = $doctor_id;
			$data .= '
							<form id="editPrescription" name="editPrescription" method="post">
										<div id="prescriptionDetailsSection" class="p-3">
											<h4>Prescription Details</h4>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label>Prescription Name</label>
													<input type="hidden" id="ol_pre_name" name="ol_pre_name" value="' . $name . '">
													<input type="text" class="form-control "
														   id="eprescription_list_name"
														   name="eprescription_list_name"
														   data-valid="required"  data-msg="Enter Prescription name"
														   value="' . $name . '"
													/>
												</div>
												<div class="form-group col-md-3">
													<label>Objective</label>
													<input type="text"  class="form-control "
														   id="eprescription_objective"
														   name="eprescription_objective"
														   data-valid="required" 
														   placeholder="Objective"
														   value="' . $objective . '"
													/>
													
												</div>
												<div class="form-group col-md-3">
													<label>Doctor Name</label>
													<select name="edoctor_name" id="edoctor_names"															
															style="width: 100%"
															class="form-control">														
													</select>
												</div>
												<div class="align-items-end col-md-3 d-flex form-group">
												<button class="btn btn-primary">Save</button>
											</div>
											</div>
										</div>
							</form>
						<hr>
						<form id="eprescriptionForm" name="eprescriptionForm" method="post">
										<div id="prescriptionSection" class="p-3">
											<h4>Add New Medicine</h4>
											<div class="form-row">												
												<div class="form-group col-md-3">
													<label>Group Name</label>
													<input type="hidden"  name="eprescription_list_name" value="' . $name . '">
													<input type="hidden"  name="eprescription_objective" value="' . $objective . '">
													<input type="hidden"  name="edoctor_name" value="' . $doctor_id . '">
													<select name="egroup_name" id="egroup_name_medicine_prescription"
															data-valid="required" data-msg="Enter Group name"
															style="width: 100%"
															class="form-control">
														<option>Select Group</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label>Medicine Name</label>
													<select class="form-control"
															id="eprescription_medicine_list"
															style="width: 100%"
															name="eprescription_medicine_list">
														<option value="" selected="" disabled="">Select Medicine
														</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label>Per Day Schedule</label>
													<select data-value="2" class="form-control"
															name="eprescription_per_day_schedule"
															id="eprescription_per_day_schedule"
															data-valid="required" data-msg="Select Per Day Schedule"
															aria-required="true">
														<option disabled="" selected="">Select Per Day Schedule
														</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
													</select>													
												</div>												
												<div class="form-group col-md-3">
													<label>No`s of Day</label>
													<input type="number" name="medicie_no_days"
														   id="medicine_no_days"
														   min="1"
														   data-valid="required" data-msg="Select No`s of Day"
														   class="form-control" >
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Remark</label>
													<textarea class="form-control" name="prescription_remark"
															  id="prescription_remark"
															  placeholder="Enter Remark"
													></textarea>
												</div>
											</div>
											<div class="form-row justify-content-end">
												<button class="btn btn-primary" style="float:right" type="submit" >Save</button><br>
											</div>											
										<br><hr>' . $data1 . '
										</div>
										<hr>
									
									</form>';
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = $data;
		}
		echo json_encode($response);
	}

	public function editPrescription(){
		$validObject = $this->is_parameter(array("ol_pre_name","eprescription_list_name","edoctor_name"));
		if($validObject->status){
			$param = $validObject->param;
			$prescriptionTable = $this->session->user_session->prescription_master_table;
			$prescriptionObject = $this->db->select("id")->where("name",$param->ol_pre_name)->get($prescriptionTable)->result();
			try {
				$this->db->trans_start();
				if (is_array($prescriptionObject)) {
					foreach ($prescriptionObject as $prescription) {
						$this->db->where("id", $prescription->id)
							->set(
								array("name" => $param->eprescription_list_name,
									"objective" => $this->input->post("eprescription_objective"),
									"doctor_id" => $param->edoctor_name
								)
							)->update($prescriptionTable);
					}
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response["status"]=201;
					$response["body"]="Failed To Update";
				} else {
					$this->db->trans_commit();
					$response["status"]=200;
					$response["body"]="Save Changes";
				}
				$this->db->trans_complete();
			}catch (Exception $e){
				$response["status"]=201;
				$response["body"]="Failed To Update";
			}
		}else{
			$response["status"]=201;
			$response["body"]="Try later";
		}
		echo json_encode($response);
	}

	public function update_prescription()
	{
		//$ol_pre_name=$this->input->post('ol_pre_name');
		$new_name = $this->input->post('eprescription_list_name');
		$objective = $this->input->post('eprescription_objective');
		$doctor_name = $this->input->post('edoctor_name');
		$remark = $this->input->post('prescription_remark');
		$perday = $this->input->post('eprescription_per_day_schedule');
		$numday = $this->input->post('medicie_no_days');
		$egroup_name = $this->input->post('egroup_name');
		$eprescription_medicine_list = $this->input->post('eprescription_medicine_list');

		$prescriptionTable = $this->session->user_session->prescription_master_table;


		$data = array(
			"name" => $new_name,
			"medicine_id" => $eprescription_medicine_list,

			"per_date_schedule" => $perday,
			"remark" => $remark,
			"status" => 1,
			"create_by" => $this->session->user_session->id,
			"nos_of_days" => $numday,
			"doctor_id" => $doctor_name,
			"objective" => $objective
		);
		$insert = $this->db->insert($prescriptionTable, $data);


		if ($insert == true) {
			$response['status'] = 200;
			$response['body'] = "Added Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Something Went Wrong";
		}
		echo json_encode($response);
	}

	public function deletePrescription()
	{
		$prescription_name = $this->input->post('item');
		$prescriptionTable = $this->session->user_session->prescription_master_table;
		$set = array("status" => 0);
		$where = array("name" => $prescription_name);
		$update_status = $this->db->update($prescriptionTable, $set, $where);
		if ($update_status == true) {
			$response['status'] = 200;
			$response['body'] = "Deleted Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Something Went Wrong";
		}
		echo json_encode($response);
	}

	public function delete_med()
	{
		$id = $this->input->post('Mid');
		$name = $this->input->post('Pname');
		$prescriptionTable = $this->session->user_session->prescription_master_table;
		$delete = $this->db->delete($prescriptionTable, array("name" => $name, "medicine_id" => $id));
		//	echo $this->db->last_query();
		if ($delete == true) {
			$response['status'] = 200;
			$response['body'] = "Deleted Successfully";
		} else {
			$response['status'] = 201;
			$response['body'] = "Something Went Wrong";
		}
		echo json_encode($response);
	}
}
