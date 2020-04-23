<!DOCTYPE html>
<html>
<head>
	<title>Customers Sales Return Report</title>
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

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }


        @media print{@page {size: landscape}}
    </style>
    <script type="text/javascript">
        (function(){
            window.print();
        //     setTimeout(function() {
        //          //window.close();
        //      }, 500);
        })();
    </script>    
</head>
<body>
   <table width="100%">
        <tr>
            <td width="10%"  class="bottom"><img src="<?php echo base_url($company_info->logo_path); ?>" style="height: 90px; width: 120px; text-align: left;"></td>
            <td width="90%"  class="bottom" >
                <h3 class="report-header" style="margin-bottom: 0"><strong><?php echo $company_info->company_name; ?></strong></h3>
                <span><?php echo $company_info->company_address; ?></span><br>
                <span><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></span><br>
                <span><?php echo $company_info->email_address; ?></span><br>

            </td>
        </tr>
    </table><hr>
    <div>
        <h1 class="report-header" style="text-align: center;"><strong>SALES RETURNS REPORT</strong></h1>
        <p style="text-align: center;">Period <?php echo $_GET['startDate']; ?> to <?php echo $_GET['endDate']; ?></p>
    </div>


    <table width="100%" style="text-align: left;">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Date Invoice</th>
                <th>Date Returned</th>
                <th>Customer</th>
                <th>Product</th>
                <th class="align-right">Qty</th>
                <th class="align-right">Price</th>
                <th class="align-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $sum=0; 
                foreach($returns as $return) {  ?>
                        <tr>
                            <td><?php echo $return->inv_no; ?></td>
                            <td><?php echo $return->date_invoice; ?></td>
                            <td><?php echo $return->date_returned; ?></td>
                            <td><?php echo $return->customer_name; ?></td>
                            <td><?php echo $return->product_desc; ?></td>
                            <td class="align-right"><?php echo number_format($return->adjust_qty,2); ?></td>
                            <td class="align-right"><?php echo number_format($return->adjust_price,2); ?></td>
                            <td class="align-right"><?php echo number_format($return->adjust_line_total_price,2); ?></td>
                        </tr>
                    <?php
                    $sum+=$return->adjust_line_total_price; 
                }
            ?>
            <tr>
                <td colspan="7" class="align-right"><b>Total:</b></td>
                <td class="align-right"><b><?php echo number_format($sum,2); ?></b></td>
            </tr>
        </tbody>
    </table>

</body>
</html>