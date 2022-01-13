<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">

		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card profile-widget">
						<div class="profile-widget-header">
<!--							<img alt="image" src="--><?//=base_url()?><!--assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">-->
							<div class="profile-widget-items">
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">Name</div>
									<div class="profile-widget-item-value" id="patient_name"></div>
								</div>
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">Aadhar Number</div>
									<div class="profile-widget-item-value" id="patient_aadhar_number">-</div>
								</div>
								<div class="profile-widget-item">
									<div class="profile-widget-item-label">Contract</div>
									<div class="profile-widget-item-value" id="patient_contact">-</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="row">
				<!-- <div class="col-lg-6">
					<div class="card card-large-icons">
						<div class="card-icon bg-primary text-white">
							<i class="fas fa-bed"></i>
						</div>
						<div class="card-body">
							<h4>Bed Management</h4>
							<a href="features-setting-detail.html" class="card-cta">view <i class="fas fa-chevron-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card card-large-icons">
						<div class="card-icon bg-primary text-white">
							<i class="fas fa-pills"></i>
						</div>
						<div class="card-body">
							<h4>Medicine management</h4>
							<a href="features-setting-detail.html" class="card-cta">view<i class="fas fa-chevron-right"></i></a>
						</div>
					</div>
				</div> -->
				<div class="col-lg-12">
					<div class="table-responsive">
						<table class="table table-striped" id="companyTable">
							<thead>
							<tr>
								<td>Room</td>
								<td>Bed</td>
								<!-- <td>Action</td> -->
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>




<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		document.getElementById("patient_nameSidebar").innerText=localStorage.getItem("patient_name");
		document.getElementById("patient_adharSidebar").innerText= localStorage.getItem("patient_adharnumber");

		//document.getElementById("patient_aadhar_numberSidebar").innerText=localStorage.getItem("patient_adharnumber");
		//document.getElementById("patient_idSidebar").innerText=localStorage.getItem("patient_id");
	});
</script>
