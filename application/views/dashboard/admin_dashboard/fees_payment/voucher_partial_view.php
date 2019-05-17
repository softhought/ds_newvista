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
                  <th>Account Details</th> 
                  
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
            <td><?php echo $value['voucher_number']; ?></td>
            <td><?php echo $value['cheque_number']; ?></td>
            <td><?php echo $value['cheque_date']; ?></td>
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
            
					</tr>              			
              	<?php
              		}

              	?>
                </tbody> 
               
              </table>

              </div>
<script>$('.dataTables').DataTable();</script>