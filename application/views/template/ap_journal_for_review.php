<center>
    <table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
                <br />
                <div class="tab-container tab-top tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $purchase_info->dr_invoice_id; ?>" data-parent-id="<?php echo $purchase_info->dr_invoice_id; ?>" style="min-height: 300px;">
                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $purchase_info->supplier_name; ?></b>.<br />
                                    <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $purchase_info->supplier_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                                    <input type="hidden" name="dr_invoice_id" value="<?php echo $purchase_info->dr_invoice_id; ?>">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label> <b class="required"> * </b> Branch : </label>
                                            <select name="department_id" class="cbo_department_list" data-error-msg="" required>
                                                <?php foreach($departments as $department){ ?>
                                                    <option value="<?php echo $department->department_id; ?>" <?php echo ($purchase_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        
                                        <div class="col-lg-3 col-lg-offset-3">
                                            <label>Txn # :</label>
                                            <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                       
                                        <div class="col-lg-6">
                                            <label> <b class="required"> * </b> Supplier : </label>
                                            <select name="supplier_id" class="cbo_supplier_list" data-error-msg="Input Tax Account is required." required>
                                                <?php foreach($suppliers as $supplier){ ?>
                                                    <option value="<?php echo $supplier->supplier_id; ?>" <?php echo ($purchase_info->supplier_id===$supplier->supplier_id?'selected':''); ?>><?php echo $supplier->supplier_name; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        
                                        <div class="col-lg-3 col-lg-offset-3">
                                            <label><b class="required"> * </b> Date :</label>
                                            <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $purchase_info->date_delivered; ?>">
                                        </div>
                                    </div><br />
                                    <span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Journal Entries</strong></span>
                                <hr />

                                <table id="tbl_entries_for_review_<?php echo $purchase_info->dr_invoice_id; ?>" class="table table-bordered" style="background-color: white;">
                                    <thead>
                                    <tr style="">
                                        <th style="width: 30%;">Account</th>
                                        <th style="">Memo</th>
                                        <th style="width: 15%;text-align: right;">Dr</th>
                                        <th style="width: 15%;text-align: right;">Cr</th>
                                        <th style="width: 10%;">Action</th>
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
                                    <button name="btn_finalize_journal_review" class="btn btn-primary <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize this Journal</button>
                                </div>
                            </div>


                        </div>

                        <div class="tab-pane" id="purchase_review_<?php echo $purchase_info->dr_invoice_id; ?>" >

                                <span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Purchase Invoice</strong></span>
                                <hr />

                                <div style="margin-left: 2%">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fa fa-code"></i> <b>Invoice # :</b> <?php echo $purchase_info->dr_invoice_no; ?><br />
                                            <i class="fa fa-caret-square-o-left"></i> <b>External # :</b> <?php echo $purchase_info->external_ref_no; ?><br />
                                            <i class="fa fa-bookmark"></i> <b>PO # :</b> <?php echo $purchase_info->po_no; ?><br /><br />
                                            <i class="fa fa-calendar"></i> <b>Terms :</b> <?php echo $purchase_info->term_description; ?><br />
                                            <i class="fa fa-calendar-o"></i> <b>Delivery Date :</b> <?php echo $purchase_info->date_delivered; ?><br />
                                            <i class="fa fa-file-o"></i> <b>Remarks :</b> <?php echo $purchase_info->remarks; ?><br />
                                        </div>

                                        <div class="col-lg-6">
                                            <i class="fa fa-users"></i> <b>Supplier : </b><?php echo $purchase_info->supplier_name; ?><br />
                                            <i class="fa fa-globe"></i> <b>Address : </b><?php echo $purchase_info->address; ?><br />
                                            <i class="fa fa-send"></i> <b>Email : </b><?php echo $purchase_info->email_address; ?><br />
                                            <i class="fa fa-phone-square"></i> <b>Telephone : </b><?php echo $purchase_info->contact_no; ?><br />
                                            <br />

                                            <i class="fa fa-user"></i> <b>Posted by : </b><?php echo $purchase_info->posted_by; ?><br />
                                            <i class="fa fa-calendar"></i> <b>Date : </b><?php echo $purchase_info->date_created; ?><br />

                                        </div>
                                    </div>



                                    <br /><br />

                                    <table class="table table-striped" style="background-color: white;">
                                        <thead>
                                            <tr style="">
                                                <td style="width: 40%;"><strong>Item</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Qty</strong></td>
                                                <td style="width: 12%;"><strong>UM</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Price (RR)</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Price (PO)</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Tax</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                                $dr_total_price=0.00;
                                                $dr_total_tax=0.00;

                                                foreach($items as $item){

                                                    ?>
                                            <tr style="<?php echo ($purchase_info->po_no != '' && $item->dr_price != $item->po_price ? 'color: #f44336; font-weight: bolder;' : ''); ?>">
                                                <td><?php echo $item->product_desc; ?></td>
                                                <td align="right"><?php echo number_format($item->dr_qty,2); ?></td>
                                                <td>pcs</td>
                                                <td align="right"><?php echo number_format($item->dr_price,2); ?></td>
                                                <td align="right"><?php echo number_format($item->po_price,2); ?></td>
                                                <td align="right"><?php echo number_format($item->dr_tax_amount,2); ?></td>
                                                <td align="right"><?php echo number_format($item->dr_line_total_price,2); ?></td>
                                            </tr>
                                            <?php

                                                    $dr_total_price+=$item->dr_line_total_price;
                                                    $dr_total_tax+=$item->dr_tax_amount;
                                            }

                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right"><strong>Total</strong></td>
                                                <td align="right"><strong><?php echo number_format($dr_total_tax,2); ?></strong></td>
                                                <td align="right"><strong><?php echo number_format($dr_total_price,2); ?></strong></td>
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




