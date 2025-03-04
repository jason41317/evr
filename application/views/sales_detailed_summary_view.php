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
        div.dataTables_filter input { 
            margin-top: 10px;
        }

        .toolbar{
            float: left;
        }

        td:nth-child(5),td:nth-child(6){
            text-align: right;
        }

        td:nth-child(7){
            text-align: right;
            font-weight: bolder;
        }

        .numeriCol {
            text-align: right;
        }

        .select2-container{
            min-width: 100%;
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
                        <li><a href="Sales_detailed_summary">Sales Detailed summary</a></li>
                    </ol>

                    <div class="container-fluid">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="div_payable_list">
                                        <div class="panel-group panel-default" id="accordionA">
                                            <div class="panel panel-default" style="border-radius: 6px;border: 1px solid lightgrey;min-height: 670px;">
                                                <div id="collapseTwo" class="collapse in">
                                                    <div class="panel-body">
                                                    <h2 class="h2-panel-heading">Sales Report</h2>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <div class="row">

                                                                <div class="col-lg-3">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_from" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    Period End * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" id="txt_date" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <br />
                                                        <div class="tab-container tab-top tab-primary">
                                                            <ul class="nav nav-tabs">
                                                                <li id="btn_customer" class="active">
                                                                    <a data-toggle="tab" href="#customers">Customers</a>
                                                                </li>
                                                                <li id="btn_salesperson">
                                                                    <a data-toggle="tab" href="#vet_rep">Salespersons</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div id="customers" class="tab-pane fade in active">
                                                                    <strong>Search Customers :</strong><br>
                                                                    <select id="cbo_customers" class="form-control" style="width: 100%;">
                                                                        <option value="all">[All Customers]</option>
                                                                        <?php foreach($customers as $customer) { ?>
                                                                            <option value="<?php echo $customer->customer_id; ?>"><?php echo $customer->customer_name; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print_customer_report" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Print Summary Report (All Customers)">
                                                                    <i class="fa fa-print"></i> Summary Report</button>
                                                                    <button class="btn btn-success pull-left" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; margin-top: 10px; margin-bottom: 10px;" title="Reload" >
                                                                    <i class="fa fa-refresh"></i></button>
                                                                    <table id="tbl_account_subsidiary" style="margin-top: 10px;" class="table table-striped" cellspacing="0" width="100%">
                                                                        <thead class="">
                                                                        <tr>
                                                                            <th>Customer</th>
                                                                            <th>Contact</th>
                                                                            <th>Email</th>
                                                                            <th>Address</th>
                                                                            <th>Total Invoice</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <td align="right" colspan="4">Current Page Total : </td>
                                                                                <td id="td_page_total" align="right"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" colspan="4">Grand Total : </td>
                                                                                <td id="td_grand_total" align="right"></td>
                                                                            </tr>

                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                                <div id="vet_rep" class="tab-pane fade">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <strong>Search Salesperson :</strong><br>
                                                                            <select id="cbo_salesperson" class="form-control" style="width: 100%;">
                                                                                <option value="all">[All Salesperson]</option>
                                                                                <?php foreach($salespersons as $salesperson) { ?>
                                                                                    <option value="<?php echo $salesperson->salesperson_id; ?>"><?php echo $salesperson->salesperson_name; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <strong>Search Product Type :</strong><br>
                                                                            <select id="cbo_product_type" class="form-control" style="width: 100%;">
                                                                                <option value="all">[All]</option>
                                                                                <?php foreach($product_types as $product_type) { ?>
                                                                                    <option value="<?php echo $product_type->refproduct_id; ?>"><?php echo $product_type->product_type; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <strong>Search Supplier :</strong><br>
                                                                            <select id="cbo_supplier" class="form-control" style="width: 100%;">
                                                                                <option value="all">[All Supplier]</option>
                                                                                <?php foreach($suppliers as $supplier) { ?>
                                                                                    <option value="<?php echo $supplier->supplier_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                    <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print_salesperson_report" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Print" >
                                                                    <i class="fa fa-print"></i> Detailed Report</button>
                                                                    <button class="btn btn-primary pull-left" style="margin-right: 5px; margin-top: 10px; margin-bottom: 10px;" id="btn_print_salesperson_report_summary" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " title="Print" >
                                                                    <i class="fa fa-print"></i> Summary Report</button>
                                                                    <button class="btn btn-success pull-left" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; margin-top: 10px; margin-bottom: 10px;" data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >
                                                                    <i class="fa fa-refresh"></i></button>
                                                                    <table id="tbl_salespersons" style="margin-top: 10px;" class="table table-striped" cellspacing="0" width="100%">
                                                                        <thead class="">
                                                                        <tr>
                                                                            <th>Salesperson</th>
                                                                            <th width="20%" style="text-align: right;">Total Invoice</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>

                                                                        <tfoot>
                                                                            <tr>
                                                                                <td align="right" colspan="">Current Page Total : </td>
                                                                                <td id="td_page_total_sp" align="right"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" colspan="">Grand Total : </td>
                                                                                <td id="td_grand_total_sp" align="right"></td>
                                                                            </tr>

                                                                        </tfoot>
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
                    </div>
                </div> <!-- .container-fluid -->
            </div> <!-- #page-content -->
        </div>

        <footer role="contentinfo">
            <div class="clearfix">
                <ul class="list-unstyled list-inline pull-left">
                    <li><h6 style="margin: 0;">&copy; 2017 - JDEV IT Business Solutions</h6></li>
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
        var _cboAccounts; var dt; var _cboCustomers; var _cboSalesperson; var _cboProductType; var _cboSupplier;
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');


        var initializeControls=function(){

            _cboSalesperson = $('#cbo_salesperson').select2({
                placeholder: 'Please Select Salesperson',
                allowClear: true
            });

            _cboProductType = $('#cbo_product_type').select2({
                placeholder: 'Please Select Product Type',
                allowClear: true
            });

            _cboSupplier = $('#cbo_supplier').select2({
                placeholder: 'Please Select Supplier',
                allowClear: true
            });

            _cboCustomers = $('#cbo_customers').select2({
                placeholder: 'Please Select Customer',
                allowClear: true
            });

            _cboSalesperson.select2('val','all');
            _cboProductType.select2('val','all');
            _cboSupplier.select2('val','all');
            _cboCustomers.select2('val', 'all');

            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

            reloadList();
            reloadSalespersonList();

            //createToolBarButton();



        }();

        var bindEventControls=function(){
            $('#btn_print_salesperson_report').on('click', function(){
                window.open('Sales_detailed_summary/transaction/summary-report-vet-rep?startDate='+_date_from.val()+'&endDate='+_date_to.val()+'&sp_id='+_cboSalesperson.val());
            });

            $('#btn_print_salesperson_report_summary').on('click', function(){
                window.open('Sales_detailed_summary/transaction/summary-report-vet-rep-summary?startDate='+_date_from.val()+'&endDate='+_date_to.val()+'&sp_id='+_cboSalesperson.val());
            });

            $('.date-picker').on('change',function(){
                dt.destroy();
                reloadList();
            });

            $('#btn_salesperson').on('click', function(){
                reloadSalespersonList();
            });

            $('#btn_customer').on('click', function(){
                reloadList();
            });

            _cboCustomers.on("select2:select", function (e) {
                dt.destroy();
                reloadList();
            });

            _cboSalesperson.on("select2:select", function (e) {
                dtSalesperson.destroy();
                reloadSalespersonList();
            });

            _cboProductType.on("select2:select", function (e) {
                dtSalesperson.destroy();
                reloadSalespersonList();
            });

            _cboSupplier.on("select2:select", function (e) {
                dtSalesperson.destroy();
                reloadSalespersonList();
            });

            $(document).on('click','#btn_print_customer_report',function(){
                window.open('Sales_detailed_summary/transaction/summary-report?startDate='+_date_from.val()+'&endDate='+_date_to.val()+'&cus_id='+_cboCustomers.val());
            });

            $(document).on('click','#btn_refresh',function(){
                dt.destroy();
                reloadList();
                //createToolBarButton();
            });


        }();

        // function createToolBarButton(){
        //     var _btnPrint='<button class="btn btn-primary" id="btn_print" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Print" >'+
        //         '<i class="fa fa-print"></i> Print Report</button>';

        //     var _btnRefresh='<button class="btn btn-success" id="btn_refresh" style="text-transform: none; font-family: Tahoma, Georgia, Serif; " data-toggle="modal" data-target="#salesInvoice" data-placement="left" title="Reload" >'+
        //         '<i class="fa fa-refresh"></i></button>';

        //     $("div.toolbar").html(_btnPrint+"&nbsp;"+_btnRefresh);
        // };

        function reloadSalespersonList(){
            dtSalesperson=$('#tbl_salespersons').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "bDestroy":true,
                "bPaginate":false,
                "ajax": {
                    "url": "Sales_detailed_summary/transaction/per-salesperson-sales",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "startDate":_date_from.val(),
                            "endDate":_date_to.val(),
                            "sp_id":_cboSalesperson.val(),
                            "pt_id": _cboProductType.val(),
                            "supp_id": _cboSupplier.val()
                        });
                    }
                },
                "columns": [
                    { targets:[0],data: "salesperson_name" },
                    {
                        className: "numeriCol",
                        targets:[1],data:
                        "total_amount_invoice",
                        render: function(data){
                            return '<b>'+accounting.formatNumber(data,4)+'</b>';
                        }
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 1 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 1, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                     $('#td_page_total_sp').html('<b>'+accounting.formatNumber(pageTotal,4)+'</b>');
                    $('#td_grand_total_sp').html('<b>'+accounting.formatNumber(total,4)+'</b>');



                }

            });
        };

        function reloadList(){
            dt=$('#tbl_account_subsidiary').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "bDestroy":true,
                "bPaginate":false,
                "ajax": {
                    "url": "Sales_detailed_summary/transaction/per-customer-sales",
                    "type": "GET",
                    "bDestroy": true,
                    "data": function ( d ) {
                        return $.extend( {}, d, {
                            "startDate":_date_from.val(),
                            "endDate":_date_to.val(),
                            "cus_id":_cboCustomers.val()
                        });
                    }
                },
                "columns": [
                    { targets:[0],data: "customer_name" },
                    { targets:[1],data: "contact_no" },
                    { targets:[2],data: "email_address" },
                    { targets:[3],data: "address" },
                    {
                        targets:[4],data:
                        "total_amount_invoice",
                        render: function(data){
                            return '<b>'+accounting.formatNumber(data,4)+'</b>';
                        }
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                     $('#td_page_total').html('<b>'+accounting.formatNumber(pageTotal,4)+'</b>');
                    $('#td_grand_total').html('<b>'+accounting.formatNumber(total,4)+'</b>');



                }

            });
        };





    });
</script>


</body>

</html>