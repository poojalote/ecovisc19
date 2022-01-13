<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Users Details</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">
					<div class="card">
						<div class="card-header">
							<h4>User Details</h4>
							<div class="card-header-action">
								<div class="row">
									<div class="form-group mx-2 my-0">
										<select class="form-control" name="userCompany" id="userCompany" onchange="getUsersTableData(2,this.value)">

										</select>
									</div>
									<button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#fire-modal-users" id="userAdd" ><i
											class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<div class="dataTables_wrapper no-footer">
									<table class="table table-striped dataTable no-footer" id="usersTable"
										   role="grid">
										<thead>
										<tr>
											<td>Name</td>
											<td>Username</td>
											<td>Company</td>
											<td>Branch</td>
											<td>Action</td>
										</tr>
										</thead>
										<tbody>

										</tbody>
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

<!-- company modal  -->
<?php $this->load->view('admin/users/user_form'); ?>


<?php $this->load->view('_partials/footer'); ?>
