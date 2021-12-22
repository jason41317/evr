<head>  <title>Issuance Report</title></head>
<body>
<style>

    .align-right {
        text-align: right;
    }

    .align-left {
        text-align: left;
    }

    .align-center {
        text-align: center;
    }

    .report-header {
        font-weight: bolder;
    }
          
      </style>

<div style="width:100%">
<table style="font-family:tahoma;width: 100%;border:none!important;" id="report_header">
    <tbody>
        <tr>
            <td style="width:75%;font-size:18px;font-weight:bold;border:none!important;">ITEM TRANSFER REPORT</td>
            <td style="width:25%;font-size:18px;font-weight:bold;border:none!important;text-align: right;"><?php echo $issuance_info->trn_no; ?></td>
        </tr>

    </tbody>
</table>

<table width="100%" id="issuance" style="border:none!important;">
    <thead>
    </thead>
    <tbody>
        <tr>
            <td style="width:20%;text-align:left;font-weight:bold;border:none!important;">From Department:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo $issuance_info->from_department_name; ?></td>
            <td style="width:10%;border:none!important;"></td>
            <td style="width:10%;border:none!important;"></td>
            <td style="width:20%;text-align:right;font-weight:bold;border:none!important;">Date:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo  date_format(new DateTime($issuance_info->date_issued),"m/d/Y"); ?></td>
        </tr>
        <tr>


            <td style="width:20%;text-align:left;font-weight:bold;border:none!important;">To Department:</td>
            <td style="width:20%;text-align:center;" class="report"><?php echo $issuance_info->to_department_name; ?></td>
            <td style="width:10%;border:none!important;"></td>

            <td style="width:10%;border: none!important;"></td>
            <td style="text-align:right;font-weight:bold;border:none!important;">Terms:</td>
            <td style="width:20%;text-align:center;" class="report"> <?php echo $issuance_info->terms; ?></td>
        </tr>
    </tbody>
</table><br>
<table width="100%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11;background-color: transparent!important;border:none!important;" class="nohover">
    <thead>
        <tr >
            <th style="width:25%;text-align:left;border-bottom: 1px solid gray;">Description</th>
            <th style="width:15%;text-align:left;border-bottom: 1px solid gray;">Expiration</th>
            <th style="width:15%;text-align:left;border-bottom: 1px solid gray;">Batch No</th>
            <th style="width:5%;text-align:center;border-bottom: 1px solid gray;">Quantity</th>
            <th style="width:10%;text-align:center;border-bottom: 1px solid gray;">Unit</th>
            <th style="width:15%;text-align:right;border-bottom: 1px solid gray;">Unit Price</th>
            <th style="width:15%;text-align:right;border-bottom: 1px solid gray;">Amount</th>
        </tr>
    </thead>
    <tbody>
       <?php 
            $grandtotal=0;
            foreach($issue_items as $item){
            $grandtotal+=$item->issue_line_total_price;
             ?>
                <tr>
                    <td style="border-bottom: 1px solid gray;"><?php echo $item->product_desc; ?></td>
                    <td style="border-bottom: 1px solid gray;"><?php echo $item->exp_date; ?></td>
                    <td style="border-bottom: 1px solid gray;"><?php echo $item->batch_no; ?></td>
                    <td style="text-align:center; border-bottom: 1px solid gray;"><?php echo number_format($item->issue_qty,0); ?></td>
                    <td style="text-align:center; border-bottom: 1px solid gray;"><?php echo $item->unit_name; ?></td>
                    <td style="border-bottom: 1px solid gray;" align="right"><?php echo number_format($item->issue_price,2); ?></td>
                    <td style="border-bottom: 1px solid gray;" align="right"><?php echo number_format($item->issue_line_total_price,2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="6" align="right"><strong>Grand Total</strong></td>
                <td style="font-weight:bold;" align="right"><?php echo number_format($grandtotal,2); ?></td>
            </tr>
    </tbody>
</table>
</div>









