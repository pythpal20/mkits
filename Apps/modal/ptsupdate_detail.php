<?php
    include '../../config/connection.php'; 
    // var_dump($_POST); die();

    $idPts      = $_POST['idPts'];
    $iditem     = $_POST['iditem'];
    $sku        = $_POST['sku'];
    $qty        = $_POST['qty'];
    $harga      = $_POST['harga'];
    $amount     = $_POST['amount'];
    $ket        = $_POST['ket'];

    $query = "UPDATE pts_detail SET qty = '$qty', model = '$sku', harga = '$harga', amount = '$amount', ket = '$ket' WHERE id = '$iditem'";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $hsl = $mwk->get_result();
?>