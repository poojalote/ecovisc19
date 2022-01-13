<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
 
<style>

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}
.dropdown-menu {
    width: 300px !important;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
	
}
.dropdown-item:hover,a:hover{
	background-color:#891635;
	color:white;
}
a:hover{
	color:white;

}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}
	.table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
		padding: 0 15px;
		height: 40px;
		vertical-align: middle;
		font-size: 13px;
	}

	.card_label {
		font-size: 11px;
		text-align: center;
		/* letter-spacing: .5px; */
		/* margin-top: 4px; */
		/*text-overflow: ellipsis;*/
		/* overflow: hidden; */
		/*white-space: nowrap;*/
	}

	.card-stats-item {
		/*width:30%!important;*/
		/*padding: 0px!important;*/
		/*padding: 5px 5px!important;*/
		/*border: 1px solid #e9ecef!important;*/
		/*margin: 3px!important;*/
	}

	.card {
		box-shadow: 0 4px 6px 6px rgb(0 0 0 / 3%);
	}

	.border_class {
		border: 1px solid #d3d3d35e !important;
		padding: 10px !important;
	}

	/*.bg-primary {
	   background-color: #6777ef !important;
   }*/
   .navbar .nav-link
   {
	   color:black;
   }
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header card-primary">
		
		
		<div id="DropDownDiv"></div>
			<button class="btn btn-link" type="button" style="margin-left: auto;color:#891635;font-weight:900" id="dis_btn1"
			onclick="go_toDashboard()">Go to Dashboard
					</button>
		</div>
		<div class="section-body">
		
			<div class="">
				<div class="col-12 col-md-12">

					<div class="">
						<div class="" id="mainDashboard" >
							<div class="row">
								<div class="col-12 col-md-12 col-lg-12">
									<div class="card">
										<div class="card-header">
											<h4>Bed Availibility</h4>
										</div>
										<div class="card-body">
											<div style="display: block; width: 100%!important; height: 200px!important;">
												<canvas id="BedAvailabilityChart" class="chartjs-render-monitor"
														height="147" width="294"
														style="display: block; width: 294px!important; height: 147px!important;"></canvas>
											</div>
										</div>
									</div>
								</div>


								<div class="col-12 col-md-6 col-lg-6" style="display: none">
									<div class="card">
										<div class="card-header">
											<h4>Download Billing Report</h4>
										</div>
										<div class="card-body">
											<div style="display: block; width: 100%!important; height: 196px!important;">
												<form id="downloadBillingDashboard">
													<div class="mt-1 ml-2 p-2">

														<input type="checkbox" name="date_wise_chk" id="date_wise_chk"
															   onclick="getDateOptions()">
														<label class="mr-3">Date Wise</label>
														<input type="checkbox" name="monthly_chk" id="monthly_chk"
															   onclick="getMonthOptions()">
														<label>Monthly</label>
													</div>
													<div class="ml-3">
														<div class="form-row d-none" id="datewiseDiv">
															<div class="form-group col-md-6">
																<label>Start date</label>
																<input type="date" name="start_date" id="start_date"
																	   class="form-control" onchange="getValidDate()">
															</div>
															<div class="form-group col-md-6">
																<label>End date</label>
																<input type="date" name="end_date" id="end_date"
																	   class="form-control" onchange="getValidDate()">
															</div>
														</div>
														<div class="form-row d-none" id="monthlyDiv">
															<div class="form-group col-md-6">
																<label>Year</label>
																<select name="year_select" id="year_select"
																		class="form-control">
																	<option selected disabled>Select Year</option>
																	<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
																</select>
															</div>
															<div class="form-group col-md-6">
																<label>Month</label>
																<select name="month_select" id="month_select"
																		class="form-control">
																</select>
															</div>
														</div>
														<div class="form-row">
															<button class="btn btn-primary d-none" type="button"
																	id="DashboardBillingReportBtn"
																	onclick="getDashboardBillingReport()"><i
																		class="fa fa-download"></i> Download Excel
															</button>
														</div>

													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" id="data_div_monthly">
<!--								<div class="col-lg-6 col-md-6 col-sm-12" id="data_div_monthly">-->
<!---->
<!--								</div>-->
<!--								<div class="col-lg-6 col-md-6 col-sm-12" id="data_div_yearly">-->
<!---->
<!--								</div>-->
							</div>
							<div class="row" style="display: none">
								<div class="col-12 col-md-6 col-lg-6">
									<div class="card">
										<div class="card-header">
											<h4>Deaths and Transfers Billing Report</h4>
										</div>
										<div class="card-body">
											<div class="col-md-12 d-flex mb-2">
												<select class="col-sm-4 form-control" id="d_t_selectEvent" name="d_t_selectEvent" style="border-radius: 20px;" onchange="getDeathTranferBillingReport()">
													<option value="1">All</option>
													<option value="2">Mortality/Death</option>
													<option value="3">Transfer</option>
												</select>
												<select class="col-sm-4 form-control" id="d_t_selectOption" name="d_t_selectOption" style="border-radius: 20px;" onchange="getDeathTranferBillingReport()">
													<option value="1">All Bills</option>
													<option value="2">Open Bills</option>
													<option value="3">Closed Bills</option>
												</select>

												<button class="ml-2 btn btn-primary" type="button" id="d_t_reportBtn" onclick="getDeathTranferBillingExcelReport()"><i class="fa fa-download"></i> Download Report</button>
												<input type="hidden" name="d_t_totalCount" id="d_t_totalCount" value="0">
											</div>

											<table class="table" id="d_t_billingTable">
												<thead style="background-color: #8916353b;">
													<tr>
														<th>patient name</th>
														<th>Status</th>
														<th>Bill Amount</th>
														<th>Bill Status</th>
													</tr>
												</thead>
												<tbody>
													
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>


						</div>
						<div class="card">
						<div id="OtherDashboard" style="display:none">
						
						</div><br>
						<div class="col-md-12" id="ViewTable" style="overflow-x: auto;"></div>
						<br>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script>

	$(document).ready(function () {


		get_bed_availability();
		getDropdown();
	});
	let BedCollection = null;
	let occupied = null;
	let available = null;
	const discharge = [];

	function get_bed_availability() {
		app.request("<?= base_url() ?>" + "bed_management_report", null).then(response => {
			if (response.status == 200) {
				// console.log(response.label);
				BedCollection = response.label;
				occupied = response.occupied;
				available = response.available;
				discharge.push(response.discharge);
				get_Bed_Availability_Chart(BedCollection, occupied, available, discharge);
			} else {
				// app.errorToast(response.body);
			}
			// $("#data_div").html(response.data);
		}).catch(error => {
			console.log(error);
		})
	}


	var myChart1 = "";
	var ctx = "";

	function get_Bed_Availability_Chart(BedCollection, occupied, available, discharge) {

		// if(typeof myChart1.destroy != "undefined") myChart1.destroy();
		// myChart.destroy();
		var ctxId = document.getElementById("BedAvailabilityChart").getContext('2d');
		//var ctx = document.getElementById("BedAvailabilityChart");
		myChart1 = new Chart(ctxId, {
			type: 'bar',
			data: {
				labels: BedCollection,
				datasets: [
					{
						label: 'Occupied',
						data: occupied,
						borderWidth: 2,
						backgroundColor: 'rgba(254,86,83,.7)',
						borderColor: 'rgba(254,86,83,.7)',
						borderWidth: 2.5,
						pointBackgroundColor: 'transparent',
						pointBorderColor: 'transparent',
						pointRadius: 4
						// fillText:occupied
					},
					{
						label: 'Available',
						data: available,
						borderWidth: 2,
						backgroundColor: 'rgba(72,154,93,.8)',
						borderColor: 'rgba(72,154,93,.8)',
						borderWidth: 2.5,
						pointBackgroundColor: 'transparent',
						pointBorderColor: 'transparent',
						pointRadius: 4
					},
				]
			},
			showTooltips: true,
			options: {
				layout: {
					padding: {
						left: 0,
						right: 0,
						top: 15,
						bottom: 0
					}
				},
				events: [],
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: true,
					position: 'top',
				},

				tooltips: {
					callbacks: {
						labelColor: function(tooltipItem, chart) {
							return {
								borderColor: 'rgb(255, 0, 0)',
								backgroundColor: 'rgb(255, 0, 0)'
							};
						},
						labelTextColor: function(tooltipItem, chart) {
							return '#543453';
						}
					}
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: true,
							color: '#f2f2f2',

						},

						ticks: {
							beginAtZero: true,
							display: true,
							position: 'top',
						}
					}],

					xAxes: [{
						gridLines: {
							display: false
						},
						ticks: {
		                    autoSkip: false
		                    // maxRotation: 90,
		                    // minRotation: 90
		                }
					}]
				},
				hover: {
					animationDuration: 0
				},
				animation: {
					duration: 1,
					onComplete: function () {
						var chartInstance = this.chart,
								ctx = chartInstance.ctx;

						ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.textBaseline = 'bottom';

						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								if (dataset.data[index] > 0) {
									var data = dataset.data[index];
									ctx.fillText(data, bar._model.x, bar._model.y);
								}
							});
						});
					}
				}
			}

		});
	}
	
	//mainDashboard
	function go_toDashboard(){
		$("#mainDashboard").show();
		$("#OtherDashboard").hide();
	}
	
	function getDropdown(){
		//getReports
		$.ajax({
			type: "POST",
			url: "<?= base_url("Report/getDropDown") ?>",
			dataType: "json",
			success: function (result) {
				console.log(result.data)
				$("#DropDownDiv").html(result.data);
				/* $('.dropdown-submenu a.test').on("click", function(e){
					
					$(this).next('ul').toggle();
					e.stopPropagation();
					e.preventDefault();
				  }); */
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	
	function getDataHTML(id){
		$("#mainDashboard").hide();
		$("#OtherDashboard").show();
		$.ajax({
			type: "POST",
			url: "<?= base_url("Report/getReportFormData") ?>",
			dataType: "json",
			data:{id},
			success: function (result) {
				$("#OtherDashboard").html("");
				$("#ViewTable").html("");
				if(result.status==200){
					$("#OtherDashboard").html(result.data);
				}else{
					$("#OtherDashboard").html(result.data);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	
	function ShowData(){
		//download_form
		
		$.ajax({
			type: "POST",
			url: "<?= base_url("Report/ShowData") ?>",
			dataType: "json",
			data:$('#download_form').serialize(),
			success: function (result) {
				if(result.status==200){
					$("#ViewTable").html(result.table);
					if(result.is_dataTable == 1){
						getDatatable(result.array_data);
					}
					//$("#table_data").dataTable();
				}else{
					$("#ViewTable").html(result.table);
					//$("#table_data").dataTable();
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	
	function getDatatable(data){
		$('#table_data1').DataTable( {
			data: data
		});
	}
	
	function DownloadData(){
		
		var loginForm = $('#download_form').serializeArray();
			var loginFormObject = {};
			$.each(loginForm,
			    function(i, v) {
			        loginFormObject[v.name] = v.value;
			    });
			const x=JSON.stringify(loginFormObject);
			
	//	var x=$("#query_id").val();
		
		window.location.href= "<?= base_url("Report/DownloadData?formdata=") ?>"+ x;
	}
</script>
