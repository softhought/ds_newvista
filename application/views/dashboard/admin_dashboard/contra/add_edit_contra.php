<script src="<?php echo base_url(); ?>assets/js/adm_scripts/contra.js"></script>  
<?php

    // pre($bodycontent['AccountList']);
    if($bodycontent['mode']=='EDIT')
    {
        // pre($bodycontent['ContraEditData']);
        // pre($bodycontent['ContraDebitData']);
        // pre($bodycontent['ContraCreditData']);
       
    }

?>
<style>
    section#contravoucher1{
        background-color: rgb(255,255,255);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
        margin: 0px auto;
        padding: 24px;
    }
    section#contravoucher2{
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
</style>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Contra Voucher  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlockLarge">
                <div class="box-header with-border">
                    <h3 class="box-title">Contra Voucher</h3>
                    <a href="<?php echo base_url();?>contra" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                  
                    <form method="post" id="ContraForm">
                        <input type="hidden" name="mode" value="<?php echo $bodycontent['mode']; ?>">
                        <?php if($bodycontent['mode']=='EDIT')
                            {
                                echo '<input type="hidden" name="voucher_id" value="'.$bodycontent['voucher_id'].'">';                                
                            }
                        ?>                        
                           
                        <section id="contravoucher1">
                            <div class="row"> 
                            <input type="hidden" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $bodycontent['acnt_dt_start']; ?>" />
                            <input type="hidden" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $bodycontent['acnt_dt_end']; ?>" />       
                                <div id="voucher_date_div" class="form-group col-md-6">
                                    <label for="voucher_date">Voucher Date*</label>                                    
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" name="voucher_date" id="voucher_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {  $voucherDate = str_replace('-', '/', trim($bodycontent['ContraEditData']->voucher_date));		
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
                                            echo $bodycontent['ContraEditData']->cheque_number;             
                                        }?>" autocomplete="off">  
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cheque_date">Cheque Date</label><br>
                                    <br>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" name="cheque_date" id="cheque_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {
                                            if ($bodycontent['ContraEditData']->cheque_date!="") {
                                                $chequeDate = str_replace('-', '/', trim($bodycontent['ContraEditData']->cheque_date));		
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
                                    <textarea class="form-control" name="narration" id="narration"><?php if($bodycontent['mode']=='EDIT'){echo $bodycontent['ContraEditData']->narration;}?></textarea>  
                                </div>
                            </div>                        
                        </section>
                        <br>
                        <section id="contravoucher1">
                            <div class="row">
                                <div id="debit_ac_div" class="form-group col-md-6">                           
                                    <label for="debit_ac">Debit*</label>
                                    <select class="form-control selectpicker" data-show-subtext="true" name="debit_ac" id="debit_ac" data-live-search="true"  >
                                        <option  value="">Select A/C</option>
                                        <?php foreach ($bodycontent['AccountList'] as $value) { ?>
                                            <option  value="<?php echo $value->account_id; ?>" 
                                            <?php if ($bodycontent['mode']=="EDIT"){
                                               if ($bodycontent['ContraDebitData']->account_master_id==$value->account_id) {
                                                echo " selected";
                                                }
                                        } ?>
                                            ><?php echo $value->account_name; ?></option>   
                                    <?php  }  ?>
                                        
                                    </select>
                                </div>
                               
                                <div id="div_debit_amount" class="form-group col-md-6">
                                    <label for="debit_amount">Debit Amount*</label>
                                    <input type="text" class="form-control" name="debit_amount" id="debit_amount" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['ContraDebitData']->voucher_amount;             
                                        }?>" autocomplete="off">  
                                </div>

                                <div id="credit_ac_div" class="form-group col-md-6">                          
                                    <label for="credit_ac">Credit*</label>
                                    <select class="form-control selectpicker" data-show-subtext="true" name="credit_ac" id="credit_ac" data-live-search="true"  >
                                        <option  value="">Select A/C</option>
                                        <?php foreach ($bodycontent['AccountList'] as $value) { ?>
                                            <option  value="<?php echo $value->account_id; ?>" 
                                            <?php if ($bodycontent['mode']=="EDIT"){
                                               if ($bodycontent['ContraCreditData']->account_master_id==$value->account_id) {
                                                echo " selected";
                                                }
                                        } ?>
                                            ><?php echo $value->account_name; ?></option>   
                                    <?php  }  ?>
                                        
                                    </select>
                                </div>

                                <div id="div_credit_amount" class="form-group col-md-6">
                                    <label for="credit_amount">Credit Amount*</label>
                                    <input type="text" class="form-control" name="credit_amount" id="credit_amount" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['ContraCreditData']->voucher_amount;             
                                        }?>" autocomplete="off">  
                                </div>
                            </div>                        
                        </section>
                        <br>
                        <section id="contravoucher1">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="total_debit">Total Debit</label>
                                    <input type="text" readonly class="form-control" name="total_debit" id="total_debit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['ContraEditData']->total_debit;             
                                        }?>">  
                                </div>                                
                                <div class="form-group col-md-6">
                                    <label for="total_credit">Total Credit</label>
                                    <input type="text" class="form-control" readonly name="total_credit" id="total_credit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['ContraEditData']->total_credit;             
                                        }?>">  
                                </div>                                
                            </div> 
                        </section><br>
                                 
                       
                        <div class="btnDiv col-md-12">
                        <button type="submit"  name="submit" id="contrasavebtn" class="btn formBtn btn-primary"><?php  echo $bodycontent['btnText'];?></button>
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