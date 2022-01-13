<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Prescription Master</h1>
		</div>
		<div class="section-body">
			<div class="card">
				<div class="card-body">

					<div class="col-md-12">
						<div class="d-flex flex-row-reverse mb-3">
							<a class="btn btn-primary" data-toggle="collapse" id="newPrescriptionButton"
							   href="#newPrescriptionPanel"
							   role="button"
							   aria-expanded="true" aria-controls="collapseExample">
								New Prescription
							</a>
						</div>
						<div class="collapse " id="newPrescriptionPanel">
							<div class="row">
								<div class="col-sm-12">
									<form id="prescriptionForm" name="prescriptionForm">
										<div id="prescriptionSection" class="p-3">

											<div class="form-row">
												<div class="form-group col-md-3">
													<label>Prescription Name</label>
													<input type="text" class="form-control "
														   id="prescription_list_name"
														   name="prescription_list_name"
														   data-valid="required" data-msg="Enter Prescription name"
													/>
												</div>
												<div class="form-group col-md-3">
													<label>Objective</label>
													<input type="text" class="form-control "
														   id="prescription_objective"
														   name="prescription_objective"
														   data-valid="required" data-msg="Enter Prescription name"
														   placeholder="Objective"
													/>
												</div>
												<div class="form-group col-md-3">
													<label>Doctor Name</label>
													<select name="doctor_name" id="doctor_name_medicine_prescription"
															data-valid="required" data-msg="Enter Doctor name"
															style="width: 100%"
															class="form-control">
														<option>Select Doctor Name</option>
													</select>
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label>Group Name</label>
													<select name="group_name" id="group_name_medicine_prescription"
															data-valid="required" data-msg="Enter Group name"
															style="width: 100%"
															class="form-control">
														<option>Select Group</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label>Medicine Name</label>
													<select class="form-control "
															id="prescription_medicine_list"
															style="width: 100%"
															name="prescription_medicine_list">
														<option value="" selected="" disabled="">Select Medicine
														</option>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label>Per Day Schedule</label>
													<select data-value="2" class="form-control"
															name="prescription_per_day_schedule"
															id="prescription_per_day_schedule"
															data-valid="required" data-msg="Select Per Day Schedule"
															aria-required="true">
														<option disabled="" selected="">Select Per Day Schedule
														</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
													</select>
												</div>

												<div class="form-group col-md-3">
													<label>No's of Day</label>
													<input type="number" name="medicie_no_days"
														   id="medicine_no_days"
														   min="1"
														   data-valid="required" data-msg="Select No's of Day"
														   class="form-control">
												</div>
											</div>
											<div class="form-row">
											<div class="form-group col-md-3">
															<label>Route</label>
															<select data-value="2" class="form-control" name="ms_route" id="ms_route" aria-required="true">
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
															<label>Quantity</label>
															<select data-value="2" class="form-control" name="ms_quantity" id="ms_quantity" aria-required="true">
																<option disabled="" selected="">Select Quantity
																</option>
																<option value="0.25">0.25</option>
																<option value="0.5">0.5</option>
																<?php for($i=1;$i<=10;$i++){ ?>
																<option value="<?php echo $i;?>">
																	<?php echo $i;?>
																</option>
																<?php }?>
																
															</select>
															</div>
												<div class="form-group col-md-6">
													<label>Remark</label>
													<textarea class="form-control" name="prescription_remark"
															  id="prescription_remark"
															  placeholder="Enter Remark"
													></textarea>
												</div>
											</div>
											<div class="d-flex flex-row-reverse">
												<button class="btn btn-primary mr-1" type="button"
														onclick="addPrescriptionItem()">Add
												</button>
												<button class="btn btn-primary mr-1" type="button"
														onclick="savePrescription()">Save
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
										   cellspacing="0">
										<thead>
										<tr>
											<td>Medicine</td>
											<td>Per Day Schedule</td>
											<td>No's Day</td>
											<td>Remark</td>
										</tr>
										</thead>
										<tbody id="prescriptionItemMasterTable">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
								   id="prescriptionMasterTable"
								   style="width: 100%"
								   cellspacing="0">
								<thead>
								<tr>
									<td>Prescription</td>
									<td>Doctor Name</td>
									<td>Objective</td>
									<td>Medicines</td>
									<td>Action</td>
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
<div class="modal fade " id="edit_prescription" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Prescription edit</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div id="med_data_div"></div>

			</div>
		</div>
	</div>
</div>


<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
	let prescriptionArray = [];
	$(document).ready(function () {

		loadDoctors();
		loadMedicineOptions();

		loadClassification();
		loadSubClassification("group_name_medicine_prescription", 1);

		//getMedicineGroup1();
		getPrescriptionTable('prescriptionMasterTable')

	});

</script>
