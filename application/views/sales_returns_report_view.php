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
                        <li><a href="Sales_returns_report">Sales Returns Report</a></li>
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
                                                    <h2 class="h2-panel-heading">Sales Returns Report</h2>
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="date_from" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    Period End * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                                         <span class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                         </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4"><br>
                                                                        <button class="btn btn-primary pull-left" id="btn_print" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;"><i class="fa fa-print"></i>&nbsp; Print Report</button>
                                                                        <button class="btn btn-success pull-left" id="btn_excel" style="margin-right: 5px; margin-top: 0; margin-bottom: 10px;"><i class="fa fa-file-excel-o"></i>&nbsp; Export to Excel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />

                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                            <table id="tbl_pi_summary" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th>Invoice</th>
                                                                    <th>Date Invoice</th>
                                                                    <th>Date Returned</th>
                                                                    <th>Customer</th>
                                                                    <th>Product</th>
                                                                    <th>Qty</th>
                                                                    <th>Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td align="right" colspan="7">Current Page Total : </td>
                                                                        <td id="td_page_total_summary" align="right"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="right" colspan="7">Grand Total : </td>
                                                                        <td id="td_grand_total_summary" align="right"></td>
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
        var dtSummary;
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

            initializeDataTable();
        }();

        var bindEventControls=function(){
            $('#btn_print').on('click', function(){
                window.open('Sales_returns_report/transaction/print-report?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            });

            $('#btn_excel').on('click', function(){
                window.open('Sales_returns_report/transaction/export?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            });

            _date_from.on('change', function(){
                $('#tbl_pi_summary').DataTable().ajax.reload()
            });

            _date_to.on('change', function(){
               $('#tbl_pi_summary').DataTable().ajax.reload()
            });
        }();


        function initializeDataTable(){
                dtSummary=$('#tbl_pi_summary').DataTable({   
                    "bLengthChange":false,
                    "bPaginate":false,
                    oLanguage: {
                            sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                    },
                    processing : true,
                    "ajax": {
                        "url":"Sales_returns_report/transaction/list",
                        "type":"GET",
                        "bDestroy":true,
                        "data": function (d) {
                            return $.extend({}, d, {
                                "startDate":_date_from.val(),
                                "endDate":_date_to.val()
                            });
                        }
                    },
                    
                        "columns":[
                            { targets:[0],data: "inv_no" },
                            { targets:[1],data: "date_invoice" },
                            { targets:[2],data: "date_returned" },
                            { targets:[3],data: "customer_name" },
                            { targets:[4],data: "product_desc" },
                            {
                                sClass: "numericCol", 
                                targets:[7],data: "adjust_qty",
                                render: function(data,type,full,meta) {
                                    return accounting.formatNumber(data,2);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[7],data: "adjust_price",
                                render: function(data,type,full,meta) {
                                    return accounting.formatNumber(data,2);
                                }
                            },
                            {
                                sClass: "numericCol", 
                                targets:[7],data: "adjust_line_total_price",
                                render: function(data,type,full,meta) {
                                    return accounting.formatNumber(data,2);
                                }
                            }
                            
                        ],
                        "order":[[0,'asc']],

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
                                .column( 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            pageTotal = api
                                .column( 7, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            $('#td_page_total_summary').html('<b>'+accounting.formatNumber(pageTotal,2)+'</b>');
                            $('#td_grand_total_summary').html('<b>'+accounting.formatNumber(total,2)+'</b>');



                        }

                });

        };

    });
</script>


</body>

</html>