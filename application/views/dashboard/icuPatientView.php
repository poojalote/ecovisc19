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
	 border-top: 1px solid gray;
	}
	#historyItemTable.dataTable{
	   border: 1px solid gray;
	   border-top: 1px solid gray;
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
							


						</div>
						
						
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="form-group mx-2 my-0">
								<!--<select class="form-control" id='searchPatient'
										 style="border-radius: 20px;">
									
									
								</select>-->
							</div>
							<br>
							<button type="button" onclick="CallAPI()" style="float:right" class="btn btn-primary">Click me</button>
					
				</div>
			</div>
		</div>
	</section>
</div>



<!-- Main Content  end-->

<?php $this->load->view('_partials/footer'); ?>
<script type="text/javascript">
	$(document).ready(function () {

	get_icuPatientList();

});
	function get_icuPatientList() {
	var gender = $("#searchGender").val();

	$.ajax({
		type: "POST",
		url: baseURL + "get_icuPatientList",
		dataType: "json",
		async: false,
		cache: false,
		data: {gender: gender},
		success: function (result) {
			var data = result.options;
			if (result.status == 200) {
				$('#searchPatient').empty();
				$('#searchPatient').append(data);
				/* $('#searchPatient').prepend('<option value="1050">ASMA SALMANI</option>');
				$('#searchPatient').prepend('<option value="1044">Shakuntala Nitant Amberkar</option>');
				$('#searchPatient').prepend('<option value="1045">MEERA HANDE BHASKAR</option>'); */
				$('#searchPatient').select2();

			} else {
				$('#searchPatient').empty();
				$('#searchPatient').append(data);
				$('#searchPatient').select2();
			}
		}
	});
}
function CallAPI(){

		var p_id=$('#searchPatient').val();
		//reportDownloadForm
		$.ajax({
			type: "POST",
			url: baseURL+"ApiController/uploadAllPatientDataLive",
			dataType: "json",
			//data:{p_id},
			success: function (result) {
				
				alert(result);

			}, error: function (error) {
				
			}
		});
	}
</script>
