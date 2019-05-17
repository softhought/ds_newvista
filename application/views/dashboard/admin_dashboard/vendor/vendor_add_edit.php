<script src="<?php echo base_url(); ?>assets/js/adm_scripts/vendor.js"></script>  
<?php

    // print_r($bodycontent['vendorEditData']);


?>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vendor  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlockLarge">
                <div class="box-header with-border">
                    <h3 class="box-title">Vendor </h3>
                    <a href="<?php echo base_url();?>vendor" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                  
                    <form method="post" id="vendorForm" >
                        <?php if($bodycontent['mode']=="EDIT"){
                           echo '<input type="hidden" name="vendor_id" id="vendor_id" value="'.$bodycontent["vendor_id"].'">';
                           echo '<input type="hidden" name="account_id" id="account_id" value="'.$bodycontent["vendorEditData"]->account_master_id.'">';
                       }  ?>
                    <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode'];?>">
                        <div id="vendor_name_div" class="form-group col-md-6">                            
                            <label for="vendor_name">Name *</label>
                            <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="<?php  if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['vendorEditData']->name;} ?>"  placeholder="Name" >
                        </div>
                        <div id="address_div" class="form-group col-md-6">                            
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php  if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['vendorEditData']->address;} ?>"  placeholder="Address">
                        </div>
                        <div id="gst_no_div" class="form-group col-md-6">                            
                            <label for="gst_no">GST No.</label>
                            <input type="text" class="form-control" name="gst_no" id="gst_no" value="<?php  if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['vendorEditData']->gst_no;} ?>"  placeholder="GST No.">
                        </div>
                        <div id="contact_no_div" class="form-group col-md-6">                            
                            <label for="contact_no">Contact No.</label>
                            <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['vendorEditData']->contact_no;} ?>"  placeholder="Contact No.">
                        </div>
                        <div id="contact_persone_div" class="form-group col-md-6">                            
                            <label for="contact_persone">Contact Persone</label>
                            <input type="text" class="form-control" name="contact_persone" id="contact_persone" value="<?php     if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['vendorEditData']->contact_persone;} ?>"  placeholder="Contact Persone">
                        </div>
                        <div id="state_id_div" class="form-group col-md-6">                            
                            <label for="state_id">State*</label>
                            <select class="form-control selectpicker" data-show-subtext="true" name="state_id" id="state_id" data-live-search="true"  >
                            <option  value="">Select State</option>
                            <?php foreach ($bodycontent['stateList'] as $value) { ?>
                                <option  value="<?php echo $value->id; ?>" 
                                <?php if ($bodycontent['mode']=="EDIT"){
                                    if ($bodycontent['vendorEditData']->state_id==$value->id) {
                                       echo " selected";
                                    }
                               } ?>
                                ><?php echo $value->name; ?></option>   
                            <?php  }  ?>
                                
                            </select>
                        </div>
                        <div id="group_id_div" class="form-group col-md-6">                            
                            <label for="group_id">Account Group*</label>
                            <select class="form-control selectpicker" data-show-subtext="true" name="group_id" id="group_id" data-live-search="true" >
                            <option  value="">Select Group</option>
                            <?php foreach ($bodycontent['groupList'] as $value) { ?>
                                <option  value="<?php echo $value->id; ?>" data-tokens="<?php echo $value->group_description; ?>" 
                                <?php if ($bodycontent['mode']=="EDIT" && !empty($bodycontent['groupIdToselect']->group_id)){
                                    if ($bodycontent['groupIdToselect']->group_id==$value->id) {
                                       echo " selected";
                                    }
                               } ?>
                                ><?php echo $value->group_description; ?></option>   
                            <?php  }  ?>
                                
                            </select>
                        </div> 
                        <div id="bank_ifsc_div" class="form-group col-md-6">
                                    <label for="bank_ifsc">IFSC</label>
                                    <input type="text" class="form-control desablecls" name="bank_ifsc" id="bank_ifsc" <?php if ($bodycontent['mode']=="EDIT"){ if ($bodycontent['vendorEditData']->bank_ifsc!=""){ echo "value='".$bodycontent['vendorEditData']->bank_ifsc."'";} }?>  placeholder="IFSC Code">
                               </div>
                               <div id="bank_ac_no_div" class="form-group col-md-6">
                                    <label for="bank_ac_no">A/C No.</label>
                                    <input type="text" class="form-control desablecls" name="bank_ac_no" id="bank_ac_no" <?php if ($bodycontent['mode']=="EDIT"){ if ($bodycontent['vendorEditData']->bank_ac_no!=""){ echo "value='".$bodycontent['vendorEditData']->bank_ac_no."'"; } }?>  placeholder="A/C No.">
                               </div>
                               <div id="bank_address_div" class="form-group col-md-6">
                                    <label for="bank_address">Bank Address</label>
                                    <input type="text" class="form-control desablecls" name="bank_address" id="bank_address" <?php if ($bodycontent['mode']=="EDIT"){ if ($bodycontent['vendorEditData']->bank_address!=""){  echo "value='".$bodycontent['vendorEditData']->bank_address."'"; } }?>  placeholder="Bank Address">
                               </div>
                               <div id="bank_branch_div" class="form-group col-md-6">
                                    <label for="bank_branch">Branch</label>
                                    <input type="text" class="form-control desablecls" name="bank_branch" id="bank_branch" <?php if ($bodycontent['mode']=="EDIT"){ if ($bodycontent['vendorEditData']->bank_branch!=""){ echo "value='".$bodycontent['vendorEditData']->bank_branch."'"; }}?>  placeholder="Bank Branch">
                               </div>                       
                       
                        <div class="btnDiv col-md-12">
                        <button type="submit"  name="submit" id="vendorsavebtn" class="btn formBtn btn-primary"><?php echo $bodycontent['btnText'];?></button>
                        <span class="btn btn-primary formBtn loaderbtn" id="loaderbtn" style="display:none;"><i class="fa fa-spinner rotating" aria-hidden="true"></i> <?php echo $bodycontent['btnTextLoader']; ?></span>
                        </div>
                    </form>
                    <div class="response_msg" id="cas_response_msg">
                        <!-- response modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->