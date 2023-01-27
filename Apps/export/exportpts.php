<?php
	include '../../config/connection.php';
	$awal = $_POST['tglawal'];
	$akhir = $_POST['tglakhir'];
	$status = $_POST['status'];

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Data PTS '. $awal .' s/d '. $akhir .'.csv');

	// BOM header UTF-8
	// echo "\xEF\xBB\xBF";
	
		$output = fopen('php://output', 'w');
		fputcsv($output, array('ID', 'Tgl. Request', 'Status', 'Tgl. Diambil', 'Tgl.Kembali', 'Ket. Pembelian', 'Customer','Alamat', 'Kota', 'SKU','Qty.', 'Harga', 'Amount', 'Sales', 'Keterangan'));

        $sts = '%' . $status . '%';
		$query = "SELECT a.idPts, a.tgl_create, REPLACE(REPLACE(REPLACE(a.status,'1','Kembali'),'2','Tidak Kembali'),'3', 'Dibeli') AS statuss, a.tgl_ambil, a.tgl_kembali,
		a.keterangan_beli, a.customer_nama, a.alamat, a.kota, b.model, b.qty, b.harga, b.amount, a.sales, a.keterangan
        FROM pts_header a
        JOIN pts_detail b ON a.idPts = b.idPts
        WHERE a.status LIKE '$sts' AND app_admin = '1' AND app_akunting = '1' AND a.tgl_create BETWEEN '$awal' AND '$akhir'
		ORDER BY a.idPts DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	
?>