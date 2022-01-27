function checkLogin1(form) {
	app.request(baseURL + "login", new FormData(form)).then(success => {
		if (success.status === 200) {
			let userData = success.data;
			console.log(baseURL);
			app.successToast(success.body);
			if (parseInt(userData.roles) === 1) {

				window.location.href = baseURL + "admin/dashboard";
			} else if(parseInt(userData.roles) === 6){
				window.location.href = baseURL + "labMasterAdmin";
			} else {
				if(parseInt(userData.roles) === 2) {
					 if (parseInt(userData.user_type) === 5) {
						window.location.href = baseURL + "hospitalMedicine";
						// window.location.href = baseURL + "pharmeasy";
					} else {
						if (parseInt(userData.default_access) !== 2) {
						window.location.href = baseURL + "patient_info";
						}else{
						window.location.href = baseURL + "icubedManagement";
						}
					}
				}else if(parseInt(userData.roles) === 5){
					window.location.href = baseURL + "security";
				}else{

					if (parseInt(userData.user_type) === 4) {
						window.location.href = baseURL + "pharmeasy";
						// window.location.href = baseURL + "hospitalMedicine";
					} else if (parseInt(userData.user_type) === 6) {
						window.location.href = baseURL + "view_pickup";
						// window.location.href = baseURL + "pharmeasy";
					}
					else if (parseInt(userData.user_type) === 12) {
						window.location.href = baseURL + "labpatient_info";
					}
					else if (parseInt(userData.user_type) === 7) {
						window.location.href = baseURL + "view_radiologypickup";
					}else{
						window.location.href = baseURL + "patient_info";
					}

				}
			}
		} else {
			app.errorToast(success.body);
		}

	}).catch(error => console.log(error));
}

$(document).ready(function () {
	var value = localStorage.getItem('device_id');
	if (value == null || value ==='null') {
		$('#isToken').val(0);
	} else {
		$('#isToken').val(1);
	}
});


let userData = [];

function checkLogin(form) {
	var formdata = new FormData(form);
	var device_data = localStorage.getItem('device_id');
	var logged_users = localStorage.getItem('logged_users');
	formdata.set('device', device_data);
	formdata.set('log_users',logged_users);
	app.request(baseURL + "login", formdata).then(success => {
		$('#redirectTo').val("");
		if (success.status === 200) {
			userData = success.data;
			console.log(baseURL);
			// app.successToast(success.body);
			let mobile = userData.mobile_number;
			if (mobile === null || mobile === "") {
				$('#redirectTo').val(1);
				$('#Mobileupdate').modal('show');
				app.formValidation();
			} else {
				redirect(1);
			}
		} else if (success.status === 301) {
			let mobile = success.mobile;
			if (mobile === null || mobile === "") {
				$('#redirectTo').val(2);
				$('#Mobileupdate').modal('show');
				app.formValidation();
			}
			else {
				redirect(2);
			}
		} else {
			app.errorToast(success.body);
		}
	}).catch(error => console.log(error));
}

function insertMobile() {
	var mobile = $('#mobile_number').val();
	var formdata = new FormData();
	formdata.set('mobile_number',mobile);
	app.request(baseURL + "updateMobile", formdata).then(success => {
		if (success.status === 200) {
			var redirect_val = $('#redirectTo').val();
			if(redirect_val === '1'){
				redirect(1);
			}
			else{
				redirect(2);
			}
		} else {
			app.errorToast(success.body);
		}
	}).catch(error => console.log(error));
}

function redirect(type) {
	if (type === 1) {
		if (parseInt(userData.roles) === 1) {
			window.location.href = baseURL + "admin/dashboard";
		} else if(parseInt(userData.roles) === 6){
			window.location.href = baseURL + "labMasterAdmin";
		} else {
			if (parseInt(userData.roles) === 2) {
				if (parseInt(userData.user_type) === 5) {
					window.location.href = baseURL + "hospitalMedicine";
					// window.location.href = baseURL + "pharmeasy";
				} else {
					if (parseInt(userData.default_access) !== 2) {
						window.location.href = baseURL + "patient_info";
					} else {
						window.location.href = baseURL + "icubedManagement";
					}
				}
			}else if(parseInt(userData.roles) === 5){
				window.location.href = baseURL + "security";
			} else {
				if (parseInt(userData.user_type) === 4) {
					window.location.href = baseURL + "pharmeasy";
					// window.location.href = baseURL + "hospitalMedicine";
				} else if (parseInt(userData.user_type) === 6) {
					window.location.href = baseURL + "view_pickup";
					// window.location.href = baseURL + "pharmeasy";
				} else if (parseInt(userData.user_type) === 12) {
					window.location.href = baseURL + "labpatient_info";
				} else {
					window.location.href = baseURL + "view_radiologypickup";
				}
			}
		}
	} else {
		window.location.href = baseURL + "otp";
	}
}
