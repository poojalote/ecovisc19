<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('_partials/header');
$this->load->view('Form_Show/form_navigation');
?>
<style>
	.div_display{
		height: auto !important;
		width: auto !important;
		padding: 4px !important;
        top:0px !important;
	}
	.spanLabel {
		background-color: transparent !important;
		padding: 4px;
	}
    p{
        height: auto !important;
    }
    #div_79,#div_68{
        position: unset !important;
    }
</style>
<div class="main-content">
	<section class="section">
		<div class="section-header">
            <?php if($report_id == 12){

            } ?>
            <button class="btn btn-primary" type="button" style="margin-left: auto;" id="printButton" onclick="print_div()">PRINT</button>
		</div>
		<input type="hidden" id="dep_id"value="<?php echo $dep_id ?>">
		<input type="hidden" id="report_id"value="<?php echo $report_id ?>">
		<input type="hidden" id="string_param" value="<?php echo $string_param ?>">
		<div class="section-body">
			<div class="">

				<div class="">
					<div class="card">
						<div class="section-body_new" id="showDataReport">

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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<?php $this->load->view('_partials/footer'); ?>


<style>
	.spanLabel{
		background-color: #0c0c0c24;
		padding: 4px;
	}
</style>

<script>
	let base_url='<?= base_url() ?>';
	// A $( document ).ready() block.
	$( document ).ready(function() {
		var dep_id=$("#dep_id").val();
		var report_id=$("#report_id").val();
		var string_param=$("#string_param").val();
		getDataReport(report_id,string_param);
        get_DepartMent_Menus(dep_id,report_id,string_param)
	});
	
	function getDataReport(report_id,string_param) {
		let formData = new FormData();
		formData.append('report_id',report_id);
		formData.append('string_param',string_param);
		app.request(base_url+"GetReportView",formData).then(response => {
			if (response.status === 200) {
				$("#showDataReport").html(response.data);

				$(".removeDeleteButton").remove();
				$(".ui-resizable-handle").remove();
				$("[contenteditable='true']").each((i,e)=>{
					$(e).attr("contenteditable",false);
				});
			} else {

			}
		});
	}
    function print_div() {
        let divName=".section-body_new";
        $('#printButton').toggleClass('d-none');
        var printContents = document.querySelector(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        $('#printButton').toggleClass('d-none');
    }
    function get_DepartMent_Menus(department_id,section_id,queryparameter_hidden)
    {

        var formData = new FormData();
        formData.set("department_id", department_id);
        formData.set("section_id", section_id);
        formData.set("queryparameter_hidden", queryparameter_hidden);
        $.ajax({
            type: "POST",
            url:  "<?php echo base_url();?>getDepartmentMenus",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (result) {

                if (result.status === 200) {
                    $("#form_navigation_menu").empty();
                    // app.errorToast("hiiiiiii");
                    var userdata=result.data;
                    if(userdata!=null)
                    {
                        for(var i=0;i<userdata.length;i++)
                        {

                            if(section_id=="null" || section_id==0)
                            {
                                if(i==0){
                                    section_id=userdata[i].id;
                                }
                            }
                            var newOBJ=null;
                            if(userdata[i].query_string_parameter!=null && userdata[i].query_string_parameter!="")
                            {
                                var stringParaData=userdata[i].query_string_parameter;
                                var data_array=stringParaData.split(',');
                                var Obj={};
                                var queryparameter_hidden = $("#string_param").val();
                                //console.log(queryparameter_hidden);
                                let qObject = atob(queryparameter_hidden);
                                //    console.log(qObject);
                                qObject.split("&").map(i=>{
                                    let item = i.split("=");
                                        Obj[item[0]]=item[1];
                                })
                                // $.each(data_array, function(i, field) {
                                //     var field1=field.split("&");
                                //     if(qObject.hasOwnProperty(field1[0])){
                                //         Obj[field1[0]]=qObject[field1[0]];
                                //     }
                                //
                                // });
                                //console.log(Obj);
                                newOBJ=JSON.stringify(Obj);
                                newOBJ=btoa(newOBJ);

                            }
                            var pathArray = window.location.pathname.split('/');
                            let isActive = false;
                            if("html_navigation" === pathArray[1]){
                                if(department_id === pathArray[2]){
                                    if(userdata[i].id === pathArray[3]){
                                        isActive=true;
                                    }
                                }
                            }
                            let style = isActive ?'color: white;text-decoration: none;' :'color: black;text-decoration: none;'
                            let active = isActive ?'menu-header_section active':'menu-header_section1';
                            var template=`
								<a href="<?php echo base_url(); ?>html_navigation/${department_id}/${userdata[i].id}/${newOBJ}" class=""
								  style="${style}">
									<li class="menu-header mt-2 ${active}">${userdata[i].name}</li>
								</a>`;
                            var templateMobileView=`
								<a href="<?php echo base_url(); ?>html_navigation/${department_id}/${userdata[i].id}/${newOBJ}" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="${userdata[i].name}"
								style="<?php echo $this->uri->segment(1) == 'html_navigation/<?php echo $department_id?>/<?php echo $userdata[i].id?>' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
									<i class="fas fa-file-medical-alt"></i>
								</a>
								`
                            $("#form_navigation_menu").append(template);
                            $("#from_navigation_menu_mobile").append(templateMobileView);
                        }

                       // get_forms(section_id);
                    }
                    if(result.hasOwnProperty("report")){
                        let report = result.report;
                        report.forEach(r=>{

                            let department_id =r.id;
                            var newOBJ=null;
                            var stringParaData=r.query_param;
                            var data_array=stringParaData.split(',');
                            var queryparameter_hidden = $("#string_param").val();
                            //console.log(queryparameter_hidden);
                            let qObject = atob(queryparameter_hidden);
                            //    console.log(qObject);
                            qObject.split("&").map(i=>{
                                let item = i.split("=");
                                Obj[item[0]]=item[1];
                            })

                            newOBJ=JSON.stringify(Obj);
                            newOBJ=btoa(newOBJ);

                            let isActive = false;
                            if("html_navigation" === pathArray[1]){
                                if(department_id === pathArray[2]){
                                    if(userdata[i].id === pathArray[3]){
                                        isActive=true;
                                    }
                                }
                            }

                            let style = isActive ?'color: white;text-decoration: none;' :'color: black;text-decoration: none;'
                            let active = isActive ?'menu-header_section active':'menu-header_section1';
                            var template=`
								<a href="<?php echo base_url(); ?>GetQueryParamDataReport/${department_id}/${newOBJ}" class=""
								  style="${style}">
									<li class="menu-header mt-2 ${active}">${r.Report_name}</li>
								</a>`;
                            var templateMobileView=`
								<a href="<?php echo base_url(); ?>GetQueryParamDataReport/${department_id}/${newOBJ}" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="${r.Report_name}"
								style="<?php echo $this->uri->segment(1) == 'html_navigation/<?php echo $department_id?>/<?php echo $userdata[i].id?>' ? 'color: white;text-decoration: none;' : 'color: black;text-decoration: none;'; ?>">
									<i class="fas fa-file-medical-alt"></i>
								</a>
								`
                            $("#form_navigation_menu").append(template);
                            $("#from_navigation_menu_mobile").append(templateMobileView);
                        });
                    }

                } else {
                    app.errorToast(result.body);
                }
            }, error: function (error) {

                app.errorToast('something went wrong');
            }
        });
    }
</script>
