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
            <div class="  animated fadeInRight mt-2 mb-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> Customer Order</h5>
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
                                <div class="table-responsive">
                                    <table class="table table-hover display" id="example">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th class="text-center"> No </th>
                                                <th class="text-center" style="min-width:110px" data-priority="1">No BL
                                                </th>
                                                <th class="text-center "> Order</th>
                                                <th class="text-center" style="min-width:70px"> Kirim</th>
                                                <th class="text-center">Customer</th>
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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js">
    </script> -->
    <script>
    $(document).ready(function() {

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_co.php",
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
                    "targets": 7
                },
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

        $('#example tbody').on('click', '.seedata', function() {
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
                                ppn = 0.1 * (amount - diskon_static);
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
                                ppn = 0.1 * (amount - diskon_static);
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
                        var nopol = $('#nopol').val();
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
                        if ($(this).hasClass("disabled")) {
                            alert("isi alasan terlebih dahulu!");
                        } else if (!kenek || !nopol || !jenis) {
                            alert(
                                "isi pic 2, nopol dan jenis terlebih dahulu!");
                        } else {
                            $.when(kirim_semua()).then(refresh());
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
                }
            });
        });

    });
    </script>