<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '5'){
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
                    <h2>Delivery CO Sales</h2>
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
            <?php if($data['user_nama'] == 'Ari Sugara') { ?>
            <button type="button" name="expt" id="expt" class="btn btn-success btn-sm modalExport"
                            title="Export To Csv." rel="tooltip"><span class="fa fa-cloud-download"></span> Export
                            Data</button>
               <?php } ?>
            <div class="  animated fadeInRight mt-2 mb-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span class="fa fa-child"></span> PT. MWK</a></li>
                                <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span class="fa fa-cloud"></span> PT. MWM</a></li>
                                <li><a class="nav-link tab3" data-toggle="tab" href="#tab-3" id="tab3"><span class="fa fa-building-o"></span> PT. DTM</a></li>
                                <li><a class="nav-link tab4" data-toggle="tab" href="#tab-4" id="tab4"><span class="fa fa-building-o"></span> PT. BAK</a></li>
                                <li><a class="nav-link tab5" data-toggle="tab" href="#tab-5" id="tab5"><span class="fa fa-building-o"></span> PT. FCI</a></li>
                            </ul>
                            <div class="tab-content">
                                <!-- pt mwk -->
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover display" id="tblDso">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th class="text-center">Method</th>
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
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover display" id="tbmarketplace"
                                                style="width: 100%;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th class="text-center">Method</th>
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
                                            <table class="table table-hover display" id="tbshowroom"
                                                style="width: 100%;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th class="text-center">Method</th>
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
                                            <table class="table table-hover display" id="tbinternal"
                                                style="width: 100%;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th class="text-center">Method</th>
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
                                <div role="tabpanel" id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover display" id="tbfci"
                                                style="width: 100%;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th class="text-center"> No </th>
                                                        <th class="text-center" style="min-width:110px"
                                                            data-priority="1">No BL
                                                        </th>
                                                        <th class="text-center "> Order</th>
                                                        <th class="text-center" style="min-width:70px"> Tanggal Plan
                                                        </th>
                                                        <th class="text-center">Customer</th>
                                                        <th class="text-center">Kota</th>
                                                        <!--<th class="text-center">Amount</th>-->
                                                        <th class="text-center">Issued by</th>
                                                        <th class="text-center">Sales</th>
                                                        <th class="text-center">Method</th>
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

    <!-- modal -->
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
    <div class="modal inmodal fade" id="modalExport" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Data Planning Pengiriman</h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body" id="detailModalExport">
                    <form target="_blank" action="exportExcelPlan.php" method="post">
                        <div class="form-group" id="data_5">
                            <label class="font-normal">Range select</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="start"
                                    value="<?= date("m/d/Y") ?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end"
                                    value="<?= date("m/d/Y") ?>">
                                <button class="btn btn-primary btn-sm export">export</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss='modal'>close</button>
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
                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-info"
                        style="width: 100%" role="progressbar" aria-valuenow="100%" aria-valuemin="0"
                        aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $('.modalExport').click(function() {
        $("#modalExport").modal("show");
    });

    $('.export').click(function() {
        $("#modalExport").modal("hide");
    });

    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
       $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function(e) {
        $.fn.dataTable.tables({
                visible: true,
                api: true
            })
            .columns.adjust()
            .responsive.recalc()
            .draw();
    });
    //table mwk
    $(document).ready(function() {

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var table = $('#tblDso').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/delivery_comwk.php?id=1",
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
                    "targets": 9
                },
            ],
            "order": [
                [9, 'asc']
            ]
        });

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

        $('#tblDso tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
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

                        var data_detail = $(this).attr('data-detail');
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
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());
                            // diskon
                            // var diskon = parseInt(diskon_static) /
                            //     parseInt(qty_kirim_static);
                            // diskon = diskon * parseInt(qty_kirim);
                            // amount
                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
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
                            var customer = $('#customer_hdr').html();
                            var customer_id = $('#customer_id_hdr').html();
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
                                var form = $('#form_' + i).serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" || nopol_other == "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
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
                                    location.reload(true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#insert').modal("show");
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            },
                            5000);
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
                            case "D 8146 FR":
                                jenis = "Carry Box";
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

    //table mwm
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tablem = $('#tbmarketplace').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/delivery_comwm.php?id=1",
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
                    "targets": 9
                },
            ],
            "order": [
                [9, 'asc']
            ]
        });

        tablem.on('draw.dt', function() {
            var info = tablem.page.info();
            tablem.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tbmarketplace tbody').on('click', '.seedata', function() {
            var data = tablem.row($(this).parents('tr')).data();
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

                        var data_detail = $(this).attr('data-detail');
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
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
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
                            var customer = $('#customer_hdr').html();
                            var customer_id = $('#customer_id_hdr').html();
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
                                var form = $('#form_' + i).serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" || nopol_other == "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
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
                                    location.reload(true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#insert').modal("show");
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            },
                            5000);
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

    //table dtm
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tabletoko = $('#tbshowroom').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/delivery_codtm.php?id=1",
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
                    "targets": 9
                },
            ],
            "order": [
                [9, 'asc']
            ]
        });

        tabletoko.on('draw.dt', function() {
            var info = tabletoko.page.info();
            tabletoko.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tbshowroom tbody').on('click', '.seedata', function() {
            var data = tabletoko.row($(this).parents('tr')).data();
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

                        var data_detail = $(this).attr('data-detail');
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
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
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
                            var customer = $('#customer_hdr').html();
                            var customer_id = $('#customer_id_hdr').html();
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
                                var form = $('#form_' + i).serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" || nopol_other == "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
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
                                    location.reload(true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#insert').modal("show");
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            },
                            5000);
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

    //table bak
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tabletoko = $('#tbinternal').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/delivery_cobak.php?id=1",
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
                    "targets": 9
                },
            ],
            "order": [
                [9, 'asc']
            ]
        });

        tabletoko.on('draw.dt', function() {
            var info = tabletoko.page.info();
            tabletoko.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tbinternal tbody').on('click', '.seedata', function() {
            var data = tabletoko.row($(this).parents('tr')).data();
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

                        var data_detail = $(this).attr('data-detail');
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
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
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
                            var customer = $('#customer_hdr').html();
                            var customer_id = $('#customer_id_hdr').html();
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
                                var form = $('#form_' + i).serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" || nopol_other == "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
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
                                    location.reload(true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#insert').modal("show");
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            },
                            5000);
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
    // FCI
    $(document).ready(function() {
        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var tabletoko = $('#tbfci').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/delivery_cofci.php?id=1",
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
                    "targets": 9
                },
            ],
            "order": [
                [9, 'asc']
            ]
        });

        tabletoko.on('draw.dt', function() {
            var info = tabletoko.page.info();
            tabletoko.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        $('#tbfci tbody').on('click', '.seedata', function() {
            var data = tabletoko.row($(this).parents('tr')).data();
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

                        var data_detail = $(this).attr('data-detail');
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
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
                            $("#harga_total_" + index).val(hasil);
                            $("#amount_" + index).val(amount);
                            $("#ppn_" + index).val(ppn);
                        });
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var ppn_static = parseInt($("#ppn_static_" +
                                    index)
                                .val());
                            var diskon_static = parseInt($("#diskon_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());

                            var amount = qty_kirim * harga;
                            // ppn
                            var ppn = 0;
                            if (ppn_static != 0) {
                                ppn = 0.11 * (amount - diskon_static);
                            } else {

                            }
                            var hasil = (amount) - diskon_static + ppn;
                            $("#diskon_" + index).val(diskon_static);
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
                            var customer = $('#customer_hdr').html();
                            var customer_id = $('#customer_id_hdr').html();
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
                                var form = $('#form_' + i).serialize();
                                $.ajax({
                                    url: 'modal_agil/insert_detail_co_delivery.php',
                                    method: 'post',
                                    data: form,
                                    success: (data) => {
                                        console.log(data);
                                    }
                                });
                            }
                        }

                        // nopol other cek
                        var nopol_other = $('#nopol_other').val();

                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || nopol == "0" || nopol_other == "" || !
                            jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
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
                                    location.reload(true);
                                }
                            });
                        }
                    });

                    function refresh() {
                        $('#insert').modal("show");
                        $('#modalView').modal('hide');
                        setTimeout(function() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            },
                            5000);
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