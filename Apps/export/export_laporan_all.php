<?php
include '../../config/connection.php';
$awal = $_POST['tglawal'];
$akhir = $_POST['tglakhir'];
// var_dump($_POST);die();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Laporan MKITS '.$awal.' to '.$akhir.'.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array(
    'Tgl.PO', 'NO. SO', 'No. CO', 'Status CO', 'No Ref PO', 'Jenis Transaksi', 'ID Register Customer', 'Nama Customer', 'Kota',
    'Status Customer', 'SKU', 'Qty. SCO', 'Harga', 'Diskon (SCO)', 'PPN (SCO)', 'Amount (SCO)', 'Harga Total (SCO)',
    'Qty. Request (CO)', 'Qty. Kirim (CO)', 'Qty. Request (Delivery)', 'Qty. Kirim (Delivery)', 'Qty. Sisa Diterima (Delivery)', 'Qty Pending'
));

$query = "SELECT
	a.tgl_po,
	a.noso,
	b.No_Co,
	REPLACE(REPLACE(REPLACE(b.status, '0', 'AWAL'), '1', 'DIPROSES'), '2', 'CANCEL') AS status_co,
	a.noso_ref,
	a.jenis_transaksi,
	ab.customer_idregister,
	ab.customer_nama,
	ac.wilayah_nama,
	ab.status,
	c.model,
	c.qty AS QTY_SCO,
	c.price AS harga_SCO,
	c.diskon AS diskon_SCO,
	c.ppn AS PPN_SCO,
	c.amount AS amount_SCO,
	c.harga_total,
	(SELECT SUM(qty_request) FROM customerorder_dtl WHERE No_Co = b.No_Co AND model = c.model) AS QTY_REQUEST_CO,
	(SELECT SUM(qty_kirim) FROM customerorder_dtl WHERE No_Co = b.No_Co AND model = c.model) AS QTY_KRM_CO,
	(SELECT SUM(qty_request) FROM customerorder_dtl_delivery WHERE No_Co = b.No_Co AND model = c.model) AS QTY_REQ_DELIVERY,
	(SELECT SUM(qty_kirim) FROM customerorder_dtl_delivery WHERE No_Co = b.No_Co AND model = c.model) AS QTY_KRM_DELIVERY,
	(SELECT SUM(qty_sisa_diterima) FROM customerorder_dtl_delivery WHERE No_Co = b.No_Co AND model = c.model) AS Qty_sisa_diterima,
	(SELECT SUM(qty_sisa) FROM customerorder_dtl_pending WHERE noso = a.noso AND model = c.model) AS Pending
FROM salesorder_hdr a 
LEFT JOIN customerorder_hdr b ON a.noso = b.noso
JOIN master_customer ab ON a.customer_id = ab.customer_id
JOIN master_wilayah ac ON ab.customer_kota = ac.wilayah_id
JOIN salesorder_dtl c ON a.noso =c.noso
WHERE `a`.`tgl_po` BETWEEN '$awal' AND '$akhir'
ORDER BY `a`.`tgl_po` DESC";
$mwk = $db1->prepare($query);
$mwk->execute();
$reslt = $mwk->get_result();

while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);