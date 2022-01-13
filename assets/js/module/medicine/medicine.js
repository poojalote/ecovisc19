function loadMedicineOptions() {


	$("#prescription_medicine_list").select2(
		{
			ajax: {
				url: baseURL + "get-medicine",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Medicine Name",
				data: function (params) {

					let setValue = $('#group_name_medicine_prescription').val();

					return {
						type: setValue,
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response.body
					};
				},
				cache: true
			},
			minimumInputLength: 3
		}
	);
}

function loadMedicineOptionsE() {

	$("#eprescription_medicine_list").select2(
		{
			ajax: {
				url: baseURL + "get-medicine",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Medicine Name",
				data: function (params) {

					let setValue = $('#egroup_name_medicine_prescription').val();

					return {
						type: setValue,
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response.body
					};
				},
				cache: true
			},
			minimumInputLength: 3
		}
	);
}

function loadMedicineOptions1() {


	$("#medicine_list").select2(
		{
			ajax: {
				url: baseURL + "get-medicine",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Medicine Name",
				data: function (params) {
					let setValue = $('#group_name_medicine_schedule').val();
				
					return {
						type: setValue,
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response.body
					};
				},
				cache: true
			},
			minimumInputLength: 3
		}
	);
}

function load_medicine_history() {
	let formData = new FormData();
	formData.set("patient_id", window.localStorage.getItem("patient_id"));
	app.request(baseURL + "load_patient_medicine_history", formData).then(res => {
		if(res.status === 200){
			$("#history_table_section").empty();
			$("#history_table_section").append(res.body);
			$('#scrollMe')[0].scrollIntoView(true);

			$('.popoverData').popover();
		}else{

		}

	})
	// var element = document.getElementById("scrollMe"); 
	// element.scrollIntoView({behavior: "smooth"});

}

function loadDoctors(element = null, selected = null) {
	let formData = new FormData();
	formData.set("type", 2);
	app.request(baseURL + "get-users", formData).then(response => {

		let data = response.body;
		if (element == null) {
			$("#doctor_name_medicine_prescription").select2({
				data: data
			});
		} else {
			$("#" + element).select2({
				data: data
			});
			$("#" + element).val(selected).trigger('change');
		}


	})
}

function loadClassification() {

	let formData = new FormData();
	formData.set("type", 1);
	app.request(baseURL + "classification", formData).then(response => {

		let data = response.body;
		$("#classification_name_medicine").select2({
			data: data
		});
	})

}

function loadSubClassification(element, typeValue) {
	let formData = new FormData();
	if (typeValue === 1) {
		formData.set("type", "401 medicine")
	} else {
		formData.set("type", $('#classification_name_medicine').val());
	}
	app.request(baseURL + "sub-classification", formData).then(response => {

		let data = response.body;
		$("#" + element).select2({
			data: data
		});
	})

}

function loadUnitOfMeasure() {
	let formData = new FormData();
	formData.set("type", 112);
	app.request(baseURL + "unit_of_measure", formData).then(response => {
		$("#unit_of_measure").select2(
			{data: response.body});
	});
}

function show_div(id) {
	// add_medicine


	if (id == "add_medicine") {
		get_medicine_data_1();
	}
	if (id == "att_medicine") {
		var pID = $("#patient_list").val(); // paitint id
		get_medicine_data();
		getDoesDetails(pID);
		$('#medicine_list').select2();
	}
	var dtToday = new Date();
	$('#Start_Date_new').attr('min', max_date(dtToday));
}

function myFunction_1() {
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("medi_name");
	filter = input.value.toUpperCase();
	table = document.getElementById("myTable");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

function loadMedicine(element, value) {
	get_medicine_data(element, value);
}


function getMedicineGroup() {

	app.request(baseURL + "getMedicineGroup", null).then(response => {
		if (response.status !== 200) {
			app.errorToast("Medicine Group Not Found")
		}
		$('#group_name_medicine').empty();
		$('#group_name_medicine').append(response.body);
		$('#group_name_medicine_schedule').empty();
		$('#group_name_medicine_schedule').append(response.body);
		$('#group_name_medicine_schedule').select2();
		$('#group_name_medicine_prescription').empty();

		$('#group_name_medicine_prescription').append(response.body);
		$('#egroup_name_medicine_prescription').empty();
		$('#egroup_name_medicine_prescription').append(response.body);

		loadMedicineOptions1();
	})
}

function schedulePrescription() {
	let start_date = $('#start_date_schedule_prescription').val();

	if (start_date !== "") {
		let form = document.getElementById("schedulePrescriptionForm");
		let formData = new FormData(form);
		app.request(baseURL + 'schedulePrescription', formData).then(response => {
			if (response.status === 200) {
				app.successToast(response.body);
				getDoesDetails(localStorage.getItem("patient_id"));
				form.reset();
				$('#scheduleMedicineModal').modal('toggle');
			} else {
				app.errorToast(response.body);
			}
		})
	} else {
		app.errorToast("Select Start Date & Select Medicines");
	}

}

function addPrescriptionItem() {
	let prescriptionName = document.getElementById('prescription_list_name').value;
	let doctorName = document.getElementById('doctor_name_medicine_prescription').value
	let prescription_objective = document.getElementById('prescription_objective').value


	let medicineName = document.getElementById('prescription_medicine_list').value;
	let perDaySchedule = document.getElementById('prescription_per_day_schedule').value;
	let prescriptionRemark = document.getElementById('prescription_remark').value;
	let days = document.getElementById('medicine_no_days').value;
	let ms_quantity = document.getElementById('ms_quantity').value;
	let ms_route = document.getElementById('ms_route').value;


	let prescriptionObject = {
		name: prescriptionName,
		medicine_id: medicineName,
		per_date_schedule: perDaySchedule,
		nos_of_days: days,
		doctorName: doctorName,
		remark: prescriptionRemark,
		quantity: ms_quantity,
		route: ms_route,
		objective: prescription_objective
	}
	let medicineText = $('#prescription_medicine_list option:selected').toArray().map(item => item.text).join();
	var itemObject = btoa(JSON.stringify(prescriptionObject))
	var length = $('#prescriptionItemMasterTable').children().length;
	var code = Math.floor(Math.random() * (999 - 100 + 1) + 100);
	if (prescriptionName !== '' && prescriptionName !== null && doctorName !== '' && doctorName !== null && medicineName !== '' && medicineName !== null
		&& perDaySchedule !== '' && perDaySchedule !== null && days !== "") {

		var itemTemplat = `<tr id="${code + '_' + length}" data-prescription="${itemObject}">
            <td>
            	<button class="border-0 btn-transition btn btn-outline-primary" onclick="deletePrescription('${code + '_' + length}')"> <i class="fa fa-trash"></i>
                </button>
                ${medicineText}
            </td>
            <td>${perDaySchedule}</td>
            <td>${days}</td>
            <td>${prescriptionRemark}</td>
            </tr>`;
		$('#prescriptionItemMasterTable').append(itemTemplat);
		$('#prescription_medicine_list').val('');
		// $('#prescription_medicine_list').select2();
		$('#prescription_remark').val('');
		$('#prescription_per_day_schedule').val('');
		$('#medicine_no_days').val('');
	} else {
		$('#prescription_medicine_list').focus();
	}

	prescriptionArray.push(prescriptionObject);

}


function savePrescription() {
	var itemLength = $('#prescriptionItemMasterTable').children().length;
	if (itemLength > 0) {
		var itemArray = [];
		$('#prescriptionItemMasterTable').children().each(function (e) {
			itemArray.push(JSON.parse(atob($(this)[0].dataset['prescription'])));
		});

		let prescriptionName = document.getElementById('prescription_list_name').value;
		let doctorName = document.getElementById('doctor_name_medicine_prescription').value
		let prescription_objective = document.getElementById('prescription_objective').value
		var object = {
			"prescriptionName": prescriptionName,
			"doctorName": doctorName,
			"objective": prescription_objective,
			"itemArray": itemArray
		};
		$.ajax({
			type: "post",
			url: baseURL + "savePrescription",
			data: object,
			dataType: "json",
			success: function (result) {
				if (result.status === 200) {
					app.successToast(result.body);
					document.getElementById('prescriptionForm').reset();
					$('#prescriptionItemMasterTable').empty();
					$('#prescription_medicine_list').val('');
					$('#doctor_name_medicine_prescription').val('');
					$('#group_name_medicine_prescription').val('');
					$('#newPrescriptionButton').click();

					getPrescriptionTable('prescriptionMasterTable')
					loadPrescription();
				} else {
					app.errorToast(result.body);
				}
			},
			error: function (error) {
				// reject(error);
				app.errorToast('prescription not added');
			}
		});
	} else {
		app.errorToast('Add medicine in list');
	}
}

function getPrescriptionTable(element) {

	app.dataTable(element, {
		url: baseURL + "getPrescriptionTableData"
	}, [
		{
			data: 0
		},
		{
			data: 1
		},
		{
			data: 4
		},
		{
			data: 3
		},

		{
			data: 2,
			render: (d, t, r, m) => {
				if (element === "schedulePrescriptionTable") {
					return `<button class="btn btn-primary btn-action mr-1" type="button" data-target="#scheduleMedicineModal" data-toggle="modal" data-name="${d}" data-pres_id="${d}"> <i class="fas fa-eye"></i> </button>`;
				} else {
					return `<button class="btn btn-primary btn-action mr-1" type="button" onclick="deletePrescription('${d}')" data-pres_id="${d}"> <i class="fas fa-trash"></i> </button><button class="btn btn-primary btn-action mr-1" onclick="open_edit_modal('${d}')" type="button"> <i class="fa fa-pencil"></i> </button>`;
				}

			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		if (element === "schedulePrescriptionTable") {
			$('td:eq(4)', nRow).html(`<button class="btn btn-primary btn-action mr-1" data-target="#scheduleMedicineModal" data-toggle="modal" data-name="${aData[0]}" type="button"  data-pres_id="${aData[0]}"> <i class="fas fa-eye"></i> </button>`);
		} else {
			$('td:eq(4)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="deletePrescription('${aData[0]}')" data-pres_id="${aData[0]}"> <i class="fas fa-trash"></i> </button><button class="btn btn-primary btn-action mr-1"onclick="open_edit_modal('${aData[0]}')" type="button" > <i class="fa fa-pen"></i> </button>`);
		}


	})

}

function loadPrescription() {
	app.dataTable('schedulePrescriptionTable', {
		url: baseURL + 'getPrescriptionTableData',
	}, [
		{data: 0},
		{
			data: 0,
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button" data-target="#scheduleMedicineModal" data-toggle="modal"
				data-name="${d}"> <i class="fas fa-eye"></i> </button>`;
			}
		}], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(1)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" data-target="#scheduleMedicineModal" data-toggle="modal"
				data-name="${aData[0]}"> <i class="fas fa-eye"></i> </button>`);

	})
}

function prescriptionMedicineTable(name,patient_id) {
	app.dataTable('prescriptionMedicineTable', {url: baseURL + "getPrescriptionMedicine", data: {name: name,patient_id:patient_id}},
		[
			{
				data: 4,
				render: (d, t, r, m) => {
					if(r[5]==0){
						return `<input type="checkbox" name="med_id[]" value="${d}" >`;
					}
					else{
						return `-`;
					}
				}
			},
			{data: 0},
			{
				data: 1,
				render: (d, t, r, m) => {
					return `<input type="number"  name="med_schedule_per_day_${r[4]}" min="1"  max="5" value="${d}" class="form-control">`;
				}
			},
			{
				data: 2,
				render: (d, t, r, m) => {
					return `<input type="number"  name="med_no_days_${r[4]}" min="1" value="${d}" class="form-control">`;
				}
			},
			{
				data: 3,
				render: (d, t, r, m) => {
					return `<input type="text"  name="med_desc_${r[4]}"  value="${d}" class="form-control">`;
				}
			},
			{
				data: 6,
				render: (d, t, r, m) => {
					return `<input type="text" readonly style="width:80px" name="med_route_${r[4]}"  value="${d}" class="form-control">`;
				}
			},{
				data: 7,
				render: (d, t, r, m) => {
					return `<input type="text" readonly name="med_quantity_${r[4]}"  value="${d}" class="form-control">`;
				}
			}

		], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			if(aData[5]==0){
				$('td:eq(0)', nRow).html(`<input type="checkbox" name="med_id[]"  value="${aData[4]}" >`);
			}
			else{
				$('td:eq(0)', nRow).html(`-`);
			}
			$('td:eq(2)', nRow).html(`<input type="number"  min="1" max="5" name="med_schedule_per_day_${aData[4]}" class="form-control"  value="${aData[1]}" >`);
			$('td:eq(3)', nRow).html(`<input type="number"  min="1" name="med_no_days_${aData[4]}" class="form-control"  value="${aData[2]}" >`);
			$('td:eq(4)', nRow).html(`<input type="text"  name="med_desc_${aData[4]}" class="form-control"  value="${aData[3]}" >`);
			$('td:eq(5)', nRow).html(`<input type="text" readonly style="width:80px"name="med_route_${aData[4]}" class="form-control"  value="${aData[6]}" >`);
			$('td:eq(6)', nRow).html(`<input type="text" readonly name="med_quantity_${aData[4]}" class="form-control"  value="${aData[7]}" >`);
		});
}

/* function deletePrescription(ids) {
	let formData = new FormData();
	formData.set("name", ids);
	app.request("deletePrescription", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			getPrescriptionTable();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
} */

function getreturnMedicineTable(patient_id="")
{
	if(patient_id == ""){
		var patient_id=window.localStorage.getItem("patient_id");
	}
	app.dataTable('returnMedicineTable', {url: baseURL + "getReturnMedicineTable", data: {patient_id: patient_id}},
		[
			{
				data: 1,
				render: (d, t, r, m) => {
					return `<input type="checkbox" name="med_id[]" value="${d}" >
					<input type="hidden" name="patient_id" value="${r[3]}" >`;
				}
			},
			{data: 0},
			{
				data: 1,
				render: (d, t, r, m) => {
					return `<input type="number"  name="return_medicine_${r[1]}" id="edit-quantity_${r[1]}" min="0" max="${r[4]}" value="0" class="form-control edit-quantity" onKeyup="maxValue(${r[1]},${r[4]})">`;
				}
			}

		], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			$('td:eq(0)', nRow).html(`<input type="checkbox" name="med_id[]"  value="${aData[1]}" >`);
			$('td:eq(2)', nRow).html(`<input type="number"  min="0" max="${aData[4]}" name="return_medicine_${aData[1]}" id="edit-quantity_${aData[1]}" class="form-control edit-quantity"  value="0" onKeyup="maxValue(${aData[1]},${aData[4]})">`);
			});
}

function maxValue(id,max)
{
	// console.log(max);
	var numbers = document.getElementById("edit-quantity_"+id);
	var maxQuantity = max;
	numbers.addEventListener("input",function(e)
	{
		if(this.value > maxQuantity)
		{
			app.errorToast('max value reached ! ');
			this.value = maxQuantity;
		}
	})

}
 
function get_medicine_data(element, value) {
	//getDischaredPatient


	$('#' + element).selec2({
		ajax: {
			url: baseURL + "get-medicine",
			type: "post",
			dataType: "json",
			delay: 250,
			placeholder: "Medicine Name",
			data: function (params) {
				return {
					type: $('#group_name_medicine_prescription').val(),
					searchTerm: params.term
				};
			},
			processResults: function (response) {
				return {
					results: response.body
				};
			},
			cache: true
		},
		minimumInputLength: 3
	});

	$.ajax({
		url: baseURL + "getmedicine",
		type: "POST",
		dataType: "json",
		data: {group_id: value},
		success: function (result) {
			var data = result.body;
			var list = result.list;
			//console.log(result);
			//$('#video_count').empty();
			if (result.status == 200) {

				$('#' + element).html(data);
				// $('#myMenu').html(data);
				$('#' + element).select2();
			} else {

				$('#' + element).html(data);
				// $('#myMenu').html(data);
				$('#' + element).select2();
			}
		}, error: function (error) {
			//   toastr.error("Something went wrong please try again");
		}
	});
}

function get_medicine_data_1() {

	app.dataTable("myTable", {
		url: baseURL + "getMedicineTable",
	}, [
		{data: 0},
		{data: 1},
		{data: 2},
		{
			data: 3, render: function (d, t, r, m) {
				return `<button type='button' onclick='delete_medi(.${d})' class='btn btn-primary'><i class='fa fa-trash'></i></button>`;
			}
		}
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(3)', nRow).html(`<button type='button' onclick='delete_medi(.${aData[3]})' class='btn btn-primary'><i class='fa fa-trash'></i></button>`);
	});
}

$('#add_medi_form').validate({
	rules: {
		medi_name: {
			required: true
		},

	},
	messages: {
		medi_name: {
			required: "Please Enter Medicine Name"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "add_medicine_fun",
			dataType: "json",
			data: $('#add_medi_form').serialize(),
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					app.successToast(result.body);
					$("#add_medi_form").trigger("reset");
					get_medicine_data_1();
					get_medicine_data();

				} else {
					toastr.error(result.body);
				}
				// $.LoadingOverlay("hide");

				//toastr.success(result.body);
			}, error: function (error) {
				console.log('Logged ---> ', error);
				$.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});

function max_date(dtToday) {


	var month = dtToday.getMonth() + 1;
	var day = dtToday.getDate();
	var year = dtToday.getFullYear();
	if (month < 10)
		month = '0' + month.toString();
	if (day < 10)
		day = '0' + day.toString();

	var maxDate = year + '-' + month + '-' + day;
	return maxDate;
}

function getDoesDetails(p_id) {
	new Promise((resolve, reject) => {
		$.ajax({
			type: "post",
			url: baseURL + 'getICUDoesDetails',
			data: {p_id: p_id},
			dataType: "json",
			success: function (result) {
				resolve(result);
			},
			error: function (error) {
				reject(error);
			}
		});
	}).then((result) => {
		if (result.status === 200) {
//                    $('#doesHistoryTable').empty();
//                    $('#doesHistoryTable').append(result.body);
			$('#doesHistoryTable1').empty();
			$('#doesHistoryTable1').append(result.body);
			// if (result.isAvailabel) {
			// if (result.currentArray.length > 0) {
			// let currentTableRow = ``;
			// currentTableRow += result.currentArray.map((x, i) => currentDoesRow(x, result.cdate)).join('');
			// currentTableRow += ``;
			$('#currentDoesTableBox').empty();
			$('#currentDoesTableBox').append(result.currentArray);
			// }
			// }

		} else {
			$('#doesHistoryTable1').empty();
			$('#currentDoesTableBox').empty();
			$('#currentDoesTableBox').empty();
			$('#currentDoesTableBox').append(result.currentArray);

		}

	}).catch(error => {
		console.log(error);
		app.errorToast('Something went wrong');
	});

}

function validationEprescriptionForm() {
	$("#eprescriptionForm").validate({
		rules: {
			egroup_name: {
				required: true,
			},
			eprescription_medicine_list: {
				required: true,
			},
			eprescription_per_day_schedule: {
				required: true,
			},
			medicie_no_days: {
				required: true,
			}
		},
		messages: {
			egroup_name: {
				required: "Select Group Name"
			},
			eprescription_medicine_list: {
				required: "Medicine Name"
			},
			eprescription_per_day_schedule: {
				required: "Select Per Day Schedule"
			},
			medicie_no_days: {
				required: "Select number of days"
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			update_prescription();
		}
	});
}

function validationPrescriptionEditForm() {
	$("#editPrescription").validate({
		rules: {
			eprescription_list_name: {
				required: true,
			},
			eprescription_objective: {
				required: true,
			},
			edoctor_name: {
				required: true,
			},
		},
		messages: {
			eprescription_list_name: {
				required: "Please Add Prescription Name"
			},
			eprescription_objective: {
				required: "Please Prescription Object"
			},
			edoctor_name: {
				required: "Please Select Doctor Name"
			},
		},
		errorElement: 'span',
		submitHandler: function (form) {
			app.request(baseURL + "editPrescriptionDetails", new FormData(form)).then(res => {
				if (res.status === 200) {
					app.successToast(res.body);
					location.reload();
				} else {
					app.errorToast(res.body);
				}
			}).catch(error => {
				console.log(error);
			})
		}
	});
}

$('#att_medi_form').validate({
	rules: {
		medicine_list: {
			required: true,
			//  uniqueUserID: true
		},
		Start_Date_new: {
			required: true,
			//  uniqueUserID: true
		},
		End_Date_new: {
			required: true,
			//  uniqueUserID: true
		},
		Per_Day_Schedule_new: {
			required: true,
			//  uniqueUserID: true
		},

	},
	messages: {
		medicine_list: {
			required: "Please Select Medicine Name"
		},
		Start_Date_new: {
			required: "Please Select Start date"
		},
		End_Date_new: {
			required: "Please Select End date"
		},
		Per_Day_Schedule_new: {
			required: "Please Select per day Schedule"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		$.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "addPatientMedicine",
			dataType: "json",
			data: $('#att_medi_form').serialize(),
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status === 200) {
					app.successToast(result.body);
					$("#att_medi_form").trigger("reset");
					$("#medicine_list").val('');
            		$('#medicine_list').select2({allowClear: true});
            		getMedicineGroup();
					//    get_patien_medicine_data();
					var pID = $("#patient_list").val();
					getDoesDetails(pID);
					$("#flowRateTextDiv").hide();
				} else {
					app.errorToast(result.body);
				}


				//toastr.success(result.body);
			}, error: function (error) {
				console.log('Logged ---> ', error);
				$.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});

function hide_date() {
	var atLeastOneIsChecked = $('input[name="chk"]:checked').length > 0;
	var atLeastOneIsChecked1 = $('input[name="e_chk"]:checked').length > 0;
	//end_date_div
	if (atLeastOneIsChecked1) {
		$("#End_Date_new").val("");
		$("#e_end_date_div").hide();
	} else {
		$("#e_end_date_div").show();
	}
	if (atLeastOneIsChecked == true) {
		$("#End_Date_new").val("");
		$("#end_date_div").hide();

	} else {
		$("#end_date_div").show();
	}
}
$("#flowRateTextDiv").hide();
function get_flowrate_text()
{
	var atLeastOneIsChecked = $('input[name="flowratechk"]:checked').length > 0;
	if (atLeastOneIsChecked == true) {
		
		$("#flowRateTextDiv").show();

	} else {
		$("#flowRate_new").val("");
		$("#flowRateTextDiv").hide();
	}
}

function currentDoesRow(array, index) {

	let data = array[index];


	return `<div class="row currentDateDoes1">
            <div class="col-md-12">
                    <table style="width:100%;font-size: 12px " class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display">
                             <thead>
                                            <tr>
                                               ${data[1]}
                                            </tr>
                                        </thead>
                                                        <tbody>
                                                              <tr>

                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>5</td>
                                            </tr>
                            <tr>${data[2]}${data[3]}${data[4]}${data[5]}${data[6]}</tr>
                               </tbody>
                    </table>
                                  </div>
                </div> `;

}

function doesGiven(p_id, did, i, date,flowrate=null) {
	new Promise((resolve, reject) => {
		$.ajax({
			type: "post",
			url: baseURL + 'doesGivent',
			data: {p_id: p_id, ite_count: i, does_id: did, ite_date: date,flowrate:flowrate},
			dataType: "json",
			success: function (result) {
				resolve(result);
			},
			error: function (error) {
				reject(error);
			}
		});
	}).then((result) => {
		if (result.status === 200) {
			app.successToast(result.body);
			getDoesDetails(p_id);
		} else {
			app.errorToast(result.body);
		}

	}).catch(error => {
		console.log(error);
		app.errorToast('Something went wrong');
	});
}

function deleteMedicine(form) {

	app.request(baseURL + "deleteScheduleMedicine", new FormData(form)).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			getDoesDetails($('#e_p_id').val());
			$('#editForm_new').trigger('reset');
			$('#closeedit').click();
			$('#closeedit1').click();
		} else {
			app.errorToast(response.body);
		}
	})
}

function get_data(id) {
	//e_medicine_id
	//e_p_id

	var pid = $("#patient_list").val();
	var mid = id;
	$("#e_p_id").val(pid);
	$("#e_medicine_id").val(mid);
	$.ajax({
		url: baseURL + "getEditMedicineData",
		type: "POST",
		dataType: "json",
		data: {patient_id: pid, medi_id: mid},
		success: function (result) {
			var data = result.data;
			var dtToday = new Date();
			$('#e_Start_Date_new').attr('min', max_date(dtToday));
			//$('#video_count').empty();
			$('#editForm_new').trigger("reset");

			if (result.status == 200) {
				// console.log(data.end_date);
				$("#e_Start_Date_new").val(date_change(data.start_date));
				$("#e_End_Date_new").val(date_change(data.end_date));
				$("#e_Per_Day_Schedule_new").val(data.total_iteration);
				if (data.end_date === "0000-00-00 00:00:00") {
					$('#e_chk').attr('checked', 'checked');
					$("#e_end_date_div").hide();
				} else {
					$('#e_chk').removeAttr('checked');

					$("#e_end_date_div").show();
				}
			} else {
				("#e_Start_Date_new").val("");
				("#e_End_Date_new_Date_new").val("");
				("#e_Per_Day_Schedule_new").val("");
			}
		}, error: function (error) {
			//   toastr.error("Something went wrong please try again");
		}
	});
}

function date_change(userDate) {
	var date = new Date(userDate),
		yr = date.getFullYear(),
		month = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth(),
		day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
		newDate = yr + '-' + month + '-' + day;
	return (newDate);
}

// $('#editForm_new').validate({
// 	rules: {
//
// 		Start_Date_new: {
// 			required: true,
// 			//  uniqueUserID: true
// 		},
// 		End_Date_new: {
// 			required: true,
// 			//  uniqueUserID: true
// 		},
// 		Per_Day_Schedule_new: {
// 			required: true,
// 			//  uniqueUserID: true
// 		},
//
// 	},
// 	messages: {
//
// 		Start_Date_new: {
// 			required: "Please Select Start date"
// 		},
// 		End_Date_new: {
// 			required: "Please Select End date"
// 		},
// 		Per_Day_Schedule_new: {
// 			required: "Please Select per day Schedule"
// 		},
//
// 	},
// 	errorElement: 'span',
// 	submitHandler: function (form) {
// 		$.LoadingOverlay("show");
// 		$.ajax({
// 			type: "POST",
// 			url: baseURL + "updatePatientMedicine",
// 			dataType: "json",
// 			data: $('#editForm_new').serialize(),
// 			success: function (result) {
// 				$.LoadingOverlay("hide");
// 				if (result.status === 200) {
// 					app.successToast(result.body);
//
// 					getDoesDetails($("#patient_list").val());
// 					$("#editForm_new").trigger("reset");
// 					$("#edit_modal").modal("hide");
//
// 					//    get_patien_medicine_data();
// 				} else {
// 					app.errorToast(result.body);
// 				}
//
//
// 				//toastr.success(result.body);
// 			}, error: function (error) {
// 				console.log('Logged ---> ', error);
// 				$.LoadingOverlay("hide");
// 				app.errorToast('something went wrong');
// 			}
// 		});
// 	}
// });

function delete_medi(medicine_id) {
	$.ajax({
		url: baseURL + "deleteMedicine",
		type: "POST",
		dataType: "json",
		data: {medicine_id: medicine_id},
		success: function (result) {

			if (result.status == 200) {
				app.successToast(result.body);
				get_medicine_data_1();
				get_medicine_data();
			} else {
				app.errorToast(result.body);
			}
		}, error: function (error) {
			app.errorToast("Something went wrong please try again");
		}
	});
}


function clearDoesEntry(patient_id, does_details_id, iteration) {

	var r = confirm("Clear Does Entry Datetime !");
	if (r === true) {
		new Promise((resolve, reject) => {
			if (patient_id !== undefined && does_details_id !== undefined) {
				let formData = new FormData();
				formData.append("patient_id", patient_id);
				formData.append("does_details_id", does_details_id);
				formData.append("iteration", iteration);
				$.ajax({
					type: "POST",
					url: baseURL + 'deleteMedicineHistory',
					dataType: "json",
					data: formData,
					processData: false,
					contentType: false,
					cache: false,
					async: false,
					success: function (result) {
						if (result.status === 200) {
							resolve(result.body);
							getDoesDetails(patient_id);
						} else {
							resolve("Failed To Clear Does");
						}
					},
					error: function (result) {
						console.log(result);
						reject("Failed To Clear Does");
					}
				});
			} else {
				reject("Required Parameter");
			}
		}).then(result => {
			// toastr.success(result);
			// getDoesDetails(patient_id);
		}).catch(e => toastr.error(e));
	} else {

	}
}

var clearOperation = (patient_id, does_details_id) => {
	var r = confirm("Clear Does Entry Data !");
	if (r === true) {
		new Promise((resolve, reject) => {
			if (patient_id !== undefined && does_details_id !== undefined) {
				let formData = new FormData();
				formData.append("patient_id", patient_id);
				formData.append("does_details_id", does_details_id);
				$.ajax({
					type: "POST",
					url: 'clear_data',
					dataType: "json",
					data: formData,
					processData: false,
					contentType: false,
					cache: false,
					async: false,
					success: function (result) {
						if (result.status === 200) {
							resolve(result.body);
						} else {
							resolve("Failed To Clear Data");
						}
					},
					error: function (result) {
						console.log(result);
						reject("Failed To Clear Data");
					}
				});
			} else {
				reject("Required Parameter");
			}
		}).then(result => {
			// toastr.success(result);
			// getDoesDetails(patient_id);
			view_form();
		}).catch(e => toastr.error(e));
	} else {

	}
}

function open_edit_modal(id) {
	$("#edit_prescription").modal('show');
	get_data11(id);
}

function get_data11(id) {
	$.ajax({
		type: "POST",
		url: baseURL + "get_prescribe_data",
		dataType: "json",
		async: false,
		cache: false,
		data: {id},
		success: function (result) {
			//console.log(result);
			if (result.status == 200) {

				var data = result.data;
				$("#med_data_div").html(data);
				loadDoctors("edoctor_names", result.doctor_id);
				validationPrescriptionEditForm();
				validationEprescriptionForm();
				loadMedicineOptionsE();
				getMedicineGroup();

			} else {
				$("#med_data_div").html("");
			}
		}

	});
}

function update_prescription() {
	var form_data = document.getElementById('eprescriptionForm');
	var Form_data = new FormData(form_data);
	$.ajax({
		type: "POST",
		url: baseURL + 'update_prescription',
		dataType: "json",
		data: Form_data,
		contentType: false,
		processData: false,
		success: function (result) {

			// app.successToast(result);

			if (result.status === 200) {

				app.successToast(result.body);
				var name = $("#eprescription_list_name").val();
				get_data11(name);
				getPrescriptionTable('prescriptionMasterTable');
			} else {
				app.errorToast(result.body);
			}
		},
		error: function (error) {
			// $.LoadingOverlay("hide");
			app.errorToast("something went wrong please try again");
		}
	});
}

function deletePrescription(item) {

	let formData = new FormData();
	formData.set("item", item);
	app.request(baseURL + "deletePrescription", formData).then(result => {
		if (result.status === 200) {
			app.successToast(result.body);
			getPrescriptionTable('prescriptionMasterTable');
		} else {
			app.errorToast(result.body);
		}
	})

}

function delete_med(id, name) {
	console.log(id);
	console.log(name);
	let formData = new FormData();
	formData.set("Mid", id);
	formData.set("Pname", name);
	$.ajax({
		type: "POST",
		url: baseURL + 'deletePrescriptionMed',
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function (result) {
			if (result.status === 200) {
				app.successToast(result.body);
				get_data11(name);
				getPrescriptionTable('prescriptionMasterTable');
			} else {
				app.errorToast(result.body);
			}
		},
		error: function (error) {
			// $.LoadingOverlay("hide");
			app.errorToast("something went wrong please try again");
		}
	});
}

function availabWPatient(p_id, m_id, sts) {
	let formData = new FormData();
	formData.set("p_id", p_id);
	formData.set("m_id", m_id);
	formData.set("sts", sts);
	$.ajax({
		type: "POST",
		url: baseURL + 'availabWPatient',
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function (result) {
			if (result.status === 200) {
				app.successToast(result.body);

			} else {
				app.errorToast(result.body);
			}
		},
		error: function (error) {
			// $.LoadingOverlay("hide");
			app.errorToast("something went wrong please try again");
		}
	});
}


function returnScheduleMedicine() {
		
		let form = document.getElementById("returnMedicineForm");
		let formData = new FormData(form);
		app.request(baseURL + 'returnMedicineForm', formData).then(response => {
			if (response.status === 200) {
				app.successToast(response.body);
				var patient_id=window.localStorage.getItem("patient_id");
				getreturnMedicineTable(patient_id)
				form.reset();
			} else {
				app.errorToast(response.body);
			}
		})
	

}

function deleteActivate(id) {

	let formData = new FormData();
	formData.set("id",id);
	app.request(baseURL+"activeMedicine",formData).then(response =>{
		if(response.status ===200){
			app.successToast(response.body);
			let patient_id = localStorage.getItem("patient_id");
			getDoesDetails(patient_id);
			load_medicine_history();
		}else{
			app.errorToast(response.body);
		}
	})
}

function addMedicineComment(p_id,m_id,iteration,dosedate)
{
	$("#commentMedicineModalBtn").click();
	$("#m_patient_id").val(p_id);
	$("#c_medicine_id").val(m_id);
	$("#m_iteration_id").val(iteration);
	$("#m_dose_date").val(dosedate);

}

function addMecidineCommentData()
{
	var comment=$("#medicine_comment").val();
	if(comment!="")
	{
		// var form=$('#medicineCommentForm').serialize();
		let form = document.getElementById("medicineCommentForm");
		let formData = new FormData(form);
		app.request(baseURL + "addmedicineCommentForm", formData).then(res => {
				if (res.status === 200) {
					app.successToast(res.body);
					$("#commentMedicineModalBtn").click();
				} else {
					app.errorToast(res.body);
				}
			}).catch(error => {
				console.log(error);
			})
	}
	else
	{
		app.errorToast('Enter comment');
	}
	
}