$( document ).ready(function() {
    var basepath = $("#basepath").val();

  

  $(document).on('submit','#vendorForm',function(e){
    e.preventDefault();    
    if(vendorFormValidation())
    {        
    
        var formDataserialize = $("#vendorForm").serialize();
        // alert(formDataserialize);
        // console.log(formDataserialize);
        var type = "POST"; //for creating new resource
        var urlpath = basepath + 'vendor/AddEditVendor';
        $("#vendorsavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'block');

        $.ajax({
            type: type,
            url: urlpath,
            data: formDataserialize,
            success: function(result) {
                // alert(result.msg_status);
                if (result.msg_status == 200) {
                        
                    $("#suceessmodal").modal({
                        "backdrop": "static",
                        "keyboard": true,
                        "show": true
                    });
                    var addurl = basepath + "vendor/vendor";
                    var listurl = basepath + "vendor";
                    $("#responsemsg").text(result.msg_data);
                    $("#response_add_more").attr("href", addurl);
                    $("#response_list_view").attr("href", listurl);

                } 
                else {
                    $("#cas_response_msg").text(result.msg_data);
                }
                
                $("#loaderbtn").css('display', 'none');
                
                $("#vendorsavebtn").css({
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

function vendorFormValidation()
{
    $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
    $("#vendor_name_div").removeClass('has-error');
    $("#state_id_div").removeClass('has-error');
    $("#group_id_div").removeClass('has-error');
    if($('#vendor_name').val()=="")
    {        
        $("#vendor_name_div").addClass('has-error');
        $("#vendor_name").focus();
		$("#clsmsg")
		.text("Error : Enter Name")
		.addClass("form_error")
        .css("display", "block");
		return false;
    }
    if($('#state_id option:selected').val()=="")
    {
        $("#state_id_div").addClass('has-error');
		$("#clsmsg")
		.text("Error : Select State")
		.addClass("form_error")
        .css("display", "block");
		return false;
    }
    if($('#group_id option:selected').val()=="")
    {
        $("#group_id_div").addClass('has-error');
		$("#clsmsg")
		.text("Error : Select Account Group")
		.addClass("form_error")
        .css("display", "block");
		return false;
    }


    return true;
}