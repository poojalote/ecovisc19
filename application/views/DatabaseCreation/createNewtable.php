<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style type="text/css">
	.main-content
	{
		width: 100%!important;
		padding-left: 30px!important;
	}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Create New Table</h1>
			<div class="section-header-breadcrumb">
              <a href="<?php echo base_url(); ?>table_creation" class="btn btn-primary" style="border-radius:20px;"><i
											class="fas fa-arrow-left"></i> Back</a>
            </div>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">
						<div class="card-body">
							<form id="newTableCreateForm">
								<div class="section-title mt-0">Table Name</div>
								<div class="form-group">
			                      <label>Table Name</label>
			                      <input type="text" class="form-control" name="table_name" id="table_name">
			                    </div>
								<div class="section-title mt-0">Table Columns</div>
								<div class="form-group">
									<input type="hidden" name="rowCount" id="rowCount" value="0">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Name</th>
												<th>Type</th>
												<th>Length</th>
												<th>Not Null</th>
												<th>Auto Increament</th>
												<th>Index</th>
												<th>Default</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="tableRow"></tbody>
									</table>
								</div>
								<div class="form-group text-center">
									<button type="button" class="btn btn-info" onclick="getNewRow()"><i class="fas fa-plus"></i> Add New Column</button>
								</div>
								<div class="form-group text-right">
									<hr/>
									<button type="button" class="btn btn-primary" onclick="saveDatabaseTableCreation()">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!-- company modal  -->
<?php $this->load->view('admin/department/department_form'); ?>


<?php $this->load->view('_partials/footer'); ?>

