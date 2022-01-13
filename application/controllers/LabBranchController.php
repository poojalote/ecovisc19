<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'HexaController.php';

/**
 * @property  Company_model Company_model
 * @property  DepartmentModel DepartmentModel
 */
class LabBranchController extends HexaController
{


    /**
     *  LabBranchController constructor.

     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("LabBranchModel");
    }


    function upload_lab_branch()
    {
        $validationObject = $this->is_parameter(array("lab_branch_name"));
        if($validationObject->status)
        {
            $param=$validationObject->param;
            $lab_id = $this->input->post('forward_lab_branch');
            $name = $this->input->post('lab_branch_name');
            $address = $this->input->post('lab_branch_address');
            $mobile = $this->input->post('lab_branch_mobile');
            $email = $this->input->post('lab_branch_email');
            $lab_branch_logo = $this->input->post('lab_branch_logo');
            $forward_lab_branch_logo = $this->input->post('forward_lab_branch_logo');


            if($_FILES['lab_branch_logo']['name'] != "")
            {
                $_FILES['lab_branch_logo']['name'] = $_FILES['lab_branch_logo']['name'];
                $_FILES['lab_branch_logo']['type'] = $_FILES['lab_branch_logo']['type'];
                $_FILES['lab_branch_logo']['tmp_name'] = $_FILES['lab_branch_logo']['tmp_name'];
                $_FILES['lab_branch_logo']['error'] = $_FILES['lab_branch_logo']['error'];
                $_FILES['lab_branch_logo']['size'] = $_FILES['lab_branch_logo']['size'];
                $config['upload_path'] = 'uploads/lab_branch_logo/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '500000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $fileName = "lab_branch_logo/".$_FILES['lab_branch_logo']['name'];
                $data = array('upload_data' => $this->upload->data());
                $file = $this->upload->do_upload('lab_branch_logo');
            }
            else
            {
                $fileName = $forward_lab_branch_logo;
            }
            if(!is_null($lab_id))
            {
                $update_data = array(
                    "name" => $name,
                    "mobile" => $mobile,
                    "email" => $email,
                    "address" => $address,
                    "logo" => isset($fileName) ? $fileName : null
                );
                $update = $this->LabBranchModel->insert_data($update_data,$lab_id);
                if($update)
                {
                    $response["status"]=200;
                    $response["body"]= 'Data Updated';
                }
                else
                {
                    $response["status"]=201;
                    $response["body"]="Unable to Update Changes";
                }
            }
            else
            {
                $update_data = array(
                    "name" => $name,
                    "mobile" => $mobile,
                    "email" => $email,
                    "address" => $address,
                    "logo" => isset($fileName) ? $fileName : null
                );
                $update = $this->LabBranchModel->insert_data($update_data,$lab_id);
                if($update)
                {
                    $response["status"]=200;
                    $response["body"]= 'New Data Inserted';
                }
                else
                {
                    $response["status"]=201;
                    $response["body"]="Unable to Save Changes";
                }
            }
        }else{
            $response["status"]=201;
            $response["body"]="Missing Parameter";
        }
        echo json_encode($response);
    }


    function getlab_branchTableData()
    {
        $tableName="lab_branch";
        $where = array();
        $order = array('id' => 'asc');
        $column_order = array('name');
        $column_search = array("name");
        $select = array("*");

        $memData = $this->LabBranchModel->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order);
        $results_last_query = $this->db->last_query();
        $filterCount = $this->LabBranchModel->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
        $totalCount = $this->LabBranchModel->countAll($tableName, $where);

        if (count($memData) > 0) {
            $tableRows = array();
            foreach ($memData as $row) {
                $tableRows[] = array(
                    $row->name,
                    $row->address,
                    $row->mobile,
                    $row->email,
                    $row->id,
                    $row->status
                );
            }
            $results = array(
                "draw" => (int)isset($_POST['draw']),
                "recordsTotal" => $totalCount,
                "recordsFiltered" => $filterCount,
                "data" => $tableRows
            );
        } else {
            $results = array(
                "draw" => (int)isset($_POST['draw']),
                "recordsTotal" => $totalCount,
                "recordsFiltered" => $filterCount,
                "data" => $memData

            );
        }
        echo json_encode($results);
    }


    function getlabbranchDataById(){

        $validationObject = $this->is_parameter(array('lab_id'));
        if($validationObject->status){
            $lab_id= $validationObject->param->lab_id;

            $LabObject=$this->LabBranchModel->_select("lab_branch",array('id'=>$lab_id));
            if($LabObject->totalCount > 0){
                $response["status"]=200;
                $response["body"]=$LabObject->data;
            }else{
                $response["status"]=201;
                $response["body"]="Not Found";
            }
        }else{
            $response["status"]=201;
            $response["body"]="Missing Parameter";
        }
        echo json_encode($response);
    }



    function ChangeLabBranchStatus()
    {
        $validationObject = $this->is_parameter(array('labid','status'));
        if ($validationObject->status) {
            $lab_id = $validationObject->param->labid;
            $status = $validationObject->param->status;
            $companyObject=$this->LabBranchModel->_update("lab_branch",array("status"=>$status),array('id'=>$lab_id));
            if($companyObject->status){
                $response["status"]=200;
                $response["body"]="Save Change";
            }else{
                $response["status"]=201;
                $response["body"]="Failed To Save Changes";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Missing Parameter";
        }
        echo json_encode($response);
    }

}
?>
