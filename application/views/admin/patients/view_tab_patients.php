<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$branchpermission_array = $this->session->Branch_permission;
$user_permission_array = $this->session->user_permission;
if (is_null($branchpermission_array)) {
	$branchpermission_array = array();
}
if (is_null($user_permission_array)) {
	$user_permission_array = array();
}
?>
<style>
	.card .card_border101 .shadow-none,
	.card .card_border102 .shadow-none,
	.card .card_border103 .shadow-none,
	.card .card_border104 .shadow-none,
	.card .card_border105 .shadow-none,
	{
		padding: 0 !important;
	}

	.card-body.card_body101, .card-body.card_body102, .card-body.card_body103, .card-body.card_body104, .card-body.card_body105 {
		padding: 0 !important;
	}

</style>
<style type="text/css">

	.tabs {
		position: relative;
		overflow: hidden;
		margin: 0 auto;
		width: 100%;
		font-weight: 300;
		font-size: 1.25em;
	}

	/* Nav */
	.tabs nav {
		text-align: center;
	}

	.tabs nav ul {
		position: relative;
		display: -ms-flexbox;
		display: -webkit-flex;
		display: -moz-flex;
		display: -ms-flex;
		display: flex;
		margin: 0 auto;
		padding: 0;
		max-width: 1200px;
		list-style: none;
		-ms-box-orient: horizontal;
		-ms-box-pack: center;
		-webkit-flex-flow: row wrap;
		-moz-flex-flow: row wrap;
		-ms-flex-flow: row wrap;
		flex-flow: row wrap;
		-webkit-justify-content: center;
		-moz-justify-content: center;
		-ms-justify-content: center;
		justify-content: center;
	}

	.tabs nav ul li {
		position: relative;
		z-index: 1;
		display: block;
		margin: 0;
		text-align: center;
		-webkit-flex: 1;
		-moz-flex: 1;
		-ms-flex: 1;
		flex: 1;
	}

	.tabs nav a {
		position: relative;
		display: block;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		line-height: 2.5;
	}

	.tabs nav a span {
		vertical-align: middle;
		font-size: 1em;
	}

	.tabs nav li.tab-current a {
		color: #74777b;
	}

	.tabs nav a:focus {
		outline: none;
	}

	/* Icons */
	.icon::before {
		z-index: 10;
		display: inline-block;
		margin: 0 0.4em 0 0;
		vertical-align: middle;
		text-transform: none;
		font-weight: normal;
		font-variant: normal;
		font-size: 1.3em;
		font-family: 'stroke7pixeden';
		line-height: 1;
		speak: none;
		-webkit-backface-visibility: hidden;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
	}

	/* Content */
	.content-wrap {
		position: relative;
	}

	.content-wrap section {
		display: none;
		/*margin: 0 auto;*/
		padding: 0px !important;
		max-width: 100%;
		text-align: center;
	}

	.content-wrap section.content-current {
		display: block;
	}

	.content-wrap section p {
		margin: 0;
		padding: 0.75em 0;
		color: rgba(40, 44, 42, 0.05);
		font-weight: 900;
		font-size: 4em;
		line-height: 1;
	}

	/* Fallback */
	.no-js .content-wrap section {
		display: block;
		padding-bottom: 2em;
		border-bottom: 1px solid rgba(255, 255, 255, 0.6);
	}

	.no-flexbox nav ul {
		display: block;
	}

	.no-flexbox nav ul li {
		min-width: 15%;
		display: inline-block;
	}

	/*****************************/
	/* Underline */
	/*****************************/

	.tabs-style-underline nav {
		background: #fff;
	}

	.tabs-style-underline nav a {
		padding: 0.25em 0 0.5em !important;
		border-left: 1px solid #e7ecea;
		-webkit-transition: color 0.2s;
		transition: color 0.2s;
	}

	.tabs-style-underline nav li:last-child a {
		border-right: 1px solid #e7ecea;
	}

	.tabs-style-underline nav li a::after {
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 6px;
		background: #891635;
		content: '';
		-webkit-transition: -webkit-transform 0.3s;
		transition: transform 0.3s;
		-webkit-transform: translate3d(0, 150%, 0);
		transform: translate3d(0, 150%, 0);
	}

	.tabs-style-underline nav li.tab-current a::after {
		-webkit-transform: translate3d(0, 0, 0);
		transform: translate3d(0, 0, 0);
	}

	.tabs-style-underline nav a span {
		font-weight: 700;
	}

	.tabs-style-underline nav a:hover {
		text-decoration: none !important;
		color: #74777b !important;
	}

	.fa_class {
		font-size: 22px !important;
	}

	@media screen and (max-width: 58em) {
		.tabs nav a.icon span {
			display: none;
		}

		.tabs nav a:before {
			margin-right: 0;
		}
	}

	#dynamicDataTableFilter_0 {
		margin-top: 6px !important;
	}

	@media (min-width: 992px) {
		.modal-lg {
			max-width: 1050px;
		}
	}
</style>
<!-- Main Content start -->
<div class="main-content">
	<section class="section">

		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">

						<div class="card-body px-1">
							<section>
								<input type="hidden" id="department_id" name="department_id"
									   value="20">
								<input type="hidden" id="section_id" name="section_id"
									   value="101">
								<input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
									   value="eyJicmFuY2hfaWQiOiIyIn0=">
								<div class="tabs tabs-style-underline">
									<nav>

										<ul>
											<?php
											if (array_search("IPD_TAB", $user_permission_array) && array_search("IPD_TAB", $branchpermission_array)) {
												?>
												<li class="tab-current"><a href="#ipd" class="icon"
																		   onclick="get_forms(101,0,'ipd'),dynamicFilter('#datatable_button_46',0,``,3,1,101)"><i
																class="fa fa-hospital mr-1 fa_class"></i>
														<span> IPD</span></a>
												</li>
											<?php } ?>
											<?php
											if (array_search("OPD_TAB", $user_permission_array) && array_search("OPD_TAB", $branchpermission_array)) {
												?>
												<li class=""><a href="#opd" class="icon"
																onclick="opdOperation()"
													><i
																class="fa fa-stethoscope mr-1 fa_class"></i>
														<span> OPD</span></a></li>
											<?php } ?>
											<?php
											if (array_search("ICU_TAB", $user_permission_array) && array_search("ICU_TAB", $branchpermission_array)) {
												?>
												<li class=""><a href="#icu" class="icon" onclick="get_dataICU()"><i
																class="fa fa-procedures mr-1 fa_class"></i>
														<span> ICU</span></a></li>
											<?php } ?>
											<?php
											if (array_search("EM_TAB", $user_permission_array) && array_search("EM_TAB", $branchpermission_array)) {
												?>
												<li class=""><a href="#emergency" class="icon"
																onclick="get_forms(104,0,'emergency')"><i
																class="fa fa-heartbeat mr-1 fa_class"></i>
														<span> Emergency</span></a></li>
											<?php } ?>
											<?php
											if (array_search("OP_TAB", $user_permission_array) && array_search("OP_TAB", $branchpermission_array)) {
												?>
												<li class=""><a href="#operation" class="icon"
																onclick="get_forms(105,0,'operation')"><i
																class="fa fa-diagnoses mr-1 fa_class"></i> <span> Operation Theatre</span></a>
												</li>
											<?php } ?>
										</ul>
									</nav>
									<div class="content-wrap">
										<section id="ipd" class="content-current">

										</section>
										<section id="opd"></section>
										<section id="icu">
											<div class="section-header card-primary" style="border-top: 0px!important;">
												<h1 style="color: #891635">ICU Management</h1>
												<button class="btn btn-link pt-3" onclick="open_modal_bed()"><i
															class="fa fa-bed" style="font-size:16px"></i></button>
												<div class="card-header-action d-flex" style="margin-left: auto; ">
													<div class="align-items-center">
														<div class="form-group mx-2 my-0">
															<select id="searchGender" class="form-control"
																	onchange="get_roomdetailstable()"
																	style="border-radius: 20px;">
																<option value="0">All</option>
																<option value="1">Male</option>
																<option value="2">Female</option>
															</select>
														</div>
													</div>
													<div class="align-items-center">
														<div class="form-group mx-2 my-0">
															<select id="searchAge" class="form-control"
																	onchange="get_roomdetailstable()"
																	style="border-radius: 20px;">
																<option selected disabled>Select Age</option>
																<option value="0-20">0-20</option>
																<option value="21-40">21-40</option>
																<option value="41-60">41-60</option>
																<option value="age>60">age >60</option>
																<option value="0">All</option>
															</select>
														</div>
													</div>
													<div class="align-items-center">
														<div class="form-group mx-2 my-0">
															<select id="searchPatient" class="form-control"
																	onchange="get_roomdetailstable()"
																	style="border-radius: 20px;">
																<option selected disabled>Select Patient</option>

															</select>
														</div>
													</div>
												</div>


											</div>

											<div class="">

												<div id="show_room_details" style="overflow-x: auto;">
												</div>
											</div>
										</section>
										<section id="emergency">

										</section>
										<section id="operation">

										</section>
									</div><!-- /content -->
								</div><!-- /tabs -->
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>

<button type="button" class="btn btn-info btn-lg d-none" id="icu_bed_medicine_button" data-toggle="modal"
		data-target="#icu_bed_medicine_modal">Open Modal
</button>
<div class="modal fade" id="icu_bed_medicine_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4><span id="headerIcuPanel"></span></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-md-12" id="icu_bed_medicine_data">

				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="medication_vitals" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<section>
					<div class="tabs tabs-style-underline">
						<nav>
							<ul>
								<li id="vt" class="tab-current"><a onclick="vitaltab()">Vitals</a></li>
								<li id="nt"><a onclick="notestab()">Progress Notes</a></li>
								<li id="mt"><a onclick="medictab()">Medicines</a></li>
							</ul>
						</nav>
					</div>
					<div class="content-wrap">
						<section id="vitalsTab" class="content-current">
							<div id="vitals">

							</div>
						</section>
						<section id="schedule_table">
							<div id="currentDoesTableBox"></div>
						</section>
						<section id="notesTab">
							<div id="notes">

							</div>
						</section>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="IcubedModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5>ICU Bed Management</h5>
			</div>
			<div class="modal-body">
				<div class="row justify-content-sm-around" id="bed_data">

				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="largeVideo" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center align-items-center">
					<canvas id="large_video_panel" width="500" height="400">
						No Supported
					</canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<!--UPDATE MODAL MEDICINE-->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closeUpdate" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="updateMedicineForm" class="form-horizontal" method="POST"
					  data-form-valid="updateMedicineForm">
					<input type="hidden" id="u_medicine_id" name="u_medicine_id">
					<input type="hidden" id="u_p_id" name="u_p_id">
					<div class="form-group">
						<strong>Remark</strong>
						<textarea name="u_remark" id="u_remark" class="form-control" maxlength="255"></textarea>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Route</label>
							<select data-value="2" class="form-control" name="u_route" id="u_route">
								<option disabled="" selected="">Select Route
								</option>
								<option value="PO/NG">PO/ NG</option>
								<option value="IV">IV</option>
								<option value="IM">IM</option>
								<option value="SC">SC</option>
								<option value="PR">PR</option>
								<option value="LA">LA</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Dose</label>
							<select data-value="2" class="form-control" name="u_quantity" id="u_quantity">
								<option disabled="" selected="">Select Dose
								</option>
								<option value="0.25">0.25</option>
								<option value="0.5">0.5</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2">
							<label>Flow Rate</label>
							<input type="checkbox" name="u_flow_rate_check" id="flow_rate_check"
								   onchange="$('#update_flow_rate').toggleClass('d-none')"/>
						</div>
						<div class="form-group col-md-10 d-none" id="update_flow_rate">
							<label>Flow Rate</label>
							<input type="text" name="u_flow_rate_update" id="flow_rate_update" class="form-control"/>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">save</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>


<!--delete form-->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" id="closeedit1" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
				<form id="editForm_new" class="form-horizontal" method="POST" data-form-valid="deleteMedicine"
					  onsubmit="return false">
					<input type="hidden" id="e_medicine_id" name="id">
					<input type="hidden" id="e_p_id" name="e_p_id">

					<div class="form-group">
						<strong>Delete Reason</strong>
						<textarea name="deleteReason" id="reason" class="form-control" maxlength="255"
								  data-valid="required" data-msg="Enter reason"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">save</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<button type="button" class="btn btn-primary d-none" id="commentMedicineModalBtn" data-toggle="modal"
		data-target="#commentMedicineModal">Open Modal
</button>
<!--Medicine Comment modal -->
<div class="modal fade" id="commentMedicineModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Comment</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="medicineCommentForm" method="post">
					<input type="hidden" name="m_patient_id" id="m_patient_id">
					<input type="hidden" name="c_medicine_id" id="c_medicine_id">
					<input type="hidden" name="m_iteration_id" id="m_iteration_id">
					<input type="hidden" name="m_dose_date" id="m_dose_date">

					<div class="form-row">
						<textarea class="form-control" type="text" name="medicine_comment"
								  id="medicine_comment"></textarea>
					</div>
					<div class="align-items-baseline form-row justify-content-end mt-2">
						<button class="btn btn-primary mr-1" type="button" onclick="addMecidineCommentData()">
							Save
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Main Content end -->
<?php $this->load->view('_partials/footer'); ?>
<script src="<?= base_url('assets/js/module/medicine/medicine.js'); ?>"></script>

<script type="text/javascript">
	const videoStreaming = 'https://vs.ecovisrkca.com/';
	let cameraCapture = null;
	var base_url = "<?php echo base_url(); ?>";
	$(document).ready(function () {
		get_forms(101, 0, 'ipd').then(r => {
			dynamicFilter('#datatable_button_89', 0, ``, 3, 1, 102);
		});
		[].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
			new CBPFWTabs(el);
		});
	});

	function getMedicVitals(section_id, patient_id) {
		$('#vitals').html('');
		$('#currentDoesTableBox').html('');
		$('#notes').html('');
		$('#medication_vitals').modal('show');
		getVitals(patient_id);
		getNotes(patient_id)
		getDoesDetails(patient_id);
		$('#notesTab').removeClass('content-current');
		$('#schedule_table').removeClass('content-current');
		$('#vitalsTab').addClass('content-current');
		$('#nt').removeClass('tab-current');
		$('#vt').addClass('tab-current');
		$('#mt').removeClass('tab-current');
	}

	function notestab() {
		$('#notesTab').addClass('content-current');
		$('#schedule_table').removeClass('content-current');
		$('#vitalsTab').removeClass('content-current');
		$('#nt').addClass('tab-current');
		$('#vt').removeClass('tab-current');
		$('#mt').removeClass('tab-current');
	}

	function vitaltab() {
		$('#notesTab').removeClass('content-current');
		$('#schedule_table').removeClass('content-current');
		$('#vitalsTab').addClass('content-current');
		$('#nt').removeClass('tab-current');
		$('#vt').addClass('tab-current');
		$('#mt').removeClass('tab-current');
	}

	function medictab() {
		$('#notesTab').removeClass('content-current');
		$('#schedule_table').addClass('content-current');
		$('#vitalsTab').removeClass('content-current');
		$('#nt').removeClass('tab-current');
		$('#vt').removeClass('tab-current');
		$('#mt').addClass('tab-current');
	}

	function getVitals(patient_id) {
		var section_id = 2;
		var table_name = "his_com_1_dep_2";
		$.ajax({
			type: "POST",
			url: baseURL + "get_patient_history_data",
			dataType: "json",
			data: {table_name: table_name, patient_id: patient_id, section_id: section_id},
			success: function (result) {
				$('#vitals').empty();
				$('#vitals').append(result.table);

				$("#example").on("mousedown", "td .fa.fa-minus-square", function (e) {
					table.row($(this).closest("tr")).remove().draw();
				});
				$("#example").on('mousedown.edit', "i.fa.fa-pencil-square", function (e) {

					$(this).removeClass().addClass("fa fa-envelope-o");
					var $row = $(this).closest("tr").off("mousedown");
					var $tds = $row.find("td").not(':first').not(':last');

					$.each($tds, function (i, el) {
						var txt = $(this).text();
						$(this).html("").append("<input type='text' value=\"" + txt + "\">");
					});
				});

				$('#history_table_' + section_id).on('mousedown', "#selectbasic", function (e) {
					e.stopPropagation();
				});

				$('#history_table_' + section_id).DataTable(
						{
							order: false,
							//"columnDefs": [{"targets": result.transColumnIndex, "type": "date-eu"}],*/
						}
				);
			}, error: function (error) {
				$('#vitals').html('No Data Found');
				app.errorToast('Something went wrong please try again');
			}
		});
	}

	function getNotes(patient_id) {
		var section_id = 25;
		var table_name = "his_com_1_dep_8";
		$.ajax({
			type: "POST",
			url: baseURL + "get_patient_history_data",
			dataType: "json",
			data: {table_name: table_name, patient_id: patient_id, section_id: section_id},
			success: function (result) {
				$('#notes').empty();
				$('#notes').append(result.table);

				$("#example").on("mousedown", "td .fa.fa-minus-square", function (e) {
					table.row($(this).closest("tr")).remove().draw();
				});
				$("#example").on('mousedown.edit', "i.fa.fa-pencil-square", function (e) {

					$(this).removeClass().addClass("fa fa-envelope-o");
					var $row = $(this).closest("tr").off("mousedown");
					var $tds = $row.find("td").not(':first').not(':last');

					$.each($tds, function (i, el) {
						var txt = $(this).text();
						$(this).html("").append("<input type='text' value=\"" + txt + "\">");
					});
				});

				$('#history_table_' + section_id).on('mousedown', "#selectbasic", function (e) {
					e.stopPropagation();
				});

				$('#history_table_' + section_id).DataTable(
						{
							order: false,
						}
				);
			}, error: function (error) {
				$('#notes').html('No Data Found');
				app.errorToast('Something went wrong please try again');
			}
		});
	}


	function getDoesDetails(p_id) {
		new Promise((resolve, reject) => {
			$.ajax({
				type: "post",
				url: base_url + 'getICUDoesDetails',
				data: {p_id: p_id},
				dataType: "json",
				success: function (result) {
					resolve(result);
				},
				error: function (error) {
					reject(error);
				}
			});
		}).then((result) => {
			if (result.status === 200) {
				$('#currentDoesTableBox').html("");
				$('#currentDoesTableBox').append(result.currentArray);
			} else {
				$('#currentDoesTableBox').html("");
				$('#currentDoesTableBox').append(result.currentArray);
			}

		}).catch(error => {
			console.log(error);
			app.errorToast('Something went wrong');
		});

	}

	function opdOperation() {
		get_forms(102, 0, 'opd').then(r => {
			if (r == 1) {
				dynamicFilter('#datatable_button_89', 0, ``, 3, 1, 102)
			}

		})
	}

	function get_dataICU() {
		get_roomdetailstable();

		$('#largeVideo').on('show.bs.modal', function (e) {
			let camera = parseInt($(e.relatedTarget).data('camera'));
			largeVideoPanel(-1);
			largeVideoPanel(camera);
		})
		$('#largeVideo').on('hide.bs.modal', function (e) {
			disconnectVideo();
		})
	}

	$('#update_modal').on('show.bs.modal', function (e) {
		let medicine_id = $(e.relatedTarget).data('id');
		let patient_id = $(e.relatedTarget).data('pid');

		let flow_rate = parseInt(atob($(e.relatedTarget).data('flow_rate')));
		let flow_text = atob($(e.relatedTarget).data('flow_text'));
		let remark = atob($(e.relatedTarget).data('remark'));
		let route = atob($(e.relatedTarget).data('route'));
		let quantity = atob($(e.relatedTarget).data('quantity'));

		app.formValidation();
		$("#u_medicine_id").val(medicine_id);
		$("#u_p_id").val(patient_id);
		if (flow_rate === 1) {
			$("#flow_rate_check").click();
			$("#update_flow_rate").removeClass('d-none')
		}

		$("#flow_rate_update").val(flow_text);
		$("#u_remark").val(remark);
		$("#u_route").val(route);
		$("#u_quantity").val(quantity);
	});

	function updateMedicineForm(form) {
		let patient_id = $('#u_p_id').val();
		app.request(baseURL + "saveMedicineUpdate", new FormData(form)).then(res => {
			if (res.status === 200) {
				app.successToast(res.body);
				$("#updateMedicineForm").trigger('reset');
				$("#closeUpdate").click();
				getDoesDetails(patient_id);
			} else {
				app.errorToast(res.body);
			}
		}).catch(error => console.log(error));
	}

	$('#edit_modal').on('show.bs.modal', function (e) {
		let id = $(e.relatedTarget).data('id');
		let pid = $(e.relatedTarget).data('pid');
		$('#e_medicine_id').val(id);
		$('#e_p_id').val(pid);
	});
	onclick = 'deleteMedicineHome(" . $doesObject->id . ",".$p_id.");'

	function addMedicineComment(p_id, m_id, iteration, dosedate) {
		$("#commentMedicineModalBtn").click();
		$("#m_patient_id").val(p_id);
		$("#c_medicine_id").val(m_id);
		$("#m_iteration_id").val(iteration);
		$("#m_dose_date").val(dosedate);
	}

	function addMecidineCommentData() {
		var comment = $("#medicine_comment").val();
		if (comment != "") {
			// var form=$('#medicineCommentForm').serialize();
			let form = document.getElementById("medicineCommentForm");
			let formData = new FormData(form);
			app.request(baseURL + "addmedicineCommentForm", formData).then(res => {
				if (res.status === 200) {
					app.successToast(res.body);
					$("#commentMedicineModalBtn").click();
				} else {
					app.errorToast(res.body);
				}
			}).catch(error => {
				console.log(error);
			})
		} else {
			app.errorToast('Enter comment');
		}

	}
</script>
