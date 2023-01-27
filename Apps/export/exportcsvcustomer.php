<?php
	include '../../config/connection.php';
	$kategori = $_POST['kategori'];
	$kota = $_POST['kota'];

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Customer '. $kategori .' '. $kota .'.csv');

	// BOM header UTF-8
	// echo "\xEF\xBB\xBF";

	$output = fopen('php://output', 'w');
	fputcsv($output, array('Nama Konsumen', 'ID Register', 'Kategori', 'TERM', 'Payment Method', 'Alamat', 'Kecamatan','Kota', 'Provinsi', 'No. Telp', 'No. HP', 'PIC', 'Alamat PIC','No. Hp (PIC)', 'Status', 'Sales', 'Input By'));

	$fkategori = '%' . $kategori . '%';
	$fkota = '%' . $kota . '%';
	$query = "SELECT ms.customer_nama, ms.customer_idregister, ms.customer_kategori, term, method, ms.customer_alamat, kc.wilayah_nama AS kecamatan, mw.wilayah_nama AS kota, a.wilayah_nama as prov, ms.customer_telp, ms.customer_nohp, ms.pic_nama, ms.pic_alamat, ms.pic_kontak, ms.status, m.user_nama, ms.input_by FROM master_customer ms JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id JOIN master_wilayah a ON ms.customer_provinsi = a.wilayah_id LEFT JOIN master_wilayah kc ON ms.customer_kecamatan = kc.wilayah_id LEFT JOIN master_user m ON ms.customer_sales = m.user_id
	WHERE ms.customer_kategori LIKE ? AND ms.customer_kota LIKE ? ORDER BY customer_nama ASC";
	$mwk = $db1->prepare($query);
	$mwk->bind_param('ss', $fkategori, $fkota);
	$mwk->execute();
	$reslt = $mwk->get_result();

	while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
?>