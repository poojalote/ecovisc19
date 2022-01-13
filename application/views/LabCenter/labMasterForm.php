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
                                                <li class="">
                                                    <a href="#unitMasterPanel" class="icon" id="tabUnitMaster"
                                                    ><i class="fas fa-vial mr-1 fa_class"></i>
                                                        <span>Unit Master</span></a></li>
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
</script>
