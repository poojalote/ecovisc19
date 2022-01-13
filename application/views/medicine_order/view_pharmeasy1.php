<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
$user_id = $session_data->id;
$username = $session_data->name;
?>

<style>
	.table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
		padding: 0px 4px;
	}
	/*.main-content
	{
		width: 100%!important;
	}*/
	.left_item a
	{
		    padding: 3px 15px;
		    color: #bcc1c6;
		    font-size: 10px;
		    text-transform: uppercase;
		    letter-spacing: 1.3px;
		    font-weight: 600;
		    background: #bbb8b9;
		    color: black;
		    padding: 5px 0px 5px 0px !important;
		    margin-top: .5rem!important;
		    border-radius: none!important;
	}
	.left_item a .active
	{
		background: #891635 !important;
		color: white !important;
	}
	.nav-link{
		border-radius: 0!important;
		color: black;
	}
	.nav-pills .nav-item .nav-link
	{
		color: black;
	}

	.modal-lg {
	    max-width: 80% !important;
	}
	
	.table_back
	{
		background-color: #f5f5f5!important;
	}
	#printme {
	  display: none;
	}
	#printme1 {
	  display: none;
	}

	@media print {
	  .main-sidebar {
	    display: none;
	  }
	  .main-content {
	    display: none;
	  }
	  #prinDivHistory
	  {
	  	 display: none;
	  }
	  #prinDivHistory1
	  {
	  	 display: none;
	  }
	  .main-footer
	  {
	  	display: none;
	  }
	  .close
	  {
	  	display: none;
	  }
	  .btn-rounded 
	  {
	  	display: none;
	  }
	  #printme {
	    display: block;
	  }
	  #printme1 {
	    display: block;
	  }
	  .table_back
		{
			background-color: #f5f5f5!important;
		}

	}
</style>
<div id="printme"></div>
<div id="printme1"></div>
<!-- Main Content -->
<div class="main-sidebar" id="menu_hideshow">
	<div class="" style="text-align: center!important;">
		<div class="profile-widget-header">
			<div class="rounded-circle profile-widget-picture">
				<i class="fas fa-user-md" style="font-size: 6rem"></i>
			</div>
		</div>
		<div class="mt-2">
			<b style="text-transform: uppercase;"><?= $username ?></b>
		</div>
		<div>
			<small>PHARMACIST</small>
		</div>
						<div class="card-header-action text-center">
							<ul class="nav nav-pills flex-column" id="pharmeasyTabs" role="tablist">
								<li class="nav-item left_item">
									<a class="nav-link a_color active" id="orderMedicine" data-toggle="tab"
									   href="#orderMedicinePanel"
									   role="tab"
									   aria-controls="orderMedicinePanel" aria-selected="true">Order Medicine </a>
								</li>

								<li class="nav-item left_item">
									<a class="nav-link" id="returnMedicine" data-toggle="tab"
									   href="#returnMedicinePanel"
									   role="tab"
									   aria-controls="returnMedicinePanel" aria-selected="false">Return Medicine</a>
								</li>

								<li class="nav-item left_item">
									<a class="nav-link" id="backOrder" data-toggle="tab"
									   href="#backOrderPanel"
									   role="tab"
									   aria-controls="backOrderPanel" aria-selected="false">Back Order</a>
								</li>
								<li class="nav-item left_item">
									<a class="nav-link" id="historyMedicine" onclick="load_patient_order_history()"
									   data-toggle="tab"
									   href="#historyMedicinePanel"
									   role="tab"
									   aria-controls="historyMedicinePanel" aria-selected="false">History Medicine</a>
								</li>
								<li class="nav-item left_item">
									<a class="nav-link" id="hospitalOrderMedicine" 
									   data-toggle="tab"
									   href="#hospitalorderMedicinePanel"
									   role="tab"
									   aria-controls="hospitalorderMedicinePanel" aria-selected="false">Hospital Order Medicine</a>
								</li>
								<li class="nav-item left_item">
									<a class="nav-link" id="hospitalReturnMedicine" 
									   data-toggle="tab"
									   href="#hospitalreturnMedicinePanel"
									   role="tab"
									   aria-controls="hospitalorderMedicinePanel" aria-selected="false">Hospital Return Medicine</a>
								</li> 
							</ul>
						</div>
					</div>
</div>
<div class="main-content main-content1">
	
	
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Order Medicine Details</h1>
			<!-- <button class="btn btn-primary ml-1" type="button" onclick="get_menuHide()">Menu Hide</button> -->
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					
					<div class="card">

						
						<div class="card-body">
							<div class="tab-content">
								
								<div class="tab-pane fade show active" role="tabpanel" id="orderMedicinePanel">
									<div class="col-md-12">
										<!-- <div class="row" style="float: right;">
											<button class="btn btn-primary mb-2" type="button" id="printButton" onclick="printDiv()">Print</button>
										</div> -->
										<div class="row">
											<div class="col-md-6 form-group">
												<label>Patient Name</label>
												<select id="patient-order-list" name="patient_order_id"
														class="form-control"
														style="width: 100%;" onchange="load_patient_order(this.value)">
												</select>
											</div>
											<div class="col-md-6 form-group">
												<label>After Date</label>
												<input type="date" class="form-control" id="from_date" name="from_date"
													   value="2021-05-31" onchange="date_change();">
											</div>
										</div>
										<div class="card-header-action">
											<ul class="nav nav-pills" id="medicineTabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active d-none" id="medicineOrder-tab"
													   data-toggle="tab" href="#medicineOrderPanel"
													   role="tab"
													   aria-controls="medicineOrderPanel"
													   aria-selected="true">Medicines</a>
												</li>

												<li class="nav-item">
													<a class="nav-link d-none" id="cosumableOrder-tab" data-toggle="tab"
													   href="#ConsumableOrderPanel"
													   role="tab"
													   aria-controls="ConsumableOrderPanel" aria-selected="false">Consumables</a>
												</li>

											</ul>
										</div>
										<div class="tab-content">
											<div class="tab-pane fade" role="tabpanel" id="medicineOrderPanel">
												<form id="order_pharmeasy" method="post"
													  data-form-valid="savePharmeasyOrder">
													<input type="hidden" name="patient_id" id="orderPatient"/>
													<input type="hidden" name="from_date1" id="from_date1"/>
													<input type="hidden" name="type" value="1"/>
													<div class="row" id="printmedicineDiv">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																<tr>
																	<td>Medicine Name</td>
																	<td>BU</td>
																	<td>PKT</td>
																	<td>Order Quantity</td>
																	<td>Supply Quantity</td>
																	<td></td>
																	<td>Alternative Medicine</td>
																	<td>Unit Rate</td>
																	<td>Total</td>
																	<td>Mcgm</td>
																</tr>
																</thead>
																<tbody id="orderTable">
																</tbody>
																<tfoot id="orderTableFooter">
																<tr>
																	<td colspan="8" class="text-right">Invoice Number
																	</td>
																	<td colspan="2">
																		<input type="text" name="invoice_number"
																			   id="invoice_number"
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Number"></td>
																</tr>
																<tr>
																	<td colspan="8" class="text-right">Invoice Amount
																	</td>
																	<td colspan="2"><input type="number"
																						   name="invoice_amount"
																						   readonly
																						   id="invoice_amount"
																						   class="form-control"
																						   data-valid="required"
																						   data-msg="Enter Invoice Amount">
																	</td>
																</tr>
																</tfoot>
															</table>
														</div>
													</div>
													<div class="align-items-center justify-content-end row">

														<button class="btn btn-primary">Save Order</button>
														<button id="openOrderModel" data-toggle="modal"
																data-target="#fire-modal-order" type="button"
																class="d-none">open
														</button>
													</div>
												</form>
											</div>
											<div class="tab-pane fade" role="tabpanel" id="ConsumableOrderPanel">
												<form id="order_consumables_pharmeasy" method="post"
													  data-form-valid="saveConsumablePharmeasyOrder">
													<input type="hidden" name="patient_id" id="orderConsumablePatient"/>
													<input type="hidden" name="from_date2" id="from_date2"/>
													<input type="hidden" name="type" value="1"/>
													<div class="row">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																<tr>
																	<td>Consumables Material</td>
																	<td>BU</td>
																	<td>Order Quantity</td>
																	<td>Supply Quantity</td>
																	<td></td>
																	<td>Alternative</td>
																	<td>Unit Rate</td>
																	<td>Total</td>
																	<td>Mcgm</td>
																</tr>
																</thead>
																<tbody id="orderConsumableTable">
																</tbody>
																<tfoot id="orderConsumableTableFooter">
																<tr>
																	<td colspan="7" class="text-right">Invoice Number
																	</td>
																	<td><input type="text" name="invoice_number"
																			   id="cons_invoice_number"
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Number"></td>
																</tr>
																<tr>
																	<td colspan="7" class="text-right">Invoice Amount
																	</td>
																	<td><input type="number" name="invoice_amount"
																			   id="cons_invoice_amount"
																			   readonly
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Amount"></td>
																</tr>
																</tfoot>
															</table>
														</div>
													</div>
													<div class="align-items-center justify-content-end row">
														<button class="btn btn-primary">Save Order</button>
														<button id="openOrderModel" data-toggle="modal"
																data-target="#fire-modal-order" type="button"
																class="d-none">open
														</button>
													</div>
												</form>
											</div>
										</div>

									</div>
								</div>

								<div class="tab-pane fade" role="tabpanel" id="returnMedicinePanel">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6 form-group">
												<label>Patient Name</label>
												<select id="patient-order-return-list" name="patient_order_return_id"
														class="form-control"
														style="width: 100%;"
														onchange="load_patient_order_rerurn(this.value)">
												</select>
											</div>
										</div>
										<form id="order_return_pharmeasy" method="post"
											  data-form-valid="savePharmeasyReturnOrder">
											<input type="hidden" name="patient_id" id="orderReturnPatient"/>
											<input type="hidden" name="type" value="1"/>
											<div class="row">
												<div class="table-responsive">
													<table class="table table-striped">
														<thead>
														<tr>
															<td>Medicine Name</td>
															<td>BU</td>
															<td>PKT</td>
															<td>Order Quantity</td>
															<td>Order ID</td>
															<td></td>
															<td>Return Reason</td>
														</tr>
														</thead>
														<tbody id="orderReturnTable">
														</tbody>
														<tfoot id="orderReturnTableFooter">
														<tr>
															<td colspan="5" class="text-right">Invoice Number</td>
															<td><input type="text" name="invoice_return_number"
																	   id="invoice_return_number"
																	   class="form-control" data-valid="required"
																	   data-msg="Enter Invoice Number"></td>
														</tr>
														<tr>
															<td colspan="5" class="text-right">Invoice Amount</td>
															<td><input type="number" name="invoice_return_amount"
																	   id="invoice_return_amount"
																	   class="form-control" data-valid="required"
																	   data-msg="Enter Invoice Amount"></td>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
											<div class="align-items-center justify-content-end row">
												<button class="btn btn-primary">Return Order</button>
												<button id="openOrderReturnModel" data-toggle="modal"
														data-target="#fire-modal-order" type="button" class="d-none">
													open
												</button>
											</div>
										</form>
									</div>
								</div>
								<div class="tab-pane fade" role="tabpanel" id="backOrderPanel">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6 form-group">
												<label>Patient Name</label>
												<select id="patient-backorder-list" name="patient_backorder_id"
														class="form-control"
														style="width: 100%;"
														onchange="load_patient_backorder(this.value)">
												</select>
											</div>
											<div class="col-md-6 form-group">
												<label>After Date</label>
												<input type="date" class="form-control" id="backfrom_date"
													   name="backfrom_date"
													   value="2021-05-31" onchange="backdate_change();">
											</div>
										</div>
										<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
											   cellspacing="0" id="BackOrderTable" style="width:100%">
											<thead>
											<tr>
												<td>Patient Name</td>
												<td>Medicine Name</td>
												<td>Date</td>
												<td>Order Quantity</td>

											</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>

								</div>

								<div class="tab-pane fade" role="tabpanel" id="historyMedicinePanel">
									<div class="col-md-12">
										<div class="col-md-6 form-group">
											<label>Patient Name</label>
											<select id="patient_history" name="patient_history" class="form-control"
													style="width: 100%;"
													onchange="load_patient_order_history(this.value)">
											</select>

										</div>

									</div>
									<div class="col-md-12">
										<div class="card-header-action">
											<ul class="nav nav-pills" id="medicineHistoryTabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="medicineHistoryOrder-tab"
													   data-toggle="tab" href="#medicineHistoryOrderPanel"
													   role="tab"
													   aria-controls="medicineHistoryOrderPanel"
													   aria-selected="true">Medicines</a>
												</li>

												<li class="nav-item">
													<a class="nav-link" id="cosumableHistoryOrder-tab" data-toggle="tab"
													   href="#ConsumableHistoryOrderPanel"
													   role="tab"
													   aria-controls="ConsumableHistoryOrderPanel"
													   aria-selected="false">Consumables</a>
												</li>

											</ul>
										</div>
									</div>

									<div class="col-md-12">

										<div class="tab-content">
											<div class="tab-pane fade show active" role="tabpanel"
												 id="medicineHistoryOrderPanel">
												<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
													   cellspacing="0" id="HistoryOrderTable" style="width:100%">
													<thead>
													<tr>
														<td>Patient ID</td>
														<td>Patient Name</td>
														<td>Order Number</td>
														<td>Invoice Amount</td>
														<td>Invoice Number</td>
														<td>Supply Date</td>
														<td>Action</td>
													</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
											<div class="tab-pane fade" role="tabpanel" id="ConsumableHistoryOrderPanel">
												<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
													   cellspacing="0" id="ConsumableHistoryOrderTable"
													   style="width:100%">
													<thead>
													<tr>
														<td>Patient ID</td>
														<td>Patient Name</td>
														<td>Order Number</td>
														<td>Invoice Amount</td>
														<td>Invoice Number</td>
														<td>Supply Date</td>
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
							
							<div class="tab-pane fade" role="tabpanel" id="hospitalorderMedicinePanel">
							<div class="col-md-12">
										<div class="card-header-action">
											<ul class="nav nav-pills" id="hospitalneworder" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" 
													   data-toggle="tab" href="#hospitalneworderPanel"
													   role="tab"
													   aria-controls="hospitalneworderPanel"
													   aria-selected="true">New Orders</a>
												</li>

												<li class="nav-item">
													<a class="nav-link" id="hospitalhistoryorder" data-toggle="tab"
													   href="#HospitalOrderHistoryOrderPanel"
													   role="tab"
													   aria-controls="HospitalOrderHistoryOrderPanel"
													   aria-selected="false" onclick="load_hospital_order_history()">Order History</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="col-md-12">
									<div class="tab-content">
											<div class="tab-pane fade show active" role="tabpanel"
												 id="hospitalneworderPanel">
										<div class="row">
											<div class="col-md-6 form-group">
												<label>Zone</label>
												<select id="department_name" name="department_name"
														class="form-control"
														style="width: 100%;" onchange="load_departmentOrder(this.value)">
												<option value="-1" selected disabled>Select Zone</option>
												
												</select>
											</div>
											</div>
											<div id="h_table_order" style="display:none"> 
											<form id="hospital_order_pharmeasy" method="post"
													  data-form-valid="saveHospPharmeasyOrder">
										<div class="row" id="">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																<tr>
																	<td>Material/Medicine Name</td>
																	<td>BU</td>
																	<td>Department</td>
																	<td>Group</td>
																	<td>Order Quantity</td>
																	<td>Supply Quantity</td>
																	<td></td>
																	<td>Alternative Medicine</td>
																	<td>Unit Rate</td>
																	<td>Total</td>
																	<td>Mcgm</td>
																</tr>
																</thead>
																<tbody id="HorderTable">
																</tbody>
																<tfoot id="HorderTableFooter">
																<tr>
																	<td colspan="8" class="text-right">Invoice Number
																	</td>
																	<td colspan="2">
																		<input type="text" name="h_invoice_number"
																			   id="h_invoice_number"
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Number"></td>
																</tr>
																<tr>
																	<td colspan="8" class="text-right">Invoice Amount
																	</td>
																	<td colspan="2"><input type="number"
																						   name="h_invoice_amount"
																						   readonly
																						   id="h_invoice_amount"
																						   class="form-control"
																						   data-valid="required"
																						   data-msg="Enter Invoice Amount">
																	</td>
																</tr>
																</tfoot>
															</table>
														</div>
													</div>
													<div class="align-items-center justify-content-end row">

														<button class="btn btn-primary">Save Order</button>
														<button id="openOrderModel1" data-toggle="modal"
																data-target="#fire-modal-order" type="button"
																class="d-none">open
														</button>
													</div>
													</form>
													</div>
											</div>
											<div class="tab-pane fade" role="tabpanel" id="HospitalOrderHistoryOrderPanel">
												 <table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
													   cellspacing="0" id="HistoryHospOrderTable" style="width:100%">
													<thead>
													<tr>
														<td>Order Number</td>
														<td>Invoice Number</td>
														<td>Zone</td>
														<td>Department</td>
							
									 
									  
						   
														<td>Date</td>
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
							<div class="tab-pane fade" role="tabpanel" id="hospitalreturnMedicinePanel">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-6 form-group">
												<label>Zone</label>
												<select id="zone_name" name="zone_name"
														class="form-control"
														style="width: 100%;" onchange="load_hospreturnOrder(this.value)">
												<option value="-1" selected disabled>Select Zone</option>
												
												</select>
											</div>
										</div>
										<form id="h_order_return_pharmeasy" method="post"
											  data-form-valid="saveHPharmeasyReturnOrder">
											<input type="hidden" name="type" value="1"/>
											<div class="row">
												<div class="table-responsive">
													<table class="table table-striped">
														<thead>
														<tr>
															<td>Medicine Name</td>
															<td>BU</td>
															<td>Return Quantity</td>
															<td>Order ID</td>
															<td></td>
															<td>Amount</td>
															<td>Return Reason</td>
														</tr>
														</thead>
														<tbody id="RorderTable">
														</tbody>
														<tfoot id="RorderTable">
														<tr>
															<td colspan="5" class="text-right">Invoice Number</td>
															<td><input type="text" name="h_invoice_return_number"
																	   id="h_invoice_return_number"
																	   class="form-control" data-valid="required"
																	   data-msg="Enter Invoice Number"></td>
														</tr>
														<!--<tr>
															<td colspan="5" class="text-right">Invoice Amount</td>
															<td><input type="number" name="invoice_return_amount"
																	   id="invoice_return_amount"
																	   class="form-control" data-valid="required"
																	   data-msg="Enter Invoice Amount"></td>
														</tr> -->
														</tfoot>
													</table>
												</div>
											</div>
											<div class="align-items-center justify-content-end row">
												<button class="btn btn-primary">Return Order</button>
												<button id="openOrderReturnModel" data-toggle="modal"
														data-target="#fire-modal-order" type="button" class="d-none">
													open
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-order"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<div class="row">
							<h3>New Order Number : <span id="orderNumber"></span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary mr-1" type="button" onclick="clearWindow()">Submit</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="View_order_history"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				 <button type="button" class="close" data-dismiss="modal" onclick="modal_hide()">&times;</button>
				
			</div>
			<div class="modal-body py-0" id="prinDivHistory">
				<h5><span id="modalTitle">Medicine History</span></h5>
				<div class="" style="float: right;">
						<button class="btn btn-primary mb-2" type="button" id="printButton" onclick="printDiv($('#prinDivHistory'))">Print</button>
					</div>
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<div id="order_history_item">

						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="View_hosporder_history"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				
				 <button type="button" class="close" data-dismiss="modal" onclick="modal_hide()">&times;</button>
				
			</div>
			<div class="modal-body py-0" id="prinDivHistory1">
				<h5><span id="modalTitle">Hospital Order History</span></h5>
				<div class="" >
						<button class="btn btn-primary mb-2" type="button" id="printButton1" onclick="printDiv11($('#prinDivHistory1'))">Print</button>
					</div>
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<div id="Hosporder_history_item">

						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>


<?php $this->load->view('_partials/footer'); ?>
<script>
	const url = "get-order-patients";
	const tableURL = "get-patient-order1";
	const r_url = "get-order-return-patients";
	const r_tableURL = "get-patient-order-return";
	const url_history = "history_patient";
	const b_url = "get-backorder-patients";
	$(document).ready(function () {
		get_order_patients(url);
		get_order_patients_history(url_history);
		get_order_return_patients(r_url);
		get_backorder_patients(b_url);
		load_patient_backorder();
		getDeparment();
		getZone();


	});

	function date_change() {
		get_order_patients(url);
		$("#medicineOrder-tab").addClass('d-none');
		$("#medicineOrderPanel").removeClass('show active');

		$("#cosumableOrder-tab").addClass('d-none');
		$("#ConsumableOrderPanel").removeClass('show active');
	}

	function backdate_change() {
		get_backorder_patients(b_url);
		load_patient_backorder();
	}

	let medicineRate = [];
	let h_medicineRate = [];
	let materialRate = [];
	function get_sum_rate(id) {
		if ($("input[data-order_id='" + id + "']").is(":checked")) {
			let rate = parseFloat($("#rate_medicine_" + id).val());
			let qty = parseFloat($("input[data-supply_order_id='" + id + "']").val());
			let total = 0;
			if (rate > 0) {
				total = qty * rate;
				let index = medicineRate.findIndex(i => i.id === id);
				if (index !== -1) {
					medicineRate[index] = {id: id, unitRate: rate.toFixed(2), total: total};
				} else {
					medicineRate.push({id: id, unitRate: rate.toFixed(2), total: total});
				}
			}
			$("#total_medicine_" + id).val(total.toFixed(2));
		}

		calculateOrder();
	}
	
	
	function get_material_sum_rate(id) {
		if ($("input[data-material_id='" + id + "']").is(":checked")) {
			let rate = parseFloat($("#rate_material_" + id).val());
			let qty = parseFloat($("input[data-supply_material_order_id='" + id + "']").val());
			let total = 0;
			if (rate > 0) {
				total = qty * rate;
				let index = materialRate.findIndex(i => i.id === id);
				if (index !== -1) {
					materialRate[index] = {id: id, unitRate: rate.toFixed(2), total: total};
				} else {
					materialRate.push({id: id, unitRate: rate.toFixed(2), total: total});
				}
			}
			$("#total_material_" + id).val(total.toFixed(2));
		}
		calculateMaterialOrder();
	}

	function get_material_total_rate(id) {
		if ($("input[data-material_id='" + id + "']").is(":checked")) {
			let total = parseFloat($("#total_material_" + id).val());
			let qty = parseFloat($("input[data-supply_material_order_id='" + id + "']").val());
			let PerUnitRate = 0;

			PerUnitRate = total / qty;
			let index = materialRate.findIndex(i => i.id === id);
			if (index !== -1) {
				materialRate[index] = {id: id, unitRate: PerUnitRate.toFixed(2), total: total};
			} else {
				materialRate.push({id: id, unitRate: PerUnitRate.toFixed(2), total: total});
			}

			$("#rate_material_" + id).val(PerUnitRate.toFixed(2));
		}
		calculateMaterialOrder();
	}

	function get_total_rate(id) {
		if ($("input[data-order_id='" + id + "']").is(":checked")) {
			let total = parseFloat($("#total_medicine_" + id).val());
			let qty = parseFloat($("input[data-supply_order_id='" + id + "']").val());
			let PerUnitRate = 0;

			PerUnitRate = total / qty;
			let index = medicineRate.findIndex(i => i.id === id);
			if (index !== -1) {
				medicineRate[index] = {id: id, unitRate: PerUnitRate.toFixed(2), total: total};
			} else {
				medicineRate.push({id: id, unitRate: PerUnitRate.toFixed(2), total: total});
			}

			$("#rate_medicine_" + id).val(PerUnitRate.toFixed(2));
		}
		calculateOrder();
	}

	function updateConsumeableCalculation(element, id) {
		let index = materialRate.findIndex(i => i.id === id);
		if (!$(element).is(":checked")) {
			document.getElementById("total_material_" + id).removeAttribute("min");
			if (index !== -1) {
				materialRate.splice(index, 1);
				calculateMaterialOrder();
			}
		} else {
			document.getElementById("total_material_" + id).min = 0.1;
			get_sum_rate(id);
		}
	}

	function updateCalculation(element, id) {
		let index = medicineRate.findIndex(i => i.id === id);
		if (!$(element).is(":checked")) {
			document.getElementById("total_medicine_" + id).removeAttribute("min");
			if (index !== -1) {
				medicineRate.splice(index, 1);
				calculateOrder();
			}
		} else {
			document.getElementById("total_medicine_" + id).min = 0.1;
			get_sum_rate(id);
		}
	}
	function h_get_sum_rate(id){
		if ($("input[data-h_order_id='" + id + "']").is(":checked")) {
			let rate = parseFloat($("#h_rate_medicine_" + id).val());
			let qty = parseFloat($("input[data-h_supply_order_id='" + id + "']").val());
			let total = 0;
			if (rate > 0) {
				total = qty * rate;
				let index = h_medicineRate.findIndex(i => i.id === id);
				if (index !== -1) {
					h_medicineRate[index] = {id: id, unitRate: rate.toFixed(2), total: total};
				} else {
					h_medicineRate.push({id: id, unitRate: rate.toFixed(2), total: total});
				}
			}
			$("#h_total_medicine_" + id).val(total.toFixed(2));
		}

		h_calculateOrder();
	}
	function h_updateCalculation(element, id) {
		let index = h_medicineRate.findIndex(i => i.id === id);
		if (!$(element).is(":checked")) {
			document.getElementById("h_total_medicine_" + id).removeAttribute("min");
			if (index !== -1) {
				h_medicineRate.splice(index, 1);
				h_calculateOrder();
			}
		} else {
			document.getElementById("h_total_medicine_" + id).min = 0.1;
			h_get_sum_rate(id);
		}
	}
	function h_calculateOrder() {
		let finalTotal = 0;
		if (h_medicineRate.length > 0) {
			h_medicineRate.forEach(m => {
				finalTotal = finalTotal + m.total;
			});
		}
		$("#h_invoice_amount").val(finalTotal.toFixed(2));
	}
	function h_get_total_rate(id) {
		if ($("input[data-h_order_id='" + id + "']").is(":checked")) {
			let total = parseFloat($("#h_total_medicine_" + id).val());
			let qty = parseFloat($("input[data-h_supply_order_id='" + id + "']").val());
			let PerUnitRate = 0;

			PerUnitRate = total / qty;
			let index = h_medicineRate.findIndex(i => i.id === id);
			if (index !== -1) {
				h_medicineRate[index] = {id: id, unitRate: PerUnitRate.toFixed(2), total: total};
			} else {
				h_medicineRate.push({id: id, unitRate: PerUnitRate.toFixed(2), total: total});
			}

			$("#h_rate_medicine_" + id).val(PerUnitRate.toFixed(2));
		}
		h_calculateOrder();
	}


	function calculateMaterialOrder() {
		let finalTotal = 0;
		if (materialRate.length > 0) {
			materialRate.forEach(m => {
				finalTotal = finalTotal + m.total;
			});
		}
		$("#cons_invoice_amount").val(finalTotal.toFixed(2));
	}

	function calculateOrder() {
		let finalTotal = 0;
		if (medicineRate.length > 0) {
			medicineRate.forEach(m => {
				finalTotal = finalTotal + m.total;
			});
		}
		$("#invoice_amount").val(finalTotal.toFixed(2));
	}
	
	function getPerUnitRate() {
		let finalTotal = parseFloat(document.getElementById("invoice_amount").value);
		let totalMedicineCount = $("input[data-order_id]:checked").length;

		let individualShare = finalTotal / totalMedicineCount;
		let medicineData = $("input[data-order_id]:checked");
		console.log(medicineData.length)
		for (let i = 0; i < medicineData.length; i++) {
			let qty = parseFloat($("input[data-supply_order_id='" + medicineData[i].dataset.order_id + "']").val());
			let total = Math.ceil(individualShare / qty);
			$("#rate_medicine_" + medicineData[i].dataset.order_id).val(total);
			let index = medicineRate.findIndex(j => j.id === medicineData[i].dataset.order_id);
			if (index !== -1) {
				medicineRate[index] = {id: medicineData[i].dataset.order_id, total: total};
			} else {
				medicineRate.push({id: medicineData[i].dataset.order_id, total: total});
			}
		}
	}

function printDiv1() {
	let divName="#prinDivHistory";
	$('#printButton').toggleClass('d-none');
	var printContents = document.querySelector(divName).innerHTML;
	// var printContents = document.getElementById('orderMedicinePanel').innerHTML;    
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
// return false;
	document.body.innerHTML = originalContents;
	
	$('#printButton').toggleClass('d-none');

	// var divContents = document.getElementById("orderMedicinePanel").innerHTML;
 //            var a = window.open('', '', 'height=500, width=500');
 //            a.document.write('<html>');
 //            a.document.write('<body > <h1>Div contents are <br>');
 //            a.document.write(divContents);
 //            a.document.write('</body></html>');
 //            a.document.close();
 //            a.print();
// var divContents = document.getElementById("orderMedicinePanel").innerHTML;
            // var divContents = document.getElementById("orderMedicinePanel").innerHTML;
            // var printWindow = window.open('', '', 'height=200,width=400');
            // printWindow.document.write('<html><head><title>DIV Contents</title>');
            // printWindow.document.write('</head><body >');
            // printWindow.document.write(divContents);
            // printWindow.document.write('</body></html>');
            // printWindow.document.close();
            // printWindow.print();
}

function printDiv(print)
{
	  $("#printme").html(print.html());
        window.print();
        $("#printme").html("");
}
function printDiv11(print)
{
	  $("#printme1").html(print.html());
        window.print();
        $("#printme1").html("");
}
	function get_menuHide()
	{
		$("#menu_hideshow").toggle('d-none');
	}
	function modal_hide()
	{
		// console.log('hiii');
		//  location.reload();
		// $("#View_order_history").modal('hide');
	}
	
</script>
