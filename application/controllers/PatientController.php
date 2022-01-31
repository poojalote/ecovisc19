<?php
require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
require_once 'HexaController.php';

/**
 * @property  Patient_Model Patient_Model
 */
class PatientController extends HexaController
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {

        parent::__construct();

        // load model
        $this->load->model('Patient_Model');

        // load base_url
        $this->load->helper('url');

    }

    public function index()
    {
        $this->load->view('admin/patients/view_patients', array("title" => "Patient Details"));
    }


    public function fill()
    {
        $code = $_POST['code'];
        // print_r($code);exit();

        $xml = simplexml_load_string($code);
        echo json_encode($xml);


    }

    public function add_patient()
    {

        if (!is_null($this->input->post("name")) && !is_null($this->input->post("contact"))) {

            if ($this->input->post("adhardetails") == 1 && is_null($this->input->post("adhhar_no"))) {
                $response["status"] = 201;
                $response["body"] = "enter Adhar No";
                echo json_encode($response);
                exit;
            }
            $adhardetails = $this->input->post("adhardetails");
            if ($adhardetails == 1) {
                $adhhar_no = $this->input->post("adhhar_no");
            } else {
                $adhhar_no = "";
            }


            $searchSelectPatient = $this->input->post("searchSelectPatient");

            $patient_name = $this->input->post("name");
            $patient_image = $this->input->post("patient_image");
            $patient_aadhar_image = $this->input->post("patient_adhhar_image");

            $contact = $this->input->post("contact");
            $patientId = $this->input->post("patientId");
            $gender = $this->input->post("gender");
            $birth_day = $this->input->post("birth_day");
            $blood_group = $this->input->post("blood_group");
            $vtc = $this->input->post("vtc");
            $alter_contact = $this->input->post("alter_contact");
            $location = $this->input->post("location");
            $dist = $this->input->post("dist");
            $sub_dist = $this->input->post("sub_dist");
            $postal_code = $this->input->post("postal_code");

            $admission_payer = $this->input->post("admission_payer");
            $patient_company = $this->input->post("patient_company");
            $work_location = $this->input->post("work_location");

            $admission_date = $this->input->post("admission_date");
            $admission_mode = $this->input->post("admission_mode");
            $admission_teleconsult_date = $this->input->post("admission_date");
            $reference_id = $this->input->post("reference_id");
            $doctor_name = $this->input->post("doctor_name");
            $other_location = $this->input->post("other_location");

            $session_data = $this->session->user_session;
            $user_id = $session_data->id;
            $branch_id=$session_data->branch_id;
            $table_name = $session_data->patient_table;
            $code=substr($postal_code, 0, 3);
			if($code == '400'){
				$locality='Mumbai';
			}else{
				$locality='Outside of Mumbai';
			}

            if (is_null($this->input->post("gender")) && $this->input->post("gender") == "") {
                $gender = '';
            }
            if (is_null($this->input->post("birth_day")) && $this->input->post("birth_day") == "") {
                $birth_day = '';
            }
            if (is_null($this->input->post("blood_group")) && $this->input->post("blood_group") == "") {
                $blood_group = '';
            }
            if (is_null($this->input->post("vtc")) && $this->input->post("vtc") == "") {
                $vtc = '';
            }
            if (is_null($this->input->post("alter_contact")) && $this->input->post("alter_contact") == "") {
                $alter_contact = '';
            }
            if (is_null($this->input->post("location")) && $this->input->post("location") == "") {
                $location = '';
            }
            if (is_null($this->input->post("dist")) && $this->input->post("dist") == "") {
                $dist = '';
            }
            if (is_null($this->input->post("sub_dist")) && $this->input->post("sub_dist") == "") {
                $sub_dist = '';
            }
            if (is_null($this->input->post("postal_code")) && $this->input->post("postal_code") == "") {
                $postal_code = '';
            }
            if (is_null($this->input->post("admission_date")) && $this->input->post("admission_date") == "") {
                $admission_date = '';
            }
            if (is_null($this->input->post("admission_mode")) && $this->input->post("admission_mode") == "") {
                $admission_mode = '';
            }
            if (is_null($this->input->post("admission_teleconsult_date")) && $this->input->post("admission_teleconsult_date") == "") {
                $admission_teleconsult_date = '';
            }
            if (is_null($this->input->post("admission_payer")) && $this->input->post("admission_payer") == "") {
                $admission_payer = '';
            }
            if (is_null($this->input->post("patient_company")) && $this->input->post("patient_company") == "") {
                $patient_company = '';
            }
            if (is_null($this->input->post("work_location")) && $this->input->post("work_location") == "") {
                $work_location = '';
            }
            if (is_null($patient_image) && $patient_image == "") {
                $patient_image = "";
            } else {
                $profileImagePath = $this->upload_file_aadhar($patient_image);
                if ($profileImagePath != null) {
                    $patient_image = $profileImagePath;
                }
            }


			if(($admission_mode == 1) && empty($doctor_name)){
				$response["status"] = 201;
				$response["data"] = "Select Doctor Name";
				echo json_encode($response);
				exit;
			}
            if (!empty($patientId)) {
                $update_data = array(
                    'adhar_no' => $adhhar_no,
                    'patient_name' => $patient_name,
                    "gender" => $gender,
                    'birth_date' => $birth_day,
                    'blood_group' => $blood_group,
                    'contact' => $contact,
                    'other_contact' => $alter_contact,
                    'address' => $location,
                    'district' => $dist,
                    'sub_district' => $sub_dist,
                    'pin_code' => $postal_code,
//					'company_id' => $company_id,
                    // 'is_icu_patient' => 2,
                    'payer' => $admission_payer,
                    'patient_company' => $patient_company,
                    'work_location' => $work_location,
                    'modify_on' => date('Y-m-d'),
                    'admission_date' => $admission_date,
                    'admission_mode' => $admission_mode,
                    'tele_consulting_from' => $admission_teleconsult_date,
                    'modify_by' => $user_id,
                    'doctor_name' => $doctor_name,
                    'reference_id' => $reference_id,
                    'other_location' => $other_location,
                    'locality' => $locality,

                );
                if ($patient_image != "") {
                    $update_data["patient_image"] = $patient_image;
                }
                $where = array('id' => $patientId);
                $update = $this->Patient_Model->updateForm($table_name, $update_data, $where);

                if ($adhardetails == 2) {

                    $adhar_no = "A000000" . $patientId;
                    $this->db->where(array("id" => $patientId));
                    $this->db->update($table_name, array("adhar_no" => $adhar_no));
                }
                if ($update == TRUE) {
                    $response["status"] = 200;
                    $response["data"] = "updated successfully";
                } else {
                    $response["status"] = 201;
                    $response["data"] = "Not Updated";
                }
            } else {
                $insert_data = array(
                    'adhar_no' => $adhhar_no,
                    'patient_name' => $patient_name,
                    'patient_adhhar_image' => $patient_aadhar_image,
                    'patient_image' => $patient_image,
                    "gender" => $gender,
                    'birth_date' => $birth_day,
                    'blood_group' => $blood_group,
                    'contact' => $contact,
                    'other_contact' => $alter_contact,
                    'address' => $location,
                    'district' => $dist,
                    'sub_district' => $sub_dist,
                    'pin_code' => $postal_code,
//					'company_id' => $company_id,
                    'payer' => $admission_payer,
                    'patient_company' => $patient_company,
                    'work_location' => $work_location,
                    'is_icu_patient' => 2,
                    'admission_date' => $admission_date,
                    'admission_mode' => $admission_mode,
                    'tele_consulting_from' => $admission_teleconsult_date,
                    'create_on' => date('Y-m-d'),
                    'create_by' => $user_id,
                    'branch_id'=>$branch_id,
                    'doctor_name'=>$doctor_name,
					'reference_id' => $reference_id,
					'other_location' => $other_location,
					'locality' => $locality,
                );
                //$condition = 'where dm.adhar_no="' . $adhhar_no . '" and dm.discharge_date is null';

                if(!is_null($searchSelectPatient) && $searchSelectPatient !==""){
                    $condition = 'where dm.id="' . $searchSelectPatient . '"';
                }else{
                    $condition = 'where dm.adhar_no="' . $adhhar_no . '"  group by adhar_no order by id desc';
                }

                $user_data = $this->Patient_Model->getTableData($table_name, $condition);

                $response["user"] = $user_data;
                if ($user_data->totalCount > 0) {
                    // ipd
                    if ((int)$user_data->data[0]->admission_mode == 2) {

                        if (!is_null($user_data->data[0]->discharge_date)) {
                            // insert
                            $result = $this->Patient_Model->addForm($table_name, $insert_data);
                            $response["table"] = $table_name;
                            if ($result->status == TRUE) {
								$insert_id = $result->inserted_id;
								$patientId=$insert_id;
                                if ($adhardetails == 2) {
                                    $adhar_no = "A000000" . $insert_id;
                                    $this->db->where(array("id" => $insert_id));
                                    $this->db->update($table_name, array("adhar_no" => $adhar_no));
                                }

                                if($branch_id == 9){
									$ref_id="NESA".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else if($branch_id == 10){
                                	$ref_id="MJC".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else if($branch_id == 2){
									 $ref_id="NAG".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else{
                                	$ref_id="";
								}
                                if($ref_id != ""){
									$this->db->where(array("id" => $insert_id));
									$this->db->update($table_name, array("reference_id" => $ref_id));
								}
                                $response["status"] = 200;
                                $response["ref_id"] = $ref_id;
                                $response["branch_id"] = $branch_id;
                                $response["data"] = "uploaded successfully 3";
								$response["patient_id"] = $patientId;
								$response["patient_name"] = $patient_name;
                            } else {
                                $response["status"] = 201;
                                $response["data"] = "Not Uploaded";
                            }
                        } else {
                            $response["status"] = 202;
                            $response["data"] = "Patient already admitted with same aadhar number in IPD";
                        }
                    }

                    if ((int)$user_data->data[0]->admission_mode == 1) {

                        if (!is_null($user_data->data[0]->discharge_date)) {
                            $result = $this->Patient_Model->addForm($table_name, $insert_data);
                            if ($result->status == TRUE) {
								$insert_id = $result->inserted_id;
								$patientId=$insert_id;
                                if ($adhardetails == 2) {
                                    $adhar_no = "A000000" . $insert_id;
                                    $this->db->where(array("id" => $insert_id));
                                    $this->db->update($table_name, array("adhar_no" => $adhar_no));
                                }
								if($branch_id == 9){
									$ref_id="NESA".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else if($branch_id == 10){
									$ref_id="MJC".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else if($branch_id == 2){
									$ref_id="NAG".str_pad($patientId,6,"0",STR_PAD_LEFT);
								}else{
									$ref_id="";
								}
								if($ref_id != ""){
									$this->db->where(array("id" => $insert_id));
									$this->db->update($table_name, array("reference_id" => $ref_id));
								}
                                $response["status"] = 200;
                                $response["data"] = "uploaded successfully ";
								$response["patient_id"] = $patientId;
								$response["patient_name"] = $patient_name;
                            } else {
                                $response["status"] = 201;
                                $response["data"] = "Not Uploaded";
                            }
                        } else {
                            $response["status"] = 201;
                            $response["data"] = "Patient already admitted or bill is not close with same aadhar number in OPD";
                        }
                    }


                } else {

                    // insert
                    $result = $this->Patient_Model->addForm($table_name, $insert_data);
                    if ($result->status == TRUE) {
						$insert_id = $result->inserted_id;
						$patientId=$insert_id;
                        if ($adhardetails == 2) {
                            $adhar_no = "A000000" . $insert_id;
                            $this->db->where(array("id" => $insert_id));
                            $this->db->update($table_name, array("adhar_no" => $adhar_no));
                        }
						if($branch_id == 9){
							$ref_id="NESA".str_pad($patientId,6,"0",STR_PAD_LEFT);
						}else if($branch_id == 10){
							$ref_id="MJC".str_pad($patientId,6,"0",STR_PAD_LEFT);
						}else if($branch_id == 2){
							$ref_id="NAG".str_pad($patientId,6,"0",STR_PAD_LEFT);
						}else{
							$ref_id="";
						}
						if($ref_id != ""){
							$this->db->where(array("id" => $insert_id));
							$this->db->update($table_name, array("reference_id" => $ref_id));
						}
                        if($admission_mode == 2)
                        {
                            $checkSmsStatus = $this->Patient_Model->_select('branch_master',array('id'=>$branch_id,'isSMS'=>1),'*',true);
                            if($checkSmsStatus->totalCount >0)
                            {
                                $this->load->model("SmsModel");
                                $branchData = $checkSmsStatus->data;
                                $this->SmsModel->sendSMS($contact,array("name"=>$patient_name,"center"=>$branchData->name." Center",'bed'=>"",'room'=>""),$template="1107162869085979911");
                            }
                        }
                        $response["status"] = 200;
                        $response["data"] = "uploaded successfully";
						$response["patient_id"] = $patientId;
						$response["patient_name"] = $patient_name;
                    } else {
                        $response["status"] = 201;
                        $response["data"] = "Not Uploaded";
                    }
                }

            }

        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }


        echo json_encode($response);


    }

    public function downloadPatients($type = 0)
    {
//		if (!is_null($this->input->post_get('type'))) {
//			$type = $this->input->post_get('type');
//		} else {
//			$type = 0;
//		}
        // check user role 1 admin to fetch from patient_master other wise form company patient table
        if ($this->session->user_session->roles == 1) {
            $tableName = "patient_master";
            $select = array("*");
        } else {
            $tableName = $this->session->user_session->patient_table . " o";
            $hospital_bed_table = $this->session->user_session->hospital_bed_table;
            $hospital_room_table = $this->session->user_session->hospital_room_table;
            $select = array("*",
                "(select hb.bed_name from " . $hospital_bed_table . " hb where hb.id=bed_id) as bed_name",
                "(select em.sec_4_f_30 from com_1_dep_4 em where em.patient_id=o.id) as emergency_contact",
                "(select hm.sec_38_f_214 from com_1_dep_16 hm where hm.patient_id=o.id) as Nutrition_Notes",
                "(select name from option_master p where p.id=(select hm.sec_38_f_212 from com_1_dep_16 hm where hm.patient_id=o.id)) as Diet_Type",
                "(select name from option_master p where p.id=(select hm.sec_38_f_213 from com_1_dep_16 hm where hm.patient_id=o.id)) as Meal_Type",
                "(select name from option_master p where p.id=(select hm.sec_38_f_262 from com_1_dep_16 hm where hm.patient_id=o.id)) as Meal_Preference",
                "(select group_concat(hb.room_no,'-',hb.ward_no) from " . $hospital_room_table . " hb where hb.id=roomid) as room_name"
            );
        }


        $where = array();
        if ($type == 1) {
            $where["admission_date!="] = "0000-00-00 00:00:00";
            $where["discharge_date"] = null;

        } elseif ($type == 2) {
            $where["discharge_date!="] = "0000-00-00 00:00:00";
        } else if ($type == 4) {
            $where["admission_date="] = "0000-00-00 00:00:00";
        }

        $patientDetails = $this->db->select($select)->where($where)->get($tableName)->result();


        if (is_array($patientDetails)) {
            if (count($patientDetails) > 0) {
                $tableRows = array();
                foreach ($patientDetails as $row) {
                    $mfd = "";
                    if ($row->mark_as_discharge == 1) {
                        $mfd = "Yes";
                    }
                    $room_name = $this->get_room_name($row->roomid);
                    if ($room_name != false) {
                        $room_name = $room_name;
                    } else {
                        $room_name = "";
                    }
                    $age = $this->ageCalculator($row->birth_date);
                    if ($age == 0) {
                        $age = 'NA';
                    }
                    if ($row->gender == 2) {
                        $gender = 'Female';

                    } else {
                        $gender = 'Male';
                    }
                    $tableRows[] = array(
                        $row->adhar_no,
                        $row->patient_name,
                        $row->contact,
                        $row->blood_group,
                        $room_name,
                        $row->bed_name,
                        $row->admission_date,
                        $mfd,
                        $row->discharge_date,
                        $row->emergency_contact,
                        $row->Diet_Type,
                        $row->Meal_Type,
                        $row->event,
                        $row->Nutrition_Notes,
                        $row->id,
                        $age,
                        $gender,
                        $row->Meal_Preference
                    );
                }
                $this->exportPatient($tableRows);
            }
        } else {
            echo json_encode("No Data Found");
        }

    }

    public function exportPatient($data)
    {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Patient Details");
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Patient ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Aadhar Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Age');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Gender');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Contact');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Blood Group');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Zone');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Bed');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Admission Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'MFD');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Discharge Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Emergency Contact');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Diet Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Meal Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Event');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Nutrition Notes');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Meal Preference');

        $rowCount = 2;
        foreach ($data as $pData) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $pData[14]);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $pData[0]);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $pData[1]);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $pData[15]);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $pData[16]);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $pData[2]);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $pData[3]);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $pData[4]);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $pData[5]);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $pData[6]);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $pData[7]);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $pData[8]);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $pData[9]);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $pData[10]);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $pData[11]);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $pData[12]);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $pData[13]);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $pData[17]);
            $rowCount++;
        }
        $filename = "Patient_Details" . date("Y-m-d") . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

    public function getPatientTableData()
    {

        if (!is_null($this->input->post('type'))) {
            $type = $this->input->post('type');
        } else {
            $type = 0;
        }
        if (!is_null($this->input->post('zoneid'))) {
            $zoneid = $this->input->post('zoneid');
        } else {
            $zoneid = 0;
        }

        // check user role 1 admin to fetch from patient_master other wise form company patient table
        if ($this->session->user_session->roles == 1) {
            $tableName = "patient_master";
            $select = array("*");
        } else {
            $tableName = $this->session->user_session->patient_table;
            $hospital_bed_table = $this->session->user_session->hospital_bed_table;
            $hospital_room_table = $this->session->user_session->hospital_room_table;
            $select = array("*",
                "(select hb.bed_name from " . $hospital_bed_table . " hb where hb.id=bed_id) as bed_name", "(select hb1.category from " . $hospital_bed_table . " hb1 where hb1.id=bed_id) as category",
                "(select group_concat(hb.room_no,'-',hb.ward_no) from " . $hospital_room_table . " hb where hb.id=roomid) as room_name"
            );
        }

        $permission_array = $this->session->user_permission;
        $permit = 0;
        if (in_array("patient_list", $permission_array)) {
            $permit = 1;
        }
        $where = array();
        $where_or = null;
        $where["type="] = 1;
        if ($type == 1) {
            $where["admission_date!="] = "0000-00-00 00:00:00";
            $where["discharge_date"] = null;
            $where_or["discharge_date"] = "0000-00-00 00:00:00";
            $where["type="] = 1;
//			$where["is_icu_patient!="] = 3;

        } elseif ($type == 2) {
            $where["discharge_date!="] = "0000-00-00 00:00:00";
            $where["type="] = 1;
            $where["billing_open"] = 0;
        } else if ($type == 4) {
            $where["admission_date="] = "0000-00-00 00:00:00";
            $where["type="] = 1;
        } else if ($type == 5) {
            $where["type="] = 2;

        } else if ($type == 7) {
            $where["billing_open"] = 1;
            $where["type="] = 1;
        }
        /* else if ($type == 6) {
            $where["admission_date!="] = "0000-00-00 00:00:00";
            $where["discharge_date"] = null;
            $where["is_icu_patient="] = 3;
            $where["type="] = 1;

        } */
        if ($zoneid != "-1" && $zoneid != "") {
            $where["roomid"] = $zoneid;
        }


        $order = array('id' => 'desc');
        $column_order = array('patient_name', 'contact', 'adhar_no');
        $column_search = array("patient_name", 'adhar_no', 'contact');

        $memData = $this->Patient_Model->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order, null, $where_or);

        $query = $this->db->last_query();
        $filterCount = $this->Patient_Model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->Patient_Model->countAll($tableName, $where);

        if (count($memData) > 0) {

            $tableRows = array();
            foreach ($memData as $row) {

                $profile_img = $row->patient_image !== "" ? $row->patient_image : base_url("assets/img/avatar/avatar-1.png");
                $mfd = "";
                if ($row->mark_as_discharge == 1) {
                    $mfd = "Discharged";
                }
                $room_name = $this->get_room_name($row->roomid);
                if ($room_name != false) {
                    $room_name = $room_name;
                } else {
                    $room_name = "";
                }

                if ($row->category == 2) {
                    $is_icu_patient = 3;
                } else {
                    $is_icu_patient = 2;
                }
                $age = $this->ageCalculator($row->birth_date);
                if ($age == 0) {
                    $age = 'NA';
                }
                if ($row->gender == 2) {
                    $gender = $age . ' / Female';

                } else {
                    $gender = $age . ' / Male';
                }

                $tableRows[] = array(
                    $row->adhar_no,
                    $row->patient_name,
                    $row->contact,
                    $row->blood_group,
                    $row->bed_name,
                    $row->id,
//					$row->company_id,
                    $is_icu_patient,
                    $this->session->user_session->roles,
                    $profile_img,
                    $row->admission_mode,
                    $row->admission_date,
                    $mfd,
                    $room_name,
                    $permit,
                    $row->type,
                    $gender

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
        $results["query"] = $query;
        echo json_encode($results);

    }

    public function getPatientTableDataZone()
    {

        if (!is_null($this->input->post('zoneid'))) {
            $zoneid = $this->input->post('zoneid');
        } else {
            $zoneid = 0;
        }
        if (!is_null($this->input->post_get('type'))) {
            $type = $this->input->post_get('type');
        } else {
            $type = 0;
        }


        // check user role 1 admin to fetch from patient_master other wise form company patient table
        if ($this->session->user_session->roles == 1) {
            $tableName = "patient_master";
            $select = array("*");
        } else {
            $tableName = $this->session->user_session->patient_table;
            $hospital_bed_table = $this->session->user_session->hospital_bed_table;
            $hospital_room_table = $this->session->user_session->hospital_room_table;
            // print_r($hospital_room_table);exit();
            $select = array("*", "(select hb.bed_name from " . $hospital_bed_table . " hb where hb.id=bed_id) as bed_name", "(select hb1.category from " . $hospital_bed_table . " hb1 where hb1.id=bed_id) as category");
        }
        $permission_array = $this->session->user_permission;
        $permit = 0;
        if (in_array("patient_list", $permission_array)) {
            $permit = 1;
        }

        $where = array();
        $where["type="] = 1;
        if ($type == 1) {
            $where["admission_date!="] = "0000-00-00 00:00:00";
            $where["discharge_date"] = null;
            $where["type="] = 1;

        } elseif ($type == 2) {
            $where["discharge_date!="] = "0000-00-00 00:00:00";
            $where["type="] = 1;
        } else if ($type == 4) {
            $where["admission_date="] = "0000-00-00 00:00:00";
            $where["type="] = 1;
        } else if ($type == 5) {
            $where["type="] = 2;
        } else if ($type == 7) {
            $where["billing_open"] = 1;
            $where["type="] = 1;
        }
        if ($zoneid != "-1") {
            $where["roomid"] = $zoneid;
        }


        $order = array('id' => 'desc');
        $column_order = array('patient_name', 'contact', 'adhar_no');
        $column_search = array("patient_name", 'adhar_no', 'contact');

        $memData = $this->Patient_Model->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);


        $filterCount = $this->Patient_Model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->Patient_Model->countAll($tableName, $where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {
                $profile_img = $row->patient_image !== "" ? $row->patient_image : base_url("assets/img/avatar/avatar-1.png");
                $mfd = "";
                if ($row->mark_as_discharge == 1) {
                    $mfd = "Discharged";
                }
                $room_name = $this->get_room_name($row->roomid);
                if ($room_name != false) {
                    $room_name = $room_name;
                } else {
                    $room_name = "";
                }

                if ($row->category == 2) {
                    $is_icu_patient = 3;
                } else {
                    $is_icu_patient = 2;
                }
                $age = $this->ageCalculator($row->birth_date);
                if ($age == 0) {
                    $age = 'NA';
                }
                if ($row->gender == 2) {
                    $gender = $age . ' / Female';

                } else {
                    $gender = $age . ' / Male';
                }
                $tableRows[] = array(
                    $row->adhar_no,
                    $row->patient_name,
                    $row->contact,
                    $row->blood_group,
                    $row->bed_name,
                    $row->id,
                    $is_icu_patient,
                    $this->session->user_session->roles,
                    $profile_img,
                    $row->admission_mode,
                    $row->admission_date,
                    $mfd,
                    $room_name,
                    $permit,
                    $row->type,
                    $gender
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

    function get_room_name($id)
    {
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $query = "select * from " . $hospital_room_table . " where id=" . $id;
        $q = $this->db->query($query);
        if ($this->db->affected_rows() > 0) {
            return $q->row()->room_no . ' ' . $q->row()->ward_no;
        } else {
            return false;
        }
    }

    public function getPatientDataById()
    {

        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');

            $session_data = $this->session->user_session;

//			$company_id = $session_data->company_id;

            $tableName = $this->session->user_session->patient_table;// 'com_' . $company_id . '_patient';
            //$where=array("id"=>$patientId);
            $where = "where dm.id='" . $patientId . "'";
            $resultObject = $this->Patient_Model->getTableData($tableName, $where);

            if ($resultObject->totalCount > 0) {
                $response["status"] = 200;
                $response["body"] = $resultObject->data;
            } else {
                $response["status"] = 201;
                $response["body"] = "Data Not Found";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function deletePatient()
    {
        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $session_data = $this->session->user_session;

            $user_id = $session_data->id;
            $company_id = $session_data->company_id;
            $tableName = $this->session->user_session->patient_table;//'com_' . $company_id . '_patient';
            $departmentData = array('status' => 0, 'modify_on' => date('Y-m-d'), "modify_by" => $user_id);
            $where = array('id' => $patientId);

            $result = $this->Patient_Model->deletePatient($tableName, $departmentData, $where);
            if ($result == TRUE) {
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

    public function delete_Patient()
    {
        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $session_data = $this->session->user_session;
            $user_id = $session_data->id;
            $company_id = $session_data->company_id;
            $branch_id = $session_data->branch_id;
            $tableName = $this->session->user_session->patient_table;
            $getPdata = $this->Patient_Model->getpatientdata($patientId, $tableName, $branch_id);
            if ($this->db->affected_rows() > 0) {

                $data_array = array(
                    "branch_id" => $getPdata->branch_id,
                    "company_id" => $company_id,
                    "deleted_by" => $user_id,
                    "deleted_on" => date('Y-m-d h:i:s'),
                    "admission_date" => $getPdata->admission_date,
                    "admission_mode" => $getPdata->admission_mode,
                    "tele_consulting_from" => $getPdata->tele_consulting_from,
                    "is_icu_patient" => $getPdata->is_icu_patient,
                    "adhar_no" => $getPdata->adhar_no,
                    "patient_name" => $getPdata->patient_name,
                    "gender" => $getPdata->gender,
                    "birth_date" => $getPdata->birth_date,
                    "blood_group" => $getPdata->blood_group,
                    "contact" => $getPdata->contact,
                    "other_contact" => $getPdata->other_contact,
                    "address" => $getPdata->address,
                    "district" => $getPdata->district,
                    "sub_district" => $getPdata->sub_district,
                    "patient_image" => $getPdata->patient_image,
                    "patient_adhhar_image" => $getPdata->patient_adhhar_image,
                    "pin_code" => $getPdata->pin_code,
                    "create_on" => $getPdata->create_on,
                    "create_by" => $getPdata->create_by,
                    "status" => $getPdata->status,
                    "bed_id" => $getPdata->bed_id,
                    "roomid" => $getPdata->roomid,
                    "patient_id" => $getPdata->id,
                    "discharge_date" => $getPdata->discharge_date,
                    "diagnostic" => $getPdata->diagnostic,
                    "treated_hospital" => $getPdata->treated_hospital,
                    "course_hospital" => $getPdata->course_hospital,
                    "followup_date" => $getPdata->followup_date,
                    "swab_report" => $getPdata->swab_report,
                    "significant_event" => $getPdata->significant_event,
                    "type" => $getPdata->type,
                    "discharge_condition" => $getPdata->discharge_condition,
                    "mark_as_discharge" => $getPdata->mark_as_discharge,
                    "transfer_reason" => $getPdata->transfer_reason,
                    "transfer_to" => $getPdata->transfer_to,
                    "is_transfered" => $getPdata->is_transfered,
                    "medication" => $getPdata->medication,
                    "urgent_care" => $getPdata->urgent_care,
                    "physical_activity" => $getPdata->physical_activity,
                );

                $insert_data = $this->Patient_Model->delete_insert_data($data_array, $tableName, $patientId);
                if ($insert_data == true) {
                    $response["status"] = 200;
                    $response["body"] = "Deleted Successfully";
                } else {
                    $response["status"] = 201;
                    $response["body"] = "Falied to delete.";
                }
            } else {
                $response["status"] = 201;
                $response["body"] = "No data found";
            }

        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function search()
    {
        // print_r($id);
        if (!is_null($this->input->post('adhar_no')) && $this->input->post('adhar_no') != "") {
            $session_data = $this->session->user_session;

            $user_id = $session_data->id;
            $company_id = $session_data->company_id;
            $tableName = $this->session->user_session->patient_table;//'com_' . $company_id . '_patient';
            $id = $this->input->post('adhar_no');

            //$condition = array("adhhar_no"=>$id);
            $condition = 'where dm.adhar_no="' . $id . '" and dm.discharge_date is null';
            //$table_name= "patient_master";
            $user_data = $this->Patient_Model->getTableData($tableName, $condition);

            if ($user_data->totalCount > 0) {
                $response["status"] = 201;
                $response["messageBody"] = "Patient Already Admitted";
                $response["body"] = $user_data->data;
            } else {
                $response["status"] = 200;
                $response["body"] = $user_data->data;
//                $response["messageBody"] = "";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Not Data Found";
        }
        //$response['xml_arr']=$user_data;
        echo json_encode($response);

    }

    public function searchPatient()
    {
        $header = $this->is_parameter(array("searchValue"));
        if ($header->status) {
            $searchValue = $header->param->searchValue;

            $tableName = $this->session->user_session->patient_table;

//			$this->db->group_start();
//            $this->db->like("upper(adhar_no)", strtoupper($searchValue),'after');
//            $this->db->or_like("upper(patient_name)", strtoupper($searchValue),'after');
////			$this->db->group_end();
//            $this->db->order_by('id', 'DESC');
//            $this->db->group_by("adhar_no");
//            $this->db->limit(10, 0);
            $user_data = $this->db->query("select * from com_2_patient p join (
select  max(id) as id from `com_2_patient` WHERE upper(adhar_no) LIKE '".strtoupper($searchValue)."%' ESCAPE '!'OR  upper(patient_name) LIKE '".strtoupper($searchValue)."%' ESCAPE '!' group by adhar_no) t 
on p.id= t.id")->result();
//            $user_data = $this->db->get($tableName)->result();
            $response["query"] = $this->db->last_query();
            if (count($user_data) > 0) {
                $response["status"] = 200;
                $response["body"] = $user_data;
            } else {
                $response["status"] = 201;
                $response["body"] = "Not Found";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Not Found";
        }
        echo json_encode($response);
    }

//	public function upload_file()
//	{
//		$filename = 'pic_'.date('YmdHis') . '.jpeg';
//		if( move_uploaded_file($_FILES['webcam']['tmp_name'],'uploads/patient_profiles/'.$filename) ){
//
//			echo $filename;
//		}
//	}

    public function upload_file_aadhar($data)
    {
        $filename = 'pic_' . date('YmdHis') . '.jpeg';
        if (move_uploaded_file($data, 'uploads/patient_aadhar/' . $filename)) {

            return $filename;
        }
        return null;
    }

    public function patientDischarge()
    {
        $validationObject = $this->is_parameter(array("patient_id"));

        if ($validationObject->status) {

            $patient_id = $validationObject->param->patient_id;

            $patient_table = $this->session->user_session->patient_table;
            $bedTable = $this->session->user_session->hospital_bed_table;
            $discharge_date = $this->input->post("discharge_date");
            /* $patient_diagnostic = $this->input->post("patient_diagnostic");
            $patient_treated_hospital = $this->input->post("patient_treated_hospital");
            $patient_course_hospital = $this->input->post("patient_course_hospital");

            $patient_swab_report = $this->input->post("patient_swab_report"); */
            $patient_follow_up = $this->input->post("patient_follow_up");
            $sign_event = $this->input->post("sign_event");
            $cndn_discharge_time = $this->input->post("cndn_discharge_time");
            $medication = $this->input->post("medication");
            $physical_activity = $this->input->post("physical_activity");
            $urgent_care = $this->input->post("urgent_care");
            $is_transfer = $this->input->post("is_transfer");
             $medication_auto = $this->input->post("medication_auto");

            $event = $this->input->post("event");
            $trasfer_to = "";
            $trans_reason = "";
            if ($is_transfer == 1) {
                $trasfer_to = $this->input->post("trasfer_to");
                $trans_reason = $this->input->post("trans_reason");
            }

            $dischargeData = array(
                "discharge_date" => $discharge_date,
                "significant_event" => $sign_event,
                "discharge_condition" => $cndn_discharge_time,
                "medication" => $medication,
                "physical_activity" => $physical_activity,
                "followup_date" => $patient_follow_up,
                "urgent_care" => $urgent_care,
                "is_transfered" => $is_transfer,
                "transfer_to" => $trasfer_to,
                "transfer_reason" => $trans_reason,
                "event" => $event,
                "hospital_medication" => $medication_auto,
                /* "diagnostic" => $patient_diagnostic,
                "treated_hospital" => $patient_treated_hospital,
                "course_hospital" => $patient_course_hospital,
                "followup_date" => $patient_follow_up,
                "swab_report" => $patient_swab_report, */
            );
            $where = array("id" => $patient_id, "status" => 1);

            $resultObject = $this->Patient_Model->dischargePatient($patient_table, $dischargeData, $where, $patient_id, $bedTable);
            if ($resultObject) {
                $response["status"] = 200;
                $response["body"] = "Save Changes";
            } else {
                $response["status"] = 201;
                $response["body"] = "Failed To Save";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Failed To Save";
        }
        echo json_encode($response);

    }

    public function ageCalculator($dob)
    {
        //echo $dob;

        if (!empty($dob) && $dob !== "0000-00-00") {
            $birthdate = new DateTime($dob);
            $today = new DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return 0;
        }
    }

    public function get_patient_data($id)
    {
//	$id=$this->input->post('id');
        $query = $this->Patient_Model->getpatientdata($id, $this->session->user_session->patient_table, $this->session->user_session->branch_id);

        if ($query != false) {
            $patient_name = $query->patient_name;
            $patient_id = $query->id;
            $genderC = $query->gender;

            $dob = $query->birth_date;
            $age = $this->ageCalculator($dob);
            $attend_phy = 'NA';
            if ($genderC == 2) {
                $gender = "Female";
            } else {
                $gender = "Male";
            }
            //$gender = 'NA';
            $digits = 10;
            $case_number = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $barcode = $this->create_barcode($case_number);

            $info = array("name" => $patient_name,
                "Patient_id" => $patient_id,
                "age_sex" => $age . "/" . $gender,
                "attn_phy" => $attend_phy,
                "id_mark" => "",
                "case_no" => $case_number,
                "dob" => $dob);
            $html = '<!DOCTYPE html>';
            $html .= '<html lang="en" >';
            $html .= '<head>';

            $html .= '<style>    
	
        
    </style>';
            $html .= '<style>@page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }<style>';
            $html .= '</head>';
            $html .= '<body style="font-size: 11px;font-family: Arial, sans-serif;padding:0px 8px; ">';

            $html .= '<div  style="font-size: 11px;font-family:Arial, sans-serif;">';
            $html .= '<table style="border-spacing: 1px;">';
            $html .= '<tr>';
            $html .= '<td><label style="font-weight: bold;font-size: 11px;font-family: Arial, sans-serif;">Name  </label></td>';
            $html .= '<td  colspan="4">: ' . $info['name'] . '</td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td><label style="font-weight: bold;">Patient Id  </label></td>';
            $html .= '<td>: ' . $info['Patient_id'] . '</td>';
            $html .= '<td><label style="font-weight: bold;margin-left: 50px;">Case No </label></td>';
            $html .= '<td>: ' . $info['case_no'] . '</td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td><label style="font-weight: bold;">Age/Sex  </label></td>';
            $html .= '<td>: ' . $info['age_sex'] . '</td>';
// $html.='<td></td>';
            $html .= '<td><label style="font-weight: bold;margin-left: 50px;">D.O.B  </label></td>';
            $html .= '<td>: ' . $info['dob'] . '</td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td><label style="font-weight: bold;">Attn. Phy.  </label></td>';
            $html .= '<td>: ' . $info['attn_phy'] . '</td>';
            $html .= '<td colspan="2"><img src="' . $barcode . '" style="margin-left: 20px;" width="170" height="18"></td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td><label style="font-weight: bold;">ID Mark  </label></td>';
            $html .= '<td>: ' . $info['id_mark'] . '</td>';
            $html .= '</tr>';

            $html .= '</table>';

            $html .= '</div>';
            $html .= '</body>';
            $html .= '</html>';

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->set_option('isHtml5ParserEnabled', true);
            $dompdf->setPaper(array(0, 0, 255.1176, 67.3592));

            $dompdf->render();
            $dompdf->stream("Patient Information", array('Attachment' => 0));

        } else {

        }
    }

    function barcodeImg()
    {
        $this->load->view("barcode");
    }

    function create_barcode($case_number)
    {
        $string = trim($case_number);

        // $string = trim($_POST['string']);
        $type = "code128";
        $orientation = "horizontal";
        $size = 30;
        $print = true;

        if ($string != '') {

            $base64image = '<img class="barcode" id="imageprev"  style="weidth:300px;height:70px;" alt="' . $string . '" src="barcode.php?text=' . $string . '&codetype=' . $type . '&orientation=' . $orientation . '&size=' . $size . '&print=' . $print . '" />';
        } else {
            $base64image = '';
        }

        // print_r($base64image);
//		echo base_url("barcode?text=$string&codetype=$type&orientation=$orientation&size=$size&print= $print");
//		exit();
//		$barcode=file_get_contents(base_url("barcode?text=$string&codetype=$type&orientation=$orientation&size=$size&print= $print"));
//		var_dump($barcode);
//		exit();
        $barcode = $this->generatorBarcode($case_number);
        return $barcode;
//		var_dump($barcode);
//		echo $barcode;
//		exit();
//		$codeimge='uploads/barcode/'.$case_number.'.png';
//		file_put_contents($codeimge, $barcode);
//		return $codeimge;
    }


    function generatorBarcode($text)
    {


        $code_type = "code128b";
        $orientation = "horizontal";
        $size = 60;
        $print = true;

// For demonstration purposes, get pararameters that are passed in through $_GET or set to the default value
        $filepath = "";
//		$text = (isset($_GET["text"]) ? $_GET["text"] : "0");
//		$size = (isset($_GET["size"]) ? $_GET["size"] : "20");
//		$orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
//		$code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");

        $sizefactor = "1";

// This function call can be copied into your project and can be made from anywhere in your code
        return $this->barcode($filepath, $text, $size, $orientation, $code_type, $print, $sizefactor);


    }

    function barcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false, $SizeFactor = 1)
    {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }

            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");

            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }

            for ($X = 1; $X <= strlen($text); $X += 2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }

            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (integer)(substr($code_string, ($i - 1), 1));
        }

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length * $SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $SizeFactor;
        }

        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1));
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
//		if ($filepath == "") {
//			header('Content-type: image/png');
        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();
        $base64 = 'data:image/png;base64,' . base64_encode($image_data);
        return $base64;
//			imagedestroy($image);
//		} else {
//			imagepng($image, $filepath);
//			imagedestroy($image);
//		}
    }

    public function getZoneData()
    {
        $hospital_room_table = $this->session->user_session->hospital_room_table;
        $branch_id = $this->session->user_session->branch_id;
        $sql = "select * from " . $hospital_room_table . " where branch_id=" . $branch_id;
        $query = $this->db->query($sql);
        $option = "<option selected disabled>Select Zone</option><option value='-1'>All</option>";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            foreach ($result as $row) {
                $option .= '<option value="' . $row->id . '">' . $row->room_no . ' ' . $row->ward_no . '</option>';
            }
            $response['status'] = 200;
            $response['data'] = $option;
        } else {
            $response['status'] = 200;
            $response['data'] = $option;
        }
        echo json_encode($response);
    }

    function getDoctorList(){
		$branch_id = $this->session->user_session->branch_id;
		$query=$this->db->query("select id,name from users_master where roles=2 AND branch_id=".$branch_id);
		$option = "<option selected disabled>Select Doctor Name</option>";
		if ($this->db->affected_rows() > 0) {
			$result = $query->result();
			foreach ($result as $row) {
				$option .= '<option value="' . $row->id . '">' . $row->name . '</option>';
			}
			$response['status'] = 200;
			$response['data'] = $option;
		} else {
			$response['status'] = 200;
			$response['data'] = $option;
		}
		echo json_encode($response);
	}


	public function get_patient_history_data()
	{
		$this->load->model('Formmodel');
		$table_name = $this->input->post('table_name');
		$patient_id = $this->input->post('patient_id');
		$section_id = $this->input->post('section_id');
		$branch_id = $this->session->user_session->branch_id;
		$resultTemplateObject = $this->Formmodel->getHistoryTableColumn($section_id);
		$labelArray = array();
		$dataArray = array();
		$transArray = array();
		$data = "";
		$optionsValue = array();
		if ($resultTemplateObject->totalCount > 0) {
			$data = "<table class='table table-responsive' style='width:100%' id='history_table_" . $section_id . "'><thead>";
			foreach ($resultTemplateObject->data as $column) {
				$data .= "<th>" . $column->name . "</th>";
				if ((int)$column->ans_type == 3) {
					$options = $this->Formmodel->get_all_options($column->id);
					if (is_array($options)) {
						$optionsValue[$column->field_name] = $options;
					}
				}
				if ((int)$column->ans_type == 4) {
					$options = $this->Formmodel->get_all_options($column->id);
					if (is_array($options)) {
						$optionsValue[$column->field_name] = $options;
					}
				}

				if ((int)$column->ans_type == 6) {
					array_push($labelArray, $column->name);
				}
			}
			$totalColumn = count($resultTemplateObject->data);
			$response["transColumnIndex"] = $totalColumn;
			$data .= "<th>Date</th>";
			$data .= "</thead><tbody>";
			$resultObject = $this->Formmodel->history_data($table_name, array("patient_id" => $patient_id, "branch_id" => $branch_id));
			$response["query"] = $this->db->last_query();
			// print_r($resultObject);exit();
			if (count($resultObject) > 0) {
				foreach ($resultObject as $recordIndex => $record) {
					$row = (array)$record;
					$td = "";
					$count = 0;
					foreach ($resultTemplateObject->data as $column) {
						$value = $row[$column->field_name];
						if ((int)$column->ans_type == 7) {
							if ($row[$column->field_name] != "" && $row[$column->field_name] != null)
								$value = '<a href="' . base_url($row[$column->field_name]) . '" class="btn btn-link" download><i class="fa fa-download"></i> Download</a>';
						}

						if ((int)$column->ans_type == 4) {
							$option = $optionsValue[$column->field_name];
							if (is_array($option)) {
								foreach ($option as $optionValues) {
									if ($optionValues->id == $value) {
										$value = $optionValues->name;
										break;
									}
								}
							}
						}
						if ((int)$column->ans_type == 3) {
							$option = $optionsValue[$column->field_name];
							if (is_array($option)) {
								foreach ($option as $optionValues) {
									if ($optionValues->id == $value) {
										$value = $optionValues->name;
										break;
									}
								}
							}
						}
						if ($value != "" && $value != null) {
							$td .= "<td>" . $value . "</td>";
							$dataArray[$column->name][date('jS M H:i:a', strtotime($row['trans_date']))] = $row[$column->field_name];
							$count = 1;
						} else {
							$td .= "<td></td>";
						}
					}
					$edit_btn = '';
					$permission_array = $this->session->user_permission;
//					if (in_array("history_update", $permission_array)) {
//						$edit_btn = "<button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editHistoryModal'  data-patient_id='" . $patient_id . "' data-section_id='" . $section_id . "' data-history_id='" . $record->id . "' id='editSectionButton_" . $section_id . "'><i class='fa fa-edit'></i></button>";
//					} else {
//						//$edit_btn="<button class='btn btn-primary btn-sm'id='editSectionButton_" . $section_id . "' disabled><i class='fa fa-edit'></i></button>";
//					}
					if ($count == 1) {
						$data .= "<tr>";
						$data .= $td;
						$data .= "<td>" . date('d/m H:i:a', strtotime($row['trans_date'])) . "</td>";
//						$data .= "<td>" . $edit_btn . "</td>";
						$data .= "</tr>";
						array_push($transArray, date('jS M H:i:a', strtotime($row['trans_date'])));
					}

				}
			}
			$data .= "</tbody></table>";
		}

		$response["table"] = $data;
		$response["label"] = $labelArray;
		$response["trans"] = $transArray;
		$response["data"] = $dataArray;

		echo json_encode($response);
	}
}
