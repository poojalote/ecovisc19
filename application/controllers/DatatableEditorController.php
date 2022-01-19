<?php

require_once 'HexaController.php';

/**
 * @property  MasterModel MasterModel
 */
class DatatableEditorController extends HexaController
{


    /**
     * DatatableEditorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("MasterModel");
    }

    public function opdPanel(){
        $this->load->view('Form_Show/opd_panel',array("title"=>"OPD Panel"));
    }

    public function datatableTabSection(){
        $this->load->view('admin/patients/view_tab_patients',array("title"=>"Datatable"));
    }

    function getAllTableNames()
    {
        $tables = $this->db->list_tables();
        $option = "<option value='' selected disabled>Select Table</option>";
        foreach ($tables as $table) {
            $option .= "<option value='" . $table . "'>" . $table . "</option>";
        }
        $response['option'] = $option;
        echo json_encode($response);
    }

    function getAllColumns()
    {
        $TableName = $this->input->post('TableName');
        $fields = $this->db->field_data($TableName);
        $option = "<option value='' disabled>Select Column</option>";
        foreach ($fields as $field) {
            $column_name = $field->name;
            $option .= "<option value='" . $column_name . "'>" . $column_name . "</option>";
        }
        $response['status'] = 200;
        $response['option'] = $option;
        echo json_encode($response);


    }


    function saveDataTableEditor()
    {

        $header = $this->is_parameter(array("element_id", "section_id", "queryTable", "queryTableSelectColumn", "queryTableSearchColumn",
            "queryTableOrderColumn", "queryTableOrderColumnDirection", "dataTableSyncType"));

        if ($header->status) {
            $query_master_id=$this->input->post("query_master_id");
            $filterArray = json_decode($this->input->post("filterData"));
            $actionArray = json_decode($this->input->post("actionData"));
            $whereArray = json_decode($this->input->post("whereData"));
            $customWhereCondition = $this->input->post("customWhereCondition");

            $table = $header->param->queryTable;
            $select = $header->param->queryTableSelectColumn;
            $search = $header->param->queryTableSearchColumn;
            $order = $header->param->queryTableOrderColumn;
            $direction = $header->param->queryTableOrderColumnDirection;
            $type = $header->param->dataTableSyncType;
            $whereCondition = "";
            if (!is_null($this->input->post("queryTableWhereCondition")) && $this->input->post("queryTableWhereCondition") !== "") {
                $whereCondition = $this->input->post("queryTableWhereCondition");
            }

            $filterStringArray = array();
            if (!is_null($filterArray)) {
                foreach ($filterArray as $filterObject) {
                    $filterString = "";
                    if (property_exists($filterObject, "FilterTableColumn")) {
                        $filterString .= "FilterTableColumn:" . $filterObject->FilterTableColumn . "|";
                    }
                    if (property_exists($filterObject, "filterValueType")) {
                        $filterString .= "filterValueType:" . $filterObject->filterValueType . "|";
                    }
                    if (property_exists($filterObject, "filterQueryTable")) {
                        $filterString .= "filterQueryTable:" . $filterObject->filterQueryTable . "|";
                    }
                    if (property_exists($filterObject, "filterKeyValue")) {
                        $filterString .= "filterKeyValue:" . $filterObject->filterKeyValue . "|";
                    }
                    if (property_exists($filterObject, "filterQueryCondition")) {
                        $filterString .= "filterQueryCondition:" . $filterObject->filterQueryCondition . "|";
                    }
                    if (property_exists($filterObject, "filterStaticValue")) {
                        $filterString .= "filterStaticValue:" . $filterObject->filterStaticValue . "|";
                    }
                    array_push($filterStringArray, $filterString);
                }
            }
            $actionStringArray = array();
            if (!is_null($actionArray)) {
                foreach ($actionArray as $actionObject) {
                    $actionString = "";
                    if (property_exists($actionObject, "actionButtonPrimary")) {
                        $actionString .= "actionButtonPrimary:" . $actionObject->actionButtonPrimary . "|";
                    }
                    if (property_exists($actionObject, "actionButtonIcon")) {
                        $actionString .= "actionButtonIcon:" . $actionObject->actionButtonIcon . "|";
                    }
                    if (property_exists($actionObject, "actionButtonType")) {
                        $actionString .= "actionButtonType:" . $actionObject->actionButtonType . "|";
                    }
                    if (property_exists($actionObject, "actionButtonRedirectTemplate")) {
                        $actionString .= "actionButtonRedirectTemplate:" . $actionObject->actionButtonRedirectTemplate . "|";
                    }
                    if (property_exists($actionObject, "actionButtonRedirectQueryParam")) {
                        $actionString .= "actionButtonRedirectQueryParam:" . $actionObject->actionButtonRedirectQueryParam . "|";
                    }
                    if (property_exists($actionObject, "actionButtonExecutionQuery")) {
                        $actionString .= "actionButtonExecutionQuery:" . $actionObject->actionButtonExecutionQuery . "|";
                    }
                    if (property_exists($actionObject, "actionButtonRedirectPage")) {
                        $actionString .= "actionButtonRedirectPage:" . $actionObject->actionButtonRedirectPage . "|";
                    }
                    if (property_exists($actionObject, "actionButtonModalQueryParam")) {
                        $actionString .= "actionButtonModalQueryParam:" . $actionObject->actionButtonModalQueryParam . "|";
                    }
                    if (property_exists($actionObject, "actionButtonModalTemplate")) {
                        $actionString .= "actionButtonModalTemplate:" . $actionObject->actionButtonModalTemplate . "|";
                    }


                    array_push($actionStringArray, $actionString);
                }
            }
            $whereStringArray = array();
            if (!is_null($whereArray)) {
                foreach ($whereArray as $itemObject) {
                    $whereString = "";
                    if (property_exists($itemObject, "WhereTableColumn")) {
                        $whereString .= "whereTableColumn:" . $itemObject->WhereTableColumn . "|";
                    }
                    if (property_exists($itemObject, "WhereColumnValue")) {
                        $whereString .= "WhereColumnValue:" . $itemObject->WhereColumnValue . "|";
                    }
                    array_push($whereStringArray, $whereString);
                }
            }


            $filterColumns = implode(",", $filterStringArray);
            $actionColumns = implode(",", $actionStringArray);
            $whereColumns = implode(",", $whereStringArray);
            if (!is_null($customWhereCondition) && $customWhereCondition != "") {
                $cusWhereArray = explode(",", $customWhereCondition);
                foreach ($cusWhereArray as $whereOption) {
                    $values = explode("=", $whereOption);
                    if (count($values) == 2) {
                        $whereColumns .= ",whereTableColumn:" . $values[0] . "|WhereColumnValue:" . $values[1];
                    }
                }
            }
            $dataTableDetails = array(
                "elementID" => $header->param->element_id,
                "sectionID" => $header->param->section_id,
                "table_name" => $table,
                "select_column" => $select,
                "search_column" => $search,
                "order_column" => $order,
                "order_direction" => $direction,
                "table_type" => $type,
                "where_condition" => $whereColumns,
                "filter_columns" => $filterColumns,
                "action_columns" => $actionColumns,
                "status" => 1,
            );
            if($query_master_id!=null)
            {
                $where=array('id'=>$query_master_id);
                $resultObject = $this->MasterModel->_update("datatable_query_master", $dataTableDetails,$where);
            }
            else
            {
                $resultObject = $this->MasterModel->_insert("datatable_query_master", $dataTableDetails);
            }

            if ($resultObject->status) {
                $response["status"] = 200;
                $response["body"] = "Add Successfully";
            } else {
                $response["status"] = 201;
                $response["body"] = "failed";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Missing Parameter";
        }
        echo json_encode($response);
    }


    public function getDataTableTemplate()
    {

        $element_id = $this->input->post("element_id");
        $section_id = $this->input->post("section_id");

        $queryParameter_hidden = $this->input->post("queryParameter");
        if (!is_null($queryParameter_hidden)) {
            $queryParameterString = base64_decode($queryParameter_hidden);
            $queryStringArray = json_decode($queryParameterString);
            extract((array)$queryStringArray);
        }

        $resultObject = $this->MasterModel->_select("datatable_query_master",
            array("status" => 1, "elementID" => $element_id, "sectionID" => $section_id), array("table_name", "select_column", "filter_columns", "action_columns"));

        if ($resultObject->totalCount > 0) {
            $table = $resultObject->data->table_name;
            $selectColumn = explode(",", $resultObject->data->select_column);
//			$searchColumn = explode(",", $resultObject->data->search_column);
//			$orderColumn = explode(",", $resultObject->data->order_column);
//			$orderDirection = $resultObject->data->order_direction;
//			$type = $resultObject->data->table_type;
            $filterArray = array();
            if ($resultObject->data->filter_columns != "" && $resultObject->data->filter_columns != null) {
                $filterStrings = explode(",", $resultObject->data->filter_columns);

                foreach ($filterStrings as $filter) {
                    $filterOptions = explode("|", $filter);
                    $filterObject = new stdClass();
                    foreach ($filterOptions as $option) {
                        $filterProperties = explode(":", $option);
                        if (count($filterProperties) == 2) {
                            $filterObject->{$filterProperties[0]} = $filterProperties[1];
                        }
                    }
                    array_push($filterArray, $filterObject);
                }
            }
            $filterTemplate = "";
            $response["filter"] = $filterArray;

            foreach ($filterArray as $index => $filter) {

                if (property_exists($filter, "filterValueType")) {
                    if ((int)$filter->filterValueType == 1) {
                        $filterTemplate .= `
							<div class="col-md-3">

								<input type="date" name="dynamicDataTableFilter_` . $index . `"
								 id="dynamicDataTableFilter_` . $index . `'
								 onchange="dynamicFilter('` . $element_id . `','` . $index . `','` . $filter->FilterTableColumn . `,` . $filter->filterValueType . `,` . $section_id . `)' />
							</div>
						`;
                    }
                    if ((int)$filter->filterValueType == 2) {
                        $filterTemplate .= `
							<div class="col-md-3">
								<input type='datetime-local' name="dynamicDataTableFilter_` . $index . `"
								 id="dynamicDataTableFilter_` . $index . `'
								 onchange="dynamicFilter('` . $element_id . `','` . $index . `','` . $filter->FilterTableColumn . `,` . $filter->filterValueType . `,` . $section_id . `)' />
							</div>
						`;
                    }
                    if ((int)$filter->filterValueType == 3) {
                        $options = "";
                        if (property_exists($filter, "filterQueryCondition") && property_exists($filter, "filterQueryTable") &&
                            property_exists($filter, "filterKey")) {
                            $Conditions=explode("@",$filter->filterQueryCondition);
                            $whereCondition=array();
                            foreach($Conditions as $con){
                                $cond=explode("=",$con);
                                if(strpos("#",$cond[1])){
                                    $param = str_replace("#","",$cond[1]);
                                    if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105) {
                                        if($cond[0]=="branch_id"){
                                            $whereCondition[$cond[0]]=$this->session->user_session->branch_id;
                                        }else{
                                            $whereCondition[$cond[0]]=${$param};
                                        }
                                    }else{
                                        $whereCondition[$cond[0]]=${$param};
                                    }

                                }else{
                                    if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105) {
                                        if($cond[0]=="branch_id"){
                                            $whereCondition[$cond[0]]=$this->session->user_session->branch_id;
                                        }else{
                                            $whereCondition[$cond[0]]=$cond[1];
                                        }
                                    }else{
                                        $whereCondition[$cond[0]]=$cond[1];
                                    }

                                }

                            }

                            if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105) {

                                $table ="com_1_room ";
                            }else{
                                $table = $filter->filterQueryTable;
                            }

                            if(property_exists($filter,"customfilterValue")){
                                $select=explode("@",$filter->customfilterValue);
                                $selectString ="group_concat(".implode(',',$select).") as ".$filter->filterValue;
                                $filterQueryResult = $this->MasterModel->
                                _select($filter->filterQueryTable, $whereCondition,
                                    array($selectString,$filter->filterKey), false, $filter->filterKey);
                                $response["query"] = $this->db->last_query();
                            }else{
                                $filterQueryResult = $this->MasterModel->
                                _select($filter->filterQueryTable, $whereCondition,
                                    array($filter->filterValue,$filter->filterKey), false, $filter->filterKey);
                            }

                            $response["filterQuery"] = $filterQueryResult->last_query;
                            if ($filterQueryResult->totalCount > 0) {
                                foreach ($filterQueryResult->data as $option) {
                                    if ($option->{$filter->filterKey} !== "" && $option->{$filter->filterKey} != null)
                                        $options .= "<option value='" . $option->{$filter->filterKey} . "'>" . $option->{$filter->filterValue} . "</option>";
                                }
                            }
                        } else if (property_exists($filter, "filterStaticValue")) {
                            $groupOptions = explode("@", $filter->filterStaticValue);
                            foreach ($groupOptions as $fOption) {
                                $keyValue = explode("=", $fOption);
                                if (count($keyValue) == 2) {
                                    $options .= "<option value='" . $keyValue[0] . "'>" . $keyValue[1] . "</option>";
                                }
                            }
                        }
                        $margin_left='';
                        if($index==0)
                        {
                            $margin_left='style="margin-left:auto;"';
                        }
                        $filterTemplate .= '
							<div class="form-group col-md-3" '.$margin_left.'>
								<label>' . $filter->FilterTableColumn . '</label>
								<select  class="form-control" name="dynamicDataTableFilter_' . $index . '"
								 id="dynamicDataTableFilter_' . $index . '"
								 onchange="dynamicFilter(\'' . $element_id . '\',' . $index . ',`' . $filter->FilterTableColumn . '`,' . $filter->filterValueType . ',this.value,' . $section_id . ')">' . $options . '</select>
							 </div>
						';
                    }
                }
            }

            $actionArray = array();
            if ($resultObject->data->action_columns != "" && $resultObject->data->action_columns != null) {
                $actionStrings = explode(",", $resultObject->data->action_columns);
                foreach ($actionStrings as $action) {
                    $actionOptions = explode("|", $action);
                    $actionObject = new stdClass();
                    foreach ($actionOptions as $option) {
                        $actionProperties = explode(":", $option);
                        if (count($actionProperties) == 2) {
                            $actionObject->{$actionProperties[0]} = $actionProperties[1];
                        }
                    }
                    array_push($actionArray, $actionObject);
                }
            }

            $tableStructure = "
				<div class='row'>
					" . $filterTemplate . "
				</div>
				<div class='row'>
					<div class='table-responsive'>
					<table class='dataTable table table-striped'  style='width: 100%' id='dynamicDataTable_" . str_replace("#", "", $element_id) . "'>
						<thead>
							<tr>
				";
            foreach ($selectColumn as $column) {
                $position = strpos($column, " as ");
                if ($position !== false) {
                    $column = str_replace("'", "", substr($column, ($position + 4)));
                }

				if($section_id == '102' && $column=='ConsultCount'){

				}else{
					$tableStructure .= "<th>" . ucfirst($column) . "</th>";
				}

            }
            if (count($actionArray) > 0) {
                $tableStructure .= "<th>Action</th>";
            }
            $tableStructure .= "
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					</div>
				</div>
					";


            $response["status"] = 200;
            $response["body"] = $tableStructure;
            $response["tableID"] = "dynamicDataTable_" . str_replace("#", "", $element_id);

        } else {
            $response["status"] = 201;
            $response["body"] = "Not Found";
        }
        echo json_encode($response);

    }

    function getDynamicTableData()
    {
        $element_id = $this->input->post("element_id");
        $section_id = $this->input->post("section_id");
        $transaction_id = $this->input->post("transaction_id");
        $queryParameter_hidden = $this->input->post("queryParameter");
        $having = null;
        if (!is_null($queryParameter_hidden)) {
            $queryParameterString = base64_decode($queryParameter_hidden);
            $queryStringArray = json_decode($queryParameterString);
            extract((array)$queryStringArray);
        }



        $resultObject = $this->MasterModel->_select("datatable_query_master",
            array("status" => 1, "elementID" => $element_id, "sectionID" => $section_id));

        if ($resultObject->totalCount > 0) {
            $table = $resultObject->data->table_name." q ";
            $selectColumn = explode(",", $resultObject->data->select_column);
            $searchColumn = explode(",", $resultObject->data->search_column);
            $orderColumn = explode(",", $resultObject->data->order_column);
            $whereCondition = $resultObject->data->where_condition != "" ? explode(",", $resultObject->data->where_condition) : array();
            $orderDirection = $resultObject->data->order_direction;
            $type = $resultObject->data->table_type;
            $where = array();
            $filterArray =array();
            if ($resultObject->data->filter_columns != "" && $resultObject->data->filter_columns != null) {
                $filterStrings = explode(",", $resultObject->data->filter_columns);

                foreach ($filterStrings as $filter) {
                    $filterOptions = explode("|", $filter);
                    $filterObject = new stdClass();
                    foreach ($filterOptions as $option) {
                        $filterProperties = explode(":", $option);
                        if (count($filterProperties) == 2) {
                            $filterObject->{$filterProperties[0]} = $filterProperties[1];
                        }
                    }
                    array_push($filterArray, $filterObject);
                }
            }



            $updateSearchColumn = array();
            foreach ($selectColumn as $index=>  $column) {
                $position = strpos($column, " as ");
                if ($position !== false) {
					if($column == "getAgeGender(id) as Age_Gender"){
						if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105) {

							$tableBranch =$this->session->user_session->patient_table ." q1 ";
						}
						$column="(select group_concat(TIMESTAMPDIFF(YEAR, birth_date, CURDATE()),' / ',case when gender =1 then 'Male' else 'Female' end) from ".$tableBranch." where q1.id = q.id) as Age_Gender";
						$selectColumn[$index]=$column;
						array_push($updateSearchColumn, trim($column));
						//	continue;
					}else{
						array_push($updateSearchColumn, trim(str_replace("'", "", substr($column, ($position + 4)))));
					}
                   // array_push($updateSearchColumn, trim(str_replace("'", "", substr($column, ($position + 4)))));
                } else {
                    $selectColumn[$index]=" q.".$column;
                    array_push($updateSearchColumn, trim($column));
                }
            }

            $customerWhereCondition =null;
            $whereSelectColumns = array();
            if (count($whereCondition) > 0) {
                foreach ($whereCondition as $condition) {
                    $whereSection = explode("|", $condition);
                    $whereObject = new stdClass();
                    foreach ($whereSection as $section) {
                        $whereValues = explode(":", $section);
                        if (count($whereValues) == 2) {
                            if ($whereValues[0] == "whereTableColumn") {
                                $whereObject->column = $whereValues[1];

                            }
                            if ($whereValues[0] == "WhereColumnValue") {
                                $whereObject->value = $whereValues[1];
                            }

                            if ($whereValues[0] == "customWhereCondition") {
                                $customerWhereCondition =$this->replaceStringWithValue($whereValues[1],$queryParameter_hidden);
                            }
                        }
                        if (count($whereValues) == 3) {
                            if ($whereValues[0] == "whereTableColumn") {
                                $whereObject->column = $whereValues[1];
                            }
                            if ($whereValues[0] == "WhereColumnValue") {
                                $whereObject->value = ${$whereValues[1]};
                            }
                        }

                    }
                    if (property_exists($whereObject, "column") && property_exists($whereObject, "value")) {
                        $where[$whereObject->column] = $whereObject->value;
                        array_push($whereSelectColumns, $whereObject->column);
                        array_push($selectColumn, " q.".$whereObject->column);
                    }
                }
            }


            if (!is_null($this->input->post("filterColumn"))) {
                $whereColumn = $this->input->post("filterColumn");
                $whereValue = $this->input->post("filterByValue");
//                $where[$whereColumn] = $whereValue;
                if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id ==105)
                {
                    if($whereValue == 1){
                        $where['admission_date !='] = null;
                        $where['admission_date !='] = "0000-00-00 00:00:00";
                        $where['discharge_date ='] = null;
                    }else if($whereValue == 2){
                        $where['discharge_date !='] = null;
                        $where['discharge_date !='] = "0000-00-00 00:00:00";
                    }

                    if($whereColumn =="Zone"){
                        $where['roomid'] = $whereValue;
                    }

                    if($section_id==102 && ($whereValue != 1 || $whereValue != 2)){
						if($whereValue == 4){
							$where['admission_date !='] = null;
							$where['admission_date !='] = "0000-00-00 00:00:00";
							$where['date(admission_date) <='] =date('Y-m-d');
							$where['discharge_date ='] = null;
							$having['column']= 'ConsultCount';
							$having['value']= 0;
						}else if($whereValue == 3){
							$where['admission_date !='] = null;
							$where['admission_date !='] = "0000-00-00 00:00:00";
							$where['discharge_date ='] = null;
							$having['column']= 'ConsultCount';
							$having['value']= 0;
						}
					}
                }else{
                    $where[$whereColumn] = $whereValue;
                }
            }else{
                if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105)
                {
                    $where['admission_date !='] = null;
                    $where['admission_date !='] = "0000-00-00 00:00:00";
                    $where['discharge_date ='] = null;
                }
            }

            $actionArray = array();
            if ($resultObject->data->action_columns != "" && $resultObject->data->action_columns != null) {
                $actionStrings = explode(",", $resultObject->data->action_columns);
                foreach ($actionStrings as $action) {
                    $actionOptions = explode("|", $action);
                    $actionObject = new stdClass();
                    foreach ($actionOptions as $option) {
                        $actionProperties = explode(":", $option);
                        if (count($actionProperties) == 2) {
                            $actionObject->{$actionProperties[0]} = $actionProperties[1];
                        }
                    }
                    array_push($actionArray, $actionObject);
                }
            }
            $actionButton = array();
            $isActionExists = false;
            foreach ($actionArray as $index => $action) {
                if (property_exists($action, "actionButtonPrimary") && property_exists($action, "actionButtonType")) {
                    $icon = "<i class=''></i>";
                    $actionObject = new stdClass();
                    array_push($selectColumn, $action->actionButtonPrimary);
                    array_push($whereSelectColumns, $action->actionButtonPrimary);
                    if (property_exists($action, "actionButtonIcon")) {
                        $icon = "<i class='" . $action->actionButtonIcon . "'></i>";
                        $actionObject->icon = $icon;
                    }
                    if (property_exists($action, "actionButtonPrimary")) {
                        $actionObject->column = $action->actionButtonPrimary;
                    }
                    // if (property_exists($action, "actionButtonRedirectUrl")) {
                    // 	$url_string=explode('/', str_replace("#", '$', $action->actionButtonRedirectUrl));

                    // 	$actionObject->url=str_replace("#", '$', $action->actionButtonRedirectUrl);

                    // 	// $actionObject->url = $action->actionButtonRedirectUrl;
                    // }
                    // if (property_exists($action, "actionButtonCustomTemplateQueryParam")) {
                    // 	// $actionObject->queryParam =str_replace("#", '$', $action->actionButtonCustomTemplateQueryParam);
                    // 	$actiQParam=explode('@', $action->actionButtonCustomTemplateQueryParam);

                    // 	foreach ($actiQParam as $actiQvalue) {
                    // 		$expactiQvalue=explode('-', $actiQvalue);
                    // 		if(count($expactiQvalue)>1)
                    // 		{
                    // 			print_r(str_replace('#', '', $expactiQvalue[1]));
                    // 		}

                    // 	}
                    // 	$actionObject->queryParam = $action->actionButtonCustomTemplateQueryParam;
                    // }
                    // exit();
                    $actionObject->type = $action->actionButtonType;
                    $actionObject->index = $index;
                    $actionObject->section_id = $section_id;
                    $actionObject->elementID = $element_id;
                    if((int)$action->actionButtonType == 2){
                        if (property_exists($action, "actionButtonRedirectTemplate")) {
                            $actionObject->actionButtonRedirectTemplate = $action->actionButtonRedirectTemplate;
                        }
                    }


                    if ((int)$action->actionButtonType == 3) {
                        $actionButtonTemplate = "<button class='btn btn-sm' type='button'
						 onclick='dataTableExecution(`" . $element_id . "`," . $index . "," . $action->actionButtonType . ")'>" . $icon . "</button>";
                        $actionObject->text = $actionButtonTemplate;
                    }

                    if ((int)$action->actionButtonType == 4) {

                    }

                    array_push($actionButton, $actionObject);
                    $isActionExists = true;
                }
            }

            if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105) {

                $table =$this->session->user_session->patient_table ." q ";
            }


            $metaData = $this->MasterModel->getRows($_POST, $where, array_unique($selectColumn), $table, $searchColumn, $orderColumn,
                array($resultObject->data->order_column=> $orderDirection),null,null,$having,$customerWhereCondition);
            $last_query = $this->db->last_query();
            $filterCount = $this->MasterModel->countFiltered($_POST, $table, $where, $searchColumn, $orderColumn,
                array($resultObject->data->order_column, $orderDirection),$customerWhereCondition,$having,array_unique($selectColumn));

            $totalCount = $this->MasterModel->countAll($table, $where);
            $data = array();

            foreach ($metaData as $rowData) {

                $tempData = array();
                foreach ($updateSearchColumn as $columns) {

					if($section_id == '102' && $columns=='ConsultCount'){

					}else{
						if (array_search($columns, $whereSelectColumns) == false) {
							//array_push($tempData, $rowData->{$columns});
							//var_dump($columns);
							if(property_exists($rowData,$columns)){


								array_push($tempData, $rowData->{$columns});
							}else{
								$position = strpos($columns, "Age_Gender");
								if($position != false){

									array_push($tempData, $rowData->Age_Gender);
								}
							}
						}
					}

                }

                if ($isActionExists) {


                    if (count($actionButton) > 0) {
                        $actionButtonTemplate="<div class='d-flex'>";
                        if($section_id==101 || $section_id==102 || $section_id==103 || $section_id==104 || $section_id==105)
                        {
                           /* $actionButtonTemplate .='<a class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" href="'.base_url().'new_patients/'.$rowData->id.'">
								<img src="'.base_url().'assets/img/aadhaar_Logo.svg.png" style="width: 24px;height: 24px"></a>';*/
                            if($section_id==101)
                            {
								$actionButtonTemplate .='<a class="btn btn-reddit" onclick="getMedicVitals(2,'.$rowData->id.')" target="_blank"><img src="'.base_url().'assets/img/vitals-icon-GB.jpg" style="width: 24px;height: 24px"></a>';

                                $actionButtonTemplate .='<button class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" onclick="loadPatient('.$rowData->id.',`'.$rowData->patient_name.'`,`'.$rowData->adhar_no.'`,`'.$rowData->contact.'`,`'.base_url().'assets/img/avatar/avatar-1.png`,`'.$rowData->admission_date.'`,`2`,`1`,`1`)">
											<img src="'.base_url().'assets/img/sleeping.svg" style="width: 24px;height: 24px">
										</button>';

                            }
                            else if($section_id==102)
                            {
                                $actionButtonTemplate .='<button class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" onclick="loadPatient('.$rowData->id.',`'.$rowData->patient_name.'`,`'.$rowData->adhar_no.'`,`'.$rowData->contact.'`,`'.base_url().'assets/img/avatar/avatar-1.png`,`'.$rowData->Consultation_date.'`,`1`,`1`,`2`)">
											<img src="'.base_url().'assets/img/sleeping.svg" style="width: 24px;height: 24px">
										</button>';
                            }
                            else if($section_id==103)
                            {
                                $actionButtonTemplate .='<button class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" onclick="loadPatient('.$rowData->id.',`'.$rowData->patient_name.'`,`'.$rowData->adhar_no.'`,`'.$rowData->contact.'`,`'.base_url().'assets/img/avatar/avatar-1.png`,`'.$rowData->admission_date.'`,`2`,`undefind`,`3`)">
											<img src="'.base_url().'assets/img/sleeping.svg" style="width: 24px;height: 24px">
										</button>';
                            }
                            else if($section_id==104 || $section_id==105)
                            {
                                $actionButtonTemplate .='<button class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" onclick="loadPatient('.$rowData->id.',`'.$rowData->patient_name.'`,`'.$rowData->adhar_no.'`,`'.$rowData->contact.'`,`'.base_url().'assets/img/avatar/avatar-1.png`,`'.$rowData->admission_date.'`,2,1,1)">
											<img src="'.base_url().'assets/img/sleeping.svg" style="width: 24px;height: 24px">
										</button>';
                                $actionButtonTemplate .='<button class="btn btn-link" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="View Detail" onclick="loadPatient('.$rowData->id.',`'.$rowData->patient_name.'`,`'.$rowData->adhar_no.'`,`'.$rowData->contact.'`,`'.base_url().'assets/img/avatar/avatar-1.png`,`'.$rowData->admission_date.'`,`1`,`4`,`2`)">
                                            <i class="fas fa-user-md"></i>
                                        </button>';
                            }
                            $actionButtonTemplate .='<a class="btn btn-link" href="'.base_url().'get_patient_data/'.$rowData->id.'" target="_blank"><i class="fa fa-download"></i></a>';

                        }
                        else{
                            foreach ($actionButton as $button) {
                                if (property_exists($button, "column")) {
                                    if (array_search($button->column, $whereSelectColumns) !== false) {
                                        $button->value = $rowData->{$button->column};
                                        $actionButtonTemplate .= $this->getAllTemplateSection($button);

                                    }
                                }
                            }
                        }
                        $actionButtonTemplate .='</div>';
                        array_push($tempData, $actionButtonTemplate);
                    }
                }


                $data[] = $tempData;
            }
            $response = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $filterCount,
                "recordsFiltered" => $totalCount,
                "SearchColumn" => $updateSearchColumn,
                "data" => $data,
                "query" => $last_query
            );
        } else {
            $response = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => array()
            );
        }
        echo json_encode($response);
    }

    function replaceStringWithValue($customWhereCondition,$queryParameter_hidden){

        if($customWhereCondition !=""){
            $queryParameterString = base64_decode($queryParameter_hidden);
            $queryStringArray = (array)json_decode($queryParameterString);
            foreach ($queryStringArray as $key=>$value){
                $customWhereCondition=str_replace("#".$key,$value,$customWhereCondition);
            }
        }
        return $customWhereCondition;
    }


    function getAllTemplateSection($button)
    {

        $actionButtonTemplate = "";
        if ($button->type == 3) {
            $actionButtonTemplate = "<button class='btn btn-sm' type='button'
						 onclick='dataTableExecution(`" . $button->elementID . "`,`" .$button->section_id . "`," . $button->index . "," . $button->type . ",`" . $button->value . "`)'>" . $button->icon . "</button>";

        } else if($button->type == 4){
            $actionButtonTemplate = "<button class='btn btn-link' type='button' id='redirectButton".str_replace('#', '', $button->elementID)."'>" . $button->icon . "</button>
				<script> document.getElementById(redirectButton".str_replace('#', '', $button->elementID).").onclick = function () {
			        location.href = '<?php echo base_url();?>".$button->url."';
			    };
			    </script>";

        } else{
            $actionButtonTemplate = "<button class='btn btn-sm' type='button'
						 onclick='dataTableUpdate(`" .$button->elementID . "`,`" .$button->section_id . "`," . $button->index . "," . $button->type . ",`" . $button->value . "`,".$button->actionButtonRedirectTemplate.")'>" . $button->icon . "</button>";

        }
        return $actionButtonTemplate;
    }

    function executionButton()
    {
        $header = $this->is_parameter(array("transID", "elementID", "sectionID", "index"));
        if ($header->status) {

            $transValue = $header->param->transID;
            $elementID = str_replace("#", "", $header->param->elementID);
            $sectionId = $header->param->sectionID;
            $index = $header->param->index;

            $dataTable = $this->MasterModel->_select("datatable_query_master",
                array("elementID" => "#" . $elementID, "sectionID" => $sectionId),
                array("action_columns")
            );


            if ($dataTable->totalCount > 0) {

                $action_columns = $dataTable->data->action_columns;

                $actionArray = array();
                if ($action_columns != "" && $action_columns != null) {
                    $actionStrings = explode(",", $action_columns);
                    foreach ($actionStrings as $action) {
                        $actionOptions = explode("|", $action);
                        $actionObject = new stdClass();
                        foreach ($actionOptions as $option) {
                            $actionProperties = explode(":", $option);
                            if (count($actionProperties) == 2) {
                                $actionObject->{$actionProperties[0]} = $actionProperties[1];
                            }
                        }
                        array_push($actionArray, $actionObject);
                    }
                }

                if (count($actionArray) > 0) {
                    foreach ($actionArray as $actionObject) {

                        if ($actionObject->actionButtonType == 3) {
                            $executionQuery = $actionObject->actionButtonExecutionQuery;
                            if (strpos($executionQuery, $actionObject->actionButtonPrimary)) {
                                $sqlQuery = str_replace("#" . $actionObject->actionButtonPrimary, $transValue, $executionQuery);
                                if (!is_array($sqlQuery)) {
                                    $this->db->query($sqlQuery);
                                    if ($this->db->affected_rows() > 0) {
                                        $response["status"] = 200;
                                        $response["body"] = "Save Changes";
                                    } else {
                                        $response["status"] = 201;
                                        $response["body"] = "Failed To Save Changes";
                                    }
                                }
                            } else {
                                $response["status"] = 201;
                                $response["body"] = "Failed To Save Changes";
                                $response["error"] = "Query mapping failed";
                            }
                        }
                    }
                } else {
                    $response["status"] = 201;
                    $response["body"] = "Failed To Save Changes";
                    $response["error"] = "No Action Details Found";
                }
            } else {
                $response["status"] = 201;
                $response["body"] = "Failed To Save Changes";
                $response["error"] = "Action Template Not Found";
            }
        } else {
            $response["status"] = 201;
            $response["body"] = "Failed To Save Changes";
            $response["error"] = "Required Parameter Missing";
        }
        echo json_encode($response);
    }

    function getAllSection(){


        $resultObject = $this->MasterModel->_select("html_section_master",array("status"=>1),array("id","name"),false);

        $options ="";
        if($resultObject->totalCount >0){
            foreach ($resultObject->data as $section){
                $options .="<option value='".$section->id."'>".$section->name."</option>";
            }
        }
        $response["status"]=200;
        $response["body"]=$options;
        echo json_encode($response);

    }

    public function fetchTemplateDatatableData(){
        // print_r($this->input->post());exit();
        $validationObject = $this->is_parameter(array("section_id","element_id"));
        if ($validationObject->status) {
            $params = $validationObject->param;
            $section_id = $params->section_id;
            $element_id = $params->element_id;
            $resultObject = $this->MasterModel->_select("datatable_query_master",
                array("status" => 1, "elementID" => $element_id, "sectionID" => $section_id), array("*"));
            $data='';
            if($resultObject->totalCount>0)
            {
                $data=$resultObject->data;
            }
            $response['status']=200;
            $response['data']=$data;
            $response['body']='';
        }
        else
        {
            $response['status']=201;
            $response['body']='Something Went wrong';
        }
        echo json_encode($response);
    }
}
