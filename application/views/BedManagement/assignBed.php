<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$permission_array = $this->session->user_permission;

if(is_null($permission_array)){
	$permission_array=array();
}
?>
<style>
	.error {
		color: red;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Assign Bed</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">
					<div class="card">

						<div class="card-body">

							<div id="p_details">


							</div>
							<br/>
							<?php if (in_array("assign_bed", $permission_array)) { ?>
								<form id="newPatientForm" method="post">
									<input type="hidden" value="" name="p_id" id="p_id">
									<div class="form-group my-0 py-0">
										<label>Unique Id</label>
										<input type="text" name="u_Id" class="form-control " id="u_Id"
											   placeholder="Unique Id" />
									</div>
									<!-- <div class="form-group my-0 py-0">
										<label>Bed Type </label>
										<select class="form-control" name="service_id"
												id="service_id">
											<option disabled>select bed type</option>
										</select>
									</div> -->
									<div class="form-group my-0 py-0">
										<label>Name </label>
										<input type="text" name="name" class="form-control" id="name"
											   placeholder="Enter Name" />
									</div>

									<div class="form-group my-0 py-0" id="hBed">
										<label>Hospital Room</label>
										<select name="h_room" id="hroom" class="form-control "></select>
									</div>
									<div class="form-group my-0 py-0" id="sBed" style="display: none">
										<strong>Bed</strong>
										<select name="b_bed" id="b_bed" class="form-control "></select>
									</div>


									<!--									<button type="button" class="btn btn-danger" id="btnDelete" onclick="deletePaitent($('#p_id').val())" style="display: none">Delete</button>-->
									<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
									<div class="form-group my-0 py-0 mt-2">
										<button type="submit" id="assign_bed_btn" class="btn btn-primary">Assign</button>
										<button type="button" id="check_order_btn"onclick="check_roomorder()" class="btn btn-primary">Add to Bill
										</button>
									</div>
								</form>

							<?php } ?>


						</div>
						<div class="card-body">
							<div class="table-responsive">
								<div class="dataTables_wrapper no-footer">
									<table class="table table-striped dataTable no-footer" id="patientBedHistoryTable"
										   role="grid">
										<thead>
										<tr>
											<td>Room</td>
											<td>Bed</td>
											<td>Date</td>
											<!--  <td>Contact</td>
											 <td>Birth Date</td>
											 <td>Location</td>
											 <td>Blood Group</td>
											 <td>Action</td> -->
										</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
	$(document).ready(function () {
		document.getElementById("patient_nameSidebar").innerText = localStorage.getItem("patient_name");
		document.getElementById("patient_adharSidebar").innerText = localStorage.getItem("patient_adharnumber");
		var patient_id = localStorage.getItem("patient_id");
		$("#patient_list").val(patient_id);


	});

	function check_roomorder() {
		let p_id = $("#p_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("AssignBedController/assignBedCalculation")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status === 200) {
					app.successToast(result.body);
				} else {
					app.errorToast(result.body);
				}
			}
		});

	}


</script>
