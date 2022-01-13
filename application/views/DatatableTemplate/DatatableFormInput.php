<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="">
	<section class="section">
		<div class="">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="d-block">Fetch Data From</label>
						<!--						<div class="form-check form-check-inline">-->
						<!--							<input class="form-check-input" checked name="operationQuery"-->
						<!--								   type="radio" id="tableOperation" value="1" onchange="tableOperation(this.value)">-->
						<!--							<label class="form-check-label" for="tableOperation">Table selection</label>-->
						<!--						</div>-->
						<!--						<div class="form-check form-check-inline">-->
						<!--							<input class="form-check-input" name="operationQuery" type="radio"-->
						<!--								   id="rawQueryOperation" value="2" onchange="tableOperation(this.value)">-->
						<!--							<label class="form-check-label" for="rawQueryOperation">Raw Query</label>-->
						<!--						</div>-->
					</div>
				</div>
			</div>
			<input type="hidden" name="hasKey" id="haskeyOfInputForm"/>
			<input type="hidden" name="section_id" id="sectionOfInputForm"/>
			<input type="hidden" name="depart_id" id="departmentOfInputForm"/>
			<div class="row" id="formQuerySelectionRow">
				<div class="col-md-4" id="insertTable">
					<div class="form-group">
						<label for="dbTables">Select table</label>
						<select name="dbTables" id="dbTables" style="width: 100%"></select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="dbTables">Columns To fetch Data</label>
						<textarea name="SelectColumns" class="form-control" id="dynamicselectColumns"></textarea>
						<small class="text-muted">Column list with comma separator for data fetching</small>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="dbTables">Data Fetch With Condition</label>
						<textarea name="whereCondition" class="form-control" id="dynamicWhereCondition"></textarea>
						<small class="text-muted">Where condition apply to selected table for data fetching</small>
					</div>
				</div>
			</div>
			<div class="row" id="rawQuerySelectionRow" style="display: none">
				<div class="col-md-6">
					<div class="form-group">
						<label for="dbRawQuery">Raw Query</label>
						<textarea name="whereCondition" class="form-control" id="dbRawQuery"></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="d-block">Add/Update Data From</label>
						<div class="form-check form-check-inline">
							<input class="form-check-input" checked name="operationQuery1"
								   type="radio" id="tableOperation1" value="3" onchange="tableOperation1(this.value)">
							<label class="form-check-label" for="tableOperation1">Insert Operation</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" name="operationQuery1" type="radio"
								   id="rawQueryOperation1" value="4" onchange="tableOperation1(this.value)">
							<label class="form-check-label" for="rawQueryOperation1">Update Operation</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="formQuerySelectionRow1">
				<div class="col-md-6" id="insertTable1">
					<div class="form-group">
						<label for="dbTables1">Select table</label>
						<select name="dbTables1" id="dbTables1" style="width: 100%"></select>
					</div>
				</div>
				<div class="col-md-6" id="updateTable1" style="display: none">
					<div class="form-group">
						<label for="dynamicWhereCondition1">Data Fetch With Condition</label>
						<textarea name="whereCondition1" class="form-control" id="dynamicWhereCondition1"></textarea>
						<small class="text-muted">Where condition apply to selected table for data fetching</small>
					</div>
				</div>
			</div>

			<div class="row" id="rowStartConfig">
				<div class="col-md-12">
					<div class="row justify-content-end">
						<button class="btn btn-outline-primary" onclick="startConfiguration()"
								id="saveConfigurationButton">
							Start Configuration
						</button>
					</div>
				</div>
			</div>
			<div class="row my-4" style="display: none" id="rowConfiguration">
				<table id="dynamicTableConfiguration" class="table table-bordered table-striped"></table>
			</div>
			<div class="row" id="rowSaveConfig" style="display: none">
				<div class="col-md-12">
					<div class="row justify-content-end">
						<button class="btn btn-outline-primary" onclick="saveConfiguration()"
								id="saveConfigurationButton">
							Save Configuration
						</button>
					</div>
				</div>
			</div>
			<!-- <form id="saveForm">
				<div class="row pt-3">
					<div class="col-12 col-md-12">
						<input type="hidden" name="transTablename" id="transTablename"/>
						<table id="example" class="table table-borderless" style="width:100%">
							<thead id="tableHead">

							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" style="display: none">
					<div class="col-md-12 ">
						<div class="row justify-content-end">
							<button class="btn btn-outline-primary" id="saveButton">
								Save
							</button>
						</div>
					</div>
				</div>
			</form> -->
		</div>
	</section>
</div>

<div id="dynamicQueryDropDownButton" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Query DropDown Configuration</h4>
			</div>
			<div class="modal-body">
				<div id="queryDropdownDynamicTabel">
					<div class="col-md-12">
						<div class="form-group mt-2">
							<button type="button" class="btn btn-link ml-2"
									onclick="getHideDynamicDropDown(1)">
								Form Through
							</button>
							<button type="button" class="btn btn-link ml-2"
									onclick="getHideDynamicDropDown(2)">
								Normal Query
							</button>
						</div>
						<div class="form-group mt-2" id="dynamicNormalQueryConfiguration" style="display: none;">
							<label>Query</label>
							<textarea class="form-control" name="txtDynamicDropDownQuery"
									  id="txtDynamicDropDownQuery"></textarea>
						</div>
						<div class="form-group mt-2" id="dynamicFormQueryConfiguration">
							<div class="mt-2 row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Select Table</label>
										<select name="selectDynamicQueryPrimaryTable"
												id="selectDynamicQueryPrimaryTable"
												class="form-control" style="width: 100%"
												onchange="getAllColumnsList(this.value,2)">
										</select>
									</div>
								</div>
							</div>
							<div class="mt-2 row">
								<div class="col-md-6">
									Select Option Value:
									<select name="selectDynamicKeyColumn" id="selectDynamicKeyColumn"
											class="form-control" style="width: 100%">
									</select>
								</div>
								<div class="col-md-6">
									Select Option Name:
									<select name="selectDynamicValueColumn" id="selectDynamicValueColumn"
											class="form-control"
											style="width: 100%">
									</select>
								</div>
							</div>
							<div class="mt-2 row">
								<div class="col-md-12">
									<input type="hidden" id="whereConditionCounter" value="0"/>
									<button type="button" name="add_where" id="add_where"
											onclick="addWhereRows()"
											class="btn btn-outline-primary">
										<i class="fa fa-plus"></i> Add Where Condition
									</button>
								</div>
							</div>
							<div class="col-md-12" id="appendDynamicWhereConditionRow">

							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row align-items-end">
					<button type="button" class="btn btn-primary" onclick="saveQueryDropDown()">Save</button>
				</div>
			</div>
		</div>

	</div>
</div>

<div id="dynamicCalculationModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Query DropDown Configuration</h4>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-2">
							<label>Operation</label>
							<select id="operationColumns" class="form-control">
								<option value="1">+</option>
								<option value="2">-</option>
								<option value="3">*</option>
								<option value="4">/</option>
							</select>
						</div>
						<div class="form-group col-md-5">
							<label>Select Columns</label>
							<select id="headerColumns" multiple class="form-control"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row align-items-end">
					<button type="button" class="btn btn-primary" onclick="saveCalculation()">Save</button>
				</div>
			</div>
		</div>

	</div>
</div>
<?php
// $this->load->view('_partials/footer');
?>
<script>

	// $(document).ready(function () {
	// 	let rows = [];
	// 	$('#saveButton').click(function () {

	// 		elementsSelector.forEach(e => {
	// 			$('#example').find(e).map((i, v) => {
	// 				let name = $(v).attr('name').split("-");

	// 				if (rows.hasOwnProperty(name[1])) {
	// 					let object = rows[name[1]];
	// 					object[name[0]] = $(v).val();
	// 					rows[name[1]] = object;
	// 				} else {
	// 					console.log(name);
	// 					let object = {};
	// 					object[name[0]] = $(v).val();
	// 					rows[name[1]] = object;
	// 				}

	// 			});
	// 		})
	// 		let formData = new FormData();
	// 		formData.set("data", JSON.stringify(rows));
	// 		formData.set("tableName", $("#transTablename").val());
	// 		formData.set("whereKey", "id");
	// 		app.request(baseURL + "updateDynamicFormTransaction", formData).then(response => {
	// 			if (response.status === 200) {
	// 				app.successToast(response.body);
	// 			} else {
	// 				app.errorToast(response.body);
	// 			}
	// 		})
	// 		console.log(rows);
	// 		return false;
	// 	});
	// 	// getAllDBTable(1);
	// });

	//onchange="getAllColumnsList(this.value,1)"
	function startConfiguration() {
		var Check_operationQuery_Fetch=$('input[name="operationQuery"]:checked').val();
		var Check_operationQuery_insert=$('input[name="operationQuery1"]:checked').val();
		Insert_query="";
		fetch_query="";
		fecth_table_name="";
		Insert_table_name="";
		var fecth_table_name=$("#dbTables").val();
		var dynamicselectColumns=$("#dynamicselectColumns").val();
		var Insert_table_name=$("#dbTables1").val();
		let formData = new FormData();
		formData.append('fecth_table_name', fecth_table_name);
		formData.append('Insert_table_name', Insert_table_name);
		formData.append('dynamicselectColumns', dynamicselectColumns);
		app.request("GetDataColumnsForConfig", formData).then(response => {
			if (response.status == 200) {
				var col_opt1=response.fecth_columns;
				console.log(col_opt1);
				var col_opt2=response.insert_columns;
				configuration(col_opt1,col_opt2)
			}
			//return new Promise().resolve1();
		});
	}

	function tableOperation(element) {
		if (parseInt(element) === 1) {
			$("#formQuerySelectionRow").attr('style', 'display:flex');
			$("#rawQuerySelectionRow").attr('style', 'display:none');
		} else {
			$("#formQuerySelectionRow").attr('style', 'display:none');
			$("#rawQuerySelectionRow").attr('style', 'display:flex');
		}
	}
	function tableOperation1(element) {
		if(parseInt(element) === 3) {
			$("#insertTable1").attr('style', 'display:block');
			$("#updateTable1").attr('style', 'display:none');
		}else {
			$("#updateTable1").attr('style', 'display:block');
		}
	}

	function operationType(value) {
		if (parseInt(value) === 1) {
			$("#insertTable").attr('style', 'display:block');
			$("#updateTable").attr('style', 'display:none');
		} else {
			$("#insertTable").attr('style', 'display:none');
			$("#updateTable").attr('style', 'display:block');
		}
	}

	let excelColumnOption = "";
	let dynamicQueryDropDownColumn = "";

	function getAllColumnsList(value, type) {
		let formData = new FormData();
		formData.append('TableName', value);
		app.request("getAllColumns", formData).then(response => {
			if (response.status === 200) {
				if (type === 1) {
					excelColumnOption = response.option;
					$("#rowConfiguration").attr('style', 'display:block');
					$("#rowSaveConfig").attr('style', 'display:block');
					if (excelColumnOption !== "") {
						//configuration(excelColumnOption);
					}
				} else {
					dynamicQueryDropDownColumn = response.option;
					$("#selectDynamicKeyColumn").empty();
					$("#selectDynamicKeyColumn").append(response.option)
					$("#selectDynamicKeyColumn").select2();
					$("#selectDynamicValueColumn").empty();
					$("#selectDynamicValueColumn").append(response.option);
					$("#selectDynamicValueColumn").select2();
				}
			}
		});
	}

	let whereConditionArray = [];

	function addWhereRows() {
		let counter = whereConditionArray.length;

		let rows = `
		<div class="mt-2 row" id="whereDynamicRow_${counter}">
			<div class="col-md-3">
				where column:
				<select name="selectDynamicKeyColumn" id="selectDynamicKeyColumn_${counter}"
				class="form-control" style="width: 100%">
				</select>
			</div>
			<div class="col-md-3">
				Where value:
				<select name="selectDynamicValueColumn" id="selectDynamicValueColumn_${counter}"
				class="form-control"
				style="width: 100%">
				</select>
			</div>
			<div class="col-md-3">
				Static Where value:
				<input type="text" name="staticWhereValue" id="staticWhereValue_${counter}" class="form-control"/>
			</div>
			<div class="col-md-3">
				<div class="row align-items-center">
					<button class="btn btn-primary" onclick="removeWhereRow(${counter})"><i class="fa fa-trash"></i></button>
				</div>
			</div>
		</div>
		`;
		$("#appendDynamicWhereConditionRow").append(rows);
		$("#selectDynamicKeyColumn_" + counter).append(dynamicQueryDropDownColumn);
		$("#selectDynamicKeyColumn_" + counter).select2();
		whereConditionArray.push(counter);
	}

	function saveCalculation() {
		let operation = $("#operationColumns").val();
		let headers = $("#headerColumns").val();
		let configurationString = "CalOperation=" + operation + "||CalColumns=" + headers.join(",")
		$(configurationInput).val(configurationString);
		$("#dynamicCalculationModal").modal('hide');
	}

	function saveQueryDropDown() {
		let configurationString = "";
		let customQuery = $("#txtDynamicDropDownQuery").val();

		if (customQuery !== "") {
			configurationString = "customQuery=" + customQuery;
		} else {
			let primaryTable = $("#selectDynamicQueryPrimaryTable").val();
			let primaryTableKey = $("#selectDynamicKeyColumn").val();
			let primaryTableValue = $("#selectDynamicValueColumn").val();

			if (primaryTable !== "") {
				configurationString = "primaryTable=" + primaryTable;
				if (primaryTableKey !== "") {
					configurationString += "||keyColumn=" + primaryTableKey;
				}
				if (primaryTableValue !== "") {
					configurationString += "||valueColumn=" + primaryTableValue;
				}
				if (whereConditionArray.length > 0) {
					let whereString = whereConditionArray.map(i => {
						let whereColumn = $(`#selectDynamicKeyColumn_${i}`).val();
						let condition = "";
						if (whereColumn !== "" && whereColumn != null) {
							condition = "WhereColumn=" + whereColumn;
							let whereColumnDynamicValue = $(`#selectDynamicValueColumn_${i}`).val();
							if (whereColumnDynamicValue !== "" && whereColumnDynamicValue != null) {
								condition += "@WhereValue=" + whereColumnDynamicValue;
							} else {
								let whereColumnStaticValue = $(`#staticWhereValue_${i}`).val();
								condition += "@WhereValue=" + whereColumnStaticValue;
							}
						}
						return condition;
					}).join(",");
					configurationString += "||" + whereString;

				}
			}

		}
		console.log(configurationString);
		$(configurationInput).val(configurationString);
		$("#dynamicQueryDropDownButton").modal('hide');
	}

	function removeWhereRow(counter) {
		let index = whereConditionArray.findIndex(i => i === counter);
		if (index !== -1) {
			whereConditionArray.splice(index, 1);
			$(`#whereDynamicRow_${counter}`).remove();
		}

	}

	function getAllDBTable(count = 0) {
		app.request(baseURL + "getAllTablenames").then(result => {
			if (count === 1) {
				$("#dbTables").html(result.option);
				$("#dbTables1").html(result.option);
				$("#dbTables").select2();
				$("#dbTables1").select2();
			} else {
				$("#selectDynamicQueryPrimaryTable").html(result.option);
				$("#selectDynamicQueryPrimaryTable").select2();
			}
		});
	}

	let rowsElement = [];

	function configuration(columnOptions,columnOfInsertOrUpdateOptions) {
		let cols = [
			{
				name: "header",
				header: "Header",
				markup: "<input type='text' class='form-control' data-type='3' />"
			},
			{
				name: "type",
				header: "Type",
				markup: `<select class='form-control' data-type='2'>
						<option value="0">None</option>
						<option value="1">Text</option>
						<option value="2">Textarea</option>
						<option value="3">Single-selection</option>
						<option value="4">Multiple-selection</option>
						<option value="5">CheckboxGroup</option>
						<option value="6">RadioGroup</option>
						<option value="7">Date</option>
						<option value="8">File</option>
						<option value="9">Number</option>
						<option value="10">Query DropDown</option>
						<option value="11">Hidden</option>

					</select>`
			}, {
				name: "configuration",
				header: "Configuration",
				markup: "<input type='text' class='form-control' data-type='1'/>"
			}
			,
			{
				name: "column_name",
				header: "Column",
				markup: "<select class='form-control' data-type='4'>" + columnOptions + "</select>"
			},
			{
				name: "operation_column",
				header: "Save On",
				markup: "<select class='form-control' data-type='5'>" + columnOfInsertOrUpdateOptions + "</select>"
			},
			{

				markup: '<div class="btn-group"> <button class="btn btn-outline-primary" data-button="1" title="delete this row">' +
						'<i class="fa fa-trash"></i></button>' +
						'<button class="btn btn-outline-primary" data-button="2" title="setting this row">' +
						'<i class="fas fa-cogs"></i></button></div>',
				tabStop: false
			}
		];
		$("#rowConfiguration").attr('style', 'display:block');
		$("#rowSaveConfig").attr('style', 'display:block');
		$("#dynamicTableConfiguration").empty();
		$('#dynamicTableConfiguration').rsLiteGrid({
			cols: cols,
			onAddRow: function (event, $lastNewRow) {
				rowsElement.push($($lastNewRow));

				$($($lastNewRow).find('button[data-button="1"]')[0]).click(function () {
					$('#dynamicTableConfiguration').rsLiteGrid('delRow', $lastNewRow);
				});
				$($($lastNewRow).find('button[data-button="2"]')[0]).click(function () {
					loadSetting($($lastNewRow));
				});
			},

		})
	}

	let headers;

	function getHeaderValues() {
		headers = [];
		headers = rowsElement.map(i => {
			return $(i[0]).find('select[data-type="4"]').val();
		});
		let options = headers.map(i => {
			if (i !== undefined && i !== "none")
				return `<option value="${i}">${i}</option>`;
		}).join("");
		console.log(options);
		$("#headerColumns").append(options);
		$("#headerColumns").select2();
	}

	function getHideDynamicDropDown(type) {
		if (type === 1) {
			$("#dynamicFormQueryConfiguration").show();
			$("#dynamicNormalQueryConfiguration").hide();
		} else {
			$("#dynamicFormQueryConfiguration").hide();
			$("#dynamicNormalQueryConfiguration").show();
		}
	}


	let lastRow;
	let configurationInput = null;

	function loadSetting(lastElement) {
		let type = $($(lastElement).find('select[data-type="2"]')[0]).val();
		configurationInput = $($(lastElement).find('input[data-type="1"]')[0]);
		console.log(configurationInput);
		switch (parseInt(type)) {
			case 9:
				$("#dynamicCalculationModal").modal('show');
				getHeaderValues();
				break;
			case 10:
				$("#dynamicQueryDropDownButton").modal('show');
				getAllDBTable(2);
				break;

		}

	}

	let elementsSelector = [];

	function getHeaders() {
		let formData = new FormData();
		formData.set("master_id", 1);
		app.request(baseURL + "getHeaderConfiguration", formData).then(response => {
			if (response.status === 200) {

				let headers = [];
				let tableName = "";
				let operation = 2;
				elementsSelector = [];
				let columnObject = response.body.map(column => {
					let type = parseInt(column.type);
					headers.push(column.header);
					tableName = column.table_name;
					operation = column.operation;
					switch (type) {
						case 0:
							return {data: column.column_name}
						case 1:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
									return `<input  class="form-control" type="text" name="${column.column_name + "-" + row.id}" />`
								}
							}
						case 2:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`textarea[name='${column.column_name + "-" + row.id}']`);
									return `<textarea class="form-control" name="${column.column_name + "-" + row.id}" ></textarea>`
								}
							}
						case 3:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									if (column.configuration !== "") {
										let options = column.configuration.split(",");
										let optionTemplate = options.map(i => {
											return `<option value="${i}">${i}</option>`;
										})
										elementsSelector.push(`select[name='${column.column_name + "-" + row.id}']`);
										return `<select class="form-control" name="${column.column_name + "-" + row.id}">${optionTemplate}</select>`
									} else {
										elementsSelector.push(`select[name='${column.column_name + "-" + row.id}']`);
										return `<select class="form-control" name="${column.column_name + "-" + row.id}"><option value="">No Data Found</option></select>`
									}
								}
							}
						case 4:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									if (column.configuration !== "") {
										let options = column.configuration.split(",");
										let optionTemplate = options.map(i => {
											return `<option value="${i}">${i}</option>`;
										})
										elementsSelector.push(`select[name='${column.column_name + "-" + row.id}']`);
										return `<select class="form-control" multiple name="${column.column_name + "-" + row.id}">${optionTemplate}</select>`
									} else {
										elementsSelector.push(`select[name='${column.column_name + "-" + row.id}']`);
										return `<select class="form-control" multiple name="${column.column_name + "-" + row.id}"><option value="">No Data Found</option></select>`
									}
								}
							}
						case 5:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									if (column.configuration !== "") {
										let options = column.configuration.split(",");
										let optionTemplate = options.map(i => {
											elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']:checked`);
											return `<input type="checkbox" name="${column.column_name + "-" + row.id}" /><label>${i}</label>`;
										})
										return `<div class="form-group">${optionTemplate}</div>`;
									} else {
										elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']:checked`);
										return `<input type="checkbox" name="${column.column_name + "-" + row.id}" value="${val}" />`;
									}
								}
							}
						case 6:
							elementsSelector.push(`input[name='${column.column_name}']:checked`);
							return {
								data: column.column_name,
								render: (val, type, row) => {
									if (column.configuration !== "") {
										let options = column.configuration.split(",");
										let optionTemplate = options.map(i => {
											elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']:checked`);
											return `<input type="radio" name="${column.column_name + "-" + row.id}" value="${i}"/><label>${i}</label>`;
										})
										return `<div class="form-group">${optionTemplate}</div>`;
									} else {
										return ``;
									}
								}
							}
						case 7:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
									return `<input type="date" class="form-control" name="${column.column_name + "-" + row.id}" />`
								}
							}
						case 8:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
									return `<input type="file" class="form-control" name="${column.column_name + "-" + row.id}" />`
								}
							}
						case 9:

							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
									return `<input type="number" class="form-control" name="${column.column_name + "-" + row.id}" />`
								}
							}
						case 10:
							return {
								data: column.column_name,
								render: async (val, type, row) => {
									if (column.configuration !== "") {
										let formData = new FormData();
										formData.set("conf", column.configuration);
										let response = await app.request(baseURL + 'getColumnOptions', formData);
										let options = "";
										if (response.status === 200) {
											options = response.data;
										}
										elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
										return `<select class="form-control" id="${column.column_name + "-" + row.id}" name="${column.column_name + "-" + row.id}">${options}</select>`;
									}
								}
							}
						case 11:
							return {
								data: column.column_name,
								render: (val, type, row) => {
									elementsSelector.push(`input[name='${column.column_name + "-" + row.id}']`);
									return `<input type="hidden" class="form-control" name="${column.column_name + "-" + row.id}" value="${val}" />`
								}
							}
					}
				});
				$("#transTablename").val(tableName);
				let header = `<tr>`;

				headers.forEach(h => {
					header += `<td>${h}</td>`;
				})
				header += "</tr>";
				$("#tableHead").append(header);
				let formData = new FormData();
				formData.set("master_id", 1);
				app.request(baseURL + "getDynamicFormData", formData).then(response => {
					if (response.status === 200) {
						let data = response.body;
						console.log(data);
						$('#example').DataTable({
							paging: false,
							ordering: false,
							data: data,
							columns: columnObject
						})
						console.log(headers);
						console.log(columnObject);
					}
				})


			} else {
				app.errorToast(response.body);
			}
		})
	}

	function saveConfiguration() {
		let tableName = $("#dbTables").val();
		let fetchTableColumns = $("#dynamicselectColumns").val();
		let hasKey = $("#haskeyOfInputForm").val();
		let section_id = $("#sectionOfInputForm").val();
		let depart_id = $("#departmentOfInputForm").val();
		let rows = $('#dynamicTableConfiguration').rsLiteGrid('getData');
		let operation = 1;
		if ($("#tableOperation1").is("checked")) {
			operation = 1;
		} else if ($("#rawQueryOperation1").is("checked")) {
			operation = 2;
		}
		let operationTableName = $("#dbTables1").val();
		if (tableName !== "" && operationTableName !=="" && hasKey!=="" && section_id !=="" && depart_id !=="") {
			let formData = new FormData();
			formData.set("dynamicWhereCondition", $("#dynamicWhereCondition").val());
			formData.set("update_where_columns", $("#dynamicWhereCondition1").val());
			formData.set("operation", operation);
			formData.set("fetch_query_columns", fetchTableColumns);
			formData.set("operationTable", operationTableName);
			formData.set("trans_table", tableName);
			formData.set("haskey", hasKey);
			formData.set("section_id", section_id);
			formData.set("depart_id", depart_id);
			formData.set("data", JSON.stringify(rows));
			console.log(rows);
			app.request(baseURL + "saveDynamicFormTableEntry", formData).then(response => {
				if (response.status === 200) {
					app.successToast(response.body);
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => {
				console.log(error)
			})
		}
	}
</script>

