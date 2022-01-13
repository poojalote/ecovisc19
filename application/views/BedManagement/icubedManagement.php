<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$permission_array = $this->session->user_permission;

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
		width: 500%;
		z-index: 999;
	/ / border: 1 px solid grey;
	}

	.tooltip-wrap:hover .tooltip-content {
		display: block;
	}

	.main-content {
		width: 100% !important;
	}

	.th_height th {
		height: 36px !important;
		color: white !important;
	}
</style>
<!-- Main Content -->
<div class="main-content" style="width: 100%;padding-left: 0px;">
	<section class="section">
		<div class="section-body">
			<div class="section-header card-primary" style="border-top: 2px solid #891635">
				<h1 style="color: #891635">ICU Management</h1>
				<button class="btn btn-link pt-3" onclick="open_modal_bed()"><i class="fa fa-bed" style="font-size:16px"></i></button>
				<div class="card-header-action d-flex" style="margin-left: auto; ">
					<div class="align-items-center">
						<div class="form-group mx-2 my-0">
							<select id="searchGender" class="form-control" onchange="get_roomdetailstable()"
									style="border-radius: 20px;">
								<option value="0">All</option>
								<option value="1">Male</option>
								<option value="2">Female</option>
							</select>
						</div>
					</div>
					<div class="align-items-center">
						<div class="form-group mx-2 my-0">
							<select id="searchAge" class="form-control" onchange="get_roomdetailstable()"
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
							<select id="searchPatient" class="form-control" onchange="get_roomdetailstable()"
									style="border-radius: 20px;">
								<option selected disabled>Select Patient</option>

							</select>
						</div>
					</div>
				</div>


			</div>
		</div>
		<div class="card">

			<div class="card-body">

				<div id="show_room_details" style="overflow-x: auto;">
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
<?php $this->load->view('_partials/footer'); ?>

<script>
	 const videoStreaming ='https://vs.docango.com/';
	let cameraCapture =null; 
	$(document).ready(function () {
		//get_all_bed();
		get_roomdetailstable();
		get_icuPatientList();
		$('#largeVideo').on('show.bs.modal', function (e) {
			let camera = parseInt($(e.relatedTarget).data('camera'));
			largeVideoPanel(-1);
			largeVideoPanel(camera);
		})
		$('#largeVideo').on('hide.bs.modal', function (e) {
			disconnectVideo();
		})
		

		//let socket = io(videoStreaming ,{ transports : ['websocket'] });

		// socket.on('capture', function (filenames) {
		// 	if(filenames){
		// 		// filenames.forEach(f=>{
		// 		// 	let img= document.getElementById(f.code);
		// 		// 	img.src = f.image;
		// 		// })
		// 		cameraCapture = filenames;
		// 		startCamera();
		// 	}
		// })
	});

</script>
