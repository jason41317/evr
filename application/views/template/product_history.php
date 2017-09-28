

<div style="padding:1%;">

   <center>
       <table width="100%"  style="border-collapse: collapse;">
           <thead>
                <tr>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Reference</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Txn Type</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Description</b></td>

                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Exp Date</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;"><b>Batch #</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>In</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Out</b></td>
                    <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><b>Balance</b></td>
                </tr>

           </thead>
           <tbody>
                <?php if(count($products)==0){ ?>
                    <tr>
                        <td colspan="9" style="border: 1px solid lightgrey;padding: 10px;" align="center">No transaction found.</td>
                    </tr>
                <?php } ?>

                <?php foreach($products as $product){ ?>
               <tr>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo date("M d, Y",strtotime($product->txn_date)); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php if($product->type=="Other Sales Invoice"||$product->type=="Sales Invoice"){ ?><a href="#" class="force_adjust_cost" data-exp-date="<?php echo $product->exp_date; ?>" data-batch-id="<?php echo $product->batch_no; ?>" data-prod-id="<?php echo $product->product_id; ?>" data-ref-no="<?php echo $product->ref_no; ?>"><?php } ?><?php echo $product->ref_no; ?><?php if($product->type=="Other Sales Invoice"||$product->type=="Sales Invoice"){ ?></a><?php } ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->type; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->Description; ?></td>

                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->exp_date; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;"><?php echo $product->batch_no; ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->in_qty,0); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;"><?php echo number_format($product->out_qty,0); ?></td>
                   <td style="border: 1px solid lightgrey;padding: 5px;text-align: right;font-weight: bolder;"><?php echo number_format($product->balance,0); ?></td>
               </tr>
                <?php } ?>

           </tbody>
       </table>
       <br /><br />

   </center>
</div>





















