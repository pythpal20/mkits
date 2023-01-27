<?php
	include '../../config/connection.php';
	$awal = $_POST['tglawal'];
	$akhir = $_POST['tglakhir'];
	$perusahaan = $_POST['perusahaan'];

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Data CO '. $awal .' s/d '. $akhir .'.csv');

	// BOM header UTF-8
	// echo "\xEF\xBB\xBF";
	
		$output = fopen('php://output', 'w');
		fputcsv($output, array('No. SJ', 'No. Faktur', 'Tgl. Invoice', 'No. SO', 'No. CO','Customer', 'ID Register Customer', 'Kota', 'Metode Pembayaran','SKU', 'Qty.', 'Price', 'Amount', 'Diskon.', 'PPN 10%', 'Ongkos Kirim', 'Sales', 'PT.', 'Alasan', 'Oleh', 'Status CO' , 'Tgl. Kirim', 'Tgl. Create'));

        $idPT = '%' . $perusahaan . '%';
		$query = "SELECT a.no_bl, 
						 a.no_fa,
						 a.tgl_inv,
						 a.noso, 
						 a.No_Co,
						 c.customer_nama, 
						 c.customer_idregister,
						 e.wilayah_nama, 
						 f.term, b.model, 
						 b.qty_kirim, 
						 b.price, 
						 b.amount, 
						 b.diskon, 
						 b.ppn, 
						 a.ongkir, 
						 a.sales, 
						 d.atasnama, 
						 a.alasan_cancelpo, 
						 a.cancelpo_by, 
						 REPLACE(REPLACE(a.status, '1', 'AKTIF'), '2', 'CANCEL'),
						 a.tgl_krm,
						 a.tgl_create
        FROM customerorder_hdr a
        JOIN customerorder_dtl b ON a.No_Co = b.No_Co
        JOIN master_customer c ON a.customer_id = c.customer_id
        JOIN list_perusahaan d ON a.id_perusahaan = d.id_perusahaan
        JOIN master_wilayah e ON c.customer_kota = e.wilayah_id
        JOIN salesorder_hdr f ON a.noso = f.noso
		WHERE a.tgl_create BETWEEN '$awal' AND '$akhir'
		AND a.id_perusahaan LIKE '$idPT'
		ORDER BY a.tgl_inv DESC";
		$mwk = $db1->prepare($query);
		$mwk->execute();
		$reslt = $mwk->get_result();

		while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
	
?>