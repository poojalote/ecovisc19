$(document).ready(function () {

	var patient_id = localStorage.getItem("patient_id");
	// getSampleCollectionTable('PATHOLOGY', 'pathologySampleTable');
	// billing_services();
	// let patient_admission = window.localStorage.getItem("patient_admission");
	// if(patient_admission !==null && patient_admission !=="0000-00-00 00:00:00"){

	// }
	$('#getRadiologyUploadModal').on('hidden.bs.modal', function () {

		$("#radioFileUploadationForm").trigger("reset");

	});
	getCommonServices('yes');
// getOrderPlaceTable(patient_id);
	getServiceOrderPlaceTimeTable(patient_id);
	clearListButton();
	getStandardLabServices(1);
	$('#deleteSampleModel').on('hide.bs.modal', function (e) {
		getSampleCollectionTable('PATHOLOGY', 'pathologySampleTable');
	});


	var dt = new Date();
	var month = dt.getMonth() + 1;
	var day = dt.getDate();
	var output = dt.getFullYear() + '-' +
		(month < 10 ? '0' : '') + month + '-' +
		(day < 10 ? '0' : '') + day + " 00:00:00";
	let patient_admission = output;
	// document.getElementById("standardLabDate").min = app.getDate(patient_admission);
	document.getElementById("serviceOrder_date").min = app.getDate(patient_admission);
	document.getElementById("standardLabDate").min = app.getDate(patient_admission);

	var sdt = new Date();
	sdt.setDate(sdt.getDate() + 30);

	var pmonth = sdt.getMonth() + 1;
	var pday = sdt.getDate();
	var poutput = sdt.getFullYear() + '-' +
		(pmonth < 10 ? '0' : '') + pmonth + '-' +
		(pday < 10 ? '0' : '') + pday + " 00:00:00";
	var pdate1 = poutput;
	document.getElementById('standardLabDate').max = app.getDate(pdate1);
	document.getElementById("serviceOrder_date").max = app.getDate(pdate1);
	// console.log(pdate1);

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

function clearListButton() {
	var length = $('#serviceOrderItemTable').children().length;
	if (length > 0) {
		var element = document.getElementById("clearListButtonDiv");
		element.classList.remove("d-none");
	} else {
		// $("#clearListButtonDiv").hide();
		var element = document.getElementById("clearListButtonDiv");
		element.classList.add("d-none");
	}
}

function clearListServiceItem() {
	$('#serviceOrderItemTable').empty("");
	getCommonServices('yes');
	clearListButton();
}

function serviceOrderCategoryToggle() {
	var spi = document.getElementById('serviceCategoryshow');
	spi.classList.toggle("d-none");
}

function getCommonServicesDetail(common) {
	if (common == 'yes') {
		// $("#commonServiceDetailDiv").empty("");
		$("#commonServiceDetailDiv").show();
		getCommonServices();
	} else {
		// $("#commonServiceDetailDiv").empty("");
		$("#commonServiceDetailDiv").hide();
	}
}

function getServiceOrderPlaceTimeTable(patient_id) {
	serverRequest("getServiceOrderPlaceTimeTable", {patientId: patient_id}).then(response => {

		var user_data = response.options;
		if (response.status === 200) {

			$("#orderPlaceTable").empty("");
			$("#orderPlaceTable").append(user_data);


		} else {
			$("#orderPlaceTable").empty("");
			$("#orderPlaceTable").append(user_data);

		}
	}).catch(error => console.log(error));
}

function getCommonServices(commonServices) {
	serverRequest("getOrderCommonServicesName", null).then(response => {
		// $.LoadingOverlay("hide");
		// console.log(response);
		var user_data = response.options;
		if (response.status === 200) {
			// console.log(response);
			$("#commonServiceDetail").empty("");
			$("#commonServiceDetail").append(user_data);
			// $("#bservice_name").select2();

		} else {
			$("#commonServiceDetail").empty("");
			$("#commonServiceDetail").append(user_data);
			// $("#bservice_name").select2();
		}
	}).catch(error => console.log(error));
}

function getStandardLabServices(day) {
	// $("#standardLabDateDiv").addClass('d-none');
	var dt = new Date();
	var month = dt.getMonth() + 1;
	var day = dt.getDate();
	var output = dt.getFullYear() + '-' +
		(month < 10 ? '0' : '') + month + '-' +
		(day < 10 ? '0' : '') + day + " 00:00:00";
	$("#standardLabDate").val(app.getDate(output));
	if (day == 0) {
		$("#standardLabDateDiv").removeClass('d-none');
	}
	serverRequest("getStandardLabServicesName", {day: day}).then(response => {
// $.LoadingOverlay("hide");
// console.log(response);
		var user_data = response.option;
		if (response.status === 200) {
// console.log(response);
			$("#standardLabServicesTable").empty("");
			$("#standardLabServicesTable").append(user_data);
// $("#bservice_name").select2();

		} else {
			$("#standardLabServicesTable").empty("");
			$("#standardLabServicesTable").append(user_data);
// $("#bservice_name").select2();
		}
	}).catch(error => console.log(error));
}

function get_zone() {
//zoneDetails

	app.request(baseURL + "getZoneData", null).then(success => {
		if (success.status == 200) {
			var user_data = success.data;
			$("#psampleAllPatient").html(user_data);
			$("#sampleAllPatient").html(user_data);
			$("#rsampleAllPatient").html(user_data);
		}
	});
}

function getServiceName(category) {
	// $.LoadingOverlay("show");
	serverRequest("getOrderServicesName", {category: category}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#bserviceOrder_name").empty("");
			$("#bserviceOrder_name").append(user_data);
			$("#bserviceOrder_name").select2();

		} else {
			$("#bserviceOrder_name").empty("");
			$("#bserviceOrder_name").append(user_data);
			$("#bserviceOrder_name").select2();
		}
	}).catch(error => console.log(error));
}

function getServiceDescription(service_no) {
	// $.LoadingOverlay("show");
	serverRequest("getServicesOrderDescription", {service_no: service_no}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#bserviceOrder_desc").empty("");
			$("#bserviceOrder_desc").append(user_data);
			$("#bserviceOrder_desc").select2();

		} else {
			$("#bserviceOrder_desc").empty("");
			$("#bserviceOrder_desc").append(user_data);
			$("#bserviceOrder_desc").select2();
		}
	}).catch(error => console.log(error));
}

function getServiceRate(id) {
	// $.LoadingOverlay("show");
	serverRequest("getServicesOrderRate", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);

		if (response.status == 200) {
			var user_data = response.option[0];
			// console.log(response);
			if (user_data.rate != 0) {
				// $("#billing_rate").val(user_data.rate);
				$("#divBillingRate").html('<input type="text" class="form-control" value="' + user_data.rate + '" name="billing_rate" id="billing_rate" readonly>');
			} else {
				$("#divBillingRate").html('<input type="text" class="form-control" value="' + user_data.rate + '" name="billing_rate" id="billing_rate">');

			}

			$("#billing_service_id").val(user_data.id);

		} else {

			$("#billing_rate").val("");
			$("#billing_service_id").val("");
		}
	}).catch(error => console.log(error));
}

function addServiceOrderItem(serviceOrder_id = null, serviceOrder_description = null, serviceOrder_rate = null, serviceOrder_date = null) {
	// console.log(service_id);

	var service_description;
	var service_id;
	var rate;
	var sdate;
	var perform_by;

	if (serviceOrder_id == null && serviceOrder_description == null) {

		service_description = $('#bserviceOrder_desc option:selected').toArray().map(item => item.text).join();
		service_id = document.getElementById('bserviceOrder_desc').value;
		rate = document.getElementById('billing_rate').value;

		// console.log("service_id");
		sdate = document.getElementById('serviceOrder_date').value;
		perform_by = document.getElementById('serviceOrder_perform').value;
	} else {

		service_description = serviceOrder_description;
		service_id = serviceOrder_id;
		rate = serviceOrder_rate;
		sdate = serviceOrder_date
		perform_by = "";
		// console.log(service_id);
	}
	if (service_id == "Select Services") {
		$('#bserviceOrder_desc').focus();
		return;
	}

	// console.log(service_description);
	var length = $('#serviceOrderItemTable').children().length;
	var code = Math.floor(Math.random() * (999 - 100 + 1) + 100);
	var itemObject = btoa(JSON.stringify({
		service_id: service_id,
		service_description: service_description,
		rate: rate,
		service_date: sdate,
		service_perform: perform_by
	}));
	if (service_description !== '' && service_description !== null && service_id !== '' && service_id !== null) {
		if (sdate !== '' && sdate !== null) {
			var itemTemplat = `<tr id="order_${service_id}" data-prescription="${itemObject}">
            <td>
                ${service_description}
            </td>
	<td>
		${sdate}
	</td>
           <!-- <td>
            <button class="border-0 btn-transition btn btn-outline-primary" onclick="deleteServiceOrderItem(order_'${service_id}')"> <i class="fa fa-trash"></i>
               </button>
            </td>-->
            </tr>`;
			if (serviceOrder_id == null && serviceOrder_description == null) {
				$('#serviceOrderItemTable').append(itemTemplat);
				$('#bserviceOrder_name').val('');
				$('#bserviceOrder_desc').select2();
			} else {
				if ($("#ser_or_" + serviceOrder_id).prop('checked') == true) {

					$('#serviceOrderItemTable').append(itemTemplat);
					$('#bserviceOrder_name').val('');
					$('#bserviceOrder_desc').select2();
				} else {
					deleteServiceOrderItem('order_' + serviceOrder_id);
				}
			}
			clearListButton();
			$('#bservice_cat').val('');
			$('#bserviceOrder_name').val('');
			$("#bserviceOrder_desc").val(null).trigger('change');
			$('#billing_rate').val('');
			$('#serviceOrder_unit').val(1);
			$('#serviceOrder_date').val('');
		} else {

			$('#serviceOrder_date').focus();
		}

	} else {

		if (service_description !== '' && service_description !== null) {
			$('#bserviceOrder_desc').focus();
		}

		// $('#serviceOrder_date').focus();
	}
}

function deleteServiceOrderItem(item) {
	$('#' + item).remove();
}

function getServiceOrderTime(day, time, id) {
	// console.log("time");

	var length = $('#serviceOrderTimeHidden').children().length;
	// console.log(time);
	var code = Math.floor(Math.random() * (999 - 100 + 1) + 100);
	var itemObject = btoa(JSON.stringify({day: day, time: time}));
	if (day !== '' && day !== null && time !== '' && time !== null) {

		var itemTemplat = `<tr id="serviceOrder_${id}" data-serviceorder="${itemObject}">
            <td>
                ${time}
            </td>
            <td>
            <!--<button class="border-0 btn-transition btn btn-outline-primary" onclick="deleteServiceOrderItem(serviceOrder_'${id}')"> <i class="fa fa-trash"></i>
               </button>-->
            </td>
            </tr>`;
		// var servicetimeId=day+'_'+time;
		// console.log(id);
		// console.log($("#"+id).prop('checked'));
		if ($("#" + id).prop('checked') == true) {
			$('#serviceOrderTimeHidden').append(itemTemplat);
			// console.log(servicetimeId);
		} else {
			// console.log(servicetimeId);
			// alert();
			deleteServiceOrderItem('serviceOrder_' + id);
		}
	} else {

	}


}

function place_serviceOrder() {
	var itemLength = $('#serviceOrderItemTable').children().length;
	if (itemLength > 0) {
		var itemArray = [];
		$('#serviceOrderItemTable').children().each(function (e) {
			itemArray.push(JSON.parse(atob($(this)[0].dataset['prescription'])));
		});


// var timeLength = $('#serviceOrder_date').val();
// if (timeLength) {
// var timeArray = [];
// $('#serviceOrderTimeHidden').children().each(function (e) {
//           timeArray.push(JSON.parse(atob($(this)[0].dataset['serviceorder'])));
//       });
		// console.log(itemArray);
		var patientName = $('#serviceOrder_patient_name').val();
		var patient_id = $('#serviceOrder_patient_id').val();
		var patientAdhar = $('#serviceOrder_patient_adhar').val();
		var object = {
			"itemArray": itemArray,
			"patientName": patientName,
			"patientAdhar": patientAdhar,
			"patientId": patient_id
		};
		$.ajax({
			type: "post",
			url: baseURL + "placeServiceOrder",
			data: object,
			dataType: "json",
			success: function (result) {
				if (result.status == 200) {
					app.successToast(result.body);
					document.getElementById('uploadServiceOrderPlace').reset();

					$('#serviceOrderItemTable').empty();
					$('#serviceOrderTimeHidden').empty();

					// getPrescriptionTable();
					getServiceOrderPlaceTimeTable(localStorage.getItem("patient_id"));
					clearListServiceItem();
				} else {
					app.errorToast(result.body);
				}

			},
			error: function (error) {
				app.errorToast('Order not place');
			}
		});
// }
// else{
// 	app.errorToast('Select time for services');
// }

	} else {
		app.errorToast('Add service in list');
	}
}


function getOrderPlaceTable(p_id) {
	// var p_id = $('#p_id').val();

	app.dataTable('orderPlaceTable', {
		url: baseURL + "getOrderPlaceTable",
		data: {p_id: p_id}
	}, [
		{
			data: 0
		},
		{
			data: 1
		},
		{
			data: 2
		},
		{
			data: 3
		},
		{
			data: 4,
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteserviceOrderTranscation(${d})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>`;
			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// let date = aData[2];

		//
		// $('td:eq(0)', nRow).html(`${aData[0]}`);
		//
		// $('td:eq(1)', nRow).html(`${aData[1]}`);


		$('td:eq(4)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteserviceOrderTranscation(${aData[4]})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>`);

	})

}

function deleteserviceOrderTranscation(id) {
	// $.LoadingOverlay("show");
	// console.log(id);
	serverRequest("deleteserviceOrderTranscation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getOrderPlaceTable(localStorage.getItem("patient_id"));
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}


function uploadStandardLabServices(day) {
// var formData=$('#uploadStandardLabServices').serialize();
// var formElements=document.getElementById("uploadStandardLabServices").elements;
// var formData = new FormData(formElements);
	var form_data = document.getElementById('uploadStandardLabServices');
	var formData = new FormData(form_data);
// var formData = new FormData(document.querySelector('uploadStandardLabServices'));
// console.log(formData);
	var patientName = $('#serviceOrder_patient_name').val();
	var patient_id = $('#serviceOrder_patient_id').val();
	var patientAdhar = $('#serviceOrder_patient_adhar').val();
// var object = {"formData": formData,
// 			"patientName": patientName,
// 			"patientAdhar": patientAdhar,
// 			"patientId": patient_id,
// 			"day":day
// };
	formData.append("patientName", patientName);
	formData.append("patient_id", patient_id);
	formData.append("patientAdhar", patientAdhar);

	$.ajax({
		type: "post",
		url: baseURL + "placeStandardLabServiceOrder",
		data: formData,
		dataType: "json",
		contentType: false,
		processData: false,
		success: function (result) {
			if (result.status == 200) {
				app.successToast(result.body);
				document.getElementById('uploadStandardLabServices').reset();

// $('#serviceOrderItemTable').empty();
// $('#serviceOrderTimeHidden').empty();
// getPrescriptionTable();
// 				$("#standardLabDateDiv").addClass('d-none');
				getServiceOrderPlaceTimeTable(localStorage.getItem("patient_id"));
				clearListServiceItem();
			} else {
				app.errorToast(result.body);

				// $("#standardLabDateDiv").addClass('d-none');
			}

		},
		error: function (error) {
			app.errorToast('Order not place');
		}
	});
}

function getStandardLabServiceCount(Id, checkId) {
	if ($("#" + checkId).prop('checked') == true) {

		$('#' + Id).val(1);
		let code = checkId.split("_");
		selectedServices.push(code[1]);

	} else {
		$('#' + Id).val(0);

	}
}

function getSampleCollectionTable(category, tableID, patient_id = null) {
	// var p_id = $('#p_id').val();
	// console.log(""+tableID+"");
	let formData = new FormData();
	formData.set("category", category);
	// if(category=="RADIOLOGY"){
	let zone = $("#psampleAllPatient").val();
	if (zone !== null) {
		formData.set("zone_id", zone);
	}


	app.request(baseURL + "getSampleCollectionTable", formData).then(res => {

		$(`#${tableID}`).DataTable({
			destroy: true,
			responsive: true,
			order: [7, 'desc'],
			autoWidth: false,
			data: res.data,
			columns: [
				{
					data: 0
				},
				{
					data: 1
				},
				/*{
					data: 2,
					render: (d, t, r, m) => {
						return `<div class="wrapDiv">${d}</div>`;
					}
				},*/
				{
					data: 3,
					render: (d, t, r, m) => {
						return `<div class="wrapDiv">${d}</div>`;
					}
				},
				{
					data: 5,
					render: (d, t, r, m) => {
						return `<div class="wrapDiv">${d}</div>`;
					}
				},
				{
					data: 7,
					render: (d, t, r, m) => {
						if (parseInt(r[10]) === 1) {
							let value = 1;
							return `<input type="checkbox" id="sampleCollectionCheckbox_${r[6]}"
 								onclick="serviceOrderBillingInfo(${r[6]},'${category}','${tableID}','${category}',${value},${r[12]},'${r[2]}','${r[13]}','${r[5]}','${r[3]}')">`;
						} else {
							let value = 0;
							return `<input type="checkbox"  id="sampleCollectionCheckbox_${r[6]}" 
			onclick="serviceOrderBillingInfo(${r[6]},'${category}','${tableID}','${category}',${value},${r[12]},'${r[2]}','${r[13]}','${r[5]}','${r[3]}')">`;
						}

					}
				},
				{
					data: 7,
					render: (d, t, r, m) => {
						return `<button type="button" class="btn btn-link" 
		onclick="deleteServiceOrder('${d}','${tableID}','${category}','${r[11]}')"  data-toggle="modal" data-target="#deleteSampleModel"><i class="fa fa-times"></i></button>`;
					}
				},
				{
					data: 8
				},
				{
					data: 9
				}

			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if (parseInt(aData[10]) === 1) {
					let value = 1;
					let status = '';
					$('td:eq(4)', nRow).html(`<input type="checkbox" ${status} id="sampleCollectionCheckbox_${aData[6]}" 
				onclick="serviceOrderBillingInfo(${aData[6]},'${category}','${tableID}','${category}',${value},${aData[12]},'${aData[2]}','${aData[13]}','${aData[5]}','${aData[3]}')">`);
				} else {
					let value = 0;
					let status = '';
					$('td:eq(4)', nRow).html(`<input type="checkbox" ${status} id="sampleCollectionCheckbox_${aData[6]}" 
			onclick="serviceOrderBillingInfo(${aData[6]},'${category}','${tableID}','${category}',${value},${aData[12]},'${aData[2]}','${aData[13]}','${aData[5]}','${aData[3]}')">`);
				}
				$('td:eq(5)', nRow).html(`<button type="button" class="btn btn-link" 
onclick="deleteServiceOrder('${aData[7]}','${tableID}','${category}','${aData[11]}')" data-toggle="modal" data-target="#deleteSampleModel"><i class="fa fa-times"></i></button>`);
			},
			fnInitComplete: function (oSetting, json) {
				this.api().columns().every(function () {
					var column = this;

					if (column[0][0] == 0 || column[0][0] == 1) {
						if (column[0][0] == 0) {
							columnName = "Bed No.";
						}
						if (column[0][0] == 1) {
							columnName = "Patient Name";
						}
						var select = $('<select><option value="">' + columnName + '</option></select>')
							.appendTo($(column.header()).empty()).on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
								console.log(val);
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});
						column.data().unique().sort().each(function (d, j) {
							let value = '';
							if (column[0][0] == 0) {
								value = d;
							}
							if (column[0][0] == 1) {
								value = d;
							}

							select.append('<option value="' + value + '">' + value + '</option>')
						});
					}
				});
			}
		});
	});
}

function serviceOrderBillingInfo(service_order_id, service_no, tablename, category, value, patient_id, order_id, serviceIDS, service_names, service_numbers) {
	if ($("#sampleCollectionCheckbox_" + service_order_id).prop('checked') == true) {
		var confirm_service_given = 1;
		$("#ListPathologyServicesModal").modal('show');
		$("#service_Path_file").val('');
		var forminputs = `
		<input type="hidden" id="Pservice_order_id" name="Pservice_order_id" value="${service_order_id}">
		<input type="hidden" id="Pservice_no" name="Pservice_no" value="${service_no}">
		<input type="hidden" id="Ptablename" name="Ptablename" value="${tablename}">
		<input type="hidden" id="Pcategory" name="Pcategory" value="${category}">
		<input type="hidden" id="Pvalue" name="Pvalue" value="${value}">
		<input type="hidden" id="Ppatient_id" name="Ppatient_id" value="${patient_id}">
		<input type="hidden" id="Porder_id" name="Porder_id" value="${order_id}">
		<input type="hidden" id="PserviceIDS" name="PserviceIDS" value="${serviceIDS}">
		<input type="hidden" id="Pservice_numbers" name="Pservice_numbers" value="${service_numbers}">
		`;
		var arr = service_names.split(",");
		var arr1 = serviceIDS.split(",");

		$("#PathologyServiceList").html("");
		var data1 = ``;
		$(arr).each(function (index, data) {

			data1 += `<input type="checkbox" checked name="SampleCollectionPathService[]"  id="SampleCollectionService_${index}" value="${arr1[index]}" > ${data} <br>`;
		});
		$("#PathologyServiceList").html(data1);
		$("#PathologyServiceList").append(forminputs);

	}

}

$("#PathologyFileUploadationForm").validate({
	rules: {
		service_file: {
			required: true,
		},

	},
	messages: {
		service_file: {
			required: "Please Select File"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		var file = document.getElementById("service_Path_file");
		if (file.files.length == 0) {
			$("#radiology_diles_error").html("Please Select File");
			// app.errorToast("No files selected");
		} else {
			var formData = new FormData(form);
			formData.append('confirm_service_given', '1');
			formData.append('sample_pickup', '1');
			SavePathologyProgress(formData);
		}

	}
});

function SavePathologyProgress(formData) {
	app.request(baseURL + "getserviceOrderBillingInfo", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			$("#ListPathologyServicesModal").modal('hide');
			getSampleCollectionTable($("#Pcategory").val(), $("#Ptablename").val(), $("#psampleAllPatient").val());

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function getPathologyData(service_order_id, service_no, tablename, category, value, patient_id, order_id, serviceIDS) {
	serverRequest("GetPathologyServiceList", {
		service_order_id: service_no,
		patient_id: patient_id,
		order_id: order_id,
		serviceIDS: serviceIDS
	}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);

		var user_data = response.option;
		if (response.status == 200) {
			app.successToast(response.body);
			deleteServiceOrderItem("sampleItem_" + labcode);
			getSampleCollectionTable('PATHOLOGY', 'pathologySampleTable', $("#psampleAllPatient").val());

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));

}

function deleteServiceOrder(service_order_id, tablename, category, data) {
	let samples = data.split(',');
	let sampleData = samples.map(s => {
		let object = s.split("||");
		return {
			labcode: object[1],
			name: object[0],
			patientId: object[2]
		};
	})
	let template = ``;
	template += sampleData.map(t => {
		return `<li class="list-group-item d-flex justify-content-between align-items-center" id="sampleItem_${t.labcode}">
                        ${t.name}
                        <button class="btn btn-primary" onclick="removeServiceOrderItem('${t.labcode}',${t.patientId})"><i class="fa fa-trash"></i></button>
                      </li>`
	}).join(" ")
	$("#sampleList").empty();
	$("#sampleList").append(template);

}

function removeServiceOrderItem(labcode, patient_id) {

	serverRequest("deleteServiceOrder", {service_order_id: labcode, patient_id: patient_id}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);

		var user_data = response.option;
		if (response.status == 200) {
			app.successToast(response.body);
			deleteServiceOrderItem("sampleItem_" + labcode);
			getSampleCollectionTable('PATHOLOGY', 'pathologySampleTable', $("#psampleAllPatient").val());

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));

}

function deleteRadiolgyServiceOrder(service_order_id, tablename, category, data) {
	let samples = data.split(',');
	let sampleData = samples.map(s => {
		let object = s.split("||");
		return {
			labcode: object[1],
			name: object[0],
			patientId: object[2]
		};
	})
	let template = ``;
	template += sampleData.map(t => {
		return `<li class="list-group-item d-flex justify-content-between align-items-center" id="sampleItem_${t.labcode}">
                        ${t.name}
                        <button class="btn btn-primary" onclick="removeRadiologyServiceOrderItem('${t.labcode}',${t.patientId})"><i class="fa fa-trash"></i></button>
                      </li>`
	}).join(" ")
	$("#sampleList").empty();
	$("#sampleList").append(template);

}

function removeRadiologyServiceOrderItem(labcode, patient_id) {
	let confirmAction = confirm("Are you sure to you want confirm service");
	if (confirmAction) {
		serverRequest("deleteServiceOrder", {service_order_id: labcode, patient_id: patient_id}).then(response => {
			// $.LoadingOverlay("hide");
			//console.log(response);

			var user_data = response.option;
			if (response.status == 200) {
				app.successToast(response.body);
				// deleteServiceOrderItem("sampleItem_"+labcode);
				getSampleCollectionTable1('RADIOLOGY', 'radiologySampleTable', $("#sampleAllPatient").val());

			} else {
				app.errorToast(response.body);
			}
		}).catch(error => console.log(error));
	}

}

function getAllPatients(category) {
	serverRequest("getSampleAllPatients", {category: category}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			// console.log(response);
			if (category == 'RADIOLOGY') {
				$("#sampleAllPatient").empty("");
				$("#sampleAllPatient").append(user_data);
				$("#sampleAllPatient").select2();
			} else {
				$("#psampleAllPatient").empty("");
				$("#psampleAllPatient").append(user_data);
				$("#psampleAllPatient").select2();
			}


		} else {
			if (category == 'RADIOLOGY') {
				$("#sampleAllPatient").empty("");
				$("#sampleAllPatient").append(user_data);
				$("#sampleAllPatient").select2();
			} else {
				$("#psampleAllPatient").empty("");
				$("#psampleAllPatient").append(user_data);
				$("#psampleAllPatient").select2();
			}
		}
	}).catch(error => console.log(error));
}

function getSampleCollectionTable1(category, tableID, patient_id = null) {
	// var p_id = $('#p_id').val();
	// console.log(""+tableID+"");
	let formData = new FormData();
	formData.set("category", category);
	// if(category=="RADIOLOGY"){
	let zone = $("#sampleAllPatient").val();
	if (zone !== null) {
		formData.set("zone_id", zone);
	}
	// console.log(zone);
	var userTypeCheck = $("#userTypeCheck").val();
	// } else{
	// 	let zone = $("#psampleAllPatient").val();
	// 	if(zone !==null ){
	// 		formData.set("zone_id", zone);
	// 	}
	// }

	// if(patient_id !=null){
	// 	formData.set("patient_id", patient_id);
	// }

	app.request(baseURL + "getRadiologySampleCollectionTable", formData).then(res => {

		$(`#${tableID}`).DataTable({
			destroy: true,
			responsive: true,
			order: [8, 'desc'],
			autoWidth: false,
			data: res.data,
			columns: [
				{
					data: 0
				},
				{
					data: 1
				},
				{
					data: 2
				},
				{
					data: 3
				},
				{
					data: 5
				},
				{
					data: 7,
					render: (d, t, r, m) => {
						if (parseInt(r[10]) === 1) {
							let value = 1;
							return `<input type="checkbox" checked id="sampleCollectionCheckbox1_${r[6]}"
 								onclick="getRadiologyUploadModal('${r[13]}',${r[12]},'${r[6]}')" class="checkboxClose">`;
						} else {
							let value = 0;
							return `<input type="checkbox"  id="sampleCollectionCheckbox1_${r[6]}" 
			onclick="getRadiologyUploadModal('${r[13]}',${r[12]},'${r[6]}')" class="checkboxClose">`;
						}

					}
				},
				{
					data: 7,
					render: (d, t, r, m) => {

						if (userTypeCheck == 2) {
							return `<button type="button" class="btn btn-link" 
		onclick="removeRadiologyServiceOrderItem('${r[13]}','${r[12]}')"  data-toggle="modal" data-target="#deleteSampleModel"><i class="fa fa-times"></i></button>`;
						} else {
							return ` `;
						}
					}
				},
				{
					data: 8
				},
				{
					data: 9
				}
				// ,
				// {
				// 	data: 14
				// },
				// {
				// 	data: 15
				// },
				// {
				// 	data: 16
				// }


			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if (parseInt(aData[10]) === 1) {
					let value = 1;
					let status = 'checked';
					$('td:eq(5)', nRow).html(`<input type="checkbox" ${status} id="sampleCollectionCheckbox1_${aData[6]}" 
				onclick="getRadiologyUploadModal('${aData[13]}',${aData[12]},'${aData[6]}')" class="checkboxClose">`);
				} else {
					let value = 0;
					let status = '';
					$('td:eq(5)', nRow).html(`<input type="checkbox" ${status} id="sampleCollectionCheckbox1_${aData[6]}" 
			onclick="getRadiologyUploadModal('${aData[13]}',${aData[12]},'${aData[6]}')" class="checkboxClose">`);
				}

				if (userTypeCheck == 2) {
					$('td:eq(6)', nRow).html(`<button type="button" class="btn btn-link" 
onclick="removeRadiologyServiceOrderItem('${aData[13]}','${aData[12]}')"><i class="fa fa-times"></i></button>`);
				} else {
					$('td:eq(6)', nRow).html(` `);
					;
				}
				// if(aData[14]!=""){
				// 	$('td:eq(9)', nRow).html(`<button class="btn btn-link" onclick="radiologyDownloadButtons('${aData[14]}')"><i class="fa fa-download"></i></button></div>`);
				// }
				// else
				// {
				// 	$('td:eq(9)', nRow).html(`-`);
				// }
				// $('td:eq(10)', nRow).html(`${aData[15]}`);
				// $('td:eq(11)', nRow).html(`${aData[16]}`);
			},
			fnInitComplete: function (oSetting, json) {
				this.api().columns().every(function () {
					var column = this;
					var columnName = "";

					if (column[0][0] == 0 || column[0][0] == 1) {
						if (column[0][0] == 0) {
							columnName = "Bed No.";
						}
						if (column[0][0] == 1) {
							columnName = "Patient Name";
						}
						var select = $('<select><option value="">' + columnName + '</option></select>')
							.appendTo($(column.header()).empty()).on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
								console.log(val);
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});
						column.data().unique().sort().each(function (d, j) {
							let value = '';
							if (column[0][0] == 0) {
								value = d;
							}
							if (column[0][0] == 1) {
								value = d;
							}

							select.append('<option value="' + value + '">' + value + '</option>')
						});
					}
				});
			}

		});
	});
}

function getRadiologyUploadModal(serviceIDS, patient_id, Id) {
	if ($("#sampleCollectionCheckbox1_" + Id).prop('checked') == true) {
		$("#openRadiologyUploadButton").click();

		$("#radioServiceIds").val(serviceIDS);
		// console.log(serviceIDS);
		$("#radioPatientId").val(patient_id);
	} else {
		var formData = new FormData();
		formData.append('radioServiceIds', serviceIDS);
		formData.append('patient_id', patient_id);
		formData.append('normal_status', '');
		formData.append('confirm_service_given', '0');
		formData.append('service_file[]', '');
		formData.append('sample_pickup', '0');

		// uploadRadiologyUplodForm(formData,0);

	}

}

$("#radioFileUploadationForm").validate({
	rules: {
		service_file: {
			required: true,
		},
		normal_status: {
			required: true,
		},

	},
	messages: {
		service_file: {
			required: "Please Select File"
		},
		normal_status: {
			required: "Please Select Status"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		var file = document.getElementById("service_file");
		if (file.files.length == 0) {
			$("#radiology_diles_error").html("Please Select File");
			// app.errorToast("No files selected");
		} else {
			var formData = new FormData(form);
			formData.append('confirm_service_given', '1');
			formData.append('sample_pickup', '1');
			uploadRadiologyUplodForm(formData, 1);
		}

	}
});

function uploadRadiologyUplodForm(data, btnCheck) {
	app.request(baseURL + "uploadRadioUplodation", data).then(res => {
		if (res.status === 200) {
			app.successToast(res.body);
			getSampleCollectionTable1('RADIOLOGY', 'radiologySampleTable');
			if (btnCheck == 1) {
				$("#openRadiologyUploadButton").click();

				document.getElementById('radioFileUploadationForm').reset();
				getSampleCollectionTable2('RADIOLOGY', 'radiologySampleHistoryTable');
			}
			//
			// location.reload();
		} else {
			app.errorToast(res.body);
		}
	}).catch(error => {
		console.log(error);
	})
}

function radiologyDownloadButtons(download_data) {
	let samples = download_data.split(',');
	var filedata = [];
	var interval = samples.length;
	if (samples.length > 0) {
		for (var i = 0; samples.length > 0; i++) {
			// filedata.push(samples[i]);
			if (i >= samples.length) {
				break;
			}
			var a = document.createElement("a");
			a.setAttribute('href', baseURL + samples[i]);
			a.setAttribute('download', '');
			a.setAttribute('target', '_blank');
			a.click();

		}

		// console.log(filedata);
	}

}

function getSampleCollectionTable2(category, tableID, patient_id = null) {

	let formData = new FormData();
	formData.set("category", category);
	// if(category=="RADIOLOGY"){
	let zone = $("#rsampleAllPatient").val();
	if (zone !== null) {
		formData.set("zone_id", zone);
	}

	$('#' + tableID).dataTable().fnClearTable();
	$('#' + tableID).dataTable().fnDestroy();
	app.request(baseURL + "getRadiologySampleHistoryTable", formData).then(res => {

		$(`#${tableID}`).DataTable({
			destroy: true,
			responsive: true,
			order: [9, 'desc'],
			autoWidth: false,
			data: res.data,
			columns: [
				{
					data: 0
				},
				{
					data: 1
				},
				{
					data: 2
				},
				{
					data: 3
				},
				{
					data: 5
				},
				{
					data: 14,
					render: (d, t, r, m) => {

						if (r[14] != "") {
							return `<button class="btn btn-link" onclick="radiologyDownloadButtons('${r[14]}')"><i class="fa fa-download"></i></button>`;
						} else {
							return `<input type="checkbox" id="sampleCollectionCheckbox1_${r[6]}" 
	onclick="getRadiologyUploadModal('${r[13]}',${r[12]},'${r[6]}')" class="checkboxClose"><span> Pending</span> `;
						}
					}

				},
				{
					data: 15,

				},
				{
					data: 16
				},
				{
					data: 8
				},
				{
					data: 9
				}
			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

				if (aData[14] != "") {
					$('td:eq(5)', nRow).html(`<button class="btn btn-link" onclick="radiologyDownloadButtons('${aData[14]}')"><i class="fa fa-download"></i></button>`);
				} else {
					$('td:eq(5)', nRow).html(`<input type="checkbox" id="sampleCollectionCheckbox1_${aData[6]}" 
onclick="getRadiologyUploadModal('${aData[13]}',${aData[12]},'${aData[6]}')" class="checkboxClose"><span> Pending</span>`);
				}

			},
			fnInitComplete: function (oSetting, json) {
				this.api().columns().every(function () {
					var column = this;

					if (column[0][0] == 0 || column[0][0] == 1) {
						if (column[0][0] == 0) {
							columnName = "Bed No.";
						}
						if (column[0][0] == 1) {
							columnName = "Patient Name";
						}
						var select = $('<select><option value="">' + columnName + '</option></select>')
							.appendTo($(column.header()).empty()).on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
								console.log(val);
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});
						column.data().unique().sort().each(function (d, j) {
							let value = '';
							if (column[0][0] == 0) {
								value = d;
							}
							if (column[0][0] == 1) {
								value = d;
							}

							select.append('<option value="' + value + '">' + value + '</option>')
						});
					}
				});
			}

		});
	});

}

function deletePathService(id) {
	serverRequest("deleteserviceOrderTranscation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getServiceOrderPlaceTimeTable(localStorage.getItem("patient_id"));

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function getNotConfirmReport(confirm_status, category) {
	let formData = new FormData();
	let zone;
	if (category == "RADIOLOGY") {
		if (confirm_status == 0) {
			zone = $("#sampleAllPatient").val();
		} else {
			zone = $("#rsampleAllPatient").val();
		}
	} else if (category == "PATHOLOGY") {
		zone = $("#psampleAllPatient").val();
	}

	if (zone !== null) {
		formData.set("zone_id", zone);
	}
	formData.set("confirm_status", confirm_status);
	formData.set("category", category);

	var userTypeCheck = $("#userTypeCheck").val();

	app.request(baseURL + "getNotConfirmReport", formData).then(res => {
		if (res.status == 200) {
			var loginFormObject = {};

			// let patient = $("#OtherServiceAllHistoryPatient").val();
			// loginFormObject["patient_id"]=patient;
			loginFormObject["zone"] = zone;
			loginFormObject["confirm_status"] = confirm_status;
			loginFormObject["category"] = category;

			const x = JSON.stringify(loginFormObject);
			window.location.href = baseURL + "getRadiologyNotConfirmReport?data=" + x;
		} else {
			app.errorToast('Data Not Found For Download');
		}
	});
}

