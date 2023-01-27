<?php
date_default_timezone_set('Asia/Jakarta');

include '../../config/connection.php';

if($_POST['nominal_diterima'] != '') {
    // var_dump($_POST);
    // die();
    
    $nobl = $_POST['no_bl'];
    $nomditerima = $_POST['nominal_diterima'];
    $keterangan = $_POST['keterangan'];
    $tgl = $_POST['tgl_delivery'];
    $users = $_POST['muser'];
    $now = date('Y-m-d H:i:s');    
    $kenek = $_POST['kenek'];
    $sopir = $_POST['sopir'];

    $query = "INSERT INTO tb_setoran (no_bl, nominal_diterima, tgl_input, inputby, keterangan, tgl_delivery, pic1, pic2)
    VALUES('$nobl', '$nomditerima', '$now', '$users', '$keterangan' , '$tgl', '$kenek', '$sopir')";
    $pcs = $db1->prepare($query);
    $pcs->execute();
    $resl = $pcs->get_result();
}