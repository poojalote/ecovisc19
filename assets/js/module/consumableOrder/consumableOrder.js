$(document).ready(function () {

	// var patient_id = localStorage.getItem("patient_id");
	// billing_services();
	// getBillingTable(patient_id);
	getConsumableGroup();
	getComapanyUsers();
	receiveCunsumablelOrderHistoryTable();
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

function getConsumableGroup() {
	// $.LoadingOverlay("show");
	serverRequest("getConsumableGroup", null).then(response => {
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
	serverRequest("getConsumableComapanyUsers", null).then(response => {
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
	serverRequest("getConsumableDescription", {id: id}).then(response => {
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
				url: baseURL + "get-materialConsumableDescription",
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
				url: baseURL + "get-materialConsumableDescription",
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

$('#add_consumable_order_form').validate({
	rules: {
		hospital_name: {
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
		var form_data = document.getElementById('add_consumable_order_form');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		var patient_id=localStorage.getItem("patient_id");
		Form_data.append("patient_id", patient_id);

		$.ajax({
			type: "POST",
			url: baseURL + "add_consumable_order",
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
					 receiveCunsumablelOrderHistoryTable();
					
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
	document.getElementById('add_consumable_order_form').reset();
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
			 	var patient_id=localStorage.getItem("patient_id");
			// var patient_id = $('#serviceOrder_patient_id').val();
			// var patientAdhar = $('#serviceOrder_patient_adhar').val();
var object = {"itemArray": itemArray,
			"hospital_order_id":hospital_order_id,
			"patient_id":patient_id
			};
			$.ajax({
				type: "post",
				url: baseURL + "placeConsumableMaterialOrder",
				data: object,
				dataType: "json",
				success: function (result) {
if(result.status==200)
{
						app.successToast(result.body);
						document.getElementById('add_consumable_order_form').reset();
						document.getElementById('att_material_list').reset();
						receiveCunsumablelOrderHistoryTable();
						$('#material_list_itemTable').empty();
						$('#material_group_name').select2('');
						$('#hospital_order_by').select2('');
						$('#material_description').select2('');
						$('#newMaterialListPanel').removeClass('show');
						$('#saveInOrderButton').addClass('d-none');
						// getFormsInNormalPosition();
						$('#material_group_name').removeAttr('disabled', false);
						$("#hospital_order_by").removeAttr('disabled', false);
						$("#order_for_hospital").removeAttr('readonly', false);
						
						 $('#hospitalOrderCreateButton').removeClass('d-none');
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

function receiveCunsumablelOrderHistoryTable(id=null)
{
	// var id=1;
	// console.log(id);
	var patient_id=localStorage.getItem("patient_id");
	var id1=id;
	if(id==null){var id1=1;}
	app.dataTable('receiveCunsumablelOrderHistoryTable', {
		url: baseURL + "getReceiveConsumableOrderHistoryTable",
		data: {id: id1,patient_id:patient_id}
	}, [
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
                            
                            `;
				}
			}
		}
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// $('td:eq(2)', nRow).html(`<div>${aData[2]}</div>`);
		// $('td:eq(1)', nRow).html(`<div>${aData[10] !== null && aData[10] !== '0000-00-00 00:00:00' ? aData[10] : '-'}</div>`);
		
		$('td:eq(5)',nRow).html(`${aData[8]}`);
		if (parseInt(aData[6]) === 1) {
			$('td:eq(6)', nRow).html(` <button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${aData[5]}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${aData[5]},${aData[7]},${aData[6]}),getMaterialDescriptionListTable(${aData[5]})">
                                 view order
                            </button>`);
		//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		} else {


			$('td:eq(6)', nRow).html(`
                            <button class="btn btn-primary btn-action mr-1" type="button" id="viewHospitalOrderButtin_${aData[5]}" data-toggle="modal" data-target="#hospitalOrderModal"
                                  onclick="getViewOrderData(${aData[5]},${aData[7]},${aData[6]}),getMaterialDescriptionListTable(${aData[5]})">
                                 view order
                            </button>
                            <button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteHospitalOrderTranscation(${aData[5]})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>
                            
                            `);
		//	$('td:eq(7)',nRow).html(`${aData[11]}`);
		}

	})


}
function getViewOrderData(hos_order_id,group_id,receive)
{
	$("#view_hospital_order_id").val(hos_order_id);
	$("#receive_hospital_order_id").val(hos_order_id);
	$("#view_hospital_group_id").val(group_id);
	
	serverRequest("getViewConsumableOrderData", {hos_order_id: hos_order_id,group_id:group_id,receive:receive}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#viewMaterialGroupName").val(response.group_name);
			loadMaterialDescription2();
			// $("#view_material_description").empty("");
			// $("#view_material_description").append(user_data);
			// $("#view_material_description").select2();
			$("#newMaterialViewOrderListButton").removeClass('d-none');
			$("#receiveMaterialViewOrderListButton").removeClass('d-none');
			$("#newMaterialVireOrderListPanel").removeClass('show');
			$("#receiveMaterialVireOrderListPanel").removeClass('show');
			// var itemLength = $('#hospitalOrderMaterialListTable').children().length;
			// console.log(itemLength);
			if(response.receive_status==1)
			{
				$("#newMaterialViewOrderListButton").addClass('d-none');
				$("#receiveMaterialViewOrderListButton").addClass('d-none');
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

$('#newConsumableMaterialOrderListForm').validate({
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
		var form_data = document.getElementById('newConsumableMaterialOrderListForm');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "newConsumableMaterialOrderListForm",
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

function getMaterialDescriptionListTable(order_id) {
	
	app.dataTable('hospitalOrderMaterialListTable', {
		url: baseURL + "getConsumableOrderMaterialListTable",
		data: {order_id: order_id}
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
			data: 3,
			render: (d, t, r, m) => {
				if(parseInt(r[4])=== 1){
					let value = 1;
					return ``;
				}
				else
				{
					let value = 0;
					return `<button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteHospitalOrderMaterialTranscation(${d},${order_id})"
                                  >
                                 <i class="fas fa-trash"></i>
                            </button>`;
				}
				
			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// let date = aData[2];
		// console.log(aData[11]);
		if(parseInt(aData[4])===1)
		{
			let value = 1;
			let status = 'checked';
			$('td:eq(3)', nRow).html(``);
		}
		else
		{
			let value = 0;
			let status='';
			$('td:eq(3)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="deleteHospitalOrderMaterialTranscation(${aData[3]},${order_id})"
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
	
		var form_data = document.getElementById('receiveOrderForm');
		var formdata = new FormData(form_data);
		// $.LoadingOverlay("show");

		var patient_id=localStorage.getItem("patient_id");
		formdata.append("patient_id", patient_id);

		$.ajax({
			type: "POST",
			url: baseURL + "receiveConsumableOrderForm",
			dataType: "json",
			data: formdata,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					app.successToast(result.data);
					document.getElementById('receiveOrderForm').reset();
					var allHospitalOrder=$("#allHospitalOrder").val();
					receiveCunsumablelOrderHistoryTable(allHospitalOrder);
					console.log(result.hos_order_id);
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
});


function deleteHospitalOrderMaterialTranscation(id,order_id) {
	// $.LoadingOverlay("show");
	serverRequest("deleteConsumableOrderMaterialTranscation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getConsumableMaterialDescriptionListTable(order_id);
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}
function deleteHospitalOrderTranscation(id) {
	// $.LoadingOverlay("show");
	var patient_id=localStorage.getItem("patient_id");
	serverRequest("deleteConsumableOrderTranscation", {id: id,patient_id:patient_id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			receiveCunsumablelOrderHistoryTable();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}
