<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<style>
	table.dataTable tbody td {
		word-break: break-word;
		vertical-align: top;
	}

	.main-content {
		width: 100% !important;
	}

	.highlight {
		color: red;
	}
</style>
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header card-primary" style="border-top: 2px solid #891635;">
			<h1 style="color: #891635">Pathology Sample Details</h1>
		</div>
		<div class="section-body">
			<div class="card">
				<ul class="nav nav-pills" id="PathlogyTabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="samplecollectionT" data-toggle="tab"
						   href="#SampleCollectionPanel"
						   role="tab"
						   aria-controls="SampleCollectionPanel" aria-selected="true">Sample Collection </a>
					</li>

<!--					<li class="nav-item">-->
<!--						<a class="nav-link" id="historysampleT" data-toggle="tab" onclick="load_sample_history()"-->
<!--						   href="#SampleHistoryPanel"-->
<!--						   role="tab"-->
<!--						   aria-controls="SampleHistoryPanel" aria-selected="false">History</a>-->
<!--					</li>-->

				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" role="tabpanel" id="SampleCollectionPanel">
						<div class="card-header">
							<div class="col-md-12">
								<div class="row justify-content-end">
									<!--									<button class="btn btn-icon btn-primary mr-1" type="button" onclick="Open_modal()">Upload</button>-->

									<!--									<button class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#fire-modal-pickup_download" type="button">View Sample Collection Order</button>-->
									<!--	<button class="btn btn-primary btn-sm" type="button" onclick="download_excel()">Download Excel</button>-->
									<!--									<button class="btn btn-primary btn-sm" type="button" onclick="click_button()">Sample Collection</button>-->
									<button class="btn btn-primary btn-sm d-none" id="apiModalButton" type="button"
											data-toggle="modal" data-target="#apiModel">api
									</button>
									<button class="btn btn-primary btn-sm" type="button" onclick="generateApi()">Api
										Sample Collection
									</button>
									<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#apiReceiveModel" onclick="healthStartLoad()" type="button" >Api
										Receive Report
									</button>
								</div>
								<div class="row">
									<div class="form-group mx-2 my-0">
										<select class="form-control" id='psampleAllPatient'
												onchange="loadTable()"
												style="width: 100%;margin-top:-30px; ">
										</select>
									</div>
								</div>
							</div>

						</div>
						<form id="saveSampleCollection" data-form-valid="saveCollection">
							<div class="card-body">

								<table class="table table-bordered table-stripped" id="pathologyPickupTable"
									   style="width: 100%">
									<thead>
									<tr>
										<th><input type="checkbox" name="select_all" value="-1" id="example-select-all"
												   class="custom-control custom-checkbox"></th>
										<th>Patient Name</th>
										<th>Service Order No.</th>
										<th>Service Code</th>
										<th>Service Name</th>

									</tr>
									<tr>
										<th></th>
										<th>Patient Name</th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
									</thead>
									<tbody>
									</tbody>
									<tfoot id="footerButton">
									<tr>
										<td colspan="5" class="text-right">
											<button id="save_button" style="display:none"
													class="btn btn-primary btn-sm">Sample Collection
											</button>

											<button id="openOrderModel" data-toggle="modal"
													data-target="#fire-modal-pickup" type="button" class="d-none">open
											</button>
										</td>
									</tr>
									</tfoot>
								</table>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" role="tabpanel" id="SampleHistoryPanel">

						<div class="col-md-12">
							<div class="row justify-content-end">
								<div class="align-items-center ">

									<div class="form-group mx-2 my-0">
										<select name="HistoryPatient" id="HistoryPatient" class="form-control"
												onchange="load_sample_history()" style="border-radius: 20px;">
											<option selected disabled>Select Patient</option>

										</select>
									</div>
								</div>
								<div class="row justify-content-end">
									<div class="align-items-center ">
										<div class="form-group mx-2 my-0">
											<select name="historyStatus_filter" id="historyStatus_filter"
													class="form-control" onchange="load_sample_history()"
													style="border-radius: 20px;">
												<option value="1">Pending</option>
												<option value="2">Completed</option>
												<option value="0">All</option>
											</select>
										</div>

									</div>
									<div class="align-items-center ">
										<div class="form-group mx-2 my-0">
											<button class="btn btn-primary" type="button"
													onclick="downloadSampleHistory()" style="margin-top: 4px;"><i
														class="fa fa-download"></i> Export Excel
											</button>
										</div>
									</div>

								</div>

								<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
									   cellspacing="0" id="HistorySampleTable" style="width:100%">
									<thead>
									<tr>
										<td>Patient Name</td>
										<td> Date</td>
										<td>Order Id</td>
										<td> Status</td>
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
	</section>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="apiReceiveModel"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<ul class="nav nav-pills role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="healthStartApi"
							   data-toggle="tab"
							   href="#healthHistoryPanel" role="tab"
							   aria-controls="healthHistoryPanel"
							   aria-selected="false">
								HealthStart-Api
							</a>
						</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" role="tabpanel" id="healthHistoryPanel">
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<button type="button" class="btn btn-sm btn-outline-primary" onclick="healthStartLoad()">Sync Data</button>
										</div>
										<div class="row">
											<table id="healthStartTable" class="dataTable no-footer table-bordered table-striped " style="width: 100%">
												<thead>
												<tr>
													<th>Response</th>
													<th>Date-Time</th>
												</tr>
												</thead>
												<tbody></tbody>
											</table>
										</div>

									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="apiModel"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

				<div class="modal-body py-0">
					<div class="card my-0 shadow-none">
						<div class="card-body">
							<ul class="nav nav-pills role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="JioApi"
									   data-toggle="tab" href="#JioApiCollectionPanel"
									   role="tab" aria-controls="JioApiCollectionPanel"
									   aria-selected="true">Api-Site.jio.com</a>
								</li>

							</ul>
							<div class="tab-content">
								<div class="tab-pane fade show active" role="tabpanel" id="JioApiCollectionPanel">
									<form id="api-request" method="post">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<p class="card-title font-weight-bold" id="api-patient-id"></p>
											</div>
											<div class="row">
												<div class="col-md-4">
													<p class="card-title font-weight-bold">Service Order No</p>
													<p class="card-subtitle" id="api-service_order"></p>
												</div>
												<div class="col-md-4">
													<p class="card-title font-weight-bold">Service Code</p>
													<p class="card-subtitle" id="api-service-code"></p>
												</div>
												<div class="col-md-4">
													<p class="card-title font-weight-bold">Service Name</p>
													<p class="card-subtitle" id="api-service-name"></p>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<p class="card-title font-weight-bold">HL7String</p>
													<p class="card-subtitle" id="api-hl7RawString"></p>
													<p class="card-title font-weight-bold">HL7String Soap Request</p>
													<textarea class="form-control"  style=" min-height: 400px;max-height: 900px;height: auto;resize: none" name="hl7string" id="api-hl7string"></textarea>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<p class="card-title font-weight-bold">API Response</p>
													<textarea class="form-control" style=" min-height: 100px;max-height: 900px;height: auto;resize: none" id="api-reponseString"></textarea>
												</div>
											</div>
										</div>
									</div>
										<div class="row">
											<button class="btn btn-sm btn-outline-primary btn-block">Send Request</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" role="tabpanel" id="healthHistoryPanel">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<button type="button" class="btn btn-sm btn-outline-primary" onclick="healthStartLoad()">Sync Data</button>
											</div>
											<div class="row">
												<table id="healthStartTable" class="dataTable no-footer table-bordered table-striped " style="width: 100%">
													<thead>
													<tr>
														<th>Response</th>
														<th>Date-Time</th>
													</tr>
													</thead>
													<tbody></tbody>
												</table>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

		</div>
	</div>
</div>


<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
	$(document).ready(function () {
		get_zone();

	})
	$('#api-request').validate({
		rules: {
			hl7string: {
				required: true
			}
		},
		messages: {
			hl7string: {
				required: "Please Add HL7 String"
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {
			app.request(baseURL + "apiSendSampleCollection", new FormData(form)).then(response => {
				if(response.status ===200){
					$("#api-reponseString").val(response.raw)
					app.successToast(response.body);
				}else if(response.status ===201){
					$("#api-reponseString").val(response.raw)
					app.successToast(response.error);
				}else{
					$("#api-reponseString").val(response.error)
					app.successToast("Failed");
				}
			})
		}
	});

	function healthStartLoad(){
		app.dataTable("healthStartTable",{
			url:baseURL+"getLabReportSampleCollection",
		});
	}

	$('#excelFileupload').validate({
		rules: {
			file_ex1: {
				required: true
			}
		},
		messages: {
			file_ex1: {
				required: "Select Excel File"
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {

			if ($('#sample_upload_file').val()) {


				var form_data = document.getElementById('excelFileupload');
				var Form_data = new FormData(form_data);
				$.ajax({
					type: "POST",
					url: baseURL + "add_Excel_file",
					dataType: "json",
					data: Form_data,
					contentType: false,
					processData: false,
					success: function (result) {
						if (result.status === 200) {
							app.successToast(result.body);
							get_file_uploaded_table();
							modalafterfileUpload(result.insertCount, result.existingCount, result.duplicate_table);
						} else if (result.status === 202) {
							app.errorToast(result.body);

						} else {
							app.errorToast(result.body);
							modalafterfileUpload(result.insertCount, result.existingCount, result.duplicate_table);
						}
						$('#excelFileupload').trigger('reset')
					}, error: function (error) {
						console.log('Logged ---> ', error);
						app.errorToast('something went wrong');
						$('#excelFileupload').trigger('reset')
					}
				});
			}
		}
	});

	function Open_modal() {
		$("#file_save_modal").modal('show');
		get_file_uploaded_table();
	}

	function get_file_uploaded_table() {
		$.ajax({
			type: "POST",
			url: baseURL + "getuploadedFiles",
			dataType: "json",

			contentType: false,
			processData: false,
			success: function (result) {
				if (result.status === 200) {
					$("#fileuploadedData").html(result.data);
					$("#fileTable").DataTable();

				} else {
					$("#fileuploadedData").html("");
				}

			}, error: function (error) {
				console.log('Logged ---> ', error);
				app.errorToast('something went wrong');

			}
		});
	}

	function modalafterfileUpload(insert, duplicate, table) {
		$("#modalafterfileUpload").modal('show');

		$("#data_insert").html("<h4>Successfull Entries : " + insert + "</h4><br><h4>Duplicate Entries : " + duplicate + "</h4>");
		//$("#dup_table").DataTable();
	}

	function click_button() {
		//save_button
		$("#save_button").click();
	}

	function download_excel_new() {
		var id = $("#orderNumberhideen").val();
	}

	function generateApi() {

		if (sampleCollection.length === 1) {
			let patientOrderNumber = sampleCollection[0].id.split("_");
			console.log(patientOrderNumber[1], patientOrderNumber[2]);
			let formData = new FormData();
			formData.set("patient_id", patientOrderNumber[1])
			formData.set("order_number", sampleCollection[0].id)
			app.request(baseURL + "apiSaveSampleCollection", formData).then(response => {
				if (response.status === 200) {
					$("#api-service_order").empty();
					$("#api-service_order").append(response.serviceOrders.join("|"));
					$("#api-service-code").empty();
					$("#api-service-code").append(response.serviceCode.join("|"));
					$("#api-service-name").empty();
					$("#api-service-name").append(response.serviceName.join("|"));
					$("#api-patient-id").empty();
					$("#api-patient-id").append(response.patientName);
					$("#api-hl7RawString").empty();
					$("#api-hl7RawString").append(response.raw);
					$("#api-hl7string").val(response.body)
					highlight(response.staticValues);
				} else {
					$("#api-service_order").empty();
					$("#api-service-code").empty();
					$("#api-service_name").empty();
					$("#api-patient-id").empty();
					app.errorToast(response.body);
				}

			}).catch(error => {
				console.log(error);
				app.errorToast("something went wrong");
			});
			$("#apiModalButton").click();
		} else {
			app.errorToast("Select Only One Patient")
		}

	}

	function highlight(highlight) {
		var inputText = document.getElementById("api-hl7RawString");
		var innerHTML = inputText.innerHTML;
		highlight.forEach(text => {
			// var index = innerHTML.indexOf(text);
			// if (index >= 0) {
			// 	innerHTML = innerHTML.substring(0,index) + "<span class='highlight'>" + innerHTML.substring(index,index+text.length) + "</span>" + innerHTML.substring(index + text.length);
			// 	inputText.innerHTML = innerHTML;
			// }
			var regex = new RegExp('(' + text + ')', 'g');
			innerHTML = innerHTML.replace(regex, '<span class="highlight">$1</span>');
			inputText.innerHTML = innerHTML;
		})

	}
</script>
