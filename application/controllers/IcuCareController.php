<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IcuCareController extends CI_Controller {

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
	function __construct()
	{
		parent::__construct();
		$this->load->model('bed_model');
		$this->load->model('IcuCareModel');

	}
	public function index()
	{
		$this->load->view('Icu_care/Icu_nursing_care',array("title"=>"Billing"));
	}
	
	public function getData()
	{
		$tableName="com_1_critical_care";
		$patient_id=$this->input->post('patient_id');
		$date_filter=$this->input->post('date_filter');
		// $date_f=date('Y-m-d');
		$date_id=$this->input->post('date_id');
		
		if($date_id==null)
		{
			
			$date_f=date('Y-m-d', strtotime($date_filter));
		}
		else{
			if($date_id==2)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' + 1 day'));
			}
			else if($date_id==1)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' - 1 day'));
			}
			else
			{
				$date_f=date('Y-m-d', strtotime($date_filter));
			}
		}
		 // print_r($date_f);exit();
		$branch_id = $this->session->user_session->branch_id;
		
		$th="";
		$temp="";
		$bps="";
		$bpd="";
		$hr="";
		$rr="";
		$rhythm="";
		$spo2="";
		$etco2="";
		$ipap="";
		$epap="";
		$mode="";
		$fto2="";
		$pee="";
		$ppeak="";
		$rate="";
		$tidal="";
		$pressure="";
		$rass="";

		$drugInfusion1="";
		$drugInfusion2="";
		$drugInfusion3="";
		$drugInfusion4="";
		$drugInfusion5="";

		$IVFluids1="";
		$IVFluids2="";
		$IVFluids3="";
		$IVFluids4="";
		$IVFluids5="";

		$bolus1="";
		$bolus2="";
		$bolus3="";
		$bolus4="";
		$bolus5="";

		$ngvom="";
		$cumng="";
		$hurin="";
		$cumurin="";
		$dr1="";
		$dr2="";
		$dr3="";
		$dr4="";
		$hrdrain="";
		$cumdrain="";
		$totalop="";
		$iabp_ratio="";
		$abdominal="";
		$ppr="";
		$ppl="";
		$bowlop="";
		$centralline="";
		$atriallines="";
		$hdCatheter="";
		$periline="";
		$drains="";
		$urincatheter="";
		$endoTube="";
		$iabpCatheter="";
		$tracheTube="";
		$rylesTube="";
		$para1="";
		$para2="";
		$backcare="";
		$mcare="";
		$eyecare="";
		$chestpt="";
		$limbpt="";
		$cuffp="";
		$cldress="";
		$Etcare="";
		$sbath="";
		$presore="";
		$site="";
		$action="";
		$bldsgr="";
		$insl="";
		$routeAdmi="";
		$insulineName="";
		$in_iv="";
		$in_rt="";
		$in_orl="";
		$in_total="";
		$op_urn="";
		$op_rt="";
		$op_drn="";
		$op_total="";
		$op_bal="";
		$qty="";
		$given="";
		$remark="";
		$intake_total="";
		$output_B_t="";
		$balance_Total="";

		$score="";
		$vital_s="";
		$ventilator_s="";
		$output1_s="";
		$others_s="";
		$invasive_lines_s="";
		$rass_s="";
		$nursing_care_s="";
		$diabetic_s="";
		$intake_s="";
		$output2_s="";
		$die_chart_s="";
		$colspan=2;
		$typemeal="";

		// 
		// print_r(DATE($date_f));exit();
		$result=$this->db->query('select * from '.$tableName.' where patient_id='.$patient_id.' and branch_id='.$branch_id.' and date(`created_on`) = date("'.$date_f.'")');
		// echo $this->db->last_query();
		if($this->db->affected_rows() > 0)
		{	
			$resultObject=$result->result();
			// print_r($resultObject);exit();
			$cumngv_A="";
			$cumU_B="";
			$cumD_C="";
			$output1_T="";
			$intake_A="";
			$putput2_T_B="";
			$balance_T="";
			// $totals_odResultObject=$this->db->query('select sum(hourly_N_G_Vomitus) as cumngv, sum(DrainI+DrainII+DrainIII+DrainIV+Hourly_Drainage) as drainage,sum(Hourly_Urine) as cumurin,sum(hourly_N_G_Vomitus+DrainI+DrainII+DrainIII+DrainIV+Hourly_Drainage+Hourly_Urine) as opt1,sum(I_V+R_T+Oral) as intakeT,sum(Urine+output_R_T+output_Drain) as opt2,(sum(I_V+R_T+Oral)-sum(Urine+output_R_T+output_Drain)) as balance from com_1_critical_care where patient_id='.$patient_id.' and branch_id='.$branch_id.' and date(created_on) = CURDATE()');
			// // print_r($totals_odResult);
			// if($this->db->affected_rows()>0){
			// 	$totals_odResult=$totals_odResultObject->row();

			// 	$cumngv_A=$totals_odResult->cumngv;
			// 	$cumU_B=$totals_odResult->cumurin;
			// 	$cumD_C=$totals_odResult->drainage;
			// 	$output1_T=$totals_odResult->opt1;
			// 	$intake_A=$totals_odResult->intakeT;
			// 	$putput2_T_B=$totals_odResult->opt2;
			// 	$balance_T=$totals_odResult->balance;
			
			// }
			$resultObjectArray=array();
			$hourly_N_G_Vomitus=0;
			$dranage=0;
			$cum_urine=0;
			$output1=0;
			$intake1=0;
			$output2=0;
			$balance1=0;
			foreach ($resultObject as $key => $value) {
				$hourly_N_G_Vomitus=((int)$hourly_N_G_Vomitus+(int)$value->hourly_N_G_Vomitus);
				$dranage=((int)$dranage+((int)$value->DrainI+(int)$value->DrainII+(int)$value->DrainIII+(int)$value->DrainIV+(int)$value->Hourly_Drainage));
				$cum_urine=((int)$cum_urine+(int)$value->Hourly_Urine);
				$output1=((int)$output1+((int)$value->hourly_N_G_Vomitus+(int)$value->DrainI+(int)$value->DrainII+(int)$value->DrainIII+(int)$value->DrainIV+(int)$value->Hourly_Drainage+(int)$value->Hourly_Urine));
				$intake1=((int)$intake1+((int)$value->I_V+(int)$value->R_T+(int)$value->Oral));
				$output2=((int)$output2+((int)$value->Urine+(int)$value->output_R_T+(int)$value->output_Drain));
				$balance1=((int)$balance1+((int)$value->I_V+(int)$value->R_T+(int)$value->Oral)-((int)$value->Urine+(int)$value->output_R_T+(int)$value->output_Drain));

				$value->cumngv_A=$hourly_N_G_Vomitus;
				$value->cumD_C=$dranage;
				$value->cumU_B=$cum_urine;
				$value->output1_T=$output1;
				$value->intake_A=$intake1;
				$value->putput2_T_B=$output2;
				$value->balance_T=$balance1;
				array_push($resultObjectArray, $value);
			}
			// print_r($resultObjectArray);exit();
			rsort($resultObjectArray);

			$colspan=$colspan+count($resultObjectArray);
			foreach ($resultObjectArray as $row) {

				$edit_date=date('Y-m-d',strtotime($row->created_on));
				$current_date = date('Y-m-d');

				$edit_date_time=date('H:i',strtotime($row->created_on));
				$date_time = date('H:i');
				
				$mins=(strtotime($date_time)-strtotime($edit_date_time))/60;
				
			
				if(strtotime($edit_date)==strtotime($current_date) && $mins < 45)
				{
					
				}
				else
				{

				$date=date('D M d H:i',strtotime($row->created_on));
				$th.='<th style="font-size:11px;width:76px;text-align:center;">'.$date.'<i class="fas fa-pencil-alt" style="font-size:8px;border: 1px solid #bbb8b9;padding: 2px;box-shadow: 0px 0px 0px 0px #888888;" onclick="changesSigns(\''.$row->id.'\')"></i></th>';

				$temp.='<td class="text-center">'.$row->temperature.'</td>';
				$bps.='<td class="text-center">'.$row->BP.'</td>';
				$bpd.='<td class="text-center">'.$row->BPDiastolic.'</td>';
				$hr.='<td class="text-center">'.$row->HR.'</td>';
				$rr.='<td class="text-center">'.$row->RR.'</td>';
				$rhythm.='<td class="text-center">'.$row->RHYTHM.'</td>';
				$spo2.='<td class="text-center">'.$row->SPO2.'</td>';
				$etco2.='<td class="text-center">'.$row->ETCO2.'</td>';
				$ipap.='<td class="text-center">'.$row->BIPAP.'</td>';
				$epap.='<td class="text-center">'.$row->EPAP.'</td>';
				$mode.='<td class="text-center">'.$row->Mode.'</td>';
				$fto2.='<td class="text-center">'.$row->Flo2.'</td>';
				$pee.='<td class="text-center">'.$row->PEE.'</td>';
				$ppeak.='<td class="text-center">'.$row->PPEAK.'</td>';
				$rate.='<td class="text-center">'.$row->RATE.'</td>';
				$tidal.='<td class="text-center">'.$row->Tidal_Volume.'</td>';
				$pressure.='<td class="text-center">'.$row->Pressure_Support.'</td>';
				$rass.='<td class="text-center">'.$row->RASS.'</td>';

				 
				$drugInfusion1.='<td class="text-center">'.$row->DRUG_Infusion1.'</td>';
				$drugInfusion2.='<td class="text-center">'.$row->DRUG_Infusion2.'</td>';
				$drugInfusion3.='<td class="text-center">'.$row->DRUG_Infusion3.'</td>';
				$drugInfusion4.='<td class="text-center">'.$row->DRUG_Infusion4.'</td>';
				$drugInfusion5.='<td class="text-center">'.$row->DRUG_Infusion5.'</td>';

				$IVFluids1.='<td class="text-center">'.$row->IV_Fluids1.'</td>';
				$IVFluids2.='<td class="text-center">'.$row->IV_Fluids2.'</td>';
				$IVFluids3.='<td class="text-center">'.$row->IV_Fluids3.'</td>';
				$IVFluids4.='<td class="text-center">'.$row->IV_Fluids4.'</td>';
				$IVFluids5.='<td class="text-center">'.$row->IV_Fluids5.'</td>';

				$bolus1.='<td class="text-center">'.$row->BOLUS1.'</td>';
				$bolus2.='<td class="text-center">'.$row->BOLUS2.'</td>';
				$bolus3.='<td class="text-center">'.$row->BOLUS3.'</td>';
				$bolus4.='<td class="text-center">'.$row->BOLUS4.'</td>';
				$bolus5.='<td class="text-center">'.$row->BOLUS5.'</td>';

				$ngvom.='<td class="text-center">'.$row->hourly_N_G_Vomitus.'</td>';

				$cumng.='<td class="text-center">'.$row->cumngv_A.'</td>';
				$hurin.='<td class="text-center">'.$row->Hourly_Urine.'</td>';
				$cumurin.='<td class="text-center">'.$row->cumU_B.'</td>';
				$dr1.='<td class="text-center">'.$row->DrainI.'</td>';
				$dr2.='<td class="text-center">'.$row->DrainII.'</td>';
				$dr3.='<td class="text-center">'.$row->DrainIII.'</td>';
				$dr4.='<td class="text-center">'.$row->DrainIV.'</td>';
				$hrdrain.='<td class="text-center">'.$row->Hourly_Drainage.'</td>';
				$cumdrain.='<td class="text-center">'.$row->cumD_C.'</td>';
				$totalop.='<td class="text-center">'.$row->output1_T.'</td>';
				$iabp_ratio.='<td class="text-center">'.$row->IABP_ratio.'</td>';
				$abdominal.='<td class="text-center">'.$row->Abdominal_Girth.'</td>';
				$ppr.='<td class="text-center">'.$row->Pedal_Pulse_R.'</td>';
				$ppl.='<td class="text-center">'.$row->Pedal_Pulse_L.'</td>';
				$bowlop.='<td class="text-center">'.$row->Bowel_Opened.'</td>';
				$centralline.='<td class="text-center">'.$row->Central_Line.'</td>';
				$atriallines.='<td class="text-center">'.$row->Atrial_Lines.'</td>';
				$hdCatheter.='<td class="text-center">'.$row->HD_Catheter.'</td>';
				$periline.='<td class="text-center">'.$row->Peripheral_Line.'</td>';
				$drains.='<td class="text-center">'.$row->Drains.'</td>';
				$urincatheter.='<td class="text-center">'.$row->Urinary_Catheter.'</td>';
				$endoTube.='<td class="text-center">'.$row->Endotracheal_Tube.'</td>';
				$iabpCatheter.='<td class="text-center">'.$row->IABP_catheter.'</td>';
				$tracheTube.='<td class="text-center">'.$row->Tracheostomy_tube.'</td>';
				$rylesTube.='<td class="text-center">'.$row->Ryles_tube.'</td>';
				
				$para1.='<td class="text-center">'.$row->Parameter_1.'</td>';
				$para2.='<td class="text-center">'.$row->Parameter_2.'</td>';
				$backcare.='<td class="text-center">'.$row->Back_Care.'</td>';
				$mcare.='<td class="text-center">'.$row->Mouth_care.'</td>';
				$eyecare.='<td class="text-center">'.$row->Eye_care.'</td>';
				$chestpt.='<td class="text-center">'.$row->Chest_P_T.'</td>';
				$limbpt.='<td class="text-center">'.$row->Limb_P_T.'</td>';
				$cuffp.='<td class="text-center">'.$row->Cuff_pressure.'</td>';
				$cldress.='<td class="text-center">'.$row->Central_line_dressing.'</td>';
				$Etcare.='<td class="text-center">'.$row->E_T_T_T_care.'</td>';
				$remark.='<td class="text-center">'.$row->Remarks.'</td>';
				$given.='<td class="text-center">'.$row->Given_By.'</td>';
				$qty.='<td class="text-center">'.$row->Quantity.'</td>';//type of diet
				$typemeal.='<td class="text-center">'.$row->TypeOfMeal.'</td>';//type of meal
				
				$op_drn.='<td class="text-center">'.$row->output_Drain.'</td>';
				$op_rt.='<td class="text-center">'.$row->output_R_T.'</td>';
				$op_urn.='<td class="text-center">'.$row->Urine.'</td>';
				$intake_total.='<td class="text-center">'.$row->intake_A.'</td>';
				$output_B_t.='<td class="text-center">'.$row->putput2_T_B.'</td>';
				$balance_Total.='<td class="text-center">'.$row->balance_T.'</td>';
				$in_orl.='<td class="text-center">'.$row->Oral.'</td>';
				$in_rt.='<td class="text-center">'.$row->R_T.'</td>';
				$in_iv.='<td class="text-center">'.$row->I_V.'</td>';
				$score.='<td class="text-center">'.$row->Score.'</td>';
				$insl.='<td class="text-center">'.$row->Insulin.'</td>';
				$insulineName.='<td class="text-center">'.$row->InsulinName.'</td>';
				$routeAdmi.='<td class="text-center">'.$row->routeOfAdmini.'</td>';
				
				$bldsgr.='<td class="text-center">'.$row->Blood_Sugar.'</td>';
				$action.='<td class="text-center">'.$row->Action_Taken.'</td>';
				$site.='<td class="text-center">'.$row->Site.'</td>';
				$presore.='<td class="text-center">'.$row->Pressure_Sore.'</td>';
				$sbath.='<td class="text-center">'.$row->Sponge_Bath.'</td>';
								
			}
			}
		}

		$drugName1="";
		$drugName2="";
		$drugName3="";
		$drugName4="";
		$drugName5="";

		$bolusName1="";
		$bolusName2="";
		$bolusName3="";
		$bolusName4="";
		$bolusName5="";

		$ivfluidName1="";
		$ivfluidName2="";
		$ivfluidName3="";
		$ivfluidName4="";
		$ivfluidName5="";


		$drugResult=$this->db->query('select * from '.$tableName.' where patient_id='.$patient_id.' and branch_id='.$branch_id.' and date(created_on) = CURDATE() order by id desc limit 1');
		if($this->db->affected_rows() > 0)
		{	
			$drugObject=$drugResult->row();

				if($drugObject->DRUG_Infusion1!="" && $drugObject->DRUG_Infusion1!=null)
				{
					$drugexplode1=explode(':', $drugObject->DRUG_Infusion1);
					$drugName1=$drugexplode1[0];
				}
				if($drugObject->DRUG_Infusion2!="" && $drugObject->DRUG_Infusion2!=null)
				{
					$drugexplode2=explode(':', $drugObject->DRUG_Infusion2);
					$drugName2=$drugexplode2[0];
				}
				if($drugObject->DRUG_Infusion3!="" && $drugObject->DRUG_Infusion3!=null)
				{
					$drugexplode3=explode(':', $drugObject->DRUG_Infusion3);
					$drugName3=$drugexplode3[0];
				}
				if($drugObject->DRUG_Infusion4!="" && $drugObject->DRUG_Infusion4!=null)
				{
					$drugexplode4=explode(':', $drugObject->DRUG_Infusion4);
					$drugName4=$drugexplode4[0];
				}
				if($drugObject->DRUG_Infusion5!="" && $drugObject->DRUG_Infusion5!=null)
				{
					$drugexplode5=explode(':', $drugObject->DRUG_Infusion5);
					$drugName5=$drugexplode5[0];
				}

				//bolus
				if($drugObject->BOLUS1!="" && $drugObject->BOLUS1!=null)
				{
					$bolusexplode1=explode(':', $drugObject->BOLUS1);
					$bolusName1=$bolusexplode1[0];
				}
				if($drugObject->BOLUS2!="" && $drugObject->BOLUS2!=null)
				{
					$bolusexplode2=explode(':', $drugObject->BOLUS2);
					$bolusName2=$bolusexplode2[0];
				}
				if($drugObject->BOLUS3!="" && $drugObject->BOLUS3!=null)
				{
					$bolusexplode3=explode(':', $drugObject->BOLUS3);
					$bolusName3=$bolusexplode3[0];
				}
				if($drugObject->BOLUS4!="" && $drugObject->BOLUS4!=null)
				{
					$bolusexplode4=explode(':', $drugObject->BOLUS4);
					$bolusName4=$bolusexplode4[0];
				}
				if($drugObject->BOLUS5!="" && $drugObject->BOLUS5!=null)
				{
					$bolusexplode5=explode(':', $drugObject->BOLUS5);
					$bolusName5=$bolusexplode5[0];
				}

				//Iv fluids
				if($drugObject->IV_Fluids1!="" && $drugObject->IV_Fluids1!=null)
				{
					$ivfluidexplode1=explode(':', $drugObject->IV_Fluids1);
					$ivfluidName1=$ivfluidexplode1[0];
				}
				if($drugObject->IV_Fluids2!="" && $drugObject->IV_Fluids2!=null)
				{
					$ivfluidexplode2=explode(':', $drugObject->IV_Fluids2);
					$ivfluidName2=$ivfluidexplode2[0];
				}
				if($drugObject->IV_Fluids3!="" && $drugObject->IV_Fluids3!=null)
				{
					$ivfluidexplode3=explode(':', $drugObject->IV_Fluids3);
					$ivfluidName3=$ivfluidexplode3[0];
				}
				if($drugObject->IV_Fluids4!="" && $drugObject->IV_Fluids4!=null)
				{
					$ivfluidexplode4=explode(':', $drugObject->IV_Fluids4);
					$ivfluidName4=$ivfluidexplode4[0];
				}
				if($drugObject->IV_Fluids5!="" && $drugObject->IV_Fluids5!=null)
				{
					$ivfluidexplode5=explode(':', $drugObject->IV_Fluids5);
					$ivfluidName5=$ivfluidexplode5[0];
				}
		}


		$data="";
		$class1="vital_td2";
		$class2="vent1";
		$class3="op1";
		$class4="ot1";
		$class5="il1";
		$class6="rass";
		$class7="nursecare";
		$class8="diabetic";
		$class9="intake";
		$class10="op2";
		$class11="dc1";
		$class12="drugInfusion1";
		$class13="bolus1";
		$class14="ivFluids1";
		$data .='
		<table class="table-bordered">
		<input type="hidden" name="hidden_id" id="hidden_id">
		<thead class="table_header">
		<tr class="bg_color">
		<th>
		Item
		</th>
		<th style="width: 76px;">
		Now <span id="flowsheet_edit_date" style="font-size:9px;"></span>
		</th>
		'.$th.'
		</tr>
		</thead>
		<tbody>
		<tr class="bg_color">
		<td id="vital_td" colspan='.$colspan.'>
		<i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class1. '\')"></i> <b>Vital </b></td>'.$vital_s.'</tr>
		<tr class="vital_td2"><td class="sign_p">Temp</td><td><input type="number" name="temp" id="temp"></td>'.$temp.'</tr>
		<tr class="vital_td2"><td class="sign_p">BP Systolic</td><td><input type="number" name="bpsytolic" id="bps"></td>'.$bps.'</tr>
		<tr class="vital_td2"><td class="sign_p">BP Diastolic</td><td><input type="number" name="bpdiastolic" id="bpd"></td>'.$bpd.'</tr>
		<tr class="vital_td2"><td class="sign_p">HR</td><td><input type="number" name="hr" id="hr"></td>'.$hr.'</tr>
		<tr class="vital_td2"><td class="sign_p">RR</td><td><input type="number" name="rr" id="rr"></td>'.$rr.'</tr>
		<tr class="vital_td2"><td class="sign_p">RHYTHM</td><td>
		<!--<input type="number" name="rhythm" id="rhythm">-->
		<select name="rhythm" id="rhythm">
			<option selected disabled>Select Rhythm</option>
			<option value="Normal Sinus Rhythm">Normal Sinus Rhythm</option>
			<option value="Sinus Tachycardia">Sinus Tachycardia</option>
			<option value="Sinus Bradycardia">Sinus Bradycardia</option>
			<option value="Atrial Fibrilation">Atrial Fibrilation</option>
			<option value="Atrial Flutter">Atrial Flutter</option>
			<option value="Premature Contractions">Premature Contractions</option>
			<option value="Ventricular Fibrilation">Ventricular Fibrilation</option>
			<option value="Ventricular Tachyardia">Ventricular Tachyardia</option>
		</select>
		</td>'.$rhythm.'</tr>
		<tr class="vital_td2"><td class="sign_p">SpO2 % </td><td><input type="number" name="spo2" id="spo2"></td>'.$spo2.'</tr>
		<tr class="vital_td2"><td class="sign_p">ETCO2</td><td><input type="number" name="etco2" id="etco2"></td>'.$etco2.'</tr>
		<tr class="vital_td2"><td class="sign_p">IPAP</td><td><input type="number" name="ipap" id="ipap"></td>'.$ipap.'</tr>
		<tr class="vital_td2"><td class="sign_p">EPAP</td><td><input type="number" name="epap" id="epap"></td>'.$epap.'</tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class2. '\')"></i> <b>Ventilator</b></td>'.$ventilator_s.'</tr>
		<tr class="vent1"><td class="sign_p">Mode</td><td>
		<select name="mode" id="mode">
			<option selected disabled> Select mode </option>
			<option value="A/C-PC">A/C-PC</option>
			<option value="AVAPS-AE">AVAPS-AE</option>
			<option value="PSV">PSV</option>
			<option value="SIMV-PC">SIMV-PC</option>
			<option value="A/C-VC">A/C-VC</option>
			<option value="S/T">S/T</option>
			<option value="CPAP">CPAP</option>
			<option value="SIMV-VC">SIMV-VC</option>
		</select></td>'.$mode.'</tr>
		<tr class="vent1"><td class="sign_p">FiO2 % </td><td><input type="number" name="fto2" id="fto2"></td>'.$fto2.'</tr>
		<tr class="vent1"><td class="sign_p">PEEP</td><td><input type="number" name="pee" id="pee"></td>'.$pee.'</tr>
		<tr class="vent1"><td class="sign_p">PPEAK</td><td><input type="number" name="ppeak" id="ppeak"></td>'.$ppeak.'</tr>
		<tr class="vent1"><td class="sign_p">RATE</td><td><input type="number" name="rate" id="rate"></td>'.$rate.'</tr>
		<tr class="vent1"><td class="sign_p">Tidal Volume</td><td><input type="number" name="tidal" id="tidal"></td>'.$tidal.'</tr>
		<tr class="vent1"><td class="sign_p">Pressure Support</td><td><input type="number" name="pressure" id="pressure"></td>'.$pressure.'</tr>
		<!--<tr class="vent1"><td class="sign_p">RASS</td><td><input type="number" name="rass" id="rass"></td>'.$rass.'</tr>-->
		
		<tr class="bg_color"><td class="mainsign_p" colspan='.$colspan.'><b><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class12. '\')"></i> DRUG Infusion</b></td></tr>
		<tr class="drugInfusion1"><td class="sign_p"><input type="text" id="drug_Infusion1" name="drug_Infusion1" value="'.$drugName1.'" placeholder="Enter drug infucion1" ></td><td><input type="text" id="drug_Infusion_value1" name="drug_Infusion_value1" onkeyup="checkDrugValue(\'drug_Infusion1\',\'drug_Infusion_value1\',\'Enter Drug Infusion First\')"></td>'.$drugInfusion1.'</tr>
		<tr class="drugInfusion1"><td class="sign_p"><input type="text" id="drug_Infusion2" name="drug_Infusion2" value="'.$drugName2.'" placeholder="Enter drug infucion2"></td><td><input type="text" id="drug_Infusion_value2" name="drug_Infusion_value2" onkeyup="checkDrugValue(\'drug_Infusion2\',\'drug_Infusion_value2\',\'Enter Drug Infusion First\')"></td>'.$drugInfusion2.'</tr>
		<tr class="drugInfusion1"><td class="sign_p"><input type="text" id="drug_Infusion3" name="drug_Infusion3" value="'.$drugName3.'" placeholder="Enter drug infucion3"></td><td><input type="text" id="drug_Infusion_value3" name="drug_Infusion_value3" onkeyup="checkDrugValue(\'drug_Infusion3\',\'drug_Infusion_value3\',\'Enter Drug Infusion First\')"></td>'.$drugInfusion3.'</tr>
		<tr class="drugInfusion1"><td class="sign_p"><input type="text" id="drug_Infusion4" name="drug_Infusion4" value="'.$drugName4.'" placeholder="Enter drug infucion4"></td><td><input type="text" id="drug_Infusion_value4" name="drug_Infusion_value4" onkeyup="checkDrugValue(\'drug_Infusion4\',\'drug_Infusion_value4\',\'Enter Drug Infusion First\')"></td>'.$drugInfusion4.'</tr>
		<tr class="drugInfusion1"><td class="sign_p"><input type="text" id="drug_Infusion5" name="drug_Infusion5" value="'.$drugName5.'" placeholder="Enter drug infucion5"></td><td><input type="text" id="drug_Infusion_value5" name="drug_Infusion_value5" onkeyup="checkDrugValue(\'drug_Infusion5\',\'drug_Infusion_value5\',\'Enter Drug Infusion First\')"></td>'.$drugInfusion5.'</tr>
		
		<tr class="bg_color"><td class="mainsign_p" colspan='.$colspan.'><b><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class13. '\')"></i> BOLUS</b></td></tr>
		<tr class="bolus1"><td class="sign_p"><input type="text" id="bolusName1" name="bolusname1" value="'.$bolusName1.'" placeholder="Enter Bolus 1" ></td><td><input type="text" id="bolus1" name="bolus1" onkeyup="checkDrugValue(\'bolusName1\',\'bolus1\',\'Enter Bolus Name First\')"></td>'.$bolus1.'</tr>
		<tr class="bolus1"><td class="sign_p"><input type="text" id="bolusName2" name="bolusname2" value="'.$bolusName2.'" placeholder="Enter Bolus 2" ></td><td><input type="text" id="bolus2" name="bolus2" onkeyup="checkDrugValue(\'bolusName2\',\'bolus2\',\'Enter Bolus Name First\')"></td>'.$bolus2.'</tr>
		<tr class="bolus1"><td class="sign_p"><input type="text" id="bolusName3" name="bolusname3" value="'.$bolusName3.'" placeholder="Enter Bolus 3" ></td><td><input type="text" id="bolus3" name="bolus3" onkeyup="checkDrugValue(\'bolusName3\',\'bolus3\',\'Enter Bolus Name First\')"></td>'.$bolus3.'</tr>
		<tr class="bolus1"><td class="sign_p"><input type="text" id="bolusName4" name="bolusname4" value="'.$bolusName4.'" placeholder="Enter Bolus 4" ></td><td><input type="text" id="bolus4" name="bolus4" onkeyup="checkDrugValue(\'bolusName4\',\'bolus4\',\'Enter Bolus Name First\')"></td>'.$bolus4.'</tr>
		<tr class="bolus1"><td class="sign_p"><input type="text" id="bolusName5" name="bolusname5" value="'.$bolusName5.'" placeholder="Enter Bolus 5" ></td><td><input type="text" id="bolus5" name="bolus5" onkeyup="checkDrugValue(\'bolusName5\',\'bolus5\',\'Enter Bolus Name First\')"></td>'.$bolus5.'</tr>

		<tr class="bg_color"><td class="mainsign_p" colspan='.$colspan.'><b><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class14. '\')"></i> IV Fluids</b></td></tr>
		<tr class="ivFluids1"><td class="sign_p"><input type="text" id="ivfluidName1" name="ivfluidName1" value="'.$ivfluidName1.'" placeholder="Enter Iv Fluid 1" ></td><td><input type="text" id="ivFluids1" name="ivFluids1" onkeyup="checkDrugValue(\'ivfluidName1\',\'ivFluids1\',\'Enter Iv fluid First\')"></td>'.$IVFluids1.'</tr>
		<tr class="ivFluids1"><td class="sign_p"><input type="text" id="ivfluidName2" name="ivfluidName2" value="'.$ivfluidName2.'" placeholder="Enter Iv Fluid 2" ></td><td><input type="text" id="ivFluids2" name="ivFluids2" onkeyup="checkDrugValue(\'ivfluidName2\',\'ivFluids2\',\'Enter Iv fluid First\')"></td>'.$IVFluids2.'</tr>
		<tr class="ivFluids1"><td class="sign_p"><input type="text" id="ivfluidName3" name="ivfluidName3" value="'.$ivfluidName3.'" placeholder="Enter Iv Fluid 3" ></td><td><input type="text" id="ivFluids3" name="ivFluids3" onkeyup="checkDrugValue(\'ivfluidName3\',\'ivFluids3\',\'Enter Iv fluid First\')"></td>'.$IVFluids3.'</tr>
		<tr class="ivFluids1"><td class="sign_p"><input type="text" id="ivfluidName4" name="ivfluidName4" value="'.$ivfluidName4.'" placeholder="Enter Iv Fluid 4" ></td><td><input type="text" id="ivFluids4" name="ivFluids4" onkeyup="checkDrugValue(\'ivfluidName4\',\'ivFluids4\',\'Enter Iv fluid First\')"></td>'.$IVFluids4.'</tr>
		<tr class="ivFluids1"><td class="sign_p"><input type="text" id="ivfluidName5" name="ivfluidName5" value="'.$ivfluidName5.'" placeholder="Enter Iv Fluid 5" ></td><td><input type="text" id="ivFluids5" name="ivFluids5" onkeyup="checkDrugValue(\'ivfluidName5\',\'ivFluids5\',\'Enter Iv fluid First\')"></td>'.$IVFluids5.'</tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class3. '\')"></i> <b>Output</b></td>'.$output1_s.'</tr>
		<tr class="op1"><td class="sign_p">hourly N.G./Vomitus</td><td><input type="number" name="ng" id="ng"></td>'.$ngvom.'</tr>
		<tr class="op1"><td class="sign_p">Cumulative N.G. (A)</td><td></td>'.$cumng.'</tr>
		<tr class="op1"><td class="sign_p">Hourly Urine</td><td><input type="number" name="hurin" id="hurin"></td>'.$hurin.'</tr>
		<tr class="op1"><td class="sign_p">Cumulative Urine (B)</td><td></td>'.$cumurin.'</tr>
		<tr class="op1"><td class="sign_p">Drain -I</td><td><input type="number" name="dr1" id="dr1"></td>'.$dr1.'</tr>
		<tr class="op1"><td class="sign_p">Drain -II</td><td><input type="number" name="dr2" id="dr2"></td>'.$dr2.'</tr>
		<tr class="op1"><td class="sign_p">Drain -III</td><td><input type="number" name="dr3" id="dr3"></td>'.$dr3.'</tr>
		<tr class="op1"><td class="sign_p">Drain -IV</td><td><input type="number" name="dr4" id="dr4"></td>'.$dr4.'</tr>
		<tr class="op1"><td class="sign_p">Hourly Drainage</td><td><input type="number" name="hrdrain" id="hrdrain"></td>'.$hrdrain.'</tr>
		<tr class="op1"><td class="sign_p">Cum. Drainage(C)</td><td></td>'.$cumdrain.'</tr>
		<tr class="op1"><td class="sign_p">Total Output (A+B+C)</td><td></td>'.$totalop.'</tr>
		
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class4. '\')"></i> <b>Others</b></td>'.$others_s.'</tr>
		<tr class="ot1"><td class="sign_p">IABP ratio</td><td><input type="number" name="iabp" id="iabp"></td>'.$iabp_ratio.'</tr>
		<tr class="ot1"><td class="sign_p">Abdominal Girth</td><td><input type="number"  name="abdominal" id="abdominal"></td>'.$abdominal.'</tr>
		<!--<tr class="ot1"><td class="sign_p">Pedal Pulse (R)</td><td><input type="number" name="ppr" id="ppr"></td>'.$ppr.'</tr>-->
		<tr class="ot1"><td class="sign_p">Pulse
			<select id="pulseField" name="pulseField">
				<option selected disabled>Select Pulse</option>
				<option value="Radial">Radial</option>
				<option value="Brachial">Brachial</option>
				<option value="Femoral">Femoral</option>
				<option value="Dorsalis Pedis">Dorsalis Pedis</option>
				<option value="Posterial Tibial">Posterial Tibial</option>
			</select>
		</td><td><input type="number"  name="ppl" id="ppl">
		</td>'.$ppl.'</tr>
		<tr class="ot1"><td class="sign_p">Bowel Opened</td><td>
		<input type="radio" name="bowlop" value="yes" id="bowlopyes" class="bowlop">
		<label for="bowlopyes">Yes</label>
		<input type="radio" name="bowlop" value="no" id="bowlopno" class="bowlop">
		<label for="bowlopno">No</label>
		</td>'.$bowlop.'</tr>
		
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class5. '\')"></i> <b>Invasive Lines</b></td>'.$invasive_lines_s.'</tr>
		<tr class="il1"><td class="sign_p">Central Line</td><td><input type="text" name="centralline" id="centralline"></td class="sign_p">'.$centralline.'</tr>
		<tr class="il1"><td class="sign_p">Arterial Lines</td><td><input type="text" name="atriallines" id="atriallines"></td>'.$atriallines.'</tr>
		<tr class="il1"><td class="sign_p">HD Catheter</td><td><input type="text" name="hdCatheter" id="hdCatheter"></td>'.$hdCatheter.'</tr>
		<tr class="il1"><td class="sign_p">Peripheral Line</td><td><input type="text" name="periline" id="periline"></td>'.$periline.'</tr>
		<tr class="il1"><td class="sign_p">Drains</td><td><input type="text" name="drains" id="drains"></td>'.$drains.'</tr>
		<tr class="il1"><td class="sign_p">Urinary Catheter</td><td><input type="text" name="urincatheter" id="urincatheter"></td>'.$urincatheter.'</tr>
		<tr class="il1"><td class="sign_p">Endotracheal Tube</td><td><input type="text" name="endoTube" id="endoTube"></td>'.$endoTube.'</tr>
		<tr class="il1"><td class="sign_p">IABP catheter</td><td><input type="text" name="iabpCatheter" id="iabpCatheter"></td>'.$iabpCatheter.'</tr>
		<tr class="il1"><td class="sign_p">Tracheostomy tube</td><td><input type="text" name="tracheTube" id="tracheTube"></td>'.$tracheTube.'</tr>
		<tr class="il1"><td class="sign_p">Ryles tube</td><td><input type="text" name="rylesTube" id="rylesTube"></td>'.$rylesTube.'</tr>
		
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class6. '\')"></i> <b>RASS</b></td>'.$rass_s.'</tr>
		<tr class="rass">
		<td class="sign_p">
		<input type="radio" id="Combative" name="para1" class="para1" value="Combative" onclick="getRassScaleScore(\'rass\',+4)">
		<label for="Combative">Combative</label><br>
		<input type="radio" id="v_agitated" name="para1" class="para1" value="Very Agitated" onclick="getRassScaleScore(\'rass\',+3)">
		<label for="female">Very Agitated</label><br>
		<input type="radio" id="agitated" name="para1" class="para1" value="Agitated" onclick="getRassScaleScore(\'rass\',+2)">
		<label for="female">Agitated</label><br>
		<input type="radio" id="restless" name="para1" class="para1" value="Restless" onclick="getRassScaleScore(\'rass\',+1)">
		<label for="female">Restless</label><br>
		<input type="radio" id="alertcalm" name="para1" class="para1" value="Alert & Calm" onclick="getRassScaleScore(\'rass\',0)">
		<label for="female">Alert & Calm</label><br>
		<input type="radio" id="drowsy" name="para1" class="para1" value="Drowsy" onclick="getRassScaleScore(\'rass\',-1)">
		<label for="male">Drowsy</label><br>
		<input type="radio" id="lightsedation" name="para1" class="para1" value="Light Sedation" onclick="getRassScaleScore(\'rass\',-2)">
		<label for="female">Light Sedation</label><br>
		<input type="radio" id="msedation" name="para1" class="para1" value="Moderate Sedation" onclick="getRassScaleScore(\'rass\',-3)">
		<label for="female">Moderate Sedation</label><br>
		<input type="radio" id="deepsedation" name="para1" class="para1" value="Deep Sedation" onclick="getRassScaleScore(\'rass\',-4)">
		<label for="female">Deep Sedation</label><br>
		<input type="radio" id="usedation" name="para1" class="para1" value="Unarousable Sedation" onclick="getRassScaleScore(\'rass\',-5)">
		<label for="female">Unarousable sedation</label>
		</td>
		<td><input readonly type="number" name="rass" id="rass" class=""></td>'.$rass.'</tr>
		
		
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class7. '\')"></i> <b>Nursing Care</b></td>'.$nursing_care_s.'</tr>
		<tr class="nursecare"><td class="sign_p">Back Care</td>
		<td>
		<input type="radio"  name="backcare" value="yes" id="backcareyes" class="backcare">
		<label for="male">Yes</label>
		<input type="radio" name="backcare" value="no" id="backcareno" class="backcare">
		<label for="female">No</label></td>'.$backcare.'</tr>
		<tr class="nursecare"><td class="sign_p">Mouth care</td>
		<td>
		<input type="radio" name="mcare" value="yes" id="mcareyes" class="mcare">
		<label for="male">Yes</label>
		<input type="radio" name="mcare" value="no" id="mcareno" class="mcare">
		<label for="female">No</label></td>'.$mcare.'</tr>
		<tr class="nursecare"><td class="sign_p">Eye care</td>
		<td>
		<input type="radio" name="eyecare" value="yes" id="eyecareyes" class="eyecare">
		<label for="male">Yes</label>
		<input type="radio" name="eyecare" value="no" id="eyecareno" class="eyecare">
		<label for="female">No</label></td>'.$eyecare.'</tr>
		<tr class="nursecare"><td class="sign_p">Chest P.T.</td>
		<td>
		<input type="radio"  name="chestpt" value="yes" id="chestptyes" class="chestpt">
		<label for="male">Yes</label>
		<input type="radio" name="chestpt" value="no" id="chestptno" class="chestpt">
		<label for="female">No</label></td>'.$chestpt.'</tr>
		<tr class="nursecare"><td class="sign_p">Limb P.T.</td>
		<td>
		<input type="radio" name="limbpt" value="yes" id="limbptyes" class="limbpt">
		<label for="male">Yes</label>
		<input type="radio" name="limbpt" value="no" id="limbptno" class="limbpt">
		<label for="female">No</label></td>'.$limbpt.'</tr>
		<tr class="nursecare"><td class="sign_p">Cuff pressure</td>
		<td>
		<input type="number" name="cuffp" id="cuffpyes" class="cuffp">
		<!--<label for="male">Yes</label>
		<input type="radio" name="cuffp" value="no" id="cuffpno" class="cuffp">
		<label for="female">No</label>-->
		</td>'.$cuffp.'</tr>
		<tr class="nursecare"><td class="sign_p">Central line dressing</td>
		<td>
		<input type="radio" name="cldress" value="yes" id="cldressyes" class="cldress">
		<label for="male">Yes</label>
		<input type="radio"  name="cldress" value="no" id="cldressno" class="cldress">
		<label for="female">No</label></td>'.$cldress.'</tr>
		<tr class="nursecare"><td class="sign_p">E.T./T.T. care</td>
		<td>
		<input type="radio" name="Etcare" value="yes" id="Etcareyes" class="Etcare">
		<label for="male">Yes</label>
		<input type="radio"  name="Etcare" value="no" id="Etcareno" class="Etcare">
		<label for="female">No</label></td>'.$Etcare.'</tr>
		<tr class="nursecare"><td class="sign_p">Sponge Bath</td>
		<td>
		<input type="radio"  name="sbath" value="yes" id="sbathyes" class="sbath">
		<label for="male">Yes</label>
		<input type="radio"  name="sbath" value="no" id="sbathno" class="sbath">
		<label for="female">No</label></td>'.$sbath.'</tr>
		<tr class="nursecare"><td class="sign_p">Pressure Sore</td>
		<td>
		<input type="radio"  name="presore" value="yes" id="presoreyes" class="presore">
		<label for="male">Yes</label>
		<input type="radio"  name="presore" value="no" id="presoreno" class="presore">
		<label for="female">No</label></td>'.$presore.'</tr>
		<tr class="nursecare"><td class="sign_p">Site</td><td><textarea name="site" id="site"></textarea></td>'.$site.'</tr>
		<tr class="nursecare"><td class="sign_p">Action Taken</td><td><textarea name="action" id="action_taken"></textarea></td>'.$action.'</tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class8. '\')"></i> <b>Diabetic</b></td>'.$diabetic_s.'</tr>
		<tr class="diabetic"><td class="sign_p">Blood Sugar</td><td><input type="number" name="bldsgr" id="bldsgr"></td>'.$bldsgr.'</tr>
		<tr class="diabetic"><td class="sign_p">Insuline</td><td><input type="number"  name="insl" id="insl"></td>'.$insl.'</tr>
		<tr class="diabetic"><td class="sign_p">Name Of Insuline</td><td><input type="text"  name="inslField" id="inslField" ></td>'.$insulineName.'</tr>
		<tr class="diabetic"><td class="sign_p">Route Of Administration</td><td><input type="text" name="routeAdmi" id="routeAdmi"></td>'.$routeAdmi.'</tr>
		
		<tr class="bg_color"><td class="mainsign_p"><b>P Asse.(scrore)</b></td><td><input type="number"  name="score" id="score"></td>'.$score.'</tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class9. '\')"></i> <b>Intake</b></td>'.$intake_s.'</tr>
		<tr class="intake"><td class="sign_p">I/V.</td><td><input type="number"  name="in_iv" id="in_iv"></td>'.$in_iv.'</tr>
		<tr class="intake"><td class="sign_p">R.T.</td><td><input type="number"  name="in_rt" id="in_rt"></td>'.$in_rt.'</tr>
		<tr class="intake"><td class="sign_p">Oral</td><td><input type="number"  name="in_orl" id="in_orl"></td>'.$in_orl.'</tr>
		<tr class="intake"><td class="sign_p">Total(A)</td><td></td>'.$intake_total.'</tr>
		<tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class10. '\')"></i> <b>Output</b></td>'.$output2_s.'</tr>
		<tr class="op2"><td class="sign_p">Urine</td><td><input type="number"  name="op_urn" id="op_urn"></td>'.$op_urn.'</tr>
		<tr class="op2"><td class="sign_p">R.T.</td><td><input type="number"  name="op_rt" id="op_rt"></td>'.$op_rt.'</tr>
		<tr class="op2"><td class="sign_p">Drain</td><td><input type="number"  name="op_drn" id="op_drn"></td>'.$op_drn.'</tr>
		<tr class="op2"><td class="sign_p">Total(B)</td><td></td>'.$output_B_t.'</tr>
		<tr class="op2"><td class="sign_p">Balance</td><td></td>'.$balance_Total.'</tr>
		
		<tr>
		
		<tr class="bg_color"><td colspan='.$colspan.'><i style="font-size:11px" class="fa fa-plus" onclick="load(\'' .$class11. '\')"></i> <b>Diet Chart</b></td>'.$die_chart_s.'</tr>
		<tr class="dc1"><td class="sign_p">Type of Diet</td><td>
		<!--<textarea name="qty" id="qty"></textarea>-->
		<select id="qty" name="qty">
				<option selected disabled>Select Type of Diet </option>
				<option value="Full Diet">Full Diet</option>
				<option value="Soft Diet">Soft Diet</option>
				<option value="Liquid Diet">Liquid Diet</option>
				<option value="Tube Feed">Tube Feed</option>
		</select>
		</td>'.$qty.'</tr>
		<tr class="dc1"><td class="sign_p">Type of Meal</td><td>
		<!--<textarea name="typemeal" id="typemeal"></textarea>-->
		<select id="typemeal" name="typemeal">
				<option selected disabled>Select Type of Meal </option>
				<option value="Normal">Normal</option>
				<option value="Diabetic">Diabetic</option>
				<option value="Renal">Renal</option>
				<option value="Salt Free">Salt Free</option>
				<option value="Jain">Jain</option>
		</select>
		</td>'.$typemeal.'</tr>
		<tr class="dc1"><td class="sign_p">Given By</td><td><textarea name="given" id="given"></textarea></td>'.$given.'</tr>
		<tr class="dc1"><td class="sign_p">Remarks</td><td><textarea name="remark" id="remark"></textarea></td>'.$remark.'</tr>
		
		
		</tbody>
		</table>
		';
		
		$response['data']=$data;
		$response['status']=200;
		$response['date_filter']=$date_f;
		$response['date_format']=date('D d M Y',strtotime($date_f));
		echo json_encode($response);
	}
	public function uploadIcuCriticalCareForm(){
		
	
	$branch_id = $this->session->user_session->branch_id;
	$user_id = $this->session->user_session->id;
	
	$patient_id=$this->input->post('patient_id');
	$icucare_id=$this->input->post('hidden_id');

	$temperature="";
	$BPs="";
	$BPd="";
	$HR="";
	$RR="";
	$RHYTHM="";
	$SPO2="";
	$ETCO2="";
	$BIPAP="";
	$Flo2="";
	$Mode="";
	$PEE="";
	$PPEAK="";
	$RATE="";
	$Tidal_Volume="";
	$Pressure_Support="";
	$RASS="";
	$hourly_N_G="";
	$Hourly_Urine="";
	$Drain1="";
	$Drain2="";
	$Drain3="";
	$Drain4="";
	$Hourly_Drainage="";
	$IABP_ratio="";
	$Abdominal_Girth="";
	$Pedal_Pulse_R="";
	$Pedal_Pulse_L="";
	$Bowel_Opened="";
	$Central_Line="";
	$Atrial_Lines="";
	$HD_Catheter="";
	$Peripheral_Line="";
	$Drains="";
	$Urinary_Catheter="";
	$Endotracheal_Tube="";
	$IABP_catheter="";
	$Tracheostomy_tube="";
	$Ryles_tube="";
	$Back_Care="";
	$Mouth_care="";
	$Eye_care="";
	$Chest_P_T="";
	$Limb_P_T="";
	$Cuff_pressure="";
	$Central_line_dressing="";
	$E_TT_T_care="";
	$Sponge_Bath="";
	$Pressure_Sore="";
	$Site="";
	$Action_Taken="";
	$Blood_Sugar="";
	$Insulin="";
	$InsulinName="";
	$routeAdmini="";
	$Score="";
	$IV="";
	$R_T="";
	$Oral="";
	$Urine="";
	$output_R_T="";
	$output_Drain="";
	$Quantity="";
	$TypeOfMeal="";
	$Given_By="";
	$Remarks="";



	$temperature=$this->input->post('temp');
	$BPs=$this->input->post('bpsytolic');
	$BPd=$this->input->post('bpdiastolic');
	$HR=$this->input->post('hr');
	$RR=$this->input->post('rr');
	$RHYTHM=$this->input->post('rhythm');
	$SPO2=$this->input->post('spo2');
	$ETCO2=$this->input->post('etco2');
	$IPAP=$this->input->post('ipap');
	$EPAP=$this->input->post('epap');
	$Flo2=$this->input->post('fto2');
	$Mode=$this->input->post('mode');
	$PEE=$this->input->post('pee');
	$PPEAK=$this->input->post('ppeak');
	$RATE=$this->input->post('rate');
	$Tidal_Volume=$this->input->post('tidal');
	$Pressure_Support=$this->input->post('pressure');
	//
	$drugInfusion1="";
	$drugInfusion2="";
	$drugInfusion3="";
	$drugInfusion4="";
	$drugInfusion5="";
	$bolus1="";
	$bolus2="";
	$bolus3="";
	$bolus4="";
	$bolus5="";
	$ivfluids1="";
	$ivfluids2="";
	$ivfluids3="";
	$ivfluids4="";
	$ivfluids5="";
	// for ($i=1; $i <6 ; $i++) { 
		if($this->input->post('drug_Infusion1')!="" && $this->input->post('drug_Infusion1')!=null){
			$drugInfusion1=$this->input->post('drug_Infusion1').':'.$this->input->post('drug_Infusion_value1');
		}
		if($this->input->post('drug_Infusion2')!="" && $this->input->post('drug_Infusion2')!=null){
			$drugInfusion2=$this->input->post('drug_Infusion2').':'.$this->input->post('drug_Infusion_value2');
		}
		if($this->input->post('drug_Infusion3')!="" && $this->input->post('drug_Infusion3')!=null){
			$drugInfusion3=$this->input->post('drug_Infusion3').':'.$this->input->post('drug_Infusion_value3');
		}
		if($this->input->post('drug_Infusion4')!="" && $this->input->post('drug_Infusion4')!=null){
			$drugInfusion4=$this->input->post('drug_Infusion4').':'.$this->input->post('drug_Infusion_value4');
		}
		if($this->input->post('drug_Infusion5')!="" && $this->input->post('drug_Infusion5')!=null){
			$drugInfusion5=$this->input->post('drug_Infusion5').':'.$this->input->post('drug_Infusion_value5');
		}
		
		if($this->input->post('bolusname1')!="" && $this->input->post('bolusname1')!=null){
			$bolus1=$this->input->post('bolusname1').':'.$this->input->post('bolus1');
		}
		if($this->input->post('bolusname2')!="" && $this->input->post('bolusname2')!=null){
			$bolus2=$this->input->post('bolusname2').':'.$this->input->post('bolus2');
		}
		if($this->input->post('bolusname3')!="" && $this->input->post('bolusname3')!=null){
			$bolus3=$this->input->post('bolusname3').':'.$this->input->post('bolus3');
		}
		if($this->input->post('bolusname4')!="" && $this->input->post('bolusname4')!=null){
			$bolus4=$this->input->post('bolusname4').':'.$this->input->post('bolus4');
		}
		if($this->input->post('bolusname5')!="" && $this->input->post('bolusname5')!=null){
			$bolus5=$this->input->post('bolusname5').':'.$this->input->post('bolus5');
		}

		if($this->input->post('ivfluidName1')!="" && $this->input->post('ivfluidName1')!=null){
			$ivfluids1=$this->input->post('ivfluidName1').':'.$this->input->post('ivFluids1');
		}
		if($this->input->post('ivfluidName2')!="" && $this->input->post('ivfluidName2')!=null){
			$ivfluids2=$this->input->post('ivfluidName2').':'.$this->input->post('ivFluids2');
		}
		if($this->input->post('ivfluidName3')!="" && $this->input->post('ivfluidName3')!=null){
			$ivfluids3=$this->input->post('ivfluidName3').':'.$this->input->post('ivFluids3');
		}
		if($this->input->post('ivfluidName4')!="" && $this->input->post('ivfluidName4')!=null){
			$ivfluids4=$this->input->post('ivfluidName4').':'.$this->input->post('ivFluids4');
		}
		if($this->input->post('ivfluidName5')!="" && $this->input->post('ivfluidName5')!=null){
			$ivfluids5=$this->input->post('ivfluidName5').':'.$this->input->post('ivFluids5');
		}
		
	
	$hourly_N_G=$this->input->post('ng');
	$Hourly_Urine=$this->input->post('hurin');
	$Drain1=$this->input->post('dr1');
	$Drain2=$this->input->post('dr2');
	$Drain3=$this->input->post('dr3');
	$Drain4=$this->input->post('dr4');
	$Hourly_Drainage=$this->input->post('hrdrain');
	$IABP_ratio=$this->input->post('iabp');
	$Abdominal_Girth=$this->input->post('abdominal');
	// $Pedal_Pulse_R=$this->input->post('ppr');
	// $Pedal_Pulse_L=$this->input->post('ppl');
	if($this->input->post('pulseField')!="" && $this->input->post('pulseField')!=null){
			$Pedal_Pulse_L=$this->input->post('pulseField').':'.$this->input->post('ppl');
		}
	$Bowel_Opened=$this->input->post('bowlop');
	$Central_Line=$this->input->post('centralline');
	$Atrial_Lines=$this->input->post('atriallines');
	$HD_Catheter=$this->input->post('hdCatheter');
	$Peripheral_Line=$this->input->post('periline');
	$Drains=$this->input->post('drains');
	$Urinary_Catheter=$this->input->post('urincatheter');
	$Endotracheal_Tube=$this->input->post('endoTube');
	$IABP_catheter=$this->input->post('iabpCatheter');
	$Tracheostomy_tube=$this->input->post('tracheTube');
	$Ryles_tube=$this->input->post('rylesTube');
	$Parameter_1=$this->input->post('para1');
	// $Parameter_2=$this->input->post('para2');
	if(is_null($this->input->post('para1')) && $this->input->post('para1')=="")
	{
		$Parameter_1="";
	}
	 $RASS=$this->input->post('rass');
	// if(is_null($this->input->post('para2')) && $this->input->post('para2')=="")
	// {
	// 	$Parameter_2="";
	// }


	
	
	$Back_Care=$this->input->post('backcare');
	$Mouth_care=$this->input->post('mcare');
	$Eye_care=$this->input->post('eyecare');
	$Chest_P_T=$this->input->post('chestpt');
	$Limb_P_T=$this->input->post('limbpt');
	$Cuff_pressure=$this->input->post('cuffp');
	$Central_line_dressing=$this->input->post('cldress');
	$E_TT_T_care=$this->input->post('Etcare');
	$Sponge_Bath=$this->input->post('sbath');
	$Pressure_Sore=$this->input->post('presore');
	$Site=$this->input->post('site');
	$Action_Taken=$this->input->post('action');
	$Blood_Sugar=$this->input->post('bldsgr');
	$Insulin=$this->input->post('insl');
	$InsulinName=$this->input->post('inslField');
	// if($this->input->post('inslField')!="" && $this->input->post('inslField')!=null){
	// 		$Insulin=$this->input->post('inslField').':'.$this->input->post('insl');
	// 	}
	$routeAdmini=$this->input->post('routeAdmi');
	$Score=$this->input->post('score');
	$IV=$this->input->post('in_iv');
	$R_T=$this->input->post('in_rt');
	$Oral=$this->input->post('in_orl');
	$Urine=$this->input->post('op_urn');
	$output_R_T=$this->input->post('op_rt');
	$output_Drain=$this->input->post('op_drn');
	$Quantity=$this->input->post('qty');//type of diet
	$TypeOfMeal=$this->input->post('typemeal');//type of meal
	$Given_By=$this->input->post('given');
	$Remarks=$this->input->post('remark');

	if(is_null($this->input->post('backcare')) && $this->input->post('backcare')=="")
	{
		$Back_Care="";
	}
	if(is_null($this->input->post('mcare')) && $this->input->post('mcare')=="")
	{
		$Mouth_care="";
	}
	if(is_null($this->input->post('eyecare')) && $this->input->post('eyecare')=="")
	{
		$Eye_care="";
	}

	if(is_null($this->input->post('chestpt')) && $this->input->post('chestpt')=="")
	{
		$Chest_P_T="";
	}
	if(is_null($this->input->post('limbpt')) && $this->input->post('limbpt')=="")
	{
		$Limb_P_T="";
	}
	if(is_null($this->input->post('cuffp')) && $this->input->post('cuffp')=="")
	{
		$Cuff_pressure="";
	}
	if(is_null($this->input->post('cldress')) && $this->input->post('cldress')=="")
	{
		$Central_line_dressing="";
	}
	if(is_null($this->input->post('Etcare')) && $this->input->post('Etcare')=="")
	{
		$E_TT_T_care="";
	}
	if(is_null($this->input->post('sbath')) && $this->input->post('sbath')=="")
	{
		$Sponge_Bath="";
	}
	if(is_null($this->input->post('presore')) && $this->input->post('presore')=="")
	{
		$Pressure_Sore="";
	}
	if(is_null($this->input->post('mode')) && $this->input->post('mode')=="")
	{
		$Mode="";
	}
	if(is_null($this->input->post('bowlop')) && $this->input->post('bowlop')=="")
	{
		$Bowel_Opened="";
	}
	if(is_null($this->input->post('rhythm')) && $this->input->post('rhythm')=="")
	{
		$RHYTHM="";
	}

	if(!empty($icucare_id))
	{

		$update_data=array(
	"temperature"=>$temperature,
	"BP"=>$BPs,
	"BPDiastolic"=>$BPd,
	"HR"=>$HR,
	"RR"=>$RR,
	"RHYTHM"=>$RHYTHM,
	"SPO2"=>$SPO2,
	"ETCO2"=>$ETCO2,
	"BIPAP"=>$IPAP,
	"EPAP"=>$EPAP,
	"Flo2"=>$Flo2,
	"Mode"=>$Mode,
	"PEE"=>$PEE,
	"PPEAK"=>$PPEAK,
	"RATE"=>$RATE,
	"Tidal_Volume"=>$Tidal_Volume,
	"Pressure_Support"=>$Pressure_Support,
	"RASS"=>$RASS,
	"DRUG_Infusion1"=>$drugInfusion1,
	"DRUG_Infusion2"=>$drugInfusion2,
	"DRUG_Infusion3"=>$drugInfusion3,
	"DRUG_Infusion4"=>$drugInfusion4,
	"DRUG_Infusion5"=>$drugInfusion5,
	"BOLUS1"=>$bolus1,
	"BOLUS2"=>$bolus2,
	"BOLUS3"=>$bolus3,
	"BOLUS4"=>$bolus4,
	"BOLUS5"=>$bolus5,
	"IV_Fluids1"=>$ivfluids1,
	"IV_Fluids2"=>$ivfluids2,
	"IV_Fluids3"=>$ivfluids3,
	"IV_Fluids4"=>$ivfluids4,
	"IV_Fluids5"=>$ivfluids5,
	"hourly_N_G_Vomitus"=>$hourly_N_G,
	"Hourly_Urine"=>$Hourly_Urine,
	"DrainI"=>$Drain1,
	"DrainII"=>$Drain2,
	"DrainIII"=>$Drain3,
	"DrainIV"=>$Drain4,
	"Hourly_Drainage"=>$Hourly_Drainage,
	"IABP_ratio"=>$IABP_ratio,
	"Abdominal_Girth"=>$Abdominal_Girth,
	"Pedal_Pulse_R"=>$Pedal_Pulse_R,
	"Pedal_Pulse_L"=>$Pedal_Pulse_L,
	"Bowel_Opened"=>$Bowel_Opened,
	"Central_Line"=>$Central_Line,
	"Atrial_Lines"=>$Atrial_Lines,
	"HD_Catheter"=>$HD_Catheter,
	"Peripheral_Line"=>$Peripheral_Line,
	"Drains"=>$Drains,
	"Urinary_Catheter"=>$Urinary_Catheter,
	"Endotracheal_Tube"=>$Endotracheal_Tube,
	"IABP_catheter"=>$IABP_catheter,
	"Tracheostomy_tube"=>$Tracheostomy_tube,
	"Ryles_tube"=>$Ryles_tube,
	"Parameter_1"=>$Parameter_1,
	// "Parameter_2"=>$Parameter_2,
	"Back_Care"=>$Back_Care,
	"Mouth_care"=>$Mouth_care,
	"Eye_care"=>$Eye_care,
	"Chest_P_T"=>$Chest_P_T,
	"Limb_P_T"=>$Limb_P_T,
	"Cuff_pressure"=>$Cuff_pressure,
	"Central_line_dressing"=>$Central_line_dressing,
	"E_T_T_T_care"=>$E_TT_T_care,
	"Sponge_Bath"=>$Sponge_Bath,
	"Pressure_Sore"=>$Pressure_Sore,
	"Site"=>$Site,
	"Action_Taken"=>$Action_Taken,
	"Blood_Sugar"=>$Blood_Sugar,
	"Insulin"=>$Insulin,
	"InsulinName"=>$InsulinName,
	"routeOfAdmini"=>$routeAdmini,
	"Score"=>$Score,
	"I_V"=>$IV,
	"R_T"=>$R_T,
	"Oral"=>$Oral,
	"Urine"=>$Urine,
	"output_R_T"=>$output_R_T,
	"output_Drain"=>$output_Drain,
	"Quantity"=>$Quantity,
	"TypeOfMeal"=>$TypeOfMeal,
	"Given_By"=>$Given_By,
	"Remarks"=>$Remarks,
	);

			$this->db->where('id', $icucare_id);
		$update=$this->db->update('com_1_critical_care',$update_data);
		if($update== true){
			$response['status']=200;
			$response['body']="Added Successfully";
			
		}else{
			$response['status']=201;
			$response['body']="Failed to Add";
		}
	}
	else
	{


	
	$data=array(
	"patient_id"=>$patient_id,
	"branch_id"=>$branch_id,
	"created_on"=>date('Y-m-d H:i:s'),
	"created_by"=>$user_id,
	"temperature"=>$temperature,
	"BP"=>$BPs,
	"BPDiastolic"=>$BPd,
	"HR"=>$HR,
	"RR"=>$RR,
	"RHYTHM"=>$RHYTHM,
	"SPO2"=>$SPO2,
	"ETCO2"=>$ETCO2,
	"BIPAP"=>$IPAP,
	"EPAP"=>$EPAP,
	"Flo2"=>$Flo2,
	"Mode"=>$Mode,
	"PEE"=>$PEE,
	"PPEAK"=>$PPEAK,
	"RATE"=>$RATE,
	"Tidal_Volume"=>$Tidal_Volume,
	"Pressure_Support"=>$Pressure_Support,
	"RASS"=>$RASS,
	"DRUG_Infusion1"=>$drugInfusion1,
	"DRUG_Infusion2"=>$drugInfusion2,
	"DRUG_Infusion3"=>$drugInfusion3,
	"DRUG_Infusion4"=>$drugInfusion4,
	"DRUG_Infusion5"=>$drugInfusion5,
	"BOLUS1"=>$bolus1,
	"BOLUS2"=>$bolus2,
	"BOLUS3"=>$bolus3,
	"BOLUS4"=>$bolus4,
	"BOLUS5"=>$bolus5,
	"IV_Fluids1"=>$ivfluids1,
	"IV_Fluids2"=>$ivfluids2,
	"IV_Fluids3"=>$ivfluids3,
	"IV_Fluids4"=>$ivfluids4,
	"IV_Fluids5"=>$ivfluids5,
	"hourly_N_G_Vomitus"=>$hourly_N_G,
	"Hourly_Urine"=>$Hourly_Urine,
	"DrainI"=>$Drain1,
	"DrainII"=>$Drain2,
	"DrainIII"=>$Drain3,
	"DrainIV"=>$Drain4,
	"Hourly_Drainage"=>$Hourly_Drainage,
	"IABP_ratio"=>$IABP_ratio,
	"Abdominal_Girth"=>$Abdominal_Girth,
	"Pedal_Pulse_R"=>$Pedal_Pulse_R,
	"Pedal_Pulse_L"=>$Pedal_Pulse_L,
	"Bowel_Opened"=>$Bowel_Opened,
	"Central_Line"=>$Central_Line,
	"Atrial_Lines"=>$Atrial_Lines,
	"HD_Catheter"=>$HD_Catheter,
	"Peripheral_Line"=>$Peripheral_Line,
	"Drains"=>$Drains,
	"Urinary_Catheter"=>$Urinary_Catheter,
	"Endotracheal_Tube"=>$Endotracheal_Tube,
	"IABP_catheter"=>$IABP_catheter,
	"Tracheostomy_tube"=>$Tracheostomy_tube,
	"Ryles_tube"=>$Ryles_tube,
	"Parameter_1"=>$Parameter_1,
	// "Parameter_2"=>$Parameter_2,
	"Back_Care"=>$Back_Care,
	"Mouth_care"=>$Mouth_care,
	"Eye_care"=>$Eye_care,
	"Chest_P_T"=>$Chest_P_T,
	"Limb_P_T"=>$Limb_P_T,
	"Cuff_pressure"=>$Cuff_pressure,
	"Central_line_dressing"=>$Central_line_dressing,
	"E_T_T_T_care"=>$E_TT_T_care,
	"Sponge_Bath"=>$Sponge_Bath,
	"Pressure_Sore"=>$Pressure_Sore,
	"Site"=>$Site,
	"Action_Taken"=>$Action_Taken,
	"Blood_Sugar"=>$Blood_Sugar,
	"Insulin"=>$Insulin,
	"InsulinName"=>$InsulinName,
	"routeOfAdmini"=>$routeAdmini,
	"Score"=>$Score,
	"I_V"=>$IV,
	"R_T"=>$R_T,
	"Oral"=>$Oral,
	"Urine"=>$Urine,
	"output_R_T"=>$output_R_T,
	"output_Drain"=>$output_Drain,
	"Quantity"=>$Quantity,
	"TypeOfMeal"=>$TypeOfMeal,
	"Given_By"=>$Given_By,
	"Remarks"=>$Remarks,
	);
	
	$insert=$this->db->insert('com_1_critical_care',$data);
	if($insert== true){
		$response['status']=200;
		$response['body']="Added Successfully";
		
	}else{
		$response['status']=201;
		$response['body']="Failed to Add";

		
	}
	}
	echo json_encode($response);
	}

public function getIcuCareDataById()
{
	
	if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
	{
		$id=$this->input->post('id');
		$branch_id = $this->session->user_session->branch_id;
		$tableName="com_1_critical_care";
		$resultObject=$this->db->query('select * from '.$tableName.' where id='.$id.' and branch_id='.$branch_id);
		if($this->db->affected_rows()>0)
		{
			$result=$resultObject->row();
			
			$edit_date_format=date('D d M Y H:i',strtotime($result->created_on));
			// print_r($result);exit();
			$response['status']=200;
			$response['body']=$result;
			$response['edit_date_format']=$edit_date_format;
		} else
		{
			$response['status']=201;
			$response['body']="Failed to get data";
		}
		
	}
	else{
		$response['status']=201;
		$response['body']="Something went wrong";
	}
	echo json_encode($response);
}
	
	
public function getGCSData()
{
		$patient_id=$this->input->post('patient_id');
	$branch_id = $this->session->user_session->branch_id;
		$th="";
		$eyeopen_name="";
		$BVR_name="";
		$BMR_name="";
		$pupil="";
		$motor_power_name="";
		$date_id=$this->input->post('id');
		$date_filter=$this->input->post('date');
		// $date_f=date('Y-m-d');
		$total_gcs="";
		$eyeopen_td="";
		$BVR_td="";
		$BMR_td="";
		$pupil_td="";
		$motor_power_td="";

		if($date_id==null)
		{
			
			$date_f=date('Y-m-d', strtotime($date_filter));
		}
		else{
			if($date_id==2)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' + 1 day'));
			}
			else if($date_id==1)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' - 1 day'));
			}
			else
			{
				$date_f=date('Y-m-d', strtotime($date_filter));
			}
		}
		$response['date_f']=$date_f;


	$query=$this->db->query("select * from com_1_glass_glow where patient_id=".$patient_id." and branch_id=".$branch_id." and date(date)='".$date_f."' order by id desc");
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			
			foreach($result as $row){
				$total_count="";
				$date=$row->date;
				$total_count=$row->eyeopen_val+$row->BVR_val+$row->BMR_val;
				$th .='<th style="width:60px;font-size:11px;text-align:center">'.$date=date('D M d H:i',strtotime($row->date)).'<i class="fas fa-pencil-alt" style="font-size:8px;border: 1px solid #bbb8b9;padding: 2px;box-shadow: 0px 0px 0px 0px #888888;" onclick="get_data_to_edit(\''.$row->id.'\')"></i>
				</th>';
				$eyeopen_name .="<td style='width:60px;font-size:11px'>".$row->eyeopen_name."</td>";
				$BVR_name .="<td style='width:60px;font-size:11px'>".$row->BVR_name."</td>";
				$BMR_name .="<td style='width:60px;font-size:11px'>".$row->BMR_name."</td>";
				$motor_power_name .="<td style='width:60px;font-size:11px'>".$row->motor_power_name."</td>";
				$pupil .= "<td style='width:60px;font-size:11px'>R:".$row->right_reaction."
				<br>R:".$row->right_size."
				<br>L:".$row->left_reaction."
				<br>L:".$row->left_size."</td>";

				$eyeopen_td.="<td style='width:60px;font-size:11px'></td>";
				$BVR_td.="<td style='width:60px;font-size:11px'></td>";
				$BMR_td.="<td style='width:60px;font-size:11px'></td>";
				$pupil_td.="<td style='width:60px;font-size:11px'></td>";
				$motor_power_td.="<td style='width:60px;font-size:11px'></td>";
				$total_gcs.="<td style='width:60px;font-size:11px'>".$total_count."</td>";
			}
		}else{
			
		}
		$data="";
		$data .='
		<table class="table-bordered" id="new_table">
		<input type="hidden" name="glasgow_coma_edit_id" id="glasgow_coma_edit_id">
		<thead>
		<tr class="bg_color">
		<th >Items</th>
		<th class="nowtr"style="width:76px">Now <span id="glasglow_edit_date" style="font-size:9px;"></span></th>
		'.$th.'
		</tr ">
		</thead>
		<tbody>
		<tr class="bg_color"><td onclick="load(\'eyeopen\')"><i style="font-size:11px" class="fa fa-plus"></i><b> Eye Opening</b></td>
		<td>
		<input type="text" name="eyeopenval" id="eyeopenval"  readonly class="td_input">
		<input type="hidden" name="h_eyeopenval"  id="h_eyeopenval" readonly>
		</td>
		'.$eyeopen_name.'
		</tr>
		<tr class="eyeopen">
		<td >
		<input type="radio"  name="eyeopen" value="4" id="eyeopen1" class="eyeopen_n" onclick="give_value(\'eyeopenval\',4,\'Spontaneously\')">
		<label for="male">Spontaneously (4)</label><br>
		<input type="radio" name="eyeopen" value="3" id="eyeopen2" class="eyeopen_n" onclick="give_value(\'eyeopenval\',3,\'To speech\')">
		<label for="female">To speech (3)</label><br>
		<input type="radio" name="eyeopen" value="2" id="eyeopen3" class="eyeopen_n"  onclick="give_value(\'eyeopenval\',2,\'To pain\')">
		<label for="female">To Pain (2)</label><br>
		<input type="radio" name="eyeopen" value="1" id="eyeopen4" class="eyeopen_n" onclick="give_value(\'eyeopenval\',1,\'None\')">
		<label for="female">None (1)</label>
		</td><td></td>'.$eyeopen_td.'
		
		</tr>
		<tr class="bg_color"><td onclick="load(\'bvrtgl\')"><i style="font-size:11px" class="fa fa-plus"></i><b> B.V.R<b></td>
		<td>
		<input type="text" name="bvrval" id="bvrval" readonly class="td_input">
		<input type="hidden" name="h_bvrval" id="h_bvrval"  readonly>
		</td>
		'.$BVR_name.'
		</tr>
		<tr class="bvrtgl"><td>
		<input type="radio"  name="bvr" value="5" id="bvr1" class="bvr_c" onclick="give_value(\'bvrval\',5,\'Oriented\')">
		<label for="male">Oriented (5)</label><br>
		<input type="radio" name="bvr" value="4" id="bvr2" class="bvr_c" onclick="give_value(\'bvrval\',4,\'Confused\')">
		<label for="female">Confused (4)</label><br>
		<input type="radio" name="bvr" value="3" id="bvr3" class="bvr_c" onclick="give_value(\'bvrval\',3,\'Inappropriate Words\')" >
		<label for="female">inappropriate Words (3)</label><br>
		<input type="radio" name="bvr" value="2" id="bvr4" class="bvr_c" onclick="give_value(\'bvrval\',2,\'Incomprehensible Sounds\')">
		<label for="female">Incomprehensible Sounds (2)</label><br>
		<input type="radio" name="bvr" value="1" id="bvr5" class="bvr_c" onclick="give_value(\'bvrval\',1,\'None\')">
		<label for="female">None (1)</label><br>
		<input type="radio" name="bvr" value="0" id="bvr6" class="bvr_c" onclick="give_value(\'bvrval\',0,\'On TT or ET Tube\')">
		<label for="female">On TT or ET Tube (0)</label>
		</td>
		<td></td>'.$BVR_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'bmrtgl\')"><i style="font-size:11px" class="fa fa-plus"></i><b> B.M.R</b></td>
		<td>
		<input type="text" name="bmrval" id="bmrval"   readonly class="td_input">
		<input type="hidden" name="h_bmrval" id="h_bmrval"  readonly>
		</td>
		'.$BMR_name.'
		</tr>
		<tr class="bmrtgl">
		<td>
		<input type="radio"  name="bmr" value="6" id="bmr1" class="bmr_c" onclick="give_value(\'bmrval\',6,\'Obeys command\')">
		<label for="male">Obeys command (6)</label><br>
		<input type="radio" name="bmr" value="5" id="bmr2" class="bmr_c" onclick="give_value(\'bmrval\',5,\'Localises to pain\')">
		<label for="female">Localises to pain (5)</label><br>
		<input type="radio" name="bmr" value="4" id="bmr3" class="bmr_c" onclick="give_value(\'bmrval\',4,\'Withdraws to pain\')" >
		<label for="female">Withdraws to pain (4)</label><br>
		<input type="radio" name="bmr" value="3" id="bmr4" class="bmr_c" onclick="give_value(\'bmrval\',3,\'Decorticate\')" >
		<label for="female">Decorticate (3)</label><br>
		<input type="radio" name="bmr" value="2" id="bmr5" class="bmr_c" onclick="give_value(\'bmrval\',2,\'Decerebrate\')">
		<label for="female">Decerebrate (2)</label><br>
		<input type="radio" name="bmr" value="1" id="bmr6" class="bmr_c" onclick="give_value(\'bmrval\',1,\'None\')">
		<label for="female">None (1)</label>
		</td>
		<td></td>'.$BMR_td.'
		</tr>
		<tr class="bg_color"><td><b> Total GCS</b></td>
		<td></td>
		'.$total_gcs.'
		</tr>

		<tr class="bg_color"><td onclick="load(\'pupilreaction\')"><i style="font-size:11px" class="fa fa-plus"></i><b> Pupilary Reaction</b></td>
		<td><input type="text" name="prr1val" id="prr1val" readonly class="td_input">
		<input type="hidden" id="h_prr1val" name="h_prr1val" readonly>
		<input type="text" name="prrval" id="prrval" readonly class="td_input">
		<input type="hidden"id="h_prrval" name="h_prrval" readonly>
		<input type="text" name="prl1val" id="prl1val" readonly class="td_input">
		<input type="hidden" id="h_prl1val" name="h_prl1val" readonly>
		<input type="text" name="prlval" id="prlval" readonly class="td_input">
		<input type="hidden" name="h_prlval" id="h_prlval" readonly>
		</td>
		'.$pupil.'
		</tr>
		
		<tr class="pupilreaction">
		<td>
		<div class="row">
		<div class="col-md-12"><lable><b>Right Reaction:</b></lable></div>
		<div class="col-md-6">
		<input type="radio"  name="prr1" id="prr1" class="prr1" value="Reacting" onclick="give_value(\'prr1val\',\'Reacting\',\'R:Reacting\')">
		<label for="male">Reacting</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prr1" id="prr2" class="prr1" value="fixed" onclick="give_value(\'prr1val\',\'fixed\',\'R:fixed\')">
		<label for="male">Fixed</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prr1" id="prr3" class="prr1" value="normal" onclick="give_value(\'prr1val\',\'normal\',\'R:normal\')">
		<label for="male">Normal</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prr1" id="prr4" class="prr1" value="sluggish" onclick="give_value(\'prr1val\',\'sluggish\',\'R:sluggish\')">
		<label for="male">sluggish</label>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12"><lable><b>Right size:</b></lable></div>
		<div class="col-md-6">
		<input type="radio"  name="prr" id="prrs1" class="prrs1" value="8mm" onclick="give_value(\'prrval\',\'8mm\',\'R:8mm\')">
		<label for="male">8 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs2" class="prrs1" value="7mm" onclick="give_value(\'prrval\',\'7mm\',\'R:7mm\')">
		<label for="female">7 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs3" class="prrs1" value="6mm" onclick="give_value(\'prrval\',\'6mm\',\'R:6mm\')">
		<label for="female">6 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs4" class="prrs1" value="5mm" onclick="give_value(\'prrval\',\'5mm\',\'R:5mm\')">
		<label for="female">5 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs5" class="prrs1" value="4mm" onclick="give_value(\'prrval\',\'4mm\',\'R:4mm\')">
		<label for="female">4 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs6" class="prrs1" value="3mm" onclick="give_value(\'prrval\',\'3mm\',\'R:3mm\')">
		<label for="female">3 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs7" class="prrs1" value="2mm" onclick="give_value(\'prrval\',\'2mm\',\'R:2mm\')">
		<label for="female">2 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prr" id="prrs8" class="prrs1" value="1mm" onclick="give_value(\'prrval\',\'1mm\',\'R:1mm\')">
		<label for="female">1 mm</label>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12"><lable><b>Left Reaction:</b></lable></div>
		<div class="col-md-6">
		<input type="radio"  name="prl1" id="prl1" class="prl1" value="Reacting" onclick="give_value(\'prl1val\',\'Reacting\',\'L:Reacting\')">
		<label for="male">Reacting</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prl1" id="prl2" class="prl1" value="fixed" onclick="give_value(\'prl1val\',\'fixed\',\'L:fixed\')">
		<label for="male">Fixed</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prl1" id="prl3" class="prl1" value="normal" onclick="give_value(\'prl1val\',\'normal\',\'L:normal\')">
		<label for="male">Normal</label>
		</div>
		<div class="col-md-6">
		<input type="radio"  name="prl1" id="prl4" class="prl1" value="sluggish" onclick="give_value(\'prl1val\',\'sluggish\',\'L:sluggish\')">
		<label for="male">sluggish</label>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12"><lable><b>Left Size:</b></lable></div>
		<div class="col-md-6">
		<input type="radio"  name="prl" id="prls1" class="prls1" value="8mm" onclick="give_value(\'prlval\',\'8mm\',\'L:8mm\')">
		<label for="male">8 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls2" class="prls1" value="7mm" onclick="give_value(\'prlval\',\'7mm\',\'L:7mm\')" >
		<label for="female">7 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls3" class="prls1" value="6mm" onclick="give_value(\'prlval\',\'6mm\',\'L:6mm\')">
		<label for="female">6 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls4" class="prls1" value="5mm" onclick="give_value(\'prlval\',\'5mm\',\'L:5mm\')">
		<label for="female">5 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls5" class="prls1" value="4mm" onclick="give_value(\'prlval\',\'4mm\',\'L:4mm\')">
		<label for="female">4 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls6" class="prls1" value="3mm" onclick="give_value(\'prlval\',\'3mm\',\'L:3mm\')">
		<label for="female">3 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls7" class="prls1" value="2mm"  onclick="give_value(\'prlval\',\'2mm\',\'L:2mm\')">
		<label for="female">2 mm</label>
		</div>
		<div class="col-md-6">
		<input type="radio" name="prl" id="prls8" class="prls1" value="1mm" onclick="give_value(\'prlval\',\'1mm\',\'L:1mm\')">
		<label for="female">1 mm</label>
		</div>
		</div>
		</td>
		<td></td>'.$pupil_td.'
		</tr>
		
		<tr class="bg_color"><td onclick="load(\'motorpwr\')"><i style="font-size:11px" class="fa fa-plus"></i><b> Motor Power</b></td>
		<td><input type="text" name="mtrpwrval" id="mtrpwrval" readonly class="td_input">
		<input type="hidden" id="h_mtrpwrval" name="h_mtrpwrval" readonly></td>
		'.$motor_power_name.'
		</tr>
		<tr class="motorpwr">
		<td>
		<input type="radio"  name="mtrpwr" id="mtrpwr1" class="mtrpwr1" value="5" onclick="give_value(\'mtrpwrval\',5,\'Normal Strenght\')">
		<label for="male">Normal Strenght</label><br>
		<input type="radio" name="mtrpwr" id="mtrpwr2" class="mtrpwr1" value="4"onclick="give_value(\'mtrpwrval\',4,\'Moves With min. Res.\')" >
		<label for="female">Moves With min. Res.</label><br>
		<input type="radio" name="mtrpwr" id="mtrpwr3" class="mtrpwr1" value="3" onclick="give_value(\'mtrpwrval\',3,\'Moves againts gravity without Res.\')">
		<label for="female">Moves againts gravity without Res.</label><br>
		<input type="radio" name="mtrpwr" id="mtrpwr4" class="mtrpwr1" value="2" onclick="give_value(\'mtrpwrval\',2,\'Moves With gravity Eliminated\')">
		<label for="female">Moves With gravity Eliminated</label><br>
		<input type="radio" name="mtrpwr" id="mtrpwr5" class="mtrpwr1" value="1" onclick="give_value(\'mtrpwrval\',1,\'Flickering\')">
		<label for="female">Flickering</label><br>
		<input type="radio" name="mtrpwr" id="mtrpwr6" class="mtrpwr1" value="0" onclick="give_value(\'mtrpwrval\',0,\'No movement\')">
		<label for="female">No movement</label>
		
		</td>
		<td></td>'.$motor_power_td.'
		</tr>
		
		</tbody>
		</table>
		';
		$response['data']=$data;
		$response['status']=200;
		$response['date_format']=date('D d M Y',strtotime($date_f));
		echo json_encode($response);
	}
	
	
	function uploadGlassglowForm(){
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$patient_id=$this->input->post('patient_id');
		$glasgow_coma_edit_id=$this->input->post('glasgow_coma_edit_id');
		$h_eyeopenval=$this->input->post('h_eyeopenval');
		$eyeopenval=$this->input->post('eyeopenval');
		$h_bvrval=$this->input->post('h_bvrval');
		$bvrval=$this->input->post('bvrval');
		$h_bmrval=$this->input->post('h_bmrval');
		$bmrval=$this->input->post('bmrval');
		$h_prr1val=$this->input->post('h_prr1val');
		$h_prrval=$this->input->post('h_prrval');
		$h_prl1val=$this->input->post('h_prl1val');
		$h_prlval=$this->input->post('h_prlval');
		$h_mtrpwrval=$this->input->post('h_mtrpwrval');
		$mtrpwrval=$this->input->post('mtrpwrval');
		if(!empty($glasgow_coma_edit_id))
		{
			$where = array("company_id"=>$company_id,
							"branch_id"=>$branch_id,
							"patient_id"=>$patient_id,
							"id"=>$glasgow_coma_edit_id);

			$update_data=array(
				"eyeopen_val"=>$h_eyeopenval,
				"eyeopen_name"=>$eyeopenval,
				"BVR_val"=>$h_bvrval,
				"BVR_name"=>$bvrval,
				"BMR_val"=>$h_bmrval,
				"BMR_name"=>$bmrval,
				"right_reaction"=>$h_prr1val,
				"right_size"=>$h_prrval,
				"left_reaction"=>$h_prl1val,
				"left_size"=>$h_prlval,
				"motor_power_val"=>$h_mtrpwrval,
				"motor_power_name"=>$mtrpwrval,
				);
			$this->db->where($where);
			$update=$this->db->update('com_1_glass_glow',$update_data);
			if($update== true){
				$response['status']=200;
				$response['body']="Added Successfully";
				
			}else{
				$response['status']=201;
				$response['body']="Failed to Add";
			}
		}
		else
		{
			$data=array(
				"company_id"=>$company_id,
				"branch_id"=>$branch_id,
				"patient_id"=>$patient_id,
				"date"=>date('Y-m-d h:i:s'),
				"created_by"=>$user_id,
				"eyeopen_val"=>$h_eyeopenval,
				"eyeopen_name"=>$eyeopenval,
				"BVR_val"=>$h_bvrval,
				"BVR_name"=>$bvrval,
				"BMR_val"=>$h_bmrval,
				"BMR_name"=>$bmrval,
				"right_reaction"=>$h_prr1val,
				"right_size"=>$h_prrval,
				"left_reaction"=>$h_prl1val,
				"left_size"=>$h_prlval,
				"motor_power_val"=>$h_mtrpwrval,
				"motor_power_name"=>$mtrpwrval,
				);
				$insert=$this->db->insert("com_1_glass_glow",$data);
				if($insert== true){
				$response['status']=200;
				$response['body']="Added Successfully";
				}else{
				$response['status']=201;
				$response['body']="Failed to Add";	
				}
		}
		echo json_encode($response);
		
	}


	public function getBradenScaleData()
	{
		$patient_id=$this->input->post('patient_id');
		
		$th="";
		$sernsory_p_name="";
		$moisture_name="";
		$activity_name="";
		$mobility_name="";
		$nutrition_name="";
		$friction_share_name="";
		$total="";
		$date_id=$this->input->post('id');
		$date_filter=$this->input->post('date');
		// $date_f=date('Y-m-d');

		$sernsory_p_td="";
		$moisture_td="";
		$activity_td="";
		$mobility_td="";
		$nutrition_td="";
		$friction_share_td="";
		
		if($date_id==null)
		{
			
			$date_f=date('Y-m-d', strtotime($date_filter));
		}
		else{
			if($date_id==2)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' + 1 day'));
			}
			else if($date_id==1)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' - 1 day'));
			}
			else
			{
				$date_f=date('Y-m-d', strtotime($date_filter));
			}
		}
		$response['date_f']=$date_f;
		$tableName="com_1_barden_scale";

		$query=$this->db->query("select * from ".$tableName." where patient_id='$patient_id' and date(date)='$date_f' order by id desc");
		if($this->db->affected_rows() > 0){
			$result=$query->result();
		
			foreach($result as $row){
					$total_count="";
					$interpretation="";
				$date=$row->date;
				$total_count=$row->sernsor_val+$row->moisture_val+$row->activity_val+$row->mobility_val+$row->nutrition_val+$row->friction_share_val;
				// print_r($total_count);
				$th .='<th style="width:60px;font-size:11px;text-align:center">'.$date=date('D M d H:i',strtotime($row->date)).'<i class="fas fa-pencil-alt" style="font-size:8px;border: 1px solid #bbb8b9;padding: 2px;box-shadow: 0px 0px 0px 0px #888888;" onclick="get_bardendata_to_edit(\''.$row->id.'\')"></i></th>';
				$sernsory_p_name .="<td style='width:60px;font-size:11px'>".$row->sernsor_name."</td>";
				$moisture_name .="<td style='width:60px;font-size:11px'>".$row->moisture_name."</td>";
				$activity_name .="<td style='width:60px;font-size:11px'>".$row->activity_name."</td>";
				$mobility_name .="<td style='width:60px;font-size:11px'>".$row->mobility_name."</td>";
				$nutrition_name .="<td style='width:60px;font-size:11px'>".$row->nutrition_name."</td>";
				$friction_share_name .="<td style='width:60px;font-size:11px'>".$row->friction_share_name."</td>";
				if($total_count>=6 && $total_count<=9)
				{
					$interpretation.="Very High Risk";
				}
				else if($total_count>=10 && $total_count<=12)
				{
					$interpretation.="High Risk";
				}
				else if($total_count>=13 && $total_count<=15)
				{
					$interpretation.="Medium Risk";
				}
				else if($total_count>=16 && $total_count<=18)
				{
					$interpretation.="Low Risk";
				}
				else
				{
					$interpretation.="Low Risk";
				}
				$total.="<td style='width:60px;font-size:11px'>".$interpretation."</td>";

				$sernsory_p_td.="<td style='width:60px;font-size:11px'></td>";
				$moisture_td.="<td style='width:60px;font-size:11px'></td>";
				$activity_td.="<td style='width:60px;font-size:11px'></td>";
				$mobility_td.="<td style='width:60px;font-size:11px'></td>";
				$nutrition_td.="<td style='width:60px;font-size:11px'></td>";
				$friction_share_td.="<td style='width:60px;font-size:11px'></td>";
				
			}
		}else{
			
		}

		$data="";
		$data .='
		<table class="table-bordered" id="barden_table">
		<input type="hidden" name="barden_scale_edit_id" id="barden_scale_edit_id">
		<thead>
		<tr class="bg_color">
		<th >Items</th>
		<th class="nowtr"style="width:76px">Now<span style="font-size:9px;" id="barden_scale_edit_date"></span></th>
		'.$th.'
		</tr ">
		</thead>
		<tbody>
		<tr class="bg_color"><td onclick="load(\'sensory_p\')"><i style="font-size:11px" class="fa fa-plus"></i><b>SENSORY PERCEPTION</b></td>
		<td>
		<input type="text" name="sensory_p" id="sensory_p"  readonly class="td_input">
		<input type="hidden" name="h_sensory_p"  id="h_sensory_p" readonly>
		</td>
		'.$sernsory_p_name.'
		</tr>
		<tr class="sensory_p">
		<td >
		<input type="radio"  name="sensory_pe" id="sensory_pe1" class="sensory_pe1" value="1" onclick="give_value(\'sensory_p\',1,\'Completely Limited\')">
		<label for="male">Completely Limited (1)</label><br>
		<input type="radio" name="sensory_pe" id="sensory_pe2" class="sensory_pe1" value="2"  onclick="give_value(\'sensory_p\',2,\'Very Limited\')">
		<label for="female">Very Limited (2)</label><br>
		<input type="radio" name="sensory_pe" id="sensory_pe3" class="sensory_pe1" value="3"  onclick="give_value(\'sensory_p\',3,\'Slightly Limited\')">
		<label for="female">Slightly Limited (3)</label><br>
		<input type="radio" name="sensory_pe" id="sensory_pe4" class="sensory_pe1" value="4" onclick="give_value(\'sensory_p\',4,\'No Impairment\')">
		<label for="female">No Impairment (4)</label>
		</td><td></td>'.$sernsory_p_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'moisture_m\')"><i style="font-size:11px" class="fa fa-plus"></i><b>MOISTURE</b></td>
		<td>
		<input type="text" name="moisture_m" id="moisture_m"  readonly class="td_input">
		<input type="hidden" name="h_moisture_m"  id="h_moisture_m" readonly>
		</td>
		'.$moisture_name.'
		</tr>
		<tr class="moisture_m">
		<td >
		<input type="radio"  name="moisture_me" id="moisture_me1" class="moisture_me1" value="1" onclick="give_value(\'moisture_m\',1,\'Constantly Moist\')">
		<label for="male">Constantly Moist (1)</label><br>
		<input type="radio" name="moisture_me" id="moisture_me2" class="moisture_me1" value="2"  onclick="give_value(\'moisture_m\',2,\'Very Moist\')">
		<label for="female">Very Moist (2)</label><br>
		<input type="radio" name="moisture_me" id="moisture_me3" class="moisture_me1" value="3"  onclick="give_value(\'moisture_m\',3,\'Occasionally Moist\')">
		<label for="female">Occasionally Moist (3)</label><br>
		<input type="radio" name="moisture_me" id="moisture_me4" class="moisture_me1" value="4" onclick="give_value(\'moisture_m\',4,\'Rarely Moist\')">
		<label for="female">Rarely Moist (4)</label>
		</td><td></td>'.$moisture_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'activity_a\')"><i style="font-size:11px" class="fa fa-plus"></i><b>ACTIVITY</b></td>
		<td>
		<input type="text" name="activity_a" id="activity_a"  readonly class="td_input">
		<input type="hidden" name="h_activity_a"  id="h_activity_a" readonly>
		</td>
		'.$activity_name.'
		</tr>
		<tr class="activity_a">
		<td >
		<input type="radio"  name="activity_ae" id="activity_ae1" class="activity_ae1" value="1" onclick="give_value(\'activity_a\',1,\'Bed Fast\')">
		<label for="male">Bed Fast</label><br>
		<input type="radio" name="activity_ae" id="activity_ae2" class="activity_ae1" value="2"  onclick="give_value(\'activity_a\',2,\'Chair Fast\')">
		<label for="female">Chair Fast</label><br>
		<input type="radio" name="activity_ae" id="activity_ae3" class="activity_ae1" value="3"  onclick="give_value(\'activity_a\',3,\'Walks Occasionally\')">
		<label for="female">Walks Occasionally</label><br>
		<input type="radio" name="activity_ae" id="activity_ae4" class="activity_ae1" value="4" onclick="give_value(\'activity_a\',4,\'Walks Frequently\')">
		<label for="female">Walks Frequently</label>
		</td><td></td>'.$activity_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'mobility_m\')"><i style="font-size:11px" class="fa fa-plus"></i><b>MOBILITY</b></td>
		<td>
		<input type="text" name="mobility_m" id="mobility_m"  readonly class="td_input">
		<input type="hidden" name="h_mobility_m"  id="h_mobility_m" readonly>
		</td>
		'.$mobility_name.'
		</tr>
		<tr class="mobility_m">
		<td >
		<input type="radio"  name="mobility_me" id="mobility_me1" class="mobility_me1" value="1" onclick="give_value(\'mobility_m\',1,\'Completely Immobile\')">
		<label for="male">Completely Immobile (1)</label><br>
		<input type="radio" name="mobility_me" id="mobility_me2" class="mobility_me1" value="2"  onclick="give_value(\'mobility_m\',2,\'Very Limited\')">
		<label for="female">Very Limited (2)</label><br>
		<input type="radio" name="mobility_me" id="mobility_me3" class="mobility_me1" value="3"  onclick="give_value(\'mobility_m\',3,\'Slightly Limited\')">
		<label for="female">Slightly Limited (3)</label><br>
		<input type="radio" name="mobility_me" id="mobility_me4" class="mobility_me1" value="4"  onclick="give_value(\'mobility_m\',4,\'No Limitations\')">
		<label for="female">No Limitations (4)</label><br>
		
		</td><td></td>'.$mobility_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'nutrition_n\')"><i style="font-size:11px" class="fa fa-plus"></i><b>NUTRITION</b></td>
		<td>
		<input type="text" name="nutrition_n" id="nutrition_n"  readonly class="td_input">
		<input type="hidden" name="h_nutrition_n"  id="h_nutrition_n" readonly>
		</td>
		'.$nutrition_name.'
		</tr>
		<tr class="nutrition_n">
		<td >
		<input type="radio"  name="nutrition_ne" id="nutrition_ne1" class="nutrition_ne1" value="1" onclick="give_value(\'nutrition_n\',1,\'Very Poor\')">
		<label for="male">Very Poor (1)</label><br>
		<input type="radio" name="nutrition_ne" id="nutrition_ne2" class="nutrition_ne1" value="2"  onclick="give_value(\'nutrition_n\',2,\'Probably Inadequate\')">
		<label for="female">Probably Inadequate (2)</label><br>
		<input type="radio" name="nutrition_ne" id="nutrition_ne3" class="nutrition_ne1" value="3"  onclick="give_value(\'nutrition_n\',3,\'Adequate\')">
		<label for="female">Adequate (3)</label><br>
		<input type="radio" name="nutrition_ne" id="nutrition_ne4" class="nutrition_ne1" value="4"  onclick="give_value(\'nutrition_n\',4,\'Excellent\')">
		<label for="female">Excellent (4)</label>
		
		</td><td></td>'.$nutrition_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'friction_share_s\')"><i style="font-size:11px" class="fa fa-plus"></i><b>FRICTION & SHARE</b></td>
		<td>
		<input type="text" name="friction_share_s" id="friction_share_s"  readonly class="td_input">
		<input type="hidden" name="h_friction_share_s"  id="h_friction_share_s" readonly>
		</td>
		'.$friction_share_name.'
		</tr>
		<tr class="friction_share_s">
		<td >
		<input type="radio"  name="friction_share_se" id="friction_share_se1" class="friction_share_se1" value="1" onclick="give_value(\'friction_share_s\',1,\'Problem\')">
		<label for="male">Problem (1)</label><br>
		<input type="radio" name="friction_share_se" id="friction_share_se2" class="friction_share_se1" value="2"  onclick="give_value(\'friction_share_s\',2,\'Potential Problem\')">
		<label for="female">Potential Problem (2)</label><br>
		<input type="radio" name="friction_share_se" id="friction_share_se3" class="friction_share_se1" value="3"  onclick="give_value(\'friction_share_s\',3,\'No Apparent Problem\')">
		<label for="female">No Apparent Problem (3)</label>
		
		
		</td><td></td>'.$friction_share_td.'
		</tr>

		<tr class="bg_color"><td><b>Braden Score Interpretation</b></td>
		<td>
		
		</td>
		'.$total.'
		</tr>

		</tbody>
		</table>';

		$response['data']=$data;
		$response['status']=200;
		$response['date_format']=date('D d M Y',strtotime($date_f));
		echo json_encode($response);

	}
	public function uploadBradenScaleForm()
	{
		// print_r($this->input->post());exit();
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$patient_id=$this->input->post('patient_id');
		$barden_scale_edit_id=$this->input->post('barden_scale_edit_id');
		$h_sensory_p=$this->input->post('h_sensory_p');
		$sensory_p=$this->input->post('sensory_p');
		$h_moisture_m=$this->input->post('h_moisture_m');
		$moisture_m=$this->input->post('moisture_m');
		$h_activity_a=$this->input->post('h_activity_a');
		$activity_a=$this->input->post('activity_a');
		$h_mobility_m=$this->input->post('h_mobility_m');
		$mobility_m=$this->input->post('mobility_m');
		$h_nutrition_n=$this->input->post('h_nutrition_n');
		$nutrition_n=$this->input->post('nutrition_n');
		$h_friction_share_s=$this->input->post('h_friction_share_s');
		$friction_share_s=$this->input->post('friction_share_s');

		if(!empty($barden_scale_edit_id))
		{
			$where=array("company_id"=>$company_id,
				"branch_id"=>$branch_id,
				"patient_id"=>$patient_id,
				"id"=>$barden_scale_edit_id);
			$update_data=array(
				"sernsor_val"=>$h_sensory_p,
				"sernsor_name"=>$sensory_p,
				"moisture_val"=>$h_moisture_m,
				"moisture_name"=>$moisture_m,
				"activity_val"=>$h_activity_a,
				"activity_name"=>$activity_a,
				"mobility_val"=>$h_mobility_m,
				"mobility_name"=>$mobility_m,
				"nutrition_val"=>$h_nutrition_n,
				"nutrition_name"=>$nutrition_n,
				"friction_share_val"=>$h_friction_share_s,
				"friction_share_name"=>$friction_share_s,
				);
			$this->db->where($where);
			$update=$this->db->update('com_1_barden_scale',$update_data);
			if($update== true){
				$response['status']=200;
				$response['body']="Added Successfully";
				
			}else{
				$response['status']=201;
				$response['body']="Failed to Add";
			}
		}
		else
		{
			$data=array(
				"company_id"=>$company_id,
				"branch_id"=>$branch_id,
				"patient_id"=>$patient_id,
				"date"=>date('Y-m-d h:i:s'),
				"created_by"=>$user_id,
				"sernsor_val"=>$h_sensory_p,
				"sernsor_name"=>$sensory_p,
				"moisture_val"=>$h_moisture_m,
				"moisture_name"=>$moisture_m,
				"activity_val"=>$h_activity_a,
				"activity_name"=>$activity_a,
				"mobility_val"=>$h_mobility_m,
				"mobility_name"=>$mobility_m,
				"nutrition_val"=>$h_nutrition_n,
				"nutrition_name"=>$nutrition_n,
				"friction_share_val"=>$h_friction_share_s,
				"friction_share_name"=>$friction_share_s,
				);
				$insert=$this->db->insert("com_1_barden_scale",$data);
				if($insert== true){	
				$response['status']=200;
				$response['body']="Added Successfully";
				}else{
				$response['status']=201;
				$response['body']="Failed to Add";	
				}
		}
		echo json_encode($response);
	}

	public function getFallRiskAsseData()
	{
		$patient_id=$this->input->post('patient_id');
		
		$th="";
		$age_f_name="";
		$fall_history_name="";
		$elimination_name="";
		$medication_name="";
		$equipment_name="";
		$mobility_f_name="";
		$cognition_name="";
		$total="";

		$age_td="";
		$fall_history_td="";
		$elimination_td="";
		$medication_td="";
		$equipment_td="";
		$mobility_f_td="";
		$cognition_td="";

		$date_id=$this->input->post('id');
		$date_filter=$this->input->post('date');
		// $date_f=date('Y-m-d');

		
		if($date_id==null)
		{
			
			$date_f=date('Y-m-d', strtotime($date_filter));
		}
		else{
			if($date_id==2)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' + 1 day'));
			}
			else if($date_id==1)
			{
				
				$date_f=date('Y-m-d', strtotime($date_filter. ' - 1 day'));
			}
			else
			{
				$date_f=date('Y-m-d', strtotime($date_filter));
			}
		}
		$response['date_f']=$date_f;
		$tableName="com_1_fall_risk";

		$query=$this->db->query("select * from ".$tableName." where patient_id='$patient_id' and date(date)='$date_f' order by id desc");
		if($this->db->affected_rows() > 0){
			$result=$query->result();
			
			foreach($result as $row){
				$total_count="";
				$total_count_risk="";
				$date=$row->date;
				$total_count=$row->age_val+$row->fall_history_val+$row->elimination_val+$row->medication_val+$row->equipment_val+$row->mobility_val+$row->cognition_val;
				if($total_count>=6 && $total_count<=13)
				{
					$total_count_risk="Moderate Risk";
				}else if($total_count>13)
				{
					$total_count_risk="High Risk";
				}

				$th .='<th style="width:60px;font-size:11px;text-align:center">'.$date=date('D M d H:i',strtotime($row->date)).'<i class="fas fa-pencil-alt" style="font-size:8px;border: 1px solid #bbb8b9;padding: 2px;box-shadow: 0px 0px 0px 0px #888888;" onclick="get_fallRiskdata_to_edit(\''.$row->id.'\')"></i>
				</th>';
				$age_f_name .="<td style='width:60px;font-size:11px'>".$row->age_name."</td>";
				$fall_history_name .="<td style='width:60px;font-size:11px'>".$row->fall_history_name."</td>";
				$elimination_name .="<td style='width:60px;font-size:11px'>".$row->elimination_name."</td>";
				$medication_name .="<td style='width:60px;font-size:11px'>".$row->medication_name."</td>";
				$equipment_name .="<td style='width:60px;font-size:11px'>".$row->equipment_name."</td>";
				$mobility_f_name .="<td style='width:60px;font-size:11px'>".$row->mobility_name."</td>";
				$cognition_name .="<td style='width:60px;font-size:11px'>".$row->cognition_name."</td>";
				$total.="<td style='width:60px;font-size:11px'>".$total_count_risk."</td>";

				$age_td.="<td style='width:60px;font-size:11px'></td>";
				$fall_history_td.="<td style='width:60px;font-size:11px'></td>";
				$elimination_td.="<td style='width:60px;font-size:11px'></td>";
				$medication_td.="<td style='width:60px;font-size:11px'></td>";
				$equipment_td.="<td style='width:60px;font-size:11px'></td>";
				$mobility_f_td.="<td style='width:60px;font-size:11px'></td>";
				$cognition_td.="<td style='width:60px;font-size:11px'></td>";
				
			}
		}else{
			
		}

		$data="";
		$data .='
		<table class="table-bordered" id="fall_risk_table">
		<input type="hidden" name="fall_risk_edit_id" id="fall_risk_edit_id">
		<thead>
		<tr class="bg_color">
		<th >Items</th>
		<th class="nowtr"style="width:76px">Now <span style="font-size:9px;" id="fall_risk_edit_date"></span></th>
		'.$th.'
		</tr ">
		</thead>
		<tbody>
		<tr class="bg_color"><td onclick="load(\'age_a\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Age</b></td>
		<td>
		<input type="text" name="age_a" id="age_a"  readonly class="td_input">
		<input type="hidden" name="h_age_a"  id="h_age_a" readonly>
		</td>
		'.$age_f_name.'
		</tr>
		<tr class="age_a">
		<td >
		<input type="radio"  name="age_ae" id="age_ae1" class="age_ae1" value="1" onclick="give_value(\'age_a\',1,\'Less than 60 yrs\')">
		<label for="male">Less than 60 yrs (1)</label><br>
		<input type="radio" name="age_ae" id="age_ae2" class="age_ae1" value="2"  onclick="give_value(\'age_a\',2,\'60 to 69 yrs\')">
		<label for="female">60 to 69 yrs (2)</label><br>
		<input type="radio" name="age_ae" id="age_ae3" class="age_ae1" value="3"  onclick="give_value(\'age_a\',3,\'70 to 79 yrs\')">
		<label for="female">70 to 79 yrs (3)</label><br>
		<input type="radio" name="age_ae" id="age_ae4" class="age_ae1" value="4" onclick="give_value(\'age_a\',4,\'greater than equal 80yrs\')">
		<label for="female">greater than equal 80yrs (4)</label>
		</td><td></td>'.$age_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'fall_history_h\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Fall history</b></td>
		<td>
		<input type="text" name="fall_history_h" id="fall_history_h"  readonly class="td_input">
		<input type="hidden" name="h_fall_history_h"  id="h_fall_history_h" readonly>
		</td>
		'.$fall_history_name.'
		</tr>
		<tr class="fall_history_h">
		<td >
		<input type="radio"  name="fall_he" id="fall_he1" class="fall_he1" value="0" onclick="give_value(\'fall_history_h\',0,\'None\')">
		<label for="male">None</label><br>
		<input type="radio" name="fall_he" id="fall_he2" class="fall_he1" value="5"  onclick="give_value(\'fall_history_h\',5,\'One fall within 6 months before admission\')">
		<label for="female">One fall within 6 months before admission (5)</label><br>
		
		</td><td></td>'.$fall_history_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'elimination_f\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Elimination:</b><span style="font-size:6px;">Bowel and Urine</span></td>
		<td>
		<input type="text" name="elimination_f" id="elimination_f"  readonly class="td_input">
		<input type="hidden" name="h_elimination_f"  id="h_elimination_f" readonly>
		</td>
		'.$elimination_name.'
		</tr>
		<tr class="elimination_f">
		<td >
		<input type="radio"  name="elimination_fe" id="elimination_fe1" class="elimination_fe1" value="2" onclick="give_value(\'elimination_f\',2,\'Incontinence\')">
		<label for="male">Incontinence (2)</label><br>
		<input type="radio" name="elimination_fe" id="elimination_fe2" class="elimination_fe1" value="2"  onclick="give_value(\'elimination_f\',2,\'Urgency or frequency\')">
		<label for="female">Urgency or frequency (2)</label><br>
		<input type="radio" name="elimination_fe" id="elimination_fe3" class="elimination_fe1" value="4"  onclick="give_value(\'elimination_f\',4,\'Urgency or frequency and incontinence\')">
		<label for="female">Urgency or frequency and incontinence (4)</label>
		</td><td></td>'.$elimination_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'medications_f\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Medications:</b></td>
		<td>
		<input type="text" name="medications_f" id="medications_f"  readonly class="td_input">
		<input type="hidden" name="h_medications_f"  id="h_medications_f" readonly>
		</td>
		'.$medication_name.'
		</tr>
		<tr class="medications_f">
		<td >
		<input type="radio"  name="medications_fe" id="medications_fe1" class="medications_fe1" value="3" onclick="give_value(\'medications_f\',3,\'On 1 high fall risk drug\')">
		<label for="male">On 1 high fall risk drug (3)</label><br>
		<input type="radio" name="medications_fe" id="medications_fe2" class="medications_fe1" value="5"  onclick="give_value(\'medications_f\',5,\'On 2 or more high fall risk drugs\')">
		<label for="female">On 2 or more high fall risk drugs (5)</label><br>
		<input type="radio" name="medications_fe" id="medications_fe3" class="medications_fe1" value="7"  onclick="give_value(\'medications_f\',7,\'Sedated procedure within pas 24 hours\')">
		<label for="female">Sedated procedure within past 24 hours (7)</label>
		</td><td></td>'.$medication_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'equipment_f\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Patient Care Equipment:</b></td>
		<td>
		<input type="text" name="equipment_f" id="equipment_f"  readonly class="td_input">
		<input type="hidden" name="h_equipment_f"  id="h_equipment_f" readonly>
		</td>
		'.$equipment_name.'
		</tr>
		<tr class="equipment_f">
		<td >
		<input type="radio"  name="equipment_fe" id="equipment_fe1" class="equipment_fe1" value="1" onclick="give_value(\'equipment_f\',1,\'One present\')">
		<label for="male">One present (1)</label><br>
		<input type="radio" name="equipment_fe" id="equipment_fe2" class="equipment_fe1" value="2"  onclick="give_value(\'equipment_f\',2,\'Two present\')">
		<label for="female">Two present (2)</label><br>
		<input type="radio" name="equipment_fe" id="equipment_fe3" class="equipment_fe1" value="3"  onclick="give_value(\'equipment_f\',3,\'Three or more present\')">
		<label for="female">Three or more present (3)</label>
		</td><td></td>'.$equipment_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'mobility_f\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Mobility</b></td>
		<td>
		<input type="text" name="mobility_f" id="mobility_f"  readonly class="td_input">
		<input type="hidden" name="h_mobility_f"  id="h_mobility_f" readonly>
		</td>
		'.$mobility_f_name.'
		</tr>
		<tr class="mobility_f">
		<td >
		<input type="checkbox"  name="mobility_fe1" id="mobility_fe1" class="mobility_fe1" value="Requires assistance for mobility, transfer or ambulation" onclick="give_value(\'mobility_f\',2,\'Requires assistance for mobility, transfer or ambulation\')">
		<label for="male">Requires assistance for mobility, transfer or ambulation (2)</label><br>
		<input type="checkbox" name="mobility_fe2" id="mobility_fe2" class="mobility_fe1" value="Unsteady gait"  onclick="give_value(\'mobility_f\',2,\'Unsteady gait\')">
		<label for="female">Unsteady gait (2)</label><br>
		<input type="checkbox" name="mobility_fe3" id="mobility_fe3" class="mobility_fe1" value="Visual or auditory impairment  affecting mobility"  onclick="give_value(\'mobility_f\',2,\'Visual or auditory impairment  affecting mobility\')">
		<label for="female">Visual or auditory impairment  affecting mobility (2)</label>
		
		</td><td></td>'.$mobility_f_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'cogmtion_f\')"><i style="font-size:11px" class="fa fa-plus"></i><b>Cognition</b></td>
		<td>
		<input type="text" name="cogmtion_f" id="cogmtion_f"  readonly class="td_input">
		<input type="hidden" name="h_cogmtion_f"  id="h_cogmtion_f" readonly>
		</td>
		'.$cognition_name.'
		</tr>
		<tr class="cogmtion_f">
		<td >
		<!--<input type="radio"  name="cogmtion_fe" id="cogmtion_fe1" class="cogmtion_fe1" value="2" onclick="give_value(\'cogmtion_f\',2,\'Visual or auditory or impairment affecting mobility\')">
		<label for="male">Visual or auditory or impairment affecting mobility</label><br>-->
		<input type="checkbox" name="cogmtion_fe1" id="cogmtion_fe2" class="cogmtion_fe1" value="Altered awareness of immediate physical environment"  onclick="give_value(\'cogmtion_f\',1,\'Altered awareness of immediate physical environment\')">
		<label for="female">Altered awareness of immediate physical environment (1)</label><br>
		<input type="checkbox"  name="cogmtion_fe2" id="cogmtion_fe3" class="cogmtion_fe1" value="Impulsive" onclick="give_value(\'cogmtion_f\',2,\'Impulsive\')">
		<label for="male">Impulsive (2)</label><br>
		<input type="checkbox" name="cogmtion_fe3" id="cogmtion_fe4" class="cogmtion_fe1" value="Lack of undesrtanding of ones physical and cognitive limitations"  onclick="give_value(\'cogmtion_f\',4,\'Lack of undesrtanding of ones physical and cognitive limitations\')">
		<label for="female">Lack of undesrtanding of ones physical and cognitive limitations (4)</label>
		
		</td><td></td>'.$cognition_td.'
		</tr>
		<tr class="bg_color"><td onclick="load(\'score_f\')"><b>Fall Risk Score Interpretation</b></td>
		<td>
		</td>
		'.$total.'
		</tr>

		</tbody>
		</table>';
		$response['data']=$data;
		$response['status']=200;
		$response['date_format']=date('D d M Y',strtotime($date_f));
		echo json_encode($response);

	}

	public function uploadFallRiskForm()
	{
		
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$user_id = $this->session->user_session->id;
		$patient_id=$this->input->post('patient_id');
		$fall_risk_edit_id=$this->input->post('fall_risk_edit_id');
		$age_a=$this->input->post('age_a');
		$h_age_a=$this->input->post('h_age_a');
		$h_fall_history_h=$this->input->post('h_fall_history_h');
		$fall_history_h=$this->input->post('fall_history_h');
		$h_elimination_f=$this->input->post('h_elimination_f');
		$elimination_f=$this->input->post('elimination_f');
		$h_medications_f=$this->input->post('h_medications_f');
		$medications_f=$this->input->post('medications_f');
		$h_equipment_f=$this->input->post('h_equipment_f');
		$equipment_f=$this->input->post('equipment_f');
		// $h_mobility_f=$this->input->post('h_mobility_f');
		$h_mobility_f=0;
		// $mobility_f=$this->input->post('mobility_f');
		$mobility_fe1=0;
		$mobility_fe2=0;
		$mobility_fe3=0;
		$mobility_array=array();
		if(!is_null($this->input->post('mobility_fe1')) && $this->input->post('mobility_fe1')!="")
		{
			array_push($mobility_array,$this->input->post('mobility_fe1'));
			$mobility_fe1=2;
		}

		if(!is_null($this->input->post('mobility_fe2')) && $this->input->post('mobility_fe2')!="")
		{
			array_push($mobility_array,$this->input->post('mobility_fe2'));
			$mobility_fe2=2;
		}
		if(!is_null($this->input->post('mobility_fe3')) && $this->input->post('mobility_fe3')!="")
		{
			array_push($mobility_array,$this->input->post('mobility_fe3'));
			$mobility_fe3=2;
		}
		
		$h_mobility_f=$mobility_fe1+$mobility_fe2+$mobility_fe3;
		if(!array_filter($mobility_array))
		{
			$mobility_f="";
		}
		else
		{
			if(count($mobility_array)>1)
			{
				$mobility_f=implode('|||', $mobility_array);
			}
			else
			{
				$mobility_f=array_shift($mobility_array);
			}
		}

		// $h_cogmtion_f=$this->input->post('h_cogmtion_f');
		$h_cogmtion_f=0;
		// $cogmtion_f=$this->input->post('cogmtion_f');
		$cogmtion_fe1=0;
		$cogmtion_fe2=0;
		$cogmtion_fe3=0;
		$cogmtion_array=array();

		if(!is_null($this->input->post('cogmtion_fe1')) && $this->input->post('cogmtion_fe1')!="")
		{
			array_push($cogmtion_array,$this->input->post('cogmtion_fe1'));
			$cogmtion_fe1=1;
		}

		if(!is_null($this->input->post('cogmtion_fe2')) && $this->input->post('cogmtion_fe2')!="")
		{
			array_push($cogmtion_array,$this->input->post('cogmtion_fe2'));
			$cogmtion_fe2=2;
		}
		if(!is_null($this->input->post('cogmtion_fe3')) && $this->input->post('cogmtion_fe3')!="")
		{
			array_push($cogmtion_array,$this->input->post('cogmtion_fe3'));
			$cogmtion_fe3=4;
		}

		$h_cogmtion_f=$cogmtion_fe1+$cogmtion_fe2+$cogmtion_fe3;

		if(!array_filter($cogmtion_array))
		{
			$cogmtion_f="";
		}
		else
		{
			if(count($cogmtion_array)>1)
			{
				$cogmtion_f=implode('|||', $cogmtion_array);
			}
			else
			{
				$cogmtion_f=array_shift($cogmtion_array);
			}
		}
	
		// print_r($cogmtion_array);exit();
		if(!empty($fall_risk_edit_id))
		{
			$where=array("company_id"=>$company_id,
				"branch_id"=>$branch_id,
				"patient_id"=>$patient_id,
				"id"=>$fall_risk_edit_id);
			$update_data=array(
				"age_val"=>$h_age_a,
				"age_name"=>$age_a,
				"fall_history_val"=>$h_fall_history_h,
				"fall_history_name"=>$fall_history_h,
				"elimination_val"=>$h_elimination_f,
				"elimination_name"=>$elimination_f,
				"medication_val"=>$h_medications_f,
				"medication_name"=>$medications_f,
				"equipment_val"=>$h_equipment_f,
				"equipment_name"=>$equipment_f,
				"mobility_val"=>$h_mobility_f,
				"mobility_name"=>$mobility_f,
				"cognition_val"=>$h_cogmtion_f,
				"cognition_name"=>$cogmtion_f
				);
			$this->db->where($where);
			$update=$this->db->update('com_1_fall_risk',$update_data);
			if($update== true){
				$response['status']=200;
				$response['body']="Added Successfully";
				
			}else{
				$response['status']=201;
				$response['body']="Failed to Add";
			}
		}
		else
		{
			$data=array(
				"company_id"=>$company_id,
				"branch_id"=>$branch_id,
				"patient_id"=>$patient_id,
				"date"=>date('Y-m-d h:i:s'),
				"created_by"=>$user_id,
				"age_val"=>$h_age_a,
				"age_name"=>$age_a,
				"fall_history_val"=>$h_fall_history_h,
				"fall_history_name"=>$fall_history_h,
				"elimination_val"=>$h_elimination_f,
				"elimination_name"=>$elimination_f,
				"medication_val"=>$h_medications_f,
				"medication_name"=>$medications_f,
				"equipment_val"=>$h_equipment_f,
				"equipment_name"=>$equipment_f,
				"mobility_val"=>$h_mobility_f,
				"mobility_name"=>$mobility_f,
				"cognition_val"=>$h_cogmtion_f,
				"cognition_name"=>$cogmtion_f
				);
				$insert=$this->db->insert("com_1_fall_risk",$data);
				if($insert== true){
				$response['status']=200;
				$response['body']="Added Successfully";
				}else{
				$response['status']=201;
				$response['body']="Failed to Add";	
				}
		}
		echo json_encode($response);
	}

public function getGlasGlowDataById()
{
	
	if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
	{
		$id=$this->input->post('id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$tableName="com_1_glass_glow";
		$resultObject=$this->db->query('select * from '.$tableName.' where id='.$id.' and branch_id='.$branch_id.' and company_id='.$company_id);
		if($this->db->affected_rows()>0)
		{
			$result=$resultObject->row();
			
			$edit_date_format=date('D d M Y H:i',strtotime($result->date));
			// print_r($result);exit();
			$response['status']=200;
			$response['body']=$result;
			$response['edit_date_format']=$edit_date_format;
		} else
		{
			$response['status']=201;
			$response['body']="Failed to get data";
		}
		
	}
	else{
		$response['status']=201;
		$response['body']="Something went wrong";
	}
	echo json_encode($response);
}


public function uploadSofaScore()
{
	// print_r($this->input->post());exit();
	$branch_id = $this->session->user_session->branch_id;
	$company_id = $this->session->user_session->company_id;
	$user_id = $this->session->user_session->id;

	$pa02=$this->input->post('pa02');
	$patlet_s=$this->input->post('patlet_s');
	$glass_glow_sofa=$this->input->post('glass_glow_sofa');
	$bilirubin_sofa=$this->input->post('bilirubin_sofa');
	$arterial_sofa=$this->input->post('arterial_sofa');
	$creatinine_sofa=$this->input->post('creatinine_sofa');
	$patient_id=$this->input->post('patient_id');
	$sofa_score=$pa02+$patlet_s+$glass_glow_sofa+$bilirubin_sofa+$arterial_sofa+$creatinine_sofa;

	$data = array('branch_id' => $branch_id,
				  'company_id'=>$company_id,
				  'patient_id'=>$patient_id,
				  'sofa_score'=>$sofa_score,
				  'date'=>date('Y-m-d'),
				  'created_on'=>date('Y-m-d H:i:s'),
				  'created_by'=>$user_id );

	$insert=$this->db->insert("com_1_sofa_score",$data);
		if($insert== true){
		$response['status']=200;
		$response['body']="Added Successfully";
		}else{
		$response['status']=201;
		$response['body']="Failed to Add";	
		}echo json_encode($response);

}
public function getSofaScroTable()
{
	$patient_id=$this->input->post('patient_id');
		
			$tableName = "com_1_sofa_score";
			$select = array("*");
			$where=array('patient_id'=>$patient_id);



		$order = array('id' => 'desc');
		$column_order = array('date');
		$column_search = array("date");

		$memData = $this->bed_model->getRows($_POST, $where, $select, $tableName, $column_search, $column_order, $order,null,$where);
		$query = $this->db->last_query();
		$filterCount = $this->bed_model->countFiltered($_POST, $tableName, $where, $column_search, $column_order, $order);
		$totalCount = $this->bed_model->countAll($tableName, $where);

		if (count($memData) > 0) {
			$tableRows = array();
			foreach ($memData as $row) {
				$date=date('D M d Y H:i a',strtotime($row->created_on));
				
				$tableRows[] = array(
					$row->sofa_score,
					$date,
					$row->id
				);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $tableRows,
			);
		} else {
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => $totalCount,
				"recordsFiltered" => $filterCount,
				"data" => $memData,
			);
		}
		$results["query"] = $query;
		echo json_encode($results);
}

public function getBardenScaleDataById()
{

	if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
	{
		$id=$this->input->post('id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$tableName="com_1_barden_scale";
		$resultObject=$this->db->query('select * from '.$tableName.' where id='.$id.' and branch_id='.$branch_id.' and company_id='.$company_id);
		if($this->db->affected_rows()>0)
		{
			$result=$resultObject->row();
			
			$edit_date_format=date('D d M Y H:i',strtotime($result->date));
			// print_r($result);exit();
			$response['status']=200;
			$response['body']=$result;
			$response['edit_date_format']=$edit_date_format;
		} else
		{
			$response['status']=201;
			$response['body']="Failed to get data";
		}
		
	}
	else{
		$response['status']=201;
		$response['body']="Something went wrong";
	}
	echo json_encode($response);
}

public function getFallRiskDataById()
{
	if(!is_null($this->input->post('id')) && $this->input->post('id')!="")
	{
		$id=$this->input->post('id');
		$branch_id = $this->session->user_session->branch_id;
		$company_id = $this->session->user_session->company_id;
		$tableName="com_1_fall_risk";
		$resultObject=$this->db->query('select * from '.$tableName.' where id='.$id.' and branch_id='.$branch_id.' and company_id='.$company_id);
		if($this->db->affected_rows()>0)
		{
			$result=$resultObject->row();
			
			$edit_date_format=date('D d M Y H:i',strtotime($result->date));
			// print_r($result);exit();
			$response['status']=200;
			$response['body']=$result;
			$response['edit_date_format']=$edit_date_format;
		} else
		{
			$response['status']=201;
			$response['body']="Failed to get data";
		}
		
	}
	else{
		$response['status']=201;
		$response['body']="Something went wrong";
	}
	echo json_encode($response);
}
	
	public function getDataTimeUnder()
	{
		if(!is_null($this->input->post('patient_id')) && $this->input->post('patient_id')!="")
		{
			$patient_id=$this->input->post('patient_id');
			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;
			$tableName="com_1_critical_care";
			$resultObject=$this->db->query('select * from '.$tableName.' where  patient_id='.$patient_id.' and branch_id='.$branch_id.' and date(created_on) = CURDATE() order by id desc');
			
			if($this->db->affected_rows()>0)
			{
				$result=$resultObject->row();
				
				// $edit_date_format=date('D d M Y H:i',strtotime($result->date));
				$edit_date=date('d-m-y',strtotime($result->created_on));
				$date = date('d-m-y');

				if($edit_date==$date)
				{
					$edit_date_time=date('H:i',strtotime($result->created_on));
					$date_time = date('H:i');
					$mins=(strtotime($date_time)-strtotime($edit_date_time))/60;
					if($mins < 45)
					{
						$response['id']=$result->id;
					}
					else{
						$response['id']="";
					}

				}
				else
				{
					$response['id']="";
				}
				// print_r($result);exit();
				$response['status']=200;
				$response['body']=$result;
				
			} else
			{
				$response['status']=201;
				$response['body']="Failed to get data";
			}
		
		}
		else{
			$response['status']=201;
			$response['body']="Something went wrong";
		}
	echo json_encode($response);
	}

	public function getDownloadDietReportData()
	{
		$patient_id = $this->input->post('patient_id');
		$tableName="com_1_critical_care";
		$patient_table = $this->session->user_session->patient_table;
		$hospital_bed_table = $this->session->user_session->hospital_bed_table;
		$chkcount=1;
		$resultObject=$this->IcuCareModel->getDietReportData($tableName,$patient_table,$hospital_bed_table,$patient_id,$chkcount);
		// print_r($resultObject);exit();
		if(count($resultObject)>0)
		{
			$response['status']=200;
		}
		else
		{
			$response['status']=201;
		}
		echo json_encode($response);
	}

	public function getDownloadDietReport()
	{
			$data=$this->input->post_get('data');
		
			$object = json_decode($data);
			$category = "RADIOLOGY";
			$patient_id = $object->patient_id;
			$tableName="com_1_critical_care";
			$patient_table = $this->session->user_session->patient_table;
			$hospital_bed_table = $this->session->user_session->hospital_bed_table;
			$chkcount=0;
			$resultObject=$this->IcuCareModel->getDietReportData($tableName,$patient_table,$hospital_bed_table,$patient_id,$chkcount);
			// print_r($resultObject);exit();
			if (count($resultObject) > 0) {
				$this->createExcel($resultObject, 0);
			}
			else
			{
				echo json_encode(array("body"=>"No data found","status"=>200));
			}

	}

	public function createExcel($data,$type)
	{
		$this->load->library('excel');
		//$listInfo = $this->export->exportList();
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->setTitle("Diet Report");
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sr No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Date and Time');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Patient Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bed No');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Meal Type');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Diet Type');
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Remarks');
		$rowCount = 2;
		$k = 1;
		
		foreach ($data as $row) {
				$serviceIDArray=array();
					$patient_info = explode('|||', $row->patient_info);
					$patient_name = "";
					$bed_name = "";
					$room_id = "";
					if (count($patient_info) > 1) {
						$patient_name = $patient_info[0];
						$bed_name = $patient_info[1];
						$room_id = $patient_info[2];
					}
					if ($row->created_on != null && $row->created_on != "0000-00-00 00:00:00") {
						$date = date("Y-m-d h:i:sa", strtotime($row->created_on));
					} else {
						$date = "-";
					}
					
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $k);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $date);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $patient_name);
			
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $bed_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->Quantity);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->TypeOfMeal);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->Remarks);

				$rowCount++;
				$k++;
			}
		// print_r($objPHPExcel);exit();
		ob_end_clean();
		$filename = "Diet_Report_" . date("Y-m-d") . "" . time() . ".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');

	}
}

