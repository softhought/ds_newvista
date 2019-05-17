<script>
    $(".amountDtl").focus();
</script>
<style>
td{
    padding-left: 10px;
}
</style>
 
<div id="generalVoucher_0_<?php echo($divnumber); ?>" class="generalVoucher" style="padding-top:10px;">

<table width="100%" class="gridtable voucherDtl" id="voucherDtl">
                        <tr>
                        <td width="10%">
                            <div class="form-group" id="debitcreditdiv_<?php echo($divnumber); ?>">
                                <select name="debitcredit[]" id="debitcredit_0_<?php echo($divnumber); ?>"  class="debitcredit selectStyle form-control selectpicker"> 
                                    <option value="0">A/c Tag</option>
                                    <option value="Dr" <?php if($acctag=="PY"){echo 'selected';}else{echo(" ");}?> >Dr</option>
                                    <option value="Cr" <?php if($acctag=="RC"){echo 'selected';}else{echo(" ");}?> >Cr</option>
                                </select>
                            </div>
                        </td>
                        <td width="40%"> 
                            <div class="form-group" id="acHeaddiv_<?php echo($divnumber); ?>">
                                <select name="acHead[]" id="acHead_0_<?php echo($divnumber); ?>" style="" class="acHead selectStyle form-control selectpicker" data-live-search="true"> 
                                    <option value="0">Select A/c Name</option>
                                    <?php foreach($accounthead as $row){?>
                                    <option value="<?php echo $row->account_id;?>"><?php echo $row->account_name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </td>
                        
                        <td>
                            <div class="form-group" id="amountDtldiv_<?php echo($divnumber); ?>">
                                <input style="text-align: right;" type="text" name="amountDtl[]" id="amountDtl_0_<?php echo($divnumber); ?>" class="amountDtl textStyle form-control" placeholder="Amount" value="<?php //echo $amount;?>"/>
                            </div>
                        </td>
                        <td style="text-align:right;" width="10%">
                            <div class="form-group" id="deldiv_<?php echo($divnumber); ?>">
                                <a href="javascript:void(0);" id="del_0_<?php echo($divnumber); ?>" class="btn del btn-danger btn-xs"  data-title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
                            </div>
                        </td>
                        </tr>
            </table> 
    </div>


<script>


    




</script>