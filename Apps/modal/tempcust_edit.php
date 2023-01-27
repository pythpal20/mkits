<?php
    // var_dump($_POST); die();
    include '../../config/connection.php';

    if (!isset($_POST['idRegis'])) {
        $idcust = $_POST['idcust'];
        $nama_customer = $_POST['nama_customer'];
        $kategori = $_POST['kategori'];
        $telp = $_POST['telp'];
        $nohp = $_POST['nohp'];
        $kab = $_POST['kab'];
        $pic = $_POST['pic'];
        $almtCustomer = $_POST['almtCustomer'];
        $sts = $_POST['sts'];

        $query = "UPDATE temp_customer SET customer_nama = '$nama_customer', detail_alamat ='$almtCustomer', pic= '$pic', notelp='$telp', nohp='$nohp', jenis_usaha= '$kategori', kota='$kab', status= '$sts' WHERE ID = '$idcust'";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $reslt = $mwk->get_result();
    } else {
        $idcust = $_POST['idcust'];
        $nama_customer = $_POST['nama_customer'];
        $kategori = $_POST['kategori'];
        $telp = $_POST['telp'];
        $nohp = $_POST['nohp'];
        $kab = $_POST['kab'];
        $pic = $_POST['pic'];
        $almtCustomer = $_POST['almtCustomer'];
        $idRegis = $_POST['idRegis'];
        $sts = $_POST['sts'];
        
        $query = "UPDATE temp_customer SET customer_idregister='$idRegis', customer_nama = '$nama_customer', detail_alamat ='$almtCustomer', pic= '$pic', notelp='$telp', nohp='$nohp', jenis_usaha= '$kategori', kota='$kab', status= '$sts' WHERE ID = '$idcust'";
        $mwk = $db1->prepare($query);
        $mwk->execute();
        $reslt = $mwk->get_result();
    }
?>