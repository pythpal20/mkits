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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
    <!-- load css library -->
</head>

<body onload="blinkText();">
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Order (CO)</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" id="back">Customer</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>History</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <?php 
                error_reporting(0);
                $id = $_GET['id'];
                $qry = "SELECT * FROM master_customer a 
                JOIN master_wilayah b ON a.customer_kota = b.wilayah_id
                WHERE a.customer_id = '$id'";
                $mwk = $db1->prepare($qry);
                $mwk->execute();
                $rests = $mwk->get_result();
                $row = $rests->fetch_assoc();

                $ct1 = "SELECT COUNT(No_Co) AS totalPo FROM customerorder_hdr WHERE customer_id = '$id'";
                $mwk = $db1->prepare($ct1);
                $mwk -> execute();
                $hsl = $mwk->get_result();
                $ct = $hsl->fetch_assoc();

                $ct2 = "SELECT SUM(b.harga_total) AS totalAmt FROM customerorder_hdr a
                JOIN customerorder_dtl b ON a.No_Co = b.No_Co
                WHERE a.customer_id = '$id' GROUP BY a.customer_id";
                $mwk = $db1->prepare($ct2);
                $mwk -> execute();
                $hsl = $mwk->get_result();
                $cta = $hsl->fetch_assoc();

                $ct3 = "SELECT count(noso) AS totalSco FROM salesorder_hdr WHERE customer_id = '$id'";
                $mwk = $db1->prepare($ct3);
                $mwk -> execute();
                $hsl = $mwk->get_result();
                $ctb = $hsl->fetch_assoc();
            ?>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th width="30%">ID Register</th>
                                        <td>:</td>
                                        <td> <?php echo $row['customer_idregister']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td>:</td>
                                        <td> <?php echo $row['customer_nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td> <?php echo $row['customer_alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kota</th>
                                        <td>:</td>
                                        <td> <?php echo $row['wilayah_nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>TOP</th>
                                        <td>:</td>
                                        <td> <?php echo $row['term']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox">
                            <div class="ibox-content">
                                <table class="table-striped" width="100%">
                                    <tr>
                                        <th>Total PO</th>
                                        <td>:</td>
                                        <td> <?php echo $ct['totalPo']; ?> PO</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>:</td>
                                        <td> <?php echo 'Rp. ' . number_format($cta['totalAmt'],0,",",".") .',-'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total SCO</th>
                                        <td>:</td>
                                        <td> <?php echo $ctb['totalSco']; ?> SCO</td>
                                    </tr>
                                </table>
                                <br>
                                <!--<div class="btn-group">-->
                                <!--    <button class="btn btn-sm btn-info grapik" name="grapik"><span class="fa fa-bar-chart-o"></span> Lihat dalam Grafik</button>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span class="fa fa-folder-o"></span> FA List</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span class="fa fa-folder-open-o"></span> Item List</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span class="fa fa-folder-open-o"></span> History Item</a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span class="fa fa-history"></span> History Update <sup class="label label-info label-xs" id="blink">NEW</sup></a></li>
                                <li><a class="nav-link tab5" data-toggle="tab" href="#tab-5" id="tab5"><span class="fa fa-history"></span> ALL SKU <sup class="label label-warning label-xs" id="blink">NEW</sup></a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <table class="table-striped display" style="width:100%;" id="tablePo">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority ="1">No. Inv</th>
                                                    <th>Tgl. Inv</th>
                                                    <th>No. SO</th>
                                                    <th>No. CO</th>
                                                    <th>Sales</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Total Harga</th>
                                                    <th data-priority = "2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table-striped display" style="width:100%;" id="tblItem">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. Inv</th>
                                                    <th>No. SO</th>
                                                    <th>Tgl. Order</th>
                                                    <th style="width: 15%;" data-priority ="1">SKU</th>
                                                    <th>Qty.</th>
                                                    <th data-priority ="2">Harga/pcs</th>
                                                    <th>Disc</th>
                                                    <th>PPN</th>
                                                    <th>Amount</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-bordered table-striped display" style="width:100%;"
                                            id="history">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="width: 15%;">SKU</th>
                                                    <th colspan="12" style="text-align: center;">Qty Item / Month</th>
                                                </tr>
                                                <tr>
                                                    <th>Jan</th>
                                                    <th>Feb</th>
                                                    <th>Mar</th>
                                                    <th>Apr</th>
                                                    <th>Mei</th>
                                                    <th>Jun</th>
                                                    <th>Juli</th>
                                                    <th>Ags</th>
                                                    <th>Sep</th>
                                                    <th>Okt</th>
                                                    <th>Nov</th>
                                                    <th>Des</th>
                                                </tr>
                                            </thead>
                                        </table>
                                         <b>Note* : History item berdasarkan data CO</b>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-borderless table-striped display" style="width:100%;"
                                            id="updateHistory">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tgl Update</th>
                                                    <th>Update By</th>
                                                    <th>View Detail</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-panel">
                                    <div class="panel-body">
                                        <table id="tablexs" data-toggle="tablexs" data-url="../serverside/joinSku.php?id=<?= $_GET['id'] ?>" data-show-toggle="true" data-search="true" data-show-columns="true" data-id-field="model" data-show-print="true" data-show-export="true" width="100%" data-fixed-columns="true" data-fixed-number="1" data-show-print="true" data-show-export="true" data-pagination="true" data-show-refresh="true">
                                            <thead>
                                                <tr>
                                                    <th data-field="model" rowspan="2" data-valign="middle" data-width="1000">Model/ SKU</th>
                                                    <th colspan="3">Januari</th>
                                                    <th colspan="3">Februari</th>
                                                    <th colspan="3">Maret</th>
                                                    <th colspan="3">April</th>
                                                    <th colspan="3">Mei</th>
                                                    <th colspan="3">Juni</th>
                                                    <th colspan="3">Juli</th>
                                                    <th colspan="3">Agustus</th>
                                                    <th colspan="3">September</th>
                                                    <th colspan="3">Oktober</th>
                                                    <th colspan="3">November</th>
                                                    <th colspan="3">Desember</th>
                                                </tr>
                                                <tr>
                                                    <th data-field="Jan" data-sortable="true">SCO</th>
                                                    <th data-field="Jan2" data-sortable="true">CO</th>
                                                    <th data-field="Jan3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Feb" data-sortable="true">SCO</th>
                                                    <th data-field="Feb2" data-sortable="true">CO</th>
                                                    <th data-field="Feb3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Mar" data-sortable="true">SCO</th>
                                                    <th data-field="Mar2" data-sortable="true">CO</th>
                                                    <th data-field="Mar3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Apr" data-sortable="true">SCO</th>
                                                    <th data-field="Apr2" data-sortable="true">CO</th>
                                                    <th data-field="Apr3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Mei" data-sortable="true">SCO</th>
                                                    <th data-field="Mei2" data-sortable="true">CO</th>
                                                    <th data-field="Mei3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Jun" data-sortable="true">SCO</th>
                                                    <th data-field="Jun2" data-sortable="true">CO</th>
                                                    <th data-field="Jun3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Jul" data-sortable="true">SCO</th>
                                                    <th data-field="Jul2" data-sortable="true">CO</th>
                                                    <th data-field="Jul3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Ags" data-sortable="true">SCO</th>
                                                    <th data-field="Ags2" data-sortable="true">CO</th>
                                                    <th data-field="Ags3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Sep" data-sortable="true">SCO</th>
                                                    <th data-field="Sep2" data-sortable="true">CO</th>
                                                    <th data-field="Sep3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Okt" data-sortable="true">SCO</th>
                                                    <th data-field="Okt2" data-sortable="true">CO</th>
                                                    <th data-field="Okt3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Nov" data-sortable="true">SCO</th>
                                                    <th data-field="Nov2" data-sortable="true">CO</th>
                                                    <th data-field="Nov3" data-sortable="true">CO Krm</th>

                                                    <th data-field="Des" data-sortable="true">SCO</th>
                                                    <th data-field="Des2" data-sortable="true">CO</th>
                                                    <th data-field="Des3" data-sortable="true">CO Krm</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/print/bootstrap-table-print.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script>
    
    <script>
    $(document).ready(() => {
        $("#back").click(() => {
            window.history.back();
        });
        
        $("#tablexs").bootstrapTable();
    });
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        $.fn.dataTable.tables({
                visible: true,
                api: true
            })
            .columns.adjust()
            .responsive.recalc()
            .draw();
    });
    $(document).ready(function() {
        document.getElementById('mastercustomer').className = 'active';
        var table = $('#tablePo').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/historyCO.php?ide=<?php echo $_GET['id']; ?>",
            columnDefs: [{
                    "targets": 7,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                },
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-primary btn-xs detail' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span> View</button></center>"
                }
            ]
        });

        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tablePo tbody').on('click', '.detail', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/detail_co.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#DetailView').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
    });

    $(document).ready(function() {
        var tables = $('#tblItem').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/historyitem.php?ide=<?php echo $_GET['id']; ?>",
            columnDefs: [{
                    "targets": 10,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                },{
                    "targets": 8,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                },
                {
                    "targets": 9,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }, {
                    "targets": 6,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }
            ],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    title: 'History Item <?= $row["customer_nama"] ?>'
                },
                {
                    extend: 'excel',
                    title: 'ExampleFile'
                },
                {
                    extend: 'pdf',
                    title: 'ExampleFile'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    title: 'History Item <?= $row["customer_nama"] ?>'
                }
            ]
        });
        tables.on('draw.dt', function() {
            var info = tables.page.info();
            tables.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
    });
    $(document).ready(function() {
        var table3 = $('#history').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/skulistforcustomer.php?idcustomer=<?php echo $_GET['id']; ?>",
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    title: 'History Item <?= $row["customer_nama"] ?>'
                },
                {
                    extend: 'excel',
                    title: 'ExampleFile'
                },
                {
                    extend: 'pdf',
                    title: 'ExampleFile'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    title: 'History Item <?= $row["customer_nama"] ?>'
                }
            ]
        });
    });
    $(document).ready(function() {
        var table4 = $('#updateHistory').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/historyUpdate.php?id=<?php echo $_GET['id']; ?>",
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'> View</span></button> </center>"
            }]
        });
    });
    </script>
</body>
<div id="viewDetail" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="DetailView">

            </div>
        </div>
    </div>
</div>

</html>