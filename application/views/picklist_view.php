<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->

<head>
    <meta charset="utf-8">
    <title>JCORE - <?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">
    <?php echo $_def_css_files; ?>
    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">
    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">
    <style>
        #tbl_items td,
        #tbl_items tr,
        #tbl_items th {
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }

        .toolbar {
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table {
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        .select2-container {
            min-width: 100%;
        }

        .dropdown-menu>.active>a,
        .dropdown-menu>.active>a:hover {
            background-color: dodgerblue;
        }

        @keyframes spin {
            from {
                transform: scale(1) rotate(0deg);
            }

            to {
                transform: scale(1) rotate(360deg);
            }
        }

        @-webkit-keyframes spin2 {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        .custom_frame {
            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        @media screen and (max-width: 480px) {
            table {
                min-width: 800px;
            }

            .dataTables_filter {
                min-width: 800px;
            }

            .dataTables_info {
                min-width: 800px;
            }

            .dataTables_paginate {
                float: left;
                width: 100%;
            }
        }

        .numeric {
            text-align: right;
            width: 60%;
        }

        #btn_new {
            text-transform: capitalize !important;
        }

        .modal-body {
            text-transform: bold;
        }

        .boldlabel {
            font-weight: bold;
        }

        .inlinecustomlabel {
            font-weight: bold;
        }

        .form-group {
            padding-bottom: 3px;
        }

        #is_tax_exempt {
            width: 23px;
            height: 23px;
        }

        /*.modal-body {
            padding-left:0px !important;
        }*/
        #label {
            text-align: left;
        }

        .form-group {
            padding: 0;
            margin: 5px;
        }

        .input-group {
            padding: 0;
            margin: 0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
        }

        #tbl_picklist_filter {
            display: none;
        }

        div.dataTables_processing {
            position: absolute !important;
            top: 0% !important;
            right: -45% !important;
            left: auto !important;
            width: 100% !important;
            height: 40px !important;
            background: none !important;
            background-color: transparent !important;
        }

        button[name="copy_item"] {
            font-size: 15px !important;
            padding-top: 4px !important;
            padding-right: 7px !important;
            padding-bottom: 4px !important;
            padding-left: 7px !important;
            margin-right: 5px;
        }

        button[name="search_item"] {
            font-size: 15px !important;
            padding-top: 4px !important;
            padding-right: 7px !important;
            padding-bottom: 4px !important;
            padding-left: 7px !important;
            margin-right: 5px;
        }

        button[name="remove_item"] {
            font-size: 15px !important;
            padding-top: 4px !important;
            padding-right: 7px !important;
            padding-bottom: 4px !important;
            padding-left: 7px !important;
        }

        .hide-el {
            display: none !important;
        }
    </style>
</head>

<body class="animated-content" style="font-family: tahoma;">
    <?php echo $_top_navigation; ?>
    <div id="wrapper">
        <div id="layout-static">
            <?php echo $_side_bar_navigation;
            ?>
            <div class="static-content-wrapper white-bg">
                <div class="static-content">
                    <div class="page-content">
                        <!-- #page-content -->
                        <ol class="breadcrumb" style="margin-bottom: 10px;">
                            <li><a href="Dashboard">Dashboard</a></li>
                            <li><a href="Picklist">Picklist</a></li>
                        </ol>
                        <div class="container-fluid"">
                            <div data-widget-group=" group1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="div_user_list">

                                            <div class="panel panel-default" style="border: 4px solid #2980b9;">
                                                <div class="panel-body table-responsive" style="overflow-x: hidden;">
                                                    <h2 class="h2-panel-heading">Picklist</h2>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-2"><br>
                                                            <button class="btn btn-primary <?php echo (in_array('28-1', $this->session->user_rights) ? '' : 'hidden'); ?>" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;"><i class="fa fa-plus-circle"></i> New Picklist</button>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            Salesperson :<br />
                                                            <select name="salesperson" id="salesperson" class="form-control">
                                                                <option value="-1">ALL</option>
                                                                <?php foreach ($salespersons as $salesperson) { ?>
                                                                    <option value="<?php echo $salesperson->salesperson_id; ?>"><?php echo $salesperson->fullname; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            Status :<br />
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="-1">ALL</option>
                                                                <option value="0">PENDING</option>
                                                                <option value="1">FINALIZED</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            From :<br />
                                                            <div class="input-group">
                                                                <input type="text" id="txt_start_date" name="" class="date-picker form-control" value="<?php echo date("m") . '/01/' . date("Y"); ?>">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            To :<br />
                                                            <div class="input-group">
                                                                <input type="text" id="txt_end_date" name="" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            Search :<br />
                                                            <input type="text" id="searchbox_tbl_picklist" class="form-control">
                                                        </div>
                                                    </div><br>
                                                    <table id="tbl_picklist" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead class="">
                                                            <tr>
                                                                <th>&nbsp;&nbsp;</th>
                                                                <th width="12%">Picklist #</th>
                                                                <th width="10%">Pick Date</th>
                                                                <!-- <th width="10%">Time</th> -->
                                                                <th width="12%">Sales Order #</th>
                                                                <th>Customer</th>
                                                                <!-- <th>Salesperson</th> -->
                                                                <th width="10%">Status</th>
                                                                <th width="10%" style="text-align: center;">Is Finalized?</th>
                                                                <th width="10%" style="text-align: center;">Is Canceled?</th>
                                                                <th width="15%" style="text-align: left;"><center>Action</center></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="div_user_fields" style="display: none;">
                                        <div class="panel panel-default" style="border: 4px solid #2980b9;border-radius: 8px;z-index: 1;">

                                            <div class="panel-body" style="padding-top: 0;">

                                                <div class="row" style="padding: 1%;margin-top: 0%;font-family: "Source Sans Pro", "Segoe UI", "Droid Sans", Tahoma, Arial, sans-serif">
                                                    <form id="frm_picklist" role="form" class="form-horizontal">

                                                        <h4 style="margin-bottom: 6px;"><b>PL # : <span id="span_picklist_no">PL-XXXX</span></b></h4>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;">

                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    Branch :<br />
                                                                    <select name="department" id="cbo_departments" data-error-msg="Department is required." disabled>
                                                                        <option value="0">[ Create New Branch ]</option>
                                                                        <?php foreach ($departments as $department) { ?>
                                                                            <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>

                                                                </div>

                                                                <div class="col-sm-4">
                                                                    SO # : <br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="sales_order_id" id="sales_order_id" class="form-control" style="display:none;">
                                                                        <input type="text" name="so_no" class="form-control" readonly>
                                                                        <span class="input-group-addon">
                                                                            <a href="#" id="btn_pick_so" style="text-decoration: none;color:black;"><b>...</b></a>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-2 col-sm-offset-1">
                                                                    PL # :<br />
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-code"></i>
                                                                        </span>
                                                                        <input type="text" id="txt_slip_no" name="slip_no" class="form-control" placeholder="PL-YYYYMMDD-XXX" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    Customer : <br />
                                                                    <select name="customer" id="cbo_customers" data-error-msg="Customer is required." disabled>
                                                                        <!-- <option value="0">[ Create New Customer ]</option> -->
                                                                        <?php foreach ($customers as $customer) { ?>
                                                                            <option data-address="<?php echo $customer->address; ?>" value="<?php echo $customer->customer_id; ?>"><?php echo $customer->customer_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    Sales person :<br />
                                                                    <select name="salesperson_id" id="cbo_salesperson" disabled>
                                                                        <option value="0">[ Create New Salesperson ]</option>
                                                                        <?php foreach ($salespersons as $salesperson) { ?>
                                                                            <option value="<?php echo $salesperson->salesperson_id; ?>"><?php echo $salesperson->acr_name . ' - ' . $salesperson->fullname; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-2 col-sm-offset-1">
                                                                    Pick Date : <br />
                                                                    <div class="input-group">

                                                                        <input type="text" name="date_pick" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Pick" data-error-msg="Please set the date this items are picked!" required>
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-9">
                                                                    Address :<br>
                                                                    <input class="form-control" id="txt_address" type="text" name="address" placeholder="Customer Address" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <hr>
                                                <div class="row" style="padding: 1%;">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />
                                                        <form id="frm_items">
                                                            <div class="table-responsive" style="overflow-x: hidden;">
                                                                <div class="table-responsive" style="min-height: 200px;">
                                                                    <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                                                        <thead class="">
                                                                            <tr>
                                                                                <th width="10%">Qty</th>
                                                                                <th width="10%">UM</th>
                                                                                <th width="10%">Pack Size</th>
                                                                                <th width="30%">Item</th>
                                                                                <th width="20%" style="text-align: right; display: none;">Unit Price</th>
                                                                                <th width="12%" style="text-align: right; display: none;">Discount</th>
                                                                                <th style="display: none;">T.D</th> <!-- total discount -->
                                                                                <th style="display: none;">Tax %</th>
                                                                                <th width="20%" style="text-align: right; display: none;">Total</th>
                                                                                <th class="hidden">Total Price</th>
                                                                                <th class="hidden">V.I</th>
                                                                                <th class="hidden">N.V</th>
                                                                                <td class="hidden">Item ID</td>
                                                                                <th>Batch</th>
                                                                                <th>Expiration</th>
                                                                                <th>
                                                                                    <center>Action</center>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <td colspan="8" style="height: 50px;">&nbsp;</td>
                                                                            </tr>
                                                                            <tr style="display:none;">
                                                                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount :</strong></td>
                                                                                <td align="right">
                                                                                    <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00">
                                                                                    <input id="txt_overall_discount_amount" name="total_overall_discount_amount" type="hidden" class="numeric form-control" value="0.00" readonly>
                                                                                </td>
                                                                                <td colspan="3" id="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                                                                                <td align="right" colspan="1" id="td_before_tax" color="red">0.00</td>
                                                                            </tr>
                                                                            <tr style="display:none;">
                                                                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                                                                <td align="right" colspan="2" id="td_tax" color="red">0.00</td>
                                                                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                                                                                <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <label><strong>Remarks :</strong></label><br />
                                                                <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>

                                                        <br />
                                                        <div class="row" style="display:none;">
                                                            <div class="col-lg-4 col-lg-offset-8">
                                                                <div class="table-responsive">
                                                                    <table id="tbl_picklist_summary" class="table invoice-total" style="font-family: tahoma;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Discount :</td>
                                                                                <td align="right">0.00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Total before Tax :</td>
                                                                                <td align="right">0.00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tax :</td>
                                                                                <td align="right">0.00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><strong>Total After Tax :</strong></td>
                                                                                <td align="right"><b>0.00</b></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Save Changes</button>
                                                        <button id="btn_cancel" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div>


            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog">
                <!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <!---content--->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure you want to delete this record?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes_delete" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
                        </div>
                    </div>
                    <!---content---->
                </div>
            </div>
            <!---modal-->

            <div id="modal_confirmation_finalize" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Finalize</h4>
                        </div>
                        <div class="modal-body">
                            <p id="modal-body-message">Finalizing Picklist Transaction. Are you sure you want to finalize this record? ?</p>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_yes_finalize" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->

            <div id="modal_confirmation_cancel" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>Confirm Cancel</h4>
                        </div>
                        <div class="modal-body">
                            <p id="modal-body-message">Canceling Picklist Transaction. Are you sure you want to cancel this record? ?</p>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_yes_cancel" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->


            <div id="modal_so_list" class="modal fade" tabindex="-1" role="dialog">
                <!--modal-->
                <div class="modal-dialog" style="width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Sales Order</h2>
                        </div>

                        <div class="modal-body">
                            <table id="tbl_so_list" class="table table-striped" cellspacing="0" width="100%">
                                <thead class="">
                                    <tr>
                                        <th></th>
                                        <th width="10%">SO#</th>
                                        <th>Customer</th>
                                        <th width="15%">Remarks</th>
                                        <th>Salesperson</th>
                                        <th>Order</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th width="5%">
                                            <center>Action</center>
                                        </th>
                                        <th>ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sales Order Content -->
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <!-- <button id="btn_accept" type="button" class="btn btn-green" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                            <button id="cancel_so_modal" class="btn btn-default" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                    <!---content-->
                </div>
            </div>
            <!---modal-->


            <div id="modal_search_list" class="modal fade" tabindex="-1" role="dialog">
                <!--modal-->
                <div class="modal-dialog" style="width: 90%;">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h2 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Choose Item</h2>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <table id="tbl_search_list" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
                                    <thead class="">
                                        <tr>
                                            <th>PLU</th>
                                            <th>Description</th>
                                            <th>Batch</th>
                                            <th>Expiration</th>
                                            <th>On Hand</th>
                                            <th>Projected Qty</th>
                                            <th>SRP</th>
                                            <th>Dealer</th>
                                            <th>Distributor</th>
                                            <th>Discounted</th>
                                            <th>Selling/Vet</th>
                                            <th>Cost</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sales Order Content -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button id="btn_accept" type="button" class="btn btn-green" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                            <button id="cancel_search_modal" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                    <!---content-->
                </div>
            </div>
            <!---modal-->


            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li>
                            <h6 style="margin: 0;">&copy; 2020 - JDEV OFFICE SOLUTION INC</h6>
                        </li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>

        </div>
    </div>


    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>
    <?php echo $_rights; ?>

    <script src="assets/plugins/spinner/dist/spin.min.js"></script>
    <script src="assets/plugins/spinner/dist/ladda.min.js"></script>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="assets/plugins/fullcalendar/moment.min.js"></script>
    <!-- Data picker -->
    <script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>

    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            var dt;
            var dt_so;
            var _txnMode;
            var _selectedID;
            var _selectRowObj;
            var _cboDepartments;
            var _cboSalesperson;
            var _cboCustomers;
            var _cboStatus;
            var _cboSalespersons;

            var oTableItems = {
                qty : 'td:eq(0)',
                unit_name : 'td:eq(1)',
                size : 'td:eq(2)',
                product_desc : 'td:eq(3)',
                so_price : 'td:eq(4)',
                discount : 'td:eq(5)',
                total_line_discount : 'td:eq(6)',
                tax : 'td:eq(7)',
                gross : 'td:eq(8)', //Gross
                total : 'td:eq(9)', //Total
                vat_input : 'td:eq(10)',
                net_vat : 'td:eq(11)', //Before Tax
                product_id: 'td:eq(12)',
                batch_no: 'td:eq(13)',
                exp_date: 'td:eq(14)',
                srp_cost: 'td:eq(15)'
            };

            var oTableSearch = {
                sBatch: 'td:eq(2)',
                sExpDate: 'td:eq(3)',
                sCost: 'td:eq(11)',
            };

            var oTableDetails = {
                discount: 'tr:eq(0) > td:eq(1)',
                before_tax: 'tr:eq(1) > td:eq(1)',
                so_tax_amount: 'tr:eq(2) > td:eq(1)',
                after_tax: 'tr:eq(3) > td:eq(1)'
            };


            var initializeControls = function() {
                _cboSalespersons = $("#salesperson").select2({
                    placeholder: "Please select salesperson.",
                    allowClear: false
                });

                _cboSalespersons.select2('val', -1);

                _cboStatus = $("#status").select2({
                    placeholder: "Please select status.",
                    allowClear: false
                });

                _cboStatus.select2('val', -1);

                dt = $('#tbl_picklist').DataTable({
                    "dom": '<"toolbar">frtip',
                    "bLengthChange": false,
                    "pageLength": 15,
                    "order": [
                        [9, "desc"]
                    ],
                    oLanguage: {
                        sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                    },
                    processing: true,
                    "ajax": {
                        "url": "Picklist/transaction/list",

                        "bDestroy": true,
                        "data": function(d) {
                            return $.extend({}, d, {
                                "tsd": $('#txt_start_date').val(),
                                "ted": $('#txt_end_date').val(),
                                "salesperson_id": _cboSalespersons.select2('val'),
                                "status": _cboStatus.select2('val')
                            });
                        }
                    },
                    "columns": [{
                            "targets": [0],
                            "class": "details-control",
                            "orderable": false,
                            "data": null,
                            "defaultContent": ""
                        },
                        {
                            targets: [1],
                            data: "picklist_no"
                        },
                        {
                            targets: [2],
                            data: "date_pick"
                        },
                        // {
                        //     targets: [3],
                        //     data: "time_created"
                        // },
                        {
                            targets: [3],
                            data: "so_no"
                        },
                        {
                            targets: [4],
                            data: "customer_name"
                        },
                        // {
                        //     targets: [6],
                        //     data: "salesperson"
                        // },
                        {
                            targets: [5],
                            data: "order_status"
                        },
                        { targets:[6],data: null,
                            render: function (data, type, full, meta){
                                var _attribute='';
                                if(data.is_finalized=="1"){
                                    _attribute=' class="fa fa-check-circle" style="color:green;" ';
                                }else{
                                    _attribute=' class="fa fa-times-circle" style="color:red;" ';
                                }

                                return '<center><i '+_attribute+'></i></center>';
                            }
                        },
                        { targets:[7],data: null,
                            render: function (data, type, full, meta){
                                var _attribute='';
                                if(data.is_canceled=="1"){
                                    _attribute=' class="fa fa-check-circle" style="color:green;" ';
                                }else{
                                    _attribute=' class="fa fa-times-circle" style="color:red;" ';
                                }

                                return '<center><i '+_attribute+'></i></center>';
                            }
                        },
                        {
                            targets: [8],
                            data: null,
                            render: function(data, type, full, meta) {
                                return '<center> ' + pl_finalized + "&nbsp;" + pl_btn_edit + "&nbsp;" + pl_btn_trash + "&nbsp;" + pl_cancel + ' </center>';
                            }
                        },
                        {
                            visible: false,
                            targets: [9],
                            data: "picklist_id"
                        },
                        {
                            visible: false,
                            targets: [10],
                            data: "sales_order_id"
                        }
                    ]

                });


                dt_so = $('#tbl_so_list').DataTable({
                    "bLengthChange": false,
                    "autoWidth": false,
                    "order": [
                        [9, "asc"]
                    ],
                    "ajax": "Sales_order/transaction/open",
                    "columns": [{
                            "targets": [0],
                            "class": "details-control",
                            "orderable": false,
                            "data": null,
                            "defaultContent": ""
                        },
                        {
                            targets: [1],
                            data: "so_no"
                        },
                        {
                            targets: [2],
                            data: "customer_name"
                        },
                        {
                            targets: [3],
                            data: "remarks",
                            render: $.fn.dataTable.render.ellipsis(60)
                        },
                        {
                            targets: [4],
                            data: "salesperson"
                        },
                        {
                            targets: [5],
                            data: "date_order"
                        },
                        {
                            targets: [6],
                            data: "time_created"
                        },
                        {
                            targets: [7],
                            data: "order_status"
                        },
                        {
                            targets: [8],
                            render: function(data, type, full, meta) {
                                var btn_accept = '<button class="btn btn-success btn-sm" name="accept_so"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Create Sales Invoice on SO"><i class="fa fa-check accept"></i> <span class=""></span></button>';
                                return '<center>' + btn_accept + '</center>';
                            }
                        },
                        {
                            visible: false,
                            targets: [9],
                            data: "sales_order_id"
                        },

                    ]

                });


                _cboDepartments = $("#cbo_departments").select2({
                    placeholder: "Please select branch.",
                    allowClear: false
                });

                _cboDepartments.select2('val', null);

                _cboCustomers = $("#cbo_customers").select2({
                    placeholder: "Please select customer.",
                    allowClear: true
                });

                _cboCustomers.select2('val', null);

                _cboSalesperson = $("#cbo_salesperson").select2({
                    placeholder: "Please select sales person.",
                    allowClear: true
                });

                _cboSalesperson.select2('val', null);


                $('.numeric').autoNumeric('init');

                $('.date-picker').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true

                });

                $("input#touchspin4").TouchSpin({
                    verticalbuttons: true,
                    verticalupclass: 'fa fa-fw fa-plus',
                    verticaldownclass: 'fa fa-fw fa-minus'
                });

            }();


            var bindEventHandlers = (function() {
                var detailRows = [];

                _cboSalespersons.on("select2:select", function (e) {
                    $('#tbl_picklist').DataTable().ajax.reload();
                });

                _cboStatus.on("select2:select", function (e) {
                    $('#tbl_picklist').DataTable().ajax.reload();
                });

                $("#txt_start_date,#txt_end_date").on("change", function () {
                    $('#tbl_picklist').DataTable().ajax.reload()
                });

                $("#searchbox_tbl_picklist").keyup(function(){
                    dt
                        .search(this.value)
                        .draw();
                });


                $('#btn_new').click(function() {
                    _txnMode = "new";
                    _selectedID = 0;
                    clearFields($('#frm_picklist'));
                    $('#txt_overall_discount').val('0.00');
                    $('#cbo_salesperson').select2('val', null);
                    $('#cbo_customers').select2('val', null);
                    $('#cbo_departments').select2('val', null); //default_department_id
                    $('input[name="date_pick"]').datepicker('setDate', 'today');
                    showList(false);
                });

                $('#tbl_picklist tbody').on('click', 'tr td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = dt.row(tr);
                    var idx = $.inArray(tr.attr('id'), detailRows);

                    if (row.child.isShown()) {
                        tr.removeClass('details');
                        row.child.hide();

                        // Remove from the 'open' array
                        detailRows.splice(idx, 1);
                    } else {
                        tr.addClass('details');
                        //console.log(row.data());
                        var d = row.data();

                        $.ajax({
                            "dataType": "html",
                            "type": "POST",
                            "url": "Templates/layout/picklist/" + d.picklist_id + "?type=fullview",
                            "beforeSend": function() {
                                row.child('<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>').show();
                            }
                        }).done(function(response) {
                            row.child(response).show();
                            // Add to the 'open' array
                            if (idx === -1) {
                                detailRows.push(tr.attr('id'));
                            }
                        });
                    }
                });

                $('#tbl_picklist tbody').on('click','button[name="finalize_info"]',function(){
                    _selectRowObj=$(this).closest('tr');
                    var data=dt.row(_selectRowObj).data();

                    if (data.is_finalized > 0) {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "This picklist is already finalized."
                        });
                    } else {
                        _selectedID=data.picklist_id;

                        $('#modal_confirmation_finalize').modal('show');
                    }
                });

                $('#tbl_picklist tbody').on('click', 'button[name="edit_info"]', function() {
                    _txnMode = "edit";

                    _selectRowObj = $(this).closest('tr');
                    var data = dt.row(_selectRowObj).data();

                    // if (data.picklist_status_id != '1') {
                    //     showNotification({
                    //         title: "Invalid",
                    //         stat: "error",
                    //         msg: "Only Open Sales can be Edited."
                    //     });
                    if (data.is_finalized > 0) {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "This picklist is already finalized. You are not allowed to modify it."
                        });
                    } else {
                        _selectedID = data.picklist_id;

                        $('textarea[name="remarks"]').val(data.remarks);

                        $('input,textarea').each(function() {
                            var _elem = $(this);
                            $.each(data, function(name, value) {
                                if (_elem.attr('name') == name && _elem.attr('type') != 'password') {
                                    _elem.val(value);
                                }
                            });
                        });

                        $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(), 2));
                        $('#cbo_departments').select2('val', data.department_id);
                        $('#cbo_customers').select2('val', data.customer_id);
                        $('#cbo_salesperson').select2('val', data.salesperson_id);
                        $('#txt_address').val(data.address);
                        $('#txt_slip_no').val(data.picklist_no);
                        $('#span_picklist_no').html(data.picklist_no);


                        $.ajax({
                            url: 'Picklist/transaction/items/' + data.picklist_id,
                            type: "GET",
                            cache: false,
                            dataType: 'json',
                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                            },
                            success: function(response) {
                                var rows = response.data;
                                $('#tbl_items > tbody').html('');

                                $.each(rows, function(i, value) {

                                    $('#tbl_items > tbody').append(newRowItem({
                                        so_qty: value.so_qty,
                                        product_code: value.product_code,
                                        unit_id: value.unit_id,
                                        unit_name: value.unit_name,
                                        size: value.size,
                                        product_id: value.product_id,
                                        product_desc: value.product_desc,
                                        so_line_total_discount: value.so_line_total_discount,
                                        tax_exempt: false,
                                        so_tax_rate: value.so_tax_rate,
                                        so_price: value.so_price,
                                        so_discount: value.so_discount,
                                        tax_type_id: null,
                                        so_line_total_gross: (value.so_price * value.so_qty),
                                        so_line_total_price: value.so_line_total_price,
                                        so_non_tax_amount: value.so_non_tax_amount,
                                        so_tax_amount: value.so_tax_amount,
                                        batch_no: value.batch_no,
                                        exp_date: value.exp_date,
                                        srp_cost: value.srp_cost
                                    }));
                                });

                                reComputeTotal();
                            }
                        });

                        showList(false);
                    } // END OF IF ELSE
                });

                $('#tbl_picklist tbody').on('click', 'button[name="remove_info"]', function() {
                    _selectRowObj = $(this).closest('tr');
                    var data = dt.row(_selectRowObj).data();

                    // if (data.picklist_status_id != '1') {
                    //     showNotification({
                    //         title: "Invalid",
                    //         stat: "error",
                    //         msg: "Only Open Sales can be Deleted."
                    //     });
                    if (data.is_finalized > 0) {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "This picklist is already finalized. You are not allowed to delete it."
                        });
                    } else {
                        _selectedID = data.picklist_id;

                        $('#modal_confirmation').modal('show');
                    }
                });

                $('#tbl_picklist tbody').on('click','button[name="cancel_info"]',function(){
                    _selectRowObj=$(this).closest('tr');
                    var data=dt.row(_selectRowObj).data();

                    if(data.is_canceled == 1)
                    {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "This picklist has already been canceled."
                        });

                        return
                    }

                    if (data.is_finalized == 1 && data.picklist_status_id == 1) {
                        _selectedID=data.picklist_id;

                        $('#modal_confirmation_cancel').modal('show');
                    } else {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "Only finalized open picklist can be canceled."
                        });
                    }
                });


                $('#btn_pick_so').click(function() {
                    $('#tbl_so_list tbody').html('<tr><td colspan="8"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
                    dt_so.ajax.reload(null, false);
                    $('#modal_so_list').modal('show');
                });

                $('#cancel_so_modal').on('click', function() {
                    $('#modal_so_list').modal('hide');
                });

                $('#cancel_search_modal').on('click', function() {
                    $('#modal_search_list').modal('hide');
                });

                $('#tbl_so_list tbody').on('click', 'tr td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = dt_so.row(tr);
                    var idx = $.inArray(tr.attr('id'), detailRows);

                    if (row.child.isShown()) {
                        tr.removeClass('details');
                        row.child.hide();

                        // Remove from the 'open' array
                        detailRows.splice(idx, 1);
                    } else {
                        tr.addClass('details');
                        //console.log(row.data());
                        _selectRowObj = $(this).closest('tr');
                        var d = dt_so.row(_selectRowObj).data();

                        $.ajax({
                            "dataType": "html",
                            "type": "POST",
                            "url": "Templates/layout/sales-order/" + d.sales_order_id + '/contentview',
                            "beforeSend": function() {
                                row.child('<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>').show();
                            }
                        }).done(function(response) {
                            row.child(response).show();
                            // Add to the 'open' array
                            if (idx === -1) {
                                detailRows.push(tr.attr('id'));
                            }
                        });


                    }
                });

                $('#tbl_so_list > tbody').on('click', 'button[name="accept_so"]', function() {
                    _selectRowObj = $(this).closest('tr');
                    var data = dt_so.row(_selectRowObj).data();
                    btn = $(this);

                    $('input,textarea').each(function() {
                        var _elem = $(this);
                        $.each(data, function(name, value) {
                            if (_elem.attr('name') == name && _elem.attr('type') != 'password') {
                                _elem.val(value);
                            }

                        });

                        $('#cbo_customers').select2('val', data.customer_id);
                        $('#cbo_departments').select2('val', data.department_id);
                        $('#cbo_salesperson').select2('val', data.salesperson_id);
                        $('#txt_address').val(data.address);

                    });

                    const vsales_order_id = $("#sales_order_id").val()
                    const vpicklist_id = _selectedID > 0 ? _selectedID : 0
                    const params = `id_filter=${vsales_order_id}&picklist_id=${vpicklist_id}`

                    $.ajax({
                        url: 'Sales_order/transaction/item-balance?' + params,
                        type: "GET",
                        cache: false,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                            showSpinningProgress(btn);
                        },
                        success: function(response) {
                            var rows = response.data;
                            console.log(rows)
                            $('#tbl_items > tbody').html('');

                            $.each(rows, function(i, value) {
                                $('#tbl_items > tbody').append(newRowItem({
                                    so_qty : value.so_qty,
                                    product_code : value.product_code,
                                    unit_id : value.unit_id,
                                    unit_name : value.unit_name,
                                    size : value.size,
                                    product_id: value.product_id,
                                    product_desc : value.product_desc,
                                    so_line_total_discount : value.so_line_total_discount,
                                    tax_exempt : false,
                                    so_tax_rate : value.so_tax_rate,
                                    so_price : value.so_price,
                                    so_discount : value.so_discount,
                                    tax_type_id : null,
                                    so_line_total_gross : (value.so_price * value.so_qty),
                                    so_line_total_price : value.so_line_total_price,
                                    so_non_tax_amount : value.non_tax_amount,
                                    so_tax_amount : value.tax_amount,
                                    batch_no : '',
                                    exp_date : '',
                                    srp_cost : value.srp_cost
                                }));
                            });

                            $('.trigger-keyup').keyup();
                            reComputeTotal();
                            showSpinningProgress(btn);
                        }
                    });

                    $('#modal_so_list').modal('hide');
                });


                $('#txt_overall_discount').on('keypress', function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                    }
                });

                $('#txt_overall_discount').on('keyup', function() {
                    var global_discount = accounting.unformat($(this).val());

                    if (global_discount > 100) {
                        showNotification({
                            title: "Invalid",
                            stat: "error",
                            msg: "Discount must not be greater than 100%."
                        });
                        $(this).val('0.00');
                        $(this).select();
                    }

                    $('.trigger-keyup').keyup();
                    reComputeTotal();
                });

                //track every changes on numeric fields
                $('#tbl_items tbody').on('keyup', 'input.numeric,input.number', function() {
                    var row = $(this).closest('tr');

                    var price = parseFloat(accounting.unformat(row.find(oTableItems.so_price).find('input.numeric').val()));
                    var qty = parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.number').val()));
                    var tax_rate = parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val())) / 100;

                    var line_total = price * qty; //ok not included in the output (view) and not saved in the database
                    var net_vat = line_total / (1 + tax_rate);
                    var vat_input = line_total - net_vat;

                    $(oTableItems.gross, row).find('input.numeric').val(accounting.formatNumber(line_total, 2));
                    $(oTableItems.total, row).find('input.numeric').val(accounting.formatNumber(line_total, 4)); // line total amount
                    $(oTableItems.net_vat, row).find('input.numeric').val(net_vat); //net of vat
                    $(oTableItems.vat_input, row).find('input.numeric').val(vat_input); //vat input

                    reComputeTotal();
                });

                $('#tbl_items > tbody').on('click', 'button[name="copy_item"]', function() {
                    _selectRowTblItems = $(this).closest('tr');

                    var price=parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.so_price).find('input.numeric').val()));
                    var tax_rate=parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.tax).find('input.numeric').val()))/100;

                    var net_vat=price/(1+tax_rate);
                    var vat_input=price-net_vat;

                    $('#tbl_items > tbody').append(newRowItem({
                        so_qty : 1,
                        unit_name : _selectRowTblItems.find(oTableItems.unit_name).text(),
                        size : _selectRowTblItems.find(oTableItems.size).text(),
                        product_desc : _selectRowTblItems.find(oTableItems.product_desc).text(),
                        so_price : parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.so_price).find('input.numeric').val())),
                        so_discount : "0.00",
                        so_line_total_discount : "0.00",
                        so_tax_rate : parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.tax).find('input.numeric').val())),
                        so_line_total_gross : parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.so_price).find('input.numeric').val())),
                        so_line_total_price : parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.so_price).find('input.numeric').val())),
                        so_non_tax_amount: net_vat,
                        so_tax_amount : vat_input,
                        product_id : _selectRowTblItems.find(oTableItems.product_id).find('input.form-control').val(),
                        batch_no : '',
                        exp_date : '',
                        srp_cost : _selectRowTblItems.find(oTableItems.srp_cost)
                    }));
                });

                $('#tbl_items > tbody').on('click', 'button[name="search_item"]', function() {
                    _selectRowTblItems = $(this).closest('tr');
                    var global_item_desc = _selectRowTblItems.find(oTableItems.product_desc).text();
                    //console.log(global_item_desc);

                    var _data = [];
                    _data.push({
                        name: "type",
                        value: 3
                    });
                    _data.push({
                        name: "description",
                        value: global_item_desc
                    });
                    _data.push({
                        name: "depid",
                        value: _cboDepartments.val()
                    });


                    $.ajax({
                        url: 'Picklist/transaction/current-items-search',
                        "dataType": "json",
                        "type": "POST",
                        cache: false,
                        dataType: 'json',
                        "data": _data,
                        beforeSend: function() {
                            $('#tbl_search_list > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                        },
                        success: function(response) {
                            var rows = response.data;
                            if (rows.length == 0) {
                                showNotification({
                                    title: "<b style='color:white;display: inline;'>No Stocks!</b>",
                                    stat: "error",
                                    msg: "There are no stocks available for the item."
                                });
                            } else {
                                $('#tbl_search_list > tbody').html('');
                                $.each(rows, function(i, value) {
                                    $('#tbl_search_list > tbody').append('<tr class="row-item">' +
                                        '<td >' + value.product_code + '</td>' +
                                        '<td >' + value.product_desc + '</td>' +
                                        '<td >' + value.batch_no + '</td>' +
                                        '<td >' + value.exp_date + '</td>' +
                                        '<td >' + value.on_hand_per_batch + '</td>' +
                                        '<td >' + value.projected_qty + '</td>' +
                                        '<td >' + value.srp + '</td>' +
                                        '<td >' + value.srp_dealer + '</td>' +
                                        '<td >' + value.srp_distributor + '</td>' +
                                        '<td >' + value.srp_discounted + '</td>' +
                                        '<td >' + value.srp_public + '</td>' +
                                        '<td >' + value.srp_cost + '</td>' +
                                        '<td ><button type="button" name="accept_search" class="btn btn-success"><i class="fa fa-check"></i></button> </td>' +
                                        '<tr></tr>'
                                    );
                                });
                                $("#modal_search_list").modal('show');
                            }
                        }
                    });
                });

                $('#tbl_items > tbody').on('click', 'button[name="remove_item"]', function() {
                    $(this).closest('tr').remove();
                    reComputeTotal();

                    // _selectRowTblItems = $(this).closest('tr');

                    // var product_id = _selectRowTblItems.find(oTableItems.product_id).find('input.form-control').val()
                    // var product_desc = _selectRowTblItems.find(oTableItems.product_desc).text();
                    // var price = parseFloat(accounting.unformat(_selectRowTblItems.find(oTableItems.srp_cost).find('input.numeric').val()));

                    console.log(price)
                });

                $('#tbl_search_list > tbody').on('click', 'button[name="accept_search"]', function() {
                    var row = $(this).closest('tr');
                    _selectRowTblItems.find(oTableItems.batch_no).find('input').val(row.find(oTableSearch.sBatch).text());
                    _selectRowTblItems.find(oTableItems.exp_date).find('input').val(row.find(oTableSearch.sExpDate).text());
                    _selectRowTblItems.find(oTableItems.srp_cost).find('input').val(row.find(oTableSearch.sCost).text());

                    $('#modal_search_list').modal('hide');
                });


                $('#btn_yes_delete').click(function() {
                    removePicklist().done(function(response) {
                        showNotification(response);
                        if (response.stat == "success") {
                            dt.row(_selectRowObj).remove().draw();
                        }
                    });
                });

                $('#btn_yes_finalize').click(function(){
                    finalizePicklist().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row(_selectRowObj).data(response.row_finalize[0]).draw();
                        }
                    });
                });

                $('#btn_yes_cancel').click(function(){
                    cancelPicklist().done(function(response){
                        showNotification(response);
                        if(response.stat=="success"){
                            dt.row(_selectRowObj).data(response.row_cancel[0]).draw();
                        }
                    });
                });


                $('#btn_save').click(async function() {
                    if (await validateRequiredFields($('#frm_picklist'))) {
                        if (_txnMode == "new") {
                            createPicklist().done(function(response) {
                                showNotification(response);
                                if (response.stat == "success") {
                                    dt.row.add(response.row_added[0]).draw();
                                    clearFields($('#frm_picklist'));
                                    showList(true);
                                }

                                if (response.current_row_index != undefined) {
                                    var rowObj = $('#tbl_items > tbody tr:eq(' + response.current_row_index + ')');
                                    rowHighlight(rowObj);
                                }
                            }).always(function() {
                                showSpinningProgress($('#btn_save'));
                            });
                        } else {
                            updatePicklist().done(function(response) {
                                showNotification(response);
                                if (response.stat == "success") {
                                    dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                                    clearFields($('#frm_picklist'));
                                    showList(true);
                                }

                                if (response.current_row_index != undefined) {
                                    var rowObj = $('#tbl_items > tbody tr:eq(' + response.current_row_index + ')');
                                    rowHighlight(rowObj);
                                }
                            }).always(function() {
                                showSpinningProgress($('#btn_save'));
                            });
                        }
                    }
                });

                $('#btn_cancel').click(function() {
                    showList(true);
                });

            })();

            var validateRequiredFields = async function(f){
                var stat=true;
                var rows=$('#tbl_items > tbody tr');
                var rowObj = $('#tbl_items > tbody tr');
                rowHighlight(rowObj, false);


                $('div.form-group').removeClass('has-error');
                $('input[required],textarea[required],select[required]',f).each(function(){

                    if($(this).is('select')){
                        if($(this).select2('val')==0||$(this).select2('val')==null){
                            showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                            $(this).closest('div.form-group').addClass('has-error');
                            $(this).focus();
                            stat=false;
                            return false;
                        }
                    }else{
                        if($(this).val()==""){
                            showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                            $(this).closest('div.form-group').addClass('has-error');
                            $(this).focus();
                            stat=false;
                            return false;
                        }
                    }
                });

                const vsales_order_id = $("#sales_order_id").val()
                const vpicklist_id = _selectedID > 0 ? _selectedID : 0
                const params = `id_filter=${vsales_order_id}&picklist_id=${vpicklist_id}`

                await $.ajax({
                    url: 'Sales_order/transaction/item-balance?' + params,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        var rows_so = response.data;

                        try {
                            $.each(rows_so, function(i, value) {
                                var total_qty = 0;
                                var total_qty_free = 0;

                                $.each(rows,function(){
                                    var self = $(this);
                                    const product_id = accounting.unformat($(oTableItems.product_id,self).find('input.form-control').val())
                                    const line_qty = accounting.unformat($(oTableItems.qty,self).find('input.form-control').val())
                                    const line_price = accounting.unformat($(oTableItems.so_price,self).find('input.form-control').val())

                                    if(value.product_id == product_id) {
                                        if(line_price == 0) {
                                            total_qty_free = total_qty_free + line_qty;
                                        }
                                        else {
                                            total_qty = total_qty + line_qty;
                                        }
                                    }
                                });

                                if(value.so_price == 0){
                                    if(value.so_qty < total_qty_free)
                                    {
                                        throw "Exit Error"
                                    }
                                }
                                else{
                                    if(value.so_qty < total_qty)
                                    {
                                        throw "Exit Error"
                                    }
                                }
                            });
                        }
                        catch(e)
                        {
                            stat = false;
                            showNotification({title:"Warning!",stat:"warning",msg: 'Atleast 1 product has a greater qty than the SO qty.' });
                        }
                    }
                });

                //console.log(stat);
                return stat;
            };

            var createPicklist = function() {
                var _data = $('#frm_picklist,#frm_items').serializeArray();

                var tbl_summary = $('#tbl_picklist_summary');

                _data.push({
                    name: "department",
                    value:$("#cbo_departments").val()
                });
                _data.push({
                    name: "customer",
                    value:$("#cbo_customers").val()
                });
                _data.push({
                    name: "salesperson_id",
                    value:$("#cbo_salesperson").val()
                });
                _data.push({
                    name: "remarks",
                    value: $('textarea[name="remarks"]').val()
                });
                _data.push({
                    name: "summary_discount",
                    value: tbl_summary.find(oTableDetails.discount).text()
                });
                _data.push({
                    name: "summary_before_discount",
                    value: tbl_summary.find(oTableDetails.before_tax).text()
                });
                _data.push({
                    name: "summary_tax_amount",
                    value: tbl_summary.find(oTableDetails.so_tax_amount).text()
                });
                _data.push({
                    name: "summary_after_tax",
                    value: tbl_summary.find(oTableDetails.after_tax).text()
                });

                return $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": "Picklist/transaction/create",
                    "data": _data,
                    "beforeSend": showSpinningProgress($('#btn_save'))
                });
            };

            var updatePicklist = function() {
                var _data = $('#frm_picklist,#frm_items').serializeArray();

                var tbl_summary = $('#tbl_picklist_summary');

                _data.push({
                    name: "department",
                    value:$("#cbo_departments").val()
                });
                _data.push({
                    name: "customer",
                    value:$("#cbo_customers").val()
                });
                _data.push({
                    name: "salesperson_id",
                    value:$("#cbo_salesperson").val()
                });
                _data.push({
                    name: "remarks",
                    value: $('textarea[name="remarks"]').val()
                });
                _data.push({
                    name: "summary_discount",
                    value: tbl_summary.find(oTableDetails.discount).text()
                });
                _data.push({
                    name: "summary_before_discount",
                    value: tbl_summary.find(oTableDetails.before_tax).text()
                });
                _data.push({
                    name: "summary_tax_amount",
                    value: tbl_summary.find(oTableDetails.so_tax_amount).text()
                });
                _data.push({
                    name: "summary_after_tax",
                    value: tbl_summary.find(oTableDetails.after_tax).text()
                });
                _data.push({
                    name: "picklist_id",
                    value: _selectedID
                });

                return $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": "Picklist/transaction/update",
                    "data": _data,
                    "beforeSend": showSpinningProgress($('#btn_save'))
                });
            };

            var removePicklist = function() {
                return $.ajax({
                    "dataType": "json",
                    "type": "POST",
                    "url": "Picklist/transaction/delete",
                    "data": {
                        picklist_id: _selectedID
                    }
                });
            };

            var finalizePicklist=function(){

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Picklist/transaction/finalize",
                    "data":{picklist_id : _selectedID}
                });
            };

            var cancelPicklist=function(){

                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Picklist/transaction/cancel",
                    "data":{picklist_id : _selectedID}
                });
            };


            var showList = function(b) {
                if (b) {
                    $('#div_user_list').show();
                    $('#div_user_fields').hide();
                } else {
                    $('#div_user_list').hide();
                    $('#div_user_fields').show();
                }
            };

            var showNotification = function(obj) {
                PNotify.removeAll(); //remove all notifications
                new PNotify({
                    title: obj.title,
                    text: obj.msg,
                    type: obj.stat
                });
            };

            var showSpinningProgress = function(e) {
                $(e).toggleClass('disabled');
                $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
            };

            var clearFields = function(f) {
                $('input,textarea,select', f).val('');
                $(f).find('input:first').focus();
                $('#tbl_items > tbody').html('');
                $('#cbo_departments').select2('val', null);
                $('#cbo_customers').select2('val', null);
                $('#cbo_salesperson').select2('val', null);
                $('#img_user').attr('src', 'assets/img/anonymous-icon.png');
            };

            function format(d) {
                //return
            };

            function validateNumber(event) {
                var key = window.event ? event.keyCode : event.which;

                if (event.keyCode === 8 || event.keyCode === 46 ||
                    event.keyCode === 37 || event.keyCode === 39) {
                    return true;
                } else if (key < 48 || key > 57) {
                    return false;
                } else return true;
            };

            var getFloat = function(f) {
                return parseFloat(accounting.unformat(f));
            };

            var reInitializeNumeric = function() {
                $('.numeric').autoNumeric('init', {
                    mDec: 4
                });
                $('.number').autoNumeric('init', {
                    mDec: 0
                });
            };

            var newRowItem = function(d) {
                return '<tr>'+
                '<td width="10%"><input name="so_qty[]" type="text" class="number form-control trigger-keyup" value="'+ d.so_qty+'"></td>'+
                '<td width="5%">'+ d.unit_name+'</td>'+
                '<td width="10%">'+ d.size + '</td>' + 
                '<td width="30%">'+d.product_desc+'</td>'+
                '<td width="11%" style="display: none;"><input name="so_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.so_price,4)+'" style="text-align:right;"></td>'+
                '<td width="11%" style="display: none;"><input name="so_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_discount,4)+'" style="text-align:right;"></td>'+
                '<td style="display: none;" width="11%"><input name="so_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_discount,4)+'" readonly></td>'+
                '<td width="11%" style="display: none;"><input name="so_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_tax_rate,4)+'"></td>'+
                '<td width="11%" style="display: none;" align="right"><input name="so_line_total_gross[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_gross,4)+'" readonly></td>'+
                '<td class="hidden"><input name="so_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_price,4)+'" readonly></td>'+
                '<td style="display: none;"><input name="so_tax_amount[]" type="text" class="numeric form-control" value="'+ d.so_tax_amount+'" readonly></td>'+
                '<td style="display: none;"><input name="so_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.so_non_tax_amount+'" readonly></td>'+
                '<td style="display: none;"><input name="product_id[]" type="text" class="form-control" value="'+ d.product_id+'" readonly></td>'+
                '<td><input name="batch_no[]" type="text" class="form-control" value="'+ d.batch_no+'" readonly></td>'+
                '<td><input name="exp_date[]" type="text" class="form-control" value="'+ d.exp_date+'" readonly></td>'+
                '<td width="11%" style="display: none;"><input name="srp_cost[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.srp_cost,4)+'" style="text-align:right;"></td>'+
                '<td width="15%" align="center"><button type="button" name="copy_item" class="btn btn-orange"><i class="fa fa-files-o"></i></button> <button type="button" name="search_item" class="btn btn-warning"><i class="fa fa-search"></i></button> <button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>' +
                '</tr>';
            };

            var reComputeTotal = function() {
                var rows = $('#tbl_items > tbody tr');

                var discounts = 0;
                var before_tax = 0;
                var after_tax = 0;
                var so_tax_amount = 0;
                var gross = 0;

                $.each(rows, function() {
                    //console.log($(oTableItems.net_vat,$(this)));
                    gross += parseFloat(accounting.unformat($(oTableItems.gross, $(this)).find('input.numeric').val()));
                    discounts += parseFloat(accounting.unformat($(oTableItems.total_line_discount, $(this)).find('input.numeric').val()));
                    before_tax += parseFloat(accounting.unformat($(oTableItems.net_vat, $(this)).find('input.numeric').val()));
                    so_tax_amount += parseFloat(accounting.unformat($(oTableItems.vat_input, $(this)).find('input.numeric').val()));
                    after_tax += parseFloat(accounting.unformat($(oTableItems.total, $(this)).find('input.numeric').val()));
                });

                var global_discount = (gross - discounts) * ($('#txt_overall_discount').val() / 100);

                var tbl_summary = $('#tbl_picklist_summary');
                tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts + global_discount, 4));
                tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax, 4));
                tbl_summary.find(oTableDetails.so_tax_amount).html(accounting.formatNumber(so_tax_amount, 4));
                tbl_summary.find(oTableDetails.after_tax).html('<b>' + accounting.formatNumber(after_tax, 4) + '</b>');

                $('#txt_overall_discount_amount').val(accounting.formatNumber(global_discount, 2));
                $('#td_before_tax').html(accounting.formatNumber(before_tax, 4));
                $('#td_after_tax').html(accounting.formatNumber(after_tax, 4));
                $('#td_discount').html(accounting.formatNumber(discounts + global_discount, 4));
                $('#td_tax').html(accounting.formatNumber(so_tax_amount, 4));
            };

            var rowHighlight = function(rowObj, b = true) {
                if (b) {
                    $('td:eq(0) input', rowObj).css({
                        "color": "red",
                        "border-color": "red",
                        "font-weight": "bolder"
                    });


                } else {
                    $('td:eq(0) input', rowObj).css({
                        "color": "black",
                        "border-color": "lightgray",
                        "font-weight": "normal"
                    });
                }

            };

        });
    </script>

</body>

</html>