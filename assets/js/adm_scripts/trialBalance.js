 
$(document).ready(function() {
     
    var acnt_dt_start=$('#acnt_dt_start').val();
    var acnt_dt_end=$('#acnt_dt_end').val();
   
        $(".acntYrWiseDt").datepicker({
          format: 'mm/dd/yyyy',
          startDate: acnt_dt_start,
          endDate:acnt_dt_end    
        });


        //Print sale tax register
         $("#showtrialbalancepdf").click(function(){
            var fromdate = $("#from_date").val();
            var todate = $("#to_date").val();
            $("#errormsg").text("").css("dispaly", "none").removeClass("form_error");
            $("#from_date_div").removeClass("has-error");
            $("#to_date_div").removeClass("has-error");

            if(fromdate==""){
                 $("#from_date_div").addClass("has-error");                    
                    $("#fees_desc").focus();
                    $("#errormsg")
                    .text("Error : Enter From Date")
                    .addClass("form_error")
                    .css("display", "block");
                 return false;
            }

             if(todate==""){
                 $("#to_date_div").addClass("has-error");                  
                  $("#errormsg")
                  .text("Error : Enter To Date")
                  .addClass("form_error")
                  .css("display", "block");
                 return false;
            }
            else{
                 $("#trialbalanceregister").submit();
            }
           
            
        });
        
        
});/* end of document ready */
        
 