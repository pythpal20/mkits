<?php
	include '../../config/connection.php';
	$id = $_POST['idKab'];

	$ambil_kode ="SELECT * FROM master_wilayah WHERE wilayah_id = '$id' " ;
	$hasil_kode = mysqli_query($connect, $ambil_kode);
	$html=[];
	while ($row = mysqli_fetch_array($hasil_kode)) {
	    array_push($html, $row['wilayah_code']);
	}
	echo json_encode($html) ;
?>