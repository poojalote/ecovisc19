	<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
    @media (max-width: 800px) {

        body.layout-2 .main-content {
            padding-top: 5px !important;
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

    }

    .select2-container {
        width: 100% !important;
    }
</style>
<style>
    .content-wrap section
    {
        text-align: unset!important;
    }
    #saveButton_inlineformtable_button_96
    {
        margin: 10px!important;
    }
    #form_143 .div_display
    {
        height: 100%!important;
    }
    #form_143 .spanLabel
    {
        top:unset!important;
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section section-body_new">
        <!--		<div class="section-header card-primary">-->
        <!--			<h1 id="section_name">-</h1>-->
        <!--		</div>-->
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
                        <input type="hidden" id="hiddenDivName" name="hiddenDivName" value="">
						<input type="hidden" id="excelhiddenelement" name="excelhiddenelement" value="">
                        <!-- <div class="card-header">
                            <h4>Department Details</h4>
                            <div class="card-header-action">
                                <div class="row">
                                    <div class="form-group mx-2 my-0">
                                        <select class="form-control" id='allCompanies' onchange="loadDepartment(2,this.value)">

                                        </select>
                                    </div>
                                <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#fire-modal-department" id="addDepartment"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div> -->

                        <div class="card-body">
                            <!--     <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="package-tab1" data-toggle="tab"
                                           href="#package-panel1" role="tab" aria-controls="package-panel1"
                                           aria-selected="true" onclick="loadPackageData(136,'package-panel1')">Lab Service
                                            Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="package-tab2" data-toggle="tab" href="#package-panel2"
                                           role="tab" aria-controls="package-panel2" aria-selected="false"
                                           onclick="loadPackageData(143,'package-panel2')">Lab Data Entry</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="package-tab3" data-toggle="tab" href="#package-panel3"
                                           role="tab" aria-controls="package-panel3" aria-selected="false"
                                           onclick="getPatientLabReportList()">Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="package-tab4" data-toggle="tab" href="#package-panel4"
                                           role="tab" aria-controls="package-panel4" aria-selected="false"
                                           onclick="loadPackageData(144,'package-panel4')">Payment</a>
                                    </li>

                                </ul> -->
                            <!--   <div class="tab-content" id="masterpackagetabs">
                                  <div class="tab-pane fade show active" id="package-panel1" role="tabpanel"
                                       aria-labelledby="package-tab1">

                                  </div>
                                  <div class="tab-pane fade" id="package-panel2" role="tabpanel"
                                       aria-labelledby="package-tab2">

                                  </div>
                                  <div class="tab-pane fade" id="package-panel3" role="tabpanel"
                                       aria-labelledby="package-tab3">

                                  </div>
                                   <div class="tab-pane fade" id="package-panel4" role="tabpanel"
                                       aria-labelledby="package-tab4">

                                  </div>

                              </div> -->
                            <div class="tabs tabs-style-underline">
                                <!--  <nav>
                                     <ul id="lab_master_top_nav">
                                         <li class="tab-current">
                                             <a href="#departmentPanel0" class="icon" id="tabDepartment">
                                                 <i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
                                                 <span>Lab Service Order</span>
                                             </a>
                                         </li>
                                         <li class="">
                                             <a href="#masterTestPanel0" class="icon" id="tabMasterTest">
                                                 <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                 <span>Lab Data Entry</span></a></li>
                                         <li class="">
                                             <a href="#childTestPanel0" class="icon" id="tabChildTest">
                                                 <i class="fas fa-capsules mr-1 fa_class"></i>
                                                 <span>Report</span></a></li>
                                         <li class="">
                                             <a href="#unitMasterPanel0" class="icon" id="tabUnitMaster"
                                             ><i class="fas fa-vial mr-1 fa_class"></i>
                                                 <span>Payment</span></a></li>
                                     </ul>
                                 </nav> -->
                                <div class="content-wrap content-wrap1" id="lab_master_panel">
                                    <section id="departmentPanel0" class="content-current">
                                        <div id="tabdepartmentPanel0">
                                            <form id="labserviceorder">
                                                <div class="row p-2">
                                                    <div class="col-md-6">
                                                        <label>Select Service</label>
                                                        <select class="form-control" name="service_name" id="service_name"
                                                                onchange="getServiceChildTest(this.value)">

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Select Package</label>
                                                        <select class="form-control" name="package_name" id="package_name"
                                                                onchange="getPackageChildTest(this.value)">

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Rate</label>
                                                        <input type="number" class="form-control" name="service_rate"
                                                               id="service_rate">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Service Date</label>
                                                        <input type="date" class="form-control" name="service_date"
                                                               id="service_date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Comment</label>
                                                        <textarea class="form-control" name="comment" id="comment"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row p-2" id="service_data">

                                                </div>
                                                <div class="row p-2" id="service_data">
                                                    <button type="button" class="btn btn-primary form-control col-md-3"
                                                            onclick="saveLabServiceOrder()">Order Confirm
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="row p-2">
                                                <table class="table" id="serviceLabOrderTable" style="width: 100%!important;">
                                                    <thead>
                                                    <tr>
                                                        <th>Service Order</th>
                                                        <th>Amount</th>
                                                        <th>Service Order Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
                                    <section id="masterTestPanel0">
										<div class="tabs tabs-style-underline">
											<nav>
												<ul id="lab_entry_top_nav">
													<li class="tab-current" id="LabTabNormal">
														<a href="#labEntryNormalPanel" class="icon" id="labEntryTabNormal">
															<i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
															<span>Lab Data Entry</span>
														</a>
													</li>
                                                    <li class="" id="LabTabHandson">
                                                        <a href="#labEntryHandsonPanel" class="icon" id="labEntryTabHandson">
                                                            <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                            <span>Lab Excel Data Entry</span>
                                                        </a>
                                                    </li>
                                                    <li class="" id="PathologyTab">
                                                        <a href="#pathologyCollectionPanel" class="icon" id="labPathologyCollection">
                                                            <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                            <span>Pathology Collection</span>
                                                        </a>
                                                    </li>
												</ul>
											</nav>
											<div class="content-wrap content-wrap2" id="lab_master_panel">
												<section id="labEntryNormalPanel" class="content-current">
													<div id="tabmasterTestPanel0"></div>
												</section>
                                                <section id="labEntryHandsonPanel">
													<div class="col-md-12 mb-2 text-right">
														<button class="btn btn-primary" type="button" id="saveLabExcelDataEntry" onclick="saveExcelData();">Save</button>
													</div>
													<div class="col-md-3">
														<select name="selectServiceOrder" id="selectServiceOrder" class="form-control" style="font-size: 15px!important;" onchange="getServiceOrderChildList(this.value)"></select>
													</div>
                                                    <div id="tabentryhandsondata"></div>

                                                </section>
                                                <section id="pathologyCollectionPanel">
                                                    <table class="table table-bordered table-stripped" id="pathologyTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Patient Name</th>
                                                                <th>Service Code</th>
                                                                <th style="width: 165px;">Service Name</th>

                                                                <th>Delete Service</th>
                                                                <th>Date and Time</th>
                                                                <th>Confirm Service Given</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </section>
											</div>
										</div>

                                    </section>
                                    <section id="childTestPanel0">
										<div class="tabs tabs-style-underline">
											<nav>
												<ul id="lab_report_top_nav">
													<li class="tab-current" id="LabTabLab">
														<a href="#labReportNormalPanel" class="icon" id="labDataNormal">
															<i class="fas fa-file-medical-alt  mr-1 fa_class"></i>
															<span>Lab Reports</span>
														</a>
													</li>
													<li class="" id="LabTabPath">
														<a href="#labReportPathologyPanel" class="icon" id="labDataPathology">
															<i class="fas fa-notes-medical  mr-1 fa_class"></i>
															<span>Pathology Reports</span>
														</a>
													</li>
												</ul>
											</nav>
											<div class="content-wrap content-wrap3" id="lab_reportPath_panel">
												<section id="labReportNormalPanel" class="content-current">
													<div id="tabchildTestPanel0">
														<table class="table" id="patientServiceLabReportTable" style="width: 100%!important;">
															<thead>
															<tr>
																<th>Service Order</th>
																<th>Amount</th>
																<th>Service Order Date</th>
																<th>Action</th>
															</tr>
															</thead>
															<tbody>

															</tbody>
														</table>
													</div>
												</section>
												<section id="labReportPathologyPanel">
													<div id="tabchildTestPanelPath0"></div>
												</section>
											</div>
										</div>

                                    </section>
                                    <section id="unitMasterPanel0">
										<div class="row mb-2"><button class="btn btn-primary odpsction" type="button"
																	  style="margin-right:10px;margin-left: auto;float:right;"
																	  id="CloseBillButton" onclick="Close_billing()">Close Billing
											</button></div>
                                        <div id="tabunitMasterPanel0"></div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="">

                            <!-- <div id="ShowForm">
                                <div id="form_data"></div>
                                <div id="form_data1"></div>
                                <div id="form_data_report" class="" style="display: none"></div>
                            </div>
                            <div id="ShowHistory" class="" style="display:none">
                                History Table show here
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="lab-service-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body py-0">
                <div class="card my-0 shadow-none">
                    <div class="card-body">
                        <div>
                            <table class="table" id="serviceLabOrderChild" style="width: 100%!important;">
                                <thead>
                                <tr>
                                    <th>Test Name</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="deleteSampleModel"
     aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body py-0">
                <div class="card my-0 shadow-none">
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="sampleList">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="ListPathologyServicesModal"
     aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="PathologyFileUploadationForm2" method="post">
                <div class="modal-header">
                    <h5>Pathology Sample Collection</h5>
                </div>
                <div class="modal-body py-0">
                    <div class="card my-0 shadow-none">
                        <div class="card-body">

                            <div id="PathologyServiceList"></div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="service_file">File Upload</label>
                                    <input type="file" class="form-control" name="service_file[]" multiple=""
                                           data-valid="required" data-msg="Select file" id="service_Path_file">
                                    <span id="radiology_diles_error" style="color: red"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
<script>
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function () {
        get_lableftsidebar();
        // var section_id = $("#section_id").val();
        let queryParam =document.getElementById("queryparameter_hidden").value;
        let sectionId = document.getElementById("section_id").value;
        let departmentId = document.getElementById("department_id").value;
        // get_forms(section_id,0,null,null,null,'package-panel1');
        document.getElementById("hiddenDivName").value= 'tabdepartmentPanel0';
        showPanel(1);
        getServices();
        getPackage();
        getLabServiceOrders();

        $("#tabDepartment0").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabdepartmentPanel0';
            // get_forms(128, 0, queryParam, departmentId, null, 'tabdepartmentPanel0');
            showPanel(1);
			$("#excelhiddenelement").val('');
        })

        $("#tabMasterTest0").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';
            get_forms(143, 0, queryParam, departmentId, null, 'tabmasterTestPanel0');
            showPanel(143);
			$('#LabTabNormal').removeClass('tab-current');
			$('#LabTabHandson').removeClass('tab-current');
			$('#PathologyTab').removeClass('tab-current');
			$('#LabTabNormal').addClass('tab-current');
        });

        $("#tabChildTest0").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabchildTestPanel0';
            // get_forms(132, 0, queryParam, departmentId, null, 'tabchildTestPanel0');
            showPanel(2);
            getPatientLabReportList();
			$("#excelhiddenelement").val('');
			$('#LabTabLab').addClass('tab-current');
			$('#LabTabPath').removeClass('tab-current');
        })

        $("#tabUnitMaster0").on('click',function (event) {
            document.getElementById("hiddenDivName").value= 'tabunitMasterPanel0';
            get_forms(144, 0, queryParam, departmentId, null, 'tabunitMasterPanel0');
            showPanel(144);
            $("#excelhiddenelement").val('');
        })

		$("#labEntryTabNormal").on('click',function (event) {
			// document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';
			// get_forms(143, 0, queryParam, departmentId, null, 'tabmasterTestPanel0');
			get_forms(143, 0, queryParam, departmentId, null, 'tabmasterTestPanel0');
			// showPanel(143);
			showPanel1('Normal',143);
		})
        $("#labEntryTabHandson").on('click',function (event) {
            // document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';
			$("#tabentryhandsondata").html('');
            showPanel1('handson',143);


        })
        $("#labPathologyCollection").on('click',function (event) {
            // document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

            showPanel1('labPathologyCollection',143);

        })
		$("#labDataNormal").on('click',function (event) {
			// document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

			document.getElementById("hiddenDivName").value= 'tabchildTestPanel0';
			// get_forms(132, 0, queryParam, departmentId, null, 'tabchildTestPanel0');
			showPanel(2);
			getPatientLabReportList();
			$("#excelhiddenelement").val('');
			$('#LabTabLab').addClass('tab-current');
			$('#LabTabPath').removeClass('tab-current');

		})
		$("#labDataPathology").on('click',function (event) {
			// document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

			showPanel2('labDataPathology',143);

		})
    });


function getCollectionTable(category, tableID) {
    
    // var p_id = $('#p_id').val();
    //console.log(""+tableID+"");
    let patient_id = localStorage.getItem("patient_id");
    // let formData = new FormData();
    // formData.set("patient_id", patient_id);
    // // if(category=="RADIOLOGY"){
    // let zone = $("#psampleAllPatient").val();
    // if (zone !== null) {
    //     formData.set("zone_id", zone);
    // }
    let base_url = `<?php echo base_url(); ?>`;
    app.dataTable('pathologyTable', {
        url: base_url+"getLabCollectionTable",
        data:{patient_id:patient_id},
        dataType:'json',
    }, [
            {
                data: 0
            },
            {
                data: 1
            },
            {
                data: 2
            },

            {
                data: 3,
				render: (d, t, r, m) => {
					return `<button type="button" class="btn btn-link"
						onclick="deleteServiceOrder('${d}','${tableID}','${category}','${r[4]}')" ><i class="fa fa-times"></i></button>`;
				}
            },
            {
                data: 6
            },
            {
                data: 1,
                render: (d, t, r, m) => {
                    // if (parseInt(r[10]) === 1) {
                    //     let value = 1;
                    //     return `<input type="checkbox" id="sampleCollectionCheckbox_${r[10]}"
                    //         onclick="serviceOrderBillingInfo(${r[1]},${r[4]},${r[5]},${r[9]},${r[10]})">`;
                    // } else {
                        // let value = 0;
                        return `<input type="checkbox"  id="sampleCollectionCheckbox_${r[3]}" 
        onclick="serviceOrderBillingInfo('${r[1]}',${r[4]},${r[5]},${r[9]},${r[3]})">`;
                    // }

                }
            },
    ] )
}


function serviceOrderBillingInfo(service_id, patient_id,branch_id,ext_pid,sid) {
    if ($("#sampleCollectionCheckbox_" + sid).prop('checked') == true) {
        var confirm_service_given = 1;
        $("#ListPathologyServicesModal").modal('show');
        $("#service_Path_file").val('');
        var forminputs = `
        <input type="hidden" id="Pservice_id" name="Pservice_id" value="${service_id}">
        <input type="hidden" id="Ppatient_id" name="Ppatient_id" value="${patient_id}">
        <input type="hidden" id="Pbranch_id" name="Pbranch_id" value="${branch_id}">
        <input type="hidden" id="Pext_pid" name="Pext_pid" value="${ext_pid}">
        <input type="hidden" id="PSid" name="PSid" value="${sid}">
        <input type="hidden" id="Pservice_no" name="Pservice_no" value="PATHOLOGY">
        `;
        // var arr = service_names.split(",");
        // var arr1 = serviceIDS.split(",");

        $("#PathologyServiceList").html("");
        // var data1 = ``;
        // $(arr).each(function (index, data) {

        //     data1 += `<input type="checkbox" checked name="SampleCollectionPathService[]"  id="SampleCollectionService_${index}" value="${arr1[index]}" > ${data} <br>`;
        // });
        // $("#PathologyServiceList").html(data1);
        $("#PathologyServiceList").append(forminputs);

    }

}


$("#PathologyFileUploadationForm2").validate({
    rules: {
        service_file: {
            required: true,
        },

    },
    messages: {
        service_file: {
            required: "Please Select File"
        },

    },
    errorElement: 'span',
    submitHandler: function (form) {
        var file = document.getElementById("service_Path_file");
        if (file.files.length == 0) {
            $("#radiology_diles_error").html("Please Select File");
            // app.errorToast("No files selected");
        } else {
            var formData = new FormData(form);
            formData.append('confirm_service_given', '1');
            formData.append('sample_pickup', '1');
            // console.log(formData);
            SavePathologyProgress2(formData);
        }

    }
});

function SavePathologyProgress2(formData) {
    let base_url = `<?php echo base_url(); ?>`;
    app.request(base_url + "getserviceOrderBillingInfo2", formData).then(response => {
        if (response.status === 200) {
            app.successToast(response.body);
            $(".modal").modal('hide');
            getCollectionTable($("#Pcategory").val(), $("#Ptablename").val(), $("#psampleAllPatient").val());

        } else {
            app.errorToast(response.body);
        }
    }).catch(error => console.log(error));
}

    function showPanel(id) {
        $(".a_menu").css({
            "text-decoration": 'none',
            "color": 'black'
        });
        $('.li_menu').addClass('menu-header_section1').removeClass('menu-header_section active');
        $('.a_menu_' + id).css({
            "text-decoration": 'none',
            "color": 'white'
        });
        $(".li_menu_" + id).addClass('menu-header_section active').removeClass('menu-header_section1');

        let panel =parseInt(id);
        $(".content-wrap1 section").removeClass("content-current");
        $("#lab_master_top_nav li").removeClass("tab-current")
        if(panel ===1){
            $("#lab_master_top_nav li:nth-child(1)").addClass("tab-current")
            $("#departmentPanel0").addClass("content-current");
        }
        if(panel ===143){
            $("#lab_master_top_nav li:nth-child(2)").addClass("tab-current")
            $("#masterTestPanel0").addClass("content-current");
			$("#labEntryNormalPanel").addClass("content-current")
        }
        if(panel ===2){
            $("#lab_master_top_nav li:nth-child(3)").addClass("tab-current")
            $("#childTestPanel0").addClass("content-current");
			$("#labReportNormalPanel").addClass("content-current")
        }
        if(panel ===144){
            $("#lab_master_top_nav li:nth-child(4)").addClass("tab-current")
            $("#unitMasterPanel0").addClass("content-current");
        }

    }
	function showPanel1(id,sectionId) {
		$(".content-wrap2 section").removeClass("content-current");
		$("#lab_entry_top_nav li").removeClass("tab-current")
		if(id=='Normal')
		{
			$("#lab_entry_top_nav li:nth-child(1)").addClass("tab-current")
			$("#labEntryNormalPanel").addClass("content-current");
			get_forms(143, 0, queryParam, departmentId, null, 'tabmasterTestPanel0');
		}
        if(id=='handson')
        {
            $("#lab_entry_top_nav li:nth-child(2)").addClass("tab-current")
            $("#labEntryHandsonPanel").addClass("content-current");
			getServiceOrderList(sectionId);

        }
        if(id=='labPathologyCollection')
        {
            $("#lab_entry_top_nav li:nth-child(3)").addClass("tab-current")
            $("#pathologyCollectionPanel").addClass("content-current");
            // loadEditableTable(sectionId);
            getCollectionTable('PATHOLOGY', 'pathologyTable');
        }
	}
	function showPanel2(id,sectionId) {
		$(".content-wrap3 section").removeClass("content-current");
		$("#lab_report_top_nav li").removeClass("tab-current")

		if(id=='labDataPathology')
		{
			$("#lab_report_top_nav li:nth-child(2)").addClass("tab-current")
			$("#labReportPathologyPanel").addClass("content-current");
			getPathologyReports();
		}
	}
    function loadPackageData(section_id, divId) {
        if (section_id == 136) {
            getServices();
            getPackage();
            // getLabServiceOrders();
        } else {
            $("#section_id").val(section_id);
            $("#hiddenDivName").val(divId);
            get_forms(section_id, 0, null, null, null, divId);
        }
    }
</script>
<script type="text/javascript">
    function getServices() {
        $('#service_name').select2({
            ajax: {
                url: base_url + "getServiceTest",
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
    }

    function getPackage() {
        $('#package_name').select2({
            ajax: {
                url: base_url + "getPackageTest",
                type: "post",
                dataType: "json",
                delay: 250,
                placeholder: "Package Name",
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
    }

    function getServiceChildTest(service_id) {
        let formData = new FormData();
        formData.set("service_id", service_id);
        app.request(base_url + "getServiceChildTest", formData).then(response => {
            $("#service_data").html("");
            if (response.status == 200) {
                //formButton HistoryButton
                $("#service_data").html(response.data);
                $("#service_rate").val(response.rate);
            } else {
                $("#service_rate").val(response.rate);
            }
        });
    }

    function getPackageChildTest(package_id) {
        let formData = new FormData();
        formData.set("package_id", package_id);
        app.request(base_url + "getPackageChildTest", formData).then(response => {
            $("#service_data").html("");
            if (response.status == 200) {
                //formButton HistoryButton
                $("#service_data").html(response.data);
                $("#service_rate").val(response.rate);
            } else {
                $("#service_rate").val(response.rate);
            }
        });
    }

    function saveLabServiceOrder() {
        if ($("#service_name").val() == "" && $("#package_name").val() == "") {
            app.errorToast('Select lab Test or Package test');
        } else {
            var form_data = document.getElementById('labserviceorder');
            var formData = new FormData(form_data);
            formData.set("patient_id", localStorage.getItem("patient_id"));
            // formData.set("patient_id", 2);
            app.request(base_url + "saveLabServiceOrder", formData).then(response => {
                $("#service_data").html("");
                if (response.status == 200) {
                    app.successToast(response.body);
                    $('#labserviceorder').trigger("reset");
                    getLabServiceOrders();
                } else {
                    app.successToast(response.body);
                }
            });
        }

    }

    function getLabServiceOrders() {
        var patient_id = localStorage.getItem("patient_id");
        app.dataTable('serviceLabOrderTable', {
            url: base_url + "getLabServiceOrders",
            data: {patient_id: patient_id},
        }, [
            {
                data: 0
            },
            {
                data: 1
            },
            {
                data: 2
            },
            {
                data: 3,
                render: (d, t, r, m) => {

                    return `<button class="btn btn-primary btn-action mr-1" type="button" onclick="cancelOrder('${r[3]}','${r[5]}')" data-serv_id="${r[3]}"> <i class="fas fa-times"></i> </button>
						<button class="btn btn-primary btn-action mr-1" data-toggle="modal"
						data-target="#lab-service-modal" data-id="${r[3]}" onclick="open_edit_modal('${r[4]}','${r[5]}')" type="button"> <i class="fa fa-eye"></i> </button>`;


                }
            }

        ], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

            $('td:eq(3)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="cancelOrder('${aData[3]}','${aData[5]}')" data-pres_id="${aData[3]}"> <i class="fas fa-times"></i> </button><button class="btn btn-primary btn-action mr-1"  data-toggle="modal" data-target="#lab-service-modal" data-id="${aData[3]}"onclick="open_edit_modal('${aData[4]}','${aData[5]}')" type="button" > <i class="fa fa-eye"></i> </button>`);


        })

    }

    function cancelOrder(order_id, service_type) {
        let formData = new FormData();
        formData.set("service_id", order_id);
        formData.set("service_type", service_type);
		formData.set("patient_id", localStorage.getItem("patient_id"));
        app.request(base_url + "getlabServiceCancelOrder", formData).then(response => {
            $("#service_data").html("");
            if (response.status == 200) {
                //formButton HistoryButton
                getLabServiceOrders();
            } else {
                app.errorToast('Order not Cancel');
            }
        });
    }

    function open_edit_modal(service_id, service_type) {
        var patient_id = localStorage.getItem("patient_id");
        app.dataTable('serviceLabOrderChild', {
            url: base_url + "getlabServiceChildOrder",
            data: {patient_id: patient_id, service_id: service_id, service_type: service_type},
        }, [
            {
                data: 0
            }

        ], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

        })

    }

    function showLabPatientReport() {
        let formData = new FormData();
        formData.set("patient_id", localStorage.getItem("patient_id"));
        app.request(base_url + "showLabPatientReport", formData).then(response => {
            $("#package-panel3").html("");
            if (response.status == 200) {
                //formButton HistoryButton
                $("#package-panel3").html(response.data);
            } else {
                // app.errorToast('');
            }
        });
    }
	function getPatientLabReportList()
	{
		var patient_id = localStorage.getItem("patient_id");
		app.dataTable('patientServiceLabReportTable', {
			url: base_url + "getLabServiceOrders1",
			data: {patient_id: patient_id},
		}, [
			{
				data: 0
			},
			{
				data: 1
			},
			{
				data: 2
			},
			{
				data: 3,
				render: (d, t, r, m) => {
					let reportArray ={"patient_id":patient_id,"service_id":r[3]};
					let string = btoa(JSON.stringify(reportArray));
					// if(r[6]==r[7]){
						return `
                        <a class="btn btn-primary" href="${base_url+'patientLabReport/'+string}" target="_blank"><i class="fa fa-file"></i></a>`;

					// }
					// else
					// {
					// 	return ``;
					// }
				}
			}

		], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			let reportArray ={"patient_id":patient_id,"service_id":aData[3]};
			let string = btoa(JSON.stringify(reportArray));
			// if(aData[6]==aData[7]){
				$('td:eq(3)', nRow).html(`<a class="btn btn-primary" href="${base_url+'patientLabReport/'+string}" target="_blank"><i class="fa fa-file"></i></a>`);
			// }
			// else
			// {
			// 	$('td:eq(3)', nRow).html(``);
			// }

		})

	}


    function loadLabEntry() {
            getAllPatientOrderServices();
    }
    function getAllPatientOrderServices() {

        var patient_id = 2//localStorage.getItem("patient_id");
        let formData = new FormData();
        formData.set("patient_id", patient_id);
        app.request(base_url+"getServiceOrderOptions",formData).then(res=>{
            if(res.status ===200){
                $("#ddl_patient_services").select2({
                    data:res.data
                })
                $("#ddl_patient_services").on("change",function (e) {
                    getPatientLabSelectedReportList($(this).val());
                })
            }

        })
    }

    let units ;

        function getPatientLabSelectedReportList(service_id) {

        var patient_id = 2//localStorage.getItem("patient_id");
        let formData = new FormData();
        formData.set("patient_id", patient_id);
        formData.set("order_id", service_id);
        app.request(base_url + "getPatientLabOrders", formData).then(res => {

            if (res.status == 200) {
                let unitsOptions=`<option>None</option>`;
                 unitsOptions += res.units.map(i=>{
                    return `<option value="${i.id}">${i.name}</option>`;
                });
                units = res.units;



                $("#order_child_test_data_entry").dataTable({
                    data: res.data,
                    "paging":   false,
                    "ordering": false,
                    "info":     false,
                    columns: [
                        {
                            data: 1
                        },
                        {
                            data: 0,
                            render: (d, t, r, m) => {
                                return `<input type="text" class="form-control" name="value_${d}" />`;
                            }
                        },
                        {
                            data: 0,
                            render: (d, t, r, m) => {
                                return `<select class="form-control" style="width: 100%" name="unit_${d}" onchange="updateUnit(this.value,${m.row})">${unitsOptions}</select>`;
                            }
                        },
                        {
                            data: 0,
                            render: (d, t, r, m) => {
                                return `<textarea class="form-control" style="width: 100%" name="reference_${d}" id="reference_${m.row}" ></textarea>`;
                            }
                        }

                    ]
                })
            }
        })

    }



    function updateUnit(value,index) {
        let newIndex=units.findIndex(i=>{ return parseInt(i.id) == parseInt(value)});
        if( newIndex !==-1){
            $("#reference_"+index).val(units[newIndex].referance);
        }


    }

</script>
<script type="text/javascript">
	function Close_billing() {
		var p_id = localStorage.getItem("patient_id");
		$.ajax({
			type: "POST",
			url: '<?= base_url("LabPatientController/ChangeBillingOpen")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status == 200) {

					app.successToast(result.body);
					checkBillingStatus();
				} else {
					app.errorToast(result.body);
				}
			}
		});
	}

	function checkBillingStatus() {
		var p_id = localStorage.getItem("patient_id");
		$.ajax({
			type: "POST",
			url: '<?= base_url("LabPatientController/check_billing_status")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {

				if (result.status == 200) {
					var value = result.value;
					if (value == 1) {
						$("#CloseBillButton").html("Billing Already Close");
						// $('.a_menu22').hide();
					} else {
						$("#CloseBillButton").html("Close Billing");
						// $('.a_menu22').show();
					}
				} else {

				}
			}
		});
	}

</script>
<script>
	function loadEditableTable(sectionId,service_order_id) {
		$("#saveLabExcelDataEntry").hide();
        // console.log("p id = == "+localStorage.getItem("patient_id"));
		let formData = new FormData();
		formData.set("section_id", sectionId);
		formData.set("dep_id", $("#department_id").val());
		formData.set("haskey", $("#excelhiddenelement").val());
        formData.set('queryParam',$('#queryparameter_hidden').val());
		formData.set('order_id',service_order_id);
		$.ajax({
			type: "POST",
			url: "<?= base_url("getLabDataEntryExcelData") ?>",
			dataType: "json",
			data:formData,
			contentType:false,
			processData:false,
			success: function (result) {
				let userType=[];
				if(result.status==200)
				{
					userType=result.data;
					$("#saveLabExcelDataEntry").show();
				}
                data = result.body;
				var rows = data;
				var types = [
                    {type: 'text'},
					{type: 'text'},
					{type: 'text'},
                    {type: 'text'},
                    {type: 'text',readOnly:true},
                    {type: 'text'},
                    {type: 'text'},
					{type: 'text'},
					{type: 'text'},
				];
				var hideArra = [0,4,5,6,7,8];
				var columns = ["Master Id",'Test Name(A)', 'Value(B)', 'Unit(C)', 'Bio Ref Interval(D)',"Child Test Id","Id","OrderId","Master Name"];
				hideColumn = {
					// specify columns hidden by default
					columns: hideArra,
					copyPasteEnabled: false,
				};
                // console.log(result.body);
				createHandonTable(columns, rows, types, 'tabentryhandsondata', hideColumn);

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

    function saveExcelData() {
        $.LoadingOverlay("show");
        // $("#newErrorDiv").html('');
        var array=hotDiv.getData();
		var Form_data = new FormData();
		Form_data.set('patient_id',localStorage.getItem("patient_id"));
		Form_data.set('value',JSON.stringify(array));
		Form_data.set('patient_name',localStorage.getItem("patient_name"));
		Form_data.set('patient_adhar',localStorage.getItem("patient_adharnumber"));
        if (confirm("Are You Sure You want to upload?")) {
            $.ajax({
                url: "<?= base_url();?>" + "updateDynamicLabData",
                type: "POST",
                dataType: "json",
                data: Form_data,
				contentType: false,
				processData: false,
                success: function (result) {
                    $.LoadingOverlay("hide");
                    if (result.status == 200) {
                        app.successToast(result.body);
						loadEditableTable(143,$("#selectServiceOrder").val());

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
    function getPathologyReports() {
		$.LoadingOverlay("show");
		$("#tabchildTestPanelPath0").html('');
		$.ajax({
			url: "<?= base_url();?>" + "getLabPathologyTableData",
			type: "POST",
			dataType: "json",
			data: {p_id:localStorage.getItem("patient_id")},
			success: function (result) {
				$.LoadingOverlay("hide");
				if (result.status == 200) {
					$("#tabchildTestPanelPath0").html(result.data);
				} else {
					toastr.error(result.body);

				}
			},
			error: function (error) {

				$.LoadingOverlay("hide");
				console.log(error);
				// $.LoadingOverlay("hide");
			}
		});
	}

	function radiologyDownloadButtons(download_data) {
		let samples = download_data.split(',');
		var filedata=[];
		var interval=samples.length;
		if(samples.length>0)
		{
			for (var i =0; samples.length > 0; i++) {
				// filedata.push(samples[i]);
				if (i >= samples.length) {
					break;
				}
				var a = document.createElement("a");
				a.setAttribute('href', "<?= base_url();?>"+samples[i]);
				a.setAttribute('download', '');
				a.setAttribute('target', '_blank');
				a.click();

			}

			// console.log(filedata);
		}

	}
	function deleteServiceOrder(service_id,table_id,category,patient_id) {
		let confirmAction = confirm("Are you sure to you want confirm service");
		if (confirmAction) {
			$.ajax({
				url: "<?= base_url();?>" + "deletePathologyServiceOrder",
				type: "POST",
				dataType: "json",
				data: {service_order_id: service_id, patient_id: patient_id},
				success: function (response) {
					if (response.status == 200) {
						app.successToast(response.body);
						getCollectionTable(category, table_id);
					} else {
						app.errorToast(response.body);
					}
				},
				error: function (error) {

					console.log(error);
				}
			});
		}
	}
	function getServiceOrderList(sectionId) {
		$("#selectServiceOrder").html("");
		let patient_id=localStorage.getItem("patient_id");
		$.ajax({
			url: "<?= base_url();?>" + "getServiceOrderList",
			type: "POST",
			dataType: "json",
			data: {patient_id: patient_id},
			success: function (response) {
				if (response.status == 200) {
					$("#selectServiceOrder").append(response.data);
					$("#selectServiceOrder").select2({});
				} else {
					// app.errorToast(response.body);
				}
			},
			error: function (error) {
				console.log(error);
			}
		});
	}
	function getServiceOrderChildList(service_id) {
		let sectionId=143;
		loadEditableTable(sectionId,service_id);

	}
</script>
