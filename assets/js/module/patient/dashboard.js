$(document).ready(function () {

	localStorage.getItem("patient_id");
	// document.getElementById("patient_name").innerText=localStorage.getItem("patient_name");
	// document.getElementById("patient_aadhar_number").innerText=localStorage.getItem("patient_adharnumber");
	// document.getElementById("patient_contact").innerText=localStorage.getItem("patient_contact");

	document.getElementById("patient_nameSidebar").innerText=localStorage.getItem("patient_name");
	document.getElementById("patient_adharSidebar").innerText= localStorage.getItem("patient_adharnumber");
	if(localStorage.getItem("patient_profile")!=="" && localStorage.getItem("patient_profile") !=="null"){
		document.getElementById("patient_profile").setAttribute("src",localStorage.getItem("patient_profile"));
	}
	get_PatientDataById(localStorage.getItem("patient_id"));
	check_billing_status();

});
