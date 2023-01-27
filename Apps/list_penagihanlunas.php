<?php
include '../config/connection.php';

session_start();
$akses = $_SESSION['moduls'];
if (isset($_SESSION['usernameu']) || $akses == '2') {
} else {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
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
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> List FA</h5>
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
                                <div class="row">
                                    <div class="col-sm-12 m-b-xs">
                                        <button class="btn btn-info btn-sm pull-left exportBtn">
                                            <i class="fa fa-file-excel-o"></i> | Export Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="">
                                    <table class="table table-hover display" id="example" width="100%" data-toggle="example" data-show-toggle="true" data-show-columns="true" data-id-field="No_Co" data-show-footer="false">
                                        <!-- <thead class="table-info">
                                            <tr> -->
                                        <!-- <th class="text-center"> No </th> -->
                                        <!-- <th class="text-center"> Tanggal FA </th>
                                                <th class="text-center"> No FA </th>
                                                <th class="text-center"> No SO </th>
                                                <th class="text-center">
                                                    Customer
                                                <th class="text-center"> Sales
                                                <th class="text-center" data-priority="8">
                                                    Nominal FA Awal
                                                </th>
                                                <th class="text-center" data-priority="7">Nominal Konfirmasi </th> -->
                                        <!-- <th class="text-center">NO FA Akhir </th> -->
                                        <!-- <th class="text-center" data-priority="6">tgl Kontrabon </th>
                                                <th class="text-center" data-priority="5">tgl Duedate </th>
                                                <th class="text-center" data-priority="4">Overdue </th>
                                                <th class="text-center" data-priority="3">Total Bayar </th>
                                                <th class="text-center" data-priority="2">Selisih </th>
                                                <th class="text-center" data-priority="1">Aksi </th> -->
                                        <!-- <th class="text-center">Nominal Pembayaran</th>
                                                <th class="text-center"> Kontra Bon</th>
                                                <th class="tet-center"> Due Date</th>
                                                <th data-priorixty="2">Overdue</th>
                                                <th data-priority="2">Status</th> -->
                                        <!-- </tr>
                                        </thead> -->
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

    <!-- modal export -->
    <div class="modal inmodal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Penagihan Selesai</h4>
                </div>
                <div class="modal-body" id="">
                    <div class="form-group" id="data_5">
                        <label class="font-normal">Pilih renggang waktu</label>
                        <form action="exportPenagihanlunas.php" method="post" target="_blank">
                            <div class="input-daterange input-group" id="datepicker">
                                <!-- from export excel -->
                                <input type="text" class="form-control-sm form-control" name="start" id="start" value="<?= date("m/d/Y") ?>" autocomplete="off">
                                <span class="input-group-addon">s/d</span>
                                <input type="text" class="form-control-sm form-control" name="end" id="end" value="<?= date("m/d/Y") ?>" autocomplete="off">
                            </div>
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
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-group btn btn-primary ">Download</button>
                    </form>
                    <!--akhir from export excel -->
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <?php include 'template/load_js.php'; ?>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
    
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script>
        $.fn.dataTable
            .tables({
                visible: true,
                api: true
            })
            .columns.adjust();
        $(document).ready(function() {
            $("#example").bootstrapTable({
                url: '../serverside/billingComplete.php',
                pagination: true,
                search: true,
                fixedColumns: true,
                fixedNumber: 2,
                fixedRightNumber: 2,
                columns: [{
                    field: 'tgl_inv',
                    title: 'Tgl. Inv',
                    sortable: 'true',
                }, {
                    field: 'nofa_awal',
                    title: 'No. Inv',
                    sortable: 'true'
                }, {
                    field: 'noso',
                    title: 'No. SO',
                    sortable: 'true'
                }, {
                    field: 'customer_nama',
                    title: 'Nama Customer',
                    sortable: 'true'
                }, {
                    field: 'sales',
                    title: 'Nama Sales',
                    sortable: 'true'
                }, {
                    field: 'nominal_awal',
                    title: 'Nominal Awal',
                    sortable: 'true',
                    formatter: Rupiah
                }, {
                    field: 'nominal_akhir',
                    title: 'Nominal Konfirmasi',
                    sortable: 'true',
                    formatter: Rupiah
                }, {
                    field: 'tgl_kontrabon',
                    title: 'Tgl Kontrabon',
                    sortable: 'true'
                }, {
                    field: 'tgl_duedate',
                    title: 'Tgl. Due-date',
                    sortable: 'true'
                }, {
                    field: 'overdue',
                    title: 'Overdue',
                    sortable: 'true'
                }, {
                    field: 'total_bayar',
                    title: 'Total Bayar',
                    sortable: 'true',
                    formatter: Rupiah
                }, {
                    field: 'selisih',
                    title: 'Selisih',
                    sortable: 'true',
                    formatter: function(value) {
                        if(value === '0' || value === '-0'){
                            return [
                                '<label class="label label-info label-xs">LUNAS</label>'
                            ]
                        } else {
                            return [
                                Rupiah(value)
                            ]
                        }
                    }
                }, {
                    field: 'No_Co',
                    title: 'Act',
                    formatter: function(value) {
                        return [
                            '<center> <a href="form_penagihan.php?co='+value+'" class="seedata btn btn-xs btn-primary" target="_blank"><i class="fa fa-eye"></i></a></center>'
                        ]
                    }
                }]
            });

            function Rupiah(value, row) {
                var sign = 1;
                if (value < 0) {
                    sign = -1;
                    value = -value;
                }

                let num = value.toString().includes('.') ? value.toString().split('.')[0] : value.toString();
                let len = num.toString().length;
                let result = '';
                let count = 1;

                for (let i = len - 1; i >= 0; i--) {
                    result = num.toString()[i] + result;
                    if (count % 3 === 0 && count !== 0 && i !== 0) {
                        result = '.' + result;
                    }
                    count++;
                }

                if (value.toString().includes(',')) {
                    result = result + ',' + value.toString().split('.')[1];
                }
                // return result with - sign if negative
                return sign < 0 ? '-' + result : (result ? 'Rp. ' + result : '');
            }

            $('.exportBtn').click(function() {
                $('#exportModal').modal("show");
            });
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

        });
    </script>