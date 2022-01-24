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
<div class="main-content main-content1">
	<section class="section">


		<div class="">

			<div class="">
				<div class="section-header card-primary" style="border-top: 2px solid #891635">
					<h1>Discharge Details</h1>

					<button class="btn btn-primary" type="button" style="margin-left: auto;" id="dis_btn1" onclick="check_discharge(1)">Mark for
						Discharge
					</button>
					<button class="btn btn-primary" type="button"  style="margin-left: auto;display:none;" id="dis_btn2" 
					onclick="check_discharge(0)">Already Marked for Discharge
					</button>
					<button class="btn btn-primary ml-1" type="button"  style="display:none;" id="dis_btn3" data-toggle="modal" data-target="#fire-modal-death_dec"
							onclick="getDeathDetailForm()">Death Declaration Details
					</button>

				</div>
				<div class="section-body">
					<div class="card">
						<form id="uploadCompany" method="post" data-form-valid="saveDischarge">
							<div class="modal-body py-0">
								<div class="card my-0 shadow-none">
									<div class="card-body">
										<div class="form-group row mb-3">
											<div class="col-sm-6">
												<label class="font-weight-bold">Admission date</label>
												<input class="form-control" disabled type="text" id="admission_date">
											</div>
											<div class="col-sm-6">
												<label class="font-weight-bold">Admission Time</label>

												<input type="text" class="form-control" name="atime"
													   id="atime" disabled>
											</div>


										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-6">
												<label class="font-weight-bold">Event</label>
												<select class="form-control" id="event" name="event" onchange="getDeathDeatilsButton()">
													<option selected disabled>Select option</option>
													<option value="discharge">Discharge</option>
													<option value="mortality">Mortality</option>
													<option value="transfer">Transfer</option>
													<option value="Discharge against medical advice">Discharge against medical advice</option>
												</select>
											</div>
											<div class="col-sm-6">
												<label class="font-weight-bold">Date of
													Discharge</label>
												<input type="hidden" name="patient_id" id="patient_id">
												<input type="datetime-local" class="form-control" name="discharge_date"
													   id="discharge_date"
													   data-valid="required" data-msg="Enter discharge date" onchange="getDeathDeatilsButton()">
											</div>


										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Course during hospital stay</label>
												<input type="text" class="form-control" id="sign_event"
													   name="sign_event">
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Medication used during hospital
													stay</label>
												<br><span id="medicineDetails" style="font-size: 11px;"></span>
												<div class="d-flex">
												<textarea type="text" class="form-control" id="medication_auto"
														  name="medication_auto" placeholder="Other Comment..." ></textarea>

												</div>
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Condition at the Time of
													Discharge</label>
												<input type="text" class="form-control" id="cndn_discharge_time"
													   name="cndn_discharge_time">
											</div>
										</div>
										<div class="" align="centre"><h4>Discharge Advice</h4></div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Medication</label>
												<input type="text" class="form-control" id="medication"
													   name="medication">
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Physical Activity</label>
												<input type="text" class="form-control" id="physical_activity"
													   name="physical_activity">
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Follow Up</label>
												<input type="text" class="form-control"
													   name="patient_follow_up"
													   id="patient_follow_up">
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Urgent Care</label>
												<input type="text" class="form-control" id="urgent_care"
													   name="urgent_care">
											</div>
										</div>
										<div class="form-group row mb-3">
											<div class="col-sm-12">
												<label class="font-weight-bold">Is Transfered</label>:
												<input type="radio" id="is_tr_y" name="is_transfer" value="1"
													   onclick="is_transfer_fun(1)">
												<label>Yes</label>
												<input type="radio" id="is_tr_n" name="is_transfer" value="0"
													   onclick="is_transfer_fun(0)">
												<label>No</label>
											</div>
										</div>
										<div id="transfer_section" style="display:none">
											<div class="form-group row mb-3">
												<div class="col-sm-12">
													<label class="font-weight-bold">Transfer To</label>
													<input type="text" class="form-control" id="trasfer_to"
														   name="trasfer_to">
												</div>
											</div>
											<div class="form-group row mb-3">
												<div class="col-sm-12">
													<label class="font-weight-bold">Transfer Reason</label>
													<input type="text" class="form-control" id="trans_reason"
														   name="trans_reason">
												</div>
											</div>
										</div>
										<div class="row ml-1">
											<!--<h6>In case of observation of any of the above symptoms, please contact NSCI
												Covid Care at # 93214 58814</h6>-->
										</div>



									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary mr-1" type="submit">Submit</button>
								<button class="btn btn-secondary" type="reset">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-death_dec"
	 aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

				<div class="modal-body py-0">
					<input type="hidden" id="department_id" name="department_id"
						   value="25">
					<input type="hidden" id="section_id" name="section_id"
						   value="149">
					<input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
						   value="">
					<input type="hidden" id="hiddenDivName" name="hiddenDivName" value="deathDetails">
					<div class="card my-0 shadow-none" id="deathDetails">

					</div>
				</div>


		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>
<script>
	const base_url = "<?php echo base_url(); ?>";
	document.getElementById("patient_id").value = localStorage.getItem("patient_id");
	getDischargeDetails(localStorage.getItem("patient_id"));

	//discharge_date
	$(document).ready(function () {
//   $("#discharge_date").val(new Date().toJSON().slice(0,19));
   var dt = new Date();
   // var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
   var month = dt.getMonth()+1;
var day = dt.getDate();

var output = dt.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day+" 00:00:00";
//    var date=output+"T"+time;
// 		document.getElementById("discharge_date").min = app.getDate(output);
		check_mark_as_dischage();
		get_patient_details();
	});

	function check_mark_as_dischage() {
		var p_id = $("#patient_id").val();

		$.ajax({
			type: "POST",
			url: '<?= base_url("DischargeManagementController/checkmarkasdischarge")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id},
			success: function (result) {
				//console.log(result);
				if (result.status == 200) {
					
					$("#dis_btn1").hide();
					$("#dis_btn2").show();
					
					//$("#dis_btn").attr("onclick", "").unbind("click");


				} else {
					$("#dis_btn1").show();
					$("#dis_btn2").hide();
				}
			}
		});
	}

	function check_discharge(id) {
		var p_id = $("#patient_id").val();

		$.ajax({
			type: "POST",
			url: '<?= base_url("DischargeManagementController/markasdischarge")?>',
			dataType: "json",
			async: false,
			cache: false,
			data: {p_id,id},
			success: function (result) {
				//console.log(result);
				if (result.status == 200) {
					app.successToast(result.body);
					check_mark_as_dischage();
				} else {
					app.errorToast(result.body);
				}
			}
		});
	}

</script>
<script>
	function getDeathDeatilsButton() {
		var dis_date=$("#discharge_date").val();
		var dis_event=$("#event").val();
		if(dis_date!="" && dis_event=="mortality")
		{
			document.getElementById('dis_btn3').style.display="block";
		}
		else {
			document.getElementById('dis_btn3').style.display="none";
		}
	}
	function getDeathDetailForm() {
		let object ={"patient_id":$("#patient_id").val(),"branch_id":session_branch_id};
		let string = btoa(JSON.stringify(object));
		$("#department_id").val(25);
		$("#section_id").val(149);
		$("#queryparameter_hidden").val(string);
		$("#hiddenDivName").val('deathDetails');
		get_forms(149,0,string,25,null,'deathDetails');
	}
	

</script>
