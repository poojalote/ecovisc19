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

	.color_in {
		color: green;
		font-weight: bold;
	}

	.color_out {
		color: red;
		font-weight: bold;
	}
	.comment_pointer
	{
		cursor: pointer;
	}
	.text_bottom
	{
		border-bottom: 1px solid gray;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Medication</h1>
		</div>
		<div class="section-body">
			<div class="card">
				<div class="" style="padding:5px;">

					<div class="card-header-action">
						<ul class="nav nav-pills" id="medicineTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="#scheduleMedicine"
								   role="tab" onclick="show_div('att_medicine')"
								   aria-controls="scheduleMedicine" aria-selected="true">Medicine Schedules</a>
							</li>
							<!--							<li class="nav-item">-->
							<!--								<a class="nav-link" id="profile-tab" data-toggle="tab" href="#addMedicine" role="tab" onclick="show_div('add_medicine')"-->
							<!--								   aria-controls="addMedicine" aria-selected="false">Add Medicine</a>-->
							<!--							</li>-->

							<li class="nav-item">
								<a class="nav-link" id="contact-tab" data-toggle="tab" href="#schedulePrescription"
								   role="tab"
								   aria-controls="schedulePrescription" aria-selected="false">Schedule from Kits</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="history-tab" data-toggle="tab" href="#medicine_history_tab"
								   role="tab"
								   aria-controls="addPrescription" onclick="load_medicine_history()"
								   aria-selected="false">Daywise Medication</a>

							</li>
							<li class="nav-item">
								<a class="nav-link" id="return-medicine-tab" onclick="getreturnMedicineTable()"
								   data-toggle="tab" href="#returnMedicine"
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
										<i class="fa fa-plus"></i> Schedule New Medicine
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
																   aria-required="true" onchange="getValidDate()">
														</div>
														<div class="form-group col-md-3" id="end_date_div">
															<label>End Date</label>
															<input type="date" class="form-control" name="End_Date_new"
																   id="End_Date_new" placeholder="Enter End Date"
																   value=""
																   aria-required="true" onchange="getValidDate()">

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

													<div class="form-row">
														<div class="form-group col-md-3">
															<label>Route</label>
															<select data-value="2" class="form-control" name="ms_route"
																	id="ms_route" aria-required="true">
																<option disabled="" selected="">Select Route
																</option>
																<option value="PO/NG">PO/ NG</option>
																<option value="IV">IV</option>
																<option value="IM">IM</option>
																<option value="SC">SC</option>
																<option value="PR">PR</option>
																<option value="LA">LA</option>
															</select>
														</div>
														<div class="form-group col-md-3">
															<label>Dose</label>
															<select data-value="2" class="form-control"
																	name="ms_quantity" id="ms_quantity"
																	aria-required="true">
																<option disabled="" selected="">Select Dose
																</option>
																<option value="0.25">0.25</option>
																<option value="0.5">0.5</option>
																<?php for ($i = 1; $i <= 10; $i++) { ?>
																	<option value="<?php echo $i; ?>">
																		<?php echo $i; ?>
																	</option>
																<?php } ?>

															</select>
														</div>
														<div class="form-group col-md-2">
															<label>Flow Rate</label><br>
															<input type="checkbox" id="flowratechk" name="flowratechk"
																   onchange="get_flowrate_text()">
														</div>
														<div class="form-group col-md-4" id="flowRateTextDiv">
															<label></label>
															<input type="text" class="form-control" name="flowRate_new"
																   id="flowRate_new" placeholder="Enter Flow rate"
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
										Complete Medication
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

<!--medicine extend modal-->
<div class="modal fade" id="extendModel" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Extend Medicine</h4>
				<button type="button" class="close" id="closeExtend" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="extendScheduleForm" class="form-horizontal" method="POST"
					  data-form-valid="extendScheduleMedicine">
					<input type="hidden" id="extend_schedule_medicine_id" name="extend_schedule_medicine_id">
					<input type="hidden" id="extend_patient_id" name="extend_patient_id">
					<input type="hidden" id="extend_start_date" name="extend_start_date">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label id="extend_medicine_name"></label>
						</div>
						<div class="form-group col-md-6">
							<label>Last Schedule end date</label>
							<label id="extend_medicine_end_date"></label>
						</div>
					</div>

					<div class="form-group">
						<label>Per Day Schedule</label>
						<select name="extend_schedule_day" type="number" id="extend_per_day_schedule"
								class="form-control"
								data-valid="required" data-msg="Enter Per Day Schedule">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</div>
					<div class="form-group">
						<label>Extend to</label>
						<input type="date" name="extend_date" class="form-control" id="extend_date"
							   data-valid="required" data-msg="Enter date"
						/>
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
<!--delete form-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closeedit1" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
				<form id="editForm_new" class="form-horizontal" method="POST" data-form-valid="deleteMedicine"
					  onsubmit="return false">
					<input type="hidden" id="e_medicine_id" name="id">
					<input type="hidden" id="e_p_id" name="e_p_id">

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
<!--edit form-->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closeUpdate" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="updateMedicineForm" class="form-horizontal" method="POST"
					  data-form-valid="updateMedicineForm">
					<input type="hidden" id="u_medicine_id" name="u_medicine_id">
					<input type="hidden" id="u_p_id" name="u_p_id">
					<div class="form-group">
						<strong>Remark</strong>
						<textarea name="u_remark" id="u_remark" class="form-control" maxlength="255"></textarea>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Route</label>
							<select data-value="2" class="form-control" name="u_route" id="u_route">
								<option disabled="" selected="">Select Route
								</option>
								<option value="PO/NG">PO/ NG</option>
								<option value="IV">IV</option>
								<option value="IM">IM</option>
								<option value="SC">SC</option>
								<option value="PR">PR</option>
								<option value="LA">LA</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Dose</label>
							<select data-value="2" class="form-control" name="u_quantity" id="u_quantity">
								<option disabled="" selected="">Select Dose
								</option>
								<option value="0.25">0.25</option>
								<option value="0.5">0.5</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2">
							<label>Flow Rate</label>
							<input type="checkbox" name="u_flow_rate_check" id="flow_rate_check"
								   onchange="$('#update_flow_rate').toggleClass('d-none')"/>
						</div>
						<div class="form-group col-md-10 d-none" id="update_flow_rate">
							<label>Flow Rate</label>
							<input type="text" name="u_flow_rate_update" id="flow_rate_update" class="form-control"/>
						</div>
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
								   cellspacing="0" id="prescriptionMedicineTable" style="width: 100%;">
								<thead>
								<tr>
									<td></td>
									<td>Medicine</td>
									<td>Per Day Schedule</td>
									<td>No of Days</td>
									<td>Remark</td>
									<td>Route</td>
									<td>Quantity</td>
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

<button type="button" class="btn btn-primary d-none" id="commentMedicineModalBtn" data-toggle="modal" data-target="#commentMedicineModal">Open Modal</button>
<!--Medicine Comment modal -->
<div class="modal fade" id="commentMedicineModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Comment</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="medicineCommentForm" method="post">
					<input type="hidden" name="m_patient_id" id="m_patient_id">
					<input type="hidden" name="c_medicine_id" id="c_medicine_id">
					<input type="hidden" name="m_iteration_id" id="m_iteration_id">
					<input type="hidden" name="m_dose_date" id="m_dose_date">

					<div class="form-row">
						<textarea class="form-control" type="text" name="medicine_comment" id="medicine_comment"></textarea>
					</div>
					<div class="align-items-baseline form-row justify-content-end mt-2">
									<button class="btn btn-primary mr-1" type="button" onclick="addMecidineCommentData()">
										Save
									</button>
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
		
		getDoesDetails(patient_id);
		getreturnMedicineTable(patient_id);
		getMedicineGroup();
		getPrescriptionTable('schedulePrescriptionTable');
		load_medicine_history();
		$('#medicine_list').select2();

		$("#patient_list").val(patient_id);

		$('#update_modal').on('show.bs.modal', function (e) {
			let medicine_id = $(e.relatedTarget).data('id');
			let patient_id = $(e.relatedTarget).data('pid');

			let flow_rate = parseInt(atob($(e.relatedTarget).data('flow_rate')));
			let flow_text = atob($(e.relatedTarget).data('flow_text'));
			let remark = atob($(e.relatedTarget).data('remark'));
			let route = atob($(e.relatedTarget).data('route'));
			let quantity = atob($(e.relatedTarget).data('quantity'));

			app.formValidation();
			$("#u_medicine_id").val(medicine_id);
			$("#u_p_id").val(patient_id);
			if (flow_rate === 1) {
				$("#flow_rate_check").click();
				$("#update_flow_rate").removeClass('d-none')
			}

			$("#flow_rate_update").val(flow_text);
			$("#u_remark").val(remark);
			$("#u_route").val(route);
			$("#u_quantity").val(quantity);

		});

		$('#extendModel').on('show.bs.modal', function (e) {
			let medicine_id = $(e.relatedTarget).data('id');
			let medicine_name = $(e.relatedTarget).data('name');
			let medicine_date = $(e.relatedTarget).data('date');
			let original_date = $(e.relatedTarget).data('original_date');

			document.getElementById('extend_date').min = medicine_date;
			app.formValidation();
			$("#extend_start_date").val(medicine_date);
			$("#extend_patient_id").val(patient_id);
			$("#extend_medicine_end_date").empty();
			$("#extend_medicine_end_date").append(original_date);
			$("#extend_schedule_medicine_id").val(medicine_id);
			$("#extend_medicine_name").empty();
			$("#extend_medicine_name").append(medicine_name);

		});

		$('#rescheduleMedicine').on('show.bs.modal', function (e) {
			let medicine_id = $(e.relatedTarget).data('medicine_id');
			let reschedule_date = $(e.relatedTarget).data('reschedule_date');
			let alreadyGivenDoesCount = parseInt($(e.relatedTarget).data('alreadygivendoescount'));
			var input = document.getElementById("per_day_schedule");

			let options = ``;

			for (let i = 0; i <= 5; i++) {
				let disable = `disabled`;

				if (alreadyGivenDoesCount >= i && alreadyGivenDoesCount != 0) {
					options += `<option ${disable} value="${i}">${i}</option>`
				} else {

					options += `<option value="${i}">${i}</option>`
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
				prescriptionMedicineTable(name, pid);
			} else {
				app.errorToast("Select Patient. Try again");
			}
		});

		$('#edit_modal').on('show.bs.modal', function (e) {
			let id = $(e.relatedTarget).data('id');
			let pid = $(e.relatedTarget).data('pid');
			$('#e_medicine_id').val(id);
			$('#e_p_id').val(pid);

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

		var sdt = new Date();
		 sdt.setDate(sdt.getDate() + 30);
		 var ptime = sdt.getHours() + ":" + sdt.getMinutes() + ":" + sdt.getSeconds();
		 var pmonth = sdt.getMonth() + 1;
		var pday = sdt.getDate();
		var poutput = sdt.getFullYear() + '-' +
				(pmonth < 10 ? '0' : '') + pmonth + '-' +
				(pday < 10 ? '0' : '') + pday;
		var pdate1 = poutput;
		document.getElementById('start_date_schedule_prescription').max = pdate1;
	});
	function getValidDate()
	{
		 var from = $("#Start_Date_new").val();
		 var to = $("#End_Date_new").val();
		 var date = new Date(from);
    	 var newdate = new Date(date);
    	  newdate.setDate(newdate.getDate() + 30);
    	 
		var time = newdate.getHours() + ":" + newdate.getMinutes() + ":" + newdate.getSeconds();
		var month = newdate.getMonth() + 1;
		var day = newdate.getDate();

		var output = newdate.getFullYear() + '-' +
				(month < 10 ? '0' : '') + month + '-' +
				(day < 10 ? '0' : '') + day;
		var date1 = output;
   			 document.getElementById('End_Date_new').max = date1;
		 // console.log(date1);
		 // document.getElementById("End_Date_new").max = ndate;
	}
	function extendScheduleMedicine(form) {
		app.request(baseURL + "saveExtendScheduleMedicine", new FormData(form)).then(res => {
			if (res.status === 200) {
				app.successToast(res.body);
				$("#extendScheduleForm").trigger('reset');
				$("#closeExtend").click();
				load_medicine_history();
				let patient_id = localStorage.getItem("patient_id");
				getDoesDetails(patient_id);
			} else {
				app.errorToast(res.body);
			}
		}).catch(error => console.log(error));
	}

	function updateMedicineForm(form) {
		app.request(baseURL + "saveMedicineUpdate", new FormData(form)).then(res => {
			if (res.status === 200) {
				app.successToast(res.body);
				$("#updateMedicineForm").trigger('reset');
				$("#closeUpdate").click();
				load_medicine_history();
				let patient_id = localStorage.getItem("patient_id");
				getDoesDetails(patient_id);
			} else {
				app.errorToast(res.body);
			}
		}).catch(error => console.log(error));
	}

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
