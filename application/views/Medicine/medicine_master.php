<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Medicine Master</h1>
		</div>
		<div class="section-body">
			<div class="card">

				<div class="card-body">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<form id="add_medi_form" name="add_medi_form" >
									<div class="form-row">
										<div class="form-group col-md-4">
											<label>Classification</label>
											<select name="classification_name" id="classification_name_medicine"
													onclick="loadSubClassification(this.value)"
													style="width: 100%"
													class="form-control">
												<option>Classification</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Sub-Classification</label>
											<select name="group_name" id="group_name_medicine"
													style="width: 100%"
													class="form-control">
												<option>Select Sub-Classification</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>Medicine Name</label>
											<input type="text" list="myMenu" class="form-control" id="medi_name"
												   name="medi_name"
												   Placeholder="Enter Medicine Name">
											<datalist id="myMenu">
											</datalist>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-4">
											<label>Unit of Measure</label>
											<select name="unit_of_measure" id="unit_of_measure"
													data-valid="required" data-msg="Enter Unit of Measure"
													style="width: 100%"
													class="form-control">
												<option>Unit of Measure</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label>PKT</label>
											<input type="number" class="form-control "
												   id="pkt_value"
												   name="pkt_value"
												   min="1"
												   data-valid="required" data-msg="Enter value"/>
										</div>
										<div class="align-items-end col d-flex form-group justify-content-end">
											<button class="btn btn-primary">save</button>
										</div>
									</div>

								</form>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-hover table-striped table-bordered dataTable dtr-inline font-size-md responsive display"
									   style="width: 100%"
									   id="myTable" >
									<thead>
									<tr>
										<th>Name</th>
										<th>Unit of Measure</th>
										<th>PKT</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody >
									</tbody>
								</table>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>


<script type="text/javascript">
	let prescriptionArray=[];
	$(document).ready(function () {


		loadClassification();
		loadSubClassification("group_name_medicine",0);
		loadUnitOfMeasure();
		get_medicine_data_1();
		getMedicineGroup();


	});

</script>
