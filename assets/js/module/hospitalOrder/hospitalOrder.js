$(document).ready(function () {

	// var patient_id = localStorage.getItem("patient_id");
	// billing_services();
	// getBillingTable(patient_id);
	getMaterialGroup();
	getComapanyUsers();
	getZoneID();
	// receiveHospitalOrderHistoryTable();
});

function getZoneID(){
	//ZoneID
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
			$('#ZoneID').empty();
			$('#ZoneID').append(result.body);
		} else {
			$('#ZoneID').empty();
			$('#ZoneID').append(result.body);
		}
	}).catch(e => {
		console.log('Logged ---> ', error);
		alert('something went wrong');
	});
}


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

function getMaterialGroup() {
	// $.LoadingOverlay("show");
	serverRequest("getMaterialGroup", null).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#material_group_name").empty("");
			$("#material_group_name").append(user_data);
			$("#material_group_name").select2();

		} else {
			$("#material_group_name").empty("");
			$("#material_group_name").append(user_data);
			$("#material_group_name").select2();
		}
	}).catch(error => console.log(error));
}

function getComapanyUsers() {
	// $.LoadingOverlay("show");
	serverRequest("getComapanyUsers", null).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#hospital_order_by").empty("");
			$("#hospital_order_by").append(user_data);
			$("#hospital_order_by").select2();

		} else {
			$("#hospital_order_by").empty("");
			$("#hospital_order_by").append(user_data);
			$("#hospital_order_by").select2();
		}
	}).catch(error => console.log(error));
}

function getMaterialDescription(id) {
	// $.LoadingOverlay("show");
	serverRequest("getMaterialDescription", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#material_description").empty("");
			$("#material_description").append(user_data);
			$("#material_description").select2();

		} else {
			$("#material_description").empty("");
			$("#material_description").append(user_data);
			$("#material_description").select2();
		}
	}).catch(error => console.log(error));
}

function loadMaterialDescription() {


	$("#material_description").select2(
		{
			ajax: {
				url: baseURL + "get-materialDescription",
				type: "post",
				dataType: "json",
				placeholder: "Material Name",
				data: function (params) {
					let setValue = $('#material_group_name').val();

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

function loadMaterialDescription2() {


	$("#view_material_description").select2(
		{
			ajax: {
				url: baseURL + "get-materialDescription",
				type: "post",
				dataType: "json",
				placeholder: "Material Name",
				data: function (params) {
					let setValue = $('#view_hospital_group_id').val();

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
			minimumInputLength: 3,
			dropdownParent: $('#hospitalOrderModal')
		}
	);
}

$('#add_hospital_order_form').validate({
	rules: {
		hospital_name: {
			required: true
		},
		department: {
			required: true
		},
		ZoneID: {
			required: true
		},
		material_group_name: {
			required: true
		},
		hospital_order_by: {
			required: true
		},
		order_for_hospital: {
			required: true
		}
	},
	messages: {
		hospital_name: {
			required: "Enter Hospital Name"
		},
		department: {
			required: "Please select Department"
		},
		ZoneID: {
			required: "Please select Zone"
		},
		material_group_name: {
			required: "Please select Material group"
		},
		hospital_order_by: {
			required: "Please Select Order By"
		},
		order_for_hospital: {
			required: "Please Enter order for hospital yes or no"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		var form_data = document.getElementById('add_hospital_order_form');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "add_hospital_order",
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					app.successToast(result.data);
					$("#hospital_order_no").val(result.order_no);
					$("#hospital_order_date").val(result.order_date);
					$("#hospital_order_id").val(result.insert_id);
					loadMaterialDescription();
					$("#newMaterialListButton").click();

					$("#material_group_name").select2({disabled:'readonly'});
					$("#hospital_order_by").select2({disabled:'readonly'});

					$("#order_for_hospital").prop('readonly', true);

					$('#hospitalOrderCreateButton').addClass('d-none');
					receiveHospitalOrderHistoryTable();
				} else {
					app.errorToast(result.data);
				}

				// $.LoadingOverlay("hide");

			}, error: function (error) {
				console.log('Logged ---> ', error);
				// $.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});

function add_material_item_to_list()
{
	var material_description = $('#material_description option:selected').toArray().map(item => item.text).join();
	var	material_id = document.getElementById('material_description').value;
	var	material_quantity = document.getElementById('material_quantity').value;
	var	material_unit = document.getElementById('material_unit').value;
	var	hospital_orderId = document.getElementById('hospital_order_id').value;
	var length = $('#material_list_itemTable').children().length;
	var code = Math.floor(Math.random() * (999 - 100 + 1) + 100);
	var itemObject = btoa(JSON.stringify({material_id: material_id, material_description: material_description,material_quantity: material_quantity, material_unit:material_unit,hospital_order_id:hospital_order_id}));
	if (material_description !== '' && material_description !== null && material_description !== 'Select Material Description' && material_id !== '' && material_id !== null)
	{
		// var button_id="hospital_order_"+material_id;
		var itemTemplat = `<tr id="hospital_order_${material_id}" data-hospital="${itemObject}">
            <td>
                ${material_description}
            </td>
			<td>
				${material_quantity}
			</td>
			<td>
				${material_unit}
			</td>
            <td>
            <button class="border-0 btn-transition btn btn-outline-primary" onclick="deleteMaterialOrderItem('hospital_order_${material_id}')"> <i class="fa fa-trash"></i>
               </button>
            </td>
            </tr>`;
		$('#material_list_itemTable').append(itemTemplat);
		$('#material_description').val('');
		$('#material_description').select2({allowClear: true});
		loadMaterialDescription();
		//
		$('#material_quantity').val('1');
		getSaveInButton();
	}
	else
	{
		$('#material_description').focus();
	}
}

function deleteMaterialOrderItem(item) {
	$('#' + item).remove();
	getSaveInButton();
}

function getSaveInButton()
{
	var itemLength = $('#material_list_itemTable').children().length;
	if (itemLength > 0) {
		$('#saveInOrderButton').removeClass('d-none');
	}
	else{
		$('#saveInOrderButton').addClass('d-none');
	}
}
function getFormsInNormalPosition()
{
	document.getElementById('add_hospital_order_form').reset();
	document.getElementById('att_material_list').reset();
	$('#material_list_itemTable').empty();
	$('#material_group_name').select2('');
	$('#hospital_order_by').select2('');
	$('#material_description').select2('');
	$('#newMaterialListPanel').removeClass('show');
	$('#saveInOrderButton').addClass('d-none');

	$('#material_group_name').removeAttr('disabled', false);
	$("#hospital_order_by").removeAttr('disabled', false);
	$("#order_for_hospital").removeAttr('readonly', false);

	$('#hospitalOrderCreateButton').removeClass('d-none');
}

function save_hospital_order_list()
{
	var itemLength = $('#material_list_itemTable').children().length;
	if (itemLength > 0) {
		var itemArray = [];
		$('#material_list_itemTable').children().each(function (e) {
			itemArray.push(JSON.parse(atob($(this)[0].dataset['hospital'])));
		});
		var hospital_order_id = $('#hospital_order_id').val();
		// var patient_id = $('#serviceOrder_patient_id').val();
		// var patientAdhar = $('#serviceOrder_patient_adhar').val();
		var object = {"itemArray": itemArray,
			"hospital_order_id":hospital_order_id
		};
		$.ajax({
			type: "post",
			url: baseURL + "placeHospitalMaterialOrder",
			data: object,
			dataType: "json",
			success: function (result) {
				if(result.status==200)
				{
					app.successToast(result.body);
					document.getElementById('add_hospital_order_form').reset();
					document.getElementById('att_material_list').reset();
					receiveHospitalOrderHistoryTable();
					$('#material_list_itemTable').empty();
					$('#material_group_name').select2('');
					$('#hospital_order_by').select2('');
					$('#material_description').select2('');
					$('#newMaterialListPanel').removeClass('show');
					$('#saveInOrderButton').addClass('d-none');

					$('#material_group_name').removeAttr('disabled', false);
					$("#hospital_order_by").removeAttr('disabled', false);
					$("#order_for_hospital").removeAttr('readonly', false);

					$('#hospitalOrderCreateButton').removeClass('d-none');
					// getFormsInNormalPosition();
					// getPrescriptionTable();
					// getServiceOrderPlaceTimeTable(localStorage.getItem("patient_id"));
					// clearListServiceItem();
				}
				else
				{
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

	}
	else
	{
		app.errorToast('Add service in list');
	}
}

function receiveHospitalOrderHistoryTable(id=null)
{
	// var id=1;
	// console.log(id);
	var id1=id;
	if(id==null){var id1=1;
		$("#allHospitalOrder").val(id1);
	}
	app.dataTable('receiveHospitalOrderHistoryTable', {
		url: baseURL + "getReceiveHospitalOrderHistoryTable",
		data: {id: id1}
	}, [
		{
			data: 0,
		},
		{
			data: 1,
		},
		{
			data: 9
		},
		{
			data: 2
		},
		{
			data: 3
		},
		{
			data: 4
		},
		{
			data: 8
		},

		{
			data: 5,
			render: (d, t, r, m) => {
				if (parseInt(r[6]) === 1) {
					return `<button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${d}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${r[5]},${r[7]},${r[6]}),getMaterialDescriptionListTable(${d})">
                                 view order
                            </button>
							<button class="btn btn-primary btn-action mr-1" type="button" id="Printorder_${d}" 
                                  onclick="printOrder(${r[5]})">
                                Print Order
                            </button>
                           `;
				} else {


					return `
                            <button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${d}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${r[5]},${r[7]},${r[6]}),getMaterialDescriptionListTable(${d})">
                                 view order
                            </button>
                            <button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteserviceOrderTranscation(${d})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>
							<button class="btn btn-primary btn-action mr-1" type="button" id="Printorder_${d}" 
                                  onclick="printOrder(${r[5]})">
                                Print Order
                            </button>
                            
                            `;
				}
			}
		}
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// $('td:eq(2)', nRow).html(`<div>${aData[2]}</div>`);
		// $('td:eq(1)', nRow).html(`<div>${aData[10] !== null && aData[10] !== '0000-00-00 00:00:00' ? aData[10] : '-'}</div>`);

		$('td:eq(6)',nRow).html(`${aData[8]}`);
		if (parseInt(aData[6]) === 1) {
			$('td:eq(7)', nRow).html(` <button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${aData[5]}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${aData[5]},${aData[7]},${aData[6]}),getMaterialDescriptionListTable(${aData[5]})">
                                 view order
                            </button>
							<button class="btn btn-primary btn-action mr-1" data-backdrop="false" data-toggle="modal" data-target="#Modal_printDiv"  type="button" id="Printorder_btn" 
                                  onclick="printOrder(${aData[5]})">
                                 Print order
                            </button>
							`);
			//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		} else {


			$('td:eq(7)', nRow).html(`
                            <button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${aData[5]}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${aData[5]},${aData[7]},${aData[6]}),getMaterialDescriptionListTable(${aData[5]})">
                                 view order
                            </button>
                            <button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteHospitalOrderTranscation(${aData[5]})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-primary btn-action mr-1" data-backdrop="false" data-toggle="modal" data-target="#Modal_printDiv" type="button" id="Printorder_btn" 
                                  onclick="printOrder(${aData[5]})">
                                 Print order
                            </button>
                            `);
			//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		}

	})


}



function inventriesTable(){
	app.dataTable('InventriTableData', {
		url: baseURL + "getTableInventries",

	}, [
		{
			data: 0,
		},
		{
			data: 1,
		},
		{
			data: 4,
		},
		{
			data: 5,
		},
		{
			data: 3,
			render: (d, t, r, m) => {
				var btn_consume_medicine="<button class='btn btn-primary' onclick='consume_medicine("+r[3]+","+r[5]+")'>Consume Medicine</button>";
				var history="<button class='btn btn-primary' onclick='get_history("+r[3]+")'>History</button>";
				var allhistory="<button class='btn btn-primary' onclick='get_detailhistory("+r[3]+")'>Detail History</button>";
				return `${btn_consume_medicine} ${history} ${allhistory}`;
			}
		}
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		var btn_consume_medicine="<button class='btn btn-primary' onclick='consume_medicine("+aData[3]+","+aData[5]+")'>Consume Medicine</button>";
		var history="<button class='btn btn-primary' onclick='get_history("+aData[3]+")'>History</button>";
		var allhistory="<button class='btn btn-primary' onclick='get_detailhistory("+aData[3]+")'>Detail History</button>";

		$('td:eq(4)', nRow).html(`${btn_consume_medicine}  ${history} ${allhistory}`);


	})
}

function consume_medicine(id,balance){
	$("#Modal_Consume_Medicine").modal('show');
	$("#material_item_id").val(id);
	$('#consumeForm').trigger("reset");
	$('#patientId').html("");
	$("#quantityToPatient").attr({     // substitute your own
		"max" : balance          // values (or variables) here
	});
	get_zone_id();

}

function get_history(id){
	$("#Modal_summarised_history").modal('show');
	$.ajax({
		type: 'POST',
		url: baseURL + "GetSummarisedHistoryData",
		data:{id},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			$('#tableHistory').dataTable().fnDestroy();
			if (success.status == 200) {

				$("#historyTableData").html(user_data);
				$("#tableHistory").dataTable();
//console.log(success.body);
			} else {
				$("#historyTableData").html(user_data);
				$("#tableHistory").dataTable();
			}

		}
	});
}

function get_detailhistory(id){
	//
	var status1=1;
	$("#Modal_Detail_history").modal('show');
	$.ajax({
		type: 'POST',
		url: baseURL + "GetSummarisedHistoryData",
		data:{id,status1},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			$('#tableHistory1').dataTable().fnDestroy();
			if (success.status == 200) {

				$("#historyDetailTableData").html(user_data);

				$("#tableHistory1").dataTable();
//console.log(success.body);
			} else {
				$("#historyDetailTableData").html(user_data);
				$("#tableHistory1").dataTable();
			}

		}
	});
}

function ReverseOrderConsume(id,material_id){
	$.ajax({
		type: 'POST',
		url: baseURL + "ReverseOrderConsume",
		data:{id,material_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				app.successToast(success.body);
				get_history(material_id);
				inventriesTable();
				$("#Modal_summarised_history").modal('hide');
//console.log(success.body);
			} else {
				app.errorToast(success.body);
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
				$("#selectZone").html(user_data);
//console.log(success.body);
			} else {

			}

		}

	});
}
function printOrder(id){

	$("#printDiv").html("");
	$.ajax({
		type: 'POST',
		url: baseURL + "GetDataPrintDiv",
		data:{id},
		success: function (success) {
			success = JSON.parse(success);

			if (success.status == 200) {
				var user_data = success.data;
				$("#printDiv").html(user_data);
			} else {
				$("#printDiv").html("");
			}

		}

	});
}
function getZonePatient(id){

	$("#patientId").select2(
		{
			ajax: {
				url: baseURL + "getPatientListData",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Patient Name",
				data: function (params) {

					let setValue = $('#selectZone').val();

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

$('#consumeForm').validate({
	rules: {
		selectZone: {
			required: true
		},
		patientId: {
			required: true
		},
		Quantity: {
			required: true
		},

	},
	messages: {
		selectZone: {
			required: "Select Zone"
		},
		patientId: {
			required: "Please select Patient"
		},
		Quantity: {
			required: "Please Enter Quantity"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		var form_data = document.getElementById('consumeForm');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "add_consume_details",
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {
					app.successToast(result.body);
					$('#consumeForm').trigger("reset");
					$('#patientId').html("");
					inventriesTable();

				} else {
					app.errorToast(result.data);
				}

				// $.LoadingOverlay("hide");

			}, error: function (error) {
				console.log('Logged ---> ', error);
				// $.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});

function getDataReturn(){
	var order_id=$("#receive_hospital_order_id").val();
	$("#return_hospital_order_id").val(order_id);
	serverRequest("GetOrderData", {id: order_id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			$("#ret_order_invoice_no").val(response.invoice_number);
			$("#ret_vendor_name").val(response.vendor_name);
			$("#ret_item_list").html(response.data_list);
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}
function getViewOrderData(hos_order_id,group_id,receive)
{
	$("#returnMaterialVireOrderListPanel").removeClass('show');
	$("#newMaterialVireOrderListPanel").removeClass('show');
	$("#receiveMaterialVireOrderListPanel").removeClass('show');
	$("#view_hospital_order_id").val(hos_order_id);
	$("#receive_hospital_order_id").val(hos_order_id);
	$("#view_hospital_group_id").val(group_id);

	serverRequest("getViewOrderData", {hos_order_id: hos_order_id,group_id:group_id,receive:receive}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#viewMaterialGroupName").val(response.group_name);
			// $("#view_material_description").empty("");
			// $("#view_material_description").append(user_data);
			// $("#view_material_description").select2();
			loadMaterialDescription2();
			$("#newMaterialViewOrderListButton").removeClass('d-none');
			$("#receiveMaterialViewOrderListButton").removeClass('d-none');


			$("#returnMaterialViewOrderListButton").removeClass('d-none');
			// var itemLength = $('#hospitalOrderMaterialListTable').children().length;
			// console.log(itemLength);
			if(response.receive_status==1)
			{
				$("#newMaterialViewOrderListButton").addClass('d-none');
				$("#receiveMaterialViewOrderListButton").addClass('d-none');
			}else{
			//	$("#returnMaterialViewOrderListButton").addClass('d-none');
			}

		} else {
			$("#viewMaterialGroupName").val("");
			$("#view_material_description").empty("");
			$("#view_material_description").append(user_data);
			$("#view_material_description").select2();
			$("#newMaterialViewOrderListButton").removeClass('d-none');
			$("#receiveMaterialViewOrderListButton").removeClass('d-none');

		}
	}).catch(error => console.log(error));
}

$('#newMaterialOrderListForm').validate({
	rules: {
		view_material_description: {
			required: true
		},
		view_material_quantity: {
			required: true
		},
		view_material_unit: {
			required: true
		}
	},
	messages: {
		view_material_description: {
			required: "Please select Material Description"
		},
		view_material_quantity: {
			required: "Enter Material Quantity"
		},
		view_material_unit: {
			required: "Enter Material Unit"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		var form_data = document.getElementById('newMaterialOrderListForm');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "newMaterialOrderListForm",
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					app.successToast(result.data);
					console.log(result.hos_order_id);
					getMaterialDescriptionListTable(result.hos_order_id);

				} else {
					app.errorToast(result.data);
				}

				// $.LoadingOverlay("hide");

			}, error: function (error) {
				console.log('Logged ---> ', error);
				// $.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});
let orderrate=[];
function getMaterialDescriptionListTable(order_id) {
orderrate=[];
	app.dataTable('hospitalOrderMaterialListTable', {
		url: baseURL + "gethospitalOrderMaterialListTable",
		data: {order_id: order_id}
	}, [
		{
			data: 0
		},
		{
			data: 1
		},{
			data: 13
		},
		{
			data: 2
		},
		{
			data: 3,
			render: (d, t, r, m) => {
				if(parseInt(r[4])=== 1 || parseInt(r[11])==1 || parseInt(r[12]) == 0){
					return `<input type="number" value='${r[8]}' readonly class="form-control"
					id="rate_o_${d}" name="rate_o_${d}">`;
				}
				else
				{
					return `<input type="number" value='${r[8]}' onkeyup="get_rate_calculation(${d},${r[1]})" class="form-control"
					id="rate_o_${d}" name="rate_o_${d}">`;
				}

			}
		},
		{
			data: 3,
			render: (d, t, r, m) => {
				if(parseInt(r[4])=== 1 || parseInt(r[11])== 1){
					let value = 1;
					return ``;
				}
				else
				{
					let value = 0;
					return `<button class="btn btn-primary btn-action mr-1" type="button" 
					onclick="deleteHospitalOrderMaterialTranscation(${d},${order_id})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>`;
				}

			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// let date = aData[2];
		// console.log(aData[11]);
		console.log(aData[9]);
		
		//$("#hos_invoice_amount").val();
		$("#hos_invoice_amount").val(aData[9]);
		$("#hos_order_invoice_no").val(aData[10]);
		var id=aData[3];
		 orderrate[id]=aData[8];
		if(parseInt(aData[4])===1 || (aData[11])==1 || (aData[12]) == 0)
		{
			$('td:eq(4)', nRow).html(`<input type="number" readonly value='${aData[8]}'
			class="form-control" id="rate_o_${aData[3]}" name="rate_o_${aData[3]}">`);
		}
		else
		{
			$('td:eq(4)', nRow).html(`<input type="number" value='${aData[8]}'
			onkeyup="get_rate_calculation(${aData[3]},${aData[1]})"
			class="form-control" id="rate_o_${aData[3]}" name="rate_o_${aData[3]}">`);
		}

		if(parseInt(aData[4])===1 || (aData[11])==1)
		{
			let value = 1;
			let status = 'checked';
			$('td:eq(5)', nRow).html(``);
		}
		else
		{
			let value = 0;
			let status='';
			$('td:eq(5)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button"
			onclick="deleteHospitalOrderMaterialTranscation(${aData[3]},${order_id})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>`);
		}


	})


}

$('#receiveOrderForm').validate({
	rules: {
		hos_order_invoice_no: {
			required: true
		},
		hos_vendor_name: {
			required: true
		},
		hos_invoice_amount: {
			required: true
		}
	},
	messages: {
		hos_order_invoice_no: {
			required: "Enter Invoice Number"
		},
		hos_vendor_name: {
			required: "Enter Vendor Name"
		},
		hos_invoice_amount: {
			required: "Enter Invoice Amount"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		console.log('hiiiiii');

		var order_id=$("#receive_hospital_order_id").val();
		save_individual_price(order_id);



	}
});
function add_other_data(count){
	var form_data = document.getElementById('receiveOrderForm');
	var formdata = new FormData(form_data);
	formdata.append("count",count);
	$.ajax({

		type: "POST",
		url: baseURL + "receiveOrderForm",
		dataType: "json",
		data: formdata,
		contentType: false,
		processData: false,
		success: function (result) {
			if (result.status === 200) {

				app.successToast(result.data);
				document.getElementById('receiveOrderForm').reset();
				var allHospitalOrder=$("#allHospitalOrder").val();
				receiveHospitalOrderHistoryTable(allHospitalOrder);
				$("#viewHospitalOrderButtin_"+result.hos_order_id).click();

			} else {
				app.errorToast(result.data);
			}

			// $.LoadingOverlay("hide");

		}, error: function (error) {
			console.log('Logged ---> ', error);
			// $.LoadingOverlay("hide");
			app.errorToast('something went wrong');
		}
	});
}
function save_individual_price(order_id){
	var form_data2 = document.getElementById('receiveOrderTableForm');
	var formdata = new FormData(form_data2);
	formdata. append("order_id", order_id);

	$.ajax({
		type: "POST",
		url: baseURL + "SaveIndividualPrice",
		dataType: "json",
		data: formdata,
		contentType: false,
		processData: false,
		success: function (result) {
			if (result.status === 200) {
				add_other_data(result.count);
			} else {
				app.errorToast(result.body);
			}

			// $.LoadingOverlay("hide");

		}, error: function (error) {
			console.log('Logged ---> ', error);
			// $.LoadingOverlay("hide");
			app.errorToast('something went wrong');
		}
	});
}
$('#returnOrderForm').validate({
	rules: {
		ret_item_list: {
			required: true
		},
		ret_invoice_amount: {
			required: true
		},
		ret_invoice_quantity: {
			required: true
		}
	},
	messages: {
		ret_item_list: {
			required: "Select Item"
		},
		ret_invoice_quantity: {
			required: "Enter Return Quantity"
		},
		ret_invoice_amount: {
			required: "Enter Invoice Amount"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		var form_data = document.getElementById('returnOrderForm');
		var formdata = new FormData(form_data);
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "returnOrderForm",
			dataType: "json",
			data: formdata,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					app.successToast(result.body);
					document.getElementById('returnOrderForm').reset();
					var order_id=$("#return_hospital_order_id").val();
					$("#returnMaterialVireOrderListPanel").removeClass('show');
					getMaterialDescriptionListTable(order_id)

				} else {
					app.errorToast(result.body);
				}

				// $.LoadingOverlay("hide");

			}, error: function (error) {
				console.log('Logged ---> ', error);
				// $.LoadingOverlay("hide");
				app.errorToast('something went wrong');
			}
		});
	}
});


function deleteHospitalOrderMaterialTranscation(id,order_id) {
	// $.LoadingOverlay("show");
	serverRequest("deleteHospitalOrderMaterialTranscation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getMaterialDescriptionListTable(order_id);
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}
function deleteHospitalOrderTranscation(id) {
	// $.LoadingOverlay("show");
	serverRequest("deleteHospitalOrderTranscation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			receiveHospitalOrderHistoryTable();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function getBalancequantity(id){
	var order_id=$("#return_hospital_order_id").val();

	serverRequest("getBalancequantity", {id: id,order_id:order_id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {

			$("#ret_invoice_quantity").attr({     // substitute your own
				"max" : response.quantity          // values (or variables) here
			});
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}


function get_rate_calculation(id,into_val){
	var rate=$("#rate_o_"+id).val();

	orderrate[id]=rate;
	var sum = orderrate.reduce(function(a, b){
		return (a*1) + (b*1);
	}, 0);
	$("#hos_invoice_amount").val(sum);
}
