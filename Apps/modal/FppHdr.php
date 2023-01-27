<?php
	error_reporting(0);
	include '../../config/connection.php';
	// var_dump($_POST);
	$tglNow = date('ymd');
	$query 	= "SELECT MAX(kode) AS idArr 
	FROM (SELECT CAST(urutan AS INT) AS kode FROM (SELECT SUBSTRING(fpp_id, 11, 11) AS urutan FROM master_fpp) AS tabel_a) AS table_b";
	$mwk 	= $db1->prepare($query);
	$mwk->execute();
	$res1 	= $mwk->get_result();
	while ($sb 	= $res1->fetch_assoc()) {
		$urutan = $sb['idArr'];
		$urutan = $urutan+1;
		$huruf 	= "FPP";
		$fppId 	= $huruf . $tglNow ."-". sprintf("%03s", $urutan);
	}

	$idFPP 		= $fppId;
	$noso 		= $_POST['noso'];
	$customer 	= $_POST['cs'];
	$tglPo		= $_POST['tglpo'];
	$tglKrm		= $_POST['tglkrm'];
	$tglFpp		= $_POST['tglfpp'];
	$uinput 	= $_POST['uinput'];

	$a1	= $_POST['als1'];
	$a2	= $_POST['als2'];
	$a3	= $_POST['als3'];
	$a4	= $_POST['als4'];
	$a5	= $_POST['als5'];
	$a6	= $_POST['als6'];
	$a7	= $_POST['als7'];
	$al	= $_POST['als_ln'];

	$p1	= $_POST['pros1'];
	$p2	= $_POST['pros2'];
	$p3	= $_POST['pros3'];
	$p4	= $_POST['pros4'];
	$p5	= $_POST['pros5'];
	$pl	= $_POST['pros_ln'];
	$catatan = $_POST['catatan'];

	$query = "INSERT INTO master_fpp (fpp_id, noso, customer_id, tgl_po, tgl_krm, fpp_tanggal, alasan1, alasan2, alasan3, alasan4, alasan5, alasan6, alasan7, alasan_lain, proses1, proses2, proses3, proses4, proses5, proses_lain, inputby, catatan) VALUES ('$idFPP', '$noso', '$customer', '$tglPo', '$tglKrm', '$tglFpp', '$a1', '$a2', '$a3', '$a4', '$a5', '$a6', '$a7', '$al', '$p1', '$p2', '$p3', '$p4', '$p5', '$pl', '$uinput', '$catatan')";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$relst = $mwk->get_result();

	echo $idFPP;
?>