<?php

require_once 'HexaController.php';

/**
 * @property  User User
 */
class AssignBedController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Assignbed_model');
	}

	/*
	 * login api
	 */

	public function assignBed()
	{
		$this->load->view('BedManagement/assignBed', array("title" => "Assign Bed"));
	}

	public function room_order()
	{
		$this->load->view('BedManagement/roomorder', array("title" => "Room order"));
	}

	public function add_patient_detials()
	{
		if (!is_null($this->input->post_get('u_Id')) && !is_null($this->input->post_get('name'))
		) {
			$uid = $this->input->post_get('u_Id');
			$name = $this->input->post_get('name');
			$hroom = $this->input->post_get('h_room');
			$bed = $this->input->post_get('b_bed');
			$pid = $this->input->post_get('p_id');
			//$service_id = $this->input->post_get('service_id');
			$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
			$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
			$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
			$patient_table = $this->session->user_session->patient_table;

			if (isset($this->session->user_session)) {
				$branch_id = $this->session->user_session->branch_id;
				if (!isset($branch_id)) {
					session_destroy();
					$response["status"] = 202;
					$response["body"] = 'Session Not Availble. Please login again';
					echo json_encode($response);
					exit();
				}

				//$depart_id = $this->session->user_session->department;
			} else {
				session_destroy();
				$response["status"] = 202;
				$response["body"] = 'Session Not Availble. Please login again';
				echo json_encode($response);
				exit();
			}
			$data = array(
				'patient_name' => $name
			);
			$cat = 1;
			$query = $this->db->query("select * from " . $hospital_room_table . " where id=" . $hroom);
			if ($this->db->affected_rows() > 0) {
				$res = $query->row();
				$cat = $res->category;

			}
			if (!is_null($hroom)) {
				$data["roomid"] = $hroom;
			}
			if (!is_null($bed)) {
				$data["bed_id"] = $bed;
			}
			if ($cat == 2) {
				$data["is_icu_patient"] = 3;
			} else {
				$data["is_icu_patient"] = 2;
			}


			if ($pid != '' || $pid != null) {
                $checkBedTransfer = $this->Assignbed_model->_select('com_1_bed_history',array('patient_id'=>$pid,'branch_id'=>$branch_id),'*',false)->totalCount;
				$resultObject = $this->Assignbed_model->updateMasterPatient($data, $pid, $branch_id, $patient_table, $patient_bed_history_table, $hospital_bed_table);
				if ($resultObject->status) {
                    $checkSmsStatus = $this->Assignbed_model->_select('branch_master',array('id'=>$branch_id,'isSMS'=>1),'*',true);
                    if($checkSmsStatus->totalCount > 0)
                    {
                        $branchData = $checkSmsStatus->data;

                        $this->load->model("SmsModel");
                        if($checkBedTransfer > 0 )
                        {
                            $template = "1107162869101849104";
                            $patientDetails = $this->Assignbed_model->_rawQuery('select contact,(select bed_name from '.$hospital_bed_table.' where id = "'.$bed.'" ) as bed, (select group_concat(room_no,"-",ward_no) from '.$hospital_room_table.' where id = "'.$hroom.'" ) as room from '.$patient_table.' where id = "'.$pid.'"')->data;
                            $PD = $patientDetails[0];
                            if($PD != null)
                            {
                                $this->SmsModel->sendSMS($PD->contact, array("name"=>$name,'center'=>$branchData->name." Center",'bed'=>"Bed no:".$PD->bed,'room'=>"Room no:".$PD->room), $template, $template_id = 2);
                            }
                        }
                        else
                        {
                            $template = "1107162869085979911";
                            $patientDetails = $this->Assignbed_model->_rawQuery('select contact,(select bed_name from '.$hospital_bed_table.' where id = "'.$bed.'" ) as bed, (select group_concat(room_no,"-",ward_no) from '.$hospital_room_table.' where id = "'.$hroom.'" ) as room from '.$patient_table.' where id = "'.$pid.'"')->data;
                            $PD = $patientDetails[0];
                            if($PD != null)
                            {
                                $this->SmsModel->sendSMS($PD->contact,array("name"=>$name,'center'=>$branchData->name." Center",'bed'=>"Bed no:".$PD->bed,'room'=>"Room no:".$PD->room),$template);
                            }
                        }
                    }
					$response["id"] = $resultObject;
					$response["status"] = 200;
					$response["body"] = 'Update Successfully';
				} else {
					$response["status"] = 201;
					$response["body"] = 'Failed To Update';
				}
			} else {
				$response["status"] = 201;
				$response["body"] = 'Parameter missing';
			}
		} else {
			$response["status"] = 201;
			$response["body"] = 'Something went wrong';
		}
		echo json_encode($response);
	}


	function deletePaitent()
	{
		if (!is_null($this->input->post('p_id'))) {
			$branch_id = $this->session->user_session->branch_id;
			$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
			$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
			$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
			$patient_table = $this->session->user_session->patient_table;
			$resultObject = $this->Assignbed_model->deleteMasterPatient($this->input->post('p_id'), $branch_id, $patient_table, $hospital_bed_table, $patient_bed_history_table);
			if ($resultObject->status) {
				$data["status"] = 200;
				$data['body'] = 'Remove Patient Details';
			} else {
				$data["status"] = 201;
				$data['body'] = 'Failed To Delete';
			}
		} else {
			$data["status"] = 201;
			$data['body'] = 'Required Parameter Missing';
		}
		echo json_encode($data);
	}

	function deactivateBed()
	{
		$validObject = $this->is_parameter(array("id", "status", "bedStatus"));
		if ($validObject->status) {
			$bed_id = $validObject->param->id;
			$status = $validObject->param->status;
			$bedStatus = $validObject->param->bedStatus;
			$table_name = $this->session->user_session->hospital_bed_table;

			$resultObject = $this->Assignbed_model->_update($table_name, array("active" => $status, "status" => $bedStatus,'modify_on'=>date('Y-m-d H:i:s'),'modify_by'=>$this->session->user_session->id), array("id" => $bed_id));

			if ($resultObject->status) {
				$response["status"] = 200;
				$response["body"] = "Save Changes";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed Save Changes";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	public function getBedAvilableOption()
	{
		$branch_id = $this->session->user_session->branch_id;
		$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
		$patient_table = $this->session->user_session->patient_table;

		$room_id = $this->input->post_get("room_id");
		$roomList = $this->db->select("*")->where(array("Id_room" => $room_id, "status" => 1, "active" => 0))->get($hospital_bed_table)->result();
		$options = "";
		if (count($roomList) > 0) {
			$options = "<option selected disabled>Select Bed</option>";
			foreach ($roomList as $option) {
				$options .= "<option value='" . $option->id . "'>" . $option->bed_name . "</option>";
			}
		} else {
			$options = "<option selected disabled>No Bed Available</option>";
		}
		$response["status"] = 200;
		$response["body"] = $options;
		echo json_encode($response);
	}

	public function getUserData()
	{
		if (!empty($this->input->get_post('id'))) {
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
			$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
			$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
			$patient_table = $this->session->user_session->patient_table;
			$id = $this->input->get_post('id');
			$result = $this->db->query("select * from " . $patient_table . " where id='$id'")->result();
			//print_r($result);exit();
//			echo $this->db->last_query();
			if (count($result) > 0) {
				$response["status"] = 200;
				$response["body"] = $result;
			} else {
				$response["status"] = 201;
				$response["body"] = "";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "missing paramter";
		}
		echo json_encode($response);
	}

	//Get Bed details Info

	public function getRoomsOptions()
	{
		$facility = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
		$patient_table = $this->session->user_session->patient_table;

		$roomList = $this->db->where("branch_id", $branch_id)->select("*")->get($hospital_room_table)->result();
		$options = "";
		if (count($roomList) > 0) {
			$options = "<option selected disabled>Select Room</option>";
			foreach ($roomList as $option) {
				$options .= "<option value='" . $option->id . "'>" . $option->room_no . " - " . $option->ward_no . "</option>";
			}
		} else {
			$options = "<option selected disabled>No Room</option>";
		}
		$response["status"] = 200;
		$response["body"] = $options;
		echo json_encode($response);
	}

	public function isUniqueUpdate()
	{
		if (!is_null($this->input->post_get('u_Id'))) {
			$id = $this->input->post_get('u_Id');
			$p_id = $this->input->post_get('p_id');
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
			$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
			$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
			$patient_table = $this->session->user_session->patient_table;
			if ($this->Assignbed_model->get_patient_by_uniqueIDUpdate($id, $p_id, $branch_id, $patient_table)) {
				//echo $this->db->last_query();
				echo json_encode(true);
			} else {

				echo json_encode(false);
			}
		} else {
			echo json_encode(false);
		}
	}

	public function getPatientBedHistoryTableData()
	{
		$patient_id = $this->input->post('p_id');
		$branch_id = $this->session->user_session->branch_id;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
		$hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
		$resultObject = $this->Assignbed_model->bed_history($patient_id, $branch_id, $hospital_bed_table, $hospital_room_table, $patient_bed_history_table);
		// print_r($resultObject);exit();
		// $resultObject=$this->DepartmentModel->getTableData($where);

		if ($resultObject->totalCount > 0) {
			$tableRows = array();
			foreach ($resultObject->data as $row) {
				// $date=$row->inTime;
				// $date1=$date->format("F j, Y, g:i a");
				$date = $row->inTime;
				$date1 = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('F j, Y, g:i a');
				$tableRows[] = array(
					$row->room,
					$row->bed,
					$row->inTime = $date1,
					// $row->create_on,
					// $row->create_by,
					$row->id
				);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $resultObject->totalCount,
				"recordsFiltered" => $resultObject->totalCount,
				"data" => $tableRows
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $resultObject->totalCount,
				"recordsFiltered" => $resultObject->totalCount,
				"data" => $resultObject->data
			);
		}


		$results['last_query'] = $resultObject->last_query;
		echo json_encode($results);
	}

	public function getorder_room1()
	{
		$p_id = $this->input->post('p_id');
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;
		$sql = "select inTime,service_id from " . $patient_bed_history_table . " where patient_id='" . $p_id . "' and branch_id = '" . $this->session->user_session->branch_id . "'";

		$query = $this->db->query($sql);
		$rate = array();
		$intime = array();
		$service_id1 = array();

		if ($this->db->affected_rows() > 0) {

			$result = $query->result();
			$oid = $this->generate_order($p_id);
			$cnt = 1;

			foreach ($result as $row) {
				$service_id = $row->service_id;
				$service_id1[] = $row->service_id;
				$get_service_charges = $this->Assignbed_model->get_service_charges($service_id);

				if ($get_service_charges != false) {
					$rate[] = $get_service_charges;
				}

				$intime[] = $row->inTime;
			}


			$count = count($intime);

			$this->db->delete("oder_room_table", array("patient_id" => $p_id));
			$this->db->delete($billing_transaction, array("patient_id" => $p_id, "type" => 1));
			$response["count"] = $count;
			for ($i = 0; $i < $count; $i++) {
				$date1 = $intime[$i];
				$first_time = 0;
				$second_time = 0;
				$j = $i + 1;
				if ($j == $count) {
					$query_dis_date = $this->db->query("select discharge_date from " . $tableName . " where id='$p_id'");
					if ($this->db->affected_rows() > 0) {
						$result_dis = $query_dis_date->row();
						$discharge_date = $result_dis->discharge_date;
					} else {
						$discharge_date = "0000-00-00 00:00:00";
					}
					if ($discharge_date == null || $discharge_date == "0000-00-00 00:00:00") {
						$date2 = date('Y-m-d h:i:s');
					} else {
						$date2 = $discharge_date;
					}

				} else {
					$date2 = $intime[$j];
					if ($j != 0) {

						$d_new = date("Y-m-d", strtotime($date2));
						$d1_new = $d_new . "12:00:00";
						$n_new = date('Y-m-d', strtotime(' +1 day', strtotime($d_new)));
						$d1_new1 = $n_new . "12:00:00";
						$date_a = new DateTime($date2);
						$date_b = new DateTime($d1_new1);
						$interval = date_diff($date_a, $date_b);
						$second_time = $interval->format('%h');

						$date_a1 = new DateTime($d1_new);
						$date_b1 = new DateTime($date2);
						$interval1 = date_diff($date_a1, $date_b1);
						$first_time = $interval1->format('%h');
					}
				}


				$dates = $this->getDatesFromRange($date1, $date2);


				$date1_ts = strtotime($date1);
				$date2_ts = strtotime($date2);
				$diff = $date2_ts - $date1_ts;
				$hour = abs($date1_ts - $date2_ts) / (60 * 60);
				$day = ($diff / 86400);

				for ($k = 0; $k < $day; $k++) {
					if ($k == 0) {
						$date1_ts1 = strtotime($date1);
						$d = $date1;
					} else {
						$date1_ts1 = strtotime($dates[$k]);
						$d = $dates[$k];
					}

					if ($k == (count($dates) - 1)) {

						$d1 = date("Y-m-d H:i:s");
					} else {
						$m = $k + 1;
						$d1 = $dates[$m];
					}


					$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($d1)));
					$diff1 = $date2_ts1 - $date1_ts1;
					$hour = abs($diff1) / (60 * 60);

					if ($first_time != 0 && $second_time != 0) {

						if ($first_time > $second_time) {
							$k1 = $i - 1;
							$rate1 = $rate[$k1];
						} else {
							$rate1 = $rate[$i];
						}
					} else {
						if ($hour <= 12) {
							$rate1 = $rate[$i] / 2;
						} else {
							$rate1 = $rate[$i];
						}
					}


					$service_name = "";
					$get_service_name = $this->db->query("select service_description from service_master where service_id='$service_id1[$i]'");
					if ($this->db->affected_rows() > 0) {
						$res11 = $get_service_name->row();
						$service_name = $res11->service_description;
					}


					$array = array(
						"service_id" => $service_id1[$i],
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate1,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $d,
					);
					$array2 = array(
						"service_id" => $service_id1[$i],
						"patient_id" => $p_id,
						"rate" => $rate1,
						"total" => $rate1,
						"order_id" => $oid,
						"service_desc" => $service_name,
						"date_service" => $d,
						"unit" => 1,
						"type" => 1,
						"branch_id" => $branch_id,
						"confirm" => 1

					);
					$d5 = date('Y-m-d', strtotime($d));
					$d51 = $d5 . " 00:00:00";
					//$insert= $this->db->insert("oder_room_table",$array);
					$query = $this->db->query("select id from oder_room_table where date_service='$d51' AND branch_id='$branch_id' AND patient_id='$p_id'");
					if ($this->db->affected_rows() > 0) {
						$delete = $this->db->delete("oder_room_table", array("id" => $query->row()->id));
					}
					$query2 = $this->db->query("select id from " . $billing_transaction . " where date_service='$d51' AND branch_id='$branch_id' AND patient_id='$p_id'");
					if ($this->db->affected_rows() > 0) {
						$delete1 = $this->db->delete($billing_transaction, array("id" => $query2->row()->id));
					}
					$t1 = 'oder_room_table';
					$insert = $this->Assignbed_model->insert_order($t1, $array, $billing_transaction, $array2);
					if ($insert == true) {


						$cnt++;
					}
				}
			}
			if ($cnt > 1) {
				$response["status"] = 200;
				$response["body"] = "Added Successfully.";
			} else {
				$response["status"] = 201;
				$response["body"] = "Something Went wrong.";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "No data availabel for this patient.";
		}
		echo json_encode($response);
	}

	public function add_doctor_consultation($p_id)
	{
		$branch_id = $this->session->user_session->branch_id;
		$query = $this->db->query("select *,
		(select name from option_master o where o.id=h.sec_26_f_143) as option_service from his_com_1_dep_9 h where patient_id=" . $p_id);
		$cnt = 0;
		$billing_transaction = $this->session->user_session->billing_transaction;
		if ($this->db->affected_rows() > 0) {
			$where = "patient_id=" . $p_id . " AND type=3 AND (service_id='CON005' OR service_id='CON006')";
			$this->db->delete($billing_transaction, $where);
			$result = $query->result();
			$service_id = "";
			$rate = 0;
			$oid = $this->generate_order($p_id);
			foreach ($result as $row) {
				$service_name = $row->option_service;
				$get_service_charges = $this->Assignbed_model->get_service_chargesbyname($service_name);
				if ($get_service_charges != false) {
					$service_id = $get_service_charges->service_id;
					$rate = $get_service_charges->rate;
				}
				$trans_date = $row->trans_date;
				/* $array = array(
						"service_id" => $service_id,
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $trans_date,
					); */
				$array2 = array(
					"service_id" => $service_id,
					"patient_id" => $p_id,
					"rate" => $rate,
					"total" => $rate,
					"final_amount" => $rate,
					"total" => $rate,
					"order_id" => $oid,
					"service_desc" => $service_name,
					"date_service" => $trans_date,
					"unit" => 1,
					"type" => 3,
					"branch_id" => $branch_id,
					"confirm" => 1

				);
				$t1 = 'oder_room_table';

				$insert = $this->Assignbed_model->insert_order_bill($billing_transaction, $array2);


			}

			return true;

		} else {
			return false;
		}
	}

	public function assignBedCalculation()
	{

		$p_id = $this->input->post('p_id');


		if (!is_null($p_id)) {
			try {
				$billing_transaction = $this->session->user_session->billing_transaction;
				$branch_id = $this->session->user_session->branch_id;

				$this->db->trans_start();
				//add doctor Consulatation
				$this->add_doctor_consultation($p_id);
				// delete existing bed details from order room and billing transaction
				$this->db->delete("oder_room_table", array("patient_id" => $p_id));
				$this->db->delete($billing_transaction, array("patient_id" => $p_id, "type" => 1));

				// get all bed rate and duration details
				$bedCalculationArray = $this->calculateAssignBed($p_id);
				$response["object"] = $bedCalculationArray;
				$oid = $this->generate_order($p_id);

				foreach ($bedCalculationArray as $object) {
					if ($object->type != -1) {
						$roomOrder = array(
							"service_id" => $object->type,
							"patient_id" => $p_id,
							"order_id" => $oid,
							"price" => $object->rate,
							"branch_id" => $branch_id,
							"service_name" => $object->service_name,
							"date_service" => $object->datetime,
						);
						$billingData = array(
							"service_id" => $object->type,
							"patient_id" => $p_id,
							"rate" => $object->rate,
							"total" => $object->rate,
							"final_amount" => $object->rate,
							"order_id" => $oid,
							"service_desc" => $object->service_name,
							"date_service" => $object->datetime,
							"unit" => 1,
							"type" => 1,
							"branch_id" => $branch_id,
							"confirm" => 1

						);
						$insert = $this->db->insert('oder_room_table', $roomOrder);
						if ($insert == true) {
							$this->db->insert($billing_transaction, $billingData);
						}
					}
				}

				// check all transaction of done with success.
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
			} catch (Exception $exc) {
				$this->db->trans_rollback();
				$this->db->trans_complete();
				log_message('error', $exc->getMessage());
				$result = FALSE;
			}

			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Added Successfully.";
			} else {
				$response["status"] = 201;
				$response["body"] = "Something Went wrong.";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "No data available for this patient.";
		}

		echo json_encode($response);
	}

	public function getorder_room_pp()
	{
		$p_id = $this->input->post('p_id');
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;

		//add doctor Consulatation
		$dr_con = $this->add_doctor_consultation($p_id);
		//add bed mangement
		$sql = "select inTime,(select bed_type from " . $hospital_bed_table . " b where b.id=h.bed_id) as service_id
		from " . $patient_bed_history_table . " h where patient_id='" . $p_id . "' and branch_id = '" . $this->session->user_session->branch_id . "'";

		$query = $this->db->query($sql);
		$rate = array();
		$intime = array();
		$service_id1 = array();

		if ($this->db->affected_rows() > 0) {

			$result = $query->result();
			$oid = $this->generate_order($p_id);
			$cnt = 1;

			foreach ($result as $row) {
				$service_id = $row->service_id;
				$service_id1[] = $row->service_id;
				$get_service_charges = $this->Assignbed_model->get_service_charges($service_id);

				if ($get_service_charges != false) {
					$rate[] = $get_service_charges;
				}

				$intime[] = $row->inTime;
			}
			$query_dis_date = $this->db->query("select discharge_date,admission_date from " . $tableName . " where id='$p_id'");
			if ($this->db->affected_rows() > 0) {
				$result_dis = $query_dis_date->row();
				$discharge_date = $result_dis->discharge_date;
				$admission_date = $result_dis->admission_date;
			} else {
				$discharge_date = "0000-00-00 00:00:00";
				$admission_date = "0000-00-00 00:00:00";
			}

			if ($discharge_date == null || $discharge_date == "0000-00-00 00:00:00") {
				$date2 = date('Y-m-d H:i:s');
			} else {
				$date2 = $discharge_date;
			}
			if ($admission_date == null || $admission_date == "0000-00-00 00:00:00") {
				$date1 = $intime[0];
			} else {
				$date1 = $admission_date;
				$intime[0] = $date1;
			}


			array_push($intime, $date2);

			$count = count($intime);
			$var_dates = array();
			$var_dates1 = array();
			$var_services = array();
			$var_rate = array();
			for ($i = 0; $i < $count; $i++) {

				$date = $intime[$i];
				$k = $i + 1;
				if ($k == $count) {

				} else {

					$date1 = $intime[$k];
					$dates = $this->getDatesFromRange($date, $date1);

					$m = 0;
					foreach ($dates as $newd) {
						if ($m == 0) {
							$var_dates[] = $newd;
							$var_dates1[] = date('Y-m-d', strtotime($newd));
						} else {
							$dd = date('Y-m-d', strtotime($newd));
							$var_dates[] = $dd . " 12:00:00";
							$var_dates1[] = date('Y-m-d', strtotime($newd));
						}
						$var_services[] = $service_id1[$i];
						$var_rate[] = $rate[$i];
						$m++;
					}
				}
			}

			$arr_unique = array_unique($var_dates1);
			$arr_duplicates = array_diff_assoc($var_dates1, $arr_unique);
			$hourfirst_date = null;
			$hoursecond_date = null;
			$var_cnt = count($var_dates);
			$minus_cnt = $var_cnt - 1;
			$service_name11 = array();
			$this->db->delete("oder_room_table", array("patient_id" => $p_id));
			$this->db->delete($billing_transaction, array("patient_id" => $p_id, "type" => 1));
			for ($n = 0; $n < $var_cnt; $n++) {
				$service_name = "";
				$get_service_name = $this->db->query("select service_description from service_master where service_id='$var_services[$n]'");
				if ($this->db->affected_rows() > 0) {
					$res11 = $get_service_name->row();
					$service_name = $res11->service_description;

				}
				$d = $var_dates[$n];
				if ($minus_cnt == $n) {  //last day calculation

					$last_date = $date2;
					if ($n != 0) {
						$t = $n - 1;
					} else {
						$t = $n;
					}

					$date1_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
					$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($date2)));
					$diff1 = $date2_ts1 - $date1_ts1;
					$hour = abs($diff1) / (60 * 60);
					if ($hour <= 12) {
						$rate1 = $var_rate[$n] / 2;
					} else {
						$rate1 = $var_rate[$n];
					}
					$date1_p = strtotime(date('Y-m-d', strtotime($var_dates[$n])));
					$date2_p = strtotime(date('Y-m-d', strtotime($date2)));
					$time_n = date('Hi', strtotime($last_date));
					if ($date1_p == $date2_p && $time_n <= 1200) {
						$s = $n - 1;
						$date1_ts1_n = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$s])));
					} else {
						$date1_ts1_n = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$n])));
					}

					$date2_ts1_n = strtotime(date('Y-m-d H:i:s', strtotime($date2)));
					$diff1_n = $date2_ts1_n - $date1_ts1_n;
					$hour_n = abs($diff1_n) / (60 * 60);
					if ($hour_n <= 12) {
						$rate1_n = $var_rate[$n] / 2;
					} else {
						$rate1_n = $var_rate[$n];
					}


					$l_date = null;
					if ($time_n <= date('Hi', strtotime('1200'))) {
						$l_date = date('Y-m-d 12:00:00', strtotime($last_date));
					}

					/* if($time_n <= date('Hi', strtotime('1200'))){
						$arraylast=false;
					}	else{ */
					$arraylast = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate1_n,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $last_date,
					);
					$array2_last = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"rate" => $rate1_n,
						"total" => $rate1_n,
						"final_amount" => $rate1_n,
						"order_id" => $oid,
						"service_desc" => $service_name,
						"date_service" => $last_date,
						"unit" => 1,
						"type" => 1,
						"branch_id" => $branch_id,
						"confirm" => 1

					);
					//}
				} else { //other day calculation
					$t = $n + 1;
					$time1 = date('Hi', strtotime($var_dates[$n]));
					//echo $var_dates[$n];
					$date1_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$n])));
					$curr_date = date('Y-m-d', strtotime($var_dates[$n]));
					$admitdate = date('Y-m-d', strtotime($admission_date));
					if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 <= date('Hi', strtotime('1200'))) {
						$date2_ts1 = strtotime(date('Y-m-d 12:00:00', strtotime($var_dates[$n])));
					} else {
						if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 >= date('Hi', strtotime('1200'))) { //get time difference if shift on first day rate calculation
							$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
							$diff1 = $date2_ts1 - $date1_ts1;
							$hourfirst_date = abs($diff1) / (60 * 60);
							$ratefirst = $var_rate[$n];
							$service_first = $res11->service_description;
							$date21_ts1 = strtotime(date('Y-m-d 12:00:00', strtotime($var_dates[$t])));
							$diff12 = $date21_ts1 - $date2_ts1;
							$hoursecond_date = abs($diff12) / (60 * 60);
							$p = $n + 1;
							$ratesecond = $var_rate[$p];
							$service_second = $res11->service_description;


						}


						$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
					}
					$diff1 = $date2_ts1 - $date1_ts1;
					$hour = abs($diff1) / (60 * 60);


					if ($hour <= 12) {
						$rate1 = $var_rate[$n] / 2;
					} else {
						$rate1 = $var_rate[$n];
					}

				}
				$curr_date1 = date('Y-m-d', strtotime($d));
				$admitdate2 = date('Y-m-d', strtotime($admission_date));

				if ((in_array(date('Y-m-d', strtotime($d)), $arr_duplicates)) && ((strtotime($curr_date1) != strtotime($admitdate2)))) { //shift bed rate-- take maximum time spent

					$time = date('H', strtotime($d));

					if ($n != 0) {
						$t = $n - 1;
					} else {
						$t = $n;
					}

					$rate1 = $var_rate[$t];
					$service_name = $this->get_service_name_new($var_services[$t]);
				}

				if ($hourfirst_date != null && $hoursecond_date != null) { // if bed is shift on first day assign rate
					if ($n == $p) {
						//$ratefirst
						//$ratesecond
						if ($hourfirst_date > $hoursecond_date) {
							$rate1 = $ratefirst;
							$service_name = $service_first;
						}
						if ($hoursecond_date > $hourfirst_date) {
							$rate1 = $ratesecond;
							$service_name = $service_second;
						}
					}
				}

				$time1 = date('Hi', strtotime($d));

				$curr_date = date('Y-m-d', strtotime($d));
				$admitdate = date('Y-m-d', strtotime($admission_date));
				if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 >= date('Hi', strtotime('1200'))) { // if patient is admitted after 12

				} else {
					$array = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate1,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $d,
					);
					$array2 = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"rate" => $rate1,
						"total" => $rate1,
						"final_amount" => $rate1,
						"total" => $rate1,
						"order_id" => $oid,
						"service_desc" => $service_name,
						"date_service" => $d,
						"unit" => 1,
						"type" => 1,
						"branch_id" => $branch_id,
						"confirm" => 1

					);

					$d5 = date('Y-m-d', strtotime($d));
					$d51 = $d5;
					//$insert= $this->db->insert("oder_room_table",$array);

					$query = $this->db->query("select id from oder_room_table where date_service like '%$d51%' AND branch_id='$branch_id' AND patient_id='$p_id'");
					if ($this->db->affected_rows() > 0) {
						$delete = $this->db->delete("oder_room_table", array("id" => $query->row()->id));
					}
					$query2 = $this->db->query("select id from " . $billing_transaction . " where date_service like '%$d51%' AND branch_id='$branch_id' AND patient_id='$p_id' AND type=1");

					if ($this->db->affected_rows() > 0) {
						$delete1 = $this->db->delete($billing_transaction, array("id" => $query2->row()->id));
					}

					$t1 = 'oder_room_table';
					$insert = $this->Assignbed_model->insert_order($t1, $array, $billing_transaction, $array2);
					if ($insert == true) {


						$cnt++;
					}
				}


			}


			//var_dump($dates);
			if ($cnt > 1) {
				if ($arraylast != false) {
					if ($l_date != null) {
						$delete1 = $this->db->delete($billing_transaction, array("patient_id" => $p_id, "date_service" => $l_date, "type" => 1));
					}
					$insert = $this->db->insert($t1, $arraylast);
					if ($insert == true) {
						$this->db->insert($billing_transaction, $array2_last);
					}
				}

				$response["status"] = 200;
				$response["body"] = "Added Successfully.";
			} else {
				$response["status"] = 201;
				$response["body"] = "Something Went wrong.";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "No data availabel for this patient.";
		}
		echo json_encode($response);
	}

	function get_service_name_new($service_id)
	{
		$service_name = "";
		$get_service_name = $this->db->query("select service_description from service_master where service_id='$service_id'");
		if ($this->db->affected_rows() > 0) {
			$res11 = $get_service_name->row();
			$service_name = $res11->service_description;

		}
		return $service_name;
	}

	function getDatesFromRange($date1, $date2, $format = 'Y-m-d H:i:s')
	{
		$dates = array();
		$datelast = $date2;
		$current = strtotime($date1);
		$date2 = strtotime($date2);
		$stepVal = '+1 day';
		while ($current <= $date2) {
			$dates[] = date($format, $current);
			$current = strtotime($stepVal, $current);
		}
		$cnt = count($dates);
		$k = $cnt - 1;
		$hour = date('Hi', strtotime($datelast));
		if ((date('Y-m-d', strtotime($dates[$k])) != date('Y-m-d', strtotime($datelast))) && $hour > 1200) {
			$dates[] = date($format, $current);
		}


		return $dates;
	}

	function getDatesFromRange1($start, $end, $format = 'Y-m-d H:i:s')
	{


		// Declare an empty array
		$array = array();

		// Variable that store the date interval
		// of period 1 day
		$interval = new DateInterval('P1D');
		if ($end != "0000-00-00 00:00:00") {
			$realEnd = new DateTime($end);
		} else {
			$realEnd = new DateTime(date('Y-m-d H:i:s'));
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

	public function generate_order($p_id)
	{
		$order_id = 'O_' . $p_id . '_' . rand(100, 100000);
		$result = $this->db->query("select order_id from oder_room_table where order_id='$order_id'")->row();
		if (is_object($result)) {
			return $this->generate_order($p_id);
		} else {
			return $order_id;
		}

	}

	public function getorder_room_pooja()
	{
		$p_id = $this->input->post('p_id');
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;
		$sql = "select inTime,(select bed_type from " . $hospital_bed_table . " b where b.id=h.bed_id) as service_id
		from " . $patient_bed_history_table . " h where patient_id='" . $p_id . "' and branch_id = '" . $this->session->user_session->branch_id . "'";

		$query = $this->db->query($sql);
		$rate = array();
		$intime = array();
		$service_id1 = array();
		$var_rate_date_wise = array();

		if ($this->db->affected_rows() > 0) {

			$result = $query->result();
			$oid = $this->generate_order($p_id);
			$cnt = 1;

			foreach ($result as $row) {
				$service_id = $row->service_id;
				$service_id1[] = $row->service_id;
				$get_service_charges = $this->Assignbed_model->get_service_charges($service_id);

				if ($get_service_charges != false) {
					$rate[] = $get_service_charges;
				}

				$intime[] = $row->inTime;
			}
			$query_dis_date = $this->db->query("select discharge_date,admission_date from " . $tableName . " where id='$p_id'");
			if ($this->db->affected_rows() > 0) {
				$result_dis = $query_dis_date->row();
				$discharge_date = $result_dis->discharge_date;
				$admission_date = $result_dis->admission_date;
			} else {
				$discharge_date = "0000-00-00 00:00:00";
				$admission_date = "0000-00-00 00:00:00";
			}

			if ($discharge_date == null || $discharge_date == "0000-00-00 00:00:00") {
				$date2 = date('Y-m-d H:i:s');
			} else {
				$date2 = $discharge_date;
			}
			if ($admission_date == null || $admission_date == "0000-00-00 00:00:00") {
				$date1 = $intime[0];
			} else {
				$date1 = $admission_date;
				$intime[0] = $date1;
			}


			array_push($intime, $date2);

			$count = count($intime);
			$var_dates = array();
			$var_dates1 = array();
			$var_services = array();
			$var_rate = array();
			$var_rate_date_wise = array();
			$var_service_date_wise = array();
			for ($i = 0; $i < $count; $i++) {

				$date = $intime[$i];
				$k = $i + 1;
				if ($k == $count) {

				} else {

					$date1 = $intime[$k];
					$dates = $this->getDatesFromRange($date, $date1);

					$m = 0;
					foreach ($dates as $newd) {
						if ($m == 0) {
							$var_dates[] = $newd;
							$var_dates1[] = date('Y-m-d', strtotime($newd));
						} else {
							$dd = date('Y-m-d', strtotime($newd));
							$var_dates[] = $dd . " 12:00:00";
							$var_dates1[] = date('Y-m-d', strtotime($newd));
						}
						$var_services[] = $service_id1[$i];
						$var_rate[] = $rate[$i];
						$pq = date('Y-m-d', strtotime($newd));
						$var_rate_date_wise[$pq] = $rate[$i];
						$var_service_date_wise[$pq] = $service_id1[$i];
						$m++;
					}
				}
			}


			$arr_unique = array_unique($var_dates1);
			$arr_duplicates = array_diff_assoc($var_dates1, $arr_unique);
			$hourfirst_date = null;
			$hoursecond_date = null;
			$hour = null;
			$next_date = null;
			$time = null;
			//var_dump($var_dates);
			$var_cnt = count($var_dates);
			$minus_cnt = $var_cnt - 1;
			$service_name11 = array();
			$this->db->delete("oder_room_table", array("patient_id" => $p_id));
			$this->db->delete($billing_transaction, array("patient_id" => $p_id, "type" => 1));
			for ($n = 0; $n < $var_cnt; $n++) {
				$service_name = "";
				$get_service_name = $this->db->query("select service_description from service_master where service_id='$var_services[$n]'");
				if ($this->db->affected_rows() > 0) {
					$res11 = $get_service_name->row();
					$service_name = $res11->service_description;

				}
				$d = $var_dates[$n];
				if ($minus_cnt == $n) {  //last day calculation

					$last_date = $date2;
					if ($n != 0) {
						$t = $n - 1;
					} else {
						$t = $n;
					}

					$date1_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
					$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($date2)));
					$diff1 = $date2_ts1 - $date1_ts1;
					$hour = abs($diff1) / (60 * 60);
					if ($hour <= 12) {
						$rate1 = $var_rate[$n] / 2;
					} else {
						$rate1 = $var_rate[$n];
					}
					$date1_ts1_n = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$n])));
					$date2_ts1_n = strtotime(date('Y-m-d H:i:s', strtotime($date2)));
					$diff1_n = $date2_ts1_n - $date1_ts1_n;
					$hour_n = abs($diff1_n) / (60 * 60);
					if ($hour_n <= 12) {
						$rate1_n = $var_rate[$n] / 2;
					} else {
						$rate1_n = $var_rate[$n];
					}

					$time_n = date('Hi', strtotime($last_date));


					/* if($time_n <= date('Hi', strtotime('1200'))){
						$arraylast=false;
					}	else{ */
					$arraylast = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate1_n,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $last_date,
					);
					$array2_last = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"rate" => $rate1_n,
						"total" => $rate1_n,
						"final_amount" => $rate1_n,
						"order_id" => $oid,
						"service_desc" => $service_name,
						"date_service" => $last_date,
						"unit" => 1,
						"type" => 1,
						"branch_id" => $branch_id,
						"confirm" => 1

					);
					//}
				} else { //other day calculation
					$t = $n + 1;
					$time1 = date('Hi', strtotime($var_dates[$n]));
					//echo $var_dates[$n];
					$date1_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$n])));
					$curr_date = date('Y-m-d', strtotime($var_dates[$n]));
					$admitdate = date('Y-m-d', strtotime($admission_date));
					if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 <= date('Hi', strtotime('1200'))) {
						$date2_ts1 = strtotime(date('Y-m-d 12:00:00', strtotime($var_dates[$n])));
					} else {
						if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 >= date('Hi', strtotime('1200'))) { //get time difference if shift on first day rate calculation
							$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
							$diff1 = $date2_ts1 - $date1_ts1;
							$hourfirst_date = abs($diff1) / (60 * 60);
							$ratefirst = $var_rate[$n];
							$service_first = $res11->service_description;
							$date21_ts1 = strtotime(date('Y-m-d 12:00:00', strtotime($var_dates[$t])));
							$diff12 = $date21_ts1 - $date2_ts1;
							$hoursecond_date = abs($diff12) / (60 * 60);
							$p = $n + 1;
							$ratesecond = $var_rate[$p];
							$service_second = $res11->service_description;


						}


						$date2_ts1 = strtotime(date('Y-m-d H:i:s', strtotime($var_dates[$t])));
					}
					$diff1 = $date2_ts1 - $date1_ts1;
					$hour = abs($diff1) / (60 * 60);
					$rate_new = $var_rate[$n];

					if ($next_date != null) {

						$nextdate = strtotime($next_date);
						$currdate = strtotime(date('Y-m-d', strtotime($d)));

						if ($nextdate == $currdate) {
							if ($time > 0001 && $time < 1200) {
								$prev_date = date('Y-m-d', strtotime('-2 day', strtotime($next_date)));
								if (array_key_exists($prev_date, $var_rate_date_wise)) {
									$rate_new = $var_rate_date_wise[$prev_date];
									$service_id = $var_service_date_wise[$prev_date];
									$service_name = $this->get_service_name_new($service_id);
								} else {
									$rate_new = $var_rate_date_wise[$next_date];
									$service_id = $var_service_date_wise[$next_date];
									$service_name = $this->get_service_name_new($service_id);
								}
							}
						}
					}

					if ($hour <= 12) {
						$rate1 = $rate_new / 2;
					} else {
						$rate1 = $rate_new;
					}

				}
				$curr_date1 = date('Y-m-d', strtotime($d));
				$admitdate2 = date('Y-m-d', strtotime($admission_date));

				if ((in_array(date('Y-m-d', strtotime($d)), $arr_duplicates)) && ((strtotime($curr_date1) != strtotime($admitdate2)))) { //shift bed rate-- take maximum time spent

					$next_date = null;
					$time = date('Hi', strtotime($d));
					//if($time != '00'){
					/*  if($time > 12){
						if($n == $minus_cnt){
							$t=$n;
						}else{
							$t=$n+1;
						}
						$service_name=$this->get_service_name_new($var_services[$t]);

						$rate1 = $var_rate[$t];

					}else{

						if($n != 0){
							$t=$n-1;
						}else{
							$t=$n;
						}

						$rate1 = $var_rate[$t];
						$service_name=$this->get_service_name_new($var_services[$t]);


					} */
					if ($n != 0) {
						$t = $n - 1;
					} else {
						$t = $n;
					}

					$rate1 = $var_rate[$t];
					$service_name = $this->get_service_name_new($var_services[$t]);

					$next_date = date('Y-m-d', strtotime('+1 day', strtotime($d)));


					//}
				}

				if ($hourfirst_date != null && $hoursecond_date != null) { // if bed is shift on first day assign rate
					if ($n == $p) {
						//$ratefirst
						//$ratesecond
						if ($hourfirst_date > $hoursecond_date) {
							$rate1 = $ratefirst;
							$service_name = $service_first;
						}
						if ($hoursecond_date > $hourfirst_date) {
							$rate1 = $ratesecond;
							$service_name = $service_second;
						}
					}
				}

				$time1 = date('Hi', strtotime($d));

				$curr_date = date('Y-m-d', strtotime($d));
				$admitdate = date('Y-m-d', strtotime($admission_date));
				if ((strtotime($curr_date) == strtotime($admitdate)) && $time1 >= date('Hi', strtotime('1200'))) { // if patient is admitted after 12

				} else {
					$array = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"order_id" => $oid,
						"price" => $rate1,
						"branch_id" => $branch_id,
						"service_name" => $service_name,
						"date_service" => $d,
					);
					$array2 = array(
						"service_id" => $var_services[$n],
						"patient_id" => $p_id,
						"rate" => $rate1,
						"total" => $rate1,
						"final_amount" => $rate1,
						"total" => $rate1,
						"order_id" => $oid,
						"service_desc" => $service_name,
						"date_service" => $d,
						"unit" => 1,
						"type" => 1,
						"branch_id" => $branch_id,
						"confirm" => 1

					);

					$d5 = date('Y-m-d', strtotime($d));
					$d51 = $d5;
					//$insert= $this->db->insert("oder_room_table",$array);

					$query = $this->db->query("select id from oder_room_table where date_service like '%$d51%' AND branch_id='$branch_id' AND patient_id='$p_id'");
					if ($this->db->affected_rows() > 0) {
						$delete = $this->db->delete("oder_room_table", array("id" => $query->row()->id));
					}
					$query2 = $this->db->query("select id from " . $billing_transaction . " where date_service like '%$d51%' AND branch_id='$branch_id' AND patient_id='$p_id' AND type=1");

					if ($this->db->affected_rows() > 0) {
						$delete1 = $this->db->delete($billing_transaction, array("id" => $query2->row()->id));
					}

					$t1 = 'oder_room_table';
					$insert = $this->Assignbed_model->insert_order($t1, $array, $billing_transaction, $array2);
					if ($insert == true) {


						$cnt++;
					}
				}

			}


			//var_dump($dates);
			if ($cnt > 1) {
				if ($arraylast != false) {
					$insert = $this->db->insert($t1, $arraylast);
					if ($insert == true) {
						$this->db->insert($billing_transaction, $array2_last);
					}
				}
				$response["status"] = 200;
				$response["body"] = "Added Successfully.";
			} else {
				$response["status"] = 201;
				$response["body"] = "Something Went wrong.";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "No data availabel for this patient.";
		}
		echo json_encode($response);
	}

	public function getorder_room()
	{
		$p_id = $this->input->post('p_id');
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;
		if (is_null($p_id)) {
			$response['status'] = 201;
			$response['body'] = "Something Went Wrong.Refresh the page and try again";
			echo json_encode($response);
			exit;

		}
		$query_dis_date = $this->db->query("select discharge_date,admission_date from " . $tableName . " where id='$p_id'");

		if ($this->db->affected_rows() > 0) {
			$result_dis = $query_dis_date->row();
			$discharge_date = $result_dis->discharge_date;
			$admission_date = $result_dis->admission_date;
		} else {
			$discharge_date = "0000-00-00 00:00:00";
			$admission_date = "0000-00-00 00:00:00";
		}

		if ($discharge_date == null || $discharge_date == "0000-00-00 00:00:00") {
			$date2 = date('Y-m-d H:i:s');
		} else {
			$date2 = $discharge_date;
		}
		$getRateData = $this->getRateData($p_id);
		$rates = $getRateData[0];
		$dates_bed = $getRateData[1];
		$dates = $this->getDatesRange($admission_date, $date2);
		$m = 0;
		$count = count($rates);
		$n = $count - 1;
		$rate_array = array();
		$next_date1 = "";

		$objectOfDates = array();
		foreach ($dates as $newd) {
			$object = new stdClass();
			$object->newd = $newd;
			$date = date('Y-m-d', strtotime($newd));
			$admit_date = date('Y-m-d', strtotime($admission_date));
			$dis_date = date('Y-m-d', strtotime($discharge_date));
			//admission_date calculation
			if (strtotime($date) == strtotime($admit_date)) {
				$time_admission = date('Hi', strtotime($admission_date));
				if ($time_admission < 1200) {
					$rate_array[$admission_date] = $rates[0] / 2;
				}
			} else if (strtotime($date) == strtotime($dis_date)) {
				//last day calculation
				$time_discharge = date('Hi', strtotime($discharge_date));

				if ($time_discharge > 1200) {
					$discharge_date1 = date('Y-m-d 12:00:00', strtotime($discharge_date));
					$rate_array[$discharge_date1] = $rates[$n];
					$rate_array[$discharge_date] = $rates[$n] / 2;
				} else {
					$rate_array[$discharge_date] = $rates[$n];
				}
			} else {
				//middle days calculation
				$middleDaysArray = array();
				for ($i = 0; $i < $count; $i++) {
					$mObject = new stdClass();

					$d1 = $dates_bed[$i]; // bed assign date
					$mObject->d1 = $d1;
					if ($count == 1 || $i == $n) {
						$d2 = $dis_date;  // only one bed assign or last date
					} else {
						$j = $i + 1;
						$d2 = $dates_bed[$j]; // next assign bed
					}

					$mObject->d2 = $d2;
					$d1_c = date('Y-m-d', strtotime($d1)); // start date
					$d2_c = date('Y-m-d', strtotime($d2)); // end date
					$date1 = date('Y-m-d', strtotime($date)); // current date
					$mObject->date1 = $date1;
					if (strtotime($date1) == strtotime($d1_c)) {
						//shifting calculation
						$shift_time = date('Hi', strtotime($d1));
						$next_date1 = date('Y-m-d', strtotime('+1 day', strtotime($date1)));
						$next_date = date('Y-m-d 12:00:00', strtotime($next_date1));
						$rate_array[$next_date] = $rates[$i];
						$mObject->shift_time = $shift_time;
						$mObject->next_date1 = $next_date1;
						$mObject->next_date = $next_date;
						$mObject->rates = $rates[$i];
					} else {

						//normal days calculation
						if (strtotime($date1) != strtotime($next_date1)) {

							$dt1 = strtotime($d1_c);
							$dt2 = strtotime($d2_c);
							$currdate = strtotime($date);
							$date = date('Y-m-d 12:00:00', strtotime($date));
							if (($currdate >= $dt1) && ($currdate <= $dt2)) {
								if (!array_key_exists($date, $rate_array)) {
									$rate_array[$date] = $rates[$i];
								}
							} else {
								//if(!array_key_exists($date,$rate_array)){
								//$rate_array[$date]=$rates[$i];
								//}
								$rate_array[$date] = $rates[$i];
							}
							$mObject->d1_c = $d1_c;
							$mObject->d2_c = $d2_c;
							$mObject->currdate = $currdate;
							$mObject->rates = $rates[$i];
						} else {

						}
					}
					array_push($middleDaysArray, $mObject);
				}
				$object->middleDayData = $middleDaysArray;
			}


			array_push($objectOfDates, $object);
			$m++;
		}
		var_dump($rate_array);
		var_dump($objectOfDates);
	}


	function calculateAssignBed($p_id)
	{
		//$p_id = $this->input->post('p_id');
		$tableName = $this->session->user_session->patient_table;
		$ADT = $this->db
			->where('id', $p_id)
			->select(array("discharge_date", "admission_date"))
			->get($tableName)->row();
		$bedArray = array();
		if (!is_null($ADT)) {
			$admissionDate = $ADT->admission_date;
			if (is_null($ADT->discharge_date) || $ADT->discharge_date == "0000-00-00 00:00:00") {
				$dischargeDate = date('Y-m-d H:i:s');
			} else {
				$dischargeDate = $ADT->discharge_date;
			}

			// find bed rate and transfer date
			$bedRateData = $this->getRateData($p_id);
			$rate = $bedRateData[0];
			$bedAssignDate = $bedRateData[1];

			// all date from admission to discharge or current datetime
			 $duration = $this->getDatesRange($admissionDate, $dischargeDate);
			//array("2021-06-15","2021-06-16","2021-06-17");

			$joinDate = date('Y-m-d', strtotime($admissionDate));
			$leaveDate = date('Y-m-d', strtotime($dischargeDate));
//			$query = $this->db->query("call getDateRange(" . $p_id . ")");
//			$durationResult = $query->row();
//			$query->next_result();
//			$query->free_result();
			// check rate and bedAssignDate is available
			if (count($rate) > 0 and count($bedAssignDate) > 0) {
				$firstBedRate = $rate[0];
				$firstBedInTime = $bedAssignDate[0];
				$isDischarge = false;
//				if (!is_null($durationResult)) {
//					$duration = explode(",", $durationResult->dateRange);
//
//					$duration[count($duration) - 1] = $dischargeDate;

					foreach ($duration as $loopDateTime) {

						$isFirstOrLast = 3;
						// check admission date
						if ($this->checkEqualDate(date('Y-m-d',strtotime($loopDateTime)), $joinDate)) {
							if ($this->checkEqualDate(date('Y-m-d',strtotime($loopDateTime)), $leaveDate)) {
								$object = $this->sameDayAdmitDischarge($loopDateTime, $p_id, $admissionDate, $dischargeDate, $firstBedRate);
								if ($object->admission != null) {
									array_push($bedArray, $object->admission);
									$firstBedInTime = $object->admission->startDateTime;
									$firstBedRate = $object->admission->og_rate;
								}
								if ($object->discharge != null) {
									array_push($bedArray, $object->discharge);
									$firstBedInTime = $object->discharge->startDateTime;
									$firstBedRate = $object->discharge->og_rate;
								}
								$isDischarge = true;
								continue;
							} else {
								$loopDateTime = $admissionDate;
								$isFirstOrLast = 1;
							}

						} else if ($this->checkEqualDate($loopDateTime, $dischargeDate)) {
							$loopDateTime = $dischargeDate;
							$isDischarge = true;
							$isFirstOrLast = 2;
						} else {
							if ($this->checkEqualDate($loopDateTime, date('Y-m-d', strtotime($firstBedInTime)))) {
								$loopDateTime = $firstBedInTime;
							} else {
								$loopDateTime = date('Y-m-d 12:00:00', strtotime($loopDateTime));
							}
						}


						$rateArray = $this->getBedRate($loopDateTime, $p_id, $firstBedInTime, $firstBedRate, $isFirstOrLast);

						if ($rateArray === null) {
							continue;
						}

						if ($isDischarge) {
							if ($rateArray->og_rate == $rateArray->rate) {
								$rateArray->datetime = date('Y-m-d 12:00:00', strtotime($loopDateTime));
								array_push($bedArray, $rateArray);
								$rateArrayCopy = clone $rateArray;
								$rateArrayCopy->datetime = $dischargeDate;
								$rateArrayCopy->rate = $rateArrayCopy->og_rate / 2;
								array_push($bedArray, $rateArrayCopy);
							} else {
								array_push($bedArray, $rateArray);
							}

						} else {
							array_push($bedArray, $rateArray);
						}
						$firstBedInTime = $rateArray->startDateTime;
						$firstBedRate = $rateArray->og_rate;
					}
//				}
			}
		}
		return $bedArray;

	}

	function sameDayAdmitDischarge($dateTime, $patientId, $admissionDate, $dischargeDate, $firstBedRate)
	{
		$object = new stdClass();
		if ($this->getTime($admissionDate) > 1200 && $this->getTime($dischargeDate) > 1200) {
			// both date in same section
			$object->admission = $this->getBedRate($dateTime, $patientId, $admissionDate, $firstBedRate, true);
			$object->discharge = null;
		} else {
			// differ section
			if ($this->getTime($admissionDate) < 1200 && $this->getTime($dischargeDate) < 1200) {
				$object->admission = null;
				$object->discharge = $this->getBedRate($dateTime, $patientId, $dischargeDate, $firstBedRate, true);
			} else {
				$object->admission = $this->getBedRate($dateTime, $patientId, $admissionDate, $firstBedRate, true);
				$object->discharge = $this->getBedRate($dateTime, $patientId, $dischargeDate, $firstBedRate, true);
			}


		}

		return $object;
	}

	function getFullDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate)
	{
		$loopEndDate = date('Y-m-d 12:00:00', strtotime('+24hours ' . $dateTime));

		$object = $this->getRateObject($patientId, $dateTime, $assignBedDateTime, $dateTime, $loopEndDate);
		if ($object->type == -1) {
			$object->rate = $firstBedRate;
			$object->og_rate = $firstBedRate;
		}
		return $object;
	}

	function getHalfDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate)
	{
		//$loopStartDate = date('Y-m-d 12:00:00', strtotime('-24hours ' . $dateTime));
		$loopEndDate = date('Y-m-d 12:00:00', strtotime($dateTime));
		$object = $this->getRateObject($patientId, $dateTime, $assignBedDateTime, $dateTime, $loopEndDate);

		if ($object->type == -1) {
			$object->rate = $firstBedRate / 2;
			$object->og_rate = $firstBedRate;
		} else {
			$object->rate = $object->rate / 2;
		}
		return $object;
	}

	function getBedRate($dateTime, $patientId, $assignBedDateTime, $firstBedRate, $isFirstOrLast = 3)
	{
		if ($isFirstOrLast !== 3) {
			if ($isFirstOrLast == 1) {
				if ($this->getTime($dateTime) >= 1200) {
					// full day
					//return $this->getFullDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate);
					return null;
				} else {
					//  half day

					return $this->getHalfDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate);
				}
			}
			if ($isFirstOrLast == 2) {
				if ($this->getTime($dateTime) >= 1200) {
					//  half day
					$loopEndDate = date('Y-m-d 12:00:00', strtotime($dateTime));
					$object = $this->getRateObject($patientId, $dateTime, $assignBedDateTime, $dateTime, $loopEndDate);
					if ($object->type == -1) {
						$object->rate = $firstBedRate;
						$object->og_rate = $firstBedRate;
					}
					return $object;
					return $this->getHalfDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate);
				} else {
					// full day

					return $this->getFullDay($dateTime, $patientId, $assignBedDateTime, $firstBedRate);
				}

			}
		} else {

			$loopEndDate = date('Y-m-d 12:00:00', strtotime('+24hours ' . $dateTime));
			$object = $this->getRateObject($patientId, $dateTime, $assignBedDateTime, $dateTime, $loopEndDate);
			if ($object->type == -1) {
				$object->rate = $firstBedRate;
				$object->og_rate = $firstBedRate;
			}
			return $object;
		}
	}

	function getRateObject($patientId, $dateTime, $lastBedAssignInTime, $loopStartDate, $loopEndDate)
	{
		$rateObject = new stdClass();
		$rateObject->startPoint = $loopStartDate;
		$rateObject->endPoint = $loopEndDate;
		$bed_history_table = $this->session->user_session->patient_bed_history_table;
		$bed_table = $this->session->user_session->hospital_bed_table;
		$branch_id = $this->session->user_session->branch_id;

		$bedResultObject = $this->db->select(
			array('inTime', "'" . $loopStartDate . "' as loopStartDate", "'" . $loopEndDate . "' as loopEndDate",
				'(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from ' . $bed_table . ' b where b.id=h.bed_id) as service_details'))
			->where(array("patient_id" => $patientId, "branch_id" => $branch_id))
			->where("inTime between '" . $lastBedAssignInTime . "' and '" . $loopEndDate . "'")
			->order_by("inTime", "asc")
			->get($bed_history_table . ' h ')->result();

		if (count($bedResultObject) == 1) {
			$rate_string = explode('|', $bedResultObject[0]->service_details);
			$rateObject->rate = (double)$rate_string[0];
			$rateObject->type = $rate_string[1];
			$rateObject->service_name = $rate_string[2];
			$rateObject->datetime = $dateTime;
			$rateObject->startDateTime = $bedResultObject[0]->inTime;
			$rateObject->og_rate = (double)$rate_string[0];
		} else {
			if (count($bedResultObject) > 0) {
				$startPoint = $loopStartDate;
				$bedArray = array();

				$bedTypeArray = array();
				foreach ($bedResultObject as $index => $bed) {
					$rate_string1 = explode('|', $bed->service_details);
					$objectCopy = new stdClass();
					$objectCopy->object = $bed;
					if ($index != count($bedResultObject) - 1) {
						$nextObject = $bedResultObject[$index + 1];
						$objectCopy->endDateTime = $nextObject->inTime;
					} else {
						$objectCopy->endDateTime = $loopEndDate;
					}
					$bedTypeArray[$rate_string1[1]][] = $objectCopy;
				}
				$loopEndDateCopy = $loopEndDate;
				foreach ($bedTypeArray as $bedItems) {
					$loopEndDate = $loopEndDateCopy;
					foreach ($bedItems as $index => $combo) {

						$timeObject = new stdClass();
						$bed = $combo->object;
						$timeObject->copyEndDate = $loopEndDateCopy;
						$rate_string = explode('|', $bed->service_details);
						if ($this->checkEqualDate($startPoint, $bed->inTime)) {
							$startPoint = date('Y-m-d 12:00:00', strtotime('-24hours ' . $loopEndDate));
							$timeObject->ifsection = $startPoint;
							$timeObject->startDateTime = $loopEndDate;
							if ($combo->endDateTime != null) {
								$loopEndDate = $combo->endDateTime;
								$timeObject->startDateTime = $bed->inTime;
							}
							$hours = $this->getHoursBetweenDates($startPoint, $loopEndDate);
							$timeObject->spoint = $startPoint;
							$timeObject->epoint = $loopEndDate;
							$timeObject->hours = $hours;
							$timeObject->rate = (double)$rate_string[0];
							$timeObject->og_rate = (double)$rate_string[0];
							$timeObject->service_name = $rate_string[2];
							$timeObject->type = $rate_string[1];
							$timeObject->hoursArray = array(array("sp" => $timeObject->spoint, "ep" => $timeObject->epoint, "hours" => $timeObject->hours));
							$bedArray[$rate_string[1]] = $timeObject;
							continue;
						} else {
//							if(date('Y-m-d H:i:s',strtotime($startPoint)) < date('Y-m-d H:i:s',strtotime($bed->inTime))){
								$startPoint = $bed->inTime;
//							}


							$timeObject->elsesection = $startPoint;

						}

						if ($combo->endDateTime != null) {
							$loopEndDate = $combo->endDateTime;
							$timeObject->startDateTime = $bed->inTime;
						} else {
//							$timeObject->startDateTime = $loopEndDate;
							$timeObject->startDateTime = $bed->inTime;
							$loopEndDate = $loopEndDateCopy;
						}

						$hours = $this->getHoursBetweenDates($startPoint, $loopEndDate);

						$timeObject->spoint = $startPoint;
						$timeObject->epoint = $loopEndDate;

						$timeObject->hours = $hours;
						$timeObject->rate = (double)$rate_string[0];
						$timeObject->og_rate = (double)$rate_string[0];
						$timeObject->service_name = $rate_string[2];
						$timeObject->type = $rate_string[1];

						if (array_key_exists($rate_string[1], $bedArray)) {
							$existingTimeObject = $bedArray[$rate_string[1]];
							$hArray = $existingTimeObject->hoursArray;
							if (property_exists($timeObject, 'ifsection')) {
								$existingTimeObject->ifsection = $timeObject->ifsection;
								$existingTimeObject->overwrite = 2;
							}

							if (property_exists($timeObject, 'elsesection')) {
								$existingTimeObject->elsesection = $timeObject->elsesection;
								$existingTimeObject->overwrite = 1;
							}

							array_push($hArray, array("sp" => $timeObject->spoint, "ep" => $timeObject->epoint, "hours" => $timeObject->hours));
							$timeObject->hoursArray = $hArray;
							$totalHours = $existingTimeObject->hours + $timeObject->hours;
							$timeObject->hours = $totalHours;

							$bedArray[$rate_string[1]] = $timeObject;
						} else {
							$timeObject->hoursArray = array(array("sp" => $timeObject->spoint, "ep" => $timeObject->epoint, "hours" => $timeObject->hours));
							$bedArray[$rate_string[1]] = $timeObject;
						}
					}
				}

				$maxRateObject = $this->maxHours($bedArray);
				$rateObject->rate = $maxRateObject->rate;
				$rateObject->type = $maxRateObject->type;
				$rateObject->startDateTime = $maxRateObject->startDateTime;
				$rateObject->datetime = $dateTime;
				$rateObject->og_rate = $maxRateObject->og_rate;
				$rateObject->bedTypeArray = $bedTypeArray;
				$rateObject->bedRateArray = $bedArray;
				$rateObject->service_name = $maxRateObject->service_name;
			} else {

				$firstBedResultObject = $this->db->select(
					array('inTime',
						'(select (select group_concat(rate,"|",service_id,"|",service_description) from service_master where service_id=b.bed_type) from ' . $bed_table . ' b where b.id=h.bed_id) as service_details'))
					->where(array("patient_id" => $patientId, "branch_id" => $branch_id))
					->order_by("inTime", "asc")
					->get($bed_history_table . ' h ')->row();
				if (!is_null($firstBedResultObject)) {
					$rate_string = explode('|', $firstBedResultObject->service_details);
					$rateObject->rate = (double)$rate_string[0];
					$rateObject->og_rate = (double)$rate_string[0];
					$rateObject->type = $rate_string[1];
					$rateObject->service_name = $rate_string[2];
				} else {
					$rateObject->type = -1;
				}
				$rateObject->startDateTime = $loopStartDate;
				$rateObject->datetime = $dateTime;
			}
		}
		return $rateObject;
	}

	function maxHours($array)
	{
		return array_reduce($array, function ($a, $b) {
			return $a ? ($a->hours > $b->hours ? $a : $b) : $b;
		});
	}

	function getHoursBetweenDates($startDate, $endDate)
	{
		$t1 = strtotime($startDate);
		$t2 = strtotime($endDate);
		$diff = $t1 - $t2;
//		return abs($diff) / (60 * 60);
		if($diff < 0){
			return abs($diff) / (60 * 60);
		}else{
			return 0;
		}


	}

	function checkShiftedRate($loopDate, $bedAssignDate, $shiftedIndex)
	{
		$value = false;
		if (!$this->checkEqualDate($loopDate, $bedAssignDate[$shiftedIndex - 1])) {

		} else {
			$value = $this->checkShiftedRate($loopDate, $bedAssignDate, $shiftedIndex - 1);
		}
		return $value;
	}

	function checkBelongToDates($startDate, $endDate, $checkDate)
	{
		// Convert to timestamp
		$start = strtotime($startDate);
		$end = strtotime($endDate);
		$check = strtotime($checkDate);
		return (($start <= $check) && ($check <= $end));
	}

	function getTime($dateTime)
	{
		return (int)date('Hi', strtotime($dateTime));
	}

	function checkEqualDate($date1, $date2)
	{
		return strtotime($date1) == strtotime($date2);
	}


	function getRateData($p_id)
	{
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$billing_transaction = $this->session->user_session->billing_transaction;
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;
		$patient_bed_history_table = $this->session->user_session->patient_bed_history_table;

		//add doctor Consulatation
		$rate = array();
		$intime = array();
		//$dr_con=$this->add_doctor_consultation($p_id);
		//add bed mangement
		$sql = "select inTime,
		(select bed_type from " . $hospital_bed_table . " b where b.id=h.bed_id) as service_id
		from " . $patient_bed_history_table . " h where patient_id='" . $p_id . "' and branch_id = '" . $this->session->user_session->branch_id . "'";
		$query = $this->db->query($sql);

		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$service_id = $row->service_id;
				$get_service_charges = $this->Assignbed_model->get_service_charges($service_id);
				if ($get_service_charges != false) {
					$rate[] = $get_service_charges;
					$intime[] = $row->inTime;
				}
			}
		}


		return array($rate, $intime);
	}

	function getDatesRange1($date1, $date2, $format = 'Y-m-d')
	{
		$dates = array();
		$datelast = $date2;
		$current = strtotime(date('Y-m-d', strtotime($date1)));
		$date2 = strtotime(date('Y-m-d', strtotime($date2)));
		//  $date2 = strtotime($date2);

		while ($current <= $date2) {
			$dates[] = date($format, $current);
			$current = strtotime('+24hours', $current);
		}
		return $dates;
	}

	function getDatesRange($date1,$date2){
		//$date1='02-06-2021 14:09:00';$date2='02-06-2021 16:29:00';
		$dates = array();
		$startHours=(int)date('Hi', strtotime($date1));
		$startSection=false;
		if($startHours > 1200){
			$startDate = strtotime(date('Y-m-d 12:00:00', strtotime($date1)));
			$startSection=true;
		}else{
			$endDate = strtotime(date('Y-m-d 12:00:00', strtotime($date1)));
			$startDate = strtotime(date('Y-m-d 12:00:00', strtotime('-24hours',$endDate)));
		}
		$endHours=(int)date('Hi', strtotime($date2));
		$endSection=false;
		if($endHours > 1200){
			$endDate = strtotime(date('Y-m-d H:i:s', strtotime($date2)));
			$endSection=true;
		}else{
			$endDate = strtotime(date('Y-m-d 12:00:00', strtotime($date2)));
		}


		while ($startDate <= $endDate) {
			$dates[] = date('Y-m-d H:i:s', $startDate);
			$startDate = strtotime('+24hours', $startDate);
		}

		if($endSection){
			$dates[count($dates)-1]=$date2;
		}
		if($startSection){
			if(count($dates)!=1){
				$dates[0]=$date1;
			}
		}
		if(date("Y-m-d",strtotime($date1))==date("Y-m-d",strtotime($date2))){
			if ($this->getTime($date1) > 1200 && $this->getTime($date2) > 1200) {
				$dates=array(date("Y-m-d H:i:s",strtotime($date2)));
			}else if($this->getTime($date1) < 1200 && $this->getTime($date2) < 1200){
				$dates=array(date("Y-m-d H:i:s",strtotime($date2)));
			}else{
				$dates=array(date("Y-m-d H:i:s",strtotime($date1)),date("Y-m-d H:i:s",strtotime($date2)));
			}
		}

//		var_dump($dates);
		return $dates;
	}

	function UploadAllPatientBill(){
		$branch_id = $this->session->user_session->branch_id;
		$tableName = $this->session->user_session->patient_table;

		$query=$this->db->query("select id from ".$tableName." where branch_id=".$branch_id."
		AND discharge_date is not null AND discharge_date != '0000-00-00 00:00:00'");
		$res=array();
		if($this->db->affected_rows() > 0)
		{

			$result=$query->result();
			foreach($result as $row){
				$patientId=$row->id;
				$result1 = $this->assignBedCalculationAll($patientId);
				$res[$patientId]=$result1;
			}
		}
		//for 50 patients it takes 1.2 minutes.

		log_message("error",json_encode($res));
		echo json_encode($res);
	}

	public function assignBedCalculationAll($p_id)
	{


		if (!is_null($p_id)) {
			try {
				$billing_transaction = $this->session->user_session->billing_transaction;
				$branch_id = $this->session->user_session->branch_id;

				$this->db->trans_start();
				//add doctor Consulatation
				$this->add_doctor_consultation($p_id);
				// delete existing bed details from order room and billing transaction
				$this->db->delete("oder_room_table", array("patient_id" => $p_id));
				$this->db->delete($billing_transaction, array("patient_id" => $p_id, "type" => 1));

				// get all bed rate and duration details
				$bedCalculationArray = $this->calculateAssignBed($p_id);
				$response["object"] = $bedCalculationArray;
				$oid = $this->generate_order($p_id);

				foreach ($bedCalculationArray as $object) {
					if ($object->type != -1) {
						$roomOrder = array(
							"service_id" => $object->type,
							"patient_id" => $p_id,
							"order_id" => $oid,
							"price" => $object->rate,
							"branch_id" => $branch_id,
							"service_name" => $object->service_name,
							"date_service" => $object->datetime,
						);
						$billingData = array(
							"service_id" => $object->type,
							"patient_id" => $p_id,
							"rate" => $object->rate,
							"total" => $object->rate,
							"final_amount" => $object->rate,
							"order_id" => $oid,
							"service_desc" => $object->service_name,
							"date_service" => $object->datetime,
							"unit" => 1,
							"type" => 1,
							"branch_id" => $branch_id,
							"confirm" => 1

						);
						$insert = $this->db->insert('oder_room_table', $roomOrder);
						if ($insert == true) {
							$this->db->insert($billing_transaction, $billingData);
						}
					}
				}

				// check all transaction of done with success.
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
			} catch (Exception $exc) {
				$this->db->trans_rollback();
				$this->db->trans_complete();
				log_message('error', $exc->getMessage());
				$result = FALSE;
			}

			if ($result) {
				$response["status"] = 200;
				$response["body"] = "Added Successfully.";
			} else {
				$response["status"] = 201;
				$response["body"] = "Something Went wrong.";
			}
		} else {
			$response["status"] = 202;
			$response["body"] = "No data available for this patient.";
		}
		return $response;
		//echo json_encode($response);
	}
}
