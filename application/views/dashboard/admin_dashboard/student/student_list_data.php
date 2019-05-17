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
                  <th style="width:20%;">Father Name</th>
                  <th style="width:10%;">Contact No</th>

               
                
                  <!-- <th style="width:10%;">DOB</th> -->
                  <th style="width:10%;">Action</th>
                 
                  
                </tr>
                </thead>
                <tbody>
               
                <?php 
                  $i = 1;
                  $row=1;
                  if ($studentList) {
                    
                  foreach ($studentList as $key => $value) {

                  //  echo $value['centerMasterData']->center_name;

                  
                  ?>

          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $value->reg_no; ?></td>
            <td><?php echo $value->name; ?></td>
            <td><?php echo $value->classname; ?></td>
            <td><?php echo $value->section; ?></td>
            <td><?php echo $value->rollno; ?></td>
            <td><?php echo $value->father_name; ?></td>
            <td><?php echo $value->father_contact_no; ?></td>
            
            <!-- <td><?php echo date("d-m-y", strtotime($value->dob));?></td>
                       -->
           
             <td align="center"> 
              <a href="<?php echo base_url(); ?>student/addstudent/<?php echo $value->student_id; ?>" class="btn btn-primary btn-xs" data-title="Edit">
                <span class="glyphicon glyphicon-pencil"></span>
              </a>
            
            </td>
         
          </tr>
                    
                <?php $row++;
                  }

                }

                ?>
             
                </tbody>
               
              </table>
            </div>