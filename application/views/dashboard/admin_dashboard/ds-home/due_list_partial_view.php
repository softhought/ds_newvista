<script>
$(document).ready(function() {
    var groupColumn = 0;
    var table = $('#duelisttable').DataTable({
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "dom": 'Bfrtip',
        "buttons": [
          'excel', 'print'
        ],
        "order": [[ groupColumn, 'asc' ]],
        "displayLength": 10,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="10">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('#duelisttable tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            table.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            table.order( [ groupColumn, 'asc' ] ).draw();
        }
    } );

});
</script>
<div  id="Div_close">             
<section>
    <div class="box box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-green">
        <div class="widget-user-image">
          <img class="img-circle" src="<?php base_url(); ?>assets/images/list.png" alt="User Avatar">          
        </div>
        <!-- /.widget-user-image -->
        <div class="row">
            <h3 style="margin-left: 93px;"><?php //echo $groupbylist['listname']; ?>                     
            <button style="margin-right: 28px;" type="button" onclick=" $('#Div_close').hide();" class="close" >Close</button>
            </h3>
        </div>
        
      </div>
      <div class="box-footer"> 
        
      <div class="datatalberes" style="max-width:1100px;overflow-x:auto;">
     
              <table class="table table-bordered table-striped dataTables" id="duelisttable" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <!-- <th style="width:5%;">Sl</th> -->
                  <th style="width:5%;">Class</th>
                  <!-- <th style="width:10%;">Reg. No</th> -->
                  <th style="width:20%;">Name</th>
                  <!-- <th style="width:10%;">DOB</th> -->
                  <!-- <th >Blood Group</th>                  -->
                  <!-- <th >Section</th> -->
                  <!-- <th >Roll</th> -->
                  <th style="width:20%;">Payable Amount</th>
                  <!-- <th >Contact No</th> -->
                  <th style="width:20%;">Paid Amount</th>
                  <th style="width:20%;">Adjustment Amount</th>
                  <th style="width:20%;">Due Amount</th>
                
                  
                </tr>
                </thead>
                <tbody>
               
                <?php 
                  $i = 1;
                  $row=1;
                  if ($totalDueThisMonth) {
                    
                  foreach ($totalDueThisMonth as $class ) {
                  foreach ($class as $value ) {

                 //  echo $value['centerMasterData']->center_name;

                  
                  ?>

          <tr>
            <!-- <td><?php //echo $i++; ?></td> -->
            <td><?php echo "Class - ".$value['classname']; ?></td>
            <td style=""><?php echo $value['student_name']; ?></td>
            <!-- <td nowrap style="text-align: left;"><?php //echo $value->name; ?></td> -->
            <!-- <td><?php //if($value->dob!=""){ echo date('d-m-Y',strtotime($value->dob));} ?></td> -->
            <!-- <td><?php //echo $value->group; ?></td> -->
            <!-- <td><?php //echo $value->section; ?></td> -->
            <!-- <td><?php //echo $value->rollno; ?></td> -->
            <td nowrap style="text-align: right;"><?php echo $value['total_fees_amount']; ?></td>
            <!-- <td><?php //echo $value->father_contact_no; ?></td>    -->
            <td style="text-align: right;"><?php echo $value['paid_amount']; ?></td>  
            <td style="text-align: right;"><?php echo $value['adjustment_amount']; ?></td>  
            <td style="text-align: right;"><?php echo $value['total_due_amount_monthly']; ?></td>   
          </tr>
                    
                <?php $row++;
                  }
                }

                }

                ?>
             
                </tbody>
                
              </table>
             
            </div>
      </div>
  </div>
</section>
</div>