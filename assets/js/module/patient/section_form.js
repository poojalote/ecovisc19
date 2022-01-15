//on readyState


// user in dynamic form submision
function save_form_data(form) {

	app.request(baseURL+"sectionSave",new FormData(form)).then(result=>{
		var firm_data = result.firm_data;

		if (result['code'] == '200') {
			app.successToast("Save Changes");
			if(result['is_history']==1)
			{
				let section_id=result['section_id'];
				$("#history_btn_"+section_id).click();
				$('#data_form_'+section_id)[0].reset();
				$('#data_form_'+section_id+' .custom-select').val(null).trigger("change");
			}
		} else {
			app.errorToast("Failed To Save Data")
		}
	}).catch(error=>{
		console.log(error)
		app.errorToast('Something went wrong please try again');
	})

}
// use in discharge form
function saveDischarge(form) {

	app.request(baseURL+"patientDischarge",new FormData(form)).then(result=>{
		if (result.status == 200) {
			app.successToast(result.body)
		} else {
			app.errorToast(result.body)
		}
	}).catch(error=>{
		console.log(error)
		app.errorToast('Something went wrong please try again');
	})

}
function getDischargeDetails(patientId) {

	let formData = new FormData();
	formData.set("patientId",patientId);
	app.request("https://c19.docango.com/new_patients/getPatientData", formData).then(response => {
		if (response.status === 200) {
			var user_data = response.body;
			if (user_data[0]['discharge_date'] != null && user_data[0]['discharge_date'] != '') {
				let date = app.getDate(user_data[0]['discharge_date']);
				$("#discharge_date").val(date);
			}
			if (user_data[0]['diagnostic'] != null && user_data[0]['diagnostic'] != '') {
				$("#patient_diagnostic").val(user_data[0]['diagnostic']);
			}
			if (user_data[0]['treated_hospital'] != null && user_data[0]['treated_hospital'] != '') {
				$("#patient_treated_hospital").val(user_data[0]['treated_hospital']);
			}
			if (user_data[0]['course_hospital'] != null && user_data[0]['course_hospital'] != '') {
				$("#patient_course_hospital").val(user_data[0]['course_hospital']);
			}
			if (user_data[0]['followup_date'] != null && user_data[0]['followup_date'] != '') {
				let date = app.getDate(user_data[0]['followup_date']);
				$("#patient_follow_up").val(date);
			}
			if (user_data[0]['swab_report'] != null && user_data[0]['swab_report'] != '') {
				let blood = user_data[0]['swab_report'];
				$("#patient_swab_report option[value='" + blood + "']").prop("selected", true);
			}
		} else {
			app.errorToast('data not found ');
		}
	});
}

function get_patient_details(){
	var patient_id=$("#patient_id").val();
	$.ajax({
		type: 'POST',
		url: baseURL + "getpatientdatadis",
		data: {p_id: patient_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var date = success.data;

				$("#admission_date").val( date.split(' ')[0]);
				$("#atime").val(date.split(' ')[1]);
				$("#medication_auto").val(success.medication);


			} else {

			}

		}

	});
}
function is_transfer_fun(id){
	if(id == 1){
		$("#transfer_section").show();
	}else{
		$("#transfer_section").hide();
	}
}
