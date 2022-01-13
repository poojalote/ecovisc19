<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home2 extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Home2_model');
		$table_name="companies_master";
		$result['company_data']=$this->Home2_model->all_company($table_name);
		// print_r($result);
		$this->load->view('header');
		$this->load->view('index2', $result);
		$this->load->view('footer');
	}
	
	public function add_company()
	{
		$form_data=$this->input->POST();
		// print_r($form_data['id']);
		// print_r(date("y-m-d"));
		// exit();
		
		if ($form_data['id']=='') {

			$table_name='companies_master';
			$date = date("y-m-d");
		$insert_data= array(
								'name' => $form_data['name'],
								"status" =>$form_data['status'],
								"create_by"=>$form_data['create_by'],
								"create_on" =>$date,
								);
		// print_r($insert_data);
		// exit();

		$this->load->model('Home2_model');

		$user_data=$this->Home2_model->addForm($table_name, $insert_data);
		 print_r($user_data);
			
		}
		else
		{
			$condition = array("id" => $form_data['id']);
			$table_name='companies_master';
			$update_data= array(
								'name' => $form_data['name'],
								"status" =>$form_data['status'],
								"create_by"=>$form_data['create_by'],
								
								);
		// 	print_r($update_data);
		// exit();
		$this->load->model('Home2_model');

		$user_data=$this->Home2_model->updateForm($table_name,$update_data, $condition);
		 print_r($user_data);
		
		}
		

	}

	public function select_company($id)
	{
		// print_r($id);
		$condition = array("id" => $id);
		$table_name= "companies_master";
		$this->load->model('Home2_model');

		$user_data=$this->Home2_model->select($table_name, $condition);
		 // print_r($user_data);
		echo json_encode($user_data);



	}
	public function delete_company($id)
	{
		$condition = array("id" => $id);
			$table_name='companies_master';
			$this->load->model('Home2_model');

		$user_data=$this->Home2_model->delete($table_name, $condition);
		print_r($user_data);
		

	}
}
