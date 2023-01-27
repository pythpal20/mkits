<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '1'){
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
                            <strong>Request Sample</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- || -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <?php if($data['level'] == 'sales') { ?>
                        <a href="datasampleadd.php" class="btn btn-xs btn-info"><span class="fa fa-plus"></span> |
                            Request Sample</a>
                        <?php } ?>
                        <?php if ($data['level'] == 'superadmin' || $data['level'] =='admin') { ?>
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button> |
                        <button type="button" name="exprt" id="exprt" class="btn btn-info btn-sm laporan"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-file-excel-o"></span> Laporan
                            PTS</button>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Pick Ticket Sample</h5>
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
                                <?php if ($data['level'] !== 'sales') { ?>
                                <table class="table table-bordered table-striped" width="100%" id="TableRpt">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="10%">No. PTS</th>
                                            <th>Tgl. Request</th>
                                            <th>Tgl. Ambil</th>
                                            <th>Customer</th>
                                            <th>Sales</th>
                                            <th>Status</th>
                                            <th>Map</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                                <?php } elseif ($data['level'] == 'sales') { ?>
                                <table class="table table-striped" width="100%" id="TableRpt">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th data-priority="1">No. PTS</th>
                                            <th>Tgl. Request</th>
                                            <th>Tgl. Ambil</th>
                                            <th>Customer</th>
                                            <th data-priority="1">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <input type="hidden" name="level" id="level" value="<?php echo $data['level']; ?>">
    <?php 
        $nm_sales = $data['user_nama'];
    ?>
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        var lvl = $('#level').val();
        if (lvl === "admin" || lvl === "superadmin") { //data serverside all table

            var table = $('#TableRpt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/DataRpt.php?kategori; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span></button><button class='btn btn-primary btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span> </button> <button class='btn btn-danger btn-xs tblDelete'><span class='fa fa-trash'></span> </button></div></center>"
                }, {
                    "targets": 6,
                    "render" : function(data, row) {
                        if (data == 1) {
                            return 'Kembali'
                        }else if(data == 2) {
                            return 'Tidak Kembali'
                        }else if(data == 3) {
                            return 'Dibeli'
                        }
                    }
                },{
                    "targets": 7,
                    "render": function(data, row) {
                        if (data === '2|2') {
                            return 'CANCEL'
                        } else if (data === '1|1') {
                            return 'COMPLETE'
                        } else if (data === '1|0' || data === '0|1') {
                            return 'IN PROGGRES'
                        } else if (data === '1|2' || data === '2|1' || data === '0|2' ||
                            data === '2|0') {
                            return 'HALF CANCEL'
                        } else {
                            return 'UNPROCESS'
                        }
                    }
                }],
                "order": [
                    [1, "ASC"]
                ]
            });

        } else if (lvl === "sales") { //data serverside table requst berdasarkan nama sales

            var table = $('#TableRpt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/DataRptSales.php?nama=<?= $nm_sales; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span></button></div></center>"
                }],
                "order": [
                    [0, "desc"]
                ]
            });

        } else { //jika yang masuk adalah user dengan level guest
            var table = $('#TableRpt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/DataRpt.php?kategori; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span></button></center>"
                }],
                "order": [
                    [0, "desc"]
                ]
            });
        }
        table.on('draw.dt', function() { //penomoran pada tabel
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#TableRpt tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/pts_view.php",
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
        $('#TableRpt tbody').on('click', '.tblEdit', function() { // tombol ubah data po
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "pts_edit.php?id=" + data[0];
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        document.getElementById('samplerequest').setAttribute('class', 'active');
        
        
    });
    $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
        
    $('.laporan').click(function() {
        $('#laporan').modal('show');
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
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih tanggal pembuatan PTS</h5>
                    <form method="POST" action="export/exportpts.php" id="formExport">
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
    <div class="modal fade" id="laporan" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih tanggal pembuatan PTS</h5>
                    <form method="POST" action="export/laporanpts.php" id="formExport">
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