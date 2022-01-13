<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>

	table.dataTable tbody td {
		word-break: break-word;
		vertical-align: top;
	}

	div.wrapDiv {
		white-space: nowrap;
		width: 100px;

		overflow: hidden;
		text-overflow: ellipsis;
	}

	div.wrapDiv:hover {
		overflow: visible;
		white-space: normal;

	}

	.bundle_div {
		padding: 35px;
		border-top: 5px solid #d3d3d3;

	}
	.bundle_div ,h6{
		font-weight:500;
	}

	.text-muted {
		font-size: 12px;
	}

	.card_my_header {
		border-bottom: 1px solid #f9f9f9;

		width: 100%;
		/*min-height: 70px;*/
		padding: 5px 5px;

		text-align: center;
	}

	.right_side_card {
		border-radius: 0px 0px 20px 20px;
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	.right_side_card_middle {
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	.right_side_card_top {
		border-radius: 20px 20px 0px 0px;
		border: 1px: solid #f1f1f1;
		padding: 23px;
	}

	
	.diagonal_divline_l {
	  width:25%;
	  background: linear-gradient(to top right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_r {
	  width:25%;
	  background: linear-gradient(to bottom right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_b {
	  width:25%;
	  background: linear-gradient(to left bottom, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.diagonal_divline_bl {
	  width:25%;
	  background: linear-gradient(to bottom right, #fff calc(50% - 1px), #aaa, #fff calc(50% + 1px) )
	}
	.border_bottom
	{
		border-bottom: 1px solid #aaa;
	}
	.border_right
	{
		border-right: 1px solid #aaa;

	}
	.card_height
	{
		height: 260px!important;
	}
</style>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<!-- <div class="section-header" style="border-top: 2px solid #891635">
			<h1> Sample Collection</h1>
		</div> -->
		<div class="section-header card-primary" style="border-top: 2px solid #891635">
			<h1 style="color: #891635">Patient Dashboard</h1>

		</div>
		<div class="section-body" style="background-color:lightgray;padding: 10px; ">
			<div class="" style="overflow-x: auto;">
				<div class="row">
					<div class="col-12 col-sm-12 col-lg-4 mt-lg-0 mt-sm-4 pr-0" style="font-size: 13px">

						  <div class="card card_height">
		                 <!--  <div class="card-header">
		                    <h4>VITALS </h4> <span class="text-muted"> 2/7 14:00</span>
		                  </div> -->
		                  <div class="card-body text-center" >
		                  	<!-- <div>HR:<span id="V_HR">110(110-120)</span> CVP:14mmHg
		                  	</div>
							
		                  	<div>BP:<span id="V_BP">121/79(93)</span> RR:<span id="V_RR">13</span> SpO2:<span id="V_SPO2">97%</span>
		                  	</div>
		                  	<div>TC: 105.1 Tm: <span id="V_TM">105.8 0F</span>
		                  	</div>	 -->
		                   <div id="patientReport_image"></div>
		                  </div>
		                </div>
					</div>
					<div class="col-12 col-sm-12 col-lg-4 mt-lg-0 mt-sm-4 pr-0" style="font-size: 13px">
						  <div class="card card_height">
		                  <div class="card-header" style="min-height: 0px!important">
		                    <h4>HEME</h4> <span class="text-muted last_visit"></span>
		                  </div>
		                  <div class="card-body">
		                  	<!-- <div class="row"> -->
		                  		<!-- <div class="col-md-9">
		                  			<div class="row">
				                  		<div class="col-md-4 diagonal_divline_l"></div>
				                  		<div class="col-md-4 diagonal_divline_s">15.3</div>
				                  		<div class="col-md-4 diagonal_divline_r"></div>
				                  		<div class="col-md-4">19.9</div>
				                  		<div class="col-md-4"></div>
				                  		<div class="col-md-4">381</div>
				                  		<div class="col-md-4 diagonal_divline_bl"></div>
				                  		<div class="col-md-4">51.5</div>
				                  		<div class="col-md-4 diagonal_divline_b"></div>
				                  	</div>
				                 
		                  		</div>
		                  		<div class="col-md-3 text-center" style="border:1px solid lightgray;border-radius: 5px;">
		                  			<div style="border-bottom: 1px solid lightgray;padding-top: 10px">Bands</div>
		                  			<div>3</div>
		                  		</div> -->
		                  		<div id="HEME">
		                  			<table class="table-bordered" style="width: 100%">
		                  				<thead>

		                  				</thead>
		                  				<tbody>
		                  					<tr>
		                  						<td>Neutrophils</td><td id="Neutrophils"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Lymphocytes</td><td id="Lymphocytes"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Monocytes</td><td id="Monocytes"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Eosinophils</td><td id="Eosinophils"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Basophils</td><td id="Basophils"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Platelet_Count</td><td id="Platelet_Count"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Haemoglobin</td><td id="Haemoglobin"></td>
		                  					</tr>
		                  				</tbody>
		                  			</table>
		                  		</div>
		                  	<!-- </div> -->
		                  	
		                   
		                  </div>
		                </div>
					</div>
					<div class="col-12 col-sm-12 col-lg-4 mt-lg-0 mt-sm-4" style="font-size: 12px">
						  <div class="card card_height">
		                  <div class="card-header text-center" style="min-height: 0px!important">
		                    <h4>CHEM </h4> <span class="text-muted last_visit"></span>  
		                  </div>
		                  <div class="card-body">
		                  <!-- 	<div class="row">
		                  		<div class="col-md-6">
		                  			<div class="row">
		                  				<div class="col-md-3 pb-1 border_right border_bottom">142</div>
		                  				<div class="col-md-3 pb-1 border_right border_bottom">98</div>
		                  				<div class="col-md-3 pb-1 border_bottom">21</div>
		                  				<div class="col-md-3 diagonal_divline_r"></div>
		                  				<div class="col-md-3 pt-1 border_right">3.6</div>
		                  				<div class="col-md-3 pt-1 border_right">24</div>
		                  				<div class="col-md-3 pt-1 ">1</div>
		                  				<div class="col-md-3 diagonal_divline_b"></div>
		                  			</div>
		                  		</div>
		                  		<div class="col-md-6">
		                  			<div>iCa:5.04 @2/7 13:41</div>
		                  			<div>Mg: 1.6 @2/7 01:48</div>
		                  			<div>PO4:4.1 @2/7 01:48</div>
		                  		</div>
		                  	</div> -->
		                  	<div class="">
		                  		<table class="table-bordered" style="width: 100%">
		                  				<thead>

		                  				</thead>
		                  				<tbody>
		                  					<tr>
		                  						<td>Chloride</td><td id="Chloride"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Potassium</td><td id="Potassium"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Sodium</td><td id="Sodium"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Bicarbonate</td><td id="Bicarbonate"></td>
		                  					</tr>
		                  					<tr>
		                  						<td>Calcium</td><td id="Calcium"></td>
		                  					</tr>
		                  					
		                  				</tbody>
		                  			</table>
		                  	</div>
		                   
		                  </div>
		                </div>

					</div>
				</div>
				<div class="row">

					<div class="col-12 col-sm-12 col-lg-2 mt-lg-0 mt-sm-4 text-center pr-0">
						<div class="card text-center" style="border-radius: 20px;">
							<div class="text-center" style="padding: 20px">
								<h5>BUNDLES</h5>
							</div>
							<div class="text-center">

								<div class="bundle_div">
									<h6 id="cl">Central Line</h6>
									<div><span class="text-muted">Loc:NSCI-</span>
									<span class="text-muted" id="days_new"></span><span class="text-muted" id="time_new"></span></div>
									<div><span class="text-muted" id="ResultCentralLine"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="al">Arterial Lines </h6>
									<div><span class="text-muted" id="ResultAtrialLine"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="hc">HD Catheter </h6>
									<div><span class="text-muted" id="Hdcath"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="pl">Peripheral Line </h6>
									<div><span class="text-muted" id="periline"></span></div>
									
								</div>
								<div class="bundle_div">
									<h6 id="dr">Drains </h6>
									<div><span class="text-muted" id="Drains"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="uc">Urinary Catheter</h6>
									<div><span class="text-muted" id="urincath"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="et">Endotracheal Tube</h6>
									<div><span class="text-muted" id="endotube"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="ic">IABP catheter</h6>
									<div><span class="text-muted" id="iabpcath"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="tt">Tracheostomy tube</h6>
									<div><span class="text-muted" id="trachtube"></span></div>
								</div>
								<div class="bundle_div">
									<h6 id="rt">Ryles tube</h6>
									<div><span class="text-muted" id="ryletube"></span></div>
								</div>

							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-lg-7 mt-lg-0 mt-sm-4 pr-0">
						<div class="card mb-1">
							<div class="card_my_header text-center">
								<h6>HR: Last 1 hour</h6>
							</div>
							<div class="card-body">
								<canvas id="HRCHART" height="150" width="393"
										style="display: block; width: 393px; height: 150px;"
										class="chartjs-render-monitor"></canvas>
							</div>
						</div>
						<div class="card mb-1">
							<div class="card_my_header text-center">
								<h6>RR: Last 1 hour</h6>
							</div>
							<div class="card-body">
								<canvas id="RRCHART" height="150" width="393"
										style="display: block; width: 393px; height: 150px;"
										class="chartjs-render-monitor"></canvas>

							</div>
						</div>
						<div class="card mb-1">
							<div class="card_my_header text-center">
								<h6>NIBP: Last 1 hour</h6>
							</div>
							<div class="card-body">
								<canvas id="nibpCHART" height="150" width="393"
										style="display: block; width: 393px; height: 150px;"
										class="chartjs-render-monitor"></canvas>

							</div>
						</div>
						<!-- <div class="card mb-1">
							<div class="card_my_header text-center">
								<h6>SBP/MAP: 2 hours 20 minutes Last: 2/7 14:00</h6>
							</div>
							<div class="card-body">
								<canvas id="SBPMAPCHART" height="150" width="393"
										style="display: block; width: 393px; height: 150px;"
										class="chartjs-render-monitor"></canvas>

							</div>
						</div> -->
						<div class="card mb-1">
							<div class="card_my_header text-center">
								<h6>SpO2: Last 1 hour</h6>
							</div>
							<div class="card-body">
								<canvas id="SPO2CHART" height="150" width="393"
										style="display: block; width: 393px; height: 150px;"
										class="chartjs-render-monitor"></canvas>


							</div>
						</div>
					</div>
					<div class="col-12 col-sm-12 col-lg-3 mt-lg-0 mt-sm-4 text-center">
						<div class="card mb-2 right_side_card_top" style="">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6><span id="sofa_head">SOFA</span> <span class="text-muted" id="sofa_date"></span></h6>
							</div>
							<div class="" style="font-size: 14px;">
								<div><h6>Score: <span id="sofa_score"></span></h6></div>
								<div>*No GCS, Pressors</div>
							</div>
						</div>
						<div class="card mb-2 right_side_card_middle">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6><span id="glucose_head">GLUCOSE</span> <span class="text-muted">(PoC) <span id="glucose_date"></span></span></h6>
							</div>
							<div class="" style="font-size: 14px;">
								<div id="glucose_score"></div>

							</div>
						</div>
						<div class="card mb-2 right_side_card_middle">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6><span id="lactate_head"> LACTATE</span> <span
											class="text-muted" id="lactate_date"></span></h6>
							</div>
							<div class="">
								<div id="LACTATE"></div>
								<!-- <div>Prev: 0.3 - Cur:8.9</div> -->
							</div>
						</div>
						<div class="card mb-2" style="border:1px:solid #f1f1f1;padding: 20px">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6><span id="bloodGas_head">BLOOD GAS</span> <span class="text-muted">(ART) <span id="bloodGas_date"></span></span></h6>
							</div>
							<div class="">
								<div id="bloodGas_score"></div>
								<div>7.41|41.6|181|23.4|2.9|96.7</div>

							</div>
						</div>
						<div class="card mb-2 right_side_card_middle">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6>VENT <span class="text-muted" id="time2"></span></h6>
							</div>
							<div class="" id="VentDiv">
								

							</div>
						</div>
						<div class="card mb-2 right_side_card_middle" style="">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6><span class="text-muted">2/7 01:48</span> COAGS <span
											class="text-muted">2/7 01:48</span></h6>
							</div>
							<div class="">
								<div>PTT: 37.6 | PT: 18.3 INR:0.9</div>

							</div>
						</div>
						<div class="card mb-1 right_side_card">
							<div class="" style="border-bottom: 1px solid #d3d3d37d">
								<h6>TEG <span class="text-muted">2/7 13:41</span></h6>
							</div>
							<div class="">
								<div>R:06 a:66.3</div>
								<div>K:08 MA:63.6</div>
								<div> Ly-30:1.2</div>
							</div>
						</div>


					</div>

				</div>
			</div>
		</div>
	</section>
</div>

<div class="modal fade" id="largeVideo" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
			<div class="modal-body">
				<div class="row justify-content-center align-items-center">
					<canvas id="large_video_panel" width="500" height="400">
							No Supported
					</canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
	const videoStreaming ='https://vs.docango.com/';
	let cameraCapture =null; 
	$(document).ready(function () {
		get_Hr_chart();
		get_Rr_chart();
		get_nibp_chart();
		//get_SBP_MAP_chart();
		get_SPO2_chart();
		/* var intervalId = window.setInterval(function(){
			get_Hr_chart();
	}, 10000); */
	$('#largeVideo').on('show.bs.modal', function (e) {
			let camera = parseInt($(e.relatedTarget).data('camera'));
			largeVideoPanel(-1);
			largeVideoPanel(camera);
		})
		$('#largeVideo').on('hide.bs.modal', function (e) {
			disconnectVideo();
		})
	});


</script>
<script language="JavaScript">
	let labelsCollection = null;
	let record = null;
	const trans = [];

	function get_Hr_chart() {
		var patient_id = localStorage.getItem("patient_id");
		
		$.ajax({
			type: "POST",
			url: "<?= base_url("get_Hr_chart") ?>",
			dataType: "json",
			data: {patient_id},
			success: function (result) {
				if (result.status === 200) {
					labelsCollection = result.label;
					record = result.data;
					trans.push(result.trans);
					get_Hr_Line_Chart(labelsCollection, record, trans);
				} else {
					app.errorToast(result.body);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});

	}
	let myChart;
	function get_Hr_Line_Chart(labelsCollection, record, trans) {

		var ctx = document.getElementById("HRCHART").getContext('2d');
		 myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: labelsCollection,
				datasets: [{
					label: 'HR',
					data: record,
					borderWidth: 2,
					backgroundColor: 'transparent',
					borderColor: 'rgba(254,86,83,.7)',
					pointBackgroundColor: 'transparent',
					pointBorderColor: 'transparent',
					pointRadius: 4
				},
				]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							min: Math.min(...record),
							max: Math.max(...record),
							stepSize: 1
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						}

					}]
				},
			}
		});
	}

	let SBPMAPCollection = null;
	let SBP = null;
	let MAP = null;
	const transSBPMAP = [];

	function get_SBP_MAP_chart() {
		$.ajax({
			type: "POST",
			url: "<?= base_url("get_SBP_MAP_chart") ?>",
			dataType: "json",
			data: '',
			success: function (result) {
				if (result.status === 200) {
					SBPMAPCollection = result.label;
					SBP = result.SBP;
					MAP = result.MAP;
					transSBPMAP.push(result.trans);
					get_SBP_MAP_Chart(SBPMAPCollection, SBP, MAP, transSBPMAP);
				} else {
					app.errorToast(result.body);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});

	}

	function get_SBP_MAP_Chart(SBPMAPCollection, SBP, MAP, transSBPMAP) {
		var ctx = document.getElementById("SBPMAPCHART").getContext('2d');
		var myChart1 = new Chart(ctx, {
			type: 'line',
			data: {
				labels: SBPMAPCollection,
				datasets: [{
					label: 'SBP',
					data: SBP,
					borderWidth: 2,
					backgroundColor: 'transparent',
					borderColor: 'rgba(254,86,83,.7)',
					borderWidth: 2.5,
					pointBackgroundColor: 'transparent',
					pointBorderColor: 'transparent',
					pointRadius: 4
				},
					{
						label: 'MAP',
						data: MAP,
						borderWidth: 2,
						backgroundColor: 'transparent',
						borderColor: 'rgba(72,154,93,.8)',
						borderWidth: 2.5,
						pointBackgroundColor: 'transparent',
						pointBorderColor: 'transparent',
						pointRadius: 4
					},
				]
			},
			options: {
				elements: {
					line: {
						tension: 0 // disables bezier curves
					}
				},
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							beginAtZero: true,
							stepSize: 20
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						}
					}]
				},
			}
		});
	}

	let spo2Collection = null;
	let spo2 = null;
	const transspo2 = [];

	function get_SPO2_chart() {
		var patient_id = localStorage.getItem("patient_id");
		$.ajax({
			type: "POST",
			url: "<?= base_url("get_SPO2_chart") ?>",
			dataType: "json",
			data: {patient_id},
			success: function (result) {
				if (result.status === 200) {
					spo2Collection = result.label;
					spo2 = result.data;
					transspo2.push(result.trans);
					get_SpO2_Line_Chart(spo2Collection, spo2, transspo2);
				} else {
					app.errorToast(result.body);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});

	}

	function get_SpO2_Line_Chart(spo2Collection, spo2, transspo2) {
		var ctx = document.getElementById("SPO2CHART").getContext('2d');
		var myChart2 = new Chart(ctx, {
			type: 'line',
			data: {
				labels: spo2Collection,
				datasets: [{
					label: 'SpO2',
					data: spo2,
					borderWidth: 2,
					backgroundColor: 'transparent',
					borderColor: 'rgba(21,15,202,.7)',
					borderWidth: 2.5,
					pointBackgroundColor: 'transparent',
					pointBorderColor: 'transparent',
					pointRadius: 4
				},
				]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							beginAtZero: true,
							stepSize: 5
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						},
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}]
				},
			}
		});
	}
	let RRlabelsCollection = null;
	let RRrecord = null;
	const RRtrans = [];
	function get_Rr_chart() {
		var patient_id = localStorage.getItem("patient_id");
		
		$.ajax({
			type: "POST",
			url: "<?= base_url("get_Rr_chart") ?>",
			dataType: "json",
			data: {patient_id},
			success: function (result) {
				if (result.status === 200) {
					RRlabelsCollection = result.label;
					RRrecord = result.data;
					RRtrans.push(result.trans);
					get_Rr_Line_Chart(RRlabelsCollection, RRrecord, RRtrans);
				} else {
					app.errorToast(result.body);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});

	}
	
	function get_Rr_Line_Chart(RRlabelsCollection, RRrecord, RRtrans) {

		var ctx = document.getElementById("RRCHART").getContext('2d');
		 myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: RRlabelsCollection,
				datasets: [{
					label: 'RR',
					data: RRrecord,
					borderWidth: 2,
					backgroundColor: 'transparent',
					borderColor: 'rgba(68,199,205,1)',
					pointBackgroundColor: 'transparent',
					pointBorderColor: 'transparent',
					pointRadius: 4
				},
				]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						}

					}]
				},
			}
		});
	}
	
	
	
	let NIlabelsCollection = null;
	let NIrecord = null;
	const NItrans = [];
	function get_nibp_chart() {
		var patient_id = localStorage.getItem("patient_id");
		
		$.ajax({
			type: "POST",
			url: "<?= base_url("get_nibp_chart") ?>",
			dataType: "json",
			data: {patient_id},
			success: function (result) {
				if (result.status === 200) {
					NIlabelsCollection = result.label;
					NIrecord = result.data;
					NItrans.push(result.trans);
					get_nibp_Line_Chart(NIlabelsCollection, NIrecord, NItrans);
				} else {
					app.errorToast(result.body);
				}

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});

	}
	
	function get_nibp_Line_Chart(NIlabelsCollection, NIrecord, NItrans) {

		var ctx = document.getElementById("nibpCHART").getContext('2d');
		 myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: NIlabelsCollection,
				datasets: [{
					label: 'NIBP',
					data: NIrecord,
					borderWidth: 2,
					backgroundColor: 'transparent',
					borderColor: 'rgba(68,199,205,1)',
					pointBackgroundColor: 'transparent',
					pointBorderColor: 'transparent',
					pointRadius: 4
				},
				]
			},
			options: {
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							drawBorder: false,
							color: '#f2f2f2',
						},
						ticks: {
							beginAtZero: true,
							stepSize: 1
						}
					}],
					xAxes: [{
						gridLines: {
							display: false
						}

					}]
				},
			}
		});
	}
</script>
