  
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
                  <th style="width:10%;">Sl</th>
                  <th>Fees Description</th>
                  <th align="right">Amount</th>
                
                  
             
                </tr>
                </thead>
                <tbody>
                  
               
              	<?php 
				
              		$i = 1;
                  $total_amount=0;
                  $fees_id="";
                  // pre($fessComponentData);
                  $fessComponentJson=json_encode($fessComponentData);
                    foreach ($fessComponentData as $fescomonent) {
                     $total_amount+=$fescomonent->sum_amount;
                     $fees_id=$fescomonent->fees_id.','.$fees_id;
                   
                  ?>
              	

					<tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $fescomonent->fees_desc; ?></td>
						<td align="right"><?php echo $fescomonent->sum_amount; ?></td>

					</tr>
          
             <?php } ?>
             <tr style="font-weight: bold;"><td colspan="2" >Total amount</td><td align="right"><?php echo number_format($total_amount,2); ?></td></tr>
                </tbody>
               
              </table>
              </center>              

      <input type="hidden" name="total_pay_amount" id="total_pay_amount" value="<?php echo $total_amount;?>" />
      <input type="hidden" name="component_amount_total" id="component_amount_total" value='<?php echo base64_encode($fessComponentJson);?>'>
              <?php
       $curr_dt = date('d/m/Y');     
?>

  <div  style="margin-top:50px;margin-left: 139px; ">
        <div class="form-group row">
        

          <div class="col-sm-2 col-md-2 col-xs-12">
            <label for="pdate">Receipt Date</label> 
            <input type="text"  class="form-control custom_frm_input "  name="payment_date" id="payment_date"  placeholder="" value="<?php echo $curr_dt;?>" style="width: 204px;" />
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
});
</script>   