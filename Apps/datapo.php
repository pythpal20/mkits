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
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <?php include 'template/load_css.php';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="pengguna" id="pengguna" value="<?php echo $data['user_nama']; ?>">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data PO Sales</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data PO</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <?php if ($data['modul'] == '1') { ?>
                        <?php if($data['level'] == 'sales' || $data['level'] == 'superadmin' || $data['user_nama'] == 'Antonius' || $data['user_nama'] == 'Arie Wijaya') : ?>
                        <a href="datapo_add.php" class="btn btn-info btn-sm"><span class="fa fa-plus-circle"></span>
                            Tambah Order</a>
                        <?php endif ?>
                        
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                         <?php if($data['company'] == 'Foodpack') : ?> 
                            <div class="float-right">
                                <button type="button" name="expt" id="expt" class="btn btn-danger btn-sm exportDataFP"  title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export Data Foodpack</button>
                            </div>
                            <?php endif; ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span class="fa fa-child"></span> DSO FoodPack</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span class="fa fa-child"></span> DSO Horeka</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span class="fa fa-cloud"></span> Marketplace</a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span class="fa fa-building-o"></span> Showroom75</a></li>
                                <li><a class="nav-link tab5 bg-info text-light" data-toggle="tab" href="#tab-5" id="tab5"><span class="fa fa-shopping-cart"></span> Toko Online</a></li>
                                <?php if ($data['level'] == 'superadmin') { ?>
                                    <li><a class="nav-link tab6" data-toggle="tab" href="#tab-6" id="tab6"><span class="fa fa-building-o"></span> Order Internal</a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="foodpack" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Pengajuan Harga</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="horeka" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Pengajuan Harga</th>
                                                    <th data-priority="3">Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="dataPoM" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th data-priority="3">Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="dataShw" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped table-bordered" id="onlinestore" width="100%">
                                            <thead scoop="row" class="table-danger">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Customer</th>
                                                    <th>Input By</th>
                                                    <th>Amount</th>
                                                    <th data-priority="3">Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-6" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="datainternal" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
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
            <input type="hidden" id="pgn" value="<?= $data['user_nama'] ?>">
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="DataScript/dso_horeka.js"></script>
    <script src="DataScript/onlineStore.js"></script>
    <!-- load js library -->
    <script>
    //1. Tabel Sales Order
    
    //2. Table Marketplace
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        var pg = $("#pgn").val();
        if (lvl == "admin" || lvl == "superadmin") {
            var tablem = $('#dataPoM').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/dataPOM.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

                }, {
                    "targets": 6,
                        "render": function(data, row) {
                            if (pg === 'Arie Wijaya') {
                                if (data === 'UNPROCESS') {
                                    return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
                                } else if (data === 'CANCEL') {
                                    return '<span class="label label-danger">[' + data +
                                        ']</span>';
                                } else if (data === 'PROCESS') {
                                    return '<span class="label label-success">[' + data +
                                        ']</span>';
                                }
                            } else {
                                if (data === 'UNPROCESS') {
                                    return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip" disabled>Proses</button>';
                                } else if (data === 'CANCEL') {
                                    return '<span class="label label-danger">[' + data +
                                        ']</span>';
                                } else if (data === 'PROCESS') {
                                    return '<span class="label label-success">[' + data +
                                        ']</span>';
                                }
                            }
                        }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        if (data === '0|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                        } else if (data === '2|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
                        } else if (data == '1|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                        } else if (data == '1|1') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
                        }
                    }
                }],
                order: [[2, 'ASC']]
            });
        } else {
            var tablem = $('#dataPoM').DataTable({ //ketika yang login adalah guest
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/dataPOM.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>'
                }]
            });
        }
        tablem.on('draw.dt', function() { //penomoran pada tabel
            var info = tablem.page.info();
            tablem.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#dataPoM tbody').on('click', '.view_data', function() { //view detail di modal show
            var data = tablem.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    //console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#dataPoM tbody').on('click', '.aprove', function() { //aprove data 
            var data = tablem.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            var sals = data[4];
            var cust = data[3];
            var pengg = $('#pengguna').val();
            swal.fire({
                title: "Proses Data ?",
                imageUrl:'../img/system/undraw_Questions.png',
                imageheight: 200,
                showCancelButton: true,
                confirmButtonColor: "#48D1CC",
                cancelButtonColor: "#FF4500",
                confirmButtonText: "Ya, Proses!"
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "modal/changestatus.php",
                        method: "POST",
                        data: {
                            id: id,
                            pengguna: pengg
                        },
                        success: function(data) {
                            Swal.fire({
                                title: data,
                                imageUrl: '../img/system/undraw_approve.png',
                                imageHeight: 200
                            });
                            var url =
                                'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                            var chat_id = ["-759758736","-1001688464072"];
                            var text = "Processed By : <i>" + pengg +
                                "</i>\n" + "No. PO : <b><i>" +
                                "<a href='#'>" + id + "</a></i></b>\n" +
                                "Customer : <i>" + cust + "</i>\n" +
                                "Sales : <i>" + sals + "</i>\n" + data;
                            for (let index = 0; index < chat_id.length; index++) {
                                const element = chat_id[index];
                                $.ajax({
                                    url: url,
                                    method: "get",
                                    data: {
                                        chat_id: element,
                                        parse_mode: 'html',
                                        text: text
                                    }
                                });
                            }
                            setTimeout(function() {
                                location.assign("datapo.php");
                            }, 2500);
                        }
                    });
                }
            });
        });
        $('#dataPoM tbody').on('click', '.ubah', function() { // tombol ubah data po
            var data = tablem.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "datapo_edit.php?id=" + data[0];
        });

        $('#dataPoM tbody').on('click', '.hapus', function() { //tombol hapus po
            var data = tablem.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "modal/datapo_delete.php?id=" + data[0];
        });

        $('#dataPoM tbody').on('click', '.cancel', function() { // tombol cancel PO
            var data = tablem.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
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
    //3. Tabel Showroom
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        var pg = $("#pgn").val();
        if (lvl == "admin" || lvl == "superadmin") {
            var tableshw = $('#dataShw').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/dataShw.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === 'UNPROCESS') {
                            return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger">[' + data +
                                ']</span>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-success">[' + data +
                                ']</span>';
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        if(pg == 'Antonius'){
                            if (data === '0|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                            } else if (data === '2|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
                            } else if (data == '1|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                            } else if (data == '1|1') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
                            }
                        } else {
                            if (data === '0|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip" disabled><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                            } else if (data === '2|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
                            } else if (data == '1|0') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                            } else if (data == '1|1') {
                                return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
                            }
                        }
                    }
                }]
            });
        } else {
            var tableshw = $('#dataShw').DataTable({ //ketika yang login adalah guest
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/dataShw.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>'
                }]
            });
        }
        tableshw.on('draw.dt', function() { //penomoran pada tabel
            var info = tableshw.page.info();
            tableshw.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#dataShw tbody').on('click', '.view_data', function() { //view detail di modal show
            var data = tableshw.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    //console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#dataShw tbody').on('click', '.aprove', function() { //aprove data 
            var data = tableshw.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            var sals = data[4];
            var cust = data[3];
            var pengg = $('#pengguna').val();
            swal.fire({
                title: "Proses Data ?",
                imageUrl: '../img/system/undraw_Questions.png',
                imageHeight: 200,
                showCancelButton: true,
                confirmButtonColor: "#48D1CC",
                cancelButtonColor: "#FF4500",
                confirmButtonText: "Ya, Proses!"
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "modal/changestatus.php",
                        method: "POST",
                        data: {
                            id: id,
                            pengguna: pengg
                        },
                        success: function(data) {
                            Swal.fire({
                                title: data,
                                imageUrl : '../img/system/undraw_approve.png',
                                imageHeight: 200
                            });
                            var url =
                                'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                            var chat_id = ["-759758736","-1001688464072"];
                            var text = "Processed By : <i>" + pengg +
                                "</i>\n" + "No. PO : <b><i>" +
                                "<a href='#'>" + id + "</a></i></b>\n" +
                                "Customer : <i>" + cust + "</i>\n" +
                                "Sales : <i>" + sals + "</i>\n" + data;
                            for (let index = 0; index < chat_id.length; index++) {
                                const element = chat_id[index];
                                $.ajax({
                                    url: url,
                                    method: "get",
                                    data: {
                                        chat_id: element,
                                        parse_mode: 'html',
                                        text: text
                                    }
                                });
                            }
                            setTimeout(function() {
                                location.assign("datapo.php");
                            }, 2000);
                        }
                    });
                } else if(result.dismiss === Swal.DismissReason.cancel){
                    swal.fire("Batal", "Anda Batal Memproses data", "error");
                }
            });
        });
        
        $('#dataShw tbody').on('click', '.ubah', function() { // tombol ubah data po
            var data = tableshw.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "datapo_edit.php?id=" + data[0];
        });

        $('#dataShw tbody').on('click', '.hapus', function() { //tombol hapus po
            var data = tableshw.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "modal/datapo_delete.php?id=" + data[0];
        });

        $('#dataShw tbody').on('click', '.cancel', function() { // tombol cancel PO
            var data = tableshw.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
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
    
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        if (lvl == "admin" || lvl == "superadmin") {
            var tableint = $('#datainternal').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/datapointernal.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')

                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === 'UNPROCESS') {
                            return '<button class="btn btn-xs btn-info aprove" title="Proses PO" rel="tooltip">Proses</button>';
                        } else if (data === 'CANCEL') {
                            return '<span class="label label-danger">[' + data +
                                ']</span>';
                        } else if (data === 'PROCESS') {
                            return '<span class="label label-success">[' + data +
                                ']</span>';
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        if (data === '0|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button> <button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                        } else if (data === '2|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>';
                        } else if (data == '1|0') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button><button title="Ubah" rel="tooltip" class="btn btn-primary btn-xs ubah"><span class="fa fa-pencil"></span></button><button class="btn btn-xs btn-warning cancel" title="Cancel-PO" rel="tooltip"><span class="fa fa-window-close"></span></button></div>';
                        } else if (data == '1|1') {
                            return '<div class="btn-group"><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button></div>';
                        }
                    }
                }]
            });
        } else {
            var tableint = $('#datainternal').DataTable({ //ketika yang login adalah guest
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/datapointernal.php?kategori; ?>",
                responsive: true,
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>'
                }]
            });
        }
        tableint.on('draw.dt', function() { //penomoran pada tabel
            var info = tableint.page.info();
            tableint.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#datainternal tbody').on('click', '.view_data', function() { //view detail di modal show
            var data = tableint.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/detailpo.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    //console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#datainternal tbody').on('click', '.aprove', function() { //aprove data 
            var data = tableint.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            var id = data[0];
            var sals = data[4];
            var cust = data[3];
            var pengg = $('#pengguna').val();
                $.ajax({
                    url: "modal/changestatus.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        Swal.fire(
                            data,
                            '',
                            'success'
                        );
                        var url =
                            'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                        var chat_id = ["-759758736","-1001688464072"];
                        var text = "Processed By : <i>" + pengg +
                            "</i>\n" + "No. PO : <b><i>" +
                            "<a href='#'>" + id + "</a></i></b>\n" +
                            "Customer : <i>" + cust + "</i>\n" +
                            "Sales : <i>" + sals + "</i>\n" + data;
                        for (let index = 0; index < chat_id.length; index++) {
                            const element = chat_id[index];
                            $.ajax({
                                url: url,
                                method: "get",
                                data: {
                                    chat_id: element,
                                    parse_mode: 'html',
                                    text: text
                                }
                            });
                        }
                    setTimeout(function() {
                        location.assign("datapo.php");
                    }, 2000);
                }
            })

        });
        $('#datainternal tbody').on('click', '.ubah', function() { // tombol ubah data po
            var data = tableint.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "datapo_edit.php?id=" + data[0];
        });
        $('#datainternal tbody').on('click', '.hapus', function() { //tombol hapus po
            var data = tableint.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.location.href = "modal/datapo_delete.php?id=" + data[0];
        });
        $('#datainternal tbody').on('click', '.cancel', function() { // tombol cancel PO
            var data = tableint.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
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
    </script>

    <script>
    $(document).ready(function() {
        document.getElementById('purchaseorder').setAttribute('class', 'active');
    });
    </script>
    <!-- script lama -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
    });
     $(document).ready(function() {
        $('.exportDataFP').click(function() {
            $('#exportDataFP').modal('show');
        });
    });
    $("#tab5").click(() => {
        swal.fire({
            title: 'Tab Toko Online',
            html: 'Tab ini merupakan tab SCO dari penjualan lewat situs <a href="https://mrkitchen.co.id">https://mrkitchen.co.id</a>',
            imageUrl: '../img/system/undraw_Job_offers.png',
            imageHeight: 250,
            confirmButtonColor: '#DC143C',
            confirmButtonText: 'Ok, Paham'

        });
    });
    </script>
    <div id="viewDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
        <div class="modal-dialog" role="document" style="max-width:75%">
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
    <div class="modal fade" id="exportData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu</h5>
                    <form method="POST" action="export/exportcsv.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="all">ALL</option>
                                        <option value="salesmarketing">Sales & Marketing</option>
                                        <option value="marketplace">Marketplace</option>
                                        <option value="showroom">TOKO 75</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">ALL</option>
                                        <option value="0">UNPROCESSED</option>
                                        <option value="1">PROCESSED</option>
                                        <option value="2">CANCEL</option>
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
    <!---->MODAL EXPORT UNTUK FP-->
     <div class="modal fade" id="exportDataFP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data Khusus Foodpack </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu</h5>
                    <form method="POST" action="export/exportcsvFP.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">ALL</option>
                                        <option value="0">UNPROCESSED</option>
                                        <option value="1">PROCESSED</option>
                                        <option value="2">CANCEL</option>
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