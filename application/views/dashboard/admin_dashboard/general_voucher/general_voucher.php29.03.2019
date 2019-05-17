<script src="<?php echo base_url(); ?>assets/js/adm_scripts/general_voucher.js"></script>  
<?php

    // pre($bodycontent['AccountList']);   

?>
<style>
    section#journalvoucher1{
        background-color: rgb(255,255,255);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
        margin: 0px auto;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 24px;
        padding-right: 24px;
    }
    /* section#journalvoucher2{
        background-color: rgb(255,255,255);
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        box-shadow: 0 1px 0 rgba(255,255,255,0.2) inset, 0 0 4px rgba(0,0,0,0.2);
        margin: 0px auto;
        padding: 24px;
    } */
    textarea#narration{
        height: 54px !important;
    }

td{
    padding-left: 10px;
}

</style>
<script>

</script>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">General Voucher  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlockLarge">
                <div class="box-header with-border">
                    <h3 class="box-title">General Voucher</h3>
                    <a href="<?php echo base_url();?>generalvoucher" class="link_tab"><span class="glyphicon glyphicon-list"></span></a>
                </div>
                <div class="box-body">  
                <p id="clsmsg" class="form_error"></p>                  
                    <form method="post" id="GeneralVoucherForm">
                        <input type="hidden" name="mode" value="<?php echo $bodycontent['mode']; ?>">
                        <?php if($bodycontent['mode']=='EDIT')
                            {
                                echo '<input type="hidden" name="voucher_id" value="'.$bodycontent['voucher_id'].'">';                                
                            }
                        ?>                        
                           
                        <section id="journalvoucher">
                            <div class="row"> 
                                <div id="voucher_date_div" class="form-group col-md-6">

                                <input type="hidden" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $bodycontent['acnt_dt_start']; ?>" />
                                <input type="hidden" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $bodycontent['acnt_dt_end']; ?>" /> 

                                    <label for="voucher_date">Voucher Date*</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control" name="voucher_date" id="voucher_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                         {  
                                            echo $bodycontent['generalVouchermaster']['voucher_date'];             
                                        }else{ echo date('m/d/Y');}?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>

                                <div id="paidto_rcv_div" class="form-group col-md-6">
                                    <label for="paidto_rcv">Paid To/Received From*</label>
                                    <input type="text" class="form-control" name="paidto_rcv" id="paidto_rcv" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                         {  
                                            echo $bodycontent['generalVouchermaster']['paid_to'];             
                                        }?>">
                                </div>                             
                               
                            <div id="Pay_Rc_div" class="form-group col-md-6">                           
                                    <label for="Pay_Rc">Receipt/Payment*</label>
                                    <select class="form-control selectpicker" data-show-subtext="true" name="Pay_Rc" id="Pay_Rc" data-live-search="true" <?php if($bodycontent['mode']=='EDIT'){echo "disabled";}else{echo "";}?> >
                                    <option value="PY" <?php if($bodycontent['mode']=='EDIT'){ if($bodycontent['generalVouchermaster']['transaction_type']=='PY'){echo('selected');}}else{echo('');} ?>>Payment</option>
               <option value="RC" <?php if($bodycontent['mode']=='EDIT'){ if($bodycontent['generalVouchermaster']['transaction_type']=='RC'){echo('selected');}}else{echo('');} ?>>Receipt</option>   
                                    
                                        
                                    </select>
                             </div>   
                            <div id="account_id_div" class="form-group col-md-6">                           
                                    <label for="account_id">Bank/Cash*</label>
                                    <select class="form-control selectpicker" data-show-subtext="true" name="account_id" id="account_id" data-live-search="true"  >
                                        <option  value="">Select A/C</option>
                                        <?php foreach ($bodycontent['AccountList'] as $value) { ?>
                                            <option  value="<?php echo $value->account_id; ?>" 
                                            <?php if ($bodycontent['mode']=="EDIT"){
                                            if($bodycontent['generalVouchermaster']['accountId']== $value->account_id){echo('selected');}
                                             } ?>
                                            ><?php echo $value->account_name; ?></option>   
                                    <?php  }  ?>
                                        
                                    </select>
                            </div>
                            <div class="form-group col-md-6">
                                    <label for="cheque_no">Cheque No.</label>                                    
                                    <input type="text" class="form-control" name="cheque_no" id="cheque_no" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['generalVouchermaster']['cheque_number'];             
                                        }?>" autocomplete="off">  
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cheque_date">Cheque Date</label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" name="cheque_date" id="cheque_date" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                            
                                            if ($bodycontent['generalVouchermaster']['cheque_date']!="") {
                                                $cheque_date = $bodycontent['generalVouchermaster']['cheque_date']; 
                                            }else{
                                                $cheque_date="";
                                            }
                                                                                    
                                            echo $cheque_date;             
                                        }else{ echo date('m/d/Y');}?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div> 
                                <div id="amount_div" class="form-group col-md-6">
                                    <label for="amount">Amount*</label>
                                    <input style="text-align: right;" type="text" class="form-control" name="amount" id="amount" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                         {  
                                            echo $bodycontent['generalVouchermaster']['voucher_amount'];             
                                        }?>">
                                </div> 
                                <div id="div_narration" class="form-group col-md-6">
                                    <label for="narration">Narration</label>
                                    <textarea class="form-control" name="narration" id="narration"><?php if($bodycontent['mode']=='EDIT'){ echo $bodycontent['generalVouchermaster']['narration'];
                                    }?></textarea>  
                                </div>
                            <div class="col-md-12" style="text-align: center;">
                            <button type="button" style="width:100%;" name="addnewDtlDiv" class="btn btn-primary" id="addnewDtlDiv">Add Account Details</button>
                            </div>
                                   
                        </div>                     
                        </section>
                        <br>
                        <section id="journalvoucher1" style="<?php if($bodycontent['mode']=="EDIT"){ echo 'display:block;';}else{ echo 'display:none;';} ?>" class="groupvoucherDtl">
                        <?php if($bodycontent['mode']=="EDIT"){
                            $i=1;
    
                            foreach ($bodycontent['generalVoucherDtl'] as $content){
                            ?>
                            
                            <div style="padding-top:10px;" id="generalVoucher_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" class="generalVoucher">
                                    <table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                                                <tr>
                                                <td width="10%">
                                                    <select name="debitcredit[]" id="debitcredit_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="debitcredit selectStyle form-control selectpicker"> 
                                                        <option value="0">A/c Tag</option>
                                                        <option value="Dr" <?php if($content['is_debit']=='Y'){echo('selected');}else{echo('');} ?>>Dr</option>
                                                        <option value="Cr" <?php if($content['is_debit']=='N'){echo('selected');}else{echo('');} ?>>Cr</option>
                                                    </select>
                                                </td>
                                                <td width="40%"> 
                                                    <select name="acHead[]" id="acHead_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" style="" class="acHead selectStyle form-control selectpicker" data-live-search="true"> 
                                                        <option value="0">Select A/c Name</option>
                                                        <?php foreach($bodycontent['accounthead'] as $row){?>
                                                            <option value="<?php echo $row->account_id;?>" <?php if ($content['accountId']==$row->account_id) {
                                                                echo " selected";
                                                            } ?>><?php echo $row->account_name;?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>                                                
                                                <td>
                                                    <input type="text" style="text-align: right;" name="amountDtl[]" id="amountDtl_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" value="<?php echo($content['VouchrDtlAmt']);?>" class="amountDtl textStyle  form-control" placeholder="Amount" />
                                                </td>
                                                <td width="10%" style="text-align:right;">                                                    
                                                    <div class="form-group" id="deldiv_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>">
                                                        <a href="javascript:void(0);" id="del_<?php echo($content['voucherMastId']);?>_<?php echo($content['VoucherDtlId']); ?>" class="btn del btn-danger btn-xs"  data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                                                    </div>
                                                </td>
                                                </tr>
                                    </table>
                            </div>
                            <?php $i++;
                            }
                            }
                            ?> 
                        </section><br> 
                        <section id="journalvoucher1">
                            <div id="totalDebitCreditDiv" class="row">
                                <div class="form-group col-md-6">
                                    <label for="total_debit">Total Debit</label>
                                    <input type="text" style="text-align: right;" readonly class="form-control" name="total_debit" id="total_debit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                           echo $bodycontent['generalVouchermaster']['total_debit'];             
                                        }?>">  
                                </div>
                                                               
                                <div class="form-group col-md-6">
                                    <label for="total_credit">Total Credit</label>
                                    <input type="text" class="form-control" style="text-align: right;" readonly name="total_credit" id="total_credit" value="<?php 
                                        if($bodycontent['mode']=='EDIT')  
                                        {                                           
                                            echo $bodycontent['generalVouchermaster']['total_credit'];             
                                        }?>">  
                                </div>  

                            </div> 
                        </section><br>                             
                       
                        <div class="btnDiv col-md-12">
                        <button type="button"  name="generalVoucher" id="generalVoucher" class="btn formBtn btn-primary"><?php  echo $bodycontent['btnText'];?></button>
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
