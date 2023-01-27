<?php
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
    session_start();
    $id = $_SESSION['idu'];
    $query = "SELECT * FROM master_user WHERE user_id='$id'"; 
    $mwk = $db1->prepare($query); 
    $mwk->execute();
    $resl = $mwk->get_result();
    $data = $resl->fetch_assoc();
    $user_ngupdate = $data['user_nama'];
    // var_dump($_POST); die();
    $sales      = $_POST['sales'];
    $nsco       = $_POST['nsco'];
    $idcust     = $_POST['idcust'];
    $tglkrm     = $_POST['tglkrm'];
    $tglinv     = $_POST['tglinv'];
    $ongkir     = $_POST['ongkir'];
    $alamat     = $_POST['alamat'];
    $noso       = $_POST['noso'];
    $tglupdate  = date('Y-m-d H:i:s');
    $idFpp      = $_POST['idFpp'];
    $customer   = $_POST['customer'];
    $appby      = $_POST['appby'];

    $sql = "SELECT MAX(keterangan) as jlh FROM customerorder_hdr WHERE No_Co = '$nsco'";
    $mwk = $db1->prepare($sql);
    $mwk -> execute();
    $hasil = $mwk->get_result();
    while ($row = $hasil->fetch_assoc()) {
        $count_revisi  = $row['jlh'];
        $urutan = (int) substr($count_revisi, 7);
        // var_dump($urutan); die();
        $urutan = $urutan+1;
        $huruf = "REVISI";
        $count_revisi = $huruf . '-'. $urutan;
    }
    if ($hasil->num_rows >0){
        
        $query = "UPDATE customerorder_hdr SET tgl_krm = '$tglkrm', tgl_inv='$tglinv', ongkir='$ongkir', alamat_krm='$alamat',customer_nama = '$customer', keterangan='$count_revisi', tgl_update='$tglupdate',updateby ='$user_ngupdate', fpp_id='$idFpp', ttd_by = '$appby' WHERE No_Co = '$nsco'";
        $mwk   = $db1->prepare($query);
        $mwk->execute();
        $resl  = $mwk->get_result();
    }
    echo $count_revisi;
?>