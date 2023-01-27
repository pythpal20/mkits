<?php 
	error_reporting(0);
	include '../../config/connection.php';
	// var_dump($_POST);
	$id = $_POST['id'];

	$query = "UPDATE salesorder_hdr SET status ='2' WHERE noso ='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
	if($resl->num_rows >0){
		echo 'Maaf, gagal';
	} else {
		echo 'PO sudah di CANCEL';
	}
?>