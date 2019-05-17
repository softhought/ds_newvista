<script src="<?php echo base_url(); ?>assets/js/adm_scripts/feesstructure.js"></script>  
  
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List of Fees Structure</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Fees Structure</h3>&nbsp;
              <a href="<?php echo base_url();?>feesstructure/addFeesStructure" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Class</th>
                  <th>Fees Description</th>
                 
                  <th>Amount</th>
                 
                  <th style="text-align:right;width:5%;">Action</th>
                </tr>
                </thead>
                <tbody>
               
              	<?php 
                  // pre($bodycontent['feesstructureList']);
              		$i = 1;
              		foreach ($bodycontent['feesstructureList'] as $value) { 
              	
              		?>

					<tr>
						<td><?php echo $i; ?></td>
            <td><?php echo $value->classname; ?></td>
            <td><?php echo $value->fees_desc; ?></td>
            <td><?php echo $value->amount; ?></td>
				
						<td align="center"> 
							<a href="<?php echo base_url(); ?>feesstructure/addFeesStructure/<?php echo $value->id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
							<a href="javascript:void(0);" id="deleteBtn_<?php echo $i; ?>" data-text="<?php echo $value->id;?>" class="btn deleteBtn btn-danger btn-xs" data-title="Delete">
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

    