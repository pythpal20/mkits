<?php
    include '../../config/connection.php';
     $idpt       = $_POST['idpt'];
     $alamat     = $_POST['alamat'];
     $nsco       = $_POST['nsco'];
     $idcustomer = $_POST['idcustomer'];
     $sales      = $_POST['sales'];

        $query = "INSERT INTO customerorder_hdr_pending (noso, id_perusahaan, customer_id, sales, alamat_krm) VALUES ('$nsco', '$idpt', '$idcustomer' , '$sales', '$alamat')";
        $mwk=$db1->prepare($query);
        $mwk->execute();
        $resl = $mwk->get_result();
?>