  
   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Group List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Group List</h3>&nbsp;
              <a href="<?php echo base_url();?>accounts/group" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="datatalberes" style="overflow-x:auto;">
              <table class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:10%;">Sl</th>
                  <th>Description</th>
                  <th>Main Category</th>
                  <th>Sub Category</th>
                  <!-- <th>Special</th> -->
                  <th>Active</th>
                  <!-- <th style="width:10%;">Status</th> -->
                  <th style="text-align:right;width:5%;">Action</th>
                </tr>
                </thead>
                <tbody>
               
              	<?php 
				// print_r($bodycontent['groupList']);
              		$i = 1;
              		foreach ($bodycontent['groupList'] as $value) { 
              		
              		?>

					<tr>
						<td><?php echo $i++; ?></td>
            <td><?php echo $value->group_description; ?></td>
            <td><?php echo $value->main_category; ?></td>
            <td><?php echo $value->sub_category; ?></td>
            <!-- <td><?php //echo $value->is_special; ?></td> -->
            <td><?php echo $value->is_active; ?></td>
				
						
						
						<td align="center"> 
            <?php if($value->is_special!="Y"){ ?>
							<a href="<?php echo base_url(); ?>accounts/group/<?php echo $value->id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
								<span class="glyphicon glyphicon-pencil"></span>
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