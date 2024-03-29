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
    <li><a href="Open_sales">Open Sales</a></li>
</ol>


<div class="container-fluid"">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">

<div id="div_delivery_list">
    <div class="panel panel-default">
        <div class="panel-body table-responsive" style="overflow-x: hidden;">
            <h2 style="margin-bottom: 0;" class="h2-panel-heading"> Open Sales Report</h2><hr>
            <div class="row">
                <div class="col-lg-4">&nbsp; <br>
                <button class="btn btn-primary pull-left"  id="btn_print" title="Print">
                    <i class="fa fa-print"></i> Print Report
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-success pull-left" id="btn_export" title="Export" style="margin-left: 5px;">
                    <i class="fa fa-file-excel-o"></i> Export Report
                </button>
                </div>
                <div class="col-lg-4">
                    Customer :<br />
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="0">ALL</option>
                        <?php foreach($customers as $customer) {?>
                            <option value="<?php echo $customer->customer_id;?>">
                                <?php echo $customer->customer_name;?>
                            </option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-lg-4">
                    Search :<br />
                        <input type="text" id="searchbox_tbl_delivery_invoice" class="form-control">
                </div>
            </div><br>
            <table id="tbl_delivery_invoice" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
          
                    <th>Sales Order No.</th>
                    <th>Date</th>
                    <th>Product Code</th>
                    <th>Product Desription</th>
                    <th>Product Type</th>
                    <th>Order QTY</th>
                    <th>Delivered</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="panel-footer"></div>
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
    var dt; var _selectedID; var _selectRowObj; var _cboCustomer;

    var initializeControls=function(){
        _cboCustomer=$('#customer_id').select2({
            placeholder: "Please select customer.",
            allowClear: false
        });

        _cboCustomer.select2('val', 0);

        dt=$('#tbl_delivery_invoice').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "language": {
                "searchPlaceholder":"Search"
            },
            "ajax": {
                "url": "Open_sales/transaction/list",
                "type": "POST",
                "bDestroy": true,
                "data": function ( d ) {
                    return $.extend( {}, d, {
                        "customer_id": _cboCustomer.select2('val')
                    });
                }
            },
            "columns": [
                {
                    targets:[0],data: "so_no" 
                },
                { targets:[1],data: "last_invoice_date" },
                { targets:[2],data: "product_code" },
                { targets:[3],data: "product_desc" },
                { targets:[4],data: "product_type" },
                { targets:[5],data: "SoQtyTotal" },
                { targets:[6],data: "SoQtyDelivered" },
                { targets:[7],data: "SoQtyBalance" },
                { 
                    visible: false,
                    targets:[8],data: "customer_name" 
                }
            ],
            "order": [[ 0, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                api.column(0, {page:'current'} ).data().each( function ( group, i, data ) {
                    if ( last !== group ) {
                        var customer_name = api.rows( {page:'current'} ).data()[i].customer_name
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="8" style="background-color:orange;"><strong>'+'Sales Order #: <i>'+group+'</i> | Customer : <i>'+customer_name+'</i></strong></td></tr>'
                        );
                        last = group;
                    }
                } );
            }
        });

    }();






    var bindEventHandlers=(function(){
        var detailRows = [];

        $("#searchbox_tbl_delivery_invoice").keyup(function(){         
            dt
                .search(this.value)
                .draw();
        });

        _cboCustomer.on("select2:select", function (e) {
            $('#tbl_delivery_invoice').DataTable().ajax.reload();
        });

        $('#btn_print').click(function(){
            window.open('Open_sales/transaction/report');
        });

        $('#btn_export').on('click', function() {
            window.open('Open_sales/transaction/export','_self');
        });


    })();

});




</script>


</body>


</html>