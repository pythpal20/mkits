<?php
    error_reporting(0);
    include '../../config/connection.php';
    // var_dump($_POST);
    $idfu        = $_POST['idfu'];
    $customer    = $_POST['customer'];
    $jenis       = $_POST['jenis'];
    $tglkunjungan= date_format(date_create($_POST['tglkunjungan']), 'Y-m-d');
    $salest      = $_POST['salest'];
    $ket         = $_POST['ket'];
    $deskripsi   = $_POST['deskripsi'];
    $penginput   = $_POST['penginput'];

    $sql = "UPDATE master_kunjungan SET followup_by = '$jenis', tgl_followup = '$tglkunjungan', customer_id='$customer', sales = '$salest', ket = '$ket', deskripsi_followup='$deskripsi', inputby='$penginput' WHERE id_followup = '$idfu'";
    $mwk = $db1->prepare($sql);
    $mwk -> execute();
    $resl= $mwk->get_result();
    if ($resl->num_rows > 0){
        echo 'gagal';
    } else {
        echo 'berhasil';
    }
?>