<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
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
    public function index()
    {
        $this->load->view('login', array("title" => "Login"));
    }

    public function view_cam()
    {
        $this->load->view("video-cam", array("title" => "Cam"));
    }

    public function view_companies()
    {
        $this->load->view("admin/company/view_company", array("title" => "Companies"));
    }

    public function view_branches()
    {
        $this->load->view("admin/branch/view_branch", array("title" => "Branches"));
    }

    public function from_companies()
    {
        $this->load->view("admin/company/company_form", array("title" => "Department"));
    }

    public function view_lab_branches()
    {
        $this->load->view("admin/lab_branch/view_lab_branch", array("title" => "Lab Branches"));
    }

    public function view_department()
    {
        $this->load->view("admin/department/view_departments", array("title" => "Department"));
    }

    public function from_department()
    {
        $this->load->view("admin/department/department_form", array("title" => "Department"));
    }

    public function view_template()
    {
        $this->load->view("admin/templates/section_form", array("title" => "Template"));
    }

    public function from_template()
    {
        $this->load->view("admin/templates/template_form", array("title" => "Template"));
    }

    public function view_users()
    {
        $this->load->view("admin/users/view_users", array("title" => "Users"));
    }

    public function from_user()
    {
        $this->load->view("admin/users/template_form", array("title" => "Users"));
    }

    public function view_patient()
    {
        $this->load->view("admin/patients/view_patients", array("title" => "Patients"));
    }

    public function from_patient($id = 0)
    {
        $this->load->view("admin/patients/patient_form", array("title" => "Patients", "patient_id" => $id));
    }

    public function sendMessage()
    {

        $this->load->model("Global_model");
        $this->Global_model->sendSms('919920482779', "Your Bed is Register");
    }

    public function test()
    {
        $this->load->view("welcome_message", array("title" => "test"));
    }
}
