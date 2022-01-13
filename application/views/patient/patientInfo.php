<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
	$user_type = $session_data->user_type;
	$role = $session_data->roles;
?>
<style>
	.dataTables_filter {
		display: flex !important;
		justify-content: flex-end !important;
	}

	.dataTables_paginate {
		display: flex !important;
		justify-content: flex-end !important;
	}

	table {
	/ / table-layout: fixed;
	}

	/*.profile-widget .profile-widget-picture {
    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    float: left;
    width: 100px;
    margin: -35px -5px 0 30px;
    position: relative;
    z-index: 1;
}*/

</style>
<!-- Main Content start -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-body">
			<div class="">
				<div class="section-header card-primary">
					<h1 style="color: #891635">Patient List</h1>
					<div class="card-header-action d-flex" style="margin-left: auto; ">
						<div class="align-items-center">
							<div class="form-group mx-2 my-0">
								<select class="form-control" id='allPatient'
										onchange="loadPatients(this.value)" style="border-radius: 20px;">
									<option value="1">Admitted</option>
									<!-- <option value="6">Admit ICU</option> -->
									<option value="2">Discharged</option>
									<option value="4">Pending</option>
									<?php if($user_type==3){ ?>
										<option value="5">Staff</option>
									<?php } ?>
                                    <option value="8">OPD</option>
									<option value="7">Patients with Closed Bill</option>
									<option value="3">All</option>
									
								</select>
							</div>


						</div>
						<div class="align-items-center">
							<div class="form-group mx-2 my-0">
								<select class="form-control" id='zoneDetails'
										onchange="loadPatientsZoneWise(this.value)" style="border-radius: 20px;">
									<option selected disabled>Select Zone</option>

								</select>
							</div>
						</div>
						<button class="btn btn-primary" onclick="exportPatientData()"><i class="fa fa-download"></i>
							Export Patient Data
						</button>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<table class="table table-hover table-striped table-responsive table-bordered "
						   id="patientTable" style="width:100%" role="grid">
						<thead style="background: #8916353b;">
						<tr>
							<th>Aadhar Number</th>
							<th >Name</th>
							<th>Contact</th>
							<th>Blood Group</th>
							<th>Zone</th>
							<th>Bed</th>
							<th>Admission Date</th>
							<th>MFD</th>
							<th >Action</th>


						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>


<div class="modal fade" id="history_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-content" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editForm_new" class="form-horizontal" method="POST" novalidate="novalidate"
					  onsubmit="return false">
					<div id="DataView"></div>
					<input type="hidden" id="pat_id" name="pat_id">
<!--					<div id="radiology_report">-->
<!--						<div id="accordion_RR">-->
<!--							<div class="accordion">-->
<!--								<div class="accordion-header " onclick="get_RadiologyTableData()" role="button"-->
<!--									 data-toggle="collapse" data-target="#panel-bodyRR" aria-expanded="true">-->
<!--									<h4>Radiology Report</h4>-->
<!--								</div>-->
<!--								<div class="accordion-body collapse" id="panel-bodyRR" data-parent="#accordion_RR">-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


					</div>
			</div>
			</form>
		</div>
	</div>
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
<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
