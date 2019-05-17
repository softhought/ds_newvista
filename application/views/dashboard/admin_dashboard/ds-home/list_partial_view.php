<?php
// pre($Studentlist);
// echo "<br>";
?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


<script>
$(document).ready(function() {
    var groupColumn = 0;
    var table = $('#Studentlisttable').DataTable({
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
    $('#Studentlisttable tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            table.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            table.order( [ groupColumn, 'asc' ] ).draw();
        }
    } );
} );


</script>

<style>
tr.group,
tr.group:hover {
    background-color: #ddd !important;
}
</style>

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
     
              <table class="table table-bordered table-striped dataTables" id="Studentlisttable" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <!-- <th style="width:5%;">Sl</th> -->
                  <th style="width:5%;">Class</th>
                  <th style="width:10%;">Reg. No</th>
                  <th style="width:20%;">Name</th>
                  <th style="width:10%;">DOB</th>
                  <th >Blood Group</th>                 
                  <th >Section</th>
                  <th >Roll</th>
                  <th style="width:20%;">Father Name</th>
                  <th >Contact No</th>
                  <th style="width:20%;">Present Address</th>
                  <th style="width:20%;">Permament Address</th>
                
                  
                </tr>
                </thead>
                <tbody>
               
                <?php 
                  $i = 1;
                  $row=1;
                  if ($Studentlist) {
                    
                  foreach ($Studentlist as $value ) {
                //   foreach ($key as $value ) {

                 //  echo $value['centerMasterData']->center_name;

                  
                  ?>

          <tr>
            <!-- <td><?php echo $i++; ?></td> -->
            <td><?php echo "Class - ".$value->classname; ?></td>
            <td style="text-align: left;"><?php echo $value->reg_no; ?></td>
            <td nowrap style="text-align: left;"><?php echo $value->name; ?></td>
            <td><?php if($value->dob!=""){echo date('d-m-Y',strtotime($value->dob));}else{ echo "";} ?></td>
            <td><?php echo $value->group; ?></td>
            <td><?php echo $value->section; ?></td>
            <td><?php echo $value->rollno; ?></td>
            <td nowrap style="text-align: left;"><?php echo $value->father_name; ?></td>
            <td><?php echo $value->father_contact_no; ?></td>   
            <td><?php echo $value->present_area.",".$value->present_town.",".$value->present_po.",".$value->present_ps.",".$value->present_stateName.",".$value->present_distName."-".$value->present_pin; ?></td>  
            <td><?php echo $value->area.",".$value->town.",".$value->post_office.",".$value->police_station.",".$value->stateName.",".$value->distName."-".$value->pin_code; ?></td>   
          </tr>
                    
                <?php $row++;
                //   }
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

