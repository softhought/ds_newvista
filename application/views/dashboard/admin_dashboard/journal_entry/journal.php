<script src="<?php echo base_url(); ?>assets/js/adm_scripts/journal.js"></script>  
<?php

    // pre($bodycontent['AccountList']);
    if($bodycontent['mode']=='EDIT')
    {
        // pre($bodycontent['JournalEditData']);
        // pre($bodycontent['voucherDetailsData']);
        // pre($bodycontent['voucherDetailsData']);
       
    }

?>
<style>
    section#journalvoucher1{
        background-color: rgb(255,255,255);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
        margin: 0px auto;
        padding: 24px;
    }
    section#journalvoucher2{
        background-color: rgb(255,255,255);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
        margin: 0px auto;
        padding: 24px;
    }
    textarea#narration{
        height: 54px !important;
    }
    .addmore .col-md-3{
        padding-right: 8px !important;
        padding-left: 8px !important;
    }
</style>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Journal Voucher  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlockLarge">
                <div class="box-header with-border">
                    <h3 class="box-title">Journal Voucher</h3>
                    <a href="<?php echo base_url();?>journal" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                  
                    <form method="post" id="JournalForm">
                        <input type="hidden" name="mode" value="<?php echo $bodycontent['mode']; ?>">
                        <?php if($bodycontent['mode']=='EDIT')
                            {
                                echo '<input type="hidden" name="voucher_id" value="'.$bodycontent['voucher_id'].'">';                                
                            }
                        ?>                        
                           
                        <section id="journalvoucher1">
                            <div class="row"> 
                                <div id="voucher_date_div" class="form-group col-md-6">

                                <input type="hidden" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $bodycontent['acnt_dt_start']; ?>" />
                                <input type="hidden" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $bodycontent['acnt_dt_end']; ?>" /> 

                                    <label for="voucher_date">Voucher Date*</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" name="voucher_date" id="voucher_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {  $voucherDate = str_replace('-', '/', trim($bodycontent['JournalEditData']->voucher_date));		
                                            $voucher_date=date("m/d/Y",strtotime($voucherDate));
                                            echo $voucher_date ;             
                                        }?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cheque_no">Cheque No.</label>                                    
                                    <input type="text" class="form-control" name="cheque_no" id="cheque_no" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['JournalEditData']->cheque_number;             
                                        }?>" autocomplete="off">  
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cheque_date">Cheque Date</label><br>
                                    <br>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" name="cheque_date" id="cheque_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {
                                            if ($bodycontent['JournalEditData']->cheque_date!="") {
                                                $chequeDate = str_replace('-', '/', trim($bodycontent['JournalEditData']->cheque_date));		
                                                $cheque_date=date("m/d/Y",strtotime($chequeDate)); 
                                            }else{
                                                $cheque_date="";
                                            }
                                                                                    
                                            echo $cheque_date;             
                                        }?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                               
                                <div id="div_narration" class="form-group col-md-6">
                                    <label for="narration">Narration*</label>
                                    <textarea class="form-control" name="narration" id="narration"><?php if($bodycontent['mode']=='EDIT'){echo $bodycontent['JournalEditData']->narration;}?></textarea>  
                                </div>
                            </div>                        
                        </section>
                        <br>
                        <section  id="journalvoucher1">
                        <input type="hidden"  value="<?php if ($bodycontent['mode']=="EDIT"){ echo sizeof($bodycontent['voucherDetailsData'])-1;}else{ echo "0";}?>" name="serial_id" id="serial_id">
                            <div class="row">
                                <div class="form-group col-md-2"> 
                                    <label for="ac_tag">A/C Tag*</label>
                                </div>                                
                                <div class="form-group col-md-4"> 
                                    <label for="account">Account*</label>
                                </div>
                                <div class="form-group col-md-4"> 
                                 <label for="amount">Amount*</label>
                                </div>
                                <div class="form-group col-md-2"> 
                                </div>
                            </div>
                            <div class="addmore" id="addmore">
                            
                                <?php if ($bodycontent['mode']=="EDIT") { 
                                    $loop=sizeof($bodycontent['voucherDetailsData']);
                                    for ($i=0; $i <$loop ; $i++) { 
                                       $count=$i;                 
                                    //  pre($bodycontent['voucherDetailsData']);                   
                                    ?>
                                    <!-- edit part -->
                                    <div class="row findRow" id="row_<?php echo $count ?>">
                                    <div id="ac_tag_div_<?php echo $count ?>" class="form-group ac_tag_div col-md-2">
                                        <select class="form-control selectpicker ac_tag" data-id="<?php echo $count ?>" name="ac_tag[]" id="ac_tag_<?php echo $count ?>">
                                            <option value="0">A/C Tag</option>
                                            <option <?php if ($bodycontent['voucherDetailsData'][$i]->is_debit=="Y"){ echo "selected"; } ?> value="Dr">Dr</option>
                                            <option <?php if ($bodycontent['voucherDetailsData'][$i]->is_debit=="N"){ echo "selected"; } ?> value="Cr">Cr</option>                                        
                                        </select>
                                    </div> 
                                    <div id="account_div_<?php echo $count ?>" class="form-group account_div col-md-4">
                                        <select class="form-control selectpicker account" data-id="<?php echo $count ?>" data-show-subtext="true" name="account[]" id="account_<?php echo $count ?>" data-live-search="true"  >
                                            <option  value="">Select A/C</option>
                                            <?php foreach ($bodycontent['AccountList'] as $value) { ?>
                                                <option  value="<?php echo $value->account_id; ?>" 
                                                <?php if ($bodycontent['mode']=="EDIT"){
                                                if ($bodycontent['voucherDetailsData'][$i]->account_master_id==$value->account_id) {
                                                    echo " selected";
                                                    }
                                                } ?>><?php echo $value->account_name; ?></option>   
                                            <?php  }  ?>                                            
                                        </select>
                                    </div>

                                    <div id="div_amount_<?php echo $count ?>" class="form-group div_amount col-md-4">
                                        <input type="text" class="form-control amount" data-id="<?php echo $count ?>" name="amount[]" id="amount_<?php echo $count ?>" value="<?php 
                                            if($bodycontent['mode']=='EDIT')  
                                            {                                           
                                                echo $bodycontent['voucherDetailsData'][$i]->voucher_amount;             
                                            }?>" autocomplete="off" placeholder="Amount" >  
                                    </div>
                                    <?php if ($loop-1==$i) { ?>
                                        <div id="div_add_btn" class="form-group col-md-2">                                
                                            <button type="button" class="btn btn-primary" id="add">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                    <?php }else{ ?>
                                    <div id="div_remove_btn_<?php echo $count ?>" class="form-group col-md-2"> 
                                        <button type="button" class="btn btn-danger btn_remove" data-id="<?php echo $count ?>" id="remove_<?php echo $count ?>" name="remove">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </div>
                                    </div>
                                     <!-- edit part end -->
                                <?php  } } }else{?>
                             
                                <div class="row findRow" id="row_0">
                                <div id="ac_tag_div_0" class="ac_tag_div form-group col-md-2"> 
                                    <select class="form-control selectpicker ac_tag" data-show-subtext="true" name="ac_tag[]" id="ac_tag_0" data-id="0" data-live-search="true"  >
                                        <option  value="0">A/C Tag</option>
                                        <option  value="Dr">Dr</option>
                                        <option  value="Cr">Cr</option>                        
                                    </select>
                                </div>

                                <div id="account_div_0" class="form-group account_div col-md-4">
                                    <select class="form-control account selectpicker" data-show-subtext="true" name="account[]" id="account_0" data-live-search="true"  data-id="0" >
                                        <option  value="">Select A/C</option>
                                        <?php foreach ($bodycontent['AccountList'] as $value) { ?>
                                            <option  value="<?php echo $value->account_id; ?>"><?php echo $value->account_name; ?></option>   
                                        <?php  }  ?>                                        
                                    </select>
                                </div>

                                <div id="div_amount_0" class="div_amount form-group col-md-4"> 
                                    <input type="text" class="form-control amount" data-id="0" name="amount[]" id="amount_0" autocomplete="off" placeholder="Amount" >  
                                </div>

                                <div id="div_add_btn" class="form-group col-md-2">                                
                                    <button type="button" class="btn btn-primary" id="add">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                                </div>
                                <?php } ?>
                             
                            </div>                          
                        </section>
                        <br>
                        <section id="journalvoucher1">
                            <div class="row" id="tootal">
                                <div class="form-group col-md-6">
                                    <label for="total_debit">Total Debit</label>
                                    <input type="text" readonly class="form-control" name="total_debit" id="total_debit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['JournalEditData']->total_debit;             
                                        }?>">  
                                </div>                                
                                <div class="form-group col-md-6">
                                    <label for="total_credit">Total Credit</label>
                                    <input type="text" class="form-control" readonly name="total_credit" id="total_credit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['JournalEditData']->total_credit;             
                                        }?>">  
                                </div>                             
                            </div> 
                        </section><br>
                                 
                       
                        <div class="btnDiv col-md-12">
                            <button type="submit"  name="submit" id="journalsavebtn" class="btn formBtn btn-primary"><?php  echo $bodycontent['btnText'];?></button>
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