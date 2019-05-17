$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#caste").focus();
     $('.selectpicker').selectpicker({
    dropupAuto: false
    });

      var mode=$("#mode").val();
            
              if (mode=='EDIT') {

            var  selected_roles = $("#selected_month_ids").val();

            var selected_attr = selected_roles.split(',');
            $("#sel_month").selectpicker("val", selected_attr);
           // $('#sel_role').selectpicker('refresh');

                }
	
	$(document).on('submit','#feesComponentForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#feesComponentForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'feescomponent/feesComponent_action';
            $("#feescomavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'block');

            $.ajax({
                type: type,
                url: urlpath,
                data: formData,
                dataType: 'json',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(result) {
					if (result.msg_status == 200) {
							
                        $("#suceessmodal").modal({
                            "backdrop": "static",
                            "keyboard": true,
                            "show": true
                        });
                        var addurl = basepath + "feescomponent/addFeesComponent";
                        var listurl = basepath + "feescomponent";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#feescom_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#feescomavebtn").css({
                        "display": "block",
                        "margin": "0 auto"
                    });
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
			
			
		}

    });
    
	
    $('.deleteBtn').click(function() {
        var splitid=$(this).attr("id").split('_');
        var id=splitid[1];
        var fees_id= $('#deleteBtn_'+id).data('text'); 
       
        // alert(fees_id); 
        $.confirm({
            title: 'Confirm!',
            content: 'Are you Sure you want to delete ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: basepath+'feescomponent/deleteFeesComponent',
                        data: {fees_id:fees_id},
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        success: function(result) {
                            if (result.msg_status == 200) {                 
                                
                                $("#modal-success").modal({
                                    "backdrop": "static",
                                    "keyboard": true,
                                    "show": true
                                });
                                var addurl = basepath + "feescomponent";
                            
                                $("#appendBody").text(result.msg_data);
                                $("#redirectToListsuccess").attr("href", addurl);

                            } 
                            else {
                                // alert(fees_id+" have data");                    
                                $("#modal-danger").modal({
                                    "backdrop": "static",
                                    "keyboard": true,
                                    "show": true
                                });
                                var addurl = basepath + "feescomponent";
                            
                                $("#dengAppendBody").text(result.msg_data);
                                $("#redirectToListerror").attr("href", addurl);
                            
                                
                            }                
                            
                        },
                        error: function(jqXHR, exception) {
                            var msg = '';
                        }
                    });
                },
                cancel: function () {
                    // $.alert('Canceled!');
                }
            }
        });
              
    });


	

});/* end of document ready */

function validate()
{  
	var fees_desc = $("#fees_desc").val();
    var months =$('#sel_month').val().length;
    
	$("#feescommsg").text("").css("dispaly", "none").removeClass("form_error");
	if(fees_desc=="")
	{
		$("#fees_desc").focus();
		$("#feescommsg")
		.text("Error : Enter Fees Description")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}

    if(months=="0")
    {
        $("#fees_desc").focus();
        $("#feescommsg")
        .text("Error : Select Month")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }
	return true;
}
