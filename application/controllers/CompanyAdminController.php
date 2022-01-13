<?php

require_once 'HexaController.php';

class CompanyAdminController extends HexaController
{


	/**
	 * CompaniesController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function company_admin(){

		$this->load->view('company_admin/company_admin',array("title"=>"Company Admin"));

	}
}
