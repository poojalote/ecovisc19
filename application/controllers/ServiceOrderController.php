<?php

require_once 'HexaController.php';

/**
 * @property  User User
 * @property  ServiceOrderModel ServiceOrderModel
 */
class ServiceOrderController extends HexaController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('ServiceOrderModel');
        $this->load->model('Global_model');
    }

    /*
     * login api
     */

    public function index()
    {
        $this->load->view('ServiceOrder/serviceOrder', array("title" => "Service Order"));
    }

    public function index1()
    {
        $this->load->view('ServiceOrder/serviceOrder1', array("title" => "Service Order"));
    }

    public function radiologySampleCollection()
    {
        $this->load->view('ServiceOrder/radiologySampleCollection', array("title" => "radiologySampleCollection"));
    }

    public function radiologySampleCollectionPickup()
    {
        $this->load->view('ServiceOrder/radiologySampleCollection', array("title" => "radiologySampleCollection"));
    }

    public function pathologySampleCollection()
    {
        $this->load->view('ServiceOrder/pathologySampleCollection', array("title" => "pathologySampleCollection"));
    }

    public function getOrderServicesName()
    {
        $category = $this->input->post('category');
        $tableName = 'service_master';

        if ($category == "All") {
            $where = "";
            $where .=" where branch_id=".$this->session->user_session->branch_id;
        } else {
            $where = "where service_category='" . $category . "'";
            $where .=" and branch_id=".$this->session->user_session->branch_id;
        }


        $resultObject = $this->ServiceOrderModel->getSelectServicesData($tableName, $where);
        // print_r($resultObject);exit();
        $option = "No Data Found";
        if ($resultObject->totalCount > 0) {
            $option = '<option value="All">All</option>';

            foreach ($resultObject->data as $key => $value) {
                $option .= '<option value="' . $value->service_no . '">' . $value->service_name . '</option>';
            }
            $results['status'] = 200;
            $results['option'] = $option;
        } else {
            $results['status'] = 201;
            $results['option'] = $option;
        }
        echo json_encode($results);
    }

    public function getStandardLabServicesName()
    {
        $day = $this->input->post('day');
        $tableName = 'service_master';
		$where = "where commonly_use='1' and branch_id=".$this->session->user_session->branch_id;
        $resultObject = $this->ServiceOrderModel->getStandardLabServicesData($tableName, $where);
        // print_r($resultObject);exit();
        $option = "No Data Found";
        if ($resultObject->totalCount > 0) {
            $count = 1;

            foreach ($resultObject->data as $key => $value) {
                $check = '';
                $val = 0;
                if ($day == 1 && $value->first_day == 1) {
                    $check = "checked";
                    $val = 1;
                } else if ($day == 5 && $value->fifth_day == 1) {
                    $check = "checked";
                    $val = 1;
                } else if ($day == 11 && $value->elevnth_day == 1) {
                    $check = "checked";
                    $val = 1;
                } else if ($day == 14 && $value->fourteenth_day == 1) {
                    $check = "checked";
                    $val = 1;
                }

                $option .= '<tr>
					<td>' . $value->service_description . '</td>
					<td style="text-align:center"><input type="checkbox" name="standardLab_' . $count . '" onclick="getStandardLabServiceCount(\'hid_or_not_' . $count . '\',\'standardLab_' . $value->id . '\')" id="standardLab_' . $value->id . '" ' . $check . '/>
					<input type="hidden" id="hid_or_not_' . $count . '"  name="hid_or_not" value="' . $val . '"/>
					<input type="hidden" name="standardServiceId_' . $count . '" id="standardServiceId_' . $count . '" value="' . $value->service_id . '"/>
					<input type="hidden" name="standardServicedesc_' . $count . '" id="standardServicedesc_' . $count . '" value="' . $value->service_description . '"/>
					<input type="hidden" name="standardServiceRate_' . $count . '" id="standardServiceRate_' . $count . '" value="' . $value->rate . '"/>
					</td>
					</tr>';
                $count++;
            }
            $option .= '<tr>
					<td><input type="hidden" name="standardLabTotalCount" id="standardLabTotalCount" value="' . $resultObject->totalCount . '"/></td>
					<td><button type="button" class="btn btn-primary" onclick="uploadStandardLabServices(\'' . $day . '\')">place order</button></td>
					</tr>';
            $results['status'] = 200;
            $results['option'] = $option;
        } else {
            $results['status'] = 201;
            $results['option'] = $option;
        }
        echo json_encode($results);
    }

    public function getOrderCommonServicesName()
    {

        $tableName = 'service_master';
        $where = "where commonly_use='1' and branch_id=".$this->session->user_session->branch_id;
        $resultObject = $this->ServiceOrderModel->selectDataById($tableName, $where);

        if ($resultObject->totalCount > 0) {
            $options = '';
            $data = $resultObject->data;
            // print_r($data);exit();
            foreach ($data as $key => $value) {
                $options .= '<li><input type="checkbox" id="ser_or_' . $value->service_id . '" onclick="addServiceOrderItem(\'' . $value->service_id . '\',\'' . $value->service_description . '\',\'' . $value->rate . '\')" value="' . $value->service_id . '"/> ' . $value->service_description . ' </li>';
            }
            $results['status'] = 200;
            $results['options'] = $options;
        } else {
            $results['status'] = 201;
            $results['options'] = "";
        }

        echo json_encode($results);
    }

    public function getBillingServicesDescription()
    {
        if (!is_null($this->input->post('service_no'))) {
            $service_no = $this->input->post('service_no');
            $tableName = 'service_master';
            if ($service_no == "All") {
                $where = array();
            } else {
                $where = array("service_no" => $service_no);
            }
            $where["branch_id"] =$this->session->user_session->branch_id;

            $resultObject = $this->ServiceOrderModel->getSelectServicesDescriptionData($tableName, $where);
            // print_r($resultObject);exit();
            $option = "No Data Found";
            if ($resultObject->totalCount > 0) {
                $option = '<option selected disabled>Select Services</option>';

                foreach ($resultObject->data as $key => $value) {
                    $option .= '<option value="' . $value->service_id . '">' . $value->service_description . '</option>';
                }
                $results['status'] = 200;
                $results['option'] = $option;
            } else {
                $results['status'] = 201;
                $results['option'] = $option;
            }
        } else {
            $results['status'] = 201;
            $results['option'] = "";
            $results['body'] = "parameter missing";
        }
        echo json_encode($results);
    }

    public function getServicesOrderRate()
    {
        if (!is_null($this->input->post('id'))) {
            $service_id = $this->input->post('id');
            $tableName = 'service_master';
            $resultObject = $this->ServiceOrderModel->getSelectServicesRateData($tableName, $service_id);
            // print_r($resultObject);exit();
            // $option="No Data Found";
            if ($resultObject->totalCount > 0) {
                $resultObject->data;
                $results['status'] = 200;
                $results['option'] = $resultObject->data;;
            } else {
                $results['status'] = 201;
                $results['option'] = "";
            }
        } else {
            $results['status'] = 201;
            $results['option'] = "";
            $results['body'] = "parameter missing";
        }
        echo json_encode($results);
    }

    public function get_status_true($tableServiceOrder, $patientId, $branch_id, $service_id, $company_id)
    {
        $alreadyServiceExist = $this->db->query('select * from ' . $tableServiceOrder . ' where patient_id=' . $patientId . ' AND branch_id=' . $branch_id . ' AND company_id=' . $company_id . ' AND service_id="' . $service_id . '" AND sample_pickup=0 AND (service_category="RADIOLOGY" OR service_category="PATHOLOGY")')->num_rows();
        if ($alreadyServiceExist >= 1) {
            return false;
        } else {
            return true;
        }
    }

    public function get_status_true_billing($BillingTable, $patientId, $branch_id, $service_id, $company_id, $date)
    {
        $alreadyServiceExist = $this->db->query('select *,
		(select service_category from service_master s where s.service_id=b.service_id) as service_cat,
		(select service_description from service_master s where s.service_id=b.service_id) as service_description
		from ' . $BillingTable . ' b where patient_id=' . $patientId . ' AND branch_id=' . $branch_id . ' AND service_id="' . $service_id . '" AND confirm=0 AND is_deleted=1 AND DATE(date_service) = DATE("' . $date . '")')->row();

        if ($this->db->affected_rows() > 0) {
            $service_cat = $alreadyServiceExist->service_cat;
            $service_description = $alreadyServiceExist->service_description;
            if ($service_cat == "RADIOLOGY" || $service_cat == "PATHOLOGY") {
                return false;
            } else {

                return $service_description;
            }
        } else {
            return false;
        }
    }

    public function placeServiceOrder()
    {
        // $itemArray = $this->input->post_get('itemArray');
        //  print_r($itemArray);exit();
        $ValidationObject = $this->is_parameter(array("patientId"));
        if ($ValidationObject->status) {
            $param = $ValidationObject->param;
            // print_r($param->patientId);exit();
            $user_id = $this->session->user_session->id;
            $company_id = $this->session->user_session->company_id;
            $branch_id = $this->session->user_session->branch_id;
            $patientId = $param->patientId;
            $patientName = $this->input->post_get('patientName');
            $patientAdhar = $this->input->post_get('patientAdhar');
            $time = $this->input->post_get('time');
            $randomNo = mt_rand(100000, 999999);
            $order_number = "o_" . $patientId . '_' . $randomNo;
            // print_r($order_number);exit();
            $tableName = 'service_order';
            $patientId = $param->patientId;

            $itemArray = array();

            $itemArray[] = $this->input->post_get('itemArray');
            // $timeArray[] = $this->input->post_get('timeArray');

            // $prescriptionArray["create_by"]=$user_id;
            // var_dump($timeArray);exit();
            $tableServiceOrder = "service_order";
            $billingTable = "service_order";
            $dataArray1 = array();
            $billing_array1 = array();
            $statusResult = true;

            foreach ($itemArray as $prescriptionArraydata) {

                $dataArray = array();
                $billing_array = array();
                foreach ($prescriptionArraydata as $key => $value) {

                    $statusResult = $this->get_status_true($tableServiceOrder, $patientId, $branch_id, $value['service_id'], $company_id);
                    if ($statusResult == false) {
                        $response["status"] = 201;
                        $response["body"] = "Already Ordered Sample collection Pending";
                        echo json_encode($response);

                        exit();
                    }


                    $billing_transaction = $this->session->user_session->billing_transaction;
                    $statusResultBilling = $this->get_status_true_billing($billing_transaction, $patientId, $branch_id, $value['service_id'], $company_id, $value['service_date']);
                    if ($statusResultBilling != false) {
                        $response["status"] = 201;
                        $response["body"] = "Billing is not close for " . $statusResultBilling . " service";
                        echo json_encode($response);
                        exit();
                    }
                    $serviceOrderExistData = $this->db->query("select * from " . $tableServiceOrder . " where patient_id='" . $patientId . "' AND service_id='" . $value['service_id'] . "' AND order_date='" . $value['service_date'] . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "' AND service_category !='PATHOLOGY'")->num_rows();

                    if ($serviceOrderExistData <= 0) {
                        $resultServiceCategory = $this->db->query("select service_category,service_no from service_master where service_id='" . $value['service_id'] . "'")->row();
                        $s_category_coll = $resultServiceCategory->service_category;
                        $service_no = $resultServiceCategory->service_no;
                        $sample_collection = 1;
                        $status = 1;
                        $confirm_service_given = 0;
                        $service_user_id = $user_id;
                        $service_given_date = date('Y-m-d H:i:s');
                        if ($s_category_coll == "RADIOLOGY") {
                            $sample_collection = 0;
                            $status = 0;
                            $service_user_id = "";
                            $service_given_date = "";
                        }

                        if ($s_category_coll == "PATHOLOGY") {
                            $confirm_service_given = 1;
                            $sample_collection = 0;
                        }

                        $dataArray = array('order_number' => $order_number,
                            'service_id' => $value['service_id'],
                            'service_no' => $service_no,
                            'service_detail' => $value['service_description'],
                            'service_category' => $s_category_coll,
                            'order_receive' => 1,
                            'order_date' => $value['service_date'],
                            // 'order_time' => $time,
                            'quantity' => 1,
                            'patient_id' => $patientId,
                            'patient_name' => $patientName,
                            'adhar_number' => $patientAdhar,
                            'price' => $value['rate'],
                            'company_id' => $company_id,
                            'branch_id' => $branch_id,
                            'sample_collection' => $sample_collection,
                            'create_by' => $user_id,
                            'create_on' => date('Y-m-d H:i:s'),
                            'service_provider' => $service_user_id,
                            'service_given_date' => $service_given_date,
                            'confirm_service_given' => $confirm_service_given,
                            'service_perform_by' => $value['service_perform']
                        );
                        $dataArray1[$key] = $dataArray;
                        $billing_unit = 1;
                        $billing_rate = $value['rate'];
                        $total = $billing_unit * $billing_rate;

                        if ($s_category_coll == 'ACCOMM') {
                            $type = 1;
                            $entry_type = 1;
                        } else {
                            $type = 3;
                            $entry_type = 0;
                        }
                        $billing_array = array('order_id' => $order_number,
                            'service_id' => $value['service_id'],
                            'service_desc' => $value['service_description'],
                            'unit' => 1,
                            'date_service' => $value['service_date'],
                            'total' => $total,
                            'create_on' => date('Y-m-d H:i:s'),
                            'create_by' => $user_id,
                            'rate' => $value['rate'],
                            'status' => $status,
                            'patient_id' => $patientId,
                            'type' => $type,
                            'branch_id' => $branch_id,
                            'entry_type' => $entry_type,
                            'final_amount' => $total);
                        $billing_array1[$key] = $billing_array;
                        // if($s_category_coll=="PATHOLOGY" || $s_category_coll=="RADIOLOGY")
                        // {
                        // 	// $billing_array=array();
                        // }
                        // else
                        // {

                        // }
                        // }
                        // }
                    }


                }

            }
            // print_r($dataArray1);exit();

            if (!empty($dataArray1)) {
                $billing_transaction = $this->session->user_session->billing_transaction;
                if ($this->ServiceOrderModel->placeServiceOrder($tableName, $dataArray1, $billing_transaction, $billing_array1,$patientId,$branch_id)) {
                    // if(!empty($billing_array1)){
                    //
                    // 	if($this->ServiceOrderModel->placeServiceOrder1($billing_transaction,$billing_array1))
                    // 		{
                    $response["status"] = 200;
                    $response["body"] = "Order Placed Successfully";
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


    public function placeStandardLabServiceOrder()
    {
        // $itemArray = $this->input->post();
        // print_r($itemArray);exit();
        $standardLabTotalCount = $this->input->post('standardLabTotalCount');
        $labDay = $this->input->post('labDay');

        $patientName = $this->input->post('patientName');
        $patient_id = $this->input->post('patient_id');
        $patientAdhar = $this->input->post('patientAdhar');

        $randomNo = mt_rand(100000, 999999);
        $order_number = "o_" . $patient_id . '_' . $randomNo;
        $tableName = 'service_order';
        $dataArray1 = array();
        $dataArray = array();
        $billing_array = array();
        $billing_array1 = array();
        $patient_table = $this->session->user_session->patient_table;
        $user_id = $this->session->user_session->id;
        $company_id = $this->session->user_session->company_id;
        $branch_id = $this->session->user_session->branch_id;

        $where = array('id' => $patient_id);
        $result = $this->ServiceOrderModel->getPatientAdmissionDate($patient_table, $where);
        // print_r($result);exit();
        $admissionDate = "";
        if ($result->totalCount > 0) {
            $resultData = $result->data;
            $admissionDate = $resultData->admission_date;
        }
        $standardLabDate = $this->input->post('standardLabDate');
        $date = $standardLabDate;
        if ($admissionDate != "" && $admissionDate != "0000-00-00 00:00:00") {
            $Date = $admissionDate;
//			if ($labDay == 1) {
//				$date = $admissionDate;
//			} else if ($labDay == 5) {
//
//				$date = date('Y-m-d', strtotime($Date . ' + 5 days'));
//			} else if ($labDay == 11) {
//
//				$date = date('Y-m-d', strtotime($Date . ' + 11 days'));
//			} else if ($labDay == 14) {
//
//				$date = date('Y-m-d', strtotime($Date . ' + 14 days'));
//			} else if ($labDay == 0) {
//
//				$date = date('Y-m-d', strtotime($standardLabDate));
//			}


            $tableServiceOrder = "service_order";
            for ($i = 1; $i <= $standardLabTotalCount; $i++) {
                $standardLab = $this->input->post('standardLab_' . $i);
                // print_r($standardLab);exit();
                $standardServiceId = $this->input->post('standardServiceId_' . $i);
                $standardServicedesc = $this->input->post('standardServicedesc_' . $i);
                $standardServiceRate = $this->input->post('standardServiceRate_' . $i);

                if ($standardLab == 'on') {

                    $serviceOrderExistData = $this->db->query("select * from " . $tableServiceOrder . " where patient_id='" . $patient_id . "' AND service_id='" . $standardServiceId . "' AND order_date='" . $date . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "'AND service_category !='PATHOLOGY'")->num_rows();
                    // print_r($serviceOrderExistData);exit();
                    $statusResult = $this->get_status_true($tableServiceOrder, $patient_id, $branch_id, $standardServiceId, $company_id);
                    if ($statusResult == false) {
                        $response["status"] = 201;
                        $response["body"] = "Already Ordered Sample collection Pending";
                        echo json_encode($response);
                        exit();
                    }
                    if ($serviceOrderExistData <= 0) {
                        $resultServiceCategory = $this->db->query("select service_category,service_no from service_master where service_id='" . $standardServiceId . "'")->row();
                        $s_category_coll = $resultServiceCategory->service_category;
                        $service_no = $resultServiceCategory->service_no;
                        $sample_collection = 1;
                        $status = 1;
                        $confirm_service_given = 0;
                        $service_user_id = $user_id;
                        $service_given_date = date('Y-m-d H:i:s');
                        if ($s_category_coll == "RADIOLOGY") {
                            $sample_collection = 0;
                            $status = 0;
                            $service_user_id = "";
                            $service_given_date = "";
                        }
                        if ($s_category_coll == "PATHOLOGY") {
                            $confirm_service_given = 1;
                            $sample_collection = 0;
                        }
                        $dataArray = array('order_number' => $order_number,
                            'service_id' => $standardServiceId,
                            'service_no' => $service_no,
                            'service_detail' => $standardServicedesc,
                            'service_category' => $s_category_coll,
                            'order_receive' => 1,
                            'order_date' => $date,
                            // 'order_time' => $time,
                            'quantity' => 1,
                            'patient_id' => $patient_id,
                            'patient_name' => $patientName,
                            'adhar_number' => $patientAdhar,
                            'price' => $standardServiceRate,
                            'company_id' => $company_id,
                            'branch_id' => $branch_id,
                            'sample_collection' => $sample_collection,
                            'create_by' => $user_id,
                            'create_on' => date('Y-m-d H:i:s'),
                            'service_provider' => $service_user_id,
                            'service_given_date' => $service_given_date,
                            'confirm_service_given' => $confirm_service_given);
                        $dataArray1[$i] = $dataArray;

                        $billing_unit = 1;
                        $billing_rate = $standardServiceRate;
                        $total = $billing_unit * $billing_rate;
                        $billing_array = array('order_id' => $order_number,
                            'service_id' => $standardServiceId,
                            'service_desc' => $standardServicedesc,
                            'unit' => 1,
                            'date_service' => $date,
                            'total' => $total,
                            'create_on' => date('Y-m-d H:i:s'),
                            'create_by' => $user_id,
                            'rate' => $standardServiceRate,
                            'status' => $status,
                            'patient_id' => $patient_id,
                            'type' => 3,
                            'branch_id' => $branch_id,
                            'final_amount' => $total);
                        $billing_array1[$i] = $billing_array;
                        // if($s_category_coll=="PATHOLOGY" || $s_category_coll=="RADIOLOGY")
                        // {
                        // 	// $billing_array=array();
                        // }
                        // else
                        // {
                        // 	$billing_array1[]=$billing_array;
                        // }

                    }
                }
            }

            if (!empty($dataArray1)) {
                $billing_transaction = $this->session->user_session->billing_transaction;
                if ($this->ServiceOrderModel->placeServiceOrder(
                    $tableName, $dataArray1, $billing_transaction, $billing_array1)) {

                    $response["status"] = 200;
                    $response["body"] = "Order Placed Successfully";

                } else {
                    $response["status"] = 201;
                    $response["body"] = " Order not places";
                }
            } else {
                $response["status"] = 201;
                $response["body"] = " Order alredy places";
            }
            // print_r($dataArray1);exit();
        } else {
            $response["status"] = 201;
            $response["body"] = "Patient Yet Not Admitted";
        }
        echo json_encode($response);
    }

    public function add_billing_transaction()
    {
        if (!is_null($this->input->post("bservice_name")) && !is_null($this->input->post("bservice_desc")) && !is_null($this->input->post("billing_rate")) && !is_null($this->input->post("billing_date")) && !is_null($this->input->post("billing_patient_id"))) {

            $bservice_name = $this->input->post("bservice_name");
            $bservice_desc = $this->input->post("bservice_desc");
            $billing_rate = $this->input->post("billing_rate");
            $billing_date = $this->input->post("billing_date");

            $billing_unit = $this->input->post("billing_unit");
            $patientId = $this->input->post("billing_patient_id");
            $billing_detail = $this->input->post("billing_detail");
            $billing_file = $this->input->post("billing_file");
            $service_id = $this->input->post("billing_service_id");

            $billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
            $user_id = $this->session->user_session->id;//hospital_room_table

            if (is_null($this->input->post("billing_unit")) && $this->input->post("billing_unit") == "") {
                $billing_unit = 1;
            }
            if (is_null($this->input->post("billing_detail")) && $this->input->post("billing_detail") == "") {
                $billing_detail = '';
            }
            if (is_null($this->input->post("billing_file")) && $this->input->post("billing_file") == "") {
                $billing_file = '';
            }
            $this->load->model('formmodel');
            $upload_path = "uploads";

            $combination = 2;
            $result = $this->upload_file($upload_path, "billing_file", $combination);
            $response["f"] = $result;
            if ($result->status) {
                $input_data = $result->body[0];
            } else {
                $input_data = "";
            }


            $total = $billing_unit * $billing_rate;

            $update_data = array(
                'service_id' => $service_id,
                'unit' => $billing_unit,
                "rate" => $billing_rate,
                'total' => $total,
                'service_desc' => $billing_detail,
                'service_file' => $input_data,
                'patient_id' => $patientId,
                'date_service' => $billing_date,
                'status' => 1,
                'create_on' => date('Y-m-d'),
                'create_by' => $user_id,
                'branch_id' => $branch_id

            );
            // $dataSelect=$this->db->query("select * from ".$billing_transaction." where service_id=".$service_id."");
            $update = $this->BillingModel->addForm($billing_transaction, $update_data);
            if ($update == TRUE) {
                $response["status"] = 200;
                $response["data"] = "updated successfully";
            } else {
                $response["status"] = 201;
                $response["data"] = "Not Updated";
            }

        } else {
            $response["status"] = 201;
            $response["data"] = "Something went wrong";
        }


        echo json_encode($response);
    }

    public function getOrderPlaceTable()
    {
        $patient_id = $this->input->post('p_id');
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;


        $tableName = "service_order";
        $where = array('patient_id' => $patient_id, 'branch_id' => $branch_id, 'company_id' => $company_id, 'sample_collection' => 1);
        $order = array('id' => 'desc');
        $column_order = array('service_detail');
        $column_search = array("service_detail");
        $select = array("*");
        $memData = $this->ServiceOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);
        $results_last_query = $this->db->last_query();
        $filterCount = $this->ServiceOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->ServiceOrderModel->countAll($tableName, $where);

        // $resultObject = $this->ServiceOrderModel->service_order_history($tableName, $where);
        // print_r($resultObject);exit();
        // $resultObject=$this->DepartmentModel->getTableData($where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {

                $date = $this->getDate($row->order_date);
                $tableRows[] = array(
                    $row->service_detail,
                    $row->date_service = $date,
                    $row->order_time,
                    $row->price,
                    $row->id,

                );
            }
            $results = array(
                "draw" => (int)$_POST['draw'],
                "recordsTotal" => $totalCount,
                "recordsFiltered" => $filterCount,
                "data" => $tableRows
            );
        } else {
            $results = array(
                "draw" => (int)$_POST['draw'],
                "recordsTotal" => $totalCount,
                "recordsFiltered" => $filterCount,
                "data" => $memData
            );
        }


        $results['last_query'] = $results_last_query;
        echo json_encode($results);
    }

    public function deleteserviceOrderTranscation()
    {
        if (!is_null($this->input->post('id'))) {
            $id = $this->input->post('id');
            // $billing_transaction = $this->session->user_session->billing_transaction;//hospital_room_table
            // $table_name='departments_master';
            $tableName = "service_order";
            // $where = array('id' => $id);
            $where = "where id='" . $id . "'";
            $result = $this->ServiceOrderModel->deleteServicePlaceOrder($tableName, $where);
            // print_r($result);exit();
            if ($result == true) {
                $response["status"] = 200;
                $response["body"] = "Deleted successfully";
            } else {
                $response["status"] = 201;
                $response["body"] = "Not Deleted";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function getServiceOrderPlaceTimeTable1()
    {
        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $patient_table = $this->session->user_session->patient_table;
            $branch_id = $this->session->user_session->branch_id;
            $company_id = $this->session->user_session->company_id;

            $tableName = "service_order";
            $where = array('id' => $patientId);
            $result = $this->ServiceOrderModel->getPatientAdmissionDate($patient_table, $where);
            // print_r($result);exit();

            $where = "where patient_id='" . $patientId . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "'  group by order_date";

            $resultDateData = $this->ServiceOrderModel->selectDataById($tableName, $where);
            // print_r($resultData);exit();

            $where = "where patient_id='" . $patientId . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "'";
            $resultserviceData = $this->ServiceOrderModel->selectDataById($tableName, $where);

            $admissionDate = "";
            if ($result->totalCount > 0) {
                $resultData = $result->data;
                $admissionDate = $resultData->admission_date;
            }
            $data = '';
            if ($admissionDate != "" && $admissionDate != "0000-00-00 00:00:00") {
                $admissionDate = $this->getDate($admissionDate);
                $data .= '<thead>
							<tr><td class="sticky-col"><b>ADMISSION DATE : ' . $admissionDate . '</b></td></tr>
							<tr>
								<td class="sticky-col first-col"><b>LAB TEST</b></td>
								';
                if ($resultDateData->totalCount > 0) {
                    $dates = $resultDateData->data;


//					foreach ($dates as $key => $value) {
//						$date = date('jS', strtotime($value->order_date));
//
//					}
                    $dateArray = array();
                    $dateArray1 = array();
                    // print_r($dates);exit();
                    foreach ($dates as $key => $value1) {
                        $dateArray[] = date('Y-m-d', strtotime($value1->order_date));
                        // $dateArray[$value1->order_date][] = $value1;

                    }
                    $dateArray = array_unique($dateArray);
                    // print_r($dateArray);exit();
                    foreach ($dateArray as $key => $value) {
                        $date = date('jS ', strtotime($value));
                        // $date = $this->getDate($value->order_date);
                        $data .= '<td>' . $date . '</td>';
                        $dateArray1[] = $value;
                    }
                    // print_r($dateArray);exit();
                    $data .= '</tr>
									</thead>';
                    $data .= '<tbody>';
                    if ($resultserviceData->totalCount > 0) {
                        $servicedata = $resultserviceData->data;
                        $service_name = array();
                        foreach ($servicedata as $key => $value1) {
                            $service_name[$value1->service_detail][] = $value1;
                            // $service_name['date']=$value1->order_date;
                            // $service_name=$value1->service_detail;
                        }
                        // $servicedata = array_unique($service_name);
                        // print_r($dateArray);exit();

                        foreach ($service_name as $key => $value1) {
                            $data .= '<tr>';
                            $sName = substr($key, 0, 15);
                            $data .= '<td class="sticky-col first-col"><div class="a">' . $key . '</div></td>';
                            for ($i = 0; $i < count($dateArray1); $i++) {
                                // print_r($dateArray1);exit();
                                $is_present = false;
                                foreach ($value1 as $key => $svalue) {
                                    $datemanual = date('Y-m-d', strtotime($svalue->order_date));
                                    if ($dateArray1[$i] == $datemanual) {
                                        // if(in_array(date('Y-m-d',strtotime($svalue->order_date)), $dateArray)){
                                        // echo $svalue->order_date;
                                        $data .= '<td style="text-align:center"><input type="checkbox" checked disabled>
										</td>';
                                        $is_present = true;
                                        break;
                                    }

                                }
                                if (!$is_present) {
                                    $data .= '<td></td>';

                                }


                            }
                            $data .= '</tr>';
                        }


                    }
                    $data .= '</tbody>';
                }

            }
            $response["status"] = 200;
            $response["options"] = $data;
            // if($admissionDate)
        } else {
            $response["status"] = 201;
            $response["options"] = "";
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function getServiceOrderPlaceTimeTable()
    {
        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $patient_table = $this->session->user_session->patient_table;
            $branch_id = $this->session->user_session->branch_id;
            $company_id = $this->session->user_session->company_id;
            $billing_transaction = $this->session->user_session->billing_transaction;

            $tableName = "service_order";
            $where = array('id' => $patientId);
            $result = $this->ServiceOrderModel->getPatientAdmissionDate($patient_table, $where);
            // print_r($result);exit();
            $where = "where patient_id='" . $patientId . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "' group by order_date";
            $resultDateData = $this->ServiceOrderModel->selectDataById($tableName, $where);
            // print_r($resultData);exit();

            $where = "where patient_id='" . $patientId . "' AND company_id='" . $company_id . "' AND branch_id='" . $branch_id . "'";
            $resultserviceData = $this->ServiceOrderModel->selectDataById1($tableName, $where, $billing_transaction);

            $admissionDate = "";
            if ($result->totalCount > 0) {
                $resultData = $result->data;
                $admissionDate = $resultData->admission_date;
            }
            $data = '';
            if ($admissionDate != "" && $admissionDate != "0000-00-00 00:00:00") {
                $admissionDate = $this->getDate($admissionDate);
                $data .= '<thead>
							<tr><td class="sticky-col"><b>ADMISSION DATE : ' . $admissionDate . '</b></td></tr>
							<tr>
								<td class="sticky-col first-col"><b>LAB TEST</b></td>
								';
                if ($resultDateData->totalCount > 0) {
                    $dates = $resultDateData->data;
                    $dateArray = array();
                    $dateArray1 = array();
                    // print_r($dates);exit();
                    foreach ($dates as $key => $value1) {
                        $dateArray[] = date('Y-m-d', strtotime($value1->order_date));
                        // $dateArray[$value1->order_date][] = $value1;

                    }
                    $dateArray = array_unique($dateArray);
                    asort($dateArray);
                    // print_r($dateArray);exit();
                    foreach ($dateArray as $key => $value) {
                        $date = date('jS ', strtotime($value));
                        // $date = $this->getDate($value->order_date);
                        $data .= '<td class="text-center">' . $date . '</td>';
                        $dateArray1[] = $value;
                    }
                    // print_r($dateArray);exit();
                    $data .= '</tr>
									</thead>';
                    $data .= '<tbody>';
                    if ($resultserviceData->totalCount > 0) {
                        $servicedata = $resultserviceData->data;
                        $service_name = array();
                        foreach ($servicedata as $key => $value1) {
                            $service_name[$value1->service_detail][] = $value1;
                            // $service_name['date']=$value1->order_date;
                            // $service_name=$value1->service_detail;
                        }
                        // $servicedata = array_unique($service_name);
                        // print_r($dateArray);exit();

                        foreach ($service_name as $key => $value1) {
                            $data .= '<tr>';
                            $sName = substr($key, 0, 15);
                            $data .= '<td class="sticky-col first-col"><div class="a">' . $key . '</div></td>';
                            for ($i = 0; $i < count($dateArray1); $i++) {
                                // print_r($dateArray1);exit();
                                $is_present = false;
                                foreach ($value1 as $key => $svalue) {
                                    $datemanual = date('Y-m-d', strtotime($svalue->order_date));
                                    if ($dateArray1[$i] == $datemanual) {
                                        // if(in_array(date('Y-m-d',strtotime($svalue->order_date)), $dateArray)){
                                        // echo $svalue->order_date;
                                        $data .= '<td style="text-align:center"><input type="checkbox" class="pt-1" checked disabled>';
                                        if ($svalue->service_category == 'PATHOLOGY') {
                                            if ($svalue->sample_pickup == 0) {
                                                $data .= '
												<button class="btn btn-link" style="margin-top: -5px;" onclick="deletePathService(' . $svalue->id . ')"><i class="fa fa-trash"></i></button>
												</td>';
                                            }
                                        } else if ($svalue->service_category == 'RADIOLOGY') {
                                            if ($svalue->file_upload == null && $svalue->file_upload == "" && $svalue->normal_status == null && $svalue->normal_status == "") {
                                                $data .= '
												<button class="btn btn-link" style="margin-top: -5px;" onclick="deletePathService(' . $svalue->id . ')"><i class="fa fa-trash"></i></button>
												</td>';
                                            }

                                        } else {

                                            if ($svalue->confirm == 0) {

                                                $data .= '
												<button class="btn btn-link" style="margin-top: -5px;" onclick="deletePathService(' . $svalue->id . ')"><i class="fa fa-trash"></i></button>
												</td>';
                                            }

                                        }

                                        $is_present = true;
                                        break;
                                    }

                                }
                                if (!$is_present) {
                                    $data .= '<td></td>';

                                }


                            }
                            $data .= '</tr>';
                        }


                    }
                    $data .= '</tbody>';
                }

            }
            $response["status"] = 200;
            $response["options"] = $data;
            // if($admissionDate)
        } else {
            $response["status"] = 201;
            $response["options"] = "";
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function getSampleCollectionTable()
    {
        // print_r("hiiii");exit();
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $patient_table = $this->session->user_session->patient_table;
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;

        // $category="RADIOLOGY";
        $category = $this->input->post('category');
        $patient_id = $this->input->post('patient_id');
        $zone = $this->input->post('zone_id');

        // print_r($zone);exit();
        $where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'sample_collection' => 0, 'service_category' => $category, 'sample_pickup' => 0, 'file_upload_status' => 0);
        if ($patient_id != null && $patient_id != '') {
            $where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'sample_collection' => 0, 'service_category' => $category, 'patient_id' => $patient_id, 'sample_pickup' => 0, 'file_upload_status' => 0);
        }

        $tableName = "service_order so";

        $order = array('id' => 'desc');
        $column_order = array('service_id', 'service_description');
        $column_search = array();
        $select = array("so.*",
            "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info",
            " group_concat(concat('AA',lpad(id,6,'0'))) as order_id",
            "group_concat(service_id) as service_code",
            "group_concat(service_detail) as service_name",
            "group_concat(service_detail,'||',so.id,'||',so.patient_id) as delete_string",
            "(select pt.roomid from " . $patient_table . " pt where  pt.id=so.patient_id) as room_id",
            "(select um.name from users_master um where um.id=so.create_by) as user_name");

        $this->db->select($select)->where($where)->group_by("service_category,patient_id");

        if (!is_null($zone)) {
            if ((int)$zone != -1) {
                $this->db->having('room_id', $zone);
            }
        }
        $memData = $this->db->get($tableName)->result();

//		$memData = $this->ServiceOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order,'service_no,patient_id');
        $results_last_query = $this->db->last_query();
//		$filterCount = $this->ServiceOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
//		$totalCount = $this->ServiceOrderModel->countAll($tableName, $where);

        // $resultObject = $this->ServiceOrderModel->service_order_history($tableName, $where);
        // print_r($resultObject);exit();
        // $resultObject=$this->DepartmentModel->getTableData($where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {

                $serviceIDArray = array();
                $patient_info = explode('|||', $row->patient_info);
                $patient_name = "";
                $bed_name = "";
                $room_id = "";
                if (count($patient_info) > 1) {
                    $patient_name = $patient_info[0];
                    $bed_name = $patient_info[1];
                    $room_id = $patient_info[2];
                }
                // print_r($row->confirm_service_given);exit();
                $today = date('Y-m-d H:i:s');

                if (date('Y-m-d', strtotime($row->order_date)) <= $today) {

                    $service_info = explode(',', $row->delete_string);

                    foreach ($service_info as $key => $svalue) {
                        $servicevalue = explode('||', $svalue);
                        if (count($servicevalue) > 1) {
                            $serviceID = $servicevalue[1];
                            array_push($serviceIDArray, $serviceID);
                        }
                    }

                    if ($row->service_given_date != null && $row->service_given_date != "0000-00-00 00:00:00") {
                        // $date = $this->getDate($row->service_given_date);
                        $date = date("Y-m-d h:i:sa", strtotime($row->service_given_date));
                        // $date = new /DateTime($row->service_given_date);
                    } else {
                        $date = "-";
                    }
                    if ($row->user_name != null && $row->user_name != "") {
                        $user = $row->user_name;
                    } else {
                        $user = "-";
                    }
                    $tableRows[] = array(

                        $bed_name,
                        $patient_name,
                        $row->order_id,
                        $row->service_code,
                        $row->order_number,
                        $row->service_name,
                        $row->id,
                        $row->service_no,
                        $user,
                        $date,
                        $row->confirm_service_given,
                        $row->delete_string,
                        $row->patient_id,
                        $serviceIDArray
                    );
                }
            }

            $results = array(
                "draw" => 1,
                "recordsTotal" => count($memData),
                "recordsFiltered" => count($memData),
                "data" => $tableRows
            );
        } else {
            $results = array(
                "draw" => 1,
                "recordsTotal" => count($memData),
                "recordsFiltered" => count($memData),
                "data" => $memData
            );
        }


        $results['last_query'] = $results_last_query;
        echo json_encode($results);
    }


    public function getRadiologySampleCollectionTable()
    {
        // print_r("hiiii");exit();
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $patient_table = $this->session->user_session->patient_table;
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;

        // $category="RADIOLOGY";
        $category = $this->input->post('category');
        $patient_id = $this->input->post('patient_id');
        $zone = $this->input->post('zone_id');

        // print_r($zone);exit();
        $where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'sample_collection' => 0, 'service_category' => $category, 'sample_pickup' => 0, 'is_deleted' => 1);
        if ($patient_id != null && $patient_id != '') {
            $where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'sample_collection' => 0, 'service_category' => $category, 'patient_id' => $patient_id, 'sample_pickup' => 0, 'is_deleted' => 1);
        }

        $tableName = "service_order so";

        $order = array('id' => 'desc');
        $column_order = array('service_id', 'service_description');
        $column_search = array();
        $select = array("so.*",
            "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info",
            "(select pt.roomid from " . $patient_table . " pt where  pt.id=so.patient_id) as room_id",
            "(select um.name from users_master um where um.id=so.service_provider) as user_name");
        // $this->db->select($select)->where($where)->group_by("service_category,patient_id");
        // " group_concat(concat('AA',lpad(id,6,'0'))) as order_id",
        // 	"group_concat(service_id) as service_code",
        // 	"group_concat(service_detail) as service_name",
        // 	"group_concat(service_detail,'||',so.id,'||',so.patient_id) as delete_string",
        $this->db->select($select)->where($where);
        if (!is_null($zone)) {
            if ((int)$zone != -1) {
                $this->db->having('room_id', $zone);
            }
        }
        $memData = $this->db->get($tableName)->result();

//		$memData = $this->ServiceOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order,'service_no,patient_id');
        $results_last_query = $this->db->last_query();
//		$filterCount = $this->ServiceOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
//		$totalCount = $this->ServiceOrderModel->countAll($tableName, $where);

        // $resultObject = $this->ServiceOrderModel->service_order_history($tableName, $where);
        // print_r($resultObject);exit();
        // $resultObject=$this->DepartmentModel->getTableData($where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {

                $serviceIDArray = array();
                $patient_info = explode('|||', $row->patient_info);
                $patient_name = "";
                $bed_name = "";
                $room_id = "";
                if (count($patient_info) > 1) {
                    $patient_name = $patient_info[0];
                    $bed_name = $patient_info[1];
                    $room_id = $patient_info[2];
                }

                // $service_info=explode(',', $row->delete_string);

                // foreach ($service_info as $key => $svalue) {
                // 	$servicevalue=explode('||', $svalue);
                // 	if (count($servicevalue) > 1) {
                // 		$serviceID = $servicevalue[1];
                // 		array_push($serviceIDArray,$serviceID);
                // 	}
                // }
                // print_r($serviceIDArray);exit();
                // $service_name=
                // print_r($row->confirm_service_given);exit();
                $today = date('Y-m-d');

                if (date('Y-m-d', strtotime($row->order_date)) <= $today) {

                    if ($row->service_given_date != null && $row->service_given_date != "0000-00-00 00:00:00") {
                        // $date = $this->getDate($row->service_given_date);
                        $date = date("Y-m-d h:i:sa", strtotime($row->service_given_date));
                        // $date = new /DateTime($row->service_given_date);
                    } else {
                        $date = "-";
                    }
                    if ($row->user_name != null && $row->user_name != "") {
                        $user = $row->user_name;
                    } else {
                        $user = "-";
                    }
                    if ($row->file_upload != null && $row->file_upload != "") {
                        $file_upload = $row->file_upload;
                    } else {
                        $file_upload = "";
                    }
                    if ($row->normal_status != null && $row->normal_status != "") {
                        $normal_status = $row->normal_status;
                    } else {
                        $normal_status = "-";
                    }
                    if ($row->Remark != null && $row->Remark != "") {
                        $Remark = $row->Remark;
                    } else {
                        $Remark = "-";
                    }

                    $tableRows[] = array(

                        $bed_name,
                        $patient_name,
                        $row->order_number,
                        $row->service_id,
                        $row->order_number,
                        $row->service_detail,
                        $row->id,
                        $row->service_no,
                        $user,
                        $date,
                        $row->confirm_service_given,
                        $row->id,
                        $row->patient_id,
                        $row->id,
                        $file_upload,
                        $normal_status,
                        $Remark
                    );
                }
            }

            $results = array(
                "draw" => 1,
                "recordsTotal" => count($memData),
                "recordsFiltered" => count($memData),
                "data" => $tableRows
            );
        } else {
            $results = array(
                "draw" => 1,
                "recordsTotal" => count($memData),
                "recordsFiltered" => count($memData),
                "data" => $memData
            );
        }


        $results['last_query'] = $results_last_query;
        echo json_encode($results);
    }

    public function getserviceOrderBillingInfo()
    {
        if (!is_null($this->input->post('Pservice_order_id')) && !is_null($this->input->post("Ppatient_id")) && !is_null($this->input->post("PserviceIDS"))) {
            $service_order_id = $this->input->post('Pservice_order_id');
            $confirm_service_given = $this->input->post('confirm_service_given');
            $patient_id = $this->input->post("Ppatient_id");
            $Pservice_no = $this->input->post("Pservice_no");
            $order_id = $this->input->post("Porder_id");
            $serviceIDS = $this->input->post("PserviceIDS");
            $SampleCollectionPathService = $this->input->post("SampleCollectionPathService");


            $billing_transaction = $this->session->user_session->billing_transaction;
            $user_id = $this->session->user_session->id;
            $branch_id = $this->session->user_session->branch_id;
            $company_id = $this->session->user_session->company_id;
            try {
                $this->db->trans_start();
                $tableName = "service_order";
                if ($confirm_service_given == 1) {
                    $data = array('service_provider' => $user_id,
                        'service_given_date' => date('Y-m-d H:i:s'),
					"file_upload_status"=>1,
                        'confirm_service_given' => $confirm_service_given);
                } else {
                    $data = array('service_provider' => NULL,
                        'service_given_date' => NULL,
					"file_upload_status"=>1,
                        'confirm_service_given' => $confirm_service_given);
                }

                $Ids = explode(',', $serviceIDS);
                foreach ($SampleCollectionPathService as $key => $value) {
                    $where = array('id' => $value, 'patient_id' => $patient_id,
                        'branch_id' => $branch_id,
                        'company_id' => $company_id);

                    $this->db->where($where);
                    $update = $this->db->update($tableName, $data);

                    if ($update == true) {

                        $resultObject = $this->db->where($where)->get($tableName);

                        if ($this->db->affected_rows() > 0) {
                            $resultsArray = $resultObject->result();

                            if ($confirm_service_given == 1) {
                                foreach ($resultsArray as $results) {
                                    $total = $results->quantity * $results->price;
                                    $billing_array = array('order_id' => $results->order_number,
                                        'service_id' => $results->service_id,
                                        'service_desc' => $results->service_detail,
                                        'unit' => $results->quantity,
                                        'date_service' => $results->service_given_date,
                                        'total' => $total,
                                        'create_on' => date('Y-m-d H:i:s'),
                                        'create_by' => $results->service_provider,
                                        'rate' => $results->price,
                                        'status' => 1,
                                        'patient_id' => $results->patient_id,
                                        'type' => 3,
                                        'reference_id' => $value,
                                        'branch_id' => $branch_id);
                                    $this->db->insert($billing_transaction, $billing_array);
                                }
                            } else {
                                foreach ($resultsArray as $results) {
                                    $deleteWhere = array('service_id' => $results->service_id,
                                        'service_desc' => $results->service_detail,
                                        'patient_id' => $patient_id,
                                        'type' => 3,
                                        'order_id' => $results->order_number,
                                        'reference_id' => $value,
                                        'branch_id' => $branch_id);
                                    $this->db->where($deleteWhere);
                                    $this->db->delete($billing_transaction);
                                }
                            }
                        }



                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $response['status'] = 201;
                            $response['body'] = "service not confirm";
                        } else {
                            $this->db->trans_commit();
                            $response['status'] = 200;
                            $response['body'] = "service confirm";
                        }
                        // print_r($billing_array);exit();
                    }
                }
				if($Pservice_no == "PATHOLOGY"){
					$name_input = "service_file";

					$upload_path = "uploads";
					$combination = 2;
					$result = $this->upload_file($upload_path, $name_input, $combination);
					// print_r($result);exit();
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
					$dataNewTable=array(
						"service_ids"=>$this->input->post('PserviceIDS'),
						"patient_id"=>$patient_id,
						"branch_id"=>$branch_id,
						"file_uploaded"=>$input_data,
						"created_by"=>$user_id,
					);
					$this->db->insert("pathology_service_transaction_table", $dataNewTable);
				}

                $this->db->trans_complete();
            } catch (Exception $exception) {
                $this->db->trans_rollback();
                $response['status'] = 201;
                $response['body'] = "service not confirm";
            }


        } else {
            $response['status'] = 201;
            $response['body'] = "service not confirm";
        }
        echo json_encode($response);
    }

    public function deleteServiceOrder()
    {
        if (!is_null($this->input->post('service_order_id')) && !is_null($this->input->post('patient_id'))) {
            $service_order_id = $this->input->post('service_order_id');
            $patient_id = $this->input->post('patient_id');

            $billing_transaction = $this->session->user_session->billing_transaction;
            $user_id = $this->session->user_session->id;
            $branch_id = $this->session->user_session->branch_id;
            $company_id = $this->session->user_session->company_id;

            try {
                $this->db->trans_start();
                $tableName = "service_order";
                $where = array('id' => $service_order_id, 'patient_id' => $patient_id,
                    'branch_id' => $branch_id,
                    'company_id' => $company_id);
                $resultObject = $this->db->where($where)->get($tableName);
                if ($this->db->affected_rows() > 0) {
                    $resultsArray = $resultObject->result();
                    $this->db->where($where);
                    $delete = $this->db->delete($tableName);

                    foreach ($resultsArray as $results) {
                        $deleteWhere = array('service_id' => $results->service_id,
                            'service_desc' => $results->service_detail,
                            'patient_id' => $patient_id,
                            'type' => 3,
                            'order_id' => $results->order_number,
                            'reference_id' => $service_order_id,
                            'branch_id' => $branch_id);
                        $this->db->where($deleteWhere);
                        $this->db->delete($billing_transaction);
                    }
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $response['status'] = 201;
                    $response['body'] = "Changes Not Save";
                } else {
                    $this->db->trans_commit();
                    $response['status'] = 200;
                    $response['body'] = "Save Changes";
                }


                $this->db->trans_complete();
            } catch (Exception $exception) {
                $this->db->trans_rollback();
                $response['status'] = 201;
                $response['body'] = "Changes Not Save";
            }


        } else {
            $response['status'] = 201;
            $response['body'] = "service order not deleted";
        }
        echo json_encode($response);
    }

    public function deleteServiceOrder1()
    {
        if (!is_null($this->input->post('service_order_id')) && !is_null($this->input->post('patient_id'))) {
            $billing_id = $this->input->post('service_order_id');
            $patient_id = $this->input->post('patient_id');

            $billing_transaction = $this->session->user_session->billing_transaction;
            $user_id = $this->session->user_session->id;
            $branch_id = $this->session->user_session->branch_id;
            $company_id = $this->session->user_session->company_id;

            try {
                $this->db->trans_start();

                $where = array('id' => $billing_id, 'patient_id' => $patient_id,
                    'branch_id' => $branch_id,
                    'type' => 3);
                $data = array('is_deleted' => 0);
                $this->db->where($where);
                $update = $this->db->update($billing_transaction, $data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $response['status'] = 201;
                    $response['body'] = "Changes Not Save";
                } else {
                    $this->db->trans_commit();
                    $response['status'] = 200;
                    $response['body'] = "Save Changes";
                }


                $this->db->trans_complete();
            } catch (Exception $exception) {
                $this->db->trans_rollback();
                $response['status'] = 201;
                $response['body'] = "Changes Not Save";
            }


        } else {
            $response['status'] = 201;
            $response['body'] = "service order not deleted";
        }
        echo json_encode($response);
    }

    public function getSampleAllPatients()
    {
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        // $patient_table = $this->session->user_session->patient_table;
        $category = $this->input->post('category');
        $tableName = "service_order";
        $where = "where company_id='" . $company_id . "' AND branch_id='" . $branch_id . "' AND service_category='" . $category . "' AND sample_collection=0 group by patient_name";
        $resultObject = $this->ServiceOrderModel->getStandardLabServicesData($tableName, $where);
        // print_r($resultObject);exit();
        $option = "No Data Found";
        if ($resultObject->totalCount > 0) {
            $option = '<option selected disabled>Select Patient</option>';
            $option .= '<option value="">All</option>';

            foreach ($resultObject->data as $key => $value) {
                $option .= '<option value="' . $value->patient_id . '">' . $value->patient_name . '</option>';
            }
            $results['status'] = 200;
            $results['option'] = $option;
        } else {
            $results['status'] = 201;
            $results['option'] = $option;
        }
        echo json_encode($results);
    }

    public function uploadRadioUplodation()
    {
        // print_r($this->input->post());exit();
        $ValidationObject = $this->is_parameter(array("patient_id", "radioServiceIds"));
        if ($ValidationObject->status) {
            $param = $ValidationObject->param;
            // print_r($param->patientId);exit();
            $user_id = $this->session->user_session->id;
            $company_id = $this->session->user_session->company_id;
            $branch_id = $this->session->user_session->branch_id;
            $patient_id = $param->patient_id;
            $radioServiceIds = $param->radioServiceIds;
            $normal_status = $this->input->post('normal_status');
            $radioly_remark = $this->input->post_get('radioly_remark');
            $confirm_service_given = $this->input->post_get('confirm_service_given');
            $sample_pickup = $this->input->post_get('sample_pickup');
            if (is_null($this->input->post('radioly_remark')) && $this->input->post('radioly_remark') == "") {
                $radioly_remark = "";
            }
            if (is_null($this->input->post('normal_status')) && $this->input->post('normal_status') == "") {
                $normal_status = "";
            }
            if (is_null($this->input->post('confirm_service_given')) && $this->input->post('confirm_service_given') == "") {
                $confirm_service_given = 0;
            }

            $name_input = "service_file";

            $upload_path = "uploads";
            $combination = 2;
            $result = $this->upload_file($upload_path, $name_input, $combination);
            // print_r($result);exit();
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
            // print_r($input_data);exit();
            try {
                $this->db->trans_start();
                $tableName = "service_order";
                $billing_transaction = $this->session->user_session->billing_transaction;
                $samplePickupNumber = $this->Global_model->generate_order("select sample_pickup_no from service_order where sample_pickup_no='#id'");
                $Ids = explode(',', $radioServiceIds);
                foreach ($Ids as $key => $value) {
                    $where = array('id' => $value, 'patient_id' => $patient_id);
                    $data = array('file_upload' => $input_data, 'normal_status' => $normal_status, 'Remark' => $radioly_remark, 'service_provider' => $user_id,
                        'service_given_date' => date('Y-m-d H:i:s'),
                        'confirm_service_given' => $confirm_service_given,
                        'sample_pickup' => $sample_pickup,
                        'sample_pickup_date' => date("Y-m-d H:i:s"),
                        'sample_pickup_user_id' => $user_id,
                        'sample_pickup_no' => $samplePickupNumber);
                    $this->db->where($where);
                    $update = $this->db->update($tableName, $data);
                    if ($update == true) {
                        if ($confirm_service_given == 1) {
                            $resultObject = $this->db->where($where)->get($tableName);
                            if ($this->db->affected_rows() > 0) {
                                $resultsArray = $resultObject->result();
                                foreach ($resultsArray as $results) {
                                    $total = $results->quantity * $results->price;
                                    $billing_array = array('order_id' => $results->order_number,
                                        'service_id' => $results->service_id,
                                        'service_desc' => $results->service_detail,
                                        'unit' => $results->quantity,
                                        'date_service' => $results->service_given_date,
                                        'total' => $total,
                                        'create_on' => date('Y-m-d H:i:s'),
                                        'create_by' => $results->service_provider,
                                        'rate' => $results->price,
                                        'status' => 1,
                                        'patient_id' => $results->patient_id,
                                        'type' => 3,
                                        'reference_id' => $value,
                                        'branch_id' => $branch_id,
                                        'final_amount' => $total);
                                    $isExists = $this->db->select("id")->where('reference_id', $value)->get($billing_transaction)->row();
                                    if (is_null($isExists) || empty($isExists)) {
                                        $this->db->insert($billing_transaction, $billing_array);
                                    }

                                }
                            }
                        }
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $response['status'] = 201;
                            $response['body'] = "service not confirm";
                            $result = false;
                        } else {
                            $this->db->trans_commit();
                            $response['status'] = 200;
                            $response['body'] = "Save Changes";
                            $result = true;
                        }
                        // print_r($billing_array);exit();
                    }
                }

                // print_r($billing_array);exit();
                if ($result == true) {
                    $response['status'] = 200;
                    $response['body'] = "Save Changes";
                }
                $this->db->trans_complete();
            } catch (Exception $exception) {
                $this->db->trans_rollback();
                $response['status'] = 201;
                $response['body'] = "service not confirm";
            }


        } else {
            $response["status"] = 201;
            $response["body"] = "Invalid Request";
        }
        echo json_encode($response);
    }

    public function uploadRadioUplodation1()
    {
        // print_r($this->input->post());exit();
        $ValidationObject = $this->is_parameter(array("patient_id", "radioServiceIds"));
        if ($ValidationObject->status) {
            $param = $ValidationObject->param;
            // print_r($param->patientId);exit();
            $user_id = $this->session->user_session->id;
            $company_id = $this->session->user_session->company_id;
            $branch_id = $this->session->user_session->branch_id;
            $patient_id = $param->patient_id;
            $radioServiceIds = $param->radioServiceIds;
            $normal_status = $this->input->post('normal_status');
            $radioly_remark = $this->input->post_get('radioly_remark');
            $confirm_service_given = $this->input->post_get('confirm_service_given');
            $sample_pickup = $this->input->post_get('sample_pickup');
            $serviceBillingIds = $this->input->post_get('serviceBillingIds');
            if (is_null($this->input->post('radioly_remark')) && $this->input->post('radioly_remark') == "") {
                $radioly_remark = "";
            }
            if (is_null($this->input->post('normal_status')) && $this->input->post('normal_status') == "") {
                $normal_status = "";
            }
            if (is_null($this->input->post('confirm_service_given')) && $this->input->post('confirm_service_given') == "") {
                $confirm_service_given = 0;
            }

            $name_input = "service_file";

            $upload_path = "uploads";
            $combination = 2;
            $result = $this->upload_file($upload_path, $name_input, $combination);
            // print_r($result);exit();
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
            // print_r($input_data);exit();
            try {
                $this->db->trans_start();
                $tableName = "service_order";
                $billing_transaction = $this->session->user_session->billing_transaction;
                $samplePickupNumber = $this->Global_model->generate_order("select sample_pickup_no from service_order where sample_pickup_no='#id'");
                // $Ids=explode(',', $radioServiceIds);
                // foreach ($Ids as $key => $value) {
                $where = array('id' => $radioServiceIds, 'patient_id' => $patient_id);
                $data = array('file_upload' => $input_data, 'normal_status' => $normal_status, 'Remark' => $radioly_remark, 'service_provider' => $user_id,
                    'service_given_date' => date('Y-m-d H:i:s'),
                    'confirm_service_given' => $confirm_service_given,
                    'sample_pickup' => $sample_pickup,
                    'sample_pickup_date' => date("Y-m-d H:i:s"),
                    'sample_pickup_user_id' => $user_id,
                    'sample_pickup_no' => $samplePickupNumber);
                $this->db->where($where);
                $update = $this->db->update($tableName, $data);
                if ($update == true) {
                    if ($confirm_service_given == 1) {
                        // $resultObject = $this->db->where($where)->get($tableName);
                        // if ($this->db->affected_rows() > 0) {
                        // 	$resultsArray = $resultObject->result();
                        // 	foreach ($resultsArray as $results) {
                        // 		$total = $results->quantity * $results->price;
                        // 		$billing_array = array('order_id' => $results->order_number,
                        // 			'service_id' => $results->service_id,
                        // 			'service_desc' => $results->service_detail,
                        // 			'unit' => $results->quantity,
                        // 			'date_service' => $results->service_given_date,
                        // 			'total' => $total,
                        // 			'create_on' => date('Y-m-d H:i:s'),
                        // 			'create_by' => $results->service_provider,
                        // 			'rate' => $results->price,
                        // 			'status' => 1,
                        // 			'patient_id' => $results->patient_id,
                        // 			'type' => 3,
                        // 			'reference_id' => $value,
                        // 			'branch_id'=>$branch_id,
                        // 			'final_amount' => $total);
                        // 		$this->db->insert($billing_transaction, $billing_array);
                        // 	}
                        // }
                        $where1 = array('id' => $serviceBillingIds,
                            'patient_id' => $patient_id,
                            'reference_id' => $radioServiceIds);
                        $data1 = array('confirm' => 1);
                        $this->db->where($where1);
                        $update_billing = $this->db->update($billing_transaction, $data1);
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $response['status'] = 201;
                        $response['body'] = "service not confirm";
                        $result = false;
                    } else {
                        $this->db->trans_commit();
                        $response['status'] = 200;
                        $response['body'] = "Save Changes";
                        $result = true;
                    }
                    // print_r($billing_array);exit();
                }
                // }

                // print_r($billing_array);exit();
                if ($result == true) {
                    $response['status'] = 200;
                    $response['body'] = "Save Changes";
                }
                $this->db->trans_complete();
            } catch (Exception $exception) {
                $this->db->trans_rollback();
                $response['status'] = 201;
                $response['body'] = "service not confirm";
            }


        } else {
            $response["status"] = 201;
            $response["body"] = "Invalid Request";
        }
        echo json_encode($response);
    }

    public function getRadiologySampleHistoryTable()
    {
        // print_r("hiiii");exit();
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $patient_table = $this->session->user_session->patient_table;
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;

        // $category="RADIOLOGY";
        $category = $this->input->post('category');
        $patient_id = $this->input->post('patient_id');
        $zone = $this->input->post('zone_id');
        // print_r($zone);exit();
        $where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'service_category' => $category, 'sample_pickup' => 1);
        // if ($patient_id != null && $patient_id != '') {
        // 	$where = array('branch_id' => $branch_id, 'company_id' => $company_id, 'service_category' => $category, 'patient_id' => $patient_id, 'sample_pickup' => 1);
        // }

        $tableName = "service_order so";

        $order = array('id' => 'desc');
        $column_order = array('service_id', 'service_description');
        $column_search = array();
        $select = array("so.*",
            "(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info",
            "(select pt.roomid from " . $patient_table . " pt where  pt.id=so.patient_id) as room_id",
            "(select um.name from users_master um where um.id=so.sample_pickup_user_id) as user_name");
        $this->db->select($select)->where($where);
        $i = 0;
        $search = array('patient_name', 'service_detail', 'order_number');
        // loop searchable columns
        // print_r($_POST['search']['value']);exit();
        foreach ($search as $item) {
            // if datatable send POST for search
            if ($_POST['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                // last loop
                if (count($search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (!is_null($zone)) {
            if ((int)$zone != -1 && $zone != "") {
                $this->db->having('room_id', $zone);
            }
        }
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $memData = $this->db->get($tableName)->result();
        $results_last_query = $this->db->last_query();
        // print_r($results_last_query);
        // $memData = $this->ServiceOrderModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);

        // $query=$this->db->last_query();
        // $filterCount = $this->ServiceOrderModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        // $totalCount=$this->db->select($select)->where($where)->get($tableName)->num_rows();
        $totalCount = $this->ServiceOrderModel->countAll($tableName, $where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {

                $serviceIDArray = array();
                $patient_info = explode('|||', $row->patient_info);
                $patient_name = "";
                $bed_name = "";
                $room_id = "";
                if (count($patient_info) > 1) {
                    $patient_name = $patient_info[0];
                    $bed_name = $patient_info[1];
                    $room_id = $patient_info[2];
                }
                $today = date('Y-m-d');

                if (date('Y-m-d', strtotime($row->order_date)) <= $today) {

                    if ($row->sample_pickup_date != null && $row->sample_pickup_date != "0000-00-00 00:00:00") {
                        // $date = $this->getDate($row->service_given_date);
                        $date = date("Y-m-d h:i:sa", strtotime($row->sample_pickup_date));
                        // $date = new /DateTime($row->service_given_date);
                    } else {
                        $date = "-";
                    }
                    if ($row->user_name != null && $row->user_name != "") {
                        $user = $row->user_name;
                    } else {
                        $user = "-";
                    }
                    if ($row->file_upload != null && $row->file_upload != "") {
                        $file_upload = $row->file_upload;
                    } else {
                        $file_upload = "";
                    }
                    if ($row->normal_status != null && $row->normal_status != "") {
                        $normal_status = $row->normal_status;
                    } else {
                        $normal_status = "-";
                    }
                    if ($row->Remark != null && $row->Remark != "") {
                        $Remark = $row->Remark;
                    } else {
                        $Remark = "-";
                    }
//					if($file_upload!=""){
                    $tableRows[] = array(

                        $bed_name,
                        $patient_name,
                        $row->order_number,
                        $row->service_id,
                        $row->order_number,
                        $row->service_detail,
                        $row->id,
                        $row->service_no,
                        $user,
                        $date,
                        $row->confirm_service_given,
                        $row->id,
                        $row->patient_id,
                        $row->id,
                        $file_upload,
                        $normal_status,
                        $Remark
                    );
//					}
                }
            }

            $results = array(
                "draw" => (int)$_POST['draw'],
                "recordsTotal" => count($memData),
                "recordsFiltered" => $totalCount,
                "data" => $tableRows
            );
        } else {
            $results = array(
                "draw" => (int)$_POST['draw'],
                "recordsTotal" => count($memData),
                "recordsFiltered" => $totalCount,
                "data" => $memData
            );
        }


        $results['last_query'] = $results_last_query;
        echo json_encode($results);
    }

    public function getNotConfirmReport()
    {
        $patient_table = $this->session->user_session->patient_table;
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;

        // $category = "RADIOLOGY";
        $patient_id = $this->input->post('patient_id');
        $zone = $this->input->post('zone_id');
        $confirm_status = $this->input->post('confirm_status');
        $category = $this->input->post('category');


        $chk_count = 1;
        $tableName = "service_order so";
        if ($category == "RADIOLOGY") {
            $memData = $this->ServiceOrderModel->getRadiologyNotConfirmServices($category, $tableName, $hospital_bed_table, $patient_table, $patient_id, $zone, $confirm_status, $chk_count);
        } else if ($category == "PATHOLOGY") {
            $memData = $this->ServiceOrderModel->getPathologyNotConfirmServices($category, $tableName, $hospital_bed_table, $patient_table, $patient_id, $zone, $confirm_status, $chk_count);
        }

        $results_last_query = $this->db->last_query();
        // print_r($results_last_query);exit();
        if (count($memData) > 0) {
            $response['status'] = 200;
        } else {
            $response['status'] = 201;
        }
        echo json_encode($response);

    }

    public function getRadiologyNotConfirmReport()
    {

        $data = $this->input->post_get('data');

        $object = json_decode($data);
        // $category = "RADIOLOGY";
        $patient_id = $this->input->post('patient_id');
        $patient_table = $this->session->user_session->patient_table;
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;
        $zone = $object->zone;
        $confirm_status = $object->confirm_status;
        $category = $object->category;
        if ($confirm_status == 0) {
            $service = "Pending";
        } else {
            $service = "Performed";
        }
        // print_r($zone);exit();
        $chk_count = 0;
        $tableName = "service_order so";
        if ($category == "RADIOLOGY") {
            $memData = $this->ServiceOrderModel->getRadiologyNotConfirmServices($category, $tableName, $hospital_bed_table, $patient_table, $patient_id, $zone, $confirm_status, $chk_count);
        } else if ($category == "PATHOLOGY") {
            $memData = $this->ServiceOrderModel->getPathologyNotConfirmServices($category, $tableName, $hospital_bed_table, $patient_table, $patient_id, $zone, $confirm_status, $chk_count);
        }
        // print_r($memData);exit();
        if (count($memData) > 0) {
            if ($category == "RADIOLOGY") {
                $this->createExcel($memData, 0, $service);
            } else if ($category == "PATHOLOGY") {
                $this->pathologyCreateExcel($memData, 0, $service);
            }
        } else {
            echo json_encode(array("body" => "No data found", "status" => 200));
        }
    }

    public function createExcel($data, $type, $service)
    {
        $this->load->library('excel');
        //$listInfo = $this->export->exportList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->setTitle("Radiology " . $service . " Report");
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bed No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Service Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Service Order No');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Service Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Service Provider');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Date and Time  (dd-Mmm-yy hh:mm AM/PM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Service Status');
        $rowCount = 2;
        $k = 1;
        $service_confirm = $service;
        // if($type==1)
        // {
        // 	$service_confirm="Performed";
        // }
        foreach ($data as $row) {
            $serviceIDArray = array();
            $patient_info = explode('|||', $row->patient_info);
            $patient_name = "";
            $bed_name = "";
            $room_id = "";
            if (count($patient_info) > 1) {
                $patient_name = $patient_info[0];
                $bed_name = $patient_info[1];
                $room_id = $patient_info[2];
            }
            if ($row->service_given_date != null && $row->service_given_date != "0000-00-00 00:00:00") {
                // $date = $this->getDate($row->service_given_date);
                $date = date("Y-m-d h:i:sa", strtotime($row->service_given_date));
                // $date = new /DateTime($row->service_given_date);
            } else {
                $date = "-";
            }
            if ($row->user_name != null && $row->user_name != "") {
                $user = $row->user_name;
            } else {
                $user = "-";
            }
            if ($row->file_upload != null && $row->file_upload != "") {
                $file_upload = $row->file_upload;
            } else {
                $file_upload = "";
            }
            if ($row->normal_status != null && $row->normal_status != "") {
                $normal_status = $row->normal_status;
            } else {
                $normal_status = "-";
            }
            if ($row->Remark != null && $row->Remark != "") {
                $Remark = $row->Remark;
            } else {
                $Remark = "-";
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $bed_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $patient_name);

            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->service_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->order_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->service_detail);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $user);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $date);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $service_confirm);

            $rowCount++;
            $k++;
        }
        // print_r($objPHPExcel);exit();
        ob_end_clean();
        $filename = "Radiology_" . $service . "_Services_" . date("Y-m-d") . "" . time() . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function pathologyCreateExcel($data, $type, $service)
    {
        $this->load->library('excel');
        //$listInfo = $this->export->exportList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->setTitle("Pathology " . $service . " Report");
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Bed No');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Service Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Service Order No');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Service Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Service Provider');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Date and Time  (dd-Mmm-yy hh:mm AM/PM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Service Status');
        $rowCount = 2;
        $k = 1;
        $service_confirm = $service;
        // if($type==1)
        // {
        // 	$service_confirm="Performed";
        // }
        foreach ($data as $row) {
            $serviceIDArray = array();
            $patient_info = explode('|||', $row->patient_info);
            $patient_name = "";
            $bed_name = "";
            $room_id = "";
            if (count($patient_info) > 1) {
                $patient_name = $patient_info[0];
                $bed_name = $patient_info[1];
                $room_id = $patient_info[2];
            }
            if ($row->service_given_date != null && $row->service_given_date != "0000-00-00 00:00:00") {
                // $date = $this->getDate($row->service_given_date);
                $date = date("Y-m-d h:i:sa", strtotime($row->service_given_date));
                // $date = new /DateTime($row->service_given_date);
            } else {
                $date = "-";
            }
            if ($row->user_name != null && $row->user_name != "") {
                $user = $row->user_name;
            } else {
                $user = "-";
            }
            if ($row->file_upload != null && $row->file_upload != "") {
                $file_upload = $row->file_upload;
            } else {
                $file_upload = "";
            }
            if ($row->normal_status != null && $row->normal_status != "") {
                $normal_status = $row->normal_status;
            } else {
                $normal_status = "-";
            }
            if ($row->Remark != null && $row->Remark != "") {
                $Remark = $row->Remark;
            } else {
                $Remark = "-";
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $bed_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $patient_name);

            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->service_code);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->order_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->service_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $user);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $date);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $service_confirm);

            $rowCount++;
            $k++;
        }
        // print_r($objPHPExcel);exit();
        ob_end_clean();
        $filename = "Pathology_" . $service . "_Services_" . date("Y-m-d") . "" . time() . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }



}
