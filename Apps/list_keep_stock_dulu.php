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
    <?php include 'template/load_js.php';?>
    <!-- load css library -->
</head>

<body>
    <div id="wrapper">
        <input type="hidden" name="level" id="leveluser" value="<?php echo $data['level']; ?>">
        <input type="hidden" name="namauser" id="namauser" value="<?php echo $data['user_nama']; ?>">
        <input type="hidden" name="moduluser" id="moduluser" value="<?php echo $data['modul']; ?>">

        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Keep Stock</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="list_so_mau_keep.php">Keep Stock</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>List Keep Stock</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Keep Stock</h5>
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
                                    <div class="col-12">
                                        <button class="btn btn-primary pull-right exportBtn">
                                            <i class="fa fa-file-excel-o"></i> export
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="">
                                    <table class="table table-hover display" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-priority="2">No Keep Stock</th>
                                                <th>Customer</th>
                                                <th>Due Date</th>
                                                <th>Noso</th>
                                                <th>Jenis SO</th>
                                                <th>Status</th>
                                                <th>Print</th>
                                                <th data-priority="1">Action</th>
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
    <!-- modal detail keepstock -->
    <div class="modal inmodal fade" id="modalview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                    <h4 class="modal-title">Detail Keep Stock</h4>
                </div>
                <div class="modal-body" id="detailModal">
                </div>

                <div class="modal-footer">
                    <?php if($data['modul'] == '4'&& $data['level']=="admin"):?>
                    <button type="button" class="btn btn-success tutupmodal">Selesai</button>
                    <?php endif;?>
                    <?php if($data['modul'] == '1'&& $data['level']=="admin"):?>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- modal export -->
    <div class="modal inmodal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Export Keep Stock</h4>
                </div>
                <div class="modal-body" id="">
                    <div class="form-group" id="data_5">
                        <label class="font-normal">Range select</label>
                        <form action="exportExcelKeepstock.php" method="post" target="_blank">
                            <div class="input-daterange input-group" id="datepicker">
                                <!-- from export excel -->
                                <input type="text" class="form-control-sm form-control" name="start" id="start"
                                    value="<?=date("m/d/Y")?>">
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" name="end" id="end"
                                    value="<?=date("m/d/Y")?>">
                            </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn-group btn btn-primary ">Download</button>
                    </form>
                    <!--akhir from export excel -->
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- modal detail keepstock -->
    <div class="modal inmodal fade" id="modalCancel" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Cancel Keep Stock</h4>
                </div>
                <div class="modal-body" id="detailCancel">
                    <div class="form-group">
                        <label>Alasan</label>
                        <input type="hidden" name="id_cancel" id="id_cancel" value="">
                        <input type="hidden" name="noso_cancel" id="noso_cancel" value="">
                        <input type="hidden" name="customer_cancel" id="customer_cancel" value="">
                        <input type="text" id="alasan_cancel" name="alasan_cancel" placeholder="masukan alasan"
                            class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary simpanCancel">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.11.3/b-2.0.1/b-colvis-2.0.1/fh-3.2.0/r-2.2.9/datatables.min.js">
    </script>
    <script>
    $(document).ready(function() {
        $('.exportBtn').click(function() {
            $('#exportModal').modal("show");
        });
        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        var buttonView =
            "<button class='btn btn-default btn-sm seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";

        //    if else button req cancel
        var leveluser = $("#leveluser").val();
        var moduluser = $("#moduluser").val();

        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_keepstock.php",
            "columnDefs": [
                // {
                //     "targets": -1,
                //     "data": null,
                //     "orderable": false,
                //     "defaultContent": "<center> " +
                //         buttonView + buttonCancel + " </center>"
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
            var id = data[0];
            var customer = data[2];
            var leveluser = $("#leveluser").val();
            var moduluser = $("#moduluser").val();
            var moduluser = $("#moduluser").val();

            $.ajax({
                url: 'modal_agil/ambilDetailKeepStock.php',
                method: 'post',
                data: {
                    "id": id,
                    "level": leveluser,
                    "modul": moduluser,
                },
                success: (data) => {
                    // disable klik outside
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    $('.keepstock').click(function() {
                        var no_keepstock = $(this).attr("no_keepstock");
                        var id = $(this).attr("id");
                        var noso = $(this).attr("noso");
                        var sku = $(this).attr("sku");
                        var status = $(this).attr("status");
                        var qty_req = $(this).attr("qty_req");
                        var qty_keep = $(this).attr("qty_keep");
                        var jml_req = $('#input_' + id).val();
                        var user = $("#namauser").val();
                        var user_req = $(this).attr("user_req");
                        var total_hitung = parseInt(jml_req) + parseInt(
                            qty_keep);
                        // kondisi pengecekan proses (edit qty keep atau approve)
                        if (status == "edit") {
                            if (total_hitung <= qty_req && parseInt(jml_req) >
                                "0" &&
                                parseInt(jml_req) != " ") {
                                $.ajax({
                                    url: 'modal_agil/editKeep.php',
                                    method: 'post',
                                    data: {
                                        "qty_req": jml_req,
                                        "no_keepstock": no_keepstock,
                                        "status_keep": '0',
                                        "id": id,
                                    },
                                    success: (data) => {
                                        $('#modalview').modal('hide');
                                    }
                                });
                            } else {
                                alert('tidak bisa melakukan aksi!');
                            }
                        } else {
                            if (total_hitung <= qty_req && parseInt(jml_req) >
                                "0" &&
                                parseInt(jml_req) != " " && !$(this).hasClass(
                                    "disabled")
                            ) {


                                $(this).removeClass("btn-primary");
                                $(this).addClass("btn-success");
                                $(this).addClass("disabled");
                                $(this).html("disiapkan");

                                $.ajax({
                                    url: 'modal_agil/updateKeep.php',
                                    method: 'post',
                                    data: {
                                        "qty_keep": jml_req,
                                        "qty_req": qty_req,
                                        "no_keepstock": no_keepstock,
                                        "status_keep": '1',
                                        "id": id,
                                        "user": user,
                                    },
                                    success: (data) => {}
                                });


                            } else {
                                alert('tidak bisa melakukan aksi!');
                            }
                        }
                    });

                    $('.hapus').click(function() {
                        $('#modalview').modal('hide');

                        var id = $(this).attr('id');
                        var qty_req = $(this).attr('qty_req');
                        var sku = $(this).attr('sku');
                        var noso = $(this).attr('noso');
                        Swal.fire({
                            title: 'Apakah yakin sku ' + sku +
                                ' dengan qty req ' + qty_req + ' di noso ' +
                                noso + ' akan dihapus?',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            denyButtonText: `jangan`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'modal_agil/hapus_detail_keepstock.php',
                                    method: 'post',
                                    data: {
                                        "id": id
                                    },
                                    success: (data) => {
                                        console.log(data);
                                        if (data == "1") {
                                            Swal.fire(
                                                'terhapus!',
                                                '',
                                                'success')
                                            location.reload(
                                                true);
                                        } else {
                                            Swal.fire(
                                                'Data keep gagal dihapus',
                                                '',
                                                'danger')
                                            location.reload(
                                                true);
                                        }
                                    }
                                });
                            } else if (result.isDenied) {
                                Swal.fire('Data keep tidak dihapus', '',
                                    'info')
                            }
                        })
                    });
                    $('.selesai').click(function() {
                        var id = $(this).attr('id');
                        var user = $("#namauser").val();
                        var nosh = $("#nosh").val();
                        var noso = $(this).attr('noso');
                        var customer = $(this).attr('customer');
                        if (nosh != "") {
                            $.ajax({
                                url: 'modal_agil/selesaiKeep.php',
                                method: 'post',
                                data: {
                                    "user": user,
                                    "id": id,
                                    "sh": nosh,
                                },
                                success: (data) => {
                                    $.when(kirimnotif()).then(
                                        refresh());

                                }
                            });

                            // notifikasi telegram
                            var url_bot =
                                "https://api.telegram.org/bot5061930493:AAFy0XQqc3qRiGKVqxdwkq2SzJegclk_sXU/sendMessage";
                            var kumpulan_chatid = ["1155974361","-1001644094894"];

                            var text =
                                "________________________________\n" +
                                "<b>=====Keepstock Completed=====</b>\n" +
                                "________________________________\n\n" +
                                "Status:<b>" + "Completed</b>\n\n" +
                                "No. Keepstock :<b> K-" + pad(id, 4) +
                                "</b>\nKeep stock dari Customer :\n<b>" +
                                customer +
                                "</b>\nNo.PO :<b>" +
                                noso +
                                "</b>\nNo.SH :<b>" +
                                nosh +
                                "</b>\nCompleted By: <b>" + user + "</b>";

                            function notif(item, index) {
                                $.ajax({
                                    url: url_bot,
                                    method: 'get',
                                    data: {
                                        chat_id: item,
                                        text: text,
                                        parse_mode: "HTML",
                                    },
                                    success: (data) => {}
                                });
                            }

                            // id keep
                            function pad(num, numZeros) {
                                var n = Math.abs(num);
                                var zeros = Math.max(0, numZeros - Math.floor(n)
                                    .toString().length);
                                var zeroString = Math.pow(10, zeros).toString()
                                    .substr(
                                        1);
                                if (num < 0) {
                                    zeroString = '-' + zeroString;
                                }

                                return zeroString + n;
                            }

                            // foreach notifikasi ke masing masing penerima
                            function kirimnotif() {
                                kumpulan_chatid.forEach(notif);
                            }

                            function refresh() {
                                $('#modalView').modal('toggle');
                                location.reload(true);
                            }
                        } else {
                            alert('Mohon isi No SH!');
                        }
                    });

                    $('.hapusKeepstock').click(function() {
                        var id = $(this).attr('id');
                        var noso = $(this).attr('noso');
                        var customer = $(this).attr('customer');
                        var user = '<?=$data['user_nama'];?>';

                        $.ajax({
                            url: 'modal_agil/hapusKeepstock.php',
                            method: 'post',
                            data: {
                                "id": id,
                            },
                            success: (data) => {
                                console.log(data);
                                $.when(kirimnotif()).then(refresh());
                            }
                        });

                        // notifikasi telegram
                        var url_bot =
                            "https://api.telegram.org/bot5061930493:AAFy0XQqc3qRiGKVqxdwkq2SzJegclk_sXU/sendMessage";
                        var kumpulan_chatid = ["1155974361","-1001644094894"];

                        var text =
                            "________________________________\n" +
                            "<b>=====Keepstock Canceled=====</b>\n" +
                            "________________________________\n\n" +
                            "Status:<b>" + "Canceled</b>\n\n" +
                            "No. Keepstock :<b> K-" + pad(id, 4) +
                            "</b>\nKeep stock dari Customer :\n<b>" +
                            customer +
                            "</b>\nNo.PO :\n<b>" +
                            noso +
                            "</b>\nCanceled By: <b>" + user + "</b>";

                        function notif(item, index) {
                            $.ajax({
                                url: url_bot,
                                method: 'get',
                                data: {
                                    chat_id: item,
                                    text: text,
                                    parse_mode: "HTML",
                                },
                                success: (data) => {}
                            });
                        }

                        // id keep
                        function pad(num, numZeros) {
                            var n = Math.abs(num);
                            var zeros = Math.max(0, numZeros - Math.floor(n)
                                .toString().length);
                            var zeroString = Math.pow(10, zeros).toString().substr(
                                1);
                            if (num < 0) {
                                zeroString = '-' + zeroString;
                            }

                            return zeroString + n;
                        }

                        // foreach notifikasi ke masing masing penerima
                        function kirimnotif() {
                            kumpulan_chatid.forEach(notif);
                        }

                        function refresh() {
                            $('#modalView').modal('toggle');
                            location.reload(true);
                        }
                    });
                }
            });
        });


        $('#example tbody').on('click', '.cancel', function() {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            var customer = data[2];
            var noso = data[3];
            var leveluser = $("#leveluser").val();
            var moduluser = $("#moduluser").val();
            $('#id_cancel').val(id);
            $('#noso_cancel').val(noso);
            $('#customer_cancel').val(customer);
            $('#modalCancel').modal("show");
        });

        $('.simpanCancel').click(function() {
            var alasan = $('#alasan_cancel').val();
            var id_cancel = $('#id_cancel').val();
            var noso = $('#noso_cancel').val();
            var customer = $('#customer_cancel').val();
            var user = $("#namauser").val();


            if (alasan == "") {
                alert('mohon isi alasan !');
            } else {
                $.ajax({
                    url: 'modal_agil/reqHapus.php',
                    method: 'post',
                    data: {
                        "id": id_cancel,
                        "alasan": alasan,
                        "customer": customer,
                        "user": user,
                    },
                    success: (data) => {
                        console.log(data);
                        $.when(kirimnotif()).then(refresh());


                    }
                });
                // notifikasi telegram
                var url_bot =
                    "https://api.telegram.org/bot5061930493:AAFy0XQqc3qRiGKVqxdwkq2SzJegclk_sXU/sendMessage";
                var kumpulan_chatid = ["1155974361","-1001644094894"];

                var text =
                    "________________________________\n" +
                    "<b>=====Keepstock Req Cancel=====</b>\n" +
                    "________________________________\n\n" +
                    "Status:<b>" + "Requesting Cancel</b>\n\n" +
                    "No. Keepstock :<b> K-" + pad(id_cancel, 4) +
                    "</b>\nKeep stock dari Customer :\n<b>" +
                    customer +
                    "</b>\nNo.PO :\n<b>" +
                    noso +
                    "</b>\nAlasan :\n<b>" +
                    alasan +
                    "</b>\nNama Req: <b>" + user + "</b>";

                function notif(item, index) {
                    $.ajax({
                        url: url_bot,
                        method: 'get',
                        data: {
                            chat_id: item,
                            text: text,
                            parse_mode: "HTML",
                        },
                        success: (data) => {}
                    });
                }

                // foreach notifikasi ke masing masing penerima
                function kirimnotif() {
                    kumpulan_chatid.forEach(notif);
                }
                // id keep
                function pad(num, numZeros) {
                    var n = Math.abs(num);
                    var zeros = Math.max(0, numZeros - Math.floor(n).toString().length);
                    var zeroString = Math.pow(10, zeros).toString().substr(1);
                    if (num < 0) {
                        zeroString = '-' + zeroString;
                    }

                    return zeroString + n;
                }

                function refresh() {
                    $('#modalCancel').modal('toggle');
                    location.reload(true);
                }


            }
        });

        $('.tutupmodal').click(function() {

            var count = 0;
            var customer = $('#customerNama').html();
            var user = $("#namauser").val();
            var jumlah_sku = $("#jumlah_sku").val();
            var sudah_notif = 0;
            $('button').each(function(index, element) {
                if ($(this).hasClass('disabled') && !$(this).hasClass('sudahnotif')) {
                    // do sth if disabled
                    count++;

                } else {
                    // do sth if enabled 
                }
                if ($(this).hasClass('sudahnotif')) {
                    sudah_notif = 1;
                } else {

                }
            });
            if (count != parseInt(jumlah_sku)) {
                if (sudah_notif == 1) {

                    $('#modalview').modal('toggle');
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: '',
                        html: '<h4> anda sudah keep semua produk!</h4>',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {

                    $('#modalview').modal('toggle');
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: '',
                        html: '<h4> anda belum keep semua produk!</h4>',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            } else {
                // notifikasi telegram
                var url_bot =
                    "https://api.telegram.org/bot5061930493:AAFy0XQqc3qRiGKVqxdwkq2SzJegclk_sXU/sendMessage";
                var kumpulan_chatid = ["1155974361","-1001644094894"];
                var chat_id_sales = $("#telegramSales").html();
                var sales = $("#namaSales").html();
                var user_req = $("#userReq").html();
                var no_keep = $("#noKeep").html();
                var noso = $("#noso").html();
                kumpulan_chatid.push(chat_id_sales);

                var text =
                    "________________________________\n" +
                    "<b>=====Keepstock Disiapkan=====</b>\n" +
                    "________________________________\n\n" +
                    "Status:<b>" + "Sudah disiapkan</b>\n\n" +
                    "No. Keepstock :<b>" + no_keep +
                    "</b>\nKeep stock <b>baru</b> dari Customer : \n<b>" +
                    customer +
                    "</b>\nNo.PO: <b>" + noso +
                    "</b>\nNama Req: <b>" + user_req +
                    "</b>| produk: <b>" + jumlah_sku + "</b>" +
                    "\nNama Kept: <b>" + user + "</b>";


                // foreach notifikasi ke masing masing penerima
                function kirimnotif() {
                    kumpulan_chatid.forEach(notif);
                }

                function notif(item, index) {
                    $.ajax({
                        url: url_bot,
                        method: 'get',
                        data: {
                            chat_id: item,
                            text: text,
                            parse_mode: "HTML",
                        },
                        success: (data) => {}
                    });
                }

                $.when(kirimnotif()).then(refresh());

                function refresh() {
                    $('#modalview').modal('toggle');
                    var noso = $("#noso").html();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '',
                        html: '<h5>anda sudah melakukan keep ' + count +
                            ' Produk, <br> dengan no keep ' + no_keep +
                            ' !</h5>',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    setTimeout(() => {
                        $.ajax({
                            url: 'modal_agil/updateNotif.php',
                            method: 'post',
                            data: {
                                "notif": '1',
                                "noso": noso,
                            },
                            success: (data) => {
                                location.reload(true);
                            }
                        });
                    }, 2500);
                }
            }


        });
    });
    </script>