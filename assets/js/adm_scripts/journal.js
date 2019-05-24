$(document).ready(function(){
    var basepath = $("#basepath").val();
    var acnt_dt_start=$('#acnt_dt_start').val();
    var acnt_dt_end=$('#acnt_dt_end').val();
   
        $("#voucher_date").datepicker({
          format: 'mm/dd/yyyy',
          startDate: acnt_dt_start,
          endDate: acnt_dt_end    
        });
    
    $('#add').click(function(){
      
        var size=parseInt($('#serial_id').val());
        var count=size+1;
             
        $.ajax({
            url: basepath + "journal/addMore",
            type: 'post',
            data: {count:count},
            success: function(data) {
            //  $(".addmore").show()
            $('#serial_id').val(count);
             $(".addmore").prepend(data);
             $('.selectpicker').selectpicker();                              
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
                   console.log(msg);  
                }
        });
    });

    $(document).on('click','.btn_remove', function(){
        var id = $(this).attr("data-id");
        // var serial=$('#serial_id').val();
        // $('#serial_id').val(parseInt(serial-1));
        $("#row_"+id).remove();
        AmountDetail();
    });

    $(document).on('keyup','.amount',function(e){
        e.preventDefault();         
        var id=$(this).attr('data-id'); 
        // alert(id);       
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {                
            $('#amount_'+id).val($('#amount_'+id).val().replace(/[^\d.]/g, ''));
        } 
        AmountDetail();
       
    });

    $(document).on('change', ".ac_tag", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        AmountDetail();       
        var id=$(this).attr('data-id');
        var ac_tag=$(this).val();
       getDebitCrediteComparison(ac_tag,id);
        // alert(id+' '+ac_tag);
   });


     $(document).on('submit','#JournalForm',function(e){
        e.preventDefault();    
        
        if(fromValidate())
        {        
            if(detailvalidation())
            {        
                if(getDebitCreditEqualValidation())
                {
                    var formDataserialize = $("#JournalForm").serialize();
                    // alert(formDataserialize);
                    // console.log(formDataserialize);
                    var type = "POST"; //for creating new resource
                    var urlpath = basepath + 'journal/insertUpdate';
                    $("#journalsavebtn").css('display', 'none');
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
                                var addurl = basepath + "journal/journal";
                                var listurl = basepath + "journal";
                                $("#responsemsg").text(result.msg_data);
                                $("#response_add_more").attr("href", addurl);
                                $("#response_list_view").attr("href", listurl);
            
                            }else {
                                $("#cas_response_msg").text(result.msg_data);
                            }
                            
                            $("#loaderbtn").css('display', 'none');
                            
                            $("#journalsavebtn").css({
                                "display": "block",
                                "margin": "0 auto"
                            });
                        },
                        error: function(jqXHR, exception) {
                            var msg = '';
                        }
                    });
                    
                } 
            }
        }
    
    });


    // $('.deleteBtn').click(function() {
    //     var splitid=$(this).attr("id").split('_');
    //     var id=splitid[1];
    //     var voucher_id=parseInt($('#deleteBtn_'+id).data('text')); 
       
    //     alert(voucher_id); 
    //     $.confirm({
    //         title: 'Confirm!',
    //         content: 'Are you Sure you want to delete ?',
    //         buttons: {
    //             confirm: function () {
    //                 $.ajax({
    //                     type: 'POST',
    //                     url: basepath+'journal/deleteVoucher',
    //                     data: {voucher_id:voucher_id},
    //                     dataType: 'json',
    //                     contentType: "application/x-www-form-urlencoded; charset=UTF-8",
    //                     success: function(result) {
    //                         if (result.msg_status == 200) {                 
                                
    //                             $("#modal-success").modal({
    //                                 "backdrop": "static",
    //                                 "keyboard": true,
    //                                 "show": true
    //                             });
    //                             var addurl = basepath + "journal";
                            
    //                             $("#appendBody").text(result.msg_data);
    //                             $("#redirectToListsuccess").attr("href", addurl);

    //                         } 
    //                         else {
    //                             // alert(fees_id+" have data");                    
    //                             $("#modal-danger").modal({
    //                                 "backdrop": "static",
    //                                 "keyboard": true,
    //                                 "show": true
    //                             });
    //                             var addurl = basepath + "journal";
                            
    //                             $("#dengAppendBody").text(result.msg_data);
    //                             $("#redirectToListerror").attr("href", addurl);
                            
                                
    //                         }                
                            
    //                     },
    //                     error: function(jqXHR, exception) {
    //                         var msg = '';
    //                     }
    //                 });
    //             },
    //             cancel: function () {
    //                 // $.alert('Canceled!');
    //             }
    //         }
    //     });
              
    // });



    $(document).on('click','.deleteBtn',function()
    {
        var splitid=$(this).attr("id").split('_');
        var id=splitid[1];
        var voucher_id=parseInt($('#deleteBtn_'+id).data('text')); 
       
      //  alert(voucher_id); 
        $.confirm({
            title: 'Confirm!',
            content: 'Are you Sure you want to delete ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        type: 'POST',
                        url: basepath+'journal/deleteVoucher',
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
                                var addurl = basepath + "journal";
                            
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
                                var addurl = basepath + "journal";
                            
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


});// document ready end











function fromValidate()
{    
    $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
    $('#voucher_date_div').removeClass('has-error');
    $("#narration").removeClass('has-error');
    $('#tootal').removeClass('has-error');
    $('.div_amount').removeClass('has-error');
    $('.ac_tag_div').removeClass('has-error');
    $('.account_div').removeClass('has-error');
   
    var total_credit=$('#total_credit').val();
    var total_debit=$('#total_debit').val();

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

    
   
    // for (var i = 0; i < $('select[name*="ac_tag"]').length; i++) {
    //     if ($('#ac_tag_'+i+' option:selected').val()=="0") {
    //         $('#ac_tag_div_'+i).addClass('has-error');
    //         $("#clsmsg")
    //                 .text("Error : Please Select A/C Tag !")
    //                 .addClass("form_error")
    //                 .css("display", "block");
    //         return false;
    //     } 
    // }
    
    // for (var i = 0; i < $('input[name*="amount"]').length; i++) {
    //     if ($('#amount_'+i).val()=="") {
    //         $('#div_amount_'+i).addClass('has-error');
    //         $("#clsmsg")
    //                 .text("Error : Please Enter Amount !")
    //                 .addClass("form_error")
    //                 .css("display", "block");
    //         return false;
    //     }        
    // }
    
    // for (var i = 0; i < $('select[name*="account"]').length; i++) {
    //     if ($('#account_'+i+' option:selected').val()=="") {
    //         $('#account_div_'+i).addClass('has-error');
    //         $("#clsmsg")
    //                 .text("Error : Please Select Account !")
    //                 .addClass("form_error")
    //                 .css("display", "block");
    //         return false;
    //     }        
    // }
    return true;
}

function detailvalidation(){
    if(!getDetailAccountHeadValidation()){       
        $("#clsmsg")
                .text("Error : Please Select A/C Tag !")
                .addClass("form_error")
                .css("display", "block");
        return false;
    }

    if(!getDetailDbCrValidation()){
        $("#clsmsg")
                    .text("Error : Please Select Account !")
                    .addClass("form_error")
                    .css("display", "block");
       return false;
    }  
     
    if(!getDetailAmountValidation()){
        $("#clsmsg")
                    .text("Error : Please Enter Amount !")
                    .addClass("form_error")
                    .css("display", "block");
       return false;
    }
    return true;
}


function getDetailDbCrValidation(){
    
    var selectedType;
    var flag=0;
     $('select[name*="account"]').each(function() {
        selectedType = $(this).val();
       //console.log(selectedproduct);
        if(selectedType==''){
            flag=1;
        }
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }
 
  function getDetailAccountHeadValidation(){
    
    var accountHead;
    var flag=0;
     $('select[name*="ac_tag"]').each(function() {
         
        accountHead = $(this).val();
       //console.log(selectedproduct);
        if(accountHead=='0'){
            flag=1;
        }
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }

 
 
 function getDetailAmountValidation(){
      var flag=0;
      $('input[name*="amount"]').each(function() {
          var amt = $(this).val() == ""||0? "" : $(this).val();
       //console.log(selectedproduct);
        if(amt==""){
            flag=1;
        }
    });
    if(flag==1){
        return false;
    }else{
            return true;  
    }
 }



function AmountDetail(){
    getTotalDebit();
    getTotalCredit();
}


function getTotalAmount()
{
    var total_debit = 0;
    var total_credit = 0;
   
    $( "div.findRow" ).each(function() {
        var ac_tag=$(this).find('select.ac_tag option:selected').val();
        var i=$(this).find('select.ac_tag').attr('data-id');        
        // alert(i);
         if (ac_tag=='Dr') {
            var amount=$('#amount_'+i).val()||0;
            total_debit=total_debit + parseFloat(amount);
        } 
        if (ac_tag=='Cr') {
            var amount=$('#amount_'+i).val()||0;
            total_credit= total_credit + parseFloat(amount);
        } 
        if(ac_tag==0){total_credit=0;total_debit=0;}
    });   

    debitCreditSum ={'totalCredit':total_credit,'totalDebit':total_debit};
    return debitCreditSum;

}

function getDebitCreditEqualValidation(){
    var totalDebit = $("#total_debit").val();
    var totalCredit = $("#total_credit").val();
    
    if(totalDebit!=totalCredit){
        $('#tootal').addClass('has-error');        
        $("#clsmsg")
            .text("Error : Total Debit and Total Credit Amount must be same !")
            .addClass("form_error")
            .css("display", "block");
        return false;   
    }
    else{
        return true;
    }
}

function getTotalDebit(){
    var totalDetailAmount=0;
    var totalDebitAmount =0;    

    totalDetailAmount=getTotalAmount().totalDebit;
    console.log('DetailAmount Test:'+totalDetailAmount);
    
    totalDebitAmount=parseFloat(totalDetailAmount);
    
     $("#total_debit").val(totalDebitAmount);
   
}

function getTotalCredit(){
    var totalDetailAmount=0;
    var totalCreditAmount =0;   

    totalDetailAmount=getTotalAmount().totalCredit;
    console.log('TotalCreditAmount:'+totalDetailAmount);
    
    totalCreditAmount=parseFloat(totalDetailAmount);    
    $("#total_credit").val(totalCreditAmount);
}

function getDebitCrediteComparison(DrCrtag,id){  
    var AmtactualId='amount_'+id;
    var totalDebit=$('#total_debit').val();
    var totalCredit=$('#total_credit').val();
    var differenceDebit=parseFloat(totalDebit-totalCredit);
    var differenceCredit=parseFloat(totalCredit-totalDebit);
    // alert('differenceDebit : '+differenceDebit+' ,differenceCredit : '+differenceCredit);
    
    if(DrCrtag=="Dr"){
       if(differenceDebit>0){
           $('#'+AmtactualId).val(0);
       }else{
            $('#'+AmtactualId).val(differenceCredit);
       }
    }
    else{
        if(differenceDebit>0){
            $('#'+AmtactualId).val(differenceDebit);
        }
        else{
            $('#'+AmtactualId).val(0);
       }
    }
    getTotalDebit();
    getTotalCredit();
}

