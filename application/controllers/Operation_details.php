<?php

include_once 'HexaController.php';

/**
 * @property  MedicineOrderModel MedicineOrderModel
 * @property  Global_model Global_model
 */
class Operation_details extends HexaController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MedicineOrderModel");
        $this->load->model("Global_model");
    }

    public function index()
    {
        $this->load->view("Operation_details/opertaion_master", array("title" => "Operation Details"));
    }

    public function SaveOperation()
    {
        $date=$this->input->post('opr_plan_date');
        $opr_comment=$this->input->post('opr_comment');
        $patient_id=$this->input->post('patient_id');
        $upload_path = "uploads";
        $combination = 2;
        $name_input="userfile";
        $result = $this->upload_file($upload_path, $name_input, $combination);
        if ($result->status) {
            if ($result->body[0] == "uploads/") {
                $input_data = "";
            } else {
                $input_data = $result->body[0];
            }

        } else {
            $input_data = "";
        }
        $branch_id=$this->session->user_session->branch_id;
        $user_id=$this->session->user_session->id;
        $data=array(
            "comment"=>$opr_comment,
            "plan_date"=>$date,
            "file"=>$input_data,
            "branch_id"=>$branch_id,
            "patient_id"=>$patient_id,
            "user_id"=>$user_id
        );
        $insert=$this->db->insert("operation_master",$data);
        if($insert == true){
            $response['status']=200;
            $response['body']="Added Successfully";
        }else{
            $response['status']=201;
            $response['body']="Failed To Add";
        }echo json_encode($response);
    }
    function GetOpertaionDeatilsTable(){
        $patient_id=$this->input->post('patient_id');
        $branch_id=$this->session->user_session->branch_id;
        $query=$this->db->query("select * from operation_master where patient_id=".$patient_id." AND branch_id=".$branch_id);
        $html="";
        if($this->db->affected_rows() > 0){
            $result=$query->result();
            $html .="<table class='table  table-bordered'>
					<thead>
					<tr>
					<th>Date</th>
					<th>Details</th>
					<th>File</th>
					<th>Action</th>
</tr>
</thead>
<tbody>
";
            foreach ($result as $row){
                //<a href='".$row->comment."' class='btn btn-link' download>Download</a>
                if($row->file == ""){
                    $d_btn="-";
                }else{
                    $d_btn="<a href='".$row->file."' class='btn btn-link' download>Download</a>";
                }

                $html .="
				<tr>
				<td>".$row->plan_date."</td>
				<td>".$row->comment."</td>
				<td>".$d_btn."</td>
				<td><button type='button' class='btn btn-link' onclick='gotoOTDeatils(".$row->id.",".$branch_id.")'>View</button></td>
</tr>
				";
            }
            $html .="</tbody></table>";
            $response['status']=200;
            $response['data']=$html;
        }else{
            $html="";
            $response['status']=200;
            $response['data']=$html;
        }echo json_encode($response);
    }
}