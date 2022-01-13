<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
 
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Patient Details</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Medicine Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                <div id="p_details">


                        </div>
                        <br/>
                    <div class="col-sm-4">

                                <button type="button"  class="btn btn-primary btn-sm" onclick="show_div('att_medicine')">Schedule Medicine<i class="fa fa-plus mx-1"></i></button>

                                <button type="button"  class="btn btn-primary btn-sm" onclick="show_div('add_medicine')">Add Medicine<i class="fa fa-plus mx-1"></i></button>
                        </div>

                        <form id="add_medi_form" name="add_medi_form" onsubmit="return false">
                            <div id="add_medicine" style="display:none">
                                <label>Medicine Name</label>
                                <div class="row">

                                    <div class="col-sm-3 ">
                                        <input type="text" list="myMenu" class="form-control"  id="medi_name" onkeyup="myFunction_1()" name="medi_name" Placeholder="Enter Medicine Name">
                                        <datalist  id="myMenu">
                                        </datalist >
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit"  class="btn btn-primary">Add</button>
                                    </div>

                                    <div class="col-md-7" >

                                        <div    style="height:150px;overflow-y: auto; overflow-x: hidden;">
                                            <table class="table" id="myTable">

                                                <tbody id="medi_table_view" >

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </form>

                        <form id="att_medi_form" name="att_medi_form" onsubmit="return false" >
                            <div id="att_medicine" style="display:none" >
                                <div class="row" >
                                    <input type="hidden" id="patient_list" name="patient_list" >
    <!-- <select class="form-control valid" id="patient_list"  name="patient_list" onchange="get_patien_medicine_data()" aria-invalid="false">
        <option value="" selected="" disabled="">Select Patient Name</option></select> -->

                                    <div class="col-md-3 mb-2"><strong>Medicine Name</strong>
                                        <select class="form-control valid" id="medicine_list"  name="medicine_list" aria-invalid="false">
                                            <option value="" selected="" disabled="">Select Medicine</option></select>
                                    </div>
                                    <div class="col-md-3 mb-2"><strong>Start Date</strong>
                                        <input type="date" class="form-control" name="Start_Date_new" id="Start_Date_new" placeholder="Enter Start Date" value="" aria-required="true">
                                    </div>
                                    <div class="col-md-3 mb-2" id="end_date_div">
                                        <strong>End Date</strong>
                                        <input type="date" class="form-control" name="End_Date_new" id="End_Date_new" placeholder="Enter End Date" value="" aria-required="true">

                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <strong>Is End Date Recurring</strong><br>
                                        <input type="checkbox" id="chk" name="chk"onchange="hide_date()">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <strong>Per Day Schedule</strong>
                                        <select data-value="2" class="form-control" name="Per_Day_Schedule_new" id="Per_Day_Schedule_new" aria-required="true">
                                            <option disabled="" selected="">Select   Per Day Schedule  </option>
                                            <option value="1">1</option><option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div  class="col-md-3 mb-2">
                                        <strong>Remark</strong>
                                        <input type="text" class="form-control" name="Remark_new" id="Remark_new" placeholder="Enter Remark" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button type="submit"  class="btn btn-primary">Add</button>
                                </div>
                                <br>
                                <div class="col-md-12">
                                    <table class="table" id="table_medi_pati" style="display: none">
                                        <thead>
                                            <tr>

                                                <th>Date & Time</th>
                                                <th>Medicine Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Per Day Schedule</th>
                                                <th>Remark</th>
                                                <th>Action</th>
                                            <tr>
                                        </thead>
                                        <tbody  id="table_patient_medi">
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                            </div>
                        </form>
                        <br>
                        

                        <div id="schedule_table">
                            <div id="currentDoesTableBox"></div>

                        </div>
                        <hr>
                           <div class="row">
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="button"  class="btn btn-primary btn-sm" onclick="show_div('history')">History<i class="fa fa-plus mx-2"></i></button>
                            </div> </div><br>
                        <div id="history" style="display:none">
                            <div class="row currentDateDoes">
                                <div class="col-md-12">
                                    <table style="width:100%;font-size: 12px "
                                           class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
                                           cellspacing="0" >
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Date</td>
                                                <td>1st</td>
                                                <td>2nd</td>
                                                <td>3rd</td>
                                                <td>4th</td>
                                                <td>5th</td>
                                            </tr>
                                        </thead>
                                        <tbody id="doesHistoryTable1">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
 <!--edit form-->
        <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <form id="editForm_new" class="form-horizontal" method="POST" novalidate="novalidate"  onsubmit="return false">
                            <input type="hidden" id="e_medicine_id" name="e_medicine_id">
                            <input type="hidden" id="e_p_id" name="e_p_id">

                            <div class="col-md-6 mb-2"><strong>Start Date</strong>
                                <input type="date" class="form-control" name="e_Start_Date_new" id="e_Start_Date_new" placeholder="Enter Start Date" value="" aria-required="true" >
                            </div>
                            <div class="col-md-6 mb-2" id="e_end_date_div">
                                <strong>End Date</strong>
                                <input type="date" class="form-control" name="e_End_Date_new" id="e_End_Date_new" placeholder="Enter End Date" value="" aria-required="true">

                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Is End Date Recurring</strong><br>
                                <input type="checkbox" id="e_chk" name="e_chk"onchange="hide_date()">
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>Per Day Schedule</strong>
                                <select data-value="2" class="form-control" name="e_Per_Day_Schedule_new" id="e_Per_Day_Schedule_new" aria-required="true">
                                    <option disabled="" selected="">Select   Per Day Schedule  </option>
                                    <option value="1">1</option><option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" >update</button>
                                <button type="button" class="btn btn-danger" id="delete_medi_patie" name="delete_medi_patie">Delete</button>

                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById("patient_nameSidebar").innerText=localStorage.getItem("patient_name");
        var patient_id=localStorage.getItem("patient_id");
        $("#patient_list").val(patient_id);

                                    });  
 
</script>