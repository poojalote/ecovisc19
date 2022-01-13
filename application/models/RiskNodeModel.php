<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class RiskNodeModel extends MasterModel
{

	public function getPatientData($patient_table,$hospital_bed_table,$hospital_room_table)
	{
		$query="SELECT *,TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age, (select hb.bed_name from ".$hospital_bed_table." hb where hb.id=bed_id) as bed_name, (select hb1.category from ".$hospital_bed_table." hb1 where hb1.id=bed_id) as category, (select group_concat(hb.room_no,'-',hb.ward_no) from ".$hospital_room_table." hb where hb.id=roomid) as room_name FROM `".$patient_table."` WHERE `type` = 1 AND `admission_date` != '0000-00-00 00:00:00' AND `discharge_date` IS NULL OR `discharge_date` = '0000-00-00 00:00:00' ORDER BY `id` DESC";
		return parent::_rawQuery($query);
	}

	public function getPatientData1($patient_table,$hospital_bed_table,$hospital_room_table,$having)
	{
		$query="SELECT count(*) as main_count,sum(case when (select hb1.category from ".$hospital_bed_table." hb1 where hb1.id=bed_id and category=1) then 1 else 0 end) as dome
		,sum(case when (select hb1.category from ".$hospital_bed_table." hb1 where hb1.id=bed_id and category=2) then 1 else 0 end) as icu
		 FROM `".$patient_table."` WHERE `type` = 1 AND `admission_date` != '0000-00-00 00:00:00' AND `discharge_date` IS NULL OR
		 `discharge_date` = '0000-00-00 00:00:00' ORDER BY `id` DESC";
		return parent::_rawQuery($query);
	}
	public function getPatientData2($patient_table,$ids)
	{
		$query="SELECT id,adhar_no,patient_name,gender,TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age
		 FROM `".$patient_table."` WHERE id in (".$ids.") AND `type` = 1 AND `admission_date` != '0000-00-00 00:00:00' AND `discharge_date` IS NULL OR
		 `discharge_date` = '0000-00-00 00:00:00' ORDER BY `id` DESC";
		return parent::_rawQuery($query);
	}



}

