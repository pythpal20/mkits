<?php   
    // var_dump($_POST); die(); 
    include '../../config/connection.php'; 
    $sku    = $_POST['sku'];
    $qty    = $_POST['qty'];
    $ket    = $_POST['ket'];
    $idPts  = $_POST['idPts'];
    $no_urut= $_POST['no_urut'];

    if(isset($_POST['sku']) && isset($_POST['qty'])) {
        $query = "INSERT INTO pts_detail (id, idPts, model, qty, nourut, ket) VALUES ('', '$idPts', '$sku', '$qty', '$no_urut', '$ket')";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $resl = $mwk->get_result();
    }
?>