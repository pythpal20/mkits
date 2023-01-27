<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls']; 
    if (isset($_SESSION['usernameu']) || $akses == '4' ){
        
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
                            <strong>Customer Order Delivery </strong>
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
                                <button class="btn btn-primary modalExport">Export</button>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table class="table table-hover display" id="example">
                                        <thead class="table-info">
                                            <tr>
                                                <th class="text-center"> No </th>
                                                <th class="text-center" style="min-width:110px"> Tanggal Kirim
                                                <th class="text-center" style="min-width:110px" data-priority="1"> CO
                                                <th class="text-center" style="min-width:110px" data-priority="1"> BL
                                                </th>
                                                <!-- <th class="text-center "> Order</th>
                                                <th class="text-center" style="min-width:70px"> Kirim</th> -->
                                                <th class="text-center">Customer</th>
                                                <th class="text-center">Qty total</th>
                                                <!-- <th class="text-center">Status Delivery</th> -->
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
    <div class="modal inmodal fade" id="modalExport" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Data Delivery</h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body" id="detailModalExport">
                    <form target="_blank" action="exportExcelDelivery.php" method="post">
                        <div class="form-group" id="data_5">
                            <label class="font-normal">Range select</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="start"
                                    value="<?=date("m/d/Y")?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end"
                                    value="<?=date("m/d/Y")?>">
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
    <!-- modal -->
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
    <!-- modal -->
    <div class="modal inmodal fade" id="modalAlasanGudang" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                    <h4 class="modal-title">Close Pending</h4>
                    <small class="font-bold"></small>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input type="text" name="alasan_dari_gudang" placeholder="alasan" id="alasan_dari_gudang"
                            class="form-control">
                        <input type="hidden" name="id_detail" id="id_detail">
                        <input type="hidden" name="qty_sisa_alasan_gudang" id="qty_sisa_alasan_gudang">
                        <button class="btn btn-sm btn-primary close_manual_gudang">Simpan</button>
                    </div>
                </div>

                <div class=" modal-footer">
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
            "ajax": "serverside_agil/serverside_co_delivery_gudang.php",
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
                url: "modal_agil/ambilDetailCODeliveryGudang.php",
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

                        $("#qty_sisa_diterima_" + index).bind('mouseup keyup',
                            function() {
                                var qty_sisa_diterima = parseInt($(
                                        "#qty_sisa_diterima_" +
                                        index)
                                    .val());
                                var qty_sisa = parseInt($(
                                        "#qty_sisa_" +
                                        index)
                                    .val());
                                if (qty_sisa_diterima <= qty_sisa &&
                                    qty_sisa_diterima >= 0) {
                                    if (qty_sisa_diterima == qty_sisa) {
                                        $("#terima_gudang_" + index).removeClass(
                                            "d-none");
                                        $("#pending_gudang_" + index).addClass(
                                            "d-none");
                                        console.log(index);
                                    } else {
                                        console.log(index);
                                        $("#pending_gudang_" + index).removeClass(
                                            "d-none");
                                        $("#terima_gudang_" + index).addClass(
                                            "d-none");

                                    }
                                } else {
                                    alert(
                                        'tidak bisa melebihi qty awal atau minus!');
                                    $("#qty_sisa_diterima_" + index).val(0);
                                    $("#pending_gudang_" + index).addClass(
                                        "d-none");
                                    $("#terima_gudang_" + index).addClass("d-none");
                                }
                            });

                    }


                    function refresh() {
                        $('#modalView').modal('toggle');
                        location.reload(true);
                    }

                    // $('.terima_gudang').click(function() {
                    //     event.preventDefault();
                    //     var id = $(this).attr('data-id');
                    //     var qty_sisa_diterima = $("#" +
                    //         $(this).attr('data-no')).val();
                    //     var status = '1';
                    //     $.ajax({
                    //         url: 'modal_agil/updateStatusDeliveryGudang.php',
                    //         method: 'post',
                    //         data: {
                    //             'id': id,
                    //             'status': status,
                    //             'qty_sisa_diterima': qty_sisa_diterima,
                    //         },
                    //         success: (data) => {
                    //             location.reload(true);
                    //         }
                    //     });
                    // });

                    // $('.pending_gudang').click(function() {
                    //     event.preventDefault();
                    //     var id = $(this).attr('data-id');
                    //     var qty_sisa_diterima = $("#" +
                    //         $(this).attr('data-no')).val();
                    //     var duedate = $("#" +
                    //         $(this).attr('data-duedate')).val();
                    //     var status = '2';
                    //     $.ajax({
                    //         url: 'modal_agil/updateStatusDeliveryGudang.php',
                    //         method: 'post',
                    //         data: {
                    //             'id': id,
                    //             'status': status,
                    //             'duedate': duedate,
                    //             'qty_sisa_diterima': qty_sisa_diterima,
                    //         },
                    //         success: (data) => {
                    //             location.reload(true);
                    //             // console.log(data);
                    //         }
                    //     });
                    // });
                    // $('.close_gudang').click(function() {
                    //     event.preventDefault();
                    //     var id = $(this).attr('data-id');
                    //     var qty_sisa_diterima = $("#" +
                    //         $(this).attr('data-no')).val();
                    //     var duedate = $("#" +
                    //         $(this).attr('data-duedate')).val();
                    //     var alasan = $("#" +
                    //         $(this).attr('data-alasan')).html();
                    //     var status = '4';
                    //     alasan = alasan.replace(/\s/g, '');
                    //     if (alasan == "") {
                    //         Swal.fire({
                    //             title: 'Apakah yakin akan close pending ? delivery belum mengisi alasan pending!',
                    //             showDenyButton: true,
                    //             showCancelButton: true,
                    //             confirmButtonText: 'Ya, saya ada alasan sendiri',
                    //             denyButtonText: `Tidak`,
                    //         }).then((result) => {
                    //             /* Read more about isConfirmed, isDenied below */
                    //             if (result.isConfirmed) {
                    //                 $('#modalAlasanGudang').modal('toggle');
                    //                 $("#id_detail").val(id);
                    //                 $("#qty_sisa_alasan_gudang").val(
                    //                     qty_sisa_diterima);
                    //             } else if (result.isDenied) {
                    //                 Swal.fire('close pending dibatalkan',
                    //                     '',
                    //                     'info')
                    //             }
                    //         })
                    //         $('#modalview').modal('toggle');


                    //     } else {

                    //         $.ajax({
                    //             url: 'modal_agil/updateStatusDeliveryGudang.php',
                    //             method: 'post',
                    //             data: {
                    //                 'id': id,
                    //                 'status': status,
                    //                 'qty_sisa_diterima': qty_sisa_diterima,
                    //             },
                    //             success: (data) => {
                    //                 location.reload(true);
                    //                 // console.log(data);
                    //             }
                    //         });
                    //     }
                    // });

                    // $('.close_manual_gudang').click(function() {
                    //     var id = $('#id_detail').val();
                    //     var qty_sisa = $('#qty_sisa_alasan_gudang').val();
                    //     var alasan = $('#alasan_dari_gudang').val();
                    //     var status = "4";
                    //     $.ajax({
                    //         url: 'modal_agil/updateStatusDeliveryGudang.php',
                    //         method: 'post',
                    //         data: {
                    //             'id': id,
                    //             'status': status,
                    //             'alasan': alasan,
                    //             'qty_sisa_diterima': qty_sisa,
                    //         },
                    //         success: (data) => {
                    //             location.reload(true);
                    //         }
                    //     });
                    // });
                    
                    
                    $('.terima_gudang').click(function() {
                        event.preventDefault();
                        var id = $(this).attr('data-id');
                        var btn = $(this);
                        var qty_sisa_diterima = $("#" +
                            $(this).attr('data-no')).val();
                        var status = '1';
                        $.ajax({
                            url: 'modal_agil/updateStatusDeliveryGudang.php',
                            method: 'post',
                            data: {
                                'id': id,
                                'status': status,
                                'qty_sisa_diterima': qty_sisa_diterima,
                            },
                            success: (data) => {
                                btn.addClass("disabled");
                            }
                        });
                    });

                    $('.pending_gudang').click(function() {
                        event.preventDefault();
                        var id = $(this).attr('data-id');
                        var btn = $(this);
                        var qty_sisa_diterima = $("#" +
                            $(this).attr('data-no')).val();
                        var duedate = $("#" +
                            $(this).attr('data-duedate')).val();
                        var status = '2';
                        $.ajax({
                            url: 'modal_agil/updateStatusDeliveryGudang.php',
                            method: 'post',
                            data: {
                                'id': id,
                                'status': status,
                                'duedate': duedate,
                                'qty_sisa_diterima': qty_sisa_diterima,
                            },
                            success: (data) => {
                                btn.addClass("disabled");
                                // console.log(data);
                            }
                        });
                    });
                    $('.close_gudang').click(function() {
                        event.preventDefault();
                        var id = $(this).attr('data-id');
                        var btn = $(this);
                        var qty_sisa_diterima = $("#" +
                            $(this).attr('data-no')).val();
                        var duedate = $("#" +
                            $(this).attr('data-duedate')).val();
                        var alasan = $("#" +
                            $(this).attr('data-alasan')).html();
                        var status = '4';
                        alasan = alasan.replace(/\s/g, '');
                        if (alasan == "") {
                            Swal.fire({
                                title: 'Apakah yakin akan close pending ? delivery belum mengisi alasan pending!',
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, saya ada alasan sendiri',
                                denyButtonText: `Tidak`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    $('#modalAlasanGudang').modal('toggle');
                                    $("#id_detail").val(id);
                                    $("#qty_sisa_alasan_gudang").val(
                                        qty_sisa_diterima);
                                } else if (result.isDenied) {
                                    Swal.fire('close pending dibatalkan',
                                        '',
                                        'info')
                                }
                            })
                            $('#modalview').modal('toggle');


                        } else {

                            $.ajax({
                                url: 'modal_agil/updateStatusDeliveryGudang.php',
                                method: 'post',
                                data: {
                                    'id': id,
                                    'status': status,
                                    'qty_sisa_diterima': qty_sisa_diterima,
                                },
                                success: (data) => {
                                    btn.addClass("disabled");
                                    // console.log(data);
                                }
                            });
                        }
                    });

                    $('.close_manual_gudang').click(function() {
                        var id = $('#id_detail').val();
                        var btn = $(this);
                        var qty_sisa = $('#qty_sisa_alasan_gudang').val();
                        var alasan = $('#alasan_dari_gudang').val();
                        var status = "4";
                        $.ajax({
                            url: 'modal_agil/updateStatusDeliveryGudang.php',
                            method: 'post',
                            data: {
                                'id': id,
                                'status': status,
                                'alasan': alasan,
                                'qty_sisa_diterima': qty_sisa,
                            },
                            success: (data) => {
                                btn.addClass("disabled");
                            }
                        });
                    });

                }
            });
        });



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

    });
    </script>