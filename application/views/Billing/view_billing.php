<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.select2.select2-container.select2-container--default {
		width: 100% !important;
	}
	.accordion .accordion-header[aria-expanded="true"]{
		box-shadow: 0 2px 6px #891635!important;
		background-color: #891635!important;
	}
	table.datatable thead td.no-sort {
	    background: none;
	    pointer-events: none;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Billing Details</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">
					<div class="card">

						<div class="">
							<form id="uploadBilling" method="post" data-form-valid="saveBilling" onsubmit="return false">
								<div class="py-0">
									<div class="card my-0 shadow-none">
										<div class="card-body">
											<input type="hidden" name="forward_billing" id="forward_billing">
											<input type="hidden" name="billing_patient_id" id="billing_patient_id">
											<input type="hidden" name="billing_patient_name" id="billing_patient_name">
											<input type="hidden" name="billing_patient_adhar" id="billing_patient_adhar">
											<div class="form-row">

												<div class="form-group my-0 py-0 col-md-6">
													<label>Service Name</label>
													<select id="bservice_name" name="bservice_name" class="form-control" onchange="getServiceDescription(this.value)">
														<option value="">No data found</option>
													</select>
												</div>

												<div class="form-group my-0 py-0 col-md-6">
													<label>Service Description</label>

													<select id="bservice_desc" name="bservice_desc" class="form-control" onchange="getServiceRate(this.value)">
														<option value="">No data found</option>
													</select>
												</div>


											</div>
											<div class="form-row">
												<div class="form-group my-0 py-0 col-md-3">
													<label>Rate</label>
													<input type="hidden" name="billing_service_id" id="billing_service_id">
													<div id="divBillingRate">

														<input type="text" name="billing_rate" class="form-control" id="billing_rate">
													</div>

												</div>
												<div class="form-group my-0 py-0 col-md-3">
													<label>Unit</label>
													<input type="number" name="billing_unit" id="billing_unit" value="1" class="form-control">

												</div>
												<div class="form-group my-0 py-0 col-md-3">
													<label>Date Service</label>
													<input type="date" name="billing_date" class="form-control" id="billing_date">

												</div>

												<div class="form-group my-0 py-0 col-md-3">
													<label>File Upload</label>
													<input type="file" name="billing_file[]" class="form-control" id="billing_file">

												</div>
											</div>
											<div class="form-row">
												<div class="form-group my-0 py-0 col-md-8">
													<label>Detail</label>
													<textarea name="billing_detail" class="form-control" id="billing_detail"></textarea>

												</div>
												<div class="modal-footer my-0 py-0 col-md-4">

													<button class="btn btn-default mr-1 mt-4" type="submit" style="background: #891635;color: white">Submit</button>
													<button class="btn btn-secondary mt-4" type="reset">Reset</button>
												</div>
											</div>
										</div>
									</div>
								</div>

							</form>
						</div>
						<div class="row d-none">
						<div class="col-md-12">
						<button type="button" class="btn btn-link" onclick="$('#room_table_div').toggleClass('d-none');view_room_order_billing()">View Room Order Billing</button>
						</div>
						</div>
						<div class="row d-none" id="room_table_div">
						<button class="btn btn-link ml-5" onclick="add_order()"><i class="fa fa-plus"></i>Add to order list</button>
						<div class="col-md-12">
						<div class="table-responsive">
								<table class="table table-striped" >
									<thead>
									<tr>
										<td>Service Name</td>
										<td>Date</td>
										<td>Order</td>
										<td>Rate</td>
									</tr>
									</thead>
									<tbody id="roombilltable">

									</tbody>
								</table>
							</div>
						</div>
						</div>
						<div class="card-body">
							<!-- <div class="table-responsive"> -->
							<hr/>
							<div class="row mb-2 pl-2">
									<button class="btn btn-primary d-none" id="billingCheckSubmit" onclick="submitCheckBilling()">Save Confirm Service</button>
							</div>
								<table class="table table-striped" id="billingTable" style="width: 100%">
									<thead>
										<tr>
										<td data-priority="1">Bed No</td>
										<td>Patient ID</td>
										<td>Patient Name</td>
										<td>Service Code</td>
										<td>Service Order No</td>
										<td>Service Name</td>
										<td  data-priority="2" class="no-sort">	<input type="checkbox" name="select_all" value="-1" id="example-select-all" class="custom-control custom-checkbox billingCheckbox"></td>
										<td>Delete Service</td>
										<td>Service Provider</td>
										<td>Date and Time</td>
									</tr>
									<tr>
										<td data-priority="1"></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td data-priority="2" class="no-sort">Confirm Service Given </td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									
									</thead>
									<tbody>

									</tbody>
								</table>
							<!-- </div> -->
						</div>
						
						
						
						<div class="card-body">
							<!-- <div class="table-responsive"> -->
							<hr/>
							<h5>Deleted Billings</h5>
								<table class="table table-striped" id="DeletebillingTable" style="width: 100%">
									<thead>
										<tr>
										<td data-priority="1">Bed No</td>
										<td>Patient ID</td>
										<td>Patient Name</td>
										<td>Service Code</td>
										<td>Service Order No</td>
										<td>Service Name</td>
										<!-- 	<td  data-priority="2" class="no-sort">	</td> -->
										<td>Restore Service</td>
										<td>Service Provider</td>
										<td>Date and Time</td>
									</tr>
									
									
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
	</section>
</div>

<!-- company modal  -->
<?php $this->load->view('Billing/billing'); ?>


<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		document.getElementById("patient_nameSidebar").innerText=localStorage.getItem("patient_name");
		document.getElementById("patient_adharSidebar").innerText= localStorage.getItem("patient_adharnumber");
		var patient_id=localStorage.getItem("patient_id");
		$("#billing_patient_id").val(patient_id);
		$("#billing_patient_name").val(localStorage.getItem("patient_name"));
		$("#billing_patient_adhar").val(localStorage.getItem("patient_adharnumber"));
		$("#patient_list").val(patient_id);
		$("#p_id").val(patient_id);

	});
function view_room_order_billing(){
	var p_id=$("#billing_patient_id").val();
	$.ajax({
            type: "POST",
            url: '<?= base_url("RoomOrderBilling")?>',
            dataType: "json",
            async: false,
            cache: false,
			data:{p_id},
            success: function (result) {
               
                if (result.status == 200) {
                    $("#roombilltable").html(result.data);
                } else {
					$("#roombilltable").html(result.data);
                }
            }
        });
}

function add_order(){
	var p_id=$("#billing_patient_id").val();
	$.ajax({
            type: "POST",
            url: '<?= base_url("addOrderRoom")?>',
            dataType: "json",
            async: false,
            cache: false,
			data:{p_id},
            success: function (result) {
               
                if (result.status == 200) {
                    alert(result.body);
                } else {
					alert(result.body);
                }
            }
        });
}
</script>
