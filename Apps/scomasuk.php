<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '3'){
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
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data SCO Masuk</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data SCO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link active tabse" data-toggle="tab" href="#tab-1"><span class="fa fa-send-o (alias)"></span> Sales</span></a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"><span class="fa fa-send (alias)" id="tabmp"></span> Marketplace & Showroom</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3"><span class="fa fa-send (alias)"></span> SCO PTS</a></li>
                                <li><a class="nav-link tabso" data-toggle="tab" href="#tab-4"><span class="fa fa-send (alias)" id="tabso"></span> Pending</a></li>
                                <?php if($data['level'] == 'superadmin') { ?>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-5"><span class="fa fa-send (alias)"></span> Internal</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="">
                                            <table class="table table-striped" id="tabelUnProses" width="100%">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>No SCO</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Total SKU</th>
                                                        <th>Qty. Req</th>
                                                        <th>PT.</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="">
                                            <table class="table table-striped" id="ShowroomAndMarketplace" width="100%">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>No SCO</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Total SKU</th>
                                                        <th>Qty. Req</th>
                                                        <th>PT.</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="">
                                            <table class="table table-striped" id="tabelPts" style="width:100%;">
                                                <thead scoop="row">
                                                    <tr>
                                                    <th>#</th>
                                                        <th>No SCO</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Total SKU</th>
                                                        <th>Qty. Req</th>
                                                        <th>PT.</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="">
                                            <table class="table table-striped" id="tablePending" style="width:100%;">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th style="width:3%">#</th>
                                                        <th>No SCO</th>
                                                        <th>Customer</th>
                                                        <th>Total SKU</th>
                                                        <th>PT.</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="">
                                            <table class="table table-striped" id="tabelInternal" style="width:100%;">
                                                <thead scoop="row">
                                                    <tr>
                                                    <th>#</th>
                                                        <th>No SCO</th>
                                                        <th>Tgl. Order</th>
                                                        <th>Customer</th>
                                                        <th>Sales</th>
                                                        <th>Total SKU</th>
                                                        <th>Qty. Req</th>
                                                        <th>PT.</th>
                                                        <th>Aksi</th>
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
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php $uapv = 1; ?>
    <input type="hidden" id="lvl" value="<?php echo $data['level']; ?>">
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        $('.tabso').click(function() {
            document.getElementById('tabso').className += "active";
            var lvl = $('#lvl').val();
            if (lvl == 'admin' || lvl == 'superadmin') {
                var table = $('#tableProses').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "../serverside/scoProcess.php?stat=<?php echo $uapv; ?>",
                    responsive: true
                });
            }
        });
        $('.tabse').click(function() {
            window.location.reload();
        });

    });
    </script>

    <script>
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var table = $('#tabelUnProses').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scoUnproces.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip'><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs cancel' title='Cancel' rel='tooltip'><span class='fa fa-window-close'></span></button></center>"
                }]
            })
        } else {
            var table = $('#tabelUnProses').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scoUnproces.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            })
        }
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

        $('#tabelUnProses tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo_2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tabelUnProses tbody').on('click', '.createpo', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            window.location.href = "comaker.php?id=" + data[0];
        });
        //KLIK CANCEL BUTTON
        $('#tabelUnProses tbody').on('click', '.cancel', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            $.ajax({
                url: "modal/cancelsco.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#FormPending').html(data);
                    $('#EditModal').modal('show');
                }
            });
        });
    });
    //2. load data untuk table Showroom dan Marketplace
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var tablew = $('#ShowroomAndMarketplace').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scompsw.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip'><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs cancel' title='Cancel' rel='tooltip'><span class='fa fa-window-close'></span></button></center>"
                }]
            })
        } else {
            var tablew = $('#ShowroomAndMarketplace').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scompsw.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            })
        }
        tablew.on('draw.dt', function() {
            var info = tablew.page.info();
            tablew.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#ShowroomAndMarketplace tbody').on('click', '.seedata', function() {
            var data = tablew.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo_2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#ShowroomAndMarketplace tbody').on('click', '.createpo', function() {
            var data = tablew.row($(this).parents('tr')).data();
            var id = data[0];
            window.location.href = "comaker.php?id=" + data[0];
        });
    });
    //Load datatable dari serverside table pending
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var tablep = $('#tablePending').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scoPending.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip'><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs hapus' title='Hapus' rel='tooltip'><span class='fa fa-trash'></span></button></center>"
                }]
            });
        } else {
            var tablep = $('#tablePending').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scoPending.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip' disabled><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs hapus' title='Hapus' rel='tooltip' disabled><span class='fa fa-trash'></span></button></center>"
                }]
            });
            tablep.on('draw.dt', function() {
                var info = tablep.page.info();
                tablep.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
        }
            tablep.on('draw.dt', function() {
                var info = tablep.page.info();
                tablep.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });

            $('#tablePending tbody').on('click', '.seedata', function() {
                var data = tablep.row($(this).parents('tr')).data();
                var id = data[0];
                $.ajax({
                    url: "modal/detailPending.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        $('#detaiOrder').html(data);
                        $('#viewDetail').modal('show');

                    }
                });
            });
            $('#tablePending tbody').on('click', '.hapus', function() {
                var data = tablep.row($(this).parents('tr')).data();
                var id = data[0];
                $.ajax({
                    url: "modal/act_hapus_pending.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                        swal.fire(
                            'Yah :(',
                            'Data ini telah dihapus',
                            'success'
                            );
                    }
                });
            });
            $('#tablePending tbody').on('click', '.createpo', function() {
                var data = tablep.row($(this).parents('tr')).data();
                var id = data[0];
                window.location.href = "comaker_pending.php?id=" + data[0];
            });
        
    });
    // Load data PTS
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var tablepts = $('#tabelPts').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scopts.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip'><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs cancel' title='Cancel' rel='tooltip'><span class='fa fa-window-close'></span></button></center>"
                }]
            })
        } else {
            var tablepts = $('#tabelPts').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scopts.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            })
        }
        tablepts.on('draw.dt', function() {
            var info = tablepts.page.info();
            tablepts.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#tabelPts tbody').on('click', '.seedata', function() {
            var data = tablepts.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo_2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tabelPts tbody').on('click', '.createpo', function() {
            var data = tablepts.row($(this).parents('tr')).data();
            var id = data[0];
            window.location.href = "comaker.php?id=" + data[0];
        });
    });
    // Load Data SCO Internal
    $(document).ready(function() {
        var lvl = $('#lvl').val();
        if (lvl == 'admin' || lvl == 'superadmin') {
            var tableInt = $('#tabelInternal').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scointernal.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> <button class='btn btn-info btn-xs createpo' title='Create CO' rel='tooltip'><span class='fa fa-plus'></span></button> <button class='btn btn-danger btn-xs cancel' title='Cancel' rel='tooltip'><span class='fa fa-window-close'></span></button></center>"
                }]
            })
        } else {
            var tableInt = $('#tabelInternal').DataTable({
                "processing": true,
                "serverSide": true,
                responsive: true,
                "ajax": "../serverside/scointernal.php?stat=<?php echo $uapv; ?>",
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
                }]
            })
        }
        tableInt.on('draw.dt', function() {
            var info = tableInt.page.info();
            tableInt.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#tabelInternal tbody').on('click', '.seedata', function() {
            var data = tableInt.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo_2.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#tabelInternal tbody').on('click', '.createpo', function() {
            var data = tableInt.row($(this).parents('tr')).data();
            var id = data[0];
            window.location.href = "comaker.php?id=" + data[0];
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        document.getElementById('tabelSco').setAttribute('class', 'active');
    });

    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: 'modal/getQtysco_in.php',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#sqty').html(reslt.dataun);
                    $('#sqlqty').html(reslt.dataun);
                }
            });
        }, 1000);
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="detaiOrder">

                </div>
            </div>
        </div>
    </div>
     <div id="EditModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Give Feedback</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="FormPending">

                </div>
            </div>
        </div>
    </div>
</body>

</html>