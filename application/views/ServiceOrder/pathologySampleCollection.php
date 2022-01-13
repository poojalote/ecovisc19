<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>

	table.dataTable tbody td {
		word-break: break-word;
		vertical-align: top;
	}

	div.wrapDiv {
		white-space: nowrap;
		width: 100px;

		overflow: hidden;
		text-overflow: ellipsis;
	}

	div.wrapDiv:hover {
		overflow: visible;
		white-space: normal;

	}
</style>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<!-- <div class="section-header" style="border-top: 2px solid #891635">
			<h1> Sample Collection</h1>
		</div> -->
		<div class="section-header card-primary">
			<h1 style="color: #891635">Pathology Sample Collection</h1>

		</div>
		<div class="section-body">
			<div class="">
				<div class="">

					<div class="card">
						<div class="card-header d-flex">

							<div class="card-header-action">

								<div class="form-group mx-2 my-0">
									<select class="form-control" id='psampleAllPatient'
											onchange="getSampleCollectionTable('PATHOLOGY','pathologySampleTable',this.value)"
											style="width: 100%">
									</select>
								</div>

							</div>
							<div class="col-md-2 form-group" style="margin-left: auto;">
								<button name="pathologyExcelNotConfirm" id="pathologyExcelNotConfirm"
										class="btn btn-primary" onclick="getNotConfirmReport(0,'PATHOLOGY')"><i
											class="fa fa-download"></i> Download Report
								</button>
							</div>
						</div>

						<div class="card-body">


							<table class="table table-bordered table-stripped" id="pathologySampleTable">
								<thead>
								<tr>
									<th>Bed No.</th>
									<th>Patient Name</th>
									<!--<th>Service Code</th>-->
									<th>Service Order No.</th>
									<th style="width: 165px;">Service Name</th>
									<th>Confirm Service Given</th>
									<th>Delete Service</th>
									<th>Service Provider</th>
									<th>Date and Time</th>
								</tr>
								<!-- <tr>
									<th>Bed No.</th>
									<th>Patient Name</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr> -->
								</thead>
								<tbody>

								</tbody>

							</table>


						</div>


					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="deleteSampleModel"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">
						<ul class="list-group list-group-flush" id="sampleList">

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="ListPathologyServicesModal"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<form id="PathologyFileUploadationForm" method="post">
			<div class="modal-header">
				<h5>Pathology Sample Collection</h5>
			</div>
			<div class="modal-body py-0">
				<div class="card my-0 shadow-none">
					<div class="card-body">

						<div id="PathologyServiceList"></div>
						<br>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="service_file">File Upload</label>
								<input type="file" class="form-control" name="service_file[]" multiple=""
									   data-valid="required" data-msg="Select file" id="service_Path_file">
								<span id="radiology_diles_error" style="color: red"></span>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit">Save</button>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- company modal  -->
<?php $this->load->view('Billing/billing'); ?>


<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {

		getSampleCollectionTable('PATHOLOGY', 'pathologySampleTable');
		get_zone();
		// getAllPatients('PATHOLOGY');
	});

	// var checkList = document.getElementById('list1');
	// checkList.getElementsByClassName('anchor')[0].onclick = function(evt) {
	// 	if (checkList.classList.contains('visible'))
	// 		checkList.classList.remove('visible');
	// 	else
	// 		checkList.classList.add('visible');
	// }

</script>
