<center>
<table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
<tbody>
<tr>
<td>
<br />

<div class="tab-container tab-top tab-default">
<ul class="nav nav-tabs">
    <li class="active"><a href="#journal_review_<?php echo $sales_info->sales_invoice_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
    <li class=""><a href="#purchase_review_<?php echo $sales_info->sales_invoice_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
</ul>
<div class="tab-content">

<div class="tab-pane active" id="journal_review_<?php echo $sales_info->sales_invoice_id; ?>" data-parent-id="<?php echo $sales_info->sales_invoice_id; ?>" style="min-height: 300px;">

    <?php if(!$valid_particular){ ?>
        <div class="alert alert-dismissable alert-danger">
            <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $sales_info->customer_name; ?></b>.<br />
            <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $sales_info->customer_name; ?></b> is not deleted or cancelled to your masterfile record.
            <br /><br />
            <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
    <?php } ?>



    <form id="frm_journal_review" role="form" class="form-horizontal row-border">
            <input type="hidden" name="sales_invoice_id" value="<?php echo $sales_info->sales_invoice_id; ?>">
            <div class="row">
            
            <div class="col-lg-6">
            <label > <b class="required">*</b> Branch :</label>
                <select name="department_id" class="cbo_department_list" data-error-msg="Branch is required." required>
                    <?php foreach($departments as $department){ ?>
                        <option value="<?php echo $department->department_id; ?>" <?php echo ($sales_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                    <?php } ?>
                </select>

            </div>
            
            <div class="col-lg-3 col-lg-offset-3">
            <label> Txn # :</label>
                <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
            </div>

            </div>

            <div class="row">
            
            <div class="col-lg-6">
            <label > <b class="required">*</b> Customer :</label>
                <select name="customer_id" class="cbo_customer_list" data-error-msg="Customer is required." required>
                    <?php foreach($customers as $customer){ ?>
                        <option value="<?php echo $customer->customer_id; ?>" <?php echo ($sales_info->customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                    <?php } ?>
                </select>

            </div>   
            
            <div class="col-lg-3 col-lg-offset-3">
                <label class=""> <b class="required">*</b> Date :</label>
                <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $sales_info->date_invoice; ?>">
            </div>
            </div>

        <br /><span><strong><i class="fa fa-bars"></i> Journal Entries</strong></span>
        <hr />

        <table id="tbl_entries_for_review_<?php echo $sales_info->sales_invoice_id; ?>" class="table table-bordered" style="background-color: white;">
            <thead>
            <tr style="">
                <th style="width: 30%;">Account</th>
                <th >Memo</th>
                <th style="width: 15%;text-align: right;">Dr</th>
                <th style="width: 15%;text-align: right;">Cr</th>
                <th width="10%">Action</th>
            </tr>
            </thead>

            <tbody>

            <?php

            $dr_total=0.00; $cr_total=0.00;

            foreach($entries as $entry){


                ?>
                <tr>
                    <td>
                        <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" title="Please select Student">
                            <?php foreach($accounts as $account){ ?>
                                <option value='<?php echo $account->account_id; ?>' <?php echo ($entry->account_id==$account->account_id?'selected':''); ?> ><?php echo $account->account_title; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" name="memo[]" class="form-control"  value="<?php echo $entry->memo; ?>"></td>
                    <td><input type="text" name="dr_amount[]" class="form-control numeric" value="<?php echo number_format($entry->dr_amount,2); ?>"></td>
                    <td><input type="text" name="cr_amount[]" class="form-control numeric"  value="<?php echo number_format($entry->cr_amount,2);?>"></td>
                    <td>
                        <button type="button" class="btn btn-default add_account"><i class="fa fa-plus-circle" style="color: green;"></i></button>
                        <button type="button" class="btn btn-default remove_account"><i class="fa fa-times-circle" style="color: red;"></i></button>
                    </td>
                </tr>
                <?php
                $dr_total+=$entry->dr_amount;
                $cr_total+=$entry->cr_amount;

            }

            ?>


            </tbody>

            <tfoot>
            <tr>
                <td colspan="2" align="right"><strong>Total</strong></td>
                <td align="right"><strong><?php echo number_format($dr_total,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($cr_total,2); ?></strong></td>
                <td></td>
            </tr>
            </tfoot>

        </table>
        <label class="col-lg-2"> Remarks :</label><br />
        <div class="col-lg-12">
            <textarea name="remarks" class="form-control" style="width: 100%;"></textarea>
        </div>

        <br /><hr />

    </form>

    <br /><br /><hr />


    <div class="row">
        <div class="col-lg-12">
            <button name="btn_finalize_journal_review" class="btn btn-primary  <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
        </div>
    </div>


</div>

<div class="tab-pane" id="purchase_review_<?php echo $sales_info->sales_invoice_id; ?>" >

    <span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Sales Invoice</strong></span>
    <hr />

    <div style="margin-left: 2%">

        <div class="row">
            <div class="col-lg-6">
                <i class="fa fa-code"></i> <b>Invoice # : </b><?php echo $sales_info->sales_inv_no; ?><br />
                <i class="fa fa-bookmark"></i> <b>SO # : </b><?php echo $sales_info->so_no; ?><br /><br />
                <i class="fa fa-calendar-o"></i> <b>Invoice Date : </b><?php echo $sales_info->date_invoice; ?><br />
                <i class="fa fa-file-o"></i> <b>Remarks : </b><?php echo $sales_info->remarks; ?><br />
            </div>

            <div class="col-lg-6">
                <i class="fa fa-users"></i><b> Customer : </b><?php echo $sales_info->customer_name; ?><br />
                <i class="fa fa-globe"></i><b> Address : </b><?php echo $sales_info->address; ?><br />
                <i class="fa fa-send"></i> <b>Email : </b><?php echo $sales_info->email_address; ?><br />
                <i class="fa fa-phone-square"></i> <b>Telephone : </b><?php echo $sales_info->contact_no; ?><br />
                <br />

                <i class="fa fa-user"></i> <b>Posted by : </b><?php echo $sales_info->posted_by; ?><br />
                <i class="fa fa-calendar"></i> <b>Date : </b><?php echo $sales_info->date_created; ?><br />

            </div>
        </div>



        <br /><br />

        <table class="table table-striped" style="background-color: white;">
            <thead>
            <tr style="">
                <td style="width: 40%;"><strong>Item</strong></td>
                <td style="width: 12%;text-align: right;"><strong>Qty</strong></td>
                <td style="width: 12%;"><strong>UM</strong></td>
                <td style="width: 12%;text-align: right;"><strong>Price</strong></td>
                <td style="width: 12%;text-align: right;"><strong>Tax</strong></td>
                <td style="width: 12%;text-align: right;"><strong>Total</strong></td>
            </tr>
            </thead>
            <tbody>
            <?php

            $inv_total_price=0.00;
            $inv_total_tax=0.00;

            foreach($items as $item){

                ?>
                <tr>
                    <td><?php echo $item->product_desc; ?></td>
                    <td align="right"><?php echo number_format($item->inv_qty,2); ?></td>
                    <td><?php echo $item->unit_name; ?></td>
                    <td align="right"><?php echo number_format($item->inv_price,2); ?></td>
                    <td align="right"><?php echo number_format($item->inv_tax_amount,2); ?></td>
                    <td align="right"><?php echo number_format($item->inv_line_total_price,2); ?></td>
                </tr>
                <?php

                $inv_total_price+=$item->inv_line_total_price;
                $inv_total_tax+=$item->inv_tax_amount;
            }

            ?>
            </tbody>

            <tfoot>
            <tr>
                <td colspan="4" align="right"><strong>Total</strong></td>
                <td align="right"><strong><?php echo number_format($inv_total_tax,2); ?></strong></td>
                <td align="right"><strong><?php echo number_format($inv_total_price,2); ?></strong></td>
            </tr>
            </tfoot>

        </table>

        <br /><br />
    </div>

</div>

</div>
</div>


</td>
</tr>
</tbody>

</table>
</center>




