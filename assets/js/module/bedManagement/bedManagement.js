$(document).ready(function () {
	get_roomdetailstable();
	get_zone_id();
	getZoneData1();
});


function loadPatient(id, name, adhar_number, contract, profile, admissionDate, mode) {
	localStorage.setItem("patient_id", id);
	localStorage.setItem("patient_name", name);
	localStorage.setItem("patient_adharnumber", adhar_number);
	localStorage.setItem("patient_contact", contract);
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


	window.location.href = baseURL + "patient/dashboard";
}

function deactiveBed(id, status) {
	let newStatus;
	if (status === 1) {
		newStatus = 0;
	} else {
		newStatus = 1;
	}
	let formData = new FormData();
	formData.set("id", id);
	formData.set("status", newStatus);
	formData.set("bedStatus", status);
	app.request(baseURL + "updateBedActiveStatus", formData).then(res => {
		if (res.status === 200) {
			app.successToast(res.body);
			get_roomdetailstable();
		} else {
			app.errorToast(res.body);
		}
	});

}

//Show Room Details
function get_flag_data(room_id,bed_id){
	$.ajax({
		type: "POST",
		url: baseURL + "BedManagementController/get_flag_data",
		dataType: "json",
		async: false,
		cache: false,
		data:{room_id,bed_id},
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			} else {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			}
		}
	});
}
function get_roomdetailstable(id="") {
	var bloodtest=$("#bloodtest").val();
	var vitalsign=$("#vitalsign").val();
	if(id==""){
		var id=$("#zoneDetails").val();
	}
	$.ajax({
		type: "POST",
		url: baseURL + "get_roomdetails_info",
		dataType: "json",
		async: false,
		cache: false,
		data:{id,bloodtest,vitalsign},
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			} else {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			}
		}
	});
}
function get_icuroomdetailstable() {
	$.ajax({
		type: "POST",
		url: baseURL + "get_roomdetails_info_icu",
		dataType: "json",
		async: false,
		cache: false,
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			} else {
				$('#show_room_details').empty();
				$('#show_room_details').append(data);
			}
		}
	});
}
function get_zone_id() {
//zoneDetails

	$.ajax({
		type: 'POST',
		url: baseURL + "BedManagementController/getZoneData",
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.data;
				$("#zoneDetails1").html(user_data);
//console.log(success.body);
			} else {

			}

		}

	});
}
function getZoneData1() {
//zoneDetails

	$.ajax({
		type: 'POST',
		url: baseURL + "BedManagementController/getZoneData1",
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

//Delete Individual Room

//delete individual Room
function delete_room(id) {
	var result = confirm("Do You Want to delete?");
	if (result) {
		$.ajax({
			url: baseURL + "delete_room",
			type: "POST",
			data: {id: id},
			cache: false,
			async: false,
			success: function (success) {
				success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					get_roomdetailstable();
				} else {
					app.errorToast(success.body); //toster.error
				}
			},
			error: function (error) {
				app.errorToast("something went to wrong");
			}
		});
	} else {
	}
}

function add_bed_btn() {

	let	id= $("#zoneDetails1").val();
	
	
	$("#room_id").val(id);
	get_bedtailstable();
}

$("#add_room_form").validate({
	rules: {
		room_no: {required: true},
		ward_no: {required: true},
		room_cat: {required: true},
	},
	messages: {
		room_no: {required: "Enter Room No"},
		ward_no: {required: "Enter Ward No"},
		room_cat: {required: "Select Room Type"},

	}, errorElement: "span",
	submitHandler: function (form) { // for demo
		$.ajax({
			url: baseURL + "add_room_info",
			type: "POST",
			data: $("#add_room_form").serialize(),
			success: function (success) {
				success = JSON.parse(success);
				if (success.status === true) {
					app.successToast("Room added  Successfully.");
					get_roomdetailstable();
					get_zone_id();
					getZoneData1();
					$("#add_room_form")[0].reset();
				} else {
					app.errorToast(success.body); //toster.error
				}
			},
			error: function (error) {
				// app.errorToast(success.body);
				console.log(error);
				app.errorToast("something went to wrong.");
			}
		});
	}
});

function remove_error(id) {
	$('#' + id + '_error').html("");
}

function get_bedtailstable() {
	var room_id = document.getElementById("room_id").value;
	var category = document.getElementById("category").value;
	
	$.ajax({
		type: "POST",
		url: baseURL + "get_bedetails_info",
		dataType: "json",
		data: {room_id: room_id,category:category},
		async: false,
		cache: false,
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#bed_data').html(data);
			} else {
				$('#bed_data').html(data);
			}
		}
	});
}

//Add Bed Room for Rooms
$("#add_bed_form").validate({
	rules: {
		bed_a1: {required: true},
		zoneDetails1: {required: true}
	},
	messages: {
		bed_a1: {required: "Enter Bed Name"},
		zoneDetails1: {required: "Select Zone"}

	}, errorElement: "span",
	submitHandler: function (form) { // for demo
		$.ajax({
			url: baseURL + "add_bedroom_info",
			type: "POST",
			data: $("#add_bed_form").serialize(),
			success: function (success) {
				success = JSON.parse(success);
				if (success.status === true) {
					app.successToast("BedRoom added  Successfully.");
					//get_bedtailstable();
					get_roomdetailstable();
					$("#add_bed_form")[0].reset();
					$("#zoneDetails1").val('');
					$("#bed_data").empty();
					$("#fire-modal-bedManagement").modal('hide');
				} else {

					app.errorToast(success.body);
				}
			},
			error: function (error) {
				//app.errorToast(success.body);
				console.log(error);
				app.errorToast("something went to wrong.");
			}
		});
	}
});

//Show Bed Details

function get_bedtailstable() {
	var room_id = document.getElementById("zoneDetails1").value;
	
	$.ajax({
		type: "POST",
		url: baseURL + "get_bedetails_info",
		dataType: "json",
		data: {room_id: room_id},
		async: false,
		cache: false,
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#bed_data').html(data);
			} else {
				$('#bed_data').html(data);
			}
		}
	});
}


function delete_bed(id) {
	var result = confirm("Do You Want to delete?");
	if (result) {
		$.ajax({
			url: baseURL + "delete_bed",
			type: "POST",
			data: {id: id},
			cache: false,
			async: false,
			success: function (success) {
				success = JSON.parse(success);
				if (success.status == 200) {
					app.successToast(success.body);
					get_bedtailstable();
				} else {
					app.errorToast(error.body);
				}
			},
			error: function (error) {
				console.log(error);
				app.errorToast("something went to wrong");
			}
		});
	} else {

	}
}

function get_occupiedroomdetailstable(id="") {
	var bloodtest=$("#bloodtest").val();
	var vitalsign=$("#vitalsign").val();
	if(id==""){
		var id=$("#zoneDetails").val();
	}
	$.ajax({
		type: "POST",
		url: baseURL + "get_occupiedroomdetails_info",
		dataType: "json",
		async: false,
		cache: false,
		data:{id,bloodtest,vitalsign},
		success: function (result) {
			var data = result.result_sal;
			if (result.status == 200) {
				$('#show_occupiedroom_details').empty();
				$('#show_occupiedroom_details').append(data);
			} else {
				$('#show_occupiedroom_details').empty();
				$('#show_occupiedroom_details').append(data);
			}
		}
	});
}