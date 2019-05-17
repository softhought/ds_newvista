<script src="<?php echo base_url(); ?>assets/js/adm_scripts/feescomponent.js"></script>   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>  
  <style type="text/css">
  .monthstyle{background-color: #ef7a25 !important;}
</style>   
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List of Fees Component</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Fees Component</h3>&nbsp;
              <a href="<?php echo base_url();?>feescomponent/addFeesComponent" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th style="width:20%;">Fees Description</th>
                  <th >Active For Months</th>
                  <th>Account</th>
                 
                  <th style="text-align:right;width:5%;">Action</th>
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				
              		$i = 1;
              		foreach ($bodycontent['feescomponentList'] as $value) { 
              	
              		?>

					<tr>
						<td><?php echo $i; ?></td>
            <td><?php echo $value['FeesComponentData']->fees_desc; ?></td>
            <td><?php 

                  foreach ($value['monthData'] as $monthdata) { ?>
                   
                  <span class="label label-warning monthstyle"><?php echo $monthdata->month_code; ?></span>
                <?php  }
             ?></td>
            <td><?php echo $value['FeesComponentData']->account_name; ?></td>
				
						<td align="center"> 
							<a href="<?php echo base_url(); ?>feescomponent/addFeesComponent/<?php echo $value['FeesComponentData']->id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
							<a href="javascript:void(0);" id="deleteBtn_<?php echo $i; ?>"  data-text="<?php echo $value['FeesComponentData']->id;?>" class="btn deleteBtn btn-danger btn-xs" data-title="Delete">
								<span class="glyphicon glyphicon-trash"></span>
							</a>              
						</td>
					</tr>
              			
              	<?php
                  $i++;
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