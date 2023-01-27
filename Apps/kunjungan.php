<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) && ($akses !== '1' || $akses !== '3')){
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
        <!-- Load Header disini ya  -->
        <?php include 'template/header.php'; ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Kunjungan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Tabel Kunjungan</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- breadcum end -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <a href="formkunjungan.php" class="btn btn-sm btn-info"><span class="fa fa-plus-circle"></span>
                            Tambah Data</a>
                        <button class="btn btn-sm btn-success download"><span
                                class="fa fa-download"></span> Exp. Data</button>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Kunjungan</h5>
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
                                <table class="table table-bordered display" style="width: 100%;" id="tblKunjungan">
                                    <thead>
                                        <th data-priority="1">#</th>
                                        <th data-priority="3">Tgl. Followup</th>
                                        <th data-priority="4">Customer</th>
                                        <th style="width:15%;">Sales</th>
                                        <th>Jenis Followup</th>
                                        <th>Ket</th>
                                        <th>Deskripsi</th>
                                        <th data-priority="2">Aksi</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        var table = $('#tblKunjungan').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "../serverside/tblKunjungan.php",
            columnDefs: [{
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-warning btn-xs tblEdit' tooltip='Edit'><span class='fa fa-edit'></span></button> <button class='btn btn-danger btn-xs tblDelete tooltip='Delete''><span class='fa fa-trash'></span> </button>"
            }, {
                "targets": 4,
                "render": function(data, row) {
                    if (data === 'kunjungan') {
                        return 'KUNJUNGAN'
                    } else if (data === 'telepon') {
                        return 'TELEPON'
                    }
                }
            }]
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
        $('#tblKunjungan').on('click', '.tblEdit', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "KunjunganEdit.php?id=" + data[0];
        });
        $('#tblKunjungan').on('click', '.tblDelete', function() {
            var data = table.row($(this).parents('tr')).data();
            window.location.href = "kunjungan_delete.php?id=" + data[0];
        });
        $('.download').click(function() {
            $('#exportModal').modal("show");
        });
        $('#data_5 .input-daterange').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
    });
    </script>
</body>
<div class="modal inmodal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Export Data Kunjungan</h4>
            </div>
            <div class="modal-body" id="">
                <div class="form-group" id="data_5">
                    <label class="font-normal">Pilih Rentang Waktu</label>
                    <form action="export/ExportKunjungan.php" method="post" target="_blank">
                        <div class="input-daterange input-group" id="datepicker">
                            <!-- from export excel -->
                            <input type="text" class="form-control-sm form-control" name="start" id="start"
                                value="<?=date("m/d/Y")?>" autocomplete="off">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control-sm form-control" name="end" id="end"
                                value="<?=date("m/d/Y")?>" autocomplete="off">
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn-group btn btn-primary ">Download</button>
                </form>
                <!--akhir from export excel -->
            </div>
        </div>
    </div>
</div>
</html>