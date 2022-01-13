<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>

<!-- Main Content -->
<div class="main-content main-content1">
	<section class="section">
		<div class="section-header" style="border-top: 2px solid #891635">
			<h1>Order Room</h1>
		</div>
		<div class="section-body">
			<div class="">
				<div class="">
					<div class="card">

						<div class="card-body">

								<div id="p_details">


								</div>
								<br/>


								<form id="room_orderform" onsubmit="return false">
									<input type="hidden" value="" name="p_id" id="p_id">


								
								<div class="form-group my-0 py-0 mt-2">
									
							</div>
							</form>

						</div>
						
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
		var patient_id=localStorage.getItem("patient_id");
		$("#patient_list").val(patient_id);
		$("#p_id").val(patient_id);

	});
	
</script>
