<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>

    table.dataTable tbody td {
        word-break: break-word;
        vertical-align: top;
    }

    div.wrapDiv {
        white-space: nowrap;
        width: 100px;

        overflow: hidden;
        text-overflow: ellipsis;
    }

    div.wrapDiv:hover {
        overflow: visible;
        white-space: normal;

    }
</style>
<!-- Main Content -->
<div class="main-content main-content1">
    <section class="section">
        <!-- <div class="section-header" style="border-top: 2px solid #891635">
            <h1> Sample Collection</h1>
        </div> -->
        <div class="section-header card-primary">
            <h1 style="color: #891635">Pathology Collection</h1>

        </div>
        <div class="section-body">
            <div class="">
                <div class="">

                    <div class="card">
                        <div class="card-header d-flex">

                            <div class="card-header-action">

                               <!--  <div class="form-group mx-2 my-0">
                                    <select class="form-control" id='psampleAllPatient'
                                            onchange="getSampleCollectionTable('PATHOLOGY','pathologySampleTable',this.value)"
                                            style="width: 100%">
                                    </select>
                                </div> -->

                            </div>
                            <!-- <div class="col-md-2 form-group" style="margin-left: auto;">
                                <button name="pathologyExcelNotConfirm" id="pathologyExcelNotConfirm"
                                        class="btn btn-primary" onclick="getNotConfirmReport(0,'PATHOLOGY')"><i
                                        class="fa fa-download"></i> Download Report
                                </button>
                            </div> -->
                        </div>

                        <div class="card-body">


                            <table class="table table-bordered table-stripped" id="pathologySampleTable">
                                <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Service Code</th>
                                    <th style="width: 165px;">Service Name</th>
                                    <th>Confirm Service Given</th>
                                    <th>Delete Service</th>
                                    <th>Date and Time</th>
                                    <th>Action</th>
                                </tr>
                                <!-- <tr>
                                    <th>Bed No.</th>
                                    <th>Patient Name</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr> -->
                                </thead>
                                <tbody>

                                </tbody>

                            </table>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
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

<!-- company modal  -->
<?php $this->load->view('Billing/billing'); ?>


<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
    $(document).ready(function () {

        getCollectionTable('PATHOLOGY', 'pathologySampleTable');
        // get_zone();
        // getAllPatients('PATHOLOGY');
    });

function getCollectionTable(category, tableID, patient_id = null) {
    // var p_id = $('#p_id').val();
    //console.log(""+tableID+"");
    // let formData = new FormData();
    // formData.set("category", category);
    // // if(category=="RADIOLOGY"){
    // let zone = $("#psampleAllPatient").val();
    // if (zone !== null) {
    //     formData.set("zone_id", zone);
    // }
  

    app.dataTable('pathologySampleTable', {
        url: baseURL + "getLabCollectionTable",
       // data:formData
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
                data: 7
            },
            {
                data: 3
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
    app.request(baseURL + "getserviceOrderBillingInfo2", formData).then(response => {
        if (response.status === 200) {
            app.successToast(response.body);
            $(".modal").modal('hide');
            getCollectionTable($("#Pcategory").val(), $("#Ptablename").val(), $("#psampleAllPatient").val());

        } else {
            app.errorToast(response.body);
        }
    }).catch(error => console.log(error));
}
    // var checkList = document.getElementById('list1');
    // checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
    //  if (checkList.classList.contains('visible'))
    //      checkList.classList.remove('visible');
    //  else
    //      checkList.classList.add('visible');
    // }

</script>
