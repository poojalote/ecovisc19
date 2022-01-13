<?php


require_once 'HexaClan.php';

class Doctor extends MasterModel
{

	/**
	 * @var string
	 */
	private $category_table;
	private $doctor_table;
	private $doctor_view;
	private $user_header_table;
	private $image_resource_table;

	public function __construct()
	{
		parent::__construct();
		$this->category_table = "doctor_category_data";
		$this->doctor_table = "doctor_header_all";
		$this->doctor_view = "doctor_profile_view";
		$this->user_header_table = "user_header_all";
		$this->image_resource_table = "image_resource_data";
	}


	public function saveCategory($data, $categoryID = 0)
	{
		if ($categoryID == 0) {
			return parent::_insert($this->category_table, $data);
		} else {
			return parent::_update($this->category_table, $data, array("id" => $categoryID));
		}
	}

	public function moveTrash($categoryID)
	{
		return parent::_update($this->category_table, array("status" => 1), array("id" => $categoryID));
	}

	public function deleteCategory($categoryID)
	{
		return parent::_delete($this->category_table, array("id" => $categoryID));
	}

	public function getCategoryByID($categoryID)
	{
		return parent::_select($this->category_table, array("status" => 1, "id" => $categoryID));
	}

	public function getCategories()
	{
		return parent::_select($this->category_table, array("status" => 1,"type"=>1), "*", FALSE);
	}

	public function getEducations(){
		return parent::_select($this->category_table, array("status" => 1,"type"=>2), "*", FALSE);
	}

	public function getDoctorProfileByCategoryId($categoryID)
	{
		return parent::_select($this->doctor_view, array("category" => $categoryID, "status" => 1), array("user_id", "name", "email", "contact", "education", "address", "alt_contact_1", "profile_image"), FALSE);
	}

	public function getDoctorProfileByDoctorId($doctorID)
	{
		return parent::_select($this->doctor_view, array("user_id" => $doctorID, "status" => 1), "*", FALSE);
	}

	public function saveDoctor($userData,$doctorData,$imageData, $doctorID = 0)
	{
		if ($doctorID == 0) {
			return $this->insertDoctor($userData,$doctorData,$imageData);
		} else {
			return$this->updateDoctor($userData,$doctorData,$imageData,$doctorID);
		}
	}

	public function updateDoctor($userData, $doctorData, $imageData,$docID)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			// update user details
			$this->db->set($userData)->where('id',$docID)->update($this->user_header_table);
			// update doctor details by doc id
			$this->db->set($doctorData)->where('doc_id',$docID)->update($this->doctor_table);
			// add image in image_resource_table
			$this->db->insert($this->image_resource_table, $imageData);
			$imageID = $this->db->insert_id();
			// update user table for profile image by using doc id
			$this->db->where(array('id' => $docID, 'status' => 1))
				->set('profile_image', $imageID)
				->update($this->image_resource_table);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	public function insertDoctor($userData, $doctorData, $imageData)
	{
		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			// insert user details
			$this->db->insert($this->user_header_table, $userData);
			// get last insert id
			$resultObject->inserted_id = $this->db->insert_id();
			// attach last insert id as doctor id  in doctor table
			$doctorData["doc_id"] = $resultObject->inserted_id;
			$this->db->insert($this->doctor_table, $doctorData);
			// add image in image_resource_table
			$this->db->insert($this->image_resource_table, $imageData);
			$imageID = $this->db->insert_id();
			// update user table for profile image by using doc id
			$this->db->where(array('id' => $resultObject->inserted_id, 'status' => 1))
				->set('profile_image', $imageID)
				->update($this->user_header_table);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $ex) {
			$resultObject->status = FALSE;
			$this->db->trans_rollback();
		}
		return $resultObject;
	}

	public function getDoctors($where,$end_limit = 0, $start_limit = 1)
	{
		$resultObject = new stdClass();
		try {
			$result = $this->db->where($where)->limit($start_limit, $end_limit)->get($this->doctor_view)->result();

			if (count($result) > 0) {
				$resultObject->totalCount = count($result);
				$resultObject->data = $result;
			} else {
				$resultObject->totalCount = 0;
				$resultObject->data = array();
			}
		} catch (Exception $ex) {
			$resultObject->totalCount = 0;
			$resultObject->data = array();
		}
		return $resultObject;
	}

}
