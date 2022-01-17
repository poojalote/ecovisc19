<?php
require_once 'HexaController.php';

/**
 * @property  BranchModel BranchModel
 * @property  DepartmentModel DepartmentModel
 */
class SecurityController extends HexaController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('security/securityManagement', array("title" => "Security Management"));
    }


    // ------------------ otp management

    public function security()
    {
        $response = array();
        $branch_id = $this->session->user_session->branch_id;
        $data = $this->db->query('SELECT otp,expiry_on,(SELECT user_name FROM users_master where id = user_id) as username,
(SELECT name FROM users_master where id = user_id) as name,
(SELECT mobile_number FROM users_master where id = user_id) as mobile,
(SELECT name FROM branch_master 	where id = branch_id) as branch_name
 FROM otp_master where
 date(expiry_on)="'.date("Y-m-d").'" order by id desc')->result();
        // $table_row = '';
        $row_data = array();
        if (!empty($data)) {

            foreach ($data as $value) {
                $row = array(
                    $value->otp,
                    $value->expiry_on,
                    $value->name,
                    $value->username,
                    $value->branch_name,
					$value->mobile
                );
                array_push($row_data, $row);
            }

            $response['status'] = 200;
            $response['data'] = $row_data;
            $response['last_q'] = $this->db->last_query();
        } else {
            $response['status'] = 201;
            $response['data'] = $row_data;
            $response['last_q'] = $this->db->last_query();
        }

        echo json_encode($response);


    }
}
