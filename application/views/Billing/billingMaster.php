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

	.table:not(.table-sm):not(.table-md):not(.dataTable) td, .table:not(.table-sm):not(.table-md):not(.dataTable) th {
		padding: 0 15px;
		height: 40px;
		vertical-align: middle;
		font-size: 13px;
	}


</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Billing Master</h1>
			<div class="section-header-button" style="margin-left: auto;" id="printButton">
				<button type="button" class="btn btn-primary" onclick="printDiv()">PRINT</button>
				<button type="button" class="btn btn-primary" onclick="getPatientBIllingPrintData()">BILLING PRINT
				</button>
				<button type="button" class="btn btn-primary" id="changebillbutton" onclick="change_billing_open()">
					Close Billing
				</button>
			</div>
			<style>
				.savebtn{
					margin-top: -25px;
				}
				@media print{
					.hide_class{
						display: none;
					}
					#discount_amt{
						border: none;
					}
					tbody#accomodationTableBilling tr td:nth-child(4){
						display:none
					}
					tbody#accomodationTableBilling tr td:nth-child(5){
						display:none
					}
					tbody#accomodationTableBilling tr td:nth-child(6){
						display:none
					}
					tbody#accomodationTableBilling tr td:nth-child(7) {
						display:none
					}
					tbody#accomodationTableBilling tr td.sub{
						display:block;
						font-size: 17px;
						padding: 10px;
					}
					tbody#accomodationTableBilling tr td.sub1{
						display:none;
					}

					tbody#serviceOrderCollectionTableBilling tr td:nth-child(5) {
						display:none
					}
					tbody#serviceOrderCollectionTableBilling tr td:nth-child(6) {
						display:none
					}
					tbody#serviceOrderCollectionTableBilling tr td:nth-child(7) {
						display:none
					}
					tbody#serviceOrderCollectionTableBilling tr td:nth-child(8) {
						display:none
					}
					tbody#serviceOrderCollectionTableBilling tr td input {
						border:none;

					}
					tbody#serviceOrderCollectionTableBilling tr td.sub{
						display:block;
						font-size: 17px;
						padding: 10px;
					}
					tbody#serviceOrderCollectionTableBilling tr td.sub1{
						display:none;
					}

					tbody#medicineAndConsumablesTableBilling tr td:nth-child(3) {
						display:none
					}
					tbody#medicineAndConsumablesTableBilling tr td:nth-child(4) {
						display:none
					}
					tbody#medicineAndConsumablesTableBilling tr td:nth-child(5) {
						display:none
					}
					tbody#medicineAndConsumablesTableBilling tr td:nth-child(6) {
						display:none
					}
					tbody#medicineAndConsumablesTableBilling tr td input {
						border:none
					}
					tbody#medicineAndConsumablesTableBilling tr td.sub{
						display:block;
						font-size: 17px;
						padding: 10px;
					}
					tbody#medicineAndConsumablesTableBilling tr td.sub1{
						display:none;
					}

					tbody#roombilltable tr td:nth-child(5) {
						display:none
					}
					tbody#roombilltable tr td:nth-child(6) {
						display:none
					}
					tbody#roombilltable tr td:nth-child(7) {
						display:none
					}
					tbody#roombilltable tr td:nth-child(8) {
						display:none
					}
					tbody#roombilltable tr td input{
						border:none
					}
					tbody#roombilltable tr td.sub{
						display:block;
						font-size:17px;
						padding: 10px;

					}
					tbody#roombilltable tr td.sub1{
						display:none;
					}
				}
			</style>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">
					<div class="card">
						<input type="hidden" name="billingMaster_patient_id" id="billingMaster_patient_id">
						<div class="col-md-12 card-body" style="padding-top: 20px;">
							<div class="form-row">
								<div class="form-group col-md-6">
									Name : <span id="billingMasterPatientName"></span>
								</div>
								<div class="form-group col-md-6">
									Bill No : <span id="billingNo"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									Age : <span id="patientAge"></span>
								</div>
								<div class="form-group col-md-6">
									Bill Date : <span id="billingDate"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									Patient ID : <span id="billingPatient_id"></span>
								</div>
								<div class="form-group col-md-6">
									Case Type : <span id=""> Covid Treatment</span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									Case ID : <span id="case_id"></span>
								</div>
								<div class="form-group col-md-6">
									Location : <span id=""> NSCI, Worli, Mumbai</span>
								</div>
							</div>

						</div>
						<hr/>
						<div class="col-md-12 card-body">
							<div class="form-row" style="font-size: 16px;text-decoration: underline;"><b>Stay</b></div>
							<div class="form-row">
								<div class="form-group col-md-6">
									Admission Date : <span id="admission_date"></span>
								</div>
								<div class="form-group col-md-6">
									Admission Time : <span id="admission_time"></span>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									Discharge Date : <span id="discharge_date"></span>
								</div>
								<div class="form-group col-md-6">
									Discharge Time : <span id="discharge_time"></span>
								</div>
							</div>
						</div>
						<hr/>

						<div class="row card-body div1 ">
							<div class="col-md-12">
								<div class="form-view" style="font-size: 16px;text-decoration: underline;"><strong>Accomodation</strong></div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="">
										<thead>
										<tr>
											<td>Start Date/Time</td>
											<td>Service Description</td>
											<td>Qty</td>
											<td class="hide_class">Rate ( Rs)</td>
											<td class="hide_class">Amount ( Rs)</td>
											<td class="hide_class">Discount</td>
											<td class="hide_class">Delete</td>
											<td>Final Amount  ( Rs)</td>
										</tr>
										</thead>
										<tbody id="accomodationTableBilling">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<hr class="div1" />
						<div class="row card-body div2">
							<div class="col-md-12">
								<div class="form-view" style="font-size: 16px;text-decoration: underline;"><strong>Doctor Consultation</strong></div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="doctorConsulationTableBilling">
										<thead>
										<tr>
											<td>Date/Time</td>
											<td>Service Description</td>
											<td>Service Order No.</td>
											<td>Qty</td>
											<td class="hide_class">Rate ( Rs)</td>
											<td class="hide_class">Amount ( Rs)</td>
											<td class="hide_class">Discount</td>
											<td class="hide_class">Delete</td>
											<td>Final Amount  ( Rs)</td>


										</tr>
										</thead>
										<tbody id="roombilltable">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<hr class="div2" />
						<div class="row card-body div3">
							<div class="col-md-12">
								<div class="form-view som" style="font-size: 16px;text-decoration: underline;"><strong>Service Orders</strong></div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="">
										<thead>
										<tr>
											<td>Date/Time</td>
											<td>Service Description</td>
											<td>Service Order No.</td>
											<td>Qty</td>
											<td class="hide_class">Rate ( Rs)</td>
											<td class="hide_class">Amount ( Rs)</td>
											<td class="hide_class">Discount</td>
											<td class="hide_class">Delete</td>
											<td>Final Amount  ( Rs)</td>
										</tr>
										</thead>
										<tbody id="serviceOrderCollectionTableBilling">

										</tbody>
									</table>
								</div>
							</div>

						</div>
						<hr class="div3" />
						<div class="row card-body div4">

							<div class="col-md-12">
								<div class="form-view" style="font-size: 16px;text-decoration: underline;"><strong>Medication and Consumables</strong></div>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="">
										<thead>
										<tr>
											<td>S. No.</td>
											<td>Voucher Reference Number</td>
											<td>Date / Time</td>
											<td class="hide_class">Amount ( Rs)</td>
											<td class="hide_class">Discount</td>
											<td class="hide_class">Delete</td>
											<td>Final Amount  ( Rs)</td>
										</tr>
										</thead>
										<tbody id="medicineAndConsumablesTableBilling">

										</tbody>
									</table>
								</div>
							</div>

						</div>
						<hr class="div4" />
						<div class="row card-body mt-10 div5">

							<div class="col-md-12">
								<div class="form-view"><strong>Grand Total : <span id="subTotal"></span></strong></div>
								<div class="form-view hide_class"><strong>Discount : <form id="percentage_form"><input type="radio" name="discount" value="1" checked="" id="per_btn"> Percentage <input type="radio" name="discount" value="2" id="amt_btn"> Amount <input type="number" name="discount_amt" id="discount_amt" min="0" value="0"> <button type="button" onclick="save_Percentage()" class="btn btn-link"><i class="fa fa-save"></i></button></form></strong></div>
								<div class="form-view" style="font-size: 20px;"><strong>Payable Amount : <span id="grandTotal"></span></strong> </div>

							</div>
						</div>


					</div>
					<div id="billingPrint" style="display: none;"></div>
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
		$("#billingMaster_patient_id").val(patient_id);
		$("#patient_list").val(patient_id);
		$("#p_id").val(patient_id);

		getPatientBIllingData();
		getAccomodationTableBIllingData();
		getmedicineAndConsumablesTableBilling();
		getserviceOrderCollectionTableBilling();
		getGrandTotal();
		check_billing_status();
	});

	function getAccomodationTableBIllingData() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("getAccomodationTableBIllingData")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id: p_id},
			success: function (result) {

				if (result.status == 200) {
					$("#accomodationTableBilling").html(result.data);
				} else {
					$("#accomodationTableBilling").html(result.data);
				}
			}
		});
	}

	function getserviceOrderCollectionTableBilling() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("getserviceOrderCollectionTableBilling")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id: p_id},
			success: function (result) {

				if (result.status == 200) {
					$("#serviceOrderCollectionTableBilling").html(result.data);
					$("#roombilltable").html(result.data_consult);
				} else {
					$("#serviceOrderCollectionTableBilling").html(result.data);
					$("#roombilltable").html(result.data_consult);
				}
			}
		});
	}

	function getmedicineAndConsumablesTableBilling() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("getmedicineAndConsumablesTableBilling")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id: p_id},
			success: function (result) {

				if (result.status == 200) {
					$("#medicineAndConsumablesTableBilling").html(result.data);
				} else {
					$("#medicineAndConsumablesTableBilling").html(result.data);
				}
			}
		});
	}

	function getPatientBIllingData() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("getPatientBIllingData")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id: p_id},
			success: function (result) {

				if (result.status == 200) {
					var userdata = result.data;
					$("#billingMasterPatientName").html(result.patient_name);
					$("#billingNo").html('BL_' + result.patient_id);
					// console.log(result.patientAge);
					if (result.patient_age == 0) {
						$("#patientAge").html("DOB Not available");
					} else {
						$("#patientAge").html(result.patient_age);
					}

					$("#billingDate").html('<?php echo date('d M Y'); ?>');
					if (userdata[0]['adhar_no'] != null || userdata[0]['adhar_no'] !== "") {
						$("#billingPatient_id").html(userdata[0]['adhar_no']);
					}

					$("#case_id").html(result.patient_id);
					$("#admission_date").html(result.admission_date);
					$("#admission_time").html(result.admission_time);
					$("#discharge_date").html(result.discharge_date);
					$("#discharge_time").html(result.discharge_time);
					$("#discount_amt").val(result.discount_amt);
					if (result.discount_type != null) {
						var radios = document.getElementsByName('discount');
						for (var j = 0; j < radios.length; j++) {
							if (radios[j].value == result.discount_type) {
								radios[j].checked = true;
								break;
							}
						}
					}

				} else {
					app.errorToast('No data found');
				}
			}
		});
	}

	function add_order() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("addOrderRoom")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status == 200) {
					alert(result.body);
				} else {
					alert(result.body);
				}
			}
		});
	}

	function change_billing_open() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("ChangeBillingOpen")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status == 200) {

					check_billing_status();
					alert(result.body);
				} else {
					alert(result.body);
				}
			}
		});
	}

	function check_billing_status() {
		var p_id = localStorage.getItem("patient_id");
		$.ajax({
			type: "POST",
			url: '<?= base_url("check_billing_status")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status == 200) {
					var value = result.value;
					if (value == 1) {

						$("#medication_list").hide();
						$("#serviceOrder_list").hide();
						$("#billinginfo_list").hide();
						$("#consumableOrder_list").hide();
						$("#assign_bed_btn").prop('disabled', true);
						$("#check_order_btn").prop('disabled', true);
						$("#submit_btn").prop('disabled', true);
						$("#changebillbutton").html("Billing Already Close");

					} else {
						$("#medication_list").show();
						$("#serviceOrder_list").show();
						$("#billinginfo_list").show();
						$("#consumableOrder_list").show();
						$("#changebillbutton").html("Close Billing");
					}
				} else {

				}
			}
		});
	}

	function getGrandTotal() {
		var serviceOCSubtotal = $("#serviceOCSubtotal").val();
		var accomodationSubtotal = $("#accomodationSubtotal").val();
		var medicineSubtotal = $("#medicineSubtotal").val();
		var doctorconsultsubtotal = $("#doctorconsultsubtotal").val();
		// var serviceTotal=$("#serviceOCSubtotal").val();

		var grand_total = parseInt(serviceOCSubtotal) + parseInt(accomodationSubtotal) + parseInt(medicineSubtotal) + parseInt(doctorconsultsubtotal);
		// var discount=grand_total*0;
		var dis_type = document.querySelector('input[name="discount"]:checked').value;
		if (dis_type == 1) {
			var discount = grand_total * ((100 - $("#discount_amt").val()) / 100);
		} else {
			var discount = grand_total - $("#discount_amt").val();
		}

		$("#subTotal").html(grand_total);
		$("#grandTotal").html(discount);
	}
</script>
<script type="text/javascript">
	function getPatientBIllingPrintData() {
		var p_id = $("#billingMaster_patient_id").val();
		$.ajax({
			type: "POST",
			url: '<?= base_url("getPatientBIllingPrintData")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id: p_id},
			success: function (result) {

				if (result.status == 200) {
					var userdata = result.data;

					$("#billingPrint").html(userdata);
				} else {
					// app.errorToast('No data found');
				}
			}
		});
		let divName = "#billingPrint";
		var printContents = document.querySelector(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}

	function save_Percentage() {
		var p_id = $("#billingMaster_patient_id").val();
		var formdata = document.getElementById('percentage_form');
		let formData = new FormData(formdata);
		formData.set("p_id", p_id);

		$.ajax({
			type: "POST",
			url: '<?= base_url("savePatientBIllingDiscountData")?>',
			dataType: "json",
			data: formData,
			processData: false,
			contentType: false,
			success: function (result) {

				if (result.status == 200) {
					// var userdata=result.data;
					app.successToast('discount changes saved');
					// $("#billingPrint").html(userdata);
				} else {
					app.errorToast('No data Changes');
				}
			}
		});
	}
	$(document).ready(function(){
		var subtotalvalue1 = $('#accomodationSubtotal').val();
		var subtotalvalue2 = $('#doctorconsultsubtotal').val();
		var subtotalvalue3 = $('#serviceOCSubtotal').val();
		var subvalue1 = $('#serviceOCSubtotal1').val();
		var subvalue2 = $('#serviceOCSubtotal2').val();
		var subvalue3 = $('#serviceOCSubtotal3').val();
		var subvalue4 = $('#serviceOCSubtotal4').val();
		var subvalue5 = $('#serviceOCSubtotal5').val();
		var subtotalvalue4 = $('#medicineSubtotal').val();
		if(subtotalvalue1 == 0)
		{
			$('.div1').addClass('hide_class');
		}
		if(subtotalvalue2 == 0)
		{
			$('.div2').addClass('hide_class');
		}
		if(subtotalvalue3 == 0)
		{
			$('.div3').addClass('hide_class');
		}
		if(subvalue1 == 0)
		{
			$('.ordercollection1').addClass('hide_class');
		}
		if(subvalue2 == 0)
		{
			$('.ordercollection2').addClass('hide_class');
		}
		if(subvalue3 == 0)
		{
			$('.ordercollection3').addClass('hide_class');
		}
		if(subvalue4 == 0)
		{
			$('.ordercollection4').addClass('hide_class');
		}
		if(subvalue5 == 0)
		{
			$('.ordercollection5').addClass('hide_class');
		}
		if(subtotalvalue4 == 0)
		{
			$('.div4').addClass('hide_class');
		}
		if(subtotalvalue1==0 && subtotalvalue2==0 && subtotalvalue3==0 && subtotalvalue4==0)
		{
			$('.div5').addClass('hide_class');
		}
	});
</script>
