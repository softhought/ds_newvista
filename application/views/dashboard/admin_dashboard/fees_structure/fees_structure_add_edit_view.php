<script src="<?php echo base_url(); ?>assets/js/adm_scripts/feesstructure.js"></script>  

   <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fees Structure  <?php echo $bodycontent['mode'];?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary formBlock">
              <div class="box-header with-border">
                <h3 class="box-title">Fees Structure </h3>
                 <a href="<?php echo base_url();?>feesstructure" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <!--<form role="form" name="cityForm" id="cityForm"> -->
              <?php 
              $attr = array("id"=>"feesStructureForm","name"=>"feesStructureForm");
              echo form_open('',$attr); ?>
                <div class="box-body">
                 
                <div class="form-group">
                    
                <input type="hidden" name="feesStrID" id="feesStrID" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['feesStructureEditdata']->id;}else{echo "0";}?>" />

                  <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode']; ?>" />

                    <label for="state">Class</label> 
                    <select id="classid" name="classid" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                     <option value="0">Select</option> 
                      <?php 
                      if($bodycontent['classList'])
                      {
                        foreach($bodycontent['classList'] as $classlist)
                        { ?>
                            <option value="<?php echo $classlist->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['feesStructureEditdata']->class_id==$classlist->id){echo "selected";}else{echo "";} ?> ><?php echo $classlist->classname; ?></option>
                <?php   }
                      }
                      ?>

                    </select>
                  </div>

                  <div class="form-group">
                  

                    <label for="feesdesc">Fees </label>
                    <div id="fees_dropdown">
                    <select id="feesid" name="feesid" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                     <option value="0">Select</option> 
                      <?php 
                      if($bodycontent['feesList'])
                      {
                        foreach($bodycontent['feesList'] as $feeslist)
                        { ?>
                            <option value="<?php echo $feeslist->id; ?>" <?php if(($bodycontent['mode']=="EDIT") && $bodycontent['feesStructureEditdata']->fees_id==$feeslist->id){echo "selected";}else{echo "";} ?> ><?php echo $feeslist->fees_desc; ?></option>
                      <?php   }
                      }
                      ?>

                    </select>
                    </div>
                  </div>

                    <div class="form-group">
                   

                    <label for="amount">Amount</label>
                    <input type="text" class="form-control forminputs typeahead" id="amount" name="amount" placeholder="Enter Amount" autocomplete="off" value="<?php if($bodycontent['mode']=="EDIT"){echo $bodycontent['feesStructureEditdata']->amount;}?>" >
                  </div>

                  <p id="feesstrmsg" class="form_error"></p>

                  <div class="btnDiv">
                      <button type="submit" class="btn btn-primary formBtn" id="feescomavebtn"><?php echo $bodycontent['btnText']; ?></button>
                      <!-- <button type="button" class="btn btn-danger formBtn" onclick="window.location.href='<?php echo base_url();?>district'">Go to List</button> -->
					  
					           <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                  </div>
                  
                </div>
                <!-- /.box-body -->

                <!-- <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div> -->
              <?php echo form_close(); ?>

              <div class="response_msg" id="feesstr_response_msg">
               
              </div>

            
            </div>
            <!-- /.box -->      
      </div>
    </div>

    </section>
    <!-- /.content -->

