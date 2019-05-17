 <script>
$(document).ready(function(){
    
    $('#example').dataTable();   
});
</script>


   <!--           <div class="example" style="overflow-x:auto;">
              <table id="contralist" class="table table-bordered dataTables" style="border-collapse: collapse !important;">
<thead>

            <th>Account</th>
            <th>Closing</th>
            
    </thead>
    <tbody>
       <?php 
        if($result)  : 
                foreach ($result as $content) : ?>
        <tr>
            <td><?php echo($content['account_name']);?></td>
            <td><?php echo($content['opening_balance']);?></td>
        </tr>
      <?php endforeach; 
     else: ?>
         <tr> 
             <td>No</td>
             <td> data found</td>
         </tr>
    <?php
    endif; 
    ?>
    </tbody>
     </table>
     </div> -->

     <!-- Main content -->
    <section class="content">

<div class="box" style="width: 95%;">
<div class="box-header">
  <h3 class="box-title">Contra List</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
  <div class="datatalberes" style="overflow-x:auto;">
  <table id="example" class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
    <thead>
    <tr>
      <th style="width:10%;">Sl</th>
      <th>Account</th>
            <th>Closing</th>
    </tr>
    </thead>
    <tbody>
   
      <?php 
             
          $i = 1;
          foreach ($result as $content) { 
          
          ?>

        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo($content['account_name']);?></td>
            <td><?php echo($content['opening_balance']);?></td>


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
