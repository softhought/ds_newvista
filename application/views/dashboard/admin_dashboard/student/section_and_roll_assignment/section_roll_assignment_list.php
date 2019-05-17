<div class="datatalberes" style="overflow-x:auto;">
              <table class="table table-bordered table-striped dataTables" style="border-collapse: collapse !important;">
                <thead>
                <tr>
                  <th style="width:5%;">Sl</th>
                  <th style="width:10%;">Reg. No</th>
                  <th style="width:20%;">Name</th>
                  <th style="width:10%;">Class</th>
                  <th style="width:10%;">Section</th>
                  <th style="width:10%;">Roll</th>                  
                  <th style="width:10%;">Action</th>
                 
                  
                </tr>
                </thead>
                <tbody>
               
                <?php 
                
                  $i = 1;
                  $row=1;
                  if ($studentList) {
                    // print_r($studentList);
                  foreach ($studentList as $key => $value) {

                  //  echo $value['centerMasterData']->center_name;

                  
                  ?>
          
          <tr>
          
            <td><?php echo $i++; ?></td>
            <td><?php echo $value->reg_no; ?></td>
            <td><?php echo $value->name; ?></td>
            <td><?php echo $value->classname; ?></td>
            <td>
            <div class="form-group " id="section_<?php echo $row; ?>"> 
              <input type="hidden" name="student_id" id="student_id_<?php echo $row; ?>" value="<?php echo $value->student_id; ?>">
              <input type="hidden" name="class_id" id="class_id_<?php echo $row; ?>" value="<?php echo $value->class_id; ?>">
              <input type="hidden" name="school_id" id="school_id_<?php echo $row; ?>" value="<?php echo $value->school_id; ?>">
              <input type="hidden" name="acdm_session_id" id="acdm_session_id_<?php echo $row; ?>" value="<?php echo $value->acdm_session_id; ?>">
                <select id="classList_<?php echo $row; ?>" name="classList" class="form-control classList selectpicker"
                                    data-actions-box="true" data-live-search="true" >
                                    <option value="">Select Class</option>
                                    <?php 
                                    // print_r($sectionList);
                                        if($sectionList)
                                        {
                                        foreach($sectionList as $section)
                                        { ?>
                                            <option value="<?php echo $section->id; ?>" <?php 
                                                if ($value->section_id==$section->id) {
                                                    echo "Selected";
                                                }
                                             ?>><?php echo $section->section ; ?></option>
                                        <?php 
                                        }
                                        }
                                    ?>
                </select>
                <span id="select_error_<?php echo $row; ?>" style="display:none;" class="help-block"></span>
            </div>
            </td>
            <td>
                <div class="form-group" id="roll_<?php echo $row; ?>"> 
                  <input  type="text" class="form-control roll_no "  name="roll_no" id="roll_no_<?php echo $row; ?>" placeholder="Enter Roll No." value="<?php if($value->rollno!=""){ echo $value->rollno; }?>">
                  <span id="error_<?php echo $row; ?>" style="display:none;" class="help-block"></span>
                </div>
            </td>         
            
            
           
             <td align="center"> 
             <div class="btnDiv">
             <?php
              if($value->rollno!="" && $value->section_id!="")
              { 
                echo '<button id="btn_'.$row.'" onclick="UpdateRollSection(this);" class="btn update-btn btn-primary">Updated</button>'; 
              }else{
                  echo '<button id="btn_'.$row.'" onclick="UpdateRollSection(this);" class="btn submit-btn btn-info">Update</button>';
              }
              ?>              
              <button id="loaderbtn_<?php echo $row;?>" style="display:none;" class="btn m-progress btn-primary">Updating..</button>
              
              </div>
            </td>
          
          </tr>
          
                    
                <?php $row++;
                  }

                }

                ?>
             
                </tbody>
               
              </table>
            </div>