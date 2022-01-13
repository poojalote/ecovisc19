$(document).ready(function () {
	loadTable(null);
	$('#fire-modal-pickup_download').on('show.bs.modal', function (e) {
		loadDownloadTemplate();
	});

});
let table = null;


let radiologySampleCollection = [];

function loadTable(pickup_date) {
	let zone = $("#psampleAllPatient").val();
	let formData = new FormData();
	if(zone !==null ){
		formData.set("zone_id", zone);
	}
	app.request(baseURL + "getRadiologySampleCollectedOrder", formData).then(res => {
		table = $("#pathologyPickupTable").DataTable({
			destroy: true,
			order: [],
			paging: false,
			autoWidth: false,
			data: res.data,
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: 0,
				'render': function (data, type, full, meta) {
					return '<input type="checkbox" name="id[]" value="' + data + '" class="custom-control custom-checkbox">';
				}
			}],
			select: {
				style: 'os',
				selector: 'td:first-child'
			},

			fnInitComplete: function (oSetting, json) {
				this.api().columns().every(function () {
					var column = this;

					if (column[0][0] == 1) {
						var select = $('<select><option value=""></option></select>')
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
		});

		$('#example-select-all').on('click', function () {
			// Get all rows with search applied
			var rows = table.rows({'search': 'applied'}).nodes();
			// Check/uncheck checkboxes for all rows in the table

			$('input[type="checkbox"]', rows).prop('checked', this.checked);
			$('input[type="checkbox"]', rows).each(function (e) {
				if (this.checked) {
					let index = radiologySampleCollection.findIndex(i => i.id === parseInt(this.value));
					if (index === -1)
						radiologySampleCollection.push({id: parseInt($(this).val())});
				} else {
					let index = radiologySampleCollection.findIndex(i => i.id === parseInt($(this).val()));
					if (index !== -1)
						radiologySampleCollection.splice(index, 1);
				}
			});
			console.log(radiologySampleCollection);
		});

		// Handle click on checkbox to set state of "Select all" control
		$('#pathologyPickupTable tbody').on('change', 'input[type="checkbox"]', function () {
			// If checkbox is not checked
			if (!this.checked) {
				var el = $('#example-select-all').get(0);
				let index = radiologySampleCollection.findIndex(i => i.id === parseInt(this.value));
				if (index !== -1)
					radiologySampleCollection.splice(index, 1);
				// If "Select all" control is checked and has 'indeterminate' property
				if (el && el.checked && ('indeterminate' in el)) {
					// Set visual state of "Select all" control
					// as 'indeterminate'
					el.indeterminate = true;
				}
			} else {
				let index = radiologySampleCollection.findIndex(i => i.id === parseInt(this.value));
				if (index === -1)
					radiologySampleCollection.push({id: parseInt($(this).val())});

			}
			console.log(radiologySampleCollection);
		});
		radiologySampleCollection = [];
	})
}

function loadDownloadTemplate() {

	app.dataTable("sampleOrderTable", {
		url: baseURL + "getSampleCollectOrder"
	}, [
		{data: 0},
		{data: 1},
		{
			data: 0,
			render: (d, t, r, m) => {
				return `<a href="${baseURL+"downloadSampleOrder/"+d}" class="btn btn-primary"><i class="fa fa-download"></i></a>`
			}
		},
	], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(4)', nRow).html(`<a href="${baseURL+"downloadSampleOrder/"+aData[0]}" class="btn btn-primary"><i class="fa fa-download"></i></a>`);
	});
}


function saveCollection(form) {

	if (radiologySampleCollection.length === 0) {
		app.errorToast("Please Select Samples");
	} else {
		let formData = new FormData();

		formData.set("radiologySampleCollection", JSON.stringify(radiologySampleCollection))
		app.request(baseURL + "saveRadiologySampleCollection", formData).then(response => {
			radiologySampleCollection=[];
			if (response.status === 200) {
				app.successToast(response.body);
				if (response.mode === true) {
					$('#orderNumber').empty()
					$('#orderNumber').append(response.pickup_number);
				}
				$("#openOrderModel").click();
				loadTable(null);
			} else {
				app.errorToast(response.body);
			}
		}).catch(error => {
			console.log(error);
			app.errorToast("something went wrong");
		});
	}
}

function download_excel() {
	if (radiologySampleCollection.length === 0) {
		app.errorToast("Please Select Samples");
	} else {
		var x = JSON.stringify(radiologySampleCollection);

		window.location.href = baseURL + "ExcelDownload?data=" + x;
	}

}

function get_zone() {
//zoneDetails

	app.request(baseURL+"getZoneData",null).then(success=>{
		if (success.status == 200) {
			var user_data = success.data;
			$("#psampleAllPatient").html(user_data);
		}
	});
}
