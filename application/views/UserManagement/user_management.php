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
				<h1 style="color: #891635">User Management</h1>

			</div>

			<div class="card-body">

				<div class="" id="">
					<form id="accessMgmtForm" action="post">
						<div class="row">
							<div class="col-md-6">
								<label for="">Select Company</label>
								<select name="company" id="company" onchange="getAllBranchesList()">
									<option disabled>Select Branch</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="">Select Branch</label>
								<select name="branches" id="branches">
									<option disabled>Select Branch</option>
								</select>
							</div>
							<div class="col-md-12 text-right">
								<button type="button" onclick="saveFormData()" class="btn btn-primary mt-4">Save</button>
							</div>
						</div>
					</form>
						<div class="col-md-12" id="">
							<div class="">
								<h6 >User Details</h6>
								<div id="newErrorDiv"></div>
								<div id="user_data" class="row">

								</div>
							</div>


						</div>

				</div>




			</div>
	</section>
</div>
</div>

</div>

<?php $this->load->view('_partials/footer'); ?>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	//query_data
	$( document ).ready(function() {
		getAllCompanyList();
		getAllBranchesList();
		loadEditableTable();
	});

	function getAllCompanyList(){
		$("#company").html('');
		$.ajax({
			type: "POST",
			url: "<?= base_url("getAllCompanyList") ?>",
			dataType: "json",
			success: function (result) {
				$("#company").append(result.body);
				$("#company").select2({});
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	function getAllBranchesList(){
		$("#branches").html('');
		let company_id=$("#company").val();
		$.ajax({
			type: "POST",
			url: "<?= base_url("getAllBranchesList") ?>",
			dataType: "json",
			data:{company_id:company_id},
			success: function (result) {
				$("#branches").append(result.body);
				$("#branches").select2({});
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	function loadEditableTable() {
			$.ajax({
				type: "POST",
				url: "<?= base_url("get_user_types") ?>",
				dataType: "json",
				success: function (result) {
					let userType=[];
					if(result.status==200)
					{
						userType=result.data;
					}
					var rows = [['', '', '', '', '',],];
					var types = [
						{type: 'text'},
						{type: 'text'},
						{type: 'text'},
						{
							type: 'dropdown', source: ['Doctor','Nurse','Other'],
						},
						{
							type: 'dropdown', source: userType,
						},


					];
					var hideArra = [];
					var columns = ['Name(A)', 'User Name(B)', 'Password(C)', 'Role(D)', 'User Type(E)'];
					hideColumn = {
						// specify columns hidden by default
						columns: hideArra,
						copyPasteEnabled: false,
					};
					createHandonTable(columns, rows, types, 'user_data', hideColumn);

				}, error: function (error) {
					app.errorToast('Something went wrong please try again');
				}
			});
	}

	let hotDiv;

	function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true) {

		var element = document.getElementById(divId);
		hotDiv != null ? hotDiv.destroy() : '';
		hotDiv = new Handsontable(element, {
			data: columnRows,
			colHeaders: columnsHeader,
			formulas: true,
			manualColumnResize: true,
			manualRowResize: true,

			// ],
			columns: columnTypes,
			minSpareRows:1,
			stretchH: 'all',
			colWidths: '100%',
			width: '100%',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: hideColumn,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});

		hotDiv.validateCells();
	}

	function saveFormData(){
		$("#newErrorDiv").html('');
		var data = hotDiv.getData();
		let form_data=document.getElementById('accessMgmtForm');
		let formData = new FormData(form_data);
		formData.set('arrData', JSON.stringify(data));
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveUsersMgmtFormData") ?>",
			dataType: "json",
			data:formData,
			contentType:false,
			processData:false,
			success: function (result) {
				if(result.status==200){
					app.successToast(result.data);
					loadEditableTable();
				}else if(result.status=202){
					$("#newErrorDiv").append(`<div><div class="alert alert-light alert-has-icon">
							                      <div class="alert-icon"><i class="fa fa-edit"></i></div>
							                      <div class="alert-body">
							                        <div class="alert-title">Same <b>User Name</b> Already Exist</div>
							                         ${result.error_data}
							                      </div>
							                    </div></div>`);
					app.errorToast(result.data);
				}
				else {
					app.errorToast(result.data);
				}
			}, error: function (error) {
				app.errorToast('Something went wrong please try again');
			}
		});
	}

</script>
