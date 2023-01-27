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
    <input type="hidden" value="<?= $data['level'] ?>" id="lvl" name="lvl">
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Form Perubahan PO</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data FPP</strong>
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
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>List Data Pengajuan Perubahan PO</h5>
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
                                    <table class="display table table-hover table-bordered" id="myFppList" width="100%">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th data-priority="1">No. FPP</th>
                                                <th>No. SO</th>
                                                <th>Tgl. Pengajuan</th>
                                                <th>Customer</th>
                                                <th>Sales</th>
                                                <th data-priority="3">Status</th>
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
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <!-- load js library -->
    <script>
    $(document).ready(function() {
        document.getElementById('fpp').setAttribute('class', 'active');
    });
    </script>
    <script>
    $(document).ready(function() {
        var lev = $('#lvl').val();
        if (lev == 'superadmin' || lev == 'admin') {
            var table = $('#myFppList').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/data_fpp.php",
                columnDefs: [{
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return '<span class="label label-info label-xs">PROCESSED</span>'
                        } else if (data == 0) {
                            return '<span class="label label-warning label-xs">UNPROCESS</span>'
                        } else {
                            return '<span class="label label-danger label-xs">CANCELED</span>'
                        }
                    }
                }, {
                    "targets": 7,
                    "render": function(data, row) {
                        if (data == 1) {
                            return '<button class="btn btn-primary btn-xs showdtl" rel="tooltip" title="View detail"><span class="fa fa-eye"></span></button> <button class="btn btn-success btn-xs download" rel="tooltip" title="Download"><span class="fa fa-download"></span></button>'
                        } else if (data == 0) {
                            return '<button class="btn btn-primary btn-xs showdtl" rel="tooltip" title="View detail"><span class="fa fa-eye"></span></button> <button class="btn btn-info btn-xs approval" rel="tooltip" title="Process"><span class="fa fa-check-square-o"></span></button>'
                        } else {
                            return '<button class="btn btn-primary btn-xs showdtl" rel="tooltip" title="View detail"><span class="fa fa-eye"></span></button>'
                        }
                    }
                }]
            });
        } else {
            var table = $('#myFppList').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": "../serverside/data_fpp.php",
                columnDefs: [{
                    "targets": 6,
                    "render": function(data, row) {
                        if (data == 1) {
                            return '<span class="label label-info label-xs">PROCESSED</span>'
                        } else if (data == 0) {
                            return '<span class="label label-warning label-xs">UNPROCESS</span>'
                        } else {
                            return '<span class="label label-danger label-xs">CANCELED</span>'
                        }
                    }
                }, {
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": '<button class="btn btn-primary btn-xs showdtl" rel="tooltip" title="View detail"><span class="fa fa-eye"></span></button>'
                }]
            });
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
        $('#myFppList tbody').on('click', '.showdtl', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/DetailFpp.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#dtlFpp').html(data);
                    $('#viewDetail').modal('show');

                }
            });
        });
        $('#myFppList tbody').on('click', '.download', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[3];
            var data3 = btoa(data3);
            window.open("datafpp_print.php?id=" + data[0], "_blank");
        });
        $('#myFppList tbody').on('click', '.approval', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            // console.log(id);
            function approvalfpp() {
                $.ajax({
                    url: "modal/AprovalFpp.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        // console.log(data);

                    }
                });

            }
            $.when(approvalfpp()).then(refresh());
        });

        function refresh() {
            Swal.fire(
                'Berhasil',
                'Sudah diapprove',
                'success'
            );
            setTimeout(function() {
                location.reload(true);
            }, 3600);
        }
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.exportData').click(function() {
            $('#exportData').modal('show');
        });
    });
    </script>
    <div id="viewDetail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pengajuan FPP</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="dtlFpp">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportData" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Form Export Data </h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <h5>Filter Export</h5>
                    <form method="POST" action="export/exportfpp.php" id="formExport">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Awal</label>
                                    <input type="date" name="tglawal" class="form-control" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tglakhir" class="form-control" required="">
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