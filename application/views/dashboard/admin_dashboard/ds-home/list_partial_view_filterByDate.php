<?php
// pre($todayAdmissionlist);
// echo "<br>";
?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


<script>
$(document).ready(function() {
    var groupColumn = 0;
    var table = $('#todayAdmissionlisttable').DataTable({
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
    $('#todayAdmissionlisttable tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            table.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            table.order( [ groupColumn, 'asc' ] ).draw();
        }
    } );



    $(".custom_frm_input").datepicker({
      format: 'dd/mm/yyyy'  
    });

    var basePath= $("#basepath").val();


$('#todayAdmissionlistbtn').on('click',function(){
    
  var from_date=$('#from_date').val(); 
  var to_date=$('#to_date').val();
  if(validateSrcDate())
  {
    $.ajax({        
        type: "POST",
        url: basePath + 'dashboard/FilterByDate',
        data:{from_date:from_date,to_date:to_date},
        dataType: "html",
        //contentType:"application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            $("#DetailList").html(result)
        },
        error: function(jqXHR, exception) {
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
    });
  }
});


} );
function validateSrcDate()
{  
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
   
    
    $("#payhismsg").text("").css("dispaly", "none").removeClass("form_error");
    if(from_date=="")
    {
        $("#from_date").focus();
        $("#payhismsg")
        .text("Error : Select From Date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(to_date=="")
    {
        $("#to_date").focus();
        $("#payhismsg")
        .text("Error : Select To Date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }


    return true;
}


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
      <div class="row"> 
        <div class="col-sm-12">
         <!-- <div class="col-sm-4"></div> -->
          <!-- <div class="col-sm-4"> -->
            <form class="form-inline" id='todayAdmissionlist'>
              <div class="form-group">
                <label for="from_date">From Date :</label>
                <input type="text" placeholder="dd/mm/yyyy" value="<?php if (!empty($from_date)) { echo $from_date; } ?>" autocomplete="off" class="form-control custom_frm_input"  name="from_date" id="from_date"   style="width: 204px;" />
              </div>
              <div class="form-group">
                <label for="to_date">To Date :</label>
                <input type="text" autocomplete="off"  class="form-control custom_frm_input" placeholder="dd/mm/yyyy"  value="<?php if (!empty($to_date)) { echo $to_date; } ?>"  name="to_date" id="to_date"  style="width: 204px;" />
              </div>              
              <button type="button" id="todayAdmissionlistbtn" class="btn btn-default">Search</button>
              <!-- <p id="payhismsg" class="form_error" style="display: none;"></p> -->
            </form> 
           <!-- </div> -->
         <!-- <div class="col-sm-4"></div> -->
        </div>    
      </div>    
      <div class="datatalberes" style="max-width:1100px;overflow-x:auto;">
     
              <table class="table table-bordered table-striped dataTables" id="todayAdmissionlisttable" style="border-collapse: collapse !important;">
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
                  if ($todayAdmissionlist) {
                    
                  foreach ($todayAdmissionlist as $value ) {
                //   foreach ($key as $value ) {

                 //  echo $value['centerMasterData']->center_name;

                  
                  ?>

          <tr>
            <!-- <td><?php echo $i++; ?></td> -->
            <td><?php echo "Class - ".$value->classname; ?></td>
            <td style="text-align: left;"><?php echo $value->reg_no; ?></td>
            <td nowrap style="text-align: left;"><?php echo $value->name; ?></td>
            <td><?php if($value->dob!=""){ echo date('d-m-Y',strtotime($value->dob));} ?></td>
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

