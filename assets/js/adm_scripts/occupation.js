$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#occupation").focus();
	
	$(document).on('submit','#occupationForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#occupationForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'occupation/occupation_action';
            $("#occsavebtn").css('display', 'none');
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
                        var addurl = basepath + "occupation/addoccupation";
                        var listurl = basepath + "occupation";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#occ_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#occsavebtn").css({
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
	var occupation = $("#occupation").val();
	$("#occmsg").text("").css("dispaly", "none").removeClass("form_error");
	if(occupation=="")
	{
		$("#occupation").focus();
		$("#occmsg")
		.text("Error : Enter Occupation")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}
