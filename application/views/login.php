	<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title><?php echo $title; ?></title>
	<!-- add icon link -->
	<link rel="icon" href="<?php echo base_url(); ?>assets/img/reliance_logo.ico"
		  type="image/x-icon" style="font-size:60px;">
	<!-- General CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">
	<!-- Template CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
	<style type="text/css">
		body {
			background-color: #f2e5e9;
			font-family: 'Ubuntu', sans-serif;
		}
		.main
		{
			background-color: #FFFFFF;
			width: 400px;
			height: auto;
			margin: 7em auto;
			border-radius: 1.5em;
			box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
		}
		.sign {
			padding-top: 40px;
			color: #891635;
			font-family: 'Ubuntu', sans-serif;
			font-weight: bold;
			font-size: 23px;
		}

		.un {
			width: 76%;
			color: rgb(38, 50, 56);
			font-weight: 700;
			font-size: 14px;
			letter-spacing: 1px;
			background: rgba(136, 126, 126, 0.04);
			padding: 10px 20px;
			border: none;
			border-radius: 20px;
			outline: none;
			box-sizing: border-box;
			border: 2px solid rgba(0, 0, 0, 0.02);
			margin-bottom: 50px;
			margin-left: 46px;
			text-align: center;
			margin-bottom: 27px;
			font-family: 'Ubuntu', sans-serif;
		}
		/*.input_btn_radius
		{
			border-radius: 20px;
		}*/
		form.form1 {
			padding-top: 40px;
		}

		.pass {
			width: 76%;
			color: rgb(38, 50, 56);
			font-weight: 700;
			font-size: 14px;
			letter-spacing: 1px;
			background: rgba(136, 126, 126, 0.04);
			padding: 10px 20px;
			border: none;
			border-radius: 20px;
			outline: none;
			box-sizing: border-box;
			border: 2px solid rgba(0, 0, 0, 0.02);
			margin-bottom: 50px;
			margin-left: 46px;
			text-align: center;
			margin-bottom: 27px;
			font-family: 'Ubuntu', sans-serif;
		}


		.un:focus, .pass:focus {
			border: 2px solid rgba(0, 0, 0, 0.18) !important;

		}

		.submit {
			cursor: pointer;
			border-radius: 5em;
			color: #fff;
			background: linear-gradient(to right, #891635, #891635);
			border: 0;
			padding-left: 40px;
			padding-right: 40px;
			padding-bottom: 10px;
			padding-top: 10px;
			font-family: 'Ubuntu', sans-serif;
			/*margin-left: 35%;*/
			font-size: 13px;
			box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
			outline: none;
		}

		.forgot {
			text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
			color: #891635;
			padding-top: 15px;
		}

		a {
			text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
			color: #891635;
			text-decoration: none
		}
		.footer {
			position: fixed;
			text-align: center;
			bottom: 0px;
			width: 100%;
			margin: 0;
			padding: 0;
			left: 0;
			right: 0;
		}
		button
		{
			outline: none;
			border: none;
		}

		@media (max-width: 600px) {
			.main {
				border-radius: 1.5em;
				width:95%;
			}
			.sign
			{
				padding-top: 40px;
			}
			form.form1
			{
				padding-top: 30px;
			}
		}

	</style>
</head>

<body>
<div id="app">
	<section class="section">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">


					<div class="card main">
						<div class="login-brand mb-4">
								<img src="<?php echo base_url(); ?>dist/img/credit/healthstart.jpeg" height="200" width="200" alt="logo"
									 class="rounded-circle">
						</div>

						<div class="card-body text-center">
							<form  method="post" data-form-valid="checkLogin"
								   id="loginForm" onsubmit="return false">
                                <input type="hidden" name="isToken" value="0" id="isToken">
								<div class="form-group">
									<!-- <label for="email">Email</label> -->
									<input id="email" type="text" class="form-control text-center input_btn_radius un" placeholder="Email" name="email" tabindex="1"
										   data-valid="required"
										   data-msg="Please fill username"
										   required autofocus>
								</div>

								<div class="form-group">
									<div class="d-block">
										<!-- <label for="password" class="control-label">Password</label> -->
									</div>
									<input id="password" type="password" placeholder="Password" class="form-control text-center input_btn_radius un" name="password"
										   data-valid="required"
										   data-msg="Please fill password"
										   tabindex="2" >
									<div class="invalid-feedback">
										please fill in your password
									</div>
								</div>

								<div class="form-group">
									<button type="submit" class="submit" style="background: #891635;color: white;" tabindex="4">
										SIGN IN
									</button>
									<p class="forgot" align="center"><a href="#">Forgot Password?</a></p>
								</div>

							</form>

						</div>
					</div>



					<div class=" footer"> <div style="box-shadow: 3px 0px 3px #000000;padding: 4px;margin: 0px;">Copyright ©  <?= date('Y') ?></div></div>
				</div>
			</div>
		</div>
	</section>

    <div class="modal fade " data-backdrop="static" data-keyboard="false" id="Mobileupdate" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                 style="width: 89% !important; border-radius: 15px !important; box-shadow: 0px 0px 10px 0px lightgrey;">
                <div class="modal-header justify-content-center border-bottom-0">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">
                        <img src="<?php echo base_url(); ?>dist/img/credit/healthstart.jpeg" height="50"
                             width="50" alt="logo"
                             class="rounded-circle">
                    </h5>

                </div>
                <form method="post" data-form-valid="insertMobile"
                      id="MobileUpdate" onsubmit="return false">
                    <div class="modal-body p-0">
                        <input type="hidden" name="redirectTo" id="redirectTo">
                        <div class="text-center">
                            <p>Please provide your mobile number to receive OTP</p>
                        </div>
                        <div class="form-group d-flex flex-column align-items-center">
                            <input type="text" name="mobile_number" id="mobile_number"
                                   data-valid="required|number|minlength=10|maxlength=12"
                                   data-msg="Enter Mobile Number|Only Numbers Allowed|Enter 10 digit number|Mobile number should be between 10 to 12 Characters"
                                   required autofocus class="form-control m-auto w-75 border border-secondary">
                        </div>
                    </div>
                    <div class="justify-content-center modal-footer">
                        <button type="submit" id="updateNumber" class="btn text-light"
                                style="border-radius: 25px; background-color: #891635;border: 1px solid #b02a37;">Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('_partials/js'); ?>
