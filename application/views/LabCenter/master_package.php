<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
    @media (max-width: 800px) {

        body.layout-2 .main-content {
            padding-top: 5px!important;
            padding-left: 5px!important;
            padding-right: 5px!important;
        }

    }
</style>

<!-- Main Content -->
<div class="main-content" >
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
                        <input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden" value="<?= $queryParam ?>">
                        <input type="hidden" id="hiddenDivName" name="hiddenDivName" value="package-panel1">
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

                        <div>
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="package-tab1" data-toggle="tab" href="#package-panel1" role="tab" aria-controls="package-panel1" aria-selected="true" onclick="loadPackageData(140,'package-panel1')">Master Package</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="package-tab1" data-toggle="tab" href="#package-panel2" role="tab" aria-controls="package-panel2" aria-selected="false" onclick="loadPackageData(141,'package-panel2')">Set Master Package</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="masterpackagetabs">
                                <div class="tab-pane fade show active" id="package-panel1" role="tabpanel" aria-labelledby="package-tab1">

                                </div>
                                <div class="tab-pane fade" id="package-panel2" role="tabpanel" aria-labelledby="package-tab2">

                                </div>

                            </div>
                        </div>
                        <div class="">

                            <div id="ShowForm">
                                <div id="form_data"></div>
                                <div id="form_data1"></div>
                                <div id="form_data_report" class="" style="display: none"></div>
                            </div>
                            <div id="ShowHistory" class="" style="display:none">
                                History Table show here
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
    var base_url="<?php echo base_url(); ?>";
    $(document).ready(function () {
        var section_id=$("#section_id").val();
        var divshowName=$("#hiddenDivName").val();
        get_forms(section_id,0,null,null,null,divshowName);
    });
    function loadPackageData(section_id,divId)
    {
        $("#section_id").val(section_id);
        get_forms(section_id,0,null,null,null,divId);
    }
</script>
