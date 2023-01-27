<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls']; 
    if (isset($_SESSION['usernameu']) || $akses == '2' ){
        
    }else
    {
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
    <style>
    .swal2-popup {
        font-size: 0.7rem !important;
        font-family: Georgia, serif;
        text-align: center;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="namauser" id="namauser" value="<?php echo $data['user_nama']; ?>">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Penagihan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Penagihan</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>List FA</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-12 m-b-xs">
                        <!-- <button class="btn btn-success pull-left exportBtn">
                            <i class="fa fa-file-excel-o"></i>Export
                        </button> -->
                    </div>
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-building-o"></span> PT. MWK</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span
                                            class="fa fa-building-o"></span> CV. MWM</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span
                                            class="fa fa-building-o"></span> PT. BAK </a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span
                                            class="fa fa-building-o"></span> PT. FCI </a></li>
                                <li><a class="nav-link tab5" data-toggle="tab" href="#tab-5" id="tab5"><span
                                            class="fa fa-building-o"></span> PT. DTM </a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example" width="100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th class="text-center"> No </th> -->
                                                        <th class="text-center"> Tanggal FA </th>
                                                        <th class="text-center"> No FA </th>
                                                        <th class="text-center"> No SO </th>
                                                        <th class="text-center">
                                                            Customer
                                                        <th class="text-center"> Sales
                                                        <th class="text-center" data-priority="8">
                                                            Nominal FA Awal
                                                        </th>
                                                        <th class="text-center" data-priority="7">Nominal Konfirmasi
                                                        </th>
                                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                                        <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                                        <th class="text-center" data-priority="5">tgl Duedate </th>
                                                        <th class="text-center" data-priority="4">Overdue </th>
                                                        <th class="text-center" data-priority="3">Total Bayar </th>
                                                        <th class="text-center" data-priority="2">Selisih </th>
                                                        <th class="text-center" data-priority="1">Aksi </th>
                                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example2" width="100%">
                                                <thead>
                                                    <tr>
                                                        <!-- <th class="text-center"> No </th> -->
                                                        <th class="text-center"> Tanggal FA </th>
                                                        <th class="text-center"> No FA </th>
                                                        <th class="text-center"> No SO </th>
                                                        <th class="text-center">
                                                            Customer
                                                        <th class="text-center"> Sales
                                                        <th class="text-center" data-priority="8">
                                                            Nominal FA Awal
                                                        </th>
                                                        <th class="text-center" data-priority="7">Nominal Konfirmasi
                                                        </th>
                                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                                        <th class="text-center" data-priority="6">tgl Kontrabon
                                                        </th>
                                                        <th class="text-center" data-priority="5">tgl Duedate </th>
                                                        <th class="text-center" data-priority="4">Overdue </th>
                                                        <th class="text-center" data-priority="3">Total Bayar </th>
                                                        <th class="text-center" data-priority="2">Selisih </th>
                                                        <th class="text-center" data-priority="1">Aksi </th>
                                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example3" width="100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <!-- <th class="text-center"> No </th> -->
                                                        <th class="text-center"> Tanggal FA </th>
                                                        <th class="text-center"> No FA </th>
                                                        <th class="text-center"> No SO </th>
                                                        <th class="text-center">
                                                            Customer
                                                        <th class="text-center"> Sales
                                                        <th class="text-center" data-priority="8">
                                                            Nominal FA Awal
                                                        </th>
                                                        <th class="text-center" data-priority="7">Nominal Konfirmasi
                                                        </th>
                                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                                        <th class="text-center" data-priority="6">tgl Kontrabon
                                                        </th>
                                                        <th class="text-center" data-priority="5">tgl Duedate </th>
                                                        <th class="text-center" data-priority="4">Overdue </th>
                                                        <th class="text-center" data-priority="3">Total Bayar </th>
                                                        <th class="text-center" data-priority="2">Selisih </th>
                                                        <th class="text-center" data-priority="1">Aksi </th>
                                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example4" width="100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <!-- <th class="text-center"> No </th> -->
                                                        <th class="text-center"> Tanggal FA </th>
                                                        <th class="text-center"> No FA </th>
                                                        <th class="text-center"> No SO </th>
                                                        <th class="text-center">
                                                            Customer
                                                        <th class="text-center"> Sales
                                                        <th class="text-center" data-priority="8">
                                                            Nominal FA Awal
                                                        </th>
                                                        <th class="text-center" data-priority="7">Nominal Konfirmasi
                                                        </th>
                                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                                        <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                                        <th class="text-center" data-priority="5">tgl Duedate </th>
                                                        <th class="text-center" data-priority="4">Overdue </th>
                                                        <th class="text-center" data-priority="3">Total Bayar </th>
                                                        <th class="text-center" data-priority="2">Selisih </th>
                                                        <th class="text-center" data-priority="1">Aksi </th>
                                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example5" width="100%">
                                                <thead class="table-info">
                                                    <tr>
                                                        <!-- <th class="text-center"> No </th> -->
                                                        <th class="text-center"> Tanggal FA </th>
                                                        <th class="text-center"> No FA </th>
                                                        <th class="text-center"> No SO </th>
                                                        <th class="text-center">
                                                            Customer
                                                        <th class="text-center"> Sales
                                                        <th class="text-center" data-priority="8">
                                                            Nominal FA Awal
                                                        </th>
                                                        <th class="text-center" data-priority="7">Nominal Konfirmasi
                                                        </th>
                                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                                        <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                                        <th class="text-center" data-priority="5">tgl Duedate </th>
                                                        <th class="text-center" data-priority="4">Overdue </th>
                                                        <th class="text-center" data-priority="3">Total Bayar </th>
                                                        <th class="text-center" data-priority="2">Selisih </th>
                                                        <th class="text-center" data-priority="1">Aksi </th>
                                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
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

    <!-- modal export  -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Export Penagihan</h4>
                </div>
                <div class="modal-body" id="">
                    <div class="form-group" id="data_5">
                        <form action="exportPenagihan.php" method="post" target="_blank">
                            <!-- <label class="font-normal">Pilih renggang Waktu</label>
                            <div class="input-daterange input-group" id="datepicker"> -->
                            <!-- from export excel -->
                            <!-- <input type="text" class="form-control-sm form-control" name="start" id="start"
                                    value="<?=date("m/d/Y")?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end" id="end"
                                    value="<?=date("m/d/Y")?>"> -->
                            <!-- </div> -->
                            <label>Perusahaan</label>
                            <select name="perusahaan" id="perusahaan" class="form-control-sm form-control">
                                <option value="">ALL</option>
                                <option value="1">Multi Wahana Kencana (MWK)</option>
                                <option value="2">Multi Wahana Makmur (MWM)</option>
                                <option value="3">Batavia Adimarga Kencana (BAK)</option>
                                <option value="4">Dewata Titian Mas (DTM)</option>
                                <option value="5">Food Container Indonesia (FCI)</option>
                            </select>
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

    <!-- akhir export -->
    <?php include 'template/load_js.php';?>
    <script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $.fn.dataTable
        .tables( { visible: true, api: true } )
        .columns.adjust();
    });
    $('.exportBtn').click(function() {
        $('#exportModal').modal("show");
    });
    // Tabel 1 (MWK)
    $(document).ready(function() {
        var table = $("#example").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihanmwk.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });
        // $('#data_5 .input-daterange').datepicker({
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

    });
    // Tabel 2 (MWM)
    $(document).ready(function() {
        var table2 = $("#example2").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihanmwm.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });
        // $('#data_5 .input-daterange').datepicker({
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

    });
    // Tabel 3 (BAK)
    $(document).ready(function() {
        var table3 = $("#example3").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihanbak.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });
        // $('#data_5 .input-daterange').datepicker({
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

    });
    // Tabel 4 (FCI)
    $(document).ready(function() {
        var table4 = $("#example4").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihanfci.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });
        // $('#data_5 .input-daterange').datepicker({
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

    });
    // Tabel 5 (DTM)
    $(document).ready(function() {
        var table5 = $("#example5").DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": "serverside_agil/serverside_penagihandtm.php",
            columnDefs: [{
                "targets": 11,
                "render": function(data, row) {
                    if (data >= 0) {
                        return "<span class='label label-info'>COMPLETE</span>"
                    } else {
                        return data
                    }
                }
            }]
        });
        // $('#data_5 .input-daterange').datepicker({
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     autoclose: true
        // });

    });
    </script>