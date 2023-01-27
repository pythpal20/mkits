<?php
    include '../../config/connection.php';
    // var_dump($_POST); die();
    if(isset($_POST['qtyback'])) {
        $idpts = $_POST['idpts'];
        $item = $_POST['item'];
        $sku = $_POST['sku'];
        $qtyact = $_POST['qtyact'];
        $qtyback = $_POST['qtyback'];
        $tglback = $_POST['tglback'];
        $keterangan = $_POST['keterangan'];

        $query = "UPDATE pts_detail_aktual SET qty_kembali = '$qtyback', tgl_kembali = '$tglback', ket = '$keterangan' WHERE idPts = '$idpts' AND id = '$item'";
        $mwk = $db1 -> prepare($query);
        $mwk -> execute();
        $resl = $mwk->get_result();
    }
    
?>