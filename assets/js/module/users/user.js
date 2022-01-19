let role, company_id, branch_id;

$(document).ready(function () {

	getAllCompanies();
	get_permission_div();
	get_all_profile_data();
	get_user_types();
	role = $("#role").val();
	company_id = $("#uAllCompanies").val();
	branch_id = $("#uAllBranches").val();

	$('#fire-modal-users').on('show.bs.modal', function (e) {
		$('#uploadUsers').trigger('reset');
		$('#uploadUsers1').trigger('reset');
		$("#permission-tab2").show();
		$("#permission-tab1").show();
		//$( "#normalUser" ).show();
		//$( "#otheruser" ).show();
		$('#normalUser').addClass("show active");

		$('#otheruser').removeClass("show active");
		$('#permission-tab2').removeClass("active");
		$('#permission-tab1').addClass("active");
		$('#uploadUsers')[0].reset();
		$('#uploadUsers1')[0].reset();
		$('#uAllCompanies').val('');
		$('#uAllCompanies1').val('');
		// $('#dcompany_id').select2();
		$('#forward_user').val('');
		$('#roleDepartment').empty();

		if (role == 2) {
			$('#uAllCompanies').val(company_id);
			$('#uAllCompanies1').val(company_id);
			get_data(company_id);
		}
	});
	$('#profile_management').on('show.bs.modal', function (e) {
		if (role == 2) {
			getCompanyDepartment(company_id);
		} else {
			getCompanyDepartment();
		}

	});

	if (role == 2) {
		getUsersTableData(1, company_id, branch_id);
	} else {
		getUsersTableData();
	}

});

function get_data(company_id) {
	getCompanyDepartment(company_id);
}

function checkDepartment(source) {
	checkboxes = document.getElementsByName('depCheck[]');
	for (var i = 0, n = checkboxes.length; i < n; i++) {
		checkboxes[i].checked = source.checked;
	}
}

function getCompanyBranches(company_id) {
	let formData = new FormData();
	formData.set("company_id", company_id);
	return app.request(baseURL + "getBranches", formData).then(response => {

		if (response.status === 200) {
			// modal select element
			$("#uAllBranches").empty();
			$("#uAllBranches1").empty();
			$("#uAllBranches").append(response.option);
			$("#uAllBranches1").append(response.option);
		} else {
			$("#uAllBranches").empty();
			$("#uAllBranches1").empty();
			$("#uAllBranches").append('<option>No data Found</option>');
			$("#uAllBranches1").append('<option>No data Found</option>');
		}
	}).catch(error => console.log(error));

}

function getCompanyDepartment(companyId) {
	$.LoadingOverlay("show");
	let formData = new FormData();
	formData.set("companyId", companyId);
	return app.request(baseURL + 'companyDepartment', formData).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {
			var user_data = result.data;

			$("#roleDepartment").html('');
			$("#roleDepartment").append(user_data);

		} else {
			$("#roleDepartment").html('');
			app.errorToast('No Department Found');

		}
	}).catch(error => {
		$.LoadingOverlay("hide");
		app.errorToast("something went wrong please try again");
	});
}

function getAllCompanies() {
	app.request(baseURL + "fetchAllCompanies", null).then(result => {
		if (result.status === 200) {
			// above table view
			$("#userCompany").empty();
			$("#userCompany").append(result.option);
			// modal select element
			$("#uAllCompanies").empty();
			$("#uAllCompanies").append(result.option);
		} else {
			// above table view
			$("#userCompany").empty();
			$("#userCompany").append('<option>No data Found</option>');
			// modal select element
			$("#uAllCompanies").empty();
			$("#uAllCompanies").append('<option>No data Found</option>');
		}
	}).catch(error => console.log(error));

}

function getUsersTableData(type = 1, companyId = null, branch_id = null) {
	if (companyId != null) {
		if (parseInt(companyId) === 0) {
			companyId = null;
		}
	}
	app.dataTable("usersTable", {
		url: baseURL + "fetchAllUser",
		data: {
			type: type, companyId: companyId, branch_id: branch_id
		}
	}, undefined, (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {


		$('td:eq(4)', nRow).html(`
                        <a class="btn btn-primary btn-action mr-1" data-toggle="modal" data-target="#fire-modal-users" data-id="2" onClick="get_usersDataById(${aData[4]})">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
						<a class="btn btn-primary btn-action mr-1" onClick="open_access_modal(${aData[4]})">
                            <i class="fas fa-users"></i>
                        </a>
						
						
                         <a class="btn btn-danger btn-action"
                           data-toggle="tooltip" title=""
                           data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                           data-confirm-yes="deleteUser(${aData[4]})"
                            data-original-title="Delete">
                        <i class="fas fa-trash"></i></a>
                            `);
	}, () => {
		app.confirmationBox();
	});


}

function deleteUser(userId) {
	$.LoadingOverlay("show");
	let formData = new FormData();
	formData.set("userId", userId);
	app.request(baseURL + "deleteUser", formData).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {
			app.successToast(result.body);
		} else {
			app.errorToast(result.body);
		}
		if (role == 2) {
			getUsersTableData(1, company_id, branch_id);
		} else {
			getUsersTableData();
		}
	}).catch(error => console.log(error));
}

function saveUser(form) {
	$.LoadingOverlay("show");
	app.request(baseURL + "saveUser", new FormData(form)).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {

			app.successToast(result.data);
			if (role == 2) {
				getUsersTableData(1, company_id, branch_id);
			} else {
				getUsersTableData();
			}

			$("#userAdd").click();

		} else {
			app.errorToast(result.data);
		}
	})

}

function saveUser1(form) {
	$.LoadingOverlay("show");
	let formData = new FormData(form);
	formData.set("other", 1);
	app.request(baseURL + "uploadOtherUsers", formData).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {

			app.successToast(result.data);
			if (role == 2) {
				getUsersTableData(1, company_id, branch_id);
			} else {
				getUsersTableData();
			}

			$("#userAdd").click();

		} else {
			app.errorToast(result.data);
		}
	})

}

function get_usersDataById(userId) {
	$.LoadingOverlay("show");
	let formData = new FormData();
	formData.set("userId", userId);
	app.request(baseURL + "getUserDataById", formData).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {
			var user_data = result.body;
			var data = result.data;

			if (data['oth'] == 1) {
				$("#permission-tab1").hide();
				//	$( "#normalUser" ).hide();
				$("#permission-tab2").show();
				$('#otheruser').addClass("show active");
				$('#normalUser').removeClass("show active");
				if (user_data[0]['id'] != null && user_data[0]['id'] != '') {
					$("#forward_user1").val(user_data[0]['id']);
				}
				if (user_data[0]['name'] != null && user_data[0]['name'] != '') {
					$("#user_name1").val(user_data[0]['name']);
				}
				if (user_data[0]['mobile_number'] != null && user_data[0]['mobile_number'] != '') {
					$("#user_contact").val(user_data[0]['mobile_number']);
				}

				if (data['user_type'] != null && data['user_type'] != '') {
					let comp = data['user_type'];
					console.log(comp);
					$("#user_type1 option[value='" + comp + "']").prop("selected", true);
				}
				if (user_data[0]['company_id'] != null && user_data[0]['company_id'] != '') {
					let comp = user_data[0]['company_id'];

					$("#uAllCompanies1 option[value='" + comp + "']").prop("selected", true);
					getCompanyBranches(comp).then(response => {
						let branch = user_data[0]['branch_id'];
						$("#uAllBranches1 option[value='" + branch + "']").prop("selected", true);
						if (user_data[0]['udepartment'] != null && user_data[0]['udepartment'] != '') {

							let permission = user_data[0]['udepartment'].split(",");
							permission.map(dep => {
								let dep1 = dep.split("|||");
								$(`#defaultCheck${dep1[0]}`).attr("checked", "checked");
							});

						}
					})
				}
				if (user_data[0]['user_name'] != null && user_data[0]['user_name'] != '') {
					$("#user_email1").val(user_data[0]['user_name']);

				}
				if (user_data[0]['password'] != null && user_data[0]['password'] != '') {
					$("#password1").val(user_data[0]['password']);

				}
			} else {
				$("#permission-tab2").hide();
				$("#permission-tab1").show();
				$('#normalUser').addClass("show active");
				$('#otheruser').removeClass("show active");
				if (user_data[0]['id'] != null && user_data[0]['id'] != '') {
					$("#forward_user").val(user_data[0]['id']);
				}
				if (user_data[0]['name'] != null && user_data[0]['name'] != '') {
					$("#user_name").val(user_data[0]['name']);
				}
				if (user_data[0]['mobile_number'] != null && user_data[0]['mobile_number'] != '') {
					$("#user_contact").val(user_data[0]['mobile_number']);
				}

				if (user_data[0]['user_type'] != null && user_data[0]['user_type'] != '') {
					let comp = user_data[0]['user_type'];
					$("#user_type option[value='" + comp + "']").prop("selected", true);
				}
				if (user_data[0]['company_id'] != null && user_data[0]['company_id'] != '') {
					let comp = user_data[0]['company_id'];

					$("#uAllCompanies option[value='" + comp + "']").prop("selected", true);
					getCompanyBranches(comp).then(response => {
						let branch = user_data[0]['branch_id'];
						$("#uAllBranches option[value='" + branch + "']").prop("selected", true);
						if (user_data[0]['udepartment'] != null && user_data[0]['udepartment'] != '') {

							let permission = user_data[0]['udepartment'].split(",");
							permission.map(dep => {
								let dep1 = dep.split("|||");
								$(`#defaultCheck${dep1[0]}`).attr("checked", "checked");
							});

						}
					})
				}
				if (user_data[0]['user_name'] != null && user_data[0]['user_name'] != '') {
					$("#user_email").val(user_data[0]['user_name']);

				}
				if (user_data[0]['password'] != null && user_data[0]['password'] != '') {
					$("#password").val(user_data[0]['password']);

				}
			}
			console.log(user_data);

			// if (user_data[0]['alldepartments'] != null && user_data[0]['alldepartments'] != '') {
			// 	$("#roleDepartment").empty();
			// 	var str = user_data[0]['alldepartments'];
			// 	var dep = str.split(",");
			// 	depChk = '<div class="form-check">'
			// 		+ ' <input class="form-check-input" type="checkbox"  onClick="checkDepartment(this)" id="defaultCheck">'
			// 		+ '  <label class="form-check-label" for="defaultCheck">'
			// 		+ '     All'
			// 		+ ' </label>'
			// 		+ ' </div>';
			// 	var dep2 = '';
			// 	if (user_data[0]['udepartment'] != null && user_data[0]['udepartment'] != '') {
			// 		var str2 = user_data[0]['udepartment'];
			// 		if (str2 != '') {
			// 			var dep2 = str2.split(",");
			// 		}
			// 	}
			//
			// 	$("#roleDepartment").append(depChk);
			// 	for (var i = 0; i < dep.length; i++) {
			//
			//
			// 		departmentCheckbox(dep[i], dep2);
			// 	}
			//
			// }
		} else {
			app.errorToast('data not found ');
		}

	}).catch(error => console.log(error));
}

function departmentCheckbox(dep, dep_data) {
	//console.log(dep_data);
	var dep1 = dep.split("|||");
	var check = '';
	if (dep_data != '') {
		for (var k = 0; k < dep_data.length; k++) {
			var dep2 = dep_data[k].split("|||");


			if (dep2[0] == dep1[0]) {
				check = "checked";
			}


		}
	}


	depChk = '<div class="form-check">'
		+ '<input class="form-check-input" name="depCheck[]" multiple type="checkbox" id="defaultCheck' + dep1[0] + '" value="' + dep1[0] + '" ' + check + '>'
		+ '<label class="form-check-label" for="defaultCheck' + dep1[0] + '">'
		+ ' ' + dep1[1] + ' '
		+ ' </label>'
		+ '</div>';

	$("#roleDepartment").append(depChk);
}

function open_access_modal(id) {
	$("#access_modal").modal('show');
	$.ajax({
		type: "POST",
		url: baseURL + "get_access_data",
		dataType: "json",
		async: false,
		cache: false,
		data: {id},
		success: function (result) {
			//console.log(result);
			if (result.status == 200) {

				var data = result.body;
				$("#per_data_div").html(data);


			} else {

			}
		}

	});
}

function save_permission() {
	var form_data = document.getElementById('accessdataform');
	var Form_data = new FormData(form_data);
	$.ajax({
		type: "POST",
		url: baseURL + 'save_permission',
		dataType: "json",
		data: Form_data,
		contentType: false,
		processData: false,
		success: function (result) {

			// app.successToast(result);

			if (result.status === 200) {

				app.successToast(result.body);

				$("#access_modal").modal('hide');
				//		loadPrescription();
			} else {
				app.errorToast(result.body);
			}
		},
		error: function (error) {
			// $.LoadingOverlay("hide");
			app.errorToast("something went wrong please try again");
		}
	});
}

function save_profile() {
	var form_data = document.getElementById('profile_form');
	var Form_data = new FormData(form_data);
	$.ajax({
		type: "POST",
		url: baseURL + 'save_profile',
		dataType: "json",
		data: Form_data,
		contentType: false,
		processData: false,
		success: function (result) {

			// app.successToast(result);

			if (result.status === 200) {

				app.successToast(result.body);
				$('#profile_form').trigger("reset");
				get_permission_div();
				$("#profile_management").modal('hide');


				//		loadPrescription();
			} else {
				app.errorToast(result.body);
			}
		},
		error: function (error) {
			// $.LoadingOverlay("hide");
			app.errorToast("something went wrong please try again");
		}
	});
}

function get_permission_div() {
	$.ajax({
		type: "POST",
		url: baseURL + "get_permission_div",
		dataType: "json",
		async: false,
		cache: false,
		success: function (result) {
			if (result.status == 200) {
				var data = result.data;
				$("#all_permission_div").html(data);
			} else {

			}
		}

	});
}

function get_user_types() {
	$.ajax({
		type: "POST",
		url: baseURL + "get_user_types",
		dataType: "json",
		async: false,
		cache: false,
		success: function (result) {
			//console.log(result);
			if (result.status == 200) {

				var data = result.data;
				$("#user_type").html(data);


			} else {

			}
		}

	});
}

function get_all_profile_data() {
	$.ajax({
		type: "POST",
		url: baseURL + "get_all_profile_data",
		dataType: "json",
		async: false,
		cache: false,
		success: function (result) {
			//console.log(result);
			if (result.status == 200) {

				var data = result.data;
				$("#table_profile").html(data);


			} else {

			}
		}

	});
}

function get_profile_edit(id) {
	let formData = new FormData();
	formData.set("id", id);
	app.request(baseURL + "get_profile_edit", formData)
		.then(result => {
			if (result.status === 200) {
				var data = result.data;
				$("#all_permission_div").html(data);
				$("#profile_name").val(result.name);
				let permission = result.roles;
				permission.map(dep => {
					if (dep[1] === 1) {
						$(`#defaultCheck${dep[0]}`).attr("checked", "checked");
					} else {
						$(`#defaultCheck${dep[0]}`).attr("checked", false);
					}

				});
			}
		}).catch(error => {

	})
}
