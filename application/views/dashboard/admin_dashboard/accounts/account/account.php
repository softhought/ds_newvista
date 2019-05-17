<script src="<?php echo base_url(); ?>assets/js/adm_scripts/accounts_account.js"></script>  
<?php

    // print_r($bodycontent['acountEditData']);

?>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Account  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Account </h3>
                    <a href="<?php echo base_url();?>accounts/accountList" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
                </div>
                <div class="box-body">                    
                    <form method="post" id="accountForm" >
                        <?php if($bodycontent['mode']=="EDIT"){
                            echo '<input type="hidden" name="account_id" id="account_id" value="'.$bodycontent["acountEditData"]->account_id.'">';
                        }  ?>
                    <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode'];?>">
                        <div id="account_name_div" class="form-group">                            
                            <label for="account_name">Account *</label>
                            <input type="text" class="form-control" name="account_name" id="account_name" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['acountEditData']->account_name."'";
                            if ($bodycontent['acountEditData']->from_where=="O" && $bodycontent['acountEditData']->is_special=="N") {
                                echo "  readonly";
                            }
                            } ?>  placeholder="Account" >
                        </div>
                        <div id="group_id_div" class="form-group">
                            <?php if ($bodycontent['mode']=="EDIT"){
                                    if ($bodycontent['acountEditData']->from_where=="O" && $bodycontent['acountEditData']->is_special=="N") {
                                        echo '<input type="hidden" name="group_id" id="group_id" value="'.$bodycontent["acountEditData"]->group_id.'" >';
                                    }                              
                                    
                            } ?>                            
                            <label for="group_id">Group *</label>
                            <select class="form-control selectpicker" data-show-subtext="true" name="group_id" id="group_id" data-live-search="true"
                            <?php if ($bodycontent['mode']=="EDIT"){
                                 if ($bodycontent['acountEditData']->from_where=="O" && $bodycontent['acountEditData']->is_special=="N") {
                                    echo "  disabled";
                                }
                             }?> >
                            <option  value="0">Select Group</option>
                            <?php foreach ($bodycontent['groupList'] as $value) { ?>
                                <option  value="<?php echo $value->id; ?>" data-tokens="<?php echo $value->is_bank; ?>" 
                                <?php if ($bodycontent['mode']=="EDIT"){
                                    if ($bodycontent['acountEditData']->group_id==$value->id) {
                                        echo " selected";
                                    }
                                    
                                } ?>
                                ><?php echo $value->group_description; ?></option>   
                            <?php  }  ?>                                
                               
                            </select>
                        </div>


                        <div id="bankdetails" style="display:<?php if ($bodycontent['mode']=="EDIT" && $bodycontent['acountEditData']->bank_ifsc!=""){echo "block";}else{echo "none";}?>;">
                               <div id="bank_ifsc_div" class="form-group">
                                    <label for="bank_ifsc">IFSC</label>
                                    <input type="text" class="form-control desablecls" name="bank_ifsc" id="bank_ifsc" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['acountEditData']->bank_ifsc."'"; }?>  placeholder="IFSC Code">
                               </div>
                               <div id="bank_ac_no_div" class="form-group">
                                    <label for="bank_ac_no">A/C No.</label>
                                    <input type="text" class="form-control desablecls" name="bank_ac_no" id="bank_ac_no" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['acountEditData']->bank_ac_no."'"; }?>  placeholder="A/C No.">
                               </div>
                               <div id="bank_address_div" class="form-group">
                                    <label for="bank_address">Address</label>
                                    <input type="text" class="form-control desablecls" name="bank_address" id="bank_address" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['acountEditData']->bank_address."'"; }?>  placeholder="Bank Address">
                               </div>
                               <div id="bank_branch_div" class="form-group">
                                    <label for="bank_branch">Branch</label>
                                    <input type="text" class="form-control desablecls" name="bank_branch" id="bank_branch" <?php if ($bodycontent['mode']=="EDIT"){ echo "value='".$bodycontent['acountEditData']->bank_branch."'"; }?>  placeholder="Bank Branch">
                               </div>
                        </div>


                        <div id="opening_balance_div" class="form-group" >                            
                            <label for="opening_balance">Opening Balance</label>
                            <input type="number" class="form-control" name="opening_balance" id="opening_balance" <?php if ($bodycontent['mode']=="EDIT"){ echo "value=".$bodycontent['acountEditData']->opening_balance; }?>  placeholder="Opening Balance">
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="is_active" id="is_active" value="Y"  
                                <?php if ($bodycontent['mode']=="EDIT"){ 
                                    if($bodycontent['acountEditData']->is_active=="Y")
                                    {
                                        echo "checked";
                                    }
                                }else{ echo "checked"; }?> >
                                Active
                            </label>
                        </div>
                        <div class="btnDiv">
                        <button type="submit"  name="submit" id="cassavebtn" class="btn formBtn btn-primary"><?php echo $bodycontent['btnText'];?></button>
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