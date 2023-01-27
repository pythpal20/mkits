<?php
    // var_dump($_POST);die();
    include '../../config/connection.php' ;
    date_default_timezone_set('Asia/Jakarta');
    $customer       = $_POST['customer'];
    $sales          = $_POST['sales'];
    $tglambil       = $_POST['tglambil'];
    $stsample       = $_POST['stsample'];
    $tglkembali     = $_POST['tglkembali'];
    $ketbeli        = $_POST['ketbeli'];
    $keterangan     = $_POST['keterangan'];
    $tglinput       = date('Y-m-d H:i:s');
    $alamat         = $_POST['alamat'];
    $kota           = $_POST['kota'];

    $code ="SELECT MAX(kode) AS idArr
    FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(idPts, 7) AS urutan FROM pts_header) AS tabel_a) AS table_b";
    $mwk = $db1->prepare($code);
    $mwk->execute();
    $res1 = $mwk->get_result();
    while ($sb = $res1->fetch_assoc()) {
        $urutan  = $sb['idArr'];
        $urutan = $urutan+1;
        $huruf = "PTS-A";
        $idPts = $huruf."/". sprintf("%04s", $urutan);
    }
    $idPick = $idPts;
    // var_dump($idPts);die();
    $query ="INSERT INTO pts_header (idPts, tgl_create, status, tgl_ambil, tgl_kembali, customer_nama, sales, keterangan, keterangan_beli, alamat, kota, complete) 
    VALUES ('$idPts', '$tglinput', '$stsample', '$tglambil', '$tglkembali', '$customer', '$sales', '$keterangan', '$ketbeli', '$alamat', '$kota', '0')";
    $mwk = $db1->prepare($query);
    $mwk->execute();
    $resl = $mwk->get_result();
    echo $idPts;
?>