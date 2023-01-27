<?php
    // var_dump($_POST);die();
    include '../../config/connection.php';

    $customer       = $_POST['customer'];
    $jenis          = $_POST['jenis'];
    $tglkunjungan   = date_format(date_create($_POST['tglkunjungan']), 'Y-m-d');
    $sales          = $_POST['salest'];
    $ket            = $_POST['ket'];
    $deskripsi      = $_POST['deskripsi'];
    $inputby        = $_POST['penginput'];
    
    $query = "INSERT INTO master_kunjungan (followup_by, tgl_followup, sales, customer_id, ket, deskripsi_followup, inputby) 
    VALUES ('$jenis', '$tglkunjungan', '$sales', '$customer', '$ket' , '$deskripsi', '$inputby')";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
?>