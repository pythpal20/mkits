<?php 
    include '../../config/connection.php';
    // var_dump($_POST);die();
    if(isset($_POST['item'])) {

        $item = $_POST['item'];
        $sku = $_POST['sku'];
        $qtys = $_POST['qty'];
        $hrg = $_POST['hrg'];
        $amts = $_POST['amounts'];
        $ket = $_POST['ket'];
        $idPts = $_POST['idPts'];
        $norut = $_POST['norut'];

        $query = "INSERT INTO pts_detail_aktual (id, idPts, model, qty_aktual, harga_aktual, amount_aktual, nourut, ket) 
        VALUES ('$item', '$idPts', '$sku', '$qtys', '$hrg', '$amts','$norut', '$ket')";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $resl = $mwk->get_result();
    }
?>