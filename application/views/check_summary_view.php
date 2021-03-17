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


        #tbl_check_list_filter{
            display: none;
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

        .select2-container {
            width: 100% !important;
        }

        .right_align_items{
        	text-align: right;
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
        #tbl_accounts_receivable_filter{
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
<div class="static-content">
<div class="page-content"><!-- #page-content -->
<div class="container-fluid">
<div data-widget-group="group1">
<div class="row">
<div class="col-md-12">
<div id="div_payable_list">
    <div class="panel panel-default" style="border-radius:6px;margin-top: 20px;">
        <div class="panel-body">
            <h2 class="h2-panel-heading">Check Summary</h2><hr />
            <div class="row">
                <div class="col-lg-3">
                    <br/>
                    <button class="btn btn-primary" id="btn_print_check_list" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Print list"><i class="fa fa-print"></i> Print</button>
                    <button class="btn btn-success" id="btn_excel_check_list" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Download Excel list"><i class="fa fa-file-excel-o"></i> Export</button>
                    <button class="btn btn-default" id="btn_refresh_check_list" style="text-transform: none;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Refresh"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
                <div class="col-lg-2">
                    From :<br />
                    <div class="input-group">
                        <input type="text" id="txt_start_date" name="" class="date-picker form-control" value="<?php echo date("m") ?>/01/<?php echo date("Y") ?>">
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
                    Bank :<br />
                    <select id="cbo_banks" class="form-control" name="bank_id">
                    <option value="all">All Banks</option>
                    <option value="0">None</option>
                    <?php foreach($banks as $bank){ ?>
                        <option value='<?php echo $bank->bank_id; ?>'><?php echo $bank->bank_name.' - ('.$bank->account_no.')'; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                        Search :<br />
                         <input type="text" id="searchbox_check" class="form-control">
                </div>
            </div><br>
            <div>
                <table id="tbl_check_list" class="table table-striped" cellspacing="0" width="100%">
                    <thead style="display:none;">
                    <tr>
                        <th>Bank</th>
                        <th>Check #</th>
                        <th style="text-align: right!important;">Amount</th>
                        <th>Check Date</th>
                        <th>Voucher #</th>
                        <th>Particular</th>
                        <th width="15%">Remarks</th>
                        <th>Issued</th>
                        <th width="5%"><center>Action</center></th>
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

<div id="modal_check_layout" class="modal fade" role="dialog"><!--modal-->
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

<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/ellipsis.js"></script>
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

    var _cboCheckTypes; var dtCheckList; var _cboLayouts; var _selectedTypeID;

    var initializeControls=function(){

        _cboCheckTypes=$('#cbo_banks').select2({
            placeholder: "Please Select Check Type",
            allowClear:false
        });
        
        _cboCheckTypes.select2('val','all');

        _cboLayouts=$('#cbo_layouts').select2({
            placeholder: "Please select check layout.",
            allowClear: false
        });
        _cboLayouts.select2('val',null);        

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        dtCheckList=$('#tbl_check_list').DataTable({
            "dom": '<"toolbar">frtip',
            "bLengthChange":false,
            "pageLength" : 10,
            oLanguage: {
                    sProcessing: '<center><br /><img src="assets/img/loader/ajax-loader-sm.gif" /><br /><br /></center>'
            },
            processing : true,
            "ajax" : {
                "url" : "Check_summary/transaction/get-check-list",
                "bDestroy": true,            
                "data": function ( d ) {
                        return $.extend( {}, d, {
                            "bank_id": _cboCheckTypes.val(),
                            "start_date": $('#txt_start_date').val(),
                            "end_date": $('#txt_end_date').val()
                        });
                    }
            }, 
            "columnDefs": [
                { "visible": false, "targets": 0 }
            ],
            "columns": [

                { targets:[0],data: "bank" },
                { targets:[1],data: "check_no" },
                { sClass: 'text-right',targets:[2],data: "amount",
                    render: function(data, type, full, meta){
                        return accounting.formatNumber(data,2);
                    }
                },
                { targets:[3],data: "check_date" },
                { targets:[4],data: "ref_no" },
                { targets:[5],data: "supplier_name" },
                { targets:[6],data: "remarks" , render: $.fn.dataTable.render.ellipsis(40) },
                {  targets:[7],data: "check_status",
                    render: function (data, type, full, meta){
                        //alert(data.check_status);
                        if(data=="1"){
                            _attribute=' class="fa fa-check-circle" style="color:green;" ';
                        }else{
                            _attribute=' class="fa fa-times-circle" style="color:red;" ';
                        }

                        return '<center><i '+_attribute+'></i></center>';
                    }
                },
                {  targets:[8],
                    render: function (data, type, full, meta){
                        var btn_check_print='<button class="btn btn-success btn-sm" name="print_check" style="margin-right:0px;text-transform: none;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-print"></i> </button>';
                        return '<center>'+btn_check_print+'</center>';
                    } }
            ],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last!== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group" style="background-color: #7add58;"><td colspan="8" align="left"><b style="text-transform: capitalize;font-size: 15px;color:white;"><i class="fa fa-bars"></i> '+group+'</b></td></tr>' +
                            '<tr class="group">'+
                                    '<td><b>Check #</b></td>'+
                            '<td><b>Amount</b></td>'+
                                    '<td><b>Check Date</b></td>'+
                                    '<td><b>Voucher #</b></td>'+
                                    '<td><b>Particular</b></td>'+
                                    '<td><b>Remarks</b></td>'+
                                    '<td align="center"><b>Issued</b></td>'+
                                    '<td><center>Action</center></td>'+
                            '</tr>'
                        );

                        last = group;
                    }
                } );
            }
        });
    }();



    var bindEventHandlers=function(){

        var detailRows = [];

        _cboCheckTypes.on("select2:select", function (e) {
            $('#tbl_check_list').DataTable().ajax.reload();
       });

        $('#btn_refresh_check_list').click(function(){
            $('#tbl_check_list').DataTable().ajax.reload();
        });

        $('#txt_start_date').on('change', function(){
            $('#tbl_check_list').DataTable().ajax.reload();
        });

        $('#txt_end_date').on('change', function(){
            $('#tbl_check_list').DataTable().ajax.reload();
        });

        $("#searchbox_check").keyup(function(){         
            dtCheckList
                .search(this.value)
                .draw();
        });

        $('#btn_print_check_list').click(function(){
            window.open('Check_summary/transaction/print-check-list?bank='+$('#cbo_banks').val()+'&start='+$('#txt_start_date').val()+"&end="+$('#txt_end_date').val());
        });

        $('#btn_excel_check_list').on('click', function() {
            window.open('Check_summary/transaction/export-check-list?bank='+$('#cbo_banks').val()+'&start='+$('#txt_start_date').val()+"&end="+$('#txt_end_date').val());
        });           

        $('#tbl_check_list').on('click','button[name="print_check"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dtCheckList.row(_selectRowObj).data();
            _selectedID=data.journal_id;

            $('#modal_check_layout').modal('show');
        });

        $('#btn_preview_check').click(function(){
            if ($('#cbo_layouts').select2('val') != null || $('#cbo_layouts').select2('val') != undefined){
                window.open('Templates/layout/print-check?id='+$('#cbo_layouts').val()+'&jid='+_selectedID);
            }
            else{
                showNotification({ title: 'Error', msg: 'Please select check layout!', stat: 'error' });
            }
        });

    }();

    var showList=function(b){
        if(b){
            $('#div_payable_list').show();
            $('#div_payable_fields').hide();
        }else{
            $('#div_payable_list').hide();
            $('#div_payable_fields').show();
        }
    };

    //initialize numeric text
    function reInitializeNumeric(){
        $('.numeric').autoNumeric('init');
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

        return stat;
    };


});

</script>
</body>
</html>