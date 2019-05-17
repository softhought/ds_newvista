<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/adm_scripts/general_voucher.js"></script>   
<style>
#VoucherList td{
vertical-align: inherit;
}
</style>
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">General</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">General Voucher List</h3>&nbsp;
              <a href="<?php echo base_url();?>generalvoucher/general" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table id="VoucherList" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Voucher Date</th>
                  <th>Voucher No.</th>
                  <th>Cheque No.</th>
                  <th>Cheque Date</th>
                  <th>Account Details</th> 
                  <th style="text-align:right;width:5%;">Action</th>
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				          // print_r($bodycontent['VoucherList']);
              		$i = 1;
              		foreach ($bodycontent['VoucherList'] as $value) { 
              		
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
                  <th>D/C</th>
                </tr>
                <?php foreach ($value['voucher_ac_detail'] as $voucher_detail) {?>
                  <tr>
                    <td><?php echo $voucher_detail->account_name; ?></td>
                    <td><?php echo $voucher_detail->voucher_amount; ?></td>
                    <td><?php if($voucher_detail->is_debit=='Y'){ echo "D"; }else{ echo "C"; } ?></td>
                  </tr>
               <?php } ?>
              
            </table>
            </td>
            <td align="center"> 
            <?php if($value['is_frm_receipt']=='N'){ ?>           
							<a href="<?php echo base_url(); ?>generalvoucher/general/<?php echo $value['id']; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>   
              <a href="javascript:void(0);" id="deleteBtn_<?php echo $value['id']; ?>"  data-text="<?php echo $value['id'];?>" class="btn deleteBtn btn-danger btn-xs" data-title="Delete">
								<span class="glyphicon glyphicon-trash"></span>
							</a> 
                <?php } ?>      
						</td>
					</tr>              			
              	<?php
              		}
              	?>
                </tbody>
               
              </table>

              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->