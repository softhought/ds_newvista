<script>
$( ".datepicker" ).datepicker({
       
       changeMonth: true,
       changeYear: true,
       format: 'dd-mm-yyyy'

    });
</script>

<div class="row" style="margin-left: 24px;margin-right: 24px;">
    <form id="dueForm">
        <div class="row">
            <div class="col-md-12">   
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                            <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
                            <?php if ($mode=='EDIT') { 
                                echo '<input type="hidden" name="voucher_id" value="'.$voucher_id.'">';
                            }?>
                            <label for="pdate">Adjustment Date</label>      
                            <input type="text"  class="form-control custom_frm_input datepicker"  name="payment_date" id="payment_date"  placeholder="" value="<?php if ($mode=='EDIT') { echo date("d-m-Y",strtotime($VoucherPaymentRef['voucher_date']));}else{echo date("d-m-Y");}?>" style="width: 204px;" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paid_amount">Adjustment Amount</label> 
                            <input type="text"  class="form-control"  name="paid_amount" id="paid_amount" value="<?php if ($mode=='EDIT') { echo $VoucherPaymentRef['paid_amount'];}?>" style="width: 204px;" />
                        </div>  
                    </div> 
                
                    <div id="account_debit_div" class="col-md-4">
                        <div class="form-group">
                            <label for="account_debit">Account to be Debit</label>  
                            <select id="account_debit" name="account_debit" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option> 
                            <?php
                            foreach ($AccountList as $value) {
                            ?>
                            <option data-text="<?php echo $value->account_name;?>"  value="<?php echo $value->account_id; ?>" <?php if ($mode=='EDIT') {
                                if ($value->account_id==$CreditAccountId) {
                                    echo " selected";
                                }
                            }?>><?php echo $value->account_name; ?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">                 
                    <div  id="narration_div" class="col-md-12">
                        <div class="form-group">
                            <label for="narration">Narration</label>
                            <textarea class="form-control" name="narration" id="narration"><?php if ($mode=='EDIT') { echo $VoucherPaymentRef['narration'];}?></textarea>
                        </div>
                    </div>
            </div>
        <div class="row">
            <div class="col-md-12"> 
                <p id="paymentmsg" class="form_error" style="width: 776px;"></p> 
                <p id="payment_err_msg" class="form_error"></p>
            </div>   
        </div>   
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-4"> 
                <button type="button" class='btn btn-primary btn-lg'  data-text='' name='payDuesubmit' id='payDuesubmit'>Save</button> 
            </div>   
        </div>   
    </form>         
</div>

        

<script>
$('.selectpicker').selectpicker();
$('#payDuesubmit').on('click',function(){
    var basepath = $("#basepath").val();
    var formDataserialize = $("#dueForm").serialize();
    // alert(formDataserialize);
    if (ValidateSavePayment()) {        
    
    $.ajax({
            type: "POST",
            url: basepath+'feespayment/dueAdjustmentPayment_action',
            data: formDataserialize,           
            success: function (result) {
                 console.log(result);
                 if (result.status==200) {
                    $("#modal-success").modal({
                                    "backdrop": "static",
                                    "keyboard": true,
                                    "show": true
                                });
                                var addurl = basepath + "feespayment/payment_history";
                            
                                $("#appendBody").text(result.message);
                                $("#redirectToListsuccess").attr("href", addurl);
                 }else{
                    $("#modal-danger").modal({
                                    "backdrop": "static",
                                    "keyboard": true,
                                    "show": true
                                });
                                var addurl = basepath + "feespayment/payment_history";
                            
                                $("#dengAppendBody").text(result.message);
                                $("#redirectToListerror").attr("href", addurl);

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
                   // alert(msg);  
            }
        }); /*end ajax call*/
    }
});
function ValidateSavePayment()
{  
     
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

</script>