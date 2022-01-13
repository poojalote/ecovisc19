<?php

require_once 'HexaController.php';

/**
 * @property  User User
 */
class ConsumableOrderController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('ConsumableOrderModel');
		$this->load->model('Global_model');
	}

	/*
	 * login api
	 */

	public function index()
	{
		$this->load->view('CunsumableOrder/consumableOrder', array("title" => "Consumable Order"));
	}

	public function getConsumableGroup()
	{
		// print_r('hiiii');exit();
		$tableName = 'com_1_consumable_group';
		$resultObject = $this->ConsumableOrderModel->getSelectConsumableGroupData($tableName);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Consumable Group</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->id . '">' . $value->group_name . '</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}

	public function getComapanyUsers()
	{
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$tableName = 'users_master';
		$where = 'where branch_id="' . $branch_id . '" AND company_id="' . $company_id . '"';
		$resultObject = $this->ConsumableOrderModel->selectDataById($tableName, $where);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Order By</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->id . '">' . $value->name . '</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}

	public function add_consumable_order()
	{
		// print_r($this->input->post());exit();
		if (!is_null($this->input->post("hospital_name")) && !is_null($this->input->post("material_group_name")) && !is_null($this->input->post("hospital_order_by")) && !is_null($this->input->post("order_for_hospital")) && !is_null($this->input->post("patient_id"))) {
			$hospital_name = $this->input->post("hospital_name");
			$material_group_name = $this->input->post("material_group_name");
			$hospital_order_by = $this->input->post("hospital_order_by");
			$order_for_hospital = $this->input->post("order_for_hospital");
			$hospital_order_no = $this->input->post("order_for_hospital");
			$hospital_order_date = $this->input->post("order_for_hospital");
			$patient_id = $this->input->post("patient_id");

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableName = 'com_1_consumable_order_management';

			if (is_null($this->input->post("hospital_order_no")) && $this->input->post("hospital_order_no") == "") {
				$hospital_order_no = "";
			}
			if (is_null($this->input->post("hospital_order_date")) && $this->input->post("hospital_order_date") == "") {
				$hospital_order_date = date('Y-m-d H:i:s');
			}

			$hospital_order_date = date('Y-m-d H:i:s');

			$insert_data = array(
				'hospital_name' => $hospital_name,
				'order_for_hospital' => $order_for_hospital,
				"order_create_date" => $hospital_order_date,
				'material_group_id' => $material_group_name,
				'order_by_user' => $hospital_order_by,
				'status' => 0,
				'create_on' => date('Y-m-d H:i:s'),
				'create_by' => $user_id,
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'patient_id' => $patient_id
			);
			$insert = $this->db->insert($tableName, $insert_data);
			$insert_id = $this->db->insert_id();
			if ($insert == true) {
				$hospital_order_no = 'COS_' . $insert_id;
				$update_data = array('order_no' => $hospital_order_no);
				$this->db->where('id', $insert_id);
				$update = $this->db->update($tableName, $update_data);
				if ($update == true) {
					$response["status"] = 200;
					$response["order_no"] = $hospital_order_no;
					$response["order_date"] = date('d M Y g:i A', strtotime($hospital_order_date));
					$response["insert_id"] = $insert_id;
					$response["group_id"] = $material_group_name;
					$response["data"] = "Data inserted Successfully";
				} else {
					$response["status"] = 201;
					$response["data"] = "Data no inserted";
				}
			} else {
				$response["status"] = 201;
				$response["data"] = "Data no inserted";
			}

		} else {
			$response["status"] = 201;
			$response["data"] = "Something went wrong";
		}


		echo json_encode($response);
	}

	public function getConsumableDescription()
	{
		$group_id = $this->input->post("id");
		$tableName = 'com_1_consumable_group_table';

		$where='where group_no='.$group_id.'';
		$resultObject = $this->ConsumableOrderModel->selectDataById($tableName,$where);

		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Consumable Description</option>';

			foreach ($resultObject->data as $key => $value) {
				$option .= '<option value="' . $value->id . '">' . $value->material_description . '</option>';
			}
			$results['status'] = 200;
			$results['option'] = $option;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
		}
		echo json_encode($results);
	}

	public function getmaterialConsumableDescriptionOptions()
	{

		$validObject = $this->is_parameter(array("type", "searchTerm"));
		$response = array();
		if ($validObject->status) {

			$type = $validObject->param->type;
			$search = $validObject->param->searchTerm;
			$where = array();
			if ((int)$type != 0)
				$where = array("group_no" => (int)$type);
			$userData = $this->db->select(array("id", "material_description"))->where($where)->like("material_description", $search)->limit(10, 0)->get("com_1_consumable_group_table")->result();

			$response["last_query"] = $this->db->last_query();
			$data = array();
			if (count($userData) > 0) {
				foreach ($userData as $user) {
					array_push($data, array("id" => $user->id, "text" => $user->material_description));
				}
			}
			$response["body"] = $data;
		} else {
			$response["body"] = array();
		}
		echo json_encode($response);
	}


	public function getViewConsumableOrderData()
	{
		$hos_order_id = $this->input->post("hos_order_id");
		$group_id = $this->input->post("group_id");
		$receive = $this->input->post("receive");
		$grouptableName = 'com_1_consumable_group';
		$materialgrouptableName = 'com_1_consumable_group_table';
		$hospitalgrouptableName = 'com_1_consumable_order_management';
		$materialItemtableName = 'com_1_consumable_material_item_table';
		// $where='where group_no="'.$group_id.'"';
		// $where = array('group_no' => $group_id);


		$resultObject = $this->db->query('select gt.*,(select hg.receive_status from ' . $hospitalgrouptableName . ' hg where hg.id=' . $hos_order_id . ') as receive_status from ' . $grouptableName . ' gt where gt.id="' . $group_id . '"');
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($this->db->affected_rows() > 0) {
			$result = $resultObject->row();
			// print_r($resultObject);exit();

		// $resultObject2=$this->db->query('select mt.* from '.$materialgrouptableName.' mt where mt.group_no='.$group_id.'');
		// if ($this->db->affected_rows() > 0) {
		// 	$result2=$resultObject2->result();
		// 	$option = '<option selected disabled>Select Consumable Description</option>';
		// 	// $group_name='';
		// 	foreach ($result2 as $key => $value) {
		// 		// print_r($value);exit();
		// 		$option .= '<option value="' . $value->id . '">' . $value->material_description . '</option>';

		// 		}
		// 		$results['option'] = $option;
		// 	} else {
		// 		$results['option'] = $option;
		// 	}
			$results['status'] = 200;
			$results['group_name'] = $result->group_name;
			$results['receive_status'] = $result->receive_status;
		} else {
			$results['status'] = 201;
			$results['option'] = $option;
			$results['group_name'] = "";
			$results['receive_status'] = 0;
		}
		echo json_encode($results);
	}

	public function placeConsumableMaterialOrder()
	{
		$ValidationObject = $this->is_parameter(array("hospital_order_id","patient_id"));
		if ($ValidationObject->status) {
			$param = $ValidationObject->param;
			// print_r($param);exit();
			$user_id = $this->session->user_session->id;
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$hospital_order_id = $param->hospital_order_id;
			$patient_id = $param->patient_id;
			$itemArray[] = $this->input->post_get('itemArray');
			// print_r($itemArray);exit();
			$tableName1 = 'com_1_consumable_order_management';
			$tableName = "com_1_consumable_material_item_table";
			$dataArray1 = array();
			foreach ($itemArray as $prescriptionArraydata) {
				$dataArray = array();
				foreach ($prescriptionArraydata as $key => $value) {
					$dataArray = array('material_description_id' => $value['material_id'],
						'material_description' => $value['material_description'],
						'quantity' => $value['material_quantity'],
						'unit' => $value['material_unit'],
						'material_order_id' => $hospital_order_id,
						'branch_id' => $branch_id,
						'company_id' => $company_id,
						'patient_id' => $patient_id,
						'order_create_date'=> date('Y-m-d h:i:s')
					);
					$dataArray1[] = $dataArray;
				}
			}
			if (!empty($dataArray1)) {

				if ($this->ConsumableOrderModel->placeConsumableMaterialListOrder($tableName, $dataArray1)) {
					$update_data = array('status' => 1);
					$this->db->where('id', $hospital_order_id);
					$update = $this->db->update($tableName1, $update_data);
					$response["status"] = 200;
					$response["body"] = "Order place successfully";
				} else {
					$response["status"] = 201;
					$response["body"] = " Order not places";
				}
			} else {
				$response["status"] = 201;
				$response["body"] = " Order alredy places";
			}
		} else {
			$response["status"] = 201;
			$response["body"] = "Invalid Request";
		}
		echo json_encode($response);
	}

	public function getReceiveConsumableOrderHistoryTable()
	{
		if (!is_null($this->input->post('id'))) {
			$type = $this->input->post('id');
		} else {
			$type = 0;
		}
		$patient_id=$this->input->post('patient_id');

		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;

		$hospital_group_table = "com_1_consumable_group";
		$tableName = "com_1_consumable_order_management";
		// $select = array("*");
		$select = array("*", "(select hb.group_name from " . $hospital_group_table . " hb where hb.id=material_group_id) as group_name");
		// print_r($type);exit();
		if ($type == 1) {
			$where = array('receive_status' => 0,
							'status' => 1,
							'patient_id' => $patient_id,
							'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		} else if ($type == 2) {
			$where = array('receive_status' => 1,
							'status' => 1,
							'patient_id' => $patient_id,
							'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		} else {
			$where = array('status' => 1,
							'patient_id' => $patient_id,
							'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		}

		$order = array('create_on' => 'desc');
		$column_order = array('hospital_name');
		$column_search = array();

		$memData = $this->ConsumableOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

		$filterCount = $this->ConsumableOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->ConsumableOrderModel->countAll($tableName, $where);

		if (count($memData) > 0) {
			$tableRows = array();
			// print_r($memData);exit();
			foreach ($memData as $row) {

				$date=date('d M Y g:i A',strtotime($row->order_create_date));
				if($row->receive_on=='0000-00-00 00:00:00')
					{
						$receive_date="-";
					}
					else
					{
						$receive_date=date('d M Y g:i A',strtotime($row->receive_on));
					}
				// print_r($date);exit();
				$vendor_name = "-";
				$invoice_number = "-";
				if ($row->vendor_name != null && $row->vendor_name != "") {
					$vendor_name = $row->vendor_name;
				}
				if ($row->invoice_number != null && $row->invoice_number != "" && $row->invoice_number != 0) {
					$invoice_number = $row->invoice_number;
				}
				$tableRows[] = array(
					$row->order_no,
					$date,
					$row->group_name,
					$vendor_name,
					$invoice_number,
					$row->id,
					$row->receive_status,
					$row->material_group_id,
					$receive_date
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

	public function newConsumableMaterialOrderListForm()
	{
		// print_r($this);exit();
		if (!is_null($this->input->post("view_material_description")) && !is_null($this->input->post("view_material_quantity")) && !is_null($this->input->post("view_material_unit")) && !is_null($this->input->post("view_hospital_order_id"))) {
			$view_material_description = $this->input->post("view_material_description");
			$view_material_quantity = $this->input->post("view_material_quantity");
			$view_material_unit = $this->input->post("view_material_unit");
			$view_hospital_order_id = $this->input->post("view_hospital_order_id");

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;


			$view_material_description_name = '';
			$tableName = 'com_1_consumable_group_table';
			// $where = array('id' => $view_material_description);
			// print_r($tableName);exit();
			// $resultObject = $this->ConsumableOrderModel->getSelectMaterialDescription($tableName,$view_material_description);
			$resultObject = $this->db->query('select * from ' . $tableName . ' where id="' . $view_material_description . '"');
			if ($this->db->affected_rows() > 0) {
				$result = $resultObject->row();
				$view_material_description_name = $result->material_description;
			}
			// print($resultObject);exit();
			$tableName2 = 'com_1_consumable_material_item_table';
			$where1 = 'where material_description_id="' . $view_material_description . '" AND 	material_order_id="' . $view_hospital_order_id . '"';
			$resultObject = $this->ConsumableOrderModel->selectDataById($tableName2, $where1);
			if ($resultObject->totalCount <= 0) {
				$insert_data = array(
					'material_description_id' => $view_material_description,
					'material_description' => $view_material_description_name,
					"quantity" => $view_material_quantity,
					'unit' => $view_material_unit,
					'material_order_id' => $view_hospital_order_id,
					'branch_id' => $branch_id,
					'company_id' => $company_id
				);
				$insert = $this->db->insert($tableName2, $insert_data);
				$insert_id = $this->db->insert_id();
				if ($insert == true) {
					$response["status"] = 200;
					$response["hos_order_id"] = $view_hospital_order_id;
					$response["data"] = "Data inserted Successfully";
				} else {
					$response["status"] = 201;
					$response["data"] = "Data no inserted";
				}

			} else {
				$response["status"] = 201;
				$response["data"] = "Item already Added";
			}

		} else {
			$response["status"] = 201;
			$response["data"] = "Something went wrong";
		}


		echo json_encode($response);
	}

	public function getConsumableOrderMaterialListTable()
	{
		if (!is_null($this->input->post('order_id'))) {
			$order_id = $this->input->post('order_id');
		} else {
			$order_id = 0;
		}

		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;

		$hospital_order_table = "com_1_consumable_order_management";
		$tableName = " com_1_consumable_material_item_table";
		// $select = array("*");
		$select = array("*", "(select hb.receive_status from " . $hospital_order_table . " hb where hb.id=material_order_id) as receive_status");

		$where = array('material_order_id' => $order_id,'branch_id'=>$branch_id,'company_id'=>$company_id);
		$order = array();
		$column_order = array('material_description');
		$column_search = array('material_description');

		$memData = $this->ConsumableOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

		$filterCount = $this->ConsumableOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->ConsumableOrderModel->countAll($tableName, $where);

		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {

				$tableRows[] = array(
					$row->material_description,
					$row->quantity,
					$row->unit,
					$row->id,
					$row->receive_status,
					$row->material_description_id,
					$row->material_order_id,
					$row->received_material
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

	public function deleteConsumableOrderMaterialTranscation()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$tableName = "com_1_consumable_material_item_table";
			$where = array('id' => $id);
			$this->db->where($where);
			$delete = $this->db->delete($tableName);
			if ($delete == true) {
				$response['status'] = 200;
				$response['body'] = "Hospital order Item deleted Successfully";
			} else {
				$response['status'] = 201;
				$response['body'] = "Hospital order List not deleted";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function deleteConsumableOrderTranscation()
	{
		if (!is_null($this->input->post('id')) && !is_null($this->input->post('patient_id'))) {
			$id = $this->input->post('id');
			$patient_id = $this->input->post('patient_id');
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableName = "com_1_consumable_order_management";
			$where = array('id' => $id,'patient_id'=>$patient_id,'branch_id'=>$branch_id,'company_id'=>$company_id);
			$this->db->where($where);
			$delete = $this->db->delete($tableName);
			if ($delete == true) {
				$tableName2 = "com_1_consumable_material_item_table";
				$where2 = array('material_order_id' => $id);
				$this->db->where($where2);
				$delete2 = $this->db->delete($tableName2);

				if ($delete2 == true) {
					$response['status'] = 200;
					$response['body'] = "Hospital order deleted Successfully";
				} else {
					$response['status'] = 201;
					$response['body'] = "Hospital order not deleted";
				}
			} else {
				$response['status'] = 201;
				$response['body'] = "Hospital order not deleted";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Something went wrong";
		}
		echo json_encode($response);
	}

	public function receiveConsumableOrderForm()
	{
		if (!is_null($this->input->post("hos_order_invoice_no")) && !is_null($this->input->post("hos_vendor_name")) && !is_null($this->input->post("hos_invoice_amount")) && !is_null($this->input->post("patient_id"))) {
			$hos_order_invoice_no = $this->input->post("hos_order_invoice_no");
			$hos_invoice_amount = $this->input->post("hos_invoice_amount");
			$hos_vendor_name = $this->input->post("hos_vendor_name");
			$hospital_order_id = $this->input->post("receive_hospital_order_id");
			// print_r($hospital_order_id);exit();
			$patient_id = $this->input->post("patient_id");

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;

			$name_input = "hos_invoice_attachment";

			$upload_path = "uploads";
			$combination = 2;
			$result = $this->upload_file($upload_path, $name_input, $combination);
			// print_r($result);exit();
			if ($result->status) {
				if ($result->body[0] == "uploads/") {
					$input_data = "";
				} else {
					$input_data = $result->body[0];
				}

			} else {
				$input_data = "";
			}
			// $input_data="";

			$tableName = 'com_1_consumable_order_management';


			$update_data = array(
				'invoice_number' => $hos_order_invoice_no,
				'vendor_name' => $hos_vendor_name,
				"invoice_amount" => $hos_invoice_amount,
				'invoice_attactment' => $input_data,
				'receive_status' => 1,
				'receive_by' => $user_id,
				'receive_on' => date('Y-m-d h:i:s')
			);

			$where = array('id' => $hospital_order_id,'patient_id'=>$patient_id,'branch_id'=>$branch_id,'company_id'=>$company_id);
			$update = $this->ConsumableOrderModel->updateForm($tableName, $update_data, $where);
			// print_r($insert);exit();
			if ($update == true) {
				$response["status"] = 200;
				$response["hos_order_id"] = $hospital_order_id;
				$response["data"] = "Invoice Received Successfully";
			} else {
				$response["status"] = 201;
				$response["data"] = "Invoice not received";
			}


		} else {
			$response["status"] = 201;
			$response["data"] = "Something went wrong";
		}


		echo json_encode($response);
	}

}
