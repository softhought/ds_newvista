<script src="<?php echo base_url(); ?>assets/js/adm_scripts/accounts_group.js"></script>  
<?php
// if(isset($bodycontent['editgroup']))
// {
//     print_r($bodycontent['editgroup']);
// }

?>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Accounts  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Group </h3>
                    <a href="<?php echo base_url();?>accounts" class="link_tab"><span class="glyphicon glyphicon-list"></span> List</a>
                </div>
                <div class="box-body">                    
                    <form method="post" id="groupForm" >
                    <input type="hidden" name="mode" id="mode" value="<?php echo $bodycontent['mode'];?>">
                    <?php
                     if ($bodycontent['mode']=="EDIT") {
                    ?>
                        <input type="hidden" name="id" id="id" value="<?php echo $bodycontent['editgroup']->id;?>">
                        <!-- <input type="hidden" name="is_special" id="is_special" value="<?php echo $bodycontent['editgroup']->is_special;?>"> -->
                    <?php 
                     }
                    ?>
                        <div id="group_description_div" class="form-group">                            
                            <label for="group_description">Group Description</label>
                            <input type="text" class="form-control" name="group_description" id="group_description" value="<?php if ($bodycontent['mode']=="EDIT"){ echo $bodycontent['editgroup']->group_description ;} ?>"  placeholder="Group Description">
                        </div>

                        <!--  main category -->
                        <div id="main_category_div" class="form-group">
                            <label class="radio-inline"><input type="radio" name="main_category" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->main_category=="B"){
                                    echo " checked " ;
                                }
                             } ?> value="B" id="main_category1">Balance Sheet</label>

                            <label class="radio-inline"><input type="radio" name="main_category" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->main_category=="P"){
                                    echo " checked " ;
                                }
                             } ?> value="P" id="main_category2">Profit & Loss</label>
                        </div>

                        <!-- sub category 1 -->
                        <div class="form-group" id="div_sub_category1" style="display:<?php if ($bodycontent['mode']=="EDIT") {
                           if ($bodycontent['editgroup']->sub_category=="A" || $bodycontent['editgroup']->sub_category=="L" ) {
                               echo 'true';
                           }else{
                               echo 'none';
                           }
                        }else{
                            echo 'none';
                        } ?>;">
                            <label class="radio-inline"><input type="radio" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->sub_category=="A"){
                                    echo " checked " ;
                                }
                             } ?> name="sub_category" value="A" id="sub_category" >Assets</label>                             
                            <label class="radio-inline"><input type="radio" name="sub_category" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->sub_category=="L"){
                                    echo " checked " ;
                                }
                             } ?> value="L" id="sub_category">Liability</label>
                        </div>

                        <!-- sub category 2 -->
                        <div class="form-group" id="div_sub_category2" style="display:<?php if ($bodycontent['mode']=="EDIT") {
                           if ($bodycontent['editgroup']->sub_category=="I" || $bodycontent['editgroup']->sub_category=="E" ) {
                               echo 'true';
                           }else{
                               echo 'none';
                           }
                        }else{
                            echo 'none';
                        } ?>;">
                            <label class="radio-inline"><input type="radio" name="sub_category" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->sub_category=="I"){
                                    echo " checked " ;
                                }
                             } ?> value="I" id="sub_category" >Income</label>
                            <label class="radio-inline"><input type="radio" name="sub_category" <?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->sub_category=="E"){
                                    echo " checked " ;
                                }
                             } ?> value="E" id="sub_category">Expenditure</label>
                        </div>
                        <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" name="is_active" id="is_active" value="Y" checked>Active</label>
                        </div>
                        <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" name="is_bank" id="is_bank" value="Y"<?php if ($bodycontent['mode']=="EDIT"){
                                if($bodycontent['editgroup']->is_bank=="Y"){
                                    echo " checked " ;
                                }
                             } ?>>Is it a Bank Account ?</label>
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