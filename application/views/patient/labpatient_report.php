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
    <style>
            #exTab1 .tab-content {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }

            #exTab2 h3 {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }

            /* remove border radius for the tab */

            #exTab1 .nav-pills > li > a {
              border-radius: 0;
            }

            /* change border radius for the tab , apply corners on top*/

            #exTab3 .nav-pills > li > a {
              border-radius: 4px 4px 0 0 ;
            }

            #exTab3 .tab-content {
              color : white;
              background-color: #428bca;
              padding : 5px 15px;
            }

            .activeTabPanelBtn{
                border: 1px solid grey !important;
                background-color: #fff !important;
                color: #000 !important;
                border-bottom: 0px !important;
                box-shadow: 0px 0px 0px grey !important;
                border-radius: 5px 5px 0px 0px !important;
                outline: 0 !important;
            }
            .inactiveTabPanelBtn{
                border: 0px !important;
                background-color: transparent !important;
                outline: 0 !important;
            }
            .tabPanelDiv{
                border-top: 1px solid grey !important;
                margin-top: -17px !important;
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
                                              <th>Order Id</th>
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
                                <li class="" id="PathologyTabs">
                                    <a href="#ocrPanela" class="icon" id="labOcr">
                                        <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                        <span>OCR</span>
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

                          <section id="ocrPanel" class="mx-3">

                            <!-- Button trigger modal -->
                            


                            <div class="col-md-12 mb-2 text-left">
                                <!-- <button type="button" class="btn btn-primary" onclick="openModalForOcr();"> -->
                                <button type="button" id="openFileSelecter" class="btn btn-primary">
                                  Upload Report Image/pdf
                                </button>
                                <span id="ocfFileName"></span>
                                <input type="file" class="form-control" name="ocrFile" id="ocrFile" accept="image/png, image/gif, image/jpeg, application/pdf" required data-msg="Select file" style="display: none;">
                                <input type="hidden" name="serviceData" id="serviceData" value="0">
                                <input type="hidden" name="imgData" id="imgData" value="0">
                                <input type="hidden" name="libraryData" id="libraryData" value="0">
                                <!-- <button class="btn btn-primary" type="button" id="saveLabExcelDataEntry" onclick="saveChildLabExcelData();">Save</button> -->

                            </div>
                            <div class="col-md-3">
                                <!-- <select name="selectServiceOrder1" id="selectServiceOrder1" class="form-control" style="font-size: 10px!important;" onchange="getChildTestData(this.value)"></select> -->
                            </div>
                            <div class="col-md-12">
                                <!-- <div class="tabs tabs-style-underline">
                                    <nav>
                                        <ul id="lab_entry_top_navInner">
                                            <li class="" id="filePreviewTab">
                                                <a href="#filePreviewPanel" class="icon" id="ocrFilePreview">
                                                    <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                    <span>File Preview</span>
                                                </a>
                                            </li>

                                            <li class="" id="handsonTableTab">
                                                <a href="#handsonTablePanel" class="icon" id="handsonTablePreview">
                                                    <i class="fas fa-notes-medical  mr-1 fa_class"></i>
                                                    <span>Handson Table Preview</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="content-wrap content-wrap2" id="lab_master_panel">
                                        <section id="filePreviewPanel" class="content-current">
                                           <div id="">
                                               file preview
                                           </div>
                                       </section>
                                        <section id="handsonTablePanel" class="content-current">
                                           <div id="">
                                               handson
                                           </div>
                                       </section>
                                   </div>
                                </div> -->
                                <div id="ocrDataContainer">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link activeTabPanelBtn" id="a" onclick="changeTab(this.id);" type="button">File Preview</button>
                                  </li>
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link inactiveTabPanelBtn" id="b" type="button"  onclick="changeTab(this.id);" role="tab">Handson Presentation</button>
                                  </li>
                                  <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="c" type="button"  onclick="changeTab(this.id);" role="tab" >Contact</button>
                                  </li> -->
                                </ul>
                                <hr class="tabPanelDiv">
                                <div class="tab-content" id="pills-tabContent">
                                  <div class="tab-pane fade active show" id="panelA">
                                    <canvas class="canvas" id="imgCanvas" style="width:100%;"></canvas>
                                  </div>
                                  <div class="tab-pane fade" id="panelB">
                                    <div id="tabentryhandsondata">
                                        <?php //var_dump($this->session->userdata()); ?>
                                        <div id="newDiv1"></div>
                                    </div>
                                  </div>
                                  <!-- <div class="tab-pane fade" id="panelC">C</div> -->
                                </div>
                               
                                </div>
                                
                                
                               <!--  <form id="form_ocrupload" name="form_ocrupload" method="post" enctype="multipart/form-data">
                                    <input type="file" class="form-control" name="ocrFile" id="ocrFile" required accept="image/png, image/gif, image/jpeg, application/pdf" />
                                    <input type="hidden" name="serviceData" id="serviceData" value="0">
                                    <input type="hidden" name="imgData" id="imgData" value="0">
                                    <input type="hidden" name="libraryData" id="libraryData" value="0">
                                    <input type="submit" id="btn_ocr_submit" class="btn btn-primary btn-sm" name="submit">
                                </form> -->
                                <!-- <div id="divImgCanvas" style="width:100%;height: auto;"> -->
                                    <!-- <canvas class="canvas" id="imgCanvas" style="width:100%;"></canvas> -->
                                <!-- </div> -->
                            </div>
                            

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

<!-- <form id="form_ocrupload" name="form_ocrupload" method="post" enctype="multipart/form-data">
                                    <input type="file" class="form-control" name="ocrFile" id="ocrFile" required accept="image/png, image/gif, image/jpeg, application/pdf" />
                                    <input type="hidden" name="serviceData" id="serviceData" value="0">
                                    <input type="hidden" name="imgData" id="imgData" value="0">
                                    <input type="hidden" name="libraryData" id="libraryData" value="0">
                                    <input type="submit" id="btn_ocr_submit" class="btn btn-primary btn-sm" name="submit">
                                </form> -->

<div class="modal fade" tabindex="-1" role="dialog" id="uploadOcrModal"
aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <form id="form_ocrupload" name="form_ocrupload" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5>Upload Image for OCR</h5>
            </div>
            <div class="modal-body py-0">
                <div class="card my-0 shadow-none">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="service_file">File Upload</label>
                                
                                <!-- <input type="file" class="form-control" name="ocrFile" id="ocrFile" accept="image/png, image/gif, image/jpeg, application/pdf" required data-msg="Select file"> -->

                                <!-- <input type="file" class="form-control" name="service_file[]" multiple="" -->
                                <!-- data-valid="required" data-msg="Select file" id="service_Path_file"> -->
                                <span id="radiology_diles_error" style="color: red"></span>
                                 <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
                                  <h3 id="status"></h3>
                                  <p id="loaded_n_total"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <input type="hidden" name="serviceData" id="serviceData" value="0">
                <input type="hidden" name="imgData" id="imgData" value="0">
                <input type="hidden" name="libraryData" id="libraryData" value="0"> -->
                <input type="submit" id="btn_ocr_submit" class="btn btn-primary btn-sm" name="submit" value="Upload">
                <!-- <button class="btn btn-primary" type="submit" id="btn_ocr_submit" class="btn btn-primary btn-sm" name="submit">Save</button> -->
            </div>
        </form>
    </div>
</div>
</div>
<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
<script>
        document.getElementById('openFileSelecter').onclick = function() {
            document.getElementById('ocrFile').click();

        };
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
        $("#labOcr").on('click',function (event) {
            // document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

            showPanel1('labOcr',143);

        })

         $("#ocrFilePreview").on('click',function (event) {
            // document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

            showPanel1('ocrFilePreview',143);

        })
          $("#handsonTablePreview").on('click',function (event) {
            // document.getElementById("hiddenDivName").value= 'tabmasterTestPanel0';

            showPanel1('handsonTablePreview',143);

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
    function changeTab(id){
    //     // alert(id);

        

        if (id == 'a') {
            $("#pills-tab").children().removeClass('show active');
            $("#pills-tab").children('button').removeClass('active');
            $("#pills-tabContent").children('div').removeClass('show active');
            $("#a").addClass('activeTabPanelBtn').removeClass('inactiveTabPanelBtn');
            $("#b").removeClass('activeTabPanelBtn').addClass('inactiveTabPanelBtn');
            $("#panelA").addClass("active").addClass('show');            
        }
        if (id == 'b') {
            $("#pills-tab").children().removeClass('show active');
            $("#pills-tab").children('button').removeClass('active');
            $("#pills-tabContent").children('div').removeClass('show active');
            $("#a").removeClass('activeTabPanelBtn').addClass('inactiveTabPanelBtn');
            $("#b").addClass('activeTabPanelBtn').removeClass('inactiveTabPanelBtn');
            $("#panelB").addClass("active").addClass('show');            
        }
    //     else if (id == 'nav-profile-tab') {
    //         $("#nav-tabContent").children().removeClass('show active');
    //         $("#nav-profile-tab").addClass('show')
    //         $("#nav-profile-tab").addClass("active");
    //     }
    //     else if (id == 'nav-contact-tab') {
    //         $("#nav-tabContent").children().removeClass('show active');
    //         $("#nav-contact-tab").addClass('show')
    //         $("#nav-contact-tab").addClass("active");
    //     }
    }

    function openModalForOcr(){
        $("#uploadOcrModal").modal("show");
    }

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
  $("#lab_entry_top_navInner li").removeClass("tab-current")
  
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
    if(id=='labOcr')
    {
    $("#lab_entry_top_nav li:nth-child(4)").addClass("tab-current")
    $("#ocrPanel").addClass("content-current");
    getServiceOrderList(sectionId);
    loadEditableTable();
    // loadEditableTable(sectionId);
    // getCollectionTable('PATHOLOGY', 'pathologyTable');
    }
    if(id=='ocrFilePreview')
    {
        $("#lab_entry_top_navInner li:nth-child(1)").addClass("tab-current")
        $("#filePreviewPanel").addClass("content-current");
        
        // loadEditableTable(sectionId);
        // getCollectionTable('PATHOLOGY', 'pathologyTable');
    }
    if(id=='handsonTablePreview')
    {
        $("#lab_entry_top_navInner li:nth-child(2)").addClass("tab-current")
        $("#handsonTablePanel").addClass("content-current");
        
        // loadEditableTable(sectionId);
        // getCollectionTable('PATHOLOGY', 'pathologyTable');
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
            data: 3
        },
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

            $('td:eq(4)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="cancelOrder('${aData[3]}','${aData[5]}')" data-pres_id="${aData[3]}"> <i class="fas fa-times"></i> </button><button class="btn btn-primary btn-action mr-1"  data-toggle="modal" data-target="#lab-service-modal" data-id="${aData[3]}"onclick="open_edit_modal('${aData[4]}','${aData[5]}')" type="button" > <i class="fa fa-eye"></i> </button>`);


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
        Form_data.set('service_order_id',$("#selectServiceOrder").val());
        // Form_data.set('service_order_id1',$("#selectServiceOrder1").val());
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
        // $("#selectServiceOrder1").html("");
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
                // $("#selectServiceOrder1").append(response.data);
                // $("#selectServiceOrder1").select2({});
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
<script type="text/javascript" src="<?php echo base_url();?>assets/library.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/patient_library.js"></script>
<script type="text/javascript" src="https://www.googleapis.com/auth/cloud-vision"></script>
<!-- <script src="http://localhost:8080/index.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>
  https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API
<script type="text/javascript">

    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    // pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js';
    // console.log(pdfjsLib);
    var randsID = '_Zer';
    var fileUploaded = [];
    var socket = null;
    var clientId = null;
    var chnnelID = null;
    var conn = null;
    $(function () {
        // chnnelID = $('#surefaceID').val();
        // clientId = $('#userID').val();
        // webSocket();
        // loadCanvasBox(chnnelID);
        // $('#container').on('mousewheel', scroll);

        $("#ocrFile").on("change", fileReader);
        // const canvas = $('#imgCanvas');
        // console.log(canvas); // [canvas.canvas]

        // const ctx = canvas[0].getContext('2d');

        // console.log(ctx); // CanvasRenderingContext2D
    });

     function uploadImageToOCR(){
            // $("#form_ocrupload").submit(function(e){
            // e.preventDefault();
            var arrLabParentTests = '';
            var file = $("#ocrFile")[0].files[0].name;
            console.log('ocr file name ',$("#ocrFile")[0].files[0]);
            $("#ocfFileName").text(file);
            // let getServiceData = getChildTestData(157);
            // if (getServiceData) {
                var fd = new FormData();
                fd.append( "ocrFile", $("#ocrFile")[0].files[0]);
                fd.append("imgData",$("#imgData").val());
                fd.append( "libraryData", $("#libraryData").val());
                fd.append( "service_data", $("#serviceData").val());

                var service_id = $("#selectServiceOrder1").val();
                $.ajax({

                    url : 'http://localhost:8080/test',
                    type : 'POST',
                    data : fd,
                    processData:false,
                    contentType:false,
                    crossDomain: true,

                    success: function(result) {
                        var arrLabParentTests = [];
                        getLabParentTestsFunction().then(res=>{
                            console.log('arrLabMaster = ',arrLabParentTests);
                            var rows = [
                            ['', '', '', '', '', '', '', '', '', '', '',''],
                            ];
                            if (result) {
                            // var columns=result.columns;
                            if (result.length > 0) {
                                rows = result;
                            }
                            // var types=result.types;
                            // columnRows=rows;
                            // columnsHeader=columns;

                        } else {

                            rows = [
                            ['', '', '', '', '', '', '', '', '', '', '',''],
                            ];
                        }



                        var types = [
                        {
                            type: 'text',validator: emptyValidator,
                        },

                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type: 'dropdown',validator: emptyValidator,source:res,
                        },
                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type: 'text',validator: emptyValidator,
                        },
                        {
                            type:'text',  
                        },
                        {
                            type: 'text',
                        },
                        {
                            type: 'text'
                        },
                        {
                            type: 'text'
                        },
                        ];
                        var hideArra = [8,9,10,11];
                        var columns = ['name', 'value', 'Unit', 'ref','Test','Master Test Name','Service Code','Child Id','branch_id','Master Test Id','name in library','serviceDataid'];


                        hideColumn = {
                            // specify columns hidden by default
                            columns: hideArra,
                            copyPasteEnabled: false,
                        };
                        createHandonTable1(columns, rows, types, 'newDiv1', hideColumn,1);

                    });
                }
                    });
            // }else{

            // }
            // var formData = new FormData($("#form_ocrupload")[0]);
            
        // });
        }
    $(document).ready(function() {
        $("#ocrDataContainer").hide();
        // var  getLabParentTestsFunction();
       
    });

   // function getExt(){
   //  // alert("test");
   //      // $("#ocrFile").
   //      var files = event.target.files
   //      var filename = files[0].name
   //      var extension = files[0].type
   //      // alert(extension);
   //      // console.log(files);
   //      if (extension == 'application/pdf') {
   //          pdf_image(files);
   //          // console.log(files);
   //      }
   //  }
   // document.querySelector('#ocrFile').addEventListener('change', function() {

   //      var reader = new FileReader();
   //      var files = event.target.files
   //      reader.onload = function() {

   //          var arrayBuffer = this.result,
   //          array = new Uint8Array(arrayBuffer),
   //          binaryString = String.fromCharCode.apply(null, array);

   //          // console.log(binaryString);
   //          if (files[0].type == 'application/pdf') {
   //              pdf_image(binaryString);
   //          }
   //      }
   //      reader.readAsArrayBuffer(this.files[0]);

   //  }, false);
   
   function fileReader(e) {
    // alert("test");
    // $("#btn_ocr_submit").attr("disabled","disabled");
    $("#btn_ocr_submit").prop("disabled", true);
    getChildTestData();
    getLibraryData();
    let randID = randsID;
    var file = e.target.files[0];
    var fileReader = new FileReader();
    if (file.type === "application/pdf") {
        fileReader.onload = function () {
            var pdfData = new Uint8Array(this.result);
            var loadingTask = pdfjsLib.getDocument({data: pdfData});
            loadingTask.promise.then(function (pdf) {
                var pageNumber = 1;
                pdf.getPage(pageNumber).then(function (page) {
                    var canvas = $(`#imgCanvas`)[0];
                    console.log(randID);
                    canvas.width = 900;
                    canvas.height = 650;
                    var context = canvas.getContext('2d');
                    var scale = .8;///(canvas.height / canvas.width) / 8;
                    console.log(scale);
                    var viewport = page.getViewport({scale: scale});


                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);
                    renderTask.promise.then(function () {
                        var dataURL = canvas.toDataURL();
                        console.log("pdf_Data = ",dataURL);
                        $("#ocrDataContainer").show();
                        $("#imgData").val(dataURL);
                        uploadImageToOCR();
                        // uploadOnPDFServer(file, dataURL).then((result) => {
                        //     if (result.status === 200) {

                        //         // fileUploaded.push({id: randID, file: file, url: result.body, type: 1});
                        //         // insertOperation({s: 4, u_id: randsID, c_id: chnnelID, create_by: clientId,
                        //         //     w: 258, h: 345, file: result.body});
                        //         // sendSocketMsg(JSON.stringify(
                        //         //         {op: "operation", channel: chnnelID,
                        //         //             userID: clientId,
                        //         //             action: "create", type: "pdf", id: randID, file:
                        //         //                     {fileUrl: result.body, thumbUrl: result.thumb}}));
                        //     } else {
                        //         alert(result.body);
                        //     }
                        // }).catch(error => {
                        //     console.log(error);
                        // });
                    });
                });
            }, function (reason) {
                console.error(reason);
            });
        };
        fileReader.readAsArrayBuffer(file);
    } else {
        var file = document.getElementById('ocrFile').files[0];
        var reader = new FileReader();
        reader.addEventListener('load', function() {
            var res = reader.result; 
            // console.log('inser block = ',res);
            $("#ocrDataContainer").show();
            $("#imgData").val(res);
            uploadImageToOCR();
        });

        reader.readAsDataURL(file);

        // console.log('outer block = ',dataUrl);
        // if(result instanceof Error) {
        //     console.log('Error: ', result.message);
        //     return;
        // }
        // var canvas = document.getElementById(randID + '_canvas');
        // var ctx = canvas.getContext('2d');
        // fileReader.onload = function (ex) {
        //     var img = new Image();
        //     img.onload = function () {
        //         drawImageScaled(img, ctx);
        //         uploadOnFileServer(file).then((result) => {
        //             if (result.status === 200) {
        //                 fileUploaded.push({id: randID, file: file, url: result.body, type: 2});
        //                 insertOperation({s: 5, u_id: randsID, c_id: chnnelID, create_by: clientId,
        //                     w: img.width, h: img.height, file: result.body});
        //             } else {
        //                 alert(result.body);
        //             }
        //         }).catch(error => {
        //             console.log(error);
        //         });
        //     };
        //     img.src = ex.target.result;
        // };

        // fileReader.readAsDataURL(e.target.files[0]);
    }
}

   function pdf_image(files) {
    // var file_url  = 'https://rmt.ecovisrkca.com/downloadFile?f=dXBsb2FkL2NvbnRyYWN0LzE2MzYzNjY5NTZfZmlsZS1zYW1wbGVfMTUwa0IucGRm';
    var pdfjsLib;
    // var file_url = 'https://rmt.ecovisrkca.com/downloadFile?f=' + filename + '&t=1';
    var file_url = files;
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.js';
    var pdfDoc = null,
        pageNum = 1,
        pageRendering = true,
        scale = 1.0,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');

    return pdfjsLib.getDocument(file_url).promise.then(function (pdfDoc_) {
        pdfDoc = pdfDoc_;
        pageRendering = true;
        return pdfDoc.getPage(1).then(function (page) {
            var viewport = page.getViewport({
                scale: scale
            });
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);
            return renderTask.promise.then(function () {
                pngUrl = canvas.toDataURL();
                return pngUrl;
                console.log(pngUrl);
            });
        });
    }).catch(error => console.log(error));
}


   function getLabParentTestsFunction(){
    return new Promise(function(resolve,reject){
        var p_id = localStorage.getItem("patient_id");
        $.ajax({
            url : '<?php echo base_url(); ?>getLabParentTests',
            dataType : 'json',
            type : 'POST',
            data : {p_id:p_id},
            success: function(resp) {
             resolve(resp);
         }
     });
    });
}

// function getLibraryData(){
//     return new Promise(function(resolve,reject){
//         $.ajax({
//             url : '<?php echo base_url(); ?>getLibraryData',
//             dataType : 'json',
//             type : 'POST',
//             success: function(resp) {
//              resolve(resp);
//              $("#libraryData").val(resp);
//          }
//      });
//     });
// }

function getLibraryData(){
        // ajax request here
        $.ajax({
            url : '<?php echo base_url(); ?>getLibraryData',
            dataType : 'json',
            type : 'POST',
            success: function(resp) {
                if (resp.status ==200) {
                    let serviceData = JSON.stringify(resp.data);
                    console.log('library Data = ',JSON.parse(resp.data));
                    $("#libraryData").val(serviceData);
                        // return true;
                    }else{
                        // return false;
                        // ocrDataFunction(resp.data,resp.imagepath);
                        console.log(resp.status);
                    }
                }
            });
        // console.log(service_id+' - '+imagepath);
    }

emptyValidator = function(value, callback) {
  if (!value && value!==0) {
        // console.log('false');
        callback(false);
    } else {
        // console.log('true');
        callback(true);
    }
};
     // function getServiceData()
     function getChildTestData(service_id){

        $("#serviceData").val("0");
        // ajax request here
        var p_id = localStorage.getItem("patient_id");
        // alert(p_id);
        $.ajax({
            url : '<?php echo base_url(); ?>getLabChildTests',
            dataType : 'json',
            type : 'POST',
            data : {service_id:service_id,p_id:p_id},
            success: function(resp) {
                if (resp.status ==200) {
                    let serviceData = JSON.stringify(resp.data);
                    console.log("service data",resp.data);
                    $("#serviceData").val(serviceData);
                    $("#btn_ocr_submit").prop("disabled", false);
                        // return true;
                    }else{
                        // return false;
                        // ocrDataFunction(resp.data,resp.imagepath);
                        console.log(resp.status);
                    }
                }
            });
        // console.log(service_id+' - '+imagepath);
    }


    function saveChildLabExcelData() {
        $.LoadingOverlay("show");
        // $("#newErrorDiv").html('');
        var array=hotDiv.getData();
        var Form_data = new FormData();
        Form_data.set('patient_id',localStorage.getItem("patient_id"));
        Form_data.set('value',JSON.stringify(array));
        Form_data.set('patient_name',localStorage.getItem("patient_name"));
        Form_data.set('patient_adhar',localStorage.getItem("patient_adharnumber"));
        // Form_data.set('service_order_id1',$("#selectServiceOrder1").val());
        if (confirm("Are You Sure You want to upload?")) {
            $.ajax({
                url: "<?= base_url();?>" + "updateDynamicLabDataChildLabTest",
                type: "POST",
                dataType: "json",
                data: Form_data,
                contentType: false,
                processData: false,
                success: function (result) {
                    $.LoadingOverlay("hide");
                    if (result.status == 200) {
                        app.successToast(result.body);
                        // window.location.reload();
                        // loadEditableTable(143,$("#selectServiceOrder1").val());

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
<script>

    // function loadEditableTable(id, branch_id) {
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>assets/json/multiDres.json',
    //         type: "POST",
    //         dataType: "json",
    //         data: {id: id, branch_id: branch_id},
    //         success: function (result) {
    //             console.log(result);
    //             var rows = [
    //                 ['', '', '', '', '',],
    //             ];
    //             if (result) {
    //                 // var columns=result.columns;
    //                 if (result.length > 0) {
    //                     rows = result;
    //                 }
    //                 // var types=result.types;
    //                 // columnRows=rows;
    //                 // columnsHeader=columns;

    //             } else {

    //                 rows = [
    //                     ['', '', '', '', ''],
    //                 ];
    //             }
    //             var types = [
    //                 {type: 'text',},

    //                 {type: 'text'},
    //                 {
    //                     type: 'text'
    //                 },
    //                 {
    //                     type: 'text'
    //                 },,
    //                 {
    //                     type: 'text'
    //                 },
    //             ];
    //             var hideArra = [];
    //             var columns = ['name in library','name', 'value', 'Unit', 'ref'];


    //             hideColumn = {
    //                 // specify columns hidden by default
    //                 columns: hideArra,
    //                 copyPasteEnabled: false,
    //             };
    //             createHandonTable(columns, rows, types, 'newDiv', hideColumn);

    //         },
    //         error: function (error) {
    //             console.log(error);
    //             // $.LoadingOverlay("hide");
    //         }
    //     });

    // }


    // let hotDiv;

    function createHandonTable(columnsHeader, columnRows, columnTypes, divId, hideColumn = true) {
        console.log(columnsHeader);
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
            stretchH: 'all',
            colWidths: '100%',
            width: '100%',
            height: 520,
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

     function createHandonTable1(columnsHeader, columnRows, columnTypes, divId, hideColumn = true,dropType) {
        console.log(columnsHeader);
        var element = document.getElementById(divId);
        hotDiv != null ? hotDiv.destroy() : '';
        hotDiv = new Handsontable(element, {
            data: columnRows,
            colHeaders: columnsHeader,
            formulas: true,
            manualColumnResize: true,
            manualRowResize: true,

            // ],
            afterChange: function(changes, src){
                if(changes){
                    var row = changes[0][0];
                    var value = changes[0][3];
                    var prop = changes[0][1];
                    if(prop==5)
                    {
                        let arrServiceCode = value.split('#');
                        this.setDataAtCell(row,6,arrServiceCode[0]);
                        this.render();
                    }
                }
            },
            columns: columnTypes,
            stretchH: 'all',
            colWidths: '100%',
            width: '100%',
            height: 520,
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

// --------------- data save in database

    // var data = hotDiv.getData();
    // let formData = new FormData();
    // formData.set('arrData', JSON.stringify(data));


</script>