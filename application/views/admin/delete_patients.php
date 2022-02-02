<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$role = $this->session->user_session->roles;
$type = $this->session->user_session->user_type;
$branch_id = $this->session->user_session->branch_id;
?>
<input type="hidden" name="roles" id="roles" value="<?= $role ?>">
<input type="hidden" name="user_type" id="user_type" value="<?= $type ?>">
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Patients List</h1>
		</div>
		<div class="card">

			<?php if ($role == 2 && $type == 3) { ?>
				<input type="hidden" name="branch_id" id="branch_id" value="<?= $branch_id ?>">
				<input type="hidden" name="type" id="type1" value="3">
			<?php } else { ?>
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
			<?php } ?>

			<div class="row p-4">
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
		var role = $('#roles').val();
		var user_type = $('#user_type').val();
		if(role == 2 && user_type == 3){
			getPatientsList();
		}
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
		var role = $('#roles').val();
		var user_type = $('#user_type').val();
		let branch_id = "";
		let type = "";
		if (role == 2 && user_type == 3) {
			branch_id = $('#branch_id').val();
			type = $('#type1').val();
		} else {
			branch_id = $('#branches').val();
			type = $('#type').val();
		}
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
					if (role == 2 && user_type == 3) {
						if (type == 3) {
							return `<button class="btn btn-primary" onclick="readmit(${d})"><i class="fas fa-syringe"></i></button>`;
						} else {
							return ``;
						}
					} else {
						if (type == 3) {
							return `<button class="btn btn-primary" onclick="readmit(${d})"><i class="fas fa-syringe"></i></button>
								<button class="btn btn-primary" onclick="delPatient(${d})"><i class="fas fa-trash"></i></button>`;
						} else {
							return `<button class="btn btn-primary" onclick="delPatient(${d})"><i class="fas fa-trash"></i></button>`;
						}
					}
				},
			},
		], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
			if (role == 2 && user_type == 3) {
				if (type == 3) {
					$('td:eq(6)', nRow).html(`<button class="btn btn-primary" onclick="readmit(${aData[0]})"><i class="fas fa-syringe"></i></button>`);
				} else {
					$('td:eq(6)', nRow).html(``);
				}
			} else {
				if (type == 3) {
					$('td:eq(6)', nRow).html(`<button class="btn btn-primary" onclick="readmit(${aData[0]})"><i class="fas fa-syringe"></i></button>
										<button class="btn btn-primary" onclick="delPatient(${aData[0]})"><i class="fas fa-trash"></i></button>`);
				} else {
					$('td:eq(6)', nRow).html(`<button class="btn btn-primary" onclick="delPatient(${aData[0]})"><i class="fas fa-trash"></i></button>`);
				}
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

	function readmit(id) {
		if (confirm('Are you sure you want to re-admit this?')) {
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
