function checkLogin(form) {
	app.request(baseURL + "login", new FormData(form)).then(success => {
		if (success.status === 200) {
			let userData = success.data;
			console.log(baseURL);
			app.successToast(success.body);
			if (parseInt(userData.roles) === 1) {

				window.location.href = baseURL + "admin/dashboard";
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
					else{
						window.location.href = baseURL + "view_radiologypickup";
					}
					
				}
			}
		} else {
			app.errorToast(success.body);
		}

	}).catch(error => console.log(error));
}
