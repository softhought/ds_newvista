<script src="<?php echo base_url(); ?>assets/js/adm_scripts/sectionandroll.js"></script>  
<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/admin_style.css" />     
<style>
.viewbtn{
  margin-left: 145px;
}
</style>


<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?php echo $bodycontent['module'] ;?></li>
    </ol>
</section>
 <!-- Main content -->
<section class="content">
    <div class="box">
        <!-- box-header -->
        <div class="box-header">
            <h3 class="box-title">Select Class</h3>        
        </div>
        <!-- /.box-header -->
        <!-- box-body -->
        <div class="box-body">
            <form id="StudentListForm">        
                <div class="row">                
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="form-group">         
                            <label for="classList" class="searchby"> Class </label>
                            <select id="classList" name="classList" class="form-control selectpicker"
                                data-actions-box="true" data-live-search="true" >
                                <option value="">Select Class</option>
                                <?php 
                                    if($bodycontent['classList'])
                                    {
                                    foreach($bodycontent['classList'] as $value)
                                    { ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->classname ; ?></option>
                                    <?php 
                                    }
                                    }
                                ?>
                            </select>
                        </div> 
                        <p id="clsmsg" class="form_error"></p>
                    </div>   
                </div>
               
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 btnview">
                        <button type="button" class="btn btn-primary formBtn viewbtn" onclick="viewList();" id="viewblocllist">View</button>
                    </div>
                </div>
            </form> 
            
            <!-- /.box-body -->  
            <div class="dashboardloader" style="width: 100%; clear: both;display:none; ">
                <img src="<?php echo base_url();?>assets/images/verify_logo.gif" style="margin-left:auto;margin-right:auto;display:block;" />
                <p style="text-align:center;color:#055E87;letter-spacing:1px;">Please wait loading...</p>
            </div><br>
            <section id="loadStudentList"> 
                <!-- student list will appear here -->
            </section>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->