<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Database</h1>
			<div class="section-header-breadcrumb">
              <a href="<?php echo base_url(); ?>createNewtable" class="btn btn-primary" style="border-radius:20px;"><i
											class="fas fa-plus"></i> Create new table</a>
            </div>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h4>Database Table Details</h4>
							
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<div class="dataTables_wrapper no-footer">
									<table class="table table-striped dataTable no-footer" id="databaseTable"
										   role="grid">
										<thead>
										<tr>
											<td>Table Name</td>
											<td>Table Actions</td>
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
<!-- Modal -->
<div id="databaseCreationModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fa fa-database"></i> Categories</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>

			</div>
			<div class="modal-body">
				<div id="databaseTableColumnsDetails" style="height: 70vh;overflow: scroll;"></div>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>


<?php $this->load->view('_partials/footer'); ?>

