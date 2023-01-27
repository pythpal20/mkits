<?php
	include '../../config/connection.php';
	$awal = $_POST['tglawal'];
	$akhir = $_POST['tglakhir'];
	$status = $_POST['status'];
	$kategori = $_POST['kategori'];

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Data PO '. $awal .' s/d '. $akhir .'.csv');

	// BOM header UTF-8
	// echo "\xEF\xBB\xBF";
	if($kategori == 'all') {
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Tanggal PO', 'Tanggal Kirim', 'No. So', 'No. PO Referensi', 'Jenis Transaksi', 'ID Reg. Customer', 'Customer', 'Kota', 'Status', 'SKU', 'Qty.', 'Price', 'Amount', 'Diskon (Rp.)', 'PPN 10% (Rp.)', 'Ongkos Kirim', 'Harga Total', 'Sales', 'TOP', 'PT. ', 'Status', 'Promo', 'Keterangan', 'Alasan Cancel', 'Oleh'));

		$stat = '%' . $status . '%';
		$query = "SELECT sh.tgl_po, sh.tgl_krm, sh.noso, sh.noso_ref, sh.jenis_transaksi, ms.customer_idregister, ms.customer_nama, mw.wilayah_nama, ms.status, sd.model, sd.qty, sd.price, sd.amount, sd.diskon, sd.ppn, sh.ongkir,sd.harga_total, sh.sales, sh.term,lp.atasnama, REPLACE(REPLACE(sh.status, '1', 'DIPROSES'), '2', 'CANCEL'), sd.promo_id, sd.keterangan, sh.alasan_cancelsco, sh.cancelsco_by
		FROM salesorder_hdr sh
		LEFT JOIN salesorder_dtl sd ON sh.noso = sd.noso
		JOIN master_customer ms ON sh.customer_id = ms.customer_id
		JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan
		JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id 
		WHERE sh.tgl_po BETWEEN '$awal' AND '$akhir'
		AND sh.status LIKE '$stat'
		ORDER BY sh.tgl_po DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	} elseif ($kategori == 'salesmarketing') {
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Tanggal PO', 'Tglo Krm', 'No. So', 'No. PO Referensi', 'Jenis Transaksi', 'ID Reg. Customer', 'Customer', 'Kota', 'Status', 'SKU', 'Qty.', 'Price', 'Amount', 'Diskon (Rp.)', 'PPN 10% (Rp.)', 'Ongkos Kirim', 'Harga Total', 'Sales', 'TOP', 'PT. ', 'Status','Promo', 'Keterangan', 'Alasan Cancel', 'Oleh'));

		$stat = '%' . $status . '%';
		$query = "SELECT sh.tgl_po, sh.tgl_krm, sh.noso, sh.noso_ref, sh.jenis_transaksi, ms.customer_idregister, ms.customer_nama, mw.wilayah_nama, ms.status, sd.model, sd.qty, sd.price, sd.amount, sd.diskon, sd.ppn, sh.ongkir,sd.harga_total, sh.sales, sh.term,lp.atasnama, REPLACE(REPLACE(sh.status, '1', 'DIPROSES'), '2', 'CANCEL'), sd.promo_id, sd.keterangan, sh.alasan_cancelsco, sh.cancelsco_by
		FROM salesorder_hdr sh
		JOIN salesorder_dtl sd ON sh.noso = sd.noso
		JOIN master_customer ms ON sh.customer_id = ms.customer_id
		JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan
		JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id 
		WHERE sh.jenis_transaksi != 'MARKETPLACE' AND sh.jenis_transaksi != 'SHOWROOM' AND sh.tgl_po BETWEEN '$awal' AND '$akhir'
		AND sh.status LIKE '$stat'
		ORDER BY sh.tgl_po DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	} elseif ($kategori == 'marketplace') {
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Tanggal PO', 'No. So', 'No. PO Referensi', 'Jenis Transaksi', 'ID Reg. Customer', 'Customer', 'Alamat', 'Status', 'SKU', 'Qty.', 'Price', 'Amount', 'Diskon (Rp.)', 'PPN 10% (Rp.)', 'Ongkos Kirim', 'Harga Total', 'Sales', 'TOP', 'PT. ', 'Status', 'Keterangan', 'Alasan Cancel', 'Oleh'));

		$stat = '%' . $status . '%';
		$query = "SELECT sh.tgl_po, sh.noso, sh.noso_ref, sh.jenis_transaksi, ms.customer_idregister, ms.customer_nama, alamat_krm, ms.status, sd.model, sd.qty, sd.price, sd.amount, sd.diskon, sd.ppn, sh.ongkir,sd.harga_total, sh.sales, sh.term,lp.atasnama, REPLACE(REPLACE(sh.status, '1', 'DIPROSES'), '2', 'CANCEL'), sd.keterangan, sh.alasan_cancelsco, sh.cancelsco_by
		FROM salesorder_hdr sh
		JOIN salesorder_dtl sd ON sh.noso = sd.noso
		JOIN master_customer ms ON sh.customer_id = ms.customer_id
		JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan
		JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id 
		WHERE sh.jenis_transaksi = 'MARKETPLACE' AND sh.tgl_po BETWEEN '$awal' AND '$akhir'
		AND sh.status LIKE '$stat'
		ORDER BY sh.tgl_po DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	} elseif($kategori == 'showroom') {
		$output = fopen('php://output', 'w');
		fputcsv($output, array('Tanggal PO', 'No. So', 'No. PO Referensi', 'Jenis Transaksi', 'ID Reg. Customer', 'Customer', 'Alamat', 'Status', 'SKU', 'Qty.', 'Price', 'Amount', 'Diskon (Rp.)', 'PPN 10% (Rp.)', 'Ongkos Kirim', 'Harga Total', 'Sales', 'TOP', 'PT. ', 'Status', 'Keterangan', 'Alasan Cancel', 'Oleh'));

		$stat = '%' . $status . '%';
		$query = "SELECT sh.tgl_po, sh.noso, sh.noso_ref, sh.jenis_transaksi, ms.customer_idregister, ms.customer_nama, alamat_krm, ms.status, sd.model, sd.qty, sd.price, sd.amount, sd.diskon, sd.ppn, sh.ongkir,sd.harga_total, sh.sales, sh.term,lp.atasnama, REPLACE(REPLACE(sh.status, '1', 'DIPROSES'), '2', 'CANCEL'), sd.keterangan, sh.alasan_cancelsco, sh.cancelsco_by
		FROM salesorder_hdr sh
		JOIN salesorder_dtl sd ON sh.noso = sd.noso
		JOIN master_customer ms ON sh.customer_id = ms.customer_id
		JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan
		JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id 
		WHERE sh.jenis_transaksi = 'SHOWROOM' AND sh.tgl_po BETWEEN '$awal' AND '$akhir'
		AND sh.status LIKE '$stat'
		ORDER BY sh.tgl_po DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	}
?>