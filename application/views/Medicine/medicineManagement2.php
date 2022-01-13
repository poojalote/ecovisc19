<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	div.medicine {
			white-space: nowrap;
		width: 100px;

		overflow: hidden;
		text-overflow: ellipsis;
	}
	div.medicine:hover {
		overflow: visible;
		white-space: normal;

	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Medicine Detail</h1>
		</div>
		<div class="section-body">
			<div class="card">
				<div class="" style="padding:5px;">

					<div class="card-header-action">
						<ul class="nav nav-pills" id="medicineTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#scheduleMedicine"
								   role="tab" onclick="show_div('att_medicine')"
								   aria-controls="scheduleMedicine" aria-selected="true">Schedule Medicine </a>
							</li>
							<!--							<li class="nav-item">-->
							<!--								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#addMedicine" role="tab" onclick="show_div('add_medicine')"-->
							<!--								   aria-controls="addMedicine" aria-selected="false">Add Medicine</a>-->
							<!--							</li>-->

							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#schedulePrescription"
								   role="tab"
								   aria-controls="schedulePrescription" aria-selected="false">Schedule Prescription</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="history-tab" data-toggle="tab" href="#medicine_history_tab"
								   role="tab"
								   aria-controls="addPrescription" onclick="load_medicine_history()"aria-selected="false">Medicine History</a>

							</li>
							<li class="nav-item">
								<a class="nav-link" id="return-medicine-tab" onclick="getreturnMedicineTable()" data-toggle="tab" href="#returnMedicine"
								   role="tab"
								   aria-controls="returnMedicine" aria-selected="false">Return Medicine</a>

							</li>
						</ul>
					</div>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" role="tabpanel" id="scheduleMedicine">
							<div class="col-md-12">
								<div class="d-flex flex-row-reverse mb-3">
									<a class="btn btn-link" style="color: #891635!important;" data-toggle="collapse"
									   href="#newSchedulePanel"
									   role="button"
									   aria-expanded="true" aria-controls="collapseExample">
										<i class="fa fa-plus"></i> New Schedule Medicine
									</a>
								</div>
								<div class="collapse " id="newSchedulePanel">
									<div class="row">
										<div class="col-sm-12">
											<form id="att_medi_form" name="att_medi_form" onsubmit="return false">
												<div id="att_medicine" class="p-3">
													<div class="form-row">
														<input type="hidden" id="patient_list" name="patient_list">
														<div class="form-group col-md-3">
															<label>Group Name</label>
															<select name="group_name" id="group_name_medicine_schedule"
																	style="width: 100%"
																	onchange="loadMedicineOptions1();"
																	class="form-control">
																<option>Select Group</option>
															</select>
														</div>
														<div class="form-group col-md-3">
															<label>Medicine Name</label>
															<select class="form-control " id="medicine_list"
																	style="width: 100%"
																	name="medicine_list">
																<option value="" selected="" disabled="">Select Medicine
																</option>
															</select>
														</div>
														<div class="form-group col-md-3">
															<label>Per Day Schedule</label>
															<select data-value="2" class="form-control"
																	name="Per_Day_Schedule_new"
																	id="Per_Day_Schedule_new" aria-required="true">
																<option disabled="" selected="">Select Per Day Schedule
																</option>
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
															</select>
														</div>

													</div>
													<div class="form-row">
														<div class="form-group col-md-3">
															<label>Start Date</label>
															<input type="date" class="form-control"
																   name="Start_Date_new"
																   id="Start_Date_new" placeholder="Enter Start Date"
																   value=""
																   aria-required="true">
														</div>
														<div class="form-group col-md-3" id="end_date_div">
															<label>End Date</label>
															<input type="date" class="form-control" name="End_Date_new"
																   id="End_Date_new" placeholder="Enter End Date"
																   value=""
																   aria-required="true">

														</div>
														<div class="form-group col-md-2">
															<label>Is End Date Recurring</label><br>
															<input type="checkbox" id="chk" name="chk"
																   onchange="hide_date()">
														</div>
														<div class="form-group col-md-4">
															<label>Remark</label>
															<input type="text" class="form-control" name="Remark_new"
																   id="Remark_new" placeholder="Enter Remark"
																   aria-required="true">
														</div>
													</div>
													<div class="d-flex flex-row-reverse">
														<button class="btn btn-primary mr-1" type="submit">Add</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div id="schedule_table">
										<div id="currentDoesTableBox"></div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="d-flex flex-row-reverse mb-3">
									<a class="btn btn-primary" data-toggle="collapse" href="#historySchedulePanel"
									   role="button"
									   aria-expanded="true" aria-controls="collapseExample">
										History
									</a>
								</div>
								<div class="collapse " id="historySchedulePanel">
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
												   cellspacing="0">
												<thead>
												<tr>
													<td>Name</td>
													<td>Date</td>
													<td>1st</td>
													<td>2nd</td>
													<td>3rd</td>
													<td>4th</td>
													<td>5th</td>
												</tr>
												</thead>
												<tbody id="doesHistoryTable1">

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane fade " role="tabpanel" id="schedulePrescription">
							<div class="col-sm-12">
								<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
									   id="schedulePrescriptionTable"
									   style="width: 100%"
									   cellspacing="0">
									<thead>
									<tr>
										<td>Prescription</td>
										<td>Doctor Name</td>
										<td>Objective</td>
										<td>Medicine Name</td>
										<td>Action</td>
									</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>


						<div class="tab-pane fade" role="tabpanel" id="medicine_history_tab">
							<div class="col-sm-12">
								<section id="history_table_section">

								</section>
							</div>

						</div>

						<div class="tab-pane fade" role="tabpanel" id="returnMedicine">
							<form id="returnMedicineForm" method="post" onsubmit="return false">
								<div class="col-sm-12">
									<div class="d-flex flex-row-reverse mb-3">
										<button class="btn btn-primary mr-1" type="button"
												onclick="returnScheduleMedicine()">
											Save
										</button>
									</div>
								</div>
								<div class="col-sm-12">
									<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
										   id="returnMedicineTable"
										   style="width: 100%"
										   cellspacing="0">
										<thead>
										<tr>
											<td></td>
											<td>Medicine</td>
											<td>Return Quantity</td>

										</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</form>
						</div>


					</div>

				</div>
			</div>
	</section>
</div>

<div class="modal fade" id="rescheduleMedicine" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Reschedule Medicine</h4>
				<button type="button" class="close" id="closeedit" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editRescheduleForm" class="form-horizontal" method="POST" data-form-valid="rescheduleMedicine"
				>
					<input type="hidden" id="reschedule_medicine_id" name="reschedule_medicine_id">
					<input type="hidden" id="reschedule_date" name="reschedule_date">
					<input type="hidden" id="reschedule_patient" name="patient_id">

					<div class="form-group">
						<strong>Per Day Schedule</strong>
						<select name="schedule_day" type="number" id="per_day_schedule" class="form-control"
							  
								data-valid="required" data-msg="Enter Per Day Schedule"></select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">save</button>
			</div>
			</form>
		</div>

	</div>
</div>
</div>
<!--edit form-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closeedit" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
				<form id="editForm_new" class="form-horizontal" method="POST" data-form-valid="deleteMedicine"
					  onsubmit="return false">
					<input type="hidden" id="e_medicine_id" name="id">
					<input type="hidden" id="e_p_id" name="e_p_id">
					<input type="hidden" id="e_d_date" name="e_d_date">

					<div class="form-group">
						<strong>Delete Reason</strong>
						<textarea name="deleteReason" id="reason" class="form-control" maxlength="255"
								  data-valid="required" data-msg="Enter reason"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">save</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<!--prescription modal -->
<div class="modal fade" id="scheduleMedicineModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Prescription Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="schedulePrescriptionForm" method="post">
					<div class="row">
						<div class="col-md-12">

							<input type="hidden" name="pName" id="schedulePrescriptionName">
							<input type="hidden" name="patient_id" id="schedulePrescriptionForPatient">
							<div class="form-row">
								<div class="form-group col-md-5">
									<label for="start_date_schedule_prescription">Start Date</label>
									<input type="date" class="form-control" name="start_date"
										   data-valid="required" data-msg="Select Start date"
										   id="start_date_schedule_prescription">
								</div>

								<div class="align-items-baseline col-md-2 d-flex flex-column form-group justify-content-end">
									<button class="btn btn-primary mr-1" type="button" onclick="schedulePrescription()">
										Schedule
									</button>
								</div>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
								   cellspacing="0" id="prescriptionMedicineTable">
								<thead>
								<tr>
									<td></td>
									<td>Medicine</td>
									<td>Per Day Schedule</td>
									<td>No of Days</td>
									<td>Remark</td>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
	$(document).ready(function () {

		var patient_id = localStorage.getItem("patient_id");

		loadMedicineOptions();
		loadSubClassification("group_name_medicine", 0);
		load_medicine_history();
		getDoesDetails(patient_id);
		getreturnMedicineTable(patient_id);
		getMedicineGroup();
		getPrescriptionTable('schedulePrescriptionTable');

		$('#medicine_list').select2();

		$("#patient_list").val(patient_id);
		$('#rescheduleMedicine').on('show.bs.modal', function (e) {
			let medicine_id = $(e.relatedTarget).data('medicine_id');
			let reschedule_date = $(e.relatedTarget).data('reschedule_date');
			let alreadyGivenDoesCount = parseInt($(e.relatedTarget).data('alreadygivendoescount'));
			var input = document.getElementById("per_day_schedule");

			let options=``;
			for(let i =1;i<=5;i++){
				let disable = `disabled`;
				if(alreadyGivenDoesCount>=i){
					options+=`<option ${disable} value="${i}">${i}</option>`
				}else{
					options+=`<option value="${i}">${i}</option>`
				}
			}
			$("#per_day_schedule").empty();
			$("#per_day_schedule").append(options);
			//per_day_schedule
			//$("#per_day_schedule").attr({"min" : alreadyGivenDoesCount});

			app.formValidation();
			$("#reschedule_medicine_id").val(medicine_id);
			$("#reschedule_date").val(reschedule_date);
			$("#reschedule_patient").val(patient_id);

		});
		$('#scheduleMedicineModal').on('hide.bs.modal', function (e) {
			$("#editRescheduleForm").trigger('reset');
		});

		$('#scheduleMedicineModal').on('show.bs.modal', function (e) {

			let name = $(e.relatedTarget).data('name');
			let pid = localStorage.getItem("patient_id");
			if (pid != null && pid !== "") {
				$('#schedulePrescriptionName').val(name);
				$('#schedulePrescriptionForPatient').val(pid);
				prescriptionMedicineTable(name);
			} else {
				app.errorToast("Select Patient. Try again");
			}
		});

		$('#edit_modal').on('show.bs.modal', function (e) {
			let id = $(e.relatedTarget).data('id');
			let pid = $(e.relatedTarget).data('pid');
			let d_date = $(e.relatedTarget).data('date');
			$('#e_medicine_id').val(id);
			$('#e_p_id').val(pid);
			$('#e_d_date').val(d_date);

		});
		onclick = 'deleteMedicine(" . $doesObject->id . ",".$p_id.");'


		var dt = new Date();
		var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
		var month = dt.getMonth() + 1;
		var day = dt.getDate();

		var output = dt.getFullYear() + '-' +
				(month < 10 ? '0' : '') + month + '-' +
				(day < 10 ? '0' : '') + day;
		var date = output;
		document.getElementById("Start_Date_new").min = date;
		document.getElementById("End_Date_new").min = date;
		document.getElementById("start_date_schedule_prescription").min = date;


	});

	function rescheduleMedicine(form) {
		app.request(baseURL + "saveRescheduleMedicine", new FormData(form)).then(res => {
			if (res.status === 200) {
				app.successToast(res.body);
				$("#editRescheduleForm").trigger('reset');
				$("#rescheduleMedicine").modal("hide");
				load_medicine_history();
				let patient_id = localStorage.getItem("patient_id");
				getDoesDetails(patient_id);
			} else {
				app.errorToast(res.body);
			}
		}).catch(error => console.log(error));
	}

	//Start_Date_new
</script>
