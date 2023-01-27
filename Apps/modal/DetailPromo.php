<?php
if (isset($_POST['sku']) && isset($_POST['hargadasar'])) {
    // var_dump($_POST);die();
    include '../../config/connection.php';

    $sku = $_POST['sku'];
    $hargadasar = $_POST['hargadasar'];
    $diskon_persen = $_POST['diskon_persen'];
    $nom_disc = $_POST['nom_disc'];
    $harga_diskon = $_POST['harga_diskon'];
    $promo_id = $_POST['promo_id'];
    $no_urut = $_POST['no_urut'];
    $qty = $_POST['promo_qty'];

    $kueri = "INSERT INTO bundle_promo_dtl (int_id, promo_id, model, harga_default, disc_percent, diskon, harga_promo, promo_qty, norut)
        VALUES ('', '$promo_id', '$sku', '$hargadasar', '$diskon_persen', '$nom_disc', '$harga_diskon', '$qty', '$no_urut')";
    $pcs = $db1->prepare($kueri);
    $pcs->execute();
    $resl = $pcs->get_result();
}