<?php
    include '../config/connection.php';
    date_default_timezone_set('Asia/Jakarta');
    session_start();
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) ) {
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
                    <h2>Setoran</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Setoran</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Data Setoran</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Form Konfirmasi Setoran</h5>
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
                                <div class="panel-body text-center">.
                                    <div class="">
                                        <table class="table table-bordered role=" grid" id="example" style="width:100%">
                                            <thead scoop="row">
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th data-priority="1" class="text-center">Tgl. Delivery</th>
                                                    <th class="text-center">Nominal Uang</th>
                                                    <th class="text-center">PIC 1</th>
                                                    <th class="text-center">PIC 2</th>
                                                    <th data-priority="2" class="text-center">Pembayaran</th>
                                                    <th data-priority="3" class="text-center">Aksi</th>
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
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <div class="modal inmodal" id="inserting" tabindex="-1" role="dialog" aria-hidden="true">
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
    <input type="hidden" id="muser" value="<?php echo $data['user_nama']; ?>">
    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        document.getElementById('tagihan').setAttribute('class', 'active');
    });
    </script>
    <script>
    //Tagihan Setoran untuk input dan view
    $(document).ready(function() {
        var muser = $('#muser').val();
        if (muser == "Ari Sugara" || muser == "cecep nurhidayat" || muser == "alif IT" || muser == "Paulus Christofel S (MKITS Developer)") {
        var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/tagihan.php",
            columnDefs: [{
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-success btn-xs acceptdata' data-toggler='tooltip' title='Input Setoran'><span class='fa fa-download'></span> </button> <button class='btn btn-primary btn-xs viewdata'><span class='fa fa-eye'></span> </button>"
            }],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    title: 'Data Setoran'
                },
                {
                    extend: 'excel',
                    title: 'Data Setoran'
                },
                {
                    extend: 'pdf',
                    title: 'Data Setoran'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    title: 'Data Setoran'
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
        $('#example').on('click', '.acceptdata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[1];
            var data3 = btoa(data3);
            var tgl_delivery = data[0];
            var sopir = data[3];
            var kenek = data[4];
            $.ajax({
                url: "modal/terimasetoran.php",
                method: "POST",
                data: {
                    id: tgl_delivery,
                    pic: sopir,
                    pic2: kenek
                },
                success: function(data) {
                    $('#ModalSetoran').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    // console.log(data);

                    $('#FomSetoran').html(data);
                    $('#ModalSetoran').modal('show');

                    //for output
                    var value = $('#total_row').val();
                    for (let i = 1; i <= value; i++) {
                        var sisa = $('#sisa' + i).val();
                        var nm_diterima = $('nomditerima' + i).val();
                        <!--console.log(sisa);-->
                        if(sisa == 0){
                            $('#nomditerima' + i).prop("disabled", true);
                        } else {
                            $('#nomditerima' + i).prop("disabled", false);
                        }
                        
                        //onchange
                        $('#nomditerima' + i).change(function() {
                            var x = $('#nomditerima' + i).val();
                            var y = $('#sisa' + i).val();

                            if (parseInt(y) < parseInt(x)) {
                                $('#nomditerima' + i).val('');
                                alert('Nominal melebihi sisa setoran!');
                            }
                        });
                    }
                    
                    $(".keluar").click(() => {
                        location.reload();
                    });
                    $(".simpan").click(() => {
                        event.preventDefault();
                        var value = $('#total_row').val();
                        <!--var sopir = $('#sopir).val();-->
                        <!--var kenek = $('#kenek).val();-->
                        for (var i = 1; i <= value; i++) {
                            
                            var form = $("#form" + (i)).serializeArray();
                            var nominal = $("#awal" + i).val();
                            form.push({
                                name: "muser",
                                value: muser
                            });
                            form.push({
                                name: "nourut",
                                value: i
                            });
                            form.push({
                                name: "kenek",
                                value: sopir
                            });
                            form.push({
                                name: "sopir",
                                value: kenek
                            });    
                            console.log(form);
                            $.ajax({
                                url: "modal/simpansetoran.php",
                                method: "POST",
                                data: form,
                                success: function(data) {
                                console.log(data);
                                    $('#ModalSetoran').modal("hide");
                                }
                            });
                        }
                        Swal.fire(
                        'Good Job!',
                        'Berhasil Menyimpan Data',
                        'success');
                        setTimeout(function() {
                            // your code to be executed after 1 second
                            location.assign(
                                "tagihanharian.php"
                            );
                        },3000);
                    });
                }
            });
        });
        $('#example').on('click', '.viewdata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[1];
            var data3 = btoa(data3);
            var tgl_delivery = data[0];
            var sopir = data[3];
            var kenek = data[4];
            $.ajax({
                url: "modal/viewtagihan.php",
                method: "POST",
                data: {
                    tgl_delivery: tgl_delivery,
                    pic: sopir,
                    pic2: kenek
                },
                success: function(data) {
                    console.log(data);
                    $('#ViewModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#DataModal').html(data);
                    $('#ViewModal').modal('show');
                    
                    //fortable
                    $('#tbView').DataTable({
                        "paging":   false
                    });
                }
            });
        });
        $(".tutup").click(function() {
            location.reload();
        });
       } else {
         //Tagihan setoran untuk view
            var table = $('#example').DataTable({
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": "../serverside/tagihan.php",
            columnDefs: [{
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-primary btn-xs viewdata'><span class='fa fa-eye'></span> </button>"
            }],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    title: 'Data Setoran'
                },
                {
                    extend: 'excel',
                    title: 'Data Setoran'
                },
                {
                    extend: 'pdf',
                    title: 'Data Setoran'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    title: 'Data Setoran'
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
        $('#example').on('click', '.viewdata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[1];
            var data3 = btoa(data3);
            var tgl_delivery = data[0];
            var sopir = data[3];
            var kenek = data[4];
            $.ajax({
                url: "modal/viewtagihan.php",
                method: "POST",
                data: {
                    tgl_delivery: tgl_delivery,
                    pic: sopir,
                    pic2: kenek
                },
                success: function(data) {
                    console.log(data);
                    $('#ViewModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#DataModal').html(data);
                    $('#ViewModal').modal('show');
                    
                    //fortable
                    $('#tbView').DataTable({
                        "paging":   false
                    });
                }
            });
        });
        $(".tutup").click(function() {
            location.reload();
        });
        }
    });
    </script>
    <div id="ModalSetoran" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Input setoran</h4>
                </div>
                <div class="modal-body modal-default" id="FomSetoran">

                </div>
                <div class="modal-footer">
                    <button id="simpan" class="btn btn-info simpan"><span class="fa fa-save"></span>
                        Simpan</button>
                    <button type="button" id="close" data-dismiss="modal" class="btn btn-warning keluar">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ViewModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail BL & History Setoran</h4>
                </div>
                <div class="modal-body" id="DataModal">

                </div>
                <div class="modal-footer">
                    <button type="button" id="close" data-dismiss="modal"
                        class="btn btn-warning btn-sm tutup">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>