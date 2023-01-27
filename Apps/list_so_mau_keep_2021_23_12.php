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
                    <h2>Keep Stock</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="list_so_mau_keep.php">Keep Stock</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Sales Order</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5> Sales Order</h5>
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
                                    <table class="table table-hover display" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>No SO</th>
                                                <th>Customer</th>
                                                <th data-priority="1">Sales</th>
                                                <th class="text-center">Total SKU</th>
                                                <th class="text-center">Total QTY</th>
                                                <th class="text-center">Company</th>
                                                <th class="text-center" data-priority="1">Action</th>
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
    <!-- modal -->
    <div class="modal inmodal fade" id="modalview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                    <h4 class="modal-title">Detail SO</h4>
                    <!-- yg akan menjadi no keep -->
                    <input type="hidden" name="no_keep" id="no_keep" value="<?="K-".add_leading_zero($no_keep)?>">
                    <!-- yg akan menjadi no keep -->
                    <small class="font-bold">klik keep untuk request keep stock ke gudang</small>
                </div>
                <div class="modal-body" id="detailModal">
                </div>

                <div class="modal-footer">
                
                    <button type="button" class="btn btn-info tutupmodal">Selesai</button>
                 
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

        var buttonView =
            "<button class='btn btn-default btn-xs seedata' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var buttonKeep =
            "<button class='btn btn-primary  detailKeep' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button>";
        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "serverside_agil/serverside_so.php",
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "orderable": false,
                    "defaultContent": "<center> " +
                        buttonView + " </center>"
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
            var id = data[0];
            // alert(id);
            $.ajax({
                url: "modal_agil/ambilDetailSkuSo.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // disable klik outside
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#detailModal').html(data);
                    $('#modalview').modal('show');
                    $('.test').click(function() {
                        if ($(this).hasClass("disabled")) {
                            alert('tidak bisa melakukan aksi!');
                        } else {
                            // proses
                            var id = parseInt($(this).attr('id'));
                            var qty = parseInt($(this).attr('qty'));
                            var total_qty_req = $(this).attr('total_qty_req');
                            var sku = $(this).attr('sku');
                            var noso = $(this).attr('noso');
                            var jml_req = $('#input_' + id).val();
                            var no_keep = $('#no_keep').val();
                            var sku = $(this).attr('sku');
                            var customer = $(this).attr('customer');
                            var sales = $(this).attr('sales');
                            var user = $("#namauser").val();
                            var telegramSales = $("#telegramSales").val();
                            var duedate = $("#duedate").val();
                            var ket_qty = $('#ket_' + id).val();

                            var total_hitung = parseInt(jml_req) + parseInt(
                                total_qty_req);
                            if (total_hitung <= qty && parseInt(jml_req) > "0" &&
                                parseInt(jml_req) != " " && duedate != "") {


                                // $(this).removeClass('btn-primary');
                                // $(this).addClass('btn-warning');
                                $(this).addClass('disabled');
                                // Bind normal buttons

                                $.ajax({
                                    url: 'modal_agil/insertKeep.php',
                                    method: 'post',
                                    data: {
                                        "noso": noso,
                                        "jml": jml_req,
                                        "sku": sku,
                                        "customer": customer,
                                        "sales": sales,
                                        "telegramSales": telegramSales,
                                        "duedate": duedate,
                                        "user": user,
                                        "ket": ket_qty,
                                        "qty_po": qty,
                                        "no_keep":  no_keep.split("-")[1]
                                            .replace(/^0+/,
                                                ''),
                                    },
                                    success: (data) => {
                                        setTimeout(() => {
                                            $('#input_' + id)
                                                .attr(
                                                    'readonly',
                                                    'readonly');
                                            $('#ket_' + id)
                                                .attr(
                                                    'readonly',
                                                    'readonly');
                                        }, 300);
                                    }
                                });

                            } else {
                                alert(
                                    'tidak bisa melakukan aksi! mohon isi duedate, dan isi qty dengan benar!'
                                );
                            }
                        }

                    });

                }
            });
        });

        $('.tutupmodal').click(function() {
            var no_keep = $('#no_keep').val();
            var count = 0;
            var customer = "";
            var noso = "";
            var user = $("#namauser").val();
            $('button').each(function(index, element) {
                if ($(this).hasClass('disabled')) {
                    // do sth if disabled
                    count++;
                    customer = $(this).attr("customer");
                    noso = $(this).attr('noso');
                } else {
                    // do sth if enabled 
                }
            });

            if (count == 0) {
                $('#modalview').modal('toggle');
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: '',
                    html: '<h4> anda tidak melakukan keep sama sekali !</h4>',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                // notifikasi telegram
                var url_bot =
                    "https://api.telegram.org/bot5061930493:AAFy0XQqc3qRiGKVqxdwkq2SzJegclk_sXU/sendMessage";
                var kumpulan_chatid = ["1155974361","-1001644094894"];
                var chat_id_sales = $("#telegramSales").html();
                var sales = $("#namaSales").html();
                kumpulan_chatid.push(chat_id_sales);

                var text =
                    "________________________________\n" +
                    "<b>=====Keepstock Baru=====</b>\n" +
                    "________________________________\n\n" +
                    "No. Keepstock :<b>" + no_keep +
                    "</b>\nCustomer : \n<b>" +
                    customer +
                    "</b>\nNo.PO: <b>" + noso +
                    "</b>\nJumlah SKU: <b>" + count +
                    "</b>\nSales: <b>" + sales +
                    "</b>\nNama Req: <b>" + user + "</b>";

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

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '',
                        html: '<h5>anda sudah melakukan keep ' + count +
                            ' SKU, <br> dengan no keep ' + no_keep +
                            ' !</h5>',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    setTimeout(() => {
                        location.reload(true);
                    }, 2500);
                }
            }

        });
    });
    </script>