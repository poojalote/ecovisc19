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
				<h1 style="color: #891635">Access Management</h1>

			</div>

			<div class="card-body">

				<div class="" id="">
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




			</div>
	</section>
</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Report Form</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<div class="modal-body">
				<form id="download_form">
					<div id="reportDownloadForm">

					</div>
					<div id="ViewTable">

					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"onclick="ShowData()">Save</button>
				<button type="button" class="btn btn-primary"onclick="DownloadData()">Download</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
</div>

<?php $this->load->view('_partials/footer'); ?>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	//query_data
	$( document ).ready(function() {
		getAllBranchesList();
		getHtmlForm();
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

	function getAllBranchesList(){
		$("#branches").html('');
		$.ajax({
			type: "POST",
			url: "<?= base_url("getAllBranchesList") ?>",
			dataType: "json",
			success: function (result) {
				$("#branches").append(result.body);
				$("#branches").select2({});
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
			url: "<?= base_url("getAccessMgmtFormData") ?>",
			dataType: "json",
			data:{id},
			success: function (result) {
				$("#query_data").html(result.data);

			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function saveFormData(){
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveAccessMgmtFormData") ?>",
			dataType: "json",
			data:$('#accessMgmtForm').serialize(),
			success: function (result) {
				if(result.status==200){
					app.successToast(result.body);
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
