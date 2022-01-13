$(document).ready(function () {
	getAllTablesFromDatabase();
});
function getNewRow()
{
	var count=$("#rowCount").val();
	var counter=(count*1)+1;
	var datatatype_options=getAllColumnDatatatype();
	var html=`<tr id="tr${counter}">
				<td><input type="text" class="form-control" name="c_name[]" id="c_name${counter}"></td>
			  	<td><select class="form-control" name="c_type[]" id="c_type${counter}">
			  	${datatatype_options}</select></td>
			  	<td><input type="number" class="form-control" name="c_length[]" id="c_length${counter}"></td>
			  	<td><input type="checkbox" class="" name="c_notnull[]" id="c_notnull${counter}"></td>
			 	<td><input type="checkbox" class="" name="c_autoincrement[]" id="c_autoincrement${counter}"></td>
			  	<td><select class="form-control" name="c_index" id="c_index${counter}">
			  	<option value=""></option>
			  	<option value="PRIMARY">PRIMARY</option>
			  	<option value="UNIQUE">UNIQUE</option>
			  	<option value="INDEX">INDEX</option>
			  	</select></td>
			  	<td><input type="text" class="form-control" name="c_default" id="c_default${counter}"></td>
			  	<td><button type="button" class="btn btn-primary" id="c_remove${counter}" onclick="removeTableRow(${counter})"><i class="fa fa-trash"></i></button></td>
			  </tr>`;
	$("#tableRow").append(html);
	var cnt=counter++;
	$("#rowCount").val(cnt);

}
function getAllColumnDatatatype()
{
	var option=``;
	let datatype_array=['varchar','bigint','longtext','datetime','int','tinyint',
	'decimal','double','date','text','mediumtext','timestamp','mediumblob','smallint','enum',
	'time','char','blob','set','longblob','float'];
	for(var i=0;i<datatype_array.length;i++)
	{
		option+=`<option value="${datatype_array[i]}">${datatype_array[i]}</option>`;
	}
	return option;
}
function removeTableRow(counter)
{
	var count=$("#rowCount").val();
	console.log(count);
	$("#tr"+counter).remove();
	for(var i=counter;i<count;i++){
		var j=i+1;
		var c_name="c_name"+i;
		var c_type="c_type"+i;
		var c_length="c_length"+i;
		var c_notnull="c_notnull"+i;
		var c_autoincrement="c_autoincrement"+i;
		var c_index="c_index"+i;
		var c_default="c_default"+i;
		var c_remove="c_remove"+i;
		document.getElementById("c_name"+j).id = c_name;
		document.getElementById("c_type"+j).id = c_type;
		document.getElementById("c_length"+j).id = c_length;
		document.getElementById("c_notnull"+j).id = c_notnull;
		document.getElementById("c_autoincrement"+j).id = c_autoincrement;
		document.getElementById("c_default"+j).id = c_default;
		document.getElementById("c_index"+j).id = c_index;
		$("#c_remove"+j).attr("onclick","removeTableRow("+i+")");
		document.getElementById("c_remove"+j).id = c_remove;
		$("#tr"+j).attr("id","tr"+i);
	}
	var k=parseInt(count)-1;
	$("#rowCount").val(k);
}
function getAllTablesFromDatabase()
{
		app.dataTable('databaseTable', {
		url: baseURL + 'getAllTablesFromDatabase',
	}, [
		{data: 0},
		{
			data: 0,
			render: (d, t, r, m) => {
				return `<button class="btn btn-primary btn-action mr-1" type="button" data-target="#databaseCreationModal" data-toggle="modal"
				data-name="${d}" onclick="getDatabaseTableCategories('${d}')"> <i class="fas fa-eye"></i> </button>`;
			}
		}], (nRow, aData, iDisplayIndex, iDisplayIndexFull) => {
		$('td:eq(1)', nRow).html(`<button class="btn btn-primary btn-action mr-1" type="button" data-target="#databaseCreationModal" data-toggle="modal"
				data-name="${aData[0]}" onclick="getDatabaseTableCategories('${aData[0]}')"> <i class="fas fa-eye"></i> </button>`);

	})
}

function getDatabaseTableCategories(table_name)
{
	let formData = new FormData();
	formData.set("table_name", table_name);
	app.request(baseURL + "getDatabaseTableCategories", formData).then(result => {
		if (result.status === 200) {
			// app.successToast(result.body);
			$("#databaseTableColumnsDetails").html(result.data);
			// getPrescriptionTable('prescriptionMasterTable');
		} else {
			app.errorToast(result.body);
		}
	})
}
function saveDatabaseTableCreation(){
	$.ajax({
		type: "POST",
		url: baseURL+"saveDatabaseTableCreation",
		dataType: "json",
		data:$('#newTableCreateForm').serialize(),
		success: function (result) {
			if(result.status==200){
				app.successToast(result.body);
				setTimeout(function(){  
				window.location.href=baseURL+"table_creation";
				}, 3000);
			}else{
				app.errorToast(result.body);
			}

		}, error: function (error) {
			app.errorToast('Something went wrong please try again');
		}
	});
}