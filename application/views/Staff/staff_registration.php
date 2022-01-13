<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	$url = "https://";
else
	$url = "http://";
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];
$patientId = basename($url);
// print_r($patientId);
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$permission_array=$this->session->user_permission;
?>
<?php
$code = '<?xml version="1.0" encoding="UTF-8"?>
    <PrintLetterBarcodeData uid="218659385355" 
    name="Pooja Rajendra Lote" gender="F" yob="1997" 
    loc="Dhamani" vtc="Dhamani" po="Khalapur" dist="Raigarh" 
    subdist="Khalapur" state="Maharashtra" pc="410202" dob="31/07/1997"/>';
// $xml=simplexml_load_string($code);
// // print_r($xml);
// $uid= $xml['uid'];
// $name= $xml['name'];
// $gender= $xml['gender'];
// $year_of_birth= $xml['yob'];
// $location= $xml['loc'];
// $vtc= $xml['vtc'];
// $post= $xml['po'];
// $dist= $xml['dist'];
// $subdist= $xml['subdist'];
// $pc= $xml['pc'];
// $dob= $xml['dob'];

if (!isset($patient_id)) {
	$patient_id = 0;
}

?>
<style>
	.error {
		color: red;
	}

	#my_camera {
		border: none !important;
	}

	#my_camera video {
		border-radius: 50%;
		object-fit: cover;

	}
</style>
<section id="vidscan" style="display: none;">
	<div class="container">

		<div id="overlay" onclick="off()">
			<div class="col-md-12 col-sm-12" style="padding: 100px;"><span class="close">&times;</span>

				<video id="preview" style="width: 100%;height: 500px;"></video>
			</div>
		</div>
	</div>
</section>

<div class="main-content main-content1">
	<section class="section">


		<!--		<div class="row">-->
		<!--			<div class="col-2 col-md-2 text-center">-->
		<!--				--><?php //$this->load->view('_partials/left_sidebar'); ?>
		<!--			</div>-->
		<!--			<div class="col-10 col-md-10">-->

		<div class="section-body">
			<div class="justify-content-center">

				<div class="">
					<div class="card">
						<div class="section-header card-primary">
							<h1>Staff Registration</h1>
						</div>
						<form id="patientForm" method="post" data-validate="ture" onsubmit="return false">
							<input type="text" id="addhar_img" name="patient_adhhar_image"
								   style="display: none;">
							<div class="card-body">
								<div class="section-title">Staff Details</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Profile</label>
										<select class="form-control" name="staff_profile" id="staff_profile">
											<option selected disabled>Select Profile</option>
											
										</select>
									</div>
									<div class="form-group col-md-6">
										<label>Type</label>
										<select class="form-control" name="staff_type" id="staff_type">
											<option selected disabled>Select type</option>
											<option value="1">IPD</option>
											<option value="2">OPD</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Zone</label>
										<select class="form-control" name="staff_zone" id="staff_zone">
											<option selected disabled>Select Zone</option>
											
										</select>
									</div>
									
								</div>

								<div class="section-title">Aadhar Details</div>
								
								<div class="form-group">
									<div class="input-group mb-3">
										<input class="m-1" type="radio" id="adhardetails1" checked name="adhardetails" onclick="checkadhar(1)" value="1">
										<label >Yes</label>
										<input class="m-1" type="radio" id="adhardetails2" name="adhardetails" onclick="checkadhar(2)" value="2">
										<label >No</label>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<input type="text" id="adhhar_no" name="adhhar_no" onfocusout="search()"
											   class="form-control" placeholder="Aadhar Number"
											   aria-label="" autocomplete="off">
										<!--											<div class="input-group-append">-->
										<!--												<button class="btn btn-primary" onclick="on()" type="button">Scan Aadhar-->
										<!--													Card-->
										<!--												</button>-->
										<!--											</div>-->
									</div>
								</div>

								<div class="form-group">
									<label>Name</label>
									<input type="hidden" id="patientId" name="patientId"
										   value="<?php echo $patient_id; ?>">
									<input type="text" id="name" class="form-control" name="name" data-required
										   data-required-msg>
								</div>
								<div class="form-group">
									<label>Profile Photo</label>
									<input type="hidden" id="p_img" name="patient_image"/>


									<button class="btn btn-primary" onclick="cap_image()" type="button">Open
										Camera
									</button>
									<div id="results"></div>
									<div id="my_camera" style="display: none;"></div>
									<button class="btn btn-primary" style="display: none;"
											onclick="take_snapshot()" id="cap_btn" type="button">Capture
									</button>
								</div>
								<div class="form-group">
									<label class="d-block">Gender</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input gender" value="1" type="radio"
											   name="gender"
											   id="maleRadio">
										<label class="form-check-label" for="maleRadio">
											Male
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input gender" value="2" type="radio"
											   name="gender"
											   id="femaleRadio">
										<label class="form-check-label" for="femaleRadio">
											Female
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Birth Date</label>
										<input type="date" id="dob" class="form-control" name="birth_day">
									</div>
									<div class="form-group col-md-6">
										<label>Blood Group</label>
										<select class="form-control" name="blood_group" id="blood_group">
											<option value="">Select Blood Group</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="o+">O+</option>
											<option value="o-">O-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="Unknown-">unknown</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Contact Number</label>
										<input type="text" class="form-control"
											   name="contact" id="contact">
										<input type="text" style="display: none;" id="vtc" class="form-control"
											   name="vtc">
									</div>
								</div>
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control" id="loc" name="location"></textarea>
								</div>
								<div class="form-row">
									<div class="form-group col-md-4">
										<label>District</label>
										<input type="text" id="dist" class="form-control" name="dist">
									</div>
									<div class="form-group col-md-4">
										<label>Sub-district</label>
										<input type="text" id="subdist" class="form-control" name="sub_dist">
									</div>
									<div class="form-group col-md-4">
										<label>Pin Code</label>
										<input type="text" id="pc" class="form-control" name="postal_code">
									</div>
								</div>
								


							</div>
							<div class="card-footer text-right">
							<?php 
		if (in_array("patient_registration", $permission_array) || in_array("patient_edit",$permission_array)){ 
		?>
			<button class="btn btn-primary mr-1" type="Submit">Submit</button>
	<?php	}
		?>
							
								<button class="btn btn-secondary" type="reset">Reset</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
		<!--			</div>-->
		<!--		</div>-->
	</section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="fire-modal-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Are You Sure?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				This action can not be undone. Do you want to continue?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-shadow" id="">Yes</button>
				<button type="button" class="btn btn-secondary" id="">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/dynamsoft-javascript-barcode@7.2.2-v2/dist/dbr.js" data-productKeys="LICENSE-KEY"></script>  -->

<script type="text/javascript">


	function toggleAdmissionMode(e, id) {

		if ($(e).is(":checked")) {
			if (id == 2) {
				$('#teleconsultStartDdate').addClass('d-none');
			} else {
				$('#teleconsultStartDdate').removeClass('d-none')
			}
		}
	}

	function on() {
		document.getElementById("vidscan").style.display = "block";
		document.getElementById("overlay").style.display = "block";
		document.getElementById("preview").style.display = 'block';

		let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
		scanner.addListener('scan', function (content) {
			// var data = $.parseXML(content);

			// alert(content);

			// alert(content);
			// document.getElementById("text").innerText=content;
			// document.getElementById("fill").style.display='block';
			scanner.stop();
			document.getElementById("overlay").style.display = "none";
			document.getElementById("vidscan").style.display = "none";


			fill(content);

		});
		Instascan.Camera.getCameras().then(function (cameras) {
			if (cameras.length > 0) {
				scanner.start(cameras[0]);
			} else {
				console.error('No cameras found.');
			}
		}).catch(function (e) {
			console.error(e);
		});
	}

	function off() {
		document.getElementById("overlay").style.display = "none";
		document.getElementById("vidscan").style.display = "none";
		let scanner = new Instascan.Scanner({video: document.getElementById('preview')});
		scanner.stop();
	}

	function fill(code) {
		// console.log(code);
		if (code.includes('8?') == true) {
			var cd = code.substring(40);
			var code = '<?xml version = "1.0" encoding = "UTF-8"?>' + cd;


		}
		if (code.includes('<?xml version = "1.0" encoding = "UTF-8"?>') == true) {
			var code = code;
		} else {
			// alert("hii");
			document.getElementById("vidscan1").style.display = "block";
			document.getElementById("overlay1").style.display = "block";
			cap_image1();

			function cap_image1() {
				document.getElementById("my_camera1").style.display = "block";

				Webcam.set({
					width: 320,
					height: 240,
					image_format: 'jpeg',
					jpeg_quality: 90
				});
				Webcam.attach('#my_camera1');
				document.getElementById("cap_btn1").style.display = "block";
			}

		}


		// console.log(code);

		// app.request(baseURL+"patientController/fill")
		$.ajax({
			url: 'https://covidcare.docango.com/patientController/fill',
			type: "POST",
			data: {code},
			success: function (success) {
				success = jQuery.parseJSON(success);
				var data = success.xml_arr;
				var uid = data['uid'][0];
				var name = data['name'][0];
				var gender = data['gender'][0];
				var yob = data['year_of_birth'][0];
				var loc = data['location'][0];
				var vtc = data['vtc'][0];
				var dist = data['dist'][0];
				var pc = data['pc'][0];

				// console.log(data['uid'][0]);

				// document.getElementById("u_id").value(uid);
				console.log(data);

				document.getElementById("adhhar_no").value = uid;
				document.getElementById("name").value = name;
				if (gender == "M" || gender == "MALE") {
					document.getElementById("maleRadio").checked = 'true';
				} else {
					document.getElementById("femaleRadio").checked = 'true';
				}
				document.getElementById("loc").value = loc + "," + vtc;
				document.getElementById("vtc").value = vtc;
				document.getElementById("dist").value = dist;
				document.getElementById("pc").value = pc;


			}, error: function (error) {
				alert("something went to wrong");
			}
		});
	}
	
	function checkadhar(id){
		if(id==1){
			$("#adhhar_no").show();
		}else{
			$("#adhhar_no").hide();
		}
	}

</script>


<?php $this->load->view('_partials/footer');

if ($patient_id != 0) {
	echo "<script>get_PatientDataById(" . $patient_id . ")</script>";

}
?>
