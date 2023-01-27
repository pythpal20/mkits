<?php
    include '../../config/connection.php';

    date_default_timezone_set('Asia/Jakarta');
    $waktu = date('Y-m-d H:i:s');
    $akun = $_POST['akun'];
    if ($_POST['modul'] == '2') {
        $id = $_POST['id'];
        $query = "UPDATE pts_header SET app_akunting = '1', tgl_akuntingapp = '$waktu' ,akunting = '$akun' WHERE idPts = '$id'";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $hsl = $mwk->get_result();
    } elseif ($_POST['modul'] == '3') {
        $id = $_POST['id'];
        $query = "UPDATE pts_header SET app_admin = '1', tgl_adminapp = '$waktu' , `admin` = '$akun' WHERE idPts = '$id'";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $hsl = $mwk->get_result();
    }
?>