$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	

    /* check roll no */
    $(document).on('keyup','.roll_no',function(e){
        e.preventDefault();       
       var roll_input_id= $(this).attr('id');
       var id=$(this).attr('id').split('_')[2];
       var section=$('#classList_'+id+' option:selected').val();
       var roll_no=$('#'+roll_input_id).val();
       var student_id=$('#student_id_'+id).val();
       var class_id=$('#class_id_'+id).val();
       var school_id=$('#school_id_'+id).val();
       var acdm_session_id=$('#acdm_session_id_'+id).val();
       $("#select_error_"+id).hide();
       $("#section_"+id).removeClass('has-error');
       
        if(section!="")
        {
            $("#roll_"+id).removeClass('has-error');
            $("#error_"+id).hide();
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
            {                
                $('#'+roll_input_id).val($('#'+roll_input_id).val().replace(/[^\d.]/g, ''));

            }
                var type = "POST"; //for creating new resource
                var urlpath = basepath + 'sectionandroll/checkRoll';
                $("#section_"+id).removeClass('has-error');
                $('#roll_'+id).removeClass("has-error");
                $("#error_"+id).hide();
            
                $.ajax({
                        type: type,
                        url: urlpath,
                        data: {
                            rollno:roll_no,
                            section_id:section,
                            student_id:student_id,
                            class_id:class_id,
                            school_id:school_id,
                            acdm_session_id:acdm_session_id
                        },
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        success: function(result) {                      
                            
                            // alert(result.msg_status);
                            if (result.msg_status == 200) {
            
                                $("#"+roll_input_id).css("background-color","#FFF");
                            } 
                            else {
                                        
                                        $("#"+roll_input_id).focus();                                    
                                        $('#roll_'+id).addClass("has-error");                               
                                        $("#"+roll_input_id).css("background-color","#FFD2D2");
                                        // $("#error_"+id).show();
                                        $("#error_"+id)
                                            .text("Roll no already assigned!")		
                                            .css("display", "block");
                                        
                            }
                            
                        
                        },
                        error: function(jqXHR, exception) {
                            var msg = '';
                        }
                    });
            
        }else{
            $("#section_"+id).addClass('has-error');
            $("#select_error_"+id)
            .text("Select a Class to Assign Roll!")		
            .css("display", "block");
            return false;
        }
     

    });
	

});//document ready end

function validate()
{  
	var section = $("#classList option:selected").val();
	$("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
	if(section=="")
	{
		$("#classList").focus();
		$("#clsmsg")
		.text("Error : Select Class")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}

function UpdateRollSection(btn)
{
    var basepath = $("#basepath").val();
    var id=$(btn).attr('id').split('_')[1];
    var btn_id=$(btn).attr('id');
    var section=$('#classList_'+id+' option:selected').val();//section id
    var roll_no=$('#roll_no_'+id).val();
    if(updateValidate(roll_no,section,id))
    {
        $('#'+btn_id).hide();
        $('#loaderbtn_'+id).show();
        var student_id=$('#student_id_'+id).val();
        var class_id=$('#class_id_'+id).val();
        var school_id=$('#school_id_'+id).val();
        var acdm_session_id=$('#acdm_session_id_'+id).val();
        $.ajax({
            type: "POST",
            url: basepath+'sectionandroll/updateRollSection',
            data:{
                "section_id":section,
                "rollno":roll_no,
                "student_id":student_id,
                "class_id":class_id,
                "school_id":school_id,
                "acdm_session_id":acdm_session_id
            } ,
            dataType: 'html',
            // contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
            success: function (result) {
                $('#'+btn_id).show();
                $('#loaderbtn_'+id).hide();
                viewList();                    
                $('.selectpicker').selectpicker();
                $('.dataTables').DataTable();                            
                
                
            }, 
            error: function (jqXHR, exception) {
                  var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                   // alert(msg);  
                }
            }); /*end ajax call*/
    }   
    
    // alert(section);
}

function updateValidate(roll,section,id)
{
    $("#section_"+id).removeClass('has-error');
    $("#roll_"+id).removeClass('has-error');
    $("#select_error_"+id).hide();
    $("#error_"+id).hide();
    if(section=="")
    {
        $("#section_"+id).addClass('has-error');
        $("#select_error_"+id)
		.text("Error : Select Class")		
        .css("display", "block");        
        return false;
    }
    if(roll=="")
    {                
        $("#roll_"+id).addClass('has-error');
        $("#error_"+id)
		.text("Error : Enter Roll")		
        .css("display", "block");
        return false;
    }
    
    return true;

}


function viewList() 
{
    var basepath = $("#basepath").val();
    if(validate())
	{            
                   var formDataserialize = $("#StudentListForm" ).serialize();
                    formDataserialize = decodeURI(formDataserialize);
                    console.log(formDataserialize);
                    var formData = {formDatas: formDataserialize};
                    
                    $(".dashboardloader").css("display","block");
        
                    $.ajax({
                        type: "POST",
                        url: basepath+'sectionandroll/sectionRollAssignmentStudentList',
                        data: formData,
                        dataType: 'html',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                        success: function (result) {
                            
                            $("#loadStudentList").html(result);
                            $('.selectpicker').selectpicker();
                            $('.dataTables').DataTable();                            
                            $(".dashboardloader").css("display","none");
                            
                        }, 
                        error: function (jqXHR, exception) {
                              var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'Not connect.\n Verify Network.';
                                } else if (jqXHR.status == 404) {
                                    msg = 'Requested page not found. [404]';
                                } else if (jqXHR.status == 500) {
                                    msg = 'Internal Server Error [500].';
                                } else if (exception === 'parsererror') {
                                    msg = 'Requested JSON parse failed.';
                                } else if (exception === 'timeout') {
                                    msg = 'Time out error.';
                                } else if (exception === 'abort') {
                                    msg = 'Ajax request aborted.';
                                } else {
                                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                }
                               // alert(msg);  
                            }
                        }); /*end ajax call*/
        	
		}
}
