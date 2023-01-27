<?php
    // var_dump($_POST);die();
    date_default_timezone_set('Asia/Jakarta');
    include '../config/connection.php';
     

    $tglkirim = $_POST['tglkirim'];
    $uang = $_POST['uang'];
    $sopir = $_POST['sopir'];
    $kenek = $_POST['kenek'];
    $tglinput = date_format(date_create($_POST['tglinput']), 'Y-m-d H:i:s'); //musti di date_format (Y-m-d)
    
    $query = "INSERT INTO tb_setoran (INT_ID, tgl_delivery, tgl_input, nominal_diterima, sopir, kenek)
    VALUES ('$lvl', '$tglkirim', '$tglinput', '$uang', '$sopir', '$kenek')";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
?>