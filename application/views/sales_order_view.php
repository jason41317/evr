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
        #tbl_items td,#tbl_items tr,#tbl_items th{
            table-layout: fixed;
            border: 1px solid gray;
            border-collapse: collapse;
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
        .numeric{
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
            width:23px;
            height:23px;
        }
        /*.modal-body {
            padding-left:0px !important;
        }*/
        #label {
            text-align:left;
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
        #img_user {
            padding-bottom: 15px;
        }
        #tbl_sales_order_filter{
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


        .hide-el {
            display: none!important;
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
<div class="static-content"  >
<div class="page-content"><!-- #page-content -->
<ol class="breadcrumb"  style="margin-bottom: 10px;">
    <li><a href="Dashboard">Dashboard</a></li>
    <li><a href="Sales_order">Sales Order</a></li>
</ol>
<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_user_list">


    <div class="panel panel-default" style="border: 4px solid #2980b9;">
        <div class="panel-body table-responsive" style="overflow-x: hidden;">
        <h2 class="h2-panel-heading">Sales Order</h2><hr>
        <div class="row">
            <div class="col-lg-2"><br>
                <button class="btn btn-primary <?php echo (in_array('25-1',$this->session->user_rights)?'':'hidden'); ?>"  id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" ><i class="fa fa-plus-circle"></i> New Sales Order</button>
            </div>
            <div class="col-lg-2">
                Salesperson :<br />
                <select name="salesperson" id="salesperson" class="form-control">
                    <option value="-1">ALL</option>
                    <?php foreach($salespersons as $salesperson){ ?>
                        <option value="<?php echo $salesperson->salesperson_id; ?>"><?php echo $salesperson->fullname; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-2">
                Status :<br />
                <select name="status" id="status" class="form-control">
                    <option value="0">ALL</option>
                    <option value="1">OPEN</option>
                    <option value="2">CLOSED</option>
                    <option value="3">PARTIALLY RECEIVED</option>
                    <option value="4">CLOSED BY USER</option>
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
            <div class="col-lg-2">
                Search :<br />
                <input type="text" id="searchbox_tbl_sales_order" class="form-control">
            </div>
        </div><br>
            <table id="tbl_sales_order" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th>&nbsp;&nbsp;</th>
                    <th width="12%">SO #</th>
                    <th>Order Date</th>
                    <th width="10%">Time</th>
                    <th width="20%">Customer</th>
                    <th width="15%">Remarks</th>
                    <th>Salesperson</th>
                    <th width="10%">Status</th>
                    <th width="15%" style="text-align: left;">Action</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>



                </tbody>
            </table>
        </div>
    </div>

</div>


<div id="div_user_fields" style="display: none;">
    <div class="panel panel-default" style="border: 4px solid #2980b9;border-radius: 8px;z-index: 1;">
<!-- <div class="panel-heading">
    <h2>Sales Order</h2>
    <div class="panel-ctrls" data-actions-container=""></div>
</div> -->

<div class="panel-body" style="padding-top: 0;">

    <div class="row" style="padding: 1%;margin-top: 0%;font-family: "Source Sans Pro", "Segoe UI", "Droid Sans", Tahoma, Arial, sans-serif">
        <form id="frm_sales_order" role="form" class="form-horizontal">

            <h4 style="margin-bottom: 6px;"><b>SO # : <span id="span_so_no">SO-XXXX</span></b></h4>
            <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;">

                <div class="row">
                    <div class="col-sm-5">
                        Branch :<br />
                        <select name="department" id="cbo_departments" data-error-msg="Department is required." required>
                            <option value="0">[ Create New Branch ]</option>
                            <?php foreach($departments as $department){ ?>
                                <option value="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="col-sm-2 col-sm-offset-5">
                        SO # :<br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-code"></i>
                            </span>
                            <input type="text" name="slip_no" class="form-control" placeholder="SO-YYYYMMDD-XXX" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-5">
                        Customer : <br />
                        <select name="customer" id="cbo_customers" data-error-msg="Customer is required." required>
                            <!-- <option value="0">[ Create New Customer ]</option> -->
                            <?php foreach($customers as $customer){ ?>
                                <option data-address="<?php echo $customer->address; ?>" value="<?php echo $customer->customer_id; ?>"><?php echo $customer->customer_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        Sales person :<br/>
                        <select name="salesperson_id" id="cbo_salesperson">
                            <option value="0">[ Create New Salesperson ]</option>
                            <?php foreach($salespersons as $salesperson){ ?>
                                <option value="<?php echo $salesperson->salesperson_id; ?>"><?php echo $salesperson->acr_name.' - '.$salesperson->fullname; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-sm-offset-1">
                        Order Date : <br />
                        <div class="input-group">

                            <input type="text" name="date_order" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Order" data-error-msg="Please set the date this items are ordered!" required>
                                 <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                        </div>
                    </div>                
                    <div class="col-sm-9">
                        Address :<br>
                        <input class="form-control" id="txt_address" type="text" name="address" placeholder="Customer Address">
                    </div>
                </div>



            </div>

        </form>
    </div>

    <hr>
    <div class="row" style="padding: 1%;">

        <div class="row">
            <div class="col-lg-9">
                <label style="font-family: Tahoma;">Please Select Product Type first:</label>
                <div style="padding: 0%;">
                    <select name="producttype" id="cbo_prodType" data-error-msg="Product Type is required." required>
                        <?php foreach($refproducts as $refproduct){ ?>
                            <option value="<?php echo $refproduct->refproduct_id; ?>"><?php echo $refproduct->product_type; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <small><i>(Only one product type can be used for a Sales Order.)</i></small>
            </div>
            <div class="col-lg-3">
                <label style="font-family: Tahoma;">Please select Default Lookup Price :</label>
                <div style="padding: 0%;">
                    <select name="lookup_price" id="cboLookupPrice">
                        <option value="0">None</option>
                        <option value="1">SRP (Recommended)</option>
                        <!-- <option value="2" >Distributor Price</option> -->
                        <!-- <option value="3" hidden>Dealer Price</option> -->
                        <option value="4">Selling/Vet Price</option>
                        <option value="5">Discounted Price</option>
                        <!-- <option value="6">Purchase Cost</option> -->
                    </select>
                </div>
            </div>
        </div>



        <br />

        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
        <div id="custom-templates">
            <input class="typeahead" type="text" placeholder="Enter PLU or Search Item">
        </div><br />

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />


            <form id="frm_items">
                <div class="table-responsive" style="overflow-x: hidden;">
                    <div class="table-responsive"  style="min-height: 200px;">
                        <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">

                        <thead class="">
                        <tr>

                            <th width="10%">Qty</th>
                            <th width="10%">UM</th>
                            <th width="10%">Pack Size</th>
                            <th width="30%">Item</th>
                            <th width="20%" style="text-align: right;">Unit Price</th>
                            <th width="12%" style="text-align: right; display: none;">Discount</th>
                            <th style="display: none;">T.D</th> <!-- total discount -->
                            <th style="display: none;">Tax %</th>
                            <th width="20%" style="text-align: right">Total</th>
                            <th class="hidden">Total Price</th>
                            <th class="hidden">V.I</th>
                            <th class="hidden">N.V</th>
                            <td class="hidden">Item ID</td>
                            <th><center>Action</center></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8" style="height: 50px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount :</strong></td>
                                <td align="right">
                                    <input id="txt_overall_discount" name="total_overall_discount" type="text" class="numeric form-control" value="0.00">
                                    <input id="txt_overall_discount_amount" name="total_overall_discount_amount" type="hidden" class="numeric form-control" value="0.00" readonly>
                                </td>
                                <td colspan="3" id="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                                <td align="right" colspan="1" id="td_before_tax" color="red">0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                <td align="right" colspan="2" id="td_tax" color="red">0.00</td>
                                <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                                <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                            </tr>
                        </tfoot>


                    </table>
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
                        <table id="tbl_sales_order_summary" class="table invoice-total" style="font-family: tahoma;">
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


<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content--->
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->

<div id="modal_confirmation_close" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Closing of Sales Order</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes_close" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_new_customer" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>New Customer</h4>

            </div>

            <div class="modal-body">
                <form id="frm_customer">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <div class="col-md-4" id="label">
                                    <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Customer Name :</label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-users"></i>
                                        </span>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" data-error-msg="Customer Name is required!" required>
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
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="control-label boldlabel" style="text-align:left;padding-top:10px;"><i class="fa fa-user" aria-hidden="true" style="padding-right:10px;"></i>Customer's Photo</label>
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
                <button id="btn_create_customer" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_customer" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->



<div id="modal_new_salesperson" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 id="salesperson_title" class="modal-title" style="color: #ecf0f1;"><span id="modal_mode"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="frm_salesperson" role="form">
                        <div class="">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 control-label "><strong>* Acronym name :</strong></label>
                                    <div class="col-xs-12 col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="acr_name" class="form-control" placeholder="Acronym" data-error-msg="Acronym name is required!" required>
                                        </div>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 control-label "><strong>* First name :</strong></label>
                                    <div class="col-xs-12 col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="firstname" class="form-control" placeholder="Firstname" data-error-msg="Firstname is required!" required>
                                        </div>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 control-label "><strong>&nbsp;&nbsp;Middle name :</strong></label>
                                    <div class="col-xs-12 col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="middlename" class="form-control" placeholder="Middlename">
                                        </div>
                                    </div>
                                </div>
                            </div><br><br>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-4 control-label "><strong>* Last name :</strong></label>
                                    <div class="col-xs-12 col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>
                                            </span>
                                            <input type="text" name="lastname" class="form-control" placeholder="Last name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_create_salesperson" class="btn btn-primary" name="btn_save">Save</button>
                <button id="btn_close_salesperson" class="btn btn-default">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div id="modal_new_department" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content"><!---content--->
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>New Branch</h4>

            </div>

            <div class="modal-body">
                <form id="frm_department_new">

                    <div class="form-group">
                        <label>* Branch :</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-users"></i>
                            </span>
                            <input type="text" name="department_name" class="form-control" placeholder="Branch" data-error-msg="Branch name is required." required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Branch Description :</label>
                        <textarea name="department_desc" class="form-control"></textarea>
                    </div>




                </form>


            </div>

            <div class="modal-footer">
                <button id="btn_create_department" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_close_department" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->



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




$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;
    var _cboDepartments, _cboSalesperson; var _cboCustomers; var _productType; var _lookUpPrice; var _defLookUp;
    var _cboStatus; var _cboSalespersons;

    var oTableItems={
        qty : 'td:eq(0)',
        unit_price : 'td:eq(4)',
        discount : 'td:eq(5)',
        total_line_discount : 'td:eq(6)',
        tax : 'td:eq(7)',
        gross : 'td:eq(8)', //Gross
        total : 'td:eq(9)', //Total
        vat_input : 'td:eq(10)',
        net_vat : 'td:eq(11)' //Before Tax

    };


    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        so_tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };


    var initializeControls=function(){
        _cboSalespersons=$("#salesperson").select2({
            placeholder: "Please select salesperson.",
            allowClear: false
        });

        _cboSalespersons.select2('val',-1);

        _cboStatus=$("#status").select2({
            placeholder: "Please select status.",
            allowClear: false
        });

        _cboStatus.select2('val',1);

        dt=$('#tbl_sales_order').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength":15,
            "order": [[ 9, "desc" ]],
            // "ajax" : "Sales_order/transaction/list",
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Sales_order/transaction/list",
                
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "tsd":$('#txt_start_date').val(),
                            "ted":$('#txt_end_date').val(),
                            "salesperson_id": _cboSalespersons.select2('val'),
                            "status": _cboStatus.select2('val')
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
                { targets:[1],data: "so_no" },
                { targets:[2],data: "date_order" },
                { targets:[3],data: "time_created" },
                { targets:[4],data: "customer_name" },
                { targets:[5],data: "remarks", render: $.fn.dataTable.render.ellipsis(40) },

                { targets:[6],data: "salesperson" },

                { targets:[7],data: "order_status" },
                {
                    targets:[8],data: null,
                    render: function (data, type, full, meta){
                        if(data.order_status_id == 1  || data.order_status_id == 3){
                            return so_btn_edit+"&nbsp;"+so_btn_trash+'&nbsp'+so_btn_mark_as_closed; 
                        }else{
                            return so_btn_edit+"&nbsp;"+so_btn_trash; 
                        }
                        
                    }
                },
                { visible:false, targets:[9],data: "sales_order_id" },
            ]

        }); 

        _cboCustomers=$("#cbo_customers").select2({
            placeholder: "Please select customer.",
            allowClear: true
        });


        _lookUpPrice = $('#cboLookupPrice').select2({
            allowClear: false
        });
        _lookUpPrice.select2('val',1);

        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select branch.",
            allowClear: false
        });

        _cboSalesperson=$("#cbo_salesperson").select2({
            placeholder: "Please select sales person.",
            allowClear: true
        });

        _cboSalesperson.select2('val',null);

        _productType = $('#cbo_prodType').select2({
            placeholder: "Please select Product Type",
            allowClear: false
        });


        $('.numeric').autoNumeric('init');

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        _cboDepartments.select2('val',null);
        _cboCustomers.select2('val',null);

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });

         _cboSalesperson.on('select2:select',function(e){
            var i=$(this).select2('val');

            if(i == 0) {
                //clearFields($('#modal_new_salesperson').find('form'));
                _cboSalesperson.select2('val',null);
                $('#modal_new_salesperson').modal('show');
                $('#salesperson_title').text('Create New Salesperson');
            }
        });

         $('#btn_close_salesperson').on('click',function(){
            $('#modal_new_salesperson').modal('hide');
        });

         $('#btn_create_salesperson').click(function(){
            var btn=$(this);

            if(validateRequiredFields($('#frm_salesperson'))){
                var data=$('#frm_salesperson').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Salesperson/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_salesperson').modal('hide');

                    var _salesperson=response.row_added[0];
                    $('#cbo_salesperson').append('<option value="'+_salesperson.salesperson_id+'" selected>'+ _salesperson.acr_name + ' - ' +_salesperson.fullname+'</option>');
                    $('#cbo_salesperson').select2('val',_salesperson.salesperson_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }


        });

        $('#custom-templates .typeahead').keypress(function(event){
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
            }
        });


        var products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace(''),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                cache: false,
                url: 'Sales_order/transaction/product-lookup/',

                replace: function(url, uriEncodedQuery) {
                    var prod_type=$('#cbo_prodType').select2('val');
                    var department_id=$('#cbo_departments').select2('val');
                    return url + '?type='+prod_type+'&description='+uriEncodedQuery+'&department_id='+department_id;
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
                '<td width=10%" style="padding-left:1%;"><b>PLU</b></td>'+
                '<td width="30%" align="left"><b>Description 1</b></td>'+
                '<td width="10%" style="text-align: right;"><b>On hand</b></td>'+
                '<td width="10%" align="right"><b>SRP</b></td>'+
                // '<td width="0%" align="right"><b>Dealer</b></td>'+
                //'<td width="10%" align="right"><b>Distributor</b></td>'+
                '<td width="10%" align="right"><b>Discounted</b></td>'+
                '<td width="10%" align="right" style="padding-right:1%;"><b>Selling/Vet</b></td></tr></table>'

            ].join('\n'),

            suggestion: Handlebars.compile('<table class="tt-items"><tr>'+
                '<td width="10%" style="padding-left:1%;">{{product_code}}</td>'+
                '<td width="30%" align="left">{{product_desc}}</td>'+
                '<td width="10%" align="right">{{on_hand}}</td>'+
                '<td width="10%" align="right">{{sale_price}}</td>'+
                // '<td width="0%" align="right">{{dealer_price}}</td>'+
                //'<td width="10%" align="right">{{distributor_price}}</td>'+
                '<td width="10%" align="right">{{discounted_price}}</td>'+
                '<td width="10%" align="right" style="padding-right:1%;">{{public_price}}</td></tr></table>')

        }
    }).on('keyup', this, function (event) {
            if(_objTypeHead.typeahead('val') == '')
                return false;
            if (event.keyCode == 13) {
                //$('.tt-suggestion:first').click();
                _objTypeHead.typeahead('close');
                _objTypeHead.typeahead('val');
                _objTypeHead.typeahead('val','');  
            }
    }).bind('typeahead:select', function(ev, suggestion) {

            if($('#tbl_items > tbody tr').length == '10'){

                showNotification({title:"Invalid",stat:"error",msg:"Maximum of 10 Items per Order"});

            }else{

            var tax_rate=suggestion.tax_rate; // tax rate is based the tax type set to selected product
            var _defLookUp=_lookUpPrice.select2('val');

            if(_defLookUp=="0"){
                total=0;
            }else if(_defLookUp=="2"){
                total=getFloat(suggestion.distributor_price);
            }else if(_defLookUp=="3"){
                total=getFloat(suggestion.dealer_price);
            }
            else if(_defLookUp=="4"){
                total=getFloat(suggestion.public_price);
            }
            else if(_defLookUp=="5"){
                total=getFloat(suggestion.discounted_price);
            }
            else if(_defLookUp=="6"){
                total=getFloat(suggestion.purchase_cost);
            }else{
                total=getFloat(suggestion.sale_price);
            }


            var net_vat=0;
            var vat_input=0;

            if(suggestion.is_tax_exempt=="0"){ //not tax excempt
                net_vat=total/(1+(getFloat(tax_rate)/100));
                vat_input=total-net_vat;
            }else{
                tax_rate=0;
                net_vat=total;
                vat_input=0;
            }


            $('#tbl_items > tbody').append(newRowItem({
                so_qty : "1",
                product_code : suggestion.product_code,
                unit_id : suggestion.unit_id,
                unit_name : suggestion.unit_name,
                size : suggestion.size,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                so_line_total_discount : "0.00",
                tax_exempt : false,
                so_tax_rate : tax_rate,
                so_price : total,
                so_discount : "0.00",
                tax_type_id : null,
                so_line_total_gross : total,
                so_line_total_price : total,
                so_non_tax_amount: net_vat,
                so_tax_amount:vat_input,
                batch_no : '',
                exp_date : ''
            }));
            reInitializeNumeric();
            reComputeTotal();
            }
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
        _cboSalespersons.on("select2:select", function (e) {
                $('#tbl_sales_order').DataTable().ajax.reload();
            });

        _cboStatus.on("select2:select", function (e) {
            $('#tbl_sales_order').DataTable().ajax.reload();
        });

        var detailRows = [];
        $('#tbl_sales_order tbody').on( 'click', 'tr td.details-control', function () {
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
                    "url":"Templates/layout/sales-order/"+ d.sales_order_id+"?type=fullview",
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

        $("#searchbox_tbl_sales_order").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#txt_start_date,#txt_end_date").on("change", function () {        
            $('#tbl_sales_order').DataTable().ajax.reload()
        });



        //loads modal to create new department
        _cboDepartments.on("select2:select", function (e) {

            var i=$(this).select2('val');

            if(i==0){ //new departmet
                clearFields($('#modal_new_department').find('form'));
                _cboDepartments.select2('val',null)
                $('#modal_new_department').modal('show');
            }

        });

        _productType.on("select2:select", function (e) {
            if($('#tbl_items > tbody tr').length > 0){
                $('#tbl_items > tbody').html('');
                reComputeTotal();
                showNotification({title:"Success",stat:"info",msg:"Items Reset Successfully."});
            }
        });        

        _cboCustomers.on("select2:select", function (e) {

            var i=$(this).select2('val');
            if(i==0){ //new customer
                clearFields($('#modal_new_customer').find('form'));
                _cboCustomers.select2('val',null)
                $('#modal_new_customer').modal('show');
            }

        });


        _cboCustomers.on('change',function(e){
            var i=$(this).select2('val');
            var obj_customers=$('#cbo_customers').find('option[value="' + i + '"]');
            $('#txt_address').val(obj_customers.data('address'));
        });


        //create new department
        $('#btn_create_department').click(function(){
            var btn=$(this);

            if(validateRequiredFields($('#frm_department_new'))){
                var data=$('#frm_department_new').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Departments/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_department').modal('hide');

                    var _department=response.row_added[0];
                    $('#cbo_departments').append('<option value="'+_department.department_id+'" selected>'+_department.department_name+'</option>');
                    $('#cbo_departments').select2('val',_department.department_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }


        });

        $('#tbl_sales_order tbody').on('click','#btn_email',function(){
            _selectRowObj=$(this).parents('tr').prev();
            var d=dt.row(_selectRowObj).data();
            var btn=$(this);

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Email/send/po/"+ d.sales_order_id,
                "data": {email:$(this).data('supplier-email')},
                "beforeSend" : function(){
                    showSpinningProgress(btn);
                }
            }).done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).data(response.row_updated[0]).draw();
            }).always(function(){
                showSpinningProgress(btn);
            });
        });

        $('#btn_new').click(function(){
            _txnMode="new";
            //$('.toggle-fullscreen').click();
            clearFields($('#frm_sales_order'));
            $('#txt_overall_discount').val('0.00');
            $('#cbo_prodType').select2('val', 1);
            $('#cbo_salesperson').select2('val',null);
            $('#cbo_departments').select2('val', default_department_id);
            $('input[name="date_order"]').datepicker('setDate', 'today');
            ///$('.sales_order_title').html('New Sales Order');
            $('.typeahead').typeahead('val',''); 
            showList(false);
        });

        $('#tbl_sales_order tbody').on('click','button[name="edit_info"]',function(){
            ///alert("ddd");
            _txnMode="edit";
            //$('.sales_order_title').html('Edit Sales Order');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();

            if(data.order_status_id != '1' ){
                showNotification({title:"Invalid",stat:"error",msg:"Only Open Sales can be Edited."});
            }else {


            _selectedID=data.sales_order_id;

            $('textarea[name="remarks"]').val(data.remarks);

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });

            $('#txt_overall_discount').val(accounting.formatNumber($('#txt_overall_discount').val(),2));
            $('#cbo_departments').select2('val',data.department_id);
            $('#cbo_customers').select2('val',data.customer_id);
            $('#cbo_salesperson').select2('val',data.salesperson_id);
            $('#txt_address').val(data.address);

            _lookUpPrice.select2('val');

            $.ajax({
                url : 'Sales_order/transaction/items/'+data.sales_order_id,
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                beforeSend : function(){
                    $('#tbl_items > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    $('#tbl_items > tbody').html('');

                    $.each(rows,function(i,value){

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
                            so_non_tax_amount: value.so_non_tax_amount,
                            so_tax_amount:value.so_tax_amount,
                            batch_no: value.batch_no,
                            exp_date: value.exp_date

                        }));
                    });

                    reComputeTotal();
                }
            });




            showList(false); 


        } // END OF IF ELSE 

        });

        $('#tbl_sales_order tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();

            if(data.order_status_id != '1' ){
                showNotification({title:"Invalid",stat:"error",msg:"Only Open Sales can be Deleted."});
            }else {

            _selectedID=data.sales_order_id;

            $('#modal_confirmation').modal('show');
            }
        });

        $('#tbl_sales_order tbody').on('click','button[name="mark_as_closed"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.sales_order_id;

            $('#modal_confirmation_close').modal('show');
        });

        $('#txt_overall_discount').on('keypress', function(event){
              if (event.key === "Enter") {
                event.preventDefault();
              }
        });
        
        $('#txt_overall_discount').on('keyup',function(){
            var global_discount = accounting.unformat($(this).val());

            if (global_discount > 100){
                showNotification({title:"Invalid",stat:"error",msg:"Discount must not be greater than 100%."});
                $(this).val('0.00');
                $(this).select();
            }

            $('.trigger-keyup').keyup();
            reComputeTotal();
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

            var global_discount = $('#txt_overall_discount').val();
            var line_total = price*qty; //ok not included in the output (view) and not saved in the database
            var line_total_discount=discount*qty; 
            // var line_total_discount=line_total*(discount/100);
            var new_line_total=line_total-line_total_discount; 
            var total_after_global = new_line_total-(new_line_total*(global_discount/100));
            var net_vat=total_after_global/(1+tax_rate);
            var vat_input=total_after_global-net_vat;

            $(oTableItems.gross,row).find('input.numeric').val(accounting.formatNumber(line_total,2));
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(total_after_global,4)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(line_total_discount); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(net_vat); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(vat_input); //vat input

            //console.log(net_vat);
            reComputeTotal();

        });


        $('#btn_yes').click(function(){
            //var d=dt.row(_selectRowObj).data();
            //if(getFloat(d.order_status_id)>1){
            //showNotification({title:"Error!",stat:"error",msg:"Sorry, you cannot delete purchase order that is already been recorded on purchase invoice."});
            //}else{
            removeIssuanceRecord().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }

            });
            //}
        });


        $('#btn_yes_close').click(function(){
            MarkRecordAsClosed().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                    $('#tbl_sales_order').DataTable().ajax.reload();
                }

            });
        });


        $('#btn_cancel').click(function(){
            showList(true);
        });



        $('#btn_save').click(function(){

            if(validateRequiredFields($('#frm_sales_order'))){
                if(_txnMode=="new"){
                    createSalesOrder().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_sales_order'));
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                }else{
                    updateSalesOrder().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                        clearFields($('#frm_sales_order'));
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

        //create new customer
        $('#btn_create_customer').click(function(){
            var btn=$(this);

            if(validateRequiredFields($('#frm_customer'))){
                var data=$('#frm_customer').serializeArray();
                createCustomer().done(function(response){
                    showNotification(response);
                    $('#modal_new_customer').modal('hide');
                    var _customer=response.row_added[0];
                    $('#cbo_customers').append('<option value="'+_customer.customer_id+'" selected>'+_customer.customer_name+'</option>');
                    $('#cbo_customers').select2('val',_customer.customer_id);
                    clearFields($('#modal_new_customer').find('form'));
                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
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
                url : 'Customers/transaction/upload',
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

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
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

    var createCustomer=function(){
        var _data=$('#frm_customer').serializeArray();
        _data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Customers/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_create_customer'))
        });
    };

    var createSalesOrder=function(){
        var _data=$('#frm_sales_order,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_sales_order_summary');

        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.so_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_order/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateSalesOrder=function(){
        var _data=$('#frm_sales_order,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_sales_order_summary');

        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.so_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "sales_order_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_order/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeIssuanceRecord=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_order/transaction/delete",
            "data":{sales_order_id : _selectedID}
        });
    };

    var MarkRecordAsClosed=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Sales_order/transaction/close",
            "data":{sales_order_id : _selectedID}
        });
    };


    var showList=function(b){
        if(b){
            $('#div_user_list').show();
            $('#div_user_fields').hide();
        }else{
            $('#div_user_list').hide();
            $('#div_user_fields').show();
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
        $('input,textarea,select',f).val('');
        $(f).find('input:first').focus();
        $('#tbl_items > tbody').html('');
        $('#cbo_departments').select2('val', null);
        $('#cbo_customers').select2('val', null);
        $('#cbo_prodType').select2('val', 1);
        $('#img_user').attr('src','assets/img/anonymous-icon.png');
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
        '<td width="10%"><input name="so_qty[]" type="text" class="number form-control trigger-keyup" value="'+ d.so_qty+'"></td>'+
        '<td width="5%">'+ d.unit_name+'</td>'+
        '<td width="10%">'+ d.size + '</td>' + 
        '<td width="30%">'+d.product_desc+'</td>'+
        '<td width="11%"><input name="so_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.so_price,4)+'" style="text-align:right;"></td>'+
        '<td width="11%" style="display: none;"><input name="so_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_discount,4)+'" style="text-align:right;"></td>'+
        '<td style="display: none;" width="11%"><input name="so_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_discount,4)+'" readonly></td>'+
        '<td width="11%" style="display: none;"><input name="so_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_tax_rate,4)+'"></td>'+
        '<td width="11%" align="right"><input name="so_line_total_gross[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_gross,4)+'" readonly></td>'+
        '<td class="hidden"><input name="so_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.so_line_total_price,4)+'" readonly></td>'+
        '<td style="display: none;"><input name="so_tax_amount[]" type="text" class="numeric form-control" value="'+ d.so_tax_amount+'" readonly></td>'+
        '<td style="display: none;"><input name="so_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.so_non_tax_amount+'" readonly></td>'+
        '<td style="display: none;"><input name="product_id[]" type="text" class="form-control" value="'+ d.product_id+'" readonly></td>'+
            '<td style="display: none;"><input name="batch_no[]" type="text" class="form-control" value="'+ d.batch_no+'" readonly></td>'+
            '<td style="display: none;"><input name="exp_date[]" type="text" class="numeric form-control" value="'+ d.exp_date+'" readonly></td>'+
        '<td align="center"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
        '</tr>';


    };



    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');

        var discounts=0; 
        var before_tax=0; 
        var after_tax=0; 
        var so_tax_amount=0;
        var gross=0;

        $.each(rows,function(){
            //console.log($(oTableItems.net_vat,$(this)));
            gross+=parseFloat(accounting.unformat($(oTableItems.gross,$(this)).find('input.numeric').val()));
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            so_tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        });

        var global_discount = (gross - discounts) * ($('#txt_overall_discount').val() / 100);

        var tbl_summary=$('#tbl_sales_order_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts + global_discount,4));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,4));
        tbl_summary.find(oTableDetails.so_tax_amount).html(accounting.formatNumber(so_tax_amount,4));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,4)+'</b>');

        $('#txt_overall_discount_amount').val(accounting.formatNumber(global_discount,2));
        $('#td_before_tax').html(accounting.formatNumber(before_tax,4));
        $('#td_after_tax').html(accounting.formatNumber(after_tax,4));
        $('#td_discount').html(accounting.formatNumber(discounts + global_discount,4));
        $('#td_tax').html(accounting.formatNumber(so_tax_amount,4));


    };



    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init', {mDec:4});
        $('.number').autoNumeric('init', {mDec:0});
    };








});




</script>


</body>


</html>