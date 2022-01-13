<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');

?>
<style>
/*.vital_td2 ,.op1,.vent1,.ot1,.il1,.rass,.nursecare,.diabetic,.intake,.op2,.dc1,.drugInfusion1,.bolus1,.ivFluids1{
	display:none;

}*/
.eyeopen, .bvrtgl, .bmrtgl, .pupilreaction, .motorpwr{
	display:none;
	
}
.sensory_p,.moisture_m,.activity_a,.mobility_m,.nutrition_n,.friction_share_s
{
	display:none;
}
.age_a,.fall_history_h,.elimination_f,.medications_f,.equipment_f,.mobility_f,.cogmtion_f
{
	display: none;
}
input[type="number"]{
	width: 100% !important;
	/*height: 13px;*/
    border: none;
    border-bottom: 1px solid lightgray;
    font-size: 12px;
}
input[type="text"]{
	width: 100% !important;
	/*height: 13px;*/
    border: none;
    border-bottom: 1px solid lightgray;
    font-size: 12px;
}
input[type="radio"]{
	
	/*height: 13px;*/
    border: none;
    border-bottom: 1px solid lightgray;
    font-size: 9px !important;
}
input[type="textarea"]{
	width: 60% !important;
	/*height: 13px;*/
    border: none;
    border-bottom: 1px solid lightgray;
    font-size: 12px;
}
select{
	width: 100% !important;
	/*height: 13px;*/
    border: none;
    border-bottom: 1px solid lightgray;
    font-size: 12px;
}
td label{
	font-size: 11px;
}
.sign_p
{
	padding-left: 55px;
}
.bg_color
{
	background-color:#8916353b;
	cursor: pointer;
	color: black;
}
td
{
	font-size: 10px;
	color: black;
	/*line-height: 0px;*/
}
td label
{
	font-size: 10px;
	color: black;
}
td i{
	border: 1px solid #bbb8b9;
    padding: 2px;
    box-shadow: 1px 1px 3px 0px #888888;
}
.mainsign_p
{
	/*padding-left: 20px;*/
}

.tableFixHead
{
	/*width: 100%;*/
	height: 450px;
	overflow: auto;
}
.table_header
{
	position: sticky;
}
   .tableFixHead  td {
      /*padding: 3px 7px 3px 0px;*/
      /*width: 200px;*/
    }
   

.nowtr, td{
//	width:10px;
}
.nowtr, input[type="text"]{
//	width: 50% !important;
}
#new_table td{
	width:150px;
}
.date_css
{
	padding-right: 10px;
	color: black;
	/*border-bottom: 1px solid black;*/
}
.tab-content > .tab-pane
{
	line-height: 1.5;
}


.list_select_o
{
	display: inline;
	 font-size: 11px; 
}
.list_select_v
{
	float: right;
    display: block;
    padding-left: 8px;
     font-size: 11px; 
    opacity: .7;
}
.td_input
{
	background: #e4c9d0;
}
.modal_header
	{
		background: #891635;
		color: white;
	}
	.modal_close
	{
		color: white;
	}
	@media (min-width: 768px) {
	  .modal-xl {
	    width: 90%;
	   max-width:1200px;
	  }
	}
	
</style>
<div class="main-content main-content1">
	<section class="section">


		

			<div class="">
				<div class="section-header card-primary" style="border-top: 2px solid #891635">
					<h1>Critical Care Flowsheet</h1>
				</div>
				<div class="section-body" >
					<div class="card">
						
						<div class="card-header-action">
						<ul class="nav nav-pills" id="medicineTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1"
								role="tab"  aria-controls="tab1" aria-selected="true">Critical Care flowsheet </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="gcs-tab" data-toggle="tab" href="#tab2"
								role="tab"  aria-controls="tab2" onclick="getGcsData();" aria-selected="true">Glasgow Coma Scale </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="braden-tab" data-toggle="tab" href="#tab3"
								role="tab"  aria-controls="tab3" onclick="getBradenScaleData();" aria-selected="true">Braden Scale </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="braden-tab" data-toggle="tab" href="#tab4"
								role="tab"  aria-controls="tab4" onclick="getFallRiskAsseData();" aria-selected="true">Fall Risk Assesment </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="sofa-tab" data-toggle="tab" href="#tab5"
								role="tab"  aria-controls="tab5" onclick="getSofaScroTable();" aria-selected="true">Sofa Score </a>
							</li>
							<!-- <div id="button_data" class="ml-2" style="margin-top: -5px;"> -->
							<li class="nav-item">
								<a class="nav-link" id="icu-rehab-tab" data-toggle="tab" href="#tab6"
								role="tab"  aria-controls="tab6" onclick="getRehabModal(18,40,'tab6')" aria-selected="true">ICU rehab </a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="icu-rehab-asse-tab" data-toggle="tab" href="#tab7"
								role="tab"  aria-controls="tab7" onclick="getRehabModal(18,41,'tab7')" aria-selected="true">ICU rehab assessment form </a>
							</li>
							<!-- </div> -->
						</ul>
						</div>
						<div class="card-body">

							


						<div class="tab-content">
						<div class="tab-pane fade show active" role="tabpanel" id="tab1">
<input type="hidden" name="hidden_date" id="hidden_date" value="<?php echo date('Y-m-d') ?>">
							
							
							<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">

			                  <button class="btn btn-primary btn-sm" onclick="get_datewise_data(1)"><i class="fa fa-arrow-left"></i> prev</button>
			                  <button class="btn btn-primary btn-sm" onclick="load_all_items()"><i class="fa fa-arrows-alt"></i></button>
			                  <div class="card-header-action" style="margin-left: auto;">
			                    <div class="btn-group">
			                    	<span class="date_css" id="date_format_readonly"></span>
			                     <button class="btn btn-primary btn-sm" onclick="get_datewise_data(2)">next <i class="fa fa-arrow-right"></i></button>
									
			                    </div>
			                  </div>
			                </div>
						<form id="icuCriticalCareForm" onsubmit="return false">
							<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">
							 <div class="card-header-action" style="margin-left: auto;">
								<button type="button" class="btn btn-primary" onclick="uploadIcuCriticalCareForm()">Save</button>
								<button type="button" class="btn btn-secondary" onclick="getData()">Reset</button>
								<button type="button" id="dietReportBtn" class="btn btn-primary" onclick="getDownloadDietReport()"><i class="fa fa-download"></i> Diet Report</button>
							</div>
							</div>
							<div id="section_body" class="tableFixHead">
				
           					</div>

						</form>
							</div>
							
							<div class="tab-pane fade " role="tabpanel" id="tab2">
							<input type="hidden" readonly id="d12" name="date_idtab2" value="<?php echo date('Y-m-d') ?>">

							<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">

			                  <button class="btn btn-primary btn-sm" onclick="get_datewiseData(1)"><i class="fa fa-arrow-left"></i> prev</button>
			                  <button class="btn btn-primary btn-sm" onclick="load_all_coma_scale()"><i class="fa fa-arrows-alt"></i></button>
			                  <div class="card-header-action" style="margin-left: auto;">
			                    <div class="btn-group">
			                    	<span class="date_css" id="date_format_coma_scale"></span>
			                     <button class="btn btn-primary btn-sm" onclick="get_datewiseData(2)">next <i class="fa fa-arrow-right"></i></button>
									
			                    </div>
			                  </div>
			                </div>

							<form id="glosgowform" onsubmit="return false">
								<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">
							 <div class="card-header-action" style="margin-left: auto;">
							 	<button type="button" class="btn btn-primary" onclick="uploadGlassglowForm()">Save</button>
							 	<button type="button" class="btn btn-secondary" onclick="getGcsData()">Reset</button>
							 </div>
							</div>
							<div id="div_gcs" class="tableFixHead">
							
							</div>
							
							</form>
							</div>
							<div class="tab-pane fade " role="tabpanel" id="tab3">
								<input type="hidden" readonly id="d13" name="date_idtab3" value="<?php echo date('Y-m-d') ?>">

									<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">

					                  <button class="btn btn-primary btn-sm" onclick="get_datewiseBrandenData(1)"><i class="fa fa-arrow-left"></i> prev</button>
					                  <button class="btn btn-primary btn-sm" onclick="load_all_barden_scale()"><i class="fa fa-arrows-alt"></i></button>
					                  <div class="card-header-action" style="margin-left: auto;">
					                    <div class="btn-group">
					                    	<span class="date_css" id="date_format_barden_scale"></span>
					                     <button class="btn btn-primary btn-sm" onclick="get_datewiseBrandenData(2)">next <i class="fa fa-arrow-right"></i></button>
											
					                    </div>
					                  </div>
					                </div>

									<form id="bradenScaleform" onsubmit="return false">
										<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">
										 <div class="card-header-action" style="margin-left: auto;">
										 	<button type="button" class="btn btn-primary" onclick="uploadBradenScaleForm()">Save</button>
										 	<button type="button" class="btn btn-secondary" onclick="getBradenScaleData()">Reset</button>
										 </div></div>
									<div id="div_braden" class="tableFixHead">
									
									</div>
									
									</form>
							</div>
							<div class="tab-pane fade " role="tabpanel" id="tab4">
								<input type="hidden" readonly id="d14" name="date_idtab4" value="<?php echo date('Y-m-d') ?>">

									<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">

					                  <button class="btn btn-primary btn-sm" onclick="get_datewiseFallRiskData(1)"><i class="fa fa-arrow-left"></i> prev</button>
					                  <button class="btn btn-primary btn-sm" onclick="load_all_Fall_risk()"><i class="fa fa-arrows-alt"></i></button>
					                  <div class="card-header-action" style="margin-left: auto;">
					                    <div class="btn-group">
					                    	<span class="date_css" id="date_format_fall_risk"></span>
					                     <button class="btn btn-primary btn-sm" onclick="get_datewiseFallRiskData(2)">next <i class="fa fa-arrow-right"></i></button>
											
					                    </div>
					                  </div>
					                </div>

									<form id="FallRiskAsseform" onsubmit="return false">
										<div class="card-header" style="padding: 0px;border: none;min-height: 0px;padding-bottom: 5px;">
										 <div class="card-header-action" style="margin-left: auto;">
										 	<button type="button" class="btn btn-primary" onclick="uploadFallRiskForm()">Save</button>
										 	<button type="button" class="btn btn-secondary" onclick="getFallRiskAsseData()">Reset</button>
										 </div>
										</div>
									<div id="div_fallrisk" class="tableFixHead">
									
									</div>
									
									</form>
							</div>

							<div class="tab-pane fade " role="tabpanel" id="tab5">
								<div class="row">
									<div class="col-md-6">
										<form id="sofaScoreform" onsubmit="return false">
											<div class="row">
												<input type="hidden" name="pa02" id="pa02" value="0">
												<div class="col-md-4">
													<label>PaO2/FiO2*, mmHg</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab1" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op1" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('pa02',0)"><div class="list_select_o"> >=400</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('pa02',1)"><div class="list_select_o"> 300-399</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('pa02',2)"><div class="list_select_o"> 200-299</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('pa02',2)"><div class="list_select_o"> ≤199 and NOT mechanically ventilated </div><span class="list_select_v">+2</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('pa02',3)"><div class="list_select_o"> 100-199 and mechanically ventilated </div><span class="list_select_v">+3</span></a>
								                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('pa02',4)"><div class="list_select_o"> <100 and mechanically ventilated </div><span class="list_select_v">+4</span></a>
								                        </div>
								                      
												</div>
											</div>
											<br/>
											<div class="row">
												<input type="hidden" name="patlet_s" id="patlet_s" value="0">
												<div class="col-md-4">
													<label>Platelets, ×103/µL</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab2" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op2" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('patlet_s',0)"><div class="list_select_o"> ≥150</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('patlet_s',1)"><div class="list_select_o"> 100-149</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('patlet_s',2)"><div class="list_select_o"> 50-99</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('patlet_s',3)"><div class="list_select_o"> 20-49 </div><span class="list_select_v">+3</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('patlet_s',3)"><div class="list_select_o"> <20 </div><span class="list_select_v">+4</span></a>
								                           
								                        </div>
								                      
												</div>
											</div>
											<br/>
											<div class="row">
												<input type="hidden" name="glass_glow_sofa" id="glass_glow_sofa" value="0">
												<div class="col-md-4">
													<label>Glasgow Coma Scale</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab3" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op3" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('glass_glow_sofa',0)"><div class="list_select_o"> 15</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('glass_glow_sofa',1)"><div class="list_select_o"> 13-14</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('glass_glow_sofa',2)"><div class="list_select_o"> 10-12</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('patlet_s',3)"><div class="list_select_o"> 6-9 </div><span class="list_select_v">+3</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('glass_glow_sofa',3)"><div class="list_select_o"> <6 </div><span class="list_select_v">+4</span></a>
								                           
								                        </div>
								                      
												</div>
											</div>
											<br/>
											<div class="row">
												<input type="hidden" name="bilirubin_sofa" id="bilirubin_sofa" value="0">
												<div class="col-md-4">
													<label>Bilirubin, mg/dL (μmol/L)</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab4" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op4" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('bilirubin_sofa',0)"><div class="list_select_o"> <1.2 (<20)</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('bilirubin_sofa',1)"><div class="list_select_o"> 1.2–1.9 (20-32)</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('bilirubin_sofa',2)"><div class="list_select_o"> 2.0–5.9 (33-101)</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('bilirubin_sofa',3)"><div class="list_select_o"> 6.0–11.9 (102-204) </div><span class="list_select_v">+3</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('bilirubin_sofa',3)"><div class="list_select_o"> ≥12.0 (>204)</div><span class="list_select_v">+4</span></a>
								                           
								                        </div>
								                      
												</div>
											</div>
												<br/>
											<div class="row">
												<input type="hidden" name="arterial_sofa" id="arterial_sofa" value="0">
												<div class="col-md-4">
													<label>Mean arterial pressure OR administration of vasoactive agents required (listed doses are in units of mcg/kg/min)</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab5" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op5" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('arterial_sofa',0)"><div class="list_select_o"> No hypotension</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('arterial_sofa',1)"><div class="list_select_o"> MAP <70 mmHg</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('arterial_sofa',2)"><div class="list_select_o"> DOPamine ≤5 or DOBUTamine (any dose)</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('arterial_sofa',3)"><div class="list_select_o"> DOPamine >5, EPINEPHrine ≤0.1, or norEPINEPHrine ≤0.1 </div><span class="list_select_v">+3</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('arterial_sofa',3)"><div class="list_select_o"> DOPamine >15, EPINEPHrine >0.1, or norEPINEPHrine >0.1</div><span class="list_select_v">+4</span></a>
								                           
								                        </div>
								                      
												</div>
											</div>
												<br/>
											<div class="row">
												<input type="hidden" name="creatinine_sofa" id="creatinine_sofa" value="0">
												<div class="col-md-4">
													<label>Creatinine, mg/dL (μmol/L) (or urine output)</label>
												</div>
												<div class="col-md-8">
													
								                        <div class="list-group" id="list-tab6" role="tablist">
								                          <a class="list-group-item list-group-item-action active show" id="first_op6" data-toggle="list" href="#list-home" role="tab" aria-selected="true" onclick="get_textbox_value('creatinine_sofa',0)"><div class="list_select_o"> <1.2 (<110)</div><span class="list_select_v">0</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-profile" role="tab" aria-selected="false" onclick="get_textbox_value('creatinine_sofa',1)"><div class="list_select_o"> 1.2–1.9 (110-170)</div><span class="list_select_v">+1</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-messages" role="tab" aria-selected="false" onclick="get_textbox_value('creatinine_sofa',2)"><div class="list_select_o"> 2.0–3.4 (171-299)</div><span class="list_select_v">+2</span></a>
								                          <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('creatinine_sofa',3)"><div class="list_select_o"> 3.5–4.9 (300-440) or UOP <500 mL/day) </div><span class="list_select_v">+3</span></a>
								                           <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab" aria-selected="false" onclick="get_textbox_value('creatinine_sofa',3)"><div class="list_select_o"> ≥5.0 (>440) or UOP <200 mL/day</div><span class="list_select_v">+4</span></a>
								                           
								                        </div>
								                      
												</div>
											</div>
											<br/>
											<div class="row">
												<button type="button" class="btn btn-primary" style="margin-left: auto;" onclick="uploadSofaScore()">Save</button>
											</div>

									
										</form>
									</div>
									<div class="col-md-6">
										<table class="table table-bordered table-stripped" id="sofaScoreTable" style="width: 100%">
											<thead style="background-color: #e4c9d0;">
												<th>SOFA Score</th>
												<th>Date</th>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
								
							</div>
							<div class="tab-pane fade " role="tabpanel" id="tab6">
							</div>
							<div class="tab-pane fade " role="tabpanel" id="tab7">
							</div>

						</div>
					</div>
				
				</div>
			</div>
			</div>
		
	</section>
	
</div>

<?php $this->load->view('admin/templates/history_form'); ?>
<?php $this->load->view('_partials/footer'); ?>
<!-- <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script> -->
<script>


</script>
