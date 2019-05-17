$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#caste").focus();
	
	$(document).on('submit','#casteForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#casteForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'caste/caste_action';
            $("#cassavebtn").css('display', 'none');
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
                        var addurl = basepath + "caste/addcaste";
                        var listurl = basepath + "caste";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#cas_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#cassavebtn").css({
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
	
	


	

});

function validate()
{  
	var caste = $("#caste").val();
	$("#casmsg").text("").css("dispaly", "none").removeClass("form_error");
	if(caste=="")
	{
		$("#caste").focus();
		$("#casmsg")
		.text("Error : Enter Caste")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}
