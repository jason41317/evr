<style>
/*    .tab-container .nav.nav-tabs li a {
        background: #414141 !important;
        color: white !important;
    }
    .tab-container .nav.nav-tabs li a:hover {
        background: #414141 !important;
        color: white !important;
    }
    .tab-container .nav.nav-tabs li a:focus {
        background: #414141 !important;
        color: white !important;
    }
*/
    table.table_journal_entries_review td {
        border: 0px !important;
    }
    tr {
        border: none!important;
    }
/*    tr:nth-child(even){
        background: #414141 !important;
        border: none!important;
    }
*/
/*
    tr:hover {
        transition: .4s;
        background: transparent !important;
        color: white;
    }
    tr:hover .btn {
        border-color: #494949!important;
        border-radius: 0!important;
        -webkit-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.75);
    }
*/
</style>
<center>
    <table class="table_journal_entries_review"  width="100%" style="font-family: tahoma;">
        <tbody>
        <tr>
            <td>
                <br />
                <div class="tab-container tab-top tab-default">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#journal_review_<?php echo $adjustment_info->adjustment_id; ?>" data-toggle="tab"><i class="fa fa-gavel"></i> Review Journal</a></li>
                        <li class=""><a href="#purchase_review_<?php echo $adjustment_info->adjustment_id; ?>" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Transaction</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="journal_review_<?php echo $adjustment_info->adjustment_id; ?>" data-parent-id="<?php echo $adjustment_info->adjustment_id; ?>" style="min-height: 300px;">
                            <?php if(!$valid_particular){ ?>
                                <div class="alert alert-dismissable alert-danger">
                                    <i class="ti ti-close"></i>&nbsp; <strong>Sorry!</strong> We could not find the record of <b><?php echo $particular_name; ?></b>.<br />
                                    <i class="ti ti-close"></i>&nbsp; Please make sure that <b><?php echo $particular_name; ?></b> is not deleted or cancelled to your masterfile record.
                                    <br /><br />
                                    <i class="fa fa-bars"></i>&nbsp; Please call the System Administrator or Developer for assistance.
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </div>
                            <?php } ?>
                            <form id="frm_journal_review" role="form" class="form-horizontal row-border">
                            <input type="hidden" name="ref_no" value="<?php echo $adjustment_info->adjustment_code; ?>">
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> General Journal</strong></span></h4>
                                <hr />
                                <div style="width: 90%;">
                                    <input type="hidden" name="adjustment_id" value="<?php echo $adjustment_info->adjustment_id; ?>">
                                    <label class="col-lg-2"> <b class="required">*</b> Txn # :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="txn_no" class="form-control" style="font-weight: bold;" placeholder="TXN-MMDDYYY-XXX" readonly>
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Date :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="date_txn" class="date-picker  form-control" value="<?php echo $adjustment_info->date_adjusted; ?>">
                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Particular : </label>
                                    <div class="col-lg-10">

                                            <select id="cbo_particulars" name="particular_id" class=" cbo_supplier_list selectpicker show-tick form-control" data-live-search="true" data-error-msg="Particular is required." required>
                                                <optgroup label="Customers">
                                                    <?php foreach($customers as $customer){ ?>
                                                        <option value='C-<?php echo $customer->customer_id; ?>' 
                                                            <?php if($particular_type == 1){
                                                                echo ($particular_id===$customer->customer_id?'selected':''); 
                                                                }?>>
                                                            <?php echo $customer->customer_name; ?></option>
                                                    <?php } ?>
                                                </optgroup>

                                                <optgroup label="Suppliers">
                                                    <?php foreach($suppliers as $supplier){ ?>
                                                        <option value='S-<?php echo $supplier->supplier_id; ?>' 
                                                            <?php if($particular_type == 2){
                                                                echo ($particular_id===$supplier->supplier_id?'selected':''); 
                                                                }?>>
                                                            <?php echo $supplier->supplier_name; ?></option>
                                                    <?php } ?>
                                                </optgroup>

                                            </select>

                                    </div>
                                    <br /><br />
                                    <label class="col-lg-2"> <b class="required">*</b> Branch : </label>
                                    <div class="col-lg-10">
                                        <select name="department_id" class="cbo_department_list" data-error-msg="" required>
                                            <?php foreach($departments as $department){ ?>
                                                <option value="<?php echo $department->department_id; ?>" <?php echo ($adjustment_info->department_id===$department->department_id?'selected':''); ?>><?php echo $department->department_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <br /><br /><br />
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-gear"></i> Journal Entries</strong></span></h4>
                                <hr />
                                <table id="tbl_entries_for_review_adj<?php echo $adjustment_info->adjustment_id; ?>" class="table table-striped" style="width: 100% !important;">
                                    <thead>
                                    <tr style="border-bottom:solid gray;">
                                        <th style="width: 30%;">Account</th>
                                        <th style="width: 15%;">Memo</th>
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
                                                <select name="accounts[]" class="selectpicker show-tick form-control selectpicker_accounts" data-live-search="true" >
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
                                    <textarea name="remarks" class="form-control" style="width: 100%;"><?php echo $adjustment_info->remarks; ?></textarea>
                                </div>
                                <br /><hr />
                            </form>
                            <br /><br /><hr />
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <button name="btn_finalize_journal_review" class="btn btn-primary <?php if(!$valid_particular){ echo "disabled"; }?>"><i class="fa fa-check-circle"></i> <span class=""></span> Finalize and Post this Journal</button>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group" style="float: right;">
                                        <input type="text" name="closing_reason" class="form-control" placeholder="Close Notes/Remarks" >
                                         <span class="input-group-addon " style="padding: 0px;background-color: #ff0039!important;">
                                            <button name="btn_close_journal_review" class="btn btn-danger " title="Click this if you don't want to post this in Accounting, and it will be removed from the list of Pending for Review" style="">Close</button>    
                                        </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="purchase_review_<?php echo $adjustment_info->adjustment_id; ?>" >
                                <h4><span style="margin-left: 1%"><strong><i class="fa fa-bars"></i> Adjustment</strong></span></h4>
                                <hr />
                                <div style="margin-left: 2%;margin-right: 20px;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fa fa-code"></i> Adjustment Code : <?php echo $adjustment_info->adjustment_code; ?><br />
                                            <i class="fa fa-calendar-o"></i> Adjustment Date : <?php echo $adjustment_info->date_adjusted; ?><br />
                                            <i class="fa fa-file-o"></i> Remarks : <?php echo $adjustment_info->remarks; ?><br />
                                        </div>
                                        <div class="col-lg-6">
                                            <i class="fa fa-user"></i> Posted by : <?php echo $adjustment_info->posted_by; ?><br />
                                            <i class="fa fa-calendar"></i> Date : <?php echo $adjustment_info->date_created; ?><br />
                                        </div>
                                    </div>
                                    <br /><br />
                                    <table class="table table-striped" style="width: 100% !important;">
                                        <thead>
                                            <tr style="border-bottom: solid gray;">
                                                <td style="width: 40%;"><strong>Item</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Qty</strong></td>
                                                <td style="width: 12%;"><strong>UM</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Net Vat</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Tax</strong></td>
                                                <td style="width: 12%;text-align: right;"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $gross_total=0;
                                                $discounts=0;
                                                $dr_total_price=0;
                                                $dr_total_tax=0;
                                                foreach($items as $item){
                                                    ?>
                                            <tr style="">
                                                <td><?php echo $item->product_desc; ?></td>
                                                <td align="right"><?php echo number_format($item->adjust_qty,2); ?></td>
                                                <td><?php echo $item->unit_name; ?></td>
                                                <td align="right"><?php echo number_format($item->adjust_non_tax_amount,2); ?></td>
                                                <td align="right"><?php echo number_format($item->adjust_tax_amount,2); ?></td>
                                                <td align="right"><?php echo number_format($item->adjust_price * $item->adjust_qty,2); ?></td>
                                                
                                            </tr>
                                            <?php
                                                    $gross_total+=$item->adjust_qty*$item->adjust_price;
                                                    $discounts+=$item->global_discount_amount;               
                                                    $dr_total_price+=$item->adjust_line_total_price;
                                                    $dr_total_tax+=$item->adjust_tax_amount;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6"> </td>

                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right">Gross Total:</td>
                                                <td align="right"><?php echo number_format($gross_total,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right">Discount:</td>
                                                <td align="right"><?php echo number_format($discounts,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right">Total Before Tax:</td>
                                                <td align="right"><?php echo number_format($adjustment_info->total_before_tax,2); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right">Tax Amount:</td>
                                                <td align="right"><?php echo number_format($adjustment_info->total_tax_amount,2); ?></td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td colspan="4" align="right"><strong>Total Amount:</strong></td>
                                                <td align="right"><strong><?php echo number_format($adjustment_info->total_after_tax,2); ?></strong></td>
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
