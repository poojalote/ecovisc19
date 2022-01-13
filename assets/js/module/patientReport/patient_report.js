$(document).ready(function () {
	var patient_id = localStorage.getItem("patient_id");
	 get_VitalSigns(patient_id);
	var intervalId = window.setInterval(function(){
	 get_VitalSigns(patient_id);
	}, 10000);
	
	get_excelSigns(patient_id);
	getbundelsData(patient_id);
	get_sofaScore(patient_id);
	get_patientReportImage(patient_id);
	get_HEME_data(patient_id);

});

function serverRequest(requestURL, dataObject) {

	return new Promise((resolve, reject) => {
		$.ajax({
			type: "POST",
			url: baseURL + requestURL,
			dataType: "json",
			data: dataObject,
			success: function (result) {
				resolve(result);
			}, error: function (error) {
				console.log("Error in Server Request Function : ", error);
				reject('Something went wrong please try again');

			}
		});
	});
}

function get_VitalSigns(patient_id) {
	serverRequest("get_VitalSigns", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			var user_data = response.body;
			$("#V_HR").html(response.HR);
			$("#V_BP").html(response.NIBP);
			$("#V_RR").html(response.RR);
			$("#V_SPO2").html(response.SPO2);
			$("#V_TM").html(response.TM);
		} else {
			//app.errorToast('data not found ');
		}
	}).catch(error => console.log(error));
}
function getbundelsData(patient_id){
	serverRequest("GetBundlesData", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			var user_data = response.data;
			var time = response.time;
			var days = response.days;
			$("#time_new").html("-Time: "+time);
			$("#time2").html("Time: "+time);
			$("#days_new").html("Day: "+days);
			 var htmlVent="";
			//'<span class="text-muted">Mode</span>'
			if(user_data['Mode'] != ""){
				htmlVent = htmlVent+'<span class="text-muted">Mode:'+user_data['Mode']+'</span>';
			}
			if(user_data['Flo2'] != ""){
				htmlVent = htmlVent+'|<span class="text-muted">Flo2:'+user_data['Flo2']+'</span>';
			}
			if(user_data['PEE'] != ""){
				htmlVent = htmlVent+'|<span class="text-muted">PEEP:'+user_data['PEE']+'</span>';
			}
			if(user_data['RATE'] != ""){
				htmlVent = htmlVent+'|<span class="text-muted">RATE:'+user_data['RATE']+'</span>';
			}
			if(user_data['RASS'] != ""){
				htmlVent = htmlVent+'|<span class="text-muted">RASS:'+user_data['RASS']+'</span>';
			}
			if(user_data['Tidal_Volume'] != ""){
				htmlVent = htmlVent+'|<span class="text-muted">Tidal Volume:'+user_data['Tidal_Volume']+'</span>';
			}
			$("#VentDiv").html(htmlVent); 
			if(user_data['Central_Line'] != ""){
				$("#ResultCentralLine").html("<b>Result:"+user_data['Central_Line']+"</b>");
				$("#cl").css("font-weight", "900");
			}
			if(user_data['Atrial_Lines'] != ""){
				$("#ResultAtrialLine").html("<b>Result:"+user_data['Atrial_Lines']+"</b>");
				$("#al").css("font-weight", "900");
			}
			if(user_data['HD_Catheter'] != ""){
				$("#Hdcath").html("<b>Result:"+user_data['HD_Catheter']+"</b>");
				$("#hc").css("font-weight", "900");
			}
			if(user_data['Peripheral_Line'] != ""){
				$("#Peripheral_Line").html("<b>Result:"+user_data['Peripheral_Line']+"</b>");
				$("#pl").css("font-weight", "900");
			}
			if(user_data['Drains'] != ""){
				$("#Drains").html("<b>Result:"+user_data['Drains']+"</b>");
				$("#dr").css("font-weight", "900");
			}
			if(user_data['Urinary_Catheter'] != ""){
				$("#urincath").html("<b>Result:"+user_data['Urinary_Catheter']+"</b>");
				$("#uc").css("font-weight", "900");
			}
			if(user_data['Endotracheal_Tube'] != ""){
				$("#endotube").html("<b>Result:"+user_data['Endotracheal_Tube']+"</b>");
				$("#et").css("font-weight", "900");
			}
			if(user_data['IABP_catheter'] != ""){
				$("#iabpcath").html("<b>Result:"+user_data['IABP_catheter']+"</b>");
				$("#ic").css("font-weight", "900");
			}
			if(user_data['Tracheostomy_tube'] != ""){
				$("#trachtube").html("<b>Result:"+user_data['Tracheostomy_tube']+"</b>");
				$("#tt").css("font-weight", "900");
			}
			if(user_data['Ryles_tube'] != ""){
				$("#ryletube").html("<b>Result:"+user_data['Ryles_tube']+"</b>");
				$("#rt").css("font-weight", "900");
			}
			
			console.log(user_data);
			
		} else {
			//app.errorToast('data not found ');
		}
	}).catch(error => console.log(error));
}
function get_excelSigns(patient_id) {
	serverRequest("get_excelSigns", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			var user_data = response.body;
			
			if(response.lactate != ""){
				$("#LACTATE").html(response.lactate);
				$("#lactate_date").html(response.sofa_date);
				$("#lactate_head").css("font-weight", "900");
			}

			
			if(response.glucose != ""){
				$("#glucose_score").html(response.glucose);
				$("#glucose_date").html(response.glucose_date);
				$("#glucose_head").css("font-weight", "900");
			}
			if(response.BloodGas != ""){
				$("#bloodGas_score").html(response.BloodGas);
				$("#bloodGas_date").html(response.BloodGas_date);
				$("#bloodGas_head").css("font-weight", "900");
			}
			
			

			

		} else {
			app.errorToast('data not found ');
		}
	}).catch(error => console.log(error));
}
function get_sofaScore(patient_id) {
	serverRequest("get_sofaScore", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			
			$("#sofa_score").html(response.sofa_score);
			$("#sofa_date").html(response.sofa_date);
			if(response.sofa_score != ""){
				
				$("#sofa_head").css("font-weight", "900");
			}

			

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function get_patientReportImage(patient_id) {
	serverRequest("get_patientReportImage", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			
			$("#patientReport_image").html(response.data);
			
			

			

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function get_HEME_data(patient_id) {
	serverRequest("get_HEME_data", {patient_id: patient_id}).then(response => {
		
		if (response.status === 200) {
			// var user_data = response.body;
		
				$("#Neutrophils").html(response.Neutrophils);
				$("#Lymphocytes").html(response.Lymphocytes);
				$("#Monocytes").html(response.Monocytes);
				$("#Eosinophils").html(response.Eosinophils);
				$("#Basophils").html(response.Basophils);
				$("#Platelet_Count").html(response.Platelet_Count);
				$("#Haemoglobin").html(response.Haemoglobin);

				$("#Chloride").html(response.Chloride);
				$("#Potassium").html(response.Potassium);
				$("#Sodium").html(response.Sodium);
				$("#Bicarbonate").html(response.Bicarbonate);
				$("#Calcium").html(response.Calcium);
				
				$(".last_visit").html(response.last_visit);
	

		} else {
			$("#Neutrophils").html('');
			$("#Lymphocytes").html('');
				$("#Monocytes").html('');
				$("#Eosinophils").html('');
				$("#Basophils").html('');
				$("#Platelet_Count").html('');
				$("#Haemoglobin").html('');

				$("#Chloride").html('');
				$("#Potassium").html('');
				$("#Sodium").html('');
				$("#Bicarbonate").html('');
				$("#Calcium").html('');
				
				$(".last_visit").html('');
			// app.errorToast('data not found ');
		}
	}).catch(error => console.log(error));
}