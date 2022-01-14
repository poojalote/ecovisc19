<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$session_data = $this->session->user_session;
	$user_type = $session_data->user_type;
	$role = $session_data->roles;
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

	table {
	/ / table-layout: fixed;
	}

	/*.profile-widget .profile-widget-picture {
    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    float: left;
    width: 100px;
    margin: -35px -5px 0 30px;
    position: relative;
    z-index: 1;
}*/

</style>
<!-- Main Content start -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-body">
			<div class="">
				<div class="section-header card-primary">
					<h1 style="color: #891635">Patient List</h1>
					<div class="card-header-action d-flex" style="margin-left: auto; ">
						<div class="align-items-center">
							<div class="form-group mx-2 my-0">
								<select class="form-control" id='allPatient'
										onchange="loadPatients(this.value)" style="border-radius: 20px;">
									<option value="1">Service Order</option>
									<option value="2">Order Cancelled</option>
									<option value="4">In Process</option>
                                    <option value="8">Report Submitted</option>
									<option value="3">All</option>

								</select>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<table class="table table-hover table-striped table-responsive table-bordered "
						   id="patientTable" style="width:100%" role="grid">
						<thead style="background: #8916353b;">
						<tr>
							<th>Aadhar Number</th>
							<th >Name</th>
							<th>Contact</th>
							<th>Blood Group</th>
<!--							<th>Zone</th>-->
<!--							<th>Bed</th>-->
							<th>Admission Date</th>
							<th>MFD</th>
							<th >Action</th>


						</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>




<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
