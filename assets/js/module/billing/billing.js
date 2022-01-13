$(document).ready(function () {

	var patient_id = localStorage.getItem("patient_id");
	billing_services();
	getBillingTable(patient_id);
	getDeleteBillingTable(patient_id);

	var dt = new Date();
	var month = dt.getMonth()+1;
	var day = dt.getDate();

	var output = dt.getFullYear() + '-' +
		(month<10 ? '0' : '') + month + '-' +
		(day<10 ? '0' : '') + day;

	// document.getElementById("billing_date").min = output;

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

function billing_services() {
	// $.LoadingOverlay("show");
	serverRequest("getBillingServices", null).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#bservice_name").empty("");
			$("#bservice_name").append(user_data);
			$("#bservice_name").select2();

		} else {
			$("#bservice_name").empty("");
			$("#bservice_name").append(user_data);
			$("#bservice_name").select2();
		}
	}).catch(error => console.log(error));
}

function getServiceDescription(service_no) {
	// $.LoadingOverlay("show");
	serverRequest("getBillingServicesDescription", {service_no: service_no}).then(response => {
		// $.LoadingOverlay("hide");
		//console.log(response);
		var user_data = response.option;
		if (response.status == 200) {
			console.log(response);
			$("#bservice_desc").empty("");
			$("#bservice_desc").append(user_data);
			$("#bservice_desc").select2();

		} else {
			$("#bservice_desc").empty("");
			$("#bservice_desc").append(user_data);
			$("#bservice_desc").select2();
		}
	}).catch(error => console.log(error));
}

function getServiceRate(id) {
	// $.LoadingOverlay("show");
	serverRequest("getBillingServicesDRate", {id: id}).then(response => {
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

$('#uploadBilling').validate({
	rules: {
		bservice_name: {
			required: true
		},
		bservice_desc: {
			required: true
		},
		billing_rate: {
			required: true
		},
		billing_date: {
			required: true
		}
	},
	messages: {
		bservice_name: {
			required: "Please select service name"
		},
		bservice_desc: {
			required: "Please select service description"
		},
		billing_rate: {
			required: "billing rate required"
		},
		billing_date: {
			required: "Please select date"
		}
	},
	errorElement: 'span',
	submitHandler: function (form) {
		var form_data = document.getElementById('uploadBilling');
		var Form_data = new FormData(form_data);
		// var form_data = new FormData(document.getElementById("patientForm"));
		// $.LoadingOverlay("show");
		$.ajax({
			type: "POST",
			url: baseURL + "add_billing_transaction",
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {

					app.successToast(result.data);
					// $("#billingFormButton").click();
					document.getElementById('uploadBilling').reset();
					$('#forward_billing').val('');
					$('#billing_service_id').val('');
					// location.reload();
					getBillingTable(localStorage.getItem("patient_id"));
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
function getBillingTable1(p_id) {
		var formData = new FormData();
		formData.set("p_id", p_id);
	app.request(baseURL + "getBillingTable", formData).then(res => {
		table = $("#billingTable").DataTable({
			destroy: true,
			responsive:true,
			order: [],
			paging: false,
			autoWidth: false,
			data: res.data,
			columns:[
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
			data: 4
		},
		{
			data: 5
		},
		{
			data: 6,
			render: (d, t, r, m) => {
				if(parseInt(r[11])=== 1){
					let value = 1;
					return `<input type="checkbox" checked id="sampleBillingCollectionCheckbox_${d}" onclick="serviceOrderBillingInfo(${d},'${tableID}','${category}',${value})">`;
				}
				else
				{
					let value = 0;
					return `<input type="checkbox"  id="sampleBillingCollectionCheckbox_${d}" >`;
				// }return `<input type="checkbox"  id="sampleBillingCollectionCheckbox_${d}" onclick="serviceOrderBillingInfo(${d},'${tableID}','${category}',${value})">`;
				}
				
			}
		},
		{
			data: 7,
			render: (d, t, r, m) => {
				return `<button type="button" class="btn btn-link" onclick="deleteServiceOrder(${d},'${tableID}','${category}','${r[3]}')"><i class="fa fa-times"></i></button>`;
			}
		},
		{
			data: 8
		},
		{
			data: 9	
		}

	],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				if(parseInt(aData[11])===1)
			{
				let value = 1;
				let status = 'checked';
				$('td:eq(6)', nRow).html(`<input type="checkbox" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="serviceOrderBillingInfo(${aData[6]},'${tableID}','${category}',${value})">`);
			}
			else
			{
				let value = 0;
				let status='';
				$('td:eq(6)', nRow).html(`<input type="checkbox" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}">`);
				// $('td:eq(6)', nRow).html(`<input type="checkbox" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="serviceOrderBillingInfo(${aData[6]},'${tableID}','${category}',${value})">`);
				}
		

			$('td:eq(7)', nRow).html(`<button type="button" class="btn btn-link" onclick="deleteServiceOrder(${aData[7]},'${tableID}','${category}','${aData[3]}')"><i class="fa fa-times"></i></button>`);

				}

		});

		$('#example-select-all').on('click', function () {
			// var table=$('#billingTable').DataTable({});
			// var table = document.getElementById("billingTable");
			// Get all rows with search applied
			var rows = table.rows({'search': 'applied'}).nodes();
			// Check/uncheck checkboxes for all rows in the table

			$('input[type="checkbox"]', rows).prop('checked', this.checked);
			
		});
	})
	
	

}
function getDeleteBillingTable(p_id) {

	tableID='DeletebillingTable';
	category='general';
	app.dataTable('DeletebillingTable', {
		url: baseURL + "getDeleteBillingTable",
		data: {p_id: p_id},
		order: [],
		columnDefs: [
    	{orderable: false, targets: 'no-sort' }
 		 ]
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
			data: 4
		},
		{
			data: 5
		},
		{
			data: 6,
			render: (d, t, r, m) => {
				return `<button type="button" class="btn btn-link" onclick="restore_service('${r[6]}')"><i class="fa fa-check"></i></button>`;
			}
		},
		{
			data: 8
		},
		{
			data: 9	
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// let date = aData[2];
		// console.log(aData[11]);
		if(parseInt(aData[11])===1)
		{
			let value = 1;
			let status = 'checked';
			//$('td:eq(6)', nRow).html(`<input type="checkbox" ${status} data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}">`);
		}
		else
		{
			let value = 0;
			let status='';
			// $('td:eq(6)', nRow).html(`<input type="checkbox" data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="serviceOrderBillingInfo(${aData[6]},'${tableID}','${category}',${value})">`);
			//$('td:eq(6)', nRow).html(`<input type="checkbox" data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="getButton(${iDisplayIndex})">`);
			}
		
	
		$('td:eq(6)', nRow).html(`<button type="button" class="btn btn-link" onclick="restore_service(${aData[6]})"><i class="fa fa-check"></i></button>`);

	})
	
	

}
let table;

function getBillingTable(p_id) {

	tableID='billingTable';
	category='general';
	table=app.dataTable('billingTable', {
		url: baseURL + "getBillingTable",
		data: {p_id: p_id},
		order: [],
		columnDefs: [
    	{orderable: false, targets: 'no-sort' }
 		 ]
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
			data: 4
		},
		{
			data: 5
		},
		{
			data: 6,
			render: (d, t, r, m) => {
				
				if(parseInt(r[11])=== 1){
					let value = 1;
					return `<input type="checkbox" checked data-checkbox_id="0" id="sampleBillingCollectionCheckbox_${d}" onclick="serviceOrderBillingInfo(${d},'${tableID}','${category}',${value})">`;
				}
				else
				{
					let value = 0;
					// return `<input type="checkbox" class="checkboxBilling"  id="sampleBillingCollectionCheckbox_${d}" >`;
					return `<input type="checkbox" data-checkbox_id="${d}" class="billingCheckbox checkboxBilling_${m.row}"  id="sampleBillingCollectionCheckbox_${d}" >`;
				}
				
			}
		},
		{
			data: 7,
			render: (d, t, r, m) => {
				return `<button type="button" class="btn btn-link" onclick="deleteServiceOrder(${d},'${tableID}','${category}','${r[3]}')"><i class="fa fa-times"></i></button>`;
			}
		},
		{
			data: 8
		},
		{
			data: 9	
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		// let date = aData[2];
		// console.log(aData[11]);
		if(parseInt(aData[11])===1)
		{
			let value = 1;
			let status = 'checked';
			$('td:eq(6)', nRow).html(`<input type="checkbox" ${status} data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}">`);
		}
		else
		{
			let value = 0;
			let status='';
			// $('td:eq(6)', nRow).html(`<input type="checkbox" data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="serviceOrderBillingInfo(${aData[6]},'${tableID}','${category}',${value})">`);
			$('td:eq(6)', nRow).html(`<input type="checkbox" data-checkbox_id="${aData[6]}" class="billingCheckbox checkboxBilling_${iDisplayIndex}" ${status} id="sampleBillingCollectionCheckbox_${aData[6]}" onclick="getButton(${iDisplayIndex})">`);
			}
		
	
		$('td:eq(7)', nRow).html(`<button type="button" class="btn btn-link" onclick="deleteServiceOrder(${aData[7]},'${tableID}','${category}','${aData[3]}')"><i class="fa fa-times"></i></button>`);

	})
	
	

}
$('.billingCheckbox').on('click', function () {
	// console.log('supi');
	if($(".billingCheckbox").prop("checked") == true)
	{
		$("#billingCheckSubmit").removeClass('d-none');
	}
	else
	{
		$("#billingCheckSubmit").addClass('d-none');
	}
	
	});
// $('.billingCheckbox:checkbox.class').each(function () {
//        var sThisVal = (this.checked ? $(this).val() : "");
//        console.log(sThisVal);
//   });

function getButton(index) {
	// 
	let checkbtn=[];
	$(".billingCheckbox:checked").each(function() {
        checkbtn.push(1);
        
    });
    if(checkbtn.length>0)
    {
    	$("#billingCheckSubmit").removeClass('d-none');
    }
    else
    {
    	$("#billingCheckSubmit").addClass('d-none');
    }
	
}

$('#example-select-all').on('click', function () {
		
			var checkboxes = $('input[type="checkbox"]').length;
	
			$('input[type="checkbox"]').prop('checked', this.checked);
			
	
		});

function submitCheckBilling()
{
	var checkboxes = $('input[type="checkbox"]').length;
	if(checkboxes>1){
			
			
			// console.log(checkboxes);
			// $('input[type="checkbox"]').prop('checked', this.checked);
			var billingCheckArray=[];
			for(var i=0;i<checkboxes;i++)
			{
				// var checkBox = document.getElementsByClassName("checkboxBilling_"+i);
				var checkBox=$(".checkboxBilling_"+i);
				// console.log(checkBox);
				if ($(".checkboxBilling_"+i).prop("checked") == true){
					

					// $('.checkboxBilling_'+i).data('checkbox_id',1); //setter
					// $(".checkboxBilling_"+i).click();
					var getCheck=$('.checkboxBilling_'+i).data('checkbox_id');
					billingCheckArray.push(getCheck);
				}

				// if(checkboxes!=1 && i==(checkboxes-1))
				// {
				// 	app.successToast("service confirm");
				// }
				
			}
			serviceOrderBillingInfo(billingCheckArray);
			// getBillingTable(localStorage.getItem("patient_id"));
			// $('#example-select-all').prop('checked', false);
		
	}
	else
	{
		app.errorToast('No Service Found');
		$('#example-select-all').prop('checked', false);
		$("#billingCheckSubmit").addClass('d-none');
	}

}
function serviceOrderBillingInfo(billingarray)
{
	// console.log(billingarray);

	if(billingarray.length>0)
	{
		let confirmAction = confirm("Are you sure to you want confirm service");
       	if (confirmAction) {
		var confirm_service_given=1;
		// var formData = new FormData();
		// formData.append("service_order_id", billingarray);
		// formData.append("confirm_service_given", confirm_service_given);

		// console.log(formData);

		serverRequest("getBillingserviceOrderBillingInfo", {service_order_id:billingarray,confirm_service_given:confirm_service_given}).then(response => {
				// $.LoadingOverlay("hide");
				//console.log(response);
				if (response.status == 200) {
					// console.log(response);
					
						getBillingTable(localStorage.getItem("patient_id"));
						$('#example-select-all').prop('checked', false);
						$("#billingCheckSubmit").addClass('d-none');
						app.successToast(response.body);
					
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
		}
		else
		{

			$('input[type="checkbox"]').prop('checked', false);
			$("#billingCheckSubmit").addClass('d-none');
		}
	}
	else
	{
		app.errorToast("Please select service");
	}
	
}
		
function serviceOrderBillingInfo1(service_order_id,tablename,category,value)
{
	// if ($("#sampleBillingCollectionCheckbox_" + service_order_id).prop('checked') == true) {
		var confirm_service_given=1;
	// }
	// else
	// {
	// 	var confirm_service_given=0;
	// }
	var a = $('#sampleBillingCollectionCheckbox_'+ service_order_id).data('checkbox_id'); //getter
	if(a==0){
		let confirmAction = confirm("Are you sure to you want confirm service");
       if (confirmAction) {
			serverRequest("getBillingserviceOrderBillingInfo", {service_order_id: service_order_id,confirm_service_given:confirm_service_given}).then(response => {
				// $.LoadingOverlay("hide");
				//console.log(response);
				if (response.status == 200) {
					// console.log(response);
					
					if ($("#sampleBillingCollectionCheckbox_" + service_order_id).prop('checked') == true) {
						getBillingTable(localStorage.getItem("patient_id"));
						app.successToast(response.body);
					}
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
	}
	}else{
		serverRequest("getBillingserviceOrderBillingInfo", {service_order_id: service_order_id,confirm_service_given:confirm_service_given}).then(response => {
				// $.LoadingOverlay("hide");
				//console.log(response);
				if (response.status == 200) {
					// console.log(response);
					
					if ($("#sampleBillingCollectionCheckbox_" + service_order_id).prop('checked') == true) {
						getBillingTable(localStorage.getItem("patient_id"));
						app.successToast(response.body);
					}
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
	}
	// let confirmAction = confirm("Are you sure to you want confirm service");
 //       if (confirmAction) {
			
	// }
}
function deleteServiceOrder(service_order_id,tablename,category,service_id)
{
	let confirmAction = confirm("Are you sure to you want delete service");
       if (confirmAction) {
       	 var patient_id=localStorage.getItem("patient_id");
			serverRequest("deleteBillingServiceOrder", {service_order_id: service_order_id,patient_id:patient_id,service_id:service_id}).then(response => {
				// $.LoadingOverlay("hide");
				//console.log(response);

				var user_data = response.option;
				if (response.status == 200) {
					app.successToast(response.body);
					getBillingTable(localStorage.getItem("patient_id"));
					getDeleteBillingTable(localStorage.getItem("patient_id"));


				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
	}
}

function restore_service(id){
	serverRequest("restoreService", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getBillingTable(localStorage.getItem("patient_id"));
			getDeleteBillingTable(localStorage.getItem("patient_id"));
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function deleteBillingTrascation(id) {
	// $.LoadingOverlay("show");
	serverRequest("deleteBillingTrascation", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			getBillingTable(localStorage.getItem("patient_id"));
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function printDiv() {
	let divName=".main-content.main-content1";
	$('#printButton').toggleClass('d-none');
	$('.deletebtnBill').toggleClass('d-none');
	$('.discountth').toggleClass('d-none');
	var printContents = document.querySelector(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
	$('#printButton').toggleClass('d-none');
}

// function save_discount(id,total,item){
// 	var discount=$("#dis_"+id).val();
// 	serverRequest("saveDiscount", {id,total,discount}.then(response => {
// 		// $.LoadingOverlay("hide");
// 		if (response.status === 200) {
// 			app.successToast(response.body);
// 			if(item == 1){
// 				getAccomodationTableBIllingData();
// 			}
// 			if(item == 2){
// 				getserviceOrderCollectionTableBilling();
// 			}
// 			if(item == 3){
// 				getmedicineAndConsumablesTableBilling();
// 			}
// 				getGrandTotal();
// 		} else {
// 			app.errorToast(response.body);
// 		}
// 	}).catch(error => console.log(error));
// }

function save_discount(id,total,type,item){
	var discount=$("#dis_"+id).val();
	var type = $("input[type='radio'][name='discount"+id+"']:checked").val();
	serverRequest("saveDiscount", {id,total,discount,type}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			if(item == 1){
				getAccomodationTableBIllingData();
			}
			if(item == 2){
				getserviceOrderCollectionTableBilling();
			}
			if(item == 3){
				getmedicineAndConsumablesTableBilling();
			}
			getGrandTotal();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

function delete_service_bill(id,item){
	serverRequest("deleteBillingTrascationAcc", {id: id}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			if(item == 1){
				getAccomodationTableBIllingData();
			}
			if(item == 2){
				getserviceOrderCollectionTableBilling();
			}
			if(item == 3){
				getmedicineAndConsumablesTableBilling();
			}
			getGrandTotal();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}
