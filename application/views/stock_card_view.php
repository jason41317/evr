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
/*        a {
            color:#333333;
        }*/
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
                                                                <div class="col-lg-5">
                                                                    Product * :<br/>
                                                                    <select id="cboProduct" class="form-control">
                                                                        <?php foreach($products as $product) { ?>
                                                                            <option value="<?php echo $product->product_id; ?>">
                                                                                <?php echo $product->product_desc; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    Branch * :<br/>
                                                                    <select id="cbo_department" class="form-control">
                                                                        <option value="0">All Branches</option>
                                                                        <?php foreach($departments as $department) { ?>
                                                                            <option value="<?php echo $department->department_id; ?>">
                                                                                <?php echo $department->department_name; ?>
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
                        <button id="btn_update_cost" type="button" class="btn" style="background-color:#2ecc71;color:white;"><span></span> Update</button>
                        <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal" style="padding: 2px 7px!important;">Cancel</button>
                    </div>
                </div><!---content-->
            </div>
        </div><!---modal-->


    </div>
</div>
</div>








<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>
<?php echo $_rights; ?>

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
        var _cboDepartments;
        var dtProducts;
        var _date_from = $('input[name="date_from"]');
        var _date_to = $('input[name="date_to"]');

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
                allowClear: false
            });

            cbo_product.select2('val',1);

            _cboDepartments = $('#cbo_department').select2({
                placeholder: "Please Select a department",
                allowClear: false
            });

            _cboDepartments.select2('val',default_department_id);

            initializeDataTable();
        }();

        var bindEventControls=function(){
            $('#btn_excel').on('click', function(){
                window.open('Products/transaction/export-product-history?id='+cbo_product.val()+'&start='+_date_from.val()+'&end='+_date_to.val()+'&depid='+_cboDepartments.val());
            });

            cbo_product.on('select2:select', function(){
                initializeDataTable();
            });

            _cboDepartments.on('select2:select', function(){
                initializeDataTable();
            });

            _date_from.on('change', function(){
                initializeDataTable();
            });

            _date_to.on('change', function(){
                initializeDataTable();
            });
        }();

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };

        var showNotification=function(obj){
            PNotify.removeAll();
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };
       
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
                "url":"Stock_card/transaction/stock-history?id="+cbo_product.val()+'&startDate='+_date_from.val()+'&endDate='+_date_to.val()+'&depid='+_cboDepartments.val(),
            }).done(function(response){
                $('#tbl_products > tbody').html(response);
            });

        };

    });
</script>


</body>

</html>