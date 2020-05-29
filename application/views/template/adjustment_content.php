

<div>
    <center><table width="95%" cellpadding="5" style="font-family: tahoma;font-size: 11">
            <tr>
                <td width="45%" valign="top">
                    <span>Department :</span><br />
                    <address>
                        <strong><?php echo $adjustment_info->department_name; ?></strong><br /><br />

                    </address>
                    <p>
                        <span>Date adjusted : <br /> <b><?php echo  date_format(new DateTime($adjustment_info->date_adjusted),"m/d/Y"); ?></b></span><br />

                    </p>
                    <br />
                    <span>Adjustment type :</span><br />
                    <strong><?php echo $adjustment_info->adjustment_type; ?></strong><br>
                </td>

                <?php if($adjustment_info->is_returns == 1){ ?>
                    <td width="50%" align="right" valign="top">
                        <p>Adjustment No.</p>
                        <h4 class="text-navy"><?php echo $adjustment_info->adjustment_code; ?></h4><br />
                        <p>
                            Reference No : <br/>
                            <b><?php echo $adjustment_info->inv_no; ?></b>
                        </p>
                        <br/>
                        <p>
                            Customer : <br/>
                            <b><?php echo $adjustment_info->customer_name; ?></b>
                        </p>
                    </td>
                <?php }else{?>
                    <td width="50%" align="right">
                        <p>Adjustment No.</p><br />
                        <h4 class="text-navy"><?php echo $adjustment_info->adjustment_code; ?></h4><br />
                    </td>
                <?php }?>
            </tr>
        </table></center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <thead>
            <tr>
                <th width="50%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Item</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Qty</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Price</th>
                <th width="12%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($adjustment_items as $item){ ?>
                <tr>
                    <td width="50%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->adjust_qty,0); ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: center;height: 30px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->adjust_price,2); ?></td>

                    <td width="12%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->adjust_line_total_price,2); ?></td>
                </tr>
            <?php } ?>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="height: 30px;padding: 6px;border-right: 1px solid gray;border-left: 1px solid gray;">Remarks</td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Discount : </td>
                <td style="border-bottom: 1px solid gray;border-right: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($adjustment_info->total_discount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="3" style="height: 30px;padding: 6px;border-right: 1px solid gray;border-bottom: 1px solid gray;border-left: 1px solid gray;" valign="top"><?php echo $adjustment_info->remarks; ?></td>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Total before Tax : </td>
                <td style="border-bottom: 1px solid gray;border-right: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($adjustment_info->total_before_tax,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;">Tax Amount : </td>
                <td style="border-bottom: 1px solid gray;border-right: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($adjustment_info->total_tax_amount,2); ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom:1px solid gray;text-align: left;height: 30px;padding: 6px;"><strong>Total after Tax : </strong></td>
                <td style="border-bottom: 1px solid gray;border-right: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><strong><?php echo number_format($adjustment_info->total_after_tax,2); ?></strong></td>
            </tr>
            </tfoot>
        </table><br /><br />
    </center>
</div>





















