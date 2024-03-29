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

        .numeric{
            text-align: right;
        }

        @media screen and (max-width: 1000px) {
            .custom_frame{
                padding-left:5%;

            }
        }

        @media screen and (max-width: 480px) {

            table{
                min-width: 700px;
            }




            .dataTables_filter{
                min-width: 700px;
            }

            .dataTables_info{
                min-width: 700px;
            }

            .dataTables_paginate{
                float: left;
                width: 100%;
            }
        }

        .boldlabel {
            font-weight: bold;
        }

        #modal-supplier {
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

        input[type=checkbox] {
            margin-left: 10px;
          /* Double-sized Checkboxes */
          -ms-transform: scale(1.5); /* IE */
          -moz-transform: scale(1.5); /* FF */
          -webkit-transform: scale(1.5); /* Safari and Chrome */
          -o-transform: scale(1.5); /* Opera */
          padding: 10px;
        }

        .modal-body p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
        }

        #tbl_delivery_invoice_filter{
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

        .error{
            border: 1px solid red!important;
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
    <li><a href="Deliveries">Purchase Invoice</a></li>
</ol>


<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">

<div id="div_delivery_list">
    <div class="panel panel-default">
        <div class="panel-body table-responsive" style="overflow-x: hidden;">
            <h2 style="margin-bottom: 0;" class="h2-panel-heading"> Purchase Invoice</h2><hr>
            <div class="row">
                <div class="col-lg-3"><br>
                        <button class="btn btn-primary <?php echo (in_array('21-1',$this->session->user_rights)?'':'hidden'); ?>" id="btn_new" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><i class="fa fa-plus-circle"></i> New Purchase Invoice</button>
                </div>
                <div class="col-lg-3">
                        From :<br />
                        <div class="input-group">
                            <input type="text" id="txt_start_date" name="" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                             <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                             </span>
                        </div>
                </div>
                <div class="col-lg-3">
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
                         <input type="text" id="searchbox_tbl_delivery_invoice" class="form-control">
                </div>
            </div><br>
            <table id="tbl_delivery_invoice" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th width="3%"></th>
                    <th width="15%">Invoice #</th>
                    <th>Supplier</th>
                    <th width="15%">External Ref#</th>
                    <th width="15%">PO #</th>
                    <th>Terms</th>
                    <th width="10%">Delivered</th>
                    <th width="10%"><center>Action</center></th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>


<div id="div_delivery_fields" style="display: none;">
<div class="panel panel-default" style="border: 4px solid #2980b9;border-radius: 8px;z-index: 1;">
<!-- <div class="panel-heading">
    <h2>Purchase Invoice</h2>
</div> -->


    <div class="col-xs-12 col-md-4" style="display: none;">
        <div class="btn btn-green"><strong> <a id="btn_receive_po" href="#" style="color: white; text-decoration: none;">Receive from Purchase Order</a> </strong></div>
        <div class="panel-ctrls" data-actions-container=""></div>
    </div>


<div class="panel-body">
<div>

<div class="row ">
    <div class="container-fluid">
    <form id="frm_deliveries" role="form" class="form-horizontal">
        <h4 style="margin-bottom: 6px; margin-left: 10px;"><b>Invoice # : <span id="span_invoice_no">INV-XXXX</span></b></h4>
        <!-- <div class="check-div">
            <input class="" type="checkbox" name="chk_save"><label for="chk_save" style="color: #3f51b5;"><strong>&nbsp;&nbsp;Update Cost on Sales Invoice</strong></label>
        </div>
 -->        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;">
            <div class="row">
                <div class="col-sm-3">
                    Invoice #:<br />
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-code"></i>
                        </span>
                        <input type="text" name="dr_invoice_no" class="form-control" placeholder="P-INV-YYYYMMDD-XXX" readonly>
                    </div>
                </div>

                <div class="col-sm-2">
                    Invoice Date :<br />
                    <div class="input-group">

                        <input type="text" name="date_delivered" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Due Date" data-error-msg="Delivery Date is required!" required>
                         <span class="input-group-addon">
                             <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-3 col-sm-offset-4">

                </div>

            </div>



            <div class="row">
                <div class="col-sm-3">
                    PO #:<br />
                    <div class="input-group">
                        <input type="text" name="po_no" class="form-control" placeholder="PO #">
                         <span class="input-group-addon">
                            <a href="#" id="link_browse_po"><b>...</b></a>
                        </span>
                    </div>
                </div>

                <div class="col-sm-2">
                    Due Date:<br />
                    <div class="input-group">
                        <input type="text" name="date_due" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Due Date" data-error-msg="Due Date is required!" required>
                        <span class="input-group-addon">
                                 <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <div class="col-sm-3 col-sm-offset-4">
                    Reference #:<br />
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-code"></i>
                        </span>
                        <input type="text" name="external_ref_no" class="form-control" placeholder="External Ref No.">
                    </div>
                </div>

            </div>


            <div class="row">

                <div class="col-sm-5">
                    Branch * : <br />
                    <select name="department" id="cbo_departments" data-error-msg="Branch is required." required>
                        <option value="0">[ Create New Branch ]</option>
                        <?php foreach($departments as $department){ ?>
                            <option value="<?php echo $department->department_id; ?>"  data-default-cost="<?php echo $department->default_cost; ?>" ><?php echo $department->department_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-sm-3 col-sm-offset-4">
                    Terms :<br />
                    <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        <!-- <input type="text" name="terms" class="form-control"> -->
                        <input type="number" id="txt_terms" name="terms" class="form-control" value="" placeholder="Term in Days">
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-sm-5">
                    Supplier :<br />
                    <select name="supplier" id="cbo_suppliers" data-error-msg="Supplier is required." required>
                        <option value="0">[ Create New Supplier ]</option>
                        <?php foreach($suppliers as $supplier){ ?>
                            <option value="<?php echo $supplier->supplier_id; ?>" data-tax-type="<?php echo $supplier->tax_type_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                        <?php } ?>
                    </select>
                </div>





                <div class="col-sm-3 col-sm-offset-4">
                    Contact Person :<br />
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-users"></i>
                        </span>
                        <input type="text" name="contact_person" class="form-control" placeholder="Contact Person">
                    </div>
                </div>

                <div class="col-sm-3" >
                    Tax type :<br />
                    <select name="tax_type" id="cbo_tax_type">
                        <?php foreach($tax_types as $tax_type){ ?>
                            <option value="<?php echo $tax_type->tax_type_id; ?>" data-tax-rate="<?php echo $tax_type->tax_rate; ?>"><?php echo $tax_type->tax_type; ?></option>
                        <?php } ?>
                    </select>
                </div>



            </div><br />



        </div>



    </form>
    </div>
</div>

<div class="row ">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><br />



        <label style="font-family: Tahoma;">Please select product type first :</label>
        <div style="padding: 0%;">
            <select name="producttype" id="cbo_prodType" data-error-msg="Product Type is required." required>
                <?php foreach($refproducts as $refproduct){ ?>
                    <option value="<?php echo $refproduct->refproduct_id; ?>"><?php echo $refproduct->product_type; ?></option>
                <?php } ?>
            </select>
        </div>

        <br />


        <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
        <div id="custom-templates">
            <input class="typeahead" type="text" name="plu_search" placeholder="Enter PLU or Search Item">
        </div><br />

        <form id="frm_items">
            <div class="table-responsive" style="min-height: 200px;padding: 1px;">
                <table id="tbl_items" class="table table-striped " cellspacing="0" width="100%" style="font-font:tahoma;">
                <thead class="">
                <tr>
                    <th width="10%">Qty</th>
                    <th width="7%">UM</th>
                    <th width="20%">Item</th>
                    <th width="10%" style="text-align: right;">Unit Price</th>
                    <th style="text-align: right; display: none;">Discount</th>
                    <th style="display: none;">T.D</th> <!-- total discount -->
                    <th style="display:none;">Tax %</th>
                    <th width="10%" style="text-align: right;">Total</th>
                    <th style="display: none;">V.I</th> <!-- vat input -->
                    <th style="display: none;">N.V</th> <!-- net of vat -->
                    <td style="display: none;">Item ID</td><!-- product id -->
                    <th width="10%"><center>Expiration Date</center></th>
                    <th width="13%"><center>Batch #</center></th>
                    <td><center><strong>Action</strong></center></td>
                </tr>
                </thead>
                <tbody>

                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="8" style="height: 50px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount :</strong></td>
                        <td align="right" colspan="1" id="td_discount color="red">0.00</td>
                        <td colspan="3" id="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                        <td align="right" colspan="1" id="td_before_tax" color="red">0.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                        <td align="right" colspan="1" id="td_tax" color="red">0.00</td>
                        <td colspan="3" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total After Tax :</strong></td>
                        <td align="right" colspan="1" id="td_after_tax" color="red">0.00</td>
                    </tr>
                </tfoot>

            </table>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                Remarks :<br />
                <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea><br />
            </div>
        </div>


        <div class="row" style="display: none;">
            <div class="col-lg-4 col-lg-offset-8">
                <table id="tbl_delivery_summary" class="table invoice-total">
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
        <div class="modal-content"><!---content-->
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
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_po_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content"><!---content-->
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Purchase Order</h4>

            </div>

            <div class="modal-body">
                <table id="tbl_po_list" class="custom-design table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead class="">
                    <tr>
                        <th></th>
                        <th>PO#</th>
                        <th>Vendor</th>
                        <th>Terms</th>
                        <th>Deliver to</th>
                        <th>Status</th>
                        <th><center>Action</center></th>
                        <th>ID</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <!-- <button id="btn_accept" type="button" class="btn btn-primary" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Receive this Order</button> -->
                <button type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
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
                <button id="btn_create_new_supplier" type="button" class="btn"  style="background-color:#2ecc71;color:white;"><span class=""></span> Save</button>
                <button id="btn_close_new_supplier" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>




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
    var dt; var dt_po; var _txnMode; var _selectedID; var _selectRowObj; var _cboSuppliers; var _cboTaxType;
    var _productType; var _cboDepartments; var _defCostType;


    _defCostType=1; //Luzon Area Purchase Cost is default, this will change when branch is specified

    var oTableItems={
        qty : 'td:eq(0)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        total : 'td:eq(7)',
        vat_input : 'td:eq(8)',
        net_vat : 'td:eq(9)',
        product_id : 'td:eq(10)',
        exp_date : 'td:eq(11)',
        batch_no : 'td:eq(12)'

    };


    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };


    var initializeControls=function(){

        $('#txt_terms').val(0);

        dt_po=$('#tbl_po_list').DataTable({
            "bLengthChange":false,
            "order": [[ 7, "desc" ]],
            "ajax" : "Purchases/transaction/open",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "po_no" },
                { targets:[2],data: "supplier_name" },
                { targets:[3],data: "term_description" },
                { targets:[4],data: "deliver_to_address", render: $.fn.dataTable.render.ellipsis(100) },
                { targets:[5],data: "order_status" },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_accept='<button class="btn btn-success btn-sm" name="accept_po"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Receive this PO"><i class="fa fa-check"></i></button>';
                        return '<center>'+btn_accept+'</center>';
                    }
                },
                {visible:false, targets:[7],data: "purchase_order_id" },
            ]
        });



        _productType = $('#cbo_prodType').select2({
            placeholder: "Please select Product Type",
            allowClear: false
        });

        dt=$('#tbl_delivery_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 8, "desc" ]],
            "pageLength":15,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Deliveries/transaction/list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "tsd":$('#txt_start_date').val(),
                            "ted":$('#txt_end_date').val()

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
                { targets:[1],data: "dr_invoice_no" },
                { targets:[2],data: "supplier_name" },
                { targets:[3],data: "external_ref_no" },
                { targets:[4],data: "po_no" },
                { targets:[5],data: "term_description" },
                { targets:[6],data: "date_delivered" },
                {
                    targets:[7],
                    render: function (data, type, full, meta){
                        return '<center>'+pi_btn_edit+'&nbsp;'+pi_btn_trash+'</center>';
                    }
                },
                { visible:false, targets:[8],data: "dr_invoice_id" }

            ]
        });

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });

        $('.numeric').autoNumeric('init');

        $('#mobile_no').keypress(validateNumber);

        $('#landline').keypress(validateNumber);

        _cboSuppliers=$("#cbo_suppliers").select2({
            placeholder: "Please select supplier.",
            allowClear: true
        });

        _cboSuppliers.select2('val',null);

        _cboTaxType=$('#cbo_tax_type').select2({
            placeholder: "Please select tax type.",
            allopwClear: true
        });

        var _cboTaxGroup=$('#cbo_tax_group').select2({
            placeholder: "Please select tax type.",
            allopwClear: true,
            dropdownParent: "#modal_new_supplier"
        });


        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Please select branch.",
            allowClear: false
        });

        _cboDepartments.select2('val',null);



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
                url: 'Purchases/transaction/product-lookup/',

                replace: function(url, uriEncodedQuery) {
                    //var prod_type=$('#cbo_prodType').select2('val');
                    var sid=$('#cbo_suppliers').select2('val');
                    var prod_type=$('#cbo_prodType').select2('val');
                    var department_id=$('#cbo_departments').select2('val');

                    return url + '?type='+prod_type+'&sid='+sid+'&description='+uriEncodedQuery+'&department_id='+department_id;
                }
            }
        });


        var _objTypeHead=$('#custom-templates .typeahead');

        _objTypeHead.typeahead(null, {
            name: 'products',
            display: 'description',
            source: products,
            limit : 10000,
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

                suggestion: Handlebars.compile('<table class="tt-items"><tr>'+
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
                _objTypeHead.typeahead('close');
                _objTypeHead.typeahead('val','');
            }
        }).bind('typeahead:select', function(ev, suggestion) {


            //var tax_id=$('#cbo_tax_type').select2('val');
            //var tax_rate=parseFloat($('#cbo_tax_type').find('option[value="'+tax_id+'"]').data('tax-rate'));

            var tax_rate=suggestion.tax_rate;
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

            if(suggestion.is_tax_exempt=="0"){ //not tax excempt
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

            var exp_date = <?php echo json_encode(date("m/d/Y")); ?>;


            $('#tbl_items > tbody').append(newRowItem({
                dr_qty : "1",
                product_code : suggestion.product_code,
                unit_id : suggestion.unit_id,
                unit_name : suggestion.unit_name,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                dr_line_total_discount : "0.00",
                tax_exempt : false,
                dr_tax_rate : tax_rate,
                dr_price : purchase_cost,
                dr_discount : "0.00",
                tax_type_id : null,
                dr_line_total_price : total,
                dr_non_tax_amount: net_vat,
                dr_tax_amount: vat_input,
                exp_date:exp_date,
                batch_no:""
            }));





            reInitializeNumeric();
            reComputeTotal();
            reInitializeExpireDate();
            //alert("dd")
        });



        _cboDepartments.on("select2:select", function (e) {

            var i=$(this).select2('val');
            var obj_department=$('#cbo_departments').find('option[value="'+i+'"]');
            _defCostType=obj_department.data('default-cost');


        });


        $('div.tt-menu').on('click','table.tt-suggestion',function(){
            _objTypeHead.typeahead('val','');
        });

        $("input#touchspin4").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-fw fa-plus',
            verticaldownclass: 'fa fa-fw fa-minus'
        });


        $('#txt_terms').on('keyup',function(){
           var term_days=$(this).val();
            var d=$('input[name="date_delivered"]').val();
            var dd= moment(d);
            var nextDate = moment(dd, 'MM/DD/YYYY').add('days', term_days).format('MM/DD/YYYY');
            $('input[name="date_due"]').val(nextDate);
        });

        $('#txt_terms').on('change',function(){
            var term_days=$(this).val();
            var d=$('input[name="date_delivered"]').val();
            var dd= moment(d);
            var nextDate = moment(dd, 'MM/DD/YYYY').add('days', term_days).format('MM/DD/YYYY');
            $('input[name="date_due"]').val(nextDate);
        });

        $('input[name="date_delivered"').on('change', function() {
            recomputeTerms();
        });

        $('input[name="date_due"').on('change', function() {
            recomputeTerms();
        });


    }();



    function recomputeTerms() {
        const dueDate =  $('input[name="date_due"]').val();
        const dateDelivered = $('input[name="date_delivered"]').val();

        if(!dueDate || !dateDelivered) {
            return
        }

        const timeDueDate = new Date(dueDate).getTime();
        const timeDelivered = new Date(dateDelivered).getTime();
        const termsDay = Math.floor((timeDueDate - timeDelivered)/(24 * 3600 * 1000));

        $('#txt_terms').val(termsDay)
    }


    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_delivery_invoice tbody').on( 'click', 'tr td.details-control', function () {
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
                var d=row.data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/dr/"+ d.dr_invoice_id,
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

        $('#tbl_po_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt_po.row( tr );
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
                _selectRowObj=$(this).closest('tr');
                var d=dt_po.row(_selectRowObj).data();

                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Templates/layout/po/"+ d.purchase_order_id+'/contentview',
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


        $("#searchbox_tbl_delivery_invoice").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#txt_start_date,#txt_end_date").on("change", function () {        
            $('#tbl_delivery_invoice').DataTable().ajax.reload()
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


        $('#tbl_delivery_invoice tbody').on('click','#btn_email',function(){
            _selectRowObj=$(this).parents('tr').prev();
            var d=dt.row(_selectRowObj).data();

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Email/send/po/"+ d.dr_invoice_id,
                "data": {email:$(this).data('supplier-email')}
            }).done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).data(response.row_updated[0]).draw();
            });
        });

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#btn_save').removeClass('disabled');
            //$('.toggle-fullscreen').click();
            clearFields($('#frm_deliveries'));
            _cboSuppliers.select2('val',null);
            _cboTaxType.select2('val',null);
            $('#cbo_departments').select2('val', default_department_id);
            $('input[name="date_delivered"]').datepicker('setDate', 'today');
            $('input[name="date_due"]').datepicker('setDate', 'today');
            $('input[name="plu_search"]').val('');
            $('.check-div').hide();
            $('.typeahead').typeahead('val',''); 
            showList(false);
        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });


        $('#btn_receive_po').click(function(){
            $('#tbl_po_list tbody').html('<tr><td colspan="7"><center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center></td></tr>');
            dt_po.ajax.reload( null, false );
            $('#modal_po_list').modal('show');
        });


        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });



        $('#tbl_po_list > tbody').on('click','button[name="accept_po"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_po.row(_selectRowObj).data();

            $('textarea[name="remarks"]').val(data.remarks);
            $('#cbo_suppliers').select2('val',data.supplier_id);
            $('#cbo_departments').select2('val',data.department_id);


            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name') == name && _elem.attr('type')!='password' && name != 'terms'){
                        _elem.val(value);
                    }
                });
            });


            $('#modal_po_list').modal('hide');
            resetSummary();
            recomputeTerms();


            var exp_date = <?php echo json_encode(date("m/d/Y")); ?>;

            $.ajax({
                url : 'Purchases/transaction/item-balance/'+data.purchase_order_id,
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

                    var total_discount=0;
                    var total_tax_amount=0;
                    var total_non_tax_amount=0;
                    var gross_amount=0;

                    $.each(rows,function(i,value){

                        $('#tbl_items > tbody').append(newRowItem({
                            dr_qty : value.po_qty,
                            product_code : value.product_code,
                            unit_id : value.unit_id,
                            unit_name : value.unit_name,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            dr_line_total_discount : value.po_line_total_discount,
                            tax_exempt : false,
                            dr_tax_rate : value.po_tax_rate,
                            dr_price : value.po_price,
                            dr_discount : value.po_discount,
                            tax_type_id : null,
                            dr_line_total_price : value.po_line_total,
                            dr_non_tax_amount: value.non_tax_amount,
                            dr_tax_amount:value.tax_amount,
                            exp_date: exp_date,
                            batch_no:""
                        }));

                        //sum up all footer details
                        total_discount+=getFloat(value.po_line_total_discount);
                        total_tax_amount+=getFloat(value.tax_amount);
                        total_non_tax_amount+=getFloat(value.non_tax_amount);
                        gross_amount+=getFloat(value.po_line_total);

                    });


                    reInitializeNumeric();
                    reInitializeExpireDate();


                   reComputeTotal();
                }
            });



        });


        $('#btn_create_user_suppliers').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_supplier_new'))){
                var data=$('#frm_supplier_new').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"Suppliers/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_new_supplier').modal('hide');

                    var _suppliers=response.row_added[0];
                    $('#cbo_suppliers').append('<option value="'+_suppliers.supplier_id+'" data-tax-type="'+_suppliers.tax_type_id+'" selected>'+_suppliers.supplier_name+'</option>');
                    $('#cbo_suppliers').select2('val',_suppliers.supplier_id);
                    $('#cbo_tax_type').select2('val',_suppliers.tax_type_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });

        $('#btn_create_new_supplier').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_suppliers_new'))){
                var data=$('#frm_suppliers_new').serializeArray();
                /*_data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});*/
                createSupplier().done(function(response){
                    showNotification(response);
                    $('#modal_new_supplier').modal('hide');

                    var _suppliers=response.row_added[0];
                    $('#cbo_suppliers').append('<option value="'+_suppliers.supplier_id+'" data-tax-type="'+_suppliers.tax_type_id+'" selected>'+_suppliers.supplier_name+'</option>');
                    $('#cbo_suppliers').select2('val',_suppliers.supplier_id);
                    $('#cbo_tax_type').select2('val',_suppliers.tax_type_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });


        $('#tbl_delivery_invoice tbody').on('click','button[name="edit_info"]',function(){
            ///alert("ddd");

            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.dr_invoice_id;

            verifyInvoice().done(function(response){
                if(response.is_locked == 1){
                    showNotification(response);
                    return false;
                }else{

                    if(data.order_status_id == 4){
                        showNotification({title:"Purchase Order Already Marked As Closed",stat:"warning",msg:"Editing this invoice will reopen the Purchase Order."});
                    }

                    //make sure save button is disabled
                    $('#btn_save').addClass('disabled');

                    $('textarea[name="remarks"]').html(data.remarks);
                    $('#cbo_suppliers').select2('val',data.supplier_id);
                    $('#cbo_departments').select2('val',data.department_id);
                    $('#txt_terms').html('val',data.terms);

                    $('input,textarea').each(function(){
                        var _elem=$(this);
                        $.each(data,function(name,value){
                            if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                                _elem.val(value);
                            }
                        });
                    });


                    resetSummary();

                    $.ajax({
                        url : 'Deliveries/transaction/items/'+data.dr_invoice_id,
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

                            var total_discount=0;
                            var total_tax_amount=0;
                            var total_non_tax_amount=0;
                            var gross_amount=0;

                            $.each(rows,function(i,value){
                                $('#tbl_items > tbody').append(newRowItem({
                                    dr_qty : value.dr_qty,
                                    product_code : value.product_code,
                                    unit_id : value.unit_id,
                                    unit_name : value.unit_name,
                                    batch_no : value.batch_no,
                                    product_id: value.product_id,
                                    product_desc : value.product_desc,
                                    dr_line_total_discount : value.dr_line_total_discount,
                                    tax_exempt : false,
                                    dr_tax_rate : value.dr_tax_rate,
                                    dr_price : value.dr_price,
                                    dr_discount : value.dr_discount,
                                    tax_type_id : null,
                                    dr_line_total_price : value.dr_line_total_price,
                                    dr_non_tax_amount: value.dr_non_tax_amount,
                                    dr_tax_amount:value.dr_tax_amount,
                                    exp_date : value.expiration,
                                    batch_no : value.batch_no
                                }));


                                //sum up all footer details
                                total_discount+=getFloat(value.dr_line_total_discount);
                                total_tax_amount+=getFloat(value.tax_amount);
                                total_non_tax_amount+=getFloat(value.non_tax_amount);
                                gross_amount+=getFloat(value.dr_line_total_price);


                            });

                            //notify if already posted in Sales Journal
                            if(response.post_status=='posted'){
                                showNotification({title:"Invalid",stat:"info",msg:response.post_message});
                            }else{ // if not yet posted, remove disabled class
                                $('#btn_save').removeClass('disabled');
                            }

                            reInitializeNumeric();
                            reInitializeExpireDate();
                            //write summary details
                            var tbl_summary=$('#tbl_delivery_summary');
                            tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(total_discount,4));
                            tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(total_non_tax_amount,4));
                            tbl_summary.find(oTableDetails.tax_amount).html(accounting.formatNumber(total_tax_amount,4));
                            tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(gross_amount,4)+'</b>');
                            reComputeTotal();

                        }
                    });

                    showList(false);
                }
            });

        });

        $('#tbl_delivery_invoice tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.dr_invoice_id;

            verifyInvoice().done(function(response){
                if(response.is_locked == 1){
                    showNotification(response);
                }else{
                    $('#modal_confirmation').modal('show');
                }
            });
        });


        $('#tbl_items tbody').on('keyup','input.numeric,input.number',function(){
            var row=$(this).closest('tr');

            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.number').val()));
            var tax_rate=parseFloat(accounting.unformat(row.find(oTableItems.tax).find('input.numeric').val()))/100;

            if(discount>price){
                showNotification({title:"Invalid",stat:"error",msg:"Discount must not greater than unit price."});
                row.find(oTableItems.discount).find('input.numeric').val('');
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

            reComputeTotal();


        });

        $('#tbl_items tbody').on('change','input.date-expire,input.batch-code',function(){
            var row=$(this).closest('tr');

            var product_id=parseFloat(accounting.unformat(row.find(oTableItems.product_id).find('input').val()));
            var exp_date=row.find(oTableItems.exp_date).find('input').val();
            var batch_no=row.find(oTableItems.batch_no).find('input').val();

            if(!(checkProduct(product_id,exp_date,batch_no))){ 
                showNotification({title: 'Warning',stat:"error",msg: "Item is Already Added. No duplicate expiration date and batch no."});
                $(this).val("");
                return;
            }

        });


        var checkProduct= function(check_id,exp_date,batch_no){
            var prodstat=true;
            var i=0;
            var rowcheck=$('#tbl_items > tbody tr');
            $.each(rowcheck,function(){

                item = parseFloat(accounting.unformat($(oTableItems.product_id,$(this)).find('input').val()));
                expiration = $(oTableItems.exp_date,$(this)).find('input').val();
                batch = $(oTableItems.batch_no,$(this)).find('input').val();

                if(check_id == item && expiration == exp_date && batch == batch_no){
                    i++;
                }
            });

            if(i > 1){  
                prodstat=false;
            }

            return prodstat;  
        };


        $('#btn_yes').click(function(){
            removePurchaseInvoice().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;

            $('#div_img_user').hide();
            $('#div_img_loader').show();

            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            $.ajax({
                url : 'Users/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('#div_img_loader').hide();
                    $('#div_img_user').show();
                    $('img[name="img_user"]').attr('src',response.path);

                }
            });

        });

        $('#btn_cancel').click(function(){
            //make sure save button is disabled
            $('#btn_save').removeClass('disabled');
            showList(true);
        });

        $('#btn_save').click(function(){

            if(validateRequiredFields($('#frm_deliveries'))){
                if(validateRequiredFields($('#frm_items'))){
                    if(_txnMode=="new"){
                        createDeliverInvoice().done(function(response){
                            showNotification(response);
                            if(response.stat=="success") {
                                dt.row.add(response.row_added[0]).draw();
                                clearFields($('#frm_deliveries'));
                                showList(true);
                            }

                            if (response.current_row_index != undefined) {
                                var rowObj=$('#tbl_items > tbody tr:eq('+response.current_row_index+')');
                                rowHighlight(rowObj);
                            }

                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }else{
                        updatePurchaseOrder().done(function(response){
                            showNotification(response);
                            if(response.stat=="success") {
                                dt.row(_selectRowObj).data(response.row_updated[0]).draw(false);
                                clearFields($('#frm_deliveries'));
                                showList(true);
                            }

                            if (response.current_row_index != undefined) {
                                var rowObj=$('#tbl_items > tbody tr:eq('+response.current_row_index+')');
                                rowHighlight(rowObj);
                            }
                        }).always(function(){
                            showSpinningProgress($('#btn_save'));
                        });
                    }
                }
            }

        });

        $('#link_browse_po').click(function(){
            $('#btn_receive_po').click();
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
        var rowObj=$('#tbl_items > tbody tr');
        rowHighlight(rowObj,false);

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
                if($(this).val()=="" || $(this).val()==null){
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

    var createDeliverInvoice=function(){
        var _data=$('#frm_deliveries,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_delivery_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Deliveries/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updatePurchaseOrder=function(){
        var _data=$('#frm_deliveries,#frm_items').serializeArray();

        var tbl_summary=$('#tbl_delivery_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "dr_invoice_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Deliveries/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removePurchaseInvoice=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Deliveries/transaction/delete",
            "data":{dr_invoice_id : _selectedID}
        });
    };

    var checkProduct=function(product_id,exp_date,batch_no,id){
        var _data=$('#').serializeArray();

        _data.push({name : "product_id" ,value : product_id});
        _data.push({name : "exp_date" ,value : exp_date});
        _data.push({name : "batch_no" ,value : batch_no});
        _data.push({name : "dr_invoice_id" ,value : id});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Deliveries/transaction/checkProduct",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var verifyInvoice=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Transaction_lock/transaction/verify/1",
            "data":{invoice_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_delivery_list').show();
            $('#div_delivery_fields').hide();
        }else{
            $('#div_delivery_list').hide();
            $('#div_delivery_fields').show();
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
        $('input:not(.date-picker),textarea',f).val('');
        $(f).find('input:first').focus();
        $('#tbl_items > tbody').html('');
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
        '<td width="10%"><input name="dr_qty[]" type="text" class="number form-control" value="'+ d.dr_qty+'"></td>'+
        '<td width="5%">'+ (d.unit_name==null ? 'none' : d.unit_name) +'</td>'+
        '<td width="30%">'+ d.product_desc +'</td>'+
        '<td width="11%"><input name="dr_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.dr_price,4)+'" style="text-align:right;"></td>'+
        '<td width="11%" style="display:none;"><input name="dr_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.dr_discount,4)+'" style="text-align:right;"></td>'+
        '<td style="display: none;" width="11%"><input name="dr_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.dr_line_total_discount,4)+'" readonly></td>'+
        '<td width="11%" style="display:none;"><input name="dr_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.dr_tax_rate,4)+'"></td>'+
        '<td width="11%" align="right"><input name="dr_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.dr_line_total_price,4)+'" readonly></td>'+
        '<td style="display: none;"><input name="dr_tax_amount[]" type="text" class="numeric form-control" value="'+ d.dr_tax_amount+'" readonly></td>'+
        '<td style="display: none;"><input name="dr_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.dr_non_tax_amount+'" readonly></td>'+
        '<td style="display: none;"><input name="product_id[]" type="text" class="form-control" value="'+ d.product_id +'" readonly></td>'+
        '<td><input type="text" name="exp_date[]" class="date-expire form-control" placeholder="mm/dd/yyyy" data-error-msg="Expiration Date is required!" value="'+ (d.exp_date == undefined ? '' : d.exp_date) +'" required></td>' +
        '<td><input name="batch_code[]" data-error-msg="Batch # is required!" type="text" class="form-control batch-code" value="'+d.batch_no+'" required></td>'+
        '<td align="center"><button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button></td>'+
        '</tr>';
    };



    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var tbl_summary=$('#tbl_delivery_summary');

        var discounts=0; var before_tax=0; var after_tax=0; var tax_amount=0;

        $.each(rows,function(){
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        });

        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,4));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,4));
        tbl_summary.find(oTableDetails.tax_amount).html(accounting.formatNumber(tax_amount,4));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,4)+'</b>');

        $('#td_before_tax').html(accounting.formatNumber(before_tax,4));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,4)+'</b>');
        $('#td_discount').html(accounting.formatNumber(discounts,4));
        $('#td_tax').html(accounting.formatNumber(tax_amount,4));

    };

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init',{mDec:4});
        $('.number').autoNumeric('init', {mDec:0});
    };

    var resetSummary=function(){
        var tbl_summary=$('#tbl_delivery_summary');
        tbl_summary.find(oTableDetails.discount).html('0.00');
        tbl_summary.find(oTableDetails.before_tax).html('0.00');
        tbl_summary.find(oTableDetails.tax_amount).html('0.00');
        tbl_summary.find(oTableDetails.after_tax).html('<b>0.00</b>');
    };

    var reInitializeExpireDate=function(){
        $('.date-expire').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        });

    };


    var rowHighlight=function(rowObj,b=true){

        if(b){
            $('input.date-expire',rowObj).css({
                "color": "red",
                "border-color": "red",
                "font-weight": "bolder"
            });

        }else{
            $('input.date-expire',rowObj).css({
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