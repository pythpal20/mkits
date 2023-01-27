<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) ){
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
                    <h2>Status SCO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="infosco.php">Status SCO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>SCO Pending</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php if($data['level'] == 'superadmin' || $data['level']=='admin') : ?>
                    <div class="col-md-12 m-b-xs">
                        <button class="btn btn-success btn-sm export" id="export"><span class="fa fa-download"></span> |
                            Export Data</button>
                    </div>
                    <?php endif; ?>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Data SCO Pending By Admin Penjualan</h5>
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
                                    <table class="table table-striped" id="tablePending" width="100%">
                                        <thead scoop="row">
                                            <tr>
                                                <th>#</th>
                                                <th>No SCO</th>
                                                <th>Sales</th>
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
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <div id="viewDetail" class="modal inmodal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Detail Order</h4>
                </div>
                <div class="modal-body" id="detaiOrder">

                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="exportData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Data </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Pilih rentang waktu</h5>
                    <form method="POST" action="export/expPending.php" id="formExport">
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
                            <div class="col-md-4">
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
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        document.getElementById('status_sco').setAttribute('class', 'active');
    });
    $(document).ready(function() {
        $('.export').click(function() {
            $('#exportData').modal('show');
        });
    });
    //load Data from serverside
    $(document).ready(function() {
        var tablep = $('#tablePending').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "ajax": "../serverside/masterpending.php?stat",
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "orderable": false,
                "defaultContent": "<center><button class='btn btn-warning btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button> </center>"
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
                    // console.log(data);
                    $('#detaiOrder').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
    });
    </script>
</body>

</html>