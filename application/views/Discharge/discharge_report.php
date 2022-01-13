<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content main-content1">
    <section class="section">


        <div class="">

            <div class="">
                <div class="section-header card-primary" style="border-top: 2px solid #891635">
                    <h1>Discharge Report</h1>

                    <button class="btn btn-primary" type="button" style="margin-left: auto;" id="printButton"
                            onclick="print_div()">PRINT
                    </button>
                    <button class="btn btn-primary ml-1" type="button" style="" id="death_report_button"
                            onclick="print_DeathReport()">Death Report
                    </button>
                </div>
                <div class="section-body">
                    <div class="card p-3">
                        <input type="hidden" id="patient_id" name="patient_id">
                        <?php
                        if (!is_null($this->session->branch_logo)) {
                            $logo = $this->session->branch_logo->branch_logo;
                            $style=$this->session->branch_logo->style;
                        } else {
                            $logo = "dist/img/credit/healthstart.jpeg";
                            $style="margin-left: auto;width: 200px;height: 92px;";
                        }
                        ?>
                        <img alt="image" id="" style="<?= $style ?>"
                             src="<?= base_url($logo) ?>" class="">
                        <div class="mt-3" align="center"><h5>Discharge Report(1/3)</h5></div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6 text-left">
                                    <div class="">
                                        <label class="font-weight-bold">Name </label>
                                        <span id="p_name" class="m-1"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Patient ID</label>
                                        <span id="p_adhar" class="m-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6 text-left">
                                    <div class="">
                                        <label class="font-weight-bold">DOB </label>
                                        <span id="p_dob" class="m-1"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Age</label>
                                        <span id="p_age" class="m-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6 text-left">
                                    <div class="">
                                        <label class="font-weight-bold">Case Type </label>
                                        <span id="p_case_type" class="m-1">: Covid Treatment</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Sex</label>
                                        <span id="p_sex" class="m-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Location </label>
                                        <span id="p_location" class="m-1">: </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Case ID</label>
                                        <span id="p_caseid" class="m-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="m-2"><h5>Stay</h5></div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Admission date</label>
                                        <span id="p_admitdate" class="m-1"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Admission Time</label>
                                        <span id="p_admittime" class="m-1"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Discharge Date </label>
                                        <span id="p_discharedate" class="m-1"> </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="font-weight-bold">Discharge Time</label>
                                        <span id="p_dischargetime" class="m-1"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="m-2"><h5>Case History - Initial Assessment</h5></div>
                        <div class="row">
                            <div class="col-md-12 d-flex" id="case_history">
                            </div>
                        </div>
                        <hr>
                        <div class="m-2" align="center"><h5>Discharge Report(2/3)</h5></div>
                        <div class="m-2"><h5>Vital Signs</h5></div>
                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="col-md-6" id="vital_sign_table"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="m-2"><h5>Labratory Findings</h5></div>
                        <span class="ml-2">Attached</span>
                        <div class="m-2"><h5>Procedures</h5></div>
                        <span class="ml-2">List of Clinical Procedures recommended by Doctor from Services Section</span>
                        <hr>
                        <div class="m-2" align="center"><h5>Discharge Report(3/3)</h5></div>
                        <div class="m-2"><h5> Course during hospital stay</h5></div>
                        <span id="significant_event" class="ml-2"></span>
                        <div class="m-2"><h5>Condition at the Time of Discharge</h5></div>
                        <span id="discharge_condition" class="ml-2"></span>
                        <hr>
                        <div class="m-2" align="center"><h5>Discharge Advice</h5></div>
                        <div class="m-2"><h5>Medication</h5></div>
                        <span id="medication" class="ml-2"></span>
                        <div class="m-2"><h5>Physical Activity</h5></div>
                        <span id="physical_activity" class="ml-2"></span>
                        <div class="m-2"><h5>Followup</h5></div>
                        <span id="followup" class="ml-2"></span>
                        <div class="m-2"><h5>Urgent Care</h5></div>
                        <span id="urgentcare" class="ml-2"></span>
                        <hr>
                        <div id="transfer_div" style="display:none">
                            <div class="m-2"><h5>Transfer To</h5></div>
                            <span id="transfer_to" class="ml-2"></span>
                            <div class="m-2"><h5>Transfer Reason</h5></div>
                            <span id="transfer_reason" class="ml-2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="deathReportDiv" style="display: none;font-size: 15px;"></div>
<?php $this->load->view('_partials/footer'); ?>
<script>
    document.getElementById("patient_id").value = localStorage.getItem("patient_id");

    $(document).ready(function () {

        get_patient_data();
        getprint_DeathReport();
    });

    function get_patient_data() {
        p_id = $("#patient_id").val();
        $.ajax({
            type: "POST",
            url: '<?= base_url("DischargeManagementController/getPatientData")?>',
            dataType: "json",
            async: false,
            cache: false,
            data: {p_id},
            success: function (result) {
                //console.log(result);
                if (result.status == 200) {

                    var data = result.data;
                    //console.log(result.case_history);
                    $("#case_history").html(result.case_history);

                    $("#vital_sign_table").html(result.vital_sign);
                    $("#p_name").text(": " + data['patient_name']);
                    $("#p_adhar").text(": " + data['adhar_no']);

                    $("#p_age").text(": " + get_age(data['birth_date']));
                    $("#p_dob").text(": " + data['birth_date']);
                    if (data['gender'] == 2) {
                        var gender = 'Female';
                    } else if (data['gender'] == 1) {
                        var gender = 'Male';
                    } else {
                        var gender = 'Other';
                    }
                    $("#p_sex").text(": " + gender);
                    $("#p_caseid").text(": " + data['id']);
                    $("#p_location").text(": " + data['Location']);
                    var date = data['admission_date'];
                    $("#p_admitdate").text(": " + date.split(' ')[0]);
                    $("#p_admittime").text(": " + date.split(' ')[1]);
                    var date2 = data['discharge_date'];
                    if (date2 != null) {
                        $("#p_discharedate").text(": " + date2.split(' ')[0]);
                        $("#p_dischargetime").text(": " + date2.split(' ')[1]);
                    }
                    $("#significant_event").text(data['significant_event']);
                    $("#discharge_condition").text(data['discharge_condition']);
                    $("#medication").text(data['medication']);
                    $("#physical_activity").text(data['physical_activity']);
                    $("#followup").text(data['followup_date']);
                    $("#urgentcare").text(data['urgent_care']);
                    if (data['is_transfered'] == 1) {
                        $("#transfer_div").show();
                        $("#transfer_to").text(data['transfer_to']);
                        $("#transfer_reason").text(data['transfer_reason']);
                        if (data['event'] == 'mortality') {
                            document.getElementById('death_report_button').style.display = "block";
                        } else {

                            document.getElementById('death_report_button').style.display = "none";
                        }

                    }

                } else {

                }
            }
        });

    }

    function downlod_report() {
        p_id = $("#patient_id").val();
        window.location.href = '<?= base_url("DischargeManagementController/downlod_report?p_id=")?>' + p_id;
    }

    function print_div() {
        let divName = ".section-body";
        $('#printButton').toggleClass('d-none');
        var printContents = document.querySelector(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        $('#printButton').toggleClass('d-none');
    }

    function get_age(date) {
        if ((date) !== null && (date) !== '0000-00-00') {
            var dob = new Date(date);
            //calculate month difference from current date in time
            var month_diff = Date.now() - dob.getTime();

            //convert the calculated difference in date format
            var age_dt = new Date(month_diff);

            //extract year from date
            var year = age_dt.getUTCFullYear();

            //now calculate the age of the user
            return age = Math.abs(year - 1970);
        } else {
            return 0;
        }

    }

</script>
<script>
    function getprint_DeathReport() {
        p_id = $("#patient_id").val();
        $.ajax({
            type: "POST",
            url: '<?= base_url("DischargeManagementController/getDeathPatientData")?>',
            dataType: "json",
            async: false,
            cache: false,
            data: {p_id},
            success: function (result) {
                //console.log(result);
                if (result.status == 200) {

                    var data = result.data;
                    $("#deathReportDiv").html(data);
                } else {
                    $("#deathReportDiv").html('');
                }
            }
        });
    }

    function print_DeathReport() {
        let divName = "#deathReportDiv";

        var printContents = document.querySelector(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

    }
</script>
