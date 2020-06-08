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

                <div class="col-lg-12">
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
<div class="panel panel-default" style="border: 4px solid #2980b9;border-radius: 8px;">
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
                        <input type="text" name="terms" class="form-control">
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
    var dt; var _selectedID; var _selectRowObj; 

    var initializeControls=function(){

        dt=$('#tbl_delivery_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "order": [[ 7, "desc" ]],
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Purchase_invoice_history/transaction/list",
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
                { targets:[3],data: "external_ref_no", render: $.fn.dataTable.render.ellipsis(60) },
                { targets:[4],data: "po_no" },
                { targets:[5],data: "term_description" },
                { targets:[6],data: "date_delivered" },
                { visible:false, targets:[7],data: "dr_invoice_id" }

            ]
        });




    }();






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

        $("#searchbox_tbl_delivery_invoice").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });




    })();

});




</script>


</body>


</html>