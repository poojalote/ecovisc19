<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
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
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Service Order Details</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">

					<div class="card">
						<div class="card-header-action">
							<ul class="nav nav-pills" id="serviceOrderTablist" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="standardLabTab" data-toggle="tab"
									   href="#standardLab1" role="tab"
									   aria-controls="standardLab1" aria-selected="true">Standard Lab Test</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="serviceOrderTab" data-toggle="tab" href="#serviceOrder1"
									   role="tab" aria-controls="serviceOrder1" aria-selected="false">Service Order
										Request</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="orderPlaceTab" data-toggle="tab" href="#placeOrder1"
									   role="tab"
									   aria-controls="placeOrder1" aria-selected="false">Order History</a>
								</li>


							</ul>
						</div>

						<div class="tab-content">
							<div class="tab-pane fade show active" role="tabpanel" id="standardLab1">
								<form id="uploadStandardLabServices" method="post" onsubmit="return false">
									<button type="button" class="btn btn-primary" onclick="getSoapRequest()">Click</button>
									<table class="table-bordered" align="center">
										<thead>
										<th>Day</th>
										<th>
											<select class="form-control" name="labDay" id="labDat"
													onchange="getStandardLabServices(this.value)">
												<option value="1">0th day of patient</option>
												<option value="5">5th day of patient</option>
												<option value="11">11th day of patient</option>
												<option value="14">14th day of patient</option>
												<option value="0" selected>select any other date</option>
											</select>
											<div id="standardLabDateDiv" class="mt-1">
												<input type="datetime-local" name="standardLabDate"
													   id="standardLabDate">
											</div>
										</th>
										</thead>
										<tbody id="standardLabServicesTable">

										</tbody>
									</table>
								</form>
							</div>
							<div class="tab-pane fade" role="tabpanel" id="serviceOrder1">


								<div class="">
									<form id="uploadServiceOrderPlace" method="post" onsubmit="return false">
										<div class="py-0">
											<div class="card my-0 shadow-none">
												<div class="card-body">
													<input type="hidden" name="forward_billing" id="forward_billing">
													<input type="hidden" name="billing_patient_id"
														   id="billing_patient_id">
													<div class="form-row">
														<!-- <table class="table-bordered" align="center">
															<thead>
															<tr>
																<th></th>
																<th>5 AM - 12 PM </th>
																<th>12 PM - 5 PM </th>
																<th>5 PM - 12 AM </th>
																<th>12 AM - 5 AM </th>
															</tr>
															</thead>
															<tbody class="text-center" id="serviceOrderPlaceTimeTable">
															<tr>
																<td>Today</td>
																<td><input type="checkbox" name="serviceorder" id="1_5AM-12PM" onclick="getServiceOrderTime(1,'5 AM - 12 PM','1_5AM-12PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="1_12PM-5PM" onclick="getServiceOrderTime(1,'12 PM - 5 PM','1_12PM-5PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="1_5PM-12AM" onclick="getServiceOrderTime(1,'5 PM - 12 AM','1_5PM-12AM')"></td>
																<td><input type="checkbox" name="serviceorder" id="1_12AM-5AM" onclick="getServiceOrderTime(1,'12 AM - 5 AM','1_12AM-5AM')"></td>
															</tr>
															<tr>
																<td>2nd Day</td>
																<td><input type="checkbox" name="serviceorder" id="2_5AM-12PM" onclick="getServiceOrderTime(2,'5AM-12PM','2_5AM-12PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="2_12PM-5PM" onclick="getServiceOrderTime(2,'12 PM - 5 PM','2_12PM-5PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="2_5PM-12AM" onclick="getServiceOrderTime(2,'5 PM - 12 AM','2_5PM-12AM')"></td>
																<td><input type="checkbox" name="serviceorder" id="2_12AM-5AM" onclick="getServiceOrderTime(2,'12 AM - 5 AM','2_12AM-5AM')"></td>
															</tr>
															<tr>
																<td>3rd Day</td>
																<td><input type="checkbox" name="serviceorder" id="3_5AM-12PM" onclick="getServiceOrderTime(3,'5 AM - 12 PM','3_5AM-12PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="3_12PM-5PM" onclick="getServiceOrderTime(3,'12 PM - 5 PM','3_12PM-5PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="3_5PM-12AM" onclick="getServiceOrderTime(3,'5 PM - 12 AM','3_5PM-12AM')"></td>
																<td><input type="checkbox" name="serviceorder" id="3_12AM-5AM" onclick="getServiceOrderTime(3,'12 AM - 5 AM','3_12AM-5AM')"></td>
															</tr>
															<tr>
																<td>4th Day</td>
																<td><input type="checkbox" name="serviceorder" id="4_5AM-12PM" onclick="getServiceOrderTime(4,'5 AM - 12 PM','4_5AM-12PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="4_12PM-5PM" onclick="getServiceOrderTime(4,'12 PM - 5 PM','4_12PM-5PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="4_5PM-12AM" onclick="getServiceOrderTime(4,'5 PM - 12 AM','4_5PM-12AM')"></td>
																<td><input type="checkbox" name="serviceorder" id="4_12AM-5AM" onclick="getServiceOrderTime(4,'12 AM - 5 AM','4_12AM-5AM')"></td>
															</tr>
															<tr>
																<td>5th Day</td>
																<td><input type="checkbox" name="serviceorder" id="5_5AM-12PM" onclick="getServiceOrderTime(5,'5 AM - 12 PM','5_5AM-12PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="5_12PM-5PM" onclick="getServiceOrderTime(5,'12 PM - 5 PM','5_12PM-5PM')"></td>
																<td><input type="checkbox" name="serviceorder" id="5_5PM-12AM" onclick="getServiceOrderTime(5,'5 PM - 12 AM','5_5PM-12AM')"></td>
																<td><input type="checkbox" name="serviceorder" id="5_12AM-5AM" onclick="getServiceOrderTime(5,'12 AM - 5 AM','5_12AM-5AM')"></td>
															</tr>
															</tbody>
														</table> -->
														<!-- <div class="d-none" id="">
															<table class="table table-striped">
																<thead>
																<tr>
																	<td>day</td>
																	<td>Time</td>
																</tr>
																</thead>
																<tbody id="serviceOrderTimeHidden">

																</tbody>
															</table>
														</div> -->
													</div>
													<!-- <hr/>
													<div class="form-row">
														<input type="hidden" name="serviceOrder_patient_id" id="serviceOrder_patient_id">
														<input type="hidden" name="serviceOrder_patient_name" id="serviceOrder_patient_name">
														<input type="hidden" name="serviceOrder_patient_adhar" id="serviceOrder_patient_adhar">
														<div class="form-group my-0 py-0 col-md-2">
															<label>Commonly Use</label>


														</div>

														<div class="form-group my-0 py-0 col-md-10" id="commonServiceDetailDiv">

															<div id="list1" class="dropdown-check-list visible" tabindex="100">

																<ul class="items" id="commonServiceDetail" style="height: 110px;overflow-y: auto;">

																</ul>
															</div>
														</div>


													</div> -->
													<!-- <hr/> -->
													<div> Add Other Services
														<!--  <button type="button" class="btn btn-primary" onclick="serviceOrderCategoryToggle()"><i class="fa fa-plus"></i> </button> -->
														<input type="hidden" name="serviceOrder_patient_id"
															   id="serviceOrder_patient_id">
														<input type="hidden" name="serviceOrder_patient_name"
															   id="serviceOrder_patient_name">
														<input type="hidden" name="serviceOrder_patient_adhar"
															   id="serviceOrder_patient_adhar">
													</div>
													<div class="" id="serviceCategoryshow">
														<div class="form-row">
															<div class="form-group my-0 py-0 col-md-6">
																<label>Service Category</label>

																<select id="bservice_cat" name="bservice_cat"
																		class="form-control"
																		onchange="getServiceName(this.value)">
																	<option value="All">All
																	</option>
																	<option value="RADIOLOGY">Radiology</option>
																	<option value="PATHOLOGY">Pathology</option>
																	<option value="PROCEDURE">Procedure</option>
																	<option value="EQUIPMENT">Bio Medical Equipment
																	</option>
																	<option value="F&B">F&B</option>
																	<option value="Materials">Materials</option>
																	<option value="OTHERS">Others</option>
																</select>
															</div>
															<div class="form-group my-0 py-0 col-md-6">
																<label>Service Name</label>
																<select id="bserviceOrder_name"
																		name="bserviceOrder_name" class="form-control"
																		onchange="getServiceDescription(this.value)">
																	<option value="">No data found</option>
																</select>
															</div>

														</div>
														<div class="form-row">
															<div class="form-group my-0 py-0 col-md-3">
																<label>Service Description</label>

																<select id="bserviceOrder_desc"
																		name="bserviceOrder_desc" class="form-control"
																		onchange="getServiceRate(this.value)">
																	<option value="">No data found</option>
																</select>
															</div>
															<div class="form-group my-0 py-0 col-md-2">
																<label>Rate</label>
																<input type="hidden" name="billing_service_id"
																	   id="billing_service_id">
																<div id="divBillingRate">

																	<input type="text" name="billing_rate"
																		   class="form-control" id="billing_rate">
																</div>

															</div>
															<div class="form-group my-0 py-0 col-md-2">
																<label>Unit</label>
																<input type="number" name="serviceOrder_unit"
																	   id="serviceOrder_unit" value="1" min="1" max="1"
																	   class="form-control">

															</div>
															<div class="form-group my-0 py-0 col-md-3">
																<label>Service Date</label>
																<input type="datetime-local" name="serviceOrder_date"
																	   id="serviceOrder_date" class="form-control">

															</div>
															<div class="modal-footer my-0 py-0 col-md-2">

																<button class="btn btn-default mr-1 mt-4" type="button"
																		onclick="addServiceOrderItem()"
																		style="background: #891635;color: white">Add to
																	list
																</button>

															</div>


														</div>
													</div>
													<hr/>
													<div class="form-row">

														<div class="modal-footer my-0 py-0 col-md-4"
															 style="margin-left: auto;">

															<button class="btn btn-default mr-1" type="button"
																	onclick="place_serviceOrder()"
																	style="background: #891635;color: white">Place Order
															</button>
															<button class="btn btn-secondary" type="reset">Reset
															</button>
															<div id="clearListButtonDiv" class="mr-1 d-none"
																 style="margin-left: auto;">
																<button type="button" class="btn btn-primary"
																		onclick="clearListServiceItem()"
																		style="float: right;">Clear List
																</button>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div>

									</form>
								</div>
								<div class="p-1">

									<div class="table-responsive">

										<table class="table table-striped">
											<thead>
											<tr>
												<td>Name</td>
												<td>Date</td>
											</tr>
											</thead>
											<tbody id="serviceOrderItemTable">

											</tbody>
										</table>
									</div>
								</div>

							</div>
							<div class="tab-pane fade" role="tabpanel" id="placeOrder1">
								<div class="card-body view">
									<div class="table-responsive wrapper">
										<table class="table-striped table-bordered" id="orderPlaceTable"
											   style="width: 100%">
											<!-- <thead>
											<tr>
												<td>service</td>
												<td>date</td>
												<td>time</td>
												<td>Rate</td>
												<td>Action</td>
											</tr>
											</thead> -->
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

<!-- company modal  -->
<?php $this->load->view('Billing/billing'); ?>


<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		document.getElementById("patient_nameSidebar").innerText = localStorage.getItem("patient_name");
		document.getElementById("patient_adharSidebar").innerText = localStorage.getItem("patient_adharnumber");
		var patient_id = localStorage.getItem("patient_id");
		$("#billing_patient_id").val(patient_id);
		$("#patient_list").val(patient_id);
		$("#p_id").val(patient_id);
		$("#serviceOrder_patient_adhar").val(localStorage.getItem("patient_adharnumber"));
		$("#serviceOrder_patient_id").val(localStorage.getItem("patient_id"));
		$("#serviceOrder_patient_name").val(localStorage.getItem("patient_name"));
		getStandardLabServices(0)
		$("#bservice_cat").select2();
		getServiceName('All');
		getServiceDescription('All');
	

	});

	let selectedServices =[];
	
	function getSoapRequest(){
		var patient_id = localStorage.getItem("patient_id");
		serverRequest("HL7Controller/createNewMessage", {id: patient_id,codes:selectedServices}).then(response => {
		// $.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			
			
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
	}
	
	
	//
	// var checkList = document.getElementById('list1');
	// checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
	// 	if (checkList.classList.contains('visible'))
	// 		checkList.classList.remove('visible');
	// 	else
	// 		checkList.classList.add('visible');
	// }

</script>
