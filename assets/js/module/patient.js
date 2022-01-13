// $(document).ready(function(){
// 		alert("hii");
// });

function add_patient()
{
	
  
    var formdata=$("#doctor_form").serialize();
    // alert(formdata);
    $.ajax({
            type:'POST',
            url:"http://localhost/new_covid/"+"patientController/add_patient",
            data:formdata,
            success:function(resp)
            {
                // alert(resp);
                if (resp==0) {
                    alert('');
                }
                else
                {
                   
                    setTimeout(function()
                    {
                        window.location.href=baseURL+"view_patients";
                    },3000);
                }
            }

        });
}

function search()
{
	// alert("hii");
	var id = $('#adhhar_no').val();
	// alert(id);
	 $.ajax({
            type:'POST',
            url:"http://localhost/new_covid/"+"patientController/search/"+id,
            data:'',
            success:function(success)
            {
                // alert(resp);
               
                	// console.log(resp);
                	success = JSON.parse(success);
                    var data=success.xml_arr;
               		console.log(data['id']);
                   
                    // setTimeout(function()
                    // {
                    //     window.location.href=baseURL+"view_patients";
                    // },3000);
              
            }

        });

}