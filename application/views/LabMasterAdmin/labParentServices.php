<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Lab Patient Services</h1>
		</div>

		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">
						<div class="card-body">
							<button class="btn btn-primary float-right m-2" onclick="saveLabData()">save</button>
							<div id="lab_master">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<?php $this->load->view('_partials/footer'); ?>
<script>
	$(document).ready(function () {
		getData();
	});

	function getData() {
		app.request(baseURL + "getLabMasterTest", null).then(res => {
			let columnsHeader = [
				"Master Service Id",
				"Name",
				"Details",
				"Rate",
				"Department ID"
			];
			let sourceData = res.department;
			let hiddenColumns = [];
			let columnsRows = res.data;
			let columnTypes = [
				{type: 'text'},
				{type: 'text'},
				{type: 'text'},
				{type: 'numeric'},
				{type: 'dropdown',source:sourceData},
			];
			handson(columnsHeader, columnsRows, columnTypes, 'lab_master', hiddenColumns);
		});
	}

	let hosController;

	function handson(columnsHeader, columnsRows, columnTypes, divId, hiddenColumns) {
		if (columnsRows.length === 0) {
			columnsRows = [
				['', '', '', '', ''],
			];
		}


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

	function saveLabData() {
		var array = hosController.getData();
		let formdata = new FormData();
		formdata.set('data',array);
		app.request(baseURL + 'saveLabMasterData',formdata).then(res=>{
			if(res.status === 200)
			{
				app.successToast(res.body);
				getData();
			}
			else
			{
				app.errorToast(res.body);
			}
		}).catch(error=>console.log(error));
	}

</script>
