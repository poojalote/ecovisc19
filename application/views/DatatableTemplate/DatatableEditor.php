<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="">
	<section class="section">

		<div class="">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="">
						<div class="section-header">
							<h4>DataTable Editor</h4>
						</div>
						<div class="card-body p-0">
							<form id="uploadCompany" method="post" data-form-valid="saveCompany">
								<div class="modal-body p-0">
									<div class="card my-0 shadow-none">
										<div class="card-body">
											<input type="hidden" id="query_master_id"
												   name="query_master_id"/>
											<input type="hidden" id="datatable_section_id"
												   name="datatable_section_id"/>
											<input type="hidden" id="element_id" name="element_id"/>

											<!--Table Query -->
											<div class="row">
												<div class="col-md-12">
													<div class="form-row">
														<div class="form-group col-md-4">
															<label for="queryTable">Table Name*</label>
															<select id="queryTable" class="form-control "
																	style="width: 100%"
																	onchange="getAllColumns(this.value)"
																	name="queryTable">
															</select>
														</div>
														<div class="form-group col-md-8">
															<label>DataTable Type*</label>
															<div class="form-row">
																<div class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="serverSideSync"
																		   name="dataTableSyncType"
																		   checked
																		   value="1"
																		   class="custom-control-input">
																	<label class="custom-control-label"
																		   for="serverSideSync">Server
																		side(sync)</label>
																</div>
																<div class="custom-control custom-radio custom-control-inline">
																	<input type="radio" id="clientSideSync"
																		   name="dataTableSyncType"
																		   value="2"
																		   class="custom-control-input">
																	<label class="custom-control-label"
																		   for="clientSideSync">Client
																		Side(async)</label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="form-row">
														<div class="form-group col-md-4">
															<label for="queryTableSelectColumn">Select Column*</label>
															<select id="queryTableSelectColumn" multiple
																	style="width: 100%"
																	name="queryTableSelectColumn">
																<option value="">Select Column Name</option>
															</select>
														</div>
														<div class="form-group col-md-6">
															<label for="rawQueryTableSelectColumn">Raw Select
																Section</label>
															<textarea id="rawQueryTableSelectColumn"
																	  name="rawQueryTableSelectColumn"
																	  class="form-control"
																	  placeholder="Query Select Section"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-row">
														<div class="form-group col-md-4">
															<label>Search Column*</label>
															<select id="queryTableSearchColumn" multiple
																	class="w-100"
																	name="queryTableSearchColumn">
																<option>Select Column Name</option>
															</select>
														</div>
														<div class="form-group col-md-6">
															<label>Raw Search Section</label>
															<textarea id="rawQueryTableSearchColumn"
																	  name="rawQueryTableSearchColumn"
																	  class="form-control"
																	  placeholder="Query Search Section"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-row">
														<div class="form-group col-md-4">
															<label>Order Column*</label>
															<select id="queryTableOrderColumn" multiple
																	class="w-100"
																	name="queryTableOrderColumn">
																<option>Select Column Name</option>
															</select>
														</div>
														<div class="form-group col-md-4">
															<label>Order Direction*</label>
															<select class="form-control"
																	id="queryTableOrderColumnDirection"
																	class="w-100"
																	name="queryTableOrderColumnDirection">
																<option value="-1"></option>
																<option value="asc">asc</option>
																<option value="desc">desc</option>
															</select>
														</div>
													</div>
													<!--													<div class="form-group col-md-4">-->
													<!--														<label>Raw order Section</label>-->
													<!--														<textarea id="rawQueryTableOrderColumn"-->
													<!--																  name="rawQueryTableOrderColumn"-->
													<!--																  class="form-control"-->
													<!--																  placeholder="Query Order Section"></textarea>-->
													<!--													</div>-->
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-row">
														<div class="form-group col-md-4">
															<label>File Column</label>
															<select id="queryTableFileColumn"
																	class="w-100"
																	name="queryTableOrderColumn">
																<option>Select Column Name</option>
															</select>
														</div>
														<div class="form-group col-md-4">
															<div class="custom-control custom-radio">
																<input type="radio" id="rb_check_download" name="dataTableDownload"  value="1" class="custom-control-input">
																<label class="custom-control-label" for="rb_check_download">Only download</label>
															</div>
															<div class="custom-control custom-radio">
																<input type="radio" id="rb_check_both_download" name="dataTableDownload" checked="" value="2" class="custom-control-input">
																<label class="custom-control-label" for="rb_check_both_download">Download and upload</label>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!--Wheres -->
											<div class="section-title">Where Condition</div>
											<div class="form-row">
												<button class="btn btn-outline-secondary" type="button"
														onclick="addWhereSection()"><i
															class="fa fa-plus"></i> Add Where
												</button>
											</div>
											<section id="WhereSection">

											</section>
											<div class="row">
												<div class="form-group col-md-10 py-2">
													<label>Custom Where Condition</label>
													<textarea class="form-control"
															  id="queryTableWhereCondition"
															  name="queryTableWhereCondition"></textarea>
												</div>
											</div>
											<hr/>
											<!--Filters -->
											<div class="section-title">Filters</div>
											<div class="form-row">
												<button class="btn btn-outline-secondary" type="button"
														onclick="addFilterSection()"><i
															class="fa fa-plus"></i> Add Filter
												</button>
											</div>
											<hr/>
											<section id="filterSection">

											</section>

											<!--action button -->
											<div class="section-title">Actions Button</div>
											<div class="form-row">
												<button class="btn btn-outline-secondary" type="button"
														onclick="addActionSection()"><i
															class="fa fa-plus"></i> Add Actions
												</button>
											</div>
											<hr/>
											<section id="actionSection">

											</section>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-primary mr-1" type="button" onclick="saveDatatableForm()">
										Submit
									</button>
									<button class="btn btn-secondary" type="reset">Reset</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php
//$this->load->view('_partials/footer');
?>
<script>
	// $(document).ready(() => {
	// 	getAllTables();
	// 	loadDataTable();
	// 	$("#queryTableSelectColumn").select2();
	// 	$("#queryTableSearchColumn").select2();
	// 	$("#queryTableOrderColumn").select2();
	// });
	let tableColumnsOption = null;
	let tableOption = null;
	let QueryStringParameter = null;
	function getAllTables(section_id = null, element_id = null) {
		app.request(baseURL + "getAllTables", null).then(response => {
			tableOption = response.option;
			$("#queryTable").empty();
			$("#queryTable").append(response.option);
			$("#queryTable").select2();
			$("#filterQueryTable").empty();
			$("#filterQueryTable").append(response.option);
			$("#filterQueryTable").select2();
			if (section_id != null && element_id != null) {
				getSelecteDatableData(section_id, element_id);
			}
		}).catch(error => {
			console.log(error);
			app.errorToast("Something went wrong")
		})
	}

	function getAllColumns(value, type = -1, data = null, count = null) {
		let formData = new FormData();
		formData.set("TableName", value);
		app.request(baseURL + "getAllColumns", formData).then(response => {

			if (type === -1) {
				tableColumnsOption = response.option;
				$("#queryTableSelectColumn").empty();
				$("#queryTableSelectColumn").append(response.option);
				$("#queryTableSelectColumn").select2();
				$("#queryTableSearchColumn").empty();
				$("#queryTableSearchColumn").append(response.option);
				$("#queryTableSearchColumn").select2();
				$("#queryTableOrderColumn").empty();
				$("#queryTableOrderColumn").append(response.option);
				$("#queryTableOrderColumn").select2();

				$("#queryTableOrderColumn").empty();
				$("#queryTableOrderColumn").append(response.option);
				$("#queryTableOrderColumn").select2();

				$("#queryTableFileColumn").empty();

				$("#queryTableFileColumn").append(response.option);
				$("#queryTableFileColumn").select2();

				if (data != null) {
					getSelectSelectedColumn(data);
				}
			} else {
				$("#filterKeyValue_" + type).empty();
				$("#filterKeyValue_" + type).append(response.option);
				$("#filterKeyValue_" + type).select2();
				$("#filterKey_" + count).empty();
				$("#filterKey_" + count).append(response.option);
				$("#filterKey_" + count).select2();
				getSelectedFilterSelection(data, count);
			}


		}).catch(error => {
			console.log(error);
			app.errorToast("Something went wrong")
		})
	}

	let filterCount = 0;
	let filterArray = [];

	function addFilterSection() {
		filterCount++;
		let templateString = filterTemplate(filterCount);
		$("#filterSection").append(templateString);
		filterArray.push({});
		if (tableColumnsOption != null) {
			$("#filterTableColumn_" + filterCount).empty();
			$("#filterTableColumn_" + filterCount).append(tableColumnsOption);
			$("#filterTableColumn_" + filterCount).select2();
		}

	}

	function filterTypeSection(counter, value) {
		if (parseInt(value) === 3) {
			$("#dropDownQueryTableSection_" + counter).removeClass("d-none");
			$("#dropDownKeySection_" + counter).removeClass("d-none");
			$("#dropDownKeyValueSection_" + counter).removeClass("d-none");
			$("#dropDownCustomKeyValueSection_" + counter).removeClass("d-none");
			$("#dropDownConditionSection_" + counter).removeClass("d-none");
			if (tableOption != null) {
				$("#filterQueryTable_" + counter).empty();
				$("#filterQueryTable_" + counter).append(tableOption);
				$("#filterQueryTable_" + counter).select2();
			}

		} else {
			$("#dropDownQueryTableSection_" + counter).addClass("d-none");
			$("#dropDownKeySection_" + counter).addClass("d-none");
			$("#dropDownKeyValueSection_" + counter).addClass("d-none");
			$("#dropDownCustomKeyValueSection_" + counter).addClass("d-none");
			$("#dropDownConditionSection_" + counter).addClass("d-none");
		}

	}

	function filterTemplate(counter) {

		return `<div class="form-row my-2">
					<div class="form-group col-sm-4 col-md-2">
						<label>Filter On Column</label>
						<select class="w-100" id="filterTableColumn_${counter}"  name="filterQueryTable_${counter}">
						<option>Table Name</option>
						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2">
						<label>Filter value type</label>
						<select class="form-control"
							id="filterValueType_${counter}" name="filterValueType_${counter}"
							onchange="filterTypeSection(${counter},this.value)">
							<option value="-1" disabled selected>Select Value Type</option>
						<option value="1">Date</option>
						<option value="2">DateTime</option>
						<option value="3">DropDown</option>
						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2 d-none"  id="dropDownQueryTableSection_${counter}">
						<label>Filter DropDown Query Table</label>
						<select class="form-control" id="filterQueryTable_${counter}" onchange="getAllColumns(this.value,'${counter}')" name="filterQueryTable_${counter}">

						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2 d-none" id="dropDownKeyValueSection_${counter}">
						<label>Filter DropDown key/value Column</label>
						<select class="form-control" id="filterKeyValue_${counter}" name="filterKeyValue_${counter}">

						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2 d-none" id="dropDownConditionSection_${counter}">
						<label>Filter DropDown condition</label>
						<input type="text" class="form-control" id="filterQueryCondition_${counter}" name="filterQueryCondition_${counter}"/>
					</div>
					<div class="form-group col-sm-4 col-md-2">
						<label>Filter DropDown Static values</label>
						<input type="text" class="form-control" id="filterStaticValue_${counter}" name="filterStaticValue_${counter}"/>
					</div>
				</div>`
	}

	let whereCount = 0;
	let whereArray = [];

	function addWhereSection() {
		whereCount++;
		let templateString = whereTemplate(whereCount);
		if (tableColumnsOption != null) {
			$("#WhereSection").append(templateString);
			whereArray.push({});
			$("#whereTableColumn_" + whereCount).empty();
			$("#whereTableColumn_" + whereCount).append(tableColumnsOption);
			$("#whereTableColumn_" + whereCount).select2();
			getQueryStringParaForWhere(whereCount);
		} else {
			app.errorToast("Select Primary Table")
		}
	}

	function whereTemplate(counter) {
		return `<div class="form-row my-2">
					<div class="form-group col-sm-4 col-md-2">
						<label>Where On Column</label>
						<select class="w-100" id="whereTableColumn_${counter}"  name="whereQueryTable_${counter}">
						<option>Table Name</option>
						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2" id="whereDropDownKeyValueSection_${counter}">
						<label>Where Query Parameter Value</label>
						<select class="form-control" id="whereValue_${counter}" name="whereValue_${counter}">

						</select>
					</div>
					<div class="form-group col-sm-4 col-md-2">
						<label>Where Static values</label>
						<input type="text" class="form-control" id="whereStaticValue_${counter}" name="whereStaticValue_${counter}"/>
					</div>
				</div>`
	}

	function getQueryStringParaForWhere(counter) {
		//QueryStringParameter

		$("#whereValue_" + counter).empty();
		if (QueryStringParameter != null) {
			$("#whereValue_" + counter).append(QueryStringParameter);
		} else {
			$("#whereValue_" + counter).append(QueryStringParameter);
		}

	}

	// function getQueryStringParaForWhere(counter) {
	// 	//QueryStringParameter
	// 	app.request("getQueryStringPara").then(response => {
	// 		$("#whereValue_" + counter).empty();
	// 		if (response.status === 200) {
	// 			$("#whereValue_" + counter).append(response.data);
	// 		} else {
	// 			$("#whereValue_" + counter).append(response.data);
	// 		}
	// 	});
	// }
	function getQueryStringParaForWhere1(counter) {
		//QueryStringParameter
		app.request("getQueryStringPara").then(response => {
			if (response.status === 200) {
				QueryStringParameter = response.data;
			} else {
				QueryStringParameter = response.data;
			}
		});
	}

	let actionCount = 0;
	let actionArray = [];

	function addActionSection() {
		actionCount++;
		let templateString = actionTemplate(actionCount);
		$("#actionSection").append(templateString);
		actionArray.push({});
		if (tableColumnsOption != null) {
			$("#actionButtonPrimary_" + actionCount).empty();
			$("#actionButtonPrimary_" + actionCount).append(tableColumnsOption);
			$("#actionButtonPrimary_" + actionCount).select2();
		}
	}

	function saveDatatableForm() {

		whereArray.forEach((object, index) => {
			index++;
			let whereTableColumn = $("#whereTableColumn_" + index).val();
			if (whereTableColumn !== "") {
				object.WhereTableColumn = whereTableColumn;
			} else {
				delete object.WhereTableColumn;
			}

			let whereValueType = $("#whereValue_" + index).val();
			if (whereValueType != null) {
				if (whereValueType.length > 0) {
					object.WhereColumnValue = whereValueType;
				} else {
					if ($("#whereStaticValue_" + index).val() !== "" && $("#whereStaticValue_" + index).val() !== null) {
						object.WhereColumnValue = $("#whereStaticValue_" + index).val();
					} else {
						delete object.WhereColumnValue;
					}
				}
			} else {
				if ($("#whereStaticValue_" + index).val() !== "" && $("#whereStaticValue_" + index).val() !== null) {
					object.WhereColumnValue = $("#whereStaticValue_" + index).val();
				} else {
					delete object.WhereColumnValue;
				}
			}

		});


		filterArray.forEach((object, index) => {
			index++;
			let filterTableColumn = $("#filterTableColumn_" + index).val();
			if (filterTableColumn !== "") {
				object.FilterTableColumn = filterTableColumn;
			} else {
				delete object.FilterTableColumn;
			}
			let filterValueType = $("#filterValueType_" + index).val();
			if (filterValueType !== "" && filterValueType != null) {
				object.filterValueType = filterValueType;
			} else {
				delete object.FilterTableColumn;
			}
			let filterQueryTable = $("#filterQueryTable_" + index).val();
			if (filterQueryTable !== "" && filterQueryTable != null) {
				object.filterQueryTable = filterQueryTable;
			} else {
				delete object.filterQueryTable;
			}

			let filterKeyValue = $("#filterKeyValue_" + index).val();
			if (filterKeyValue !== "" && filterKeyValue != null) {
				object.filterKeyValue = filterKeyValue;
			} else {
				delete object.filterKeyValue;
			}

			let filterQueryCondition = $("#filterQueryCondition_" + index).val();
			if (filterQueryCondition !== "" && filterQueryCondition != null) {
				object.filterQueryCondition = filterQueryCondition;
			} else {
				delete object.filterQueryCondition;
			}

			let filterStaticValue = $("#filterStaticValue_" + index).val();
			if (filterStaticValue !== "" && filterStaticValue != null) {
				object.filterStaticValue = filterStaticValue;
			} else {
				delete object.filterStaticValue;
			}
		});

		actionArray.forEach((object, index) => {
			index++;
			let actionButtonPrimary = $("#actionButtonPrimary_" + index).val();
			if (actionButtonPrimary !== "" && actionButtonPrimary != null) {
				object.actionButtonPrimary = actionButtonPrimary;
			} else {
				delete object.actionButtonPrimary;
			}
			let actionButtonIcon = $("#actionButtonIcon_" + index).val();
			if (actionButtonIcon !== "" && actionButtonIcon != null) {
				object.actionButtonIcon = actionButtonIcon;
			} else {
				delete object.actionButtonIcon;
			}
			let actionButtonType = $("#actionButtonType_" + index).val();
			if (actionButtonType !== "" && actionButtonType != null) {
				object.actionButtonType = actionButtonType;
			} else {
				delete object.actionButtonType;
			}
			if (actionButtonType === "2") {
				object.actionButtonRedirectTemplate = $("#datatable_section_id").val();
				object.actionButtonRedirectUpdateParam = "#" + object.actionButtonPrimary;
			} else {
				let actionButtonRedirectTemplate = $("#actionButtonRedirectTemplate_" + index).val();
				if (actionButtonRedirectTemplate !== "" && actionButtonRedirectTemplate != null) {
					object.actionButtonRedirectTemplate = actionButtonRedirectTemplate;
				} else {
					delete object.actionButtonRedirectTemplate;
				}
				let actionButtonRedirectQueryParam = $("#actionButtonRedirectQueryParam_" + index).val();
				if (actionButtonRedirectQueryParam !== "" && actionButtonRedirectQueryParam != null) {
					object.actionButtonRedirectQueryParam = actionButtonRedirectQueryParam;
				} else {
					delete object.actionButtonRedirectQueryParam;
				}
			}


			let actionButtonExecutionQuery = $("#actionButtonExecutionQuery_" + index).val();
			if (actionButtonExecutionQuery !== "" && actionButtonExecutionQuery != null) {
				object.actionButtonExecutionQuery = actionButtonExecutionQuery;
			} else {
				delete object.actionButtonExecutionQuery;
			}
			let actionButtonModalTemplate = $("#actionButtonModalTemplate_" + index).val();
			if (actionButtonModalTemplate !== "" && actionButtonModalTemplate != null) {
				object.actionButtonModalTemplate = actionButtonModalTemplate;
			} else {
				delete object.actionButtonModalTemplate;
			}
			let actionButtonModalQueryParam = $("#actionButtonModalQueryParam_" + index).val();
			if (actionButtonModalQueryParam !== "" && actionButtonModalQueryParam != null) {
				object.actionButtonModalQueryParam = actionButtonModalQueryParam;
			} else {
				delete object.actionButtonModalQueryParam;
			}
			let actionButtonRedirectPage = $("#actionButtonRedirectPage_" + index).val();
			if (actionButtonRedirectPage !== "" && actionButtonRedirectPage != null) {
				object.actionButtonRedirectPage = actionButtonRedirectPage;
			} else {
				delete object.actionButtonRedirectPage;
			}
		});

		let dataTableForm = new FormData();
		let queryTable = $("#queryTable").val();
		let queryTableSelectColumn = "";
		let customWhereCondition = $("#queryTableWhereCondition").val();

		let fileColumn = $('#queryTableFileColumn').val();
		let fileOperation = $("#rb_check_download").is("checked") ? $("#rb_check_download").val() :
				$("#rb_check_both_download").is("checked") ? $("#rb_check_both_download").val() : 1;

		if ($("#queryTableSelectColumn").val().length !== 0) {
			if ($("#rawQueryTableSelectColumn").val() !== "") {
				let selectColumn = $("#queryTableSelectColumn").val().join();
				selectColumn += "," + $("#rawQueryTableSelectColumn").val();
				queryTableSelectColumn = selectColumn
			} else {
				queryTableSelectColumn = $("#queryTableSelectColumn").val();
			}
		} else {
			if ($("#rawQueryTableSelectColumn").val() !== "") {
				queryTableSelectColumn = $("#rawQueryTableSelectColumn").val();
			}
		}

		let queryTableSearchColumn = "";
		if ($("#queryTableSearchColumn").val().length !== 0) {
			if ($("#rawQueryTableSearchColumn").val() !== "") {
				let searchColumn = $("#queryTableSearchColumn").val().join();
				searchColumn += "," + $("#rawQueryTableSearchColumn").val();
				queryTableSearchColumn = searchColumn;
			} else {
				queryTableSearchColumn = $("#queryTableSearchColumn").val();
			}
		} else {
			if ($("#rawQueryTableSearchColumn").val() !== "") {
				queryTableSearchColumn = $("#rawQueryTableSearchColumn").val();
			}
		}

		let queryTableOrderColumn = "";
		if ($("#queryTableOrderColumn").val().length !== 0) {
			queryTableOrderColumn = $("#queryTableOrderColumn").val();
		}

		let queryTableOrderColumnDirection = $("#queryTableOrderColumnDirection").val();

		let dataTableSyncType = $("#serverSideSync").is("checked") ? $("#serverSideSync").val() :
				$("#clientSideSync").is("checked") ? $("#clientSideSync").val() : 1;
		let dataTableWhereCondition = $("#queryTableWhereCondition").val();

		if (queryTable !== "" && queryTable != null
				&& queryTableSelectColumn !== "" && queryTableSelectColumn != null
				&& queryTableSearchColumn !== "" && queryTableSearchColumn != null
				&& queryTableOrderColumn !== "" && queryTableOrderColumn != null
				&& queryTableOrderColumnDirection !== "" && queryTableOrderColumnDirection != null
				&& dataTableSyncType !== "" && dataTableSyncType != null
		) {
			dataTableForm.set("query_master_id", $("#query_master_id").val());
			dataTableForm.set("element_id", $("#element_id").val());
			dataTableForm.set("section_id", $("#datatable_section_id").val());
			dataTableForm.set("queryTable", queryTable);
			dataTableForm.set("customWhereCondition", customWhereCondition);
			dataTableForm.set("queryTableSelectColumn", queryTableSelectColumn);
			dataTableForm.set("queryTableSearchColumn", queryTableSearchColumn);
			dataTableForm.set("queryTableOrderColumn", queryTableOrderColumn);
			dataTableForm.set("queryTableOrderColumnDirection", queryTableOrderColumnDirection);
			dataTableForm.set("dataTableSyncType", dataTableSyncType);
			dataTableForm.set("queryTableWhereCondition", dataTableWhereCondition);
			dataTableForm.set("queryFileColumn",fileColumn);
			dataTableForm.set("queryFileOperation",fileOperation);

			if (filterArray.length > 0) {
				dataTableForm.set("filterData", JSON.stringify(filterArray));
			}
			if (actionArray.length > 0) {
				dataTableForm.set("actionData", JSON.stringify(actionArray));
			}
			if (whereArray.length > 0) {
				dataTableForm.set("whereData", JSON.stringify(whereArray));
			}
			app.request(baseURL + "saveDataTableEditor", dataTableForm).then(response => {
				console.log(response);
				if (response.status === 200) {
					app.successToast(response.body);
					// loadDataTable($("#element_id").val(), $("#datatable_section_id").val());
					$("#uploadCompany")[0].reset();
					$("#datatableOpBtn").click();
				} else {
					app.errorToast(response.body);
				}

			}).catch(error => {
				console.log(error);
				app.errorToast("Something Went Wrong");
			})
		} else {
			app.errorToast("Please fill all required values")
		}

	}

	function actionTypeSection(counter, value) {
		if (parseInt(value) === 1) {
			$("#actionSectionRedirectTemplate_" + counter).removeClass("d-none");
			$("#actionSectionRedirectQueryParam_" + counter).removeClass("d-none");
			getAllSection('actionButtonRedirectTemplate_' + counter)
		} else {
			$("#actionSectionRedirectTemplate_" + counter).addClass("d-none");
			$("#actionSectionRedirectQueryParam_" + counter).addClass("d-none");
			$("#actionButtonRedirectTemplate_" + counter).val("");
			$("#actionButtonRedirectQueryParam_" + counter).val("");
		}
		if (parseInt(value) === 2) {
			$("#actionSectionRedirectPage_" + counter).removeClass("d-none");
		} else {
			$("#actionButtonRedirectPage_" + counter).val("");
			$("#actionSectionRedirectPage_" + counter).addClass("d-none");

		}

		if (parseInt(value) === 3) {
			$("#actionSectionExecutionQuery_" + counter).removeClass("d-none");
		} else {
			$("#actionSectionExecutionQuery_" + counter).addClass("d-none");
			$("#actionButtonExecutionQuery_" + counter).val("");
		}
		if (parseInt(value) === 4) {
			$("#actionSectionModalTemplate_" + counter).removeClass("d-none");
			$("#actionSectionModalQueryParam_" + counter).removeClass("d-none");
		} else {
			$("#actionSectionModalTemplate_" + counter).addClass("d-none");
			$("#actionSectionModalQueryParam_" + counter).addClass("d-none");
			$("#actionButtonModalTemplate_" + counter).val("");
			$("#actionButtonModalQueryParam_" + counter).val("");
		}


	}

	function actionTemplate(counter) {

		return `
		<div class="form-row my-2">
			<div class="form-group col-md-2">
				<label>Primary column</label>
				<select class="w-100" id="actionButtonPrimary_${counter}" name="actionButtonPrimary_${counter}">
				<option>Table Name</option>
				</select>
			</div>
			<div class="form-group col-md-2">
				<label>Icon class</label>
				<select  class="form-control" id="actionButtonIcon_${counter}" name="actionButtonIcon_${counter}" >
				<option value="">Select Icon</option>
				<option value="fa fa-pen">fa fa-pen</option>
				<option value="fa fa-trash">fa fa-trash</option>
				<option value="fa fa-eye">fa fa-eye</option>
				</select>

			</div>
			<div class="form-group col-md-2">
				<label>Action Type</label>
				<select class="form-control" id="actionButtonType_${counter}" name="actionButtonType_${counter}"
                 onchange="actionTypeSection(${counter},this.value)">
				<option value="-1" >Select Action Type</option>
				<option value="1">Redirection To new Template</option>
				<option value="2">Update Operation</option>
				<option value="3">Execute Query</option>
				</select>
			</div>
			<div class="form-group col-md-2 d-none" id="actionSectionRedirectTemplate_${counter}">
				<label>Redirection Template </label>
				<select class="form-control" id="actionButtonRedirectTemplate_${counter}" name="actionButtonRedirectTemplate_${counter}">
				<option>Select key/value Column</option>
				</select>
			</div>
			<div class="form-group col-md-2 d-none" id="actionSectionRedirectQueryParam_${counter}">
				<label>Extra Query Parameter Value</label>
				<input type="text" class="form-control" id="actionButtonRedirectQueryParam_${counter}" name="actionButtonRedirectQueryParam_${counter}"/>
			</div>
			<div class="form-group col-md-2 d-none"  id="actionSectionExecutionQuery_${counter}">
				<label>Execution Query</label>
				<textarea class="form-control"  id="actionButtonExecutionQuery_${counter}" name="actionButtonExecutionQuery_${counter}"></textarea>
			</div>
		</div>
		`;
	}

	function loadDataTable(element_id, section_id) {
		let formData = new FormData();
		formData.set("element_id", element_id)
		formData.set("section_id", section_id)
		app.request(baseURL + "getDataTableTemplate", formData).then(response => {

			if (response.status === 200) {
				var div_id = element_id.replace("#", "");
				$("#dynamic_datatable_" + div_id).empty();
				$("#dynamic_datatable_" + div_id).append(response.body);

				app.dataTable(response.tableID, {
					url: baseURL + "getDataTableData",
					data: {
						element_id: element_id,
						section_id: section_id
					}
				});
			}
		})
	}

	function dynamicFilter(element_id, index, filterColumn, type, value, section_id) {
		var div_id = element_id.replace("#", "");
		app.dataTable("dynamicDataTable_" + div_id, {
			url: baseURL + "getDataTableData",
			data: {
				element_id: element_id,
				section_id: section_id,
				filterColumn: filterColumn,
				filterByValue: value
			}
		});
	}

	function getAllSection(element) {
		app.request(baseURL + "getAllSection", null).then(response => {
			tableOption = response.option;
			$(`#${element}`).empty();
			$(`#${element}`).append(response.body);
			$(`#${element}`).select2();

		}).catch(error => {
			console.log(error);
			app.errorToast("Something went wrong")
		})
	}
</script>
