<?php
    include '../config/connection.php';
    $co = $_GET['co'];
    session_start(); 
    $akses = $_SESSION['moduls'];

    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 

    $sql="
        SELECT 
        d.tgl_inv,
        d.no_fa as nofa_awal,
        a.noso,
        a.No_Co as noco,
        c.customer_nama,
        c.pic_nama,
        c.customer_telp,
        c.pic_kontak,
        d.sales, 
        f.term,
        g.tgl_kontrabon,
        g.tgl_duedate,
        (select sum(e.harga_total) from customerorder_dtl e where e.No_co = a.No_Co)  AS nominal_awal,
        (select sum(b.harga_total) from customerorder_dtl_delivery b where b.No_co = a.No_Co)  AS nominal_akhir,
        a.tgl_delivery,    
        a.no_fa as nofa_akhir
        FROM customerorder_hdr_delivery a
        JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
        JOIN customerorder_dtl e ON a.No_Co = e.No_Co
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN customerorder_hdr d ON a.No_Co = d.No_Co
        left JOIN kontrabon g ON g.noco = a.No_Co
        JOIN salesorder_hdr f ON f.noso = a.noso
        WHERE a.No_Co = '".$co."'
        GROUP BY b.No_Co
    ";

    $item = mysqli_query($connect, $sql);
    $item = $item->fetch_array();
?>
<!-- ambil data -->

<!DOCTYPE html>
<html lang="en">

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
                    <h2>Penagihan</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#"> Penagihan</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Header Penagihan</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row ">
                    <div class="ibox col-lg-12">
                        <div class="ibox-title">
                            <h5> Detail Penagihan</h5>
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
                            <table class="table table-striped">
                                <tr>
                                    <td>Tgl FA</td>
                                    <td>:</td>
                                    <td><?=$item['tgl_inv']?></td>
                                    <td></td>
                                    <td></td>
                                    <td>No SO</td>
                                    <td>:</td>
                                    <td><?=$item['noso']?></td>
                                </tr>
                                <!-- form -->
                                <form action="modal_agil/insert_penagihan.php" id="penanggalan" method="post">
                                    <input type="hidden" name="noco_insert" value="<?=$co;?>">
                                    <input type="hidden" name="jenis" value="insert">
                                    <tr>
                                        <td>No FA</td>
                                        <td>:</td>
                                        <td><?=$item['nofa_awal']?></td>
                                        <td></td>
                                        <td></td>
                                        <td>Tgl Due Date</td>
                                        <td>:</td>
                                        <td><input type="date" name="tgl_due" class="form-control" id="tgl_due"
                                                value="<?php echo $tgl_kontrabon = ($item['tgl_duedate'] != null) ? $item['tgl_duedate'] : '' ;?>"
                                                required>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Customer</td>
                                        <td>:</td>
                                        <td><?=$item['customer_nama']?></td>
                                        <td></td>
                                        <td></td>
                                        <td>Tgl Kontra Bon</td>
                                        <td>:</td>
                                        <td>
                                            <input type="date" name="tgl_kontrabon" class="form-control"
                                                id="tgl_kontrabon"
                                                value="<?php echo $tgl_kontrabon = ($item['tgl_kontrabon'] != null) ? $item['tgl_kontrabon'] : '' ;?>"
                                                required>
                                        </td>
                                    </tr>
                                </form>
                                <!-- akhir form -->
                                <tr>
                                    <td>PIC</td>
                                    <td>:</td>
                                    <td><?=$item['pic_nama']?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>No Telp</td>
                                    <td>:</td>
                                    <td><?=$item['customer_telp']?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>:</td>
                                    <td><?=$item['pic_kontak']?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Nominal Fa awal</td>
                                    <td>:</td>
                                    <td><?=$item['nominal_awal']?></td>
                                    <td></td>
                                    <td></td>
                                    <td>Jenis Pembayaran</td>
                                    <td>:</td>
                                    <td><?=$item['term']?></td>
                                </tr>
                                <tr>
                                    <td>Nominal Fa Konsumen</td>
                                    <td>:</td>
                                    <td><?=$item['nominal_akhir']?></td>
                                    <td></td>
                                    <td></td>
                                    <td> Sales</td>
                                    <td>:</td>
                                    <td><?=$item['sales']?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="ibox-footer ">
                            <div class="row">
                                <div class="col-lg-6 text-left">
                                    <form action="detail_penagihan.php" method="get" id="lihat_detail">
                                        <input type="hidden" name="noco_detail" value="<?=$co?>">
                                        <button type="submit" class="btn  btn-secondary "> Detail </button>
                                    </form>
                                </div>
                                <div class="col-lg-6 text-right">
                                    <button class="btn  btn-default t" onclick="history.back()">Kembali</button>
                                    <button class="btn  btn-primary kirim ">Kirim</button>
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
</body>

</html>

<script>
$(document).ready(function() {
    $('.kirim').click(function() {
        $("#penanggalan").submit();
    });


});
</script>