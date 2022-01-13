$(function () {


	dataTable('doctor_details_view', {url: 'get_doctors'}, (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(0)', nRow).html(`<img alt="image" src="${aData[0]}" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="${aData[1]}">`);
		$('td:eq(6)', nRow).html(`<a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a>
									   <a class="btn btn-danger btn-action" 
									   data-toggle="tooltip" title="" 
									   data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
									    data-confirm-yes="deleteDoctor(${aData[6]})" 
									    data-original-title="Delete">
									   <i class="fas fa-trash"></i></a>`)

	}, (settings, json) => {
		confirmationBox();
	});


});

function deleteDoctor(id) {
	console.log('Doctor delete id : ', id);
}
