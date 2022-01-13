<?php

require_once 'MasterModel.php';

class HtmlPageModel extends MasterModel
{

	private $table;

	/**
	 * TemplateModel constructor.
	 * @param $table
	 */
	public function __construct()
	{
		$this->table = "html_html_template_master";
	}
	public function fetchAllSections()
	{
		return $this->_select("html_section_master", array("status" => 1), "*", false);
	}

}