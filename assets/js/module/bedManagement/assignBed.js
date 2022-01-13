$(document).ready(function () {
	getRooms();
	var patient_id = localStorage.getItem("patient_id");
	update_user(patient_id);
	getpatientBedHistoryTable(patient_id);
	get_bed_type();
	check_billing_status();
});
function check_billing_status(){
	var p_id = localStorage.getItem("patient_id");
	$.ajax({
            type: "POST",
            url: baseURL + "check_billing_status",
            dataType: "json",
            async: false,
            cache: false,
			data:{p_id},
            success: function (result) {
               
                if (result.status == 200) {
					var value=result.value;
                   if(value == 1){
					   
					   $("#assign_bed_btn").prop('disabled', true);
					   $("#check_order_btn").prop('disabled', true);
				   }else{
					    $("#assign_bed_btn").prop('disabled', false);
					    $("#check_order_btn").prop('disabled', false);
				   }
                } else {
					
                }
            }
        });
}
$('#newPatientForm').validate({
	rules: {
		u_Id: {
			required: true,
			uniqueUserID: true
		},
		name: {
			required: true
		},
	
		b_bed:{
			required: true
		}
	},
	messages: {
		u_Id: {
			required: "Please Unique Id"
		},
		name: {
			required: "Please Name"
		},
		
		b_bed:{
			required: "Please Select Bed"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "add_Patient_number",
			dataType: "json",
			data: $('#newPatientForm').serialize(),
			success: function (result) {
				if (result.status === 200) {
					getpatientBedHistoryTable(localStorage.getItem("patient_id"));
					if (result.id !== null) {
						if ($('#p_id').val() == '') {
							$('#patient_id_nam_1').val(result.id.id);
							$('#patient_id_nam').val(result.id.adhar_no);
							//$('#newPatientForm').trigger('reset');
							//$('#newPatientModal').modal('toggle');
							//$('#p_dataTable_row').hide();
							// $("#create_module").show();
							// $('#profile_collapse_card').show();
							// $('#profile_collapse').show();
							// $("#ttt").show();
							// view_form(1);
						} else {
							$('#p_id').val('');
							// showPaitintDetials();
							//  $('#newPatientForm').trigger('reset');
							// $('#newPatientModal').modal('toggle');

						}
					}
					app.successToast(result.body);
				}
				$.LoadingOverlay("hide");

			}, error: function (error) {
				console.log('Logged ---> ', error);
				$.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});

function deletePaitent(p_id) {
	new Promise((resolve, reject) => {
		$.ajax({
			type: "post",
			url: baseURL + 'deletePaitent',
			data: {p_id: p_id},
			dataType: "json",
			success: function (result) {
				resolve(result);
			},
			error: function (error) {
				reject(error);
			}
		});
	}).then(result => {
		if (result.status === 200) {
			app.successToast(result.body);
			// $('#newPatientModal').modal('hide');
			// showPaitintDetials();
		} else {
			app.errorToast(result.body);
		}

	}).catch(error => {
		console.log(error);
		app.errorToast('Something went wrong');
	});
}

function getpatientBedHistoryTable(p_id) {
	// var p_id = $('#p_id').val();

	app.dataTable('patientBedHistoryTable', {
		url: baseURL + "getPatientBedHistoryTableData",
		data: {p_id: p_id}
	}, undefined, (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		let date = aData[2];


		$('td:eq(0)', nRow).html(`${aData[0]}`);

		$('td:eq(1)', nRow).html(`${aData[1]}`);


		$('td:eq(2)', nRow).html(`${date}`);

	})

}

$('#hroom').change(function () {
	getBeds($(this).val());
});

function getBeds(id, selected = '') {
	new Promise((resolve, reject) => {
		$.ajax({
			type: "post",
			url: baseURL + 'getBedOptions',
			data: {room_id: id},
			dataType: "json",
			success: function (result) {
				resolve(result);
			},
			error: function (error) {
				reject(error);
			}
		});
	}).then(result => {
		if (result.status === 200) {
			if (selected == '') {
				$('#sBed').show();
				$('#b_bed').empty();
				$('#b_bed').append(result.body);
			} else {
				$('#sBed').show();
				$('#b_bed').empty();
				$('#b_bed').append(result.body);

			}

		} else {
			$('#b_bed').empty();
			$('#b_bed').append(result.body);
		}
	}).catch(e => {
		console.log('Logged ---> ', error);
		alert('something went wrong');
	});
}

function getRooms() {
	new Promise((resolve, reject) => {
		$.ajax({
			type: "post",
			url: baseURL + "getRoomOptions",
			dataType: "json",
			success: function (result) {
				resolve(result);
			},
			error: function (error) {
				reject(error);
			}
		});
	}).then(result => {
		if (result.status === 200) {
			$('#hroom').empty();
			$('#hroom').append(result.body);
		} else {
			$('#hroom').empty();
			$('#hroom').append(result.body);
		}
	}).catch(e => {
		console.log('Logged ---> ', error);
		alert('something went wrong');
	});
}

function update_user(id) {
	$.ajax({
		type: "post",
		url: baseURL + "get_user_name",
		data: {'id': id},
		dataType: "json",
		success: function (success) {
			if (success.status == 200) {
				var data = success.body[0];
				//console.log(data);
				// $('#newPatientModal').modal('show');
				$('hBed').show();
				$('#btnDelete').show();
				$('#u_Id').val(data.adhar_no);
				$('#name').val(data.patient_name);
				$('#p_id').val(data.id);
				$('#hroom').val(data.roomid);
				// $('#bed_id').val(data.bed_id);
				getBeds(data.roomid, data.bed_id);
				unicValidationUpdate();
				$('#u_Id').rules('remove', 'uniqueUserID');
				$('#u_Id').rules('add', 'uniqueUserIDUpdate');
				// $('#u_Id').attr('readonly',true);
			} else {

			}
		},
		error: function (error) {

		}
	});
}

function unicValidation() {
	$.validator.addMethod("uniqueUserID", function (value, element) {
		$.ajax({
			url: baseURL + "isUnique",
			data: {u_Id: value},
			type: "post",
			dataType: "json",
			async: false,
			success: function (msg) {
				console.log(msg);
				isSuccess = msg === true ? true : false;
			}
		});
		console.log(isSuccess);
		return isSuccess;
	}, "Id already exists");
}

function unicValidationUpdate() {
	var p_id = $('#p_id').val();
	$.validator.addMethod("uniqueUserIDUpdate", function (value, element) {
		$.ajax({
			url: baseURL + "isUniqueUpdate",
			data: {u_Id: value, 'p_id': p_id},
			type: "post",
			dataType: "json",
			async: false,
			success: function (msg) {
				console.log(msg);
				isSuccess = msg === true ? true : false;

			}
		});
		console.log(isSuccess);
		return isSuccess;
	}, "Id already exists");
}

function get_bed_type(){
		 $.ajax({
            type: "POST",
            url: baseURL + "get_bed_type",
            dataType: "json",
            async: false,
            cache: false,
            success: function (result) {
                var data = result.data;
                if (result.status == 200) {
                  
					   $("#service_id").html(data);
                } else {
						
                }
            }
        });
	}
