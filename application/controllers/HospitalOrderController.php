<?php

require_once 'HexaController.php';

/**
 * @property  User User
 * @property  HospitalOrderModel HospitalOrderModel
 */
class HospitalOrderController extends HexaController
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('HospitalOrderModel');
		$this->load->model('Global_model');
	}

	/*
	 * login api
	 */

	public function index()
	{
		$this->load->view('HospitalOrder/hospitalOrder', array("title" => "Hospital Order"));
	}

	public function hospital_order_management()
	{
		$this->load->view('HospitalOrder/leftsideBarHospitalOrder', array("title" => "Hospital Order"));
	}
	public function Consumable_Inventory()
	{
		$this->load->view('HospitalOrder/Consumable_Inventory', array("title" => "Hospital Order"));
	}																							  
 

	public function getMaterialGroup()
	{
		// print_r('hiiii');exit();
		$tableName = 'hospital_material_group';
		$resultObject = $this->HospitalOrderModel->getSelectMaterialGroupData($tableName);
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Material Group</option>';

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
		$resultObject = $this->HospitalOrderModel->selectDataById($tableName, $where);
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

	public function add_hospital_order()
	{
		// print_r($this);exit();
		if (!is_null($this->input->post("hospital_name")) && !is_null($this->input->post("material_group_name")) && !is_null($this->input->post("hospital_order_by")) && !is_null($this->input->post("order_for_hospital"))) {
			$hospital_name = $this->input->post("hospital_name");
			$department = $this->input->post("department");
			$material_group_name = $this->input->post("material_group_name");
			$hospital_order_by = $this->input->post("hospital_order_by");
			$order_for_hospital = $this->input->post("order_for_hospital");
			$hospital_order_no = $this->input->post("order_for_hospital");
			$hospital_order_date = $this->input->post("order_for_hospital");
			$ZoneID = $this->input->post("ZoneID");

			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableName = 'hospital_order_management';

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
				'department' => $department,
				"order_create_date" => $hospital_order_date,
				'material_group_id' => $material_group_name,
				'order_by_user' => $hospital_order_by,
				'status' => 0,
				'create_on' => date('Y-m-d H:i:s'),
				'create_by' => $user_id,
				'branch_id' => $branch_id,
				'zone_id' => $ZoneID,
				'company_id' => $company_id
			);
			$insert = $this->db->insert($tableName, $insert_data);
			$insert_id = $this->db->insert_id();
			if ($insert == true) {
				$hospital_order_no = 'HOS_' . $insert_id;
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

	public function getMaterialDescription()
	{
		$group_id = $this->input->post("id");
		$tableName = 'hospital_material_group_table';

		$where='where group_no='.$group_id.'';
		$resultObject = $this->HospitalOrderModel->selectDataById($tableName,$where);

		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($resultObject->totalCount > 0) {
			$option = '<option selected disabled>Select Material Description</option>';

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

	public function getMaterialDescriptionOptions()
	{

		$validObject = $this->is_parameter(array("type", "searchTerm"));
		$response = array();
		if ($validObject->status) {

			$type = (int)$validObject->param->type;
			$search = $validObject->param->searchTerm;
			$where = array();
			if ($type != 0){
				if($type==6){
					$userData = $this->db->select(array("id", "name as material_description"))->where($where)->like("name", $search)->limit(10, 0)->get("medicine_master")->result();
				}else{
					$where = array("group_no" => (int)$type);
					$userData = $this->db->select(array("id", "material_description"))->where($where)->like("material_description", $search)->limit(10, 0)->get("hospital_material_group_table")->result();
				}
			}else{
				$userData = $this->db->select(array("id", "material_description"))->where($where)->like("material_description", $search)->limit(10, 0)->get("hospital_material_group_table")->result();
			}



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

	public function getViewOrderData()
	{
		$hos_order_id = $this->input->post("hos_order_id");
		$group_id = $this->input->post("group_id");
		$receive = $this->input->post("receive");
		$grouptableName = 'hospital_material_group';
		$materialgrouptableName = 'hospital_material_group_table';
		$hospitalgrouptableName = 'hospital_order_management';
		$materialItemtableName = 'hospital_material_item_table';
		// $where='where group_no="'.$group_id.'"';
		// $where = array('group_no' => $group_id);


		$resultObject = $this->db->query('select gt.*,(select hg.receive_status from ' . $hospitalgrouptableName . ' hg where hg.id=' . $hos_order_id . ') as receive_status from ' . $grouptableName . ' gt where gt.id="' . $group_id . '"');
		// print_r($resultObject);exit();
		$option = "No Data Found";
		if ($this->db->affected_rows() > 0) {
			$result = $resultObject->row();
			
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

	public function placeHospitalMaterialOrder()
	{
		$ValidationObject = $this->is_parameter(array("hospital_order_id"));
		if ($ValidationObject->status) {
			$param = $ValidationObject->param;
			// print_r($param);exit();
			$user_id = $this->session->user_session->id;
			$company_id = $this->session->user_session->company_id;
			$branch_id = $this->session->user_session->branch_id;
			$hospital_order_id = $param->hospital_order_id;
			$itemArray[] = $this->input->post_get('itemArray');
			// print_r($itemArray);exit();
			$hospitalgrouptableName = 'hospital_order_management';
			$tableName = "hospital_material_item_table";
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
						'company_id' => $company_id
					);
					$dataArray1[] = $dataArray;
				}
			}
			if (!empty($dataArray1)) {

				if ($this->HospitalOrderModel->placeHospitamMaterialListOrder($tableName, $dataArray1)) {
					$update_data = array('status' => 1);
					$this->db->where('id', $hospital_order_id);
					$update = $this->db->update($hospitalgrouptableName, $update_data);
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

	public function getReceiveHospitalOrderHistoryTable()
	{
		if (!is_null($this->input->post('id'))) {
			$type = $this->input->post('id');
		} else {
			$type = 0;
		}

		$hospital_group_table = "hospital_material_group";
		$tableName = "hospital_order_management";

		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		// $select = array("*");
		$select = array("*", "(select hb.group_name from " . $hospital_group_table . " hb where hb.id=material_group_id) as group_name");
		// print_r($type);exit();
		if ($type == 1) {
			$where = array('receive_status' => 0,'status' => 1,'return_status'=>null,'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		} else if ($type == 2) {
			$where = array('receive_status' => 1,'status' => 1,'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		} else {
			$where = array('status' => 1,'branch_id'=>$branch_id,
							'company_id'=>$company_id);
		}

		$order = array('create_on' => 'desc');
		$column_order = array('hospital_name');
		$column_search = array();

		$memData = $this->HospitalOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

		$filterCount = $this->HospitalOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->HospitalOrderModel->countAll($tableName, $where);

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
					$receive_date,
					$row->department
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

	public function newMaterialOrderListForm()
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
			$tableName = 'hospital_material_group_table';
			// $where = array('id' => $view_material_description);
			// print_r($tableName);exit();
			// $resultObject = $this->HospitalOrderModel->getSelectMaterialDescription($tableName,$view_material_description);
			$resultObject = $this->db->query('select * from ' . $tableName . ' where id="' . $view_material_description . '"');
			if ($this->db->affected_rows() > 0) {
				$result = $resultObject->row();
				$view_material_description_name = $result->material_description;
			}
			// print($resultObject);exit();
			$tableName2 = 'hospital_material_item_table';
			$where1 = 'where material_description_id="' . $view_material_description . '" AND 	material_order_id="' . $view_hospital_order_id . '"';
			$resultObject = $this->HospitalOrderModel->selectDataById($tableName2, $where1);
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

	public function gethospitalOrderMaterialListTable()
	{
		if (!is_null($this->input->post('order_id'))) {
			$order_id = $this->input->post('order_id');
		} else {
			$order_id = 0;
		}

		$hospital_order_table = "hospital_order_management";
		$tableName = " hospital_material_item_table";
		// $select = array("*");
		$select = array("*", "(select hb.receive_status from " . $hospital_order_table . " hb where hb.id=material_order_id) as receive_status",
		"(select hb.supplier_invoice_amount from " . $hospital_order_table . " hb where hb.id=material_order_id) as supplier_invoice_amount",
		"(select hb.supplier_invoice_number from " . $hospital_order_table . " hb where hb.id=material_order_id) as supplier_invoice_number"
		);

		$where = array('material_order_id' => $order_id);
		$order = array('receive_status');
		$column_order = array('material_description');
		$column_search = array('material_description');

		$memData = $this->HospitalOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

		$filterCount = $this->HospitalOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->HospitalOrderModel->countAll($tableName, $where);
	$supplier_invoice_amount=0;
		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$supplier_invoice_amount=$row->supplier_invoice_amount;
				$supplier_invoice_number=$row->supplier_invoice_number;
				if($row->is_receive == 1 && $row->is_supplied == 1){
					$material_description=$row->material_description ."<b style='color:green'>(Received)</b>";
				}else if($row->is_receive == 0 && $row->is_supplied == 1){
					$material_description=$row->material_description."<b style='color:orange'>(Not Received)</b>";
				}else{
					$material_description=$row->material_description."<b style='color:orange'>(Not Supplied)</b>";
				}
				if($row->is_return == 1){
					$material_description=$row->material_description ."<b style='color:red'>(Return)</b>";
				}
				
				$tableRows[] = array(
					$material_description,
					$row->quantity,
					$row->unit,
					$row->id,
					$row->receive_status,
					$row->material_description_id,
					$row->material_order_id,
					$row->received_material,
					$row->supplier_unit_price,
					$supplier_invoice_amount,
					$supplier_invoice_number,
					$row->is_receive,
					$row->is_supplied,
					$row->supply_quantity,
				);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"supplier_invoice_amount" => $supplier_invoice_amount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows,
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"supplier_invoice_amount" => $supplier_invoice_amount,
				"recordsFiltered" => $filterCount,
				"data" => $memData,
			);
		}
		echo json_encode($results);
	}

	public function deleteHospitalOrderMaterialTranscation()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$tableName = "hospital_material_item_table";
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

	public function deleteHospitalOrderTranscation()
	{
		if (!is_null($this->input->post('id'))) {
			$id = $this->input->post('id');
			$tableName = "hospital_order_management";
			$where = array('id' => $id);
			$this->db->where($where);
			$delete = $this->db->delete($tableName);
			if ($delete == true) {
				$tableName2 = "hospital_material_item_table";
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

	public function SaveIndividualPrice(){
		$order_id=$this->input->post('order_id');
		$final_array=array();
		if(!is_null($order_id)){
			$query=$this->db->query("select id,material_description from 
			hospital_material_item_table where is_receive != 1 and is_supplied = 1 and material_order_id=".$order_id);
			if($this->db->affected_rows() > 0){
				$result=$query->result();
				foreach($result as $row){
					$id=$row->id;
					$material_description=$row->material_description;
					$rate=$this->input->post('rate_o_'.$id);
					if($rate == 0){
						$response['status']=201;
						$response['body'] = "Please Enter Rate for ".$material_description;
						 echo json_encode($response);
						exit; 
					}else{
						$final_array[$id]=$rate;
					}
				}
				$cnt=0;
				foreach($final_array as $key=>$value){
					$set=array("supplier_unit_price"=>$value,"is_receive"=>1);
					$where=array("id"=>$key);
					$this->db->where($where);
					$update=$this->db->update("hospital_material_item_table",$set);
					if($update == true){
						$cnt++;
					}
				}
				if($cnt > 0){
					$response['status']=200;
					$response['count']=$cnt;
					$response['body'] = "Added";
					
				}else{
					$response['status']=201;
					$response['body'] = "Something went wrong";
					
				}
				
			}else{
				$response['status']=201;
				$response['body'] = "Something went wrong";
					
			}
		}else{
			$response['status']=201;
			$response['body'] = "Order Not Found";
					
		}echo json_encode($response);
	}
	public function receiveOrderForm()
	{
		if (!is_null($this->input->post("hos_order_invoice_no")) && !is_null($this->input->post("hos_vendor_name")) && !is_null($this->input->post("hos_invoice_amount"))) {
			$hos_order_invoice_no = $this->input->post("hos_order_invoice_no");
			$hos_invoice_amount = $this->input->post("hos_invoice_amount");
			$hos_vendor_name = $this->input->post("hos_vendor_name");
			$hospital_order_id = $this->input->post("receive_hospital_order_id");
			$count_u = $this->input->post("count");
			// print_r($hospital_order_id);exit();

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

			$tableName = 'hospital_order_management';

			$query=$this->db->query("select count(*) as count,sum(case when is_receive = 1 then 1 else 0 end) as r_count from hospital_material_item_table
				where material_order_id=".$hospital_order_id);
				if($this->db->affected_rows() > 0){
					$count=$query->row()->count;
					$r_count=$query->row()->r_count;
				}else{
					$count=0;
					$r_count=0;
				}
				if($r_count == $count){
					$receive_status=1;
				}else{
					$receive_status=0;
				}
			$update_data = array(
				'invoice_number' => $hos_order_invoice_no,
				'vendor_name' => $hos_vendor_name,
				"invoice_amount" => $hos_invoice_amount,
				'invoice_attactment' => $input_data,
				'receive_status' => $receive_status,
				'receive_by' => $user_id,
				'receive_on' => date('Y-m-d h:i:s')
			);

			$where = array('id' => $hospital_order_id);
			$update = $this->HospitalOrderModel->updateForm($tableName, $update_data, $where);
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
	
	public function getTableInventries(){
		
		$orderTable = "hospital_order_management";
		$patient_medicine_order_consume = "patient_medicine_order_consume";
		$tableName = "hospital_material_item_table";
		$type=0;
		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		// $select = array("*");
		$select = array("material_description_id,id,material_description,sum(supply_quantity) 
		as quantity","(select sum(pmc.quantity) from ".$patient_medicine_order_consume." pmc where pmc.material_item_id=material_description_id) as consume");
		// print_r($type);exit();
		
		$where ="branch_id=".$branch_id." AND company_id=".$company_id." AND is_receive = 1 AND  material_order_id in (SELECT id FROM hospital_order_management where material_group_id=6)";
		$order = array('id' => 'desc');
		$column_order = array('material_description');
		$column_search = array();
		$group_by=array('material_description_id');
		$memData = $this->HospitalOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order,$group_by);

		$filterCount = $this->HospitalOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->HospitalOrderModel->countAll($tableName, $where);
		
		if (count($memData) > 0) {
			$tableRows = array();
			// print_r($memData);exit();
			foreach ($memData as $row) {

				if($row->consume >0){
					$consume=$row->consume;
				}else{
					$consume=0;
				}
				$balance=($row->quantity)-($consume);
				
				$tableRows[] = array(
					$row->material_description,
					$row->quantity,
					$row->id,
					$row->material_description_id,
					$consume,
					$balance
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
	
	function GetSummarisedHistoryData(){
		$id=$this->input->post('id');
		$status1=$this->input->post('status1');
		if($status1 == 1){
			$where="";
			$th="<th>Status</th>";
			$t_id="tableHistory1";
		}else{
			$where=" AND quantity > 0  AND status=1";
			$th="";
			$t_id="tableHistory";
		}
		$tableName = $this->session->user_session->patient_table;
		$query=$this->db->query("select *,
		(select material_description from hospital_material_item_table mt where mt.material_description_id=material_item_id order by id desc limit 1) as material ,
		(select patient_name from ".$tableName." pt where pt.id=patient_id) as patient 
		from patient_medicine_order_consume where material_item_id='$id'".$where." order by id desc");
		$data ="";
			$data .="<table class='table table-bordered' id='".$t_id."'>
			<thead>
			<tr>
			<th>Patient Name</th>
			<th>Material Name</th>
			<th>Quantity</th>
			<th>Date</th>
			".$th."
			<th>Action</th>
			</tr>
			</thaed>
			<tbody>
			";
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			
			foreach($result as $row){
				if($status1 ==1){
				if($row->quantity < 0){
					$td="<td>Reverse</td>";
				}else{
					$td="<td>Consumed</td>";
				}
				$btn="-";
			}else{
				$td="";
				$btn='<button class="btn btn-link" onclick="ReverseOrderConsume('.$row->id.','.$row->material_item_id.')">Reverse Order</button>';
			}
				
				$data .="
				<tr>
				<td>".$row->patient."</td>
				<td>".$row->material."</td>
				<td>".$row->quantity."</td>
				<td>".$row->created_on."</td>
				".$td."
				<td>".$btn."</td>
				</tr>
				";
			}
			$data .="</tbody>
			</table>";
			$response['status']=200;
			$response['data']=$data;
		}else{
			$response['status']=201;
			$response['data']=$data;
		}echo json_encode($response);
	}
	
	
	
	public function ReverseOrderConsume(){
		$id=$this->input->post('id');
		$user_id = $this->session->user_session->id;
		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		$query=$this->db->query("select * from patient_medicine_order_consume where id='$id'");
		if($this->db->affected_rows() > 0){
			$row=$query->row();
			$q = -($row->quantity);
			$data=array(
		"company_id"=>$company_id,
		"branch_id"=>$branch_id,
		"patient_id"=>$row->patient_id,
		"material_item_id"=>$row->material_item_id,
		"quantity"=>$q,
		"created_on"=>date('Y-m-d H:i:s'),
		"created_by"=>$user_id,
		"status"=>2,
		);
		}
		
		$insert=$this->HospitalOrderModel->reveseMedicineData($data,$id);
		if($insert == true){
			$response["status"] = 200;
			$response["body"] = "Reverse Successfully";
		}else{
			$response["status"] = 201;
			$response["body"] = "Something Went Wrong";
			
		}echo json_encode($response);
	}
	
	
	
	public function getPatientListData(){
		$id=$this->input->post('type');
		$tableName = $this->session->user_session->patient_table;
		
		
		$validObject = $this->is_parameter(array("type", "searchTerm"));
		$response = array();
		if ($validObject->status) {

			$type = $validObject->param->type;
			$search = $validObject->param->searchTerm;
			$where = array();
			if ((int)$type == -1){
				$where = array("1" => 1);
			}else{
				$where = array("roomid" => $id);
			}
				
			$userData = $this->db->select(array("id", "patient_name","adhar_no"))->where($where)->like("patient_name", $search)->limit(10, 0)->get($tableName)->result();
			$response["last_query"] = $this->db->last_query();
			$data = array();
			if (count($userData) > 0) {
				foreach ($userData as $user) {
					$n=$user->patient_name." ".$user->adhar_no;
					array_push($data, array("id" => $user->id, "text" =>$n ));
				}
			}
			$response["body"] = $data;
		} else {
			$response["body"] = array();
		}
		echo json_encode($response);
	}
	
	public function add_consume_details(){
		$material_item_id=$this->input->post('material_item_id');
		$patient_id=$this->input->post('patientId');
		$quantity=$this->input->post('quantityToPatient');
		$user_id = $this->session->user_session->id;
		$company_id = $this->session->user_session->company_id;
		$branch_id = $this->session->user_session->branch_id;
		$data=array(
		"company_id"=>$company_id,
		"branch_id"=>$branch_id,
		"patient_id"=>$patient_id,
		"material_item_id"=>$material_item_id,
		"quantity"=>$quantity,
		"created_on"=>date('Y-m-d H:i:s'),
		"created_by"=>$user_id,
		);
		$insert=$this->db->insert('patient_medicine_order_consume',$data);
		if($insert == true){
			$response["status"] = 200;
			$response["body"] = "Added Successfully";
		}else{
			$response["status"] = 201;
			$response["body"] = "Something Went Wrong";
			
		}echo json_encode($response);
	}
	
	public function GetOrderData(){
		$order_id=$this->input->post('id');
		$query=$this->db->query("select distinct material_description,material_description_id,material_order_id,
		(select group_concat(invoice_number,'||',vendor_name)
		from hospital_order_management hom where hom.id=hoi.material_order_id) as info 
		from hospital_material_item_table hoi where hoi.is_return=0 AND hoi.is_receive=1 AND hoi.material_order_id=".$order_id);
		$data_list="<option disabled selected>Select Item</option>";
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			foreach($result as $row){
				$data_list .="<option value='".$row->material_description_id."'>".$row->material_description."</option>";
				$info=$row->info;
			}
			
			$data=explode("||",$info);
			$invoice_number=$data[0];
			$vendor_name=$data[1];
			$response["status"] = 200;
			$response["invoice_number"] = $invoice_number;
			$response["vendor_name"] = $vendor_name;
			$response["data_list"] = $data_list;
			
		}else{
			$response["status"] = 201;
			$response["invoice_number"] = "";
			$response["vendor_name"] = "";
			$response["data_list"] = "";
			$response["body"] = "Something Went Wrong";
			
		}echo json_encode($response);
		
	}
	
	public function returnOrderForm(){
		$ret_item_list=$this->input->post('ret_item_list');
		$order_id=$this->input->post('return_hospital_order_id');
		$ret_vendor_name=$this->input->post('ret_vendor_name');
		$ret_order_invoice_no=$this->input->post('ret_order_invoice_no');
		$ret_invoice_amount=$this->input->post('ret_invoice_amount');
		$ret_invoice_quantity=$this->input->post('ret_invoice_quantity');
		$name_input = "ret_invoice_attachment";

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
			$user_id = $this->session->user_session->id;
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			//$query=$this->db->query("select * from hospital_order_management where id=".$order_id);
			//if($this->db->affected_rows()>0){
			//	$result=$query->row();
			/* $data = array(
				'hospital_name' => $result->hospital_name,
				'order_no' => $result->order_no,
				'order_for_hospital' => $result->order_for_hospital,
				'order_create_date' => date('Y-m-d H:i:s'),
				'material_group_id' => $result->material_group_id,
				'material_group_name' => $result->material_group_name,
				'order_by_user' => $result->order_by_user,
				'vendor_name' => $ret_vendor_name,
				"invoice_number" => $result->invoice_number,
				"zone_id" => $result->zone_id,
			//	"invoice_amount" => (-$ret_invoice_amount),
				'invoice_attactment' => $input_data,
				'return_status' => 1,
				'return_by' => $user_id,
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'return_on' => date('Y-m-d h:i:s')
			); */
			
			$query1=$this->db->query("select * from hospital_material_item_table where material_description_id=".$ret_item_list." AND material_order_id=".$order_id);
			if($this->db->affected_rows() > 0){
				$result1=$query1->row();
				$data2=array(
				"material_description_id"=>$result1->material_description_id,
				"material_description"=>$result1->material_description,
				"unit"=>$result1->unit,
				"material_order_id"=>$result1->material_order_id,
				"received_material"=>$result1->received_material,
				"branch_id"=>$result1->branch_id,
				"company_id"=>$result1->company_id,
				"is_return"=>1,
				"quantity"=>(-$ret_invoice_quantity),
				);
			}else{
				$data2=array();
			}
			$insert=$this->HospitalOrderModel->returnMedicineData($order_id,$data2);
		
			if($insert == true){
			
			$response["status"] = 200;
			$response["body"] = "Return Successfully";
			}else{
				$response["status"] = 201;
			$response["body"] = "Something Went Wrong";
			}
		echo json_encode($response);
				
	}
	
	public function getBalancequantity(){
		$id=$this->input->post('id');
		$order_id=$this->input->post('order_id');
		$query=$this->db->query("select sum(supply_quantity) as quantity from hospital_material_item_table where material_description_id=".$id." AND material_order_id=".$order_id);
		if($this->db->affected_rows() > 0){
			$res=$query->row();
			$quantity=$res->quantity;
			$response["status"] = 200;
			$response["quantity"] = $quantity;
		}else{
			$response["status"] = 201;
			$response["quantity"] = 0;
		}echo json_encode($response);
	}
	
	public function GetDataPrintDiv(){
		$id=$this->input->post('id');
		$data="";
		$query=$this->db->query('SELECT hospital_name,order_no,invoice_number,invoice_amount,
		(select group_concat(material_description,"||",unit,"||",supply_quantity,"||",material_total,"||",supplier_unit_price SEPARATOR "#") 
		from hospital_material_item_table
		c where c.material_order_id=p.id ) as data 
						FROM hospital_order_management p where p.id='.$id);
						
						
			//echo $this->db->last_query();
			if($this->db->affected_rows() > 0){
			$row=$query->row();
			$datahtml=$row->data;
			$data1 ="";
			$data1 .='<table class="table table-bordered">
			<thead>
			<tr>
			<th>Material Description</th>
			<th>Unit</th>
			<th>Supply quantity</th>
			<th>Amount</th>
			</tr>
			<thead>
			<tbody>
			';
			$exp=explode("#",$datahtml);
			$Tamount=0;
			for($i=0;$i<count($exp);$i++){
				$exp2=explode("||",$exp[$i]);
				$material_description = "";
					$unit = "";
					$quantity = "";
					$amount = "";
				// if(count($exp2) > 2){
					if(isset($exp2[0]) && isset($exp2[0])!="")
					{
						$material_description = $exp2[0];
					
					if(isset($exp2[1]))
					{
						$unit = $exp2[1];
					}
					
					if(isset($exp2[2]))
					{
						$quantity = $exp2[2];
					}

					if(array_key_exists(4,$exp2))
					{
						$amount = $exp2[4];
						
						$Tamount = $Tamount + ($amount);
					}
					
					
					// }
					$sts="";
					if($amount < 0){
						$sts="<b>(Return)</b>";
					}
					$data1 .="
					<tr>
					<td>".$material_description.$sts."</td>
					<td>".$unit."</td>
					<td>".$quantity."</td>
					<td>".$amount."</td>
					</tr>
					";
				}
			}
			$data1 .='
			</tbody>
			</table>
			';
			$data .="<br><br><br>
			<div class='row pl-4'>
			<div class='col-md-6'>
			<span><b>Hospital Name:</b> ".$row->hospital_name."</span> 
			</div>
			<div class='col-md-6'>
			<span><b>Order No: </b>".$row->order_no."</span>
			</div>
			</div><br>
			<div class='row pl-4'>
			<div class='col-md-6'>
			<span><b>Invoice Amount: </b> ".$Tamount."</span> 
			</div>
			<div class='col-md-6'>
			<span><b>Invoice Number: </b>".$row->invoice_number."</span>
			</div>
			</div><br>
			<div class='col-md-12'>
			".$data1."
			</div>
			
			";
			$response["status"] = 200;
			$response["data"] = $data;
			}else{
			$response["status"] = 201;
			$response["data"] = "";
		}echo json_encode($response);
	}

}
