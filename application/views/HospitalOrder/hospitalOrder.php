<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.error{
		color: red;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Hospital Order Management</h1>
		</div>
		<div class="section-body">
			<div class="card">
				<div class="card-header-action">
						<ul class="nav nav-pills" id="HospitalOrderTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="createOrdertab" data-toggle="tab" href="#createHistoryOrder"
								   role="tab" onclick="getFormsInNormalPosition()"
								   aria-controls="createHistoryOrder" aria-selected="true">Create Order 
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="receiveOrderTab" data-toggle="tab" href="#receiveHistoryOrder"
								   role="tab" onclick="receiveHospitalOrderHistoryTable()" 
								   aria-controls="receiveHistoryOrder" aria-selected="false">Receive Order
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="receiveOrderTab" data-toggle="tab" href="#medConInventries"
								   role="tab" onclick="inventriesTable()" 
								   aria-controls="InventriesOrder" aria-selected="false">Medicine Consumable Inventory
								</a>
							</li>
						</ul>
					</div>
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" role="tabpanel" id="createHistoryOrder">
							
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<form id="add_hospital_order_form" method="post">
									<div class="form-row">
										<div class="form-group col-md-4">
											<label>Hospital Name</label>
											<input type="text" class="form-control" id="hospital_name"
												   name="hospital_name"
												   Placeholder="Enter Hospital Name" value="NSCI hospital" data-valid="required" data-msg="Enter value">
										</div>
										<div class="form-group col-md-4">
											<label>Department Name</label>
											<select  class="form-control" id="department" name="department">
											<option value="" selected>Select Department</option>
											<option value="Nursing">Nursing</option>
											<option value="HR">HR</option>
											<option value="IT">IT</option>
											</select>
											
										</div>
										<div class="form-group col-md-4">
											<label>Order No.</label>
											<input type="text" class="form-control" id="hospital_order_no"
												   name="hospital_order_no"
												   Placeholder="Order No." readonly>
										</div>
										
										
									</div>
									<div class="form-row">
									<div class="form-group col-md-4">
											<label>Order Create date</label>
											<input type="text" class="form-control" id="hospital_order_date"
												   name="hospital_order_date"
												   Placeholder="Order date" readonly>
										</div>
										<div class="form-group col-md-4">
											<label>Select Material Group</label>
											<select name="material_group_name" id="material_group_name"
													style="width: 100%"
													class="form-control" data-valid="required" data-msg="Enter value">
												<option>Select Material Group</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Order By User</label>
											<select name="hospital_order_by" id="hospital_order_by"
													data-valid="required" data-msg="Entervalue"
													style="width: 100%"
													class="form-control">
												<option>Order By User</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Order for Hospital</label>
											<input type="text" class="form-control "
												   id="order_for_hospital"
												   name="order_for_hospital"
												  value="yes" 
												   data-valid="required" data-msg="Enter value"/>
										</div>
										<div class="align-items-end col d-flex form-group justify-content-end">
											<button class="btn btn-primary" id="hospitalOrderCreateButton">Create Order</button>
										</div>
									</div>

								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex flex-row-reverse mb-3">
									<a class="btn btn-link d-none" style="color: #891635!important;" data-toggle="collapse" href="#newMaterialListPanel" id="newMaterialListButton"
									   role="button"
									   aria-expanded="true" aria-controls="collapseExample">
										<i class="fa fa-plus"></i> create order
									</a>
								</div>
								<div class="collapse " id="newMaterialListPanel">
									<div class="row">
										<div class="col-sm-12">
											<form id="att_material_list" name="att_medi_form" onsubmit="return false">
												<div id="att_medicine" class="p-3">
													<div class="form-row">
														<input type="hidden" id="hospital_order_id" name="hospital_order_id">
														<div class="form-group col-md-3">
															<label>Material Description</label>
															<select name="material_description" id="material_description"
																	style="width: 100%"
																	class="form-control">
																<option>Select Material description</option>
															</select>
														</div>
														<div class="form-group col-md-3">
															<label>Quantity</label>
															<input type="number" class="form-control" name="material_quantity"
																   id="material_quantity" placeholder="Enter material quantity" min="1" value="1"
																   aria-required="true">
														</div>
														<div class="form-group col-md-3">
															<label>Unit</label>
															<input type="text" class="form-control" name="material_unit"
																   id="material_unit" placeholder="Enter material unit" value="Each"
																   aria-required="true" readonly="">
														</div>
														<div  class="form-group col-md-3">
															<label>&nbsp;</label>
															<div class="d-flex flex-row-reverse">
																<button class="btn btn-primary mr-1" type="button" onclick="add_material_item_to_list()">Add to list</button>
															</div>
														</div>
														
														
													</div>
													
													
												</div>
											</form>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
												   style="width: 100%"
												   >
												<thead>
												<tr>
													<th>Material Description</th>
													<th>Quantity</th>
													<th>Unit</th>
													<th>Action</th>
												</tr>
												</thead>
												<tbody id="material_list_itemTable">
												</tbody>
											</table>
										</div>
									</div>

									<div class="d-flex flex-row-reverse">
																<button class="btn btn-primary mr-1" type="button" id="saveInOrderButton" onclick="save_hospital_order_list()">Save in order</button>
																<!-- <button class="btn btn-primary mr-1" type="button" id="saveInOrderButton" onclick="getFormsInNormalPosition()">Refresh Order</button> -->
															</div>
								</div>
							</div>
						</div>
						

					</div>
				</div>
				<div class="tab-pane fade" role="tabpanel" id="receiveHistoryOrder">
				

					<div class="col-md-12">
						<div class="col-md-4 pb-1 card-header-action" style="margin-left: auto;">
						<div class="align-items-center">
							<div class="form-group mx-2 my-0">
								<select class="form-control" id='allHospitalOrder'
										onchange="receiveHospitalOrderHistoryTable(this.value)" style="border-radius: 20px;">
									<option value="1">Pending</option>
									<option value="2">Receive</option>
									<option value="3">All</option>
								</select>
							</div>

						</div>
					</div>
						<table class="table table-hover table-striped table-bordered "
						   id="receiveHospitalOrderHistoryTable"  style="width:100%" role="grid">
						<thead style="background: #8916353b;">
						<tr>
							<th data-priority="1">Order No.</th>
							<th data-priority="2">Order Date</th>
							<th>Department</th>
							<th>Material Group</th>
							<th>Vendor Name</th>
							<th>Invoice No.</th>
							<th>Receive Date</th>
							<th>Action</th>
						</tr>
						</thead>
					</table>
					</div>
				</div>
				<div class="tab-pane fade" role="tabpanel" id="medConInventries">
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
