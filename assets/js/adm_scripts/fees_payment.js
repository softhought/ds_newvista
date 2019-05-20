$(document).ready(function(){
   
    var basepath = $("#basepath").val();
       $( ".datepicker" ).datepicker({
       
       changeMonth: true,
       changeYear: true,
       format: 'dd/mm/yyyy'

    });

   

       var mode=$("#mode").val();
            
              if (mode=='EDIT') {

            var  selected_roles = $("#selected_month_ids").val();

            var selected_attr = selected_roles.split(',');
            $("#sel_month").selectpicker("val", selected_attr);
           // $('#sel_role').selectpicker('refresh');

                }

   /* On select class  */
    $(document).on("change", "#acdm_section,#acdm_class", function() {
        var acdm_class=$('select[name=acdm_class]').val();
        var acdm_section=$('select[name=acdm_section]').val();

       
    $.ajax({
    type: "POST",
    url: basepath+'feespayment/getStudent',
    data: {acdm_class:acdm_class,acdm_section:acdm_section},
    
    success: function(data){
        $("#student_dropdown").html(data);
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
                   // alert(msg);  
                }



    });/*end ajax call*/

    });

   /* check Payment Given Months  */
    $(document).on("change", "#studentid", function() {
        var acdm_class=$('#acdm_class option:selected').val();
        var studentid=$('#studentid option:selected').val();
         
    $.ajax({
    type: "POST",
    url: basepath+'feespayment/checkPaymentGivenMonths',
    data: {studentid:studentid,acdm_class:acdm_class},
    
    success: function(data){
        $("#sel_month_dropdown").html(data);
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
                   // alert(msg);  
                }



    });/*end ajax call*/

    });


  // search
    $(document).on("click","#searchbtn",function(event){
        event.preventDefault();

           var formDataserialize = $("#feesPaySearchForm" ).serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);
            var formData = {formDatas: formDataserialize};
            
            $("#loadpaymentcomponent").html('');
            if (validate()) {
                  $(".loaderbtn").css("display","block");

            $.ajax({
                type: "POST",
                url: basepath+'feespayment/getPaymentComponentList',
                data: formData,
                dataType: 'html',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                success: function (result) {
                   
                    $("#loadpaymentcomponent").html(result);
                    $(".loaderbtn").css("display","none");
                        $( ".datepicker" ).datepicker({
                       
                       changeMonth: true,
                       changeYear: true,
                       format: 'dd/mm/yyyy'

                    });
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
                       // alert(msg);  
                    }
                }); /*end ajax call*/

}//end of validation

       

});

/* change month for save payment*/
$(document).on('change', '.changmonth', function(event){
           event.preventDefault();
             var formDataserialize = $("#feesPaySearchForm" ).serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);
            var formData = {formDatas: formDataserialize};
             $("#loadpaymentcomponent").html('');

            if (validate()) {
                  $(".loaderbtn").css("display","block");

            $.ajax({
                type: "POST",
                url: basepath+'feespayment/getPaymentComponentList',
                data: formData,
                dataType: 'html',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                success: function (result) {
                   
                    $("#loadpaymentcomponent").html(result);
                    $(".loaderbtn").css("display","none");
                        $( ".datepicker" ).datepicker({
                       
                       changeMonth: true,
                       changeYear: true,
                       format: 'dd/mm/yyyy'

                    });
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
                       // alert(msg);  
                    }
                }); /*end ajax call*/

}//end of validation
      
}); 


/* change month for Edit payment*/
$(document).on('change', '.changmonthedit', function(event){
           event.preventDefault();
             var formDataserialize = $("#feesPayEditForm" ).serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);
            var formData = {formDatas: formDataserialize};
             $("#loadpaymentcomponent").html('');

            if (validate()) {
                  $(".loaderbtn").css("display","block");

            $.ajax({
                type: "POST",
                url: basepath+'feespayment/getPaymentComponentListPaymentEdit',
                data: formData,
                dataType: 'html',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                success: function (result) {
                   
                    $("#loadpaymentcomponent").html(result);
                    $(".loaderbtn").css("display","none");
                        $( ".datepicker" ).datepicker({
                       
                       changeMonth: true,
                       changeYear: true,
                       format: 'dd/mm/yyyy'

                    });
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
                       // alert(msg);  
                    }
                }); /*end ajax call*/

}//end of validation
      
}); 

/* save payment*/

   $(document).on("click", "#paymentSave", function(event) {
    event.preventDefault();
    
      var studentid = $("#studentid").val();
      var monthids = $("#monthids").val();
      var payment_mode = $("#payment_mode option:selected").val();
      var payment_date = $("#payment_date").val();
      var total_pay_amount = $("#total_pay_amount").val();
      var paymentID = $("#paymentID").val();
      var mode = $("#mode").val();

      var paid_amount=$('#paid_amount').val(); 
      var cheque_no=$('#cheque_no').val(); 
      var bank_name=$('#bank_name').val(); 
      var cheque_date=$('#cheque_date').val(); 
      var branch_name=$('#branch_name').val(); 
      var narration=$('#narration').val();
      var account_debit=$('#account_debit option:selected').val();
     
    //   var component_amount_total=$('#component_amount_total').val();


    //   var Arr=[];
      var newArray=[];
      $.each($("input[class='comp_select_checkbox']:checked"), function(){   
        var comp_id =$(this).val();     
        var comp_month =$(this).attr('data-month').split(',');;
        var comp_amnt =parseFloat($(this).attr('data-amnt'));
           
        for (let i = 0; i < comp_month.length; i++) {
            const element = {'month':comp_month[i],'fees_id':comp_id,'amount':comp_amnt};
            newArray.push(element);
        }
        // Arr=[];
        // Arr.push(newArray);  
        });
        var componentData = JSON.stringify(newArray);
        
       console.log(componentData);





    //   alert(component_amount_total);exit();
      var urlpath = basepath + 'feespayment/payment_action';
     if (ValidateSavePayment()) {
        $.ajax({
      type: "POST",
      url:  urlpath,
      data: {paymentID:paymentID,mode:mode,studentid:studentid,monthids:monthids,payment_mode:payment_mode,payment_date:payment_date,total_pay_amount:total_pay_amount,paid_amount:paid_amount,cheque_no:cheque_no,bank_name:bank_name,cheque_date:cheque_date,branch_name:branch_name,narration:narration,account_debit:account_debit,selected_component_ids:componentData},
      dataType: 'json',
      contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
      success: function (result) {
        if(result.msg_status=1)
        {

          $("#save-msg-data").text(result.msg_data);
                        
                        $("#saveMsgModal").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                            });
         // location.reload();
        }
        
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
        alert(msg);  
        }
    }); /*end ajax call*/

    }//end of if loop

    });



/* Update Payment master data*/


/* Update payment master */

   $(document).on("click", "#paymentmstUpdate", function(event) {
    event.preventDefault();
      
      
      var payment_date = $("#payment_date").val();  
      var paymentID = $("#paymentID").val();
      var mode = $("#mode").val();
      var payment_mode = $("#payment_mode option:selected").val();
      var paid_amount=$('#paid_amount').val(); 
           var cheque_no=$('#cheque_no').val(); 
           var bank_name=$('#bank_name').val(); 
           var cheque_date=$('#cheque_date').val(); 
           var branch_name=$('#branch_name').val(); 
           var narration=$('#narration').val();
           var account_debit=$('#account_debit option:selected').val();
     
      var urlpath = basepath + 'feespayment/updatePaymentMaster';
     if (ValidateSavePayment()) {
        $.ajax({
      type: "POST",
      url:  urlpath,
      data: {paymentID:paymentID,mode:mode,payment_mode:payment_mode,payment_date:payment_date,paid_amount:paid_amount,cheque_no:cheque_no,bank_name:bank_name,cheque_date:cheque_date,branch_name:branch_name,narration:narration,account_debit:account_debit},
      dataType: 'json',
      contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
      success: function (result) {
        if(result.msg_status=1)
        {

          $("#save-msg-data").text(result.msg_data);
                        
                        $("#saveMsgModal").modal({"backdrop"  : "static",
                              "keyboard"  : true,
                              "show"      : true                    
                            });
         // location.reload();
        }
        
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
        alert(msg);  
        }
    }); /*end ajax call*/

    }//end of if loop

    });
/* view payment history*/

 var table =  $('#csvDatas').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": basepath + 'csvuploader/listCsvData',
                    
                     });
    $('#users tbody').on('click', 'tr', function () {
        console.log(table.row(this).data());
    });
$(document).on('click', '#viewpaymenthistory', function(event){
           event.preventDefault();
          
             var formDataserialize = $("#PaymentHistoryForm" ).serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);
            var formData = {formDatas: formDataserialize};
             $("#loadpaymentList").html('');
              
          
                if (validateFormHistory()) {

                   $(".dashboardloader").css("display","block");

                $.ajax({
                type: "POST",
                url: basepath+'feespayment/getPaymentList',
                data: formData,
                dataType: 'html',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
                success: function (result) {
                   
                    $("#loadpaymentList").html(result);
                
                    $(".dashboardloader").css("display","none");
                    
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
                       // alert(msg);  
                    }
                }); /*end ajax call*/

              }//end of class
                   
      
}); 


$(document).on('click', '#viewpaymentDuePDF', function(event){
    // added on 18.05.2019 
    event.preventDefault();
    
    var from_date = $('#from_date').val() || 0 ;
    var to_date = $('#to_date').val() || 0 ;
    var acdm_class = $('#acdm_class').val() || 0 ;
    var acdm_section = $('#acdm_section').val() || 0 ;
    var studentid = $('#studentid').val() || 0 ;
    var check = $("#DueOnly").is(":checked");
    if(check) {
        var DueOnly =1;
    }else{
        var DueOnly =0;
    }
    
    //alert(DueOnly);
              
     if (validateFormHistory()) {

        var url = basepath+"feespayment/payment_DueReport/"+from_date+"/"+to_date+"/"+acdm_class+"/"+acdm_section+"/"+studentid+"/"+DueOnly;
        window.open(url, '_blank');

     }//end of class
                   
      
}); 



$(document).on('change', '#payment_mode', function(event){
    event.preventDefault(); 
    // var mode=$('#payment_mode option:selected').val();
    var mode=$('#payment_mode option:selected').text();
        $('#cheque_no').val(""); 
        $('#bank_name').val(""); 
        $('#cheque_date').val(""); 
        $('#branch_name').val(""); 
        // $('#narration').val("");
  if(mode=="Cheque"){
        $('#cheque_no_div').show(); 
        $('#bank_name_div').show(); 
        $('#cheque_date_div').show(); 
        $('#branch_name_div').show();        
   }else{
        $('#cheque_no_div').hide(); 
        $('#bank_name_div').hide(); 
        $('#cheque_date_div').hide(); 
        $('#branch_name_div').hide(); 
        
   }
 
});


 });// end of document ready



function validate()
{  
    var studentid = $("#studentid").val();
    var months =$('#sel_month').val().length;
    
    $("#feepaymsg").text("").css("dispaly", "none").removeClass("form_error");
    if(studentid=="0")
    {
        $("#studentid").focus();
        $("#feepaymsg")
        .text("Error : Select Student")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(months=="0")
    {
        $("#fees_desc").focus();
        $("#feepaymsg")
        .text("Error : Select Month")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }
    return true;
}


function ValidateSavePayment()
{  
      var payment_mode = $("#payment_mode").val();
      var payment_date = $("#payment_date").val();
      var paid_amount = $("#paid_amount").val();
      var account_debit = $("#account_debit option:selected").val();
     // alert(payment_date);
    
    $("#paymentmsg").text("").css("dispaly", "none").removeClass("form_error");
     if(payment_date=="")
    {
        $("#payment_date").focus();
        $("#paymentmsg")
        .text("Error : Select Payment date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(paid_amount=="")
    {
        $("#paid_amount").focus();
        $("#paymentmsg")
        .text("Error : Select Paid Amount")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(payment_mode=="0")
    {
        $("#studentid").focus();
        $("#paymentmsg")
        .text("Error : Select Payment mode")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }    

    if(account_debit=="0")
    {
        $("#account_debit").focus();
        $("#paymentmsg")
        .text("Error : Select Account to be Debited")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

   


    return true;
}



function validateFormHistory()
{  
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
   
    
    $("#payhismsg").text("").css("dispaly", "none").removeClass("form_error");
    if(from_date=="")
    {
        $("#from_date").focus();
        $("#payhismsg")
        .text("Error : Select From Date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(to_date=="")
    {
        $("#to_date").focus();
        $("#payhismsg")
        .text("Error : Select To Date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }


    return true;
}


