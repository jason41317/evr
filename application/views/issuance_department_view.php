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

        button[name="search_item"] {
            font-size: 15px!important;
            padding-top: 4px!important;
            padding-right: 7px!important;
            padding-bottom: 4px!important;
            padding-left: 7px!important;
            margin-right: 5px;
        }

        button[name="remove_item"] {
            font-size: 15px!important;
            padding-top: 4px!important;
            padding-right: 7px!important;
            padding-bottom: 4px!important;
            padding-left: 7px!important;
        }

        #tbl_issuances_filter{
            display: none;
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
    </style>
</head>
<body class="animated-content"  style="font-family: tahoma;">
<?php echo $_top_navigation; ?>
<div id="wrapper">
<div id="layout-static">
<?php 
echo $_side_bar_navigation;
?>
<div class="static-content-wrapper white-bg">
<div class="static-content"  >
<div class="page-content"><!-- #page-content -->
<ol class="breadcrumb"  style="margin-bottom: 10px;">
    <li><a href="Dashboard">Dashboard</a></li>
    <li><a href="Issuance_department">Issuance to Department</a></li>
</ol>
<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_user_list">
    <div class="panel panel-default">
<!--         <div class="panel-heading">
            <b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i>&nbsp; Issuance</b>
        </div> -->
        <div class="panel-body table-responsive">
            <h2 class="h2-panel-heading">Issuance to Department<small> | <a href="assets/manual/inventory/Issuance_to_Department.pdf" target="_blank" style="color:#999999;"><i class="fa fa-question-circle"></i></a></small></h2><hr>
            <div class="row">
                <div class="col-lg-2"><br>
                    <button class="btn btn-primary" id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Record Item to Transfer" ><i class="fa fa-plus"></i> Record Item to Transfer</button>
                </div>
                <div class="col-lg-1"><br>
                    <button class="btn btn-success" id="btn_export" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" 
                    data-placement="left" title="Export Item Transfer" ><i class="fa fa-file-excel-o"></i> Export</button>
                </div>
                <div class="col-lg-2"><br>
                    <button class="btn btn-success" id="btn_export_product" style="text-transform: none; font-family: Tahoma, Georgia, Serif;padding: 6px 10px!important;" data-toggle="modal" 
                    data-placement="left" title="Export Item Transfer" ><i class="fa fa-file-excel-o"></i> Export Per Product</button>
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
                    <input type="text" id="searchbox_tbl_issuances" class="form-control">
                </div>
            </div><br>
            <table id="tbl_issuances" class="table table-striped" cellspacing="0" width="100%">
                <thead class="">
                <tr>
                    <th></th>
                    <th>Transfer #</th>
                    <th>From Department</th>
                    <th>To Department</th>
                    <th width="25%">Remarks</th>
                    <th><center>Action</center></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- <div class="panel-footer"></div> -->
    </div>
</div>
<div id="div_user_fields" style="display: none;">
<div class="panel panel-default">
<!-- <div class="panel-heading">


    <div class="panel-ctrls" data-actions-container=""></div>
</div> -->
<div class="panel-body">
<!--     <h2 id="item_issuance_title"><i class="fa fa-bars"></i>Item Issuance</h2> -->
<!-- <h2 id="item_issuance_title"></h2> -->
        <h2 class="h2-panel-heading" id="item_issuance_title">Issuance</h2><hr>
<div class="row">
    <div class="container-fluid">
        <!--<div class="btn btn-green" style="margin-left: 10px;">
            <strong><a id="btn_receive_si" href="#" style="text-decoration: none; color: white;">Create from Sales Invoice</a></strong>
        </div>-->    
        <form id="frm_issuances" role="form" class="form-horizontal">
            <div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                         Transfer # : <br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-code"></i>
                            </span>
                            <input type="text" name="trn_no" class="form-control" placeholder="TRN-YYYYMMDD-XXX" readonly>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <b class="required">*</b> From Department : <br />
                        <select name="from_department_id" id="cbo_departments" data-default="<?php echo $accounts[0]->default_department_id; ?>" class="cbo_departments" data-error-msg="From Department is required." required>
                            <!-- <option value="0">[ Create New Department ]</option> -->
                            <?php foreach($departments as $department){ ?>
                            <option value="<?php echo $department->department_id; ?>" data-tax-type="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <b class="required">*</b>  To Department : <br />
                        <select name="to_department_id" id="cbo_departments_to" class="cbo_departments" data-error-msg="To Department is required." required>
                            <option value="0">[ Create New Department ]</option>
                            <?php foreach($departments as $department){ ?>
                            <option value="<?php echo $department->department_id; ?>" data-tax-type="<?php echo $department->department_id; ?>"><?php echo $department->department_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                        Terms :<br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-code"></i>
                            </span>
                            <input type="text" name="terms" id="terms" class="form-control" data-error-msg="Terms is required!">
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        Date issued : <br />
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" name="date_issued" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date issued" data-error-msg="Please set the date this items are issued!" required>
                        </div>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                    </div>
                    <div class="col-lg-4"></div>

                </div>
            </div>
        </form>
    </div>
</div>
    <br />
    <div>
        <div class="row">
            <div class="container-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" style="font-family: Tahoma;">Please select product type first :</label>
                    <div class="col-lg-12" style="padding: 0%;">
                        <select name="producttype" id="cbo_prodType" data-error-msg="Product Type is required." required>
                            <?php foreach($refproducts as $refproduct){ ?>
                            <option value="<?php echo $refproduct->refproduct_id; ?>"><?php echo $refproduct->product_type; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label" style="font-family: Tahoma;"><strong>Enter PLU or Search Item :</strong></label>
        
                    <div id="custom-templates">
                        <input class="typeahead" id="typeaheadsearch" type="text" placeholder="Enter PLU or Search Item">
                    </div><br />
                    <form id="frm_items">
                        <div class="table-responsive" style="min-height: 200px;padding: 1px;max-height: 400px;overflow: auto;">
                            <table id="tbl_items" class="table table-striped" cellspacing="0" width="100%" style="font-font:tahoma;">
                                <thead class="">
                                    <tr>
                                        <th width="10%">Qty</th>
                                        <th width="10%">UM</th>
                                        <th width="30%">Description</th>
                                        <th width="10%" style="text-align: right;">Unit Price</th>
                                        <th class="hidden">Discount</th>
                                        <th class="hidden">T.D</th>
                                        <th class="hidden">Tax %</th>
                                        <th width="10%" style="text-align: right;">Total</th>
                                        <th width="10%">Expiration</th>
                                        <th width="10%">Batch #</th>
                                        <th class="hidden">Cost Upon Invoice</th>
                                        <th class="hidden">V.I</th> <!-- vat input -->
                                        <th class="hidden">N.V</th> <!-- net of vat -->
                                        <th class="hidden">Item ID</td><!-- product id -->
                                        <th width="10%"><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8" style="height: 50px;">&nbsp;</td>
                                    </tr>
                                    <tr class="hidden">
                                        <td colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Discount :</strong></td>
                                        <td align="right" colspan="1" id="td_discount" color="red">0.00</td>
                                        <td id="" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Before Tax :</strong></td>
                                        <td align="right" colspan="1" id="td_before_tax" color="red">0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="hidden" colspan="2" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Tax :</strong></td>
                                        <td class="hidden" align="right" colspan="1" id="td_tax" color="red">0.00</td>
                                        <td colspan="7" style="text-align: right;"><strong><i class="glyph-icon icon-star"></i> Total Amount :</strong></td>
                                        <td align="right" id="td_after_tax" color="red">0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label control-label><strong>Remarks :</strong></label>
                            <div class="col-lg-12" style="padding: 0%;">
                                <textarea name="remarks" id="remarks" class="form-control" placeholder="Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: none;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <div class="table-responsive">
                                <table id="tbl_issuance_summary" class="table invoice-total" style="font-family: tahoma;">
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
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color: white;"><span id="modal_mode"> </span>Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>
            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">No</button>
            </div>
        </div>
    </div>
</div><!---modal-->
<div id="modal_new_department" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:white;"><span id="modal_mode"> </span>New Department</h4>
            </div>
            <div class="modal-body">
                <form id="frm_department_new">
                    <div class="form-group">
                        <label><b>* </b> Department :</label>
                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-users"></i>
                                                </span>
                            <input type="text" name="department_name" class="form-control" placeholder="Department" data-error-msg="Department name is required." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description :</label>
                        <textarea name="department_desc" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_create_department" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                <button id="btn_close_close_department" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div>
    </div>
</div><!---modal-->

<div id="modal_search_list" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
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
                        <th style="text-align: right;">On Hand</th>
                        <th style="text-align: right;">SRP</th>
                        <th style="text-align: right;">Dealer</th>
                        <th style="text-align: right;">Distributor</th>
                        <th style="text-align: right;">Discounted</th>
                        <th style="text-align: right;">Vet</th>
                        <th style="text-align: right;">Cost</th>
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
                <button id="cancel_modal" class="btn btn-default" data-dismiss="modal" style="text-transform: none;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->


<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTIONS</h6></li>
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
    var products;
    var dt; var _txnMode; 
    var _selectedID; 
    var _selectRowObj; 
    var _cboDepartments; 
    var _cboDepartmentsTo; 
    var _cboProductType;
    var dt_si; 
    var _cboCustomers;
    var _issuance_filter_id;
    var _productType;
    var _line_unit;
    var _cboDepartmentactive;
    var global_item_desc = '';
    var _selectRowTblItems;

    var oTableItems={
        qty : 'td:eq(0)',
        unit_value: 'td:eq(1)',
        unit_identifier : 'td:eq(2)',
        unit_price : 'td:eq(3)',
        discount : 'td:eq(4)',
        total_line_discount : 'td:eq(5)',
        tax : 'td:eq(6)',
        total : 'td:eq(7)',
        exp_date : 'td:eq(8)',
        batch_no : 'td:eq(9)',
        cost_upon_invoice : 'td:eq(10)',
        vat_input : 'td:eq(11)',
        net_vat : 'td:eq(12)',
        item_id : 'td:eq(13)',
        bulk_price : 'td:eq(15)',
        retail_price : 'td:eq(16)'
    };

    var oTableSearch={
        sBatch : 'td:eq(2)',
        sExpDate : 'td:eq(3)',
        sCost : 'td:eq(10)',
    };

    $('#tbl_si_list > tbody').on('click','button[name="accept_si"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt_si.row(_selectRowObj).data();
            //alert(d.sales_order_id);
            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
                $('input[name="issued_to_person"]').val(data.customer_name);
                $('#cbo_departments').select2('val',data.department_id);
                //$('#cbo_customers').select2('val',data.customer_id);
            });
            $.ajax({
                url : 'Sales_invoice/transaction/list/'+data.sales_invoice_id,
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
                        $('#tbl_items > tbody').prepend(newRowItem({
                            issue_qty : value.inv_qty,
                            unit_id : value.unit_id,
                            unit_name : value.unit_name,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            issue_line_total_discount : value.inv_line_total_discount,
                            tax_exempt : false,
                            issue_tax_rate : value.inv_tax_rate,
                            issue_price : value.inv_price,
                            issue_discount : value.inv_discount,
                            tax_type_id : null,
                            issue_line_total_price : value.inv_line_total_price,
                            issue_non_tax_amount: value.inv_non_tax_amount,
                            issue_tax_amount:value.inv_tax_amount,
                            is_basyo:value.is_basyo,
                            is_product_basyo:value.is_product_basyo
                        }));
                    });
                    reComputeTotal();
                    $('#modal_si_list').modal('hide');
                    resetSummary();
                }
            });
        });
    var oTableDetails={
        discount : 'tr:eq(0) > td:eq(1)',
        before_tax : 'tr:eq(1) > td:eq(1)',
        issue_tax_amount : 'tr:eq(2) > td:eq(1)',
        after_tax : 'tr:eq(3) > td:eq(1)'
    };
dt_si = $('#tbl_si_list').DataTable({
        "bLengthChange" : false,
        "ajax" : "Sales_invoice/transaction/list",
        "columns" : [
        {
            "targets" : [0],
            "class":     "details-control",
            "orderable" : true,
            "data" : null,
            "defaultContent" : ""
        },
        { targets:[1], data: "sales_inv_no" },
        { targets:[2], data: "date_invoice" },
        { targets:[3], data: "department_name"},
        { targets:[4], data: "remarks"},
        { 
            targets:[5], 
            render: function (data, type, full, meta){
                var btn_accept='<button class="btn btn-success btn-sm" name="accept_si"  style="margin-left:-15px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Create Sales Invoice on SO"><i class="fa fa-check"></i> Accept SI</button>';
                return '<center>'+btn_accept+'</center>';
            }
        }
    ]
});
    var initializeControls=function(){
        dt=$('#tbl_issuances').DataTable({
            "dom": '<"toolbar">frtip',
            "order": [[ 1, "desc" ]],
            "bLengthChange":false,  
            "ajax" : {
                "url" : "Issuance_department/transaction/list",
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
                { targets:[1],data: "trn_no" },
                { targets:[2],data: "from_department_name" },
                { targets:[3],data: "to_department_name" },
                { targets:[4],data: "remarks",render: $.fn.dataTable.render.ellipsis(80)},
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-red btn-sm" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                        return '<center>'+btn_edit+"&nbsp;"+btn_trash+'</center>';
                    }
                },
                { targets:[6],data: "issuance_department_id",visible: false },
            ]
        });
        $('#btn_receive_si').click(function(){
            $('#modal_si_list').modal('show');
        });
        // var createToolBarButton=function(){
        //     var _btnNew='<button class="btn btn-primary"  id="btn_new" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Record Item to Transfer" >'+
        //         '<i class="fa fa-plus"></i> Record Item to Transfer</button>';
        //     $("div.toolbar").html(_btnNew);
        // }();

        _cboDepartments=$("#cbo_departments").select2({
            placeholder: "Issue item from Department.",
            allowClear: false
        });
        _cboDepartments.select2('val',null);

        _cboDepartmentsTo=$("#cbo_departments_to").select2({
            placeholder: "Issue item to Department.",
            allowClear: false
        });
        _cboDepartmentsTo.select2('val',null);


        _cboProductType=$("#cbo_prodType").select2({
            placeholder: "Select Product Type",
            allowClear: false
        });
        _cboProductType.select2('val',null);


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
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
                url: 'Sales_invoice/transaction/current-items/',

                replace: function(url, uriEncodedQuery) {
                    var prod_type=$('#cbo_prodType').select2('val');
                    var depid=$('#cbo_departments').select2('val');
                    return url + '?type='+prod_type+'&description='+uriEncodedQuery+'&depid='+depid;
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
                    '<td width=10%" style="padding-left: 1%;"><b>PLU</b></td>'+
                    '<td width="40%" align="left"><b>Description 1</b></td>'+
                    '<td width="15%" align="left"><b>Batch #</b></td>'+
                    '<td width="15%" align="left"><b>Expiration</b></td>'+
                    '<td width="10%" align="right"><b>On hand</b></td>'+
                    '<td width="10%" align="right" style="padding-right: 1%;"><b>Cost</b></td>'+
                    '</tr></table>'
                ].join('\n'),

                suggestion: Handlebars.compile('<table class="tt-items"><tr>'+
                    '<td width="10%" style="padding-left: 1%">{{product_code}}</td>'+
                    '<td width="40%" align="left">{{product_desc}}</td>'+
                    '<td width="15%" align="left">{{batch_no}}</td>'+
                    '<td width="15%" align="left">{{exp_date}}</td>'+
                    '<td width="10%" align="right">{{on_hand_per_batch}}</td>'+
                    '<td width="10%" align="right" style="padding-right: 1%;">{{item_cost}}</td>'+
                    '</tr></table>')

            }
        }).on('keyup', this, function (event) {
            if (_objTypeHead.typeahead('val') == '')
                return false;
            if (event.keyCode == 13) {
                $('.tt-suggestion:first').click();
                _objTypeHead.typeahead('close');
                _objTypeHead.typeahead('val','');
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            _objTypeHead.typeahead('val','');
            //var tax_rate=0;

            var tax_rate=suggestion.tax_rate; // tax rate is based the tax type set to selected product

            var total=getFloat(suggestion.item_cost);
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

            $('#tbl_items > tbody').prepend(newRowItem({
                issue_qty : "1",
                product_code : suggestion.product_code,
                unit_id : suggestion.unit_id,
                unit_name : suggestion.unit_name,
                product_id: suggestion.product_id,
                product_desc : suggestion.product_desc,
                issue_line_total_discount : "0.00",
                tax_exempt : false,
                issue_tax_rate : tax_rate,
                issue_price : suggestion.item_cost,
                issue_discount : "0.00",
                tax_type_id : null,
                issue_line_total_price : total,
                issue_non_tax_amount : net_vat,
                issue_tax_amount : vat_input,
                batch_no : suggestion.batch_no,
                exp_date : suggestion.exp_date,
                cost_upon_invoice : suggestion.srp_cost,
                max_qty : suggestion.on_hand_per_batch
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
        $('#tbl_issuances tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var d=row.data();
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
                    "url":"Templates/layout/issuance-department/"+ d.issuance_department_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child('<div style="padding: 20px;">'+response+'</div>','no-padding').show();
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                });
            }
        } );
        //loads modal to create new department
        _cboDepartments.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ //new department
                $(this).select2('val',null);
                _cboDepartmentactive = '#cbo_departments';
                $('#modal_new_department').modal('show');
                clearFields($('#modal_new_department').find('form'));
            }
        });

        _cboDepartmentsTo.on("select2:select", function (e) {
            var i=$(this).select2('val');
            if(i==0){ //new department
                _cboDepartmentactive = '#cbo_departments_to';
                $(this).select2('val',null);
                $('#modal_new_department').modal('show');
                clearFields($('#modal_new_department').find('form'));
            }else{
                // $('#terms').focus();
                $('#typeaheadsearch').focus();
            }
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
                    $('.cbo_departments').append('<option value="'+_department.department_id+'" >'+_department.department_name+'</option>');
                    $(_cboDepartmentactive).select2('val',_department.department_id);
                }).always(function(){
                    showSpinningProgress(btn);
                });
            }
        });
        $('#tbl_issuances tbody').on('click','#btn_email',function(){
            _selectRowObj=$(this).parents('tr').prev();
            var d=dt.row(_selectRowObj).data();
            var btn=$(this);
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Email/send/po/"+ d.issuance_department_id,
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
            $('#item_issuance_title').html('Record Item to Transfer');
            //$('.toggle-fullscreen').click();
            clearFields($('#frm_issuances'));
            $('#cbo_departments').select2('val', default_department_id);
            $('#cbo_departments_to').select2('val', null);      
            $('#cbo_prodType').select2('val', 3);
            showList(false);
            $('#cbo_departments_to').select2('open');
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


        $('#tbl_issuances tbody').on('click','button[name="edit_info"]',function(){

            _txnMode="edit";
            $('#item_issuance_title').html('Edit Item to issue');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.issuance_department_id;

  
            $('#cbo_prodType').select2('val', 3);
            _is_journal_posted_from=data.is_journal_posted_from;
            _is_journal_posted_to=data.is_journal_posted_to;
            if(_is_journal_posted_from > 0 || _is_journal_posted_to > 0){
                showNotification({title:"<b style='color:white;'> Error!</b>",stat:"error",msg:"Cannot Edit: Invoice is already Posted in General Journal."});
                return;
            }

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name&&_elem.attr('type')!='password'){
                        _elem.val(value);
                    }
                });
            });


            $('#cbo_departments_to').select2('val',data.to_department_id);
            $('#cbo_departments').select2('val',data.from_department_id);
            $('textarea[name="remarks"]').val(data.remarks);
            $.ajax({
                url : 'Issuance_department/transaction/items/'+data.issuance_department_id,
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
                    a=0

                    $.each(rows,function(i,value){
 
                        $('#tbl_items > tbody').prepend(newRowItem({
                            issue_qty : value.issue_qty,
                            product_code : value.product_code,
                            unit_id : value.unit_id,
                            unit_name : value.unit_name,
                            product_id: value.product_id,
                            product_desc : value.product_desc,
                            issue_line_total_discount : value.issue_line_total_discount,
                            tax_exempt : false,
                            issue_tax_rate : value.issue_tax_rate,
                            issue_price : value.issue_price,
                            issue_discount : value.issue_discount,
                            tax_type_id : null,
                            issue_line_total_price : value.issue_line_total_price,
                            issue_non_tax_amount : value.issue_non_tax_amount,
                            issue_tax_amount : value.issue_tax_amount,
                            batch_no : value.batch_no,
                            exp_date : value.exp_date,
                            cost_upon_invoice : value.cost_upon_invoice                          
                        }));   
                    });

                    reInitializeNumeric();
                    reComputeTotal();
                }
            });
            showList(false);
        
        });
        $('#tbl_issuances tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.issuance_department_id;
            _is_journal_posted_from=data.is_journal_posted_from;
            _is_journal_posted_to=data.is_journal_posted_to;
            if(_is_journal_posted_from > 0 || _is_journal_posted_to > 0){
                showNotification({title:"<b style='color:white;'> Error!</b>",stat:"error",msg:"Cannot Delete: Invoice is already Posted in General Journal."});
                return;
            }
            $('#modal_confirmation').modal('show');

        });
        //track every changes on numeric fields
        $('#tbl_items tbody').on('change','select',function(){
        if(changetxn == 'active'){
            var row=$(this).closest('tr');
            var unit_value=row.find(oTableItems.unit_value).find('option:selected').attr("data-unit-identifier"); 
            if(getFloat(unit_value) == 1 ){
                var price=parseFloat(accounting.unformat(row.find(oTableItems.bulk_price).find('input.numeric').val()));
            }else{
                var price=parseFloat(accounting.unformat(row.find(oTableItems.retail_price).find('input.numeric').val()));
            }
            $(oTableItems.unit_price,row).find('input').val(accounting.formatNumber(price,2));
            $(oTableItems.unit_identifier,row).find('input').val(unit_value); 
            $('.trigger-number').keyup();
        }
        
        });
 
        $('#tbl_items tbody').on('keyup','input.numeric',function(){
            var row=$(this).closest('tr');
            var price=parseFloat(accounting.unformat(row.find(oTableItems.unit_price).find('input.numeric').val()));
            var discount=parseFloat(accounting.unformat(row.find(oTableItems.discount).find('input.numeric').val()));
            var qty=parseFloat(accounting.unformat(row.find(oTableItems.qty).find('input.numeric').val()));
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
            $(oTableItems.total,row).find('input.numeric').val(accounting.formatNumber(line_total,2)); // line total amount
            $(oTableItems.total_line_discount,row).find('input.numeric').val(accounting.formatNumber(line_total_discount,2)); //line total discount
            $(oTableItems.net_vat,row).find('input.numeric').val(accounting.formatNumber(net_vat,2)); //net of vat
            $(oTableItems.vat_input,row).find('input.numeric').val(accounting.formatNumber(vat_input,2)); //vat input=

            reComputeTotal();
        });

        $('#tbl_items tbody').on('keypress','input.qty',function(evt){
            if(evt.keyCode==13){
                evt.preventDefault();
                reInitializeNumeric();
                $('#typeaheadsearch').focus();
            }
        });

        $('#tbl_items tbody').on('focus','input.numeric',function(){
            $(this).select();
        });

        $('#terms').on('keypress',function(evt){
            if(evt.keyCode==13){
                evt.preventDefault();
                $('#typeaheadsearch').focus();
            }
        });

        $('#btn_yes').click(function(){
            removeIssuanceRecord().done(function(response){
                showNotification(response);
                if(response.stat=="success"){
                    dt.row(_selectRowObj).remove().draw();
                }
            });
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });

        var rowHighlight=function(rowObj,b=true){
            if(b){
                $('td:eq(0) input',rowObj).css({
                    "color": "red",
                    "border-color": "red",
                    "font-weight": "bolder"
                });


            }else{
                $('td:eq(0) input',rowObj).css({
                    "color": "black",
                    "border-color": "lightgray",
                    "font-weight": "normal"
                });
            }

        };

        $('#btn_save').click(function(){ 
            if(_cboDepartments.val() == _cboDepartmentsTo.val()){ // DEPARTMENT FROM AND TO MUST NOT BE THE SAME
                    showNotification({title:"Error !",stat:"error",msg:"Departments must not be the same."});
            }else{ 
                if(validateRequiredFields($('#frm_issuances'))){
                    if(_txnMode=="new"){
                        createIssuance().done(function(response){
                            showNotification(response);

                            if(response.stat == "success"){
                                dt.row.add(response.row_added[0]).draw();
                                clearFields($('#frm_issuances'));
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
                        updateIssuances().done(function(response){
                            showNotification(response);

                            if(response.stat == "success"){
                                dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                                clearFields($('#frm_issuances'));
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

        $('#tbl_items > tbody').on('click','button[name="remove_item"]',function(){
            $(this).closest('tr').remove();
            reComputeTotal();
        });

        $('#tbl_items > tbody').on('click','button[name="search_item"]',function(){
            _selectRowTblItems=$(this).closest('tr');
            global_item_desc=_selectRowTblItems.find(oTableItems.unit_identifier).find($('.product_desc')).val();
            var _data=[];
            _data.push({name : "type", value :$('#cbo_prodType').select2('val') });
            _data.push({name : "description", value : global_item_desc });
            _data.push({name : "depid", value : _cboDepartments.val() });


            $.ajax({
                url : 'Sales_invoice/transaction/current-items-search',
                "dataType":"json",
                "type":"POST",
                cache : false,
                dataType : 'json',
                "data":_data,
                beforeSend : function(){
                    $('#tbl_search_list > tbody').html('<tr><td align="center" colspan="8"><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></td></tr>');
                },
                success : function(response){
                    var rows=response.data;
                    if(rows.length == 0){
                        showNotification({
                            title: "<b style='color:white;display: inline;'>No Stocks!</b>",
                            stat : "error",
                            msg : "There are no stocks available for the item."
                        });

                    }else{
                        $('#tbl_search_list > tbody').html('');
                        $.each(rows,function(i,value){
                            $('#tbl_search_list > tbody').append('<tr class="row-item">'+
                            '<td >'+value.product_code+'</td>'+
                            '<td >'+value.product_desc+'</td>'+
                            '<td >'+value.batch_no+'</td>'+
                            '<td >'+value.exp_date+'</td>'+
                            '<td align="right">'+value.on_hand_per_batch+'</td>'+
                            '<td align="right">'+value.srp+'</td>'+
                            '<td align="right">'+value.srp_dealer+'</td>'+
                            '<td align="right">'+value.srp_distributor+'</td>'+
                            '<td align="right">'+value.srp_discounted+'</td>'+
                            '<td align="right">'+value.srp_public+'</td>'+
                            '<td align="right">'+value.srp_cost+'</td>'+
                            '<td ><button type="button" name="accept_search" class="btn btn-success"><i class="fa fa-check"></i></button> </td>'+
                            '<tr></tr>'
                            );
                        });
                        $("#modal_search_list").modal('show');
                    }


                }
            });




        });      

        $('#tbl_search_list > tbody').on('click','button[name="accept_search"]',function(){
            var row=$(this).closest('tr');
            _selectRowTblItems.find(oTableItems.exp_date).find('input').val(row.find(oTableSearch.sExpDate).text());
            _selectRowTblItems.find(oTableItems.batch_no).find('input').val(row.find(oTableSearch.sBatch).text());
            _selectRowTblItems.find(oTableItems.cost_upon_invoice).find('input').val(row.find(oTableSearch.sCost).text());
            _selectRowTblItems.find(oTableItems.unit_price).find('input').val(row.find(oTableSearch.sCost).text());
            $('.trigger-number').keyup();
            showNotification({title:"Success!",stat:"success",msg:'The item you selected was updated.'});

            $('#modal_search_list').modal('hide');
        });

        $("#searchbox_tbl_issuances").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $("#txt_start_date,#txt_end_date").on("change", function () {        
            $('#tbl_issuances').DataTable().ajax.reload()
        });

        $('#btn_export').click(function(){
            window.open('Issuance_department/transaction/export?from='+$('#txt_start_date').val()+'&to='+$('#txt_end_date').val());
        }); 
        
        $('#btn_export_product').click(function(){
            window.open('Issuance_department/transaction/export-product?from='+$('#txt_start_date').val()+'&to='+$('#txt_end_date').val());
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
    var createIssuance=function(){
        var _data=$('#frm_issuances,#frm_items').serializeArray();
        var tbl_summary=$('#tbl_issuance_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.issue_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Issuance_department/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };
    var updateIssuances=function(){
        var _data=$('#frm_issuances,#frm_items').serializeArray();
        var tbl_summary=$('#tbl_issuance_summary');
        _data.push({name : "remarks", value : $('textarea[name="remarks"]').val()});
        _data.push({name : "summary_discount", value : tbl_summary.find(oTableDetails.discount).text()});
        _data.push({name : "summary_before_discount", value :tbl_summary.find(oTableDetails.before_tax).text()});
        _data.push({name : "summary_tax_amount", value : tbl_summary.find(oTableDetails.issue_tax_amount).text()});
        _data.push({name : "summary_after_tax", value : tbl_summary.find(oTableDetails.after_tax).text()});
        _data.push({name : "issuance_department_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Issuance_department/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeIssuanceRecord=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Issuance_department/transaction/delete",
            "data":{issuance_department_id : _selectedID}
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
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        $(e).toggleClass('disabled');
    };
    var clearFields=function(f){
        var dDate = <?php echo json_encode(date('m/d/Y')); ?>;
        $('input,textarea,select,input:not(.date-picker)',f).val('');
        $('#remarks').val('');
        $(f).find('input:first').focus();
        $('.date-picker').val(dDate);
        $('#tbl_items > tbody').html('');
        // $('#cbo_departments').select2('val', null);
        $('#td_before_tax, #td_after_tax, #td_discount, #td_tax').val('');
    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };

    var newRowItem=function(d){
        return '<tr>'+
            // [0] QTY
            '<td>'+
                '<input name="issue_qty[]" type="text" class="numeric form-control trigger-number qty" value="'+d.issue_qty+'">'+
            '</td>'+
            // [1] Unit 
            '<td width="5%">'+ (d.unit_name==null ? 'none' : d.unit_name) +'</td>'+
            // [2] Item
            '<td>'+
                d.product_desc+
                '<input type="text" class="hidden product_desc" value="'+d.product_desc+'">'+
            '</td>'+
            // [3] Unit Price
            '<td>'+
                '<input name="issue_price[]" type="text" class="numeric form-control" value="'+accounting.formatNumber(d.issue_price,2)+'" style="text-align:right;">'+
            '</td>'+
            // [4] Discount
            '<td class="hidden">'+
                '<input name="issue_discount[]" type="text" class="numeric form-control discount" value="'+ accounting.formatNumber(d.issue_discount,2)+'" style="text-align:right;">'+
            '</td>'+
            // [5] Total Discount
            '<td class="hidden">'+
                '<input name="issue_line_total_discount[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.issue_line_total_discount,2)+'" readonly>'+
            '</td>'+
            // [6] Tax Rate
            '<td class="hidden">'+
                '<input name="issue_tax_rate[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.issue_tax_rate,2)+'">'+
            '</td>'+
            // [7] Net Total
            '<td align="right">'+
                '<input name="issue_line_total_price[]" type="text" class="numeric form-control" value="'+ accounting.formatNumber(d.issue_line_total_price,2)+'" readonly>'+
            '</td>'+
            // [8] Expiration
            '<td>'+
                '<input name="exp_date[]" type="text" class="form-control" value="'+ d.exp_date +'" readonly>'+
            '</td>'+
            // [9] Batch #
            '<td>'+
                '<input name="batch_no[]" type="text" class="form-control" value="'+ d.batch_no +'" readonly>'+
            '</td>'+
            // [10] Cost Upon Invoice
            '<td class="hidden"><input name="cost_upon_invoice[]" type="text" class="numeric form-control" value="'+ d.cost_upon_invoice+'" readonly>'+
            '</td>'+
            // [11] Vat Input
            '<td class="hidden">'+
                '<input name="issue_tax_amount[]" type="text" class="numeric form-control" value="'+ d.issue_tax_amount+'" readonly>'+
            '</td>'+
            // [12] Net of Vat
            '<td class="hidden">'+
                '<input name="issue_non_tax_amount[]" type="text" class="numeric form-control" value="'+ d.issue_non_tax_amount+'" readonly>'+
            '</td>'+
            // [13] Product ID
            '<td class="hidden">'+
                '<input name="product_id[]" type="text" class="numeric form-control" value="'+ d.product_id+'" readonly>'+
            '</td>'+
            // [14] Action
            '<td align="center">'+
                '<button type="button" name="search_item" class="btn btn-warning"><i class="fa fa-search"></i></button>'+
                '<button type="button" name="remove_item" class="btn btn-red"><i class="fa fa-trash"></i></button>'+
            '</td>'+
            // [15] Bulk Price
            '<td class="hidden">'+
                '<input type="text" class="numeric form-control" value="'+ d.bulk_price+'" readonly>'+
            '</td>'+
            // [16] Retail Price
            '<td class="hidden">'+
                '<input type="text" class="numeric form-control" value="'+ d.retail_price+'" readonly>'+
            '</td>'+
        '</tr>';
    };

    var reComputeTotal=function(){
        var rows=$('#tbl_items > tbody tr');
        var discounts=0; var before_tax=0; var after_tax=0; var issue_tax_amount=0;
        $.each(rows,function(){
            //console.log($(oTableItems.net_vat,$(this)));
            discounts+=parseFloat(accounting.unformat($(oTableItems.total_line_discount,$(this)).find('input.numeric').val()));
            before_tax+=parseFloat(accounting.unformat($(oTableItems.net_vat,$(this)).find('input.numeric').val()));
            issue_tax_amount+=parseFloat(accounting.unformat($(oTableItems.vat_input,$(this)).find('input.numeric').val()));
            after_tax+=parseFloat(accounting.unformat($(oTableItems.total,$(this)).find('input.numeric').val()));
        });
        $('#td_before_tax').html(accounting.formatNumber(before_tax,2));
        $('#td_after_tax').html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
        $('#td_discount').html(accounting.formatNumber(discounts,2));
        $('#td_tax').html(accounting.formatNumber(issue_tax_amount,2));

        var tbl_summary=$('#tbl_issuance_summary');
        tbl_summary.find(oTableDetails.discount).html(accounting.formatNumber(discounts,2));
        tbl_summary.find(oTableDetails.before_tax).html(accounting.formatNumber(before_tax,2));
        tbl_summary.find(oTableDetails.issue_tax_amount).html(accounting.formatNumber(issue_tax_amount,2));
        tbl_summary.find(oTableDetails.after_tax).html('<b>'+accounting.formatNumber(after_tax,2)+'</b>');
               
    };

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
    };

    var checkProduct= function(check_id){
        var prodstat=true;
        var rowcheck=$('#tbl_items > tbody tr');
        $.each(rowcheck,function(){
            item = parseFloat(accounting.unformat($(oTableItems.item_id,$(this)).find('input.numeric').val()));
            if(check_id == item){
                prodstat=false;
                return false;
            }
        });
         return prodstat;    
    };    

});
</script>
</body>
</html>