$(document).ready(function(){
   
	var basepath = $("#basepath").val();
	$("#section").focus();
	
	$(document).on('submit','#religionForm',function(e){
		e.preventDefault();
		
		if(validate())
		{
			
		
            var formDataserialize = $("#religionForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'religion/religion_action';
            $("#relsavebtn").css('display', 'none');
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
                        var addurl = basepath + "religion/addreligion";
                        var listurl = basepath + "religion";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#rel_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#relsavebtn").css({
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
	var religion = $("#religion").val();
	$("#relmsg").text("").css("dispaly", "none").removeClass("form_error");
	if(religion=="")
	{
		$("#religion").focus();
		$("#relmsg")
		.text("Error : Enter Religion")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}
	return true;
}
