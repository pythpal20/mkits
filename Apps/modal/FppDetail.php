<?php
	include '../../config/connection.php';
	if(isset($_POST['item'])) {
		// var_dump($_POST);
		$item 	= $_POST['item'];
		$sku 	= $_POST['sku'];
		$qty 	= $_POST['qty'];
		$ket 	= $_POST['ket'];
		$tgl 	= $_POST['tgl'];
		$idFpp 	= $_POST['idFpp'];
		$no_urut= $_POST['no_urut'];

		$query = "INSERT INTO fpp_detail (id, fpp_id, fpp_tanggal, model, qty, keterangan, no_urut) VALUES ('', '$idFpp', '$tgl', '$sku', '$qty', '$ket', '$no_urut')";
		$mwk = $db1->prepare($query);
		$mwk -> execute();
		$resl = $mwk->get_result();
	}
?>