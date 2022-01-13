<?php

require_once 'HexaController.php';

class LabController extends HexaController
{


    /**
     * LabController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->load->view("LabCenter/viewLabDashboard",array("title"=>"Lab Dashboard"));
    }

    public function labMaster($department_id = 0, $section_id = 0, $QueryParamter = null){
        $this->load->view("LabCenter/labMasterForm",array("title"=>"Lab Master", "department_id" => $department_id, "section_id" => $section_id, "queryParam" => $QueryParamter));
    }
}