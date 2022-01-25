<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<style>
    .content-wrap section
    {
        text-align: unset!important;
    }
    .div_display{
        height: 100% !important;
    }
    .card_body137{
        padding-bottom: 32px !important;
    }
    #lab_master_top_nav1 li a
    {
        font-size: 12px!important;
    }
    #tabMasterTestPanel .div_display{
        width: 100%!important;
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
                               value="<?= $dep_id ?>">
                        <input type="hidden" id="section_id" name="section_id"
                               value="<?= $section_id ?>">
                        <input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
                               value="<?= $string_param ?>">
                        <input type="hidden" id="hiddenDivName" name="hiddenDivName">

                        <section id="profileSection">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <!--  <ul class="nav nav-pills" id="myTab3" role="tablist">
                                         <li class="nav-item">
                                             <a class="nav-link active" id="package-tab3" data-toggle="tab" href="#package-panel3" role="tab" aria-controls="package-panel1" aria-selected="true" onclick="loadPackageData(137,'stuplabdiv')">Setup Lab Master Test</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="package-tab4" data-toggle="tab" href="#package-panel4" role="tab" aria-controls="package-panel1" aria-selected="false" onclick="loadPackageData(139,'package-panel4')">Setup Lab Child Test</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="package-tab1" data-toggle="tab" href="#package-panel1" role="tab" aria-controls="package-panel1" aria-selected="false" onclick="loadPackageData(140,'package-panel1')">Master Package</a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" id="package-tab2" data-toggle="tab" href="#package-panel2" role="tab" aria-controls="package-panel2" aria-selected="false" onclick="loadPackageData(141,'package-panel2')">Set Master Package</a>
                                         </li>

                                     </ul>
  -->
                                    <!--   <div class="tab-content" id="masterpackagetabs">
                                         <div class="tab-pane fade show active" id="package-panel3" role="tabpanel" aria-labelledby="package-tab3">
                                             <div class="tabs tabs-style-underline" id="stuplabdiv">


                                             </div>
                                         </div>
                                          <div class="tab-pane fade" id="package-panel4" role="tabpanel" aria-labelledby="package-tab4">

                                         </div>

                                         <div class="tab-pane fade" id="package-panel1" role="tabpanel" aria-labelledby="package-tab1">

                                         </div>
                                         <div class="tab-pane fade" id="package-panel2" role="tabpanel" aria-labelledby="package-tab2">

                                         </div>

                                     </div> -->

                                    <div class="tabs tabs-style-underline">
                                        <nav>
                                            <ul id="lab_master_top_nav">
                                                <li class="tab-current">
                                                    <a href="#departmentPanel" class="icon" id="tabDepartment">
                                                        <i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
                                                        <span>Setup Lab Master Test</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#masterTestPanel" class="icon" id="tabMasterTest">
                                                        <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                        <span>Setup Lab Child Test</span></a></li>
                                                <li class="">
                                                    <a href="#childTestPanel" class="icon" id="tabChildTest">
                                                        <i class="fas fa-capsules mr-1 fa_class"></i>
                                                        <span>Master Package</span></a></li>
                                                <li class="">
                                                    <a href="#unitMasterPanel" class="icon" id="tabUnitMaster"
                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                        <span>Set Master Package</span></a></li>
                                            </ul>
                                        </nav>
                                        <div class="content-wrap" id="lab_master_panel">
                                            <section id="departmentPanel" class="content-current">
                                                <div id="tabDepartmentPanel">
                                                    <div class="tabs tabs-style-underline">
                                                        <nav>
                                                            <ul id="lab_master_top_nav1">
                                                                <li class="tab-current">
                                                                    <a href="#departmentPanel1" class="icon" id="tabDepartment1">
                                                                        <i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
                                                                        <span>Biochemistry</span>
                                                                    </a>
                                                                </li>
                                                                <li class="">
                                                                    <a href="#masterTestPanel1" class="icon" id="tabMasterTest1">
                                                                        <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                                        <span>Lab Immunology</span></a></li>
                                                                <li class="">
                                                                    <a href="#childTestPanel1" class="icon" id="tabChildTest1">
                                                                        <i class="fas fa-capsules mr-1 fa_class"></i>
                                                                        <span>Haematology</span></a></li>
                                                                <li class="">
                                                                    <a href="#unitMasterPanel1" class="icon" id="tabUnitMaster1"
                                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                                        <span>Hispathology</span></a></li>
                                                                <li class="">
                                                                    <a href="#unitMasterPanel2" class="icon" id="tabUnitMaster2"
                                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                                        <span>Microbiology</span></a></li>
                                                                <li class="">
                                                                    <a href="#unitMasterPanel3" class="icon" id="tabUnitMaster3"
                                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                                        <span>Molecular Biology</span></a></li>
                                                                <li class="">
                                                                    <a href="#unitMasterPanel4" class="icon" id="tabUnitMaster4"
                                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                                        <span>Blood Bank</span></a></li>
                                                                <li class="">
                                                                    <a href="#unitMasterPanel5" class="icon" id="tabUnitMaster5"
                                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                                        <span>PRO-CPY</span></a></li>
                                                            </ul>
                                                        </nav>
                                                        <div class="content-wrap content-wrap1" id="lab_master_panel1">
                                                            <section id="departmentPanel1" class="content-current1">
                                                                <div id="tabDepartmentPanel1"></div>
                                                            </section>
                                                            <section id="masterTestPanel1">
                                                                <div id="tabMasterTestPanel1"></div>
                                                            </section>
                                                            <section id="childTestPanel1">
                                                                <div id="tabChildTestPanel1"></div>
                                                            </section>
                                                            <section id="unitMasterPanel1">
                                                                <div id="tabUnitMasterPanel1"></div>
                                                            </section>
                                                            <section id="unitMasterPanel2">
                                                                <div id="tabUnitMasterPanel2"></div>
                                                            </section>
                                                            <section id="unitMasterPanel3">
                                                                <div id="tabUnitMasterPanel3"></div>
                                                            </section>
                                                            <section id="unitMasterPanel4">
                                                                <div id="tabUnitMasterPanel4"></div>
                                                            </section>
                                                            <section id="unitMasterPanel5">
                                                                <div id="tabUnitMasterPanel5"></div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <section id="masterTestPanel">
<!--                                                <div id="tabMasterTestPanel"></div>-->
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
												<div id="ErrorDiv" class="mt-2"></div>
												<div id="tabSubgroupMasterPanel" class="col-md-12 mt-2"></div>
                                            </section>
                                            <section id="childTestPanel">
                                                <div id="tabChildTestPanel"></div>
                                            </section>
                                            <section id="unitMasterPanel">
                                                <div id="tabUnitMasterPanel"></div>
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
        // get_forms(sectionId, 0, queryParam, departmentId, null, 'tabDepartmentPanel');
        showPanel(sectionId);



        $("#tabDepartment").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabDepartmentPanel';
            // get_forms(137, 0, queryParam, departmentId, null, 'tabDepartmentPanel');
            showPanel(137);

        })

        $("#tabMasterTest").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabMasterTestPanel';
            // get_forms(139, 0, queryParam, departmentId, null, 'tabMasterTestPanel');
            showPanel2('subgroup');

        })

        $("#tabChildTest").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabChildTestPanel';
            get_forms(140, 0, queryParam, departmentId, null, 'tabChildTestPanel');
            showPanel(140);

        })

        $("#tabUnitMaster").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel';
            get_forms(141, 0, queryParam, departmentId, null, 'tabUnitMasterPanel');
            showPanel(141);
        })

        let newqueryParamdata=JSON.parse(atob(queryParam));
        newqueryParamdata.department_id="1";
        var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
        document.getElementById("queryparameter_hidden").value=newqueryParam;
        // console.log(newqueryParam);
        get_forms(137, 0, newqueryParam, departmentId, null, 'tabDepartmentPanel1');
        showPanel1(1);
        $("#tabDepartment1").on('click',function (event) {
            newqueryParamdata.department_id="1";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabDepartmentPanel1';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabDepartmentPanel1');
            showPanel1(1);

        })

        $("#tabMasterTest1").on('click',function (event) {
            newqueryParamdata.department_id="2";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabMasterTestPanel1';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabMasterTestPanel1');
            showPanel1(2);

        })

        $("#tabChildTest1").on('click',function (event) {
            newqueryParamdata.department_id="3";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabChildTestPanel1';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabChildTestPanel1');
            showPanel1(3);

    });
    // function loadPackageData(section_id,divId)
    // {
    //     $("#section_id").val(section_id);
    //     get_forms(section_id,0,null,null,null,divId);
    // }

        $("#tabUnitMaster1").on('click',function (event) {
            newqueryParamdata.department_id="4";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel1';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabUnitMasterPanel1');
            showPanel1(4);
        })
        $("#tabUnitMaster2").on('click',function (event) {
            newqueryParamdata.department_id="5";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel2';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabUnitMasterPanel2');
            showPanel1(5);
        })
        $("#tabUnitMaster3").on('click',function (event) {
            newqueryParamdata.department_id="6";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel3';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabUnitMasterPanel3');
            showPanel1(6);
        })
        $("#tabUnitMaster4").on('click',function (event) {
            newqueryParamdata.department_id="7";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel4';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabUnitMasterPanel4');
            showPanel1(7);
        })
        $("#tabUnitMaster5").on('click',function (event) {
            newqueryParamdata.department_id="8";
            var newqueryParam=btoa(JSON.stringify(newqueryParamdata));
            document.getElementById("queryparameter_hidden").value=newqueryParam;
            document.getElementById("hiddenDivName").value= 'tabUnitMasterPanel5';
            get_forms(137, 0, newqueryParam, departmentId, null, 'tabUnitMasterPanel5');
            showPanel1(8);
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
    });

    //  function loadPackageData(section_id,divId)
    // {
    //     $("#section_id").val(section_id);
    //     get_forms(section_id,0,null,null,null,divId);
    // }
    function showPanel(id) {
        let panel =parseInt(id);
        $(".content-wrap section").removeClass("content-current");

        $("#lab_master_top_nav li").removeClass("tab-current")
        if(panel ===137){
            $("#lab_master_top_nav li:nth-child(1)").addClass("tab-current")
            $("#departmentPanel").addClass("content-current");
        }
        // if(panel ===139){
        //     $("#lab_master_top_nav li:nth-child(2)").addClass("tab-current")
        //     $("#masterTestPanel").addClass("content-current");
        // }
        if(panel ===140){
            $("#lab_master_top_nav li:nth-child(2)").addClass("tab-current")
            $("#childTestPanel").addClass("content-current");
        }
        if(panel ===141){
            $("#lab_master_top_nav li:nth-child(3)").addClass("tab-current")
            $("#unitMasterPanel").addClass("content-current");
        }
    }
    function showPanel1(id) {
        let panel =parseInt(id);
        $(".content-wrap1 section").removeClass("content-current");
        $(".content-wrap1 section div").html("");
        $("#lab_master_top_nav1 li").removeClass("tab-current")
        if(panel ===1){
            $("#lab_master_top_nav1 li:nth-child(1)").addClass("tab-current")
            $("#departmentPanel1").addClass("content-current");
        }
        if(panel ===2){
            $("#lab_master_top_nav1 li:nth-child(2)").addClass("tab-current")
            $("#masterTestPanel1").addClass("content-current");
        }
        if(panel ===3){
            $("#lab_master_top_nav1 li:nth-child(3)").addClass("tab-current")
            $("#childTestPanel1").addClass("content-current");
        }
        if(panel ===4){
            $("#lab_master_top_nav1 li:nth-child(4)").addClass("tab-current")
            $("#unitMasterPanel1").addClass("content-current");
        }
        if(panel ===5){
            $("#lab_master_top_nav1 li:nth-child(5)").addClass("tab-current")
            $("#unitMasterPanel2").addClass("content-current");
        }
        if(panel ===6){
            $("#lab_master_top_nav1 li:nth-child(6)").addClass("tab-current")
            $("#unitMasterPanel3").addClass("content-current");
        }
        if(panel ===7){
            $("#lab_master_top_nav1 li:nth-child(7)").addClass("tab-current")
            $("#unitMasterPanel4").addClass("content-current");
        }
        if(panel ===8){
            $("#lab_master_top_nav1 li:nth-child(8)").addClass("tab-current")
            $("#unitMasterPanel5").addClass("content-current");
        }
    }
	function showPanel2(id) {
		$(".content-wrap section").removeClass("content-current");
		$("#lab_master_top_nav li").removeClass("tab-current")
		if(id ==='subgroup'){
		    $("#lab_master_top_nav li:nth-child(2)").addClass("tab-current")
		    $("#masterTestPanel").addClass("content-current");
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
					{type: 'dropdown',source:source,allowInvalid:true,filter: false,strict:false},
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
			// filters: true,
			contextMenu: true,
			hiddenColumns: hideColumn,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar'],
			licenseKey: 'non-commercial-and-evaluation'
		});

		// hotDiv.validateCells();
	}
	function saveSubgroupBtn() {
		$("#ErrorDiv").html('');
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
						loadEditableTable($("#masterTestId").val());
					}else if(result.status==202)
					{
						$("#ErrorDiv").append(`<div style="font-size: 14px;"><div class="alert alert-light alert-has-icon">
                  <div class="alert-icon"><i class="fa fa-edit"></i></div>
                     <div class="alert-body">
                     <div class="alert-title">At this Position Data will be <b>Mandatory</b> </div>
                        ${result.error}
                     </div>
                 </div></div>`);
					}
					else
					{
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
