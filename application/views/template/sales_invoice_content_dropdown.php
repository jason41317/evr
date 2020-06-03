<!-- <link rel="stylesheet" type="text/css" href="assets/css/style-blessed3ef7a.css"> -->
<style type="text/css">
   .tbl_sales_invoice_details .tbl-border-si {
    border: 1px solid #757575!important;
}
</style>
<div class="row">
    <div class="container-fluid">
            <table class="" width="100%" style="border: none!important;">
                <tr>
                    <td class="table-cellpadding" width="15%">Sold To :</td>
                    <td class="table-cellpadding" style="border-bottom: 1px solid  #757575;" width="30%"><strong><?php if ($_GET['category'] == 1) { echo $sales_info->customer_name; } else { echo $sales_info->department_name; }?></strong></td>
                    <td class="table-cellpadding">REF NO. :</td>
                    <td class="table-cellpadding" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->so_no.' '.$sales_info->acr_name; ?></strong></td>
                </tr>
                <tr>
                    <td class="table-cellpadding">ADDRESS :</td>
                    <td class="table-cellpadding" style="border-bottom: 1px solid  #757575;"><strong><?php echo $sales_info->address; ?></strong></td>
                    <td class="table-cellpadding">DATE :</td>
                    <td class="table-cellpadding" style="border-bottom: 1px solid  #757575;"><strong><?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</div><br>
<div class="row">
    <div class="container-fluid">
        <table width="100%" cellpadding="10" class="table-border tbl_sales_invoice_details">
            <thead>
                <tr>
                    <th width="40%" class="table-cellpadding tbl-border-si tbl-center">PRODUCT</th>
                    <th width="10%" class="table-cellpadding tbl-border-si tbl-center">QTY</th>
                    <th width="10%" class="table-cellpadding tbl-border-si tbl-center">PACK SIZE</th>
                    <th width="10%" class="table-cellpadding tbl-border-si tbl-center">UNIT PRICE</th>
                    <th width="20%" class="table-cellpadding tbl-border-si tbl-center">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($sales_invoice_items as $item) { 
                ?>
                <tr>
                    <td width="40%" class=" tbl-border-si" style="padding: 5px;"><?php echo $item->product_desc; ?><br>
                    <sup><?php echo $item->batch_no.' '.$item->exp_date; ?></sup></td>
                    <td width="10%" class="table-cellpadding tbl-border-si tbl-center"><?php echo number_format($item->inv_qty,0); ?></td>
                    <td width="10%" class="table-cellpadding tbl-border-si tbl-center"><?php echo $item->size; ?></td>
                    <td width="10%" class="table-cellpadding tbl-border-si tbl-center"><?php echo number_format($item->inv_price,2); ?></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-center"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class=" tbl-border-si" width="30%"></td>
                    <td class=" tbl-border-si" width="10%"></td>
                    <td class=" tbl-border-si" width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Total Sales (VAT inclusive)</td>
                    <td class=" tbl-border-si" align="center" width="30%">&nbsp;</td>
                </tr>
                <tr>
                    <td class=" tbl-border-si"  width="30%"></td>
                    <td class=" tbl-border-si" width="10%"></td>
                    <td class=" tbl-border-si"  width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Less: VAT</td>
                    <td class=" tbl-border-si" align="center" width="30%"></td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding tbl-border-si tbl-right">VATable Sales</td>
                    <td class=" tbl-border-si" width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Amount: Net of VAT</td>
                    <td class=" tbl-border-si" width="30%"></td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding tbl-border-si tbl-right">VAT-Exempt Sales</td>
                    <td class=" tbl-border-si"  width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Less: SC/PWD Discount</td>
                    <td class=" tbl-border-si" width="30%"></td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding tbl-border-si tbl-right">Zero Rated Sales</td>
                    <td class=" tbl-border-si" width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Amount Due</td>
                    <td class=" tbl-border-si" align="center" style="
                    <?php if ($_GET['category'] == 1) { echo 'color: #404040;'; } else { echo 'color: transparent;'; } ?>" width="30%"><?php echo number_format($sales_info->total_before_tax,2); ?></td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding tbl-border-si tbl-right">VAT Amount</td>
                    <td class=" tbl-border-si"  width="10%"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left">Add: VAT</td>
                    <td class=" tbl-border-si" align="center" style="
                    <?php if ($_GET['category'] == 1) { echo 'color: #404040;'; } else { echo 'color: transparent;'; }?>" width="30%"><?php echo number_format($sales_info->total_tax_amount,2); ?></td>
                </tr>
                <tr>
                    <td class=" tbl-border-si"  width="50%" colspan="3"></td>
                    <td width="20%" class="table-cellpadding tbl-border-si tbl-left"><strong>TOTAL AMOUNT DUE</strong></td>
                    <td class=" tbl-border-si" align="center" width="30%"><?php echo number_format($sales_info->total_after_tax,2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div style='border-bottom:1px solid gray;'></div>
    </div>
</div><br />
<div class="row" >
    <div class="col-lg-12">
        <div class="title-action" style="margin-left: 3%;">
            <a href="Sales_invoice/transaction/print/<?php echo $sales_info->sales_invoice_id; ?>" target="_blank" class="btn btn-default" style="text-transform:none;font-family: tahoma;" ><i class="fa fa-print"></i> Print Sales Invoice</a>
        </div>
    </div>

</div>







