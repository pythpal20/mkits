<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '4'){
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
                    <h2>Data Request Pick Ticket Sample</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Pengajuan Sample</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- || -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
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
                                                    <th style="width:5%">#</th>
                                                    <th data-priority="1">No. PTS</th>
                                                    <th>Tgl. Request</th>
                                                    <th>Tgl. Ambil</th>
                                                    <th>Due Date</th>
                                                    <th>Customer</th>
                                                    <th>Sales</th>
                                                    <th>Status</th>
                                                    <th style="width:11%" data-priority="2">Aksi</th>
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
                                                    <th style="width:8%" data-priority="2">Aksi</th>
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
    // PTS Kembali
    $(document).ready(function() {
        var lvl = $('#level').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
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
                    "targets": 8,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>"
                        } else {
                            return "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-success btn-xs dataIn' rel='tooltip' title='Input Data barang kembali'><span class='fa fa-mail-reply (alias)'></span></button> <button class='btn btn-xs btn-primary completes'><span class='fa fa-check'></span></button> </center>"
                        }
                    }
                }]
            });
        } else {
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
                    "targets": 8,
                    "render": function(data, row) {
                        if (data == 1) {
                            return "<button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>"
                        } else {
                            return "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-xs btn-primary completes' disabled><span class='fa fa-check'></span></button> </center>"
                        }
                    }
                }]
            });
        }
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
        
        $('#PtsBack tbody').on('click', '.completes', function() {
            var data = table1.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/completepts.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    swal.fire(
                        'Completed',
                        'Data terkonfirmasi kembali',
                        'success');
                    // table.ajax.reload();
                    location.reload();
                }
            });
        });

        $('#PtsBack tbody').on('click', '.dataIn', function() { // tombol ubah data po
            var data = table1.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "sampleback.php?id=" + data[0];
        });
    });
    //PTS Tidak Kembali
    $(document).ready(function() {
        var lvl = $('#level').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
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
        } else {
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
                    "defaultContent": "<center><button class='btn btn-info btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button></center>"
                }]
            });
        }
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
    //PTS Dibeli
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
    </script>

    <script>
    $(document).ready(function() {
        document.getElementById('ptsampleakt').setAttribute('class', 'active');
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

</html>