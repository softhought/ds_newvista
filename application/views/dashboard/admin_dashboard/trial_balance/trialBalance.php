<script src="<?php echo base_url(); ?>assets/js/adm_scripts/trialBalance.js"></script> 
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
        <li class="active">Trial Balance  <?php echo $bodycontent['module'];?></li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Trial Balance </h3>                    
                </div>
                <div class="box-body">   
                    <input type="hidden" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $bodycontent['acnt_dt_start']; ?>" />
                    <input type="hidden" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $bodycontent['acnt_dt_end']; ?>" />                   
                    <form method="post" id="trialbalanceregister" name="trialbalanceregister" method="post" action="<?php echo base_url(); ?>trialbalance/pdfTrialBalance"  target="_blank">

                        <div id="from_date_div" class="form-group">   
                            <label for="from_date">From Date*</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control acntYrWiseDt" name="from_date" id="from_date" value="<?php 
                                        $chequeDate = str_replace('-', '/', trim($bodycontent['fiscalStartDt']));
                                        echo date("m/d/Y",strtotime($chequeDate)); 
                                        ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                        </div>
                        <div id="to_date_div" class="form-group">   
                            <label for="to_date">To Date*</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control acntYrWiseDt" name="to_date" id="to_date" value="<?php echo date("m/d/Y"); ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                        </div>
                        <p id="errormsg" class="form_error"></p>
                        <div class="btnDiv">
                        <button type="submit"  name="submit" id="showtrialbalancepdf" class="btn formBtn btn-primary"><i class="glyphicon glyphicon-file"></i><?php echo $bodycontent['btnText'];?></button>
                        
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