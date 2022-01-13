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
                                       href="#sectionTab" role="tab" aria-controls="section" aria-selected="false">Sections</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="question-tab" data-toggle="tab" href="#questionTab"
                                       role="tab" aria-controls="question" aria-selected="true">Form Elements</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="dom-tab" data-toggle="tab" href="#domTab"
                                       role="tab" aria-controls="question" aria-selected="true">DOM Element</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="questionTab" role="tabpanel"
                                     aria-labelledby="question-tab">
                                    <ul class="list-group" id="">
                                        <!-- <li class="list-group-item item_div" data-type="21" draggable="true">
                                            <i class="fas fa-table"></i> Row
                                        </li>
                                        <li class="list-group-item item_div" data-type="22" draggable="true">
                                            <i class="fas fa-table"></i> div
                                        </li>
                                        <li class="list-group-item item_div" data-type="23">
                                            <i class="fas fa-table"></i> label
                                        </li> -->
                                        <!-- 	<li class="list-group-item item_div" data-type="1" data-name="#shorttext_" id="item_shorttext" draggable="true">
                                                <i class="fas fa-font"></i> Short Text
                                            </li> -->
                                        <li class="list-group-item item_div" id="item_shorttext" data-type="1" data-name="#shorttext_" draggable="true">
                                            <i class="fas fa-font"></i> Short Text
                                        </li>
                                        <li class="list-group-item item_div" data-type="2" id="item_longtext" data-name="#longtext_" draggable="true">
                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAW0lEQVRIie2TMQrAMAwDL3ldSv//gaT/SIe4dOnggA0ddCCwFsmLQIgITuACZrAGcGBHdPijXuxIo2aGq+B/BcXk9dsFKVTWiuEdB07vYcCac8aaO9A2HxLigxsxxE0Q/2+PkwAAAABJRU5ErkJggg=="/>
                                            Long Text
                                        </li>
                                        <li class="list-group-item item_div" data-type="3" id="item_dropdown" data-name="#dropdown_" draggable="true">
                                            <i class="fas fa-chevron-circle-down"></i>
                                            Drop-down
                                        </li>
                                        <li class="list-group-item item_div" data-type="4" id="item_multidropdown" data-name="#multidropdown_" draggable="true">
                                            <i class="far fa-caret-square-down"></i>
                                            Multiple Selection
                                        </li>
                                        <li class="list-group-item item_div" data-type="5" id="item_date" data-name="#date_" draggable="true">
                                            <i class="far fa-calendar-alt"></i>
                                            Date
                                        </li>
                                        <li class="list-group-item item_div" data-type="6" id="item_number" data-name="#number_" draggable="true">
                                            <i class="fas fa-hashtag"></i>
                                            Number
                                        </li>
                                        <li class="list-group-item item_div" data-type="7" id="item_file" data-name="#file_" draggable="true">
                                            <i class="fas fa-paperclip"></i>
                                            Attachment
                                        </li>
                                        <!-- <li class="list-group-item" data-type="11" onclick="insertAtCaret('editor', '#label_',11);return false;">
                                            <i class="fas fa-font"></i> Label
                                        </li> -->
                                        <li class="list-group-item item_div" data-type="12" id="item_checkbox" data-name="#checkbox_" draggable="true">
                                            <i class="fas fa-font"></i> Checkbox group
                                        </li>
                                        <li class="list-group-item item_div" data-type="13" id="item_radio" data-name="#radio_" draggable="true">
                                            <i class="fas fa-font"></i> Radio group
                                        </li>

                                        <li class="list-group-item item_div" data-type="8" id="item_querydropdown" data-name="#querydropdown_" draggable="true">
                                            <i class="fas fa-chevron-circle-down"></i>
                                            Query Drop-down
                                        </li>
                                        <li class="list-group-item item_div" data-type="14" id="item_button" data-name="#button_" draggable="true">
                                            <i class="fas fa-caret-square-right"></i> Form Button
                                        </li>
                                        <li class="list-group-item item_div" data-type="15" id="item_excel_button" data-name="#excel_button_" draggable="true">
                                            <i class="fas fa-caret-square-right"></i> Excel Report Button
                                        </li>
                                        <li class="list-group-item item_div" data-type="16" id="item_pdf_button" data-name="#pdf_button_" draggable="true">
                                            <i class="fas fa-caret-square-right"></i> PDF Report Button
                                        </li>
                                        <li class="list-group-item item_div" data-type="17" id="item_datatable_button" data-name="#datatable_button_" draggable="true">
                                            <i class="fas fa-table"></i> DataTable Button
                                        </li>
                                        <li class="list-group-item item_div" data-type="23" id="item_datatable_report" data-name="#exceltable_button_" draggable="true">
                                            <i class="fas fa-table"></i> Excel Table button
                                        </li>
                                        <li class="list-group-item item_div" data-type="19" id="item_csv_button" data-name="#csv_button_" draggable="true">
                                            <i class="fas fa-table"></i> CSV Report Button
                                        </li>
                                        <li class="list-group-item item_div" data-type="20" id="item_datatable_report" data-name="#datatable_report_" draggable="true">
                                            <i class="fas fa-table"></i> DataTable Report
                                        </li>
                                        <li class="list-group-item item_div" data-type="23" id="item_exceltable_report" data-name="#exceltable_button_" draggable="true">
                                            <i class="fas fa-table"></i> Excel Table button
                                        </li>
                                        <li class="list-group-item item_div" data-type="24" id="item_inlineformtable_report" data-name="#inlineformtable_button_" draggable="true">
                                            <i class="fas fa-table"></i> Inline Form Table button
                                        </li>
                                        <li class="list-group-item item_div" data-type="25" id="item_querydropdownmulti" data-name="#querydropdownmultiselect_" draggable="true">
                                            <i class="fas fa-chevron-circle-down"></i>
                                            Query Drop-down Multiple Selection
                                        </li>
                                        <!-- <li class="list-group-item" data-type="10" onclick="insertAtCaret('editor', '#numberwithvalue_',10);return false;">
                                            <i class="fas fa-hashtag"></i>
                                            Number with fixed value
                                        </li>
                                        <li class="list-group-item" data-type="9" onclick="insertAtCaret('editor', '#fixquerydropdown_',9);return false;">
                                            <i class="fas fa-chevron-circle-down"></i>
                                            Fix Query Drop-down
                                        </li>
                                         -->

                                    </ul>
                                </div>
                                <div class="tab-pane fade active show" id="sectionTab" role="tabpanel"
                                     aria-labelledby="section-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Sections</th>
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

                                    <ul class="list-group" id="domMasterSortable">
                                        <li class="list-group-item item_div" id="item_row" data-type="21" draggable="true" data-name="#row_">
                                            <i class="fas fa-table"></i> Row
                                        </li>
                                        <li class="list-group-item item_div" id="item_divs" data-type="22" draggable="true" data-name="#div_">
                                            <i class="fas fa-table"></i> div
                                        </li>
                                        <li class="list-group-item item_div" id="item_lable"  data-type="11" draggable="true" data-name="#lable_">
                                            <i class="fas fa-table"></i> label
                                        </li>
                                    </ul>
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
                        <form id="doctor_form" method="post" data-form-valid="uploadSection">
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="custom-switch mt-2" style="float:right">
                                            <input type="checkbox" name="history_unabled" onchange="updateHistory()" class="custom-switch-input" id="history_unabled" data-eid="">

                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">History</span>
                                        </label>
                                    </div>
                                    <h2 class="section-title">Form Required Fields</h2>
                                    <div class="col-md-12">
                                        <label>Form Type</label>
                                        <select class="form-control" name="form_type" id="form_type" onchange="getformTypeSection(this.value)">
                                            <option value="1">HTML FORM</option>
                                            <option value="2">MASTER FORM</option>
                                            <option value="3">TRANSACTION FORM</option>
                                        </select>
                                        <div id="TableDivDisplay" class="mt-2" style="display: none;">
                                            <label class="d-block">Column View</label>
                                            <div class="form-row">
                                                <input type="hidden" name="column_view" id="column_view" value="2">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exampleRadios1" name="exampleRadios" value="1" class="custom-control-input" onclick="storeColumnViewValue(1,'column_view')">
                                                    <label class="custom-control-label" for="exampleRadios1"> One Column View</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exampleRadios2" name="exampleRadios" checked="" value="2" class="custom-control-input" onclick="storeColumnViewValue(2,'column_view')">
                                                    <label class="custom-control-label" for="exampleRadios2"> Two Column View With lable</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exampleRadios3" name="exampleRadios" value="3" class="custom-control-input" onclick="storeColumnViewValue(3,'column_view')">
                                                    <label class="custom-control-label" for="exampleRadios3"> Two Column View With TextBox</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="exampleRadios4" name="exampleRadios" value="4" class="custom-control-input" onclick="storeColumnViewValue(4,'column_view')">
                                                    <label class="custom-control-label" for="exampleRadios4"> Four Column View With lable</label>
                                                </div>
                                            </div>
                                            <label>Primary Table</label>
                                            <select class="form-control" name="primary_table" id="primary_table" onchange="getPrimaryTableData(this.value)" style="width: 100%!important">
                                            </select>
                                            <input type="hidden" name="primaryTableInsert" id="primaryTableInsert">
                                            <input type="hidden" name="primaryTableButton" id="primaryTableButton">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Section Name</label>
                                        <input type="text" class="form-control" name="section_name" id="section_name" data-valid="required"
                                               data-msg="Enter section name" />
                                    </div>
                                    <div class="col-md-12">
                                        <label>Query Parameter</label>
                                        <select class="form-control select2"
                                                name="QueryStringParameter[]" id="QueryStringParameter" multiple data-valid="required" data-msg="Add Query Parameters" style="width: 100%!important">
                                        </select>
                                    </div>
                                    <input type="hidden" name="section_id" id="section_id"/>
                                    <input type="hidden" name="department_id" id="department_id" />
                                    <input type="hidden" name="elementSequenceType" id="elementSequenceType"/>
                                    <input type="hidden" name="elementSequenceId" id="elementSequenceId"/>
                                    <input type="hidden" name="elementSequenceText" id="elementSequenceText"/>
                                </div>
                                <div class="col-md-12" id="div_dependantSection" style="display:none">
                                    <label>Select Dependancy</label>
                                    <select id="depend_section_id" class="form-control" name="depend_section_id"></select>
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
<button type="button" class="btn btn-info btn-lg d-none" id="datatableOpBtn" data-toggle="modal" data-target="#datatableOp">Open Modal</button>
<!-- Modal -->
<div id="datatableOp" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content" style="width: 90%!important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

            </div>
            <div class="modal-body">
                <!-- <div id="datatableOpHere"></div> -->


                <?php $this->load->view('DatatableTemplate/DatatableEditor'); ?>
            </div>
            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
        </div>

    </div>
</div>

<div id="RedirctModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

            </div>
            <div class="modal-body">
                <input type='hidden' id='QS_section_id' name='QS_section_id'>
                <form id="queryForm" method="post">
                    <div id="queryParamString"></div>
                </form>


            </div>
            <div class="modal-footer">

                <button type="button" id='redirectButton'class="btn btn-primary" style="display:none"
                        onclick="redirectToanotherFor()" >GO</button>
            </div>
        </div>

    </div>
</div>


<!-- narendra sir inline form table modal start -->
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg d-none" id="inlineformtableOpBtn" data-toggle="modal" data-target="#inlineformtableOp">Open Modal</button>
<!-- Modal -->
<div id="inlineformtableOp" class="modal fade" role="dialog">
    <div class="modal-dialog modal-content" style="width: 90%!important;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->

            </div>
            <div class="modal-body">
                <!-- <div id="datatableOpHere"></div> -->


                <?php $this->load->view('DatatableTemplate/DatatableFormInput'); ?>
            </div>
            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
        </div>

    </div>
</div>
<!--- narendra sir inline form table modal end -->
<?php $this->load->view('admin/HtmlFormTemplate/html_modal_page'); ?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        if(id !=="") {
            const draggable = document.getElementById(id);
            let type = draggable.getAttribute('data-type');
            let name = draggable.getAttribute('data-name');

            var design = insertAtCaret("dropBox", name, type);
		// console.log(design);
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

            var nodeCopy = doc.body.firstChild;
            if (type == 21 || type == 22 || type == 11) {
                nodeCopy = nodeCopy.firstChild;
                if (type == 11) {
                    // nodeCopy.setAttribute("contenteditable", true);
                    nodeCopy.setAttribute("onclick", "getFocusEvent(this)");
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
            nodeCopy.style.overflow = "hidden";
            var cnt = 0;
            if (nodeCopy.getAttribute('id') != 'item1') {
                nodeCopy.classList.add('div_drag');
                $(".div_drag").draggable({containment: "parent"});
                cnt = 1;
            }
            e.target.appendChild(nodeCopy);
            if (cnt == 1) {
                $(".div_drag").draggable({containment: "parent"});
                $(".div_drag").resizable({
                    containment: "parent",
                    minHeight: '100%',
                    edges: {left: true, right: true, bottom: true, top: true}
                });

            }
        }
    }
    function getFocusEvent(ele)
    {
        // console.log(ele);
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
    $('#close-bar').on('click', function(){

        var $$ = $(this),
            panelWidth = $('#hiddenPanel').outerWidth();

        if( $$.is('.myButton') ){
            $('#hiddenPanel').animate({left:0}, 300);
            $$.removeClass('myButton')
        } else {
            $('#hiddenPanel').animate({left:-panelWidth}, 300);
            $$.addClass('myButton')
        }

    });
</script>
