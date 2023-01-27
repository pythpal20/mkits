<?php

date_default_timezone_set('Asia/Jakarta');
if (isset($_POST['addby'])) {
    include '../../config/connection.php';
    $addby = $_POST['addby'];
    $namapromo = $_POST['namapromo'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis_promo'];
    $tglbuat = date('Y-m-d');
    $cekTgl = date('ymd');

    // var_dump($_POST['jenis_promo']);
    $query = "SELECT MAX(kode) AS idArr FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(promo_id, 16, 9) AS urutan FROM bundle_promo) AS tabel_a) AS table_b";
    $mwk = $db1->prepare($query);
    $mwk->execute();
    $res1 = $mwk->get_result();
    while ($sb = $res1->fetch_assoc()) {
        $urutan  = $sb['idArr'];
        $urutan = $urutan + 1;
        $huruf = "PRM/DSO";
        $idPo = $huruf . "/" . $cekTgl . "-" . sprintf("%04s", $urutan);
    }
    $ID_PROMO = $idPo;
    // var_dump($ID_PROMO); die();

    $kueri = "INSERT INTO bundle_promo (promo_id, promo_name, promo_description, promo_date, promo_addby, promo_jenis) VALUES ('$ID_PROMO', '$namapromo', '$deskripsi', '$tglbuat', '$addby', '$jenis')";
    $pcs = $db1->prepare($kueri);
    $pcs->execute();
    $res2 = $pcs->get_result();

    echo $ID_PROMO;
}