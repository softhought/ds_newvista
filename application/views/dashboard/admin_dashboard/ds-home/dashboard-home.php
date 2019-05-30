<script src="<?php echo base_url(); ?>assets/js/adm_scripts/dashboard.js"></script> 
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

<!-- changed on 11/12/18 by sandipan sarkar -->
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
         <div class="col-lg-3 col-xs-6">
    <!--  small box -->
     <div class="small-box bg-aqua">
       <div class="inner">
         <h3><?php echo $bodycontent['activeStdentCount'] ;?></h3>
   
         <p>Total Student</p>
       </div>
       <div class="icon">
         <i class="ion ion-ios-people-outline"></i>
       </div>
       <a href="javascript:void(0);" class="small-box-footer" id="Studentlist" onclick="OpenStudentList($(this).attr('id'))">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div> 
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
       <!-- small box -->
       <div class="small-box bg-green">
         <div class="inner">
           <h3><?php echo $bodycontent['todayAdmissionCount'] ;?></h3>
           <p>Today's Admission</p>
         </div>
         <div class="icon">
           <i class="ion ion-stats-bars"></i>
         </div>
         <a href="javascript:void(0);" class="small-box-footer" id="todayAdmissionlist" onclick="OpenStudentList($(this).attr('id'))">More info <i class="fa fa-arrow-circle-right"></i></a>
       </div>
     </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php  if($bodycontent['TodayCollectionSum']!=""){ echo $bodycontent['TodayCollectionSum']; }else{ echo "0";} ?></h3>
            <p>Today's Collection</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo $bodycontent['totalDueThisMonth']; ?></h3>
      
            <p>Total Due of This Month</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="javascript:void(0);" class="small-box-footer" id="totalDueThisMonthList" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->



  <div class="jumbotron jumbotron-fluid" style="text-align:center;background: transparent;">
    <div class="container">
      <div id="DetailList">
      <h1 class="display-4" style="font-size: 3em;">Welcome to New Vista Academy </h1>
      </div>
        
    
    </div>
  </div>

</section>
    <!-- /.content -->