<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
$user_type = $session_data->user_type;
$role = $session_data->roles;
?>
<style>
	.select2.select2-container.select2-container--default {
		width: 100% !important;
	}

	.accordion .accordion-header[aria-expanded="true"] {
		box-shadow: 0 2px 6px #891635 !important;
		background-color: #891635 !important;
	}

	.dropdown-check-list {
		display: inline-block;
	}

	.dropdown-check-list .anchor {
		position: relative;
		cursor: pointer;
		display: inline-block;
		padding: 5px 50px 5px 10px;
		border: 1px solid #ccc;
	}

	.dropdown-check-list .anchor:after {
		position: absolute;
		content: "";
		border-left: 2px solid black;
		border-top: 2px solid black;
		padding: 5px;
		right: 10px;
		top: 20%;
		-moz-transform: rotate(-135deg);
		-ms-transform: rotate(-135deg);
		-o-transform: rotate(-135deg);
		-webkit-transform: rotate(-135deg);
		transform: rotate(-135deg);
	}

	.dropdown-check-list .anchor:active:after {
		right: 8px;
		top: 21%;
	}

	.dropdown-check-list ul.items {
		padding: 2px;
		display: none;
		margin: 0;
		/*border: 1px solid #ccc;*/
		/*border-top: none;*/
	}

	.dropdown-check-list ul.items li {
		list-style: none;
	}

	.dropdown-check-list.visible .anchor {
		color: #0094ff;
	}

	.dropdown-check-list.visible .items {
		display: block;
	}

	div.a {
		white-space: nowrap;
		width: 100px;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	div.a:hover {
		overflow: visible;
	}

	.view {
		margin: auto;
		width: 100%;
	}

	.wrapper {
		position: relative;
		overflow: auto;
		/*border: 1px solid black;*/
		white-space: nowrap;
	}

	.sticky-col {
		position: -webkit-sticky;
		position: sticky;
		background-color: white;
	}

	.first-col {
		width: 50px;
		min-width: 50px;
		max-width: 50px;
		left: 0px;
	}

	.second-col {
		width: 150px;
		min-width: 150px;
		max-width: 150px;
		left: 100px;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<!-- <div class="section-header" style="border-top: 2px solid #891635">
			<h1></h1>
		</div> -->
		<div class="section-header card-primary" style="border-top: 2px solid #891635;">
			<h1 style="color: #891635;">Other Services</h1>
			<input type="hidden" id="userTypeCheck" value="<?php echo $role; ?>"/>
			<div class="card-header-action" style="margin-left: auto;">
				<ul class="nav nav-pills" id="radiologyTabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="radiologyCollectionTab" data-toggle="tab"
						   href="#radiologyCollectionPanel"
						   role="tab"
						   aria-controls="radiologyCollectionPanel" aria-selected="true">Other Services Collection</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="radiologyHistoryTab" data-toggle="tab" href="#radiologyHistoryPanel"
						   role="tab"
						   aria-controls="radiologyHistoryPanel" aria-selected="false">Other Services History</a>
					</li>

				</ul>
			</div>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">

					<div class="card">

						<div class="card-body">
							<div class="tab-content">
								<div class="tab-pane fade show active" role="tabpanel" id="radiologyCollectionPanel">
									<div class="">
										<div class="card-header-action d-flex">
<!-- 
											<div class="col-md-4 form-group">
												<select class="form-control" id='sampleAllPatient'
														onchange="getSampleCollectionTable1('RADIOLOGY','radiologySampleTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div> -->
											<div class="col-md-4 form-group">
												<select class="form-control" id='OtherServiceAllPatient'
														onchange="getSampleCollectionTable1('RADIOLOGY','radiologySampleTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div>
											<div class="col-md-4 form-group">
												<select class="form-control" id='OtherServiceAllCategory'
														onchange="getSampleCollectionTable1('RADIOLOGY','radiologySampleTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div>
											<div class="col-md-4 form-group">
												<button class="btn btn-primary" type="button"
																	id="OtherServiceReportBtn"
																	onclick="getOtherServicesReport()"><i
																		class="fa fa-download"></i> Download Excel
															</button>
										</div>
									</div>
										<button id="openRadiologyUploadButton" data-toggle="modal"
												data-target="#getRadiologyUploadModal" type="button" class="d-none">open
										</button>
										<table class="table table-bordered table-stripped" id="radiologySampleTable">
											<thead>
											<tr>
												<th>Bed No.</th>
												<!-- <th>Patient ID</th> -->
												<th>Patient Name</th>
												<th>Service Code</th>
												<th>Service Order No.</th>
												<th>Service Name</th>
												<th>Confirm Service Given</th>
												<th>Delete Service</th>
												<th>Service Provider</th>
												<th>Date and Time</th>
												<!-- <th>files</th>
												<th>Status</th>
												<th>Remark</th> -->
											</tr>
											<!-- <tr>
												<th>Bed No.</th>

												<th>Patient Name</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												
											</tr> -->
											</thead>
											<tbody>

											</tbody>
										</table>

									</div>
								</div>
								<div class="tab-pane fade" role="tabpanel" id="radiologyHistoryPanel">
									<div class="">
										<div class="card-header-action d-flex">

										<!-- 	<div class="col-md-4 form-group">
												<select class="form-control" id='rsampleAllPatient'
														onchange="getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div> -->
											<div class="col-md-4 form-group">
												<select class="form-control" id='OtherServiceAllHistoryPatient'
														onchange="getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div>
											<div class="col-md-4 form-group">
												<select class="form-control" id='OtherServiceAllHistoryCategory'
														onchange="getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable',this.value)"
														style="width: 100%;border-radius: 20px;">
												</select>
											</div>
											<div class="col-md-4 form-group">
												<button class="btn btn-primary" type="button"
																	id="OtherServiceHistoryReportBtn"
																	onclick="getOtherServicesHistoryReport()"><i
																		class="fa fa-download"></i> Download Excel
															</button>
											</div>
										</div>

										<table class="table table-bordered table-stripped"
											   id="radiologySampleHistoryTable">
											<thead>
											<tr>
												<th>Bed No.</th>
												<!-- <th>Patient ID</th> -->
												<th>Patient Name</th>
												<th>Service Code</th>
												<th>Service Order No.</th>
												<th>Service Name</th>
												<th>Files</th>
												<th>Normal</th>
												<th>Remark</th>
												<th>Service Provider</th>
												<th>Date and Time</th>
												<!-- <th>files</th>
												<th>Status</th>
												<th>Remark</th> -->
											</tr>
											<!-- <tr>
												<th>Bed No.</th>

												<th>Patient Name</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												
											</tr> -->
											</thead>
											<tbody>

											</tbody>
										</table>

									</div>
								</div>
							</div>


						</div>


					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<!--prescription modal -->
<div class="modal fade" id="getRadiologyUploadModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Confirm Service</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="radioFileUploadationForm" method="post" onsubmit="return false">
					<div class="row">
						<div class="col-md-12">

							<input type="hidden" name="radioServiceIds" id="radioServiceIds">
							<input type="hidden" name="serviceBillingIds" id="serviceBillingIds">
							<input type="hidden" name="patient_id" id="radioPatientId">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="service_file">File Upload</label>
									<input type="file" class="form-control" name="service_file[]" multiple
										   data-valid="required" data-msg="Select file"
										   id="service_file">
									<span id="radiology_diles_error" style="color: red"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="normal_status">Normal</label>
									<select id="normal_status" name="normal_status" class="form-control">
										<option selected disabled>Select Status</option>
										<option value="yes">Yes</option>
										<option value="no">No</option>
										<option value="Inconclusive">Inconclusive</option>
										<option value="Awaiting">Awaiting</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="radioly_remark">Remark</label>
									<textarea class="form-control" name="radioly_remark"
											  data-valid="required" data-msg="Select Remark"
											  id="radioly_remark"></textarea>
								</div>
							</div>
							<div class="form-row">
								<div class="align-items-baseline col-md-2 d-flex flex-column form-group justify-content-end">
									<button class="btn btn-primary mr-1" type="submit">
										Save
									</button>
								</div>
							</div>

						</div>
					</div>

				</form>

			</div>
		</div>
	</div>
</div>
<!-- company modal  -->
<div class="modal fade" tabindex="-1" role="dialog" id="deleteSampleModel"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<ul class="list-group list-group-flush" id="sampleList">

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {

		getSampleCollectionTable1('RADIOLOGY', 'radiologySampleTable');

		getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable');
		get_zone();
		// $("#getRadiologyUploadModal").on('hide.bs.modal', function(){
		// 	$('.checkboxClose').prop('checked', false);
		// 	// $("input:checkbox").attr('checked', false);
		// });
		getAllOtherPatient();
		getAllOtherHistoryPatient();
		getAllOtherCategory();
		getAllOtherHistoryCategory();
	});

	function get_zone() {
		app.request(baseURL + "getZoneData", null).then(success => {
			if (success.status == 200) {
				var user_data = success.data;
				$("#sampleAllPatient").html(user_data);
				$("#rsampleAllPatient").html(user_data);
			}
		});
	}

	function getAllOtherPatient()
	{
		app.request(baseURL + "getOtherServicePatientData", null).then(success => {
			if (success.status == 200) {
				var user_data = success.data;
				$("#OtherServiceAllPatient").append(user_data);
				$("#OtherServiceAllPatient").select2();
			}
			else
			{
				var user_data = success.data;
				$("#OtherServiceAllPatient").append(user_data);
				$("#OtherServiceAllPatient").select2();
			}
		});
		
	}
	function getAllOtherHistoryPatient()
	{
		app.request(baseURL + "getOtherServiceHistoryPatientData", null).then(success => {
			if (success.status == 200) {
				var user_data = success.data;
				$("#OtherServiceAllHistoryPatient").append(user_data);
				$("#OtherServiceAllHistoryPatient").select2();
			}
			else
			{
				var user_data = success.data;
				$("#OtherServiceAllHistoryPatient").append(user_data);
				$("#OtherServiceAllHistoryPatient").select2();
			}
		});
		
	}
	function getAllOtherCategory()
	{
		app.request(baseURL + "getOtherServiceCategoryData", null).then(success => {
			if (success.status == 200) {
				var user_data = success.data;
				$("#OtherServiceAllCategory").append(user_data);
				$("#OtherServiceAllCategory").select2();
			}
			else
			{
				var user_data = success.data;
				$("#OtherServiceAllCategory").append(user_data);
				$("#OtherServiceAllCategory").select2();
			}
		});
		
	}
	function getAllOtherHistoryCategory()
	{
		app.request(baseURL + "getOtherServiceHistoryCategoryData", null).then(success => {
			if (success.status == 200) {
				var user_data = success.data;
				$("#OtherServiceAllHistoryCategory").append(user_data);
				$("#OtherServiceAllHistoryCategory").select2();
			}
			else
			{
				var user_data = success.data;
				$("#OtherServiceAllHistoryCategory").append(user_data);
				$("#OtherServiceAllHistoryCategory").select2();
			}
		});
		
	}

	function getSampleCollectionTable1(category, tableID, patient_id = null) {

		let formData = new FormData();
		// formData.set("category", category);
		let zone = $("#sampleAllPatient").val();
		if (zone !== null) {
			formData.set("zone_id", zone);
		}
		let patient = $("#OtherServiceAllPatient").val();
		let service_category = $("#OtherServiceAllCategory").val();
		formData.set("patient_id", patient);
		formData.set("category", service_category);
		let userTypeCheck = $("#userTypeCheck").val();

		app.request(baseURL + "getBillingTable1", formData).then(res => {

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
						data: 4
					},
					{
						data: 6,
						render: (d, t, r, m) => {
							if (parseInt(r[10]) === 1) {
								let value = 1;
								return `<input type="checkbox" checked id="sampleCollectionCheckbox1_${r[6]}"
 								onclick="getRadiologyUploadModal('${r[5]}',${r[10]},'${r[6]}')" class="checkboxClose">`;
							} else {
								let value = 0;
								return `<input type="checkbox"  id="sampleCollectionCheckbox1_${r[6]}"
			onclick="getRadiologyUploadModal('${r[5]}',${r[10]},'${r[6]}')" class="checkboxClose">`;
							}

						}
					},
					{
						data: 6,
						render: (d, t, r, m) => {

							if (userTypeCheck == 2) {
								return `<button type="button" class="btn btn-link"
		onclick="removeRadiologyServiceOrderItem('${r[5]}','${r[10]}')"  data-toggle="modal" data-target="#deleteSampleModel"><i class="fa fa-times"></i></button>`;
							} else {
								return ` `;
							}
						}
					},
					{
						data: 7
					},
					{
						data: 8
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
				onclick="getRadiologyUploadModal('${aData[5]}',${aData[10]},'${aData[6]}')" class="checkboxClose">`);
					} else {
						let value = 0;
						let status = '';
						$('td:eq(5)', nRow).html(`<input type="checkbox" ${status} id="sampleCollectionCheckbox1_${aData[6]}"
			onclick="getRadiologyUploadModal('${aData[5]}',${aData[10]},'${aData[6]}')" class="checkboxClose">`);
					}

					if (userTypeCheck == 2) {
						$('td:eq(6)', nRow).html(`<button type="button" class="btn btn-link"
onclick="removeRadiologyServiceOrderItem('${aData[5]}','${aData[10]}')"><i class="fa fa-times"></i></button>`);
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

	function getSampleCollectionTable2(category, tableID, patient_id = null) {

		let formData = new FormData();
		// formData.set("category", category);
		let zone = $("#rsampleAllPatient").val();
		if (zone !== null) {
			formData.set("zone_id", zone);
		}
		let patient = $("#OtherServiceAllHistoryPatient").val();
		let service_category = $("#OtherServiceAllHistoryCategory").val();
		formData.set("patient_id", patient);
		formData.set("category", service_category);

		let userTypeCheck = $("#userTypeCheck").val();

		app.request(baseURL + "getBillingHistoryTable1", formData).then(res => {

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
						data: 4
					},
					{
						data: 11,
						render: (d, t, r, m) => {

							if (r[11] != "") {
								return `<button class="btn btn-link" onclick="radiologyDownloadButtons('${r[11]}')"><i class="fa fa-download"></i></button>`;
							} else {
								return ` `;
							}
						}
					},
					{
						data: 12
					},
					{
						data: 13
					},
					{
						data: 7
					},
					{
						data: 8
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
					if (aData[11] != "") {
					$('td:eq(5)', nRow).html(`<button class="btn btn-link" onclick="radiologyDownloadButtons('${aData[11]}')"><i class="fa fa-download"></i></button>`);
						} else {
							$('td:eq(5)', nRow).html(`-`);
						}

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
	function getRadiologyUploadModal(billing_id, patient_id, Id) {
		if ($("#sampleCollectionCheckbox1_" + Id).prop('checked') == true) {
			$("#openRadiologyUploadButton").click();

			$("#radioServiceIds").val(Id);
			$("#serviceBillingIds").val(billing_id);
			// console.log(serviceIDS);
			$("#radioPatientId").val(patient_id);
		} else {
			var formData = new FormData();
			formData.append('radioServiceIds', Id);
			formData.append('serviceBillingIds', billing_id);
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
		// service_file: {
		// 	required: true,
		// },
		// normal_status: {
		// 	required: true,
		// },

	},
	messages: {
		// service_file: {
		// 	required: "Please Select File"
		// },
		// normal_status: {
		// 	required: "Please Select Status"
		// },

	},
	errorElement: 'span',
	submitHandler: function (form) {
		var file = document.getElementById("service_file");
		// if (file.files.length == 0) {
		// 	$("#radiology_diles_error").html("Please Select File");
		// 	// app.errorToast("No files selected");
		// } else {
			var formData = new FormData(form);
			formData.append('confirm_service_given', '1');
			formData.append('sample_pickup', '1');
			uploadRadiologyUplodForm(formData, 1);
		// }

	}
});

function uploadRadiologyUplodForm(data, btnCheck) {
	app.request(baseURL + "uploadRadioUplodation1", data).then(res => {
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
function removeRadiologyServiceOrderItem(labcode, patient_id) {
	let confirmAction = confirm("Are you sure to you want confirm service");
	if (confirmAction) {
		serverRequest("deleteServiceOrder1", {service_order_id: labcode, patient_id: patient_id}).then(response => {
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

function getOtherServicesReport()
{
		var loginFormObject = {};
		// formData.set("category", category);
		
		let patient = $("#OtherServiceAllPatient").val();
		let service_category = $("#OtherServiceAllCategory").val();
		loginFormObject["patient_id"]=patient;
		loginFormObject["category"]=service_category;
		// formData.set("patient_id", patient);
		// formData.set("category", service_category);
	const x=JSON.stringify(loginFormObject);
	window.location.href= baseURL+"getOtherServiceReport?data=" + x;
}
function getOtherServicesHistoryReport()
{
		var loginFormObject = {};
		// formData.set("category", category);
		
		let patient = $("#OtherServiceAllHistoryPatient").val();
		let service_category = $("#OtherServiceAllHistoryCategory").val();
		loginFormObject["patient_id"]=patient;
		loginFormObject["category"]=service_category;
		// formData.set("patient_id", patient);
		// formData.set("category", service_category);
	const x=JSON.stringify(loginFormObject);
	window.location.href= baseURL+"getOtherServicesHistoryReport?data=" + x;
}
</script>
