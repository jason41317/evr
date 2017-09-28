<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Invoice</title> 
    <style>
        html {
            font-family: 'Calibri',sans-serif;
        }

        .company-info {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="container-fluid">
            <div class="text-center">
                <span style="font-weight: 600; font-size: 20px;">EVR Vet-Options Corporation</span><br>
                <span class="company-info"><?php echo $company_info->company_address; ?></span><br>
                <span class="company-info">Tel nos.: <?php echo $company_info->landline; ?></span><br>
                <span class="company-info">VAT REG. TIN NO <?php echo $company_info->tin_no; ?></span>
            </div>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <h4 style="font-weight: 700;">SALES INVOICE</h4>
                    </td>
                    <td width="50%" align="right">
                        <h4><span style="font-weight: 700;">No. </span><span style="color: red;"><?php echo $sales_info->sales_inv_no; ?></span></h4>
                    </td>
                </tr>
            </table>
                <table cellspacing="5" width="100%" style="border: 2px solid #757575; padding: 5px; font-size: 12px;">
                    <tr>
                        <td class="" width="15%">SOLD To :</td>
                        <td class="" style="border-bottom: 1px solid #757575; font-size: 14px; font-family: 'Times New Roman', sans-serif;" width="30%"><strong><?php echo $sales_info->customer_name; ?></strong></td>
                        <td class="" width="16%">OSCA/PWD ID No. :</td>
                        <td class="" style="border-bottom: 1px solid #757575;"     width="16%"></td>
                        <td class="" colspan="2" width="33%">CardHolder's Signature : </td>
                    </tr>
                    <tr>
                        <td class="" colspan="2"></td>
                        <td class="">REF NO. :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->so_no.' '.$sales_info->acr_name; ?></strong></td>
                        <td class="" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="">ADDRESS :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->address; ?></strong></td>
                        <td class="">DATE :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;" colspan="3" width="16%"><strong><?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="">BUSINESS STYLE :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"></td>
                        <td class="">TERMS :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"></td>
                        <td class="" width="6%">TIN :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;" width="30%"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 7px;">
        <div class="container-fluid">
            <table style="font-size: 12px;" width="100%" cellpadding="2" class="table-border" border="1" cellspacing="0" bordercolor="#757575">
                <thead>
                    <tr>
                        <th width="30%" class=" tbl-border-si text-center">PRODUCT</th>
                        <th width="10%" class=" tbl-border-si text-center">QTY</th>
                        <th width="10%" class=" tbl-border-si text-center">PACK SIZE</th>
                        <th width="10%" class=" tbl-border-si text-center">UNIT PRICE</th>
                        <th width="30%" class=" tbl-border-si text-center">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sum = 0;
                        $item_count = 15 - count($sales_invoice_items);
                        foreach($sales_invoice_items as $item) { 
                    ?>
                    <tr>
                        <td width="30%" class=" tbl-border-si" style="padding: 1px;"><?php echo $item->product_desc; ?><br>
                        <span style="font-size: 9px;"><?php echo $item->batch_no.' '.$item->exp_date; ?></span></td>
                        <td width="10%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_qty,0); ?></td>
                        <td width="10%" class=" tbl-border-si text-center"><?php echo $item->size; ?></td>
                        <td width="20%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_price,2); ?></td>
                        <td width="30%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                    </tr>
                    <?php
                    } 
                        if ($item_count < 15) {
                            for ($i = 0; $i < $item_count; $i++) {
                                echo 
                                '<tr>
                                    <td width="30%" class=" tbl-border-si" style="padding: 5px;">&nbsp;</td>
                                    <td width="10%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="10%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="20%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="30%" class=" tbl-border-si text-center">&nbsp;</td>
                                </tr>';
                            }
                        }
                    ?>
                    <tr>
                        <td class=" tbl-border-si" width="30%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Total Sales (VAT inclusive)</td>
                        <td class=" tbl-border-si" align="center" width="30%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class=" tbl-border-si"  width="30%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Less: VAT</td>
                        <td class=" tbl-border-si" align="center" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VATable Sales</td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Amount: Net of VAT</td>
                        <td class=" tbl-border-si" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VAT-Exempt Sales</td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Less: SC/PWD Discount</td>
                        <td class=" tbl-border-si" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">Zero Rated Sales</td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Amount Due</td>
                        <td class=" tbl-border-si" align="center" style="color: #404040;" width="30%"><?php echo number_format($sales_info->total_before_tax,2); ?></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VAT Amount</td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Add: VAT</td>
                        <td class=" tbl-border-si" align="center" style="color: #404040;" width="30%"><?php echo number_format($sales_info->total_tax_amount,2); ?></td>
                    </tr>
                    <tr>
                        <td class=" tbl-border-si"  width="50%" colspan="3"></td>
                        <td width="20%" class=" tbl-border-si tbl-left"><strong>TOTAL AMOUNT DUE</strong></td>
                        <td class=" tbl-border-si" align="center" width="30%"><?php echo number_format($sales_info->total_after_tax,2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
            <table class="table-border" width="100%" style="font-size: 12px;">
                <tbody>
                    <tr>
                        <td width="15%"> </td>
                        <td width="15%"></td>
                        <td style="font-size: 10px;" width="70%">RECEIVED the above-mentioned quantity and merchandise in good order, condition and to my/our full and complete satisfaction. I/We agree to the conditions stipulated therein.</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="">Prepared By</td>
                        <td class="">Checked By</td>
                        <td class="">Customer / Authorized Representative (Print Name Over Signature / Date)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
 -->


<!-- *********************************************** Another Format ************************************************** -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sales Invoice</title> 
    <style>
        @page {
            -webkit-transform: rotate(-90deg); -moz-transform:rotate(-90deg);
            filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        }

        html {
            font-family: 'Calibri',sans-serif;
        }

        .company-info {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }
    </style>

    <script>
        window.print();
    </script>
</head>
<body>
    <div class="row">
        <div class="container-fluid">
            <div class="text-center">
                <span style="font-weight: 600; font-size: 20px;">EVR Vet-Options Corporation</span><br>
                <span class="company-info"><?php echo $company_info->company_address; ?></span><br>
                <span class="company-info">Tel nos.: <?php echo $company_info->landline; ?></span><br>
                <span class="company-info">VAT REG. TIN NO <?php echo $company_info->tin_no; ?></span>
            </div>
            <table width="100%">
                <tr>
                    <td width="50%">
                        <span style="font-weight: 700;">SALES INVOICE</span>
                    </td>
                    <td width="50%" align="right">
                        <span><span style="font-weight: 700;">No. </span><span style="color: red;"><?php echo $sales_info->sales_inv_no; ?></span></span>
                    </td>
                </tr>
            </table>
                <table cellspacing="5" width="100%" style="border: 2px solid #757575; padding: 5px; font-size: 12px;">
                    <tr>
                        <td class="" width="15%">SOLD To :</td>
                        <td class="" style="border-bottom: 1px solid #757575; font-size: 16px; font-family: 'Times New Roman', sans-serif;" width="30%"><strong><?php echo $sales_info->customer_name; ?></strong></td>
                        <td class="" width="16%">OSCA/PWD ID No. :</td>
                        <td class="" style="border-bottom: 1px solid #757575;"     width="16%"></td>
                        <td class="" colspan="2" width="33%">CardHolder's Signature : </td>
                    </tr>
                    <tr>
                        <td class="" colspan="2"></td>
                        <td class="">REF NO. :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->so_no.' '.$sales_info->acr_name; ?></strong></td>
                        <td class="" colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="">ADDRESS :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->address; ?></strong></td>
                        <td class="">DATE :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;" colspan="3" width="16%"><strong><?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="">BUSINESS STYLE :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"></td>
                        <td class="">TERMS :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;"></td>
                        <td class="" width="6%">TIN :</td>
                        <td class="" style="border-bottom: 1px solid  #757575;" width="30%"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 7px;">
        <div class="container-fluid">
            <table style="font-size: 12px; margin-bottom: 0;" width="100%" class="table-border" border="1" cellspacing="0" bordercolor="#757575">
                <thead>
                    <tr>
                        <th width="30%" class=" tbl-border-si text-center">PRODUCT</th>
                        <th width="10%" class=" tbl-border-si text-center">QTY</th>
                        <th width="10%" class=" tbl-border-si text-center">PACK SIZE</th>
                        <th width="10%" class=" tbl-border-si text-center">UNIT PRICE</th>
                        <th width="30%" class=" tbl-border-si text-center">AMOUNT</th>
                    </tr>
                </thead>
                <tbody style="font-family: 'Times New Roman', serif;">
                    <?php 
                        $sum = 0;
                        $item_count = 15 - count($sales_invoice_items);
                        foreach($sales_invoice_items as $item) { 
                    ?>
                    <tr>
                        <td width="30%" class=" tbl-border-si" style="padding: 1px; font-size: 13px; font-weight: 200;"><?php echo $item->product_desc; ?><br>
                        <span style="font-size: 10px;"><?php echo $item->batch_no.' '.$item->exp_date; ?></span></td>
                        <td style="font-size: 15px;" width="10%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_qty,0); ?></td>
                        <td style="font-size: 15px;" width="10%" class=" tbl-border-si text-center"><?php echo $item->size; ?></td>
                        <td style="font-size: 15px;" width="20%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_price,2); ?></td>
                        <td style="font-size: 15px;" width="30%" class=" tbl-border-si text-center"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                    </tr>
                    <?php
                    } 
                        if ($item_count < 15) {
                            for ($i = 0; $i < $item_count; $i++) {
                                echo 
                                '<tr>
                                    <td width="30%" class=" tbl-border-si" style="padding: 9px;">&nbsp;</td>
                                    <td width="10%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="10%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="20%" class=" tbl-border-si text-center">&nbsp;</td>
                                    <td width="30%" class=" tbl-border-si text-center">&nbsp;</td>
                                </tr>';
                            }
                        }
                    ?>

                </tbody>
            </table>
            <table style="font-size: 12px;" width="100%" cellpadding="2" class="table-border" border="1" cellspacing="0" bordercolor="#757575">
                    <tr>
                        <td class=" tbl-border-si" width="30%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Total Sales (VAT inclusive)</td>
                        <td class=" tbl-border-si" align="center" width="30%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class=" tbl-border-si"  width="30%"></td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Less: VAT</td>
                        <td class=" tbl-border-si" align="center" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VATable Sales</td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Amount: Net of VAT</td>
                        <td class=" tbl-border-si" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VAT-Exempt Sales</td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Less: SC/PWD Discount</td>
                        <td class=" tbl-border-si" width="30%"></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">Zero Rated Sales</td>
                        <td class=" tbl-border-si" width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Amount Due</td>
                        <td class=" tbl-border-si" align="center" style="color: #404040; font-size: 13px; font-family: 'Times New Roman', serif;" width="30%"><?php echo number_format($sales_info->total_before_tax,2); ?></td>
                    </tr>
                    <tr>
                        <td width="40%" colspan="2" class=" tbl-border-si tbl-right">VAT Amount</td>
                        <td class=" tbl-border-si"  width="10%"></td>
                        <td width="20%" class=" tbl-border-si tbl-left">Add: VAT</td>
                        <td class=" tbl-border-si" align="center" style="color: #404040;font-size: 13px; font-family: 'Times New Roman', serif;" width="30%"><?php echo number_format($sales_info->total_tax_amount,2); ?></td>
                    </tr>
                    <tr>
                        <td class=" tbl-border-si"  width="50%" colspan="3"></td>
                        <td width="20%" class=" tbl-border-si tbl-left"><strong>TOTAL AMOUNT DUE</strong></td>
                        <td class=" tbl-border-si" align="center" width="30%" style="font-size: 15px; font-family: 'Times New Roman', serif; font-weight: bold;"><?php echo number_format($sales_info->total_after_tax,2); ?></td>
                    </tr>
                </table>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
            <table class="table-border" width="100%" style="font-size: 12px;">
                <tbody>
                    <tr>
                        <td width="15%"> </td>
                        <td width="15%"></td>
                        <td style="font-size: 10px;" width="70%">RECEIVED the above-mentioned quantity and merchandise in good order, condition and to my/our full and complete satisfaction. I/We agree to the conditions stipulated therein.</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                        <td style="padding-left: 5px; padding-right: 5px;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td class="">Prepared By</td>
                        <td class="">Checked By</td>
                        <td class="">Customer / Authorized Representative (Print Name Over Signature / Date)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
