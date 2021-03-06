<?php

require_once 'MasterModel.php';

class formmodel extends MasterModel
{

	public function get_form($department_id)
	{

		$query = $this->db->query("select distinct section_id,
                (select name from section_master where section_master.id=template_master.section_id) as section_name,
                (select is_history from section_master where section_master.id=template_master.section_id) as is_history,
                (select is_traction from section_master where section_master.id=template_master.section_id) as is_traction,
                (select tb_history from section_master where section_master.id=template_master.section_id) as tb_history ,
                (select name from departments_master d where d.id=template_master.department_id) as template_name,
                (select seq_num from section_master where section_master.id=template_master.section_id) as seq_num,
				tb_name
				from template_master where department_id='$department_id' and status=1");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function get_personalTemplate_form($department_id,$section_id)
	{

		$query = $this->db->query("select distinct section_id,
                (select name from section_master where section_master.id=template_master.section_id) as section_name,
                (select is_history from section_master where section_master.id=template_master.section_id) as is_history,
                (select is_traction from section_master where section_master.id=template_master.section_id) as is_traction,
                (select tb_history from section_master where section_master.id=template_master.section_id) as tb_history ,
                (select name from departments_master d where d.id=template_master.department_id) as template_name,
                (select seq_num from section_master where section_master.id=template_master.section_id) as seq_num,
				tb_name
				from template_master where department_id='$department_id' and status=1 and section_id='$section_id'");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_form1($department_id,$section_id)
	{

		$query = $this->db->query("select distinct section_id,
                (select name from section_master where section_master.id=template_master.section_id) as section_name,
                (select is_history from section_master where section_master.id=template_master.section_id) as is_history,
                (select is_traction from section_master where section_master.id=template_master.section_id) as is_traction,
                (select tb_history from section_master where section_master.id=template_master.section_id) as tb_history ,
                (select name from departments_master d where d.id=template_master.department_id) as template_name,
                (select seq_num from section_master where section_master.id=template_master.section_id) as seq_num,
				tb_name
				from template_master where department_id='$department_id' and section_id='$section_id' and status=1");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}	
	public function getPatientDetails($tableName,$where){
		return $this->_select($tableName,$where);
	}

	public function get_sectionform($section_id)
	{
		$query = $this->db->query("select *  from template_master where section_id='$section_id' and status =1 order by sequeance_num ");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function get_sectionformid_wise($id)
	{
		$query = $this->db->query("select *  from template_master where id='$id' and status =1 ");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	public function check_dependancy($name,$section_id){
		$query = $this->db->query("select *  from template_master where section_id='$section_id' and status =1 and dependancy='$name' ");
		if ($this->db->affected_rows() > 0) {
			$res=$query->row();
			return $res->id;
		} else {
			return false;
		}
	}

	public function get_data_from_table($f_name, $tb_name, $patient_id)
	{
		$this->db->select($f_name);
		$this->db->from($tb_name);
		$this->db->where('patient_id', $patient_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row()->$f_name;
		} else {
			return false;
		}
	}

	public function getHistoryTableColumn($section_id)
	{
		$sql="select * from template_master t where t.section_id= ".$section_id." and t.status=1 order by sequeance_num asc";
		return $this->_rawQuery($sql);
	}

	public function history_data($table_name, $where)
	{
		return $this->db->select("*")->where($where)->order_by("trans_date","desc")->get($table_name)->result();
//		return $this->_select($table_name, $where, "*", false);
	}

	public function get_section_data($department_id, $section_id)
	{
		$query = $this->db->query("select *  from template_master where department_id='$department_id' AND section_id='$section_id'");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_all_options($id)
	{
		$query = $this->db->query("select *  from option_master where temp_id='$id'");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function get_all_data($department_id,$section_id)
	{
		$query = $this->db->query("select *  from template_master where department_id='$department_id' and section_id='$section_id' and status=1");
		if ($this->db->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function check_patient_availabel($patient_id, $tb_name)
	{

		$this->db->select('*');
		$this->db->from($tb_name);
		$this->db->where('patient_id', $patient_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}

	}

	public function check_branch_patient_history_availabel($where, $tb_name)
	{

		$this->db->select('*');
		$this->db->from($tb_name);
		$this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}

	}

	function upload_multiple_file_new($upload_path, $inputname, $combination = "")
	{

		$combination = (explode(",", $combination));

		$check_file_exist = $this->check_file_exist($upload_path);
		if (isset($_FILES[$inputname]) && $_FILES[$inputname]['error'] != '4') {

			$files = $_FILES;
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = '*';
//            $config['max_size'] = '20000000';    //limit 10000=1 mb
			$config['remove_spaces'] = true;
			$config['overwrite'] = false;

			$this->load->library('upload', $config);

			if (is_array($_FILES[$inputname]['name'])) {
				$count = count($_FILES[$inputname]['name']); // count element
				$files = $_FILES[$inputname];
				$images = array();
				$dataInfo = array();
				if ($count > 0) {
					if (in_array("1", $combination)) {
						for ($j = 0; $j < $count; $j++) {
							$fileName = $files['name'][$j];
							if (in_array($fileName, $check_file_exist)) {
								$response['status'] = 201;
								$response['body'] = $fileName . " Already exist";
								return $response;
							}
						}
					}
					$inputname = $inputname . "[]";
					for ($i = 0; $i < $count; $i++) {
						$_FILES[$inputname]['name'] = $files['name'][$i];
						$_FILES[$inputname]['type'] = $files['type'][$i];
						$_FILES[$inputname]['tmp_name'] = $files['tmp_name'][$i];
						$_FILES[$inputname]['error'] = $files['error'][$i];
						$_FILES[$inputname]['size'] = $files['size'][$i];
						$fileName = $files['name'][$i];
						//get system generated File name CONCATE datetime string to Filename
						if (in_array("2", $combination)) {
							$date = date('Y-m-d H:i:s');
							$randomdata = strtotime($date);
							$fileName = $randomdata . $fileName;
						}
						$images[] = $fileName;

						$config['file_name'] = $fileName;

						$this->upload->initialize($config);
						$up = $this->upload->do_upload($inputname);
						//var_dump($up);
						$dataInfo[] = $this->upload->data();
					}
					//var_dump($dataInfo);

					$file_with_path = array();
					foreach ($dataInfo as $row) {
						$raw_name = $row['raw_name'];
						$file_ext = $row['file_ext'];
						$file_name = $raw_name . $file_ext;
						if (!empty($file_name)) {
							$file_with_path[] = $upload_path . "/" . $file_name;
						}
					}
					if (count($file_with_path) > 0) {
						$response['status'] = 200;
						$response['body'] = $file_with_path;
					} else {
						$response['status'] = 202;
						$response['body'] = $file_with_path;
					}
					return $response;
				} else {
					$response['status'] = 201;
					$response['body'] = array();
					return $response;
				}
			} else {
				$response['status'] = 201;
				$response['body'] = array();
				return $response;
			}
		} else {
			$response['status'] = 201;
			$response['body'] = array();
			return $response;
		}
	}

	function check_file_exist($upload_path)
	{
		$filesnames = array();

		foreach (glob('./' . $upload_path . '/*.*') as $file_NAMEEXISTS) {
			$file_NAMEEXISTS;
			$filesnames[] = str_replace("./" . $upload_path . "/", "", $file_NAMEEXISTS);
		}
		return $filesnames;
	}
	public function get_all_selection_data($table_name,$where)
	{
		return $this->_select($table_name, $where, "*", true);
	
	}
	public function getSectionValueExist($patient_id,$branch_id,$section_id,$table_name)
	{
		$resulyArray=0;
		$resultObject=$this->_rawQuery('select group_concat(tt.field_name) as field_name from template_master tt where tt.section_id='.$section_id.' and tt.status=1');

		if($resultObject->totalCount>0)
		{
			$field_name=$resultObject->data[0]->field_name;
			$resultObject1=$this->_rawQuery('select '.$field_name.' from '.$table_name.' where `patient_id` = '.$patient_id.' AND `branch_id` = '.$branch_id);

			if($resultObject1->totalCount>0)
			{
				$d_ss=(array)$resultObject1->data[0];
				$d_ss=array_filter($d_ss);
				$d_select=0;
				if(count($d_ss)>0)
				{
					$d_select=$d_select+1;
				}

				if($d_select>0){
					$resulyArray=1;
				}
			}
		}
		return $resulyArray;
	}

}
