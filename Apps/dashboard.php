<?php
  include '../config/connection.php';
  include '../config/data_graphic.php';
  session_start(); 
    $akses = $_SESSION['moduls'];
    if (!isset($_SESSION['usernameu'])){
        header("Location: ../index.php");
    } 
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc(); 
  
  if($_SESSION['moduls'] != 6) {
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="theme-color" content"#9d4edd">
    <?php include 'template/load_css.php';?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.css">
    <link href="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css" rel="stylesheet">
    <!-- load css library -->
</head>

<body>
    <input type="hidden" id="lvls" value="<?php echo $data['modul']; ?>">
    <div id="wrapper">
        <?php include 'template/header.php'; ?>
        <!-- side-navbar -->
        <div id="page-wrapper" class="gray-bg">
            <?php include 'template/header_bottom.php'; ?>
            <!-- header -->
            <!-- write the content below -->

            <div class="row  border-bottom white-bg dashboard-header">
                <div class="col-lg-12">
                    <?php if($data['level'] !== 'sales') : ?>
                    <h4>Grafik Penjualan perbulan Tahun ini</h4>
                    <?php
                        $dataset1 = array();
                        while ($fl=$flotLn->fetch_assoc()){
                            $dataset1[] = array( $fl['bulan'], $fl['totalPo'] );
                        }
                    ?>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-line-chart"></div>
                    </div>
                    <?php endif; ?>
                    <?php if($data['level'] == 'sales') : ?>
                    <h4>Grafik Penjualanmu perbulan Tahun ini</h4>
                    <?php
                        $dataset2 = array();
                        $lnFU = "SELECT MONTH(tgl_po) AS bulan, COUNT(noso) AS totalPo FROM salesorder_hdr
                        WHERE YEAR(tgl_po) = YEAR(CURRENT_DATE()) AND sales = '".$data['user_nama']."'
                        GROUP BY MONTH(tgl_po)";
                        $mwk = $db1->prepare($lnFU);
                        $mwk->execute();
                        $FuLn = $mwk->get_result();
                        while ($fu=$FuLn->fetch_assoc()) {
                            $dataset2[] = array( $fu['bulan'], $fu['totalPo'] );
                        } 
                    ?>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="chartPerHari"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                <h4>Selamat datang <?php echo $data['user_nama']; ?>,</h4>
                <?php if($data['modul']=='5' || $data['modul'] == '1'){ ?>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i>Planing Pengiriman Hari ini <small> (Belum
                                        dikirim)</small>
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $qdlv = "SELECT mw.wilayah_nama, COUNT(sh.No_Co) AS jumlahPo FROM customerorder_hdr sh
                                        LEFT JOIN master_customer mc ON sh.customer_id = mc.customer_id
                                        LEFT JOIN master_wilayah mw ON mc.customer_kota = mw.wilayah_id
                                        JOIN salesorder_hdr o ON sh.noso = o.noso
                                        WHERE sh.tgl_krm = CURRENT_DATE() AND (sh.`status_delivery` = '0' || sh.status_delivery = '2') AND (o.jenis_transaksi LIKE 'KUNJUNGAN' OR o.jenis_transaksi LIKE 'TELEPON')
                                        GROUP BY mw.wilayah_nama ORDER BY jumlahPo DESC";
                                        $mwk = $db1->prepare($qdlv);
                                        $mwk -> execute();
                                        $resl_dlv = $mwk->get_result();
                                    ?>
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>KOTA</th>
                                                <th>Jumlah BL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($data_dlv = $resl_dlv->fetch_assoc()){ ?>
                                            <tr>
                                                <td><?= $data_dlv['wilayah_nama'] ?></td>
                                                <td><?= $data_dlv['jumlahPo'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i> Pengiriman Hari ini <small> (Sudah
                                        dikirim)</small>
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $qdlv = "SELECT mw.wilayah_nama, COUNT(sh.No_Co) AS jumlahPo FROM customerorder_hdr_delivery sh
                                            LEFT JOIN master_customer mc ON sh.customer_id = mc.customer_id
                                            LEFT JOIN master_wilayah mw ON mc.customer_kota = mw.wilayah_id
                                            JOIN salesorder_hdr o ON sh.noso = o.noso
                                            WHERE DATE_FORMAT(sh.tgl_delivery, '%Y-%m-%d') = CURRENT_DATE() AND sh.`status_delivery` != '0' AND (o.jenis_transaksi LIKE 'KUNJUNGAN' OR o.jenis_transaksi LIKE 'TELEPON')
                                            GROUP BY mw.wilayah_nama ORDER BY jumlahPo DESC";
                                        $mwk = $db1->prepare($qdlv);
                                        $mwk -> execute();
                                        $resl_dlv = $mwk->get_result();
                                    ?>
                                    <table class="table table-borderless" id="tableTerkirim">
                                        <thead>
                                            <tr>
                                                <th>KOTA</th>
                                                <th>Jumlah BL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($data_dlv = $resl_dlv->fetch_assoc()){ ?>
                                            <tr>
                                                <td><?= $data_dlv['wilayah_nama'] ?></td>
                                                <td><?= $data_dlv['jumlahPo'] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-12">
                    <div class="row">
                        <?php if($data['modul'] == '2') : ?>
                        <div class="col-md-3">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i> SCO Unprocess
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $un = "SELECT COUNT(noso) as tot FROM salesorder_hdr WHERE status = '1' AND aproval_finance = '0'";
                                        $mwk = $db1->prepare($un);
                                        $mwk -> execute();
                                        $hun = $mwk->get_result();
                                        $dun = $hun->fetch_assoc();
                                    ?>
                                    <h3 class="panel-title">
                                        <?php echo $dun['tot']; ?>
                                        <small>PO sheet</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i> SCO Pending
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $un = "SELECT COUNT(noso) as tot FROM salesorder_hdr WHERE status = '1' AND aproval_finance = '2'";
                                        $mwk = $db1->prepare($un);
                                        $mwk -> execute();
                                        $hun = $mwk->get_result();
                                        $dun = $hun->fetch_assoc();
                                    ?>
                                    <h3 class="panel-title">
                                        <?php echo $dun['tot']; ?>
                                        <small>PO sheet</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i> SCO Cancel
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $un = "SELECT COUNT(noso) as tot FROM salesorder_hdr WHERE status = '1' AND aproval_finance = '3'";
                                        $mwk = $db1->prepare($un);
                                        $mwk -> execute();
                                        $hun = $mwk->get_result();
                                        $dun = $hun->fetch_assoc();
                                    ?>
                                    <h3 class="panel-title">
                                        <?php echo $dun['tot']; ?>
                                        <small>PO sheet</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <i class="fa fa-info-circle"></i> SCO Process
                                </div>
                                <div class="panel-body">
                                    <?php 
                                        $un = "SELECT COUNT(noso) as tot FROM salesorder_hdr WHERE status = '1' AND aproval_finance = '1'";
                                        $mwk = $db1->prepare($un);
                                        $mwk -> execute();
                                        $hun = $mwk->get_result();
                                        $dun = $hun->fetch_assoc();
                                    ?>
                                    <h3 class="panel-title">
                                        <?php echo $dun['tot']; ?>
                                        <small>PO sheet</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php if($data['level'] !== 'sales') : ?>
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>10 Kota dengan Invoice terkirim</h5>
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
                                        <?php
                                            $arset1=array();
                                            $arset2=array();
                                            while ($hc=$hcity->fetch_assoc()){
                                                $arset1[]=array($hc['wilayah_nama']);
                                                $arset2[]=array($hc['jumlahPo']);
                                            }
                                        ?>
                                        <div>
                                            <canvas id="doughnutChart" height="145"></canvas>
                                        </div>
                                    </div>
                                    <div class="ibox-footer">
                                        <em style="font-size: 0.756em">*grafik dalam 1 tahun | dihitung dari CO/ Inv terkonfirmasi Kirim</em>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Informasi Penjualan bulan ini</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                        $ttl_po = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) AND sales ='".$data['user_nama']."'";
                                        $mwk = $db1->prepare($ttl_po);
                                        $mwk->execute();
                                        $reslt = $mwk->get_result();
                                        $tpo = $reslt->fetch_assoc();

                                        $ttl_po2 = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE `status` != '2' AND jenis_transaksi != 'MARKETPLACE' AND jenis_transaksi != 'SHOWROOM' AND MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po)= YEAR(CURRENT_DATE())";
                                        $mwk = $db1->prepare($ttl_po2);
                                        $mwk->execute();
                                        $reslt2 = $mwk->get_result();
                                        $tpo2 = $reslt2->fetch_assoc();
                                        
                                        $ttl_po3 = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) AND jenis_transaksi = 'MARKETPLACE'";
                                        $mwk = $db1->prepare($ttl_po3);
                                        $mwk->execute();
                                        $reslt3 = $mwk->get_result();
                                        $tpo3 = $reslt3->fetch_assoc();
                                        
                                        $ttl_po4 = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) AND jenis_transaksi = 'SHOWROOM'";
                                        $mwk = $db1->prepare($ttl_po4);
                                        $mwk->execute();
                                        $reslt4 = $mwk->get_result();
                                        $tpo4 = $reslt4->fetch_assoc();

                                        $ttl_amt = "SELECT SUM(sd.harga_total) AS total_hrg, sh.sales FROM salesorder_dtl sd 
                                        JOIN salesorder_hdr sh ON sd.noso = sh.noso
                                        WHERE MONTH(sd.tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(sd.tgl_po) = YEAR(CURRENT_DATE()) AND sh.sales ='".$data['user_nama']."'";
                                        $mwk = $db1->prepare($ttl_amt);
                                        $mwk->execute();
                                        $resl = $mwk->get_result();
                                        $tpa = $resl->fetch_assoc();

                                        $ttl_amt2 = "SELECT SUM(sd.harga_total) AS total_hrg 
                                        FROM salesorder_dtl sd JOIN salesorder_hdr sh ON sd.noso = sh.noso 
                                        WHERE sh.status != '2' AND MONTH(sd.tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(sd.tgl_po) = YEAR(CURRENT_DATE()) AND sh.jenis_transaksi != 'MARKETPLACE' AND sh.jenis_transaksi != 'SHOWROOM' AND sh.jenis_transaksi != 'INTERNAL'";
                                        $mwk = $db1->prepare($ttl_amt2);
                                        $mwk->execute();
                                        $resl2 = $mwk->get_result();
                                        $tpa2 = $resl2->fetch_assoc();

                                        // $produk = "SELECT model, COUNT(model) AS modus, SUM(qty) AS total FROM salesorder_dtl 
                                        // WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE())
                                        // GROUP BY model ORDER BY total DESC LIMIT 15";
                                        // EDIT ALIF
                                        $produk = "SELECT a.model, COUNT(a.model) AS modus, SUM(a.qty_kirim) AS total FROM customerorder_dtl_delivery a 
                                        JOIN customerorder_hdr_delivery b ON a.No_Co = b.No_Co
                                        WHERE MONTH(a.tgl_delivery) = MONTH(CURRENT_DATE()) AND YEAR(a.tgl_delivery) = YEAR(CURRENT_DATE())
                                        GROUP BY a.model ORDER BY total DESC LIMIT 15";
                                        $mwk = $db1->prepare($produk);
                                        $mwk->execute();
                                        $hasil_prod = $mwk->get_result();

                                        $hitung_customer = "SELECT COUNT(noso) AS totalNew FROM salesorder_hdr sh
                                        JOIN master_customer mc ON sh.customer_id = mc.customer_id
                                        WHERE mc.status = 'new' AND MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE());";
                                        $mwk = $db1->prepare($hitung_customer);
                                        $mwk->execute();
                                        $hasil_hitung = $mwk->get_result();
                                        $hh = $hasil_hitung->fetch_assoc();
                                    ?>
                                    <?php if($data['level'] == 'sales') : ?>
                                    <div class="ibox-content">
                                        <ul class="list-group clear-list m-t">
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo $tpo['total']; ?> PO
                                                </span>
                                                <span class="label label-success">1</span> Jumlah Penjualan anda bulan
                                                ini
                                            </li>
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo 'Rp. ' . number_format($tpa['total_hrg'],0,'.','.'); ?>
                                                </span>
                                                <span class="label label-primary">2</span> Total amount bulan ini
                                            </li>
                                        </ul>
                                    </div>
                                    <?php endif ?>
                                    <?php if($data['level'] !== 'sales') : ?>
                                    <div class="ibox-content">
                                        <ul class="list-group clear-list m-t">
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo $tpo2['total']; ?> LEMBAR SCO
                                                </span>
                                                <span class="label label-default">1</span> Jumlah Penjualan bulan ini (SM)
                                            </li>
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo $tpo3['total']; ?> LEMBAR SCO
                                                </span>
                                                <span class="label label-success">2</span>Penjualan Marketplace
                                                bulan ini
                                            </li>
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo $tpo4['total']; ?> LEMBAR SCO
                                                </span>
                                                <span class="label label-warning">3</span>Penjualan Showroom
                                                bulan ini
                                            </li>
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo 'Rp. ' . number_format($tpa2['total_hrg'],0,'.','.'); ?>
                                                </span>
                                                <span class="label label-info">4</span> Total amount(SM) bulan ini
                                            </li>
                                            <li class="list-group-item fist-item">
                                                <span class="float-right">
                                                    <?php echo $hh['totalNew']; ?>
                                                </span>
                                                <span class="label label-primary">5</span> Total PO New Customer
                                            </li>
                                        </ul>
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php if($data['level'] !== 'sales') : ?>
                            <?php
                                    $kategori = [];
                                    $jumlahC = [];
                                    while ($arow = $rkategory->fetch_assoc()) {
                                        array_push($kategori, $arow['customer_kategori']);
                                        array_push($jumlahC, $arow['Jumlah']);
                                    }
                                    $namaKategori = "'" . implode("','", $kategori) . "'";
                                    $jumlahKategori = implode(",", $jumlahC);
                                    // var_dump($jumlahKategori);
                                    ?>
                            <div class="col-lg-6">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Grafik Qty Pendatapatan Kategori Customer</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <canvas id="kotakChart"></canvas>
                                    </div>
                                    <div class="ibox-footer">
                                        <small><em>*data diambil dari data CO terkirim dari Januari - Desember <?= date('Y') ?></em></small>
                                    </div>
                                </div>
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>List Jumlah PO by Sales</h5><small> (SCO CANCELED NOT INCLUDE)</small>
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
                                            <table class="table table-hover gtable" data-page-size="5">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th>SCO</th>
                                                        <th align="right" data-type="numeric" data-sort-initial="true">
                                                            Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = "SELECT * FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) GROUP BY sales";
                                                        $mwk = $db1->prepare($sql);
                                                        $mwk -> execute();
                                                        $hasil = $mwk->get_result();
                                                        $no = 1;
                                                        while ($hs = $hasil->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td>
                                                            <?php echo $hs['sales']; ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                $total_po = "SELECT COUNT(noso) AS ttl_po FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE()) AND sales='".$hs['sales']."' AND status != '2'";
                                                                $mwk = $db1->prepare($total_po);
                                                                $mwk -> execute();
                                                                $pottl = $mwk->get_result();
                                                                $ttlpo = $pottl->fetch_assoc();
                                                                echo $ttlpo['ttl_po'] . ' Lembar';
                                                            ?>
                                                        </td>
                                                        <td align="right">
                                                            <?php 
                                                                $sql3 = "SELECT SUM(harga_total) AS amount FROM salesorder_dtl sd 
                                                                JOIN salesorder_hdr sh ON sd.noso= sh.noso
                                                                WHERE MONTH(sd.tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(sd.tgl_po) = YEAR(CURRENT_DATE()) AND sh.sales = '".$hs['sales']."' AND sh.status !='2'";
                                                                $mwk = $db1->prepare($sql3);
                                                                $mwk -> execute();
                                                                $amnt = $mwk->get_result();
                                                                $mt = $amnt->fetch_assoc();
                                                                echo $mt['amount']; 
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <ul class="pagination float-right"></ul>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <button class="btn btn-sm btn-danger kasitunjuk"><span class="fa fa-eye"></span> | Lihat Statistik <?= date('Y') ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>15 Produk Terlaris Bulan ini</h5>
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
                                            <table class="table table-hover ftable" data-page-size="5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>SKU</th>
                                                        <th>Jumlah Orderan</th>
                                                        <th data-type="numeric" data-sort-initial="descending">Total Qty
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; while ($prod = $hasil_prod->fetch_assoc()) : ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $prod['model']; ?></td>
                                                        <td><?php echo $prod['modus']; ?></td>
                                                        <td><?php echo $prod['total']; ?></td>
                                                    </tr>
                                                    <?php endwhile ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <ul class="pagination float-right"></ul>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="pengguna" value="<?php echo $data['user_nama'];?>">
            <!-- end of content -->
            <?php include 'template/footer.php'; ?>
            <!-- Footer -->
        </div>
    </div>
    <div class="modal fade" id="statistic" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="max-width: 80%;">
            <div class="modal-content animated bounceInUp">
                <div class="modal-header">
                    <h4 class="modal-title">Nominal Penjualan Sales per Bulan dalam Tahun <?= date('Y') ?></h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link tab1 active" data-toggle="tab" href="#tab-1"><span class="fa fa-building-o"></span> By SCO</a></li>
                            <li><a class="nav-link tab2" data-toggle="tab" href="#tab-2" id="tab2"><span class="fa fa-building-o"></span> By CO</a></li>
                            <li><a href="#tab-3" data-toggle="tab" class="nav-link tab3" id="tab3"><span class="fa fa-building-o"></span> ALL</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div id="toolbar" class="select">
                                        <select class="form-control">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table class="table table-bordered" id="statisk" data-toggle="statisk" data-show-toggle="true" data-toolbar="#toolbar" data-show-columns="true" data-id-field="sales" data-show-footer="false" data-show-print="true" data-show-export="true" data-show-refresh="true"></table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div id="toolbar2" class="select">
                                        <select class="form-control">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table class="table table-bordered" id="statistikco" data-toggle="statistikco" data-show-toggle="true" data-toolbar="#toolbar2" data-show-columns="true" data-id-field="Sales" data-show-footer="false" data-show-print="true" data-show-export="true" data-show-refresh="true"></table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <table style="width:100%;" id="table" data-toggle="table" data-url="../serverside/joinStatistik.php" data-show-toggle="true" data-search="true" data-show-columns="true" data-id-field="Sales" data-show-footer="false" data-show-print="true" data-show-export="true" width="100%" data-fixed-columns="true" data-fixed-number="1" data-show-print="true" data-show-export="true" data-pagination="true" data-show-refresh="true">
                                            <thead>
                                                <tr>
                                                    <th data-field="sales" rowspan="2" data-valign="middle" data-width="1000">Nama User</th>
                                                    <th colspan="2">Januari</th>
                                                    <th colspan="2">Februari</th>
                                                    <th colspan="2">Maret</th>
                                                    <th colspan="2">April</th>
                                                    <th colspan="2">Mei</th>
                                                    <th colspan="2">Juni</th>
                                                    <th colspan="2">Juli</th>
                                                    <th colspan="2">Agustus</th>
                                                    <th colspan="2">September</th>
                                                    <th colspan="2">Oktober</th>
                                                    <th colspan="2">November</th>
                                                    <th colspan="2">Desember</th>
                                                </tr>
                                                <tr>
                                                    <th data-field="Jan" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Jan1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Feb" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Feb1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Mar" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Mar1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Apr" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Apr1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Mei" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Mei1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Jun" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Jun1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Jul" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Jul1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Ags" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Ags1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Sep" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Sep1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Okt" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Okt1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Nov" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Nov1" data-formatter="Rupiahx" data-sortable="true">CO</th>
                                                    <th data-field="Des" data-formatter="Rupiahx" data-sortable="true">SCO</th>
                                                    <th data-field="Des" data-formatter="Rupiahx" data-sortable="true">CO</th>
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
    </div>
    <?php include 'template/load_js.php'; ?>
    <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="DataScript/statistik.js"></script>
    <!-- load js library -->
    <script>
    function Rupiahx(value, row) {
                var sign = 1;
                if (value < 0) {
                    sign = -1;
                    value = -value;
                }

                let num = value.toString().includes('.') ? value.toString().split('.')[0] : value.toString();
                let len = num.toString().length;
                let result = '';
                let count = 1;

                for (let i = len - 1; i >= 0; i--) {
                    result = num.toString()[i] + result;
                    if (count % 3 === 0 && count !== 0 && i !== 0) {
                        result = '.' + result;
                    }
                    count++;
                }

                if (value.toString().includes(',')) {
                    result = result + ',' + value.toString().split('.')[1];
                }
                // return result with - sign if negative
                return sign < 0 ? '-' + result : (result ? 'Rp. ' + result : '');
            }
    $(document).ready(function() {
        document.getElementById('dashboard').setAttribute('class', 'active');
        var pengguna = $('#pengguna').val();
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 5000
            };
            toastr.success('MKITS', 'Welcome ' + pengguna);

        }, 1300);
    });
    $(document).ready(function() {
        var lev = $('#lvls').val();
        if (lev == 3) {
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
        } else if (lev == 2) {
            setInterval(function() {
                $.ajax({
                    url: 'modal/getLabel.php',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        var reslt = data;
                        $('#aklabel').html(reslt.dataun);
                    }
                });
            }, 1000);
        }

    });
    </script>

    <script>
    $(document).ready(function() {
        var table = $('.gtable').DataTable({
            pageLength:5,
            columnDefs: [{
                "targets": 3,
                "render": $.fn.dataTable.render.number( '.', '', '', 'Rp. ' )
            }, {
                "type": "num", 
                "targets": 3 
            }]
        });
        table
        .order( [ 3, 'desc' ] )
        .draw();
    });
    
    $(document).ready(function(){
        $('.ftable').footable();
    });
    </script>

    <?php if($data['level'] !=='sales'): ?>
    <script>
                $(function() {
                    var barData = {
                        labels: [<?= $namaKategori ?>],
                        datasets: [{
                            label: "Amount (Rp.) / Tahun",
                            backgroundColor: [
                                'rgba(60, 179, 113)',
                                'rgba(0, 255, 255)',
                                'rgba(65, 105, 225)',
                                'rgba(218, 165, 32)',
                                'rgba(47, 79, 79)',
                                'rgba(173, 255, 47)',
                                'rgba(127, 255, 212)',
                                'rgba(255, 0, 255)',
                                'rgba(255, 87, 51)',
                                'rgba(189, 183, 107)'
                            ],
                            pointBorderColor: "#fff",
                            data: [<?= $jumlahKategori ?>]
                        }]
                    }

                    var barOptions = {
                        responsive: true
                    };


                    var ctx2 = document.getElementById("kotakChart").getContext("2d");
                    new Chart(ctx2, {
                        type: 'bar',
                        data: barData,
                        options: barOptions
                    });
                });
            </script>
    <script>
    $(function() {
        var barOptions = {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.0
                        }, {
                            opacity: 0.0
                        }]
                    }
                }
            },
            xaxis: {
                tickDecimals: 0
            },
            colors: [" #1ab394"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth: 0
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: "Bulan: %x, Total PO: %y"
            }
        };
        var barData = <?php echo json_encode($dataset1); ?>;
        $.plot($("#flot-line-chart"), [barData], barOptions);
    }); //chart js pie var
    dt = <?php echo json_encode($arset1); ?>;
    var lb = <?php echo json_encode($arset2); ?>;
    var doughnutData = {
        labels: dt,
        datasets: [{
            data: lb,
            backgroundColor: ["#EB984E", "#663399", "#8FBC8B", "#4682B4", "#F7DC6F", "#FF4500", "#2F4F4F", "#FFE4E1", "#ADD8E6", "#DB7093"]
        }]
    };
    var doughnutOptions = {
        responsive: true,
        legend: {
            display: true,
            position: "left",
            labels: {
                fontSize: 10,
                boxWidth: 20,
            }
        }
    };
    var
        ctx4 = document.getElementById("doughnutChart").getContext("2d");
    new Chart(ctx4, {
        type: 'pie',
        data: doughnutData,
        options: doughnutOptions
    });
    </script>
    <?php endif ?>

    <?php if($data['level']=='sales'):?>
    <script>
    $(function() {
        var barOptions2 = {
            series: {
                lines: {
                    show: true,
                    lineWidth: 2,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.0
                        }, {
                            opacity: 0.0
                        }]
                    }
                }
            },
            xaxis: {
                tickDecimals: 0
            },
            colors: ["#1ab394"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth: 0
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: "Bulan: %x, Total PO: %y"
            }
        };
        var barDatas = <?php echo json_encode($dataset2); ?>;
        $.plot($("#chartPerHari"), [barDatas], barOptions2);
    });
    
    $(document).ready(function() {
        $('#tableTerkirim').footable();
    });
    </script>
    <?php endif ?>
</body>

</html>
<?php } else {
    header('Location: logout.php');
}
?>