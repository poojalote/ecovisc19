// let profileImageData = null;


function exportPatientData() {
	let type = $("#allPatient").val();
	if (type === "") {
		type = 1;
	}
	window.location.href = baseURL + "exportData/" + type;
}

function validation(x) {

	var regexp = /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/;
	return regexp.test(x);
}

function mobileValidation(x) {

	var regexp = /^[6-9]\d{9}$/;
	return regexp.test(x);
}

$(document).ready(function () {
	localStorage.setItem("leftsidebar",1);
	get_lableftsidebar();
	loadPatients();

	$.validator.addMethod("uniqueUserID", function (value, element) {
		let valueResult = validation(value);
		console.log(valueResult, value);
		return valueResult;
	}, "Invalid Aadhar Number");
	$.validator.addMethod("mobileValidation", function (value, element) {
		let valueResult = mobileValidation(value);
		console.log(valueResult, value);
		return valueResult;
	}, "Number with Country Code");
	if (document.getElementById('adhhar_no') && document.getElementById('contact')) {
		app.setValidation('adhhar_no', {uniqueUserID: true});
		app.setValidation('contact', {mobileValidation: true});
	}
	var dt = new Date();
	var month = dt.getMonth() + 1;
	var day = dt.getDate();

	var output = dt.getFullYear() + '-' +
		(month < 10 ? '0' : '') + month + '-' +
		(day < 10 ? '0' : '') + day + " 00:00:00";
	let mode = parseInt($("#patientId").val());
	if (document.getElementById("admission_date")) {
		if (mode === 0) {
			document.getElementById("admission_date").min = app.getDate(output);


		}
	}
	get_zone_id();
	$("#history_modal").on('hide.bs.modal', function (e) {
		$("#DataView").empty();
		$("#panel-bodyRR").empty();
	});

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

function patientModalName() {
	window.location.href = base_url + 'admin/new_patients';
}

function loadPatientsZoneWise(zoneid, companyId = null) {
	let type = $("#allPatient").val();
	if (type === "") {
		type = 1;
	}
	app.dataTable('patientTable', {
		url: baseURL + "getPatientTableDataZone",
		data: {zoneid: zoneid, companyId: companyId, type: type}
	}, [
		{
			data: 0,
			render: (d, t, r, m) => {
				return `<button class="btn btn-link" onclick="get_modal_view(${r[5]})><i class="fa fa-plus"></i></button>`;
			}
		},
		{
			data: 1,
		},
		{
			data: 2
		},
		{
			data: 3
		},
		// {
		// 	data: 12
		// },
		// {
		// 	data: 4
		// },
		{
			data: 5,
			render: (d, t, r, m) => {
				return `<div>${r[10]}</div>`;
			}
		},
		{
			data: 11
		},
		{
			data: 6,
			render: (d, t, r, m) => {
				if (parseInt(r[10]) === 1) {
					return `<div class="btn-group"><a class="btn btn-primary " type="button"
		   data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
		   href="${baseURL + 'new_patients/' + r[5]}"
>
	<i class="fas fa-pen"></i>
</a>
<button class="btn btn-danger btn-action trigger--fire-modal-1" type="button"
		onclick="deletePatient(${r[5]})">
	<i class="fas fa-trash"></i>
</button></div>`;
				} else {

					if (parseInt(r[13]) === 1) {
						return ` <div class="btn-group"> <a class="btn btn-link " type="button"
		   data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
		   href="${baseURL + 'new_patients/' + r[5]}"
>
	<!--                               			  <i class="fas fa-pen"></i>-->

	<img src="${baseURL + 'assets/img/aadhaar_Logo.svg.png'}" style="width: 24px;height: 24px">
</a>
<button class="btn btn-link " type="button"
		data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"

		onclick="loadPatient(${r[5]},'${r[1]}','${r[0]}','${r[2]}','${r[8]}','${r[10]}','${r[9]}','${r[15]}','${r[6]}')"
>
	<img src="${baseURL + 'assets/img/sleeping.svg'}" style="width: 24px;height: 24px">
</button></div>
`;
					} else {
						return `<span>NA</span>`;
					}
				}
			}
		},
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(0)', nRow).html(`<button class="btn btn-link" onclick="get_modal_view(${aData[5]})"><i class="fa fa-plus"></i></button>${aData[0]}`);
		$('td:eq(2)', nRow).html(`<div>${aData[2]}</div>`);
		$('td:eq(4)', nRow).html(`<div>${aData[10] !== null && aData[10] !== '0000-00-00 00:00:00' ? aData[10] : '-'}</div>`);
		if (parseInt(aData[10]) === 1) {
			$('td:eq(6)', nRow).html(`<div class="btn-group"><a class="btn btn-primary" type="button"
							 data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
							 href="${baseURL + 'new_patients/' + aData[5]}"
>
	<i class="fas fa-pen"></i>
</a>
<button class="btn btn-danger btn-action trigger--fire-modal-1" type="button"
		onclick="deletePatient(${aData[5]})">
	<i class="fas fa-trash"></i>
</button>
<a class="btn btn-link" href="${baseURL + 'get_patient_data/' + aData[5]}" target="_blank" ><i class="fa fa-download"></i></a>
</div>
`);
//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		} else {

			if (parseInt(aData[13]) === 1) {
				$('td:eq(6)', nRow).html(`<div class="btn-group"><a class="btn btn-link" type="button"
							 data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
							 href="${baseURL + 'new_patients/' + aData[5]}"
>

	<img src="${baseURL + 'assets/img/aadhaar_Logo.svg.png'}" style="width: 24px;height: 24px">
</a>
<button class="btn btn-link" type="button"
		data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"

		onclick="loadPatient(${aData[5]},'${aData[1]}','${aData[0]}','${aData[2]}','${aData[8]}','${aData[10]}','${aData[9]}','${aData[15]}','${aData[6]}')"
>
	<img src="${baseURL + 'assets/img/sleeping.svg'}" style="width: 24px;height: 24px">
</button>
<a class="btn btn-link"  href="${baseURL + 'get_patient_data/' + aData[5]}" target="_blank" ><i class="fa fa-download"></i></a></div>
`);

			} else {
				return `<span>NA</span>`;
			}
//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		}

	})
}

function loadPatients(type = 1, companyId = null) {

// })
// app.dataTable('patientTable', {
// 		url: baseURL + "getPatientTableData",
// 		data: {type: type, companyId: companyId}
// 	},
	let zoneid = $("#zoneDetails").val();

	$('#patientTable').DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		order: [],
		"pagingType": "simple_numbers",
		ajax: {
			url: baseURL + "getLabPatientTableData",
			type: "POST",
			data: {type: type, companyId: companyId, zoneid: zoneid}
		},

		columns: [
			{
				data: 0,
			},
			{
				data: 1,
			},
			{
				data: 2
			},
			{
				data: 3
			},
			// {
			// 	data: 12
			// },
			// {
			// 	data: 4
			// },

			{
				data: 5,
				render: (d, t, r, m) => {
					return `<div>${r[10]}</div>`;
				}
			},
			{
				data: 11
			},
			{
				data: 6,
				render: (d, t, r, m) => {
					if (parseInt(r[10]) === 1) {
						return `<div class="btn-group"><a class="btn btn-primary" type="button"
		   data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
		   href="${baseURL + 'lab_patient/' + r[5]}"
>
	<i class="fas fa-pen"></i>
</a>
<button class="btn btn-danger btn-action trigger--fire-modal-1" type="button"
		onclick="deletePatient(${r[5]})">
	<i class="fas fa-trash"></i>
</button></div>`;
					} else {

						if (parseInt(r[13]) === 1) {
							if(type ==4){
								var del_btn="<button class='btn btn-link' onclick='delete_patient("+r[5]+")'><i class='fa fa-trash'></i></button>";
							}else{
								var del_btn="";
							}
							return `<div class="btn-group"><a class="btn btn-link" type="button"
		   data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
		   href="${baseURL + 'lab_patient/' + r[5]}"
>
	<!--                               			  <i class="fas fa-pen"></i>-->

	<img src="${baseURL + 'assets/img/aadhaar_Logo.svg.png'}" style="width: 24px;height: 24px">
</a>
<button class="btn btn-link " type="button"
		data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"

		onclick="loadPatient(${r[4]},'${r[1]}','${r[0]}','${r[2]}','${r[7]}','${r[9]}','${r[8]}','${r[13]}','${r[5]}')"
>
	<img src="${baseURL + 'assets/img/sleeping.svg'}" style="width: 24px;height: 24px">
</button>${del_btn}</div> 
<a class="btn btn-link"  href="${baseURL + 'get_labpatient_data/' + r[5]}" target="_blank" ><i class="fa fa-download"></i></a>
${del_btn}

</div>
`;
						} else {
							return `<span></span>`;
						}
					}
				}
			},
		],
		fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			$('td:eq(0)', nRow).html(`${aData[0]}`);
			$('td:eq(2)', nRow).html(`<div>${aData[2]}</div>`);
			$('td:eq(4)', nRow).html(`<div>${aData[10] !== null && aData[10] !== '0000-00-00 00:00:00' ? aData[10] : '-'}</div>`);
			if (parseInt(aData[10]) === 1) {
				$('td:eq(6)', nRow).html(`<div class="btn-group"><a class="btn btn-primary " type="button"
							 data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
							 href="${baseURL + 'lab_patient/' + aData[5]}"
>
	<i class="fas fa-pen"></i>
</a>
<button class="btn btn-danger btn-action trigger--fire-modal-1" type="button"
		onclick="deletePatient(${aData[5]})">
	<i class="fas fa-trash"></i>
</button>
<a class="btn btn-link" href="${baseURL + 'get_labpatient_data/' + aData[5]}" target="_blank" ><i class="fa fa-download"></i></a></div>
`);
			} else {
				if(type ==4){
					var del_btn="<button class='btn btn-link' onclick='delete_patient("+aData[5]+")'><i class='fa fa-trash'></i></button>";
				}else{
					var del_btn="";
				}
				if (parseInt(aData[13]) === 1) {
					$('td:eq(6)', nRow).html(`<div class="btn-group"><a class="btn btn-link" type="button"
							 data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"
							 href="${baseURL + 'lab_patient/' + aData[5]}"
>

	<img src="${baseURL + 'assets/img/aadhaar_Logo.svg.png'}" style="width: 24px;height: 24px">
</a>
<button class="btn btn-link" type="button"
		data-toggle="tooltip" data-placement="left" title data-original-title="View Detail"

		onclick="loadPatient(${aData[4]},'${aData[1]}','${aData[0]}','${aData[2]}','${aData[7]}','${aData[9]}','${aData[8]}','${aData[13]}','${aData[5]}')"
>
	<img src="${baseURL + 'assets/img/sleeping.svg'}" style="width: 24px;height: 24px">
</button>
<a class="btn btn-link"  href="${baseURL + 'get_labpatient_data/' + aData[5]}" target="_blank" ><i class="fa fa-download"></i></a>
${del_btn}

</div>
	
`);
				} else {
					return `<span></span>`;
				}
			}

		}
	});


}

function loadPatient(id, name, adhar_number, contract, profile, admissionDate, mode, type,icu) {
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
	localStorage.setItem("leftsidebar", 2);
	let object ={"patient_id":id,"branch_id":session_branch_id};
	let string = btoa(JSON.stringify(object));
	window.location.href = baseURL + "labpatient_report/22/136/"+string;
}

$("#patientForm").validate({

	rules: {
		name: 'required',
		contact: 'required',
		birth_day: 'required',
		blood_group: 'required'
	},
	messages: {
		name: "Enter Patient Name",
		contact: "Enter contact number",
		birth_day: 'Enter birth date',
		blood_group: 'select blood group'
	},
	errorElement: 'span',

	submitHandler: function (form) {
// $.LoadingOverlay("show");

		var form_data = document.getElementById('patientForm');
		var Form_data = new FormData(form_data);
		$.ajax({
			type: "POST",
			url: baseURL + 'saveLabPatient',
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				console.log('byeeee');
				app.successToast(result);
				$.LoadingOverlay("hide");
				if (result.status === 200) {

					app.successToast(result.data);

					$('#patientForm').trigger('reset');

					$('#patientForm')[0].reset();
					// window.location.href = baseURL+"patient_info";
					// loadPatients(1);
// modalName();
				} else {
					app.errorToast(result.data);
				}
			},
			error: function (error) {
// $.LoadingOverlay("hide");
				app.errorToast("something went wrong please try again");
			}
		});
	}
});

function get_PatientDataById(patientId) {

	$.LoadingOverlay("show");
	serverRequest(baseURL+"getPatientData", {patientId: patientId}).then(response => {

		$.LoadingOverlay("hide");
		if (response.status === 200) {
			var user_data = response.body;

			if (user_data[0]['id'] != null && user_data[0]['id'] != '') {

				$("#patientId").val(user_data[0]['id']);
				$("#admission_date").attr("min", "");
			}
			if (user_data[0]['adhar_no'] != null && user_data[0]['adhar_no'] != '') {
				$("#adhhar_no").val(user_data[0]['adhar_no']);

			}
			if (user_data[0]['patient_name'] != null && user_data[0]['patient_name'] != '') {
				$("#name").val(user_data[0]['patient_name']);

			}
			if (user_data[0]['gender'] != null && user_data[0]['gender'] != '') {
				let comp = user_data[0]['gender'];
				if (comp == 1) {
					var male = document.getElementById("maleRadio");
					male.checked = true;
//$("#maleRadio input[name='gender']").prop("checked", true);
				} else {
					var female = document.getElementById("femaleRadio");
					female.checked = true;
//$("#femaleRadio input[name='gender']").prop("checked", true);
				}
			}
			if (user_data[0]['birth_date'] != null && user_data[0]['birth_date'] != '') {
				$("#dob").val(user_data[0]['birth_date']);

			}
			if (user_data[0]['blood_group'] != null && user_data[0]['blood_group'] != '') {
				let blood = user_data[0]['blood_group'];

				$("#bloodGroup option[value='" + blood + "']").prop("selected", true);


			}
			if (user_data[0]['contact'] != null && user_data[0]['contact'] != '') {
				$("#contact").val(user_data[0]['contact']);

			}
			if (user_data[0]['other_contact'] != null && user_data[0]['other_contact'] != '') {
				$("#other_contact").val(user_data[0]['other_contact']);

			}
			if (user_data[0]['address'] != null && user_data[0]['address'] != '') {
				$("#loc").val(user_data[0]['address']);

			}
			if (user_data[0]['district'] != null && user_data[0]['district'] != '') {
				$("#dist").val(user_data[0]['district']);

			}
			if (user_data[0]['sub_district'] != null && user_data[0]['sub_district'] != '') {
				$("#subdist").val(user_data[0]['sub_district']);

			}
			if (user_data[0]['pin_code'] != null && user_data[0]['pin_code'] != '') {
				$("#pc").val(user_data[0]['pin_code']);

			}

			if (user_data[0]['admission_date'] != null && user_data[0]['admission_date'] != '') {
				let date = app.getDate(user_data[0]['admission_date']);
				$("#admission_date").val(date);

			}



		} else {
			app.errorToast('data not found ');
		}

	}).catch(error => console.log(error));
}

function deletePatient(patientId) {
	$.LoadingOverlay("show");
	serverRequest("deleteLabPatient", {patientId: patientId}).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {
			app.successToast(result.body);
			loadPatients();
		} else {
			app.errorToast(result.body);
		}
	}).catch(error => console.log(error));
}

function search() {
	var id = $('#adhhar_no').val();

	$.ajax({
		type: 'POST',
		url: baseURL + "patientSearch",
		data: {adhar_no: id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				if(success.hasOwnProperty("messageBody")){
					app.errorToast(success.messageBody);
				}

				var user_data = success.body;
				if (user_data.length > 0) {
					get_PatientDataById(user_data[0]['id']);
				}
			} else {
				app.errorToast(success.messageBody);
			}

		}

	});

}

function cap_image() {
	document.getElementById("my_camera").style.display = "block";

	Webcam.set({
		width: 320,
		height: 320,
		image_format: 'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach('#my_camera');
	document.getElementById("cap_btn").style.display = "block";
}

function take_snapshot() {
	Webcam.snap(function (data_uri) {
		if (data_uri) {
			document.getElementById('results').innerHTML =
				`<div class="profile-widget-header">
	<img alt="image" id="patient_profile1" src="${data_uri}" class="rounded-circle profile-widget-picture" style="box-shadow: 0 4px 8px rgb(0 0 0 / 3%); width: 120px;height:120px;position: relative;z-index: 1;">
</div>`;
			document.getElementById("my_camera").style.display = "none";
			document.getElementById("cap_btn").style.display = "none";
			document.getElementById('p_img').value = data_uri;
		}
// saveSnap();

	});
	Webcam.reset();
}

function saveSnap() {
// Get base64 value from <img id='imageprev'> source
	var base64image = document.getElementById("imageprev").src;
// console.log(base64image);

	Webcam.upload(base64image, baseURL + 'patientController/upload_file', function (code, text) {
// console.log('Save successfully');
		console.log(text);
		$("#p_img").val(text);

	});

}

function take_snapshot_aadhar() {
	Webcam.snap(function (data_uri) {
		document.getElementById('results1').innerHTML =
			'<img id="imageprev1" src="' + data_uri + '"/>';
		saveSnap_aadhar();

	});

	Webcam.reset();
}

function saveSnap_aadhar() {
// Get base64 value from <img id='imageprev'> source
	var base64image = document.getElementById("imageprev1").src;
// console.log(base64image);

	Webcam.upload(base64image, baseURL + 'patientController/upload_file_aadhar', function (code, text) {
// console.log('Save successfully');
		var image = $("#addhar_img").val();
		if (image == "") {
			$("#addhar_img").val(text);
			cap_image1();

			function cap_image1() {
				document.getElementById("my_camera1").style.display = "block";

				Webcam.set({
					width: 320,
					height: 240,
					image_format: 'jpeg',
					jpeg_quality: 90
				});
				Webcam.attach('#my_camera1');
				document.getElementById("cap_btn1").style.display = "block";
			}
		} else {
			var image2 = image + "," + text;
			$("#addhar_img").val(image2);
			document.getElementById("vidscan1").style.display = "none";
			document.getElementById("overlay1").style.display = "none";
		}
// console.log(text);


	});

}


function get_pdf(id) {
	$.ajax({
		type: 'POST',
		url: baseURL + "get_patient_data",
		data: {id: id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.body;
				get_PatientDataById(user_data[0]['id']);
//console.log(success.body);
			} else {

			}

		}

	});
}

function get_zone_id() {
//zoneDetails

	$.ajax({
		type: 'POST',
		url: baseURL + "getZoneData",
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.data;
				$("#zoneDetails").html(user_data);
//console.log(success.body);
			} else {

			}

		}

	});
}

function get_modal_view(p_id) {
	$("#history_modal").modal('show');
	$("#pat_id").val(p_id);
	$.ajax({
		type: 'POST',
		url: baseURL + "getPatientHistoryData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.code == 200) {
				var user_data = success.data;
				$("#DataView").html(user_data);
				getCriticalParaData(p_id);
//console.log(success.body);
			} else {

			}

		}

	});

}

function getCriticalParaData(p_id){
	//alert();
	$.ajax({
		type: 'POST',
		url: baseURL + "FormController/getCriticalParaData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.code == 200) {
				var user_data = success.data_li;
				var content_data = success.data_body;
				$("#myTab4").append(user_data);
				$("#myTab2Content").append(content_data);
//console.log(success.body);
			} else {

			}

		}

	});
}

function get_data_critical(p_id){
	//getlabreportFrequentlyUsed
	$.ajax({
		type: 'POST',
		url: baseURL + "getlabreportFrequentlyUsed",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {

				var content_data = success.data;

				$("#panel-bodyCP").html(content_data);
//console.log(success.body);
			} else {

			}

		}

	});

}

function get_TableData(section_id, patient_id, table) {
	//getHistoryTemplate
	$.ajax({
		type: 'POST',
		url: baseURL + "get_history_data",
		data: {section_id: section_id, patient_id: patient_id, table_name: table},
		success: function (success) {
			success = JSON.parse(success);


			var user_data = success.table;

			$("#panel-body"+section_id).html(user_data);
			if(section_id == 2){
				$("#history_table_"+section_id).dataTable(
					{
						"order": [[ 9, "desc" ]]
					}
				);
			}else{
				$("#history_table_"+section_id).dataTable();
			}


//console.log(success.body);

		}

	});

}

function get_RadiologyTableData() {
	var p_id = $("#pat_id").val();
	$.ajax({
		type: 'POST',
		url: baseURL + "getRadiologyData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			if (success.status == 200) {

				$("#panel-bodyRR").html(user_data);
				$("#rad_table").dataTable();
//console.log(success.body);
			} else {
				$("#panel-bodyRR").html(user_data);
				$("#rad_table").dataTable();
			}

		}

	});
}

function load_medicine_history(p_id) {
	let formData = new FormData();
	formData.set("patient_id", p_id);
	app.request(baseURL + "load_patient_medicine_history", formData).then(res => {
		if(res.status === 200){
			$("#history_table_section").empty();
			$("#history_table_section").append(res.body);
		}else{

		}

	})
}

function delete_patient(p_id){
	let formData = new FormData();
	formData.set("patientId", p_id);
	app.request(baseURL + "delete_Patient", formData).then(res => {
		if(res.status === 200){
			app.successToast(res.body);
			loadPatients(4);
		}else{
			app.errorToast(res.body);
		}

	})
}

$('#rescheduleMedicine').on('show.bs.modal', function (e) {
	let medicine_id = $(e.relatedTarget).data('medicine_id');
	let reschedule_date = $(e.relatedTarget).data('reschedule_date');
	let alreadyGivenDoesCount = parseInt($(e.relatedTarget).data('alreadygivendoescount'));
	var input = document.getElementById("per_day_schedule");

	let options=``;
	for(let i =1;i<=5;i++){
		let disable = `disabled`;
		if(alreadyGivenDoesCount>=i){
			options+=`<option ${disable} value="${i}">${i}</option>`
		}else{
			options+=`<option value="${i}">${i}</option>`
		}
	}
	$("#per_day_schedule").empty();
	$("#per_day_schedule").append(options);
	//per_day_schedule
	//$("#per_day_schedule").attr({"min" : alreadyGivenDoesCount});
	var patient_id=	$("#pat_id").val();
	app.formValidation();
	$("#reschedule_medicine_id").val(medicine_id);
	$("#reschedule_date").val(reschedule_date);
	$("#reschedule_patient").val(patient_id);

});

function rescheduleMedicine(form) {
	app.request(baseURL + "saveRescheduleMedicine", new FormData(form)).then(res => {
		if (res.status === 200) {
			app.successToast(res.body);
			$("#editRescheduleForm").trigger('reset');
			$("#rescheduleMedicine").modal("hide");
			var patient_id=	$("#pat_id").val();
			load_medicine_history(patient_id);

			//let patient_id = localStorage.getItem("patient_id");
			//load_medicine_history(patient_id);
		} else {
			app.errorToast(res.body);
		}
	}).catch(error => console.log(error));
}
