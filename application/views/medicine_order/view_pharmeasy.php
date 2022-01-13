<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Order Medicine Details</h1>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card">

						<div class="card-header-action">
							<ul class="nav nav-pills" id="pharmeasyTabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="orderMedicine" data-toggle="tab"
									   href="#orderMedicinePanel"
									   role="tab"
									   aria-controls="orderMedicinePanel" aria-selected="true">Order Medicine </a>
								</li>

								<li class="nav-item">
									<a class="nav-link" id="returnMedicine" data-toggle="tab"
									   href="#returnMedicinePanel"
									   role="tab"
									   aria-controls="returnMedicinePanel" aria-selected="false">Return Medicine</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="historyMedicine" onclick="load_patient_order_history()"
									   data-toggle="tab"
									   href="#historyMedicinePanel"
									   role="tab"
									   aria-controls="returnMedicinePanel" aria-selected="false">History Medicine</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content">
								<div class="tab-pane fade show active" role="tabpanel" id="orderMedicinePanel">
									<div class="col-md-12">
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
													<div class="row">
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
																</tr>
																</thead>
																<tbody id="orderTable">
																</tbody>
																<tfoot id="orderTableFooter">
																<tr>
																	<td colspan="5" class="text-right">Invoice Number
																	</td>
																	<td><input type="text" name="invoice_number"
																			   id="invoice_number"
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Number"></td>
																</tr>
																<tr>
																	<td colspan="5" class="text-right">Invoice Amount
																	</td>
																	<td><input type="number" name="invoice_amount"
																			   id="invoice_amount"
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
																</tr>
																</thead>
																<tbody id="orderConsumableTable">
																</tbody>
																<tfoot id="orderConsumableTableFooter">
																<tr>
																	<td colspan="5" class="text-right">Invoice Number
																	</td>
																	<td><input type="text" name="invoice_number"
																			   id="cons_invoice_number"
																			   class="form-control"
																			   data-valid="required"
																			   data-msg="Enter Invoice Number"></td>
																</tr>
																<tr>
																	<td colspan="5" class="text-right">Invoice Amount
																	</td>
																	<td><input type="number" name="invoice_amount"
																			   id="cons_invoice_amount"
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
								
								<div class="tab-pane fade" role="tabpanel" id="historyMedicinePanel">
									<div class="col-md-6 form-group">
										<label>Patient Name</label>
										<select id="patient_history" name="patient_history" class="form-control"
												style="width: 100%;" onchange="load_patient_order_history(this.value)">
										</select>

									</div>
									<div class="col-md-12">
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
				<h5>Medicine History</h5>
			</div>
			<div class="modal-body py-0">
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


<?php $this->load->view('_partials/footer'); ?>
<script>
	const url = "get-order-patients";
	const tableURL = "get-patient-order";
	const r_url = "get-order-return-patients";
	const r_tableURL = "get-patient-order-return";
	const url_history = "history_patient";
	$(document).ready(function () {
		get_order_patients(url);
		get_order_patients_history(url_history);
		get_order_return_patients(r_url);

	});

	function date_change() {
		get_order_patients(url);
		$("#medicineOrder-tab").addClass('d-none');
		$("#medicineOrderPanel").removeClass('show active');

		$("#cosumableOrder-tab").addClass('d-none');
		$("#ConsumableOrderPanel").removeClass('show active');
	}
</script>
