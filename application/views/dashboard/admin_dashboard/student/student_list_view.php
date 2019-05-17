<script src="<?php echo base_url(); ?>assets/js/adm_scripts/admission.js"></script>  
<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/admin_style.css" />     
<style type="text/css">
  .searchby{

  float: right;

  margin-top: 4px;

}
.viewbtn{
  margin-left: 145px;
}
.orleb{
  
  margin-left: 170px;
}
</style>
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">List of Students</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Students</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <?php
              $attr = array("id"=>"StudentListForm","name"=>"StudentListForm");
              echo form_open('',$attr); ?>


                   <div class="row">
            <div class="col-md-4 "><label for="classList" class="searchby"> Registration No. </label> </div>
            <div class="col-md-4">
                      <div class="form-group">
                     
                     <select id="sel_reg" name="sel_reg" class="form-control selectpicker"
                        data-actions-box="true" data-live-search="true" >
                        <option value="">Select</option>
                          <?php 
                            if($bodycontent['studentList'])
                            {
                              foreach($bodycontent['studentList'] as $value)
                              { ?>
                                <option value="<?php echo $value->student_id; ?>"><?php echo $value->reg_no ; ?></option>
                            <?php 
                              }
                            }
                          ?>
                        </select>
                        </div>
                      <label for="classList" class="orleb">OR</label>
                  </div>
                </div>
            <div class="row">
            <div class="col-md-4 "><label for="classList" class="searchby"> Student Name </label> </div>
            <div class="col-md-4">
                      <div class="form-group">
                     
                     <select id="sel_name" name="sel_name" class="form-control selectpicker"
                        data-actions-box="true" data-live-search="true" >
                        <option value="">Select</option>
                          <?php 
                            if($bodycontent['StudentNameList'])
                            {
                              foreach($bodycontent['StudentNameList'] as $value)
                              { ?>
                                <option value="<?php echo $value->name; ?>"><?php echo $value->name ; ?></option>
                            <?php 
                              }
                            }
                          ?>
                        </select>
                        </div>
                      <label for="classList" class="orleb">OR</label>
                  </div>
                </div>
              <div class="row">
            <div class="col-md-4 "><label for="classList" class="searchby"> Class </label> </div>
            <div class="col-md-4">
                      <div class="form-group">
                     
                     
                       <select id="sel_class" name="sel_class" class="form-control selectpicker"
                        data-actions-box="true" data-live-search="true" >
                        <option value="">Select</option>
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
                 
                  </div>

             
                </div>

                   <div class="row">
            <div class="col-md-4 "><label for="classList" class="searchby"> Section </label> </div>
            <div class="col-md-4">
                      <div class="form-group">
                     
                     
                       <select id="sel_section" name="sel_section" class="form-control selectpicker"
                        data-actions-box="true" data-live-search="true" >
                         <option value="">Select</option>
                          <?php 
                            if($bodycontent['sectionList'])
                            {
                              foreach($bodycontent['sectionList'] as $value)
                              { ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->section ; ?></option>
                            <?php 
                              }
                            }
                          ?>
                        </select>
                        </div>
                 
                  </div>

             
                </div>
            

                 <div class="row">
                    <div class="col-md-offset-4 col-md-4 btnview">
              <button type="submit" class="btn btn-primary formBtn viewbtn" id="viewblocllist">View</button>
              </div>
                 </div>
             <?php echo form_close(); ?>

              <div class="dashboardloader" style="width: 100%; clear: both;display:none; ">
            <img src="<?php echo base_url();?>assets/images/verify_logo.gif"
             style="margin-left:auto;margin-right:auto;display:block;" />
           <p style="text-align:center;color:#055E87;letter-spacing:1px;">Please wait loading...</p>
            </div><br>
            <section id="loadStudentList"> 
               

             </section>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->





