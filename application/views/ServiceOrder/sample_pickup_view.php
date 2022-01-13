<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<style>
	table.dataTable tbody td {
		word-break: break-word;
		vertical-align: top;
	}
	.main-content
	{
		width: 100%!important;
	}
</style>
<div class="main-content" style="width: 100%;padding-left: 2px;">
	<section class="section">
		<div class="section-header card-primary" style="border-top: 2px solid #891635;">
			<h1 style="color: #891635">Pathology Sample Details</h1>
		</div>
		<div class="section-body">
			<div class="card">
			<ul class="nav nav-pills" id="PathlogyTabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="samplecollectionT" data-toggle="tab" href="#SampleCollectionPanel"
								   role="tab"
								   aria-controls="SampleCollectionPanel" aria-selected="true">Sample Collection </a>
							</li>
	
							<li class="nav-item">
								<a class="nav-link" id="historysampleT" data-toggle="tab" onclick="load_sample_history()" href="#SampleHistoryPanel"
								   role="tab"
								   aria-controls="SampleHistoryPanel" aria-selected="false">History</a>
							</li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" role="tabpanel" id="SampleCollectionPanel">
				<div class="card-header">
					<div class="col-md-12">
						<div class="row justify-content-end">
						<button class="btn btn-icon btn-primary mr-1" type="button" onclick="Open_modal()">Upload</button>
							
							<button class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#fire-modal-pickup_download" type="button">View Sample Collection Order</button>
						<!--	<button class="btn btn-primary btn-sm" type="button" onclick="download_excel()">Download Excel</button>-->
							<button class="btn btn-primary btn-sm" type="button" onclick="click_button()">Sample Collection</button>
						</div>
						<div class="row">
							<div class="form-group mx-2 my-0">
								<select class="form-control" id='psampleAllPatient'
										onchange="loadTable()"
										style="width: 100%;margin-top:-30px; ">
								</select>
							</div>
						</div>
					</div>

				</div>
				<form id="saveSampleCollection" data-form-valid="saveCollection">
					<div class="card-body">

						<table class="table table-bordered table-stripped" id="pathologyPickupTable" style="width: 100%">
							<thead>
							<tr>
								<th data-priority="1"><input type="checkbox" name="select_all" value="-1" id="example-select-all" class="custom-control custom-checkbox"></th>
								<th data-priority="2">Patient Name</th>
								<th>Service Order No.</th>
								<th>Service Code</th>
								<th>Service Name</th>

							</tr>
							<!-- <tr>
								<th></th>
								<th>Patient Name</th>
								<th></th>
								<th></th>
								<th></th>
							</tr> -->
							</thead>
							<tbody>
							</tbody>
							<tfoot id="footerButton">
							<tr>
								<td colspan="5" class="text-right">
									<button id="save_button" style="display:none" class="btn btn-primary btn-sm">Sample Collection</button>

									<button id="openOrderModel" data-toggle="modal"
											data-target="#fire-modal-pickup" type="button" class="d-none">open
									</button>
								</td>
							</tr>
							</tfoot>
						</table>
					</div>
				</form>
			</div>
			<div class="tab-pane fade" role="tabpanel" id="SampleHistoryPanel">
			
			<div class="col-md-12">
				<div class="row justify-content-end">
					<!-- <div class="align-items-center ">
							
							<div class="form-group mx-2 my-0">
								<select name="HistoryPatient" id="HistoryPatient" class="form-control" onchange="load_sample_history()" style="border-radius: 20px;">
									<option selected disabled>Select Patient</option>
									
								</select>
							</div>
					</div> -->
				<div class="row justify-content-end">
					<div class="align-items-center ">
							<div class="form-group mx-2 my-0">
								<select name="historyStatus_filter" id="historyStatus_filter" class="form-control" onchange="load_sample_history()" style="border-radius: 20px;">
									<option value="1">Pending</option>
									<option value="2">Completed</option>
									<option value="0">All</option>
								</select>
							</div>
							
					</div>
					<div class="align-items-center ">
							<div class="form-group mx-2 my-0">
								<button class="btn btn-primary" type="button" onclick="downloadSampleHistory()" style="margin-top: 4px;"><i class="fa fa-download"></i> Export Excel</button>
							</div>
					</div>

				</div>
					<div class="col-sm-12">
							<table class="table table-hover table-striped table-bordered"
							   id="HistorySampleTable" style="width:100%">
							<thead>
							<tr>

								<th>Patient ID</th>
								<th data-priority="1">Patient Name</th>
								<td data-priority="2">Service ID</td>
								<td>Service Name</td>
								<td> Date</td>
								<td>Order Id</td>
								<td> Status</td>


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
	</section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-pickup_download"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<div class="col-md-12">
							<table class="table table-hover table-striped table-bordered dataTable no-footer " id="sampleOrderTable" style="width: 100%">
								<thead>
									<tr>

										<th>Order Number</th>
										<th>Date</th>
										<th>Action</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-pickup"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
	
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<div class="row">
						<input type="hidden" id="orderNumberhideen" name="orderNumberhideen">
							<h3>New Order Number : <span id="orderNumber"></span></h3>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<a href="" id="dwn_file" class="btn btn-primary"  >Submit</a>
			
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="file_save_modal"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
		<div class="modal-header">
		<h4>Upload File</h4>
		</div>
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body"><hr>
						<div class="" align="center">
						<form id="excelFileupload" class="form mr-1" method="post">
								<div class="form-inline" align="center">
									<input type="file" name="userfile" id="sample_upload_file" class="d-none" onchange="$('#sampleUploadSave').click()">
									<button id="sampleUploadSave" class="d-none"></button>
									<button class="btn btn-icon btn-primary" type="button" onclick="$('#sample_upload_file').click()">Upload</button>
								
								</div>
							</form>
							
						</div><br>
						<div id="fileuploadedData"></div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalafterfileUpload"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body py-0" style="overflow : none;">
				<div class="card my-0 shadow-none">
					<div class="card-body"><br>
						<div class="row">
							<div id="data_insert"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-info mr-1" type="button" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="SampleHistoryItemModal"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body py-0" style="overflow : none;">
				<div class="card my-0 shadow-none">
					<div class="card-body"><br>
						<div class="row">
							<div class="col-md-12">
							<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
							   cellspacing="0" id="HistorySampleItemTable" style="width:100%">
							<thead>
							<tr>
								<td>Patient Name</td>
								<td>Service Name</td>
								<td>Service OrderId</td>
								<td>Price</td>
								<td>Sample Pickup Date</td>
								<td>Status</td>
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
			<div class="modal-footer">
				<button class="btn btn-info mr-1" type="button" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
	$(document).ready(function () {
		get_zone();
		
	})

	$('#excelFileupload').validate({
		rules: {
			file_ex1: {
				required: true
			}
		},
		messages: {
			file_ex1: {
				required: "Select Excel File"
			}
		},
		errorElement: 'span',
		submitHandler: function (form) {

			if($('#sample_upload_file').val()) {


				var form_data = document.getElementById('excelFileupload');
				var Form_data = new FormData(form_data);
				$.ajax({
					type: "POST",
					url: baseURL + "add_Excel_file",
					dataType: "json",
					data: Form_data,
					contentType: false,
					processData: false,
					success: function (result) {
						if (result.status === 200) {
							app.successToast(result.body);
							get_file_uploaded_table();
							modalafterfileUpload(result.insertCount,result.existingCount,result.duplicate_table);
						} else if(result.status === 202) {
							app.errorToast(result.body);
							
						}else{
							app.errorToast(result.body);
							modalafterfileUpload(result.insertCount,result.existingCount,result.duplicate_table);
						}
						$('#excelFileupload').trigger('reset')
					}, error: function (error) {
						console.log('Logged ---> ', error);
						app.errorToast('something went wrong');
						$('#excelFileupload').trigger('reset')
					}
				});
			}
		}
	});
	
	function Open_modal(){
		$("#file_save_modal").modal('show');
		get_file_uploaded_table();
	}
	
	function get_file_uploaded_table(){
		$.ajax({
					type: "POST",
					url: baseURL + "getuploadedFiles",
					dataType: "json",
					
					contentType: false,
					processData: false,
					success: function (result) {
						if (result.status === 200) {
							$("#fileuploadedData").html(result.data);
							$("#fileTable").DataTable();
							
						} else {
							$("#fileuploadedData").html("");
						}
						
					}, error: function (error) {
						console.log('Logged ---> ', error);
						app.errorToast('something went wrong');
						
					}
				});
	}
	function modalafterfileUpload(insert,duplicate,table){
		$("#modalafterfileUpload").modal('show');
		
		$("#data_insert").html("<h4>Successfull Entries : " +insert+"</h4><br><h4>Duplicate Entries : " +duplicate+"</h4>");
		//$("#dup_table").DataTable();
	}	
	
	function click_button(){
		//save_button
		$( "#save_button" ).click();
	}
	
	function download_excel_new(){
		var id=$("#orderNumberhideen").val();
	}
</script>
