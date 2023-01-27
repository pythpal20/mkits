<?php 
    include '../config/connection.php';
    // var_dump($_POST);die();

    $itemid         = $_POST['itemid'];
    $sku            = $_POST['sku'];
    $qty_save       = $_POST['qty_save'];
    $qty            = $_POST['qty'];
    $harga          = $_POST['harga'];
    $amt            = $_POST['amt'];
    $disc           = $_POST['disc'];
    $hitungan_ppn   = $_POST['hitungan_ppn'];
    $ttl            = $_POST['ttl'];
    $noco           = $_POST['NoCo'];
    $noso           = $_POST['noso'];
    $urt            = $_POST['urt'];
    $xsia = $qty_save-$qty;
    $revs           = $_POST['revs'];

    if ($_POST['qty_save'] - $_POST['qty'] == '0'){
        $query = "UPDATE customerorder_dtl SET price = '$harga', diskon = '$disc', ppn='$hitungan_ppn', amount= '$amt', harga_total='$ttl', revisi='$revs' WHERE No_Co = '$noco' AND id = '$itemid'";
        $mwk = $db1->prepare($query);
        $mwk -> execute(); 
        $resl = $mwk->get_result();
                                                               
    } elseif($_POST['qty_save'] - $_POST['qty'] != '0'){
       
        $query2 = "UPDATE customerorder_dtl SET qty_request='$qty', qty_kirim='$qty', price='$harga', diskon='$disc', ppn='$hitungan_ppn', amount='$amt', harga_total='$ttl', revisi='$revs' WHERE No_Co='$noco' AND id='$itemid'";
        $upd = $db1 -> prepare($query2);
	    $upd -> execute(); 
	    $resl = $upd -> get_result();
        
        // cekpendingan
        $sisa = $qty_save-$qty;
        if ($hitungan_ppn != '0'){
            $boolppn = '1';
        } else {
            $boolppn = '0';
        }
        $sql = "SELECT * FROM customerorder_dtl_pending WHERE noso = '$noso' AND model = '$sku'";
        $mwk = $db1->prepare($sql);
        $mwk->execute();
        $hasil = $mwk->get_result();
        $dbx = $hasil->fetch_assoc();
        $sis = $dbx['qty_sisa'];
        $krmx = $dbx['qty_kirim'];
        $skrm = $krmx-$sisa;
        $upd = $sis + $sisa;

        if ($hasil->num_rows > 0) {
            $qry = "UPDATE customerorder_dtl_pending SET qty_kirim ='$skrm', qty_sisa = '$upd', price ='$harga', ppn='$boolppn' WHERE noso = '$noso' AND model = '$sku'";
            $mwk = $db1->prepare($qry);
            $mwk -> execute();
            $hsl = $mwk->get_result();
        } else {
            $qry = "INSERT INTO customerorder_dtl_pending (noso, model, qty_kirim, qty_sisa, price, diskon, ppn, no_urut) VALUES ('$noso', '$sku', '$qty', '$sisa', '$harga', '$disc', '$boolppn', '$urt')";
            $mwk = $db1->prepare($qry);
            $mwk -> execute();
            $hsl = $mwk->get_result();

            echo 'SISA';
        }
    } else {
        $query = "UPDATE customerorder_dtl SET price = '$harga', diskon = '$disc', ppn='$hitungan_ppn', amount= '$amt', harga_total='$ttl' WHERE No_Co = '$noco' AND id = '$itemid'";
        $mwk = $db1->prepare($query);
        $mwk -> execute();
        $resl = $mwk->get_result();

    }
?>