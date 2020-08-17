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
        select{ width: 100%; }
        #tbl_audit_trail_filter{display: none;}
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
                        <li><a href="Sales_returns_report">Audit Trail</a></li>
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
                                                    <h2 class="h2-panel-heading">Audit Trail</h2><hr>
                                                            <div class="row">
                                                                <div class="col-sm-3" >
                                                                    Transaction Type :
                                                                    <select name="" id="trans_type_id" required>
                                                                        <option value="">All Transaction Types</option>
                                                                        <?php foreach($trans_type as $row) { echo '<option value="'.$row->trans_type_id.'">'.$row->trans_type_desc.'</option>'; } ?>
                                                                    </select>

                                                                </div>
                                                                <div class="col-sm-2" >
                                                                    Record Type :
                                                                    <select name="" id="trans_key_id"  required>
                                                                        <option value="">All Record Types</option>
                                                                        <?php foreach($trans_key as $row) { echo '<option value="'.$row->trans_key_id.'">'.$row->trans_key_desc.'</option>'; } ?>
                                                                    </select>

                                                                </div>
                                                                <div class="col-lg-2">
                                                                    Period Start * :<br />
                                                                    <div class="input-group">
                                                                        <input type="text" name="date_from" class="date-picker form-control" value="<?php echo date("m").'/01/'.date("Y"); ?>">
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
                                                                <div class="col-sm-3" >
                                                                    User Account:
                                                                    <select name="" id="user_id"  required>
                                                                        <option value="">All User Accounts</option>
                                                                        <?php foreach($users as $row) { echo '<option value="'.$row->user_id.'">'.$row->user_name.' - '.$row->full_name.'</option>'; } ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        <br />
                                                        <div style="border: 1px solid #a0a4a5;padding: 1%;border-radius: 5px;padding-bottom: 2%;">
                                                        <div class="">
                                                            <input type="text" class="form-control" placeholder="Search" name="" id="tbl_audit_trail_search">
                                                        </div><br>
                                                            <table id="tbl_audit_trail" class="table table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th width="15%">Transaction Date</th>
                                                                    <th width="20%">Transaction Type</th>
                                                                    <th width="10%">Record Type</th>
                                                                    <th width="35%">Log Description</th>
                                                                    <th width="20%">User</th>
                                                                </tr>
                                                                </thead>
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
        var _trans_type_id;
        var _trans_key_id;
         var initializeControls=function() {
            $('.date-picker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            _trans_type_id=$('#trans_type_id').select2({
                allowClear: false
            });


            _trans_key_id=$('#trans_key_id').select2({
                allowClear: false
            });

            _user_id=$('#user_id').select2({
                allowClear: false
            });


            initializeDataTable();
        }();

        var bindEventControls=function(){
            // $('#btn_print').on('click', function(){
            //     window.open('Sales_returns_report/transaction/print-report?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            // });

            // $('#btn_excel').on('click', function(){
            //     window.open('Sales_returns_report/transaction/export?startDate='+_date_from.val()+'&endDate='+_date_to.val());
            // });


            _date_from.on('change', function(){
                $('#tbl_audit_trail').DataTable().ajax.reload()
            });

            _date_to.on('change', function(){
               $('#tbl_audit_trail').DataTable().ajax.reload()
            });

            
            _trans_key_id.on('change', function(){
               $('#tbl_audit_trail').DataTable().ajax.reload()
            });

            _trans_type_id.on('change', function(){
               $('#tbl_audit_trail').DataTable().ajax.reload()
            });

            _user_id.on('change', function(){
               $('#tbl_audit_trail').DataTable().ajax.reload()
            });            

            $("#tbl_audit_trail_search").keyup(function(){         
                dtSummary
                    .search(this.value)
                    .draw();
            });


        }();


        function initializeDataTable(){
                dtSummary=$('#tbl_audit_trail').DataTable({   
                    "bLengthChange":false,
                    oLanguage: {
                            sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
                    },
                    processing : true,
                    "ajax": {
                        "url":"Audit_trail/transaction/list",
                        "type":"GET",
                        "bDestroy":true,
                        "data": function (d) {
                            return $.extend({}, d, {
                                "user_id": $('#user_id').val(),
                                "startDate":_date_from.val(),
                                "endDate":_date_to.val(),
                                "trans_type_id": $('#trans_type_id').val(),
                                "trans_key_id": $('#trans_key_id').val(),
                            });
                        }
                    },
                    
                        "columns":[
                            { targets:[0],data: "date_time" },
                            { targets:[1],data: "trans_type_desc" },
                            { targets:[2],data: "trans_key_desc" },
                            { targets:[3],data: "message" },
                            { targets:[4],data: "username" },
                            
                        ],
                });

        };

    });
</script>


</body>

</html>