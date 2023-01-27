<?php 
	error_reporting(0);
	include '../../config/connection.php';
	// var_dump($_POST);
	$id = $_POST['id'];
	$dNow = date('Y-m-d');

	$query = "UPDATE master_fpp SET approvl ='1', tgl_aprove ='$dNow' WHERE fpp_id ='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
	if($resl->num_rows >0){
		echo 'Maaf, gagal';
	} else {
		echo 'Berhasil Aprove';
	}
?>