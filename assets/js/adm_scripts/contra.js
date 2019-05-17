$(document).ready(function(){
    var basepath = $("#basepath").val();
    var acnt_dt_start=$('#acnt_dt_start').val();
    var acnt_dt_end=$('#acnt_dt_end').val();
   
        $("#voucher_date").datepicker({
          format: 'mm/dd/yyyy',
          startDate: acnt_dt_start,
          endDate:acnt_dt_end    
        });

    $('.deleteBtn').click(function() {
        var splitid=$(this).attr("id").split('_');
        var id=splitid[1];
        var voucher_id=parseInt($('#deleteBtn_'+id).data('text')); 
       
        // alert(fees_id); 
        $.confirm({
            title: 'Confirm!',
            content: 'Are you Sure you want to delete ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: basepath+'contra/deleteContraVoucher',
                        data: {voucher_id:voucher_id},
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                        success: function(result) {
                            if (result.msg_status == 200) {                 
                                
                                $("#modal-success").modal({
                                    "backdrop": "static",
                                    "keyboard": true,
                                    "show": true
                                });
                                var addurl = basepath + "contra";
                            
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
                                var addurl = basepath + "contra";
                            
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

    $(document).on('keyup','#debit_amount',function(e){
        e.preventDefault(); 
        
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {                
            $('#debit_amount').val($('#debit_amount').val().replace(/[^\d.]/g, ''));
        } 
        var amount=$('#debit_amount').val();       
        $('#credit_amount').val(amount);
        $('#total_debit').val(amount);
        $('#total_credit').val(amount);
    });

    $(document).on('keyup','#credit_amount',function(e){
        e.preventDefault(); 
        
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {                
            $('#credit_amount').val($('#credit_amount').val().replace(/[^\d.]/g, ''));
        }
        var amount=$('#credit_amount').val();
        $('#debit_amount').val(amount);
        $('#total_debit').val(amount);
        $('#total_credit').val(amount);
    });


    $('#credit_ac, #debit_ac').change(function () {
        var credit_ac=$('#credit_ac option:selected').val();
        var debit_ac=$('#debit_ac option:selected').val();
        $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
        $('#debit_ac_div').removeClass('has-error');
        $('#credit_ac_div').removeClass('has-error');
        if(credit_ac==debit_ac && credit_ac!="" && debit_ac!="")
        {
            $('#debit_ac_div').addClass('has-error');
            $('#credit_ac_div').addClass('has-error');
            $("#clsmsg")
                .text("Error : Debit and Credit Account Can not be same !")
                .addClass("form_error")
                .css("display", "block");
            return false;            
        }
        return true;        
     });


     $(document).on('submit','#ContraForm',function(e){
        e.preventDefault();    
        if(fromValidate())
        {        
        
            var formDataserialize = $("#ContraForm").serialize();
            // alert(formDataserialize);
            // console.log(formDataserialize);
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'contra/insertUpdate';
            $("#contrasavebtn").css('display', 'none');
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
                        var addurl = basepath + "contra/contra";
                        var listurl = basepath + "contra";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);
    
                    }else {
                        $("#cas_response_msg").text(result.msg_data);
                    }
                    
                    $("#loaderbtn").css('display', 'none');
                    
                    $("#contrasavebtn").css({
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


});// document ready end

function fromValidate()
{    
    $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
    $('#debit_ac_div').removeClass('has-error');
    $('#credit_ac_div').removeClass('has-error');
    $("#narration").removeClass('has-error');
    $('#debit_amount').removeClass('has-error');
    $('#credit_amount').removeClass('has-error');
    var credit_ac=$('#credit_ac option:selected').val();
    var debit_ac=$('#debit_ac option:selected').val();
    var credit_amount=$('#credit_amount').val();
    var debit_amount=$('#debit_amount').val();

    if ($("#voucher_date").val()=="") {
        $('#voucher_date_div').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Enter Voucher Date !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }

    if ($("#narration").val()=="") {
        $('#div_narration').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Enter Narration !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }  
    
    if (debit_amount=="") {
        $('#div_debit_amount').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Enter Debit Amount !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }

    if (credit_amount=="") {
        $('#div_credit_amount').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Enter Credit Amount !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }

    if ($('#debit_ac option:selected').val()=="") {
        $('#debit_ac_div').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Select a Debit Account !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }
    if ($('#credit_ac option:selected').val()=="") {
        $('#credit_ac_div').addClass('has-error');
        $("#clsmsg")
            .text("Error : Please Select a Credit Account !")
            .addClass("form_error")
            .css("display", "block");
        return false ;
    }
    if(credit_ac==debit_ac && credit_ac!="" && debit_ac!="")
    {
        $('#debit_ac_div').addClass('has-error');
        $('#credit_ac_div').addClass('has-error');
        $("#clsmsg")
            .text("Error : Debit and Credit Account Can not be same !")
            .addClass("form_error")
            .css("display", "block");
        return false;            
    }
    
       
    
    return true;
}