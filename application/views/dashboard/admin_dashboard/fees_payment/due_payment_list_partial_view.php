<?php // pre($VoucherData);?>
<div class="datatalberes" style="overflow-x:auto;">
              <table id="journalList" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Voucher Date</th>
                  <th>Voucher No.</th>
                  <th>Cheque No.</th>
                  <th>Cheque Date</th>
                  <th>Total Amount</th>
                  <th>Receipt Amount</th>
                  <!-- <th>Due Amount</th> -->
                  <th>Account Details</th> 
                  <th>Action</th> 
                  
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          // print_r($bodycontent['journalList']);
              		$i = 1;
              		foreach ($VoucherData as $value) { 
              		
              		?>

					<tr>
						<td><?php echo $i++; ?></td>
            <td><?php echo $value['voucher_date']; ?></td>
            <td><?php echo $value['voucher_no']; ?></td>
            <td><?php echo $value['cheque_no']; ?></td>
            <td><?php echo $value['cheque_date']; ?></td>
            <td><?php echo $totalAmnt; ?></td>
            <td><?php echo $value['paid_amount']; ?></td>
            <!-- <td><?php //echo $totalDueAmnt; ?></td> -->            
            <td>
            <table class="table table-striped table-bordered">              
                <tr>
                  <th>A/C</th>
                  <th>Amount</th>
                  <th></th>
                </tr>
                <?php foreach ($value['voucher_ac_detail'] as $voucher_detail) {?>
                  <tr>
                    <td><?php echo $voucher_detail->account_name; ?></td>
                    <td><?php echo $voucher_detail->voucher_amount; ?></td>
                    <td><?php if($voucher_detail->is_debit=='Y'){ echo "Dr"; }else{ echo "Cr"; }?></td>
                  </tr>
               <?php } ?>
              
            </table>
            </td>
            <td>
              <button id='editDueData_<?php echo $value['voucher_id'];?>' data-pay="<?php echo $payment_id; ?>" data-text="<?php echo $value['voucher_id'];?>" class='btn btn-primary btn-xs editDueData'><span class='glyphicon glyphicon-pencil'></span></button>  &nbsp;&nbsp;
              <button id='deleteDueData_<?php echo $value['voucher_id'];?>' data-pay="<?php echo $payment_id; ?>" data-text="<?php echo $value['voucher_id'];?>" class='btn btn-danger btn-xs deleteDueData'><span class='glyphicon glyphicon-trash'></span></button>
            </td>
            
					</tr>              			
              	<?php
              		}

              	?>
                </tbody> 
               
              </table>

              </div>
              <br>
              <div class='row' style='text-align: center;'>
                <div class='col-md-12'>
                    <button  class='btn btn-primary btn-lg'  data-text="<?php echo $payment_id; ?>" id='payDue'>Receipt Due</button>                  
                </div>
              </div>


              
<script>

$('.dataTables').DataTable();
$('#payDue').on('click',function(){   
        var paymentId=$('#payDue').attr('data-text'); 
        // alert(paymentId);       
        var basepath = $("#basepath").val();  
    $.ajax({
            type: "POST",
            url: basepath+'feespayment/duePaymentAddEdit',
            data: {payment_id:paymentId},           
            success: function (result) {
             
                //  console.log(result);              
                $("#DuePaymentTitleText").html(result.title);
                $("#AddEditData").html(result.modal); 
                $('#DuePaymentAddEdit').modal('show');            
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
});

$('.editDueData').on('click',function(){  
    var id=$(this).attr('id') ;
        var voucherId=$('#'+id).attr('data-text'); 
        var paymentId=$('#'+id).attr('data-pay'); 
        // alert(paymentId);       
        var basepath = $("#basepath").val();  
    $.ajax({
            type: "GET",
            url: basepath+'feespayment/duePaymentAddEdit/'+voucherId+'/'+paymentId,
            // data: {voucher_id:},           
            success: function (result) {
             
                //  console.log(result);              
                $("#DuePaymentTitleText").html(result.title);
                $("#AddEditData").html(result.modal); 
                $('#DuePaymentAddEdit').modal('show');            
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
});


$('.deleteDueData').on('click',function(){  
    var id=$(this).attr('id') ;
        var voucherId=$('#'+id).attr('data-text'); 
        var paymentId=$('#'+id).attr('data-pay'); 
        // alert(paymentId);       
        var basepath = $("#basepath").val(); 
        $.confirm({
            title: 'Confirm!',
            content: 'Are you Sure you want to delete ?',
            buttons: {
                confirm: function () { 
                    $.ajax({
                            type: "POST",
                            url: basepath+'feespayment/deleteDuePaymentVoucher',
                            data: {voucher_id:voucherId},           
                            success: function (result) {
                                if (result.status == 200) {                 
                                
                                    $("#modal-success").modal({
                                        "backdrop": "static",
                                        "keyboard": true,
                                        "show": true
                                    });
                                    var addurl = basepath + "feespayment/payment_history";
                                
                                    $("#appendBody").text(result.message);
                                    $("#redirectToListsuccess").attr("href", addurl);

                                }else {
                                    // alert(fees_id+" have data");                    
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
                        },
                cancel: function () {
                    // $.alert('Canceled!');
                }
            }
        });
});
</script>