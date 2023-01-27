<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu'])){
        header("Location: ../index.php");
    }
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'template/load_css.php';?>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
    <!-- load css library -->
      <style>
    /* Ensure that the demo table scrolls */
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Status BL</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="infosco.php">Status SCO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Info Monitoring</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="col-sm-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Data Monitoring</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="">
                                <table data-toggle="table" data-url="../serverside/tabelmonitoring.php"  data-pagination="true" data-search="true" class="stripe row-border order-column" id="tabelmonitoring" width="100%">
                                    <thead>
                                        <tr>
                                        <!--    <th style=" " rowspan="2" data-priority="1">No. BL </th>-->
                                        <!--    <th style=" " rowspan="2">No. SCO</th>-->
                                        <!--    <th style=" " rowspan="2">PT.</th>-->
                                        <!--    <th style=" " rowspan="2" data-priority="2">Customer</th>-->
                                        <!--    <th style=" " rowspan="2">Sales</th>-->
                                        <!--    <th colspan="2">Akunting</th>-->
                                        <!--    <th colspan="2">CO</th>-->
                                        <!--    <th colspan="2">Terkirim</th-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <th>By</th>-->
                                        <!--    <th>Tgl.</th>-->
                                        <!--    <th>By</th>-->
                                        <!--    <th>Tgl.</th>-->
                                        <!--    <th>Kenek</th>-->
                                        <!--    <th>Supir</th>-->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <!-- Footer -->
     <?php include 'template/load_js.php'; ?>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <!-- load js library -->
    <script src="DataScript/infomonitoring.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/print/bootstrap-table-print.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
    <script>
    //  $.fn.dataTable
    //     .tables( { visible: true, api: true } )
    //     .columns.adjust();
    //  $(document).ready(function() {
    //     var table = $('#tabelmonitoring').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": "../serverside/tabelmonitoring.php",
    //         "fixedColumns": true,
    //         "scrollY": 400,
    //         "scrollX": true,
    //         "scrollCollapse": true,
    //         "paging": true,
    //         "columnDefs": [{
    //             "targets": 13,
    //             "render": function(data, row) {
    //                 if (data === '0') {
    //                     return '<span class="label label-success">Lunas</span>'
    //                 } else if (data === 'Belum Bayar') {
    //                     return '<span class="label label-warning">Belum Bayar</span>'
    //                 } else {
    //                     return '<span class="label label-danger">' + data + '</span>'
    //                 }
    //             }
    //         }]
    //     });
    // });
    </script>
    <!--<script>-->
    <!--$(document).ready(function() {-->
    <!--    document.getElementById('statusbl').setAttribute('class', 'active');-->
    <!--    $('.exportData').click(function() {-->
    <!--        $('#exportData').modal('show');-->
    <!--    });-->
    <!--    $('.fullexport').click(function() {-->
    <!--        $('#ModalExprt').modal('show');-->
    <!--    });-->
    <!--});-->
    <!--</script>-->
</body>
</html>