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
        .alert {
            border-width: 0;
            border-style: solid;
            padding: 24px;
            margin-bottom: 32px;
        }
        .alert-danger, .alert-danger h1, .alert-danger h2, .alert-danger h3, .alert-danger h4, .alert-danger h5, .alert-danger h6, .alert-danger small {
            color: white;
        }

        .alert-danger {
            color: #dd191d;
            background-color: #f9bdbb;
            border-color: #e84e40;
        }


        .toolbar{
            float: left;
        }

        body {
            overflow-x: hidden;
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
            z-index: 999999999;
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

        .boldlabel {
            font-weight: bold;
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

        .modal-body p {
            margin-left: 20px !important;
        }

        #img_user {
            padding-bottom: 15px;
        }

        .select2-container {
            width: 100% !important;
        }


        input[type=checkbox] {
          /* Double-sized Checkboxes */
          margin-top: 10px;
          margin-left: 10px;
          -ms-transform: scale(1.5); /* IE */
          -moz-transform: scale(1.5); /* FF */
          -webkit-transform: scale(1.5); /* Safari and Chrome */
          -o-transform: scale(1.5); /* Opera */
        }
        .right_align{
            text-align: right;
        }

        #tbl_check_list td:nth-child(6),#tbl_check_list th:nth-child(6){
            text-align: center;
        }

        button[name="print_check"]{
            padding-top: 0px!important;
            padding-bottom: 0px!important;
        }

        button[name="mark_delivered"],button[name="mark_issued"],button[name="mark_approved"] {
            padding-top: 0px!important;
            padding-bottom: 0px!important;
            font-size: 12px!important;
        }

        #tbl_check_list_filter, #tbl_for_release_filter, #tbl_delivered_filter{
            display: none;
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
    <li><a href="Treasury">Treasury</a></li>
</ol>

<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">

<div id="div_payable_list">
    <!-- <div class="col-sm-6"> -->
        <div class="panel panel-default" style="border-radius:6px;">
             <div class="panel-body panel-responsive" style="min-height: 400px;">
                <a data-toggle="collapse" data-parent="#accordionA" href="#collapseOne" style="text-decoration: none;">
                    <h2 class="h2-panel-heading"> For Approval &amp; Release</h2>
                </a>
                        <div class="row">
                                <div class="col-sm-8">
                                <button class="btn btn-green" id="btn_refresh_check_list" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Refresh" ><i class="fa fa-refresh"></i> Refresh</button>
                                </div>
                                <div class="col-sm-2">
                                    <select id="cbo_check_status">
                                        <option value="all">All</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Approved</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><input type="text" class="form-control" id="searchbox_table"> </div>
                        </div>
                        <br>
                        <div>
                            <table id="tbl_check_list" class="table table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Transaction #</th>
                                    <th>Particular</th>
                                    <th>Check Date</th>
                                    <th>Check No</th>
                                    <th>Amount</th>
                                    <th>Voucher #</th>
                                    <th>Remarks</th>
                                    <th style="width: 10px;">Release Status</th>
                                    <th><center>Action</center></th>
                                    <th><center>ID</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
             </div>
        </div>
<!--     </div>
    <div class="col-sm-6"> -->
        <div class="panel panel-primary">

            <div class="panel-body" style="min-height: 400px;">
            <h2 class="h2-panel-heading">
                Released
            </h2>
                <div class="row">
                    <div class="col-sm-8">
                        <button class="btn btn-green" id="btn_refresh_check_release" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Refresh" ><i class="fa fa-refresh"></i> Refresh</button>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="searchbox_released"> 
                    </div>
                </div>
                <br>
                <table id="tbl_for_release" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Transaction #</th>
                        <th>Particular</th>
                        <th>Check Date.</th>
                        <th>Check No.</th>
                        <th>Amount</th>
                        <th style="width: 20%;"><center>Action</center></th>
                        <th style="width: 20%;"><center>ID</center></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    <!-- </div> -->
        <div class="panel panel-primary">

            <div class="panel-body" style="min-height: 400px;">
            <h2 class="h2-panel-heading">
                Delivered
            </h2>
                <div class="row">
                    <div class="col-sm-8">
                        <button class="btn btn-green" id="btn_refresh_check_delivered" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Refresh" ><i class="fa fa-refresh"></i> Refresh</button>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="searchbox_delivered"> 
                    </div>
                </div>
                <br>
                <table id="tbl_delivered" class="table table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Transaction #</th>
                        <th>Particular</th>
                        <th  style="width: 10%">Check Date</th>
                        <th  style="width: 10%">Check No</th>
                        <th style="width: 10px;">Amount</th>
                        <th style="width: 10%"><center>ID</center></th>
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
</div> <!-- .container-fluid -->
</div> <!-- #page-content -->
</div>

<footer role="contentinfo">
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;">&copy; 2018 - JDEV OFFICE SOLUTION INC</h6></li>
        </ul>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
    </div>
</footer>

</div>
</div>
</div>


<div id="modal_check_layout" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>Select Check Layout</h4>

            </div>

            <div class="modal-body" style="padding-right: 20px;">

                <div class="row">
                        <div class="container-fluid">
                            <div class="col-xs-12">
                                <select name="check_layout" class="form-control" id="cbo_layouts">
                                    <?php foreach($layouts as $layout){ ?>
                                        <option value="<?php echo $layout->check_layout_id; ?>"><?php echo $layout->check_layout; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                </div>


            </div>

            <div class="modal-footer">
                <button id="btn_preview_check" type="button" class="btn btn-primary"  style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Preview Check</button>
                <button id="btn_close_check" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->

<div id="modal_confirmation_approval" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1 !important;"><span id="modal_mode"> </span>Check Approval Confirmation</h4>
            </div>
            <div class="modal-body" style="padding-right: 20px;">
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-xs-12">
                            Are you sure you want to approve this check for transaction# <b><span class="txn_no"></span></b>?
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_yes_approve" type="button" class="btn btn-success" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;"><span class=""></span> Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->



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
    var _txnMode; var _cboMethods; var _selectRowObj; var _selectedID; var _txnMode; var _cboCheckStatus;
    var dtReview; var cbo_refType; var _cboLayouts; var dtRecurring; var dtCheckList; var _attribute;
    var dtCheckDelivered;

    var oTBJournal={
        "dr" : "td:eq(2)",
        "cr" : "td:eq(3)"
    };

    var oTFSummary={
        "dr" : "td:eq(1)",
        "cr" : "td:eq(2)"
    };


    var initializeControls=function(){

        _cboCheckStatus=$('#cbo_check_status').select2({
            placeholder: "",
            minimumResultsForSearch : -1,
            allowClear: false
        });

        _cboCheckStatus.select2('val','all');

        dtCheckList=$('#tbl_check_list').DataTable({
            "dom": '<"print">frtip',
            "bLengthChange":false,
            "pageLength" : 7,
            "order": [[ 8, "desc" ]],
            "ajax" : {
                "url":"Treasury/transaction/get-check-list",
                "bDestroy": true,            
                "data": function ( d ) {
                    return $.extend( {}, d, {
                            "check_status_id":_cboCheckStatus.val()
                        });
                    }
            },
            "columns": [

                { targets:[0],data: "txn_no" },
                { targets:[1],data: "supplier_name"},
                { targets:[2],data: "check_date" },
                { targets:[3],data: "check_no" },
                {sClass:"right_align", targets:[4],data: "amount", render: $.fn.dataTable.render.number( ',', '.', 2) },
                { "visible": false, targets:[5],data: "ref_no" },
                { "visible": false, targets:[6],data: "remarks" },
                {  targets:[7],data: "check_status_id",
                    render: function (data, type, full, meta){
                        //alert(data.check_status);
                        if(data=="2"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }

                        return '<center><i '+_attribute+'></i></center>';
                    }
                },
                {  targets:[8],data: null,
                    render: function (data, type, full, meta){
                        var btn_check_print='<button class="btn btn-success btn-sm" name="print_check" style="margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Print Check"><i class="fa fa-print"></i> Print Check</button>';

                        var btn_mark_released="";
                        var btn_mark_approved="";

                        if(data.check_status_id == 1){
                            btn_mark_approved='<button class="btn btn-default btn-sm" name="mark_approved" style="margin-left:10px;margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Mark as Approved"><i class="fa fa-check"></i> </button>';
                        }else{
                            btn_mark_released='<button class="btn btn-success btn-sm" name="mark_issued" style="margin-left:10px;margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Mark as Released"><i class="fa fa-check"></i> </button>';
                        }

                        return '<center>'+btn_check_print+''+btn_mark_released+''+btn_mark_approved+'</center>';
                    } 
                },
                { targets:[9],data: "journal_id", visible:false },
            ]
        });
        dtCheckRelease=$('#tbl_for_release').DataTable({
            "dom": '<"print">frtip',
            "bLengthChange":false,
            "pageLength" : 7,
            "order": [[ 5, "desc" ]],
            "ajax" : "Treasury/transaction/check-for-release",
            "columns": [
                { targets:[0],data: "txn_no" },
                { targets:[1],data: "supplier_name" },
                { targets:[2],data: "check_date" },
                { targets:[3],data: "check_no" },
                {sClass:"right_align", targets:[4],data: "amount",
                render: $.fn.dataTable.render.number( ',', '.', 2)
                 },
                
                {  targets:[4],
                    render: function (data, type, full, meta){
                        var btn_check_print='<button class="btn btn-success btn-sm" name="print_check" style="margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Reprint"><i class="fa fa-print"></i> Reprint Check</button>';
                        var btn_mark_delivered='<button class="btn btn-success btn-sm" name="mark_delivered" style="margin-left:10px;margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Mark as Delivered"><i class="fa fa-check"></i> </button>';

                        return '<center>'+btn_check_print+''+btn_mark_delivered+'</center>';
                    } 
                },
                { targets:[5],data: "journal_id", visible:false },
            ]
        });

        dtCheckDelivered=$('#tbl_delivered').DataTable({
            "dom": '<"print">frtip',
            "bLengthChange":false,
            "pageLength" : 7,
            "order": [[ 4, "desc" ]],
            "ajax" : "Treasury/transaction/check-delivered",
            "columns": [
                { targets:[0],data: "txn_no" },
                { targets:[1],data: "supplier_name" },
                { targets:[2],data: "check_date" },
                { targets:[3],data: "check_no" },
                { sClass:"right_align", targets:[4],data: "amount",
                render: $.fn.dataTable.render.number( ',', '.', 2)},
                { targets:[4],data: "journal_id",visible:false }

            ]
        });



        reInitializeNumeric();


        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });

        _cboLayouts=$('#cbo_layouts').select2({
            placeholder: "Please select check layout.",
            allowClear: true
        });
        _cboLayouts.select2('val',null);


        cbo_refType=$('#cbo_refType').select2({
            placeholder: "Please select reference type.",
            allowClear: true
        });

        // _cboMethods=$('#cbo_methods').select2({
        //placeholder: "Please select method of payment.",
        //allowClear: true
        //});

        //_cboMethods.select2('val',null);
    }();



    var bindEventHandlers=function(){
        var detailRows = [];


        $('#btn_refresh_check_list').click(function(){
            dtCheckList.ajax.reload();
            dtCheckRelease.ajax.reload();
        });
        $('#btn_refresh_check_release').click(function(){
            dtCheckRelease.ajax.reload();
            dtCheckList.ajax.reload();
        });

        $('#btn_refresh_check_delivered').click(function(){
            dtCheckDelivered.ajax.reload();
        });
        $('#btn_print_check_list').on('click',function(){
            $('#modal_print_check_list_option').modal('show');
        });

        $('#btn_preview_check').click(function(){
            if ($('#cbo_layouts').select2('val') != null || $('#cbo_layouts').select2('val') != undefined)
                window.open('Templates/layout/print-check?id='+$('#cbo_layouts').val()+'&jid='+_selectedID);
            else
                showNotification({ title: 'Error', msg: 'Please select check layout!', stat: 'error' });
        });

        $('#tbl_cash_disbursement_list').on('click','button[name="print_check"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;

            $('#modal_check_layout').modal('show');
        });

        $('#tbl_for_release').on('click','button[name="print_check"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dtCheckRelease.row(_selectRowObj).data();
            _selectedID=data.journal_id;

            $('#modal_check_layout').modal('show');
        });

        $('#tbl_check_list').on('click','button[name="print_check"]',function(){


            _selectRowObj=$(this).closest('tr');
            var data=dtCheckList.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            //alert(_selectedID);
            $('#modal_check_layout').modal('show');
        });

        $('#tbl_for_release').on('click','button[name="mark_delivered"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtCheckRelease.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            markDeliveredCheck().done(function(response){
                showNotification(response);
                dtCheckRelease.row(_selectRowObj).remove().draw();   
                dtCheckDelivered.ajax.reload();         
            });
        });

        $('#tbl_check_list').on('click','button[name="mark_issued"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtCheckList.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            markReleasedCheck().done(function(response){
                showNotification(response);
                dtCheckList.row(_selectRowObj).remove().draw();   
                dtCheckRelease.ajax.reload();         
            });
        });

        $('#tbl_check_list').on('click','button[name="mark_approved"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dtCheckList.row(_selectRowObj).data();
            _selectedID=data.journal_id;

            $('.txn_no').html(data.txn_no);    
            $('#modal_confirmation_approval').modal('show');
        });        

        $('#btn_yes_approve').on('click',function(){
            markApprovedCheck().done(function(response){
                showNotification(response);
                if(response.stat == 'success'){
                    dtCheckList.row(_selectRowObj).data(response.row_updated[0]).draw();  
                }      
            });
        });

        $('#tbl_cash_disbursement_list').on('click','button[name="cancel_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.journal_id;
            $('#modal_confirmation').modal('show');
        });


        $('#btn_yes').click(function(){
            $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Cash_disbursement/transaction/cancel",
                "data":{journal_id : _selectedID},
                "success": function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }

                }
            });
        });

        _cboCheckStatus.on("select2:select", function (e) {
            dtCheckList.ajax.reload()
        });

        $("#searchbox_table").keyup(function(){         
            dtCheckList
                .search(this.value)
                .draw();
        });

        $("#searchbox_released").keyup(function(){         
            dtCheckRelease
                .search(this.value)
                .draw();
        });

        $("#searchbox_delivered").keyup(function(){         
            dtCheckDelivered
                .search(this.value)
                .draw();
        });        

        $('#tbl_entries').on('click','button.remove_account',function(){
            var oRow=$('#tbl_entries > tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals($('#tbl_entries'));

        });


        $('#btn_cancel').click(function(){
            showList(true);
        });

        $('#btn_create_new_supplier').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_suppliers_new'))){
                var data=$('#frm_suppliers_new').serializeArray();
                /*_data.push({name : "photo_path" ,value : $('img[name="img_user"]').attr('src')});*/
                createSupplier().done(function(response){
                    showNotification(response);
                    $('#modal_new_supplier').modal('hide');

                    var _suppliers=response.row_added[0];
                    $('#cbo_suppliers').append('<option value="'+_suppliers.supplier_id+'" data-tax-type="'+_suppliers.tax_type_id+'" selected>'+_suppliers.supplier_name+'</option>');
                    $('#cbo_suppliers').select2('val',_suppliers.supplier_id);
                    ///$('#cbo_tax_type').select2('val',_suppliers.tax_type_id);

                }).always(function(){
                    showSpinningProgress(btn);
                });
            }

        });

        $('#btn_browse').click(function(event){
            event.preventDefault();
            $('input[name="file_upload[]"]').click();
        });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;
            /*$('#div_img_product').hide();
            $('#div_img_loader').show();*/
            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });
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

        $('#btn_remove_photo').click(function(event){
            event.preventDefault();
            $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
        });

        $("#cbo_pay_type").change(function(){
            if($(this).val() == 2) {
                $('#check_date').prop('required',true);
                $('#check_no').prop('required',true);
            } else {
                $('#check_date').prop('required',false);
                $('#check_no').prop('required',false);
            }
        });


    }();





    //*********************************************************************8
    //              user defines


    var markDeliveredCheck=function(){

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Treasury/transaction/mark-delivered",
            "data":{journal_id : _selectedID}
        });
    };

    var markReleasedCheck=function(){

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Treasury/transaction/mark-released",
            "data":{journal_id : _selectedID}
        });
    };

    var markApprovedCheck=function(){

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Treasury/transaction/mark-approved",
            "data":{journal_id : _selectedID}
        });
    };

    var clearFields=function(f){
        $('input,textarea,select',f).val('');
        $(f).find('select').select2('val',null);



        $(f).find('input:first').focus();
        $('#tbl_entries > tbody tr').slice(2).remove();


        $('#tbl_entries > tfoot tr').find(oTFSummary.dr).html('<b>0.00</b>');
        $('#tbl_entries > tfoot tr').find(oTFSummary.cr).html('<b>0.00</b>');
    };

    //initialize numeric text
    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init');
    };


    function reInitializeSpecificDropDown(elem){
        elem.select2({
            placeholder: "Please select item.",
            allowClear: false
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

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };


    var reComputeTotals=function(tbl){
        var oRows=tbl.find('tbody tr');
        var _DR_amount=0.00; var _CR_amount=0.00;

        $.each(oRows,function(i,value){
            _DR_amount+=getFloat($(this).find(oTBJournal.dr).find('input.numeric').val());
            _CR_amount+=getFloat($(this).find(oTBJournal.cr).find('input.numeric').val());


        });



        tbl.find('tfoot tr').find(oTFSummary.dr).html('<b>'+accounting.formatNumber(_DR_amount,2)+'</b>');
        tbl.find('tfoot tr').find(oTFSummary.cr).html('<b>'+accounting.formatNumber(_CR_amount,2)+'</b>');

    };

    var getFloat=function(f){
        return parseFloat(accounting.unformat(f));
    };


    var showNotification=function(obj){
        PNotify.removeAll(); //remove all notifications
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };


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


        if(!isBalance()){
            showNotification({title:"Error!",stat:"error",msg:'Please make sure Debit and Credit is balance.'});
            stat=false;
        }

        return stat;
    };


    var isBalance=function(opTable=null){
        reComputeTotals($('#tbl_entries'));
        var oRow; var dr; var cr;

        if(opTable==null){
            oRow=$('#tbl_entries > tfoot tr');
        }else{
            oRow=$(opTable+' > tfoot tr');
        }

        dr=getFloat(oRow.find(oTFSummary.dr).text());
        cr=getFloat(oRow.find(oTFSummary.cr).text());

        return (dr==cr);
    };


    var reInitializeChildEntriesTable=function(tbl){

        var _oTblEntries=tbl.find('tbody');
        _oTblEntries.on('keyup','input.numeric',function(){
            var _oRow=$(this).closest('tr');

            if(_oTblEntries.find(oTBJournal.dr).index()===$(this).closest('td').index()){ //if true, this is Debit amount
                if(getFloat(_oRow.find(oTBJournal.dr).find('input.numeric').val())>0){
                    _oRow.find(oTBJournal.cr).find('input.numeric').val('0.00');
                }
            }else{
                if(getFloat(_oRow.find(oTBJournal.cr).find('input.numeric').val())>0) {
                    _oRow.find(oTBJournal.dr).find('input.numeric').val('0.00');
                }
            }
            reComputeTotals(tbl);
        });



        //add account button on table
        tbl.on('click','button.add_account',function(){

            var row=$('#table_hidden').find('tr');
            row.clone().insertAfter(tbl.find('tbody > tr:last'));

            reInitializeNumeric();
            reInitializeDropDownAccounts(tbl);

        });


        tbl.on('click','button.remove_account',function(){
            var oRow=tbl.find('tbody tr');

            if(oRow.length>1){
                $(this).closest('tr').remove();
            }else{
                showNotification({"title":"Error!","stat":"error","msg":"Sorry, you cannot remove all rows."});
            }

            reComputeTotals(tbl);

        });




    };
    //***************************************************************************************************************88




});


</script>

</body>

</html>