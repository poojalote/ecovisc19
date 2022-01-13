function get_roomdetailstable() {
	var gender = $("#searchGender").val();
	var searchPatient = $("#searchPatient").val();
	var searchAge = $("#searchAge").val();
	var bloodtest = $("#bloodtest").val();
	var vitalsign = $("#vitalsign").val();

	var id = $("#zoneDetails").val();
	let formData = new FormData();
	if (id) {
		formData.set("id", id);
	}
	if (bloodtest) {
		formData.set("bloodtest", bloodtest);
	}
	if (vitalsign) {
		formData.set("vitalsign", vitalsign);
	}

	if (gender) {
		formData.set("gender", gender);
	}

	if (searchAge) {
		formData.set("searchAge", searchAge);
	}
	if (searchPatient) {
		formData.set("searchPatient", searchPatient);
	}


	app.request(baseURL + "get_roomdetails_info_icu", formData).then(result => {
		var data = result.result_sal;
		if (result.status == 200) {
			$('#show_room_details').empty();
			$('#show_room_details').append(data);
			if (result.pData) {
				result.pData.map(async data => {
					await getPatientLabReport(data[0], data[2]);
					if(data[1] !== "-1") {
						var res = data[1].split(" | ");
						var camera = res[0] + res[1];
						get_images(camera);
					}
				});
			}

		} else {
			$('#show_room_details').empty();
			$('#show_room_details').append(data);
		}
	})
}

function get_images(camera){
	let d = new Date();
	if(camera !=="undefined"){
		document.getElementById("L_"+camera).src="https://vs.docango.com/images/picture_"+camera+".jpg?version="+d.getMilliseconds();
		getLiveImages(camera);
	}else{
		document.getElementById("L_"+camera).src="https://c19.docango.com/assets/img/not-available.jpg";
	}

}
function getLiveImages(camera) {
	let d = new Date();
	let oldUrl = document.getElementById("L_"+camera).src;
	let newUrl = "https://vs.docango.com/images/picture_"+camera+".jpg?version="+d.getMilliseconds();
	document.getElementById("L_"+camera).src=loadImage1(newUrl,oldUrl);
	setTimeout(()=>getLiveImages(camera),120000);

}
let loadImage1 = function(newUrl,oldUrl){
	let image = new Image();
	image.src = newUrl;
	if (image.width === 0) {
		return oldUrl;
	} else {
		return newUrl;
	}
}

function getVitalSignLiveByBed(bed_id) {
	let formData = new FormData();
	formData.set("bed_id",bed_id);

	app.request(baseURL + "getVitalSignLiveByBed", formData).then(res => {
		if (res.status === 200) {
			$("#patient_vital_" + bed_id).empty();
			$("#patient_vital_" + bed_id).append(res.body);
			$("#vitaDataNew" + bed_id).empty();
			$("#vitaDataNew" + bed_id).append(res.body2);
			setTimeout(()=>getVitalSignLiveByBed(bed_id),10000);
		}
	})

}

function getPatientLabReport(id, bed_id) {
	let formData = new FormData();
	formData.set("id", id);
	formData.set("bed_id", bed_id);
	return app.request(baseURL + "getPatientLabReport", formData).then(response => {
		$("#patient_lab_" + id).empty();
		$("#patient_lab_" + id).append(response.lab);
		$("#patient_vital_" + id).empty();
		$("#patient_vital_" + id).append(response.vital);
		$("#vitaDataNew" + id).empty();
		$("#vitaDataNew" + id).append(response.vital_signinline);
		getVitalSignLiveByBed(bed_id);
	}).catch(error => {
		console.log(error);
		$("#patient_lab_" + id).empty();
		$("#patient_lab_" + id).append("-");
		$("#patient_vital_" + id).empty();
		$("#patient_vital_" + id).append('-');
		$("#vitaDataNew" + id).empty();
		$("#vitaDataNew" + id).append('-');
		getVitalSignLiveByBed(bed_id);
	});

}

function get_icuPtientScheduleMedicine(id) {
	// console.log(id);
	$("#icu_bed_medicine_button").click();
	$.ajax({
		type: "POST",
		url: baseURL + "get_icuPtientScheduleMedicine",
		dataType: "json",
		async: false,
		cache: false,
		data: {id: id},
		success: function (result) {
			var data = result.data;
			if (result.status == 200) {

				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("Medication Details");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);


			} else {
				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);
			}
		}
	});
}

function getIcuPatientLabTestPara(patient_id) {
	$("#icu_bed_medicine_button").click();
	$.ajax({
		type: "POST",
		url: baseURL + "getIcuPatientLabTestPara",
		dataType: "json",
		async: false,
		cache: false,
		data: {patient_id: patient_id},
		success: function (result) {
			var data = result.data;
			if (result.status == 200) {
				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("Lab Test Details");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);

			} else {
				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);
			}
		}
	});
}

function getIcuPatientVitalSignPara(patient_id) {
	$("#icu_bed_medicine_button").click();
	$.ajax({
		type: "POST",
		url: baseURL + "getIcuPatientVitalSignPara",
		dataType: "json",
		async: false,
		cache: false,
		data: {patient_id: patient_id},
		success: function (result) {
			var data = result.data;
			if (result.status == 200) {
				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("Vital Sign Details");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);

			} else {
				$('#headerIcuPanel').empty();
				$('#headerIcuPanel').append("");
				$('#icu_bed_medicine_data').empty();
				$('#icu_bed_medicine_data').append(data);
			}
		}
	});
}

function loadPatient(id, name, adhar_number, contract, profile, admissionDate, mode, type, icu) {
	localStorage.setItem("patient_id", id);
	localStorage.setItem("patient_name", name);
	localStorage.setItem("patient_adharnumber", adhar_number);
	localStorage.setItem("patient_contact", contract);
	localStorage.setItem("patient_type", type);
	localStorage.setItem("patient_icu", icu);
	if (profile != null || profile !== '') {
		localStorage.setItem("patient_profile", profile);
	}

	if (admissionDate != null && admissionDate !== "0000-00-00 00:00:00") {
		localStorage.setItem("patient_admission", admissionDate);
	} else {
		localStorage.setItem("patient_admission", null);
	}
	if (mode != null || mode !== '0') {
		localStorage.setItem("patient_mode", mode);
	} else {
		localStorage.setItem("patient_mode", null);
	}
	if (parseInt(type) === 2) {
		window.location.href = baseURL + "staff/dashboard";
	} else {
		if (parseInt(icu) === 3) {
			window.location.href = baseURL + "patientReport";
		} else {
			window.location.href = baseURL + "patient/dashboard";

		}

	}

}

function get_icuPatientList() {
	var gender = $("#searchGender").val();

	$.ajax({
		type: "POST",
		url: baseURL + "get_icuPatientList",
		dataType: "json",
		async: false,
		cache: false,
		data: {gender: gender},
		success: function (result) {
			var data = result.options;
			if (result.status == 200) {
				$('#searchPatient').empty();
				$('#searchPatient').append(data);
				$('#searchPatient').select2();

			} else {
				$('#searchPatient').empty();
				$('#searchPatient').append(data);
				$('#searchPatient').select2();
			}
		}
	});
}
let imageInterval;
function open_modal_bed(){
	$("#IcubedModal").modal('show');
	
	get_all_bed();


}


function get_all_bed(){
	$.ajax({
		type: "POST",
		url: baseURL + "GetIcuBedData",
		dataType: "json",
		async: false,
		cache: false,
		success: function (result) {
			var data = result.data;

			if (result.status == 200) {
				let codes=result.cameraCode;
				$('#bed_data').empty();
				$('#bed_data').html(data);
				if(!imageInterval){
					if(codes.length>0){
						codes.forEach(f=>{
							let d = new Date();
							document.getElementById(f).src="https://vs.docango.com/images/picture_"+f+".jpg?version="+d.getMilliseconds();
						})
					}
					imageInterval=setInterval(()=>{
						if(codes.length>0){
							codes.forEach(f=>{
								let d = new Date();
								document.getElementById(f).src="https://vs.docango.com/images/picture_"+f+".jpg?version="+d.getMilliseconds();
							})
						}
					},120000);
				}
			} else {
				$('#bed_data').empty();
				$('#bed_data').html(data);
			}
		}
	});
}


