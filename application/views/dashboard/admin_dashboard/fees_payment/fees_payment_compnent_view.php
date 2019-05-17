  
<hr>
<center><button type="button" class="btn btn bg-maroon margin">Fees Details</button><br>
<div class="datatalberes" >
  <input type="hidden" name="monthids" id="monthids" value="<?php echo $monthids_string; ?>" />
  <input type="hidden" name="studentid" id="studentid" value="<?php echo $studentid; ?>" />
  <input type="hidden" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $acnt_dt_start; ?>" />
  <input type="hidden" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $acnt_dt_end; ?>" />

   <input type="hidden" name="paymentID" id="paymentID" value="<?php if($mode=='EDIT'){echo $paymentID;}else{ echo "0";}?>" />
  
    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>" />

              <table class="table table-bordered table-striped  nowrap" style="border-collapse: collapse !important;width: 70%;outline: 1px solid #77609e;">
                <thead>
                  <tr >
                    <th colspan="3"><b style="font-weight: bold;color: #202b80;">For months :</b>
                      <?php

                      foreach ($monthsname as  $key => $value) {
                        if ($key==0) {$spc=""; }else{$spc=", ";}
                        echo $spc.$value." ";
                      }
                      ?>
                    </th>
                  </tr>
                <tr style="background-color: #605ca8;color: #fff;">
                  <th style="width:8%;"></th>
                  <th>Fees Description</th>
                  <th align="right">Amount</th>
                
                  
             
                </tr>
                </thead>
                <tbody>
                <?php  if (!empty($GetPaidComponentArr)) { ?>
                 
                
                <tr>
                <td colspan='3' style="text-align: center;background-color: #605ca8;color: #fff;">Already Paid Fees </td>
                </tr>
                <?php foreach ($GetPaidComponentArr as $PaidComponent) {              
                  ?>
                  <tr>
                  <td><img src="<?php echo base_url(); ?>assets/images/paid-icon.png" style="height: 25px;width: 25px;" alt="paid icon"></td>
                  <td><?php echo $PaidComponent['fees_desc']; ?></td>
                  <td align="left">Payment Taken For Month (<?php echo $PaidComponent['month_code']; ?>) 
                  </td>   
                  </tr>
                <?php  } } ?>



<!-- /*********** once in life time fees *****************/ -->

                <?php
                if (!empty($OnceInLifeTimeComponent)) {                 
                ?>
                  
                <tr>
                <td colspan='3' style="text-align: center;background-color: #605ca8;color: #fff;">Once in life time </td>
                </tr>

                <?php 
                if(!empty($OnceInLifeTimePaidComponent)){
                foreach ($OnceInLifeTimePaidComponent as $LifeTimePaidComponent) {  
                    ?>
                <tr>
                  <td><img src="<?php echo base_url(); ?>assets/images/paid-icon.png" style="height: 25px;width: 25px;" alt="paid icon"></td>
                  <td><?php echo $LifeTimePaidComponent['fees_desc']; ?></td>
                  <td align="left"> Payment Taken </td>                 
                </tr>

              <?php                   
              }
            }
               if(!empty($OnceInLifeTimeNotPaidComponent)){
                foreach ($OnceInLifeTimeNotPaidComponent as $LifeTimeNotPaidComponent) {  
                    ?>
                <tr>
                  <td><input type="checkbox" class="comp_select_checkbox" data-amnt="<?php echo $LifeTimeNotPaidComponent->amount; ?>" name="comp_detail" data-month="<?php echo $LifeTimeNotPaidComponent->month_id; ?>"  data-totalamnt="<?php echo $LifeTimeNotPaidComponent->amount; ?>" value="<?php echo $LifeTimeNotPaidComponent->fees_id; ?>"></td>
                  <td><?php echo $LifeTimeNotPaidComponent->fees_desc; ?></td>
                  <td align="right"> <?php echo $LifeTimeNotPaidComponent->amount; ?></td>
                </tr>

              <?php                   
                }
               }
               } ?>
<!-- /*********** once in life time fees *****************/ -->


<!-- /*********** yearly once fees *****************/ -->

                <?php
                if (!empty($OnceInAyearComponent)) {                 
                ?>
                  
                <tr>
                <td colspan='3' style="text-align: center;background-color: #605ca8;color: #fff;">Once in a year </td>
                </tr>

                <?php 
                if(!empty($OnceInAyearPaidComponent)){
                foreach ($OnceInAyearPaidComponent as $yearPaidComponent) {  
                    ?>
                <tr>
                  <td><img src="<?php echo base_url(); ?>assets/images/paid-icon.png" style="height: 25px;width: 25px;" alt="paid icon"></td>
                  <td><?php echo $yearPaidComponent['fees_desc']; ?></td>
                  <td align="left"> Payment Taken </td>                 
                </tr>

              <?php                   
              }
            }
               if(!empty($OnceInAyearNotPaidComponent)){
                foreach ($OnceInAyearNotPaidComponent as $yearNotPaidComponent) {  
                    ?>
                <tr>
                  <td><input type="checkbox" class="comp_select_checkbox" data-amnt="<?php echo $yearNotPaidComponent->amount; ?>" name="comp_detail" data-month="<?php echo $yearNotPaidComponent->month_id; ?>"  data-totalamnt="<?php echo $yearNotPaidComponent->amount; ?>" value="<?php echo $yearNotPaidComponent->fees_id; ?>"></td>
                  <td><?php echo $yearNotPaidComponent->fees_desc; ?></td>
                  <td align="right"> <?php echo $yearNotPaidComponent->amount; ?></td>
                </tr>

              <?php                   
                }
               }
               } ?>
<!-- /*********** yearly once fees *****************/ -->



              <?php
               $total_amount=0; 
               if (!empty($notPaidComponentArr)) {
                ?>
                <tr><td colspan='3' style="text-align: center;background-color: #605ca8;color: #fff;">Payable Fees </td></tr>
                <?php
              		$i = 1;                                   
                    foreach ($notPaidComponentArr as $fescomonent) {
                                    
                  ?>
              	

         <tr>       
           <!-- <td><?php echo $i; ?></td> -->
           <td>
              <input type="checkbox" class="comp_select_checkbox" data-amnt="<?php echo $fescomonent['amount']; ?>" name="comp_detail" data-month="<?php echo $fescomonent['month_id']; ?>"  data-totalamnt="<?php echo $fescomonent['total_amount']; ?>" value="<?php echo $fescomonent['fees_id']; ?>">
           </td>
           <td><?php echo $fescomonent['fees_desc']; ?></td>
           <td align="right"><?php echo $fescomonent['total_amount']; ?></td>      
         </tr> 
<?php $i++;  } }?>
             <tr style="font-weight: bold;"><td colspan="2" >Total amount</td><td id="total_selected_cmpnent_amnt" align="right"></td></tr>
                </tbody>
               
              </table>
              </center>              

      <input type="hidden" name="total_pay_amount" id="total_pay_amount" value="" />
      <!-- <input type="hidden" name="component_amount_total" id="component_amount_total" value='<?php echo base64_encode($fessComponentJson);?>'> -->
              <?php
       $curr_dt = date('d/m/Y'); 
       if ($acnt_dt_start >= $curr_dt && $acnt_dt_end <= $curr_dt) {
         $today=$curr_dt;
       } else{
         $today=$acnt_dt_end;
       }   
?>

  <div  style="margin-top:50px;margin-left: 139px; ">
        <div class="form-group row">
        

          <div class="col-sm-2 col-md-2 col-xs-12">
            <label for="pdate">Receipt Date</label> 
            <input type="text"  class="form-control custom_frm_input "  name="payment_date" id="payment_date"  placeholder="" value="<?php echo $today;?>" style="width: 204px;" />
          </div>
          <div class="col-sm-2 col-md-2 col-xs-12"> </div>
          <div class="col-sm-2 col-md-2 col-xs-12">
            <label for="paid_amount">Paid Amount</label> 
            <input type="text"  class="form-control"  name="paid_amount" id="paid_amount"  value="<?php echo $total_amount;?>" style="width: 204px;" />
          </div>

          <div class="col-sm-2 col-md-2 col-xs-12"> </div>
        

          <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="mode">Receipt mode</label>
              <select id="payment_mode" name="payment_mode" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                <option value="0">Select</option> 
                <?php
                foreach ($PaymentModeList as $value) {
                echo '<option value="'.$value->id.'">'.$value->payment_mode.'</option>';
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
            <select id="account_debit" name="account_debit" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
              <option value="0">Select</option> 
              <?php
                foreach ($AccountList as $value) {
                  echo '<option data-text="'.$value->account_name.'" value="'.$value->account_id.'">'.$value->account_name.'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-sm-2 col-md-2 col-xs-12"> </div>
        <div style="display:none;" id="cheque_no_div" class="col-md-4">
          <div class="form-group">
            <label for="cheque_no">Cheque No.</label>
            <input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="Enter Cheque No.">
          </div>
        </div>
      <!-- </div>

      <div class="form-group row"> -->
        <div style="display:none;" id="bank_name_div" class="col-md-4">
          <div class="form-group">
            <label for="bank_name">Bank</label>  
            <input name="bank_name" id="bank_name" class="form-control" placeholder="Enter Bank Name">              
          </div>
        </div>
        <div class="col-sm-2 col-md-2 col-xs-12"> </div>
        <div style="display:none;" id="cheque_date_div" class="col-md-4">
          <div class="form-group">
            <label for="cheque_date">Cheque Date</label>
            <input type="text"  class="form-control custom_frm_input datepicker" name="cheque_date" id="cheque_date">
          </div>
        </div>
      <!-- </div>

      <div class="form-group row"> -->
        <div style="display:none;" id="branch_name_div" class="col-md-4">
          <div class="form-group">
            <label for="branch_name">Branch Name</label>  
            <input name="branch_name" id="branch_name" class="form-control" placeholder="Enter Branch Name">            
          </div>
        </div>
        <div class="col-sm-2 col-md-2 col-xs-12"> </div>
        <div  id="narration_div" class="col-md-4">
          <div class="form-group">
            <label for="narration">Narration</label>
            <textarea class="form-control" name="narration" id="narration"></textarea>
          </div>
        </div>
      </div>
      

      <p id="paymentmsg" class="form_error" style="width: 776px;"></p> 
      <p id="payment_err_msg" class="form_error"></p>
      <div class="form-group row" style="margin-top:20px;" >

      
      </div>

  </div>
              <center> <div class="">
              <button type="submit" class="btn btn-primary formBtn" id="paymentSave" style="display: inline-block;width:150px;"><?php echo $btnText;?></button></center>
            </div>
<script type="text/javascript">
$(document).ready(function() {
var acnt_dt_start=$('#acnt_dt_start').val();
var acnt_dt_end=$('#acnt_dt_end').val();
// console.log(acnt_dt_start+" "+acnt_dt_end);
    $("#payment_date").datepicker({
      format: 'dd/mm/yyyy',
      startDate: acnt_dt_start,
      endDate:acnt_dt_end    
    });


    $(".comp_select_checkbox").on('click',function(){

      var comp_id =$(this).val();
      var comp_totalamnt =parseFloat($(this).attr('data-totalamnt'));     
      var comp_month =$(this).attr('data-month').split(',');;
      var comp_amnt =parseFloat($(this).attr('data-amnt'));
      var total_amnt =parseFloat($('#total_selected_cmpnent_amnt').text().trim() || 0);
      var newArray=[];
      for (let i = 0; i < comp_month.length; i++) {
        const element = {'month':comp_month[i],'fees_id':comp_id,'amount':comp_amnt};
        newArray.push(element);
      }
      //console.log(newArray);

      

     // alert(comp_id+" "+comp_totalamnt+" "+comp_month+" "+comp_amnt+" "+total_amnt);

      if($(this).is(':checked')){
          $('#total_selected_cmpnent_amnt').text(comp_totalamnt+total_amnt);
          $('#total_pay_amount').val(comp_totalamnt+total_amnt);
          $('#paid_amount').val(comp_totalamnt+total_amnt);
      } else {
          $('#total_selected_cmpnent_amnt').text(total_amnt-comp_totalamnt);
          $('#total_pay_amount').val(total_amnt-comp_totalamnt);
          $('#paid_amount').val(total_amnt-comp_totalamnt);
      }
      
    });

});
</script>   