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

			<div class="card-body">

					<ul class="nav nav-pills" id="pills-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active show" id="pills_parent_data" data-toggle="tab" href="#div_parent_data" role="tab" aria-controls="div_parent_data" aria-selected="true" onclick="clearData(1)">Master Test Mapping</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills_child_data" data-toggle="tab" href="#div_child_data" role="tab" aria-controls="div_child_data" aria-selected="false" onclick="clearData(2)">Child Test Mapping</a>
						</li>

					</ul>
					<div class="tab-content" id="myTabContent2">
						<div class="tab-pane fade active show" id="div_parent_data" role="tabpanel" aria-labelledby="pills_parent_data">
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
									<div id="errorDiv"></div>
									<div class="">
										<h6 >Select Lab Admin Master Test</h6>
										<input type="checkbox" id="selectall"> <label for="selectall">All</label>
									</div>
									<div id="query_data" class="row">

									</div>

								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="div_child_data" role="tabpanel" aria-labelledby="pills_child_data">
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
										<input type="checkbox" id="selectallC"> <label for="selectallC">All</label>
									</div>
									<div id="query_data_1" class="row">

									</div>

								</div>
							</form>
						</div>

					</div>


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
		$("#selectallC").click(function(){
			if(this.checked){
				$('.checkboxallc').each(function(){
					$(".checkboxallc").prop('checked', true);
				})
			}else{
				$('.checkboxallc').each(function(){
					$(".checkboxallc").prop('checked', false);
				})
			}
		});
	});
	function reset_Form(){
		$('#query_form')[0].reset();
	}

	function getLabMasterData(){
		$.LoadingOverlay("show");
		$("#query_data").html('');
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLabMasterData") ?>",
			dataType: "json",
			success: function (result) {
				$.LoadingOverlay("hide");
				// console.log(result.body);
				$("#query_data").append(result.data);
				$("#branches").select2({});
			}, error: function (error) {
				$.LoadingOverlay("hide");
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
		$.LoadingOverlay("show");
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
				$.LoadingOverlay("hide");
				$("#query_data").html('').html(result.data);

			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function saveFormData(){
		$.LoadingOverlay("show");
		$("#errorDiv").html('');
		var obj = {};
		obj.labMasterData = $('input[name="labMasterData[]"]:checked').map(function(){
			return  this.value;
		}).get();
		let form_data=new FormData();
		form_data.set('branches',$("#branches").val());
		form_data.set('labMasterData',JSON.stringify(obj));
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveLabMasterData") ?>",
			dataType: "json",
			data:form_data,
			contentType:false,
			processData:false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if(result.status==200){
					app.successToast(result.body);
				} else if(result.status==202){
					app.errorToast(result.body);

					$("#errorDiv").html(`<div style="font-size: 14px;">
						<div class="alert alert-light alert-has-icon">
                  <div class="alert-icon"><i class="fa fa-edit"></i></div>
                     <div class="alert-body">
                     <div class="alert-title">Uncheck Some of Services which are not in service master for that branch if you want to continue for checked services click on save button </div>

                     </div>
                 </div></div>`);
					let cservices=result.error;
					$("#selectall")[0].checked=false;
					for(var j=0;j<cservices.length;j++)
					{
						if($('input[type="checkbox"][value='+cservices[j]+']').is(":checked"))
						{
							$('input[type="checkbox"][value='+cservices[j]+']')[0].checked = false
						}
					}
				}else{
					app.errorToast(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function getHtmlFormChild(id=null){
		$("#lab_master_test").val("");
		$("#lab_master_test").select2({allowClear:true});

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
		$.LoadingOverlay("show");
		// alert(id);return false;
		var branch_id = $("#branch_id").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url("getHtmlLabAdminChildTest") ?>",
			dataType: "json",
			data:{id,branch_id},
			success: function (result) {
				$.LoadingOverlay("hide");
				// console.log(result.data);
				// $("#lab_master_test").html("").append(result.data);
				// $("#lab_master_test").select2();
				$("#query_data_1").html("").html(result.data);
			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	
	function saveFormChildData(){
		$.LoadingOverlay("show");
		var objc = {};
		objc.labChildData = $('input[name="labChildData[]"]:checked').map(function(){
			return  this.value;
		}).get();
		let form_data=new FormData();
		form_data.set('branch_id',$("#branch_id").val());
		form_data.set('labChildData',JSON.stringify(objc));
		form_data.set('lab_master_test',$("#lab_master_test").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveLabChildData") ?>",
			dataType: "json",
			data:form_data,
			contentType:false,
			processData:false,
			success: function (result) {
				$.LoadingOverlay("hide");
				if(result.status==200){
					app.successToast(result.body);
					// window.location.reload();
					// document.getElementById("accessMgmtForm").reset();//form1 is the form id.
					// getHtmlForm(result.branch_id);
				}else{
					app.errorToast(result.body);
				}
			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	function clearData(type) {
		if(type==1)
		{
			$("#branches").val('');
			getLabMasterData();
		}
		else {
			$("#branch_id").val('');
			$("#branch_id").select2({allowClear:true});
			$("#lab_master_test").val('');
			getHtmlLabAdminChildTest();
		}
	}
</script>
