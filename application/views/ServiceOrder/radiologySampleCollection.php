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
	.accordion .accordion-header[aria-expanded="true"]{
		box-shadow: 0 2px 6px #891635!important;
		background-color: #891635!important;
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
		<div class="section-header card-primary">
			<h1 style="color: #891635">Radiology Sample Collection</h1>
			<input type="hidden" id="userTypeCheck" value="<?php echo $role; ?>" />
				<div class="card-header-action" style="margin-left: auto;">
						<ul class="nav nav-pills" id="radiologyTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="radiologyCollectionTab" data-toggle="tab" href="#radiologyCollectionPanel"
								   role="tab" 
								   aria-controls="radiologyCollectionPanel" aria-selected="true">Radiology Collection</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="radiologyHistoryTab" data-toggle="tab" href="#radiologyHistoryPanel"
								   role="tab" onclick="getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable')" 
								   aria-controls="radiologyHistoryPanel" aria-selected="false">Radiology History</a>
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

											<div class="col-md-4 form-group">
												<select class="form-control" id='sampleAllPatient'
														onchange="getSampleCollectionTable1('RADIOLOGY','radiologySampleTable',this.value)" style="width: 100%;border-radius: 20px;">
												</select>
											</div>
											<div class="col-md-2 form-group" style="margin-left: auto;">
												<button name="radiologyExcelNotConfirm" id="radiologyExcelNotConfirm" class="btn btn-primary" onclick="getNotConfirmReport(0,'RADIOLOGY')"><i class="fa fa-download"></i> Download Report</button>
											</div>

										</div>
									<button id="openRadiologyUploadButton" data-toggle="modal"
															data-target="#getRadiologyUploadModal"  type="button" class="d-none" >open</button>
									<!-- <div class="table-responsive"> -->
									<table class="table table-bordered table-stripped" id="radiologySampleTable" role="grid" style="width: 100%">
										<thead>
											<tr>
											<th data-priority="1">Bed No.</th>
											<!-- <th>Patient ID</th> -->
											<th data-priority="2">Patient Name</th>
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
												<th data-priority="1">Bed No.</th>
												
												<th data-priority="2">Patient Name</th>
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
									<!-- </div> -->

									</div>
								</div>
								<div class="tab-pane fade" role="tabpanel" id="radiologyHistoryPanel">
									<div class="">
										<div class="card-header-action d-flex">

											<div class="col-md-4 form-group">
												<select class="form-control" id='rsampleAllPatient'
														onchange="getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable',this.value)" style="width: 100%;border-radius: 20px;">
												</select>
											</div>

											<div class="col-md-2 form-group" style="margin-left: auto;">
												<button name="radiologyExcelNotConfirm" id="radiologyExcelNotConfirm" class="btn btn-primary" onclick="getNotConfirmReport(1,'RADIOLOGY')"><i class="fa fa-download"></i> Download Report</button>
											</div>

										</div>
									
									<!-- <div class="table-responsive"> -->
									<table class="table table-bordered table-stripped" id="radiologySampleHistoryTable" role="grid" style="width: 100%!important">
										<thead>
											<tr>
											<th data-priority="1">Bed No.</th>
											<th data-priority="2">Patient Name</th>
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
												<th data-priority="1">Bed No.</th>
												
												<th data-priority="2">Patient Name</th>
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
									<!-- </div> -->

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
				<h4>Radiology Samples</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form id="radioFileUploadationForm" method="post" onsubmit="return false">
				<div class="row">
					<div class="col-md-12">
						
							<input type="hidden" name="radioServiceIds" id="radioServiceIds">
							<input type="hidden" name="patient_id" id="radioPatientId">
							<div class="form-row">
								<div class="form-group col-md-12">
									<label for="service_file">File Upload</label>
									<input type="file" class="form-control" name="service_file[]" multiple data-valid="required" data-msg="Select file"
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
						<ul class="list-group list-group-flush"  id="sampleList">

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('Billing/billing'); ?>


<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		// document.getElementById("patient_nameSidebar").innerText=localStorage.getItem("patient_name");
		// document.getElementById("patient_adharSidebar").innerText= localStorage.getItem("patient_adharnumber");
		// var patient_id=localStorage.getItem("patient_id");
		// $("#billing_patient_id").val(patient_id);
		// $("#patient_list").val(patient_id);
		// $("#p_id").val(patient_id);
		// $("#serviceOrder_patient_adhar").val(localStorage.getItem("patient_adharnumber"));
		// $("#serviceOrder_patient_id").val(localStorage.getItem("patient_id"));
		// $("#serviceOrder_patient_name").val(localStorage.getItem("patient_name"));
		getSampleCollectionTable1('RADIOLOGY','radiologySampleTable');
		getSampleCollectionTable2('RADIOLOGY','radiologySampleHistoryTable');
		// getAllPatients('RADIOLOGY');
		get_zone();
		 $("#getRadiologyUploadModal").on('hide.bs.modal', function(){
	         $('.checkboxClose').prop('checked', false);
	          // $("input:checkbox").attr('checked', false);
	  	});
	});

	// var checkList = document.getElementById('list1');
	// checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
	// 	if (checkList.classList.contains('visible'))
	// 		checkList.classList.remove('visible');
	// 	else
	// 		checkList.classList.add('visible');
	// }

</script>
