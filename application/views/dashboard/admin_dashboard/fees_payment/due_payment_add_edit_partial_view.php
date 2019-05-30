<script>
$( ".datepicker" ).datepicker({
       
       changeMonth: true,
       changeYear: true,
       format: 'dd-mm-yyyy'

    });
</script>
<div class="col-md-12"> 
<div class="row" style="margin-left: 124px;">
    <form id="dueForm">
        <div class="row">
            <div class="col-md-12">            
                <div class="form-group row">
                    <div class="col-sm-2 col-md-2 col-xs-12">
                        <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                        <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
                        <?php if ($mode=='EDIT') { 
                            echo '<input type="hidden" name="voucher_id" value="'.$voucher_id.'">';
                        }?>
                        <label for="pdate">Receipt Date</label>      
                        <input type="text"  class="form-control custom_frm_input datepicker"  name="payment_date" id="payment_date"  placeholder="" value="<?php if ($mode=='EDIT') { echo date("d-m-Y",strtotime($VoucherPaymentRef['voucher_date']));}else{echo date("d-m-Y");}?>" style="width: 204px;" />
                    </div>
                    <div class="col-sm-2 col-md-2 col-xs-12"> </div>
                    <div class="col-sm-2 col-md-2 col-xs-12">
                        <label for="paid_amount">Paid Amount</label> 
                        <input type="text"  class="form-control"  name="paid_amount" id="paid_amount" value="<?php if ($mode=='EDIT') { echo $VoucherPaymentRef['paid_amount'];}?>" style="width: 204px;" />
                    </div>  
                    <div class="col-sm-2 col-md-2 col-xs-12"> </div>      
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <label for="mode">Receipt mode</label>  
                        <div class="form-group">
                        <select id="payment_mode" name="payment_mode" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                        <option value="0">Select</option>                          
                        <?php
                        foreach ($PaymentModeList as $paymode) {
                        ?>
                        <option value="<?php echo $paymode->id; ?>" <?php if ($mode=='EDIT') {
                                if ($paymode->id==$VoucherPaymentRef['payment_mode']) {
                                    echo " selected";
                                }
                            }?>><?php echo $paymode->payment_mode;?></option>
                        <?php                            
                        }
                        ?>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div id="account_debit_div" class="col-md-4">
                        <div class="form-group">
                            <label for="account_debit">Account to be Debited</label>  
                            <select id="account_debit" autocomplete="off" name="account_debit" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option> 
                            <?php
                            foreach ($AccountList as $value) {
                            ?>
                            <option data-text="<?php echo $value->account_name;?>"  value="<?php echo $value->account_id; ?>" <?php if ($mode=='EDIT') {
                                if ($value->account_id==$DebitAccountId) {
                                    echo " selected";
                                }
                            }?>><?php echo $value->account_name; ?></option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2 col-xs-12"> </div>
                    <div style="display:none;" id="cheque_no_div" class="col-md-4">
                        <div class="form-group">
                            <label for="cheque_no">Cheque No.</label>
                            <input type="text" autocomplete="off" class="form-control" name="cheque_no" value="<?php if ($mode=='EDIT') { echo $VoucherPaymentRef['cheque_no'];}?>" id="cheque_no" placeholder="Enter Cheque No.">
                        </div>
                    </div>
                    <!-- </div>
                    <div class="form-group row"> -->
                    <div style="display:none;" id="bank_name_div" class="col-md-4">
                        <div class="form-group">
                            <label for="bank_name">Bank</label>  
                            <input name="bank_name" autocomplete="off" id="bank_name" value="<?php if ($mode=='EDIT') { echo $VoucherPaymentRef['bank_name'];}?>" class="form-control" placeholder="Enter Bank Name">              
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2 col-xs-12"> </div>
                    <div style="display:none;" id="cheque_date_div" class="col-md-4">
                        <div class="form-group">
                            <label for="cheque_date">Cheque Date</label>
                            <input type="text"  autocomplete="off"  class="form-control custom_frm_input datepicker"  value="<?php if ($mode=='EDIT') { if ($VoucherPaymentRef['cheque_date']!="") {echo date("d-m-Y",strtotime($VoucherPaymentRef['cheque_date']));}else{echo "";}}else{echo date("d-m-Y");}?>"  name="cheque_date" id="cheque_date">
                        </div>
                    </div>
                    <!-- </div>
                    <div class="form-group row"> -->
                    <div style="display:none;" id="branch_name_div" class="col-md-4">
                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>  
                            <input name="branch_name" autocomplete="off" id="branch_name" value="<?php if ($mode=='EDIT') { echo $VoucherPaymentRef['branch_name'];}?>" class="form-control" placeholder="Enter Branch Name">            
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2 col-xs-12"> </div>
                    <div  id="narration_div" class="col-md-4">
                        <div class="form-group">
                            <label for="narration">Narration</label>
                            <textarea class="form-control" name="narration" id="narration"><?php if ($mode=='EDIT') { echo $VoucherPaymentRef['narration'];}?></textarea>
                        </div>
                    </div>
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
            <div class="col-md-12"> 
                <button type="button" class='btn btn-primary btn-lg'  data-text='' name='payDuesubmit' id='payDuesubmit'>Save</button> 
            </div>   
        </div>   
    </form>         
</div>
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
            url: basepath+'feespayment/duePayment_action',
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

</script>