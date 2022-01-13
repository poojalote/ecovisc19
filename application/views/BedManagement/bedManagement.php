<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$permission_array = $this->session->user_permission;
if(is_null($permission_array)){
	$permission_array=array();
}
?>
<style>
	.dataTables_filter {
		display: flex !important;
		justify-content: flex-end !important;
	}

	.dataTables_paginate {
		display: flex !important;
		justify-content: flex-end !important;
	}

	.accordion .accordion-header[aria-expanded="true"] {
		box-shadow: 0 2px 6px #891635 !important;
		background-color: #891635 !important;
	}

	.cardclass .text-left {
		width: 150px !important;
		height: 30px;
	}

	.cardclass .text-center {
		width: 150px !important;
		height: 100px;
	}

	.tooltip-wrap {
		position: relative;
	}

	.tooltip-wrap .tooltip-content {
		display: none;
		position: absolute;
		bottom: 0%;
		left: 0%;
		right: 0%;
		margin-left: 15%;
		background-color: #fff;
		padding: .2em;
		box-shadow: 2px 2px 2px 2px #bcc1c6;
		width: 1000%;
		z-index: 999;
		border-radius: 8px;
		border: 1px solid #80808021;
	/ / border: 1 px solid grey;
	}

	.tooltip-wrap:hover .tooltip-content {
		display: block;
	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-body">
			<div class="section-header card-primary">
				<h1 style="color: #891635">Risk Dashboard</h1>

				<div class="card-header-action" style="margin-left: auto;margin-right: 10px;">

					<div class="row align-items-center">
<!--						<div class="form-group mx-2 my-0">-->
<!--							<select class="form-control" id='bloodtest'-->
<!--									onchange="get_roomdetailstable()" style="border-radius: 20px;">-->
<!--								<option selected disabled>Select Blood Test Deviation</option>-->
<!--								<option value='2'>More than 1 deviation</option>-->
<!--								<option value='1'>1 deviation</option>-->
<!--								<option value='3'>No deviation</option>-->
<!---->
<!--							</select>-->
<!--						</div>-->
<!--						<div class="form-group mx-2 my-0">-->
<!--							<select class="form-control" id='vitalsign'-->
<!--									onchange="get_roomdetailstable()" style="border-radius: 20px;">-->
<!--								<option selected disabled>Select Vital Sign Deviation</option>-->
<!--								<option value='2'>More than 1 deviation</option>-->
<!--								<option value='1'>1 deviation</option>-->
<!--								<option value='3'>No deviation</option>-->
<!---->
<!--							</select>-->
<!--						</div>-->
<!--						<div class="form-group mx-2 my-0">-->
<!--							<select class="form-control" id='zoneDetails'-->
<!--									onchange="get_roomdetailstable(this.value)" style="border-radius: 20px;">-->
<!--								<option selected disabled>Select Zone</option>-->
<!---->
<!--							</select>-->
<!--						</div>-->
						<?php $edit = 1;
						if ($edit == 1 && in_array("bed_management", $permission_array)) { ?>
							<button class="btn btn-icon btn-primary" data-toggle="modal"
									data-target="#fire-modal-bedManagement" id="addBedRooms"
									style="border-radius: 20px;"><i
										class="fas fa-plus"></i></button>
						<?php } ?>
					</div>

				</div>
			</div>
			<div class="card">

				<div class="card-body">
					<div class="table-responsive">
						<div class="dataTables_wrapper no-footer">
							<table class="table table-striped dataTable no-footer" id="patientTable"
								   role="grid">
								<thead>
								<!-- <tr>
									<td>Aadhar Number</td>
									<td>Name</td>
									<td>Gender</td>
									<td>Contact</td>
									<td>Birth Date</td>
									<td>Location</td>
									<td>Blood Group</td>
									<td>Action</td>
								</tr> -->
								</thead>
							</table>
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active show" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false" onclick="get_occupiedroomdetailstable()">Risk Analysis</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true" onclick="get_roomdetailstable()">All Beds</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                                    <div id="show_room_details">
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                                    <div class="row">
                                        <div class="btn btn-group">
                                            <button type="button" class="btn btn-block"><i class="fas fa-bed text-danger mx-2" style="font-size: x-large;color:#ff0000!important;"></i>High</button>
                                        </div>
                                        <div class="btn btn-group">
                                            <button type="button" class="btn btn-block"><i class="fas fa-bed text-danger mx-2" style="font-size: x-large;color:#ca2dd4!important;"></i>Medium</button>
                                        </div>
                                        <div class="btn btn-group">
                                            <button type="button" class="btn btn-block"><i class="fas fa-bed text-danger mx-2" style="font-size: x-large;color:#239f38!important;"></i>Low</button>
                                        </div>
                                    </div>
                                    <div id="show_occupiedroom_details">
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
<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-bedManagement"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Room Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>


			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<ul class="nav nav-pills" role="tablist">
							<li class="nav-item">
								<a href="#add_room" class="nav-link active" id="permission-tab" data-toggle="tab"
								   role="tab">Add Room</a></li>
							<li class="nav-item"><a href="#Add_bed" class="nav-link " id="permission-tab"
													data-toggle="tab" role="tab">Add Bed</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active " id="add_room" role="tabpanel">
								<form id="add_room_form" name="add_room_form" method="post"
									  data-form-valid="add_room_form"
									  onsubmit="return false">
									<div class="form-group my-0 py-0">
										<label>Room Category</label>
										<select class="form-control" id="room_cat" name="room_cat">
											<option value="1" selected>General</option>
											<option value="2">ICU</option>
										</select>

										<span class="required" id="room_cat_error" style="color:red"></span>
									</div>
									<div class="form-group my-0 py-0">
										<label>Room No</label>
										<input type="text" class="form-control" placeholder="Enter  Room No."
											   onkeypress="remove_error('room_no')" id="room_no" name="room_no">
										<span class="required" id="room_no_error" style="color:red"></span>
									</div>
									<div class="form-group my-0 py-0" id="fix_deduct_amount_yes" style="display: block">

										<label> Ward/Section No</label>
										<input type="text" class="form-control" placeholder="Enter  Ward No."
											   onkeypress="remove_error('ward_no')" id="ward_no" name="ward_no">
										<span class="required" id="ward_no_error" style="color:red"></span>

									</div>
									<br>
									<button type="submit" class="btn btn-primary" id="add_hospital_room">Save</button>
								</form>
							</div>
							<div class="tab-pane fade  " id="Add_bed" role="tabpanel">
								<form id="add_bed_form" name="add_bed_form" method="post" onsubmit="return false">
									<input type="hidden" name="room_id" id="room_id">
									<input type="hidden" name="category" id="category" value='1'>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Select Zone</label>
												<select class="form-control" id="zoneDetails1" name="zoneDetails1"
														onchange="add_bed_btn()">
													<option value="" disabled selected>Select Zone</option>

												</select>
											</div>
											<div class="form-group">
												<?php
												$edit = 1;
												if ($edit == 1) {
												$cnt = 1;
												for ($i = 0; $i < 5; $i++) {
													?>
													<div class="row">
														<div class="col-md-12 d-flex">
															<div class="loading" id="loader"
																 style="display:none;"></div>


															<div class="col-md-6">
																<div class="input-group mb-2">
																	<label class="mr-2">Bed<?php echo $cnt; ?></label>
																	<input type="text" id="bed_a<?php echo $cnt; ?>"
																		   name="bed_a<?php echo $cnt; ?>"
																		   onkeyup="remove_error('bed_a<?php echo $cnt; ?>')"
																		   class="form-control"
																		   placeholder="Enter Bed<?php echo $cnt; ?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="input-group mb-2">
																	<label class="mr-2">Camera<?php echo $cnt; ?></label>
																	<input type="text" id="camera_a<?php echo $cnt; ?>"
																		   name="camera_a<?php echo $cnt; ?>"
																		   onkeyup="remove_error('bed_a<?php echo $cnt; ?>')"
																		   class="form-control"
																		   placeholder="Enter Camera<?php echo $cnt; ?>">
																</div>
															</div>


															<span class="required"
																  id="bed_a<?php echo $cnt; ?>_error"></span>

														</div>
													</div>

													<?php
													$cnt++;
												}
												?>

											</div>
											<button type="submit" id="add_bedroom_btn" name="add_bedroom_btn"
													class="btn btn-primary mb-2">Add
											</button>
											<button type="button" class="btn btn-default mb-2" data-dismiss="modal">
												Close
											</button>
											<?php } ?>
										</div>


									</div>


								</form>
								<div id="bed_data" name="bed_data"></div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">

					<button class="btn btn-secondary" type="reset">Reset</button>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- <div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
		
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<div class="modal-body">
				<div class="form-body">
					<form id="add_bed_form" name="add_bed_form" method="post" onsubmit="return false">
						<input type="hidden" name="room_id" id="room_id">
						<input type="hidden" name="category" id="category" value='1'>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php
$edit = 1;
if ($edit == 1) {
	$cnt = 1;
	for ($i = 0; $i < 5; $i++) {
		?>
										<div class="row">
										<div class="col-md-12 d-flex">
											<div class="loading" id="loader" style="display:none;"></div>

											<div class="input-group mb-2">
												<label class="mr-2">Bed<?php echo $cnt; ?></label>
												<input type="text" id="bed_a<?php echo $cnt; ?>"
													   name="bed_a<?php echo $cnt; ?>"
													   onkeyup="remove_error('bed_a<?php echo $cnt; ?>')"
													   class="form-control" placeholder="Enter Bed<?php echo $cnt; ?>">
											</div>
											<span class="required" id="bed_a<?php echo $cnt; ?>_error"></span>
											
										</div>
										</div>
										
										<?php
		$cnt++;
	}
	?>

								</div>
								<button type="submit" id="add_bedroom_btn" name="add_bedroom_btn"
										class="btn btn-primary mb-2">Add
								</button>
								<button type="button" class="btn btn-default mb-2" data-dismiss="modal">Close</button>
								<?php } ?>
							</div>

						</div>


					</form>
					<div id="bed_data" name="bed_data"></div>
				</div>
			</div>
		</div>
	</div>
</div> -->

<div class="modal fade bs-example-modal-sm" tabindex="-1" id="mmodla" role="dialog" aria-labelledby="mySmallModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-sm">

		<div class="modal-content">
			<div align="center"><br>
				<h4 style="color:#d580e4">Vital Sign</h4>
				<hr>
			</div>
			<div align="center" id="datashow"></div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-sm" tabindex="-1" id="mmodla1" role="dialog" aria-labelledby="mySmallModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-sm">

		<div class="modal-content">
			<div align="center"><br>
				<h4 style="color:#007bff">Blood Test</h4>
				<hr>
			</div>
			<div align="center" id="datashow1"></div>
		</div>
	</div>
</div>

<?php $this->load->view('_partials/footer'); ?>

<script>
	$(document).ready(function () {

        get_occupiedroomdetailstable();
		$("#test2").hover(function () {

		});
	});

	function click_vital() {
		var data = $("#test1").attr("data-d1");

		$('#mmodla').modal({
			show: true
		});
		$("#datashow").html("");
		$("#datashow").html(data);
	}

	function click_frequent() {
		var data = $("#test2").attr("data-d1");

		$('#mmodla1').modal({
			show: true
		});
		$("#datashow1").html("");
		$("#datashow1").html(data);
	}

</script>
