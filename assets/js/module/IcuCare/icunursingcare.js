$( document ).ready(function() {
	
	// getRehabModal(localStorage.getItem("patient_id"),18,41);
   getData(localStorage.getItem("patient_id"));

   $('#vital_td').on('click',function(){	
		
	});
   getDataTimeUnder(localStorage.getItem("patient_id"));

   $('#editHistoryModal').on('show.bs.modal', function (e) {
			let section_id = parseInt($(e.relatedTarget).data('section_id'));
			let history_id = parseInt($(e.relatedTarget).data('history_id'));
			let department_id = parseInt($(e.relatedTarget).data('department_id'));
			let patient_id = localStorage.getItem("patient_id");
			// get_forms(localStorage.getItem("patient_id"));
			get_forms_history(section_id, history_id, patient_id, department_id);
		});

});

function load(id){
	$('.'+id).toggle();
}

function getDataTimeUnder(patient_id)
{
	var patient_id=localStorage.getItem("patient_id");
	
	let formData = new FormData();
	// console.log(date_id);	
	formData.set("patient_id", patient_id);
	app.request(baseURL + "getDataTimeUnder", formData).then(response => {
	
				// success = JSON.parse(success);
				if (response.status == 200) {
					
					if(response.id!=null && response.id!="")
					{
						changesSigns(response.id);
					}
					


				} else {
					
				}
			
	})
}

function getData(patient_id=null,date_id=null,date_filter=null)
{
	
	// console.log(date_id);
	var date_filter1;
	if(date_filter==null)
	{
		
		date_filter1=$("#hidden_date").val();
	}
	else
	{
		date_filter1=date_filter;
		
	}
	var id=date_id;
	var patient_id=localStorage.getItem("patient_id");
	
	let formData = new FormData();
	// console.log(date_id);
	formData.set("date_id", date_id);
	formData.set("patient_id", patient_id);
	formData.set("date_filter", date_filter1);
	app.request(baseURL + "getData", formData).then(response => {
	
				// success = JSON.parse(success);
				if (response.status == 200) {
					$("#section_body").html(response.data);

					$("#hidden_date").val(response.date_filter);
					$("#date_format_readonly").html(response.date_format);
					if(date_filter!=null)
					{
						// load_all_items();
					}
					getDataTimeUnder(localStorage.getItem("patient_id"));


				} else {
					$("#section_body").html("");
					$("#hidden_date").val(response.date_filter);
					$("#date_format_readonly").html(response.date_format);
				}
			
	})
}
function uploadIcuCriticalCareForm()
{
	var patient_id=localStorage.getItem("patient_id");
	let form = document.getElementById("icuCriticalCareForm");
	var date_filter=$("#hidden_date").val();
	
	let formData = new FormData(form);
	
	formData.append("patient_id", patient_id);
	var date_id=null;
	$.ajax({
			url: baseURL + "uploadIcuCriticalCareForm",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (success) {
				// success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					// hidden_id
					$("#hidden_id").val('');
					$("#hidden_date").val(date_filter);
					 getData(localStorage.getItem("patient_id"),date_id,date_filter);
					 // load_all_items();
					 getDataTimeUnder(patient_id);

				} else {
					app.errorToast(success.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}


function get_datewise_data(id)
{
	 getData(localStorage.getItem("patient_id"),id);
}

function load_all_items(){
	
	$('.vital_td2').toggle();
	$('.vent1').toggle();
	$('.op1').toggle();
	$('.ot1').toggle();
	$('.il1').toggle();
	$('.rass').toggle();
	$('.nursecare').toggle();
	$('.diabetic').toggle();
	$('.intake').toggle();
	$('.op2').toggle();
	$('.dc1').toggle();
	$('.drugInfusion1').toggle();
	$('.bolus1').toggle();
	$('.ivFluids1').toggle();

}

function checkDrugValue(textId,ValueId,errorText)
{
	var text=$("#"+textId).val();
	if(text=="")
	{
		$("#"+ValueId).val('');
		app.errorToast(errorText);
	}
}

function getRassScaleScore(id,score)
{
	$("#"+id).val(score);
}
function changesSigns(id)
{
	let formData = new FormData();
	// console.log(id);
	formData.set("id", id);

	app.request(baseURL + "getIcuCareDataById", formData).then(response => {
	
	if (response.status == 200) {
		var userdata=response.body;
					// load_all_items();
					$("#hidden_id").val(userdata.id);

					$("#flowsheet_edit_date").html(response.edit_date_format);
					//vitals
					$("#temp").val(userdata.temperature);
					$("#bps").val(userdata.BP);
					$("#bpd").val(userdata.BPDiastolic);
					$("#hr").val(userdata.HR);
					$("#rr").val(userdata.RR);
					// $("#rhythm").val(userdata.RHYTHM);
					if(userdata.RHYTHM!="" && userdata.RHYTHM!=null)
					{
						
						$('#rhythm option[value="'+userdata.RHYTHM+'"]').attr('selected','selected');
					}
					else
					{

						$('#rhythm').val("");
					}
					$("#spo2").val(userdata.SPO2);
					$("#etco2").val(userdata.ETCO2);
					$("#ipap").val(userdata.BIPAP);
					$("#epap").val(userdata.EPAP);
					
					//ventilator
					// $("#mode").val(userdata.Mode);
					 // $("#mode").append('<option value=' + userdata.Mode + '>' + userdata.Mode + '</option>');
					if(userdata.Mode!="" && userdata.Mode!=null)
					{
						$('#mode option[value="'+userdata.Mode+'"]').attr('selected','selected');
					}
					else
					{
						$('#mode').val("");
					}
					
					$("#fto2").val(userdata.Flo2);
					$("#pee").val(userdata.PEE);
					$("#ppeak").val(userdata.PPEAK);
					$("#rate").val(userdata.RATE);
					$("#tidal").val(userdata.Tidal_Volume);
					$("#pressure").val(userdata.Pressure_Support);
					

					//Drug infusion
					
						if(userdata.DRUG_Infusion1 != "" && userdata.DRUG_Infusion1!=null)
						{
							var drugdata1=userdata.DRUG_Infusion1;
							var drug1 = drugdata1.split(":");
							$("#drug_Infusion1").val(drug1[0]);
							$("#drug_Infusion_value1").val(drug1[1]);
						}
						if(userdata.DRUG_Infusion2 != "" && userdata.DRUG_Infusion2!=null)
						{
							var drugdata2=userdata.DRUG_Infusion2;
							var drug2 = drugdata2.split(":");
							$("#drug_Infusion2").val(drug2[0]);
							$("#drug_Infusion_value2").val(drug2[1]);
						}
						if(userdata.DRUG_Infusion3 != "" && userdata.DRUG_Infusion3!=null)
						{
							var drugdata3=userdata.DRUG_Infusion3;
							var drug3 = drugdata3.split(":");
							$("#drug_Infusion3").val(drug3[0]);
							$("#drug_Infusion_value3").val(drug3[1]);
						}
						if(userdata.DRUG_Infusion4 != "" && userdata.DRUG_Infusion4!=null)
						{
							var drugdata4=userdata.DRUG_Infusion4;
							var drug4 = drugdata4.split(":");
							$("#drug_Infusion4").val(drug4[0]);
							$("#drug_Infusion_value4").val(drug4[1]);
						}
						if(userdata.DRUG_Infusion5 != "" && userdata.DRUG_Infusion5!=null)
						{
							var drugdata5=userdata.DRUG_Infusion5;
							var drug5 = drugdata5.split(":");
							$("#drug_Infusion5").val(drug5[0]);
							$("#drug_Infusion_value5").val(drug5[1]);
						}
						

						// bolus
						
						if(userdata.BOLUS1 != "" && userdata.BOLUS1!=null)
						{
							var bolusdata1=userdata.BOLUS1;
							var bolus1 = bolusdata1.split(":");
							$("#bolusName1").val(bolus1[0]);
							$("#bolus1").val(bolus1[1]);
						}

						if(userdata.BOLUS2 != "" && userdata.BOLUS2!=null)
						{
							var bolusdata2=userdata.BOLUS2;
							var bolus2 = bolusdata2.split(":");
							$("#bolusName2").val(bolus2[0]);
							$("#bolus2").val(bolus2[1]);
						}

						if(userdata.BOLUS3 != "" && userdata.BOLUS3!=null)
						{
							var bolusdata3=userdata.BOLUS3;
							var bolus3 = bolusdata3.split(":");
							$("#bolusName3").val(bolus3[0]);
							$("#bolus3").val(bolus3[1]);
						}

						if(userdata.BOLUS4 != "" && userdata.BOLUS4!=null)
						{
							var bolusdata4=userdata.BOLUS4;
							var bolus4 = bolusdata4.split(":");
							$("#bolusName4").val(bolus4[0]);
							$("#bolus4").val(bolus4[1]);
						}

						if(userdata.BOLUS5 != "" && userdata.BOLUS5!=null)
						{
							var bolusdata5=userdata.BOLUS5;
							var bolus5 = bolusdata5.split(":");
							$("#bolusName5").val(bolus5[0]);
							$("#bolus5").val(bolus5[1]);
						}
						

						// ivFluids
						
						if(userdata.IV_Fluids1 != "" && userdata.IV_Fluids1!=null)
						{
							var ivfluiddata1=userdata.IV_Fluids1;
							var ivfluid1 = ivfluiddata1.split(":");
							$("#ivfluidName1").val(ivfluid1[0]);
							$("#ivFluids1").val(ivfluid1[1]);
						}
						if(userdata.IV_Fluids2 != "" && userdata.IV_Fluids2!=null)
						{
							var ivfluiddata2=userdata.IV_Fluids2;
							var ivfluid2 = ivfluiddata2.split(":");
							$("#ivfluidName2").val(ivfluid2[0]);
							$("#ivFluids2").val(ivfluid2[1]);
						}
						if(userdata.IV_Fluids3 != "" && userdata.IV_Fluids3!=null)
						{
							var ivfluiddata3=userdata.IV_Fluids3;
							var ivfluid3 = ivfluiddata3.split(":");
							$("#ivfluidName3").val(ivfluid3[0]);
							$("#ivFluids3").val(ivfluid3[1]);
						}
						if(userdata.IV_Fluids4 != "" && userdata.IV_Fluids4!=null)
						{
							var ivfluiddata4=userdata.IV_Fluids4;
							var ivfluid4 = ivfluiddata4.split(":");
							$("#ivfluidName4").val(ivfluid4[0]);
							$("#ivFluids4").val(ivfluid4[1]);
						}
						if(userdata.IV_Fluids5 != "" && userdata.IV_Fluids5!=null)
						{
							var ivfluiddata5=userdata.IV_Fluids5;
							var ivfluid5 = ivfluiddata5.split(":");
							$("#ivfluidName5").val(ivfluid5[0]);
							$("#ivFluids5").val(ivfluid5[1]);
						}
						
						
						// output1
						$("#ng").val(userdata.hourly_N_G_Vomitus);
						$("#hurin").val(userdata.Hourly_Urine);
						$("#dr1").val(userdata.DrainI);
						$("#dr2").val(userdata.DrainII);
						$("#dr3").val(userdata.DrainIII);
						$("#dr4").val(userdata.DrainIV);
						$("#hrdrain").val(userdata.Hourly_Drainage);
						
						//others
						$("#iabp").val(userdata.IABP_ratio);
						$("#abdominal").val(userdata.Abdominal_Girth);
						// $("#ppr").val(userdata.Pedal_Pulse_R);
						$("#ppl").val(userdata.Pedal_Pulse_L);
						if(userdata.Pedal_Pulse_L != "" && userdata.Pedal_Pulse_L!=null)
						{
							var pulsepedaldata1=userdata.Pedal_Pulse_L;
							var pulse1 = pulsepedaldata1.split(":");
							// $("#pulseField").val(pulse1[0]);
							if(pulse1.length > 1)
							{
								if(pulse1[0]!="" && pulse1[0]!=null)
								{
									$('#pulseField option[value="'+pulse1[0]+'"]').attr('selected','selected');
								}
							// $("#pulseField").append('<option value=' + pulse1[0] + '>' + pulse1[0] + '</option>');
					
								$("#ppl").val(pulse1[1]);
							}
							
						}
						else
						{
							$('#pulseField').val("");
						}

						// $("#bowlop").val(userdata.Bowel_Opened);
						if(userdata.Bowel_Opened!="" && userdata.Bowel_Opened!=null)
						{
							var radiobtn;
							if(userdata.Bowel_Opened=="yes")
							{
								radiobtn = document.getElementById("bowlopyes");
								radiobtn.checked = true;
							}
							else if(userdata.Bowel_Opened=="no")
							{
								radiobtn = document.getElementById("bowlopno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".bowlop").prop('checked', false);
							}
						}
						else 
							{
								$(".bowlop").prop('checked', false);
							}

						//invasive lines
						$("#centralline").val(userdata.Central_Line);
						$("#atriallines").val(userdata.Atrial_Lines);
						$("#hdCatheter").val(userdata.HD_Catheter);
						$("#periline").val(userdata.Peripheral_Line);
						$("#drains").val(userdata.Drains);
						$("#urincatheter").val(userdata.Urinary_Catheter);
						$("#endoTube").val(userdata.Endotracheal_Tube);
						$("#iabpCatheter").val(userdata.IABP_catheter);
						$("#tracheTube").val(userdata.Tracheostomy_tube);
						$("#rylesTube").val(userdata.Ryles_tube);

						// rass
						if(userdata.Parameter_1!="" && userdata.Parameter_1!=null)
						{
							var radiobtn;
							if(userdata.Parameter_1=="Combative")
							{
								radiobtn = document.getElementById("Combative");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Very Agitated")
							{
								radiobtn = document.getElementById("v_agitated");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Agitated")
							{
								radiobtn = document.getElementById("agitated");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Restless")
							{
								radiobtn = document.getElementById("restless");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Alert & Calm")
							{
								radiobtn = document.getElementById("alertcalm");
								radiobtn.checked = true;
							}else
							if(userdata.Parameter_1=="Drowsy")
							{
								radiobtn = document.getElementById("drowsy");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Light Sedation")
							{
								radiobtn = document.getElementById("lightsedation");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Moderate Sedation")
							{
								radiobtn = document.getElementById("msedation");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Deep Sedation")
							{
								radiobtn = document.getElementById("deepsedation");
								radiobtn.checked = true;
							}else 
							if(userdata.Parameter_1=="Unarousable Sedation")
							{
								radiobtn = document.getElementById("usedation");
								radiobtn.checked = true;
							}
							else 
							{
								$(".para1").prop('checked', false);
							}
						}
						else 
							{
								$(".para1").prop('checked', false);
							}

							$("#rass").val(userdata.RASS);

						// if(userdata.Parameter_2!="" && userdata.Parameter_2!=null)
						// {
						// 	var radiobtn;
							
						// 	else 
						// 	{
						// 		$(".para2").prop('checked', false);
						// 	}
						// }
						// else 
						// 	{
						// 		$(".para2").prop('checked', false);
						// 	}

						// nursing care
						if(userdata.Back_Care!="" && userdata.Back_Care!=null)
						{	var radiobtn;
							if(userdata.Back_Care=="yes")
							{
								radiobtn = document.getElementById("backcareyes");
								radiobtn.checked = true;
							}
							else if(userdata.Back_Care=="no")
							{
								radiobtn = document.getElementById("backcareno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".backcare").prop('checked', false);
							}
						}
						else 
							{
								$(".backcare").prop('checked', false);
							}

						if(userdata.Mouth_care!="" && userdata.Mouth_care!=null)
						{
							var radiobtn;
							if(userdata.Mouth_care=="yes")
							{
								radiobtn = document.getElementById("mcareyes");
								radiobtn.checked = true;
							}
							else if(userdata.Mouth_care=="no")
							{
								radiobtn = document.getElementById("mcareno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".mcare").prop('checked', false);
							}
						}
						else 
							{
								$(".mcare").prop('checked', false);
							}

						if(userdata.Eye_care!="" && userdata.Eye_care!=null)
						{
							var radiobtn;
							if(userdata.Eye_care=="yes")
							{
								radiobtn = document.getElementById("eyecareyes");
								radiobtn.checked = true;
							}
							else if(userdata.Eye_care=="no")
							{
								radiobtn = document.getElementById("eyecareno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".eyecare").prop('checked', false);
							}
						}
						else 
							{
								$(".eyecare").prop('checked', false);
							}

						if(userdata.Chest_P_T!="" && userdata.Chest_P_T!=null)
						{
							var radiobtn;
							if(userdata.Chest_P_T=="yes")
							{
								radiobtn = document.getElementById("chestptyes");
								radiobtn.checked = true;
							}
							else if(userdata.Chest_P_T=="no")
							{
								radiobtn = document.getElementById("chestptno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".chestpt").prop('checked', false);
							}
						}
						else 
							{
								$(".chestpt").prop('checked', false);
							}
						if(userdata.Limb_P_T!="" && userdata.Limb_P_T!=null)
						{
							var radiobtn;
							if(userdata.Limb_P_T=="yes")
							{
								radiobtn = document.getElementById("limbptyes");
								radiobtn.checked = true;
							}
							else if(userdata.Limb_P_T=="no")
							{
								radiobtn = document.getElementById("limbptno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".limbpt").prop('checked', false);
							}
						}
						else 
							{
								$(".limbpt").prop('checked', false);
							}
						// if(userdata.Cuff_pressure!="" && userdata.Cuff_pressure!=null)
						// {
						// 	var radiobtn;
						// 	if(userdata.Cuff_pressure=="yes")
						// 	{
						// 		radiobtn = document.getElementById("cuffpyes");
						// 		radiobtn.checked = true;
						// 	}
						// 	else if(userdata.Cuff_pressure=="no")
						// 	{
						// 		radiobtn = document.getElementById("cuffpno");
						// 		radiobtn.checked = true;
						// 	}
						// 	else 
						// 	{
						// 		$(".cuffp").prop('checked', false);
						// 	}
						// }
						// else 
						// 	{
						// 		$(".cuffp").prop('checked', false);
						// 	}
						$("#cuffpyes").val(userdata.Cuff_pressure);
						if(userdata.Central_line_dressing!="" && userdata.Central_line_dressing!=null)
						{
							var radiobtn;
							if(userdata.Central_line_dressing=="yes")
							{
								radiobtn = document.getElementById("cldressyes");
								radiobtn.checked = true;
							}
							else if(userdata.Central_line_dressing=="no")
							{
								radiobtn = document.getElementById("cldressno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".cldress").prop('checked', false);
							}
						}
						else 
							{
								$(".cldress").prop('checked', false);
							}
						if(userdata.E_T_T_T_care!="" && userdata.E_T_T_T_care!=null)
						{
							var radiobtn;
							if(userdata.E_T_T_T_care=="yes")
							{
								radiobtn = document.getElementById("Etcareyes");
								radiobtn.checked = true;
							}
							else if(userdata.E_T_T_T_care=="no")
							{
								radiobtn = document.getElementById("Etcareno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".Etcare").prop('checked', false);
							}
						}
						else 
							{
								$(".Etcare").prop('checked', false);
							}
						if(userdata.Sponge_Bath!="" && userdata.Sponge_Bath!=null)
						{
							var radiobtn;
							if(userdata.Sponge_Bath=="yes")
							{
								radiobtn = document.getElementById("sbathyes");
								radiobtn.checked = true;
							}
							else if(userdata.Sponge_Bath=="no")
							{
								radiobtn = document.getElementById("sbathno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".sbath").prop('checked', false);
							}
						}
						else 
							{
								$(".sbath").prop('checked', false);
							}
						if(userdata.Pressure_Sore!="" && userdata.Pressure_Sore!=null)
						{
							var radiobtn;
							if(userdata.Pressure_Sore=="yes")
							{
								radiobtn = document.getElementById("presoreyes");
								radiobtn.checked = true;
							}
							else if(userdata.Pressure_Sore=="no")
							{
								radiobtn = document.getElementById("presoreno");
								radiobtn.checked = true;
							}
							else 
							{
								$(".presore").prop('checked', false);
							}
						}
						else 
							{
								$(".presore").prop('checked', false);
							}

						$("#site").val(userdata.Site);
						$("#action_taken").val(userdata.Action_Taken);

						// diabetic
						$("#bldsgr").val(userdata.Blood_Sugar);

						$("#insl").val(userdata.Insulin);
						$("#inslField").val(userdata.InsulinName);
						$("#routeAdmi").val(userdata.routeOfAdmini);
						// if(userdata.Insulin != "" && userdata.Insulin!=null)
						// {
						// 	var insulinedata1=userdata.Insulin;
						// 	var insuline1 = insulinedata1.split(":");
						// 	$("#inslField").val(insuline1[0]);
						// 	$("#insl").val(insuline1[1]);
						// }

						// pain assestment
						$("#score").val(userdata.Score);

						// intake
						$("#in_iv").val(userdata.I_V);
						$("#in_rt").val(userdata.R_T);
						$("#in_orl").val(userdata.Oral);

						// output2
						$("#op_urn").val(userdata.Urine);
						$("#op_rt").val(userdata.output_R_T);
						$("#op_drn").val(userdata.output_Drain);

						// die chart
						// $("#qty").val(userdata.Quantity);//type ofe diet
						if(userdata.Quantity!="" && userdata.Quantity!=null)
						{
							$('#qty option[value="'+userdata.Quantity+'"]').attr('selected','selected');
						}
						else
						{
							$('#qty').val("");
						}
						// $("#typemeal").val(userdata.TypeOfMeal);//type of meal
						if(userdata.TypeOfMeal!="" && userdata.TypeOfMeal!=null)
						{
							$('#typemeal option[value="'+userdata.TypeOfMeal+'"]').attr('selected','selected');
						}
						else
						{
							$('#typemeal').val("");
						}
						$("#given").val(userdata.Given_By);
						$("#remark").val(userdata.Remarks);



				} else {
					console.log('something went wrong');
					app.errorToast("something went to wrong");
				}
			
	})
}

function uploadGlassglowForm(){
	var patient_id=localStorage.getItem("patient_id");
	let form = document.getElementById("glosgowform");
	let formData = new FormData(form);
	formData.append("patient_id", patient_id);
	var date_id=null;
	var date_filter=$("#d12").val();

	$.ajax({
			url: baseURL + "uploadGlassglowForm",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (success) {
				// success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					$("#glasgow_coma_edit_id").val('');
					$("#d12").val(date_filter);
					$("#glasglow_edit_date").html('');
					
					 getGcsData(date_filter,date_id);

				} else {
					app.errorToast(success.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}



function getGcsData(date_filter=null,id=null,edit_id=""){
// 	n =  new Date();
// y = n.getFullYear();
// m = n.getMonth() + 1;
// d = n.getDate();
// var dd=m + "/" + d + "/" + y;

// 	$('#d12').val(dd);
// 	if(date == ""){
// 		date =dd;
// 	}
	var date_filter1;
	if(date_filter==null)
	{
		
		date_filter1=$("#d12").val();
	}
	else
	{
		date_filter1=date_filter;
		
	}


var patient_id=	localStorage.getItem("patient_id")
	$.ajax({
			url: baseURL + "getGCSData",
			type: "POST",
			data: {patient_id:patient_id,date:date_filter1,id:id},
			cache: false,
			async: false,
			success: function (success) {
				success = JSON.parse(success);
				if (success.status == 200) {
				//	console.log(success.data);
					$("#div_gcs").html(success.data);
					$("#d12").val(success.date_f);
					$("#date_format_coma_scale").html(success.date_format);
					if(date_filter!=null)
					{
						// load_all_coma_scale();
					}
				} else {
					$("#div_gcs").html("");
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function get_data_to_edit(edit_id){
	// getGcsData("","",edit_id);
	let formData = new FormData();
	// console.log(id);
	formData.set("id", edit_id);

	app.request(baseURL + "getGlasGlowDataById", formData).then(response => {
		if (response.status == 200) {
		var userdata=response.body;
		load_all_coma_scale();
			$("#glasgow_coma_edit_id").val(userdata.id);

			$("#glasglow_edit_date").html(response.edit_date_format);

				//eye opening
					if(userdata.eyeopen_name!="" && userdata.eyeopen_name!=null)
						{
							var radiobtn;
							$("#eyeopenval").val(userdata.eyeopen_name);
							$("#h_eyeopenval").val(userdata.eyeopen_val);
							if(userdata.eyeopen_name=="Spontaneously")
							{
								radiobtn = document.getElementById("eyeopen1");
								radiobtn.checked = true;
							}else 
							if(userdata.eyeopen_name=="To speech")
							{
								radiobtn = document.getElementById("eyeopen2");
								radiobtn.checked = true;
							}else 
							if(userdata.eyeopen_name=="To pain")
							{
								radiobtn = document.getElementById("eyeopen3");
								radiobtn.checked = true;
							}else 
							if(userdata.eyeopen_name=="None")
							{
								radiobtn = document.getElementById("eyeopen4");
								radiobtn.checked = true;
							}else 
							{
								$(".eyeopen_n").prop('checked', false);
							}
						}
						else{
							$("#eyeopenval").val(userdata.eyeopen_name);
							$("#h_eyeopenval").val(userdata.eyeopen_val);
							$(".eyeopen_n").prop('checked', false);
						}

					//b v r
					if(userdata.BVR_name!="" && userdata.BVR_name!=null)
						{
							$("#bvrval").val(userdata.BVR_name);
							$("#h_bvrval").val(userdata.BVR_val);
							var radiobtn;
							if(userdata.BVR_name=="Oriented")
							{
								radiobtn = document.getElementById("bvr1");
								radiobtn.checked = true;
							}else 
							if(userdata.BVR_name=="Confused")
							{
								radiobtn = document.getElementById("bvr2");
								radiobtn.checked = true;
							}else 
							if(userdata.BVR_name=="inappropriate Words")
							{
								radiobtn = document.getElementById("bvr3");
								radiobtn.checked = true;
							}else 
							if(userdata.BVR_name=="Incomprehensible Sounds")
							{
								radiobtn = document.getElementById("bvr4");
								radiobtn.checked = true;
							}else 
							if(userdata.BVR_name=="None")
							{
								radiobtn = document.getElementById("bvr5");
								radiobtn.checked = true;
							}else 
							if(userdata.BVR_name=="On TT or ET Tube")
							{
								radiobtn = document.getElementById("bvr6");
								radiobtn.checked = true;
							}else 
							{
								$(".bvr_c").prop('checked', false);
							}
						}
						else
						{
							$("#bvrval").val(userdata.BVR_name);
							$("#h_bvrval").val(userdata.BVR_val);
							$(".bvr_c").prop('checked', false);
						}

						// b m r
						if(userdata.BMR_name!="" && userdata.BMR_name!=null)
						{
							$("#bmrval").val(userdata.BMR_name);
							$("#h_bmrval").val(userdata.BMR_val);
							var radiobtn;
							if(userdata.BMR_name=="Obeys command")
							{
								radiobtn = document.getElementById("bmr1");
								radiobtn.checked = true;
							}else 
							if(userdata.BMR_name=="Localises to pain")
							{
								radiobtn = document.getElementById("bmr2");
								radiobtn.checked = true;
							}else 
							if(userdata.BMR_name=="Withdraws to pain")
							{
								radiobtn = document.getElementById("bmr3");
								radiobtn.checked = true;
							}else 
							if(userdata.BMR_name=="Decorticate")
							{
								radiobtn = document.getElementById("bmr4");
								radiobtn.checked = true;
							}else 
							if(userdata.BMR_name=="Decerebrate")
							{
								radiobtn = document.getElementById("bmr5");
								radiobtn.checked = true;
							}else 
							if(userdata.BMR_name=="None")
							{
								radiobtn = document.getElementById("bmr6");
								radiobtn.checked = true;
							}else 
							{
								$(".bmr_c").prop('checked', false);
							}
						}
						else 
							{
								$("#bmrval").val(userdata.BMR_name);
								$("#h_bmrval").val(userdata.BMR_val);
								$(".bmr_c").prop('checked', false);
							}
						// pupilary reaction
						if(userdata.right_reaction!="" && userdata.right_reaction!=null)
						{
							$("#prr1val").val(userdata.right_reaction);
							$("#h_prr1val").val(userdata.right_reaction);
							var radiobtn;
							if(userdata.right_reaction=="Reacting")
							{
								radiobtn = document.getElementById("prr1");
								radiobtn.checked = true;
							}else 
							if(userdata.right_reaction=="fixed")
							{
								radiobtn = document.getElementById("prr2");
								radiobtn.checked = true;
							}else 
							if(userdata.right_reaction=="normal")
							{
								radiobtn = document.getElementById("prr3");
								radiobtn.checked = true;
							}else 
							if(userdata.right_reaction=="sluggish")
							{
								radiobtn = document.getElementById("prr4");
								radiobtn.checked = true;
							}else 
							{
								$(".prr1").prop('checked', false);
							}
						}
						else 
							{
								$("#prr1val").val(userdata.right_reaction);
								$("#h_prr1val").val(userdata.right_reaction);
								$(".prr1").prop('checked', false);
							}

						if(userdata.right_size!="" && userdata.right_size!=null)
						{
							$("#prrval").val(userdata.right_size);
							$("#h_prrval").val(userdata.right_size);
							var radiobtn;
							if(userdata.right_size=="8mm")
							{
								radiobtn = document.getElementById("prrs1");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="7mm")
							{
								radiobtn = document.getElementById("prrs2");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="6mm")
							{
								radiobtn = document.getElementById("prrs3");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="5mm")
							{
								radiobtn = document.getElementById("prrs4");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="4mm")
							{
								radiobtn = document.getElementById("prrs5");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="3mm")
							{
								radiobtn = document.getElementById("prrs6");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="2mm")
							{
								radiobtn = document.getElementById("prrs7");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="1mm")
							{
								radiobtn = document.getElementById("prrs8");
								radiobtn.checked = true;
							}else 
							{
								$(".prrs1").prop('checked', false);
							}
						}
						else 
							{
								$("#prrval").val(userdata.right_reaction);
								$("#h_prrval").val(userdata.right_size);
								$(".prrs1").prop('checked', false);
							}
							//left 
						if(userdata.left_reaction!="" && userdata.left_reaction!=null)
						{
							$("#prl1val").val(userdata.left_reaction);
							$("#h_prl1val").val(userdata.left_reaction);
							var radiobtn;
							if(userdata.left_reaction=="Reacting")
							{
								radiobtn = document.getElementById("prl1");
								radiobtn.checked = true;
							}else 
							if(userdata.left_reaction=="fixed")
							{
								radiobtn = document.getElementById("prl2");
								radiobtn.checked = true;
							}else 
							if(userdata.left_reaction=="normal")
							{
								radiobtn = document.getElementById("prl3");
								radiobtn.checked = true;
							}else 
							if(userdata.left_reaction=="sluggish")
							{
								radiobtn = document.getElementById("prl4");
								radiobtn.checked = true;
							}else 
							{
								$(".prl1").prop('checked', false);
							}
						}
						else 
							{
								$("#prl1val").val(userdata.left_reaction);
								$("#h_prl1val").val(userdata.left_reaction);
								$(".prl1").prop('checked', false);
							}

						if(userdata.right_size!="" && userdata.right_size!=null)
						{
							$("#prlval").val(userdata.right_size);
							$("#h_prlval").val(userdata.right_size);
							var radiobtn;
							if(userdata.right_size=="8mm")
							{
								radiobtn = document.getElementById("prls1");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="7mm")
							{
								radiobtn = document.getElementById("prls2");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="6mm")
							{
								radiobtn = document.getElementById("prls3");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="5mm")
							{
								radiobtn = document.getElementById("prls4");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="4mm")
							{
								radiobtn = document.getElementById("prls5");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="3mm")
							{
								radiobtn = document.getElementById("prls6");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="2mm")
							{
								radiobtn = document.getElementById("prls7");
								radiobtn.checked = true;
							}else 
							if(userdata.right_size=="1mm")
							{
								radiobtn = document.getElementById("prls8");
								radiobtn.checked = true;
							}else 
							{
								$(".prls1").prop('checked', false);
							}
						}
						else 
							{
								$("#prlval").val(userdata.right_reaction);
								$("#h_prlval").val(userdata.right_size);
								$(".prls1").prop('checked', false);
							}

						// motor power
						if(userdata.motor_power_name!="" && userdata.motor_power_name!=null)
						{
							$("#mtrpwrval").val(userdata.motor_power_name);
							$("#h_mtrpwrval").val(userdata.motor_power_val);
							var radiobtn;
							if(userdata.motor_power_name=="Normal Strenght")
							{
								radiobtn = document.getElementById("mtrpwr1");
								radiobtn.checked = true;
							}else 
							if(userdata.motor_power_name=="Moves With min. Res.")
							{
								radiobtn = document.getElementById("mtrpwr2");
								radiobtn.checked = true;
							}else 
							if(userdata.motor_power_name=="Moves againts gravity without Res.")
							{
								radiobtn = document.getElementById("mtrpwr3");
								radiobtn.checked = true;
							}else 
							if(userdata.motor_power_name=="Moves With gravity Eliminated")
							{
								radiobtn = document.getElementById("mtrpwr4");
								radiobtn.checked = true;
							}else 
							if(userdata.motor_power_name=="Flickering")
							{
								radiobtn = document.getElementById("mtrpwr5");
								radiobtn.checked = true;
							}else 
							if(userdata.motor_power_name=="No movement")
							{
								radiobtn = document.getElementById("mtrpwr6");
								radiobtn.checked = true;
							}else 
							{
								$(".mtrpwr1").prop('checked', false);
							}
						}
						else 
							{
								$("#mtrpwrval").val(userdata.motor_power_name);
								$("#h_mtrpwrval").val(userdata.motor_power_val);
								$(".mtrpwr1").prop('checked', false);
							}
		}
		else 
		{
			console.log('something went wrong');
			app.errorToast("something went to wrong");
		}

	})
}

 function get_datewiseData(id){
	var date_idtab2=$("#d12").val();
	getGcsData(date_idtab2,id);

}
function give_value(id,value,val){
	
	$("#h_"+id).val(value);
	$("#"+id).val(val);

}

function load_all_coma_scale()
{
	$('.eyeopen').toggle();
	$('.bvrtgl').toggle();
	$('.bmrtgl').toggle();
	$('.pupilreaction').toggle();
	$('.motorpwr').toggle();
	
}

function getBradenScaleData(date_filter=null,id=null,edit_id="")
{
	var date_filter1;
	if(date_filter==null)
	{
		
		date_filter1=$("#d13").val();
	}
	else
	{
		date_filter1=date_filter;
		
	}

	
var patient_id=	localStorage.getItem("patient_id")
	$.ajax({
			url: baseURL + "getBradenScaleData",
			type: "POST",
			data: {patient_id:patient_id,date:date_filter1,id:id},
			cache: false,
			async: false,
			success: function (success) {
				success = JSON.parse(success);
				if (success.status == 200) {
				//	console.log(success.data);
					$("#div_braden").html(success.data);
					$("#d13").val(success.date_f);
					$("#date_format_barden_scale").html(success.date_format);
				} else {
					$("#div_braden").html("");
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function get_datewiseBrandenData(id){
	var date_idtab2=$("#d13").val();
	getBradenScaleData(date_idtab2,id);

}

function load_all_barden_scale()
{
	$('.sensory_p').toggle();
	$('.moisture_m').toggle();
	$('.activity_a').toggle();
	$('.mobility_m').toggle();
	$('.nutrition_n').toggle();
	$('.friction_share_s').toggle();
	
}

function uploadBradenScaleForm()
{
	var patient_id=localStorage.getItem("patient_id");
	let form = document.getElementById("bradenScaleform");
	let formData = new FormData(form);
	formData.append("patient_id", patient_id);
	var date_id=null;
	var date_filter=$("#d13").val();

	$.ajax({
			url: baseURL + "uploadBradenScaleForm",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (success) {
				// success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);

					$("#barden_scale_edit_id").val('');
					$("#d13").val(date_filter);
					$("#barden_scale_edit_date").html('');

					 getBradenScaleData(date_filter,date_id);

				} else {
					app.errorToast(success.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function getFallRiskAsseData(date_filter=null,id=null,edit_id="")
{
	var date_filter1;
	if(date_filter==null)
	{
		
		date_filter1=$("#d14").val();
	}
	else
	{
		date_filter1=date_filter;
		
	}
	
	
var patient_id=	localStorage.getItem("patient_id")
	$.ajax({
			url: baseURL + "getFallRiskAsseData",
			type: "POST",
			data: {patient_id:patient_id,date:date_filter1,id:id},
			cache: false,
			async: false,
			success: function (success) {
				success = JSON.parse(success);
				if (success.status == 200) {
				//	console.log(success.data);
					$("#div_fallrisk").html(success.data);
					$("#d14").val(success.date_f);
					$("#date_format_fall_risk").html(success.date_format);
				} else {
					$("#div_braden").html("");
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function get_datewiseFallRiskData(id){
	var date_idtab4=$("#d14").val();
	getFallRiskAsseData(date_idtab4,id);

}

function load_all_Fall_risk()
{
	$('.age_a').toggle();
	$('.fall_history_h').toggle();
	$('.elimination_f').toggle();
	$('.medications_f').toggle();
	$('.equipment_f').toggle();
	$('.mobility_f').toggle();
	$('.cogmtion_f').toggle();
	
}

function uploadFallRiskForm()
{
	var patient_id=localStorage.getItem("patient_id");
	let form = document.getElementById("FallRiskAsseform");
	let formData = new FormData(form);
	formData.append("patient_id", patient_id);
	var date_id=null;
	var date_filter=$("#d13").val();

	$.ajax({
			url: baseURL + "uploadFallRiskForm",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (success) {
				// success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					$("#fall_risk_edit_id").val('');
					$("#d14").val(date_filter);
					$("#fall_risk_edit_date").html('');
					 getFallRiskAsseData(date_filter,date_id);

				} else {
					app.errorToast(success.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function get_textbox_value(id,value)
{
	$("#"+id).val(value);
	// console.log(value);
}

function uploadSofaScore()
{
	var patient_id=localStorage.getItem("patient_id");
	let form = document.getElementById("sofaScoreform");
	let formData = new FormData(form);
	formData.append("patient_id", patient_id);
	$.ajax({
			url: baseURL + "uploadSofaScore",
			type: "POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (success) {
				// success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					$("#sofaScoreform").trigger("reset");
					$("#first_op1").click();
					$("#first_op2").click();
					$("#first_op3").click();
					$("#first_op4").click();
					$("#first_op5").click();
					$("#first_op6").click();
					 getSofaScroTable();

				} else {
					app.errorToast(success.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
}

function getSofaScroTable() {

var patient_id=localStorage.getItem("patient_id");

	app.dataTable('sofaScoreTable', {
		url: baseURL + "getSofaScroTable",
		data: {patient_id: patient_id}
	}, undefined, (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		
		$('td:eq(0)', nRow).html(`${aData[0]}`);

		$('td:eq(1)', nRow).html(`${aData[1]}`);


	})
}

function get_bardendata_to_edit(edit_id)
{
	let formData = new FormData();
	// console.log(id);
	formData.set("id", edit_id);

	app.request(baseURL + "getBardenScaleDataById", formData).then(response => {
		if (response.status == 200) {
			var userdata=response.body;
			load_all_barden_scale();
			$("#barden_scale_edit_id").val(userdata.id);

			$("#barden_scale_edit_date").html(response.edit_date_format);

					//sensor perception
					if(userdata.sernsor_name!="" && userdata.sernsor_name!=null)
						{
							var radiobtn;
							$("#sensory_p").val(userdata.sernsor_name);
							$("#h_sensory_p").val(userdata.sernsor_val);
							if(userdata.sernsor_name=="Completely Limited")
							{
								radiobtn = document.getElementById("sensory_pe1");
								radiobtn.checked = true;
							}else 
							if(userdata.sernsor_name=="Very Limited")
							{
								radiobtn = document.getElementById("sensory_pe2");
								radiobtn.checked = true;
							}else 
							if(userdata.sernsor_name=="Slightly Limited")
							{
								radiobtn = document.getElementById("sensory_pe3");
								radiobtn.checked = true;
							}else 
							if(userdata.sernsor_name=="No Impairment")
							{
								radiobtn = document.getElementById("sensory_pe4");
								radiobtn.checked = true;
							}else 
							{
								$(".sensory_pe1").prop('checked', false);
							}
						}
						else{
							$("#sensory_p").val(userdata.sernsor_name);
							$("#h_sensory_p").val(userdata.sernsor_val);
							$(".sensory_pe1").prop('checked', false);
						}	

						//moisture
					if(userdata.moisture_name!="" && userdata.moisture_name!=null)
						{
							var radiobtn;
							$("#moisture_m").val(userdata.moisture_name);
							$("#h_moisture_m").val(userdata.moisture_val);
							if(userdata.moisture_name=="Constantly Moist")
							{
								radiobtn = document.getElementById("moisture_me1");
								radiobtn.checked = true;
							}else 
							if(userdata.moisture_name=="Very Moist")
							{
								radiobtn = document.getElementById("moisture_me2");
								radiobtn.checked = true;
							}else 
							if(userdata.moisture_name=="Occasionally Moist")
							{
								radiobtn = document.getElementById("moisture_me3");
								radiobtn.checked = true;
							}else 
							if(userdata.moisture_name=="Rarely Moist")
							{
								radiobtn = document.getElementById("moisture_me4");
								radiobtn.checked = true;
							}else 
							{
								$(".moisture_me1").prop('checked', false);
							}
						}
						else{
							$("#moisture_m").val(userdata.moisture_name);
							$("#h_moisture_m").val(userdata.moisture_val);
							$(".moisture_me1").prop('checked', false);
						}

						// activity
					if(userdata.activity_name!="" && userdata.activity_name!=null)
						{
							var radiobtn;
							$("#activity_a").val(userdata.activity_name);
							$("#h_activity_a").val(userdata.activity_val);
							if(userdata.activity_name=="Bed Fast")
							{
								radiobtn = document.getElementById("activity_ae1");
								radiobtn.checked = true;
							}else 
							if(userdata.activity_name=="Chair Fast")
							{
								radiobtn = document.getElementById("activity_ae2");
								radiobtn.checked = true;
							}else 
							if(userdata.activity_name=="Walks Occasionally")
							{
								radiobtn = document.getElementById("activity_ae3");
								radiobtn.checked = true;
							}else 
							if(userdata.activity_name=="Walks Frequently")
							{
								radiobtn = document.getElementById("activity_ae1");
								radiobtn.checked = true;
							}else 
							{
								$(".activity_ae1").prop('checked', false);
							}
						}
						else{
							$("#activity_a").val(userdata.activity_name);
							$("#h_activity_a").val(userdata.activity_val);
							$(".activity_ae1").prop('checked', false);
						}	

						// mobility
					if(userdata.mobility_name!="" && userdata.mobility_name!=null)
						{
							var radiobtn;
							$("#mobility_m").val(userdata.mobility_name);
							$("#h_mobility_m").val(userdata.mobility_val);
							if(userdata.mobility_name=="Completely Immobile")
							{
								radiobtn = document.getElementById("mobility_me1");
								radiobtn.checked = true;
							}else 
							if(userdata.mobility_name=="Very Limited")
							{
								radiobtn = document.getElementById("mobility_me2");
								radiobtn.checked = true;
							}else 
							if(userdata.mobility_name=="Slightly Limited")
							{
								radiobtn = document.getElementById("mobility_me3");
								radiobtn.checked = true;
							}else 
							if(userdata.mobility_name=="No Limitations")
							{
								radiobtn = document.getElementById("mobility_me4");
								radiobtn.checked = true;
							}else 
							{
								$(".mobility_me1").prop('checked', false);
							}
						}
						else{
							$("#mobility_m").val(userdata.mobility_name);
							$("#h_mobility_m").val(userdata.mobility_val);
							$(".mobility_me1").prop('checked', false);
						}

					// nutrition
					if(userdata.nutrition_name!="" && userdata.nutrition_name!=null)
						{
							var radiobtn;
							$("#nutrition_n").val(userdata.nutrition_name);
							$("#h_nutrition_n").val(userdata.nutrition_val);
							if(userdata.nutrition_name=="Very Poor")
							{
								radiobtn = document.getElementById("nutrition_ne1");
								radiobtn.checked = true;
							}else 
							if(userdata.nutrition_name=="Probably Inadequate")
							{
								radiobtn = document.getElementById("nutrition_ne2");
								radiobtn.checked = true;
							}else 
							if(userdata.nutrition_name=="Adequate")
							{
								radiobtn = document.getElementById("nutrition_ne3");
								radiobtn.checked = true;
							}else 
							if(userdata.nutrition_name=="Excellent")
							{
								radiobtn = document.getElementById("nutrition_ne4");
								radiobtn.checked = true;
							}else 
							{
								$(".nutrition_ne1").prop('checked', false);
							}
						}
						else{
							$("#nutrition_n").val(userdata.nutrition_name);
							$("#h_nutrition_n").val(userdata.nutrition_val);
							$(".nutrition_ne1").prop('checked', false);
						}

					// friction and share
					if(userdata.friction_share_name!="" && userdata.friction_share_name!=null)
						{
							var radiobtn;
							$("#friction_share_s").val(userdata.friction_share_name);
							$("#h_friction_share_s").val(userdata.friction_share_val);
							if(userdata.friction_share_name=="Problem")
							{
								radiobtn = document.getElementById("friction_share_se1");
								radiobtn.checked = true;
							}else 
							if(userdata.friction_share_name=="Potential Problem")
							{
								radiobtn = document.getElementById("friction_share_se2");
								radiobtn.checked = true;
							}else 
							if(userdata.friction_share_name=="No Apparent Problem")
							{
								radiobtn = document.getElementById("friction_share_se3");
								radiobtn.checked = true;
							}else 
							{
								$(".friction_share_se1").prop('checked', false);
							}
						}
						else{
							$("#friction_share_s").val(userdata.friction_share_name);
							$("#h_friction_share_s").val(userdata.friction_share_val);
							$(".friction_share_se1").prop('checked', false);
						}	


		}
		else 
		{
			console.log('something went wrong');
			app.errorToast("something went to wrong");
		}
	})
}

function get_fallRiskdata_to_edit(edit_id)
{
	let formData = new FormData();
	// console.log(id);
	formData.set("id", edit_id);

	app.request(baseURL + "getFallRiskDataById", formData).then(response => {
		if (response.status == 200) {
			var userdata=response.body;
			load_all_Fall_risk();
			$("#fall_risk_edit_id").val(userdata.id);

			$("#fall_risk_edit_date").html(response.edit_date_format);
			``		// age
					if(userdata.age_name!="" && userdata.age_name!=null)
						{
							var radiobtn;
							$("#age_a").val(userdata.age_name);
							$("#h_age_a").val(userdata.age_val);
							if(userdata.age_name=="Less than 60 yrs")
							{
								radiobtn = document.getElementById("age_ae1");
								radiobtn.checked = true;
							}else 
							if(userdata.age_name=="60 to 69 yrs")
							{
								radiobtn = document.getElementById("age_ae2");
								radiobtn.checked = true;
							}else 
							if(userdata.age_name=="70 to 79 yrs")
							{
								radiobtn = document.getElementById("age_ae3");
								radiobtn.checked = true;
							}else 
							if(userdata.age_name=="greater than equal 80yrs")
							{
								radiobtn = document.getElementById("age_ae4");
								radiobtn.checked = true;
							}else 
							{
								$(".age_ae1").prop('checked', false);
							}
						}
						else{
							$("#age_a").val(userdata.age_name);
							$("#h_age_a").val(userdata.age_val);
							$(".age_ae1").prop('checked', false);
						}
						// fall history
					if(userdata.fall_history_name!="" && userdata.fall_history_name!=null)
						{
							var radiobtn;
							$("#fall_history_h").val(userdata.fall_history_name);
							$("#h_fall_history_h").val(userdata.fall_history_val);
							if(userdata.fall_history_name=="None")
							{
								radiobtn = document.getElementById("fall_he1");
								radiobtn.checked = true;
							}else 
							if(userdata.fall_history_name=="One fall within 6 months before admission")
							{
								radiobtn = document.getElementById("fall_he2");
								radiobtn.checked = true;
							}else 
							{
								$(".fall_he1").prop('checked', false);
							}
						}
						else{
							$("#fall_history_h").val(userdata.fall_history_name);
							$("#h_fall_history_h").val(userdata.fall_history_val);
							$(".fall_he1").prop('checked', false);
						}

					// elimination
					if(userdata.elimination_name!="" && userdata.elimination_name!=null)
						{
							var radiobtn;
							$("#elimination_f").val(userdata.elimination_name);
							$("#h_elimination_f").val(userdata.elimination_val);
							if(userdata.elimination_name=="Incontinence")
							{
								radiobtn = document.getElementById("elimination_fe1");
								radiobtn.checked = true;
							}else 
							if(userdata.elimination_name=="Urgency or frequency")
							{
								radiobtn = document.getElementById("elimination_fe2");
								radiobtn.checked = true;
							}else 
							if(userdata.elimination_name=="Urgency or frequency and incontinence")
							{
								radiobtn = document.getElementById("elimination_fe3");
								radiobtn.checked = true;
							}else 
							{
								$(".elimination_fe1").prop('checked', false);
							}
						}
						else{
							$("#elimination_f").val(userdata.elimination_name);
							$("#h_elimination_f").val(userdata.elimination_val);
							$(".elimination_fe1").prop('checked', false);
						}

					// medications
					if(userdata.medication_name!="" && userdata.medication_name!=null)
						{
							var radiobtn;
							$("#medications_f").val(userdata.medication_name);
							$("#h_medications_f").val(userdata.medication_val);
							if(userdata.medication_name=="On 1 high fall risk drug")
							{
								radiobtn = document.getElementById("medications_fe1");
								radiobtn.checked = true;
							}else 
							if(userdata.medication_name=="On 2 or more high fall risk drugs")
							{
								radiobtn = document.getElementById("medications_fe2");
								radiobtn.checked = true;
							}else 
							if(userdata.medication_name=="Sedated procedure within pas 24 hours")
							{
								radiobtn = document.getElementById("medications_fe3");
								radiobtn.checked = true;
							}else 
							{
								$(".medications_fe1").prop('checked', false);
							}
						}
						else{
							$("#medications_f").val(userdata.medication_name);
							$("#h_medications_f").val(userdata.medication_val);
							$(".medications_fe1").prop('checked', false);
						}

					// patient care equipment
					if(userdata.equipment_name!="" && userdata.equipment_name!=null)
						{
							var radiobtn;
							$("#equipment_f").val(userdata.equipment_name);
							$("#h_equipment_f").val(userdata.equipment_val);
							if(userdata.equipment_name=="One present")
							{
								radiobtn = document.getElementById("equipment_fe1");
								radiobtn.checked = true;
							}else 
							if(userdata.equipment_name=="Two present")
							{
								radiobtn = document.getElementById("equipment_fe1");
								radiobtn.checked = true;
							}else 
							if(userdata.equipment_name=="Three or more present")
							{
								radiobtn = document.getElementById("equipment_fe1");
								radiobtn.checked = true;
							}else 
							{
								$(".equipment_fe1").prop('checked', false);
							}
						}
						else{
							$("#equipment_f").val(userdata.equipment_name);
							$("#h_equipment_f").val(userdata.equipment_val);
							$(".equipment_fe1").prop('checked', false);
						}

					// mobility
					if(userdata.mobility_name!="" && userdata.mobility_name!=null)
						{
							var radiobtn;
							$("#mobility_f").val(userdata.mobility_name);
							$("#h_mobility_f").val(userdata.mobility_val);
							$(".mobility_fe1").prop('checked', false);

							var mobilitydata1=userdata.mobility_name;
							var mobility = mobilitydata1.split("|||");
							// console.log(mobility);
							mobility.forEach(getMobilityCheckBoxes);

							// if(userdata.mobility_name=="Requires assistance for mobility, transfer or ambulation")
							// {
							// 	radiobtn = document.getElementById("mobility_fe1");
							// 	radiobtn.checked = true;
							// }else 
							// if(userdata.mobility_name=="Unsteady gait")
							// {
							// 	radiobtn = document.getElementById("mobility_fe2");
							// 	radiobtn.checked = true;
							// }else 
							// if(userdata.mobility_name=="Visual or auditory impairment  affecting mobility")
							// {
							// 	radiobtn = document.getElementById("mobility_fe3");
							// 	radiobtn.checked = true;
							// }else 
							// {
							// 	$(".mobility_fe1").prop('checked', false);
							// }
						} 
						else{
							$("#mobility_f").val(userdata.mobility_name);
							$("#h_mobility_f").val(userdata.mobility_val);
							$(".mobility_fe1").prop('checked', false);
						}

					// cognition
					if(userdata.cognition_name!="" && userdata.cognition_name!=null)
						{
							var radiobtn;
							$("#cogmtion_f").val(userdata.cognition_name);
							$("#h_cogmtion_f").val(userdata.cognition_val);
							$(".cogmtion_fe1").prop('checked', false);

							var congnitiondata1=userdata.cognition_name;
							var congnition = congnitiondata1.split("|||");
							// console.log(mobility);
							congnition.forEach(getCongnitionCheckBoxes);
							
							
						}
						else{
							$("#cogmtion_f").val(userdata.cognition_name);
							$("#h_cogmtion_f").val(userdata.cognition_val);
							$(".cogmtion_fe1").prop('checked', false);
						}

		}
		else 
		{
			console.log('something went wrong');
			app.errorToast("something went to wrong");
		}
		})
}

function getMobilityCheckBoxes(item)
{
	if(item=="Requires assistance for mobility, transfer or ambulation")
		{
			$("#mobility_fe1").prop('checked', true);
			
		}

		if(item=="Unsteady gait")
		{
			$("#mobility_fe2").prop('checked', true);
		}

		if(item=="Visual or auditory impairment  affecting mobility")
		{
			$("#mobility_fe3").prop('checked', true);
		}
		
}

function getCongnitionCheckBoxes(item)
{
	if(item=="Altered awareness of immediate physical environment")
		{
			
			$("#cogmtion_fe2").prop('checked', true);
		}
		 
		if(item=="Impulsive")
		{
			
			$("#cogmtion_fe3").prop('checked', true);
		}
		
		if(item=="Lack of undesrtanding of ones physical and cognitive limitations")
		{
			
			$("#cogmtion_fe4").prop('checked', true);
		}
}

function getDownloadDietReport()
{
	let formData = new FormData();
	var patient_id = localStorage.getItem("patient_id");
	formData.set("patient_id", patient_id);
	app.request(baseURL + "getDownloadDietReportData", formData).then(res => {
		if(res.status==200)
		{
			var loginFormObject = {};
		
				// let patient = $("#OtherServiceAllHistoryPatient").val();
				// loginFormObject["patient_id"]=patient;
				loginFormObject["patient_id"]=patient_id;
			const x=JSON.stringify(loginFormObject);
			window.location.href= baseURL+"getDownloadDietReport?data=" + x;
		}
		else
		{
			app.errorToast('Data Not Found For Download');
		}
		});
	
}


	function get_forms(patient_id,department_id) {
		// var department_id = $("#department_id").val();

		$.ajax({
			url: baseURL+"getTemplateFormPersonal",
			type: "POST",
			dataType: "json",
			data: {department_id: department_id, patient_id: patient_id},
			success: function (result) {
				var data = result.data;
				if (result['code'] === 200) {
					// $('#department_name').html(result.template_name);
					$("#form_data").html(data);
					$("#button_data").html(result.button_data);
					app.formValidation();
				} else {
					$("#button_data").html('');
				}
			}, error: function (error) {

				alert('Something went wrong please try again');
			}
		});
	}

function getRehabModal(department_id,section_id,tab)
{
	var patient_id=localStorage.getItem("patient_id");

	$.ajax({
			url: baseURL+"getSectionTemplateFormPersonal",
			type: "POST",
			dataType: "json",
			data: {department_id: department_id, patient_id: patient_id,section_id:section_id},
			success: function (result) {
				var data = result.data;
				if (result['code'] === 200) {
					// $('#department_name').html(result.template_name);
					$("#"+tab).html(data);
					// $("#button_data").html(result.button_data);
					app.formValidation();
				} else {
					$("#"+tab).html(data);
					// $("#button_data").html('');
				}
			}, error: function (error) {

				alert('Something went wrong please try again');
			}
		});
}

let labelsCollection = null;
	let record = null;
	const trans = [];


function view_history(table_name, section_id) {
		$("#main_div_" + section_id).addClass('d-none');
		$("#history_div_" + section_id).removeClass('d-none');
		$("#graph_div_" + section_id).addClass('d-none');
		$("#history_btn_" + section_id).hide();//main_btn
		$("#graph_btn_" + section_id).show();
		$("#main_btn_" + section_id).show();
		let patient_id = localStorage.getItem("patient_id")
		$.ajax({
			type: "POST",
			url: baseURL+"get_history_data",
			dataType: "json",
			data: {table_name: table_name, patient_id: patient_id, section_id: section_id},
			success: function (result) {
				$("#history_div_" + section_id).empty();
				$("#history_div_" + section_id).append(result.table);

				$("#example").on("mousedown", "td .fa.fa-minus-square", function (e) {
					table.row($(this).closest("tr")).remove().draw();
				});
				$("#example").on('mousedown.edit', "i.fa.fa-pencil-square", function (e) {

					$(this).removeClass().addClass("fa fa-envelope-o");
					var $row = $(this).closest("tr").off("mousedown");
					var $tds = $row.find("td").not(':first').not(':last');

					$.each($tds, function (i, el) {
						var txt = $(this).text();
						$(this).html("").append("<input type='text' value=\"" + txt + "\">");
					});
				});

				$('#history_table_' + section_id).on('mousedown', "#selectbasic", function (e) {
					e.stopPropagation();
				});

				$('#history_table_' + section_id).DataTable(
						{
						 order:[[result.transColumnIndex,"desc"]],
							"columnDefs" : [{"targets":result.transColumnIndex, "type":"date-eu"}],
						 }
						 );
				labelsCollection = result.label;
				record = result.data;
				trans.push(result.trans);
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}


	function loadGraph(sectionName, records, lable, transDate, section_id) {
		const labelsValues = transDate;
		let color = getRandomColor();
		const historyDataSets = [{
			label: lable,
			data: records[lable],
			borderColor: color,
			backgroundColor: color,
			tension: 0.1
		}];

		const data = {
			labels: labelsValues,
			datasets: historyDataSets
		};
		const config = {
			type: 'line',
			data: data,
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: sectionName
					}
				}
			},
		};


		$(`#graph_section_${section_id}`).append(`<canvas id="chat_section_${lable}"  class="col-md-4" style="width: 100%;height: 100%"></canvas>`);
		var ctx = document.getElementById(`chat_section_${lable}`)
		new Chart(ctx, config);
	}

	function view_graph(sectionName, section_id) {
		$("#history_div_" + section_id).addClass('d-none');
		$("#main_div_" + section_id).addClass('d-none');
		$("#graph_div_" + section_id).removeClass('d-none');
		$(`#graph_section_${section_id}`).empty();
		const transDate = trans[0];
		labelsCollection.map(l => {
			loadGraph(sectionName, record, l, transDate, section_id);
			return;
		})

	}
	function view_main_data(section_id) {
		$("#history_btn_" + section_id).show();//main_btn
		$("#main_btn_" + section_id).hide();
		$("#history_div_" + section_id).addClass('d-none');
		$("#main_div_" + section_id).removeClass('d-none');
		$("#graph_div_" + section_id).addClass('d-none');
		$("#graph_btn_" + section_id).hide();
	}
// user in dynamic form submision
function save_form_data(form) {

	app.request(baseURL+"sectionSave",new FormData(form)).then(result=>{
		var firm_data = result.firm_data;

		if (result['code'] == '200') {
			app.successToast("Save Changes")

		} else {
			app.errorToast("Failed To Save Data")
		}
	}).catch(error=>{
		console.log(error)
		app.errorToast('Something went wrong please try again');
	})

}

function get_forms_history(section_id, history_id, patient_id, department_id) {
		let formData = new FormData();
		formData.set("section_id", section_id);
		formData.set("history_id", history_id);
		formData.set("patient_id", patient_id);
		// formData.set("department_id",department_id);
		app.request(baseURL+'getHistoryTemplate', formData).then(response => {
			if (response.status === 200) {
				$('#history_form_section').empty();
				$('#history_form_section').append(response.data);
			}
		}).catch(error => {
			console.log(error);
		})
	}

	// user update dynamic form submission
	function update_form_data(sectionFormId) {
		// console.log('hiiiii');
		form = document.getElementById(sectionFormId);
		app.request(baseURL + "sectionUpdate", new FormData(form)).then(result => {
			var firm_data = result.firm_data;

			if (result['code'] == '200') {
				var tableName = result['tableName'];
				var section_id = result['section_id'];
				app.successToast("Save Changes");
				view_history(tableName, section_id);
				$("#editSectionButton_" + section_id).click();

			} else {
				app.errorToast("Failed To Save Data");
			}
		}).catch(error => {
			console.log(error)
			app.errorToast('Something went wrong please try again');
		})
	}