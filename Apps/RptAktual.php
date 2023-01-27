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
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <div class="row border-bottom white-bg page-heading">
                <!-- || -->
                <div class="col-lg-10">
                    <h2>Pick Ticket Sample Aktual</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="datasample.php">Pick ticket Sample</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Aktual</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- || -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php if($data['modul'] == '1' || $data['modul'] == '2') { ?>
                    <div class="col-md-12 m-b-xs">
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                    </div>
                    <?php } ?>
                    <div class="col-md-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-retweet"></span> Kembali</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span
                                            class="fa fa-tag"></span> Tidak Kembali</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span
                                            class="fa fa-shopping-cart"></span> Dibeli </a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <table class="table table-bordered display" id="PtsBack" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. PTS</th>
                                                    <th>Tgl. Request</th>
                                                    <th>Tgl. Ambil</th>
                                                    <th>Due Date</th>
                                                    <th>Customer</th>
                                                    <th>Sales</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane ">
                                    <div class="panel-body">
                                        <table class="table table-bordered display" id="PtsNot" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">#</th>
                                                    <th data-priority="1">No. PTS</th>
                                                    <th>Tgl. Request</th>
                                                    <th>Tgl. Ambil</th>
                                                    <th>Customer</th>
                                                    <th>Sales</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane ">
                                    <div class="panel-body">
                                        <table class="table table-bordered display" id="PtsBuy" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:5%">#</th>
                                                    <th data-priority="1">No. PTS</th>
                                                    <th>Tgl. Request</th>
                                                    <th>Tgl. Ambil</th>
                                                    <th>Customer</th>
                                                    <th>Sales</th>
                                                    <th>Ket. Beli</th>
                                                    <th>Status</th>
                                                    <th style="width:8%" data-priority="2">Aksi</th>
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
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <input type="hidden" name="level" id="level" value="<?php echo $data['level']; ?>">
    <script>
    $(document).ready(function() {
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
    });
    // PTS Kembali
    $(document).ready(function() {
        var table1 = $('#PtsBack').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/aktualpts.php?jenis=1",
            "columnDefs": [{
                "targets": 7,
                "render": function(data, row) {
                    if (data == '1') {
                        return "<span class='label label-info label-xs'>COMPLETE</span>"
                    } else {
                        return "<span class='label label-warning label-xs'>UNCOMPLETE</span>"
                    }
                }
            }, {
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button></center>"
            }]
        });
        table1.on('draw.dt', function() {
            var info = table1.page.info();
            table1.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#PtsBack tbody').on('click', '.seedata', function() {
            var data = table1.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/ptsaktual_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewPts').html(data);
                    $('#PtsModal').modal('show');
                }
            });
        });

    });
    //PTS Tidak Kembali
    $(document).ready(function() {
        var table2 = $('#PtsNot').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/aktualptsnot.php?jenis=2",
            "columnDefs": [{
                "targets": 6,
                "render": function(data, row) {
                    if (data == 1) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return "<span class='label label-warning'>UNCOMPLETE</span>"
                    }
                }
            }, {
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
            }]
        });
        table2.on('draw.dt', function() {
            var info = table2.page.info();
            table2.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#PtsNot tbody').on('click', '.seedata', function() {
            var data = table2.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/ptsaktual_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewPts').html(data);
                    $('#PtsModal').modal('show');
                }
            });
        });
    });
    //PTS dibeli
    $(document).ready(function() {
        var lvl = $('#level').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table3 = $('#PtsBuy').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/aktualptsbuy.php?jenis=3",
                "columnDefs": [{
                    "targets": 7,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>COMPLETE</span>"
                        } else {
                            return "<span class='label label-warning'>UNCOMPLETE</span>"
                        }
                    }
                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            });
        } else {
            var table3 = $('#PtsBuy').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/aktualptsbuy.php?jenis=3",
                "columnDefs": [{
                    "targets": 7,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<span class='label label-info'>COMPLETE</span>"
                        } else {
                            return "<span class='label label-warning'>UNCOMPLETE</span>"
                        }
                    }
                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            });
        }
        table3.on('draw.dt', function() {
            var info = table3.page.info();
            table3.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#PtsBuy tbody').on('click', '.seedata', function() {
            var data = table3.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/ptsaktual_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewPts').html(data);
                    $('#PtsModal').modal('show');
                }
            });
        });
    });
    $(document).ready(function() {
        document.getElementById('pengajuan').setAttribute('class', 'active');
    });
    </script>
</body>
<div id="PtsModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail PTS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="viewPts">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exportData" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content animated bounceInUp">
            <div class="modal-header">
                <h4 class="modal-title">Form Export Data </h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <h5>Pilih tanggal pembuatan PTS</h5>
                <form method="POST" action="export/expAktualPts.php" id="formExport">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="date" name="tglawal" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tglakhir" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    <option value="1">Kembali</option>
                                    <option value="2">Tidak Kembali</option>
                                    <option value="3">Dibeli</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button id="simpan" type="submit" class="btn btn-success pull-right"><span
                                    class="fa fa-cloud-download"></span> Download</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</html>