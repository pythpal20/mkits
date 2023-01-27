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
    <link rel="stylesheet" href="../assets/css/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
    <!-- load css library -->
    <style>
        #toolbar {
            margin: 0;
        }
    </style>
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
                    <h2>Data Komplain</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="salescomplain.php">Tabel CO</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>data komplain</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Data komplain kamu</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <table id="tb_com" data-show-toggle="true" data-page-size="10" data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-columns-toggle-all="true"></table>
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
    <div class="modal fade" id="compModal" tabindex="-1" aria-labelledby="compModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <div id="compModalLabel"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="compHtml">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success download" id="download" disabled=""><i class="fa fa-download"></i> MOM</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
    <!-- table-bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="../assets/js/plugins/summernote/summernote-bs4.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/print/bootstrap-table-print.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.21.2/dist/extensions/custom-view/bootstrap-table-custom-view.js"></script>
    <script src="DataScript/addSco.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('komplainform').setAttribute('class', 'active');
        });
        // table bootstrap
        $('#tb_com').bootstrapTable({
            url: '../serverside/myComplain.php',
            pagination: true,
            search: true,
            showColumns: true,
            showToggle: true,
            columns: [{
                field: 'komplain_id',
                title: 'ID Komplain',
                sortable: true
            }, {
                field: 'customer',
                title: 'Nama Customer',
                sortable: true
            }, {
                field: 'noco',
                title: 'No CO',
            }, {
                field: 'tglKomplain',
                title: 'Tanggal Komplain',
                sortable: true
            }, {
                field: 'status',
                title: 'Status',
                sortable: true,
                formatter: function(value, row, index) {
                    if (value == '0') {
                        return '<span class="label label-warning">Pending</span>';
                    } else if (value == '1') {
                        return '<span class="label label-success">Solved</span>';
                    }
                },
                align: 'center'
            }, {
                field: 'sales',
                title: 'Sales',
                sortable: 'true'
            }, {
                field: 'action',
                title: 'Action',
                formatter: tombol,
                align: 'center'
            }]
        });

        function tombol(value, row, index) {
            return [
                '<button class="btn btn-primary btn-xs lihat" data-sid="' + row.komplain_id + '" data-status="' + row.status + '"><i class="fa fa-eye"></i></button> ' +
                '<button class="btn btn-success btn-xs approve" data-sid="' + row.komplain_id + '" data-status="' + row.status + '"><i class="fa fa-check"></i></button>'
            ].join('');
        }
        $('body').on('click', '#tb_com .lihat', function() {
            var id = $(this).data('sid');
            var status = $(this).data('status');

            if (status == '0') {
                $("#download").prop('disabled', true);
            } else {
                $("#download").prop('disabled', false);
            }
            // alert(id)
            $.ajax({
                url: 'modal/shwKomplain.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    $('#compHtml').html(data);
                    $('#compModal').modal('show');

                    $("#download").click(function() {
                        // window.location.href = "export/momPdf.php?id=" + id;
                        window.open('export/momPdf.php?id=' + id, '_blank');
                    });
                }
            });
        });

        $('body').on('click', '#tb_com .approve', function() {
            var id = $(this).data('sid');
            var status = $(this).data('status');

            if (status == '1') {
                swal.fire(
                    'Oops...',
                    'Komplain sudah di approve!',
                    'error'
                );
            } else {
                swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan mengapprove komplain ini!",
                    icon: 'question',
                    showCancelButton: true,
                }).then((resl) => {
                    if (resl.isConfirmed) {
                        $.ajax({
                            url: 'modal/approveKomplain.php',
                            type: 'POST',
                            data: {
                                id: id,
                                status: status
                            },
                            success: function(data) {
                                swal.fire({
                                    title: 'Berhasil!',
                                    text: "Komplain berhasil di approve!",
                                    icon: 'success',
                                    allowOutsideClick: false,
                                }).then((rex) => {
                                    if (rex.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }
                        });
                    }
                });
            }
            // alert(id)
        });
    </script>