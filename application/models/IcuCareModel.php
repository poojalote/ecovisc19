<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'MasterModel.php';

class IcuCareModel extends MasterModel
{

// fetch table data
	public function getDietReportData($tableName,$patient_table,$hospital_bed_table,$patient_id,$chkcount)
	{
		$where = array('branch_id' => $this->session->user_session->branch_id,'patient_id'=>$patient_id);
		if($chkcount==1)
		{
			$select=array("count(so.id)");
		}
		else
		{
			$select = array("so.created_on","so.Quantity","so.patient_id","so.TypeOfMeal","so.Remarks",
			"(select GROUP_CONCAT(pt.patient_name,'|||',(case when pt.bed_id !=0 then (select bm.bed_name from " . $hospital_bed_table . " bm where bm.id=pt.bed_id) else 'No Bed' end),'|||',pt.roomid) from " . $patient_table . " pt WHERE pt.id=so.patient_id) as patient_info");
		}
		
		$this->db->select($select)->where($where)->order_by('so.id desc');
		return $this->db->get($tableName." so")->result();

	}

	
}

