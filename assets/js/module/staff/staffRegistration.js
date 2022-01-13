let profileImageData = null;


function exportPatientData() {
	let type = $("#allPatient").val();
	if(type ===""){
		type =1;
	}
	window.location.href = baseURL+"exportData/"+type;
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
	// loadPatients();
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
    var month = dt.getMonth()+1;
	var day = dt.getDate();

	var output = dt.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day+" 00:00:00";
	if(document.getElementById("admission_date")){
		document.getElementById("admission_date").min = app.getDate(output);
	}

	// get_zone_id();


	

});

get_profile_type();
	get_staff_zone();
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


function get_PatientDataById(patientId) {
	// get_profile_type();
	// get_staff_zone();
	$.LoadingOverlay("show");
	serverRequest(baseURL+"getPatientData", {patientId: patientId}).then(response => {

		$.LoadingOverlay("hide");
		if (response.status === 200) {
			var user_data = response.body;

			if (user_data[0]['id'] != null && user_data[0]['id'] != '') {

				$("#patientId").val(user_data[0]['id']);

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

				$("#blood_group option[value='" + blood + "']").prop("selected", true);


			}
			if (user_data[0]['staff_profile'] != null && user_data[0]['staff_profile'] != '') {
				let staff = user_data[0]['staff_profile'];
				let res = staff.split("|||");
				if(res.length>1)
				{

					var staff_profile_type=res[0];
					var type=res[1];
					var zone=res[2];
					$("#staff_profile option[value='" + staff_profile_type + "']").prop("selected", true);

					$("#staff_type option[value='" + type + "']").prop("selected", true);
					$("#staff_zone option[value='" + zone + "']").prop("selected", true);
					
				}

				


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

			
		


		} else {
			app.errorToast('data not found ');
		}

	}).catch(error => console.log(error));
}

function deletePatient(patientId) {
	$.LoadingOverlay("show");
	serverRequest("deletePatient", {patientId: patientId}).then(result => {
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
				var user_data = success.body;
				if(user_data.length > 0){
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





//////////////////----------------- staff registration --------------/////////////////

function get_profile_type() {
	$.ajax({
		type: 'POST',
		url: baseURL + "get_profile_type",
		data: '',
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.option;
				$("#staff_profile").empty('');
				$("#staff_profile").append(user_data);
			} else {
				console.log('Something went wrong');
			}

		}

	});
}
function get_staff_zone() {
	$.ajax({
		type: 'POST',
		url: baseURL + "get_staff_zone",
		data: '',
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.option;
				$("#staff_zone").empty('');
				$("#staff_zone").append(user_data);
			} else {
				console.log('Something went wrong');
			}

		}

	});
}

$("#patientForm").validate({

	rules: {
		staff_profile: 'required',
		name: 'required',
		contact: 'required',
		birth_day:'required',
		blood_group:'required'
	},
	messages: {
		staff_profile: 'select profile',
		name: "Enter Patient Name",
		contact: "Enter contact number",
		birth_day:'Enter birth date',
		blood_group:'select blood group'
	},
	errorElement: 'span',

	submitHandler: function (form) {
// $.LoadingOverlay("show");

		var form_data = document.getElementById('patientForm');
		var Form_data = new FormData(form_data);

		$.ajax({
			type: "POST",
			url: baseURL + 'saveStaff',
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {

// app.successToast(result);
				$.LoadingOverlay("hide");
				if (result.status === 200) {

					app.successToast(result.data);


					$('#patientForm').trigger('reset');

					$('#patientForm')[0].reset();

					// get_PatientDataById(localStorage.getItem("patient_id"));
					window.location.href = "https://covidcare.docango.com/"+"patient_info";
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
