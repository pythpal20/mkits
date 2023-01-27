<?php
include '../config/connection.php';
date_default_timezone_set('Asia/Jakarta');
session_start();
$akses = $_SESSION['moduls'];
if (!isset($_SESSION['usernameu']) && $akses == '6') {
    header("Location: ../index.php");
}
$id = $_SESSION['idu'];
$query = "SELECT * FROM master_user WHERE user_id='$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
$data = $resl->fetch_assoc();

if(isset($_SESSION['idu'])) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'template/load_css.php'; ?>
</head>

<body id="page-top" class="landing-page no-skin-config">
    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="landing.php" style="background-color: red;">MR. KITCHEN | SETORAN</a>
                <div class="navbar-header page-scroll">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>
    </div>


    <section id="#" class="container services">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h3>DATA SETORAN HARIAN <small>Berdasarkan CO yang sudah terkirim</small></h3>
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
                        <table class="table table-hover display" id="tbs">
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
    </section>

    <!-- Modal -->
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
                        class="btn btn-warning btn-sm keluar">Close</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="muser" value="<?= $data['modul'] ?>">
    <?php require 'template/load_js.php'; ?>
    <script src="../assets/js/plugins/wow/wow.min.js"></script>
    <script>
    $(document).ready(function() {
        var nm_user = $("#muser").val();
        if (nm_user == '6') {
            var table = $('#tbs').DataTable({
                "processing": true,
                "responsive": true,
                "serverSide": true,
                "ajax": "../serverside/tagihan.php",
                columnDefs: [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary btn-sm viewdata'><span class='fa fa-eye'></span></button>"
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
            $('#tbs').on('click', '.viewdata', function() {
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
                    }
                });
            });
            setInterval(function() {
                table.ajax.reload();
            }, 2000);
        } else {

        }

    });
    $(document).ready(function() {

        $('body').scrollspy({
            target: '#navbar',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
            $("#navbar").collapse('hide');
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
            header = document.querySelector('.navbar-default'),
            didScroll = false,
            changeHeaderOn = 200;

        function init() {
            window.addEventListener('scroll', function(event) {
                if (!didScroll) {
                    didScroll = true;
                    setTimeout(scrollPage, 250);
                }
            }, false);
        }

        function scrollPage() {
            var sy = scrollY();
            if (sy >= changeHeaderOn) {
                $(header).addClass('navbar-scroll')
            } else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();
    </script>

</body>

</html>
<?php } else {
    header('Location: logout.php');
} ?>