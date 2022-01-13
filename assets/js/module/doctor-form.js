$(function () {
	// this is done
	// form validation of doctor form
	validation('doctor_form', {
		name: {required: true},
			email: {
			required: true,
			email: true
		},
		contact: {required: true},
		gender: {required: true},
		'profileImage[]': {required: true},
		category: {required: true},
		education: {required: true}
	}, {
		name: {required: "Enter Name"},
		email: {required: "Enter Email",},
		contact: {required: "Enter Contact"},
		gender: {required: "Select Gender"},
		'profileImage[]': {required: "Upload Profile Image"},
		category: {required: "Select Category"},
		education: {required: "Select Education"}
	}, (form) => {

		request('save_doctor_changes', new FormData(form)).then(result => {
			if (result.status === 200) {
				successToast(result.body);
				$('#doctor_form').trigger('reset');
				setTimeout(() => location.replace(baseURL + "doctor_view"), 5000);
			} else {
				errorToast(result.body);
			}
		}).catch(error => console.log("doctor Save changes request ", error));

	})

	// fetch doctor categories details
	request('api/doctor_categories', null).then(result => {
		if (result.status === 200) {
			let selectData = JSON.parse(atob(result.body));
			selectOption('category', 'Select Category', selectData)
		} else {
			errorToast(result.body);
		}
	}).catch(error => console.log(error));

	// fetch doctor education details
	request('api/doctor_education', null).then(result => {
		if (result.status === 200) {
			let selectData = JSON.parse(atob(result.body));
			selectOption('education', 'Select Category', selectData)
		} else {
			errorToast(result.body);
		}
	}).catch(error => console.log(error));

});
