<?php
include '../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (!isset($_SESSION['usernameu']) || $akses !== '1') {
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
    <?php include 'template/load_css.php'; ?>
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
                            <?php if ($data['level'] == 'sales' || $data['level'] == 'superadmin') : ?>
                                <a href="datapo_add.php" class="btn btn-info btn-sm"><span class="fa fa-plus-circle"></span>
                                    Tambah Order</a>
                            <?php endif ?>
                            <?php if ($data['level'] == 'admin' || $data['level'] == 'superadmin') : ?>
                                <button type="button" name="expt" id="expt" class="btn btn-success btn-sm exportData" title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                                    Data</button>
                            <?php endif ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data Sales Order</h5>
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
                                    <table class="table tablePo table-bordered table-hover" id="tablePo">
                                        <thead scoop="row" class="table-danger">
                                            <tr>
                                                <th data-priority="1">#</th>
                                                <th>No. So</th>
                                                <th>Tanggal Order</th>
                                                <th data-priority="3">Nama Customer</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th data-priority="2">Aksi</th>
                                            </tr>
                                        </thead>
                                        <!--  -->
                                    </table>
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
    <!-- load js library -->
    <script>
        $(document).ready(function() {
            document.getElementById('purchaseorder').setAttribute('class', 'active');
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $("#tablePo").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/datascoku.php?id=<?php echo $data['user_nama']; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": '<center><button type="button" name="view" value="Lihat Detail" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="fa fa-eye"></span></button> <button class="btn btn-success btn-xs makefpp" title="FPP" rel="tooltip"><span class="fa fa-pencil-square-o"></span></button></center>'
                }, {
                    "targets": 4,
                    "render": $.fn.dataTable.render.number('.', '', '', 'Rp. ')
                }]
            });
            // $('.tableModal').footable();
            table.on('draw.dt', function() { //penomoran pada tabel
                var info = table.page.info();
                table.column(0, {
                    search: 'applied',
                    order: 'applied',
                    page: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + info.start;
                });
            });
            $('#tablePo tbody').on('click', '.view_data', function() { //view detail di modal show
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
            $('#tablePo tbody').on('click', '.makefpp', function() { // tombol ubah data po
                var data = table.row($(this).parents('tr')).data();
                var data3 = data[3];
                var data3 = btoa(data3);
                window.location.href = "formfpp.php?id=" + data[0];
            });
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     //Begin Tampil Detail Karyawan
        //     $('.view_data').click(function() {
        //         var id = $(this).attr("id-po");
        //         $.ajax({
        //             url: "modal/detailpo.php",
        //             method: "POST",
        //             data: {
        //                 id: id
        //             },
        //             success: function(data) {
        //                 // console.log(data);
        //                 $('#detaiOrder').html(data);
        //                 $('#viewDetail').modal('show');

        //             }
        //         });
        //     });
        // });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="detaiOrder">

                </div>
            </div>
        </div>
    </div>
</body>

</html>