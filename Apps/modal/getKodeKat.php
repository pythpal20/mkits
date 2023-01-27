<?php
	include '../../config/connection.php';
	$id = $_POST['idKat'];

	$ambil_kode ="SELECT * FROM master_kategori WHERE kategori_nama = '$id' " ;
	$hasil_kode = mysqli_query($connect, $ambil_kode);
	$html=[];
	while ($row = mysqli_fetch_array($hasil_kode)) {
	    array_push($html, $row['kategori_code']);
	}
	echo json_encode($html) ;
?>