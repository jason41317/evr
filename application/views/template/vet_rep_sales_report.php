<!DOCTYPE html>
<html>
<head>
	<title>Salesperson Sales Summary Report</title>
	<style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .data {
            border-bottom: 1px solid #404040;
        }

        .align-center {
            text-align: center;
        }

        .report-header {
            font-weight: bolder;
        }

        hr {
            border-top: 1px solid #404040;
        }
    </style>
    <script type="text/javascript">
        (function(){
            window.print();
            setTimeout(function() {
                 //window.close();
             }, 500);
        })();
    </script>    
</head>
<body>
   <table width="100%">
        <tr>
            <td width="10%"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%" class="align-center">
                <h1 class="report-header"><strong><?php echo $company_info->company_name; ?></strong></h1>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
            </td>
        </tr>
    </table><hr>
    <div>
        <h1 class="report-header" style="text-align: center;"><strong>SALESPERSON SALES REPORT</strong></h1>
        <p style="text-align: center;">Period <?php echo $_GET['startDate']; ?> to <?php echo $_GET['endDate']; ?></p>
    </div>
    <?php foreach ($salespersons as $salesperson) { ?>
        <h2><?php echo $salesperson->salesperson_name; ?></h2>
    
    <table width="95%" style="margin-left: 5%; text-align: right;">
        <thead>
            <tr style="text-transform: uppercase;">
                <td width="25%" style="text-align: left;"><strong>Invoice #</strong></td>
                <td width="25%" style="text-align: left;"><strong>Date</strong></td>
                <td width="25%"style="text-align: left;"><strong>Remarks</strong></td>
                <td width="25%"><strong>Invoice Amount</strong></td>
            </tr><hr>
        </thead>
        <tbody>
            <?php $sum=0; 
                foreach($sales_summary as $summary) { 
                    if($summary->salesperson_id==$salesperson->salesperson_id) { ?>
                        <tr>
                            <td style="text-align: left;"><?php echo $summary->sales_inv_no; ?></td>
                            <td style="text-align: left;"><?php echo $summary->date_invoice; ?></td>
                            <td style="text-align: left;"><?php echo $summary->remarks; ?></td>
    <td><?php echo  ($summary->total_amount_invoice < 0 ? "(".number_format(abs($summary->total_amount_invoice),4).")" :number_format($summary->total_amount_invoice,4))   ?></td>
                        </tr>
                    <?php
                    $sum+=$summary->total_amount_invoice; 
                    }
                }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><h2><?php echo number_format($sum,4); ?></h2></td>
            </tr>
        </tbody>
    </table>
    <?php } ?>
</body>
</html>