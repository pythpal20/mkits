<?php 
	error_reporting(0);
	include '../config/connection.php';
	// var_dump($_POST);
	$sku = $_POST['model'];
	$barcode=$_POST['barcode'];
	$kat=$_POST['kat'];
	$desk=$_POST['desk'];
	$hrg=$_POST['hrg'];

	$cek = "SELECT * FROM master_produk WHERE model='$sku' AND barcode = '$barcode'";
	$mwk = $db1->prepare($cek);
	$mwk->execute();
	$hasil_cek = $mwk->get_result();
	if ($hasil_cek->num_rows > 0){
		echo 'Maaf SKU ini sudah ada!';
	} else {
		$query = "INSERT INTO master_produk (id, model, barcode, kategori, deskripsi, harga) VALUES ('', '$sku', '$barcode', '$kat', '$desk', '$hrg')";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$resl = $mwk->get_result();
		if ($resl->num_rows > 0){
			echo 'Sorry! Gagal insert Data';
		} else {
			echo 'Good! Insert Data Berhasil';
		}
	}
?>