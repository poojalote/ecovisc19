$(document).ready(function () {
	getRadiologyTableData();
	loadReport();
	getTableData();


})

function loadReport() {

	let formData = new FormData();
	formData.set("patient_id", window.localStorage.getItem("patient_id"));
	app.request(baseURL + "getLabReport", formData).then(res => {
		$("#labReportTable").DataTable({
			destroy: true,
			order: [],
			autoWidth: false,
			responsive: true,
			data: res.data,
			fnInitComplete: function (oSetting, json) {
				this.api().columns().every(function () {
					var column = this;

					if (column[0][0] == 0 || column[0][0] == 1) {
						var select = $('<select class="form-control" style="width: 100%"><option value=""></option></select>')
							.appendTo($(column.header()).empty()).on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
								console.log(val);
								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});
						column.data().unique().sort().each(function (d, j) {
							let value = '';
							if (column[0][0] == 0) {
								value = d;
							}
							if (column[0][0] == 1) {
								value = d;
							}

							select.append('<option value="' + value + '">' + value + '</option>')
						});
					}
				});
			}
		})
	}).catch(error => console.log(error))
}

function getTableData() {
	p_id = window.localStorage.getItem("patient_id");
	$.ajax({
		type: 'POST',
		url: baseURL + "getlabreportFrequentlyUsed",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			if (success.status == 200) {
				var user_data = success.data;
				$("#getTableDataDiv").html(user_data);
//console.log(success.body);
			} else {

			}

		}

	});
}

function getRadiologyTableData() {
	p_id = window.localStorage.getItem("patient_id");
	$.ajax({
		type: 'POST',
		url: baseURL + "getRadiologyData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			if (success.status == 200) {

				$("#getRadioLogyDiv").html(user_data);
				$("#rad_table").dataTable();
//console.log(success.body);
			} else {
				$("#getRadioLogyDiv").html(user_data);
				$("#rad_table").dataTable();
			}

		}

	});
}


function getPathologyTableData() {
	p_id = window.localStorage.getItem("patient_id");
	$.ajax({
		type: 'POST',
		url: baseURL + "getPathologyTableData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			if (success.status == 200) {

				$("#getPathoLogyDiv").html(user_data);
				$("#path_table").dataTable();
//console.log(success.body);
			} else {
				$("#getPathoLogyDiv").html(user_data);
				$("#path_table").dataTable();
			}

		}

	});
}

function getOtherServiceTableData() {
	p_id = window.localStorage.getItem("patient_id");
	$.ajax({
		type: 'POST',
		url: baseURL + "getOtherServiceTableData",
		data: {p_id},
		success: function (success) {
			success = JSON.parse(success);
			var user_data = success.data;
			if (success.status == 200) {

				$("#getOtherServiceDiv").html(user_data);
				$("#otherservice_table").dataTable();
//console.log(success.body);
			} else {
				$("#getOtherServiceDiv").html(user_data);
				$("#otherservice_table").dataTable();
			}

		}

	});
}

function radiologyDownloadButtons(download_data) {
	let samples = download_data.split(',');
	var filedata = [];
	var interval = samples.length;
	if (samples.length > 0) {
		for (var i = 0; samples.length > 0; i++) {
			// filedata.push(samples[i]);
			if (i >= samples.length) {
				break;
			}
			var a = document.createElement("a");
			a.setAttribute('href', baseURL + samples[i]);
			a.setAttribute('download', '');
			a.setAttribute('target', '_blank');
			a.click();

		}

		// console.log(filedata);
	}

}


function getLabReportOrderTestData() {
	$("#getLabReportGraphic").empty();
	let formData = new FormData();
	formData.set("patient_id", window.localStorage.getItem("patient_id"));
	app.request(baseURL + "getLabReportOrderTestData", formData).then(res => {
		var user_data = res.data;
		if (res.status == 200) {

			$("#orderTestGraphicOpt").html(user_data);
			$("#orderTestGraphicOpt").select2();

		} else {
			// $("#getRadiologyDataogyDiv").html(user_data);
			// $("#rad_table").dataTable();
		}
	}).catch(error => console.log(error));
}

let labelsCollection = null;
let record = null;
const trans = [];

function getOrderTestParaGraph(order_test) {
	$("#getLabReportGraphic").empty();
	let formData = new FormData();
	formData.set("order_test", order_test);
	formData.set("patient_id", window.localStorage.getItem("patient_id"));
	app.request(baseURL + "getLabReportOrderTestParaData", formData).then(res => {
		var user_data = res.data;
		if (res.status == 200) {

			labelsCollection = res.label;
			record = res.data;
			trans.push(res.trans);

			const transDate = trans;
			labelsCollection.map(l => {
				loadGraph(record, l, transDate);
				return;
			})
		} else {
			// $("#getRadiologyDataogyDiv").html(user_data);
			// $("#rad_table").dataTable();
		}
	}).catch(error => console.log(error));
}

function getRandomColor() {
	var letters = '0123456789ABCDEF';
	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += letters[Math.floor(Math.random() * 16)];
	}
	return color;
}

function loadGraph(records, lable, transDate) {
	// console.log(transDate);
	const labelsValues = transDate[lable];
	let color = getRandomColor();
	const historyDataSets = [{
		label: lable,
		data: records[lable],
		borderColor: color,
		backgroundColor: color,
		tension: 0.1
	}];

	const data = {
		labels: labelsValues,
		datasets: historyDataSets
	};
	const config = {
		type: 'line',
		data: data,
		options: {
			responsive: true,
			plugins: {
				legend: {
					position: 'top',
				},
				title: {
					display: true
				}
			}
		},
	};


	$(`#getLabReportGraphic`).append(`<div class="col-md-4"><canvas id="chat_section_${lable}" style="width: 100%;height: 200px"></canvas></div>`);
	var ctx = document.getElementById(`chat_section_${lable}`)
	new Chart(ctx, config);
}

function UpdatePathologyFile(id, p_id) {
	$("#ListPathologyServicesModal").modal('show');
	$("#service_Path_file").val('');
	var forminputs = `<input type="hidden" id="pathology_id" name="pathology_id" value="${id}">
					<input type="hidden" id="patient_id" name="patient_id" value="${p_id}">`;
	$("#PathologyServiceList").append(forminputs);
}


$("#PathologyFileUploadationForm").validate({
	rules: {
		service_file: {
			required: true,
		},

	},
	messages: {
		service_file: {
			required: "Please Select File"
		},

	},
	errorElement: 'span',
	submitHandler: function (form) {
		var file = document.getElementById("service_Path_file");
		if (file.files.length == 0) {
			$("#radiology_diles_error").html("Please Select File");
		} else {
			var formData = new FormData(form);
			SavePathologyProgress(formData);
		}

	}
});

function SavePathologyProgress(formData) {
	app.request(baseURL + "updateserviceOrderBillingInfo", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			$("#ListPathologyServicesModal").modal('hide');
			getPathologyTableData();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => console.log(error));
}

