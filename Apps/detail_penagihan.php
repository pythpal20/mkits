<?php
include '../config/connection.php';
$co = $_GET['noco_detail'];
session_start();
$akses = $_SESSION['moduls'];

$id = $_SESSION['idu'];
$query = "SELECT * FROM master_user WHERE user_id='$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl = $mwk->get_result();
$data = $resl->fetch_assoc();

//  cari data sesuai co di table detail penagihan
$history = "SELECT * FROM detail_penagihan WHERE noco = '$co' order by int_id desc";
$history = $db1->prepare($history);
$history->execute();
$resl2 = $history->get_result();
//   $data_history = $resl2->fetch_assoc(); 

function rupiah($angka)
{

    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>


<!DOCTYPE html>
<html lang="en">

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
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->
            <div class="row border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Penagihan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"> Penagihan</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Detail Penagihan</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row ">
                    <div class="ibox col-lg-12">
                        <div class="ibox-title">
                            <h5> Tambah Detail Penagihan</h5>
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
                            <form action="modal_agil/insert_detail_penagihan.php" method="post" id="form_detail_penagihan">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <input type="text" value="<?= $co; ?>" class="form-control" name="noco" readonly>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" placeholder="nominal" class="form-control" name="nominal" value="">
                                        </div>
                                        <div class="col-lg-3">
                                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
                                                <option value="Transfer" selected>Transfer</option>
                                                <option value="Cash">Cash</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="date" placeholder="tanggal pembayaran" class="form-control" name="tanggal_bayar">
                                            <input type="hidden" name="addby" id="addby" value="<?= $data['user_nama']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="keterangan" placeholder="keterangan" id="keterangan" cols="30" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ibox-footer ">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button class="btn  btn-default t" onclick="history.back()">Kembali</button>
                                    <button class="btn  btn-primary kirim ">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ibox col-lg-12">
                        <div class="ibox-title">
                            <h4>History Penagihan</h4>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Keterangan</th>
                                        <th>Nominal Pembayaran</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Tanggal Input</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($item = $resl2->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $item['keterangan'] ?></td>
                                            <td><?= rupiah($item['nominal']) ?></td>
                                            <td><?= $item['metode_pembayaran'] ?></td>
                                            <td><?= $item['tgl_pembayaran'] ?></td>
                                            <td><?= $item['tgl_input'] ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <?php include 'template/load_js.php'; ?>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#form_detail_penagihan').trigger("reset");
        $('.kirim').click(function() {
            $("#form_detail_penagihan").submit();
        });
    });
</script>