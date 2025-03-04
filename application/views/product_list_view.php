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


    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <style>


        .select2-container{
            min-width: 100%;
            z-index: 99999999;
        }

    </style>


</head>
<body>
<?php echo $_top_navigation; ?>
<div id="wrapper">
    <div id="layout-static">
        <?php echo $_side_bar_navigation;?>
        <div class="static-content-wrapper white-bg">
            <div class="static-content">
                <div class="page-content">
                    <div id="modal_inventory" class="modal fade" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header modal-erp">
                                    <h4 class="modal-title" style="color: white;">Product Inventory Report</h4>
                                </div>
                                <div class="modal-body">


                                    <div class="row">
                                        <div class="col-sm-12">
                                            Branch : <br />
                                            <select name="department" id="cbo_departments" data-error-msg="Branch is required." required>
                                                <option value="0">ALL DEPARTMENTS</option>
                                                <?php foreach($departments as $department){ ?>
                                                    <option value="<?php echo $department->department_id; ?>">
                                                        <?php echo $department->department_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <br />

                                    <div class="row">
                                        <div class="col-sm-12">
                                            Report : <br />
                                            <select name="report" id="cbo_report" data-error-msg="Branch is required." required>
                                                <option value="1">Group by product type</option>
                                                <option value="2">List</option>
                                            </select>
                                        </div>
                                    </div>

                                    <br />

                                    <div class="row">
                                        <div class="col-sm-12">
                                            Product Type : <br />
                                            <select name="report" id="cboProductType">

                                                <?php foreach($product_types as $type){ ?>
                                                <option value="<?php echo $type->refproduct_id; ?>"><?php echo $type->product_type; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <br />

                                    <div class="row">
                                        <div class="col-sm-12">
                                            Suppliers : <br />
                                            <select name="report" id="cboSuppliers">
                                                <option value="0">All Suppliers</option>
                                                <?php foreach($suppliers as $supplier){ ?>
                                                    <option value="<?php echo $supplier->supplier_id; ?>"><?php echo $supplier->supplier_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <br />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            Status : <br />
                                            <select name="status" id="cbo_status" data-error-msg="Branch is required." required>
                                                <option value="-1">All Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br/>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="chk_show_all" value="1"> <label for="chk_show_all" style="font-weight: normal;">Show Items with 0 Qty</label>
                                        </div>
                                    </div>

                                    <br />


                                    <div class="row">
                                        <div class="col-sm-12">
                                            As of Date : <br />
                                            <div class="input-group" style="z-index: 99999">

                                                <input type="text" name="date_filter" id="dt_date_filter" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>" placeholder="Date Due" data-error-msg="Please set the date this items are issued!" required>

                                                <span class="input-group-addon">
                                                     <i class="fa fa-calendar"></i>
                                                </span>

                                            </div>
                                        </div>
                                    </div><br />








                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <!-- <button id="btn_print" class="btn btn-primary">Print</button> -->
                                            <button id="btn_export" class="btn btn-success">Export to Excel</button>
                                            <button class="btn btn-red" data-dismiss="modal">Close</button>
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
</body>


<?php echo $_def_js_files; ?>

<?php echo $_switcher_settings; ?>


<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>




<script>
    $(document).ready(function(){
        var _cboDepartments; var _cboReport; var _cboSuppliers; var _cboStatus;




        var bindEventHandlers=function(){
            $('#modal_inventory').modal('show');

            $('#btn_print').click(function(){

                //if($('#cbo_report').val()==1){
                    window.open('Templates/layout/inventory?type=preview&date='+$('#dt_date_filter').val()+'&format='+$('#cbo_report').val());

                //}else{
                   // window.open('Templates/layout/inventory?type=preview&date='+$('#dt_date_filter').val()+'$format='+$('#cbo_report').val());
                //}

            });

            $('#btn_export').click(function(){
                window.open('Product_list/transaction/export?date='+$('#dt_date_filter').val()+'&type_id='+$('#cboProductType').select2('val')+'&show_all='+$('#chk_show_all:checked').val()+'&depid='+_cboDepartments.select2('val')+'&supid='+_cboSuppliers.select2('val')+'&status='+_cboStatus.select2('val'));
            });


        }();

        var initializeControls=function(){
            _cboDepartments=$("#cbo_departments").select2({
                placeholder: "Please select branch.",
                allowClear: false,
                enabled: false
            });

            _cboDepartments.select2("val",0);

            // _cboDepartments.select2("enable",false);

            _cboSuppliers=$("#cboSuppliers").select2({
                placeholder: "Please select supplier.",
                allowClear: false,
                enabled: false
            });

            _cboSuppliers.select2("val",0);

            _cboStatus=$("#cbo_status").select2({
                placeholder: "Please select Status.",
                allowClear: false,
                enabled: false
            });

            _cboStatus.select2("val",1);

            _cboReport=$("#cbo_report").select2({
                placeholder: "Please select type.",
                allowClear: false
            });

            _cboReport.select2('enable',false);


            _cboProdType=$("#cboProductType").select2({
                placeholder: "Please product type.",
                allowClear: false
            });

            _cboProdType.select2('val',3);


            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true

            });

        }();

    });
</script>
</html>

