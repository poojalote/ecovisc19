<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Medicine Consumable Inventory</h1>
		</div>
		<div class="section-body">
			<div class="card">
				
				<div class="card-body">
					
			
				
				<table class="table table-hover table-striped table-bordered "
						   id="InventriTableData"  style="width:100%" role="grid">
						<thead style="background: #8916353b;">
						<tr>
							<th data-priority="1">Name</th>
							<th data-priority="2">Quantity</th>
							<th >Consumed</th>
							<th >Balance</th>
							<th>Action</th>
						</tr>
						</thead>
					</table>
				
			

				</div>
			</div>
		</div>
	</section>
</div>

<!--prescription modal -->
<div class="modal fade" id="hospitalOrderModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Hospital Order Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						
							<input type="hidden" name="pName" id="schedulePrescriptionName">
							<input type="hidden" name="patient_id" id="schedulePrescriptionForPatient">
							<div class="form-row">
								<div class="form-group col-md-5">
									<label for="viewMaterialName">Material Group</label>
									<input type="text" class="form-control" name="viewMaterialGroupName"
										   id="viewMaterialGroupName" readonly>
								</div>

								<div class="align-items-baseline col-md-2 d-flex flex-column form-group justify-content-end">
									<button class="btn btn-primary mr-1" type="button" data-toggle="collapse" href="#newMaterialVireOrderListPanel" id="newMaterialViewOrderListButton"
									   role="button"
									   aria-expanded="true" aria-controls="collapseExample">
										<i class="fa fa-plus"></i> add
									</button>
									
								</div>
								<div class="align-items-baseline col-md-2 d-flex flex-column form-group justify-content-end">
									<button class="btn btn-primary mr-1" type="button" data-toggle="collapse" href="#receiveMaterialVireOrderListPanel" id="receiveMaterialViewOrderListButton"
									   role="button"
									   aria-expanded="true" aria-controls="receiveMaterialVireOrderListPanel">
										<i class="fa fa-file"></i> receive
									</button>
									
								</div>
								<div class="align-items-baseline col-md-2 d-flex flex-column form-group justify-content-end">
									<button class="btn btn-primary mr-1" type="button" data-toggle="collapse" onclick="getDataReturn()" href="#returnMaterialVireOrderListPanel" id="returnMaterialViewOrderListButton"
									   role="button"
									   aria-expanded="true" aria-controls="returnMaterialVireOrderListPanel">
										<i class="fa fa-file"></i> Return
									</button>
									
								</div>
								
							</div>
							<div class="form-row">
								
								<div class="collapse " id="returnMaterialVireOrderListPanel">
									<form id="returnOrderForm" name="returnOrderForm" method="post" onsubmit="return false">
												<div id="" class="p-3">
													<hr/>
													<input type="hidden" id="return_hospital_order_id" name="return_hospital_order_id">
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Select Item</label>
															<select class="form-control" name="ret_item_list"id="ret_item_list" onchange="getBalancequantity(this.value)">
															<option selected disabled >Select Item</option>
															</select>
														</div>
														<div class="form-group col-md-6">
															<label>Invoice No.</label>
															<input type="number" class="form-control" readonly name="ret_order_invoice_no"
																   id="ret_order_invoice_no"  min="1"
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Vendor Name</label>
															<input type="text" class="form-control" name="ret_vendor_name"
																   id="ret_vendor_name" Readonly
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Invoice Amount</label>
															<input type="number" class="form-control" name="ret_invoice_amount"
																   id="ret_invoice_amount" placeholder="Enter Return Invoice Amount" 
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Return Quanity</label>
															<input type="number" class="form-control" name="ret_invoice_quantity"
																   id="ret_invoice_quantity" placeholder="Enter Return Invoice Quanity"
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Invoice Attachment</label>
															<input type="file" class="form-control" name="ret_invoice_attachment[]"
																   id="ret_invoice_attachment" placeholder="Select Invoice Attachment"
																   aria-required="true">
														</div>
														<div  class="form-group col-md-6">
															
														</div>
														<div  class="form-group col-md-6">
															<label>&nbsp;</label>
															<div class="d-flex flex-row-reverse">
																<button class="btn btn-primary mr-1 form-control" type="submit">Return</button>
															</div>
														</div>
														
														
													</div>
													
													
												</div>
											</form>
								</div>
								<div class="collapse " id="newMaterialVireOrderListPanel">
									<form id="newMaterialOrderListForm" name="att_medi_form" onsubmit="return false">
												<div id="att_medicine" class="p-3">
													<hr/>
													<div class="form-row">
														<input type="hidden" id="view_hospital_order_id" name="view_hospital_order_id">
														<input type="hidden" id="view_hospital_group_id" name="view_hospital_group_id">
														<div class="form-group col-md-6">
															<label>Material Description</label>
															<select name="view_material_description" id="view_material_description"
																	style="width: 100%"
																	class="form-control">
																<!-- <option>Select Material description</option> -->
															</select>
														</div>
														<div class="form-group col-md-2">
															<label>Quantity</label>
															<input type="number" class="form-control" name="view_material_quantity"
																   id="view_material_quantity" placeholder="Enter material quantity" min="1" value="1"
																   aria-required="true">
														</div>
														<div class="form-group col-md-2">
															<label>Unit</label>
															<input type="text" class="form-control" name="view_material_unit"
																   id="view_material_unit" placeholder="Enter material unit" value="Each"
																   aria-required="true" readonly="">
														</div>
														<div  class="form-group col-md-2">
															<label>&nbsp;</label>
															<div class="d-flex flex-row-reverse">
																<button class="btn btn-primary mr-1 form-control" type="submit">Add</button>
															</div>
														</div>
														
														
													</div>
													
													
												</div>
											</form>
								</div>
								
								<div class="collapse " id="receiveMaterialVireOrderListPanel">
									<form id="receiveOrderForm" name="receiveOrderForm" method="post" onsubmit="return false">
												<div id="" class="p-3">
													<hr/>
													<div class="form-row">
														<input type="hidden" id="receive_hospital_order_id" name="receive_hospital_order_id">
														
														<div class="form-group col-md-6">
															<label>Invoice No.</label>
															<input type="number" class="form-control" name="hos_order_invoice_no"
																   id="hos_order_invoice_no" placeholder="Enter Invoice No." min="1"
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Vendor Name</label>
															<input type="text" class="form-control" name="hos_vendor_name"
																   id="hos_vendor_name"  placeholder="Enter Vendor Name"
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Invoice Amount</label>
															<input type="number" class="form-control" name="hos_invoice_amount"
																   id="hos_invoice_amount" readonly placeholder="Enter Invoice Quantity" 
																   aria-required="true">
														</div>
														<div class="form-group col-md-6">
															<label>Invoice Attachment</label>
															<input type="file" class="form-control" name="hos_invoice_attachment[]"
																   id="hos_invoice_attachment" placeholder="Select Invoice Attachment"
																   aria-required="true">
														</div>
														<div  class="form-group col-md-6">
															
														</div>
														<div  class="form-group col-md-6">
															<label>&nbsp;</label>
															<div class="d-flex flex-row-reverse">
																<button class="btn btn-primary mr-1 form-control" type="submit">Receive</button>
															</div>
														</div>
														
														
													</div>
													
													
												</div>
											</form>
								</div>
							</div>
						
					</div>
				</div>
			
			<form id="receiveOrderTableForm" name="receiveOrderTableForm" method="post" onsubmit="return false">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
							   cellspacing="0" id="hospitalOrderMaterialListTable" style="width:100%">
							<thead>
							<tr>
								<td>Material Description</td>
								<td>Quanity</td>
								<td>Unit</td>
								<td>Amount</td>
								<td>Action</td>
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

<div class="modal fade" id="Modal_Consume_Medicine"  role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Consume Medicine</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
					<div class="col-md-12">
						<form method="post" id="consumeForm" name="consumeForm">
						<input type="hidden" id="material_item_id" name="material_item_id">
						<div class="form-group col-md-12">
							<label>Select Zone</label>
							<select name="selectZone" id="selectZone"
									style="width: 100%"
									class="form-control" onchange="getZonePatient(this.value)">
								<!-- <option>Select Material description</option> -->
							</select>
						</div>
						<div class="form-group col-md-12">
							<label>Select Patient</label>
							<select name="patientId" id="patientId"
									style="width: 100%"
									class="form-control">
								<!-- <option>Select Material description</option> -->
							</select>
						</div>
						<div class="form-group col-md-12">
						<label>Quantity</label>
						<input type="number" class="form-control" name="quantityToPatient"
							   id="quantityToPatient" placeholder="Enter material quantity" min="1" 
							   aria-required="true">
						</div>
						<button type="submit" class="btn btn-primary"> Save</button>
						
						</form>
							
										
								</div>
						
					</div>
				</div>
			
			
				
				

			</div>
		</div>
		
<div class="modal fade" id="Modal_summarised_history"  role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Summarised History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
					<div class="col-md-12" id="historyTableData">
						
						
					</div>
				</div>
			
			
				
				

			</div>
		</div>
		</div>
		<div class="modal fade" id="Modal_Detail_history"  role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Detail History</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
					<div class="col-md-12" id="historyDetailTableData">
						
						
					</div>
				</div>
			
			
				
				

			</div>
		</div>
		</div>
		<div class="modal fade" id="Modal_printDiv"  role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>Print Order</h4>
						<button type="button" id="close_m" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<button class="btn btn-primary" align="center" type="button" style="margin-left: auto;" id="printButton" onclick="print_div()">PRINT
					</button>
							<div  class="aa" align="center" id="printDiv">
								
								
							</div>
						</div>
					</div>
		</div>
		</div>
<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
	let prescriptionArray=[];
	$(document).ready(function () {
inventriesTable();


	});
	
	function print_div() {
		
		   
	
	let divName=".aa";
	$('#printButton').toggleClass('d-none');
	var printContents = document.querySelector(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;
	$('#printButton').toggleClass('d-none');
	 $('#Printorder_btn').click();
}

</script>
