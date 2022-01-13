<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Doctor Details</h1>
		</div>
		<div class="section-body">
			<div class="row justify-content-center">
				<div class="col-12 col-md-6 col-lg-6">
					<div class="card">
						<form id="doctor_form" method="post" data-validate="ture">
							<div class="card-body">
								<div class="section-title">Basic Details</div>
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" data-required data-required-msg >
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email">
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Contact</label>
										<input type="text" class="form-control" name="contact">
									</div>
									<div class="form-group col-md-6">
										<label>Other Contact</label>
										<input type="text" class="form-control" name="alter_contact">
									</div>
								</div>

								<div class="form-group">
									<label class="d-block">Gender</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="gender"
											   id="maleRadio" checked="">
										<label class="form-check-label" for="maleRadio">
											Male
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="gender"
											   id="femaleRadio" checked="">
										<label class="form-check-label" for="femaleRadio">
											Female
										</label>
									</div>
								</div>
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control" name="address"></textarea>
								</div>
								<div class="section-title">Profile Image</div>
								<div class="custom-file">
									<input type="file" name="profileImage[]" class="custom-file-input" id="profileImage">
									<label class="custom-file-label" for="profileImage">Choose file</label>
								</div>


								<div class="section-title mt-0">Category</div>
								<div class="form-group">
									<select class="form-control select2" id="category" name="category">
									</select>
								</div>
								<div class="section-title mt-0">Education</div>
								<div class="form-group">
									<select class="custom-select" name="education" id="education">

									</select>
								</div>
							</div>
							<div class="card-footer text-right">
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


<?php $this->load->view('_partials/footer'); ?>
