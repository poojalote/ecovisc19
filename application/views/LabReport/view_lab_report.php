<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$branchpermission_array = $this->session->Branch_permission;
?>
<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header card-primary" style="border-top: 2px solid #891635;">
			<h1>Lab Report</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="col-12 col-md-12">
					<div class="card row">
						<div class="card-body">
						<ul class="nav nav-pills" role="tablist">
							<?php
							if (array_search("lab_report_critical_para", $branchpermission_array) ) {
							?>
										<li class="nav-item">
											<a href="#Frequently_use" class="nav-link " onclick="getTableData()" id="permission-tab" data-toggle="tab" role="tab">Critical Parameters</a>
										</li>
							<?php } ?>
							<?php
							if (array_search("lab_report_LabReports", $branchpermission_array)) {
							?>

										<li class="nav-item">
											<a href="#LabReport" class="nav-link " id="permission-tab" data-toggle="tab" role="tab">Lab Reports</a>
										</li>
							<?php } ?>
							<?php
							if (array_search("lab_report_radiology", $branchpermission_array) ) {
							?>
										<li class="nav-item">
											<a href="#radReport" class="nav-link active" id="radiology-tab" onclick="getRadiologyTableData()" data-toggle="tab" role="tab">Radiology Reports</a>
										</li>
							<?php } ?>
							<?php
							if (array_search("lab_report_pathology", $branchpermission_array) ) {
							?>
										<li class="nav-item">
											<a href="#pathReport" class="nav-link " id="pathology-tab" onclick="getPathologyTableData()" data-toggle="tab" role="tab">Pathology Reports</a>
										</li>
							<?php } ?>
							<?php
							if (array_search("lab_report_other_service", $branchpermission_array)) {
							?>
										<li class="nav-item">
											<a href="#otherServiceReport" class="nav-link " id="otherservice-tab" onclick="getOtherServiceTableData()" data-toggle="tab" role="tab">Other Services Reports</a>
										</li>
							<?php } ?>
							<?php
							if (array_search("lab_report_graph", $branchpermission_array)) {
							?>
										<li class="nav-item">
											<a href="#LabReportGraphic" onclick="getLabReportOrderTestData()" class="nav-link " id="permission-tab" data-toggle="tab" role="tab">Graphs</a>
										</li>
							<?php } ?>
										
									</ul>
									<div class="tab-content">
									<div class="tab-pane fade   " id="Frequently_use" role="tabpanel"><br>
									<div id="getTableDataDiv" align="center"></div>	
									
									</div>
									
									
									<div class="tab-pane fade " id="LabReport" role="tabpanel">
									<div class="table-responsive">
								<table class="table table-hover table-striped table-bordered" id="labReportTable">
									<thead style="background: #8916353b;">
									<tr>
										<td data-priority="1">VisitDate</td>
										<td data-priority="2">Order Test</td>
										<td>Parameter Name</td>
										<td>Result</td>
										<td>Unit</td>
										<td>Ref Range</td>
									</tr>
									<tr>
										<td>VisitDate</td>
										<td>Order Test</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									</thead>
									<tbody>

									</tbody>

								</table>
									</div>
									</div>
									
									<div class="tab-pane fade show active " id="radReport" role="tabpanel"><br>
										<div id="getRadioLogyDiv" align="center"></div>	
									
									</div>
									<div class="tab-pane fade  " id="pathReport" role="tabpanel"><br>
										<div id="getPathoLogyDiv" align="center"></div>

									</div>
									<div class="tab-pane fade  " id="otherServiceReport" role="tabpanel"><br>
										<div id="getOtherServiceDiv" align="center"></div>	
									
									</div>
									<div class="tab-pane fade  " id="LabReportGraphic" role="tabpanel"><br>
										<div class="col-md-12">
											<select class="col-sm-4 form-control" name="orderTestGraphicOpt" id="orderTestGraphicOpt" onchange="getOrderTestParaGraph(this.value)">
												
											</select>
										</div>
										<div class="row" id="getLabReportGraphic" align="center">
											
										</div>	
									
									</div>
									</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>



<?php $this->load->view('_partials/footer'); ?>
