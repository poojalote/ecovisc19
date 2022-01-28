<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Lab Child Services</h1>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Lab Child Services</h4>
							<div class="card-header-action">

							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-3">
									<select name="lab_master_test"  class="form-control" id="lab_master_test" onchange="getHtmlLabAdminChildTest(this.value)">
										<option> Select Lab Master Data</option>
									</select>
								</div>
								<div class="col-md-9 text-right">
									<button type="button" class="btn btn-primary" name="saveButton" id="saveButton" onclick="saveMainChildServices()">Save</button>
								</div>
							</div>

							<div id="lab_master"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<?php $this->load->view('_partials/footer'); ?>
<script> var base_url='<?php echo base_url(); ?>';</script>
<script>
	$(document).ready(function () {

		$('#lab_master_test').select2({
			ajax: {
				url: base_url + "getLabMainMasterDataOption",
				type: "post",
				dataType: "json",
				delay: 250,
				placeholder: "Service Lab Test Name",
				data: function (params) {
					return {
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
	});
	function getHtmlLabAdminChildTest(id=null){
		$.LoadingOverlay("show");
		var lab_master_test = $("#lab_master_test").val();

		$.ajax({
			type: "POST",
			url: "<?= base_url("getMainLabAdminChildTest") ?>",
			dataType: "json",
			data:{lab_master_test,lab_master_test},
			success: function (res) {
				$.LoadingOverlay("hide");
				let columnsHeader = [
					"Name",
					"Method",
					"Unit",
					"Referance range",
					"Child Code",
					"id"
				];
				let hiddenColumns = [5];

				let columnsRows = res.data;
				if (res.data == "") {
					columnsRows = [
						['', '', '', '', '',''],
					];
				}
				let columnTypes = [
					{type: 'text'},
					{type: 'text'},
					{type: 'text'},
					{type: 'text'},
					{type: 'text'},
					{type: 'text'},
				];
				handson(columnsHeader, columnsRows, columnTypes, 'lab_master', hiddenColumns);
			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}
	let hosController;

	function handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns) {


		const container = document.getElementById(divId);
		hosController != null ? hosController.destroy() : "";
		hosController = new Handsontable(container, {
			data: columnsRows,
			colHeaders: columnsHeader,
			manualColumnResize: true,
			manualRowResize: true,
			columns: columnTypes,
			minSpareRows: 1,
			colWidths: '100%',
			width: '100%',
			stretchH: 'all',
			height: 320,
			rowHeights: 23,
			rowHeaders: true,
			filters: true,
			contextMenu: true,
			hiddenColumns: {
				columns: hiddenColumns,
				copyPasteEnabled: false,
			},
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});
		hosController.validateCells();
	}
	function saveMainChildServices() {
		$.LoadingOverlay("show");
		let array = hosController.getData();
		console.log(array);
		let formdata = new FormData();
		formdata.set('data',JSON.stringify(array));
		formdata.set('lab_master_test',$("#lab_master_test").val());
		$.ajax({
			type: "POST",
			url: "<?= base_url("saveMainChildServices") ?>",
			dataType: "json",
			data:formdata,
			contentType:false,
			processData:false,
			success: function (res) {
				$.LoadingOverlay("hide");
			if(res.status === 200)
			{
				app.successToast(res.body);
				// getData();
			}
			else
			{
				app.errorToast(res.body);
			}

			}, error: function (error) {
				$.LoadingOverlay("hide");
				app.errorToast('Something went wrong please try again');
			}
		});
	}
</script>
