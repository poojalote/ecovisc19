<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>

	.select2-container
	{
		width: 100%!important;
	}
</style>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<!-- <div class="section-header" style="border-top: 2px solid #891635">
			<h1> Sample Collection</h1>
		</div> -->
		<div class="card card-primary" style="border-top: 2px solid #891635">
			<div class="section-header card-primary" style="border-top: 2px solid #891635">
				<h1 style="color: #891635">Lab Master Data</h1>
			</div>
			<section id="profileSection">

				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				  <li class="nav-item" role="presentation">
				    <button class="nav-link active" id="pills_parent_data" data-bs-toggle="pill" data-bs-target="#div_parent_data" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Parent Setup</button>
				  </li>
				  <li class="nav-item" role="presentation">
				    <button class="nav-link" id="pills_child_data" data-bs-toggle="pill" data-bs-target="#div_child_data" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Child Setup</button>
				  </li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
				  <div class="" id="div_parent_data" >
				  	
				  	<form id="accessMgmtForm" action="post">
						<div class="row  form-group">
							<div class="col-md-6">
								<label for="">Select Branch </label>
								<select class="form-control" name="branches" id="branches" onchange="getHtmlForm(this.value)">
									<option disabled>Select Branch</option>
								</select>
							</div>
							<div class="col-md-6 text-right">
								<button type="button" onclick="saveFormData()" class="btn btn-primary mt-4">Save</button>
							</div>
						</div>
						<div class="col-md-12  form-group" id="">
							<div class="">
								<h6 >Select Lab Admin Master Test</h6>
								<input type="checkbox" id="selectall"> <label for="selectall">All</label>
							</div>
							<div id="query_data" class="row">

							</div>

						</div>
					</form>

				  </div>
				  <div class="" id="div_child_data">
						<form id="accessMgmtForm_1" action="post">
						<div class="row form-group">
							<div class="col-md-4 form-group">
								<label for="">Select Branch</label>
								<select class="form-control" name="branch_id" id="branch_id" onchange="getHtmlFormChild(this.value)">
									<!-- <option disabled>Select Branch</option> -->
								</select>
							</div>

							<div class="col-md-4">
								<label for="">Select Lab Master Data</label>
								<select name="lab_master_test"  class="form-control" id="lab_master_test" onchange="getHtmlLabAdminChildTest(this.value)">
									<option> Select Lab Master Data</option>
								</select>
							</div>
							<div class="col-md-4 text-right">
								<button type="button" onclick="saveFormChildData()" class="btn btn-primary mt-4">Save</button>
							</div>
						</div>
						<div class="col-md-12 form-group" id="">
							<div class="">
								<h6 >Select Lab Child Test</h6>
								<input type="checkbox" id="selectall"> <label for="selectall">All</label>
							</div>
							<div id="query_data_1" class="row">

							</div>

						</div>
					</form>
				  </div>
				  
				</div>
				</section>
			<div class="card-body">



				<!-- <div class="" id="tabChildSetup">
					<form id="accessMgmtForm" action="post">
						<div class="row">
							<div class="col-md-6">
								<label for="">Select Branch</label>
								<select name="branches" id="branches" onchange="getHtmlForm(this.value)">
									<option disabled>Select Branch</option>
								</select>
							</div>
							<div class="col-md-6 text-right">
								<button type="button" onclick="saveFormData()" class="btn btn-primary mt-4">Save</button>
							</div>
						</div>
						<div class="col-md-12" id="">
							<div class="">
								<h6 >Select Permissions</h6>
								<input type="checkbox" id="selectall"> <label for="selectall">All</label>
							</div>
							<div id="query_data" class="row">

							</div>

						</div>
					</form>
				</div>
 -->


			</div>
	</section>
</div>
</div>

</div>

<?php $this->load->view('_partials/footer'); ?>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>var base_url='<?php echo base_url(); ?>';</script>
<script type="text/javascript">
	//query_data
	$( document ).ready(function() {
		$('#div_child_data').hide();
			$('#div_parent_data').show();
		getAllBranchesList();
		getHtmlForm();
// pills_parent_data
// pills_child_data
		$("#pills_parent_data").click(function(){
			$('#div_child_data').hide();
			$('#div_parent_data').show();
			getAllBranchesList();
		});
		$("#pills_child_data").click(function(){
			$('#div_parent_data').hide();
			$('#div_child_data').show();
			getAllBranchesList();
		});
		// getLabMasterData();
		$("#selectall").click(function(){
			if(this.checked){
				$('.checkboxall').each(function(){
					$(".checkboxall").prop('checked', true);
				})
			}else{
				$('.checkboxall').each(function(){
					$(".checkboxall").prop('checked', false);
				})
			}
		});
	});
	function reset_Form(){
		$('#query_form')[0].reset();
	}

	function getLabMasterData(){
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLabMasterData") ?>",
			dataType: "json",
			success: function (result) {
				// console.log(result.body);
				$("#query_data").append(result.data);
				$("#branches").select2({});
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function getAllBranchesList(){
		$("#branches").html('');
		$("#branch_id").html('');
		$.ajax({
			type: "POST",
			url: "<?= base_url("getAllBranchesList") ?>",
			dataType: "json",
			success: function (result) {
				$("#branches").append(result.body);
				$("#branches").select2({});

				$("#branch_id").append(result.body);
				$("#branch_id").select2({});
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	function getHtmlForm(id=null){
		$("#selectall").prop('checked', false);
		if(id !== null){
			var x = document.getElementById("query_data");
			if (x.style.display === "none") {
				x.style.display = "block";
			}
		}
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLabMasterData") ?>",
			dataType: "json",
			data:{id},
			success: function (result) {
				$("#query_data").html('').html(result.data);

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function saveFormData(){
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveLabMasterData") ?>",
			dataType: "json",
			data:$('#accessMgmtForm').serialize(),
			success: function (result) {
				if(result.status==200){
					app.successToast(result.body);
					window.location.reload();
					// document.getElementById("accessMgmtForm").reset();//form1 is the form id.
					getHtmlForm(result.branch_id);
				}else{
					app.errorToast(result.body);
				}
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function getHtmlFormChild(id=null){
		// alert(id);return false;
		//$.ajax({
		//	type: "POST",
		//	url: "<?//= base_url("getLabMasterDataOption") ?>//",
		//	dataType: "json",
		//	data:{id},
		//	success: function (result) {
		//			console.log(result.data);
		//		if (result.status == '200') {
		//			$("#lab_master_test").html("").append(result.data);
		//		}else{
		//			$("#lab_master_test").html("").append('<option>No Test Avalable</option>');
		//			$("#query_data_1").html("");
		//		}
		//		// $("#lab_master_test").select2();
		//	}, error: function (error) {
		//
		//		app.errorToast('Something went wrong please try again');
		//	}
		//});
		$('#lab_master_test').select2({
			ajax: {
				url: base_url + "getLabMasterDataOption",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Service Lab Test Name",
				data: function (params) {
					return {
						data:id,
						type: 1,
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response.body
					};
				},
				cache: true
			},
			minimumInputLength: 1
		});
	}


	function getHtmlLabAdminChildTest(id=null){
		// alert(id);return false;
		var branch_id = $("#branch_id").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url("getHtmlLabAdminChildTest") ?>",
			dataType: "json",
			data:{id,branch_id},
			success: function (result) {
				console.log(result.data);
				// $("#lab_master_test").html("").append(result.data);
				// $("#lab_master_test").select2();
				$("#query_data_1").html("").html(result.data);
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	
	function saveFormChildData(){
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveLabChildData") ?>",
			dataType: "json",
			data:$('#accessMgmtForm_1').serialize(),
			success: function (result) {
				if(result.status==200){
					app.successToast(result.body);
					window.location.reload();
					// document.getElementById("accessMgmtForm").reset();//form1 is the form id.
					getHtmlForm(result.branch_id);
				}else{
					app.errorToast(result.body);
				}
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

</script>
