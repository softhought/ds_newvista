<script src="<?php echo base_url(); ?>assets/js/adm_scripts/fees_payment.js"></script>  
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/admin_style.css" />  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fees Receipt </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlockLarge">
              <div class="box-header with-border">
                <h3 class="box-title">Fees Receipt</h3>
                 
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <!--<form role="form" name="cityForm" id="cityForm"> -->
              <?php 
              $attr = array("id"=>"feesPaySearchForm","name"=>"feesPaySearchForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
                  <div class="row">
                   
                   <div class="col-md-2">
                         <div class="form-group">
                          <label for="acdm_class">Class</label>
                         <select id="acdm_class" name="acdm_class" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['classList'])
                          {
                          foreach($bodycontent['classList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" ><?php echo $value->classname; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                   </div>

                    <div class="col-md-2">
                          <div class="form-group">
                          <label for="acdm_section">Section</label>
                         <select id="acdm_section" name="acdm_section" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['sectionList'])
                          {
                          foreach($bodycontent['sectionList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>"  ><?php echo $value->section; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                   </div>


                    <div class="col-md-3">

                         <div class="form-group">
                          <label for="studentid">Student</label>
                        <div id="student_dropdown">
                         <select id="studentid" name="studentid" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                         

                        </select>
                        </div>

                        </div>

                   </div>


                   <div class="col-md-3">

                     <div class="form-group">
                          <label for="reg_no">Month</label>
                          <div id="sel_month_dropdown">
                          <select id="sel_month" name="sel_month[]" class="form-control selectpicker changmonth"  data-show-subtext="true" data-actions-box="true" data-live-search="true" multiple="multiple" >
                           
                        
                          <?php 
                          if($bodycontent['monthList'])
                          {
                          foreach($bodycontent['monthList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>"  ><?php echo $value->month_code; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>
                        </div>
                      

                        </div>
                   </div>

                   <div class="col-md-2">
                    <div class="form-group">

                     <button type="submit" class="btn btn-primary" id="searchbtn" style="margin-top: 25px;" > <i class="fa fa-search" aria-hidden="true"></i> Search </button>
                      <!-- <button class="btn btn-primary loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> Loading...</button> -->
                        
                     </div>
                   </div>

                 </div>
 
       

                  <p id="feepaymsg" class="form_error"></p>

                <section id="loadpaymentcomponent"> 
              

             </section>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="feepay_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->


    <!-- Modal -->
<div id="saveMsgModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-body">
        <p id="save-msg-data"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
      </div>
    </div>

  </div>
</div>
    

