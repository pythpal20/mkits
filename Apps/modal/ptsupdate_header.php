<?php
    include '../../config/connection.php';
    //var_dump($_POST); die();

    $idPts      = $_POST['idPts'];
    $sales      = $_POST['sales'];
    $customer   = $_POST['customer'];
    $tglambil   = $_POST['tglambil'];
    $stsample   = $_POST['stsample'];
    $tglkembali = $_POST['tglkembali'];
    $ketbeli    = $_POST['ketbeli'];
    $kota       = $_POST['kota'];
    $alamat     = $_POST['alamat'];
    $keterangan = $_POST['keterangan'];

    $query = "UPDATE pts_header SET status = '$stsample', tgl_ambil = '$tglambil', tgl_kembali = '$tglkembali', keterangan = '$keterangan', keterangan_beli ='$ketbeli' WHERE idPts = '$idPts'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $hsl = $mwk->get_result();

    if(isset($_POST['ketbeli'])) {
        $kueri = "UPDATE pts_header SET complete = '1' WHERE idPts = '$idPts'";
        $pcs = $db1->prepare($kueri);
        $pcs->execute();
        $hasil = $pcs->get_result();
    }
?>