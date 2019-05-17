$( document ).ready(function() {
    var basepath = $("#basepath").val();

    $(document).on('change','#group_id',function(e){
        var group_id=$('#group_id option:selected').data('tokens');
        if (group_id=='Y') {
            $('#bankdetails').show();
           
        }else{
            $('.desablecls').val('');
            $('#bankdetails').hide();
        }
    });
  

  $(document).on('submit','#accountForm',function(e){
    e.preventDefault();    
    if(accountFormValidation())
    {        
    
        var formDataserialize = $("#accountForm").serialize();
        // alert(formDataserialize);
        // console.log(formDataserialize);
        var type = "POST"; //for creating new resource
        var urlpath = basepath + 'accounts/accountAddEdit';
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
                    var addurl = basepath + "accounts/account";
                    var listurl = basepath + "accounts/accountList";
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


});/* end of document ready */


function accountFormValidation()
{
    $('#account_name_div').removeClass('has-error');
    $('#group_id_div').removeClass('has-error');
    $('#bank_ifsc_div').removeClass('has-error');
    $('#bank_ac_no_div').removeClass('has-error');
    $('#bank_address_div').removeClass('has-error');
    $('#bank_branch_div').removeClass('has-error');

    if($('#account_name').val()=="")
    {
        $('#account_name_div').addClass('has-error');
        return false;
    }
    if($('#group_id option:selected').val()=="0")
    {        
        $('#group_id_div').addClass('has-error');
        return false;
    }

    if($('#group_id option:selected').data('tokens')=='Y')
    {
        if($('#bank_ifsc').val()=="") {
            $('#bank_ifsc_div').addClass('has-error');
            return false;
        }

        if($('#bank_ac_no').val()=="") {
            $('#bank_ac_no_div').addClass('has-error');
            return false;
        }
        if($('#bank_address').val()=="") {
            $('#bank_address_div').addClass('has-error');
            return false;
        }
        if($('#bank_branch').val()=="") {
            $('#bank_branch_div').addClass('has-error');
            return false;
        }
    }

    return true;
}