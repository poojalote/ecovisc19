<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<style>
    .content-wrap section
    {
        text-align: unset!important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section section-body_new">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <input type="hidden" id="department_id" name="department_id"
                               value="<?= $department_id ?>">
                        <input type="hidden" id="section_id" name="section_id"
                               value="<?= $section_id ?>">
                        <input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
                               value="<?= $queryParam ?>">
                        <input type="hidden" id="hiddenDivName" name="hiddenDivName">

                        <section id="profileSection">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <div class="tabs tabs-style-underline">
                                        <nav>
                                            <ul id="lab_master_top_nav">
                                                <li class="tab-current">
                                                    <a href="#departmentPanel" class="icon" id="tabDepartment">
                                                        <i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
                                                        <span>Department</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#masterTestPanel" class="icon" id="tabMasterTest">
                                                        <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                        <span>Master Test</span></a></li>
                                                <li class="">
                                                    <a href="#childTestPanel" class="icon" id="tabChildTest">
                                                        <i class="fas fa-capsules mr-1 fa_class"></i>
                                                        <span>Child Test</span></a></li>
<!--                                                <li class="">-->
<!--                                                    <a href="#unitMasterPanel" class="icon" id="tabUnitMaster"-->
<!--                                                    ><i class="fas fa-vial mr-1 fa_class"></i>-->
<!--                                                        <span>Unit Master</span></a></li>-->
												<li class="">
													<a href="#subgroupMasterPanel" class="icon" id="tabSubgroupMaster"
													><i class="fas fa-vial mr-1 fa_class"></i>
														<span>Child Test Group</span></a></li>
                                            </ul>
                                        </nav>
                                        <div class="content-wrap" id="lab_master_panel">
                                            <section id="departmentPanel" class="content-current">
                                                <div id="tabDepartmentPanel"></div>
                                            </section>
                                            <section id="masterTestPanel">
                                                <div id="tabMasterTestPanel"></div>
                                            </section>
                                            <section id="childTestPanel">
                                                <div id="tabChildTestPanel"></div>
                                            </section>
                                            <section id="unitMasterPanel">
                                                <div id="tabUnitMasterPanel"></div>
                                            </section>
											<section id="subgroupMasterPanel">
												<div class="col-md-12 row">
													<div class="col-md-4">
														<label for="">
															Select Master Test
														</label>
														<select name="masterTestId" id="masterTestId" class="col-md-3" onchange="loadEditableTable(this.value)"></select>
													</div>
													<div class="col-md-8 text-right">
														<button type="button" class="btn btn-sm btn-primary mt-5" id="saveSubgroupBtn" onclick="saveSubgroupBtn()">Save</button>
													</div>
												</div>

												<div id="tabSubgroupMasterPanel" class="col-md-12 mt-2"></div>

											</section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
    const base_url = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        let queryParam =document.getElementById("queryparameter_hidden").value;
        let sectionId = document.getElementById("section_id").value;
        let departmentId = document.getElementById("department_id").value;

        document.getElementById("hiddenDivName").value= 'tabDepartmentPanel';
        get_forms(128, 0, queryParam, departmentId, null, 'tabDepartmentPanel');
        showPanel(128);

        $("#tabDepartment").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabDepartmentPanel';
            get_forms(128, 0, queryParam, departmentId, null, 'tabDepartmentPanel');
            showPanel(128);

        })

        $("#tabMasterTest").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabMasterTestPanel';
            get_forms(129, 0, queryParam, departmentId, null, 'tabMasterTestPanel');
            showPanel(129);

        })

        $("#tabChildTest").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabChildTestPanel';
            get_forms(132, 0, queryParam, departmentId, null, 'tabChildTestPanel');
            showPanel(132);

        })

        $("#tabUnitMaster").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel';
            get_forms(135, 0, queryParam, departmentId, null, 'tabUnitMasterPanel');
            showPanel(135);
        })
		$("#tabSubgroupMaster").on('click',function (event) {
			document.getElementById("hiddenDivName").value= 'tabSubgroupMasterPanel';
			// get_forms(135, 0, queryParam, departmentId, null, 'tabUnitMasterPanel');
			showPanel1('subgroup');
		})
		$("#masterTestId").select2(
				{
					ajax: {
						url: "<?php echo base_url() ?>getMasterTestData",
						type: "post",
						dataType: "json",
						delay: 250,
						data: function (params) {
							return {
								searchTerm: params.term // search term
							};
						},
						processResults: function (response) {
							return {
								results: response
							};
						},
						cache: true
					},
					minimumInputLength: 3
				}
		);
    })

    function showPanel(id) {
        let panel =parseInt(id);

        $(".content-wrap section").removeClass("content-current");
        $("#lab_master_top_nav li").removeClass("tab-current")
        if(panel ===128){
            $("#lab_master_top_nav li:nth-child(1)").addClass("tab-current")
            $("#departmentPanel").addClass("content-current");
        }
        if(panel ===129){
            $("#lab_master_top_nav li:nth-child(2)").addClass("tab-current")
            $("#masterTestPanel").addClass("content-current");
        }
        if(panel ===132){
            $("#lab_master_top_nav li:nth-child(3)").addClass("tab-current")
            $("#childTestPanel").addClass("content-current");
        }
        if(panel ===135){
            $("#lab_master_top_nav li:nth-child(4)").addClass("tab-current")
            $("#unitMasterPanel").addClass("content-current");
        }

    }
	function showPanel1(panel) {
		$(".content-wrap section").removeClass("content-current");
		$("#lab_master_top_nav li").removeClass("tab-current")
		if(panel=='subgroup'){
			$("#lab_master_top_nav li:nth-child(5)").addClass("tab-current")
			$("#subgroupMasterPanel").addClass("content-current");
		}
	}
</script>
<script>

	function loadEditableTable(masterId) {
		// console.log(masterId);
		// console.log("p id = == "+localStorage.getItem("patient_id"));
		let formData = new FormData();
		formData.set("masterId", masterId);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLabMasterChildEntryExcelData") ?>",
			dataType: "json",
			data:formData,
			contentType:false,
			processData:false,
			success: function (result) {
				let rows=[['','','','','']];
				if(result.status==200)
				{
					rows = result.rows;
				}
				let source=result.source;
				var types = [
					{type: 'text'},
					{type: 'text'},
					{type: 'text'},
					// {type: 'text'},
					{type: 'dropdown',source:source,isRequired:false},
					{type: 'text'},
				];
				var hideArra = [0,2];
				var columns = ["Id",'Test Name(A)', 'Method(B)', 'Unit(C)', 'Bio Ref Interval(D)'];
				hideColumn = {
					// specify columns hidden by default
					columns: hideArra,
					copyPasteEnabled: false,
				};
				// console.log(result.body);
				createHandonTable(columns, rows, types, 'tabSubgroupMasterPanel', hideColumn);

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
			columns: columnTypes,
			beforeRemoveRow :(index) => {

				var data = hotDiv.getDataAtRow(index);
				if(data.length !== 0)
				{
					if(data[0]!=null && data[0]!="")
					{
						RemoveRowData(data[0],1);
					}
				}
			},
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

		// hotDiv.validateCells();
	}
	function saveSubgroupBtn() {

		let data=hotDiv.getData();
		let formData = new FormData();
		formData.set("arrayData", JSON.stringify(data));
		formData.set("master_id", $("#masterTestId").val());
		if (confirm("Are You Sure You want to upload?")) {
			$.LoadingOverlay("show");
			$.ajax({
				url: "<?= base_url();?>" + "saveSubGroupChildData",
				type: "POST",
				dataType: "json",
				data:formData,
				contentType:false,
				processData:false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						app.successToast(result.body);
					} else {
						app.errorToast(result.body);
					}
				},
				error: function (error) {

					$.LoadingOverlay("hide");
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		}
	}
	function RemoveRowData(id,type) {
		let formData = new FormData();
		formData.set("id", id);
		if (confirm("Are You Sure You want to Remove Data?")) {
			$.LoadingOverlay("show");
			$.ajax({
				url: "<?= base_url();?>" + "RemoveChildTestData",
				type: "POST",
				dataType: "json",
				data:formData,
				contentType:false,
				processData:false,
				success: function (result) {
					$.LoadingOverlay("hide");
					if (result.status == 200) {
						app.successToast(result.body);
					} else {
						app.errorToast(result.body);
					}
				},
				error: function (error) {
					$.LoadingOverlay("hide");
					console.log(error);
					// $.LoadingOverlay("hide");
				}
			});
		}
	}
</script>
