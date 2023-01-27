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
                                <h5>Data CO kamu</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div id="toolbar">
                                    <button class="btn btn-secondary datakomplain" data-toggle="tooltip" rel="tooltip" title="data komplain anda"><i class="fa fa-eye"></i> List Komplain</button>
                                </div>
                                <table id="tb_co" data-show-toggle="true" data-page-size="10" data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-columns-toggle-all="true"></table>
                            </div>
                            <div class="ibox-footer">
                                <em><small>Pilih dan klik tombol warna hijau untuk membuat complain</small></em>
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
    <div class="modal fade" id="coModal" tabindex="-1" aria-labelledby="coModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <div id="coModalLable"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="htmlCo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="insert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-body">
                    <label>Menyimpan Data . . .</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-info" style="width: 100%" role="progressbar" aria-valuenow="100%" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
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

            $(".datakomplain").click(function() {
                window.location.href = "mycomplain.php?name=<?= $data['user_nama'] ?>";
            });
        });
        // table bootsrap
        $(document).ready(function() {
            var usr = "<?= $data['user_nama'] ?>";
            $table = $("#tb_co")
            $table.bootstrapTable({
                url: '../serverside/getmyco.php?id=' + usr,
                toolbar: '#toolbar',
                columns: [{
                        field: 'No_Co',
                        title: 'No. CO',
                        sortable: true,
                        formatter: function(value) {
                            return [
                                value.substring(4)
                            ]
                        }
                    },
                    {
                        field: 'noso',
                        title: 'No. SCO',
                        sortable: true
                    },
                    {
                        field: 'customer_nama',
                        title: 'Customer',
                        sortable: true
                    }, {
                        field: 'tgl_po',
                        title: 'Tgl SCO',
                        sortable: 'true'
                    }, {
                        field: 'tgl_create',
                        title: 'Tgl CO',
                        sortable: 'true'
                    }, {
                        field: 'tgl_delivery',
                        title: 'Tgl dikirim',
                        sortable: 'true'
                    }, {
                        field: 'qty',
                        title: 'Qty SKU',
                        align: 'center',
                        sortable: 'true'
                    }, {
                        field: 'No_Co',
                        title: 'Aksi',
                        align: 'center',
                        valign: 'middle',
                        formatter: function(value, row, index) {
                            return [
                                '<button class="btn btn-warning btn-xs see" title="Lihat SKU" data-code="' + value + '" rel="tooltip"><i class="fa fa-eye"></i></button> ' +
                                '<button class="btn btn-primary btn-xs comment" data-code="' + value + '" title="Tambahkan comment"><i class="fa fa-plus"></i></button>'
                            ].join('');
                        }
                    }
                ],
                pagination: true,
                search: true,
                showColumns: true
            });

            $('body').on('click', '#tb_co .see', function() {
                var id = $(this).data('code');
                $.ajax({
                    url: "modal/dataco_sales.php",
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#coModal").modal('show');
                        $("#htmlCo").html(data);
                        $(".tb_sku").bootstrapTable({
                            pagination: true,
                            search: true
                        })
                    }
                });
            });

            $('body').on('click', '#tb_co .comment', function() {
                var id = $(this).data('code');
                $.ajax({
                    url: 'modal/formKomplain.php',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#coModal").modal('show');
                        $("#htmlCo").html(data);
                        $(".modal-footer").append('<button type="button" class="btn btn-primary saveKomplain" id="saveKomplain" disabled="">Simpan</button>');
                        var index = $("#count").val();
                        // plugins
                        $(".komplen").summernote({
                            height: 100,
                            placeholder: 'Isi komplain disini',
                            tabsize: 2,
                            toolbar: [
                                ['font', ['bold', 'underline', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph']]
                            ]
                        });
                        $(".tindakan").summernote({
                            height: 100,
                            placeholder: 'Isi tindakan disini',
                            tabsize: 2,
                            toolbar: [
                                ['font', ['bold', 'underline', 'clear']],
                                ['para', ['ul', 'ol', 'paragraph']]
                            ]
                        });
                        
                        $('input[type=checkbox]').on('change', function(evt) {
                            var item = $('input[id=intid]:checked');
                            if (item.length = 0) {
                                $('#saveKomplain').prop("disabled", true);
                            } else {
                                $('#saveKomplain').prop("disabled", false);
                            }
                        });

                        $("#saveKomplain").click(() => {
                            var formHeader = $("#formHeader").serializeArray();
                            var isi = $("#isi").val();
                            var tindakan = $("#tindakan").val();

                            if (isi == "" || tindakan == "") {
                                alert("Isi komplain dan tindakan terlebih dahulu");
                                return false;
                            } else {
                                $.ajax({
                                    url: 'modal/headerKomplain.php',
                                    method: 'POST',
                                    data: formHeader,
                                    success: function(data) {
                                        console.log(data);
                                        $("#coModal").modal('hide');
                                        $table.bootstrapTable('refresh');

                                        var idkomplain = data;
                                        for (var i = 1; i <= index; i++) {
                                            var form = $('#form' + (i)).serializeArray();

                                            form.push({
                                                name: "idcomplain",
                                                value: idkomplain
                                            });

                                            form.push({
                                                name: "no_urut",
                                                value: i
                                            });

                                            $.ajax({
                                                url: 'modal/detailKomplain.php',
                                                method: 'POST',
                                                data: form,
                                                success: function(data) {
                                                    console.log(data);
                                                }
                                            });
                                        }
                                    }
                                });
                            }


                            $(document).ajaxStart(function() {
                                $("#insert").modal({
                                    backdrop: 'static',
                                    keyboard: true,
                                    show: true
                                });
                            }).ajaxStop(function() {
                                $("#insert").modal('hide');
                                swal.fire({
                                    title: 'Komplain tersimpan',
                                    text: 'komplain akan segera diproses',
                                    icon: 'success',
                                    allowOutsideClick: false
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            });
                        });

                    }
                });
            });
        });
    </script>