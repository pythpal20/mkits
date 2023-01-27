<?php
    // var_dump($_POST);

use LDAP\Result;

    include '../../config/connection.php';
    $idRegis = $_POST['idRegis'];
    $nama_customer = $_POST['nama_customer'];
    $kategori = $_POST['kategori'];
    $telp = $_POST['telp'];
    $nohp = $_POST['nohp'];
    $prov = $_POST['prov'];
    $kab = $_POST['kab'];
    $pic = $_POST['pic'];
    $almtCustomer = $_POST['almtCustomer'];

    $query = "INSERT INTO temp_customer (customer_idregister, customer_nama, detail_alamat, pic, notelp, nohp, jenis_usaha, kota)
    VALUES ('$idRegis', '$nama_customer', '$almtCustomer', '$pic', '$telp', '$nohp', '$kategori', '$kab')";
    $mwk = $db1->prepare($query);
    $mwk -> execute();
    $resl = $mwk->get_result();
?>