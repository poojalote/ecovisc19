<?php

require_once 'HexaController.php';

/**
 * @property  Blogs Blogs
 */
class HealthTipsApi extends HexaController
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Blogs');
	}

	function get_health_tips()
	{
		$resultObject = $this->Blogs->getHealthTips();
		if ($resultObject->totalCount > 0) {
			$response["status"] = 200;
			$response["body"] = parent::base64_response($resultObject);
		} else {
			$response["status"] = 201;
			$response["body"] = NULL;
		}
		echo json_encode($response);
	}

}
