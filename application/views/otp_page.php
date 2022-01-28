<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>otp</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
	<style>
		body {
			background-color: #f2e5e9;
		}

		.height-100 {
			height: 100vh
		}

		.card {
			width: 400px;
			border: none;
			height: 300px;
			box-shadow: 0px 5px 20px 0px #d2dae3;
			z-index: 1;
			display: flex;
			justify-content: center;
			align-items: center;
			border-radius: 15px;
		}

		.card h6 {
			color: #891635;
			font-size: 20px
		}

		.inputs input {
			width: 40px;
			height: 40px
		}

		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			margin: 0
		}

		.card-2 {
			background-color: #fff;
			padding: 10px;
			width: 350px;
			height: 100px;
			bottom: -50px;
			left: 20px;
			position: absolute;
			border-radius: 10px
		}

		.card-2 .content {
			margin-top: 50px
		}

		.card-2 .content a {
			color: #891635
		}

		.form-control:focus {
			box-shadow: none;
			border: 2px solid #891635
		}

		.btn-danger:focus {
			color: #fff;
			background-color: #bb2d3b;
			border-color: #b02a37;
			box-shadow: none;
		}

		.validate {
			border-radius: 20px;
			height: 40px;
			background-color: #891635;
			border: 1px solid red;
			width: 140px
		}
		.resendbtn{
			color: #891635;
			margin: 0;
			font-size: 16px;
			padding: 0;
			margin-top: -6px;
			font-weight: bolder;
		}
	</style>
</head>

<body>
<div class="container height-100 d-flex justify-content-center align-items-center">
	<div class="position-relative">
		<div class="card p-2 text-center">
			<input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
			<h6 id="otp_message"><?= $data; ?></h6>
			<div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
				<input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" autofocus/>
				<input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1"/>
				<input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1"/>
				<input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1"/>
			</div>
			<div class="mt-4">
				<button class="btn btn-danger px-4 validate" onclick="validateOtp()">Validate</button>
				<div class="mb-0 mt-3" style="font-size: small;">
					<span>For more details contact with Authorised Person</span><small> 9320675610 / 9920482779 </small>
				</div>
				<div class="mb-0 mt-3" style="font-size: small;">Didn't Recieve the OTP? <span id="resend">Resend in <span id="countdowntimer">120</span> seconds</span>
				</div>
			</div>
		</div>
	</div>
</div>
</body>


<?php $this->load->view('_partials/js'); ?>

<script> var baseUrl = '<?=base_url()?>';</script>
<script>
	let logged_user = [];
	$(document).ready(function () {
		var log = localStorage.getItem('logged_users');
		if (log !== null) {
			log = atob(log);
			log = JSON.parse(log);
			if (Array.isArray(log) === true) {
				logged_user.push(...log);
			}
		}
	});
	document.addEventListener("DOMContentLoaded", function (event) {

		function OTPInput() {
			const inputs = document.querySelectorAll('#otp > *[id]');
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].addEventListener('keydown', function (event) {
					if (event.key === "Backspace") {
						inputs[i].value = '';
						if (i !== 0) inputs[i - 1].focus();
					} else {
						if (i === inputs.length - 1 && inputs[i].value !== '') {
							return true;
						} else if ((event.keyCode > 47 && event.keyCode < 58) || (event.keyCode >= 96 && event.keyCode <= 105)) {
							inputs[i].value = event.key;
							if (i !== inputs.length - 1) inputs[i + 1].focus();
							event.preventDefault();
						} else if (event.keyCode > 64 && event.keyCode < 91) {
							inputs[i].value = String.fromCharCode(event.keyCode);
							if (i !== inputs.length - 1) inputs[i + 1].focus();
							event.preventDefault();
						}
					}
				});
			}
		}

		OTPInput();
	});

	function validateOtp() {
		var first = $('#first').val();
		var second = $('#second').val();
		var third = $('#third').val();
		var fourth = $('#fourth').val();
		var otp = first + second + third + fourth;
		var formdata = new FormData();
		formdata.set('otp', otp);
		app.request(baseUrl + "OtpValidation", formdata).then(res => {
			if (res.status === 200) {
				var user_id = $('#user_id').val();
				logged_user.push(user_id);
				var log_user = JSON.stringify(logged_user);
				log_user = btoa(log_user);
				localStorage.setItem('logged_users', log_user);

				var device = JSON.stringify(res.device_id);
				var device_details = btoa(device);
				localStorage.setItem('device_id', device_details);

				userData = res.data;
				if (parseInt(userData.roles) === 1) {
					window.location.href = baseURL + "admin/dashboard";
				} else if(parseInt(userData.roles) === 6){
					window.location.href = baseURL + "labMasterAdmin";
				} else {
					if (parseInt(userData.roles) === 2) {
						if (parseInt(userData.user_type) === 5) {
							window.location.href = baseURL + "hospitalMedicine";
							// window.location.href = baseURL + "pharmeasy";
						} else {
							if (parseInt(userData.default_access) !== 2) {
								window.location.href = baseURL + "patient_info";
							} else {
								window.location.href = baseURL + "icubedManagement";
							}
						}
					} else if (parseInt(userData.roles) === 5) {
						window.location.href = baseURL + "security";
					} else {
						if (parseInt(userData.user_type) === 4) {
							window.location.href = baseURL + "pharmeasy";
							// window.location.href = baseURL + "hospitalMedicine";
						} else if (parseInt(userData.user_type) === 6) {
							window.location.href = baseURL + "view_pickup";
							// window.location.href = baseURL + "pharmeasy";
						} else if (parseInt(userData.user_type) === 12) {
							window.location.href = baseURL + "labpatient_info";
						} else if (parseInt(userData.user_type) === 7) {
							window.location.href = baseURL + "view_radiologypickup";
						}else{
							window.location.href = baseURL + "patient_info";
						}
					}
				}
			} else {
				$('#first').val("");
				$('#second').val("");
				$('#third').val("");
				$('#fourth').val("");
				console.log(res.data);
				app.errorToast(res.data);
			}
		}).catch(error => console.log(error));
	}

	function resendOtp(mobile) {
		var formdata = new FormData();
		formdata.set('mobile',mobile);
		app.request(baseURL + "ResendOtp", formdata).then(success => {
			if (success.status === 200) {
				app.successToast("Otp Sent Successfully");
			}
			else{
				console.log('Error Sending Otp');
			}
		}).catch(error => console.log(error));
	}

	var timeleft = 120;
	var downloadTimer = setInterval(function(){
		timeleft--;
		document.getElementById("countdowntimer").textContent = timeleft;
		if(timeleft <= 0){
			clearInterval(downloadTimer);
			$('#resend').html('');
			$('#resend').append(`<button class="btn btn-link text-decoration-none resendbtn" onclick="resendOtp()">Resend OTP</button>`);
		}
	},1000);


</script>

</html>
