<?php
	include '../config/connection.php';
	var_dump($_POST);
	$nopo = $_POST['nopo'];
	$customer = $_POST['customer'];
	$tanggal = $_POST['tanggal'];
	$top = $_POST['top'];
	$tglkirim = $_POST['tglkirim'];
	$alamat_kirim = $_POST['alamatKirim'];
	$perusahaan = $_POST['jenisPerusahaan'];
	$nopo_ref = $_POST['nopo_ref'];
	$sales = $_POST['sales'];
	$ongkir = $_POST['ongkir'];
	$keterangan = $_POST['keterangan'];
	$method = $_POST['method'];

	$query = "UPDATE salesorder_hdr SET customer_id = '$customer', tgl_po = '$tanggal', term = '$top', tgl_krm = '$tglkirim', alamat_krm = '$alamat_kirim', id_perusahaan = '$perusahaan', noso_ref = '$nopo_ref', sales = '$sales', ongkir = '$ongkir', keterangan = '$keterangan', method = '$method' WHERE noso = '$nopo'";
	$mwk = $db1->prepare($query);
	$mwk -> execute();
	$resl = $mwk->get_result();
?>