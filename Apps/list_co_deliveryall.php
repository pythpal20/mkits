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


$ambil_id_terakhir = "SELECT max(no_keepstock) as idmax FROM keepstock ";
$result_id = $db1->query($ambil_id_terakhir);
$no_keep = (int)$result_id->fetch_assoc()['idmax']+1;

      // function id
function add_leading_zero($value, $threshold = 4) {
    return sprintf('%0' . $threshold . 's', $value);
}
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

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
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
                    <h2>Delivery</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Delivery</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Customer Order</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span
                                            class="fa fa-child"></span> Order By Sales</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span
                                            class="fa fa-cloud"></span> Order By Marketplace</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span
                                            class="fa fa-building-o"></span> Order By Toko</a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span
                                            class="fa fa-building-o"></span> Order Internal</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped" id="example" width="100%">
                                                <thead scoop="row">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No
                                                            BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th>Status Delivery</th>
                                                        <th data-priority="2">Action</th>
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
                                                <thead scoop="row">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No
                                                            BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th>Status Delivery</th>
                                                        <th data-priority="2">Action</th>
                                                        <!-- <th>Ongkir</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Kirim</th> -->
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
                                                <thead scoop="row">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No
                                                            BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th>Status Delivery</th>
                                                        <th data-priority="2">Action</th>
                                                        <!-- <th>Ongkir</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Kirim</th> -->
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
                                                <thead scoop="row">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No
                                                            BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th>Status Delivery</th>
                                                        <th data-priority="2">Action</th>
                                                        <!-- <th>Ongkir</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Kirim</th> -->
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
    <?php include 'template/load_js.php';?>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <!-- modal 
    -->
    <div class="modal inmodal fade" id="modalview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                    <h4 class="modal-title">Detail CO</h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body" id="detailModal">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss='modal'>close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js">
    </script> -->
    <script>
    //1. Tabel Sales Order
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        $.fn.dataTable.tables({
                visible: true,
                api: true
            })
            .columns.adjust()
            .responsive.recalc()
            .draw();
    });
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tableco = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_co.php",
            "fixedColumns": true,
            columnDefs: [{
                    "targets": -1,
                    "responsivePriority": 1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + " </center>"
                },
                {
                    "responsivePriority": 2,
                    "targets": -1
                },
                {
                    "responsivePriority": 3,
                    "targets": 8
                },
            ],
            "order": [
                [8, 'asc']
            ]
        });
        tableco.on('draw.dt', function() { //penomoran pada tabel
            var info = tableco.page.info();
            tableco.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#example tbody').on('click', '.seedata', function() { //viewdata delivery
            var data = tableco.row($(this).parents('tr')).data();
            var noco = data[0];
            $.ajax({
                url: "modal_agil/ambilDetailCOall.php",
                method: "POST",
                data: {
                    noco: noco
                },
                success: function(data) {
                    // permodalan
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    // edit detail button
                    $('.edit_detail').click(function() {
                        event.preventDefault();
                        $("#option_alasan").removeClass("d-none");

                        var data_detail = $(this).attr(
                            'data-detail');
                        if ($(this).hasClass("btn-default")) {
                            $(data_detail).prop('readonly', false);
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-info");
                        } else {
                            $(data_detail).prop('readonly', true);
                            $(this).removeClass("btn-info");
                            $(this).addClass("btn-default");
                        }
                        $(".kirim").addClass("disabled");
                    });
                    // jumlah sku di detail
                    var jumlah = $("input[name=total]").val();
                    // penjumlahan rumus
                    for (let index = 1; index <= jumlah; index++) {
                        $("#qty_kirim_" + index).keyup(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });

                    }

                    $('.kirim').click(function() {
                        var kenek = $('#kenek').val();
                        var nopol = "";
                        if ($('#nopol').val() == "other") {
                            nopol = $('#nopol_other').val();
                        } else {
                            nopol = $('#nopol').val();
                        }
                        var jenis = $('#jenis').val();
                        var sopir = $('#sopir').val();

                        function kirim_semua() {
                            // jumlah sku di detail 
                            var jumlah = $("input[name=total]").val();
                            // kirim header
                            var noco = $('#noco_hdr').html();
                            var noso = $('#noso_hdr').html();
                            var nosh = $('#nosh_hdr').html();
                            var nobl = $('#nobl_hdr').html();
                            var nofa = $('#nofa_hdr').html();
                            var customer = $('#customer_hdr')
                                .html();
                            var customer_id = $('#customer_id_hdr')
                                .html();
                            var alamat = $('#alamat_hdr').html();
                            var alasan = $('#alasan').val();

                            $.ajax({
                                url: 'modal_agil/insert_header_co_delivery.php',
                                method: 'post',
                                data: {
                                    "noco": noco,
                                    "noso": noso,
                                    "nosh": nosh,
                                    "nobl": nobl,
                                    "nofa": nofa,
                                    "customer": customer,
                                    "customer_id": customer_id,
                                    "alamat": alamat,
                                    "alasan": alasan,
                                    "kenek": kenek,
                                    "nopol": nopol,
                                    "sopir": sopir,
                                    "jenis": jenis,
                                },
                                success: (data) => {
                                    console.log(data);
                                }
                            });

                            // kirim detail per form
                            for (var i = 1; i <= jumlah; i++) {
                                event.preventDefault();
                                var form = $('#form_' + i)
                                    .serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(
                                            data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" ||
                            nopol_other ==
                            "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!"
                            );
                        } else {
                            $.when(kirim_semua()).then(refresh());
                        }
                    });

                    $('.reschedule').click(function() {
                        var tanggal = $('#jadwalkan').val();
                        var bl = $('#nobl_hdr').html();
                        if (!tanggal) {
                            alert('tolong isi tanggal!');
                        } else {
                            $.ajax({
                                url: 'modal_agil/updateDeliveryCO.php',
                                method: 'post',
                                data: {
                                    'tanggal': tanggal,
                                    'bl': bl,
                                },
                                success: (data) => {
                                    console.log(data);
                                    location.reload(
                                        true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }

                    $("#alasan").change(function() {
                        if ($(this).val() != "0") {
                            $(".kirim").removeClass("disabled");
                        } else {
                            $(".kirim").addClass("disabled");
                        }
                    });

                    $("#nopol").change(function() {
                        var jenis = "";
                        switch ($(this).val()) {
                            case "D 8809 FP":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8106 EO":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8927 EN":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8138 FP":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8466 EN":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8977 FQ":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8320 EO":
                                jenis = "Grandbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8583 FD":
                                jenis = "Wingbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8711 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "D 8713 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "other":
                                $("#nopol_div").append(
                                    "<input type='text' name='nopol' id='nopol_other' style='max-width:130px;' placeholder='nopol' class='form-control'>"
                                );
                                jenis = "";
                                break;
                            default:
                        }

                        $("#jenis").val(jenis);


                    });
                }
            });
        });

    });
    //2. Tabel Marketplace 
    $(document).ready(function() {

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tablecomtp = $('#example2').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/co_dlv_marketplace.php",
            "columnDefs": [{
                    "targets": -1,
                    "responsivePriority": 1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + " </center>"
                },
                {
                    "responsivePriority": 2,
                    "targets": -1
                },
                {
                    "responsivePriority": 3,
                    "targets": 8
                },
            ],
            "order": [
                [8, 'asc']
            ]
        });

        tablecomtp.on('draw.dt', function() { //penomoran pada tabel
            var info = tablecomtp.page.info();
            tablecomtp.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#example2 tbody').on('click', '.seedata', function() { //viewdata delivery
            var data = tablecomtp.row($(this).parents('tr')).data();
            var noco = data[0];
            $.ajax({
                url: "modal_agil/ambilDetailCO.php",
                method: "POST",
                data: {
                    noco: noco
                },
                success: function(data) {
                    // permodalan
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    // edit detail button
                    $('.edit_detail').click(function() {
                        event.preventDefault();
                        $("#option_alasan").removeClass("d-none");

                        var data_detail = $(this).attr(
                            'data-detail');
                        if ($(this).hasClass("btn-default")) {
                            $(data_detail).prop('readonly', false);
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-info");
                        } else {
                            $(data_detail).prop('readonly', true);
                            $(this).removeClass("btn-info");
                            $(this).addClass("btn-default");
                        }
                        $(".kirim").addClass("disabled");
                    });
                    // jumlah sku di detail 
                    var jumlah = $("input[name=total]").val();

                    // penjumlahan rumus
                    for (let index = 1; index <= jumlah; index++) {
                        $("#qty_kirim_" + index).keyup(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });

                    }

                    $('.kirim').click(function() {
                        var kenek = $('#kenek').val();
                        var nopol = "";
                        if ($('#nopol').val() == "other") {
                            nopol = $('#nopol_other').val();
                        } else {
                            nopol = $('#nopol').val();
                        }
                        var jenis = $('#jenis').val();
                        var sopir = $('#sopir').val();

                        function kirim_semua() {
                            // jumlah sku di detail 
                            var jumlah = $("input[name=total]")
                                .val();

                            // kirim header
                            var noco = $('#noco_hdr').html();
                            var noso = $('#noso_hdr').html();
                            var nosh = $('#nosh_hdr').html();
                            var nobl = $('#nobl_hdr').html();
                            var nofa = $('#nofa_hdr').html();
                            var customer = $('#customer_hdr')
                                .html();
                            var customer_id = $('#customer_id_hdr')
                                .html();
                            var alamat = $('#alamat_hdr').html();
                            var alasan = $('#alasan').val();

                            $.ajax({
                                url: 'modal_agil/insert_header_co_delivery.php',
                                method: 'post',
                                data: {
                                    "noco": noco,
                                    "noso": noso,
                                    "nosh": nosh,
                                    "nobl": nobl,
                                    "nofa": nofa,
                                    "customer": customer,
                                    "customer_id": customer_id,
                                    "alamat": alamat,
                                    "alasan": alasan,
                                    "kenek": kenek,
                                    "nopol": nopol,
                                    "sopir": sopir,
                                    "jenis": jenis,
                                },
                                success: (data) => {
                                    console.log(data);
                                }
                            });

                            // kirim detail per form
                            for (var i = 1; i <= jumlah; i++) {
                                event.preventDefault();
                                var form = $('#form_' + i)
                                    .serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(
                                            data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" ||
                            nopol_other ==
                            "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!"
                            );
                        } else {
                            $.when(kirim_semua()).then(refresh());
                        }
                    });

                    $('.reschedule').click(function() {
                        var tanggal = $('#jadwalkan').val();
                        var bl = $('#nobl_hdr').html();
                        if (!tanggal) {
                            alert('tolong isi tanggal!');
                        } else {
                            $.ajax({
                                url: 'modal_agil/updateDeliveryCO.php',
                                method: 'post',
                                data: {
                                    'tanggal': tanggal,
                                    'bl': bl,
                                },
                                success: (data) => {
                                    console.log(data);
                                    location.reload(
                                        true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }

                    $("#alasan").change(function() {
                        if ($(this).val() != "0") {
                            $(".kirim").removeClass("disabled");
                        } else {
                            $(".kirim").addClass("disabled");
                        }
                    });

                    $("#nopol").change(function() {
                        var jenis = "";
                        switch ($(this).val()) {
                            case "D 8809 FP":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8106 EO":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8927 EN":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8138 FP":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8466 EN":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8977 FQ":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8320 EO":
                                jenis = "Grandbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8583 FD":
                                jenis = "Wingbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8711 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "D 8713 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "other":
                                $("#nopol_div").append(
                                    "<input type='text' name='nopol' id='nopol_other' style='max-width:130px;' placeholder='nopol' class='form-control'>"
                                );
                                jenis = "";
                                break;
                            default:
                        }

                        $("#jenis").val(jenis);


                    });
                }
            });
        });

    });
    //3. Tabel Showroom
    $(document).ready(function() {

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tablecoshw = $('#example3').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/co_dlv_toko.php",
            "columnDefs": [{
                    "targets": -1,
                    "responsivePriority": 1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + " </center>"
                },
                {
                    "responsivePriority": 2,
                    "targets": -1
                },
                {
                    "responsivePriority": 3,
                    "targets": 8
                },
            ],
            "order": [
                [8, 'asc']
            ]
        });

        tablecoshw.on('draw.dt', function() { //penomoran pada tabel
            var info = tablecoshw.page.info();
            tablecoshw.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#example3 tbody').on('click', '.seedata', function() { //viewdata delivery
            var data = tablecoshw.row($(this).parents('tr')).data();
            var noco = data[0];
            $.ajax({
                url: "modal_agil/ambilDetailCO.php",
                method: "POST",
                data: {
                    noco: noco
                },
                success: function(data) {
                    // permodalan
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    // edit detail button
                    $('.edit_detail').click(function() {
                        event.preventDefault();
                        $("#option_alasan").removeClass("d-none");

                        var data_detail = $(this).attr(
                            'data-detail');
                        if ($(this).hasClass("btn-default")) {
                            $(data_detail).prop('readonly', false);
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-info");
                        } else {
                            $(data_detail).prop('readonly', true);
                            $(this).removeClass("btn-info");
                            $(this).addClass("btn-default");
                        }
                        $(".kirim").addClass("disabled");
                    });
                    // jumlah sku di detail 
                    var jumlah = $("input[name=total]").val();

                    // penjumlahan rumus
                    for (let index = 1; index <= jumlah; index++) {
                        $("#qty_kirim_" + index).keyup(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });

                    }

                    $('.kirim').click(function() {
                        var kenek = $('#kenek').val();
                        var nopol = "";
                        if ($('#nopol').val() == "other") {
                            nopol = $('#nopol_other').val();
                        } else {
                            nopol = $('#nopol').val();
                        }
                        var jenis = $('#jenis').val();
                        var sopir = $('#sopir').val();

                        function kirim_semua() {
                            // jumlah sku di detail 
                            var jumlah = $("input[name=total]")
                                .val();

                            // kirim header
                            var noco = $('#noco_hdr').html();
                            var noso = $('#noso_hdr').html();
                            var nosh = $('#nosh_hdr').html();
                            var nobl = $('#nobl_hdr').html();
                            var nofa = $('#nofa_hdr').html();
                            var customer = $('#customer_hdr')
                                .html();
                            var customer_id = $('#customer_id_hdr')
                                .html();
                            var alamat = $('#alamat_hdr').html();
                            var alasan = $('#alasan').val();

                            $.ajax({
                                url: 'modal_agil/insert_header_co_delivery.php',
                                method: 'post',
                                data: {
                                    "noco": noco,
                                    "noso": noso,
                                    "nosh": nosh,
                                    "nobl": nobl,
                                    "nofa": nofa,
                                    "customer": customer,
                                    "customer_id": customer_id,
                                    "alamat": alamat,
                                    "alasan": alasan,
                                    "kenek": kenek,
                                    "nopol": nopol,
                                    "sopir": sopir,
                                    "jenis": jenis,
                                },
                                success: (data) => {
                                    console.log(data);
                                }
                            });

                            // kirim detail per form
                            for (var i = 1; i <= jumlah; i++) {
                                event.preventDefault();
                                var form = $('#form_' + i)
                                    .serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(
                                            data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" ||
                            nopol_other ==
                            "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!"
                            );
                        } else {
                            $.when(kirim_semua()).then(refresh());
                        }
                    });

                    $('.reschedule').click(function() {
                        var tanggal = $('#jadwalkan').val();
                        var bl = $('#nobl_hdr').html();
                        if (!tanggal) {
                            alert('tolong isi tanggal!');
                        } else {
                            $.ajax({
                                url: 'modal_agil/updateDeliveryCO.php',
                                method: 'post',
                                data: {
                                    'tanggal': tanggal,
                                    'bl': bl,
                                },
                                success: (data) => {
                                    console.log(data);
                                    location.reload(
                                        true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }

                    $("#alasan").change(function() {
                        if ($(this).val() != "0") {
                            $(".kirim").removeClass("disabled");
                        } else {
                            $(".kirim").addClass("disabled");
                        }
                    });

                    $("#nopol").change(function() {
                        var jenis = "";
                        switch ($(this).val()) {
                            case "D 8809 FP":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8106 EO":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8927 EN":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8138 FP":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8466 EN":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8977 FQ":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8320 EO":
                                jenis = "Grandbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8583 FD":
                                jenis = "Wingbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8711 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "D 8713 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "other":
                                $("#nopol_div").append(
                                    "<input type='text' name='nopol' id='nopol_other' style='max-width:130px;' placeholder='nopol' class='form-control'>"
                                );
                                jenis = "";
                                break;
                            default:
                        }

                        $("#jenis").val(jenis);


                    });
                }
            });
        });

    });
    //4. Tabel Internal
    $(document).ready(function() {

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tablecoint = $('#example4').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/co_dlv_internal.php",
            "columnDefs": [{
                    "targets": -1,
                    "responsivePriority": 1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + " </center>"
                },
                {
                    "responsivePriority": 2,
                    "targets": -1
                },
                {
                    "responsivePriority": 3,
                    "targets": 8
                },
            ],
            "order": [
                [8, 'asc']
            ]
        });

        tablecoint.on('draw.dt', function() { //penomoran pada tabel
            var info = tablecoint.page.info();
            tablecoint.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#example4 tbody').on('click', '.seedata', function() { //viewdata delivery
            var data = tablecoint.row($(this).parents('tr')).data();
            var noco = data[0];
            $.ajax({
                url: "modal_agil/ambilDetailCO.php",
                method: "POST",
                data: {
                    noco: noco
                },
                success: function(data) {
                    // permodalan
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    // edit detail button
                    $('.edit_detail').click(function() {
                        event.preventDefault();
                        $("#option_alasan").removeClass("d-none");

                        var data_detail = $(this).attr(
                            'data-detail');
                        if ($(this).hasClass("btn-default")) {
                            $(data_detail).prop('readonly', false);
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-info");
                        } else {
                            $(data_detail).prop('readonly', true);
                            $(this).removeClass("btn-info");
                            $(this).addClass("btn-default");
                        }
                        $(".kirim").addClass("disabled");
                    });
                    // jumlah sku di detail 
                    var jumlah = $("input[name=total]").val();

                    // penjumlahan rumus
                    for (let index = 1; index <= jumlah; index++) {
                        $("#qty_kirim_" + index).keyup(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($(
                                    "#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($(
                                    "#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($(
                                    "#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($(
                                    "#qty_kirim_" +
                                    index)
                                .val());
                            var harga = parseInt($("#price_" +
                                    index)
                                .val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.1 * (amount -
                                    diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static +
                                ppn;
                            $("#diskon_" + index).val(
                                diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });

                    }

                    $('.kirim').click(function() {
                        var kenek = $('#kenek').val();
                        var nopol = "";
                        if ($('#nopol').val() == "other") {
                            nopol = $('#nopol_other').val();
                        } else {
                            nopol = $('#nopol').val();
                        }
                        var jenis = $('#jenis').val();
                        var sopir = $('#sopir').val();

                        function kirim_semua() {
                            // jumlah sku di detail 
                            var jumlah = $("input[name=total]")
                                .val();

                            // kirim header
                            var noco = $('#noco_hdr').html();
                            var noso = $('#noso_hdr').html();
                            var nosh = $('#nosh_hdr').html();
                            var nobl = $('#nobl_hdr').html();
                            var nofa = $('#nofa_hdr').html();
                            var customer = $('#customer_hdr')
                                .html();
                            var customer_id = $('#customer_id_hdr')
                                .html();
                            var alamat = $('#alamat_hdr').html();
                            var alasan = $('#alasan').val();

                            $.ajax({
                                url: 'modal_agil/insert_header_co_delivery.php',
                                method: 'post',
                                data: {
                                    "noco": noco,
                                    "noso": noso,
                                    "nosh": nosh,
                                    "nobl": nobl,
                                    "nofa": nofa,
                                    "customer": customer,
                                    "customer_id": customer_id,
                                    "alamat": alamat,
                                    "alasan": alasan,
                                    "kenek": kenek,
                                    "nopol": nopol,
                                    "sopir": sopir,
                                    "jenis": jenis,
                                },
                                success: (data) => {
                                    console.log(data);
                                }
                            });

                            // kirim detail per form
                            for (var i = 1; i <= jumlah; i++) {
                                event.preventDefault();
                                var form = $('#form_' + i)
                                    .serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(
                                            data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" ||
                            nopol_other ==
                            "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!"
                            );
                        } else {
                            $.when(kirim_semua()).then(refresh());
                        }
                    });

                    $('.reschedule').click(function() {
                        var tanggal = $('#jadwalkan').val();
                        var bl = $('#nobl_hdr').html();
                        if (!tanggal) {
                            alert('tolong isi tanggal!');
                        } else {
                            $.ajax({
                                url: 'modal_agil/updateDeliveryCO.php',
                                method: 'post',
                                data: {
                                    'tanggal': tanggal,
                                    'bl': bl,
                                },
                                success: (data) => {
                                    console.log(data);
                                    location.reload(
                                        true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }

                    $("#alasan").change(function() {
                        if ($(this).val() != "0") {
                            $(".kirim").removeClass("disabled");
                        } else {
                            $(".kirim").addClass("disabled");
                        }
                    });

                    $("#nopol").change(function() {
                        var jenis = "";
                        switch ($(this).val()) {
                            case "D 8809 FP":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8106 EO":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8927 EN":
                                jenis = "Engkel";
                                $("#nopol_other").remove();
                                break;
                            case "D 8138 FP":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8466 EN":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8977 FQ":
                                jenis = "Double";
                                $("#nopol_other").remove();
                                break;
                            case "D 8320 EO":
                                jenis = "Grandbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8583 FD":
                                jenis = "Wingbox";
                                $("#nopol_other").remove();
                                break;
                            case "D 8711 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "D 8713 EY":
                                jenis = "Grandvan";
                                $("#nopol_other").remove();
                                break;
                            case "other":
                                $("#nopol_div").append(
                                    "<input type='text' name='nopol' id='nopol_other' style='max-width:130px;' placeholder='nopol' class='form-control'>"
                                );
                                jenis = "";
                                break;
                            default:
                        }

                        $("#jenis").val(jenis);


                    });
                }
            });
        });

    });
    </script>