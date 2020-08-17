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


    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">


    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">

    <!--/twitter typehead-->
    <link href="assets/plugins/twittertypehead/twitter.typehead.css" rel="stylesheet">

    <style>

        #tbl_items td,#tbl_items tr,#tbl_items th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
        }

        #tbl_transaction th{
            vertical-align: middle!important;
        }

        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        .select2-container{
            min-width: 100%;

        }

        .dropdown-menu > .active > a,.dropdown-menu > .active > a:hover{
            background-color: dodgerblue;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .custom_frame{

            border: 1px solid lightgray;
            margin: 1% 1% 1% 1%;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        .numeric{
            text-align: right;
        }



        @media screen and (max-width: 480px) {

            table{
                min-width: 800px;
            }

            .dataTables_filter{
                min-width: 800px;
            }

            .dataTables_info{
                min-width: 800px;
            }

            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }

        .boldlabel {
            font-weight: bold;
        }

        .modal-body {
            padding-left:0px !important;
        }

        .form-group {
            padding:0;
            margin:5px;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        textarea {
            resize: none;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

        #btn_lock_transactions{
            padding: 6px!important;
        }

        #tbl_transaction_filter{
            display: none;
        }
        #tbl_transaction_lock_filter{
            display: none;
        }

        div.dataTables_processing{ 
            position: absolute!important; 
            top: 0%!important; 
            right: -45%!important; 
            left: auto!important; 
            width: 100%!important; 
            height: 40px!important; 
            background: none!important; 
            background-color: transparent!important; 
        } 

        .btn {
            font-size: 15px!important;
            padding: 6px 10px!important;
        }

    </style>
</head>

<body class="animated-content"  style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
<div id="layout-static">


<?php echo $_side_bar_navigation;

?>


<div class="static-content-wrapper white-bg">


<div class="static-content">
<div class="page-content"><!-- #page-content -->

<ol class="breadcrumb" style="margin-bottom: 10px;">
    <li><a href="Dashboard">Dashboard</a> </li>
    <li><a href="Transaction_lock">Transaction Lock</a></li>
</ol>

<div class="container-fluid"">
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div id="div_user_list">
                    <div class="panel panel-default">
                        <div class="panel-body table-responsive" style="overflow-x: hidden;">
                        <h2 class="h2-panel-heading">Transaction Unlocking <small class="module_title"></small>
                            <div style="float: right;">
                                
                                <button class="btn btn-default <?php echo (in_array('20-1',$this->session->user_rights)?'':'hidden'); ?>"  id="btn_new" style="font-family: Tahoma, Georgia, Serif;"><i class="fa fa-arrow-right"></i> Go to Locking</button>
                            </div>
                        </h2><hr>
                            <div class="row">
                                <div class="col-lg-3">
                                    <br/>
                                    <button class="btn btn-warning <?php echo (in_array('20-1',$this->session->user_rights)?'':'hidden'); ?>"  id="btn_unlock_all" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;padding: 5px!important;"><i class="fa fa-unlock"></i> <span>Unlock Transaction</span></button>       
                                    <button class="btn btn-success" id="btn_refresh"><i class="fa fa-refresh"></i></button>                             
                                </div>
                                <div class="col-lg-2">
                                    Module :<br>
                                    <select id="cbo_transaction_module" name="module_id" class="form-control" style="width: 100%;">
                                        <option value="">Please select a module</option>
                                        <?php foreach($modules as $module){ ?>
                                            <option value="<?php echo $module->module_id; ?>"><?php echo $module->module; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                        From :<br />
                                        <div class="input-group">
                                            <input type="text" id="txt_start_date" name="" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
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
                                <div class="col-lg-3">
                                        Search :<br />
                                         <input type="text" id="searchbox_tbl_transaction" class="form-control">
                                </div>
                            </div><br>
                            <table id="tbl_transaction" class="table table-striped" cellspacing="0" width="100%">
                                <thead class="">
                                <tr>
                                    <th width="3%">
                                        <input type="checkbox" class="css-checkbox" name="select_all" id="select_all" style="width: 5px!important;height: 5px!important;">
                                                        <label for="select_all" class="css-label"></label>
                                    </th>
                                    <th width="5%"></th>
                                    <th width="15%">Invoice #</th>
                                    <th width="20%">Particular</th>
                                    <th width="15%">Branch</th>
                                    <th width="15%">Reference #</th>
                                    <th width="15%">Invoice Date</th>
                                    <th width="20%">Remarks</th>
                                    <th width="5%" class="align-center"><center>Action</center></th>
                                    <th class="align-center">id</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </div>

                <div id="div_lock_transaction" style="display: none;">
                    <div class="panel panel-default">
                        <div class="panel-body table-responsive" style="overflow-x: hidden;">
                        <h2 class="h2-panel-heading">Transaction Locking <small class="module_title_lock"></small>

                        <div style="float: right;">
                            <button id="btn_cancel" class="btn-default btn" style="font-family: Tahoma, Georgia, Serif;""><i class="fa fa-arrow-left"></i> Go to unlocking</button>
                        </div>

                        </h2><hr>
                            <div class="row">
                                <div class="col-lg-3"><br/>
                                    <button id="btn_lock_transactions" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  <i class="fa fa-lock"></i> Lock Transaction</button>
                                </div>
                                <div class="col-lg-2">
                                    Module :<br>
                                    <select id="cbo_transaction_module_lock" name="module_lock_id" class="form-control" style="width: 100%;">
                                        <option value="">Please select a module</option>
                                        <?php foreach($modules as $module){ ?>
                                            <option value="<?php echo $module->module_id; ?>"><?php echo $module->module; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                        From :<br />
                                        <div class="input-group">
                                            <input type="text" id="txt_start_lock_date" name="" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                                             <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                             </span>
                                        </div>
                                </div>
                                <div class="col-lg-2">
                                        To :<br />
                                        <div class="input-group">
                                            <input type="text" id="txt_end_lock_date" name="" class="date-picker form-control" value="<?php echo date("m/t/Y"); ?>">
                                             <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                             </span>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                        Search :<br />
                                         <input type="text" id="searchbox_tbl_transaction_lock" class="form-control">
                                </div>
                            </div><br>
                            <table id="tbl_transaction_lock" class="table table-striped" cellspacing="0" width="100%">
                                <thead class="">
                                <tr>
                                    <th width="5%"></th>
                                    <th width="20%">Invoice #</th>
                                    <th width="20%">Particular</th>
                                    <th width="15%">Branch</th>
                                    <th width="15%">Reference #</th>
                                    <th width="15%">Invoice Date</th>
                                    <th width="20%">Remarks</th>
                                    <th class="align-center">id</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">           
                        </div>
                    </div>
                </div>

                <div id="div_user_fields" style="display: none;">
                    <div class="panel panel-default" style="border: 4px solid #2980b9;border-radius: 8px;z-index: 1;">

                            <div class="panel-body"  style="padding-bottom: 0%;padding-top: 0%;">

                                <div class="row" style="padding: 1%;margin-top: 0%;font-family: "Source Sans Pro", "Segoe UI", "Droid Sans", Tahoma, Arial, sans-serif">
                                    <form id="frm_purchases" role="form" class="form-horizontal">
                                        <h4 style="margin-bottom: 6px;"><b>PO # : <span id="span_po_no">PO-XXXX</span></b></h4>
                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;">
                                            <div class="row">
                                                <div class="col-sm-5" >
                                                    Branch * : <br />
                                                    <select name="department" id="cbo_departments"  data-error-msg="Branch is required." required>
                                                        <option value="0">[ Create New Branch ]</option>
                                                        <?php foreach($departments as $department){ ?>
                                                            <option value="<?php echo $department->department_id; ?>" data-default-cost="<?php echo $department->default_cost; ?>" data-delivery-address="<?php echo $department->delivery_address;  ?>"><?php echo $department->department_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>


                                                <div class="col-sm-3 col-sm-offset-3">
                                                    PO # : <br />
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-code"></i>
                                                        </span>
                                                        <input type="text" name="po_no" class="form-control" placeholder="PO-YYYYMMDD-XXX" readonly>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Supplier * : <br />
                                                    <select name="supplier" id="cbo_suppliers" data-error-msg="Supplier is required." required>
                                                        <option value="0">[ Create New Supplier ]</option>
                                                        <?php foreach($suppliers as $supplier){ ?>
                                                            <option value="<?php echo $supplier->supplier_id; ?>" data-tax-type="<?php echo $supplier->tax_type_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-sm-4 col-sm-offset-3">

                                                    Contact Person : <br />
                                                    <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-users"></i>
                                                                </span>
                                                        <input type="text" name="contact_person" class="form-control" placeholder="Contact Person">
                                                    </div>

                                                    <div style="display: none;">
                                                    Tax type : <br />
                                                    <select name="tax_type" id="cbo_tax_type">
                                                        <?php foreach($tax_types as $tax_type){ ?>
                                                            <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                                                        <?php } ?>
                                                    </select></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <input type="checkbox" id="cb_deliver_address" style=""> <label for="cb_deliver_address" style="font-weight: normal!important;">Deliver to Address * :</label> <br />
                                                    <textarea name="deliver_to_address" class="form-control" placeholder="Deliver to Address" data-error-msg="Deliver address is required!" required readonly></textarea>

                                                </div>

                                                <div class="col-sm-4 col-sm-offset-3">
                                                    Terms : <br />
                                                    <input type="text" name="terms" class="form-control">
                                                </div>
                                            </div>


                                        </div>

                                    </form>

                            </div>


                                <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;"><br />

                                    <label style="font-family: Tahoma;">Please select product type first :</label>
                                    <div style="padding: 0%;">
                                        <select name="producttype" id="cbo_prodType" data-error-msg="Product Type is required." required>
                                            <?php foreach($refproducts as $refproduct){ ?>
                                                <option value="<?php echo $refproduct->refproduct_id; ?>"><?php echo $refproduct->product_type; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>


                                    <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
                                    <div id="custom-templates">
                                        <input class="typeahead" type="text" placeholder="Enter PLU or Search Item">
                                    </div><br />

                                    <form id="frm_items">
                                        <div class="table-responsive">
                                            <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                                <thead class="">
                                                <tr>
                                                    <th width="10%">Qty</th>
                                                    <th width="10%">UM</th>
                                                    <th width="30%">Item</th>
                                                    <th width="20%" style="text-align: right;">Unit Price</th>
                                                    <th width="12%" style="text-align: right; display: none;">Discount</th>
                                                    <th style="display: none;">T.D</th> <!-- total discount -->
                                                    <th style="display: none;">Tax %</th>
                                                    <th width="20%" style="text-align: right;">Total</th>
                                                    <th style="display: none;">V.I</th> <!-- vat input -->
                                                    <th style="display: none;">N.V</th> <!-- net of vat -->
                                                    <td style="display: none;">Item ID</td><!-- product id -->
                                                    <th><center>Action</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6" style="height: 50px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount :</strong></td>
                                                        <td align="right" colspan="1" id="td_discount color="red">0.00</td>
                                                        <td colspan="2" id="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                                                        <td align="right" colspan="1" id="td_before_tax" color="red">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                                        <td align="right" colspan="1" id="td_tax" color="red">0.00</td>
                                                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                                                        <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                                                    </tr>
                                                </tfoot>


                                            </table>
                                        </div>


                                </div>


                                <br />
                                <div class="row ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label control-label><strong>Remarks :</strong></label>
                                        <div class="col-lg-12" style="padding: 0%;">
                                              <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea>
                                        </div>




                                        <div class="row" style="display: none;">
                                            <div class="col-lg-4 col-lg-offset-8">
                                                <div class="table-responsive">
                                                    <table id="tbl_purchase_summary" class="table invoice-total" style="font-family: tahoma;">
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

                                    </form>


                                <br />
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span>  Save Changes</button>
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


<div id="modal_confirmation_transaction" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span><i class="fa fa-unlock"></i> Confirm Unlock</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to unlock the selected transactions?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_confirmation_unlock" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content-->
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span><i class="fa fa-unlock"></i> Confirm Unlock</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to unlock this transaction?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes_unlock" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_confirmation_lock" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content"><!---content-->
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span><i class="fa fa-lock"></i> Confirm Lock Transactions</h4>
            </div>
            <div class="modal-body">
                <p id="modal-body-message">Are you sure you want to lock this transactions? <br/>
                <strong style="color:red">Warning : <em>Invoices will no longer be available for update and delete.</em></strong></p>
            </div>
            <div class="modal-footer">
                <button id="btn_yes_lock" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_new_supplier" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>New Supplier</h4>

            </div>

            <div class="modal-body" style="overflow:hidden;">
                <form id="frm_suppliers_new">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Company Name :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="supplier_name" class="form-control" placeholder="Supplier Name" data-error-msg="Supplier Name is required!" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Contact Person :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="contact_name" class="form-control" placeholder="Contact Person" data-error-msg="Contact Person is required!" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                         </span>
                                         <textarea name="address" class="form-control" data-error-msg="Supplier address is required!" placeholder="Address" required ></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Email Address :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                        <input type="text" name="email_address" class="form-control" placeholder="Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Landline :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input type="text" name="landline" id="landline" class="form-control" placeholder="Landline">
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">Mobile No :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-mobile"></i>
                                        </span>
                                        <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No">
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;">TIN # :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-code"></i>
                                        </span>
                                        <input type="text" name="tin_no" class="form-control" placeholder="TIN #">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                     <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Tax :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-code"></i>
                                        </span>
                                        <select name="tax_type_id" id="cbo_tax_group">
                                            <option value="">Please select tax type...</option>
                                            <?php foreach($tax_types as $tax_type){ ?>
                                                <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <label class="control-label boldlabel" style="text-align:left;padding-top:10px;"><i class="fa fa-user" aria-hidden="true" style="padding-right:10px;"></i>Supplier's Photo</label>
                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                    </div>
                                    <div style="width:100%;height:300px;border:2px solid #34495e;border-radius:5px;">
                                        <center>
                                            <img name="img_user" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;"></img>
                                        </center>
                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                        <center>
                                             <button type="button" id="btn_browse" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                             <button type="button" id="btn_remove_photo" style="width:150px;" class="btn btn-danger">Remove</button>
                                             <input type="file" name="file_upload[]" class="hidden">
                                        </center> 
                                    </div>
                                </div>   
                            </div>
                        </div>
                    
                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_new_supplier" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_new_supplier" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->


<div id="modal_purchase_order" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header " style="padding: 5px !important;">
                <h2 style="color:white; padding-left: 10px;">Purchase Order</h2>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="overflow: scroll; width: 100%;">
                    <div id="purchase_order">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2020 - JDEV OFFICE SOLUTION INC</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>




</div>
</div>


</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>
<?php echo $_rights; ?>



<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>




<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>



<!-- twitter typehead -->
<script src="assets/plugins/twittertypehead/handlebars.js"></script>
<script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
<script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>


<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script type="text/javascript"></script>
    

<script>




$(document).ready(function(){
    var dt; var dt_lock; var _txnMode; var _selectedID; var _selectRowObj; var _cboSuppliers; var _cboTaxType;
    var _productType; var _cboDepartments; var _defCostType; var _cboTransactionModule; var _cboTransactionLockModule;


    _defCostType=1; //Luzon Area Purchase Cost is default, this will change when branch is specified

    var oTableItems={
        qty : 'td:eq(0)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        total : 'td:eq(7)',
        vat_input : 'td:eq(8)',
        net_vat : 'td:eq(9)'

    };


    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };


    var initializeControls=function(){

        _cboTransactionModule = $('#cbo_transaction_module').select2({
            placeholder: "Please select a Module.",
            allowClear: false
        });

        _cboTransactionModule.select2('val',null);    

        _cboTransactionLockModule = $('#cbo_transaction_module_lock').select2({
            placeholder: "Please select a Module.",
            allowClear: false
        });

        _cboTransactionLockModule.select2('val',null);                

        dt=$('#tbl_transaction').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 9, "desc" ]],
            "bPaginate": false,
            oLanguage: {
                    sProcessing: '<br /><img src="assets/img/loader/ajax-loader-sm.gif" style="margin-right: 230px;" /><br /><br />'
            },
            processing : true,
            "ajax" : {
                "url" : "Transaction_lock/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "module_id":$('#cbo_transaction_module').val(),
                            "tsd":$('#txt_start_date').val(),
                            "ted":$('#txt_end_date').val(),
                            "is_locked":1
                        });
                    }
            }, 
            "columns": [
                { sClass:"align-center",
                    targets:[0],data: null,"orderable": false,
                    render: function (data, type, full, meta){
                        var checkbox='<input type="checkbox" class="css-checkbox trans_chckbx" name="invoice_id[]" value="'+data.invoice_id+'" id="'+data.invoice_id+'"><label for="'+data.invoice_id+'" class="css-label "></label> ';
                        return '<center>'+checkbox+'</center>';
                    }
                },
                {
                    "targets": [1],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[2],data: "invoice_no" },
                { targets:[3],data: "particular" },
                { targets:[4],data: "branch" },
                { targets:[5],data: "reference_no" },
                { targets:[6],data: "invoice_date" },
                { targets:[7],data: "remarks",  render: $.fn.dataTable.render.ellipsis(35) },
                { sClass:"align-center",
                    targets:[8],
                    render: function (data, type, full, meta){
                        return '<center>'+btn_lock+'</center>';
                    }
                },
                { visible:false, targets:[9],data: "invoice_id" },
            ]
        });


        dt_lock=$('#tbl_transaction_lock').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 7, "desc" ]],         
            oLanguage: {
                    sProcessing: '<br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br />'
            },
            processing : true,
            "ajax" : {
                "url" : "Transaction_lock/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "module_id":$('#cbo_transaction_module_lock').val(),
                            "tsd":$('#txt_start_lock_date').val(),
                            "ted":$('#txt_end_lock_date').val(),
                            "is_locked":0
                        });
                    }
            }, 
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "invoice_no" },
                { targets:[2],data: "particular",  render: $.fn.dataTable.render.ellipsis(35) },
                { targets:[3],data: "branch" },
                { targets:[4],data: "reference_no" },
                { targets:[5],data: "invoice_date" },
                { targets:[6],data: "remarks",  render: $.fn.dataTable.render.ellipsis(35) },
                { visible:false, targets:[7],data: "invoice_id" },
            ]
        });


        $('.numeric').autoNumeric('init');

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        _cboSuppliers=$('#cbo_suppliers').select2({
            placeholder: "Please select supplier first to filter product lookup.",
            allowClear: true
        });

        _cboSuppliers.select2('val',null);


        _productType = $('#cbo_prodType').select2({
            placeholder: "Please select Product Type",
            allowClear: false
        });

        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select branch.",
            allowClear: true
        });

        _cboDepartments.select2('val',null);

        _cboTaxType=$('#cbo_tax_type').select2({
            placeholder: "Please select tax type.",
            allopwClear: true

        });

        var _cboTaxGroup=$('#cbo_tax_group').select2({
            placeholder: "Please select tax type.",
            allopwClear: true,
            dropdownParent: "#modal_new_supplier"
        });

        _cboTaxGroup.select2('val',null);


        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });


        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace(''),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                cache: false,
                url: 'Purchases/transaction/product-lookup/',

                replace: function(url, uriEncodedQuery) {
                    //var prod_type=$('#cbo_prodType').select2('val');
                    //var prod_type=$('#cbo_prodType').select2('val');
                    var sid=$('#cbo_suppliers').select2('val');
                    var prod_type=$('#cbo_prodType').select2('val');

                    return url + '?type='+prod_type+'&sid='+sid+'&description='+uriEncodedQuery;
                }
            }
        });


        var _objTypeHead=$('#custom-templates .typeahead');

        _objTypeHead.typeahead({minLength:1,hint:true}, {
                name: 'products',
                display: 'product_code',
                limit : 10000,
                source: products,
                templates: {
                    header: [
                        '<table class="tt-head"><tr>'+
                        '<td width=15%" style="padding-left: 1%;"><b>PLU</b></td>'+
                        '<td width="45%" align="left"><b>Description 1</b></td>'+
                        '<td width="10%" align="left"><b>Description 2</b></td>'+
                        '<td width="15%" align="right"><b>On hand</b></td>'+
                        '<td width="15%" align="right" style="padding-right: 1%;"><b>Cost</b></td>'+
                        '</tr></table>'
                    ].join('\n'),

                    suggestion: Handlebars.compile('<table class="tt-items">'+
                        '<tr>'+
                        '<td width="15%" style="padding-left: 1%">{{product_code}}</td>'+
                        '<td width="45%" align="left">{{product_desc}}</td>'+
                        '<td width="10%" align="left">{{produdct_desc1}}</td>'+
                        '<td width="15%" align="right">{{on_hand}}</td>'+
                        '<td width="15%" align="right" style="padding-right: 1%;">{{cost}}</td>'+
                        '</tr></table>')

                }
            }).on('keyup', this, function (event) {
                if (_objTypeHead.typeahead('val') == '')
                    return false;
                if (event.keyCode == 13) {
                    //$('.tt-suggestion:first').click();
                    _objTypeHead.typeahead('close');
                    _objTypeHead.typeahead('val','');
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                //if(_objTypeHead.typeahead('val')==''){ return false; }
                //console.log(suggestion);

                //var tax_id=$('#cbo_tax_type').select2('val');
                //var tax_rate=parseFloat($('#cbo_tax_type').find('option[value="'+tax_id+'"]').data('tax-rate'));

                var tax_rate=suggestion.tax_rate; //base on the tax rate set to current product

                //choose what purchase cost to be use
                var purchase_cost=0.00;
                if(_defCostType==2){ //Viz-Min Area purchase cost
                    purchase_cost=suggestion.purchase_cost_2;
                    //Notify the User that Purchase Cost will be based on Viz-Min Area
                    showNotification({
                        title:"Information!",
                        stat:"info",
                        msg:"Purchase cost will be based on Viz-Min Area Purchase Cost!"
                    });
                }else{ //Luzon Area Purchase Cost
                    purchase_cost=suggestion.purchase_cost;
                }


                var total=getFloat(purchase_cost);
                var net_vat=0;
                var vat_input=0;


                if(suggestion.is_tax_exempt=="0"){ //this is not excempted to tax
                    net_vat=total/(1+(getFloat(tax_rate)/100));
                    vat_input=total-net_vat;
                }else{
                    tax_rate=0;
                    net_vat=total;
                    vat_input=0;

                    //if(tax_id!="1"){ //if supplier is taxable, notify the user that this item is tax excempt
                        //showNotification({title:"Tax Excempt!",stat:"info",msg:"This item is tax excempt."});
                    //}

                }


                $('#tbl_items > tbody').append(newRowItem({
                    po_qty : "1",
                    product_code : suggestion.product_code,
                    unit_id : suggestion.unit_id,
                    unit_name : suggestion.unit_name,
                    product_id: suggestion.product_id,
                    product_desc : suggestion.product_desc,
                    po_line_total_discount : "0.00",
                    tax_exempt : false,
                    po_tax_rate : tax_rate,
                    po_price : purchase_cost,
                    po_discount : "0.00",
                    tax_type_id : null,
                    po_line_total : total,
                    po_non_tax_amount: net_vat,
                    po_tax_amount:vat_input
                }));


                reInitializeNumeric();
                reComputeTotal();


            });

            $('div.tt-menu').on('click','table.tt-suggestion',function(){
                _objTypeHead.typeahead('val','');
            });

            $("input#touchspin4").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'fa fa-fw fa-plus',
                verticaldownclass: 'fa fa-fw fa-minus'
            });


    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#cb_deliver_address').change(function(){
            if($(this).prop("checked") == true){
                $('textarea[name="deliver_to_address"]').attr("readonly", false); 
            }else{
                $('textarea[name="deliver_to_address"]').attr("readonly", true);
            }
        });

        $('#tbl_transaction tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/transaction-invoice/"+d.invoice_id+'/'+d.type_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );

        $('#tbl_transaction_lock tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_lock.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                //console.log(row.data());
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/transaction-invoice/"+d.invoice_id+'/'+d.type_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response ).show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );        


        $("#searchbox_tbl_transaction").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#searchbox_tbl_transaction_lock").keyup(function(){         
            dt_lock
                .search(this.value)
                .draw();
        });        

        $('#select_all').on('click',function(){
            var checked = $("#select_all:checked").length;
            if (checked == 1){
                $('.trans_chckbx').prop('checked',true);
            }else{
                $('.trans_chckbx').prop('checked',false);
            }
        });

        $('#btn_lock_transactions').on('click', function(){
            var dtcount = dt_lock.column( 0 ).data().length;
            if(dtcount > 0){
                $('#modal_confirmation_lock').modal('show');
            }else{
                showNotification({title:"Invalid",stat:"error",msg:"No transaction available."});  
            }

        });

        $('#btn_unlock_all').on('click', function(){
            var result = countChecked($('#tbl_transaction'), '.trans_chckbx');

            if(result.checked > 0){
                $('#modal_confirmation_transaction').modal('show');
            }else{
                showNotification({title:"Invalid",stat:"error",msg:"Please select a transaction."});
            }

        });         

        $('#btn_refresh').on('click', function(){
            refereshTable();
        });

        $("#cbo_transaction_module,#txt_start_date,#txt_end_date").on("change", function () {  
            refereshTable();
        });

        $("#cbo_transaction_module_lock,#txt_start_lock_date,#txt_end_lock_date").on("change", function () {  
            refereshTableLock();
        });        

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#frm_transactions'));
            showList(false);
        });

        $('#tbl_transaction tbody').on('click','button[name="unlock_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.invoice_id;

            $('#modal_confirmation_unlock').modal('show');
        });

        //track every changes on numeric fields
        $('#tbl_items tbody').on('keyup','input.numeric,input.number',function(){
            var row=$(this).closest('tr');

            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.number').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val()))/100;

            if(discount>price){
                showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
                row.find(oTableItems.discount).find('input.numeric').val('0.00');
                //$(this).trigger('keyup');
                //return;
            }

            var discounted_price=price-discount;
            var line_total_discount=discount*qty;
            var line_total=discounted_price*qty;
            var net_vat=line_total/(1+tax_rate);
            var vat_input=line_total-net_vat;

            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(line_total,4)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(line_total_discount); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(net_vat); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(vat_input); //vat input

            //console.log(net_vat);
            reComputeTotal();


        });


        $('#btn_yes').click(function(){
            $('#btn_unlock_all').attr('disabled',true);
            $("#btn_unlock_all span").text('Unlocking');

            unlockTransactions(1).done(function(response){
                showNotification(response);
                $('#select_all').prop('checked', false);
                $('#tbl_transaction').DataTable().ajax.reload();
            }).always(function(){
                $("#btn_unlock_all span").text('Unlock');
                $('#btn_unlock_all').attr('disabled',false);
            });
        });


        $('#btn_yes_unlock').click(function(){
            unlockTransactions(2).done(function(response){
                showNotification(response);
                $('#tbl_transaction').DataTable().ajax.reload();
            });
        });

        $('#btn_yes_lock').click(function(){
            lockTransactions().done(function(response){
                showNotification(response);
                refereshTableLock();
            });
        });       

        $('#btn_cancel').click(function(){
            _cboTransactionLockModule.select2('val',null);                
            refereshTableLock();
            showList(true);
        });


        $('#btn_save').click(function(){

            if(validateRequiredFields($('#frm_purchases'))){
                if(_txnMode=="new"){
                    createPurchaseOrder().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_purchases'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updatePurchaseOrder().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                        clearFields($('#frm_purchases'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }

            }

        });



        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
                $(this).closest('tr').remove();
                reComputeTotal();
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
            $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
            console.log(_files);
            $.ajax({
                url : 'Suppliers/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('img[name="img_user"]').attr('src',response.path);
                }
            });
        });


    })();

    var validateRequiredFields=function(f){
        var stat=true;

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

        return stat;
    };

    var validateRequiredFields=function(f){
        var stat=true;

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

        return stat;
    };

    var countChecked = function($table, checkboxClass) {
      if ($table) {
        // Find all elements with given class
        var chkAll = $table.find(checkboxClass);
        // Count checked checkboxes
        var checked = chkAll.filter(':checked').length;
        // Count total
        var total = chkAll.length;    
        // Return an object with total and checked values
        return {
          total: total,
          checked: checked
        }
      }
    }

    var refereshTable=function(){
        $('#select_all').prop('checked',false);
        $('.module_title').html('| '+ $('#cbo_transaction_module option:selected').text());
        $('#tbl_transaction').DataTable().ajax.reload();
    }

    var refereshTableLock=function(){
        $('#select_all_lock').prop('checked',false);
        if($('#cbo_transaction_module_lock option:selected').val() != null){
            $('.module_title_lock').html('| '+ $('#cbo_transaction_module_lock option:selected').text());
        }
        $('#tbl_transaction_lock').DataTable().ajax.reload();
    }    

    var createSupplier=function() {
        var _data=$('#frm_suppliers_new').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Suppliers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_new_supplier'))
        });
    };

    var createPurchaseOrder=function(){
        var _data=$('#frm_purchases,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_purchase_summary');
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updatePurchaseOrder=function(){
        var _data=$('#frm_purchases,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_purchase_summary');
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "purchase_order_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var unlockTransactions=function(b){
        
        if(b==1){
            var _data = dt.$('input, select').serialize();
            var module_id = $('#cbo_transaction_module').val();
        }else{
            var _data=$('#').serializeArray();
            var module_id = $('#cbo_transaction_module').val();
            _data.push({name : "invoice_id[]", value : _selectedID});   
        }

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Transaction_lock/transaction/unlock/"+module_id,
            "data":_data
        });
    };

    var lockTransactions=function(){
        
        var _data=$('#').serializeArray();
        _data.push({name : "module_id", value : $('#cbo_transaction_module_lock').val()});  
        _data.push({name : "tsd", value : $('#txt_start_date').val()});
        _data.push({name : "ted", value : $('#txt_end_date').val()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Transaction_lock/transaction/lock",
            "data":_data
        });
    };    

    var removePurchaseOrder=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Purchases/transaction/delete",
            "data":{purchase_order_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_user_list').show();
            $('#div_lock_transaction').hide();
        }else{
            $('#div_user_list').hide();
            $('#div_lock_transaction').show();
        }
    };

    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };



    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
        $('#tbl_items > tbody').html('');
        $('#cbo_tax_type').select2('val',null);
        $('#cbo_suppliers').select2('val',null);
        $('#cb_deliver_address').prop("checked", false);
        $('textarea[name="deliver_to_address"]').attr("readonly", true); 
    };


    function format ( d ) {

        //return


    };

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;

        if (event.keyCode === 8 || event.keyCode === 46
            || event.keyCode === 37 || event.keyCode === 39) {
            return true;
        }
        else if ( key < 48 || key > 57 ) {
            return false;
        }
        else return true;
    };
    
    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var newRowItem=function(d){


        return '<tr>'+
                        '<td width="10%"><input name="po_qty[]" type="text" class="number form-control" value="'+ d.po_qty+'"></td>'+
                        '<td width="5%">'+ d.unit_name+'</td>'+
                        '<td width="30%">'+d.product_desc+'</td>'+
                        '<td width="11%"><input name="po_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.po_price,4)+'" style="text-align:right;"></td>'+
                        '<td width="11%" style="display:none;"><input name="po_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_discount,4)+'" style="text-align:right;"></td>'+
                        '<td style="display: none;" width="11%"><input name="po_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_line_total_discount,4)+'" readonly></td>'+
                        '<td width="11%" style="display:none;"><input name="po_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_tax_rate,4)+'"></td>'+
                        '<td width="11%" align="right"><input name="po_line_total[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.po_line_total,4)+'" readonly></td>'+
                        '<td style="display: none;"><input name="tax_amount[]" type="text" class="numeric form-control" value="'+ d.po_tax_amount+'" readonly></td>'+
                        '<td style="display: none;"><input name="non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.po_non_tax_amount+'" readonly></td>'+
                        '<td style="display: none;"><input name="product_id[]" type="text" class="form-control" value="'+ d.product_id+'" readonly></td>'+
                        '<td align="center"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
    };



    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');


        var discounts=0; var before_tax=0; var after_tax=0; var tax_amount=0;

        $.each(rows,function(){
            //console.log($(oTableItems.net_vat,$(this)));
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        });

        var tbl_summary=$('#tbl_purchase_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,4));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,4));
        tbl_summary.find(oTableDetails.tax_amount).html(accounting.formatNumber(tax_amount,4));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,4)+'</b>');


        $('#td_before_tax').html(accounting.formatNumber(before_tax,4));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,4)+'</b>');
        $('#td_discount').html(accounting.formatNumber(discounts,4));
        $('#td_tax').html(accounting.formatNumber(tax_amount,4));


    };




    _cboDepartments.on("select2:select", function (e) {

        var i=$(this).select2('val');
        var obj_department=$('#cbo_departments').find('option[value="'+i+'"]');

        _defCostType=obj_department.data('default-cost');
        $('textarea[name="deliver_to_address"]').val(obj_department.data('delivery-address'));


    });


    _cboSuppliers.on("select2:select", function (e) {

        var i=$(this).select2('val');

        if(i==0){ //new supplier
            _cboSuppliers.select2('val',null)
            $('#modal_new_supplier').modal('show');
            clearFields($('#modal_new_supplier').find('form'));
        }else{
            var obj_supplier=$('#cbo_suppliers').find('option[value="'+i+'"]');
            _cboTaxType.select2('val',obj_supplier.data('tax-type')); //set tax type base on selected Supplier
        }


    });




    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec: 4});
        $('.number').autoNumeric('init', {mDec:0});

    };








});




</script>


</body>


</html>