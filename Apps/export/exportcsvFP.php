<?php
include '../../config/connection.php';
$awal = $_POST['tglawal'];
$akhir = $_POST['tglakhir'];
$status = $_POST['status'];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Data PO ' . $awal . ' s/d ' . $akhir . '.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Tanggal PO', 'No. So', 'No. PO Referensi', 'Jenis Transaksi', 'ID Reg. Customer', 'Customer', 'Kota', 'Status', 'SKU', 'Qty.', 'Price', 'Amount', 'Diskon (Rp.)', 'PPN 10% (Rp.)', 'Ongkos Kirim', 'Harga Total', 'Sales', 'TOP', 'PT. ', 'Status', 'Keterangan', 'Alasan Cancel', 'Oleh'));

$stat = '%' . $status . '%';
$query = "SELECT sh.tgl_po, sh.noso, sh.noso_ref, sh.jenis_transaksi, ms.customer_idregister, ms.customer_nama, mw.wilayah_nama, ms.status, sd.model, sd.qty, sd.price, sd.amount, sd.diskon, sd.ppn, sh.ongkir,sd.harga_total, sh.sales, sh.term,lp.atasnama, REPLACE(REPLACE(sh.status, '1', 'DIPROSES'), '2', 'CANCEL'), sd.keterangan, sh.alasan_cancelsco, sh.cancelsco_by
		FROM salesorder_hdr sh
		LEFT JOIN salesorder_dtl sd ON sh.noso = sd.noso
		JOIN master_customer ms ON sh.customer_id = ms.customer_id
		JOIN list_perusahaan lp ON sh.id_perusahaan = lp.id_perusahaan
		JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id 
		JOIN master_user mu ON sh.sales = mu.user_nama
		WHERE sh.tgl_po BETWEEN '$awal' AND '$akhir' AND mu.company = 'Foodpack'
		AND sh.status LIKE '$stat'
		ORDER BY sh.tgl_po DESC";
$mwk = $db1->prepare($query);
$mwk->execute();
$reslt = $mwk->get_result();

while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);