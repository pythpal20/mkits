<?php
    include '../config/connection.php';
    
    session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu']) || $akses !== '3'){
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
</head>

<body>
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <div class="row border-bottom white-bg page-heading">
                <!-- || -->
                <div class="col-lg-10">
                    <h2>Data Request Pick Ticket Sample</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Request Sample</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- |Konten| -->
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12 m-b-xs">
                        <?php if($data['level'] == 'sales') { ?>
                        <a href="datasampleadd.php" class="btn btn-xs btn-info"><span class="fa fa-plus"></span> |
                            Request Sample</a>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Pick Ticket Sample</h5>
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
                                <table class="table table-striped" width="100%" id="TableRpt">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No. PTS</th>
                                            <th>Tgl. Request</th>
                                            <th>Tgl. Ambil</th>
                                            <th>Customer</th>
                                            <th>Sales</th>
                                            <th>Map</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'template/footer.php'; ?>
        </div>
    </div>
    <input type="hidden" name="level" id="level" value="<?php echo $data['level']; ?>">

    <?php include 'template/load_js.php'; ?>
    <script>
    $(document).ready(function() {
        document.getElementById('samplerequest').setAttribute('class', 'active');
    });
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: 'modal/getQtysco_in.php',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var reslt = data;
                    $('#sqty').html(reslt.dataun);
                    $('#sqlqty').html(reslt.dataun);
                }
            });
        }, 1000);
    });
    </script>
    <script>
    $(document).ready(function() {
        var lvl = $('#level').val();
        // if (lvl === "admin" || lvl === "superadmin") { //data serverside all table
        if (lvl === "superadmin") {
            var table = $('#TableRpt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/DataRptAdmin.php?kategori; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span> View</button></div></center>"
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === '0') {
                            return '<button class="btn btn-primary btn-xs setuju" rel="tooltip" title="Dengan tombol ini maka anda telah setuju dan menandatangani dokumen"><span class="fa fa-check"></span> | Approve</button>'
                        } else if (data === '1') {
                            return '<b>Approved</b>'
                        } else if (data === '2') {
                            return '<b>Pending</b> <button class="btn btn-primary btn-xs setuju"><span class="fa fa-check"></span></button>'
                        } else {
                            return 'INVALID'
                        }
                    }
                }]
            });
        } else {
            var table = $('#TableRpt').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "../serverside/DataRptAdmin.php?kategori; ?>",
                "responsive": true,
                "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<center><div class='btn-group'><button class='btn btn-xs btn-info seedata'><span class='fa fa-eye'></span> View</button></div></center>"
                }, {
                    "targets": 6,
                    "render": function(data, row) {
                        if (data === '0') {
                            return '<button class="btn btn-primary btn-xs setuju" rel="tooltip" title="Dengan tombol ini maka anda telah setuju dan menandatangani dokumen" disabled><span class="fa fa-check"></span> | Approve</button>'
                        } else if (data === '1') {
                            return '<b>Approved</b>'
                        } else if (data === '2') {
                            return '<b>Pending</b> <button class="btn btn-primary btn-xs setuju" disabled><span class="fa fa-check"></span></button>'
                        } else {
                            return 'INVALID'
                        }
                    }
                }]
            });
        }
        table.on('draw.dt', function() { //penomoran pada tabel
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied',
                sort: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
        $('#TableRpt tbody').on('click', '.seedata', function() {
            var data = table.row($(this).parents('tr')).data();
            var data3 = data[5];
            var data3 = btoa(data3);
            var id = data[0];
            $.ajax({
                url: "modal/pts_view.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#viewPts').html(data);
                    $('#PtsModal').modal('show');
                }
            });
        });
        $('#TableRpt tbody').on('click', '.setuju', function() {
            var data = table.row($(this).parents('tr')).data();
            var customer = data[4];
            var sales = data[5];
            var id = data[0];
            var tgl = data[3];
            var akun = "<?=$data['user_nama']?>";
            var modul = '3';
            $.ajax({
                url: "modal/akpts.php",
                method: "POST",
                data: {
                    id: id,
                    modul: modul,
                    akun: akun
                },
                success: function(data) {
                    swal.fire(
                        'Sudah diapprove dan dikonfirm',
                        'Sukses',
                        'success'
                    );

                    var url =
                        'https://api.telegram.org/bot5042604357:AAGe8tnjQG0Zb9c8dsSwivXuviNNXd9MvvE/sendMessage';
                    var chat_id = ["-759758736",
                        "-1001704848872"
                    ]; //notif ke group sales dan marketing
                    var text = "Request Sample dari :  <i>" + customer +
                        "</i>\n" +
                        "No. PTS : <i><b>" + id + "</b></i>\n" +
                        "Diajukan oleh : <i>" + sales + "</i>\n" +
                        "Tanggal diambil : <b>" + tgl + "</b>\n" +
                        "<b><i>Sudah Diproses Oleh : " + akun +
                        " Dari Tim ADMIN</i></b>";
                    for (let index = 0; index < chat_id.length; index++) {
                        const element = chat_id[index];
                        // console.log(element);
                        $.ajax({
                            url: url,
                            method: "get",
                            data: {
                                chat_id: element,
                                parse_mode: 'html',
                                text: text
                            }
                        });
                    }
                    setTimeout(function() {
                        location.assign("dataptsadm.php");
                    }, 2500);
                }
            });
        });
    });
    </script>
</body>
<div id="PtsModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail PTS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="viewPts">

            </div>
        </div>
    </div>
</div>

</html>