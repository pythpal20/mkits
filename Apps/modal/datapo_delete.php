<?php
	error_reporting();
	include '../../config/connection.php';
	$nopo = $_GET['id'];

	$query = "DELETE FROM salesorder_hdr WHERE noso = '$nopo'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
	if ($resl->num_rows > 0){
		echo "<script>alert('".$db1->error."'); window.location.href = '../datapo.php';</script>";
	} else {
		echo "<script>alert('Data sudah Dihapus'); window.location.href = '../datapo.php';</script>";
	}
?>