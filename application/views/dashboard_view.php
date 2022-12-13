<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
<head>
    <meta charset="utf-8">
    <title>JCORE</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">


   <?php echo $_def_css_files; ?>

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">


    <style>
    .data-container {
          border-radius: 5px;
        background: rgba(255, 255, 255, .1);
        padding: 10px;
        border:1px solid #d4dbdd;
    }

    .toolbar{
        float: left;
    }

    .btn-white {
        background: white none repeat scroll 0 0;
        border: 1px solid #e7eaec;
        color: inherit;
        text-transform: none;
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

    @keyframes spin {
        from { transform: scale(1) rotate(0deg); }
        to { transform: scale(1) rotate(360deg); }
    }

    @-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg); }
        to { -webkit-transform: rotate(360deg); }
    }
 .v-timeline {
          position: relative;
          padding: 0;
          margin-top: 2em;
          margin-bottom: 2em;
      }
      .vertical-container {
          width: 98%;
          margin: 0 auto;
      }

      .v-timeline::before {
          content: '';
          position: absolute;
          top: 0;
          left: 18px;
          height: 100%;
          width: 4px;
          background: #525252;
      }

      .vertical-timeline-block:first-child {
        margin-top: 0;
      }

      .vertical-timeline-block {
          position: relative;
          margin: 2em 0;
      }

      .vertical-timeline-icon {
          position: absolute;
          top: 0;
          left: 0;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          font-size: 16px;
          border: 1px solid #525252;
          text-align: center;
          background: #525252;
          color: #ffffff;
      }

      .vertical-timeline-icon i {
          display: block;
          width: 24px;
          height: 24px;
          position: relative;
          left: 50%;
          top: 50%;
          margin-left: -12px;
          margin-top: -9px;
      }

      .c-accent {
          color: #f6a821;
      }

      .vertical-timeline-content {
          position: relative;
          margin-left: 60px;
/*          background-color: rgba(68, 70, 79, 0.5);*/
          border-radius: 0.25em;
          border: 1px solid #3d404c;
      }

      .vertical-timeline-content:before {
          border-color: transparent;
          border-right-color: #3d404c;
          border-width: 11px;
          margin-top: -11px;
      }

      .vertical-timeline-content:after, .vertical-timeline-content:before {
          right: 100%;
          top: 20px;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none;
      }

      .p-sm {
          padding: 15px !important;
      }

      .vertical-timeline-content .vertical-date {
          font-weight: 500;
          text-align: right;
      }

      .vertical-timeline-content p {
          margin: 1em 0 0 0;
          line-height: 1.6;
      }

      .vertical-timeline-content:after {
          border-color: transparent;
          border-right-color: #3d404c;
          border-width: 10px;
          margin-top: -10px;
      }

      .vertical-timeline-content:after, .vertical-timeline-content:before {
          right: 100%;
          top: 20px;
          border: solid transparent;
          content: " ";
          height: 0;
          width: 0;
          position: absolute;
          pointer-events: none;
      }

      .vertical-timeline-content:after {
          content: "";
          display: table;
          clear: both;
      }

      .vertical-timeline-content {
          position: relative;
          margin-left: 60px;
/*          background-color: rgba(68, 70, 79, 0.5);*/
          border-radius: 0.25em;
          border: 1px solid #3d404c;
      }

      .vertical-timeline-block:after {
          content: "";
          display: table;
          clear: both;
      }

      .vertical-container::after {
          content: '';
          display: table;
          clear: both;
      }

      .v-timeline {
          position: relative;
          padding: 0;
          margin-top: 2em;
          margin-bottom: 2em;
      }

      .vertical-container {
          width: 98%;
          margin: 0 auto;
      }
    </style>

</head>

<body class="animated-content" style="font-family: tahoma;">

<?php echo $_top_navigation; ?>

<div id="wrapper">
        <div id="layout-static">
        <?php echo $_side_bar_navigation; ?>


        <div class="static-content-wrapper">
            <div class="static-content"  >
                    <div class="page-content"><!-- #page-content -->


                        <div class="container-fluid" style="margin-top: 10px;">
                            <div data-widget-group="group1">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel panel-default" style="border-top: 3px solid #2196f3;">

                                            <div class="panel-body table-responsive">
                                            <h2>Company Snapshot</h2>
                                                <div class="row">


                                                    <div class="col-sm-4">
                                                        <br />
                                                        <small>
                                                            Income (Current Month)
                                                        </small>
                                                        <h2 class="m-b-xs">
                                                            <?php echo number_format($income_current_month,2); ?>
                                                        </h2>
                                                        <div id="sparkline1" class="m-b-sm"></div>
                                                        <div class="row">
                                                            <div class="col-xs-4">
                                                                <small class="stats-label">This Day</small>
                                                                <h4><?php echo number_format($income_this_day,2); ?></h4>
                                                            </div>

                                                            <div class="col-xs-4">
                                                                <small class="stats-label">Yesterday</small>
                                                                <h4><?php echo number_format($income_yesterday,2); ?></h4>
                                                            </div>
                                                            <div class="col-xs-4">
                                                                <small class="stats-label">Last week</small>
                                                                <h4><?php echo number_format($income_last_week,2); ?></h4>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <br />
                                                        <small>
                                                            Income (last month)

                                                        </small>
                                                        <h2 class="m-b-xs">
                                                            <?php echo number_format($income_last_month,2); ?>
                                                        </h2>

                                                        <div id="sparkline2" class="m-b-sm"></div>
                                                        <div class="row">
                                                            <div class="col-xs-4">
                                                                <small class="stats-label">This Day</small>
                                                                <h4><?php echo number_format($this_day_percentage,0); ?>%</h4>
                                                            </div>

                                                            <div class="col-xs-4">
                                                                <small class="stats-label">Yesterday</small>
                                                                <h4><?php echo number_format($yesterday_percentage,0); ?>%
                                                                </h4>
                                                            </div>
                                                            <div class="col-xs-4">
                                                                <small class="stats-label">Last week</small>
                                                                <h4><?php echo number_format($last_week_percentage,0); ?>%</h4>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4">
<br />
                                                        <div class="row m-t-xs">
                                                            <div class="col-xs-6">
                                                                <small>Income (last year)</small>
                                                                <h2 class="no-margins"><?php echo number_format($income_last_year,2); ?></h2>
                                                                <div class="font-bold text-navy"><?php echo $last_year_income_percentage; ?>% <i class="fa fa-bolt"></i></div>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <small>Income (current year)</small>
                                                                <h2 class="no-margins"><?php echo number_format($income_this_year,2); ?></h2>
                                                                <div class="font-bold text-navy"><?php echo $this_year_income_percentage; ?>% <i class="fa fa-bolt"></i></div>
                                                            </div>
                                                        </div>


                                                        <table class="table small m-t-sm">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <strong><?php echo number_format($total_last_year_client,0); ?></strong> Clients

                                                                </td>
                                                                <td>
                                                                    <strong><?php echo number_format($total_current_year_client,0); ?></strong> Clients
                                                                </td>

                                                            </tr>


                                                            </tbody>
                                                        </table>



                                                    </div>

                                                </div>

                                                <br /><br />

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <center><small>Income (current year) vs Income (previous year)</small></center><br />

                                                        <div>
                                                            <canvas id="lineChart" height="140"></canvas>
                                                        </div>
                                                    </div>




                                                    <div class="col-lg-6">
                                                        <center><small class="text-navy">Income vs Expense (current year)</small></center><br />
                                                        <div>
                                                            <canvas id="barChart" height="140"></canvas>
                                                        </div>
                                                    </div>


                                                </div>








                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


<!--                         <div class="container-fluid mt-n">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-xs-12   <?php echo ($this->session->user_group_id != 1 ? 'col-sm-12' : 'col-sm-8'); ?>">

                                    <div class="panel panel-default <?php //echo (in_array('7-1',$this->session->user_rights)?'':'hidden'); ?>">
                                        <div class="panel-heading">
                                            <h2>Purchase Order for Approval</h2>
                                        </div>


                                        <div class="panel-body table-responsive" style="border-top: 3px solid #2196f3;">
                                        <h2>Purchase Order for Approval</h2>
                                            <table id="tbl_po_list" class="table table-striped" cellspacing="0" width="100%">
                                                <thead class="">
                                                <tr>
                                                    <th></th>
                                                    <th><i class="fa fa-code"></i> PO#</th>
                                                    <th><i class="fa fa-users"></i> Vendor</th>
                                                    <th><i class="fa fa-calendar"></i> Terms </th>
                                                    <th><i class="fa fa-users"></i> Posted by </th>
                                                    <th style="text-align: center;"> <i class="fa fa-paperclip"></i></th>
                                                    <th><center>Action</center></th>
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
 -->

                    <div class="container-fluid mt-n">
                        <div data-widget-group="group1">
                            <div class="row">
                                <div class="col-xs-12   <?php echo ($this->session->user_group_id != 1 ? 'col-sm-12' : 'col-sm-8'); ?>">

                                    <div class="row" style="margin-left: 1px;">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="border-top: 3px solid #2196f3;">
                                            <h2>Adjustment In for Approval</h2>
                                                <table id="tbl_adjustment_in_list" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead class="">
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th width="15%">Adjustment #</th>
                                                        <th width="15%">Type</th>
                                                        <th width="15%">Invoice</th>
                                                        <th width="15%">Branch</th>
                                                        <th width="10%"><center>Action</center></th>
                                                        <th>ID</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-left: 1px;">
                                        <div class="panel panel-default">
                                            <div class="panel-body table-responsive" style="border-top: 3px solid #2196f3;">
                                            <h2>Adjustment Out for Approval</h2>
                                                <table id="tbl_adjustment_out_list" class="table table-striped" cellspacing="0" width="100%">
                                                    <thead class="">
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th>Adjustment #</th>
                                                        <th>Branch</th>
                                                        <th width="30%">Remarks</th>
                                                        <th class="align-center">Adjustment</th>
                                                        <th><center>Action</center></th>
                                                        <th>ID</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 <?php echo ($this->session->user_group_id == 1 ? 'col-sm-4' : 'hidden' ); ?>">
                                  <div id="style-1" class="data-container" style="min-height: 700px; max-height: 700px; overflow-y: scroll;">
                                    <h3><i class="fa fa-rss" style="color: #067cb2;;"></i> ACTIVITY FEED</h3>
                                    <div class="v-timeline vertical-container">
                                        <?php echo ($this->session->user_group_id != 1 ? '' : $news_feed); ?>
                                    </div>
                                  </div>
                                </div>

                            </div>
                        </div>
                    </div>


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



<!-- Sparkline -->
<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- CHART -->
<script src="assets/plugins/chartJs/Chart.min.js"></script>

<!-- DATATABLE -->
<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>



<script>
    (function() {

        var sparklineCharts = function(){
            $("#sparkline1").sparkline([124, 43, 43, 35, 44, 32, 44, 52,134, 43, 43, 35, 44, 32, 44, 52,124, 43, 43, 35, 44, 32, 44, 52,134, 43, 43, 35, 44, 32, 44, 52], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });

            $("#sparkline2").sparkline([32, 11, 25, 37, 41, 32, 34, 42], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });

            $("#sparkline3").sparkline([34, 22, 24, 41, 10, 18, 16,8], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1C84C6',
                fillColor: "transparent"
            });
        };

        var sparkResize;

        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineCharts, 500);
        });

        sparklineCharts();




        var data1 = [
            [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,20],[11,10],[12,13],[13,4],[14,7],[15,8],[16,12]
        ];
        var data2 = [
            [0,0],[1,2],[2,7],[3,4],[4,11],[5,4],[6,2],[7,5],[8,11],[9,5],[10,4],[11,1],[12,5],[13,2],[14,5],[15,2],[16,0]
        ];
        $("#flot-dashboard5-chart").length && $.plot($("#flot-dashboard5-chart"), [
                data1,  data2
            ],
            {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,

                    borderWidth: 2,
                    color: 'transparent'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis:{
                },
                yaxis: {
                },
                tooltip: false
            }
        );



        var lineData = {
            labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
            datasets: [
                {
                    label: "Example dataset",
                    fillColor: "rgba(220,220,220,0.5)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: <?php echo json_encode($previous_year_income_monthly); ?>
                },
                {
                    label: "Example dataset",
                    fillColor: "rgba(26,179,148,0.5)",
                    strokeColor: "rgba(26,179,148,0.7)",
                    pointColor: "rgba(26,179,148,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: <?php echo json_encode($current_year_income_monthly); ?>
                }
            ]
        };

        var lineOptions = {
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            bezierCurve: true,
            bezierCurveTension: 0.4,
            pointDot: true,
            pointDotRadius: 4,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 20,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,
            responsive: true,
        };


        var ctx = document.getElementById("lineChart").getContext("2d");
        var myNewChart = new Chart(ctx).Line(lineData, lineOptions);



    })();
</script>

<script>
    var barData = {
        labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data: <?php echo json_encode($expense_monthly); ?>
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.8)",
                highlightFill: "rgba(26,179,148,0.75)",
                highlightStroke: "rgba(26,179,148,1)",
                data: <?php echo json_encode($current_year_income_monthly); ?>
            }
        ]
    };

    var barOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        responsive: true
    }


    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);
</script>

<script>

    $(document).ready(function(){
        var dt; var dtAI; var dtAO; var _selectedID; var _selectRowObj;

        var initializeControls=(function(){
             dtAI=$('#tbl_adjustment_in_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "pageLength":5,
                "ajax" : {
                    "url" : "Adjustments/transaction/list-for-approved",
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "adjustment_code" },
                    { targets:[2],data: "trans_type" },
                    { targets:[3],data: "inv_no" },
                    { targets:[4],data: "department_name" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_ai"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approved this Adjustment"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    },
                    {visible:false, sClass: "align-center" ,targets:[6],data: "adjustment_id" },
                ]

            });

            dtAO=$('#tbl_adjustment_out_list').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "pageLength":5,
                "ajax" : {
                    "url" : "Adjustment_out/transaction/list-for-approved",
                },
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "adjustment_code" },
                    { targets:[2],data: "department_name" },
                    { targets:[3],data: "remarks" },
                    { sClass:"align-center", targets:[4],data: "adjustment_type" },
                    {
                        targets:[5],
                        render: function (data, type, full, meta){
                            var btn_approved='<button class="btn btn-success btn-sm" name="approve_ao"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Approved this Adjustment"><i class="fa fa-check" style="color: white;"></i> <span class=""></span></button>';

                            return '<center>'+btn_approved+'</center>';
                        }
                    },
                    { visible:false, targets:[6],data: "adjustment_id" },
                ]

            });
        })();


        var bindEventHandlers=(function(){


            var detailRows = [];

            $('#tbl_adjustment_in_list > tbody').on('click','button[name="approve_ai"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dtAI.row(_selectRowObj).data();
                _selectedID=data.adjustment_id;

                approveAdjustmentIn().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        console.log("True");
                        dtAI.row(_selectRowObj).remove().draw();
                    }

                });
            });


            $('#tbl_adjustment_out_list > tbody').on('click','button[name="approve_ao"]',function(){
            // showNotification({title:"Approving PO and Sending Email!",stat:"info",msg:"Please wait for a few seconds."});
                _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

                var data=dtAO.row(_selectRowObj).data();
                _selectedID=data.adjustment_id;

                approveAdjustmentOut().done(function(response){
                    showNotification(response);
                    if(response.stat=="success"){
                        console.log("True");
                        dtAO.row(_selectRowObj).remove().draw();
                    }

                });
            });

            $('#tbl_adjustment_in_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtAI.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    //console.log(row.data());
                    var d=row.data();

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/adjustments/"+ d.adjustment_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response ).show();
                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });
                }
            });

            $('#tbl_adjustment_out_list tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dtAO.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    //console.log(row.data());
                    var d=row.data();

                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Templates/layout/adjustments/"+ d.adjustment_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response ).show();
                        // Add to the 'open' array
                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });
                }
            });

            // $('#tbl_po_list tbody').on( 'click', 'tr td.details-control', function () {
            //     var tr = $(this).closest('tr');
            //     var row = dt.row( tr );
            //     var idx = $.inArray( tr.attr('id'), detailRows );

            //     if ( row.child.isShown() ) {
            //         tr.removeClass( 'details' );
            //         row.child.hide();

            //         // Remove from the 'open' array
            //         detailRows.splice( idx, 1 );
            //     }
            //     else {
            //         tr.addClass( 'details' );
            //         //console.log(row.data());
            //         var d=row.data();

            //         $.ajax({
            //             "dataType":"html",
            //             "type":"POST",
            //             "url":"Templates/layout/po/"+ d.purchase_order_id+'?type=approval',
            //             "beforeSend" : function(){
            //                 row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
            //             }
            //         }).done(function(response){
            //             row.child( response ).show();
            //             // Add to the 'open' array
            //             if ( idx === -1 ) {
            //                 detailRows.push( tr.attr('id') );
            //             }
            //         });




            //     }
            // } );


            //*****************************************************************************************
            // $('#tbl_po_list > tbody').on('click','button[name="approve_po"]',function(){
            //     _selectRowObj=$(this).closest('tr'); //hold dom of tr which is selected

            //     var data=dt.row(_selectRowObj).data();
            //     _selectedID=data.purchase_order_id;

            //      approvePurchaseOrder().done(function(response){
            //         showNotification(response);
            //         if(response.stat=="success"){
            //             dt.row(_selectRowObj).remove().draw();
            //         }

            //     });
            // });


            //****************************************************************************************
            // $('#tbl_po_list > tbody').on('click','button[name="mark_as_approved"]',function(){
            //     _selectRowObj=$(this).parents('tr').prev();
            //     _selectRowObj.find('button[name="approve_po"]').click();
            //     showSpinningProgress($(this));
            // });


            //****************************************************************************************
            // $('#tbl_po_list > tbody').on('click','button[name="external_link_conversation"]',function(){
            //     _selectRowObj=$(this).parents('tr').prev();
            //     _selectRowObj.find('#link_conversation').trigger("click");
            //     //alert(_selectRowObj.find('a[id="link_conversation"]').length);
            // });




        })();


        //functions called on bindEventHandlers
        // var approvePurchaseOrder=function(){
        //     return $.ajax({
        //         "dataType":"json",
        //         "type":"POST",
        //         "url":"Purchases/transaction/mark-approved",
        //         "data":{purchase_order_id : _selectedID}

        //     });
        // };

        //functions called on bindEventHandlers
        var approveAdjustmentIn=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Adjustments/transaction/mark-approved",
                "data":{adjustment_id : _selectedID}

            });
        };

        //functions called on bindEventHandlers
        var approveAdjustmentOut=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"Adjustment_out/transaction/mark-approved",
                "data":{adjustment_id : _selectedID}

            });
        };

        var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };

        var showSpinningProgress=function(e){
            $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
        };



    });


</script>



</body>


</html>