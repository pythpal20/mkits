<?php
    // var_dump($_POST); die();
    include '../config/connection.php';
    if (isset($_POST['item'])){
        $sku    = $_POST['sku'];
        $qty    = $_POST['qty'];
        $qtyact = $_POST['qtyact'];
        $harga  = $_POST['harga'];
        $amt    = $_POST['amt'];
        $disc   = $_POST['disc'];
        $ppn    = $_POST['ppn'];
        $ttl    = $_POST['ttl'];
        $nco    = $_POST['nco'];
        $no_urut = $_POST['no_urut'];
        $nsco = $_POST['nsco'];
        $id = $_POST['item'];
        $keepstock = $_POST['keepstock'];

        if ($qty == $qtyact){
            $query = "INSERT INTO customerorder_dtl (No_Co, model, qty_request, qty_kirim, price, diskon, ppn, amount, harga_total, no_urut, keterangan, locator)
            VALUES ('$nco', '$sku', '$qty', '$qtyact', '$harga', '$disc', '$ppn', '$amt', '$ttl', '$no_urut', '', '$keepstock')";
            $mwk=$db1->prepare($query);
            $mwk->execute();
            $resl = $mwk->get_result();
            if ($resl->num_rows > 0 ){
                
                // echo 'COMPLETE';
            } else{
                $hapus = "DELETE FROM customerorder_dtl_pending WHERE id = '$id' AND noso = '$nsco'";
                $mwk = $db1->prepare($hapus);
                $mwk -> execute();
                $hasil = $mwk->get_result();
            }
        } else {
            $query = "INSERT INTO customerorder_dtl (No_Co, model, qty_request, qty_kirim, price, diskon, ppn, amount, harga_total, no_urut, keterangan, locator)
            VALUES ('$nco', '$sku', '$qty', '$qtyact', '$harga', '$disc', '$ppn', '$amt', '$ttl', '$no_urut', '', '$keepstock')";
            $mwk=$db1->prepare($query);
            $mwk->execute();
            $resl = $mwk->get_result();

            $sisa = $qty - $qtyact;
            if ($ppn != '0'){
                $boolppn = '1';
            } else {
                $boolppn = '0';
            }
            $querys = "UPDATE customerorder_dtl_pending  SET model = '$sku', qty_kirim = '$qtyact', qty_sisa = '$sisa', price = '$harga', diskon = '$disc', ppn = '$boolppn', no_urut = '$no_urut' WHERE id = '$id' AND noso = '$nsco'";
            $mwk=$db1->prepare($querys);
            $mwk->execute();
            $resl = $mwk->get_result();
            echo 'SISA';
        }
    }
    // } elseif(!isset($_POST['item'])) {
    //     $qty    = $_POST['qty'];
    //     $nsco    = $_POST['nsco'];
    //     $sku    = $_POST['sku'];
    //     $no_urut = $_POST['no_urut'];
    //     $disc   = $_POST['disc'];
    //     $harga  = $_POST['harga'];
    //     $ppn    = $_POST['ppn'];
    //     if ($ppn != '0'){
    //         $boolppn = '1';
    //     } else {
    //         $boolppn = '0';
    //     }

    //     $query = "INSERT INTO customerorder_dtl_pending (noso, model, qty_kirim, qty_sisa, price, diskon, ppn, no_urut)
    //     VALUES ('$nsco', '$sku', '0', '$qty','$harga', '$disc', '$boolppn' , '$no_urut')";
    //     $mwk=$db1->prepare($query);
    //     $mwk->execute();
    //     $resl = $mwk->get_result();
    //     echo 'SISA';
    // }
?>