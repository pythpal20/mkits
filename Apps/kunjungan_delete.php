<?php
	error_reporting(0);
	include '../config/connection.php';
	$id = $_GET['id'];
	//-----------------------//
	$query = "DELETE FROM master_kunjungan WHERE id_followup = '$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$reslt = $mwk->get_result();
	if($reslt->num_rows>0){
		echo "<script>alert('".$db1->error."'); window.location.href = './kunjungan.php';</script>";
	} else {
		echo "<script>alert('Data sudah Dihapus'); window.location.href = './kunjungan.php';</script>";
	}
?>