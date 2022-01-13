<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');

?>
<style>
    /*.vital_td2 ,.op1,.vent1,.ot1,.il1,.rass,.nursecare,.diabetic,.intake,.op2,.dc1,.drugInfusion1,.bolus1,.ivFluids1{
        display:none;

    }*/
    .eyeopen, .bvrtgl, .bmrtgl, .pupilreaction, .motorpwr{
        display:none;

    }
    .sensory_p,.moisture_m,.activity_a,.mobility_m,.nutrition_n,.friction_share_s
    {
        display:none;
    }
    .age_a,.fall_history_h,.elimination_f,.medications_f,.equipment_f,.mobility_f,.cogmtion_f
    {
        display: none;
    }
    input[type="number"]{
        width: 100% !important;
        /*height: 13px;*/
        border: none;
        border-bottom: 1px solid lightgray;
        font-size: 12px;
    }
    input[type="text"]{
        width: 100% !important;
        /*height: 13px;*/
        border: none;
        border-bottom: 1px solid lightgray;
        font-size: 12px;
    }
    input[type="radio"]{

        /*height: 13px;*/
        border: none;
        border-bottom: 1px solid lightgray;
        font-size: 9px !important;
    }
    input[type="textarea"]{
        width: 60% !important;
        /*height: 13px;*/
        border: none;
        border-bottom: 1px solid lightgray;
        font-size: 12px;
    }
    select{
        width: 100% !important;
        /*height: 13px;*/
        border: none;
        border-bottom: 1px solid lightgray;
        font-size: 12px;
    }
    td label{
        font-size: 11px;
    }
    .sign_p
    {
        padding-left: 55px;
    }
    .bg_color
    {
        background-color:#8916353b;
        cursor: pointer;
        color: black;
    }
    td
    {
        font-size: 10px;
        color: black;
        /*line-height: 0px;*/
    }
    td label
    {
        font-size: 10px;
        color: black;
    }
    td i{
        border: 1px solid #bbb8b9;
        padding: 2px;
        box-shadow: 1px 1px 3px 0px #888888;
    }
    .mainsign_p
    {
        /*padding-left: 20px;*/
    }

    .tableFixHead
    {
        /*width: 100%;*/
        height: 450px;
        overflow: auto;
    }
    .table_header
    {
        position: sticky;
    }
    .tableFixHead  td {
        /*padding: 3px 7px 3px 0px;*/
        /*width: 200px;*/
    }


    .nowtr, td{
    //	width:10px;
    }
    .nowtr, input[type="text"]{
    //	width: 50% !important;
    }
    #new_table td{
        width:150px;
    }
    .date_css
    {
        padding-right: 10px;
        color: black;
        /*border-bottom: 1px solid black;*/
    }
    .tab-content > .tab-pane
    {
        line-height: 1.5;
    }


    .list_select_o
    {
        display: inline;
        font-size: 11px;
    }
    .list_select_v
    {
        float: right;
        display: block;
        padding-left: 8px;
        font-size: 11px;
        opacity: .7;
    }
    .td_input
    {
        background: #e4c9d0;
    }
    .modal_header
    {
        background: #891635;
        color: white;
    }
    .modal_close
    {
        color: white;
    }
    @media (min-width: 768px) {
        .modal-xl {
            width: 90%;
            max-width:1200px;
        }
    }


</style>
<div class="main-content main-content1">
    <section class="section">




        <div class="">
            <div class="section-header card-primary" style="border-top: 2px solid #891635">
                <h1>Operation Details</h1>
            </div>
            <div class="section-body" >
                <div class="card">

                    <div class="card-header-action">

                    </div>
                    <div class="card-body">
                        <form id="form_operation" name="form_operation">
                        <div class="col-md-12">
                            <label>Plan Date</label>
                            <input type="date" class="form-control" id="opr_plan_date" name="opr_plan_date">
                        </div>
                        <div class="col-md-12">
                            <label>comment</label>
                           <textarea class="form-control" id="opr_comment" name="opr_comment"></textarea>
                        </div>
                        <div class="col-md-12"><br>
                            <label>Upload File</label>
                            <input type="file" id="userfile" name="userfile[]">
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="button" style="float: right" onclick="SaveOperationDetails()">Save</button>
                        </div>
                        </form>
                        <div id="OperationDataView"></div>
                    </div>

                </div>
            </div>
        </div>

    </section>

</div>]
<?php $this->load->view('_partials/footer'); ?>
<!-- <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script> -->
<script>
//GetOperationDetails
$( document ).ready(function() {
    GetOperationDetails();
});
    function SaveOperationDetails() {
        var patient_id=localStorage.getItem("patient_id");
        let form = document.getElementById("form_operation");
        let formData = new FormData(form);
        formData.append("patient_id", patient_id);

        $.ajax({
            url: baseURL + "Operation_details/SaveOperation",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (success) {
                // success = JSON.parse(success);
                if (success.status == 200) {
                    app.successToast(success.body);
                    GetOperationDetails();

                } else {
                    app.errorToast(success.body);
                }
            },
            error: function (error) {
                console.log(error);
                app.errorToast("something went to wrong");
            }
        });


    }
    function GetOperationDetails() {
        var patient_id=localStorage.getItem("patient_id");
        let formData = new FormData();
        formData.append("patient_id", patient_id);
        $.ajax({
            url: baseURL + "Operation_details/GetOpertaionDeatilsTable",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (success) {
                // success = JSON.parse(success);
                if (success.status == 200) {
                    $("#OperationDataView").html(success.data);
                } else {
                    $("#OperationDataView").html(success.data);
                }
            },
            error: function (error) {
                console.log(error);
                app.errorToast("something went to wrong");
            }
        });
    }

    function gotoOTDeatils(id,branch_id){
        localStorage.setItem('OperationID',id);
        var patient_id=localStorage.getItem("patient_id");
        let object ={"patient_id":patient_id,"branch_id":branch_id,"operation_id":id};
        let string = btoa(JSON.stringify(object));
        window.location.href = baseURL + "patient_navigation/21/1/"+string;
    }

</script>
