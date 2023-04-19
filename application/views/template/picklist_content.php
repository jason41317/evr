<div>
    <center><table width="95%" cellpadding="5" style="font-family: tahoma;font-size: 11">
            <tr>
                <td width="45%" valign="top"><br />
                    <span>Department :</span><br />
                    <address>
                        <strong><?php echo $picklist->department_name; ?></strong><br /><br />

                    </address>
                    <p>
                        <span>Pick date : <br /> <b><?php echo  date_format(new DateTime($picklist->date_pick),"m/d/Y"); ?></b></span><br /><br />
                    </p>
                    <br />
                    <span>Customer :</span><br />
                    <strong><?php echo $picklist->customer_name; ?></strong><br>
                    <br />
                    <span>Address :</span><br />
                    <strong><?php echo $picklist->address; ?></strong><br>
                </td>

                <td width="50%" align="right">
                    <p>Picklist No.</p><br />
                    <h4 class="text-navy"><?php echo $picklist->picklist_no; ?></h4><br />

                    <br>

                    <span>Salesperson :</span><br />
                    <strong><?php echo $picklist->salesperson; ?></strong>


                </td>
            </tr>
        </table></center>

    <br /><br />

    <center>
        <table width="95%" style="border-collapse: collapse;border-spacing: 0;font-family: tahoma;font-size: 11">
            <thead>
            <tr>
                <th width="50%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Item</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: right;height: 30px;padding: 6px;">Qty</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">UM</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: center;height: 30px;padding: 6px;">Pack Size</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Batch</th>
                <th width="10%" style="border-bottom: 2px solid gray;text-align: left;height: 30px;padding: 6px;">Expiration</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                foreach($picklist_items as $item){
            ?>
                <tr>
                    <td width="50%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->product_desc; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: right;height: 30px;padding: 6px;"><?php echo number_format($item->so_qty,0); ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: center;height: 30px;padding: 6px;"><?php echo $item->unit_name; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: center;height: 30px;padding: 6px;"><?php echo $item->size; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->batch_no; ?></td>
                    <td width="10%" style="border-bottom: 1px solid gray;text-align: left;height: 30px;padding: 6px;"><?php echo $item->exp_date; ?></td>
                </tr>
            <?php } ?>

            </tbody>
            <tfoot>
            </tfoot>
        </table><br /><br />
    </center>
</div>