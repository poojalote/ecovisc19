<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>


<div class="main-content main-content1">
	<section class="section">
		<div class="section-header card-primary" style="border-top: 2px solid #891635">
			<h1>-</h1>
		</div>
		<div class="section-body">
			<div class=" justify-content-center">
				<div class="">
					<div class="card">
						<div class="card-body">
<<<<<<< HEAD

							<h1>rsLiteGrid Spreadsheet Data Grid Example</h1>
							<table class="table table-bordered table-striped"></table>
							<button class="btn btn-primary">Save Change</button>
=======
							<h1>rsLiteGrid Spreadsheet Data Grid Example</h1>
							<table class="table table-bordered table-striped"></table>
							<button class="btn btn-primary">Export to Json</button>
>>>>>>> 9e8a9109c651f108fcf463f654b4ef09203083ba

						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>
<script>
<<<<<<< HEAD
	function getElementByType(Type, option = null) {
		switch (parseInt(Type)) {
			case 1:
				return `<input type="text" class="form-control">`;
			case 2:
				return `<input type="number" class="form-control">`;
			case 3:
				return `<input type="date" class="form-control">`;
			case 4:
				if (option != null) {
					let options = option.split(",");
					let optionsString = options.map(o => {
						return `<option value="${o}">${o}</option>`;
					});
					return `<select class="form-control"><option value="-1" selected disabled>Select Value</option>${optionsString}</select>`
				} else {
					return `<select class="form-control"><option value="-1" selected disabled>No Options</option></select>`;
				}
			case 5:
				if (option != null) {
					let options = option.split(",");
					let optionsString = options.map(o => {
						return `<option value="${o}">${o}</option>`;
					});
					return `<select class="form-control" multiple><option value="-1" disabled>Select Value</option>${optionsString}</select>`
				} else {
					return `<select class="form-control"><option value="-1" selected disabled>No Options</option></select>`;
				}
			case 6:
				if (option != null) {
					let options = option.split(",");
					let optionsString = options.map((o, i) => {
						return `<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" id="dynamicCheck_${i}" value="option1">
										<label class="form-check-label" for="dynamicCheck_${i}">1</label>
									</div>`;
					});
					return `<div class="form-group">${optionsString}</div>`;
				}
				break;
			case 7:
				if (option != null) {
					let options = option.split(",");
					let optionsString = options.map((o, i) => {
						return `<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" id="dynamicCheck_${i}" value="option1">
										<label class="form-check-label" for="dynamicCheck_${i}">1</label>
									</div>`;
					});
					return `<div class="form-group">${optionsString}</div>`;
				}
				break;
		}
	}

	$(document).ready(function () {
		let formData = new FormData();
		formData.set("section_id", 78);
		formData.set("hash_key", "exceltable_button_64");
		app.request(baseURL + "getExcelTableData", formData).then(response => {
			if (response.status === 200) {
				let tableName="";
				let cols = response.data.map(col => {
					tableName= col.table;
					return {
						name: col.column,
						header: col.input_name,
						markup: getElementByType(col.input_type, col.options)
					};

				});
				cols.push({
							name:"branch_id",
							defaultValue:1,
							markup: '<button class="btn btn-outline-primary" title="delete this row">' +
									'<i class="fa fa-trash"></i></button>' +
									'<input type="hidden" value="1" />',
							tabStop: false
						}
				);

				$('table').rsLiteGrid({
					cols: cols,
					onAddRow: function (event, $lastNewRow) {
						$('button', $lastNewRow).click(function () {
							$('table').rsLiteGrid('delRow', $lastNewRow);
						});
					},
				})
				$('table + button').click(function () {
					let rows = $('table').rsLiteGrid('getData');
					let objects = [];
					rows.map(i => {
						if (checkProperties(i)) {
							objects.push(i);
						}
					});
					if(objects.length>0){
						if(tableName!==""){
							let formData = new FormData();
							formData.set("trans_table",tableName);
							formData.set("data",JSON.stringify(objects));
							app.request(baseURL+"saveDynamicTableEntry",formData).then(response=>{

							}).catch(error=>{
								console.log(error)
							})
						}

					}
				})
			}

		})

		// export data

	});

	function checkProperties(obj) {
		let count = Object.keys(obj).length;
		let isEmpty = 0;
		console.log(Object.keys(obj));
		let keys = Object.keys(obj);
		for (let key in keys) {
			if (obj[keys[key]] == null || obj[keys[key]] === "")
				isEmpty++;
		}
		if (isEmpty === count) {
			return false;
		} else {
			return true;
		}

	}
</script>

=======
	$(document).ready(function () {
		$('table').rsLiteGrid({

			cols: [{
				name: 'name',
				header: 'Name'
			}, {
				name: 'gender',
				header: 'Gender',
				markup: '<select class="form-control"><option value="male">Male</option><option value="female">Female</option></select>',
				defaultValue: 'male'
			}, {
				name: 'age',
				header: 'Age',
				markup: '<input type="number" class="form-control">'
			}, {
				name: 'rule',
				header: 'Rule'
			}, {
				// Delete button needs no name, since this columns does not need to be exported to Json
				markup: '<button title="delete this row">X</button>',
				tabStop: false
			}],

			// event fired after each row is appended to the table.
			// The right place to set the click event for the delete row button
			onAddRow: function (event, $lastNewRow) {
				$('button', $lastNewRow).click(function () {
					$('table').rsLiteGrid('delRow', $lastNewRow);
				});
			}

			// load table with 2 rows of data
		}).rsLiteGrid('setData', [

		]);

		// export data
		$('table + button').click(function () {
			console.log($('table').rsLiteGrid('getData'));
			alert('Open your browser console to see the Json data.');
		})
	});
</script>

<script type="text/javascript">

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-36251023-1']);
	_gaq.push(['_setDomainName', 'jqueryscript.net']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
>>>>>>> 9e8a9109c651f108fcf463f654b4ef09203083ba
