<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
?>
<style>
	.custom-header {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: space-between;
		padding: 8px 0;
	}
</style>
<style>.form-control-field
	{
		font-size: 14px;
		padding: 10px 15px;
		height: 42px;
		background-color: #fdfdff;
		border-color: #e4e6fc;
		line-height: 1.5;
		color: #495057;
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		margin-left:5px;
	}

	.main-content
	{
		width: 100%!important;
		padding-left: 5px!important;
		padding-right: 5px!important;
		padding-top: 90px!important;
	}
	body.layout-2 .main-wrapper
	{
		padding: 0px!important;
	}
	.btn_class
	{
		color: #007bff;
		text-decoration: underline;
	}
	.select2-container {
		width: 100%!important;
	}
	div.spanLabel.highlight {
		background: #E1ECF4;
		border: 1px dotted #39739d;
	}
	.section_title
	{
		content: ' ';
		border-radius: 5px;
		height: 8px;
		width: 30px;
		background-color: #891635;
		display: inline-block;
		float: left;
		margin-top: 6px;
		margin-right: 15px;
	}
</style>
<style>



	.drag-over {
		border: dashed 3px red;
	}


	.item_div {
		min-height: 50px;
		width: 100%;
	}

	.yellow {
		background-color: #f0db4f45;
		margin: 2px;
		/* display: table;
	 border-collapse: separate;
	 box-sizing: border-box;
	 text-indent: initial;
	 border-spacing: 2px;
	 border-color: grey;*/
	}

	.green {
		background-color: #4ff0724d;
		/*margin: 2px;*/
		border: .4px solid black;
	}
	.label_Blue
	{
		/*background-color: blue;*/
		/*margin: 2px;*/
		border: .4px solid black;
	}

	.hide {
		display: none;
	}
	[contentEditable=true]:empty:not(:focus):before{
		content:attr(data-text)
	}
	.top_right:before
	{
		top: 1px;
		right: 1px;
		display: inline;
		z-index: 90;
		position: absolute;
		content: "\e697";
		cursor: pointer;
	}
	#dropBox{
		overflow: auto;
	}
	.div_display
	{
		background-color: #fdfdff;
		border-color: #e4e6fc;
		/*display: block;*/
		width: 100%;
		min-height: calc(2.25rem + 2px);
		padding: .375rem .75rem;
		font-size: 1rem;
		line-height: 1.5;
		color: #495057;
		/* background-color: #fff;*/
		background-clip: padding-box;
		border: 1px solid #ced4da;
		border-radius: .25rem;
		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	.Border_div
	{
		border:1px dotted red;
	}
	.div_drag
	{
		/*position: absolute;*/
		overflow: hidden;
	}
</style>
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1><span id="departmentName"></span></h1>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-12 col-md-3 col-lg-3">
					<div class="card">

						<div class="card-body">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active show" id="section-tab" data-toggle="tab"
									   href="#sectionTab" role="tab" aria-controls="section" aria-selected="false">Reports</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="question-tab" data-toggle="tab" href="#questionTab"
									   role="tab" aria-controls="question" aria-selected="true"> Elements</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="dom-tab" data-toggle="tab" href="#domTab"
									   role="tab" aria-controls="question" aria-selected="true">Formatting</a>
								</li>

							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade" id="questionTab" role="tabpanel"
									 aria-labelledby="question-tab">
									
									<ul class="list-group" id="domMasterSortable">
										<li class="list-group-item item_div" id="item_row" data-type="1" draggable="true" data-name="#row_">
											<i class="fas fa-table"></i> Row
										</li>
										<li class="list-group-item item_div" id="item_divs" data-type="2" draggable="true" data-name="#div_">
											<i class="fas fa-table"></i> Div
										</li>
										<li class="list-group-item item_div" id="item_lable"  data-type="3" draggable="true" data-name="#lable_">
											<i class="fas fa-table"></i> Label
										</li>
										<li class="list-group-item item_div" id="item_labledatabase"  data-type="4" draggable="true" data-name="#lablewithdatabasevalue_">
											<i class="fas fa-table"></i> Label With Database Value
										</li>
										<li class="list-group-item item_div" id="item_paragraph"  data-type="5" draggable="true" data-name="#paragraph_">
											<i class="fas fa-table"></i> Paragraph
										</li>
										<li class="list-group-item item_div" id="item_paragraphdatabase"  data-type="6" draggable="true" data-name="#paragraphwithdatabase_">
											<i class="fas fa-table"></i> Paragraph Database Value
										</li>
										<li class="list-group-item item_div" id="item_tablevertical"  data-type="7" draggable="true" data-name="#tablevertical_">
											<i class="fas fa-table"></i> Table Vertical
										</li>
										<li class="list-group-item item_div" id="item_tablehorizontal"  data-type="8" draggable="true" data-name="#tablehorizontal_">
											<i class="fas fa-table"></i> Table Horizontal
										</li>
									</ul>
								</div>
								<div class="tab-pane fade active show" id="sectionTab" role="tabpanel"
									 aria-labelledby="section-tab">
									<div class="row">
										<div class="col-12">
											<table class="table table-striped mb-0">
												<thead>
												<tr>
													<th>Reports</th>
													<th></th>
												</tr>
												</thead>
												<tbody id="sectionTableBody">

												</tbody>
											</table>
										</div>
									</div>

								</div>
								<div class="tab-pane fade" id="domTab" role="tabpanel"
									 aria-labelledby="dom-tab">

									<!--  <div><span id="close-bar" class="myButton btn btn-info"> # </span></div> -->
									<div>
										<div class="pt-2"><h5>Formating Element</h5></div>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('bold')"><i class="fas fa-bold"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('italic')"><i class="fas fa-italic"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('underline')"><i class="fas fa-underline"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('strikeThrough')"><i class="fas fa-strikethrough"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('insertUnorderedList')"><i class="fas fa-list-ul"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('insertOrderedList')"><i class="fas fa-list-ol"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('createLink')"><i class="fas fa-link"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('removeFormat')"><i class="fas fa-times"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('redo')"><i class="fas fa-redo"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementDataTag('undo')"><i class="fas fa-undo"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h1>')"><i class="fas fa-heading"></i>1</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h2>')"><i class="fas fa-heading"></i>2</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h3>')"><i class="fas fa-heading"></i>3</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h4>')"><i class="fas fa-heading"></i>4</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h5>')"><i class="fas fa-heading"></i>5</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('formatBlock','<h6>')"><i class="fas fa-heading"></i>6</button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('JustifyLeft',' ')"><i class="fas fa-align-left"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('JustifyCenter',' ')"><i class="fas fa-align-center"></i></button>
										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('JustifyRight',' ')"><i class="fas fa-align-right"></i></button>

										<button class="btn btn-sm btn-outline-dark" onclick="getElementHeadingTag('Justify',' ')"><i class="fas fa-align-justify"></i></button>

									</div>
									<div class="pt-2" id="textStyleDiv">
										<div><h5>Style Formating</h5></div>

										<div class="col-md-12">
											<div class="section-title mt-0">Background</div>
											<div class="form-row">
												<div class="form-group">
													<label>Background-color</label>
													<input type="color" class="form-control" id="inBgColor"/>
												</div>
											</div>
											<div class="section-title mt-0">Border</div>
											<div class="form-row">
												<div class="form-group col-md-12">
													<label>size</label>
													<input type="text" min="0" class="form-control" value="0px" id="inBorderSize"/>
												</div>
												<div class="form-group col-md-12">
													<label>border-style</label>
													<select id="ddBorderStyle" class="form-control">
														<option value="dashed">dashed</option>
														<option value="dotted">dotted</option>
														<option value="double">double</option>
														<option value="dashed">groove</option>
														<option value="solid" selected>solid</option>
													</select>
												</div>
												<div class="form-group col-md-12">
													<label>border-color</label>
													<input type="color" class="form-control" id="inBorderColor"/>
												</div>
											</div>
											<div class="section-title mt-0">Box Shadow</div>
											<div class="form-row">

												<div class="form-group col-md-12">
													<label>box-shadow-color</label>
													<input type="color" id="inBoxShadowColor" class="form-control inBoxShadow"/>
												</div>
												<div class="form-group col-md-12">
													<label>x-offset</label>
													<input type="text" value="0px" id="inBoxSizex" class="form-control inBoxShadow"/>
												</div>
												<div class="form-group col-md-12">
													<label>y-offset</label>
													<input type="text" value="0px" id="inBoxSizey" class="form-control inBoxShadow"/>
												</div>
												<div class="form-group col-md-12">
													<label>Blur</label>
													<input type="text" value="0px" id="inBoxSizeb" class="form-control inBoxShadow"/>
												</div>
												<div class="form-group col-md-12">
													<label>Spread</label>
													<input type="text" value="0px" id="inBoxSizes" class="form-control inBoxShadow"/>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="section-title mt-0">Custom Css</div>
										<textarea name="textStyle" id="textStyle" class="form-control" rows="50" style="min-height: 200px;"></textarea></div>

									<hr/>
								</div>
							</div>


						</div>
					</div>
				</div>
				<div class="col-12 col-md-9 col-lg-9">
					<div class="card">
						<form id="reportMaker_form" method="post" data-form-valid="uploadSection">
							<div class="card-body">

								<div class="form-group">
									
									<div class="col-md-12">
										<label>Reort Name</label>
										<input type="text" class="form-control" name="report_name" id="report_name" data-valid="required"
											   data-msg="Enter Report name" />
									</div>
									
									<input type="hidden" name="report_id" id="report_id"/>
									
									<input type="hidden" name="elementSequenceType" id="elementSequenceType"/>
									<input type="hidden" name="elementSequenceId" id="elementSequenceId"/>
									<input type="hidden" name="elementSequenceText" id="elementSequenceText"/>

									<div class="col-md-12">
										<label>Query Parameter</label>
										<select class="form-control select2"
												name="QueryStringParameter[]" id="QueryStringParameter" multiple data-valid="required" data-msg="Add Query Parameters" style="width: 100%!important">
										</select>
									</div>
								</div>
							
								<h2 class="section-title">Form Editor</h2>
								<!-- <div class="">
									<div id="editor" name="editor" contenteditable="true" class="ui-widget-content"></div>
								</div> -->

								<div class="col-md-12" id="dropBox" name="editor" contenteditable="true" style="height: 100vh;border: 1px solid black;"></div>
								<h2 class="section-title">Form Query Selections</h2>
								<div class="" id="edit_buttons">

								</div>

							</div>
							<div class="card-footer text-right">
								<button class="btn btn-primary mr-1" id="templateFornBtn" type="submit">Submit</button>
								<!-- <button class="btn btn-secondary" type="reset">Reset</button> -->
							</div>
						</form>
						<div class="card-footer">
							<!-- <h2 class="section-title">Form Design View</h2> -->
							<!-- <div class="bg-secondary droppable-box">
									<ul id="htmlFormModalData" class="list-group connected-sortable"
										style="min-height: 20px"></ul>
								</div> -->
							<div class="col-md-12" id="htmlFormModalData"></div>
						</div>
					</div>
				</div>
				<!-- <div class="col-12 col-md-2 col-lg-2"></div> -->

			</div>
		</div>
	</section>
	<section id="hiddenPanel" class="txt-highlight-color bg-color bg-pattern">
	</section>
</div>

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg d-none" id="htmlFormModalOpBtn" data-toggle="modal"
		data-target="#htmlFormModalOp">Open Modal
</button>
<!-- Modal -->
<div id="htmlFormModalOp" class="modal fade" role="dialog">

	<div class="modal-dialog modal-content" style="width:90%!important;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Configuration</h4>
				<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

			</div>
			<div class="modal-body">
				
				
	
				<div id="addInputHereRequiredHere"></div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="addFormDesignOptions()">Save</button>
				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			</div>
		</div>

	</div>
</div>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg d-none" id="querydropdownOpBtn" data-toggle="modal"
		data-target="#querydropdownOp">Open Modal
</button>
<!-- Modal -->
<div id="querydropdownOp" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

			</div>
			<div class="modal-body">
				<div id="querydropdownOpHere"></div>

				<div id="querydropdownOpHereDefault"></div>


			</div>
			<div class="modal-footer">

				<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			</div>
		</div>

	</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<?php $this->load->view('_partials/footer'); ?>


<style>
	.spanLabel{
		background-color: #0c0c0c24;
		padding: 4px;
	}
</style>

<script>
	$( function() {
		$( "#dropBox" ).droppable();
		// $( "#editor" ).droppable();
		// $( "#editor" ).sortable();
		// $( "#editor" ).sortable();

	} );
	$(".top_right").on('click', function(event){
		event.stopPropagation();
		event.stopImmediatePropagation();
		console.log(event);
		//(... rest of your JS code)
	});
	const items = document.querySelectorAll('.item_div');

	items.forEach(item => {
		item.addEventListener('dragstart', dragStart);
	})

	function dragStart(e) {
		e.dataTransfer.setData('text/plain', e.target.id);
		// setTimeout(() => {
		// 	e.target.classList.add('hide');
		// }, 0);
		// console.log(e.target.parentElement);
	}

	const boxes = document.querySelectorAll('#dropBox');

	boxes.forEach(box => {
		box.addEventListener('dragenter', dragEnter)
		box.addEventListener('dragover', dragOver);
		box.addEventListener('dragleave', dragLeave);
		box.addEventListener('drop', drop);
	});
	function dragEnter(e) {
		e.preventDefault();
		e.target.classList.add('drag-over');
	}

	function dragOver(e) {
		e.preventDefault();
		e.target.classList.add('drag-over');
	}

	function dragLeave(e) {
		e.target.classList.remove('drag-over');
	}

	function drop(e) {
		e.target.classList.remove('drag-over');

		// get the draggable element
		const id = e.dataTransfer.getData('text/plain');
		const draggable = document.getElementById(id);
		let type = draggable.getAttribute('data-type');
		let name = draggable.getAttribute('data-name');

		var design=insertAtCaret("dropBox", name,type);
		console.log(design);
		// if(type==21){
		// 	let element=document.createElement("div");
		// 	element.id ="";
		// 	element.classList=[];
		// 	let el="<div class='row'></div>";
		// 	$.html(el);
		// }
		// console.log(type);
		// let nodeCopy=draggable.cloneNode(true);

		// var textNo=Math.floor((Math.random() * 100) + 1);
		// let item_id=nodeCopy.id="item"+textNo;

		var parser = new DOMParser();
		var doc = parser.parseFromString(design, 'text/html');
		console.log(doc);
		var nodeCopy= doc.body.firstChild;
		if(type==1 || type==2 || type==3 || type==4 || type==5 || type==6)
		{	
			if(type==1 || type==2 || type==6 || type==3 || type==5 || type==6)
			{
				nodeCopy=nodeCopy.firstChild;
				if(type==3 || type==5)
				{
					nodeCopy.setAttribute("onclick", "getFocusEvent(this)");
				}

			}
			// console.log(nodeCopy);
			if(type==4)
			{
				// console.log(nodeCopy);
				// nodeCopy.setAttribute("contenteditable", true);
				nodeCopy.firstChild.setAttribute("onclick", "getFocusEvent(this)");
			}
		}
		// var temp = document.createElement('div');
		// temp.innerHTML = design;
		// var htmlObject = temp.firstChild;

		// var nodeCopy=stringToHTML(design);
		// console.log(nodeCopy);
		// nodeCopy.setAttribute("contenteditable", true);
		nodeCopy.setAttribute("draggable", true);
		nodeCopy.setAttribute("droppable", true);
		nodeCopy.setAttribute("resizable", true);
		nodeCopy.style.overflow="hidden";
		var cnt=0;
		if(nodeCopy.getAttribute('id')!='item1')
		{
			nodeCopy.classList.add('div_drag');
			$( ".div_drag" ).draggable({containment: "parent"});
			cnt=1;
		}
		e.target.appendChild(nodeCopy);
		if(cnt==1)
		{
			$( ".div_drag" ).draggable({containment: "parent"});
			$( ".div_drag" ).resizable({containment: "parent",
				minHeight: '100%',
				edges: { left: true, right: true, bottom: true, top: true }
			});

		}

	}
	function getFocusEvent(ele)
	{
		// console.log("hiiii");
		ele.setAttribute("contenteditable", true);
		$(ele).focus();
	}
	$(".bld").on('click',function(){
		document.execCommand('bold');
	});

	$(".itl").on('click',function(){
		document.execCommand('italic');
	});
	function getElementDataTag(tag)
	{
		document.execCommand(tag);
	}
	function getElementHeadingTag(tagHead,tag)
	{

		document.execCommand(tagHead, false, tag);
	}
	
</script>
