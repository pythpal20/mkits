<?php
include '../config/connection.php';

$query = mysqli_query(
    $connect,
    "SELECT 
	SUBSTR(a.no_bl,5) as no_bl,
	h.noso,
	g.atasnama as nama_pt,
	c.customer_nama, 
	h.sales,
	h.aproval_by,
	h.aproval_date,
	h.tgl_po,
	c.issuedby,
	c.tgl_create,
	a.kenek,
	a.sopir,
    b.tgl_delivery,
	IFNULL(((SELECT SUM(f.nominal) FROM detail_penagihan f WHERE c.No_Co = f.noco) -(SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE c.No_Co = b.No_Co)), 'Belum Bayar') AS selisih
FROM customerorder_hdr_delivery a
JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
JOIN customerorder_hdr c ON a.No_Co = c.No_Co
JOIN customerorder_dtl d ON a.No_Co = d.No_Co
LEFT JOIN kontrabon e ON a.No_Co = e.noco
LEFT JOIN detail_penagihan f ON a.No_Co = f.noco
JOIN list_perusahaan g ON c.id_perusahaan = g.id_perusahaan
JOIN salesorder_hdr h ON c.noso = h.noso
GROUP BY b.No_Co, b.tgl_delivery
ORDER BY `selisih` ASC"
);

$data = array();
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}
echo json_encode($data);