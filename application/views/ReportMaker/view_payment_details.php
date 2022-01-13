<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<style>
	.content-wrap section
	{
		text-align: unset!important;
	}
	#form_fieldfile_29,#form_fieldfile_93
	{
		width: 100%!important;
	}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section section-body_new">
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="card">
						<input type="hidden" id="department_id" name="department_id"
							   value="<?= $department_id ?>">
						<input type="hidden" id="section_id" name="section_id"
							   value="<?= $section_id ?>">
						<input type="hidden" id="queryparameter_hidden" name="queryparameter_hidden"
							   value="<?= $queryParam ?>">
						<input type="hidden" id="hiddenDivName" name="hiddenDivName" value="payment_details">

						<section id="profileSection">
							<div class="card card-primary">
								<div class="card-body">

									<section id="payment_details"></section>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>


<?php $this->load->view('_partials/footer'); ?>

<script type="text/javascript">
	const base_url = "<?php echo base_url(); ?>";

	$(document).ready(function () {
		let queryParam =document.getElementById("queryparameter_hidden").value;
		let sectionId = document.getElementById("section_id").value;
		let departmentId = document.getElementById("department_id").value;
		let qObject = JSON.parse(atob(queryParam));
		qObject.patient_id=localStorage.getItem("patient_id");
		// let object ={"patient_id":localStorage.getItem("patient_id"),"branch_id":session_branch_id};
		let string = btoa(JSON.stringify(qObject));
		document.getElementById("queryparameter_hidden").value=string;
		get_forms(148, 0, string, departmentId, null, 'payment_details');

	})

</script>
