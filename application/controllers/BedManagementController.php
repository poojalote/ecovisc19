<?php

require_once 'HexaController.php';

/**
 * @property  User User
 */
class BedManagementController extends HexaController
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('bed_model');

    }

    /*
     * login api
     */

    public function index()
    {
        $this->load->view('BedManagement/bedManagement', array("title" => "Bed Management"));
    }

    public function icubedManagement()
    {
        $this->load->view('BedManagement/icubedManagement', array("title" => "ICU Bed Management"));
    }

    public function add_room_info()
    {
        $room_no = $this->input->post_get('room_no');
        $ward_no = $this->input->post_get('ward_no');
        $room_cat = $this->input->post_get('room_cat');
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table


        if (empty(trim($room_no))) {
            $response['id'] = 'room_no';
            $response['error'] = 'Enter room no';
            echo json_encode($response);
        } elseif (empty($ward_no)) {
            $response['id'] = 'ward_no';
            $response['error'] = 'Enter ward no';
            echo json_encode($response);
        } else {

            $room_data = array(
                "create_on" => date('Y-m-d H:m:i'),
                "create_by" => $this->session->user_session->id,
                "category" => $room_cat,
                "room_no" => $room_no, "ward_no" => $ward_no, "branch_id" => $this->session->user_session->branch_id
            );
            if ($this->bed_model->add_room($room_data, $hospital_room_table)) {
                $response['roomdata'] = $room_data;
                $response["status"] = true;
                $response["body"] = "Loan added successfully.";
            } else {
                $response['roomdata'] = $room_data;
                $response["status"] = false;
                $response["body"] = "Failed To Add Loan";
            }
            echo json_encode($response);
        }
    }


    public function getZoneData()
    {
        $hospital_room_table = $this->session->user_session->hospital_room_table;
        $branch_id = $this->session->user_session->branch_id;
        $sql = "select * from " . $hospital_room_table . " where branch_id=" . $branch_id;
        $query = $this->db->query($sql);
        $option = "<option selected disabled>Select Zone</option>";
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

    public function getZoneData1()
    {
        $hospital_room_table = $this->session->user_session->hospital_room_table;
        $branch_id = $this->session->user_session->branch_id;
        $sql = "select * from " . $hospital_room_table . " where branch_id=" . $branch_id . " AND category=1";
        $query = $this->db->query($sql);
        $option = "<option selected disabled>Select Zone</option>";
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

    public function get_roomdetails_info()
    {

        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_table = $this->session->user_session->patient_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table

        $query = $this->db->query("select * from " . $hospital_room_table . " where branch_id=" . $this->session->user_session->branch_id);
        $edit = 1;
        $actionTh = "<th>Action</th>";

        $data = '';
        $data .= '<table style="width: 100%;" id="roomdetails_table" class="table table-hover table-striped table-bordered dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Room No</th>
                                            <th>ward No</th>
                                            <th>Bed No</th>
                                            <th>Available Bed No</th>
                                            ' . $actionTh . '
                                        </tr>
                                    </thead>';

        $template = '<div id="bedAccordion">';
        if ($this->db->affected_rows() > 0) {

            $result1 = $query->result();
            $k = 1;


            foreach ($result1 as $row) {
                $room_get = $row->id;
                $query_get_bed = $this->db->query("select * from " . $hospital_bed_table . " where Id_room ='$room_get' and category=1 and branch_id=" . $this->session->user_session->branch_id);
                $result11 = $query_get_bed->result();
                $test1 = array();
                $rooms = "";

                foreach ($result11 as $row1) {
                    $test1[] = $row1->bed_name;
                    $status = "";
                    $patient_name = "";
                    $onclick = 'onclick="deactiveBed(' . $row1->id . ',' . $row1->active . ')"';
                    if ((int)$row1->status == 0) {
                        $patientNameResult = $this->db->query('select id,patient_name,adhar_no,contact,patient_image,admission_date,admission_mode from ' . $patient_table . ' where id =(select patient_id from ' . $patient_bed_history_table . ' where room_id=' . $room_get . ' and bed_id=' . $row1->id . ' and branch_id=' . $this->session->user_session->branch_id . '  order by id desc limit 1)')->result();

                        if (count($patientNameResult) > 0) {
                            $patient_name = $patientNameResult[0]->patient_name;
                            $id = $patientNameResult[0]->id;
                            $adhar_number = $patientNameResult[0]->adhar_no;
                            $concat = $patientNameResult[0]->contact;
                            $profile = $patientNameResult[0]->patient_image;
                            $adminDate = $patientNameResult[0]->admission_date;
                            $adminMode = $patientNameResult[0]->admission_mode;
                            $status = "text-danger";
                            $onclick = ' style="cursor:pointer" onclick="loadPatient(`' . $id . '`,`' . $patient_name . '`,`' . $adhar_number . '`,`' . $concat . '`,`' . $profile . '`,`' . $adminDate . '`,`' . $adminMode . '`)"';
                        }
                        $response["patientName"][] = $this->db->last_query();

                    }
                    $unuseIcon='<i class="fas fa-bed ' . $status . '" style="font-size: x-large;"></i>';
                    if ($row1->active == 1) {
						$unuseIcon='<img src="'.base_url().'assets/img/unuse_bed2.png" width="33px" height="30px">';
                        $status = "";
                        $patient_name = "";
                        $onclick = 'onclick="deactiveBed(' . $row1->id . ',' . $row1->active . ')"';
                    }
                    $rooms .= '<div class="card mb-0 mx-2" ' . $onclick . '>
								<div class="card-body p-3 text-center">
									'.$unuseIcon.'
									<h3>' . $row1->bed_name . '</h3>
									<small>' . $patient_name . '</small>
								</div>
							</div>';
                }
                $permission_array = $this->session->user_permission;
                $btn_edit = "";
                $btn_del = "";
                $btn_edit = "<button type='button' data-toggle='modal' data-target='#myModal' onclick='add_bed_btn(\"" . $row->id . "\")'class='btn btn-sm btn-outline-dark mx-1'>"
                    . "<i class='fa fa-bed' ></i> Add Bed </button>";
                if (in_array("bed_management", $permission_array)) {

                    $btn_del = '<button type="button"  class="btn btn-sm btn-outline-dark mx-1" onclick="delete_room(' . $row->id . ')"> 
											<i class="fa fa-trash"></i> 
										</button> ';
                }
                $template .= '<div class="accordion">
								<div class="accordion-header" role="button" data-toggle="collapse"  data-target="#panel-body-' . $row->id . '" aria-expanded="false">
                         		 	<h4>' . $row->room_no . ' ' . $row->ward_no . '</h4>
                       			 </div>
                       			 <div class="accordion-body collapse show" id="panel-body-' . $row->id . '" data-parent="#bedAccordion">
                       			 	<div class="row justify-content-end row">
										
																				    
                       			 	</div> 
                       			 	<div class="row align-items-center">
                        					' . $rooms . '
									</div>
                       			 </div>
                       		</div> ';

                $template .= "</div>";
                $test12 = implode(" , ", $test1);
                $query_get_bed_sts = $this->db->query("select bed_name from " . $hospital_bed_table . " where Id_room ='$room_get' and status='1'");
                $result_sts = $query_get_bed_sts->result();
                $test2 = array();
                foreach ($result_sts as $row11) {
                    $test2[] = $row11->bed_name;
                }
                $test111 = implode(" , ", $test2);

                $btn_edit = "";
//				if (in_array("Create_bed", $permission_array)){
//					$btn_edit = "<button type='button' data-toggle='modal' data-target='#myModal' onclick='add_bed_btn(\"" . $row->id . "\")'class='btn-icon btn-icon-only btn btn-primary btn-sm'>"
//                        . "<i class='fa fa-bed' aria-hidden='true'></i> Add Bed </button>";
//				}

                if ($edit == 1) {
                    $btn_del = "<button type='button' onclick='delete_room(\"" . $row->id . "\")'class='btn-icon btn-icon-only btn btn-danger btn-sm ml-2'>"
                        . "<i class='fa fa-trash'  > </i> </button>";
                } else {
                    $btn_del = "";
                }
                $data .= '<tr>
                    <td>' . $k . '</td>
                    <td>' . $row->room_no . '</td>
                    <td>' . $row->ward_no . '</td>
                    <td>' . $test12 . '</td>
                    <td>' . $test111 . '</td>
                    <td>' . $btn_edit . $btn_del . '</td>
                    </tr>';
                $k++;
            }
            $data .= '</table>';
            $response["status"] = 200;
            $response["result_sal"] = $template;
        } else {
            $template = '';
            $response["result_sal"] = $template;
            $response["status"] = 201;
        }
        echo json_encode($response);
    }

    public function get_roomdetails_info_icu()
    {
        $serachGender = $this->input->get_post('gender');
        $searchPatient = $this->input->get_post('searchPatient');
        $searchAge = $this->input->get_post('searchAge');

        $patient_table = $this->session->user_session->patient_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
        $branch_id = $this->session->user_session->branch_id;

        $s_gender = "";
        if ($serachGender == 1) {
            $s_gender = "and gender = 1";
        } else if ($serachGender == 2) {
            $s_gender = "and gender = 2";
        }
        $template = '';
        $a = 1;
        if ($a == 1) {
            $sql = "
			select * from (select pt.id, pt.patient_name, pt.adhar_no,pt.blood_group,pt.gender, pt.contact, pt.patient_image,pt.birth_date,
			       pt.admission_date, pt.admission_mode,pt.type,pt.is_icu_patient,pt.bed_id,
			       (select group_concat(cb1.bed_name,',',(case when cb1.camera_name is null then -1 else cb1.camera_name end))from com_1_bed cb1 where cb1.id=pt.bed_id) as bed_name,
1 as labParaInfo,
(select 
				group_concat( pm.name,'||',pm.total_iteration,'||',
				(case when curdate() between date(pm.start_date) and date(pm.end_date) then 1 else 0 end),'||',
				(case when datediff(pm.end_date,pm.start_date) =0 then 1 else datediff(pm.end_date,pm.start_date) end),'||',
				(select mm.name from medicine_master mm where mm.id=pm.name) SEPARATOR '@@')
				 from  " . $patient_mediine_table . " pm
 				where pm.p_id=pt.id and branch_id=" . $branch_id . " and status=1  order by id desc limit 5) as medicine_details,
 				(select group_concat(datediff(now(),h.inTime),'||',h.inTime) from " . $patient_bed_history_table . " h where h.bed_id=pt.bed_id and h.room_id = pt.roomid and h.patient_id=pt.id) as bedtime
from " . $patient_table . "  pt where pt.bed_id in (select cb.id from com_1_bed cb where cb.category=2 and cb.status=0 and cb.branch_id=" . $branch_id . ") and (pt.discharge_date is null or pt.discharge_date ='0000-00-00 00:00:00') " . $s_gender . " ) a order by a.bed_id";
            $query_get_bed = $this->db->query($sql);
            $result11 = $query_get_bed->result();
            $rooms = "";
            foreach ($result11 as $row1) {
                $coloData = $this->random_color();
                $roomsData = "";

                $bed = explode(',', $row1->bed_name);
                $profile = "";
                $medicineInfo = "";
                $bedTime = explode("||", $row1->bedtime);
                $icuBedTemplate = "";
                if (count($bedTime) >= 1) {
                    $icuBedInTime = $this->getDate($bedTime[1]);
                    $icuNumberOfBed = $bedTime[0];
                    $icuBedTemplate = "<span>In: " . $icuBedInTime . "</span><span class='font-weight-bold'>(" . $icuNumberOfBed . " days)</span>";
                }
                $patient_name = $row1->patient_name;
                $id = $row1->id;
                $adhar_number = $row1->adhar_no;
                $concat = $row1->contact;
                $profile_image = $row1->patient_image;
                $adminDate = $row1->admission_date;
                $adminMode = $row1->admission_mode;
                $gender = $row1->gender;
                $patient_type = $row1->type;
                if ($gender == 1) {
                    $gen = "Male";
                } else if ($gender == 2) {
                    $gen = "Female";
                } else {
                    $gen = "Other";
                }
                $age = (date('Y') - date('Y', strtotime($row1->birth_date)));

                $onclick = ' style="cursor:pointer;" onclick="loadPatient(`' . $id . '`,`' . $patient_name . '`,`' . $adhar_number . '`,`' . $concat . '`,`' . $profile_image . '`,`' . $adminDate . '`,`' . $adminMode . '`,`' . $patient_type . '`,`3`)"';

                $profile .= "<div " . $onclick . ">";
                $profile .= "<div class='text-center'><span style='font-size:11px'>" . $patient_name . "</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>" . $age . " y</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>BG:" . $row1->blood_group . "</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>" . $gen . "</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>A-" . $adhar_number . "</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>" . $bed[0] . "</span></div>";
                $profile .= "<div class='text-center'><span style='font-size:11px'>" . $icuBedTemplate . "</span></div>";
                $profile .= "</div>";

                $medicinecnt = 0;
                $medicineInfoDiv = "";
                if ($row1->medicine_details != null) {
                    $medicineInfo .= "<div style='height:auto;cursor:pointer;' onclick='get_icuPtientScheduleMedicine(" . $id . ")'>";
                    $medicineData = explode('@@', $row1->medicine_details);
                    if ($medicineData >= 0) {
                        foreach ($medicineData as $key => $m_value) {
                            $medicineDatainfo = explode('||', $m_value);
                            if (count($medicineDatainfo) > 4) {
                                $medicine_id = $medicineDatainfo[0];
                                $m_t_iteration = $medicineDatainfo[1];
                                $m_s_today = $medicineDatainfo[2];
                                $m_s_totaldays = $medicineDatainfo[3];
                                $medicine_name = $medicineDatainfo[4];
                                if ($m_s_today == 1) {
                                    if ($medicinecnt <= 4) {
                                        $medicinecnt++;
                                        $m_medicine_name = substr($medicine_name, 0, 8);
                                        $medicineInfoDiv .= "<div style='font-size:11px;border-bottom:1px solid #d3d3d38c;padding:5px;'>" . $m_medicine_name . "-" . date('d M') . "-" . $m_s_totaldays . " D-" . $m_t_iteration . "/d</div>";
                                    }
                                }
                            }
                        }
                    }
                    $medicineInfo .= $medicineInfoDiv;
                    $medicineInfo .= "</div>";
                }
                $labTestInfo = "<div id='patient_lab_" . $id . "'>loading...</div>";

                $vitalTestInfo = "<div id='patient_vital_" . $row1->bed_id . "'>loading...</div>";

                $c_name = "";
                if (count($bed) >= 1) {
                    if ((int)$bed[1] !== -1 && $bed[1] != "") {
                        $exxp1 = explode("|", $bed[1]);
                        if (count($exxp1) >= 2) {
                            $c_name = trim($exxp1[0]) . trim($exxp1[1]);
                        }
                        $image = "https://vs.ecovisrkca.com/images/picture_'.$c_name.'.jpg";
                    } else {
                        $c_name = "";
                        $image = "https://covidcare.ecovisrkca.com/assets/img/not-available.jpg";

                    }
                } else {
                    $c_name = "";
                    $image = "https://covidcare.ecovisrkca.com/assets/img/not-available.jpg";

                }
                $roomsData .= '
									<table class="table table-bordered table-striped" id="icubedManagement_1">
									<thead class="th_height" style="background-color:#' . $coloData . ';">
									<tr>
									<th style="width:16%;color:white;">Patient Profile</th>
									<th style="width:19%;color:white;">Medication</th>
									<th style="width:19%;color:white;">Lab Tests</th>
									<th style="width:26%;color:white;">Vital Signs</th>
									<th style="width:20%;color:white;">Video</th>
									</tr>
									</thead>
									<tbody>
									';
                $roomsData .= '
									<tr>									
									<td style="vertical-align:top;padding:7px;">' . $profile . '</td>
									<td style="vertical-align:top;padding:7px;">' . $medicineInfo . '</td>
									<td style="vertical-align:top;padding:7px;">' . $labTestInfo . '</td>
									<td style="overflow: hidden;position: relative;padding:0px 0px!important;">' . $vitalTestInfo . '</td>
									<td><div data-toggle="modal" data-target="#largeVideo" data-camera="' . $c_name . '"  >
									<img src="' . $image . '" id="L_' . $c_name . '" class="p-1"style="width: 200px;height:150px;border:2px  black" alt="No Video Available" />
									
									</tr>
									';
                $roomsData .= "</tbody></table>";

                if ($searchAge == "" && $searchAge == null) {
                    if ($searchPatient != "" && $searchPatient != null) {
                        if ($searchPatient == $id) {
                            $rooms .= $roomsData;
                            $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                        }
                    } else {
                        $rooms .= $roomsData;
                        $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                    }
                } else {
                    if ($searchAge == "0-20") {
                        if ($age > 0 && $age <= 20) {
                            if ($searchPatient != "" && $searchPatient != null) {
                                if ($searchPatient == $id) {

                                    $rooms .= $roomsData;
                                    $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                                }
                            } else {
                                $rooms .= $roomsData;
                                $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                            }
                        }

                    } else if ($searchAge == "21-40") {
                        if ($age >= 21 && $age <= 40) {
                            if ($searchPatient != "" && $searchPatient != null) {
                                if ($searchPatient == $id) {

                                    $rooms .= $roomsData;
                                    $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                                }
                            } else {
                                $rooms .= $roomsData;
                                $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                            }
                        }
                    } else if ($searchAge == "41-60") {
                        if ($age >= 41 && $age <= 60) {
                            if ($searchPatient != "" && $searchPatient != null) {
                                if ($searchPatient == $id) {

                                    $rooms .= $roomsData;
                                    $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                                }
                            } else {
                                $rooms .= $roomsData;
                                $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                            }
                        }
                    } else if ($searchAge == "age>60") {
                        if ($age > 60) {
                            if ($searchPatient != "" && $searchPatient != null) {
                                if ($searchPatient == $id) {

                                    $rooms .= $roomsData;

                                    $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                                }
                            } else {
                                $rooms .= $roomsData;

                                $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                            }
                        }
                    } else {
                        if ($searchPatient != "" && $searchPatient != null) {
                            if ($searchPatient == $id) {

                                $rooms .= $roomsData;

                                $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                            }
                        } else {
                            $rooms .= $roomsData;

                            $response["pData"][] = array($id, $bed[1], $row1->bed_id);

                        }
                    }

                }
            }
            $template .= '
				<div class="row align-items-center" id="test">
                         					' . $rooms . '
				 					</div>
				';

            $response["status"] = 200;
            $response["result_sal"] = $template;
        } else {
            $template = '';
            $response["result_sal"] = $template;
            $response["status"] = 201;
        }
        echo json_encode($response);
    }

    public function getLabReport()
    {

        $validObject = $this->is_parameter(array("id", "bed_id"));
        $labTestInfo = "-";
        $vital_sign = "-";
        if ($validObject->status) {
            $id = $validObject->param->id;
            $bed_id = $validObject->param->bed_id;
            $cam = $this->input->post("cam");
            $response["id"] = $id;
            $response["cam"] = $cam;
            $query_get_bed = $this->db->query("select getLabParaValues( " . $id . ") as labParaInfo");
            $result11 = $query_get_bed->result();

            $labparadata = "";
            $labparacnt = 0;
            foreach ($result11 as $row1) {
                if ($row1->labParaInfo != null) {
                    $paraData = explode('@@', $row1->labParaInfo);
                    if (count($paraData) >= 0) {
                        $para_name = "";
                        $paraStatus = "";
                        $paraResult = "";
                        // print_r($paraData);
                        foreach ($paraData as $key => $p_value) {
                            $paraDatavalue = explode('||', $p_value);
                            if (count($paraDatavalue) > 1) {
                                if ($labparacnt <= 4) {
                                    $labparacnt++;
                                    $para_name = $paraDatavalue[0];
                                    $paraStatus = $paraDatavalue[1];
                                    $paraResult = $paraDatavalue[2];
                                    if ($paraStatus == 0) {
                                        $labparadata .= '
													<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-' . $paraResult . '</div>
													';
                                    } else {
                                        $labparadata .= '
													<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-<span style="color:red;">' . $paraResult . '</span></div>
													';
                                    }
                                }
                            }
                        }
                    }
                }

            }
            $flag = "";
            if ($labparadata != "") {
                $onclickPara = 'onclick="getIcuPatientLabTestPara(' . $id . ')"';
                $flag .= '<div ' . $onclickPara . ' style="cursor:pointer;font-size:11px;height:auto;">';
                $flag .= $labparadata;
                $flag .= '</div>';
                $labTestInfo = $flag;
            }
            $vital_sign = $this->getVitalSignLive($bed_id)->flag;
            $vital_signinline = $this->getVitalSignLive($bed_id)->flagnew;
        }

        $response["lab"] = $labTestInfo;
        $response["vital"] = $vital_sign;
        $response["vital_signinline"] = $vital_signinline;
        echo json_encode($response);

    }

    function getVitalSignLiveByBed()
    {
        $validObject = $this->is_parameter(array("bed_id"));
        if ($validObject->status) {
            $bed_id = $validObject->param->bed_id;
            $object = $this->getVitalSignLive($bed_id);
            $response["body"] = $object->flag;
            $response["body2"] = $object->flagnew;
            $response["object"] = $object->object;
            $response["status"] = 200;
        } else {
            $response["status"] = 200;
            $response["body"] = "";
            $response["body2"] = "";
        }
        echo json_encode($response);
    }

    public function get_vital_sign_para($patient_id)
    {
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $query = $this->db->query("select * from icu_patient_para where branch_id='$branch_id' AND company_id='$company_id'");
        $flag = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();

            $cnt = 0;
            $cnt1 = 0;
            $alldata = "";
            $flagData = "";
            $alldata .= "<table class='table p-2'>
			<thead>
			<tr>
			<th>Parameter Name</th>
			<th>Result</th>
			</tr>
			</thead><tbody>";
            foreach ($result as $row1) {
                $min_range = $row1->min_value;
                $max_range = $row1->max_value;
                $para_id = $row1->temp_id;
                //get para name
                $para_name = "";
                $qq = $this->db->query("select name from template_master where id='$para_id'")->row();
                if ($this->db->affected_rows() > 0) {
                    $para_name = $qq->name;
                }
                $table_name = $row1->table_name;
                $column_name = $row1->column_name;
                $q1 = $this->db->query("select " . $column_name . " from " . $table_name . " where
					patient_id='$patient_id'  AND branch_id='$branch_id' order by id desc");

                if ($this->db->affected_rows() > 0) {
                    $r1 = $q1->row();
                    $result_a = $r1->$column_name;
                    if (($result_a >= $min_range && $result_a <= $max_range) || $result_a == "") {

                        $alldata .= "";
                        $flagData = "";

                    } else {
                        $alldata .= '<tr>
							<td>' . $para_name . '</td>
							<td>' . $result_a . '</td>
							</tr>
							 ';
                        $cnt1++;
                    }
                }

            }
            $flag .= '<div class="d-flex">';
            $flagData = " <i class='fa fa-flag' style='color:#d580e4'></i>(" . $cnt1 . ")";
            foreach ($result as $row) {
                $min_range = $row->min_value;
                $max_range = $row->max_value;
                $para_id = $row->temp_id;
                //get para name
                $para_name = "";
                $qq = $this->db->query("select name from template_master where id='$para_id'")->row();
                if ($this->db->affected_rows() > 0) {
                    $para_name = $qq->name;
                }
                $table_name = $row->table_name;
                $column_name = $row->column_name;
                $q1 = $this->db->query("select " . $column_name . " from " . $table_name . " where
					patient_id='$patient_id'  AND branch_id='$branch_id' order by id desc");
                //	$a="";
                if ($this->db->affected_rows() > 0) {

                    $r1 = $q1->row();
                    $result_a = $r1->$column_name;
                    if (($result_a >= $min_range && $result_a <= $max_range) || $result_a == "") {

                        $flag .= "";

                    } else {
                        $flag .= '<div class=" mr-1" data-d1="' . $alldata . '" id="test1" onclick="click_vital()" style="text-align: center;">';
                        if ($cnt == 0) {
                            $flag .= $flagData;
                        }

                        $flag .= "</div>";


                    }
                    $cnt++;
                }

            }

            /* for($i=0;$i<$cnt1;$i++){

            } */


            $flag .= '</div>';
            return array($flag, $cnt);
        } else {
            return false;
        }
    }


    public function get_frequently_use_para($id)
    {
        $patient_id = 'N' . str_pad($id, '9', '0', STR_PAD_LEFT);
        $query = $this->db->query("select * from labparameter_table");
        $flag = "";
        $alldata = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $flag .= '<div class="d-flex" >';
            $cnt = 0;
            $cnt1 = 0;
            $flagData = "";
            $alldata .= "<table class='table p-2'>
			<thead>
			<tr>
			<th>Parameter Name</th>
			<th>Result</th>
			</tr>
			</thead><tbody>";
            foreach ($result as $row1) {
                $min_range = $row1->min_range;
                $max_range = $row1->max_range;
                $para_name = $row1->para_name;
                $q1 = $this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row1->para_id' order by id desc");
                if ($this->db->affected_rows() > 0) {

                    $r1 = $q1->row();

                    $result_a = $r1->result;
                    if (($result_a >= $min_range && $result_a <= $max_range) || $result_a == "") {

                        $alldata .= "";

                    } else {
                        $alldata .= '<tr>
							<td>' . $para_name . '</td>
							<td>' . $result_a . '</td>
							</tr>
							 ';
                        $cnt1++;

                    }
                }
            }
            $alldata .= "</tbody></table>";

            $flagData = " <i class='fa fa-flag' style='color:#007bff'></i>(" . $cnt1 . ")";
            foreach ($result as $row) {
                $min_range = $row->min_range;
                $max_range = $row->max_range;
                $para_name = $row->para_name;
                $q1 = $this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row->para_id' order by id desc");
                if ($this->db->affected_rows() > 0) {

                    $r1 = $q1->row();

                    $result_a = $r1->result;
                    if (($result_a >= $min_range && $result_a <= $max_range) || $result_a == "") {

                        $flag .= "";

                    } else {

                        $flag .= '<div class="tooltip-wrap mr-1" data-d1="' . $alldata . '" id="test2" onclick="click_frequent()" style="text-align: center;">';
                        if ($cnt == 0) {
                            $flag .= $flagData;
                        }
                        $flag .= " </div>";
                    }
                    $cnt++;
                }
            }
            $flag .= '</div>';

            return array($flag, $cnt);
        } else {
            return false;
        }
    }

    public function get_bedetails_info()
    {
        $room_id = $this->input->post("room_id");

        $category = 1;
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $query1 = $this->db->query("select category from " . $hospital_room_table . " where id='$room_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query1->row();
            $category = $res->category;
        }


        $query = $this->db->query("select * from " . $hospital_bed_table . " where Id_room ='$room_id' and category='$category' and branch_id=" . $this->session->user_session->branch_id);
        $edit = 1;
        $actionTh = "";

        if ($edit == 1) {
            $actionTh = "<th>Action</th>";
        }
        $permission_array = $this->session->user_permission;
        $data = '';
        $data .= '<table style="width: 100%;" id="bed_data_table" class="table table-hover table-striped table-bordered dataTable dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Bed Name</th>
                                            <th>Camera Name</th>
                                            ' . $actionTh . '

                                        </tr>
                                    </thead>';
        if ($this->db->affected_rows() > 0) {

            $result1 = $query->result();
            $k = 1;
            foreach ($result1 as $row) {

                if ($edit == 1 && in_array("bed_management", $permission_array)) {
                    //$btn_del = "<td><button type='button' onclick='delete_bed(\"" . $row->id . "\")'class='btn-icon btn-icon-only btn btn-danger btn-sm'><i class='fa fa-trash'> </i> </button></td>";
                    $btn_del = "<td>-</td>";
                } else {
                    $btn_del = "<td>-</td>";
                }
                $data .= '<tr>
                    <td>' . $k . '</td>
                    <td>' . $row->bed_name . '</td>
                    <td>' . $row->camera_name . '</td>
                    ' . $btn_del . '
                    </tr>';
                $k++;
            }
            $data .= '</table>';
            $response["status"] = 200;
            $response["result_sal"] = $data;
        } else {
            $response["result_sal"] = $data;
            $response["status"] = 201;
        }
        echo json_encode($response);
    }

    //Get Bed room Modal
    public function add_bed_btn()
    {
        $id = $this->input->post_get("id");
    }

    //Add Bedroom for particular Room

    public function add_bedroom_info()
    {
        //$room_id = $this->input->post_get("room_id");
        $room_id = $this->input->post_get("zoneDetails1");

        $category = 1;
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $query = $this->db->query("select category from " . $hospital_room_table . " where id='$room_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query->row();
            $category = $res->category;
        }
        $cnt = 1;
        for ($i = 1; $i <= 5; $i++) {
            $bed_a = $this->input->post("bed_a" . $i);
            $camera_a = $this->input->post("camera_a" . $i);

            $b = $i;

            if ($bed_a != "") {
                $bedroom_data = array(
                    "branch_id" => $this->session->user_session->branch_id,
                    "create_on" => date('Y-m-d H:m:i'),
                    "create_by" => $this->session->user_session->id,
                    "category" => $category,
                    "Id_room" => $room_id, "bed_name" => $bed_a, "camera_name" => $camera_a, "status" => "1"
                );
            } else {
                $bedroom_data = null;
            }
            if ($bedroom_data != null) {
                $query = $this->bed_model->add_bedroom($bedroom_data, $hospital_bed_table);

                if ($query == TRUE) {
                    $cnt++;
                }
            }
        }

        if ($cnt > 1) {
            $response['bedroomdata'] = $bedroom_data;
            $response["status"] = true;
            $response["body"] = "Loan added successfully.";
        } else {
            $response['bedroomdata'] = $bedroom_data;
            $response["status"] = false;
            $response["body"] = "Failed To Add Loan";
        }
        echo json_encode($response);
    }

    //Delete Particular Bed

    public function delete_bed()
    {
        $id = $this->input->post_get("id");
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $q3 = $this->db->query("Delete from " . $hospital_bed_table . " where Id= '$id'");
        if ($q3 == true) {
            $response["status"] = 200;
            $response["body"] = "Delete Room Successfully";
        } else {
            $response["status"] = 201;
            $response["body"] = "Failed To Delete Room";
        }
        echo json_encode($response);
    }

    //Delete Room

    public function delete_room()
    {
        $id = $this->input->post_get("id");
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $q3 = $this->db->query("Delete from " . $hospital_room_table . " where id= '$id'");
        if ($q3 == true) {
            $q3 = $this->db->query("Delete from " . $hospital_bed_table . " where id_room= '$id'");
            $response["status"] = 200;
            $response["body"] = "Delete Room Successfully";
        } else {
            $response["status"] = 201;
            $response["body"] = "Failed To Delete Room";
        }//                $response["query"] = $this->db->last_query();

        echo json_encode($response);
    }

    public function get_bed_type()
    {

        $get_bed = $this->bed_model->get_bed_type();
        $option = "<option value='-1' selected disabled>Select Bed Type</option>";
        if ($get_bed != false) {
            foreach ($get_bed as $row) {
                $option .= "<option value=" . $row->service_id . ">" . $row->service_description . "</option>";
            }
            $response["status"] = 200;
            $response["data"] = $option;
        } else {
            $response["status"] = 201;
            $response["data"] = $option;
        }
        echo json_encode($response);
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

    public function getLabParaFun($p_id)
    {

        $patient_id = 'N' . str_pad($p_id, '9', '0', STR_PAD_LEFT);
        $query = $this->db->query("select * from labparameter_table");
        $flag = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();

            $cnt = 0;
            $labparadata = "";
            foreach ($result as $row) {
                $min_range = $row->min_range;
                $max_range = $row->max_range;
                $para_name = $row->para_name;
                $q1 = $this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row->para_id' ");
                if ($this->db->affected_rows() > 0) {

                    $r1 = $q1->row();
                    if ($cnt <= 4) {
                        $cnt++;
                        $result_a = $r1->result;
                        if (($result_a >= $min_range && $result_a <= $max_range)) {
                            $labparadata .= '
								<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-' . $result_a . '</div>
								';


                        } else {
                            $labparadata .= '
								<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-<span style="color:red;">' . $result_a . '</span></div>
								';
                        }
                    }
                }
            }
            $onclick = '';
            if ($labparadata != "") {
                $onclick = 'onclick="getIcuPatientLabTestPara(' . $p_id . ')"';
            }
            $flag .= '<div class="text-center" ' . $onclick . ' style="cursor:pointer;font-size:11px;height:150px;/* overflow: scroll; */
			    position: absolute;
			    top: 6px;
			    /* bottom: 0px; */
			   left: 5px; 
			    right: -13px;
			    overflow: auto;">';
            $flag .= $labparadata;
            $flag .= '</div>';

            return $flag;
        } else {
            return false;
        }
    }

    public function get_vital_sign_paradata($patient_id)
    {
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $query = $this->db->query("select *,(select name from template_master where id=temp_id) as tem_name from icu_patient_para where branch_id='$branch_id' AND company_id='$company_id'");
        $flag = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();

            $cnt = 0;
            $vitalSigndata = "";
            foreach ($result as $row) {
                $min_range = $row->min_value;
                $max_range = $row->max_value;

                $para_name = $row->tem_name;
                //get para name

//				$qq = $this->db->query("select name from template_master where id='$para_id'")->row();
//				if ($this->db->affected_rows() > 0) {
//					$para_name = $qq->name;
//				}
                $table_name = $row->table_name;
                $column_name = $row->column_name;
                $q1 = $this->db->query("select " . $column_name . " from " . $table_name . " where
					patient_id='$patient_id'  AND branch_id='$branch_id' order by id desc");

                if ($this->db->affected_rows() > 0) {

                    $r1 = $q1->row();
                    if ($cnt <= 4) {
                        $cnt++;
                        $result_a = $r1->$column_name;
                        if (($result_a >= $min_range && $result_a <= $max_range)) {

                            $vitalSigndata .= '
							<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-' . $result_a . '</div>
							';

                        } else {
                            $vitalSigndata .= '
							<div style="border-bottom:1px solid #d3d3d38c;padding:5px;">' . $para_name . '-<span style="color:red;">' . $result_a . '</span></div>
							';
                        }
                    }
                }
            }
            $onclick = '';
            if ($vitalSigndata != "") {
                $onclick = 'onclick="getIcuPatientVitalSignPara(' . $patient_id . ')"';
            }
            $flag .= '<div class="text-center" ' . $onclick . ' style="cursor:pointer;font-size:11px; height: 150px;
				    /* overflow: scroll; */
				    position: absolute;
				    top: 6px;
				    /* bottom: 0px; */
				    left: 5px; 
				    right: -13px;
				    overflow: auto;">';
            $flag .= $vitalSigndata;
            $flag .= '</div>';

            return $flag;//$this->getVitalSignLive($patient_id);
        } else {
            return "-";//function for vital sign
        }

    }

    public function getVitalSignLive1($bed_id)
    {
//		$d=$this->getVitalSignLive($bed_id);
//		var_dump($d);
//		exit();
        $this->db2 = $this->load->database('live', TRUE);
//		$query = $this->db3->query("select * from patient_monitor_live_data where patient_id=1 order by id desc limit 1");
        $query = $this->db2->query("select * from patient_monitor_live_data where patient_id=" . $bed_id);
//		echo $this->db2->last_query();
        var_dump($query->row());
    }

    public function getVitalSignLive2($bed_id)
    {
        $object = new stdClass();

        $this->db2 = $this->load->database('live', TRUE);
//		$query = $this->db3->query("select * from patient_monitor_live_data where patient_id=1 order by id desc limit 1");
        $query = $this->db2->query("select * from patient_monitor_live where patient_id=" . $bed_id);
        $hrbpm = "-";
        $RR = "-";
        $spo2 = "-";
        $nibp = "-";
        $PR = "-";
        $ST = "-";
        $PVCS = "-";
        $Temp = "-";
        $mmsg = "-";
        $param1 = "-";
        $object->object = "select * from patient_monitor_live where patient_id=" . $bed_id;

        $row = $query->row();
        $object->object = $row;

        if (!is_null($row)) {
            $hr_bpm_value = (int)$row->HR_BPM;
            if ($hr_bpm_value >= 50 && $hr_bpm_value <= 220) {
                $hrbpm = $row->HR_BPM;
            } else {
                $hrbpm = "";
            }
            $rr_rpm_value = (int)$row->RR_RPM;
            if ($rr_rpm_value >= 12 && $rr_rpm_value <= 50) {
                $RR = $row->RR_RPM;
            } else {
                $RR = "";
            }
            $spo2_value = (int)$row->SPO2;
            if ($spo2_value >= 80 && $spo2_value <= 150) {
                $spo2 = $row->SPO2;
            } else {
                $spo2 = "";
            }

            $nibp_value = (int)$row->NIBP;
            if ($nibp_value >= 10 && $nibp_value <= 200) {
                $nibp = $row->NIBP;
            } else {
                $nibp = "";
            }
            $PR = "-";//$row->PR;
            $ST = "-";//$row->ST;
            $PVCS = "-";//$row->PVCS;
            $Temp = $row->TEMP;
            $mmsg = "-";//$row->mmsg;
            $param1 = "-";// $row->param1;
        }

        $flag1 = '<div class="row">
	<div class="col-md-6"
		 style="border: 2px solid red;border-right: none;">
		<div class="row">
			<div class="col-sm-6 text-left">
				<div class="row">
					<div class="col-sm-12 p-0"><span style="font-size:11px;">HR Bpm</span></div>
				</div>
				<div class="row" style="height:20px">
				</div>
				<div class="text-center"><span style="font-size:1.3rem;font-weight:900;color:#00fc00">' . $hrbpm . '</span></div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12 text-left"><span style="font-size:10px;">SpO2 %</span></div>
				</div>
				<div class="row" style="height:20px">
				</div>
				<div class="text-center"><span style="font-size:1.3rem;font-weight:900;color:#cece5c">' . $spo2 . '</span></div>
			</div>
		</div>
	</div>
	<div class="col-md-6" style="border: 2px solid red;">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-sm-12 text-left"><span style="font-size:10px;">RR rpm</span></div>
				</div>
				<div class="row" style="height:20px">
				</div>
				<div class="text-center"><span style="font-size:1.3rem;font-weight:900;color:#08fcf8">' . $RR . '</span></div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-sm-12 p-0"><span style="font-size:11px;">Nibp mmsg</span></div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6 text-left">
						<span style="font-size:10px;font-weight:900;color:red">' . $param1 . '</span>
					</div>
					<div class="col-sm-12 col-md-6 text-right">
						<span class="text-right" style="font-size:10px;font-weight:900;color:red">' . $mmsg . '</span>
					</div>
				</div>
				<div class="text-center"><span style="font-size:1.3rem;font-weight:900;color:red">' . $nibp . '</span></div>
			</div>
		</div>
	</div>
</div>';
        $object->flag = $flag1;

        return $object;
    }

    public function getVitalSignLive($bed_id)
    {
        $object = new stdClass();

        $this->db2 = $this->load->database('live', TRUE);
//		$query = $this->db3->query("select * from patient_monitor_live_data where patient_id=1 order by id desc limit 1");
        $query = $this->db2->query("select * from patient_monitor_live where patient_id=" . $bed_id);
        $hrbpm = "-";
        $RR = "-";
        $vTemp = "-";
        $spo2 = "-";
        $nibp = "-";
        $PR = "-";
        $ST = "-";
        $PVCS = "-";
        $Temp = "-";
        $mmsg = "-";
        $param1 = "-";
        $bp1 = "-";
        $bp2 = "-";
        $bp3 = "-";
        $object->object = "select * from patient_monitor_live where patient_id=" . $bed_id;

        $row = $query->row();
        $object->object = $row;
        $date = "";
        if (!is_null($row)) {
            $date = date('d M h:i a', strtotime($row->p_datetime));
            $hr_bpm_value = (int)$row->HR_BPM;
            if ($hr_bpm_value >= 5 && $hr_bpm_value <= 220) {
                $hrbpm = $row->HR_BPM;
            } else {
                $hrbpm = "";
            }
            $rr_rpm_value = (int)$row->RR_RPM;
            if ($rr_rpm_value >= 5 && $rr_rpm_value <= 220) {
                $RR = $row->RR_RPM;
            } else {
                $RR = "";
            }
            $spo2_value = (int)$row->SPO2;
            if ($spo2_value >= 5 && $spo2_value <= 220) {
                $spo2 = $row->SPO2;
            } else {
                $spo2 = "";
            }

            $nibp_value = (int)$row->NIBP;
            if ($nibp_value >= 5 && $nibp_value <= 220) {
                $nibp = $row->NIBP;
            } else {
                $nibp = "";
            }
            $temp_value = (int)$row->TEMP;
            if ($temp_value >= 1 && $temp_value <= 50) {
                $vTemp = $row->TEMP;
            } else {
                $vTemp = "";
            }
            $bp1_value = (int)$row->BP1;
            if ($bp1_value >= 5 && $bp1_value <= 500) {
                $bp1 = $row->BP1;
            } else {
                $bp1 = "";
            }
            $bp2_value = (int)$row->BP2;
            if ($bp2_value >= 5 && $bp2_value <= 500) {
                $bp2 = $row->BP2;
            } else {
                $bp2 = "";
            }
            $bp3_value = (int)$row->BP3;
            if ($bp3_value >= 5 && $bp3_value <= 500) {
                $bp3 = $row->BP3;
            } else {
                $bp3 = "";
            }
            $PR = "-";//$row->PR;
            $ST = "-";//$row->ST;
            $PVCS = "-";//$row->PVCS;
            $Temp = $row->TEMP;
            $mmsg = "-";//$row->mmsg;
            $param1 = "-";// $row->param1;
        }

        $flag1 = '
				<style>
					.vitalStickyNote
					{
						margin: 5px auto;
						  font-family: "Lato";
						  background:#fafafa;
						  color:#fff;
						  margin:0!important;
 						 padding:0!important;		
						 
					}
					.h2_sticky
					{
						 font-weight: bold;
						 font-size:10px!important;
					}
					.sticky_value
					{
						
  						 font-size:20px!important;
  						 text-align:center;
  						 font-weight:bold;
  						 padding: 0.2em 0!important;
					}
					.sticky_ul,.sticky_li
					{
						 list-style:none!important;
						 text-decoration:none!important;
					}
					.sticky_ul
					{
						 margin: 0px;
    					 padding: 25px;
						 display: flex!important;
						  flex-wrap: wrap!important;
						  // justify-content: center!important;
						

					}
					.sticky_a
					{
						text-decoration:none!important;
					  color:#000;
					  background:#fccc;
					  display:block;
					  height:4em;
					  width:3em;
					  padding:.5em;
					  box-shadow: 5px 5px 7px rgba(33,33,33,.7);
					  transition: transform .15s linear;
					}	
					.sticky_a1
					{
						text-decoration:none!important;
					  color:#000;
					  background:#fccc;
					  display:block;
					  height:6em;
					  width:10em;
					  padding:.5em;
					  box-shadow: 5px 5px 7px rgba(33,33,33,.7);
					  transition: transform .15s linear;
					}
					.sticky_li
					{
						margin:0.3em;
					}					
				</style>
				<div class="row">
					<div class="vitalStickyNote">
						<ul class="sticky_ul">
						  <li class="sticky_li">
							<a class="sticky_a" style="background:#ff7455">
							  <h2 class="h2_sticky">HR Bpm</h2>
							  <p class="sticky_value">' . $hrbpm . '</p>
							</a>
						  </li>
						  <li class="sticky_li">
							<a class="sticky_a" style="background:#1ba8b1">
							  <h2 class="h2_sticky">SpO2 %</h2>
							  <p class="sticky_value">' . $spo2 . '</p>
							</a>
						  </li>
						  <li class="sticky_li">
							<a class="sticky_a" style="background:#ff0079">
							  <h2 class="h2_sticky">RR rpm</h2>
							  <p class="sticky_value">' . $RR . '</p>
							</a>
						  </li>
						  <li class="sticky_li">
							<a class="sticky_a" style="background:#cc00ff">
							  <h2 class="h2_sticky">PR mmsg</h2>
							  <p class="sticky_value">' . $nibp . '</p>
							</a>
						  </li>					 
							<li class="sticky_li">
							<a class="sticky_a" style="background:#8500ff">
							  <h2 class="h2_sticky">Temp</h2>
							  <p class="sticky_value">' . $vTemp . '</p>
							</a>
						  </li>	
						<!--<li class="sticky_li">
							<a class="sticky_a1" style="background:#e244b1">
							 <div class="d-flex justify-content-around">
							 <h6 class="h2_sticky" style="font-size :10px">Sys<br><span class="" style="font-size :18px">' . $bp1 . '</span></h6>
							 <h6 class=" pl-3" style="font-size :10px">Dia<br><span class=""  style="font-size :18px">' . $bp2 . '</span></h6> 
							 </div>
							<div  align="center">
							    <h6 class="h2_sticky" style="font-size :10px" >Mean<br><span class="" style="font-size :18px">' . $bp3 . '</span></h6>
							 </div>
							</a>
						  </li>-->	
						</ul>
					</div>

				</div>
				</div>
				<div class="row justify-content-center">
					<small class="py-1 font-italic">' . $date . '</small>
				</div>
				';
        $flagnew = "<span style='color:#ff7455'>" . $hrbpm . "</span>";
        $flagnew .= "<span style='color:#1ba8b1'>|" . $spo2 . "</span>";
        $flagnew .= "<span style='color:#ff0079'>|" . $RR . "</span>";
        $flagnew .= "<span style='color:#cc00ff'>|" . $nibp . "</span>";

        $object->flag = $flag1;
        $object->flagnew = $flagnew;

        return $object;
    }

    public function get_icuPtientScheduleMedicine()
    {
        $id = $this->input->get_post('id');
        $patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $medicineInfo = "";
        $medicineTable = "medicine_master";
        $patientMedicineResult = $this->db->query('select pm.*,(select mm.name from ' . $medicineTable . ' mm where mm.id=pm.name) as medicine_name from ' . $patient_mediine_table . ' pm where pm.p_id=' . $id . ' and branch_id=' . $this->session->user_session->branch_id . ' and status=1  order by id desc')->result();

        // print_r($patientMedicineResult);exit();
        if (count($patientMedicineResult) > 0) {

            $start_date = "";
            $medicineInfo .= "<div>";


            foreach ($patientMedicineResult as $key => $m_value) {
                // print_r($m_value);exit();
                $start_date = date('d M', strtotime($m_value->start_date));
                $dateRang = $this->getDatesFromRange($m_value->start_date, $m_value->end_date);
                $totalDay = count($dateRang);
                $todaydate = date('Y-m-d');
                if (in_array($todaydate, $dateRang)) {

                    $medicineInfo .= "<div style='font-size:11px;'>" . $m_value->medicine_name . " - " . $start_date . " - " . $totalDay . " Days - " . $m_value->total_iteration . "/Day</div><hr/>";


                }

            }


            $medicineInfo .= "</div>";
            $response["status"] = 200;
            $response["data"] = $medicineInfo;
        } else {
            $response["status"] = 201;
            $response["data"] = $medicineInfo;
        }
        echo json_encode($response);
    }

    function random_color_part()
    {
        return str_pad(dechex(mt_rand(22, 206)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public function getIcuPatientLabTestPara()
    {

        $p_id = $this->input->post('patient_id');
        $patient_id = 'N' . str_pad($p_id, '9', '0', STR_PAD_LEFT);
        $query = $this->db->query("select * from labparameter_table");
        $flag = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $flag .= '<div class="">';
            $cnt = 0;
            foreach ($result as $row) {
                $min_range = $row->min_range;
                $max_range = $row->max_range;
                $para_name = $row->para_name;
                $q1 = $this->db->query("select * from excel_structure_data where
					Patient_number='$patient_id' AND ParameterId='$row->para_id' order by id desc limit 1");
                if ($this->db->affected_rows() > 0) {
                    $cnt++;
                    $r1 = $q1->row();

                    $result_a = $r1->result;
                    if (($result_a >= $min_range && $result_a <= $max_range)) {
                        $flag .= '<div class="align-items-center justify-content-center text-right row">
									<div class="col-md-4 text-left" style="text-overflow: ellipsis; word-break: break-all; font-size: small;">' . $para_name . '</div>
									<div class="col-md-3"><div class="d-flex flex-column"> <span>' . $result_a . '</span><span class="small">' . $r1->VisitDate . '</span></div></div>
									<div class="col-md-3">' . $min_range . ' - ' . $max_range . '</div>
									<div class="col-md-2">' . $row->unit . '</div>
								  </div>
								<hr class="m-2"/>
								';


                    } else {
                        $flag .= '
								 <div class="align-items-center justify-content-center text-right row">
									<div class="col-md-4 text-left" style="text-overflow: ellipsis; word-break: break-all; font-size: small;">' . $para_name . '</div>
									<div class="col-md-3"><div class="d-flex flex-column"> <span style="color:red;">' . $result_a . '</span><span class="small">' . $r1->VisitDate . '</span></div></div>
									<div class="col-md-3">' . $min_range . ' - ' . $max_range . '</div>
									<div class="col-md-2">' . $row->unit . '</div>
								  </div><hr class="m-2"/>
								';
                    }

                }
            }
            $flag .= '</div>';

            $response['status'] = 200;
            $response['data'] = $flag;
        } else {
            $response['status'] = 201;
            $response['data'] = $flag;
        }
        echo json_encode($response);
    }


    public function getIcuPatientVitalSignPara()
    {
        $p_id = $this->input->post('patient_id');
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $query = $this->db->query("select * from icu_patient_para where branch_id='$branch_id' AND company_id='$company_id'");
        $flag = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $flag .= '<div>';
            $cnt = 0;
            foreach ($result as $row) {
                $min_range = $row->min_value;
                $max_range = $row->max_value;
                $para_id = $row->temp_id;
                //get para name
                $para_name = "";
                $qq = $this->db->query("select name from template_master where id='$para_id'")->row();
                if ($this->db->affected_rows() > 0) {
                    $para_name = $qq->name;
                }
                $table_name = $row->table_name;
                $column_name = $row->column_name;
                $q1 = $this->db->query("select " . $column_name . " from " . $table_name . " where
					patient_id='$p_id'  AND branch_id='$branch_id' order by id desc");

                if ($this->db->affected_rows() > 0) {
                    $cnt++;
                    $r1 = $q1->row();
                    $result_a = $r1->$column_name;
                    if (($result_a >= $min_range && $result_a <= $max_range)) {

                        $flag .= '
							<div style="">' . $para_name . '-' . $result_a . '</div><hr/>
							';

                    } else {
                        $flag .= '
							<div style="">' . $para_name . '-<span style="color:red;">' . $result_a . '</span></div><hr/>
							';
                    }
                }
            }

            $flag .= '</div>';

            $response['status'] = 200;
            $response['data'] = $flag;
        } else {
            $response['status'] = 201;
            $response['data'] = $flag;
        }
        echo json_encode($response);
    }

    public function get_icuPatientList()
    {
        // $serachGender=$this->input->get_post('gender');
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_table = $this->session->user_session->patient_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table
        $patient_mediine_table = $this->session->user_session->patient_mediine_table;//dose details table
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;

        // $s_gender="";
        //  if($serachGender==1)
        // {
        // 	$s_gender="and gender = 1";
        // }
        // else if($serachGender==2)
        // {
        // 	$s_gender="and gender = 2";
        // }
        $options = "";

        $query_get_bed = $this->db->query("select * from " . $hospital_bed_table . " where category=2 and status=0 and branch_id=" . $this->session->user_session->branch_id);
        $result11 = $query_get_bed->result();
        $test1 = array();
        if (count($result11) > 0) {

            $gender = "";
            $options .= "<option selected disabled>Select Patient</option>";
            $options .= '<option value="">All</option>';
            foreach ($result11 as $row1) {

                if ((int)$row1->status == 0) {
                    $patientNameResult = $this->db->query('select id,patient_name,adhar_no,blood_group,gender,contact,patient_image,birth_date,admission_date,admission_mode,type from ' . $patient_table . ' where id =(select patient_id from ' . $patient_bed_history_table . ' where bed_id=' . $row1->id . ' and branch_id=' . $this->session->user_session->branch_id . ' and status=1 order by id desc limit 1)')->result();
                    //echo count($patientNameResult);
                    if (count($patientNameResult) > 0) {

                        $patient_name = $patientNameResult[0]->patient_name;
                        $id = $patientNameResult[0]->id;

                        // if($gender==1){
                        // 	$gen =  "Male";
                        // }
                        // else if($gender==2){
                        // 	$gen =  "Female";
                        // }
                        // else{
                        // 	$gen =  "Other";
                        // }

                        // $age = (date('Y') - date('Y',strtotime($patientNameResult[0]->birth_date)));


                        $response["patientName"][] = $this->db->last_query();


                        $options .= '<option value="' . $id . '">' . $patient_name . '</option>';

                    }


                }


            }
            $response['status'] = 200;
            $response['options'] = $options;
        } else {
            $response['status'] = 201;
            $response['options'] = $options;
        }
        echo json_encode($response);
    }

    public function GetIcuBedData()
    {
        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_table = $this->session->user_session->patient_table;//hospital_bed_table
        $branch_id = $this->session->user_session->branch_id;
        $company_id = $this->session->user_session->company_id;
        $sql = 'SELECT id,camera_name,bed_name,
		(select group_concat(patient_name,"|",id) from ' . $patient_table . ' p where p.bed_id=c.id)
		as patient_name FROM ' . $hospital_bed_table . ' c where category=2 AND status=0 AND branch_id=' . $branch_id;

        $query = $this->bed_model->getIcuBedData($sql);
        $data = "";
        $cameraImage = array();
        $c_name = "";
        if ($query != False) {
            foreach ($query as $row) {

                $p_data = $row->patient_name;
                if (!is_null($p_data)) {
                    $exxp = explode("|", $p_data);
                    $p_name = $exxp[0];
                    $camera_name = $row->camera_name;
                    $exxp1 = explode("|", $camera_name);

                    /* var_dump($exxp1);
                    echo count($exxp1); */
                    if (is_array($exxp1) && count($exxp1) != 0 && $exxp1[0] != "") {
                        $c_name = trim($exxp1[0]) . trim($exxp1[1]);
                    }
                    array_push($cameraImage, $c_name);
                    if ($c_name == "") {
                        $img = '<img src="https://covidcare.docango.com/assets/img/not-available.jpg" id="L_" class="p-1" style="width: 200px;height:150px;border:2px  black" alt="No Video Available">';
                    } else {
                        $img = '<img src="https://vs.docango.com/images/picture_' . $c_name . '.jpg" id="' . $c_name . '" class="p-1"style="width: 200px;height:150px;border:2px  black" alt="centered image" />';
                    }
                    $data .= '<div class=" d-flex flex-column align-items-center">			
			<div data-toggle="modal" data-target="#largeVideo" data-camera="' . $c_name . '" >
			' . $img . '
			
			</div>
			<span style="font-size:8px;text-transform: capitalize;">' . $p_name . '(' . $row->bed_name . ')</span>
			<span id="vitaDataNew' . $exxp[1] . '" class="row" ></span>
			</div>';
                }
            }
            $response['status'] = 200;
            $response['data'] = $data;
            $response["cameraCode"] = $cameraImage;
        } else {
            $response['status'] = 201;
            $response['data'] = "";
        }
        echo json_encode($response);


    }



    public function get_occupiedroomdetails_info()
    {

        $hospital_room_table = $this->session->user_session->hospital_room_table;//hospital_room_table
        $hospital_bed_table = $this->session->user_session->hospital_bed_table;//hospital_bed_table
        $patient_table = $this->session->user_session->patient_table;//hospital_bed_table
        $patient_bed_history_table = $this->session->user_session->patient_bed_history_table;//patient_bed_history_table

        $query = $this->db->query("select * from " . $hospital_room_table . " where branch_id=" . $this->session->user_session->branch_id);
        $edit = 1;
        $actionTh = "<th>Action</th>";

        $data = '';

        $pTotal =0;
        $template = '<div id="bedAccordion">';
        if ($this->db->affected_rows() > 0) {

            $result1 = $query->result();
            $k = 1;

            foreach ($result1 as $row) {
                $room_get = $row->id;
                $query_get_bed = $this->db->query("select * from " . $hospital_bed_table . " where Id_room ='$room_get' and category=1 and status=0 and branch_id=" . $this->session->user_session->branch_id);
                $result11 = $query_get_bed->result();
                $test1 = array();
                $rooms = "";

                foreach ($result11 as $row1) {
                    $test1[] = $row1->bed_name;
                    if ((int)$row1->status == 0) {
                        $patientNameResult = $this->db->query('select id,patient_name,adhar_no,contact,patient_image,admission_date,admission_mode from ' . $patient_table . ' where (discharge_date is null OR discharge_date = "0000-00-00 00:00:00") and id =(select patient_id from ' . $patient_bed_history_table . ' where room_id=' . $room_get . ' and bed_id=' . $row1->id . ' and branch_id=' . $this->session->user_session->branch_id . '  order by id desc limit 1) ')->result();

                        if (count($patientNameResult) > 0) {

                            $patient_name = $patientNameResult[0]->patient_name;
                            $id = $patientNameResult[0]->id;
                            $adhar_number = $patientNameResult[0]->adhar_no;
                            $concat = $patientNameResult[0]->contact;
                            $profile = $patientNameResult[0]->patient_image =="" ? "https://covidcare.docango.com/assets/img/avatar/avatar-1.png" : $patientNameResult[0]->patient_image ;
                            $adminDate = $patientNameResult[0]->admission_date;
                            $adminMode = $patientNameResult[0]->admission_mode;
                            $status = "text-danger";
                            $onclick = ' style="cursor:pointer" onclick="loadPatient(`' . $id . '`,`' . $patient_name . '`,`' . $adhar_number . '`,`' . $concat . '`,`' . $profile . '`,`' . $adminDate . '`,`' . $adminMode . '`,1,2)"';
                            $criticalData = $this->db->query('select blood_test_result,SPO2_status,RR_status,HR_status,cormobodies_status from patient_critical_data where patient_id='.$id.' and branch_id='.$this->session->user_session->branch_id)->row();
                            $bedClassName="#239f38";
                            if(!is_null($criticalData)){
                                $blood_test_result =(int)$criticalData->blood_test_result;
                                $SPO2_status =(int)$criticalData->SPO2_status;
                                $RR_status =(int)$criticalData->RR_status;
                                $HR_status =(int)$criticalData->HR_status;
                                $cormobodies_status =(int)$criticalData->cormobodies_status;
                                if( $SPO2_status ==0 || $RR_status ==0||$HR_status ==0){
                                    $bedClassName="#6d6a6d";
                                }else {
                                    if ($blood_test_result == 4 || $SPO2_status == 4 || $RR_status == 4 || $HR_status == 4 || $cormobodies_status == 4) {
                                        $bedClassName = "#ff0000";// VeryHigh
                                    } else {
                                        $secondConditionCount = 0;
                                        if ($blood_test_result == 3) {
                                            $secondConditionCount++;
                                        }
                                        if ($SPO2_status == 3) {
                                            $secondConditionCount++;
                                        }
                                        if ($RR_status == 3) {
                                            $secondConditionCount++;
                                        }
                                        if ($HR_status == 3) {
                                            $secondConditionCount++;
                                        }
                                        if ($cormobodies_status == 3) {
                                            $secondConditionCount++;
                                        }

                                        if ($secondConditionCount >= 3) {
                                            $bedClassName = "#ff0000";//VeryHigh
                                        } else {
                                            $medCount = 0;
                                            $lowCount = 0;
                                            $highCount = 0;
                                            // blood_test_result
                                            if ($blood_test_result == 1) {
                                                $lowCount++;
                                            }
                                            if ($blood_test_result == 2) {
                                                $medCount++;
                                            }
                                            if ($blood_test_result == 3) {
                                                $highCount++;
                                            }
                                            // SPO2_status
                                            if ($SPO2_status == 1) {
                                                $lowCount++;
                                            }
                                            if ($SPO2_status == 2) {
                                                $medCount++;
                                            }
                                            if ($SPO2_status == 3) {
                                                $highCount++;
                                            }
                                            // RR_status
                                            if ($RR_status == 1) {
                                                $lowCount++;
                                            }
                                            if ($RR_status == 2) {
                                                $medCount++;
                                            }
                                            if ($RR_status == 3) {
                                                $highCount++;
                                            }
                                            // HR_status
                                            if ($HR_status == 1) {
                                                $lowCount++;
                                            }
                                            if ($HR_status == 2) {
                                                $medCount++;
                                            }
                                            if ($HR_status == 3) {
                                                $highCount++;
                                            }
                                            // cormobodies_status
                                            if ($cormobodies_status == 1) {
                                                $lowCount++;
                                            }
                                            if ($cormobodies_status == 2) {
                                                $medCount++;
                                            }
                                            if ($cormobodies_status == 3) {
                                                $highCount++;
                                            }

                                            if ($highCount != 0) {
                                                $bedClassName = "#ca2dd4";//high
                                            } else {
                                                if ($medCount >= $lowCount) {
                                                    $bedClassName = "#239f38";// med
                                                } else {
                                                    $bedClassName = "#239f38"; // low
                                                }
												if ($medCount >= 1) {
													$bedClassName = "#239f38";// med
												}
                                            }
                                        }
                                    }
                                }
                            }
                            $pTotal++;
                            $rooms .= '<div class="card mb-0 mx-2" ' . $onclick . '>
								<div class="card-body p-3 text-center">
									<i class="fas fa-bed ' . $status . '" style="font-size: x-large;color:'.$bedClassName.'!important;"></i>
									<h3>' . $row1->bed_name . '</h3>
									<small>' . $patient_name . '</small>
								</div>
							</div>';
                        }
                        $response["patientName"][] = $this->db->last_query();
                    }
                }

                $template .= '<div class="accordion">
								<div class="accordion-header" role="button" data-toggle="collapse"  data-target="#panel-body-' . $row->id . '" aria-expanded="false">
                         		 	<h4>' . $row->room_no . ' ' . $row->ward_no . '</h4>
                       			 </div>
                       			 <div class="accordion-body collapse show" id="panel-body-' . $row->id . '" data-parent="#bedAccordion">
                       			 	<div class="row justify-content-end row">
										
																				    
                       			 	</div> 
                       			 	<div class="row align-items-center">
                        					' . $rooms . '
									</div>
                       			 </div>
                       		</div> ';
                $k++;
            }
            $template .= "</div>";
            $response["pTotal"]=$pTotal;
            $response["status"] = 200;
            $response["result_sal"] = $template;
        } else {
            $template = '';
            $response["result_sal"] = $template;
            $response["status"] = 201;
        }
        echo json_encode($response);
    }

    function refreshBed(){
		$patient_table = $this->session->user_session->patient_table;//hospital_bed_table
		$branch_id = $this->session->user_session->branch_id;
		$query=$this->db->query("select id,(select discharge_date from ".$patient_table." where id=(select (patient_id)  from com_1_bed_history where bed_id=cb.id order by id desc limit 1)) as discharge_date
from com_1_bed cb where status=0 and active=0 and  branch_id=".$branch_id);
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			$count=0;
			foreach ($result as $row){
				$bed_id=$row->id;
				$discharge_date=$row->discharge_date;
				if(!is_null($discharge_date)){
					$where=array("id"=>$bed_id);
					$set=array("status"=>1);
					$update=$this->db->update("com_1_bed",$set,$where);
					if($update == true){
						$count++;
					}
				}
			}
			if($count > 0){
				$response['status']=200;
				$response['body']="Beds Refresh Successfully.";
			}else{
				$response['status']=201;
				$response['body']="No beds available for refresh";
			}
		}else{
			$response['status']=201;
			$response['body']="Something went wrong.";
		}echo json_encode($response);
	}


}
