$( document ).ready(function() {
    var basepath = $("#basepath").val();
    
   $('#main_category1').on('change',function(){
    $("#div_sub_category2").hide();
    $("#div_sub_category1").show();
   });
   $('#main_category2').on('change',function(){
    $("#div_sub_category1").hide();
    $("#div_sub_category2").show();
   });

   $(document).on('submit','#groupForm',function(e){
    e.preventDefault();
    
    if(groupFormValidation())
    {        
    
        var formDataserialize = $("#groupForm").serialize();
        // alert(formDataserialize);
        // console.log(formDataserialize);
        var type = "POST"; //for creating new resource
        var urlpath = basepath + 'accounts/GroupInsert';
        $("#cassavebtn").css('display', 'none');
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
                    var addurl = basepath + "accounts/group";
                    var listurl = basepath + "accounts";
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

function groupFormValidation()
{
   if($('#group_description').val()=="")
   {
    $("#group_description_div").addClass('has-error');
    $("#group_description").focus();
    return false;
   }
   if($("input[name='main_category']:checked").val() == null)
   {
    $("#group_description_div").removeClass('has-error');
    $("#main_category_div").addClass('has-error');
    $("#main_category1").focus();
    return false;
   }
   if($("#main_category1:checked").val() != null)
   {
        $("#group_description_div").removeClass('has-error');
        if($("#div_sub_category1 input[name='sub_category']:checked").val() == null)        {
            $("#main_category_div").removeClass('has-error');
            $("#div_sub_category1").addClass('has-error');
           
            return false;
        }
   }
   if($("#main_category2:checked").val() != null)
   {       
        $("#group_description_div").removeClass('has-error');
        if($("#div_sub_category2 input[name='sub_category']:checked").val() == null)
        {
            $("#main_category_div").removeClass('has-error');
            $("#div_sub_category2").addClass('has-error');
           
            return false;
        }
   }
   return true;
}