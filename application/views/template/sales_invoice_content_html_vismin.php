<html>
    <head>
        <title>VISMIN - Sales Invoice</title>
        <style type="text/css">
            /*body {
                font-family: 'Times New Roman', serif;
                font-weight: 200;
            }*/

            @page {
                    size: auto;   /* auto is the initial value */
                    margin: .5in .5in 1in .35in; 
            }
        </style>


        <script type="text/javascript">
             window.print();
             setTimeout(function() {
                window.close();
             }, 500);
        </script>



    </head>
    <body>  
        <div class="row">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <h1 class="text-center" style="font-weight: 600;"><!-- EVR Vet-Options Corporation --></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h4 style="font-weight: 800;"><!-- SALES INVOICE --></h4>
            </div>
        </div>
            <br>
            <br>
            <br>
            <table class="" width="100%" style="margin-top: 6px;">
                <br>
                <tr>
                    <td class="table-cellpadding " width="8%"><!-- SOLD To : -->&nbsp;</td>
                    <td class="" width="40%" style="padding-bottom: 0; font-size: 16px; font-family: 'Times New Roman', serif; font-weight: 200; color: transparent;"><?php echo $sales_info->customer_name; ?></td>
                    <td class="table-cellpadding " width="16%"><!-- OSCA/PWD ID No. : -->&nbsp;</td>
                    <td class="table-cellpadding " width="16%">&nbsp;</td>
                    <td class="table-cellpadding " colspan="2" width="33%"><!-- CardHolder's Signature :  -->&nbsp;</td>
                    <span style="position: absolute; margin-top: -2px; margin-left: 60px;font-size: 16px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $sales_info->customer_name; ?></span>
                </tr>
                <tr>
                    <td class="table-cellpadding" colspan="2">&nbsp;</td>
                    <td class="table-cellpadding"><!-- REF NO. : -->&nbsp;</td>
                    <td class="" style="font-size: 12px; color: transparent; font-family: 'Times New Roman', serif; font-weight: 200;" colspan="3" style="padding-left: 90px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sales_info->so_no.' '.$sales_info->acr_name; ?></td>
                    <span style="position: absolute; margin-top: 14px; margin-left: 470px;font-size: 12px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $sales_info->so_no.' '.$sales_info->acr_name; ?></span>
                    <td class="table-cellpadding" colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="table-cellpadding "><!-- ADDRESS : -->&nbsp;</td>
                    <td class="" style="font-size: 12px; color: transparent;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $sales_info->address; ?></td>
                    <td class="table-cellpadding "><!-- DATE : -->&nbsp;</td>
                    <td class="" colspan="3" style="font-size: 12px; color: transparent;font-family: 'Times New Roman', serif; font-weight: 200;" style="padding-left: 80px;" width="16%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?></td>
                    <span style="position: absolute; margin-top: 30px; margin-left: 465px;font-size: 12px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo  date_format(new DateTime($sales_info->date_invoice),"m/d/Y"); ?></span>

                    <span style="position: absolute; margin-top: 48px; margin-left: 465px;font-size: 12px;font-family: 'Times New Roman', serif; font-weight: 200;">
                        <?php  if($sales_info->terms > 0){ echo $sales_info->terms; } ?>
                         <?php echo $sales_info->cod_pdc;?>
                    </span>

                    <span style="position: absolute; margin-top: 48px; margin-left:590px;font-size: 12px;font-family: 'Times New Roman', serif; font-weight: 200;">
                         <?php echo $sales_info->tin_no;?>
                    </span>

                    <span style="position: absolute; margin-top: 30px; margin-left: 60px;font-size: 12px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $sales_info->address; ?></span>
                </tr>
                <tr>
                    <td class="table-cellpadding "><!-- BUSINESS STYLE : -->&nbsp;</td>
                    <td class="table-cellpadding ">&nbsp;</td>
                    <td class="table-cellpadding "><!-- TERMS : -->&nbsp;</td>
                    <td class="table-cellpadding ">&nbsp;</td>
                    <td class="table-cellpadding " width="6%"><!-- TIN : -->&nbsp;</td>
                    <td class="table-cellpadding " width="30%">&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
</div><br>
<!-- <span style="position: absolute; top: 165px;">______________________________________________</span> -->
<div class="row" style="margin-top: -22px;">
    <div class="container-fluid">
        <table width="100%" cellspacing="0">
            <thead>
                
            </thead>
            <tbody>
                <!-- <tr>
                    <td width="30%" height="5px"></td>
                    <td width="10%" class="table-cellpadding tbl-center"></td>
                    <td width="10%" class="table-cellpadding tbl-center"></td>
                    <td width="20%" class="table-cellpadding tbl-center"></td>
                    <td width="30%" class="table-cellpadding tbl-center"></td>
                </tr> -->
                <tr>
                    <td width="33%" class=" " style=""><span style=" font-size: 13px;font-family: 'Times New Roman', serif; font-weight: 200;"></span><br>
                    </td>
                    <td width="3%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"></td>
                    <td width="3%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"></td>
                    <td width="20%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"><span style="float: left;">ED</span></td>
                    <td width="20%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"></td>
                </tr>
                <?php 
                    $item_count = 5 - count($sales_invoice_items);
                    foreach($sales_invoice_items as $item) { 
                ?>
                <tr>
                    <td width="33%" class=" " style=""><span style=" font-size: 13px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $item->product_desc; ?></span><br>
                    </td>
                    <td width="3%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo number_format($item->inv_qty,0); ?></td>
                    <td width="3%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo $item->size; ?></td>
                    <td width="20%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"><span style="float: left;"><?php echo date('M-Y',strtotime($item->exp_date)); ?></span>  <span style="float: right;"><?php echo number_format($item->inv_price,2); ?></span></td>
                    <td width="20%" align="center" class="tbl-center" style="font-size: 15px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo number_format($item->inv_qty * $item->inv_price,2); ?></td>
                </tr>
                <?php 
                    $total = $item->inv_line_total_price;
                    //$sum += $total;
                } 
                    if ($item_count < 5) {
                        for ($i = 0; $i < $item_count; $i++) {
                            echo 
                            '<tr>
                                <td class=" " style="padding: 5px;">&nbsp;</td>
                                <td class="table-cellpadding tbl-center">&nbsp;</td>
                                <td class="table-cellpadding tbl-center">&nbsp;</td>
                                <td class="table-cellpadding tbl-center">&nbsp;</td>
                                <td class="table-cellpadding tbl-center">&nbsp;</td>
                            </tr>';
                        }
                } ?>
                 <tr>
                    <td class="" >&nbsp;</td>
                    <td class="" >&nbsp;</td>
                    <td class="" >&nbsp;</td>
                    <td  class="table-cellpadding  tbl-left">&nbsp;</td>
                    <td class="" align="center" >&nbsp;</td>
                </tr>
                <tr >
                    <!-- <td style="text-align: right;" colspan="2">
                        Sales Discount
                        <small><?php  echo $sales_info->total_overall_discount > 0 ? "(". strval(number_format($sales_info->total_overall_discount,2))." %)" : '' ?></small>
                    </td>
                    <td style="text-align: right;" ><?php echo number_format($discount,2); ?></td>
                    <td class="table-cellpadding  tbl-left"></td>
                    <td class="" align="center"></td> -->

                    <td style="text-align: right; padding-right: 40px" width="40%" colspan="2" class="table-cellpadding  tbl-right">
                        Sales Discount
                        <small><?php  echo $sales_info->total_overall_discount > 0 ? "(". strval(number_format($sales_info->total_overall_discount,2))." %)" : '' ?></small>
                    </td>
                    <td style="text-align: right; padding-right: 20px; " class="" width="10%"><?php echo number_format($discount,2); ?></td>
                    <td width="20%" class="table-cellpadding  tbl-left">&nbsp;</td>
                    <td class="" align="center" width="30%">&nbsp;</td>
                </tr>
                <tr>
                    <td class="" >&nbsp;</td>
                    <td class="" >&nbsp;</td>
                    <td class="" >&nbsp;</td>
                    <td class="table-cellpadding  tbl-left"><!-- Total Sales (VAT inclusive)  -->&nbsp;</td>
                    <td class="" align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding  tbl-right"><!-- VATable Sales -->&nbsp;</td>
                    <td class="" width="10%">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><!-- Amount: Net of VAT -->&nbsp;</td>
                    <td class="" align="center" width="30%">&nbsp;</td>
                </tr>
                <tr>
                    <td class=""  width="30%">&nbsp;</td>
                    <td class="" width="10%">&nbsp;</td>
                    <td class=""  width="10%">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><!-- Less: VAT -->&nbsp;</td>
                    <td class="" align="center" width="30%">&nbsp;</td>
                </tr>
                <tr>
                    <td class=""  width="30%">&nbsp;</td>
                    <td class="" width="10%">&nbsp;</td>
                    <td class=""  width="10%">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><!-- Less: VAT -->&nbsp;</td>
                    <td class="" align="center" width="30%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding  tbl-right"><!-- Zero Rated Sales -->&nbsp;</td>
                    <td class="" width="10%">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><!-- Amount Due -->&nbsp;</td>
                    <td class="" style="color: transparent;" align="center" width="30%"><?php echo number_format($sales_info->total_before_tax,2); ?></td>
                    <!-- 270px -->
                    <span style="position: absolute; margin-top: 285px; margin-left: 600px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo number_format($sales_info->total_before_tax,2); ?></span>
                </tr>
                <tr>
                    <td width="40%" colspan="2" class="table-cellpadding  tbl-right"><!-- VAT Amount -->&nbsp;</td>
                    <td class=""  width="10%">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><!-- Add: VAT -->&nbsp;</td>
                    <td class="" style="color: transparent;" align="center" width="30%"><?php echo number_format($sales_info->total_tax_amount,2); ?></td>
                    <!-- 300px -->
                    <span style="position: absolute; margin-top: 315px; margin-left: 600px;font-family: 'Times New Roman', serif; font-weight: 200;"><?php echo number_format($sales_info->total_tax_amount,2); ?></span>
                </tr>
                <tr>
                    <td class=""  width="50%" colspan="3">&nbsp;</td>
                    <td width="20%" class="table-cellpadding  tbl-left"><strong><!-- TOTAL AMOUNT DUE -->&nbsp;</td>
                    <td class="" style="color: transparent;font-family: 'Times New Roman', serif; font-weight: 200;" align="center" width="30%"><strong><?php echo number_format($sales_info->total_after_tax,2); ?></td>
                    <!-- 330px -->
                    <span style="position: absolute; margin-top: 345px; margin-left: 600px;font-family: 'Times New Roman', serif; font-weight: 200;"><strong><?php echo number_format($sales_info->total_after_tax,2); ?></strong></span>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <table class="table-border" width="100%">
            <tbody>
                <tr>
                    <td width="15%"> </td>
                    <td width="15%"></td>
                    <td class="table-cellpadding" width="70%"><!-- RECEIVED the above-mentioned quantity and merchandise in good order, condition and to my/our full and complete satisfaction. I/We agree to the conditions stipulated therein. --> &nbsp;</td>
                </tr>
                <tr>
                    <!-- <td style="border-bottom: 1px solid #404040;">&nbsp;</td>
                    <td style="border-bottom: 1px solid #404040;">&nbsp;</td> -->
                    <td>&nbsp;</td>
                </tr>
                <tr style="text-align: center;">
                    <td class="table-cellpadding"><!-- Prepared By --></td>
                    <td class="table-cellpadding"><!-- Checked By --></td>
                    <td class="table-cellpadding"><!-- Customer / Authorized Representative (Print Name Over Signature / Date) --></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    </body>
</html>








