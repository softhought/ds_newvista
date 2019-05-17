<script src="<?php echo base_url(); ?>assets/js/adm_scripts/fees_payment.js"></script>  
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
.req-star-mark{color: red;}
</style>
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Receipt History</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

		    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Receipt History</h3>
             
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <?php
              $attr = array("id"=>"PaymentHistoryForm","name"=>"PaymentHistoryForm");
              echo form_open('',$attr); ?>


       

            <div class="row">
            <div class="col-md-4 "><!-- <label for="classList" class="searchby"> From Date </label> --> </div>
            <div class="col-md-2" style="">
                <div class="form-group">
                     <label for="from_date">From Date<span class="req-star-mark">*</span></label>
                     <input type="text"  class="form-control custom_frm_input datepicker"  name="from_date" id="from_date"  placeholder="dd-mm-yy" value="" style="" />
                        </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                     <label for="to_date">To Date<span class="req-star-mark">*</span></label>
                     <input type="text"  class="form-control custom_frm_input datepicker"  name="to_date" id="to_date"  placeholder="dd-mm-yy" value="" style="" />
                        </div>
            </div>
           </div>

         

            <div class="row">
            <div class="col-md-4 "><label for="classList" class="searchby">Class </label> </div>
            <div class="col-md-4">
                      <div class="form-group">
                     
                     
                       <select id="acdm_class" name="acdm_class" class="form-control selectpicker"
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
                     
                     
                       <select id="acdm_section" name="acdm_section" class="form-control selectpicker"
                        data-actions-box="true" data-live-search="true" >
                         <option value="0">Select</option>
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
            <div class="col-md-4 "><label for="classList" class="searchby"> Student </label> </div>
            <div class="col-md-4">
                   <div class="form-group">
                          
                        <div id="student_dropdown">
                         <!-- <select id="studentid" name="studentid" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                        </select> -->
                        <select id="studentid" name="studentid" class="form-control selectpicker" class="form-control selectpicker"
                       data-show-subtext="true" data-actions-box="true" data-live-search="true"  >
                          <option value="0">Select</option> 
                            <?php
                                foreach ($bodycontent['studentList'] as $key => $value) { ?>
                                <option value="<?php echo $value->student_id; ?>"><?php echo $value->name."  [Roll-".$value->rollno."]"; ?></option>
                            <?php	} ?>
                        </select>
                        </div>

                        </div>
            </div>
           </div>
            
         <p id="payhismsg" class="form_error"></p>
                 <div class="row">
                    <div class="col-md-offset-4 col-md-4 btnview">
              <button type="submit" class="btn btn-primary formBtn viewbtn" id="viewpaymenthistory">View</button>
              </div>
                 </div>
             <?php echo form_close(); ?>

              <div class="dashboardloader" style="width: 100%; clear: both;display:none; ">
            <img src="<?php echo base_url();?>assets/images/verify_logo.gif"
             style="margin-left:auto;margin-right:auto;display:block;" />
           <p style="text-align:center;color:#055E87;letter-spacing:1px;">Please wait loading...</p>
            </div><br>
            <section id="loadpaymentList"> 

                   
               

             </section>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->





