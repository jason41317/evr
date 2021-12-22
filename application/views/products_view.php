<!DOCTYPE html>
<html lang="en">
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
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">
    <style>
    </style>
    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>
    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

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

    <style>

        .toolbar{
            float: left;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
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
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

       /* .container-fluid {
            padding: 0 !important;
        }

        .panel-body {
            padding: 0 !important;
        }*/

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


        .numeric{
            text-align: right;
        }

        .form-group {
            padding-bottom: 3px;
        }

        #is_tax_exempt {
            width:23px;
            height:23px;
        }

        #modal_new_supplier {
            padding-left:0px !important;
        }

        .input-group {
            padding:0;
            margin:0;
        }

        .btn-back {
            float: left; 
            border-radius: 50px; 
            border: 3px solid #9E9E9E!important; 
            background: transparent; 
            margin-right: 10px;
        }

        textarea {
            resize: none;
        }

        #supplier-modal p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
        }

        #tbl_products_filter{
            display: none;
        }

        .required{
            color: red;
            font-weight: bold;
        }

    </style>
</head>

<body class="animated-content" style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->

                    <ol class="breadcrumb" style="margin:0%;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="products" id="filter">Products</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_product_list">
                                        <div class="panel panel-default" style="border-top: 3px solid #2196f3;">
                                            <div class="panel-body table-responsive">
                                                <h2 style="margin-top: 0px !important;margin-bottom: 0px !important;">Products</h2><hr>
                                                
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <br/>
                                                        <button class="btn btn-primary" id="btn_new" style="float: left; text-transform: capitalize;font-family: Tahoma, Georgia, Serif;margin-bottom: 0px !important;" data-toggle="modal" data-target="" data-placement="left" title="Create New product" ><i class="fa fa-plus-circle"></i> Create New Product</button>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-3">
                                                        Product Type :<br />
                                                        <select name="refproduct_id" id="refproduct_id" class="form-control">
                                                            <?php foreach($refproduct as $row) {?>
                                                                <option value="<?php echo $row->refproduct_id;?>">
                                                                    <?php echo $row->product_type;?>
                                                                </option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        Search :<br />
                                                         <input type="text" id="searchbox" class="form-control">
                                                    </div>
                                                </div>
                                                <br/>
                                                <div>
                                                    <table id="tbl_products" class="table table-striped" cellspacing="0" width="100%">
                                                        <thead class="">
                                                        <tr>    
                                                            <th width="3%"></th>
                                                            <th width="10%">PLU</th>
                                                            <th width="42%">Product Description</th>
                                                            <th width="15%">Product Type</th>
                                                            <th width="10%">Category</th>
                                                            <th width="10%">On Hand</th>
                                                            <th width="10%"><center>Action</center></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="panel-footer"></div>
                                        </div>
                                    </div>
                                    <div id="div_product_fields" style="display: none;">
                                        <div class="panel panel-default" style="border-top: 3px solid #2196f3;">
                                            <div class="panel-body table-responsive">
                                                <form id="frm_product">
                                                <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> PLU :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-file-code-o"></i>
                                                            </span>
                                                            <input type="text" name="product_code" class="form-control" value="" data-error-msg="PLU is required." required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Product Description :</label>
                                                        <textarea name="product_desc" class="form-control" data-error-msg="Product Description is required." required></textarea>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class="">Other Description :</label>
                                                        <textarea name="product_desc1" class="form-control"></textarea>
                                                    </div>


                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Product Type :</label>
                                                        <select name="refproduct_id" id="cbo_product_type" class="form-control" data-error-msg="Product type is required." required>
                                                            <option value="">Please Select...</option>
                                                            <option value="prodtype">[ Create Product Type ]</option>
                                                            <?php
                                                            foreach($refproduct as $row)
                                                            {
                                                                echo '<option value="'.$row->refproduct_id.'">'.$row->product_type.'</option>';
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>


                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Supplier :</label>
                                                        <select name="supplier_id" id="new_supplier" class="form-control" data-error-msg="Supplier is required." required>
                                                            <option value="">Please Select...</option>
                                                            <option value="sup">[ Create Supplier ]</option>
                                                            <?php
                                                            foreach($suppliers as $row)
                                                            {
                                                                echo '<option value="'.$row->supplier_id.'">'.$row->supplier_name.'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Category :</label>
                                                        <select name="category_id" id="product_category" class="form-control" data-error-msg="Category is required." required>
                                                            <option value="">Please Select...</option>
                                                            <option value="cat">[ Create Category ]</option>
                                                            <?php
                                                            foreach($categories as $row)
                                                            {
                                                                echo '<option value="'.$row->category_id.'">'.$row->category_name.'</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>


                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Tax :</label>
                                                        <select name="tax_type_id" id="cbo_tax" class="form-control" data-error-msg="Tax type is required." required>
                                                            <option value="">Please Select...</option>
                                                            <?php foreach($tax_types as $tax_type) { ?>
                                                                <option value="<?php echo $tax_type->tax_type_id; ?>"><?php echo $tax_type->tax_type; ?></option>
                                                            <?php    } ?>


                                                        </select>
                                                    </div>


                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Inventory type :</label>

                                                        <select name="item_type_id" id="cbo_item_type" class="form-control" data-error-msg="Item type is required." required>
                                                            <option value="">None</option>
                                                            <?php foreach($item_types as $item_type){ ?>
                                                                <option value="<?php echo $item_type->item_type_id ?>"><?php echo $item_type->item_type; ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>

                                                    <div class="form-group" style="margin-bottom:0px;">
                                                        <label class=""><span class="required">*</span> Unit of Measurement :</label>
                                                        <select name="unit_id" id="product_unit" class="form-control" data-error-msg="Unit is required." required>
                                                            <option value="">Please Select...</option>
                                                            <option value="unt">[ Create Unit ]</option>
                                                            <?php
                                                            foreach($units as $row)
                                                            {
                                                                echo '<option value="'.$row->unit_id.'">'.$row->unit_name.'</option>';
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>



                                                <div class="col-lg-4" style="margin:0px;">



                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Pack Size :</label>
                                                        <input type="text" name="size" class="form-control">
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Suggested Retail Price (SRP) :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="sale_price" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Discounted Price :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="discounted_price" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Dealer's Price :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                            <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="dealer_price" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Distributor's Price :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="distributor_price" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Public Price :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="public_price" class="form-control numeric">
                                                        </div>
                                                    </div>
                                                 <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Purchase Cost 1 (Luzon Area):</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="purchase_cost" class="form-control numeric">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Purchase Cost 2 (Viz-Min Area):</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="purchase_cost_2" class="form-control numeric">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Tax Exempt ?</label><br>
                                                        <input type="checkbox" name="is_tax_exempt" class="form-control" id="is_tax_exempt">

                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Warning Quantity :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="product_warn" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Ideal Quantity :</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-toggle-off"></i>
                                                            </span>
                                                            <input type="text" name="product_ideal" class="form-control numeric">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Link to Credit Account :</label>

                                                        <select name="income_account_id" id="income_account_id" class="form-control" data-error-msg="Link to Account is required.">
                                                            <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                            <option value="0">None</option>
                                                            <?php foreach($accounts as $account){ ?>
                                                                <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="margin-bottom:3px;">
                                                        <label class="">Link to Debit Account :</label>
                                                        <select name="expense_account_id" id="expense_account_id" class="form-control" data-error-msg="Link to Account is required.">
                                                            <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                            <option value="0">None</option>
                                                            <?php foreach($accounts as $account){ ?>
                                                                <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <div class="form-group" style="margin-bottom:3px;">
                                                    <label class="">Cost of Sales Account:</label>
                                                    <select name="cos_account_id" id="cos_account_id" data-error-msg="Link to Cost of sales account is required.">
                                                        <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                        <option value="0">None</option>
                                                        <?php foreach($accounts as $account){ ?>
                                                            <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="margin-bottom:3px;">
                                                    <label class="">Sales Return Account:</label>
                                                    <select name="sales_return_account_id" id="sales_return_account_id" data-error-msg="Link to sales return account is required.">
                                                        <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                        <option value="0">None</option>
                                                        <?php foreach($accounts as $account){ ?>
                                                            <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="margin-bottom:3px;">
                                                    <label class="">Sales Discount Account:</label>
                                                    <select name="sd_account_id" id="sd_account_id" data-error-msg="Link to sales discount account is required." required>
                                                        <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                        <option value="0">None</option>
                                                        <?php foreach($accounts as $account){ ?>
                                                            <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="margin-bottom:3px;">
                                                    <label class="">Purchase Return Account:</label>
                                                    <select name="po_return_account_id" id="po_return_account_id" data-error-msg="Link to purchase return account is required.">
                                                        <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                        <option value="0">None</option>
                                                        <?php foreach($accounts as $account){ ?>
                                                            <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>            
                                                <div class="form-group" style="margin-bottom:3px;">
                                                    <label class="">Purchase Discount Account:</label>
                                                    <select name="pd_account_id" id="pd_account_id" data-error-msg="Link to purchase discount account is required.">
                                                        <optgroup label="Please select NONE if this will not be recorded on Journal."></optgroup>
                                                        <option value="0">None</option>
                                                        <?php foreach($accounts as $account){ ?>
                                                            <option value="<?php echo $account->account_id; ?>"><?php echo $account->account_title; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>  
                                                </div>
                                                </div>
                                                </form>
                                            </div>
                                             <div class="panel-footer" style="text-align: right;">
                                                 <div class="col-md-12">
                                                    <button id="btn_save" type="button" class="btn btn-primary">Save</button>
                                                    <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->

            <div id="modal_category_group" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>New Category Group</h4>

                        </div>

                        <div class="modal-body">
                            <form id="frm_category_group">
                                <div class="form-group">
                                    <label class="boldlabel">* Category Name :</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope-o"></i>
                                                </span>
                                        <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Category Name" data-error-msg="Category name is required." required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="boldlabel">Description :</label>
                                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="category_desc" id="category_desc" placeholder="Category Description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </form>


                        </div>

                        <div class="modal-footer">
                            <button id="btn_create_category_group" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                            <button id="btn_close_category_group" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->

            <div id="modal_unit_group" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>New Unit Group</h4>

                        </div>

                        <div class="modal-body">
                            <form id="frm_unit_group">
                                <div class="form-group">
                                    <label class="boldlabel">* Unit Name :</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope-o"></i>
                                                </span>
                                        <input type="text" name="unit_name" id="unit_name" class="form-control" placeholder="Unit Name" data-error-msg="Unit name is required." required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="boldlabel">Description :</label>
                                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="unit_desc" id="unit_desc" placeholder="Unit Description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </form>


                        </div>

                        <div class="modal-footer">
                            <button id="btn_create_unit_group" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Create</button>
                            <button id="btn_close_unit_group" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div><!---modal-->

            <div id="modal_product_type" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title""><span id="modal_mode"> </span>New Product Type</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frm_product_type">
                                <div class="form-group">
                                    <label class="boldlabel">* Product Type :</label>
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-cube"></i>
                                                </span>
                                        <input type="text" name="product_type" id="product_type" class="form-control" placeholder="Product Type" data-error-msg="Product Type is required!" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="boldlabel">Description :</label>
                                    <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea name="description" id="description" class="form-control" data-error-msg="Description is required!" placeholder="Description" required></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_create_product_type" class="btn btn-primary" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Create</button>
                            <button id="btn_close_product_type" class="btn btn-default" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal_new_supplier" class="modal fade" tabindex="-1" role="dialog" style="padding-left:0px !important;"><!--modal-->
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>New Supplier</h4>
                        </div>
                        <div class="modal-body" style="overflow:hidden;margin-left: 20px !important;">
                            <form id="frm_suppliers_new">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;"><font color="red"><b>*</b></font> Company Name :</label>
                                            </div>
                                            <div class="form-group" style="padding:0;margin:5px;">
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
                                            <div class="form-group" style="padding:0;margin:5px;">
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
                                            <div class="form-group" style="padding:0;margin:5px;">
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
                                            <div class="form-group" style="padding:0;margin:5px;">
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
                                                 <label class="control-label boldlabel" style="text-align:right;">Contact No :</label>
                                            </div>
                                            <div class="form-group" style="padding:0;margin:5px;">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-mobile"></i>
                                                    </span>
                                                    <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Contact No">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="col-md-4" id="label">
                                                 <label class="control-label boldlabel" style="text-align:right;">TIN # :</label>
                                            </div>
                                            <div class="form-group" style="padding:0;margin:5px;">
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
                                            <div class="form-group" style="padding:0;margin:5px;">
                                                <div class="input-group" style="padding: 0 !important;margin: 0 !important;">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-code"></i>
                                                    </span>
                                                    <select name="tax_type_id" id="cbo_tax_group" class="form-control">
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
                                                        <img name="img_user" id="img_user" src="assets/img/anonymous-icon.png" height="140px;" width="140px;" style="padding-bottom: 15px;"></img>
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
                    </div><!---content-->
                </div>
            </div><!---modal-->

            <div id="modal_update_cost" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog" style="width: 30%;">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_ref_no"> </span></h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group" style="margin-bottom:0px;">
                                <label class="">Update the Cost of this Product :</label>
                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-file-code-o"></i>
                                                    </span>
                                    <input type="text" id="txt_cost_upon_invoice" name="cost_upon_invoice" class="form-control" value="" data-error-msg="PLU is required." required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_update_cost" type="button" class="btn" style="background-color:#2ecc71;color:white;">Update</button>
                            <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal" style="padding: 2px 7px!important;">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->

            <div id="modal_filter" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#27ae60;">
                            <button type="button" style="color:white;" class="close"  data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> View Product List </h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_filter">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="margin-bottom:0px;">
                                            <label class="boldlabel">Product Type :</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-file-code-o"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_filter" type="button" class="btn" style="background-color:#2ecc71;color:white;">Select</button>
                            <button id="btn_close_filter" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>



                <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
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

    <script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboItemTypes; var _isTaxExempt=0;
    var _cboProductTypesFilter; var _cboSuppliers; var _cboCategories; var _cboTaxTypes; var _cboInventoryTypes; var _cboUnits; var _cboSalesAccount; var _cboInventoryAccount;
    var _cboProductTypes; var _cboCOSAccounts; var _cboSRAccounts; var _cboSDAccounts; var _cboPRAccounts; var _cboPDAccounts;

    var initializeControls=function() {

        _cboProductTypesFilter=$('#refproduct_id').select2({
            placeholder: "Please select product type.",
            allowClear: false
        });

        _cboProductTypesFilter.select2('val',3);

        dt=$('#tbl_products').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength":15,
            "ajax": {
            "url": "Products/transaction/getproduct",
            "type": "POST",
            "bDestroy": true,
            "data": function ( d ) {
                    return $.extend( {}, d, {
                        "refproduct_id": _cboProductTypesFilter.select2('val')//id of product type
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
                { targets:[1],data: "product_code" ,  render: $.fn.dataTable.render.ellipsis(20)},
                { targets:[2],data: "product_desc",  render: $.fn.dataTable.render.ellipsis(150) },
                { targets:[3],data: "product_type" },
                { targets:[4],data: "category_name" },
                {
                    visible: false, sClass: "text-right", targets:[5],data: "on_hand",
                    render: function (data, type, full, meta) {
                        if(data=="na"){
                            return data;
                        }else{
                            return accounting.formatNumber(data,2);
                        }

                    }
                },
                {
                    targets:[6],
                    render: function (data, type, full, meta){
                        var btn_edit='<button class="btn btn-primary btn-sm" name="edit_info"   data-toggle="tooltip" data-placement="top" title="Edit" style="margin-left:-5px;"><i class="fa fa-pencil"></i> </button>';
                        var btn_trash='<button class="btn btn-danger btn-sm" name="remove_info"  data-toggle="tooltip" data-placement="top" title="Move to trash" style="margin-right:-5px;"><i class="fa fa-trash-o"></i> </button>';

                        return '<center>'+btn_edit+'&nbsp;'+btn_trash+'</center>';
                    }
                }
            ],

            language: {
                         searchPlaceholder: "Search Product Name"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(5).attr({
                    "align": "left"
                });
            }

        });
        
        $('.numeric').autoNumeric('init',{mDec:4});

        _cboProductTypes=$('#cbo_product_type').select2({
            placeholder: "Please select a product type.",
            allowClear: false
        });

        _cboProductTypes.select2('val',null);


        _cboSuppliers=$('#new_supplier').select2({
            placeholder: "Please select a supplier.",
            allowClear: false
        });

        _cboSuppliers.select2('val',null);

        _cboCategories=$('#product_category').select2({
            placeholder: "Please select a category.",
            allowClear: false
        });

        _cboCategories.select2('val',null);

        _cboTaxTypes=$('#cbo_tax').select2({
            placeholder: "Please select a tax type.",
            allowClear: false
        });

        _cboTaxTypes.select2('val',null);

        _cboInventoryTypes=$('#cbo_item_type').select2({
            placeholder: "Please select an inventory type.",
            allowClear: false
        });

        _cboInventoryTypes.select2('val',null);

        _cboUnits=$('#product_unit').select2({
            placeholder: "Please select a unit.",
            allowClear: false
        });

        _cboUnits.select2('val',null);

        _cboSalesAccount=$('#income_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboSalesAccount.select2('val',0);

        _cboInventoryAccount=$('#expense_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboInventoryAccount.select2('val',0);

        _cboCOSAccounts=$('#cos_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboCOSAccounts.select2('val',0);

        _cboSRAccounts=$('#sales_return_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboSRAccounts.select2('val',0);

        _cboSDAccounts=$('#sd_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboSDAccounts.select2('val',0);

        _cboPRAccounts=$('#po_return_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboPRAccounts.select2('val',0);

        _cboPDAccounts=$('#pd_account_id').select2({
            placeholder: "Please select an account.",
            allowClear: false
        });

        _cboPDAccounts.select2('val',0);

    }();
        
    var bindEventHandlers=(function(){
        var detailRows = [];

        _cboProductTypesFilter.on("select2:select", function (e) {
            $('#tbl_products').DataTable().ajax.reload();
        });

        $("#searchbox").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        $('#mobile_no').keypress(validateNumber);
        $('#landline').keypress(validateNumber);

        $("#product_category").on("change", function () {        
            $modal = $('#modal_category_group');
            if($(this).val() === 'cat'){
                $modal.modal('show');
                _cboCategories.select2('val',null);
                clearFieldsCategory($('#frm_category_group'));
            }
        });

        var pid="";
        var refno="";
        var expdate="";
        var bid="";

        $(document).on('click','a.force_adjust_cost',function(e){
            e.preventDefault();


            pid=$(this).attr('data-prod-id');
            refno=$(this).attr('data-ref-no');
            expdate=$(this).attr('data-exp-date');
            bid=$(this).attr('data-batch-id');

            var _data=[];
            _data.push({name:"pid",value:pid});
            _data.push({name:"refno",value:refno});
            _data.push({name:"expdate",value:expdate});
            _data.push({name:"bid",value:bid});
            _data.push({name:"cost",value:$('#txt_cost_upon_invoice').val()});


            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Products/transaction/get-current-invoice-cost",
                "data":_data
            }).done(function(response){
                $('#txt_cost_upon_invoice').val(response.cost);
                $('#modal_ref_no').html(refno);
                $('#modal_update_cost').modal('show');
            });


        });

        $('#btn_update_cost').click(function(){
            var _data=[];
            _data.push({name:"pid",value:pid});
            _data.push({name:"refno",value:refno});
            _data.push({name:"expdate",value:expdate});
            _data.push({name:"bid",value:bid});
            _data.push({name:"cost",value:$('#txt_cost_upon_invoice').val()});

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Products/transaction/update-cost",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_update_cost'))
            }).done(function(response){
                showNotification(response);
                $('#modal_update_cost').modal('hide');
            });
        });


        $('#tbl_products').on('click','button.btn-export',function(){
            var _parent=$(this).closest('div#div_product_history_menu');
            var id=$(this).data('product-id');
            var start=_parent.find('.date-start').val();
            var end=_parent.find('.date-end').val();
            window.open('Products/transaction/export-product-history?id='+id+'&start=0&end=0');
        });

        // NEW PRODUCT UNIT
        $("#product_unit").on("change", function () {        
            $modal = $('#modal_unit_group');
            if($(this).val() === 'unt'){
                $modal.modal('show');
                _cboUnits.select2('val',null);
                clearFieldsUnit($('#frm_unit_group'));
            }
        });

        $("#cbo_product_type").on("change", function () {        
            $modal = $('#modal_product_type');
            if($(this).val() === 'prodtype'){
                $modal.modal('show');
                _cboProductTypes.select2('val',null);
                clearFieldsProductType($('#frm_product_type'));
            }
        });

        $("#new_supplier").on("change", function () {        
            $modal = $('#modal_new_supplier');
            if($(this).val() === 'sup'){
                $modal.modal('show');
                _cboSuppliers.select2('val',null);
                clearFieldsModal($('#frm_suppliers_new'));
            }
        });
    
        $('#btn_create_category_group').click(function(){

        var btn=$(this);

        if(validateRequiredFields($('#frm_category_group'))){
            var data=$('#frm_category_group').serializeArray();

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Categories/transaction/create",
                "data":data,
                "beforeSend" : function(){
                    showSpinningProgress(btn);
                }
            }).done(function(response){
                showNotification(response);
                $('#modal_category_group').modal('hide');

                var _group=response.row_added[0];
                $('#product_category').append('<option value="'+_group.category_id+'" selected>'+_group.category_name+'</option>');
                $('#product_category').select2('val',_group.category_id);

            }).always(function(){
                showSpinningProgress(btn);
            });
        }
    });

    $('#btn_create_unit_group').click(function(){

        var btn=$(this);

        if(validateRequiredFields($('#frm_unit_group'))){
            var data=$('#frm_unit_group').serializeArray();

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Units/transaction/create",
                "data":data,
                "beforeSend" : function(){
                    showSpinningProgress(btn);
                }
            }).done(function(response){
                showNotification(response);
                $('#modal_unit_group').modal('hide');

                var _group=response.row_added[0];
                $('#product_unit').append('<option value="'+_group.unit_id+'" selected>'+_group.unit_name+'</option>');
                $('#product_unit').select2('val',_group.unit_id);

            }).always(function(){
                showSpinningProgress(btn);
            });
        }
    });

    $('#btn_create_product_type').click(function(){

        var btn=$(this);

        if(validateRequiredFields($('#frm_product_type'))){
            var data=$('#frm_product_type').serializeArray();

            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Refproducts/transaction/create",
                "data":data,
                "beforeSend" : function(){
                    showSpinningProgress(btn);
                }
            }).done(function(response){
                showNotification(response);
                $('#modal_product_type').modal('hide');

                var _group=response.row_added[0];
                $('#cbo_product_type').append('<option value="'+_group.refproduct_id+'" selected>'+_group.product_type+'</option>');
                $('#cbo_product_type').select2('val', _group.refproduct_id);

            }).always(function(){
                showSpinningProgress(btn);
            });
        }
    });

    $('#btn_create_new_supplier').click(function(){

        var btn=$(this);

        if(validateRequiredFields($('#frm_suppliers_new'))){
            var data=$('#frm_suppliers_new').serializeArray();
            data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});

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
                $('#new_supplier').append('<option value="'+_suppliers.supplier_id+'" selected>'+_suppliers.supplier_name+'</option>');
                $('#new_supplier').select2('val', _suppliers.supplier_id);

            }).always(function(){
                showSpinningProgress(btn);
            });
        }
    });


        $('#tbl_products tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                var d=row.data();
                $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Products/transaction/product-history?id="+ d.product_id,
                    "beforeSend" : function(){
                        row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                    }
                }).done(function(response){
                    row.child( response ).show();
                    reInitializeDatePicker();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }


                });
            }
        } );

        $('#btn_new').click(function(){
            _txnMode="new";
            clearFields($('#frm_product'));
            $('#is_tax_exempt').attr('checked', false);

            _cboProductTypes.select2('val',null);
            _cboSuppliers.select2('val',null);
            _cboCategories.select2('val',null);
            _cboTaxTypes.select2('val',null);
            _cboInventoryTypes.select2('val',null);
            _cboUnits.select2('val',null);
            _cboSalesAccount.select2('val',63);
            _cboInventoryAccount.select2('val',17);
            _cboCOSAccounts.select2('val',64);
            _cboSRAccounts.select2('val',232);
            _cboSDAccounts.select2('val',288);
            _cboPRAccounts.select2('val',0);
            _cboPDAccounts.select2('val',0);
            showList(false);

        });

        $('#tbl_products tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.product_id;

             $('input,textarea,select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('#is_tax_exempt').prop('checked', (data.is_tax_exempt==1?true:false));

            _cboProductTypes.select2('val',data.refproduct_id);
            _cboSuppliers.select2('val',data.supplier_id);
            _cboCategories.select2('val',data.category_id);
            _cboTaxTypes.select2('val',data.tax_type_id);
            _cboInventoryTypes.select2('val',data.item_type_id);
            _cboUnits.select2('val',data.unit_id);
            _cboSalesAccount.select2('val',data.income_account_id);
            _cboInventoryAccount.select2('val',data.expense_account_id);
            _cboCOSAccounts.select2('val',data.cos_account_id);
            _cboSRAccounts.select2('val',data.sales_return_account_id);
            _cboSDAccounts.select2('val',data.sd_account_id);
            _cboPRAccounts.select2('val',data.po_return_account_id);
            _cboPDAccounts.select2('val',data.pd_account_id);
            showList(false);
        });

        $('input[name="purchase_cost"],input[name="markup_percent"],input[name="sale_price"]').keyup(function(){
            reComputeSRP();
        });

        $('#tbl_products tbody').on('click','button[name="remove_info"]',function(){
            $('#modal_confirmation').modal('show');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.product_id;

        });
        
        $('#btn_yes').click(function(){
            removeProduct().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

        $('#btn_cancel').click(function(){
            showList(true);
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_product'))){
                if(_txnMode=="new"){
                    createProduct().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_product'))
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }
                if(_txnMode==="edit"){
                    updateProduct().done(function(response){
                        showNotification(response);
                        if(response.stat == 'success'){
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            showList(true);
                        }
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }
            }
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
            $('#div_img_product').hide();
            $('#div_img_loader').show();
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
                if($(this).val()==0){
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

    var createProduct=function(){
        var _data=$('#frm_product').serializeArray();
       // _data.push({name : "is_tax_exempt" ,value : _isTaxExempt});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Products/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateProduct=function(){
        var _data=$('#frm_product').serializeArray();
        //_data.push({name : "is_tax_exempt" ,value : _isTaxExempt});
        _data.push({name : "product_id" ,value : _selectedID});

        return $.ajax({ 
            "dataType":"json",
            "type":"POST",
            "url":"Products/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeProduct=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Products/transaction/delete",
            "data":{product_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_product_list').show();
            $('#div_product_fields').hide();
        }else{
            $('#div_product_list').hide();
            $('#div_product_fields').show();
        }
    };

    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input,textarea,select',f).val('');
        $(f).find('input:first').focus();
        $('#is_tax_exempt',f).prop('checked', false);
        $('#img_user').attr('src','assets/img/anonymous-icon.png');
    };

    var clearFieldsModal=function(f){
        $('input,textarea,select',f).val('');
        $(f).find('input:first').focus();
        $('#img_user').attr('src','assets/img/anonymous-icon.png');
    };

    var clearFieldsCategory=function(f){
        $('#category_name').val('');
        $('#category_desc').val('');
        $(f).find('select:first').focus();
    };

    var clearFieldsUnit=function(f){
        $('#unit_name').val('');
        $('#unit_desc').val('');
        $(f).find('select:first').focus();
    };

    var clearFieldsProductType=function(f){
        $('#product_type').val('');
        $('#description').val('');
        $(f).find('select:first').focus();
    };

    var reInitializeDatePicker=function(){
        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
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

    function format ( d ) {
        return '<br /><table style="margin-left:10%;width: 80%;">' +
        '<thead>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td width="20%">Product Code : </td><td width="50%"><b>'+ d.product_code+'</b></td>' +
        '</tr>' +
        '<tr>' +
        '<td>Product Name : </td><td>'+ d.product_desc+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Product Description : </td><td>'+ d.product_desc1+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Supplier : </td><td>'+ d.supplier_name+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Product Type : </td><td>'+ d.product_type+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Category : </td><td>'+ d.category_name+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Department : </td><td>na</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Unit of Measurement : </td><td>'+ d.unit_name+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Pack Size : </td><td>'+ d.size+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Vat Exempt : </td><td>'+ d.is_tax_exempt+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Equivalent Points : </td><td>'+ d.equivalent_points+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Warn Qty : </td><td>'+ d.product_warn+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Ideal : </td><td>'+ d.product_ideal+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Purchase Cost : </td><td>'+ accounting.formatNumber(d.purchase_cost,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Markup Percent : </td><td>'+ d.markup_percent+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Sale Price : </td><td>'+ accounting.formatNumber(d.sale_price,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Whole Sale Price : </td><td>'+ accounting.formatNumber(d.whole_sale,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Retailer Price : </td><td>'+ accounting.formatNumber(d.retailer_price,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Special Discount Price : </td><td>'+ accounting.formatNumber(d.special_disc,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Valued Customer Price : </td><td>'+ accounting.formatNumber(d.valued_customer,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Discount Price : </td><td>'+ accounting.formatNumber(d.discounted_price,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Dealer Price : </td><td>'+ accounting.formatNumber(d.dealer_price,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Distributor Price : </td><td>'+ accounting.formatNumber(d.distributor_price,2)+'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Public Price : </td><td>'+ accounting.formatNumber(d.public_price,2)+'</td>' +
        '</tr>' +
        '</tbody></table><br />';
    };

    // MARKUP + PURCHASE COST
    /*var reComputeSRP=function(){
        var markupPercent=getFloat($('input[name="markup_percent"]').val());
        var purchaseAmount=getFloat($('input[name="purchase_cost"]').val());

        if(markupPercent>0){
            var markupDecimal=markupPercent/100;
            var newAmount=purchaseAmount*markupDecimal;
            var srpAmount=purchaseAmount+newAmount;
            $('input[name="sale_price"]').val(accounting.formatNumber(srpAmount,2));
        }

    };*/

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };



    $('#btn_filter').click(function(){
        if(validateRequiredFields($('#frm_filter'))){
            showSpinningProgress($('#btn_filter'));
            showProduct();
            getProduct();
            $('#modal_filter').modal('toggle');
        }
    });

    var showProduct=function(){
        $('#div_product_list').show();
    };

    var hideProduct=function(){
        $('#div_product_list').hide();
        $('#modal_filter').modal('toggle');
    };



});

</script>

</body>

</html>