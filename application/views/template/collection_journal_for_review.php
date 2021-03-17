<center>


    <table class="table_journal_entries_review"  width="97%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
                <br />

                <div class="tab-container tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $payment_info->payment_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#payment_review_<?php echo $payment_info->payment_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Payment</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="journal_review_<?php echo $payment_info->payment_id; ?>" data-parent-id="<?php echo $payment_info->payment_id; ?>" style="min-height: 300px;">

                            <?php
                                $is_check_not_due=$payment_info->payment_method_id==2 && $payment_info->rem_day_for_due>0;
                                if($is_check_not_due){
                            ?>

                            <div class="alert alert-dismissable alert-danger">
                                <i class="fa fa-exclamation-circle"></i>&nbsp; <strong>Ooopss!</strong> Looks like the check on this transaction is not yet <b>Due</b>. Please see details below. <br />
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            </div>

                            <?php } ?>

                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $payment_info->customer_name; ?></b>.<br />
                                    <i class="fa fa-exclamation-circle"></i>&nbsp; Please make sure that <b><?php echo $payment_info->customer_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                                <input type="hidden" name="payment_id" value="<?php echo $payment_info->payment_id; ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label> Txn #:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" name="txn_no" class="form-control" value="TXN-YYYYMMDD-XXX" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                   <label> <b class="required">*</b>  Date:</label>
                                                    <div class="input-group">
                                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $payment_info->payment_date; ?>">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                   <label> <b class="required">*</b>  Customer:</label>
                                                    <select name="customer_id" class="cbo_customer_list">
                                                        <?php foreach($customers as $customer){ ?>
                                                            <option value="<?php echo $customer->customer_id; ?>" <?php echo ($payment_info->customer_id===$customer->customer_id?'selected':''); ?>><?php echo $customer->customer_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <label> <b class="required">*</b>  Branch: </label>
                                                    <select name="department_id" class="cbo_department_list">
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>" <?php echo ($payment_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                   <label> <b class="required">*</b> Method of Payment : </label>
                                                    <select name="payment_method" class="cbo_payment_method">
                                                        <?php foreach($methods as $method){ ?>
                                                            <option value="<?php echo $method->payment_method_id; ?>" <?php echo ($payment_info->payment_method_id==$method->payment_method_id?'selected':''); ?>><?php echo $method->payment_method; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label><b class="required">*</b> OR # :</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-code"></i>
                                                        </span>
                                                        <input type="text" name="or_no" class="form-control" value="<?php echo $payment_info->receipt_no; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label> <b class="required">*</b> Amount :</label>
                                                    <input type="text" name="amount" class="numeric form-control" value="<?php echo number_format($payment_info->total_paid_amount,2); ?>">
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label>Check Date :</label>
                                                        <div class="input-group">
                                                            <input type="text" name="check_date" class="date-picker form-control" value="<?php echo ($payment_info->payment_method_id==2?$payment_info->date_check:''); ?>">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                         <label>Check # : </label>
                                                        <input type="text" name="check_no" class="form-control" value="<?php echo ($payment_info->payment_method_id==2?$payment_info->check_no:''); ?>">
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                                <br>
                                <span><strong><i class="fa fa-bars"></i> Journal Entries</strong></span>
                                <hr />

                                <table id="tbl_entries_for_review_<?php echo $payment_info->payment_id; ?>" class="table table-striped" style="background-color: white;">
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


                                <hr />
                                <label class="col-lg-2"> Remarks :</label><br />
                                <div class="col-lg-12">
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo $payment_info->remarks; ?></textarea>
                                </div>

                                <br /><hr />

                            </form>

                            <br /><br /><hr />


                            <div class="row">
                                <div class="col-lg-12">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary <?php echo ($is_check_not_due?'disabled':''); ?> <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
                                </div>
                            </div>


                        </div>

                        <div class="tab-pane" id="payment_review_<?php echo $payment_info->payment_id; ?>" >

                            <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Payment Transaction</strong></span></h4>
                            <hr />

                            <div style="margin-left: 2%">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <i class="fa fa-code"></i> <b> OR/AR # : </b><b><?php echo $payment_info->receipt_no; ?></b><br />
                                        <i class="fa fa-calendar"></i> <b> Payment Date :</b> <?php echo $payment_info->payment_date; ?><br />
                                        <i class="fa fa-caret-square-o-left"></i> <b> Receipt Type :</b> <?php echo $payment_info->receipt_type; ?><br /><br />
                                        <i class="fa fa-bookmark"></i> <b> Department : </b><?php echo $payment_info->department_name; ?><br />
                                        <i class="fa fa-users"></i> <b> Customer : </b><?php echo $payment_info->customer_name; ?><br /><br />
                                    </div>

                                    <div class="col-lg-6">
                                        <i class="fa fa-code"></i> <b>Method of Payment : </b><?php echo $payment_info->payment_method; ?><br />
                                        <i class="fa fa-calendar"></i><b> Check Date : </b><?php echo $payment_info->date_check; ?><br />
                                        <i class="fa fa-caret-square-o-left"></i><b> Check # : </b><?php echo $payment_info->check_no; ?><br /><br />
                                        <i class="fa fa-bookmark"></i> <b>Total Payment :</b> <b><?php echo number_format($payment_info->total_paid_amount,2); ?></b><br />

                                    </div>

                                </div>


                                <table class="table table-striped">
                                    <thead>
                                    <tr style="">
                                        <td width="12%"><strong>Invoice #</strong></td>
                                        <td width="12%"><strong>Invoice Date</strong></td>
                                        <td width="12%"><strong>Due Date</strong></td>
                                        <td width="50%"><strong>Remarks</strong></td>
                                        <td width="14%" style="text-align: right;"><strong>Paid Amount</strong></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($payments_list as $pay){ ?>
                                            <tr>
                                                <td><?php echo $pay->sales_inv_no; ?></td>
                                                <td><?php echo $pay->invoice_date; ?></td>
                                                <td><?php echo $pay->due_date; ?></td>
                                                <td><?php echo $pay->remarks; ?></td>
                                                <td align="right"><?php echo number_format($pay->payment_amount,2); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                    <tfoot>

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




