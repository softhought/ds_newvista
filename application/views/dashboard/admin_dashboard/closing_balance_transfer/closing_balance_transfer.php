<script src="<?php echo base_url(); ?>assets/js/adm_scripts/closingtransfer.js"></script> 
<?php

    //  print_r($bodycontent['Accountlist']);

?>
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Closing Blance Transfer </li>
    </ol>
</section>

 <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary formBlock">
                <div class="box-header with-border">
                    <h3 class="box-title">Closing Blance Transfer </h3>                    
                </div>
                <div class="box-body">                    
                    <form method="post" id="closingtransfer" name="closingtransfer" method="post">
                    <input type="hidden" class="form-control" name="acnt_dt_start" id="acnt_dt_start" value="<?php echo $bodycontent['start_date']; ?>">   
                    <input type="hidden" class="form-control" name="acnt_dt_end" id="acnt_dt_end" value="<?php echo $bodycontent['end_date']; ?>">  
                <div class="col-md-12"> 
                    <div class="col-md-6"> 
                        <div id="from_date_div" class="form-group">   
                            <label for="from_date">Current year</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly value="<?php echo $bodycontent['period']; ?>">   

                                        <input type="hidden" class="form-control" name="fromYearId" id="fromYearId" value="<?php echo $bodycontent['currentyearid']; ?>">   
                                    </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div id="to_date_div" class="form-group">   
                            <label for="to_date">Next year </label>
                                    <div class="input-group">
                                    <?php if ($bodycontent["next_year"]!="") { ?>
                                        <input type="text" class="form-control" readonly value="<?php echo($bodycontent["next_year"]["nextPeriod"]); ?>">   

                                        <input type="hidden" class="form-control" name="toYearId" id="toYearId" value="<?php echo $bodycontent["next_year"]["nextId"]; ?>">  
                                   <?php }else{ ?>
                                    <input type="text" class="form-control" readonly value="">   
                                   <?php } ?>
                                        
                                    </div>
                        </div>
                    </div>
                </div>
                        <p id="errormsg" class="form_error"></p>
                        <div class="btnDiv">
                        <button type="button"  name="submit" id="ClosingBlanceTransfer" class="btn formBtn btn-primary"><i class="glyphicon glyphicon-file"></i><?php echo $bodycontent['btnText'];?></button>

                        <button  style="display: none;" disabled  type="button" id="transferLoader" class="btn formBtn btn-primary"><img src="<?php echo base_url(); ?>assets/images/transfer.gif"/></button>
                        
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

<div class="container" id="datadiv">
    <img src="<?php echo base_url(); ?>assets/images/loader.gif" id="loader" style="display: none;padding-left:450px;"/>
</div>