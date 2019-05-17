<div class="row findRow" id="row_<?php echo $count ?>">
    <div id="ac_tag_div_<?php echo $count ?>" class="ac_tag_div form-group col-md-2">                        
        <select class="form-control selectpicker ac_tag" data-id="<?php echo $count ?>" data-show-subtext="true" name="ac_tag[]" id="ac_tag_<?php echo $count ?>" data-live-search="true"  >
            <option  value="0">A/C Tag</option>
            <option  value="Dr">Dr</option>
            <option  value="Cr">Cr</option> 
        </select>
    </div>    
    <div id="account_div_<?php echo $count ?>" class="form-group account_div col-md-4">                          
        <select class="form-control selectpicker account" data-show-subtext="true" data-id="<?php echo $count ?>" name="account[]" id="account_<?php echo $count ?>" data-live-search="true"  >
            <option  value="">Select A/C</option>
            <?php foreach ($AccountList as $value) { ?>
                <option  value="<?php echo $value->account_id; ?>" ><?php echo $value->account_name; ?></option>   
            <?php  }  ?>
        </select>
    </div>
    <div id="div_amount_<?php echo $count ?>" class="form-group div_amount col-md-4">
        <input type="text" class="form-control amount" data-id="<?php echo $count ?>" name="amount[]" id="amount_<?php echo $count ?>"  autocomplete="off" placeholder="Amount">  
    </div>
    <div id="div_remove_btn_<?php echo $count ?>" class="form-group col-md-2">                                
        <button type="button" class="btn btn-danger btn_remove" data-id="<?php echo $count ?>" id="remove_<?php echo $count ?>" name="remove">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
    </div>
    <!-- <div id="div_add_btn" class="form-group col-md-2">                                
        <button type="button" class="btn btn-primary" id="add">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </div> -->
</div> 