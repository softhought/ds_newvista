<script src="<?php echo base_url(); ?>assets/js/adm_scripts/admission.js"></script>  
  <style type="text/css">
   .file {
  visibility: hidden;
  position: absolute;
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
        <li class="active">Registration  <?php echo $bodycontent['mode'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlockLarge">
              <div class="box-header with-border">
                <h3 class="box-title">Student Registration </h3>
                
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <!--<form role="form" name="cityForm" id="cityForm"> -->
              <form class="form-area" name="AdmissionForm" id="AdmissionForm" enctype="multipart/form-data" method="post">
                <div class="box-body">
                 
 

                  <div class="form-group">
                    <input type="hidden" name="studentID" id="studentID" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->student_id;}else{echo "0";}?>" />

                    <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />

                    
                  </div>
                  <p id="adm_info_error" class="form_error"></p>
                   <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span> Admission Info</p>
                   <div class="row">
                   <div class="col-md-12">

                          <div class="row">
                         <div class="col-md-8" style="#border: 1px solid blue;">

                           <div class="row">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div id="reg_no_err">
                        <div class="form-group">
                          <label for="reg_no">Reg. No<span class="req-star-mark">*</span></label>
                          <input type="text" class="form-control forminputs removeerr" id="reg_no" name="reg_no" placeholder="Enter Registration No" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->reg_no; } ?>" />

                         </div>
                         
                         
                        </div>
                      </div>
                       <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="form_sl_no">Form Sl No.<span class="req-star-mark">*</span></label>
                        <input type="text" class="form-control forminputs removeerr" id="form_sl_no" name="form_sl_no" placeholder="Enter Form Serial" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->form_sl_no; } ?>" />
                        </div>
                      </div>

                       <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                <label>Date of Admission
                <!-- <span class="req-star-mark">*</span> -->
                </label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control pull-right datemaskk" id="admdt" name="admdt" type="text" value="<?php if($bodycontent['mode']=="EDIT" && $bodycontent['studentEditdata']->admission_dt!=null){echo date("d/m/Y",strtotime($bodycontent['studentEditdata']->admission_dt));}  ?>">
                  

                </div>
                <!-- /.input group -->
              </div>
              
                  </div>
                   
                    </div>

                     <div class="row">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="student_name">Student Name<span class="req-star-mark">*</span></label>
                          <input type="text" class="form-control forminputs removeerr" id="student_name" name="student_name" placeholder="Enter Student Name" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->name; } ?>" />

                        </div>
                      </div>

                          <div class="col-md-4 col-sm-12 col-xs-12">
                         <div class="form-group">
                            <label>Date of Birth
                            <!-- <span class="req-star-mark">*</span> -->
                            </label>

                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input class="form-control pull-right datemaskk" id="studentdob" name="studentdob" type="text" value="<?php if($bodycontent['mode']=="EDIT" && $bodycontent['studentEditdata']->dob!=null ){echo date("d/m/Y",strtotime($bodycontent['studentEditdata']->dob));}?>" >
                            </div>
                          
                            <!-- /.input group -->
                          </div>
                          
                  </div>

                  <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Gender<span class="req-star-mark">*</span></label>
                         <select id="gender" name="gender" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          pre($bodycontent['genderList']);
                          if($bodycontent['genderList'])
                          {
                          foreach($bodycontent['genderList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->gender_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->gender; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>
                       
                   
                   
                    </div>

                    <div class="row">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Blood Group</label>
                         <select id="bloodgroup" name="bloodgroup" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['bloodgroupList'])
                          {
                          foreach($bodycontent['bloodgroupList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->blood_gr_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->group; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>

                      <!-- <div class="col-md-4 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label for="caste">Caste</label>
                            <select id="caste" name="caste" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="0">Select</option> 
                            <?php 
                            // if($bodycontent['casteList'])
                            // {
                            // foreach($bodycontent['casteList'] as $value)
                            // { ?>
                              <option value="<?php //echo $value->id; ?>" <?php //if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->caste_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->caste; ?></option>
                            <?php  
                            //  }
                            // }
                            ?>

                          </select>
                        </div>
                      </div> -->

                  <!-- <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="religion">Religion</label>
                         <select id="religion" name="religion" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          // if($bodycontent['religionList'])
                          // {
                          // foreach($bodycontent['religionList'] as $value)
                          // { ?>
                            <option value="<?php //echo $value->id; ?>" <?php //if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->religion_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->religion; ?></option>
                      <?php   
                          // }
                          // }
                          ?>

                        </select>

                        </div>
                      </div> -->
                       
                   
                   
                    </div>

                      


                    
                          </div>
                          <div class="col-md-4" style="#border: 1px solid green;">
                            <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="student_picture" style="width: 145px;height:164px;border: 2px solid #6d78cb;margin-left:80px;margin-bottom:13px; ">
                              <img id="profile_img" src="<?php if($bodycontent['mode']=="EDIT"){

                                if($bodycontent['studentEditdata']->is_file_uploaded=='Y'){
echo base_url()."assets/documents/profile_picture/".$bodycontent['studentEditdata']->random_file_name;
                                  }else{
                                    echo base_url()."assets/images/profile_pic_avter.png";
                                  }

                              }else{
                                echo base_url()."assets/images/profile_pic_avter.png";
                              }?>" alt="Profile Picture" style="width:141px;height:160px;">

                              <input type="hidden" id="derault_profile_src" name="derault_profile_src" value="<?php echo base_url(); ?>assets/images/profile_pic_avter.png">
                            </div>
                            

                        </div>
                        </div>

                          <div class="row">
                      <div class="col-md-offset-2 col-md-10 col-sm-12 col-xs-12">
<!-- Upload Profile picture  -->
                        <?php $rowno=1;?>


<!--              
 <div class="form-group">
    
    
          <input type="hidden" name="prvFilename[]" id="prvFilename_0_<?php echo $rowno; ?>" class="form-control prvFilename" value="" readonly >

          <input type="hidden" name="randomFileName[]" id="randomFileName_0_<?php echo $rowno; ?>" class="form-control randomFileName" value="" readonly >

          <input type="hidden" name="docDetailIDs[]" id="docDetailIDs_0_<?php echo $rowno; ?>" class="form-control randomFileName" value="0" readonly >
      
        <input type="file" name="fileName[]" class="file fileName" id="fileName_0_<?php echo $rowno; ?>" accept=".jpg , .jpeg , .png" />
        <div class="input-group col-xs-12">
             
          <input type="text" name="userFileName[]" id="userFileName_0_<?php echo $rowno; ?>" class="form-control input-xs userFileName" readonly placeholder="Upload Picture" >

            <input type="hidden" name="isChangedFile[]" id="isChangedFile_0_<?php echo $rowno; ?>" value="Y" >
            <span class="input-group-btn">
              <button class="browse btn btn-primary input-xs" type="button" id="uploadBtn_0_<?php echo $rowno; ?>">
                  <i class="fa fa-folder-open" aria-hidden="true"></i>
            </button>
              </span>
        </div>
     
</div> -->



 <div class="form-group">
    
       <label for="subcode">Maximum file size 500KB </label>
          <input type="hidden" name="prvFilename[]" id="prvFilename_0_<?php echo $rowno; ?>" class="form-control prvFilename" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->user_file_name;}else{echo "";}?>" readonly >

          <input type="hidden" name="randomFileName[]" id="randomFileName_0_<?php echo $rowno; ?>" class="form-control randomFileName" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->random_file_name;}else{echo "";}?>" readonly >

          <input type="hidden" name="docDetailIDs[]" id="docDetailIDs_0_<?php echo $rowno; ?>" class="form-control randomFileName" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->docid;}else{echo "0";}?>" readonly >
      
        <input type="file" name="fileName[]" class="file fileName" id="fileName_0_<?php echo $rowno; ?>" accept=".jpg , .jpeg , .png" />
        <div class="input-group col-xs-12">
             <!--  <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span> -->
          <input type="text" name="userFileName[]" id="userFileName_0_<?php echo $rowno; ?>" class="form-control input-xs userFileName" readonly placeholder="Upload Document" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->user_file_name;}?>" >

            <input type="hidden" name="isChangedFile[]" id="isChangedFile_0_<?php echo $rowno; ?>" value="<?php if($bodycontent['mode']=="EDIT"){echo "N";}else{echo "N";}?>" >
            <span class="input-group-btn">
              <button class="browse btn btn-primary input-xs" type="button" id="uploadBtn_0_<?php echo $rowno; ?>">
                  <i class="fa fa-folder-open" aria-hidden="true"></i>
            </button>
              </span>
        </div>
     


</div>

<!-- End of Upload Profile picture  -->
                   
                     </div>
                        </div>


                    
                          </div>
                          </div>



                   </div>
                   </div>



                   <div class="row">
                       <div class="col-md-12">

                      <div class="row">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Father Name<span class="req-star-mark">*</span></label>
                         <input type="text" class="form-control forminputs removeerr" id="father_name" name="father_name" placeholder="Enter Father Name" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->father_name; } ?>" />


                        </div>
                      </div>

                        <div class="col-md-3 col-sm-12 col-xs-12" id="father_contact_no_d">
                        <div class="form-group" > 
                          <label for="reg_no">Father Contact No <span class="req-star-mark">*</span></label></label>
                        <input type="text" class="form-control forminputs removeerr" id="father_contact_no" name="father_contact_no" placeholder="Enter Father Contact " autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->father_contact_no; } ?>" />

                        </div>
                          
                        </div>

                  <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Father Occupation</label>
                         <select id="father_occupation" name="father_occupation" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['occupationList'])
                          {
                          foreach($bodycontent['occupationList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->father_occupation_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->occupation; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>
            
              <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Father Income</label>
                        <input type="text" class="form-control forminputs removeerr" id="father_income" name="father_income" placeholder="Enter Father Income" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->fathers_income; } ?>" />

                        </div>
                          
                        </div>
                       
                   
                   
                    </div>



                     <div class="row">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Mother Name</label>
                         <input type="text" class="form-control forminputs removeerr" id="mother_name" name="mother_name" placeholder="Enter Mother Name" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->mother_name; } ?>" />


                        </div>
                      </div>

                        <div class="col-md-3 col-sm-12 col-xs-12" id="mother_contact_no_d">
                        <div class="form-group">
                          <label for="reg_no">Mother Contact No</label>
                        <input type="text" class="form-control forminputs removeerr" id="mother_contact_no" name="mother_contact_no" placeholder="Enter Mother Contact " autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->mother_contact_no; } ?>" />

                        </div>
                          
                        </div>

                  <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Mother Occupation</label>
                         <select id="mother_occupation" name="mother_occupation" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['occupationList'])
                          {
                          foreach($bodycontent['occupationList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->mother_occupation_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->occupation; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>
            
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Mother Income</label>
                        <input type="text" class="form-control forminputs removeerr" id="mother_income" name="mother_income" placeholder="Enter Mother Income" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->mother_income; } ?>" />

                        </div>
                          
                        </div>
                       
                   
                   
                    </div>

                       <div class="row">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Guardian<span class="req-star-mark">*</span></label>
                         <input type="text" class="form-control forminputs removeerr" id="guardian_name" name="guardian_name" placeholder="Enter Guardian Name" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->guardian_name; } ?>" />


                        </div>
                      </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                          <label for="reg_no">Relation<span class="req-star-mark">*</span></label>
                         <select id="guardian_relation" name="guardian_relation" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['relationList'])
                          {
                          foreach($bodycontent['relationList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->relationship_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->relation; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                          
                        </div>

                   
                    </div>

                    <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span> Present Address</p>

                     <div class="row">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Area</label>
                         <input type="text" class="form-control forminputs removeerr" id="present_area" name="present_area" placeholder="Enter Area" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->present_area; } ?>" />


                        </div>
                      </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                          <label for="reg_no">Town</label>
                         <input type="text" class="form-control forminputs removeerr" id="present_town" name="present_town" placeholder="Enter Town" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->present_town; } ?>" />


                    </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">P.O</label>
                         <input type="text" class="form-control forminputs removeerr" id="present_po" name="present_po" placeholder="Enter Post Office" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->present_po; } ?>" />


                        </div>
                      </div>
            
                     <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">P.S</label>
                         <input type="text" class="form-control forminputs removeerr" id="present_ps" name="present_ps" placeholder="Enter Police Station" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->present_ps; } ?>" />


                        </div>
                      </div>


                    </div>

                    <div class="row">
                     
                     <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label for="reg_no">Pin Code</label>
                           <input type="text" class="form-control forminputs removeerr" id="present_pin" name="present_pin" placeholder="Enter Pin Code" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->present_pin; } ?>" />


                          </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">State</label>
                         <select id="present_state" name="present_state" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['stateList'])
                          {
                          foreach($bodycontent['stateList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if($value->id=='41'){echo "selected";}else{echo "";};?> <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->present_state_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->name; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>


                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">District</label>
                          <div id="present_dist_dropdown">
                         <select id="present_dist" name="present_dist" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['districtList'])
                          {
                          foreach($bodycontent['districtList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->present_dist_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->name; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>
                      </div>

                        </div>
                      </div>

                  </div>

                   <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span> Permament Address</p>
                   <input type="checkbox" name="adr_check" id="adr_check" value="Permanemt">&nbsp;Same As Present Address(Tick If Yes)<br>

                   <div class="row">
                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Area</label>
                         <input type="text" class="form-control forminputs removeerr" id="area" name="area" placeholder="Enter Area" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->area; } ?>" />


                        </div>
                      </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                          <label for="reg_no">Town</label>
                         <input type="text" class="form-control forminputs removeerr" id="town" name="town" placeholder="Enter Town" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->town; } ?>" />


                    </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">P.O</label>
                         <input type="text" class="form-control forminputs removeerr" id="post_office" name="post_office" placeholder="Enter Post Office" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->post_office; } ?>" />


                        </div>
                      </div>
            
                     <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">P.S</label>
                         <input type="text" class="form-control forminputs removeerr" id="police_station" name="police_station" placeholder="Enter Police Station" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->police_station; } ?>" />


                        </div>
                      </div>
                      </div>

                        <div class="row">
                         <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label for="reg_no">Pin Code</label>
                           <input type="text" class="form-control forminputs removeerr" id="pin_code" name="pin_code" placeholder="Enter Pin Code" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->pin_code; } ?>" />


                          </div>
                        </div>

                       <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">State</label>
                         <select id="state" name="state" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['stateList'])
                          {
                          foreach($bodycontent['stateList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if($value->id=='41'){echo "selected";}else{echo "";};?> <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->present_state_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->name; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>

                        </div>
                      </div>

                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">District</label>
                          <div id="district_dropdown">
                         <select id="district" name="district" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['districtList'])
                          {
                          foreach($bodycontent['districtList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->present_dist_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->name; ?></option>
                      <?php   }
                          }
                          ?>

                        </select>
                      </div>

                        </div>
                      </div>



                    </div>
                    <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span> Academic Details</p>
                      <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Session<span class="req-star-mark">*</span></label>
                         <select id="academic_session" name="academic_session" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <!-- <option value="0">Select</option>  -->
                          <?php 
                          if($bodycontent['sessionList'])
                          {
                          foreach($bodycontent['sessionList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->acdm_session_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->start_yr."-".$value->end_yr; ?></option>
                        <?php   }
                          }
                          ?>

                        </select>

                        </div>
                        </div>

                           <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Class<span class="req-star-mark">*</span></label>
                         <select id="acdm_class" name="acdm_class" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['classList'])
                          {
                          foreach($bodycontent['classList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->class_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->classname; ?></option>
                        <?php   }
                          }
                          ?>

                        </select>

                        </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label for="reg_no">Section</label>
                         <select id="acdm_section" name="acdm_section" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                         <option value="0">Select</option> 
                          <?php 
                          if($bodycontent['sectionList'])
                          {
                          foreach($bodycontent['sectionList'] as $value)
                          { ?>
                            <option value="<?php echo $value->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['studentEditdata']->section_id==$value->id){echo "selected";}else{echo "";} ?> ><?php echo $value->section; ?></option>
                        <?php   }
                          }
                          ?>

                        </select>

                        </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label for="reg_no">Roll</label>
                            <input type="text" class="form-control forminputs removeerr" id="acdm_roll" name="acdm_roll" placeholder="Enter Roll" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['studentEditdata']->rollno; } ?>" />

                          </div>
                            
                        </div>
                        
                   
                      </div>
                      <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span>Account Details</p>
                   <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                          <?php if($bodycontent['mode']=="EDIT"){echo "<input type='hidden' name='account' id='account' value='".$bodycontent['studentEditdata']->account_id."'>";} ?> 
                            <label for="account_group">Account Group<span class="req-star-mark">*</span></label>
                          <select id="account_group" name="account_group" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                          <option value="">Select Group</option> 
                            <?php 
                            if($bodycontent['accountGroupList'])
                            {
                              // pre($bodycontent['groupIdToselect']->group_id);
                            foreach($bodycontent['accountGroupList'] as $value)
                            { ?>
                           
                              <option value="<?php echo $value->id; ?>"  <?php if(($bodycontent['mode']=="EDIT" && !empty($bodycontent['groupIdToselect']))){if($bodycontent['groupIdToselect']->group_id==$value->id){echo "selected";}else{echo "";}} ?> ><?php echo $value->group_description; ?></option>
                          <?php   }
                            }
                            ?>

                          </select>

                          </div>
                        </div>
                      </div>
                   </div>
                      <?php if($bodycontent['mode']=="EDIT"){?>

                       <p class="formSubTitle"><span class="glyphicon glyphicon-pencil"></span> Academic Historical data</p>

                  <div class="row">
                       <div class="col-md-12">
                                 
                  
                                      <table class="table table-bordered table-striped table-condensed">
                                        <thead style="background-color: #669dbd;color: #fff;">
                                          <tr>
                                            <th>Sl. No.</th>
                                            <th>Academic Session</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Roll</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php  
                                          $acdsl=1;
                                          if($bodycontent['studentAcademicData']) {
                                             foreach($bodycontent['studentAcademicData'] as $value){

                                            ?>
                                          <tr>
                                            <td><?php echo $acdsl++;?></td>
                                            <td><?php echo $value->start_yr."-".$value->end_yr?></td>
                                            <td><?php echo $value->classname;?></td>
                                            <td><?php echo $value->section?></td>
                                            <td><?php echo $value->rollno?></td>
                                          </tr>
                                        <?php }}?>

                                        </tbody>
                                      </table>
                                 

                              </div>

                          </div>

                        <?php }?>





                       </div>
                       
                   </div>
                  
                  

                  <p id="admmsg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="admsavebtn"><?php echo $bodycontent['btnText']; ?></button>
                      <!-- <button type="button" class="btn btn-danger formBtn" onclick="window.location.href='<?php echo base_url();?>district'">Go to List</button> -->
					  
					           <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              
            </form>

              <div class="response_msg" id="adm_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->

