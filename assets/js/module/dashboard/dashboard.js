$(document).ready(function () {
	 get_monthly_Data();
    // get_yearly_Data();
	getAllMonths();
	getDeathTranferBillingReport();
	 $("#monthly_chk").click();
	 // $("#monthly_chk").prop('checked',true);
	  $("#date_wise_chk").prop('checked',false);
	  checkUrlData();
	
});

function getValidDate()
{
	 // $("#end_date").rules('add', { greaterThan: "#start_date" });
	 var from = $("#start_date").val();
		var to = $("#end_date").val();

		if(Date.parse(from) >= Date.parse(to)){
		   app.errorToast("Invalid Date Range check end date");
		   $("#end_date").val('');
		}
		
}
function checkUrlData()
{
	 var params = {};
    var param_array1 = window.location.href.split('?')[1];
    // console.log(param_array1);
   if(param_array1!="" && param_array1!=undefined){

    var param_array=param_array1.split('&');
    // 
    
    	for(var i in param_array){
        x = param_array[i].split('=');
        params[x[0]] = x[1];
        // console.log(params[x[0]]);
        if(params[x[0]]==201)
        {
        	app.errorToast("Data Not found for download");
        	window.location.href=baseURL+"Dashboard";
        }
    }
    }
    
}
function getDateOptions()
{
	if($("#date_wise_chk").prop('checked') == true){
		    $("#datewiseDiv").removeClass('d-none');
		    $("#monthly_chk").prop('checked',false);
		    getMonthOptions();

		}
		else
		{
			 $("#datewiseDiv").addClass('d-none');
		}
		checkbutton();
			
}

function getMonthOptions()
{
	if($("#monthly_chk").prop('checked') == true){
		    $("#monthlyDiv").removeClass('d-none');
		    $("#date_wise_chk").prop('checked',false);
		    getDateOptions();
		    
		}
		else
		{
			 $("#monthlyDiv").addClass('d-none');
		}
		checkbutton();
}

function checkbutton()
{
	if($("#monthly_chk").prop('checked') == true || $("#date_wise_chk").prop('checked') == true){
	 	$("#DashboardBillingReportBtn").removeClass('d-none');
	}
	else
	{
		$("#DashboardBillingReportBtn").addClass('d-none');
	}
}

function getAllMonths()
{
	$("#month_select").empty();
	 const monthNames = ["January", "February", "March", "April", "May", "June",
	    "July", "August", "September", "October", "November", "December"
	  ];
	  const targetNode = document.getElementById('month_select');

		const srcArray = [{id: 1, name: 'January'}, {id: 2, name: 'February'}, {id: 3, name: 'March'}, {id: 4, name: 'April'},
			{id: 5, name: 'May'}, {id: 6, name: 'June'}, {id: 7, name: 'July'}, {id: 8, name: 'August'},
			{id: 9, name: 'September'}, {id: 10, name: 'October'}, {id: 11, name: 'November'}, {id: 12, name: 'December'}];

		targetNode.innerHTML = srcArray.reduce((options, {id,name}) => 
		  options+=`<option value="${id}">${name}</option>`, 
		  '<option selected disabled>Select Month</option>');
}

function getDashboardBillingReport1()
{
	var form_data = document.getElementById('downloadBillingDashboard');
	var Form_data = new FormData(form_data);
	$.ajax({
			type: "POST",
			url: baseURL + "getDashboardBillingReport",
			dataType: "json",
			data: Form_data,
			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {
					// Create Base64 Object
					// console.log(result.data);
					// console.log(result.data);
					if(result.data!="")
					{
						var newData = result.data;
						
						// const x = JSON.stringify(newData);
						// const x=JSON.parse(JSON.stringify(newData));
						// var x = ;
						var formData = new FormData();
						formData.set("data", JSON.stringify(newData))
						// console.log(formData);
						window.location.href= baseURL+"getDownloadDashboardBilling?data=" + formData;
					}
					else
					{
						app.successToast(result.body);
					}
					
					
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
function getDashboardBillingReport2()
{
	// var form_data = document.getElementById('downloadBillingDashboard');
	// var formData = new FormData(form_data);
	  var formData=$('#downloadBillingDashboard').serialize();
			const x=JSON.stringify(formData);
			// var x=JSON.parse(formData);
			// console.log(x);
			// window.location.href= baseURL+"getDashboardBillingReport/"+x;
			window.location.href= baseURL+"getDashboardBillingReport?data=" + x;


}
function getDashboardBillingReport()
{
	// var form_data = document.getElementById('downloadBillingDashboard');
	// var formData = new FormData(form_data);
	  // var formData=$('#downloadBillingDashboard').serialize();
	    var loginForm = $('#downloadBillingDashboard').serializeArray();
			var loginFormObject = {};
			$.each(loginForm,
			    function(i, v) {
			        loginFormObject[v.name] = v.value;
			    });
			const x=JSON.stringify(loginFormObject);
	 if($("#date_wise_chk").prop('checked') == true)
	 {
	 	// var start_date=("#start_date").val();
	 	// var end_date=("#end_date").val();
	 	if($("#start_date").val()!=null && $("#start_date").val()!="" && $("#end_date").val()!=null && $("#end_date").val()!="")
	 	{
	 		window.location.href= baseURL+"getDashboardBillingReport?data=" + x;
	 	}
	 	else
	 	{
	 		app.errorToast("Please Select Start date and end date");
	 	}
	 }
	 else if($("#monthly_chk").prop('checked') == true)
	 {
	 	if($("#year_select").val()!="" && $("#year_select").val()!=null && $("#month_select").val()!="" && $("#month_select").val()!=null)
	 	{
	 		window.location.href= baseURL+"getDashboardBillingReport?data=" + x;
	 	}
	 	else
	 	{
	 		app.errorToast("Please Select Year and Month");
	 	}
	 }
	 else
	 {
	 	app.errorToast("Please Select Date Wise Or Monthly");
	 }
	
	  // var object = {};
			// 	formData.forEach(function(value, key){
			// 	    object[key] = value;
			// 	});
			
			// var x=JSON.parse(formData);
			// console.log(x);
			// window.location.href= baseURL+"getDashboardBillingReport/"+x;
			


}

function get_monthly_Data(){
	app.request(baseURL +"get_dashboard_Data", null).then(response => {
	$("#data_div_monthly").html(response.data);
	$('#vaccination_data').html(response.vaccine_data);
	}).catch(error => {
		console.log(error);
	})
}
function get_yearly_Data(){
	app.request(baseURL +"get_yearly_Data", null).then(response => {
	$("#data_div_yearly").html(response.data);
	}).catch(error => {
		console.log(error);
	})
}

function getDeathTranferBillingReport()
{
	let status = $("#d_t_selectOption").val();
	let event = $("#d_t_selectEvent").val();
	let formData = new FormData();
	formData.set("status", status);
	formData.set("event", event);
	app.request(baseURL + "getDeathTranferBillingReport", formData).then(res => {
	$("#d_t_totalCount").val(res.total_count);
	$('#d_t_billingTable').DataTable({
		destroy: true,
			responsive: true,
			autoWidth: false,
			"pagingType": "simple_numbers",
			data: res.data,
		columns: [
			{
				data: 0
			},
			{
				data: 1,
			},
			{
				data: 2
			},
			{
				data: 3
			}
			],
			fnRowCallback: (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			}
	});
	});
}

function getDeathTranferBillingExcelReport()
{
	var t_count=$("#d_t_totalCount").val();
	if(t_count<=0)
	{
		app.errorToast('No Records Found');
	}
	else
	{
		let status = $("#d_t_selectOption").val();
		let event = $("#d_t_selectEvent").val();
		var loginFormObject = {};
		loginFormObject["status"]=status;
		loginFormObject["event"]=event;
		const x=JSON.stringify(loginFormObject);
		window.location.href= baseURL+"getDeathTranferBillingExcelReport?data=" + x;
	}
}
