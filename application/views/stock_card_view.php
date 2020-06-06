<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>JCORE - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-cdjp-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">

    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">


    <!--<link href="assets/dropdown-enhance/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">-->

    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

    <style>
        tr.group,
        tr.group:hover {
            background-color: #eaeaea !important;
        }

        div.dataTables_filter input { 
            margin-top: -5px;
            margin-left: 760px;
        }

        .numericCol {
            text-align: right;
        }

        .toolbar{
            float: left;
        }

        td:nth-child(6),td:nth-child(7){
            text-align: right;
        }

        td:nth-child(8){
            text-align: right;
            font-weight: bolder;
        }
        .class-title{
            font-weight: bold;
        }
        a {
            color:#333333;
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

                    <ol class="breadcrumb" style="margin-bottom: 0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Stock_card">Stock Card Report</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="div_payable_list">

                                        <div class="panel-group panel-default" id="accordionA">
                                            <div class="panel panel-default" style="border-radius: 6px;border: 1px solid #eeeeee;min-height: 670px;">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Stock Card Report</h2>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <div class="row">
                                                                <div class="col-lg-8">
                                                                    Product Type * :<br/>
                                                                    <select id="cboProduct" class="form-control">
                                                                        <?php foreach($products as $product) { ?>
                                                                            <option value="<?php echo $product->product_id; ?>">
                                                                                <?php echo $product->product_desc; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="date_from" class="date-picker form-control" value="01/01/<?php echo date("Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-2">
                                                                    Period End * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;">
                                                        <table style="width: 100%;margin-bottom:0px!important;" class="table table-striped">
                                                            <tr>
                                                                <td style="width: 15%;" class="class-title">Product Code</td>
                                                                <td style="width: 35%;" id="product_code"></td>
                                                                <td  style="width: 15%;" class="class-title">Purchase Cost</td>
                                                                <td  style="width: 35%;" id="purchase_cost"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 15%;" class="class-title">Product Description</td>
                                                                <td style="width: 35%;" id="product_desc"></td>

                                                                <td  style="width: 15%;" class="class-title">Suggested Retail Price</td>
                                                                <td  style="width: 35%;" id="sale_price"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 15%;" class="class-title">Unit of Measurement</td>
                                                                <td style="width: 35%;" id="unit_of_measurement"></td>

                                                                <td  style="width: 15%;" class="class-title">Current Inventory Stock</td>
                                                                <td  style="width: 35%;" id="current_inventory_stock"></td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                        <br>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <button class="btn btn-success pull-left" id="btn_excel" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;"><i class="fa fa-file-excel-o"></i>&nbsp; Export to Excel
                                                            </button>

                                                            <table id="tbl_products" class="table table-striped" cellspacing="0" width="100%">
                                                                <tbody>
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
                            </div>
                        </div>
                    </div>
                </div> <!-- .container-fluid -->
            </div> <!-- #page-content -->
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


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- Select2-->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!---<script src="assets/plugins/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>-->

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- numeric formatter -->
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        var cbo_product;
        var dtProducts;
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');

         var initializeControls=function() {
            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            cbo_product = $('#cboProduct').select2({
                placeholder: "Please Select a Product",
                allowClear: true
            });

            cbo_product.select2('val',1);

            initializeDataTable();
        }();

        var bindEventControls=function(){
            $('#btn_excel').on('click', function(){
                window.open('Products/transaction/export-product-history?id='+cbo_product.val()+'&start='+_date_from.val()+'&end='+_date_to.val());
            });

            cbo_product.on('select2:select', function(){
                initializeDataTable();
            });

            _date_from.on('change', function(){
                initializeDataTable();
            });

            _date_to.on('change', function(){
                initializeDataTable();
            });
        }();

       
        function initializeDataTable(){
            $.ajax({
                "url":"Products/transaction/list-single?id="+cbo_product.val(),
                type : "GET",
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
            }).done(function(response){
                var data = response.data[0];
                $('#product_desc').html(data.product_desc);
                $('#unit_of_measurement').html(data.unit_name);
                $('#purchase_cost').html(accounting.formatNumber(data.purchase_cost,2));
                $('#sale_price').html(accounting.formatNumber(data.sale_price,2));
                $('#product_code').html(data.product_code);
                $('#current_inventory_stock').html(accounting.formatNumber(response.onhand.balance,2));
            });

            $.ajax({
                "dataType":"html",
                "type":"POST",
                "url":"Stock_card/transaction/stock-history?id="+cbo_product.val()+'&startDate='+_date_from.val()+'&endDate='+_date_to.val(),
            }).done(function(response){
                $('#tbl_products > tbody').html(response);
            });

        };

    });
</script>


</body>

</html>