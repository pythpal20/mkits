<?php 
$id = $_GET['id'];
include '../../../config/connection.php';
$row = array();
$query = "SELECT 
d.tgl_inv,
d.no_fa AS nofa_awal,
a.noso,
a.No_Co,
c.customer_nama,
d.sales,      
(SELECT SUM(e.harga_total) FROM customerorder_dtl e WHERE e.No_co = a.No_Co)  AS nominal_awal,
(SELECT SUM(b.harga_total) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)  AS nominal_akhir,
a.tgl_delivery,    
f.tgl_kontrabon,    
f.tgl_duedate, 
IFNULL(((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(ROUND(b.harga_total)) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)), 'belum bayar') AS selisih,
(SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco) AS total_bayar,  
DATEDIFF( NOW(), f.tgl_duedate ) AS overdue,  
a.no_fa AS nofa_akhir
FROM customerorder_hdr_delivery a
JOIN customerorder_dtl_delivery b ON a.No_Co = b.No_Co
JOIN customerorder_dtl e ON a.No_Co = e.No_Co
JOIN master_customer c ON a.customer_id = c.customer_id
JOIN customerorder_hdr d ON a.No_Co = d.No_Co
LEFT JOIN kontrabon f ON a.No_Co = f.noco
LEFT JOIN detail_penagihan g ON a.No_Co =g.noco
WHERE d.id_perusahaan = '$id' AND (((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(ROUND(b.harga_total)) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)) IS NULL OR ((SELECT SUM(g.nominal) FROM detail_penagihan g WHERE a.No_co = g.noco)-(SELECT SUM(ROUND(b.harga_total)) FROM customerorder_dtl_delivery b WHERE b.No_co = a.No_Co)) < '0')
GROUP BY b.No_Co";
$mwk = $db1->prepare($query);
$mwk->execute();
$hasil = $mwk->get_result();
while($r = $hasil->fetch_assoc()){
    $row[] = $r;
}
print json_encode($row);