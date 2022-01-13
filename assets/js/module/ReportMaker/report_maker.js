var clone, before, parent;
let sortList;
$(document).ready(function () {

	fetchReport();
	GetallTable1();
	getQueryStringPara();
	// $('#editor').trumbowyg({
	// 	 btnsDef: {
	//         // Create a new dropdown
	//         image: {
	//             dropdown: ['insertImage', 'upload', 'base64'],
	//             ico: 'insertImage'
	//         }
	//     },
	// 	btns: [
	// 		['viewHTML'],
	// 		['undo', 'redo'],
	// 		['formatting'],
	// 		['strong', 'em', 'del'],
	// 		['fontfamily'],
	// 		['btnGrp-semantic'],
	// 		['superscript', 'subscript'],
	// 		['link'],
	// 		['image'],
	// 		['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
	// 		['unorderedList', 'orderedList'],
	// 		['btnGrp-lists'],
	// 		['foreColor', 'backColor'], // this isnt working right now
	// 		['horizontalRule'],
	// 		['removeformat'],
	// 		['fullscreen'],
	// 		['fontsize'],
	// 		['table'],

	// 	],
	// 	plugins: {
	// 		fontsize: {
	// 			sizeList: [
	// 				'12px',
	// 				'14px',
	// 				'18px',
	// 				'22px'
	// 			],
	// 			allowCustomSize: false
	// 		},
	// 			 allowTagsFromPaste: {
	//             allowedTags: ['h4', 'p', 'br','div']
	//         },
	//         resizimg: {
	//             minSize: 64,
	//             step: 16,
	//         },
	//          // Add imagur parameters to upload plugin for demo purposes
	//         upload: {
	//             serverPath: baseURL+'uploadTrumbowygImage',
	//             fileFieldName: 'image[]',
	//             urlPropertyName: 'data.link'
	//         }
	// 	},
	// 	semantic:  {
	//         'div': 'div', 
	//         'lable':'lable'
	//     },
	//     hideButtonTexts: true,
	//     imageWidthModalEdit: true,
	//     urlProtocol: true
	// });



	$('#dropBox').click(function(e){

		var id=e.target;


		e.target.focus();

		if(e.target.id!="dropBox"){
			if(id.getAttribute('data-type')){

				var data_t=id.getAttribute('data-type');
				console.log(data_t);
				// 
				var ele_id=e.target.id;
				var status=0;
				if(data_t=='3' || data_t=='1'){
					status=1;
				}
				var deleteDiv=`<div class="removeDeleteButton" style="top:0;right:0;position:absolute;font-size:12px;cursor:pointer;" onclick="deleteFormElementTags('${ele_id}',${data_t},${status})"><i class="fa fa-trash"></i></div>`;

				if(previousSelectedElement !=null){
					previousSelectedElement.classList.remove('Border_div');


// 				// previousSelectedElement=previousSelectedElement.removeChild(deleteDiv);
// 				// console.log(previousSelectedElement.firstChild);
// 				// if(id.getAttribute('data-type')=="21" || id.getAttribute('data-type')=="22")
// 				// {
					if(previousSelectedElement.hasChildNodes()){
						// console.log(previousSelectedElement.getElementsByClassName('removeDeleteButton'));
						// previousSelectedElement=previousSelectedElement.removeChild(previousSelectedElement.getElementsByClassName('removeDeleteButton'));
						for (var i = 0; i < previousSelectedElement.childNodes.length; i++) {
							if (previousSelectedElement.childNodes[i].className == "removeDeleteButton") {
								previousSelectedElement.childNodes[i].remove();
							}
						}
					}
// 				// }
				}
				previousSelectedElement = id;
				if(id.getAttribute('data-type')=="3" || id.getAttribute('data-type')=="4" || id.getAttribute('data-type')=="5"
					|| id.getAttribute('data-type')=="6")
				{
					setCursor(e.target.id);

				}
				if(id.getAttribute('data-type')=="2" || id.getAttribute('data-type')=="2")
				{
					getDivMenuFunction(e.target);

				}
				$("#"+e.target.id).append(deleteDiv);
				// e.target.innerHTML=e.target.innerHTML+deleteDiv;
				id.classList.add('Border_div');
// 			// id.setAttribute("draggable", true);
// 			// id.setAttribute("droppable", true);
// 			// id.setAttribute("resizable", true);
// 			// id.classList.add('div_drag');	
// 			// $( ".div_drag" ).draggable({containment: "parent"});
// 			// 	 $( ".div_drag" ).resizable({containment: "parent",
// 			// 	 minHeight: '100%'
// 			// 	});

// 			// console.log(e.target.innerHTML);
			}
		}
	});

})

let previousSelectedElement = null;
function setCursor(editableId) {
	var pos=0;
	var tag = document.getElementById(editableId);
	let l=tag.textContent.length;
	// Creates range object
	var setpos = document.createRange();

	// Creates object for selection
	var set = window.getSelection();

	// Set start position of range
	console.log(tag);
	if(tag.childNodes){
		setpos.setStart(tag.childNodes[0], l-1);
	}

	// Collapse range within its boundary points
	// Returns boolean
	setpos.collapse(true);

	// Remove all ranges set
	set.removeAllRanges();

	// Add range with respect to range object.
	set.addRange(setpos);

	// Set cursor on focus
	tag.focus();
}
function getDivMenuFunction(targetEle)
{
	// console.log('in');
	// $("#textStyle").focus();
	$("#textStyle").val('');
	// console.log(targetEle.id.getAttribute('style'));
	$("#textStyle").val(targetEle.getAttribute('style'));
}

$("#textStyle").focusout(function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style=$("#textStyle").val();
	}
});
$("#inBgColor").on('change',function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style.background=$(this).val();
	}
});
$("#inBorderColor").on('change',function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style.borderColor=$(this).val();
	}
});
$("#inBorderSize").on('input',function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style.border=$(this).val();
	}
});
$("#ddBorderStyle").on('change',function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style.borderStyle=$(this).val();
	}
});
$(".inBoxShadow").on('change',function(){
	if(previousSelectedElement!=null){
		previousSelectedElement.style.boxShadow=$("#inBoxSizex").val()+" "+$("#inBoxSizey").val()+" "+$("#inBoxSizeb").val()+" "+$("#inBoxSizes").val()+" "+$("#inBoxShadowColor").val();
	}
});

function deleteFormElementTags(targetEle,type,status)
{
	// console.log(targetEle);
	let ele_id=targetEle;
	var passEle=document.getElementById(ele_id);
	var $passEle=passEle;
	// var list = passEle.getElementsByTagName('label').length;
	// console.log();
	let cntrl=0;
	if(type=='11' || type=='21' || type=='22')
	{
		var tagNamearray=['label','select','button','input'];

		for(var i=0;i<tagNamearray.length;i++)
		{
			var list = passEle.getElementsByTagName(tagNamearray[i]).length;
			// targetEle.child().length;
			// console.log(list);
			if(list>0)
			{
				if($($passEle).hasClass('spanLabel')){

				}
				else
				{
					cntrl++;
				}
			}
		}
	}
	// console.log(cnt);
	if(cntrl==0)
	{
		if(type!='11' && type!='21')
		{
			if($($passEle).hasClass('spanLabel')){
				deleteElementTags(passEle.getAttribute('data-name'));
			}
		}
		$("#"+ele_id).remove();
		previousSelectedElement=null;
	}
	else
	{
		alert('Remove Child Element First');
	}
}

function deleteElementTags(argumentId) {
	var elemntIdField="#"+argumentId;
	let elementIndex = textArray.findIndex(i => i.trim() === elemntIdField);
	// console.log(elementIndex);
	removeIndexValue(elementIndex);


	let elementDropdownIndex = dropDownArray.findIndex(i => i === elemntIdField);
	dropDownArray.splice(elementDropdownIndex, 1);
}
// sortList = $('#questionListSortable').sortable({
// 	connectWith: ".connected-sortable",
// 	tolerance: 'pointer',
// 	scroll: true,
// 	revert: true,
// 	receive: function (event, ui) {
// 		let typeElement = parseInt($(ui.item[0]).attr("data-type"));

// 		let id = Math.floor((Math.random() * 100) + 1);


// 		switch (typeElement) {
// 			case 1: // short text
// 				ui.item.replaceWith(shortText(id, 1));
// 				break;
// 			case 2: // long text
// 				ui.item.replaceWith(longText(id, 2));
// 				break;
// 			case 3: // drop down
// 				ui.item.replaceWith(dropDown(id, 3));
// 				break;
// 			case 4: // drop down
// 				ui.item.replaceWith(multipleDropDown(id, 4));
// 				break;
// 			case 5: // date element
// 				ui.item.replaceWith(dateElement(id, 5));
// 				break;
// 			case 6:
// 				ui.item.replaceWith(number(id, 6));
// 				break;
// 			case 7:
// 				ui.item.replaceWith(attachment(id, 7));
// 				break;
// 			case 8:
// 				ui.item.replaceWith(querydropdown(id, 8));
// 				break;
// 			case 9:
// 				ui.item.replaceWith(fixquerydropdown(id, 9));
// 				break;
// 			case 10:
// 				ui.item.replaceWith(fixnumber(id, 10));
// 				break;
// 			case 11:
// 				ui.item.replaceWith(label(id, 11));
// 				break;
// 			case 12:
// 				ui.item.replaceWith(checkboxGroup(id, 12));
// 				break;
// 			case 13:
// 				ui.item.replaceWith(radioGroup(id, 13));
// 				break;
// 			case 14:
// 				ui.item.replaceWith(button(id, 14));
// 				break;

// 		}

// 	},
// 	update: function (event, ui) {
// 		let typeSequence = $('#questionListSortable').sortable("toArray", {attribute: 'data-type'});
// 		let idSequence = $('#questionListSortable').sortable("toArray", {attribute: 'data-id'});
// 		$('#elementSequenceType').val(typeSequence.join())
// 		$('#elementSequenceId').val(idSequence.join())
// 	}
// }).disableSelection();

function removeIndexValue(elementIndex)
{
	if(elementIndex!=-1){
		textMainInputArray.splice(elementIndex, 1);


		let elementsText = $("#elementSequenceText").val();
		let elementTextArray = elementsText.split(",");

		elementTextArray.splice(elementIndex, 1);
		$("#elementSequenceText").val(elementTextArray.join(','));
		textArray.splice(elementIndex, 1);

		let elementsType = $("#elementSequenceType").val();
		let elementsTypeArray = elementsType.split(",");
		elementsTypeArray.splice(elementIndex, 1);
		$("#elementSequenceType").val(elementsTypeArray.join(','));
		textTypeArray.splice(elementIndex, 1);

		let elementsId = $("#elementSequenceId").val();
		let elementsIdArray = elementsId.split(",");
		elementsIdArray.splice(elementIndex, 1);
		$("#elementSequenceId").val(elementsIdArray.join(','));
		textNumberArray.splice(elementIndex, 1);
	}
}
$('#questionMasterSortable').sortable({
	connectWith: ".connected-sortable",
	helper: "clone",
	revert: true,
	start: function (event, ui) {
		$(ui.item).show();
		clone = $(ui.item).clone();
		before = $(ui.item).prev();
		parent = $(ui.item).parent();
	},

	remove: function (event, ui) {
		if (before.length)
			before.after(clone);
		else
			parent.prepend(clone);
	}
}).disableSelection();

function onHistorySetting(e) {
	if ($(e).is(":checked")) {
		$('input[type="hidden"].custom-switch-input.history').val("on")
	} else {
		$('input[type="hidden"].custom-switch-input.history').val("off")
	}

}

function loadTemplateElement(section_id, department_id) {
	let formData = new FormData();
	formData.set("department_id", department_id);
	formData.set("section_id", section_id);
	app.request(baseURL + "htmlform/fetch_section_details", formData).then(response => {
		if (response.status === 200) {
			if (response.body.length > 0) {

				let sectionDetails = response.body[0].section.split("|||");
				$('#department_id').val(department_id);
				$('#section_id').val(sectionDetails[0]);
				$("#section_name").val(sectionDetails[1]);
				let typeElementArray = [];
				let elementID = [];
				let element = response.body.map(i => {
					let id = Math.floor((Math.random() * 100) + 1);
					let typeElement = parseInt(i.ans_type);
					typeElementArray.push(typeElement);
					elementID.push(i.id);
					if (parseInt(i.is_history) === 1) {
						$('#ck_template_history').attr("checked", "checked");
					} else {
						$('#ck_template_history').attr("checked", false);
					}
					let section = i.section.split("|||");

					if (parseInt(section[2]) === 1) {
						$('#ck_template_transaction').attr("checked", "checked");

					} else {
						$('#ck_template_transaction').attr("checked", false);
					}

					let items = "";
					switch (typeElement) {
						case 1: // short text
							items = shortText(i.id, 1, i.id, i);
							break;
						case 2: // long text
							items = longText(i.id, 2, i.id, i);
							break;
						case 3: // drop down
							items = dropDown(i.id, 3, i.id, i);
							break;
						case 4: // drop down
							items = multipleDropDown(i.id, 4, i.id, i);
							break;
						case 5: // date element
							items = dateElement(i.id, 5, i.id, i);
							break;
						case 6:
							items = number(i.id, 6, i.id, i);
							break;
						case 7:
							items = attachment(i.id, 7, i.id, i);
							break;
						case 8:
							items = querydropdown(i.id, 8, i.id, i);
							break;
						case 9:
							items = fixquerydropdown(i.id, 9, i.id, i);
							break;
						case 10:
							items = fixnumber(i.id, 10, i.id, i);
							break;
						case 11:
							items = label(i.id, 11, i.id, i);
							break;
						case 12:
							items = checkboxGroup(i.id, 12, i.id, i);
							break;
						case 13:
							items = radioGroup(i.id, 13, i.id, i);
							break;
						case 14:
							items = button(i.id, 14, i.id, i);
							break;
					}
					return items;

				});
				$('#questionListSortable').empty();
				$('#questionListSortable').append(element);
				$('#elementSequenceType').val(typeElementArray.join());
				$('#elementSequenceId').val(elementID.join());
			}
		}
	})

}

function deleteReportmaker(report_id) {
	let formData = new FormData();
	formData.set("report_id", report_id)
	app.request(baseURL + "deleteReportmaker", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			fetchReport();
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => {
		console.log("deleteReportmaker : ", error), app.errorToast("Something went wrong")
	})
}

function fetchReport() {

	app.request("getReportMakers", null).then(response => {
		if (response.status === 200) {
			let sectionTemplate = ``;
			if (response.body.length > 0) {
				sectionTemplate +=`<tr>
										<td>Create New Section</td>
										<td>
											<a class="btn btn-primary btn-sm btn-action" onclick="loadNewSection()">New</a>
										</td>
									</tr>`;
				sectionTemplate += response.body.map(s => {
					return `
					<tr>
						<td>${s.Report_name}</td>
						<td class="btn-group" style="height:35px!important;">
							
							<a class="btn btn-primary btn-action" onclick="get_addedReportmakerData(${s.id})"><i
							class="fas fa-pencil-alt"></i></a>
							<a class="btn btn-danger btn-acton trigger--fire-modal-1" 
							   onclick="deleteReportmaker(${s.id})"><i class="fas fa-trash"></i></a>
							<a class="btn btn-primary btn-acton " 
							   onclick="openParameterModal(${s.id})" style="color:white;"><i class="fas fa-eye"></i></a>
						</td>
					</tr>
					`
				});

			} else {
				sectionTemplate = `
				<tr>
					<td>No Section</td>
					<td>					
					</td>
				</tr>
				`;
			}
			$("#sectionTableBody").empty();
			$("#sectionTableBody").append(sectionTemplate);
			// app.confirmationBox();
		} else {
			app.errorToast(response.body);
		}

	}).catch(error => {
		console.log("fn_fetchSection : ", error);
		app.errorToast("Something went wrong")
	})
}



function deleteElement(id, type, elementID) {
	if (elementID != null) {
		let formData = new FormData();
		formData.set("templateID", elementID);
		app.request(baseURL + "deleteTemplateElement", formData).then(response => {
			// console.log(response);
			if(response.status===200){
				app.successToast(response.body);
				deleteTemplateItems(id, type);
				let elements = $("#elementSequenceId").val();
				let elementTypes = $("#elementSequenceType").val();
				let elementArray = elements.split(",");
				let elementIndex = elementArray.findIndex(i => parseInt(i) === parseInt(elementID));
				elementArray.splice(elementIndex, 1);
				$("#elementSequenceId").val(elementArray.join(','));
				let elementTypeArray = elementTypes.split(",");
				let typeIndex = elementTypeArray.findIndex(i => parseInt(i) === parseInt(type));
				elementTypeArray.splice(elementIndex, 1);
				$("#elementSequenceType").val(elementTypeArray.join(','));
			}else{
				app.errorToast(response.body);
			}
		}).catch(error => {
			console.log(error);
		})
	} else {
		deleteTemplateItems(id, type);
	}


}

function deleteOptions(id, helmValue, value) {
	let newObjectIndex = optionsValues.findIndex(i => {
		return i.name === helmValue
	})
	if (newObjectIndex !== -1) {
		let valueIndex = optionsValues[newObjectIndex].values.findIndex(i => {
			return i === value;
		})
		if (valueIndex !== -1) {
			optionsValues[newObjectIndex].values.splice(valueIndex, 1);
			$(`#${helmValue}`).val(optionsValues[newObjectIndex].values.join())
		}
	}
	$(`#${id}`).remove();
}




function row_section(id, type, elementId, data = null)
{
	return `<div class="div_display" data-type="${type}" id="${elementId}"></div>`;
}
function div_section(id, type, elementId, data = null)
{
	return `<div class="div_display" data-type="${type}" id="${elementId}"></div>`;
}

function label(id, type, elementId = null, data = null) {
	var text=elementId;
	if(data!=null && data!="")
	{
		text=data;
	}
	return `<label id="${elementId}" data-type="${type}">&nbsp;&nbsp;&nbsp; ${text} &nbsp;&nbsp;&nbsp;</label>`;
}

function labelwithDatabase(id, type, elementId = null, data = null) {
	var text=elementId;
	if(data!=null && data!="")
	{
		text=data;
	}
	return `<label id="${elementId}" data-type="${type}">&nbsp;&nbsp;&nbsp; ${text} &nbsp;&nbsp;&nbsp;</label><label readonly contenteditable="false">&nbsp;&nbsp;#${text}</label>`;
}
function paragraph(id, type, elementId = null, data = null) {
	var text=elementId;
	if(data!=null && data!="")
	{
		text=data;
	}
	return `<p id="${elementId}" data-type="${type}">&nbsp;&nbsp;&nbsp; ${text} &nbsp;&nbsp;&nbsp;</p>`;
}
function paragraphwithdatabase(id, type, elementId = null, data = null) {
	var text=elementId;
	if(data!=null && data!="")
	{
		text=data;
	}
	return `<p id="${elementId}" readonly contenteditable="false" data-type="${type}"> #${text}</p>`;
}
function tableVertical(id, type, elementId, data = null) {
	return `#${elementId}`;
}
function tableHorizontal(id, type, elementId, data = null) {
	return `#${elementId}`;
}
let textMainInputArray=[];
let historyTableButton;
let primaryTableColumnArray=[];
let queryStringParaArray;
let requiredFieldArray=[];
let dropdownOptionsArray=[];
let querydropdownOptionsArray=[];
let textNumberArray=[];
let textTypeArray=[];
let textArray=[];
let paraGraphArray=[];
let tableDataArray;
function insertAtCaret(areaId, text,type) {

	var txtarea = document.getElementById(areaId);
	if (!txtarea) {
		return;
	}
	var textNo=Math.floor((Math.random() * 100) + 1);
	if(textNumberArray.length>0)
	{
		for(var i=0;i<textNumberArray.length;i++)
		{
			if(textTypeArray[i]==type && textNumberArray[i]==textNo)
			{
				var textNo=Math.floor((Math.random() * 100) + 1);
			}
		}
	}
	var textName=text+textNo;


	textTypeArray.push(type);
	textNumberArray.push(textNo);

	$('#elementSequenceType').val(textTypeArray.join());
	$('#elementSequenceId').val(textNumberArray.join());

	textArray.push(textName);


	$('#elementSequenceText').val(textArray.join());

	if(type==4 || type==6)
	{
		paraGraphArray.push({type:type,text:textName,table:'',field:'',where:'',rawQuery:''});
	}

	let v_data='';
	textName = textName.replace("#","");
	let items = "";
	switch (type) {

		case "1":
			items = row_section(textNo, 1, textName, v_data);
			break;
		case "2":
			items = div_section(textNo, 2, textName, v_data);
			break;
		case "3":
			items = label(textNo, 3, textName, v_data);
			break;
		case "4":
			items = labelwithDatabase(textNo, 4, textName, v_data);
			break;
		case "5":
			items = paragraph(textNo, 5, textName, v_data);
			break;
		case "6":
			items = paragraphwithdatabase(textNo, 6, textName, v_data);
			break;
		case "7":
			items = tableVertical(textNo, 7, textName, v_data);
			break;
		case "8":
			items = tableHorizontal(textNo, 8, textName, v_data);
			break;
	}
	// items = row_section(textNo, 21, textName, v_data);

	items='<div class="spanLabel" data-type="'+type+'" id="target_'+textNo+'" data-name="'+textName+'">'+items+'</div>';
// data-type="'+type+'" data-name="'+text+'"
	// if(type!=18){
	// 	$('#editor').trumbowyg('execCmd', {
	// 		cmd: 'insertHtml',
	// 		param: textName2,
	// 		forceCss: false,
	// 	});

	// }
	// $(".spanLabel").draggable();
	return items;


}

function storeColumnViewValue(value,id)
{
	$("#"+id).val(value);
	$('#primary_table').val('');
	$('#primary_table').select2({allowClear: true});
	// $('#editor').trumbowyg('html', '');
	$('#dropBox').html('');
}
function themeSelection(value,id,headColor,headText,bodyColor,bodyText)
{
	$("#"+id).val(value);
	$("#colorPicker").val(headColor);
	$("#colorHeaderTextPicker").val(headText);
	$("#colorCardBodyPicker").val(bodyColor);
	$("#colorCardBodyTextPicker").val(bodyText);
}
function loadNewSection(department_id)
{
	dropdownOptionsArray=[];
	textNumberArray=[];
	textTypeArray=[];
	textArray=[];
	dropDownArray=[];

	$("#doctor_form").trigger('reset');
	$("#section_id").val('');
	$("#elementSequenceType").val('');
	$("#elementSequenceId").val('');
	$("#questionListSortable").empty();
	// $('#editor').trumbowyg('html','');
	$('#dropBox').html('');
	$("#htmlFormModalData").empty();
	$("#edit_buttons").empty();


	document.getElementById("templateFornBtn").disabled = false;
}

function updateHistory(){
	if($('#history_unabled').is(':checked')){
		insertAtCaret('dropBox', '#datatable_button_',18);
	}
	else
	{
		let elementsType = $("#elementSequenceType").val();
		let elementsTypeArray = elementsType.split(",");
		let elementID=18;
		let elementIndex = elementsTypeArray.findIndex(i => parseInt(i) === parseInt(elementID));
		removeIndexValue(elementIndex);
	}
}

function get_addedReportmakerData(report_id)
{
	$("#htmlFormModalData").empty();

	// $('#editor').trumbowyg('html', '');
	$('#dropBox').html('');
	$("#report_id").val(report_id);
	let formData = new FormData();
	formData.set("report_id", report_id);
	app.request(baseURL + "fetch_ReportMakerHtml", formData).then(response => {
		if (response.status === 200) {
			dropdownOptionsArray=[];
			textNumberArray=[];
			textTypeArray=[];
			textArray=[];
			dropDownArray=[];
			textMainInputArray=[];
			paraGraphArray=[];
			var userdata=response.data;
			$("#report_id").val(report_id);

			// $('#editor').trumbowyg('html', userdata.raw_html);
			$('#dropBox').append(userdata.raw_html);
			$( ".div_drag" ).draggable({containment: "parent"});
			$( ".div_drag" ).resizable({containment: "parent",
				minHeight: '100%'});
			// $("#htmlFormModalData").html(userdata.section_html);
			$("#report_name").val(userdata.Report_name);
			$("#report_id").val(userdata.id);

			if(userdata.ans_type!=null)
			{
				textTypeArray=userdata.ans_type.split(',');
				$("#elementSequenceType").val(userdata.ans_type);
			}

			if(userdata.ans_type!=null)
			{
				textNumberArray=userdata.ans_type.split(',');
				$("#elementSequenceId").val(userdata.ans_type);
			}
			if(userdata.hash_keys!=null)
			{
				textArray=userdata.hash_keys.split(',');
				$("#elementSequenceText").val(userdata.hash_keys);
			}
			var str=userdata.query_param;
			var arr=str.split(",");
			$("#QueryStringParameter").select2();
			var str2=[];
			for(i=0;i<arr.length;i++){
				str2.push(arr[i]);
			}
			$("#QueryStringParameter").val(str2).trigger("change");

			var design=``;
			var typeArray=userdata.ans_type;
			var typearr = typeArray.split(",");
			var textArraystr=userdata.hash_keys;
			var textarr = textArraystr.split(",");
			if(typearr.length>0)
			{
				for(var i=0;i<typearr.length;i++)
				{
					if(typearr[i]==7)
					{

						design+=`<button type="button" class="btn btn-primary m-2" 
						onclick="getQueryModal('${userdata.id}',
						'${textarr[i]}',${typearr[i]},'${userdata.hash_keys}')">`+textarr[i]+`</button>`;
					}
					if(typearr[i]==8)
					{
						design+=`<button type="button" class="btn btn-primary m-2" 
						onclick="getQueryModal('${userdata.id}',
						'${textarr[i]}',${typearr[i]},'${userdata.hash_keys}')">`+textarr[i]+`</button>`;
						// get_queryAjax(userdata.id,userdata.department_id,textarr[i],typearr[i]);
					}


				}

			}
			$("#edit_buttons").html(design);
			if(userdata.opt!=null)
			{
				var mystr=userdata.opt;
				var myarr = mystr.split("@");
				for (var i = 0; i < myarr.length; i++) {
					var myop = myarr[i].split("||");
					if(myop.length>4)
					{
						paraGraphArray.push({type:myop[1],text:myop[0],table:myop[2],field:myop[3],where:myop[4],rawQuery:myop[5]});
					}

				}
			}


			console.log(paraGraphArray);
			// app.confirmationBox();
		} else {
			app.errorToast(response.body);
		}

	}).catch(error => {
		console.log("get_addedSectionData : ", error);
		app.errorToast("Something went wrong")
	})
}
function get_queryAjax(section_id,department_id,id,type)
{
	let formData = new FormData();
	formData.set("department_id", department_id);
	formData.set("section_id", section_id);
	formData.set("field_id", id);
	formData.set("field_type", type);
	app.request(baseURL + "htmlform/getQueryDropdownAjax", formData).then(response => {
		if (response.status === 200) {
			// app.successToast(response.body);
			// get_addedSectionData(section_id);
			// console.log(response.data);
			$("#htmlFormModalData").append(response.data);
			// app.confirmationBox();
		} else {
			// app.errorToast(response.body);
		}

	}).catch(error => {
		console.log("saveDesignWindow : ", error);
		app.errorToast("Something went wrong")
	})
}
function getDesignWindow()
{
	$("#htmlFormModalData").toggle('d-none');
	$("#htmlFormModalDatatrumbyog").toggle('d-none');
}
function saveDesignWindow()
{
	// var editor_data=$("#editor").val();
	var editor_data=$("#dropBox").html();
	var section_id=$("#htmlSectionId").val();
	let formData = new FormData();
	formData.set("editor_data", editor_data);
	formData.set("section_id", section_id);
	app.request(baseURL + "htmlform/save_template_sectionsHtml", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
			get_addedSectionData(section_id);
			// app.confirmationBox();
		} else {
			app.errorToast(response.body);
		}

	}).catch(error => {
		console.log("saveDesignWindow : ", error);
		app.errorToast("Something went wrong")
	})
}
// save form
function uploadSection(form) {
	if(paraGraphArray.length>0){
//modal open
		$("#htmlFormModalOpBtn").click();
		required_field(paraGraphArray);

	}else{
		$("#htmlFormModalOpBtn").click();
		required_field(paraGraphArray);
		// let formData = new FormData(form);
		// uploadSectionData(formData,1);
	}

}

function uploadSectionData(formData,type)
{
	// document.getElementById("templateFornBtn").disabled = true;
	app.request("save_template_sectionsHtml", formData).then(response => {
		if (response.status === 200) {
			console.log(response.body);
			app.successToast("save");
			location.reload();
			// loadNewSection(department_id);
			// document.getElementById("templateFornBtn").disabled = false;
			// fetchSection(localStorage.getItem("Department_id"));
			// get_addedSectionData(response.section_id);
			// if(type==2)
			// {
			// 	$("#htmlFormModalOpBtn").click();
			// }
		} else {
			app.errorToast(response.body);
			// document.getElementById("templateFornBtn").disabled = false;
		}
	});
}

function get_inputBoxForDropdown(dropDownArray)
{

	for(var i=0;i<dropDownArray.length;i++)
	{
		var data=dropDownArray[i].text;
		var data_id=data.split("#");
		if(dropDownArray[i].type==14)
		{
			var options=get_buttonQueryData(data_id,textArray);
		}
			// else if(dropDownArray[i].type==8)
			// {
			// 	var options=get_queryDropdownData(dropDownArray[i],textArray);
		// }
		else
		{
			var options=`<div class="row">
			<div class="title col-md-3 mt-2"> ${dropDownArray[i].text} options</div>
			<div class=" col-md-9 form-group my-0 py-0 mt-2">
				<input type="text" class="form-control" name="option_${data_id[1]}" 
				id="option_${data_id[1]}" placeholder="add options comma(,) seperated" value="${dropDownArray[i].value}"/>
			</div>
			</div>
			`;
		}

		$("#addInputHere").append(options);
	}


}
let opdata;
let hashopt;
let listColumns;
function required_field(paraGraphArray)
{
	// console.log(requiredFieldArray);
	$.LoadingOverlay('show');
	let formData = new FormData();
	formData.set("paraGraphArray",JSON.stringify(paraGraphArray));
	app.request(baseURL + "getParaghraphConfigurationData", formData).then(response => {
		$.LoadingOverlay('hide');
		if (response.status === 200) {
			$("#addInputHereRequiredHere").html(response.data);
			// get_addedSectionData(section_id);
			// app.confirmationBox();
		} else {
			app.errorToast(response.body);
		}

	}).catch(error => {
		$.LoadingOverlay('hide');
		console.log("saveDesignWindow : ", error);
		app.errorToast("Something went wrong")
	})


}
function queryTableSave(report_id,id,type,without_hash)
{
	var data=id;
	var data_id=data.split("#");
	var newElement1 = {};
	var sel_id="select_"+data_id[1];
	newElement1['id'] = data_id[1];
	newElement1['dop_id'] = sel_id;
	newElement1['type'] = type;
	var myElement = document.getElementById(sel_id);
	if(myElement!=null)
	{
		var myEleValue= document.getElementById(sel_id).value;
		if(myEleValue!="")
		{

			newElement1['table_name'] = myEleValue;
			newElement1['select_key'] = $("#key_"+data_id[1]).val();
			var where_id="wherecount_"+data_id[1];
			var whereValue= document.getElementById(where_id).value;
			let wheredataArray=[];
			if(whereValue>0)
			{

				for (var i = 1; i <= whereValue; i++) {
					var newWhereElement = {};
					var wherecol_id="column"+i+"_"+data_id[1]+"";
					var wherecol_ele=document.getElementById(wherecol_id);
					if(wherecol_ele!=null)
					{
						var wherecol_val= document.getElementById(wherecol_id).value;
						if(wherecol_val!="")
						{
							var wherepara_ele="para_value"+i+"_"+data_id[1]+"";
							var wheretext_ele="text"+i+"_"+data_id[1]+"";
							var wherepara_val= document.getElementById(wherepara_ele).value;
							var wheretext_val= document.getElementById(wheretext_ele).value;
							if (wheretext_val!="" || wherepara_val!="") {
								newWhereElement['where_col']=wherecol_val;
								if(wherepara_val!="")
								{
									newWhereElement['where_text']="#"+wherepara_val;
								}
								else
								{
									newWhereElement['where_text']=wheretext_val;
								}

								wheredataArray.push(newWhereElement);
							}
						}
					}
				}
			}
			newElement1['where_op'] = wheredataArray;
		}

	}
	// console.log(newElement);
	newElement1['raw_query'] = '';
	querydropdownOptionsArray.push(newElement1);
	// console.log(querydropdownOptionsArray);
	var tab=$("#select_"+data_id[1]).val();
	var rawq=$("#textquery_"+data_id[1]).val();
	if(tab=="" && rawq=="")
	{
		app.errorToast('add query');
	}
	else
	{
		let formData = new FormData();
		formData.set("hash_id",id);
		formData.set("report_id",report_id);
		formData.set("ans_type",type);
		formData.set("without_hash",without_hash);
		formData.set("rawq",rawq);
		formData.set("query_data",JSON.stringify(querydropdownOptionsArray));
		app.request(baseURL + "saveQueryTableData", formData).then(response => {
			if (response.status === 200) {
				app.successToast(response.body);
				$("#querydropdownOpBtn").click();
				// get_addedSectionData(section_id);
				// app.confirmationBox();
			} else {
				app.errorToast(response.body);
			}

		}).catch(error => {
			console.log("saveDesignWindow : ", error);
			app.errorToast("Something went wrong")
		});
	}
	// var form_id='tableQuery_'+without_hash;
	// var form =document.getElementById(form_id);


	// app.request(baseURL + "saveQueryTableData", formData).then(response => {
	// 	if (response.status === 200) {
	// 		app.successToast(response.body);
	// 		$("#querydropdownOpBtn").click();
	// 		// get_addedSectionData(section_id);
	// 		// app.confirmationBox();
	// 	} else {
	// 		app.errorToast(response.body);
	// 	}

	// }).catch(error => {
	// 	console.log("saveDesignWindow : ", error);
	// 	app.errorToast("Something went wrong")
	// })
}
function getChangeDate(value,id)
{
	var div_id="df_v_"+id;
	if(value==3)
	{
		document.getElementById(div_id).style.display = 'block';
	}
	else
	{
		document.getElementById(div_id).style.display = 'none';
	}
}
function getformTypeSection(value)
{
	if(value==1)
	{
		document.getElementById('TableDivDisplay').style.display = 'none';
		if($('#history_unabled').is(':checked')){
			$('#history_unabled').click();
		}
	}
	else
	{
		document.getElementById('TableDivDisplay').style.display = 'block';
		if(value==2)
		{
			if($('#history_unabled').is(':checked')){

			}
			else
			{
				$('#history_unabled').click();
			}
		}

		if(value == 3){
			if($('#history_unabled').is(':checked')){
				$('#history_unabled').click();
			}
			$("#div_dependantSection").show();
			getAllsections();
		}
	}
}

function getAllsections(){
	var department_id=$("#department_id").val();
	$.ajax({
		type: "POST",
		url: baseURL+"GetallSections",
		dataType: "json",
		data:{department_id},
		success: function (result) {

			$("#depend_section_id").html(result.data);
			// listColumns=result.data;

		}, error: function (error) {

		}
	});
}
function get_ck_required(e)
{
	if ($(e).is(":checked")) {
		$(e).val("on");
	}
	else
	{
		$(e).val("off");
	}
}

function addFormDesignOptions()
{

	let isRequiredArray=[];

	if(paraGraphArray.length>0)
	{
		for(var i=0;i<paraGraphArray.length;i++)
		{
			var para_text=paraGraphArray[i].text;
			para_text=para_text.replace('#','');
			var whereConut_ele="whereConfigCount_"+i+"_"+para_text;
			var whereConut_val=document.getElementById(whereConut_ele).value;

			let wheredataArray=[];
			if(whereConut_val>=0)
			{

				var table_para_ele="table_select_"+para_text;
				var table_para_val=document.getElementById(table_para_ele).value;
				var key_para_ele="key_"+para_text;
				var key_para_val=document.getElementById(key_para_ele).value;
				var rawQuery_ele="rawQuery_"+para_text;
				var rawQuery_val=document.getElementById(rawQuery_ele).value;
				var newElement1 = {};
				newElement1['id'] = paraGraphArray[i].text;
				newElement1['no_hashId'] = para_text;
				newElement1['ans_type'] = paraGraphArray[i].type;
				newElement1['table'] = table_para_val;
				newElement1['rawQuery'] = rawQuery_val;
				newElement1['field'] = key_para_val;

				for(var j=1;j<=whereConut_val;j++)
				{
					// console.log(j);
					var newWhereElement = {};
					var wherecol_id="wherecolumn_"+j+"_"+para_text;
					var wherecol_ele=document.getElementById(wherecol_id);


					if(wherecol_ele!=null)
					{
						// console.log($("#"+wherecol_id).val());
						var wherecol_val=document.getElementById(wherecol_id).value;
						if(wherecol_val!="")
						{

							var wherepara_ele="wherequerystring_"+j+"_"+para_text;
							var wherepara_val=document.getElementById(wherepara_ele).value;
							var wheretext_ele="wherevalue_"+j+"_"+para_text;
							var wheretext_val=document.getElementById(wheretext_ele).value;
							if (wheretext_val!="" || wherepara_val!="") {
								newWhereElement['where_col']=wherecol_val;
								if(wherepara_val!="")
								{
									newWhereElement['where_text']="#"+wherepara_val;
								}
								else
								{
									newWhereElement['where_text']=wheretext_val;
								}

								wheredataArray.push(newWhereElement);
							}
						}
					}
				}

			}
			var where_v=[];
			if(wheredataArray.length>0)
			{
				for(var m=0;m<wheredataArray.length;m++)
				{
					where_v.push(wheredataArray[m].where_col+'='+wheredataArray[m].where_text);
				}
			}
			newElement1['where'] = where_v;

			// console.log(chek_re1);

			// newElement1['where'] = where_para_val;
			isRequiredArray.push(newElement1);

		}
	}
	console.log(isRequiredArray);
	var form =document.getElementById('reportMaker_form');

	let formData = new FormData(form);

	formData.set("isRequired",JSON.stringify(isRequiredArray));

	formData.set("editor",$("#dropBox").html());
	// var circularquery=CircularJSON.stringify(querydropdownOptionsArray);
	// var circularquerystr= JSON.parse(circular);

	uploadSectionData(formData,2);

}

function get_queryDropdownData(dropdownArr_index,hashtextarray)
{
	var data=dropdownArr_index.text;
	var data_id=data.split("#");
	// console.log(data);

	opdata=getSelectTableOptions(data_id[1]);
	hashopt=getSelectHashOptions(hashtextarray);
	// console.log(opdata);
	var options=`<div class="">
			<div class="mt-2"> <strong>${dropdownArr_index.text} options</strong> 
			<a type="button" class="btn btn-link ml-2 btn_class" onclick="getHideDiv('form_through_${data_id[1]}','mormal_query_${data_id[1]}')">form through</a>
			<a type="button" class="btn btn-link ml-2 btn_class" onclick="getHideDiv('mormal_query_${data_id[1]}','form_through_${data_id[1]}',)">normal query</a>
			</div>
			<div class="mt-2" id="mormal_query_${data_id[1]}" style="display:none">
				<label>Query : </label><textarea class="form-control" name="textquery_${data_id[1]}" id="textquery_${data_id[1]}"></textarea>
			</div>
			<div class="mt-2" id="form_through_${data_id[1]}">
			<div>
				From : <select name="select_${data_id[1]}" id="select_${data_id[1]}" class="selectTable" onchange="getListOfColumns1(this.value,'tableColumns')">
				${opdata}</select>
			</div>
			<div id="dropdownQueryyData_${data_id[1]}">
			</div>
			<div class="mt-2">
				select value: <select name="key_${data_id[1]}" id="key_${data_id[1]}" class="tableColumns">
				</select>
				select name: <select name="name_${data_id[1]}" id="name_${data_id[1]}" class="tableColumns">
				</select>
			</div>
			<div class="mt-2">
				<input type="hidden" value="1" name="wherecount_${data_id[1]}" id="wherecount_${data_id[1]}" class="form-control-field">
			
				<label>where column: </label><select name="column1_${data_id[1]}" id="column1_${data_id[1]}" class="tableColumns">
				</select>
				<label>dependancy:</label> <select name="value1_${data_id[1]}" id="value1_${data_id[1]}" class="">
				${hashopt}</select> 
				<input type="text" name="text1_${data_id[1]}" id="text1_${data_id[1]}" placeholder="Enter value here" class="form-control-field" />
			</div>
			<div id="whereIds_${data_id[1]}">
			</div>
			<button type="button" name="add_where" id="add_where" onclick="getWhereColumns('${data_id[1]}','${hashtextarray}')" class="btn btn-primary">
			<i class="fa fa-plus"></i></button>
			</div>
			</div>
			<script>$("#select_${data_id[1]}").select2();
			$("#key_${data_id[1]}").select2();
			$("#name_${data_id[1]}").select2();
			$("#column1_${data_id[1]}").select2();
			$("#value1_${data_id[1]}").select2();
			</script>`;

	return options;
}
function getHideDiv(div_id1,div_id2) {
	console.log(div_id2);
	$("#"+div_id1).show();
	$("#"+div_id2).hide();
}
function GetallTable1(){


	$.ajax({
		type: "POST",
		url: baseURL+"getAllTablenames",
		dataType: "json",
		//data:{p_id},
		success: function (result) {
			tableDataArray=result.data;
			$("#primary_table").append(result.option);
			$("#primary_table").select2();
		}, error: function (error) {

		}
	});
}

function getSelectTableOptions(id=null)
{
	// console.log(tableDataArray);
	var options=``;
	if(tableDataArray.length>0)
	{
		options+=`<option value=''>Select Table</option>`;
		for (var i = 0; i < tableDataArray.length; i++) {
			// options+=`<option value='`+tableDataArray[i]+`'>`+tableDataArray[i]+`</option>`;
			options += '<option value="'+tableDataArray[i]+'">'+tableDataArray[i]+'</option>';
		}
	}
	// $("#"+id).html(options);
	return options;

}
function getSelectHashOptions(hashtextarray)
{
	var options=``;
	if(hashtextarray.length>0)
	{
		options+=`<option value=''>Select Hash Id</option>`;
		for (var i = 0; i < hashtextarray.length; i++) {
			options += '<option value="'+hashtextarray[i]+'">'+hashtextarray[i]+'</option>';
		}
	}
	// $("#"+id).html(options);
	return options;
}
function getListOfColumns1(TableName,classId){
	$.LoadingOverlay("show");
	$.ajax({
		type: "POST",
		url: baseURL+"GetAllColumns",
		dataType: "json",
		data:{TableName},
		success: function (result) {
			$.LoadingOverlay("hide");
			$("."+classId).html(result.data);
			$(".tableColumns1").html(result.data);
			// $(".tableColumns").html(result.data);
			listColumns=result.data;

		}, error: function (error) {
			$.LoadingOverlay("hide");
		}
	});
}
function getListOfColumns2(TableName,classId=null){
	$.LoadingOverlay("show");
	$.ajax({
		type: "POST",
		url: baseURL+"GetAllColumns",
		dataType: "json",
		data:{TableName},
		success: function (result) {
			$.LoadingOverlay("hide");
			$("#"+classId).html(result.data);
			// $(".tableColumns1").html(result.data);
			// $(".tableColumns").html(result.data);
			// listColumns=result.data;

		}, error: function (error) {
			$.LoadingOverlay("hide");
		}
	});
}
function getConfiWhereColumns(para_text,div_id,tableColumns,queryParamString,cont)
{
	var count=$("#whereConfigCount_"+cont+"_"+para_text).val();
	var k=parseInt(count)+1;
	// console.log(tableColumns);
	if(tableColumns=='')
	{
		table_name=$("#table_select_"+para_text).val();
		tableColumns=getListOfColumns1(table_name,'wherecolumn_'+k+'_'+para_text);
	}
	else
	{
		tableColumns=atob(tableColumns);
	}

	var data=`  
					<div class="col-md-2 form-group my-0 py-0 mt-1">
					</div>
					<div class="col-md-2 form-group my-0 py-0 mt-1">
					</div>
					<div class="col-md-2 form-group my-0 py-0 mt-1">
					</div>
					<div class="col-md-1 form-group my-0 py-0 mt-1">
					</div>
					<div class="col-md-2 form-group my-0 py-0 mt-1">
						<select name="wherecolumn_${k}_${para_text}" id="wherecolumn_${k}_${para_text}" class=" form-control tableColumns${para_text} wherecolumn_${k}_${para_text}">
						${tableColumns}
						</select>
					   </div>
					     <div class="col-md-2 form-group my-0 py-0 mt-1">
					     <select name="wherequerystring_${k}_${para_text}" id="wherequerystring_${k}_${para_text}" class=" form-control ">
						${atob(queryParamString)}
						</select>
						
					   </div>
					   <div class="col-md-1 form-group my-0 py-0 mt-1">
					   		<input type="text" name="wherevalue_${k}_${para_text}" id="wherevalue_${k}_${para_text}" class=" form-control " placeholder="Enter value here">
					   </div>
					   <script>$("#wherecolumn_${k}_${para_text}").select2();
						$("#wherequerystring_${k}_${para_text}").select2();
						</script>
			
			`;
	$("#whereConfigCount_"+cont+"_"+para_text).val(k);
	$("#"+div_id).append(data);
}
function getWhereColumns(data_id,hashoptionsArray,table_name)
{
	var count=$("#wherecount_"+data_id).val();
	var k=parseInt(count)+1;
	if(table_name=='')
	{
		table_name=$("#select_"+data_id).val();
	}
	getListOfColumns2(table_name,'column'+k+'_'+data_id);
	// console.log(hashopt);
	var data=`<div class="mt-2 row" id="div${k}_${data_id}">
				<div class="col-md-4">
				<label>where column: </label><select name="column${k}_${data_id}" id="column${k}_${data_id}" class="tableColumns1">
				</select>
				</div>
				<div class="col-md-4">
				<label>Where value: </label>
				<select name="para_value${k}_${data_id}" id="para_value${k}_${data_id}" class="form-control">
				${atob(hashoptionsArray)}
				</select>
				</div>
				<div class="col-md-3">
				<label>Where value: </label>
				<input type="text" name="text${k}_${data_id}" id="text${k}_${data_id}" placeholder="Enter value here" class="form-control">
				</div>
				<div class="col-md-1">
				<label>Remove where</label>
				<button type="button" class="btn btn-primary" id="button${k}_${data_id}" onclick="removeWhereOptions('div${k}_${data_id}','${data_id}',${k})">
				<i class="fa fa-times"></i></button>
				</div>
				<script>$("#column${k}_${data_id}").select2();
				$("#para_value${k}_${data_id}").select2();
				$("#value${k}_${data_id}").select2();</script>
			</div>
			
			`;
	$("#wherecount_"+data_id).val(k);
	$("#whereIds_"+data_id).append(data);
}
function removeWhereOptions(div_id,data_id,no)
{
	var count=$("#wherecount_"+data_id).val();
	$("#"+div_id).remove();
	for(var i=no;i<count;i++){
		var j=i+1;
		var column="column"+i+'_'+data_id;
		var value="value"+i+'_'+data_id;
		var text="text"+i+'_'+data_id;
		var button="button"+i+'_'+data_id;
		document.getElementById("column"+j+'_'+data_id).name = column;
		document.getElementById("column"+j+'_'+data_id).id = column;

		document.getElementById("text"+j+'_'+data_id).name = text;
		document.getElementById("text"+j+'_'+data_id).id = text;
		$("#button"+j+'_'+data_id).attr("onclick","removeWhereOptions('div"+i+"_"+data_id+"','"+data_id+"',"+i+")");
		document.getElementById("button"+j+'_'+data_id).id = button;
		$("#div"+j+'_'+data_id).attr("id","div"+i+"_"+data_id);
		var data=`<script>$("#column`+i+`_${data_id}").select2();
				</script>`;
		$("#whereIds_"+data_id).append(data);
	}
	var k=parseInt(count)-1;
	$("#wherecount_"+data_id).val(k);
}

function getQueryModal(report_id,id,type,textarray)
{
	let formData = new FormData();
	formData.set("report_id",report_id);
	formData.set("field_id",id);
	formData.set("field_type",type);
	formData.set("textarray",textArray);
	// formData.set("querydropDownOptions",JSON.stringify(querydropdownOptionsArray));
	app.request("getTableQueryData", formData).then(response => {
		if (response.status === 200) {
			$("#querydropdownOpBtn").click();
			$("#querydropdownOpHere").html(response.data);
		}
	});


}
function getDatatableModal(section_id,department_id,id,type,textarray)
{
	$("#datatableOpBtn").click();
	$("#datatable_section_id").val(section_id);
	$("#element_id").val(id);
	getAllTables(section_id,id);
	// loadDataTable();
	getQueryStringParaForWhere1();
	$("#queryTableSelectColumn").select2();
	$("#queryTableSearchColumn").select2();
	$("#queryTableOrderColumn").select2();
	filterCount = 0;
	filterArray = [];
	whereCount = 0;
	whereArray = [];
	actionCount = 0;
	actionArray = [];
	$("#WhereSection").empty();
	$("#filterSection").empty();
	$("#actionSection").empty();
	$("#query_master_id").val('');
	$('#queryTableSelectColumn').val('');
	$('#queryTableSelectColumn').select2({allowClear: true});
	$('#queryTableSearchColumn').val('');
	$('#queryTableSearchColumn').select2({allowClear: true});
	$('#queryTableOrderColumn').val('');
	$('#queryTableOrderColumn').select2({allowClear: true});
	$('#queryTableOrderColumnDirection').val('');
}
function getSelecteDatableData(section_id,id)
{
	let formData = new FormData();
	formData.set("section_id", section_id);
	formData.set("element_id", id);
	$("#query_master_id").val('');
	app.request(baseURL + "fetchTemplateDatatableData", formData).then(response => {
		if(response.status==200){

			var userdata=response.data;
			if(userdata!="")
			{
				$("#query_master_id").val(userdata.id);
				$("#queryTable option[value="+userdata.table_name+"]").prop("selected", true);
				$("#queryTable").select2();
				$("#filterQueryTable option[value="+userdata.table_name+"]").prop("selected", true);
				$("#filterQueryTable").select2();
				getAllColumns(userdata.table_name,type=-1,userdata);

				if(userdata.table_type!=null && userdata.table_type!="")
				{
					if(userdata.table_type==1)
					{
						$("#serverSideSync").prop("checked", true);
					}
					else
					{
						$("#clientSideSync").prop("checked", true);
					}
				}
			}
		}
		else{
			app.errorToast(response.body);
		}

	});

}
function getSelectSelectedColumn(userdata)
{
	$('#queryTableSelectColumn').val('');
	$('#queryTableSelectColumn').select2({allowClear: true});
	$('#queryTableSearchColumn').val('');
	$('#queryTableSearchColumn').select2({allowClear: true});
	$('#queryTableOrderColumn').val('');
	$('#queryTableOrderColumn').select2({allowClear: true});
	$('#queryTableOrderColumnDirection').val('');
	if(userdata.select_column!=null && userdata.select_column!="")
	{
		var select_column=userdata.select_column.split(',');
		var subqueryString="";
		for(var i=0;i<select_column.length;i++)
		{
			var string=select_column[i];

			if( string.indexOf(' as ') >= 0){
				subqueryString += string +",";

			}else{
				$("#queryTableSelectColumn option[value="+select_column[i]+"]").prop("selected", true);
			}

		}
		subqueryString=subqueryString.replace(/,+$/,'');
		$("#rawQueryTableSelectColumn").val(subqueryString);
		$("#queryTableSelectColumn").select2();
	}
	if(userdata.search_column!=null && userdata.search_column!="")
	{
		var search_column=userdata.search_column.split(',');
		subqueryStringSearch="";
		for(var i=0;i<search_column.length;i++)
		{
			var stringSelect=search_column[i];
			if( stringSelect.indexOf(' as ') >= 0){
				subqueryStringSearch += stringSelect +",";

			}else{
				$("#queryTableSearchColumn option[value="+search_column[i]+"]").prop("selected", true);
			}


		}
		subqueryStringSearch=subqueryStringSearch.replace(/,+$/,'');
		$("#rawQueryTableSearchColumn").val(subqueryStringSearch);
		$("#queryTableSearchColumn").select2();
	}
	if(userdata.order_column!=null && userdata.order_column!="")
	{
		var order_column=userdata.order_column.split(',');
		for(var i=0;i<order_column.length;i++)
		{
			$("#queryTableOrderColumn option[value="+order_column[i]+"]").prop("selected", true);

		}
		$("#queryTableOrderColumn").select2();
	}
	if(userdata.order_direction!=null && userdata.order_direction!="")
	{
		$("#queryTableOrderColumnDirection option[value="+userdata.order_direction+"]").prop("selected", true);
	}
	if(userdata.where_condition!=null && userdata.where_condition!="")
	{
		$("#WhereSection").empty();
		get_whereEditData(userdata);
	}
	if(userdata.filter_columns!=null && userdata.filter_columns!="")
	{
		$("#filterSection").empty();
		get_filterEditData(userdata);
	}
	if(userdata.action_columns!=null && userdata.action_columns!="")
	{
		$("#actionSection").empty();
		get_actionEditData(userdata);
	}

}
function get_whereEditData(userdata)
{
	if(userdata.where_condition!=null && userdata.where_condition!="")
	{	var cntr=1;
		var where_condition=userdata.where_condition.split(',');
		for(var i=0;i<where_condition.length;i++)
		{
			addWhereSection();
			var where="where"+cntr;
			where=where_condition[i].split('|');
			if(where.length>2)
			{
				var whereTableColumn=where[0].split(':');
				if(whereTableColumn.length>1){
					$("#whereTableColumn_"+cntr+" option[value="+whereTableColumn[1]+"]").prop("selected", true);
					$("#whereTableColumn_"+cntr).select2();
				}
				var whereTableValue=where[1].split(':');
				if(whereTableValue.length>2){
					$("#whereValue_"+cntr+" option[value='"+whereTableValue[1]+":"+whereTableValue[2]+"']").prop("selected", true);
					$("#whereValue_"+cntr).select2();
				}
				else if(whereTableValue.length>1)
				{
					$("#whereStaticValue_"+cntr).val(whereTableValue[1]);
				}
			}
			cntr++;
		}
	}
}
function get_filterEditData(userdata)
{
	if(userdata.filter_columns!=null && userdata.filter_columns!="")
	{
		var cnt=1;
		var filter_columns=userdata.filter_columns.split(',');
		for(var i=0;i<filter_columns.length;i++)
		{
			addFilterSection();
			var filter="filter"+cnt;
			filter=filter_columns[i].split('|');
			for(var j=0;j<filter.length;j++)
			{
				var filterTableColumn=filter[j].split(':');
				if(filterTableColumn.length>1){
					if(filterTableColumn[0]=="FilterTableColumn")
					{
						$("#filterTableColumn_"+cnt+" option[value="+filterTableColumn[1]+"]").prop("selected", true);
						$("#filterTableColumn_"+cnt).select2();
					}
					if(filterTableColumn[0]=="filterValueType")
					{
						$("#filterValueType_"+cnt+" option[value="+filterTableColumn[1]+"]").prop("selected", true);
						filterTypeSection(cnt,filterTableColumn[1]);
					}
					if(filterTableColumn[0]=="filterStaticValue")
					{
						$("#filterStaticValue_"+cnt).val(filterTableColumn[1]);
					}
					if(filterTableColumn[0]=="filterQueryTable")
					{
						$("#filterQueryTable_"+cnt+" option[value="+filterTableColumn[1]+"]").prop("selected", true);
						$("#filterQueryTable_"+cnt).select2();
						getAllColumns(filterTableColumn[1],3,filter,cnt);
					}
					if(filterTableColumn[0]=="filterQueryCondition")
					{
						$("#filterQueryCondition_"+cnt).val(filterTableColumn[1]);
					}
					if(filterTableColumn[0]=="filterStaticValue")
					{
						$("#filterStaticValue_"+cnt).val(filterTableColumn[1]);
					}

				}
			}
			cnt++;
		}

	}
}
function getSelectedFilterSelection(filterColumn,count)
{
	for(var j=0;j<filterColumn.length;j++)
	{
		var filterTableColumn=filterColumn[j].split(':');
		if(filterTableColumn.length>1){
			if(filterTableColumn[0]=="filterKeyValue")
			{
				$("#filterKeyValue_"+count+" option[value="+filterTableColumn[1]+"]").prop("selected", true);
				$("#filterKeyValue_"+count).select2();
				break;
			}
		}
	}
}

function get_actionEditData(userdata)
{
	if(userdata.action_columns!=null && userdata.action_columns!="")
	{
		var cntl=1;
		var action_columns=userdata.action_columns.split(',');
		for(var i=0;i<action_columns.length;i++)
		{
			addActionSection();
			var action="action"+cntl;
			action=action_columns[i].split('|');
			for(var j=0;j<action.length;j++)
			{
				var actionTableColumn=action[j].split(':');
				if(actionTableColumn.length>1){
					if(actionTableColumn[0]=="actionButtonPrimary")
					{
						$("#actionButtonPrimary_"+cntl+" option[value="+actionTableColumn[1]+"]").prop("selected", true);
						$("#actionButtonPrimary_"+cntl).select2();
					}
					if(actionTableColumn[0]=="actionButtonIcon")
					{
						$("#actionButtonIcon_"+cntl).val(actionTableColumn[1]);
					}
					if(actionTableColumn[0]=="actionButtonType")
					{
						$("#actionButtonType_"+cntl+" option[value="+actionTableColumn[1]+"]").prop("selected", true);
						actionTypeSection(cntl,actionTableColumn[1]);
					}
					if(actionTableColumn[0]=="actionButtonRedirectTemplate")
					{
						$("#actionButtonRedirectTemplate_"+cntl+" option[value="+actionTableColumn[1]+"]").prop("selected", true);
						$("#actionButtonRedirectTemplate_"+cntl).select2();
					}
					if(actionTableColumn[0]=="actionButtonRedirectQueryParam")
					{
						$("#actionButtonRedirectQueryParam_"+cntl).val(actionTableColumn[1]);
					}
					if(actionTableColumn[0]=="actionButtonExecutionQuery")
					{
						$("#actionButtonExecutionQuery_"+cntl).val(actionTableColumn[1]);
					}

				}
			}
			cntl++;
		}

	}
}
function getExcelPdfModal(section_id,department_id,id,type,textarray)
{
	let formData = new FormData();
	formData.set("section_id",section_id);
	formData.set("department_id",department_id);
	formData.set("id",id);
	formData.set("field_type",type);
	// formData.set("textarray",textArray);
	// formData.set("querydropDownOptions",JSON.stringify(querydropdownOptionsArray));
	app.request("Html_template/getExcelPdfData", formData).then(response => {

		$("#querydropdownOpBtn").click();
		$("#querydropdownOpHere").html(response.data);

	});
}

function saveFormData(){

	$.ajax({
		type: "POST",
		url: baseURL+"Html_template/saveFormData",
		dataType: "json",
		data:$('#query_form').serialize(),
		success: function (result) {
			if(result.status==200){
				app.successToast(result.body);
				//$('#query_form')[0].reset();
				document.getElementById("query_form").reset();//form1 is the form id.
				$("#querydropdownOpBtn").click();
				// getTableQuery();

				// toggle_div();

			}else{
				app.errorToast(result.body);
			}

		}, error: function (error) {
			app.errorToast('Something went wrong please try again');
		}
	});
}
function getDataHTML(id,section_id,type,hash_id){
	// $("#mainDashboard").hide();
	// $("#OtherDashboard").show();
	$.ajax({
		type: "POST",
		url: baseURL+"Html_template/getReportFormData",
		dataType: "json",
		data:{id:id,section_id:section_id,type:type,hash_id:hash_id},
		success: function (result) {
			$("#querydropdownOpHere").html('');
			if(result.status==200){
				$("#querydropdownOpBtn").click();
				$("#querydropdownOpHere").html(result.data);
			}else{
				$("#querydropdownOpBtn").click();
				$("#querydropdownOpHere").html(result.data);
			}

		}, error: function (error) {
			app.errorToast('Something went wrong please try again');
		}
	});
}
function DownloadData(field_id){

	var form_id='download_form_'+field_id;
	var loginForm = $('#'+form_id).serializeArray();
	// console.log(loginForm);
	var loginFormObject = {};
	$.each(loginForm,
		function(i, v) {
			loginFormObject[v.name] = v.value;
		});
	const x=JSON.stringify(loginFormObject);

	//	var x=$("#query_id").val();

	window.location.href= baseURL+"Html_template/DownloadData?formdata="+ x;
}
//DownloadNewpdf
function DownloadPDFData(field_id){

	var form_id='download_form_'+field_id;
	var loginForm = $('#'+form_id).serializeArray();
	var loginFormObject = {};
	$.each(loginForm,
		function(i, v) {
			loginFormObject[v.name] = v.value;
		});
	const x=JSON.stringify(loginFormObject);

	//	var x=$("#query_id").val();

	window.location.href= baseURL+"Html_template/DownloadNewpdf?formdata="+ x;
}

function DownloadCSVData(field_id){
	var form_id='download_form_'+field_id;
	var loginForm = $('#'+form_id).serializeArray();
	var loginFormObject = {};
	$.each(loginForm,
		function(i, v) {
			loginFormObject[v.name] = v.value;
		});
	const x=JSON.stringify(loginFormObject);

	//	var x=$("#query_id").val();

	window.location.href= baseURL+"Html_template/DownloadNewcsv?formdata="+ x;
}
function queryDropdownSave(section_id,department_id,id,type)
{
	var data=id;
	var data_id=data.split("#");
	var newElement1 = {};
	var sel_id="select_"+data_id[1];
	newElement1['id'] = data_id[1];
	newElement1['dop_id'] = sel_id;
	newElement1['type'] = type;
	var myElement = document.getElementById(sel_id);
	if(myElement!=null)
	{
		var myEleValue= document.getElementById(sel_id).value;
		if(myEleValue!="")
		{

			newElement1['table_name'] = myEleValue;
			newElement1['select_key'] = $("#key_"+data_id[1]).val();
			newElement1['select_value'] =$("#name_"+data_id[1]).val();
			newElement1['dep_column'] = $("#dep_column_"+data_id[1]).val();
			newElement1['dep_value'] =$("#dep_value_"+data_id[1]).val();
			var where_id="wherecount_"+data_id[1];
			var whereValue= document.getElementById(where_id).value;
			let wheredataArray=[];
			if(whereValue>0)
			{

				for (var i = 1; i <= whereValue; i++) {
					var newWhereElement = {};
					var wherecol_id="column"+i+"_"+data_id[1]+"";
					var wherecol_ele=document.getElementById(wherecol_id);
					if(wherecol_ele!=null)
					{
						var wherecol_val= document.getElementById(wherecol_id).value;
						if(wherecol_val!="")
						{
							var wherepara_ele="para_value"+i+"_"+data_id[1]+"";
							var wheretext_ele="text"+i+"_"+data_id[1]+"";
							var wherepara_val= document.getElementById(wherepara_ele).value;
							var wheretext_val= document.getElementById(wheretext_ele).value;
							if (wheretext_val!="" || wherepara_val!="") {
								newWhereElement['where_col']=wherecol_val;
								if(wherepara_val!="")
								{
									newWhereElement['where_text']="#"+wherepara_val;
								}
								else
								{
									newWhereElement['where_text']=wheretext_val;
								}

								wheredataArray.push(newWhereElement);
							}
						}
					}
				}
			}
			newElement1['where_op'] = wheredataArray;
		}

	}
	// console.log(newElement);
	newElement1['raw_query'] = '';
	querydropdownOptionsArray.push(newElement1);
	// console.log(querydropdownOptionsArray);
	var tab=$("#select_"+data_id[1]).val();
	var rawq=$("#textquery_"+data_id[1]).val();
	if(tab=="" && rawq=="")
	{
		app.errorToast('add query');
	}
	else
	{
		let formData = new FormData();
		formData.set("section_id",section_id);
		formData.set("department_id",department_id);
		formData.set("field_id",data_id[1]);
		formData.set("field_type",type);
		formData.set("querydropDownOptions",JSON.stringify(querydropdownOptionsArray));

		formData.set("select_key",$("#key_"+data_id[1]).val());
		formData.set("select_value",$("#name_"+data_id[1]).val());
		app.request("htmlform/save_dropdown_sectionsHtml", formData).then(response => {
			if (response.status === 200) {
				// console.log(response.body);
				// app.successToast(response.body);
				// $("#querydropdownOpHereDefault").html(response.data);
				$("#querydropdownOpBtn").click();
				document.getElementById('templateFornBtn').click();

			} else {
				app.errorToast(response.body);
				document.getElementById('templateFornBtn').click();
				// document.getElementById("templateFornBtn").disabled = false;
			}
		});
	}

}
function save_html_querydrop_default(field_id,field_type,section_id)
{
	var def_val=$("#default_query_"+field_id).val();
	if(def_val=="")
	{
		aqpp.errorToast('select default value');
	}
	else
	{	let formData = new FormData();
		formData.set("section_id",section_id);
		formData.set("department_id",$("#department_id").val());
		formData.set("field_id",field_id);
		formData.set("field_type",field_type);
		formData.set("default_val",def_val);

		app.request("htmlform/save_html_querydrop_default", formData).then(response => {
			if (response.status === 200) {
				// console.log(response.body);
				app.successToast(response.body);
				$("#querydropdownOpBtn").click();

			} else {
				app.errorToast(response.body);
				// document.getElementById("templateFornBtn").disabled = false;
			}
		});
	}
}
function getPrimaryTableData(table_name)
{
	$.ajax({
		type: "POST",
		url: baseURL+"getTableColumnsAndDatatypes",
		dataType: "json",
		data:{table_name:table_name},
		success: function (response) {
			if (response.status === 200) {
				// app.successToast(response.body);
				getPrimaryTableDataDesign(response.data);
			} else {
				app.errorToast(response.body);
			}
		}, error: function (error) {
			app.errorToast("Something went Wrong");
		}
	});
}
function getPrimaryTableDataDesign(data)
{
	var column_viewDesign=$("#column_view").val();
	let tableDesign=``;
	if (data.length > 0) {

		tableDesign +=``;
		if(column_viewDesign==1)
		{
			tableDesign += getOneColumnView(data);
		}
		else if(column_viewDesign==2)
		{
			tableDesign += getTwoColumnViewWithLabel(data);
		}
		else if(column_viewDesign==3)
		{
			tableDesign += getTwoColumnViewWithTextbox(data,3);
		}
		else if(column_viewDesign==4)
		{
			tableDesign += getTwoColumnViewWithTextbox(data,4);
		}

		var textName = getPrimaryColumnCreateField("",14,1);
		var RandomNo=Math.floor((Math.random() * 100) + 1);

		if(column_viewDesign==1)
		{
			tableDesign +=`<div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}" id="div_${RandomNo}" style="width:100%;padding:10px;">${textName.textName2}</div>`;
		}
		else if(column_viewDesign==2 || column_viewDesign==3)
		{
			tableDesign +=`<div class="row div_drag div_display" data-type="21" id="row_${RandomNo}" style="width:100%;padding:10px;" >
			<div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}1" id="div_${RandomNo}1" style="width:50%;padding:10px;"> </div>
			<div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}" id="div_${RandomNo}" style="width:50%;padding:10px;">${textName.textName2}</div>
			</div>`;
		}
		else
		{
			tableDesign +=`<div class="row div_drag div_display" data-type="21" id="row_${RandomNo}" style="width:100%;padding:10px;" >
			<div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}1" id="div_${RandomNo}1" style="width:25%;padding:10px;">
			 </div>
			 <div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}2" id="div_${RandomNo}2" style="width:25%;padding:10px;">
			 </div>
			 <div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}3" id="div_${RandomNo}3" style="width:25%;padding:10px;">
			 </div>
			<div class="div_drag div_display" data-type="22" data-name="button_${RandomNo}" id="div_${RandomNo}4" style="width:25%;padding:10px;"> 
			${textName.textName2}</div>
			</div>`;
		}

		tableDesign +=``;
		// $('#editor').trumbowyg('html', '');
		$('#dropBox').html('');
		// $('#editor').trumbowyg('execCmd', {
		// 	cmd: 'insertHtml',
		// 	param: tableDesign,
		// 	forceCss: false,
		// });
		$('#dropBox').append(tableDesign);
		$(".spanLabel").draggable();
		$( ".div_drag" ).draggable({containment: "parent"});
		$( ".div_drag" ).resizable({containment: "parent",
			minHeight: '100%'});
	}
}

let primaryTableArray=[];
function getOneColumnView(data)
{
	var tableDesign=``;
	let element = data.map((i,index) => {

		var RandomNo=Math.floor((Math.random() * 100) + 1);
		var textName = getPrimaryColumnCreateField(i['column'],i['type'],0);

		var primaryInsertvar=i['column']+':'+textName.textname;
		tableDesign +=`<div class="div_drag div_display" data-type="22" id="div_${RandomNo}1" style="width:100%;padding:10px;">${textName.columnName} ${textName.textName2}</div>`;

		primaryTableArray.push(primaryInsertvar);

		primaryTableColumnArray.push(i['column']);

	});

	$("#primaryTableInsert").val(primaryTableArray.join('|'));
	return tableDesign;
}
function getTwoColumnViewWithLabel(data)
{
	var tableDesign=``;
	let element = data.map((i,index) => {
		var RandomNo=Math.floor((Math.random() * 100) + 1);
		var textName = getPrimaryColumnCreateField(i['column'],i['type'],0);

		var primaryInsertvar=i['column']+':'+textName.textname;

		tableDesign +=`<div class="row div_drag div_display" data-type="21" id="row_${RandomNo}" style="width:100%;padding:10px;" >
					<div class="div_drag div_display" data-type="22" id="div_${RandomNo}1" style="width:50%;">${textName.columnName}</div>
					<div class="div_drag div_display" data-type="22" id="div_${RandomNo}2" style="width:50%;">${textName.textName2}</div></div>`;

		primaryTableArray.push(primaryInsertvar);

		primaryTableColumnArray.push(i['column']);

	});

	$("#primaryTableInsert").val(primaryTableArray.join('|'));
	return tableDesign;
}
function getTwoColumnViewWithTextbox(data,type)
{
	var tableDesign=``;
	let evenA=[];
	let oddA=[];
	let element = data.map((i,index) => {

		if (index % 2 === 0) {
			evenA.push(i);
		} else {
			oddA.push(i);
		}

	});

	for(var i=0;i<evenA.length;i++)
	{
		var RandomNo=Math.floor((Math.random() * 100) + 1);

		tableDesign +=`<div class="row div_drag div_display" data-type="21" id="row_${RandomNo}" style="width:100%;padding:10px;" >`;
		tableDesign +=getEvenDataValue(i,evenA,type);
		tableDesign +=getEvenDataValue(i,oddA,type);
		tableDesign +=`</div>`;
	}

	return tableDesign;
}
function getEvenDataValue(indexe,data,type)
{
	var design=``;
	if(indexe<data.length)
	{

		// let element = data.map((i,index) => {
		for (var i = 0; i < data.length; i++) {
			if(indexe==i)
			{
				// console.log(data[i].column)
				var textName = getPrimaryColumnCreateField(data[i].column,data[i].type,0);
				var primaryInsertvar=data[i].column+':'+textName.textname;
				if(type==3){
					var RandomNo=Math.floor((Math.random() * 100) + 1);
					design+=`<div class="div_drag div_display" data-type="22" id="div_${RandomNo}" style="width:50%;">
				${textName.columnName}${textName.textName2}</div>`;
				}else if(type==4){
					var RandomNo=Math.floor((Math.random() * 100) + 1);
					design+=`<div class="div_drag div_display" data-type="22" id="div_${RandomNo}" style="width:25%;">
					${textName.columnName}</div><div class="div_drag div_display" data-type="22" id="div_${RandomNo}" style="width:25%;">
					${textName.textName2}</div>`;
				}
				primaryTableArray.push(primaryInsertvar);
				primaryTableColumnArray.push(data[i].column);

				break;
			}
		}
		$("#primaryTableInsert").val(primaryTableArray.join('|'));
		// });
	}
	return design;

}
function getPrimaryColumnCreateField(column,type,buttontype)
{
	let textreturn={};
	var text='';
	if(type==6)
	{
		text="#number_";
	}
	else if(type==5)
	{
		text="#date_";
	}
	else if(type==14)
	{
		text="#button_";
	}
	else
	{
		text="#shorttext_";
	}

	var textNo=Math.floor((Math.random() * 100) + 1);
	if(textNumberArray.length>0)
	{
		for(var j=0;j<textNumberArray.length;j++)
		{
			if(textTypeArray[j]==type && textNumberArray[j]==textNo)
			{
				textNo=Math.floor((Math.random() * 100) + 1);
			}
		}
	}

	textTypeArray.push(type);
	textNumberArray.push(textNo);

	$('#elementSequenceType').val(textTypeArray.join());
	$('#elementSequenceId').val(textNumberArray.join());
	var textName=text+textNo;
	textreturn['textname']=textName;
	textArray.push(textName);
	if(type==14)
	{
		$("#primaryTableButton").val(textName);
	}
	$('#elementSequenceText').val(textArray.join());
	textName = textName.replace("#","");
	let items='';
	let v_data ='';
	if(type==6)
	{
		items = number(textNo, 6, textName, v_data);
	}
	else if(type==5)
	{
		items = dateElement(textNo, 5, textName, v_data);
	}
	else if(type==14)
	{
		items = button(textNo, 5, textName, v_data);
	}
	else
	{
		items = shortText(textNo, 1, textName,v_data);
	}
	var label_N='label'+textNo;
	let columnlabel=label(textNo, 11, label_N,column);
	var columnName='<div class="div_drag">'+columnlabel+'</div>';
	textMainInputArray.push(items);
	var textName2='<div class="spanLabel" data-type="22" id="target_'+textNo+'" data-name="'+textName+'">'+items+'</div>';
	var parser = new DOMParser();
	var doc = parser.parseFromString(textName2, 'text/html');
	var nodeCopy= doc.body.firstChild;

	nodeCopy.setAttribute("draggable", true);
	nodeCopy.setAttribute("droppable", true);
	nodeCopy.setAttribute("resizable", true);
	nodeCopy.style.overflow="hidden";
	nodeCopy.classList.add('div_drag');
	// console.log(nodeCopy);

	var $html = $(nodeCopy);
	var str = $html.prop('outerHTML');

	// console.log(str);
	textreturn['textName2']=str;
	textreturn['columnName']=columnName;
	return textreturn;

}
//-------------------------changes by pooja-----------------------------
let countInsert=1;
InsertQueryArray=[];
let newqueryData = {};

function getButtonModal(section_id,department_id,btn_id,btn_type,textarray){
	countInsert=1;
	InsertQueryArray=[];
	newqueryData = {};
	$("#htmlqueryModal").modal('show');
	getQueryStringPara2();
	var html=`<hr><div>
	<button id='insertButton' type='button' class="btn btn-link" onclick="getInsertButtonForm('${textarray}',1,'${section_id}')">Insert Query</button>
	<button id='updateButton' type='button' class="btn btn-link" onclick="getInsertButtonForm('${textarray}',2,'${section_id}')">Update Query</button>
	<button id='DeleteButton' type='button' class="btn btn-link" onclick="getInsertButtonForm('${textarray}',3),'${section_id}'">Delete Query</button>
	</div>
	<input type="hidden" id="queryString" name="queryString">
	<input type="hidden" id="queryDepartmentID" name="queryDepartmentID" value="${department_id}">
	<input type="hidden" id="querysection_id" name="querysection_id" value="${section_id}">
	<input type="hidden" id="ButtonInsertID" name="ButtonInsertID" value="${btn_id}">
	<div id="appendToThis"></div>
	`;
	$("#divAppendData").html(html);
	getButtoQueryTable(section_id,department_id,btn_id);

}

function get_buttonQueryData(data1,textarray){


	//return html;
}

function getInsertButtonForm(textarray,quertType,section_id){
	$("#querySaveBtn").show();
	if(quertType==3){
		var checkboxselectall=``;

	}else{
		var checkboxselectall=`<div class="col-md-4">
			<input type='checkbox' id="q_checkHead${countInsert}"  onclick="checkall(${countInsert})" >  Select All
			</div>`;
	}
	var html=`<input type="hidden" id="finalCount" name="finalCount" value="${countInsert}">
	<div class="row"><div class="col-md-8">
	<input type="hidden" id="queryType${countInsert}" name="queryType${countInsert}" value="${quertType}">
	<select class="form-control" onchange="getListOfColumns('${textarray}',${countInsert},${quertType},${section_id})" 
	id='optionTable_${countInsert}' name='optionTable_${countInsert}'style="border-radius: 20px;">
			</select></div>
		<div class="col-md-4">
		<input type='checkbox' id='insertIDGenerate${countInsert}' name="insertIDGenerate${countInsert}" onclick="getListOfColumns('${textarray}',${countInsert},${quertType},${section_id})" >Generate InsertId
			</div>
			${checkboxselectall}
			
			</div>
			<div id="appendColumnData_${countInsert}"></div>
			`;
	$("#appendToThis").prepend(html);
	appendTableoptions(countInsert);
	countInsert++;
	$("#finalCount").val(countInsert);
}

function appendTableoptions(count=0){
	$.ajax({
		type: "POST",
		url: baseURL+"getAllTablenames",
		dataType: "json",
		//data:{p_id},
		success: function (result) {
			if(count != 0){
				$("#optionTable_"+count).html(result.option);
			}else{
				$("#excelMappingTable").html(result.option);
			}


		}, error: function (error) {

		}
	});
}

function getListOfColumns(dataArray,count,type,section_id){
	var TableName=$("#optionTable_"+count).val();
	$("#q_checkHead"+count).prop('checked', false);
	checkall(count);
	newqueryData['TableName_'+count]=TableName;
	$("#queryString").val(JSON.stringify(newqueryData));



	$.ajax({
		type: "POST",
		url: baseURL+"GetAllColumns",
		dataType: "json",
		data:{TableName,count,dataArray,type,section_id},
		success: function (result) {

			$("#appendColumnData_"+count).html(result.data);
			var finalCount=$("#finalCount").val();
			for(var i=0;i< finalCount;i++){
				if($("#insertIDGenerate"+i).prop('checked')){
					$("option[value='#insertID"+i+"']").remove();
					$('.hashoptionclass').append(
						`<option value='#insertID${i}'>#insertID${i}</option>`);
				}else{
					$("option[value='#insertID"+i+"']").remove();
				}
			}


		}, error: function (error) {

		}
	});

}
function get_dependant_value(id)
{
	$("#txt_dependant_"+id).toggleClass("d-none")
}
function create_array(cnt1,cnt2){
	if($("#checkColumn"+cnt1+"_"+cnt2).prop('checked')){
		var data1=$("#columnName_"+cnt1+"_"+cnt2).val();
		var data2=$("#fieldName_"+cnt1+"_"+cnt2).val();
		newqueryData['otherData'+cnt1+"_"+cnt2]=data1+":"+data2;
		$("#queryString").val(JSON.stringify(newqueryData));
		console.log(newqueryData);
	}else{
		console.log('removed data');
		var k="otherData"+cnt1+"_"+cnt2;
		console.log(k);
		delete newqueryData[k];
		$("#queryString").val(JSON.stringify(newqueryData));
		console.log(newqueryData);
	}


}

function checkall(id){
	arr_length=$(".q_check"+id).length;

	if($("#q_checkHead"+id).prop('checked')){
		$(".q_check"+id).prop('checked', true);
		var cn=1;
		for(i=0;i<arr_length;i++){
			var data1=$("#columnName_"+id+"_"+cn).val();
			var data2=$("#fieldName_"+id+"_"+cn).val();
			newqueryData['otherData'+id+"_"+cn]=data1+":"+data2;
			$("#queryString").val(JSON.stringify(newqueryData));
			cn++;
		}
	}else{
		$(".q_check"+id).prop('checked', false);
		console.log(2);
		var cn=1;
		for(i=0;i<arr_length;i++){
			var k="otherData"+id+"_"+cn;
			delete newqueryData[k];
			$("#queryString").val(JSON.stringify(newqueryData));
			cn++;
		}
	}
	console.log(newqueryData);
}

function insertDataForm(btn_id,section_id){
	var form =document.getElementById('form_'+section_id);
	// var formValid = document.forms['form_'+section_id].checkValidity();
	var formValid = document.forms['form_'+section_id].reportValidity();
	/* var URL=window.location.href;
	var arr=URL.split('/');

	if(arr[6] != ''){
		var queryparameter_hidden=arr[6];
	}else{
		var queryparameter_hidden=null;
	} */
	var queryparameter_hidden=$("#queryparameter_hidden").val();
	if(formValid==true)
	{
		let formData = new FormData(form);
		formData.append("queryparameter_hidden",queryparameter_hidden)
		formData.set("btn_id",btn_id);

		app.request("InsertFordataUsingButton", formData).then(response => {
			if (response.status === 200) {
				app.successToast(response.body);
			} else {
				app.errorToast(response.body);
				// document.getElementById("templateFornBtn").disabled = false;
			}
		});
	}
}

function addQueryData(){
	var form =document.getElementById('QueryDAtaForm');
	let formData = new FormData(form);
	app.request("SaveQueryDataHTML", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.body);
		} else {
			app.errorToast(response.body);

		}
	});

}
function appendWhereHtml(count,optionT,optionfield){
	var counter1=$("#Uwherecount_"+count).val();
	console.log(counter1);
	var counter= (counter1 * 1) + 1;
	var html =`<br><div class='row'>
		   <div class='col-md-4'>
		   <select class='form-control' id='WherecolumnName_${count}_${counter}'
		   name='WherecolumnName_${count}_${counter}'>
		   ${atob(optionT)}
		   </select>
		   </div>
		   <div class='col-md-4'>
		   <select class='form-control' id='WherefieldName_${count}_${counter}' 
		   name='WherefieldName_${count}_${counter}'>
		  ${atob(optionfield)}
		   </select>
		   </div>
		    <div class='col-md-4'>
		  <input type='text' class='form-control' id='WheretextfieldName_${count}_${counter}'
		  name='WheretextfieldName_${count}_${counter}'>
		   </div>
		   </div>
		   <div id='divwhereAppend_${count}_${counter}'>
		   </div>
		   `;
	console.log(html);
	$("#divwhereAppend_"+count+"_"+counter1).html(html);
	$("#Uwherecount_"+count).val(counter);

}

function getButtoQueryTable(section_id,department_id,btn_id){
	let formData = new FormData();
	formData. append("section_id",section_id);
	formData. append("department_id",department_id);
	formData. append("btn_id",btn_id);
	app.request("SaveQueryDataHTMLTable", formData).then(response => {
		if (response.status === 200) {
			$("#tableQuery").html(response.data);
			var redirection=response.redirection;
			var arr=redirection.split("|");

			var arr2=arr[0].split(":");
			var redirection_type=arr2[1];
			$("#formActionType").val(redirection_type);
			getOtherActiondiv(redirection_type,arr);
			/* 	if(redirection_type == 1){
					var arr3=arr[1].split(":");
					$("#route1").val(arr3[1]);
					var arr4=arr[2].split(":");
					var array = arr4[1].split(',');
					$("#qeryparam1").val(array).trigger("change");
				}else if(redirection_type == 2){
					var arr3=arr[1].split(":");
					console.log(arr3);
					$("#sectionselect2").val(arr3[1]);
					var arr4=arr[2].split(":");
					var array = arr4[1].split(',');
					$("#qeryparam2").val(array).trigger("change");
				} */
		} else {
			$("#tableQuery").html(response.data);

		}
	});
}

function functionEditQuery(id){
	$("#querySaveBtn").hide();
	let formData = new FormData();
	formData. append("id",id);
	app.request("GetQueryDatatoEdit", formData).then(response => {
		if (response.status === 200) {
			$("#EditQueryDIv").html(response.data);
		} else {
			$("#EditQueryDIv").html(response.data);

		}
	});
}

function FunUpdateQueryForm(){
	//UpdateQueryForm
	var formActionType=$("#formActionType").val();
	var sectionselect2=$("#sectionselect2").val();
	var route1=$("#route1").val();
	var qeryparam1=$("#qeryparam1").val();
	var qeryparam2=$("#qeryparam2").val();
	var form =document.getElementById('UpdateQueryForm');

	let formData = new FormData(form);
	formData.append("formActionType",formActionType);
	formData.append("sectionselect2",sectionselect2);
	formData.append("route1",route1);
	formData.append("qeryparam1",qeryparam1);
	formData.append("qeryparam2",qeryparam2);
	app.request("UpdatequeryTable", formData).then(response => {
		if (response.status === 200) {
			app.successToast(response.data);
		} else {
			app.errorToast(response.data);

		}
	});
}

function openParameterModal(report_id){
	//$("#RedirctModal").modal('show');
	//$("#QS_section_id").val(section_id)
	let formData = new FormData();
	formData.append('report_id',report_id);
	app.request("GetQueryParamDataReport", formData).then(response => {
		if (response.status === 200) {
			var data=response.data;


			window.location = baseURL+"ViewReportMaker/"+report_id+"/"+(btoa(data));
			// $("#queryParamString").html(response.data);
			// $('#redirectButton').show();
		} else {
			app.errorToast(response.body);
			// $("#queryParamString").html(response.data);
			// $('#redirectButton').show();

		}
	});
}

function redirectToanotherFor(){
	var form =document.getElementById('queryForm');
	let formData = new FormData(form);
	var x = $("#queryForm").serializeArray();
	var Obj={};
	$.each(x, function(i, field) {
		Obj[field.name]=field.value;
	});
	var newOBJ=JSON.stringify(Obj);
	newOBJ=btoa(newOBJ);
	var section_id=$("#QS_section_id").val();
	var myArr = baseURL.split("/");

	window.location = "http://localhost/template_engine/html_form_view/"+section_id+"/"+newOBJ;

}

function getQueryStringPara(){
	//QueryStringParameter
	app.request("getQueryStringPara").then(response => {
		if (response.status === 200) {
			$("#QueryStringParameter").html(response.data);
			queryStringParaArray=response.data;
		} else {
			$("#QueryStringParameter").html(response.data);
			queryStringParaArray=response.data;
		}
	});
}
function getQueryStringPara2(){
	//QueryStringParameter
	app.request("getQueryStringPara2").then(response => {
		if (response.status === 200) {
			$("#qeryparam1").html(response.data);
			$("#qeryparam2").html(response.data);
		} else {
			$("#qeryparam1").html(response.data);
			$("#qeryparam2").html(response.data);
		}
	});
}
function GetAllSections(value,arr){
	//QueryStringParameter
	var department_id= $("#department_id").val();
	console.log(department_id);
	let formData = new FormData();
	formData.append('department_id',department_id);
	app.request("GetallSections",formData).then(response => {
		if (response.status === 200) {
			$("#sectionselect2").html(response.data);
			if(arr != null){
				var redirection_type=value;
				if(redirection_type == 1){
					var arr3=arr[1].split(":");
					$("#route1").val(arr3[1]);
					var arr4=arr[2].split(":");
					var array = arr4[1].split(',');
					$("#qeryparam1").val(array).trigger("change");
				}else if(redirection_type == 2){
					var arr3=arr[1].split(":");

					console.log("pooja");
					console.log(arr3);
					$("#sectionselect2").val(arr3[1]);
					var arr4=arr[2].split(":");
					var array = arr4[1].split(',');
					console.log(array);
					$("#qeryparam2").val(array).trigger("change");
				}else{

				}
			}
		} else {
			$("#sectionselect2").html(response.data);
		}
	});
}

//getCsvModal

function getOtherActiondiv(value,arr=null){

	if(value == 1){
		$("#div_first").show();
		$("#div_second").hide();
	}else if(value == 2){
		$("#div_second").show();
		$("#div_first").hide();
		GetAllSections(value,arr);
	}else{
		$("#div_first").hide();
		$("#div_second").hide();
	}
	getQueryStringPara2();

}

function getExcelTableModal(section_id,department_id,id,type,textarray){
	$("#ExcelTableButton").modal('show');
	$('#excelSectionID').val(section_id);
	$('#ExcelDeptId').val(department_id);
	$('#ExcelBtnID').val(id);
	getExcelTableView(section_id,department_id,id,type,textarray);
}
function getExcelTableView(section_id,department_id,id,type=null,textarray=null){
	let formData = new FormData();
	formData.append('section_id',section_id);
	formData.append('department_id',department_id);
	formData.append('id',id);
	formData.append('type',type);
	formData.append('textarray',textarray);
//ExcelTableConfiguaration
	app.request("getExcelTableConfiguaration",formData).then(response => {
		if (response.status === 200) {
			$("#excelDataTableView").html(response.data);
			getExcelDataBaseMapping(section_id,department_id,id);
		} else {
			$("#excelDataTableView").html(response.data);
		}
	});
}
function  getExcelDataBaseMapping(section_id,department_id,hash_key) {
//excelDataMapping
	var html='<hr><div class="row"><div class="col-md-12">' +
		'<h5>Mapping</h5></div></div>' +
		'<div class="row"><div class="col-md-12">' +
		'<label>Select Table</label>' +
		'<select class="form-control" id="excelMappingTable" onchange="getAllColumnsListExcel(this.value,'+section_id+',\''+hash_key+'\')" name="excelMappingTable"></select>' +
		'</div></div>';
	$("#excelDataMapping").html(html);
	appendTableoptions();

}
function getAllColumnsListExcel(value,section_id,hash_key){
	let formData = new FormData();
	formData.append('TableName',value);
	formData.append('section_id',section_id);
	formData.append('hash_key',hash_key);
	app.request("getAllColumnsListExcel",formData).then(response => {

		$("#excelDataMappingOther").html(response.data);
	});
}
function functionEditExcelHeader(section_id,department_id,id)
{
	let formData = new FormData();
	formData.append('section_id',section_id);
	formData.append('department_id',department_id);
	formData.append('id',id);
	app.request("getExcelTableConfiguarationUpdate",formData).then(response => {
		if (response.status === 200) {
			var userdata=response.data;
			if(userdata.length>0)
			{
				$("#excelCount").val(userdata.length);
				for(var i=0;i<userdata.length;i++)
				{
					getViewExcelHeader(userdata[i]);
				}
			}
			// $("#excelDataTableView").html(response.data);
		} else {
			app.errorToast('Something went wrong');
		}
	});
}
function functionDeleteExcelHeader(section_id,department_id,id) {
	let formData = new FormData();
	formData.append('section_id',section_id);
	formData.append('department_id',department_id);
	formData.append('id',id);
	app.request("getExcelTableConfiguarationDelete",formData).then(response => {
		if (response.status === 200) {
			app.successToast('Deleted Successfully');
			getExcelTableView(section_id,department_id,id);
			$('#AppendExcelDataToDiv').html("");
			$('#save_btn_excel').html("");
			$('#excelCount').val(0);
		} else {
			app.errorToast('Something went wrong');
		}
	});
}
function getViewExcelHeader(data=null){
	var count=$("#excelCount").val();
	var counter=(count*1)+1;
	var header_name="";
	var header_type="";
	var header_options="";
	var style="display:none;";
	if(data!=null)
	{
		header_name=data.input_name;
		header_type=data.input_type;
		header_options=data.options;
		if(header_type==4)
		{
			var style="display:block;";
		}
	}
	var html='' +
		'<div class="row">' +
		'<div class="col-md-6"><input type="text" placeholder="Header Name" class="form-control" id="input_name'+counter+'" name="input_name[]" value="'+header_name+'"></div>' +
		'<div class="col-md-6"><select onchange="getOptionsOfExcelHeader(this.value,'+counter+')" class="form-control" id="input_type'+counter+'" name="input_type[]">' +
		'<option value="">Select Header Type</option>' +
		'<option value="1">text</option>' +
		'<option value="2">number</option>' +
		'<option value="3">date</option>' +
		'<option value="4">Dropdown</option>' +
		'<option value="5">Multiselection Dropdown</option>' +
		'<option value="6">Radio Button</option>' +
		'<option value="7">Check Box</option>' +
		'<option value="8">Query Dropdown</option>' +
		'</select>'+
		'<textarea class="form-control" id="querydropdown'+counter+'" name="querydropdown[]" style="display: none"></textarea>'+
		'<input type="text" placeholder="Enter Options By Coma" class="form-control" id="input_options'+counter+'" name="input_options[]" value="'+header_options+'" style="'+style+'"></div>' +
		'</div><br>';
	// $("#input_type"+counter+" option[value='"+header_type+"']").prop("selected", true);

	$("#AppendExcelDataToDiv").append(html);
	var d_id="input_type"+counter;
	document.getElementById(d_id).value=parseInt(header_type);
	var cnt=counter++;
	$("#excelCount").val(cnt);
	if(data==null){
		$("#save_btn_excel").html('<button class="btn btn-primary"  type="button" onclick="saveDataExcelHeader()">Save</button>');
	}
}
function getOptionsOfExcelHeader(value,counter)
{
	var e_id="input_options"+counter;
	var e_id2="querydropdown"+counter;
	if(value==4 || value==5 || value==6 || value==7)
	{
		document.getElementById(e_id).style.display="block";

	}
	else
	{
		document.getElementById(e_id).style.display="none";
	}
	if(value == 8){
		document.getElementById(e_id2).style.display="block";
	}else{
		document.getElementById(e_id2).style.display="none";
	}
}
function saveDataExcelHeader(){
	$.ajax({
		type: "POST",
		url: baseURL+"Html_template/ExcelHeadersave",
		dataType: "json",
		data:$('#ExcelHeaderForm').serialize(),
		success: function (result) {
			if(result.status==200){
				app.successToast(result.body);
				$('#AppendExcelDataToDiv').html("");
				$('#save_btn_excel').html("");
				$('#excelCount').val(0);
				// getExcelTableView(section_id,department_id,id);
			}else{
				app.errorToast(result.body);
			}

		}, error: function (error) {
			app.errorToast('Something went wrong please try again');
		}
	});
}

