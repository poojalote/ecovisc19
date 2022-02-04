<?php

require_once 'HexaController.php';

class PathologyOrderController extends HexaController
{


	/**
	 * PathologyOrderController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	function labReport()
	{
		$this->load->view("LabReport/view_lab_report", array("title" => "Lab Report"));
	}

	function loadReports()
	{
		$validObject = $this->is_parameter(array("patient_id"));
		$reportArray = array();
		if ($validObject->status) {

			$patient_id = $validObject->param->patient_id;
			$patient_id = 'N' . str_pad($patient_id, '9', '0', STR_PAD_LEFT);
			$resultObject = $this->db->select("VisitDate,ordertest,ParameterName,result,unit,ref_range")
				->where(array("Patient_number" => $patient_id, "branch_id" => $this->session->user_session->branch_id))
				->order_by("str_to_date(VisitDate,'%M %d %Y %H') desc")
				->get("excel_structure_data")->result();

			$query = $this->db->last_query();
			if (is_array($resultObject)) {

				foreach ($resultObject as $object) {
					$object = array(
						$object->VisitDate,
						$object->ordertest,
						$object->ParameterName,
						$object->result,
						$object->unit,
						$object->ref_range,
					);
					array_push($reportArray, $object);
				}
			}
			$results = array(
				"draw" => 1,
				"recordsTotal" => count($reportArray),
				"recordsFiltered" => count($reportArray),
				"data" => $reportArray,
			);
			$results["query"] = $query;
		} else {
			$results = array(
				"draw" => 1,
				"recordsTotal" => count($reportArray),
				"recordsFiltered" => count($reportArray),
				"data" => $reportArray,
			);
		}


		echo json_encode($results);
	}


	public function getlabreportFrequentlyUsed()
	{
		$p_id = $this->input->post_get('p_id');
		$patient_id = 'N' . str_pad($p_id, '9', '0', STR_PAD_LEFT);
		//$patient_id="N000000361";
		$date_arra = array();
		//
		$q2 = $this->db->query("select  *, (select para_name from labparameter_table where para_id collate utf8mb4_general_ci = ParameterId)
		as para_name from excel_structure_data where patient_id='$p_id' and ParameterId collate 
	utf8mb4_general_ci in (select para_id from labparameter_table)   order by VisitDate desc ");
		$d = "";
		$dateA = array();
		$parameter_name = array();
		if ($this->db->affected_rows() > 0) {
			$res1 = $q2->result();
			foreach ($res1 as $row) {
				$date_arra[date('Y-m-d', strtotime($row->VisitDate))][] = $row;
				$parameter_name[$row->para_name] = $row;
				//
			}
		}

		$dateA = array_keys($date_arra);
		$response['before sort'] = $dateA;
		$response['sort'] = $date_arra;
		usort($dateA, function ($time1, $time2) {
			if (strtotime($time1) < strtotime($time2))
				return 1;
			else if (strtotime($time1) > strtotime($time2))
				return -1;
			else
				return 0;
		});
		$response['after sort'] = $dateA;
		for ($k = 0; $k < count($dateA); $k++) {
			$d .= "<th>" . $dateA[$k] . "</th>";
		}
		$data = "";
		/* $query=$this->db->query("select * from labparameter_table");
		
		if($this->db->affected_rows() > 0){
			$result=$query->result(); */
		$data .= "<table class='table-bordered table'><thead>
			<tr>
			<th>Parameter Name</th>
			<th>Unit</th>
			" . $d . "
			</tr>
			</thead><tbody>";
		foreach ($parameter_name as $ind => $para_name) {
			$data_td = "";
			foreach ($dateA as $index) {
				$row1 = $date_arra[$index];
				$set = false;
				foreach ($row1 as $row) {
					if ($ind == $row->para_name) {
						$dt = date('M d Y', strtotime($index));
						$data_td .= "
							<td>" . $row->result . "</td>
							";
						$set = true;
						break;
					}
				}
				if (!$set) {
					$data_td .= "<td>-</td>";

				}

			}
			$data .= "
				<tr>
				<td>" . $ind . "</td>
				<td>" . $para_name->unit . "</td>
				" . $data_td . "
				</tr>
				";
		}


		$data .= "</tbody></table>";
		$response['status'] = 200;
		$response['data'] = $data;
		/* }else{
			$response['status']=201;
			$response['data']=$data;
		} */
		echo json_encode($response);
	}

	public function getRadiologyData()
	{
		$p_id = $this->input->post_get('p_id');
		$branch_id = $this->session->user_session->branch_id;
		$query = $this->db->query("select * from service_order where patient_id='$p_id' and branch_id='$branch_id' AND service_category='RADIOLOGY' group by service_id ");
		// print_r($this->db->last_query());
		$data = "";
		$data .= "<table class='table table-bordered' id='rad_table'><thead>
		<tr>
		<th>Service detail</th>
		<th>Date</th>
		<th>File</th>
		<th>Remark</th>
		<th>Normal Status</th>
		</tr>
		</thead><tbody>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {

				$ser_det = $row->service_id;
				$query2 = $this->db->query("select * from service_order where patient_id='$p_id' AND service_category='RADIOLOGY' AND service_id='$ser_det' ");
				if ($this->db->affected_rows() > 0) {
					$res = $query2->result();
					$cnt = count($res);
					$data .= "

			<tr>
			<td rowspan='" . $cnt . "'>" . $row->service_detail . "</td>";
					foreach ($res as $row1) {
						$btn = "-";
						if ($row1->file_upload != null && $row1->file_upload != "") {
							$btn = '
						 <button type="button" class="btn btn-link" onclick="radiologyDownloadButtons(\'' . $row1->file_upload . '\')"><i class="fa fa-download"></i></button>
						';
						}

						$data .= "
			
			<td>" . $row1->order_date . "</td>
			<td>" . $btn . "</td>
			<td>" . $row1->Remark . "</td>
			<td>" . $row1->normal_status . "</td>
			
			</tr>
			";
					}

				}
			}
			$data .= "
		</tbody>
		</table>
		";
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = $data;
		}
		echo json_encode($response);
	}

	public function getPathologyTableData()
	{
//
		$p_id = $this->input->post_get('p_id');
		$branch_id = $this->session->user_session->branch_id;
//		SELECT ps.*,(select GROUP_CONCAT(so.service_detail) as service_detail from service_order so where FIND_IN_SET(so.id, ps.service_ids)) as service_names FROM pathology_service_transaction_table ps where ps.patient_id = "1";
//		$query=$this->db->query("SELECT ps.*, GROUP_CONCAT(so.service_detail) as service_detail FROM pathology_service_transaction_table ps, service_order so WHERE FIND_IN_SET(so.id, ps.service_ids) AND ps.patient_id = ".$p_id);
		$query = $this->db->query("SELECT ps.*,(case when ps.type=2 then (select lt.name from lab_master_test lt where lt.id=ps.service_ids and lt.branch_id=ps.branch_id order by id desc limit 1) else (select GROUP_CONCAT(so.service_detail) from service_order so where FIND_IN_SET(so.id, ps.service_ids)) end) as service_names FROM pathology_service_transaction_table ps where ps.status=1 and ps.patient_id = " . $p_id . " and branch_id=" . $branch_id);
		// print_r($this->db->last_query());
		$data = "";

		$data .= "<table class='table table-bordered' id='path_table'><thead>
		<tr>
		<th>Service detail</th>
		<th>File</th>
		</tr>
		</thead><tbody>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$btn = "";
				$cnt = count($result);

				$data .= "

			<tr>
			<td>" . $row->service_names . "</td>";
				if ($row->file_uploaded != null && $row->file_uploaded != "") {
					$btnArr = explode(',', $row->file_uploaded);
//					foreach ($btnArr as $btnRow){
					$btn .= '
						 <button type="button" class="btn btn-link" onclick="radiologyDownloadButtons(\'' . $row->file_uploaded . '\')"><i class="fa fa-download"></i></button>
						<button type="button" class="btn btn-link" onclick="UpdatePathologyFile(\'' . $row->id . '\',\'' . $p_id . '\')"><i class="fa fa-pencil-alt"></i></button>
						';
//					}
				} else {
					$btn .= "-";
				}
				$data .= "<td>" . $btn . "</td>
			</tr>
			";
			}
		}
		$data .= "
		</tbody>
		</table>";
		$response['status'] = 200;
		$response['data'] = $data;

		echo json_encode($response);
	}

	public function getOtherServiceTableData()
	{
		$p_id = $this->input->post_get('p_id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$query = $this->db->query("select * from service_order where branch_id=" . $branch_id . " AND company_id=" . $company_id . " AND patient_id=" . $p_id . " AND service_category not in ('ACCOMM','PATHOLOGY','RADIOLOGY') group by service_id ");

		$data = "";
		$data .= "<table class='table table-bordered' id='otherservice_table'><thead>
		<tr>
		<th>Service detail</th>
		<th>Date</th>
		<th>File</th>
		<th>Remark</th>
		<th>Normal Status</th>
		</tr>
		</thead><tbody>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {

				$ser_det = $row->service_id;
				$query2 = $this->db->query("select * from service_order where branch_id=" . $branch_id . " AND company_id=" . $company_id . " AND patient_id=" . $p_id . " AND service_category not in ('ACCOMM','PATHOLOGY','RADIOLOGY') AND service_id='" . $ser_det . "' ");
				if ($this->db->affected_rows() > 0) {
					$res = $query2->result();
					$cnt = count($res);
					$data .= "

			<tr>
			<td rowspan='" . $cnt . "'>" . $row->service_detail . "</td>";
					foreach ($res as $row1) {
						$btn = "-";
						if ($row1->file_upload != null && $row1->file_upload != "") {
							$btn = '
						 <button type="button" class="btn btn-link" onclick="radiologyDownloadButtons(\'' . $row1->file_upload . '\')"><i class="fa fa-download"></i></button>
						';
						}
						if ($row1->Remark != null && $row1->Remark) {
							$remark = $row1->Remark;
						} else {
							$remark = "-";
						}
						if ($row1->normal_status != null && $row1->normal_status) {
							$normal_status = $row1->normal_status;
						} else {
							$normal_status = "-";
						}

						$data .= "
			
			<td>" . $row1->order_date . "</td>
			<td>" . $btn . "</td>
			<td>" . $remark . "</td>
			<td>" . $normal_status . "</td>
			
			</tr>
			";
					}

				}
			}
			$data .= "
		</tbody>
		</table>
		";
			$response['status'] = 200;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['data'] = $data;
		}
		echo json_encode($response);
	}

	public function getLabReportOrderTestData()
	{
		$validObject = $this->is_parameter(array("patient_id"));

		if ($validObject->status) {
			$branch_id = $this->session->user_session->branch_id;
			$patient_id = $validObject->param->patient_id;
			$patient_id = 'N' . str_pad($patient_id, '9', '0', STR_PAD_LEFT);
			$where = array('Patient_number' => $patient_id,
				'branch_id' => $branch_id,
				'result REGEXP' => "^[0-9]+\\.?[0-9]*$");
			$resultObject = $this->db->select("id,VisitDate,OrderTest,ParameterName,result,unit,ref_range")
				->where($where)
				->order_by("str_to_date(VisitDate,'%M %d %Y %H') desc")
				->group_by('OrderTest')
				->get("excel_structure_data")->result();

			$query = $this->db->last_query();
			// print_r($query);exit();
			$data = "<option selected disabled>Select Order Test</option>";
			if (is_array($resultObject)) {

				foreach ($resultObject as $object) {
					$data .= "<option value='" . $object->OrderTest . "'>" . $object->OrderTest . "</option>";
				}
				// print_r($resultObject);exit();
			}

			$response['status'] = 200;
			$response["query"] = $query;
			$response['data'] = $data;
		} else {
			$response['status'] = 201;
			$response['body'] = "Parameter missing";
		}


		echo json_encode($response);
	}

	public function getLabReportOrderTestParaData()
	{
		$validObject = $this->is_parameter(array("patient_id", "order_test"));
		if ($validObject->status) {
			$branch_id = $this->session->user_session->branch_id;
			$patient_id = $validObject->param->patient_id;
			$patient_id = 'N' . str_pad($patient_id, '9', '0', STR_PAD_LEFT);
			$order_test = $validObject->param->order_test;

			$labelArray = array();
			$dataArray = array();
			$transArray = array();
			$data = "";
			$optionsValue = array();

			$where = array('Patient_number' => $patient_id,
				'OrderTest' => $order_test,
				'branch_id' => $branch_id,
				'result REGEXP' => "^[0-9]+\\.?[0-9]*$");
			$resultlabelObject = $this->db->select("id,VisitDate,OrderTest,ParameterName,result,unit,ref_range,ParameterId")
				->where($where)
				->order_by("str_to_date(VisitDate,'%M %d %Y %H') desc")
				->group_by('ParameterId')
				->get("excel_structure_data")->result();
			// print_r($this->db->last_query());exit();
			if (count($resultlabelObject) > 0) {
				foreach ($resultlabelObject as $column) {
					array_push($labelArray, $column->ParameterName);
				}
				// print_r($labelArray);exit();
				$resultDataObject = $this->db->select("id,VisitDate,OrderTest,ParameterName,result,unit,ref_range,ParameterId")
					->where($where)
					->order_by("str_to_date(VisitDate,'%M %d %Y %H') desc")
					->get("excel_structure_data")->result();
				// print_r($this->db->last_query());exit();
				if (count($resultDataObject) > 0) {
					foreach ($resultDataObject as $recordIndex => $record) {
						// print_r($record);exit();

						$row = (array)$record;
						if (is_numeric($record->result)) {
							foreach ($resultlabelObject as $column) {
								// print_r($row);exit();
								// $value = $record->result;
								if ($record->ParameterId == $column->ParameterId) {
									$dataArray[$column->ParameterName][date('jS M H:i:a', strtotime($row['VisitDate']))] = $record->result;
									$transArray[$column->ParameterName][date('jS M H:i:a', strtotime($row['VisitDate']))] = $record->VisitDate;
									// array_push($transArray, date('jS M H:i:a', strtotime($row['VisitDate'])));

								}

							}
						}


					}

				}
				// print_r($dataArray);exit();

			}

			$query = $this->db->last_query();
			$response['status'] = 200;
			$response["query"] = $query;
			$response["label"] = $labelArray;
			$response["trans"] = $transArray;
			$response["data"] = $dataArray;
		} else {
			$response['status'] = 201;
			$response['body'] = "Parameter missing";
		}


		echo json_encode($response);

	}

	public function getLabPathologyTableData()
	{
//
		$p_id = $this->input->post_get('p_id');
		$branch_id = $this->session->user_session->branch_id;
//		SELECT ps.*,(select GROUP_CONCAT(so.service_detail) as service_detail from service_order so where FIND_IN_SET(so.id, ps.service_ids)) as service_names FROM pathology_service_transaction_table ps where ps.patient_id = "1";
//		$query=$this->db->query("SELECT ps.*, GROUP_CONCAT(so.service_detail) as service_detail FROM pathology_service_transaction_table ps, service_order so WHERE FIND_IN_SET(so.id, ps.service_ids) AND ps.patient_id = ".$p_id);
		$query = $this->db->query("SELECT ps.*,(case when ps.type=2 then (case when cast(ps.service_ids As UNSIGNED)=0 then
 (select sm.service_description from service_master sm where sm.service_id=ps.service_ids and sm.branch_id=ps.branch_id) else 
 (select lmt.name from lab_master_test lmt where lmt.id=ps.service_ids and lmt.branch_id=ps.branch_id) end) else
 (select GROUP_CONCAT(so.service_detail) from service_order so where so.branch_id=ps.branch_id and FIND_IN_SET(so.id, ps.service_ids)) end) as service_names FROM pathology_service_transaction_table ps where ps.lab_patient_ext_id = " . $p_id . " and branch_id=" . $branch_id);

//		print_r($this->db->last_query());exit();
		$data = "";

		$data .= "<table class='table table-bordered' id='path_table' style='font-size:15px;'><thead>
		<tr>
		<th>Service detail</th>
		<th>File</th>
		</tr>
		</thead><tbody>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$btn = "";
				$cnt = count($result);

				$data .= "

			<tr>
			<td>" . $row->service_names . "</td>";
				if ($row->file_uploaded != null && $row->file_uploaded != "") {
					$btnArr = explode(',', $row->file_uploaded);
//					foreach ($btnArr as $btnRow){
					$btn .= '
						 <button type="button" class="btn btn-link" onclick="radiologyDownloadButtons(\'' . $row->file_uploaded . '\')"><i class="fa fa-download"></i></button>
						';
//					}
				} else {
					$btn .= "-";
				}
				$data .= "<td>" . $btn . "</td>
			</tr>
			";
			}
		}
		$data .= "
		</tbody>
		</table>";
		$response['status'] = 200;
		$response['data'] = $data;

		echo json_encode($response);
	}


	public function updateserviceOrderBillingInfo()
	{
		if (!is_null($this->input->post('pathology_id')) && !is_null($this->input->post("patient_id"))) {
			$pathology_id = $this->input->post('pathology_id');
			$patient_id = $this->input->post('patient_id');
			try {
				$this->db->trans_start();
				$name_input = "service_file";
				$upload_path = "uploads";
				$combination = 2;
				$result = $this->upload_file($upload_path, $name_input, $combination);
				if ($result->status) {
					if ($result->body[0] == "uploads/") {
						$input_data = "";
					} else {
						$input_data = $result->body;
					}
				} else {
					$input_data = "";
				}
				if ($input_data != "") {
					if (count($input_data) > 1) {
						$input_data = implode(',', $input_data);
					} else {
						$input_data = $input_data[0];
					}
				} else {
					$input_data = "";
				}
				$this->db->where('id', $pathology_id)->set('file_uploaded', $input_data)->update('pathology_service_transaction_table');

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$response['status'] = 201;
					$response['body'] = "Update Failed";
				} else {
					$this->db->trans_commit();
					$response['status'] = 200;
					$response['body'] = "File Updated Successfully";
				}
			} catch (Exception $exception) {
				$this->db->trans_rollback();
				$response['status'] = 201;
				$response['body'] = "Update Failed";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}
}
