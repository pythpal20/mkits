<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
include '../../config/connection.php';
// var_dump($_POST);
// die();
$id = $_POST['id'];

if (isset($_POST['pengguna'])) {
	$pengguna = $_POST['pengguna'];
	$tanggal = date('Y-m-d H:i:s');
	$query = "UPDATE salesorder_hdr SET status ='1', sco_aprovalby = '$pengguna', sco_aprovaldate = '$tanggal' WHERE noso ='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
	if ($resl->num_rows > 0) {
		echo 'Maaf, gagal';
	} else {
		echo 'PO diproses';
	}
} else {
	$query = "UPDATE salesorder_hdr SET status ='1' WHERE noso ='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
	if ($resl->num_rows > 0) {
		echo 'Maaf, gagal';
	} else {
		echo 'PO diproses';
	}
}
