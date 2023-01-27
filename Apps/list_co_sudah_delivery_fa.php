<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls']; 
    if (isset($_SESSION['usernameu']) || $akses == '2' ){
        
    }else
    {
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
                            <strong>Customer Order Delivery</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> Customer Order Delivery</h5>
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
                                        <thead class="table-info">
                                            <tr>
                                                <th class="text-center"> No </th>
                                                <th class="text-center" style="min-width:130px">
                                                    Tanggal Kirim
                                                <th class="text-center" style="min-width:130px" data-priority="1"> FA
                                                <th class="text-center" style="min-width:110px" data-priority="1"> BL
                                                </th>
                                                <!-- <th class="text-center "> Order</th>
                                                <th class="text-center" style="min-width:70px"> Kirim</th> -->
                                                <th class="text-center">Customer</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center"> Delivery</th>
                                                <th class="text-center"> Gudang</th>
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

                <div class="modal-footer d-flex justify-content-between">
                    <form method="get" action="modal_agil/print_fa.php" target="_blank">
                        <input type="hidden" value="" name="noco_fa" id="noco_fa">
                        <button type="submit" class="btn btn-secondary "><i class="fa fa-print"></i> FA</button>
                    </form>
                    <button type="button" class="btn btn-default " data-dismiss='modal'>close</button>
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
        var buttonApprove =
            "<button class='btn btn-primary btn-xs approve_fa' title='approve fa' rel='tooltip'><span class='fa fa-check'></span></button>";
        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_co_delivery_fa.php",
            "columnDefs": [
                // {
                //     "targets": -1,
                //     "responsivePriority": 1,
                //     "data": null,
                //     "orderable": false,
                //     "defaultContent": "<center> " +
                //         buttonView + buttonApprove + " </center>"
                // },
                // {
                //     "responsivePriority": 2,
                //     "targets": -1
                // },
                {
                    "targets": 0,
                    "className": "text-center",
                },
                {
                    "targets": 1,
                    "className": "text-center",
                },
                {
                    "targets": 2,
                    "className": "text-center",
                },
                {
                    "targets": 3,
                    "className": "text-center",
                },
                {
                    "targets": 4,
                    "className": "text-center",
                },
                {
                    "targets": 5,
                    "className": "text-center",
                },
                {
                    "targets": 6,
                    "className": "text-center",
                },
                {
                    "targets": 7,
                    "className": "text-center",
                },
                {
                    "targets": 8,
                    "className": "text-center",
                }



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
            $("#noco_fa").val(noco);
            $.ajax({
                url: "modal_agil/ambilDetailCODelivery_fa.php",
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
                    });
                    // jumlah sku di detail 
                    var jumlah = $("input[name=total]").val();

                    // penjumlahan rumus
                    for (let index = 1; index <= jumlah; index++) {
                        $("#qty_kirim_" + index).change(() => {
                            var qty_kirim_static = parseInt($("#qty_kirim_static_" +
                                    index)
                                .val());
                            var qty_kirim = parseInt($("#qty_kirim_" + index)
                                .val());
                            var harga = parseInt($("#price_" + index).val());
                            var ppn = parseInt($("#ppn_" + index).val());
                            var diskon = parseInt($("#diskon_" + index).val()) /
                                parseInt(qty_kirim_static);
                            diskon = diskon * parseInt(qty_kirim);
                            var amount = qty_kirim * harga;
                            var hasil = (amount) - diskon + ppn;
                            console.log("diskon: " + diskon);
                            // $("#diskon_" + index).val(diskon);
                            // $("#harga_total_" + index).val(hasil);
                            // $("#amount_" + index).val(amount);
                        });
                        // $("#qty_kirim_" + index).change(() => {
                        //     var qty_kirim = parseInt($("#qty_kirim_" + index)
                        //         .val());
                        //     var harga = parseInt($("#price_" + index).val());
                        //     var ppn = parseInt($("#ppn_" + index).val());
                        //     var diskon = parseInt($("#diskon_" + index).val());
                        //     var amount = qty_kirim * harga;
                        //     var hasil = (amount + ppn) - diskon;
                        //     $("#harga_total_" + index).val(hasil);
                        //     $("#amount_" + index).val(amount);
                        // });

                    }

                    $('.kirim').click(function() {
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
                            var alamat = $('#alamat_hdr').html();
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
                                    "alamat": alamat,
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
                        $.when(kirim_semua()).then(refresh());
                    });

                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }


                }
            });
        });


        $('#example tbody').on('click', '.approve_fa', function() {
            var data = table.row($(this).parents('tr')).data();
            var noco = data[0];
            var status = '3';

            $.ajax({
                url: 'modal_agil/updateStatusDeliveryFa.php',
                method: 'post',
                data: {
                    'status': status,
                    'noco': noco,
                },
                success: (data) => {
                    location.reload(true);
                }
            });
        });


    });
    </script>