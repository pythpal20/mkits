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
    
    date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html>

<head>
    <?php include 'template/load_css.php';?>
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="lvlUser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="namaku" id="namaku" value="<?php echo $data['user_nama']; ?>">
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
                        
                        <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
                    </div>
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-building-o"></span> Order By Sales</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span
                                            class="fa fa-building-o"></span> Order By Marketplace</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span
                                            class="fa fa-building-o"></span> Order By Toko</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <table class="table table-bordered" id="dataPo" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th data-priority="1">No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Req Harga</th>
                                                    <th>Status</th>
                                                    <th data-priority="2">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-bordered" id="dataPoM" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <table class="table table-hover table-striped" id="dataShw" width="100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th>#</th>
                                                    <th>No. So</th>
                                                    <th>Tgl. Order</th>
                                                    <th>Nama Customer</th>
                                                    <th>Sales</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
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
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <input type="hidden" id="hariini" value="<?php echo date('D'); ?>">
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    //1. Tabel Sales Order
    $(document).ready(function() {
        var lvl = $('#lvlUser').val();
        var table = $('#dataPo').DataTable({ //ketika yang login adalah guest
            "processing": true,
            "serverSide": true,
            "ajax": "../serverside/dataPoAll.php",
            responsive: true,
            columnDefs: [{
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": '<button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button>'
            }, {
                "targets":6,
                "render":function(data, row){
                    if(data == '0') {
                        return 'No'
                    } else {
                        return 'Yes'
                    }
                }
            }, {
                targets: 6,
                createdCell: function(tr, data) {
                    if(data === "0") {
                        $(tr).css("background-color", "MistyRose");
                    } else {
                        $(tr).css("background-color", "Azure");
                    }
                }
            }, {
                "targets": 5,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
            }]
        });

        table.on('draw.dt', function() { //penomoran
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#dataPo tbody').on('click', '.view_data', function() { // view detail data pada modal show
            var data = table.row($(this).parents('tr')).data();
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
    });
    //2. Table Marketplace
    $(document).ready(function() {
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

    });
    //3. Tabel Showroom
    $(document).ready(function() {

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
    });
    </script>

    <script>
    $(document).ready(function() {
        $("#slm").click(() => {
            var element = document.getElementById("sco");
            element.classList.add("active");
        });
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
        var namaku = $('#namaku').val();
        var jamku = <?php echo date('Hi');?>;
        var tdei = $('#hariini').val();
        // alert(jamku);
        if(namaku === 'MELLAWATI' && tdei != 'Sat') {
            if(jamku <= 1500){
                document.getElementById('expt').setAttribute("disabled", "true");
                // alert('belum jam 3');
            }
        }
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
</body>

</html>