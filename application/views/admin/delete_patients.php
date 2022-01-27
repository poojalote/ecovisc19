<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Patients List</h1>
		</div>
		<div class="card">
			<div class="row p-3">
				<div class="col-md-6">
					<div class="form-group">
						<select class="form-control" name="branches" id="branches">
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<select class="form-control" name="type" id="type">
							<option value="1">All</option>
							<option value="2">Admitted</option>
							<option value="3">Discharge</option>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-primary float-right" onclick="getPatientsList()">Filter</button>
				</div>
			</div>

			<div class="row">
				<div class="table-responsive">
					<div class="dataTables_wrapper no-footer">
						<table class="table table-striped dataTable no-footer" id="patient_list"
							   role="grid">
							<thead>
							<tr>
								<td>Aadhar No</td>
								<td>Name</td>
								<td>Contact</td>
								<td>DOB</td>
								<td>Admission Date</td>
								<td>Action</td>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
</div>
</section>
</div>

<?php $this->load->view('_partials/footer'); ?>
<script>
	$(document).ready(function () {
		getBranches(1);
	});

	function getBranches(id) {
		let formData = new FormData();
		formData.set("company_id", id);
		return app.request(baseURL + "getBranches", formData).then(response => {

			if (response.status === 200) {
				// modal select element
				$("#branches").empty();
				$("#branches").append(response.option);
			} else {
				$("#branches").empty();
				$("#branches").append('<option>No data Found</option>');
			}
		}).catch(error => console.log(error));
	}

	function getPatientsList() {

		var branch_id = $('#branches').val();
		var type = $('#type').val();
		app.dataTable('patient_list', {
			url: baseURL + "getPatients",
			data: {branch_id: branch_id, type: type}
		}, [
			{
				data: 1
			},
			{
				data: 2
			},
			{
				data: 3
			},
			{
				data: 4
			},
			{
				data: 5,
			},
			{
				data: 0,
				render: (d, t, r, m) => {
					if(type == 3)
					{
						return `<button class="btn btn-primary" onclick="readmit(${d})"><i class="fas fa-syringe"></i></button>
								<button class="btn btn-primary" onclick="delPatient(${d})"><i class="fas fa-trash"></i></button>`;
					}else {
						return `<button class="btn btn-primary" onclick="delPatient(${d})"><i class="fas fa-trash"></i></button>`;
					}

				},
			},
		], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			if(type == 3)
			{
				$('td:eq(6)', nRow).html(`<button class="btn btn-primary" onclick="readmit(${aData[0]})"><i class="fas fa-syringe"></i></button>
										<button class="btn btn-primary" onclick="delPatient(${aData[0]})"><i class="fas fa-trash"></i></button>`);
			}else {
				$('td:eq(6)', nRow).html(`<button class="btn btn-primary" onclick="delPatient(${aData[0]})"><i class="fas fa-trash"></i></button>`);
			}
		});
	}

	function delPatient(id) {
		if (confirm('Are you sure you want to delete this?')) {
			var branch_id = $('#branches').val();
			var type = $('#type').val();
			let formdata = new FormData();
			formdata.set('patient_id', id);
			formdata.set('branch_id', branch_id);
			formdata.set('type', type);
			return app.request(baseURL + "DeletePatient", formdata).then(response => {
				if (response.status === 200) {
					app.successToast(response.body);
					getPatientsList();
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
		}
	}

	function  readmit(id) {
		if (confirm('Are you sure you want to delete this?')) {
			var branch_id = $('#branches').val();
			let formdata = new FormData();
			formdata.set('patient_id', id);
			formdata.set('branch_id', branch_id);
			return app.request(baseURL + "Readmit", formdata).then(response => {
				if (response.status === 200) {
					app.successToast(response.body);
					getPatientsList();
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => console.log(error));
		}
	}

</script>
