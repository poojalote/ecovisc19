<?php
require_once "./vendor/autoload.php";

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');
require_once 'HexaController.php';

/**
 * @property  Patient_Model Patient_Model
 */
class LabPatientController extends HexaController
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

    public function lab_patient($id = 0)
    {
        $this->load->view("admin/patients/labpatient_form", array("title" => "Lab Patients", "patient_id" => $id));
    }

    public function labpatientInfo()
    {
        $this->load->view('patient/labpatientInfo', array("title" => "Patient Details"));
    }

    public function labpatient_report($department_id = 0, $section_id = 0, $QueryParamter = null)
    {
        $this->load->view('patient/labpatient_report', array("title" => "Lab Report", "department_id" => $department_id, "section_id" => $section_id, "queryParam" => $QueryParamter));
    }

    public function master_package($department_id = 0, $section_id = 0, $QueryParamter = null)
    {
        $this->load->view('LabCenter/master_package', array("title" => "Setup Package", "department_id" => $department_id, "section_id" => $section_id, "queryParam" => $QueryParamter));
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
        // print_r($this->input->post());exit();
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
            $admission_date = $this->input->post("admission_date");

            $session_data = $this->session->user_session;
            $user_id = $session_data->id;
//            $table_name = 'lab_patient';

            $table_name=$this->session->user_session->lab_patient_table;

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

            if (is_null($patient_image) && $patient_image == "") {
                $patient_image = "";
            } else {
                $profileImagePath = $this->upload_file_aadhar($patient_image);
                if ($profileImagePath != null) {
                    $patient_image = $profileImagePath;
                }
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
                    'admission_date' => $admission_date,
                    'modify_on' => date('Y-m-d'),

                    'modify_by' => $user_id

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
                    'admission_date' => $admission_date,
                    'is_icu_patient' => 2,
                    'create_on' => date('Y-m-d'),
                    'create_by' => $user_id
                );
                if ($adhhar_no != "") {
                    $condition = 'where dm.adhar_no="' . $adhhar_no . '" and dm.discharge_date is null';

                    $user_data = $this->Patient_Model->getTableData($table_name, $condition);
                } else {
                    $user_data = new stdClass();
                    $user_data->totalCount = 0;
                }

                if ($user_data->totalCount == 0) {

                    $result = $this->Patient_Model->addForm($table_name, $insert_data);
                    if ($result->status == TRUE) {
                        if ($adhardetails == 2) {
                            $insert_id = $result->inserted_id;
                            $adhar_no = "A000000" . $insert_id;
                            $this->db->where(array("id" => $insert_id));
                            $this->db->update($table_name, array("adhar_no" => $adhar_no));
                        }
                        $response["status"] = 200;
                        $response["data"] = "uploaded successfully";
                    } else {
                        $response["status"] = 201;
                        $response["data"] = "Not Uploaded";
                    }
                } else {
                    $response["status"] = 201;
                    $response["data"] = "Patient already admitted with same aadhar number";
                }

            }

        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }


        echo json_encode($response);


    }

    public function upload_file_aadhar($data)
    {
        $filename = 'pic_' . date('YmdHis') . '.jpeg';
        if (move_uploaded_file($data, 'uploads/patient_aadhar/' . $filename)) {

            return $filename;
        }
        return null;
    }

    public function searchPatient()
    {
        $header = $this->is_parameter(array("searchValue"));
        if ($header->status) {
            $searchValue = $header->param->searchValue;
            $lab_patient = $this->session->user_session->lab_patient_table;
            $tableName =  $lab_patient;
            $user_data = $this->db->query("select * from " . $tableName . " p join (
                select  max(id) as id from " . $tableName . " WHERE upper(adhar_no) LIKE '" . strtoupper($searchValue) . "%' ESCAPE '!'OR  upper(patient_name) LIKE '" . strtoupper($searchValue) . "%' ESCAPE '!' group by adhar_no) t 
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

    public function getPatientDataById()
    {

        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $session_data = $this->session->user_session;

//			$company_id = $session_data->company_id;

            $tableName = $this->session->user_session->lab_patient_table;
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

    public function getLabPatientTableData()
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
            $tableName = "lab_patient";
            $select = array("*");
        } else {
//            $tableName = 'lab_patient';
            $tableName = $this->session->user_session->lab_patient_table;
//            $hospital_bed_table = $this->session->user_session->hospital_bed_table;
//            $hospital_room_table = $this->session->user_session->hospital_room_table;
            $select = array("*",
//                "(select hb.bed_name from " . $hospital_bed_table . " hb where hb.id=bed_id) as bed_name", "(select hb1.category from " . $hospital_bed_table . " hb1 where hb1.id=bed_id) as category",
//                "(select group_concat(hb.room_no,'-',hb.ward_no) from " . $hospital_room_table . " hb where hb.id=roomid) as room_name"
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
            $where["billing_open"] = 0;

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
        } else if ($type == 8) {
            $where["admission_mode="] = 1;
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

//                if ($row->category == 2) {
//                    $is_icu_patient = 3;
//                } else {
//                    $is_icu_patient = 2;
//                }

                $tableRows[] = array(
                    $row->adhar_no,
                    $row->patient_name,
                    $row->contact,
                    $row->blood_group,
//                    $row->bed_name,
                    $row->id,
//					$row->company_id,
//                    $is_icu_patient,
                    '2',
                    $this->session->user_session->roles,
                    $profile_img,
                    $row->admission_mode,
                    $row->admission_date,
                    $mfd,
                    $room_name,
                    $permit,
                    $row->type

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

    public function deleteLabPatient()
    {
        if (!is_null($this->input->post('patientId'))) {
            $patientId = $this->input->post('patientId');
            $session_data = $this->session->user_session;

            $user_id = $session_data->id;
            $company_id = $session_data->company_id;
            $lab_patient = $this->session->user_session->lab_patient_table;
            $tableName = $lab_patient;//'com_' . $company_id . '_patient';
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

    public function get_labpatient_data($id)
    {
//	$id=$this->input->post('id');
      $tableName = $this->session->user_session->lab_patient_table;
      $query = $this->Patient_Model->getpatientdata($id, $tableName, $this->session->user_session->branch_id);

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

    public function getServiceTest()
    {

        $validObject = $this->is_parameter(array("type", "searchTerm"));
        $response = array();
        if ($validObject->status) {

            $type = $validObject->param->type;
            $search = $validObject->param->searchTerm;
            $where = array();
            if ((int)$type != 1)
                $where = array("service_name" => $type);
            $userData = $this->db->select(array("service_id", "service_name"))->where($where)->like("service_name", $search)->limit(10, 0)->get("setup_lab_service_master")->result();
            $response["last_query"] = $this->db->last_query();
            $data = array();
            if (count($userData) > 0) {
                foreach ($userData as $user) {
                    array_push($data, array("id" => $user->service_id, "text" => $user->service_name));
                }
            }
            $response["body"] = $data;
        } else {
            $response["body"] = array();
        }
        echo json_encode($response);
    }

    public function getPackageTest()
    {

        $validObject = $this->is_parameter(array("type", "searchTerm"));
        $response = array();
        if ($validObject->status) {

            $type = $validObject->param->type;
            $search = $validObject->param->searchTerm;
            $where = array();
            if ((int)$type != 1)
                $where = array("package_name" => $type);
            $userData = $this->db->select(array("id", "package_name"))->where($where)->like("package_name", $search)->limit(10, 0)->get("master_package")->result();
            $response["last_query"] = $this->db->last_query();
            $data = array();
            if (count($userData) > 0) {
                foreach ($userData as $user) {
                    array_push($data, array("id" => $user->id, "text" => $user->package_name));
                }
            }
            $response["body"] = $data;
        } else {
            $response["body"] = array();
        }
        echo json_encode($response);
    }

    function getServiceChildTest()
    {
        $header = $this->is_parameter(array("service_id"));
        $service_rate = '';
        if ($header->status) {
            $service_id = $header->param->service_id;
            $session_data = $this->session->user_session;
            $branch_id = $session_data->branch_id;

            $service_rate1 = $this->db->query('select rate from setup_lab_service_master where service_id="' . $service_id . '" and branch_id="' . $branch_id . '"');
            if ($this->db->affected_rows() > 0) {
                $service_rate1 = $service_rate1->row();
                $service_rate = $service_rate1->rate;
            }
            $service_data = $this->db->query('select sc.*,(select lc.name from lab_child_test lc where lc.id=sc.test_id) as child_test,(select lm.name from lab_master_test lm where lm.id=sc.master_id) as master_test from setup_child_lab_test sc where sc.branch_id=' . $branch_id . ' and sc.status=1 and sc.master_id=' . $service_id . '');
            if ($this->db->affected_rows() > 0) {
                $data = '';
                $service_data = $service_data->result();

                $data .= '<table class="table" id="service_table">
                <thead>
                <tr>
                <th>Test Name</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($service_data as $key => $value) {
                    $data .= '<tr>
                    <td>' . $value->child_test . '</td>

                    </tr>';
                }
                $data .= '</tbody>
                </table>';

                $response["status"] = 200;
                $response["data"] = $data;
                $response['rate'] = $service_rate;
            } else {
                $response["status"] = 201;
                $response["data"] = "";
                $response['rate'] = $service_rate;
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
            $response['rate'] = $service_rate;
        }
        echo json_encode($response);
    }

    function getPackageChildTest()
    {
        $header = $this->is_parameter(array("package_id"));
        $service_rate = '';
        if ($header->status) {
            $package_id = $header->param->package_id;
            $session_data = $this->session->user_session;
            $branch_id = $session_data->branch_id;
            $service_rate1 = $this->db->query('select package_amount from master_package where id="' . $package_id . '"');
            if ($this->db->affected_rows() > 0) {
                $service_rate1 = $service_rate1->row();
                $service_rate = $service_rate1->package_amount;
            }
            $service_data = $this->db->query('select sc.* from set_master_package sc where sc.branch_id=' . $branch_id . ' and sc.package_id=' . $package_id . ' and sc.status=1');
            if ($this->db->affected_rows() > 0) {
                $data = '';
                $service_data = $service_data->result();

                $data .= '<table class="table" id="service_table">
                <thead>
                <tr>
                <th>Test Name</th>
                </tr>
                </thead>
                <tbody>';
                foreach ($service_data as $key => $value) {
                    $data .= '<tr>
                    <td>' . $value->child_test_name . '</td>
                    </tr>';
                }
                $data .= '</tbody>
                </table>';

                $response["status"] = 200;
                $response["data"] = $data;
                $response['rate'] = $service_rate;
            } else {
                $response["status"] = 201;
                $response["data"] = "";
                $response['rate'] = $service_rate;
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
            $response['rate'] = $service_rate;
        }
        echo json_encode($response);
    }

    function saveLabServiceOrder()
    {
        if (!is_null($this->input->post("patient_id")) && !is_null($this->input->post("service_rate")) && !is_null($this->input->post("service_date"))) {
            $session_data = $this->session->user_session;
            $branch_id = $session_data->branch_id;
            $id = $session_data->id;

            $patient_id = $this->input->post("patient_id");
            $service_name = $this->input->post("service_name");
            $package_name = $this->input->post("package_name");
            $service_rate = $this->input->post("service_rate");
            $service_date = $this->input->post("service_date");
            $comment = $this->input->post("comment");
            if (is_null($this->input->post("service_name")) && $this->input->post("service_name") == "") {
                $service_name = '';
            }
            if (is_null($this->input->post("package_name")) && $this->input->post("package_name") == "") {
                $package_name = '';
            }
            if (is_null($this->input->post("service_rate")) && $this->input->post("service_rate") == "") {
                $service_rate = '';
            }
            if (is_null($this->input->post("service_date")) && $this->input->post("service_date") == "") {
                $service_date = '';
            }
            if (is_null($this->input->post("comment")) && $this->input->post("comment") == "") {
                $comment = '';
            }
            $service_id = $service_name;
            $service_type = 1;
            if (empty($service_name)) {
                $service_id = $package_name;
                $service_type = 2;
            }
            $childseviceIds = array();
            if ($service_type == 1) {
                $service_data = $this->db->query('select sc.* from setup_child_lab_test sc where sc.branch_id=' . $branch_id . ' and sc.master_id=' . $service_id . ' and sc.status=1');
                if ($this->db->affected_rows() > 0) {
                    $service_data = $service_data->result();
                    foreach ($service_data as $key => $value) {
                        array_push($childseviceIds, $value->test_id);
                    }
                }

            } else if ($service_type == 2) {
                $package_data = $this->db->query('select sc.* from set_master_package sc where sc.branch_id=' . $branch_id . ' and sc.package_id=' . $service_id . ' and sc.status=1');
                if ($this->db->affected_rows() > 0) {
                    $package_data = $package_data->result();
                    foreach ($package_data as $key => $value) {
                        array_push($childseviceIds, $value->id);
                    }
                }
            }
            if (count($childseviceIds) > 0) {
                $insert_count = 0;
                $service_array = array();

                $insert_data = array(
                    'patient_id' => $patient_id,
                    'branch_id' => $branch_id,
                    'service_id' => $service_id,
                    'service_date' => $service_date,
                    'created_by' => $id,
                    'created_on' => date('Y-m-d H:i:s'),
                    'user_id' => $id,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'service_rate' => $service_rate,
                    'comment' => $comment,
                    'status' => 1,
                    'service_type' => $service_type
                );
                $inse_data = $this->db->insert("lab_patient_serviceorder", $insert_data);
                $insert_id = $this->db->insert_id();
                foreach ($childseviceIds as $key => $value) {
                    $childinsert_data = array(
                        'patient_id' => $patient_id,
                        'branch_id' => $branch_id,
                        'order_id' => $insert_id,
                        'child_test_id' => $value,
                        'user_id' => $id,
                        'transaction_date' => date('Y-m-d H:i:s'),
                        'status' => 1,
                        'order_type' => $service_type,
                        'master_id'=>$service_id
                    );
                    if ($this->db->insert("lab_test_data_entry", $childinsert_data)) {
                        $insert_count++;
                    }
                }
                if ($insert_count > 0) {
                    $response["status"] = 200;
                    $response["body"] = "Order Confirm";
                } else {
                    $response["status"] = 201;
                    $response["body"] = "order nor confirm";
                }

            } else {
                $response["status"] = 201;
                $response["body"] = "No Child Service Found";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function getLabServiceOrders()
    {
        $patient_id = $this->input->post('patient_id');
        $tableName = 'lab_patient_serviceorder';
        $session_data = $this->session->user_session;
        $branch_id = $session_data->branch_id;
        // $branch_id=2;
        $select = array(" id", "service_id", "service_rate", "service_date", "service_type", '(case when service_type=1 then (select sm.name from lab_master_test sm where sm.id=t1.service_id) else (select mp.package_name from master_package mp where mp.id=t1.service_id) end) as service_name');
        $order = array('created_on' => 'desc');
        $column_order = array('',);
        $column_search = array("", "");
        $where = array("status" => 1, "branch_id" => $branch_id, "patient_id" => $patient_id);

        $memData = $this->Patient_Model->getRows($_POST, $where, $select, $tableName . " t1", $column_search, $column_order, $order);

        $filterCount = $this->Patient_Model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->Patient_Model->countAll($tableName, $where);
        // print_r($resultObject);exit();
        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {
                $tableRows[] = array(
                    $row->service_name,
                    $row->service_rate,
                    $row->service_date,
                    $row->id,
                    $row->service_id,
                    $row->service_type
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

    public function getlabServiceCancelOrder()
    {
        $service_id = $this->input->post('service_id');
        $service_type = $this->input->post('service_type');

        $session_data = $this->session->user_session;
        $branch_id = $session_data->branch_id;

        $where = array('id' => $service_id, 'branch_id' => $branch_id);
        $set = array("status" => 0);
        $this->db->where($where);
        $update = $this->db->update('lab_patient_serviceorder', $set);
        if ($update == true) {
            $where1 = array('order_id' => $service_id, 'branch_id' => $branch_id);
            $set1 = array("status" => 0);
            $this->db->where($where1);
            $update = $this->db->update('lab_test_data_entry', $set);
            $response['status'] = 200;
            $response['body'] = "Updated Successfully";
        } else {
            $response['status'] = 201;
            $response['body'] = "Somethimg Went Wrong";
        }

        echo json_encode($response);
    }

    public function getlabServiceChildOrder()
    {
        $order_id = $this->input->post('order_id');
        $order_type = $this->input->post('service_type');
        $patient_id = $this->input->post('patient_id');
        $session_data = $this->session->user_session;
        $branch_id = $session_data->branch_id;

        $select = array("id", '(case when order_type=1 then (select sm.name from lab_child_test sm where sm.id=t1.child_test_id) else (select mp.child_test_name from set_master_package mp where mp.id=t1.child_test_id) end) as service_name');
        $tableName = 'lab_test_data_entry';
        $order = array('id' => 'desc');
        $column_order = array('',);
        $column_search = array("", "");
        $where = array("status" => 1, "branch_id" => $branch_id, "patient_id" => $patient_id, 'order_id' => $order_id, 'order_type' => $order_type);

        $memData = $this->Patient_Model->getRows($_POST, $where, $select, $tableName . " t1", $column_search, $column_order, $order);
        $last_query = $this->db->last_query();
        // print_r($this->db->last_query());exit();
        $filterCount = $this->Patient_Model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->Patient_Model->countAll($tableName, $where);
        // print_r($resultObject);exit();
        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {
                $tableRows[] = array(
                    $row->service_name,
                    $row->id
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
        $results['last_query'] = $last_query;
        echo json_encode($results);

    }

    public function getAllServiceOrderOptions()
    {

        $header = $this->is_parameter(array("patient_id"));

        if ($header->status) {
            $branch_id = $this->session->user_session->branch_id;
            $patient_id = $header->param->patient_id;

            $resultObject = $this->Patient_Model->_rawQuery("select order_id ,(case when order_type =1 then (select name from lab_master_test where id = order_id) else (select package_name from master_package where id = order_id ) end) as name 
                from lab_test_data_entry where patient_id=" . $patient_id . " and branch_id =" . $branch_id . " and status =1 group by order_id");

            $data = array(array("id" => -1, "text" => "none"));
            if ($resultObject->totalCount > 0) {
                foreach ($resultObject->data as $items) {
                    $data[] = array("id" => $items->order_id, "text" => $items->name);
                }
            }
            $response["status"] = 200;
            $response["data"] = $data;
        } else {
            $response["status"] = 201;
            $response["data"] = array();
        }
        echo json_encode($response);
    }


    public function getAllServiceOrderTest()
    {

        $header = $this->is_parameter(array("order_id", "patient_id"));

        if ($header->status) {

            $order_id = $header->param->order_id;
            $patient_id = $header->param->patient_id;
            $branch_id = $this->session->user_session->branch_id;
            $resultObject = $this->Patient_Model->_select("lab_test_data_entry",
                array("status" => 1, "order_id" => $order_id, "patient_id" => $patient_id, "branch_id" => $branch_id),
                array("id",
                    "(case when order_type = 1 then (select name from lab_child_test where  id =child_test_id) else (select child_test_name from set_master_package where id = child_test_id) end )as child_test_name",
                    "child_test_id", "value", "unit", "refe_value"), false);
            $response["last_query"] = $resultObject->last_query;
            $unitReferenceOption = $this->Patient_Model->_select("lab_unit_master", array("status" => 1), array("id", "name", "referance"), false);
            $data = array();
//            $options = "";
//            foreach ($unitReferenceOption->data as $option){
//                $options .="<option value='".$option->id."'>".$option->name."</option>";
//            }
            $response["units"] = $unitReferenceOption->data;
            if ($resultObject->totalCount > 0) {
                foreach ($resultObject->data as $items) {

                    $data[] = array(
                        $items->id,
                        $items->child_test_name,
                        $items->child_test_id,
                        $items->value,
                        $items->unit,
                        $items->refe_value,
                    );
                }
            }

            $response["status"] = 200;
            $response["data"] = $data;
        } else {
            $response["status"] = 201;
            $response["data"] = array();
        }
        echo json_encode($response);
    }

    public function ChangeBillingOpen()
    {
        $p_id = $this->input->post('p_id');
        $lab_patient = $this->session->user_session->lab_patient_table;
        $patient_table = $lab_patient;
        $query = $this->db->query("select billing_open from " . $patient_table . " where id=" . $p_id);

        //1=close 0=open
        if ($this->db->affected_rows() > 0) {
            $billing_open = $query->row()->billing_open;
            if ($billing_open == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $where = array("id" => $p_id);
            if ($status == 0) {
                $close_date = null;
                $close_user = null;
                $discharge_date = null;
            } else {
                $close_date = date('Y-m-d H:i:s');
                $discharge_date = date('Y-m-d H:i:s');
                $close_user = $this->session->user_session->id;
            }
            $set = array("billing_open" => $status, "close_bill_date" => $close_date, "discharge_date" => $discharge_date, "bill_close_user" => $close_user);
            $this->db->where($where);
            $update = $this->db->update($patient_table, $set);
            if ($update == true) {
                $response['status'] = 200;
                if ($status == 0) {
                    $response['body'] = "Successfully Open";
                } else {
                    $response['body'] = "Successfully Close";
                }

            } else {
                $response['status'] = 201;
                $response['body'] = "Something went wrong";
            }
        } else {
            $response['status'] = 201;
            $response['body'] = "Something went wrong";
        }
        echo json_encode($response);
    }

    public function check_billing_status()
    {
        $p_id = $this->input->post('p_id');
        $lab_patient = $this->session->user_session->lab_patient_table;
        $patient_table = $lab_patient;
        $query = $this->db->query("select billing_open from " . $patient_table . " where id=" . $p_id);
        if ($this->db->affected_rows() > 0) {
            $billing_open = $query->row()->billing_open;
            $response['status'] = 200;
            $response['value'] = $billing_open;
        } else {
            $response['status'] = 201;

        }
        echo json_encode($response);
    }

    public function getLabServiceOrders1()
    {
        $patient_id = $this->input->post('patient_id');
        $tableName = 'lab_patient_serviceorder';
        $session_data = $this->session->user_session;
        $branch_id = $session_data->branch_id;
        // $branch_id=2;
        $select = array(" id", "service_id", "service_rate", "service_date", "service_type", '(case when service_type=1 then (select sm.name from lab_master_test sm where sm.id=t1.service_id) else (select mp.package_name from master_package mp where mp.id=t1.service_id) end) as service_name', '(select count(1) from lab_test_data_entry lb where lb.order_id = t1.id and (lb.value != 0 AND lb.value is not NULL and lb.value != "")) as value_count', '(select count(lb.id) from lab_test_data_entry lb where lb.order_id = t1.id) as child_count');
        $order = array('created_on' => 'desc');
        $column_order = array('',);
        $column_search = array("", "");
        $where = array("status" => 1, "branch_id" => $branch_id, "patient_id" => $patient_id);

        $memData = $this->Patient_Model->getRows($_POST, $where, $select, $tableName . " t1", $column_search, $column_order, $order);
        // print_r($this->db->last_query());exit();
        $filterCount = $this->Patient_Model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->Patient_Model->countAll($tableName, $where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {
                $tableRows[] = array(
                    $row->service_name,
                    $row->service_rate,
                    $row->service_date,
                    $row->id,
                    $row->service_id,
                    $row->service_type .
                    $row->value_count,
                    $row->child_count
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
    public function getLabDataEntryExcelData()
    {
        $header = $this->is_parameter(array("section_id","dep_id","haskey","queryParam"));

        if($header->status){
            $sql = "select master_id,table_name,operation,header,type,configuration,column_name,operation_column,where_condition,fetch_query_columns,where_condition from dynamic_form_table_master m join dynamic_form_column_master c
            on m.id=c.master_id where m.has_key ='" . $header->param->haskey . "' and m.section_id = ".$header->param->section_id." and m.dep_id = ".$header->param->dep_id." and m.status=1 and c.status=1";
            $resultObject = $this->db->query($sql)->result();
            $qParam =(array)json_decode(base64_decode($header->param->queryParam));
            if(count($resultObject)>0){
                $select=array();
                $tableName="";
                $where_condition="";
                foreach ($resultObject as $item){
                    if($item->fetch_query_columns !=="" && $item->fetch_query_columns !==null){
                        extract($qParam);
                        $arr_k=array_keys($qParam);
                        $fetch_query_columns=$item->fetch_query_columns;
                        foreach ($arr_k as $a){
                            $b="#".$a;
                            if (strpos($fetch_query_columns, $b) !== false) {
                                $fetch_query_columns=str_replace($b,$qParam[$a],$fetch_query_columns);
                            }
                        }
                        $select=explode(",",$fetch_query_columns);

                    }else{
                        array_push($select,$item->column_name);
                    }

                    $tableName=$item->table_name;
                    $where_condition=$item->where_condition;
                }
                if($tableName!==""){
                    $this->db->select($select);
                    $where=array();
                    if($where_condition!=="" && $where_condition !=null){
                     $conditions=explode(",",$where_condition);

                     if(count($conditions)>0){
                        foreach ($conditions as $cont){
                            $cond = explode("=",$cont);
                            if(count($cond)>0){
                                if(substr(trim($cond[1]), 0, strlen('#'))!=='#'){
                                    $where[$cond[0]]=$cond[1];
                                }else{
                                    $propName=str_replace("#","",$cond[1]);
                                    if(array_key_exists(trim($propName),$qParam)){
                                        $where[$cond[0]]=$qParam[$propName];
                                    }
                                }

                            }
                        }
                    }
                }
                $datanew = array();
                $this->db->where($where);
                $data=$this->db->get($tableName)->result();
                if($data != null)
                {
                    foreach($data as $row)
                    {
                        $data = array($row->master_id,$row->child_test_name,"",$row->unit,$row->refe_value,$row->child_test_id,$row->id);
                        array_push($datanew,$data);
                    }
                }
                if($datanew != null)
                {
                    $response["query"]=$this->db->last_query();
                    $response["status"]=200;
                    $response["body"]=$datanew;
                }
                else{
                    $response["status"]=201;
                    $response["body"]="No Data Found";
                }
                
            }else{
                $response["status"]=201;
                $response["body"]=array();
            }
        }else{
            $response["status"]=201;
            $response["body"]=array();
        }
    }else{
        $response["status"]=201;
        $response["body"]="something went wrong";
    }
    echo json_encode($response);

}  

public function updateDynamicLabData()
    {
        $value = $this->input->post('value');
        $session_data = $this->session->user_session;
        $branch_id = $session_data->branch_id;
        $user_id = $this->session->user_session->id;
        $patient_id = $this->input->post('patient_id');
        $updateArray = array();
        $insertArray = array();
        $insert_batch = "";
        $update_batch = "";
        // $where = array("branch_id" => $branch_id);
        $indexArray = array();
        $i = 1;
        $lab_test_data = array();
        $order_det = $this->db->where('patient_id',$patient_id)->get('lab_patient_serviceorder')->row();
        foreach ($value as $item) {
            $ltde_data = array(
                    "id"=>$item[6],
                    "value"=>$item[2],
                    "unit "=>$item[3]
                );
            array_push($lab_test_data,$ltde_data);
        }
        if (!empty($lab_test_data)) {
            $update_batch = $this->db->update_batch('lab_test_data_entry', $lab_test_data, 'id');
        }
        if ($update_batch == true) {
            $response['status'] = 200;
            $response['body'] = "Data inserted Successfully";
        } else {
            $response['status'] = 201;
            $response['body'] = "Failed To update";
            $response['last_q'] = $lab_test_data;
               
        }

        echo json_encode($response);

    }

public function updateDynamicLabData__()
    {
        $header = $this->is_parameter(array("tableName", "data","section_id","dep_id","haskey"));
        $package_id=$this->input->post('package_id');
        if ($header->status) {

            $patientId=$this->input->post('patientId');
            $patientIdA='N'.str_pad($patientId,'9','0',STR_PAD_LEFT);
            $patient_admission=$this->input->post('patient_admission');
            $patient_name=$this->input->post('patient_name');
            $tableName = $header->param->tableName;
            $data = json_decode($header->param->data);

            $section_id = $header->param->section_id;
            $hash_key = "#".$header->param->haskey;
            $dept_id = $header->param->dep_id;
            $branch_id = $this->session->user_session->branch_id;
            $lab_patient_table = $this->session->user_session->lab_patient_table;
            $getConfiguartiondataResult=$this->getConfiguartiondata($section_id,$hash_key,$dept_id);
//            print_r($getConfiguartiondataResult);exit();
            if($getConfiguartiondataResult == false){
                $response['status']=201;
                $response['body']="Something Went Wrong";
                echo json_encode($response);
                exit;
            }
            $patient_location='';
            $patient_age='';
            $patientObject=$this->MasterModel->_rawQuery('select (select location from  branch_master b where b.id=l.branch_id) as branch_loc,TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) as age from '.$lab_patient_table.' l where l.id='.$patientId.'');
            if($patientObject->totalCount>0)
            {
                $pdata=$patientObject->data[0];
                $patient_location=$pdata->branch_loc;
                $patient_age=$pdata->age;
            }
            $getConfiguartiondata=$getConfiguartiondataResult[0];
            $excelStructureDataArray=array();
            $operation=$getConfiguartiondata->operation;
            $operation_table=$getConfiguartiondata->operation_table;
            $dynamic_branch_id=$this->input->post('dynamic_branch_id');
            $resultstatus=TRUE;
            try {
                $this->db->trans_start();
            if($operation == 1){
                $InsertBatchData = array();

                foreach ($data as $object) {
                    if (!is_null($object)) {
                        $insert_object=new stdClass();
                        $isAll = false;

                        if($section_id == 137 || $section_id == 139){
                            $insert_object->branch_id=$branch_id;
                        }
                        if($section_id == 141){
                            $insert_object->package_id= $package_id;
                            $insert_object->branch_id=$branch_id;
                        }
                        foreach ($getConfiguartiondataResult as $row) {

                            if ($row->operation_column != null && $row->operation_column !== "") {
                                if($row->column_name != "" && !is_null($row->column_name)){
                                    if (property_exists($object, $row->column_name)) {

                                        $isAll = true;
                                        $insert_object->{$row->operation_column}=$object->{$row->column_name};
                                    } else {
                                        $isAll = false;
                                        break;
                                    }
                                }

                            }
                        }
                        if ($isAll) {
                            array_push($InsertBatchData, (array)$insert_object);
                            $orderIdA='AA'.str_pad($object->order_id,'6','0',STR_PAD_LEFT);
                            $excelStructureData=array('VisitDate'=>date('M d Y H:i A'),
                                'Orgname'=>'Covidcare',
                                'Location'=>$patient_location,
                                'Patient_number'=>$patientIdA,
                                'Patient_Name'=>$patient_name,
                                'Patient_Age'=>$patient_age,
                                'OrderTest'=>$object->master_name,
                                'ParameterId'=>$object->child_test_id,
                                'ParameterName'=>'',
                                'result'=>$object->value,
                                'unit'=>$object->unit,
                                'ref_range'=>$object->refe_value,
                                'orderId'=>$orderIdA,
                                'branch_id'=>$branch_id,
                                'order_number'=>$object->order_id,
                                'external_patient_id'=>$patientId,
                                'patient_type'=>2);
                            array_push($excelStructureDataArray,$excelStructureData);
                            print_r($excelStructureDataArray);exit();

                        }

                    }
                }
                if($section_id == 137 || $section_id == 139){
                    //delete operation
                    $this->db->delete($operation_table,array("branch_id"=>$branch_id));
                }
                if($section_id == 141){
                    $this->db->delete($operation_table,array("package_id"=>$package_id));
                }
                $result=$this->db->insert_batch($operation_table, $InsertBatchData);
            }else{
                $key = $getConfiguartiondata->update_where_columns;
                $updateBatchData = array();
                foreach ($data as $object) {

                    if (!is_null($object))
                    {
                        array_push($updateBatchData, (array)$object);
                            $orderIdA='AA'.str_pad($object->order_id,'6','0',STR_PAD_LEFT);
                            $excelStructureData=array('VisitDate'=>date('M d Y H:i A'),
                                'Orgname'=>'Covidcare',
                                'Location'=>$patient_location,
                                'Patient_number'=>$patientIdA,
                                'Patient_Name'=>$patient_name,
                                'Patient_Age'=>$patient_age,
                                'OrderTest'=>$object->master_name,
                                'ParameterId'=>$object->child_test_id,
                                'ParameterName'=>'',
                                'result'=>$object->value,
                                'unit'=>$object->unit,
                                'ref_range'=>$object->refe_value,
                                'orderId'=>$orderIdA,
                                'branch_id'=>$branch_id,
                                'order_number'=>$object->order_id,
                                'external_patient_id'=>$patientId,
                                'patient_type'=>2);
                            array_push($excelStructureDataArray,$excelStructureData);

                    }

                }
                $result=$this->db->update_batch($operation_table, $updateBatchData, $key);

            }
            if(count($excelStructureDataArray)>0)
            {
                $whereExcel=array('external_patient_id'=>$patientId,'patient_type'=>2,'branch_id'=>$branch_id);
                $delete=$this->db->where($whereExcel)->delete('excel_structure_data');
                if($delete){
                    $result=$this->db->insert_batch('excel_structure_data', $excelStructureDataArray);
                }
            }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $resultstatus = FALSE;
                } else {
                    $this->db->trans_commit();
                    $resultstatus = TRUE;
                }
                $this->db->trans_complete();
                $response["last_query"] = $this->db->last_query();
            } catch (Exception $ex) {
                $resultstatus = FALSE;
                $this->db->trans_rollback();
            }

            if ($resultstatus==true) {
                $response["status"] = 200;
                $response["body"] = "Save Changes";
            } else {
                $response["status"] = 201;
                $response["body"] = "Failed to save change";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "something went wrong";
        }
        echo json_encode($response);

    }

}