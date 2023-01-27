<?php
    // var_dump($_POST);die();
    include '../../config/connection.php';
    
    $kueri = "UPDATE pts_header SET complete = '1' WHERE idPts = '" . $_POST['id'] . "'";
    $pcs = $db1->prepare($kueri);
    $pcs -> execute();
    $reslt = $pcs->get_result();
?>