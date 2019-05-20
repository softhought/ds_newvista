<html>
    <head>
        <title>Payment Register</title>
    </head>
    <style>
            .demo {
		border:1px solid #C0C0C0;
		border-collapse:collapse;
		padding:5px;
	}
        .demo th {
		border:1px solid #C0C0C0;
		padding:4px;
		background:#F0F0F0;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
	}
	.demo td {
		border:1px solid #C0C0C0;
		padding:6px;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;		
		
	}
        .table_head{
            height:45px;
            border:none;
        }
        .break{
            page-break-after: always;
        }
        .amount{
            text-align: right;
        }
        </style>
    <body>

        <table width="100%">
            <tr>
                <td align="center">
                    <b><?php if($DueOnly!=0) { echo 'Due'; }else{ echo 'Receipt'; } ?> Register</b><br>
                    <span style="font-size:12px;">(<?php echo $fromDate." To ".$toDate?>)</span><br>
                    <span style="font-size:12px;"><?php
                    if($classname!="" || $section!="" || $StudentName!=""){ echo 'For  ';}
                    if ($classname!="") {
                        echo " Class-".$classname;
                    }
                    if ($section!="") {
                        echo " Section-".$section;
                    }
                    if ($StudentName!="") {
                        echo " Student-".$StudentName;
                    }
                    ?></span>
                </td>
            </tr>
        </table>
        
        <div style="padding:2px 0 5px 0;"></div>

        <table width="100%" class="">
               <tr>
                    <td align="left">
                        <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                            <?php echo($company); ?> <br/>
                            <?php echo($companylocation) ?>
                        </span>
                    </td>
                    
                    <td align=right>
                         <span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">
                             Print Date : &nbsp;<?php echo date('d-m-Y'); ?>
                         </span>
                    </td>
                </tr>
        </table>

        <div style="padding:4px"></div>

        <table width="100%" class="demo">
            <thead class="table_head">
                <tr>
                    <th>Sl. No.</th>
                    <th>Student</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Roll</th>
                    <th>Payment Details</th>
                    
                </tr>
            </thead>
            <tbody> 
                <?php $i=1; foreach ($ReportArr as $key => $value) {    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['studentname']; ?></td>
                        <td><?php echo $value['classname']; ?></td>
                        <td><?php echo $value['section']; ?></td>
                        <td><?php echo $value['roll']; ?></td>
                        <td>
                            <table width="100%" class="demo">
                                <thead>
                                    <tr>                                
                                        <th>Date of Payment</th>
                                        <th>Account(s)</th>
                                        <th>Payable Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $totalDue=0;
                                $totalPaid=0;
                                $totalAmount=0;
                                foreach ($value['PaymentDetails'] as $PaymentDetails) { 
                                    foreach ($PaymentDetails as $Details) {  //pre($Details);
                                        $totalDue+=$Details['due'];  
                                        $totalPaid+=$Details['paid'];
                                        $totalAmount+=$Details['amount'];
                                    ?>
                                    <tr>
                                        <td><?php echo $Details['payment_date']; ?></td>
                                        <td><?php echo $Details['account_head']; ?></td>
                                        <td class="amount"><?php echo number_format($Details['amount'], 2); ?></td>
                                        <td class="amount"><?php echo number_format($Details['paid'], 2); ?></td>
                                        <td class="amount"><?php echo number_format($Details['due'], 2); ?></td>
                                    </tr>
                                    <?php }} ?>
                                    <tr>
                                        <td colspan='2'>Total</td>
                                        <td class="amount"><?php echo  number_format($totalAmount, 2); ?></td>
                                        <td class="amount"><?php echo  number_format($totalPaid, 2); ?></td>
                                        <td class="amount"><?php echo  number_format($totalDue, 2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php $i++; } ?>
               
            </tbody>        
        </table>
    </body>
</html>