$(document).ready(function () {
	loadTable(null);
	get_patients();
	$('#fire-modal-pickup_download').on('show.bs.modal', function (e) {
		loadDownloadTemplate();
	});

});
let table = null;


let sampleCollection = [];

function loadTable(pickup_date) {
	let zone = $("#psampleAllPatient").val();
	let formData = new FormData();
	if(zone !==null ){
		formData.set("zone_id", zone);
	}
	app.request(baseURL + "getSampleCollectedOrder", formData).then(res => {
		table = $("#pathologyPickupTable").DataTable({
			destroy: true,
			responsive:true,
			order: [],
			paging: false,
			autoWidth: false,
			data: res.data,
			columnDefs: [{
				orderable: false,

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
						var select = $('<select><option value="">Patient name</option></select>')
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
					let index = sampleCollection.findIndex(i => i.id === this.value);
					if (index === -1)
						sampleCollection.push({id: $(this).val()});
				} else {
					let index = sampleCollection.findIndex(i => i.id === $(this).val());
					if (index !== -1)
						sampleCollection.splice(index, 1);
				}
			});
			console.log(sampleCollection);
		});

		// Handle click on checkbox to set state of "Select all" control
		$('#pathologyPickupTable tbody').on('change', 'input[type="checkbox"]', function () {
			// If checkbox is not checked
			if (!this.checked) {
				var el = $('#example-select-all').get(0);
				let index = sampleCollection.findIndex(i => i.id === this.value);
				if (index !== -1)
					sampleCollection.splice(index, 1);
				// If "Select all" control is checked and has 'indeterminate' property
				if (el && el.checked && ('indeterminate' in el)) {
					// Set visual state of "Select all" control
					// as 'indeterminate'
					el.indeterminate = true;
				}
			} else {
				let index = sampleCollection.findIndex(i => i.id === this.value);
				if (index === -1)
					sampleCollection.push({id:$(this).val()});

			}
			console.log(sampleCollection);
		});
		sampleCollection = [];
	})
}

function loadDownloadTemplate() {

	app.request(baseURL + "getSampleCollectOrder",null).then(res=>{
		$("#sampleOrderTable").DataTable({
			destroy: true,
			order: [],
			"pagingType": "simple_numbers",
			data:res.data,
			columns:[

				{data: 0},
				{data: 1},
				{
					data: 0,
					render: (d, t, r, m) => {
						return `<a href="${baseURL+"downloadSampleOrder/"+d}" class="btn btn-primary"><i class="fa fa-download"></i></a>`
					}
				},
			],
			fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				$('td:eq(4)', nRow).html(`<a href="${baseURL+"downloadSampleOrder/"+aData[0]}" class="btn btn-primary"><i class="fa fa-download"></i></a>`);
			}
		});
	})
	// app.dataTable("sampleOrderTable", {
	// 	url: baseURL + "getSampleCollectOrder"
	// }, [
	// 	{data: 2},
	// 	{data: 0},
	// 	{data: 1},
	// 	{
	// 		data: 2,
	// 		render: (d, t, r, m) => {
	// 			return `<a href="${baseURL+"downloadSampleOrder/"+d}" class="btn btn-primary"><i class="fa fa-download"></i></a>`
	// 		}
	// 	},
	// ], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
	// 	$('td:eq(4)', nRow).html(`<a href="${baseURL+"downloadSampleOrder/"+aData[2]}" class="btn btn-primary"><i class="fa fa-download"></i></a>`);
	// });
}


function saveCollection(form) {

	if (sampleCollection.length === 0) {
		app.errorToast("Please Select Samples");
	} else {
		let formData = new FormData();

		formData.set("sampleCollection", JSON.stringify(sampleCollection))
		app.request(baseURL + "saveSampleCollection", formData).then(response => {
			sampleCollection=[];
			if (response.status === 200) {
				app.successToast(response.body);
				if (response.mode === true) {
					$('#orderNumber').empty()
					$('#orderNumber').append(response.pickup_number);
					$('#orderNumberhideen').val(response.pickup_number);
					$("#dwn_file").attr("href", baseURL+"downloadSampleOrder/"+response.pickup_number);
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
	if (sampleCollection.length === 0) {
		app.errorToast("Please Select Samples");
	} else {
		var x = JSON.stringify(sampleCollection);

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


function get_patients() {
app.request(baseURL+"getServiceOrderPList",null).then(success=>{
		if (success.status == 200) {
			var user_data = success.body;
			$("#HistoryPatient").html(user_data);
		}
	});

	/* $("#HistoryPatient").select2(
		{
			ajax: {
				url: baseURL + "getServiceOrderPList",
				type: "post",
				dataType: "json",
				placeholder: "Patient Name",
				data: function (params) {
					return {
						
						searchTerm: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response.body
					};
				},
				cache: true
			},
			minimumInputLength: 3
		}
	); */
}
function load_sample_history(){
	
	var historyStatus_filter=$("#historyStatus_filter").val();
	var HistoryPatient=$("#HistoryPatient").val();
	let formData = new FormData();
	
		formData.set("historyStatus_filter", historyStatus_filter);
		formData.set("HistoryPatient", HistoryPatient);
	app.request(baseURL + "HistorySampleTableData",formData).then(res=>{
		$("#HistorySampleTable").DataTable({
			destroy: true,
			responsive: true,
			autoWidth: false,
			order: [],
			"pagingType": "simple_numbers",
			data:res.data,
			columns:[
				{data: 7},
				{data: 3},
				{data: 6},
				{data: 5},
				{data: 1},
				{data: 4},
				{data: 2}
				/* {
					data: 0,
					render: (d, t, r, m) => {
						return `<button class="btn btn-primary btn-action mr-1" type="button" onclick="getSampleHistoryData('${r[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`
					}
				}, */
			]
		/*	fnRowCallback:(nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
				$('td:eq(4)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" onclick="getSampleHistoryData('${aData[0]}')"
                                  >
                                 <i class="fas fa-eye"></i>
                            </button>`);
			} */
		});
	})
	
	
}

function getSampleHistoryData(id){
	$("#SampleHistoryItemModal").modal('show');
	$("#HistorySampleItemTable").DataTable({destroy: true});
	let formData = new FormData();
	
		formData.set("id", id);
	//HistorySampleItemTable
		app.request(baseURL + "HistorySampleItemTableData",formData).then(res=>{
		$("#HistorySampleItemTable").DataTable({
			destroy: true,
			order: [],
			"pagingType": "simple_numbers",
			data:res.data,
			columns:[

				{data: 0},
				{data: 1},
				{data: 5},
				{data: 2},
				{data: 3},
				{data: 4},
				
			],
			
		});
	})
}

function downloadSampleHistory()
{
	var historyStatus_filter=$("#historyStatus_filter").val();
	var HistoryPatient=$("#HistoryPatient").val();
	window.location.href= baseURL+"getDownloadSampleHistory/"+historyStatus_filter;
	// let formData = new FormData();
	
	// formData.set("historyStatus_filter", historyStatus_filter);
	// app.request(baseURL+"getDownloadSampleHistory",formData).then(success=>{
	// 	// if (success.status == 200) {
	// 	// 	var user_data = success.data;
	// 	// 	// $("#psampleAllPatient").html(user_data);
	// 	// }
	// });
}
