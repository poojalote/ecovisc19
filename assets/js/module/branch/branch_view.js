$(document).ready(function () {
	loadCompanies();
	$('#fire-modal-company').on('show.bs.modal', function (e) {

		document.getElementById('uploadCompany').reset()
		getAllCompanies();
		var id = parseInt($(e.relatedTarget).data('id'));
		$('#forward_company').val('');
		$('#company_name').val('');
		if (id !== 0) {
			$('#forward_company').val(id);
			get_CompanyDataById(id);

		}
	});

});

function getAllCompanies() {
	app.request(baseURL + "fetchAllCompanies", null).then(result => {
		if (result.status === 200) {
			// modal select element

			$("#dcompany_id").empty();
			$("#dcompany_id").append(result.option);
		} else {
			// modal select element
			$("#dcompany_id").empty();
			$("#dcompany_id").append('<option>No data Found</option>');
		}
	}).catch(error => console.log(error));

}
function serverRequest(requestURL, dataObject) {

	return new Promise((resolve, reject) => {
		$.ajax({
			type: "POST",
			url: baseURL + requestURL,
			dataType: "json",
			data: dataObject,
			success: function (result) {
				resolve(result);
			}, error: function (error) {
				console.log("Error in Server Request Function : ", error);
				reject('Something went wrong please try again');

			}
		});
	});
}

function loadCompanies(type = 1, companyId = null) {

	app.dataTable("companyTable", {
		url: baseURL + "fetchBranch",
		data: {
			type: type, companyId: companyId
		}
	}, undefined, (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {

		let status = parseInt(aData[1]);
		let value;
		if (status === 1) {
			value = `<div class="badge badge-pill badge-success ml-2" onclick="ChangeCompanyStatus(${aData[4]},0)" style="cursor: pointer">Active</div>`;
		} else {
			value = `<div class="badge badge-pill badge-danger ml-2" onclick="ChangeCompanyStatus(${aData[4]},1)" style="cursor: pointer">Inactive</div>`;
		}
		$('td:eq(1)', nRow).html(value);
		$('td:eq(2)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button"                                         
                                         data-toggle="modal" data-target="#fire-modal-company" data-id="${aData[4]}"
                                  >
                                 <i class="fas fa-pen"></i>
                            </button>
                            `);
	});
}


function ChangeCompanyStatus(companyId, status) {
	serverRequest(baseURL + "changeBranchStatus", {companyId: companyId, status: status}).then(success => {
		if (success.status === 200) {

			app.successToast(success.body);
			loadCompanies();

		} else {
			app.errorToast(success.body);

		}
	}).catch(error => console.log(error));
}

function companyModalName() {
	$("#companyFormButton").click();
}
// call this function by validator
function saveCompany(form) {
	$.LoadingOverlay("show");
	app.request(baseURL + 'uploadBranch', new FormData(form)).then(result => {
		$.LoadingOverlay("hide");
		if (result.status === 200) {
			app.successToast(result.data);
			$("#companyFormButton").click();
			loadCompanies();
			companyModalName();
		} else {
			app.errorToast(result.data);
		}
	}).catch(error => {
		console.log(error);
		$.LoadingOverlay("hide");
		app.errorToast("something went wrong please try again");
	})
}


function get_CompanyDataById(companyId) {
	$.LoadingOverlay("show");
	serverRequest("getBranchDataById", {companyId: companyId}).then(response => {
		$.LoadingOverlay("hide");
		if (response.status === 200) {
			var user_data = response.body;
			if (user_data[0]['name'] != null && user_data[0]['name'] != '') {
				$("#company_name").val(user_data[0]['name']);
			}
			if(user_data[0]['company_id']!=null&& user_data[0]['company_id'] != '' ){
				let comp = user_data[0]['company_id'];
				$("#dcompany_id option[value='" + comp + "']").prop("selected", true);
			}
			if (user_data[0]['id'] != null && user_data[0]['id'] != '') {
				$("#forward_company").val(user_data[0]['id']);
			}
		} else {
			app.errorToast('data not found ');
		}
	}).catch(error => console.log(error));
}

function deleteCompany(companyId) {
	$.LoadingOverlay("show");
	serverRequest("deleteBranch", {companyId: companyId}).then(response => {
		$.LoadingOverlay("hide");
		if (response.status === 200) {
			app.successToast(response.body);
			loadCompanies();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

