

function get_order_patients(url) {
	$("#patient-order-list").html("");
var date=$("#from_date").val();
let formData = new FormData();
	formData.set("date", date);
	formData.set("discharge", "0");
	app.request(baseURL +url, formData).then(response => {
		$('#patient-order-list').select2({allowClear: true,data: response.body});
		$("#patient-order-list").select2("val", "");
	}).catch(error => {
		console.log(error);
	})
}


function get_order_patients_discharge(url) {

	$("#patient-order-list").html("");
var date=$("#from_date").val();
let formData = new FormData();
	formData.set("date", date);
	formData.set("discharge", "1");
	app.request(baseURL +url, formData).then(response => {
		$('#patient-order-list').select2({allowClear: true,data: response.body});
		$("#patient-order-list").select2("val", "");
	}).catch(error => {
		console.log(error);
	})
}
//backorder 

function get_backorder_patients(url) {
	$("#patient-backorder-list").html("");
var date=$("#backfrom_date").val();
let formData = new FormData();
	formData.set("date", date);
	app.request(baseURL +url, formData).then(response => {
		$('#patient-backorder-list').select2({allowClear: true,data: response.body});
		$("#patient-backorder-list").select2("val", "");
	}).catch(error => {
		console.log(error);
	})
}
//patient_history
 function get_order_patients_history(url_history){
	app.request(baseURL +url_history, null).then(response => {
		$('#patient_history').select2({allowClear: true,data: response.body});
		$("#patient_history").select2("val", "");
	}).catch(error => {
		console.log(error);
	})
}
function get_order_return_patients(url)
{
	app.request(baseURL +url, null).then(response => {
		$('#patient-order-return-list').select2({allowClear: true,data: response.body});
		$("#patient-order-return-list").select2("val", "");
	}).catch(error => {
		console.log(error);
	})
}



function load_patient_order(patient_id) {
	medicineRate=[];
	materialRate=[];

	$("#invoice_amount").val("");
	$("#invoice_number").val("");
var date=$("#from_date").val();
	let formData = new FormData();
	formData.set("patient_id", patient_id);
	formData.set("date", date);
	// console.log(patient_id);
	app.request(baseURL +tableURL , formData).then(response => {
		$("#orderTable").empty();
		$("#orderConsumableTable").empty();
		if(response.status==200)
		{
			if(response.body=="" || response.body==null)
				{
					$("#medicineOrder-tab").addClass('d-none');
					$("#medicineOrderPanel").removeClass('show active');
				}
				else
				{
					$("#medicineOrder-tab").removeClass('d-none');
					$("#medicineOrder-tab").click();
					$("#medicineOrderPanel").addClass('show active');

					$("#orderTable").append(response.body);
					$('#orderPatient').val(patient_id);
					$(function () {
						$('[data-toggle="popover"]').popover()
					})
					
				}
				

				if(response.cons_body=="" || response.cons_body==null)
				{
					
					$("#cosumableOrder-tab").addClass('d-none');
					$("#ConsumableOrderPanel").removeClass('show active');
				}
				else
				{
					
					$("#cosumableOrder-tab").removeClass('d-none');
					if(response.body=="" || response.body==null){
						$("#cosumableOrder-tab").click();
						// $("#ConsumableOrderPanel").addClass('show active');
					}
					console.log(response.cons_body);

					$("#orderConsumableTable").append(response.cons_body);
					$('#orderConsumablePatient').val(patient_id);
				}
				if(tableURL==="get-patient-approved-order"){
					$('#invoice_number').val(response.invoice_number);
					$('#invoice_amount').val(response.invoice_amount);
					$('#orderPatient').val(response.patient_id);
					$("#order_id").val(response.order_number);
					$("#orderNumber").empty();
					$("#orderNumber").append(`OrderId : ${response.order_number}`);


					// receive consumable
					$('#cons_invoice_number').val(response.cons_invoice_number);
					$('#cons_invoice_amount').val(response.cons_invoice_amount);
					$('#orderConsumablePatient').val(response.cons_patient_id);
					$("#order_cons_id").val(response.cons_order_number);
					$("#orderConsNumber").empty();
					$("#orderConsNumber").append(`OrderId : ${response.cons_order_number}`);

				}
		}
		else
		{
			$("#medicineOrder-tab").addClass('d-none');
			$("#medicineOrderPanel").removeClass('show active');

			$("#cosumableOrder-tab").addClass('d-none');
			$("#ConsumableOrderPanel").removeClass('show active');
		}
		
		
		
	}).catch(error => {
		console.log(error);
	})
}

function load_departmentOrder(dept_id){
	let formData = new FormData();
	formData.set("dept_id", dept_id);
	app.request(baseURL +"GetHospitalOrderMedicine" , formData).then(response => {
		if(response.status==200){
			$("#h_table_order").show();
			$("#HorderTable").html("");
			$("#HorderTable").html(response.data);
		}else{
			
		}
	});
}
function load_hospreturnOrder(zone_id){
	let formData = new FormData();
	formData.set("zone_id", zone_id);
	app.request(baseURL +"GetHospitalReturnMedicine" , formData).then(response => {
		if(response.status==200){
			//$("#h_table_order").show();
			$("#RorderTable").html("");
			$("#RorderTable").html(response.body);
		}else{
			
		}
	});
}

function load_patient_order_rerurn(patient_id) {

	let formData = new FormData();
	formData.set("patient_id", patient_id);
	// console.log(patient_id);
	app.request(baseURL +r_tableURL , formData).then(response => {
		$("#orderReturnTable").empty();
		$("#orderReturnTable").append(response.body);
		$('#orderReturnPatient').val(patient_id);
		if(r_tableURL==="get-patient-approved-order-return"){
			$('#invoice_return_number').val(response.invoice_return_number);
			$('#invoice_return_amount').val(response.invoice_return_amount);
			// console.log(response.patient_id);
			$('#orderReturnPatient').val(response.patient_id);
			$("#orderReturnNumber").empty();
			$("#orderReturnNumber").append(`OrderId : ${response.order_number}`);
		}
	}).catch(error => {
		console.log(error);
	})
}
function deleteMedicine(id,patient_id) {
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL +"delete-order" , formData).then(response => {
		load_patient_order(patient_id);
	}).catch(error => {
		console.log(error);
	})
}
function savePharmeasyOrder(form) {

	app.request(baseURL+"save-pharmary-order",new FormData(form)).then(response=>{
		medicineRate=[];
		materialRate=[];
		if(response.status === 200){
			app.successToast(response.body);
			$("#orderNumber").empty();
			
			
			if(response.mode === false){
				$('#orderNumber').append(response.order_id);
				
				$("#openOrderModel").click();
				$("#patient-order-list").empty();
				$("#invoice_number").val('');
				$("#invoice_amount").val('');
				get_order_patients(url);
				$("#orderTable").empty();
				//load_patient_order(response.patient_id);
					$("#medicineOrder-tab").addClass('d-none');
			$("#medicineOrderPanel").removeClass('show active');

			$("#cosumableOrder-tab").addClass('d-none');
			$("#ConsumableOrderPanel").removeClass('show active');
			}else{
				$('#orderNumber').append(response.order_id);
				get_order_patients(url);
				$("#patient-order-list").empty();
				$("#invoice_number").val('');
				$("#invoice_amount").val('');
				$("#orderTable").empty();
				//load_patient_order(response.patient_id);
					$("#medicineOrder-tab").addClass('d-none');
			$("#medicineOrderPanel").removeClass('show active');

			$("#cosumableOrder-tab").addClass('d-none');
			$("#ConsumableOrderPanel").removeClass('show active');

				// setInterval(()=>{
				// 	location.reload();
				// },1000);

			}

		}else{
			app.errorToast(response.body);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function saveHospPharmeasyOrder(form) {

	app.request(baseURL+"save-Hospharmary-order",new FormData(form)).then(response=>{
		$("#orderNumber").html("");
		if(response.status === 200){
			app.successToast(response.body);
			var order_id=response.order_id;
			$("#h_table_order").hide();
			
			getDeparment();
			$("#openOrderModel").click();
			$("#orderNumber").html(order_id);
			$("#h_invoice_number").val('');
			$("#h_invoice_amount").val('');

		}else{
			app.errorToast(response.body);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function getDeparment() {

	app.request(baseURL+"getDeptOrder").then(response=>{
		
		if(response.status === 200){
			$("#department_name").html(response.data);
		}else{
			$("#department_name").html(response.data);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function getZone() {

	app.request(baseURL+"getDeptReturnOrder").then(response=>{
		
		if(response.status === 200){
			$("#zone_name").html(response.data);
		}else{
			$("#zone_name").html(response.data);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function saveConsumablePharmeasyOrder(form)
{
	app.request(baseURL+"save-consumable-pharmary-order",new FormData(form)).then(response=>{
		if(response.status === 200){
			app.successToast(response.body);
			$("#orderNumber").empty();
			$("#orderConsNumber").empty();
			if(response.mode === false){
				$('#orderNumber').append(response.order_id);
				$('#orderConsNumber').append(response.order_id);
				$("#openOrderModel").click();
				$("#patient-order-list").empty();
				$("#cons_invoice_number").val('');
				$("#cons_invoice_amount").val('');
				get_order_patients(url);
				$("#medicineOrder-tab").addClass('d-none');
			$("#medicineOrderPanel").removeClass('show active');

			$("#cosumableOrder-tab").addClass('d-none');
			$("#ConsumableOrderPanel").removeClass('show active');
				$("#orderConsumableTable").empty();
				//load_patient_order(response.patient_id);
			}else{
				
				$('#orderNumber').append(response.order_id);
				$('#orderConsNumber').append(response.order_id);
				$("#patient-order-list").empty();
				$("#cons_invoice_number").val('');
				$("#cons_invoice_amount").val('');
				get_order_patients(url);
				$("#medicineOrder-tab").addClass('d-none');
			$("#medicineOrderPanel").removeClass('show active');

			$("#cosumableOrder-tab").addClass('d-none');
			$("#ConsumableOrderPanel").removeClass('show active');
				//load_patient_order(response.patient_id);
				$("#orderConsumableTable").empty();
				// setInterval(()=>{
				// 	location.reload();
				// },1000);

			}

		}else{
			app.errorToast(response.body);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function savePharmeasyReturnOrder(form) {

	app.request(baseURL+"save-pharmary-return-order",new FormData(form)).then(response=>{
		if(response.status === 200){
			app.successToast(response.body);
			// console.log(response);
			$("#patient-order-return-list").empty();
			$("#invoice_return_number").val('');
			$("#invoice_return_amount").val('');
			get_order_return_patients(r_url);
			// setInterval(()=>{
			// 	location.reload();
			// },1000);
			$("#orderReturnTable").empty();

			// if(response.mode === true){
			//
			// 	$('#orderNumber').append(response.order_id);
			// }
			// $("#openOrderReturnModel").click();
		}else{
			app.errorToast(response.body);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function saveHPharmeasyReturnOrder(form) {

	app.request(baseURL+"SaveHospitalReturnOrder",new FormData(form)).then(response=>{
		if(response.status === 200){
			app.successToast(response.body);
			// console.log(response);
			
			$("#h_invoice_return_number").val('');
			// setInterval(()=>{
			// 	location.reload();
			// },1000);
			$("#RorderTable").empty();
			getZone();
			$("#openOrderModel").click();
			$("#orderNumber").html(response.order_id);
		}else{
			app.errorToast(response.body);
		}
	}).catch(error=>{
		console.log(error);
	})
}
function clearWindow() {
	$("#openOrderModel").click();
	// location.reload();
}

function load_patient_order_history(p_id){
	get_order_patients_history(url_history);
	app.dataTable('HistoryOrderTable', {
		url: baseURL + "getHistoryorderTable",
		data: {p_id: p_id}
	}, [
		{
			data: 5
		},{
			data: 2
		},
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
			
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button"  data-toggle="modal" data-target="#View_order_history" data-backdrop="false" onclick="getOrderHistoryData('${r[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`;
				
			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(6)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button"  data-toggle="modal" data-target="#View_order_history" data-backdrop="false" onclick="getOrderHistoryData('${aData[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`);
		
	});

	getConsumableHistory(p_id);
}
function getConsumableHistory(p_id)
{
	app.dataTable('ConsumableHistoryOrderTable', {
		url: baseURL + "getConsumableHistoryorderTable",
		data: {p_id: p_id}
	}, [
		{
			data: 5
		},{
			data: 2
		},
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
			
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button" data-toggle="modal" data-target="#View_order_history" data-backdrop="false"  onclick="getOrderConsumableHistoryData('${r[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`;
				
			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(6)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button"  data-toggle="modal" data-target="#View_order_history" data-backdrop="false"  onclick="getOrderConsumableHistoryData('${aData[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`);
		
	});
}

function getOrderHistoryData(order_id){
	// $("#View_order_history").modal('show');
	 // $('.modal-backdrop').hide();
	$("#order_history_item").empty();
	//order_history_item
	
	let formData = new FormData();
	formData.set("order_id", order_id);
	app.request(baseURL +"getItemMedicineHistory" , formData).then(response => {
		$("#modalTitle").html('Medicine History');
		$("#order_history_item").empty();
		$("#order_history_item").html(response.data);
		$("#historyItemTable").dataTable();
		
	}).catch(error => {
		console.log(error);
	})
	
}

function getOrderConsumableHistoryData(order_id){
	// $("#View_order_history").modal('show');
	$("#order_history_item").empty();
	//order_history_item
	
	let formData = new FormData();
	formData.set("order_id", order_id);
	app.request(baseURL +"getItemConsumableHistory" , formData).then(response => {
		$("#modalTitle").html('Consumable History');
		$("#order_history_item").empty();
		$("#order_history_item").html(response.data);
		$("#ConsumablehistoryItemTable").dataTable();
		
	}).catch(error => {
		console.log(error);
	})
	
}

function load_patient_backorder(patient_id=null)
{
	var date=$("#backfrom_date").val();
	let formData = new FormData();
	formData.set("patient_id", patient_id);
	formData.set("date", date);
	// console.log(patient_id);
	app.dataTable('BackOrderTable', {
		url: baseURL + "getBackOrderTable",
		data: {patient_id,date}
	}, [
		{
		data: 0
		},{
			data: 1
		},
		{
			data: 2
		},
		{
			data: 3
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			// $('td:eq(6)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="getOrderHistoryData('${aData[0]}')"
	  //                                 >
	  //                                <i class="fas fa-eye"></i>
	  //                           </button>`);
		
	})
}

function load_hospital_order_history(dept_id=null){
	
	app.dataTable('HistoryHospOrderTable', {
		url: baseURL + "getHospHistoryorderTable",
		data: {dept_id: dept_id}
	}, [
		{
		  
	 
		  
	
   
			data: 0
		},{
			data: 1
		},
		{
			data: 5
		},
		{
			data: 2
		},
		{
			data: 3
		},
		
		
		{
			
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button"  data-toggle="modal" data-target="#View_hosporder_history" data-backdrop="false" onclick="getHospitalOrderHistoryData('${r[4]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`;
				
			}
		}

	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(5)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" data-toggle="modal" data-target="#View_hosporder_history" data-backdrop="false" onclick="getHospitalOrderHistoryData('${aData[4]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`);
		
	});

	
}

function getHospitalOrderHistoryData(id){
	// $("#View_order_history").modal('show');
	$("#Hosporder_history_item").empty();
	//order_history_item
	
	let formData = new FormData();
	formData.set("order_id", id);
	app.request(baseURL +"getItemHospitalHistory" , formData).then(response => {
		
		$("#Hosporder_history_item").empty();
		$("#Hosporder_history_item").html(response.data);
		$("#HospitalhistoryItemTable").dataTable();
		
	}).catch(error => {
		console.log(error);
	})
	
}

