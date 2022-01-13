<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Doctor Details</h1>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Doctor Details</h4>
							<div class="card-header-action">
								<button class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<div class="dataTables_wrapper no-footer">
									<table class="table table-striped dataTable no-footer" id="doctor_details_view"
										   role="grid">
										<thead>
										<tr>
											<td>Profile</td>
											<td>Name</td>
											<td>Email</td>
											<td>Contact</td>
											<td>Category</td>
											<td>Education</td>
											<td>Action</td>
										</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!--
		check javascript inn doctor-view-1.js
-->

<?php $this->load->view('_partials/footer'); ?>
