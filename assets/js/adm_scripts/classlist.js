$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#classname").focus();
	
	$(document).on('submit','#classForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#classForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'classlist/class_action';
            $("#clsavebtn").css('display', 'none');
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
                        var addurl = basepath + "classlist/addclass";
                        var listurl = basepath + "classlist";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#cls_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#clsavebtn").css({
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
	
	

	// Set Status
    $(document).on("click", ".symtomstatus", function() {
       
		var uid = $(this).data("syid");
        var status = $(this).data("setstatus");
        var url = basepath + 'symptoms/setStatus';
        setActiveStatus(uid, status, url);

    });

	

});

function validate()
{  
	var classname = $("#classname").val();
	$("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
	if(classname=="")
	{
		$("#classname").focus();
		$("#clsmsg")
		.text("Error : Enter Class Name")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}
